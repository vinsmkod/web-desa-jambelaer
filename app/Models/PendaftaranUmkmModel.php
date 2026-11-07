<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PendaftaranUmkmModel extends Model
{
    protected $table = 'pendaftaran_umkms';
    protected $primaryKey = 'pendaftaran_umkm_id';

    public function getRouteKeyName(): string
    {
        return 'pendaftaran_umkm_id';
    }

    protected $fillable = [
        'nomor_pendaftaran',
        'user_id',
        'nama_usaha',
        'nama_pemilik',
        'alamat_usaha',
        'deskripsi_usaha',
        'produk',
        'nomor_whatsapp',
        'instagram',
        'nib',
        'sertifikasi_halal',
        'foto_produk',
        'status',          // diajukan, diverifikasi, diproses, disetujui, ditolak
        'catatan_admin',
    ];

    /**
     * Generate nomor pendaftaran unik dengan format UMKM-YYYYMMDD-XXXX
     */
    public static function generateNomorPendaftaran(): string
    {
        $today = date('Ymd');
        $prefix = 'UMKM-' . $today . '-';

        $latest = static::where('nomor_pendaftaran', 'like', $prefix . '%')
            ->orderBy('pendaftaran_umkm_id', 'desc')
            ->first();

        if ($latest && preg_match('/' . preg_quote($prefix, '/') . '(\d+)/', $latest->nomor_pendaftaran, $matches)) {
            $nextNumber = intval($matches[1]) + 1;
        } else {
            $nextNumber = 1;
        }

        $nomor = $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        while (static::where('nomor_pendaftaran', $nomor)->exists()) {
            $nextNumber++;
            $nomor = $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        }

        return $nomor;
    }

    public function getStatusLabelAttribute(): string
    {
        return match(strtolower($this->status ?? 'diajukan')) {
            'diajukan', 'menunggu' => 'Diajukan',
            'diverifikasi'         => 'Diverifikasi',
            'diproses'             => 'Diproses',
            'disetujui', 'selesai' => 'Disetujui',
            'ditolak'              => 'Ditolak',
            'dibatalkan'           => 'Dibatalkan',
            default                => ucfirst($this->status ?? 'Diajukan'),
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match(strtolower($this->status ?? 'diajukan')) {
            'diajukan', 'menunggu' => 'bg-amber-50 text-amber-700 border-amber-200',
            'diverifikasi'         => 'bg-sky-50 text-sky-700 border-sky-200',
            'diproses'             => 'bg-indigo-50 text-indigo-700 border-indigo-200',
            'disetujui', 'selesai' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            'ditolak'              => 'bg-rose-50 text-rose-700 border-rose-200',
            'dibatalkan'           => 'bg-stone-100 text-stone-600 border-stone-300',
            default                => 'bg-slate-50 text-slate-700 border-slate-200',
        };
    }

    public function getIdAttribute()
    {
        return $this->attributes['pendaftaran_umkm_id'] ?? null;
    }

    public function getKodePendaftaranAttribute(): ?string
    {
        return $this->nomor_pendaftaran;
    }

    public function getWhatsappAttribute(): ?string
    {
        return $this->nomor_whatsapp;
    }

    public function getTeleponAttribute(): ?string
    {
        return $this->nomor_whatsapp;
    }

    public function getIsPublishedAttribute(): bool
    {
        return $this->produkDipublikasikan !== null;
    }

    public function getProgressStepAttribute(): int
    {
        return match(strtolower($this->status ?? 'diajukan')) {
            'diajukan', 'menunggu' => 1,
            'diverifikasi'         => 2,
            'diproses'             => 3,
            'disetujui', 'selesai' => 4,
            'ditolak'              => -1,
            'dibatalkan'           => -2,
            default                => 1,
        };
    }

    /**
     * URL foto produk UMKM yang diunggah pemohon
     */
    public function getFotoProdukUrlAttribute(): ?string
    {
        if (!$this->foto_produk) {
            return null;
        }

        if (filter_var($this->foto_produk, FILTER_VALIDATE_URL)) {
            return $this->foto_produk;
        }

        if (file_exists(public_path('storage/' . $this->foto_produk))) {
            return asset('storage/' . $this->foto_produk);
        }

        if (file_exists(public_path($this->foto_produk))) {
            return asset($this->foto_produk);
        }

        return asset('uploads/img/DESA_JAMBELAER.png');
    }

    // ── Relationships ────────────────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }

    public function produkDipublikasikan(): HasOne
    {
        return $this->hasOne(UMKMModel::class, 'pendaftaran_umkm_id', 'pendaftaran_umkm_id');
    }
}
