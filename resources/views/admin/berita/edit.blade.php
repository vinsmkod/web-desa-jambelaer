@extends('admin.layouts.admin')

@section('title', 'Edit Berita')
@section('page_title', 'Edit Berita')
@section('page_subtitle', 'Perbarui konten artikel berita ' . $berita->judul)

@section('content')
<div class="max-w-4xl space-y-6">

    <!-- Header Actions / Back Link -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.berita.index') }}" class="btn-secondary text-xs">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali ke Daftar Berita
        </a>
        <a href="{{ route('berita.detail', $berita->slug) }}" target="_blank"
           class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-forest-50 text-forest-700 border border-forest-200 text-xs font-semibold hover:bg-forest-100 transition-all">
            <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
            Lihat Halaman Berita
        </a>
    </div>

    <!-- Main Form Card -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
        <div class="flex items-center gap-4 pb-6 mb-2 border-b border-slate-100">
            <div class="w-12 h-12 rounded-2xl bg-forest-800 text-white flex items-center justify-center shadow-xs flex-shrink-0">
                <i data-lucide="edit-3" class="w-6 h-6 text-amber-300"></i>
            </div>
            <div>
                <h2 class="text-base font-bold text-slate-900">Edit Berita Desa</h2>
                <p class="text-xs text-slate-500 mt-0.5">Ubah informasi artikel berita, gambar, atau status publikasi</p>
            </div>
        </div>

        @if ($errors->any())
        <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-600 text-xs space-y-1.5">
            <div class="font-bold flex items-center gap-2">
                <i data-lucide="alert-circle" class="w-4 h-4"></i>
                <span>Terdapat beberapa kesalahan pengisian form:</span>
            </div>
            <ul class="list-disc list-inside space-y-1 pl-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Judul Berita -->
            <div>
                <label for="judul" class="form-label">Judul Berita <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="heading" class="w-5 h-5"></i>
                    </div>
                    <input type="text" name="judul" id="judul" value="{{ old('judul', $berita->judul) }}" required
                        placeholder="Judul Berita"
                        class="form-input !pl-12 @error('judul') border-red-400 @enderror">
                </div>
                @error('judul')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Penulis -->
            <div>
                <label for="penulis" class="form-label">Penulis / Redaksi <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="user-edit" class="w-5 h-5"></i>
                    </div>
                    <input type="text" name="penulis" id="penulis" value="{{ old('penulis', $berita->penulis) }}" required
                        placeholder="Nama Penulis / Tim Redaksi"
                        class="form-input !pl-12 @error('penulis') border-red-400 @enderror">
                </div>
                @error('penulis')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kategori Berita -->
            <div>
                <label for="kategori" class="form-label">Kategori Berita <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="tag" class="w-5 h-5"></i>
                    </div>
                    <select name="kategori" id="kategori" required
                        class="form-input !pl-12 @error('kategori') border-red-400 @enderror">
                        @foreach(App\Models\Berita::kategoriList() as $key => $label)
                            <option value="{{ $key }}" {{ old('kategori', $berita->kategori) === $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('kategori')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Upload Gambar Berita -->
            <div>
                <label for="gambar" class="form-label">Foto Utama / Banner Berita <span class="text-slate-400 font-normal text-xs">(Kosongkan jika tidak ingin mengubah)</span></label>
                <div class="mt-1 flex items-center gap-4">
                    <div id="image-preview-container" class="w-32 h-20 rounded-xl bg-slate-50 border border-slate-200 overflow-hidden flex items-center justify-center text-slate-400 flex-shrink-0">
                        <img src="{{ $berita->gambar_url }}" alt="{{ $berita->judul }}" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1 min-w-0">
                        <input type="file" name="gambar" id="gambar" accept="image/png, image/jpeg, image/jpg, image/webp"
                            onchange="previewImage(this)"
                            class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-forest-50 file:text-forest-700 hover:file:bg-forest-100 cursor-pointer">
                        <p class="text-[11px] text-slate-400 mt-1">Format: JPG, PNG, WEBP. Maksimal 3MB.</p>
                    </div>
                </div>
                @error('gambar')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Ringkasan Singkat -->
            <div>
                <label for="ringkasan" class="form-label">Ringkasan Berita</label>
                <textarea name="ringkasan" id="ringkasan" rows="2"
                    class="form-input @error('ringkasan') border-red-400 @enderror">{{ old('ringkasan', $berita->ringkasan) }}</textarea>
                @error('ringkasan')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Konten Lengkap -->
            <div>
                <label for="konten" class="form-label">Isi Berita Lengkap <span class="text-red-500">*</span></label>
                <textarea name="konten" id="konten" rows="10" required
                    class="form-input font-sans text-sm leading-relaxed @error('konten') border-red-400 @enderror">{{ old('konten', $berita->konten) }}</textarea>
                @error('konten')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status Publikasi -->
            <div class="p-4 rounded-xl bg-forest-50/60 border border-forest-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-forest-100 border border-forest-200 flex items-center justify-center text-forest-700">
                        <i data-lucide="globe" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <span class="text-sm font-semibold text-slate-800 block leading-tight">Publikasikan Berita</span>
                        <span class="text-xs text-slate-500 block">Berita dapat diakses oleh publik jika status ini diaktifkan</span>
                    </div>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', $berita->is_published) ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-forest-700"></div>
                </label>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.berita.index') }}" class="btn-secondary">
                    Batal
                </a>
                <button type="submit" class="btn-primary">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>

@push('scripts')
<script>
    function previewImage(input) {
        const container = document.getElementById('image-preview-container');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                container.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection
