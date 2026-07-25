@extends('layouts.app')

@section('title', 'Budaya')
@section('meta_desc', 'Kenali kekayaan seni dan tradisi budaya Desa Jambelaer – Ruwatan Bumi, Sisingaan, Pencak Silat, dan Karnaval Milangkala tahunan.')

@section('content')

{{-- ══════════════════════════════════════════════════════════════════
     PAGE HEADER BANNER
══════════════════════════════════════════════════════════════════ --}}
<div class="relative h-52 sm:h-64 overflow-hidden bg-forest-900 rounded-[32px] mx-3 sm:mx-5 lg:mx-6 mt-6 shadow-sm">
    <img src="https://images.unsplash.com/photo-1530595467537-0b5996c41f2d?auto=format&fit=crop&w=1920&q=80"
         alt="Budaya Sunda Desa Jambelaer" class="w-full h-full object-cover opacity-20">
    <div class="absolute inset-0 bg-gradient-to-t from-forest-900 to-forest-900/50"></div>
    <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
        <span class="section-label !bg-white/10 !text-sand-300 !border-white/20">Kearifan Sunda</span>
        <h1 class="font-display font-extrabold text-3xl sm:text-4xl text-white mt-3">Pelestarian Seni & Tradisi</h1>
        <p class="text-sm text-white/50 mt-2 font-light max-w-md">Merawat tradisi leluhur sebagai pilar identitas dan falsafah hidup</p>
    </div>
</div>

