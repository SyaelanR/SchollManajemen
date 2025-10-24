<?php

namespace App\Http\Controllers;

use App\Models\Angkatan;
use App\Models\DaftarAbsensi;
use App\Models\DaftarAbsensiSiswa;
use App\Models\DaftarMateri;
use App\Models\DaftarNilai;
use App\Models\DaftarNilaiSiswa;
use App\Models\DaftarPengumuman;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\User;
use App\Models\Mapel;
use App\Models\DaftarTugas;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel; // <-- Import Facade Excel
use App\Exports\LaporanNilaiExport;


class GuruController extends Controller
{
    public function lihatjadwalG(Request $request)
    {
        $id_sekolah = $request->cookie('id_sekolah');
        $id_user = $request->cookie('id_user');

        $Jadwals = Jadwal::with('kelas.angkatan', 'mapel')
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
        ->orderBy('hari') // Urutkan berdasarkan hari
        ->orderBy('jam_mulai') // Kemudian urutkan berdasarkan jam mulai
        ->get();


        return view('guru.lihat_jadwalG', ['Jadwals' => $Jadwals]);
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

        return view('guru.manajemen_nilai_kelas', ['daftarkelasYangDiampu' => $daftarkelasYangDiampu]);
    }

    public function inputNilai(Request $request, int $id_kelas, int $id_mapel, int $id_daftar_nilai)
    {
        $id_sekolah = $request->cookie('id_sekolah');
        $id_user = $request->cookie('id_user');
        
        $infoJKA = Jadwal::where('id_kelas', $id_kelas)
                    ->where('id_mapel', $id_mapel)
                    ->where('id_sekolah', $id_sekolah)
                    ->with('kelas.angkatan')
                    ->with('mapel')
                    ->whereHas('mapel', function ($query) use ($id_user) {
                        $query->where('id_guru', $id_user);
                    })
                    ->whereHas('kelas.angkatan', function ($query) {
                        $query->whereColumn('angkatans.semester', 'jadwals.semester');
                    })
                    ->whereHas('kelas.angkatan', function ($query) {
                        // Filter Jadwal berdasarkan tingkat yang ada di relasi angkatan
                        $query->whereColumn('angkatans.id_tingkat', 'jadwals.tingkat');
                    })
                    ->firstOrFail();

        // dd($infoKelas->semester);
        
        $daftarSiswa = DaftarNilaiSiswa::where('id_kelas', $id_kelas)
                    ->where('tingkat', $infoJKA->kelas->angkatan->id_tingkat)
                    ->where('semester', $infoJKA->kelas->angkatan->semester)
                    ->where('id_mapel', $id_mapel)
                    ->where('id_sekolah', $id_sekolah)
                    ->where('id_daftar_nilai', $id_daftar_nilai)
                    ->with('siswa')->get();

        return view('guru.input_nilai', compact('daftarSiswa', 'infoJKA'));
    }

    public function inputNilaiOnline(Request $request, $id_kelas, $id_mapel, $id_daftar_nilai)
    {
        $id_sekolah = $request->cookie('id_sekolah');
        $id_user = $request->cookie('id_user');
        
        $infoJKA = Jadwal::where('id_kelas', $id_kelas)
                    ->where('id_mapel', $id_mapel)
                    ->where('id_sekolah', $id_sekolah)
                    ->with('kelas.angkatan')
                    ->with('mapel')
                    ->whereHas('mapel', function ($query) use ($id_user) {
                        $query->where('id_guru', $id_user);
                    })
                    ->whereHas('kelas.angkatan', function ($query) {
                        $query->whereColumn('angkatans.semester', 'jadwals.semester');
                    })
                    ->whereHas('kelas.angkatan', function ($query) {
                        // Filter Jadwal berdasarkan tingkat yang ada di relasi angkatan
                        $query->whereColumn('angkatans.id_tingkat', 'jadwals.tingkat');
                    })
                    ->firstOrFail();

        // dd($infoKelas->semester);
        
        $daftarSiswa = DaftarNilaiSiswa::where('id_kelas', $id_kelas)
                    ->where('tingkat', $infoJKA->kelas->angkatan->id_tingkat)
                    ->where('semester', $infoJKA->kelas->angkatan->semester)
                    ->where('id_mapel', $id_mapel)
                    ->where('id_sekolah', $id_sekolah)
                    ->where('id_daftar_nilai', $id_daftar_nilai)
                    ->with('siswa')->get();
        
        return view('guru.input_nilai_online', compact('daftarSiswa', 'infoJKA'));
    }

