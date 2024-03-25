<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Akun;

class AkunController extends Controller
{
    public function index(){
        $akuns = Akun::all();
        $total_akun = $akuns->count();
        return view('akun.index', compact('akuns', 'total_akun'));
    }

    public function create(){
        return view('akun.create');
    }

    public function store(Request $request){
        $request->validate([
            'kode_akun' => 'required|max:3|min:3|unique:akuns,kode_akun',
            'nama_akun' => 'required|max:20',
        ]);
        Akun::create([
            'kode_akun' => $request->kode_akun,
            'nama_akun' => $request->nama_akun,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('akun.index')->with('success', 'Akun berhasil ditambahkan');
    }

    public function edit(Akun $akun){
        return view('akun.edit', compact('akun'));
    }

    public function update(Request $request, Akun $akun){
        $request->validate([
            'kode_akun' => 'required|max:3|min:3|unique:akuns,kode_akun,'.$akun->id,
            'nama_akun' => 'required|max:20',
        ]);
        $akun->update([
            'kode_akun' => ucfirst($request->kode_akun),
            'nama_akun' => $request->nama_akun,
        ]);

        return redirect()->route('akun.index')->with('success', 'Akun berhasil diubah');
    }

    public function destroy(Akun $akun){
        $akun->delete();
        return redirect()->route('akun.index')->with('success', 'Akun berhasil dihapus');
    }
}
