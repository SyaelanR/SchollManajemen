<?php

namespace App\Http\Controllers;

use App\Models\Angkatan;
use App\Models\DaftarNilaiSiswa;
use App\Models\DaftarTugas;
use App\Models\Jadwal;
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
     * Menampilkan detail nilai untuk mata pelajaran tertentu.
     * Corresponds to: nilai_detail_mapel.blade.php
     *
     * @param int $id_mapel ID Mata Pelajaran yang dipilih.
     * @return \Illuminate\View\View
     */
    public function lihatNilaiMapel(Request $request, $id_mapel)
    {
        // 1. Ambil data siswa dan sekolah dari cookie
        $id_siswa = $request->cookie('id_user');
        $id_sekolah = $request->cookie('id_sekolah');
        $id_kelas = $request->cookie('id_kelas');
        $id_angkatan = $request->cookie('id_angkatan');

        // 2. Ambil informasi penting dari database
        $user = \App\Models\User::with('kelas')->findOrFail($id_siswa);
        $mapel = \App\Models\Mapel::findOrFail($id_mapel);
        $angkatan = \App\Models\Angkatan::findOrFail($id_angkatan);

        // 3. Ambil semua nilai siswa untuk mapel, tingkat, dan semester yang relevan
        $semuaNilai = DaftarNilaiSiswa::where('id_siswa', $id_siswa)
            ->where('id_mapel', $id_mapel)
            ->where('id_sekolah', $id_sekolah)
            ->where('tingkat', $angkatan->id_tingkat)
            ->where('semester', $angkatan->semester)
            ->with('daftarNilai') // Eager load relasi ke DaftarNilai
            ->get();

        // 4. Proses dan kelompokkan nilai
        $nilaiTugas = $semuaNilai->where('daftarNilai.tipe_nilai', 'Tugas')->pluck('nilai')->filter()->avg();
        $nilaiPR = $semuaNilai->where('daftarNilai.tipe_nilai', 'PR')->pluck('nilai')->filter()->avg();
        $nilaiUTS = $semuaNilai->where('daftarNilai.tipe_nilai', 'UTS')->pluck('nilai')->filter()->avg();
        $nilaiUAS = $semuaNilai->where('daftarNilai.tipe_nilai', 'UAS')->pluck('nilai')->filter()->avg();

        // Gabungkan nilai Tugas dan PR (jika ada)
        $nilaiHarian = $nilaiTugas;
        if (is_numeric($nilaiTugas) && is_numeric($nilaiPR)) {
            $nilaiHarian = ($nilaiTugas * 0.7) + ($nilaiPR * 0.3);
        } elseif (is_numeric($nilaiPR) && !is_numeric($nilaiTugas)) {
            $nilaiHarian = $nilaiPR;
        }

        // 5. Siapkan array nilai akhir untuk view
        $nilaiProses = [
            'harian' => $nilaiHarian !== null ? round($nilaiHarian) : null,
            'uts' => $nilaiUTS !== null ? round($nilaiUTS) : null,
            'uas' => $nilaiUAS !== null ? round($nilaiUAS) : null,
        ];

        // 6. Hitung rata-rata akhir dari nilai yang ada
        $skorValid = array_filter($nilaiProses, 'is_numeric');
        $rataRata = !empty($skorValid) ? array_sum($skorValid) / count($skorValid) : 0;

        // 7. Kirim data ke view
        return view('siswa.lihatnilai', [
            'namaMapel' => $mapel->nama_mapel,
            'namaKelas' => $user->kelas->nama_kelas ?? 'Belum ada kelas',
            'namaSiswa' => $user->name,
            'kkm' => 75, // Asumsi KKM, bisa diambil dari tabel mapel jika ada
            'nilaiSiswa' => $nilaiProses,
            'rataRata' => $rataRata,
        ]);
    }

}