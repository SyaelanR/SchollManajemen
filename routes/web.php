<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminDevController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\InputNilaiController;
use App\Http\Controllers\InputTugasController;

// ======================
// Rute Autentikasi
// ======================
Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'create'])->name('login');
    Route::post('/', [LoginController::class, 'store']);
});

// ======================
// Rute dengan Auth
// ======================
Route::middleware('auth')->group(function () {

    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // -------- Rute Admin --------
    Route::prefix('admin')->group(function () {
        Route::prefix('siswa')->group(function () {
            Route::get('/', [AdminController::class, 'manajSiswa'])->name('manajemenSiswa');
            Route::get('/tambah', [AdminController::class, 'tambahSiswa'])->name('tambahSiswa');
            Route::post('/tambah', [AdminController::class, 'storeSiswa'])->name('storeSiswa');
        });

        Route::prefix('guru')->group(function () {
            Route::get('/', [AdminController::class, 'manajGuru'])->name('manajemenGuru');
            Route::get('/tambah', [AdminController::class, 'tambahGuru'])->name('tambahGuru');
            Route::post('/tambah', [AdminController::class, 'storeGuru'])->name('storeGuru');
        });
    });

    // -------- Rute Admin Dev --------
    Route::middleware('role:adminDev')->group(function () {
        Route::get('/manajemen-klien', [AdminDevController::class, 'manajKlien'])->name('manajemenKlien');
        Route::get('/tambah-admin-klien', [AdminDevController::class, 'tambahKlien'])->name('tambahKlien');
        Route::post('/tambah-admin-klien', [AdminDevController::class, 'storeAdmin'])->name('storeAdmin');
    });

    // Rute Input Tugas
    Route::prefix('input-tugas')->group(function () {
        Route::get('/', [InputTugasController::class, 'index'])->name('inputtugas.index');
        Route::post('/', [InputTugasController::class, 'store'])->name('inputtugas.store');
    });

    // ======================
    // Rute Nilai
    // ======================
    Route::prefix('input-nilai')->group(function () {
        Route::get('/', [InputNilaiController::class, 'index'])->name('input.nilai');
        Route::get('/tugas/{kelas}', [InputNilaiController::class, 'tugasPerKelas'])->name('tugas.perkelas');
        Route::get('/kelas/{kelas}/input-nilai', [InputNilaiController::class, 'inputNilai'])->name('kelas.inputnilai');
        Route::get('/inputnilaisiswa', [InputNilaiController::class, 'inputNilaiQuery'])->name('input.nilai.siswa');
        Route::post('/simpan-nilai', [InputNilaiController::class, 'simpanNilai'])->name('simpan.nilai');
    });

});

// Jadwal Kelas
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
Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');
Route::get('/absensi/{kelas}', [AbsensiController::class, 'index'])->name('absensi.input');

// Pelanggaran
Route::prefix('pelanggaran')->group(function () {
    Route::get('/', [PelanggaranController::class, 'index'])->name('pelanggaran.index');
    Route::post('/', [PelanggaranController::class, 'store'])->name('pelanggaran.store');
    Route::get('/daftar', [PelanggaranController::class, 'daftarPelanggar'])->name('pelanggaran.daftar');
});
