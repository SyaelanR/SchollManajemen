use App\Http\Controllers\JadwalController;

Route::get('/', function () {
    return view('dashboard'); // Halaman utama dashboard
});

// Lihat jadwal per kelas
Route::get('/kelas/{kelas}', [JadwalController::class, 'index']);

// Tambah jadwal
Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');

// Update jadwal
Route::put('/jadwal/{id}', [JadwalController::class, 'update'])->name('jadwal.update');

// Hapus jadwal
Route::delete('/jadwal/{id}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');
