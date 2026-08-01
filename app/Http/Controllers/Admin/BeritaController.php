<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    /**
     * Menampilkan daftar berita desa di admin dashboard.
     */
    public function index()
    {
        $beritas = Berita::orderBy('created_at', 'desc')->paginate(5);

        return view('admin.berita.index', compact('beritas'));
    }

    /**
     * Menampilkan form tambah berita baru.
     */
    public function create()
    {
        return view('admin.berita.create');
    }

    /**
     * Menyimpan berita baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul'        => ['required', 'string', 'max:255'],
            'kategori'     => ['required', 'string', 'in:' . implode(',', array_keys(Berita::kategoriList()))],
            'penulis'      => ['required', 'string', 'max:100'],
            'ringkasan'    => ['nullable', 'string', 'max:500'],
            'konten'       => ['required', 'string'],
            'gambar'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'is_published' => ['nullable', 'boolean'],
        ], [
            'judul.required'   => 'Judul berita wajib diisi.',
            'penulis.required' => 'Nama penulis wajib diisi.',
            'konten.required'  => 'Konten berita wajib diisi.',
            'gambar.image'     => 'File gambar harus berupa citra (jpg, jpeg, png, webp).',
            'gambar.max'       => 'Ukuran gambar maksimal 3 MB.',
        ]);

        // Generate unique slug
        $slug = Str::slug($request->judul);
        $originalSlug = $slug;
        $count = 1;
        while (Berita::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('berita', 'public');
        }

        Berita::create([
            'judul'        => $request->judul,
            'slug'         => $slug,
            'kategori'     => $request->kategori,
            'penulis'      => $request->penulis,
            'ringkasan'    => $request->ringkasan ?: Str::limit(strip_tags($request->konten), 150),
            'konten'       => $request->konten,
            'gambar'       => $gambarPath,
            'is_published' => $request->boolean('is_published', true),
            'published_at' => $request->boolean('is_published', true) ? now() : null,
        ]);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita baru berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit berita.
     */
    public function edit(Berita $berita)
    {
        return view('admin.berita.edit', compact('berita'));
    }

    /**
     * Memperbarui data berita.
     */
    public function update(Request $request, Berita $berita)
    {
        $request->validate([
            'judul'        => ['required', 'string', 'max:255'],
            'kategori'     => ['required', 'string', 'in:' . implode(',', array_keys(Berita::kategoriList()))],
            'penulis'      => ['required', 'string', 'max:100'],
            'ringkasan'    => ['nullable', 'string', 'max:500'],
            'konten'       => ['required', 'string'],
            'gambar'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'is_published' => ['nullable', 'boolean'],
        ], [
            'judul.required'   => 'Judul berita wajib diisi.',
            'penulis.required' => 'Nama penulis wajib diisi.',
            'konten.required'  => 'Konten berita wajib diisi.',
            'gambar.image'     => 'File gambar harus berupa citra.',
            'gambar.max'       => 'Ukuran gambar maksimal 3 MB.',
        ]);

        // Update slug if title changed
        if ($berita->judul !== $request->judul) {
            $slug = Str::slug($request->judul);
            $originalSlug = $slug;
            $count = 1;
            while (Berita::where('slug', $slug)->where('id', '!=', $berita->id)->exists()) {
                $slug = "{$originalSlug}-{$count}";
                $count++;
            }
            $berita->slug = $slug;
        }

        if ($request->hasFile('gambar')) {
            if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
                Storage::disk('public')->delete($berita->gambar);
            }
            $berita->gambar = $request->file('gambar')->store('berita', 'public');
        }

        $berita->judul        = $request->judul;
        $berita->kategori     = $request->kategori;
        $berita->penulis      = $request->penulis;
        $berita->ringkasan    = $request->ringkasan ?: Str::limit(strip_tags($request->konten), 150);
        $berita->konten       = $request->konten;
        $berita->is_published = $request->boolean('is_published', true);
        if ($request->boolean('is_published', true) && !$berita->published_at) {
            $berita->published_at = now();
        }
        $berita->save();

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil diperbarui!');
    }

    /**
     * Menghapus berita dari database.
     */
    public function destroy(Berita $berita)
    {
        if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
            Storage::disk('public')->delete($berita->gambar);
        }

        $berita->delete();

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil dihapus!');
    }
}
