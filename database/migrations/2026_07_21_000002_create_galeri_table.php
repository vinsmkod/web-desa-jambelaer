<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galeri', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->enum('kategori', [
                'kegiatan_desa',
                'acara_desa',
                'umkm',
                'budaya_desa',
                'dokumentasi',
            ])->default('kegiatan_desa');
            $table->string('foto');
            $table->text('deskripsi')->nullable();
            $table->date('tanggal_publikasi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galeri');
    }
};
