<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDoctorAbsentTable extends Migration
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
            'date' => [
                'type' => 'DATETIME',
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
        $this->forge->createTable('doctor_absents');
    }

    public function down()
    {
        $this->forge->dropTable('doctor_absents');
        //
    }
}
