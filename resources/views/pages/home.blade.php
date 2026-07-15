@extends('layouts.app')

@section('title', 'Beranda')
@section('meta_desc', 'Selamat datang di portal resmi Desa Jambelaer, Kecamatan Dawuan, Kabupaten Subang – Harmoni Alam, Budaya, dan Kemandirian Ekonomi.')

@section('content')
<section class="relative min-h-screen flex items-center justify-center pt-24 pb-16 overflow-hidden">
    <!-- Background -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1500937386664-56d1dfef3854?auto=format&fit=crop&w=1920&q=80"
             alt="Sawah Desa Jambelaer" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-b from-white/90 via-white/80 to-ivory"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">

        <!-- Badge -->
        <div class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-800 mb-6">
            <i data-lucide="heart" class="w-4 h-4 fill-emerald-600 text-emerald-600"></i>
            <span class="text-xs font-semibold tracking-wider uppercase">Portal Resmi Desa Jambelaer</span>
        </div>

        <!-- Headline -->
        <h1 class="font-display font-extrabold text-4xl sm:text-5xl lg:text-6xl tracking-tight text-emerald-950 max-w-4xl mx-auto leading-tight">
            Harmoni Alam, Budaya, &amp; Kemandirian
            <span class="bg-gradient-to-r from-emerald-800 to-amber-700 bg-clip-text text-transparent">Ekonomi Desa</span>
        </h1>

        <p class="mt-6 text-base sm:text-lg text-slate-600 max-w-2xl mx-auto font-light leading-relaxed">
            Selamat datang di portal informasi resmi Desa Jambelaer, Kecamatan Dawuan, Kabupaten Subang.
            Tempat di mana tradisi luhur berpadu dengan kemajuan potensi lokal yang asri.
        </p>

        <!-- CTA -->
        <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('tentang') }}"
               class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 text-sm font-bold tracking-wide text-white bg-emerald-900 hover:bg-emerald-800 rounded-xl shadow-lg transition-all duration-200 hover:-translate-y-0.5 group">
                Jelajahi Profil
                <i data-lucide="arrow-right" class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform"></i>
            </a>
            <a href="{{ route('umkm') }}"
               class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 text-sm font-bold tracking-wide text-emerald-950 bg-white hover:bg-slate-50 border border-slate-200 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-y-0.5">
                Lihat UMKM Desa
            </a>
        </div>

        <!-- Statistics -->
        <div class="mt-20 grid grid-cols-1 sm:grid-cols-3 gap-6 max-w-5xl mx-auto text-left reveal-on-scroll">
            <div class="bg-white/80 backdrop-blur-sm p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all duration-300">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-800 mb-4">
                    <i data-lucide="layers" class="w-6 h-6"></i>
                </div>
                <span class="text-3xl sm:text-4xl font-extrabold font-display text-emerald-950 block" data-target="{{ $settings['stat_luas'] }}">0</span>
                <span class="text-xs font-semibold tracking-wider text-slate-500 uppercase block mt-1">Luas Wilayah (Ha)</span>
            </div>
            <div class="bg-white/80 backdrop-blur-sm p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all duration-300">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-800 mb-4">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
                <span class="text-3xl sm:text-4xl font-extrabold font-display text-emerald-950 block" data-target="{{ $settings['stat_penduduk'] }}">0</span>
                <span class="text-xs font-semibold tracking-wider text-slate-500 uppercase block mt-1">Jumlah Penduduk (Jiwa)</span>
            </div>
            <div class="bg-white/80 backdrop-blur-sm p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all duration-300">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-800 mb-4">
                    <i data-lucide="store" class="w-6 h-6"></i>
                </div>
                <span class="text-3xl sm:text-4xl font-extrabold font-display text-emerald-950 block" data-target="{{ $settings['stat_umkm'] }}">0</span>
                <span class="text-xs font-semibold tracking-wider text-slate-500 uppercase block mt-1">Pelaku UMKM</span>
            </div>
        </div>

        <!-- Quick Nav Cards -->
        <div class="mt-20 grid sm:grid-cols-2 lg:grid-cols-4 gap-5 max-w-5xl mx-auto text-left reveal-on-scroll delay-100">
            <a href="{{ route('tentang') }}" class="group flex flex-col p-6 bg-white/80 border border-slate-100 rounded-2xl shadow-sm hover:shadow-lg hover:border-emerald-200 transition-all duration-300 hover:-translate-y-1">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-800 mb-4 group-hover:bg-emerald-900 group-hover:text-white transition-colors duration-200">
                    <i data-lucide="info" class="w-5 h-5"></i>
                </div>
                <span class="font-display font-bold text-base text-emerald-950">Tentang Kami</span>
                <span class="text-xs text-slate-500 font-light mt-1">Profil, visi, misi &amp; sambutan kepala desa</span>
            </a>
            <a href="{{ route('umkm') }}" class="group flex flex-col p-6 bg-white/80 border border-slate-100 rounded-2xl shadow-sm hover:shadow-lg hover:border-emerald-200 transition-all duration-300 hover:-translate-y-1">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-800 mb-4 group-hover:bg-emerald-900 group-hover:text-white transition-colors duration-200">
                    <i data-lucide="store" class="w-5 h-5"></i>
                </div>
                <span class="font-display font-bold text-base text-emerald-950">UMKM</span>
                <span class="text-xs text-slate-500 font-light mt-1">Produk unggulan &amp; karya lokal warga desa</span>
            </a>
            <a href="{{ route('budaya') }}" class="group flex flex-col p-6 bg-white/80 border border-slate-100 rounded-2xl shadow-sm hover:shadow-lg hover:border-emerald-200 transition-all duration-300 hover:-translate-y-1">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-800 mb-4 group-hover:bg-emerald-900 group-hover:text-white transition-colors duration-200">
                    <i data-lucide="music-2" class="w-5 h-5"></i>
                </div>
                <span class="font-display font-bold text-base text-emerald-950">Budaya</span>
                <span class="text-xs text-slate-500 font-light mt-1">Tradisi &amp; kesenian Sunda yang dilestarikan</span>
            </a>
            <a href="{{ route('kontak') }}" class="group flex flex-col p-6 bg-white/80 border border-slate-100 rounded-2xl shadow-sm hover:shadow-lg hover:border-emerald-200 transition-all duration-300 hover:-translate-y-1">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-800 mb-4 group-hover:bg-emerald-900 group-hover:text-white transition-colors duration-200">
                    <i data-lucide="phone-call" class="w-5 h-5"></i>
                </div>
                <span class="font-display font-bold text-base text-emerald-950">Kontak</span>
                <span class="text-xs text-slate-500 font-light mt-1">Hubungi &amp; kirim aspirasi ke kantor desa</span>
            </a>
        </div>
    </div>
</section>
@endsection
