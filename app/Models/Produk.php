<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $fillable = [
        'slug', 'title', 'producer', 'price', 'badge',
        'category', 'img', 'desc_short', 'desc_long',
        'details', 'is_active', 'urutan', 'jenis', 'jenis_label',
    ];

    protected $casts = [
        'category'  => 'array',
        'details'   => 'array',
        'is_active' => 'boolean',
    ];
}
