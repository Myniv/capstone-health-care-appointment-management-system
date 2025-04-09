<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePatientTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'patientId' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'first_name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true
            ],
            'last_name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true
            ],
            'address' => [
                'type' => 'VARCHAR',
                'constraint' => '500',
                'null' => true
            ],
            'sex' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true
            ],
            'dob' => [
                'type' => 'DATE',
                'null' => true
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => true
            ],
            'profile_picture' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
            ],
            'userid' => [
                'type' => 'INT',
                'null' => true
            ],
            'createdAt' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updatedAt' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'deletedAt' => [
                'type' => 'DATETIME',
                'null' => true
            ],
        ]);
        $this->forge->addKey('patientId', true);
        $this->forge->createTable('patients');
    }

    public function down()
    {
        $this->forge->dropTable('patients');
    }
}
