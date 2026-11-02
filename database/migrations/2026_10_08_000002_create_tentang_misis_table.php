<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tentang_misi', function (Blueprint $table) {
            $table->bigIncrements('tentang_misi_id');
            $table->text('isi');
            $table->unsignedSmallInteger('urutan')->default(1);
            $table->timestamps();
        });

        // Data awal diambil dari daftar misi yang sebelumnya hardcode pada halaman publik.
        $now = now();
        DB::table('tentang_misi')->insert([
            ['isi' => 'Meningkatkan produktivitas pertanian melalui modernisasi alat ramah lingkungan.', 'urutan' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['isi' => 'Mendorong pertumbuhan UMKM desa melalui program digitalisasi pemasaran.',          'urutan' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['isi' => 'Melestarikan kesenian Sunda dan tradisi Ruwatan Bumi.',                            'urutan' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['isi' => 'Menyelenggarakan pelayanan administrasi desa yang cepat dan digital.',             'urutan' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['isi' => 'Meningkatkan kualitas infrastruktur jalan, air bersih, dan fasilitas umum desa.',  'urutan' => 5, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('tentang_misi');
    }
};
