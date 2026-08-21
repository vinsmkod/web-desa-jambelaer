@extends('layouts.app')

@section('title', 'Galeri Foto Desa Jambelaer | Dokumentasi Kegiatan Desa')
@section('meta_desc', 'Dokumentasi foto kegiatan, acara, budaya, dan pembangunan Desa Jambelaer, Kecamatan Dawuan, Kabupaten Subang. Saksikan momen dan aktivitas warga desa.')

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    { "@type": "ListItem", "position": 1, "name": "Beranda", "item": "{{ config('app.url') }}" },
    { "@type": "ListItem", "position": 2, "name": "Galeri Desa Jambelaer", "item": "{{ config('app.url') }}/galeri" }
  ]
}
</script>
@endpush

@section('content')

{{-- ══════════════════════════════════════════════════════════════════
     PAGE HEADER BANNER
══════════════════════════════════════════════════════════════════ --}}
<div class="relative h-64 sm:h-80 overflow-hidden bg-forest-900 rounded-[32px] mx-3 sm:mx-5 lg:mx-6 mt-8 sm:mt-10 shadow-sm">
    <img src="{{ asset('uploads/img/beranda.jpeg') }}"
         alt="Galeri Desa Jambelaer" class="w-full h-full object-cover opacity-60">
    <div class="absolute inset-0 bg-gradient-to-t from-forest-950/90 via-forest-900/50 to-forest-900/20"></div>
    <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
        <span class="section-label !bg-white/10 !text-sand-300 !border-white/20">Dokumentasi Desa</span>
        <h1 class="font-display font-extrabold text-3xl sm:text-4xl text-white mt-3">Galeri Desa Jambelaer</h1>
        <p class="text-sm text-white/70 mt-2 font-light max-w-md">Kumpulan momen kegiatan kemasyarakatan, pembangunan, seni, dan budaya</p>
    </div>
</div>

<div class="bg-white pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- ── Filter Category Buttons ── --}}
        <div class="flex flex-wrap items-center justify-center gap-2 py-10 reveal-on-scroll">
            <button onclick="filterGallery('all')" id="btn-cat-all"
                class="gallery-filter-btn px-5 py-2.5 rounded-full text-xs font-bold tracking-wide uppercase transition-all duration-300 bg-forest-800 text-white shadow-sm border border-forest-800">
                Semua Kategori
            </button>
            @foreach($kategoriList as $key => $label)
            <button onclick="filterGallery('{{ $key }}')" id="btn-cat-{{ $key }}"
                class="gallery-filter-btn px-5 py-2.5 rounded-full text-xs font-bold tracking-wide uppercase transition-all duration-300 bg-white border border-stone-200 text-stone-600 hover:border-forest-300">
                {{ $label }}
            </button>
            @endforeach
        </div>

        {{-- ── Gallery Grid ── --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($galeris as $index => $g)
            <div class="gallery-item bg-white rounded-xl overflow-hidden border border-stone-200 shadow-sm hover:shadow-md hover:border-forest-200 transition-all duration-300 flex flex-col group reveal-fade-up"
                 style="transition-delay: {{ ($index % 3) * 100 }}ms"
                 data-category="{{ $g->kategori }}">
                <div class="relative h-56 overflow-hidden bg-stone-50">
                    <img src="{{ $g->foto_url }}"
                         alt="{{ $g->judul }} – Foto {{ $g->kategori_label }} Desa Jambelaer"
                         class="w-full h-full object-cover group-hover:scale-103 transition-transform duration-500"
                         loading="lazy" width="400" height="225">
                    <div class="absolute inset-0 bg-gradient-to-t from-forest-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                        <a href="{{ route('galeri.detail', $g->slug ?: $g->galeri_id) }}"
                           class="inline-flex items-center text-xs font-bold text-white bg-forest-800/90 hover:bg-forest-700 px-4 py-2 rounded transition-all">
                            Lihat Foto <i data-lucide="arrow-right" class="w-3.5 h-3.5 ml-1.5 text-sand-300"></i>
                        </a>
                    </div>
                    <span class="absolute top-3 left-3 text-[10px] font-bold tracking-wider uppercase text-forest-800 bg-forest-50 border border-forest-100 px-2.5 py-1 rounded shadow-sm">
                        {{ $g->kategori_label }}
                    </span>
                </div>
                <div class="p-5 flex-grow flex flex-col justify-between">
                    <div>
                        <h3 class="font-display font-bold text-base text-stone-800 group-hover:text-forest-700 transition-colors line-clamp-1">
                            {{ $g->judul }}
                        </h3>
                        @if($g->deskripsi)
                        <p class="text-xs text-stone-500 font-light mt-1.5 line-clamp-2 leading-relaxed">
                            {{ $g->deskripsi }}
                        </p>
                        @endif
                    </div>
                    <div class="mt-4 pt-4 border-t border-stone-100 flex items-center justify-between text-xs text-stone-400 font-medium">
                        <span class="flex items-center">
                            <i data-lucide="calendar" class="w-3.5 h-3.5 mr-1.5 text-sand-500"></i>
                            {{ $g->tanggal_publikasi ? $g->tanggal_publikasi->translatedFormat('d M Y') : $g->created_at->translatedFormat('d M Y') }}
                        </span>
                        <a href="{{ route('galeri.detail', $g->slug ?: $g->galeri_id) }}" class="text-forest-700 font-bold hover:underline flex items-center gap-0.5">
                            Detail <i data-lucide="arrow-right" class="w-3 h-3"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full bg-white border border-stone-200 rounded-xl p-10 text-center max-w-sm mx-auto shadow-sm">
                <div class="w-12 h-12 rounded-lg bg-forest-50 border border-forest-100 text-forest-700 flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="image" class="w-6 h-6"></i>
                </div>
                <h3 class="font-display font-bold text-base text-stone-800">Belum Ada Foto</h3>
                <p class="text-stone-400 font-light text-xs mt-1">Dokumentasi desa akan ditambahkan oleh admin secara berkala.</p>
            </div>
            @endforelse
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    function filterGallery(category) {
        const items = document.querySelectorAll('.gallery-item');
        const buttons = document.querySelectorAll('.gallery-filter-btn');

        buttons.forEach(btn => {
            btn.classList.remove('bg-forest-800', 'text-white', 'shadow-sm', 'border-forest-800');
            btn.classList.add('bg-white', 'border', 'border-stone-200', 'text-stone-600');
        });

        const activeBtn = document.getElementById('btn-cat-' + category);
        if (activeBtn) {
            activeBtn.classList.remove('bg-white', 'border', 'border-stone-200', 'text-stone-600');
            activeBtn.classList.add('bg-forest-800', 'text-white', 'shadow-sm', 'border-forest-800');
        }

        items.forEach(item => {
            if (category === 'all' || item.getAttribute('data-category') === category) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    }
</script>
@endpush
