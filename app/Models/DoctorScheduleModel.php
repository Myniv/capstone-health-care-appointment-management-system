<?php

namespace App\Models;

use App\Entities\DoctorSchedule;
use App\Libraries\DataParams;
use CodeIgniter\Model;

class DoctorScheduleModel extends Model
{
    protected $table = 'doctor_schedules';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    //protected $returnType       = 'array';
    protected $returnType = DoctorSchedule::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'doctor_id',
        'room_id',
        'start_time',
        'end_time',
        'max_patient',
        'status'
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
    protected $validationRules = [];
    protected $validationMessages = [];
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

    public function getFilteredDoctorSchedule(DataParams $params)
    {
        $this->select("
        doctor_schedules.id as id, 
        doctor_schedules.start_time as start_time, 
        doctor_schedules.end_time as end_time, 
        doctor_schedules.max_patient as max_patient, 
        doctor_schedules.status as status, 
        rooms.name as room_name, 
        doctors.first_name as doctor_first_name, 
        doctors.last_name as doctor_last_name, 
        doctors.email as doctor_email,
        doctor_category.name as doctor_category_name,
        doctor_category.id as doctor_category_id")
            ->join('rooms', 'rooms.id = doctor_schedules.room_id', 'left')
            ->join('doctors', 'doctors.id = doctor_schedules.doctor_id', 'left')
            ->join('doctor_category', 'doctor_category.id = doctors.doctor_category_id', 'left');

        if (!empty($params->search)) {
            $this->groupStart()
                ->like('rooms.name', $params->search, 'both', null, true)
                ->orLike('doctors.first_name', $params->search, 'both', null, true)
                ->orLike('doctors.last_name', $params->search, 'both', null, true)
                ->orLike('doctors.email', $params->search, 'both', null, true)
                ->orLike('doctor_schedules.status', $params->search, 'both', null, true)
                ->orWhere('CAST(doctor_schedules.max_patient AS TEXT) LIKE', "%$params->search%")
                ->orWhere('CAST(doctor_schedules.start_time AS TEXT) LIKE', "%$params->search%")
                ->orWhere('CAST(doctor_schedules.end_time AS TEXT) LIKE', "%$params->search%")
                ->groupEnd();
        }

        if (!empty($params->doctor_category)) {
            $this->where('doctor_category.id', $params->doctor_category);
        }

        $allowedSort = [
            'id',
            'room_name',
            'doctor_first_name',
            'doctor_last_name',
            'doctor_email',
            'status',
            'max_patient',
            'start_time',
            'end_time',
        ];

        $sort = in_array($params->sort, $allowedSort) ? $params->sort : 'id';
        $order = ($params->order === 'desc') ? 'DESC' : 'ASC';

        $this->orderBy($sort, $order);

        return [
            'doctor_schedule' => $this->paginate($params->perPage, 'doctor_schedule', $params->page),
            'total' => $this->countAllResults(),
            'pager' => $this->pager
        ];
    }

    public function addSchedule($data)
    {
        // Check for overlapping schedules
        $result = $this->select('doctor_schedules.*')
            ->where('room_id', $data['room_id'])
            ->groupStart()
            ->where('start_time <', $data['end_time'])
            ->where('end_time >', $data['start_time'])
            ->groupEnd()
            ->get();

        if ($result->getNumRows() > 0) {
            // Room is already booked for this time
            return ['error' => 'Room is already booked during this time.'];
        }

        // Insert new schedule
        $this->save($data);

        return ['success' => 'Schedule added successfully.'];
    }

}
