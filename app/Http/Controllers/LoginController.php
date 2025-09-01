<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman form login.
     *
     * @return \Illuminate\View\View
     */
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
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // PERINGATAN KEAMANAN: Menggunakan enkripsi AES untuk password sangat tidak aman.
        // Sebaiknya gunakan Hashing (Bcrypt) yang merupakan standar industri.
 
        // Langkah 1: Mencari email dari tabel user.
        $user = User::where('email', $credentials['email'])->first();
 
        // Langkah 2, 3, & 4: Mengambil, mendekripsi, dan membandingkan password.
        // - `$user->password` secara otomatis mengambil dan mendekripsi password dari database
        //   karena ada `'password' => 'encrypted'` pada Model User.
        // - Kemudian dibandingkan dengan password dari input form (`$credentials['password']`).
        if ($user && $credentials['password'] === $user->password) {
            // Langkah 5 (Sukses): Jika password sama, login dan redirect ke dashboard.
            // (Bagian ini menangani session dan redirect, sesuai standar Laravel)
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }
 
        // Langkah 5 (Gagal): Jika user tidak ada atau password salah,
        // kembali ke halaman login dengan pesan error.
        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
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
