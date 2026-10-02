@extends('layouts.app')

@section('title', 'Sistem Informasi Desa Jambelaer | Kecamatan Dawuan, Kabupaten Subang')
@section('meta_desc', 'Portal resmi Pemerintah Desa Jambelaer, Kecamatan Dawuan, Kabupaten Subang, Jawa Barat. Temukan informasi profil desa, berita terkini, produk UMKM unggulan, destinasi wisata, budaya lokal, dan layanan publik desa.')
@section('og_type', 'website')
@section('og_image', asset('uploads/img/beranda.jpeg'))

@push('schema')
<script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@graph": [{
                "@type": "WebSite",
                "@id": "{{ config('app.url') }}/#website",
                "url": "{{ config('app.url') }}",
                "name": "Sistem Informasi Desa Jambelaer",
                "description": "Portal resmi Pemerintah Desa Jambelaer, Kecamatan Dawuan, Kabupaten Subang, Jawa Barat",
                "inLanguage": "id-ID",
                "publisher": {
                    "@id": "{{ config('app.url') }}/#organization"
                }
            },
            {
                "@type": "GovernmentOrganization",
                "@id": "{{ config('app.url') }}/#organization",
                "name": "Pemerintah Desa Jambelaer",
                "alternateName": "Desa Jambelaer",
                "url": "{{ config('app.url') }}",
                "logo": {
                    "@type": "ImageObject",
                    "url": "{{ config('app.url') }}/uploads/img/DESA_JAMBELAER.png"
                },
                "address": {
                    "@type": "PostalAddress",
                    "streetAddress": "{{ \App\Models\Pengaturan::get('desa_alamat', 'Jl. Raya Jambelaer, Dawuan') }}",
                    "addressLocality": "Kecamatan Dawuan",
                    "addressRegion": "Kabupaten Subang",
                    "addressCountry": "ID"
                },
                "telephone": "{{ \App\Models\Pengaturan::get('desa_telepon', '') }}",
                "email": "{{ \App\Models\Pengaturan::get('desa_email', '') }}",
                "areaServed": {
                    "@type": "AdministrativeArea",
                    "name": "Desa Jambelaer, Kecamatan Dawuan, Kabupaten Subang, Jawa Barat, Indonesia"
                }
            }
        ]
    }
</script>
@endpush

@section('content')

