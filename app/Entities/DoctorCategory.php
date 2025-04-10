<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class DoctorCategory extends Entity
{
    protected $datamap = [];
    protected $attributes = [
        'id' => null,
        'name' => null,
        'description' => null,
    ];
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'description' => 'string',
    ];
}
