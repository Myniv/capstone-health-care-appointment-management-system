<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Inventory extends Entity
{
    protected $datamap = [];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $attributes = [
        'id' => null,
        'serial_number' => null,
        'name' => null,
        'function' => null,
        'status' => null,
        'created_at' => null,
        'updated_at' => null,
        'deleted_at' => null
    ];
    protected $casts = [
        'createdAt' => 'datetime',
        'updatedAt' => 'datetime',
    ];


    public function setSerialNumber($value)
    {
        if (empty($value)) {
            $value = self::generateSerialNumber();
        }

        $this->attributes['serial_number'] = $value;
        return $this;
    }

    public static function generateSerialNumber(): string
    {
        $prefix = 'INV-';
        $random = strtoupper(bin2hex(random_bytes(3))); // Generates 6 random hex characters
        return $prefix . $random;
    }

}
