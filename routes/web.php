<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\EkstraController;
use App\Http\Controllers\Ekskul\GuruEkskulController;
use App\Http\Controllers\ekskul\guru\EkskulController;

// ===================== Dashboard =====================
Route::get('/', function () {
    return view('dashboard'); // Halaman utama/dashboard
})->name('dashboard');

// ===================== Manajemen Siswa =====================
Route::get('/manajemen-siswa', function () {
    return view('manajemenSiswa');
})->name('manajemenSiswa');

// ===================== Ekstrakurikuler (Umum - untuk semua) =====================
Route::prefix('ekstra')->name('ekstra.')->group(function () {
    Route::get('/', [EkstraController::class, 'index'])->name('index');
    Route::post('/', [EkstraController::class, 'store'])->name('store');
    Route::put('/{id}', [EkstraController::class, 'update'])->name('update');
    Route::delete('/{id}', [EkstraController::class, 'destroy'])->name('destroy');
    Route::get('/{id}', [EkstraController::class, 'show'])->name('show');
});

// ===================== Keuangan =====================
Route::prefix('keuangan')->name('keuangan.')->group(function () {
    Route::get('/', [KeuanganController::class, 'index'])->name('index');

    // Pemasukan
    Route::get('/create-pemasukan', [KeuanganController::class, 'createPemasukan'])->name('createPemasukan');
    Route::post('/store-pemasukan', [KeuanganController::class, 'storePemasukan'])->name('storePemasukan');

    // Pengeluaran
    Route::get('/create-pengeluaran', [KeuanganController::class, 'createPengeluaran'])->name('createPengeluaran');
    Route::post('/store-pengeluaran', [KeuanganController::class, 'storePengeluaran'])->name('storePengeluaran');

    // Tagihan
    Route::get('/tagihan', [KeuanganController::class, 'tagihan'])->name('tagihan');
    Route::get('/create-tagihan', [KeuanganController::class, 'createTagihan'])->name('createTagihan');
    Route::post('/store-tagihan', [KeuanganController::class, 'storeTagihan'])->name('storeTagihan');
    Route::get('/edit-tagihan/{id}', [KeuanganController::class, 'editTagihan'])->name('editTagihan');
    Route::put('/update-tagihan/{id}', [KeuanganController::class, 'updateTagihan'])->name('updateTagihan');
    Route::delete('/destroy-tagihan/{id}', [KeuanganController::class, 'destroyTagihan'])->name('destroyTagihan');

    // Transaksi umum
    Route::get('/edit/{id}', [KeuanganController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [KeuanganController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [KeuanganController::class, 'destroy'])->name('destroy');

    // API Live Data
    Route::get('/api/keuangan/live', [KeuanganController::class, 'getLiveData'])->name('live');
});

// ===================== Ekstrakurikuler (Guru) =====================
Route::prefix('guru')->name('guru.')->group(function () {
    Route::get('/', [GuruEkskulController::class, 'index'])->name('index');       // Halaman daftar
    Route::get('/create', [GuruEkskulController::class, 'create'])->name('create'); // Form tambah
    Route::post('/store', [GuruEkskulController::class, 'store'])->name('store');   // Simpan data
    Route::get('/{id}/edit', [GuruEkskulController::class, 'edit'])->name('edit'); // Form edit
    Route::put('/{id}', [GuruEkskulController::class, 'update'])->name('update');  // Update data
    Route::delete('/{id}', [GuruEkskulController::class, 'destroy'])->name('destroy'); // Hapus data
});


// ===================== Ekskul =====================

Route::prefix('ekskul/guru')->name('guru.ekskul.')->group(function () {
    Route::get('/', [EkskulController::class, 'index'])->name('index');
    Route::get('/create', [EkskulController::class, 'create'])->name('create');
    Route::post('/', [EkskulController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [EkskulController::class, 'edit'])->name('edit');
    Route::put('/{id}', [EkskulController::class, 'update'])->name('update');
    Route::delete('/{id}', [EkskulController::class, 'destroy'])->name('destroy');
    Route::get('/{id}', [EkskulController::class, 'show'])->name('show');
});





