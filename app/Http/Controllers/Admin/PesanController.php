<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesan;

class PesanController extends Controller
{
    public function index()
    {
        $pesan = Pesan::whereIn('jenis_pesan', ['pertanyaan_umum', 'pengaduan', 'kerja_sama'])
            ->orWhereNull('jenis_pesan')
            ->latest()
            ->get();

        // Group berdasarkan jenis pesan
        $grouped = $pesan->groupBy('jenis_pesan');

        $stats = [
            'total' => $pesan->count(),
            'pertanyaan_umum' => $grouped->get('pertanyaan_umum', collect())->count(),
            'pengaduan' => $grouped->get('pengaduan', collect())->count(),
            'kerja_sama' => $grouped->get('kerja_sama', collect())->count(),
        ];

        return view('admin.pesan.index', compact('pesan', 'grouped', 'stats'));
    }

    public function show(Pesan $pesan)
    {
        // Exclude pengajuan_acara (has dedicated controller)
        if ($pesan->jenis_pesan === 'pengajuan_acara') {
            abort(404);
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
