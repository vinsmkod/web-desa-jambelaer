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
        Schema::table('produk', function (Blueprint $table) {
            if (!Schema::hasColumn('produk', 'pendaftaran_umkm_id')) {
                $table->unsignedBigInteger('pendaftaran_umkm_id')->nullable()->after('pesan_id');
                $table->foreign('pendaftaran_umkm_id')
                    ->references('pendaftaran_umkm_id')
                    ->on('pendaftaran_umkms')
                    ->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            if (Schema::hasColumn('produk', 'pendaftaran_umkm_id')) {
                $table->dropForeign(['pendaftaran_umkm_id']);
                $table->dropColumn('pendaftaran_umkm_id');
            }
        });
    }
};
