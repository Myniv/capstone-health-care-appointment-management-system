<?php

namespace App\Models;

use App\Entities\EquipmentRoom;
use CodeIgniter\Model;

class EquipmentRoomModel extends Model
{
    protected $table = 'equipment_rooms';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = EquipmentRoom::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'room_id',
        'equipment_id',
        'total',
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
        'equipment_id' => 'required|is_natural_no_zero',
        'total' => 'required|is_natural_no_zero',
    ];
    protected $validationMessages = [
        'room_id' => [
            'required' => 'Room ID is required.',
            'is_natural_no_zero' => 'Room ID must be a positive integer.',
        ],
        'equipment_id' => [
            'required' => 'Equipment ID is required.',
            'is_natural_no_zero' => 'Equipment ID must be a positive integer.',
        ],
        'total' => [
            'required' => 'Total is required.',
            'is_natural_no_zero' => 'Total must be a positive integer.',
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

    public function getEquipmentRoom($room_id)
    {
        return $this->select('equipment_rooms.total as quantity, equipments.name as name, equipments.function as equipment_function')
            ->join('equipments', 'equipments.id = equipment_rooms.equipment_id', 'left')
            ->where('equipment_rooms.room_id', $room_id)
            ->findAll();
    }

    public function getEquipmentRoomById($room_id, $equipment_id){
        return $this->where('room_id', $room_id)->where('equipment_id', $equipment_id)->first();
    }
}
