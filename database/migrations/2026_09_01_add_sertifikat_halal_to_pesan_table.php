<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesan', function (Blueprint $table) {
            $table->string('sertifikat_halal')->nullable()->after('sertifikasi_umkm')
                ->comment('Path file PDF sertifikat halal yang diupload saat pendaftaran UMKM');
        });
    }

    public function down(): void
    {
        Schema::table('pesan', function (Blueprint $table) {
            $table->dropColumn('sertifikat_halal');
        });
    }
};
