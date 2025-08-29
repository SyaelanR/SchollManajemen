<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    /**
     * Menampilkan halaman untuk menambah pengguna baru.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        // return view('admin.add_users'); //gunakan titik untuk masuk kedalam folder
        return view('dashboard');
    }

    public function manajSiswa()
    {
        return view('manajemen_siswa');
    }

    public function tambahSiswa()
    {
        return view('tambah_siswa');
    }
}
