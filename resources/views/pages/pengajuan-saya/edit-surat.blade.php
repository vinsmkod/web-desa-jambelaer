@extends('layouts.app')

@section('title', 'Edit Pengajuan Surat – Desa Jambelaer')
@section('meta_desc', 'Perbaiki data pengajuan surat Anda di Desa Jambelaer. Pengajuan hanya dapat diubah selama masih berstatus Diajukan.')

@section('content')
{{-- Breadcrumb --}}
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 sm:pt-6">
    <nav class="flex items-center gap-1.5 text-xs text-stone-500 mb-4">
        <a href="{{ route('home') }}" class="hover:text-forest-800 transition-colors">Beranda</a>
        <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-stone-300"></i>
        <a href="{{ route('pengajuan.saya') }}" class="hover:text-forest-800 transition-colors">Pengajuan Saya</a>
        <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-stone-300"></i>
        <span class="text-forest-800 font-semibold">Edit Pengajuan Surat</span>
    </nav>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-forest-900 to-forest-800 text-white rounded-3xl p-6 sm:p-8 shadow-sm mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="px-2.5 py-1 rounded-lg bg-white/10 text-sand-300 border border-white/15 text-xs font-mono font-bold tracking-wider">
                    {{ $pengajuan->nomor_pengajuan }}
                </span>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold border {{ $pengajuan->status_badge_class }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                    {{ $pengajuan->status_label }}
                </span>
            </div>
            <h1 class="font-display font-extrabold text-xl sm:text-2xl text-white">Edit Pengajuan Surat</h1>
            <p class="text-xs text-white/70 mt-1">
                Perbaiki data di bawah ini. Berkas lama akan tetap dipakai apabila tidak ada unggahan baru.
            </p>
        </div>
        <a href="{{ route('pengajuan.show.detail', ['jenis' => 'surat', 'id' => $pengajuan->pengajuan_surat_id]) }}"
            class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 text-xs font-bold text-white transition-all whitespace-nowrap">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            Kembali ke Detail
        </a>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-3xl border border-stone-200/80 shadow-sm overflow-hidden">
        <div class="p-6 sm:p-8">

            {{-- Error Summary --}}
            @if($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-sm text-rose-800">
                <div class="flex items-center gap-2 font-bold mb-2">
                    <i data-lucide="alert-triangle" class="w-4 h-4 text-rose-600"></i>
                    Terdapat {{ $errors->count() }} kesalahan pada isian formulir:
                </div>
                <ul class="list-disc list-inside space-y-1 text-xs font-light">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('pengajuan.surat.update', $pengajuan->pengajuan_surat_id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- 1. Jenis Surat --}}
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
                                    {{ (old('jenis_surat_id', $pengajuan->jenis_surat_id) == $js->id) ? 'selected' : '' }}>
                                    {{ $js->nama_surat }} {{ $js->kode_surat ? '('.$js->kode_surat.')' : '' }}
                                </option>
                            @endforeach
                        </select>
                        <i data-lucide="chevron-down" class="w-4 h-4 absolute right-4 top-4 text-stone-400 pointer-events-none"></i>
                    </div>

                    <div id="surat-info-card" class="mt-3 p-4 rounded-2xl bg-amber-50/80 border border-amber-200/80 text-xs {{ old('jenis_surat_id', $pengajuan->jenis_surat_id) ? '' : 'hidden' }}">
                        <div class="flex items-start gap-2.5">
                            <i data-lucide="info" class="w-4 h-4 text-amber-700 flex-shrink-0 mt-0.5"></i>
                            <div class="space-y-1">
                                <p id="surat-info-desc" class="text-stone-700 font-medium leading-relaxed"></p>
                                <p id="surat-info-syarat" class="text-amber-900 font-semibold"></p>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- 2. Identitas Pemohon --}}
                <div class="pt-4 border-t border-stone-100">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-stone-400 mb-4 flex items-center gap-1.5">
                        <i data-lucide="id-card" class="w-4 h-4 text-forest-700"></i>
                        Identitas Pemohon
                    </h3>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-xs font-semibold text-stone-600 mb-1.5">Nama Lengkap Sesuai KTP <span class="text-rose-500">*</span></label>
                            <input type="text" id="name" name="name" required value="{{ old('name', $pengajuan->nama_pemohon) }}"
                                class="w-full px-4 py-3 rounded-xl border border-stone-200 text-sm font-medium text-stone-800 bg-stone-50/50 focus:bg-white focus:border-forest-700 focus:ring-2 focus:ring-forest-100 outline-none transition-all">
                        </div>

                        <div>
                            <label for="no_whatsapp" class="block text-xs font-semibold text-stone-600 mb-1.5">Nomor WhatsApp Aktif <span class="text-rose-500">*</span></label>
                            <input type="tel" id="no_whatsapp" name="no_whatsapp" required placeholder="cth: 081234567890" value="{{ old('no_whatsapp', $pengajuan->no_whatsapp) }}"
                                class="w-full px-4 py-3 rounded-xl border border-stone-200 text-sm font-medium text-stone-800 bg-stone-50/50 focus:bg-white focus:border-forest-700 focus:ring-2 focus:ring-forest-100 outline-none transition-all">
                        </div>

                        <div>
                            <label for="nik" class="block text-xs font-semibold text-stone-600 mb-1.5">NIK (16 Digit) <span class="text-rose-500">*</span></label>
                            <input type="text" id="nik" name="nik" required maxlength="16" pattern="[0-9]{16}" placeholder="cth: 3212010101900001" value="{{ old('nik', $pengajuan->nik) }}"
                                class="w-full px-4 py-3 rounded-xl border border-stone-200 text-sm font-medium text-stone-800 bg-stone-50/50 focus:bg-white focus:border-forest-700 focus:ring-2 focus:ring-forest-100 outline-none transition-all font-mono">
                        </div>

                        <div>
                            <label for="no_kk" class="block text-xs font-semibold text-stone-600 mb-1.5">Nomor Kartu Keluarga (16 Digit) <span class="text-rose-500">*</span></label>
                            <input type="text" id="no_kk" name="no_kk" required maxlength="16" pattern="[0-9]{16}" placeholder="cth: 3212010101000002" value="{{ old('no_kk', $pengajuan->no_kk) }}"
                                class="w-full px-4 py-3 rounded-xl border border-stone-200 text-sm font-medium text-stone-800 bg-stone-50/50 focus:bg-white focus:border-forest-700 focus:ring-2 focus:ring-forest-100 outline-none transition-all font-mono">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="alamat_pemohon" class="block text-xs font-semibold text-stone-600 mb-1.5">Alamat Domisili Lengkap <span class="text-rose-500">*</span></label>
                        <textarea id="alamat_pemohon" name="alamat_pemohon" rows="2" required placeholder="cth: Kp. Melong RT 03 RW 02, Desa Jambelaer, Kec. Dawuan"
                            class="w-full px-4 py-3 rounded-xl border border-stone-200 text-sm font-medium text-stone-800 bg-stone-50/50 focus:bg-white focus:border-forest-700 focus:ring-2 focus:ring-forest-100 outline-none transition-all resize-none">{{ old('alamat_pemohon', $pengajuan->alamat_pemohon) }}</textarea>
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
                        <textarea id="keperluan" name="keperluan" rows="3" required placeholder="Jelaskan untuk keperluan apa surat ini diajukan"
                            class="w-full px-4 py-3 rounded-xl border border-stone-200 text-sm font-medium text-stone-800 bg-stone-50/50 focus:bg-white focus:border-forest-700 focus:ring-2 focus:ring-forest-100 outline-none transition-all resize-none">{{ old('keperluan', $pengajuan->keperluan) }}</textarea>
                    </div>

                    <div class="mt-4">
                        <label for="keterangan_tambahan" class="block text-xs font-semibold text-stone-600 mb-1.5">Catatan / Data Tambahan <span class="text-stone-400 font-normal">(Opsional)</span></label>
                        <textarea id="keterangan_tambahan" name="keterangan_tambahan" rows="2" placeholder="Jika jenis surat membutuhkan data khusus"
                            class="w-full px-4 py-3 rounded-xl border border-stone-200 text-sm font-medium text-stone-800 bg-stone-50/50 focus:bg-white focus:border-forest-700 focus:ring-2 focus:ring-forest-100 outline-none transition-all resize-none">{{ old('keterangan_tambahan', $pengajuan->keterangan_tambahan) }}</textarea>
                    </div>
                </div>
                {{-- 4. Berkas Persyaratan --}}
                <div class="pt-4 border-t border-stone-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-stone-400 flex items-center gap-1.5">
                            <i data-lucide="paperclip" class="w-4 h-4 text-forest-700"></i>
                            Berkas Persyaratan
                        </h3>
                        <span class="text-[11px] text-stone-400">Kosongkan untuk mempertahankan berkas lama</span>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        {{-- File KTP --}}
                        <div class="p-4 rounded-2xl border-2 border-dashed border-stone-200 bg-stone-50/40 hover:border-forest-400 hover:bg-forest-50/20 transition-all text-center group cursor-pointer"
                            onclick="document.getElementById('file_ktp').click()">
                            <div class="w-10 h-10 rounded-xl bg-forest-100/70 text-forest-800 flex items-center justify-center mx-auto mb-2 group-hover:scale-105 transition-transform">
                                <i data-lucide="credit-card" class="w-5 h-5"></i>
                            </div>
                            <span class="block text-xs font-bold text-stone-800">Foto / Scan KTP</span>
                            <span id="label-file-ktp" class="block text-[11px] text-stone-400 mt-0.5">Klik untuk mengganti file</span>
                            @if($pengajuan->file_ktp)
                            <a href="{{ asset('storage/' . $pengajuan->file_ktp) }}" target="_blank" onclick="event.stopPropagation()"
                                class="inline-flex items-center gap-1 mt-2 text-[11px] font-semibold text-forest-700 hover:underline">
                                <i data-lucide="eye" class="w-3 h-3"></i>Lihat berkas saat ini
                            </a>
                            @endif
                            <input type="file" id="file_ktp" name="file_ktp" accept=".jpeg,.jpg,.png,.webp,.pdf" class="hidden"
                                onchange="updateFileName(this, 'label-file-ktp')">
                        </div>

                        {{-- File KK --}}
                        <div class="p-4 rounded-2xl border-2 border-dashed border-stone-200 bg-stone-50/40 hover:border-forest-400 hover:bg-forest-50/20 transition-all text-center group cursor-pointer"
                            onclick="document.getElementById('file_kk').click()">
                            <div class="w-10 h-10 rounded-xl bg-sand-100 text-sand-800 flex items-center justify-center mx-auto mb-2 group-hover:scale-105 transition-transform">
                                <i data-lucide="users" class="w-5 h-5"></i>
                            </div>
                            <span class="block text-xs font-bold text-stone-800">Foto / Scan Kartu Keluarga</span>
                            <span id="label-file-kk" class="block text-[11px] text-stone-400 mt-0.5">Klik untuk mengganti file</span>
                            @if($pengajuan->file_kk)
                            <a href="{{ asset('storage/' . $pengajuan->file_kk) }}" target="_blank" onclick="event.stopPropagation()"
                                class="inline-flex items-center gap-1 mt-2 text-[11px] font-semibold text-forest-700 hover:underline">
                                <i data-lucide="eye" class="w-3 h-3"></i>Lihat berkas saat ini
                            </a>
                            @endif
                            <input type="file" id="file_kk" name="file_kk" accept=".jpeg,.jpg,.png,.webp,.pdf" class="hidden"
                                onchange="updateFileName(this, 'label-file-kk')">
                        </div>
                    </div>
                    {{-- Dokumen Pendukung --}}
                    <div class="mt-4 p-4 rounded-2xl border border-stone-200 bg-stone-50/30 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-stone-200/70 text-stone-600 flex items-center justify-center flex-shrink-0">
                                <i data-lucide="file-plus" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <span class="text-xs font-bold text-stone-800 block">Dokumen Pendukung Lainnya <span class="text-stone-400 font-normal">(Opsional)</span></span>
                                <span id="label-file-pendukung" class="text-[11px] text-stone-400 block">
                                    @if($pengajuan->dokumen_pendukung)
                                    <a href="{{ asset('storage/' . $pengajuan->dokumen_pendukung) }}" target="_blank" class="text-forest-700 font-semibold hover:underline">Lihat berkas saat ini</a> — unggah file baru untuk mengganti.
                                    @else
                                    Surat pengantar RT/RW, foto tempat usaha (SKU), surat kematian, dll.
                                    @endif
                                </span>
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

                {{-- Submit --}}
                <div class="pt-6 border-t border-stone-100 flex flex-col sm:flex-row items-center justify-end gap-3">
                    <a href="{{ route('pengajuan.show.detail', ['jenis' => 'surat', 'id' => $pengajuan->pengajuan_surat_id]) }}"
                        class="btn-secondary text-xs w-full sm:w-auto justify-center">
                        Batal
                    </a>
                    <button type="submit" class="w-full sm:w-auto btn-primary px-8 py-3.5 text-xs font-bold justify-center shadow-md">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
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