@extends('layouts.app')

@section('title', 'Kontak Desa Jambelaer | Hubungi Pemerintah Desa')
@section('meta_desc', 'Hubungi Kantor Desa Jambelaer, Kecamatan Dawuan, Kabupaten Subang. Kirim pertanyaan, laporan, atau permintaan layanan publik melalui formulir kontak resmi desa.')

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    { "@type": "ListItem", "position": 1, "name": "Beranda", "item": "{{ config('app.url') }}" },
    { "@type": "ListItem", "position": 2, "name": "Kontak Desa Jambelaer", "item": "{{ config('app.url') }}/kontak" }
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
        <span class="text-forest-800 font-semibold">Layanan & Kontak</span>
    </nav>
</div>

<div class="relative h-60 sm:h-72 lg:h-80 overflow-hidden bg-forest-900 rounded-[28px] sm:rounded-[32px] mx-3 sm:mx-5 lg:mx-6 shadow-sm">
    <img src="{{ asset('uploads/img/beranda.jpeg') }}"
        alt="Kantor Desa Jambelaer" class="w-full h-full object-cover opacity-60">
    <div class="absolute inset-0 bg-gradient-to-t from-forest-950/90 via-forest-900/50 to-forest-900/20"></div>
    <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
        <span class="section-label !bg-white/10 !text-sand-300 !border-white/20">Pelayanan Terpadu</span>
        <h1 class="font-display font-extrabold text-3xl sm:text-4xl lg:text-5xl text-white mt-3">Layanan & Kontak Desa</h1>
        <p class="text-xs sm:text-sm text-white/70 mt-2 font-light max-w-md">Pilih salah satu layanan masyarakat Desa Jambelaer secara digital dan terpadu</p>
    </div>
</div>

