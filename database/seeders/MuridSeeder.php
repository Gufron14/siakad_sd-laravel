<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Murid;
use App\Models\Kelas;
use App\Models\User;
use Faker\Factory as Faker;

class MuridSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $kelas = Kelas::all();
        $ortu = User::where('type', 'orangtua')->pluck('id')->toArray();

        for ($i = 1; $i <= 100; $i++) {
            Murid::create([
                'nama' => $faker->name,
                'kelas_id' => $kelas->random()->id,
                'orangtua_id' => $faker->randomElement($ortu),
            ]);
        }
    }
}