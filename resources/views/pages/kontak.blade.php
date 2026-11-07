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
    { "@type": "ListItem", "position": 2, "name": "Layanan & Kontak Desa Jambelaer", "item": "{{ config('app.url') }}/layanan" }
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
                        <span class="text-sm text-stone-700 font-medium leading-snug mt-1 block">{{ \App\Models\PengaturanModel::get('desa_alamat', 'Jl. Raya Jambelaer, Dawuan, Subang 41270') }}</span>
                    </div>
                </div>
                <div class="flex items-start gap-4 p-4 sm:p-5 bg-sand-50 border border-sand-100 rounded-xl">
                    <div class="w-10 h-10 rounded-lg bg-sand-500 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="phone" class="w-4 h-4 text-white"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold tracking-widest uppercase text-sand-600 block">Telepon</span>
                        <span class="text-sm text-stone-700 font-medium leading-snug mt-1 block">{{ \App\Models\PengaturanModel::get('desa_telepon', '081324768193') }}</span>
                    </div>
                </div>
                <div class="flex items-start gap-4 p-4 sm:p-5 bg-stone-50 border border-stone-100 rounded-xl">
                    <div class="w-10 h-10 rounded-lg bg-stone-600 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="mail" class="w-4 h-4 text-white"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold tracking-widest uppercase text-stone-500 block">Email</span>
                        <span class="text-sm text-stone-700 font-medium leading-snug mt-1 block break-all">{{ \App\Models\PengaturanModel::get('desa_email', 'info@jambelaer-subang.desa.id') }}</span>
                    </div>
                </div>
                <div class="flex items-start gap-4 p-4 sm:p-5 bg-sky-50 border border-sky-100 rounded-xl">
                    <div class="w-10 h-10 rounded-lg bg-sky-600 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="clock" class="w-4 h-4 text-white"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold tracking-widest uppercase text-sky-600 block">Jam Layanan</span>
                        <span class="text-sm text-stone-700 font-medium leading-snug mt-1 block">{{ \App\Models\PengaturanModel::get('desa_jam_buka', 'Senin – Jumat: 08:00 – 15:30 WIB') }}</span>
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


        {{-- ══════════════════════════════════════════════════════════
             PANDUAN LAYANAN & INFORMASI KANTOR
        ══════════════════════════════════════════════════════════ --}}
        <div id="panduan-layanan" class="py-14 grid lg:grid-cols-12 gap-8 items-start reveal-on-scroll scroll-mt-20">

            {{-- Kolom Kiri: Panduan Prosedur Pelayanan --}}
            <div class="lg:col-span-7 space-y-6">
                <div class="bg-white border border-stone-200 rounded-2xl p-7 sm:p-9 shadow-sm">
                    <div class="flex items-center gap-2 mb-2.5">
                        <span class="text-[10px] font-bold tracking-widest uppercase text-forest-700 bg-forest-50 px-2.5 py-1 rounded-md border border-forest-100">
                            Prosedur & Alur
                        </span>
                    </div>
                    <h2 class="font-display font-extrabold text-2xl sm:text-3xl text-forest-950 mb-2">
                        Bagaimana Menggunakan Layanan?
                    </h2>
                    <p class="text-sm text-stone-500 font-light leading-relaxed mb-8">
                        Ikuti empat langkah mudah di bawah ini untuk mengajukan permohonan administrasi atau menyampaikan aspirasi secara resmi kepada Pemerintah Desa Jambelaer:
                    </p>

                    <div class="space-y-6">
                        {{-- Langkah 1 --}}
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-2xl bg-forest-800 text-sand-300 font-bold flex items-center justify-center flex-shrink-0 text-sm shadow-xs">
                                1
                            </div>
                            <div class="pt-0.5">
                                <h4 class="text-sm font-bold text-stone-900">Pilih Jenis Layanan Sesuai Kebutuhan</h4>
                                <p class="text-xs text-stone-500 font-light mt-1 leading-relaxed">
                                    Tentukan jenis layanan yang Anda perlukan melalui salah satu dari empat kartu di atas: <strong>Pengajuan Surat</strong>, <strong>Pengaduan Masyarakat</strong>, <strong>Pertanyaan Umum</strong>, atau <strong>Pendaftaran UMKM</strong>.
                                </p>
                            </div>
                        </div>

                        {{-- Langkah 2 --}}
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-2xl bg-forest-800 text-sand-300 font-bold flex items-center justify-center flex-shrink-0 text-sm shadow-xs">
                                2
                            </div>
                            <div class="pt-0.5">
                                <h4 class="text-sm font-bold text-stone-900">Klik Tombol untuk Membuka Formulir Layanan</h4>
                                <p class="text-xs text-stone-500 font-light mt-1 leading-relaxed">
                                    Klik tombol pada kartu pilihan Anda untuk langsung diarahkan menuju halaman formulir mandiri yang dirancang khusus sesuai ketentuan layanan tersebut.
                                </p>
                            </div>
                        </div>

                        {{-- Langkah 3 --}}
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-2xl bg-forest-800 text-sand-300 font-bold flex items-center justify-center flex-shrink-0 text-sm shadow-xs">
                                3
                            </div>
                            <div class="pt-0.5">
                                <h4 class="text-sm font-bold text-stone-900">Isi Data & Lengkapi Dokumen yang Diperlukan</h4>
                                <p class="text-xs text-stone-500 font-light mt-1 leading-relaxed">
                                    Lengkapi identitas pemohon dan unggah berkas persyaratan pendukung yang diminta (seperti foto/scan KTP dan Kartu Keluarga) dengan jelas, lengkap, dan sah.
                                </p>
                            </div>
                        </div>

                        {{-- Langkah 4 --}}
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-2xl bg-forest-800 text-sand-300 font-bold flex items-center justify-center flex-shrink-0 text-sm shadow-xs">
                                4
                            </div>
                            <div class="pt-0.5">
                                <h4 class="text-sm font-bold text-stone-900">Kirim Permohonan Melalui Sistem</h4>
                                <p class="text-xs text-stone-500 font-light mt-1 leading-relaxed">
                                    Kirimkan formulir untuk diproses dan diverifikasi oleh petugas desa. Progres verifikasi dan riwayat pengajuan dapat Anda pantau secara langsung melalui website.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Informasi Status Login / Ketentuan Akun --}}
                    <div class="mt-8 pt-6 border-t border-stone-100">
                        @auth
                        <div class="p-4 rounded-xl bg-forest-50 border border-forest-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-8 h-8 rounded-lg bg-forest-800 text-sand-300 flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="user-check" class="w-4 h-4"></i>
                                </div>
                                <div class="min-w-0">
                                    <span class="text-stone-500 block text-[10px] uppercase font-bold tracking-wider text-forest-700">Akun Terautentikasi</span>
                                    <span class="font-bold text-forest-950 truncate block">{{ Auth::user()->name }} ({{ Auth::user()->email }})</span>
                                </div>
                            </div>
                            <a href="{{ route('pengajuan.saya') }}" class="btn-primary text-xs py-2 px-3.5 flex-shrink-0 gap-1.5 shadow-2xs">
                                <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                                Riwayat Pengajuan
                            </a>
                        </div>
                        @else
                        <div class="p-5 rounded-2xl bg-amber-50/80 border border-amber-200/80">
                            <div class="flex items-start gap-3.5">
                                <div class="w-9 h-9 rounded-xl bg-amber-500 text-white flex items-center justify-center flex-shrink-0 mt-0.5 shadow-xs">
                                    <i data-lucide="lock" class="w-4.5 h-4.5"></i>
                                </div>
                                <div class="space-y-1.5">
                                    <h5 class="text-xs font-bold text-amber-950 uppercase tracking-wide">Ketentuan Autentikasi Pengguna</h5>
                                    <p class="text-xs text-amber-900/90 leading-relaxed font-light">
                                        Masyarakat diharapkan untuk <strong>masuk (login)</strong> ke akun terlebih dahulu sebelum mengirimkan pengajuan layanan demi keabsahan data pemohon dan kemudahan pemantauan status berkas.
                                    </p>
                                    <div class="flex flex-wrap items-center gap-2.5 pt-2">
                                        <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-forest-800 text-white text-xs font-bold hover:bg-forest-900 transition-all shadow-xs">
                                            <i data-lucide="log-in" class="w-3.5 h-3.5"></i>
                                            Masuk Akun
                                        </a>
                                        <a href="{{ route('register') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-white border border-amber-300 text-xs font-bold text-stone-700 hover:bg-amber-100/50 transition-all">
                                            <i data-lucide="user-plus" class="w-3.5 h-3.5 text-forest-700"></i>
                                            Daftar Akun Baru
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endauth
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Informasi Kantor, Jam Operasional & Media Sosial --}}
            <div class="lg:col-span-5 space-y-5">
                {{-- Office Info Card --}}
                <div class="bg-forest-900 text-white rounded-2xl p-7 shadow-sm">
                    <h2 class="font-display font-bold text-lg text-white mb-5 pb-4 border-b border-white/10">
                        Kantor Desa Jambelaer
                    </h2>
                    <div class="space-y-5">
                        <div class="flex items-start gap-4">
                            <div class="w-9 h-9 rounded-lg bg-white/10 border border-white/15 flex items-center justify-center flex-shrink-0">
                                <i data-lucide="map-pin" class="w-4 h-4 text-sand-400"></i>
                            </div>
                            <div>
                                <span class="text-[10px] text-sand-400 font-bold tracking-widest uppercase block">Alamat Lengkap</span>
                                <span class="text-sm text-white/80 font-light mt-1 block leading-relaxed">{{ \App\Models\PengaturanModel::get('desa_alamat', 'Jl. Raya Jambelaer No. 12, Kecamatan Dawuan, Kabupaten Subang, Jawa Barat 41270') }}</span>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-9 h-9 rounded-lg bg-white/10 border border-white/15 flex items-center justify-center flex-shrink-0">
                                <i data-lucide="phone" class="w-4 h-4 text-sand-400"></i>
                            </div>
                            <div>
                                <span class="text-[10px] text-sand-400 font-bold tracking-widest uppercase block">Telepon / Kontak</span>
                                <span class="text-sm text-white/80 font-light mt-1 block">{{ \App\Models\PengaturanModel::get('desa_telepon', '081324768193') }}</span>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-9 h-9 rounded-lg bg-white/10 border border-white/15 flex items-center justify-center flex-shrink-0">
                                <i data-lucide="mail" class="w-4 h-4 text-sand-400"></i>
                            </div>
                            <div>
                                <span class="text-[10px] text-sand-400 font-bold tracking-widest uppercase block">Email Resmi</span>
                                <span class="text-sm text-white/80 font-light mt-1 block break-all">{{ \App\Models\PengaturanModel::get('desa_email', 'info@jambelaer-subang.desa.id') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Jam Layanan Card --}}
                <div class="bg-white border border-stone-200 rounded-2xl p-6 shadow-sm">
                    <h3 class="font-display font-bold text-sm text-forest-900 mb-4 flex items-center gap-2">
                        <i data-lucide="calendar-clock" class="w-4 h-4 text-sand-500"></i>
                        Jam Operasional Pelayanan
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
                            <span class="text-xs font-semibold text-rose-600 bg-rose-50 px-3 py-1 rounded-full">Libur</span>
                        </div>
                    </div>
                </div>

                {{-- Sosmed Card --}}
                <div class="bg-sand-50 border border-sand-100 rounded-2xl p-6 shadow-sm">
                    <h3 class="font-display font-bold text-sm text-forest-900 mb-4 flex items-center gap-2">
                        <i data-lucide="share-2" class="w-4 h-4 text-forest-700"></i>
                        Media Sosial Resmi Desa
                    </h3>
                    @php
                    $kIg = \App\Models\PengaturanModel::get('sosmed_instagram', '');
                    $kYt = \App\Models\PengaturanModel::get('sosmed_youtube', '');
                    $kTt = \App\Models\PengaturanModel::get('sosmed_tiktok', '');
                    @endphp
                    <div class="flex flex-wrap gap-2">
                        @if($kIg)
                        <a href="{{ str_starts_with($kIg, 'http') ? $kIg : 'https://'.$kIg }}" target="_blank" rel="noopener"
                            class="flex items-center gap-2 px-3 py-2 rounded-lg bg-white border border-stone-200 text-xs font-medium text-stone-700 hover:border-pink-300 hover:text-pink-600 transition-all shadow-2xs">
                            <i data-lucide="instagram" class="w-4 h-4"></i> Instagram
                        </a>
                        @endif
                        @if($kYt)
                        <a href="{{ str_starts_with($kYt, 'http') ? $kYt : 'https://'.$kYt }}" target="_blank" rel="noopener"
                            class="flex items-center gap-2 px-3 py-2 rounded-lg bg-white border border-stone-200 text-xs font-medium text-stone-700 hover:border-red-300 hover:text-red-600 transition-all shadow-2xs">
                            <i data-lucide="youtube" class="w-4 h-4"></i> YouTube
                        </a>
                        @endif
                        @if(!$kIg && !$kYt && !$kTt)
                        <p class="text-xs text-stone-400 font-light">Media sosial belum dikonfigurasi.</p>
                        @endif
                    </div>
                </div>
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
@endpush