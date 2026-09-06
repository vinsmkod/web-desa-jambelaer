<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE pesan MODIFY COLUMN jenis_pesan ENUM('pertanyaan_umum','pengaduan','kerja_sama','pengajuan_acara','daftar_umkm','pengajuan_surat') NOT NULL DEFAULT 'pertanyaan_umum'");

        Schema::table('pesan', function (Blueprint $table) {
            $table->text('catatan_admin')->nullable()->after('sertifikat_halal');
        });
    }

    public function down(): void
    {
        Schema::table('pesan', function (Blueprint $table) {
            $table->dropColumn('catatan_admin');
        });

        DB::statement("ALTER TABLE pesan MODIFY COLUMN jenis_pesan ENUM('pertanyaan_umum','pengaduan','kerja_sama','pengajuan_acara','daftar_umkm') NOT NULL DEFAULT 'pertanyaan_umum'");
    }
};
