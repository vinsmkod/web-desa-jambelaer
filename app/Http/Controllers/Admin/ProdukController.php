<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $allProduk = Produk::orderBy('urutan')->orderBy('produk_id')->get();
        $produk    = Produk::orderBy('urutan')->orderBy('produk_id')->paginate(5)->withQueryString();
        return view('admin.produk.index', compact('produk', 'allProduk'));
    }

    public function create()
    {
        return view('admin.produk.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'producer'         => ['required', 'string', 'max:255'],
            'price'            => ['required', 'string', 'max:100'],
            'badge'            => ['required', 'string', 'max:100'],
            'category'         => ['required', 'array'],
            'img'              => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'desc_short'       => ['required', 'string'],
            'desc_long'        => ['required', 'string'],
            'is_active'        => ['boolean'],
            'urutan'           => ['nullable', 'integer'],
            'jenis'            => ['nullable', 'string', 'max:100'],
            'jenis_label'      => ['nullable', 'string', 'max:100'],
            // Detail UMKM
            'nama_pemilik'     => ['nullable', 'string', 'max:255'],
            'alamat_umkm'      => ['nullable', 'string'],
            'jam_operasional'  => ['nullable', 'string', 'max:255'],
            'no_whatsapp_umkm' => ['nullable', 'string', 'max:20'],
            'instagram_umkm'   => ['nullable', 'string', 'max:255'],
            'link_marketplace' => ['nullable', 'url', 'max:500'],
        ]);

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $filename = time() . '_' . Str::slug($data['title']) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/produk'), $filename);
            $data['img'] = '/uploads/produk/' . $filename;
        }

        // Build details from key-value pairs
        $detailKeys   = $request->input('detail_keys', []);
        $detailValues = $request->input('detail_values', []);
        $details = [];
        foreach ($detailKeys as $i => $key) {
            if (!empty($key)) {
                $details[$key] = $detailValues[$i] ?? '';
            }
        }
        $data['details']   = $details;
        $data['is_active'] = $request->boolean('is_active');

        // Auto-generate unique slug
        $slug = Str::slug($data['title']);
        $original = $slug;
        $i = 1;
        while (Produk::where('slug', $slug)->exists()) {
            $slug = $original . '-' . $i++;
        }
        $data['slug'] = $slug;

        Produk::create($data);

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Produk $produk)
    {
        return view('admin.produk.edit', compact('produk'));
    }

    public function update(Request $request, Produk $produk)
    {
        $data = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'producer'         => ['required', 'string', 'max:255'],
            'price'            => ['required', 'string', 'max:100'],
            'badge'            => ['required', 'string', 'max:100'],
            'category'         => ['required', 'array'],
            'img'              => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'desc_short'       => ['required', 'string'],
            'desc_long'        => ['required', 'string'],
            'is_active'        => ['boolean'],
            'urutan'           => ['nullable', 'integer'],
            'jenis'            => ['nullable', 'string', 'max:100'],
            'jenis_label'      => ['nullable', 'string', 'max:100'],
            // Detail UMKM
            'nama_pemilik'     => ['nullable', 'string', 'max:255'],
            'alamat_umkm'      => ['nullable', 'string'],
            'jam_operasional'  => ['nullable', 'string', 'max:255'],
            'no_whatsapp_umkm' => ['nullable', 'string', 'max:20'],
            'instagram_umkm'   => ['nullable', 'string', 'max:255'],
            'link_marketplace' => ['nullable', 'url', 'max:500'],
        ]);

        if ($request->hasFile('img')) {
            if ($produk->img && file_exists(public_path($produk->img))) {
                @unlink(public_path($produk->img));
            }
            $file = $request->file('img');
            $filename = time() . '_' . Str::slug($data['title']) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/produk'), $filename);
            $data['img'] = '/uploads/produk/' . $filename;
        } else {
            $data['img'] = $produk->img;
        }

        $detailKeys   = $request->input('detail_keys', []);
        $detailValues = $request->input('detail_values', []);
        $details = [];
        foreach ($detailKeys as $i => $key) {
            if (!empty($key)) {
                $details[$key] = $detailValues[$i] ?? '';
            }
        }
        $data['details']   = $details;
        $data['is_active'] = $request->boolean('is_active');

        $produk->update($data);

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Produk $produk)
    {
        if ($produk->img && file_exists(public_path($produk->img))) {
            @unlink(public_path($produk->img));
        }
        $produk->delete();
        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
