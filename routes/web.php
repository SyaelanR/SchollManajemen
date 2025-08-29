<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\AdminController;

// ... route lainnya

Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
Route::get('/manajemen siswa', [AdminController::class, 'manajSiswa'])->name('manajemenSiswa');
Route::get('/tambah siswa', [AdminController::class, 'tambahSiswa'])->name('tambahSiswa');