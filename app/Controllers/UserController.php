<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\DataParams;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use Myth\Auth\Models\GroupModel;

class UserController extends BaseController
{
    protected $userModel;
    protected $groupModel;
    protected $config;
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->groupModel = new GroupModel();
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
}
