@extends('layouts.app')

@section('title', 'Pengajuan Surat Keterangan | Pelayanan Masyarakat Desa Jambelaer')
@section('meta_desc', 'Layanan resmi pengajuan surat keterangan dan pernyataan masyarakat Desa Jambelaer, Kecamatan Dawuan, Kabupaten Subang secara digital dan transparan.')

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "BreadcrumbList",
  "itemListElement": [
    { "@@type": "ListItem", "position": 1, "name": "Beranda", "item": "{{ config('app.url') }}" },
    { "@@type": "ListItem", "position": 2, "name": "Pengajuan Surat", "item": "{{ config('app.url') }}/pengajuan-surat" }
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
        <span class="text-forest-800 font-semibold">Pengajuan Surat</span>
    </nav>
</div>

<div class="relative h-60 sm:h-72 lg:h-80 overflow-hidden bg-forest-900 rounded-[28px] sm:rounded-[32px] mx-3 sm:mx-5 lg:mx-6 shadow-sm">
    <img src="{{ asset('uploads/img/beranda.jpeg') }}"
        alt="Pelayanan Surat Desa Jambelaer" class="w-full h-full object-cover opacity-50">
    <div class="absolute inset-0 bg-gradient-to-t from-forest-950/95 via-forest-900/60 to-forest-900/30"></div>
    <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
        <span class="section-label !bg-white/10 !text-sand-300 !border-white/20">Layanan Administrasi Kependudukan</span>
        <h1 class="font-display font-extrabold text-3xl sm:text-4xl lg:text-5xl text-white mt-3">Pengajuan Surat Desa</h1>
        <p class="text-xs sm:text-sm text-white/75 mt-2 font-light max-w-lg">
            Ajukan permohonan surat keterangan atau surat pernyataan resmi Pemerintah Desa Jambelaer dengan mudah, aman, dan dapat dilacak langsung.
        </p>
    </div>
</div>

<div class="bg-white pb-24 pt-10">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        @auth
        {{-- Logged-in Banner --}}
        <div class="mb-8 p-4 sm:p-5 rounded-2xl bg-forest-50 border border-forest-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-xs">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-forest-800 text-sand-300 flex items-center justify-center flex-shrink-0">
                    <i data-lucide="user-check" class="w-5 h-5"></i>
                </div>
                <div>
                    <span class="text-[10px] font-bold tracking-widest uppercase text-forest-700 block">Pemohon Terautentikasi</span>
                    <p class="text-sm font-bold text-forest-950">{{ Auth::user()->name }} <span class="text-xs font-normal text-forest-700">({{ Auth::user()->email }})</span></p>
                </div>
            </div>
            <a href="{{ route('pengajuan.saya') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-white border border-forest-200 text-xs font-bold text-forest-800 hover:bg-forest-100 transition-all shadow-2xs">
                <i data-lucide="clock" class="w-3.5 h-3.5 text-forest-700"></i>
                Lihat Riwayat Pengajuan
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
                    <h4 class="text-sm font-bold text-amber-950">Masuk untuk Mengajukan Surat</h4>
                    <p class="text-xs text-amber-800 font-light mt-0.5">Silakan masuk ke akun Anda agar pengajuan surat dapat diverifikasi dan riwayatnya terpantau secara mandiri.</p>
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
                 LEFT: FORMULIR PENGAJUAN
            ══════════════════════════════════════════════════════════ --}}
            <div class="lg:col-span-8 bg-white border border-stone-200 rounded-3xl p-6 sm:p-8 shadow-xs">
                
                <div class="border-b border-stone-100 pb-5 mb-6">
                    <span class="text-[10px] font-bold tracking-widest uppercase text-forest-700 bg-forest-50 px-2.5 py-1 rounded-md border border-forest-100">
                        Formulir Permohonan
                    </span>
                    <h2 class="font-display font-extrabold text-xl sm:text-2xl text-stone-900 mt-2">
                        Data Pengajuan & Persyaratan Surat
                    </h2>
                    <p class="text-xs text-stone-500 font-light mt-1">
                        Pilih jenis surat yang dibutuhkan, lengkapi identitas pemohon, dan unggah dokumen persyaratan KTP serta KK.
                    </p>
                </div>

                <form action="{{ route('pengajuan.surat.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    {{-- 1. Pilihan Jenis Surat --}}
                    <div>
                        <label for="jenis_surat_id" class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-2">
                            Pilih Jenis Surat <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <select id="jenis_surat_id" name="jenis_surat_id" required
                                class="w-full pl-4 pr-10 py-3.5 rounded-xl border border-stone-200 bg-stone-50/50 text-stone-800 text-sm font-semibold focus:bg-white focus:border-forest-700 focus:ring-2 focus:ring-forest-100 outline-none transition-all cursor-pointer appearance-none">
                                <option value="">— Pilih Jenis Surat Keterangan / Pernyataan —</option>
                                @foreach($jenisSurat as $js)
                                    <option value="{{ $js->id }}" 
                                        data-desc="{{ $js->deskripsi }}" 
                                        data-syarat="{{ $js->persyaratan_khusus }}"
                                        {{ (old('jenis_surat_id', $selectedSurat->id ?? '') == $js->id) ? 'selected' : '' }}>
                                        {{ $js->nama_surat }} {{ $js->kode_surat ? '('.$js->kode_surat.')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            <i data-lucide="chevron-down" class="w-4 h-4 absolute right-4 top-4 text-stone-400 pointer-events-none"></i>
                        </div>

                        {{-- Dynamic Info Card for Selected Surat --}}
                        <div id="surat-info-card" class="mt-3 p-4 rounded-2xl bg-amber-50/80 border border-amber-200/80 text-xs {{ old('jenis_surat_id', $selectedSurat->id ?? '') ? '' : 'hidden' }}">
                            <div class="flex items-start gap-2.5">
                                <i data-lucide="info" class="w-4 h-4 text-amber-700 flex-shrink-0 mt-0.5"></i>
                                <div class="space-y-1">
                                    <p id="surat-info-desc" class="text-stone-700 font-medium leading-relaxed"></p>
                                    <p id="surat-info-syarat" class="text-amber-900 font-semibold"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 2. Data Identitas Pemohon --}}
                    <div class="pt-4 border-t border-stone-100">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-stone-400 mb-4 flex items-center gap-1.5">
                            <i data-lucide="id-card" class="w-4 h-4 text-forest-700"></i>
                            Identitas Pemohon
                        </h3>

                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block text-xs font-semibold text-stone-600 mb-1.5">Nama Lengkap Sesuai KTP <span class="text-rose-500">*</span></label>
                                <input type="text" id="name" name="name" required value="{{ old('name', Auth::user()->name ?? '') }}"
                                    class="w-full px-4 py-3 rounded-xl border border-stone-200 text-sm font-medium text-stone-800 bg-stone-50/50 focus:bg-white focus:border-forest-700 focus:ring-2 focus:ring-forest-100 outline-none transition-all">
                            </div>

                            <div>
                                <label for="no_whatsapp" class="block text-xs font-semibold text-stone-600 mb-1.5">Nomor WhatsApp Aktif <span class="text-rose-500">*</span></label>
                                <input type="tel" id="no_whatsapp" name="no_whatsapp" required placeholder="cth: 081234567890" value="{{ old('no_whatsapp') }}"
                                    class="w-full px-4 py-3 rounded-xl border border-stone-200 text-sm font-medium text-stone-800 bg-stone-50/50 focus:bg-white focus:border-forest-700 focus:ring-2 focus:ring-forest-100 outline-none transition-all">
                                <p class="text-[10px] text-stone-400 mt-1">Digunakan untuk informasi jadwal pengambilan surat yang sudah jadi.</p>
                            </div>

                            <div>
                                <label for="nik" class="block text-xs font-semibold text-stone-600 mb-1.5">NIK (16 Digit) <span class="text-rose-500">*</span></label>
                                <input type="text" id="nik" name="nik" required maxlength="16" pattern="[0-9]{16}" placeholder="cth: 3212010101900001" value="{{ old('nik') }}"
                                    class="w-full px-4 py-3 rounded-xl border border-stone-200 text-sm font-medium text-stone-800 bg-stone-50/50 focus:bg-white focus:border-forest-700 focus:ring-2 focus:ring-forest-100 outline-none transition-all font-mono">
                            </div>

                            <div>
                                <label for="no_kk" class="block text-xs font-semibold text-stone-600 mb-1.5">Nomor Kartu Keluarga (16 Digit) <span class="text-rose-500">*</span></label>
                                <input type="text" id="no_kk" name="no_kk" required maxlength="16" pattern="[0-9]{16}" placeholder="cth: 3212010101000002" value="{{ old('no_kk') }}"
                                    class="w-full px-4 py-3 rounded-xl border border-stone-200 text-sm font-medium text-stone-800 bg-stone-50/50 focus:bg-white focus:border-forest-700 focus:ring-2 focus:ring-forest-100 outline-none transition-all font-mono">
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="alamat_pemohon" class="block text-xs font-semibold text-stone-600 mb-1.5">Alamat Domisili Lengkap <span class="text-rose-500">*</span></label>
                            <textarea id="alamat_pemohon" name="alamat_pemohon" rows="2" required placeholder="cth: Kp. Melong RT 03 RW 02, Desa Jambelaer, Kec. Dawuan"
                                class="w-full px-4 py-3 rounded-xl border border-stone-200 text-sm font-medium text-stone-800 bg-stone-50/50 focus:bg-white focus:border-forest-700 focus:ring-2 focus:ring-forest-100 outline-none transition-all resize-none">{{ old('alamat_pemohon') }}</textarea>
                        </div>
                    </div>

                    {{-- 3. Keperluan Pengajuan --}}
                    <div class="pt-4 border-t border-stone-100">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-stone-400 mb-4 flex items-center gap-1.5">
                            <i data-lucide="file-text" class="w-4 h-4 text-forest-700"></i>
                            Tujuan & Keperluan Surat
                        </h3>

                        <div>
                            <label for="keperluan" class="block text-xs font-semibold text-stone-600 mb-1.5">Keperluan Pembuatan Surat <span class="text-rose-500">*</span></label>
                            <textarea id="keperluan" name="keperluan" rows="3" required placeholder="Jelaskan untuk keperluan apa surat ini diajukan (cth: Pengajuan pinjaman modal usaha di Bank BRI, permohonan beasiswa kuliah, persyaratan pendaftaran kerja, dsb.)"
                                class="w-full px-4 py-3 rounded-xl border border-stone-200 text-sm font-medium text-stone-800 bg-stone-50/50 focus:bg-white focus:border-forest-700 focus:ring-2 focus:ring-forest-100 outline-none transition-all resize-none">{{ old('keperluan') }}</textarea>
                        </div>

                        <div class="mt-4">
                            <label for="keterangan_tambahan" class="block text-xs font-semibold text-stone-600 mb-1.5">Catatan / Data Tambahan <span class="text-stone-400 font-normal">(Opsional)</span></label>
                            <textarea id="keterangan_tambahan" name="keterangan_tambahan" rows="2" placeholder="Jika jenis surat membutuhkan data khusus (misal untuk SKU: sebutkan nama usaha dan jenis barang/jasa yang dijual)"
                                class="w-full px-4 py-3 rounded-xl border border-stone-200 text-sm font-medium text-stone-800 bg-stone-50/50 focus:bg-white focus:border-forest-700 focus:ring-2 focus:ring-forest-100 outline-none transition-all resize-none">{{ old('keterangan_tambahan') }}</textarea>
                        </div>
                    </div>

                    {{-- 4. Unggah Persyaratan (KTP, KK, Dokumen Pendukung) --}}
                    <div class="pt-4 border-t border-stone-100">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-stone-400 flex items-center gap-1.5">
                                <i data-lucide="paperclip" class="w-4 h-4 text-forest-700"></i>
                                Unggah Berkas Persyaratan
                            </h3>
                            <span class="text-[11px] text-stone-400">Format: JPG, PNG, WEBP, PDF (Maks. 5 MB)</span>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-4">
                            {{-- File KTP --}}
                            <div class="p-4 rounded-2xl border-2 border-dashed border-stone-200 bg-stone-50/40 hover:border-forest-400 hover:bg-forest-50/20 transition-all text-center group cursor-pointer"
                                onclick="document.getElementById('file_ktp').click()">
                                <div class="w-10 h-10 rounded-xl bg-forest-100/70 text-forest-800 flex items-center justify-center mx-auto mb-2 group-hover:scale-105 transition-transform">
                                    <i data-lucide="credit-card" class="w-5 h-5"></i>
                                </div>
                                <span class="block text-xs font-bold text-stone-800">Foto / Scan KTP <span class="text-rose-500">*</span></span>
                                <span id="label-file-ktp" class="block text-[11px] text-stone-400 mt-0.5">Klik untuk memilih file</span>
                                <input type="file" id="file_ktp" name="file_ktp" required accept=".jpeg,.jpg,.png,.webp,.pdf" class="hidden"
                                    onchange="updateFileName(this, 'label-file-ktp')">
                            </div>

                            {{-- File KK --}}
                            <div class="p-4 rounded-2xl border-2 border-dashed border-stone-200 bg-stone-50/40 hover:border-forest-400 hover:bg-forest-50/20 transition-all text-center group cursor-pointer"
                                onclick="document.getElementById('file_kk').click()">
                                <div class="w-10 h-10 rounded-xl bg-sand-100 text-sand-800 flex items-center justify-center mx-auto mb-2 group-hover:scale-105 transition-transform">
                                    <i data-lucide="users" class="w-5 h-5"></i>
                                </div>
                                <span class="block text-xs font-bold text-stone-800">Foto / Scan Kartu Keluarga <span class="text-rose-500">*</span></span>
                                <span id="label-file-kk" class="block text-[11px] text-stone-400 mt-0.5">Klik untuk memilih file</span>
                                <input type="file" id="file_kk" name="file_kk" required accept=".jpeg,.jpg,.png,.webp,.pdf" class="hidden"
                                    onchange="updateFileName(this, 'label-file-kk')">
                            </div>
                        </div>

                        {{-- Dokumen Pendukung Lainnya --}}
                        <div class="mt-4 p-4 rounded-2xl border border-stone-200 bg-stone-50/30 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-stone-200/70 text-stone-600 flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="file-plus" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <span class="text-xs font-bold text-stone-800 block">Dokumen Pendukung Lainnya <span class="text-stone-400 font-normal">(Opsional)</span></span>
                                    <span id="label-file-pendukung" class="text-[11px] text-stone-400 block">Surat pengantar RT/RW, foto tempat usaha (SKU), surat kematian, dll.</span>
                                </div>
                            </div>
                            <button type="button" onclick="document.getElementById('dokumen_pendukung').click()"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white border border-stone-300 text-xs font-semibold text-stone-700 hover:bg-stone-50 transition-all whitespace-nowrap shadow-2xs">
                                <i data-lucide="upload" class="w-3.5 h-3.5"></i>
                                Pilih Berkas
                            </button>
                            <input type="file" id="dokumen_pendukung" name="dokumen_pendukung" accept=".jpeg,.jpg,.png,.webp,.pdf" class="hidden"
                                onchange="updateFileName(this, 'label-file-pendukung')">
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="pt-6 border-t border-stone-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <p class="text-[11px] text-stone-400 font-light leading-relaxed">
                            Dengan mengirimkan formulir ini, Anda menyatakan bahwa data yang diisi adalah benar dan sah sesuai dokumen kependudukan asli.
                        </p>
                        <button type="submit" class="w-full sm:w-auto btn-primary px-8 py-3.5 text-xs font-bold justify-center shadow-md">
                            <i data-lucide="send" class="w-4 h-4"></i>
                            Kirim Pengajuan Surat
                        </button>
                    </div>
                </form>
            </div>

            {{-- ══════════════════════════════════════════════════════════
                 RIGHT: PANDUAN & ALUR PELAYANAN
            ══════════════════════════════════════════════════════════ --}}
            <div class="lg:col-span-4 space-y-5">
                
                {{-- Alur Pelayanan Card --}}
                <div class="bg-forest-900 text-white rounded-3xl p-6 sm:p-7 shadow-xs">
                    <span class="text-[10px] font-bold tracking-widest uppercase text-sand-400 block mb-2">Prosedur Resmi</span>
                    <h3 class="font-display font-bold text-lg text-white mb-5 pb-4 border-b border-white/10">
                        Alur Pelayanan Surat
                    </h3>

                    <div class="space-y-4">
                        <div class="flex items-start gap-3.5">
                            <div class="w-7 h-7 rounded-lg bg-white/10 border border-white/15 text-sand-300 flex items-center justify-center text-xs font-bold flex-shrink-0">
                                1
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-white">Kirim Permohonan</h4>
                                <p class="text-[11px] text-white/70 font-light mt-0.5 leading-relaxed">Pilih jenis surat dan unggah foto/scan KTP serta KK Anda secara lengkap.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3.5">
                            <div class="w-7 h-7 rounded-lg bg-white/10 border border-white/15 text-sand-300 flex items-center justify-center text-xs font-bold flex-shrink-0">
                                2
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-white">Verifikasi Petugas Desa</h4>
                                <p class="text-[11px] text-white/70 font-light mt-0.5 leading-relaxed">Staf pelayanan memeriksa kesesuaian data kependudukan dan kelengkapan dokumen.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3.5">
                            <div class="w-7 h-7 rounded-lg bg-white/10 border border-white/15 text-sand-300 flex items-center justify-center text-xs font-bold flex-shrink-0">
                                3
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-white">Pemrosesan Dokumen</h4>
                                <p class="text-[11px] text-white/70 font-light mt-0.5 leading-relaxed">Surat diproses dan diajukan penandatanganan kepada Kepala Desa / Pejabat yang berwenang.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3.5">
                            <div class="w-7 h-7 rounded-lg bg-sand-500 text-forest-950 flex items-center justify-center text-xs font-bold flex-shrink-0 shadow-xs">
                                4
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-sand-300">Surat Siap Diambil</h4>
                                <p class="text-[11px] text-white/70 font-light mt-0.5 leading-relaxed">Status pada website berubah menjadi <strong>Selesai</strong>. Anda dapat mengambil surat fisik di Kantor Desa.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Ketentuan WhatsApp & Pengambilan Card --}}
                <div class="bg-white border border-stone-200 rounded-3xl p-6 shadow-xs">
                    <div class="flex items-center gap-2 mb-3">
                        <i data-lucide="message-circle" class="w-5 h-5 text-emerald-600"></i>
                        <h4 class="font-display font-bold text-sm text-stone-800">Media Komunikasi Tambahan</h4>
                    </div>
                    <p class="text-xs text-stone-500 font-light leading-relaxed">
                        Sistem pelacakan utama berjalan pada website ini. Nomor WhatsApp yang Anda daftarkan hanya digunakan staf pelayanan sebagai media komunikasi pendukung, misalnya untuk memberi kabar saat dokumen fisik surat telah selesai dan siap diambil di kantor desa.
                    </p>
                </div>

                {{-- Jam Layanan Kantor Desa --}}
                <div class="bg-sand-50 border border-sand-100 rounded-3xl p-6 shadow-xs">
                    <div class="flex items-center gap-2 mb-3">
                        <i data-lucide="clock" class="w-5 h-5 text-sand-700"></i>
                        <h4 class="font-display font-bold text-sm text-stone-800">Jam Pelayanan Kantor Desa</h4>
                    </div>
                    <div class="space-y-2 text-xs text-stone-600">
                        <div class="flex justify-between py-1 border-b border-sand-200/60">
                            <span>Senin – Kamis</span>
                            <span class="font-semibold text-stone-800">08:00 – 15:30 WIB</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-sand-200/60">
                            <span>Jumat</span>
                            <span class="font-semibold text-stone-800">08:00 – 11:30 WIB</span>
                        </div>
                        <div class="flex justify-between py-1">
                            <span>Sabtu – Minggu</span>
                            <span class="font-semibold text-rose-600">Libur</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
    // Dinamis info jenis surat
    const selectSurat = document.getElementById('jenis_surat_id');
    const infoCard = document.getElementById('surat-info-card');
    const descText = document.getElementById('surat-info-desc');
    const syaratText = document.getElementById('surat-info-syarat');

    function updateSuratInfo() {
        const selected = selectSurat.options[selectSurat.selectedIndex];
        if (selected && selected.value) {
            const desc = selected.getAttribute('data-desc');
            const syarat = selected.getAttribute('data-syarat');

            descText.textContent = desc ? desc : 'Surat keterangan resmi yang diterbitkan oleh Pemerintah Desa Jambelaer.';
            syaratText.textContent = syarat ? 'Persyaratan khusus: ' + syarat : 'Persyaratan utama: Lampirkan foto/scan KTP dan Kartu Keluarga (KK).';
            infoCard.classList.remove('hidden');
        } else {
            infoCard.classList.add('hidden');
        }
    }

    if (selectSurat) {
        selectSurat.addEventListener('change', updateSuratInfo);
        updateSuratInfo();
    }

    // Helper tampilan nama file yang diunggah
    function updateFileName(input, labelId) {
        const label = document.getElementById(labelId);
        if (input.files && input.files[0]) {
            const fileName = input.files[0].name;
            const fileSize = (input.files[0].size / (1024 * 1024)).toFixed(2);
            label.textContent = `✓ ${fileName} (${fileSize} MB)`;
            label.classList.remove('text-stone-400');
            label.classList.add('text-forest-800', 'font-semibold');
        }
    }
</script>
@endpush

@endsection
