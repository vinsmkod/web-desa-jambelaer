@extends('layouts.app')

@section('title', 'Pertanyaan Umum | Pusat Informasi Pelayanan Desa Jambelaer')
@section('meta_desc', 'Ajukan pertanyaan umum seputar program kerja, administrasi, atau pelayanan masyarakat Pemerintah Desa Jambelaer, Kecamatan Dawuan, Kabupaten Subang.')

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    { "@type": "ListItem", "position": 1, "name": "Beranda", "item": "{{ config('app.url') }}" },
    { "@type": "ListItem", "position": 2, "name": "Pertanyaan Umum", "item": "{{ config('app.url') }}/pertanyaan-umum" }
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
        <span class="text-forest-800 font-semibold">Pertanyaan Umum</span>
    </nav>
</div>

<div class="relative h-60 sm:h-72 lg:h-80 overflow-hidden bg-forest-900 rounded-[28px] sm:rounded-[32px] mx-3 sm:mx-5 lg:mx-6 shadow-sm">
    <img src="{{ asset('uploads/img/beranda.jpeg') }}"
        alt="Pertanyaan Informasi Desa Jambelaer" class="w-full h-full object-cover opacity-50">
    <div class="absolute inset-0 bg-gradient-to-t from-forest-950/95 via-forest-900/60 to-forest-900/30"></div>
    <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
        <span class="section-label !bg-white/10 !text-sand-300 !border-white/20">Informasi & Konsultasi</span>
        <h1 class="font-display font-extrabold text-3xl sm:text-4xl lg:text-5xl text-white mt-3">Pertanyaan Umum</h1>
        <p class="text-xs sm:text-sm text-white/75 mt-2 font-light max-w-lg">
            Sampaikan pertanyaan Anda seputar program, informasi pelayanan, atau jadwal kegiatan di Desa Jambelaer.
        </p>
    </div>
</div>

