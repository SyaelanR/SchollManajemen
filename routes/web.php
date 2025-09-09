<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminDevController;
use Illuminate\Auth\Events\Login;

// Rute Autentikasi Kustom
// Menggunakan middleware 'guest' agar pengguna yang sudah login tidak bisa mengakses halaman login lagi.
Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'create'])->name('login');
    Route::post('/', [LoginController::class, 'store']);
});


// Rute yang memerlukan autentikasi (hanya bisa diakses setelah login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');

        // Grup rute ini sekarang hanya bisa diakses oleh pengguna dengan role 'admin'.
    Route::middleware('role:admin')->group(function () {
        Route::prefix('manajemen-siswa')->group(function () {
            Route::get('/', [AdminController::class, 'manajSiswa'])->name('manajemenSiswa');
            Route::get('/tambah-siswa', [AdminController::class, 'tambahSiswa'])->name('tambahSiswa');
            Route::post('/tambah-siswa', [AdminController::class, 'storeSiswa'])->name('storeSiswa');
        });
        
        Route::prefix('manajemen-guru')->group(function () {
            Route::get('/', [AdminController::class, 'manajGuru'])->name('manajemenGuru');
            Route::get('/tambah-guru', [AdminController::class, 'tambahGuru'])->name('tambahGuru');
            Route::post('/tambah-guru', [AdminController::class, 'storeGuru'])->name('storeGuru');
        });

        Route::prefix('manajemen-angkatan')->group(function () {
            Route::get('/', [AdminController::class, 'manajAngkatan'])->name('manajemenAngkatan');
            Route::post('/', [AdminController::class, 'storeAngkatan'])->name('storeAngkatan');
        });

        Route::prefix('manajemen-kelas')->group(function () {
            Route::get('/', [AdminController::class, 'manajKelas'])->name('manajemenKelas');
            Route::post('/', [AdminController::class, 'storeKelas'])->name('storeKelas');
            Route::post('/lihat-kelas', [AdminController::class, 'lihatKelas'])->name('lihatKelas');
            Route::get('/lihat-kelas', [AdminController::class, 'lihatKelasD'])->name('lihatKelasD');
            Route::post('/lihat-kelas/tambah-siswa-ke-kelas', [AdminController::class, 'tambahSiswaKeKelas'])->name('tambahSiswaKeKelas');
        });

        Route::prefix('manajemen-keuangan')->group(function () {
            Route::get('/', [AdminController::class, 'manajKeuangan'])->name('manajemenKeuangan');
            Route::post('/pemasukan', [AdminController::class, 'storePemasukan'])->name('storePemasukan');
            Route::post('/pengeluaran', [AdminController::class, 'storePengeluaran'])->name('storePengeluaran');
            Route::get('/tagihan-siswa', [AdminController::class, 'tagihanSiswa'])->name('tagihanSiswa');
            Route::post('/tagihan-siswa', [AdminController::class, 'storeTagihan'])->name('storeTagihan');
            Route::post('/tagihan-siswa/pembayaran-tagihan', [AdminController::class, 'pembayaranTagihansiswa'])->name('pembayaranTagihanSiswa');
        });

    });

        

        // Grup rute ini sekarang hanya bisa diakses oleh pengguna dengan role 'adminDev'.
    Route::middleware('role:adminDev')->group(function () {
        Route::get('/tambah-admin-klien{id_sekolah}', [AdminDevController::class, 'tambahAdminKlien'])->name('tambahAdminKlien');
        Route::post('/tambah-admin-klien{id_sekolah}', [AdminDevController::class, 'storeAdmin'])->name('storeAdmin');

        Route::get('/info-klien', [AdminDevController::class, 'infoKlienD'])->name('infoKlienD');
        Route::post('/info-klien', [AdminDevController::class, 'infoKlien'])->name('infoKlien');

        Route::get('/tambah-klien', [AdminDevController::class, 'tambahKlien'])->name('tambahKlien');
        Route::post('/tambah-klien', [AdminDevController::class, 'storeKlien'])->name('storeKlien');
    });

});





####################################################################################################################
    // Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    // Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    // Route::get('/manajemen siswa', [AdminController::class, 'manajSiswa'])->name('manajemenSiswa');
    // Route::get('/tambah siswa', [AdminController::class, 'tambahSiswa'])->name('tambahSiswa');
    // Route::post('/tambah siswa', [AdminController::class, 'storeSiswa'])->name('storeSiswa');
    // Route::get('/', [LoginController::class, 'create'])->name('login');
    // Route::post('/', [LoginController::class, 'store']);

    // Route::get('/manajemen-guru', [AdminController::class, 'manajGuru'])->name('manajemenGuru');
    // Route::get('/tambah-guru', [AdminController::class, 'tambahGuru'])->name('tambahGuru');
    // Route::post('/tambah-guru', [AdminController::class, 'storeGuru'])->name('storeGuru');

    // Route::get('/manajemen-klien', [AdminDevController::class, 'manajKlien'])->name('manajemenKlien');
    // Route::get('/tambah-admin-klien', [AdminDevController::class, 'tambahKlien'])->name('tambahKlien');
    // Route::post('/tambah-admin-klien', [AdminDevController::class, 'storeAdmin'])->name('storeAdmin');



use App\Http\Controllers\KelasController;
use App\Http\Controllers\pelanggaranController;
use App\Http\Controllers\AbsensiController;

// Dashboard (halaman utama)
// Route::get('/', [KelasController::class, 'index'])->name('dashboard');

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
