<?php

namespace App\Livewire\Admin;

use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\JadwalPelajaran as JadwalModel;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('Jadwal Pelajaran')]
#[Layout('components.layouts.admin-app')]
class JadwalPelajaran extends Component
{
    public $kelas_id = '';
    public $tahun_ajaran = '';
    public $jadwal = [];
    public $jamWaktu = []; // Untuk menyimpan waktu yang dapat diedit
    public $editMode = false;
    public $userKelas = null;
    public $isGuru = false;

    public $isAdmin = false;
    public $isStaff = false;

    public $canEditJadwal = false;
    public $canLihatJadwal = false;

    public $filterTahunAjaran = '2025/2026'; // default tahun ajaran untuk staff

    public $hari = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
    public $defaultJamList = [
        '1' => ['jam_mulai' => '07:00', 'jam_selesai' => '07:40'],
        '2' => ['jam_mulai' => '07:40', 'jam_selesai' => '08:20'],
        '3' => ['jam_mulai' => '08:20', 'jam_selesai' => '09:00'],
        '4' => ['jam_mulai' => '09:00', 'jam_selesai' => '09:40'],
        '5' => ['jam_mulai' => '10:00', 'jam_selesai' => '10:40'], // istirahat 09:40-10:00
        '6' => ['jam_mulai' => '10:40', 'jam_selesai' => '11:20'],
        '7' => ['jam_mulai' => '11:20', 'jam_selesai' => '12:00'],
        // '8' => ['jam_mulai' => '13:00', 'jam_selesai' => '13:40'], // ishoma 12:00-13:00
        // '9' => ['jam_mulai' => '13:40', 'jam_selesai' => '14:20'],
        // '10' => ['jam_mulai' => '14:20', 'jam_selesai' => '15:00'],
    ];

    public function mount()
    {
        $this->tahun_ajaran = date('Y');
        $user = auth()->user();
        $this->isAdmin = $user->hasRole('admin');
        $this->isGuru = $user->hasRole('guru');
        $this->isStaff = $user->hasRole('staff');

        // Gunakan permission Spatie
        $this->canEditJadwal = $user->can('edit.jadwal');
        $this->canLihatJadwal = $user->can('lihat.jadwal');

        if ($this->isGuru) {
            $this->userKelas = $user->kelas;
            if ($this->userKelas) {
                $this->kelas_id = $this->userKelas->id;
            }
            $this->editMode = false;
        } elseif ($this->isStaff) {
            $this->editMode = false;
            $this->tahun_ajaran = '2025/2026';
        } else {
            $this->editMode = false;
        }

        $this->initializeJadwal();
        if ($this->kelas_id) {
            $this->loadJadwal();
        }
    }

    // ...existing code...
    public function initializeJadwal()
    {
        // Initialize empty schedule array
        foreach ($this->defaultJamList as $jam => $waktu) {
            foreach ($this->hari as $day) {
                $this->jadwal[$jam][$day] = '';
            }
        }

        // Initialize jam waktu dengan default values
        $this->jamWaktu = $this->defaultJamList;

        // Tambahkan waktu istirahat dan ishoma
        $this->jamWaktu['istirahat'] = [
            'jam_mulai' => '09:40',
            'jam_selesai' => '10:00',
        ];
        $this->jamWaktu['ishoma'] = [
            'jam_mulai' => '12:00',
            'jam_selesai' => '13:00',
        ];
    }
    // ...existing code...

    public function updatedKelasId()
    {
        $this->loadJadwal();
    }

    public function loadJadwal()
    {
        if (!$this->kelas_id) {
            return;
        }

        $this->initializeJadwal();

        // Load existing jadwal from database
        $existingJadwal = JadwalModel::where('kelas_id', $this->kelas_id)->get();

        foreach ($existingJadwal as $item) {
            if (isset($this->jadwal[$item->jam][$item->hari])) {
                $this->jadwal[$item->jam][$item->hari] = $item->mata_pelajaran_id;

                // Load waktu jika tersedia
                if ($item->waktu) {
                    $waktuParts = explode(' - ', $item->waktu);
                    if (count($waktuParts) == 2) {
                        $this->jamWaktu[$item->jam] = [
                            'jam_mulai' => $waktuParts[0],
                            'jam_selesai' => $waktuParts[1],
                        ];
                    }
                }
            }
        }
    }

