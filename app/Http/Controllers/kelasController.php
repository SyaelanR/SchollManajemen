<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function show($nama)
    {
        return view('jadwal', compact('nama'));
    }
    
    public function jadwal() {
        return view ('jadwal');
    }
    
    public function kelas10A() {
        return view ('kelas10A');
    }
    
    public function kelas10B() {
        return view ('kelas10B');
    }
    
    public function kelas11A() {
        return view ('kelas11A');
    }

    public function kelas11B() {
        return view ('kelas11B');
    }
}
