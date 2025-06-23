<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('Raport')]
#[Layout('components.layouts.admin-app')]
class Raport extends Component
{
    public function render()
    {
        return view('livewire.admin.raport');
    }
}
