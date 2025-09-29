<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EkstraController;
use App\Http\Controllers\Ekskul\GuruEkskulController;
use App\Http\Controllers\ekskul\guru\EkskulController;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index']);

Route::get('/ekstra/guru', [EkstraController::class, 'guruIndex'])->name('ekstra.guru.index');



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


Route::get('/ekstra/guru', [EkstraController::class, 'guruIndex'])->name('ekstra.guru.index');
Route::get('/ekstra/guru/create', [EkstraController::class, 'createGuru'])->name('ekstra.guru.create');





// ==================
// 📌 ROUTE KEUANGAN
// ==================
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\BendaharaController;
use App\Http\Controllers\WaliController;
Route::prefix('keuangan')->name('keuangan.')->group(function () {
    Route::get('/', [KeuanganController::class, 'index'])->name('index');
    Route::get('/create', [KeuanganController::class, 'create'])->name('create');
    Route::post('/store', [KeuanganController::class, 'store'])->name('store');
    Route::delete('/{id}/delete', [KeuanganController::class, 'destroy'])->name('destroy');
});


// Halaman utama
Route::get('/', [KeuanganController::class, 'dashboard']);

//PRODUK
Route::get('/produk', [KeuanganController::class, 'index'])->name('produk.index');
Route::post('/produk', [KeuanganController::class, 'store'])->name('produk.store');

// edit dengan query ?id=
Route::get('/produk/editproduk', [KeuanganController::class, 'edit'])->name('produk.edit');

Route::post('/produk/update', [KeuanganController::class, 'update'])->name('produk.update');
//SUPPLIER
Route::get('/supplier', [KeuanganController::class, 'supplier'])->name('supplier.index');
Route::get('/supplier/editsupplier', [KeuanganController::class, 'editSupplier'])
     ->name('supplier.editsupplier');
Route::post('/supplier/editsupplier', [KeuanganController::class, 'updateSupplier'])
     ->name('supplier.update');


// ===== Pelanggan ===== //
Route::get('/pelanggan', [KeuanganController::class, 'pelanggan'])
     ->name('pelanggan.pelanggan');       // Halaman daftar pelanggan

Route::get('/pelanggan/editpelanggan', [KeuanganController::class, 'editpelanggan'])
     ->name('pelanggan.editpelanggan');   // Form edit pelanggan

Route::post('/pelanggan/editpelanggan/{id}', [KeuanganController::class, 'update'])
     ->name('pelanggan.update');          // Proses update pelanggan
// Menu Pembelian
Route::get('/pembelian', [KeuanganController::class, 'pembelian']);

//Menu Penjualan
// Daftar + popup tambah
Route::get('/penjualan', [KeuanganController::class, 'penjualan'])->name('penjualan.index');
Route::post('/penjualan', [KeuanganController::class, 'storePenjualan'])->name('penjualan.store');
// Edit
Route::get('/penjualan/editpenjualan', [KeuanganController::class, 'editPenjualan'])
     ->name('penjualan.editpenjualan');

Route::post('/penjualan/update/{id}', [KeuanganController::class, 'updatePenjualan'])->name('penjualan.update');



// Menu Jurnal
Route::get('/jurnal', [KeuanganController::class, 'jurnal'])
     ->name('jurnal');

// POST kalau memang dibutuhkan
Route::post('/jurnal', [KeuanganController::class, 'jurnal'])
     ->name('jurnal.post'); // opsional, beda nama supaya unik
///////
Route::get('/laporan', [KeuanganController::class, 'laporan']);
Route::get('/laporan/neraca', [KeuanganController::class, 'laporanNeraca']);
Route::get('/laporan/laba-rugi', [KeuanganController::class, 'laporanLabaRugi']);

// Rute baru untuk COA (tambahkan ini)
Route::get('/bendahara/coa', [KeuanganController::class, 'coa']); // Pastikan baris ini ada
Route::get('/bendahara/coa/tambah', [KeuanganController::class, 'tambahCoa']);
Route::post('/bendahara/coa/tambah', [KeuanganController::class, 'simpanCoa']);

////gpt
Route::get('/coa', [KeuanganController::class, 'coa'])->name('coa.index');
Route::get('/coa/tambah', [KeuanganController::class, 'tambahCoa'])->name('coa.tambah');
Route::post('/coa/tambah', [KeuanganController::class, 'simpanCoa'])->name('coa.simpan');


//=============================BENDAHARA======================================//
    Route::get('/bendahara/pembelian', [BendaharaController::class, 'pembelian'])
    ->name('bendahara.pembelian');
    Route::get('/bendahara/laporan', [BendaharaController::class, 'review'])
    ->name('bendahara.laporan');
    Route::get('/bendahara/dashboard', [BendaharaController::class, 'dashboard'])
    ->name('bendahara.dashboard');
    Route::get('/bendahara/persetujuan', [BendaharaController::class, 'persetujuan'])
    ->name('bendahara.persetujuan');
    Route::get('/bendahara/pembayaran', [BendaharaController::class, 'pembayaran'])
    ->name('bendahara.pembayaran');
    Route::get('/bendahara/penjualan', [BendaharaController::class, 'penjualan'])
    ->name('bendahara.penjualan');
    Route::get('/bendahara/supplier', [BendaharaController::class, 'supplier'])
    ->name('bendahara.supplier');



    /////bendahara-laporan////
   Route::prefix('bendahara')->group(function () {
    // Halaman utama bendahara (opsional, jika ada halaman dashboard bendahara)
    Route::get('/', [KeuanganController::class, 'bendahara'])
        ->name('bendahara.index');

    // Laporan umum
    Route::get('/laporan', [BendaharaController::class, 'laporan'])
        ->name('bendahara.laporan');

    // Laporan Neraca
    Route::get('/laporan/neraca', [BendaharaController::class, 'laporanNeraca'])
        ->name('bendahara.laporan.neraca');

    // Laporan Laba Rugi
    Route::get('/laporan/laba-rugi', [BendaharaController::class, 'laporanLabaRugi'])
        ->name('bendahara.laporan.laba_rugi');
});

/////////////////////////////////TAGIHANSISWA///////////////////////////////////////////
Route::prefix('bendahara')->group(function () {
    // Halaman daftar & manajemen tagihan
    Route::get('/tagihan', [BendaharaController::class, 'tagihan'])
        ->name('bendahara.tagihan');

    // (Opsional) Endpoint jika nanti mau kirim data ke Laravel
    Route::post('/tagihan/simpan', [BendaharaController::class, 'simpanTagihan'])
        ->name('bendahara.tagihan.simpan');
});
///////jurnal/////

Route::get('/bendahara/jurnal', [BendaharaController::class, 'jurnal'])
     ->name('bendahara.jurnal');

///////////////walisantri/////////////////////
Route::prefix('wali')->group(function () {
    Route::get('/tagihan', [WaliController::class, 'tagihanWaliSantri'])
         ->name('wali.tagihan');
});

Route::prefix('wali')->group(function () {
    Route::get('/dashboard', [WaliController::class, 'dashboard'])->name('wali.dashboard');
    Route::get('/profil', [WaliController::class, 'profil'])->name('wali.profil');
    Route::get('/tagihan', [WaliController::class, 'tagihan'])->name('wali.tagihan');
});