<div class="bg-white pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- ══════════════════════════════════════════════════════════
             KONTAK INFO STRIP
        ══════════════════════════════════════════════════════════ --}}
        <div class="py-10 border-b border-stone-100">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="flex items-start gap-4 p-4 sm:p-5 bg-forest-50 border border-forest-100 rounded-xl">
                    <div class="w-10 h-10 rounded-lg bg-forest-800 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="map-pin" class="w-4 h-4 text-sand-300"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold tracking-widest uppercase text-forest-600 block">Alamat</span>
                        <span class="text-sm text-stone-700 font-medium leading-snug mt-1 block">{{ \App\Models\Pengaturan::get('desa_alamat', 'Jl. Raya Jambelaer, Dawuan, Subang 41270') }}</span>
                    </div>
                </div>
                <div class="flex items-start gap-4 p-4 sm:p-5 bg-sand-50 border border-sand-100 rounded-xl">
                    <div class="w-10 h-10 rounded-lg bg-sand-500 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="phone" class="w-4 h-4 text-white"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold tracking-widest uppercase text-sand-600 block">Telepon</span>
                        <span class="text-sm text-stone-700 font-medium leading-snug mt-1 block">{{ \App\Models\Pengaturan::get('desa_telepon', '081324768193') }}</span>
                    </div>
                </div>
                <div class="flex items-start gap-4 p-4 sm:p-5 bg-stone-50 border border-stone-100 rounded-xl">
                    <div class="w-10 h-10 rounded-lg bg-stone-600 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="mail" class="w-4 h-4 text-white"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold tracking-widest uppercase text-stone-500 block">Email</span>
                        <span class="text-sm text-stone-700 font-medium leading-snug mt-1 block break-all">{{ \App\Models\Pengaturan::get('desa_email', 'info@jambelaer-subang.desa.id') }}</span>
                    </div>
                </div>
                <div class="flex items-start gap-4 p-4 sm:p-5 bg-sky-50 border border-sky-100 rounded-xl">
                    <div class="w-10 h-10 rounded-lg bg-sky-600 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="clock" class="w-4 h-4 text-white"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold tracking-widest uppercase text-sky-600 block">Jam Layanan</span>
                        <span class="text-sm text-stone-700 font-medium leading-snug mt-1 block">{{ \App\Models\Pengaturan::get('desa_jam_buka', 'Senin – Jumat: 08:00 – 15:30 WIB') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════════
             4 SERVICE CARDS — 4 Modul Layanan Terpisah
        ══════════════════════════════════════════════════════════ --}}
        <div id="layanan-hub" class="py-12 border-b border-stone-100 reveal-on-scroll">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <span class="section-label">Pilihan Layanan Digital</span>
                <h2 class="font-display font-extrabold text-2xl sm:text-3xl text-forest-900 mt-2.5">Pilih Kategori Layanan Masyarakat</h2>
                <p class="mt-2 text-stone-500 font-light text-sm">Klik salah satu jenis layanan di bawah untuk membuka formulir mandiri dan persyaratan yang sesuai.</p>
                <div class="section-divider"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                {{-- CARD 1: Pengajuan Pembuatan Surat --}}
                <a href="{{ route('pengajuan.surat') }}" class="card-village p-6 flex flex-col justify-between hover:border-violet-500 hover:shadow-lg group transition-all duration-300 bg-white">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-violet-50 text-violet-700 flex items-center justify-center mb-4 group-hover:bg-violet-700 group-hover:text-white transition-all shadow-xs">
                            <i data-lucide="file-text" class="w-6 h-6"></i>
                        </div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-violet-700 bg-violet-50 px-2 py-0.5 rounded-md">Administrasi</span>
                        <h3 class="font-display font-bold text-base text-forest-900 mt-2 mb-1.5 group-hover:text-violet-800 transition-colors">Pengajuan Surat</h3>
                        <p class="text-xs text-stone-500 font-light leading-relaxed">
                            Permohonan surat keterangan domisili, usaha (SKU), SKTM, belum menikah, ahli waris, dan surat pernyataan.
                        </p>
                    </div>
                    <div class="pt-5 mt-4 border-t border-stone-100 flex items-center justify-between text-xs font-bold text-violet-700 group-hover:text-violet-900">
                        <span>Buka Formulir</span>
                        <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </a>

                {{-- CARD 2: Pengaduan Masyarakat --}}
                <a href="{{ route('pengaduan.create') }}" class="card-village p-6 flex flex-col justify-between hover:border-rose-500 hover:shadow-lg group transition-all duration-300 bg-white">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-700 flex items-center justify-center mb-4 group-hover:bg-rose-600 group-hover:text-white transition-all shadow-xs">
                            <i data-lucide="alert-triangle" class="w-6 h-6"></i>
                        </div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-rose-700 bg-rose-50 px-2 py-0.5 rounded-md">Aspirasi & Laporan</span>
                        <h3 class="font-display font-bold text-base text-forest-900 mt-2 mb-1.5 group-hover:text-rose-700 transition-colors">Pengaduan Masyarakat</h3>
                        <p class="text-xs text-stone-500 font-light leading-relaxed">
                            Sampaikan laporan fasilitas publik, lingkungan, atau pelayanan desa beserta foto bukti pendukung.
                        </p>
                    </div>
                    <div class="pt-5 mt-4 border-t border-stone-100 flex items-center justify-between text-xs font-bold text-rose-700 group-hover:text-rose-900">
                        <span>Kirim Pengaduan</span>
                        <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </a>

                {{-- CARD 3: Pertanyaan Umum --}}
                <a href="{{ route('pertanyaan-umum.create') }}" class="card-village p-6 flex flex-col justify-between hover:border-sky-500 hover:shadow-lg group transition-all duration-300 bg-white">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-700 flex items-center justify-center mb-4 group-hover:bg-sky-600 group-hover:text-white transition-all shadow-xs">
                            <i data-lucide="help-circle" class="w-6 h-6"></i>
                        </div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-sky-700 bg-sky-50 px-2 py-0.5 rounded-md">Informasi Publik</span>
                        <h3 class="font-display font-bold text-base text-forest-900 mt-2 mb-1.5 group-hover:text-sky-700 transition-colors">Pertanyaan Umum</h3>
                        <p class="text-xs text-stone-500 font-light leading-relaxed">
                            Tanyakan seputar informasi administrasi, program desa, atau jam pelayanan secara langsung tanpa berkas.
                        </p>
                    </div>
                    <div class="pt-5 mt-4 border-t border-stone-100 flex items-center justify-between text-xs font-bold text-sky-700 group-hover:text-sky-900">
                        <span>Tulis Pertanyaan</span>
                        <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </a>

                {{-- CARD 4: Pendaftaran UMKM --}}
                <a href="{{ route('pendaftaran-umkm.create') }}" class="card-village p-6 flex flex-col justify-between hover:border-emerald-500 hover:shadow-lg group transition-all duration-300 bg-white">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center mb-4 group-hover:bg-emerald-700 group-hover:text-white transition-all shadow-xs">
                            <i data-lucide="store" class="w-6 h-6"></i>
                        </div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md">Promosi Usaha</span>
                        <h3 class="font-display font-bold text-base text-forest-900 mt-2 mb-1.5 group-hover:text-emerald-700 transition-colors">Pendaftaran UMKM</h3>
                        <p class="text-xs text-stone-500 font-light leading-relaxed">
                            Daftarkan usaha warga Desa Jambelaer untuk dipromosikan ke katalog produk UMKM resmi website desa.
                        </p>
                    </div>
                    <div class="pt-5 mt-4 border-t border-stone-100 flex items-center justify-between text-xs font-bold text-emerald-700 group-hover:text-emerald-900">
                        <span>Daftarkan Usaha</span>
                        <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </a>
            </div>
        </div>

        {{-- Hidden Anchor Targets for Footer & External links --}}
        <div id="form-pertanyaan" class="scroll-mt-24"></div>
        <div id="form-pengaduan" class="scroll-mt-24"></div>
        <div id="form-umkm" class="scroll-mt-24"></div>

        {{-- ══════════════════════════════════════════════════════════
             FORM + INFO PANEL
        ══════════════════════════════════════════════════════════ --}}
        <div id="form-section" class="py-14 grid lg:grid-cols-12 gap-10 items-start reveal-on-scroll scroll-mt-20">

            {{-- Left: Info Panel --}}
            <div class="lg:col-span-5 space-y-5">
                {{-- Office Info Card --}}
                <div class="bg-forest-900 text-white rounded-xl p-7">
                    <h2 class="font-display font-bold text-lg text-white mb-5 pb-4 border-b border-white/10">
                        Kantor Desa Jambelaer
                    </h2>
                    <div class="space-y-5">
                        <div class="flex items-start gap-4">
                            <div class="w-9 h-9 rounded-lg bg-white/8 border border-white/10 flex items-center justify-center flex-shrink-0">
                                <i data-lucide="map-pin" class="w-4 h-4 text-sand-400"></i>
                            </div>
                            <div>
                                <span class="text-[10px] text-sand-500 font-bold tracking-widest uppercase block">Alamat Lengkap</span>
                                <span class="text-sm text-white/70 font-light mt-1 block leading-relaxed">{{ \App\Models\Pengaturan::get('desa_alamat', 'Jl. Raya Jambelaer No. 12, Kecamatan Dawuan, Kabupaten Subang, Jawa Barat 41270') }}</span>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-9 h-9 rounded-lg bg-white/8 border border-white/10 flex items-center justify-center flex-shrink-0">
                                <i data-lucide="phone" class="w-4 h-4 text-sand-400"></i>
                            </div>
                            <div>
                                <span class="text-[10px] text-sand-500 font-bold tracking-widest uppercase block">Telepon / Fax</span>
                                <span class="text-sm text-white/70 font-light mt-1 block">{{ \App\Models\Pengaturan::get('desa_telepon', '081324768193') }}</span>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-9 h-9 rounded-lg bg-white/8 border border-white/10 flex items-center justify-center flex-shrink-0">
                                <i data-lucide="mail" class="w-4 h-4 text-sand-400"></i>
                            </div>
                            <div>
                                <span class="text-[10px] text-sand-500 font-bold tracking-widest uppercase block">Email Resmi</span>
                                <span class="text-sm text-white/70 font-light mt-1 block">{{ \App\Models\Pengaturan::get('desa_email', 'info@jambelaer-subang.desa.id') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Jam Layanan Card --}}
                <div class="bg-white border border-stone-200 rounded-xl p-6">
                    <h3 class="font-display font-bold text-sm text-forest-900 mb-4 flex items-center gap-2">
                        <i data-lucide="calendar-clock" class="w-4 h-4 text-sand-500"></i>
                        Jam Operasional Layanan
                    </h3>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between py-2 border-b border-stone-50">
                            <span class="text-sm text-stone-600 font-medium">Senin – Kamis</span>
                            <span class="text-sm font-semibold text-forest-800 bg-forest-50 px-3 py-1 rounded-full text-xs">08.00 – 15.30 WIB</span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-stone-50">
                            <span class="text-sm text-stone-600 font-medium">Jumat</span>
                            <span class="text-sm font-semibold text-forest-800 bg-forest-50 px-3 py-1 rounded-full text-xs">08.00 – 11.30 WIB</span>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <span class="text-sm text-stone-400 font-medium">Sabtu – Minggu</span>
                            <span class="text-xs font-semibold text-red-600 bg-red-50 px-3 py-1 rounded-full">Libur</span>
                        </div>
                    </div>
                </div>

                {{-- Sosmed Card --}}
                <div class="bg-sand-50 border border-sand-100 rounded-xl p-6">
                    <h3 class="font-display font-bold text-sm text-forest-900 mb-4">Media Sosial Resmi Desa</h3>
                    @php
                    $kIg = \App\Models\Pengaturan::get('sosmed_instagram', '');
                    $kYt = \App\Models\Pengaturan::get('sosmed_youtube', '');
                    $kTt = \App\Models\Pengaturan::get('sosmed_tiktok', '');
                    @endphp
                    <div class="flex flex-wrap gap-2">
                        @if($kIg)
                        <a href="{{ str_starts_with($kIg, 'http') ? $kIg : 'https://'.$kIg }}" target="_blank" rel="noopener"
                            class="flex items-center gap-2 px-3 py-2 rounded-lg bg-white border border-stone-200 text-sm text-stone-700 hover:border-pink-300 hover:text-pink-600 transition-all">
                            <i data-lucide="instagram" class="w-4 h-4"></i> Instagram
                        </a>
                        @endif
                        @if($kYt)
                        <a href="{{ str_starts_with($kYt, 'http') ? $kYt : 'https://'.$kYt }}" target="_blank" rel="noopener"
                            class="flex items-center gap-2 px-3 py-2 rounded-lg bg-white border border-stone-200 text-sm text-stone-700 hover:border-red-300 hover:text-red-600 transition-all">
                            <i data-lucide="youtube" class="w-4 h-4"></i> YouTube
                        </a>
                        @endif
                        @if(!$kIg && !$kYt && !$kTt)
                        <p class="text-xs text-stone-400 font-light">Media sosial belum dikonfigurasi.</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Right: Form / Auth Required --}}
            <div class="lg:col-span-7" id="form-section">
                @guest
                {{-- State Saat Masyarakat Belum Login: TIDAK Menampilkan Form Input --}}
                <div class="bg-white border border-stone-200 rounded-2xl p-7 sm:p-10 shadow-sm text-center">
                    <div class="w-16 h-16 rounded-2xl bg-forest-50 border border-forest-100 text-forest-800 flex items-center justify-center mx-auto mb-5 shadow-xs">
                        <i data-lucide="lock" class="w-8 h-8"></i>
                    </div>

                    <span class="text-[10px] font-bold tracking-widest uppercase text-amber-700 bg-amber-50 border border-amber-200 px-3 py-1 rounded-full inline-block mb-3">
                        Autentikasi Diperlukan
                    </span>

                    <h2 class="font-display font-extrabold text-2xl sm:text-3xl text-forest-950 mb-3">
                        Masuk untuk Mengakses Layanan
                    </h2>

                    <p class="text-sm text-stone-600 max-w-lg mx-auto font-light leading-relaxed mb-8">
                        Seluruh pelayanan masyarakat di Desa Jambelaer terhubung langsung dengan sistem website desa. Untuk mengajukan permohonan layanan dan melacak proses penanganannya secara transparan, silakan masuk ke akun Anda atau daftarkan akun baru terlebih dahulu.
                    </p>

                    <div class="flex flex-col sm:flex-row items-center justify-center gap-3.5 mb-10 max-w-md mx-auto">
                        <a href="{{ route('login') }}" class="w-full sm:w-auto btn-primary justify-center text-xs py-3 px-6 gap-2 shadow-sm font-bold">
                            <i data-lucide="log-in" class="w-4 h-4"></i>
                            Masuk Akun (Login)
                        </a>
                        <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-white border border-stone-300 text-xs font-bold text-stone-700 hover:bg-stone-50 hover:border-forest-600 transition-all shadow-xs">
                            <i data-lucide="user-plus" class="w-4 h-4 text-forest-700"></i>
                            Daftar Akun Warga
                        </a>
                    </div>

                    {{-- Panduan Layanan yang Tersedia --}}
                    <div class="border-t border-stone-100 pt-8 text-left">
                        <p class="text-[11px] font-bold tracking-wider uppercase text-stone-400 mb-4 text-center">
                            Layanan yang Dapat Diajukan Setelah Masuk:
                        </p>
                        <div class="grid sm:grid-cols-3 gap-3.5">
                            <div class="p-3.5 rounded-xl bg-stone-50/70 border border-stone-200/80 flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-violet-100 text-violet-800 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <i data-lucide="file-text" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-stone-800">Pengajuan Surat</h4>
                                    <p class="text-[11px] text-stone-500 font-light mt-0.5">Permohonan surat keterangan domisili, usaha, SKTM, dll.</p>
                                </div>
                            </div>
                            <div class="p-3.5 rounded-xl bg-stone-50/70 border border-stone-200/80 flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-800 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <i data-lucide="help-circle" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-stone-800">Pertanyaan Umum</h4>
                                    <p class="text-[11px] text-stone-500 font-light mt-0.5">Konsultasi dan informasi seputar administrasi desa.</p>
                                </div>
                            </div>
                            <div class="p-3.5 rounded-xl bg-stone-50/70 border border-stone-200/80 flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-800 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <i data-lucide="alert-triangle" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-stone-800">Pengaduan Masyarakat</h4>
                                    <p class="text-[11px] text-stone-500 font-light mt-0.5">Aspirasi warga dan keluhan fasilitas umum (+ bukti foto).</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                {{-- State Saat Masyarakat Sudah Login: Menampilkan Formulir Pengajuan --}}
                <div class="bg-white border border-stone-200 rounded-xl p-7 sm:p-9 shadow-sm">
                    <h2 class="font-display font-bold text-xl text-forest-900 mb-1">Kirim Pengajuan Layanan</h2>
                    <p class="text-sm text-stone-400 font-light mb-5">Isi formulir di bawah ini untuk mengajukan permohonan layanan desa secara resmi.</p>

                    <div class="mb-6 p-3.5 rounded-xl bg-forest-50 border border-forest-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-xs">
                        <div class="flex items-center gap-2 text-forest-900 font-medium min-w-0">
                            <i data-lucide="user-check" class="w-4 h-4 text-forest-700 flex-shrink-0"></i>
                            <span class="min-w-0 break-all">Mengajukan sebagai: <strong>{{ Auth::user()->name }}</strong> ({{ Auth::user()->email }})</span>
                        </div>
                        <a href="{{ route('pengajuan.saya') }}" class="text-forest-800 hover:text-forest-950 font-bold flex items-center gap-1 flex-shrink-0">
                            Pengajuan Saya <i data-lucide="chevron-right" class="w-3 h-3"></i>
                        </a>
                    </div>

                    {{-- Success Alert --}}
                    @if(session('success'))
                    <div id="contact-success" class="mb-6 p-4 rounded-xl bg-forest-50 border border-forest-200 flex items-start gap-3">
                        <div class="w-7 h-7 rounded-full bg-forest-800 flex items-center justify-center flex-shrink-0 text-white">
                            <i data-lucide="check" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <span class="font-bold text-forest-900 text-sm block">Pesan Berhasil Terkirim!</span>
                            <span class="text-xs text-forest-700/80 font-light mt-0.5 block">{{ session('success') }}</span>
                        </div>
                    </div>
                    @else
                    <div id="contact-success" class="hidden mb-6 p-4 rounded-xl bg-forest-50 border border-forest-200 flex items-start gap-3">
                        <div class="w-7 h-7 rounded-full bg-forest-800 flex items-center justify-center flex-shrink-0 text-white">
                            <i data-lucide="check" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <span class="font-bold text-forest-900 text-sm block">Pesan Berhasil Terkirim!</span>
                            <span class="text-xs text-forest-700/80 font-light mt-0.5 block">Terima kasih atas pesan Anda. Kami akan segera merespons.</span>
                        </div>
                    </div>
                    @endif

                    {{-- Error Alert --}}
                    <div id="contact-error" class="hidden mb-6 p-4 rounded-xl bg-red-50 border border-red-200 flex items-start gap-3">
                        <div class="w-7 h-7 rounded-full bg-red-600 flex items-center justify-center flex-shrink-0 text-white">
                            <i data-lucide="alert-circle" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <span class="font-bold text-red-900 text-sm block">Gagal Mengirim Pesan</span>
                            <ul id="error-list" class="text-xs text-red-700/80 font-light mt-1 list-disc list-inside space-y-1"></ul>
                        </div>
                    </div>

                    <form id="contact-form" method="POST" action="{{ route('kontak.store') }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf

                        {{-- Style umum input --}}
                        <style>
                            .input-village {
                                width: 100%;
                                padding: 14px 16px 6px 16px;
                                border: 1px solid #e7e5e4;
                                border-radius: 8px;
                                font-size: 0.875rem;
                                font-weight: 500;
                                color: #292524;
                                background: #fdfaf5;
                                outline: none;
                                transition: border-color 0.2s, box-shadow 0.2s;
                                appearance: none;
                            }

                            .input-village:focus {
                                border-color: #1a4731;
                                box-shadow: 0 0 0 3px rgba(26, 71, 49, 0.08);
                                background: #ffffff;
                            }

                            .label-float {
                                position: absolute;
                                left: 16px;
                                top: 4px;
                                font-size: 0.65rem;
                                font-weight: 700;
                                letter-spacing: 0.1em;
                                text-transform: uppercase;
                                color: #a8a29e;
                                pointer-events: none;
                            }

                            .input-wrap {
                                position: relative;
                            }

                            /* === Upload Foto Bukti === */
                            .upload-drop-zone {
                                border: 2px dashed #e7e5e4;
                                border-radius: 10px;
                                padding: 20px 16px;
                                background: #fdfaf5;
                                cursor: pointer;
                                transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
                                display: flex;
                                flex-direction: column;
                                align-items: center;
                                gap: 8px;
                                text-align: center;
                            }

                            .upload-drop-zone:hover,
                            .upload-drop-zone.dragover {
                                border-color: #1a4731;
                                background: #f0f7f3;
                                box-shadow: 0 0 0 3px rgba(26, 71, 49, 0.08);
                            }

                            .upload-drop-zone.has-file {
                                border-color: #1a4731;
                                border-style: solid;
                                background: #f0f7f3;
                            }

                            .upload-drop-zone.error {
                                border-color: #dc2626;
                                background: #fef2f2;
                            }

                            .upload-preview {
                                width: 80px;
                                height: 80px;
                                object-fit: cover;
                                border-radius: 8px;
                                border: 1px solid #d6d3d1;
                                display: none;
                            }

                            .upload-error-msg {
                                font-size: 0.72rem;
                                color: #dc2626;
                                font-weight: 600;
                                margin-top: 4px;
                                display: none;
                            }
                        </style>

                        {{-- Jenis Pesan --}}
                        <div class="input-wrap">
                            <label class="label-float">Jenis Pesan</label>
                            <select id="jenis-pesan" name="jenis_pesan" required class="input-village pt-7 cursor-pointer">
                                <option value="">— Pilih Jenis Pesan —</option>
                                <option value="pengajuan_surat">📄 Pengajuan Surat (Buka Formulir)</option>
                                <option value="pertanyaan_umum">💬 Pertanyaan Umum</option>
                                <option value="pengaduan">🚨 Pengaduan Masyarakat</option>
                                <option value="daftar_umkm">🏪 Pendaftaran UMKM</option>
                            </select>
                            <i data-lucide="chevron-down" class="w-4 h-4 absolute right-4 top-5 pointer-events-none text-stone-400"></i>
                        </div>

                        {{-- Nama Lengkap --}}
                        <div class="input-wrap">
                            <label class="label-float" for="f-name">Nama Lengkap</label>
                            <input id="f-name" name="name" type="text" required placeholder="" value="{{ old('name', Auth::user()->name ?? '') }}" class="input-village pt-7">
                        </div>

                        {{-- Input master tersembunyi — satu-satunya yang dikirim ke server --}}
                        <input type="hidden" id="f-wa-master" name="no_whatsapp" value="">

                        {{-- WhatsApp (Pertanyaan Umum) — type=tel, hanya visible saat pertanyaan_umum --}}
                        <div id="field-email" class="hidden input-wrap">
                            <label class="label-float" for="f-email">Nomor WhatsApp</label>
                            <input id="f-email" name="no_whatsapp_tel" type="tel" placeholder="" class="input-village pt-7"
                                oninput="document.getElementById('f-wa-master').value=this.value">
                        </div>

                        {{-- WhatsApp (Pengaduan/UMKM) — type=text --}}
                        <div id="field-whatsapp" class="hidden input-wrap">
                            <label class="label-float" for="f-whatsapp">Nomor WhatsApp</label>
                            <input id="f-whatsapp" name="no_whatsapp_txt" type="text" placeholder="" class="input-village pt-7"
                                oninput="document.getElementById('f-wa-master').value=this.value">
                        </div>

                        {{-- Subjek --}}
                        <div id="field-subject" class="hidden input-wrap">
                            <label id="label-subject" class="label-float" for="f-subject">Subjek Pesan</label>
                            <input id="f-subject" name="subject" type="text" placeholder="" class="input-village pt-7">
                        </div>

                        {{-- Pesan --}}
                        <div id="field-message" class="hidden input-wrap">
                            <label id="label-message" class="label-float" for="f-msg">Isi Pesan</label>
                            <textarea id="f-msg" name="message" rows="4" placeholder="" class="input-village pt-7 resize-none"></textarea>
                        </div>

                        {{-- Upload Foto Bukti (Pengaduan only) --}}
                        <div id="field-foto-bukti" class="hidden">
                            <p class="text-[10px] font-bold tracking-widest uppercase text-stone-400 mb-2">Upload Foto Bukti <span class="text-stone-300 normal-case tracking-normal font-normal">(Opsional)</span></p>
                            <div id="upload-drop-zone" class="upload-drop-zone" onclick="document.getElementById('f-foto-bukti').click()">
                                <img id="upload-preview" class="upload-preview" alt="Preview foto bukti">
                                <div id="upload-placeholder" class="flex flex-col items-center text-center w-full">
                                    <div class="w-10 h-10 rounded-full bg-forest-50 border border-forest-100 flex items-center justify-center mx-auto mb-2">
                                        <i data-lucide="image-plus" class="w-5 h-5 text-forest-600"></i>
                                    </div>
                                    <p class="text-sm font-semibold text-stone-600">Klik atau seret foto ke sini</p>
                                    <p class="text-xs text-stone-400 font-light mt-1">Format: JPG, PNG, WEBP &bull; Maks. 5 MB</p>
                                </div>
                                <div id="upload-file-info" class="hidden flex items-center gap-2 text-sm text-forest-800 font-medium">
                                    <i data-lucide="check-circle" class="w-4 h-4 text-forest-600"></i>
                                    <span id="upload-file-name"></span>
                                    <button type="button" id="upload-remove-btn" onclick="event.stopPropagation(); clearFotoBukti()" class="ml-auto text-xs text-red-500 hover:text-red-700 font-semibold flex items-center gap-1">
                                        <i data-lucide="x" class="w-3 h-3"></i> Hapus
                                    </button>
                                </div>
                            </div>
                            <p id="upload-error-msg" class="upload-error-msg"></p>
                            <input type="file" id="f-foto-bukti" name="foto_bukti" accept="image/jpeg,image/png,image/webp" class="hidden">
                        </div>

                        {{-- ═══ UMKM Registration Fields (daftar_umkm only) ═══ --}}

                        {{-- Banner info UMKM --}}
                        <div id="field-umkm-banner" class="hidden p-4 bg-sand-50 border border-sand-100 rounded-xl flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-sand-500 flex items-center justify-center flex-shrink-0">
                                <i data-lucide="store" class="w-4 h-4 text-white"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-sand-800">Pendaftaran UMKM ke Website Desa</p>
                                <p class="text-xs text-sand-700/70 font-light mt-0.5">Isi data usaha Anda dengan lengkap. Tim desa akan memverifikasi dan menghubungi Anda dalam 3–5 hari kerja sebelum ditampilkan.</p>
                            </div>
                        </div>

                        {{-- 1. INFORMASI PENGELOLA UMKM --}}
                        <div id="field-group-pengelola-umkm" class="hidden space-y-4 pt-2">
                            <div class="flex items-center gap-2 border-b border-stone-200 pb-2">
                                <i data-lucide="store" class="w-4 h-4 text-forest-700"></i>
                                <h4 class="font-display font-bold text-sm text-stone-800">Informasi Pengelola UMKM</h4>
                            </div>

                            <div id="field-nama-umkm" class="input-wrap">
                                <label class="label-float" for="f-nama-umkm">Nama Usaha / UMKM</label>
                                <input id="f-nama-umkm" name="nama_umkm" type="text" placeholder="" class="input-village pt-7">
                            </div>

                            <div class="grid sm:grid-cols-2 gap-4">
                                <div id="field-jenis-produk-umkm" class="input-wrap">
                                    <label class="label-float">Kategori Produk</label>
                                    <select id="f-jenis-produk-umkm" name="jenis_produk_umkm" class="input-village pt-7 cursor-pointer">
                                        <option value="">— Pilih Kategori —</option>
                                        <option value="Makanan">Makanan</option>
                                        <option value="Kerajinan">Kerajinan</option>
                                    </select>
                                    <i data-lucide="chevron-down" class="w-4 h-4 absolute right-4 top-5 pointer-events-none text-stone-400"></i>
                                </div>

                                <div id="field-jam-operasional-umkm" class="input-wrap">
                                    <label class="label-float" for="f-jam-operasional-umkm">Jam Operasional</label>
                                    <input id="f-jam-operasional-umkm" name="jam_operasional_umkm" type="text" placeholder="cth: Senin-Minggu (06:00-17:00)" class="input-village pt-7">
                                </div>
                            </div>

                            <div class="grid sm:grid-cols-2 gap-4">
                                <div id="field-instagram-umkm" class="input-wrap">
                                    <label class="label-float" for="f-instagram-umkm">Instagram (Opsional)</label>
                                    <input id="f-instagram-umkm" name="instagram_umkm" type="text" placeholder="cth: @opak_ibu.ninin" class="input-village pt-7">
                                </div>

                                <div id="field-alamat-umkm" class="input-wrap">
                                    <label class="label-float" for="f-alamat-umkm">Alamat Usaha</label>
                                    <input id="f-alamat-umkm" name="alamat_umkm_daftar" type="text" placeholder="" class="input-village pt-7">
                                </div>
                            </div>
                        </div>

                        {{-- 2. TENTANG PRODUK --}}
                        <div id="field-group-tentang-produk" class="hidden space-y-4 pt-2">
                            <div class="flex items-center gap-2 border-b border-stone-200 pb-2">
                                <h4 class="font-display font-bold text-sm text-stone-800">Tentang Produk</h4>
                            </div>

                            <div id="field-deskripsi-umkm" class="input-wrap">
                                <label class="label-float" for="f-deskripsi-umkm">Cerita Singkat Produk / Usaha</label>
                                <textarea id="f-deskripsi-umkm" name="deskripsi_umkm" rows="3" placeholder="" class="input-village pt-7 resize-none"></textarea>
                            </div>
                        </div>

                        {{-- 3. SPESIFIKASI PRODUK --}}
                        <div id="field-group-spesifikasi-produk" class="hidden space-y-4 pt-2">
                            <div class="flex items-center gap-2 border-b border-stone-200 pb-2">
                                <i data-lucide="list-checks" class="w-4 h-4 text-forest-700"></i>
                                <h4 class="font-display font-bold text-sm text-stone-800">Spesifikasi Produk</h4>
                            </div>

                            <div class="grid sm:grid-cols-2 gap-4">
                                <div id="field-harga-produk-umkm" class="input-wrap">
                                    <label class="label-float" for="f-harga-produk-umkm">Harga Produk</label>
                                    <input id="f-harga-produk-umkm" name="harga_produk_umkm" type="text" placeholder="cth: 12.000 / Bungkus" class="input-village pt-7">
                                </div>

                                <div id="field-isi-produk-umkm" class="input-wrap">
                                    <label class="label-float" for="f-isi-produk-umkm">Isi / Berat Bersih</label>
                                    <input id="f-isi-produk-umkm" name="isi_produk_umkm" type="text" placeholder="cth: 200 gram / bungkus" class="input-village pt-7">
                                </div>
                            </div>

                            <div class="grid sm:grid-cols-2 gap-4">
                                <div id="field-ketersediaan-umkm" class="input-wrap">
                                    <label class="label-float">Ketersediaan Produk</label>
                                    <select id="f-ketersediaan-umkm" name="ketersediaan_umkm" class="input-village pt-7 cursor-pointer">
                                        <option value="Tersedia">Tersedia</option>
                                        <option value="Pre-Order">Pre-Order</option>
                                        <option value="Stok Terbatas">Stok Terbatas</option>
                                    </select>
                                    <i data-lucide="chevron-down" class="w-4 h-4 absolute right-4 top-5 pointer-events-none text-stone-400"></i>
                                </div>

                                <div id="field-sertifikasi-umkm" class="input-wrap">
                                    <label class="label-float" for="f-sertifikasi-umkm">Sertifikasi (Opsional)</label>
                                    <input id="f-sertifikasi-umkm" name="sertifikasi_umkm" type="text" placeholder="cth: Halal / P-IRT / NIB" class="input-village pt-7">
                                </div>
                            </div>
                        </div>

                        {{-- Upload Foto Produk (daftar_umkm only) --}}
                        <div id="field-foto-produk" class="hidden">
                            <p class="text-[10px] font-bold tracking-widest uppercase text-stone-400 mb-2">Foto Produk <span class="text-stone-300 normal-case tracking-normal font-normal">(Opsional, maks. 5 MB)</span></p>
                            <div id="upload-drop-zone-produk" class="upload-drop-zone" onclick="document.getElementById('f-foto-produk').click()">
                                <img id="upload-preview-produk" class="upload-preview" alt="Preview foto produk">
                                <div id="upload-placeholder-produk" class="flex flex-col items-center text-center w-full">
                                    <div class="w-10 h-10 rounded-full bg-sand-50 border border-sand-100 flex items-center justify-center mx-auto mb-2">
                                        <i data-lucide="image-plus" class="w-5 h-5 text-sand-600"></i>
                                    </div>
                                    <p class="text-sm font-semibold text-stone-600">Klik atau seret foto produk ke sini</p>
                                    <p class="text-xs text-stone-400 font-light mt-1">Format: JPG, PNG, WEBP &bull; Maks. 5 MB</p>
                                </div>
                                <div id="upload-file-info-produk" class="hidden flex items-center gap-2 text-sm text-forest-800 font-medium">
                                    <i data-lucide="check-circle" class="w-4 h-4 text-forest-600"></i>
                                    <span id="upload-file-name-produk"></span>
                                    <button type="button" onclick="event.stopPropagation(); clearFotoProduk()" class="ml-auto text-xs text-red-500 hover:text-red-700 font-semibold flex items-center gap-1">
                                        <i data-lucide="x" class="w-3 h-3"></i> Hapus
                                    </button>
                                </div>
                            </div>
                            <p id="upload-error-msg-produk" class="upload-error-msg"></p>
                            <input type="file" id="f-foto-produk" name="foto_produk" accept="image/jpeg,image/png,image/webp" class="hidden">
                        </div>

                        {{-- Upload Sertifikat Halal PDF (daftar_umkm only) --}}
                        <div id="field-sertifikat-halal" class="hidden">
                            <p class="text-[10px] font-bold tracking-widest uppercase text-stone-400 mb-2">Sertifikat Halal <span class="text-stone-300 normal-case tracking-normal font-normal">(PDF, Opsional, maks. 5 MB)</span></p>
                            <div id="upload-drop-zone-halal" class="upload-drop-zone" onclick="document.getElementById('f-sertifikat-halal').click()">
                                <div id="upload-placeholder-halal" class="flex flex-col items-center text-center w-full">
                                    <div class="w-10 h-10 rounded-full bg-emerald-50 border border-emerald-100 flex items-center justify-center mx-auto mb-2">
                                        <i data-lucide="shield-check" class="w-5 h-5 text-emerald-600"></i>
                                    </div>
                                    <p class="text-sm font-semibold text-stone-600">Klik atau seret file PDF ke sini</p>
                                    <p class="text-xs text-stone-400 font-light mt-1">Sertifikat Halal dari MUI / BPJPH &bull; Format: PDF (Maks. 5 MB)</p>
                                </div>
                                <div id="upload-file-info-halal" class="hidden flex items-center gap-2 text-sm text-forest-800 font-medium">
                                    <div class="w-8 h-8 rounded bg-emerald-100 flex items-center justify-center flex-shrink-0 text-emerald-700">
                                        <i data-lucide="file-check-2" class="w-4 h-4"></i>
                                    </div>
                                    <div class="text-left overflow-hidden">
                                        <span id="upload-file-name-halal" class="font-semibold block truncate text-stone-800 max-w-[200px] sm:max-w-xs"></span>
                                        <span id="upload-file-size-halal" class="text-xs text-stone-400 font-normal"></span>
                                    </div>
                                    <button type="button" onclick="event.stopPropagation(); clearSertifikatHalal()" class="ml-auto text-xs text-red-500 hover:text-red-700 font-semibold flex items-center gap-1">
                                        <i data-lucide="x" class="w-3 h-3"></i> Hapus
                                    </button>
                                </div>
                            </div>
                            <p id="upload-error-msg-halal" class="upload-error-msg"></p>
                            <input type="file" id="f-sertifikat-halal" name="sertifikat_halal" accept="application/pdf" class="hidden">
                        </div>

                        {{-- Submit --}}
                        <button id="submit-btn" type="submit" disabled
                            class="w-full btn-primary justify-center h-13 text-[11px] disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:translate-y-0 disabled:hover:shadow-none">
                            <span id="btn-text">Pilih Jenis Pesan</span>
                            <i data-lucide="send" class="w-4 h-4 ml-2"></i>
                        </button>
                    </form>
                </div>
                @endguest
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════════
             MAPS
        ══════════════════════════════════════════════════════════ --}}
        <div class="py-14 border-t border-stone-100 reveal-on-scroll delay-100">
            <div class="text-center mb-8">
                <span class="section-label">Peta Lokasi</span>
                <h2 class="font-display font-extrabold text-2xl sm:text-3xl text-forest-900 mt-3">Temukan Kami di Sini</h2>
                <div class="section-divider"></div>
            </div>
            <div class="bg-white border border-stone-200 rounded-2xl p-3 shadow-sm max-w-5xl mx-auto">
                <div class="h-80 sm:h-[420px] rounded-xl overflow-hidden">
                    <iframe
                        src="{{ !empty($mapsUrl) ? $mapsUrl : 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.262529813204!2d107.6761755!3d-6.612457!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6923c6db1dfea3%3A0xc0f3970f1ff4dff9!2sKantor%20Desa%20Jambelaer!5e0!3m2!1sid!2sid!4v1720894000000!5m2!1sid!2sid' }}"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
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

