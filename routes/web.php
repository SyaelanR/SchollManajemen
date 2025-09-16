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
use App\Http\Controllers\JadwalController; // <-- Tambahkan ini

// ======================
// Rute untuk guest (belum login)
// ======================
Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'create'])->name('login');
    Route::post('/', [LoginController::class, 'store']);
});

// ======================
// Rute untuk user yang sudah login
// ======================
Route::middleware('auth')->group(function () {

    // ---------- Logout & Dashboard ----------
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // ---------- Manajemen Siswa & Guru ----------
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

    // ---------- Admin Dev ----------
    Route::middleware('role:adminDev')->group(function () {
        Route::get('/manajemen-klien', [AdminDevController::class, 'manajKlien'])->name('manajemenKlien');
        Route::get('/tambah-admin-klien', [AdminDevController::class, 'tambahKlien'])->name('tambahKlien');
        Route::post('/tambah-admin-klien', [AdminDevController::class, 'storeAdmin'])->name('storeAdmin');
    });

    // ---------- Alur Input Nilai ----------
    Route::prefix('input-nilai')->name('inputnilai.')->group(function () {
        Route::get('/', [InputNilaiController::class, 'index'])->name('kelas');
        Route::get('/tugas/{kelas}', [InputNilaiController::class, 'tugasPerKelas'])->name('tugas');
        Route::get('/nilai/{kelas}/{tugas_id}', [InputNilaiController::class, 'inputNilai'])->name('siswa');
        Route::post('/simpan', [InputNilaiController::class, 'simpanNilai'])->name('simpan');

        // Tambahkan route baru untuk inputnilaisiswa.blade.php
        Route::get('/siswa-view', [InputNilaiController::class, 'inputNilaiSiswa'])->name('siswa-view');
    });

    // ---------- Alur Input Tugas ----------
    Route::prefix('input-tugas')->name('inputtugas.')->group(function () {
        Route::get('/', function () {
            return redirect()->route('inputnilai.kelas');
        })->name('index');
        Route::get('/{kelas}', [InputTugasController::class, 'index'])->name('kelas');
        Route::get('/{kelas}/create', [InputTugasController::class, 'create'])->name('create');
        Route::post('/{kelas}/store', [InputTugasController::class, 'store'])->name('store');
    });

    // ---------- Absensi ----------
    Route::get('/absensi', [AbsensiController::class, 'daftarKelas'])->name('absensi.daftar');
    Route::get('/absensi/{kelas}', [AbsensiController::class, 'inputAbsen'])->name('absensi.kelas');
    Route::post('/absensi/{kelas}', [AbsensiController::class, 'store'])->name('absensi.store');

    // ---------- Pelanggaran ----------
    Route::prefix('pelanggaran')->group(function () {
        Route::get('/', [PelanggaranController::class, 'index'])->name('pelanggaran.index');
        Route::post('/', [PelanggaranController::class, 'store'])->name('pelanggaran.store');
        Route::get('/daftar', [PelanggaranController::class, 'daftarPelanggar'])->name('pelanggaran.daftar');
    });

    // ---------- Jadwal ---------- Tambahkan ini supaya route('jadwal') tidak error
    Route::get('/jadwal/{kelas?}', [JadwalController::class, 'index'])->name('jadwal');

});
