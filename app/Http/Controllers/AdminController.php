<?php

namespace App\Http\Controllers;

use App\Models\RiwayatKeuangan;
use App\Models\User; // Menggunakan model User untuk Siswa dan Guru
use App\Models\Angkatan;
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

class AdminController extends Controller
{
    // ... (konstruktor atau middleware jika ada) ...

    /**
     * Menampilkan halaman manajemen siswa.
     * Sudah ada di kode Anda.
     */
    public function manajSiswa(Request $request)
    {
        $id_sekolah = $request->cookie('id_sekolah');
        $search = $request->query('search'); // Tambahkan variabel search jika ada fitur pencarian

        $students = User::where('users.role', 'siswa')
                        ->where('users.id_sekolah', $id_sekolah)
                        ->leftJoin('kelas', 'users.id_kelas', '=', 'kelas.id_kelas')
                        ->select('users.*', 'kelas.nama_kelas')
                        ->when($search, function ($query, $search) { // Tambahkan fitur pencarian
                            return $query->where('users.name', 'like', '%' . $search . '%')
                                         ->orWhere('users.nisn_nik', 'like', '%' . $search . '%')
                                         ->orWhere('kelas.nama_kelas', 'like', '%' . $search . '%');
                        })
                        ->latest('users.created_at')
                        ->paginate(10);

        return view('admin.manajemen_siswa', ['students' => $students]);
    }

    /**
     * Menampilkan form untuk menambah siswa baru.
     * Sudah ada di kode Anda.
     */
    public function tambahSiswa()
    {
        // Jika form tambah siswa juga butuh daftar kelas, Anda bisa menambahkan ini:
        // $kelases = Kelas::where('id_sekolah', request()->cookie('id_sekolah'))->get();
        // return view('admin.tambah_siswa', compact('kelases'));
        return view('admin.tambah_siswa');
    }

    /**
     * Menampilkan form untuk mengedit data siswa tertentu.
     * PASTE KODE INI
     */
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

    /**
     * Memperbarui data siswa di database.
     * PASTE KODE INI
     */
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

    /**
     * Hapus data siswa.
     * Tambahkan method ini jika belum ada
     */
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

    // --- MANAJEMEN GURU & STAF ---
    /**
     * Tampilkan daftar guru & staf.
     * Sudah ada di kode Anda.
     */
    public function manajGuru(Request $request)
    {
        $id_sekolah = $request->cookie('id_sekolah');

        $teachers = User::whereIn('role', ['guru', 'staf'])
            ->where('id_sekolah', $id_sekolah)
            ->latest()
            ->paginate(10);

        return view('admin.manajemen_guru', ['teachers' => $teachers]);
    }

    /**
     * Form tambah guru / staf.
     * Sudah ada di kode Anda.
     */
    public function tambahGuru()
    {
        return view('admin.tambah_guru');
    }

    /**
     * Edit guru / staf.
     * Sudah ada di kode Anda.
     * Sesuaikan view path menjadi 'admin.edit_guru' jika itu lokasi yang benar.
     */
    public function editGuru($id)
    {
        $id_sekolah = request()->cookie('id_sekolah');
        $teacher = User::where('id', $id)
                        ->where('id_sekolah', $id_sekolah) // Tambahkan filter id_sekolah
                        ->whereIn('role', ['guru', 'staf'])->firstOrFail();
        return view('guru.edit_guru', compact('teacher')); // Sesuaikan path view
    }


