<?php

namespace App\Models;

use App\Entities\DoctorAbsent;
use App\Libraries\DataParams;
use CodeIgniter\Model;

class DoctorAbsentModel extends Model
{
    protected $table            = 'doctor_absents';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    //protected $returnType       = 'array';
    protected $returnType       = DoctorAbsent::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'doctor_id',
        'date',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    //protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    public function getDoctorAbsentById($id)
    {
        dd($this->where('doctor_id', $id)->findAll());
        return $this->where('doctor_id', $id)->findAll();
    }

    public function getSortedDoctorAbsent(DataParams $params)
    {
        $this->select('doctor_absents.*');

        if (!empty($params->search)) {
            $this->like('date', $params->search)
                ->orWhere('CAST(doctor_id AS TEXT) LIKE', "%$params->search%");
        }

        $allowedSort = [
            'id',
            'doctor_id',
            'date',
        ];

        $sort = in_array($params->sort, $allowedSort) ? $params->sort : 'id';
        $order = ($params->order === 'desc') ? 'DESC' : 'ASC';

        $this->orderBy($sort, $order);

        return [
            'doctor_absent' => $this->paginate($params->perPage, 'doctor_absent', $params->page),
            'total' => $this->countAllResults(),
            'pager' => $this->pager
        ];
    }
}
