<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KelasController;

// Dashboard (halaman utama)
Route::get('/', [KelasController::class, 'index'])->name('dashboard');

// Jadwal
Route::get('/jadwal', [KelasController::class, 'jadwal'])->name('jadwal');

//Halaman kelas
Route::get('/kelas10A', [KelasController::class, 'kelas10A'])->name('kelas10A');
Route::get('/kelas10B', [KelasController::class, 'kelas10B'])->name('kelas10B');
Route::get('/kelas11A', [KelasController::class, 'kelas11A'])->name('kelas11A');
Route::get('/kelas11B', [KelasController::class, 'kelas11B'])->name('kelas11B');
