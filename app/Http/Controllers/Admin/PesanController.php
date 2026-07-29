<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesan;
use Illuminate\Http\Request;

class PesanController extends Controller
{
    public function index(Request $request)
    {
        // Stats selalu dari semua data
        $allPesan = Pesan::all();
        $grouped  = $allPesan->groupBy('jenis_pesan');

        $stats = [
            'total'           => $allPesan->count(),
            'pertanyaan_umum' => $grouped->get('pertanyaan_umum', collect())->count(),
            'pengaduan'       => $grouped->get('pengaduan', collect())->count(),
            'kerja_sama'      => $grouped->get('kerja_sama', collect())->count(),
            'pengajuan_acara' => $grouped->get('pengajuan_acara', collect())->count(),
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
        $pesan->delete();
        return redirect()->route('admin.pesan.index')
            ->with('success', 'Pesan berhasil dihapus.');
    }
}
