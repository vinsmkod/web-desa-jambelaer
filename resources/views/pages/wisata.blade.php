@extends('layouts.app')

@section('title', 'Wisata Desa')
@section('meta_desc', 'Jelajahi keindahan alam, budaya, kuliner, dan pesona pariwisata Desa Jambelaer, Kecamatan Dawuan, Kabupaten Subang.')

@section('content')

{{-- ══════════════════════════════════════════════════════════════════
     PAGE HEADER BANNER
     ══════════════════════════════════════════════════════════════════ --}}
<div class="relative h-64 sm:h-80 overflow-hidden bg-forest-900 rounded-[32px] mx-3 sm:mx-5 lg:mx-6 mt-8 sm:mt-10 shadow-sm">
    <img src="https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?auto=format&fit=crop&w=1920&q=80"
         alt="Wisata Alam Desa Jambelaer" class="w-full h-full object-cover opacity-70">
    <div class="absolute inset-0 bg-gradient-to-t from-forest-900 to-forest-900/50"></div>
    <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
        <span class="section-label !bg-white/10 !text-sand-300 !border-white/20">Eksplorasi Desa</span>
        <h1 class="font-display font-extrabold text-3xl sm:text-4xl text-white mt-3">Destinasi Pariwisata</h1>
        <p class="text-sm text-white/50 mt-2 font-light max-w-md">Temukan keindahan tersembunyi, tradisi lokal, dan kuliner khas Desa Jambelaer</p>
    </div>
</div>

