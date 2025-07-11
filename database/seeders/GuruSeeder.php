<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GuruSeeder extends Seeder
{
    public function run()
    {
        $guruData = [
            ['nama' => 'Ustadzah Wiwin', 'kelas' => 1],
            ['nama' => 'Ustadzah Salsa', 'kelas' => 2],
            ['nama' => 'Ustadz Nanang', 'kelas' => 3],
            ['nama' => 'Ustadzah Irma', 'kelas' => 4],
            ['nama' => 'Ustadz Hilmi', 'kelas' => 5],
            ['nama' => 'Ustadz Rahmat', 'kelas' => 6],
        ];

        $gelar = ['S.Pd.I', 'S.Pd', 'S.Ag', 'M.Pd', 'M.Ag', 'S.Hum'];

        foreach ($guruData as $data) {
            $namaGuru = $data['nama'];
            $namaLengkap = $namaGuru . ', ' . $gelar[array_rand($gelar)];

            // Buat email dari nama guru, semua huruf kecil dan tanpa spasi
            $email = Str::slug($namaGuru, '') . '@siakad.test';

            $guru = User::create([
                'name' => $namaLengkap,
                'email' => $email,
                'password' => Hash::make('password'),
                'type' => 'guru',
            ]);

            $guru->assignRole('guru');

            // Asosiasikan guru ke kelas (jika model Kelas tersedia)
            Kelas::create([
                'nama' => $data['kelas'],
                'guru_id' => $guru->id,
            ]);
        }
    }
}
