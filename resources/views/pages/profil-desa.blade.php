@extends('layouts.app')

@section('title', 'Profil Desa Jambelaer | Kecamatan Dawuan, Kabupaten Subang')
@section('meta_desc', 'Profil lengkap Desa Jambelaer â€“ sejarah desa, visi misi, sambutan kepala desa, potensi wilayah, dan struktur pemerintahan desa di Kecamatan Dawuan, Kabupaten Subang, Jawa Barat.')
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
      "name": "Profil Desa Jambelaer",
      "item": "{{ config('app.url') }}/tentang-kami"
    }
  ]
}
</script>
@endpush

@section('content')

{{-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
     PAGE HEADER BANNER & BREADCRUMB
â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 sm:pt-6">
    <nav class="flex items-center gap-1.5 text-xs text-stone-500 mb-4 reveal-fade-up">
        <a href="{{ route('home') }}" class="hover:text-forest-800 transition-colors">Beranda</a>
        <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-stone-300"></i>
        <span class="text-forest-800 font-semibold">Profil Desa</span>
    </nav>
</div>

<div class="relative h-60 sm:h-72 lg:h-80 overflow-hidden bg-forest-900 rounded-[28px] sm:rounded-[32px] mx-3 sm:mx-5 lg:mx-6 shadow-sm">
    <img src="{{ asset('uploads/img/sawah.jpeg') }}"
        alt="Hamparan sawah Desa Jambelaer, Kecamatan Dawuan, Kabupaten Subang" class="w-full h-full object-cover opacity-60"
        width="1200" height="400" loading="eager">
    <div class="absolute inset-0 bg-gradient-to-t from-forest-950/90 via-forest-900/50 to-forest-900/20"></div>
    <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
        <span class="section-label !bg-white/10 !text-sand-300 !border-white/20">Profil Desa</span>
        <h1 class="font-display font-extrabold text-3xl sm:text-4xl lg:text-5xl text-white mt-3">Mengenal Desa Jambelaer</h1>
        <p class="text-xs sm:text-sm text-white/70 mt-2 font-light max-w-md">Kecamatan Dawuan â€¢ Kabupaten Subang â€¢ Jawa Barat</p>
    </div>
</div>

<div class="bg-white pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
             SEJARAH DESA â€” Timeline Visual
        â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• --}}
        <div id="sejarah" class="py-16 border-b border-stone-100 reveal-on-scroll scroll-mt-24">
            <div class="grid lg:grid-cols-12 gap-10 items-start">
                {{-- Left: Label --}}
                <div class="lg:col-span-4 space-y-4 lg:sticky lg:top-28">
                    <span class="section-label">Sejarah</span>
                    <h2 class="font-display font-extrabold text-3xl text-forest-900 leading-tight">
                        Asal-Usul<br>Desa Jambelaer
                    </h2>
                    <div class="section-divider !mx-0"></div>
                    <p class="text-sm text-stone-500 font-light leading-relaxed">
                        {{ $profil['sejarah'] }}
                    </p>
                </div>

                {{-- Right: Timeline --}}
                <div class="lg:col-span-8">
                    <div class="relative">
                        {{-- Vertical line --}}
                        <div class="absolute left-5 top-0 bottom-0 w-px bg-forest-100"></div>

                        <div class="space-y-8">
                            @foreach($timeline as $item)
                                @php $palette = $item->palette_classes; @endphp
                                <div class="flex gap-6 group">
                                    <div class="relative z-10 flex-shrink-0">
                                        <div class="w-10 h-10 rounded-full {{ $palette['dot'] }} border-4 border-white shadow-sm flex items-center justify-center">
                                            <i data-lucide="{{ $item->ikon ?: 'circle' }}" class="w-4 h-4 {{ $palette['icon'] }}"></i>
                                        </div>
                                    </div>
                                    <div class="{{ $loop->last ? 'flex-1' : 'pb-8 flex-1' }}">
                                        <div class="{{ $palette['card'] }} rounded-xl p-5">
                                            <span class="text-[11px] font-bold tracking-widest uppercase {{ $palette['badge'] }}">Tahun {{ $item->tahun }}</span>
                                            <h3 class="font-display font-bold text-base text-forest-900 mt-1">{{ $item->judul }}</h3>
                                            <div class="text-sm text-stone-600 font-light leading-relaxed mt-2 [&_strong]:font-semibold [&_strong]:text-forest-800">
                                                {!! $item->deskripsi !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
             SAMBUTAN KEPALA DESA
        â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• --}}
        <div id="sambutan" class="py-16 border-b border-stone-100 reveal-on-scroll scroll-mt-24">
            <div class="grid lg:grid-cols-12 gap-12 items-center">
                {{-- Photo --}}
                <div class="lg:col-span-4 flex justify-center lg:justify-start">
                    <div class="relative">
                        {{-- Frame decorative --}}
                        <div class="absolute -top-3 -left-3 w-full h-full border-2 border-sand-200 rounded-xl"></div>
                        <div class="relative">
                            @php
                            $kadesFoto = $settings['kades_foto']->value ?? asset('uploads/img/DESA_JAMBELAER.png');
                            if ($kadesFoto && !str_starts_with($kadesFoto, 'http') && file_exists(public_path($kadesFoto))) {
                            $kadesFoto = asset($kadesFoto);
                            }
                            @endphp
                            <img src="{{ $kadesFoto }}"
                                alt="Kepala Desa Jambelaer"
                                class="w-64 h-72 sm:w-72 sm:h-80 object-cover rounded-xl shadow-lg border border-stone-100">
                            {{-- Name plate --}}
                            <div class="absolute -bottom-0 left-0 right-0 bg-forest-800/95 rounded-b-xl px-5 py-4">
                                <span class="font-display font-bold text-sm text-white block">{{ $settings['kades_nama']->value ?? 'Bapak Dedi Suherman, S.E.' }}</span>
                                <span class="text-[11px] font-light tracking-wider uppercase text-sand-400 block mt-0.5">{{ $settings['kades_jabatan']->value ?? 'Kepala Desa Jambelaer' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Text --}}
                <div class="lg:col-span-8 space-y-5">
                    <span class="section-label">Sambutan</span>
                    <h2 class="font-display font-extrabold text-2xl sm:text-3xl text-forest-900">{{ $settings['sambutan_judul']->value ?? 'Sambutan Kepala Desa' }}</h2>
                    <div class="section-divider !mx-0"></div>

                    @if(!empty($settings['sambutan_quote']->value))
                    <blockquote class="border-l-4 border-sand-400 pl-5 py-1 font-serif italic text-base text-stone-700 leading-relaxed">
                        "{{ $settings['sambutan_quote']->value }}"
                    </blockquote>
                    @endif

                    @php
                    $rawTeks = $settings['sambutan_teks']->value ?? '';
                    $paragraphs = array_filter(explode("\n", str_replace("\r", "", $rawTeks)));
                    @endphp

                    @if(!empty($paragraphs))
                    @foreach($paragraphs as $p)
                    <p class="text-stone-600 leading-relaxed font-light text-sm">
                        {{ trim($p) }}
                    </p>
                    @endforeach
                    @else
                    <p class="text-stone-600 leading-relaxed font-light text-sm">
                        Kami berkomitmen untuk terus membangun desa yang mandiri, sejahtera, dan berdaya saing dengan menjunjung tinggi nilai-nilai budaya lokal yang telah diwariskan leluhur. Dengan semangat gotong royong dan kebersamaan, kami yakin Desa Jambelaer akan terus maju dan berkembang.
                    </p>
                    <p class="text-stone-600 leading-relaxed font-light text-sm">
                        Kami mengundang seluruh masyarakat, perantau, dan mitra usaha untuk berkolaborasi membangun desa yang kita cintai bersama. Portal ini hadir sebagai jembatan informasi yang terbuka bagi semua.
                    </p>
                    @endif

                    @if(!empty($settings['sambutan_tagline']->value))
                    <div class="flex items-center gap-3 pt-2 bg-forest-50 border border-forest-100 rounded-xl px-5 py-4">
                        <i data-lucide="quote" class="w-5 h-5 text-sand-500 flex-shrink-0"></i>
                        <span class="text-sm text-forest-800 font-semibold font-display">
                            {{ $settings['sambutan_tagline']->value }}
                        </span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
             INFORMASI DESA â€” 3 Kartu
        â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• --}}
        <div id="data-desa" class="py-16 border-b border-stone-100 reveal-on-scroll delay-100 scroll-mt-24">
            <div class="text-center mb-10">
                <span class="section-label">Profil Wilayah</span>
                <h2 class="font-display font-extrabold text-2xl sm:text-3xl text-forest-900 mt-3">Informasi Wilayah Desa</h2>
                <div class="section-divider"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                {{-- Letak Geografis --}}
                <div class="bg-white border border-stone-200 rounded-2xl p-6 hover:border-forest-200 hover:shadow-md transition-all duration-300">
                    <div class="flex items-center gap-3 mb-5 pb-4 border-b border-stone-100">
                        <div class="w-10 h-10 rounded-xl bg-forest-50 border border-forest-100 flex items-center justify-center text-forest-700">
                            <i data-lucide="map-pin" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="font-display font-bold text-sm text-forest-900">Letak Geografis</h3>
                            <span class="text-xs text-stone-400 font-light">Batas & Luas Administratif</span>
                        </div>
                    </div>
                    <p class="text-sm text-stone-600 font-light leading-relaxed mb-5">
                        {{ $profil['letak'] }}
                    </p>

                    <div class="grid grid-cols-2 gap-2">
                        <div class="bg-stone-50 rounded-lg p-3 border border-stone-100">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-stone-400 block mb-1">â†‘ Utara</span>
                            <span class="text-xs font-semibold text-forest-900">{{ $profil['batas_utara'] }}</span>
                        </div>
                        <div class="bg-stone-50 rounded-lg p-3 border border-stone-100">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-stone-400 block mb-1">â†’ Timur</span>
                            <span class="text-xs font-semibold text-forest-900">{{ $profil['batas_timur'] }}</span>
                        </div>
                        <div class="bg-stone-50 rounded-lg p-3 border border-stone-100">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-stone-400 block mb-1">â†“ Selatan</span>
                            <span class="text-xs font-semibold text-forest-900">{{ $profil['batas_selatan'] }}</span>
                        </div>
                        <div class="bg-stone-50 rounded-lg p-3 border border-stone-100">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-stone-400 block mb-1">â† Barat</span>
                            <span class="text-xs font-semibold text-forest-900">{{ $profil['batas_barat'] }}</span>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-t border-stone-100 flex items-center justify-between">
                        <span class="text-xs text-stone-500 font-medium">Total Luas Wilayah</span>
                        <span class="text-xs font-bold text-forest-800 bg-forest-50 border border-forest-100 px-3 py-1 rounded-full">
                            {{ $profil['luas'] }}
                        </span>
                    </div>
                </div>

                {{-- Potensi Utama --}}
                <div class="bg-white border border-stone-200 rounded-2xl p-6 hover:border-sand-200 hover:shadow-md transition-all duration-300">
                    <div class="flex items-center gap-3 mb-5 pb-4 border-b border-stone-100">
                        <div class="w-10 h-10 rounded-xl bg-sand-50 border border-sand-100 flex items-center justify-center text-sand-700">
                            <i data-lucide="wheat" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="font-display font-bold text-sm text-forest-900">{{ $profil['potensi_judul'] }}</h3>
                            <span class="text-xs text-stone-400 font-light">{{ $profil['potensi_subjudul'] }}</span>
                        </div>
                    </div>
                    <p class="text-sm text-stone-600 font-light leading-relaxed">
                        {{ $profil['potensi_deskripsi'] }}
                    </p>
                </div>

                {{-- Administrasi --}}
                <div class="bg-white border border-stone-200 rounded-2xl p-6 hover:border-sky-200 hover:shadow-md transition-all duration-300">
                    <div class="flex items-center gap-3 mb-5 pb-4 border-b border-stone-100">
                        <div class="w-10 h-10 rounded-xl bg-sky-50 border border-sky-100 flex items-center justify-center text-sky-700">
                            <i data-lucide="building-2" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="font-display font-bold text-sm text-forest-900">{{ $profil['administrasi_judul'] }}</h3>
                            <span class="text-xs text-stone-400 font-light">{{ $profil['administrasi_subjudul'] }}</span>
                        </div>
                    </div>
                    <p class="text-sm text-stone-600 font-light leading-relaxed">
                        {{ $profil['administrasi_deskripsi'] }}
                    </p>
                </div>
            </div>
        </div>

        {{-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
             VISI & MISI â€” Side by Side Panel
        â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• --}}
        <div id="visi-misi" class="py-16 border-b border-stone-100 reveal-on-scroll delay-200 scroll-mt-24">
            <div class="text-center mb-10">
                <span class="section-label">Arah Pembangunan</span>
                <h2 class="font-display font-extrabold text-2xl sm:text-3xl text-forest-900 mt-3">Visi & Misi Desa</h2>
                <div class="section-divider"></div>
            </div>

            <div class="grid lg:grid-cols-2 gap-5">
                {{-- Visi --}}
                <div class="bg-forest-900 text-white rounded-2xl p-8 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-48 h-48 bg-forest-700/30 rounded-full -mr-16 -mt-16 blur-2xl"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-sand-500/20 border border-sand-400/30 flex items-center justify-center">
                                <i data-lucide="eye" class="w-5 h-5 text-sand-300"></i>
                            </div>
                            <h3 class="font-display font-bold text-lg text-white">Visi Desa</h3>
                        </div>
                        <blockquote class="font-serif italic text-base text-sand-200 leading-relaxed border-l-4 border-sand-500 pl-5">
                            "{{ $profil['visi'] }}"
                        </blockquote>
                        <p class="mt-4 text-sm text-white/50 font-light leading-relaxed">
                            {{ $profil['visi_deskripsi'] }}
                        </p>
                    </div>
                </div>

                {{-- Misi --}}
                <div class="bg-sand-50 border border-sand-100 rounded-2xl p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-sand-200 border border-sand-200 flex items-center justify-center">
                            <i data-lucide="target" class="w-5 h-5 text-sand-700"></i>
                        </div>
                        <h3 class="font-display font-bold text-lg text-forest-900">Misi Desa</h3>
                    </div>
                    <ul class="space-y-3">
                        @foreach($misi as $i => $item)
                        <li class="flex items-start gap-3">
                            <span class="flex-shrink-0 w-6 h-6 rounded bg-forest-800 text-white flex items-center justify-center font-bold text-[10px] mt-0.5">{{ $i + 1 }}</span>
                            <span class="text-sm text-stone-700 font-light leading-relaxed">{{ $item->isi }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        {{-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
             STRUKTUR ORGANISASI â€” DIPINDAHKAN KE HALAMAN TERPISAH (/struktur-desa)
        â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• --}}
        <div class="py-16 border-b border-stone-100 reveal-on-scroll delay-300">
            <div class="bg-gradient-to-br from-forest-50 to-sand-50 border border-forest-100 rounded-3xl p-8 sm:p-12 text-center">
                <div class="w-14 h-14 rounded-2xl bg-forest-800 text-sand-300 flex items-center justify-center mx-auto mb-5">
                    <i data-lucide="users" class="w-7 h-7"></i>
                </div>
                <h2 class="font-display font-extrabold text-2xl sm:text-3xl text-forest-900">Struktur Pemerintahan Desa</h2>
                <p class="text-stone-500 font-light mt-3 text-sm max-w-lg mx-auto">
                    Kenali para perangkat desa yang berdedikasi melayani masyarakat Desa Jambelaer. Susunan lengkap struktur organisasi kini tersedia pada halaman khusus.
                </p>
                <a href="{{ route('struktur.desa') }}" class="btn-primary mt-7 inline-flex items-center gap-2">
                    Lihat Struktur Desa
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        </div>

        {{-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
             PETA LOKASI
        â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• --}}
        <div id="peta" class="py-14 reveal-on-scroll scroll-mt-24">
            <div class="text-center mb-8">
                <span class="section-label">Peta Wilayah</span>
                <h2 class="font-display font-extrabold text-2xl sm:text-3xl text-forest-900 mt-3">Lokasi Kantor Desa</h2>
                <div class="section-divider"></div>
            </div>

            <div class="bg-white border border-stone-200 rounded-2xl p-3 shadow-sm max-w-5xl mx-auto">
                <div class="h-80 sm:h-[420px] rounded-xl overflow-hidden">
                    <iframe
                        src="{{ !empty($mapsUrl) ? $mapsUrl : 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.262529813204!2d107.6761505!3d-6.6124570!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6923c6db1dfea3%3A0xc0f3970f1ff4dff9!2sKantor%20Desa%20Jambelaer!5e0!3m2!1sid!2sid!4v1720894000000!5m2!1sid!2sid' }}"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3 px-3 pt-3 pb-1">
                    <i data-lucide="map-pin" class="w-4 h-4 text-forest-600 flex-shrink-0 hidden sm:block"></i>
                    <span class="text-xs text-stone-500 font-light min-w-0 sm:truncate">{{ $profil['alamat'] }}</span>
                    <a href="{{ $profil['maps_link'] }}" target="_blank" class="sm:ml-auto text-[11px] text-forest-700 font-semibold hover:text-forest-500 whitespace-nowrap flex items-center gap-1 flex-shrink-0">
                        Buka Maps <i data-lucide="external-link" class="w-3 h-3"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
