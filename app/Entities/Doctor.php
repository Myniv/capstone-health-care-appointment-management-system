<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Doctor extends Entity
{
    protected $datamap = [];
    protected $attributes = [
        'id' => null,
        'first_name' => null,
        'last_name' => null,
        'phone' => null,
        'address' => null,
        'sex' => null,
        'dob' => null,
        'email' => null,
        // 'degree' => null,
        // 'education' => null,
        'profile_picture' => null,
        'doctor_category_id' => null,
        'user_id' => null,
        'createdAt' => null,
        'updatedAt' => null,
        'deletedAt' => null,
    ];
    protected $casts = [
        'id' => 'integer',
        'first_name' => 'string',
        'last_name' => 'string',
        'phone' => 'string',
        'address' => 'string',
        'sex' => 'string',
        'dob' => 'datetime',
        'email' => 'string',
        // 'degree' => 'string',
        // 'education' => 'string',
        'profile_picture' => 'string',
        'doctor_category_id' => 'integer',
        'user_id' => 'integer',
        'createdAt' => 'datetime',
        'updatedAt' => 'datetime',
        'deletedAt' => 'datetime',
    ];
}
