<?php

namespace App\Livewire\Admin;

use App\Models\Kelas;
use App\Models\Murid;
use App\Models\Absensi as AbsensiModel;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('Absensi Santri')]
#[Layout('components.layouts.admin-app')]
class Absensi extends Component
{
    public $tanggal;
    public $semester = '';
    public $kelas_id = '';
    public $absensi = [];
    public $userKelas = null;
    public $isGuru = false;
    
    public function mount()
    {
        $this->tanggal = date('Y-m-d');
        
        // Check if user is guru and get their class
        $user = auth()->user();
        if ($user->type === 'guru') {
            $this->isGuru = true;
            $this->userKelas = $user->kelas; // Get teacher's class
            if ($this->userKelas) {
                $this->kelas_id = $this->userKelas->id;
                $this->resetAbsensi();
            }
        }
    }
    
    public function updatedKelasId()
    {
        $this->resetAbsensi();
    }
    
    public function updatedTanggal()
    {
        $this->resetAbsensi();
    }
    
    public function resetAbsensi()
    {
        $this->absensi = [];
        if ($this->kelas_id) {
            $murids = Murid::where('kelas_id', $this->kelas_id)->get();
            foreach ($murids as $murid) {
                $this->absensi[$murid->id] = 'hadir';
            }
            
            // Load existing absensi for today if exists
            $existingAbsensi = AbsensiModel::where('kelas_id', $this->kelas_id)
                ->where('tanggal', $this->tanggal)
                ->first();
                
            if ($existingAbsensi && $existingAbsensi->murid_data) {
                $this->absensi = $existingAbsensi->murid_data;
                $this->semester = $existingAbsensi->semester;
            }
        }
    }
    
    public function simpanAbsensi()
    {
        $this->validate([
            'tanggal' => 'required|date',
            'semester' => 'required',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        try {
            // Save using new JSON structure
            AbsensiModel::saveClassAttendance(
                $this->kelas_id,
                auth()->id(),
                $this->tanggal,
                $this->semester,
                $this->absensi
            );
            session()->flash('success', 'Absensi berhasil disimpan!');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menyimpan absensi: ' . $e->getMessage());
        }
    }
    
    public function render()
    {
        $kelas = Kelas::all();
        $murids = $this->kelas_id ? Murid::where('kelas_id', $this->kelas_id)->get() : collect();
        
        return view('livewire.admin.absensi', compact('kelas', 'murids'));
    }
}
