@extends('layouts.app')

@section('title', 'Struktur Pemerintahan Desa Jambelaer | Kecamatan Dawuan, Kabupaten Subang')
@section('meta_desc', 'Struktur pemerintahan Desa Jambelaer – susunan perangkat desa, kepala desa, dan jajaran perangkat yang melayani masyarakat di Kecamatan Dawuan, Kabupaten Subang, Jawa Barat.')
@section('og_image', asset('uploads/img/sawah.jpeg'))

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
      "name": "Struktur Desa Jambelaer",
      "item": "{{ config('app.url') }}/struktur-desa"
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
        <span class="text-forest-800 font-semibold">Struktur Desa</span>
    </nav>
</div>

<div class="relative h-60 sm:h-72 lg:h-80 overflow-hidden bg-forest-900 rounded-[28px] sm:rounded-[32px] mx-3 sm:mx-5 lg:mx-6 shadow-sm">
    <img src="{{ asset('uploads/img/sawah.jpeg') }}"
        alt="Struktur pemerintahan Desa Jambelaer, Kecamatan Dawuan, Kabupaten Subang" class="w-full h-full object-cover opacity-60"
        width="1200" height="400" loading="eager">
    <div class="absolute inset-0 bg-gradient-to-t from-forest-950/90 via-forest-900/50 to-forest-900/20"></div>
    <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
        <span class="section-label !bg-white/10 !text-sand-300 !border-white/20">Struktur Desa</span>
        <h1 class="font-display font-extrabold text-3xl sm:text-4xl lg:text-5xl text-white mt-3">Struktur Pemerintahan Desa</h1>
        <p class="text-xs sm:text-sm text-white/70 mt-2 font-light max-w-md">Kecamatan Dawuan • Kabupaten Subang • Jawa Barat</p>
    </div>
</div>

<div class="bg-white pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- ══════════════════════════════════════════════════════════
             STRUKTUR ORGANISASI DESA — DINAMIS (dikelola admin)
        ═════════════════════════════════════════════════════════════ --}}
        @php
        $kepalaDesa = $struktur->first();
        $jajaranDesa = $struktur->slice(1);
        @endphp

        @if($struktur->isNotEmpty())
        <div id="struktur" class="py-16 reveal-on-scroll delay-300 scroll-mt-24">
            <div class="text-center mb-12">
                <span class="section-label">Perangkat Desa</span>
                <h2 class="font-display font-extrabold text-2xl sm:text-3xl text-forest-900 mt-3">Struktur Organisasi Desa</h2>
                <div class="section-divider"></div>
                <p class="text-stone-500 font-light mt-4 text-sm max-w-lg mx-auto">
                    Para perangkat desa yang berdedikasi melayani masyarakat Desa Jambelaer.
                </p>
            </div>

            {{-- Kepala Desa --}}
            <div class="flex justify-center mb-6">
                <div class="group bg-white border-2 border-forest-200 rounded-2xl p-6 text-center w-52 sm:w-60 hover:border-forest-400 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                    <div class="relative mb-4 inline-block">
                        <img src="{{ $kepalaDesa->foto ? asset($kepalaDesa->foto) : 'https://ui-avatars.com/api/?name='.urlencode($kepalaDesa->nama).'&background=1a4731&color=fff&size=200' }}"
                            alt="{{ $kepalaDesa->nama }}"
                            class="w-24 h-24 sm:w-28 sm:h-28 rounded-full object-cover border-4 border-white shadow-md ring-2 ring-forest-200 group-hover:ring-forest-400 transition-all duration-300">
                        <div class="absolute -bottom-1 -right-1 w-7 h-7 bg-sand-500 rounded-full flex items-center justify-center border-2 border-white">
                            <i data-lucide="star" class="w-3 h-3 text-white fill-white"></i>
                        </div>
                    </div>
                    <h3 class="font-display font-extrabold text-sm text-forest-900 leading-tight">{{ $kepalaDesa->nama }}</h3>
                    <span class="inline-block text-[11px] font-semibold text-forest-700 bg-forest-50 border border-forest-100 px-3 py-1 rounded-full mt-2">{{ $kepalaDesa->jabatan }}</span>
                </div>
            </div>

            @if($jajaranDesa->isNotEmpty())
            {{-- Connector --}}
            <div class="flex justify-center">
                <div class="w-px h-6 bg-stone-200"></div>
            </div>
            <div class="flex justify-center mb-2">
                <div class="h-px w-64 bg-stone-200"></div>
            </div>

            {{-- Jajaran Grid --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-5">
                @foreach($jajaranDesa as $index => $anggota)
                <div class="group card-village p-5 text-center reveal-fade-up" style="transition-delay: {{ ($index % 4) * 75 }}ms">
                    <div class="relative mb-4 inline-block">
                        <img src="{{ $anggota->foto ? asset($anggota->foto) : 'https://ui-avatars.com/api/?name='.urlencode($anggota->nama).'&background=1a4731&color=fff&size=200' }}"
                            alt="{{ $anggota->nama }}"
                            class="w-16 h-16 sm:w-20 sm:h-20 rounded-full object-cover border-4 border-white shadow-md ring-2 ring-stone-100 group-hover:ring-forest-200 transition-all duration-300">
                    </div>
                    <h3 class="font-display font-bold text-stone-800 text-sm leading-tight">{{ $anggota->nama }}</h3>
                    <span class="inline-block text-[11px] font-medium text-forest-700 bg-forest-50 border border-forest-100 px-2.5 py-0.5 rounded-full mt-1.5">{{ $anggota->jabatan }}</span>
                </div>
                @endforeach
            </div>
            @endif
        </div>
        @else
        {{-- Empty State --}}
        <div class="py-20 text-center">
            <div class="w-16 h-16 rounded-2xl bg-stone-100 text-stone-400 flex items-center justify-center mx-auto mb-5">
                <i data-lucide="users" class="w-8 h-8"></i>
            </div>
            <h2 class="font-display font-extrabold text-xl text-stone-900">Belum Ada Data Struktur Desa</h2>
            <p class="text-sm text-stone-500 font-light mt-2 max-w-md mx-auto">
                Daftar perangkat desa belum tersedia. Administrator dapat menambahkannya melalui halaman kelola Tentang &amp; Struktur Desa.
            </p>
            @auth
            @if(Auth::user()->isAdmin())
            <a href="{{ route('admin.tentang.index') }}" class="btn-primary mt-6 inline-flex items-center gap-2">
                <i data-lucide="settings" class="w-4 h-4"></i>
                Kelola Struktur Desa
            </a>
            @endif
            @endauth
        </div>
        @endif

    </div>
</div>

@endsection
