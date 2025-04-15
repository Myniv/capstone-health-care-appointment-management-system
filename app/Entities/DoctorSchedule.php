<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class DoctorSchedule extends Entity
{
    protected $datamap = [];
    protected $attributes = [
        'id' => null,
        'doctor_id' => null,
        'start_time' => null,
        'end_time' => null,
        'max_patient' => null,
        'status' => null,
        'createdAt' => null,
        'updatedAt' => null,
    ];
    protected $casts = [
        'createdAt' => 'datetime',
        'updatedAt' => 'datetime',
    ];
    protected $dates   = ['created_at', 'updated_at'];
}
