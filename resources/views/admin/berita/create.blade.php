@extends('admin.layouts.admin')

@section('title', 'Tambah Berita Baru')
@section('page_title', 'Tambah Berita Baru')
@section('page_subtitle', 'Tulis dan publikasikan artikel berita resmi Desa Jambelaer')

@section('content')
<div class="max-w-4xl space-y-6">

    <!-- Header Actions / Back Link -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.berita.index') }}" class="btn-secondary text-xs">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali ke Daftar Berita
        </a>
    </div>

    <!-- Main Form Card -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
        <div class="flex items-center gap-4 pb-6 mb-2 border-b border-slate-100">
            <div class="w-12 h-12 rounded-2xl bg-forest-800 text-white flex items-center justify-center shadow-xs flex-shrink-0">
                <i data-lucide="newspaper" class="w-6 h-6 text-amber-300"></i>
            </div>
            <div>
                <h2 class="text-base font-bold text-slate-900">Form Berita Desa Baru</h2>
                <p class="text-xs text-slate-500 mt-0.5">Isi seluruh informasi berita secara lengkap sebelum dipublikasikan ke publik</p>
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

        <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Judul Berita -->
            <div>
                <label for="judul" class="form-label">Judul Berita <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="heading" class="w-5 h-5"></i>
                    </div>
                    <input type="text" name="judul" id="judul" value="{{ old('judul') }}" required
                        placeholder="Contoh: Kerja Bakti Gotong Royong Pembersihan Saluran Irigasi Dusun II"
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
                        <i data-lucide="user-pen" class="w-5 h-5"></i>
                    </div>
                    <input type="text" name="penulis" id="penulis" value="{{ old('penulis', auth()->user()->name ?? 'Pemerintah Desa Jambelaer') }}" required
                        placeholder="Nama Penulis / Tim Redaksi"
                        class="form-input !pl-12 @error('penulis') border-red-400 @enderror">
                </div>
                @error('penulis')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Upload Gambar Berita -->
            <div>
                <label for="gambar" class="form-label">Foto Utama / Banner Berita <span class="text-slate-400 font-normal text-xs">(Opsional, max 3MB)</span></label>
                <div class="mt-1 flex items-center gap-4">
                    <div id="image-preview-container" class="w-32 h-20 rounded-xl bg-slate-50 border border-slate-200 overflow-hidden flex items-center justify-center text-slate-400 flex-shrink-0">
                        <i data-lucide="image" class="w-6 h-6"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <input type="file" name="gambar" id="gambar" accept="image/png, image/jpeg, image/jpg, image/webp"
                            onchange="previewImage(this)"
                            class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-forest-50 file:text-forest-700 hover:file:bg-forest-100 cursor-pointer">
                        <p class="text-[11px] text-slate-400 mt-1">Format yang didukung: JPG, PNG, WEBP. Ukuran disarankan rasio 16:9 (Landscape).</p>
                    </div>
                </div>
                @error('gambar')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Ringkasan Singkat -->
            <div>
                <label for="ringkasan" class="form-label">Ringkasan Berita <span class="text-slate-400 font-normal text-xs">(Tampil pada kartu berita)</span></label>
                <textarea name="ringkasan" id="ringkasan" rows="2"
                    placeholder="Tulis ringkasan singkat berita (1-2 kalimat)..."
                    class="form-input @error('ringkasan') border-red-400 @enderror">{{ old('ringkasan') }}</textarea>
                @error('ringkasan')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Konten Lengkap -->
            <div>
                <label for="konten" class="form-label">Isi Berita Lengkap <span class="text-red-500">*</span></label>
                <textarea name="konten" id="konten" rows="10" required
                    placeholder="Tuliskan berita secara rinci di sini..."
                    class="form-input font-sans text-sm leading-relaxed @error('konten') border-red-400 @enderror">{{ old('konten') }}</textarea>
                <p class="text-[11px] text-slate-400 mt-1">Anda dapat memisahkan paragraf dengan menekan Enter dua kali.</p>
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
                        <span class="text-sm font-semibold text-slate-800 block leading-tight">Publikasikan Berita Sekarang</span>
                        <span class="text-xs text-slate-500 block">Jika diaktifkan, berita akan langsung tampil di halaman depan website</span>
                    </div>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', '1') == '1' ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-forest-700"></div>
                </label>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.berita.index') }}" class="btn-secondary">
                    Batal
                </a>
                <button type="submit" class="btn-primary">
                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                    Simpan & Publikasikan
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
