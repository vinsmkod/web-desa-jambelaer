<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StrukturDesa;
use Illuminate\Http\Request;

class TentangController extends Controller
{
    /**
     * Re-sequence urutan 1, 2, 3... secara otomatis tanpa jeda/lompatan angka.
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
        $this->resequence();
        $strukturList = StrukturDesa::orderBy('urutan')->orderBy('id')->paginate(5);
        $nextUrutan   = (StrukturDesa::max('urutan') ?? 0) + 1;

        return view('admin.tentang.index', compact('strukturList', 'nextUrutan'));
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
