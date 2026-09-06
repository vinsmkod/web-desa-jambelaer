<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Galeri extends Model
{
    use HasFactory;

    protected $table = 'galeri';
    protected $primaryKey = 'galeri_id';

    protected $fillable = [
        'created_by',
        'judul',
        'slug',
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
     * Auto-generate slug saat menyimpan jika slug kosong.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($galeri) {
            if (empty($galeri->slug)) {
                $galeri->slug = static::generateUniqueSlug($galeri->judul, $galeri->galeri_id ?? null);
            }
        });

        static::updating(function ($galeri) {
            if (empty($galeri->slug)) {
                $galeri->slug = static::generateUniqueSlug($galeri->judul, $galeri->galeri_id);
            }
        });
    }

    /**
     * Generate slug unik berdasarkan judul.
     */
    public static function generateUniqueSlug(string $judul, ?int $excludeId = null): string
    {
        $baseSlug = Str::slug($judul, '-');
        $slug     = $baseSlug;
        $counter  = 1;

        $query = static::where('slug', $slug);
        if ($excludeId) {
            $query->where('galeri_id', '!=', $excludeId);
        }

        while ($query->exists()) {
            $slug    = $baseSlug . '-' . $counter;
            $counter++;
            $query   = static::where('slug', $slug);
            if ($excludeId) {
                $query->where('galeri_id', '!=', $excludeId);
            }
        }

        return $slug;
    }

    /**
     * URL foto galeri dengan fallback aman.
     * Menangani URL penuh (http/https), path lokal storage/, dan path langsung di public/.
     */
    public function getFotoUrlAttribute(): string
    {
        if ($this->foto) {
            if (filter_var($this->foto, FILTER_VALIDATE_URL)) {
                return $this->foto;
            }
            if (file_exists(public_path('storage/' . $this->foto))) {
                return asset('storage/' . $this->foto);
            }
            if (file_exists(public_path($this->foto))) {
                return asset($this->foto);
            }
        }

        return asset('uploads/img/DESA_JAMBELAER.png');
    }

    /**
     * URL canonical galeri: gunakan slug jika tersedia, fallback ke ID.
     */
    public function getUrlAttribute(): string
    {
        $identifier = $this->slug ?: $this->galeri_id;
        return url('/galeri/' . $identifier);
    }

    /**
     * Label kategori yang dapat dibaca.
     */
    public function getKategoriLabelAttribute(): string
    {
        return match($this->kategori) {
            'kegiatan_desa' => 'Kegiatan Desa',
            'acara_desa'    => 'Acara Desa',
            'budaya_desa'   => 'Budaya Desa',
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
            'budaya_desa'   => 'Budaya Desa',
        ];
    }

    // ── Relationships ────────────────────────────────────────────────────────

    /**
     * User/Admin yang membuat foto galeri ini.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }
}

