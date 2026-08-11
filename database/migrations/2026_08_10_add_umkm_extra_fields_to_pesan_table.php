<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesan', function (Blueprint $table) {
            $table->string('jam_operasional_umkm')->nullable()->after('foto_produk');
            $table->string('instagram_umkm')->nullable()->after('jam_operasional_umkm');
            $table->string('berat_bersih_umkm')->nullable()->after('instagram_umkm');
            $table->string('harga_produk_umkm')->nullable()->after('berat_bersih_umkm');
            $table->string('ketersediaan_umkm')->nullable()->after('harga_produk_umkm');
            $table->string('sertifikasi_umkm')->nullable()->after('ketersediaan_umkm');
        });
    }

    public function down(): void
    {
        Schema::table('pesan', function (Blueprint $table) {
            $table->dropColumn([
                'jam_operasional_umkm',
                'instagram_umkm',
                'berat_bersih_umkm',
                'harga_produk_umkm',
                'ketersediaan_umkm',
                'sertifikasi_umkm',
            ]);
        });
    }
};
