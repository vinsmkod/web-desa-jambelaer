@extends('admin.layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard Admin')
@section('page_subtitle', 'Ringkasan aktivitas, statistik, dan pengelolaan Portal Desa Jambelaer')

@section('content')

@php
    $hour = now()->hour;
    $greeting = $hour < 11 ? 'Selamat Pagi' : ($hour < 15 ? 'Selamat Siang' : ($hour < 18 ? 'Selamat Sore' : 'Selamat Malam'));
@endphp

<div class="space-y-6">

    {{-- ── Welcome Banner ──────────────────────────────────────────────── --}}
    <div class="relative overflow-hidden rounded-3xl p-6 sm:p-8 shadow-sm border border-forest-800/20"
         style="background: linear-gradient(135deg, #0d2b1d 0%, #1a4731 50%, #245e3f 100%);">
        <div class="absolute -top-12 -right-12 w-56 h-56 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-10 right-1/3 w-40 h-40 bg-amber-400/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2 max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/15 text-xs text-sand-300 font-medium backdrop-blur-sm">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>{{ $greeting }}, <strong class="text-amber-300 font-bold">{{ auth()->user()->name }}</strong> 👋</span>
                </div>
                <h1 class="font-display font-extrabold text-white text-2xl sm:text-3xl tracking-tight leading-tight">
                    Panel Kelola Desa Jambelaer
                </h1>
                <p class="text-white/60 text-xs sm:text-sm font-light leading-relaxed">
                    Kecamatan Dawuan, Kabupaten Subang · Selalu pantau pesan warga, statistik produk UMKM, dan pembaruan konten desa.
                </p>
            </div>

            <div class="flex items-center gap-3 flex-wrap flex-shrink-0">
                <div class="hidden sm:block text-right mr-2">
                    <p class="text-xs text-white/60 font-medium">{{ now()->translatedFormat('l, d F Y') }}</p>
                    <p class="text-sm font-mono font-bold text-amber-300 tracking-wider" id="live-clock">{{ now()->format('H:i:s') }} WIB</p>
                </div>
                <a href="{{ route('home') }}" target="_blank"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/15 hover:bg-white/25 text-white text-xs font-bold transition-all border border-white/20 backdrop-blur-sm shadow-xs">
                    <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                    Lihat Website
                </a>
            </div>
        </div>
    </div>

    {{-- ── Main KPI Cards (4 Grid) ─────────────────────────────────────── --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

        {{-- Pengajuan Surat --}}
        <a href="{{ route('admin.pengajuan-surat.index') }}" class="bg-white border border-slate-200/80 rounded-2xl p-5 hover:border-violet-400 hover:shadow-md transition-all duration-200 group flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Pengajuan Surat</p>
                <h3 class="font-display font-extrabold text-3xl text-slate-900 mt-2 leading-none">{{ number_format($stats['pengajuan_surat']) }}</h3>
                <p class="text-[11px] text-violet-600 font-semibold mt-2.5 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                    <span>{{ $stats['pengajuan_surat_pending'] }} Perlu Diproses</span>
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                </p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-violet-50 border border-violet-100 flex items-center justify-center text-violet-600 flex-shrink-0 group-hover:scale-105 transition-transform">
                <i data-lucide="file-check" class="w-6 h-6"></i>
            </div>
        </a>

        {{-- Pengaduan Warga --}}
        <a href="{{ route('admin.pengaduan.index') }}" class="bg-white border border-slate-200/80 rounded-2xl p-5 hover:border-rose-400 hover:shadow-md transition-all duration-200 group flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Pengaduan Warga</p>
                <h3 class="font-display font-extrabold text-3xl text-slate-900 mt-2 leading-none">{{ number_format($stats['pengaduan']) }}</h3>
                <p class="text-[11px] text-rose-600 font-semibold mt-2.5 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                    <span>{{ $stats['pengaduan_pending'] }} Belum Selesai</span>
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                </p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-rose-50 border border-rose-100 flex items-center justify-center text-rose-600 flex-shrink-0 group-hover:scale-105 transition-transform">
                <i data-lucide="alert-circle" class="w-6 h-6"></i>
            </div>
        </a>

        {{-- Pertanyaan Umum --}}
        <a href="{{ route('admin.pertanyaan-umum.index') }}" class="bg-white border border-slate-200/80 rounded-2xl p-5 hover:border-sky-400 hover:shadow-md transition-all duration-200 group flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Pertanyaan Umum</p>
                <h3 class="font-display font-extrabold text-3xl text-slate-900 mt-2 leading-none">{{ number_format($stats['pertanyaan_umum']) }}</h3>
                <p class="text-[11px] text-sky-600 font-semibold mt-2.5 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                    <span>{{ $stats['pertanyaan_pending'] }} Perlu Dijawab</span>
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                </p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-sky-50 border border-sky-100 flex items-center justify-center text-sky-600 flex-shrink-0 group-hover:scale-105 transition-transform">
                <i data-lucide="help-circle" class="w-6 h-6"></i>
            </div>
        </a>

        {{-- Pendaftaran UMKM --}}
        <a href="{{ route('admin.pendaftaran-umkm.index') }}" class="bg-white border border-slate-200/80 rounded-2xl p-5 hover:border-emerald-400 hover:shadow-md transition-all duration-200 group flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Pendaftaran UMKM</p>
                <h3 class="font-display font-extrabold text-3xl text-slate-900 mt-2 leading-none">{{ number_format($stats['pendaftaran_umkm']) }}</h3>
                <p class="text-[11px] text-emerald-600 font-semibold mt-2.5 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                    <span>{{ $stats['umkm_pending'] }} Menunggu Verifikasi</span>
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                </p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 flex-shrink-0 group-hover:scale-105 transition-transform">
                <i data-lucide="store" class="w-6 h-6"></i>
            </div>
        </a>
    </div>

    {{-- ── Sub Stats: Ringkasan Publik & Informasi ──────────────────────── --}}
    <div class="grid grid-cols-2 lg:grid-cols-3 gap-3">
        <a href="{{ route('admin.produk.index') }}" class="flex items-center gap-3.5 bg-white border border-slate-200/80 rounded-xl px-4 py-3 hover:border-emerald-300 hover:bg-emerald-50/50 transition-all">
            <div class="w-9 h-9 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 flex-shrink-0">
                <i data-lucide="package" class="w-4 h-4"></i>
            </div>
            <div class="min-w-0">
                <p class="text-base font-bold font-display text-slate-900 leading-tight">{{ number_format($stats['total_produk']) }}</p>
                <p class="text-xs text-slate-500 font-medium truncate mt-0.5">Katalog UMKM ({{ $stats['produk_aktif'] }} Aktif)</p>
            </div>
        </a>

        <a href="{{ route('admin.jenis-surat.index') }}" class="flex items-center gap-3.5 bg-white border border-slate-200/80 rounded-xl px-4 py-3 hover:border-indigo-300 hover:bg-indigo-50/50 transition-all">
            <div class="w-9 h-9 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 flex-shrink-0">
                <i data-lucide="file-text" class="w-4 h-4"></i>
            </div>
            <div class="min-w-0">
                <p class="text-base font-bold font-display text-slate-900 leading-tight">{{ \App\Models\JenisSuratModel::count() }}</p>
                <p class="text-xs text-slate-500 font-medium truncate mt-0.5">Master Jenis Surat</p>
            </div>
        </a>

        <a href="{{ route('admin.acara.index') }}" class="flex items-center gap-3.5 bg-white border border-slate-200/80 rounded-xl px-4 py-3 hover:border-amber-300 hover:bg-amber-50/50 transition-all relative">
            <div class="w-9 h-9 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600 flex-shrink-0">
                <i data-lucide="calendar" class="w-4 h-4"></i>
            </div>
            <div class="min-w-0">
                <p class="text-base font-bold font-display text-slate-900 leading-tight">{{ number_format($stats['agenda_acara']) }}</p>
                <p class="text-xs text-slate-500 font-medium truncate mt-0.5">Agenda Acara Publik</p>
            </div>
        </a>
    </div>

    {{-- ── Main Content: Chart + Quick Actions ─────────────────────────── --}}
    <div class="grid lg:grid-cols-3 gap-6">

        {{-- Chart Layanan Masuk --}}
        <div class="lg:col-span-2 bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs flex flex-col">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="font-display font-bold text-slate-900 text-base">Grafik Layanan & Pengajuan Masuk</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Frekuensi permohonan layanan dari warga dalam 7 hari terakhir</p>
                </div>
                <span class="inline-flex items-center gap-1.5 text-xs bg-forest-50 text-forest-700 px-3 py-1 rounded-xl font-semibold border border-forest-200">
                    <span class="w-2 h-2 bg-forest-500 rounded-full animate-pulse"></span>
                    <span>Live Tracking</span>
                </span>
            </div>
            <div class="relative h-56 w-full flex-1">
                <canvas id="msgChart"></canvas>
            </div>
        </div>

        {{-- Aksi Cepat Hub --}}
        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs flex flex-col justify-between space-y-4">
            <div>
                <div class="flex items-center gap-2 pb-3 mb-4 border-b border-slate-100">
                    <div class="w-8 h-8 rounded-xl bg-amber-50 border border-amber-200 flex items-center justify-center text-amber-600">
                        <i data-lucide="zap" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h3 class="font-display font-bold text-slate-900 text-sm">Pintasan Aksi Cepat</h3>
                        <p class="text-[11px] text-slate-400">Akses langsung menu pengelolaan</p>
                    </div>
                </div>

                <div class="space-y-2.5">
                    <a href="{{ route('admin.pengajuan-surat.index') }}"
                       class="flex items-center gap-3 w-full p-3 rounded-2xl bg-violet-50/70 hover:bg-violet-100/70 border border-violet-200/80 text-violet-800 transition-all group">
                        <div class="w-8 h-8 rounded-xl bg-violet-600 text-white flex items-center justify-center flex-shrink-0 shadow-xs">
                            <i data-lucide="file-check" class="w-4 h-4"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold leading-tight">Kelola Pengajuan Surat</p>
                            <p class="text-[10px] text-violet-600 truncate mt-0.5">Verifikasi & cetak surat warga</p>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-violet-400 group-hover:translate-x-1 transition-transform"></i>
                    </a>

                    <a href="{{ route('admin.pendaftaran-umkm.index') }}"
                       class="flex items-center gap-3 w-full p-3 rounded-2xl bg-emerald-50/70 hover:bg-emerald-100/70 border border-emerald-200/80 text-emerald-800 transition-all group">
                        <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center flex-shrink-0 shadow-xs">
                            <i data-lucide="store" class="w-4 h-4"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold leading-tight">Verifikasi Pendaftaran UMKM</p>
                            <p class="text-[10px] text-emerald-600 truncate mt-0.5">Validasi legalitas NIB & halal</p>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-emerald-400 group-hover:translate-x-1 transition-transform"></i>
                    </a>

                    <a href="{{ route('admin.pengaduan.index') }}"
                       class="flex items-center gap-3 w-full p-3 rounded-2xl bg-rose-50/70 hover:bg-rose-100/70 border border-rose-200/80 text-rose-800 transition-all group">
                        <div class="w-8 h-8 rounded-xl bg-rose-600 text-white flex items-center justify-center flex-shrink-0 shadow-xs">
                            <i data-lucide="alert-circle" class="w-4 h-4"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold leading-tight">Tindak Lanjut Pengaduan</p>
                            <p class="text-[10px] text-rose-600 truncate mt-0.5">Respon aspirasi & laporan masyarakat</p>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-rose-400 group-hover:translate-x-1 transition-transform"></i>
                    </a>

                    <a href="{{ route('admin.acara.index') }}"
                       class="flex items-center gap-3 w-full p-3 rounded-2xl bg-amber-50/70 hover:bg-amber-100/70 border border-amber-200/80 text-amber-900 transition-all group">
                        <div class="w-8 h-8 rounded-xl bg-amber-500 text-white flex items-center justify-center flex-shrink-0 shadow-xs">
                            <i data-lucide="calendar" class="w-4 h-4"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold leading-tight">Agenda Acara Desa</p>
                            <p class="text-[10px] text-amber-700 truncate mt-0.5">Kelola agenda kegiatan publik</p>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-amber-500 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>

            <div class="pt-2 text-center border-t border-slate-100">
                <span class="text-[11px] text-slate-400">Versi Portal Desa 2.0 · Panel Layanan Terpadu</span>
            </div>
        </div>
    </div>

    {{-- ── Bottom Tables: Permohonan Layanan Terbaru & Produk Terbaru ────── --}}
    <div class="grid lg:grid-cols-2 gap-6">

        {{-- Permohonan Layanan Terbaru --}}
        <div class="bg-white border border-slate-200/80 rounded-3xl overflow-hidden shadow-xs flex flex-col">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-violet-50 border border-violet-100 flex items-center justify-center text-violet-600">
                        <i data-lucide="inbox" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h3 class="font-display font-bold text-slate-900 text-sm">Layanan Warga Terbaru</h3>
                        <p class="text-[11px] text-slate-400">Pengajuan surat, aduan, pertanyaan & UMKM</p>
                    </div>
                </div>
            </div>

            @if($layanan_terbaru->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 flex-1 text-slate-400">
                <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center mb-3 text-slate-400">
                    <i data-lucide="inbox" class="w-6 h-6"></i>
                </div>
                <p class="text-sm font-medium text-slate-500">Belum ada aktivitas layanan masuk</p>
            </div>
            @else
            <div class="divide-y divide-slate-100 flex-1">
                @foreach($layanan_terbaru as $item)
                <a href="{{ $item->url }}"
                   class="flex items-center gap-3.5 px-6 py-3.5 hover:bg-slate-50/80 transition-colors group">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-forest-700 to-forest-900 flex items-center justify-center text-white font-bold text-xs flex-shrink-0 shadow-xs">
                        {{ strtoupper(substr($item->nama, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] font-semibold px-2 py-0.5 rounded border {{ $item->badge_color }}">{{ $item->badge }}</span>
                            <span class="text-xs font-bold text-slate-800 truncate group-hover:text-forest-800 transition-colors">{{ $item->nama }}</span>
                        </div>
                        <p class="text-xs text-slate-600 truncate mt-1">{{ $item->judul }}</p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <span class="text-[10px] text-slate-400 block">{{ $item->created_at->diffForHumans() }}</span>
                        <span class="text-[10px] font-medium text-slate-500 capitalize">{{ str_replace('_', ' ', $item->status) }}</span>
                    </div>
                </a>
                @endforeach
            </div>
            @endif
        </div>


        {{-- Produk Terbaru --}}
        <div class="bg-white border border-slate-200/80 rounded-3xl overflow-hidden shadow-xs flex flex-col">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-forest-50 border border-forest-100 flex items-center justify-center text-forest-700">
                        <i data-lucide="shopping-bag" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h3 class="font-display font-bold text-slate-900 text-sm">Produk UMKM Terkini</h3>
                        <p class="text-[11px] text-slate-400">Katalog produk warga yang terdaftar</p>
                    </div>
                </div>
                <a href="{{ route('admin.produk.index') }}"
                   class="text-xs text-forest-700 hover:text-forest-900 font-semibold flex items-center gap-1 transition-colors">
                    <span>Kelola Semua</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>

            @if($produk_terbaru->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 flex-1 text-slate-400">
                <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center mb-3 text-slate-400">
                    <i data-lucide="package" class="w-6 h-6"></i>
                </div>
                <p class="text-sm font-medium text-slate-500">Belum ada produk</p>
                <a href="{{ route('admin.produk.create') }}" class="text-xs text-forest-700 font-bold hover:underline mt-1.5">+ Tambah Produk</a>
            </div>
            @else
            <div class="divide-y divide-slate-100 flex-1">
                @foreach($produk_terbaru as $p)
                <a href="{{ route('admin.produk.edit', $p) }}"
                   class="flex items-center gap-3.5 px-6 py-3.5 hover:bg-slate-50/80 transition-colors group">
                    <img src="{{ $p->img_url }}" alt="{{ $p->title }}"
                         class="w-10 h-10 rounded-xl object-cover border border-slate-200 flex-shrink-0 shadow-xs">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-bold text-slate-800 truncate group-hover:text-forest-800 transition-colors">{{ $p->title }}</p>
                        <p class="text-[11px] text-slate-400 truncate mt-0.5">{{ $p->producer }}</p>
                    </div>
                    <div class="text-right flex-shrink-0 ml-2">
                        <p class="text-xs font-bold text-amber-700">{{ $p->price }}</p>
                        <span class="inline-block text-[10px] font-semibold px-2 py-0.5 rounded-full mt-0.5 {{ $p->is_active ? 'bg-forest-50 text-forest-700 border border-forest-200' : 'bg-slate-100 text-slate-500' }}">
                            {{ $p->is_active ? 'Aktif' : 'Draft' }}
                        </span>
                    </div>
                </a>
                @endforeach
            </div>
            @endif
        </div>

    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const canvas = document.getElementById('msgChart');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');

        const gradient = ctx.createLinearGradient(0, 0, 0, 200);
        gradient.addColorStop(0,   'rgba(26, 71, 49, 0.22)');
        gradient.addColorStop(1,   'rgba(26, 71, 49, 0.01)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($chart_labels),
                datasets: [{
                    label: 'Pesan Masuk',
                    data: @json($chart_data),
                    backgroundColor: gradient,
                    borderColor: '#1a4731',
                    borderWidth: 2.5,
                    pointBackgroundColor: '#1a4731',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    tension: 0.35,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0d2b1d',
                        borderColor: '#245e3f',
                        borderWidth: 1,
                        titleColor: '#ffffff',
                        bodyColor: '#aeddc4',
                        padding: 12,
                        cornerRadius: 12,
                        callbacks: {
                            label: (ctx) => ` ${ctx.parsed.y} pesan masuk`,
                        }
                    },
                },
                scales: {
                    x: {
                        grid: { color: 'rgba(148,163,184,0.06)' },
                        ticks: { color: '#64748b', font: { size: 11, weight: '500' } },
                        border: { color: 'transparent' },
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, color: '#64748b', font: { size: 11 } },
                        grid: { color: 'rgba(148,163,184,0.06)' },
                        border: { color: 'transparent' },
                    }
                }
            }
        });
    });

    // Real-time clock update (WIB)
    function updateDashboardClock() {
        const now = new Date();
        // Convert to Asia/Jakarta time (UTC+7)
        const options = { timeZone: 'Asia/Jakarta', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
        const timeString = new Intl.DateTimeFormat('en-GB', options).format(now).replace(/:/g, ':');
        const clockEl = document.getElementById('live-clock');
        if (clockEl) {
            clockEl.textContent = timeString + ' WIB';
        }
    }
    setInterval(updateDashboardClock, 1000);
</script>
@endpush
