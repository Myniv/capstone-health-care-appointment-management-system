<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Education extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $attributes = [
        'id' => null,
        'doctor_id' => null,
        'university' => null,
        'city' => null,
        'study_program' => null,
        'degree' => null,
        'createdAt' => null,
        'updatedAt' => null,
        'deletedAt' => null,
    ];
    protected $casts = [
        'id' => 'integer',
        'doctor_id' => 'string',
        'university' => 'string',
        'city' => 'string',
        'study_program' => 'string',
        'degree' => 'string',
        'createdAt' => 'datetime',
        'updatedAt' => 'datetime',
        'deletedAt' => 'datetime',
    ];
}
