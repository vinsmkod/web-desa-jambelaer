@extends('admin.layouts.admin')

@section('title', 'Detail Pengaduan - ' . $pengaduan->nomor_pengaduan)
@section('header_title', 'Detail Pengaduan Masyarakat')

@section('content')
<div class="space-y-6 max-w-5xl">

    {{-- Breadcrumb & Back --}}
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.pengaduan.index') }}" class="btn-secondary text-xs">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            Kembali ke Daftar Pengaduan
        </a>

        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold border {{ $pengaduan->status_badge_class }}">
            {{ $pengaduan->status_label }}
        </span>
    </div>

    {{-- Detail Card --}}
    <div class="page-card">
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-slate-50/50">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-rose-700 bg-rose-50 px-2 py-0.5 rounded-md border border-rose-100">
                    Pengaduan Masyarakat
                </span>
                <h1 class="text-lg font-bold text-slate-900 mt-1 font-display">{{ $pengaduan->judul }}</h1>
                <p class="text-xs text-slate-400 mt-0.5">Nomor: {{ $pengaduan->nomor_pengaduan }} &bull; Dilaporkan pada {{ $pengaduan->created_at ? $pengaduan->created_at->translatedFormat('l, d F Y - H:i') : '-' }} WIB</p>
            </div>
            @if($pengaduan->no_whatsapp)
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pengaduan->no_whatsapp) }}" target="_blank"
                class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold hover:bg-emerald-100 transition-all">
                <i data-lucide="message-circle" class="w-4 h-4"></i>
                WhatsApp Pelapor
            </a>
            @endif
        </div>

        <div class="p-6 space-y-6">
            {{-- Data Pelapor --}}
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Identitas Pelapor</h3>
                <div class="grid sm:grid-cols-3 gap-4 text-xs">
                    <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-slate-400 block font-medium">Nama Pelapor:</span>
                        <span class="text-sm font-bold text-slate-800 mt-0.5 block">{{ $pengaduan->nama }}</span>
                    </div>
                    <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-slate-400 block font-medium">Nomor WhatsApp:</span>
                        <span class="text-sm font-bold text-slate-800 mt-0.5 block">{{ $pengaduan->no_whatsapp ?? '-' }}</span>
                    </div>
                    <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-slate-400 block font-medium">Email Pelapor:</span>
                        <span class="text-sm font-bold text-slate-800 mt-0.5 block truncate">{{ $pengaduan->email ?: '-' }}</span>
                    </div>
                </div>

                @if($pengaduan->lokasi)
                <div class="mt-3 p-3.5 bg-slate-50 rounded-xl border border-slate-100 text-xs">
                    <span class="text-slate-400 block font-medium">Lokasi Permasalahan:</span>
                    <p class="text-sm text-slate-800 mt-0.5">{{ $pengaduan->lokasi }}</p>
                </div>
                @endif

                <div class="mt-3 p-3.5 bg-slate-50 rounded-xl border border-slate-100 text-xs">
                    <span class="text-slate-400 block font-medium">Isi Pengaduan / Keluhan:</span>
                    <p class="text-sm text-slate-800 mt-1 leading-relaxed whitespace-pre-line">{{ $pengaduan->isi_pengaduan }}</p>
                </div>
            </div>

            {{-- Foto Bukti --}}
            @if($pengaduan->foto_bukti)
            <div class="pt-4 border-t border-slate-100">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Foto Bukti Pengaduan</h3>
                <div class="max-w-md rounded-2xl overflow-hidden border border-slate-200">
                    <img src="{{ asset('storage/' . $pengaduan->foto_bukti) }}" alt="Foto Bukti" class="w-full max-h-96 object-cover">
                </div>
            </div>
            @endif

            {{-- Form Tanggapan & Status --}}
            <div class="pt-6 border-t border-slate-100 bg-slate-50/50 p-5 rounded-2xl border">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-3 flex items-center gap-2">
                    <i data-lucide="message-square" class="w-4 h-4 text-forest-700"></i>
                    Tindak Lanjut & Tanggapan Administrator (SRS-F-011)
                </h3>

                <form action="{{ route('admin.pengaduan.status', $pengaduan) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label for="status" class="form-label">Status Penanganan</label>
                            <select name="status" id="status" class="form-input">
                                <option value="diajukan" {{ $pengaduan->status === 'diajukan' ? 'selected' : '' }}>Diajukan (Laporan Diterima)</option>
                                <option value="diproses" {{ $pengaduan->status === 'diproses' ? 'selected' : '' }}>Diproses (Sedang Ditindaklanjuti)</option>
                                <option value="selesai" {{ $pengaduan->status === 'selesai' ? 'selected' : '' }}>Selesai (Penanganan Tuntas)</option>
                                <option value="ditolak" {{ $pengaduan->status === 'ditolak' ? 'selected' : '' }}>Ditolak / Tidak Memenuhi Kriteria</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="tanggapan_admin" class="form-label">Tanggapan Resmi Administrator untuk Warga</label>
                        <textarea name="tanggapan_admin" id="tanggapan_admin" rows="4" class="form-input"
                            placeholder="Tuliskan tindak lanjut atau tanggapan resmi Pemerintah Desa atas laporan pengaduan ini...">{{ old('tanggapan_admin', $pengaduan->tanggapan_admin) }}</textarea>
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <button type="submit" class="btn-primary text-xs">
                            <i data-lucide="save" class="w-3.5 h-3.5"></i>
                            Simpan Tanggapan & Status
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

</div>
@endsection
