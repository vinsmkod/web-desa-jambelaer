<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pesan extends Model
{
    protected $table = 'pesan';
    protected $primaryKey = 'pesan_id';

    protected $fillable = [
        'user_id',   // nullable — diisi jika pengirim adalah admin yang sedang login
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
        // Pendaftaran UMKM
        'nama_umkm',
        'jenis_produk_umkm',
        'alamat_umkm_daftar',
        'deskripsi_umkm',
        'foto_produk',
        'jam_operasional_umkm',
        'instagram_umkm',
        'isi_produk_umkm',
        'harga_produk_umkm',
        'berat_bersih_umkm',
        'ketersediaan_umkm',
        'sertifikasi_umkm',
        'sertifikat_halal',
        'dokumen_lampiran',
        // Admin fields
        'catatan_admin',   // catatan internal admin untuk pesan, pengajuan acara, dll.
    ];


    protected $casts = [
        'is_read'        => 'boolean',
        'dipublikasikan' => 'boolean',
        'is_archived'    => 'boolean',
        'tanggal_acara'  => 'date',
    ];

    // ── Relationships ────────────────────────────────────────────────────────

    /**
     * User (admin) yang terhubung dengan pesan ini.
     *
     * Nullable: mayoritas pesan dikirim oleh masyarakat umum tanpa akun,
     * sehingga user_id akan NULL untuk pesan-pesan tersebut.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Produk UMKM yang berasal dari pengajuan pesan ini.
     *
     * Berlaku untuk pesan dengan jenis_pesan = 'daftar_umkm' yang sudah
     * disetujui dan datanya dipindahkan menjadi produk oleh admin.
     * Nullable: tidak semua pesan menghasilkan produk.
     */
    public function produk(): HasOne
    {
        return $this->hasOne(Produk::class, 'pesan_id', 'pesan_id');
    }

    // ── Business Logic ───────────────────────────────────────────────────────

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
