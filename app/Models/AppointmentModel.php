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
    protected $validationRules      = [
        'doctor_schedule_id' => 'required',
        'doctor_id' => 'required',
        'room_id' => 'required',
        'date' => 'required',
        'reason_for_visit' => 'required|max_length[100]',
    ];
    protected $validationMessages   = [
        'doctor_schedule_id' => [
            'required' => 'Time must be choosen.',
        ],
        'doctor_id' => [
            'required' => 'Doctor is required.',
        ],
        'room_id' => [
            'required' => 'Room is required.',
        ],
        'date' => [
            'required' => 'Date is required.',
        ],
        'reason_for_visit' => [
            'required' => 'Needs must be filled.',
            'max_length' => 'Needs must be less than 100 characters.',
        ],
    ];
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
        $this->select('appointments.id, 
            patients.first_name as patientFirstName, 
            patients.last_name as patientLastName,
            doctor_schedules.start_time as startTime,
            doctor_schedules.end_time as endTime,
            doctors.first_name as doctorFirstName,
            doctors.last_name as doctorLastName,
            rooms.name as roomName,
            appointments.date as date,
            appointments.status as status');

        $this->join('doctor_schedules', 'doctor_schedules.id = appointments.doctor_schedule_id');
        $this->join('rooms', 'rooms.id = doctor_schedules.room_id');

        if (Roles::PATIENT) {
            $this->join('patients', 'patients.id = appointments.patient_id');
        }

        if (Roles::DOCTOR) {
            $this->join('doctors', 'doctors.id = appointments.doctor_id');
        }


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

    public function addAppointment($data)
    {
        $this->save($data);
    }

    public function getUpcomingAppointment($patientId)
    {
        return $this->select('appointments.id, 
        patients.first_name as patientFirstName, 
        patients.last_name as patientLastName,
        doctor_schedules.start_time as startTime,
        doctor_schedules.end_time as endTime,
        doctors.first_name as doctorFirstName,
        doctors.last_name as doctorLastName,
        doctors.profile_picture as profilePicture,
        rooms.name as roomName,
        appointments.date as date,
        appointments.status as status,
        appointments.reason_for_visit')
            ->join('doctor_schedules', 'doctor_schedules.id = appointments.doctor_schedule_id', 'left')
            ->join('rooms', 'rooms.id = doctor_schedules.room_id', 'left')
            ->join('patients', 'patients.id = appointments.patient_id', 'left')
            ->join('doctors', 'doctors.id = appointments.doctor_id', 'left')
            ->where('appointments.status', 'on going')
            ->where('appointments.patient_id', $patientId)
            ->orderBy('appointments.date', 'ASC');
    }
}
