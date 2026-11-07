<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\SecurityHelper;
use App\Models\ProfilDesaModel;
use App\Models\TentangMisiModel;
use App\Models\TentangTimelineModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProfilDesaController extends Controller
{
    // ══════════════════════════════════════════════════════════════════════
    //  KELOLA PROFIL DESA (SRS-F-002)
    //  Konten halaman publik /profil-desa dikelola dari sini.
    // ══════════════════════════════════════════════════════════════════════

    /**
     * Halaman "Kelola Profil Desa" (multi-section dalam satu halaman).
     */
    public function index()
    {
        $settings = ProfilDesaModel::all()->keyBy('key');

        $tentang = [];
        foreach (ProfilDesaModel::tentangDefaults() as $key => $meta) {
            $tentang[$key] = ProfilDesaModel::getOrNull($key) ?? $meta['value'];
        }

        $timelineList       = TentangTimelineModel::orderBy('urutan')->orderBy('tentang_timeline_id')->get();
        $misiList           = TentangMisiModel::orderBy('urutan')->orderBy('tentang_misi_id')->get();
        $nextTimelineUrutan = (TentangTimelineModel::max('urutan') ?? 0) + 1;
        $nextMisiUrutan     = (TentangMisiModel::max('urutan') ?? 0) + 1;

        return view('admin.tentang_desa.index', compact(
            'settings',
            'tentang',
            'timelineList',
            'misiList',
            'nextTimelineUrutan',
            'nextMisiUrutan'
        ));
    }

    public function desaIndex()
    {
        return $this->index();
    }

    /**
     * Re-sequence urutan timeline sejarah menjadi 1, 2, 3... tanpa jeda angka.
     */
    private function resequenceTimeline(): void
    {
        $items = TentangTimelineModel::orderBy('urutan')->orderBy('tentang_timeline_id')->get();
        foreach ($items as $index => $item) {
            if ($item->urutan != ($index + 1)) {
                $item->update(['urutan' => $index + 1]);
            }
        }
    }

    /**
     * Re-sequence urutan misi menjadi 1, 2, 3... tanpa jeda angka.
     */
    private function resequenceMisi(): void
    {
        $items = TentangMisiModel::orderBy('urutan')->orderBy('tentang_misi_id')->get();
        foreach ($items as $index => $item) {
            if ($item->urutan != ($index + 1)) {
                $item->update(['urutan' => $index + 1]);
            }
        }
    }

    /**
     * Section: Sejarah Desa (deskripsi).
     * Route: PUT /admin/tentang-desa/sejarah
     */
    public function desaUpdateSejarah(Request $request)
    {
        $validated = $request->validate([
            'tentang_sejarah' => ['required', 'string', 'max:5000'],
        ]);

        ProfilDesaModel::set('tentang_sejarah', $validated['tentang_sejarah']);

        return back()->with('success', 'Deskripsi Sejarah Desa berhasil disimpan!');
    }

    /**
     * Section: Sejarah Desa → tambah item timeline.
     * Route: POST /admin/tentang-desa/timeline
     */
    public function timelineStore(Request $request)
    {
        $validated = $request->validate([
            'tahun'     => ['required', 'string', 'max:60'],
            'judul'     => ['required', 'string', 'max:150'],
            'deskripsi' => ['required', 'string', 'max:2000'],
            'ikon'      => ['nullable', 'string', 'max:60'],
            'warna'     => ['nullable', 'string', 'max:30', Rule::in(array_keys(TentangTimelineModel::$palettes))],
            'urutan'    => ['nullable', 'integer', 'min:1'],
        ]);

        $maxUrutan           = TentangTimelineModel::max('urutan') ?? 0;
        $validated['urutan'] = ($request->filled('urutan') && $request->urutan > 0) ? $request->urutan : ($maxUrutan + 1);

        // Hanya tag inline aman (strong/b/em/i/br) yang dipertahankan.
        $validated['deskripsi'] = SecurityHelper::sanitizeInlineHtml($validated['deskripsi']);
        $validated['ikon']      = $request->filled('ikon') ? preg_replace('/[^a-z0-9\-_]/i', '', $validated['ikon']) : null;

        TentangTimelineModel::create($validated);
        $this->resequenceTimeline();

        return back()->with('success', 'Timeline sejarah berhasil ditambahkan!');
    }

    /**
     * Section: Sejarah Desa → ubah item timeline.
     * Route: PUT /admin/tentang-desa/timeline/{timeline}
     */
    public function timelineUpdate(Request $request, TentangTimelineModel $timeline)
    {
        $validated = $request->validate([
            'tahun'     => ['required', 'string', 'max:60'],
            'judul'     => ['required', 'string', 'max:150'],
            'deskripsi' => ['required', 'string', 'max:2000'],
            'ikon'      => ['nullable', 'string', 'max:60'],
            'warna'     => ['nullable', 'string', 'max:30', Rule::in(array_keys(TentangTimelineModel::$palettes))],
            'urutan'    => ['nullable', 'integer', 'min:1'],
        ]);

        $validated['urutan'] = $request->filled('urutan') ? $request->urutan : $timeline->urutan;

        // Hanya tag inline aman (strong/b/em/i/br) yang dipertahankan.
        $validated['deskripsi'] = SecurityHelper::sanitizeInlineHtml($validated['deskripsi']);
        $validated['ikon']      = $request->filled('ikon') ? preg_replace('/[^a-z0-9\-_]/i', '', $validated['ikon']) : null;

        $timeline->update($validated);
        $this->resequenceTimeline();

        return back()->with('success', 'Timeline sejarah berhasil diperbarui!');
    }

    /**
     * Section: Sejarah Desa → hapus item timeline.
     * Route: DELETE /admin/tentang-desa/timeline/{timeline}
     */
    public function timelineDestroy(TentangTimelineModel $timeline)
    {
        $timeline->delete();
        $this->resequenceTimeline();

        return back()->with('success', 'Timeline sejarah berhasil dihapus!');
    }

    /**
     * Section: Kepala Desa (nama, jabatan, foto).
     * Route: PUT /admin/tentang-desa/kepala-desa
     */
    public function desaUpdateKades(Request $request)
    {
        $validated = $request->validate([
            'kades_nama'      => ['required', 'string', 'max:150'],
            'kades_jabatan'   => ['required', 'string', 'max:150'],
            'kades_foto_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        ProfilDesaModel::set('kades_nama', $validated['kades_nama']);
        ProfilDesaModel::set('kades_jabatan', $validated['kades_jabatan']);

        // Upload foto kepala desa (sama dengan mekanisme uploads/kades yang sudah ada)
        if ($request->hasFile('kades_foto_file')) {
            $file     = $request->file('kades_foto_file');
            $filename = 'kades_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/kades'), $filename);
            ProfilDesaModel::set('kades_foto', '/uploads/kades/' . $filename);
        }

        return back()->with('success', 'Data Kepala Desa berhasil disimpan!');
    }

    /**
     * Section: Sambutan Kepala Desa.
     * Route: PUT /admin/tentang-desa/sambutan
     */
    public function desaUpdateSambutan(Request $request)
    {
        $validated = $request->validate([
            'sambutan_judul'   => ['required', 'string', 'max:150'],
            'sambutan_quote'   => ['nullable', 'string', 'max:1000'],
            'sambutan_teks'    => ['required', 'string', 'max:5000'],
            'sambutan_tagline' => ['nullable', 'string', 'max:255'],
        ]);

        foreach ($validated as $key => $value) {
            ProfilDesaModel::set($key, $value ?? '');
        }

        return back()->with('success', 'Sambutan Kepala Desa berhasil disimpan!');
    }

    /**
     * Section: Profil Wilayah (letak, batas, luas).
     * Route: PUT /admin/tentang-desa/wilayah
     */
    public function desaUpdateWilayah(Request $request)
    {
        $validated = $request->validate([
            'tentang_letak'         => ['required', 'string', 'max:1000'],
            'tentang_batas_utara'   => ['required', 'string', 'max:255'],
            'tentang_batas_timur'   => ['required', 'string', 'max:255'],
            'tentang_batas_selatan' => ['required', 'string', 'max:255'],
            'tentang_batas_barat'   => ['required', 'string', 'max:255'],
            'tentang_luas'          => ['required', 'string', 'max:100', 'regex:/^[\pL\pN\s\.,\-]+$/u'],
        ]);

        foreach ($validated as $key => $value) {
            ProfilDesaModel::set($key, $value);
        }

        return back()->with('success', 'Profil wilayah desa berhasil disimpan!');
    }

    /**
     * Section: Potensi Utama.
     * Route: PUT /admin/tentang-desa/potensi
     */
    public function desaUpdatePotensi(Request $request)
    {
        $validated = $request->validate([
            'tentang_potensi_judul'     => ['required', 'string', 'max:150'],
            'tentang_potensi_subjudul' => ['nullable', 'string', 'max:100'],
            'tentang_potensi_deskripsi' => ['required', 'string', 'max:2000'],
        ]);

        foreach ($validated as $key => $value) {
            ProfilDesaModel::set($key, $value ?? '');
        }

        return back()->with('success', 'Potensi utama desa berhasil disimpan!');
    }

    /**
     * Section: Administrasi Desa.
     * Route: PUT /admin/tentang-desa/administrasi
     */
    public function desaUpdateAdministrasi(Request $request)
    {
        $validated = $request->validate([
            'tentang_administrasi_judul'     => ['required', 'string', 'max:150'],
            'tentang_administrasi_subjudul' => ['nullable', 'string', 'max:100'],
            'tentang_administrasi_deskripsi' => ['required', 'string', 'max:2000'],
        ]);

        foreach ($validated as $key => $value) {
            ProfilDesaModel::set($key, $value ?? '');
        }

        return back()->with('success', 'Informasi administrasi desa berhasil disimpan!');
    }

    /**
     * Section: Visi (visi + deskripsi).
     * Route: PUT /admin/tentang-desa/visi
     */
    public function desaUpdateVisi(Request $request)
    {
        $validated = $request->validate([
            'tentang_visi'           => ['required', 'string', 'max:1000'],
            'tentang_visi_deskripsi' => ['nullable', 'string', 'max:1000'],
        ]);

        foreach ($validated as $key => $value) {
            ProfilDesaModel::set($key, $value ?? '');
        }

        return back()->with('success', 'Visi desa berhasil disimpan!');
    }

    /**
     * Section: Visi & Misi → tambah item misi.
     * Route: POST /admin/tentang-desa/misi
     */
    public function misiStore(Request $request)
    {
        $validated = $request->validate([
            'isi'    => ['required', 'string', 'max:1000'],
            'urutan' => ['nullable', 'integer', 'min:1'],
        ]);

        $maxUrutan           = TentangMisiModel::max('urutan') ?? 0;
        $validated['urutan'] = ($request->filled('urutan') && $request->urutan > 0) ? $request->urutan : ($maxUrutan + 1);

        TentangMisiModel::create($validated);
        $this->resequenceMisi();

        return back()->with('success', 'Misi berhasil ditambahkan!');
    }

    /**
     * Section: Visi & Misi → ubah item misi.
     * Route: PUT /admin/tentang-desa/misi/{misi}
     */
    public function misiUpdate(Request $request, TentangMisiModel $misi)
    {
        $validated = $request->validate([
            'isi'    => ['required', 'string', 'max:1000'],
            'urutan' => ['nullable', 'integer', 'min:1'],
        ]);

        $validated['urutan'] = $request->filled('urutan') ? $request->urutan : $misi->urutan;

        $misi->update($validated);
        $this->resequenceMisi();

        return back()->with('success', 'Misi berhasil diperbarui!');
    }

    /**
     * Section: Visi & Misi → hapus item misi.
     * Route: DELETE /admin/tentang-desa/misi/{misi}
     */
    public function misiDestroy(TentangMisiModel $misi)
    {
        $misi->delete();
        $this->resequenceMisi();

        return back()->with('success', 'Misi berhasil dihapus!');
    }

    /**
     * Section: Peta Wilayah (embed Google Maps, alamat, link).
     * Route: PUT /admin/tentang-desa/peta
     */
    public function desaUpdatePeta(Request $request)
    {
        $validated = $request->validate([
            'maps_embed_url'    => ['nullable', 'string', 'max:2000'],
            'tentang_alamat'    => ['required', 'string', 'max:255'],
            'tentang_maps_link' => ['required', 'string', 'max:500', 'url'],
        ]);

        // Sanitasi iframe Google Maps dengan mekanisme yang sudah tersedia (SecurityHelper)
        $sanitized = SecurityHelper::sanitizeMapsIframe($request->maps_embed_url);
        if (!empty($request->maps_embed_url) && empty($sanitized)) {
            return back()
                ->withErrors(['maps_embed_url' => 'Embed Google Maps tidak valid. Hanya iframe/URL Google Maps yang diizinkan.'])
                ->withInput();
        }

        ProfilDesaModel::set('maps_embed_url', $sanitized ?? '');
        ProfilDesaModel::set('tentang_alamat', $validated['tentang_alamat']);
        ProfilDesaModel::set('tentang_maps_link', $validated['tentang_maps_link']);

        return back()->with('success', 'Peta wilayah desa berhasil disimpan!');
    }


}
