<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class siswa extends Model
{

public function siswa()
    {
        // Aspirasi dimiliki oleh satu siswa
        return $this->belongsTo(aspirasi::class, 'nis', 'nis');
    }
}
