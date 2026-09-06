<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tambahkan kolom khusus untuk pengajuan surat ke tabel pesan.
 *
 * Semua kolom bersifat nullable agar data lama tidak rusak.
 * - alamat_pemohon  : Alamat domisili pemohon (digunakan untuk Domisili & SKTM)
 * - sku_nama_usaha  : Nama usaha (khusus Surat Keterangan Usaha / SKU)
 * - sku_jenis_usaha : Jenis / bidang usaha (khusus SKU)
 * - sku_alamat_usaha: Alamat tempat usaha (khusus SKU)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesan', function (Blueprint $table) {
            // Hanya tambahkan kolom yang belum ada
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
    }

    public function down(): void
    {
        Schema::table('pesan', function (Blueprint $table) {
            $cols = ['sku_alamat_usaha', 'sku_jenis_usaha', 'sku_nama_usaha', 'alamat_pemohon'];
            foreach ($cols as $col) {
                if (Schema::hasColumn('pesan', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
