@extends('layouts.app')

@section('title', 'Budaya')
@section('meta_desc', 'Kenali kekayaan seni dan tradisi budaya Desa Jambelaer – Ruwatan Bumi, Sisingaan, Pencak Silat, dan Karnaval Milangkala tahunan.')

@section('content')
<div class="pt-28 pb-24 bg-white/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-16 reveal-on-scroll">
            <span class="text-xs font-bold tracking-widest uppercase text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full">Kearifan Sunda</span>
            <h1 class="font-display font-extrabold text-3xl sm:text-4xl text-emerald-950 mt-3">Pelestarian Seni &amp; Tradisi Budaya</h1>
            <p class="mt-4 text-slate-500 font-light text-sm sm:text-base">
                Masyarakat Desa Jambelaer memegang teguh falsafah kebersamaan dan merawat tradisi Sunda peninggalan leluhur sebagai identitas kehidupan.
            </p>
            <div class="w-16 h-1 bg-gradient-to-r from-emerald-800 to-amber-600 mx-auto mt-4 rounded-full"></div>
        </div>

        <!-- Culture Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 reveal-on-scroll delay-100">
            @forelse($budayas as $b)
            <a href="{{ route('budaya.detail', $b->id) }}" class="group relative overflow-hidden rounded-3xl h-96 shadow-md border border-slate-100 block">
                <img src="{{ $b->img_url }}"
                     alt="{{ $b->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-emerald-950 via-emerald-900/40 to-transparent flex flex-col justify-end p-6">
                    <span class="text-xs font-bold text-emerald-300 tracking-widest uppercase block mb-1">{{ $b->kategori }}</span>
                    <h3 class="font-display font-bold text-xl text-white">{{ $b->title }}</h3>
                    <p class="text-xs text-white/70 line-clamp-2 mt-2 font-light">{{ $b->excerpt }}</p>
                    <span class="inline-flex items-center text-xs font-semibold text-amber-400 mt-4">
                        Lihat Detail <i data-lucide="arrow-right" class="w-3.5 h-3.5 ml-1 group-hover:translate-x-1 transition-transform"></i>
                    </span>
                </div>
            </a>
            @empty
            <!-- Fallback Item 1: Ruwatan Bumi -->
            <a href="{{ route('budaya.detail', 1) }}" class="group relative overflow-hidden rounded-3xl h-96 shadow-md border border-slate-100 block">
                <img src="https://images.unsplash.com/photo-1530595467537-0b5996c41f2d?auto=format&fit=crop&w=600&h=800&q=80"
                     alt="Ruwatan Bumi" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-emerald-950 via-emerald-900/40 to-transparent flex flex-col justify-end p-6">
                    <span class="text-xs font-bold text-emerald-300 tracking-widest uppercase block mb-1">Upacara Adat</span>
                    <h3 class="font-display font-bold text-xl text-white">Ruwatan Bumi</h3>
                    <p class="text-xs text-white/70 line-clamp-2 mt-2 font-light">Upacara adat tanda syukur hasil bumi pertanian desa yang melimpah.</p>
                    <span class="inline-flex items-center text-xs font-semibold text-amber-400 mt-4">
                        Lihat Detail <i data-lucide="arrow-right" class="w-3.5 h-3.5 ml-1 group-hover:translate-x-1 transition-transform"></i>
                    </span>
                </div>
            </a>

            <!-- Fallback Item 2: Sisingaan -->
            <a href="{{ route('budaya.detail', 2) }}" class="group relative overflow-hidden rounded-3xl h-96 shadow-md border border-slate-100 block">
                <img src="https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?auto=format&fit=crop&w=600&h=800&q=80"
                     alt="Seni Sisingaan" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-emerald-950 via-emerald-900/40 to-transparent flex flex-col justify-end p-6">
                    <span class="text-xs font-bold text-emerald-300 tracking-widest uppercase block mb-1">Seni Pertunjukan</span>
                    <h3 class="font-display font-bold text-xl text-white">Seni Sisingaan</h3>
                    <p class="text-xs text-white/70 line-clamp-2 mt-2 font-light">Atraksi budaya khas Subang pemacu semangat kebersamaan rakyat.</p>
                    <span class="inline-flex items-center text-xs font-semibold text-amber-400 mt-4">
                        Lihat Detail <i data-lucide="arrow-right" class="w-3.5 h-3.5 ml-1 group-hover:translate-x-1 transition-transform"></i>
                    </span>
                </div>
            </a>

            <!-- Fallback Item 3: Pencak Silat -->
            <a href="{{ route('budaya.detail', 3) }}" class="group relative overflow-hidden rounded-3xl h-96 shadow-md border border-slate-100 block">
                <img src="https://images.unsplash.com/photo-1555597673-b21d5c935865?auto=format&fit=crop&w=600&h=800&q=80"
                     alt="Pencak Silat" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-emerald-950 via-emerald-900/40 to-transparent flex flex-col justify-end p-6">
                    <span class="text-xs font-bold text-emerald-300 tracking-widest uppercase block mb-1">Seni Bela Diri</span>
                    <h3 class="font-display font-bold text-xl text-white">Pencak Silat</h3>
                    <p class="text-xs text-white/70 line-clamp-2 mt-2 font-light">Pelatihan fisik dan spiritual bela diri Sunda yang menjunjung persaudaraan.</p>
                    <span class="inline-flex items-center text-xs font-semibold text-amber-400 mt-4">
                        Lihat Detail <i data-lucide="arrow-right" class="w-3.5 h-3.5 ml-1 group-hover:translate-x-1 transition-transform"></i>
                    </span>
                </div>
            </a>

            <!-- Fallback Item 4: Milangkala -->
            <a href="{{ route('budaya.detail', 4) }}" class="group relative overflow-hidden rounded-3xl h-96 shadow-md border border-slate-100 block">
                <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=600&h=800&q=80"
                     alt="Karnaval Budaya" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-emerald-950 via-emerald-900/40 to-transparent flex flex-col justify-end p-6">
                    <span class="text-xs font-bold text-emerald-300 tracking-widest uppercase block mb-1">Festival Tahunan</span>
                    <h3 class="font-display font-bold text-xl text-white">Milangkala Desa</h3>
                    <p class="text-xs text-white/70 line-clamp-2 mt-2 font-light">Peringatan hari lahir desa yang diramaikan pawai budaya kreasi warga.</p>
                    <span class="inline-flex items-center text-xs font-semibold text-amber-400 mt-4">
                        Lihat Detail <i data-lucide="arrow-right" class="w-3.5 h-3.5 ml-1 group-hover:translate-x-1 transition-transform"></i>
                    </span>
                </div>
            </a>
            @endforelse
        </div><!-- /grid -->
    </div>
</div>
@endsection