<div class="bg-white pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center py-10 reveal-on-scroll">
            <span class="section-label">Warisan Budaya</span>
            <h2 class="font-display font-extrabold text-2xl sm:text-3xl text-forest-900 mt-3">Kearifan Lokal Desa</h2>
            <div class="section-divider"></div>
        </div>

        <!-- Culture Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 reveal-on-scroll delay-100">
            @forelse($budayas as $b)
            <a href="{{ route('budaya.detail', $b->id) }}" class="group relative overflow-hidden rounded-xl h-[420px] shadow-sm border border-stone-200 block transition-all duration-300 hover:border-forest-300 hover:shadow-md">
                <img src="{{ $b->img_url }}"
                     alt="{{ $b->title }}" class="w-full h-full object-cover group-hover:scale-103 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-forest-950 via-forest-900/40 to-transparent flex flex-col justify-end p-6">
                    <span class="text-[10px] font-bold text-sand-300 tracking-widest uppercase block mb-1.5">{{ $b->kategori }}</span>
                    <h3 class="font-display font-bold text-lg text-white leading-tight">{{ $b->title }}</h3>
                    <p class="text-xs text-white/70 line-clamp-2 mt-2 font-light leading-relaxed">{{ $b->excerpt }}</p>
                    <span class="inline-flex items-center text-xs font-semibold text-sand-300 mt-4 group-hover:text-white transition-colors">
                        Lihat Selengkapnya <i data-lucide="arrow-right" class="w-3.5 h-3.5 ml-1 group-hover:translate-x-1 transition-transform"></i>
                    </span>
                </div>
            </a>
            @empty
            <!-- Fallback Item 1: Ruwatan Bumi -->
            <a href="{{ route('budaya.detail', 1) }}" class="group relative overflow-hidden rounded-xl h-[420px] shadow-sm border border-stone-200 block transition-all duration-300 hover:border-forest-300 hover:shadow-md">
                <img src="https://images.unsplash.com/photo-1530595467537-0b5996c41f2d?auto=format&fit=crop&w=600&h=800&q=80"
                     alt="Ruwatan Bumi" class="w-full h-full object-cover group-hover:scale-103 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-forest-950 via-forest-900/40 to-transparent flex flex-col justify-end p-6">
                    <span class="text-[10px] font-bold text-sand-300 tracking-widest uppercase block mb-1.5 font-semibold">Upacara Adat</span>
                    <h3 class="font-display font-bold text-lg text-white leading-tight">Ruwatan Bumi</h3>
                    <p class="text-xs text-white/70 line-clamp-2 mt-2 font-light leading-relaxed">Upacara adat tanda syukur hasil bumi pertanian desa yang melimpah.</p>
                    <span class="inline-flex items-center text-xs font-semibold text-sand-300 mt-4 group-hover:text-white transition-colors">
                        Lihat Selengkapnya <i data-lucide="arrow-right" class="w-3.5 h-3.5 ml-1 group-hover:translate-x-1 transition-transform"></i>
                    </span>
                </div>
            </a>

            <!-- Fallback Item 2: Sisingaan -->
            <a href="{{ route('budaya.detail', 2) }}" class="group relative overflow-hidden rounded-xl h-[420px] shadow-sm border border-stone-200 block transition-all duration-300 hover:border-forest-300 hover:shadow-md">
                <img src="https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?auto=format&fit=crop&w=600&h=800&q=80"
                     alt="Seni Sisingaan" class="w-full h-full object-cover group-hover:scale-103 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-forest-950 via-forest-900/40 to-transparent flex flex-col justify-end p-6">
                    <span class="text-[10px] font-bold text-sand-300 tracking-widest uppercase block mb-1.5 font-semibold">Seni Pertunjukan</span>
                    <h3 class="font-display font-bold text-lg text-white leading-tight">Seni Sisingaan</h3>
                    <p class="text-xs text-white/70 line-clamp-2 mt-2 font-light leading-relaxed">Atraksi budaya khas Subang pemacu semangat kebersamaan rakyat.</p>
                    <span class="inline-flex items-center text-xs font-semibold text-sand-300 mt-4 group-hover:text-white transition-colors">
                        Lihat Selengkapnya <i data-lucide="arrow-right" class="w-3.5 h-3.5 ml-1 group-hover:translate-x-1 transition-transform"></i>
                    </span>
                </div>
            </a>

            <!-- Fallback Item 3: Pencak Silat -->
            <a href="{{ route('budaya.detail', 3) }}" class="group relative overflow-hidden rounded-xl h-[420px] shadow-sm border border-stone-200 block transition-all duration-300 hover:border-forest-300 hover:shadow-md">
                <img src="https://images.unsplash.com/photo-1555597673-b21d5c935865?auto=format&fit=crop&w=600&h=800&q=80"
                     alt="Pencak Silat" class="w-full h-full object-cover group-hover:scale-103 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-forest-950 via-forest-900/40 to-transparent flex flex-col justify-end p-6">
                    <span class="text-[10px] font-bold text-sand-300 tracking-widest uppercase block mb-1.5 font-semibold">Seni Bela Diri</span>
                    <h3 class="font-display font-bold text-lg text-white leading-tight">Pencak Silat</h3>
                    <p class="text-xs text-white/70 line-clamp-2 mt-2 font-light leading-relaxed">Pelatihan fisik dan spiritual bela diri Sunda yang menjunjung persaudaraan.</p>
                    <span class="inline-flex items-center text-xs font-semibold text-sand-300 mt-4 group-hover:text-white transition-colors">
                        Lihat Selengkapnya <i data-lucide="arrow-right" class="w-3.5 h-3.5 ml-1 group-hover:translate-x-1 transition-transform"></i>
                    </span>
                </div>
            </a>

            <!-- Fallback Item 4: Milangkala -->
            <a href="{{ route('budaya.detail', 4) }}" class="group relative overflow-hidden rounded-xl h-[420px] shadow-sm border border-stone-200 block transition-all duration-300 hover:border-forest-300 hover:shadow-md">
                <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=600&h=800&q=80"
                     alt="Karnaval Budaya" class="w-full h-full object-cover group-hover:scale-103 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-forest-950 via-forest-900/40 to-transparent flex flex-col justify-end p-6">
                    <span class="text-[10px] font-bold text-sand-300 tracking-widest uppercase block mb-1.5 font-semibold">Festival Tahunan</span>
                    <h3 class="font-display font-bold text-lg text-white leading-tight">Milangkala Desa</h3>
                    <p class="text-xs text-white/70 line-clamp-2 mt-2 font-light leading-relaxed">Peringatan hari lahir desa yang diramaikan pawai budaya kreasi warga.</p>
                    <span class="inline-flex items-center text-xs font-semibold text-sand-300 mt-4 group-hover:text-white transition-colors">
                        Lihat Selengkapnya <i data-lucide="arrow-right" class="w-3.5 h-3.5 ml-1 group-hover:translate-x-1 transition-transform"></i>
                    </span>
                </div>
            </a>
            @endforelse
        </div>
    </div>
</div>
@endsection
