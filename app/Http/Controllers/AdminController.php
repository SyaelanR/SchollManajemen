<?php

namespace App\Http\Controllers;

use App\Models\RiwayatKeuangan;
use App\Models\User;
use App\Models\Angkatan;
use App\Models\Kelas;
use App\Models\PmabayaranSiswa;
use App\Models\DaftarTagihan;
use App\Models\Jadwal;
use App\Models\Mapel;
use App\Models\Tingkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //
    /**
     * Menampilkan halaman untuk menambah pengguna baru.
     *
     * @return \Illuminate\View\View
     */

    public function manajSiswa(Request $request)
    {
        $id_sekolah = $request->cookie('id_sekolah');
        // Menggunakan leftJoin untuk memastikan semua siswa tetap tampil meskipun belum punya kelas.
        // 'nama_kelas' akan bernilai null jika siswa belum masuk kelas.
        $students = User::where('users.role', 'siswa')
                        ->where('users.id_sekolah', $id_sekolah)
                        ->leftJoin('kelas', 'users.id_kelas', '=', 'kelas.id_kelas')
                        ->select('users.*', 'kelas.nama_kelas')
                        ->latest('users.created_at')->paginate(10);
        return view('admin.manajemen_siswa', ['students' => $students]);
    }

    public function tambahSiswa()
    {
        return view('admin.tambah_siswa');
    }



    
    public function manajGuru(Request $request)
    {
        $id_sekolah = $request->cookie('id_sekolah');
        // Menggunakan whereIn untuk mengambil pengguna dengan role 'guru' atau 'staf'
        $teachers = User::whereIn('role', ['guru', 'staf'])
                        ->where('id_sekolah', $id_sekolah)->latest()->paginate(10);
        return view('admin.manajemen_guru', ['teachers' => $teachers]);
    }




    public function tambahGuru()
    {
        return view('admin.tambah_guru');
    }




    public function storeSiswa(Request $request)
    {
        $id_sekolah = $request->cookie('id_sekolah');

        $validator = Validator::make($request->all(), [
            'students' => 'required|array|min:1',
            'students.*.nisn' => 'required|string|distinct|unique:users,nisn_nik',
            'students.*.username' => 'required|string|distinct|unique:users,username',
            'students.*.nama' => 'required|string|max:255',
            'students.*.gender' => 'required|in:Laki-laki,Perempuan',
            'students.*.password' => 'required|string|min:6',
            'students.*.address' => 'nullable|string|max:255',
            'students.*.birthplace' => 'nullable|string|max:100',
            'students.*.dob' => 'nullable|date',
            'students.*.entry_date' => 'nullable|date',
            'students.*.parent_name' => 'nullable|string|max:255',
            'students.*.parent_phone' => 'nullable|string|max:20',
            'students.*.siblings_count' => 'nullable|integer',
            'students.*.parent_salary' => 'nullable|string|max:50', // Menggunakan string untuk fleksibilitas format
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        foreach ($request->input('students', []) as $studentData) {
            // Memastikan field wajib ada sebelum membuat user
            if (isset($studentData['nama'], $studentData['nisn'], $studentData['username'], $studentData['gender'], $studentData['password'])) {
                User::create([
                    'name'              => $studentData['nama'],
                    'email'             => $studentData['username'] . '@sekolah.sch.id', // Membuat email unik
                    'password'          => $studentData['password'], // Eloquent akan mengenkripsi ini secara otomatis
                    'nisn_nik'          => $studentData['nisn'],
                    'jenis_kelamin'     => $studentData['gender'],
                    'username'          => $studentData['username'],
                    'role'              => 'siswa', // Otomatis mengatur role sebagai siswa
                    'id_sekolah'        => $id_sekolah,
                    
                    // Menambahkan field baru
                    'alamat'            => $studentData['address'],
                    'tempat_lahir'      => $studentData['birthplace'],
                    'tanggal_lahir'     => $studentData['dob'],
                    'tanggal_masuk'     => $studentData['entry_date'] ,
                    'nama_orang_tua'         => $studentData['parent_name'],
                    'no_telp'      => $studentData['parent_phone'],
                    'jumlah_sodara'    => $studentData['siblings_count'],
                    'gaji_orang_tua'         => $studentData['parent_salary'],
                ]);
            }
        }

        return response()->json(['message' => 'Data semua siswa berhasil disimpan!'], 200);
    }





    public function storeGuru(Request $request)
    {
        $id_sekolah = $request->cookie('id_sekolah');
        $validator = Validator::make($request->all(), [
            'teacher'          => 'required|array|min:1',
            'teacher.*.nik'    => 'required|string|distinct|unique:users,nisn_nik',
            'teacher.*.username' => 'required|string|distinct|unique:users,username',
            'teacher.*.nama'     => 'required|string|max:255',
            'teacher.*.password' => 'required|string|min:6',
            'teacher.*.alamat' => 'nullable|string|max:255',
            'teacher.*.tempat_lahir' => 'nullable|string|max:100',
            'teacher.*.tanggal_lahir' => 'nullable|date',
            'teacher.*.usia' => 'nullable|integer',
            'teacher.*.nomor_telp' => 'nullable|string|max:15',
            'teacher.*.jabatan' => 'required|string|in:guru,staf', // 'jabatan' dari form akan menjadi 'role'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        foreach ($request->input('teacher', []) as $teacherData) {
            // Pastikan semua data yang diperlukan ada sebelum membuat user
            if (isset($teacherData['nama'], $teacherData['nik'], $teacherData['password'], $teacherData['username'])) {
                User::create([
                    'name'          => $teacherData['nama'],
                    'email'         => $teacherData['username'] . '@sekolah.sch.id', // Membuat email unik
                    'password'      => $teacherData['password'], // Eloquent akan mengenkripsi ini secara otomatis
                    'nisn_nik'      => $teacherData['nik'],
                    'username'      => $teacherData['username'],
                    'role'          => $teacherData['jabatan'], // Menggunakan 'jabatan' dari form sebagai 'role'
                    'id_sekolah'    => $id_sekolah,
                    'alamat'        => $teacherData['alamat'],
                    'tempat_lahir'  => $teacherData['tempat_lahir'],
                    'tanggal_lahir' => $teacherData['tanggal_lahir'],
                    'usia'          => $teacherData['usia'],
                    'no_telp'       => $teacherData['nomor_telp'],
                ]);
            }
        }

        return response()->json(['message' => 'Data semua staf/guru berhasil disimpan!'], 200);
    }




    public function manajAngkatan(Request $request)
    {
        $id_sekolah = $request->cookie('id_sekolah');
        // Mengambil semua data dari tabel angkatan, diurutkan dari yang terbaru
        $angkatans = Angkatan::where('id_sekolah', $id_sekolah)->latest()->get();
        $tingkats = Tingkat::where('id_sekolah', $id_sekolah)->get();
        return view('admin.manajemen_angkatan', ['angkatans' => $angkatans, 'tingkats' => $tingkats]);
        // return view('admin.manajemen_angkatan');
    }

    public function storeAngkatan(Request $request)
    {   
        $id_sekolah = $request->cookie('id_sekolah');

        $request->validate([
            // Validasi untuk satu input 'angkatan' dengan aturan unik di tabel 'angkatans'
            'angkatan' => 'required|string|max:255|unique:angkatans,angkatan',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date'
        ], [
            'angkatan.required' => 'Tahun ajaran tidak boleh kosong.',
            'angkatan.unique' => 'Tahun ajaran ini sudah ada.',
        ]);

        // Buat entri baru di tabel angkatan
        Angkatan::create([
            'angkatan' => $request->angkatan,
            'id_sekolah' => $id_sekolah,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'id_tingkat' => $request->id_tingkat,
            'tingkat' => Tingkat::where('id_tingkat', $request->id_tingkat)->value('tingkat'),
        ]);

        // Arahkan kembali ke halaman manajemen angkatan dengan pesan sukses
        return redirect()->route('manajemenAngkatan')->with('success', 'Angkatan berhasil ditambahkan!');
    }




    public function manajKelas()
    {
        $id_sekolah = request()->cookie('id_sekolah');

        $angkatans = Angkatan::where('id_sekolah', $id_sekolah)->where('id_sekolah', $id_sekolah)->latest()->get();
        $kelas = Kelas::latest()->where('id_sekolah', $id_sekolah)->get();

        return view('admin.manajemen_kelas', ['angkatans' => $angkatans, 'kelasList' => $kelas]);
    }

    public function storeKelas(Request $request)
    {
        $id_sekolah = $request->cookie('id_sekolah');

        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'id_angkatan' => 'required|integer',
            'wali_kelas' => 'required|string|max:255',
            'jurusan' => 'nullable|string|max:20'
        ], [
            'nama_kelas.required' => 'Nama kelas tidak boleh kosong.',
            'id_angkatan.required' => 'Tahun ajaran tidak boleh kosong, buat angkatan terlebih dahulu',
            'wali_kelas.required' => 'Wali kelas tidak boleh kosong.',
            'jurusan.max' => 'Jurusan maksimal 20 karakter.'
        ]);

        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'id_angkatan' => $request->id_angkatan,
            'id_sekolah' => $id_sekolah,
            'wali_kelas' => $request->wali_kelas,
            'jurusan' => $request->jurusan,
        ]);

        return redirect()->route('manajemenKelas')->with('success', 'Kelas berhasil ditambahkan!');

    }




    public function lihatKelas(Request $request)
    {
        $id_sekolah = $request->cookie('id_sekolah');
        $id_kelas = $request->input('id_kelas');
        // dd($id_kelas);
        $infoKelas = Kelas::where('id_kelas', $id_kelas)->where('id_sekolah', $id_sekolah)->with('angkatan')->first();
        $daftarSiswa = User::where('id_kelas', $id_kelas)->where('id_sekolah', $id_sekolah)->get();
        $daftarSiswaBelumPunyaKelas = User::where('id_kelas', null)->where('id_sekolah', $id_sekolah)->where('role', 'siswa')->get();
        $jumlahSiswa = $daftarSiswa->count();
        // $angkatan = Angkatan::where('id', $kelas->id_angkatan)->first();
        return view('admin.lihat_kelas', ['id_kelas' => $id_kelas,'infoKelas' => $infoKelas, 'daftarSiswa' => $daftarSiswa, 'daftarSiswaBelumPunyaKelas' => $daftarSiswaBelumPunyaKelas, 'jumlahSiswa' => $jumlahSiswa]);
    }

    

    public function lihatKelasD()
    {
        return view('admin.lihat_kelas');
    }

    public function tambahSiswaKeKelas(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'id_kelas' => 'required|integer|exists:kelas,id_kelas',
            'siswa_ids' => 'required|array|min:1',
            'siswa_ids.*' => 'integer|exists:users,id', // Pastikan setiap ID siswa ada di tabel users
        ], [
            'id_kelas.required' => 'ID Kelas tidak valid.',
            'siswa_ids.required' => 'Anda harus memilih setidaknya satu siswa.',
        ]);

        $id_kelas = $request->input('id_kelas');
        $siswa_ids = $request->input('siswa_ids');

        // 2. Update id_kelas untuk semua siswa yang dipilih
        User::whereIn('id', $siswa_ids)->update(['id_kelas' => $id_kelas]);

        // 3. Redirect kembali ke halaman sebelumnya dengan pesan sukses
        // return back()->with('success', 'Siswa berhasil ditambahkan ke kelas!');
        return redirect()->route('manajemenKelas')->with('success', 'Siswa berhasil ditambahkan ke kelas!');
    }

    public function manajKeuangan()
    {
        $id_sekolah = request()->cookie('id_sekolah');

        // Mengambil semua transaksi diurutkan berdasarkan tanggal terlama untuk grafik
        $transaksi = RiwayatKeuangan::where('id_sekolah', $id_sekolah)
            ->orderBy('tanggal', 'asc') // Diubah ke 'asc' untuk urutan grafik yang benar
            ->get();

        // Menghitung total pemasukan dan pengeluaran untuk sekolah terkait
        $totalPemasukan = RiwayatKeuangan::where('id_sekolah', $id_sekolah)->where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = RiwayatKeuangan::where('id_sekolah', $id_sekolah)->where('jenis', 'pengeluaran')->sum('jumlah');
        
        // Mengambil saldo terakhir dari transaksi paling baru
        $saldo = $transaksi->last()->saldo ?? 0;

        // Mengambil data tanggal untuk label dan saldo untuk data grafik
        $labels = $transaksi->pluck('tanggal')->map(function ($tanggal) {
            return Carbon::parse($tanggal)->format('Y-m-d');
        });
        $saldoKumulatifData = $transaksi->pluck('saldo');

        return view('admin.keuangan', compact('transaksi', 'totalPemasukan', 'totalPengeluaran', 'saldo', 'labels', 'saldoKumulatifData'));
    }


    public function storePemasukan(Request $request)
    {
        $id_sekolah = request()->cookie('id_sekolah');

        $request->validate([
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric|min:0.01',
            'keterangan' => 'nullable|string|max:255',
        ], [
            'tanggal.required' => 'Tanggal tidak boleh kosong.',
            'jumlah.required' => 'Jumlah tidak boleh kosong.',
            'jumlah.numeric' => 'Jumlah harus berupa angka.',
            'jumlah.min' => 'Jumlah harus lebih besar dari 0.',
            'keterangan.max' => 'Keterangan maksimal 255 karakter.',
        ]);

        // Ambil saldo terakhir
        $lastTransaction = RiwayatKeuangan::where('id_sekolah', $id_sekolah)->orderBy('tanggal', 'desc')->first();
        $lastSaldo = $lastTransaction ? $lastTransaction->saldo : 0;

        // Hitung saldo baru
        $newSaldo = $lastSaldo + $request->jumlah;

        // Simpan transaksi pemasukan baru
        RiwayatKeuangan::create([
            'id_sekolah' => $id_sekolah,
            'tanggal' => $request->tanggal,
            'jenis' => 'pemasukan',
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'saldo' => $newSaldo,
        ]);

        return redirect()->route('manajemenKeuangan')->with('success', 'Pemasukan berhasil ditambahkan!');
    }

    public function storePengeluaran(Request $request)
    {
        $id_sekolah = request()->cookie('id_sekolah');

        $request->validate([
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric|min:0.01',
            'keterangan' => 'nullable|string|max:255',
        ], [
            'tanggal.required' => 'Tanggal tidak boleh kosong.',
            'jumlah.required' => 'Jumlah tidak boleh kosong.',
            'jumlah.numeric' => 'Jumlah harus berupa angka.',
            'jumlah.min' => 'Jumlah harus lebih besar dari 0.',
            'keterangan.max' => 'Keterangan maksimal 255 karakter.',
        ]);

        // Ambil saldo terakhir
        $lastTransaction = RiwayatKeuangan::where('id_sekolah', $id_sekolah)->orderBy('tanggal', 'desc')->first();
        $lastSaldo = $lastTransaction ? $lastTransaction->saldo : 0;

        // Hitung saldo baru
        $newSaldo = $lastSaldo - $request->jumlah;

        // Simpan transaksi pengeluaran baru
        RiwayatKeuangan::create([
            'id_sekolah' => $id_sekolah,
            'tanggal' => $request->tanggal,
            'jenis' => 'pengeluaran',
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'saldo' => $newSaldo,
        ]);

        return redirect()->route('manajemenKeuangan')->with('success', 'Pengeluaran berhasil ditambahkan!');
    }

    public function tagihanSiswa()
    {
        $id_sekolah = request()->cookie('id_sekolah');
        $angkatans = Angkatan::where('id_sekolah', $id_sekolah)->latest()->get();
        $daftarTagihan = DaftarTagihan::where('id_sekolah', $id_sekolah)->latest()->get();
        return view('admin.tagihan_siswa', ['daftarTagihan' => $daftarTagihan, 'angkatans' => $angkatans]);
    }

    public function storeTagihan(Request $request)
    {
        $id_sekolah = request()->cookie('id_sekolah');

        $request->validate([
            'jumlah_tagihan' => 'required|numeric|min:0.01',
            'jatuh_tempo' => 'required|date',
            'keterangan' => 'nullable|string|max:255',
            // 'target_angkatan' => 'required|string|exists:angkatans,angkatan,id_sekolah,' . $id_sekolah,
        ], [
            'jumlah_tagihan.required' => 'Jumlah tagihan tidak boleh kosong.',
            'jumlah_tagihan.numeric' => 'Jumlah tagihan harus berupa angka.',
            'jumlah_tagihan.min' => 'Jumlah tagihan harus lebih besar dari 0.',
            'jatuh_tempo.required' => 'Jatuh tempo tidak boleh kosong.',
            'jatuh_tempo.date' => 'Jatuh tempo harus berupa tanggal yang valid.',
            'keterangan.max' => 'Keterangan maksimal 255 karakter.',
            // 'target_angkatan.required' => 'Target angkatan tidak boleh kosong.',
            // 'target_angkatan.exists' => 'Target angkatan tidak valid.',
        ]);

        // 1. Buat tagihan baru dan simpan hasilnya ke dalam variabel.
        // Ini lebih aman daripada menggunakan latest()->first() setelahnya.
        $daftarTagihan = DaftarTagihan::create([
            'id_sekolah' => $id_sekolah,
            'jumlah_tagihan' => $request->jumlah_tagihan,
            'jatuh_tempo' => $request->jatuh_tempo,
            'keterangan' => $request->keterangan,
            'target_angkatan' => $request->target_angkatan,
            'nama_angkatan' => Angkatan::where('id_angkatan', $request->target_angkatan)->where('id_sekolah', $id_sekolah)->value('angkatan'),
        ]);

        // 2. Ambil semua siswa yang menjadi target tagihan.
        // Menggunakan 'pluck('id')' lebih efisien jika hanya butuh ID, tapi di sini kita butuh objeknya.
        $targetSiswa = User::where('id_angkatan', $request->target_angkatan)
                            ->where('id_sekolah', $id_sekolah)
                            ->get();

        // 3. Lakukan perulangan untuk membuat entri pembayaran untuk setiap siswa.
        foreach($targetSiswa as $siswa){
            PmabayaranSiswa::create([
                'id_siswa' => $siswa->id,
                'id_sekolah' => $id_sekolah,
                'id_daftar_tagihan' => $daftarTagihan->id_daftar_tagihan, // Gunakan ID dari tagihan yang baru dibuat.
                'jumlah_tagihan' => $request->jumlah_tagihan,
                'status_pembayaran' => 'belum lunas', // Sesuai dengan ENUM di migrasi ('lunas', 'belum lunas').
            ]);
        }

        return redirect()->route('tagihanSiswa')->with('success', 'Tagihan berhasil ditambahkan!');
    }


    public function pembayaranTagihansiswa(Request $request)
    {
        $id_daftar_tagihan = $request->input('id_daftar_tagihan');
        $id_sekolah = request()->cookie('id_sekolah');

        // Mengambil data siswa yang belum membayar menggunakan join
        $belumMembayar = User::join('pmabayaran_siswas', 'users.id', '=', 'pmabayaran_siswas.id_siswa')
            ->where('pmabayaran_siswas.id_sekolah', $id_sekolah)
            ->where('pmabayaran_siswas.id_daftar_tagihan', $id_daftar_tagihan)
            ->where('pmabayaran_siswas.status_pembayaran', 'belum lunas')
            ->select('users.name', 'users.nisn_nik')
            ->get();

        // Mengambil data siswa yang sudah membayar menggunakan join
        $sudahMembayar = User::join('pmabayaran_siswas', 'users.id', '=', 'pmabayaran_siswas.id_siswa')
            ->where('pmabayaran_siswas.id_sekolah', $id_sekolah)
            ->where('pmabayaran_siswas.id_daftar_tagihan', $id_daftar_tagihan)
            ->where('pmabayaran_siswas.status_pembayaran', 'lunas')
            ->select('users.name', 'users.nisn_nik', 'pmabayaran_siswas.updated_at')
            ->get();

        return view('admin.pembayaran_tagihan', [
            'sudahMembayar' => $sudahMembayar, 
            'belumMembayar' => $belumMembayar
        ]);
    }

    public function manajMapel()
    {
        $id_sekolah = request()->cookie('id_sekolah');
        // Menggunakan Eloquent untuk mengambil data agar casting (dekripsi) otomatis diterapkan.
        // 'with('guru')' akan melakukan eager loading relasi 'guru'.
        $mapels = Mapel::where('id_sekolah', $id_sekolah)->latest()->get();

        $teachers = User::where('role', 'guru')->where('id_sekolah', $id_sekolah)->get();
        
        return view('admin.manajemen_mapel', ['mapels' => $mapels, 'teachers' => $teachers]);

    }

    public function storeMapel(Request $request)
    {
        $id_sekolah = request()->cookie('id_sekolah');

        $request->validate([
            'kode_mapel' => 'required|string|max:20|unique:mapels,kode_mapel,NULL,id_mapel,id_sekolah,' . $id_sekolah,
            'nama_mapel' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'sks' => 'required|integer|min:1',
            'guru_pengampu' => 'nullable|exists:users,id',
        ], [
            'kode_mapel.required' => 'Kode mata pelajaran tidak boleh kosong.',
            'kode_mapel.unique' => 'Kode mata pelajaran ini sudah ada.',
            'nama_mapel.required' => 'Nama mata pelajaran tidak boleh kosong.',
            'kategori.required' => 'Kategori mata pelajaran tidak boleh kosong.',
            'sks.required' => 'SKS tidak boleh kosong.',
            'sks.integer' => 'SKS harus berupa angka.',
            'sks.min' => 'SKS harus minimal 1.',
            'guru_pengampu.exists' => 'Guru pengampu tidak valid.',
        ]);

        $namaGuru = User::where('id', $request->guru_pengampu)->where('id_sekolah', $id_sekolah)->value('name') ?? null;

        Mapel::create([
            'id_sekolah' => $id_sekolah,
            'kode_mapel' => $request->kode_mapel,
            'nama_mapel' => $request->nama_mapel,
            'kategori' => $request->kategori,
            'sks' => $request->sks,
            'id_guru' => $request->guru_pengampu,
            'nama_guru' => $namaGuru
        ]);

        return redirect()->route('manajemenMapel')->with('success', 'Mata pelajaran berhasil ditambahkan!');    

    }

    public function manajJadwal(){
        $id_sekolah = request()->cookie('id_sekolah');

        $kelaslist = Kelas::where('id_sekolah', $id_sekolah)->get();
        return view('admin.manajemen_jadwal', ['kelasList' => $kelaslist]);
    }

    public function tambahJadwal(Request $request ,int $id_kelas){
        $id_sekolah = $request->cookie('id_sekolah');

        // Menggunakan `firstOrFail` untuk menangani kasus jika kelas tidak ditemukan
        // dan `with('angkatan')` untuk eager loading, mengurangi jumlah query.
        $kelas = Kelas::with('angkatan')
                      ->where('id_kelas', $id_kelas)
                      ->where('id_sekolah', $id_sekolah)
                      ->firstOrFail(); // Akan melempar 404 Not Found jika kelas tidak ada

        // Mengambil semester dari relasi angkatan yang sudah di-load, bukan query baru.
        $semesterAktif = $kelas->angkatan->semester ?? null;
        $tingkatAktif = $kelas->angkatan->tingkat ?? null;

        // Mengambil semua mapel yang tersedia untuk sekolah ini untuk form tambah jadwal.
        $mapels = Mapel::where('id_sekolah', $id_sekolah)->get();

        // Mengambil data jadwal yang sudah ada untuk kelas ini.
        // Menggunakan nested eager loading 'mapel.guru' untuk mendapatkan nama mapel dan nama guru.
        $jadwals = Jadwal::with('mapel') // Memuat relasi mapel, dan relasi guru di dalam mapel
                        ->where('id_kelas', $id_kelas)
                        ->where('id_sekolah', $id_sekolah)
                        ->where('semester', $semesterAktif) // Hanya jadwal untuk semester aktif
                        ->where('tingkat', $tingkatAktif) // Hanya jadwal untuk tingkat aktif
                        ->orderBy('hari') // Mengurutkan berdasarkan hari
                        ->orderBy('jam_mulai') // Kemudian berdasarkan jam mulai
                        ->get();

        // Mengirimkan data yang diperlukan ke view.
        return view('admin.tambah_jadwal', ['kelas' => $kelas, 'jadwals' => $jadwals, 'mapels' => $mapels,]);
    }

    public function storeJadwal(Request $request, int $id_kelas)
    {
        $id_sekolah = $request->cookie('id_sekolah');
        $request->validate([
            'hari' => 'required|string|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i',
            'id_mapel' => 'required|exists:mapels,id_mapel',
            'ruangan' => 'required|string|nullable|string|max:100',
        ], [
            'hari.required' => 'Hari tidak boleh kosong.',
            'hari.in' => 'Hari tidak valid.',
            'jam_mulai.required' => 'Jam mulai tidak boleh kosong.',
            'jam_mulai.date_format' => 'Format jam mulai tidak valid. Gunakan format HH:MM.',
            'jam_selesai.required' => 'Jam selesai tidak boleh kosong.',
            'jam_selesai.date_format' => 'Format jam selesai tidak valid. Gunakan format HH:MM.',
            'id_mapel.required' => 'Mata pelajaran tidak boleh kosong.',
            'id_mapel.exists' => 'Mata pelajaran tidak valid.',
            'ruangan.max' => 'ruangan maksimal 100 karakter.',
            'ruangan.required' => 'ruangan tidak boleh kosong.',
        ]);

        $idAngkatan = Kelas::where('id_kelas', $id_kelas)->where('id_sekolah', $id_sekolah)->value('id_angkatan');
        $angkatan = Angkatan::where('id_angkatan', $idAngkatan)->where('id_sekolah', $id_sekolah)->get();

        Jadwal::create([
            'id_sekolah' => $id_sekolah,
            'id_kelas' => $id_kelas,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'id_mapel' => $request->id_mapel,
            'semester' => $angkatan->first()->semester ?? null,
            'tingkat' => $angkatan->first()->tingkat ?? null,
            'ruangan' => $request->ruangan,
        ]);
        return redirect()->route('storeJadwal', ['id_kelas' => $id_kelas])->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function manajTingkat()
    {
        return view('admin.manajemen_tingkat');
    }

    public function storeTingkat(Request $request)
    {
        $id_sekolah = $request->cookie('id_sekolah');
        
        // Tambahkan validasi sederhana untuk memastikan cookie ada
        if (!$id_sekolah) {
            return redirect()->back()->with('error', 'Gagal menambahkan tingkat. Sesi sekolah tidak ditemukan.');
        }
        
        $jumlahTingkat = Tingkat::where('id_sekolah', $id_sekolah)->count() ?? 0;

        // Simpan tingkat baru ke database
        Tingkat::create([
            'id_sekolah' => $id_sekolah,
            'tingkat' => $jumlahTingkat + 1,
        ]);

        return redirect()->route('manajemenTingkat')->with('success', 'Tingkat berhasil ditambahkan!');
    }

}
