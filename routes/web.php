<?php
<<<<<<< HEAD

use Illuminate\Support\Facades\Route;

// Dashboard (halaman utama)    
// Route::get('/', function () {
//     return view('dashboard');
// });
use App\Http\Controllers\kelasController;

Route::get('/', [kelasController::class, 'index'])->name('dashboard');

Route::get('/jadwal', [kelasController::class, 'jadwal'])->name('jadwal');

Route::get('/kelas10A', [kelasController::class, 'kelas10A'])->name('kelas10A');

Route::get('/kelas10B', [kelasController::class, 'kelas10B'])->name('kelas10B');

=======
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KesiswaanController;
>>>>>>> bd27f5772cb83bd35a4cbbdc0ef7910ee2c30c91

