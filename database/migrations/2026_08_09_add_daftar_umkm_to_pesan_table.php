<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Update ENUM jenis_pesan untuk menambah 'daftar_umkm'
        DB::statement("ALTER TABLE pesan MODIFY COLUMN jenis_pesan ENUM('pertanyaan_umum','pengaduan','kerja_sama','pengajuan_acara','daftar_umkm') NOT NULL DEFAULT 'pertanyaan_umum'");

        // 2. Tambah kolom-kolom khusus pendaftaran UMKM
        Schema::table('pesan', function (Blueprint $table) {
            $table->string('nama_umkm')->nullable()->after('is_archived');
            $table->string('jenis_produk_umkm')->nullable()->after('nama_umkm');
            $table->text('alamat_umkm_daftar')->nullable()->after('jenis_produk_umkm');
            $table->text('deskripsi_umkm')->nullable()->after('alamat_umkm_daftar');
            $table->string('foto_produk')->nullable()->after('deskripsi_umkm');
        });
    }

    public function down(): void
    {
        Schema::table('pesan', function (Blueprint $table) {
            $table->dropColumn(['nama_umkm', 'jenis_produk_umkm', 'alamat_umkm_daftar', 'deskripsi_umkm', 'foto_produk']);
        });

        // Rollback ENUM (hapus 'daftar_umkm')
        DB::statement("ALTER TABLE pesan MODIFY COLUMN jenis_pesan ENUM('pertanyaan_umum','pengaduan','kerja_sama','pengajuan_acara') NOT NULL DEFAULT 'pertanyaan_umum'");
    }
};
