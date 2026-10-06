<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PertanyaanUmum extends Model
{
    protected $table = 'pertanyaan_umums';
    protected $primaryKey = 'pertanyaan_id';

    public function getRouteKeyName(): string
    {
        return 'pertanyaan_id';
    }

    protected $fillable = [
        'nomor_pertanyaan',
        'user_id',
        'nama',
        'email',
        'no_whatsapp',
        'subjek',
        'pertanyaan',
        'jawaban_admin',
        'status',          // diajukan, dijawab, selesai
    ];

    /**
     * Generate nomor pertanyaan unik dengan format TANYA-YYYYMMDD-XXXX
     */
    public static function generateNomorPertanyaan(): string
    {
        $today = date('Ymd');
        $prefix = 'TANYA-' . $today . '-';

        $latest = static::where('nomor_pertanyaan', 'like', $prefix . '%')
            ->orderBy('pertanyaan_id', 'desc')
            ->first();

        if ($latest && preg_match('/' . preg_quote($prefix, '/') . '(\d+)/', $latest->nomor_pertanyaan, $matches)) {
            $nextNumber = intval($matches[1]) + 1;
        } else {
            $nextNumber = 1;
        }

        $nomor = $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        while (static::where('nomor_pertanyaan', $nomor)->exists()) {
            $nextNumber++;
            $nomor = $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        }

        return $nomor;
    }

    public function getStatusLabelAttribute(): string
    {
        return match(strtolower($this->status ?? 'diajukan')) {
            'diajukan', 'menunggu' => 'Diajukan',
            'dijawab'              => 'Dijawab',
            'selesai'              => 'Selesai',
            'dibatalkan'           => 'Dibatalkan',
            default                => ucfirst($this->status ?? 'Diajukan'),
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match(strtolower($this->status ?? 'diajukan')) {
            'diajukan', 'menunggu' => 'bg-amber-50 text-amber-700 border-amber-200',
            'dijawab'              => 'bg-sky-50 text-sky-700 border-sky-200',
            'selesai'              => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            'dibatalkan'           => 'bg-stone-100 text-stone-600 border-stone-300',
            default                => 'bg-slate-50 text-slate-700 border-slate-200',
        };
    }

    public function getProgressStepAttribute(): int
    {
        return match(strtolower($this->status ?? 'diajukan')) {
            'diajukan', 'menunggu' => 1,
            'dijawab'              => 2,
            'selesai'              => 3,
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
}
