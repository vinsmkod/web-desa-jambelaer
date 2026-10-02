<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanSurat;
use App\Models\JenisSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengajuanSuratController extends Controller
{
    /**
     * Tampilkan daftar permohonan pengajuan surat (SRS-F-010).
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'semua');
        $jenisId = $request->get('jenis_id');
        $search = $request->get('q');

        $query = PengajuanSurat::with(['jenisSurat', 'user'])->latest();

        $stats = [
            'total'        => PengajuanSurat::count(),
            'diajukan'     => PengajuanSurat::whereIn('status', ['diajukan', 'menunggu'])->count(),
            'diverifikasi' => PengajuanSurat::where('status', 'diverifikasi')->count(),
            'diproses'     => PengajuanSurat::where('status', 'diproses')->count(),
            'selesai'      => PengajuanSurat::whereIn('status', ['selesai', 'disetujui'])->count(),
            'ditolak'      => PengajuanSurat::where('status', 'ditolak')->count(),
        ];

        if ($status && $status !== 'semua') {
            if ($status === 'diajukan') {
                $query->whereIn('status', ['diajukan', 'menunggu']);
            } elseif ($status === 'selesai') {
                $query->whereIn('status', ['selesai', 'disetujui']);
            } else {
                $query->where('status', $status);
            }
        }

        if ($jenisId) {
            $query->where('jenis_surat_id', $jenisId);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_pengajuan', 'like', "%{$search}%")
                  ->orWhere('nama_pemohon', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('no_kk', 'like', "%{$search}%")
                  ->orWhere('keperluan', 'like', "%{$search}%");
            });
        }

        $pengajuan = $query->paginate(10)->withQueryString();
        $jenisSurats = JenisSurat::where('is_active', true)->orderBy('nama_surat')->get();

        return view('admin.pengajuan-surat.index', compact('pengajuan', 'stats', 'status', 'jenisId', 'search', 'jenisSurats'));
    }

    /**
     * Tampilkan detail pengajuan surat dan berkas persyaratan.
     */
    public function show(PengajuanSurat $pengajuanSurat)
    {
        $pengajuanSurat->load(['jenisSurat', 'user']);
        return view('admin.pengajuan-surat.show', compact('pengajuanSurat'));
    }

    /**
     * Perbarui status dan catatan admin untuk pengajuan surat.
     */
    public function updateStatus(Request $request, PengajuanSurat $pengajuanSurat)
    {
        $validated = $request->validate([
            'status'        => ['required', 'string', 'in:diajukan,diverifikasi,diproses,selesai,ditolak'],
            'catatan_admin' => ['nullable', 'string', 'max:2000'],
        ]);

        $pengajuanSurat->update([
            'status'        => $validated['status'],
            'catatan_admin' => $validated['catatan_admin'] ?? $pengajuanSurat->catatan_admin,
        ]);

        return back()->with('success', 'Status pengajuan surat (' . $pengajuanSurat->nomor_pengajuan . ') berhasil diperbarui.');
    }

    /**
     * Hapus pengajuan surat beserta berkas fisiknya.
     */
    public function destroy(PengajuanSurat $pengajuanSurat)
    {
        if ($pengajuanSurat->file_ktp) {
            Storage::disk('public')->delete($pengajuanSurat->file_ktp);
        }
        if ($pengajuanSurat->file_kk) {
            Storage::disk('public')->delete($pengajuanSurat->file_kk);
        }
        if ($pengajuanSurat->dokumen_pendukung) {
            Storage::disk('public')->delete($pengajuanSurat->dokumen_pendukung);
        }

        $nomor = $pengajuanSurat->nomor_pengajuan;
        $pengajuanSurat->delete();

        return redirect()->route('admin.pengajuan-surat.index')
            ->with('success', 'Data pengajuan surat (' . $nomor . ') berhasil dihapus.');
    }
}
