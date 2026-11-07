@extends('admin.layouts.admin')

@section('title', 'Edit Produk')
@section('page_title', 'Edit Produk')
@section('page_subtitle', $produk->title)

@section('content')

<div class="max-w-3xl">
    <form method="POST" action="{{ route('admin.produk.update', $produk) }}" class="space-y-6" enctype="multipart/form-data">
        @csrf @method('PUT')

        {{-- Basic Info --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-6 space-y-5">
            <h2 class="font-display font-bold text-slate-900 text-sm border-b border-slate-100 pb-3">Informasi Dasar</h2>

            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="form-label">Nama Produk *</label>
                    <input type="text" name="title" value="{{ old('title', $produk->title) }}" required
                        class="form-input" placeholder="cth: Gula Aren Cetak Murni">
                    @error('title') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Nama Produsen / UMKM *</label>
                    <input type="text" name="producer" value="{{ old('producer', $produk->producer) }}" required
                        class="form-input">
                    @error('producer') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="form-label">Harga *</label>
                    <input type="text" name="price" value="{{ old('price', $produk->price) }}" required
                        class="form-input" placeholder="cth: Rp 15.000 / kg">
                    @error('price') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Badge / Jenis *</label>
                    <select name="badge" required class="form-input">
                        @foreach(['Makanan','Kerajinan'] as $b)
                        <option value="{{ $b }}" {{ old('badge', $produk->badge) === $b ? 'selected' : '' }}>{{ $b }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Jenis Produk (Kelompok) --}}
            <div class="border-t border-slate-200 pt-5">
                <label class="form-label">Kelompok Jenis Produk
                    <span class="text-slate-500 font-normal normal-case tracking-normal text-xs ml-1">– Opsional (isi jika produk ini termasuk kelompok, cth: opak)</span>
                </label>
                <div class="grid sm:grid-cols-2 gap-5 mt-2">
                    <div>
                        <input type="text" name="jenis" value="{{ old('jenis', $produk->jenis) }}"
                            class="form-input" placeholder="cth: opak (huruf kecil, tanpa spasi)">
                        <p class="text-xs text-slate-500 mt-1">Slug kelompok, cth: <code class="text-emerald-400">opak</code></p>
                        @error('jenis') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <input type="text" name="jenis_label" value="{{ old('jenis_label', $produk->jenis_label) }}"
                            class="form-input" placeholder="cth: Opak">
                        <p class="text-xs text-slate-500 mt-1">Nama tampilan, cth: <code class="text-emerald-400">Opak</code></p>
                        @error('jenis_label') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div>
                <label class="form-label">Kategori Filter *</label>
                <div class="flex flex-wrap gap-3 mt-1">
                    @foreach(['makanan','kerajinan'] as $cat)
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="category[]" value="{{ $cat }}"
                            {{ in_array($cat, old('category', $produk->category ?? [])) ? 'checked' : '' }}
                            class="w-4 h-4 rounded border-slate-200 bg-slate-100 text-emerald-500 focus:ring-emerald-500 focus:ring-offset-slate-900">
                        <span class="text-sm text-slate-300 capitalize">{{ $cat }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="form-label">Gambar Produk (Kosongkan jika tidak ingin diubah)</label>
                <input type="file" name="img" id="img-upload" accept="image/*"
                    class="form-input" onchange="previewImg(event)">
                <div id="img-preview" class="mt-3">
                    <p class="text-xs text-slate-500 mb-1.5 font-medium">Pratinjau / Gambar Saat Ini:</p>
                    <img id="img-preview-el" src="{{ $produk->img_url }}" alt="Preview"
                         class="h-32 rounded-xl object-cover border border-slate-200 shadow-md">
                </div>
            </div>

            <div>
                <label class="form-label text-slate-500">Slug (tidak dapat diubah)</label>
                <input type="text" value="{{ $produk->slug }}" disabled
                    class="form-input opacity-40 cursor-not-allowed">
            </div>
        </div>

        {{-- Informas Pemilik & Kontak UMKM --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-6 space-y-5">
            <h2 class="font-display font-bold text-slate-900 text-sm border-b border-slate-100 pb-3">Informasi Pemilik &amp; Kontak UMKM</h2>

            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="form-label">Nama Pemilik UMKM</label>
                    <input type="text" name="nama_pemilik" value="{{ old('nama_pemilik', $produk->nama_pemilik) }}"
                        class="form-input" placeholder="cth: Ibu Suryani">
                    @error('nama_pemilik') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Nomor WhatsApp UMKM</label>
                    <input type="text" name="no_whatsapp_umkm" value="{{ old('no_whatsapp_umkm', $produk->no_whatsapp_umkm) }}"
                        class="form-input" placeholder="cth: 081234567890">
                    @error('no_whatsapp_umkm') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="form-label">Jam Operasional</label>
                    <input type="text" name="jam_operasional" value="{{ old('jam_operasional', $produk->jam_operasional) }}"
                        class="form-input" placeholder="cth: Senin - Sabtu (08.00 - 17.00 WIB)">
                    @error('jam_operasional') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Instagram (Opsional)</label>
                    <input type="text" name="instagram_umkm" value="{{ old('instagram_umkm', $produk->instagram_umkm) }}"
                        class="form-input" placeholder="cth: @umkmjambelaer">
                    @error('instagram_umkm') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="form-label">Alamat Lengkap UMKM</label>
                <textarea name="alamat_umkm" rows="2" class="form-input resize-none"
                    placeholder="cth: RT 04/RW 02, Dusun Jambelaer I, Desa Jambelaer">{{ old('alamat_umkm', $produk->alamat_umkm) }}</textarea>
                @error('alamat_umkm') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Link Marketplace (Opsional)</label>
                <input type="url" name="link_marketplace" value="{{ old('link_marketplace', $produk->link_marketplace) }}"
                    class="form-input" placeholder="cth: https://shopee.co.id/namatoko">
                @error('link_marketplace') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Description --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-6 space-y-5">
            <h2 class="font-display font-bold text-slate-900 text-sm border-b border-slate-100 pb-3">Deskripsi</h2>

            <div>
                <label class="form-label">Deskripsi Singkat *</label>
                <textarea name="desc_short" rows="2" required class="form-input">{{ old('desc_short', $produk->desc_short) }}</textarea>
            </div>
            <div>
                <label class="form-label">Deskripsi Lengkap *</label>
                <textarea name="desc_long" rows="5" required class="form-input">{{ old('desc_long', $produk->desc_long) }}</textarea>
            </div>
        </div>

        {{-- Details --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h2 class="font-display font-bold text-slate-900 text-sm">Detail Spesifikasi</h2>
                <button type="button" onclick="addDetailRow()"
                    class="text-xs text-emerald-400 hover:text-emerald-300 flex items-center gap-1">
                    <i data-lucide="plus" class="w-3.5 h-3.5"></i> Tambah Baris
                </button>
            </div>
            <div id="details-container" class="space-y-3">
                @php $details = old('detail_keys') ? array_combine(old('detail_keys', []), old('detail_values', [])) : ($produk->details ?? []); @endphp
                @foreach($details as $key => $val)
                <div class="flex gap-3 detail-row">
                    <input type="text" name="detail_keys[]" value="{{ $key }}" class="form-input flex-1" placeholder="Nama spesifikasi">
                    <input type="text" name="detail_values[]" value="{{ $val }}" class="form-input flex-1" placeholder="Nilai">
                    <button type="button" onclick="removeRow(this)"
                        class="w-10 h-10 flex items-center justify-center rounded-xl text-slate-600 hover:text-red-400 hover:bg-red-600/10 transition-all flex-shrink-0">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Settings --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-6">
            <h2 class="font-display font-bold text-slate-900 text-sm border-b border-slate-100 pb-3 mb-5">Pengaturan Tampil</h2>
            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="form-label">Urutan Tampil</label>
                    <input type="number" name="urutan" value="{{ old('urutan', $produk->urutan) }}" min="0" class="form-input">
                </div>
                <div class="flex items-center gap-3 mt-6">
                    <input type="checkbox" id="is_active" name="is_active" value="1"
                        {{ old('is_active', $produk->is_active) ? 'checked' : '' }}
                        class="w-4 h-4 rounded border-slate-200 bg-slate-100 text-emerald-500 focus:ring-emerald-500 focus:ring-offset-slate-900">
                    <label for="is_active" class="text-sm text-slate-300 cursor-pointer">Tampilkan di website</label>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3 justify-between">
            <button type="submit" form="delete-form" class="btn-danger">
                <i data-lucide="trash-2" class="w-4 h-4"></i>
                Hapus Produk
            </button>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.produk.index') }}"
                   class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-400 hover:text-slate-200 text-sm font-semibold transition-all">
                    Batal
                </a>
                <button type="submit" class="btn-primary">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>

    <form id="delete-form" method="POST" action="{{ route('admin.produk.destroy', $produk) }}"
          onsubmit="return confirm('Hapus produk ini secara permanen?')" class="hidden">
        @csrf @method('DELETE')
    </form>
</div>

@endsection

@push('scripts')
<script>
    function previewImg(event) {
        const img = document.getElementById('img-preview-el');
        const file = event.target.files[0];
        if (file) {
            img.src = URL.createObjectURL(file);
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
</script>
@endpush


