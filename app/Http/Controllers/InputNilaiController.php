<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InputNilaiController extends Controller
{
    // Halaman Pilih Kelas
    public function index()
    {
        $classes = ['10A', '10B', '11A', '11B'];
        $classCounts = ['10A'=>35, '10B'=>32, '11A'=>30, '11B'=>34];

        return view('inputnilaisiswa', compact('classes', 'classCounts'));
    }

    // Halaman Input Tugas per kelas
    public function tugasPerKelas($kelas)
    {
        $gradeTypes = ['Tugas', 'UTS', 'UAS']; // Bisa diambil dari DB juga
        return view('inputtugas', compact('kelas', 'gradeTypes'));
    }

    // Halaman Input Nilai per kelas
    public function kelasInput($kelas)
    {
        $students = [
            '10A' => ['Siswa 1','Siswa 2','Siswa 3','Siswa 4','Siswa 5'],
            '10B' => ['Siswa 6','Siswa 7','Siswa 8'],
            '11A' => ['Siswa 9','Siswa 10'],
            '11B' => ['Siswa 11','Siswa 12','Siswa 13','Siswa 14'],
        ];

        $studentList = $students[$kelas] ?? [];
        $gradeTypes = ['Tugas', 'UTS', 'UAS'];

        return view('inputtugas', compact('kelas', 'studentList', 'gradeTypes'));
    }public function inputNilai($kelas)
{
    $students = [
        '10A' => ['Siswa 1','Siswa 2','Siswa 3','Siswa 4','Siswa 5'],
        '10B' => ['Siswa 6','Siswa 7','Siswa 8'],
        '11A' => ['Siswa 9','Siswa 10'],
        '11B' => ['Siswa 11','Siswa 12','Siswa 13','Siswa 14'],
    ];

     $classes = ['10A', '10B', '11A', '11B'];
    $studentList = $students[$kelas] ?? [];
    $gradeTypes = ['Tugas', 'UTS', 'UAS'];

    return view('inputnilai', compact('kelas', 'studentList', 'gradeTypes', 'classes'));
}


    // Simpan Nilai
    public function simpanNilai(Request $request)
    {
        $grades = $request->input('grades');
        
        // Validasi sederhana
        $request->validate([
            'grades' => 'required|array',
            'grades.*' => 'numeric|min:0|max:100',
        ]);

        // Simpan ke DB sesuai kebutuhan
        return redirect()->back()->with('success','Nilai berhasil disimpan!');
    }
}
