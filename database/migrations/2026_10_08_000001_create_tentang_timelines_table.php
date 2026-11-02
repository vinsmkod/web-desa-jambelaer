<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tentang_timeline', function (Blueprint $table) {
            $table->bigIncrements('tentang_timeline_id');
            $table->string('tahun', 60);
            $table->string('judul', 150);
            $table->text('deskripsi');
            $table->string('ikon', 60)->nullable();
            $table->string('warna', 30)->default('forest');
            $table->unsignedSmallInteger('urutan')->default(1);
            $table->timestamps();
        });

        // Data awal diambil dari timeline sejarah yang sebelumnya hardcode pada halaman publik.
        $now = now();
        DB::table('tentang_timeline')->insert([
            [
                'tahun'      => '1923',
                'judul'      => 'Prakarsa 4 Galandang',
                'deskripsi'  => 'Desa Jambelaer dibentuk atas kesepakatan 4 tokoh galandang: <strong>SURLI</strong> (Kp. Jambelaer), <strong>ARNAB</strong> (Kp. Sadang), <strong>RUKI</strong> (Kp. Jambelaer), dan <strong>SUWARI</strong> (Kp. Melong).',
                'ikon'       => 'users',
                'warna'      => 'forest-dark',
                'urutan'     => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'tahun'      => '1940 – 1985',
                'judul'      => 'Pemerintahan Pertama',
                'deskripsi'  => 'Kepala desa pertama dijabat oleh <strong>SUWARI</strong>, salah satu tokoh pendiri desa, yang memimpin selama 45 tahun dengan dedikasi penuh kepada masyarakat.',
                'ikon'       => 'landmark',
                'warna'      => 'sand',
                'urutan'     => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'tahun'      => '1961',
                'judul'      => 'Pemilihan Demokratis Pertama',
                'deskripsi'  => 'Pemilihan kepala desa secara demokratis oleh masyarakat pertama kali dilaksanakan, menandai dimulainya tata kelola pemerintahan desa yang partisipatif.',
                'ikon'       => 'vote',
                'warna'      => 'forest',
                'urutan'     => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'tahun'      => '2007',
                'judul'      => 'Pemekaran Kecamatan',
                'deskripsi'  => 'Berdasarkan Peraturan Daerah Nomor 3 Tahun 2007, Desa Jambelaer resmi masuk ke dalam wilayah Kecamatan Dawuan yang baru dimekarkan dari Kecamatan Kalijati.',
                'ikon'       => 'file-text',
                'warna'      => 'stone',
                'urutan'     => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('tentang_timeline');
    }
};
