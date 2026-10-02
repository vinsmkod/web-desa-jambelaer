@extends('layouts.app')

@section('title', 'Pengaduan Masyarakat | Pelayanan Aspirasi Warga Desa Jambelaer')
@section('meta_desc', 'Layanan pengaduan resmi Pemerintah Desa Jambelaer. Sampaikan aspirasi, laporan fasilitas umum, atau permasalahan lingkungan secara mudah dan transparan.')

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    { "@type": "ListItem", "position": 1, "name": "Beranda", "item": "{{ config('app.url') }}" },
    { "@type": "ListItem", "position": 2, "name": "Pengaduan Masyarakat", "item": "{{ config('app.url') }}/pengaduan" }
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
        <a href="{{ route('kontak') }}" class="hover:text-forest-800 transition-colors">Layanan Masyarakat</a>
        <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-stone-300"></i>
        <span class="text-forest-800 font-semibold">Pengaduan Masyarakat</span>
    </nav>
</div>

<div class="relative h-60 sm:h-72 lg:h-80 overflow-hidden bg-forest-900 rounded-[28px] sm:rounded-[32px] mx-3 sm:mx-5 lg:mx-6 shadow-sm">
    <img src="{{ asset('uploads/img/beranda.jpeg') }}"
        alt="Layanan Pengaduan Desa Jambelaer" class="w-full h-full object-cover opacity-50">
    <div class="absolute inset-0 bg-gradient-to-t from-forest-950/95 via-forest-900/60 to-forest-900/30"></div>
    <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
        <span class="section-label !bg-white/10 !text-sand-300 !border-white/20">Aspirasi & Laporan Warga</span>
        <h1 class="font-display font-extrabold text-3xl sm:text-4xl lg:text-5xl text-white mt-3">Pengaduan Masyarakat</h1>
        <p class="text-xs sm:text-sm text-white/75 mt-2 font-light max-w-lg">
            Sampaikan laporan kerusakan infrastruktur, kebersihan lingkungan, atau keluhan pelayanan untuk ditindaklanjuti Pemerintah Desa.
        </p>
    </div>
</div>

