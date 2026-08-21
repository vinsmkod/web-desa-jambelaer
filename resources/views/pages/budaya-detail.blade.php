@extends('layouts.app')

@section('title', $budaya->title . ' | Budaya Desa Jambelaer')
@section('meta_desc', Str::limit($budaya->excerpt ?: ($budaya->title . ' – Kesenian dan tradisi budaya khas Desa Jambelaer, Kecamatan Dawuan, Kabupaten Subang.'), 155))
@section('og_image', $budaya->img_url ?? (isset($budaya->img) ? asset($budaya->img) : asset('uploads/img/DESA_JAMBELAER.png')))

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@graph": [
    {
      "@type": "Article",
      "headline": {{ json_encode($budaya->title) }},
      "description": {{ json_encode(Str::limit($budaya->excerpt ?: $budaya->desc, 200)) }},
      "image": {{ json_encode($budaya->img_url ?? (isset($budaya->img) ? asset($budaya->img) : asset('uploads/img/DESA_JAMBELAER.png'))) }},
      "author": {
        "@type": "Organization",
        "name": "Pemerintah Desa Jambelaer"
      },
      "publisher": {
        "@type": "GovernmentOrganization",
        "name": "Pemerintah Desa Jambelaer",
        "logo": {
          "@type": "ImageObject",
          "url": "{{ config('app.url') }}/uploads/img/DESA_JAMBELAER.png"
        }
      },
      "about": {
        "@type": "Thing",
        "name": {{ json_encode($budaya->kategori ?? 'Budaya') }},
        "description": "Budaya dan tradisi lokal Desa Jambelaer, Kecamatan Dawuan, Kabupaten Subang"
      },
      "inLanguage": "id-ID",
      "url": "{{ config('app.url') }}/budaya/{{ $budaya->slug ?? $budaya->budaya_id }}"
    },
    {
      "@type": "BreadcrumbList",
      "itemListElement": [
        { "@type": "ListItem", "position": 1, "name": "Beranda", "item": "{{ config('app.url') }}" },
        { "@type": "ListItem", "position": 2, "name": "Budaya", "item": "{{ config('app.url') }}/budaya" },
        { "@type": "ListItem", "position": 3, "name": {{ json_encode($budaya->title) }}, "item": "{{ config('app.url') }}/budaya/{{ $budaya->slug ?? $budaya->budaya_id }}" }
      ]
    }
  ]
}
</script>
@endpush

