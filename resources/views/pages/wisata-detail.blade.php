@extends('layouts.app')

@section('title', $wisata->nama)
@section('meta_desc', $wisata->ringkasan)

@section('content')
<div class="pt-24 pb-20 bg-stone-50/50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb / Back Navigation -->
        <div class="mb-6">
            <a href="{{ route('wisata') }}" class="inline-flex items-center gap-2 text-xs font-bold tracking-wide uppercase text-forest-800 hover:text-forest-650 transition-colors">
                <i data-lucide="arrow-left" class="w-4 h-4 text-sand-500"></i>
                Kembali ke Wisata
            </a>
        </div>

        <!-- Main Article Container -->
        <article class="bg-white border border-stone-200 rounded-2xl overflow-hidden shadow-sm">
            
            <!-- Hero Image Banner -->
            <div class="h-64 sm:h-96 relative">
                <img src="{{ $wisata->gambar_url }}" 
                     alt="{{ $wisata->nama }}" 
                     class="w-full h-full object-cover">
                <!-- Dark gradient overlay for modern look -->
                <div class="absolute inset-0 bg-gradient-to-t from-forest-950 via-forest-900/30 to-transparent"></div>
                
                <div class="absolute bottom-6 left-6 right-6 sm:bottom-8 sm:left-8 sm:right-8 text-white">
                    <span class="inline-block text-[10px] font-bold tracking-widest uppercase text-forest-800 bg-sand-200 px-3 py-1 rounded-md mb-3">
                        {{ $wisata->kategori_label }}
                    </span>
                    <h1 class="font-display font-extrabold text-2xl sm:text-3xl text-white drop-shadow-sm leading-tight break-words">
                        {{ $wisata->nama }}
                    </h1>
                </div>
            </div>

            <!-- Content Area -->
            <div class="p-6 sm:p-10 space-y-8">
                
                <!-- Quick Info Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="p-4 rounded-xl bg-forest-50 border border-forest-100 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-forest-800 flex items-center justify-center text-amber-300 flex-shrink-0">
                            <i data-lucide="ticket" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <span class="text-[10px] text-stone-400 font-semibold uppercase tracking-wider block">Harga Tiket</span>
                            <span class="text-sm font-bold text-forest-900 leading-tight block">{{ $wisata->harga_tiket }}</span>
                        </div>
                    </div>
                    <div class="p-4 rounded-xl bg-forest-50 border border-forest-100 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-forest-800 flex items-center justify-center text-amber-300 flex-shrink-0">
                            <i data-lucide="clock" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <span class="text-[10px] text-stone-400 font-semibold uppercase tracking-wider block">Operasional</span>
                            <span class="text-sm font-bold text-forest-900 leading-tight block">{{ $wisata->jam_operasional }}</span>
                        </div>
                    </div>
                    <div class="p-4 rounded-xl bg-forest-50 border border-forest-100 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-forest-800 flex items-center justify-center text-amber-300 flex-shrink-0">
                            <i data-lucide="map-pin" class="w-5 h-5"></i>
                        </div>
                        <div class="min-w-0">
                            <span class="text-[10px] text-stone-400 font-semibold uppercase tracking-wider block">Alamat</span>
                            <span class="text-sm font-bold text-forest-900 leading-tight block truncate" title="{{ $wisata->alamat }}">{{ $wisata->alamat }}</span>
                        </div>
                    </div>
                </div>

                <!-- Intro / Excerpt -->
                <p class="text-stone-900 font-serif font-medium text-lg leading-relaxed border-l-4 border-sand-500 pl-4 py-1 italic bg-sand-50/50 rounded-r break-words">
                    {{ $wisata->ringkasan }}
                </p>

                <!-- Full Body Description -->
                <div class="text-stone-600 font-light text-sm sm:text-base leading-relaxed space-y-4 pt-2 break-words">
                    @foreach(explode("\n", $wisata->deskripsi) as $paragraph)
                        @if(trim($paragraph) !== '')
                            <p>{{ $paragraph }}</p>
                        @endif
                    @endforeach
                </div>

                {{-- ══════════════════════════════════════════════════════════════════
                     MAPS IFRAME EMBED
                     ══════════════════════════════════════════════════════════════════ --}}
                @if($wisata->maps_iframe)
                <div class="space-y-3 pt-6 border-t border-stone-100">
                    <h3 class="font-display font-bold text-stone-800 text-base flex items-center gap-2">
                        <i data-lucide="map" class="w-5 h-5 text-forest-800"></i> Peta Lokasi Destinasi
                    </h3>
                    <div class="rounded-2xl overflow-hidden shadow-sm border border-stone-200 aspect-video w-full relative">
                        @php
                            $mapsData = $wisata->maps_iframe;
                            $isIframe = str_contains($mapsData, '<iframe');
                            $isSafeUrl = str_starts_with($mapsData, 'http') &&
                                         (str_contains($mapsData, 'google.com/maps') ||
                                          str_contains($mapsData, 'maps.google.com'));
                        @endphp
                        @if($isIframe)
                            {{-- Data sudah disanitasi oleh SecurityHelper saat disimpan --}}
                            {!! $mapsData !!}
                        @elseif($isSafeUrl)
                            <iframe class="w-full h-full border-0" src="{{ $mapsData }}" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Footer share or info info -->
                <div class="pt-8 border-t border-stone-100 flex flex-wrap items-center justify-between gap-4 text-xs text-stone-400">
                    <div class="flex items-center gap-1.5 font-medium">
                        <i data-lucide="info" class="w-4 h-4 text-forest-700"></i>
                        <span>Eksplorasi Pariwisata Desa Jambelaer</span>
                    </div>
                    <span>Terakhir diperbarui: {{ $wisata->updated_at ? $wisata->updated_at->translatedFormat('d F Y') : now()->translatedFormat('d F Y') }}</span>
                </div>
            </div>

        </article>

        <!-- Related / Other Destinations Recommendations -->
        @if($rekomendasi->isNotEmpty())
        <div class="mt-16">
            <div class="flex items-center justify-between mb-6">
                <h2 class="font-display font-extrabold text-lg sm:text-xl text-stone-800">
                    Destinasi Wisata Lainnya
                </h2>
                <a href="{{ route('wisata') }}" class="text-xs font-bold text-forest-750 hover:text-forest-650 transition-colors uppercase tracking-wider">
                    Lihat semua wisata &rarr;
                </a>
            </div>

            <div class="grid sm:grid-cols-3 gap-5">
                @foreach($rekomendasi as $rek)
                <a href="{{ route('wisata.detail', $rek->slug) }}" 
                   class="group bg-white border border-stone-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
                    <div class="h-40 relative overflow-hidden">
                        <img src="{{ $rek->gambar_url }}" 
                             alt="{{ $rek->nama }}" 
                             class="w-full h-full object-cover group-hover:scale-103 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-forest-950/70 to-transparent"></div>
                        <span class="absolute top-2.5 left-2.5 text-[9px] font-bold text-forest-800 bg-sand-200 px-2 py-0.5 rounded uppercase tracking-wide">
                            {{ $rek->kategori_label }}
                        </span>
                    </div>
                    <div class="p-4">
                        <h3 class="font-display font-bold text-stone-800 group-hover:text-forest-700 transition-colors text-sm leading-snug line-clamp-1">
                            {{ $rek->nama }}
                        </h3>
                        <p class="text-xs text-stone-500 mt-1 line-clamp-2 font-light">
                            {{ $rek->ringkasan }}
                        </p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>

<style>
    iframe {
        width: 100% !important;
        height: 100% !important;
        border: 0;
    }
</style>
@endsection
