<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaAcara extends Model
{
    use HasFactory;

    protected $table = 'agenda_acaras';
    protected $primaryKey = 'agenda_acara_id';

    protected $fillable = [
        'user_id',
        'nama_acara',
        'tanggal_acara',
        'waktu_acara',
        'lokasi_acara',
        'name',
        'nama_instansi',
        'no_whatsapp',
        'jumlah_peserta',
        'deskripsi_acara',
        'foto_bukti',
        'dokumen_lampiran',
        'status',
        'dipublikasikan',
        'is_archived',
        'is_read',
        'catatan_admin',
    ];

    protected $casts = [
        'tanggal_acara'  => 'date',
        'dipublikasikan' => 'boolean',
        'is_archived'    => 'boolean',
        'is_read'        => 'boolean',
        'jumlah_peserta' => 'integer',
    ];

    public function getRouteKeyName()
    {
        return 'agenda_acara_id';
    }

    /**
     * Relasi ke user / pembuat agenda desa
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Arsipkan agenda acara yang sudah lewat tanggalnya secara otomatis.
     */
    public static function cleanupExpiredAcara()
    {
        static::where('dipublikasikan', true)
            ->whereNotNull('tanggal_acara')
            ->whereDate('tanggal_acara', '<', now()->toDateString())
            ->where(function ($q) {
                $q->whereNull('is_archived')->orWhere('is_archived', false);
            })
            ->update(['is_archived' => true, 'dipublikasikan' => false]);
    }
}
