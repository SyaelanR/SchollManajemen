<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Angkatan;
use App\Models\Kelas;
use Illuminate\Http\Request;
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
    public function dashboard()
    {
        // return view('admin.add_users'); //gunakan titik untuk masuk kedalam folder
        return view('dashboard');
    }

    public function manajSiswa()
    {
        $students = User::where('role', 'siswa')->latest()->paginate(10);
        return view('admin.manajemen_siswa', ['students' => $students]);
    }

    public function tambahSiswa()
    {
        return view('admin.tambah_siswa');
    }
    
    public function manajGuru()
    {
        $teachers = User::where('role', 'guru')->latest()->paginate(10);
        return view('admin.manajemen_guru', ['teachers' => $teachers]);
    }

    public function tambahGuru()
    {
        return view('admin.tambah_guru');
    }


    public function storeSiswa(Request $request)
    {
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
                ]);
            }
        }

        return response()->json(['message' => 'Data semua siswa berhasil disimpan!'], 200);
    }


    public function storeGuru(Request $request)
    {
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
                ]);
            }
        }

        return response()->json(['message' => 'Data semua guru berhasil disimpan!'], 200);
    }

    public function manajAngkatan()
    {
        // Mengambil semua data dari tabel angkatan, diurutkan dari yang terbaru
        $angkatans = Angkatan::latest()->get();
        return view('admin.manajemen_angkatan', ['angkatans' => $angkatans]);
        // return view('admin.manajemen_angkatan');
    }

    public function storeAngkatan(Request $request)
    {
        // Validasi input dari form
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
        ]);

        // Arahkan kembali ke halaman manajemen angkatan dengan pesan sukses
        return redirect()->route('manajemenAngkatan')->with('success', 'Angkatan berhasil ditambahkan!');
    }

    public function manajKelas()
    {
        $angkatans = Angkatan::latest()->get();

        $kelas = Kelas::latest()->get();
        return view('admin.manajemen_kelas', ['angkatans' => $angkatans, 'kelasList' => $kelas]);
    }

    public function storeKelas(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'id_angkatan' => 'required|integer'
        ], [
            'nama_kelas.required' => 'Nama kelas tidak boleh kosong.',
            'angkatan.required' => 'Tahun ajaran tidak boleh kosong'
        ]);

        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'id_angkatan' => $request->id_angkatan
        ]);

        return redirect()->route('manajemenKelas')->with('success', 'Kelas berhasil ditambahkan!');

    }
}
