<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * AuthController — menangani autentikasi terpadu untuk seluruh pengguna.
 *
 * Satu halaman login: /login
 * Setelah login, sistem memeriksa atribut `role` dan mengarahkan ke halaman yang sesuai:
 *   - masyarakat                            → pengajuan.saya
 *   - staff_desa, kasi_pemerintahan,
 *     sekretaris_desa, kepala_desa, admin   → admin.dashboard
 */
class AuthController extends Controller
{
    /**
     * Tampilkan halaman login terpadu untuk seluruh pengguna.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('pengajuan.saya');
        }

        return view('pages.auth.login');
    }

    /**
     * Proses autentikasi login — berlaku untuk masyarakat maupun perangkat desa/admin.
     * Percabangan dilakukan berdasarkan atribut `role` pada tabel users.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required'    => 'Alamat email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Perangkat desa & admin diarahkan ke dashboard backoffice
            if ($user->isAdmin()) {
                session(['admin_last_activity' => time()]);
                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'Selamat datang kembali, ' . $user->name . ' (' . $user->role_label . ')!');
            }

            // Masyarakat diarahkan ke halaman layanan mandiri
            return redirect()->intended(route('pengajuan.saya'))
                ->with('success', 'Selamat datang kembali, ' . $user->name . '!');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan tidak sesuai.',
        ])->onlyInput('email');
    }

    /**
     * Tampilkan halaman registrasi akun mandiri untuk masyarakat.
     */
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('pages.auth.register');
    }

    /**
     * Proses pendaftaran akun masyarakat baru.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required'      => 'Nama lengkap wajib diisi.',
            'email.required'     => 'Alamat email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email ini sudah terdaftar. Silakan masuk menggunakan email tersebut.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal harus 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        UserModel::create([
            'name'     => $validated['name'],
            'email'    => strtolower(trim($validated['email'])),
            'password' => Hash::make($validated['password']),
            'role'     => 'masyarakat',
        ]);

        return redirect()->route('login')
            ->with('success', 'Pendaftaran akun berhasil! Silakan masuk menggunakan email dan password yang telah Anda daftarkan.');
    }

    /**
     * Proses logout terpadu — berlaku untuk seluruh role pengguna.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda telah berhasil keluar.');
    }
}
