@extends('layouts.app')

@section('title', $product->title . ' | UMKM Desa Jambelaer')
@section('meta_desc', Str::limit($product->desc_short ?: ($product->producer . ' – Produk UMKM Desa Jambelaer, Kecamatan Dawuan, Kabupaten Subang.'), 155))
@section('og_image', $product->img_url)

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@graph": [
    {
      "@type": "LocalBusiness",
      "name": {{ json_encode($product->producer ?: $product->title) }},
      "description": {{ json_encode(Str::limit($product->desc_short ?: $product->desc_long, 200)) }},
      "image": {{ json_encode($product->img_url) }},
      "url": "{{ config('app.url') }}/umkm/{{ $product->slug }}",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": {{ json_encode($product->alamat_umkm ?: 'Desa Jambelaer') }},
        "addressLocality": "Kecamatan Dawuan",
        "addressRegion": "Kabupaten Subang",
        "addressCountry": "ID"
      },
      @if($product->no_whatsapp_umkm)
      "telephone": {{ json_encode($product->no_whatsapp_umkm) }},
      @endif
      @if($product->jam_operasional)
      "openingHours": {{ json_encode($product->jam_operasional) }},
      @endif
      "areaServed": "Desa Jambelaer, Kecamatan Dawuan, Kabupaten Subang",
      "priceRange": {{ json_encode($product->price ?: 'Hubungi penjual') }}
    },
    {
      "@type": "BreadcrumbList",
      "itemListElement": [
        { "@type": "ListItem", "position": 1, "name": "Beranda", "item": "{{ config('app.url') }}" },
        { "@type": "ListItem", "position": 2, "name": "UMKM", "item": "{{ config('app.url') }}/umkm" },
        @if($product->jenis)
        { "@type": "ListItem", "position": 3, "name": {{ json_encode($product->jenis_label ?? ucfirst($product->jenis)) }}, "item": "{{ config('app.url') }}/umkm/jenis/{{ $product->jenis }}" },
        { "@type": "ListItem", "position": 4, "name": {{ json_encode($product->title) }}, "item": "{{ config('app.url') }}/umkm/{{ $product->slug }}" }
        @else
        { "@type": "ListItem", "position": 3, "name": {{ json_encode($product->title) }}, "item": "{{ config('app.url') }}/umkm/{{ $product->slug }}" }
        @endif
      ]
    }
  ]
}
</script>
@endpush

