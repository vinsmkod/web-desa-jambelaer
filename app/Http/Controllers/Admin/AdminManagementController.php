<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminManagementController extends Controller
{
    /**
     * Menampilkan daftar admin terdaftar dan form registrasi admin baru.
     */
    public function index()
    {
        $admins = User::orderBy('created_at', 'desc')->get();
        return view('admin.kelola-admin.index', compact('admins'));
    }

    /**
     * Menampilkan form pendaftaran admin baru.
     */
    public function create()
    {
        return view('admin.kelola-admin.create');
    }

    /**
     * Mendaftarkan admin baru ke dalam tabel users.
     * Menggunakan validasi ketat untuk mencegah registrasi jika password tidak cocok atau tidak memenuhi kriteria.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => [
                'required',
                'string',
                Password::min(8)->letters()->numbers(),
                'confirmed'
            ],
        ], [
            'name.required'      => 'Nama admin wajib diisi.',
            'name.max'           => 'Nama admin maksimal 255 karakter.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email ini sudah terdaftar dalam sistem.',
            'password.required'  => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok. Pastikan isian kedua kolom password sama.',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.kelola-admin.index')
            ->with('success', 'Admin baru berhasil didaftarkan!');
    }
}
