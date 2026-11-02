<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StrukturDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StrukturDesaController extends Controller
{
    /**
     * Re-sequence urutan 1, 2, 3... secara otomatis tanpa jeda/lompatan angka.
     * Hanya dipanggil saat data BERUBAH (store/update/destroy), bukan di index().
     */
    private function resequence(): void
    {
        $items = StrukturDesa::orderBy('urutan')->orderBy('struktur_desa_id')->get();
        foreach ($items as $index => $item) {
            if ($item->urutan != ($index + 1)) {
                $item->update(['urutan' => $index + 1]);
            }
        }
    }

    public function index()
    {
        // Tidak memanggil resequence() di sini agar tidak ada N query UPDATE setiap halaman dibuka
        $strukturList = StrukturDesa::orderBy('urutan')->orderBy('struktur_desa_id')->paginate(5);
        $nextUrutan   = (StrukturDesa::max('urutan') ?? 0) + 1;

        return view('admin.tentang.index', compact('strukturList', 'nextUrutan'));
    }

    public function store(Request $request)
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
            $filename = 'struktur_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/struktur'), $filename);
            $fotoPath = '/uploads/struktur/' . $filename;
        }

        $maxUrutan = StrukturDesa::max('urutan') ?? 0;
        $urutan    = ($request->filled('urutan') && $request->urutan > 0) ? $request->urutan : ($maxUrutan + 1);

        StrukturDesa::create([
            'created_by' => Auth::id(),
            'nama'       => $request->nama,
            'jabatan'    => $request->jabatan,
            'foto'       => $fotoPath,
            'urutan'     => $urutan,
        ]);

        $this->resequence();

        return back()->with('success', 'Anggota struktur berhasil ditambahkan!');
    }

    public function update(Request $request, StrukturDesa $struktur)
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
            $filename = 'struktur_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
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

    public function destroy(StrukturDesa $struktur)
    {
        if ($struktur->foto && file_exists(public_path($struktur->foto))) {
            @unlink(public_path($struktur->foto));
        }
        $struktur->delete();

        $this->resequence();

        return back()->with('success', 'Anggota struktur berhasil dihapus!');
    }

    public function strukturStore(Request $request)
    {
        return $this->store($request);
    }

    public function strukturUpdate(Request $request, StrukturDesa $struktur)
    {
        return $this->update($request, $struktur);
    }

    public function strukturDestroy(StrukturDesa $struktur)
    {
        return $this->destroy($struktur);
    }
}