@section('content')
<div class="pt-24 pb-24 bg-stone-50/50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Breadcrumb --}}
        <nav class="flex items-center flex-wrap gap-1.5 text-xs text-stone-500 mb-6 reveal-on-scroll">
            <a href="{{ route('home') }}" class="hover:text-forest-800 transition-colors">Beranda</a>
            <i data-lucide="chevron-right" class="w-3 h-3 flex-shrink-0 text-stone-300"></i>
            <a href="{{ route('umkm') }}" class="hover:text-forest-800 transition-colors">UMKM</a>
            @if($product->jenis)
            <i data-lucide="chevron-right" class="w-3 h-3 flex-shrink-0 text-stone-300"></i>
            <a href="{{ route('umkm.jenis', $product->jenis) }}" class="hover:text-forest-800 transition-colors">
                {{ $product->jenis_label ?? ucfirst($product->jenis) }}
            </a>
            @endif
            <i data-lucide="chevron-right" class="w-3 h-3 flex-shrink-0 text-stone-300"></i>
            <span class="text-forest-800 font-semibold truncate max-w-xs">{{ $product->title }}</span>
        </nav>

        <div class="grid lg:grid-cols-12 gap-8 items-start">

            {{-- ── Left: Image ── --}}
            <div class="lg:col-span-5 space-y-6 reveal-on-scroll">
                <div class="relative rounded-xl overflow-hidden shadow-sm border border-stone-200 bg-white">
                    <img src="{{ $product->img }}" alt="Produk {{ $product->title }} dari UMKM {{ $product->producer ?? 'Desa Jambelaer' }}"
                         class="w-full h-80 lg:h-[420px] object-cover"
                         loading="eager" width="600" height="420">
                    <span class="absolute top-4 left-4 px-2.5 py-1 rounded text-[10px] font-extrabold tracking-wider uppercase shadow-sm
                        {{ $product->badge === 'Makanan' ? 'bg-amber-50 border border-amber-100 text-amber-800' : ($product->badge === 'Kerajinan' ? 'bg-violet-50 border border-violet-100 text-violet-800' : 'bg-forest-50 border border-forest-100 text-forest-900') }}">
                        {{ $product->badge }}
                    </span>
                </div>

                {{-- Other Products --}}
                @if($allProducts->isNotEmpty())
                <div>
                    <h3 class="text-[10px] font-bold text-stone-400 uppercase tracking-wider mb-3">Produk Lainnya</h3>
                    <div class="grid grid-cols-1 gap-2.5">
                        @foreach($allProducts->take(4) as $p)
                        <a href="{{ route('umkm.detail', $p->slug) }}"
                           class="group flex items-center gap-3 p-2.5 bg-white rounded-lg border border-stone-200 hover:border-forest-200 hover:shadow-sm transition-all">
                            <img src="{{ $p->img }}" alt="Produk {{ $p->title }} UMKM Desa Jambelaer"
                                 class="w-12 h-12 object-cover rounded flex-shrink-0"
                                 loading="lazy" width="48" height="48">
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-stone-800 truncate group-hover:text-forest-700 transition-colors">{{ $p->title }}</p>
                                <p class="text-xs text-sand-700 font-bold mt-0.5">{{ $p->price }}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            {{-- ── Right: Info ── --}}
            <div class="lg:col-span-7 space-y-5 reveal-on-scroll delay-100">

                {{-- Header --}}
                <div class="bg-white border border-stone-200 rounded-xl p-6 sm:p-7 shadow-sm">
                    <span class="text-[10px] font-bold text-stone-400 tracking-widest uppercase block">{{ $product->producer }}</span>
                    <h1 class="font-display font-extrabold text-xl sm:text-2xl text-stone-850 mt-1.5 leading-tight">
                        {{ $product->title }}
                    </h1>
                    <div class="w-12 h-1 bg-gradient-to-r from-forest-800 to-amber-600 mt-3 rounded-full"></div>
                    <p class="mt-4 text-stone-600 text-sm font-light leading-relaxed">
                        {{ $product->desc_short }}
                    </p>
                    <div class="mt-5 pt-4 border-t border-stone-100 flex items-center justify-between">
                        <span class="text-lg font-extrabold font-display text-sand-700">{{ $product->price }}</span>
                        @php
                            $rawWa = $product->no_whatsapp_umkm ?: \App\Models\Pengaturan::get('sosmed_whatsapp', \App\Models\Pengaturan::get('desa_telepon', ''));
                            $waClean = preg_replace('/[^0-9]/', '', $rawWa);
                            if (str_starts_with($waClean, '0')) {
                                $waClean = '62' . substr($waClean, 1);
                            }
                            
                            $recipientName = $product->nama_pemilik ?: $product->producer;
                            $greeting = $recipientName ? "Halo {$recipientName}, " : "Halo, ";
                            $msg = urlencode("{$greeting}saya ingin bertanya mengenai produk \"{$product->title}\" yang ada di website Desa Jambelaer.");
                        @endphp
                    </div>
                </div>

                {{-- Information Card UMKM --}}
                <div class="bg-white border border-stone-200 rounded-xl p-6 shadow-sm space-y-4">
                    <h2 class="font-display font-bold text-stone-850 text-sm border-b border-stone-100 pb-3 flex items-center">
                        <i data-lucide="store" class="w-4 h-4 mr-2 text-forest-750"></i>
                        Informasi Pengelola UMKM
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        @if($product->nama_pemilik)
                        <div>
                            <span class="text-stone-400 font-medium block">Nama Pemilik</span>
                            <span class="text-stone-800 font-bold block mt-0.5">{{ $product->nama_pemilik }}</span>
                        </div>
                        @endif
                        @if($product->producer)
                        <div>
                            <span class="text-stone-400 font-medium block">Nama Usaha</span>
                            <span class="text-stone-800 font-bold block mt-0.5">{{ $product->producer }}</span>
                        </div>
                        @endif
                        @if($product->badge)
                        <div>
                            <span class="text-stone-400 font-medium block">Kategori</span>
                            <span class="text-stone-800 font-bold block mt-0.5">{{ $product->badge }}</span>
                        </div>
                        @endif
                        @if($product->jam_operasional)
                        <div>
                            <span class="text-stone-400 font-medium block">Jam Operasional</span>
                            <span class="text-stone-800 font-bold block mt-0.5">{{ $product->jam_operasional }}</span>
                        </div>
                        @endif
                        @if($product->alamat_umkm)
                        <div class="sm:col-span-2">
                            <span class="text-stone-400 font-medium block">Alamat</span>
                            <span class="text-stone-800 font-bold block mt-0.5 leading-relaxed">{{ $product->alamat_umkm }}</span>
                        </div>
                        @endif
                        @if($product->instagram_umkm)
                        <div>
                            <span class="text-stone-400 font-medium block">Instagram</span>
                            <a href="{{ str_starts_with($product->instagram_umkm, 'http') ? $product->instagram_umkm : 'https://instagram.com/'.ltrim($product->instagram_umkm, '@') }}" target="_blank" class="text-pink-600 font-bold hover:underline block mt-0.5">
                                {{ $product->instagram_umkm }}
                            </a>
                        </div>
                        @endif
                        @if($product->no_whatsapp_umkm)
                        @php
                            $cardWa = preg_replace('/[^0-9]/', '', $product->no_whatsapp_umkm);
                            if (str_starts_with($cardWa, '0')) $cardWa = '62' . substr($cardWa, 1);
                        @endphp
                        <div>
                            <span class="text-stone-400 font-medium block">Nomor WhatsApp</span>
                            <a href="https://wa.me/{{ $cardWa }}?text={{ $msg }}" target="_blank" class="text-forest-700 font-bold hover:underline block mt-0.5">
                                {{ $product->no_whatsapp_umkm }}
                            </a>
                        </div>
                        @endif
                        @if($product->link_marketplace)
                        <div class="sm:col-span-2">
                            <span class="text-stone-400 font-medium block">Link Toko / Marketplace</span>
                            <a href="{{ $product->link_marketplace }}" target="_blank" class="text-forest-800 font-bold hover:underline block mt-0.5 truncate">
                                {{ $product->link_marketplace }} &rarr;
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Description --}}
                <div class="bg-white border border-stone-200 rounded-xl p-6 shadow-sm">
                    <h2 class="font-display font-bold text-stone-850 text-sm mb-3">Tentang Produk</h2>
                    <p class="text-stone-600 text-sm leading-relaxed whitespace-pre-line font-light">{{ $product->desc_long }}</p>
                </div>

                {{-- Details Table --}}
                @if($product->details && count($product->details))
                <div class="bg-white border border-stone-200 rounded-xl overflow-hidden shadow-sm">
                    <div class="px-6 py-4 border-b border-stone-100 bg-stone-50/50">
                        <h2 class="font-display font-bold text-stone-850 text-sm">Spesifikasi Produk</h2>
                    </div>
                    <table class="w-full text-xs sm:text-sm">
                        <tbody class="divide-y divide-stone-100">
                            @foreach($product->details as $key => $val)
                            <tr class="hover:bg-forest-50/20 transition-colors">
                                <td class="px-6 py-3.5 text-stone-500 font-medium w-2/5">{{ $key }}</td>
                                <td class="px-6 py-3.5 text-stone-800 font-semibold">{{ $val }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif

                {{-- Back --}}
                <div class="pt-3">
                    <a href="{{ $product->jenis ? route('umkm.jenis', $product->jenis) : route('umkm') }}"
                       class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-stone-500 hover:text-forest-800 transition-colors group">
                        <i data-lucide="arrow-left" class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform text-sand-500"></i>
                        @if($product->jenis)
                            Kembali ke Produsen {{ $product->jenis_label ?? ucfirst($product->jenis) }}
                        @else
                            Kembali ke UMKM
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
