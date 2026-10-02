@extends('layouts.app')

@section('title', 'Wisata Desa Jambelaer | Destinasi Wisata Kabupaten Subang')
@section('meta_desc', 'Jelajahi keindahan alam, budaya, kuliner, dan pesona pariwisata Desa Jambelaer, Kecamatan Dawuan, Kabupaten Subang. Temukan destinasi wisata lokal yang autentik.')

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Beranda",
      "item": "{{ config('app.url') }}"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "Wisata Desa Jambelaer",
      "item": "{{ config('app.url') }}/wisata"
    }
  ]
}
</script>
@endpush

@section('content')

{{-- ══════════════════════════════════════════════════════════════════
     PAGE HEADER BANNER & BREADCRUMB
══════════════════════════════════════════════════════════════════ --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 sm:pt-6">
    <nav class="flex items-center gap-1.5 text-xs text-stone-500 mb-4 reveal-fade-up">
        <a href="{{ route('home') }}" class="hover:text-forest-800 transition-colors">Beranda</a>
        <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-stone-300"></i>
        <span class="text-forest-800 font-semibold">Wisata Desa</span>
    </nav>
</div>

<div class="relative h-60 sm:h-72 lg:h-80 overflow-hidden bg-forest-900 rounded-[28px] sm:rounded-[32px] mx-3 sm:mx-5 lg:mx-6 shadow-sm">
    <img src="{{ asset('uploads/img/beranda.jpeg') }}"
         alt="Wisata Alam Desa Jambelaer" class="w-full h-full object-cover opacity-60">
    <div class="absolute inset-0 bg-gradient-to-t from-forest-950/90 via-forest-900/50 to-forest-900/20"></div>
    <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
        <span class="section-label !bg-white/10 !text-sand-300 !border-white/20">Eksplorasi Desa</span>
        <h1 class="font-display font-extrabold text-3xl sm:text-4xl lg:text-5xl text-white mt-3">Destinasi Pariwisata</h1>
        <p class="text-xs sm:text-sm text-white/70 mt-2 font-light max-w-md">Temukan keindahan alam pedesaan, inovasi lingkungan, dan kehangatan warga Desa Jambelaer</p>
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
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8" id="wisata-grid">
            @forelse($wisatas as $index => $w)
            <div class="wisata-card card-village overflow-hidden flex flex-col h-full reveal-fade-up" style="transition-delay: {{ ($index % 3) * 100 }}ms" data-category="{{ $w->kategori }}">
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
            <div class="sm:col-span-2 lg:col-span-3 text-center py-16 bg-stone-50 rounded-2xl border border-stone-100">
                <div class="w-14 h-14 mx-auto rounded-full bg-forest-50 text-forest-700 flex items-center justify-center mb-3">
                    <i data-lucide="map-pin-off" class="w-7 h-7"></i>
                </div>
                <h3 class="font-display font-bold text-lg text-stone-800">Belum Ada Destinasi Wisata</h3>
                <p class="text-stone-500 text-sm mt-1">Data destinasi wisata belum tersedia di database saat ini.</p>
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
