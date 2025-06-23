<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;
use App\Models\User;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua guru yang sudah dibuat
        $gurus = User::where('type', 'guru')->get();

        // Buat 6 kelas, 1 guru per kelas
        for ($i = 1; $i <= 6; $i++) {
            Kelas::create([
                'nama' => "$i",
                'guru_id' => $gurus[$i - 1]->id ?? null,
            ]);
        }
    }
}