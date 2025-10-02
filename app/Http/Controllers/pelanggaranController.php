<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pelanggaran;
use App\Models\Kelas;

class pelanggaranController extends Controller
{
    /**
     * Tampilkan halaman utama (index) dengan formulir tambah data.
     * Dalam kasus ini, kita akan menampilkan file 'pelanggaran.index'.
     */
    public function index(Request $request)
    {
        $id_sekolah = $request->cookie('id_sekolah');

        // Mengambil semua data kelas dari sekolah yang aktif
        $kelasList = Kelas::where('id_sekolah', $id_sekolah)->latest()->get();

        // Mengirimkan data kelas ke view
        return view('pelanggaran.index', ['kelasList' => $kelasList]);
    }

    /**
     * Proses dan simpan data pelanggaran yang dikirim dari formulir.
     */
    public function store(Request $request)
    {
        // Validasi data yang dikirim dari formulir
        $validated = $request->validate([
            'id_siswa' => 'required|exists:users,id',
            'id_kelas' => 'required|exists:kelas,id_kelas',
            'jenis_pelanggaran' => 'required|string',
            'keterangan' => 'nullable|string',
            'tanggal' => 'required|date',
            'poin' => 'required|integer|min:1',
        ]);

        $id_sekolah = $request->cookie('id_sekolah');

        Pelanggaran::create([
            'id_sekolah' => $id_sekolah,
            'id_siswa' => $validated['id_siswa'],
            'id_kelas' => $validated['id_kelas'],
            'jenis_pelanggaran' => $validated['jenis_pelanggaran'],
            'keterangan' => $validated['keterangan'],
            'poin' => $validated['poin'],
            'tanggal' => $validated['tanggal'],
        ]);
        // Kembali ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Pelanggaran berhasil ditambahkan!');
    }

    public function daftarPelanggar(Request $request, $id_kelas)
    {
        $id_sekolah = $request->cookie('id_sekolah');

        // Ambil informasi kelas
        $kelas = Kelas::where('id_kelas', $id_kelas)
                      ->where('id_sekolah', $id_sekolah)
                      ->firstOrFail();

        // Ambil daftar siswa dari kelas tersebut
        $daftarSiswa = User::where('id_kelas', $id_kelas)
                            ->where('id_sekolah', $id_sekolah)
                            ->where('role', 'siswa')
                            ->get();
        
        // Ambil semua pelanggaran untuk kelas ini
        $pelanggarans = Pelanggaran::where('id_kelas', $id_kelas)
                                ->where('id_sekolah', $id_sekolah)
                                ->with('siswa') // Eager load data siswa
                                ->orderBy('tanggal', 'desc')
                                ->get();

        return view('pelanggaran.daftar-pelanggar', compact('kelas', 'daftarSiswa', 'pelanggarans'));
    }

    public function update(Request $request, Pelanggaran $pelanggaran)
    {
        $validated = $request->validate([
            'jenis_pelanggaran' => 'required|string',
            'keterangan' => 'nullable|string',
            'tanggal' => 'required|date',
            'poin' => 'required|integer|min:1',
        ]);

        $pelanggaran->update($validated);

        return back()->with('success', 'Data pelanggaran berhasil diperbarui!');
    }

    public function destroy(Pelanggaran $pelanggaran)
    {
        $pelanggaran->delete();
        return back()->with('success', 'Data pelanggaran berhasil dihapus!');
    }
}
