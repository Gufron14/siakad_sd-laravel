<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('Absensi Santri')]
#[Layout('components.layouts.admin-app')]
class Absensi extends Component
{
    public function render()
    {
        return view('livewire.admin.absensi');
    }
}
