<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('Input Nilai')]
#[Layout('components.layouts.admin-app')]
class InputNilai extends Component
{
    public function render()
    {
        return view('livewire.admin.input-nilai');
    }
}
