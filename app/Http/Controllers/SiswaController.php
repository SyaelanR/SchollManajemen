<?php

namespace App\Http\Controllers;

use App\Models\Angkatan;
use App\Models\DaftarNilaiSiswa;
use App\Models\DaftarTugas;
use App\Models\Jadwal;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
// use Illuminate\Container\Attributes\Storage;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function lihatTugasMapel (Request $request)
    {
        $idKelas = $request->cookie('id_kelas');
        $idSekolah = $request->cookie('id_sekolah');
        $idAngkatan = $request->cookie('id_angkatan');


        $infoAngkatan = Angkatan::where('id_sekolah', $idSekolah)
                                ->where('id_angkatan', $idAngkatan)
                                ->first();

        $daftarMapel = Jadwal::where('id_kelas', $idKelas)
                        ->where('id_sekolah', $idSekolah)
                        ->where('tingkat', $infoAngkatan->id_tingkat ?? 0)
                        ->where('semester', $infoAngkatan->semester ?? 0)
                        ->with(['mapel.guru'])
                        ->select('id_kelas', 'id_mapel') // hanya ambil kombinasi unik kelas+mapel
                        ->distinct()
                        ->get();

        return view('siswa.lihat_tugas_mapel', ['daftarMapel' => $daftarMapel]);
    }

    public function lihatTugasDaftar (Request $request, $idMapel)
    {
        $idSiswa = $request->cookie('id_user');
        $idSekolah = $request->cookie('id_sekolah');
        $idKelas = $request->cookie('id_kelas');
        $idAngkatan = $request->cookie('id_angkatan');

        $infoAngkatan = Angkatan::where('id_sekolah', $idSekolah)
                                ->where('id_angkatan', $idAngkatan)
                                ->first();

        $infoJadwal = Jadwal::where('id_kelas', $idKelas)
                        ->where('id_sekolah', $idSekolah)
                        ->where('id_mapel', $idMapel)
                        ->where('tingkat', $infoAngkatan->id_tingkat)
                        ->where('semester', $infoAngkatan->semester)
                        ->with(['mapel'])
                        ->firstOrFail();


        $daftarTugas = DaftarNilaiSiswa::where('id_siswa', $idSiswa)
                        ->where('id_sekolah', $idSekolah)
                        ->where('id_kelas', $idKelas)
                        ->where('tingkat', $infoAngkatan->id_tingkat)
                        ->where('semester', $infoAngkatan->semester)
                        ->where('id_mapel', $idMapel)
                        ->with(['daftarNilai.tugas.mapel'])
                        ->whereHas('daftarNilai', function ($query) {
                            $query->where('sifat', 'online');
                        })
                        ->get();

        return view('siswa.lihat_daftar_tugas', ['daftarTugas' => $daftarTugas, 'infoJadwal' => $infoJadwal]);
    
    }

    public function lihatSoal (Request $request, $namaFile)
    {
        $idSekolah = $request->cookie('id_sekolah');
        $idKelas = $request->cookie('id_kelas');
        $idAngkatan = $request->cookie('id_angkatan');

        $infoAngkatan = Angkatan::where('id_sekolah', $idSekolah)
                                ->where('id_angkatan', $idAngkatan)
                                ->first();


        DaftarTugas::where('nama_file', $namaFile)
                    ->where('id_sekolah', $idSekolah)
                    ->where('id_kelas', $idKelas)
                    ->where('tingkat', $infoAngkatan->id_tingkat)
                    ->where('semester', $infoAngkatan->semester)
                    ->firstOrFail();


        if (Storage::disk('local')->exists("tugas/$namaFile")) {
            $path = Storage::disk('local')->path("tugas/$namaFile");
            $headers = ['Content-Type' => 'application/pdf'];

            // Mengembalikan file sebagai respons inline
            return response()->file($path, $headers);
        }

        abort(404, 'File not found');

    }

    public function unggahTugas (Request $request)
    {
        // 1. Validasi request
        $request->validate([
            // 'id_daftar_nilai_siswa' => 'required|exists:daftar_nilai_siswas,id_daftar_nilai_siswa',
            'file' => 'required|file|mimes:pdf|max:10240', // PDF, max 10MB
        ], [
            'file.required' => 'Anda harus memilih file untuk diunggah.',
            'file.mimes' => 'File jawaban harus dalam format PDF.',
            'file.max' => 'Ukuran file maksimal adalah 10MB.',
        ]);

        $idSiswa = $request->cookie('id_user');
        $idDaftarNilaiSiswa = $request->input('id_daftar_nilai_siswa');

        // dd($idDaftarNilaiSiswa);

        // 2. Cari record tugas siswa yang sesuai
        $tugasSiswa = DaftarNilaiSiswa::where('id_daftar_nilai_siswa', $idDaftarNilaiSiswa)
                                      ->where('id_siswa', $idSiswa)
                                      ->firstOrFail();

        // dd($tugasSiswa);

        // // 3. Proses unggah file
        $file = $request->file('file');
        // Buat nama file yang unik: idsiswa_iddns_timestamp.extension
        $namaFile = time() . '_' . $file->getClientOriginalName();

        // dd($namaFile);
        
        // // Simpan file ke storage/app/jawaban_tugas
        $file->storeAs('tugasSiswa', $namaFile,);

        // // 4. Update nama file di database
        $tugasSiswa->update(['nama_fileTugas' => $namaFile]);

        return back()->with('success', 'Jawaban tugas berhasil diunggah!');
        // return view ('dashboard');
    }

        public function lihatJawaban (Request $request, $namaFile)
    {
        $idSekolah = $request->cookie('id_sekolah');
        $idKelas = $request->cookie('id_kelas');
        $idAngkatan = $request->cookie('id_angkatan');

        $infoAngkatan = Angkatan::where('id_sekolah', $idSekolah)
                                ->where('id_angkatan', $idAngkatan)
                                ->first();


        DaftarNilaiSiswa::where('nama_fileTugas', $namaFile)
                    ->where('id_sekolah', $idSekolah)
                    ->where('id_kelas', $idKelas)
                    ->where('tingkat', $infoAngkatan->id_tingkat)
                    ->where('semester', $infoAngkatan->semester)
                    ->firstOrFail();


        if (Storage::disk('local')->exists("tugasSiswa/$namaFile")) {
            $path = Storage::disk('local')->path("tugasSiswa/$namaFile");
            $headers = ['Content-Type' => 'application/pdf'];

            // Mengembalikan file sebagai respons inline
            return response()->file($path, $headers);
        }

        abort(404, 'File not found');

    }

    public function lihatJadwalS (Request $request)
    {
        $id_kelas = $request->cookie('id_kelas');
        $id_sekolah = $request->cookie('id_sekolah');
        
        $jadwals = Jadwal::with('kelas.angkatan', 'mapel.guru')
        ->whereHas('mapel', function ($query) use ($id_kelas) {
            $query->where('id_kelas', $id_kelas);
        })
        ->whereHas('kelas.angkatan', function ($query) use ($id_sekolah) {
            $query->where('id_sekolah', $id_sekolah);
        })
        ->whereHas('kelas.angkatan', function ($query) {
            $query->whereColumn('angkatans.semester', 'jadwals.semester');
        })
        ->whereHas('kelas.angkatan', function ($query) {
            // Filter Jadwal berdasarkan tingkat yang ada di relasi angkatan
            $query->whereColumn('angkatans.id_tingkat', 'jadwals.tingkat');
        })
        ->orderBy('hari') // Mengurutkan berdasarkan hari
        ->orderBy('jam_mulai') // Kemudian berdasarkan jam mulai
        ->get();

        return view('siswa.lihat_jadwalS', ['jadwals' => $jadwals]);
    }

    public function KRS (Request $request)
    {
        $id_kelas = $request->cookie('id_kelas');
        $id_sekolah = $request->cookie('id_sekolah');
        $id_user = $request->cookie('id_user');
        
        $user = User::where('id', $id_user)->first();

        $jadwals = Jadwal::with('kelas.angkatan.sekolah', 'mapel')
        ->whereHas('mapel', function ($query) use ($id_kelas) {
            $query->where('id_kelas', $id_kelas);
        })
        ->whereHas('kelas.angkatan', function ($query) use ($id_sekolah) {
            $query->where('id_sekolah', $id_sekolah);
        })
        ->whereHas('kelas.angkatan', function ($query) {
            $query->whereColumn('angkatans.semester', 'jadwals.semester');
        })
        ->whereHas('kelas.angkatan', function ($query) {
            // Filter Jadwal berdasarkan tingkat yang ada di relasi angkatan
            $query->whereColumn('angkatans.id_tingkat', 'jadwals.tingkat');
        })
        ->select('id_kelas', 'id_mapel') // hanya ambil kombinasi unik kelas+mapel
        ->distinct()
        // ->with('kelas.angkatan', 'mapel') // tetap load relasi
        ->get();

        $waliKelas = optional($jadwals->first()->kelas)->wali_kelas;
        $sekolah = optional($jadwals->first()->kelas->angkatan->sekolah)->nama_sekolah;
        $tingkat = optional($jadwals->first()->kelas->angkatan)->tingkat;
        $semester = optional($jadwals->first()->kelas->angkatan)->semester;

        $jumlahSKS = 0;
        foreach ($jadwals as $jadwal) {
            $jumlahSKS += $jadwal->mapel->sks;
        }


        // return view('debug', ['tes' => $jadwals]);
        return view('siswa.krs', ['jadwals' => $jadwals, 
                                            'user' => $user, 
                                            'waliKelas' => $waliKelas, 
                                            'sekolah' => $sekolah,
                                            'tingkat' => $tingkat,
                                            'semester' => $semester,
                                            'jumlahSKS' => $jumlahSKS
                                        ]);
    }
}