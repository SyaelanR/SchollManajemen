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
}
