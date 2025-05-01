<?php

namespace App\Models;

use App\Entities\DoctorAbsent;
use App\Libraries\DataParams;
use CodeIgniter\Model;
use Config\Roles;

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
        'status',
        'reason'
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
        return $this->where('doctor_id', $id)->findAll();
    }

    public function getSortedDoctorAbsent(DataParams $params)
    {

        if (!Roles::ADMIN) {
            $this->join('doctors', 'doctors.id = doctor_absents.doctor_id')
                ->where('doctors.user_id', user_id());
        }
        $this->select('doctor_absents.*');
        if (!empty($params->search)) {
            $this->where('CAST(reason AS TEXT) LIKE', "%$params->search%");
        }

        // if (!empty($params->date)) {
        //     $this->where("TO_CHAR(date, 'YYYY-MM-DD') LIKE", "%{$params->date}%");
        // }

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

    public function addAbsent($data)
    {
        if (!$data['date']) {
            return ['error' => 'Date must be filled.'];
        }

        if (!$data['reason']) {
            return ['error' => 'Reason must be filled.'];
        }

        $this->save($data);
        return ['success' => 'Absent successfully requested.'];
    }
}
