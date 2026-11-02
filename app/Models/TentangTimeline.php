<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TentangTimeline extends Model
{
    protected $table = 'tentang_timeline';
    protected $primaryKey = 'tentang_timeline_id';

    protected $fillable = ['tahun', 'judul', 'deskripsi', 'ikon', 'warna', 'urutan'];

    /**
     * Palet warna tampilan timeline (disesuaikan dengan desain halaman publik).
     * 'dot'  = latar ikon bulatan
     * 'icon' = warna ikon di dalam bulatan
     * 'card' = kelas kartu pembungkus teks
     * 'badge'= warna teks "Tahun ..."
     */
    public static array $palettes = [
        'forest-dark' => ['dot' => 'bg-forest-800', 'icon' => 'text-sand-300', 'card' => 'bg-sand-50 border border-sand-100',   'badge' => 'text-sand-600'],
        'sand'        => ['dot' => 'bg-sand-500',   'icon' => 'text-white',    'card' => 'bg-sand-50 border border-sand-100',   'badge' => 'text-sand-600'],
        'forest'      => ['dot' => 'bg-forest-600', 'icon' => 'text-white',    'card' => 'bg-sand-50 border border-sand-100',   'badge' => 'text-sand-600'],
        'stone'       => ['dot' => 'bg-stone-300',  'icon' => 'text-stone-600','card' => 'bg-forest-50 border border-forest-100','badge' => 'text-forest-600'],
    ];

    /**
     * Ambil kelas-kelas tampilan berdasarkan palet item (default: 'forest').
     */
    public function getPaletteClassesAttribute(): array
    {
        return static::$palettes[$this->warna] ?? static::$palettes['forest'];
    }
}
