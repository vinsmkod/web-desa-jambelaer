@extends('layouts.app')

@section('title', 'Tentang Kami')
@section('meta_desc', 'Kenali lebih dekat Desa Jambelaer – sejarah, profil, visi & misi, serta sambutan hangat kepala desa Kecamatan Dawuan, Kabupaten Subang.')

@section('content')

{{-- ══════════════════════════════════════════════════════════════════
     PAGE HEADER BANNER
══════════════════════════════════════════════════════════════════ --}}
<div class="relative h-52 sm:h-64 overflow-hidden bg-forest-900 rounded-[32px] mx-3 sm:mx-5 lg:mx-6 mt-6 shadow-sm">
    <img src="https://images.unsplash.com/photo-1500937386664-56d1dfef3854?auto=format&fit=crop&w=1920&q=80"
        alt="Desa Jambelaer" class="w-full h-full object-cover opacity-30">
    <div class="absolute inset-0 bg-gradient-to-t from-forest-900 to-forest-900/60"></div>
    <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
        <span class="section-label !bg-white/10 !text-sand-300 !border-white/20">Tentang Kami</span>
        <h1 class="font-display font-extrabold text-3xl sm:text-4xl text-white mt-3">Mengenal Desa Jambelaer</h1>
        <p class="text-sm text-white/50 mt-2 font-light max-w-md">Kecamatan Dawuan, Kabupaten Subang, Jawa Barat</p>
    </div>
</div>

