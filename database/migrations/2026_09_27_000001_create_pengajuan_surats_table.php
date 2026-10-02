<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengajuan_surats', function (Blueprint $table) {
            $table->bigIncrements('pengajuan_surat_id');
            $table->string('nomor_pengajuan', 50)->unique();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('jenis_surat_id');
            $table->string('nik', 20);
            $table->string('no_kk', 20);
            $table->string('nama_pemohon', 255)->nullable();
            $table->string('no_whatsapp', 30)->nullable();
            $table->text('alamat_pemohon');
            $table->text('keperluan');
            $table->string('file_ktp', 255)->nullable();
            $table->string('file_kk', 255)->nullable();
            $table->string('dokumen_pendukung', 255)->nullable();
            $table->text('keterangan_tambahan')->nullable();
            $table->string('status', 30)->default('diajukan'); // diajukan, diverifikasi, diproses, selesai, ditolak
            $table->text('catatan_admin')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('set null');

            $table->foreign('jenis_surat_id')
                ->references('id')
                ->on('jenis_surat')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_surats');
    }
};