    /**
     * Simpan data siswa baru (bisa banyak sekaligus).
     * Sudah ada di kode Anda.
     * Pastikan model `User` memiliki kolom-kolom ini di `$fillable` array.
     */
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
            'students.*.parent_salary' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        foreach ($request->input('students', []) as $studentData) {
            if (isset($studentData['nama'], $studentData['nisn'], $studentData['username'], $studentData['gender'], $studentData['password'])) {
                User::create([
                    'name' => $studentData['nama'],
                    'email' => $studentData['username'] . '@sekolah.sch.id',
                    'password' => Hash::make($studentData['password']), // Pastikan mengenkripsi password
                    'nisn_nik' => $studentData['nisn'],
                    'jenis_kelamin' => $studentData['gender'],
                    'username' => $studentData['username'],
                    'role' => 'siswa',
                    'id_sekolah' => $id_sekolah,
                    'alamat' => $studentData['address'] ?? null, // Gunakan null coalescing operator
                    'tempat_lahir' => $studentData['birthplace'] ?? null,
                    'tanggal_lahir' => $studentData['dob'] ?? null,
                    'tanggal_masuk' => $studentData['entry_date'] ?? null,
                    'nama_orang_tua' => $studentData['parent_name'] ?? null,
                    'no_telp' => $studentData['parent_phone'] ?? null,
                    'jumlah_sodara' => $studentData['siblings_count'] ?? null,
                    'gaji_orang_tua' => $studentData['parent_salary'] ?? null,
                ]);
            }
        }

