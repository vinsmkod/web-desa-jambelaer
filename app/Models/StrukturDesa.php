<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StrukturDesa extends Model
{
    protected $table = 'struktur_desa';
    protected $primaryKey = 'struktur_desa_id';

    protected $fillable = ['created_by', 'nama', 'jabatan', 'foto', 'urutan'];

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

    // ── Relationships ────────────────────────────────────────────────────────

    /**
     * User/Admin yang membuat data struktur desa ini.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }
}

