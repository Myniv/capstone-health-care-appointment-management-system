<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDoctorTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
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
            'degree' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => true
            ],
            'education' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => true
            ],
            'profile_picture' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
            ],
            'doctor_category_id' => [
                'type' => 'INT',
                'null' => true
            ],
            'user_id' => [
                'type' => 'INT',
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
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('doctor_category_id', 'doctor_category', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('doctors');
    }

    public function down()
    {
        $this->forge->dropTable('doctors');
    }
}
