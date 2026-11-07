<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class WisataModel extends Model
{
    use HasFactory;

    protected $table = 'wisata';
    protected $primaryKey = 'wisata_id';

    protected $fillable = [
        'created_by',
        'nama',
        'slug',
        'kategori',
        'ringkasan',
        'deskripsi',
        'alamat',
        'maps_iframe',
        'gambar',
        'harga_tiket',
        'jam_operasional',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer',
    ];

    /**
     * URL Gambar Wisata dengan fallback default.
     * Controller menyimpan path sebagai string absolut (/uploads/wisata/xxx) atau URL eksternal.
     */
    public function getGambarUrlAttribute(): string
    {
        if ($this->gambar) {
            // Jika URL penuh (http/https), langsung gunakan
            if (filter_var($this->gambar, FILTER_VALIDATE_URL)) {
                return $this->gambar;
            }
            // Jika path lokal, cek keberadaan file di folder public
            if (file_exists(public_path($this->gambar))) {
                return asset($this->gambar);
            }
        }

        // Fallback default lokal
        return asset('uploads/img/DESA_JAMBELAER.png');
    }

    /**
     * Label kategori yang ramah dibaca.
     */
    public function getKategoriLabelAttribute(): string
    {
        return match($this->kategori) {
            'alam' => 'Wisata Alam',
            'budaya' => 'Wisata Budaya',
            'kuliner' => 'Wisata Kuliner',
            default => ucfirst($this->kategori),
        };
    }

    /**
     * Daftar opsi kategori wisata.
     */
    public static function kategoriList(): array
    {
        return [
            'alam' => 'Wisata Alam',
            'budaya' => 'Wisata Budaya',
            'kuliner' => 'Wisata Kuliner',
        ];
    }

    // ── Relationships ────────────────────────────────────────────────────────

    /**
     * User/Admin yang membuat destinasi wisata ini.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'created_by', 'user_id');
    }
}

