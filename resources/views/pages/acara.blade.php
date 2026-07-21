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

        <!-- Kalender Acara Timeline Section -->
        @if(isset($acaraPerBulan) && $acaraPerBulan->isNotEmpty())
        <div class="mb-16 bg-white border border-slate-100 rounded-3xl p-6 sm:p-8 shadow-sm reveal-on-scroll">
            <div class="flex items-center justify-between border-b border-slate-100 pb-5 mb-6">
                <div>
                    <span class="text-[10px] font-bold tracking-widest uppercase text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full">Kalender Kegiatan</span>
                    <h2 class="font-display font-bold text-xl sm:text-2xl text-emerald-950 mt-1">Kalender Acara Desa</h2>
                </div>
                <div class="flex items-center space-x-2 text-xs font-semibold text-emerald-800 bg-emerald-50 px-3 py-1.5 rounded-xl">
                    <i data-lucide="calendar" class="w-4 h-4 text-amber-600"></i>
                    <span>Agenda Mendatang</span>
                </div>
            </div>

            <div class="relative border-l-2 border-emerald-200 ml-4 sm:ml-6 space-y-8 pl-6 sm:pl-8 py-2">
                @foreach($acaras as $event)
                <div class="relative group">
                    <!-- Timeline Node Pin -->
                    <div class="absolute -left-[31px] sm:-left-[39px] top-0 w-4 h-4 rounded-full bg-emerald-600 border-4 border-white shadow-sm group-hover:scale-125 transition-transform"></div>

                    <div class="bg-slate-50/70 hover:bg-emerald-50/50 p-4 sm:p-5 rounded-2xl border border-slate-100 hover:border-emerald-200 transition-all duration-200">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                            <div class="flex items-center space-x-2 text-xs font-bold text-amber-700">
                                <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                                <span>{{ $event->tanggal_acara ? $event->tanggal_acara->translatedFormat('l, d F Y') : 'Terjadwal' }}</span>
                                @if($event->waktu_acara)
                                <span class="text-slate-400">•</span>
                                <span class="flex items-center text-slate-500 font-medium">
                                    <i data-lucide="clock" class="w-3 h-3 mr-1"></i>
                                    {{ date('H:i', strtotime($event->waktu_acara)) }} WIB
                                </span>
                                @endif
                            </div>
                            @if($event->lokasi_acara)
                            <div class="inline-flex items-center text-xs text-slate-500 font-medium bg-white px-2.5 py-1 rounded-lg border border-slate-200/80">
                                <i data-lucide="map-pin" class="w-3 h-3 mr-1 text-emerald-700"></i>
                                {{ $event->lokasi_acara }}
                            </div>
                            @endif
                        </div>

                        <h3 class="font-display font-bold text-base sm:text-lg text-emerald-950 mt-2">
                            {{ $event->nama_acara }}
                        </h3>

                        @if($event->deskripsi_acara)
                        <p class="text-slate-500 text-xs sm:text-sm font-light mt-1.5 leading-relaxed line-clamp-2">
                            {{ $event->deskripsi_acara }}
                        </p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Events Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 reveal-on-scroll delay-100">
            @forelse($acaras as $a)
            <div class="bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col group h-full">
                <!-- Event Card Banner (CSS Dynamic Cover) -->
                <div class="relative h-48 sm:h-52 bg-gradient-to-br from-emerald-800 to-emerald-950 flex flex-col items-center justify-center overflow-hidden flex-shrink-0">
                    <!-- Glow decoration -->
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_20%,rgba(251,191,36,0.15),transparent_60%)]"></div>
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 rounded-full bg-white/5 blur-xl"></div>

                    <div class="flex flex-col items-center text-center px-4 relative z-10">
                        <div class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center text-amber-400 mb-3 border border-white/10 shadow-inner group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="calendar" class="w-7 h-7"></i>
                        </div>
                        <span class="text-xs font-bold text-emerald-200 uppercase tracking-widest">Agenda Acara</span>
                    </div>

                    <div class="absolute top-4 left-4">
                        <span class="text-[10px] font-bold tracking-wider uppercase text-emerald-950 bg-amber-400 px-3 py-1 rounded-full shadow-sm">
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