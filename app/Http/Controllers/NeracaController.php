<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Jurnal;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Crabbly\Fpdf\Fpdf as FPDF;
use App\Models\Office;

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
            if (substr($jurnal->kode_akun, 0, 1) === '1' || substr($jurnal->kode_akun, 0, 1) === '2' || substr($jurnal->kode_akun, 0, 1) === '4' || substr($jurnal->kode_akun, 0, 1) === '5') {
                $aktiva = $jurnal->total_debet;
                $pasiva = $jurnal->total_kredit;
            } elseif (substr($jurnal->kode_akun, 0, 1) === '3' || substr($jurnal->kode_akun, 0, 1) === '6' || substr($jurnal->kode_akun, 0, 1) === '7' || substr($jurnal->kode_akun, 0, 1) === '8') {
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

    public function print($tanggal)
    {
        $pdf = new FPDF;

        $bulan = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));
        $periode = date('F Y', strtotime($tanggal));
        $periode = strtoupper($periode);

        $office = Office::findOrFail(1);

        $id = Akun::pluck('id');

        $total_saldo_aktiva = 0;
        $total_saldo_pasiva = 0;

        $pdf->AddPage('L', 'A4'); // Changed to landscape mode

        // Header
        $pdf->SetFont('Arial', 'B', 18);
        $pdf->Cell(0, 10, $office->nama_perusahaan, 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, "Alamat : " . $office->alamat . " | Telepon : " . $office->no_telp . " | Email : " . $office->email, 'B', 2, 'C');
        $pdf->Ln();

        // Neraca
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, "NERACA $periode", 0, 2, 'C');

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(15, 10, 'NO', 1, 0, 'C');
        $pdf->Cell(40, 10, 'KODE AKUN', 1, 0, 'C');
        $pdf->Cell(80, 10, 'NAMA AKUN', 1, 0, 'C'); // Increased width to fit landscape mode
        $pdf->Cell(71, 10, 'AKTIVA', 1, 0, 'C'); // Increased width to fit landscape mode
        $pdf->Cell(71, 10, 'PASIVA', 1, 1, 'C'); // Increased width to fit landscape mode

        // $pdf->Ln(); 

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
            if (substr($jurnal->kode_akun, 0, 1) === '1' || substr($jurnal->kode_akun, 0, 1) === '2' || substr($jurnal->kode_akun, 0, 1) === '4' || substr($jurnal->kode_akun, 0, 1) === '5') {
                $aktiva = $jurnal->total_debet;
                $pasiva = $jurnal->total_kredit;
            } elseif (substr($jurnal->kode_akun, 0, 1) === '3' || substr($jurnal->kode_akun, 0, 1) === '6' || substr($jurnal->kode_akun, 0, 1) === '7' || substr($jurnal->kode_akun, 0, 1) === '8') {
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

            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(15, 10, $jurnal->id, 1, 0, 'C');
            $pdf->Cell(40, 10, $jurnal->kode_akun, 1, 0, 'C');
            $pdf->Cell(80, 10, $jurnal->nama_akun, 1, 0, 'L'); // Adjusted alignment
            $pdf->Cell(71, 10, "Rp. " . number_format($aktiva, 0, ',', '.'), 1, 0, 'R'); // Adjusted alignment and removed extra parameter
            $pdf->Cell(71, 10, "Rp. " . number_format($pasiva, 0, ',', '.'), 1, 1, 'R'); // Adjusted alignment and removed extra parameter
        }

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(135, 10, 'TOTAL', 1, 0, 'C'); // Adjusted width
        $pdf->Cell(71, 10, "Rp. " . number_format($total_saldo_aktiva, 0, ',', '.'), 1, 0, 'R'); // Adjusted alignment and removed extra parameter
        $pdf->Cell(71, 10, "Rp. " . number_format($total_saldo_pasiva, 0, ',', '.'), 1, 1, 'R'); // Adjusted alignment and removed extra parameter

        // Footer
        $pdf->SetY(250);
        $pdf->SetX(190);
        $pdf->SetFont('Arial', 'I', 8);
        $pdf->Cell(0, 10, "Dicetak Oleh Akuntan : " . $office->nama_perusahaan . " Pada " . date('d-m-y H:i:s') . " WIB", 0, 0, 'C');

        return $pdf->Output('D', "Neraca $periode.pdf");
    }
}