{{-- ══════════════════════════════════════════════════════════════════
     1. HERO SECTION — Split Layout
══════════════════════════════════════════════════════════════════ --}}
<section class="relative overflow-hidden bg-forest-900 rounded-[28px] sm:rounded-[32px] mx-3 sm:mx-5 lg:mx-6 mt-4 sm:mt-6 mb-1 shadow-md">
    {{-- Subtle texture / ambient glow --}}
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-sand-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-forest-700/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 min-h-[78vh] lg:min-h-[82vh] items-center gap-8 py-10 lg:py-16">

            {{-- Left: Text Content --}}
            <div class="lg:col-span-7 flex flex-col justify-center reveal-fade-left">
                {{-- Kop Surat Badge --}}
                <div class="mb-5 space-y-1 reveal-fade-up delay-100">
                    <div class="inline-flex items-center gap-2 w-fit bg-white/5 border border-white/10 px-3 py-1.5 rounded-full">
                        <span class="w-2 h-2 rounded-full bg-sand-400 animate-pulse"></span>
                        <span class="text-[10px] sm:text-[11px] font-bold tracking-[0.18em] uppercase text-sand-300">WEBSITE RESMI PEMERINTAH DESA</span>
                    </div>
                    <div class="pt-2">
                        <span class="block text-xs sm:text-sm text-sand-200/80 font-medium tracking-wide">Kecamatan Dawuan • Kabupaten Subang • Jawa Barat</span>
                    </div>
                </div>

                {{-- Headline --}}
                <h1 class="font-display font-extrabold text-3xl sm:text-5xl xl:text-6xl leading-[1.12] text-white reveal-fade-up delay-150">
                    Desa Jambelaer,<br>
                    <span class="text-sand-300">Harmoni Alam</span><br>
                    <span class="text-white/80">& Budaya Sunda</span>
                </h1>

                <p class="mt-5 text-sm sm:text-base text-white/70 font-light leading-relaxed max-w-xl reveal-fade-up delay-200">
                    Selamat datang di portal informasi dan pelayanan digital resmi Desa Jambelaer. Temukan potensi unggulan UMKM, kekayaan tradisi, destinasi wisata, serta akses layanan publik desa secara transparan.
                </p>

                {{-- CTA Group --}}
                <div class="mt-8 flex flex-wrap items-center gap-3 reveal-fade-up delay-250">
                    <a href="{{ route('tentang') }}" class="btn-primary group !bg-sand-500 !border-sand-500 hover:!bg-sand-400 hover:!border-sand-400 !text-forest-950 !font-extrabold shadow-lg shadow-sand-900/20">
                        Profil Desa
                        <i data-lucide="arrow-right" class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    <a href="{{ route('umkm') }}" class="btn-secondary !border-white/30 !text-white hover:!bg-white hover:!text-forest-900 hover:!border-white transition-all">
                        <i data-lucide="shopping-bag" class="w-4 h-4 mr-2"></i>
                        Jelajahi UMKM
                    </a>
                    <a href="{{ route('kontak') }}" class="inline-flex items-center text-xs font-semibold text-sand-300 hover:text-white px-3 py-2 transition-colors">
                        <i data-lucide="message-square" class="w-4 h-4 mr-1.5"></i>
                        Layanan & Pengaduan
                    </a>
                </div>
            </div>

            {{-- Right: Photo Feature Panel --}}
            <div class="lg:col-span-5 flex items-center justify-center reveal-fade-right delay-200">
                <div class="w-full h-[360px] sm:h-[460px] lg:h-[520px] rounded-2xl sm:rounded-3xl overflow-hidden border border-white/15 shadow-2xl relative group">
                    <img src="{{ asset('uploads/img/beranda.jpeg') }}"
                        alt="Pemandangan Desa Jambelaer, Kecamatan Dawuan, Kabupaten Subang"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                        width="800" height="560" loading="eager">
                    <div class="absolute inset-0 bg-gradient-to-t from-forest-950/80 via-forest-950/20 to-transparent"></div>

                    {{-- Floating Badge on Hero Image --}}
                    <div class="absolute bottom-4 left-4 right-4 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-4 text-white">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-forest-800/80 border border-forest-600 flex items-center justify-center text-sand-300 flex-shrink-0">
                                <i data-lucide="map-pin" class="w-5 h-5"></i>
                            </div>
                            <div class="min-w-0">
                                <h4 class="font-display font-bold text-xs sm:text-sm truncate">Desa Jambelaer</h4>
                                <p class="text-[11px] text-white/70 truncate">Kec. Dawuan, Kab. Subang, Jawa Barat 41270</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════════
     2. STATISTIK DESA — Metric Cards
