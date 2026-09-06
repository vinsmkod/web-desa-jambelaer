<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Perluas ENUM status di tabel pesan agar mendukung workflow 6-tahap
     * pengajuan surat:
     *   menunggu -> diverifikasi -> diproses -> menunggu_tanda_tangan -> selesai
     *   atau: menunggu / diverifikasi -> ditolak
     *
     * Nilai lama yang dipertahankan: menunggu, disetujui, ditolak
     * Nilai baru yang ditambahkan  : diverifikasi, diproses, menunggu_tanda_tangan, selesai
     */
    public function up(): void
    {
        DB::statement("
            ALTER TABLE pesan
            MODIFY COLUMN status
                ENUM('menunggu','disetujui','ditolak','diverifikasi','diproses','menunggu_tanda_tangan','selesai')
                NOT NULL
                DEFAULT 'menunggu'
        ");
    }

    /**
     * Kembalikan ke nilai ENUM semula.
     * PERHATIAN: Data yang sudah menggunakan status baru
     * akan ter-reset ke 'menunggu' oleh MySQL saat rollback.
     */
    public function down(): void
    {
        DB::statement("
            ALTER TABLE pesan
            MODIFY COLUMN status
                ENUM('menunggu','disetujui','ditolak')
                NOT NULL
                DEFAULT 'menunggu'
        ");
    }
};