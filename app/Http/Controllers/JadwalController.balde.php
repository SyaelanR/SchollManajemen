<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    // Tampilkan semua jadwal atau per kelas
    public function index(string $kelas = null)
    {
        $jadwals = Jadwal::when($kelas, fn($query) => $query->where('kelas', $kelas))
                          ->orderBy('hari') // contoh sorting
                          ->get();

        return view('jadwal', compact('jadwals', 'kelas'));
    }

    // Simpan jadwal baru
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'kelas' => 'required|string|max:10',
            'mata_pelajaran' => 'required|string|max:255',
            'guru' => 'required|string|max:255',
            'hari' => 'required|string|max:20',
            'jam' => 'required|string|max:20',
        ]);

        Jadwal::create($validated);

        return redirect()->route('jadwal')->with('success', 'Jadwal berhasil ditambahkan');
    }

    // Hapus jadwal
    public function destroy(int $id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('jadwal')->with('success', 'Jadwal berhasil dihapus');
    }

    // Update jadwal
    public function update(Request $request, int $id)
    {
        // Validasi input
        $validated = $request->validate([
            'kelas' => 'required|string|max:10',
            'mata_pelajaran' => 'required|string|max:255',
            'guru' => 'required|string|max:255',
            'hari' => 'required|string|max:20',
            'jam' => 'required|string|max:20',
        ]);

        $jadwal = Jadwal::findOrFail($id);
        $jadwal->update($validated);

        return redirect()->route('jadwal')->with('success', 'Jadwal berhasil diperbarui');
    }
}
