<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InputNilaiController extends Controller
{
    public function index()
    {
        $classes = ['10A', '10B', '11A', '11B', '12A', '12B'];
        $classCounts = [
            '10A' => 30, '10B' => 28, '11A' => 29, '11B' => 25, '12A' => 27, '12B' => 35,
        ];

        return view('kelas', compact('classes', 'classCounts'));
    }

    public function tugasPerKelas($kelas)
    {
        $daftarTugas = [
            ['id' => 1, 'nama_tugas' => 'Latihan Soal Matematika', 'tanggal' => '2025-11-25'],
            ['id' => 2, 'nama_tugas' => 'Esai Bahasa Indonesia', 'tanggal' => '2025-11-27'],
            ['id' => 3, 'nama_tugas' => 'Ulangan Fisika', 'tanggal' => '2025-12-01'],
            ['id' => 4, 'nama_tugas' => 'Ulangan Kimia', 'tanggal' => '2025-12-03'],
        ];

        return view('inputtugas', compact('kelas', 'daftarTugas'));
    }

    public function inputNilai($kelas, $tugas_id)
    {
        $daftarTugas = [
            1 => ['nama_tugas' => 'Latihan Soal Matematika'],
            2 => ['nama_tugas' => 'Esai Bahasa Indonesia'],
            3 => ['nama_tugas' => 'Ulangan Fisika'],
            4 => ['nama_tugas' => 'Ulangan Kimia'],
        ];
        $namaTugas = $daftarTugas[$tugas_id]['nama_tugas'] ?? 'Tugas Tidak Dikenal';

        $students = [
            '10A' => [['id'=>101,'nama'=>'Latief Prayoga'],['id'=>102,'nama'=>'Siti Aminah'],['id'=>103,'nama'=>'Budi Santoso']],
            '10B' => [['id'=>201,'nama'=>'Ahmad Fauzi'],['id'=>202,'nama'=>'Rina Sari']],
            '11A' => [['id'=>301,'nama'=>'Dewi Lestari'],['id'=>302,'nama'=>'Teguh Prakoso']],
            '11B' => [['id'=>401,'nama'=>'Andi Wijaya'],['id'=>402,'nama'=>'Rizki Amelia']],
        ];

        $studentList = $students[$kelas] ?? [];

        return view('inputnilaisiswa', compact('kelas','tugas_id','namaTugas','studentList'));
    }

    // Tambahan method baru untuk route langsung ke inputnilaisiswa
    public function inputNilaiSiswa()
    {
        // Misal default: kelas 10A, tugas id 1
        return $this->inputNilai('10A', 1);
    }

    public function simpanNilai(Request $request)
    {
        $request->validate([
            'grades'  => 'required|array',
            'grades.*.student_id' => 'required|integer',
            'grades.*.nilai' => 'required|numeric|min:0|max:100',
        ]);

        foreach ($request->grades as $gradeData) {
            $studentId = $gradeData['student_id'];
            $nilai = $gradeData['nilai'];
            $kelas = $request->kelas;
            $tugas_id = $request->tugas_id;
            // Simpan ke database sesuai kebutuhan
        }

        return back()->with('success', 'Nilai berhasil disimpan!');
    }
}
