<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('Dashboard Admin')]
#[Layout('components.layouts.admin-app')]

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.dashboard');
    }
}
