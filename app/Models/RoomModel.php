<?php

namespace App\Models;

use App\Entities\Room;
use App\Libraries\DataParams;
use CodeIgniter\Model;

class RoomModel extends Model
{
    protected $table = 'rooms';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = Room::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'name',
        'function',
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
        'status' => 'required|max_length[20]',
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
        'status' => [
            'required' => 'The status field is required.',
            'max_length' => 'The status must not exceed 20 characters.',
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

    public function getFilteredRoom(DataParams $params)
    {
        $this->select('rooms.*');

        if (!empty($params->search)) {
            $this->groupStart()
                ->like('rooms.name', $params->search, 'both', null, true)
                ->orLike('rooms.function', $params->search, 'both', null, true)
                ->orLike('rooms.status', $params->search, 'both', null, true)
                ->orWhere('CAST(rooms.id AS TEXT) LIKE', "%$params->search%")
                ->groupEnd();
        }

        $allowedSort = [
            'rooms.id',
            'rooms.name',
            'rooms.function',
            'rooms.status',
        ];

        $sort = in_array($params->sort, $allowedSort) ? $params->sort : 'id';
        $order = ($params->order === 'desc') ? 'DESC' : 'ASC';

        $this->orderBy($sort, $order);

        return [
            'rooms' => $this->paginate($params->perPage, 'rooms', $params->page),
            'total' => $this->countAllResults(),
            'pager' => $this->pager
        ];
    }
}
