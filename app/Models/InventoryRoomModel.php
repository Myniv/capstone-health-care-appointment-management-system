<?php

namespace App\Models;

use App\Entities\InventoryRoom;
use CodeIgniter\Model;

class InventoryRoomModel extends Model
{
    protected $table = 'inventory_rooms';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = InventoryRoom::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'room_id',
        'inventory_id',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'room_id' => 'required|is_natural_no_zero',
        'inventory_id' => 'required|is_natural_no_zero',
    ];
    protected $validationMessages = [
        'room_id' => [
            'required' => 'Room ID is required.',
            'is_natural_no_zero' => 'Room ID must be a positive integer.',
        ],
        'inventory_id' => [
            'required' => 'Inventory ID is required.',
            'is_natural_no_zero' => 'Inventory ID must be a positive integer.',
        ]
    ];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    public function getInventoryRoom($room_id)
    {
        return $this->select('inventory_rooms.inventory_id as inventory_id,inventories.name as inventory_name, inventories.function as inventory_function, inventories.serial_number as inventory_serial_number')
            ->join('inventories', 'inventories.id = inventory_rooms.inventory_id', 'left')
            ->where('inventory_rooms.room_id', $room_id)
            ->findAll();
    }
}
