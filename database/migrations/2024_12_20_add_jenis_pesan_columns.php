<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesan', function (Blueprint $table) {
            // Tambahkan jenis pesan
            $table->enum('jenis_pesan', [
                'pertanyaan_umum',
                'pengaduan',
                'kerja_sama',
                'pengajuan_acara'
            ])->default('pertanyaan_umum')->after('is_read');

            // Kolom untuk Pengaduan
            $table->string('no_whatsapp')->nullable()->after('jenis_pesan');

            // Kolom untuk Kerja Sama
            $table->string('nama_instansi')->nullable()->after('no_whatsapp');

            // Kolom untuk Pengajuan Acara
            $table->string('nama_acara')->nullable()->after('nama_instansi');
            $table->date('tanggal_acara')->nullable()->after('nama_acara');
            $table->time('waktu_acara')->nullable()->after('tanggal_acara');
            $table->string('lokasi_acara')->nullable()->after('waktu_acara');
            $table->integer('jumlah_peserta')->nullable()->after('lokasi_acara');
            $table->text('deskripsi_acara')->nullable()->after('jumlah_peserta');
        });
    }

    public function down(): void
    {
        Schema::table('pesan', function (Blueprint $table) {
            $table->dropColumn([
                'jenis_pesan',
                'no_whatsapp',
                'nama_instansi',
                'nama_acara',
                'tanggal_acara',
                'waktu_acara',
                'lokasi_acara',
                'jumlah_peserta',
                'deskripsi_acara',
            ]);
        });
    }
};
