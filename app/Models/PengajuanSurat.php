<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengajuanSurat extends Model
{
    protected $table = 'pengajuan_surats';
    protected $primaryKey = 'pengajuan_surat_id';

    public function getRouteKeyName(): string
    {
        return 'pengajuan_surat_id';
    }

    protected $fillable = [
        'nomor_pengajuan',
        'user_id',
        'jenis_surat_id',
        'nik',
        'no_kk',
        'nama_pemohon',
        'no_whatsapp',
        'alamat_pemohon',
        'keperluan',
        'file_ktp',
        'file_kk',
        'dokumen_pendukung',
        'keterangan_tambahan',
        'status',          // diajukan, diverifikasi, diproses, selesai, ditolak
        'catatan_admin',
    ];

    /**
     * Generate nomor pengajuan unik dengan format SURAT-YYYYMMDD-XXXX
     */
    public static function generateNomorPengajuan(): string
    {
        $today = date('Ymd');
        $prefix = 'SURAT-' . $today . '-';

        $latest = static::where('nomor_pengajuan', 'like', $prefix . '%')
            ->orderBy('pengajuan_surat_id', 'desc')
            ->first();

        if ($latest && preg_match('/' . preg_quote($prefix, '/') . '(\d+)/', $latest->nomor_pengajuan, $matches)) {
            $nextNumber = intval($matches[1]) + 1;
        } else {
            $nextNumber = 1;
        }

        $nomor = $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        while (static::where('nomor_pengajuan', $nomor)->exists()) {
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
            'selesai', 'disetujui' => 'Selesai',
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
            'selesai', 'disetujui' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            'ditolak'              => 'bg-rose-50 text-rose-700 border-rose-200',
            'dibatalkan'           => 'bg-stone-100 text-stone-600 border-stone-300',
            default                => 'bg-slate-50 text-slate-700 border-slate-200',
        };
    }

    public function getProgressStepAttribute(): int
    {
        return match(strtolower($this->status ?? 'diajukan')) {
            'diajukan', 'menunggu' => 1,
            'diverifikasi'         => 2,
            'diproses'             => 3,
            'selesai', 'disetujui' => 4,
            'ditolak'              => -1,
            'dibatalkan'           => -2,
            default                => 1,
        };
    }

    // ── Relationships ────────────────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function jenisSurat(): BelongsTo
    {
        return $this->belongsTo(JenisSurat::class, 'jenis_surat_id', 'id');
    }
}
