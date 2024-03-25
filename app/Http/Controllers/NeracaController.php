<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Akun;
use App\Models\Jurnal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NeracaController extends Controller
{
    public function index()
    {
        $jurnals = Jurnal::with('akun')
            ->get()
            ->groupBy(function ($val) {
                return Carbon::parse($val->tgl_transaksi)
                    ->format('F Y');
            });
        return view('neraca.index', [
            'jurnal' => $jurnals,
        ]);
    }

    // public function detail(Request $request, $tanggal)
    // {
    //     if (empty($tanggal)) {
    //         return redirect()->route('neraca.index');
    //     }
    
    //     $bulan = date('m', strtotime($tanggal));
    //     $tahun = date('Y', strtotime($tanggal));
    //     $periode = date('F Y', strtotime($tanggal));
    
    //     $akuns = Akun::all();
    
    //     $jurnals = Jurnal::select('akun_id', DB::raw('MAX(id) as id'))
    //         ->whereMonth('tgl_transaksi', $bulan)
    //         ->whereYear('tgl_transaksi', $tahun)
    //         ->groupBy('akun_id')
    //         ->orderBy('akun_id', 'asc')
    //         ->get();
    
    //     $jurnal_ids = $jurnals->pluck('id');
    
    //     $jurnal_details = Jurnal::whereIn('id', $jurnal_ids)
    //         ->with('akun')
    //         ->get();
    
    //     $total_debet = Jurnal::where('tipe_transaksi', 'd')
    //         ->whereIn('id', $jurnal_ids)
    //         ->sum('nominal');
    
    //     $total_kredit = Jurnal::where('tipe_transaksi', 'k')
    //         ->whereIn('id', $jurnal_ids)
    //         ->sum('nominal');
    
    //     $saldo = $total_debet - $total_kredit;
    
    //     return view('neraca.detail', compact('jurnal_details', 'periode', 'total_debet', 'total_kredit', 'saldo'));
    // }

    // public function detail(Request $request, $tanggal)
    // {
    //     if (empty($tanggal)) {
    //         return redirect()->route('neraca.index');
    //     }

    //     $bulan = date('m', strtotime($tanggal));
    //     $tahun = date('Y', strtotime($tanggal));
    //     $periode = date('F Y', strtotime($tanggal));

    //     $akuns = Akun::all();

    //     $jurnals = Jurnal::whereMonth('tgl_transaksi', $bulan)
    //         ->whereYear('tgl_transaksi', $tahun)
    //         ->with('akun')
    //         ->groupBy('akun_id')
    //         ->orderBy('akun_id', 'asc')
    //         ->get();
    //     $total_debet = Jurnal::where('tipe_transaksi', 'd')
    //         ->whereMonth('tgl_transaksi', $bulan)
    //         ->whereYear('tgl_transaksi', $tahun)
    //         ->with('akun')
    //         ->orderBy('akun_id', 'asc')
    //         ->sum('nominal');
    //     $total_kredit = Jurnal::where('tipe_transaksi', 'k')
    //         ->whereMonth('tgl_transaksi', $bulan)
    //         ->whereYear('tgl_transaksi', $tahun)
    //         ->with('akun')
    //         ->orderBy('akun_id', 'asc')
    //         ->sum('nominal');

    //     $saldo = $total_debet - $total_kredit;

    //     return view('neraca.detail', compact('jurnals', 'periode', 'total_debet', 'total_kredit', 'saldo'));

    // }

}
