<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'status',          // diajukan, diproses, diverifikasi, selesai, ditolak, dibatalkan
        'catatan_admin',
        'diproses_by',
        'diproses_at',
        'diverifikasi_by',
        'diverifikasi_at',
        'disetujui_by',
        'disetujui_at',
    ];

    protected $casts = [
        'diproses_at'     => 'datetime',
        'diverifikasi_at' => 'datetime',
        'disetujui_at'    => 'datetime',
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
            'diproses'             => 'Diproses',
            'diverifikasi'         => 'Diverifikasi',
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
            'diverifikasi'         => 'bg-sky-50 text-sky-700 border-sky-200',
            'selesai', 'disetujui' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            'ditolak'              => 'bg-rose-50 text-rose-700 border-rose-200',
            'dibatalkan'           => 'bg-stone-100 text-stone-600 border-stone-300',
            default                => 'bg-slate-50 text-slate-700 border-slate-200',
        };
    }

    /**
     * Progres tahapan pelayanan surat sesuai SRS:
     * 1. Diajukan (Masyarakat)
     * 2. Diproses (Staff Desa)
     * 3. Diverifikasi (Sekretaris Desa)
     * 4. Selesai (Kepala Desa)
     */
    public function getProgressStepAttribute(): int
    {
        return match(strtolower($this->status ?? 'diajukan')) {
            'diajukan', 'menunggu' => 1,
            'diproses'             => 2,
            'diverifikasi'         => 3,
            'selesai', 'disetujui' => 4,
            'ditolak'              => -1,
            'dibatalkan'           => -2,
            default                => 1,
        };
    }

    /**
     * Catat log riwayat setiap perubahan status & tindak lanjut proses surat.
     */
    public function logRiwayat(string $statusAwal, string $statusBaru, ?User $actor, ?string $catatan = null): RiwayatPengajuanSurat
    {
        return RiwayatPengajuanSurat::create([
            'pengajuan_surat_id' => $this->pengajuan_surat_id,
            'user_id'            => $actor?->user_id,
            'actor_name'         => $actor ? $actor->name : 'Sistem / Pemohon',
            'actor_role'         => $actor ? $actor->role : 'masyarakat',
            'status_awal'        => $statusAwal,
            'status_baru'        => $statusBaru,
            'catatan'            => $catatan,
            'created_at'         => now(),
        ]);
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

    public function diprosesBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diproses_by', 'user_id');
    }

    public function diverifikasiBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diverifikasi_by', 'user_id');
    }

    public function disetujuiBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'disetujui_by', 'user_id');
    }

    public function riwayat(): HasMany
    {
        return $this->hasMany(RiwayatPengajuanSurat::class, 'pengajuan_surat_id', 'pengajuan_surat_id')->orderBy('created_at', 'asc');
    }
}
