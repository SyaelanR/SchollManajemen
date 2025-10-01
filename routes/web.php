<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminDevController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\JadwalController;
use Illuminate\Auth\Events\Login;

// Rute Autentikasi Kustom
// Menggunakan middleware 'guest' agar pengguna yang sudah login tidak bisa mengakses halaman login lagi.
Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'create'])->name('login');
    Route::post('/', [LoginController::class, 'store']);
});


// Rute yang memerlukan autentikasi (hanya bisa diakses setelah login)\

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');

        // Grup rute ini sekarang hanya bisa diakses oleh pengguna dengan role 'admin'.
    Route::middleware('role:admin')->group(function () {
        Route::prefix('manajemen-siswa')->group(function () {
            Route::get('/', [AdminController::class, 'manajSiswa'])->name('manajemenSiswa');
            Route::get('/tambah-siswa', [AdminController::class, 'tambahSiswa'])->name('tambahSiswa');
            Route::post('/tambah-siswa', [AdminController::class, 'storeSiswa'])->name('storeSiswa');
            // Route untuk Edit Siswa
            Route::get('/{siswa}/edit', [AdminController::class, 'editSiswa'])->name('editSiswa');
            Route::put('/{siswa}', [AdminController::class, 'updateSiswa'])->name('updateSiswa');
            // Route untuk Hapus Siswa
            Route::delete('/{siswa}', [AdminController::class, 'hapusSiswa'])->name('hapusSiswa');
        });
        
        Route::prefix('manajemen-guru')->group(function () {
            Route::get('/', [AdminController::class, 'manajGuru'])->name('manajemenGuru');
            Route::get('/tambah-guru', [AdminController::class, 'tambahGuru'])->name('tambahGuru');
            Route::post('/tambah-guru', [AdminController::class, 'storeGuru'])->name('storeGuru');

            Route::delete('/{id}', [AdminController::class, 'hapusGuru'])->name('hapusGuru');

            Route::get('/edit_guru/{id}', [AdminController::class, 'editGuru'])->name('editGuru');

            Route::put('/manajemen-guru/{id}', [AdminController::class, 'updateGuru'])->name('updateGuru');
        });

        Route::prefix('manajemen-angkatan')->group(function () {
            Route::get('/', [AdminController::class, 'manajAngkatan'])->name('manajemenAngkatan');
            Route::post('/', [AdminController::class, 'storeAngkatan'])->name('storeAngkatan');
            Route::put('/{id}', [AdminController::class, 'updateAngkatan'])->name('updateAngkatan');
            Route::delete('/{id}', [AdminController::class, 'destroyAngkatan'])->name('destroyAngkatan');
        });

        Route::prefix('manajemen-kelas')->group(function () {
            Route::get('/', [AdminController::class, 'manajKelas'])->name('manajemenKelas');
            Route::post('/', [AdminController::class, 'storeKelas'])->name('storeKelas');
            // PERBAIKAN: Mengubah route untuk menerima ID kelas dari URL dengan method GET
            Route::get('/lihat-kelas/{id_kelas}', [AdminController::class, 'lihatKelas'])->name('lihatKelas');
            Route::post('/lihat-kelas/tambah-siswa-ke-kelas', [AdminController::class, 'tambahSiswaKeKelas'])->name('tambahSiswaKeKelas');

 
            Route::get('/edit-kelas/{id}', [AdminController::class, 'editKelas'])->name('editKelas');
            Route::put('/edit-kelas/{id}', [AdminController::class, 'updateKelas'])->name('updateKelas');
            Route::delete('/edit-kelas/{id}', [AdminController::class, 'destroyKelas'])->name('destroyKelas');
            Route::delete('/kelas/keluarkan-siswa/{id_siswa}/{id_kelas}', [AdminController::class, 'keluarkanSiswaDariKelas'])->name('keluarkanSiswaDariKelas');


            Route::delete('/{id_kelas}', [AdminController::class, 'destroyKelas'])->name('destroyKelas');

        });
        
        Route::prefix('manajemen-kurikulum')->group(function(){
            Route::get('/', [AdminController::class, 'manajKurikulum'])->name('manajemenKurikulum');
            Route::post('/', [AdminController::class, 'storeKurikulum'])->name('storeKurikulum');

        });

        Route::prefix('manajemen-keuangan')->group(function () {
            Route::get('/', [AdminController::class, 'manajKeuangan'])->name('manajemenKeuangan');
            Route::post('/pemasukan', [AdminController::class, 'storePemasukan'])->name('storePemasukan');
            Route::post('/pengeluaran', [AdminController::class, 'storePengeluaran'])->name('storePengeluaran');
            Route::get('/tagihan-siswa', [AdminController::class, 'tagihanSiswa'])->name('tagihanSiswa');
            Route::post('/tagihan-siswa', [AdminController::class, 'storeTagihan'])->name('storeTagihan');
            Route::post('/tagihan-siswa/pembayaran-tagihan', [AdminController::class, 'pembayaranTagihansiswa'])->name('pembayaranTagihanSiswa');
        });

        Route::prefix('manajemen-mapel')->group(function () {
            Route::get('/', [AdminController::class, 'manajMapel'])->name('manajemenMapel');
            // Route::get('/tambah-mapel', [AdminController::class, 'tambahMapel'])->name('tambahMapel');
            Route::post('/', [AdminController::class, 'storeMapel'])->name('storeMapel');
            Route::put('/{id}', [AdminController::class, 'updateMapel'])->name('updateMapel');
            Route::delete('/{id}', [AdminController::class, 'destroyMapel'])->name('destroyMapel');
        });

        Route::prefix('manajemen-jadwal')->group(function () {
            Route::get('/', [AdminController::class, 'manajJadwal'])->name('manajemenJadwal');
            Route::get('/tambah-jadwal/{id_kelas}', [AdminController::class, 'tambahJadwal'])->name('tambahJadwal');
            Route::post('/tambah-jadwal/{id_kelas}', [AdminController::class, 'storeJadwal'])->name('storeJadwal');
            Route::put('/update-jadwal/{id_jadwal}', [AdminController::class, 'updateJadwal'])->name('updateJadwal');

            // Rute untuk menghapus SEMUA jadwal berdasarkan ID KELAS
            Route::delete('/jadwal/kelas/{id_kelas}', [JadwalController::class, 'destroyByClass'])->name('jadwal.destroy.by_class');
            // Rute untuk menghapus SATU jadwal spesifik berdasarkan ID JADWAL
            Route::delete('/jadwal/{id_jadwal}', [AdminController::class, 'destroySingle'])->name('jadwal.destroy.single');
            
        });

        Route::prefix('manajemen-tingkat')->group(function () {
            Route::get('/', [AdminController::class, 'manajTingkat'])->name('manajemenTingkat');
            Route::post('/', [AdminController::class, 'storeTingkat'])->name('storeTingkat');
            Route::put('/{id_tingkat}', [AdminController::class, 'updateTingkat'])->name('updateTingkat');
            Route::delete('/{id_tingkat}', [AdminController::class, 'destroyTingkat'])->name('destroyTingkat');
        });

        Route::prefix('manajemen-rapor')->group(function (){
            Route::get('/', [AdminController::class, 'manajRapor'])->name('manajemenRapor');
            Route::get('/rapor/{id_kelas}', [AdminController::class, 'Rapors'])->name('Rapors');

        });

    });

        

        // Grup rute ini sekarang hanya bisa diakses oleh pengguna dengan role 'adminDev'.
    Route::middleware('role:adminDev')->group(function () {
        Route::get('/tambah-admin-klien/{id_sekolah}', [AdminDevController::class, 'tambahAdminKlien'])->name('tambahAdminKlien');
        Route::post('/tambah-admin-klien/{id_sekolah}', [AdminDevController::class, 'storeAdmin'])->name('storeAdmin');

        Route::get('/info-klien', [AdminDevController::class, 'infoKlienD'])->name('infoKlienD');
        Route::post('/info-klien', [AdminDevController::class, 'infoKlien'])->name('infoKlien');

        Route::get('/tambah-klien', [AdminDevController::class, 'tambahKlien'])->name('tambahKlien');
        Route::post('/tambah-klien', [AdminDevController::class, 'storeKlien'])->name('storeKlien');
    });


        //Grup rute ini sekarang hanya bisa diakses oleh pengguna dengan role 'guru'.
    Route::middleware('role:guru')->group(function () {
        Route::get('/lihat-jadwal-guru', [GuruController::class, 'lihatjadwalG'])->name('lihatjadwalG');

        Route::prefix('manajemen-nilai')->group(function () {
            Route::get('/', [GuruController::class, 'manajNilaiKelas'])->name('manajemenNilai');
            Route::get('/input-nilai/{id_kelas}/{id_mapel}/{id_daftar_nilai}', [GuruController::class, 'inputNilai'])->name('inputNilai');
            Route::get('/manajemen-nilai-daftar/{id_kelas}/{id_mapel}', [GuruController::class, 'manajNilaiDaftar'])->name('manajemenNilaiDaftar');
            Route::post('/manajemen-nilai-daftar/{id_kelas}/{id_mapel}', [GuruController::class, 'storeDaftarNilai'])->name('storeDaftarNilai');
            Route::post('/input-nilai', [GuruController::class, 'storeNilaiSiswa'])->name('storeNilaiSiswa');
            Route::put('/update-nilai/{id_daftar_nilai_siswa}', [GuruController::class, 'updateNilaiSiswa'])->name('updateNilaiSiswa');

            Route::get('/input-nilai-online/{id_kelas}/{id_mapel}/{id_daftar_nilai}', [GuruController::class, 'inputNilaiOnline'])->name('inputNilaiOnline');
            Route::get('/lihatTugasSiswa/{namaFile}', [GuruController::class, 'lihatTugasSiswa'])->name('lihatTugasSiswa');
            Route::get('/lihatSoalSiswa/{namaFile}', [GuruController::class, 'lihatSoalSiswa'])->name('lihatSoalSiswa');

        });


        Route::prefix('manajemen-absensi')->group(function () {
            Route::get('/', [GuruController::class, 'manajAbsensi'])->name('manajAbsensi');
            Route::get('/manajemen-absensi-daftar/{id_kelas}/{id_mapel}', [GuruController::class, 'manajAbsensiDaftar'])->name('manajAbsensiDaftar');
            Route::post('/manajemen-absensi-daftar/{id_kelas}/{id_mapel}', [GuruController::class, 'storeAbsensiDaftar'])->name('storeAbsensiDaftar');
            Route::get('/input-absensi/{id_kelas}/{id_mapel}/{id_daftar_absensi}', [GuruController::class, 'inputAbsensi'])->name('inputAbsensi');
            Route::post('/input-absensi', [GuruController::class, 'storeAbsensiSiswa'])->name('storeAbsensiSiswa');
            Route::put('/update-absensi/{id_daftar_absensi_siswa}', [GuruController::class, 'updateAbsensiSiswa'])->name('updateAbsensiSiswa');
        });


        Route::prefix('manajemen-tugas')->group(function () {
            Route::get('/', [GuruController::class, 'manajTugasKelas'])->name('manajTugas');
            Route::get('/input-tugas/{id_kelas}/{id_mapel}', [GuruController::class, 'inputTugas'])->name('inputTugas');
            Route::post('/input-tugas/{id_kelas}/{id_mapel}', [GuruController::class, 'storeTugas'])->name('storeTugas');

        });

        Route::prefix('manajemen-materi')->group(function () {
            Route::get('/', [GuruController::class, 'manajMateriKelas'])->name('manajMateri');
            Route::get('/input-materi/{id_kelas}/{id_mapel}', [GuruController::class, 'inputMateri'])->name('inputMateri');
            Route::post('/input-materi/{id_kelas}/{id_mapel}', [GuruController::class, 'storeMateri'])->name('storeMateri');

            Route::get('/lihat-materi/{namaFile}', [GuruController::class, 'lihatMateri'])->name('lihatMateri');
        });


        Route::prefix('manajemen-pengumuman')->group(function () {
            Route::get('/', [GuruController::class, 'manajPengumumanKelas'])->name('manajPengumuman');
            Route::get('/manajemen-pengumuman-daftar/{id_kelas}/{id_mapel}', [GuruController::class, 'manajPengumumanDaftar'])->name('manajPengumumanDaftar');
            Route::post('/manajemen-pengumuman-daftar/{id_kelas}/{id_mapel}', [GuruController::class, 'storePengumuman'])->name('storePengumumanDaftar');


        });



            
        
    });


    Route::middleware('role:siswa')->group(function () {

        Route::prefix('tugas-mapel')->group(function () {
            Route::get('', [SiswaController::class, 'lihatTugasMapel'])->name('lihatTugasMapel');
            Route::get('/tugas-daftar/{id_mapel}', [SiswaController::class, 'lihatTugasDaftar'])->name('lihatTugasDaftar');
            Route::get('/lihat-soal/{namaFile}', [SiswaController::class, 'lihatSoal'])->name('lihatSoal');
            Route::post('/unggah-tugas', [SiswaController::class, 'unggahTugas'])->name('unggahTugas');

            Route::get('/lihat-jawaban/{namaFile}', [SiswaController::class, 'lihatJawaban'])->name('lihatJawaban');
        });

        
    });

});





