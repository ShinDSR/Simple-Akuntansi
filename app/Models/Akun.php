<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_akun',
        'user_id',
        'nama_akun',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jurnal()
    {
        return $this->hasMany(Jurnal::class);
    }
}
