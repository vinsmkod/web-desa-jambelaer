@extends('admin.layouts.admin')

@section('title', 'Tambah Jenis Surat')
@section('page_title', 'Tambah Jenis Surat')
@section('page_subtitle', 'Tambahkan jenis surat keterangan baru yang bisa diajukan masyarakat')

@section('content')

<div class="max-w-2xl">
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">

        {{-- Header --}}
        <div class="flex items-center gap-3 px-6 py-5 border-b border-slate-100">
            <div class="w-10 h-10 rounded-xl bg-forest-100 flex items-center justify-center">
                <i data-lucide="file-plus" class="w-5 h-5 text-forest-700"></i>
            </div>
            <div>
                <h2 class="font-display font-bold text-slate-900">Tambah Jenis Surat Baru</h2>
                <p class="text-xs text-slate-400 mt-0.5">Isi formulir di bawah ini untuk menambahkan jenis surat</p>
            </div>
        </div>

        {{-- Form --}}
        <form action="{{ route('admin.jenis-surat.store') }}" method="POST" class="px-6 py-6 space-y-5">
            @csrf

            {{-- Nama Surat --}}
            <div>
                <label for="nama_surat" class="block text-xs font-bold text-slate-700 mb-1.5">
                    Nama Surat <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nama_surat" id="nama_surat"
                    value="{{ old('nama_surat') }}"
                    placeholder="Contoh: Surat Keterangan Domisili"
                    class="w-full px-4 py-2.5 bg-white border {{ $errors->has('nama_surat') ? 'border-red-400' : 'border-slate-200' }} rounded-xl text-sm text-slate-800 focus:outline-none focus:border-forest-600 transition-colors">
                @error('nama_surat')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Kode Surat --}}
            <div>
                <label for="kode_surat" class="block text-xs font-bold text-slate-700 mb-1.5">
                    Kode Surat <span class="text-slate-400 font-normal">(opsional)</span>
                </label>
                <input type="text" name="kode_surat" id="kode_surat"
                    value="{{ old('kode_surat') }}"
                    placeholder="Contoh: SKD, SKU, SKBM"
                    class="w-full px-4 py-2.5 bg-white border {{ $errors->has('kode_surat') ? 'border-red-400' : 'border-slate-200' }} rounded-xl text-sm text-slate-800 focus:outline-none focus:border-forest-600 transition-colors">
                <p class="text-xs text-slate-400 mt-1">Singkatan atau kode resmi surat (maksimal 20 karakter)</p>
                @error('kode_surat')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div>
                <label for="deskripsi" class="block text-xs font-bold text-slate-700 mb-1.5">
                    Deskripsi <span class="text-slate-400 font-normal">(opsional)</span>
                </label>
                <textarea name="deskripsi" id="deskripsi" rows="3"
                    placeholder="Jelaskan secara singkat fungsi dan kegunaan surat ini..."
                    class="w-full px-4 py-2.5 bg-white border {{ $errors->has('deskripsi') ? 'border-red-400' : 'border-slate-200' }} rounded-xl text-sm text-slate-800 focus:outline-none focus:border-forest-600 transition-colors resize-none">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Persyaratan Khusus --}}
            <div>
                <label for="persyaratan_khusus" class="block text-xs font-bold text-slate-700 mb-1.5">
                    Persyaratan Khusus Tambahan <span class="text-slate-400 font-normal">(opsional)</span>
                </label>
                <textarea name="persyaratan_khusus" id="persyaratan_khusus" rows="4"
                    placeholder="Contoh: Akta kelahiran (asli &amp; fotokopi), Surat nikah, Surat keterangan RT/RW..."
                    class="w-full px-4 py-2.5 bg-white border {{ $errors->has('persyaratan_khusus') ? 'border-red-400' : 'border-slate-200' }} rounded-xl text-sm text-slate-800 focus:outline-none focus:border-forest-600 transition-colors resize-none">{{ old('persyaratan_khusus') }}</textarea>
                <p class="text-xs text-slate-400 mt-1">Dokumen pendukung selain KTP & KK yang wajib dilampirkan untuk jenis surat ini</p>
                @error('persyaratan_khusus')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                {{-- Urutan --}}
                <div>
                    <label for="urutan" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Urutan Tampil
                    </label>
                    <input type="number" name="urutan" id="urutan"
                        value="{{ old('urutan', 0) }}" min="0"
                        class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm text-slate-800 focus:outline-none focus:border-forest-600 transition-colors">
                    <p class="text-xs text-slate-400 mt-1">Angka lebih kecil = tampil lebih awal</p>
                </div>

                {{-- Status Aktif --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Status</label>
                    <div class="flex items-center gap-3 mt-1">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="is_active" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }}
                                class="w-4 h-4 text-forest-600 border-slate-300 focus:ring-forest-500">
                            <span class="text-sm font-semibold text-emerald-700">Aktif</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="is_active" value="0" {{ old('is_active', '1') == '0' ? 'checked' : '' }}
                                class="w-4 h-4 text-slate-400 border-slate-300 focus:ring-slate-400">
                            <span class="text-sm font-semibold text-slate-500">Nonaktif</span>
                        </label>
                    </div>
                    <p class="text-xs text-slate-400 mt-1.5">Hanya jenis aktif yang tampil di form pengajuan</p>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-2 border-t border-slate-100 mt-6">
                <a href="{{ route('admin.jenis-surat.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:text-slate-900 text-sm font-semibold transition-all">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-forest-800 hover:bg-forest-900 text-white rounded-xl text-sm font-bold transition-all shadow-sm ml-auto">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Simpan Jenis Surat
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
