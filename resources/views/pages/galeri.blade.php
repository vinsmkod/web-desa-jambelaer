@extends('layouts.app')

@section('title', 'Galeri Desa')
@section('meta_desc', 'Dokumentasi kegiatan, acara, potensi UMKM, budaya, dan pembangunan Desa Jambelaer, Kecamatan Dawuan, Kabupaten Subang.')

@section('content')
<div class="pt-28 pb-24 bg-gradient-to-b from-ivory to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-12 reveal-on-scroll">
            <span class="text-xs font-bold tracking-widest uppercase text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full">Dokumentasi Desa</span>
            <h1 class="font-display font-extrabold text-3xl sm:text-4xl text-emerald-950 mt-3">Galeri Desa Jambelaer</h1>
            <p class="mt-4 text-slate-500 font-light text-sm sm:text-base">
                Kumpulan momen, kegiatan kemasyarakatan, pagelaran budaya, produk UMKM, dan dokumentasi pembangunan Desa Jambelaer.
            </p>
            <div class="w-16 h-1 bg-gradient-to-r from-emerald-800 to-amber-600 mx-auto mt-4 rounded-full"></div>
        </div>

        <!-- Filter Category Buttons -->
        <div class="flex flex-wrap items-center justify-center gap-2 mb-10 reveal-on-scroll">
            <button onclick="filterGallery('all')" id="btn-cat-all"
                class="gallery-filter-btn px-5 py-2 rounded-full text-xs font-bold tracking-wide transition-all bg-emerald-900 text-white shadow-sm">
                Semua Kategori
            </button>
            @foreach($kategoriList as $key => $label)
            <button onclick="filterGallery('{{ $key }}')" id="btn-cat-{{ $key }}"
                class="gallery-filter-btn px-5 py-2 rounded-full text-xs font-semibold tracking-wide transition-all bg-white border border-slate-200 text-slate-600 hover:border-emerald-700 hover:text-emerald-900">
                {{ $label }}
            </button>
            @endforeach
        </div>

        <!-- Gallery Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 reveal-on-scroll delay-100">
            @forelse($galeris as $g)
            <div class="gallery-item bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col group"
                 data-category="{{ $g->kategori }}">
                <div class="relative h-60 overflow-hidden bg-slate-100">
                    <img src="{{ $g->foto }}" alt="{{ $g->judul }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-emerald-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                        <a href="{{ route('galeri.detail', $g->id) }}"
                           class="inline-flex items-center text-xs font-bold text-white bg-emerald-600/90 hover:bg-emerald-600 px-4 py-2 rounded-xl backdrop-blur-sm transition-all">
                            Lihat Detail Foto <i data-lucide="arrow-right" class="w-3.5 h-3.5 ml-1.5"></i>
                        </a>
                    </div>
                    <span class="absolute top-4 left-4 text-[10px] font-bold tracking-wider uppercase text-white bg-emerald-900/90 px-3 py-1 rounded-full backdrop-blur-sm">
                        {{ $g->kategori_label }}
                    </span>
                </div>
                <div class="p-6 flex-grow flex flex-col justify-between">
                    <div>
                        <h3 class="font-display font-bold text-lg text-emerald-950 group-hover:text-emerald-700 transition-colors line-clamp-1">
                            {{ $g->judul }}
                        </h3>
                        @if($g->deskripsi)
                        <p class="text-xs text-slate-500 font-light mt-2 line-clamp-2 leading-relaxed">
                            {{ $g->deskripsi }}
                        </p>
                        @endif
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-50 flex items-center justify-between text-xs text-slate-400 font-medium">
                        <span class="flex items-center">
                            <i data-lucide="calendar" class="w-3.5 h-3.5 mr-1.5 text-amber-600"></i>
                            {{ $g->tanggal_publikasi ? $g->tanggal_publikasi->translatedFormat('d M Y') : $g->created_at->translatedFormat('d M Y') }}
                        </span>
                        <a href="{{ route('galeri.detail', $g->id) }}" class="text-emerald-700 font-bold hover:underline">
                            Detail &rarr;
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full bg-white border border-slate-100 rounded-3xl p-12 text-center max-w-md mx-auto shadow-sm">
                <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="image" class="w-8 h-8"></i>
                </div>
                <h3 class="font-display font-bold text-lg text-emerald-950">Belum Ada Foto Galeri</h3>
                <p class="text-slate-500 font-light text-xs mt-1">Foto galeri desa akan ditampilkan di sini setelah ditambahkan oleh admin.</p>
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
            btn.classList.remove('bg-emerald-900', 'text-white', 'shadow-sm');
            btn.classList.add('bg-white', 'border', 'border-slate-200', 'text-slate-600');
        });

        const activeBtn = document.getElementById('btn-cat-' + category);
        if (activeBtn) {
            activeBtn.classList.remove('bg-white', 'border', 'border-slate-200', 'text-slate-600');
            activeBtn.classList.add('bg-emerald-900', 'text-white', 'shadow-sm');
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
