@extends('layouts.app')

@section('title', 'Produsen ' . $jenisLabel . ' – Desa Jambelaer')
@section('meta_desc', 'Daftar produsen ' . $jenisLabel . ' dari Desa Jambelaer. Temukan produk ' . $jenisLabel . ' asli buatan warga lokal dengan harga terjangkau.')

@section('content')
<div class="pt-28 pb-24 bg-gradient-to-b from-emerald-50/50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- ── Breadcrumb ──────────────────────────────────────────────── --}}
        <nav class="flex items-center flex-wrap gap-1.5 text-xs text-slate-500 mb-10 reveal-on-scroll">
            <a href="{{ route('home') }}" class="hover:text-emerald-800 transition-colors">Home</a>
            <i data-lucide="chevron-right" class="w-3 h-3 flex-shrink-0"></i>
            <a href="{{ route('umkm') }}" class="hover:text-emerald-800 transition-colors">UMKM</a>
            <i data-lucide="chevron-right" class="w-3 h-3 flex-shrink-0"></i>
            <span class="text-emerald-800 font-semibold">{{ $jenisLabel }}</span>
        </nav>

        {{-- ── Hero Header ──────────────────────────────────────────────── --}}
        <div class="text-center max-w-3xl mx-auto mb-16 reveal-on-scroll">
            <span class="inline-flex items-center gap-1.5 text-xs font-bold tracking-widest uppercase text-emerald-700 bg-emerald-50 border border-emerald-100 px-4 py-1.5 rounded-full">
                <i data-lucide="store" class="w-3.5 h-3.5"></i>
                Produk Lokal Jambelaer
            </span>
            <h1 class="font-display font-extrabold text-3xl sm:text-4xl lg:text-5xl text-emerald-950 mt-4 leading-tight">
                Produsen
                <span class="text-emerald-700"> {{ $jenisLabel }}</span>
            </h1>
            <p class="mt-1 text-slate-500 text-lg font-light">di Desa Jambelaer</p>
            <p class="mt-4 text-slate-500 font-light text-sm sm:text-base max-w-xl mx-auto leading-relaxed">
                <strong class="text-slate-700">{{ $producers->count() }} UMKM lokal</strong> memproduksi
                <strong class="text-slate-700">{{ $jenisLabel }}</strong> asli khas Desa Jambelaer.
                Klik kartu produsen untuk melihat detail produk dan harga.
            </p>
            <div class="w-16 h-1 bg-gradient-to-r from-emerald-700 to-amber-500 mx-auto mt-5 rounded-full"></div>
        </div>

        {{-- ── Producers Grid ───────────────────────────────────────────── --}}
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8 reveal-on-scroll delay-100">
            @foreach($producers as $index => $product)
            <a href="{{ route('umkm.detail', $product->slug) }}"
               id="produsen-{{ $product->id }}"
               class="group relative overflow-hidden rounded-3xl shadow-sm border border-slate-100 hover:shadow-2xl hover:border-emerald-200 bg-white flex flex-col transition-all duration-300 hover:-translate-y-2">

                {{-- Image --}}
                <div class="relative overflow-hidden h-64">
                    <img src="{{ $product->img }}" alt="{{ $product->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    {{-- Gradient overlay --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/20 to-transparent"></div>
                    {{-- Price on image --}}
                    <div class="absolute bottom-4 left-5">
                        <span class="text-2xl font-extrabold text-white font-display drop-shadow-lg">
                            {{ $product->price }}
                        </span>
                    </div>
                    {{-- Badge top right --}}
                    <div class="absolute top-4 right-4">
                        <span class="px-3 py-1 rounded-full text-xs font-bold shadow-sm
                            {{ $product->badge === 'Makanan'   ? 'bg-amber-400 text-amber-950'
                            : ($product->badge === 'Kerajinan' ? 'bg-violet-400 text-violet-950'
                            : 'bg-emerald-400 text-emerald-950') }}">
                            {{ $product->badge }}
                        </span>
                    </div>
                    {{-- Hover overlay CTA --}}
                    <div class="absolute inset-0 bg-emerald-900/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <span class="bg-white/90 text-emerald-900 text-xs font-bold px-4 py-2 rounded-full flex items-center gap-1.5 shadow">
                            <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                            Lihat Detail & Harga
                        </span>
                    </div>
                </div>

                {{-- Info --}}
                <div class="p-6 flex-grow flex flex-col">

                    {{-- Producer badge --}}
                    <div class="flex items-center gap-3 mb-4 pb-4 border-b border-slate-100">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-700 flex items-center justify-center flex-shrink-0 shadow-sm">
                            <i data-lucide="user" class="w-5 h-5 text-white"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider leading-none mb-0.5">Produsen</p>
                            <p class="text-sm font-bold text-emerald-950 leading-tight">{{ $product->producer }}</p>
                        </div>
                    </div>

                    {{-- Product name + description --}}
                    <h2 class="font-display font-bold text-base text-emerald-950 flex-grow leading-snug">
                        {{ $product->title }}
                    </h2>
                    <p class="text-xs text-slate-500 mt-2 leading-relaxed line-clamp-2 font-light">
                        {{ $product->desc_short }}
                    </p>

                    {{-- CTA row --}}
                    <div class="flex items-center justify-between mt-5 pt-4 border-t border-slate-100">
                        <span class="text-sm font-extrabold text-amber-700 font-display">{{ $product->price }}</span>
                        <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-800 bg-emerald-50 px-3 py-1.5 rounded-full group-hover:bg-emerald-100 transition-colors">
                            Detail
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform"></i>
                        </span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        {{-- ── Tips Banner ──────────────────────────────────────────────── --}}
        <div class="mt-12 p-5 bg-amber-50 border border-amber-100 rounded-2xl flex items-start gap-3 reveal-on-scroll delay-200">
            <div class="w-8 h-8 bg-amber-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                <i data-lucide="lightbulb" class="w-4 h-4 text-amber-700"></i>
            </div>
            <p class="text-sm text-amber-800">
                <strong>Tips:</strong> Setiap produsen memiliki ciri khas dan resep yang berbeda.
                Bandingkan detail produk masing-masing untuk menemukan <strong>{{ $jenisLabel }}</strong> yang paling sesuai selera Anda.
            </p>
        </div>

        {{-- ── Back Button ──────────────────────────────────────────────── --}}
        <div class="mt-10 text-center">
            <a href="{{ route('umkm') }}"
               class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-emerald-800 transition-colors group">
                <i data-lucide="arrow-left" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"></i>
                Kembali ke Semua UMKM
            </a>
        </div>

    </div>
</div>
@endsection
