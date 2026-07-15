@extends('admin.layouts.admin')

@section('title', 'Tambah Produk')
@section('page_title', 'Tambah Produk Baru')
@section('page_subtitle', 'Isi detail produk UMKM yang akan ditampilkan')

@section('content')

<div class="max-w-3xl">
    <form method="POST" action="{{ route('admin.produk.store') }}" class="space-y-6" enctype="multipart/form-data">
        @csrf

        {{-- Basic Info --}}
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-5">
            <h2 class="font-display font-bold text-white text-sm border-b border-slate-800 pb-3">Informasi Dasar</h2>

            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="form-label">Nama Produk *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                        class="form-input" placeholder="cth: Gula Aren Cetak Murni">
                    @error('title') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Nama Produsen / UMKM *</label>
                    <input type="text" name="producer" value="{{ old('producer') }}" required
                        class="form-input" placeholder="cth: KWT Melati Lestari">
                    @error('producer') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="form-label">Harga *</label>
                    <input type="text" name="price" value="{{ old('price') }}" required
                        class="form-input" placeholder="cth: Rp 15.000 / kg">
                    @error('price') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Badge / Jenis *</label>
                    <select name="badge" required class="form-input">
                        <option value="">Pilih Badge</option>
                        <option value="Pertanian" {{ old('badge') === 'Pertanian'  ? 'selected' : '' }}>Pertanian</option>
                        <option value="Makanan" {{ old('badge') === 'Makanan'    ? 'selected' : '' }}>Makanan</option>
                        <option value="Kerajinan" {{ old('badge') === 'Kerajinan'  ? 'selected' : '' }}>Kerajinan</option>
                        <option value="Minuman" {{ old('badge') === 'Minuman'    ? 'selected' : '' }}>Minuman</option>
                        <option value="Lainnya" {{ old('badge') === 'Lainnya'    ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('badge') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Jenis Produk (Kelompok) --}}
            <div class="border-t border-slate-800 pt-5">
                <label class="form-label">Kelompok Jenis Produk
                    <span class="text-slate-500 font-normal normal-case tracking-normal text-xs ml-1">– Opsional (isi jika produk ini termasuk kelompok, cth: opak)</span>
                </label>
                <div class="grid sm:grid-cols-2 gap-5 mt-2">
                    <div>
                        <input type="text" name="jenis" value="{{ old('jenis') }}"
                            class="form-input" placeholder="cth: opak (huruf kecil, tanpa spasi)">
                        <p class="text-xs text-slate-500 mt-1">Slug kelompok, cth: <code class="text-emerald-400">opak</code></p>
                        @error('jenis') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <input type="text" name="jenis_label" value="{{ old('jenis_label') }}"
                            class="form-input" placeholder="cth: Opak">
                        <p class="text-xs text-slate-500 mt-1">Nama tampilan, cth: <code class="text-emerald-400">Opak</code></p>
                        @error('jenis_label') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div>
                <label class="form-label">Kategori Filter *</label>
                <div class="flex flex-wrap gap-3 mt-1">
                    @foreach(['pertanian','makanan','kerajinan','minuman','lainnya'] as $cat)
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="category[]" value="{{ $cat }}"
                            {{ in_array($cat, old('category', [])) ? 'checked' : '' }}
                            class="w-4 h-4 rounded border-slate-700 bg-slate-800 text-emerald-500 focus:ring-emerald-500 focus:ring-offset-slate-900">
                        <span class="text-sm text-slate-300 capitalize">{{ $cat }}</span>
                    </label>
                    @endforeach
                </div>
                @error('category') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Gambar Produk *</label>
                <input type="file" name="img" id="img-upload" required accept="image/*"
                    class="form-input" onchange="previewImg(event)">
                <div id="img-preview" class="mt-3 hidden">
                    <img id="img-preview-el" src="" alt="Preview"
                        class="h-32 rounded-xl object-cover border border-slate-700 shadow-md">
                </div>
                @error('img') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Description --}}
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-5">
            <h2 class="font-display font-bold text-white text-sm border-b border-slate-800 pb-3">Deskripsi</h2>

            <div>
                <label class="form-label">Deskripsi Singkat *</label>
                <textarea name="desc_short" rows="2" required class="form-input"
                    placeholder="Deskripsi singkat yang tampil di kartu produk...">{{ old('desc_short') }}</textarea>
                @error('desc_short') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Deskripsi Lengkap *</label>
                <textarea name="desc_long" rows="5" required class="form-input"
                    placeholder="Deskripsi lengkap yang tampil di halaman detail produk...">{{ old('desc_long') }}</textarea>
                @error('desc_long') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Details Table --}}
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                <h2 class="font-display font-bold text-white text-sm">Detail Spesifikasi</h2>
                <button type="button" onclick="addDetailRow()"
                    class="text-xs text-emerald-400 hover:text-emerald-300 flex items-center gap-1">
                    <i data-lucide="plus" class="w-3.5 h-3.5"></i> Tambah Baris
                </button>
            </div>
            <div id="details-container" class="space-y-3">
                @php $oldDetails = old('detail_keys', ['Berat Bersih', 'Kemasan', 'Masa Simpan', 'Sertifikasi', 'Ketersediaan']); @endphp
                @foreach($oldDetails as $i => $key)
                <div class="flex gap-3 detail-row">
                    <input type="text" name="detail_keys[]" value="{{ $key }}"
                        class="form-input flex-1" placeholder="Nama spesifikasi">
                    <input type="text" name="detail_values[]" value="{{ old('detail_values.'.$i, '') }}"
                        class="form-input flex-1" placeholder="Nilai">
                    <button type="button" onclick="removeRow(this)"
                        class="w-10 h-10 flex items-center justify-center rounded-xl text-slate-600 hover:text-red-400 hover:bg-red-600/10 transition-all flex-shrink-0">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Settings --}}
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-5">
            <h2 class="font-display font-bold text-white text-sm border-b border-slate-800 pb-3">Pengaturan Tampil</h2>
            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="form-label">Urutan Tampil</label>
                    <input type="number" name="urutan" value="{{ old('urutan', 0) }}" min="0"
                        class="form-input" placeholder="0">
                </div>
                <div class="flex items-center gap-3 mt-6">
                    <input type="checkbox" id="is_active" name="is_active" value="1"
                        {{ old('is_active', '1') ? 'checked' : '' }}
                        class="w-4 h-4 rounded border-slate-700 bg-slate-800 text-emerald-500 focus:ring-emerald-500 focus:ring-offset-slate-900">
                    <label for="is_active" class="text-sm text-slate-300 cursor-pointer">Tampilkan di website</label>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-3 justify-end">
            <a href="{{ route('admin.produk.index') }}"
                class="px-5 py-2.5 rounded-xl border border-slate-700 text-slate-400 hover:text-slate-200 text-sm font-semibold transition-all">
                Batal
            </a>
            <button type="submit" class="btn-primary">
                <i data-lucide="save" class="w-4 h-4"></i>
                Simpan Produk
            </button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    function previewImg(event) {
        const preview = document.getElementById('img-preview');
        const img = document.getElementById('img-preview-el');
        const file = event.target.files[0];
        if (file) {
            img.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
        } else {
            preview.classList.add('hidden');
        }
    }

    function addDetailRow() {
        const container = document.getElementById('details-container');
        const div = document.createElement('div');
        div.className = 'flex gap-3 detail-row';
        div.innerHTML = `
            <input type="text" name="detail_keys[]" class="form-input flex-1" placeholder="Nama spesifikasi">
            <input type="text" name="detail_values[]" class="form-input flex-1" placeholder="Nilai">
            <button type="button" onclick="removeRow(this)"
                class="w-10 h-10 flex items-center justify-center rounded-xl text-slate-600 hover:text-red-400 hover:bg-red-600/10 transition-all flex-shrink-0">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>`;
        container.appendChild(div);
        lucide.createIcons();
    }

    function removeRow(btn) {
        btn.closest('.detail-row').remove();
    }

    // Preview is handled on input change
</script>
@endpush