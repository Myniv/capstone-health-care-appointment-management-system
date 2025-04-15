<?php

namespace App\Models;

use App\Entities\Appointment;
use App\Libraries\DataParams;
use CodeIgniter\Model;
use Config\Roles;

class AppointmentModel extends Model
{
    protected $table            = 'appointments';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Appointment::class;
    //protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'patient_id',
        'doctor_schedule_id',
        'doctor_id',
        'room_id',
        'date',
        'status',
        'reason_for_visit'
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

    public function getSortedAppointment(DataParams $params)
    {

        if (Roles::PATIENT) {
            $this->join('patients', 'patients.id = appointments.patient_id')
                ->where('patients.user_id', user_id());
        }

        if (Roles::DOCTOR) {
            $this->join('doctors', 'doctors.id = appointments.doctor_id')
                ->where('doctors.user_id', user_id());
        }

        $this->select('appointments.*');

        if (!empty($params->search)) {
            $this->where('CAST(id AS TEXT) LIKE', "%$params->search%");
        }

        if (!empty($params->date)) {
            $this->where("TO_CHAR(date, 'YYYY-MM-DD') LIKE", "%{$params->date}%");
        }

        $allowedSort = [
            'id',
            'patient_id',
            'doctor_id',
            'room_id',
            'date',
        ];

        $sort = in_array($params->sort, $allowedSort) ? $params->sort : 'id';
        $order = ($params->order === 'desc') ? 'DESC' : 'ASC';

        $this->orderBy($sort, $order);

        return [
            'appointment' => $this->paginate($params->perPage, 'appointment', $params->page),
            'total' => $this->countAllResults(),
            'pager' => $this->pager
        ];
    }
}