══════════════════════════════════════════════════════════════════ --}}
<section class="py-14 sm:py-16 bg-white border-b border-stone-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-10 reveal-on-scroll">
            <span class="section-label">Data Demografi</span>
            <h2 class="font-display font-extrabold text-2xl sm:text-3xl text-forest-900 mt-2.5">Statistik Wilayah & Kependudukan</h2>
            <p class="mt-2 text-stone-500 font-light text-sm max-w-lg mx-auto">Data resmi gambaran kependudukan dan potensi Desa Jambelaer.</p>
            <div class="section-divider"></div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3.5 sm:gap-4">

            {{-- Jumlah Penduduk --}}
            <div class="group bg-forest-50/50 border border-stone-200 rounded-2xl p-4 sm:p-5 text-center hover:border-forest-400 hover:bg-white hover:shadow-md transition-all duration-300 reveal-fade-up delay-50">
                <div class="w-10 h-10 rounded-xl bg-forest-100 border border-forest-200 flex items-center justify-center text-forest-800 mx-auto mb-3 group-hover:bg-forest-800 group-hover:text-white transition-all">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </div>
                <span class="font-display font-extrabold text-2xl sm:text-3xl text-forest-900 block" data-target="{{ $settings['stat_penduduk'] }}">0</span>
                <span class="text-[10px] font-bold tracking-wider text-stone-400 uppercase block mt-0.5">Jiwa</span>
                <span class="text-xs text-forest-700 font-semibold mt-1 block">Penduduk</span>
            </div>

            {{-- Kepala Keluarga --}}
            <div class="group bg-forest-50/50 border border-stone-200 rounded-2xl p-4 sm:p-5 text-center hover:border-sand-400 hover:bg-white hover:shadow-md transition-all duration-300 reveal-fade-up delay-100">
                <div class="w-10 h-10 rounded-xl bg-sand-100 border border-sand-200 flex items-center justify-center text-sand-700 mx-auto mb-3 group-hover:bg-sand-500 group-hover:text-white transition-all">
                    <i data-lucide="home" class="w-5 h-5"></i>
                </div>
                <span class="font-display font-extrabold text-2xl sm:text-3xl text-forest-900 block" data-target="{{ $settings['stat_kk'] }}">0</span>
                <span class="text-[10px] font-bold tracking-wider text-stone-400 uppercase block mt-0.5">KK</span>
                <span class="text-xs text-forest-700 font-semibold mt-1 block">Kepala Keluarga</span>
            </div>

            {{-- Luas Wilayah --}}
            <div class="group bg-forest-50/50 border border-stone-200 rounded-2xl p-4 sm:p-5 text-center hover:border-emerald-400 hover:bg-white hover:shadow-md transition-all duration-300 reveal-fade-up delay-150">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 border border-emerald-200 flex items-center justify-center text-emerald-800 mx-auto mb-3 group-hover:bg-emerald-700 group-hover:text-white transition-all">
                    <i data-lucide="map" class="w-5 h-5"></i>
                </div>
                <span class="font-display font-extrabold text-2xl sm:text-3xl text-forest-900 block" data-target="{{ $settings['stat_luas'] }}">0</span>
                <span class="text-[10px] font-bold tracking-wider text-stone-400 uppercase block mt-0.5">Ha</span>
                <span class="text-xs text-forest-700 font-semibold mt-1 block">Luas Wilayah</span>
            </div>

            {{-- Jumlah UMKM --}}
            <div class="group bg-forest-50/50 border border-stone-200 rounded-2xl p-4 sm:p-5 text-center hover:border-amber-400 hover:bg-white hover:shadow-md transition-all duration-300 reveal-fade-up delay-200">
                <div class="w-10 h-10 rounded-xl bg-amber-100 border border-amber-200 flex items-center justify-center text-amber-800 mx-auto mb-3 group-hover:bg-amber-600 group-hover:text-white transition-all">
                    <i data-lucide="store" class="w-5 h-5"></i>
                </div>
                <span class="font-display font-extrabold text-2xl sm:text-3xl text-forest-900 block" data-target="{{ $settings['stat_umkm'] }}">0</span>
                <span class="text-[10px] font-bold tracking-wider text-stone-400 uppercase block mt-0.5">Unit Usaha</span>
                <span class="text-xs text-forest-700 font-semibold mt-1 block">Pelaku UMKM</span>
            </div>

            {{-- RT/RW --}}
            <div class="group bg-forest-50/50 border border-stone-200 rounded-2xl p-4 sm:p-5 text-center hover:border-sky-400 hover:bg-white hover:shadow-md transition-all duration-300 reveal-fade-up delay-250">
                <div class="w-10 h-10 rounded-xl bg-sky-100 border border-sky-200 flex items-center justify-center text-sky-800 mx-auto mb-3 group-hover:bg-sky-700 group-hover:text-white transition-all">
                    <i data-lucide="network" class="w-5 h-5"></i>
                </div>
                <span class="font-display font-extrabold text-2xl sm:text-3xl text-forest-900 block" data-target="{{ $settings['stat_rtrw'] }}">0</span>
                <span class="text-[10px] font-bold tracking-wider text-stone-400 uppercase block mt-0.5">RT/RW</span>
                <span class="text-xs text-forest-700 font-semibold mt-1 block">Lingkungan RT</span>
            </div>

            {{-- Dusun --}}
            <div class="group bg-forest-50/50 border border-stone-200 rounded-2xl p-4 sm:p-5 text-center hover:border-teal-400 hover:bg-white hover:shadow-md transition-all duration-300 reveal-fade-up delay-300">
                <div class="w-10 h-10 rounded-xl bg-teal-100 border border-teal-200 flex items-center justify-center text-teal-800 mx-auto mb-3 group-hover:bg-teal-700 group-hover:text-white transition-all">
                    <i data-lucide="tree-pine" class="w-5 h-5"></i>
                </div>
                <span class="font-display font-extrabold text-2xl sm:text-3xl text-forest-900 block" data-target="{{ $settings['stat_dusun'] }}">0</span>
                <span class="text-[10px] font-bold tracking-wider text-stone-400 uppercase block mt-0.5">Wilayah</span>
                <span class="text-xs text-forest-700 font-semibold mt-1 block">Dusun</span>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════
     3. SAMBUTAN KEPALA DESA — Formal Welcome Card
