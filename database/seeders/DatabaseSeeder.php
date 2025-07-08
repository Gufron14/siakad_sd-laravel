<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            GuruSeeder::class,
            // OrangTuaSeeder::class,
            KelasSeeder::class,
            MataPelajaranSeeder::class,
            JadwalPelajaranSeeder::class,
            MuridSeeder::class,
            // NilaiSeeder::class,
        ]);
    }
}
