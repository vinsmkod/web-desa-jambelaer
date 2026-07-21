<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Galeri extends Model
{
    use HasFactory;

    protected $table = 'galeri';

    protected $fillable = [
        'judul',
        'kategori',
        'foto',
        'deskripsi',
        'tanggal_publikasi',
        'is_active',
        'urutan',
    ];

    protected $casts = [
        'is_active'         => 'boolean',
        'tanggal_publikasi' => 'date',
    ];

    /**
     * Label kategori yang dapat dibaca.
     */
    public function getKategoriLabelAttribute(): string
    {
        return match($this->kategori) {
            'kegiatan_desa' => 'Kegiatan Desa',
            'acara_desa'    => 'Acara Desa',
            'umkm'          => 'UMKM',
            'budaya_desa'   => 'Budaya Desa',
            'dokumentasi'   => 'Dokumentasi',
            default         => ucfirst($this->kategori),
        };
    }

    /**
     * Daftar kategori yang tersedia.
     */
    public static function kategoriList(): array
    {
        return [
            'kegiatan_desa' => 'Kegiatan Desa',
            'acara_desa'    => 'Acara Desa',
            'umkm'          => 'UMKM',
            'budaya_desa'   => 'Budaya Desa',
            'dokumentasi'   => 'Dokumentasi',
        ];
    }
}
