<?php

namespace App\Http\Controllers;

use App\Models\Angkatan;
use App\Models\DaftarNilai;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\User;
use App\Models\Mapel;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function lihatjadwalG()
    {
        return view('guru.lihat_jadwalG');
    }

    public function manajNilaiKelas(Request $request)
    {
        $id_sekolah = $request->cookie('id_sekolah');
        $id_user = $request->cookie('id_user');

    $daftarkelasYangDiampu = Jadwal::with('kelas.angkatan', 'mapel')
        ->whereHas('mapel', function ($query) use ($id_user) {
            $query->where('id_guru', $id_user);
        })
        ->whereHas('kelas.angkatan', function ($query) use ($id_sekolah) {
            $query->where('id_sekolah', $id_sekolah);
        })
        ->whereHas('kelas.angkatan', function ($query) {
            $query->whereColumn('angkatans.semester', 'jadwals.semester');
        })
        ->whereHas('kelas.angkatan', function ($query) {
            $query->whereColumn('angkatans.id_tingkat', 'jadwals.tingkat');
        })
        ->whereHas('kelas.angkatan', function ($query) {
            // Filter Jadwal berdasarkan tingkat yang ada di relasi angkatan
            $query->whereColumn('angkatans.id_tingkat', 'jadwals.tingkat');
        })
        ->select('id_kelas', 'id_mapel') // hanya ambil kombinasi unik kelas+mapel
        ->distinct()
        // ->with('kelas.angkatan', 'mapel') // tetap load relasi
        ->get();

    // Iterasi untuk menghitung jumlah siswa untuk setiap kelas yang diampu
    foreach ($daftarkelasYangDiampu as $jadwal) {
        // Muat relasi yang dibutuhkan jika belum ada
        $jadwal->loadMissing('kelas.angkatan', 'mapel');
        // Hitung dan tambahkan properti jumlah_siswa ke setiap item jadwal
        $jadwal->jumlah_siswa = User::where('id_kelas', $jadwal->id_kelas)->count();
    }


        
        return view('guru.manajemen_nilai_kelas', ['daftarkelasYangDiampu' => $daftarkelasYangDiampu]);
    }

    public function inputNilai()
    {
        return view('guru.input_nilai');
    }

    public function manajNilaiDaftar(Request $request, $id_kelas, $id_mapel) 
    {
        $id_sekolah = $request->cookie('id_sekolah');
        $id_user = $request->cookie('id_user');

        $infoKelas = Jadwal::with('kelas')->where('id_kelas', $id_kelas)->firstOrFail();
        $infoMapel = Mapel::where('id_mapel', $id_mapel)
                    ->where('id_guru', $id_user)
                    ->firstOrFail();

        $infoAngkatan = Angkatan::where('id_angkatan', $infoKelas->kelas->id_angkatan)->first();

        // dd($infoKelas->semester);

        if($infoKelas->semester != $infoAngkatan->semester || $infoKelas->tingkat != $infoAngkatan->id_tingkat){
            abort(404);
        }
        

        $daftarNilai = DaftarNilai::with('mapel')
            ->where('id_kelas', $id_kelas)
            ->where('id_mapel', $id_mapel)
            ->where('id_sekolah', $id_sekolah)
            ->whereHas('mapel', function ($query) use ($id_user) {
                $query->where('id_guru', $id_user);
            })
            ->get();

        return view('guru.manajemen_nilai_daftar', ['daftarNilai' => $daftarNilai, 'infoKelas' => $infoKelas, 'infoMapel' => $infoMapel]);
    }

    public function storeDaftarNilai(Request $request, $id_kelas, $id_mapel)
    {
        $id_sekolah = $request->cookie('id_sekolah');
        $id_user = $request->cookie('id_user');

        $request->validate([
            'keterangan_nilai' => 'required|string|max:255',
            'tipe_nilai' => 'required|string|max:20',
            'tanggal'=> 'required|date'
        ],[
            'keterangan_nilai.required' => 'Keterangan tidak boleh kosong.',
            'keterangan_nilai.max' => 'Keterangan maksimal 255 karakter.',
            'tipe_nilai.required' => 'Tipe nilai tidak boleh kosong.',
            'tipe_nilai.max' => 'Tipe nilai maksimal 20 karakter.',
            'tanggal.required' => 'Tanggal tidak boleh kosong.'
        ]);

        $infoKelas = Kelas::with('angkatan')->where('id_kelas', $id_kelas)->first();
        $tingkat = $infoKelas->angkatan->id_tingkat;
        $semester = $infoKelas->angkatan->semester;

        DaftarNilai::create([
            'id_sekolah' => $id_sekolah,
            'id_kelas' => $id_kelas,
            'id_mapel' => $id_mapel,
            'keterangan' => $request->keterangan_nilai,
            'tipe_nilai' => $request->tipe_nilai,
            'tanggal' => $request->tanggal,
            'tingkat' => $tingkat,
            'semester' => $semester,
        ]);

        return redirect()->route('manajemenNilaiDaftar', ['id_kelas' => $id_kelas, 'id_mapel' => $id_mapel])->with('success', 'Nilai berhasil ditambahkan!');

    }
}
