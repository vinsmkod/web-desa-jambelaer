<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GaleriController extends Controller
{
    public function index()
    {
        $galeri = Galeri::orderBy('urutan')->orderBy('id')->paginate(5)->withQueryString();
        return view('admin.galeri.index', compact('galeri'));
    }

    public function create()
    {
        $kategoriList = Galeri::kategoriList();
        return view('admin.galeri.create', compact('kategoriList'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'             => ['required', 'string', 'max:255'],
            'kategori'          => ['required', 'string', 'in:kegiatan_desa,acara_desa,umkm,budaya_desa,dokumentasi'],
            'foto'              => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
            'deskripsi'         => ['nullable', 'string'],
            'tanggal_publikasi' => ['nullable', 'date'],
            'is_active'         => ['boolean'],
            'urutan'            => ['nullable', 'integer'],
        ]);

        if ($request->hasFile('foto')) {
            $file     = $request->file('foto');
            $filename = time() . '_' . Str::slug($data['judul']) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/galeri'), $filename);
            $data['foto'] = '/uploads/galeri/' . $filename;
        }

        $data['is_active'] = $request->boolean('is_active');
        $data['urutan']    = $request->input('urutan', 0);

        Galeri::create($data);

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Foto galeri berhasil ditambahkan!');
    }

    public function show(Galeri $galeri)
    {
        return redirect()->route('admin.galeri.index');
    }

    public function edit(Galeri $galeri)
    {
        $kategoriList = Galeri::kategoriList();
        return view('admin.galeri.edit', compact('galeri', 'kategoriList'));
    }

    public function update(Request $request, Galeri $galeri)
    {
        $data = $request->validate([
            'judul'             => ['required', 'string', 'max:255'],
            'kategori'          => ['required', 'string', 'in:kegiatan_desa,acara_desa,umkm,budaya_desa,dokumentasi'],
            'foto'              => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
            'deskripsi'         => ['nullable', 'string'],
            'tanggal_publikasi' => ['nullable', 'date'],
            'is_active'         => ['boolean'],
            'urutan'            => ['nullable', 'integer'],
        ]);

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($galeri->foto && file_exists(public_path($galeri->foto))) {
                @unlink(public_path($galeri->foto));
            }
            $file     = $request->file('foto');
            $filename = time() . '_' . Str::slug($data['judul']) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/galeri'), $filename);
            $data['foto'] = '/uploads/galeri/' . $filename;
        } else {
            $data['foto'] = $galeri->foto;
        }

        $data['is_active'] = $request->boolean('is_active');

        $galeri->update($data);

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Foto galeri berhasil diperbarui!');
    }

    public function destroy(Galeri $galeri)
    {
        if ($galeri->foto && file_exists(public_path($galeri->foto))) {
            @unlink(public_path($galeri->foto));
        }
        $galeri->delete();
        return redirect()->route('admin.galeri.index')
            ->with('success', 'Foto galeri berhasil dihapus.');
    }
}
