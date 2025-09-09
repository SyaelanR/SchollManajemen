<?php

namespace App\Http\Controllers;

use App\Models\RiwayatKeuangan;
use App\Models\User;
use App\Models\Angkatan;
use App\Models\Kelas;
use App\Models\PmabayaranSiswa;
use App\Models\DaftarTagihan;
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
        $teachers = User::where('role', 'guru')->where('id_sekolah', $id_sekolah)->latest()->paginate(10);
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
            // 'distinct' memastikan keunikan dalam array yang dikirim.
            // 'unique' memastikan keunikan di tabel 'users'.
            'students.*.nisn' => 'required|string|distinct|unique:users,nisn_nip',
            'students.*.username' => 'required|string|distinct|unique:users,username',

            // PERINGATAN: Menjadikan nama unik biasanya bukan praktik yang baik dalam sistem sekolah nyata
            // karena ada kemungkinan siswa memiliki nama yang sama. NISN adalah pengidentifikasi unik yang lebih baik.
            // Aturan ini ditambahkan sesuai permintaan Anda.

            'students.*.nama' => 'required|string|max:255',
            // 'students.*.nama' => 'required|string|max:255|distinct|unique:users,name',

            'students.*.gender' => 'required|in:Laki-laki,Perempuan',
            'students.*.password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        foreach ($request->students as $studentData) {
            if (isset($studentData['nama'], $studentData['nisn'], $studentData['gender'], $studentData['password'])) {
                User::create([
                    'name' => $studentData['nama'],
                    'email' => $studentData['username'] . '@sekolah.sch.id', // Membuat email unik berdasarkan NISN
                    'password' => $studentData['password'],
                    'nisn_nip' => $studentData['nisn'],
                    'jenis_kelamin' => $studentData['gender'],
                    'username' => $studentData['username'],
                    'role' => 'siswa', // Otomatis mengatur role sebagai siswa
                    'id_sekolah' => $id_sekolah,
                ]);
            }
        }

        return response()->json(['message' => 'Data semua siswa berhasil disimpan!'], 200);
    }





    public function storeGuru(Request $request)
    {
        $id_sekolah = $request->cookie('id_sekolah');
        $validator = Validator::make($request->all(), [
            'teacher' => 'required|array|min:1',
            'teacher.*.nip' => 'required|string|distinct|unique:users,nisn_nip',
            'teacher.*.username' => 'required|string|distinct|unique:users,username',

            'teacher.*.nama' => 'required|string|max:255',
            'teacher.*.mapel' => 'required|string|max:255',
            'teacher.*.password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        foreach ($request->teacher as $teacherData) {
            // Pastikan semua data yang diperlukan ada sebelum membuat user
            if (isset($teacherData['nama'], $teacherData['nip'], $teacherData['password'], $teacherData['mapel'])) {
                User::create([
                    'name' => $teacherData['nama'],
                    'email' => $teacherData['username'] . '@sekolah.sch.id', // Membuat email unik berdasarkan NIP
                    'password' => $teacherData['password'],
                    'nisn_nip' => $teacherData['nip'],
                    'mapel' => $teacherData['mapel'],
                    'username' => $teacherData['username'],
                    'role' => 'guru', // Otomatis mengatur role sebagai guru
                    'id_sekolah' => $id_sekolah,
                ]);
            }
        }

        return response()->json(['message' => 'Data semua guru berhasil disimpan!'], 200);
    }




    public function manajAngkatan(Request $request)
    {
        $id_sekolah = $request->cookie('id_sekolah');
        // Mengambil semua data dari tabel angkatan, diurutkan dari yang terbaru
        $angkatans = Angkatan::where('id_sekolah', $id_sekolah)->latest()->get();
        return view('admin.manajemen_angkatan', ['angkatans' => $angkatans]);
        // return view('admin.manajemen_angkatan');
    }

    public function storeAngkatan(Request $request)
    {   
        $id_sekolah = $request->cookie('id_sekolah');

        $request->validate([
            // Validasi untuk satu input 'angkatan' dengan aturan unik di tabel 'angkatans'
            'angkatan' => 'required|string|max:255|unique:angkatans,angkatan',
        ], [
            'angkatan.required' => 'Tahun ajaran tidak boleh kosong.',
            'angkatan.unique' => 'Tahun ajaran ini sudah ada.',
        ]);

        // Buat entri baru di tabel angkatan
        Angkatan::create([
            'angkatan' => $request->angkatan,
            'id_sekolah' => $id_sekolah,
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
            'id_angkatan' => 'required|integer'
        ], [
            'nama_kelas.required' => 'Nama kelas tidak boleh kosong.',
            'id_angkatan.required' => 'Tahun ajaran tidak boleh kosong, buat angkatan terlebih dahulu'
        ]);

        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'id_angkatan' => $request->id_angkatan,
            'id_sekolah' => $id_sekolah
        ]);

        return redirect()->route('manajemenKelas')->with('success', 'Kelas berhasil ditambahkan!');

    }




    public function lihatKelas(Request $request)
    {
        $id_sekolah = $request->cookie('id_sekolah');
        $id_kelas = $request->input('id_kelas');
        // dd($id_kelas);
        $namaKelas = Kelas::where('id_kelas', $id_kelas)->where('id_sekolah', $id_sekolah)->first();
        $daftarSiswa = User::where('id_kelas', $id_kelas)->where('id_sekolah', $id_sekolah)->get();
        $daftarSiswaBelumPunyaKelas = User::where('id_kelas', null)->where('id_sekolah', $id_sekolah)->where('role', 'siswa')->get();
        // $angkatan = Angkatan::where('id', $kelas->id_angkatan)->first();
        return view('admin.lihat_kelas', ['id_kelas' => $id_kelas,'namaKelas' => $namaKelas, 'daftarSiswa' => $daftarSiswa, 'daftarSiswaBelumPunyaKelas' => $daftarSiswaBelumPunyaKelas]);
    }

    

    public function lihatKelasD()
    {
        $dummy = new Kelas();
        $dummy->nama_kelas = "null";
        $dummy->id_angkatan = 0;
        $dummy->id_kelas = 0;
        return view('admin.lihat_kelas',['namaKelas' => $dummy]);
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
            ->select('users.name', 'users.nisn_nip')
            ->get();

        // Mengambil data siswa yang sudah membayar menggunakan join
        $sudahMembayar = User::join('pmabayaran_siswas', 'users.id', '=', 'pmabayaran_siswas.id_siswa')
            ->where('pmabayaran_siswas.id_sekolah', $id_sekolah)
            ->where('pmabayaran_siswas.id_daftar_tagihan', $id_daftar_tagihan)
            ->where('pmabayaran_siswas.status_pembayaran', 'lunas')
            ->select('users.name', 'users.nisn_nip', 'pmabayaran_siswas.updated_at')
            ->get();

        return view('admin.pembayaran_tagihan', [
            'sudahMembayar' => $sudahMembayar, 
            'belumMembayar' => $belumMembayar
        ]);
    }

}
