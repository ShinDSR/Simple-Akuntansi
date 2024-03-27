<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Jurnal;
use Illuminate\Http\Request;
use Carbon\Carbon;

class NeracaController extends Controller
{
    public function index()
    {
        $jurnals = Jurnal::get()
            ->groupBy(function ($val) {
                return Carbon::parse($val->tgl_transaksi)
                    ->format('F Y');
            });
        // dd($jurnals->toArray());

        return view('neraca.index', [
            'jurnal' => $jurnals,
        ]);
    }

    public function detail(Request $request, $tanggal)
    {
        if (empty($tanggal)) return redirect('neraca.index');

        $periode = date('F Y', strtotime($tanggal));
        $bulan = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));

        // Mendapatkan total debet dan kredit untuk setiap akun dalam satu kueri
        $jurnals = Akun::leftJoin('jurnals', function ($join) use ($bulan, $tahun) {
            $join->on('akuns.id', '=', 'jurnals.akun_id')
                ->whereMonth('jurnals.tgl_transaksi', $bulan)
                ->whereYear('jurnals.tgl_transaksi', $tahun);
        })
            ->select(
                'akuns.id',
                'akuns.kode_akun',
                'akuns.nama_akun',
                \DB::raw('IFNULL(SUM(CASE WHEN jurnals.tipe_transaksi = "d" THEN jurnals.nominal ELSE 0 END), 0) AS total_debet'),
                \DB::raw('IFNULL(SUM(CASE WHEN jurnals.tipe_transaksi = "k" THEN jurnals.nominal ELSE 0 END), 0) AS total_kredit')
            )
            ->groupBy('akuns.id', 'akuns.kode_akun', 'akuns.nama_akun')
            ->get();

        $data = [];
        $total_saldo_aktiva = 0;
        $total_saldo_pasiva = 0;

        foreach ($jurnals as $jurnal) {
            // Menghitung saldo sesuai dengan kode akun
            if (substr($jurnal->kode_akun, 0, 1) === '1' || substr($jurnal->kode_akun, 0, 1) === '2' || substr($jurnal->kode_akun, 0, 1) === '4' || substr($jurnal->kode_akun, 0, 1) === '5'){
                $aktiva = $jurnal->total_debet;
                $pasiva = $jurnal->total_kredit;
            } elseif (substr($jurnal->kode_akun, 0, 1) === '3' || substr($jurnal->kode_akun, 0, 1) === '6' || substr($jurnal->kode_akun, 0, 1) === '7' || substr($jurnal->kode_akun, 0, 1) === '8'){
                $pasiva = $jurnal->total_kredit;
                $aktiva = $jurnal->total_debet;
            }

            // Menyimpan data akun
            $data[] = [
                'kode_akun' => $jurnal->kode_akun,
                'nama_akun' => $jurnal->nama_akun,
                'aktiva' => $aktiva,
                'pasiva' => $pasiva,
            ];

            // Menambahkan saldo ke total saldo aktiva dan pasiva
            $total_saldo_aktiva += $aktiva;
            $total_saldo_pasiva += $pasiva;
        }

        return view('neraca.detail', compact('data', 'total_saldo_aktiva', 'total_saldo_pasiva', 'periode'));
    }
}
