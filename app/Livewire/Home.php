<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('MDTA Fathul Uluum - Kab. Bandung')]

class Home extends Component
{
    public function render()
    {
        return view('livewire.home');
    }
}
