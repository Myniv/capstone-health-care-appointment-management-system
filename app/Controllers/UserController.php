<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\DataParams;
use App\Models\AppointmentModel;
use App\Models\DoctorCategoryModel;
use App\Models\DoctorModel;
use App\Models\EducationModel;
use App\Models\PatientModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Roles;
use Myth\Auth\Models\GroupModel;

class UserController extends BaseController
{
    protected $userModel;
    protected $groupModel;
    protected $patientModel;
    protected $doctorModel;
    protected $doctorCategoryModel;
    protected $appointmentModel;
    protected $educationModel;
    protected $config;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->groupModel = new GroupModel();
        $this->patientModel = new PatientModel();
        $this->doctorModel = new DoctorModel();
        $this->doctorCategoryModel = new DoctorCategoryModel();
        $this->educationModel = new EducationModel();
        $this->appointmentModel = new AppointmentModel();

        $this->config = config('Auth');
        helper('auth');

        if (!in_groups('administrator')) {
            return redirect()->to('/');
        }
    }

    public function index()
    {
        $params = new DataParams([
            "search" => $this->request->getGet("search"),

            "role" => $this->request->getGet("role"),

            "sort" => $this->request->getGet("sort"),
            "order" => $this->request->getGet("order"),
            "perPage" => $this->request->getGet("perPage"),
            "page" => $this->request->getGet("page_users"),
        ]);

        $result = $this->userModel->getFilteredUser($params);

        $data = [
            'users' => $result['users'],
            'pager' => $result['pager'],
            'total' => $result['total'],
            'groups' => $this->groupModel->findAll(),
            'params' => $params,
            'baseUrl' => base_url('admin/users'),
        ];

        if (!cache()->get("user-list")) {
            cache()->save("user-list", $data['users'], 3600);
        }

        return view('page/user/v_user_list', $data);
    }

    public function dashboard()
    {
        $users = $this->userModel->countAllResults();
        $doctors = $this->doctorModel->countAllResults();
        $patients = $this->patientModel->countAllResults();

        $appointmentChartData = $this->getAppointmentPerDay();
        $patientDistributionChartData = $this->getPatientDistributionByDoctorCategory();

        $data = [
            'title' => 'Dashboard Admin',
            'users' => $users,
            'doctors' => $doctors,
            'patients' => $patients,
            'appointmentChartData' => $appointmentChartData,
            'patientDistributionChartData' => $patientDistributionChartData
        ];

        return view('page/user/v_user_dashboard_admin', $data);
    }

    public function profile($id)
    {
        $user = $this->userModel->getUserWithFullName($id);
        $educations = $this->educationModel->where('doctor_id', $user->doctor_id)->findAll();

        $data = [
            'title' => 'Profile',
            'user' => $user,
            'educations' => $educations
        ];

        return view('page/user/v_user_profile', $data);
    }

    public function profilePicture()
    {
        $path = $this->request->getGet('path');

        // Sanitasi path untuk mencegah traversal direktori
        $path = ltrim($path, '/');
        $path = str_replace(['../', './'], '', $path);

        // Tentukan file path lengkap
        $filePath = WRITEPATH . $path;

        // Periksa apakah path menunjuk ke file
        if (!is_file($filePath)) {
            return $this->response->setStatusCode(404, 'File Not Found')->setBody("File not found or not a valid file: $filePath");
        }

        // Kembalikan file dengan MIME type yang sesuai
        return $this->response
            ->setContentType(mime_content_type($filePath))
            ->setBody(file_get_contents($filePath));
    }

    public function createPatient()
    {
        $type = $this->request->getMethod();
        if ($type == "GET") {
            return view('page/user/v_user_patient_form');
        }
        $validation = \Config\Services::validation();
        $validation->setRules([
            'username' => 'required|min_length[3]|max_length[255]|is_unique[users.username]',
            'email' => 'required|valid_email|max_length[150]|is_unique[users.email]',
            'password' => 'required|min_length[8]',
            'first_name' => 'required|min_length[2]|max_length[100]',
            'last_name' => 'required|min_length[2]|max_length[100]',
            'phone' => 'required|regex_match[/^[0-9\-\+\s\(\)]+$/]',
            'address' => 'required|max_length[500]',
            'sex' => 'required|in_list[male,female]',
            'dob' => 'required|valid_date',
            'patient_type' => 'required',
            'profile_picture' => [
                'label' => 'Gambar',
                'rules' => [
                    'permit_empty',
                    'uploaded[profile_picture]',
                    'is_image[profile_picture]',
                    'mime_in[profile_picture,image/jpg,image/jpeg,image/png]',
                    'max_size[profile_picture,5120]', // 5MB in KB (5 * 1024)
                    'min_dims[profile_picture,600,600]',
                ],
                'errors' => [
                    'uploaded' => 'Choose Uploaded File',
                    'is_image' => 'File Must be an Image',
                    'mime_in' => 'File must be in format JPG, JPEG, PNG',
                    'max_size' => 'File size must not exceed more than 5MB',
                    'min_dims' => 'Image must be at least 600x600',
                ]
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $user = new \Myth\Auth\Entities\User();
        $user->username = $this->request->getVar('username');
        $user->email = $this->request->getVar('email');
        $user->password = $this->request->getVar('password');
        $user->active = 1;

        if (!$this->userModel->save($user)) {
            return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
        }

        $newUser = $this->userModel->where('email', $user->email)->first();
        $userId = $newUser->id;

        $groupId = $this->groupModel->where('name', 'patient')->first()->id;
        $this->groupModel->addUserToGroup($userId, $groupId);

        $patientData = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'sex' => $this->request->getPost('sex'),
            'dob' => $this->request->getPost('dob'),
            'patient_type' => $this->request->getPost('patient_type'),
            'email' => $user->email,
            'profile_picture' => '',
            'user_id' => $userId,
        ];

        $profilePicture = $this->request->getFile('profile_picture');
        if ($profilePicture && $profilePicture->isValid() && !$profilePicture->hasMoved()) {

            $uploadPath = WRITEPATH . 'uploads/' . 'patients/' . $userId . '/' . 'profile_picture' . '/';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $pictureName = 'profile_picture' . '_' . $userId . '_' . date('Y_m_d') . '_' . time() . '.' . $profilePicture->getClientExtension();
            $picturePath = $uploadPath . $pictureName;
            $profilePicture->move($uploadPath, $pictureName);

            $relativePath = 'uploads/' . 'patients/' . $userId . '/' . 'profile_picture' . '/' . $pictureName;
            $patientData['profile_picture'] = $relativePath;
        }
        // dd($patientData);
        $this->patientModel->save($patientData);

        cache()->delete("user-list");

        return redirect()->to('admin/users')->with('message', 'User Created Successfully');
    }

    public function updatePatient($id)
    {
        $type = $this->request->getMethod();
        if ($type === 'GET') {
            $data = [
                'user' => $this->userModel->getUserWithFullName($id),
            ];

            if (empty($data['user'])) {
                return redirect()->to('/users')->with('error', 'User Not Found');
            }

            return view('page/user/v_user_patient_form', $data);
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('admin/users')->with('error', 'User Not Found');
        }

        $validation = \Config\Services::validation();

        // make the unique rules dynamic if change
        $usernameRule = 'required|min_length[3]|max_length[255]';
        if ($user->username !== $this->request->getVar('username')) {
            $usernameRule .= '|is_unique[users.username]';
        }

        $emailRule = 'required|valid_email|max_length[150]';
        if ($user->email !== $this->request->getVar('email')) {
            $emailRule .= '|is_unique[users.email]';
        }

        $rules = [
            'username' => $usernameRule,
            'email' => $emailRule,
            'first_name' => 'required|min_length[2]|max_length[100]',
            'last_name' => 'required|min_length[2]|max_length[100]',
            'phone' => 'required|regex_match[/^[0-9\-\+\s\(\)]+$/]',
            'address' => 'required|max_length[500]',
            'sex' => 'required|in_list[male,female]',
            'patient_type' => 'required',
            'dob' => 'required|valid_date',
        ];

        //if there is password, it validate
        if (!empty($this->request->getVar('password'))) {
            $rules['password'] = 'required|min_length[8]';
            $rules['pass_confirm'] = 'required|matches[password]';
        }

        $validation->setRules($rules);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Update User
        $user->username = $this->request->getVar('username');
        $user->email = $this->request->getVar('email');
        if (!empty($this->request->getVar('password'))) {
            $user->password = $this->request->getVar('password');
        }

        if ($user->hasChanged()) {
            if (!$this->userModel->save($user)) {
                return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
            }
        }

        // Update Patient
        $patient = $this->patientModel->getPatientByUserId($user->id);
        $patientData = [
            'id' => $patient->id,
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'sex' => $this->request->getPost('sex'),
            'dob' => $this->request->getPost('dob'),
            'patient_type' => $this->request->getPost('patient_type'),
        ];

        $profilePicture = $this->request->getFile('profile_picture');
        if ($profilePicture && $profilePicture->isValid() && !$profilePicture->hasMoved()) {
            if (!empty($patient->profile_picture) || $patient->profile_picture !== null) {
                $oldPicturePath = WRITEPATH . $patient->profile_picture;
                if (is_file($oldPicturePath)) {
                    unlink($oldPicturePath);
                }
                // $this->deleteFolder(dirname(WRITEPATH . $patient->profile_picture));
            }

            $uploadPath = WRITEPATH . 'uploads/' . 'patients/' . $user->id . '/' . 'profile_picture' . '/';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $pictureName = 'profile_picture' . '_' . $user->id . '_' . date('Y_m_d') . '_' . time() . '.' . $profilePicture->getClientExtension();
            $picturePath = $uploadPath . $pictureName;
            $profilePicture->move($uploadPath, $pictureName);

            $relativePath = 'uploads/' . 'patients/' . $user->id . '/' . 'profile_picture' . '/' . $pictureName;
            $patientData['profile_picture'] = $relativePath;
        }

        if ($patient->first_name !== $patientData['first_name'] || $patient->last_name !== $patientData['last_name'] || $patient->phone !== $patientData['phone'] || $patient->address !== $patientData['address'] || $patient->sex !== $patientData['sex'] || $patient->dob !== $patientData['dob'] || $patient->profile_picture !== $patientData['profile_picture']) {
            if (!$this->patientModel->save($patientData)) {
                return redirect()->back()->withInput()->with('errors', $this->patientModel->errors());
            }
        }

        cache()->delete("user-list");

        if (in_groups(Roles::ADMIN)) {
            return redirect()->to('admin/users')->with('message', 'User Updated Successfully');
        } else {
            return redirect()->to('profile/detail')->with('message', 'User Updated Successfully');
        }
    }


    public function deletePatient($id)
    {
        $user = $this->userModel->find($id);

        if (empty($user)) {
            return redirect()->to('admin/users')->with('error', 'User Not Found');
        }

        $patient = $this->patientModel->getPatientByUserId($user->id);
        if (!empty($patient)) {
            if (!empty($patient->profile_picture) || $patient->profile_picture !== null) {
                $oldPicturePath = WRITEPATH . $patient->profile_picture;
                if (is_file($oldPicturePath)) {
                    unlink($oldPicturePath);
                }
                // $this->deleteFolder(dirname(WRITEPATH . $patient->profile_picture));
            }
            $this->patientModel->delete($patient->id);
        }

        $this->userModel->delete($user->id);

        cache()->delete("user-list");

        return redirect()->to('admin/users')->with('message', 'User Deleted Successfully');
    }

    public function createDoctor()
    {
        $type = $this->request->getMethod();
        if ($type == "GET") {
            $data['doctor_category'] = $this->doctorCategoryModel->findAll();
            return view('page/user/v_user_doctor_form', $data);
        }
        $educationData = $this->request->getPost('education');


        $validation = \Config\Services::validation();
        $validation->setRules([
            'username' => 'required|min_length[3]|max_length[255]|is_unique[users.username]',
            'email' => 'required|valid_email|max_length[150]|is_unique[users.email]',
            'password' => 'required|min_length[8]',
            'first_name' => 'required|min_length[2]|max_length[100]',
            'last_name' => 'required|min_length[2]|max_length[100]',
            'phone' => 'required|regex_match[/^[0-9\-\+\s\(\)]+$/]',
            'doctor_category_id' => 'required',
            'address' => 'required|max_length[500]',
            'sex' => 'required|in_list[male,female]',
            'dob' => 'required|valid_date',
            'profile_picture' => [
                'label' => 'Gambar',
                'rules' => [
                    'permit_empty',
                    'uploaded[profile_picture]',
                    'is_image[profile_picture]',
                    'mime_in[profile_picture,image/jpg,image/jpeg,image/png]',
                    'max_size[profile_picture,5120]', // 5MB in KB (5 * 1024)
                    'min_dims[profile_picture,600,600]',
                ],
                'errors' => [
                    'uploaded' => 'Choose Uploaded File',
                    'is_image' => 'File Must be an Image',
                    'mime_in' => 'File must be in format JPG, JPEG, PNG',
                    'max_size' => 'File size must not exceed more than 5MB',
                    'min_dims' => 'Image must be at least 600x600',
                ]
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $user = new \Myth\Auth\Entities\User();
        $user->username = $this->request->getVar('username');
        $user->email = $this->request->getVar('email');
        $user->password = $this->request->getVar('password');
        $user->active = 1;

        if (!$this->userModel->save($user)) {
            return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
        }

        $newUser = $this->userModel->where('email', $user->email)->first();
        $userId = $newUser->id;

        $groupId = $this->groupModel->where('name', 'doctor')->first()->id;
        $this->groupModel->addUserToGroup($userId, $groupId);

        $doctorData = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'sex' => $this->request->getPost('sex'),
            'dob' => $this->request->getPost('dob'),
            'email' => $user->email,
            'profile_picture' => '',
            'doctor_category_id' => $this->request->getPost('doctor_category_id'),
            'user_id' => $userId,
        ];

        $profilePicture = $this->request->getFile('profile_picture');
        if ($profilePicture && $profilePicture->isValid() && !$profilePicture->hasMoved()) {

            $uploadPath = WRITEPATH . 'uploads/' . 'doctors/' . $userId . '/' . 'profile_picture' . '/';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $pictureName = 'profile_picture' . '_' . $userId . '_' . date('Y_m_d') . '_' . time() . '.' . $profilePicture->getClientExtension();
            $picturePath = $uploadPath . $pictureName;
            $profilePicture->move($uploadPath, $pictureName);

            $relativePath = 'uploads/' . 'doctors/' . $userId . '/' . 'profile_picture' . '/' . $pictureName;
            $doctorData['profile_picture'] = $relativePath;
        }


        if (empty($doctorData['id'])) {
            // New record

            if ($this->doctorModel->save($doctorData)) {
                $doctorId = $this->doctorModel->getInsertID();

                $educationDataDoctor = [];
                foreach ($educationData as $edu) {
                    $edu['doctor_id'] = $doctorId;
                    $educationDataDoctor[] = $edu;
                }

                $result = $this->educationModel->insertBatchValidated($educationDataDoctor);

                if ($result['status'] == false) {
                    $del = $this->deleteDoctorHard($userId);

                    if ($del) {
                        return redirect()->back()->withInput()->with('error', $result['error']);
                    }
                }
            }
        }

        cache()->delete("user-list");

        return redirect()->to('admin/users')->with('message', 'User Created Successfully');
    }

    public function updateDoctor($id)
    {
        $type = $this->request->getMethod();
        if ($type === 'GET') {
            $data = [
                'doctor_category' => $this->doctorCategoryModel->findAll(),
                'user' => $this->userModel->getUserWithFullName($id),
            ];


            if (empty($data['user'])) {
                return redirect()->to('/users')->with('error', 'User Not Found');
            }

            return view('page/user/v_user_doctor_form', $data);
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('admin/users')->with('error', 'User Not Found');
        }

        $validation = \Config\Services::validation();

        // make the unique rules dynamic if change
        $usernameRule = 'required|min_length[3]|max_length[255]';
        if ($user->username !== $this->request->getVar('username')) {
            $usernameRule .= '|is_unique[users.username]';
        }

        $emailRule = 'required|valid_email|max_length[150]';
        if ($user->email !== $this->request->getVar('email')) {
            $emailRule .= '|is_unique[users.email]';
        }

        $rules = [
            'username' => $usernameRule,
            'email' => $emailRule,
            'first_name' => 'required|min_length[2]|max_length[100]',
            'last_name' => 'required|min_length[2]|max_length[100]',
            'phone' => 'required|regex_match[/^[0-9\-\+\s\(\)]+$/]',
            'address' => 'required|max_length[500]',
            'sex' => 'required|in_list[male,female]',
            'dob' => 'required|valid_date',
            'doctor_category_id' => 'required',
            'profile_picture' => [
                'label' => 'Gambar',
                'rules' => [
                    'permit_empty',
                    'uploaded[profile_picture]',
                    'is_image[profile_picture]',
                    'mime_in[profile_picture,image/jpg,image/jpeg,image/png]',
                    'max_size[profile_picture,5120]', // 5MB in KB (5 * 1024)
                    'min_dims[profile_picture,600,600]',
                ],
                'errors' => [
                    'uploaded' => 'Choose Uploaded File',
                    'is_image' => 'File Must be an Image',
                    'mime_in' => 'File must be in format JPG, JPEG, PNG',
                    'max_size' => 'File size must not exceed more than 5MB',
                    'min_dims' => 'Image must be at least 600x600',
                ]
            ]
        ];

        //if there is password, it validate
        if (!empty($this->request->getVar('password'))) {
            $rules['password'] = 'required|min_length[8]';
            $rules['pass_confirm'] = 'required|matches[password]';
        }

        $validation->setRules($rules);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Update User
        $user->username = $this->request->getVar('username');
        $user->email = $this->request->getVar('email');
        if (!empty($this->request->getVar('password'))) {
            $user->password = $this->request->getVar('password');
        }

        if ($user->hasChanged()) {
            if (!$this->userModel->save($user)) {
                return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
            }
        }

        // Update Patient
        $doctor = $this->doctorModel->getDoctorByUserId($user->id);
        $doctorData = [
            'id' => $doctor->id,
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'sex' => $this->request->getPost('sex'),
            'dob' => $this->request->getPost('dob'),
            'doctor_category_id' => $this->request->getPost('doctor_category_id'),
        ];


        $profilePicture = $this->request->getFile('profile_picture');
        if ($profilePicture && $profilePicture->isValid() && !$profilePicture->hasMoved()) {
            if (!empty($doctor->profile_picture) || $doctor->profile_picture !== null) {
                $oldPicturePath = WRITEPATH . $doctor->profile_picture;
                if (is_file($oldPicturePath)) {
                    unlink($oldPicturePath);
                }
                // $this->deleteFolder(dirname(WRITEPATH . $doctor->profile_picture));
            }

            $uploadPath = WRITEPATH . 'uploads/' . 'doctors/' . $user->id . '/' . 'profile_picture' . '/';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $pictureName = 'profile_picture' . '_' . $user->id . '_' . date('Y_m_d') . '_' . time() . '.' . $profilePicture->getClientExtension();
            $picturePath = $uploadPath . $pictureName;
            $profilePicture->move($uploadPath, $pictureName);

            $relativePath = 'uploads/' . 'doctors/' . $user->id . '/' . 'profile_picture' . '/' . $pictureName;
            $doctorData['profile_picture'] = $relativePath;
        }

        if ($doctor->first_name !== $doctorData['first_name'] || $doctor->last_name !== $doctorData['last_name'] || $doctor->phone !== $doctorData['phone'] || $doctor->address !== $doctorData['address'] || $doctor->sex !== $doctorData['sex'] || $doctor->dob !== $doctorData['dob'] || $doctor->profile_picture !== $doctorData['profile_picture']) {
            if (!$this->doctorModel->save($doctorData)) {
                return redirect()->back()->withInput()->with('errors', $this->patientModel->errors());
            }
        }

        cache()->delete("user-list");

        if (in_groups(Roles::ADMIN)) {
            return redirect()->to('admin/users')->with('message', 'User Updated Successfully');
        } else {
            return redirect()->to('doctor/profile/detail')->with('message', 'User Updated Successfully');
        }
    }

    public function deleteDoctorHard($id)
    {
        $user = $this->userModel->find($id);

        if (empty($user)) {
            return false;
        }

        $doctor = $this->doctorModel->getDoctorByUserId($user->id);
        if (!empty($doctor)) {
            if (!empty($doctor->profile_picture) || $doctor->profile_picture !== null) {
                $oldPicturePath = WRITEPATH . $doctor->profile_picture;
                if (is_file($oldPicturePath)) {
                    unlink($oldPicturePath);
                }
                // $this->deleteFolder(dirname(WRITEPATH . $doctor->profile_picture));
            }
            $this->doctorModel->where('user_id', $id)->delete(null, true);
        }

        $this->userModel->where('id', $id)->delete(null, true);
        return true;
    }

    public function deleteDoctor($id)
    {

        $user = $this->userModel->find($id);

        if (empty($user)) {
            return redirect()->to('admin/users')->with('error', 'User Not Found');
        }

        $doctor = $this->doctorModel->getDoctorByUserId($user->id);
        if (!empty($doctor)) {
            if (!empty($doctor->profile_picture) || $doctor->profile_picture !== null) {
                $oldPicturePath = WRITEPATH . $doctor->profile_picture;
                if (is_file($oldPicturePath)) {
                    unlink($oldPicturePath);
                }
                // $this->deleteFolder(dirname(WRITEPATH . $doctor->profile_picture));
            }
            $this->doctorModel->delete($doctor->id);
        }

        $this->userModel->delete($user->id);

        cache()->delete("user-list");

        return redirect()->to('admin/users')->with('message', 'User Deleted Successfully');
    }

    private function deleteFolder($folderPath)
    {
        if (!is_dir($folderPath)) {
            return;
        }

        $files = glob($folderPath . '/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        rmdir($folderPath);
    }

    private function getAppointmentPerDay()
    {
        // Ambil tanggal hari ini
        $today = date('Y-m-d');

        // Ambil tanggal 7 hari yang lalu
        $lastWeek = date('Y-m-d', strtotime('-6 days', strtotime($today)));

        // Query untuk menghitung jumlah appointment per hari
        $appointments = $this->appointmentModel
            ->select("DATE(date) as appointment_date, COUNT(*) as appointment_count")
            // ->where("DATE(date) BETWEEN '$lastWeek' AND '$today'")
            ->groupBy("DATE(date)")
            ->orderBy("appointment_date", "ASC")
            ->findAll();
            // dd($appointments);

        // Siapkan data untuk Chart.js
        $labels = [];
        $data = [];

        // Buat array tanggal untuk 7 hari terakhir
        $dates = [];
        for ($i = 6; $i >= 0; $i--) {
            $dates[] = date('Y-m-d', strtotime("-$i days", strtotime($today)));
        }

        // Map data appointment ke tanggal
        $appointmentMap = [];
        foreach ($appointments as $appointment) {
            $appointmentMap[$appointment->appointment_date] = (int) $appointment->appointment_count;
        }
        // dd($appointmentMap);

        // Isi data untuk setiap tanggal
        foreach ($dates as $date) {
            $labels[] = date('D, M j', strtotime($date)); // Format label (contoh: Mon, Jan 1)
        }
        // dd($dates);

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Appointments',
                    'data' => $appointmentMap,
                    'backgroundColor' => 'rgba(75, 192, 192, 0.5)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 1,
                ]
            ]
        ];
    }

    private function getPatientDistributionByDoctorCategory()
    {
        // Query untuk menghitung jumlah pasien per kategori dokter
        $patientDistribution = $this->appointmentModel
            ->select("doctor_category.name as category_name, COUNT(appointments.patient_id) as patient_count")
            ->join('doctors', 'doctors.id = appointments.doctor_id', 'left')
            ->join('doctor_category', 'doctor_category.id = doctors.doctor_category_id', 'left')
            ->groupBy("doctor_category.name")
            ->orderBy("patient_count", "DESC")
            ->findAll();

        // Siapkan data untuk Chart.js
        $labels = [];
        $data = [];
        $backgroundColors = [];

        foreach ($patientDistribution as $row) {
            $labels[] = $row->category_name;
            $data[] = (int) $row->patient_count;

            // Generate warna random untuk setiap kategori
            $backgroundColors[] = sprintf(
                'rgba(%d, %d, %d, 0.5)',
                rand(0, 255),
                rand(0, 255),
                rand(0, 255)
            );
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Patient Distribution',
                    'data' => $data,
                    'backgroundColor' => $backgroundColors,
                    'borderColor' => array_map(function ($color) {
                        return str_replace('0.5', '1', $color); // Ubah opacity menjadi 1 untuk border
                    }, $backgroundColors),
                    'borderWidth' => 1,
                ]
            ]
        ];
    }
}
