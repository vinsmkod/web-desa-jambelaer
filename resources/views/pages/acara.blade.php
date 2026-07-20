@extends('layouts.app')

@section('title', 'Acara Desa')
@section('meta_desc', 'Lihat agenda, festival, rapat warga, dan acara kemasyarakatan yang diselenggarakan di Desa Jambelaer, Dawuan, Subang.')

@section('content')
<div class="pt-28 pb-24 bg-gradient-to-b from-ivory to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-16 reveal-on-scroll">
            <span class="text-xs font-bold tracking-widest uppercase text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full">Agenda Warga</span>
            <h1 class="font-display font-extrabold text-3xl sm:text-4xl text-emerald-950 mt-3">Agenda &amp; Acara Desa</h1>
            <p class="mt-4 text-slate-500 font-light text-sm sm:text-base">
                Temukan jadwal kegiatan kemasyarakatan, rapat warga, pertunjukan seni budaya, dan festival komunitas resmi di lingkungan Desa Jambelaer.
            </p>
            <div class="w-16 h-1 bg-gradient-to-r from-emerald-800 to-amber-600 mx-auto mt-4 rounded-full"></div>
        </div>

        <!-- Events Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 reveal-on-scroll delay-100">
            @forelse($acaras as $a)
            <div class="bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col group h-full">
                
                <!-- Event Card Banner (Poster) -->
                <div class="relative h-48 sm:h-52 bg-slate-100 overflow-hidden flex-shrink-0">
                    <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=800&q=80"
                         alt="{{ $a->nama_acara }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute top-4 left-4">
                        <span class="text-[10px] font-bold tracking-wider uppercase text-white bg-emerald-900/90 px-3 py-1 rounded-full backdrop-blur-sm">
                            Kegiatan Resmi
                        </span>
                    </div>
                </div>

                <!-- Event Card Body -->
                <div class="p-6 flex-grow flex flex-col justify-between">
                    <div class="space-y-4">
                        <!-- Date & Time Row -->
                        <div class="flex items-center text-xs font-semibold text-emerald-800 space-x-4">
                            <span class="flex items-center">
                                <i data-lucide="calendar" class="w-3.5 h-3.5 mr-1.5 text-amber-600"></i>
                                {{ $a->tanggal_acara ? $a->tanggal_acara->translatedFormat('d M Y') : '-' }}
                            </span>
                            <span class="flex items-center">
                                <i data-lucide="clock" class="w-3.5 h-3.5 mr-1.5 text-amber-600"></i>
                                {{ $a->waktu_acara ? date('H:i', strtotime($a->waktu_acara)) : '-' }} WIB
                            </span>
                        </div>

                        <!-- Title & Location -->
                        <div>
                            <h3 class="font-display font-bold text-xl text-emerald-955 group-hover:text-emerald-805 transition-colors duration-200 line-clamp-1">
                                {{ $a->nama_acara }}
                            </h3>
                            <p class="text-xs text-slate-400 mt-1 flex items-center">
                                <i data-lucide="map-pin" class="w-3.5 h-3.5 mr-1 text-slate-400"></i>
                                {{ $a->lokasi_acara }}
                            </p>
                        </div>

                        <!-- Description -->
                        <p class="text-slate-500 text-xs sm:text-sm font-light leading-relaxed line-clamp-3">
                            {{ $a->deskripsi_acara }}
                        </p>
                    </div>

                    <!-- Meta & Contact Row -->
                    <div class="mt-6 pt-5 border-t border-slate-50/80 flex items-center justify-between text-xs">
                        <div class="space-y-1">
                            <span class="block text-slate-400 font-medium">Penyelenggara</span>
                            <span class="block font-semibold text-slate-700 truncate max-w-[120px]">{{ $a->name }}</span>
                        </div>

                        @if($a->jumlah_peserta)
                        <div class="bg-amber-50 px-3 py-1.5 rounded-xl text-amber-800 flex items-center font-medium">
                            <i data-lucide="users" class="w-3.5 h-3.5 mr-1.5 text-amber-600"></i>
                            {{ $a->jumlah_peserta }} Peserta
                        </div>
                        @endif

                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $a->no_whatsapp) }}" 
                           target="_blank"
                           class="w-8 h-8 rounded-full bg-emerald-50 hover:bg-emerald-600 hover:text-white flex items-center justify-center text-emerald-700 transition-colors"
                           title="Hubungi WhatsApp Penyelenggara">
                            <i data-lucide="phone" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <!-- Empty State -->
            <div class="col-span-full bg-white border border-slate-100 rounded-3xl p-12 text-center max-w-xl mx-auto shadow-sm">
                <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center mx-auto mb-6">
                    <i data-lucide="calendar" class="w-8 h-8"></i>
                </div>
                <h3 class="font-display font-bold text-xl text-emerald-950">Belum Ada Acara Terjadwal</h3>
                <p class="text-slate-500 font-light text-xs sm:text-sm mt-2 max-w-sm mx-auto leading-relaxed">
                    Saat ini belum ada pengajuan acara warga yang dipublikasikan. Anda ingin mengadakan kegiatan di desa?
                </p>
                <div class="mt-6">
                    <a href="{{ route('kontak') }}" class="inline-flex items-center justify-center px-6 h-11 text-xs font-bold tracking-wider uppercase text-white bg-emerald-900 hover:bg-emerald-800 rounded-xl transition-all">
                        Ajukan Acara Baru
                        <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
                    </a>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
