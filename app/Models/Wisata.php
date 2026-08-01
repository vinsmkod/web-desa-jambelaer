<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Wisata extends Model
{
    use HasFactory;

    protected $table = 'wisata';

    protected $fillable = [
        'nama',
        'slug',
        'kategori',
        'ringkasan',
        'deskripsi',
        'alamat',
        'maps_iframe',
        'gambar',
        'harga_tiket',
        'jam_operasional',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer',
    ];

    /**
     * URL Gambar Wisata dengan fallback default.
     */
    public function getGambarUrlAttribute(): string
    {
        if ($this->gambar) {
            if (filter_var($this->gambar, FILTER_VALIDATE_URL)) {
                return $this->gambar;
            }
            if (file_exists(public_path('uploads/wisata/' . basename($this->gambar)))) {
                return asset('uploads/wisata/' . basename($this->gambar));
            }
            if (file_exists(public_path($this->gambar))) {
                return asset($this->gambar);
            }
        }

        // Fallback default Unsplash image
        return "https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?auto=format&fit=crop&w=800&q=80";
    }

    /**
     * Label kategori yang ramah dibaca.
     */
    public function getKategoriLabelAttribute(): string
    {
        return match($this->kategori) {
            'alam' => 'Wisata Alam',
            'budaya' => 'Wisata Budaya',
            'kuliner' => 'Wisata Kuliner',
            'buatan' => 'Wisata Buatan',
            'religi' => 'Wisata Religi',
            default => ucfirst($this->kategori),
        };
    }

    /**
     * Daftar opsi kategori wisata.
     */
    public static function kategoriList(): array
    {
        return [
            'alam' => 'Wisata Alam',
            'budaya' => 'Wisata Budaya',
            'kuliner' => 'Wisata Kuliner',
            'buatan' => 'Wisata Buatan',
            'religi' => 'Wisata Religi',
        ];
    }
}
