<?php

use App\Models\Pengaturan;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Mengisi nilai awal pengaturan halaman Tentang Desa (group 'tentang')
     * dengan konten yang sebelumnya hardcode pada halaman publik.
     */
    public function up(): void
    {
        foreach (Pengaturan::tentangDefaults() as $key => $meta) {
            if (Pengaturan::where('key', $key)->doesntExist()) {
                Pengaturan::create([
                    'key'   => $key,
                    'value' => $meta['value'],
                    'label' => $meta['label'],
                    'group' => 'tentang',
                ]);
            }
        }
    }

    public function down(): void
    {
        Pengaturan::whereIn('key', array_keys(Pengaturan::tentangDefaults()))->delete();
    }
};
