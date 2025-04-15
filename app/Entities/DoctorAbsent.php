<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class DoctorAbsent extends Entity
{
    protected $datamap = [];
    protected $attributes = [
        'id' => null,
        'doctor_id' => null,
        'date' => null,
        'createdAt' => null,
        'updatedAt' => null,
    ];
    protected $casts = [
        'createdAt' => 'datetime',
        'updatedAt' => 'datetime',
    ];
    protected $dates   = ['created_at', 'updated_at'];
}
