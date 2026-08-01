@extends('layouts.app')

@section('title', 'UMKM')
@section('meta_desc', 'Temukan produk UMKM unggulan Desa Jambelaer – opak, gula aren, beras organik, keripik singkong, dan kerajinan bambu buatan warga lokal.')

@section('content')

{{-- ══════════════════════════════════════════════════════════════════
     PAGE HEADER BANNER
══════════════════════════════════════════════════════════════════ --}}
<div class="relative h-64 sm:h-80 overflow-hidden bg-forest-900 rounded-[32px] mx-3 sm:mx-5 lg:mx-6 mt-8 sm:mt-10 shadow-sm">
    <img src="{{ asset('uploads/img/beranda.jpeg') }}"
        alt="UMKM Desa Jambelaer" class="w-full h-full object-cover opacity-70">
    <div class="absolute inset-0 bg-gradient-to-t from-forest-900/90 via-forest-900/40 to-forest-900/20"></div>
    <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
        <span class="section-label !bg-white/10 !text-sand-300 !border-white/20">Kreativitas Lokal</span>
        <h1 class="font-display font-extrabold text-3xl sm:text-4xl text-white mt-3">Produk Unggulan UMKM</h1>
        <p class="text-sm text-white/70 mt-2 font-light max-w-xl">Dukung perekonomian lokal dengan membeli karya khas Desa Jambelaer</p>
    </div>
</div>

