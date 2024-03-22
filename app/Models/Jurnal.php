<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    use HasFactory;

    protected $fillable = [
        'tgl_transaksi',
        'akun_id',
        'nominal',
        'keterangan',
        'tipe_transaksi',
    ];

    protected $casts = [
        'tgl_transaksi' => 'datetime',
    ];

    public function akun()
    {
        return $this->belongsTo(Akun::class);
    }
}
