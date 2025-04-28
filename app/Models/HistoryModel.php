<?php

namespace App\Models;

use App\Entities\History;
use CodeIgniter\Model;

class HistoryModel extends Model
{
    protected $table            = 'histories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = History::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
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
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'appointment_id' => 'required',
        'patient_id' => 'required',
        'notes' => 'required|string|max_length[255]',
        'prescriptions' => 'required|string|max_length[255]'
    ];
    protected $validationMessages   = [
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

    public function getHistory()
    {
        return $this->select('histories.id as historyId,
        histories.notes as notes,
        histories.prescriptions as prescriptions,
        appointments.date as date,
        appointments.status as status,
        appointments.reason_for_visit as reason,
        doctors.first_name as firstName,
        doctors.last_name as lastName')
            ->join('appointments', 'appointments.id = histories.appointment_id', 'left')
            ->join('doctors', 'appointments.doctor_id = doctors.id', 'left')
            ->findAll(4);
    }
}
