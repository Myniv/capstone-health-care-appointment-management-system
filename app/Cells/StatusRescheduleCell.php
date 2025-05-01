<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class StatusRescheduleCell extends Cell
{
    protected $is_reschedule;

    public function mount($is_reschedule)
    {
        $this->is_reschedule = $is_reschedule;
    }

    public function getStatusReschedule()
    {
        if ($this->is_reschedule == 'true') {
            return "<div class=\"badge badge-soft badge-info\">Rescheduled</div>";
        }
        return "";
    }
}
