<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Akun;
use App\Models\Jurnal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Office;

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
            'kode_akun' => '100',
            'user_id' => 1,
            'nama_akun' => 'Kas',
        ]);

        Akun::create([
            'kode_akun' => '110',
            'user_id' => 1,
            'nama_akun' => 'Piutang Usaha',
        ]);

        Akun::create([
            'kode_akun' => '120',
            'user_id' => 1,
            'nama_akun' => 'Perlengkapan',
        ]);

        Akun::create([
            'kode_akun' => '200',
            'user_id' => 1,
            'nama_akun' => 'Utang Usaha',
        ]);

        Akun::create([
            'kode_akun' => '210',
            'user_id' => 1,
            'nama_akun' => 'Modal',
        ]);

        Akun::create([
            'kode_akun' => '300',
            'user_id' => 1,
            'nama_akun' => 'Pendapatan',
        ]);

        Akun::create([
            'kode_akun' => '400',
            'user_id' => 1,
            'nama_akun' => 'Beban',
        ]);

        Jurnal::create([
            'tgl_transaksi' => '2022-03-14',
            'akun_id' => 1,
            'nominal' => 100000,
            'keterangan' => 'Pembelian Buku',
            'tipe_transaksi' => 'd',
        ]);

        Office::create([
            'nama_perusahaan' => 'PT. Maju Mundur',
            'alamat' => 'Jl. Raya No. 1',
            'no_telp' => '08123456789',
            'email' => 'mamu@gmail.com',
            'tgl_berdiri' => '2022-03-14',
        ]);
    }
}
