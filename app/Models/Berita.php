<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';
    protected $primaryKey = 'berita_id';

    public const KATEGORI_UMUM                  = 'umum';
    public const KATEGORI_PEMERINTAHAN          = 'kegiatan_pemerintahan';
    public const KATEGORI_PEMBANGUNAN           = 'pembangunan_desa';
    public const KATEGORI_KEGIATAN_PEMERINTAHAN = 'kegiatan_pemerintahan';
    public const KATEGORI_PEMBANGUNAN_DESA      = 'pembangunan_desa';

    public const KATEGORI_LIST = [
        self::KATEGORI_UMUM         => 'Umum & Kemasyarakatan',
        self::KATEGORI_PEMERINTAHAN => 'Kegiatan Pemerintahan Desa',
        self::KATEGORI_PEMBANGUNAN  => 'Rencana & Pembangunan Desa',
    ];

    protected $fillable = [
        'created_by',
        'judul',
        'slug',
        'ringkasan',
        'konten',
        'gambar',
        'penulis',
        'kategori',
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
     * Label kategori berita.
     */
    public function getKategoriLabelAttribute(): string
    {
        return self::KATEGORI_LIST[$this->kategori] ?? ucfirst(str_replace('_', ' ', $this->kategori ?? 'Umum'));
    }

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

        // Gambar fallback default lokal
        return asset('uploads/img/DESA_JAMBELAER.png');
    }

    // ── Relationships ────────────────────────────────────────────────────────
    
    /**
     * User/Admin yang membuat berita ini.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }
}
