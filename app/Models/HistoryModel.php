<?php

namespace App\Models;

use App\Entities\History;
use App\Libraries\DataParams;
use CodeIgniter\Model;
use Config\Roles;

class HistoryModel extends Model
{
    protected $table = 'histories';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = History::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'id',
        'appointment_id',
        'patient_id',
        'notes',
        'prescriptions',
        'documents',
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
    // protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'appointment_id' => 'required',
        'patient_id' => 'required',
        'notes' => 'required|string|max_length[255]',
        'prescriptions' => 'required|string|max_length[255]'
    ];
    protected $validationMessages = [
        'appointment_id' => [
            'required' => 'The appointment ID is required.',
        ],
        'patient_id' => [
            'required' => 'The Patient ID is required.',
        ],
        'notes' => [
            'required' => 'The notes is required.',
            'max_length' => 'The notes must be less than 255 characters.',
        ],
        'prescriptions' => [
            'required' => 'The prescriptions is required.',
            'max_length' => 'The prescriptions must be less than 255 characters.',
        ]
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

    private function getHistory()
    {
        return $this->select('histories.id as historyId,
        histories.notes as notes,
        histories.prescriptions as prescriptions,
        histories.documents as documents,
        appointments.date as date,
        appointments.status as status,
        appointments.reason_for_visit as reason,
        doctors.first_name as doctorFirstName,
        doctors.last_name as doctorLastName,
        patients.first_name as patientFirstName,
        patients.last_name as patientLastName')
            ->join('appointments', 'appointments.id = histories.appointment_id', 'left')
            ->join('doctors', 'appointments.doctor_id = doctors.id', 'left')
            ->join('patients', 'appointments.patient_id = patients.id', 'left');
    }

    public function getHistoryForDashboard($id)
    {
        return $this->getHistory()
            ->orderBy('histories.id', 'DESC')
            ->where('appointments.patient_id', $id)
            ->findAll(4);
    }

    public function getSortedHistory(DataParams $params)
    {
        $this->getHistory();

        if (!empty($params->doctor)) {
            $this->where('doctors.id', $params->doctor);
        }

        if (!empty($params->search)) {
            $this->groupStart()
                ->like('histories.notes', $params->search, 'both', null, true)
                ->orLike('histories.prescriptions', $params->search, 'both', null, true)
                ->orLike('appointments.reason_for_visit', $params->search, 'both', null, true)
                ->orLike('doctors.first_name', $params->search, 'both', null, true)
                ->orLike('doctors.last_name', $params->search, 'both', null, true)
                ->groupEnd();
        }

        if (!empty($params->date)) {
            $this->where("TO_CHAR(date, 'YYYY-MM-DD') LIKE", "%{$params->date}%");
        }

        $allowedSort = ['historyId'];

        $sort = in_array($params->sort, $allowedSort) ? $params->sort : 'historyId';
        $order = ($params->order === 'desc') ? 'DESC' : 'ASC';

        $this->orderBy($sort, $order);

        return [
            'histories' => $this->paginate($params->perPage, 'histories', $params->page),
            'total' => $this->countAllResults(),
            'pager' => $this->pager
        ];
    }

    public function getAllHistoryDoctorPatient($doctorId, $date)
    {
        $this->getHistory();

        if (!empty($date)) {
            $this->where("TO_CHAR(date, 'YYYY-MM-DD') LIKE", "%{$date}%");
        }

        if (!empty($doctorId)) {
            $this->where('doctors.id', $doctorId);
        }

        return $this->findAll();
    }
}
