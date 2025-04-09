<?php

namespace Myth\Auth\Models;

use App\Libraries\DataParams;
use CodeIgniter\Model;
use Config\Roles;
use Faker\Generator;
use Myth\Auth\Authorization\GroupModel;
use Myth\Auth\Entities\User;

/**
 * @method User|null first()
 */
class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $returnType = User::class;
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'email',
        'username',
        'password_hash',
        'reset_hash',
        'reset_at',
        'reset_expires',
        'activate_hash',
        'status',
        'status_message',
        'active',
        'force_pass_reset',
        'permissions',
        'deleted_at',
    ];
    protected $useTimestamps = true;
    protected $validationRules = [
        // 'id' => 'required|numeric|is_natural_no_zero|is_not_unique[users.id]',
        'email' => 'required|valid_email|is_unique[users.email,id,{id}]',
        'username' => 'required|alpha_numeric_punct|min_length[3]|max_length[30]|is_unique[users.username,id,{id}]',
        'password_hash' => 'required',
    ];
    protected $validationRulesForInsert = [
        'email' => 'required|valid_email|is_unique[users.email,id,{id}]',
        'username' => 'required|alpha_numeric_punct|min_length[3]|max_length[30]|is_unique[users.username,id,{id}]',
        'password_hash' => 'required',
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $afterInsert = ['addToGroup'];

    /**
     * The id of a group to assign.
     * Set internally by withGroup.
     *
     * @var int|null
     */
    protected $assignGroup;

    /**
     * Logs a password reset attempt for posterity sake.
     */
    public function logResetAttempt(string $email, ?string $token = null, ?string $ipAddress = null, ?string $userAgent = null)
    {
        $this->db->table('auth_reset_attempts')->insert([
            'email' => $email,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'token' => $token,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Logs an activation attempt for posterity sake.
     */
    public function logActivationAttempt(?string $token = null, ?string $ipAddress = null, ?string $userAgent = null)
    {
        $this->db->table('auth_activation_attempts')->insert([
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'token' => $token,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Sets the group to assign any users created.
     *
     * @return $this
     */
    public function withGroup(string $groupName)
    {
        $group = $this->db->table('auth_groups')->where('name', $groupName)->get()->getFirstRow();

        $this->assignGroup = $group->id;

        return $this;
    }

    /**
     * Clears the group to assign to newly created users.
     *
     * @return $this
     */
    public function clearGroup()
    {
        $this->assignGroup = null;

        return $this;
    }

    /**
     * If a default role is assigned in Config\Auth, will
     * add this user to that group. Will do nothing
     * if the group cannot be found.
     *
     * @param mixed $data
     *
     * @return mixed
     */
    protected function addToGroup($data)
    {
        if (is_numeric($this->assignGroup)) {
            $groupModel = model(GroupModel::class);
            $groupModel->addUserToGroup($data['id'], $this->assignGroup);
        }

        return $data;
    }

    /**
     * Faked data for Fabricator.
     */
    public function fake(Generator &$faker): User
    {
        return new User([
            'email' => $faker->email,
            'username' => $faker->userName,
            'password' => bin2hex(random_bytes(16)),
        ]);
    }

    public function getFilteredUser(DataParams $params)
    {
        $this->select('users.*, 
                   users.id as user_id, 
                   users_ecommerce.status as status, 
                   users_ecommerce.id as ecommerce_id, 
                   users_ecommerce.full_name as full_name, 
                   auth_groups_users.*, 
                   auth_groups.name as role, 
                   auth_groups.id as group_id, 
                   auth_groups.description')
            ->join('users_ecommerce', 'users.username = users_ecommerce.username', 'left')
            ->join('auth_groups_users', 'auth_groups_users.user_id = users.id', 'left')
            ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id', 'left');

        // Searching
        if (!empty($params->search)) {
            $this->groupStart()
                ->like('users.username', $params->search, 'both', null, true)
                ->orLike('users.email', $params->search, 'both', null, true)
                ->orLike('users_ecommerce.full_name', $params->search, 'both', null, true)
                ->orLike('auth_groups.name', $params->search, 'both', null, true)
                ->orLike('users_ecommerce.status', $params->search, 'both', null, true)
                ->orWhere('CAST(users.id AS TEXT) LIKE', "%$params->search%")
                ->groupEnd();
        }

        // Filter by role
        if (!empty($params->role)) {
            $this->where('auth_groups.id', $params->role);
        }

        // Filter by status
        if (!empty($params->status)) {
            $this->where('users_ecommerce.status', $params->status);
        }

        // Define allowed sort columns with explicit table names
        $allowedSortColumns = [
            'users.id',
            'users.username',
            'users.email',
            'users_ecommerce.full_name',
            'auth_groups.name', // role
            'users_ecommerce.status'
        ];

        // Validate sorting column
        $sort = in_array($params->sort, $allowedSortColumns) ? $params->sort : 'users.id';
        $order = ($params->order === 'desc') ? 'DESC' : 'ASC';

        // Order results
        $this->orderBy($sort, $order);

        // Fetch results with pagination
        $result = [
            'users' => $this->paginate($params->perPage, 'users', $params->page),
            'pager' => $this->pager,
            'total' => $this->countAllResults(false),
        ];

        return $result;
    }

    public function getUserWithFullName()
    {
        return $this->select('users.*, users_ecommerce.full_name as full_name')
            ->join('users_ecommerce', 'users.username = users_ecommerce.username', 'left');
        //In the controller just using ->findAll(); for getting all the user with full name
        //or using ->find($id); for getting a single user with full name
    }

    public function getUserWithRoleAdminPM()
    {
        return $this->select('users.*, auth_groups.name as role')
            ->join('auth_groups_users', 'users.id = auth_groups_users.user_id', 'left')
            ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id', 'left')
            ->where('auth_groups.name', Roles::ADMIN)
            ->orWhere('auth_groups.name', Roles::PRODUCT_MANAGER)
            ->findAll();
    }

    public function getFullUserInfo($roles)
    {
        $this->select('users.*, 
                   users.id as user_id, 
                   users_ecommerce.status as status, 
                   users_ecommerce.id as ecommerce_id, 
                   users_ecommerce.full_name as full_name,
                   users_ecommerce.last_login as last_login, 
                   auth_groups_users.*, 
                   auth_groups.name as role, 
                   auth_groups.id as group_id, 
                   auth_groups.description')
            ->join('users_ecommerce', 'users.username = users_ecommerce.username', 'left')
            ->join('auth_groups_users', 'auth_groups_users.user_id = users.id', 'left')
            ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id', 'left');
            if(!empty($roles)){
                $this->where('auth_groups.id', $roles);
            }
            return $this->findAll();
    }

}