══════════════════════════════════════════════════════════ --}}
@php
$kadesNama = \App\Models\Pengaturan::get('kades_nama', 'Sahar Dwi Anugrah, S.Kom');
$kadesJabatan = \App\Models\Pengaturan::get('kades_jabatan', 'Kepala Desa Jambelaer');
$kadesFoto = \App\Models\Pengaturan::get('kades_foto', '');
$sambutanJudul = \App\Models\Pengaturan::get('sambutan_judul', 'Sambutan Kepala Desa');
$sambutanQuote = \App\Models\Pengaturan::get('sambutan_quote', 'Membangun Desa Jambelaer yang Mandiri, Sejahtera, dan Berakar pada Nilai Budaya Sunda.');
$sambutanTeks = \App\Models\Pengaturan::get('sambutan_teks', 'Selamat datang di portal resmi Sistem Informasi Desa Jambelaer. Website ini merupakan wujud keterbukaan informasi publik dan dedikasi kami dalam melayani seluruh warga serta mempromosikan potensi lokal desa.');
@endphp
<section class="py-16 sm:py-20 bg-stone-50/60 border-b border-stone-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">

            {{-- Photo --}}
            <div class="lg:col-span-4 flex justify-center lg:justify-start reveal-fade-left">
                <div class="relative">
                    <div class="absolute -top-3 -left-3 w-full h-full border-2 border-sand-300/60 rounded-2xl"></div>
                    <div class="relative w-64 h-80 sm:w-72 sm:h-96 rounded-2xl overflow-hidden shadow-xl bg-forest-900 border border-stone-200">
                        @if($kadesFoto && file_exists(public_path($kadesFoto)))
                        <img src="{{ asset($kadesFoto) }}" alt="{{ $kadesNama }}" class="w-full h-full object-cover">
                        @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($kadesNama) }}&background=1a4731&color=fff&size=400" alt="{{ $kadesNama }}" class="w-full h-full object-cover">
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-forest-950/90 via-transparent to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-5 text-white">
                            <span class="text-[10px] font-bold text-sand-300 uppercase tracking-widest block">{{ $kadesJabatan }}</span>
                            <h3 class="font-display font-extrabold text-base sm:text-lg text-white block mt-0.5">{{ $kadesNama }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Welcome Speech --}}
            <div class="lg:col-span-8 space-y-5 reveal-fade-right">
                <span class="section-label">Sambutan Resmi</span>
                <h2 class="font-display font-extrabold text-2xl sm:text-4xl text-forest-900 leading-tight">
                    {{ $sambutanJudul }}
                </h2>

                @if($sambutanQuote)
                <blockquote class="border-l-4 border-sand-500 pl-5 py-1 font-serif italic text-base text-stone-700 leading-relaxed bg-sand-50/50 rounded-r-xl">
                    "{{ $sambutanQuote }}"
                </blockquote>
                @endif

                <p class="text-stone-600 text-sm sm:text-base leading-relaxed font-light">
                    {{ Str::limit($sambutanTeks, 340) }}
                </p>

                <div class="pt-2 flex flex-wrap items-center gap-3">
                    <a href="{{ route('tentang') }}#sambutan" class="btn-primary">
                        Baca Sambutan Lengkap
                        <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
                    </a>
                    <a href="{{ route('kontak') }}" class="btn-secondary">
                        <i data-lucide="message-square" class="w-4 h-4 mr-2"></i>
                        Sampaikan Aspirasi
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════
     4. SEKILAS PROFIL DESA — Summary & Overview