@push('scripts')
<script>
    // ── Global Service Selection Handler ─────────────────────────────
    const isUserLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
    window.selectServiceType = function(type) {
        if (type === 'pengajuan_surat') {
            window.location.href = "{{ route('pengajuan.surat') }}";
            return;
        }
        if (!isUserLoggedIn) {
            window.location.href = "{{ route('login') }}";
            return;
        }
        const jenisPesanSelect = document.getElementById('jenis-pesan');
        if (!jenisPesanSelect) return;
        jenisPesanSelect.value = type;
        if (typeof updateFormFields === 'function') {
            updateFormFields();
        }
        const formSection = document.getElementById('form-section');
        if (formSection) {
            formSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            setTimeout(() => {
                const firstInput = document.getElementById('f-name');
                if (firstInput) firstInput.focus();
            }, 500);
        }
    };

    const form = document.getElementById('contact-form');
    if (form) {
        const successBox = document.getElementById('contact-success');
        const submitBtn = document.getElementById('submit-btn');
        const btnText = document.getElementById('btn-text');
        const jenisPesanSelect = document.getElementById('jenis-pesan');

        const fieldEmail = document.getElementById('field-email');
        const fieldWhatsapp = document.getElementById('field-whatsapp');
        const fieldSubject = document.getElementById('field-subject');
        const fieldMessage = document.getElementById('field-message');
        const fieldFotoBukti = document.getElementById('field-foto-bukti');

        // UMKM Registration Fields
        const fieldUmkmBanner = document.getElementById('field-umkm-banner');
        const fieldGroupPengelola = document.getElementById('field-group-pengelola-umkm');
        const fieldGroupTentang = document.getElementById('field-group-tentang-produk');
        const fieldGroupSpesifikasi = document.getElementById('field-group-spesifikasi-produk');
        const fieldNamaUmkm = document.getElementById('field-nama-umkm');
        const fieldJenisProdukUmkm = document.getElementById('field-jenis-produk-umkm');
        const fieldAlamatUmkm = document.getElementById('field-alamat-umkm');
        const fieldDeskripsiUmkm = document.getElementById('field-deskripsi-umkm');
        const fieldFotoProduk = document.getElementById('field-foto-produk');
        const fieldSertifikatHalal = document.getElementById('field-sertifikat-halal');

        const inputNamaUmkm = document.getElementById('f-nama-umkm');
        const inputJenisProdukUmkm = document.getElementById('f-jenis-produk-umkm');
        const inputAlamatUmkm = document.getElementById('f-alamat-umkm');
        const inputDeskripsiUmkm = document.getElementById('f-deskripsi-umkm');
        const inputJamOperasionalUmkm = document.getElementById('f-jam-operasional-umkm');
        const inputInstagramUmkm = document.getElementById('f-instagram-umkm');
        const inputIsiProdukUmkm = document.getElementById('f-isi-produk-umkm');
        const inputBeratBersihUmkm = document.getElementById('f-berat-bersih-umkm');
        const inputHargaProdukUmkm = document.getElementById('f-harga-produk-umkm');
        const inputKetersediaanUmkm = document.getElementById('f-ketersediaan-umkm');
        const inputSertifikasiUmkm = document.getElementById('f-sertifikasi-umkm');

        const inputEmail = document.getElementById('f-email');
        const inputWhatsapp = document.getElementById('f-whatsapp');
        const inputSubject = document.getElementById('f-subject');
        const inputMessage = document.getElementById('f-msg');
        const labelSubject = document.getElementById('label-subject');
        const labelMessage = document.getElementById('label-message');

        // === Upload Foto Bukti ===
    const inputFotoBukti = document.getElementById('f-foto-bukti');
    const uploadDropZone = document.getElementById('upload-drop-zone');
    const uploadPreview = document.getElementById('upload-preview');
    const uploadPlaceholder = document.getElementById('upload-placeholder');
    const uploadFileInfo = document.getElementById('upload-file-info');
    const uploadFileName = document.getElementById('upload-file-name');
    const uploadErrorMsg = document.getElementById('upload-error-msg');

    const ALLOWED_TYPES = ['image/jpeg', 'image/png', 'image/webp'];
    const MAX_SIZE_MB = 5;
    const MAX_SIZE_BYTES = MAX_SIZE_MB * 1024 * 1024;

    function setUploadError(msg) {
        uploadDropZone.classList.add('error');
        uploadDropZone.classList.remove('has-file');
        uploadErrorMsg.textContent = msg;
        uploadErrorMsg.style.display = 'block';
        uploadPreview.style.display = 'none';
        uploadPlaceholder.style.display = 'flex';
        uploadFileInfo.classList.add('hidden');
        inputFotoBukti.value = '';
    }

    function clearFotoBukti() {
        inputFotoBukti.value = '';
        uploadPreview.src = '';
        uploadPreview.style.display = 'none';
        uploadPlaceholder.style.display = 'flex';
        uploadFileInfo.classList.add('hidden');
        uploadDropZone.classList.remove('has-file', 'error');
        uploadErrorMsg.style.display = 'none';
        lucide.createIcons();
    }

    function handleFotoFile(file) {
        uploadErrorMsg.style.display = 'none';
        uploadDropZone.classList.remove('error');

        if (!ALLOWED_TYPES.includes(file.type)) {
            setUploadError('Format file tidak didukung. Gunakan JPG, PNG, atau WEBP.');
            return;
        }
        if (file.size > MAX_SIZE_BYTES) {
            setUploadError('Ukuran file melebihi batas ' + MAX_SIZE_MB + ' MB.');
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            uploadPreview.src = e.target.result;
            uploadPreview.style.display = 'block';
            uploadPlaceholder.style.display = 'none';
            uploadFileInfo.classList.remove('hidden');
            uploadFileName.textContent = file.name;
            uploadDropZone.classList.add('has-file');
            lucide.createIcons();
        };
        reader.readAsDataURL(file);
    }

    inputFotoBukti.addEventListener('change', function() {
        if (this.files && this.files[0]) handleFotoFile(this.files[0]);
    });

    uploadDropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });
    uploadDropZone.addEventListener('dragleave', function() {
        this.classList.remove('dragover');
    });
    uploadDropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        const file = e.dataTransfer.files[0];
        if (file) {
            // Sync ke input file supaya FormData ikut
            const dt = new DataTransfer();
            dt.items.add(file);
            inputFotoBukti.files = dt.files;
            handleFotoFile(file);
        }
    });

    // === Upload Foto Produk (daftar_umkm) ===
    const inputFotoProduk = document.getElementById('f-foto-produk');
    const uploadDropZoneProduk = document.getElementById('upload-drop-zone-produk');
    const uploadPreviewProduk = document.getElementById('upload-preview-produk');
    const uploadPlaceholderProduk = document.getElementById('upload-placeholder-produk');
    const uploadFileInfoProduk = document.getElementById('upload-file-info-produk');
    const uploadFileNameProduk = document.getElementById('upload-file-name-produk');
    const uploadErrorMsgProduk = document.getElementById('upload-error-msg-produk');

    function setUploadErrorProduk(msg) {
        uploadDropZoneProduk.classList.add('error');
        uploadDropZoneProduk.classList.remove('has-file');
        uploadErrorMsgProduk.textContent = msg;
        uploadErrorMsgProduk.style.display = 'block';
        uploadPreviewProduk.style.display = 'none';
        uploadPlaceholderProduk.style.display = 'flex';
        uploadFileInfoProduk.classList.add('hidden');
        inputFotoProduk.value = '';
    }

    function clearFotoProduk() {
        inputFotoProduk.value = '';
        uploadPreviewProduk.src = '';
        uploadPreviewProduk.style.display = 'none';
        uploadPlaceholderProduk.style.display = 'flex';
        uploadFileInfoProduk.classList.add('hidden');
        uploadDropZoneProduk.classList.remove('has-file', 'error');
        uploadErrorMsgProduk.style.display = 'none';
        lucide.createIcons();
    }

    function handleFotoProdukFile(file) {
        uploadErrorMsgProduk.style.display = 'none';
        uploadDropZoneProduk.classList.remove('error');

        if (!ALLOWED_TYPES.includes(file.type)) {
            setUploadErrorProduk('Format file tidak didukung. Gunakan JPG, PNG, atau WEBP.');
            return;
        }
        if (file.size > MAX_SIZE_BYTES) {
            setUploadErrorProduk('Ukuran file melebihi batas ' + MAX_SIZE_MB + ' MB.');
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            uploadPreviewProduk.src = e.target.result;
            uploadPreviewProduk.style.display = 'block';
            uploadPlaceholderProduk.style.display = 'none';
            uploadFileInfoProduk.classList.remove('hidden');
            uploadFileNameProduk.textContent = file.name;
            uploadDropZoneProduk.classList.add('has-file');
            lucide.createIcons();
        };
        reader.readAsDataURL(file);
    }

    inputFotoProduk.addEventListener('change', function() {
        if (this.files && this.files[0]) handleFotoProdukFile(this.files[0]);
    });

    uploadDropZoneProduk.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });
    uploadDropZoneProduk.addEventListener('dragleave', function() {
        this.classList.remove('dragover');
    });
    uploadDropZoneProduk.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        const file = e.dataTransfer.files[0];
        if (file) {
            const dt = new DataTransfer();
            dt.items.add(file);
            inputFotoProduk.files = dt.files;
            handleFotoProdukFile(file);
        }
    });

    // === Upload Sertifikat Halal (PDF, daftar_umkm) ===
    const inputSertifikatHalal     = document.getElementById('f-sertifikat-halal');
    const uploadDropZoneHalal      = document.getElementById('upload-drop-zone-halal');
    const uploadPlaceholderHalal   = document.getElementById('upload-placeholder-halal');
    const uploadFileInfoHalal      = document.getElementById('upload-file-info-halal');
    const uploadFileNameHalal      = document.getElementById('upload-file-name-halal');
    const uploadFileSizeHalal      = document.getElementById('upload-file-size-halal');
    const uploadErrorMsgHalal      = document.getElementById('upload-error-msg-halal');

    const MAX_HALAL_SIZE_MB    = 5;
    const MAX_HALAL_SIZE_BYTES = MAX_HALAL_SIZE_MB * 1024 * 1024;

    function setUploadErrorHalal(msg) {
        uploadDropZoneHalal.classList.add('error');
        uploadDropZoneHalal.classList.remove('has-file');
        uploadErrorMsgHalal.textContent = msg;
        uploadErrorMsgHalal.style.display = 'block';
        uploadPlaceholderHalal.style.display = 'flex';
        uploadFileInfoHalal.classList.add('hidden');
        inputSertifikatHalal.value = '';
    }

    function clearSertifikatHalal() {
        inputSertifikatHalal.value = '';
        uploadPlaceholderHalal.style.display = 'flex';
        uploadFileInfoHalal.classList.add('hidden');
        uploadDropZoneHalal.classList.remove('has-file', 'error');
        uploadErrorMsgHalal.style.display = 'none';
        lucide.createIcons();
    }

    function handleSertifikatHalalFile(file) {
        uploadErrorMsgHalal.style.display = 'none';
        uploadDropZoneHalal.classList.remove('error');

        if (file.type !== 'application/pdf' && !file.name.toLowerCase().endsWith('.pdf')) {
            setUploadErrorHalal('Format file tidak didukung. Harus berformat PDF.');
            return;
        }
        if (file.size > MAX_HALAL_SIZE_BYTES) {
            setUploadErrorHalal('Ukuran file melebihi batas ' + MAX_HALAL_SIZE_MB + ' MB.');
            return;
        }

        const sizeKb = (file.size / 1024).toFixed(1);
        const sizeMb = (file.size / (1024 * 1024)).toFixed(2);
        const displaySize = file.size > 1024 * 1024 ? `${sizeMb} MB` : `${sizeKb} KB`;

        uploadPlaceholderHalal.style.display = 'none';
        uploadFileInfoHalal.classList.remove('hidden');
        uploadFileNameHalal.textContent = file.name;
        uploadFileSizeHalal.textContent = displaySize;
        uploadDropZoneHalal.classList.add('has-file');
        lucide.createIcons();
    }

    inputSertifikatHalal.addEventListener('change', function() {
        if (this.files && this.files[0]) handleSertifikatHalalFile(this.files[0]);
    });

    uploadDropZoneHalal.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });
    uploadDropZoneHalal.addEventListener('dragleave', function() {
        this.classList.remove('dragover');
    });
    uploadDropZoneHalal.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        const file = e.dataTransfer.files[0];
        if (file) {
            const dt = new DataTransfer();
            dt.items.add(file);
            inputSertifikatHalal.files = dt.files;
            handleSertifikatHalalFile(file);
        }
    });

    function hideAllDynamicFields() {
        [fieldEmail, fieldWhatsapp, fieldSubject, fieldMessage, fieldFotoBukti,
            // UMKM fields
            fieldUmkmBanner, fieldGroupPengelola, fieldGroupTentang, fieldGroupSpesifikasi, fieldFotoProduk,
            fieldSertifikatHalal
        ].forEach(f => {
            if (f) f.classList.add('hidden');
        });

        [inputEmail, inputWhatsapp, inputSubject, inputMessage,
            // UMKM inputs
            inputNamaUmkm, inputAlamatUmkm, inputDeskripsiUmkm,
            inputJamOperasionalUmkm, inputInstagramUmkm, inputIsiProdukUmkm,
            inputHargaProdukUmkm, inputKetersediaanUmkm, inputSertifikasiUmkm
        ].forEach(inp => {
            if (inp) {
                inp.removeAttribute('required');
                inp.disabled = true;
                inp.value = ''; // Reset nilai agar tidak ada sisa data yang tertinggal
            }
        });

        // Reset select UMKM
        if (inputJenisProdukUmkm) inputJenisProdukUmkm.value = '';
        if (inputKetersediaanUmkm) inputKetersediaanUmkm.value = 'Tersedia';

        // Reset master hidden input saat semua field disembunyikan
        const waMaster = document.getElementById('f-wa-master');
        if (waMaster) waMaster.value = '';

        // Reset upload foto bukti, foto produk & sertifikat halal
        clearFotoBukti();
        clearFotoProduk();
        clearSertifikatHalal();
    }

    function showFieldWithRequired(field, input) {
        field.classList.remove('hidden');
        input.disabled = false;
        input.setAttribute('required', 'required');
    }

    function updateFormFields() {
        const jenisPesan = jenisPesanSelect.value;
        if (jenisPesan === 'pengajuan_surat') {
            window.location.href = "{{ route('pengajuan.surat') }}";
            return;
        }
        if (jenisPesan === 'daftar_umkm') {
            window.location.href = "{{ route('pendaftaran-umkm.create') }}";
            return;
        }
        hideAllDynamicFields();
        submitBtn.disabled = false;

        if (jenisPesan === 'pertanyaan_umum') {
            showFieldWithRequired(fieldEmail, inputEmail);
            showFieldWithRequired(fieldSubject, inputSubject);
            labelSubject.textContent = 'Subjek Pesan';
            inputMessage.name = 'message';
            showFieldWithRequired(fieldMessage, inputMessage);
            labelMessage.textContent = 'Isi Pesan';
            btnText.textContent = 'Kirim Pesan';
        } else if (jenisPesan === 'pengaduan') {
            showFieldWithRequired(fieldWhatsapp, inputWhatsapp);
            showFieldWithRequired(fieldSubject, inputSubject);
            labelSubject.textContent = 'Subjek Pengaduan';
            inputMessage.name = 'message';
            showFieldWithRequired(fieldMessage, inputMessage);
            labelMessage.textContent = 'Isi Pengaduan';
            fieldFotoBukti.classList.remove('hidden');
            btnText.textContent = 'Kirim Pengaduan';
        } else if (jenisPesan === 'daftar_umkm') {
            // Show UMKM banner info
            if (fieldUmkmBanner) fieldUmkmBanner.classList.remove('hidden');
            // Show WA field
            showFieldWithRequired(fieldWhatsapp, inputWhatsapp);
            // Show UMKM field groups
            if (fieldGroupPengelola) {
                fieldGroupPengelola.classList.remove('hidden');
                if (inputNamaUmkm) { inputNamaUmkm.disabled = false; inputNamaUmkm.setAttribute('required', 'required'); }
                if (inputAlamatUmkm) { inputAlamatUmkm.disabled = false; inputAlamatUmkm.setAttribute('required', 'required'); }
                if (inputJamOperasionalUmkm) inputJamOperasionalUmkm.disabled = false;
                if (inputInstagramUmkm) inputInstagramUmkm.disabled = false;
            }
            if (fieldGroupTentang) {
                fieldGroupTentang.classList.remove('hidden');
                if (inputDeskripsiUmkm) { inputDeskripsiUmkm.disabled = false; inputDeskripsiUmkm.setAttribute('required', 'required'); }
            }
            if (fieldGroupSpesifikasi) {
                fieldGroupSpesifikasi.classList.remove('hidden');
                if (inputHargaProdukUmkm) inputHargaProdukUmkm.disabled = false;
                if (inputIsiProdukUmkm) inputIsiProdukUmkm.disabled = false;
                if (inputKetersediaanUmkm) inputKetersediaanUmkm.disabled = false;
                if (inputSertifikasiUmkm) inputSertifikasiUmkm.disabled = false;
            }
            if (fieldFotoProduk) fieldFotoProduk.classList.remove('hidden');
            if (fieldSertifikatHalal) fieldSertifikatHalal.classList.remove('hidden');
            btnText.textContent = 'Kirim Pendaftaran UMKM';
        } else {
            submitBtn.disabled = true;
            btnText.textContent = 'Pilih Jenis Pesan';
        }
        lucide.createIcons();
    }

    const errorBox = document.getElementById('contact-error');
    const errorList = document.getElementById('error-list');

    jenisPesanSelect.addEventListener('change', updateFormFields);

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        successBox.classList.add('hidden');
        errorBox.classList.add('hidden');
        errorList.innerHTML = '';

        const originalBtnText = btnText.textContent;
        submitBtn.disabled = true;
        btnText.textContent = 'Mengirim...';

        fetch(form.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new FormData(form)
            })
            .then(response => {
                return response.json().then(data => {
                    if (!response.ok) {
                        if (response.status === 401 && data.redirect) {
                            window.location.href = data.redirect;
                            return;
                        }
                        if (data.errors && typeof data.errors === 'object') {
                            const errorMsgs = Object.values(data.errors).flat();
                            throw new Error(errorMsgs.join('<br>'));
                        }
                        throw new Error(data.message || 'Terjadi kesalahan saat memproses data.');
                    }
                    return data;
                });
            })
            .then(data => {
                if (data && data.redirect) {
                    window.location.href = data.redirect;
                    return;
                }
                successBox.classList.remove('hidden');
                form.reset();
                updateFormFields();
                successBox.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest'
                });
            })
            .catch(err => {
                errorBox.classList.remove('hidden');
                const errors = err.message.split('<br>');
                errors.forEach(errMsg => {
                    const li = document.createElement('li');
                    li.textContent = errMsg;
                    errorList.appendChild(li);
                });
                submitBtn.disabled = false;
                btnText.textContent = originalBtnText;
                lucide.createIcons();
                errorBox.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest'
                });
            });
    });

        // Auto-detect URL query parameter or hash on page load
        const urlParams = new URLSearchParams(window.location.search);
        const paramJenis = urlParams.get('jenis');
        const hash = window.location.hash;

        const hashMap = {
            '#form-pertanyaan': 'pertanyaan_umum',
            '#form-pengaduan': 'pengaduan',
            '#form-umkm': 'daftar_umkm',
        };

        if (paramJenis && ['pertanyaan_umum', 'pengaduan', 'daftar_umkm'].includes(paramJenis)) {
            jenisPesanSelect.value = paramJenis;
        } else if (hash && hashMap[hash]) {
            jenisPesanSelect.value = hashMap[hash];
        }

        updateFormFields();
    }
</script>
@endpush