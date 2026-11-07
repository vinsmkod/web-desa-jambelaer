<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengaduanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    /**
     * Tampilkan daftar pengaduan masyarakat (SRS-F-011).
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'semua');
        $search = $request->get('q');

        $query = PengaduanModel::with('user')->latest();

        $stats = [
            'total'    => PengaduanModel::count(),
            'diajukan' => PengaduanModel::whereIn('status', ['diajukan', 'menunggu'])->count(),
            'diproses' => PengaduanModel::where('status', 'diproses')->count(),
            'selesai'  => PengaduanModel::whereIn('status', ['selesai', 'disetujui'])->count(),
            'ditolak'  => PengaduanModel::where('status', 'ditolak')->count(),
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

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_pengaduan', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%")
                  ->orWhere('judul', 'like', "%{$search}%")
                  ->orWhere('isi_pengaduan', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%");
            });
        }

        $pengaduan = $query->paginate(10)->withQueryString();

        return view('admin.pengaduan.index', compact('pengaduan', 'stats', 'status', 'search'));
    }

    /**
     * Tampilkan detail pengaduan dan foto bukti.
     */
    public function show(PengaduanModel $pengaduan)
    {
        $pengaduan->load('user');
        return view('admin.pengaduan.show', compact('pengaduan'));
    }

    /**
     * Berikan tanggapan dan perbarui status pengaduan masyarakat.
     */
    public function updateStatus(Request $request, PengaduanModel $pengaduan)
    {
        $validated = $request->validate([
            'status'          => ['required', 'string', 'in:diajukan,diproses,selesai,ditolak'],
            'tanggapan_admin' => ['nullable', 'string', 'max:2000'],
        ]);

        $pengaduan->update([
            'status'          => $validated['status'],
            'tanggapan_admin' => $validated['tanggapan_admin'] ?? $pengaduan->tanggapan_admin,
        ]);

        return back()->with('success', 'Tanggapan dan status pengaduan (' . $pengaduan->nomor_pengaduan . ') berhasil diperbarui.');
    }

    /**
     * Hapus pengaduan masyarakat.
     */
    public function destroy(PengaduanModel $pengaduan)
    {
        if ($pengaduan->foto_bukti) {
            Storage::disk('public')->delete($pengaduan->foto_bukti);
        }

        $nomor = $pengaduan->nomor_pengaduan;
        $pengaduan->delete();

        return redirect()->route('admin.pengaduan.index')
            ->with('success', 'Data pengaduan (' . $nomor . ') berhasil dihapus.');
    }
}