    public function toggleEditMode()
    {
        $this->editMode = !$this->editMode;

        if (!$this->editMode) {
            // Cancel changes - reload from database
            $this->loadJadwal();
        }
    }

    public function simpanJadwal()
    {
        if (!$this->canEditJadwal) {
            abort(403, 'Tidak punya akses untuk mengedit jadwal');
        }

        $this->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'tahun_ajaran' => 'required',
        ]);

        // Delete existing jadwal for this class
        JadwalModel::where('kelas_id', $this->kelas_id)->delete();

        // Save new jadwal
        $totalJadwal = 0;
        foreach ($this->jadwal as $jam => $hariData) {
            foreach ($hariData as $hari => $mataPelajaranId) {
                if (!empty($mataPelajaranId)) {
                    // Format waktu untuk disimpan
                    $jamMulai = $this->jamWaktu[$jam]['jam_mulai'] ?? '';
                    $jamSelesai = $this->jamWaktu[$jam]['jam_selesai'] ?? '';
                    $waktuFormat = $jamMulai . ' - ' . $jamSelesai;

                    JadwalModel::create([
                        'kelas_id' => $this->kelas_id,
                        'mata_pelajaran_id' => $mataPelajaranId,
                        'guru_id' => auth()->id(),
                        'hari' => $hari,
                        'jam' => $jam,
                        'waktu' => $waktuFormat, // Simpan format waktu
                    ]);
                    $totalJadwal++;
                }
            }
        }

        $this->editMode = false;
        session()->flash('success', "Jadwal pelajaran berhasil disimpan! Total: {$totalJadwal} slot jadwal.");
    }

    public function clearAllJadwal()
    {
        if (!$this->canEditJadwal) {
            abort(403, 'Tidak punya akses untuk mengedit jadwal');
        }
        
        if ($this->editMode) {
            $this->initializeJadwal();
            session()->flash('info', 'Semua jadwal dikosongkan. Jangan lupa simpan untuk menyimpan perubahan.');
        }
    }

    public function fillEmptySlots()
    {
        if (!$this->canEditJadwal) {
            abort(403, 'Tidak punya akses');
        }
        if ($this->editMode && $this->kelas_id) {
            $mataPelajaranIds = MataPelajaran::pluck('id')->toArray();
            if (!empty($mataPelajaranIds)) {
                foreach ($this->jadwal as $jam => $hariData) {
                    foreach ($hariData as $hari => $current) {
                        if (empty($current)) {
                            $this->jadwal[$jam][$hari] = $mataPelajaranIds[array_rand($mataPelajaranIds)];
                        }
                    }
                }
                session()->flash('info', 'Slot kosong telah diisi otomatis. Silakan review dan simpan.');
            }
        }
    }

    public function resetWaktuDefault()
    {
        if (!$this->canEditJadwal) {
            abort(403, 'Tidak punya akses untuk mengedit jadwal');
        }
        
        if ($this->editMode) {
            $this->jamWaktu = $this->defaultJamList;
            session()->flash('info', 'Waktu dikembalikan ke default. Jangan lupa simpan untuk menyimpan perubahan.');
        }
    }

    public function render()
    {
        $kelas = Kelas::all();
        
        // Filter mata pelajaran berdasarkan kelas yang dipilih untuk admin
        if ($this->isAdmin && $this->kelas_id) {
            $mataPelajaran = MataPelajaran::where('kelas_id', $this->kelas_id)->get();
        } else {
            $mataPelajaran = MataPelajaran::all();
        }

        return view('livewire.admin.jadwal-pelajaran', compact('kelas', 'mataPelajaran'));
    }
}
