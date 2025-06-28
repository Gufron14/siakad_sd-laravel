<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\JadwalPelajaran;

class JadwalPelajaranSeeder extends Seeder
{
    public function run(): void
    {
        $jadwal = [
            '1' => [ 'jam' => '13:00-14:00', 'Senin' => ['Alquran', 'Iqro'], 'Selasa' => ['Akhlaq', 'Iqro'], 'Rabu' => ['Fiqih', 'Iqro'], 'Kamis' => ['B.Arab', 'Iqro'], 'Jum\'at' => ['Praktek', 'Hafalan Juz Amma'], 'Sabtu' => ['Doa-Doa', 'Iqro'], ],
            '2' => [ 'jam' => '13:00-14:00', 'Senin' => ['Alquran', 'Iqro'], 'Selasa' => ['Akhlaq', 'Iqro'], 'Rabu' => ['Fiqih', 'Iqro'], 'Kamis' => ['B.Arab', 'Iqro'], 'Jum\'at' => ['Praktek', 'Hafalan Juz Amma'], 'Sabtu' => ['Doa-Doa', 'Iqro'], ],
            '3' => [ 'jam' => '14:00-15:00', 'Senin' => ['Al Quran', 'Hadist'], 'Selasa' => ['Akidah', 'Akhlaq', 'Alquran'], 'Rabu' => ['Fiqih', 'Doa-Doa'], 'Kamis' => ['SKI', 'B.Arab', 'Al Quran'], 'Jum\'at' => ['Praktek', 'Hafalan Juz Amma'], 'Sabtu' => ['Tajwid', 'Hafalan Juz Amma'], ],
            '4' => [ 'jam' => '14:00-15:00', 'Senin' => ['Al Quran', 'Hadist'], 'Selasa' => ['Akidah', 'Akhlaq', 'Alquran'], 'Rabu' => ['Fiqih', 'Doa-Doa'], 'Kamis' => ['SKI', 'B.Arab', 'Al Quran'], 'Jum\'at' => ['Praktek', 'Hafalan Juz Amma'], 'Sabtu' => ['Tajwid', 'Hafalan Juz Amma'], ],
            '5' => [ 'jam' => '15:30-16:30', 'Senin' => ['Al Quran', 'Hadist'], 'Selasa' => ['Akidah', 'Akhlaq', 'Alquran'], 'Rabu' => ['Fiqih', 'Tarikh Islam'], 'Kamis' => ['SKI', 'B.Arab', 'Al Quran'], 'Jum\'at' => ['Praktek', 'Hafalan Juz Amma'], 'Sabtu' => ['Tajwid', 'Hafalan Juz Amma'], ],
            '6' => [ 'jam' => '15:30-16:30', 'Senin' => ['Al Quran', 'Hadist'], 'Selasa' => ['Akidah', 'Akhlaq', 'Alquran'], 'Rabu' => ['Fiqih', 'Tarikh Islam'], 'Kamis' => ['SKI', 'B.Arab', 'Al Quran'], 'Jum\'at' => ['Praktek', 'Hafalan Juz Amma'], 'Sabtu' => ['Tajwid', 'Hafalan Juz Amma'], ],
        ];

        $kelasList = Kelas::all();

        foreach ($kelasList as $kls) {
            $namaKelas = $kls->nama;
            if (!isset($jadwal[$namaKelas])) continue;

            $jadwalKelas = $jadwal[$namaKelas];
            $jam = $jadwalKelas['jam'];
            $guruId = $kls->guru_id;
            $dataJadwal = [];

            foreach ($jadwalKelas as $hari => $mapels) {
                if ($hari === 'jam') continue;

                foreach ($mapels as $mapelNama) {
                    $mapel = MataPelajaran::where('nama', $mapelNama)->first();
                    if (!$mapel) continue;

                    $dataJadwal[$hari][] = [
                        'jam' => $jam,
                        'mata_pelajaran_id' => $mapel->id,
                    ];
                }
            }

            JadwalPelajaran::create([
                'kelas_id' => $kls->id,
                'guru_id' => $guruId,
                'jadwal' => json_encode($dataJadwal),
            ]);
        }
    }
}
