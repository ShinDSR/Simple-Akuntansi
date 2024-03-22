<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_perusahaan',
        'alamat',
        'no_telp',
        'email',
        'tgl_berdiri',
    ];

    protected $casts = [
        'tgl_berdiri' => 'datetime',
    ];
}
