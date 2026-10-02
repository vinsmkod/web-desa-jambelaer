<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisSurat;
use Illuminate\Http\Request;

class JenisSuratController extends Controller
{
    /**
     * Tampilkan daftar jenis surat yang tersedia di desa.
     */
    public function index()
    {
        $jenisSurats = JenisSurat::withCount('pengajuanSurats')
            ->orderBy('urutan')
            ->orderBy('nama_surat')
            ->get();

        return view('admin.jenis-surat.index', compact('jenisSurats'));
    }

    /**
     * Tampilkan form tambah jenis surat baru.
     */
    public function create()
    {
        return view('admin.jenis-surat.create');
    }

    /**
     * Tampilkan detail jenis surat (redirect ke edit).
     */
    public function show(JenisSurat $jenisSurat)
    {
        return redirect()->route('admin.jenis-surat.edit', $jenisSurat);
    }

    /**
     * Tampilkan form edit jenis surat.
     */
    public function edit(JenisSurat $jenisSurat)
    {
        return view('admin.jenis-surat.edit', compact('jenisSurat'));
    }

    /**
     * Simpan jenis surat baru yang dapat diajukan masyarakat.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_surat'         => ['required', 'string', 'max:255'],
            'kode_surat'         => ['nullable', 'string', 'max:50'],
            'deskripsi'          => ['nullable', 'string', 'max:1000'],
            'persyaratan_khusus' => ['nullable', 'string', 'max:1000'],
            'urutan'             => ['nullable', 'integer', 'min:0'],
            'is_active'          => ['nullable', 'in:0,1'],
        ]);

        $validated['is_active'] = ($request->input('is_active', '0') === '1');
        $validated['urutan'] = $validated['urutan'] ?? (JenisSurat::max('urutan') + 1);

        JenisSurat::create($validated);

        return redirect()->route('admin.jenis-surat.index')
            ->with('success', 'Jenis surat "' . $validated['nama_surat'] . '" berhasil ditambahkan ke sistem pelayanan.');
    }

    /**
     * Perbarui data jenis surat.
     */
    public function update(Request $request, JenisSurat $jenisSurat)
    {
        $validated = $request->validate([
            'nama_surat'         => ['required', 'string', 'max:255'],
            'kode_surat'         => ['nullable', 'string', 'max:50'],
            'deskripsi'          => ['nullable', 'string', 'max:1000'],
            'persyaratan_khusus' => ['nullable', 'string', 'max:1000'],
            'urutan'             => ['nullable', 'integer', 'min:0'],
            'is_active'          => ['nullable', 'in:0,1'],
        ]);

        $validated['is_active'] = ($request->input('is_active', '0') === '1');

        $jenisSurat->update($validated);

        return redirect()->route('admin.jenis-surat.index')
            ->with('success', 'Data jenis surat "' . $jenisSurat->nama_surat . '" berhasil diperbarui.');
    }

    /**
     * Hapus jenis surat.
     */
    public function destroy(JenisSurat $jenisSurat)
    {
        $count = $jenisSurat->pengajuanSurats()->count() + $jenisSurat->pesan()->count();
        if ($count > 0) {
            // Jika sudah ada histori pengajuan, cukup nonaktifkan agar integritas riwayat tetap utuh
            $jenisSurat->update(['is_active' => false]);
            return back()->with('warning', 'Jenis surat memiliki ' . $count . ' riwayat pengajuan sehingga dinonaktifkan dari pilihan warga (tidak dihapus permanen agar data riwayat aman).');
        }

        $nama = $jenisSurat->nama_surat;
        $jenisSurat->delete();

        return back()->with('success', 'Jenis surat "' . $nama . '" berhasil dihapus.');
    }

    /**
     * Toggle status aktif/non-aktif jenis surat.
     */
    public function toggleActive(JenisSurat $jenisSurat)
    {
        $jenisSurat->update(['is_active' => !$jenisSurat->is_active]);

        $statusText = $jenisSurat->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', 'Jenis surat "' . $jenisSurat->nama_surat . '" berhasil ' . $statusText . '.');
    }
}
