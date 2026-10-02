@extends('admin.layouts.admin')

@section('title', 'Detail Pengajuan Surat - ' . $pengajuanSurat->nomor_pengajuan)
@section('header_title', 'Detail Pengajuan Surat')

@section('content')
<div class="space-y-6 max-w-5xl">

    {{-- Breadcrumb & Back --}}
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.pengajuan-surat.index') }}" class="btn-secondary text-xs">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            Kembali ke Daftar Surat
        </a>

        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold border {{ $pengajuanSurat->status_badge_class }}">
            {{ $pengajuanSurat->status_label }}
        </span>
    </div>

    {{-- Detail Card --}}
    <div class="page-card">
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-slate-50/50">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-violet-700 bg-violet-50 px-2 py-0.5 rounded-md border border-violet-100">
                    {{ $pengajuanSurat->jenisSurat->nama_surat ?? 'Surat Desa' }}
                </span>
                <h1 class="text-lg font-bold text-slate-900 mt-1 font-display">Pengajuan Nomor: {{ $pengajuanSurat->nomor_pengajuan }}</h1>
                <p class="text-xs text-slate-400 mt-0.5">Diajukan pada {{ $pengajuanSurat->created_at ? $pengajuanSurat->created_at->translatedFormat('l, d F Y - H:i') : '-' }} WIB</p>
            </div>
            @if($pengajuanSurat->no_whatsapp)
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pengajuanSurat->no_whatsapp) }}" target="_blank"
                class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold hover:bg-emerald-100 transition-all">
                <i data-lucide="message-circle" class="w-4 h-4"></i>
                Hubungi Pemohon (WhatsApp)
            </a>
            @endif
        </div>

        <div class="p-6 space-y-6">
            {{-- Data Pemohon Grid --}}
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Identitas Pemohon</h3>
                <div class="grid sm:grid-cols-2 gap-4 text-xs">
                    <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-slate-400 block font-medium">Nama Pemohon:</span>
                        <span class="text-sm font-bold text-slate-800 mt-0.5 block">{{ $pengajuanSurat->nama_pemohon ?? ($pengajuanSurat->user->name ?? '-') }}</span>
                    </div>
                    <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-slate-400 block font-medium">Nomor WhatsApp:</span>
                        <span class="text-sm font-bold text-slate-800 mt-0.5 block">{{ $pengajuanSurat->no_whatsapp ?? '-' }}</span>
                    </div>
                    <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-slate-400 block font-medium">NIK:</span>
                        <span class="text-sm font-bold font-mono text-slate-800 mt-0.5 block">{{ $pengajuanSurat->nik }}</span>
                    </div>
                    <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-slate-400 block font-medium">Nomor Kartu Keluarga (KK):</span>
                        <span class="text-sm font-bold font-mono text-slate-800 mt-0.5 block">{{ $pengajuanSurat->no_kk }}</span>
                    </div>
                </div>

                <div class="mt-3 p-3.5 bg-slate-50 rounded-xl border border-slate-100 text-xs">
                    <span class="text-slate-400 block font-medium">Alamat Domisili:</span>
                    <p class="text-sm text-slate-800 mt-0.5">{{ $pengajuanSurat->alamat_pemohon }}</p>
                </div>

                <div class="mt-3 p-3.5 bg-slate-50 rounded-xl border border-slate-100 text-xs">
                    <span class="text-slate-400 block font-medium">Keperluan Surat:</span>
                    <p class="text-sm text-slate-800 mt-0.5 whitespace-pre-line">{{ $pengajuanSurat->keperluan }}</p>
                </div>

                @if($pengajuanSurat->keterangan_tambahan)
                <div class="mt-3 p-3.5 bg-slate-50 rounded-xl border border-slate-100 text-xs">
                    <span class="text-slate-400 block font-medium">Keterangan Tambahan Pemohon:</span>
                    <p class="text-sm text-slate-800 mt-0.5">{{ $pengajuanSurat->keterangan_tambahan }}</p>
                </div>
                @endif
            </div>

            {{-- Berkas Lampiran --}}
            <div class="pt-4 border-t border-slate-100">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Berkas Persyaratan yang Diunggah</h3>
                <div class="grid sm:grid-cols-3 gap-3">
                    @if($pengajuanSurat->file_ktp)
                    <a href="{{ asset('storage/' . $pengajuanSurat->file_ktp) }}" target="_blank"
                        class="p-4 rounded-xl border border-slate-200 hover:border-violet-500 hover:bg-violet-50/20 transition-all flex items-center gap-3 group">
                        <i data-lucide="file-check" class="w-5 h-5 text-violet-700 flex-shrink-0"></i>
                        <div class="min-w-0">
                            <span class="text-xs font-bold text-slate-800 block truncate">KTP Pemohon</span>
                            <span class="text-[10px] text-slate-400 group-hover:text-violet-700">Lihat Berkas &rarr;</span>
                        </div>
                    </a>
                    @endif

                    @if($pengajuanSurat->file_kk)
                    <a href="{{ asset('storage/' . $pengajuanSurat->file_kk) }}" target="_blank"
                        class="p-4 rounded-xl border border-slate-200 hover:border-violet-500 hover:bg-violet-50/20 transition-all flex items-center gap-3 group">
                        <i data-lucide="file-check" class="w-5 h-5 text-violet-700 flex-shrink-0"></i>
                        <div class="min-w-0">
                            <span class="text-xs font-bold text-slate-800 block truncate">Kartu Keluarga (KK)</span>
                            <span class="text-[10px] text-slate-400 group-hover:text-violet-700">Lihat Berkas &rarr;</span>
                        </div>
                    </a>
                    @endif

                    @if($pengajuanSurat->dokumen_pendukung)
                    <a href="{{ asset('storage/' . $pengajuanSurat->dokumen_pendukung) }}" target="_blank"
                        class="p-4 rounded-xl border border-slate-200 hover:border-violet-500 hover:bg-violet-50/20 transition-all flex items-center gap-3 group">
                        <i data-lucide="file-plus" class="w-5 h-5 text-violet-700 flex-shrink-0"></i>
                        <div class="min-w-0">
                            <span class="text-xs font-bold text-slate-800 block truncate">Dokumen Pendukung</span>
                            <span class="text-[10px] text-slate-400 group-hover:text-violet-700">Lihat Berkas &rarr;</span>
                        </div>
                    </a>
                    @endif
                </div>
            </div>

            {{-- Form Status & Catatan Administrator --}}
            <div class="pt-6 border-t border-slate-100 bg-slate-50/50 p-5 rounded-2xl border">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-3 flex items-center gap-2">
                    <i data-lucide="check-square" class="w-4 h-4 text-forest-700"></i>
                    Tindakan Administrator & Verifikasi Status
                </h3>

                <form action="{{ route('admin.pengajuan-surat.status', $pengajuanSurat) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label for="status" class="form-label">Status Pengajuan</label>
                            <select name="status" id="status" class="form-input">
                                <option value="diajukan" {{ $pengajuanSurat->status === 'diajukan' ? 'selected' : '' }}>Diajukan (Menunggu Pemeriksaan)</option>
                                <option value="diverifikasi" {{ $pengajuanSurat->status === 'diverifikasi' ? 'selected' : '' }}>Diverifikasi (Berkas Sesuai)</option>
                                <option value="diproses" {{ $pengajuanSurat->status === 'diproses' ? 'selected' : '' }}>Diproses (Pencetakan / Tanda Tangan)</option>
                                <option value="selesai" {{ $pengajuanSurat->status === 'selesai' ? 'selected' : '' }}>Selesai (Surat Siap Diambil / Terbit)</option>
                                <option value="ditolak" {{ $pengajuanSurat->status === 'ditolak' ? 'selected' : '' }}>Ditolak (Persyaratan Tidak Lengkap)</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="catatan_admin" class="form-label">Catatan / Tanggapan untuk Pemohon</label>
                        <textarea name="catatan_admin" id="catatan_admin" rows="3" class="form-input"
                            placeholder="Tuliskan keterangan untuk pemohon (contoh: Surat telah selesai ditandatangani Kepala Desa dan siap diambil di kantor desa membawa KTP asli)...">{{ old('catatan_admin', $pengajuanSurat->catatan_admin) }}</textarea>
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <button type="submit" class="btn-primary text-xs">
                            <i data-lucide="save" class="w-3.5 h-3.5"></i>
                            Simpan Perubahan Status
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

</div>
@endsection
