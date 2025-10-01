<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NilaiController extends Controller
{
    /**
     * Menampilkan daftar kelas untuk input nilai.
     * Dalam kasus nyata, data kelas bisa diambil dari database.
     */
    public function index()
    {
        // Data tiruan untuk daftar kelas
        $classes = [
            ['name' => 'Kelas 10A', 'students' => 35],
            ['name' => 'Kelas 10B', 'students' => 32],
            ['name' => 'Kelas 11A', 'students' => 30],
            ['name' => 'Kelas 11B', 'students' => 34],
        ];

        // Mengirim data kelas ke view
        return view('guru.input-nilai', compact('classes'));
    }

    /**
     * Menampilkan tabel siswa dari kelas yang dipilih.
     *
     * @param string $className Nama kelas yang dipilih.
     */
    public function showStudents($className)
    {
        // Data siswa tiruan
        $studentData = [
            '10A' => [
                ['id' => 1, 'nama' => 'Andi Saputra', 'tugas' => 85, 'uts' => 90, 'uas' => 88],
                ['id' => 2, 'nama' => 'Budi Candra', 'tugas' => 75, 'uts' => 80, 'uas' => 78],
                ['id' => 3, 'nama' => 'Citra Dewi', 'tugas' => 90, 'uts' => 95, 'uas' => 92],
            ],
            '10B' => [
                ['id' => 4, 'nama' => 'Dewi Lestari', 'tugas' => 88, 'uts' => 85, 'uas' => 90],
                ['id' => 5, 'nama' => 'Eko Prasetyo', 'tugas' => 70, 'uts' => 75, 'uas' => 72],
            ],
            '11A' => [
                ['id' => 6, 'nama' => 'Fina Ramadhani', 'tugas' => 95, 'uts' => 92, 'uas' => 96],
                ['id' => 7, 'nama' => 'Gani Pratama', 'tugas' => 80, 'uts' => 82, 'uas' => 81],
            ],
            '11B' => [
                ['id' => 8, 'nama' => 'Hani Wijaya', 'tugas' => 85, 'uts' => 88, 'uas' => 87],
            ]
        ];

        // Pastikan kelas yang diminta ada
        $students = $studentData[$className] ?? [];
        
        // Mengirim data siswa dan nama kelas ke view
        return view('guru.input-nilai', compact('className', 'students'));
    }

    /**
     * Menyimpan nilai yang diinput ke database.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        // Ambil data nilai dari request
        $students = $request->input('siswa');

        // Lakukan perulangan untuk setiap siswa
        foreach ($students as $studentId => $nilai) {
            // Contoh sederhana: menyimpan data ke database
            // Di sini Anda bisa menggunakan Eloquent atau DB::table
            // Misalnya:
            // DB::table('nilai')->insert([
            //     'siswa_id' => $studentId,
            //     'nilai_tugas' => $nilai['tugas'],
            //     'nilai_uts' => $nilai['uts'],
            //     'nilai_uas' => $nilai['uas'],
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ]);
            
            // Atau menggunakan model Eloquent:
            // Nilai::updateOrCreate(
            //     ['siswa_id' => $studentId],
            //     ['nilai_tugas' => $nilai['tugas'], 'nilai_uts' => $nilai['uts'], 'nilai_uas' => $nilai['uas']]
            // );
        }

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Nilai berhasil disimpan!');
    }
}