<div class="bg-white pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- ══════════════════════════════════════════════════════════
             SEJARAH DESA — Timeline Visual
        ══════════════════════════════════════════════════════════ --}}
        <div class="py-16 border-b border-stone-100 reveal-on-scroll">
            <div class="grid lg:grid-cols-12 gap-10 items-start">
                {{-- Left: Label --}}
                <div class="lg:col-span-4 space-y-4 lg:sticky lg:top-28">
                    <span class="section-label">Sejarah</span>
                    <h2 class="font-display font-extrabold text-3xl text-forest-900 leading-tight">
                        Asal-Usul<br>Desa Jambelaer
                    </h2>
                    <div class="section-divider !mx-0"></div>
                    <p class="text-sm text-stone-500 font-light leading-relaxed">
                        Desa Jambelaer merupakan salah satu desa di wilayah Kecamatan Dawuan yang sebelumnya termasuk ke dalam wilayah Kecamatan Kalijati, berdasarkan Peraturan Daerah Nomor 3 Tahun 2007.
                    </p>
                </div>

                {{-- Right: Timeline --}}
                <div class="lg:col-span-8">
                    <div class="relative">
                        {{-- Vertical line --}}
                        <div class="absolute left-5 top-0 bottom-0 w-px bg-forest-100"></div>

                        <div class="space-y-8">
                            {{-- Timeline item 1 --}}
                            <div class="flex gap-6 group">
                                <div class="relative z-10 flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full bg-forest-800 border-4 border-white shadow-sm flex items-center justify-center">
                                        <i data-lucide="users" class="w-4 h-4 text-sand-300"></i>
                                    </div>
                                </div>
                                <div class="pb-8 flex-1">
                                    <div class="bg-sand-50 border border-sand-100 rounded-xl p-5">
                                        <span class="text-[11px] font-bold tracking-widest uppercase text-sand-600">Tahun 1923</span>
                                        <h3 class="font-display font-bold text-base text-forest-900 mt-1">Prakarsa 4 Galandang</h3>
                                        <p class="text-sm text-stone-600 font-light leading-relaxed mt-2">
                                            Desa Jambelaer dibentuk atas kesepakatan 4 tokoh galandang:
                                            <strong class="text-forest-800">SURLI</strong> (Kp. Jambelaer),
                                            <strong class="text-forest-800">ARNAB</strong> (Kp. Sadang),
                                            <strong class="text-forest-800">RUKI</strong> (Kp. Jambelaer), dan
                                            <strong class="text-forest-800">SUWARI</strong> (Kp. Melong).
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Timeline item 2 --}}
                            <div class="flex gap-6 group">
                                <div class="relative z-10 flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full bg-sand-500 border-4 border-white shadow-sm flex items-center justify-center">
                                        <i data-lucide="landmark" class="w-4 h-4 text-white"></i>
                                    </div>
                                </div>
                                <div class="pb-8 flex-1">
                                    <div class="bg-sand-50 border border-sand-100 rounded-xl p-5">
                                        <span class="text-[11px] font-bold tracking-widest uppercase text-sand-600">Tahun 1940 – 1985</span>
                                        <h3 class="font-display font-bold text-base text-forest-900 mt-1">Pemerintahan Pertama</h3>
                                        <p class="text-sm text-stone-600 font-light leading-relaxed mt-2">
                                            Kepala desa pertama dijabat oleh <strong class="text-forest-800">SUWARI</strong>, salah satu tokoh pendiri desa, yang memimpin selama 45 tahun dengan dedikasi penuh kepada masyarakat.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Timeline item 3 --}}
                            <div class="flex gap-6 group">
                                <div class="relative z-10 flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full bg-forest-600 border-4 border-white shadow-sm flex items-center justify-center">
                                        <i data-lucide="vote" class="w-4 h-4 text-white"></i>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="bg-sand-50 border border-sand-100 rounded-xl p-5">
                                        <span class="text-[11px] font-bold tracking-widest uppercase text-sand-600">Tahun 1961</span>
                                        <h3 class="font-display font-bold text-base text-forest-900 mt-1">Pemilihan Demokratis Pertama</h3>
                                        <p class="text-sm text-stone-600 font-light leading-relaxed mt-2">
                                            Pemilihan kepala desa secara demokratis oleh masyarakat pertama kali dilaksanakan, menandai dimulainya tata kelola pemerintahan desa yang partisipatif.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Timeline item 4 --}}
                            <div class="flex gap-6 group">
                                <div class="relative z-10 flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full bg-stone-300 border-4 border-white shadow-sm flex items-center justify-center">
                                        <i data-lucide="file-text" class="w-4 h-4 text-stone-600"></i>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="bg-forest-50 border border-forest-100 rounded-xl p-5">
                                        <span class="text-[11px] font-bold tracking-widest uppercase text-forest-600">Tahun 2007</span>
                                        <h3 class="font-display font-bold text-base text-forest-900 mt-1">Pemekaran Kecamatan</h3>
                                        <p class="text-sm text-stone-600 font-light leading-relaxed mt-2">
                                            Berdasarkan Peraturan Daerah Nomor 3 Tahun 2007, Desa Jambelaer resmi masuk ke dalam wilayah Kecamatan Dawuan yang baru dimekarkan dari Kecamatan Kalijati.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════════
             SAMBUTAN KEPALA DESA
        ══════════════════════════════════════════════════════════ --}}
        <div class="py-16 border-b border-stone-100 reveal-on-scroll">
            <div class="grid lg:grid-cols-12 gap-12 items-center">
                {{-- Photo --}}
                <div class="lg:col-span-4 flex justify-center lg:justify-start">
                    <div class="relative">
                        {{-- Frame decorative --}}
                        <div class="absolute -top-3 -left-3 w-full h-full border-2 border-sand-200 rounded-xl"></div>
                        <div class="relative">
                            <img src="{{ $settings['kades_foto']->value ?? 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=600&h=600&q=80' }}"
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
                    <h2 class="font-display font-extrabold text-2xl sm:text-3xl text-forest-900">Sambutan Kepala Desa</h2>
                    <div class="section-divider !mx-0"></div>

                    <blockquote class="border-l-4 border-sand-400 pl-5 py-1 font-serif italic text-base text-stone-700 leading-relaxed">
                        "Assalamu'alaikum Wr. Wb. Atas nama Pemerintah Desa Jambelaer, kami menyambut kehadiran Anda di portal resmi kami dengan penuh rasa syukur dan kebanggaan."
                    </blockquote>

                    <p class="text-stone-600 leading-relaxed font-light text-sm">
                        Kami berkomitmen untuk terus membangun desa yang mandiri, sejahtera, dan berdaya saing dengan menjunjung tinggi nilai-nilai budaya lokal yang telah diwariskan leluhur. Dengan semangat gotong royong dan kebersamaan, kami yakin Desa Jambelaer akan terus maju dan berkembang.
                    </p>

                    <p class="text-stone-600 leading-relaxed font-light text-sm">
                        Kami mengundang seluruh masyarakat, perantau, dan mitra usaha untuk berkolaborasi membangun desa yang kita cintai bersama. Portal ini hadir sebagai jembatan informasi yang terbuka bagi semua.
                    </p>

                    <div class="flex items-center gap-3 pt-2 bg-forest-50 border border-forest-100 rounded-xl px-5 py-4">
                        <i data-lucide="quote" class="w-5 h-5 text-sand-500 flex-shrink-0"></i>
                        <span class="text-sm text-forest-800 font-semibold font-display">
                            Melayani dengan Amanah, Terbuka, dan Transparan.
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════════
             INFORMASI DESA — 3 Kartu
        ══════════════════════════════════════════════════════════ --}}
        <div class="py-16 border-b border-stone-100 reveal-on-scroll delay-100">
            <div class="text-center mb-10">
                <span class="section-label">Profil Wilayah</span>
                <h2 class="font-display font-extrabold text-2xl sm:text-3xl text-forest-900 mt-3">Informasi Wilayah Desa</h2>
                <div class="section-divider"></div>
            </div>

            <div class="grid lg:grid-cols-3 gap-5">
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
                        Wilayah Desa Jambelaer terletak di Kecamatan Dawuan, Kabupaten Subang, Provinsi Jawa Barat dengan topografi yang didominasi lahan pertanian produktif.
                    </p>

                    <div class="grid grid-cols-2 gap-2">
                        <div class="bg-stone-50 rounded-lg p-3 border border-stone-100">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-stone-400 block mb-1">↑ Utara</span>
                            <span class="text-xs font-semibold text-forest-900">Desa Cisampih</span>
                        </div>
                        <div class="bg-stone-50 rounded-lg p-3 border border-stone-100">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-stone-400 block mb-1">→ Timur</span>
                            <span class="text-xs font-semibold text-forest-900">Kelurahan Parung</span>
                        </div>
                        <div class="bg-stone-50 rounded-lg p-3 border border-stone-100">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-stone-400 block mb-1">↓ Selatan</span>
                            <span class="text-xs font-semibold text-forest-900">Desa Curug Agung</span>
                        </div>
                        <div class="bg-stone-50 rounded-lg p-3 border border-stone-100">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-stone-400 block mb-1">← Barat</span>
                            <span class="text-xs font-semibold text-forest-900">Desa Tanggulun Timur</span>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-t border-stone-100 flex items-center justify-between">
                        <span class="text-xs text-stone-500 font-medium">Total Luas Wilayah</span>
                        <span class="text-xs font-bold text-forest-800 bg-forest-50 border border-forest-100 px-3 py-1 rounded-full">
                            2.500,366 Ha
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
                            <h3 class="font-display font-bold text-sm text-forest-900">Potensi Utama</h3>
                            <span class="text-xs text-stone-400 font-light">Sumber Daya & Ekonomi</span>
                        </div>
                    </div>
                    <p class="text-sm text-stone-600 font-light leading-relaxed">
                        Lahan persawahan yang produktif menjadi tulang punggung perekonomian desa bersama industri UMKM rumahan dan kerajinan bambu. Sektor pertanian padi, palawija, dan hortikultura menjadi andalan mata pencaharian warga Desa Jambelaer sehari-hari.
                    </p>
                </div>

                {{-- Administrasi --}}
                <div class="bg-white border border-stone-200 rounded-2xl p-6 hover:border-sky-200 hover:shadow-md transition-all duration-300">
                    <div class="flex items-center gap-3 mb-5 pb-4 border-b border-stone-100">
                        <div class="w-10 h-10 rounded-xl bg-sky-50 border border-sky-100 flex items-center justify-center text-sky-700">
                            <i data-lucide="building-2" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="font-display font-bold text-sm text-forest-900">Administrasi Desa</h3>
                            <span class="text-xs text-stone-400 font-light">Struktur & Wilayah</span>
                        </div>
                    </div>
                    <p class="text-sm text-stone-600 font-light leading-relaxed">
                        Salah satu dari 10 desa di bawah Kecamatan Dawuan dengan pemerintahan yang aktif dan transparan. Desa Jambelaer terdiri dari beberapa dusun dengan RT/RW yang tertata rapi untuk memudahkan pelayanan masyarakat di tingkat paling bawah.
                    </p>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════════
             VISI & MISI — Side by Side Panel
        ══════════════════════════════════════════════════════════ --}}
        <div class="py-16 border-b border-stone-100 reveal-on-scroll delay-200">
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
                            "Mewujudkan Desa Jambelaer yang Mandiri, Sejahtera, Berbasis Pertanian Berkelanjutan, dan Teguh Memegang Nilai Budaya Siliwangi pada Tahun 2030."
                        </blockquote>
                        <p class="mt-4 text-sm text-white/50 font-light leading-relaxed">
                            Visi ini menjadi arah pembangunan desa kami dalam mengoptimalkan potensi bumi, memberdayakan sumber daya manusia, dan menciptakan tata kelola pemerintahan yang bersih dan akuntabel.
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
                        @foreach([
                        'Meningkatkan produktivitas pertanian melalui modernisasi alat ramah lingkungan.',
                        'Mendorong pertumbuhan UMKM desa melalui program digitalisasi pemasaran.',
                        'Melestarikan kesenian Sunda dan tradisi Ruwatan Bumi.',
                        'Menyelenggarakan pelayanan administrasi desa yang cepat dan digital.',
                        'Meningkatkan kualitas infrastruktur jalan, air bersih, dan fasilitas umum desa.',
                        ] as $i => $misi)
                        <li class="flex items-start gap-3">
                            <span class="flex-shrink-0 w-6 h-6 rounded bg-forest-800 text-white flex items-center justify-center font-bold text-[10px] mt-0.5">{{ $i + 1 }}</span>
                            <span class="text-sm text-stone-700 font-light leading-relaxed">{{ $misi }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════════
             STRUKTUR ORGANISASI — DINAMIS (admin)
        ══════════════════════════════════════════════════════════ --}}
        @if(isset($struktur) && $struktur->isNotEmpty())
        @php
        $kepalaDesa = $struktur->first();
        $jajaranDesa = $struktur->slice(1);
        @endphp
        <div class="py-16 border-b border-stone-100 reveal-on-scroll delay-300">
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
                @foreach($jajaranDesa as $anggota)
                <div class="group card-village p-5 text-center">
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
        @endif

        {{-- ══════════════════════════════════════════════════════════
             PETA LOKASI
        ══════════════════════════════════════════════════════════ --}}
        <div class="py-16 reveal-on-scroll">
            <div class="text-center mb-10">
                <span class="section-label">Peta Wilayah</span>
                <h2 class="font-display font-extrabold text-2xl sm:text-3xl text-forest-900 mt-3">Lokasi Kantor Desa</h2>
                <div class="section-divider"></div>
            </div>

            <div class="bg-white border border-stone-200 rounded-2xl p-3 shadow-sm max-w-4xl mx-auto">
                <div class="h-80 sm:h-[420px] rounded-xl overflow-hidden">
                    <iframe
                        src="{{ !empty($mapsUrl) ? $mapsUrl : 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.262529813204!2d107.6761505!3d-6.6124570!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6923c6db1dfea3%3A0xc0f3970f1ff4dff9!2sKantor%20Desa%20Jambelaer!5e0!3m2!1sid!2sid!4v1720894000000!5m2!1sid!2sid' }}"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                <div class="flex items-center gap-3 px-3 pt-3 pb-1">
                    <i data-lucide="map-pin" class="w-4 h-4 text-forest-600 flex-shrink-0"></i>
                    <span class="text-xs text-stone-500 font-light">Jl. Raya Jambelaer, Kecamatan Dawuan, Kabupaten Subang, Jawa Barat 41270</span>
                    <a href="https://maps.google.com/?q=Kantor+Desa+Jambelaer" target="_blank" class="ml-auto text-[11px] text-forest-700 font-semibold hover:text-forest-500 whitespace-nowrap flex items-center gap-1">
                        Buka Maps <i data-lucide="external-link" class="w-3 h-3"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection