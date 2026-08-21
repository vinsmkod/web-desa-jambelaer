<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tambah kolom user_id pada tabel pesan.
 *
 * Relasi: users 1:N pesan
 *
 * Alasan nullable:
 * - Masyarakat umum mengirim pesan tanpa login (mayoritas kasus)
 * - Hanya admin yang login yang mungkin memiliki user_id
 * - Data existing (3 record) akan aman dengan nilai NULL
 *
 * onDelete('set null'):
 * - Jika user (admin) dihapus, pesan tidak ikut terhapus
 * - user_id pada pesan terkait akan di-set ke NULL secara otomatis
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesan', function (Blueprint $table) {
            // Tambah kolom user_id setelah 'id', nullable karena publik bisa kirim tanpa login
            $table->unsignedBigInteger('user_id')->nullable()->after('id');

            // Foreign key ke tabel users
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');

            // Index untuk mempercepat query filter/join berdasarkan user_id
            $table->index('user_id', 'pesan_user_id_index');
        });
    }

    public function down(): void
    {
        Schema::table('pesan', function (Blueprint $table) {
            // Hapus foreign key terlebih dahulu sebelum drop kolom
            $table->dropForeign(['user_id']);
            $table->dropIndex('pesan_user_id_index');
            $table->dropColumn('user_id');
        });
    }
};
