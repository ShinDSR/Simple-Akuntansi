<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Akun;
use App\Models\Jurnal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin01@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            // 'is_admin' => true,
            'remember_token' => Str::random(10),
        ]);

        Akun::create([
            'kode_akun' => 'KA001',
            'user_id' => 1,
            'nama_akun' => 'Kas',
        ]);

        Akun::create([
            'kode_akun' => 'KA002',
            'user_id' => 1,
            'nama_akun' => 'Bank',
        ]);

        Jurnal::create([
            'tgl_transaksi' => '2022-03-14',
            'akun_id' => 1,
            'nominal' => 100000,
            'keterangan' => 'Pembelian Buku',
            'tipe_transaksi' => 'd',
        ]);
    }
}
