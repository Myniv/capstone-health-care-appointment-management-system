<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Myth\Auth\Entities\User;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $userModel = model('Myth\Auth\Models\UserModel');
        $groupModel = model('Myth\Auth\Models\GroupModel');

        $user = new User([
            'username' => 'admin',
            'email' => 'admin@yopmail.com',
            'password' => 'Admin123',
            'active' => 1,
        ]);

        $userModel->save($user);

        $userId = $userModel->getInsertID();

        $adminGroup = $groupModel->where('name', 'administrator')->first();

        $groupModel->addUserToGroup($userId, $adminGroup->id);
    }
}
