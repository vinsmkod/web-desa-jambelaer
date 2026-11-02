<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    /**
     * Menampilkan daftar berita desa di admin dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        $query = Berita::orderBy('created_at', 'desc');

        // Kasi Pemerintahan hanya dapat mengelola berita kegiatan pemerintahan & pembangunan desa
        if ($user && $user->isKasiPemerintahan()) {
            $query->whereIn('kategori', [
                Berita::KATEGORI_KEGIATAN_PEMERINTAHAN,
                Berita::KATEGORI_PEMBANGUNAN_DESA,
            ]);
        }

        $beritas = $query->paginate(10);

        return view('admin.berita.index', compact('beritas'));
    }

    /**
     * Menampilkan form tambah berita baru.
     */
    public function create()
    {
        $user = Auth::user();
        $allowedKategori = [
            Berita::KATEGORI_KEGIATAN_PEMERINTAHAN => 'Kegiatan Pemerintahan',
            Berita::KATEGORI_PEMBANGUNAN_DESA     => 'Pembangunan Desa',
        ];

        // Staff desa, kepala desa, dan admin dapat mengelola semua kategori
        if (!$user || !$user->isKasiPemerintahan()) {
            $allowedKategori = array_merge([
                Berita::KATEGORI_UMUM => 'Umum / Kemasyarakatan',
            ], $allowedKategori);
        }

        return view('admin.berita.create', compact('allowedKategori'));
    }

    /**
     * Menyimpan berita baru ke database.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $allowedKategoriValues = [
            Berita::KATEGORI_KEGIATAN_PEMERINTAHAN,
            Berita::KATEGORI_PEMBANGUNAN_DESA,
        ];

        if (!$user || !$user->isKasiPemerintahan()) {
            $allowedKategoriValues[] = Berita::KATEGORI_UMUM;
        }

        $request->validate([
            'judul'        => ['required', 'string', 'max:255'],
            'kategori'     => ['required', 'string', 'in:' . implode(',', $allowedKategoriValues)],
            'penulis'      => ['required', 'string', 'max:100'],
            'ringkasan'    => ['nullable', 'string', 'max:500'],
            'konten'       => ['required', 'string'],
            'gambar'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'is_published' => ['nullable', 'boolean'],
        ], [
            'judul.required'    => 'Judul berita wajib diisi.',
            'kategori.required' => 'Kategori berita wajib dipilih.',
            'kategori.in'       => 'Kategori berita tidak valid sesuai kewenangan hak akses Anda.',
            'penulis.required'  => 'Nama penulis wajib diisi.',
            'konten.required'   => 'Konten berita wajib diisi.',
            'gambar.image'      => 'File gambar harus berupa citra (jpg, jpeg, png, webp).',
            'gambar.max'        => 'Ukuran gambar maksimal 3 MB.',
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
            'created_by'   => Auth::id(),
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
        $user = Auth::user();

        // Kasi Pemerintahan dibatasi hanya untuk kegiatan pemerintahan & rencana pembangunan desa
        if ($user && $user->isKasiPemerintahan() && !in_array($berita->kategori, [
            Berita::KATEGORI_KEGIATAN_PEMERINTAHAN,
            Berita::KATEGORI_PEMBANGUNAN_DESA,
        ])) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah berita di luar kategori kegiatan pemerintahan dan pembangunan desa.');
        }

        $allowedKategori = [
            Berita::KATEGORI_KEGIATAN_PEMERINTAHAN => 'Kegiatan Pemerintahan',
            Berita::KATEGORI_PEMBANGUNAN_DESA     => 'Pembangunan Desa',
        ];

        if (!$user || !$user->isKasiPemerintahan()) {
            $allowedKategori = array_merge([
                Berita::KATEGORI_UMUM => 'Umum / Kemasyarakatan',
            ], $allowedKategori);
        }

        return view('admin.berita.edit', compact('berita', 'allowedKategori'));
    }

    /**
     * Memperbarui data berita.
     */
    public function update(Request $request, Berita $berita)
    {
        $user = Auth::user();

        if ($user && $user->isKasiPemerintahan() && !in_array($berita->kategori, [
            Berita::KATEGORI_KEGIATAN_PEMERINTAHAN,
            Berita::KATEGORI_PEMBANGUNAN_DESA,
        ])) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah berita ini.');
        }

        $allowedKategoriValues = [
            Berita::KATEGORI_KEGIATAN_PEMERINTAHAN,
            Berita::KATEGORI_PEMBANGUNAN_DESA,
        ];

        if (!$user || !$user->isKasiPemerintahan()) {
            $allowedKategoriValues[] = Berita::KATEGORI_UMUM;
        }

        $request->validate([
            'judul'        => ['required', 'string', 'max:255'],
            'kategori'     => ['required', 'string', 'in:' . implode(',', $allowedKategoriValues)],
            'penulis'      => ['required', 'string', 'max:100'],
            'ringkasan'    => ['nullable', 'string', 'max:500'],
            'konten'       => ['required', 'string'],
            'gambar'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'is_published' => ['nullable', 'boolean'],
        ], [
            'judul.required'    => 'Judul berita wajib diisi.',
            'kategori.required' => 'Kategori berita wajib dipilih.',
            'kategori.in'       => 'Kategori berita tidak valid sesuai kewenangan hak akses Anda.',
            'penulis.required'  => 'Nama penulis wajib diisi.',
            'konten.required'   => 'Konten berita wajib diisi.',
            'gambar.image'      => 'File gambar harus berupa citra.',
            'gambar.max'        => 'Ukuran gambar maksimal 3 MB.',
        ]);

        // Update slug if title changed
        if ($berita->judul !== $request->judul) {
            $slug = Str::slug($request->judul);
            $originalSlug = $slug;
            $count = 1;
            while (Berita::where('slug', $slug)->where('berita_id', '!=', $berita->berita_id)->exists()) {
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
        $user = Auth::user();

        if ($user && $user->isKasiPemerintahan() && !in_array($berita->kategori, [
            Berita::KATEGORI_KEGIATAN_PEMERINTAHAN,
            Berita::KATEGORI_PEMBANGUNAN_DESA,
        ])) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus berita ini.');
        }

        if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
            Storage::disk('public')->delete($berita->gambar);
        }

        $berita->delete();

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil dihapus!');
    }
}
