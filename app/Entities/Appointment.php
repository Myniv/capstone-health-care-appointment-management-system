<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Appointment extends Entity
{
    protected $datamap = [];
    protected $attributes = [
        'id' => null,
        'patient_id' => null,
        'doctor_schedule_id' => null,
        'doctor_id' => null,
        'room_id' => null,
        'date' => null,
        'documents' => null,
        'status' => null,
        'reason_for_visit' => null,
        'is_reschedule' => null,
        'createdAt' => null,
        'updatedAt' => null,
    ];
    protected $casts = [
        'createdAt' => 'datetime',
        'updatedAt' => 'datetime',
    ];
    protected $dates   = ['created_at', 'updated_at'];
}
