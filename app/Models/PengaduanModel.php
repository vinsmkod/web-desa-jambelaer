<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengaduanModel extends Model
{
    protected $table = 'pengaduans';
    protected $primaryKey = 'pengaduan_id';

    public function getRouteKeyName(): string
    {
        return 'pengaduan_id';
    }

    protected $fillable = [
        'nomor_pengaduan',
        'user_id',
        'nama',
        'email',
        'no_whatsapp',
        'judul',
        'isi_pengaduan',
        'lokasi',
        'foto_bukti',
        'status',          // diajukan, diproses, selesai, ditolak
        'tanggapan_admin',
    ];

    /**
     * Generate nomor pengaduan unik dengan format ADU-YYYYMMDD-XXXX
     */
    public static function generateNomorPengaduan(): string
    {
        $today = date('Ymd');
        $prefix = 'ADU-' . $today . '-';

        $latest = static::where('nomor_pengaduan', 'like', $prefix . '%')
            ->orderBy('pengaduan_id', 'desc')
            ->first();

        if ($latest && preg_match('/' . preg_quote($prefix, '/') . '(\d+)/', $latest->nomor_pengaduan, $matches)) {
            $nextNumber = intval($matches[1]) + 1;
        } else {
            $nextNumber = 1;
        }

        $nomor = $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        while (static::where('nomor_pengaduan', $nomor)->exists()) {
            $nextNumber++;
            $nomor = $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        }

        return $nomor;
    }

    public function getStatusLabelAttribute(): string
    {
        return match(strtolower($this->status ?? 'diajukan')) {
            'diajukan', 'menunggu' => 'Diajukan',
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
            'diproses'             => 2,
            'selesai', 'disetujui' => 3,
            'ditolak'              => -1,
            'dibatalkan'           => -2,
            default                => 1,
        };
    }

    // ── Relationships ────────────────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }
}
