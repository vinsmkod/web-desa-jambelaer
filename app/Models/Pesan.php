<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesan extends Model
{
    protected $table = 'pesan';

    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'is_read',
        'jenis_pesan',
        'status',
        'dipublikasikan',
        'no_whatsapp',
        'nama_instansi',
        'nama_acara',
        'tanggal_acara',
        'waktu_acara',
        'lokasi_acara',
        'jumlah_peserta',
        'deskripsi_acara',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'dipublikasikan' => 'boolean',
        'tanggal_acara' => 'date',
    ];

    /**
     * Hapus otomatis pengajuan acara yang tanggalnya sudah melewati hari ini (expired/lewat hari)
     */
    public static function cleanupExpiredAcara()
    {
        static::where('jenis_pesan', 'pengajuan_acara')
            ->whereNotNull('tanggal_acara')
            ->whereDate('tanggal_acara', '<', now()->toDateString())
            ->delete();
    }
}

