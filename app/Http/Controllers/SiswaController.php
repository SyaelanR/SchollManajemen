<?php

namespace App\Http\Controllers;

use App\Models\Angkatan;
use App\Models\DaftarNilaiSiswa;
use App\Models\Jadwal;
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
                        ->where('tingkat', $infoAngkatan->id_tingkat)
                        ->where('semester', $infoAngkatan->semester)
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
                        ->firstOrFail();


        $daftarTugas = DaftarNilaiSiswa::where('id_siswa', $idSiswa)
                        ->where('id_sekolah', $idSekolah)
                        ->where('id_kelas', $idKelas)
                        ->where('tingkat', $infoAngkatan->id_tingkat)
                        ->where('semester', $infoAngkatan->semester)
                        ->where('id_mapel', $idMapel)
                        ->with(['mapel'])
                        ->with(['daftarNilai'])
                        ->get();

        return view('siswa.lihat_daftar_tugas', ['daftarTugas' => $daftarTugas]);
    
    }
}
