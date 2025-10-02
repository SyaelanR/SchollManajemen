<?php

namespace App\Http\Controllers;

use App\Models\RiwayatKeuangan;
use App\Models\User; // Menggunakan model User untuk Siswa dan Guru
use App\Models\Angkatan;
use App\Models\DaftarAcara;
use App\Models\DaftarKurikulum;
use App\Models\DaftarNilaiSiswa;
use App\Models\Kelas;
use App\Models\PmabayaranSiswa;
use App\Models\DaftarTagihan;
use App\Models\Jadwal;
use App\Models\Mapel;
use App\Models\Tingkat;
use App\Models\Teacher; // Jika ini model terpisah untuk guru, mungkin tidak diperlukan jika semua dihandle User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
            'angkatan' => [
                'required',
                'string',
                'max:255',
                Rule::unique('angkatans', 'angkatan')
                    ->where('id_sekolah', $request->cookie('id_sekolah'))
            ],
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date'
        ], [
            'angkatan.required' => 'Tahun ajaran tidak boleh kosong.',
            'angkatan.unique' => 'Tahun ajaran ini sudah ada di sekolah Anda.',
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



    // PERBAIKAN: Menerima $id_kelas langsung dari parameter route
    public function lihatKelas(Request $request, $id_kelas)
    {
        $id_sekolah = $request->cookie('id_sekolah');
        
        $infoKelas = Kelas::where('id_kelas', $id_kelas)->where('id_sekolah', $id_sekolah)->with('angkatan')->first();
        $daftarSiswa = User::where('id_kelas', $id_kelas)->where('id_sekolah', $id_sekolah)->get();
        $daftarSiswaBelumPunyaKelas = User::where('id_kelas', null)->where('id_sekolah', $id_sekolah)->where('role', 'siswa')->get();
        $jumlahSiswa = $daftarSiswa->count();
        
        return view('admin.lihat_kelas', ['id_kelas' => $id_kelas,'infoKelas' => $infoKelas, 'daftarSiswa' => $daftarSiswa, 'daftarSiswaBelumPunyaKelas' => $daftarSiswaBelumPunyaKelas, 'jumlahSiswa' => $jumlahSiswa]);
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
        $id_kelass = Kelas::where('id_kelas', $id_kelas)->where('id_sekolah', $request->cookie('id_sekolah'))->firstOrFail();
        $siswa_ids = $request->input('siswa_ids');

        // 2. Update id_kelas untuk semua siswa yang dipilih
        User::whereIn('id', $siswa_ids)->update(['id_kelas' => $id_kelass->id_kelas, 'id_angkatan' => $id_kelass->id_angkatan]);

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
        $mapels = Mapel::with('guru')
            ->where('id_sekolah', $id_sekolah)
            ->where('id_sekolah', $id_sekolah)->latest()->get();

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


        Mapel::create([
            'id_sekolah' => $id_sekolah,
            'kode_mapel' => $request->kode_mapel,
            'nama_mapel' => $request->nama_mapel,
            'kategori' => $request->kategori,
            'sks' => $request->sks,
            'id_guru' => $request->guru_id,
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

        // Menggunakan firstOrFail untuk menangani kasus jika kelas tidak ditemukan
        // dan with('angkatan') untuk eager loading, mengurangi jumlah query.
        $kelas = Kelas::with('angkatan')
                      ->where('id_kelas', $id_kelas)
                      ->where('id_sekolah', $id_sekolah)
                      ->firstOrFail(); // Akan melempar 404 Not Found jika kelas tidak ada

        // Mengambil semester dari relasi angkatan yang sudah di-load, bukan query baru.
        $semesterAktif = $kelas->angkatan->semester ?? null;
        $tingkatAktif = $kelas->angkatan->id_tingkat ?? null;

        // Mengambil semua mapel yang tersedia untuk sekolah ini untuk form tambah jadwal.
        $mapels = Mapel::with('guru')
                    ->where('id_sekolah', $id_sekolah)->get();

        // Mengambil data jadwal yang sudah ada untuk kelas ini.
        // Menggunakan nested eager loading 'mapel.guru' untuk mendapatkan nama mapel dan nama guru.
        $jadwals = Jadwal::with('mapel.guru') // Memuat relasi mapel, dan relasi guru di dalam mapel
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
            'tingkat' => $angkatan->first()->id_tingkat ?? null,
            'ruangan' => $request->ruangan,
        ]);
        return redirect()->route('tambahJadwal', ['id_kelas' => $id_kelas])->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function updateJadwal(Request $request, int $id_jadwal)
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
            'jam_mulai.required' => 'Jam mulai tidak boleh kosong.',
            'jam_selesai.required' => 'Jam selesai tidak boleh kosong.',
            'id_mapel.required' => 'Mata pelajaran tidak boleh kosong.',
            'ruangan.required' => 'Ruangan tidak boleh kosong.',
        ]);

        // Cari jadwal yang akan diupdate
        $jadwal = Jadwal::where('id_jadwal', $id_jadwal)
                      ->where('id_sekolah', $id_sekolah)
                      ->firstOrFail();

        // Update data jadwal
        $jadwal->update([
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'id_mapel' => $request->id_mapel,
            'ruangan' => $request->ruangan,
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->route('tambahJadwal', ['id_kelas' => $jadwal->id_kelas])->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function manajTingkat()
    {
        $id_sekolah = request()->cookie('id_sekolah');
        $tingkats = Tingkat::where('id_sekolah', $id_sekolah)->orderBy('tingkat', 'asc')->get();
        return view('admin.manajemen_tingkat', compact('tingkats'));
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

    public function updateTingkat(Request $request, $id_tingkat)
    {
        $id_sekolah = $request->cookie('id_sekolah');

        $request->validate([
            'tingkat' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tingkats', 'tingkat')
                    ->where('id_sekolah', $id_sekolah)
                    ->ignore($id_tingkat, 'id_tingkat')
            ],
        ], [
            'tingkat.required' => 'Nama tingkat tidak boleh kosong.',
            'tingkat.unique' => 'Nama tingkat ini sudah ada.',
        ]);

        $tingkat = Tingkat::where('id_tingkat', $id_tingkat)
                         ->where('id_sekolah', $id_sekolah)
                         ->firstOrFail();

        $tingkat->update([
            'tingkat' => $request->tingkat,
        ]);

        return redirect()->route('manajemenTingkat')->with('success', 'Tingkat berhasil diperbarui!');
    }

    public function destroyTingkat(Request $request, $id_tingkat)
    {
        $id_sekolah = $request->cookie('id_sekolah');
        
        // 1. Cari tingkat tertinggi yang ada di database untuk sekolah ini.
        // Parameter $id_tingkat dari URL akan diabaikan.
        // Menggunakan orderByRaw untuk memastikan pengurutan numerik yang benar pada kolom string.
        $tingkatTertinggi = Tingkat::where('id_sekolah', $id_sekolah)
                                   ->orderByRaw('CAST(tingkat AS UNSIGNED) DESC, tingkat DESC')
                                   ->first();
        
        // 2. Jika tingkat tertinggi ditemukan, hapus. Jika tidak, kembali dengan pesan error.
        if ($tingkatTertinggi) {
            $tingkatTertinggi->delete();
            return redirect()->route('manajemenTingkat')->with('success', 'Tingkat tertinggi berhasil dihapus!');
        }
        
        return redirect()->route('manajemenTingkat')->withErrors(['error' => 'Tidak ada tingkat yang bisa dihapus.']);
    }

    public function manajKurikulum (Request $request) 
    {
        $id_sekolah = request()->cookie('id_sekolah');

        $angkatans = Angkatan::where('id_sekolah', $id_sekolah)->latest()->get();

        $kurikulums = DaftarKurikulum::where('id_sekolah', $id_sekolah)
                    ->with('angkatan')
                    ->get();

        return view('admin.manajemen_kurikulum', ['kurikulums' => $kurikulums, 'angkatans' => $angkatans]);
    }

    public function storeKurikulum(Request $request)
    {
        $id_sekolah = $request->cookie('id_sekolah');

        $request->validate([
            'angkatan' => 'required|exists:angkatans,id_angkatan', //cek apakah id_angkatan ada di tabel angkatans
            'nama' => 'required|string|max:255',
            'jenjang' => 'required|string|in:SMA,SMK,SD,SMP',
            'jumlah_matpel' => 'required|integer|min:1',
        ], [
            'angkatan.required' => 'Angkatan tidak boleh kosong.',
            'angkatan.exists' => 'Angkatan tidak valid.',
            'nama.required' => 'Nama kurikulum tidak boleh kosong.',
            'jenjang.required' => 'Jenjang kurikulum tidak boleh kosong.',
            'jenjang.in' => 'Jenjang kurikulum tidak valid.',
            'jumlah_matpel.required' => 'Jumlah mata pelajaran tidak boleh kosong.',
            'jumlah_matpel.integer' => 'Jumlah mata pelajaran harus berupa angka.',
            'jumlah_matpel.min' => 'Jumlah mata pelajaran harus minimal 1.', 
        ]);

        DaftarKurikulum::create([
            'id_sekolah' => $id_sekolah,
            'id_angkatan' => $request->angkatan,
            'nama_kurikulum' => $request->nama,
            'jenjang' => $request->jenjang,
            'jumlah_matpel' => $request->jumlah_matpel,
        ]);

        return redirect()->route('manajemenKurikulum')->with('success', 'Kurikulum berhasil ditambahkan!');

    }

    public function manajRapor ()
    {
        $id_sekolah = request()->cookie('id_sekolah');

        $kelaslist = Kelas::where('id_sekolah', $id_sekolah)->get();

        foreach ($kelaslist as $kelas) {
        // Hitung dan tambahkan properti jumlah_siswa ke setiap item jadwal
        $kelas->jumlah_siswa = User::where('id_kelas', $kelas->id_kelas)->count();
    }
        
        return view('admin.manajemen_rapor', ['kelasList' => $kelaslist]);
    }

    public function Rapors(Request $request, int $id_kelas)
    {
        $id_sekolah = $request->cookie('id_sekolah');
    
        // Ambil info kelas dan angkatan untuk data umum di rapor
        $kelasInfo = Kelas::with('angkatan.sekolah')->findOrFail($id_kelas);
    
        // Ambil semua siswa dalam kelas beserta relasi nilai mereka
        $students = User::where('id_kelas', $id_kelas)
                        ->where('id_sekolah', $id_sekolah)
                        ->with([
                            'daftarNilaiSiswa.mapel', 
                            'daftarNilaiSiswa.daftarNilai',
                            'daftarAbsensiSiswa' // Eager load relasi absensi
                        ])
                        ->whereHas('daftarNilaiSiswa', function($query) use ($kelasInfo) {
                            $query->where('tingkat', $kelasInfo->angkatan->id_tingkat);
                            $query->where('semester', $kelasInfo->angkatan->semester);
                        })
                        ->get();
    
        // Proses data untuk setiap siswa
        $processedRapors = $students->map(function ($student) use ($kelasInfo) {
            // Kelompokkan nilai berdasarkan mapel
            $nilaiByMapel = $student->daftarNilaiSiswa->groupBy('id_mapel');
    
            $raporData = $nilaiByMapel->map(function ($nilaiGroup) {
                $scores = [
                    'Tugas' => [],
                    'PR'    => [],
                    'UTS'   => [],
                    'UAS'   => [],
                ];
    
                // 1. Kumpulkan semua nilai untuk setiap tipe ke dalam array
                foreach ($nilaiGroup as $nilai) {
                    if ($nilai->daftarNilai && is_numeric($nilai->nilai)) {
                        $tipe = $nilai->daftarNilai->tipe_nilai;
                        if (array_key_exists($tipe, $scores)) {
                            $scores[$tipe][] = $nilai->nilai; // Tambahkan nilai ke array
                        }
                    }
                }
    
                // Helper function untuk menghitung rata-rata
                $calculateAverage = function (array $numbers) {
                    if (empty($numbers)) {
                        return null;
                    }
                    return array_sum($numbers) / count($numbers);
                };
    
                // 2. Hitung rata-rata untuk setiap tipe nilai
                $avgTugas = $calculateAverage($scores['Tugas']);
                $avgPR = $calculateAverage($scores['PR']);
                $avgUTS = $calculateAverage($scores['UTS']);
                $avgUAS = $calculateAverage($scores['UAS']);
    
                // 3. Gabungkan rata-rata PR ke Tugas dengan bobot 30%
                $nilaiTugasAkhir = $avgTugas;
                if (is_numeric($avgTugas) && is_numeric($avgPR)) {
                    // Jika keduanya ada, hitung dengan bobot
                    $nilaiTugasAkhir = round(($avgTugas * 0.7) + ($avgPR * 0.3));
                } elseif (is_numeric($avgPR) && !is_numeric($avgTugas)) {
                    // Jika hanya ada PR, nilai PR menjadi nilai Tugas
                    $nilaiTugasAkhir = $avgPR;
                }
    
                // 4. Siapkan skor akhir untuk ditampilkan di rapor
                $finalScores = [
                    'Tugas' => $nilaiTugasAkhir !== null ? round($nilaiTugasAkhir) : null,
                    'UTS'   => $avgUTS !== null ? round($avgUTS) : null,
                    'UAS'   => $avgUAS !== null ? round($avgUAS) : null,
                    'Nilai Akhir' => 0,
                ];
    
                // 5. Hitung Nilai Akhir Rapor dari rata-rata (Tugas Akhir, UTS, UAS)
                $validScores = array_filter([$finalScores['Tugas'], $finalScores['UTS'], $finalScores['UAS']], 'is_numeric');
                if (count($validScores) > 0) {
                    $finalScores['Nilai Akhir'] = round(array_sum($validScores) / count($validScores));
                }
    
                return [
                    'mapel' => $nilaiGroup->first()->mapel,
                    'scores' => $finalScores,
                ];
            });
    
            // --- LOGIKA BARU UNTUK MENGHITUNG ABSENSI ---
            // Filter absensi berdasarkan semester dan tingkat dari kelas saat ini
            $absensiSemesterIni = $student->daftarAbsensiSiswa
                ->where('tingkat', $kelasInfo->angkatan->id_tingkat)
                ->where('semester', $kelasInfo->angkatan->semester);

            // Hitung jumlah untuk setiap status
            $attendanceCounts = [
                'Sakit' => $absensiSemesterIni->where('status', 'Sakit')->count(),
                'Izin'  => $absensiSemesterIni->where('status', 'Izin')->count(),
                'Alpha' => $absensiSemesterIni->where('status', 'Alpha')->count(),
            ];

            // Kembalikan data siswa bersama dengan data rapor yang sudah diproses
            return [
                'siswa' => $student,
                'rapor' => $raporData,
                'absensi' => $attendanceCounts, // Tambahkan data absensi ke hasil
            ];
        });
    
        return view('admin.rapors', ['processedRapors' => $processedRapors, 'kelasInfo' => $kelasInfo]);
    }



    /**
     * Memperbarui data kelas yang ada di database.
     */
    
    
    /**
     * Menghapus data kelas dari database.
     */


    ##############################YOGA##############################
    ##############################YOGA##############################
    ##############################YOGA##############################
    ##############################YOGA##############################
    ##############################YOGA##############################
    ##############################YOGA##############################
    ##############################YOGA##############################
    ##############################YOGA##############################
    ##############################YOGA##############################
    ##############################YOGA##############################
    ##############################YOGA##############################
    ##############################YOGA##############################

        public function destroyAngkatan(Request $request, $id)
    {
        $id_sekolah = $request->cookie('id_sekolah');

        $angkatan = Angkatan::where('id_angkatan', $id)
                            ->where('id_sekolah', $id_sekolah)
                            ->firstOrFail();

        $angkatan->delete();

        return redirect()->route('manajemenAngkatan')->with('success', 'Angkatan berhasil dihapus!');
    }


        public function hapusGuru(Request $request, $id)
    {
        $id_sekolah = $request->cookie('id_sekolah');

        $guru = User::where('id', $id)
            ->where('id_sekolah', $id_sekolah)
            ->whereIn('role', ['guru', 'staf'])
            ->firstOrFail();

        $guru->delete();

        return redirect()->route('manajemenGuru')->with('success', 'Data guru/staf berhasil dihapus!');
    }


        public function hapusSiswa(Request $request, User $siswa)
    {
        $id_sekolah = $request->cookie('id_sekolah');

        // Pastikan siswa yang akan dihapus adalah role 'siswa' dan milik sekolah yang sama
        if ($siswa->role !== 'siswa' || $siswa->id_sekolah != $id_sekolah) {
            abort(403, 'Akses ditolak atau siswa tidak ditemukan.');
        }

        $siswa->delete();
        return redirect()->route('manajemenSiswa')->with('success', 'Data siswa berhasil dihapus!');
    }


        public function destroyKelas(Request $request, $id_kelas) // Should be destroy() for KelasController
    {
        $id_sekolah = $request->cookie('id_sekolah');
        $kelas = Kelas::where('id_kelas', $id_kelas)->where('id_sekolah', $id_sekolah)->firstOrFail();
        $kelas->delete();

        return redirect()->route('manajemenKelas')->with('success', 'Data kelas berhasil dihapus!'); // PERBAIKAN: Menggunakan nama route yang benar
    }

        public function editGuru($id)
    {
        $id_sekolah = request()->cookie('id_sekolah');
        $teacher = User::where('id', $id)
                        ->where('id_sekolah', $id_sekolah) // Tambahkan filter id_sekolah
                        ->whereIn('role', ['guru', 'staf'])->firstOrFail();
        return view('guru.edit_guru', compact('teacher')); // Sesuaikan path view
    }

        public function editSiswa(Request $request, User $siswa) // Menggunakan Route Model Binding untuk User (sebagai siswa)
    {
        $id_sekolah = $request->cookie('id_sekolah');

        // Pastikan siswa yang akan diedit adalah role 'siswa' dan milik sekolah yang sama
        if ($siswa->role !== 'siswa' || $siswa->id_sekolah != $id_sekolah) {
            abort(403, 'Akses ditolak atau siswa tidak ditemukan.'); // Atau redirect dengan pesan error
        }

        $kelases = Kelas::where('id_sekolah', $id_sekolah)->get(); // Ambil semua data kelas untuk dropdown
        return view('admin.edit-siswa', compact('siswa', 'kelases')); // Sesuaikan path view Anda
    }
    

    public function editKelas(Request $request, $id_kelas) // Should be edit() for KelasController
    {
        $id_sekolah = $request->cookie('id_sekolah');
        // Temukan kelas spesifik dari database berdasarkan ID dan id_sekolah
        $kelas = Kelas::where('id_kelas', $id_kelas)
                      ->where('id_sekolah', $id_sekolah)
                      ->firstOrFail();

        // Ambil data angkatan yang tersedia untuk sekolah ini saja
        $angkatans = Angkatan::where('id_sekolah', $id_sekolah)->latest()->get();

        // Kembalikan view edit, berikan data kelas yang spesifik dan angkatan yang relevan
        return view('admin.edit-kelas', compact('kelas', 'angkatans'));
    }

    public function updateGuru(Request $request, $id)
    {
        $id_sekolah = $request->cookie('id_sekolah');

        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|unique:users,nisn_nik,' . $id,
            'name' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'no_telp' => 'nullable|string|max:15',
            'username' => 'required|string|unique:users,username,' . $id,
            'jabatan' => 'required|string|in:guru,staf',
            'password' => 'nullable|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $guru = User::where('id', $id)
            ->where('id_sekolah', $id_sekolah)
            ->firstOrFail();

        $updateData = [
            'name' => $request->name,
            'nisn_nik' => $request->nik, // Sesuaikan dengan nama kolom yang benar
            'username' => $request->username,
            'role' => $request->jabatan,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            // 'usia' tidak ada di form update, jika perlu ditambahkan
        ];

        // Hanya update password jika diisi
        if ($request->filled('password')) {
            $updateData['password'] = bcrypt($request->password);
        }
        
        // Hanya update email jika username berubah (karena email dibuat dari username)
        if ($request->username !== $guru->username) {
             $updateData['email'] = $request->username . '@sekolah.sch.id';
        }

        $guru->update($updateData);

        return redirect()->route('manajemenGuru')->with('success', 'Data guru berhasil diperbarui!');
    }

    public function updateAngkatan(Request $request, $id)
    {
        $id_sekolah = $request->cookie('id_sekolah');

        $request->validate([
            'angkatan' => 'required|string|max:255|unique:angkatans,angkatan,' . $id . ',id_angkatan,id_sekolah,' . $id_sekolah, // Tambahkan id_sekolah ke unique rule
            'id_tingkat' => 'required|integer|exists:tingkats,id_tingkat',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'semester' => 'required|in:ganjil,genap', // Tambahkan validasi untuk semester
        ], [
            'angkatan.required' => 'Tahun ajaran tidak boleh kosong.',
            'angkatan.unique' => 'Tahun ajaran ini sudah ada.',
            'id_tingkat.required' => 'Tingkat tidak boleh kosong.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai.',
            'semester.required' => 'Semester tidak boleh kosong.',
            'semester.in' => 'Semester tidak valid.',
        ]);

        $angkatan = Angkatan::where('id_angkatan', $id)
                            ->where('id_sekolah', $id_sekolah)
                            ->firstOrFail();

        $angkatan->update([
            'angkatan' => $request->angkatan,
            'id_tingkat' => $request->id_tingkat,
            'tingkat' => Tingkat::where('id_tingkat', $request->id_tingkat)->value('tingkat'),
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'semester' => $request->semester, // Tambahkan ini
        ]);

        return redirect()->route('manajemenAngkatan')->with('success', 'Angkatan berhasil diperbarui!');
    }

    public function updateSiswa(Request $request, User $siswa) // Menggunakan Route Model Binding untuk User (sebagai siswa)
    {
        $id_sekolah = $request->cookie('id_sekolah');

        // Pastikan siswa yang akan diupdate adalah role 'siswa' dan milik sekolah yang sama
        if ($siswa->role !== 'siswa' || $siswa->id_sekolah != $id_sekolah) {
            abort(403, 'Akses ditolak atau siswa tidak ditemukan.'); // Atau redirect dengan pesan error
        }

        $request->validate([
            'nisn_nik' => 'required|string|max:255|unique:users,nisn_nik,' . $siswa->id, // unique kecuali untuk siswa ini
            'name' => 'required|string|max:255',
            'id_kelas' => 'nullable|exists:kelas,id_kelas', // Sesuaikan dengan nama kolom ID di tabel kelas Anda
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'username' => 'required|string|max:255|unique:users,username,' . $siswa->id,
            'password' => 'nullable|string|min:6', // Password bisa kosong jika tidak ingin diubah
            'tempat_lahir' => 'nullable|string|max:100', // Tambahkan validasi lain jika diperlukan
            'no_telp' => 'nullable|string|max:20', // Tambahkan validasi lain jika diperlukan
        ]);

        $updateData = [
            'nisn_nik' => $request->nisn_nik,
            'name' => $request->name,
            'username' => $request->username,
            'id_kelas' => $request->id_kelas,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'id_angkatan' => Kelas::where('id_kelas', $request->id_kelas)->value('id_angkatan'),
        ];

        // Hanya update password jika diisi
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        // Hanya update email jika username berubah (karena email dibuat dari username)
        if ($request->username !== $siswa->username) {
             $updateData['email'] = $request->username . '@sekolah.sch.id';
        }


        $siswa->update($updateData);

        return redirect()->route('manajemenSiswa')->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function updateKelas(Request $request, $id_kelas) // Should be update() for KelasController
    {
        $id_sekolah = $request->cookie('id_sekolah');

        // Aturan validasi
        $request->validate([
            'nama_kelas' => [
                'required',
                'string',
                'max:255',
                // Pastikan nama kelas unik untuk angkatan dan sekolah yang sama, kecuali untuk ID kelas ini sendiri
                'unique:kelas,nama_kelas,' . $id_kelas . ',id_kelas,id_angkatan,' . $request->id_angkatan . ',id_sekolah,' . $id_sekolah,
            ],
            'wali_kelas' => 'required|string|max:255',
            'id_angkatan' => 'required|exists:angkatans,id_angkatan', // 'exists' memeriksa apakah id_angkatan ada di tabel angkatans
            'jurusan' => 'nullable|string|max:20',
        ]);

        // Cari kelas berdasarkan ID dan id_sekolah untuk keamanan
        $kelas = Kelas::where('id_kelas', $id_kelas)
                      ->where('id_sekolah', $id_sekolah)
                      ->firstOrFail();

        $kelas->update([
            'nama_kelas' => $request->nama_kelas,
            'wali_kelas' => $request->wali_kelas,
            'id_angkatan' => $request->id_angkatan,
            'jurusan' => $request->jurusan,
        ]);

        // Arahkan kembali ke daftar kelas utama dengan pesan sukses
        return redirect()->route('manajemenKelas')->with('success', 'Data kelas berhasil diperbarui!');
    }


    public function updateMapel(Request $request, $id)
    {
        $id_sekolah = request()->cookie('id_sekolah');

        $request->validate([
            'kode_mapel' => 'required|string|max:20|unique:mapels,kode_mapel,' . $id . ',id_mapel,id_sekolah,' . $id_sekolah,
            'nama_mapel' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'sks' => 'required|integer|min:1',
            'guru_id' => 'nullable|exists:users,id',
            'status' => 'required|in:aktif,nonaktif',
        ], [
            'kode_mapel.required' => 'Kode mata pelajaran tidak boleh kosong.',
            'kode_mapel.unique' => 'Kode mata pelajaran ini sudah ada.',
            'nama_mapel.required' => 'Nama mata pelajaran tidak boleh kosong.',
            'kategori.required' => 'Kategori mata pelajaran tidak boleh kosong.',
            'sks.required' => 'SKS tidak boleh kosong.',
            'sks.integer' => 'SKS harus berupa angka.',
            'sks.min' => 'SKS harus minimal 1.',
            'guru_id.exists' => 'Guru pengampu tidak valid.',
            'status.required' => 'Status tidak boleh kosong.',
        ]);

        // Cari mapel yang akan diupdate
        $mapel = Mapel::where('id_mapel', $id)
                      ->where('id_sekolah', $id_sekolah)
                      ->firstOrFail();

        // Ambil nama guru jika ada
        $namaGuru = User::where('id', $request->guru_id)->where('id_sekolah', $id_sekolah)->value('name');

        // Update data mapel
        $mapel->update([
            'kode_mapel' => $request->kode_mapel,
            'nama_mapel' => $request->nama_mapel,
            'kategori' => $request->kategori,
            'sks' => $request->sks,
            'id_guru' => $request->guru_id,
            'nama_guru' => $namaGuru,
            'status' => $request->status,
        ]);

        return redirect()->route('manajemenMapel')->with('success', 'Mata pelajaran berhasil diperbarui!');
    }

    public function destroyMapel(Request $request, $id)
    {
        $id_sekolah = $request->cookie('id_sekolah');

        $mapel = Mapel::where('id_mapel', $id)
                      ->where('id_sekolah', $id_sekolah)
                      ->firstOrFail();

        $mapel->delete();

        return redirect()->route('manajemenMapel')->with('success', 'Mata pelajaran berhasil dihapus!');
    }

    public function destroySingle($id_jadwal)
    {
        $jadwal = Jadwal::findOrFail($id_jadwal);
        $jadwal->delete();

        return redirect()->back()->with('success', 'Jadwal berhasil dihapus.');
    }

    public function keluarkanSiswaDariKelas(Request $request, $id_siswa, $id_kelas)
    {
        $id_sekolah = $request->cookie('id_sekolah');

        // 1. Cari siswa berdasarkan id, id_sekolah, dan role
        $siswa = User::where('id', $id_siswa)
                     ->where('id_sekolah', $id_sekolah)
                     ->where('role', 'siswa')
                     ->firstOrFail(); // Akan gagal jika siswa tidak ditemukan

        // 2. Verifikasi apakah siswa benar-benar ada di kelas yang dimaksud
        if ($siswa->id_kelas != $id_kelas) {
            // Jika tidak, kembalikan dengan pesan error
            return back()->with('error', 'Siswa tidak ditemukan di kelas ini.');
        }

        // 3. Set id_kelas menjadi null untuk mengeluarkan siswa dari kelas
        $siswa->id_kelas = null;
        $siswa->id_angkatan = null;
        $siswa->save();

        // 4. Redirect kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->route('manajemenKelas')->with('success', 'Siswa berhasil dikeluarkan!');


    }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
########################################################################################################################################
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
public function manajAcara(Request $request)
    {

        $id_sekolah = request()->cookie('id_sekolah');

        $daftarAcara = DaftarAcara::where('id_sekolah', $id_sekolah)
                        ->where('tanggal_selesai', '>=', Carbon::now()->subWeeks(1))
                        ->get();

        return View('admin.acara-sekolah', ['daftarAcara' => $daftarAcara]);
    }

    /**
     * Menyimpan acara baru yang ditambahkan melalui form modal.
     * Corresponds to POST /admin/acara-sekolah
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // 1. Validasi data input
        $validatedData = $request->validate([
            'judul_acara' => 'required|string|max:255',
            'tanggal_acara' => 'required|date',
            'waktu_acara' => 'required|date_format:H:i',
            'lokasi' => 'required|string|max:255',
            'peserta_target' => 'required|string|in:Semua,Siswa,Guru,Kelas XI & XII',
            'deskripsi' => 'nullable|string|max:500',
        ]);

        // 2. Simpan ke database (Contoh menggunakan Model Event, yang harus Anda buat)
        // \App\Models\Event::create($validatedData);

        // 3. Redirect ke halaman index dengan pesan sukses
        return redirect()->route('admin.acara-sekolah')->with('success', 'Acara baru berhasil ditambahkan!');
    }
    
    /**
     * Placeholder untuk menghapus acara.
     * Corresponds to DELETE /admin/acara-sekolah/{id}
     */
    public function destroy($id)
    {
        // Temukan dan hapus event
        // \App\Models\Event::destroy($id);
        
        return redirect()->route('admin.acara-sekolah')->with('success', 'Acara berhasil dihapus.');
    }
}