@section('content')
<div class="pt-24 pb-20 bg-stone-50/50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb Navigation -->
        <nav class="mb-6 flex flex-wrap items-center gap-1.5 text-xs text-stone-500" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-forest-800 transition-colors">Beranda</a>
            <i data-lucide="chevron-right" class="w-3 h-3 flex-shrink-0 text-stone-300" aria-hidden="true"></i>
            <a href="{{ route('budaya') }}" class="hover:text-forest-800 transition-colors">Budaya</a>
            <i data-lucide="chevron-right" class="w-3 h-3 flex-shrink-0 text-stone-300" aria-hidden="true"></i>
            <span class="text-forest-800 font-semibold truncate max-w-xs" aria-current="page">{{ $budaya->title }}</span>
        </nav>

        <!-- Main Article Container -->
        <article class="bg-white border border-stone-200 rounded-xl overflow-hidden shadow-sm">
            
            <!-- Hero Image Banner -->
            <div class="h-64 sm:h-96 relative">
                <img src="{{ isset($budaya->img_url) ? $budaya->img_url : asset($budaya->img ?? '') }}"
                     alt="{{ $budaya->title }} – Tradisi Budaya Desa Jambelaer, Kabupaten Subang"
                     class="w-full h-full object-cover"
                     loading="eager" width="800" height="500">
                <!-- Dark gradient overlay for modern look -->
                <div class="absolute inset-0 bg-gradient-to-t from-forest-950 via-forest-900/30 to-transparent"></div>
                
                <div class="absolute bottom-6 left-6 right-6 sm:bottom-8 sm:left-8 sm:right-8 text-white">
                    <span class="inline-block text-[10px] font-bold tracking-widest uppercase text-forest-800 bg-sand-200 px-3 py-1 rounded mb-3">
                        {{ $budaya->kategori }}
                    </span>
                    <h1 class="font-display font-extrabold text-2xl sm:text-3xl text-white drop-shadow-sm leading-tight break-words">
                        {{ $budaya->title }}
                    </h1>
                </div>
            </div>

            <!-- Content Area -->
            <div class="p-6 sm:p-10 space-y-6">
                <!-- Intro / Excerpt -->
                <p class="text-stone-900 font-serif font-medium text-lg leading-relaxed border-l-4 border-sand-500 pl-4 py-1 italic bg-sand-50/50 rounded-r break-words">
                    {{ $budaya->excerpt }}
                </p>

                <!-- Full Body Description -->
                <div class="text-stone-600 font-light text-sm sm:text-base leading-relaxed space-y-4 pt-2 break-words">
                    @foreach(explode("\n", $budaya->desc) as $paragraph)
                        @if(trim($paragraph) !== '')
                            <p>{{ $paragraph }}</p>
                        @endif
                    @endforeach
                </div>

                <!-- Footer share or info info -->
                <div class="pt-8 border-t border-stone-100 flex flex-wrap items-center justify-between gap-4 text-xs text-stone-400">
                    <div class="flex items-center gap-1.5 font-medium">
                        <i data-lucide="info" class="w-4 h-4 text-forest-700"></i>
                        <span>Pelestarian Adat Desa Jambelaer</span>
                    </div>
                    <span>Terakhir diperbarui: {{ isset($budaya->updated_at) && $budaya->updated_at instanceof \Carbon\Carbon ? $budaya->updated_at->translatedFormat('d F Y') : now()->translatedFormat('d F Y') }}</span>
                </div>
            </div>

        </article>

        <!-- Related / Other Cultures Recommendations -->
        @if(!empty($rekomendasi))
        <div class="mt-16">
            <div class="flex items-center justify-between mb-6">
                <h2 class="font-display font-extrabold text-lg sm:text-xl text-stone-800">
                    Kearifan Lokal Lainnya
                </h2>
                <a href="{{ route('budaya') }}" class="text-xs font-bold text-forest-750 hover:text-forest-650 transition-colors uppercase tracking-wider">
                    Lihat semua budaya &rarr;
                </a>
            </div>

            <div class="grid sm:grid-cols-3 gap-5">
                @foreach($rekomendasi as $rek)
                <a href="{{ route('budaya.detail', $rek->slug ?? $rek->budaya_id) }}"
                   class="group bg-white border border-stone-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
                    <div class="h-40 relative overflow-hidden">
                        <img src="{{ isset($rek->img_url) ? $rek->img_url : asset($rek->img ?? '') }}"
                             alt="{{ $rek->title }} – Budaya Desa Jambelaer"
                             class="w-full h-full object-cover group-hover:scale-103 transition-transform duration-500"
                             loading="lazy" width="300" height="160">
                        <div class="absolute inset-0 bg-gradient-to-t from-forest-950/70 to-transparent"></div>
                        <span class="absolute top-2.5 left-2.5 text-[9px] font-bold text-forest-800 bg-sand-200 px-2 py-0.5 rounded uppercase tracking-wide">
                            {{ $rek->kategori }}
                        </span>
                    </div>
                    <div class="p-4">
                        <h3 class="font-display font-bold text-stone-800 group-hover:text-forest-700 transition-colors text-sm leading-snug line-clamp-1">
                            {{ $rek->title }}
                        </h3>
                        <p class="text-xs text-stone-500 mt-1 line-clamp-2 font-light">
                            {{ isset($rek->excerpt) ? $rek->excerpt : 'Klik untuk melihat detail tradisi desa.' }}
                        </p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>
@endsection
