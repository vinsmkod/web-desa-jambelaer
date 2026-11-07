<?php

namespace App\Http\Controllers;

use App\Models\UMKMModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class UMKMController extends Controller
{
    /**
     * Menampilkan daftar produk UMKM (grouped by jenis).
     */
    public function index(): View
    {
        $products           = UMKMModel::where('is_active', true)->orderBy('urutan')->orderBy('produk_id')->get();
        $jenisGroups        = $products->whereNotNull('jenis')->groupBy('jenis');
        $individualProducts = $products->filter(fn($p) => is_null($p->jenis));

        return view('pages.umkm', compact('products', 'jenisGroups', 'individualProducts'));
    }

    /**
     * Menampilkan daftar produsen per jenis produk.
     */
    public function jenis(string $jenis): View
    {
        $producers = UMKMModel::where('is_active', true)
            ->where('jenis', $jenis)
            ->orderBy('urutan')
            ->orderBy('produk_id')
            ->get();

        if ($producers->isEmpty()) {
            abort(404);
        }

        $jenisLabel = $producers->first()->jenis_label ?? ucfirst($jenis);

        return view('pages.umkm-producers', compact('producers', 'jenis', 'jenisLabel'));
    }

    /**
     * Menampilkan detail produk / produsen UMKM.
     */
    public function detail(string $slug): View
    {
        $product     = UMKMModel::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $allProducts = UMKMModel::where('is_active', true)->where('slug', '!=', $slug)->take(4)->get();

        return view('pages.umkm-detail', compact('product', 'allProducts'));
    }
}
