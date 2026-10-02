@extends('layouts.app')

@section('title', 'Agenda & Acara Desa Jambelaer | Kecamatan Dawuan, Subang')
@section('meta_desc', 'Lihat agenda resmi, festival, rapat warga, dan acara kemasyarakatan yang diselenggarakan oleh Pemerintah Desa Jambelaer, Kecamatan Dawuan, Kabupaten Subang.')

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    { "@type": "ListItem", "position": 1, "name": "Beranda", "item": "{{ config('app.url') }}" },
    { "@type": "ListItem", "position": 2, "name": "Agenda Desa Jambelaer", "item": "{{ config('app.url') }}/acara" }
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
        <span class="text-forest-800 font-semibold">Agenda Acara</span>
    </nav>
</div>

<div class="relative h-60 sm:h-72 lg:h-80 overflow-hidden bg-forest-900 rounded-[28px] sm:rounded-[32px] mx-3 sm:mx-5 lg:mx-6 shadow-sm">
    <img src="{{ asset('uploads/img/beranda.jpeg') }}"
        alt="Agenda Warga Desa Jambelaer" class="w-full h-full object-cover opacity-60">
    <div class="absolute inset-0 bg-gradient-to-t from-forest-950/90 via-forest-900/50 to-forest-900/20"></div>
    <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
        <span class="section-label !bg-white/10 !text-sand-300 !border-white/20">Agenda Publik</span>
        <h1 class="font-display font-extrabold text-3xl sm:text-4xl lg:text-5xl text-white mt-3">Agenda & Acara Desa</h1>
        <p class="text-xs sm:text-sm text-white/70 mt-2 font-light max-w-md">Jadwal kegiatan kemasyarakatan, rapat warga, pertunjukan seni budaya, dan festival komunitas</p>
    </div>
</div>

