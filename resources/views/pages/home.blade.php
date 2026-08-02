@extends('layouts.app')

@section('title', 'Beranda')
@section('meta_desc', 'Selamat datang di portal resmi Desa Jambelaer, Kecamatan Dawuan, Kabupaten Subang – Harmoni Alam, Budaya, dan Kemandirian Ekonomi.')

@section('content')

{{-- ══════════════════════════════════════════════════════════════════
     HERO — Split Layout
══════════════════════════════════════════════════════════════════ --}}
<section class="relative overflow-hidden bg-forest-900 rounded-[32px] mx-3 sm:mx-5 lg:mx-6 mt-6 mb-1 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 min-h-[82vh] items-center gap-8">

            {{-- Left: Text Content --}}
            <div class="relative z-10 py-12 sm:py-16 lg:py-20 flex flex-col justify-center">

                {{-- Kop Surat Badge --}}
                <div class="mb-6 space-y-1">
                    <div class="inline-flex items-center gap-2 w-fit">
                        <div class="h-px w-8 bg-sand-400"></div>
                        <span class="text-[10px] sm:text-[11px] font-bold tracking-[0.15em] sm:tracking-[0.2em] uppercase text-sand-400">WEBSITE RESMI PEMERINTAH DESA</span>
                    </div>
                    <div class="pl-10">
                        <span class="block text-base sm:text-lg font-bold text-white tracking-wide">Desa Jambelaer</span>
                        <span class="block text-xs sm:text-sm text-sand-300 font-medium tracking-wide">Kecamatan Dawuan • Kabupaten Subang</span>
                    </div>
                </div>

                {{-- Headline --}}
                <h1 class="font-display font-extrabold text-3xl sm:text-5xl xl:text-6xl leading-[1.1] text-white">
                    Desa Jambelaer,<br>
                    <span class="text-sand-300">Harmoni Alam</span><br>
                    <span class="text-white/60">& Budaya Sunda</span>
                </h1>

                <p class="mt-6 text-sm sm:text-base text-white/55 font-light leading-relaxed max-w-md">
                    Selamat datang di portal informasi resmi Desa Jambelaer.
                    Temukan potensi desa, produk UMKM lokal, kekayaan budaya Sunda, dan layanan pemerintahan desa kami.
                </p>

                {{-- CTA --}}
                <div class="mt-8 flex flex-col sm:flex-row gap-3 w-full sm:w-fit">
                    <a href="{{ route('tentang') }}" class="btn-primary group w-full sm:w-auto text-center justify-center">
                        Profil Desa
                        <i data-lucide="arrow-right" class="w-4 h-4 ml-2 group-hover:translate-x-0.5 transition-transform"></i>
                    </a>
                    <a href="{{ route('umkm') }}" class="btn-secondary !border-white/20 !text-white/70 hover:!bg-white/10 hover:!text-white hover:!border-white/30 w-full sm:w-auto text-center justify-center">
                        Produk UMKM
                    </a>
                </div>
            </div>

            {{-- Right: Rounded Photo Panel --}}
            <div class="hidden lg:flex items-center justify-center py-10">
                <div class="w-full h-[560px] rounded-3xl overflow-hidden border border-white/10 shadow-lg relative">
                    <img src="{{ asset('uploads/img/beranda.jpeg') }}"
                        alt="beranda"
                        class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-forest-950/60 via-transparent to-transparent"></div>
                    <div class="absolute bottom-6 right-6 text-right">
                        <span class="block text-[9px] text-white/50 tracking-widest uppercase font-semibold">Milangkala Desa</span>
                        <span class="block text-xs text-white/80 font-light mt-0.5">Milangkala Desa Jambelaer</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════════
     STATISTIK DESA — Full-Width Strip
