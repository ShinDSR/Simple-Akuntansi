<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use Illuminate\Http\Request;
use App\Models\Jurnal;
use Carbon\Carbon;
use Crabbly\Fpdf\Fpdf as FPDF;
use App\Models\Office;

class LaporanController extends Controller
{
    public function index()
    {
        $jurnals = Jurnal::get()
            ->groupBy(function ($val) {
                return Carbon::parse($val->tgl_transaksi)
                    ->format('F Y');
            });

        return view('laporan.index', [
            'jurnal' => $jurnals,
        ]);
    }

    public function print($tanggal)
    {
        if (empty($tanggal)) return redirect('laporan.index');

        $pdf = new FPDF();

        $pdf->AddPage('L', 'A4');

        $bulan = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));
        $periode = date('F Y', strtotime($tanggal));
        $periode = strtoupper($periode);

        $office = Office::findOrFail(1);

        // Header
        $pdf->SetFont('Arial', 'B', 18);
        $pdf->Cell(0, 10, $office->nama_perusahaan, 0, 2, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, "Alamat : " . $office->alamat . " | Telepon : " . $office->no_telp . " | Email : " . $office->email, 'B', 2, 'C');
        $pdf->Ln();

        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, "LAPORAN KEUANGAN $periode", 0, 1, 'C');

        // Jurnal
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, "JURNAL $periode", 0, 2, 'C');

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(10, 10, "NO", 1, 0, 'C');
        $pdf->Cell(35, 10, "TANGGAL", 1, 0, 'C');
        $pdf->Cell(35, 10, "KODE AKUN", 1, 0, 'C');
        $pdf->Cell(67, 10, "NAMA AKUN", 1, 0, 'C');
        $pdf->Cell(65, 10, "DEBET", 1, 0, 'C');
        $pdf->Cell(65, 10, "KREDIT", 1, 1, 'C');

        $jurnals = Jurnal::whereMonth('tgl_transaksi', $bulan)
            ->whereYear('tgl_transaksi', $tahun)
            ->orderBy('tgl_transaksi', 'asc')
            ->with('akun')
            ->get();
        $total_debet = Jurnal::where('tipe_transaksi', 'd')
            ->whereMonth('tgl_transaksi', $bulan)
            ->whereYear('tgl_transaksi', $tahun)
            ->orderBy('tgl_transaksi', 'asc')
            ->with('akun')
            ->sum('nominal');
        $total_kredit = Jurnal::where('tipe_transaksi', 'k')
            ->whereMonth('tgl_transaksi', $bulan)
            ->whereYear('tgl_transaksi', $tahun)
            ->orderBy('tgl_transaksi', 'asc')
            ->with('akun')
            ->sum('nominal');

        $pdf->SetFont('Arial', '', 12);

        $no = 1;
        foreach ($jurnals as $jurnal) {
            $pdf->Cell(10, 10, $no++, 1, 0, 'C');
            $pdf->Cell(35, 10, date('d-m-Y', strtotime($jurnal->tgl_transaksi)), 1, 0, 'C');
            $pdf->Cell(35, 10, $jurnal->akun->kode_akun, 1, 0, 'C');
            $pdf->Cell(67, 10, $jurnal->akun->nama_akun, 1, 0, 'C');
            $pdf->Cell(65, 10, $jurnal->tipe_transaksi == 'd' ? 'Rp. ' . number_format($jurnal->nominal, 0, ',', '.') : "-", 1, 0, 'C');
            $pdf->Cell(65, 10, $jurnal->tipe_transaksi == 'k' ? 'Rp. ' . number_format($jurnal->nominal, 0, ',', '.') : "-", 1, 0, 'C');
            $pdf->Ln();
        }

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(147, 10, "TOTAL", 1, 0, 'C');

        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(65, 10, 'Rp. ' . number_format($total_debet, 0, ',', '.'), 1, 0, 'C');
        $pdf->Cell(65, 10, 'Rp. ' . number_format($total_kredit, 0, ',', '.'), 1, 0, 'C');
        $pdf->Ln();

        $pdf->SetY(175);
        $pdf->SetX(190);
        $pdf->SetFont('Arial', 'I', 8);
        $pdf->Cell(0, 10, "Dicetak Oleh Akuntan : " . $office->nama_perusahaan . " Pada " . date('d-m-y H:i:s') . " WIB", 0, 0, 'C');

        // Buku Besar

        $pdf->AddPage('L', 'A4');

        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, "DAFTAR BUKU BESAR $periode", 0, 2, 'C');

        $id = Akun::pluck('id');

        foreach ($id as $i) {
            $jurnals[$i] = Jurnal::where('akun_id', $i)
                ->whereMonth('tgl_transaksi', $bulan)
                ->whereYear('tgl_transaksi', $tahun)
                ->orderBy('tgl_transaksi', 'asc')
                ->get();

            $data[$i] = [
                'akun' => Akun::findOrFail($i),
                'jurnal' => $jurnals[$i],
                'total_debet' => $jurnals[$i]->where('tipe_transaksi', 'd')->sum('nominal'),
                'total_kredit' => $jurnals[$i]->where('tipe_transaksi', 'k')->sum('nominal'),
            ];

            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(92, 10, 'AKUN : ' . $data[$i]['akun']->nama_akun, 0, 0, 'L');
            $pdf->Cell(92, 10, "PERIODE : $periode", 0, 0, 'C');
            $pdf->Cell(92, 10, 'KODE : ' . $data[$i]['akun']->kode_akun, 0, 1, 'R');
            $pdf->Ln();

            $pdf->Cell(147, 10, "TRANSAKSI", 1, 0, 'C');
            $pdf->Cell(130, 10, "SALDO", 1, 0, 'C');
            $pdf->Ln();

            $pdf->Cell(10, 10, "NO", 1, 0, 'C');
            $pdf->Cell(35, 10, "TANGGAL", 1, 0, 'C');
            $pdf->Cell(102, 10, "KETERANGAN", 1, 0, 'C');
            $pdf->Cell(65, 10, "DEBET", 1, 0, 'C');
            $pdf->Cell(65, 10, "KREDIT", 1, 0, 'C');
            $pdf->Ln();

            $no = 1;
            foreach ($data[$i]['jurnal'] as $jurnal) {
                $pdf->SetFont('Arial', '', 12);
                $pdf->Cell(10, 10, $no++, 1, 0, 'C');
                $pdf->Cell(35, 10, date('d-m-Y', strtotime($jurnal->tgl_transaksi)), 1, 0, 'C');
                $pdf->Cell(102, 10, $jurnal->keterangan, 1, 0, 'C');
                $pdf->Cell(65, 10, $jurnal->tipe_transaksi == 'd' ? 'Rp. ' . number_format($jurnal->nominal, 0, ',', '.') : '-', 1, 0, 'C');
                $pdf->Cell(65, 10, $jurnal->tipe_transaksi == 'k' ? 'Rp. ' . number_format($jurnal->nominal, 0, ',', '.') : '-', 1, 0, 'C');
                $pdf->Ln();
            }

            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(147, 10, "TOTAL", 1, 0, 'C');
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(65, 10, 'Rp. ' . number_format($data[$i]['total_debet'], 0, ',', '.'), 1, 0, 'C');
            $pdf->Cell(65, 10, 'Rp. ' . number_format($data[$i]['total_kredit'], 0, ',', '.'), 1, 0, 'C');
            $pdf->Ln();

            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(147, 10, "SALDO", 1, 0, 'C');
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(130, 10, 'Rp. ' . number_format($data[$i]['total_debet'] - $data[$i]['total_kredit'], 0, ',', '.'), 1, 0, 'C');
            $pdf->Ln();

            $pdf->SetY(175);
            $pdf->SetX(190);
            $pdf->SetFont('Arial', 'I', 8);
            $pdf->Cell(0, 10, "Dicetak Oleh Akuntan : " . $office->nama_perusahaan . " Pada " . date('d-m-y H:i:s') . " WIB", 0, 0, 'C');

            return $pdf->Output('D', "Laporan $periode.pdf");
        }
    }
}
