<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHistoryTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'appointment_id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'patient_id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'notes' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'prescriptions' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'documents' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('appointment_id', 'appointments', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('patient_id', 'patients', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('histories');
    }

    public function down()
    {
        $this->forge->dropTable('histories');
    }
}
