<?php

use App\Models\PengaturanModel;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Mengisi nilai awal pengaturan halaman Tentang Desa (group 'tentang')
     * dengan konten yang sebelumnya hardcode pada halaman publik.
     */
    public function up(): void
    {
        foreach (PengaturanModel::tentangDefaults() as $key => $meta) {
            if (PengaturanModel::where('key', $key)->doesntExist()) {
                PengaturanModel::create([
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
        PengaturanModel::whereIn('key', array_keys(PengaturanModel::tentangDefaults()))->delete();
    }
};