        return response()->json(['message' => 'Data semua siswa berhasil disimpan!'], 200);
    }

    /**
     * Simpan data guru / staf baru (bisa banyak sekaligus).
     * Sudah ada di kode Anda.
     */
    public function storeGuru(Request $request)
    {
        $id_sekolah = $request->cookie('id_sekolah');

        $validator = Validator::make($request->all(), [
            'teacher' => 'required|array|min:1',
            'teacher.*.nik' => 'required|string|distinct|unique:users,nisn_nik',
            'teacher.*.username' => 'required|string|distinct|unique:users,username',
            'teacher.*.nama' => 'required|string|max:255',
            'teacher.*.password' => 'required|string|min:6',
            'teacher.*.alamat' => 'nullable|string|max:255',
            'teacher.*.tempat_lahir' => 'nullable|string|max:100',
            'teacher.*.tanggal_lahir' => 'nullable|date',
            'teacher.*.usia' => 'nullable|integer',
            'teacher.*.nomor_telp' => 'nullable|string|max:15',
            'teacher.*.jabatan' => 'required|string|in:guru,staf',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        foreach ($request->input('teacher', []) as $teacherData) {
            if (
                isset(
                    $teacherData['nama'],
                    $teacherData['nik'],
                    $teacherData['password'],
                    $teacherData['username']
                )
            ) {
                User::create([
                    'name' => $teacherData['nama'],
                    'email' => $teacherData['username'] . '@sekolah.sch.id',
                    'password' => bcrypt($teacherData['password']),
                    'nisn_nik' => $teacherData['nik'],
                    'username' => $teacherData['username'],
                    'role' => $teacherData['jabatan'],
                    'id_sekolah' => $id_sekolah,
                    'alamat' => $teacherData['alamat'] ?? null,
                    'tempat_lahir' => $teacherData['tempat_lahir'] ?? null,
                    'tanggal_lahir' => $teacherData['tanggal_lahir'] ?? null,
                    'usia' => $teacherData['usia'] ?? null,
                    'no_telp' => $teacherData['nomor_telp'] ?? null,
                ]);
            }
        }

        return response()->json(['message' => 'Data semua staf/guru berhasil disimpan!'], 200);
    }

    /**
     * Perbarui data guru / staf.
     * Sudah ada di kode Anda.
     */
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

    /**
     * Hapus data guru / staf.
     * Sudah ada di kode Anda.
     */
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


    // --- MANAJEMEN ANGKATAN ---
    public function manajAngkatan(Request $request)
    {
        $id_sekolah = $request->cookie('id_sekolah');
        $angkatans = Angkatan::where('id_sekolah', $id_sekolah)->latest()->get();
        $tingkats = Tingkat::where('id_sekolah', $id_sekolah)->get();
        return view('admin.manajemen_angkatan', ['angkatans' => $angkatans, 'tingkats' => $tingkats]);
    }

    public function storeAngkatan(Request $request)
    {
        $id_sekolah = $request->cookie('id_sekolah');

        $request->validate([
            'angkatan' => 'required|string|max:255|unique:angkatans,angkatan',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'id_tingkat' => 'required|exists:tingkats,id_tingkat', // Pastikan tingkat valid
            'semester' => 'required|in:Ganjil,Genap', // Tambahkan validasi untuk semester
        ], [
            'angkatan.required' => 'Tahun ajaran tidak boleh kosong.',
            'angkatan.unique' => 'Tahun ajaran ini sudah ada.',
            'tanggal_mulai.required' => 'Tanggal mulai tidak boleh kosong.',
            'tanggal_selesai.required' => 'Tanggal selesai tidak boleh kosong.',
            'id_tingkat.required' => 'Tingkat tidak boleh kosong.',
            'id_tingkat.exists' => 'Tingkat tidak valid.',
            'semester.required' => 'Semester tidak boleh kosong.',
            'semester.in' => 'Semester tidak valid.',
        ]);

        Angkatan::create([
            'angkatan' => $request->angkatan,
            'id_sekolah' => $id_sekolah,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'id_tingkat' => $request->id_tingkat,
            'tingkat' => Tingkat::where('id_tingkat', $request->id_tingkat)->value('tingkat'),
            'semester' => $request->semester, // Tambahkan ini
        ]);

        return redirect()->route('manajemenAngkatan')->with('success', 'Angkatan berhasil ditambahkan!');
    }

    public function updateAngkatan(Request $request, $id)
    {
        $id_sekolah = $request->cookie('id_sekolah');

        $request->validate([
            'angkatan' => 'required|string|max:255|unique:angkatans,angkatan,' . $id . ',id_angkatan,id_sekolah,' . $id_sekolah, // Tambahkan id_sekolah ke unique rule
            'id_tingkat' => 'required|integer|exists:tingkats,id_tingkat',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'semester' => 'required|in:Ganjil,Genap', // Tambahkan validasi untuk semester
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

    public function destroyAngkatan(Request $request, $id)
    {
        $id_sekolah = $request->cookie('id_sekolah');

        $angkatan = Angkatan::where('id_angkatan', $id)
                            ->where('id_sekolah', $id_sekolah)
                            ->firstOrFail();

        $angkatan->delete();

        return redirect()->route('manajemenAngkatan')->with('success', 'Angkatan berhasil dihapus!');
    }

    // --- MANAJEMEN KELAS ---
    public function manajKelas()
    {
        $id_sekolah = request()->cookie('id_sekolah');

        $angkatans = Angkatan::where('id_sekolah', $id_sekolah)->latest()->get();
        $kelasList = Kelas::latest()->where('id_sekolah', $id_sekolah)->get();

        return view('admin.manajemen_kelas', ['angkatans' => $angkatans, 'kelasList' => $kelasList]);
    }

    public function storeKelas(Request $request)
    {
        $id_sekolah = $request->cookie('id_sekolah');

        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'id_angkatan' => 'required|integer|exists:angkatans,id_angkatan', // Validasi angkatan
            'wali_kelas' => 'required|string|max:255', // Ini harusnya ID Guru
            'id_guru_wali' => 'nullable|exists:users,id', // Tambah ini untuk ID guru yang sebenarnya
            'jurusan' => 'nullable|string|max:20'
        ], [
            'nama_kelas.required' => 'Nama kelas tidak boleh kosong.',
            'id_angkatan.required' => 'Tahun ajaran tidak boleh kosong, buat angkatan terlebih dahulu',
            'id_angkatan.exists' => 'Tahun ajaran tidak valid.',
            'wali_kelas.required' => 'Wali kelas tidak boleh kosong.',
            'jurusan.max' => 'Jurusan maksimal 20 karakter.',
            'id_guru_wali.exists' => 'Guru wali tidak valid.',
        ]);

        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'id_angkatan' => $request->id_angkatan,
            'id_sekolah' => $id_sekolah,
            'wali_kelas' => $request->wali_kelas, // Ini nama guru, pastikan konsisten
            'id_guru_wali' => $request->id_guru_wali, // ID guru
            'jurusan' => $request->jurusan,
        ]);

        return redirect()->route('manajemenKelas')->with('success', 'Kelas berhasil ditambahkan!');
    }

    // Tambahkan method editKelas dan updateKelas di sini jika Anda ingin mengedit kelas
    // public function editKelas(Kelas $kelas) { ... }
    // public function updateKelas(Request $request, Kelas $kelas) { ... }


    public function lihatKelas(Request $request)
    {
        $id_sekolah = $request->cookie('id_sekolah');
        $id_kelas = $request->input('id_kelas');

        $infoKelas = Kelas::where('id_kelas', $id_kelas)
                          ->where('id_sekolah', $id_sekolah)
                          ->with('angkatan')
                          ->firstOrFail(); // Gunakan firstOrFail

        $daftarSiswa = User::where('id_kelas', $id_kelas)
                           ->where('id_sekolah', $id_sekolah)
                           ->where('role', 'siswa') // Pastikan hanya siswa
                           ->get();
        $daftarSiswaBelumPunyaKelas = User::where('id_kelas', null)
                                         ->where('id_sekolah', $id_sekolah)
                                         ->where('role', 'siswa')
                                         ->get();
        $jumlahSiswa = $daftarSiswa->count();

        return view('admin.lihat_kelas', compact('id_kelas', 'infoKelas', 'daftarSiswa', 'daftarSiswaBelumPunyaKelas', 'jumlahSiswa'));
    }

    public function lihatKelasD()
    {
        return view('admin.lihat_kelas'); // Ini mungkin tidak perlu atau bisa disatukan dengan lihatKelas
    }

    public function tambahSiswaKeKelas(Request $request)
    {
        $request->validate([
            'id_kelas' => 'required|integer|exists:kelas,id_kelas',
            'siswa_ids' => 'required|array|min:1',
            'siswa_ids.*' => 'integer|exists:users,id',
        ], [
            'id_kelas.required' => 'ID Kelas tidak valid.',
            'siswa_ids.required' => 'Anda harus memilih setidaknya satu siswa.',
        ]);

        $id_kelas = $request->input('id_kelas');
        $siswa_ids = $request->input('siswa_ids');
        $id_sekolah = $request->cookie('id_sekolah');

        // Pastikan siswa yang ditambahkan berasal dari sekolah yang sama
        User::whereIn('id', $siswa_ids)
            ->where('id_sekolah', $id_sekolah)
            ->update(['id_kelas' => $id_kelas]);

        return redirect()->route('manajemenKelas')->with('success', 'Siswa berhasil ditambahkan ke kelas!');
    }

    // --- MANAJEMEN KEUANGAN ---
    public function manajKeuangan()
    {
        $id_sekolah = request()->cookie('id_sekolah');

        $transaksi = RiwayatKeuangan::where('id_sekolah', $id_sekolah)
            ->orderBy('tanggal', 'asc')
            ->get();

        $totalPemasukan = RiwayatKeuangan::where('id_sekolah', $id_sekolah)->where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = RiwayatKeuangan::where('id_sekolah', $id_sekolah)->where('jenis', 'pengeluaran')->sum('jumlah');

        $saldo = $transaksi->last()->saldo ?? 0;

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

        $lastTransaction = RiwayatKeuangan::where('id_sekolah', $id_sekolah)->orderBy('tanggal', 'desc')->first();
        $lastSaldo = $lastTransaction ? $lastTransaction->saldo : 0;

        $newSaldo = $lastSaldo + $request->jumlah;

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

        $lastTransaction = RiwayatKeuangan::where('id_sekolah', $id_sekolah)->orderBy('tanggal', 'desc')->first();
        $lastSaldo = $lastTransaction ? $lastTransaction->saldo : 0;

        $newSaldo = $lastSaldo - $request->jumlah;

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
            'target_angkatan' => 'required|exists:angkatans,id_angkatan,id_sekolah,' . $id_sekolah, // Pastikan angkatan ada di sekolah ini
        ], [
            'jumlah_tagihan.required' => 'Jumlah tagihan tidak boleh kosong.',
            'jumlah_tagihan.numeric' => 'Jumlah tagihan harus berupa angka.',
            'jumlah_tagihan.min' => 'Jumlah tagihan harus lebih besar dari 0.',
            'jatuh_tempo.required' => 'Jatuh tempo tidak boleh kosong.',
            'jatuh_tempo.date' => 'Jatuh tempo harus berupa tanggal yang valid.',
            'keterangan.max' => 'Keterangan maksimal 255 karakter.',
            'target_angkatan.required' => 'Target angkatan tidak boleh kosong.',
            'target_angkatan.exists' => 'Target angkatan tidak valid.',
        ]);

        $daftarTagihan = DaftarTagihan::create([
            'id_sekolah' => $id_sekolah,
            'jumlah_tagihan' => $request->jumlah_tagihan,
            'jatuh_tempo' => $request->jatuh_tempo,
            'keterangan' => $request->keterangan,
            'target_angkatan' => $request->target_angkatan,
            'nama_angkatan' => Angkatan::where('id_angkatan', $request->target_angkatan)->where('id_sekolah', $id_sekolah)->value('angkatan'),
        ]);

        $targetSiswa = User::where('id_angkatan', $request->target_angkatan)
                            ->where('id_sekolah', $id_sekolah)
                            ->where('role', 'siswa') // Hanya untuk siswa
                            ->get();

        foreach ($targetSiswa as $siswa) {
            PmabayaranSiswa::create([
                'id_siswa' => $siswa->id,
                'id_sekolah' => $id_sekolah,
                'id_daftar_tagihan' => $daftarTagihan->id_daftar_tagihan,
                'jumlah_tagihan' => $request->jumlah_tagihan,
                'status_pembayaran' => 'belum lunas',
            ]);
        }

        return redirect()->route('tagihanSiswa')->with('success', 'Tagihan berhasil ditambahkan!');
    }


    public function pembayaranTagihansiswa(Request $request)
    {
        $id_daftar_tagihan = $request->input('id_daftar_tagihan');
        $id_sekolah = request()->cookie('id_sekolah');

        $belumMembayar = User::join('pmabayaran_siswas', 'users.id', '=', 'pmabayaran_siswas.id_siswa')
            ->where('pmabayaran_siswas.id_sekolah', $id_sekolah)
            ->where('pmabayaran_siswas.id_daftar_tagihan', $id_daftar_tagihan)
            ->where('pmabayaran_siswas.status_pembayaran', 'belum lunas')
            ->select('users.name', 'users.nisn_nik', 'users.id as user_id') // Tambahkan user_id
            ->get();

        $sudahMembayar = User::join('pmabayaran_siswas', 'users.id', '=', 'pmabayaran_siswas.id_siswa')
            ->where('pmabayaran_siswas.id_sekolah', $id_sekolah)
            ->where('pmabayaran_siswas.id_daftar_tagihan', $id_daftar_tagihan)
            ->where('pmabayaran_siswas.status_pembayaran', 'lunas')
            ->select('users.name', 'users.nisn_nik', 'pmabayaran_siswas.updated_at')
            ->get();

        return view('admin.pembayaran_tagihan', compact('sudahMembayar', 'belumMembayar', 'id_daftar_tagihan')); // Kirim id_daftar_tagihan
    }

    public function konfirmasiPembayaran(Request $request)
    {
        $request->validate([
            'id_siswa' => 'required|exists:users,id',
            'id_daftar_tagihan' => 'required|exists:daftar_tagihans,id_daftar_tagihan',
        ]);

        $id_sekolah = $request->cookie('id_sekolah');

        PmabayaranSiswa::where('id_siswa', $request->id_siswa)
                       ->where('id_daftar_tagihan', $request->id_daftar_tagihan)
                       ->where('id_sekolah', $id_sekolah)
                       ->update([
                           'status_pembayaran' => 'lunas',
                           'tanggal_pembayaran' => Carbon::now(), // Catat tanggal pembayaran
                       ]);

        return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }


    // --- MANAJEMEN MATA PELAJARAN ---
    public function manajMapel()
    {
        $id_sekolah = request()->cookie('id_sekolah');
        $mapels = Mapel::where('id_sekolah', $id_sekolah)->latest()->get();
        $teachers = User::where('role', 'guru')->where('id_sekolah', $id_sekolah)->get();
        
        return view('admin.manajemen_mapel', compact('mapels', 'teachers'));
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

    // Tambahkan method editMapel dan updateMapel di sini
    // public function editMapel(Mapel $mapel) { ... }
    // public function updateMapel(Request $request, Mapel $mapel) { ... }


    // --- MANAJEMEN JADWAL ---
    public function manajJadwal(){
        $id_sekolah = request()->cookie('id_sekolah');

        $kelaslist = Kelas::where('id_sekolah', $id_sekolah)->get();
        return view('admin.manajemen_jadwal', compact('kelaslist'));
    }

    public function tambahJadwal(Request $request ,int $id_kelas){
        $id_sekolah = $request->cookie('id_sekolah');

        $kelas = Kelas::with('angkatan')
                      ->where('id_kelas', $id_kelas)
                      ->where('id_sekolah', $id_sekolah)
                      ->firstOrFail();

        $semesterAktif = $kelas->angkatan->semester ?? null;
        $tingkatAktif = $kelas->angkatan->tingkat ?? null;

        $mapels = Mapel::where('id_sekolah', $id_sekolah)->get();

        $jadwals = Jadwal::with('mapel.guru') // Memuat relasi mapel, dan relasi guru di dalam mapel
                        ->where('id_kelas', $id_kelas)
                        ->where('id_sekolah', $id_sekolah)
                        ->when($semesterAktif, function ($query) use ($semesterAktif) {
                            return $query->where('semester', $semesterAktif);
                        })
                        ->when($tingkatAktif, function ($query) use ($tingkatAktif) {
                            return $query->where('tingkat', $tingkatAktif);
                        })
                        ->orderBy('hari')
                        ->orderBy('jam_mulai')
                        ->get();

        return view('admin.tambah_jadwal', compact('kelas', 'jadwals', 'mapels'));
    }

    public function storeJadwal(Request $request, int $id_kelas)
    {
        $id_sekolah = $request->cookie('id_sekolah');
        $request->validate([
            'hari' => 'required|string|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai', // jam_selesai harus setelah jam_mulai
            'id_mapel' => 'required|exists:mapels,id_mapel',
            'ruangan' => 'required|string|max:100',
        ], [
            'hari.required' => 'Hari tidak boleh kosong.',
            'hari.in' => 'Hari tidak valid.',
            'jam_mulai.required' => 'Jam mulai tidak boleh kosong.',
            'jam_mulai.date_format' => 'Format jam mulai tidak valid. Gunakan format HH:MM.',
            'jam_selesai.required' => 'Jam selesai tidak boleh kosong.',
            'jam_selesai.date_format' => 'Format jam selesai tidak valid. Gunakan format HH:MM.',
            'jam_selesai.after' => 'Jam selesai harus setelah jam mulai.',
            'id_mapel.required' => 'Mata pelajaran tidak boleh kosong.',
            'id_mapel.exists' => 'Mata pelajaran tidak valid.',
            'ruangan.max' => 'Ruangan maksimal 100 karakter.',
            'ruangan.required' => 'Ruangan tidak boleh kosong.',
        ]);

        $kelas = Kelas::with('angkatan')
                      ->where('id_kelas', $id_kelas)
                      ->where('id_sekolah', $id_sekolah)
                      ->firstOrFail();

        Jadwal::create([
            'id_sekolah' => $id_sekolah,
            'id_kelas' => $id_kelas,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'id_mapel' => $request->id_mapel,
            'semester' => $kelas->angkatan->semester ?? null,
            'tingkat' => $kelas->angkatan->tingkat ?? null,
            'ruangan' => $request->ruangan,
        ]);
        return redirect()->route('tambahJadwal', ['id_kelas' => $id_kelas])->with('success', 'Jadwal berhasil ditambahkan!');
    }

    // --- MANAJEMEN TINGKAT ---
    public function manajTingkat()
    {
        $id_sekolah = request()->cookie('id_sekolah');
        $tingkats = Tingkat::where('id_sekolah', $id_sekolah)->orderBy('tingkat')->get();
        return view('admin.manajemen_tingkat', compact('tingkats'));
    }

    public function storeTingkat(Request $request)
    {
        $id_sekolah = $request->cookie('id_sekolah');
        
        if (!$id_sekolah) {
            return redirect()->back()->with('error', 'Gagal menambahkan tingkat. Sesi sekolah tidak ditemukan.');
        }
        
        $jumlahTingkat = Tingkat::where('id_sekolah', $id_sekolah)->count() ?? 0;

        // Cek apakah tingkat dengan nomor berikutnya sudah ada
        $nextTingkatNumber = $jumlahTingkat + 1;
        $existingTingkat = Tingkat::where('id_sekolah', $id_sekolah)
                                  ->where('tingkat', $nextTingkatNumber)
                                  ->exists();

        if ($existingTingkat) {
            return redirect()->back()->with('error', 'Tingkat ' . $nextTingkatNumber . ' sudah ada.');
        }

        Tingkat::create([
            'id_sekolah' => $id_sekolah,
            'tingkat' => $nextTingkatNumber,
        ]);

        return redirect()->route('manajemenTingkat')->with('success', 'Tingkat berhasil ditambahkan!');
    }

    // Tambahkan method hapusTingkat
    public function hapusTingkat(Request $request, $id_tingkat)
    {
        $id_sekolah = $request->cookie('id_sekolah');

        $tingkat = Tingkat::where('id_tingkat', $id_tingkat)
                          ->where('id_sekolah', $id_sekolah)
                          ->firstOrFail();

        // Cek apakah ada angkatan yang masih menggunakan tingkat ini
        $angkatanTerkait = Angkatan::where('id_tingkat', $id_tingkat)
                                    ->where('id_sekolah', $id_sekolah)
                                    ->exists();
        if ($angkatanTerkait) {
            return redirect()->back()->with('error', 'Tidak bisa menghapus tingkat ini karena masih ada angkatan yang terkait.');
        }

        $tingkat->delete();
        return redirect()->route('manajemenTingkat')->with('success', 'Tingkat berhasil dihapus!');
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

    /**
     * Memperbarui data kelas yang ada di database.
     */
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
    
    /**
     * Menghapus data kelas dari database.
     */
    public function destroyKelas(Request $request, $id_kelas) // Should be destroy() for KelasController
    {
        $id_sekolah = $request->cookie('id_sekolah');
        $kelas = Kelas::where('id_kelas', $id_kelas)->where('id_sekolah', $id_sekolah)->firstOrFail();
        $kelas->delete();

        return redirect()->route('manajemenKelas')->with('success', 'Data kelas berhasil dihapus!'); // PERBAIKAN: Menggunakan nama route yang benar
    }
    
}