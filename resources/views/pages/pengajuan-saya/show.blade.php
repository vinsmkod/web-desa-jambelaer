@extends('layouts.app')

@php
    $nomorTiket = match($jenisLayanan) {
        'pengajuan_surat' => $data->nomor_pengajuan,
        'pengaduan'       => $data->nomor_pengaduan,
        'pertanyaan_umum' => $data->nomor_pertanyaan,
        'pendaftaran_umkm'=> $data->nomor_pendaftaran,
        default           => 'TIKET',
    };

    $judulHeader = match($jenisLayanan) {
        'pengajuan_surat' => $data->jenisSurat ? $data->jenisSurat->nama_surat : 'Pengajuan Surat',
        'pengaduan'       => $data->judul,
        'pertanyaan_umum' => $data->subjek,
        'pendaftaran_umkm'=> $data->nama_usaha,
        default           => 'Detail Pengajuan Layanan',
    };

    $badgeLayanan = match($jenisLayanan) {
        'pengajuan_surat' => 'Pengajuan Surat',
        'pengaduan'       => 'Pengaduan Masyarakat',
        'pertanyaan_umum' => 'Pertanyaan Umum',
        'pendaftaran_umkm'=> 'Pendaftaran UMKM',
        default           => 'Layanan',
    };

    // Edit hanya diizinkan selama pengajuan masih berstatus "diajukan"/"menunggu"
    $editable = in_array(strtolower($data->status ?? ''), ['diajukan', 'menunggu']);

    $editUrl = match($jenisLayanan) {
        'pengajuan_surat'  => $editable ? route('pengajuan.surat.edit', $data->pengajuan_surat_id) : null,
        'pengaduan'        => $editable ? route('pengaduan.edit', $data->pengaduan_id) : null,
        'pertanyaan_umum'  => $editable ? route('pertanyaan-umum.edit', $data->pertanyaan_id) : null,
        'pendaftaran_umkm' => $editable ? route('pendaftaran-umkm.edit', $data->pendaftaran_umkm_id) : null,
        default            => null,
    };
@endphp

@section('title', 'Detail ' . $nomorTiket . ' – Desa Jambelaer')
@section('meta_desc', 'Rincian status tracking, progres penanganan, dan tanggapan resmi dari Pemerintah Desa Jambelaer atas pengajuan layanan.')

