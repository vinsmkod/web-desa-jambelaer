<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AdminManagementController extends Controller
{
    /**
     * Menampilkan daftar pengguna (Perangkat Desa + Masyarakat) untuk Kelola Pengguna (SRS-F-014).
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $admins = UserModel::whereIn('role', UserModel::PERANGKAT_DESA_ROLES)
            ->when($search, function ($q) use ($search) {
                $q->where(function ($q2) use ($search) {
                    $q2->where('name', 'like', '%' . $search . '%')
                       ->orWhere('email', 'like', '%' . $search . '%')
                       ->orWhere('jabatan', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $masyarakat = UserModel::where('role', UserModel::ROLE_MASYARAKAT)
            ->when($search, function ($q) use ($search) {
                $q->where(function ($q2) use ($search) {
                    $q2->where('name', 'like', '%' . $search . '%')
                       ->orWhere('email', 'like', '%' . $search . '%')
                       ->orWhere('no_hp', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $activeTab = $request->input('tab', 'perangkat');

        return view('admin.kelola-admin.index', compact('admins', 'masyarakat', 'activeTab', 'search'));
    }

    /**
     * Menampilkan form pendaftaran perangkat desa baru.
     */
    public function create()
    {
        $roles = [
            UserModel::ROLE_STAFF_DESA        => 'Staff Desa',
            UserModel::ROLE_KASI_PEMERINTAHAN => 'Kasi Pemerintahan',
            UserModel::ROLE_SEKRETARIS_DESA   => 'Sekretaris Desa',
            UserModel::ROLE_KEPALA_DESA       => 'Kepala Desa',
        ];

        return view('admin.kelola-admin.create', compact('roles'));
    }

    /**
     * Mendaftarkan perangkat desa baru ke dalam tabel users dengan penetapan role yang sesuai.
     */
    public function store(Request $request)
    {
        $allowedRoles = [
            UserModel::ROLE_STAFF_DESA,
            UserModel::ROLE_KASI_PEMERINTAHAN,
            UserModel::ROLE_SEKRETARIS_DESA,
            UserModel::ROLE_KEPALA_DESA,
            UserModel::ROLE_ADMIN,
        ];

        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'role'     => ['required', 'string', Rule::in($allowedRoles)],
            'jabatan'  => ['nullable', 'string', 'max:100'],
            'password' => [
                'required',
                'string',
                Password::min(8)->letters()->numbers(),
                'confirmed'
            ],
        ], [
            'name.required'      => 'Nama perangkat desa wajib diisi.',
            'name.max'           => 'Nama maksimal 255 karakter.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email ini sudah terdaftar dalam sistem.',
            'role.required'      => 'Kewenangan / Role perangkat desa wajib dipilih.',
            'role.in'            => 'Pilihan kewenangan role tidak valid.',
            'password.required'  => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok. Pastikan isian kedua kolom password sama.',
        ]);

        UserModel::create([
            'name'     => $request->name,
            'email'    => strtolower(trim($request->email)),
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'jabatan'  => $request->jabatan,
        ]);

        return redirect()->route('admin.kelola-admin.index')
            ->with('success', 'Akun perangkat desa baru berhasil didaftarkan!');
    }

    /**
     * Menampilkan form edit data akun perangkat desa / reset password.
     */
    public function edit(UserModel $admin)
    {
        $roles = [
            UserModel::ROLE_STAFF_DESA        => 'Staff Desa',
            UserModel::ROLE_KASI_PEMERINTAHAN => 'Kasi Pemerintahan',
            UserModel::ROLE_SEKRETARIS_DESA   => 'Sekretaris Desa',
            UserModel::ROLE_KEPALA_DESA       => 'Kepala Desa',
            UserModel::ROLE_ADMIN             => 'Administrator Sistem',
        ];

        return view('admin.kelola-admin.edit', compact('admin', 'roles'));
    }

    /**
     * Memperbarui data perangkat desa atau mereset password.
     */
    public function update(Request $request, UserModel $admin)
    {
        $allowedRoles = [
            UserModel::ROLE_STAFF_DESA,
            UserModel::ROLE_KASI_PEMERINTAHAN,
            UserModel::ROLE_SEKRETARIS_DESA,
            UserModel::ROLE_KEPALA_DESA,
            UserModel::ROLE_ADMIN,
        ];

        $rules = [
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($admin->user_id, 'user_id')],
            'role'    => ['required', 'string', Rule::in($allowedRoles)],
            'jabatan' => ['nullable', 'string', 'max:100'],
        ];

        $messages = [
            'name.required'      => 'Nama perangkat desa wajib diisi.',
            'name.max'           => 'Nama maksimal 255 karakter.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email ini sudah digunakan oleh akun lain.',
            'role.required'      => 'Kewenangan / Role perangkat desa wajib dipilih.',
            'role.in'            => 'Pilihan kewenangan role tidak valid.',
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

        $admin->name    = $request->name;
        $admin->email   = strtolower(trim($request->email));
        $admin->role    = $request->role;
        $admin->jabatan = $request->jabatan;

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return redirect()->route('admin.kelola-admin.index')
            ->with('success', 'Data akun perangkat desa (' . $admin->name . ') berhasil diperbarui!');
    }

    /**
     * Menghapus akun pengguna (Perangkat Desa maupun Masyarakat).
     */
    public function destroy(UserModel $admin)
    {
        if ($admin->user_id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.');
        }

        // Jika akun yang dihapus adalah perangkat desa, pastikan minimal 1 akun tersisa
        if ($admin->isPerangkatDesa()) {
            if (UserModel::whereIn('role', UserModel::PERANGKAT_DESA_ROLES)->count() <= 1) {
                return back()->with('error', 'Sistem harus memiliki minimal 1 akun perangkat desa aktif.');
            }
        }

        $name = $admin->name;
        $tab  = $admin->isPerangkatDesa() ? 'perangkat' : 'masyarakat';
        $admin->delete();

        return redirect()->route('admin.kelola-admin.index', ['tab' => $tab])
            ->with('success', 'Akun "' . $name . '" berhasil dihapus.');
    }
}
