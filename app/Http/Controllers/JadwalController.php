<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index(string $kelas = null)
    {
        // Dummy data
        $jadwals = [
            ['kelas' => '10A', 'mapel' => 'Matematika', 'guru' => 'Pak Budi', 'hari' => 'Senin', 'jam' => '07:00'],
            ['kelas' => '10A', 'mapel' => 'Bahasa Indonesia', 'guru' => 'Bu Siti', 'hari' => 'Selasa', 'jam' => '08:00'],
            ['kelas' => '10B', 'mapel' => 'IPA', 'guru' => 'Pak Joko', 'hari' => 'Rabu', 'jam' => '07:00'],
            // Tambahkan sesuai kebutuhan
        ];

        // Filter per kelas jika ada parameter
        if ($kelas) {
            $jadwals = array_filter($jadwals, fn($j) => $j['kelas'] === $kelas);
        }

        return view('jadwal', ['jadwals' => $jadwals, 'kelas' => $kelas]);
    }
}
