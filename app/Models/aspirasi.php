<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class aspirasi extends Model
{
    protected $fillable = [
        'nis',
        'id_kategori',
        'lokasi',
        'keterangan',
        'status',
        'feedback'
    ];
    protected $primaryKey = 'nis'; // Beritahu Laravel PK-nya NIS
    public $incrementing = false; // Karena NIS biasanya bukan auto-increment


}