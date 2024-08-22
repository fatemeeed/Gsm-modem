<?php

namespace App\Livewire;

use Livewire\Component;

class DataloggerToggle extends Component
{

    public $datalogger;


    public function render()
    {
        return view('livewire.datalogger-toggle');
    }
}
