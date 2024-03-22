<?php

namespace App\Http\Controllers;

use App\Models\Office;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    public function index(){
        return view('office.index');
    }

    public function edit(Office $office){
        return view('office.edit', compact('office'));
    }

    public function update(Request $request, Office $office){
        $request->validate([
            'nama_perusahaan' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'email' => 'required',
            'tgl_berdiri' => 'required',
        ]);

        $office->update($request->all());

        return redirect()->route('office.index')->with('success', 'Data berhasil diupdate');
    }
}
