<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';

    protected $fillable = [
        'judul',
        'slug',
        'kategori',
        'ringkasan',
        'konten',
        'gambar',
        'penulis',
        'views',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'views'        => 'integer',
    ];

    /**
     * URL Gambar Berita dengan fallback default.
     */
    public function getGambarUrlAttribute(): string
    {
        if ($this->gambar) {
            if (filter_var($this->gambar, FILTER_VALIDATE_URL)) {
                return $this->gambar;
            }
            if (file_exists(public_path('storage/' . $this->gambar))) {
                return asset('storage/' . $this->gambar);
            }
            if (file_exists(public_path($this->gambar))) {
                return asset($this->gambar);
            }
        }

        // Gambar fallback default Unsplash berkualitas tinggi
        return 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&w=1200&q=80';
    }

    /**
     * Label kategori yang ramah dibaca.
     */
    public function getKategoriLabelAttribute(): string
    {
        return match($this->kategori) {
            'pemerintahan'    => 'Pemerintahan',
            'pembangunan'     => 'Pembangunan',
            'kegiatan_warga'  => 'Kegiatan Warga',
            'pengumuman'      => 'Pengumuman',
            'informasi_publik'=> 'Informasi Publik',
            default           => ucfirst(str_replace('_', ' ', $this->kategori)),
        };
    }

    /**
     * Daftar opsi kategori berita.
     */
    public static function kategoriList(): array
    {
        return [
            'pemerintahan'     => 'Pemerintahan',
            'pembangunan'      => 'Pembangunan',
            'kegiatan_warga'   => 'Kegiatan Warga',
            'pengumuman'       => 'Pengumuman',
            'informasi_publik' => 'Informasi Publik',
        ];
    }
    /**
     * Override route model binding parameter name.
     * Fix: Laravel pluralizes 'berita' to 'beritum' which breaks resource routing.
     */
    public function getRouteKeyName(): string
    {
        return 'id';
    }
}
