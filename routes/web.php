<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;

// Rute Autentikasi Kustom
//Menggunakan middleware 'guest' agar pengguna yang sudah login tidak bisa mengakses halaman login lagi.
Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'create'])->name('login');
    Route::post('/', [LoginController::class, 'store']);
});

// Rute yang memerlukan autentikasi (hanya bisa diakses setelah login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Grup rute ini sekarang hanya bisa diakses oleh pengguna dengan role 'admin'.
    Route::middleware('role:siswa')->group(function () {
        Route::get('/manajemen-siswa', [AdminController::class, 'manajSiswa'])->name('manajemenSiswa');
        Route::get('/tambah-siswa', [AdminController::class, 'tambahSiswa'])->name('tambahSiswa');
        Route::post('/tambah-siswa', [AdminController::class, 'storeSiswa'])->name('storeSiswa');
    });
});

    // Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    // Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    // Route::get('/manajemen siswa', [AdminController::class, 'manajSiswa'])->name('manajemenSiswa');
    // Route::get('/tambah siswa', [AdminController::class, 'tambahSiswa'])->name('tambahSiswa');
    // Route::post('/tambah siswa', [AdminController::class, 'storeSiswa'])->name('storeSiswa');
    // Route::get('/', [LoginController::class, 'create'])->name('login');
    // Route::post('/', [LoginController::class, 'store']);
