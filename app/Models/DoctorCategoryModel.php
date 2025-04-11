<?php

namespace App\Models;

use App\Entities\DoctorCategory;
use App\Libraries\DataParams;
use CodeIgniter\Model;

class DoctorCategoryModel extends Model
{
    protected $table = 'doctor_category';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    // protected $returnType       = 'array';
    protected $returnType = DoctorCategory::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'name',
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
        'name' => 'required|is_unique[doctor_category.name]',
        'description' => 'required|max_length[255]',
    ];
    protected $validationMessages = [
        'name' => [
            'required' => 'Category name is required.',
            'is_unique' => 'Category name must be unique.',
        ],
        'description' => [
            'required' => 'Category description is required.',
            'max_length' => 'Category description must not exceed 255 characters.',
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

    public function getSortedDoctorCategory(DataParams $params)
    {
        $this->select('doctor_category.*');

        if (!empty($params->search)) {
            $this->like('name', $params->search)
                ->orLike('description', $params->search)
                ->orWhere('CAST(id AS TEXT) LIKE', "%$params->search%");
        }

        $allowedSort = [
            'id',
            'name',
            'description',
        ];

        $sort = in_array($params->sort, $allowedSort) ? $params->sort : 'id';
        $order = ($params->order === 'desc') ? 'DESC' : 'ASC';

        $this->orderBy($sort, $order);

        return [
            'doctor_category' => $this->paginate($params->perPage, 'doctor_category', $params->page),
            'total' => $this->countAllResults(),
            'pager' => $this->pager
        ];
    }
}
