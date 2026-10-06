@extends('layouts.app')

@section('title', 'Edit Pertanyaan – Desa Jambelaer')
@section('meta_desc', 'Perbaiki pertanyaan Anda di Desa Jambelaer. Pertanyaan hanya dapat diubah selama belum dijawab.')

@section('content')
{{-- Breadcrumb --}}
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 sm:pt-6">
    <nav class="flex items-center gap-1.5 text-xs text-stone-500 mb-4">
        <a href="{{ route('home') }}" class="hover:text-forest-800 transition-colors">Beranda</a>
        <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-stone-300"></i>
        <a href="{{ route('pengajuan.saya') }}" class="hover:text-forest-800 transition-colors">Pengajuan Saya</a>
        <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-stone-300"></i>
        <span class="text-forest-800 font-semibold">Edit Pertanyaan</span>
    </nav>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-forest-900 to-forest-800 text-white rounded-3xl p-6 sm:p-8 shadow-sm mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="px-2.5 py-1 rounded-lg bg-white/10 text-sand-300 border border-white/15 text-xs font-mono font-bold tracking-wider">
                    {{ $pertanyaan->nomor_pertanyaan }}
                </span>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold border {{ $pertanyaan->status_badge_class }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                    {{ $pertanyaan->status_label }}
                </span>
            </div>
            <h1 class="font-display font-extrabold text-xl sm:text-2xl text-white">Edit Pertanyaan Umum</h1>
            <p class="text-xs text-white/70 mt-1">
                Pertanyaan hanya dapat diperbarui selama belum mendapat jawaban dari administrator desa.
            </p>
        </div>
        <a href="{{ route('pengajuan.show.detail', ['jenis' => 'pertanyaan', 'id' => $pertanyaan->pertanyaan_id]) }}"
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

            <form action="{{ route('pertanyaan-umum.update', $pertanyaan->pertanyaan_id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Identitas --}}
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-stone-400 mb-4 flex items-center gap-1.5">
                        <i data-lucide="user" class="w-4 h-4 text-forest-700"></i>
                        Identitas Penanya
                    </h3>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label for="nama" class="block text-xs font-semibold text-stone-600 mb-1.5">Nama Lengkap <span class="text-rose-500">*</span></label>
                            <input type="text" id="nama" name="nama" required value="{{ old('nama', $pertanyaan->nama) }}"
                                class="w-full px-4 py-3 rounded-xl border border-stone-200 text-sm font-medium text-stone-800 bg-stone-50/50 focus:bg-white focus:border-forest-700 focus:ring-2 focus:ring-forest-100 outline-none transition-all">
                        </div>

                        <div>
                            <label for="no_whatsapp" class="block text-xs font-semibold text-stone-600 mb-1.5">Nomor WhatsApp Aktif <span class="text-rose-500">*</span></label>
                            <input type="tel" id="no_whatsapp" name="no_whatsapp" required placeholder="cth: 081234567890" value="{{ old('no_whatsapp', $pertanyaan->no_whatsapp) }}"
                                class="w-full px-4 py-3 rounded-xl border border-stone-200 text-sm font-medium text-stone-800 bg-stone-50/50 focus:bg-white focus:border-forest-700 focus:ring-2 focus:ring-forest-100 outline-none transition-all">
                        </div>
                    </div>
                </div>
                {{-- Isi Pertanyaan --}}
                <div class="pt-4 border-t border-stone-100">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-stone-400 mb-4 flex items-center gap-1.5">
                        <i data-lucide="help-circle" class="w-4 h-4 text-forest-700"></i>
                        Detail Pertanyaan
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <label for="subjek" class="block text-xs font-semibold text-stone-600 mb-1.5">Subjek / Topik <span class="text-rose-500">*</span></label>
                            <input type="text" id="subjek" name="subjek" required value="{{ old('subjek', $pertanyaan->subjek) }}"
                                class="w-full px-4 py-3 rounded-xl border border-stone-200 text-sm font-medium text-stone-800 bg-stone-50/50 focus:bg-white focus:border-forest-700 focus:ring-2 focus:ring-forest-100 outline-none transition-all">
                        </div>

                        <div>
                            <label for="pertanyaan" class="block text-xs font-semibold text-stone-600 mb-1.5">Isi Pertanyaan <span class="text-rose-500">*</span></label>
                            <textarea id="pertanyaan" name="pertanyaan" rows="6" required placeholder="Tuliskan pertanyaan Anda secara jelas"
                                class="w-full px-4 py-3 rounded-xl border border-stone-200 text-sm font-medium text-stone-800 bg-stone-50/50 focus:bg-white focus:border-forest-700 focus:ring-2 focus:ring-forest-100 outline-none transition-all resize-none">{{ old('pertanyaan', $pertanyaan->pertanyaan) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="pt-6 border-t border-stone-100 flex flex-col sm:flex-row items-center justify-end gap-3">
                    <a href="{{ route('pengajuan.show.detail', ['jenis' => 'pertanyaan', 'id' => $pertanyaan->pertanyaan_id]) }}"
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

@endsection