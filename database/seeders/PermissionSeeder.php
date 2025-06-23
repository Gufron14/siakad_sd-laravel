<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Admin
            'crud guru',
            'crud kelas',
            'crud murid',
            'crud ppdb',

            // Guru
            'input nilai',
            'input absensi',
            'lihat raport',
            'lihat jadwal',
            'lihat mapel',

            // Orang Tua
            'lihat nilai anak',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

                // Assign permissions to roles
        $admin = Role::where('name', 'admin')->first();
        $guru = Role::where('name', 'guru')->first();
        $orangtua = Role::where('name', 'orangtua')->first();

        // Admin: semua permission
        $admin->syncPermissions($permissions);

        // Guru: hanya permission guru
        $guru->syncPermissions([
            'input nilai',
            'input absensi',
            'lihat raport',
            'lihat jadwal',
            'lihat mapel',
        ]);

        // Orang Tua: hanya permission orang tua
        $orangtua->syncPermissions([
            'lihat nilai anak',
        ]);
    }
}