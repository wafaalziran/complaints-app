<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kategori')->insert([
        ['id_kategori' => 1, 'ket_kategori' => 'Fasilitas Rusak'],
        ['id_kategori' => 2, 'ket_kategori' => 'Kebersihan'],
        ['id_kategori' => 3, 'ket_kategori' => 'Keamanan'],
    ]);
    }
}
