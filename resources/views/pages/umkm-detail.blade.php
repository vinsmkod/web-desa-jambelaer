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
                @php
                    $rawWa = $product->no_whatsapp_umkm ?: \App\Models\Pengaturan::get('sosmed_whatsapp', \App\Models\Pengaturan::get('kontak_telp', ''));
                    $waClean = preg_replace('/[^0-9]/', '', $rawWa);
                    if (str_starts_with($waClean, '0')) {
                        $waClean = '62' . substr($waClean, 1);
                    }
                    
                    $recipientName = $product->nama_pemilik ?: $product->producer;
                    $greeting = $recipientName ? "Halo {$recipientName}, " : "Halo, ";
                    $msg = urlencode("{$greeting}saya ingin bertanya mengenai produk \"{$product->title}\" yang ada di website Desa Jambelaer.");
                    
                    $waUrl = $waClean ? "https://wa.me/{$waClean}?text={$msg}" : route('kontak');
                @endphp

                {{-- Information Card UMKM --}}
                <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm space-y-4">
                    <h2 class="font-display font-bold text-emerald-950 text-base border-b border-slate-100 pb-3 flex items-center">
                        <i data-lucide="store" class="w-4 h-4 mr-2 text-emerald-700"></i>
                        Informasi Pengelola UMKM
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        @if($product->nama_pemilik)
                        <div>
                            <span class="text-slate-400 font-medium block">Nama Pemilik</span>
                            <span class="text-emerald-950 font-bold block mt-0.5">{{ $product->nama_pemilik }}</span>
                        </div>
                        @endif
                        @if($product->producer)
                        <div>
                            <span class="text-slate-400 font-medium block">Nama Usaha / Producer</span>
                            <span class="text-emerald-950 font-bold block mt-0.5">{{ $product->producer }}</span>
                        </div>
                        @endif
                        @if($product->badge)
                        <div>
                            <span class="text-slate-400 font-medium block">Kategori Produk</span>
                            <span class="text-emerald-950 font-bold block mt-0.5">{{ $product->badge }}</span>
                        </div>
                        @endif
                        @if($product->jam_operasional)
                        <div>
                            <span class="text-slate-400 font-medium block">Jam Operasional</span>
                            <span class="text-emerald-950 font-bold block mt-0.5">{{ $product->jam_operasional }}</span>
                        </div>
                        @endif
                        @if($product->alamat_umkm)
                        <div class="sm:col-span-2">
                            <span class="text-slate-400 font-medium block">Alamat UMKM</span>
                            <span class="text-emerald-950 font-bold block mt-0.5 leading-relaxed">{{ $product->alamat_umkm }}</span>
                        </div>
                        @endif
                        @if($product->no_whatsapp_umkm)
                        @php
                            $cardWa = preg_replace('/[^0-9]/', '', $product->no_whatsapp_umkm);
                            if (str_starts_with($cardWa, '0')) $cardWa = '62' . substr($cardWa, 1);
                        @endphp
                        <div>
                            <span class="text-slate-400 font-medium block">Nomor WhatsApp</span>
                            <a href="https://wa.me/{{ $cardWa }}?text={{ $msg }}" target="_blank" class="text-emerald-700 font-bold hover:underline block mt-0.5">
                                {{ $product->no_whatsapp_umkm }}
                            </a>
                        </div>
                        @endif
                        @if($product->instagram_umkm)
                        <div>
                            <span class="text-slate-400 font-medium block">Instagram</span>
                            <a href="{{ str_starts_with($product->instagram_umkm, 'http') ? $product->instagram_umkm : 'https://instagram.com/'.ltrim($product->instagram_umkm, '@') }}" target="_blank" class="text-pink-600 font-bold hover:underline block mt-0.5">
                                {{ $product->instagram_umkm }}
                            </a>
                        </div>
                        @endif
                        @if($product->link_marketplace)
                        <div class="sm:col-span-2">
                            <span class="text-slate-400 font-medium block">Link Toko / Marketplace</span>
                            <a href="{{ $product->link_marketplace }}" target="_blank" class="text-emerald-800 font-bold hover:underline block mt-0.5 truncate">
                                {{ $product->link_marketplace }} &rarr;
                            </a>
                        </div>
                        @endif
                    </div>
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
