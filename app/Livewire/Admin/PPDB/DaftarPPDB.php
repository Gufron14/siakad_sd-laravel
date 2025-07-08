<?php

namespace App\Livewire\Admin\PPDB;

use App\Models\PPDB;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('PPDB')]
#[Layout('components.layouts.admin-app')]

class DaftarPPDB extends Component
{
    public function render()
    {   
        $ppdb = PPDB::all();

        return view('livewire.admin.ppdb.daftar-ppdb', compact('ppdb'));
    }
}
