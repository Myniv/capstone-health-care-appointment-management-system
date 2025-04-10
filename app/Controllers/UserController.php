<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\DataParams;
use App\Models\PatientModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use Myth\Auth\Models\GroupModel;

class UserController extends BaseController
{
    protected $userModel;
    protected $groupModel;
    protected $patientModel;
    protected $config;
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->groupModel = new GroupModel();
        $this->patientModel = new PatientModel();

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
            return view('page/user/v_user_form');
        }

        //Check if the data is valid for patient model
        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'sex' => $this->request->getPost('sex'),
            'dob' => $this->request->getPost('dob'),
            'email' => $this->request->getPost('email'),
            'profile_picture' => '',
            'userId' => '',
        ];

        if (!$this->patientModel->validate($data)) {
            return redirect()->back()->withInput()->with('errors', $this->patientModel->errors());
        }

        $user = new \Myth\Auth\Entities\User();
        $user->username = $this->request->getVar('username');
        $user->email = $this->request->getVar('email');
        $user->password = $this->request->getVar('password');
        $user->active = 1;

        $checkExistingEmail = $this->userModel->where('email', $user->email)->first();
        $checkExistingEmailSoftDelete = $this->userModel->withDeleted()->where('email', $user->email)->first();
        if ($checkExistingEmail) {
            return redirect()->back()->withInput()->with('errorEmail', 'Email already exists');
        } elseif ($checkExistingEmailSoftDelete) {
            return redirect()->back()->withInput()->with('errorEmail', 'Email already exists as deleted user');
        }


        $checkExistingUsername = $this->userModel->where('username', $user->username)->first();
        $checkExistingUsernameSoftDelete = $this->userModel->withDeleted()->where('username', $user->username)->first();
        if ($checkExistingUsername) {
            return redirect()->back()->withInput()->with('errorUsername', 'Username already exists');
        } elseif ($checkExistingUsernameSoftDelete) {
            return redirect()->back()->withInput()->with('errorUsername', 'Username already exists as deleted user');
        } elseif ($this->request->getPost('username') == null || $this->request->getPost('username') == '') {
            return redirect()->back()->withInput()->with('errorUsername', 'Username is required');
        }

        $this->userModel->save($user);

        $newUser = $this->userModel->where('email', $user->email)->first();
        $userId = $newUser->id;

        $groupId = $this->groupModel->where('name', 'patient')->first()->id;
        $this->groupModel->addUserToGroup($userId, $groupId);

        //Add user Id and then save to patient model
        $data['userId'] = $userId;
        $this->patientModel->save($data);


        return redirect()->to('admin/users')->with('message', 'User Created Successfully');
    }
}
