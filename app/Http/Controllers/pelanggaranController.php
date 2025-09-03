<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class pelanggaranController extends Controller
{
    /**
     * Tampilkan halaman utama (index) dengan formulir tambah data.
     * Dalam kasus ini, kita akan menampilkan file 'kesiswaan.index'.
     */
    public function index()
    {
        return view('pelanggaran.index');
    }

    /**
     * Proses dan simpan data pelanggaran yang dikirim dari formulir.
     */
    public function store(Request $request)
    {
        // Validasi data yang dikirim dari formulir
        $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'jenis_pelanggaran' => 'required|string',
            'tanggal' => 'required|date',
            'poin' => 'required|integer|min:5|max:100',
        ]);

        // Catatan: Di sini adalah tempat di mana Anda akan menambahkan
        // kode untuk menyimpan data ke database. Contoh:
        // Pelanggaran::create($request->all());

        // Kembali ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Pelanggaran berhasil ditambahkan!');
    }

    public function daftarPelanggar()
    {
        return view('pelanggaran.daftar-pelanggar');
    }
}
