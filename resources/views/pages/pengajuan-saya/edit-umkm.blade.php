@extends('layouts.app')

@section('title', 'Edit Pendaftaran UMKM – Desa Jambelaer')
@section('meta_desc', 'Perbaiki data pendaftaran UMKM Anda di Desa Jambelaer. Pendaftaran hanya dapat diubah selama masih berstatus Diajukan.')

@section('content')
{{-- Breadcrumb --}}
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 sm:pt-6">
    <nav class="flex items-center gap-1.5 text-xs text-stone-500 mb-4">
        <a href="{{ route('home') }}" class="hover:text-forest-800 transition-colors">Beranda</a>
        <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-stone-300"></i>
        <a href="{{ route('pengajuan.saya') }}" class="hover:text-forest-800 transition-colors">Pengajuan Saya</a>
        <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-stone-300"></i>
        <span class="text-forest-800 font-semibold">Edit Pendaftaran UMKM</span>
    </nav>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-forest-900 to-forest-800 text-white rounded-3xl p-6 sm:p-8 shadow-sm mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="px-2.5 py-1 rounded-lg bg-white/10 text-sand-300 border border-white/15 text-xs font-mono font-bold tracking-wider">
                    {{ $umkm->nomor_pendaftaran }}
                </span>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold border {{ $umkm->status_badge_class }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                    {{ $umkm->status_label }}
                </span>
            </div>
            <h1 class="font-display font-extrabold text-xl sm:text-2xl text-white">Edit Pendaftaran UMKM</h1>
            <p class="text-xs text-white/70 mt-1">
                Perbaiki profil usaha Anda. Foto produk &amp; dokumen lama tetap dipakai apabila tidak ada unggahan baru.
            </p>
        </div>
        <a href="{{ route('pengajuan.show.detail', ['jenis' => 'umkm', 'id' => $umkm->pendaftaran_umkm_id]) }}"
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

            @php
                // NIB & Sertifikasi Halal dapat berupa nomor (teks) maupun berkas tersimpan
                $nibAdalahBerkas    = $umkm->nib && (str_contains($umkm->nib, '/') || (bool) preg_match('/\.(pdf|jpe?g|png|webp)$/i', $umkm->nib));
                $halalAdalahBerkas  = $umkm->sertifikasi_halal && (str_contains($umkm->sertifikasi_halal, '/') || (bool) preg_match('/\.(pdf|jpe?g|png|webp)$/i', $umkm->sertifikasi_halal));
            @endphp

            <form action="{{ route('pendaftaran-umkm.update', $umkm->pendaftaran_umkm_id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                {{-- Profil Usaha --}}
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-stone-400 mb-4 flex items-center gap-1.5">
                        <i data-lucide="store" class="w-4 h-4 text-forest-700"></i>
                        Profil Usaha
                    </h3>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label for="nama_usaha" class="block text-xs font-semibold text-stone-600 mb-1.5">Nama Usaha / UMKM <span class="text-rose-500">*</span></label>
                            <input type="text" id="nama_usaha" name="nama_usaha" required value="{{ old('nama_usaha', $umkm->nama_usaha) }}"
                                class="w-full px-4 py-3 rounded-xl border border-stone-200 text-sm font-medium text-stone-800 bg-stone-50/50 focus:bg-white focus:border-forest-700 focus:ring-2 focus:ring-forest-100 outline-none transition-all">
                        </div>

                        <div>
                            <label for="nama_pemilik" class="block text-xs font-semibold text-stone-600 mb-1.5">Nama Pemilik <span class="text-rose-500">*</span></label>
                            <input type="text" id="nama_pemilik" name="nama_pemilik" required value="{{ old('nama_pemilik', $umkm->nama_pemilik) }}"
                                class="w-full px-4 py-3 rounded-xl border border-stone-200 text-sm font-medium text-stone-800 bg-stone-50/50 focus:bg-white focus:border-forest-700 focus:ring-2 focus:ring-forest-100 outline-none transition-all">
                        </div>

                        <div>
                            <label for="produk" class="block text-xs font-semibold text-stone-600 mb-1.5">Kategori / Produk Unggulan <span class="text-rose-500">*</span></label>
                            <input type="text" id="produk" name="produk" required value="{{ old('produk', $umkm->produk) }}" placeholder="cth: Kerajinan bambu, makanan ringan"
                                class="w-full px-4 py-3 rounded-xl border border-stone-200 text-sm font-medium text-stone-800 bg-stone-50/50 focus:bg-white focus:border-forest-700 focus:ring-2 focus:ring-forest-100 outline-none transition-all">
                        </div>

                        <div>
                            <label for="nomor_whatsapp" class="block text-xs font-semibold text-stone-600 mb-1.5">Nomor WhatsApp Pemesanan <span class="text-rose-500">*</span></label>
                            <input type="tel" id="nomor_whatsapp" name="nomor_whatsapp" required placeholder="cth: 081234567890" value="{{ old('nomor_whatsapp', $umkm->nomor_whatsapp) }}"
                                class="w-full px-4 py-3 rounded-xl border border-stone-200 text-sm font-medium text-stone-800 bg-stone-50/50 focus:bg-white focus:border-forest-700 focus:ring-2 focus:ring-forest-100 outline-none transition-all">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="alamat_usaha" class="block text-xs font-semibold text-stone-600 mb-1.5">Alamat Lokasi Usaha <span class="text-rose-500">*</span></label>
                        <textarea id="alamat_usaha" name="alamat_usaha" rows="2" required placeholder="cth: Kp. Melong RT 03 RW 02, Desa Jambelaer, Kec. Dawuan"
                            class="w-full px-4 py-3 rounded-xl border border-stone-200 text-sm font-medium text-stone-800 bg-stone-50/50 focus:bg-white focus:border-forest-700 focus:ring-2 focus:ring-forest-100 outline-none transition-all resize-none">{{ old('alamat_usaha', $umkm->alamat_usaha) }}</textarea>
                    </div>

                    <div class="mt-4">
                        <label for="instagram" class="block text-xs font-semibold text-stone-600 mb-1.5">Instagram / Media Sosial <span class="text-stone-400 font-normal">(Opsional)</span></label>
                        <input type="text" id="instagram" name="instagram" value="{{ old('instagram', $umkm->instagram) }}" placeholder="cth: @umkm_jambelaer"
                            class="w-full px-4 py-3 rounded-xl border border-stone-200 text-sm font-medium text-stone-800 bg-stone-50/50 focus:bg-white focus:border-forest-700 focus:ring-2 focus:ring-forest-100 outline-none transition-all">
                    </div>

                    <div class="mt-4">
                        <label for="deskripsi_usaha" class="block text-xs font-semibold text-stone-600 mb-1.5">Deskripsi Profil Usaha <span class="text-rose-500">*</span></label>
                        <textarea id="deskripsi_usaha" name="deskripsi_usaha" rows="4" required placeholder="Ceritakan profil usaha Anda: produk yang dijual, keunikan, dll."
                            class="w-full px-4 py-3 rounded-xl border border-stone-200 text-sm font-medium text-stone-800 bg-stone-50/50 focus:bg-white focus:border-forest-700 focus:ring-2 focus:ring-forest-100 outline-none transition-all resize-none">{{ old('deskripsi_usaha', $umkm->deskripsi_usaha) }}</textarea>
                    </div>
                </div>
                {{-- Dokumen & Legalitas --}}
                <div class="pt-4 border-t border-stone-100">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-stone-400 mb-4 flex items-center gap-1.5">
                        <i data-lucide="badge-check" class="w-4 h-4 text-forest-700"></i>
                        Dokumen &amp; Legalitas <span class="text-stone-400 font-normal">(Opsional)</span>
                    </h3>

                    <div class="grid sm:grid-cols-2 gap-4">
                        {{-- NIB --}}
                        <div>
                            <label for="nib" class="block text-xs font-semibold text-stone-600 mb-1.5">Nomor NIB (Opsional)</label>
                            <input type="text" id="nib" name="nib" value="{{ old('nib', $nibAdalahBerkas ? '' : $umkm->nib) }}" placeholder="Isi nomor NIB secara langsung"
                                class="w-full px-4 py-3 rounded-xl border border-stone-200 text-sm font-medium text-stone-800 bg-stone-50/50 focus:bg-white focus:border-forest-700 focus:ring-2 focus:ring-forest-100 outline-none transition-all">
                            @if($nibAdalahBerkas)
                            <p class="text-[11px] text-stone-500 mt-1.5">
                                Berkas NIB saat ini:
                                <a href="{{ asset('storage/' . $umkm->nib) }}" target="_blank" class="text-forest-700 font-semibold hover:underline">lihat</a>.
                                Kosongkan kolom di atas untuk mempertahankannya.
                            </p>
                            @endif
                            <div class="mt-2 flex items-center gap-2">
                                <button type="button" onclick="document.getElementById('nib_file').click()"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white border border-stone-300 text-xs font-semibold text-stone-700 hover:bg-stone-50 transition-all shadow-2xs">
                                    <i data-lucide="upload" class="w-3.5 h-3.5"></i>
                                    Unggah Berkas NIB
                                </button>
                                <span id="label-nib-file" class="text-[11px] text-stone-400">PDF / gambar (maks. 5 MB)</span>
                                <input type="file" id="nib_file" name="nib" accept=".jpg,.jpeg,.png,.webp,.pdf" class="hidden"
                                    onchange="updateFileName(this, 'label-nib-file')">
                            </div>
                        </div>

                        {{-- Sertifikasi Halal --}}
                        <div>
                            <label for="sertifikasi_halal" class="block text-xs font-semibold text-stone-600 mb-1.5">Sertifikasi Halal (Opsional)</label>
                            <input type="text" id="sertifikasi_halal" name="sertifikasi_halal" value="{{ old('sertifikasi_halal', $halalAdalahBerkas ? '' : $umkm->sertifikasi_halal) }}" placeholder="Isi nomor sertifikat halal"
                                class="w-full px-4 py-3 rounded-xl border border-stone-200 text-sm font-medium text-stone-800 bg-stone-50/50 focus:bg-white focus:border-forest-700 focus:ring-2 focus:ring-forest-100 outline-none transition-all">
                            @if($halalAdalahBerkas)
                            <p class="text-[11px] text-stone-500 mt-1.5">
                                Berkas sertifikat saat ini:
                                <a href="{{ asset('storage/' . $umkm->sertifikasi_halal) }}" target="_blank" class="text-forest-700 font-semibold hover:underline">lihat</a>.
                                Kosongkan kolom di atas untuk mempertahankannya.
                            </p>
                            @endif
                            <div class="mt-2 flex items-center gap-2">
                                <button type="button" onclick="document.getElementById('halal_file').click()"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white border border-stone-300 text-xs font-semibold text-stone-700 hover:bg-stone-50 transition-all shadow-2xs">
                                    <i data-lucide="upload" class="w-3.5 h-3.5"></i>
                                    Unggah Berkas Sertifikat
                                </button>
                                <span id="label-halal-file" class="text-[11px] text-stone-400">PDF / gambar (maks. 5 MB)</span>
                                <input type="file" id="halal_file" name="sertifikasi_halal" accept=".jpg,.jpeg,.png,.webp,.pdf" class="hidden"
                                    onchange="updateFileName(this, 'label-halal-file')">
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Foto Produk --}}
                <div class="pt-4 border-t border-stone-100">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-stone-400 mb-4 flex items-center gap-1.5">
                        <i data-lucide="image" class="w-4 h-4 text-forest-700"></i>
                        Foto Produk
                    </h3>

                    <div class="p-4 rounded-2xl border border-stone-200 bg-stone-50/30 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-stone-200/70 text-stone-600 flex items-center justify-center flex-shrink-0">
                                <i data-lucide="image" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <span class="text-xs font-bold text-stone-800 block">Unggah Foto Produk Baru <span class="text-stone-400 font-normal">(Opsional)</span></span>
                                <span id="label-foto-produk" class="text-[11px] text-stone-400 block">
                                    @if($umkm->foto_produk)
                                    <a href="{{ $umkm->foto_produk_url }}" target="_blank" class="text-forest-700 font-semibold hover:underline">Lihat foto saat ini</a> — unggah foto baru untuk mengganti.
                                    @else
                                    Format JPG, PNG, atau WEBP (maks. 5 MB).
                                    @endif
                                </span>
                            </div>
                        </div>
                        <button type="button" onclick="document.getElementById('foto_produk').click()"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white border border-stone-300 text-xs font-semibold text-stone-700 hover:bg-stone-50 transition-all whitespace-nowrap shadow-2xs">
                            <i data-lucide="upload" class="w-3.5 h-3.5"></i>
                            Pilih Foto
                        </button>
                        <input type="file" id="foto_produk" name="foto_produk" accept=".jpg,.jpeg,.png,.webp" class="hidden"
                            onchange="updateFileName(this, 'label-foto-produk')">
                    </div>
                </div>

                {{-- Submit --}}
                <div class="pt-6 border-t border-stone-100 flex flex-col sm:flex-row items-center justify-end gap-3">
                    <a href="{{ route('pengajuan.show.detail', ['jenis' => 'umkm', 'id' => $umkm->pendaftaran_umkm_id]) }}"
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