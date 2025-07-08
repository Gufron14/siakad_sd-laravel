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

#[Title('Raport')]
#[Layout('components.layouts.admin-app')]
class Raport extends Component
{
    public $selectedMurid = '';
    public $selectedSemester = '';
    public $selectedTahun = '';
    public $murids = [];
    public $nilaiData = [];
    public $absensiData = [];
    public $mataPelajarans = [];
    public $kelas;
    public $listTahun = [];

    public function mount()
    {
        // Get kelas yang diajar oleh guru yang sedang login
        $this->kelas = Kelas::where('guru_id', Auth::id())->first();
        
        if ($this->kelas) {
            $this->murids = Murid::where('kelas_id', $this->kelas->id)->get();
        }

        // Generate list tahun (5 tahun terakhir sampai 2 tahun ke depan)
        $currentYear = date('Y');
        for ($i = $currentYear - 0; $i <= $currentYear + 2; $i++) {
            $this->listTahun[] = $i . '/' . ($i + 1);
        }

        // Ambil mata pelajaran yang pernah dinilai oleh guru ini
        $mataPelajaranIds = Nilai::where('guru_id', Auth::id())
            ->distinct()
            ->pluck('mata_pelajaran_id');
            
        $this->mataPelajarans = MataPelajaran::whereIn('id', $mataPelajaranIds)->get();
    }

    public function updatedSelectedMurid()
    {
        if ($this->selectedMurid && $this->selectedSemester && $this->selectedTahun) {
            $this->loadNilaiData();
            $this->loadAbsensiData();
        }
        // Debug
        logger('Selected Murid: ' . $this->selectedMurid);
        logger('Nilai Data: ', $this->nilaiData);
    }

    public function updatedSelectedSemester()
    {
        if ($this->selectedMurid && $this->selectedSemester && $this->selectedTahun) {
            $this->loadNilaiData();
            $this->loadAbsensiData();
        }
        // Debug
        logger('Selected Semester: ' . $this->selectedSemester);
    }

    public function updatedSelectedTahun()
    {
        if ($this->selectedMurid && $this->selectedSemester && $this->selectedTahun) {
            $this->loadNilaiData();
            $this->loadAbsensiData();
        }
        // Debug
        logger('Selected Tahun: ' . $this->selectedTahun);
    }

    public function loadNilaiData()
    {
        $this->nilaiData = [];
        
        if ($this->selectedMurid && $this->selectedSemester && $this->selectedTahun) {
            // Convert semester format from Ganjil/Genap to numeric
            $semesterNumber = $this->selectedSemester === 'Ganjil' ? '1' : '2';
            
            $nilaiRecords = Nilai::where('semester', $semesterNumber)
                ->where('tahun', $this->selectedTahun)
                ->with('mataPelajaran')
                ->get();

            // Debug logging
            logger('Loading nilai data...');
            logger('Selected values:', [
                'murid' => $this->selectedMurid,
                'semester' => $this->selectedSemester, 
                'tahun' => $this->selectedTahun
            ]);
            logger('Found nilai records: ' . $nilaiRecords->count());
            
            foreach ($nilaiRecords as $record) {
                logger('Record ID: ' . $record->id . ', Mata Pelajaran: ' . $record->mata_pelajaran_id);
                logger('Murid nilai data:', $record->murid_nilai);
                
                if (isset($record->murid_nilai[$this->selectedMurid])) {
                    $this->nilaiData[$record->mata_pelajaran_id] = [
                        'uas' => $record->murid_nilai[$this->selectedMurid],
                        'mataPelajaran' => $record->mataPelajaran
                    ];
                    logger('Added nilai for mapel ' . $record->mata_pelajaran_id . ': ' . $record->murid_nilai[$this->selectedMurid]);
                } else {
                    logger('No nilai found for murid ' . $this->selectedMurid . ' in record ' . $record->id);
                }
            }
            
            logger('Final nilaiData:', $this->nilaiData);
        }
    }

