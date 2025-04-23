<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Setting extends Entity
{
    protected $datamap = [];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $attributes = [
        'id' => null,
        'key' => null,
        'value' => null,
        'description' => null
    ];
}
