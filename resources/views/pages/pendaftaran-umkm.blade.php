@extends('layouts.app')

@section('title', 'Pendaftaran UMKM | Promosi Usaha Warga Desa Jambelaer')
@section('meta_desc', 'Daftarkan usaha UMKM warga Desa Jambelaer untuk diverifikasi dan dipromosikan melalui katalog produk resmi website Pemerintah Desa Jambelaer.')

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    { "@type": "ListItem", "position": 1, "name": "Beranda", "item": "{{ config('app.url') }}" },
    { "@type": "ListItem", "position": 2, "name": "Pendaftaran UMKM", "item": "{{ config('app.url') }}/pendaftaran-umkm" }
  ]
}
</script>
@endpush

@section('content')

{{-- ══════════════════════════════════════════════════════════════════
     BREADCRUMB & HEADER
══════════════════════════════════════════════════════════════════ --}}
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 sm:pt-6">
    <nav class="flex items-center gap-1.5 text-xs text-stone-500 mb-4 reveal-fade-up">
        <a href="{{ route('home') }}" class="hover:text-forest-800 transition-colors">Beranda</a>
        <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-stone-300"></i>
        <a href="{{ route('layanan') }}" class="hover:text-forest-800 transition-colors">Layanan Masyarakat</a>
        <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-stone-300"></i>
        <span class="text-forest-800 font-semibold">Pendaftaran UMKM</span>
    </nav>
</div>

<div class="relative h-60 sm:h-72 lg:h-80 overflow-hidden bg-forest-900 rounded-[28px] sm:rounded-[32px] mx-3 sm:mx-5 lg:mx-6 shadow-sm">
    <img src="{{ asset('uploads/img/beranda.jpeg') }}"
        alt="Pendaftaran UMKM Desa Jambelaer" class="w-full h-full object-cover opacity-50">
    <div class="absolute inset-0 bg-gradient-to-t from-forest-950/95 via-forest-900/60 to-forest-900/30"></div>
    <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
        <span class="section-label !bg-white/10 !text-sand-300 !border-white/20">Pemberdayaan Ekonomi Desa</span>
        <h1 class="font-display font-extrabold text-3xl sm:text-4xl lg:text-5xl text-white mt-3">Pendaftaran UMKM Desa</h1>
        <p class="text-xs sm:text-sm text-white/75 mt-2 font-light max-w-lg">
            Daftarkan produk dan usaha Anda untuk mendapatkan verifikasi resmi dan dipromosikan di etalase digital Desa Jambelaer.
        </p>
    </div>
</div>

