<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\Kelas; // Model tidak diperlukan untuk data sintetis
// use App\Models\Siswa; // Model tidak diperlukan untuk data sintetis
// use App\Models\Absensi; // Model tidak diperlukan untuk data sintetis

class absensiController extends Controller
{
    /**
     * Menampilkan halaman utama absensi dengan data kelas statis (sintetis).
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Data kelas statis untuk tujuan demonstrasi
        $kelas = [
            (object)['id' => 1, 'nama_kelas' => 'Kelas 10A'],
            (object)['id' => 2, 'nama_kelas' => 'Kelas 10B'],
            (object)['id' => 3, 'nama_kelas' => 'Kelas 11A'],
            (object)['id' => 4, 'nama_kelas' => 'Kelas 11B'],
            (object)['id' => 5, 'nama_kelas' => 'Kelas 12A'],
            (object)['id' => 6, 'nama_kelas' => 'Kelas 12B'],
        ];

        return view('absensi', compact('kelas'));
    }

    /**
     * Menampilkan daftar siswa statis (sintetis) untuk kelas tertentu.
     *
     * @param string $kelasId
     * @return \Illuminate\View\View
     */
    public function show(string $kelasId)
    {
        // Data siswa statis untuk tujuan demonstrasi
        $siswaData = [
            '1' => [
                (object)['id' => 1, 'nama_siswa' => 'Budi Santoso', 'nisn' => '12345'],
                (object)['id' => 2, 'nama_siswa' => 'Siti Nurhaliza', 'nisn' => '12346'],
                (object)['id' => 3, 'nama_siswa' => 'Joko Permadi', 'nisn' => '12347'],
            ],
            '2' => [
                (object)['id' => 4, 'nama_siswa' => 'Rini Indriyani', 'nisn' => '12348'],
                (object)['id' => 5, 'nama_siswa' => 'Andi Wijaya', 'nisn' => '12349'],
                (object)['id' => 6, 'nama_siswa' => 'Dewi Anggraini', 'nisn' => '12350'],
            ],
        ];

        // Cari data kelas berdasarkan ID statis
        $kelas = (object)['id' => $kelasId, 'nama_kelas' => 'Kelas ' . ($kelasId == 1 ? '10A' : '10B')];
        $siswa = $siswaData[$kelasId] ?? [];

        return view('absensi.show', compact('kelas', 'siswa'));
    }

    /**
     * Menyimpan data absensi yang dikirim dari formulir (belum terhubung ke database).
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            // Validasi data yang masuk
            $request->validate([
                'absensi' => 'required|array',
                'absensi.*.siswa_id' => 'required', // simplified validation
                'absensi.*.status' => 'required|in:Hadir,Sakit,Izin,Alpa',
                'absensi.*.tanggal' => 'required|date',
            ]);
        } catch (\Exception $e) {
            // Tangani kesalahan validasi atau lainnya
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }

        // Tampilkan data yang dikirimkan (untuk debug)
        return redirect()->back()->with('success', 'Absensi berhasil diproses (data tidak disimpan ke database).');
    }
}
