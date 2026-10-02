<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginForm()
    {
        if (Auth::check()) {
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('pengajuan.saya');
        }
        return view('admin.auth.login');
    }

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
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login')
            ->with('success', 'Anda berhasil logout.');
    }
}
