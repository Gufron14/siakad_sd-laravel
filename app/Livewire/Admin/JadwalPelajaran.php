<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('Jadwal Pelajaran')]
#[Layout('components.layouts.admin-app')]
class JadwalPelajaran extends Component
{
    public function render()
    {
        return view('livewire.admin.jadwal-pelajaran');
    }
}
