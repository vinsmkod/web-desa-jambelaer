<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Pesan;
use App\Models\Pengaturan;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_produk'   => Produk::count(),
            'produk_aktif'   => Produk::where('is_active', true)->count(),
            'total_pesan'    => Pesan::count(),
            'pesan_belum'    => Pesan::where('is_read', false)->count(),
            // Statistik per jenis pesan
            'pertanyaan_umum' => Pesan::where('jenis_pesan', 'pertanyaan_umum')->count(),
            'pengaduan'       => Pesan::where('jenis_pesan', 'pengaduan')->count(),
            'kerja_sama'      => Pesan::where('jenis_pesan', 'kerja_sama')->count(),
            'pengajuan_acara' => Pesan::where('jenis_pesan', 'pengajuan_acara')->count(),
            'acara_menunggu'  => Pesan::where('jenis_pesan', 'pengajuan_acara')->where('status', 'menunggu')->count(),
            'acara_disetujui' => Pesan::where('jenis_pesan', 'pengajuan_acara')->where('status', 'disetujui')->count(),
        ];

        // Hapus pengajuan acara yang sudah expired (setelah stats dihitung)
        Pesan::cleanupExpiredAcara();

        $pesan_terbaru   = Pesan::latest()->take(5)->get();
        $produk_terbaru  = Produk::latest()->take(5)->get();

        // Chart data: pesan per hari 7 hari terakhir — single query
        $startDate = now()->subDays(6)->startOfDay();
        $rawChart  = Pesan::selectRaw('DATE(created_at) as tgl, COUNT(*) as total')
            ->where('created_at', '>=', $startDate)
            ->groupBy('tgl')
            ->pluck('total', 'tgl');

        $chart_labels = [];
        $chart_data   = [];
        for ($i = 6; $i >= 0; $i--) {
            $date           = now()->subDays($i);
            $chart_labels[] = $date->translatedFormat('D');
            $chart_data[]   = $rawChart[$date->toDateString()] ?? 0;
        }

        return view('admin.dashboard', compact(
            'stats', 'pesan_terbaru', 'produk_terbaru',
            'chart_labels', 'chart_data'
        ));
    }
}
