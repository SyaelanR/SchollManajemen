<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KeuanganController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/keuangan', [KeuanganController::class, 'pengeluaran'])->name('keuangan');