══════════════════════════════════════════════════════════════════ --}}
<section class="py-16 bg-white border-b border-stone-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-12 reveal-on-scroll">
            <span class="section-label">Data Resmi</span>
            <h2 class="font-display font-extrabold text-2xl sm:text-3xl text-forest-900 mt-3">Statistik Desa Jambelaer</h2>
            <p class="mt-2 text-stone-500 font-light text-sm max-w-lg mx-auto">Data demografis dan wilayah resmi Desa Jambelaer, Kecamatan Dawuan, Kabupaten Subang.</p>
            <div class="section-divider"></div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 reveal-on-scroll delay-100">

            {{-- Jumlah Penduduk --}}
            <div class="group bg-white border border-stone-200 rounded-2xl p-5 text-center hover:border-forest-300 hover:shadow-md transition-all duration-300">
                <div class="w-11 h-11 rounded-xl bg-forest-50 border border-forest-100 flex items-center justify-center text-forest-700 mx-auto mb-3 group-hover:bg-forest-800 group-hover:text-white group-hover:border-forest-800 transition-all duration-300">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </div>
                <span class="font-display font-extrabold text-2xl text-forest-900 block" data-target="{{ $settings['stat_penduduk'] }}">0</span>
                <span class="text-[10px] font-bold tracking-widest text-stone-400 uppercase block">Jiwa</span>
                <span class="text-xs text-forest-700 font-medium mt-0.5 block">Penduduk</span>
            </div>

            {{-- Kepala Keluarga --}}
            <div class="group bg-white border border-stone-200 rounded-2xl p-5 text-center hover:border-sand-300 hover:shadow-md transition-all duration-300">
                <div class="w-11 h-11 rounded-xl bg-sand-50 border border-sand-100 flex items-center justify-center text-sand-700 mx-auto mb-3 group-hover:bg-sand-500 group-hover:text-white group-hover:border-sand-500 transition-all duration-300">
                    <i data-lucide="home" class="w-5 h-5"></i>
                </div>
                <span class="font-display font-extrabold text-2xl text-forest-900 block" data-target="{{ $settings['stat_kk'] }}">0</span>
                <span class="text-[10px] font-bold tracking-widest text-stone-400 uppercase block">KK</span>
                <span class="text-xs text-forest-700 font-medium mt-0.5 block">Kepala Keluarga</span>
            </div>

            {{-- Luas Wilayah --}}
            <div class="group bg-white border border-stone-200 rounded-2xl p-5 text-center hover:border-sky-200 hover:shadow-md transition-all duration-300">
                <div class="w-11 h-11 rounded-xl bg-sky-50 border border-sky-100 flex items-center justify-center text-sky-700 mx-auto mb-3 group-hover:bg-sky-600 group-hover:text-white group-hover:border-sky-600 transition-all duration-300">
                    <i data-lucide="map" class="w-5 h-5"></i>
                </div>
                <span class="font-display font-extrabold text-2xl text-forest-900 block" data-target="{{ $settings['stat_luas'] }}">0</span>
                <span class="text-[10px] font-bold tracking-widest text-stone-400 uppercase block">Ha</span>
                <span class="text-xs text-forest-700 font-medium mt-0.5 block">Luas Wilayah</span>
            </div>

            {{-- Jumlah UMKM --}}
            <div class="group bg-white border border-stone-200 rounded-2xl p-5 text-center hover:border-violet-200 hover:shadow-md transition-all duration-300">
                <div class="w-11 h-11 rounded-xl bg-violet-50 border border-violet-100 flex items-center justify-center text-violet-700 mx-auto mb-3 group-hover:bg-violet-600 group-hover:text-white group-hover:border-violet-600 transition-all duration-300">
                    <i data-lucide="store" class="w-5 h-5"></i>
                </div>
                <span class="font-display font-extrabold text-2xl text-forest-900 block" data-target="{{ $settings['stat_umkm'] }}">0</span>
                <span class="text-[10px] font-bold tracking-widest text-stone-400 uppercase block">Unit</span>
                <span class="text-xs text-forest-700 font-medium mt-0.5 block">Pelaku UMKM</span>
            </div>

            {{-- RT/RW --}}
            <div class="group bg-white border border-stone-200 rounded-2xl p-5 text-center hover:border-rose-200 hover:shadow-md transition-all duration-300">
                <div class="w-11 h-11 rounded-xl bg-rose-50 border border-rose-100 flex items-center justify-center text-rose-700 mx-auto mb-3 group-hover:bg-rose-600 group-hover:text-white group-hover:border-rose-600 transition-all duration-300">
                    <i data-lucide="network" class="w-5 h-5"></i>
                </div>
                <span class="font-display font-extrabold text-2xl text-forest-900 block" data-target="{{ $settings['stat_rtrw'] }}">0</span>
                <span class="text-[10px] font-bold tracking-widest text-stone-400 uppercase block">RT</span>
                <span class="text-xs text-forest-700 font-medium mt-0.5 block">Lingkungan RT</span>
            </div>

            {{-- Dusun --}}
            <div class="group bg-white border border-stone-200 rounded-2xl p-5 text-center hover:border-teal-200 hover:shadow-md transition-all duration-300">
                <div class="w-11 h-11 rounded-xl bg-teal-50 border border-teal-100 flex items-center justify-center text-teal-700 mx-auto mb-3 group-hover:bg-teal-600 group-hover:text-white group-hover:border-teal-600 transition-all duration-300">
                    <i data-lucide="tree-pine" class="w-5 h-5"></i>
                </div>
                <span class="font-display font-extrabold text-2xl text-forest-900 block" data-target="{{ $settings['stat_dusun'] }}">0</span>
                <span class="text-[10px] font-bold tracking-widest text-stone-400 uppercase block">Dusun</span>
                <span class="text-xs text-forest-700 font-medium mt-0.5 block">Wilayah Dusun</span>
            </div>
        </div>
    </div>
</section>


@endsection