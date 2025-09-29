<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WaliController extends Controller
{
       public function dashboard()
    {
        return view('wali.dashboard');
    }

    public function profil()
    {
        return view('wali.profil'); // buat file resources/views/wali/profil.blade.php
    }

    public function tagihan()
    {
        return view('wali.tagihanwalisantri'); // atau sesuaikan dengan nama file yang kamu buat
    }
    public function tagihanWaliSantri()
    {
        // Jika perlu kirim data ke view, masukkan di array kedua
        return view('wali.tagihanwalisantri');
    }
}
