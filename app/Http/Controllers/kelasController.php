<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KelasController extends Controller
{
    // Halaman utama (dashboard)
    public function index()
    {
        return view('dashboard');
    }

    // Halaman jadwal umum
    public function jadwal()
    {
        return view('jadwal');
    }

    // --- View khusus tiap kelas ---
    public function kelas10A()
    {
        return view('kelas10A');
    }

    public function kelas10B()
    {
        return view('kelas10B');
    }

    public function kelas11A()
    {
        return view('kelas11A'); // diperbaiki
    }

    public function kelas11B()
    {
        return view('kelas11B');
    }

    public function kelas12A()
    {
        return view('kelas12A');
    }

    public function kelas12B()
    {
        return view('kelas12B');
    }

    // --- Alternatif dinamis ---
    // Bisa dipakai kalau tidak mau buat method per kelas
    public function show($jadwal)
    {
        // Contoh: /kelas/10A akan cari file resources/views/kelas/10A.blade.php
        return view("jadwal.$jadwal");
    }
}
