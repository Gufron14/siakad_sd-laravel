<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JadwalPelajaran;
use App\Models\MataPelajaran;
use App\Models\Kelas;
use App\Models\User;

class JadwalPelajaranSeeder extends Seeder
{
    public function run(): void
    {
        // Jadwal untuk kelas 1 & 2
        $jadwal12 = [
            'Senin'   => ["Al-Qur'an", "Iqro"],
            'Selasa'  => ["Ahlak", "Iqro"],
            'Rabu'    => ["Fiqih", "Iqro"],
            'Kamis'   => ["B. Arab", "Iqro"],
            'Jum\'at' => ["Praktek", "Hapalan Juz Ama"],
            'Sabtu'   => ["Do'a - Do'a", "Iqro"],
        ];

        // Jadwal untuk kelas 3 & 4
        $jadwal34 = [
            'Senin'   => ["Al-Qur'an M. 1/3", "Hadis M. 2/4", "Baca Al-Qur'an"],
            'Selasa'  => ["Aqidah 1.3", "Ahlak 2.4", "Baca Al-Qur'an"],
            'Rabu'    => ["Fiqih", "Do'a - Do'a"],
            'Kamis'   => ["SKI M. 1.3", "B. Arab M. 2.4", "Baca Al-Qur'an"],
            'Jum\'at' => ["Praktek", "Hapalan Juz Ama"],
            'Sabtu'   => ["Tajwid", "Juz Ama Hapalan"],
        ];

        // Ambil kelas dan guru
        $kelas = Kelas::all();
        foreach ($kelas as $kls) {
            $isKelas12 = in_array($kls->nama, ['1', '2']);
            $jadwal = $isKelas12 ? $jadwal12 : $jadwal34;
            $guruId = $kls->guru_id;

            foreach ($jadwal as $hari => $mapels) {
                foreach ($mapels as $mapel) {
                    $mapelId = MataPelajaran::where('nama', $mapel)->first()->id ?? null;
                    if ($mapelId) {
                        JadwalPelajaran::create([
                            'kelas_id' => $kls->id,
                            'mata_pelajaran_id' => $mapelId,
                            'guru_id' => $guruId,
                            'hari' => $hari,
                            'jam' => '07:00-08:00', // contoh jam
                        ]);
                    }
                }
            }
        }
    }
}