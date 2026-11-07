<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UMKMModel;
use App\Models\PengajuanSuratModel;
use App\Models\PengaduanModel;
use App\Models\PertanyaanUmumModel;
use App\Models\PendaftaranUmkmModel;
use App\Models\AcaraModel;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_produk'    => UMKMModel::count(),
            'produk_aktif'    => UMKMModel::where('is_active', true)->count(),
            // 4 Modul Layanan Masyarakat Baru
            'pengajuan_surat' => PengajuanSuratModel::count(),
            'pengajuan_surat_pending' => PengajuanSuratModel::whereIn('status', ['diajukan', 'menunggu'])->count(),
            'pengaduan'       => PengaduanModel::count(),
            'pengaduan_pending' => PengaduanModel::whereIn('status', ['diajukan', 'menunggu'])->count(),
            'pertanyaan_umum' => PertanyaanUmumModel::count(),
            'pertanyaan_pending' => PertanyaanUmumModel::whereIn('status', ['diajukan', 'menunggu'])->count(),
            'pendaftaran_umkm' => PendaftaranUmkmModel::count(),
            'umkm_pending'    => PendaftaranUmkmModel::whereIn('status', ['diajukan', 'menunggu'])->count(),
            'agenda_acara'    => AcaraModel::count(),
        ];


        // Ambil aktivitas terbaru dari 4 layanan
        $surat_terbaru = PengajuanSuratModel::with(['jenisSurat', 'user'])->latest()->take(3)->get()->map(function ($s) {
            return (object)[
                'type' => 'surat',
                'badge' => 'Pengajuan Surat',
                'badge_color' => 'bg-violet-50 text-violet-700 border-violet-200',
                'nomor' => $s->nomor_pengajuan,
                'judul' => $s->jenisSurat ? $s->jenisSurat->nama_surat : 'Pengajuan Surat',
                'nama' => $s->nama_pemohon ?? ($s->user ? $s->user->name : 'Warga'),
                'status' => $s->status,
                'created_at' => $s->created_at,
                'url' => route('admin.pengajuan-surat.show', $s->pengajuan_surat_id),
            ];
        });

        $pengaduan_terbaru = PengaduanModel::with('user')->latest()->take(3)->get()->map(function ($p) {
            return (object)[
                'type' => 'pengaduan',
                'badge' => 'Pengaduan',
                'badge_color' => 'bg-rose-50 text-rose-700 border-rose-200',
                'nomor' => $p->nomor_pengaduan,
                'judul' => $p->judul,
                'nama' => $p->nama ?? ($p->user ? $p->user->name : 'Warga'),
                'status' => $p->status,
                'created_at' => $p->created_at,
                'url' => route('admin.pengaduan.show', $p->pengaduan_id),
            ];
        });

        $pertanyaan_terbaru = PertanyaanUmumModel::with('user')->latest()->take(3)->get()->map(function ($q) {
            return (object)[
                'type' => 'pertanyaan',
                'badge' => 'Pertanyaan Umum',
                'badge_color' => 'bg-sky-50 text-sky-700 border-sky-200',
                'nomor' => $q->nomor_pertanyaan,
                'judul' => $q->subjek,
                'nama' => $q->nama ?? ($q->user ? $q->user->name : 'Warga'),
                'status' => $q->status,
                'created_at' => $q->created_at,
                'url' => route('admin.pertanyaan-umum.show', $q->pertanyaan_id),
            ];
        });

        $umkm_terbaru = PendaftaranUmkmModel::latest()->take(3)->get()->map(function ($u) {
            return (object)[
                'type' => 'umkm',
                'badge' => 'Pendaftaran UMKM',
                'badge_color' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                'nomor' => $u->nomor_pendaftaran,
                'judul' => $u->nama_usaha,
                'nama' => $u->nama_pemilik,
                'status' => $u->status,
                'created_at' => $u->created_at,
                'url' => route('admin.pendaftaran-umkm.show', $u->pendaftaran_umkm_id),
            ];
        });

        $layanan_terbaru = collect()
            ->merge($surat_terbaru)
            ->merge($pengaduan_terbaru)
            ->merge($pertanyaan_terbaru)
            ->merge($umkm_terbaru)
            ->sortByDesc('created_at')
            ->take(6)
            ->values();

        $produk_terbaru  = UMKMModel::latest()->take(5)->get();

        // Chart data 7 hari terakhir dari 4 layanan
        $startDate = now()->subDays(6)->startOfDay();

        $suratChart = PengajuanSuratModel::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as tgl, COUNT(*) as total')
            ->groupBy('tgl')->pluck('total', 'tgl');

        $pengaduanChart = PengaduanModel::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as tgl, COUNT(*) as total')
            ->groupBy('tgl')->pluck('total', 'tgl');

        $pertanyaanChart = PertanyaanUmumModel::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as tgl, COUNT(*) as total')
            ->groupBy('tgl')->pluck('total', 'tgl');

        $umkmChart = PendaftaranUmkmModel::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as tgl, COUNT(*) as total')
            ->groupBy('tgl')->pluck('total', 'tgl');

        $chart_labels = [];
        $chart_data   = [];
        for ($i = 6; $i >= 0; $i--) {
            $date           = now()->subDays($i);
            $tglStr         = $date->toDateString();
            $chart_labels[] = $date->translatedFormat('D');
            $tot = ($suratChart[$tglStr] ?? 0)
                 + ($pengaduanChart[$tglStr] ?? 0)
                 + ($pertanyaanChart[$tglStr] ?? 0)
                 + ($umkmChart[$tglStr] ?? 0);
            $chart_data[]   = $tot;
        }

        return view('admin.dashboard', compact(
            'stats', 'layanan_terbaru', 'produk_terbaru',
            'chart_labels', 'chart_data'
        ));
    }
}