<div class="bg-white pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- ── Filter Buttons ── --}}
        <div class="flex flex-wrap justify-center gap-2 py-10 reveal-on-scroll delay-100">
            <button class="filter-btn active px-5 py-2.5 rounded-full text-xs font-bold tracking-wide uppercase transition-all duration-300 bg-forest-800 text-white shadow-sm border border-forest-800" data-filter="all">Semua</button>
            <button class="filter-btn px-5 py-2.5 rounded-full text-xs font-bold tracking-wide uppercase transition-all duration-300 bg-white text-stone-600 border border-stone-200 hover:border-forest-300" data-filter="makanan">Makanan</button>
            <button class="filter-btn px-5 py-2.5 rounded-full text-xs font-bold tracking-wide uppercase transition-all duration-300 bg-white text-stone-600 border border-stone-200 hover:border-forest-300" data-filter="kerajinan">Kerajinan</button>
            <button class="filter-btn px-5 py-2.5 rounded-full text-xs font-bold tracking-wide uppercase transition-all duration-300 bg-white text-stone-600 border border-stone-200 hover:border-forest-300" data-filter="pertanian">Pertanian</button>
        </div>

        {{-- ── Products Grid ── --}}
        <div id="products-grid" class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 reveal-on-scroll delay-200">

            {{-- Jenis Group Cards (e.g. Opak) --}}
            @foreach($jenisGroups as $jenisSlug => $jenisProducts)
            @php
            $firstProd = $jenisProducts->first();
            $producerCount = $jenisProducts->count();
            $allCats = $jenisProducts->flatMap(fn ($p) => $p->category)->unique()->values()->toArray();
            @endphp
            <a href="{{ route('umkm.jenis', $jenisSlug) }}"
                id="jenis-{{ $jenisSlug }}"
                class="product-card group bg-white border border-stone-200 rounded-xl overflow-hidden flex flex-col transition-all duration-300 hover:border-forest-300 hover:shadow-md hover:-translate-y-1"
                data-category="{{ implode(',', $allCats) }}"
                style="transition: opacity .3s, transform .3s;">

                {{-- Image --}}
                <div class="relative overflow-hidden h-48">
                    {{-- Badge kategori --}}
                    <span class="absolute top-3 left-3 z-10 px-2.5 py-1 rounded bg-forest-50 border border-forest-100 text-[10px] font-extrabold tracking-wider uppercase text-forest-800 shadow-sm">
                        {{ $firstProd->badge }}
                    </span>
                    {{-- Badge jumlah produsen --}}
                    <span class="absolute top-3 right-3 z-10 flex items-center gap-1 px-2.5 py-1 rounded bg-sand-50 border border-sand-100 text-[10px] font-bold text-sand-700 shadow-sm">
                        <i data-lucide="users" class="w-3 h-3"></i>
                        {{ $producerCount }} Produsen
                    </span>
                    <img src="{{ $firstProd->img }}" alt="{{ $firstProd->jenis_label ?? ucfirst($jenisSlug) }}"
                        class="w-full h-full object-cover group-hover:scale-103 transition-transform duration-500">
                    {{-- Overlay dengan nama jenis --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-forest-950/80 to-transparent flex items-end p-4">
                        <h2 class="text-white font-display font-extrabold text-base leading-tight">
                            {{ $firstProd->jenis_label ?? ucfirst($jenisSlug) }}
                        </h2>
                    </div>
                </div>

                {{-- Info --}}
                <div class="p-5 flex-grow flex flex-col">
                    <p class="text-xs text-stone-500 font-light leading-relaxed">
                        Diproduksi oleh
                        <span class="font-bold text-forest-800">{{ $producerCount }} UMKM lokal</span>
                        di Desa Jambelaer. Pilih produsen favorit Anda.
                    </p>
                    <div class="flex items-center justify-between mt-auto pt-4 border-t border-stone-100">
                        <span class="text-xs font-bold text-forest-800 flex items-center gap-1.5">
                            <i data-lucide="store" class="w-3.5 h-3.5 text-sand-500"></i>
                            Lihat Semua Produsen
                        </span>
                        <i data-lucide="arrow-right" class="w-3.5 h-3.5 text-forest-700 group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </div>
            </a>
            @endforeach

            {{-- Individual Product Cards --}}
            @foreach($individualProducts as $product)
            <a href="{{ route('umkm.detail', $product->slug) }}"
                id="produk-{{ $product->id }}"
                class="product-card group bg-white border border-stone-200 rounded-xl overflow-hidden flex flex-col transition-all duration-300 hover:border-forest-300 hover:shadow-md hover:-translate-y-1"
                data-category="{{ implode(',', $product->category) }}"
                style="transition: opacity .3s, transform .3s;">

                {{-- Image --}}
                <div class="relative overflow-hidden h-48">
                    <span class="absolute top-3 left-3 z-10 px-2.5 py-1 rounded text-[10px] font-extrabold tracking-wider uppercase shadow-sm
                        {{ $product->badge === 'Makanan'   ? 'bg-amber-50 border border-amber-100 text-amber-800'
                        : ($product->badge === 'Kerajinan' ? 'bg-violet-50 border border-violet-100 text-violet-800'
                        : 'bg-forest-50 border border-forest-100 text-forest-900') }}">
                        {{ $product->badge }}
                    </span>
                    <img src="{{ $product->img }}" alt="{{ $product->title }}"
                        class="w-full h-full object-cover group-hover:scale-103 transition-transform duration-500">
                </div>

                {{-- Info --}}
                <div class="p-5 flex-grow flex flex-col">
                    <span class="text-[10px] font-bold text-stone-400 tracking-wider block uppercase">{{ $product->producer }}</span>
                    <h2 class="font-display font-bold text-sm text-stone-800 mt-1 flex-grow">{{ $product->title }}</h2>
                    <p class="text-xs text-stone-500 font-light mt-1.5 leading-relaxed line-clamp-2">{{ $product->desc_short }}</p>
                    <div class="flex items-center justify-between mt-auto pt-4 border-t border-stone-100">
                        <span class="text-xs font-extrabold font-display text-sand-700">{{ $product->price }}</span>
                        <span class="text-xs font-semibold text-forest-800 flex items-center gap-1 group-hover:gap-2 transition-all">
                            Detail <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                        </span>
                    </div>
                </div>
            </a>
            @endforeach

        </div>
    </div>
</div>

@push('scripts')
        <script>
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const cat = this.dataset.filter;
                    document.querySelectorAll('.filter-btn').forEach(b => {
                        b.classList.remove('bg-forest-800', 'text-white', 'shadow-sm', 'border-forest-800');
                        b.classList.add('bg-white', 'text-stone-600', 'border', 'border-stone-200');
                    });
                    this.classList.add('bg-forest-800', 'text-white', 'shadow-sm', 'border-forest-800');
                    this.classList.remove('bg-white', 'text-stone-600', 'border', 'border-stone-200');

                    document.querySelectorAll('.product-card').forEach(card => {
                        const cats = card.dataset.category.split(',');
                        if (cat === 'all' || cats.includes(cat)) {
                            card.style.opacity = '0';
                            card.style.transform = 'scale(0.96)';
                            card.style.display = 'flex';
                            requestAnimationFrame(() => {
                                card.style.opacity = '1';
                                card.style.transform = 'scale(1)';
                            });
                        } else {
                            card.style.opacity = '0';
                            card.style.transform = 'scale(0.96)';
                            setTimeout(() => {
                                card.style.display = 'none';
                            }, 300);
                        }
                    });
                });
            });
        </script>
        @endpush
@endsection