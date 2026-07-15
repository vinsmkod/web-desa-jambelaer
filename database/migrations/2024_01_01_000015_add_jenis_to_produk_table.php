<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            // Slug kelompok jenis produk, cth: "opak"
            $table->string('jenis')->nullable()->after('urutan');
            // Nama tampilan jenis produk, cth: "Opak"
            $table->string('jenis_label')->nullable()->after('jenis');
        });
    }

    public function down(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->dropColumn(['jenis', 'jenis_label']);
        });
    }
};
