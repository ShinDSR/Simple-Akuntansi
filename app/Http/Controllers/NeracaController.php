<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurnal;
use App\Models\Akun;

class NeracaController extends Controller
{
    public function index(){
        $list_neraca = Jurnal::selectRaw("CONCAT(MONTH(tgl_transaksi), '-', YEAR(tgl_transaksi)) as tanggal")
            ->distinct()
            ->get();
        $total_neraca = $list_neraca->count();
        return view('neraca.index', compact('list_neraca', 'total_neraca'));
    }

    public function detail(Request $request, $tanggal){
        if(empty($tanggal)) return redirect()->route('neraca.index');

        $akuns = Akun::all()->count();
        
        $bulan = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));    
        $periode = date('F Y', strtotime($tanggal));

        $total_saldo_debet = 0;
        $total_saldo_kredit = 0;

        for($i = 1; $i <= $akuns; $i++){
            $list_buku = Jurnal::where('akun_id', $i)
                ->whereMonth('tgl_transaksi', $bulan)
                ->whereYear('tgl_transaksi', $tahun)
                ->orderBy('tgl_transaksi', 'asc')
                ->get();

            $saldo_debet = Jurnal::where('akun_id', $i)
                ->where('tipe_transaksi', 'd')
                ->whereMonth('tgl_transaksi', $bulan)
                ->whereYear('tgl_transaksi', $tahun)
                ->orderBy('', 'asc')
                ->sum('nominal');

            $saldo_kredit = Jurnal::where('akun_id', $i)
                ->where('tipe_transaksi', 'k')
                ->whereMonth('tgl_transaksi', $bulan)
                ->whereYear('tgl_transaksi', $tahun)
                ->orderBy('tgl_transaksi', 'asc')
                ->sum('nominal');

            $akun[$i] = Akun::findOrFail($i);

            if(substr($akun[$i]->kode, 0, 1) == 1 || substr($akun[$i]->kode, 0, 1) == 4){
                $total_saldo_debet += $saldo_debet;
                $total_saldo_kredit += $saldo_kredit;
            }
            elseif(substr($akun[$i]->kode, 0, 1) == 2 || substr($akun[$i]->kode, 0, 1) == 3 || substr($akun[$i]->kode, 0, 1) == 5 ){
                $total_saldo_debet += $saldo_kredit;
                $total_saldo_kredit += $saldo_debet;
            }
        }
        return view('neraca.detail');
    }
}
