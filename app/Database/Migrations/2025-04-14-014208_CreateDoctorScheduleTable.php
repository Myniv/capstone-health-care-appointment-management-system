<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDoctorScheduleTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'doctor_id' => [
                'type' => 'INT',
                'null' => true
            ],
            'room_id' => [
                'type' => 'INT',
                'null' => true
            ],
            'start_time' => [
                'type' => 'TIME',
                'null' => true
            ],
            'end_time' => [
                'type' => 'TIME',
                'null' => true
            ],
            'max_patient' => [
                'type' => 'INT',
                'null' => true
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('doctor_id', 'doctors', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('room_id', 'rooms', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('doctor_schedules');
    }

    public function down()
    {
        //
        $this->forge->dropTable('doctor_schedules');
    }
}
