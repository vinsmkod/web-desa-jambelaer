<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use App\Models\TentangMisi;
use App\Models\TentangTimeline;
use Illuminate\Contracts\View\View;

/**
 * Halaman publik "Profil Desa" (/profil-desa).
 * Seluruh konten dibaca dari database (Pengaturan + TentangTimeline + TentangMisi).
 */
class ProfilDesaController extends Controller
{
    public function index(): View
    {
        $settings = Pengaturan::all()->keyBy('key');
        $mapsUrl  = Pengaturan::get('maps_embed_url', '');

        // Konten scalar: nilai database jika ada, jika tidak gunakan default.
        // Key yang disimpan di $profil dibuang prefix 'tentang_' agar sesuai dengan nama yang dipakai di view.
        $profil = [];
        foreach (Pengaturan::tentangDefaults() as $key => $meta) {
            $shortKey = str_starts_with($key, 'tentang_') ? substr($key, strlen('tentang_')) : $key;
            $profil[$shortKey] = Pengaturan::getOrNull($key) ?? $meta['value'];
        }

        $timeline = TentangTimeline::orderBy('urutan')->orderBy('tentang_timeline_id')->get();
        $misi     = TentangMisi::orderBy('urutan')->orderBy('tentang_misi_id')->get();

        return view('pages.profil-desa', compact('settings', 'mapsUrl', 'profil', 'timeline', 'misi'));
    }
}

