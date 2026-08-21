@extends('layouts.app')

@section('title', $foto->judul . ' | Galeri Desa Jambelaer')
@section('meta_desc', Str::limit($foto->deskripsi ? $foto->deskripsi : ($foto->judul . ' – Dokumentasi foto ' . $foto->kategori_label . ' Desa Jambelaer, Kecamatan Dawuan, Kabupaten Subang.'), 155))
@section('og_type', 'article')
@section('og_image', $foto->foto_url)

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@graph": [
    {
      "@type": "ImageObject",
      "name": {{ json_encode($foto->judul) }},
      "description": {{ json_encode(Str::limit($foto->deskripsi ?? ($foto->judul . ' – Foto ' . $foto->kategori_label . ' Desa Jambelaer'), 200)) }},
      "contentUrl": {{ json_encode($foto->foto_url) }},
      "url": "{{ config('app.url') }}/galeri/{{ $foto->slug ?: $foto->galeri_id }}",
      "author": {
        "@type": "Organization",
        "name": "Pemerintah Desa Jambelaer"
      },
      "datePublished": "{{ $foto->tanggal_publikasi ? $foto->tanggal_publikasi->toIso8601String() : $foto->created_at->toIso8601String() }}",
      "inLanguage": "id-ID"
    },
    {
      "@type": "BreadcrumbList",
      "itemListElement": [
        { "@type": "ListItem", "position": 1, "name": "Beranda", "item": "{{ config('app.url') }}" },
        { "@type": "ListItem", "position": 2, "name": "Galeri Desa Jambelaer", "item": "{{ config('app.url') }}/galeri" },
        { "@type": "ListItem", "position": 3, "name": {{ json_encode($foto->judul) }}, "item": "{{ config('app.url') }}/galeri/{{ $foto->slug ?: $foto->galeri_id }}" }
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
        <nav aria-label="Breadcrumb" class="flex items-center flex-wrap gap-1.5 text-xs text-stone-500 mb-6 reveal-on-scroll">
            <a href="{{ route('home') }}" class="hover:text-forest-800 transition-colors">Beranda</a>
            <i data-lucide="chevron-right" class="w-3 h-3 flex-shrink-0 text-stone-300" aria-hidden="true"></i>
            <a href="{{ route('galeri') }}" class="hover:text-forest-800 transition-colors">Galeri</a>
            <i data-lucide="chevron-right" class="w-3 h-3 flex-shrink-0 text-stone-300" aria-hidden="true"></i>
            <span class="text-forest-800 font-semibold truncate max-w-xs" aria-current="page">{{ $foto->judul }}</span>
        </nav>

        <div class="grid lg:grid-cols-12 gap-8 items-start">
            {{-- ── Left / Main: Photo ── --}}
            <div class="lg:col-span-8 space-y-6 reveal-on-scroll">
                <div class="relative rounded-xl overflow-hidden shadow-sm border border-stone-200 bg-stone-900">
                    <img src="{{ $foto->foto_url }}"
                         alt="{{ $foto->judul }} – {{ $foto->kategori_label }} Desa Jambelaer, Kecamatan Dawuan, Kabupaten Subang"
                         class="w-full h-auto max-h-[600px] object-contain mx-auto"
                         loading="eager" width="900" height="600">
                    <span class="absolute top-4 left-4 px-2.5 py-1 rounded text-[10px] font-extrabold tracking-wider uppercase shadow-sm bg-forest-800 text-white">
                        {{ $foto->kategori_label }}
                    </span>
                </div>

                <div class="bg-white border border-stone-200 rounded-xl p-6 sm:p-8 shadow-sm space-y-4">
                    <div class="flex flex-wrap items-center justify-between gap-2 border-b border-stone-100 pb-4">
                        <h1 class="font-display font-extrabold text-xl sm:text-2xl text-stone-800">
                            {{ $foto->judul }}
                        </h1>
                        <span class="text-xs font-semibold text-stone-400 flex items-center">
                            <i data-lucide="calendar" class="w-4 h-4 mr-1.5 text-sand-500" aria-hidden="true"></i>
                            <time datetime="{{ $foto->tanggal_publikasi ? $foto->tanggal_publikasi->toIso8601String() : $foto->created_at->toIso8601String() }}">
                                {{ $foto->tanggal_publikasi ? $foto->tanggal_publikasi->translatedFormat('d F Y') : $foto->created_at->translatedFormat('d F Y') }}
                            </time>
                        </span>
                    </div>

                    @if($foto->deskripsi)
                    <div>
                        <h2 class="text-[10px] font-bold text-stone-400 uppercase tracking-wider mb-2">Deskripsi</h2>
                        <p class="text-stone-600 text-sm sm:text-base leading-relaxed whitespace-pre-line font-light">
                            {{ $foto->deskripsi }}
                        </p>
                    </div>
                    @endif

                    {{-- Internal linking: link ke halaman galeri utama --}}
                    <div class="pt-4 border-t border-stone-100">
                        <a href="{{ route('galeri') }}"
                           class="inline-flex items-center text-xs font-bold text-forest-800 hover:text-forest-650 transition-colors">
                            <i data-lucide="arrow-left" class="w-4 h-4 mr-1.5 text-sand-500" aria-hidden="true"></i>
                            Kembali ke Galeri Desa Jambelaer
                        </a>
                    </div>
                </div>
            </div>

            {{-- ── Right: Related Photos ── --}}
            <div class="lg:col-span-4 space-y-6 reveal-on-scroll delay-100">
                <div class="bg-white border border-stone-200 rounded-xl p-6 shadow-sm">
                    <h2 class="font-display font-bold text-stone-800 text-sm mb-4 flex items-center">
                        <i data-lucide="image" class="w-4 h-4 mr-2 text-forest-750" aria-hidden="true"></i>
                        Foto Terkait
                    </h2>

                    @if($lainnya->isNotEmpty())
                    <div class="space-y-3">
                        @foreach($lainnya as $item)
                        <a href="{{ route('galeri.detail', $item->slug ?: $item->galeri_id) }}"
                           class="group flex items-center gap-3 p-2.5 rounded-lg border border-stone-200 hover:border-forest-200 hover:bg-forest-50/20 transition-all">
                            <img src="{{ $item->foto_url }}"
                                 alt="{{ $item->judul }} – Galeri {{ $item->kategori_label }} Desa Jambelaer"
                                 class="w-14 h-14 object-cover rounded flex-shrink-0"
                                 loading="lazy" width="56" height="56">
                            <div class="min-w-0 flex-grow">
                                <h3 class="text-xs font-bold text-stone-850 group-hover:text-forest-700 truncate">
                                    {{ $item->judul }}
                                </h3>
                                <span class="text-[10px] text-stone-400 block mt-1">
                                    {{ $item->tanggal_publikasi ? $item->tanggal_publikasi->translatedFormat('d M Y') : $item->created_at->translatedFormat('d M Y') }}
                                </span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    @else
                    <p class="text-xs text-stone-400 font-light">Tidak ada foto lain dalam kategori ini.</p>
                    @endif

                    <div class="mt-6 pt-4 border-t border-stone-100">
                        <a href="{{ route('galeri') }}"
                           class="inline-flex items-center text-xs font-bold text-forest-800 hover:text-forest-650 transition-colors uppercase tracking-wider">
                            <i data-lucide="arrow-left" class="w-4 h-4 mr-1.5 text-sand-500" aria-hidden="true"></i>
                            Kembali ke Galeri
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
