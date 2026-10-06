@extends('layouts.app')

@section('title', 'Edit Pengaduan – Desa Jambelaer')
@section('meta_desc', 'Perbaiki data pengaduan Anda di Desa Jambelaer. Pengaduan hanya dapat diubah selama masih berstatus Diajukan.')

@section('content')
{{-- Breadcrumb --}}
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 sm:pt-6">
    <nav class="flex items-center gap-1.5 text-xs text-stone-500 mb-4">
        <a href="{{ route('home') }}" class="hover:text-forest-800 transition-colors">Beranda</a>
        <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-stone-300"></i>
        <a href="{{ route('pengajuan.saya') }}" class="hover:text-forest-800 transition-colors">Pengajuan Saya</a>
        <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-stone-300"></i>
        <span class="text-forest-800 font-semibold">Edit Pengaduan</span>
    </nav>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-forest-900 to-forest-800 text-white rounded-3xl p-6 sm:p-8 shadow-sm mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="px-2.5 py-1 rounded-lg bg-white/10 text-sand-300 border border-white/15 text-xs font-mono font-bold tracking-wider">
                    {{ $pengaduan->nomor_pengaduan }}
                </span>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold border {{ $pengaduan->status_badge_class }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                    {{ $pengaduan->status_label }}
                </span>
            </div>
            <h1 class="font-display font-extrabold text-xl sm:text-2xl text-white">Edit Pengaduan</h1>
            <p class="text-xs text-white/70 mt-1">
                Lengkapi kembali informasi pengaduan Anda. Foto bukti lama tetap dipakai apabila tidak ada unggahan baru.
            </p>
        </div>
        <a href="{{ route('pengajuan.show.detail', ['jenis' => 'pengaduan', 'id' => $pengaduan->pengaduan_id]) }}"
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

            <form action="{{ route('pengaduan.update', $pengaduan->pengaduan_id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                {{-- Identitas Pelapor --}}
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-stone-400 mb-4 flex items-center gap-1.5">
                        <i data-lucide="user" class="w-4 h-4 text-forest-700"></i>
                        Identitas Pelapor
                    </h3>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label for="nama" class="block text-xs font-semibold text-stone-600 mb-1.5">Nama Lengkap <span class="text-rose-500">*</span></label>
                            <input type="text" id="nama" name="nama" required value="{{ old('nama', $pengaduan->nama) }}"
                                class="w-full px-4 py-3 rounded-xl border border-stone-200 text-sm font-medium text-stone-800 bg-stone-50/50 focus:bg-white focus:border-forest-700 focus:ring-2 focus:ring-forest-100 outline-none transition-all">
                        </div>

                        <div>
                            <label for="no_whatsapp" class="block text-xs font-semibold text-stone-600 mb-1.5">Nomor WhatsApp Aktif <span class="text-rose-500">*</span></label>
                            <input type="tel" id="no_whatsapp" name="no_whatsapp" required placeholder="cth: 081234567890" value="{{ old('no_whatsapp', $pengaduan->no_whatsapp) }}"
                                class="w-full px-4 py-3 rounded-xl border border-stone-200 text-sm font-medium text-stone-800 bg-stone-50/50 focus:bg-white focus:border-forest-700 focus:ring-2 focus:ring-forest-100 outline-none transition-all">
                        </div>
                    </div>
                </div>

                {{-- Isi Pengaduan --}}
                <div class="pt-4 border-t border-stone-100">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-stone-400 mb-4 flex items-center gap-1.5">
                        <i data-lucide="megaphone" class="w-4 h-4 text-forest-700"></i>
                        Detail Pengaduan
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <label for="judul" class="block text-xs font-semibold text-stone-600 mb-1.5">Judul Pengaduan <span class="text-rose-500">*</span></label>
                            <input type="text" id="judul" name="judul" required value="{{ old('judul', $pengaduan->judul) }}"
                                class="w-full px-4 py-3 rounded-xl border border-stone-200 text-sm font-medium text-stone-800 bg-stone-50/50 focus:bg-white focus:border-forest-700 focus:ring-2 focus:ring-forest-100 outline-none transition-all">
                        </div>

                        <div>
                            <label for="lokasi" class="block text-xs font-semibold text-stone-600 mb-1.5">Lokasi Kejadian <span class="text-stone-400 font-normal">(Opsional)</span></label>
                            <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi', $pengaduan->lokasi) }}" placeholder="cth: Kp. Melong RT 03, dekat jembatan"
                                class="w-full px-4 py-3 rounded-xl border border-stone-200 text-sm font-medium text-stone-800 bg-stone-50/50 focus:bg-white focus:border-forest-700 focus:ring-2 focus:ring-forest-100 outline-none transition-all">
                        </div>

                        <div>
                            <label for="isi_pengaduan" class="block text-xs font-semibold text-stone-600 mb-1.5">Uraian Pengaduan <span class="text-rose-500">*</span></label>
                            <textarea id="isi_pengaduan" name="isi_pengaduan" rows="5" required placeholder="Jelaskan kejadian atau permasalahan yang Anda adukan secara rinci"
                                class="w-full px-4 py-3 rounded-xl border border-stone-200 text-sm font-medium text-stone-800 bg-stone-50/50 focus:bg-white focus:border-forest-700 focus:ring-2 focus:ring-forest-100 outline-none transition-all resize-none">{{ old('isi_pengaduan', $pengaduan->isi_pengaduan) }}</textarea>
                        </div>
                    </div>
                </div>
                {{-- Foto Bukti --}}
                <div class="pt-4 border-t border-stone-100">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-stone-400 mb-4 flex items-center gap-1.5">
                        <i data-lucide="camera" class="w-4 h-4 text-forest-700"></i>
                        Foto Bukti <span class="text-stone-400 font-normal">(Opsional)</span>
                    </h3>

                    <div class="p-4 rounded-2xl border border-stone-200 bg-stone-50/30 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-stone-200/70 text-stone-600 flex items-center justify-center flex-shrink-0">
                                <i data-lucide="image" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <span class="text-xs font-bold text-stone-800 block">Unggah Foto Bukti Baru</span>
                                <span id="label-foto-bukti" class="text-[11px] text-stone-400 block">
                                    @if($pengaduan->foto_bukti)
                                    <a href="{{ asset('storage/' . $pengaduan->foto_bukti) }}" target="_blank" class="text-forest-700 font-semibold hover:underline">Lihat foto saat ini</a> — unggah foto baru untuk mengganti.
                                    @else
                                    Format JPG, PNG, atau WEBP (maks. 5 MB).
                                    @endif
                                </span>
                            </div>
                        </div>
                        <button type="button" onclick="document.getElementById('foto_bukti').click()"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white border border-stone-300 text-xs font-semibold text-stone-700 hover:bg-stone-50 transition-all whitespace-nowrap shadow-2xs">
                            <i data-lucide="upload" class="w-3.5 h-3.5"></i>
                            Pilih Foto
                        </button>
                        <input type="file" id="foto_bukti" name="foto_bukti" accept=".jpg,.jpeg,.png,.webp" class="hidden"
                            onchange="updateFileName(this, 'label-foto-bukti')">
                    </div>
                </div>

                {{-- Submit --}}
                <div class="pt-6 border-t border-stone-100 flex flex-col sm:flex-row items-center justify-end gap-3">
                    <a href="{{ route('pengajuan.show.detail', ['jenis' => 'pengaduan', 'id' => $pengaduan->pengaduan_id]) }}"
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