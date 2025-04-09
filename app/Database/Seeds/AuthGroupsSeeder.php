<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AuthGroupsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'administrator', 'description' => 'Administrator'],
            ['name' => 'doctor', 'description' => 'Doctor'],
            ['name' => 'patient', 'description' => 'Patient'],
        ];

        $this->db->table('auth_groups')->insertBatch($data);
    }
}
