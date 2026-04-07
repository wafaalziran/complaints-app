<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class aspirasi extends Model
{

    protected $table = 'aspirasis';
    
    protected $fillable = [
        'nis',          // Nomor Induk Siswa
        'id_kategori',  // ID Kategori (FK)
        'lokasi',       // Lokasi Kejadian
        'keterangan',   // Isi Laporan
        'status',       // Status (Menunggu/Proses/Selesai)
        'feedback',     // Rating Urgensi Masalah
        'pesan_admin'   // Pesan Admin
    ];
}