<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $sambutanSettings = [
            [
                'key'   => 'kades_nama',
                'value' => 'Bapak Dedi Suherman, S.E.',
                'label' => 'Nama Kepala Desa & Gelar',
                'group' => 'sambutan',
            ],
            [
                'key'   => 'kades_jabatan',
                'value' => 'Kepala Desa Jambelaer',
                'label' => 'Jabatan Kepala Desa',
                'group' => 'sambutan',
            ],
            [
                'key'   => 'kades_foto',
                'value' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=600&h=600&q=80',
                'label' => 'URL Foto Kepala Desa',
                'group' => 'sambutan',
            ],
            [
                'key'   => 'sambutan_judul',
                'value' => 'Sambutan Kepala Desa',
                'label' => 'Judul Sambutan',
                'group' => 'sambutan',
            ],
            [
                'key'   => 'sambutan_quote',
                'value' => "Assalamu'alaikum Wr. Wb. Atas nama Pemerintah Desa Jambelaer, kami menyambut kehadiran Anda di portal resmi kami dengan penuh rasa syukur dan kebanggaan.",
                'label' => 'Kutipan Pembuka (Quote)',
                'group' => 'sambutan',
            ],
            [
                'key'   => 'sambutan_teks',
                'value' => "Kami berkomitmen untuk terus membangun desa yang mandiri, sejahtera, dan berdaya saing dengan menjunjung tinggi nilai-nilai budaya lokal yang telah diwariskan leluhur. Dengan semangat gotong royong dan kebersamaan, kami yakin Desa Jambelaer akan terus maju dan berkembang.\n\nKami mengundang seluruh masyarakat, perantau, dan mitra usaha untuk berkolaborasi membangun desa yang kita cintai bersama. Portal ini hadir sebagai jembatan informasi yang terbuka bagi semua.",
                'label' => 'Isi Lengkap Teks Sambutan',
                'group' => 'sambutan',
            ],
            [
                'key'   => 'sambutan_tagline',
                'value' => 'Melayani dengan Amanah, Terbuka, dan Transparan.',
                'label' => 'Tagline / Slogan Sambutan',
                'group' => 'sambutan',
            ],
        ];

        foreach ($sambutanSettings as $setting) {
            DB::table('pengaturan')->insertOrIgnore(array_merge($setting, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }

    public function down(): void
    {
        DB::table('pengaturan')->where('group', 'sambutan')->delete();
    }
};
