<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MataPelajaran;

class MataPelajaranSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus semua mata pelajaran yang ada (dengan menghapus jadwal terlebih dahulu)
        \App\Models\JadwalPelajaran::query()->delete();
        MataPelajaran::query()->delete();
        
        // Mata pelajaran untuk kelas 1 & 2
        $mapelKelas12 = [
            "Al-Qur'an", "Iqro", "Ahlak", "Fiqih", "B. Arab", "Praktek", "Hapalan Juz Ama", "Do'a - Do'a"
        ];
        
        // Mata pelajaran untuk kelas 3, 4, 5, dan 6
        $mapelKelas3456 = [
            "Al-Qur'an M. 1/3", "Hadis M. 2/4", "Baca Al-Qur'an", "Aqidah 1.3", 
            "Ahlak 2.4", "SKI M. 1.3", "B. Arab M. 2.4", "Tajwid", "Juz Ama Hapalan"
        ];

        // Ambil kelas yang ada
        $kelasIds = \App\Models\Kelas::pluck('id', 'nama');
        
        // Buat mata pelajaran untuk kelas 1 & 2
        foreach (['1', '2'] as $namaKelas) {
            if (isset($kelasIds[$namaKelas])) {
                foreach ($mapelKelas12 as $nama) {
                    MataPelajaran::create([
                        'nama' => $nama,
                        'kelas_id' => $kelasIds[$namaKelas]
                    ]);
                }
            }
        }
        
        // Buat mata pelajaran untuk kelas 3, 4, 5, 6
        foreach (['3', '4', '5', '6'] as $namaKelas) {
            if (isset($kelasIds[$namaKelas])) {
                foreach ($mapelKelas3456 as $nama) {
                    MataPelajaran::create([
                        'nama' => $nama,
                        'kelas_id' => $kelasIds[$namaKelas]
                    ]);
                }
            }
        }
    }
}