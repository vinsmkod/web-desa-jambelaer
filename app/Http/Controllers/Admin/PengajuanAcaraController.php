<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesan;
use Illuminate\Http\Request;

class PengajuanAcaraController extends Controller
{
    // Menampilkan daftar pengajuan acara
    public function index()
    {
        Pesan::cleanupExpiredAcara();

        // Hanya tampilkan yang belum diarsipkan (acara aktif & yang menunggu/ditolak)
        $pengajuan = Pesan::where('jenis_pesan', 'pengajuan_acara')
            ->where(function($q) {
                $q->whereNull('is_archived')->orWhere('is_archived', false);
            })
            ->latest()
            ->get();

        // Arsip — acara yang sudah lewat
        $arsip = Pesan::where('jenis_pesan', 'pengajuan_acara')
            ->where('is_archived', true)
            ->latest()
            ->get();

        $stats = [
            'total'     => $pengajuan->count(),
            'menunggu'  => $pengajuan->where('status', 'menunggu')->count(),
            'disetujui' => $pengajuan->where('status', 'disetujui')->count(),
            'ditolak'   => $pengajuan->where('status', 'ditolak')->count(),
            'arsip'     => $arsip->count(),
        ];

        return view('admin.pengajuan-acara.index', compact('pengajuan', 'arsip', 'stats'));
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
        // Pastikan ini pengajuan_acara dan belum diarsipkan
        if ($pesan->jenis_pesan !== 'pengajuan_acara') {
            abort(404);
        }
        if ($pesan->is_archived) {
            return back()->with('error', 'Pengajuan acara yang sudah diarsipkan tidak dapat diubah statusnya.');
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
            'menunggu'  => 'Menunggu',
            'disetujui' => 'Disetujui',
            'ditolak'   => 'Ditolak',
        ];

        return back()->with('success', 'Status pengajuan acara berhasil diubah menjadi ' . $statusLabel[$validated['status']] . '.');
    }

    // Publikasikan acara
    public function publikasiAcara(Pesan $pesan, Request $request)
    {
        // Pastikan hanya pengajuan acara yang disetujui yang bisa dipublikasikan
        if ($pesan->jenis_pesan !== 'pengajuan_acara' || $pesan->status !== 'disetujui') {
            return back()->with('error', 'Hanya pengajuan acara yang disetujui yang dapat dipublikasikan.');
        }

        try {
            $pesan->update(['dipublikasikan' => true]);

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
