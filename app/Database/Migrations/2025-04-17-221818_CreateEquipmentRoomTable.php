<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEquipmentRoomTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'room_id' => [
                'type' => 'INT',
            ],
            'equipment_id' => [
                'type' => 'INT',
            ],
            'total' => [
                'type' => 'INT',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('room_id', 'rooms', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('equipment_id', 'equipments', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('equipment_rooms');
    }

    public function down()
    {
        $this->forge->dropTable('equipment_rooms');
    }
}
