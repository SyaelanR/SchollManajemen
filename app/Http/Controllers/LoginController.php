<?php

namespace App\Http\Controllers;

use App\Models\Angkatan;
use App\Models\User;
use App\Models\Clien;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman form login.
     *
     * @return \Illuminate\View\View
     */

    public function dashboard(Request $request)
    {
        $username = $request->cookie('name');
        $time = Carbon::now()->isoFormat('dddd, D MMMM YYYY');
        // return view('admin.add_users'); //gunakan titik untuk masuk kedalam folder
        
        $role = $request->cookie('role');
        // dd($role);
        if ($role == 'adminDev'){
            $cliens = Clien::all();
            return view('dashboard', ['username' => $username, 'time' => $time, 'cliens' => $cliens]);
        }else if ($role == 'admin'){
            return view('dashboard', ['username' => $username, 'time' => $time]);
        }elseif ($role == 'guru'){
            $idUser = $request->cookie('id_user');

            $jadwalHariIni = Jadwal::where('hari', Carbon::now()->isoFormat('dddd'))
                ->with(['kelas.angkatan', 'mapel']) 
                ->whereHas('mapel', function ($query) use ($idUser) {
                    $query->where('id_guru', $idUser);
                })
                ->whereHas('kelas.angkatan', function ($query) {
                    $query->whereColumn('angkatans.semester', 'jadwals.semester');
                })
                ->whereHas('kelas.angkatan', function ($query) {
                    $query->whereColumn('angkatans.id_tingkat', 'jadwals.tingkat');
                })
                ->get();
                
            $jumlahSesi = $jadwalHariIni->count();
            return view('dashboard', ['username' => $username, 'time' => $time, 'jadwalHariIni' => $jadwalHariIni, 'jumlahSesi' => $jumlahSesi]);
        
        }elseif ($role == 'siswa'){
            $idKelas = $request->cookie('id_kelas');
            $idSekolah = $request->cookie('id_sekolah');


            $jadwalHariIni = Jadwal::where('hari', Carbon::now()->isoFormat('dddd'))
                ->where('id_kelas', $idKelas)
                ->where('id_sekolah', $idSekolah)
                ->with('mapel.guru')
                ->get();

            return view('dashboard', ['username' => $username, 'time' => $time, 'jadwalHariIni' => $jadwalHariIni]);
        }elseif ($role == 'staf'){
            return view('dashboard', ['username' => $username, 'time' => $time]);
        }else{
            return view('dashboard', ['username' => $username, 'time' => $time]);
        }
    }

    public function create()
    {
        // Mengarahkan ke view yang berisi form login
        return view('welcome');
    }

    /**
     * Menangani permintaan autentikasi yang masuk.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi data input dari form
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        // PERINGATAN KEAMANAN: Menggunakan enkripsi AES untuk password sangat tidak aman.
        // Sebaiknya gunakan Hashing (Bcrypt) yang merupakan standar industri.
 
        // Langkah 1: Mencari email dari tabel user.
        $user = User::where('username', $credentials['username'])->first();
 
        // Langkah 2, 3, & 4: Mengambil, mendekripsi, dan membandingkan password.
        // - $user->password secara otomatis mengambil dan mendekripsi password dari database
        //   karena ada 'password' => 'encrypted' pada Model User.
        // - Kemudian dibandingkan dengan password dari input form ($credentials['password']).
        if ($user && $credentials['password'] === $user->password) {
            // Langkah 5 (Sukses): Jika password sama, login dan redirect ke dashboard.
            // (Bagian ini menangani session dan redirect, sesuai standar Laravel)
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();

            // Membuat cookie dengan data pengguna
            $cookieLifetime = 60 * 24 * 30 * 12; // 1 tahun
            $response = redirect()->intended('dashboard');

            // Menambahkan cookie ke response
            $response->withCookie(cookie('name', $user->name, $cookieLifetime));
            $response->withCookie(cookie('username', $user->username, $cookieLifetime));
            $response->withCookie(cookie('nisn_nik', $user->nisn_nik, $cookieLifetime));
            $response->withCookie(cookie('role', $user->role, $cookieLifetime));
            $response->withCookie(cookie('mapel', $user->mapel, $cookieLifetime));
            $response->withCookie(cookie('id_kelas', $user->id_kelas, $cookieLifetime));
            $response->withCookie(cookie('angkatan', $user->id_angkatan, $cookieLifetime)); // Menggunakan id_angkatan sesuai migrasi
            $response->withCookie(cookie('id_sekolah', $user->id_sekolah, $cookieLifetime));
            $response->withCookie(cookie('id_user', $user->id, $cookieLifetime));
            $response->withCookie(cookie('id_angkatan', $user->id_angkatan, $cookieLifetime));
            


            return $response;
        }

        // Langkah 5 (Gagal): Jika user tidak ada atau password salah,
        // kembali ke halaman login dengan pesan error.
        throw ValidationException::withMessages([
            'username' => __('auth.failed'),
        ]);
    }

    /**
     * Menghancurkan sesi autentikasi (logout).
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}