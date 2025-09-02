<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\EkstraController;

// Dashboard
Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

// Manajemen Siswa
Route::get('/manajemen-siswa', function () {
    return view('manajemenSiswa');
})->name('manajemenSiswa');

// ===================== Ekstrakurikuler =====================
// Route halaman index
Route::get('/ekstra', [EkstraController::class, 'index'])->name('ekstra.index');

// Store tambah ekstrakurikuler baru
Route::post('/ekstra/store', [EkstraController::class, 'store'])->name('ekstra.store');

// Update ekstrakurikuler
Route::post('/ekstra/update/{id}', [EkstraController::class, 'update'])->name('ekstra.update');

// Hapus ekstrakurikuler
Route::delete('/ekstra/destroy/{id}', [EkstraController::class, 'destroy'])->name('ekstra.destroy');

// Ambil data satu ekstrakurikuler untuk modal edit (JSON)
Route::get('/ekstra/{id}', [EkstraController::class, 'show'])->name('ekstra.show');


// ===================== Keuangan =====================
Route::prefix('keuangan')->group(function () {

    // Dashboard Keuangan
    Route::get('/', [KeuanganController::class, 'index'])->name('keuangan.index');

    // Pemasukan
    Route::get('/create-pemasukan', [KeuanganController::class, 'createPemasukan'])->name('keuangan.createPemasukan');
    Route::post('/store-pemasukan', [KeuanganController::class, 'storePemasukan'])->name('keuangan.storePemasukan');

    // Pengeluaran
    Route::get('/create-pengeluaran', [KeuanganController::class, 'createPengeluaran'])->name('keuangan.createPengeluaran');
    Route::post('/store-pengeluaran', [KeuanganController::class, 'storePengeluaran'])->name('keuangan.storePengeluaran');

    // Tagihan
    Route::get('/tagihan', [KeuanganController::class, 'tagihan'])->name('keuangan.tagihan');
    Route::get('/create-tagihan', [KeuanganController::class, 'createTagihan'])->name('keuangan.createTagihan');
    Route::post('/store-tagihan', [KeuanganController::class, 'storeTagihan'])->name('keuangan.storeTagihan');
    Route::get('/edit-tagihan/{id}', [KeuanganController::class, 'editTagihan'])->name('keuangan.editTagihan');
    Route::put('/update-tagihan/{id}', [KeuanganController::class, 'updateTagihan'])->name('keuangan.updateTagihan');
    Route::delete('/destroy-tagihan/{id}', [KeuanganController::class, 'destroyTagihan'])->name('keuangan.destroyTagihan');

    // Transaksi umum
    Route::get('/edit/{id}', [KeuanganController::class, 'edit'])->name('keuangan.edit');
    Route::put('/update/{id}', [KeuanganController::class, 'update'])->name('keuangan.update');
    Route::delete('/destroy/{id}', [KeuanganController::class, 'destroy'])->name('keuangan.destroy');

    // API Live Data
    Route::get('/api/keuangan/live', [KeuanganController::class, 'getLiveData'])->name('keuangan.live');
});
