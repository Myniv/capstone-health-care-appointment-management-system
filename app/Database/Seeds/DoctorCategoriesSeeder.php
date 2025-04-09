<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DoctorCategoriesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'dentist', 'description' => 'Dokter Gigi'],
            ['name' => 'pediatrician', 'description' => 'Dokter Anak'],
            ['name' => 'general_practitioner', 'description' => 'Dokter Umum'],
        ];

        $this->db->table('doctor_categories')->insertBatch($data);
    }
}