@section('content')
{{-- Breadcrumb --}}
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 sm:pt-6">
    <nav class="flex items-center gap-1.5 text-xs text-stone-500 mb-4">
        <a href="{{ route('home') }}" class="hover:text-forest-800 transition-colors">Beranda</a>
        <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-stone-300"></i>
        <a href="{{ route('pengajuan.saya') }}" class="hover:text-forest-800 transition-colors">Pengajuan Saya</a>
        <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-stone-300"></i>
        <span class="text-forest-800 font-semibold">{{ $nomorTiket }}</span>
    </nav>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">

    {{-- Flash Message --}}
    @if(session('success'))
    <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 flex items-start gap-3 text-sm text-emerald-800 shadow-sm">
        <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-600 flex-shrink-0 mt-0.5"></i>
        <div>
            <p class="font-semibold">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if(session('warning'))
    <div class="mb-6 p-4 rounded-2xl bg-amber-50 border border-amber-200 flex items-start gap-3 text-sm text-amber-800 shadow-sm">
        <i data-lucide="alert-triangle" class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5"></i>
        <div>
            <p class="font-semibold">{{ session('warning') }}</p>
        </div>
    </div>
    @endif

    {{-- Main Tracking Card --}}
    <div class="bg-white rounded-3xl border border-stone-200/80 shadow-sm overflow-hidden mb-8">
        
        {{-- Card Header --}}
        <div class="p-6 sm:p-8 bg-gradient-to-r from-forest-900 to-forest-800 text-white flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="px-2.5 py-1 rounded-lg bg-white/10 text-sand-300 border border-white/15 text-xs font-mono font-bold tracking-wider">
                        {{ $nomorTiket }}
                    </span>
                    <span class="px-2.5 py-1 rounded-lg bg-forest-700/50 text-white text-xs font-medium border border-white/10">
                        {{ $badgeLayanan }}
                    </span>
                </div>
                <h1 class="font-display font-extrabold text-xl sm:text-2xl text-white">
                    {{ $judulHeader }}
                </h1>
                <p class="text-xs text-white/70 mt-1 flex items-center gap-1.5">
                    <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                    Diajukan pada {{ $data->created_at ? $data->created_at->translatedFormat('l, d F Y - H:i') : '-' }} WIB
                </p>
            </div>

            <div class="flex items-center gap-2">
                <span class="px-3.5 py-1.5 rounded-xl text-xs font-bold border {{ $data->status_badge_class }} bg-white">
                    {{ $data->status_label }}
                </span>
            </div>
        </div>

        {{-- Visual Stepper / Progress Bar --}}
        @php
            $currentStep = $data->progress_step ?? 1;
            $isDitolak = ($currentStep === -1);
        @endphp

        <div class="p-6 sm:p-8 border-b border-stone-100 bg-stone-50/50">
            <h2 class="text-xs font-bold uppercase tracking-wider text-stone-500 mb-6 flex items-center gap-2">
                <i data-lucide="activity" class="w-4 h-4 text-forest-700"></i>
                Progres Penanganan
            </h2>

            @if($isDitolak)
            {{-- Alert Ditolak --}}
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 flex items-start gap-3 text-rose-800">
                <i data-lucide="alert-octagon" class="w-5 h-5 text-rose-600 flex-shrink-0 mt-0.5"></i>
                <div>
                    <h3 class="font-bold text-sm">Pengajuan Ditolak / Memerlukan Perbaikan</h3>
                    <p class="text-xs text-rose-700 mt-1">
                        Mohon periksa bagian tanggapan administrator di bawah untuk mengetahui alasan penolakan atau hal yang perlu dilengkapi.
                    </p>
                </div>
            </div>
            @else
            {{-- Stepper Progress --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="p-3.5 rounded-2xl border {{ $currentStep >= 1 ? 'bg-white border-forest-200 shadow-xs' : 'bg-stone-100/60 border-stone-200 opacity-60' }}">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="w-5 h-5 rounded-full {{ $currentStep >= 1 ? 'bg-forest-700 text-white' : 'bg-stone-300 text-stone-600' }} flex items-center justify-center text-[10px] font-bold">1</span>
                        <span class="text-xs font-bold {{ $currentStep >= 1 ? 'text-forest-900' : 'text-stone-500' }}">Diajukan</span>
                    </div>
                    <p class="text-[11px] text-stone-400 font-light">Terekam di sistem</p>
                </div>

                <div class="p-3.5 rounded-2xl border {{ $currentStep >= 2 ? 'bg-white border-forest-200 shadow-xs' : 'bg-stone-100/60 border-stone-200 opacity-60' }}">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="w-5 h-5 rounded-full {{ $currentStep >= 2 ? 'bg-forest-700 text-white' : 'bg-stone-300 text-stone-600' }} flex items-center justify-center text-[10px] font-bold">2</span>
                        <span class="text-xs font-bold {{ $currentStep >= 2 ? 'text-forest-900' : 'text-stone-500' }}">Diverifikasi</span>
                    </div>
                    <p class="text-[11px] text-stone-400 font-light">Pemeriksaan berkas</p>
                </div>

                <div class="p-3.5 rounded-2xl border {{ $currentStep >= 3 ? 'bg-white border-forest-200 shadow-xs' : 'bg-stone-100/60 border-stone-200 opacity-60' }}">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="w-5 h-5 rounded-full {{ $currentStep >= 3 ? 'bg-forest-700 text-white' : 'bg-stone-300 text-stone-600' }} flex items-center justify-center text-[10px] font-bold">3</span>
                        <span class="text-xs font-bold {{ $currentStep >= 3 ? 'text-forest-900' : 'text-stone-500' }}">Diproses</span>
                    </div>
                    <p class="text-[11px] text-stone-400 font-light">Tindak lanjut staf</p>
                </div>

                <div class="p-3.5 rounded-2xl border {{ $currentStep >= 4 ? 'bg-white border-emerald-300 shadow-xs' : 'bg-stone-100/60 border-stone-200 opacity-60' }}">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="w-5 h-5 rounded-full {{ $currentStep >= 4 ? 'bg-emerald-600 text-white' : 'bg-stone-300 text-stone-600' }} flex items-center justify-center text-[10px] font-bold">4</span>
                        <span class="text-xs font-bold {{ $currentStep >= 4 ? 'text-emerald-950' : 'text-stone-500' }}">Selesai</span>
                    </div>
                    <p class="text-[11px] text-stone-400 font-light">Tuntas / Terbit</p>
                </div>
            </div>
            @endif
        </div>

        {{-- Tanggapan / Jawaban Administrator Section --}}
        @php
            $catatanAdmin = match($jenisLayanan) {
                'pengajuan_surat', 'pendaftaran_umkm' => $data->catatan_admin,
                'pengaduan'                           => $data->tanggapan_admin,
                'pertanyaan_umum'                     => $data->jawaban_admin,
                default                               => null,
            };
        @endphp

        @if($catatanAdmin)
        <div class="p-6 sm:p-8 bg-emerald-50/60 border-b border-emerald-100">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center flex-shrink-0 shadow-xs">
                    <i data-lucide="message-square" class="w-5 h-5"></i>
                </div>
                <div class="flex-1">
                    <span class="text-[10px] font-bold tracking-widest uppercase text-emerald-800 block mb-1">
                        Tanggapan Resmi Administrator Desa
                    </span>
                    <div class="text-sm text-stone-800 bg-white p-4 rounded-2xl border border-emerald-200/80 leading-relaxed font-normal shadow-2xs whitespace-pre-line">
                        {{ $catatanAdmin }}
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- ══════════════════════════════════════════════════════════
             DETAIL SPESIFIK SESUAI MODUL
        ══════════════════════════════════════════════════════════ --}}
        <div class="p-6 sm:p-8 space-y-6">

            @if($jenisLayanan === 'pengajuan_surat')
            {{-- Detail Pengajuan Surat --}}
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-stone-500 mb-4 flex items-center gap-2">
                    <i data-lucide="file-text" class="w-4 h-4 text-violet-700"></i>
                    Rincian Pemohon Surat
                </h3>

                <div class="grid sm:grid-cols-2 gap-4 text-xs">
                    <div class="p-4 rounded-2xl bg-stone-50 border border-stone-100">
                        <span class="text-stone-400 font-medium block">Nama Pemohon:</span>
                        <span class="text-sm font-bold text-stone-800 mt-0.5 block">{{ $data->nama_pemohon ?? Auth::user()->name }}</span>
                    </div>
                    <div class="p-4 rounded-2xl bg-stone-50 border border-stone-100">
                        <span class="text-stone-400 font-medium block">Nomor WhatsApp:</span>
                        <span class="text-sm font-bold text-stone-800 mt-0.5 block">{{ $data->no_whatsapp ?? '-' }}</span>
                    </div>
                    <div class="p-4 rounded-2xl bg-stone-50 border border-stone-100">
                        <span class="text-stone-400 font-medium block">NIK (Nomor Induk Kependudukan):</span>
                        <span class="text-sm font-bold font-mono text-stone-800 mt-0.5 block">{{ $data->nik }}</span>
                    </div>
                    <div class="p-4 rounded-2xl bg-stone-50 border border-stone-100">
                        <span class="text-stone-400 font-medium block">Nomor Kartu Keluarga (KK):</span>
                        <span class="text-sm font-bold font-mono text-stone-800 mt-0.5 block">{{ $data->no_kk }}</span>
                    </div>
                </div>

                <div class="mt-4 p-4 rounded-2xl bg-stone-50 border border-stone-100 text-xs">
                    <span class="text-stone-400 font-medium block">Alamat Domisili:</span>
                    <p class="text-sm text-stone-800 mt-1 leading-relaxed">{{ $data->alamat_pemohon }}</p>
                </div>

                <div class="mt-4 p-4 rounded-2xl bg-stone-50 border border-stone-100 text-xs">
                    <span class="text-stone-400 font-medium block">Keperluan / Tujuan Surat:</span>
                    <p class="text-sm text-stone-800 mt-1 leading-relaxed whitespace-pre-line">{{ $data->keperluan }}</p>
                </div>

                {{-- Berkas Lampiran Surat --}}
                <div class="mt-6 pt-6 border-t border-stone-100">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-stone-700 mb-3 flex items-center gap-2">
                        <i data-lucide="paperclip" class="w-4 h-4 text-forest-700"></i>
                        Berkas Persyaratan yang Diunggah
                    </h4>

                    <div class="grid sm:grid-cols-3 gap-3">
                        @if($data->file_ktp)
                        <a href="{{ asset('storage/' . $data->file_ktp) }}" target="_blank"
                            class="p-3.5 rounded-2xl border border-stone-200 hover:border-violet-400 hover:bg-violet-50/30 transition-all flex items-center gap-3 group">
                            <i data-lucide="file-check" class="w-5 h-5 text-violet-700"></i>
                            <div class="min-w-0">
                                <span class="text-xs font-bold text-stone-800 block truncate">Berkas KTP</span>
                                <span class="text-[10px] text-stone-400 group-hover:text-violet-700">Lihat Berkas &rarr;</span>
                            </div>
                        </a>
                        @endif

                        @if($data->file_kk)
                        <a href="{{ asset('storage/' . $data->file_kk) }}" target="_blank"
                            class="p-3.5 rounded-2xl border border-stone-200 hover:border-violet-400 hover:bg-violet-50/30 transition-all flex items-center gap-3 group">
                            <i data-lucide="file-check" class="w-5 h-5 text-violet-700"></i>
                            <div class="min-w-0">
                                <span class="text-xs font-bold text-stone-800 block truncate">Berkas KK</span>
                                <span class="text-[10px] text-stone-400 group-hover:text-violet-700">Lihat Berkas &rarr;</span>
                            </div>
                        </a>
                        @endif

                        @if($data->dokumen_pendukung)
                        <a href="{{ asset('storage/' . $data->dokumen_pendukung) }}" target="_blank"
                            class="p-3.5 rounded-2xl border border-stone-200 hover:border-violet-400 hover:bg-violet-50/30 transition-all flex items-center gap-3 group">
                            <i data-lucide="file-plus" class="w-5 h-5 text-violet-700"></i>
                            <div class="min-w-0">
                                <span class="text-xs font-bold text-stone-800 block truncate">Dokumen Pendukung</span>
                                <span class="text-[10px] text-stone-400 group-hover:text-violet-700">Lihat Berkas &rarr;</span>
                            </div>
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            @elseif($jenisLayanan === 'pengaduan')
            {{-- Detail Pengaduan Masyarakat --}}
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-stone-500 mb-4 flex items-center gap-2">
                    <i data-lucide="alert-triangle" class="w-4 h-4 text-rose-600"></i>
                    Rincian Laporan Pengaduan
                </h3>

                <div class="grid sm:grid-cols-2 gap-4 text-xs">
                    <div class="p-4 rounded-2xl bg-stone-50 border border-stone-100">
                        <span class="text-stone-400 font-medium block">Nama Pelapor:</span>
                        <span class="text-sm font-bold text-stone-800 mt-0.5 block">{{ $data->nama }}</span>
                    </div>
                    <div class="p-4 rounded-2xl bg-stone-50 border border-stone-100">
                        <span class="text-stone-400 font-medium block">Nomor WhatsApp:</span>
                        <span class="text-sm font-bold text-stone-800 mt-0.5 block">{{ $data->no_whatsapp ?? '-' }}</span>
                    </div>
                </div>

                @if($data->lokasi)
                <div class="mt-4 p-4 rounded-2xl bg-stone-50 border border-stone-100 text-xs">
                    <span class="text-stone-400 font-medium block">Lokasi Kejadian:</span>
                    <p class="text-sm text-stone-800 mt-1">{{ $data->lokasi }}</p>
                </div>
                @endif

                <div class="mt-4 p-4 rounded-2xl bg-stone-50 border border-stone-100 text-xs">
                    <span class="text-stone-400 font-medium block">Uraian Pengaduan:</span>
                    <p class="text-sm text-stone-800 mt-1 leading-relaxed whitespace-pre-line">{{ $data->isi_pengaduan }}</p>
                </div>

                @if($data->foto_bukti)
                <div class="mt-6 pt-6 border-t border-stone-100">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-stone-700 mb-3">Foto Bukti Lampiran:</h4>
                    <div class="max-w-md rounded-2xl overflow-hidden border border-stone-200">
                        <img src="{{ asset('storage/' . $data->foto_bukti) }}" alt="Foto Bukti Pengaduan" class="w-full max-h-80 object-cover">
                    </div>
                </div>
                @endif
            </div>

            @elseif($jenisLayanan === 'pertanyaan_umum')
            {{-- Detail Pertanyaan Umum --}}
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-stone-500 mb-4 flex items-center gap-2">
                    <i data-lucide="help-circle" class="w-4 h-4 text-sky-600"></i>
                    Rincian Pertanyaan
                </h3>

                <div class="grid sm:grid-cols-2 gap-4 text-xs">
                    <div class="p-4 rounded-2xl bg-stone-50 border border-stone-100">
                        <span class="text-stone-400 font-medium block">Nama Penanya:</span>
                        <span class="text-sm font-bold text-stone-800 mt-0.5 block">{{ $data->nama }}</span>
                    </div>
                    <div class="p-4 rounded-2xl bg-stone-50 border border-stone-100">
                        <span class="text-stone-400 font-medium block">Nomor WhatsApp:</span>
                        <span class="text-sm font-bold text-stone-800 mt-0.5 block">{{ $data->no_whatsapp ?? '-' }}</span>
                    </div>
                </div>

                <div class="mt-4 p-4 rounded-2xl bg-stone-50 border border-stone-100 text-xs">
                    <span class="text-stone-400 font-medium block">Isi Pertanyaan:</span>
                    <p class="text-sm text-stone-800 mt-1 leading-relaxed whitespace-pre-line">{{ $data->pertanyaan }}</p>
                </div>
            </div>

            @elseif($jenisLayanan === 'pendaftaran_umkm')
            {{-- Detail Pendaftaran UMKM --}}
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-stone-500 mb-4 flex items-center gap-2">
                    <i data-lucide="store" class="w-4 h-4 text-emerald-600"></i>
                    Rincian Profil Usaha UMKM
                </h3>

                <div class="grid sm:grid-cols-2 gap-4 text-xs">
                    <div class="p-4 rounded-2xl bg-stone-50 border border-stone-100">
                        <span class="text-stone-400 font-medium block">Nama Usaha / Merk:</span>
                        <span class="text-sm font-bold text-stone-800 mt-0.5 block">{{ $data->nama_usaha }}</span>
                    </div>
                    <div class="p-4 rounded-2xl bg-stone-50 border border-stone-100">
                        <span class="text-stone-400 font-medium block">Nama Pemilik:</span>
                        <span class="text-sm font-bold text-stone-800 mt-0.5 block">{{ $data->nama_pemilik }}</span>
                    </div>
                    <div class="p-4 rounded-2xl bg-stone-50 border border-stone-100">
                        <span class="text-stone-400 font-medium block">Kategori Produk:</span>
                        <span class="text-sm font-bold text-stone-800 mt-0.5 block">{{ $data->produk }}</span>
                    </div>
                    <div class="p-4 rounded-2xl bg-stone-50 border border-stone-100">
                        <span class="text-stone-400 font-medium block">WhatsApp Pemesanan:</span>
                        <span class="text-sm font-bold text-stone-800 mt-0.5 block">{{ $data->nomor_whatsapp }}</span>
                    </div>
                </div>

                <div class="mt-4 p-4 rounded-2xl bg-stone-50 border border-stone-100 text-xs">
                    <span class="text-stone-400 font-medium block">Alamat Usaha:</span>
                    <p class="text-sm text-stone-800 mt-1">{{ $data->alamat_usaha }}</p>
                </div>

                <div class="mt-4 p-4 rounded-2xl bg-stone-50 border border-stone-100 text-xs">
                    <span class="text-stone-400 font-medium block">Deskripsi Usaha:</span>
                    <p class="text-sm text-stone-800 mt-1 leading-relaxed whitespace-pre-line">{{ $data->deskripsi_usaha }}</p>
                </div>

                {{-- Status Publikasi di Produk --}}
                @if($data->produkDipublikasikan)
                <div class="mt-4 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <i data-lucide="check-circle" class="w-5 h-5 text-emerald-700"></i>
                        <div>
                            <span class="text-xs font-bold text-emerald-950 block">UMKM Sudah Dipublikasikan</span>
                            <span class="text-[11px] text-emerald-800 font-light">Tampil resmi di etalase produk website desa.</span>
                        </div>
                    </div>
                    <a href="{{ route('umkm.detail', $data->produkDipublikasikan->slug) }}" target="_blank"
                        class="btn-primary !bg-emerald-700 !border-emerald-700 text-xs py-2 px-3.5">
                        Lihat di Katalog UMKM &rarr;
                    </a>
                </div>
                @endif

                {{-- Foto Produk UMKM --}}
                @if($data->foto_produk)
                <div class="mt-6 pt-6 border-t border-stone-100">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-stone-700 mb-3">Foto Produk:</h4>
                    <div class="max-w-xs rounded-2xl overflow-hidden border border-stone-200">
                        <img src="{{ $data->foto_produk_url }}" alt="Foto Produk {{ $data->nama_usaha }}" class="w-full h-48 object-cover">
                    </div>
                </div>
                @endif
            </div>
            @endif

        </div>

        {{-- Footer Actions --}}
        <div class="p-6 bg-stone-50 border-t border-stone-100 flex flex-col sm:flex-row items-center justify-between gap-3">
            <a href="{{ route('pengajuan.saya') }}" class="btn-secondary text-xs">
                &larr; Kembali ke Daftar Pengajuan
            </a>

            <div class="flex items-center gap-2 flex-wrap justify-center">
                @if($editUrl)
                <a href="{{ $editUrl }}" class="btn-primary !bg-amber-500 !border-amber-500 hover:!bg-amber-600 hover:!border-amber-600 text-xs">
                    <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                    Edit Pengajuan
                </a>
                @endif

                <a href="{{ route('kontak') }}#layanan-hub" class="btn-primary text-xs">
                    Buat Pengajuan Lain
                </a>
            </div>
        </div>

    </div>

</div>
@endsection
