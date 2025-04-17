<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class InventoryRoom extends Entity
{
    protected $datamap = [];
    protected $casts = [];
    protected $attributes = [
        'id' => null,
        'room_id' => null,
        'inventory_id' => null,
    ];
}
