<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $table = 'pengaturan';
    protected $primaryKey = 'pengaturan_id';

    protected $fillable = ['key', 'value', 'label', 'group'];

    /**
     * Map alias keys to standard database keys for backward compatibility.
     */
    protected static array $aliases = [
        'kontak_telp'   => 'desa_telepon',
        'kontak_email'  => 'desa_email',
        'kontak_alamat' => 'desa_alamat',
        'kontak_jam'    => 'desa_jam_buka',
    ];

    /**
     * Get setting value by key with optional default.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        // 1. Try exact key match
        $setting = static::where('key', $key)->first();

        // 2. Try alias mapping
        if ((!$setting || $setting->value === null || $setting->value === '') && isset(static::$aliases[$key])) {
            $setting = static::where('key', static::$aliases[$key])->first();
        }

        // 3. Try reverse alias mapping
        if (!$setting || $setting->value === null || $setting->value === '') {
            $targetKey = array_search($key, static::$aliases);
            if ($targetKey) {
                $setting = static::where('key', $targetKey)->first();
            }
        }

        return ($setting && $setting->value !== null && $setting->value !== '') ? $setting->value : $default;
    }

    /**
     * Set setting value by key.
     */
    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    /**
     * Ambil value setting secara mentah (null hanya jika record belum ada /
     * value-nya null). Berbeda dengan get(), string kosong tidak diganti default
     * sehingga Administrator dapat menyimpan field opsional yang sengaja dikosongkan.
     */
    public static function getOrNull(string $key): ?string
    {
        $setting = static::where('key', $key)->first();

        return $setting?->value;
    }

    /**
     * Nilai default seluruh konten halaman Tentang Desa (group 'tentang').
     * Sumber tunggal nilai cadangan untuk halaman publik & form admin,
     * sekaligus data awal pada migration pengaturan tentang.
     */
    public static array $tentangDefaults = [
        'tentang_sejarah' => [
            'value' => 'Desa Jambelaer merupakan salah satu desa di wilayah Kecamatan Dawuan yang sebelumnya termasuk ke dalam wilayah Kecamatan Kalijati, berdasarkan Peraturan Daerah Nomor 3 Tahun 2007.',
            'label' => 'Deskripsi Sejarah Desa',
        ],
        'tentang_letak' => [
            'value' => 'Wilayah Desa Jambelaer terletak di Kecamatan Dawuan, Kabupaten Subang, Provinsi Jawa Barat dengan topografi yang didominasi lahan pertanian produktif.',
            'label' => 'Deskripsi Letak Geografis',
        ],
        'tentang_batas_utara' => [
            'value' => 'Desa Cisampih',
            'label' => 'Batas Wilayah Utara',
        ],
        'tentang_batas_timur' => [
            'value' => 'Kelurahan Parung',
            'label' => 'Batas Wilayah Timur',
        ],
        'tentang_batas_selatan' => [
            'value' => 'Desa Curug Agung',
            'label' => 'Batas Wilayah Selatan',
        ],
        'tentang_batas_barat' => [
            'value' => 'Desa Tanggulun Timur',
            'label' => 'Batas Wilayah Barat',
        ],
        'tentang_luas' => [
            'value' => '2.500,366 Ha',
            'label' => 'Total Luas Wilayah',
        ],
        'tentang_potensi_judul' => [
            'value' => 'Potensi Utama',
            'label' => 'Judul Kartu Potensi Utama',
        ],
        'tentang_potensi_subjudul' => [
            'value' => 'Sumber Daya & Ekonomi',
            'label' => 'Subjudul Kartu Potensi Utama',
        ],
        'tentang_potensi_deskripsi' => [
            'value' => 'Desa Jambelaer memiliki potensi pada sektor pertanian, perkebunan, dan UMKM olahan hasil pertanian. Sektor pertanian padi tetap menjadi salah satu mata pencaharian masyarakat, sedangkan sektor perkebunan menghasilkan berbagai komoditas buah unggulan, terutama durian dan pisang. Hasil pertanian dan perkebunan tersebut juga diolah oleh masyarakat menjadi produk bernilai tambah seperti keripik buah, opak, dan rengginang yang dapat mendukung perekonomian masyarakat Desa Jambelaer.',
            'label' => 'Deskripsi Kartu Potensi Utama',
        ],
        'tentang_administrasi_judul' => [
            'value' => 'Administrasi Desa',
            'label' => 'Judul Kartu Administrasi Desa',
        ],
        'tentang_administrasi_subjudul' => [
            'value' => 'Struktur & Wilayah',
            'label' => 'Subjudul Kartu Administrasi Desa',
        ],
        'tentang_administrasi_deskripsi' => [
            'value' => 'Salah satu dari 10 desa di bawah Kecamatan Dawuan dengan pemerintahan yang aktif dan transparan. Desa Jambelaer terdiri dari beberapa dusun dengan RT/RW yang tertata rapi untuk memudahkan pelayanan masyarakat di tingkat paling bawah.',
            'label' => 'Deskripsi Kartu Administrasi Desa',
        ],
        'tentang_visi' => [
            'value' => 'Mewujudkan Desa Jambelaer yang Mandiri, Sejahtera, Berbasis Pertanian Berkelanjutan, dan Teguh Memegang Nilai Budaya Siliwangi pada Tahun 2030.',
            'label' => 'Visi Desa',
        ],
        'tentang_visi_deskripsi' => [
            'value' => 'Visi ini menjadi arah pembangunan desa kami dalam mengoptimalkan potensi bumi, memberdayakan sumber daya manusia, dan menciptakan tata kelola pemerintahan yang bersih dan akuntabel.',
            'label' => 'Deskripsi Visi Desa',
        ],
        'tentang_alamat' => [
            'value' => 'Jl. Raya Jambelaer, Kecamatan Dawuan, Kabupaten Subang, Jawa Barat 41270',
            'label' => 'Alamat Kantor Desa (Section Peta)',
        ],
        'tentang_maps_link' => [
            'value' => 'https://maps.google.com/?q=Kantor+Desa+Jambelaer',
            'label' => 'Link Google Maps (Section Peta)',
        ],
    ];

    public static function tentangDefaults(): array
    {
        return static::$tentangDefaults;
    }
}
