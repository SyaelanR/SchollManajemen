<?php

namespace App\Http\Controllers;

use App\Models\Angkatan;
use App\Models\DaftarAbsensi;
use App\Models\DaftarAbsensiSiswa;
use App\Models\DaftarNilai;
use App\Models\DaftarNilaiSiswa;
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

    public function inputNilai(Request $request, int $id_kelas, int $id_mapel, int $id_daftar_nilai)
    {
        $id_sekolah = $request->cookie('id_sekolah');
        $id_user = $request->cookie('id_user');
        
        $infoKelas = Jadwal::with('kelas')
                    ->where('id_kelas', $id_kelas)
                    ->where('id_mapel', $id_mapel)
                    ->where('id_sekolah', $id_sekolah)
                    ->firstOrFail();
        $infoMapel = Mapel::where('id_mapel', $id_mapel)
                    ->where('id_guru', $id_user)
                    ->where('id_sekolah', $id_sekolah)
                    ->firstOrFail();
        $infoDaftarNilai = DaftarNilai::where('id_daftar_nilai', $id_daftar_nilai)
                    ->where('id_mapel', $id_mapel)
                    ->where('id_kelas', $id_kelas)
                    ->where('id_sekolah', $id_sekolah)
                    ->firstOrFail();


        $infoAngkatan = Angkatan::where('id_angkatan', $infoKelas->kelas->id_angkatan)->first();

        if(!$infoAngkatan || $infoKelas->semester != $infoAngkatan->semester || $infoKelas->tingkat != $infoAngkatan->id_tingkat || $infoDaftarNilai->semester != $infoAngkatan->semester || $infoDaftarNilai->tingkat != $infoAngkatan->id_tingkat){
            abort(404);
        }
        
        $daftarSiswa = DaftarNilaiSiswa::where('id_kelas', $id_kelas)
                    ->where('semester', $infoAngkatan->semester)
                    ->where('tingkat', $infoAngkatan->id_tingkat)
                    ->where('id_mapel', $id_mapel)
                    ->where('id_sekolah', $id_sekolah)
                    ->where('id_daftar_nilai', $id_daftar_nilai)
                    ->with('siswa')->get();

        return view('guru.input_nilai', compact('daftarSiswa', 'infoKelas', 'infoMapel', 'infoDaftarNilai'));
    }

    public function storeNilaiSiswa(Request $request)
    {
        // 1. Validasi input dari form
        $request->validate([
            // 'nilai' harus ada dan berupa array
            'nilai' => 'present|array',
            // Setiap item di dalam array 'nilai' boleh kosong (nullable), tapi jika diisi harus berupa angka antara 0-100
            'nilai.*' => 'nullable|numeric|min:0|max:100',
        ]);

        // dd($request->nilai);

        // 2. Lakukan perulangan untuk setiap nilai yang dikirim
        foreach ($request->nilai as $id_daftar_nilai_siswa => $input_nilai) {
            // Jika input nilai kosong (null), atur nilainya menjadi 0. Jika tidak, gunakan nilai dari input.
            $nilai_final = $input_nilai ?? 0;
            // Cari record nilai siswa berdasarkan ID dan perbarui nilainya
            DaftarNilaiSiswa::where('id_daftar_nilai_siswa', $id_daftar_nilai_siswa)->update(['nilai' => $nilai_final]);
        }

        // 3. Kembali ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Nilai siswa berhasil disimpan!');
    }



    public function manajNilaiDaftar(Request $request, $id_kelas, $id_mapel) 
    {
        $id_sekolah = $request->cookie('id_sekolah');
        $id_user = $request->cookie('id_user');

        $infoKelas = Jadwal::with('kelas')
                    ->where('id_kelas', $id_kelas)
                    ->where('id_mapel', $id_mapel)
                    ->where('id_sekolah', $id_sekolah)
                    ->firstOrFail();
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

        $DaftarNilai = DaftarNilai::create([
                'id_sekolah' => $id_sekolah,
                'id_kelas' => $id_kelas,
                'id_mapel' => $id_mapel,
                'keterangan' => $request->keterangan_nilai,
                'tipe_nilai' => $request->tipe_nilai,
                'tanggal' => $request->tanggal,
                'tingkat' => $tingkat,
                'semester' => $semester,
            ]);


        $targetSiswa = User::where('id_kelas', $id_kelas)
                    ->where('id_sekolah', $id_sekolah)
                    ->where('role', 'siswa')
                    ->get();

        foreach ($targetSiswa as $siswa) {
            DaftarNilaiSiswa::create([
                'id_sekolah' => $id_sekolah,
                'id_kelas' => $id_kelas,
                'id_mapel' => $id_mapel,
                'id_siswa' => $siswa->id,
                'id_daftar_nilai' => $DaftarNilai->id_daftar_nilai,
                'tingkat' => $tingkat,
                'semester' => $semester,
            ]);
        }

        return redirect()->route('manajemenNilaiDaftar', ['id_kelas' => $id_kelas, 'id_mapel' => $id_mapel])->with('success', 'Nilai berhasil ditambahkan!');

    }

    public function manajAbsensi (Request $request)
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


        
        return view('guru.manajemen_absensi_kelas', ['daftarkelasYangDiampu' => $daftarkelasYangDiampu]);
    }



    public function manajAbsensiDaftar (Request $request, $id_kelas, $id_mapel) 
    {
        $id_sekolah = $request->cookie('id_sekolah');
        $id_user = $request->cookie('id_user');

        $infoKelas = Jadwal::with('kelas')
                    ->where('id_kelas', $id_kelas)
                    ->where('id_mapel', $id_mapel)
                    ->where('id_sekolah', $id_sekolah)
                    ->firstOrFail();
        $infoMapel = Mapel::where('id_mapel', $id_mapel)
                    ->where('id_guru', $id_user)
                    ->firstOrFail();

        $infoAngkatan = Angkatan::where('id_angkatan', $infoKelas->kelas->id_angkatan)->first();

        // dd($infoKelas->semester);

        if($infoKelas->semester != $infoAngkatan->semester || $infoKelas->tingkat != $infoAngkatan->id_tingkat){
            abort(404);
        }
        

        $daftarAbsensi = DaftarAbsensi::with('mapel')
            ->where('id_kelas', $id_kelas)
            ->where('id_mapel', $id_mapel)
            ->where('id_sekolah', $id_sekolah)
            ->whereHas('mapel', function ($query) use ($id_user) {
                $query->where('id_guru', $id_user);
            })
            ->get();

        return view('guru.manajemen_absensi_daftar', ['daftarAbsensi' => $daftarAbsensi, 'infoKelas' => $infoKelas, 'infoMapel' => $infoMapel]);
    }

    public function storeAbsensiDaftar (Request $request, $id_kelas, $id_mapel)
    {
        $id_sekolah = $request->cookie('id_sekolah');

        $request->validate([
            'keterangan_absen' => 'required|string|max:255',
            'kategori_absen'=> 'required|string|max:20',
            'tanggal'=> 'required|date'
        ],[
            'keterangan_absen.required' => 'Keterangan tidak boleh kosong.',
            'keterangan_absen.max' => 'Keterangan maksimal' ,
            'kategori_absen.required' => 'Kategori tidak boleh kosong.',
            'kategori_absen.max' => 'Kategori maksimal ',
            'tanggal.required' => 'Tanggal tidak boleh kosong.'
        ]);

        $infoKelas = Kelas::with('angkatan')->where('id_kelas', $id_kelas)->first();
        $tingkat = $infoKelas->angkatan->id_tingkat;
        $semester = $infoKelas->angkatan->semester;

        $DaftarAbsensi = DaftarAbsensi::create([
                'id_sekolah' => $id_sekolah,
                'id_kelas' => $id_kelas,
                'id_mapel' => $id_mapel,
                'tanggal' => $request->tanggal,
                'tingkat' => $tingkat,
                'semester' => $semester,
                'keterangan' => $request->keterangan_absen,
                'kategori' => $request->kategori_absen,
            ]);


        $targetSiswa = User::where('id_kelas', $id_kelas)
                    ->where('id_sekolah', $id_sekolah)
                    ->where('role', 'siswa')
                    ->get();

        foreach ($targetSiswa as $siswa) {
            DaftarAbsensiSiswa::create([
                'id_siswa'=> $siswa->id,
                'id_sekolah' => $id_sekolah,
                'id_kelas' => $id_kelas,
                'id_mapel' => $id_mapel,
                'id_daftar_absensi' => $DaftarAbsensi->id_daftar_absensi,
                'tingkat' => $tingkat,
                'semester' => $semester,
            ]);
        }        

        return redirect()->route('manajAbsensiDaftar', ['id_kelas' => $id_kelas, 'id_mapel' => $id_mapel])->with('success', 'Absensi berhasil ditambahkan!');

    }

    public function inputAbsensi (Request $request, $id_kelas, $id_mapel, $id_daftar_absensi)
    {
        $id_sekolah = $request->cookie('id_sekolah');
        $id_user = $request->cookie('id_user');
        
        $infoKelas = Jadwal::with('kelas')
                    ->where('id_kelas', $id_kelas)
                    ->where('id_mapel', $id_mapel)
                    ->where('id_sekolah', $id_sekolah)
                    ->firstOrFail();
        $infoMapel = Mapel::where('id_mapel', $id_mapel)
                    ->where('id_guru', $id_user)
                    ->where('id_sekolah', $id_sekolah)
                    ->firstOrFail();
        $infoDaftarAbsensi = DaftarAbsensi::where('id_daftar_absensi', $id_daftar_absensi)
                    ->where('id_mapel', $id_mapel)
                    ->where('id_kelas', $id_kelas)
                    ->where('id_sekolah', $id_sekolah)
                    ->firstOrFail();


        $infoAngkatan = Angkatan::where('id_angkatan', $infoKelas->kelas->id_angkatan)->first();

        if(!$infoAngkatan || $infoKelas->semester != $infoAngkatan->semester || $infoKelas->tingkat != $infoAngkatan->id_tingkat || $infoDaftarAbsensi->semester != $infoAngkatan->semester || $infoDaftarAbsensi->tingkat != $infoAngkatan->id_tingkat){
            abort(404);
        }

        $daftarSiswa = DaftarAbsensiSiswa::where('id_kelas', $id_kelas)
                    ->where('semester', $infoAngkatan->semester)
                    ->where('tingkat', $infoAngkatan->id_tingkat)
                    ->where('id_mapel', $id_mapel)
                    ->where('id_sekolah', $id_sekolah)
                    ->where('id_daftar_absensi', $id_daftar_absensi)
                    ->with('siswa')->get();

        // return view('guru.input_absensi', ['daftarSiswa' => $daftarSiswa, 'infoKelas' => $infoKelas, 'infoMapel' => $infoMapel, 'infoDaftarAbsensi' => $infoDaftarAbsensi]);
        return view('guru.input_absensi', ['daftarSiswa' => $daftarSiswa, 'infoKelas' => $infoKelas]);
    }

    public function storeAbsensiSiswa (Request $request)
    {
        // 1. Validasi input dari form
        $request->validate([
            // 'status' harus ada dan berupa array
            'status' => 'present|array',
            // Setiap item di dalam array 'status' harus diisi dan nilainya harus salah satu dari: Hadir, Sakit, Izin, Alpha
        ], [
            'status.*.in' => 'Status yang dipilih tidak valid.'
        ]);

        // 2. Lakukan perulangan untuk setiap status yang dikirim
        foreach ($request->status as $id_daftar_absensi_siswa => $status_kehadiran) {
            DaftarAbsensiSiswa::where('id_daftar_absensi_siswa', $id_daftar_absensi_siswa)->update(['status' => $status_kehadiran ?? null]);
        }

        // 3. Kembali ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Absensi siswa berhasil disimpan!');
    }
}
