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
}
