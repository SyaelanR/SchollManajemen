<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;

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

    /**
     * Menghapus semua jadwal yang terkait dengan ID kelas tertentu.
     *
     * @param int $id_kelas ID dari kelas yang jadwalnya akan dihapus.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyByClass(Request $request, $id_kelas)
    {
        $id_sekolah = $request->cookie('id_sekolah');

        // Menghapus semua entri jadwal yang cocok dengan id_kelas dan id_sekolah
        Jadwal::where('id_kelas', $id_kelas)
            ->where('id_sekolah', $id_sekolah)
            ->delete();

        return redirect()->back()->with('success', 'Semua jadwal untuk kelas ini berhasil dihapus.');
    }

    /**
     * Menghapus satu jadwal spesifik berdasarkan ID jadwal.
     *
     * @param int $id_jadwal ID dari jadwal yang akan dihapus.
     * @return \Illuminate\Http\RedirectResponse
     */
    
}
