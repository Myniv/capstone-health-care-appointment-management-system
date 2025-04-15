<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAppointmentTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'patient_id' => [
                'type' => 'INT',
                'null' => true
            ],
            'doctor_schedule_id' => [
                'type' => 'INT',
                'null' => true
            ],
            'doctor_id' => [
                'type' => 'INT',
                'null' => true
            ],
            'room_id' => [
                'type' => 'INT',
                'null' => true
            ],
            'date' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            //documents
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true
            ],
            'reason_for_visit' => [
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
        $this->forge->addForeignKey('patient_id', 'patients', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('doctor_schedule_id', 'doctor_schedules', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('doctor_id', 'doctors', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('room_id', 'rooms', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('appointments');
    }

    public function down()
    {
        $this->forge->dropTable('appointments');
        //
    }
}
