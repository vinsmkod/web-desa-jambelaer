<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Tambahkan kolom slug ke tabel galeri.
     *
     * Setelah kolom ditambahkan, generate slug dari judul
     * untuk semua record yang sudah ada.
     */
    public function up(): void
    {
        Schema::table('galeri', function (Blueprint $table) {
            // Nullable agar tidak merusak record lama, unique untuk SEO
            $table->string('slug')->nullable()->unique()->after('judul');
        });

        // Generate slug untuk semua record yang sudah ada
        $galeris = DB::table('galeri')->select('id', 'judul')->get();

        foreach ($galeris as $galeri) {
            $baseSlug = Str::slug($galeri->judul, '-') ?: 'galeri-' . $galeri->id;
            $slug     = $baseSlug;
            $counter  = 1;

            // Pastikan slug unik
            while (DB::table('galeri')->where('slug', $slug)->where('id', '!=', $galeri->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            DB::table('galeri')->where('id', $galeri->id)->update(['slug' => $slug]);
        }
    }

    /**
     * Rollback: hapus kolom slug dari tabel galeri.
     */
    public function down(): void
    {
        Schema::table('galeri', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
