@extends('admin.layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Ringkasan aktivitas & pengelolaan Desa Jambelaer')

@section('content')

@php
    $hour = now()->hour;
    $greeting = $hour < 11 ? 'Selamat Pagi' : ($hour < 15 ? 'Selamat Siang' : ($hour < 18 ? 'Selamat Sore' : 'Selamat Malam'));
@endphp

{{-- ── Welcome Banner ───────────────────────────────────────────────────── --}}
<div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-900 via-emerald-800 to-slate-900 border border-emerald-700/40 p-6 mb-6">
    {{-- Decorative blobs --}}
    <div class="absolute -top-10 -right-10 w-48 h-48 bg-emerald-600/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-8 -left-8 w-40 h-40 bg-amber-600/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative flex flex-col sm:flex-row sm:items-center gap-4">
        <div class="flex-1">
            <p class="text-emerald-300 text-sm font-medium mb-1">{{ $greeting }}, {{ auth()->user()->name }} 👋</p>
            <h2 class="font-display font-extrabold text-white text-xl sm:text-2xl leading-tight">
                Panel Admin Desa Jambelaer
            </h2>
            <p class="text-emerald-200/60 text-sm mt-1.5 font-light">
                {{ now()->translatedFormat('l, d F Y') }} · {{ now()->format('H:i') }} WIB
            </p>
        </div>
        <div class="flex items-center gap-2 flex-shrink-0">
            <a href="{{ route('home') }}" target="_blank"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-sm font-semibold transition-all duration-200 border border-white/10">
                <i data-lucide="external-link" class="w-4 h-4"></i>
                Lihat Website
            </a>
        </div>
    </div>
</div>

