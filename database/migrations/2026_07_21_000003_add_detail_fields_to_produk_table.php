<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->string('nama_pemilik')->nullable()->after('producer');
            $table->text('alamat_umkm')->nullable()->after('nama_pemilik');
            $table->string('jam_operasional')->nullable()->after('alamat_umkm');
            $table->string('no_whatsapp_umkm')->nullable()->after('jam_operasional');
            $table->string('instagram_umkm')->nullable()->after('no_whatsapp_umkm');
            $table->string('link_marketplace')->nullable()->after('instagram_umkm');
        });
    }

    public function down(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->dropColumn([
                'nama_pemilik',
                'alamat_umkm',
                'jam_operasional',
                'no_whatsapp_umkm',
                'instagram_umkm',
                'link_marketplace',
            ]);
        });
    }
};
