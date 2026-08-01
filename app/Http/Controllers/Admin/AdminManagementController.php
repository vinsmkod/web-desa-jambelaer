<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
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

    /**
     * Menampilkan form edit data admin / reset password.
     */
    public function edit(User $admin)
    {
        return view('admin.kelola-admin.edit', compact('admin'));
    }

    /**
     * Memperbarui data admin atau mereset password.
     */
    public function update(Request $request, User $admin)
    {
        $rules = [
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($admin->id)],
        ];

        $messages = [
            'name.required'      => 'Nama admin wajib diisi.',
            'name.max'           => 'Nama admin maksimal 255 karakter.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email ini sudah digunakan oleh admin lain.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ];

        if ($request->filled('password')) {
            $rules['password'] = [
                'string',
                Password::min(8)->letters()->numbers(),
                'confirmed'
            ];
        }

        $request->validate($rules, $messages);

        $admin->name  = $request->name;
        $admin->email = $request->email;

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return redirect()->route('admin.kelola-admin.index')
            ->with('success', 'Data administrator (' . $admin->name . ') berhasil diperbarui!');
    }

    /**
     * Menghapus akun admin.
     */
    public function destroy(User $admin)
    {
        if ($admin->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.');
        }

        if (User::count() <= 1) {
            return back()->with('error', 'Sistem harus memiliki minimal 1 administrator aktif.');
        }

        $name = $admin->name;
        $admin->delete();

        return redirect()->route('admin.kelola-admin.index')
            ->with('success', 'Akun administrator "' . $name . '" berhasil dihapus.');
    }
}
