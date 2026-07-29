<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Rename instagram_url to sosmed_instagram
        $instagram = DB::table('pengaturan')->where('key', 'instagram_url')->first();
        if ($instagram) {
            DB::table('pengaturan')->where('key', 'instagram_url')->update([
                'key' => 'sosmed_instagram',
                'label' => 'Instagram Desa'
            ]);
        } else {
            DB::table('pengaturan')->insertOrIgnore([
                'key' => 'sosmed_instagram',
                'value' => '#',
                'label' => 'Instagram Desa',
                'group' => 'sosmed',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Rename youtube_url to sosmed_youtube
        $youtube = DB::table('pengaturan')->where('key', 'youtube_url')->first();
        if ($youtube) {
            DB::table('pengaturan')->where('key', 'youtube_url')->update([
                'key' => 'sosmed_youtube',
                'label' => 'YouTube Desa'
            ]);
        } else {
            DB::table('pengaturan')->insertOrIgnore([
                'key' => 'sosmed_youtube',
                'value' => '#',
                'label' => 'YouTube Desa',
                'group' => 'sosmed',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        // Revert renaming
        DB::table('pengaturan')->where('key', 'sosmed_instagram')->update([
            'key' => 'instagram_url',
            'label' => 'URL Instagram'
        ]);

        DB::table('pengaturan')->where('key', 'sosmed_youtube')->update([
            'key' => 'youtube_url',
            'label' => 'URL YouTube'
        ]);
    }
};
