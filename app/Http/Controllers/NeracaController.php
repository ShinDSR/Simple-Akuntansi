<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurnal;
use App\Models\Akun;

class NeracaController extends Controller
{
    public function index()
    {
        $list_neraca = Jurnal::selectRaw("CONCAT(MONTH(tgl_transaksi), '-', YEAR(tgl_transaksi)) as tanggal")
            ->distinct()
            ->get();
        $total_neraca = $list_neraca->count();
        return view('neraca.index', compact('list_neraca', 'total_neraca'));
    }

    public function detail(Request $request, $tanggal)
    {
        if(empty($tanggal)) return redirect('neraca.index');

        $total_akun = Akun::all()->count();

        $bulan = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));
        $periode = date('F Y', strtotime($tanggal));

        $total_saldo_debet = 0;
        $total_saldo_kredit = 0;

        for($i = 1; $i <= $total_akun; $i++){

            $daftar_buku[$i] = Jurnal::whereMonth('tgl_transaksi', $bulan)
                ->whereYear('tgl_transaksi', $tahun)
                ->orderBy('tgl_transaksi', 'asc')
                ->where('akun_id', $i)
                ->get();

            $total_debet[$i] = Jurnal::where('tipe_transaksi', 'd')
                ->whereMonth('tgl_transaksi', $bulan)
                ->whereYear('tgl_transaksi', $tahun)
                ->orderBy('tgl_transaksi', 'asc')
                ->where('akun_id', $i)
                ->sum('nominal');

            $total_kredit[$i] = Jurnal::where('tipe_transaksi', 'k')
                ->whereMonth('tgl_transaksi', $bulan)
                ->whereYear('tgl_transaksi', $tahun)
                ->orderBy('tgl_transaksi', 'asc')
                ->where('akun_id', $i)
                ->sum('nominal');

            $akun[$i] = Akun::findOrFail($i);

            if( substr($akun[$i]->kode_akun, 0, 1) === '1' ||  substr($akun[$i]->kode_akun, 0, 1) === '4'){
                $debet[$i] = $total_debet[$i] - $total_kredit[$i];
                $kredit[$i] = 0;
            }elseif( substr($akun[$i]->kode_akun, 0, 1) === '2' ||  substr($akun[$i]->kode_akun, 0, 1) === '3' || substr($akun[$i]->kode_akun, 0, 1) === '5'){
                $kredit[$i] = $total_kredit[$i] - $total_debet[$i];
                $debet[$i] = 0;
            }

            $data[$i] = [
                'kode_akun' => $akun[$i]->kode_akun,
                'nama_akun' => $akun[$i]->nama_akun,
                'debet' => $debet[$i],
                'kredit' => $kredit[$i],
            ];

            $total_saldo_debet += $data[$i]['debet'];
            $total_saldo_kredit += $data[$i]['kredit'];
        }
        return view('neraca.detail', compact('data', 'total_saldo_debet', 'total_saldo_kredit', 'periode'));
    }

    public function print($tanggal){
        
    }
}