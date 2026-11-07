<?php

namespace App\Models;

/**
 * ProfilDesaModel — Model representasi data Profil Desa (SRS-F-002).
 *
 * Model ini menghubungkan ProfilDesaController dengan data Profil Desa di tabel `pengaturan`,
 * serta mengagregasikan data linimasa sejarah (TentangTimelineModel) dan butir misi desa (TentangMisiModel).
 */
class ProfilDesaModel extends PengaturanModel
{
    protected $table = 'pengaturan';
    protected $primaryKey = 'pengaturan_id';

    /**
     * Ambil seluruh item linimasa sejarah desa berurutan.
     */
    public static function getTimeline()
    {
        return TentangTimelineModel::orderBy('urutan')->orderBy('tentang_timeline_id')->get();
    }

    /**
     * Ambil seluruh butir misi desa berurutan.
     */
    public static function getMisi()
    {
        return TentangMisiModel::orderBy('urutan')->orderBy('tentang_misi_id')->get();
    }

    /**
     * Ambil seluruh data scalar profil desa dengan penghapusan prefix 'tentang_' untuk view publik.
     */
    public static function getProfilData(): array
    {
        $profil = [];
        foreach (static::tentangDefaults() as $key => $meta) {
            $shortKey = str_starts_with($key, 'tentang_') ? substr($key, strlen('tentang_')) : $key;
            $profil[$shortKey] = static::getOrNull($key) ?? $meta['value'];
        }

        return $profil;
    }
}

