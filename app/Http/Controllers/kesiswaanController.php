<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KesiswaanController extends Controller
{
    // Menampilkan daftar siswa
    public function index()
    {
        // ambil data dari model (misalnya Student)
        // $students = Student::all();

        // untuk contoh, kita pakai array dummy
        $students = [
            ['id' => 1, 'nama' => 'Andi', 'kelas' => 'X IPA 1'],
            ['id' => 2, 'nama' => 'Budi', 'kelas' => 'XI IPS 2'],
        ];

        return view('kesiswaan.index', compact('students'));
    }

    // Menampilkan form tambah siswa
    public function create()
    {
        return view('kesiswaan.create');
    }

    // Proses simpan siswa baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
        ]);

        // Simpan ke database (contoh)
        // Student::create($request->all());

        return redirect()->route('kesiswaan.index')->with('success', 'Data siswa berhasil ditambahkan');
    }

    // Menampilkan detail siswa tertentu
    public function show($id)
    {
        // $student = Student::findOrFail($id);

        $student = ['id' => $id, 'nama' => 'Contoh', 'kelas' => 'X IPA 1'];

        return view('kesiswaan.show', compact('student'));
    }

    // Menampilkan form edit siswa
    public function edit($id)
    {
        // $student = Student::findOrFail($id);

        $student = ['id' => $id, 'nama' => 'Contoh', 'kelas' => 'X IPA 1'];

        return view('kesiswaan.edit', compact('student'));
    }

    // Proses update siswa
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
        ]);

        // $student = Student::findOrFail($id);
        // $student->update($request->all());

        return redirect()->route('kesiswaan.index')->with('success', 'Data siswa berhasil diperbarui');
    }

    // Hapus siswa
    public function destroy($id)
    {
        // $student = Student::findOrFail($id);
        // $student->delete();

        return redirect()->route('kesiswaan.index')->with('success', 'Data siswa berhasil dihapus');
    }
}
