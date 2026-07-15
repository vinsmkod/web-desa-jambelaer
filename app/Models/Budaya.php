<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budaya extends Model
{
    protected $table = 'budaya';

    protected $fillable = ['kategori', 'title', 'excerpt', 'desc', 'img', 'urutan'];

    /**
     * Get full image URL or a beautiful fallback from Unsplash.
     */
    public function getImgUrlAttribute(): string
    {
        if ($this->img && file_exists(public_path($this->img))) {
            return asset($this->img);
        }
        
        // Fallback default Unsplash images based on category or title
        $query = urlencode($this->kategori . ' ' . $this->title);
        return "https://images.unsplash.com/photo-1530595467537-0b5996c41f2d?auto=format&fit=crop&w=800&q=80";
    }
}
