<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $users = User::orderBy('name', 'asc')->get();
        return view('user.index', compact('users'));
    }

    public function create(){
        return view('user.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|max:30',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan');
    }

    public function edit(User $user){
        return view('user.edit', compact('user'));
    }

    public function update(Request $request,User $user){
        $request->validate([
            'name' => 'required|max:30',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'required|min:8',
        ]);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('user.index')->with('success', 'User berhasil diubah');
    }

    public function destroy(User $user){
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User berhasil dihapus');
    }
}
