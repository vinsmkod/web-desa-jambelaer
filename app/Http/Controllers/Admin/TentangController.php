<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use App\Models\StrukturDesa;
use Illuminate\Http\Request;

class TentangController extends Controller
{
    /**
     * Re-sequence urutan 1, 2, 3... secara otomatis tanpa jeda/lompatan angka.
     * Hanya dipanggil saat data BERUBAH (store/update/destroy), bukan di index().
     */
    private function resequence()
    {
        $items = StrukturDesa::orderBy('urutan')->orderBy('id')->get();
        foreach ($items as $index => $item) {
            if ($item->urutan != ($index + 1)) {
                $item->update(['urutan' => $index + 1]);
            }
        }
    }

    public function index()
    {
        // Tidak memanggil resequence() di sini agar tidak ada N query UPDATE setiap halaman dibuka
        $strukturList = StrukturDesa::orderBy('urutan')->orderBy('id')->paginate(5);
        $nextUrutan   = (StrukturDesa::max('urutan') ?? 0) + 1;

        return view('admin.tentang.index', compact('strukturList', 'nextUrutan'));
    }

    /**
     * Update informasi/pengaturan halaman Tentang Kami via Pengaturan model.
     * Route: PUT /admin/tentang → admin.tentang.update
     */
    public function update(Request $request)
    {
        $allowedKeys = [
            'tentang_sejarah', 'tentang_visi', 'tentang_misi',
            'tentang_luas', 'tentang_batas_utara', 'tentang_batas_selatan',
            'tentang_batas_timur', 'tentang_batas_barat',
        ];

        $validated = $request->validate([
            'tentang_sejarah'      => ['nullable', 'string', 'max:5000'],
            'tentang_visi'         => ['nullable', 'string', 'max:1000'],
            'tentang_misi'         => ['nullable', 'string', 'max:2000'],
            'tentang_luas'         => ['nullable', 'string', 'max:100'],
            'tentang_batas_utara'  => ['nullable', 'string', 'max:255'],
            'tentang_batas_selatan'=> ['nullable', 'string', 'max:255'],
            'tentang_batas_timur'  => ['nullable', 'string', 'max:255'],
            'tentang_batas_barat'  => ['nullable', 'string', 'max:255'],
        ]);

        foreach ($validated as $key => $value) {
            if (in_array($key, $allowedKeys)) {
                Pengaturan::set($key, $value ?? '');
            }
        }

        return back()->with('success', 'Informasi halaman Tentang Kami berhasil disimpan!');
    }

    public function strukturStore(Request $request)
    {
        $request->validate([
            'nama'     => ['required', 'string', 'max:100'],
            'jabatan'  => ['required', 'string', 'max:100'],
            'foto'     => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'urutan'   => ['nullable', 'integer', 'min:1'],
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = 'struktur_' . time() . '_' . \Illuminate\Support\Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/struktur'), $filename);
            $fotoPath = '/uploads/struktur/' . $filename;
        }

        $maxUrutan = StrukturDesa::max('urutan') ?? 0;
        $urutan    = ($request->filled('urutan') && $request->urutan > 0) ? $request->urutan : ($maxUrutan + 1);

        StrukturDesa::create([
            'nama'    => $request->nama,
            'jabatan' => $request->jabatan,
            'foto'    => $fotoPath,
            'urutan'  => $urutan,
        ]);

        $this->resequence();

        return back()->with('success', 'Anggota struktur berhasil ditambahkan!');
    }

    public function strukturUpdate(Request $request, StrukturDesa $struktur)
    {
        $request->validate([
            'nama'     => ['required', 'string', 'max:100'],
            'jabatan'  => ['required', 'string', 'max:100'],
            'foto'     => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'urutan'   => ['nullable', 'integer', 'min:1'],
        ]);

        $fotoPath = $struktur->foto;
        if ($request->hasFile('foto')) {
            if ($fotoPath && file_exists(public_path($fotoPath))) {
                @unlink(public_path($fotoPath));
            }
            $file = $request->file('foto');
            $filename = 'struktur_' . time() . '_' . \Illuminate\Support\Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/struktur'), $filename);
            $fotoPath = '/uploads/struktur/' . $filename;
        }

        $struktur->update([
            'nama'    => $request->nama,
            'jabatan' => $request->jabatan,
            'foto'    => $fotoPath,
            'urutan'  => $request->urutan ?? $struktur->urutan,
        ]);

        $this->resequence();

        return back()->with('success', 'Data anggota struktur berhasil diperbarui!');
    }

    public function strukturDestroy(StrukturDesa $struktur)
    {
        if ($struktur->foto && file_exists(public_path($struktur->foto))) {
            @unlink(public_path($struktur->foto));
        }
        $struktur->delete();

        $this->resequence();

        return back()->with('success', 'Anggota struktur berhasil dihapus!');
    }
}
