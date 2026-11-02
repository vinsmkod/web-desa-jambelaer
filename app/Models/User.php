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

    public const ROLE_STAFF_DESA        = 'staff_desa';
    public const ROLE_KASI_PEMERINTAHAN = 'kasi_pemerintahan';
    public const ROLE_SEKRETARIS_DESA   = 'sekretaris_desa';
    public const ROLE_KEPALA_DESA       = 'kepala_desa';
    public const ROLE_MASYARAKAT        = 'masyarakat';
    public const ROLE_ADMIN             = 'admin';

    public const PERANGKAT_DESA_ROLES = [
        self::ROLE_STAFF_DESA,
        self::ROLE_KASI_PEMERINTAHAN,
        self::ROLE_SEKRETARIS_DESA,
        self::ROLE_KEPALA_DESA,
        self::ROLE_ADMIN,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'jabatan',
    ];

    /**
     * Cek apakah user adalah bagian dari perangkat desa / admin.
     */
    public function isPerangkatDesa(): bool
    {
        return in_array($this->role, self::PERANGKAT_DESA_ROLES);
    }

    /**
     * Alias backward-compatibility untuk semua staf/admin desa.
     */
    public function isAdmin(): bool
    {
        return $this->isPerangkatDesa();
    }

    public function isStaffDesa(): bool
    {
        return in_array($this->role, [self::ROLE_STAFF_DESA, self::ROLE_ADMIN]);
    }

    public function isKasiPemerintahan(): bool
    {
        return in_array($this->role, [self::ROLE_KASI_PEMERINTAHAN, self::ROLE_ADMIN]);
    }

    public function isSekretarisDesa(): bool
    {
        return in_array($this->role, [self::ROLE_SEKRETARIS_DESA, self::ROLE_ADMIN]);
    }

    public function isKepalaDesa(): bool
    {
        return in_array($this->role, [self::ROLE_KEPALA_DESA, self::ROLE_ADMIN]);
    }

    public function isMasyarakat(): bool
    {
        return $this->role === self::ROLE_MASYARAKAT;
    }

    // ── Matriks Hak Akses Berdasarkan SRS ────────────────────────────────────

    /**
     * SRS-F-002: Kelola Profil Desa (Staff Desa, Kepala Desa)
     */
    public function canManageProfilDesa(): bool
    {
        return in_array($this->role, [self::ROLE_STAFF_DESA, self::ROLE_KEPALA_DESA, self::ROLE_ADMIN]);
    }

    /**
     * SRS-F-003: Kelola Struktur Desa (Staff Desa, Kepala Desa)
     */
    public function canManageStrukturDesa(): bool
    {
        return in_array($this->role, [self::ROLE_STAFF_DESA, self::ROLE_KEPALA_DESA, self::ROLE_ADMIN]);
    }

    /**
     * SRS-F-004: Kelola Data Berita (Staff Desa, Kasi Pemerintahan)
     */
    public function canManageBerita(): bool
    {
        return in_array($this->role, [self::ROLE_STAFF_DESA, self::ROLE_KASI_PEMERINTAHAN, self::ROLE_ADMIN]);
    }

    /**
     * SRS-F-005: Kelola Data UMKM (Staff Desa, Kepala Desa)
     */
    public function canManageUMKM(): bool
    {
        return in_array($this->role, [self::ROLE_STAFF_DESA, self::ROLE_KEPALA_DESA, self::ROLE_ADMIN]);
    }

    /**
     * SRS-F-006: Kelola Data Wisata (Staff Desa, Kepala Desa)
     */
    public function canManageWisata(): bool
    {
        return in_array($this->role, [self::ROLE_STAFF_DESA, self::ROLE_KEPALA_DESA, self::ROLE_ADMIN]);
    }

    /**
     * SRS-F-007: Kelola Data Budaya (Staff Desa, Kepala Desa)
     */
    public function canManageBudaya(): bool
    {
        return in_array($this->role, [self::ROLE_STAFF_DESA, self::ROLE_KEPALA_DESA, self::ROLE_ADMIN]);
    }

    /**
     * SRS-F-008: Kelola Data Galeri (Staff Desa, Kepala Desa)
     */
    public function canManageGaleri(): bool
    {
        return in_array($this->role, [self::ROLE_STAFF_DESA, self::ROLE_KEPALA_DESA, self::ROLE_ADMIN]);
    }

    /**
     * SRS-F-009: Kelola Agenda Acara (Staff Desa, Kepala Desa)
     */
    public function canManageAcara(): bool
    {
        return in_array($this->role, [self::ROLE_STAFF_DESA, self::ROLE_KEPALA_DESA, self::ROLE_ADMIN]);
    }

    /**
     * SRS-F-010: Akses Layanan Surat (Staff Desa, Sekretaris Desa, Kepala Desa)
     */
    public function canAccessSurat(): bool
    {
        return in_array($this->role, [self::ROLE_STAFF_DESA, self::ROLE_SEKRETARIS_DESA, self::ROLE_KEPALA_DESA, self::ROLE_ADMIN]);
    }

    public function canManagePengajuanSurat(): bool
    {
        return $this->canAccessSurat();
    }

    /**
     * SRS-F-010: Memeriksa kelengkapan & memproses surat (Staff Desa)
     */
    public function canProcessSurat(): bool
    {
        return in_array($this->role, [self::ROLE_STAFF_DESA, self::ROLE_ADMIN]);
    }

    /**
     * SRS-F-010: Melakukan verifikasi surat (Sekretaris Desa)
     */
    public function canVerifySurat(): bool
    {
        return in_array($this->role, [self::ROLE_SEKRETARIS_DESA, self::ROLE_ADMIN]);
    }

    /**
     * SRS-F-010: Memberikan persetujuan / penolakan akhir surat (Kepala Desa)
     */
    public function canApproveSurat(): bool
    {
        return in_array($this->role, [self::ROLE_KEPALA_DESA, self::ROLE_ADMIN]);
    }

    /**
     * SRS-F-011: Kelola Pengaduan Masyarakat (Staff Desa, Kepala Desa)
     */
    public function canManagePengaduan(): bool
    {
        return in_array($this->role, [self::ROLE_STAFF_DESA, self::ROLE_KEPALA_DESA, self::ROLE_ADMIN]);
    }

    /**
     * SRS-F-012: Kelola Pertanyaan Umum (Staff Desa, Kepala Desa)
     */
    public function canManagePertanyaan(): bool
    {
        return in_array($this->role, [self::ROLE_STAFF_DESA, self::ROLE_KEPALA_DESA, self::ROLE_ADMIN]);
    }

    /**
     * SRS-F-013: Kelola Pendaftaran UMKM (Staff Desa, Kepala Desa)
     */
    public function canManagePendaftaranUmkm(): bool
    {
        return in_array($this->role, [self::ROLE_STAFF_DESA, self::ROLE_KEPALA_DESA, self::ROLE_ADMIN]);
    }

    /**
     * SRS-F-014: Kelola Pengguna (Staff Desa, Kepala Desa)
     */
    public function canManageUsers(): bool
    {
        return in_array($this->role, [self::ROLE_STAFF_DESA, self::ROLE_KEPALA_DESA, self::ROLE_ADMIN]);
    }

    /**
     * Label representatif untuk role pengguna.
     */
    public function getRoleLabelAttribute(): string
    {
        return match($this->role) {
            self::ROLE_STAFF_DESA        => 'Staff Desa',
            self::ROLE_KASI_PEMERINTAHAN => 'Kasi Pemerintahan',
            self::ROLE_SEKRETARIS_DESA   => 'Sekretaris Desa',
            self::ROLE_KEPALA_DESA       => 'Kepala Desa',
            self::ROLE_MASYARAKAT        => 'Masyarakat',
            self::ROLE_ADMIN             => 'Administrator Sistem',
            default                      => ucfirst(str_replace('_', ' ', $this->role ?? 'Pengguna')),
        };
    }

    /**
     * Badge CSS class untuk label role.
     */
    public function getRoleBadgeClassAttribute(): string
    {
        return match($this->role) {
            self::ROLE_STAFF_DESA        => 'bg-blue-50 text-blue-700 border-blue-200',
            self::ROLE_KASI_PEMERINTAHAN => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            self::ROLE_SEKRETARIS_DESA   => 'bg-purple-50 text-purple-700 border-purple-200',
            self::ROLE_KEPALA_DESA       => 'bg-amber-50 text-amber-700 border-amber-200',
            self::ROLE_MASYARAKAT        => 'bg-stone-50 text-stone-700 border-stone-200',
            default                      => 'bg-slate-50 text-slate-700 border-slate-200',
        };
    }

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
     * Agenda acara yang dibuat oleh admin/user ini.
     */
    public function agendaAcara(): HasMany
    {
        return $this->hasMany(AgendaAcara::class, 'user_id', 'user_id');
    }

    public function pengajuanSurat(): HasMany
    {
        return $this->hasMany(PengajuanSurat::class, 'user_id', 'user_id');
    }

    public function pengaduan(): HasMany
    {
        return $this->hasMany(Pengaduan::class, 'user_id', 'user_id');
    }

    public function pertanyaanUmum(): HasMany
    {
        return $this->hasMany(PertanyaanUmum::class, 'user_id', 'user_id');
    }

    public function pendaftaranUmkm(): HasMany
    {
        return $this->hasMany(PendaftaranUmkm::class, 'user_id', 'user_id');
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
     * UMKM / Produk UMKM yang dibuat/dikelola oleh user/admin ini.
     */
    public function umkm(): HasMany
    {
        return $this->hasMany(UMKM::class, 'created_by', 'user_id');
    }

    public function produk(): HasMany
    {
        return $this->umkm();
    }

    /**
     * Anggota struktur desa yang dibuat oleh user/admin ini.
     */
    public function strukturDesa(): HasMany
    {
        return $this->hasMany(StrukturDesa::class, 'created_by', 'user_id');
    }
}
