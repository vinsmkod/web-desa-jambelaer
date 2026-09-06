<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Hapus dukungan pengajuan surat dari tabel pesan secara aman.
     */
    public function up(): void
    {
        // 1. Amankan data existing jika ada jenis_pesan 'pengajuan_surat'
        DB::table('pesan')
            ->where('jenis_pesan', 'pengajuan_surat')
            ->update([
                'jenis_pesan' => 'pertanyaan_umum',
                'status'      => 'menunggu',
            ]);

        // 2. Normalisasi nilai status surat non-standar ke status standar
        DB::table('pesan')
            ->whereIn('status', ['diverifikasi', 'diproses', 'menunggu_tanda_tangan', 'selesai'])
            ->update([
                'status' => 'menunggu',
            ]);

        // 3. Kembalikan ENUM status ke standar 3 status (menunggu, disetujui, ditolak)
        DB::statement("
            ALTER TABLE pesan
            MODIFY COLUMN status
                ENUM('menunggu','disetujui','ditolak')
                NOT NULL
                DEFAULT 'menunggu'
        ");

        // 4. Kembalikan ENUM jenis_pesan tanpa pengajuan_surat
        DB::statement("
            ALTER TABLE pesan
            MODIFY COLUMN jenis_pesan
                ENUM('pertanyaan_umum','pengaduan','kerja_sama','pengajuan_acara','daftar_umkm')
                NOT NULL
                DEFAULT 'pertanyaan_umum'
        ");

        // 5. Hapus kolom-kolom yang hanya dibuat khusus untuk fitur pengajuan surat
        Schema::table('pesan', function (Blueprint $table) {
            $cols = ['sku_alamat_usaha', 'sku_jenis_usaha', 'sku_nama_usaha', 'alamat_pemohon'];
            foreach ($cols as $col) {
                if (Schema::hasColumn('pesan', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }

    /**
     * Rollback migration.
     */
    public function down(): void
    {
        // Tambahkan kembali kolom surat jika di-rollback
        Schema::table('pesan', function (Blueprint $table) {
            if (!Schema::hasColumn('pesan', 'alamat_pemohon')) {
                $table->string('alamat_pemohon')->nullable()->after('catatan_admin');
            }
            if (!Schema::hasColumn('pesan', 'sku_nama_usaha')) {
                $table->string('sku_nama_usaha')->nullable()->after('alamat_pemohon');
            }
            if (!Schema::hasColumn('pesan', 'sku_jenis_usaha')) {
                $table->string('sku_jenis_usaha')->nullable()->after('sku_nama_usaha');
            }
            if (!Schema::hasColumn('pesan', 'sku_alamat_usaha')) {
                $table->string('sku_alamat_usaha')->nullable()->after('sku_jenis_usaha');
            }
        });

        // Kembalikan ENUM jenis_pesan dengan pengajuan_surat
        DB::statement("
            ALTER TABLE pesan
            MODIFY COLUMN jenis_pesan
                ENUM('pertanyaan_umum','pengaduan','kerja_sama','pengajuan_acara','daftar_umkm','pengajuan_surat')
                NOT NULL
                DEFAULT 'pertanyaan_umum'
        ");

        // Kembalikan ENUM status lengkap
        DB::statement("
            ALTER TABLE pesan
            MODIFY COLUMN status
                ENUM('menunggu','disetujui','ditolak','diverifikasi','diproses','menunggu_tanda_tangan','selesai')
                NOT NULL
                DEFAULT 'menunggu'
        ");
    }
};
