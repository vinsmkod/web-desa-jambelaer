<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PengaturanController extends Controller
{
    /**
     * Daftar key yang diizinkan untuk diperbarui melalui form pengaturan.
     * Key di luar daftar ini akan diabaikan (tidak disimpan).
     */
    protected array $allowedKeys = [
        // Identitas Desa
        'desa_nama', 'desa_kecamatan', 'desa_kabupaten', 'desa_provinsi',
        'desa_kodepos', 'desa_alamat',
        // Sambutan Kades
        'kades_nama', 'kades_jabatan', 'kades_foto',
        'sambutan_judul', 'sambutan_quote', 'sambutan_teks', 'sambutan_tagline',
        // Kontak & Operasional
        'desa_telepon', 'desa_email', 'desa_jam_buka',
        'kontak_telp', 'kontak_email', 'kontak_jam',
        // Statistik
        'stat_luas', 'stat_penduduk', 'stat_umkm',
        'stat_kk', 'stat_rtrw', 'stat_dusun',
        // Media Sosial
        'sosmed_instagram', 'sosmed_youtube', 'sosmed_twitter', 'sosmed_tiktok',
        'sosmed_whatsapp',
        // Peta
        'maps_embed_url',
    ];

    public function index()
    {
        $settings = Pengaturan::where('group', '!=', 'tentang')
            ->orderBy('group')
            ->orderBy('id')
            ->get()
            ->groupBy('group');

        return view('admin.pengaturan.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // Hanya proses key yang ada dalam whitelist
        $inputs = collect($request->except(['_token', '_method', 'kades_foto_file']))
            ->only($this->allowedKeys)
            ->toArray();

        // Validasi dasar: semua value harus string, maks 5000 karakter
        $request->validate(
            collect($inputs)->mapWithKeys(fn($v, $k) => [$k => ['nullable', 'string', 'max:5000']])->toArray()
        );

        // Handle upload foto kades
        if ($request->hasFile('kades_foto_file')) {
            // Validasi file upload SEBELUM mengakses file
            $request->validate([
                'kades_foto_file' => ['image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            ]);

            $file = $request->file('kades_foto_file');
            $filename = 'kades_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/kades'), $filename);
            $inputs['kades_foto'] = '/uploads/kades/' . $filename;
        }

        foreach ($inputs as $key => $value) {
            Pengaturan::set($key, $value ?? '');
        }

        return back()->with('success', 'Pengaturan berhasil disimpan!');
    }
}

