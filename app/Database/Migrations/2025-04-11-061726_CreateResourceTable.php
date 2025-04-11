<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateResourceTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'room_id' => [
                'type' => 'INT',
                'null' => true
            ],
            'equipment_id' => [
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
        $this->forge->addForeignKey('room_id', 'rooms', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('equipment_id', 'equipments', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('resources');
    }

    public function down()
    {
        //
        $this->forge->dropTable('resources');
    }
}
