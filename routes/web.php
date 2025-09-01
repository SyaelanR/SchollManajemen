<?php

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

Route::get('/kelas11A', [kelasController::class, 'kelas11A'])->name('kelas11A');

Route::get('/kelas11B', [kelasController::class, 'kelas11B'])->name('kelas11B');
