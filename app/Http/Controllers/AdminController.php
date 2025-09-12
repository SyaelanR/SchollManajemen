<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Menampilkan dashboard
    public function dashboard()
    {
        return view('dashboard');
    }

    // -----------------------------
    // Manajemen Siswa
    // -----------------------------
    public function manajSiswa()
    {
        $students = User::where('role','siswa')->latest()->paginate(10);
        return view('admin.manajemen_siswa', compact('students'));
    }

    public function tambahSiswa()
    {
        return view('admin.tambah_siswa');
    }

    public function storeSiswa(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'students' => 'required|array|min:1',
            'students.*.nisn' => 'required|string|distinct|unique:users,nisn_nip',
            'students.*.username' => 'required|string|distinct|unique:users,username',
            'students.*.nama' => 'required|string|max:255',
            'students.*.gender' => 'required|in:Laki-laki,Perempuan',
            'students.*.password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 422);
        }

        foreach($request->students as $s){
            User::create([
                'name' => $s['nama'],
                'email'=> $s['username'].'@sekolah.sch.id',
                'password'=> Hash::make($s['password']),
                'nisn_nip'=> $s['nisn'],
                'jenis_kelamin'=> $s['gender'],
                'username'=> $s['username'],
                'role'=> 'siswa',
            ]);
        }

        return response()->json(['message'=>'Data semua siswa berhasil disimpan!'],200);
    }

    // -----------------------------
    // Manajemen Guru
    // -----------------------------
    public function manajGuru()
    {
        $teachers = User::where('role','guru')->latest()->paginate(10);
        return view('admin.manajemen_guru', compact('teachers'));
    }

    public function tambahGuru()
    {
        return view('admin.tambah_guru');
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
            return response()->json(['errors'=>$validator->errors()], 422);
        }

        foreach($request->teacher as $t){
            User::create([
                'name'=>$t['nama'],
                'email'=>$t['username'].'@sekolah.sch.id',
                'password'=> Hash::make($t['password']),
                'nisn_nip'=> $t['nip'],
                'mapel'=> $t['mapel'],
                'username'=>$t['username'],
                'role'=>'guru',
            ]);
        }

        return response()->json(['message'=>'Data semua guru berhasil disimpan!'],200);
    }

    // -----------------------------
    // Input Nilai
    // -----------------------------

    // Tampilkan daftar kelas (kelas.blade.php)
    public function inputNilai()
    {
        $kelas = \App\Models\Kelas::all();
        return view('admin.kelas', compact('kelas'));
    }

    // Tampilkan form input nilai siswa per kelas (inputnilai_siswa.blade.php)
    public function inputNilaiKelas($id)
    {
        $kelas = \App\Models\Kelas::findOrFail($id);
        $students = User::where('role','siswa')->where('kelas_id',$id)->get();
        return view('admin.inputnilai_siswa', compact('kelas','students'));
    }

    // Simpan nilai siswa
    public function storeNilai(Request $request, $id)
    {
        foreach($request->nilai as $siswa_id => $data){
            \App\Models\Nilai::updateOrCreate(
                [
                    'siswa_id'=> $siswa_id,
                    'kelas_id'=> $id,
                    'mapel'=> $data['mapel'],
                ],
                [
                    'nilai'=> $data['nilai'],
                    'guru_id'=> auth()->id(),
                ]
            );
        }
        return redirect()->route('kelas.inputNilai',$id)->with('success','Nilai berhasil disimpan!');
    }
}