    public function loadAbsensiData()
    {
        if ($this->selectedMurid && $this->selectedSemester && $this->selectedTahun) {
            $absensiRecords = Absensi::where('kelas_id', $this->kelas->id)
                ->where('semester', $this->selectedSemester)
                ->whereYear('tanggal', explode('/', $this->selectedTahun)[0])
                ->get();

            $this->absensiData = [
                'sakit' => 0,
                'izin' => 0,
                'alfa' => 0
            ];

            foreach ($absensiRecords as $record) {
                $muridData = $record->murid_data;
                if (isset($muridData[$this->selectedMurid])) {
                    $status = $muridData[$this->selectedMurid];
                    if ($status === 'sakit') {
                        $this->absensiData['sakit']++;
                    } elseif ($status === 'izin') {
                        $this->absensiData['izin']++;
                    } elseif ($status === 'alfa') {
                        $this->absensiData['alfa']++;
                    }
                }
            }
        }
    }

    public function getTotalNilai()
    {
        return collect($this->nilaiData)->sum('uas');
    }

    public function getPeringkat()
    {
        if (!$this->selectedSemester || !$this->selectedTahun) {
            return null;
        }

        // Convert semester format from Ganjil/Genap to numeric
        $semesterNumber = $this->selectedSemester === 'Ganjil' ? '1' : '2';

        // Hitung total nilai untuk semua murid di kelas
        $nilaiMurids = [];
        $nilaiRecords = Nilai::where('semester', $semesterNumber)
            ->where('tahun', $this->selectedTahun)
            ->get();

        foreach ($this->murids as $murid) {
            $totalNilai = 0;
            foreach ($nilaiRecords as $record) {
                if (isset($record->murid_nilai[$murid->id])) {
                    $totalNilai += $record->murid_nilai[$murid->id];
                }
            }
            $nilaiMurids[$murid->id] = $totalNilai;
        }

        // Sort descending untuk mendapatkan peringkat
        arsort($nilaiMurids);
        $peringkat = array_keys($nilaiMurids);
        
        $posisi = array_search($this->selectedMurid, $peringkat);
        return $posisi !== false ? $posisi + 1 : null;
    }

    public function getRataRataKelas($mataPelajaranId = null)
    {
        if (!$this->selectedSemester || !$this->selectedTahun || !$mataPelajaranId) {
            return 0;
        }

        // Convert semester format from Ganjil/Genap to numeric
        $semesterNumber = $this->selectedSemester === 'Ganjil' ? '1' : '2';

        // Ambil nilai untuk mata pelajaran tertentu
        $nilaiRecord = Nilai::where('mata_pelajaran_id', $mataPelajaranId)
            ->where('semester', $semesterNumber)
            ->where('tahun', $this->selectedTahun)
            ->first();

        if (!$nilaiRecord) {
            return 0;
        }

        $totalNilai = 0;
        $jumlahMurid = 0;

        // Hitung rata-rata nilai untuk mata pelajaran ini dari semua murid di kelas
        foreach ($this->murids as $murid) {
            if (isset($nilaiRecord->murid_nilai[$murid->id])) {
                $totalNilai += $nilaiRecord->murid_nilai[$murid->id];
                $jumlahMurid++;
            }
        }

        return $jumlahMurid > 0 ? round($totalNilai / $jumlahMurid, 2) : 0;
    }

    public function cetakSemuaRaport()
    {
        if (!$this->selectedSemester || !$this->selectedTahun) {
            session()->flash('error', 'Pilih semester dan tahun terlebih dahulu');
            return;
        }

        return redirect()->route('cetakRaport', [
            'kelas_id' => $this->kelas->id,
            'semester' => $this->selectedSemester,
            'tahun' => $this->selectedTahun
        ]);
    }

    public function numberToWords($number)
    {
        $words = [
            1 => 'satu', 2 => 'dua', 3 => 'tiga', 4 => 'empat', 5 => 'lima',
            6 => 'enam', 7 => 'tujuh', 8 => 'delapan', 9 => 'sembilan', 10 => 'sepuluh',
            11 => 'sebelas', 12 => 'dua belas', 13 => 'tiga belas', 14 => 'empat belas', 15 => 'lima belas',
            16 => 'enam belas', 17 => 'tujuh belas', 18 => 'delapan belas', 19 => 'sembilan belas', 20 => 'dua puluh'
        ];
        
        return $words[$number] ?? $number;
    }

    public function render()
    {
        return view('livewire.admin.raport');
    }
}
