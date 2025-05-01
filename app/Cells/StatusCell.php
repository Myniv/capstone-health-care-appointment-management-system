<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class StatusCell extends Cell
{
    protected $status;

    public function mount($status)
    {
        $this->status = $status;
    }

    public function getStatus()
    {
        $color = '';
        $statusLower = strtolower($this->status);
        $statusUpper = ucfirst($this->status);

        if ($statusLower == 'booking' || $statusLower == 'inuse'  || $statusLower == 'pending') {
            $color =  'warning';
        }
        if ($statusLower == 'cancel' || $statusLower == 'inactive' || $statusLower == 'out of stock' || $statusLower == 'reject') {
            $color =  'error';
        }
        if ($statusLower == 'done' || $statusLower == 'active' || $statusLower == 'available' || $statusLower == 'approve') {
            $color =  'success';
        }
        if ($statusLower == 'maintenance') {
            $color =  'info';
        }

        return "<div class=\"badge badge-soft badge-{$color}\">{$statusUpper}</div>";
    }
}
