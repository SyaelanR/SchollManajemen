<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        return view('manajemen_siswa', ['students' => $students]);
    }

    public function tambahSiswa()
    {
        return view('tambah_siswa');
    }

    public function storeSiswa(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'students' => 'required|array|min:1',
            // 'distinct' memastikan keunikan dalam array yang dikirim.
            // 'unique' memastikan keunikan di tabel 'users'.
            'students.*.nisn' => 'required|string|distinct|unique:users,nisn_nip',

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
                    'email' => $studentData['nisn'] . '@sekolah.sch.id', // Membuat email unik berdasarkan NISN
                    'password' => $studentData['password'],
                    'nisn_nip' => $studentData['nisn'],
                    'jenis_kelamin' => $studentData['gender'],
                    'role' => 'siswa', // Otomatis mengatur role sebagai siswa
                ]);
            }
        }

        return response()->json(['message' => 'Data semua siswa berhasil disimpan!'], 200);
    }
}
