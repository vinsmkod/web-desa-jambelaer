<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UMKMModel extends Model
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
     * Menangani URL penuh (http/https), path lokal storage/, dan path langsung di public/ (termasuk uploads/produk).
     */
    public function getImgUrlAttribute(): string
    {
        if ($this->img) {
            // Jika URL penuh (http/https), langsung gunakan
            if (filter_var($this->img, FILTER_VALIDATE_URL)) {
                return $this->img;
            }

            $cleanPath = ltrim($this->img, '/\\');

            // Cek di storage/
            if (file_exists(public_path('storage/' . $cleanPath))) {
                return asset('storage/' . $cleanPath);
            }
            // Cek di public/ langsung (misal uploads/produk/...)
            if (file_exists(public_path($cleanPath))) {
                return asset($cleanPath);
            }
            // Cek langsung di uploads/produk jika hanya menyimpan nama file
            if (file_exists(public_path('uploads/produk/' . basename($cleanPath)))) {
                return asset('uploads/produk/' . basename($cleanPath));
            }
        }

        // Cek fallback jika ada file di uploads/produk yang sesuai dengan slug produk
        if (!empty($this->slug)) {
            $matches = glob(public_path('uploads/produk/*_' . $this->slug . '.*'));
            if (!empty($matches)) {
                return asset('uploads/produk/' . basename($matches[0]));
            }
            $matchesAlt = glob(public_path('uploads/produk/*' . $this->slug . '*'));
            if (!empty($matchesAlt)) {
                return asset('uploads/produk/' . basename($matchesAlt[0]));
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
        return $this->belongsTo(UserModel::class, 'created_by', 'user_id');
    }

    /**
     * Data pendaftaran UMKM yang menjadi asal usul produk ini (modul baru).
     */
    public function pendaftaranUmkm(): BelongsTo
    {
        return $this->belongsTo(PendaftaranUmkmModel::class, 'pendaftaran_umkm_id', 'pendaftaran_umkm_id');
    }
}
