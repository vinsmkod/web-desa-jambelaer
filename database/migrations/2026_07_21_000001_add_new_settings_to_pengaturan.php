<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $newSettings = [
            // Statistik baru
            [
                'key'   => 'stat_kk',
                'value' => '1250',
                'label' => 'Jumlah Kepala Keluarga',
                'group' => 'statistik',
            ],
            [
                'key'   => 'stat_rtrw',
                'value' => '24',
                'label' => 'Jumlah RT/RW',
                'group' => 'statistik',
            ],
            [
                'key'   => 'stat_dusun',
                'value' => '4',
                'label' => 'Jumlah Dusun',
                'group' => 'statistik',
            ],

            // Peta
            [
                'key'   => 'maps_embed_url',
                'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.15!2d107.55!3d-6.55!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e12b6a000001%3A0x0!2zS2FudG9yIERlc2EgSmFtYmVsYWVy!5e0!3m2!1sid!2sid!4v1620000000000!5m2!1sid!2sid',
                'label' => 'Google Maps Embed URL',
                'group' => 'peta',
            ],

            // Media Sosial baru
            [
                'key'   => 'sosmed_tiktok',
                'value' => '',
                'label' => 'TikTok Desa',
                'group' => 'sosmed',
            ],
            [
                'key'   => 'sosmed_whatsapp',
                'value' => '',
                'label' => 'WhatsApp Desa',
                'group' => 'sosmed',
            ],
        ];

        foreach ($newSettings as $setting) {
            DB::table('pengaturan')->insertOrIgnore(array_merge($setting, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }

    public function down(): void
    {
        DB::table('pengaturan')->whereIn('key', [
            'stat_kk', 'stat_rtrw', 'stat_dusun',
            'maps_embed_url',
            'sosmed_tiktok', 'sosmed_whatsapp',
        ])->delete();
    }
};
