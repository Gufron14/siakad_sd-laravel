<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('PPDB')]
#[Layout('components.layouts.admin-app')]
class PPDB extends Component
{
    public function render()
    {
        return view('livewire.admin.ppdb');
    }
}
