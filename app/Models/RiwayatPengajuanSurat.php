<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatPengajuanSurat extends Model
{
    protected $table = 'riwayat_pengajuan_surats';
    public $timestamps = false;

    protected $fillable = [
        'pengajuan_surat_id',
        'user_id',
        'actor_name',
        'actor_role',
        'status_awal',
        'status_baru',
        'catatan',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function pengajuanSurat(): BelongsTo
    {
        return $this->belongsTo(PengajuanSurat::class, 'pengajuan_surat_id', 'pengajuan_surat_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function getRoleBadgeClassAttribute(): string
    {
        return match($this->actor_role) {
            'staff_desa'        => 'bg-blue-50 text-blue-700 border-blue-200',
            'sekretaris_desa'   => 'bg-purple-50 text-purple-700 border-purple-200',
            'kepala_desa'       => 'bg-amber-50 text-amber-700 border-amber-200',
            'kasi_pemerintahan' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            'masyarakat'        => 'bg-stone-50 text-stone-700 border-stone-200',
            default             => 'bg-slate-50 text-slate-700 border-slate-200',
        };
    }

    public function getRoleLabelAttribute(): string
    {
        return match($this->actor_role) {
            'staff_desa'        => 'Staff Desa',
            'sekretaris_desa'   => 'Sekretaris Desa',
            'kepala_desa'       => 'Kepala Desa',
            'kasi_pemerintahan' => 'Kasi Pemerintahan',
            'masyarakat'        => 'Masyarakat / Pemohon',
            'admin'             => 'Administrator Sistem',
            default             => ucfirst(str_replace('_', ' ', $this->actor_role)),
        };
    }
}

