<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEducationTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'doctor_id' => [
                'type' => 'INT',
                'null' => true
            ],
            'university' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true
            ],
            'city' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true
            ],
            'study_program' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true
            ],
            'degree' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
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
        $this->forge->addForeignKey('doctor_id', 'doctors', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('educations');
    }

    public function down()
    {
        $this->forge->dropTable('educations');
        //
    }
}
