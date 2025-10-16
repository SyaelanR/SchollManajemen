<?php

namespace App\Http\Controllers;

use App\Models\Angkatan;
use App\Models\DaftarMateri;
use App\Models\DaftarAbsensiSiswa;
use App\Models\DaftarNilaiSiswa;
use App\Models\DaftarPengumuman;
use App\Models\DaftarTugas;
use App\Models\Mapel;
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
    /**
     * Menampilkan halaman riwayat absensi untuk siswa yang sedang login.
     */
    }
    
    public function lihatAbsensi(Request $request)
    {
        $id_sekolah = $request->cookie('id_sekolah');
        $id_siswa = $request->cookie('id_user');

        // Ambil data siswa beserta relasi kelas dan angkatan
        $siswa = User::with('kelas.angkatan')->find($id_siswa);

        // Jika siswa tidak terdaftar di kelas/angkatan, kembalikan data kosong
        if (!$siswa || !$siswa->kelas || !$siswa->kelas->angkatan) {
            return view('siswa.lihat_absensi', ['daftarAbsensi' => collect()]);
        }

        $tingkat = $siswa->kelas->angkatan->id_tingkat;
        $semester = $siswa->kelas->angkatan->semester;

        // Ambil semua data absensi siswa untuk semester dan tingkat yang aktif
        $daftarAbsensi = DaftarAbsensiSiswa::where('id_siswa', $id_siswa)
            ->where('id_sekolah', $id_sekolah)
            ->where('tingkat', $tingkat)
            ->where('semester', $semester)
            ->with(['mapel', 'daftarAbsensi']) // Eager load untuk efisiensi
            ->latest('created_at') // Urutkan dari yang terbaru
            ->get();

        return view('siswa.lihat_absensi', compact('daftarAbsensi'));
    }

    /**
     * Menampilkan daftar materi untuk kelas dan mapel tertentu.
     */
    public function lihatMateri(Request $request, $id_kelas, $id_mapel)
    {
        $id_sekolah = $request->cookie('id_sekolah');
        $id_angkatan = $request->cookie('id_angkatan');

        // Validasi apakah siswa terdaftar di kelas ini
        if ($request->cookie('id_kelas') != $id_kelas) {
            abort(403, 'Akses ditolak.');
        }

        $infoAngkatan = Angkatan::where('id_sekolah', $id_sekolah)
                                ->where('id_angkatan', $id_angkatan)
                                ->firstOrFail();

        $infoJadwal = Jadwal::where('id_kelas', $id_kelas)
                            ->where('id_mapel', $id_mapel)
                            ->with('mapel', 'kelas')
                            ->firstOrFail();

        $daftarMateri = DaftarMateri::where('id_kelas', $id_kelas)
                                    ->where('id_mapel', $id_mapel)
                                    ->where('tingkat', $infoAngkatan->id_tingkat)
                                    ->where('semester', $infoAngkatan->semester)
                                    ->latest('tanggal')->get();

        return view('siswa.lihat_materi', compact('daftarMateri', 'infoJadwal'));
    }

    /**
     * Menampilkan halaman untuk memilih mata pelajaran sebelum melihat absensi.
     */
    public function pilihMapelAbsensi(Request $request)
    {
        $id_sekolah = $request->cookie('id_sekolah');
        $id_kelas = $request->cookie('id_kelas');

        // Jika siswa tidak punya kelas, kembalikan view dengan data kosong
        if (!$id_kelas) {
            return view('siswa.pilih_mapel_absensi', ['daftarMapel' => collect()]);
        }

        // Ambil info angkatan siswa
        $infoAngkatan = Angkatan::whereHas('kelas', function ($query) use ($id_kelas) {
            $query->where('id_kelas', $id_kelas);
        })->first();

        // Ambil semua mapel yang diajarkan di kelas siswa pada semester & tingkat aktif
        $daftarMapel = Jadwal::where('id_kelas', $id_kelas)
            ->where('id_sekolah', $id_sekolah)
            ->where('tingkat', $infoAngkatan->id_tingkat ?? 0)
            ->where('semester', $infoAngkatan->semester ?? 'ganjil')
            ->with('mapel.guru')
            ->select('id_mapel')
            ->distinct()
            ->get();

        return view('siswa.pilih_mapel_absensi', compact('daftarMapel'));
    }

    /**
     * Menampilkan halaman untuk memilih mata pelajaran sebelum melihat materi.
     */
    public function pilihMapelMateri(Request $request)
    {
        $id_sekolah = $request->cookie('id_sekolah');
        $id_kelas = $request->cookie('id_kelas');

        // Jika siswa tidak punya kelas, kembalikan view dengan data kosong
        if (!$id_kelas) {
            return view('siswa.pilih_mapel_materi', ['daftarMapel' => collect()]);
        }

        // Ambil info angkatan siswa
        $infoAngkatan = Angkatan::whereHas('kelas', function ($query) use ($id_kelas) {
            $query->where('id_kelas', $id_kelas);
        })->first();

        // Ambil semua mapel yang diajarkan di kelas siswa pada semester & tingkat aktif
        $daftarMapel = Jadwal::where('id_kelas', $id_kelas)
            ->where('id_sekolah', $id_sekolah)
            ->where('tingkat', $infoAngkatan->id_tingkat ?? 0)
            ->where('semester', $infoAngkatan->semester ?? 'ganjil')
            ->with('mapel.guru')
            ->select('id_mapel', 'id_kelas') // <-- Tambahkan id_kelas di sini
            ->distinct()
            ->get();

        return view('siswa.pilih_mapel_materi', compact('daftarMapel'));
    }

    /////////////////////////////////lihat nilai///////////////////////////////////////////////////
    public function pilihMapel(Request $request)
    {
        $id_sekolah = $request->cookie('id_sekolah');
        $id_kelas = $request->cookie('id_kelas');
        $id_angkatan = $request->cookie('id_angkatan');

        // Ambil info angkatan untuk mendapatkan semester & tingkat aktif
        $infoAngkatan = Angkatan::where('id_angkatan', $id_angkatan)
                                ->where('id_sekolah', $id_sekolah)
                                ->first();

        // Mengambil daftar mapel yang unik untuk kelas siswa yang sedang login
        // berdasarkan jadwal yang ada.
        $mapelList = Jadwal::with('mapel.guru')
            ->where('id_sekolah', $id_sekolah)
            ->where('id_kelas', $id_kelas)
            // Hanya jalankan filter tambahan jika info angkatan valid
            ->when($infoAngkatan, function ($query) use ($infoAngkatan) {
                // Filter jadwal yang sesuai dengan semester dan tingkat angkatan siswa saat ini
                return $query->where('semester', $infoAngkatan->semester)
                               ->where('tingkat', $infoAngkatan->id_tingkat);
            })
            // Pastikan mapel yang terkait ada dan statusnya aktif/null
            ->whereHas('mapel', fn($q) => $q->where('status', 'aktif')->orWhereNull('status'))
            ->select('id_mapel')
            ->distinct()
            ->get();

        return view('siswa.lihatmapelnilai', ['mapelList' => $mapelList]);
    }

    /**
     * Menampilkan riwayat absensi untuk satu mata pelajaran.
     */
    public function lihatAbsensiPerMapel(Request $request, $id_mapel)
    {
        $id_sekolah = $request->cookie('id_sekolah');
        $id_siswa = $request->cookie('id_user');

        $siswa = User::with('kelas.angkatan')->find($id_siswa);

        if (!$siswa || !$siswa->kelas || !$siswa->kelas->angkatan) {
            return view('siswa.lihat_absensi_per_mapel', ['daftarAbsensi' => collect(), 'infoMapel' => null]);
        }

        $tingkat = $siswa->kelas->angkatan->id_tingkat;
        $semester = $siswa->kelas->angkatan->semester;

        $daftarAbsensi = DaftarAbsensiSiswa::where('id_siswa', $id_siswa)
            ->where('id_sekolah', $id_sekolah)
            ->where('id_mapel', $id_mapel) // Filter berdasarkan mapel
            ->where('tingkat', $tingkat)
            ->where('semester', $semester)
            ->with(['mapel', 'daftarAbsensi'])
            ->latest('created_at')
            ->get();

        $infoMapel = Mapel::find($id_mapel);

        return view('siswa.lihat_absensi_per_mapel', compact('daftarAbsensi', 'infoMapel'));
    }
    //     return view('siswa.lihatmapelnilai', ['mapelList' => $mapelList]);
    // }

    /**
     * Menampilkan detail nilai untuk mata pelajaran tertentu.
     * Corresponds to: nilai_detail_mapel.blade.php
     *
     * @param int $id_mapel ID Mata Pelajaran yang dipilih.
     * @return \Illuminate\View\View
     */
    public function lihatNilaiMapel(Request $request, $id_mapel)
    {
        $id_user = $request->cookie('id_user');
        $id_sekolah = $request->cookie('id_sekolah');

        // Menggunakan join untuk membandingkan kolom antar tabel
        $daftarNilai = DaftarNilaiSiswa::query()
                        ->select('daftar_nilai_siswas.*') // Pilih semua kolom dari tabel utama untuk menghindari ambiguitas
                        ->join('kelas', 'daftar_nilai_siswas.id_kelas', '=', 'kelas.id_kelas')
                        ->join('angkatans', 'kelas.id_angkatan', '=', 'angkatans.id_angkatan')
                        ->where('daftar_nilai_siswas.id_siswa', $id_user)
                        ->where('daftar_nilai_siswas.id_mapel', $id_mapel)
                        ->where('daftar_nilai_siswas.id_sekolah', $id_sekolah)
                        // Sekarang whereColumn akan bekerja karena tabel sudah di-join
                        ->whereColumn('daftar_nilai_siswas.tingkat', 'angkatans.id_tingkat')
                        ->whereColumn('daftar_nilai_siswas.semester', 'angkatans.semester')
                        // Eager load relasi yang dibutuhkan untuk view
                        ->with(['daftarNilai', 'kelas.angkatan'])
                        ->get();


        return view('siswa.lihatnilai', ['daftarNilai' => $daftarNilai]);
    }

    public function lihatAcara(Request $request)
    {
        $id_sekolah = $request->cookie('id_sekolah');

        // Ambil acara yang akan datang atau sedang berlangsung
        $daftarAcara = \App\Models\DaftarAcara::where('id_sekolah', $id_sekolah)
            ->where('tanggal_selesai', '>=', now())
            ->orderBy('tanggal_mulai', 'asc')
            ->get();

        // Ambil acara yang sudah lewat
        $acaraLampau = \App\Models\DaftarAcara::where('id_sekolah', $id_sekolah)
            ->where('tanggal_selesai', '<', now())
            ->orderBy('tanggal_mulai', 'desc')
            ->limit(5) // Batasi 5 acara terakhir
            ->get();

        return view('siswa.lihat_acara', compact('daftarAcara', 'acaraLampau'));
    }
////////////////////////////////lihat pengumuman/////////////////////////////////////////////
    public function lihatPengumuman(Request $request)
    {
        $id_sekolah = $request->cookie('id_sekolah');
        $id_kelas = $request->cookie('id_kelas');

        // Ambil semua ID mapel yang diajarkan di kelas siswa
        $mapelIds = Jadwal::where('id_kelas', $id_kelas)
                          ->where('id_sekolah', $id_sekolah)
                          ->pluck('id_mapel')->unique();

        // Ambil pengumuman yang relevan (berdasarkan id_sekolah, id_kelas, dan id_mapel)
        $pengumumans = DaftarPengumuman::where('id_sekolah', $id_sekolah)
            ->where('id_kelas', $id_kelas)
            ->whereIn('id_mapel', $mapelIds)
            ->with('mapel') // Eager load relasi mapel untuk efisiensi
            ->latest('created_at')->get();

        return view('siswa.lihat_pengumuman', compact('pengumumans'));
    }
}
