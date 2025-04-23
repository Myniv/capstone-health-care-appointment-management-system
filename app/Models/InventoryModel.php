<?php

namespace App\Models;

use App\Entities\Inventory;
use App\Libraries\DataParams;
use CodeIgniter\Model;

class InventoryModel extends Model
{
    protected $table = 'inventories';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = Inventory::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'name',
        'serial_number',
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
        'serial_number' => 'is_unique[inventories.serial_number]|max_length[100]',
        'function' => 'required|max_length[100]',
        'status' => 'required|in_list[Available,Maintenance,In Use]',
    ];
    protected $validationMessages = [
        'name' => [
            'required' => 'The name field is required.',
            'max_length' => 'The name must not exceed 100 characters.',
        ],
        'serial_number' => [
            'required' => 'The serial number is required.',
            'is_unique' => 'This serial number already exists in the inventory.',
            'max_length' => 'The serial number must not exceed 100 characters.',
        ],
        'function' => [
            'required' => 'The function field is required.',
            'max_length' => 'The function must not exceed 100 characters.',
        ],
        'status' => [
            'required' => 'The status field is required.',
            'in_list' => 'The status must be either "Available", "Maintenance" or "In Use".',
        ],
    ];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = ['generateUniqueSerialNumber'];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    public function getFilteredInventory(DataParams $params)
    {
        $this->select('inventories.*');

        if (!empty($params->search)) {
            $this->groupStart()
                ->like('inventories.name', $params->search, 'both', null, true)
                ->orLike('inventories.serial_number', $params->search, 'both', null, true)
                ->orLike('inventories.function', $params->search, 'both', null, true)
                ->orLike('inventories.status', $params->search, 'both', null, true)
                ->orWhere('CAST(inventories.id AS TEXT) LIKE', "%$params->search%")
                ->groupEnd();
        }

        if (!empty($params->status)) {
            $this->where('inventories.status', $params->status);
        }

        $allowedSort = [
            'inventories.id',
            'inventories.name',
            'inventories.serial_number',
            'inventories.function',
            'inventories.status',
        ];

        $sort = in_array($params->sort, $allowedSort) ? $params->sort : 'id';
        $order = ($params->order === 'desc') ? 'DESC' : 'ASC';

        $this->orderBy($sort, $order);

        return [
            'inventories' => $this->paginate($params->perPage, 'inventories', $params->page),
            'total' => $this->countAllResults(),
            'pager' => $this->pager
        ];
    }

    protected function generateUniqueSerialNumber(array $data): array
    {
        helper('text');

        if (empty($data['data']['serial_number'])) {
            do {
                $serial = 'INV-' . strtoupper(random_string('alnum', 6));
            } while ($this->where('serial_number', $serial)->countAllResults() > 0);

            $data['data']['serial_number'] = $serial;
        }

        return $data;
    }

}
