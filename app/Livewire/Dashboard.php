<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Murid;
use App\Models\Kelas;
use App\Models\PPDB;
use App\Models\Absensi;
use App\Models\Nilai;
use App\Models\JadwalPelajaran;
use App\Models\MataPelajaran;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

#[Title('Dashboard')]
#[Layout('components.layouts.admin-app')]
class Dashboard extends Component
{
    public $totalSiswa = 0;
    public $totalGuru = 0;
    public $totalKelas = 0;
    public $totalPPDB = 0;
    public $recentPPDB = [];
    
    // Data untuk Guru
    public $kelasGuru = null;
    public $jumlahSiswa = 0;
    public $hadirHariIni = 0;
    public $tidakHadir = 0;
    public $jadwalHariIni = [];
    public $siswaDiKelas = [];
    
    // Data untuk Orang Tua
    public $anakSiswa = [];

    public function mount()
    {
        $user = Auth::user();
        
        if ($user->type === 'admin') {
            $this->loadAdminData();
        } elseif ($user->type === 'guru') {
            $this->loadGuruData();
        } else {
            $this->loadOrangTuaData();
        }
    }

    private function loadAdminData()
    {
        // Total statistik
        $this->totalSiswa = Murid::count();
        $this->totalGuru = User::where('type', 'guru')->count();
        $this->totalKelas = Kelas::count();
        $this->totalPPDB = PPDB::count();
        
        // Recent PPDB applications
        $this->recentPPDB = PPDB::latest()
            ->take(5)
            ->get();
    }

    private function loadGuruData()
    {
        $userId = Auth::id();
        
        // Ambil kelas yang diajar guru
        $this->kelasGuru = Kelas::where('guru_id', $userId)->first();
        
        if ($this->kelasGuru) {
            // Jumlah siswa di kelas
            $this->jumlahSiswa = Murid::where('kelas_id', $this->kelasGuru->id)->count();
            
            // Data absensi hari ini
            $today = Carbon::today();
            $absensiHariIni = Absensi::whereDate('tanggal', $today)
            ->where('kelas_id', $this->kelasGuru->id)
            ->first();
        
        if ($absensiHariIni && $absensiHariIni->murid_data) {
            $muridData = collect($absensiHariIni->murid_data);
            $this->hadirHariIni = $muridData->filter(function($status) {
                return $status === 'hadir';
            })->count();
            
            $this->tidakHadir = $muridData->filter(function($status) {
                return in_array($status, ['sakit', 'izin', 'alpha']);
            })->count();
        } else {
            $this->hadirHariIni = 0;
            $this->tidakHadir = 0;
        }
        
                
            // $this->hadirHariIni = $absensiHariIni->where('status', 'hadir')->count();
            // $this->tidakHadir = $absensiHariIni->whereIn('status', ['sakit', 'izin', 'alpha'])->count();
            
            // Siswa di kelas
            $this->siswaDiKelas = Murid::where('kelas_id', $this->kelasGuru->id)->get();
            
            // Jadwal hari ini
            $this->loadJadwalHariIni();
        }
    }

    private function getHariIndonesia()
{
    $hari = [
        'Sunday' => 'minggu',
        'Monday' => 'senin',
        'Tuesday' => 'selasa',
        'Wednesday' => 'rabu',
        'Thursday' => 'kamis',
        'Friday' => 'jumat',
        'Saturday' => 'sabtu'
    ];
    
    return $hari[Carbon::now()->format('l')];
}


    private function loadJadwalHariIni()
    {
        if (!$this->kelasGuru) return;
        
        $hariIni = $this->getHariIndonesia();
        
        $jadwalPelajaran = JadwalPelajaran::where('kelas_id', $this->kelasGuru->id)
            ->where('guru_id', Auth::id())
            ->first();
            
        if ($jadwalPelajaran && $jadwalPelajaran->jadwal) {
            $jadwal = json_decode($jadwalPelajaran->jadwal, true);
            
            if (isset($jadwal[$hariIni])) {
                $this->jadwalHariIni = collect($jadwal[$hariIni])->map(function($item) {
                    $mataPelajaran = MataPelajaran::find($item['mapel_id']);
                    return [
                        'jam' => $item['jam'],
                        'mata_pelajaran' => $mataPelajaran ? $mataPelajaran->nama : 'Tidak diketahui',
                        'kelas' => $this->kelasGuru->nama
                    ];
                })->toArray();
            }
        }
    }

    private function loadOrangTuaData()
    {
        $userId = Auth::id();
        
        // Ambil data anak-anak
        $this->anakSiswa = Murid::where('orangtua_id', $userId)
            ->with(['kelas'])
            ->get()
            ->map(function($anak) {
                // Hitung kehadiran bulan ini
                $startOfMonth = Carbon::now()->startOfMonth();
                $endOfMonth = Carbon::now()->endOfMonth();
                
                $absensi = Absensi::where('murid_id', $anak->id)
                    ->whereBetween('tanggal', [$startOfMonth, $endOfMonth])
                    ->get();
                    
                $anak->kehadiran_bulan_ini = $absensi->where('status', 'hadir')->count();
                $anak->tidak_hadir_bulan_ini = $absensi->whereIn('status', ['sakit', 'izin', 'alpha'])->count();
                
                // Ambil nilai terbaru
                $anak->nilai_terbaru = Nilai::where('murid_id', $anak->id)
                    ->with(['mataPelajaran'])
                    ->latest()
                    ->take(3)
                    ->get()
                    ->map(function($nilai) {
                        return (object)[
                            'mata_pelajaran' => $nilai->mataPelajaran->nama ?? 'Tidak diketahui',
                            'nilai' => $nilai->nilai
                        ];
                    });
                return $anak;
            });
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
