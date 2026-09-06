<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ── Relationships ────────────────────────────────────────────────────────

    /**
     * Pesan-pesan yang terhubung dengan user ini.
     *
     * Catatan: Mayoritas pesan berasal dari masyarakat umum (tanpa login),
     * sehingga user_id pada pesan umumnya NULL. Relasi ini berguna untuk
     * keperluan traceability jika admin yang sedang login mengirim pesan.
     */
    public function pesan(): HasMany
    {
        return $this->hasMany(Pesan::class, 'user_id', 'user_id');
    }

    /**
     * Berita yang dibuat oleh user/admin ini.
     */
    public function berita(): HasMany
    {
        return $this->hasMany(Berita::class, 'created_by', 'user_id');
    }

    /**
     * Data budaya yang dibuat oleh user/admin ini.
     */
    public function budaya(): HasMany
    {
        return $this->hasMany(Budaya::class, 'created_by', 'user_id');
    }

    /**
     * Destinasi wisata yang dibuat oleh user/admin ini.
     */
    public function wisata(): HasMany
    {
        return $this->hasMany(Wisata::class, 'created_by', 'user_id');
    }

    /**
     * Foto galeri yang dibuat oleh user/admin ini.
     */
    public function galeri(): HasMany
    {
        return $this->hasMany(Galeri::class, 'created_by', 'user_id');
    }

    /**
     * Produk UMKM yang dibuat/dikelola oleh user/admin ini.
     */
    public function produk(): HasMany
    {
        return $this->hasMany(Produk::class, 'created_by', 'user_id');
    }

    /**
     * Anggota struktur desa yang dibuat oleh user/admin ini.
     */
    public function strukturDesa(): HasMany
    {
        return $this->hasMany(StrukturDesa::class, 'created_by', 'user_id');
    }
}

