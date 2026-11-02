<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * AuthController — menangani autentikasi untuk Admin maupun Masyarakat.
 *
 * Admin  : /admin/login  → view admin.auth.login   → redirect admin.dashboard
 * Publik : /login        → view pages.auth.login   → redirect pengajuan.saya
 */
class AuthController extends Controller
{
    // ══════════════════════════════════════════════════════════════════
    //  LOGIN MASYARAKAT (publik)
    // ══════════════════════════════════════════════════════════════════

    /**
     * Tampilkan halaman login untuk masyarakat.
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
     * Proses autentikasi login masyarakat.
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

            if ($user->isAdmin()) {
                session(['admin_last_activity' => time()]);
                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'Selamat datang kembali, ' . $user->name . ' (Administrator)!');
            }

            return redirect()->intended(route('pengajuan.saya'))
                ->with('success', 'Selamat datang kembali, ' . $user->name . '!');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan tidak sesuai.',
        ])->onlyInput('email');
    }

    /**
     * Tampilkan halaman registrasi warga.
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

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => strtolower(trim($validated['email'])),
            'password' => Hash::make($validated['password']),
            'role'     => 'masyarakat',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('pengajuan.saya'))
            ->with('success', 'Pendaftaran akun berhasil! Anda kini dapat menggunakan seluruh layanan masyarakat Desa Jambelaer.');
    }

    /**
     * Proses logout masyarakat.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Anda telah berhasil keluar.');
    }

    // ══════════════════════════════════════════════════════════════════
    //  LOGIN ADMIN
    // ══════════════════════════════════════════════════════════════════

    /**
     * Tampilkan halaman login admin.
     */
    public function showAdminLoginForm()
    {
        if (Auth::check()) {
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('pengajuan.saya');
        }

        return view('admin.auth.login');
    }

    /**
     * Proses autentikasi login admin.
     */
    public function adminLogin(Request $request)
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

            if ($user->isAdmin()) {
                session(['admin_last_activity' => time()]);
                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'Selamat datang kembali, ' . $user->name . ' (' . $user->role_label . ')!');
            }

            // Bukan perangkat desa / admin — tolak akses dan logout
            Auth::logout();
            return back()->withErrors([
                'email' => 'Akun ini tidak memiliki hak akses sebagai Perangkat Desa atau Administrator.',
            ])->onlyInput('email');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Proses logout admin — kembali ke halaman login admin.
     */
    public function adminLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'Anda berhasil logout.');
    }
}
