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

        // Create admin user
        $user = new User([
            'username' => 'admin',
            'email' => 'admin@yopmail.com',
            'password' => 'admin123', // Will be hashed automatically
            'active' => 1,
        ]);

        // Save the user
        $userModel->save($user);

        $userId = $userModel->getInsertID();

        // Make sure the administrator group exists
        $adminGroup = $groupModel->where('name', 'administrator')->first();

        // Assign user to administrator role
        $groupModel->addUserToGroup($userId, $adminGroup->id);
    }
}
