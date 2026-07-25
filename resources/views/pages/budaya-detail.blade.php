@extends('layouts.app')

@section('title', $budaya->title)
@section('meta_desc', $budaya->excerpt)

@section('content')
<div class="pt-24 pb-20 bg-stone-50/50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb / Back Navigation -->
        <div class="mb-6">
            <a href="{{ route('budaya') }}" class="inline-flex items-center gap-2 text-xs font-bold tracking-wide uppercase text-forest-800 hover:text-forest-650 transition-colors">
                <i data-lucide="arrow-left" class="w-4 h-4 text-sand-500"></i>
                Kembali ke Budaya
            </a>
        </div>

        <!-- Main Article Container -->
        <article class="bg-white border border-stone-200 rounded-xl overflow-hidden shadow-sm">
            
            <!-- Hero Image Banner -->
            <div class="h-64 sm:h-96 relative">
                <img src="{{ isset($budaya->img_url) ? $budaya->img_url : asset($budaya->img) }}" 
                     alt="{{ $budaya->title }}" 
                     class="w-full h-full object-cover">
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
                <a href="{{ route('budaya.detail', $rek->id) }}" 
                   class="group bg-white border border-stone-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
                    <div class="h-40 relative overflow-hidden">
                        <img src="{{ isset($rek->img_url) ? $rek->img_url : asset($rek->img) }}" 
                             alt="{{ $rek->title }}" 
                             class="w-full h-full object-cover group-hover:scale-103 transition-transform duration-500">
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