<div class="bg-white pb-24 pt-10">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        @auth
        {{-- Logged-in Banner --}}
        <div class="mb-8 p-4 sm:p-5 rounded-2xl bg-rose-50/70 border border-rose-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-xs">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-rose-700 text-white flex items-center justify-center flex-shrink-0">
                    <i data-lucide="user-check" class="w-5 h-5"></i>
                </div>
                <div>
                    <span class="text-[10px] font-bold tracking-widest uppercase text-rose-700 block">Akun Pengadu Terhubung</span>
                    <p class="text-sm font-bold text-stone-900">{{ Auth::user()->name }} <span class="text-xs font-normal text-stone-500">({{ Auth::user()->email }})</span></p>
                </div>
            </div>
            <a href="{{ route('pengajuan.saya', ['jenis' => 'pengaduan']) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-white border border-rose-200 text-xs font-bold text-rose-700 hover:bg-rose-50 transition-all shadow-2xs">
                <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                Riwayat Pengaduan Saya
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
                    <h4 class="text-sm font-bold text-amber-950">Masuk untuk Mengirim Pengaduan</h4>
                    <p class="text-xs text-amber-800 font-light mt-0.5">Silakan masuk ke akun Anda agar laporan dapat dipantau dan mendapatkan tanggapan resmi.</p>
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
                 LEFT: FORMULIR PENGADUAN
            ══════════════════════════════════════════════════════════ --}}
            <div class="lg:col-span-8 bg-white border border-stone-200 rounded-3xl p-6 sm:p-8 shadow-xs">
                
                <div class="border-b border-stone-100 pb-5 mb-6">
                    <span class="text-[10px] font-bold tracking-widest uppercase text-rose-700 bg-rose-50 px-2.5 py-1 rounded-md border border-rose-100">
                        Formulir Aspirasi & Laporan
                    </span>
                    <h2 class="font-display font-extrabold text-xl sm:text-2xl text-stone-900 mt-2">
                        Kirim Laporan Pengaduan
                    </h2>
                    <p class="text-xs text-stone-500 font-light mt-1">
                        Lengkapi detail permasalahan dan sertakan bukti foto jika tersedia untuk mempercepat tindak lanjut.
                    </p>
                </div>

                <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    {{-- Data Pengadu --}}
                    <div class="grid sm:grid-cols-2 gap-5">
                        <div>
                            <label for="nama" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">
                                Nama Lengkap <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" id="nama" name="nama"
                                value="{{ old('nama', Auth::user()->name ?? '') }}" required
                                class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-xl text-sm text-stone-800 placeholder-stone-400 focus:bg-white focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition-all"
                                placeholder="Masukkan nama lengkap Anda">
                        </div>

                        <div>
                            <label for="no_whatsapp" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">
                                Nomor WhatsApp <span class="text-rose-500">*</span>
                            </label>
                            <input type="tel" id="no_whatsapp" name="no_whatsapp"
                                value="{{ old('no_whatsapp') }}" required
                                class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-xl text-sm text-stone-800 placeholder-stone-400 focus:bg-white focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition-all"
                                placeholder="Contoh: 081234567890">
                        </div>
                    </div>

                    {{-- Judul Pengaduan --}}
                    <div>
                        <label for="judul" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">
                            Judul Laporan / Pengaduan <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="judul" name="judul"
                            value="{{ old('judul') }}" required
                            class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-xl text-sm text-stone-800 placeholder-stone-400 focus:bg-white focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition-all"
                            placeholder="Contoh: Lampu Penerangan Jalan Rusak di Dusun Karanganyar">
                    </div>

                    {{-- Lokasi Kejadian --}}
                    <div>
                        <label for="lokasi" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">
                            Lokasi / Tempat Kejadian <span class="text-stone-400 font-normal text-[11px]">(Opsional)</span>
                        </label>
                        <input type="text" id="lokasi" name="lokasi"
                            value="{{ old('lokasi') }}"
                            class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-xl text-sm text-stone-800 placeholder-stone-400 focus:bg-white focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition-all"
                            placeholder="Contoh: RT 03 / RW 02 dekat jembatan">
                    </div>

                    {{-- Isi Pengaduan --}}
                    <div>
                        <label for="isi_pengaduan" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">
                            Uraian Lengkap Pengaduan <span class="text-rose-500">*</span>
                        </label>
                        <textarea id="isi_pengaduan" name="isi_pengaduan" rows="5" required
                            class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-xl text-sm text-stone-800 placeholder-stone-400 focus:bg-white focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition-all leading-relaxed"
                            placeholder="Jelaskan secara rinci permasalahan, waktu kejadian, dan dampak yang dirasakan warga..."></textarea>
                    </div>

                    {{-- Upload Foto Bukti --}}
                    <div class="p-5 rounded-2xl bg-stone-50 border border-stone-200">
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">
                            Foto Bukti Pendukung <span class="text-stone-400 font-normal text-[11px]">(Opsional)</span>
                        </label>
                        <p class="text-xs text-stone-500 font-light mb-3">Format JPG, PNG, WEBP. Maksimal 5 MB.</p>
                        <input type="file" name="foto_bukti" id="foto_bukti" accept=".jpg,.jpeg,.png,.webp"
                            class="block w-full text-xs text-stone-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-rose-50 file:text-rose-700 hover:file:bg-rose-100 cursor-pointer">
                    </div>

                    {{-- Submit Button --}}
                    <div class="pt-4 border-t border-stone-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <p class="text-xs text-stone-400 font-light">
                            Dengan mengirim pengaduan, Anda menyatakan data yang diberikan adalah benar dan dapat dipertanggungjawabkan.
                        </p>
                        <button type="submit" class="btn-primary !bg-rose-700 !border-rose-700 hover:!bg-rose-800 w-full sm:w-auto flex-shrink-0 flex items-center justify-center gap-2">
                            <i data-lucide="send" class="w-4 h-4"></i>
                            Kirim Pengaduan
                        </button>
                    </div>
                </form>
            </div>

            {{-- ══════════════════════════════════════════════════════════
                 RIGHT: PANDUAN PENGADUAN
            ══════════════════════════════════════════════════════════ --}}
            <div class="lg:col-span-4 space-y-6">
                
                {{-- Alur Penanganan Card --}}
                <div class="bg-forest-900 text-white rounded-3xl p-6 sm:p-7 shadow-sm">
                    <h3 class="font-display font-bold text-base text-white mb-4 flex items-center gap-2">
                        <i data-lucide="shield-check" class="w-5 h-5 text-sand-400"></i>
                        Alur Tindak Lanjut
                    </h3>

                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-full bg-sand-400 text-forest-950 font-bold text-xs flex items-center justify-center flex-shrink-0 mt-0.5">1</div>
                            <div>
                                <h4 class="text-xs font-bold text-sand-300">Pengaduan Masuk</h4>
                                <p class="text-[11px] text-white/70 font-light mt-0.5">Sistem mencatat laporan dengan nomor tiket pengaduan unik.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-full bg-sand-400 text-forest-950 font-bold text-xs flex items-center justify-center flex-shrink-0 mt-0.5">2</div>
                            <div>
                                <h4 class="text-xs font-bold text-sand-300">Verifikasi & Peninjauan</h4>
                                <p class="text-[11px] text-white/70 font-light mt-0.5">Pemerintah Desa meninjau kebenaran informasi dan lokasi laporan.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-full bg-sand-400 text-forest-950 font-bold text-xs flex items-center justify-center flex-shrink-0 mt-0.5">3</div>
                            <div>
                                <h4 class="text-xs font-bold text-sand-300">Tindak Lanjut & Tanggapan</h4>
                                <p class="text-[11px] text-white/70 font-light mt-0.5">Admin memberikan tanggapan resmi dan melakukan koordinasi lapangan.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Hotline Card --}}
                <div class="bg-stone-50 border border-stone-200 rounded-3xl p-6">
                    <h4 class="font-display font-bold text-sm text-stone-800 mb-2 flex items-center gap-2">
                        <i data-lucide="phone-call" class="w-4 h-4 text-forest-700"></i>
                        Layanan Darurat / Cepat
                    </h4>
                    <p class="text-xs text-stone-500 font-light leading-relaxed mb-4">
                        Untuk kejadian darurat yang membutuhkan penanganan mendesak, silakan hubungi langsung kontak WhatsApp desa.
                    </p>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\Pengaturan::get('desa_telepon', '6281324768193')) }}" target="_blank"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-all w-full justify-center">
                        <i data-lucide="message-circle" class="w-4 h-4"></i>
                        Hubungi WhatsApp Desa
                    </a>
                </div>

            </div>

        </div>

    </div>
</div>

@endsection
