<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StrukturDesa extends Model
{
    protected $table = 'struktur_desa';

    protected $fillable = ['nama', 'jabatan', 'foto', 'urutan'];

    /**
     * Get the full URL for the foto attribute.
     */
    public function getFotoUrlAttribute(): string
    {
        if ($this->foto && file_exists(public_path($this->foto))) {
            return asset($this->foto);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->nama) . '&background=065f46&color=fff&size=200';
    }
}
