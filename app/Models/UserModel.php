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
                users.username as username,
                COALESCE(users.email, patients.email, doctors.email) as email,
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
                ->like('users.username', $params->search, 'both', null, true)
                ->orLike('users.email', $params->search, 'both', null, true)
                ->orLike('doctors.email', $params->search, 'both', null, true)
                ->orLike('patients.email', $params->search, 'both', null, true)
                ->orLike('doctors.first_name', $params->search, 'both', null, true)
                ->orLike('patients.first_name', $params->search, 'both', null, true)
                ->orLike('doctors.last_name', $params->search, 'both', null, true)
                ->orLike('patients.last_name', $params->search, 'both', null, true)
                ->orLike('auth_groups.name', $params->search, 'both', null, true)
                ->orLike('doctor_category.name', $params->search, 'both', null, true)
                ->orLike('doctors.sex', $params->search, 'both', null, true)
                ->orLike('patients.sex', $params->search, 'both', null, true)
                ->orLike("CAST(doctors.phone AS TEXT)", $params->search, 'both', null, true)
                ->orLike("CAST(patients.phone AS TEXT)", $params->search, 'both', null, true)
                ->orLike("CAST(users.id AS TEXT)", $params->search, 'both', null, true)
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
            'email',
            'first_name',
            'phone',
            'address',
            'sex',
            'dob',
            'role',
            'doctor_category',
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

    public function getUserWithFullName($userId)
    {
        return $this
            ->select("
                users.id as user_id,
                users.username,
                users.email as email,
                COALESCE(doctors.first_name, patients.first_name, 'N/A') as first_name,
                COALESCE(doctors.last_name, patients.last_name, 'N/A') as last_name,
                COALESCE(doctors.phone, patients.phone, 'N/A') as phone,
                COALESCE(doctors.address, patients.address, 'N/A') as address,
                COALESCE(doctors.sex, patients.sex, 'N/A') as sex,
                COALESCE(doctors.profile_picture, patients.profile_picture, 'N/A') as profile_picture,
                COALESCE(doctors.dob, patients.dob, '9999-01-01') as dob,
                COALESCE(doctor_category.name, 'N/A') as doctor_category, 
                COALESCE(doctor_category.id, '-1') as doctor_category_id, 
                auth_groups.name as role,
                auth_groups.id as group_id, 
            ")
            ->join('doctors', 'doctors.user_id = users.id', 'left')
            ->join('patients', 'patients.user_id = users.id', 'left')
            ->join('doctor_category', 'doctor_category.id = doctors.doctor_category_id', 'left')
            ->join('auth_groups_users', 'auth_groups_users.user_id = users.id', 'left')
            ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id', 'left')
            ->where('users.id', $userId)
            ->first();
    }
}
