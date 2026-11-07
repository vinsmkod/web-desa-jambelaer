<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilMasyarakatController extends Controller
{
    /**
     * Tampilkan halaman formulir profil masyarakat yang sedang login.
     */
    public function edit()
    {
        /** @var \App\Models\UserModel $user */
        $user = Auth::user();

        // Fitur ini hanya berlaku untuk pengguna dengan role masyarakat
        if (!$user->isMasyarakat()) {
            abort(403, 'Akses ditolak. Fitur kelola profil ini hanya diperuntukkan bagi warga/masyarakat.');
        }

        return view('pages.profil.edit', compact('user'));
    }

    /**
     * Perbarui informasi profil akun milik masyarakat yang sedang login.
     * Hanya kolom name, no_hp, dan alamat yang dapat diubah.
     */
    public function update(Request $request)
    {
        /** @var \App\Models\UserModel $user */
        $user = Auth::user();

        // Fitur ini hanya berlaku untuk pengguna dengan role masyarakat
        if (!$user->isMasyarakat()) {
            abort(403, 'Akses ditolak. Fitur kelola profil ini hanya diperuntukkan bagi warga/masyarakat.');
        }

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'no_hp' => [
                'required',
                'string',
                'max:20',
                'regex:/^[0-9\+\-\s\(\)]{8,20}$/',
            ],
            'alamat' => [
                'required',
                'string',
                'max:500',
            ],
        ], [
            'name.required'   => 'Nama lengkap wajib diisi.',
            'name.min'        => 'Nama lengkap minimal 3 karakter.',
            'name.max'        => 'Nama lengkap maksimal 255 karakter.',
            'no_hp.required'  => 'Nomor telepon wajib diisi.',
            'no_hp.regex'     => 'Format nomor telepon tidak valid. Masukkan format nomor telepon yang valid.',
            'no_hp.max'       => 'Nomor telepon maksimal 20 karakter.',
            'alamat.required' => 'Alamat lengkap wajib diisi.',
            'alamat.max'      => 'Alamat lengkap maksimal 500 karakter.',
        ]);

        // Simpan perubahan langsung ke tabel users menggunakan akun yang sedang login
        // Pembaruan atribut secara eksplisit untuk mencegah mass-assignment terhadap kolom sensitif
        $user->update([
            'name'   => trim($validated['name']),
            'no_hp'  => trim($validated['no_hp']),
            'alamat' => trim($validated['alamat']),
        ]);

        return redirect()->route('profil.edit')
            ->with('success', 'Profil akun Anda berhasil diperbarui.');
    }
}

