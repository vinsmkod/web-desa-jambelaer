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

        <!-- ── Statistik Desa Section ── -->
        <div class="mt-24 reveal-on-scroll delay-200">
            <div class="text-center mb-10">
                <span class="text-xs font-bold tracking-widest uppercase text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full">Data Resmi</span>
                <h2 class="font-display font-extrabold text-2xl sm:text-3xl text-emerald-950 mt-3">Statistik Desa Jambelaer</h2>
                <p class="mt-2 text-slate-500 font-light text-sm max-w-xl mx-auto">Data demografis dan wilayah Desa Jambelaer, Kecamatan Dawuan, Kabupaten Subang.</p>
                <div class="w-12 h-1 bg-gradient-to-r from-emerald-800 to-amber-600 mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 max-w-6xl mx-auto">
                <!-- Jumlah Penduduk -->
                <div class="bg-white/80 backdrop-blur-sm p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all duration-300 flex flex-col items-center text-center group">
                    <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-800 mb-3 group-hover:bg-emerald-900 group-hover:text-white transition-colors duration-200">
                        <i data-lucide="users" class="w-5 h-5"></i>
                    </div>
                    <span class="text-2xl font-extrabold font-display text-emerald-950 block" data-target="{{ $settings['stat_penduduk'] }}">0</span>
                    <span class="text-xs font-semibold tracking-wider text-slate-500 uppercase block mt-1 leading-tight">Jiwa</span>
                    <span class="text-xs text-emerald-700 font-medium mt-0.5">Penduduk</span>
                </div>

                <!-- Kepala Keluarga -->
                <div class="bg-white/80 backdrop-blur-sm p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all duration-300 flex flex-col items-center text-center group">
                    <div class="w-11 h-11 rounded-xl bg-amber-50 flex items-center justify-center text-amber-700 mb-3 group-hover:bg-amber-600 group-hover:text-white transition-colors duration-200">
                        <i data-lucide="home" class="w-5 h-5"></i>
                    </div>
                    <span class="text-2xl font-extrabold font-display text-emerald-950 block" data-target="{{ $settings['stat_kk'] }}">0</span>
                    <span class="text-xs font-semibold tracking-wider text-slate-500 uppercase block mt-1 leading-tight">KK</span>
                    <span class="text-xs text-emerald-700 font-medium mt-0.5">Kepala Keluarga</span>
                </div>

                <!-- Luas Wilayah -->
                <div class="bg-white/80 backdrop-blur-sm p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all duration-300 flex flex-col items-center text-center group">
                    <div class="w-11 h-11 rounded-xl bg-sky-50 flex items-center justify-center text-sky-700 mb-3 group-hover:bg-sky-700 group-hover:text-white transition-colors duration-200">
                        <i data-lucide="layers" class="w-5 h-5"></i>
                    </div>
                    <span class="text-2xl font-extrabold font-display text-emerald-950 block" data-target="{{ $settings['stat_luas'] }}">0</span>
                    <span class="text-xs font-semibold tracking-wider text-slate-500 uppercase block mt-1 leading-tight">Ha</span>
                    <span class="text-xs text-emerald-700 font-medium mt-0.5">Luas Wilayah</span>
                </div>

                <!-- Jumlah UMKM -->
                <div class="bg-white/80 backdrop-blur-sm p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all duration-300 flex flex-col items-center text-center group">
                    <div class="w-11 h-11 rounded-xl bg-violet-50 flex items-center justify-center text-violet-700 mb-3 group-hover:bg-violet-700 group-hover:text-white transition-colors duration-200">
                        <i data-lucide="store" class="w-5 h-5"></i>
                    </div>
                    <span class="text-2xl font-extrabold font-display text-emerald-950 block" data-target="{{ $settings['stat_umkm'] }}">0</span>
                    <span class="text-xs font-semibold tracking-wider text-slate-500 uppercase block mt-1 leading-tight">Unit</span>
                    <span class="text-xs text-emerald-700 font-medium mt-0.5">Pelaku UMKM</span>
                </div>

                <!-- RT/RW -->
                <div class="bg-white/80 backdrop-blur-sm p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all duration-300 flex flex-col items-center text-center group">
                    <div class="w-11 h-11 rounded-xl bg-rose-50 flex items-center justify-center text-rose-700 mb-3 group-hover:bg-rose-600 group-hover:text-white transition-colors duration-200">
                        <i data-lucide="network" class="w-5 h-5"></i>
                    </div>
                    <span class="text-2xl font-extrabold font-display text-emerald-950 block" data-target="{{ $settings['stat_rtrw'] }}">0</span>
                    <span class="text-xs font-semibold tracking-wider text-slate-500 uppercase block mt-1 leading-tight">RT/RW</span>
                    <span class="text-xs text-emerald-700 font-medium mt-0.5">Lingkungan RT</span>
                </div>

                <!-- Dusun -->
                <div class="bg-white/80 backdrop-blur-sm p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all duration-300 flex flex-col items-center text-center group">
                    <div class="w-11 h-11 rounded-xl bg-teal-50 flex items-center justify-center text-teal-700 mb-3 group-hover:bg-teal-700 group-hover:text-white transition-colors duration-200">
                        <i data-lucide="map" class="w-5 h-5"></i>
                    </div>
                    <span class="text-2xl font-extrabold font-display text-emerald-950 block" data-target="{{ $settings['stat_dusun'] }}">0</span>
                    <span class="text-xs font-semibold tracking-wider text-slate-500 uppercase block mt-1 leading-tight">Dusun</span>
                    <span class="text-xs text-emerald-700 font-medium mt-0.5">Wilayah Dusun</span>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