══════════════════════════════════════════════════════════ --}}
<section class="py-16 sm:py-20 bg-white border-b border-stone-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">

            {{-- Left Column: Visual Image Collage --}}
            <div class="lg:col-span-5 reveal-fade-left">
                <div class="relative">
                    <div class="rounded-3xl overflow-hidden shadow-xl border border-stone-200/80 aspect-[4/3] relative">
                        <img src="{{ asset('uploads/img/sawah.jpeg') }}"
                            alt="Bentang Alam Desa Jambelaer"
                            class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-forest-950/60 via-transparent to-transparent"></div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Story & Vision --}}
            <div class="lg:col-span-7 space-y-5 reveal-fade-right">
                <span class="section-label">Tentang Kami</span>
                <h2 class="font-display font-extrabold text-2xl sm:text-4xl text-forest-900 leading-tight">
                    Mengenal Lebih Dekat<br>
                    <span class="text-sand-700">Desa Jambelaer</span>
                </h2>

                <p class="text-stone-600 text-sm sm:text-base leading-relaxed font-light">
                    Desa Jambelaer merupakan bagian dari Kecamatan Dawuan, Kabupaten Subang yang kaya akan potensi pertanian, kekompakan masyarakat berbudaya Sunda, serta semangat wirausaha lokal khususnya produksi pangan olahan tradisional seperti Opak ketan.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                    <div class="bg-forest-50/50 p-4 rounded-2xl border border-stone-200 shadow-sm">
                        <div class="w-8 h-8 rounded-lg bg-forest-100 text-forest-800 flex items-center justify-center mb-2">
                            <i data-lucide="shield-check" class="w-4 h-4"></i>
                        </div>
                        <h4 class="font-display font-bold text-sm text-forest-900">Pelayanan Terbuka</h4>
                        <p class="text-xs text-stone-500 mt-1 leading-normal">Pemerintahan yang transparan dan akuntabel melayani seluruh masyarakat.</p>
                    </div>
                    <div class="bg-sand-50/50 p-4 rounded-2xl border border-stone-200 shadow-sm">
                        <div class="w-8 h-8 rounded-lg bg-sand-100 text-sand-700 flex items-center justify-center mb-2">
                            <i data-lucide="sparkles" class="w-4 h-4"></i>
                        </div>
                        <h4 class="font-display font-bold text-sm text-forest-900">Kearifan Lokal</h4>
                        <p class="text-xs text-stone-500 mt-1 leading-normal">Melestarikan tradisi Ruwatan Bumi dan kesenian Sunda secara berkelanjutan.</p>
                    </div>
                </div>

                <div class="pt-2">
                    <a href="{{ route('tentang') }}" class="btn-primary">
                        Selengkapnya Tentang Desa
                        <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════════
     4. POTENSI DESA — 3 Main Feature Pillars