<div class="bg-white pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- ── Kalender Acara Timeline Section ── --}}
        @if(isset($acaraPerBulan) && $acaraPerBulan->isNotEmpty())
        <div class="my-10 bg-white border border-stone-200 rounded-xl p-6 sm:p-8 shadow-sm reveal-on-scroll">
            <div class="flex items-center justify-between border-b border-stone-100 pb-5 mb-6">
                <div>
                    <span class="text-[10px] font-bold tracking-widest uppercase text-forest-600 bg-forest-50 border border-forest-100 px-2.5 py-1 rounded">Kalender Kegiatan</span>
                    <h2 class="font-display font-bold text-lg sm:text-xl text-stone-800 mt-2">Kalender Acara Terdekat</h2>
                </div>
                <div class="flex items-center space-x-2 text-xs font-semibold text-forest-800 bg-forest-50 border border-forest-100 px-3 py-1.5 rounded">
                    <i data-lucide="calendar" class="w-4 h-4 text-sand-500"></i>
                    <span>Agenda Mendatang</span>
                </div>
            </div>

            <div class="relative border-l border-stone-200 ml-4 sm:ml-6 space-y-6 pl-6 sm:pl-8 py-2">
                @foreach($acaras as $event)
                <div class="relative group">
                    <!-- Timeline Node Pin -->
                    <div class="absolute -left-[31px] sm:-left-[39px] top-1.5 w-3.5 h-3.5 rounded-full bg-forest-800 border-4 border-white shadow-sm group-hover:scale-125 transition-transform"></div>

                    <div class="bg-stone-50/50 hover:bg-forest-50/30 p-4 sm:p-5 rounded-lg border border-stone-200 hover:border-forest-200 transition-all duration-200">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                            <div class="flex items-center space-x-2 text-xs font-bold text-sand-700">
                                <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                                <span>{{ $event->tanggal_acara ? $event->tanggal_acara->translatedFormat('l, d F Y') : 'Terjadwal' }}</span>
                                @if($event->waktu_acara)
                                <span class="text-stone-300">•</span>
                                <span class="flex items-center text-stone-500 font-medium">
                                    <i data-lucide="clock" class="w-3 h-3 mr-1 text-sand-500"></i>
                                    {{ date('H:i', strtotime($event->waktu_acara)) }} WIB
                                </span>
                                @endif
                            </div>
                            @if($event->lokasi_acara)
                            <div class="inline-flex items-center text-xs text-stone-500 font-medium bg-white px-2.5 py-1 rounded border border-stone-200">
                                <i data-lucide="map-pin" class="w-3 h-3 mr-1 text-forest-750"></i>
                                {{ $event->lokasi_acara }}
                            </div>
                            @endif
                        </div>

                        <h3 class="font-display font-bold text-base text-stone-800 mt-2">
                            {{ $event->nama_acara }}
                        </h3>

                        @if($event->deskripsi_acara)
                        <p class="text-stone-500 text-xs sm:text-sm font-light mt-1.5 leading-relaxed line-clamp-2">
                            {{ $event->deskripsi_acara }}
                        </p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ── Events Grid ── --}}
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 reveal-on-scroll delay-100 mt-10">
            @forelse($acaras as $a)
            <div class="bg-white rounded-xl overflow-hidden border border-stone-200 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col group h-full hover:border-forest-200">
                <!-- Event Card Banner -->
                <div class="relative h-44 bg-forest-900 flex flex-col items-center justify-center overflow-hidden flex-shrink-0">
                    @php
                        $posterUrl = null;
                        if ($a->foto_bukti) {
                            $posterUrl = (str_starts_with($a->foto_bukti, 'http') || str_starts_with($a->foto_bukti, '/'))
                                ? asset($a->foto_bukti)
                                : \Illuminate\Support\Facades\Storage::url($a->foto_bukti);
                        }
                    @endphp

                    @if($posterUrl)
                        <img src="{{ $posterUrl }}" alt="{{ $a->nama_acara }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-forest-950/80 via-forest-950/40 to-forest-950/10"></div>
                    @else
                        <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_20%,rgba(196,154,79,0.1),transparent_60%)]"></div>

                        <div class="flex flex-col items-center text-center px-4 relative z-10">
                            <div class="w-12 h-12 rounded-lg bg-white/10 flex items-center justify-center text-sand-300 mb-3 border border-white/10 shadow-inner group-hover:scale-105 transition-transform duration-300">
                                <i data-lucide="calendar" class="w-6 h-6"></i>
                            </div>
                            <span class="text-[10px] font-bold text-white/50 uppercase tracking-widest">Agenda Desa</span>
                        </div>
                    @endif

                    <div class="absolute top-3 left-3 z-10">
                        @if($a->tanggal_acara && $a->tanggal_acara->isToday())
                        <span class="text-[9px] font-bold tracking-wider uppercase text-emerald-800 bg-emerald-100 px-2 py-0.5 rounded shadow-sm inline-flex items-center gap-1">
                            <span class="w-1.5 h-1.5 bg-emerald-600 rounded-full animate-pulse"></span> Sesi Hari Ini
                        </span>
                        @else
                        <span class="text-[9px] font-bold tracking-wider uppercase text-sand-900 bg-sand-200 px-2 py-0.5 rounded shadow-sm">
                            Sesi Mendatang
                        </span>
                        @endif
                    </div>
                </div>

                <!-- Event Card Body -->
                <div class="p-5 flex-grow flex flex-col justify-between">
                    <div class="space-y-3.5">
                        <!-- Date & Time Row -->
                        <div class="flex items-center text-xs font-semibold text-forest-800 space-x-4">
                            <span class="flex items-center">
                                <i data-lucide="calendar" class="w-3.5 h-3.5 mr-1.5 text-sand-500"></i>
                                {{ $a->tanggal_acara ? $a->tanggal_acara->translatedFormat('d M Y') : '-' }}
                            </span>
                            <span class="flex items-center">
                                <i data-lucide="clock" class="w-3.5 h-3.5 mr-1.5 text-sand-500"></i>
                                {{ $a->waktu_acara ? date('H:i', strtotime($a->waktu_acara)) : '-' }} WIB
                            </span>
                        </div>

                        <!-- Title & Location -->
                        <div>
                            <h3 class="font-display font-bold text-base text-stone-800 group-hover:text-forest-700 transition-colors duration-200 line-clamp-1">
                                {{ $a->nama_acara }}
                            </h3>
                            <p class="text-xs text-stone-400 mt-1 flex items-center">
                                <i data-lucide="map-pin" class="w-3.5 h-3.5 mr-1 text-stone-400"></i>
                                {{ $a->lokasi_acara }}
                            </p>
                        </div>

                        <!-- Description -->
                        <p class="text-stone-500 text-xs sm:text-sm font-light leading-relaxed line-clamp-3">
                            {{ $a->deskripsi_acara }}
                        </p>
                    </div>

                    <!-- Meta & Contact Row -->
                    <div class="mt-6 pt-4 border-t border-stone-100 flex items-center justify-between text-xs">
                        <div class="space-y-0.5">
                            <span class="block text-[10px] text-stone-400 font-bold uppercase tracking-wider">Penyelenggara</span>
                            <span class="block font-semibold text-stone-700 truncate max-w-[130px]">{{ $a->name }}</span>
                        </div>

                        @if($a->jumlah_peserta)
                        <div class="bg-sand-50 border border-sand-100 px-2.5 py-1 rounded text-sand-700 flex items-center font-medium">
                            <i data-lucide="users" class="w-3.5 h-3.5 mr-1.5 text-sand-500"></i>
                            {{ $a->jumlah_peserta }} Peserta
                        </div>
                        @endif

                        <a href="{{ route('kontak', ['layanan' => 'pertanyaan_umum']) }}"
                            class="w-8 h-8 rounded bg-forest-50 border border-forest-100 hover:bg-forest-800 hover:text-white flex items-center justify-center text-forest-800 transition-colors"
                            title="Tanya Seputar Acara">
                            <i data-lucide="help-circle" class="w-3.5 h-3.5"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <!-- Empty State -->
            <div class="col-span-full bg-white border border-stone-200 rounded-xl p-10 text-center max-w-md mx-auto shadow-sm">
                <div class="w-12 h-12 rounded-lg bg-forest-50 border border-forest-100 text-forest-700 flex items-center justify-center mx-auto mb-5">
                    <i data-lucide="calendar" class="w-6 h-6"></i>
                </div>
                <h3 class="font-display font-bold text-base text-stone-800">Belum Ada Agenda Acara</h3>
                <p class="text-stone-400 font-light text-xs mt-2 max-w-xs mx-auto leading-relaxed">
                    Saat ini belum ada agenda acara resmi pemerintah desa yang terjadwal.
                </p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection