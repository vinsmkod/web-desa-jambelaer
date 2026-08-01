<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wisata;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WisataController extends Controller
{
    public function index()
    {
        $wisataList = Wisata::orderBy('urutan')
            ->orderBy('id')
            ->paginate(5)
            ->withQueryString();

        return view('admin.wisata.index', compact('wisataList'));
    }

    public function create()
    {
        $categories = Wisata::kategoriList();
        return view('admin.wisata.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'kategori' => ['required', 'string', 'in:alam,budaya,kuliner,buatan,religi'],
            'ringkasan' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'alamat' => ['required', 'string', 'max:255'],
            'maps_iframe' => ['nullable', 'string'],
            'gambar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'harga_tiket' => ['required', 'string', 'max:100'],
            'jam_operasional' => ['required', 'string', 'max:100'],
            'urutan' => ['nullable', 'integer', 'min:0'],
        ]);

        $imgPath = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = 'wisata_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/wisata'), $filename);
            $imgPath = '/uploads/wisata/' . $filename;
        }

        // Generate unique slug
        $slug = Str::slug($request->nama);
        $originalSlug = $slug;
        $count = 1;
        while (Wisata::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        Wisata::create([
            'nama' => $request->nama,
            'slug' => $slug,
            'kategori' => $request->kategori,
            'ringkasan' => $request->ringkasan,
            'deskripsi' => $request->deskripsi,
            'alamat' => $request->alamat,
            'maps_iframe' => $request->maps_iframe,
            'gambar' => $imgPath,
            'harga_tiket' => $request->harga_tiket,
            'jam_operasional' => $request->jam_operasional,
            'urutan' => $request->urutan ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.wisata.index')->with('success', 'Destinasi wisata baru berhasil ditambahkan!');
    }

    public function edit(Wisata $wisata)
    {
        $categories = Wisata::kategoriList();
        return view('admin.wisata.edit', compact('wisata', 'categories'));
    }

    public function update(Request $request, Wisata $wisata)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'kategori' => ['required', 'string', 'in:alam,budaya,kuliner,buatan,religi'],
            'ringkasan' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'alamat' => ['required', 'string', 'max:255'],
            'maps_iframe' => ['nullable', 'string'],
            'gambar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'harga_tiket' => ['required', 'string', 'max:100'],
            'jam_operasional' => ['required', 'string', 'max:100'],
            'urutan' => ['nullable', 'integer', 'min:0'],
        ]);

        $imgPath = $wisata->gambar;
        if ($request->hasFile('gambar')) {
            if ($imgPath && file_exists(public_path($imgPath))) {
                @unlink(public_path($imgPath));
            }
            $file = $request->file('gambar');
            $filename = 'wisata_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/wisata'), $filename);
            $imgPath = '/uploads/wisata/' . $filename;
        }

        // Generate unique slug if name changed
        $slug = $wisata->slug;
        if ($wisata->nama !== $request->nama) {
            $slug = Str::slug($request->nama);
            $originalSlug = $slug;
            $count = 1;
            while (Wisata::where('slug', $slug)->where('id', '!=', $wisata->id)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
        }

        $wisata->update([
            'nama' => $request->nama,
            'slug' => $slug,
            'kategori' => $request->kategori,
            'ringkasan' => $request->ringkasan,
            'deskripsi' => $request->deskripsi,
            'alamat' => $request->alamat,
            'maps_iframe' => $request->maps_iframe,
            'gambar' => $imgPath,
            'harga_tiket' => $request->harga_tiket,
            'jam_operasional' => $request->jam_operasional,
            'urutan' => $request->urutan ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.wisata.index')->with('success', 'Data wisata berhasil diperbarui!');
    }

    public function destroy(Wisata $wisata)
    {
        if ($wisata->gambar && file_exists(public_path($wisata->gambar))) {
            @unlink(public_path($wisata->gambar));
        }
        $wisata->delete();

        return redirect()->route('admin.wisata.index')->with('success', 'Destinasi wisata berhasil dihapus!');
    }
}
