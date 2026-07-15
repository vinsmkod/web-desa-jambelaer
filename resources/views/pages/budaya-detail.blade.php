@extends('layouts.app')

@section('title', $budaya->title)
@section('meta_desc', $budaya->excerpt)

@section('content')
<div class="pt-24 pb-20 bg-slate-50/50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb / Back Navigation -->
        <div class="mb-6">
            <a href="{{ route('budaya') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-emerald-800 hover:text-emerald-950 transition-colors">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Kembali ke Budaya
            </a>
        </div>

        <!-- Main Article Container -->
        <article class="bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm">
            
            <!-- Hero Image Banner -->
            <div class="h-64 sm:h-96 relative">
                <img src="{{ isset($budaya->img_url) ? $budaya->img_url : asset($budaya->img) }}" 
                     alt="{{ $budaya->title }}" 
                     class="w-full h-full object-cover">
                <!-- Dark gradient overlay for modern look -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                
                <div class="absolute bottom-6 left-6 right-6 sm:bottom-8 sm:left-8 sm:right-8 text-white">
                    <span class="inline-block text-xs font-bold tracking-widest uppercase text-emerald-300 bg-emerald-950/60 backdrop-blur-md px-3 py-1 rounded-full border border-emerald-800/40 mb-3">
                        {{ $budaya->kategori }}
                    </span>
                    <h1 class="font-display font-extrabold text-2xl sm:text-4xl text-white drop-shadow-sm leading-tight break-words">
                        {{ $budaya->title }}
                    </h1>
                </div>
            </div>

            <!-- Content Area -->
            <div class="p-6 sm:p-10 space-y-6">
                <!-- Intro / Excerpt -->
                <p class="text-slate-900 font-medium text-lg leading-relaxed border-l-4 border-amber-500 pl-4 py-1 italic bg-amber-50/30 rounded-r-xl break-words">
                    {{ $budaya->excerpt }}
                </p>

                <!-- Full Body Description -->
                <div class="text-slate-600 font-light text-base leading-relaxed space-y-4 pt-2 break-words">
                    @foreach(explode("\n", $budaya->desc) as $paragraph)
                        @if(trim($paragraph) !== '')
                            <p>{{ $paragraph }}</p>
                        @endif
                    @endforeach
                </div>

                <!-- Footer share or info info -->
                <div class="pt-8 border-t border-slate-100 flex flex-wrap items-center justify-between gap-4 text-xs text-slate-400">
                    <div class="flex items-center gap-1">
                        <i data-lucide="info" class="w-4 h-4 text-emerald-600"></i>
                        <span>Pelestarian Adat Desa Jambelaer</span>
                    </div>
                    <span>Terakhir diperbarui: {{ isset($budaya->updated_at) && $budaya->updated_at instanceof \Carbon\Carbon ? $budaya->updated_at->translatedFormat('d F Y') : now()->translatedFormat('d F Y') }}</span>
                </div>
            </div>

        </article>

        <!-- Related / Other Cultures Recommendations -->
        @if(!empty($rekomendasi))
        <div class="mt-16">
            <div class="flex items-center justify-between mb-8">
                <h2 class="font-display font-extrabold text-xl sm:text-2xl text-emerald-950">
                    Kearifan Lokal Lainnya
                </h2>
                <a href="{{ route('budaya') }}" class="text-sm font-semibold text-emerald-700 hover:text-emerald-950 transition-colors">
                    Lihat semua budaya →
                </a>
            </div>

            <div class="grid sm:grid-cols-3 gap-6">
                @foreach($rekomendasi as $rek)
                <a href="{{ route('budaya.detail', $rek->id) }}" 
                   class="group bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <div class="h-44 relative overflow-hidden">
                        <img src="{{ isset($rek->img_url) ? $rek->img_url : asset($rek->img) }}" 
                             alt="{{ $rek->title }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <span class="absolute top-3 left-3 text-[10px] font-bold text-emerald-300 bg-emerald-950/60 backdrop-blur-md px-2.5 py-0.5 rounded-full uppercase tracking-wide">
                            {{ $rek->kategori }}
                        </span>
                    </div>
                    <div class="p-4">
                        <h3 class="font-display font-bold text-slate-800 group-hover:text-emerald-800 transition-colors text-sm sm:text-base leading-snug line-clamp-1">
                            {{ $rek->title }}
                        </h3>
                        <p class="text-xs text-slate-500 mt-2 line-clamp-2 font-light">
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