══════════════════════════════════════════════════════════════════ --}}
<section class="py-16 sm:py-20 bg-white border-b border-stone-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-12 reveal-on-scroll">
            <span class="section-label">Potensi Wilayah</span>
            <h2 class="font-display font-extrabold text-2xl sm:text-3xl text-forest-900 mt-2.5">Tiga Pilar Potensi Desa</h2>
            <p class="mt-2 text-stone-500 font-light text-sm max-w-lg mx-auto">Kenali keunggulan ekonomi kerakyatan, warisan budaya leluhur, dan pariwisata Desa Jambelaer.</p>
            <div class="section-divider"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Pillar 1: UMKM --}}
            <div class="card-village p-6 flex flex-col justify-between group hover:border-amber-300 reveal-fade-up delay-100">
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center mb-5 group-hover:bg-amber-600 group-hover:text-white transition-all">
                        <i data-lucide="store" class="w-6 h-6"></i>
                    </div>
                    <span class="text-[10px] font-bold tracking-widest text-amber-700 uppercase block mb-1">Ekonomi Kreatif</span>
                    <h3 class="font-display font-extrabold text-xl text-forest-900 mb-2">UMKM & Produk Desa</h3>
                    <p class="text-sm text-stone-500 font-light leading-relaxed mb-6">
                        Sentra produksi Opak ketan tradisional bermutu tinggi karya perajin lokal yang dipasarkan hingga luar daerah Subang.
                    </p>
                </div>
                <a href="{{ route('umkm') }}" class="inline-flex items-center text-xs font-bold text-forest-800 hover:text-amber-700 group-hover:translate-x-1 transition-all">
                    Lihat Produk UMKM <i data-lucide="chevron-right" class="w-4 h-4 ml-1"></i>
                </a>
            </div>

            {{-- Pillar 2: Budaya --}}
            <div class="card-village p-6 flex flex-col justify-between group hover:border-forest-300 reveal-fade-up delay-150">
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-forest-50 text-forest-800 flex items-center justify-center mb-5 group-hover:bg-forest-800 group-hover:text-white transition-all">
                        <i data-lucide="landmark" class="w-6 h-6"></i>
                    </div>
                    <span class="text-[10px] font-bold tracking-widest text-forest-700 uppercase block mb-1">Seni & Tradisi</span>
                    <h3 class="font-display font-extrabold text-xl text-forest-900 mb-2">Kekayaan Budaya</h3>
                    <p class="text-sm text-stone-500 font-light leading-relaxed mb-6">
                        Upacara adat Ruwatan Bumi, kesenian musik Tutunggulan, hingga Milangkala desa yang meriah menjaga keharmonisan masyarakat.
                    </p>
                </div>
                <a href="{{ route('budaya') }}" class="inline-flex items-center text-xs font-bold text-forest-800 hover:text-forest-600 group-hover:translate-x-1 transition-all">
                    Jelajahi Budaya <i data-lucide="chevron-right" class="w-4 h-4 ml-1"></i>
                </a>
            </div>

            {{-- Pillar 3: Wisata --}}
            <div class="card-village p-6 flex flex-col justify-between group hover:border-teal-300 reveal-fade-up delay-200">
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-700 flex items-center justify-center mb-5 group-hover:bg-teal-700 group-hover:text-white transition-all">
                        <i data-lucide="compass" class="w-6 h-6"></i>
                    </div>
                    <span class="text-[10px] font-bold tracking-widest text-teal-700 uppercase block mb-1">Ekowisata & Lingkungan</span>
                    <h3 class="font-display font-extrabold text-xl text-forest-900 mb-2">Destinasi Wisata</h3>
                    <p class="text-sm text-stone-500 font-light leading-relaxed mb-6">
                        Wisata edukasi lingkungan Eco Brick dan keasrian panorama alam persawahan khas pedesaan Jawa Barat yang menenangkan.
                    </p>
                </div>
                <a href="{{ route('wisata') }}" class="inline-flex items-center text-xs font-bold text-forest-800 hover:text-teal-700 group-hover:translate-x-1 transition-all">
                    Lihat Destinasi <i data-lucide="chevron-right" class="w-4 h-4 ml-1"></i>
                </a>
            </div>

        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════════
     8. BERITA & INFORMASI DESA — News Stream
