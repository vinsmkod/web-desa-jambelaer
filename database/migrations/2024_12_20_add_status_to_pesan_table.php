<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesan', function (Blueprint $table) {
            // Tambahkan status untuk pengajuan acara
            $table->enum('status', [
                'menunggu',
                'disetujui',
                'ditolak'
            ])->default('menunggu')->after('jenis_pesan')
              ->comment('Status pengajuan (khususnya untuk pengajuan acara)');

            // Tambahkan flag untuk tracking publikasi
            $table->boolean('dipublikasikan')->default(false)->after('status')
                  ->comment('Apakah acara sudah dipublikasikan ke halaman budaya');
        });
    }

    public function down(): void
    {
        Schema::table('pesan', function (Blueprint $table) {
            $table->dropColumn(['status', 'dipublikasikan']);
        });
    }
};
