<?php

namespace App\Http\Controllers;

use App\Models\Office;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    public function index(){
        $offices = Office::all();
        return view('office.index', compact('offices'));
    }

    public function create(){
        return view('office.create');
    }

    public function store(Request $request){
        $request->validate([
            'nama_perusahaan' => 'required|max:30',
            'alamat' => 'required|max:50',
            'no_telp' => 'required|max:13|min:11|numeric',
            'email' => 'required|max:30|email',
            'tgl_berdiri' => 'required',
        ]);

        Office::create($request->all());

        return redirect()->route('office.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit(Office $office){
        return view('office.edit', compact('office'));
    }

    public function update(Request $request, Office $office){
        $request->validate([
            'nama_perusahaan' => 'required|max:30',
            'alamat' => 'required|max:50',
            'no_telp' => 'required|max:13|min:11|numeric',
            'email' => 'required|max:30|email',
            'tgl_berdiri' => 'required',
        ]);

        $office->update($request->all());

        return redirect()->route('office.index')->with('success', 'Data berhasil diupdate');
    }
}
