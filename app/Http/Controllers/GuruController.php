<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function lihatjadwalG()
    {
        return view('guru.lihat_jadwalG');
    }
}