    public function lihatTugasSiswa (Request $request, $namaFile)
    {
        $id_sekolah = $request->cookie('id_sekolah');
        $idUser = $request->cookie('id_user');
        
        //ambil id mapel dari namaFile
        $infoDaftarTugasSiswa = DaftarNilaiSiswa::where('nama_fileTugas', $namaFile)
                    ->where('id_sekolah', $id_sekolah)
                    ->firstOrFail();

        //cek apakah guru mengajar mapel ini
        // $infoMapel = Mapel::where('id_mapel', $infoDaftarTugasSiswa->id_mapel)
        //             ->where('id_guru', $idUser)
        //             ->where('id_sekolah', $id_sekolah)
        //             ->firstOrFail();

        //cek apakah guru mengajar kelas&mapel ini + ambil kelas & angkatan
        $infoJKA = Jadwal::where('id_kelas', $infoDaftarTugasSiswa->id_kelas)
                    ->where('id_mapel', $infoDaftarTugasSiswa->id_mapel)
                    ->where('id_sekolah', $id_sekolah)
                    ->with('kelas.angkatan')
                    ->with('mapel')
                    ->whereHas('mapel', function ($query) use ($idUser) {
                        $query->where('id_guru', $idUser);
                    })
                    ->whereHas('kelas.angkatan', function ($query) {
                        $query->whereColumn('angkatans.semester', 'jadwals.semester');
                    })
                    ->whereHas('kelas.angkatan', function ($query) {
                        // Filter Jadwal berdasarkan tingkat yang ada di relasi angkatan
                        $query->whereColumn('angkatans.id_tingkat', 'jadwals.tingkat');
                    })
                    ->firstOrFail();


        // $infoAngkatan = Angkatan::where('id_angkatan', )->first();


        if (Storage::disk('local')->exists("tugasSiswa/$namaFile")) {
            $path = Storage::disk('local')->path("tugasSiswa/$namaFile");
            $headers = ['Content-Type' => 'application/pdf'];

            // Mengembalikan file sebagai respons inline
            return response()->file($path, $headers);
        }

        abort(404, 'File not found');

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

    /**
     * Update nilai siswa yang sudah ada.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id_daftar_nilai_siswa
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateNilaiSiswa(Request $request, $id_daftar_nilai_siswa)
    {
        // 1. Validasi input
        $validated = $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
        ]);

        // 2. Cari data nilai siswa berdasarkan ID
        $nilaiSiswa = DaftarNilaiSiswa::find($id_daftar_nilai_siswa);

        // 3. Jika data tidak ditemukan, kembali dengan pesan error
        if (!$nilaiSiswa) {
            return redirect()->back()->with('error', 'Data nilai siswa tidak ditemukan.');
        }

        // 4. Update nilai dan simpan
        $nilaiSiswa->update($validated);

        // 5. Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Nilai siswa berhasil diperbarui!');
    }


    public function manajNilaiDaftar(Request $request, $id_kelas, $id_mapel) 
    {
        $id_sekolah = $request->cookie('id_sekolah');
        $id_user = $request->cookie('id_user');

        $infoJKA = Jadwal::where('id_kelas', $id_kelas)
                    ->where('id_mapel', $id_mapel)
                    ->where('id_sekolah', $id_sekolah)
                    ->with('kelas.angkatan')
                    ->with('mapel')
                    ->whereHas('mapel', function ($query) use ($id_user) {
                        $query->where('id_guru', $id_user);
                    })
                    ->whereHas('kelas.angkatan', function ($query) {
                        $query->whereColumn('angkatans.semester', 'jadwals.semester');
                    })
                    ->whereHas('kelas.angkatan', function ($query) {
                        // Filter Jadwal berdasarkan tingkat yang ada di relasi angkatan
                        $query->whereColumn('angkatans.id_tingkat', 'jadwals.tingkat');
                    })
                    ->firstOrFail();
        

        $daftarNilai = DaftarNilai::with('mapel')
            ->where('id_kelas', $id_kelas)
            ->where('id_mapel', $id_mapel)
            ->where('id_sekolah', $id_sekolah)
            ->whereHas('mapel', function ($query) use ($id_user) {
                $query->where('id_guru', $id_user);
            })
            ->where('tingkat', $infoJKA->kelas->angkatan->id_tingkat)
            ->where('semester', $infoJKA->kelas->angkatan->semester)
            ->get();

        return view('guru.manajemen_nilai_daftar', ['daftarNilai' => $daftarNilai, 'infoJKA' => $infoJKA]);
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
        
        return view('guru.manajemen_absensi_kelas', ['daftarkelasYangDiampu' => $daftarkelasYangDiampu]);
    }



    public function manajAbsensiDaftar (Request $request, $id_kelas, $id_mapel) 
    {
        $id_sekolah = $request->cookie('id_sekolah');
        $id_user = $request->cookie('id_user');

        $infoJKA = Jadwal::where('id_kelas', $id_kelas)
                    ->where('id_mapel', $id_mapel)
                    ->where('id_sekolah', $id_sekolah)
                    ->with('kelas.angkatan')
                    ->with('mapel')
                    ->whereHas('mapel', function ($query) use ($id_user) {
                        $query->where('id_guru', $id_user);
                    })
                    ->whereHas('kelas.angkatan', function ($query) {
                        $query->whereColumn('angkatans.semester', 'jadwals.semester');
                    })
                    ->whereHas('kelas.angkatan', function ($query) {
                        // Filter Jadwal berdasarkan tingkat yang ada di relasi angkatan
                        $query->whereColumn('angkatans.id_tingkat', 'jadwals.tingkat');
                    })
                    ->firstOrFail();
        

        $daftarAbsensi = DaftarAbsensi::with('mapel')
            ->where('id_kelas', $id_kelas)
            ->where('id_mapel', $id_mapel)
            ->where('id_sekolah', $id_sekolah)
            ->where('tingkat', $infoJKA->kelas->angkatan->id_tingkat)
            ->where('semester', $infoJKA->kelas->angkatan->semester)
            ->whereHas('mapel', function ($query) use ($id_user) {
                $query->where('id_guru', $id_user);
            })
            ->get();

        // return view('guru.manajemen_absensi_daftar', ['daftarAbsensi' => $daftarAbsensi, 'infoKelas' => $infoKelas, 'infoMapel' => $infoMapel]);
        return view('guru.manajemen_absensi_daftar', ['daftarAbsensi' => $daftarAbsensi, 'infoJKA' => $infoJKA]);
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
        
        $infoJKA = Jadwal::where('id_kelas', $id_kelas)
                    ->where('id_mapel', $id_mapel)
                    ->where('id_sekolah', $id_sekolah)
                    ->with('kelas.angkatan')
                    ->with('mapel')
                    ->whereHas('mapel', function ($query) use ($id_user) {
                        $query->where('id_guru', $id_user);
                    })
                    ->whereHas('kelas.angkatan', function ($query) {
                        $query->whereColumn('angkatans.semester', 'jadwals.semester');
                    })
                    ->whereHas('kelas.angkatan', function ($query) {
                        // Filter Jadwal berdasarkan tingkat yang ada di relasi angkatan
                        $query->whereColumn('angkatans.id_tingkat', 'jadwals.tingkat');
                    })
                    ->firstOrFail();

        $daftarSiswa = DaftarAbsensiSiswa::where('id_kelas', $id_kelas)
                    ->where('tingkat', $infoJKA->kelas->angkatan->id_tingkat)
                    ->where('semester', $infoJKA->kelas->angkatan->semester)
                    ->where('id_mapel', $id_mapel)
                    ->where('id_sekolah', $id_sekolah)
                    ->where('id_daftar_absensi', $id_daftar_absensi)
                    ->with('siswa')->get();

        // return view('guru.input_absensi', ['daftarSiswa' => $daftarSiswa, 'infoKelas' => $infoKelas, 'infoMapel' => $infoMapel]);
        return view('guru.input_absensi', ['daftarSiswa' => $daftarSiswa]);
    }

    public function storeAbsensiSiswa (Request $request)
    {
        // 1. Validasi input dari form
        $request->validate([
            // 'status' harus ada dan berupa array
            'status' => 'present|array',
            // Setiap item di dalam array 'status' harus diisi dan nilainya harus salah satu dari: Hadir, Sakit, Izin, Alfa
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

    /**
     * Update status absensi siswa yang sudah ada.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id_daftar_absensi_siswa
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateAbsensiSiswa(Request $request, $id_daftar_absensi_siswa)
    {
        // 1. Validasi input
        $validated = $request->validate([
            'status' => 'required|string|in:Hadir,Izin,Sakit,Alfa',
        ]);

        // 2. Cari data absensi siswa berdasarkan ID
        $absensiSiswa = DaftarAbsensiSiswa::find($id_daftar_absensi_siswa);

        // 3. Jika data tidak ditemukan, kembali dengan pesan error
        if (!$absensiSiswa) {
            return redirect()->back()->with('error', 'Data absensi siswa tidak ditemukan.');
        }

        // 4. Update status dan simpan
        $absensiSiswa->update($validated);

        // 5. Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Status absensi berhasil diperbarui!');
    }

    public function manajTugasKelas (Request $request)
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
            // Filter Jadwal berdasarkan tingkat yang ada di relasi angkatan
            $query->whereColumn('angkatans.id_tingkat', 'jadwals.tingkat');
        })
        ->select('id_kelas', 'id_mapel') // hanya ambil kombinasi unik kelas+mapel
        ->distinct()
        ->with('kelas.angkatan', 'mapel') // tetap load relasi
        ->get();

        return view('guru.manajemen_tugas_kelas', ['daftarkelasYangDiampu' => $daftarkelasYangDiampu]);
    }

    public function inputTugas (Request $request, $id_kelas, $id_mapel)
    {
        $id_sekolah = $request->cookie('id_sekolah');
        $id_user = $request->cookie('id_user');

        $infoJKA = Jadwal::where('id_kelas', $id_kelas)
                    ->where('id_mapel', $id_mapel)
                    ->where('id_sekolah', $id_sekolah)
                    ->with('kelas.angkatan')
                    ->with('mapel')
                    ->whereHas('mapel', function ($query) use ($id_user) {
                        $query->where('id_guru', $id_user);
                    })
                    ->whereHas('kelas.angkatan', function ($query) {
                        $query->whereColumn('angkatans.semester', 'jadwals.semester');
                    })
                    ->whereHas('kelas.angkatan', function ($query) {
                        // Filter Jadwal berdasarkan tingkat yang ada di relasi angkatan
                        $query->whereColumn('angkatans.id_tingkat', 'jadwals.tingkat');
                    })
                    ->firstOrFail();

        $daftarTugas = DaftarTugas::with('mapel')
                    ->where('id_kelas', $id_kelas)
                    ->where('id_mapel', $id_mapel)
                    ->where('tingkat', $infoJKA->kelas->angkatan->id_tingkat)
                    ->where('semester', $infoJKA->kelas->angkatan->semester)
                    ->where('id_sekolah', $id_sekolah)->get();

    
        //    foreach ($daftarTugas as $tugas) {
        //         $tugas->nama_file = $tugas->nama_file 
        //         ? Str::after($tugas->nama_file, '_') 
        //         : null;
        // }

        return view('guru.input_tugas', ['daftarTugas' => $daftarTugas, 'infoJKA' => $infoJKA]);
    }



    public function storeTugas (Request $request, $id_kelas, $id_mapel)
    {
        $id_sekolah = $request->cookie('id_sekolah');

        $request->validate([
            'keterangan_tugas' => 'required|string|max:255',
            'deadline'=> 'required|date',
            'file' => 'required|file|mimes:pdf|max:5048'
        ],[
            'keterangan_tugas.required' => 'Keterangan tidak boleh kosong.',
            'keterangan_tugas.max' => 'Keterangan maksimal 255',
            'deadline.required' => 'Tanggal tidak boleh kosong.',
            'file.required' => 'File tidak boleh kosong.',
        ]);

        $file = $request->file('file');
        $namaFile = time() . '_' . $file->getClientOriginalName();

        $file->storeAs('tugas', $namaFile);

        $infoKelas = Kelas::with('angkatan')->where('id_kelas', $id_kelas)->first();
        $tingkat = $infoKelas->angkatan->id_tingkat;
        $semester = $infoKelas->angkatan->semester;

        
        $deadline = Carbon::parse($request->deadline);


        $DaftarTugas = DaftarTugas::create([
            'id_sekolah' => $id_sekolah,
            'id_kelas' => $id_kelas,
            'id_mapel' => $id_mapel,
            'keterangan' => $request->keterangan_tugas,
            'deadline' => $deadline,
            'tingkat' => $tingkat,
            'semester' => $semester,
            'nama_file' => $namaFile,
        ]);


        $DaftarNilai = DaftarNilai::create([
                'id_daftar_tugas' => $DaftarTugas->id_daftar_tugas,
                'id_sekolah' => $id_sekolah,
                'id_kelas' => $id_kelas,
                'id_mapel' => $id_mapel,
                'keterangan' => $request->keterangan_tugas,
                'tipe_nilai' => 'Tugas',
                'tanggal' => $deadline,
                'tingkat' => $tingkat,
                'semester' => $semester,
                'sifat' => 'online'
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

        
        return back()->with('success', 'Tugas berhasil disimpan!');


    }

    public function manajMateriKelas (Request $request)
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

        return view('guru.manajemen_materi_kelas', ['daftarkelasYangDiampu' => $daftarkelasYangDiampu]);

    }

    public function inputMateri (Request $request, $id_kelas, $id_mapel)
    {

        $idSekolah = $request->cookie('id_sekolah');
        $idUser = $request->cookie('id_user');

        //cek apakah guru mengajar kelas&mapel ini + ambil kelas & angkatan
        $infoJKA = Jadwal::where('id_kelas', $id_kelas)
                    ->where('id_mapel', $id_mapel)
                    ->where('id_sekolah', $idSekolah)
                    ->with('kelas.angkatan')
                    ->with('mapel')
                    ->whereHas('mapel', function ($query) use ($idUser) {
                        $query->where('id_guru', $idUser);
                    })
                    ->whereHas('kelas.angkatan', function ($query) {
                        $query->whereColumn('angkatans.semester', 'jadwals.semester');
                    })
                    ->whereHas('kelas.angkatan', function ($query) {
                        // Filter Jadwal berdasarkan tingkat yang ada di relasi angkatan
                        $query->whereColumn('angkatans.id_tingkat', 'jadwals.tingkat');
                    })
                    ->firstOrFail();


        $daftarMateri = DaftarMateri::where('id_kelas', $id_kelas)
                    ->where('id_mapel', $id_mapel)
                    ->where('id_sekolah', $idSekolah)
                    ->where('tingkat', $infoJKA->kelas->angkatan->id_tingkat)
                    ->where('semester', $infoJKA->kelas->angkatan->semester)
                    ->get();


        return view('guru.input_materi', ['daftarMateri' => $daftarMateri, 'infoJKA' => $infoJKA]);
    }

    public function storeMateri (Request $request, $id_kelas, $id_mapel)
    {
        $id_sekolah = $request->cookie('id_sekolah');
        $idUser = $request->cookie('id_user');

        $request->validate([
            'file' => 'required|file|mimes:pdf|max:5048',
            'judul_materi' => 'required|string|max:255',
            'deskripsi_materi' => 'required|string|max:255'
        ],[
            'file.required' => 'File tidak boleh kosong.',
            'judul_materi.required' => 'Judul tidak boleh kosong.',
            'judul_materi.max' => 'Judul maksimal 255 karakter.',
            'deskripsi_materi.required' => 'Deskripsi tidak boleh kosong.',
            'deskripsi_materi.max' => 'Deskripsi maksimal 255 karakter.',
        ]);

        $infoJKA = Jadwal::where('id_kelas', $id_kelas)
                    ->where('id_mapel', $id_mapel)
                    ->where('id_sekolah', $id_sekolah)
                    ->with('kelas.angkatan')
                    ->with('mapel')
                    ->whereHas('mapel', function ($query) use ($idUser) {
                        $query->where('id_guru', $idUser);
                    })
                    ->whereHas('kelas.angkatan', function ($query) {
                        $query->whereColumn('angkatans.semester', 'jadwals.semester');
                    })
                    ->whereHas('kelas.angkatan', function ($query) {
                        // Filter Jadwal berdasarkan tingkat yang ada di relasi angkatan
                        $query->whereColumn('angkatans.id_tingkat', 'jadwals.tingkat');
                    })
                    ->firstOrFail();
                    
        $file = $request->file('file');
        $namaFile = time() . '_' . $file->getClientOriginalName();

        DaftarMateri::create([
            'id_mapel' => $id_mapel,
            'id_kelas' => $id_kelas,
            'id_sekolah' => $id_sekolah,
            'keterangan' => $request->keterangan_materi,
            'tanggal' => Carbon::now()->format('Y-m-d'),
            'tingkat' => $infoJKA->kelas->angkatan->id_tingkat,
            'semester' => $infoJKA->kelas->angkatan->semester,
            'judul_materi' => $request->judul_materi,
            'deskripsi_materi' => $request->deskripsi_materi,
            'nama_file' => $namaFile
        ]);


        $file->storeAs('materi', $namaFile);

        return redirect()->route('inputMateri', ['id_kelas' => $id_kelas, 'id_mapel' => $id_mapel])->with('success', 'Materi berhasil disimpan!');


    }

    public function lihatMateri (Request $request, $namaFile)
    {
        $id_sekolah = $request->cookie('id_sekolah');
        $idUser = $request->cookie('id_user');
        
        //ambil id mapel dari namaFile
        $infoDaftarMateri = DaftarMateri::where('nama_file', $namaFile)
                    ->where('id_sekolah', $id_sekolah)
                    ->firstOrFail();


        //cek apakah guru mengajar kelas&mapel ini + ambil kelas & angkatan
        $infoJKA = Jadwal::where('id_kelas', $infoDaftarMateri->id_kelas)
                    ->where('id_mapel', $infoDaftarMateri->id_mapel)
                    ->where('id_sekolah', $id_sekolah)
                    ->with('kelas.angkatan')
                    ->with('mapel')
                    ->whereHas('mapel', function ($query) use ($idUser) {
                        $query->where('id_guru', $idUser);
                    })
                    ->whereHas('kelas.angkatan', function ($query) {
                        $query->whereColumn('angkatans.semester', 'jadwals.semester');
                    })
                    ->whereHas('kelas.angkatan', function ($query) {
                        // Filter Jadwal berdasarkan tingkat yang ada di relasi angkatan
                        $query->whereColumn('angkatans.id_tingkat', 'jadwals.tingkat');
                    })
                    ->firstOrFail();

        //cek semester & angkatan aktif
        $infoDaftarMateri = DaftarMateri::where('nama_file', $namaFile)
                    ->where('id_sekolah', $id_sekolah)
                    ->where('tingkat', $infoJKA->kelas->angkatan->id_tingkat)
                    ->where('semester', $infoJKA->kelas->angkatan->semester)
                    ->firstOrFail();


        // $infoAngkatan = Angkatan::where('id_angkatan', )->first();


        if (Storage::disk('local')->exists("materi/$namaFile")) {
            $path = Storage::disk('local')->path("materi/$namaFile");
            $headers = ['Content-Type' => 'application/pdf'];

            // Mengembalikan file sebagai respons inline
            return response()->file($path, $headers);
        }

        abort(404, 'File not found');

    }

    public function updateMateri(Request $request, $id_materi)
    {
        $id_sekolah = $request->cookie('id_sekolah');
        $id_user = $request->cookie('id_user');

        $request->validate([
            'judul_materi' => 'required|string|max:255',
            'deskripsi_materi' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf|max:5048' // File is optional on update
        ], [
            'judul_materi.required' => 'Judul tidak boleh kosong.',
            'judul_materi.max' => 'Judul maksimal 255 karakter.',
            'deskripsi_materi.required' => 'Deskripsi tidak boleh kosong.',
            'deskripsi_materi.max' => 'Deskripsi maksimal 255 karakter.',
            'file.mimes' => 'File harus berformat PDF.',
            'file.max' => 'Ukuran file maksimal 5MB.',
        ]);

        try {
            // 1. Find the material by its ID and school ID
            $materi = DaftarMateri::where('id_daftar_materi', $id_materi)
                ->where('id_sekolah', $id_sekolah)
                ->firstOrFail();

            // 2. Authorize: Check if the current teacher teaches this subject in this class
            Jadwal::where('id_kelas', $materi->id_kelas)
                ->where('id_mapel', $materi->id_mapel)
                ->where('id_sekolah', $id_sekolah)
                ->whereHas('mapel', function ($query) use ($id_user) {
                    $query->where('id_guru', $id_user);
                })
                ->firstOrFail();

            $updateData = [
                'judul_materi' => $request->judul_materi,
                'deskripsi_materi' => $request->deskripsi_materi,
            ];

            // 3. Handle file update if a new file is uploaded
            if ($request->hasFile('file')) {
                // Delete the old file
                if ($materi->nama_file && Storage::disk('local')->exists('materi/' . $materi->nama_file)) {
                    Storage::disk('local')->delete('materi/' . $materi->nama_file);
                }

                // Store the new file
                $file = $request->file('file');
                $namaFile = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('materi', $namaFile);
                $updateData['nama_file'] = $namaFile;
            }

            // 4. Update the record
            $materi->update($updateData);

            // 5. Redirect back with a success message
            return redirect()->route('inputMateri', ['id_kelas' => $materi->id_kelas, 'id_mapel' => $materi->id_mapel])
                ->with('success', 'Materi berhasil diperbarui!');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // This will trigger a 404 Not Found response if the material or authorization fails
            abort(404, 'Materi tidak ditemukan atau Anda tidak memiliki izin untuk mengubahnya.');
        }
    }

    public function destroyMateri(Request $request, $id_materi)
    {
        $id_sekolah = $request->cookie('id_sekolah');
        $id_user = $request->cookie('id_user');

        try {
            // 1. Find the material by its ID and school ID
            $materi = DaftarMateri::where('id_daftar_materi', $id_materi)
                ->where('id_sekolah', $id_sekolah)
                ->firstOrFail();

            // 2. Authorize: Check if the current teacher teaches this subject in this class
            Jadwal::where('id_kelas', $materi->id_kelas)
                ->where('id_mapel', $materi->id_mapel)
                ->where('id_sekolah', $id_sekolah)
                ->whereHas('mapel', function ($query) use ($id_user) {
                    $query->where('id_guru', $id_user);
                })
                ->firstOrFail();

            // 3. Delete the associated file from storage
            if ($materi->nama_file && Storage::disk('local')->exists('materi/' . $materi->nama_file)) {
                Storage::disk('local')->delete('materi/' . $materi->nama_file);
            }

            // 4. Delete the record from the database
            $materi->delete();

            // 5. Redirect back with a success message
            return redirect()->route('inputMateri', ['id_kelas' => $materi->id_kelas, 'id_mapel' => $materi->id_mapel])
                ->with('success', 'Materi berhasil dihapus!');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // This will trigger a 404 Not Found response if the material or authorization fails
            abort(404, 'Materi tidak ditemukan atau Anda tidak memiliki izin untuk menghapusnya.');
        }
    }


    public function lihatSoalSiswa (Request $request, $namaFile)
    {
        $id_sekolah = $request->cookie('id_sekolah');
        $idUser = $request->cookie('id_user');
        
        //ambil id mapel dari namaFile
        $infoDaftarMateri = DaftarTugas::where('nama_file', $namaFile)
                    ->where('id_sekolah', $id_sekolah)
                    ->firstOrFail();


        //cek apakah guru mengajar kelas&mapel ini + ambil kelas & angkatan
        $infoJKA = Jadwal::where('id_kelas', $infoDaftarMateri->id_kelas)
                    ->where('id_mapel', $infoDaftarMateri->id_mapel)
                    ->where('id_sekolah', $id_sekolah)
                    ->with('kelas.angkatan')
                    ->with('mapel')
                    ->whereHas('mapel', function ($query) use ($idUser) {
                        $query->where('id_guru', $idUser);
                    })
                    ->whereHas('kelas.angkatan', function ($query) {
                        $query->whereColumn('angkatans.semester', 'jadwals.semester');
                    })
                    ->whereHas('kelas.angkatan', function ($query) {
                        // Filter Jadwal berdasarkan tingkat yang ada di relasi angkatan
                        $query->whereColumn('angkatans.id_tingkat', 'jadwals.tingkat');
                    })
                    ->firstOrFail();

        //cek semester & angkatan aktif
        $infoDaftarMateri = DaftarTugas::where('nama_file', $namaFile)
                    ->where('id_sekolah', $id_sekolah)
                    ->where('tingkat', $infoJKA->kelas->angkatan->id_tingkat)
                    ->where('semester', $infoJKA->kelas->angkatan->semester)
                    ->firstOrFail();


        // $infoAngkatan = Angkatan::where('id_angkatan', )->first();


        if (Storage::disk('local')->exists("tugas/$namaFile")) {
            $path = Storage::disk('local')->path("tugas/$namaFile");
            $headers = ['Content-Type' => 'application/pdf'];

            // Mengembalikan file sebagai respons inline
            return response()->file($path, $headers);
        }

        abort(404, 'File not found');

    }


    public function manajPengumumanKelas(Request $request)
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

        return view('guru.manajemen_pengumuman_kelas', ['daftarkelasYangDiampu' => $daftarkelasYangDiampu]);
    }

    public function manajPengumumanDaftar (Request $request, $id_kelas, $id_mapel) 
    {

        $id_sekolah = $request->cookie('id_sekolah');
        $id_user = $request->cookie('id_user');

            // cek apakah guru mengajar kelas&mapel ini + ambil kelas & angkatan, & cek semester & angkatan aktif
        $infoJKA = Jadwal::where('id_kelas', $id_kelas)
                    ->where('id_mapel', $id_mapel)
                    ->where('id_sekolah', $id_sekolah)
                    ->with('kelas.angkatan')
                    ->with('mapel')
                    ->whereHas('mapel', function ($query) use ($id_user) {
                        $query->where('id_guru', $id_user);
                    })
                    ->whereHas('kelas.angkatan', function ($query) {
                        $query->whereColumn('angkatans.semester', 'jadwals.semester');
                    })
                    ->whereHas('kelas.angkatan', function ($query) {
                        // Filter Jadwal berdasarkan tingkat yang ada di relasi angkatan
                        $query->whereColumn('angkatans.id_tingkat', 'jadwals.tingkat');
                    })
                    ->firstOrFail();
        

        $DaftarPengumuman = DaftarPengumuman::where('id_kelas', $id_kelas)
            ->where('id_mapel', $id_mapel)
            ->where('id_sekolah', $id_sekolah)
            ->where('created_at', '>=', Carbon::now()->subWeeks(1))
            ->get();

        return view('guru.manajemen_pengumuman_daftar', ['infoJKA' => $infoJKA, 'daftarPengumuman' => $DaftarPengumuman]);

    }

    public function storePengumumanDaftar (Request $request, $id_kelas, $id_mapel)
    {
        $id_sekolah = $request->cookie('id_sekolah');
        $id_user = $request->cookie('id_user');

        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string|max:255'
        ],[
            'judul.required' => 'Judul tidak boleh kosong.',
            'judul.max' => 'Judul maksimal 255 karakter.',
            'isi.required' => 'Isi tidak boleh kosong.',
            'isi.max' => 'Isi maksimal 255 karakter.',
        ]);


        $infoJKA = Jadwal::where('id_kelas', $id_kelas)
                    ->where('id_mapel', $id_mapel)
                    ->where('id_sekolah', $id_sekolah)
                    ->with('kelas.angkatan')
                    ->with('mapel')
                    ->whereHas('mapel', function ($query) use ($id_user) {
                        $query->where('id_guru', $id_user);
                    })
                    ->whereHas('kelas.angkatan', function ($query) {
                        $query->whereColumn('angkatans.semester', 'jadwals.semester');
                    })
                    ->whereHas('kelas.angkatan', function ($query) {
                        // Filter Jadwal berdasarkan tingkat yang ada di relasi angkatan
                        $query->whereColumn('angkatans.id_tingkat', 'jadwals.tingkat');
                    })
                    ->firstOrFail();

        // dd($infoKelas->semester);

        DaftarPengumuman::create([
            'id_sekolah' => $id_sekolah,
            'id_kelas' => $id_kelas,
            'id_mapel' => $id_mapel,
            'judul' => $request->judul,
            'isi' => $request->isi,
        ]);
        
        return redirect()->route('manajPengumumanDaftar', ['id_kelas' => $id_kelas, 'id_mapel' => $id_mapel])->with('success', 'Pengumuman berhasil ditambahkan!');

    }

    //////////////////////////////////////////////////////////////////
    public function updatePengumuman(Request $request, $id_pengumuman)
{
    $id_sekolah = $request->cookie('id_sekolah');
    $id_user    = $request->cookie('id_user');

    $request->validate([
        'judul' => 'required|string|max:255',
        'isi'   => 'required|string|max:1000',
    ], [
        'judul.required' => 'Judul tidak boleh kosong.',
        'judul.max'      => 'Judul maksimal 255 karakter.',
        'isi.required'   => 'Isi tidak boleh kosong.',
        'isi.max'        => 'Isi maksimal 1000 karakter.',
    ]);

    try {
        // Cari pengumuman
        $pengumuman = DaftarPengumuman::where('id_pengumuman', $id_pengumuman)
            ->where('id_sekolah', $id_sekolah)
            ->firstOrFail();

        $id_kelas = $pengumuman->id_kelas;
        $id_mapel = $pengumuman->id_mapel;

        // Pastikan guru punya izin
        Jadwal::where('id_kelas', $id_kelas)
            ->where('id_mapel', $id_mapel)
            ->where('id_sekolah', $id_sekolah)
            ->whereHas('mapel', function ($query) use ($id_user) {
                $query->where('id_guru', $id_user);
            })
            ->firstOrFail();

        // 🔑 Update manual pakai query builder, tidak pakai $pengumuman->update()
        DB::table('daftar_pengumuman')
            ->where('id_pengumuman', $id_pengumuman)
            ->where('id_sekolah', $id_sekolah)
            ->update([
                'judul'      => $request->judul,
                'isi'        => $request->isi,
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('manajPengumumanDaftar', [
                'id_kelas' => $id_kelas,
                'id_mapel' => $id_mapel
            ])
            ->with('success', 'Pengumuman berhasil diperbarui!');

    } catch (ModelNotFoundException $e) {
        return back()->with('error', 'Pengumuman tidak ditemukan atau Anda tidak memiliki izin.');
    } catch (\Exception $e) {
        return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
    }
}
public function destroyPengumuman($id_pengumuman, Request $request)
{
    $id_sekolah = $request->cookie('id_sekolah');
    $id_user    = $request->cookie('id_user');

    try {
        // Cari pengumuman sesuai ID & sekolah
        $pengumuman = DaftarPengumuman::where('id_pengumuman', $id_pengumuman)
            ->where('id_sekolah', $id_sekolah)
            ->firstOrFail();

        $id_kelas = $pengumuman->id_kelas;
        $id_mapel = $pengumuman->id_mapel;

        // Cek otorisasi guru
        Jadwal::where('id_kelas', $id_kelas)
            ->where('id_mapel', $id_mapel)
            ->where('id_sekolah', $id_sekolah)
            ->whereHas('mapel', function ($query) use ($id_user) {
                $query->where('id_guru', $id_user);
            })
            ->firstOrFail();

        // Hapus pengumuman
        DB::table('daftar_pengumuman')
            ->where('id_pengumuman', $id_pengumuman)
            ->where('id_sekolah', $id_sekolah)
            ->delete();

        return redirect()
            ->route('manajPengumumanDaftar', [
                'id_kelas' => $id_kelas,
                'id_mapel' => $id_mapel
            ])
            ->with('success', 'Pengumuman berhasil dihapus!');
    
    } catch (ModelNotFoundException $e) {
        return back()->with('error', 'Pengumuman tidak ditemukan atau Anda tidak memiliki izin.');
    } catch (\Exception $e) {
        return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
    }
}



    public function exportNilai(Request $request, $id_kelas, $id_mapel)
    {
        
        $id_user = $request->cookie('id_user');
        $id_sekolah = $request->cookie('id_sekolah');
        
        $infoJKA = Jadwal::where('id_kelas', $id_kelas)
        ->where('id_mapel', $id_mapel)
        ->where('id_sekolah', $id_sekolah)
        ->with('kelas.angkatan')
        ->with('mapel')
        ->whereHas('mapel', function ($query) use ($id_user) {
            $query->where('id_guru', $id_user);
        })
        ->whereHas('kelas.angkatan', function ($query) {
            $query->whereColumn('angkatans.semester', 'jadwals.semester');
        })
        ->whereHas('kelas.angkatan', function ($query) {
            // Filter Jadwal berdasarkan tingkat yang ada di relasi angkatan
            $query->whereColumn('angkatans.id_tingkat', 'jadwals.tingkat');
        })
        ->firstOrFail();
        
        // dd($infoKelas->semester);
        
        $namaFile = 'laporan_nilai_siswa_' . $infoJKA->kelas->nama_kelas .'_'. $infoJKA->mapel->nama_mapel .'_'. date('Y-m-d') . '.xlsx';
        $id_tingkat = $infoJKA->kelas->angkatan->id_tingkat;
        $semester = $infoJKA->kelas->angkatan->semester;
        

        // Panggil facade Excel untuk men-download file
        return Excel::download(new LaporanNilaiExport($id_kelas, $id_mapel, $id_tingkat, $semester), $namaFile);

    }



    public function updateTugas(Request $request, $id)
    {
        $request->validate([
            'keterangan_tugas' => 'required|string|max:255',
            'deadline' => 'required|date',
            'file' => 'nullable|file|mimes:pdf|max:10240', // Opsional, PDF, max 10MB
        ], [
            'keterangan_tugas.required' => 'Keterangan tugas tidak boleh kosong.',
            'deadline.required' => 'Deadline tidak boleh kosong.',
            'file.mimes' => 'File harus dalam format PDF.',
            'file.max' => 'Ukuran file maksimal adalah 10MB.',
        ]);

        // Cari tugas berdasarkan ID
        $tugas = DaftarTugas::findOrFail($id);

        // Update keterangan dan deadline
        $tugas->keterangan = $request->keterangan_tugas;
        $tugas->deadline = $request->deadline;

        // Cek jika ada file baru yang diunggah
        if ($request->hasFile('file')) {
            // Hapus file lama dari storage jika ada
            if ($tugas->nama_file && Storage::disk('local')->exists('tugas/' . $tugas->nama_file)) {
                Storage::disk('local')->delete('tugas/' . $tugas->nama_file);
            }

            // Simpan file baru
            $file = $request->file('file');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('tugas', $namaFile, 'local'); // Simpan di storage/app/tugas

            // Update nama file di database
            $tugas->nama_file = $namaFile;
        }

        // Simpan perubahan pada tabel daftar_tugas
        $tugas->save();

        // Sinkronkan perubahan ke tabel daftar_nilai yang terkait
        $daftarNilai = DaftarNilai::where('id_daftar_tugas', $tugas->id_daftar_tugas)->first();
        if ($daftarNilai) {
            $daftarNilai->keterangan = $request->keterangan_tugas;
            $daftarNilai->tanggal = $request->deadline;
            $daftarNilai->save();
        }

        return back()->with('success', 'Tugas berhasil diperbarui!');
    }


    public function destroyTugas($id)
    {
        // Cari tugas berdasarkan ID
        $tugas = DaftarTugas::findOrFail($id);

        // Cari daftar nilai yang terkait dengan tugas ini
        $daftarNilai = DaftarNilai::where('id_daftar_tugas', $tugas->id_daftar_tugas)->first();

        if ($daftarNilai) {
            // Hapus semua entri nilai siswa yang terkait
            DaftarNilaiSiswa::where('id_daftar_nilai', $daftarNilai->id_daftar_nilai)->delete();
            // Hapus daftar nilai itu sendiri
            $daftarNilai->delete();
        }

        // Hapus file soal dari storage jika ada
        if ($tugas->nama_file && Storage::disk('local')->exists('tugas/' . $tugas->nama_file)) {
            Storage::disk('local')->delete('tugas/' . $tugas->nama_file);
        }

        // Hapus tugas itu sendiri
        $tugas->delete();

        // Redirect kembali dengan pesan sukses
        return back()->with('success', 'Tugas berhasil dihapus!');
    }

    public function destroyDaftarNilai(Request $request, $id_daftar_nilai)
    {
        $id_sekolah = $request->cookie('id_sekolah');
        $id_user = $request->cookie('id_user');

        // 1. Cari sesi penilaian yang akan dihapus, pastikan milik guru yang login
        $daftarNilai = DaftarNilai::where('id_daftar_nilai', $id_daftar_nilai)
            ->where('id_sekolah', $id_sekolah)
            ->whereHas('mapel', function ($query) use ($id_user) {
                $query->where('id_guru', $id_user);
            })
            ->firstOrFail();

        // 2. Hapus semua nilai siswa yang terkait dengan sesi ini (Cascading Delete)
        DaftarNilaiSiswa::where('id_daftar_nilai', $daftarNilai->id_daftar_nilai)->delete();

        // 3. Hapus sesi penilaian itu sendiri
        $daftarNilai->delete();

        // 4. Redirect kembali dengan pesan sukses
        return back()->with('success', 'Sesi penilaian berhasil dihapus!');
    }


}
