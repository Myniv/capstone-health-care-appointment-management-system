<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'key' => 'reminder_appointment_h-7',
                'value' => '7',
                'description' => 'Reminder Appointment H-7',
            ],
            [
                'key' => 'reminder_appointment_h-3',
                'value' => '3',
                'description' => 'Reminder Appointment H-3',
            ],
            [
                'key' => 'reminder_appointment_h-1',
                'value' => '1',
                'description' => 'Reminder Appointment H-1',
            ],
        ];

        $db = \Config\Database::connect();
        $builder = $db->table('settings');

        foreach ($data as $row) {
            $exists = $builder->where('key', $row['key'])->countAllResults();

            if ($exists == 0) {
                $builder->insert($row);
            }
        }
    }
}