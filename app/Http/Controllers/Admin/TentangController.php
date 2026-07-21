<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use App\Models\StrukturDesa;
use Illuminate\Http\Request;

class TentangController extends Controller
{
    // ── Tentang Kami (Settings) ───────────────────────────────────────────────

    public function index()
    {
        $settings = Pengaturan::where('group', 'tentang')->get()->keyBy('key');
        $strukturList = StrukturDesa::orderBy('urutan')->orderBy('id')->get();
        return view('admin.tentang.index', compact('settings', 'strukturList'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'kades_foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $inputs = $request->except(['_token', '_method', 'kades_foto']);

        // Keys yang boleh disimpan dari halaman ini (group tentang + stat_luas dari group statistik)
        $allowedExtras = ['stat_luas'];

        foreach ($inputs as $key => $value) {
            if (Pengaturan::where('key', $key)->where('group', 'tentang')->exists()) {
                Pengaturan::set($key, $value);
            } elseif (in_array($key, $allowedExtras) && Pengaturan::where('key', $key)->exists()) {
                Pengaturan::set($key, $value);
            }
        }

        if ($request->hasFile('kades_foto')) {
            $oldFoto = Pengaturan::get('kades_foto');
            if ($oldFoto && file_exists(public_path($oldFoto))) {
                @unlink(public_path($oldFoto));
            }
            $file = $request->file('kades_foto');
            $filename = 'kades_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/tentang'), $filename);
            Pengaturan::set('kades_foto', '/uploads/tentang/' . $filename);
        }

        return back()->with('success', 'Konten Tentang Kami berhasil diperbarui!');
    }

    // ── Struktur Desa ─────────────────────────────────────────────────────────

    public function strukturStore(Request $request)
    {
        $request->validate([
            'nama'     => ['required', 'string', 'max:100'],
            'jabatan'  => ['required', 'string', 'max:100'],
            'foto'     => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'urutan'   => ['nullable', 'integer', 'min:0'],
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = 'struktur_' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/struktur'), $filename);
            $fotoPath = '/uploads/struktur/' . $filename;
        }

        StrukturDesa::create([
            'nama'    => $request->nama,
            'jabatan' => $request->jabatan,
            'foto'    => $fotoPath,
            'urutan'  => $request->urutan ?? 0,
        ]);

        return back()->with('success', 'Anggota struktur berhasil ditambahkan!');
    }

    public function strukturUpdate(Request $request, StrukturDesa $struktur)
    {
        $request->validate([
            'nama'     => ['required', 'string', 'max:100'],
            'jabatan'  => ['required', 'string', 'max:100'],
            'foto'     => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'urutan'   => ['nullable', 'integer', 'min:0'],
        ]);

        $fotoPath = $struktur->foto;
        if ($request->hasFile('foto')) {
            if ($fotoPath && file_exists(public_path($fotoPath))) {
                @unlink(public_path($fotoPath));
            }
            $file = $request->file('foto');
            $filename = 'struktur_' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/struktur'), $filename);
            $fotoPath = '/uploads/struktur/' . $filename;
        }

        $struktur->update([
            'nama'    => $request->nama,
            'jabatan' => $request->jabatan,
            'foto'    => $fotoPath,
            'urutan'  => $request->urutan ?? 0,
        ]);

        return back()->with('success', 'Data anggota struktur berhasil diperbarui!');
    }

    public function strukturDestroy(StrukturDesa $struktur)
    {
        if ($struktur->foto && file_exists(public_path($struktur->foto))) {
            @unlink(public_path($struktur->foto));
        }
        $struktur->delete();

        return back()->with('success', 'Anggota struktur berhasil dihapus!');
    }
}
