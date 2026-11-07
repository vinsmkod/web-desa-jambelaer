@extends('layouts.app')

@section('title', $jenisLabel . ' Desa Jambelaer | UMKM Kecamatan Dawuan')
@section('meta_desc', 'Daftar produsen ' . $jenisLabel . ' dari Desa Jambelaer, Kecamatan Dawuan, Kabupaten Subang. Temukan produk ' . $jenisLabel . ' asli buatan warga lokal berkualitas.')

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    { "@type": "ListItem", "position": 1, "name": "Beranda", "item": "{{ config('app.url') }}" },
    { "@type": "ListItem", "position": 2, "name": "UMKM", "item": "{{ config('app.url') }}/umkm" },
    { "@type": "ListItem", "position": 3, "name": "{{ $jenisLabel }}", "item": "{{ config('app.url') }}/umkm/jenis/{{ $jenis }}" }
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
            <i data-lucide="chevron-right" class="w-3 h-3 flex-shrink-0 text-stone-300"></i>
            <span class="text-forest-800 font-semibold truncate max-w-xs">{{ $jenisLabel }}</span>
        </nav>

        {{-- Hero Header --}}
        <div class="text-center max-w-3xl mx-auto mb-14 reveal-on-scroll">
            <span class="inline-flex items-center gap-1.5 text-[10px] font-bold tracking-widest uppercase text-forest-800 bg-forest-50 border border-forest-100 px-4 py-1.5 rounded">
                <i data-lucide="store" class="w-3.5 h-3.5 text-sand-500"></i>
                Produk Lokal Jambelaer
            </span>
            <h1 class="font-display font-extrabold text-2xl sm:text-3xl lg:text-4xl text-stone-850 mt-4 leading-tight">
                Produsen
                <span class="text-forest-800"> {{ $jenisLabel }}</span>
            </h1>
            <p class="mt-1 text-stone-400 text-sm font-light">di Desa Jambelaer</p>
            <p class="mt-3 text-stone-500 font-light text-xs sm:text-sm max-w-xl mx-auto leading-relaxed">
                Terdapat <strong class="text-stone-700 font-semibold">{{ $producers->count() }} pelaku usaha lokal</strong> yang memproduksi olahan <strong class="text-stone-700 font-semibold">{{ $jenisLabel }}</strong> asli khas Desa Jambelaer.
            </p>
            <div class="section-divider"></div>
        </div>

        {{-- Producers Grid --}}
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 reveal-on-scroll delay-100">
            @foreach($producers as $index => $product)
            <a href="{{ route('umkm.detail', $product->slug) }}"
               id="produsen-{{ $product->produk_id }}"
               class="group relative overflow-hidden rounded-xl bg-white border border-stone-200 hover:border-forest-200 hover:shadow-md flex flex-col transition-all duration-300 hover:-translate-y-1">

                {{-- Image --}}
                <div class="relative overflow-hidden h-52">
                    <img src="{{ $product->img_url }}" alt="{{ $product->title }}"
                         class="w-full h-full object-cover group-hover:scale-103 transition-transform duration-700">
                    {{-- Gradient overlay --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-forest-950/80 via-forest-900/10 to-transparent"></div>
                    {{-- Price on image --}}
                    <div class="absolute bottom-3 left-4">
                        <span class="text-xl font-extrabold text-white font-display drop-shadow-sm">
                            {{ $product->price }}
                        </span>
                    </div>
                    {{-- Badge top right --}}
                    <div class="absolute top-3 right-3">
                        <span class="px-2.5 py-1 rounded text-[9px] font-bold shadow-sm
                            {{ $product->badge === 'Makanan'   ? 'bg-amber-50 text-amber-800'
                            : ($product->badge === 'Kerajinan' ? 'bg-violet-50 text-violet-800'
                            : 'bg-forest-50 text-forest-900') }}">
                            {{ $product->badge }}
                        </span>
                    </div>
                </div>

                {{-- Info --}}
                <div class="p-5 flex-grow flex flex-col justify-between">

                    {{-- Producer badge --}}
                    <div class="flex items-center gap-3 mb-4 pb-4 border-b border-stone-100">
                        <div class="w-8 h-8 rounded bg-forest-50 border border-forest-100 flex items-center justify-center flex-shrink-0">
                            <i data-lucide="user" class="w-4 h-4 text-forest-750"></i>
                        </div>
                        <div>
                            <p class="text-[9px] font-bold text-stone-400 uppercase tracking-wider leading-none mb-0.5">Produsen</p>
                            <p class="text-xs font-bold text-stone-750 leading-tight">{{ $product->producer }}</p>
                        </div>
                    </div>

                    {{-- Product name + description --}}
                    <div>
                        <h2 class="font-display font-bold text-sm text-stone-850 leading-snug">
                            {{ $product->title }}
                        </h2>
                        <p class="text-xs text-stone-500 mt-1.5 leading-relaxed line-clamp-2 font-light">
                            {{ $product->desc_short }}
                        </p>
                    </div>

                    {{-- CTA row --}}
                    <div class="flex items-center justify-between mt-5 pt-4 border-t border-stone-100 text-xs">
                        <span class="text-xs font-extrabold text-sand-700 font-display">{{ $product->price }}</span>
                        <span class="inline-flex items-center gap-1.5 font-bold text-forest-800 bg-forest-50 border border-forest-100 px-3 py-1.5 rounded group-hover:bg-forest-100 transition-colors">
                            Detail
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform text-sand-500"></i>
                        </span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        {{-- Tips Banner --}}
        <div class="mt-10 p-4 bg-sand-50 border border-sand-200 rounded-lg flex items-start gap-3 reveal-on-scroll delay-200 max-w-3xl mx-auto">
            <div class="w-6 h-6 bg-sand-200 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                <i data-lucide="lightbulb" class="w-3.5 h-3.5 text-sand-700"></i>
            </div>
            <p class="text-xs text-sand-800 leading-relaxed">
                <strong>Informasi Rasa & Kualitas:</strong> Setiap produsen lokal memproduksi olahan mereka dengan keahlian tersendiri. Bandingkan profil produk masing-masing untuk menemukan kesesuaian harga dan spesifikasi yang Anda inginkan.
            </p>
        </div>

        {{-- Back Button --}}
        <div class="mt-8 text-center">
            <a href="{{ route('umkm') }}"
               class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-stone-500 hover:text-forest-800 transition-colors group">
                <i data-lucide="arrow-left" class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform text-sand-500"></i>
                Kembali ke UMKM
            </a>
        </div>

    </div>
</div>
@endsection
