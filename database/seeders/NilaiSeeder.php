<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Nilai;
use App\Models\Murid;
use App\Models\JadwalPelajaran;
use App\Models\MataPelajaran;
use App\Models\User;

class NilaiSeeder extends Seeder
{
    public function run(): void
    {
        $murids = Murid::all();
        foreach ($murids as $murid) {
            // Ambil semua mapel di kelas murid
            $jadwals = JadwalPelajaran::where('kelas_id', $murid->kelas_id)->get();
            foreach ($jadwals as $jadwal) {
                Nilai::create([
                    'murid_id' => $murid->id,
                    'mata_pelajaran_id' => $jadwal->mata_pelajaran_id,
                    'guru_id' => $jadwal->guru_id,
                    'semester' => '1',
                    // 'nilai_tugas' => rand(70, 100),
                    'nilai_ujian' => rand(70, 100),
                    'tahun' => date('Y') . '/' . (date('Y') + 1),
                ]);
            }
        }
    }
}