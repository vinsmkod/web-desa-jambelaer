<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';
    protected $primaryKey = 'berita_id';

    protected $fillable = [
        'created_by',
        'judul',
        'slug',
        'ringkasan',
        'konten',
        'gambar',
        'penulis',
        'views',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'views'        => 'integer',
    ];

    /**
     * URL Gambar Berita dengan fallback default.
     */
    public function getGambarUrlAttribute(): string
    {
        if ($this->gambar) {
            if (filter_var($this->gambar, FILTER_VALIDATE_URL)) {
                return $this->gambar;
            }
            if (file_exists(public_path('storage/' . $this->gambar))) {
                return asset('storage/' . $this->gambar);
            }
            if (file_exists(public_path($this->gambar))) {
                return asset($this->gambar);
            }
        }

        // Gambar fallback default Unsplash berkualitas tinggi
        return 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&w=1200&q=80';
    }
    // ── Relationships ────────────────────────────────────────────────────────
    
    /**
     * User/Admin yang membuat berita ini.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }

    /**
     * Catatan: Frontend menggunakan query manual `where('slug', $slug)`,
     * bukan Route Model Binding, sehingga getRouteKeyName() tidak diperlukan.
     * Admin resource binding menggunakan 'id' secara default (sudah benar).
     */
}

