<?php

namespace App\Models;

use App\Entities\Equipment;
use App\Libraries\DataParams;
use CodeIgniter\Model;

class EquipmentModel extends Model
{
    protected $table = 'equipments';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = Equipment::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'name',
        'function',
        'stock',
        'status',
        'createdAt',
        'updatedAt',
        'deletedAt'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'name' => 'required|max_length[100]',
        'function' => 'required|max_length[100]',
        'stock' => 'required|is_natural|max_length[11]',
        'status' => 'required|in_list[Available,Out Of Stock]',
    ];
    protected $validationMessages = [
        'name' => [
            'required' => 'The name field is required.',
            'max_length' => 'The name must not exceed 100 characters.',
        ],
        'function' => [
            'required' => 'The function field is required.',
            'max_length' => 'The function must not exceed 100 characters.',
        ],
        'stock' => [
            'required' => 'The stock field is required.',
            'is_natural' => 'The stock must be a non-negative number.',
            'max_length' => 'The stock value is too long.',
        ],
        'status' => [
            'required' => 'The status field is required.',
            'in_list' => 'The status must be either "Available" or "Out Of Stock".',
        ],
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

    public function getFilteredEquipment(DataParams $params)
    {
        $this->select('equipments.*');

        if (!empty($params->search)) {
            $this->groupStart()
                ->like('equipments.name', $params->search, 'both', null, true)
                ->orLike('equipments.function', $params->search, 'both', null, true)
                ->orLike('equipments.status', $params->search, 'both', null, true)
                ->orWhere('CAST(equipments.id AS TEXT) LIKE', "%$params->search%")
                ->orWhere('CAST(equipments.stock AS TEXT) LIKE', "%$params->search%")
                ->groupEnd();
        }

        if (!empty($params->status)) {
            $this->where('equipments.status', $params->status);
        }

        $allowedSort = [
            'equipments.id',
            'equipments.name',
            'equipments.function',
            'equipments.stock',
            'equipments.status',
        ];

        $sort = in_array($params->sort, $allowedSort) ? $params->sort : 'id';
        $order = ($params->order === 'desc') ? 'DESC' : 'ASC';

        $this->orderBy($sort, $order);

        return [
            'equipments' => $this->paginate($params->perPage, 'equipments', $params->page),
            'total' => $this->countAllResults(),
            'pager' => $this->pager
        ];
    }

    public function getUnassignedEquipment()
    {
        return $this->db->table('equipments')
            ->select('id, name, stock, status')
            ->whereNotIn('id', function ($builder) {
                return $builder->select('id')->from('equipment_rooms');
            })
            ->get()
            ->getResultArray();
    }

    public function getAssignedEquipment()
    {
        return $this
            ->select("
                COALESCE(rooms.name, 'N/A') AS room_name,
                COALESCE(equipment_rooms.total, '-1') AS total,
                equipments.name AS name,
                equipments.function AS function,
                equipments.status AS status,
                equipments.stock AS stock
            ")
            ->join('equipment_rooms', 'equipments.id = equipment_rooms.equipment_id', 'left')
            ->join('rooms', 'equipment_rooms.room_id = rooms.id', 'left')
            ->findAll();
    }
}
