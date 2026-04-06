<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class aspirasi extends Model
{
    // Nama tabel di database
    protected $table = 'aspirasis';
    
    // Kolom yang boleh diisi
    protected $fillable = [
        'nis',          // Nomor Induk Siswa
        'id_kategori',  // ID Kategori (FK)
        'lokasi',       // Lokasi Kejadian
        'keterangan',   // Isi Laporan
        'status',       // Status (Menunggu/Proses/Selesai)
        'feedback'      // Rating/Tanggapan Admin
    ];
}