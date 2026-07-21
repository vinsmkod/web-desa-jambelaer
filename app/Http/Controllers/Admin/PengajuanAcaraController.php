<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesan;
use App\Models\Budaya;
use Illuminate\Http\Request;

class PengajuanAcaraController extends Controller
{
    // Menampilkan daftar pengajuan acara
    public function index()
    {
        $pengajuan = Pesan::where('jenis_pesan', 'pengajuan_acara')
            ->latest()
            ->get();

        $stats = [
            'total' => $pengajuan->count(),
            'menunggu' => $pengajuan->where('status', 'menunggu')->count(),
            'disetujui' => $pengajuan->where('status', 'disetujui')->count(),
            'ditolak' => $pengajuan->where('status', 'ditolak')->count(),
        ];

        return view('admin.pengajuan-acara.index', compact('pengajuan', 'stats'));
    }

    public function show(Pesan $pesan)
    {
        if ($pesan->jenis_pesan !== 'pengajuan_acara') {
            abort(404);
        }

        $pesan->update(['is_read' => true]);
        return view('admin.pengajuan-acara.show', compact('pesan'));
    }

    public function updateStatus(Pesan $pesan, Request $request)
    {
        // Ensure it's a pengajuan_acara
        if ($pesan->jenis_pesan !== 'pengajuan_acara') {
            abort(404);
        }

        $validated = $request->validate([
            'status' => ['required', 'in:menunggu,disetujui,ditolak'],
        ]);

        $pesan->update(['status' => $validated['status']]);

        // Reset publikasi flag jika status berubah dari disetujui
        if ($validated['status'] !== 'disetujui') {
            $pesan->update(['dipublikasikan' => false]);
        }

        $statusLabel = [
            'menunggu' => 'Menunggu',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
        ];

        return back()->with('success', 'Status pengajuan acara berhasil diubah menjadi ' . $statusLabel[$validated['status']] . '.');
    }

    // Publikasikan acara
    public function publikasiAcara(Pesan $pesan, Request $request)
    {
        // Ensure it's a pengajuan_acara and status is disetujui
        if ($pesan->jenis_pesan !== 'pengajuan_acara' || $pesan->status !== 'disetujui') {
            return back()->with('error', 'Hanya pengajuan acara yang disetujui yang dapat dipublikasikan.');
        }

        try {
            // Update pesan flag
            $pesan->update(['dipublikasikan' => true]);

            // Bersihkan jika ada entri di budaya dengan kategori 'Acara Desa'
            Budaya::where('title', $pesan->nama_acara)->where('kategori', 'Acara Desa')->delete();

            return back()->with('success', 'Acara berhasil dipublikasikan ke halaman agenda acara.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mempublikasikan acara: ' . $e->getMessage());
        }
    }

    // Hapus pengajuan acara
    public function destroy(Pesan $pesan)
    {
        if ($pesan->jenis_pesan !== 'pengajuan_acara') {
            abort(404);
        }

        $nama = $pesan->nama_acara;
        $pesan->delete();

        return redirect()->route('admin.pengajuan-acara.index')
            ->with('success', 'Pengajuan acara "' . $nama . '" berhasil dihapus.');
    }
}
