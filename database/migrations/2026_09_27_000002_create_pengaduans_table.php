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
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->bigIncrements('pengaduan_id');
            $table->string('nomor_pengaduan', 50)->unique();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('nama', 255);
            $table->string('email', 255)->nullable();
            $table->string('no_whatsapp', 30)->nullable();
            $table->string('judul', 255);
            $table->text('isi_pengaduan');
            $table->string('lokasi', 255)->nullable();
            $table->string('foto_bukti', 255)->nullable();
            $table->string('status', 30)->default('diajukan'); // diajukan, diproses, selesai, ditolak
            $table->text('tanggapan_admin')->nullable();
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
        Schema::dropIfExists('pengaduans');
    }
};
