<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class EquipmentRoom extends Entity
{
    protected $datamap = [];
    protected $casts = [];
    protected $attributes = [
        'id' => null,
        'room_id' => null,
        'inventory_id' => null,
        'total' => null
    ];
}
