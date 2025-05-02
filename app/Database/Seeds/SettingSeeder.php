<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'key' => 'reminder_days',
                'value' => '7,3,1',
                'description' => 'Reminder For Appointment',
            ],
            [
                'key' => 'cancel_due',
                'value' => '3',
                'description' => 'For due cancelation appointment',
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