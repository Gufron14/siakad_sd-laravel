<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class OrangTuaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        for ($i = 1; $i <= 40; $i++) {
            $ortu = User::create([
                'name' => $faker->name,
                'email' => "ortu$i@siakad.test",
                'password' => Hash::make('password'),
                'type' => 'orangtua',
            ]);
            $ortu->assignRole('orangtua');
        }
    }
}