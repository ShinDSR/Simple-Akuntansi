<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Jurnal;
use Illuminate\Http\Request;
use Carbon\Carbon;

class NeracaController extends Controller
{


    // public function index()
    // {
    //     $jurnals = Jurnal::selectRaw("CONCAT(MONTH(tgl_transaksi), '-', YEAR(tgl_transaksi)) as tanggal")
    //         ->distinct()
    //         ->get();
    //     $total_neraca = $jurnals->count();
    //     return view('neraca.index', compact('jurnals', 'total_neraca'));
    // }

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

    // public function detail(Request $request, $tanggal)
    // {
    //     if (empty($tanggal)) return redirect('neraca.index');

    //     $akuns = Akun::all();
    //     $periode = date('F Y', strtotime($tanggal));
    //     $total_saldo_aktiva = 0;
    //     $total_saldo_pasiva = 0;
    //     $data = [];

    //     foreach ($akuns as $akun) {
    //         $total_debet = Jurnal::where('tipe_transaksi', 'd')
    //             ->where('akun_id', $akun->id)
    //             ->whereMonth('tgl_transaksi', date('m', strtotime($tanggal)))
    //             ->whereYear('tgl_transaksi', date('Y', strtotime($tanggal)))
    //             ->sum('nominal');

    //         $total_kredit = Jurnal::where('tipe_transaksi', 'k')
    //             ->where('akun_id', $akun->id)
    //             ->whereMonth('tgl_transaksi', date('m', strtotime($tanggal)))
    //             ->whereYear('tgl_transaksi', date('Y', strtotime($tanggal)))
    //             ->sum('nominal');

    //         // Menetapkan nilai 0 jika tidak ada entri jurnal untuk akun tertentu
    //         $total_debet = $total_debet ?: 0;
    //         $total_kredit = $total_kredit ?: 0;

    //         $aktiva = $pasiva = 0;
    //         if (substr($akun->kode_akun, 0, 1) === '1' || substr($akun->kode_akun, 0, 1) === '4') {
    //             $aktiva = $total_debet;
    //             $pasiva = $total_kredit;
    //         } elseif (substr($akun->kode_akun, 0, 1) === '2' || substr($akun->kode_akun, 0, 1) === '3' || substr($akun->kode_akun, 0, 1) === '5') {
    //             $pasiva = $total_kredit;
    //             $aktiva = $total_debet;
    //         }

    //         $data[] = [
    //             'kode_akun' => $akun->kode_akun,
    //             'nama_akun' => $akun->nama_akun,
    //             'aktiva' => $aktiva,
    //             'pasiva' => $pasiva,
    //         ];

    //         $total_saldo_aktiva += $aktiva;
    //         $total_saldo_pasiva += $pasiva;
    //     }

    //     return view('neraca.detail', compact('data', 'total_saldo_aktiva', 'total_saldo_pasiva', 'periode'));
    // }


    // public function detail(Request $request, $tanggal)
    // {
    //     if (empty($tanggal)) return redirect('neraca.index');

    //     $periode = date('F Y', strtotime($tanggal));
    //     $bulan = date('m', strtotime($tanggal));
    //     $tahun = date('Y', strtotime($tanggal));

    //     // Membuat array untuk menyimpan total debet dan kredit untuk setiap akun
    //     $total_debet = [];
    //     $total_kredit = [];

    //     // Mendapatkan total debet dan kredit untuk setiap akun dalam satu kueri
    //     $jurnals = Jurnal::select('akun_id', 'tipe_transaksi', \DB::raw('SUM(nominal) as total'))
    //         ->whereMonth('tgl_transaksi', $bulan)
    //         ->whereYear('tgl_transaksi', $tahun)
    //         ->groupBy('akun_id', 'tipe_transaksi')
    //         ->get();

    //     foreach ($jurnals as $jurnal) {
    //         if ($jurnal->tipe_transaksi === 'd') {
    //             $total_debet[$jurnal->akun_id] = $jurnal->total;
    //         } elseif ($jurnal->tipe_transaksi === 'k') {
    //             $total_kredit[$jurnal->akun_id] = $jurnal->total;
    //         }
    //     }

    //     // Mendapatkan semua akun yang terkait dengan jurnal pada periode yang diberikan
    //     $akuns = Akun::whereIn('id', array_merge(array_keys($total_debet), array_keys($total_kredit)))->get();

    //     $data = [];
    //     $total_saldo_aktiva = 0;
    //     $total_saldo_pasiva = 0;

    //     foreach ($akuns as $akun) {
    //         // Menginisialisasi debet dan kredit dengan 0 jika tidak ada dalam jurnal
    //         $debet = $total_debet[$akun->id] ?? 0;
    //         $kredit = $total_kredit[$akun->id] ?? 0;

    //         // Memproses saldo sesuai dengan kode akun
    //         if (substr($akun->kode_akun, 0, 1) === '1' || substr($akun->kode_akun, 0, 1) === '4') {
    //             $aktiva = $debet;
    //             $pasiva = $kredit;
    //         } elseif (substr($akun->kode_akun, 0, 1) === '2' || substr($akun->kode_akun, 0, 1) === '3' || substr($akun->kode_akun, 0, 1) === '5') {
    //             $pasiva = $kredit;
    //             $aktiva = $debet;
    //         }

    //         // Menyimpan data akun
    //         $data[] = [
    //             'kode_akun' => $akun->kode_akun,
    //             'nama_akun' => $akun->nama_akun,
    //             'aktiva' => $aktiva,
    //             'pasiva' => $pasiva,
    //         ];

    //         // Menambahkan saldo ke total saldo aktiva dan pasiva
    //         $total_saldo_aktiva += $aktiva;
    //         $total_saldo_pasiva += $pasiva;
    //     }

    //     return view('neraca.detail', compact('data', 'total_saldo_aktiva', 'total_saldo_pasiva', 'periode'));
    // }

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
            if (substr($jurnal->kode_akun, 0, 1) === '1' || substr($jurnal->kode_akun, 0, 1) === '4') {
                $aktiva = $jurnal->total_debet;
                $pasiva = $jurnal->total_kredit;
            } elseif (substr($jurnal->kode_akun, 0, 1) === '2' || substr($jurnal->kode_akun, 0, 1) === '3' || substr($jurnal->kode_akun, 0, 1) === '5') {
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
