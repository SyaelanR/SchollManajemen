<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InputNilaiController extends Controller
{
    public function index()
    {
        $classes = ['10A', '10B', '11A', '11B'];
        $classCounts = ['10A'=>35, '10B'=>32, '11A'=>30, '11B'=>34];

        return view('inputnilaisiswa', compact('classes', 'classCounts'));
    }

    public function tugasPerKelas($kelas)
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
    }

    public function inputNilai($kelas)
    {
        $students = [
            '10A' => ['Siswa 1','Siswa 2','Siswa 3','Siswa 4','Siswa 5'],
            '10B' => ['Siswa 6','Siswa 7','Siswa 8'],
            '11A' => ['Siswa 9','Siswa 10'],
            '11B' => ['Siswa 11','Siswa 12','Siswa 13','Siswa 14'],
        ];

        $studentList = $students[$kelas] ?? [];
        $gradeTypes = ['Tugas', 'UTS', 'UAS'];
        $classes = ['10A', '10B', '11A', '11B'];

        return view('inputnilaisiswa', compact('kelas', 'studentList', 'gradeTypes', 'classes'));
    }

    public function inputNilaiQuery(Request $request)
    {
        $kelas = $request->query('kelas');

        $students = [
            '10A' => ['Siswa 1','Siswa 2','Siswa 3','Siswa 4','Siswa 5'],
            '10B' => ['Siswa 6','Siswa 7','Siswa 8'],
            '11A' => ['Siswa 9','Siswa 10'],
            '11B' => ['Siswa 11','Siswa 12','Siswa 13','Siswa 14'],
        ];

        $studentList = $students[$kelas] ?? [];
        $gradeTypes = ['Tugas', 'UTS', 'UAS'];
        $classes = ['10A', '10B', '11A', '11B'];

        // ✅ Perbaikan disini: view harus sama seperti file blade yang ada
        return view('inputnilaisiswa', compact('kelas', 'studentList', 'gradeTypes', 'classes'));
    }

    public function simpanNilai(Request $request)
    {
        $request->validate([
            'grades' => 'required|array',
            'grades.*' => 'numeric|min:0|max:100',
        ]);

        // $grades = $request->input('grades');
        // TODO: Simpan ke database

        return redirect()->back()->with('success','Nilai berhasil disimpan!');
    }
}
