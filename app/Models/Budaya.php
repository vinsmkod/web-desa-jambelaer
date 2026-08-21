<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Budaya extends Model
{
    protected $table = 'budaya';
    protected $primaryKey = 'budaya_id';

    protected $fillable = ['kategori', 'title', 'slug', 'excerpt', 'desc', 'img', 'urutan'];

    /**
     * Auto-generate slug saat menyimpan jika slug kosong.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($budaya) {
            if (empty($budaya->slug)) {
                $budaya->slug = static::generateUniqueSlug($budaya->title, $budaya->budaya_id ?? null);
            }
        });

        static::updating(function ($budaya) {
            if (empty($budaya->slug)) {
                $budaya->slug = static::generateUniqueSlug($budaya->title, $budaya->budaya_id);
            }
        });
    }

    /**
     * Generate slug unik berdasarkan judul.
     */
    public static function generateUniqueSlug(string $title, ?int $excludeId = null): string
    {
        $baseSlug = Str::slug($title, '-');
        $slug = $baseSlug;
        $counter = 1;

        $query = static::where('slug', $slug);
        if ($excludeId) {
            $query->where('budaya_id', '!=', $excludeId);
        }

        while ($query->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
            $query = static::where('slug', $slug);
            if ($excludeId) {
                $query->where('budaya_id', '!=', $excludeId);
            }
        }

        return $slug;
    }

    /**
     * URL gambar budaya dengan fallback.
     */
    public function getImgUrlAttribute(): string
    {
        if ($this->img) {
            if (filter_var($this->img, FILTER_VALIDATE_URL)) {
                return $this->img;
            }
            if (file_exists(public_path($this->img))) {
                return asset($this->img);
            }
        }

        // Fallback default image
        return "https://images.unsplash.com/photo-1530595467537-0b5996c41f2d?auto=format&fit=crop&w=800&q=80";
    }

    /**
     * Resolusi URL canonical budaya menggunakan slug, fallback ke ID jika slug kosong.
     */
    public function getUrlAttribute(): string
    {
        $identifier = $this->slug ?: $this->budaya_id;
        return url('/budaya/' . $identifier);
    }
}
