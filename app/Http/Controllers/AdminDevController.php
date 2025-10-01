<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Clien;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminDevController extends Controller
{

    public function tambahAdminKlien (int $id_sekolah)
    {
        // dd($id_sekolah);

        $info_sekolah = Clien::where('id_sekolah', $id_sekolah)->first();
    
        return view('adminDev.tambah_admin_klien', ['info_sekolah' => $info_sekolah]);
    }

    public function infoKlienD ()
    {
        return view('adminDev.info_klien');
    }

    public function infoKlien (Request $request) {
        $id_sekolah = $request ->input('id_sekolah');

        $admin_sekolah = User::where('id_sekolah', $id_sekolah)->where('role', 'admin')->get();
        $info_sekolah = Clien::where('id_sekolah', $id_sekolah)->first();

        return view('adminDev.info_klien', ['info_sekolah' => $info_sekolah, 'admin_sekolah' => $admin_sekolah, 'id_sekolah' => $id_sekolah]);

    }

     public function storeAdmin(Request $request, int $id_sekolah)
    {
        $validator = Validator::make($request->all(), [
            'admin' => 'required|array|min:1',
            'admin.*.nip' => 'required|string|distinct|unique:users,nisn_nik',
            'admin.*.username' => 'required|string|distinct|unique:users,nisn_nik',

            'admin.*.nama' => 'required|string|max:255',
            'admin.*.password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        foreach ($request->admin as $adminData) {
            // Pastikan semua data yang diperlukan ada sebelum membuat user
            if (isset($adminData['nama'], $adminData['nip'], $adminData['password'])) {
                User::create([
                    'name' => $adminData['nama'],
                    'email' => $adminData['username'] . '@sekolah.sch.id', // Membuat email unik berdasarkan NIP
                    'password' => $adminData['password'],
                    'nisn_nik' => $adminData['nip'],
                    'username' => $adminData['username'],
                    'role' => 'admin', // Otomatis mengatur role sebagai guru
                    'id_sekolah' => $id_sekolah,
                ]);
            }
        }

        return response()->json(['message' => 'Data semua guru berhasil disimpan!'], 200);
    }

    public function tambahKlien()
    {
        return view('adminDev.tambah_klien');
    }

    public function storeKlien(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_sekolah' => 'required|string|max:255',
            'email' => 'required|email|unique:cliens,email',
            'no_telp' => 'required|string|max:20',
            'alamat' => 'required|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Clien::create([
            'nama_sekolah' => $request->input('nama_sekolah'),
            'email' => $request->input('email'),
            'no_telp' => $request->input('no_telp'),
            'alamat' => $request->input('alamat'),
        ]);

        return redirect()->route('dashboard')->with('success', 'Data klien berhasil disimpan!');
    }
}