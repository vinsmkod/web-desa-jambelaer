<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UMKM extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $primaryKey = 'produk_id';

    protected $fillable = [
        'created_by',          // nullable — diisi jika dibuat oleh admin yang sedang login
        'pendaftaran_umkm_id', // nullable — diisi jika produk berasal dari modul Pendaftaran UMKM baru
        'pesan_id',            // nullable — diisi jika produk berasal dari pengajuan UMKM lama (legacy)
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
     * User (admin) yang membuat/mengelola data produk ini.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }

    /**
     * Data pendaftaran UMKM yang menjadi asal usul produk ini (modul baru).
     */
    public function pendaftaranUmkm(): BelongsTo
    {
        return $this->belongsTo(PendaftaranUmkm::class, 'pendaftaran_umkm_id', 'pendaftaran_umkm_id');
    }
}
