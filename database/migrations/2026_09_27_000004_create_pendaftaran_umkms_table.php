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
        Schema::create('pendaftaran_umkms', function (Blueprint $table) {
            $table->bigIncrements('pendaftaran_umkm_id');
            $table->string('nomor_pendaftaran', 50)->unique();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('nama_usaha', 255);
            $table->string('nama_pemilik', 255);
            $table->text('alamat_usaha');
            $table->text('deskripsi_usaha');
            $table->text('produk');
            $table->string('nomor_whatsapp', 30)->nullable();
            $table->string('instagram', 255)->nullable();
            $table->string('nib', 255)->nullable();
            $table->string('sertifikasi_halal', 255)->nullable();
            $table->string('foto_produk', 255)->nullable();
            $table->string('status', 30)->default('diajukan'); // diajukan, diverifikasi, diproses, disetujui, ditolak
            $table->text('catatan_admin')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_umkms');
    }
};
