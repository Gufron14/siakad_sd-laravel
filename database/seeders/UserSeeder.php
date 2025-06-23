<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1 Admin
        $admin = User::create([
            'name' => 'Admin SIAKAD',
            'email' => 'admin@siakad.test',
            'password' => Hash::make('password'),
            'type' => 'admin',
        ]);
        $admin->assignRole('admin');

        // for ($i = 1; $i <= 6; $i++) {
        //     $guru = User::create([
        //         'name' => "Guru Kelas $i",
        //         'email' => "guru$i@siakad.test",
        //         'password' => Hash::make('password'),
        //         'type' => 'guru',
        //     ]);
        //     $guru->assignRole('guru');
        // }

        // for ($i = 1; $i <= 10; $i++) {
        //     $ortu = User::create([
        //         'name' => "Orang Tua $i",
        //         'email' => "ortu$i@siakad.test",
        //         'password' => Hash::make('password'),
        //         'type' => 'orangtua',
        //     ]);
        //     $ortu->assignRole('orangtua');
        // }
    }
}