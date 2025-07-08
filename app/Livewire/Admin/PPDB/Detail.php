<?php

namespace App\Livewire\Admin\PPDB;

use App\Models\PPDB;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('Detail Calon Peserta Didik Baru')]
#[Layout('components.layouts.admin-app')]
class Detail extends Component
{   

    public $ppdb;

    public function mount($id = null) 
    {
        $this->ppdb = PPDB::findOrFail($id);
    }
    
    public function render()
    {
        return view('livewire.admin.ppdb.detail',[
            'ppdb' => $this->ppdb
        ]);
    }
}
