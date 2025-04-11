<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEquipmentTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true
            ],
            'function' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true
            ],
            'stock' => [
                'type' => 'INT',
                'null' => false
            ],
            'status' => [
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
        //$this->forge->addForeignKey('doctor_category_id', 'doctor_category', 'id', 'CASCADE', 'SET NULL');
        //$this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('equipments');
    }

    public function down()
    {
        $this->forge->dropTable('equipments');
        //
    }
}
