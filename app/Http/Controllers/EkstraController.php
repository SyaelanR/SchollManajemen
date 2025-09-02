<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EkstraController extends Controller
{
    /**
     * Data mock untuk demo, ini akan diganti dengan model Eloquent di masa depan.
     */
    private $extracurriculars = [
        ['id' => 1, 'name' => 'Futsal', 'category' => 'olahraga', 'description' => 'Mengembangkan keterampilan bermain futsal dan kerjasama tim.', 'instructor' => 'Bapak Budi', 'schedule' => 'Selasa, 15:00 - 17:00'],
        ['id' => 2, 'name' => 'Paduan Suara', 'category' => 'seni', 'description' => 'Melatih kemampuan vokal dan harmoni dalam kelompok.', 'instructor' => 'Ibu Santi', 'schedule' => 'Rabu, 14:00 - 16:00'],
        ['id' => 3, 'name' => 'Klub Sains', 'category' => 'sains', 'description' => 'Eksperimen seru dan penelitian ilmiah.', 'instructor' => 'Bapak Roni', 'schedule' => 'Jumat, 14:30 - 16:30'],
        ['id' => 4, 'name' => 'Bahasa Inggris', 'category' => 'bahasa', 'description' => 'Meningkatkan kemampuan berbicara dan menulis bahasa Inggris.', 'instructor' => 'Miss Jane', 'schedule' => 'Senin, 15:30 - 17:00'],
        ['id' => 5, 'name' => 'Basket', 'category' => 'olahraga', 'description' => 'Mengasah teknik dribble, shooting, dan strategi permainan.', 'instructor' => 'Bapak Doni', 'schedule' => 'Senin, 15:00 - 17:00'],
        ['id' => 6, 'name' => 'Tari Tradisional', 'category' => 'seni', 'description' => 'Mengenal dan melestarikan tarian-tarian dari berbagai daerah.', 'instructor' => 'Ibu Maya', 'schedule' => 'Kamis, 14:30 - 16:30'],
        ['id' => 7, 'name' => 'Robotika', 'category' => 'sains', 'description' => 'Merakit dan memprogram robot untuk kompetisi.', 'instructor' => 'Bapak Junaedi', 'schedule' => 'Sabtu, 09:00 - 12:00'],
        ['id' => 8, 'name' => 'Seni Lukis', 'category' => 'seni', 'description' => 'Menjelajahi kreativitas melalui media lukis.', 'instructor' => 'Ibu Kartika', 'schedule' => 'Senin, 15:00 - 16:30'],
    ];

    /**
     * Menampilkan halaman daftar ekstrakurikuler.
     * Mengirimkan data ekstrakurikuler ke view.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $category = $request->query('category');
        $filteredData = $this->extracurriculars;

        // Logika filter dan pencarian
        if ($category && $category !== 'all') {
            $filteredData = array_filter($filteredData, fn($item) => $item['category'] === $category);
        }

        if ($search) {
            $search = strtolower($search);
            $filteredData = array_filter($filteredData, fn($item) =>
                str_contains(strtolower($item['name']), $search) ||
                str_contains(strtolower($item['description']), $search) ||
                str_contains(strtolower($item['instructor']), $search)
            );
        }

        return view('ekstra.index', ['extracurriculars' => $filteredData]);
    }

    /**
     * Menambahkan data ekstrakurikuler baru.
     */
    public function store(Request $request)
    {
        // Logika validasi dan penyimpanan ke database akan ditempatkan di sini
        // Untuk demo, kita hanya akan mencetak data.
        // dd($request->all());

        return redirect()->route('ekstrakurikuler.index');
    }
    
    /**
     * Memperbarui data ekstrakurikuler yang sudah ada.
     */
    public function update(Request $request, $id)
    {
        // Logika validasi dan pembaruan data akan ditempatkan di sini.
        // Untuk demo, kita hanya akan mencetak ID dan data.
        // dd($id, $request->all());

        return redirect()->route('ekstrakurikuler.index');
    }

    /**
     * Menghapus data ekstrakurikuler.
     */
    public function destroy($id)
    {
        // Logika penghapusan data akan ditempatkan di sini.
        // Untuk demo, kita hanya akan mencetak ID.
        // dd($id);
        
        return redirect()->route('ekstrakurikuler.index');
    }
}
