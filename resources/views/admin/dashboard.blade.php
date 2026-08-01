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

        {{-- Total Produk --}}
        <a href="{{ route('admin.produk.index') }}" class="bg-white border border-slate-200/80 rounded-2xl p-5 hover:border-forest-400 hover:shadow-md transition-all duration-200 group flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Produk</p>
                <h3 class="font-display font-extrabold text-3xl text-slate-900 mt-2 leading-none">{{ number_format($stats['total_produk']) }}</h3>
                <p class="text-[11px] text-forest-600 font-semibold mt-2.5 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                    <span>Kelola Produk</span>
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                </p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-forest-50 border border-forest-100 flex items-center justify-center text-forest-700 flex-shrink-0 group-hover:scale-105 transition-transform">
                <i data-lucide="package" class="w-6 h-6"></i>
            </div>
        </a>

        {{-- Produk Aktif --}}
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 flex items-start justify-between">
            <div class="flex-1 min-w-0 pr-2">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Produk Aktif</p>
                <h3 class="font-display font-extrabold text-3xl text-slate-900 mt-2 leading-none">{{ number_format($stats['produk_aktif']) }}</h3>
                @php
                    $pct = $stats['total_produk'] > 0 ? round(($stats['produk_aktif'] / $stats['total_produk']) * 100) : 0;
                @endphp
                <div class="mt-3">
                    <div class="flex items-center justify-between text-[11px] font-medium text-slate-500 mb-1">
                        <span>Status Aktif</span>
                        <span class="font-bold text-sky-600">{{ $pct }}%</span>
                    </div>
                    <div class="h-1.5 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-sky-500 rounded-full transition-all" style="width: {{ $pct }}%"></div>
                    </div>
                </div>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-sky-50 border border-sky-100 flex items-center justify-center text-sky-600 flex-shrink-0">
                <i data-lucide="check-circle-2" class="w-6 h-6"></i>
            </div>
        </div>

        {{-- Total Pesan --}}
        <a href="{{ route('admin.pesan.index') }}" class="bg-white border border-slate-200/80 rounded-2xl p-5 hover:border-violet-400 hover:shadow-md transition-all duration-200 group flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Pesan</p>
                <h3 class="font-display font-extrabold text-3xl text-slate-900 mt-2 leading-none">{{ number_format($stats['total_pesan']) }}</h3>
                <p class="text-[11px] text-violet-600 font-semibold mt-2.5 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                    <span>Lihat Pesan</span>
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                </p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-violet-50 border border-violet-100 flex items-center justify-center text-violet-600 flex-shrink-0 group-hover:scale-105 transition-transform">
                <i data-lucide="mail" class="w-6 h-6"></i>
            </div>
        </a>

        {{-- Belum Dibaca --}}
        <a href="{{ route('admin.pesan.index') }}"
           class="bg-white border {{ $stats['pesan_belum'] > 0 ? 'border-amber-300 bg-amber-50/40' : 'border-slate-200/80' }} rounded-2xl p-5 hover:shadow-md transition-all duration-200 group flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Belum Dibaca</p>
                <h3 class="font-display font-extrabold text-3xl {{ $stats['pesan_belum'] > 0 ? 'text-amber-600' : 'text-slate-900' }} mt-2 leading-none">
                    {{ number_format($stats['pesan_belum']) }}
                </h3>
                @if($stats['pesan_belum'] > 0)
                <p class="text-[11px] text-amber-600 font-semibold mt-2.5 flex items-center gap-1 animate-pulse">
                    <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                    <span>Perlu ditanggapi</span>
                </p>
                @else
                <p class="text-[11px] text-emerald-600 font-medium mt-2.5 flex items-center gap-1">
                    <i data-lucide="check" class="w-3.5 h-3.5"></i>
                    <span>Semua terbaca</span>
                </p>
                @endif
            </div>
            <div class="relative w-12 h-12 rounded-2xl {{ $stats['pesan_belum'] > 0 ? 'bg-amber-100 border border-amber-200 text-amber-600' : 'bg-slate-50 border border-slate-100 text-slate-400' }} flex items-center justify-center flex-shrink-0">
                <i data-lucide="bell" class="w-6 h-6"></i>
                @if($stats['pesan_belum'] > 0)
                <span class="absolute -top-1 -right-1 w-4 h-4 bg-amber-500 rounded-full text-white text-[9px] font-bold flex items-center justify-center ring-2 ring-white">
                    {{ $stats['pesan_belum'] }}
                </span>
                @endif
            </div>
        </a>
    </div>

    {{-- ── Sub Stats: Pesan per Kategori ──────────────────────────────── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
        <a href="{{ route('admin.pesan.index') }}" class="flex items-center gap-3.5 bg-white border border-slate-200/80 rounded-xl px-4 py-3 hover:border-sky-300 hover:bg-sky-50/50 transition-all">
            <div class="w-9 h-9 rounded-xl bg-sky-50 border border-sky-100 flex items-center justify-center text-sky-600 flex-shrink-0">
                <i data-lucide="help-circle" class="w-4 h-4"></i>
            </div>
            <div class="min-w-0">
                <p class="text-base font-bold font-display text-slate-900 leading-tight">{{ number_format($stats['pertanyaan_umum']) }}</p>
                <p class="text-xs text-slate-500 font-medium truncate mt-0.5">Pertanyaan</p>
            </div>
        </a>

        <a href="{{ route('admin.pesan.index') }}" class="flex items-center gap-3.5 bg-white border border-slate-200/80 rounded-xl px-4 py-3 hover:border-rose-300 hover:bg-rose-50/50 transition-all">
            <div class="w-9 h-9 rounded-xl bg-rose-50 border border-rose-100 flex items-center justify-center text-rose-600 flex-shrink-0">
                <i data-lucide="alert-triangle" class="w-4 h-4"></i>
            </div>
            <div class="min-w-0">
                <p class="text-base font-bold font-display text-slate-900 leading-tight">{{ number_format($stats['pengaduan']) }}</p>
                <p class="text-xs text-slate-500 font-medium truncate mt-0.5">Pengaduan Warga</p>
            </div>
        </a>

        <a href="{{ route('admin.pesan.index') }}" class="flex items-center gap-3.5 bg-white border border-slate-200/80 rounded-xl px-4 py-3 hover:border-cyan-300 hover:bg-cyan-50/50 transition-all">
            <div class="w-9 h-9 rounded-xl bg-cyan-50 border border-cyan-100 flex items-center justify-center text-cyan-600 flex-shrink-0">
                <i data-lucide="handshake" class="w-4 h-4"></i>
            </div>
            <div class="min-w-0">
                <p class="text-base font-bold font-display text-slate-900 leading-tight">{{ number_format($stats['kerja_sama']) }}</p>
                <p class="text-xs text-slate-500 font-medium truncate mt-0.5">Kerja Sama</p>
            </div>
        </a>

        <a href="{{ route('admin.pengajuan-acara.index') }}" class="flex items-center gap-3.5 bg-white border border-slate-200/80 rounded-xl px-4 py-3 hover:border-amber-300 hover:bg-amber-50/50 transition-all relative">
            <div class="w-9 h-9 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600 flex-shrink-0">
                <i data-lucide="calendar-check" class="w-4 h-4"></i>
            </div>
            <div class="min-w-0">
                <div class="flex items-center gap-1.5">
                    <p class="text-base font-bold font-display text-slate-900 leading-tight">{{ number_format($stats['pengajuan_acara']) }}</p>
                    @if($stats['acara_menunggu'] > 0)
                    <span class="text-[10px] bg-amber-500 text-white font-bold px-1.5 py-0.2 rounded-full animate-pulse">
                        {{ $stats['acara_menunggu'] }} baru
                    </span>
                    @endif
                </div>
                <p class="text-xs text-slate-500 font-medium truncate mt-0.5">Pengajuan Acara</p>
            </div>
        </a>
    </div>

    {{-- ── Main Content: Chart + Quick Actions ─────────────────────────── --}}
    <div class="grid lg:grid-cols-3 gap-6">

        {{-- Chart Pesan --}}
        <div class="lg:col-span-2 bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs flex flex-col">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="font-display font-bold text-slate-900 text-base">Grafik Pesan Masuk</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Frekuensi pesan dari warga dalam 7 hari terakhir</p>
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
                    <a href="{{ route('admin.produk.create') }}"
                       class="flex items-center gap-3 w-full p-3 rounded-2xl bg-forest-50/70 hover:bg-forest-100/70 border border-forest-200/80 text-forest-800 transition-all group">
                        <div class="w-8 h-8 rounded-xl bg-forest-800 text-white flex items-center justify-center flex-shrink-0 shadow-xs">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold leading-tight">Tambah Produk UMKM</p>
                            <p class="text-[10px] text-forest-600 truncate mt-0.5">Input produk olahan warga baru</p>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-forest-500 group-hover:translate-x-1 transition-transform"></i>
                    </a>

                    <a href="{{ route('admin.pesan.index') }}"
                       class="flex items-center gap-3 w-full p-3 rounded-2xl bg-violet-50/70 hover:bg-violet-100/70 border border-violet-200/80 text-violet-800 transition-all group">
                        <div class="w-8 h-8 rounded-xl bg-violet-600 text-white flex items-center justify-center flex-shrink-0 shadow-xs relative">
                            <i data-lucide="inbox" class="w-4 h-4"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold leading-tight">Kotak Masuk Pesan</p>
                            <p class="text-[10px] text-violet-600 truncate mt-0.5">
                                {{ $stats['pesan_belum'] > 0 ? $stats['pesan_belum'].' pesan baru perlu dibaca' : 'Semua pesan sudah dibaca' }}
                            </p>
                        </div>
                        @if($stats['pesan_belum'] > 0)
                        <span class="text-[10px] bg-amber-500 text-white font-bold px-2 py-0.5 rounded-full">{{ $stats['pesan_belum'] }}</span>
                        @else
                        <i data-lucide="chevron-right" class="w-4 h-4 text-violet-400 group-hover:translate-x-1 transition-transform"></i>
                        @endif
                    </a>

                    <a href="{{ route('admin.pengajuan-acara.index') }}"
                       class="flex items-center gap-3 w-full p-3 rounded-2xl bg-amber-50/70 hover:bg-amber-100/70 border border-amber-200/80 text-amber-900 transition-all group">
                        <div class="w-8 h-8 rounded-xl bg-amber-500 text-white flex items-center justify-center flex-shrink-0 shadow-xs">
                            <i data-lucide="calendar" class="w-4 h-4"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold leading-tight">Pengajuan Acara Warga</p>
                            <p class="text-[10px] text-amber-700 truncate mt-0.5">
                                {{ $stats['acara_menunggu'] > 0 ? $stats['acara_menunggu'].' perlu persetujuan' : 'Kelola jadwal acara publik' }}
                            </p>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-amber-500 group-hover:translate-x-1 transition-transform"></i>
                    </a>

                    <a href="{{ route('admin.tentang.index') }}"
                       class="flex items-center gap-3 w-full p-3 rounded-2xl bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-800 transition-all group">
                        <div class="w-8 h-8 rounded-xl bg-slate-200 text-slate-700 flex items-center justify-center flex-shrink-0">
                            <i data-lucide="users-2" class="w-4 h-4"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold leading-tight">Struktur Organisasi</p>
                            <p class="text-[10px] text-slate-500 truncate mt-0.5">Kelola perangkat & pengurus desa</p>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-400 group-hover:translate-x-1 transition-transform"></i>
                    </a>

                    <a href="{{ route('admin.pengaturan.index') }}"
                       class="flex items-center gap-3 w-full p-3 rounded-2xl bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-800 transition-all group">
                        <div class="w-8 h-8 rounded-xl bg-slate-200 text-slate-700 flex items-center justify-center flex-shrink-0">
                            <i data-lucide="settings-2" class="w-4 h-4"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold leading-tight">Pengaturan & Sambutan</p>
                            <p class="text-[10px] text-slate-500 truncate mt-0.5">Ubah foto kades & profil resmi</p>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-400 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>

            <div class="pt-2 text-center border-t border-slate-100">
                <span class="text-[11px] text-slate-400">Versi Portal Desa 2.0 · Live Admin Panel</span>
            </div>
        </div>
    </div>

    {{-- ── Bottom Tables: Pesan Terbaru & Produk Terbaru ───────────────── --}}
    <div class="grid lg:grid-cols-2 gap-6">

        {{-- Pesan Terbaru --}}
        <div class="bg-white border border-slate-200/80 rounded-3xl overflow-hidden shadow-xs flex flex-col">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-violet-50 border border-violet-100 flex items-center justify-center text-violet-600">
                        <i data-lucide="message-square" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h3 class="font-display font-bold text-slate-900 text-sm">Pesan Terbaru</h3>
                        <p class="text-[11px] text-slate-400">Pesan dan aspirasi warga terkini</p>
                    </div>
                </div>
                <a href="{{ route('admin.pesan.index') }}"
                   class="text-xs text-forest-700 hover:text-forest-900 font-semibold flex items-center gap-1 transition-colors">
                    <span>Lihat Semua</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>

            @if($pesan_terbaru->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 flex-1 text-slate-400">
                <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center mb-3 text-slate-400">
                    <i data-lucide="inbox" class="w-6 h-6"></i>
                </div>
                <p class="text-sm font-medium text-slate-500">Belum ada pesan masuk</p>
            </div>
            @else
            <div class="divide-y divide-slate-100 flex-1">
                @foreach($pesan_terbaru as $p)
                <a href="{{ route('admin.pesan.show', $p) }}"
                   class="flex items-center gap-3.5 px-6 py-3.5 hover:bg-slate-50/80 transition-colors group">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-forest-700 to-forest-900 flex items-center justify-center text-white font-bold text-xs flex-shrink-0 shadow-xs">
                        {{ strtoupper(substr($p->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <p class="text-xs font-bold text-slate-800 truncate group-hover:text-forest-800 transition-colors">{{ $p->name }}</p>
                            @if(!$p->is_read)
                            <span class="w-2 h-2 bg-amber-500 rounded-full flex-shrink-0" title="Belum dibaca"></span>
                            @endif
                        </div>
                        <p class="text-xs text-slate-500 truncate mt-0.5">{{ $p->subject }}</p>
                    </div>
                    <span class="text-[10px] text-slate-400 font-medium flex-shrink-0">{{ $p->created_at->diffForHumans() }}</span>
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
                    <img src="{{ $p->img }}" alt="{{ $p->title }}"
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
