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
        'foto_bukti',
        'is_archived',
    ];

    protected $casts = [
        'is_read'        => 'boolean',
        'dipublikasikan' => 'boolean',
        'is_archived'    => 'boolean',
        'tanggal_acara'  => 'date',
    ];

    /**
     * Arsipkan pengajuan acara yang sudah disetujui & tanggalnya sudah lewat.
     * Menggunakan flag 'is_archived' agar histori acara tidak hilang permanen.
     * Acara berstatus 'menunggu' atau 'ditolak' tetap disimpan sebagai history.
     */
    public static function cleanupExpiredAcara()
    {
        static::where('jenis_pesan', 'pengajuan_acara')
            ->where('status', 'disetujui')
            ->whereNotNull('tanggal_acara')
            ->whereDate('tanggal_acara', '<', now()->toDateString())
            ->where(function($q) {
                $q->whereNull('is_archived')->orWhere('is_archived', false);
            })
            ->update(['is_archived' => true, 'dipublikasikan' => false]);
    }
}

