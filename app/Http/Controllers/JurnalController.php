<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurnal;
use App\Models\Akun;
use Illuminate\Validation\Rule;

class JurnalController extends Controller
{
    public function index(){
        $list_jurnal = Jurnal::selectRaw("CONCAT(MONTH(tgl_transaksi), '-', YEAR(tgl_transaksi)) as tanggal")
        ->distinct()
        ->get();

        $total_jurnal = $list_jurnal->count();
        return view('jurnal.index', compact('list_jurnal', 'total_jurnal'));
    }

    public function detail(Request $request, $tanggal){
        if(empty($tanggal)) return redirect()->route('jurnal.index');

        $bulan = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));
        $periode = date('F Y', strtotime($tanggal));

        $list_jurnal = Jurnal::whereMonth('tgl_transaksi', $bulan)
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

        // $total_jurnal = $list_jurnal->count();
        $saldo = $total_debet - $total_kredit;

        return view('jurnal.detail', compact('list_jurnal', 'periode', 'total_debet', 'total_kredit', 'saldo'));
    }

    public function search(){
        return view('jurnal.search');
    }

    public function create(){
        $akuns = Akun::all();
        return view('jurnal.create', compact('akuns'));
    }

    public function store(Request $request){
        $request->validate([
            'tgl_transaksi' => 'required|date',
            'akun_id' => [Rule::exists('akuns', 'id')],
            'nominal' => 'required|numeric',
            'keterangan' => 'required|max:30',
            'tipe_transaksi' => 'required|in:d,k',
        ]);
        Jurnal::create([
            'tgl_transaksi' => $request->tgl_transaksi,
            'akun_id' => $request->akun_id,
            'nominal' => $request->nominal,
            'keterangan' => $request->keterangan,
            'tipe_transaksi' => $request->tipe_transaksi,
        ]);
        return redirect()->route('jurnal.index')->with('success', 'Data jurnal berhasil ditambahkan');
    }

    public function edit(Jurnal $jurnal){
        $akuns = Akun::all();
        return view('jurnal.edit', compact('jurnal', 'akuns'));
    }

    public function update(Request $request, Jurnal $jurnal){
        $request->validate([
            'tgl_transaksi' => 'required|date',
            'akun_id' => [Rule::exists('akuns', 'id')],
            'nominal' => 'required|numeric',
            'keterangan' => 'required|max:30',
            'tipe_transaksi' => 'required|in:d,k',
        ]);

        $jurnal->update([
            'tgl_transaksi' => $request->tgl_transaksi,
            'akun_id' => $request->akun_id,
            'nominal' => $request->nominal,
            'keterangan' => $request->keterangan,
            'tipe_transaksi' => $request->tipe_transaksi,
        ]);

        return redirect()->route('jurnal.index')->with('success', 'Data jurnal berhasil diubah');
    }

    public function destroy(Jurnal $jurnal){
        $jurnal->delete();
        return redirect()->route('jurnal.index')->with('success', 'Data jurnal berhasil dihapus');
    }
}
