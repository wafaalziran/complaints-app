<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $semuaSiswa = DB::table('siswa')->get();

        foreach ($semuaSiswa as $siswa) {

            \App\Models\User::create([
                'name' => 'budi',
                'email' => 'budi@school.com',
                'nis' => $siswa->nis,
                'password' => Hash::make('siswa'), // Password default
                'role' => 'siswa',
            ]);

             \App\Models\User::create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'nis' => '',
                'password' => Hash::make('admin'), // Password default
                'role' => 'admin',
            ]);
        }
    }
}
