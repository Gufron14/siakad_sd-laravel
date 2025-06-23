<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $gelar = ['S.Pd.I', 'S.Pd', 'S.Ag', 'M.Pd', 'M.Ag', 'S.Hum'];
        for ($i = 1; $i <= 6; $i++) {
            $nama = $faker->name . ', ' . $gelar[array_rand($gelar)];
            $guru = User::create([
                'name' => $nama,
                'email' => "guru$i@siakad.test",
                'password' => Hash::make('password'),
                'type' => 'guru',
            ]);
            $guru->assignRole('guru');
        }
    }
}