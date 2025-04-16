<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Equipment extends Entity
{
    protected $datamap = [];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $attributes = [
        'id' => null,
        'name' => null,
        'function' => null,
        'stock' => null,
        'status' => null,
        'created_at' => null,
        'updated_at' => null,
        'deleted_at' => null
    ];
    protected $casts = [
        'createdAt' => 'datetime',
        'updatedAt' => 'datetime',
    ];
}
