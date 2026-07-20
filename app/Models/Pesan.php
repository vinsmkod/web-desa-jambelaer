<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesan extends Model
{
    protected $table = 'pesan';

    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'is_read',
        'jenis_pesan',
        'status',
        'dipublikasikan',
        'no_whatsapp',
        'nama_instansi',
        'nama_acara',
        'tanggal_acara',
        'waktu_acara',
        'lokasi_acara',
        'jumlah_peserta',
        'deskripsi_acara',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'dipublikasikan' => 'boolean',
        'tanggal_acara' => 'date',
    ];
}
