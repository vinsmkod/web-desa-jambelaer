<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $primaryKey = 'produk_id';

    protected $fillable = [
        'pesan_id',    // nullable — diisi jika produk berasal dari pengajuan UMKM (traceability)
        'slug', 'title', 'producer', 'price', 'badge',
        'category', 'img', 'desc_short', 'desc_long',
        'details', 'is_active', 'urutan', 'jenis', 'jenis_label',
        // Detail UMKM
        'nama_pemilik', 'alamat_umkm', 'jam_operasional',
        'no_whatsapp_umkm', 'instagram_umkm', 'link_marketplace',
    ];

    protected $casts = [
        'category'  => 'array',
        'details'   => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * URL gambar produk UMKM dengan fallback aman.
     * Menangani URL penuh (http/https), path lokal storage/, dan path langsung di public/.
     * Konsisten dengan model Berita, Wisata, dan Budaya.
     */
    public function getImgUrlAttribute(): string
    {
        if ($this->img) {
            // Jika URL penuh (http/https), langsung gunakan
            if (filter_var($this->img, FILTER_VALIDATE_URL)) {
                return $this->img;
            }
            // Cek di storage/
            if (file_exists(public_path('storage/' . $this->img))) {
                return asset('storage/' . $this->img);
            }
            // Cek di public/ langsung
            if (file_exists(public_path($this->img))) {
                return asset($this->img);
            }
        }

        // Fallback ke logo desa
        return asset('uploads/img/DESA_JAMBELAER.png');
    }

    // ── Relationships ────────────────────────────────────────────────────────

    /**
     * Pesan pengajuan UMKM yang menjadi asal-usul produk ini.
     *
     * Nullable: produk yang dimasukkan langsung oleh admin (tanpa pengajuan)
     * tidak akan memiliki pesan asal, sehingga nilai pesan_id = NULL.
     */
    public function pesan(): BelongsTo
    {
        return $this->belongsTo(Pesan::class, 'pesan_id', 'pesan_id');
    }
}
