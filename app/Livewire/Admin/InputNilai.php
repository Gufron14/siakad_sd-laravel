<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Murid;
use App\Models\Nilai;
use Livewire\Component;
use App\Models\MataPelajaran;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Title('Input Nilai')]
#[Layout('components.layouts.admin-app')]
class InputNilai extends Component
{
    public $kelas;
    public $mataPelajaranId = '';
    public $semester = '';
    public $tahun = '';
    public $listMataPelajaran = [];
    public $listSemester = ['1' => 'Ganjil', '2' => 'Genap'];
    public $listTahun = [];
    public $murids = [];
    public $nilai = [];

    public function mount()
    {
        // Ambil guru yang sedang login
        $guru = Auth::user();

        // Ambil kelas yang diampu guru
        $this->kelas = Kelas::where('guru_id', $guru->id)->first();

        // Ambil daftar mata pelajaran
        $this->listMataPelajaran = MataPelajaran::all();

        // Tahun ajaran (otomatis 3 tahun terakhir)
        $tahunSekarang = date('Y');
        for ($i = 0; $i < 3; $i++) {
            $this->listTahun[] = $tahunSekarang - $i . '/' . ($tahunSekarang - $i + 1);
        }

        // Default tahun ajaran
        $this->tahun = $this->listTahun[0] ?? '';

        // Ambil murid di kelas
        $this->murids = $this->kelas ? $this->kelas->murid : [];

        // Inisialisasi nilai
        foreach ($this->murids as $murid) {
            $this->nilai[$murid->id] = [
                'uas' => '',
            ];
        }
    }

    public function updatedMataPelajaranId()
    {
        $this->loadNilai();
    }

    public function updatedSemester()
    {
        $this->loadNilai();
    }

    public function updatedTahun()
    {
        $this->loadNilai();
    }

    public function loadNilai()
    {
        if (!$this->mataPelajaranId || !$this->semester || !$this->tahun) {
            return;
        }

        foreach ($this->murids as $murid) {
            $nilai = Nilai::where([
                'murid_id' => $murid->id,
                'mata_pelajaran_id' => $this->mataPelajaranId,
                'semester' => $this->semester,
                'tahun' => $this->tahun,
            ])->first();

            $this->nilai[$murid->id] = [
                'uas' => $nilai->uas ?? '',
            ];
        }
    }

    public function simpanNilai()
    {
        $this->validate([
            'mataPelajaranId' => 'required',
            'semester' => 'required',
            'tahun' => 'required',
            'nilai.*.uas' => 'nullable|numeric|min:0|max:100',
        ]);

        foreach ($this->murids as $murid) {
            Nilai::updateOrCreate(
                [
                    'murid_id' => $murid->id,
                    'mata_pelajaran_id' => $this->mataPelajaranId,
                    'semester' => $this->semester,
                    'tahun' => $this->tahun,
                ],
                [
                    'guru_id' => Auth::id(),
                    'uas' => $this->nilai[$murid->id]['uas'] ?: null,
                ],
            );
        }

        session()->flash('success', 'Nilai berhasil disimpan!');
    }

    /**
     * Hitung rata-rata kelas untuk UAS
     */
    public function getRataRataKelas()
    {
        $totalNilai = 0;
        $jumlahMurid = count($this->murids);

        foreach ($this->murids as $murid) {
            $nilaiUas = $this->nilai[$murid->id]['uas'] ?? 0;
            $totalNilai += is_numeric($nilaiUas) ? $nilaiUas : 0;
        }

        return $jumlahMurid > 0 ? number_format($totalNilai / $jumlahMurid, 2) : '-';
    }

    public function render()
    {
        $loggedInUser = Auth::user();

        // Default guru
        $guru = $loggedInUser;

        // Jika yang login adalah admin, cari user dengan role guru
        if ($loggedInUser->hasRole('admin')) {
            $guru = User::role('guru')->first(); // ambil salah satu guru
        }

        return view('livewire.admin.input-nilai', [
            'kelas' => $this->kelas,
            'guru' => $guru,
            'listMataPelajaran' => $this->listMataPelajaran,
            'listSemester' => $this->listSemester,
            'listTahun' => $this->listTahun,
            'murids' => $this->murids,
            'nilai' => $this->nilai,
        ]);
    }
}
