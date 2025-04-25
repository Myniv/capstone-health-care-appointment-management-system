<?php

namespace App\Models;

use App\Entities\Setting;
use App\Libraries\DataParams;
use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = Setting::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'key',
        'value',
        'description',
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
        'key' => 'required|is_unique[settings.key,id,{id}]',
        'value' => 'permit_empty|string',
        'description' => 'permit_empty|string|max_length[255]',
    ];

    protected $validationMessages = [
        'key' => [
            'required' => 'The setting key is required.',
            'is_unique' => 'The setting key must be unique.',
        ],
        'value' => [
            'string' => 'The value must be a valid string.',
        ],
        'description' => [
            'string' => 'The description must be a valid string.',
            'max_length' => 'The description cannot exceed 255 characters.',
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

    public function getFilteredSetting(DataParams $params)
    {
        $this->select('settings.*');
        if (!empty($params->search)) {
            $this->where('CAST(settings.id AS TEXT) LIKE', "%$params->search%")
                ->OrWhere('CAST(settings.key AS TEXT) LIKE', "%$params->search%")
                ->OrWhere('CAST(settings.value AS TEXT) LIKE', "%$params->search%")
                ->orLike('settings.description', $params->search, 'both', null, true);
        }

        $allowedSort = [
            'settings.id',
            'settings.key',
            'settings.value',
            'settings.description',
        ];

        $sort = in_array($params->sort, $allowedSort) ? $params->sort : 'id';
        $order = ($params->order === 'desc') ? 'DESC' : 'ASC';

        $this->orderBy($sort, $order);

        return [
            'settings' => $this->paginate($params->perPage, 'settings', $params->page),
            'total' => $this->countAllResults(),
            'pager' => $this->pager
        ];
    }
}
