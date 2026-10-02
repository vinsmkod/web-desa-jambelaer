<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Budaya;
use App\Models\Galeri;
use App\Models\Produk;
use App\Models\Wisata;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate sitemap.xml dinamis berisi semua halaman publik website.
     * Halaman admin, login, dan halaman privat TIDAK dimasukkan.
     */
    public function index(): Response
    {
        $siteUrl = rtrim(config('app.url', 'https://desajambelaer.sainzlab.my.id'), '/');
        $now     = now()->toAtomString();

        // ── Halaman Statis Publik ─────────────────────────────────────────────
        $staticPages = [
            ['url' => '/',             'priority' => '1.0', 'changefreq' => 'weekly'],
            ['url' => '/tentang-kami', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['url' => '/berita',       'priority' => '0.9', 'changefreq' => 'daily'],
            ['url' => '/umkm',         'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => '/wisata',       'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => '/budaya',       'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => '/galeri',       'priority' => '0.6', 'changefreq' => 'weekly'],
            ['url' => '/acara',        'priority' => '0.7', 'changefreq' => 'daily'],
            ['url' => '/kontak',       'priority' => '0.5', 'changefreq' => 'yearly'],
        ];

        // ── Berita Published ──────────────────────────────────────────────────
        $beritas = Berita::where('is_published', true)
            ->select('slug', 'updated_at')
            ->orderBy('published_at', 'desc')
            ->get();

        // ── Produk UMKM Aktif ─────────────────────────────────────────────────
        $produkList = Produk::where('is_active', true)
            ->select('slug', 'jenis', 'updated_at')
            ->orderBy('urutan')
            ->get();

        // Jenis UMKM unik untuk URL /umkm/jenis/{jenis}
        $jenisUnik = $produkList->whereNotNull('jenis')->pluck('jenis')->unique()->values();

        // ── Wisata Aktif ──────────────────────────────────────────────────────
        $wisataList = Wisata::where('is_active', true)
            ->select('slug', 'updated_at')
            ->orderBy('urutan')
            ->get();

        // ── Budaya ─────────────────────────────────────────────────────────────
        $budayaList = Budaya::select('budaya_id', 'slug', 'updated_at')
            ->orderBy('urutan')
            ->get();

        // ── Galeri Aktif ──────────────────────────────────────────────────────
        $galeriList = Galeri::where('is_active', true)
            ->select('galeri_id', 'slug', 'updated_at')
            ->orderBy('urutan')
            ->get();

        // ── Build XML ─────────────────────────────────────────────────────────
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . "\n";
        $xml .= '        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";

        // Halaman statis
        foreach ($staticPages as $page) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . e($siteUrl . $page['url']) . "</loc>\n";
            $xml .= "    <lastmod>{$now}</lastmod>\n";
            $xml .= "    <changefreq>{$page['changefreq']}</changefreq>\n";
            $xml .= "    <priority>{$page['priority']}</priority>\n";
            $xml .= "  </url>\n";
        }

        // Detail berita
        foreach ($beritas as $berita) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . e($siteUrl . '/berita/' . $berita->slug) . "</loc>\n";
            $xml .= "    <lastmod>" . $berita->updated_at->toAtomString() . "</lastmod>\n";
            $xml .= "    <changefreq>weekly</changefreq>\n";
            $xml .= "    <priority>0.7</priority>\n";
            $xml .= "  </url>\n";
        }

        // Jenis UMKM
        foreach ($jenisUnik as $jenis) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . e($siteUrl . '/umkm/jenis/' . $jenis) . "</loc>\n";
            $xml .= "    <lastmod>{$now}</lastmod>\n";
            $xml .= "    <changefreq>weekly</changefreq>\n";
            $xml .= "    <priority>0.6</priority>\n";
            $xml .= "  </url>\n";
        }

        // Detail produk UMKM
        foreach ($produkList as $produk) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . e($siteUrl . '/umkm/' . $produk->slug) . "</loc>\n";
            $xml .= "    <lastmod>" . $produk->updated_at->toAtomString() . "</lastmod>\n";
            $xml .= "    <changefreq>monthly</changefreq>\n";
            $xml .= "    <priority>0.6</priority>\n";
            $xml .= "  </url>\n";
        }

        // Detail wisata
        foreach ($wisataList as $wisata) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . e($siteUrl . '/wisata/' . $wisata->slug) . "</loc>\n";
            $xml .= "    <lastmod>" . $wisata->updated_at->toAtomString() . "</lastmod>\n";
            $xml .= "    <changefreq>monthly</changefreq>\n";
            $xml .= "    <priority>0.6</priority>\n";
            $xml .= "  </url>\n";
        }

        // Detail budaya (gunakan slug jika tersedia, fallback ke id)
        foreach ($budayaList as $budaya) {
            $identifier = $budaya->slug ?: $budaya->budaya_id;
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . e($siteUrl . '/budaya/' . $identifier) . "</loc>\n";
            $xml .= "    <lastmod>" . $budaya->updated_at->toAtomString() . "</lastmod>\n";
            $xml .= "    <changefreq>monthly</changefreq>\n";
            $xml .= "    <priority>0.5</priority>\n";
            $xml .= "  </url>\n";
        }

        // Detail galeri (gunakan slug jika tersedia, fallback ke id)
        foreach ($galeriList as $galeri) {
            $identifier = $galeri->slug ?: $galeri->galeri_id;
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . e($siteUrl . '/galeri/' . $identifier) . "</loc>\n";
            $xml .= "    <lastmod>" . $galeri->updated_at->toAtomString() . "</lastmod>\n";
            $xml .= "    <changefreq>monthly</changefreq>\n";
            $xml .= "    <priority>0.4</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= "</urlset>\n";

        return response($xml, 200)
            ->header('Content-Type', 'application/xml; charset=UTF-8')
            ->header('Cache-Control', 'public, max-age=3600');
    }
}
