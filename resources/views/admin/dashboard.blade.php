@extends('admin.layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Ringkasan aktivitas & pengelolaan Desa Jambelaer')

@section('content')

@php
    $hour = now()->hour;
    $greeting = $hour < 11 ? 'Selamat Pagi' : ($hour < 15 ? 'Selamat Siang' : ($hour < 18 ? 'Selamat Sore' : 'Selamat Malam'));
@endphp

{{-- ── Welcome Banner ──────────────────────────────────────────────── --}}
<div class="relative overflow-hidden rounded-2xl p-6 mb-6" style="background: linear-gradient(135deg, #1a4731 0%, #245e3f 60%, #2d7a52 100%);">
    <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/5 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-1/3 w-32 h-32 bg-amber-400/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative flex flex-col sm:flex-row sm:items-center gap-4">
        <div class="flex-1">
            <p class="text-green-200 text-sm font-medium mb-1 flex items-center gap-2">
                <span>{{ $greeting }}, <span class="font-bold text-slate-900">{{ auth()->user()->name }}</span></span>
                <span>👋</span>
            </p>
            <h2 class="font-display font-extrabold text-white text-xl sm:text-2xl leading-tight">
                Panel Admin Desa Jambelaer
            </h2>
            <p class="text-white/50 text-xs mt-1.5 font-light">
                {{ now()->translatedFormat('l, d F Y') }} · {{ now()->format('H:i') }} WIB
            </p>
        </div>
        <div class="flex items-center gap-2 flex-shrink-0">
            <a href="{{ route('home') }}" target="_blank"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/15 hover:bg-white/25 text-white text-sm font-semibold transition-all border border-white/20">
                <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                Lihat Website
            </a>
        </div>
    </div>
</div>

