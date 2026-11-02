<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UMKM;
use App\Models\PengajuanSurat;
use App\Models\Pengaduan;
use App\Models\PertanyaanUmum;
use App\Models\PendaftaranUmkm;
use App\Models\AgendaAcara;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_produk'    => UMKM::count(),
            'produk_aktif'    => UMKM::where('is_active', true)->count(),
            // 4 Modul Layanan Masyarakat Baru
            'pengajuan_surat' => PengajuanSurat::count(),
            'pengajuan_surat_pending' => PengajuanSurat::whereIn('status', ['diajukan', 'menunggu'])->count(),
            'pengaduan'       => Pengaduan::count(),
            'pengaduan_pending' => Pengaduan::whereIn('status', ['diajukan', 'menunggu'])->count(),
            'pertanyaan_umum' => PertanyaanUmum::count(),
            'pertanyaan_pending' => PertanyaanUmum::whereIn('status', ['diajukan', 'menunggu'])->count(),
            'pendaftaran_umkm' => PendaftaranUmkm::count(),
            'umkm_pending'    => PendaftaranUmkm::whereIn('status', ['diajukan', 'menunggu'])->count(),
            'agenda_acara'    => AgendaAcara::count(),
        ];


        // Ambil aktivitas terbaru dari 4 layanan
        $surat_terbaru = PengajuanSurat::with(['jenisSurat', 'user'])->latest()->take(3)->get()->map(function ($s) {
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

        $pengaduan_terbaru = Pengaduan::with('user')->latest()->take(3)->get()->map(function ($p) {
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

        $pertanyaan_terbaru = PertanyaanUmum::with('user')->latest()->take(3)->get()->map(function ($q) {
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

        $umkm_terbaru = PendaftaranUmkm::latest()->take(3)->get()->map(function ($u) {
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

        $produk_terbaru  = UMKM::latest()->take(5)->get();

        // Chart data 7 hari terakhir dari 4 layanan
        $startDate = now()->subDays(6)->startOfDay();

        $suratChart = PengajuanSurat::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as tgl, COUNT(*) as total')
            ->groupBy('tgl')->pluck('total', 'tgl');

        $pengaduanChart = Pengaduan::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as tgl, COUNT(*) as total')
            ->groupBy('tgl')->pluck('total', 'tgl');

        $pertanyaanChart = PertanyaanUmum::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as tgl, COUNT(*) as total')
            ->groupBy('tgl')->pluck('total', 'tgl');

        $umkmChart = PendaftaranUmkm::where('created_at', '>=', $startDate)
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
