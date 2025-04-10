<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDoctorCategoryTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'doctor_categoryId' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('doctor_categoryId', true);
        $this->forge->createTable('doctor_category');
    }

    public function down()
    {
        $this->forge->dropTable('doctor_category');
    }
}
