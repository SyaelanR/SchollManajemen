<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    public function index()
    {
        return "Ini halaman utama keuangan sekolah";
    }

    public function pemasukan()
    {
        return view('pemasukan');
    }

    public function pengeluaran()
    {
        return "Ini halaman pengeluaran sekolah";
    }
}
