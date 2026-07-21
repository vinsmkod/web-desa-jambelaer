@extends('admin.layouts.admin')

@section('title', 'Edit Foto Galeri')
@section('page_title', 'Edit Foto Galeri')
@section('page_subtitle', 'Ubah informasi atau ganti foto galeri desa')

@section('content')
<div class="max-w-3xl">
    <form action="{{ route('admin.galeri.update', $galeri->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf @method('PUT')

        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-5">
            <h3 class="font-display font-bold text-white text-base border-b border-slate-800 pb-3">Edit Informasi Foto</h3>

            <!-- Judul -->
            <div>
                <label class="form-label">Judul Foto / Kegiatan <span class="text-red-400">*</span></label>
                <input type="text" name="judul" value="{{ old('judul', $galeri->judul) }}" required class="form-input">
                @error('judul') <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Kategori & Tanggal -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Kategori Galeri <span class="text-red-400">*</span></label>
                    <select name="kategori" required class="form-input">
                        @foreach($kategoriList as $key => $label)
                        <option value="{{ $key }}" {{ old('kategori', $galeri->kategori) == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('kategori') <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="form-label">Tanggal Publikasi / Kegiatan</label>
                    <input type="date" name="tanggal_publikasi" value="{{ old('tanggal_publikasi', $galeri->tanggal_publikasi ? $galeri->tanggal_publikasi->format('Y-m-d') : '') }}" class="form-input">
                    @error('tanggal_publikasi') <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Foto Preview & Upload -->
            <div>
                <label class="form-label">Foto Saat Ini</label>
                <div class="mb-3">
                    <img src="{{ asset($galeri->foto) }}" alt="{{ $galeri->judul }}" class="w-32 h-24 object-cover rounded-xl border border-slate-700">
                </div>
                <label class="form-label">Ganti Foto (Opsional)</label>
                <input type="file" name="foto" accept="image/*" class="form-input file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-600 file:text-white hover:file:bg-emerald-500 cursor-pointer">
                <p class="text-xs text-slate-500 mt-1">Biarkan kosong jika tidak ingin mengubah foto. Maksimal 3MB.</p>
                @error('foto') <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="form-label">Deskripsi Foto / Keterangan</label>
                <textarea name="deskripsi" rows="4" class="form-input resize-none">{{ old('deskripsi', $galeri->deskripsi) }}</textarea>
                @error('deskripsi') <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Options: Active & Urutan -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-slate-800">
                <div class="flex items-center gap-3">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $galeri->is_active) ? 'checked' : '' }} class="w-4 h-4 accent-emerald-600 rounded">
                    <label for="is_active" class="text-xs font-semibold text-slate-300">Tampilkan di Halaman Galeri</label>
                </div>

                <div>
                    <label class="form-label">Urutan Tampil</label>
                    <input type="number" name="urutan" value="{{ old('urutan', $galeri->urutan) }}" class="form-input">
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.galeri.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-700 text-slate-400 hover:bg-slate-800 text-sm font-semibold transition-all">Batal</a>
            <button type="submit" class="btn-primary">
                <i data-lucide="save" class="w-4 h-4"></i>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