{{-- ── Stats Row 1: Main KPIs ──────────────────────────────────────── --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-4">

    {{-- Total Produk --}}
    <a href="{{ route('admin.produk.index') }}" class="bg-white border border-slate-200 rounded-2xl p-5 flex items-start gap-4 hover:border-forest-500/40 hover:shadow-sm transition-all cursor-pointer group">
        <div class="w-11 h-11 rounded-xl bg-forest-50 border border-forest-200 flex items-center justify-center text-forest-700 flex-shrink-0 group-hover:bg-forest-100 transition-colors">
            <i data-lucide="package" class="w-5 h-5"></i>
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-2xl font-extrabold font-display text-slate-900 leading-none">{{ $stats['total_produk'] }}</p>
            <p class="text-xs text-slate-500 mt-1">Total Produk</p>
            <p class="text-[11px] text-forest-600 font-semibold mt-1.5 flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                <i data-lucide="arrow-right" class="w-3 h-3"></i> Kelola
            </p>
        </div>
    </a>

    {{-- Produk Aktif --}}
    <div class="bg-white border border-slate-200 rounded-2xl p-5 flex items-start gap-4">
        <div class="w-11 h-11 rounded-xl bg-sky-50 border border-sky-200 flex items-center justify-center text-sky-600 flex-shrink-0">
            <i data-lucide="check-circle-2" class="w-5 h-5"></i>
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-2xl font-extrabold font-display text-slate-900 leading-none">{{ $stats['produk_aktif'] }}</p>
            <p class="text-xs text-slate-500 mt-1">Produk Aktif</p>
            <div class="mt-2 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full bg-sky-500 rounded-full transition-all"
                     style="width: {{ $stats['total_produk'] > 0 ? round($stats['produk_aktif'] / $stats['total_produk'] * 100) : 0 }}%"></div>
            </div>
        </div>
    </div>

    {{-- Total Pesan --}}
    <a href="{{ route('admin.pesan.index') }}" class="bg-white border border-slate-200 rounded-2xl p-5 flex items-start gap-4 hover:border-violet-400/40 hover:shadow-sm transition-all cursor-pointer group">
        <div class="w-11 h-11 rounded-xl bg-violet-50 border border-violet-200 flex items-center justify-center text-violet-600 flex-shrink-0 group-hover:bg-violet-100 transition-colors">
            <i data-lucide="mail" class="w-5 h-5"></i>
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-2xl font-extrabold font-display text-slate-900 leading-none">{{ $stats['total_pesan'] }}</p>
            <p class="text-xs text-slate-500 mt-1">Total Pesan</p>
            <p class="text-[11px] text-violet-600 font-semibold mt-1.5 flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                <i data-lucide="arrow-right" class="w-3 h-3"></i> Lihat semua
            </p>
        </div>
    </a>

    {{-- Belum Dibaca --}}
    <a href="{{ route('admin.pesan.index') }}"
       class="bg-white border {{ $stats['pesan_belum'] > 0 ? 'border-amber-300 bg-amber-50' : 'border-slate-200' }} rounded-2xl p-5 flex items-start gap-4 hover:shadow-sm transition-all cursor-pointer group">
        <div class="w-11 h-11 rounded-xl {{ $stats['pesan_belum'] > 0 ? 'bg-amber-100 border-amber-200' : 'bg-slate-50 border-slate-200' }} border flex items-center justify-center text-amber-600 flex-shrink-0 relative">
            <i data-lucide="bell" class="w-5 h-5"></i>
            @if($stats['pesan_belum'] > 0)
            <span class="absolute -top-1 -right-1 w-4 h-4 bg-amber-500 rounded-full text-white text-[9px] font-bold flex items-center justify-center ring-2 ring-white">{{ $stats['pesan_belum'] }}</span>
            @endif
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-2xl font-extrabold font-display {{ $stats['pesan_belum'] > 0 ? 'text-amber-600' : 'text-slate-900' }} leading-none">{{ $stats['pesan_belum'] }}</p>
            <p class="text-xs text-slate-500 mt-1">Belum Dibaca</p>
            @if($stats['pesan_belum'] > 0)
            <p class="text-[11px] text-amber-600 font-semibold mt-1.5 flex items-center gap-1 animate-pulse">
                <i data-lucide="alert-circle" class="w-3 h-3"></i> Perlu ditangani
            </p>
            @endif
        </div>
    </a>
</div>

{{-- ── Stats Row 2: Pesan per Jenis ────────────────────────────────── --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-5">
    <a href="{{ route('admin.pesan.index') }}" class="flex items-center gap-3 bg-white border border-slate-200 rounded-xl px-4 py-3 hover:border-sky-300 hover:bg-sky-50 transition-all group">
        <div class="w-8 h-8 rounded-lg bg-sky-50 border border-sky-200 flex items-center justify-center text-sky-600 flex-shrink-0">
            <i data-lucide="help-circle" class="w-4 h-4"></i>
        </div>
        <div>
            <p class="text-base font-bold font-display text-slate-900 leading-none">{{ $stats['pertanyaan_umum'] }}</p>
            <p class="text-[11px] text-slate-500 mt-0.5">Pertanyaan</p>
        </div>
    </a>
    <a href="{{ route('admin.pesan.index') }}" class="flex items-center gap-3 bg-white border border-slate-200 rounded-xl px-4 py-3 hover:border-red-300 hover:bg-red-50 transition-all group">
        <div class="w-8 h-8 rounded-lg bg-red-50 border border-red-200 flex items-center justify-center text-red-500 flex-shrink-0">
            <i data-lucide="alert-triangle" class="w-4 h-4"></i>
        </div>
        <div>
            <p class="text-base font-bold font-display text-slate-900 leading-none">{{ $stats['pengaduan'] }}</p>
            <p class="text-[11px] text-slate-500 mt-0.5">Pengaduan</p>
        </div>
    </a>
    <a href="{{ route('admin.pesan.index') }}" class="flex items-center gap-3 bg-white border border-slate-200 rounded-xl px-4 py-3 hover:border-cyan-300 hover:bg-cyan-50 transition-all group">
        <div class="w-8 h-8 rounded-lg bg-cyan-50 border border-cyan-200 flex items-center justify-center text-cyan-600 flex-shrink-0">
            <i data-lucide="handshake" class="w-4 h-4"></i>
        </div>
        <div>
            <p class="text-base font-bold font-display text-slate-900 leading-none">{{ $stats['kerja_sama'] }}</p>
            <p class="text-[11px] text-slate-500 mt-0.5">Kerja Sama</p>
        </div>
    </a>
    <a href="{{ route('admin.pengajuan-acara.index') }}" class="flex items-center gap-3 bg-white border border-slate-200 rounded-xl px-4 py-3 hover:border-amber-300 hover:bg-amber-50 transition-all group">
        <div class="w-8 h-8 rounded-lg bg-amber-50 border border-amber-200 flex items-center justify-center text-amber-600 flex-shrink-0">
            <i data-lucide="calendar-check" class="w-4 h-4"></i>
        </div>
        <div>
            <p class="text-base font-bold font-display text-slate-900 leading-none">{{ $stats['pengajuan_acara'] }}</p>
            <p class="text-[11px] text-slate-500 mt-0.5">Pengajuan Acara</p>
        </div>
    </a>
</div>

{{-- ── Main Area: Chart + Quick Actions ──────────────────────────── --}}
<div class="grid lg:grid-cols-3 gap-4 mb-4">

    {{-- Chart --}}
    <div class="lg:col-span-2 bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="font-display font-bold text-slate-900 text-sm">Grafik Pesan Masuk</h2>
                <p class="text-xs text-slate-400 mt-0.5">7 hari terakhir</p>
            </div>
            <span class="inline-flex items-center gap-1.5 text-[11px] bg-forest-50 text-forest-700 px-2.5 py-1 rounded-lg font-semibold border border-forest-200">
                <span class="w-1.5 h-1.5 bg-forest-500 rounded-full animate-pulse"></span>Live
            </span>
        </div>
        <div class="relative h-48">
            <canvas id="msgChart"></canvas>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
        <h2 class="font-display font-bold text-slate-900 text-sm mb-4 flex items-center gap-2">
            <i data-lucide="zap" class="w-4 h-4 text-amber-500"></i>
            Aksi Cepat
        </h2>
        <div class="space-y-2">
            <a href="{{ route('admin.produk.create') }}"
               class="flex items-center gap-3 w-full px-3.5 py-2.5 rounded-xl bg-forest-50 hover:bg-forest-100 border border-forest-200 hover:border-forest-300 text-sm text-forest-700 transition-all group">
                <div class="w-7 h-7 rounded-lg bg-forest-100 flex items-center justify-center flex-shrink-0">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                </div>
                <span class="font-medium text-sm">Tambah Produk</span>
                <i data-lucide="chevron-right" class="w-4 h-4 ml-auto text-forest-400 group-hover:translate-x-0.5 transition-all"></i>
            </a>

            <a href="{{ route('admin.pesan.index') }}"
               class="flex items-center gap-3 w-full px-3.5 py-2.5 rounded-xl bg-violet-50 hover:bg-violet-100 border border-violet-200 hover:border-violet-300 text-sm text-violet-700 transition-all group">
                <div class="w-7 h-7 rounded-lg bg-violet-100 flex items-center justify-center flex-shrink-0 relative">
                    <i data-lucide="inbox" class="w-4 h-4"></i>
                    @if($stats['pesan_belum'] > 0)
                    <span class="absolute -top-1 -right-1 w-3 h-3 bg-amber-500 rounded-full text-[8px] font-bold text-white flex items-center justify-center">{{ $stats['pesan_belum'] }}</span>
                    @endif
                </div>
                <span class="font-medium text-sm">Kotak Masuk</span>
                @if($stats['pesan_belum'] > 0)
                <span class="ml-auto text-[10px] bg-amber-500 text-white font-bold px-1.5 py-0.5 rounded-md">{{ $stats['pesan_belum'] }} baru</span>
                @else
                <i data-lucide="chevron-right" class="w-4 h-4 ml-auto text-violet-400 transition-all"></i>
                @endif
            </a>

            <a href="{{ route('admin.tentang.index') }}"
               class="flex items-center gap-3 w-full px-3.5 py-2.5 rounded-xl bg-slate-50 hover:bg-amber-50 border border-slate-200 hover:border-amber-200 text-sm text-slate-700 hover:text-amber-700 transition-all group">
                <div class="w-7 h-7 rounded-lg bg-slate-100 group-hover:bg-amber-100 flex items-center justify-center flex-shrink-0 transition-colors">
                    <i data-lucide="users-2" class="w-4 h-4"></i>
                </div>
                <span class="font-medium text-sm">Struktur Desa</span>
                <i data-lucide="chevron-right" class="w-4 h-4 ml-auto text-slate-400 transition-all"></i>
            </a>

            <a href="{{ route('admin.pengaturan.index') }}"
               class="flex items-center gap-3 w-full px-3.5 py-2.5 rounded-xl bg-slate-50 hover:bg-sky-50 border border-slate-200 hover:border-sky-200 text-sm text-slate-700 hover:text-sky-700 transition-all group">
                <div class="w-7 h-7 rounded-lg bg-slate-100 group-hover:bg-sky-100 flex items-center justify-center flex-shrink-0 transition-colors">
                    <i data-lucide="settings-2" class="w-4 h-4"></i>
                </div>
                <span class="font-medium text-sm">Pengaturan</span>
                <i data-lucide="chevron-right" class="w-4 h-4 ml-auto text-slate-400 transition-all"></i>
            </a>
        </div>
    </div>
</div>

{{-- ── Recent Data: Pesan + Produk ─────────────────────────────────── --}}
<div class="grid lg:grid-cols-2 gap-4">

    {{-- Pesan Terbaru --}}
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm flex flex-col">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg bg-violet-50 border border-violet-200 flex items-center justify-center text-violet-600">
                    <i data-lucide="message-square" class="w-4 h-4"></i>
                </div>
                <div>
                    <h2 class="font-display font-bold text-slate-900 text-sm leading-tight">Pesan Terbaru</h2>
                    <p class="text-[11px] text-slate-400">{{ $stats['pesan_belum'] > 0 ? $stats['pesan_belum'].' belum dibaca' : 'Semua sudah dibaca' }}</p>
                </div>
            </div>
            <a href="{{ route('admin.pesan.index') }}"
               class="text-[11px] text-forest-700 hover:text-forest-800 font-semibold flex items-center gap-1 transition-colors">
                Lihat semua <i data-lucide="arrow-right" class="w-3 h-3"></i>
            </a>
        </div>

        @if($pesan_terbaru->isEmpty())
        <div class="flex flex-col items-center justify-center py-14 flex-1">
            <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center mb-3 text-slate-400">
                <i data-lucide="inbox" class="w-5 h-5"></i>
            </div>
            <p class="text-sm font-medium text-slate-500">Kotak masuk kosong</p>
        </div>
        @else
        <div class="divide-y divide-slate-100 flex-1">
            @foreach($pesan_terbaru as $p)
            <a href="{{ route('admin.pesan.show', $p) }}"
               class="flex items-center gap-3 px-5 py-3 hover:bg-slate-50 transition-all group">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-violet-500 to-violet-700 flex items-center justify-center text-white font-bold text-xs flex-shrink-0">
                    {{ strtoupper(substr($p->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2">
                        <p class="text-sm font-semibold text-slate-800 truncate group-hover:text-slate-900 transition-colors">{{ $p->name }}</p>
                        @if(!$p->is_read)
                        <span class="w-1.5 h-1.5 bg-amber-400 rounded-full flex-shrink-0"></span>
                        @endif
                    </div>
                    <p class="text-[11px] text-slate-400 truncate mt-0.5">{{ $p->subject }}</p>
                </div>
                <span class="text-[10px] text-slate-400 flex-shrink-0">{{ $p->created_at->diffForHumans() }}</span>
            </a>
            @endforeach
        </div>
        @endif
    </div>

    {{-- Produk Terbaru --}}
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm flex flex-col">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg bg-forest-50 border border-forest-200 flex items-center justify-center text-forest-700">
                    <i data-lucide="shopping-bag" class="w-4 h-4"></i>
                </div>
                <div>
                    <h2 class="font-display font-bold text-slate-900 text-sm leading-tight">Produk Terbaru</h2>
                    <p class="text-[11px] text-slate-400">{{ $stats['produk_aktif'] }} aktif dari {{ $stats['total_produk'] }} produk</p>
                </div>
            </div>
            <a href="{{ route('admin.produk.index') }}"
               class="text-[11px] text-forest-700 hover:text-forest-800 font-semibold flex items-center gap-1 transition-colors">
                Lihat semua <i data-lucide="arrow-right" class="w-3 h-3"></i>
            </a>
        </div>

        @if($produk_terbaru->isEmpty())
        <div class="flex flex-col items-center justify-center py-14 flex-1">
            <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center mb-3 text-slate-400">
                <i data-lucide="package" class="w-5 h-5"></i>
            </div>
            <p class="text-sm font-medium text-slate-500">Belum ada produk</p>
            <a href="{{ route('admin.produk.create') }}" class="text-[11px] text-forest-700 hover:underline mt-1.5">+ Tambah sekarang</a>
        </div>
        @else
        <div class="divide-y divide-slate-100 flex-1">
            @foreach($produk_terbaru as $p)
            <a href="{{ route('admin.produk.edit', $p) }}"
               class="flex items-center gap-3 px-5 py-3 hover:bg-slate-50 transition-all group">
                <div class="w-10 h-10 rounded-xl overflow-hidden flex-shrink-0 bg-slate-100 border border-slate-200">
                    <img src="{{ $p->img }}" alt="{{ $p->title }}" class="w-full h-full object-cover">
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-slate-800 truncate group-hover:text-slate-900 transition-colors">{{ $p->title }}</p>
                    <p class="text-[11px] text-slate-400 truncate mt-0.5">{{ $p->producer }}</p>
                </div>
                <div class="text-right flex-shrink-0 ml-2">
                    <p class="text-xs font-bold text-amber-600 mb-1">{{ $p->price }}</p>
                    <span class="{{ $p->is_active ? 'badge-read' : 'badge-unread' }}">
                        {{ $p->is_active ? 'Aktif' : 'Nonaktif' }}
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

    const gradient = ctx.createLinearGradient(0, 0, 0, 180);
    gradient.addColorStop(0,   'rgba(26, 71, 49, 0.15)');
    gradient.addColorStop(1,   'rgba(26, 71, 49, 0.02)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chart_labels),
            datasets: [{
                label: 'Pesan',
                data: @json($chart_data),
                backgroundColor: gradient,
                borderColor:     'rgba(26, 71, 49, 0.8)',
                borderWidth: 2,
                pointBackgroundColor: '#1a4731',
                pointBorderColor:     '#ffffff',
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
                    borderColor:     'rgba(26, 71, 49, 0.3)',
                    borderWidth: 1,
                    titleColor: '#f8fafc',
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
                    grid:  { color: 'rgba(148,163,184,0.08)' },
                    ticks: { color: '#94a3b8', font: { size: 10 } },
                    border: { color: 'transparent' },
                },
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, color: '#94a3b8', font: { size: 10 } },
                    grid: { color: 'rgba(148,163,184,0.08)' },
                    border: { color: 'transparent' },
                }
            }
        }
    });
</script>
@endpush

