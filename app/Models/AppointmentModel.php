<?php

namespace App\Models;

use App\Entities\Appointment;
use App\Libraries\DataParams;
use CodeIgniter\Model;
use Config\Roles;

class AppointmentModel extends Model
{
    protected $table = 'appointments';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = Appointment::class;
    //protected $returnType       = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'patient_id',
        'doctor_schedule_id',
        'doctor_id',
        'room_id',
        'date',
        'status',
        'reason_for_visit',
        'is_reschedule',
        'documents'
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
    //protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'doctor_schedule_id' => 'required',
        'doctor_id' => 'required',
        'room_id' => 'required',
        'date' => 'required',
        'reason_for_visit' => 'required|max_length[100]',
    ];
    protected $validationMessages = [
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

    private function getAppointment()
    {
        return $this->select('appointments.id, 
        patients.first_name as patientFirstName, 
        patients.last_name as patientLastName,
        patients.profile_picture as patientProfilePicture,
        doctor_schedules.start_time as startTime,
        doctor_schedules.end_time as endTime,
        doctors.first_name as doctorFirstName,
        doctors.last_name as doctorLastName,
        doctors.profile_picture as doctorProfilePicture,
        doctor_category.name as doctorCategoryName,
        rooms.name as roomName,
        appointments.date as date,
        appointments.status as status,
        appointments.reason_for_visit as reason')
            ->join('doctor_schedules', 'doctor_schedules.id = appointments.doctor_schedule_id', 'left')
            ->join('rooms', 'rooms.id = doctor_schedules.room_id', 'left')
            ->join('patients', 'patients.id = appointments.patient_id', 'left')
            ->join('doctors', 'doctors.id = appointments.doctor_id', 'left')
            ->join('doctor_category', 'doctor_category.id = doctors.doctor_category_id');
    }

    public function getSortedAppointment(DataParams $params)
    {
        $this->select('appointments.id, 
            patients.first_name as patientFirstName, 
            patients.last_name as patientLastName,
            doctor_schedules.start_time as startTime,
            doctor_schedules.end_time as endTime,
            doctors.first_name as doctorFirstName,
            doctors.last_name as doctorLastName,
            doctors.profile_picture as doctorProfilePicture,
            patients.profile_picture as patientProfilePicture,
            rooms.name as roomName,
            appointments.date as date,
            appointments.reason_for_visit as reason,
            appointments.status as status,
            appointments.is_reschedule as is_reschedule');

        $this->join('doctor_schedules', 'doctor_schedules.id = appointments.doctor_schedule_id');
        $this->join('rooms', 'rooms.id = doctor_schedules.room_id');
        $this->join('patients', 'patients.id = appointments.patient_id');
        $this->join('doctors', 'doctors.id = appointments.doctor_id');



        // if (Roles::PATIENT) {
        //     $this->join('patients', 'patients.id = appointments.patient_id');
        // }

        // if (Roles::DOCTOR || Roles::ADMIN) {
        //     $this->join('doctors', 'doctors.id = appointments.doctor_id');
        // }

        if (empty($params->sort)) {
            $params->sort = 'created_at';
        }
        if (empty($params->order)) {
            $params->order = 'desc';
        }

        if (!empty($params->doctor)) {
            $this->where('doctors.id', $params->doctor);
        }

        if (!empty($params->patient)) {
            $this->where('patients.id', $params->patient);
        }

        if (!empty($params->search)) {
            $this->groupStart()
                ->like('patients.first_name', $params->search, 'both', null, true)
                ->orLike('patients.last_name', $params->search, 'both', null, true)
                ->orLike('appointments.status', $params->search, 'both', null, true)
                ->groupEnd();
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
            'created_at'
        ];

        $sort = in_array($params->sort, $allowedSort) ? $params->sort : 'created_at';
        $order = $params->sort ? (($params->order === 'desc') ? 'DESC' : 'ASC') : 'DESC';

        if ($params->order == 'asc' || $params->order == 'desc') {
            $this->orderBy($sort, $order);
        } else if ($params->order == 'furthest') {
            $this->orderBy('date', 'desc');
        } else {
            $this->orderBy('date', 'asc');
        }

        return [
            'appointments' => $this->paginate($params->perPage, 'appointments', $params->page),
            'total' => $this->countAllResults(),
            'pager' => $this->pager
        ];
    }

    public function addAppointment($data)
    {
        return $this->save($data);
    }

    public function updateAppointment($id, $data)
    {
        return $this->update($id, $data);
    }

    public function getAllAppointmentsDoctor($doctorId, $date)
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
            appointments.status as status,
            appointments.reason_for_visit as reason')
            ->join('doctor_schedules', 'doctor_schedules.id = appointments.doctor_schedule_id')
            ->join('rooms', 'rooms.id = doctor_schedules.room_id')
            ->join('patients', 'patients.id = appointments.patient_id')
            ->join('doctors', 'doctors.id = appointments.doctor_id');

        if (!empty($date)) {
            $this->where("TO_CHAR(date, 'YYYY-MM-DD') LIKE", "%{$date}%");
        }

        if (!empty($doctorId)) {
            $this->where('appointments.doctor_id', $doctorId);
        }

        return $this->findAll();
    }

    public function getUpcomingAppointmentPatient($patientId)
    {
        return $this->getAppointment()
            ->orderBy('appointments.date', 'ASC')
            ->orderBy('doctor_schedules.start_time', 'ASC')
            ->where('appointments.status', 'booking')
            ->where('appointments.patient_id', $patientId)
            ->findAll(2);
    }

    public function getUpcomingAppointmentDoctor($doctorId)
    {
        return $this->getAppointment()
            ->orderBy('appointments.date', 'ASC')
            ->orderBy('doctor_schedules.start_time', 'ASC')
            ->where('appointments.status', 'booking')
            ->where('appointments.doctor_id', $doctorId)
            // ->where('DATE(appointments.date)', date('Y-m-d'))
            ->findAll(3);
    }
}
