<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PatientModel;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Roles;
use Myth\Auth\Controllers\AuthController as MythController;
use Myth\Auth\Models\GroupModel;
use Myth\Auth\Models\UserModel;

class AuthController extends MythController
{
    protected $auth;
    protected $config;
    protected $userModel;
    protected $patientModel;
    protected $groupModel;
    public function __construct()
    {
        parent::__construct();

        $this->userModel = new UserModel();
        $this->groupModel = new GroupModel();
        $this->patientModel = new PatientModel();

        $this->auth = service('authentication');
    }

    public function login()
    {
        return parent::login();
    }

    public function attemptLogin()
    {
        $result = parent::attemptLogin();
        return $this->redirectBasedOnRole();
    }

    public function forgotPassword()
    {
        return parent::forgotPassword();
    }
    public function attemptForgotPassword()
    {
        return parent::attemptForgot();
    }

    public function resetPassword()
    {
        return parent::resetPassword();
    }

    public function attemptResetPassword()
    {
        return parent::attemptReset();
    }

    public function attemptRegister()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'username' => 'required|min_length[3]|max_length[255]|is_unique[users.username]',
            'email' => 'required|valid_email|max_length[150]|is_unique[users.email]',
            // 'password' => 'required|min_length[8]',
            'first_name' => 'required|min_length[2]|max_length[100]',
            'last_name' => 'required|min_length[2]|max_length[100]',
            'phone' => 'required|regex_match[/^[0-9\-\+\s\(\)]+$/]',
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
        $result = parent::attemptRegister();
        if (!$result) {
            return redirect()
                ->back()
                ->with('errors', session('errors'))
                ->withInput();
        }

        $email = $this->request->getPost('email');
        $user = $this->userModel->where('email', $email)->first();

        if ($user) {
            $customerGroup = $this->groupModel->where('name', Roles::PATIENT)->first();
            if ($customerGroup) {
                $this->groupModel->addUserToGroup($user->id, $customerGroup->id);
            }

            $patientData = [
                'first_name' => $this->request->getPost('first_name'),
                'last_name' => $this->request->getPost('last_name'),
                'phone' => $this->request->getPost('phone'),
                'address' => $this->request->getPost('address'),
                'sex' => $this->request->getPost('sex'),
                'dob' => $this->request->getPost('dob'),
                'email' => $user->email,
                'profile_picture' => '',
                'user_id' => $user->id,
            ];

            $profilePicture = $this->request->getFile('profile_picture');
            if ($profilePicture && $profilePicture->isValid() && !$profilePicture->hasMoved()) {

                $uploadPath = WRITEPATH . 'uploads/' . $user->id . '/' . 'profile_picture' . '/';

                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                $pictureName = 'profile_picture' . '_' . $user->id . '_' . date('Y_m_d') . '_' . time() . '.' . $profilePicture->getClientExtension();
                $picturePath = $uploadPath . $pictureName;
                $profilePicture->move($uploadPath, $pictureName);

                $relativePath = 'uploads/' . $user->id . '/' . 'profile_picture' . '/' . $pictureName;
                $patientData['profile_picture'] = $relativePath;
            }

            $this->patientModel->save($patientData);

        }

        return redirect()->route('login')->with('message', lang('Auth.activationSuccess'));
    }

    private function redirectBasedOnRole()
    {
        $userId = user_id();
        if (!$userId) {
            return redirect()->to('/login');
        }

        $userGroups = $this->groupModel->getGroupsForUser($userId);
        foreach ($userGroups as $group) {
            if ($group['name'] === Roles::ADMIN) {
                //dashboard admin
                return redirect()->to('/dashboard');
            } else if ($group['name'] === Roles::DOCTOR) {
                //dashboard doctor
                return redirect()->to('/dashboard');
            } else if ($group['name'] === Roles::PATIENT) {
                //dashboard patient
                return redirect()->to('/');
            }
        }
        return redirect()->to('/');
    }

    public function unauthorized()
    {
        return view("page/auth/unauthorized");
    }

    private function createImageVersions($filePath, $fileName)
    {
        $image = service('image');

        $directory = dirname($filePath);

        $image->withFile($filePath)
            ->resize(300, 300, true, 'height')
            ->save($directory . '/' . "medium_" . $fileName);
    }
}
