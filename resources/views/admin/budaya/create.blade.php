@extends('admin.layouts.admin')

@section('title', 'Tambah Budaya')
@section('page_title', 'Tambah Budaya Baru')
@section('page_subtitle', 'Masukkan detail kesenian atau tradisi baru Desa Jambelaer')

@section('content')

<div class="max-w-3xl">
    <div class="mb-5">
        <a href="{{ route('admin.budaya.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-400 hover:text-white transition-colors">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            Kembali ke Daftar
        </a>
    </div>

    <form method="POST" action="{{ route('admin.budaya.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-5">
            <div class="flex items-center gap-3 border-b border-slate-800 pb-3">
                <div class="w-8 h-8 rounded-lg bg-emerald-600/20 flex items-center justify-center text-emerald-400">
                    <i data-lucide="music-4" class="w-4 h-4"></i>
                </div>
                <h2 class="font-display font-bold text-white text-sm">Informasi Budaya</h2>
            </div>

            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="form-label">Nama / Judul Budaya</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="form-input" placeholder="cth: Ruwatan Bumi" required>
                    @error('title') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Kategori</label>
                    <select name="kategori" class="form-input" required>
                        <option value="" disabled selected>Pilih Kategori</option>
                        <option value="Upacara Adat" {{ old('kategori') === 'Upacara Adat' ? 'selected' : '' }}>Upacara Adat</option>
                        <option value="Seni Pertunjukan" {{ old('kategori') === 'Seni Pertunjukan' ? 'selected' : '' }}>Seni Pertunjukan</option>
                        <option value="Seni Bela Diri" {{ old('kategori') === 'Seni Bela Diri' ? 'selected' : '' }}>Seni Bela Diri</option>
                        <option value="Festival Tahunan" {{ old('kategori') === 'Festival Tahunan' ? 'selected' : '' }}>Festival Tahunan</option>
                    </select>
                    @error('kategori') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="form-label">Deskripsi Singkat (Excerpt)</label>
                <input type="text" name="excerpt" value="{{ old('excerpt') }}" class="form-input" placeholder="cth: Upacara adat tanda syukur hasil bumi pertanian desa yang melimpah." required>
                <p class="text-[11px] text-slate-500 mt-1">Muncul di kartu luar halaman budaya. Maksimal 255 karakter.</p>
                @error('excerpt') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Deskripsi Lengkap</label>
                <textarea name="desc" rows="6" class="form-input resize-none" placeholder="Tuliskan cerita lengkap, sejarah, waktu pelaksanaan, dan detail lainnya mengenai tradisi/budaya ini..." required>{{ old('desc') }}</textarea>
                <p class="text-[11px] text-slate-500 mt-1">Muncul saat pengunjung menekan tombol "Lihat Detail" (Modal).</p>
                @error('desc') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="form-label">Foto / Gambar</label>
                    <input type="file" name="img" accept="image/*" class="form-input" onchange="previewImg(event)">
                    <p class="text-[11px] text-slate-500 mt-1.5">Format: JPG, PNG, WebP. Maks. 2 MB.</p>
                    @error('img') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Urutan Tampil</label>
                    <input type="number" name="urutan" value="{{ old('urutan', 0) }}" min="0" class="form-input">
                    <p class="text-[11px] text-slate-500 mt-1.5">Angka lebih kecil akan muncul terlebih dahulu.</p>
                    @error('urutan') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div id="preview-container" class="mt-2 hidden">
                <p class="form-label">Pratinjau Gambar:</p>
                <img id="img-preview" src="" alt="Pratinjau Foto" class="w-full max-h-64 object-cover rounded-xl border border-slate-800 shadow-md">
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pb-8">
            <a href="{{ route('admin.budaya.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-400 hover:text-white border border-slate-800 hover:border-slate-600 transition-colors">
                Batal
            </a>
            <button type="submit" class="btn-primary">
                <i data-lucide="save" class="w-4 h-4"></i>
                Simpan Budaya
            </button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    function previewImg(event) {
        const preview = document.getElementById('img-preview');
        const container = document.getElementById('preview-container');
        const file = event.target.files[0];
        if (file) {
            preview.src = URL.createObjectURL(file);
            container.classList.remove('hidden');
        } else {
            container.classList.add('hidden');
        }
    }
</script>
@endpush
