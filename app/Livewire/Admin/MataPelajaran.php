<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('Mata Pelajaran')]
#[Layout('components.layouts.admin-app')]
class MataPelajaran extends Component
{
    public function render()
    {
        return view('livewire.admin.mata-pelajaran');
    }
}
