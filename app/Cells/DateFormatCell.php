<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class DateFormatCell extends Cell
{
    public $date;

    public function mount()
    {
        if (isset($this->date)) {
            $this->date = date('l, j F Y', strtotime($this->date));
        }
    }
}
