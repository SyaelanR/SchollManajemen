<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EkstraController extends Controller
{
    // Halaman daftar ekstrakurikuler
    public function index()
{
    // Data dummy sebagai objek
    $extracurriculars = [
        (object)[
            'id' => 1,
            'name' => 'Basket',
            'category' => 'Olahraga',
            'description' => 'Tim basket sekolah untuk lomba antar sekolah.',
            'instructor' => 'Pak Joko',
            'schedule' => 'Senin & Kamis 15:00 - 17:00'
        ],
        (object)[
            'id' => 2,
            'name' => 'Paduan Suara',
            'category' => 'Seni',
            'description' => 'Kelompok paduan suara untuk lomba dan acara sekolah.',
            'instructor' => 'Bu Siti',
            'schedule' => 'Selasa & Jumat 14:00 - 16:00'
        ],
        (object)[
            'id' => 3,
            'name' => 'Pramuka',
            'category' => 'Ekstrakurikuler Lain',
            'description' => 'Kegiatan pramuka untuk pengembangan karakter siswa.',
            'instructor' => 'Pak Budi',
            'schedule' => 'Rabu 13:00 - 15:00'
        ],
    ];

    return view('ekstra.index', compact('extracurriculars'));
}

}
