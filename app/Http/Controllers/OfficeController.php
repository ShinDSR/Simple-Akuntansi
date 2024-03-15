<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OfficeController extends Controller
{
    public function index(){
        return view('office.index');
    }

    public function edit(){
        return view('office.edit');
    }
}
