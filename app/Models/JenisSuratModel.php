<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisSuratModel extends Model
{
    protected $table = 'jenis_surat';

    protected $fillable = [
        'nama_surat',
        'kode_surat',
        'deskripsi',
        'persyaratan_khusus',
        'is_active',
        'urutan',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan'    => 'integer',
    ];


    public function pengajuanSurats(): HasMany
    {
        return $this->hasMany(PengajuanSuratModel::class, 'jenis_surat_id', 'id');
    }
}
