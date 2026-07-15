@extends('layouts.app')

@section('title', 'UMKM')
@section('meta_desc', 'Temukan produk UMKM unggulan Desa Jambelaer – opak, gula aren, beras organik, keripik singkong, dan kerajinan bambu buatan warga lokal.')

@section('content')
<div class="pt-28 pb-24 bg-gradient-to-b from-white to-ivory">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- ── Section Header ───────────────────────────────────────────── --}}
        <div class="text-center max-w-3xl mx-auto mb-16 reveal-on-scroll">
            <span class="text-xs font-bold tracking-widest uppercase text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full">Kreativitas Lokal</span>
            <h1 class="font-display font-extrabold text-3xl sm:text-4xl text-emerald-950 mt-3">Karya &amp; Produk Unggulan UMKM</h1>
            <p class="mt-4 text-slate-500 font-light text-sm sm:text-base">
                Dukung perekonomian lokal dengan membeli produk khas Desa Jambelaer. Diproduksi secara lokal, higienis, dan ramah lingkungan oleh warga desa.
            </p>
            <div class="w-16 h-1 bg-gradient-to-r from-emerald-800 to-amber-600 mx-auto mt-4 rounded-full"></div>
        </div>

        {{-- ── Filter Buttons ───────────────────────────────────────────── --}}
        <div class="flex flex-wrap justify-center gap-3 mb-12 reveal-on-scroll delay-100">
            <button class="filter-btn active px-6 py-2.5 rounded-full text-xs font-bold tracking-wide uppercase transition-all duration-300 bg-emerald-900 text-white shadow-sm" data-filter="all">Semua</button>
            <button class="filter-btn px-6 py-2.5 rounded-full text-xs font-bold tracking-wide uppercase transition-all duration-300 bg-white text-slate-700 border border-slate-200" data-filter="makanan">Makanan</button>
            <button class="filter-btn px-6 py-2.5 rounded-full text-xs font-bold tracking-wide uppercase transition-all duration-300 bg-white text-slate-700 border border-slate-200" data-filter="kerajinan">Kerajinan</button>
            <button class="filter-btn px-6 py-2.5 rounded-full text-xs font-bold tracking-wide uppercase transition-all duration-300 bg-white text-slate-700 border border-slate-200" data-filter="pertanian">Pertanian</button>
        </div>

        {{-- ── Products Grid ────────────────────────────────────────────── --}}
        <div id="products-grid" class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8 reveal-on-scroll delay-200">

            {{-- Jenis Group Cards (e.g. Opak) --}}
            @foreach($jenisGroups as $jenisSlug => $jenisProducts)
            @php
                $firstProd     = $jenisProducts->first();
                $producerCount = $jenisProducts->count();
                $allCats       = $jenisProducts->flatMap(fn ($p) => $p->category)->unique()->values()->toArray();
            @endphp
            <a href="{{ route('umkm.jenis', $jenisSlug) }}"
               id="jenis-{{ $jenisSlug }}"
               class="product-card group relative overflow-hidden rounded-3xl shadow-sm border-2 border-emerald-200 hover:border-emerald-400 hover:shadow-xl bg-gradient-to-b from-emerald-50 to-white flex flex-col transition-all duration-300 hover:-translate-y-1"
               data-category="{{ implode(',', $allCats) }}"
               style="transition: opacity .3s, transform .3s;">

                {{-- Image --}}
                <div class="relative overflow-hidden h-52">
                    {{-- Badge kategori --}}
                    <span class="absolute top-4 left-4 z-10 px-3 py-1 rounded-full text-xs font-extrabold tracking-wider uppercase bg-emerald-100 text-emerald-900 shadow-sm">
                        {{ $firstProd->badge }}
                    </span>
                    {{-- Badge jumlah produsen --}}
                    <span class="absolute top-4 right-4 z-10 flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-400 text-amber-950 shadow-sm">
                        <i data-lucide="users" class="w-3 h-3"></i>
                        {{ $producerCount }} Produsen
                    </span>
                    <img src="{{ $firstProd->img }}" alt="{{ $firstProd->jenis_label ?? ucfirst($jenisSlug) }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    {{-- Overlay dengan nama jenis --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-emerald-950/75 to-transparent flex items-end p-5">
                        <h2 class="text-white font-display font-extrabold text-xl leading-tight">
                            {{ $firstProd->jenis_label ?? ucfirst($jenisSlug) }}
                        </h2>
                    </div>
                </div>

                {{-- Info --}}
                <div class="p-5 flex-grow flex flex-col">
                    <p class="text-xs text-slate-500 font-light leading-relaxed">
                        Diproduksi oleh
                        <span class="font-bold text-emerald-800">{{ $producerCount }} UMKM lokal</span>
                        di Desa Jambelaer. Pilih produsen favorit Anda.
                    </p>
                    <div class="flex items-center justify-between mt-4 pt-4 border-t border-emerald-100">
                        <span class="text-sm font-bold text-emerald-800 flex items-center gap-1.5">
                            <i data-lucide="store" class="w-3.5 h-3.5"></i>
                            Lihat Semua Produsen
                        </span>
                        <i data-lucide="arrow-right" class="w-4 h-4 text-emerald-700 group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </div>
            </a>
            @endforeach

            {{-- Individual Product Cards --}}
            @foreach($individualProducts as $product)
            <a href="{{ route('umkm.detail', $product->slug) }}"
               id="produk-{{ $product->id }}"
               class="product-card group relative overflow-hidden rounded-3xl shadow-sm border border-slate-100 hover:shadow-xl bg-white flex flex-col transition-all duration-300 hover:-translate-y-1"
               data-category="{{ implode(',', $product->category) }}"
               style="transition: opacity .3s, transform .3s;">

                {{-- Image --}}
                <div class="relative overflow-hidden h-52">
                    <span class="absolute top-4 left-4 z-10 px-3 py-1 rounded-full text-xs font-extrabold tracking-wider uppercase
                        {{ $product->badge === 'Makanan'   ? 'bg-amber-50 text-amber-800'
                        : ($product->badge === 'Kerajinan' ? 'bg-violet-50 text-violet-800'
                        : 'bg-emerald-50 text-emerald-900') }} shadow-sm">
                        {{ $product->badge }}
                    </span>
                    <img src="{{ $product->img }}" alt="{{ $product->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center pb-5">
                        <span class="text-white text-xs font-bold tracking-widest uppercase flex items-center gap-2 bg-black/30 px-4 py-2 rounded-full">
                            <i data-lucide="eye" class="w-3.5 h-3.5"></i> Lihat Detail
                        </span>
                    </div>
                </div>

                {{-- Info --}}
                <div class="p-5 flex-grow flex flex-col">
                    <span class="text-xs font-bold text-slate-400 tracking-wider block uppercase">{{ $product->producer }}</span>
                    <h2 class="font-display font-bold text-base text-emerald-950 mt-1 flex-grow">{{ $product->title }}</h2>
                    <p class="text-xs text-slate-500 font-light mt-2 leading-relaxed line-clamp-2">{{ $product->desc_short }}</p>
                    <div class="flex items-center justify-between mt-4 pt-4 border-t border-slate-100">
                        <span class="text-sm font-extrabold font-display text-amber-700">{{ $product->price }}</span>
                        <span class="text-xs font-semibold text-emerald-800 flex items-center gap-1 group-hover:gap-2 transition-all">
                            Detail <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                        </span>
                    </div>
                </div>
            </a>
            @endforeach

        </div>

        {{-- ── CTA Banner ───────────────────────────────────────────────── --}}
        <div class="mt-20 bg-gradient-to-r from-emerald-900 to-emerald-800 rounded-3xl p-8 sm:p-12 text-white text-center reveal-on-scroll delay-300">
            <h2 class="font-display font-bold text-2xl sm:text-3xl">Ingin Bergabung sebagai Mitra UMKM?</h2>
            <p class="text-emerald-200/80 font-light text-sm mt-3 max-w-xl mx-auto">
                Daftarkan produk Anda bersama kami dan manfaatkan jaringan distribusi digital Desa Jambelaer untuk memperluas jangkauan pasar.
            </p>
            <a href="{{ route('kontak') }}" class="mt-8 inline-flex items-center justify-center px-8 py-3.5 text-sm font-bold tracking-wide text-emerald-950 bg-white hover:bg-amber-50 rounded-xl shadow-md transition-all hover:-translate-y-0.5">
                Hubungi Kami Sekarang
                <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const cat = this.dataset.filter;
            document.querySelectorAll('.filter-btn').forEach(b => {
                b.classList.remove('bg-emerald-900', 'text-white', 'shadow-sm');
                b.classList.add('bg-white', 'text-slate-700', 'border', 'border-slate-200');
            });
            this.classList.add('bg-emerald-900', 'text-white', 'shadow-sm');
            this.classList.remove('bg-white', 'text-slate-700', 'border', 'border-slate-200');

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
                    setTimeout(() => { card.style.display = 'none'; }, 300);
                }
            });
        });
    });
</script>
@endpush