══════════════════════════════════════════════════════════════════ --}}
<section class="py-16 sm:py-20 bg-white border-b border-stone-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 reveal-on-scroll">
            <div>
                <span class="section-label">Kabar Terkini</span>
                <h2 class="font-display font-extrabold text-2xl sm:text-3xl text-forest-900 mt-2.5">Berita & Pengumuman Desa</h2>
                <p class="mt-1 text-stone-500 font-light text-sm">Informasi kegiatan pemerintahan, pembangunan, dan pengumuman untuk warga.</p>
            </div>
            <a href="{{ route('berita') }}" class="hidden md:inline-flex items-center text-xs font-bold text-forest-800 hover:text-sand-700 transition-colors mt-4 md:mt-0">
                Semua Berita <i data-lucide="arrow-right" class="w-4 h-4 ml-1.5"></i>
            </a>
        </div>

        @if($beritas->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($beritas as $berita)
            <article class="card-village overflow-hidden flex flex-col justify-between group reveal-fade-up">
                <div>
                    <div class="aspect-[16/10] w-full overflow-hidden bg-stone-100 relative">
                        <img src="{{ $berita->gambar_url }}" alt="{{ $berita->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <span class="absolute top-3 left-3 bg-forest-900/90 text-white text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">
                            {{ $berita->kategori }}
                        </span>
                    </div>
                    <div class="p-5">
                        <div class="flex items-center gap-3 text-[11px] text-stone-400 font-medium mb-2">
                            <span><i data-lucide="calendar" class="w-3 h-3 inline mr-1"></i>{{ $berita->published_at ? $berita->published_at->format('d M Y') : $berita->created_at->format('d M Y') }}</span>
                            <span>•</span>
                            <span><i data-lucide="user" class="w-3 h-3 inline mr-1"></i>{{ $berita->penulis }}</span>
                        </div>
                        <h3 class="font-display font-bold text-base text-forest-900 group-hover:text-forest-700 transition-colors leading-snug">
                            <a href="{{ route('berita.detail', $berita->slug) }}">{{ $berita->judul }}</a>
                        </h3>
                        <p class="text-xs text-stone-500 mt-2.5 line-clamp-3 leading-relaxed font-light">
                            {{ $berita->ringkasan ?: Str::limit(strip_tags($berita->konten), 120) }}
                        </p>
                    </div>
                </div>
                <div class="px-5 pb-5 pt-2">
                    <a href="{{ route('berita.detail', $berita->slug) }}" class="inline-flex items-center text-xs font-bold text-forest-800 hover:text-sand-700">
                        Baca Artikel <i data-lucide="arrow-right" class="w-3.5 h-3.5 ml-1"></i>
                    </a>
                </div>
            </article>
            @endforeach
        </div>
        @else
        <div class="bg-stone-50 rounded-2xl border border-stone-200 p-8 text-center text-stone-500">
            <i data-lucide="newspaper" class="w-8 h-8 mx-auto text-stone-400 mb-2"></i>
            <p class="text-sm">Belum ada berita yang diterbitkan.</p>
        </div>
        @endif

    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════════
     10. LAYANAN & PENGADUAN MASYARAKAT — 5 Service Cards
══════════════════════════════════════════════════════════════════ --}}
<section class="py-16 sm:py-20 bg-white border-b border-stone-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center max-w-2xl mx-auto mb-12 reveal-on-scroll">
            <span class="section-label">Pelayanan Digital</span>
            <h2 class="font-display font-extrabold text-2xl sm:text-3xl text-forest-900 mt-2.5">Layanan Masyarakat & Aspirasi</h2>
            <p class="mt-2 text-stone-500 font-light text-sm">Sampaikan permohonan surat keterangan, pertanyaan informasi, pengaduan lingkungan, hingga pendaftaran UMKM secara langsung ke kantor desa.</p>
            <div class="section-divider"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            {{-- 1. Pengajuan Surat --}}
            <div class="card-village p-5 flex flex-col justify-between hover:border-violet-400 group reveal-fade-up delay-50">
                <div>
                    <div class="w-10 h-10 rounded-xl bg-violet-50 text-violet-700 flex items-center justify-center mb-4 group-hover:bg-violet-700 group-hover:text-white transition-all">
                        <i data-lucide="file-text" class="w-5 h-5"></i>
                    </div>
                    <h3 class="font-display font-bold text-sm text-forest-900 mb-1">Pengajuan Surat</h3>
                    <p class="text-xs text-stone-500 font-light leading-relaxed">
                        Layanan administrasi pembuatan berbagai surat keterangan desa secara online dan transparan.
                    </p>
                </div>
                <div class="pt-4">
                    <a href="{{ route('pengajuan.surat') }}" class="text-xs font-bold text-violet-700 hover:text-violet-900 inline-flex items-center">
                        Ajukan Surat <i data-lucide="chevron-right" class="w-3.5 h-3.5 ml-0.5"></i>
                    </a>
                </div>
            </div>

            {{-- 2. Pertanyaan Umum --}}
            <div class="card-village p-5 flex flex-col justify-between hover:border-forest-400 group reveal-fade-up delay-100">
                <div>
                    <div class="w-10 h-10 rounded-xl bg-forest-50 text-forest-800 flex items-center justify-center mb-4 group-hover:bg-forest-800 group-hover:text-white transition-all">
                        <i data-lucide="help-circle" class="w-5 h-5"></i>
                    </div>
                    <h3 class="font-display font-bold text-sm text-forest-900 mb-1">Pertanyaan Umum</h3>
                    <p class="text-xs text-stone-500 font-light leading-relaxed">
                        Konsultasi informasi administrasi kependudukan dan layanan pemerintahan warga.
                    </p>
                </div>
                <div class="pt-4">
                    <a href="{{ route('kontak') }}?jenis=pertanyaan_umum" class="text-xs font-bold text-forest-800 hover:text-forest-600 inline-flex items-center">
                        Kirim Tanya <i data-lucide="chevron-right" class="w-3.5 h-3.5 ml-0.5"></i>
                    </a>
                </div>
            </div>

            {{-- 3. Pengaduan Lingkungan --}}
            <div class="card-village p-5 flex flex-col justify-between hover:border-rose-400 group reveal-fade-up delay-150">
                <div>
                    <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-700 flex items-center justify-center mb-4 group-hover:bg-rose-600 group-hover:text-white transition-all">
                        <i data-lucide="alert-triangle" class="w-5 h-5"></i>
                    </div>
                    <h3 class="font-display font-bold text-sm text-forest-900 mb-1">Pengaduan Warga</h3>
                    <p class="text-xs text-stone-500 font-light leading-relaxed">
                        Laporkan fasilitas umum, infrastruktur, atau masalah lingkungan desa.
                    </p>
                </div>
                <div class="pt-4">
                    <a href="{{ route('kontak') }}?jenis=pengaduan" class="text-xs font-bold text-rose-700 hover:text-rose-900 inline-flex items-center">
                        Ajukan Aduan <i data-lucide="chevron-right" class="w-3.5 h-3.5 ml-0.5"></i>
                    </a>
                </div>
            </div>

            {{-- 5. Daftar UMKM --}}
            <div class="card-village p-5 flex flex-col justify-between hover:border-amber-400 group reveal-fade-up delay-250">
                <div>
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center mb-4 group-hover:bg-amber-600 group-hover:text-white transition-all">
                        <i data-lucide="store" class="w-5 h-5"></i>
                    </div>
                    <h3 class="font-display font-bold text-sm text-forest-900 mb-1">Daftar UMKM</h3>
                    <p class="text-xs text-stone-500 font-light leading-relaxed">
                        Daftarkan usaha Anda agar dipromosikan gratis di katalog web desa.
                    </p>
                </div>
                <div class="pt-4">
                    <a href="{{ route('kontak') }}?jenis=daftar_umkm" class="text-xs font-bold text-amber-700 hover:text-amber-900 inline-flex items-center">
                        Daftar Usaha <i data-lucide="chevron-right" class="w-3.5 h-3.5 ml-0.5"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection