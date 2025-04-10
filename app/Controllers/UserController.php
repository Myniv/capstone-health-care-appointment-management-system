<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\DataParams;
use App\Models\DoctorCategoryModel;
use App\Models\DoctorModel;
use App\Models\PatientModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use Myth\Auth\Models\GroupModel;

class UserController extends BaseController
{
    protected $userModel;
    protected $groupModel;
    protected $patientModel;
    protected $doctorModel;
    protected $doctorCategoryModel;
    protected $config;
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->groupModel = new GroupModel();
        $this->patientModel = new PatientModel();
        $this->doctorModel = new DoctorModel();
        $this->doctorCategoryModel = new DoctorCategoryModel();

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
        // dd($result);

        $data = [
            'users' => $result['users'],
            'pager' => $result['pager'],
            'total' => $result['total'],
            'groups' => $this->groupModel->findAll(),
            'params' => $params,
            'baseUrl' => base_url('admin/users'),
        ];

        return view('page/user/v_user_list', $data);
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
            'dob' => 'required|valid_date'
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
            'email' => $user->email,
            'profile_picture' => '',
            'user_id' => $userId,
        ];
        // dd($patientData);
        $this->patientModel->save($patientData);

        return redirect()->to('admin/users')->with('message', 'User Created Successfully');
    }

    public function deletePatient($id)
    {
        $user = $this->userModel->find($id);

        if (empty($user)) {
            return redirect()->to('admin/users')->with('error', 'User Not Found');
        }

        $patient = $this->patientModel->getPatientByUserId($user->id);
        if (!empty($patient)) {
            $this->patientModel->delete($patient->id);
        }

        $this->userModel->delete($user->id);

        return redirect()->to('admin/users')->with('message', 'User Deleted Successfully');
    }

    public function createDoctor()
    {
        $type = $this->request->getMethod();
        if ($type == "GET") {
            $data['doctor_category'] = $this->doctorCategoryModel->findAll();
            return view('page/user/v_user_doctor_form', $data);
        }
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
            'dob' => 'required|valid_date'
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

        $patientData = [
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
        // dd($patientData);
        $this->doctorModel->save($patientData);

        return redirect()->to('admin/users')->with('message', 'User Created Successfully');
    }

    public function deleteDoctor($id)
    {
        $user = $this->userModel->find($id);

        if (empty($user)) {
            return redirect()->to('admin/users')->with('error', 'User Not Found');
        }

        $doctor = $this->doctorModel->getDoctorByUserId($user->id);
        if (!empty($doctor)) {
            $this->doctorModel->delete($doctor->id);
        }

        $this->userModel->delete($user->id);

        return redirect()->to('admin/users')->with('message', 'User Deleted Successfully');
    }
}
