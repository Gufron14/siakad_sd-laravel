<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\Kelas;
use App\Models\Murid;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;

#[Title('Daftar Hadir Santri')]
#[Layout('components.layouts.admin-app')]
class DaftarHadir extends Component
{
    public $kelas_id;
    public $semester = 'ganjil';
    public $kelas = [];

    public function mount()
    {
        $user = Auth::user();
        
        if ($user->hasRole('admin')) {
            $this->kelas = Kelas::all();
        } else {
            // Guru hanya bisa melihat kelas yang dia ajar
            $this->kelas = Kelas::where('guru_id', $user->id)->get();
            
            // Auto select kelas jika guru hanya mengajar 1 kelas
            if ($this->kelas->count() == 1) {
                $this->kelas_id = $this->kelas->first()->id;
            }
        }
    }

    public function render()
    {
        $murids = [];
        $absensiData = [];

        if ($this->kelas_id) {
            $user = Auth::user();
            
            // Validasi akses kelas
            if (!$user->hasRole('admin')) {
                $kelasAccess = Kelas::where('id', $this->kelas_id)
                    ->where('guru_id', $user->id)
                    ->exists();
                
                if (!$kelasAccess) {
                    session()->flash('error', 'Anda tidak memiliki akses ke kelas ini.');
                    return view('livewire.admin.daftar-hadir', [
                        'murids' => [],
                        'absensiData' => []
                    ]);
                }
            }
            
            $murids = Murid::where('kelas_id', $this->kelas_id)->get();
            
            // Get all absensi records for this class and semester
            $absensiRecords = Absensi::where('kelas_id', $this->kelas_id)
                ->where('semester', $this->semester)
                ->get();

            // Process absensi data for each student
            foreach ($murids as $murid) {
                $absensiData[$murid->id] = [
                    'hadir' => 0,
                    'sakit' => 0,
                    'izin' => 0,
                    'alpa' => 0
                ];

                foreach ($absensiRecords as $record) {
                    // Fix json_decode error
                    $muridData = is_array($record->murid_data) 
                        ? $record->murid_data 
                        : json_decode($record->murid_data, true);
                    
                    if (isset($muridData[$murid->id])) {
                        $status = $muridData[$murid->id];
                        if (isset($absensiData[$murid->id][$status])) {
                            $absensiData[$murid->id][$status]++;
                        }
                    }
                }
            }
        }

        return view('livewire.admin.daftar-hadir', [
            'murids' => $murids,
            'absensiData' => $absensiData
        ]);
    }
}
