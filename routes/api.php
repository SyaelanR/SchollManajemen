<?php

use App\Http\Controllers\APIController;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return response()->json(['message' => 'API aktif']);
});

Route::post('/terima-data-jadwal', [APIController::class, 'terimaDataJadwal'])->name('terimaDataJadwal');