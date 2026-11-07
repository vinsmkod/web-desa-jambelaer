@extends('admin.layouts.admin')

@section('title', 'Detail Pengajuan Surat - ' . $pengajuanSurat->nomor_pengajuan)
@section('page_title', 'Detail Pengajuan Surat')
@section('page_subtitle', $pengajuanSurat->nomor_pengajuan)

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

            {{-- Alur Pelayanan Berjenjang (SRS-F-010) --}}
            <div class="pt-6 border-t border-slate-100">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-4 flex items-center gap-2">
                    <i data-lucide="git-commit" class="w-4 h-4 text-forest-700"></i>
                    Tahapan Alur Pelayanan Surat (SRS-F-010)
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                    {{-- 1. Pengajuan Pemohon --}}
                    <div class="p-3.5 rounded-xl border {{ $pengajuanSurat->created_at ? 'bg-emerald-50/60 border-emerald-200' : 'bg-slate-50 border-slate-200' }}">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold {{ $pengajuanSurat->created_at ? 'bg-emerald-600 text-white' : 'bg-slate-300 text-slate-600' }}">1</span>
                            <span class="text-xs font-bold text-slate-800">Diajukan</span>
                        </div>
                        <p class="text-[11px] text-slate-500 mt-2 font-medium">Oleh: {{ $pengajuanSurat->nama_pemohon ?? 'Pemohon' }}</p>
                        <p class="text-[10px] text-slate-400 mt-0.5">{{ $pengajuanSurat->created_at ? $pengajuanSurat->created_at->format('d/m/Y H:i') : '-' }}</p>
                    </div>

                    {{-- 2. Staff Desa --}}
                    <div class="p-3.5 rounded-xl border {{ $pengajuanSurat->diproses_at ? 'bg-emerald-50/60 border-emerald-200' : ($pengajuanSurat->status === 'diajukan' ? 'bg-amber-50/60 border-amber-300' : 'bg-slate-50 border-slate-200') }}">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold {{ $pengajuanSurat->diproses_at ? 'bg-emerald-600 text-white' : ($pengajuanSurat->status === 'diajukan' ? 'bg-amber-500 text-white' : 'bg-slate-300 text-slate-600') }}">2</span>
                            <span class="text-xs font-bold text-slate-800">Diproses</span>
                        </div>
                        <p class="text-[11px] text-slate-500 mt-2 font-medium">Staff: {{ $pengajuanSurat->diprosesBy->name ?? ($pengajuanSurat->status === 'diajukan' ? 'Menunggu Staff Desa' : '-') }}</p>
                        <p class="text-[10px] text-slate-400 mt-0.5">{{ $pengajuanSurat->diproses_at ? $pengajuanSurat->diproses_at->format('d/m/Y H:i') : '-' }}</p>
                    </div>

                    {{-- 3. Sekretaris Desa --}}
                    <div class="p-3.5 rounded-xl border {{ $pengajuanSurat->diverifikasi_at ? 'bg-emerald-50/60 border-emerald-200' : ($pengajuanSurat->status === 'diproses' ? 'bg-amber-50/60 border-amber-300' : 'bg-slate-50 border-slate-200') }}">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold {{ $pengajuanSurat->diverifikasi_at ? 'bg-emerald-600 text-white' : ($pengajuanSurat->status === 'diproses' ? 'bg-amber-500 text-white' : 'bg-slate-300 text-slate-600') }}">3</span>
                            <span class="text-xs font-bold text-slate-800">Diverifikasi</span>
                        </div>
                        <p class="text-[11px] text-slate-500 mt-2 font-medium">Sekdes: {{ $pengajuanSurat->diverifikasiBy->name ?? ($pengajuanSurat->status === 'diproses' ? 'Menunggu Sekdes' : '-') }}</p>
                        <p class="text-[10px] text-slate-400 mt-0.5">{{ $pengajuanSurat->diverifikasi_at ? $pengajuanSurat->diverifikasi_at->format('d/m/Y H:i') : '-' }}</p>
                    </div>

                    {{-- 4. Kepala Desa --}}
                    <div class="p-3.5 rounded-xl border {{ $pengajuanSurat->disetujui_at ? 'bg-emerald-50/60 border-emerald-200' : ($pengajuanSurat->status === 'diverifikasi' ? 'bg-amber-50/60 border-amber-300' : 'bg-slate-50 border-slate-200') }}">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold {{ $pengajuanSurat->disetujui_at ? 'bg-emerald-600 text-white' : ($pengajuanSurat->status === 'diverifikasi' ? 'bg-amber-500 text-white' : 'bg-slate-300 text-slate-600') }}">4</span>
                            <span class="text-xs font-bold text-slate-800">Selesai (Persetujuan)</span>
                        </div>
                        <p class="text-[11px] text-slate-500 mt-2 font-medium">Kades: {{ $pengajuanSurat->disetujuiBy->name ?? ($pengajuanSurat->status === 'diverifikasi' ? 'Menunggu Kades' : '-') }}</p>
                        <p class="text-[10px] text-slate-400 mt-0.5">{{ $pengajuanSurat->disetujui_at ? $pengajuanSurat->disetujui_at->format('d/m/Y H:i') : '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Form Tindakan & Verifikasi Berdasarkan Hak Akses Role --}}
            @php
                $authUser = auth()->user();
                $currentStatus = strtolower($pengajuanSurat->status ?? 'diajukan');
                $isAllowedToAct = false;
                $allowedOptions = [];

                if ($authUser->role === \App\Models\UserModel::ROLE_STAFF_DESA) {
                    $isAllowedToAct = in_array($currentStatus, ['diajukan', 'menunggu', 'diproses']);
                    $allowedOptions = [
                        'diproses' => 'Diproses (Pemeriksaan Dokumen Lengkap & Sesuai)',
                        'ditolak'  => 'Ditolak (Persyaratan Berkas Tidak Lengkap / Tidak Sesuai)',
                    ];
                } elseif ($authUser->role === \App\Models\UserModel::ROLE_SEKRETARIS_DESA) {
                    $isAllowedToAct = in_array($currentStatus, ['diproses', 'diverifikasi']);
                    $allowedOptions = [
                        'diverifikasi' => 'Diverifikasi (Verifikasi Berkas Disetujui Sekretaris Desa)',
                        'ditolak'      => 'Ditolak (Berkas Ditolak / Perlu Perbaikan)',
                    ];
                } elseif ($authUser->role === \App\Models\UserModel::ROLE_KEPALA_DESA) {
                    $isAllowedToAct = in_array($currentStatus, ['diverifikasi', 'selesai']);
                    $allowedOptions = [
                        'selesai' => 'Selesai (Disetujui Kepala Desa & Surat Diterbitkan)',
                        'ditolak' => 'Ditolak (Persetujuan Ditolak Kepala Desa)',
                    ];
                } elseif ($authUser->role === \App\Models\UserModel::ROLE_ADMIN) {
                    $isAllowedToAct = true;
                    $allowedOptions = [
                        'diajukan'     => 'Diajukan (Menunggu Pemeriksaan)',
                        'diproses'     => 'Diproses (Staff Desa)',
                        'diverifikasi' => 'Diverifikasi (Sekretaris Desa)',
                        'selesai'      => 'Selesai (Kepala Desa)',
                        'ditolak'      => 'Ditolak',
                    ];
                }
            @endphp

            @if($isAllowedToAct && !in_array($currentStatus, ['selesai', 'dibatalkan']))
            <div class="pt-6 border-t border-slate-100 bg-slate-50/70 p-5 rounded-2xl border border-slate-200">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700 flex items-center gap-2">
                        <i data-lucide="check-square" class="w-4 h-4 text-forest-700"></i>
                        Tindakan Anda ({{ $authUser->role_label }})
                    </h3>
                    <span class="text-[11px] font-semibold text-slate-500 bg-white px-2.5 py-1 rounded-lg border border-slate-200">
                        Status Saat Ini: <strong class="text-slate-800">{{ $pengajuanSurat->status_label }}</strong>
                    </span>
                </div>

                <form action="{{ route('admin.pengajuan-surat.status', $pengajuanSurat) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label for="status" class="form-label">Tindakan Keputusan <span class="text-red-500">*</span></label>
                            <select name="status" id="status" class="form-input font-medium" required>
                                <option value="">-- Pilih Tindakan Keputusan --</option>
                                @foreach($allowedOptions as $optVal => $optLabel)
                                    <option value="{{ $optVal }}" {{ $currentStatus === $optVal ? 'selected' : '' }}>
                                        {{ $optLabel }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="catatan_admin" class="form-label">Catatan / Keterangan untuk Pemohon</label>
                        <textarea name="catatan_admin" id="catatan_admin" rows="3" class="form-input"
                            placeholder="Tuliskan catatan proses permohonan surat ini (opsional)...">{{ old('catatan_admin', $pengajuanSurat->catatan_admin) }}</textarea>
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <button type="submit" class="btn-primary text-xs">
                            <i data-lucide="save" class="w-3.5 h-3.5"></i>
                            Simpan Keputusan & Perbarui Status
                        </button>
                    </div>
                </form>
            </div>
            @elseif(in_array($currentStatus, ['selesai', 'dibatalkan']))
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-600 flex items-center gap-3">
                <i data-lucide="info" class="w-5 h-5 text-slate-500 flex-shrink-0"></i>
                <span>Pengajuan surat ini telah berstatus <strong>{{ $pengajuanSurat->status_label }}</strong>. Proses alur permohonan telah berakhir.</span>
            </div>
            @else
            <div class="p-4 rounded-xl bg-amber-50 border border-amber-200 text-xs text-amber-800 flex items-center gap-3">
                <i data-lucide="alert-triangle" class="w-5 h-5 text-amber-600 flex-shrink-0"></i>
                <div>
                    <span class="font-bold block">Menunggu Tahapan Lain</span>
                    <span>Status surat saat ini adalah <strong>{{ $pengajuanSurat->status_label }}</strong>. Tahapan ini hanya dapat diproses oleh perangkat desa yang berwenang sesuai alur: <em>Staff Desa &rarr; Sekretaris Desa &rarr; Kepala Desa</em>.</span>
                </div>
            </div>
            @endif

            {{-- Riwayat Perubahan Status (Log Audit) --}}
            @if($pengajuanSurat->riwayat && $pengajuanSurat->riwayat->count() > 0)
            <div class="pt-6 border-t border-slate-100">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-3 flex items-center gap-2">
                    <i data-lucide="history" class="w-4 h-4 text-forest-700"></i>
                    Riwayat Proses & Catatan Alur Pelayanan
                </h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border border-slate-200 rounded-xl overflow-hidden">
                        <thead>
                            <tr class="bg-slate-50 text-[10px] uppercase font-bold text-slate-400 border-b border-slate-200">
                                <th class="py-2.5 px-3">Waktu</th>
                                <th class="py-2.5 px-3">Oleh</th>
                                <th class="py-2.5 px-3">Perubahan Status</th>
                                <th class="py-2.5 px-3">Catatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($pengajuanSurat->riwayat as $log)
                            <tr class="hover:bg-slate-50/50">
                                <td class="py-2.5 px-3 whitespace-nowrap text-slate-500 font-mono text-[11px]">
                                    {{ $log->created_at ? $log->created_at->format('d/m/Y H:i') : '-' }}
                                </td>
                                <td class="py-2.5 px-3 whitespace-nowrap font-medium text-slate-800">
                                    {{ $log->user->name ?? 'Sistem' }}
                                    @if($log->user && $log->user->role_label)
                                    <span class="text-[10px] text-slate-400 block font-normal">{{ $log->user->role_label }}</span>
                                    @endif
                                </td>
                                <td class="py-2.5 px-3 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-100 text-slate-600">{{ ucfirst($log->status_lama ?? 'Diajukan') }}</span>
                                        <span class="text-slate-400">&rarr;</span>
                                        <span class="px-2 py-0.5 rounded text-[10px] font-semibold {{ $log->status_baru_badge_class }}">{{ $log->status_baru_label }}</span>
                                    </span>
                                </td>
                                <td class="py-2.5 px-3 text-slate-600">
                                    {{ $log->catatan ?: '-' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

        </div>
    </div>

</div>
@endsection
