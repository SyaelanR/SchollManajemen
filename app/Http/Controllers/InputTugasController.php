<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InputTugasController extends Controller
{
    public function index($kelas)
    {
        $daftarTugas = [
            ['id' => 1, 'name' => 'Latihan Soal Matematika', 'dueDate' => '2025-11-25', 'kelas' => $kelas],
            ['id' => 2, 'name' => 'Esai Bahasa Indonesia', 'dueDate' => '2025-11-27', 'kelas' => $kelas],
        ];

        return view('inputtugas', compact('kelas', 'daftarTugas'));
    }

    public function create($kelas)
    {
        return view('formtugas', compact('kelas'));
    }

    public function store(Request $request, $kelas)
    {
        $request->validate([
            'task_name' => 'required|string|max:255',
            'due_date'  => 'required|date',
        ]);

        return redirect()->route('inputtugas.kelas', ['kelas' => $kelas])
                         ->with('success', 'Tugas berhasil ditambahkan!');
    }
}
