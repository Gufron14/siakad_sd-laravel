<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MataPelajaran;

class MataPelajaranSeeder extends Seeder
{
    public function run(): void
    {
        $mapel = [
            // Kelas 1 & 2
            "Al-Qur'an", "Iqro", "Ahlak", "Fiqih", "B. Arab", "Praktek", "Hapalan Juz Ama", "Do'a - Do'a",
            // Kelas 3 & 4
            "Al-Qur'an M. 1/3", "Hadis M. 2/4", "Baca Al-Qur'an", "Aqidah 1.3", "Ahlak 2.4", "SKI M. 1.3", "B. Arab M. 2.4", "Tajwid", "Juz Ama Hapalan"
        ];

        foreach (array_unique($mapel) as $nama) {
            MataPelajaran::firstOrCreate(['nama' => $nama]);
        }
    }
}