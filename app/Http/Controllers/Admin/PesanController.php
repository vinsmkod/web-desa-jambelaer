<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PesanController extends Controller
{
    public function index(Request $request)
    {
        // Hitung statistik dengan query agregat (COUNT) bukan load semua data ke memory
        $stats = [
            'total'           => Pesan::count(),
            'pertanyaan_umum' => Pesan::where('jenis_pesan', 'pertanyaan_umum')->count(),
            'pengaduan'       => Pesan::where('jenis_pesan', 'pengaduan')->count(),
            'kerja_sama'      => Pesan::where('jenis_pesan', 'kerja_sama')->count(),
            'pengajuan_acara' => Pesan::where('jenis_pesan', 'pengajuan_acara')->count(),
            'daftar_umkm'     => Pesan::where('jenis_pesan', 'daftar_umkm')->count(),
        ];

        // Paginated data with optional jenis filter
        $query = Pesan::latest();
        $activeTab = $request->get('jenis', 'semua');

        if ($activeTab && $activeTab !== 'semua') {
            $query->where('jenis_pesan', $activeTab);
        }

        $pesan = $query->paginate(5)->withQueryString();

        return view('admin.pesan.index', compact('pesan', 'stats', 'activeTab'));
    }

    public function show(Pesan $pesan)
    {
        // Redirect pengajuan_acara ke halaman detail-nya sendiri
        if ($pesan->jenis_pesan === 'pengajuan_acara') {
            return redirect()->route('admin.pengajuan-acara.show', $pesan);
        }

        $pesan->update(['is_read' => true]);
        return view('admin.pesan.show', compact('pesan'));
    }

    public function markRead(Pesan $pesan)
    {
        $pesan->update(['is_read' => true]);
        return back()->with('success', 'Pesan ditandai sudah dibaca.');
    }

    public function destroy(Pesan $pesan)
    {
        // Hapus foto bukti/produk/dokumen dari storage jika ada
        if ($pesan->foto_bukti) {
            Storage::disk('public')->delete($pesan->foto_bukti);
        }
        if ($pesan->foto_produk) {
            Storage::disk('public')->delete($pesan->foto_produk);
        }
        if ($pesan->dokumen_lampiran) {
            Storage::disk('public')->delete($pesan->dokumen_lampiran);
        }

        $pesan->delete();
        return redirect()->route('admin.pesan.index')
            ->with('success', 'Pesan berhasil dihapus.');
    }
}
