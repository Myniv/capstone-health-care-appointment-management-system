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

    public function setStatus($value)
    {
        if ($value === 'Maintenance') {
            $this->attributes['status'] = 'Maintenance';
        } else if ($value === '' || $value === null) {
            if ((int) $this->attributes['stock'] === 0) {
                $this->attributes['status'] = 'Out Of Stock';
            } else {
                $this->attributes['status'] = 'Available';
            }
        } else {
            $this->attributes['status'] = $value; // fallback
        }

        return $this;
    }

}
