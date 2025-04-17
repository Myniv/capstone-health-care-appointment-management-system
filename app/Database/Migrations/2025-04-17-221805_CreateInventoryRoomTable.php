<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInventoryRoomTable extends Migration
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
            'inventory_id' => [
                'type' => 'INT',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('room_id', 'rooms', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('inventory_id', 'inventories', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('inventory_rooms');
    }

    public function down()
    {
        $this->forge->dropTable('inventory_rooms');
    }
}
