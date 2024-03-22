<?php

use App\Http\Controllers\OfficeController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BukuBesarController;
use App\Http\Controllers\NeracaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/user', [UserController::class, 'index'])->name('user.index');

    Route::get('/office', [OfficeController::class, 'index'])->name('office.index');
    Route::get('/office/edit', [OfficeController::class, 'edit'])->name('office.edit');
    
    //Akun
    Route::get('/akun', [AkunController::class, 'index'])->name('akun.index');
    Route::get('/akun/create', [AkunController::class, 'create'])->name('akun.create');
    Route::post('/akun', [AkunController::class, 'store'])->name('akun.store');
    Route::get('/akun/{akun}/edit', [AkunController::class, 'edit'])->name('akun.edit');
    Route::patch('/akun/{akun}', [AkunController::class, 'update'])->name('akun.update');
    Route::delete('/akun/{akun}', [AkunController::class, 'destroy'])->name('akun.destroy');

    //Jurnal
    Route::get('/jurnal', [JurnalController::class, 'index'])->name('jurnal.index');
    Route::get('/jurnal/detail/{tanggal}', [JurnalController::class, 'detail'])->name('jurnal.detail');
    Route::get('/jurnal/search', [JurnalController::class, 'search'])->name('jurnal.search');
    Route::get('/jurnal/create', [JurnalController::class, 'create'])->name('jurnal.create');
    Route::post('/jurnal', [JurnalController::class, 'store'])->name('jurnal.store');
    Route::get('/jurnal/{jurnal}/edit', [JurnalController::class, 'edit'])->name('jurnal.edit');
    Route::patch('/jurnal/{jurnal}', [JurnalController::class, 'update'])->name('jurnal.update');
    Route::delete('/jurnal/{jurnal}', [JurnalController::class, 'destroy'])->name('jurnal.destroy');

    //Buku Besar
    Route::get('/bukubesar', [BukuBesarController::class, 'index'])->name('bukubesar.index');
    Route::get('/bukubesar/{akun}', [BukuBesarController::class, 'show'])->name('bukubesar.show');
    Route::get('/bukubesar/detail/{akun}/{tanggal}', [BukuBesarController::class, 'detail'])->name('bukubesar.detail');
    
    //Neraca
    Route::get('/neraca', [NeracaController::class, 'index'])->name('neraca.index');
    Route::get('/neraca/detail/{tanggal}', [NeracaController::class, 'detail'])->name('neraca.detail');
});

require __DIR__.'/auth.php';
