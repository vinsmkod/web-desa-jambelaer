<?php

namespace App\Http\Controllers;

use App\Models\ProfilDesaModel;
use App\Models\TentangMisiModel;
use App\Models\TentangTimelineModel;
use Illuminate\Contracts\View\View;

/**
 * Halaman publik "Profil Desa" (/profil-desa).
 * Seluruh konten dibaca dari database melalui ProfilDesaModel.
 */
class ProfilDesaController extends Controller
{
    public function index(): View
    {
        $settings = ProfilDesaModel::all()->keyBy('key');
        $mapsUrl  = ProfilDesaModel::get('maps_embed_url', '');

        // Konten scalar: nilai database jika ada, jika tidak gunakan default.
        // Key yang disimpan di $profil dibuang prefix 'tentang_' agar sesuai dengan nama yang dipakai di view.
        $profil = ProfilDesaModel::getProfilData();

        $timeline = ProfilDesaModel::getTimeline();
        $misi     = ProfilDesaModel::getMisi();

        return view('pages.profil-desa', compact('settings', 'mapsUrl', 'profil', 'timeline', 'misi'));
    }
}
