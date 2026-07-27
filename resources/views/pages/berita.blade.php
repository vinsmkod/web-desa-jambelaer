@extends('layouts.app')

@section('title', 'Berita & Informasi')
@section('meta_desc', 'Kumpulan berita resmi, pengumuman publik, dan warta kegiatan terkini dari Pemerintah Desa Jambelaer, Subang.')

@section('content')
<div class="pt-28 pb-24 bg-gradient-to-b from-ivory to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- ── Section Header ───────────────────────────────────────────── -->
        <div class="text-center max-w-3xl mx-auto mb-10 reveal-on-scroll">
            <span class="text-xs font-bold tracking-widest uppercase text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full">Warta Resmi Desa</span>
            <h1 class="font-display font-extrabold text-3xl sm:text-4xl text-emerald-950 mt-3">Berita &amp; Kabar Desa Jambelaer</h1>
            <p class="mt-4 text-slate-500 font-light text-sm sm:text-base">
                Dapatkan informasi transparan mengenai program pembangunan, kegiatan kemasyarakatan, pengumuman penting, dan warta terbaru desa.
            </p>
            <div class="w-16 h-1 bg-gradient-to-r from-emerald-800 to-amber-600 mx-auto mt-4 rounded-full"></div>
        </div>

        <!-- ── Search Bar ─────────────────────────────────────────────── -->
        <div class="max-w-xl mx-auto mb-10 reveal-on-scroll delay-100">
            <form action="{{ route('berita') }}" method="GET" class="relative flex items-center">
                <input type="text" name="q" value="{{ request('q') }}"
                    placeholder="Cari artikel berita desa..."
                    class="w-full pl-12 pr-28 py-3.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent transition-all shadow-sm">
                <div class="absolute left-4 text-slate-400">
                    <i data-lucide="search" class="w-5 h-5"></i>
                </div>
                <button type="submit" class="absolute right-2 px-5 py-2 bg-emerald-900 hover:bg-emerald-800 text-white font-bold text-xs rounded-xl transition-all">
                    Cari
                </button>
            </form>
        </div>

        <!-- ── Category Filter Buttons ─────────────────────────────────── -->
        <div class="flex items-center justify-center flex-wrap gap-2 sm:gap-3 mb-12 reveal-on-scroll delay-200">
            <a href="{{ route('berita') }}"
               class="px-5 py-2.5 rounded-full text-xs font-bold uppercase tracking-wide transition-all duration-300 {{ !request('kategori') ? 'bg-emerald-900 text-white shadow-sm' : 'bg-white text-slate-700 hover:bg-emerald-50 border border-slate-200' }}">
                Semua Kategori
            </a>
            @foreach($kategoriList as $key => $label)
            <a href="{{ route('berita', ['kategori' => $key]) }}"
               class="px-5 py-2.5 rounded-full text-xs font-bold uppercase tracking-wide transition-all duration-300 {{ request('kategori') === $key ? 'bg-emerald-900 text-white shadow-sm' : 'bg-white text-slate-700 hover:bg-emerald-50 border border-slate-200' }}">
                {{ $label }}
            </a>
            @endforeach
        </div>

        <!-- ── Featured Main News Card ────────────────────────────────── -->
        @if(isset($featuredBerita) && $featuredBerita && !request('q') && !request('kategori') && $beritas->currentPage() == 1)
        <div class="mb-14 bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-200/80 grid md:grid-cols-12 gap-0 group hover:shadow-xl transition-all duration-300 reveal-on-scroll">
            <div class="md:col-span-7 relative min-h-[300px] md:min-h-[380px] overflow-hidden bg-slate-100">
                <img src="{{ $featuredBerita->gambar_url }}" alt="{{ $featuredBerita->judul }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute top-4 left-4">
                    <span class="px-3.5 py-1.5 bg-emerald-900/90 backdrop-blur-md text-emerald-300 font-bold text-xs rounded-xl shadow-md">
                        {{ $featuredBerita->kategori_label }}
                    </span>
                </div>
            </div>
            <div class="md:col-span-5 p-8 sm:p-10 flex flex-col justify-between space-y-6">
                <div class="space-y-4">
                    <div class="flex items-center gap-3 text-xs text-slate-400">
                        <span class="flex items-center gap-1.5">
                            <i data-lucide="calendar" class="w-3.5 h-3.5 text-emerald-700"></i>
                            {{ $featuredBerita->published_at ? $featuredBerita->published_at->translatedFormat('d M Y') : $featuredBerita->created_at->translatedFormat('d M Y') }}
                        </span>
                        <span>•</span>
                        <span class="flex items-center gap-1.5">
                            <i data-lucide="user" class="w-3.5 h-3.5 text-emerald-700"></i>
                            {{ $featuredBerita->penulis }}
                        </span>
                    </div>

                    <h2 class="font-display font-extrabold text-xl sm:text-2xl text-emerald-950 group-hover:text-emerald-800 transition-colors leading-snug">
                        <a href="{{ route('berita.detail', $featuredBerita->slug) }}">
                            {{ $featuredBerita->judul }}
                        </a>
                    </h2>

                    <p class="text-slate-600 text-sm leading-relaxed line-clamp-3 font-light">
                        {{ $featuredBerita->ringkasan }}
                    </p>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs text-slate-400 flex items-center gap-1">
                        <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                        {{ number_format($featuredBerita->views) }}x dibaca
                    </span>

                    <a href="{{ route('berita.detail', $featuredBerita->slug) }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-900 hover:bg-emerald-800 text-white font-semibold text-xs rounded-xl transition-all shadow-sm">
                        Baca Selengkapnya
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        </div>
        @endif

        <!-- ── News Cards Grid ────────────────────────────────────────── -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 reveal-on-scroll">
            @forelse($beritas as $item)
            <article class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl border border-slate-200/80 flex flex-col justify-between group transition-all duration-300 hover:-translate-y-1">
                <div>
                    <!-- Image -->
                    <div class="relative aspect-video overflow-hidden bg-slate-100">
                        <img src="{{ $item->gambar_url }}" alt="{{ $item->judul }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-3 left-3">
                            <span class="px-2.5 py-1 bg-emerald-900/90 backdrop-blur-md text-emerald-300 font-bold text-[11px] rounded-lg">
                                {{ $item->kategori_label }}
                            </span>
                        </div>
                    </div>

                    <!-- Content Body -->
                    <div class="p-6 space-y-3">
                        <div class="flex items-center gap-3 text-[11px] text-slate-400">
                            <span class="flex items-center gap-1">
                                <i data-lucide="calendar" class="w-3 h-3 text-emerald-700"></i>
                                {{ $item->published_at ? $item->published_at->translatedFormat('d M Y') : $item->created_at->translatedFormat('d M Y') }}
                            </span>
                            <span>•</span>
                            <span class="flex items-center gap-1">
                                <i data-lucide="user" class="w-3 h-3 text-emerald-700"></i>
                                {{ $item->penulis }}
                            </span>
                        </div>

                        <h3 class="font-display font-bold text-base text-emerald-950 group-hover:text-emerald-700 transition-colors line-clamp-2 leading-snug">
                            <a href="{{ route('berita.detail', $item->slug) }}">
                                {{ $item->judul }}
                            </a>
                        </h3>

                        <p class="text-slate-600 text-xs line-clamp-3 leading-relaxed font-light">
                            {{ $item->ringkasan }}
                        </p>
                    </div>
                </div>

                <!-- Footer Link -->
                <div class="px-6 pb-6 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="text-slate-400 text-[11px] flex items-center gap-1">
                        <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                        {{ number_format($item->views) }} views
                    </span>
                    <a href="{{ route('berita.detail', $item->slug) }}" class="font-bold text-emerald-900 group-hover:text-emerald-700 inline-flex items-center gap-1 transition-colors">
                        Baca Artikel
                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </article>
            @empty
            <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-slate-200/80 p-8 shadow-sm">
                <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="newspaper" class="w-8 h-8"></i>
                </div>
                <h3 class="font-display font-bold text-emerald-950 text-lg">Belum Ada Artikel Berita</h3>
                <p class="text-slate-500 text-xs mt-1 max-w-sm mx-auto">
                    Berita yang sesuai dengan pencarian atau kategori ini belum tersedia. Silakan cek kembali dalam waktu dekat.
                </p>
            </div>
            @endforelse
        </div>

        @if(method_exists($beritas, 'hasPages') && $beritas->hasPages())
        <div class="pt-10">
            {{ $beritas->links() }}
        </div>
        @endif

    </div>
</div>
@endsection
