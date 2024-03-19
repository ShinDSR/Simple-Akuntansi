<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Akun;
use App\Models\Jurnal;

class BukuBesarController extends Controller
{
    public function index(){
        $akuns = Akun::all();
        return view('bukubesar.index', compact('akuns'));
    }

    public function show(Akun $akun){
        $list_buku = Jurnal::selectRaw("CONCAT(MONTH(tgl_transaksi), '-', YEAR(tgl_transaksi)) as tanggal")
            ->where('akun_id', $akun->id)
            ->distinct()
            ->get();
        $total_buku = $list_buku->count();
        return view('bukubesar.show', compact('list_buku', 'total_buku', 'akun'));
    }

    public function detail(Akun $akun, $tanggal){
        if(empty($tanggal) || empty($akun)) return redirect()->route('bukubesar.index');

        $bulan = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));
        $periode = date('F Y', strtotime($tanggal));

        $list_buku = Jurnal::where('akun_id', $akun->id)
            ->whereMonth('tgl_transaksi', $bulan)
            ->whereYear('tgl_transaksi', $tahun)
            ->orderBy('tgl_transaksi', 'asc')
            ->get();

        $total_debet = Jurnal::where('tipe_transaksi', 'd')
            ->where('akun_id', $akun->id)
            ->whereMonth('tgl_transaksi', $bulan)
            ->whereYear('tgl_transaksi', $tahun)
            ->orderBy('tgl_transaksi', 'asc')
            ->sum('nominal');

        $total_kredit = Jurnal::where('tipe_transaksi', 'k')
            ->where('akun_id', $akun->id)
            ->whereMonth('tgl_transaksi', $bulan)
            ->whereYear('tgl_transaksi', $tahun)
            ->orderBy('tgl_transaksi', 'asc')
            ->sum('nominal');
        
        $total_buku = $list_buku->count();

        return view('bukubesar.detail', compact('list_buku', 'total_buku', 'periode', 'total_debet', 'total_kredit', 'akun'));
    }
}
