<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class History extends Entity
{
    protected $datamap = [];
    protected $attributes = [
        'id' => null,
        'appointment_id' => null,
        'patient_id' => null,
        'notes' => null,
        'prescriptions' => null,
        'documents' => null,
        'created_at' => null,
        'updatedAt' => null
    ];
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