{{-- ── Stats Grid ─────────────────────────────────────────────────────────── --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

    {{-- Total Produk --}}
    <a href="{{ route('admin.produk.index') }}" class="group stat-card hover:border-emerald-600/50 hover:bg-slate-800 transition-all duration-200 cursor-pointer">
        <div class="w-11 h-11 rounded-xl bg-emerald-600/20 flex items-center justify-center text-emerald-400 flex-shrink-0 group-hover:bg-emerald-600/30 transition-colors">
            <i data-lucide="package" class="w-5 h-5"></i>
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-2xl font-extrabold font-display text-white leading-none">{{ $stats['total_produk'] }}</p>
            <p class="text-xs text-slate-400 mt-1">Total Produk</p>
            <p class="text-xs text-emerald-400 font-semibold mt-1.5 flex items-center gap-1">
                <i data-lucide="arrow-right" class="w-3 h-3"></i> Kelola
            </p>
        </div>
    </a>

    {{-- Produk Aktif --}}
    <div class="stat-card">
        <div class="w-11 h-11 rounded-xl bg-sky-600/20 flex items-center justify-center text-sky-400 flex-shrink-0">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-2xl font-extrabold font-display text-white leading-none">{{ $stats['produk_aktif'] }}</p>
            <p class="text-xs text-slate-400 mt-1">Produk Aktif</p>
            <div class="mt-1.5 h-1.5 bg-slate-700 rounded-full overflow-hidden">
                <div class="h-full bg-sky-500 rounded-full transition-all duration-700"
                     style="width: {{ $stats['total_produk'] > 0 ? round($stats['produk_aktif'] / $stats['total_produk'] * 100) : 0 }}%"></div>
            </div>
        </div>
    </div>

    {{-- Total Pesan --}}
    <a href="{{ route('admin.pesan.index') }}" class="group stat-card hover:border-violet-600/50 hover:bg-slate-800 transition-all duration-200 cursor-pointer">
        <div class="w-11 h-11 rounded-xl bg-violet-600/20 flex items-center justify-center text-violet-400 flex-shrink-0 group-hover:bg-violet-600/30 transition-colors">
            <i data-lucide="mail" class="w-5 h-5"></i>
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-2xl font-extrabold font-display text-white leading-none">{{ $stats['total_pesan'] }}</p>
            <p class="text-xs text-slate-400 mt-1">Total Pesan</p>
            <p class="text-xs text-violet-400 font-semibold mt-1.5 flex items-center gap-1">
                <i data-lucide="arrow-right" class="w-3 h-3"></i> Lihat semua
            </p>
        </div>
    </a>

    {{-- Belum Dibaca --}}
    <a href="{{ route('admin.pesan.index') }}" class="group stat-card {{ $stats['pesan_belum'] > 0 ? 'border-amber-600/40 bg-amber-900/10' : '' }} hover:border-amber-600/60 hover:bg-amber-900/20 transition-all duration-200 cursor-pointer">
        <div class="w-11 h-11 rounded-xl bg-amber-600/20 flex items-center justify-center text-amber-400 flex-shrink-0 group-hover:bg-amber-600/30 transition-colors relative">
            <i data-lucide="bell" class="w-5 h-5"></i>
            @if($stats['pesan_belum'] > 0)
            <span class="absolute -top-1 -right-1 w-4 h-4 bg-amber-500 rounded-full text-white text-[9px] font-bold flex items-center justify-center">{{ $stats['pesan_belum'] }}</span>
            @endif
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-2xl font-extrabold font-display {{ $stats['pesan_belum'] > 0 ? 'text-amber-400' : 'text-white' }} leading-none">{{ $stats['pesan_belum'] }}</p>
            <p class="text-xs text-slate-400 mt-1">Belum Dibaca</p>
            @if($stats['pesan_belum'] > 0)
            <p class="text-xs text-amber-400 font-semibold mt-1.5 flex items-center gap-1 animate-pulse">
                <i data-lucide="alert-circle" class="w-3 h-3"></i> Perlu ditangani
            </p>
            @else
            <p class="text-xs text-slate-500 mt-1.5">Semua sudah dibaca</p>
            @endif
        </div>
    </a>

</div>

{{-- ── Main Area: Chart + Quick Actions ─────────────────────────────────── --}}
<div class="grid lg:grid-cols-3 gap-5 mb-5">

    {{-- Chart --}}
    <div class="lg:col-span-2 bg-slate-900 border border-slate-800 rounded-2xl p-5">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="font-display font-bold text-white text-sm">Grafik Pesan Masuk</h2>
                <p class="text-xs text-slate-500 mt-0.5">7 hari terakhir</p>
            </div>
            <span class="inline-flex items-center gap-1.5 text-xs bg-emerald-600/15 text-emerald-400 px-2.5 py-1 rounded-lg font-semibold border border-emerald-600/20">
                <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-pulse"></span>Live
            </span>
        </div>
        <div class="relative h-52">
            <canvas id="msgChart"></canvas>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5">
        <h2 class="font-display font-bold text-white text-sm mb-4 flex items-center gap-2">
            <i data-lucide="zap" class="w-4 h-4 text-amber-400"></i>
            Aksi Cepat
        </h2>
        <div class="space-y-2.5">
            <a href="{{ route('admin.produk.create') }}"
               class="flex items-center gap-3 w-full px-4 py-3 rounded-xl bg-emerald-600/10 hover:bg-emerald-600/20 border border-emerald-600/20 hover:border-emerald-600/40 text-sm text-emerald-300 hover:text-emerald-200 transition-all duration-200 group">
                <div class="w-7 h-7 rounded-lg bg-emerald-600/20 flex items-center justify-center flex-shrink-0 group-hover:bg-emerald-600/30 transition-colors">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                </div>
                <span class="font-medium">Tambah Produk</span>
                <i data-lucide="chevron-right" class="w-4 h-4 ml-auto opacity-40 group-hover:opacity-100 group-hover:translate-x-0.5 transition-all"></i>
            </a>

            <a href="{{ route('admin.pesan.index') }}"
               class="flex items-center gap-3 w-full px-4 py-3 rounded-xl bg-violet-600/10 hover:bg-violet-600/20 border border-violet-600/20 hover:border-violet-600/40 text-sm text-violet-300 hover:text-violet-200 transition-all duration-200 group">
                <div class="w-7 h-7 rounded-lg bg-violet-600/20 flex items-center justify-center flex-shrink-0 group-hover:bg-violet-600/30 transition-colors relative">
                    <i data-lucide="inbox" class="w-4 h-4"></i>
                    @if($stats['pesan_belum'] > 0)
                    <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-amber-500 rounded-full text-[8px] font-bold text-white flex items-center justify-center">{{ $stats['pesan_belum'] }}</span>
                    @endif
                </div>
                <span class="font-medium">Kotak Masuk</span>
                @if($stats['pesan_belum'] > 0)
                <span class="ml-auto text-[10px] bg-amber-500 text-white font-bold px-1.5 py-0.5 rounded-md">{{ $stats['pesan_belum'] }} baru</span>
                @else
                <i data-lucide="chevron-right" class="w-4 h-4 ml-auto opacity-40 group-hover:opacity-100 group-hover:translate-x-0.5 transition-all"></i>
                @endif
            </a>

            <a href="{{ route('admin.tentang.index') }}"
               class="flex items-center gap-3 w-full px-4 py-3 rounded-xl bg-slate-800 hover:bg-amber-600/10 border border-slate-700 hover:border-amber-600/30 text-sm text-slate-300 hover:text-amber-300 transition-all duration-200 group">
                <div class="w-7 h-7 rounded-lg bg-slate-700 group-hover:bg-amber-600/20 flex items-center justify-center flex-shrink-0 transition-colors">
                    <i data-lucide="file-text" class="w-4 h-4"></i>
                </div>
                <span class="font-medium">Konten Desa</span>
                <i data-lucide="chevron-right" class="w-4 h-4 ml-auto opacity-40 group-hover:opacity-100 group-hover:translate-x-0.5 transition-all"></i>
            </a>

            <a href="{{ route('admin.pengaturan.index') }}"
               class="flex items-center gap-3 w-full px-4 py-3 rounded-xl bg-slate-800 hover:bg-sky-600/10 border border-slate-700 hover:border-sky-600/30 text-sm text-slate-300 hover:text-sky-300 transition-all duration-200 group">
                <div class="w-7 h-7 rounded-lg bg-slate-700 group-hover:bg-sky-600/20 flex items-center justify-center flex-shrink-0 transition-colors">
                    <i data-lucide="settings-2" class="w-4 h-4"></i>
                </div>
                <span class="font-medium">Pengaturan</span>
                <i data-lucide="chevron-right" class="w-4 h-4 ml-auto opacity-40 group-hover:opacity-100 group-hover:translate-x-0.5 transition-all"></i>
            </a>
        </div>
    </div>
</div>

{{-- ── Recent Data: Pesan + Produk ──────────────────────────────────────── --}}
<div class="grid lg:grid-cols-2 gap-5">

    {{-- Pesan Terbaru --}}
    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden flex flex-col">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-800">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg bg-violet-600/20 flex items-center justify-center text-violet-400">
                    <i data-lucide="message-square" class="w-4 h-4"></i>
                </div>
                <div>
                    <h2 class="font-display font-bold text-white text-sm leading-tight">Pesan Terbaru</h2>
                    <p class="text-[11px] text-slate-500">{{ $stats['pesan_belum'] > 0 ? $stats['pesan_belum'].' belum dibaca' : 'Semua sudah dibaca' }}</p>
                </div>
            </div>
            <a href="{{ route('admin.pesan.index') }}"
               class="text-xs text-emerald-400 hover:text-emerald-300 font-semibold flex items-center gap-1 transition-colors">
                Lihat semua <i data-lucide="arrow-right" class="w-3 h-3"></i>
            </a>
        </div>

        @if($pesan_terbaru->isEmpty())
        <div class="flex flex-col items-center justify-center py-16 text-slate-600 flex-1">
            <div class="w-12 h-12 rounded-2xl bg-slate-800 flex items-center justify-center mb-3">
                <i data-lucide="inbox" class="w-6 h-6"></i>
            </div>
            <p class="text-sm font-medium">Kotak masuk kosong</p>
            <p class="text-xs text-slate-700 mt-1">Belum ada pesan dari pengunjung</p>
        </div>
        @else
        <div class="divide-y divide-slate-800/70 flex-1">
            @foreach($pesan_terbaru as $p)
            <a href="{{ route('admin.pesan.show', $p) }}"
               class="flex items-start gap-3 px-5 py-3.5 hover:bg-slate-800/40 transition-all duration-150 group">
                {{-- Avatar --}}
                <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-violet-700 to-violet-400 flex items-center justify-center text-white font-bold text-xs flex-shrink-0 shadow-sm">
                    {{ strtoupper(substr($p->name, 0, 1)) }}
                </div>
                {{-- Content --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-0.5">
                        <p class="text-sm font-semibold text-slate-200 truncate group-hover:text-white transition-colors">{{ $p->name }}</p>
                        @if(!$p->is_read)
                        <span class="w-2 h-2 bg-amber-400 rounded-full flex-shrink-0 shadow shadow-amber-400/50"></span>
                        @endif
                    </div>
                    <p class="text-xs text-slate-500 truncate">{{ $p->subject }}</p>
                </div>
                {{-- Time --}}
                <span class="text-[11px] text-slate-600 flex-shrink-0 mt-0.5">{{ $p->created_at->diffForHumans() }}</span>
            </a>
            @endforeach
        </div>
        @endif
    </div>

    {{-- Produk Terbaru --}}
    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden flex flex-col">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-800">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg bg-emerald-600/20 flex items-center justify-center text-emerald-400">
                    <i data-lucide="shopping-bag" class="w-4 h-4"></i>
                </div>
                <div>
                    <h2 class="font-display font-bold text-white text-sm leading-tight">Produk Terbaru</h2>
                    <p class="text-[11px] text-slate-500">{{ $stats['produk_aktif'] }} aktif dari {{ $stats['total_produk'] }} produk</p>
                </div>
            </div>
            <a href="{{ route('admin.produk.index') }}"
               class="text-xs text-emerald-400 hover:text-emerald-300 font-semibold flex items-center gap-1 transition-colors">
                Lihat semua <i data-lucide="arrow-right" class="w-3 h-3"></i>
            </a>
        </div>

        @if($produk_terbaru->isEmpty())
        <div class="flex flex-col items-center justify-center py-16 text-slate-600 flex-1">
            <div class="w-12 h-12 rounded-2xl bg-slate-800 flex items-center justify-center mb-3">
                <i data-lucide="package" class="w-6 h-6"></i>
            </div>
            <p class="text-sm font-medium">Belum ada produk</p>
            <a href="{{ route('admin.produk.create') }}" class="text-xs text-emerald-400 hover:underline mt-1">+ Tambah sekarang</a>
        </div>
        @else
        <div class="divide-y divide-slate-800/70 flex-1">
            @foreach($produk_terbaru as $p)
            <a href="{{ route('admin.produk.edit', $p) }}"
               class="flex items-center gap-3 px-5 py-3.5 hover:bg-slate-800/40 transition-all duration-150 group">
                {{-- Thumbnail --}}
                <div class="w-11 h-11 rounded-xl overflow-hidden flex-shrink-0 bg-slate-800 border border-slate-700">
                    <img src="{{ $p->img }}" alt="{{ $p->title }}" class="w-full h-full object-cover">
                </div>
                {{-- Info --}}
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-slate-200 truncate group-hover:text-white transition-colors">{{ $p->title }}</p>
                    <p class="text-xs text-slate-500 truncate mt-0.5">{{ $p->producer }}</p>
                </div>
                {{-- Price + Status --}}
                <div class="text-right flex-shrink-0 ml-2">
                    <p class="text-xs font-bold text-amber-400 mb-1">{{ $p->price }}</p>
                    <span class="{{ $p->is_active ? 'badge-read' : 'badge-unread' }}">
                        {{ $p->is_active ? 'Aktif' : 'Non-aktif' }}
                    </span>
                </div>
            </a>
            @endforeach
        </div>
        @endif
    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
    const ctx = document.getElementById('msgChart').getContext('2d');

    // Gradient fill
    const gradient = ctx.createLinearGradient(0, 0, 0, 200);
    gradient.addColorStop(0,   'rgba(16, 185, 129, 0.30)');
    gradient.addColorStop(1,   'rgba(16, 185, 129, 0.02)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chart_labels),
            datasets: [{
                label: 'Pesan',
                data: @json($chart_data),
                backgroundColor: gradient,
                borderColor:     'rgba(16, 185, 129, 0.9)',
                borderWidth: 2.5,
                pointBackgroundColor: 'rgba(16, 185, 129, 1)',
                pointBorderColor:     '#0f172a',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                tension: 0.4,
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
                    backgroundColor: '#1e293b',
                    borderColor:     'rgba(16, 185, 129, 0.3)',
                    borderWidth: 1,
                    titleColor: '#f1f5f9',
                    bodyColor:  '#94a3b8',
                    padding: 10,
                    cornerRadius: 10,
                    callbacks: {
                        label: (ctx) => ` ${ctx.parsed.y} pesan masuk`,
                    }
                },
            },
            scales: {
                x: {
                    grid:  { color: 'rgba(148,163,184,0.06)' },
                    ticks: { color: '#64748b', font: { size: 11 } },
                    border: { color: 'transparent' },
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        color: '#64748b',
                        font: { size: 11 },
                    },
                    grid: { color: 'rgba(148,163,184,0.06)' },
                    border: { color: 'transparent', dash: [4,4] },
                }
            }
        }
    });
</script>
@endpush
