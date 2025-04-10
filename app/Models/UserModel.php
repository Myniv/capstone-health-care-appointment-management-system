<?php

namespace App\Models;

use App\Libraries\DataParams;
use CodeIgniter\Model;

class UserModel extends \Myth\Auth\Models\UserModel
{
    public function getFilteredUser(DataParams $params)
    {
        $this
            ->select("
                users.id as user_id,
                users.username,
                users.email as email,
                COALESCE(doctors.first_name, patients.first_name, 'N/A') as first_name,
                COALESCE(doctors.last_name, patients.last_name, 'N/A') as last_name,
                COALESCE(doctors.phone, patients.phone, 'N/A') as phone,
                COALESCE(doctors.address, patients.address, 'N/A') as address,
                COALESCE(doctors.sex, patients.sex, 'N/A') as sex,
                COALESCE(doctors.dob, patients.dob, '9999-01-01') as dob,
                COALESCE(doctor_category.name, 'N/A') as doctor_category,
                auth_groups.name as role,
                auth_groups.id as group_id, 
            ")
            ->join('doctors', 'doctors.user_id = users.id', 'left')
            ->join('patients', 'patients.user_id = users.id', 'left')
            ->join('doctor_category', 'doctor_category.id = doctors.doctor_category_id', 'left')
            ->join('auth_groups_users', 'auth_groups_users.user_id = users.id', 'left')
            ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id', 'left');

        // Search
        if (!empty($params->search)) {
            $this->groupStart()
                ->like('username', $params->search)
                ->orLike('email', $params->search)
                ->orLike('first_name', $params->search)
                ->orLike('last_name', $params->search)
                ->orLike('role', $params->search)
                ->orLike('doctor_category', $params->search)
                ->orLike('sex', $params->search)
                ->orWhere('CAST(phone AS TEXT) LIKE', "%$params->search%")
                ->orWhere('CAST(users.id AS TEXT) LIKE', "%$params->search%")
                ->groupEnd();
        }

        // Filter role
        if (!empty($params->role)) {
            $this->where('auth_groups.id', $params->role);
        }

        // Sorting
        $allowedSort = [
            'user_id',
            'username',
            'user_email',
            'first_name',
            'last_name',
            'role',
            'doctor_category',
            'group_name'
        ];
        $sort = in_array($params->sort, $allowedSort) ? $params->sort : 'user_id';
        $order = ($params->order === 'desc') ? 'DESC' : 'ASC';

        $this->orderBy($sort, $order);

        return [
            'users' => $this->paginate($params->perPage, 'users', $params->page),
            'total' => $this->countAllResults(),
            'pager' => $this->pager
        ];
    }
}
