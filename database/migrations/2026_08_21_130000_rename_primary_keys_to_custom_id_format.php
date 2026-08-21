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
        // 1. Drop foreign keys yang terhubung ke primary key lama
        Schema::table('produk', function (Blueprint $table) {
            $table->dropForeign(['pesan_id']);
        });

        Schema::table('pesan', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        // 2. Rename primary keys pada masing-masing tabel
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('id', 'user_id');
        });

        Schema::table('pesan', function (Blueprint $table) {
            $table->renameColumn('id', 'pesan_id');
        });

        Schema::table('produk', function (Blueprint $table) {
            $table->renameColumn('id', 'produk_id');
        });

        Schema::table('berita', function (Blueprint $table) {
            $table->renameColumn('id', 'berita_id');
        });

        Schema::table('budaya', function (Blueprint $table) {
            $table->renameColumn('id', 'budaya_id');
        });

        Schema::table('galeri', function (Blueprint $table) {
            $table->renameColumn('id', 'galeri_id');
        });

        Schema::table('struktur_desa', function (Blueprint $table) {
            $table->renameColumn('id', 'struktur_desa_id');
        });

        Schema::table('wisata', function (Blueprint $table) {
            $table->renameColumn('id', 'wisata_id');
        });

        Schema::table('pengaturan', function (Blueprint $table) {
            $table->renameColumn('id', 'pengaturan_id');
        });

        // 3. Pasang kembali foreign keys dengan referensi primary key baru
        Schema::table('pesan', function (Blueprint $table) {
            $table->foreign('user_id')
                  ->references('user_id')
                  ->on('users')
                  ->onDelete('set null');
        });

        Schema::table('produk', function (Blueprint $table) {
            $table->foreign('pesan_id')
                  ->references('pesan_id')
                  ->on('pesan')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Drop foreign keys
        Schema::table('produk', function (Blueprint $table) {
            $table->dropForeign(['pesan_id']);
        });

        Schema::table('pesan', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        // 2. Rename kembali primary keys ke 'id'
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('user_id', 'id');
        });

        Schema::table('pesan', function (Blueprint $table) {
            $table->renameColumn('pesan_id', 'id');
        });

        Schema::table('produk', function (Blueprint $table) {
            $table->renameColumn('produk_id', 'id');
        });

        Schema::table('berita', function (Blueprint $table) {
            $table->renameColumn('berita_id', 'id');
        });

        Schema::table('budaya', function (Blueprint $table) {
            $table->renameColumn('budaya_id', 'id');
        });

        Schema::table('galeri', function (Blueprint $table) {
            $table->renameColumn('galeri_id', 'id');
        });

        Schema::table('struktur_desa', function (Blueprint $table) {
            $table->renameColumn('struktur_desa_id', 'id');
        });

        Schema::table('wisata', function (Blueprint $table) {
            $table->renameColumn('wisata_id', 'id');
        });

        Schema::table('pengaturan', function (Blueprint $table) {
            $table->renameColumn('pengaturan_id', 'id');
        });

        // 3. Pasang kembali foreign keys ke 'id'
        Schema::table('pesan', function (Blueprint $table) {
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });

        Schema::table('produk', function (Blueprint $table) {
            $table->foreign('pesan_id')
                  ->references('id')
                  ->on('pesan')
                  ->onDelete('set null');
        });
    }
};
