<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\BudayaModel;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menambahkan kolom slug ke tabel budaya untuk URL SEO-friendly.
     */
    public function up(): void
    {
        Schema::table('budaya', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('title');
        });

        // Generate slug untuk data yang sudah ada
        $budayas = BudayaModel::all();
        foreach ($budayas as $budaya) {
            $baseSlug = Str::slug($budaya->title, '-');
            $slug = $baseSlug;
            $counter = 1;

            // Pastikan slug unik
            while (BudayaModel::where('slug', $slug)->where('id', '!=', $budaya->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            $budaya->update(['slug' => $slug]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('budaya', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
