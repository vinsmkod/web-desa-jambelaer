<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TentangMisiModel extends Model
{
    protected $table = 'tentang_misi';
    protected $primaryKey = 'tentang_misi_id';

    protected $fillable = ['isi', 'urutan'];
}
