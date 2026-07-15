@extends('layouts.app')

@section('title', $product->title)
@section('meta_desc', $product->desc_short)

@section('content')
<div class="pt-28 pb-24 bg-gradient-to-b from-white to-ivory">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Breadcrumb --}}
        <nav class="flex items-center flex-wrap gap-1.5 text-xs text-slate-500 mb-8 reveal-on-scroll">
            <a href="{{ route('home') }}" class="hover:text-emerald-800 transition-colors">Home</a>
            <i data-lucide="chevron-right" class="w-3 h-3 flex-shrink-0"></i>
            <a href="{{ route('umkm') }}" class="hover:text-emerald-800 transition-colors">UMKM</a>
            @if($product->jenis)
            <i data-lucide="chevron-right" class="w-3 h-3 flex-shrink-0"></i>
            <a href="{{ route('umkm.jenis', $product->jenis) }}" class="hover:text-emerald-800 transition-colors">
                {{ $product->jenis_label ?? ucfirst($product->jenis) }}
            </a>
            @endif
            <i data-lucide="chevron-right" class="w-3 h-3 flex-shrink-0"></i>
            <span class="text-emerald-800 font-semibold">{{ $product->title }}</span>
        </nav>

        <div class="grid lg:grid-cols-12 gap-12">

            {{-- ── Left: Image ── --}}
            <div class="lg:col-span-5 reveal-on-scroll">
                <div class="relative rounded-3xl overflow-hidden shadow-lg border border-slate-100">
                    <img src="{{ $product->img }}" alt="{{ $product->title }}"
                         class="w-full h-80 lg:h-[480px] object-cover">
                    <span class="absolute top-5 left-5 px-3 py-1.5 rounded-full text-xs font-extrabold tracking-wider uppercase shadow-sm
                        {{ $product->badge === 'Makanan' ? 'bg-amber-50 text-amber-800' : ($product->badge === 'Kerajinan' ? 'bg-violet-50 text-violet-800' : 'bg-emerald-50 text-emerald-900') }}">
                        {{ $product->badge }}
                    </span>
                </div>

                {{-- Other Products --}}
                @if($allProducts->isNotEmpty())
                <div class="mt-8">
                    <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4">Produk Lainnya</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-2 gap-3">
                        @foreach($allProducts->take(4) as $p)
                        <a href="{{ route('umkm.detail', $p->slug) }}"
                           class="group flex items-center gap-3 p-3 bg-white rounded-2xl border border-slate-100 hover:border-emerald-200 hover:shadow-md transition-all">
                            <img src="{{ $p->img }}" alt="{{ $p->title }}"
                                 class="w-12 h-12 object-cover rounded-xl flex-shrink-0">
                            <div class="min-w-0">
                                <p class="text-xs font-semibold text-emerald-950 truncate">{{ $p->title }}</p>
                                <p class="text-xs text-amber-700 font-bold">{{ $p->price }}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            {{-- ── Right: Info ── --}}
            <div class="lg:col-span-7 space-y-6 reveal-on-scroll delay-100">

                {{-- Header --}}
                <div>
                    <span class="text-xs font-bold text-slate-400 tracking-widest uppercase break-words">{{ $product->producer }}</span>
                    <h1 class="font-display font-extrabold text-3xl sm:text-4xl text-emerald-950 mt-2 leading-tight break-words">
                        {{ $product->title }}
                    </h1>
                    <p class="mt-3 text-slate-600 text-sm sm:text-base font-light leading-relaxed break-words">
                        {{ $product->desc_short }}
                    </p>
                    <div class="flex items-center gap-4 mt-5">
                        <span class="text-2xl font-extrabold font-display text-amber-700">{{ $product->price }}</span>
                    </div>
                </div>

                {{-- CTA Buttons --}}
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('kontak') }}"
                       class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3.5 text-sm font-bold tracking-wide text-white bg-emerald-900 hover:bg-emerald-800 rounded-xl shadow-md transition-all duration-200 hover:-translate-y-0.5">
                        <i data-lucide="shopping-bag" class="w-4 h-4"></i>
                        Pesan Sekarang
                    </a>
                    <a href="{{ route('kontak') }}"
                       class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3.5 text-sm font-bold tracking-wide text-emerald-950 bg-white border border-slate-200 hover:bg-emerald-50 rounded-xl transition-all duration-200 hover:-translate-y-0.5">
                        <i data-lucide="phone" class="w-4 h-4"></i>
                        Tanyakan via WhatsApp
                    </a>
                </div>

                {{-- Description --}}
                <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">
                    <h2 class="font-display font-bold text-emerald-950 text-base mb-3">Tentang Produk</h2>
                    <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-line break-words">{{ $product->desc_long }}</p>
                </div>

                {{-- Details Table --}}
                @if($product->details && count($product->details))
                <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm">
                    <div class="px-6 py-4 border-b border-slate-100">
                        <h2 class="font-display font-bold text-emerald-950 text-base">Spesifikasi Produk</h2>
                    </div>
                    <table class="w-full text-sm">
                        <tbody class="divide-y divide-slate-50">
                            @foreach($product->details as $key => $val)
                            <tr class="hover:bg-emerald-50/50 transition-colors">
                                <td class="px-6 py-3 text-slate-500 font-medium w-2/5">{{ $key }}</td>
                                <td class="px-6 py-3 text-emerald-950 font-semibold">{{ $val }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif

                {{-- Back --}}
                <a href="{{ $product->jenis ? route('umkm.jenis', $product->jenis) : route('umkm') }}"
                   class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-emerald-800 transition-colors group">
                    <i data-lucide="arrow-left" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"></i>
                    @if($product->jenis)
                        Kembali ke Produsen {{ $product->jenis_label ?? ucfirst($product->jenis) }}
                    @else
                        Kembali ke Daftar UMKM
                    @endif
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
