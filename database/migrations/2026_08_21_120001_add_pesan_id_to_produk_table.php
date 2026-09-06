<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            // Tambah kolom pesan_id nullable (FK ke pesan.pesan_id) — produk bisa dibuat tanpa pengajuan
            $table->unsignedBigInteger('pesan_id')->nullable()->after('produk_id');

            // Foreign key ke tabel pesan (referensi ke PK: pesan.pesan_id)
            $table->foreign('pesan_id')
                ->references('pesan_id')
                ->on('pesan')
                ->onDelete('set null');

            // Index untuk mempercepat query filter/join berdasarkan pesan_id
            $table->index('pesan_id', 'produk_pesan_id_index');
        });
    }

    public function down(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            // Hapus foreign key terlebih dahulu sebelum drop kolom
            $table->dropForeign(['pesan_id']);
            $table->dropIndex('produk_pesan_id_index');
            $table->dropColumn('pesan_id');
        });
    }
};
