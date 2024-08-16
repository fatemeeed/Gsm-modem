<?php

namespace App\Livewire;

use Livewire\Component;

class DataloggerToggle extends Component
{

    public $dataloggerStatus;

    public function setDataloggerStatus($dataloggerStatus)
    {
        $this->dataloggerStatus=$dataloggerStatus;
    }


    public function render()
    {
        return view('livewire.datalogger-toggle');
    }
}