####################################################################################################################
    // // Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    // Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    // Route::get('/manajemen siswa', [AdminController::class, 'manajSiswa'])->name('manajemenSiswa');
    // Route::get('/tambah siswa', [AdminController::class, 'tambahSiswa'])->name('tambahSiswa');
    // Route::post('/tambah siswa', [AdminController::class, 'storeSiswa'])->name('storeSiswa');
    // Route::get('/', [LoginController::class, 'create'])->name('login');
    // Route::post('/', [LoginController::class, 'store']);

    // Route::get('/manajemen-guru', [AdminController::class, 'manajGuru'])->name('manajemenGuru');
    // Route::get('/tambah-guru', [AdminController::class, 'tambahGuru'])->name('tambahGuru');
    // Route::post('/tambah-guru', [AdminController::class, 'storeGuru'])->name('storeGuru');


    // Route::get('/manajemen-siswa', [AdminController::class, 'manajSiswa'])->name('manajemenSiswa');
    // Route::get('/tambah-siswa', [AdminController::class, 'tambahSiswa'])->name('tambahSiswa');
    // Route::post('/tambah-siswa', [AdminController::class, 'storeSiswa'])->name('storeSiswa');

    // Route::get('/manajemen-klien', [AdminDevController::class, 'manajKlien'])->name('manajemenKlien');
    // Route::get('/tambah-admin-klien', [AdminDevController::class, 'tambahKlien'])->name('tambahKlien');
    // Route::post('/tambah-admin-klien', [AdminDevController::class, 'storeAdmin'])->name('storeAdmin');

    // Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    // Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');



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
    Route::get('/   ', [absensiController::class, 'index'])->name('absensi.index');
    Route::get('/{id}', [absensiController::class, 'show'])->name('absensi.show');
    Route::post('/store', [absensiController::class, 'store'])->name('absensi.store');
});

// Rute untuk pelanggaranController
Route::get('/pelanggaran', [pelanggaranController::class, 'index'])->name('pelanggaran.index');
Route::post('/pelanggaran', [pelanggaranController::class, 'store'])->name('pelanggaran.store');
Route::get('/daftarPelanggar', [pelanggaranController::class, 'daftarPelanggar'])->name('pelanggaran.daftar');

Route::get('/input-nilai', [AdminController::class, 'inputnilai'])->name('inputnilai');



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
#####################################################################################################################################################
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Halaman daftar acara
Route::get('/acara-sekolah', [AdminController::class, 'index'])->name('admin.acara.index');
    Route::post('/acara-sekolah', [AdminController::class, 'store'])->name('admin.acara.store');
    Route::delete('/acara-sekolah/{id}', [AdminController::class, 'destroy'])->name('admin.acara.destroy');
