<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminDevController extends Controller
{
    public function manajKlien ()
    {
        return view('adminDev.manajemen_klien');
    }

    public function tambahKlien ()
    {
        return view('adminDev.tambah_admin_klien');
    }

     public function storeAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'admin' => 'required|array|min:1',
            'admin.*.nip' => 'required|string|distinct|unique:users,nisn_nip',
            'admin.*.username' => 'required|string|distinct|unique:users,nisn_nip',

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
                    'nisn_nip' => $adminData['nip'],
                    'username' => $adminData['username'],
                    'role' => 'admin', // Otomatis mengatur role sebagai guru
                ]);
            }
        }

        return response()->json(['message' => 'Data semua guru berhasil disimpan!'], 200);
    }
}
