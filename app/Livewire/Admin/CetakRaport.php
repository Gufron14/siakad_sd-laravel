<?php

namespace App\Livewire\Admin;

use App\Models\Kelas;
use App\Models\Murid;
use App\Models\Nilai;
use App\Models\Absensi;
use App\Models\MataPelajaran;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Title('Cetak Raport')]
#[Layout('components.layouts.admin-app')]
class CetakRaport extends Component
{
    public $kelas;
    public $semester;
    public $tahun;
    public $murids = [];
    public $raportData = [];
    public $mataPelajarans = [];

    public function mount($kelas_id, $semester, $tahun)
    {
        $this->kelas = Kelas::findOrFail($kelas_id);
        $this->semester = $semester;
        $this->tahun = $tahun;
        
        // Pastikan guru hanya bisa mencetak raport kelasnya sendiri
        if ($this->kelas->guru_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }

        $this->murids = Murid::where('kelas_id', $kelas_id)->get();
        $this->mataPelajarans = MataPelajaran::all();
        
        $this->loadRaportData();
    }

    public function loadRaportData()
    {
        $nilaiRecords = Nilai::where('semester', $this->semester)
            ->where('tahun', $this->tahun)
            ->with('mataPelajaran')
            ->get();

        foreach ($this->murids as $murid) {
            // Load nilai
            $nilaiData = [];
            $totalNilai = 0;
            
            foreach ($nilaiRecords as $record) {
                if (isset($record->murid_nilai[$murid->id])) {
                    $nilaiData[$record->mata_pelajaran_id] = [
                        'uas' => $record->murid_nilai[$murid->id],
                        'mataPelajaran' => $record->mataPelajaran
                    ];
                    $totalNilai += $record->murid_nilai[$murid->id];
                }
            }

            // Load absensi
            $absensiRecords = Absensi::where('kelas_id', $this->kelas->id)
                ->where('semester', $this->semester)
                ->whereYear('tanggal', explode('/', $this->tahun)[0])
                ->get();

            $absensiData = [
                'sakit' => 0,
                'izin' => 0,
                'alpha' => 0
            ];

            foreach ($absensiRecords as $record) {
                $muridData = $record->murid_data;
                if (isset($muridData[$murid->id])) {
                    $status = $muridData[$murid->id];
                    if ($status === 'sakit') {
                        $absensiData['sakit']++;
                    } elseif ($status === 'izin') {
                        $absensiData['izin']++;
                    } elseif ($status === 'alpha') {
                        $absensiData['alpha']++;
                    }
                }
            }

            // Hitung total nilai dan peringkat
            $totalNilai = $nilaiData->sum('uas');
            
            $this->raportData[$murid->id] = [
                'murid' => $murid,
                'nilai' => $nilaiData,
                'absensi' => $absensiData,
                'total_nilai' => $totalNilai
            ];
        }

        // Hitung peringkat
        $nilaiMurids = collect($this->raportData)->pluck('total_nilai', 'murid.id')->toArray();
        arsort($nilaiMurids);
        $peringkat = array_keys($nilaiMurids);

        foreach ($this->raportData as $muridId => &$data) {
            $posisi = array_search($muridId, $peringkat);
            $data['peringkat'] = $posisi !== false ? $posisi + 1 : null;
        }
    }

    public function getRataRataKelas()
    {
        $totalNilai = collect($this->raportData)->sum('total_nilai');
        $jumlahMurid = count($this->raportData);
        
        return $jumlahMurid > 0 ? round($totalNilai / $jumlahMurid, 2) : 0;
    }

    public function render()
    {
        return view('livewire.admin.cetak-raport');
    }
}
