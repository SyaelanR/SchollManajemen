<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    /**
     * Tampilkan halaman input absensi dengan data dummy
     */
    public function index()
    {
        $students = [
            ['id' => 1, 'nama' => 'Latief Prayoga'],
            ['id' => 2, 'nama' => 'Siti Aminah'],
            ['id' => 3, 'nama' => 'Budi Santoso'],
        ];

        return view('inputabsen', compact('students'));
    }

    /**
     * Simpan absensi (sementara hanya return JSON)
     */
    public function store(Request $request)
    {
        // Validasi input sederhana
        $validated = $request->validate([
            'status.*' => 'required|in:Hadir,Sakit,Izin,Alpha',
        ]);

        $tanggal = Carbon::now()->toDateString();

        $result = [];

        foreach ($validated['status'] ?? [] as $siswaId => $status) {
            $result[] = [
                'siswa_id' => $siswaId,
                'tanggal' => $tanggal,
                'status' => $status
            ];
        }

        return response()->json([
            'message' => 'Absensi berhasil disimpan (dummy)!',
            'data' => $result
        ]);
    }
}