<div class="bg-white pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center py-10 reveal-on-scroll">
            <span class="section-label">Pesona Jambelaer</span>
            <h2 class="font-display font-extrabold text-2xl sm:text-3xl text-forest-900 mt-3">Destinasi Wisata Unggulan</h2>
            <div class="section-divider"></div>
        </div>

        {{-- ══════════════════════════════════════════════════════════════════
             CATEGORY FILTERS
             ══════════════════════════════════════════════════════════════════ --}}
        <div class="flex flex-wrap items-center justify-center gap-2 mb-10 reveal-on-scroll">
            <button onclick="filterCategory('all')" id="btn-cat-all" class="filter-btn active-filter px-4 py-2 text-xs font-bold uppercase tracking-wider rounded-full border border-stone-200 hover:border-forest-500 hover:text-forest-800 transition-all cursor-pointer">
                Semua Wisata
            </button>
            @foreach($kategoriList as $key => $label)
                <button onclick="filterCategory('{{ $key }}')" id="btn-cat-{{ $key }}" class="filter-btn px-4 py-2 text-xs font-bold uppercase tracking-wider rounded-full border border-stone-200 hover:border-forest-500 hover:text-forest-800 transition-all cursor-pointer text-stone-600 bg-white">
                    {{ $label }}
                </button>
            @endforeach
        </div>

        {{-- ══════════════════════════════════════════════════════════════════
             WISATA GRID
             ══════════════════════════════════════════════════════════════════ --}}
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8 reveal-on-scroll delay-100" id="wisata-grid">
            @forelse($wisatas as $w)
            <div class="wisata-card card-village overflow-hidden flex flex-col h-full" data-category="{{ $w->kategori }}">
                <div class="relative aspect-16/10 overflow-hidden bg-slate-100 flex-shrink-0">
                    <img src="{{ $w->gambar_url }}" alt="{{ $w->nama }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                    <span class="absolute top-4 left-4 text-[10px] font-bold text-forest-800 bg-forest-50 border border-forest-200/60 px-3 py-1 rounded-full uppercase tracking-wider shadow-sm">
                        {{ $w->kategori_label }}
                    </span>
                </div>
                <div class="p-6 flex flex-col flex-1">
                    <div class="flex items-center gap-1 text-[11px] text-sand-500 font-semibold uppercase tracking-wider">
                        <i data-lucide="ticket" class="w-3.5 h-3.5"></i>
                        <span>HTM: {{ $w->harga_tiket }}</span>
                    </div>
                    <h3 class="font-display font-bold text-xl text-forest-900 mt-2 line-clamp-1">{{ $w->nama }}</h3>
                    <p class="text-stone-500 text-sm font-light leading-relaxed mt-2 line-clamp-2">{{ $w->ringkasan }}</p>
                    <div class="flex items-center gap-1.5 text-xs text-stone-400 mt-4">
                        <i data-lucide="map-pin" class="w-4 h-4 text-stone-300 flex-shrink-0"></i>
                        <span class="truncate">{{ $w->alamat }}</span>
                    </div>
                    <div class="mt-6 pt-4 border-t border-stone-100 flex items-center justify-between mt-auto">
                        <span class="text-xs text-stone-400 font-medium flex items-center gap-1">
                            <i data-lucide="clock" class="w-3.5 h-3.5"></i> {{ $w->jam_operasional }}
                        </span>
                        <a href="{{ route('wisata.detail', $w->slug) }}" class="inline-flex items-center text-xs font-bold text-forest-700 hover:text-forest-900 group">
                            Lihat Detail 
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5 ml-1 transition-transform group-hover:translate-x-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            {{-- Fallback Destinasi 1: Curug Cipeuteuy --}}
            <div class="wisata-card card-village overflow-hidden flex flex-col h-full" data-category="alam">
                <div class="relative aspect-16/10 overflow-hidden bg-slate-100 flex-shrink-0">
                    <img src="https://images.unsplash.com/photo-1546182990-dffeafbe841d?auto=format&fit=crop&w=800&q=80" alt="Curug Cipeuteuy" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                    <span class="absolute top-4 left-4 text-[10px] font-bold text-forest-800 bg-forest-50 border border-forest-200/60 px-3 py-1 rounded-full uppercase tracking-wider shadow-sm">
                        Wisata Alam
                    </span>
                </div>
                <div class="p-6 flex flex-col flex-1">
                    <div class="flex items-center gap-1 text-[11px] text-sand-500 font-semibold uppercase tracking-wider">
                        <i data-lucide="ticket" class="w-3.5 h-3.5"></i>
                        <span>HTM: Rp 10.000</span>
                    </div>
                    <h3 class="font-display font-bold text-xl text-forest-900 mt-2 line-clamp-1">Curug Cipeuteuy</h3>
                    <p class="text-stone-500 text-sm font-light leading-relaxed mt-2 line-clamp-2">Air terjun alami dengan air pegunungan yang sangat jernih dan dikelilingi hutan pinus yang asri.</p>
                    <div class="flex items-center gap-1.5 text-xs text-stone-400 mt-4">
                        <i data-lucide="map-pin" class="w-4 h-4 text-stone-300 flex-shrink-0"></i>
                        <span class="truncate">Dusun Cikondang, Desa Jambelaer</span>
                    </div>
                    <div class="mt-6 pt-4 border-t border-stone-100 flex items-center justify-between mt-auto">
                        <span class="text-xs text-stone-400 font-medium flex items-center gap-1">
                            <i data-lucide="clock" class="w-3.5 h-3.5"></i> 08:00 - 17:00 WIB
                        </span>
                        <a href="#" class="inline-flex items-center text-xs font-bold text-forest-700 hover:text-forest-900 group">
                            Lihat Detail 
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5 ml-1 transition-transform group-hover:translate-x-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Fallback Destinasi 2: Kebun Teh Jambelaer --}}
            <div class="wisata-card card-village overflow-hidden flex flex-col h-full" data-category="alam">
                <div class="relative aspect-16/10 overflow-hidden bg-slate-100 flex-shrink-0">
                    <img src="https://images.unsplash.com/photo-1555899434-94d1368aa7af?auto=format&fit=crop&w=800&q=80" alt="Kebun Teh" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                    <span class="absolute top-4 left-4 text-[10px] font-bold text-forest-800 bg-forest-50 border border-forest-200/60 px-3 py-1 rounded-full uppercase tracking-wider shadow-sm">
                        Wisata Alam
                    </span>
                </div>
                <div class="p-6 flex flex-col flex-1">
                    <div class="flex items-center gap-1 text-[11px] text-sand-500 font-semibold uppercase tracking-wider">
                        <i data-lucide="ticket" class="w-3.5 h-3.5"></i>
                        <span>HTM: Gratis</span>
                    </div>
                    <h3 class="font-display font-bold text-xl text-forest-900 mt-2 line-clamp-1">Perkebunan Teh Hijau</h3>
                    <p class="text-stone-500 text-sm font-light leading-relaxed mt-2 line-clamp-2">Hamparan bukit kebun teh hijau yang menyejukkan mata dengan udara pagi yang sangat segar.</p>
                    <div class="flex items-center gap-1.5 text-xs text-stone-400 mt-4">
                        <i data-lucide="map-pin" class="w-4 h-4 text-stone-300 flex-shrink-0"></i>
                        <span class="truncate">Dusun Babakan, Desa Jambelaer</span>
                    </div>
                    <div class="mt-6 pt-4 border-t border-stone-100 flex items-center justify-between mt-auto">
                        <span class="text-xs text-stone-400 font-medium flex items-center gap-1">
                            <i data-lucide="clock" class="w-3.5 h-3.5"></i> 24 Jam
                        </span>
                        <a href="#" class="inline-flex items-center text-xs font-bold text-forest-700 hover:text-forest-900 group">
                            Lihat Detail 
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5 ml-1 transition-transform group-hover:translate-x-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Fallback Destinasi 3: Kampung Adat Sunda --}}
            <div class="wisata-card card-village overflow-hidden flex flex-col h-full" data-category="budaya">
                <div class="relative aspect-16/10 overflow-hidden bg-slate-100 flex-shrink-0">
                    <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=800&q=80" alt="Kampung Budaya" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                    <span class="absolute top-4 left-4 text-[10px] font-bold text-forest-800 bg-forest-50 border border-forest-200/60 px-3 py-1 rounded-full uppercase tracking-wider shadow-sm">
                        Wisata Budaya
                    </span>
                </div>
                <div class="p-6 flex flex-col flex-1">
                    <div class="flex items-center gap-1 text-[11px] text-sand-500 font-semibold uppercase tracking-wider">
                        <i data-lucide="ticket" class="w-3.5 h-3.5"></i>
                        <span>HTM: Sukarela</span>
                    </div>
                    <h3 class="font-display font-bold text-xl text-forest-900 mt-2 line-clamp-1">Kampung Restorasi Budaya</h3>
                    <p class="text-stone-500 text-sm font-light leading-relaxed mt-2 line-clamp-2">Pusat pelestarian adat istiadat, kerajinan anyaman bambu, dan pertunjukan seni musik tradisional Sunda.</p>
                    <div class="flex items-center gap-1.5 text-xs text-stone-400 mt-4">
                        <i data-lucide="map-pin" class="w-4 h-4 text-stone-300 flex-shrink-0"></i>
                        <span class="truncate">Kampung Gede, Desa Jambelaer</span>
                    </div>
                    <div class="mt-6 pt-4 border-t border-stone-100 flex items-center justify-between mt-auto">
                        <span class="text-xs text-stone-400 font-medium flex items-center gap-1">
                            <i data-lucide="clock" class="w-3.5 h-3.5"></i> 09:00 - 16:00 WIB
                        </span>
                        <a href="#" class="inline-flex items-center text-xs font-bold text-forest-700 hover:text-forest-900 group">
                            Lihat Detail 
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5 ml-1 transition-transform group-hover:translate-x-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

<style>
    .active-filter {
        background-color: var(--color-forest-800);
        color: white !important;
        border-color: var(--color-forest-800);
    }
</style>

<script>
    function filterCategory(category) {
        // Toggle active button style
        const buttons = document.querySelectorAll('.filter-btn');
        buttons.forEach(btn => {
            btn.classList.remove('active-filter');
            btn.classList.add('text-stone-600', 'bg-white');
        });

        const activeBtn = document.getElementById('btn-cat-' + category);
        activeBtn.classList.add('active-filter');
        activeBtn.classList.remove('text-stone-600', 'bg-white');

        // Filter cards
        const cards = document.querySelectorAll('.wisata-card');
        cards.forEach(card => {
            if (category === 'all') {
                card.style.display = 'flex';
            } else {
                if (card.getAttribute('data-category') === category) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            }
        });
    }
</script>

@endsection
