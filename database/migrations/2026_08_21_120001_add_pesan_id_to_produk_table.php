<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tambah kolom pesan_id pada tabel produk.
 *
 * Relasi: pesan 1:0..1 produk
 *
 * Alasan & konteks:
 * - Masyarakat bisa mendaftarkan UMKM melalui form kontak (jenis_pesan = 'daftar_umkm')
 * - Admin kemudian membuat data produk secara manual di admin panel
 * - Kolom ini memungkinkan admin menghubungkan produk dengan pengajuan asalnya (traceability)
 *
 * Alasan nullable:
 * - Produk yang dibuat langsung oleh admin tanpa pengajuan UMKM tidak memiliki pesan asal
 * - Data produk existing (7 record) semuanya dibuat manual → akan bernilai NULL, tetap aman
 *
 * onDelete('set null'):
 * - Jika pesan UMKM dihapus, data produk tidak ikut terhapus
 * - pesan_id pada produk terkait akan di-set ke NULL secara otomatis
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            // Tambah kolom pesan_id setelah 'id', nullable karena tidak semua produk berasal dari pengajuan
            $table->unsignedBigInteger('pesan_id')->nullable()->after('id');

            // Foreign key ke tabel pesan
            $table->foreign('pesan_id')
                  ->references('id')
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
