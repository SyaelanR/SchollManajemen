<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminDevController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\AbsensiController; 
use App\Http\Controllers\InputNilaiController;

// ======================
// Rute Autentikasi Kustom
// ======================
Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'create'])->name('login');
    Route::post('/', [LoginController::class, 'store']);
});

// ======================
// Rute dengan Autentikasi
// ======================
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // -------- Rute Admin --------
    Route::middleware('role:admin')->group(function () {
        // Manajemen Siswa
        Route::prefix('siswa')->group(function () {
            Route::get('/', [AdminController::class, 'manajSiswa'])->name('manajemenSiswa');
            Route::get('/tambah', [AdminController::class, 'tambahSiswa'])->name('tambahSiswa');
            Route::post('/tambah', [AdminController::class, 'storeSiswa'])->name('storeSiswa');
        });

        // Manajemen Guru
        Route::prefix('guru')->group(function () {
            Route::get('/', [AdminController::class, 'manajGuru'])->name('manajemenGuru');
            Route::get('/tambah', [AdminController::class, 'tambahGuru'])->name('tambahGuru');
            Route::post('/tambah', [AdminController::class, 'storeGuru'])->name('storeGuru');
        });

        // Input Nilai (Admin)
        Route::get('/input-nilai', [AdminController::class, 'inputNilai'])->name('inputnilai'); // route blade
        Route::get('/kelas/{id}/input-nilai', [AdminController::class, 'inputNilaiKelas'])->name('kelas.inputNilai');
        Route::post('/kelas/{id}/store-nilai', [AdminController::class, 'storeNilai'])->name('kelas.storeNilai');
    });

    // -------- Rute Admin Dev --------
    Route::middleware('role:adminDev')->group(function () {
        Route::get('/manajemen-klien', [AdminDevController::class, 'manajKlien'])->name('manajemenKlien');
        Route::get('/tambah-admin-klien', [AdminDevController::class, 'tambahKlien'])->name('tambahKlien');
        Route::post('/tambah-admin-klien', [AdminDevController::class, 'storeAdmin'])->name('storeAdmin');
    });

});

// ======================
// Rute Tanpa Autentikasi
// ======================

// Jadwal
Route::prefix('kelas')->group(function () {
    Route::get('/', [KelasController::class, 'jadwal'])->name('jadwal');
    Route::get('/kelas10a', [KelasController::class, 'kelas10A'])->name('kelas10a');
    Route::get('/kelas10b', [KelasController::class, 'kelas10B'])->name('kelas10b');
    Route::get('/kelas11a', [KelasController::class, 'kelas11A'])->name('kelas11a');
    Route::get('/kelas11b', [KelasController::class, 'kelas11B'])->name('kelas11b');
    Route::get('/kelas12a', [KelasController::class, 'kelas12A'])->name('kelas12a');
    Route::get('/kelas12b', [KelasController::class, 'kelas12B'])->name('kelas12b');
});

// Absensi
Route::prefix('absensi')->group(function () {
    Route::get('/', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::get('/{id}', [AbsensiController::class, 'show'])->name('absensi.show');
    Route::post('/store', [AbsensiController::class, 'store'])->name('absensi.store');
});

// Pelanggaran
Route::prefix('pelanggaran')->group(function () {
    Route::get('/', [PelanggaranController::class, 'index'])->name('pelanggaran.index');
    Route::post('/', [PelanggaranController::class, 'store'])->name('pelanggaran.store');
    Route::get('/daftar', [PelanggaranController::class, 'daftarPelanggar'])->name('pelanggaran.daftar');
});

Route::middleware(['auth'])->group(function () {
    // Halaman input nilai & absensi
    Route::get('/input-nilai', [InputNilaiController::class, 'index'])->name('input.nilai');

    // Simpan nilai
    Route::post('/input-nilai/simpan', [InputNilaiController::class, 'simpanNilai'])->name('simpan.nilai');

    // Simpan absensi
    Route::post('/input-absensi/simpan', [InputNilaiController::class, 'simpanAbsensi'])->name('simpan.absensi');
}); 