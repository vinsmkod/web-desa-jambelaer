@extends('layouts.app')

@section('title', 'Berita Desa Jambelaer | Informasi dan Kegiatan Desa')
@section('meta_desc', 'Kumpulan berita resmi, pengumuman publik, dan warta kegiatan terkini dari Pemerintah Desa Jambelaer, Kecamatan Dawuan, Kabupaten Subang.')

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
      "name": "Berita Desa Jambelaer",
      "item": "{{ config('app.url') }}/berita"
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
        <span class="text-forest-800 font-semibold">Berita & Informasi</span>
    </nav>
</div>

<div class="relative h-60 sm:h-72 lg:h-80 overflow-hidden bg-forest-900 rounded-[28px] sm:rounded-[32px] mx-3 sm:mx-5 lg:mx-6 shadow-sm">
    <img src="{{ asset('uploads/img/beranda.jpeg') }}"
         alt="Portal Berita Desa Jambelaer, Kecamatan Dawuan, Kabupaten Subang" class="w-full h-full object-cover opacity-60"
         width="1200" height="400" loading="eager">
    <div class="absolute inset-0 bg-gradient-to-t from-forest-950/90 via-forest-900/50 to-forest-900/20"></div>
    <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
        <span class="section-label !bg-white/10 !text-sand-300 !border-white/20">Warta Resmi Desa</span>
        <h1 class="font-display font-extrabold text-3xl sm:text-4xl lg:text-5xl text-white mt-3">Berita & Kabar Desa</h1>
        <p class="text-xs sm:text-sm text-white/70 mt-2 font-light max-w-md">Informasi resmi program pembangunan, kegiatan kemasyarakatan, dan pengumuman desa</p>
    </div>
</div>

<div class="bg-white pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10">
        <!-- ── News Cards Grid ────────────────────────────────────────── -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($beritas as $index => $item)
            <article class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl border border-slate-200/80 flex flex-col justify-between group transition-all duration-300 hover:-translate-y-1 reveal-fade-up" style="transition-delay: {{ ($index % 3) * 100 }}ms">
                <div>
                    <!-- Image -->
                    <div class="relative aspect-video overflow-hidden bg-slate-100">
                        <img src="{{ $item->gambar_url }}" alt="{{ $item->judul }} - Berita Desa Jambelaer"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            loading="lazy" width="400" height="225">
                    </div>

                    <!-- Content Body -->
                    <div class="p-6 space-y-3">
                        <div class="flex items-center gap-3 text-[11px] text-slate-400">
                            <span class="flex items-center gap-1">
                                <i data-lucide="calendar" class="w-3 h-3 text-emerald-700"></i>
                                {{ $item->published_at ? $item->published_at->translatedFormat('d M Y') : $item->created_at->translatedFormat('d M Y') }}
                            </span>
                            <span>•</span>
                            <span class="flex items-center gap-1">
                                <i data-lucide="user" class="w-3 h-3 text-emerald-700"></i>
                                {{ $item->penulis }}
                            </span>
                        </div>

                        <h3 class="font-display font-bold text-base text-emerald-950 group-hover:text-emerald-700 transition-colors line-clamp-2 leading-snug">
                            <a href="{{ route('berita.detail', $item->slug) }}">
                                {{ $item->judul }}
                            </a>
                        </h3>

                        <p class="text-slate-600 text-xs line-clamp-3 leading-relaxed font-light">
                            {{ $item->ringkasan }}
                        </p>
                    </div>
                </div>

                <!-- Footer Link -->
                <div class="px-6 pb-6 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="text-slate-400 text-[11px] flex items-center gap-1">
                        <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                        {{ number_format($item->views) }} views
                    </span>
                    <a href="{{ route('berita.detail', $item->slug) }}" class="font-bold text-emerald-900 group-hover:text-emerald-700 inline-flex items-center gap-1 transition-colors">
                        Baca Artikel
                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </article>
            @empty
            <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-slate-200/80 p-8 shadow-sm">
                <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="newspaper" class="w-8 h-8"></i>
                </div>
                <h3 class="font-display font-bold text-emerald-950 text-lg">Belum Ada Artikel Berita</h3>
                <p class="text-slate-500 text-xs mt-1 max-w-sm mx-auto">
                    Berita yang sesuai dengan pencarian atau kategori ini belum tersedia. Silakan cek kembali dalam waktu dekat.
                </p>
            </div>
            @endforelse
        </div>

        @if(method_exists($beritas, 'hasPages') && $beritas->hasPages())
        <div class="pt-10">
            {{ $beritas->links() }}
        </div>
        @endif

    </div>
</div>
@endsection