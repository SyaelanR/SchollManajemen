<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\pelanggaranController;
use App\Http\Controllers\AbsensiController;

// Dashboard (halaman utama)
Route::get('/', [KelasController::class, 'index'])->name('dashboard');

// Jadwal
Route::get('/jadwal', [KelasController::class, 'jadwal'])->name('jadwal');

// Halaman kelas
Route::get('/kelas10A', [KelasController::class, 'kelas10A'])->name('kelas10A');
Route::get('/kelas10B', [KelasController::class, 'kelas10B'])->name('kelas10B');
Route::get('/kelas11A', [KelasController::class, 'kelas11A'])->name('kelas11A');
Route::get('/kelas11B', [KelasController::class, 'kelas11B'])->name('kelas11B');
Route::get('/kelas12A', [KelasController::class, 'kelas12A'])->name('kelas12A');
Route::get('/kelas12B', [KelasController::class, 'kelas12B'])->name('kelas12B');

// Rute untuk Absensi
Route::prefix('absensi')->group(function () {
    Route::get('/absensi', [absensiController::class, 'index'])->name('absensi.index');
    Route::get('/{id}', [absensiController::class, 'show'])->name('absensi.show');
    Route::post('/store', [absensiController::class, 'store'])->name('absensi.store');
});

// Rute untuk pelanggaranController
Route::get('/pelanggaran', [pelanggaranController::class, 'index'])->name('pelanggaran.index');
Route::post('/pelanggaran', [pelanggaranController::class, 'store'])->name('pelanggaran.store');
Route::get('/daftarPelanggar', [pelanggaranController::class, 'daftarPelanggar'])->name('pelanggaran.daftar');
