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
        ];

        $pesan_terbaru   = Pesan::latest()->take(5)->get();
        $produk_terbaru  = Produk::latest()->take(5)->get();

        // Chart data: pesan per hari 7 hari terakhir
        $chart_labels = [];
        $chart_data   = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chart_labels[] = $date->translatedFormat('D');
            $chart_data[]   = Pesan::whereDate('created_at', $date->toDateString())->count();
        }

        return view('admin.dashboard', compact(
            'stats', 'pesan_terbaru', 'produk_terbaru',
            'chart_labels', 'chart_data'
        ));
    }
}
