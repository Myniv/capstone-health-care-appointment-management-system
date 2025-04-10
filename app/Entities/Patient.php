<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Patient extends Entity
{
    protected $datamap = [];
    protected $attributes = [
        'patientId' => null,
        'first_name' => null,
        'last_name' => null,
        'phone' => null,
        'address' => null,
        'sex' => null,
        'dob' => null,
        'email' => null,
        'profile_picture' => null,
        'userId' => null,
        'createdAt' => null,
        'updatedAt' => null,
        'deletedAt' => null,
    ];
    protected $casts = [
        'patientId' => 'integer',
        'first_name' => 'string',
        'last_name' => 'string',
        'phone' => 'string',
        'address' => 'string',
        'sex' => 'string',
        'dob' => 'date',
        'email' => 'string',
        'profile_picture' => 'string',
        'userId' => 'integer',
        'createdAt' => 'datetime',
        'updatedAt' => 'datetime',
        'deletedAt' => 'datetime',
    ];
}
