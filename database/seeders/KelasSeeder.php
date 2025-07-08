<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{
    public function run()
    {
        $kelas = ['1', '2', '3', '4', '5', '6'];
        
        foreach ($kelas as $tingkat) {
            Kelas::create([
                'nama' => $tingkat,
                'guru_id' => null
            ]);
        }
    }
}