<div class="bg-white pb-24 pt-10">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        @auth
        {{-- Logged-in Banner --}}
        <div class="mb-8 p-4 sm:p-5 rounded-2xl bg-sky-50/70 border border-sky-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-xs">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-sky-700 text-white flex items-center justify-center flex-shrink-0">
                    <i data-lucide="user-check" class="w-5 h-5"></i>
                </div>
                <div>
                    <span class="text-[10px] font-bold tracking-widest uppercase text-sky-700 block">Akun Penanya Terhubung</span>
                    <p class="text-sm font-bold text-stone-900">{{ Auth::user()->name }} <span class="text-xs font-normal text-stone-500">({{ Auth::user()->email }})</span></p>
                </div>
            </div>
            <a href="{{ route('pengajuan.saya', ['jenis' => 'pertanyaan_umum']) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-white border border-sky-200 text-xs font-bold text-sky-700 hover:bg-sky-50 transition-all shadow-2xs">
                <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                Riwayat Pertanyaan Saya
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
                    <h4 class="text-sm font-bold text-amber-950">Masuk untuk Mengajukan Pertanyaan</h4>
                    <p class="text-xs text-amber-800 font-light mt-0.5">Masuk ke akun Anda agar jawaban resmi dari admin dapat Anda terima dan pantau secara langsung.</p>
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
                 LEFT: FORMULIR PERTANYAAN
            ══════════════════════════════════════════════════════════ --}}
            <div class="lg:col-span-8 bg-white border border-stone-200 rounded-3xl p-6 sm:p-8 shadow-xs">
                
                <div class="border-b border-stone-100 pb-5 mb-6">
                    <span class="text-[10px] font-bold tracking-widest uppercase text-sky-700 bg-sky-50 px-2.5 py-1 rounded-md border border-sky-100">
                        Formulir Pertanyaan Bebas
                    </span>
                    <h2 class="font-display font-extrabold text-xl sm:text-2xl text-stone-900 mt-2">
                        Tulis Pertanyaan Anda
                    </h2>
                    <p class="text-xs text-stone-500 font-light mt-1">
                        Sampaikan pertanyaan atau permohonan informasi secara ringkas dan jelas. Modul ini tidak memerlukan unggahan berkas.
                    </p>
                </div>

                <form action="{{ route('pertanyaan-umum.store') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- Data Penanya --}}
                    <div class="grid sm:grid-cols-2 gap-5">
                        <div>
                            <label for="nama" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">
                                Nama Lengkap <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" id="nama" name="nama"
                                value="{{ old('nama', Auth::user()->name ?? '') }}" required
                                class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-xl text-sm text-stone-800 placeholder-stone-400 focus:bg-white focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all"
                                placeholder="Masukkan nama lengkap Anda">
                        </div>

                        <div>
                            <label for="no_whatsapp" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">
                                Nomor WhatsApp <span class="text-rose-500">*</span>
                            </label>
                            <input type="tel" id="no_whatsapp" name="no_whatsapp"
                                value="{{ old('no_whatsapp') }}" required
                                class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-xl text-sm text-stone-800 placeholder-stone-400 focus:bg-white focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all"
                                placeholder="Contoh: 081234567890">
                        </div>
                    </div>

                    {{-- Subjek Pertanyaan --}}
                    <div>
                        <label for="subjek" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">
                            Topik / Subjek Pertanyaan <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="subjek" name="subjek"
                            value="{{ old('subjek') }}" required
                            class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-xl text-sm text-stone-800 placeholder-stone-400 focus:bg-white focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all"
                            placeholder="Contoh: Jadwal Pelayanan Perekaman KTP Elektronik Desa">
                    </div>

                    {{-- Isi Pertanyaan --}}
                    <div>
                        <label for="pertanyaan" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">
                            Isi Pertanyaan <span class="text-rose-500">*</span>
                        </label>
                        <textarea id="pertanyaan" name="pertanyaan" rows="6" required
                            class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-xl text-sm text-stone-800 placeholder-stone-400 focus:bg-white focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all leading-relaxed"
                            placeholder="Tuliskan pertanyaan atau hal yang ingin Anda tanyakan secara detail kepada Pemerintah Desa Jambelaer..."></textarea>
                    </div>

                    {{-- Submit Button --}}
                    <div class="pt-4 border-t border-stone-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <p class="text-xs text-stone-400 font-light">
                            Pertanyaan akan dijawab oleh staf pelayanan desa dan jawaban dapat dilihat pada menu Riwayat Pengajuan.
                        </p>
                        <button type="submit" class="w-full sm:w-auto btn-submit-layanan">
                            <span class="btn-spinner"></span>
                            <i data-lucide="send" class="w-4 h-4 btn-icon"></i>
                            <span class="btn-text">Kirim Pertanyaan</span>
                        </button>
                    </div>
                </form>
            </div>

            {{-- ══════════════════════════════════════════════════════════
                 RIGHT: FAQ / INFORMASI
            ══════════════════════════════════════════════════════════ --}}
            <div class="lg:col-span-4 space-y-6">
                
                {{-- Jam Layanan Card --}}
                <div class="bg-forest-900 text-white rounded-3xl p-6 sm:p-7 shadow-sm">
                    <h3 class="font-display font-bold text-base text-white mb-4 flex items-center gap-2">
                        <i data-lucide="clock" class="w-5 h-5 text-sand-400"></i>
                        Waktu Tanggapan
                    </h3>
                    <p class="text-xs text-white/80 font-light leading-relaxed mb-4">
                        Pemerintah Desa Jambelaer melayani pertanyaan pada hari kerja:
                    </p>
                    <div class="bg-white/10 rounded-2xl p-4 border border-white/10 space-y-2 text-xs">
                        <div class="flex justify-between items-center text-white/90">
                            <span>Senin – Kamis</span>
                            <span class="font-bold text-sand-300">08:00 – 15:00</span>
                        </div>
                        <div class="flex justify-between items-center text-white/90">
                            <span>Jumat</span>
                            <span class="font-bold text-sand-300">08:00 – 11:30</span>
                        </div>
                        <div class="flex justify-between items-center text-white/50 pt-1 border-t border-white/10">
                            <span>Sabtu – Minggu</span>
                            <span class="text-rose-300">Libur</span>
                        </div>
                    </div>
                </div>

                {{-- Tips Pertanyaan --}}
                <div class="bg-stone-50 border border-stone-200 rounded-3xl p-6">
                    <h4 class="font-display font-bold text-sm text-stone-800 mb-2 flex items-center gap-2">
                        <i data-lucide="lightbulb" class="w-4 h-4 text-amber-500"></i>
                        Panduan Pengajuan
                    </h4>
                    <ul class="text-xs text-stone-600 font-light space-y-2 mt-3 list-disc list-inside">
                        <li>Gunakan bahasa yang sopan dan jelas.</li>
                        <li>Pastikan nomor WhatsApp aktif untuk notifikasi jawaban.</li>
                        <li>Untuk permohonan surat resmi, silakan gunakan menu <a href="{{ route('pengajuan.surat') }}" class="text-forest-700 font-bold underline">Pengajuan Surat</a>.</li>
                    </ul>
                </div>

            </div>

        </div>

    </div>
</div>

@endsection
