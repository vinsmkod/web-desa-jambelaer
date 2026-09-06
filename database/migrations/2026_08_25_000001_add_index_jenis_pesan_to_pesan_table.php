<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tambah index pada kolom jenis_pesan di tabel pesan.
 *
 * Alasan:
 * - PesanController::index()     : WHERE jenis_pesan = ? (dijalankan setiap kali halaman pesan dibuka)
 * - DashboardController::index() : COUNT(*) ... WHERE jenis_pesan = ? (5 query terpisah per load)
 * - PengajuanAcaraController     : WHERE jenis_pesan = 'pengajuan_acara' (cleanupExpiredAcara + index)
 *
 * Tanpa index, setiap query di atas melakukan full table scan pada tabel pesan.
 * Dengan index, MariaDB/MySQL dapat langsung menggunakan B-tree lookup.
 *
 * Aman untuk data existing:
 * - Menambah index tidak mengubah data apapun
 * - Tidak ada risiko data loss
 * - Bisa di-rollback kapan saja dengan drop index
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesan', function (Blueprint $table) {
            $table->index('jenis_pesan', 'pesan_jenis_pesan_index');
        });
    }

    public function down(): void
    {
        Schema::table('pesan', function (Blueprint $table) {
            $table->dropIndex('pesan_jenis_pesan_index');
        });
    }
};
