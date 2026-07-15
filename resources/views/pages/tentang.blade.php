@extends('layouts.app')

@section('title', 'Tentang Kami')
@section('meta_desc', 'Kenali lebih dekat Desa Jambelaer – sejarah, profil, visi & misi, serta sambutan hangat kepala desa Kecamatan Dawuan, Kabupaten Subang.')

@section('content')
<div class="pt-28 pb-24 bg-white/40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-16 reveal-on-scroll">
            <span class="text-xs font-bold tracking-widest uppercase text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full">Tentang Kami</span>
            <h1 class="font-display font-extrabold text-3xl sm:text-4xl text-emerald-950 mt-3">Mengenal Lebih Dekat Desa Jambelaer</h1>
            <div class="w-16 h-1 bg-gradient-to-r from-emerald-800 to-amber-600 mx-auto mt-4 rounded-full"></div>
        </div>

        <!-- Sambutan Kepala Desa -->
        <div class="grid lg:grid-cols-12 gap-12 items-center mb-20 reveal-on-scroll">
            <!-- Photo -->
            <div class="lg:col-span-5 flex justify-center">
                <div class="relative group">
                    <div class="absolute inset-0 bg-gradient-to-tr from-emerald-800 to-amber-600 rounded-3xl transform rotate-3 scale-95 group-hover:rotate-1 group-hover:scale-100 transition-all duration-500 -z-10"></div>
                    <div class="absolute -inset-1 rounded-3xl bg-white border border-slate-100 shadow-sm -z-10"></div>
                    <img src="{{ $settings['kades_foto']->value ?? 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=600&h=600&q=80' }}"
                        alt="Kepala Desa Jambelaer"
                        class="w-72 h-72 sm:w-80 sm:h-80 object-cover rounded-2xl shadow-md border-4 border-white transition-all duration-500">
                    <div class="absolute bottom-4 left-4 right-4 bg-emerald-950/90 backdrop-blur-sm rounded-xl p-4 text-white text-center">
                        <span class="font-display font-bold text-sm block">{{ $settings['kades_nama']->value ?? 'Bapak Dedi Suherman, S.E.' }}</span>
                        <span class="text-xs font-light tracking-wider uppercase text-emerald-300 block">{{ $settings['kades_jabatan']->value ?? 'Kepala Desa Jambelaer' }}</span>
                    </div>
                </div>
            </div>

            <!-- Text -->
            <div class="lg:col-span-7 space-y-5">
                <h2 class="font-display font-bold text-2xl text-emerald-950">Sambutan Hangat Kepala Desa</h2>
                <p class="text-slate-600 leading-relaxed font-light">
                    "{{ $settings['kades_sambutan_1']->value ?? '' }}"
                </p>
                <p class="text-slate-600 leading-relaxed font-light">
                    "{{ $settings['kades_sambutan_2']->value ?? '' }}"
                </p>
                <div class="flex items-center space-x-3 text-emerald-800 font-semibold text-sm">
                    <i data-lucide="check-circle" class="w-5 h-5 flex-shrink-0"></i>
                    <span>{{ $settings['kades_motto']->value ?? 'Melayani dengan Amanah, Terbuka, dan Transparan.' }}</span>
                </div>
            </div>
        </div>

        <!-- Informasi Desa -->
        <div class="grid md:grid-cols-3 gap-6 mb-20 reveal-on-scroll delay-100">
            <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-800 mb-4">
                    <i data-lucide="map-pin" class="w-5 h-5"></i>
                </div>
                <h3 class="font-display font-bold text-base text-emerald-950 mb-2">Letak Geografis</h3>
                <p class="text-sm text-slate-500 font-light leading-relaxed">
                    {{ $settings['tentang_geo']->value ?? 'Desa Jambelaer terletak di Kecamatan Dawuan, Kabupaten Subang, Provinsi Jawa Barat.' }}
                </p>
            </div>
            <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-800 mb-4">
                    <i data-lucide="tractor" class="w-5 h-5"></i>
                </div>
                <h3 class="font-display font-bold text-base text-emerald-950 mb-2">Potensi Utama</h3>
                <p class="text-sm text-slate-500 font-light leading-relaxed">
                    {{ $settings['tentang_potensi']->value ?? 'Lahan persawahan yang produktif menjadi tulang punggung perekonomian desa bersama industri UMKM rumahan dan kerajinan bambu.' }}
                </p>
            </div>
            <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-800 mb-4">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </div>
                <h3 class="font-display font-bold text-base text-emerald-950 mb-2">Administrasi</h3>
                <p class="text-sm text-slate-500 font-light leading-relaxed">
                    {{ $settings['tentang_admin']->value ?? 'Salah satu dari 10 desa di bawah Kecamatan Dawuan dengan pemerintahan yang aktif dan transparan.' }}
                </p>
            </div>
        </div>

        <!-- Visi & Misi Tab -->
        <div class="max-w-4xl mx-auto bg-white border border-slate-100 rounded-3xl p-6 sm:p-10 shadow-sm reveal-on-scroll delay-200">
            <!-- Tab Handles -->
            <div class="flex border-b border-slate-100 mb-8">
                <button id="btn-visi"
                    class="flex-1 pb-4 font-display font-bold text-lg text-emerald-900 border-b-2 border-emerald-900 focus:outline-none transition-all duration-300">
                    Visi Desa
                </button>
                <button id="btn-misi"
                    class="flex-1 pb-4 font-display font-bold text-lg text-slate-400 border-b-2 border-transparent focus:outline-none hover:text-slate-600 transition-all duration-300">
                    Misi Desa
                </button>
            </div>

            <!-- Visi -->
            <div id="content-visi">
                <blockquote class="border-l-4 border-amber-600 pl-4 py-2 text-slate-700 italic font-medium text-lg leading-relaxed">
                    "{{ $settings['visi_text']->value ?? 'Mewujudkan Desa Jambelaer yang Mandiri, Sejahtera, Berbasis Pertanian Berkelanjutan, dan Teguh Memegang Nilai Budaya Siliwangi pada Tahun 2030.' }}"
                </blockquote>
                <p class="text-slate-500 font-light mt-4 leading-relaxed text-sm">
                    {{ $settings['visi_desc']->value ?? 'Visi ini menjadi arah pembangunan desa kami dalam mengoptimalkan potensi bumi, memberdayakan sumber daya manusia, dan menciptakan tata kelola pemerintahan desa yang bersih dan akuntabel.' }}
                </p>
            </div>

            <!-- Misi -->
            <div id="content-misi" class="hidden">
                <ul class="space-y-4">
                    @php
                    $misiItems = array_filter(explode("\n", str_replace("\r", "", $settings['misi_list']->value ?? 'Meningkatkan produktivitas pertanian melalui modernisasi alat ramah lingkungan dan pendampingan intensif bagi kelompok tani.' . "\n" . 'Mendorong pertumbuhan UMKM desa melalui program digitalisasi pemasaran dan penyediaan akses permodalan bergulir.' . "\n" . 'Melestarikan kesenian daerah Sunda dan tradisi Ruwatan Bumi sebagai benteng identitas dan daya tarik pariwisata budaya desa.' . "\n" . 'Menyelenggarakan pelayanan administrasi desa yang cepat, ramah, digital, tanpa diskriminasi melalui inovasi e-Office Desa.')));
                    @endphp
                    @foreach($misiItems as $i => $misi)
                    <li class="flex items-start">
                        <span class="flex-shrink-0 w-6 h-6 rounded-full bg-emerald-50 text-emerald-800 flex items-center justify-center font-bold text-xs mr-3 mt-1">{{ $i + 1 }}</span>
                        <span class="text-slate-600 font-light text-sm sm:text-base">{{ $misi }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- ═══════════════════════════════════════════════════════════ -->
        <!-- Struktur Organisasi Desa                                    -->
        <!-- ═══════════════════════════════════════════════════════════ -->
        @if(isset($struktur) && $struktur->isNotEmpty())
        @php
        $kepalaDesa = $struktur->first();
        $jajaranDesa = $struktur->slice(1);
        @endphp
        <div class="mt-20 reveal-on-scroll delay-300">
            <!-- Section Header -->
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="text-xs font-bold tracking-widest uppercase text-amber-700 bg-amber-50 px-3 py-1 rounded-full">Perangkat Desa</span>
                <h2 class="font-display font-extrabold text-2xl sm:text-3xl text-emerald-950 mt-3">Struktur Organisasi Desa</h2>
                <div class="w-16 h-1 bg-gradient-to-r from-emerald-800 to-amber-600 mx-auto mt-4 rounded-full"></div>
                <p class="text-slate-500 font-light mt-4 text-sm sm:text-base">
                    Mengenal para perangkat desa yang berdedikasi melayani masyarakat Desa Jambelaer.
                </p>
            </div>

            <!-- Kepala Desa – Kartu Tunggal di Tengah Atas -->
            <div class="flex flex-col items-center mb-2">
                <div class="group flex flex-col items-center text-center bg-white border-2 border-emerald-100 rounded-2xl p-7 sm:p-8 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 w-56 sm:w-64 relative">
                    <!-- Foto -->
                    <div class="relative mb-4 mt-2">
                        <div class="absolute inset-0 rounded-full bg-gradient-to-br from-emerald-400 to-amber-500 opacity-0 group-hover:opacity-20 transition-opacity duration-300 blur-sm scale-110"></div>
                        <img src="{{ $kepalaDesa->foto ? asset($kepalaDesa->foto) : 'https://ui-avatars.com/api/?name='.urlencode($kepalaDesa->nama).'&background=065f46&color=fff&size=200' }}"
                            alt="{{ $kepalaDesa->nama }}"
                            class="w-28 h-28 sm:w-32 sm:h-32 rounded-full object-cover border-4 border-white shadow-lg ring-2 ring-emerald-200 group-hover:ring-emerald-400 transition-all duration-300">
                    </div>
                    <!-- Nama -->
                    <h3 class="font-display font-extrabold text-emerald-950 text-base sm:text-lg leading-tight mb-1">
                        {{ $kepalaDesa->nama }}
                    </h3>
                    <!-- Jabatan -->
                    <span class="inline-block text-xs font-semibold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full mt-1 leading-snug border border-emerald-100">
                        {{ $kepalaDesa->jabatan }}
                    </span>
                </div>

                @if($jajaranDesa->isNotEmpty())
                <!-- Garis konektor -->
                <div class="flex flex-col items-center">
                    <div class="w-0.5 h-6 bg-emerald-200"></div>
                    <div class="w-0.5 h-px bg-emerald-200"></div>
                </div>
                @endif
            </div>

            @if($jajaranDesa->isNotEmpty())
            <!-- Garis horizontal konektor -->
            <div class="flex justify-center mb-2">
                <div class="h-px bg-emerald-200" style="width: min(80%, 640px);"></div>
            </div>
            <!-- Titik-titik konektor ke bawah -->
            <div class="flex justify-center gap-0 mb-0">
                @foreach($jajaranDesa as $j)
                <div class="flex-1 flex flex-col items-center" style="max-width: {{ max(80, intval(640 / max(1, $jajaranDesa->count()))) }}px;">
                    <div class="w-0.5 h-5 bg-emerald-200"></div>
                </div>
                @endforeach
            </div>

            <!-- Grid Jajaran -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5 sm:gap-6">
                @foreach($jajaranDesa as $anggota)
                <div class="group flex flex-col items-center text-center bg-white border border-slate-100 rounded-2xl p-5 sm:p-6 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <!-- Foto -->
                    <div class="relative mb-4">
                        <div class="absolute inset-0 rounded-full bg-gradient-to-br from-emerald-400 to-amber-500 opacity-0 group-hover:opacity-20 transition-opacity duration-300 blur-sm scale-110"></div>
                        <img src="{{ $anggota->foto ? asset($anggota->foto) : 'https://ui-avatars.com/api/?name='.urlencode($anggota->nama).'&background=065f46&color=fff&size=200' }}"
                            alt="{{ $anggota->nama }}"
                            class="w-20 h-20 sm:w-24 sm:h-24 rounded-full object-cover border-4 border-white shadow-md ring-2 ring-emerald-100 group-hover:ring-emerald-300 transition-all duration-300">
                    </div>
                    <!-- Nama -->
                    <h3 class="font-display font-bold text-emerald-950 text-sm sm:text-base leading-tight mb-1">
                        {{ $anggota->nama }}
                    </h3>
                    <!-- Jabatan -->
                    <span class="inline-block text-xs font-medium text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full mt-1 leading-snug">
                        {{ $anggota->jabatan }}
                    </span>
                </div>
                @endforeach
            </div>
            @endif

        </div>
        @endif

        <!-- ═══════════════════════════════════════════════════════════ -->
        <!-- Lokasi Kantor Desa (Maps)                                   -->
        <!-- ═══════════════════════════════════════════════════════════ -->
        <div class="mt-20 reveal-on-scroll delay-300">
            <!-- Section Header -->
            <div class="text-center max-w-2xl mx-auto mb-10">
                <span class="text-xs font-bold tracking-widest uppercase text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full">Peta Wilayah</span>
                <h2 class="font-display font-extrabold text-2xl sm:text-3xl text-emerald-950 mt-3">Lokasi Kantor Desa</h2>
                <div class="w-16 h-1 bg-gradient-to-r from-emerald-800 to-amber-600 mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="max-w-4xl mx-auto bg-white border border-slate-100 rounded-3xl p-4 shadow-sm">
                <div class="h-80 sm:h-[400px] rounded-2xl overflow-hidden border border-slate-100 shadow-inner">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.262529813204!2d107.6761755!3d-6.612457!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6923c6db1dfea3%3A0xc0f3970f1ff4dff9!2sKantor%20Desa%20Jambelaer!5e0!3m2!1sid!2sid!4v1720894000000!5m2!1sid!2sid"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>


    </div>
</div>

@endsection

@push('scripts')
<script>
    const btnVisi = document.getElementById('btn-visi');
    const btnMisi = document.getElementById('btn-misi');
    const cVisi = document.getElementById('content-visi');
    const cMisi = document.getElementById('content-misi');

    btnVisi.addEventListener('click', () => {
        btnVisi.classList.add('text-emerald-900', 'border-emerald-900');
        btnVisi.classList.remove('text-slate-400', 'border-transparent');
        btnMisi.classList.add('text-slate-400', 'border-transparent');
        btnMisi.classList.remove('text-emerald-900', 'border-emerald-900');
        cVisi.classList.remove('hidden');
        cMisi.classList.add('hidden');
    });

    btnMisi.addEventListener('click', () => {
        btnMisi.classList.add('text-emerald-900', 'border-emerald-900');
        btnMisi.classList.remove('text-slate-400', 'border-transparent');
        btnVisi.classList.add('text-slate-400', 'border-transparent');
        btnVisi.classList.remove('text-emerald-900', 'border-emerald-900');
        cMisi.classList.remove('hidden');
        cVisi.classList.add('hidden');
    });
</script>
@endpush