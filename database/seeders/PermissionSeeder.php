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

            // Staff SPMB
            'create.ppdb',
            'edit.ppdb',
            'delete.ppdb',
            'lihat.ppdb',

            // Guru
            'input.nilai',
            'input.absensi',
            'lihat.raport',
            'cetak.raport',

            
            // Admin
            'create.jadwal',
            'edit.jadwal',
            'delete.jadwal',
            'lihat.jadwal',

            'create.mapel',
            'edit.mapel',
            'delete.mapel',
            'lihat.mapel',

            'create.guru',
            'edit.guru',
            'delete.guru',
            'lihat.guru',

            'create.siswa',
            'edit.siswa',
            'delete.siswa',
            'lihat.siswa',


        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to roles
        $admin = Role::where('name', 'admin')->first();
        $guru = Role::where('name', 'guru')->first();
        $staff = Role::where('name', 'staff')->first();

        // Admin: semua permission
        $admin->syncPermissions($permissions);

        // Staff: permission staff + lihat jadwal
        $staff->syncPermissions([
            'create.ppdb',
            'edit.ppdb',
            'delete.ppdb',
            'lihat.ppdb',
            'lihat.jadwal',
        ]);

        // Guru: permission guru + lihat jadwal
        $guru->syncPermissions([
            'input.nilai',
            'input.absensi',
            'lihat.raport',
            'cetak.raport',
            'lihat.jadwal',
        ]);
    }
}