<div class="bg-white pb-24 pt-10">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        @auth
        {{-- Logged-in Banner --}}
        <div class="mb-8 p-4 sm:p-5 rounded-2xl bg-emerald-50/70 border border-emerald-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-xs">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-700 text-white flex items-center justify-center flex-shrink-0">
                    <i data-lucide="store" class="w-5 h-5"></i>
                </div>
                <div>
                    <span class="text-[10px] font-bold tracking-widest uppercase text-emerald-700 block">Pelaku Usaha Terhubung</span>
                    <p class="text-sm font-bold text-stone-900">{{ Auth::user()->name }} <span class="text-xs font-normal text-stone-500">({{ Auth::user()->email }})</span></p>
                </div>
            </div>
            <a href="{{ route('pengajuan.saya', ['jenis' => 'pendaftaran_umkm']) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-white border border-emerald-200 text-xs font-bold text-emerald-700 hover:bg-emerald-50 transition-all shadow-2xs">
                <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                Riwayat Pendaftaran UMKM
            </a>
        </div>
        @else
        {{-- Guest Warning Banner --}}
        <div class="mb-8 p-5 rounded-2xl bg-amber-50 border border-amber-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center flex-shrink-0">
                    <i data-lucide="log-in" class="w-5 h-5"></i>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-amber-950">Masuk untuk Mendaftarkan UMKM</h4>
                    <p class="text-xs text-amber-800 font-light mt-0.5">Silakan masuk ke akun Anda agar status kurasi dan publikasi UMKM dapat dipantau langsung.</p>
                </div>
            </div>
            <a href="{{ route('login') }}" class="btn-primary text-xs !bg-amber-600 !border-amber-600 hover:!bg-amber-700 flex-shrink-0">
                Masuk Sekarang
            </a>
        </div>
        @endauth

        {{-- Error Summary Alert --}}
        @if ($errors->any())
        <div class="mb-8 p-5 rounded-2xl bg-rose-50 border border-rose-200 flex items-start gap-3.5 text-rose-900 shadow-xs">
            <div class="w-8 h-8 rounded-xl bg-rose-600 text-white flex items-center justify-center flex-shrink-0 mt-0.5">
                <i data-lucide="alert-circle" class="w-4 h-4"></i>
            </div>
            <div>
                <h4 class="text-sm font-bold">Harap Periksa Kembali Formulir Anda</h4>
                <ul class="mt-1.5 list-disc list-inside text-xs text-rose-700 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <div class="grid lg:grid-cols-12 gap-8 items-start">

            {{-- ══════════════════════════════════════════════════════════
                 LEFT: FORMULIR PENDAFTARAN UMKM
            ══════════════════════════════════════════════════════════ --}}
            <div class="lg:col-span-8 bg-white border border-stone-200 rounded-3xl p-6 sm:p-8 shadow-xs">
                
                <div class="border-b border-stone-100 pb-5 mb-6">
                    <span class="text-[10px] font-bold tracking-widest uppercase text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-100">
                        Formulir Registrasi Usaha
                    </span>
                    <h2 class="font-display font-extrabold text-xl sm:text-2xl text-stone-900 mt-2">
                        Data Profil & Produk UMKM
                    </h2>
                    <p class="text-xs text-stone-500 font-light mt-1">
                        Isi informasi usaha dengan lengkap. Data yang disetujui akan ditampilkan pada katalog produk UMKM Desa.
                    </p>
                </div>

                <form action="{{ route('pendaftaran-umkm.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    {{-- Nama Usaha & Pemilik --}}
                    <div class="grid sm:grid-cols-2 gap-5">
                        <div>
                            <label for="nama_usaha" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">
                                Nama Usaha / Merk <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" id="nama_usaha" name="nama_usaha"
                                value="{{ old('nama_usaha') }}" required
                                class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-xl text-sm text-stone-800 placeholder-stone-400 focus:bg-white focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all"
                                placeholder="Contoh: Opak Tradisional Bu Tini">
                        </div>

                        <div>
                            <label for="nama_pemilik" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">
                                Nama Pemilik Usaha <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" id="nama_pemilik" name="nama_pemilik"
                                value="{{ old('nama_pemilik', Auth::user()->name ?? '') }}" required
                                class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-xl text-sm text-stone-800 placeholder-stone-400 focus:bg-white focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all"
                                placeholder="Nama penanggung jawab">
                        </div>
                    </div>

                    {{-- Produk & Kontak WhatsApp --}}
                    <div class="grid sm:grid-cols-2 gap-5">
                        <div>
                            <label for="produk" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">
                                Kategori / Jenis Produk <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" id="produk" name="produk"
                                value="{{ old('produk') }}" required
                                class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-xl text-sm text-stone-800 placeholder-stone-400 focus:bg-white focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all"
                                placeholder="Contoh: Kuliner & Makanan Ringan">
                        </div>

                        <div>
                            <label for="nomor_whatsapp" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">
                                Nomor WhatsApp Pemesanan <span class="text-rose-500">*</span>
                            </label>
                            <input type="tel" id="nomor_whatsapp" name="nomor_whatsapp"
                                value="{{ old('nomor_whatsapp') }}" required
                                class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-xl text-sm text-stone-800 placeholder-stone-400 focus:bg-white focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all"
                                placeholder="Contoh: 081234567890">
                        </div>
                    </div>

                    {{-- Alamat Usaha --}}
                    <div>
                        <label for="alamat_usaha" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">
                            Alamat Lokasi Usaha <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="alamat_usaha" name="alamat_usaha"
                            value="{{ old('alamat_usaha') }}" required
                            class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-xl text-sm text-stone-800 placeholder-stone-400 focus:bg-white focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all"
                            placeholder="Contoh: Dusun Jambelaer RT 04 / RW 02">
                    </div>

                    {{-- Instagram Usaha --}}
                    <div>
                        <label for="instagram" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">
                            Akun Instagram Usaha <span class="text-stone-400 font-normal text-[11px]">(Opsional)</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-stone-400 text-sm">@</span>
                            <input type="text" id="instagram" name="instagram"
                                value="{{ old('instagram') }}"
                                class="w-full pl-8 pr-4 py-3 bg-stone-50 border border-stone-200 rounded-xl text-sm text-stone-800 placeholder-stone-400 focus:bg-white focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all"
                                placeholder="username_usaha">
                        </div>
                    </div>

                    {{-- Deskripsi Usaha --}}
                    <div>
                        <label for="deskripsi_usaha" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">
                            Deskripsi Profil Usaha & Produk <span class="text-rose-500">*</span>
                        </label>
                        <textarea id="deskripsi_usaha" name="deskripsi_usaha" rows="4" required
                            class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-xl text-sm text-stone-800 placeholder-stone-400 focus:bg-white focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all leading-relaxed"
                            placeholder="Jelaskan keunggulan produk, varian rasa, kemasan, atau kisah pembuatan produk usaha Anda..."></textarea>
                    </div>

                    {{-- Berkas Upload Section --}}
                    <div class="space-y-4 pt-2 border-t border-stone-100">
                        <h4 class="text-xs font-bold text-stone-900 uppercase tracking-wider">Berkas & Legalitas Usaha</h4>

                        {{-- Foto Produk (Wajib) --}}
                        <div class="p-4 rounded-2xl bg-stone-50 border border-stone-200">
                            <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">
                                Foto Produk Unggulan <span class="text-rose-500">*</span>
                            </label>
                            <p class="text-xs text-stone-500 font-light mb-3">Foto produk yang jelas untuk etalase website. Format JPG, PNG, WEBP (Maks. 5 MB).</p>
                            <input type="file" name="foto_produk" id="foto_produk" required accept=".jpg,.jpeg,.png,.webp"
                                class="block w-full text-xs text-stone-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer">
                        </div>

                        {{-- NIB (Opsional) --}}
                        <div class="p-4 rounded-2xl bg-stone-50 border border-stone-200">
                            <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">
                                Nomor Induk Berusaha (NIB) <span class="text-stone-400 font-normal text-[11px]">(Opsional - File/Nomor)</span>
                            </label>
                            <p class="text-xs text-stone-500 font-light mb-3">Unggah dokumen scan NIB atau berkas izin usaha.</p>
                            <input type="file" name="nib" id="nib" accept=".jpg,.jpeg,.png,.webp,.pdf"
                                class="block w-full text-xs text-stone-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-stone-200 file:text-stone-700 hover:file:bg-stone-300 cursor-pointer">
                        </div>

                        {{-- Sertifikasi Halal (Opsional) --}}
                        <div class="p-4 rounded-2xl bg-stone-50 border border-stone-200">
                            <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">
                                Sertifikasi Halal <span class="text-stone-400 font-normal text-[11px]">(Opsional - File/Nomor)</span>
                            </label>
                            <p class="text-xs text-stone-500 font-light mb-3">Unggah sertifikat halal jika produk telah tersertifikasi.</p>
                            <input type="file" name="sertifikasi_halal" id="sertifikasi_halal" accept=".jpg,.jpeg,.png,.webp,.pdf"
                                class="block w-full text-xs text-stone-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-stone-200 file:text-stone-700 hover:file:bg-stone-300 cursor-pointer">
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="pt-4 border-t border-stone-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <p class="text-xs text-stone-400 font-light">
                            Data pendaftaran akan diverifikasi oleh Admin sebelum dipublikasikan di halaman katalog UMKM desa.
                        </p>
                        <button type="submit" class="w-full sm:w-auto btn-submit-layanan">
                            <span class="btn-spinner"></span>
                            <i data-lucide="store" class="w-4 h-4 btn-icon"></i>
                            <span class="btn-text">Daftarkan UMKM</span>
                        </button>
                    </div>
                </form>
            </div>

            {{-- ══════════════════════════════════════════════════════════
                 RIGHT: KEUNTUNGAN & ALUR KURASI
            ══════════════════════════════════════════════════════════ --}}
            <div class="lg:col-span-4 space-y-6">
                
                {{-- Keuntungan Promosi Card --}}
                <div class="bg-forest-900 text-white rounded-3xl p-6 sm:p-7 shadow-sm">
                    <h3 class="font-display font-bold text-base text-white mb-4 flex items-center gap-2">
                        <i data-lucide="trending-up" class="w-5 h-5 text-sand-400"></i>
                        Manfaat Promosi Desa
                    </h3>

                    <ul class="space-y-3.5 text-xs text-white/80 font-light">
                        <li class="flex items-start gap-2.5">
                            <i data-lucide="check" class="w-4 h-4 text-sand-300 flex-shrink-0 mt-0.5"></i>
                            <span>Tampil resmi di halaman etalase digital UMKM Desa Jambelaer.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <i data-lucide="check" class="w-4 h-4 text-sand-300 flex-shrink-0 mt-0.5"></i>
                            <span>Terhubung langsung dengan tautan WhatsApp untuk pemesanan instan.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <i data-lucide="check" class="w-4 h-4 text-sand-300 flex-shrink-0 mt-0.5"></i>
                            <span>Meningkatkan kepercayaan pembeli lokal maupun luar daerah.</span>
                        </li>
                    </ul>
                </div>

                {{-- Alur Kurasi Card --}}
                <div class="bg-stone-50 border border-stone-200 rounded-3xl p-6">
                    <h4 class="font-display font-bold text-sm text-stone-800 mb-2 flex items-center gap-2">
                        <i data-lucide="layers" class="w-4 h-4 text-emerald-600"></i>
                        Alur Verifikasi
                    </h4>
                    <p class="text-xs text-stone-500 font-light leading-relaxed mb-3">
                        1. Pendaftaran dikirim oleh warga.<br>
                        2. Administrator memverifikasi keabsahan profil usaha.<br>
                        3. Setelah disetujui, UMKM otomatis dipublikasikan di menu produk.
                    </p>
                    <a href="{{ route('umkm') }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 inline-flex items-center gap-1">
                        Lihat Katalog UMKM Saat Ini <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                    </a>
                </div>

            </div>

        </div>

    </div>
</div>

@endsection
