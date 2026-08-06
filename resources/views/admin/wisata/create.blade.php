@extends('admin.layouts.admin')

@section('title', 'Tambah Wisata')
@section('page_title', 'Tambah Destinasi Wisata Baru')
@section('page_subtitle', 'Masukkan detail informasi destinasi wisata baru di Desa Jambelaer')

@section('content')

<div class="max-w-3xl pb-12">
    <div class="mb-5">
        <a href="{{ route('admin.wisata.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-slate-800 transition-colors">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            Kembali ke Daftar
        </a>
    </div>

    <form method="POST" action="{{ route('admin.wisata.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="bg-white border border-slate-200 rounded-2xl p-6 space-y-5 shadow-sm">
            <div class="flex items-center gap-3 border-b border-slate-100 pb-3">
                <div class="w-8 h-8 rounded-lg bg-emerald-600/20 flex items-center justify-center text-emerald-600">
                    <i data-lucide="compass" class="w-4 h-4"></i>
                </div>
                <h2 class="font-display font-bold text-slate-900 text-sm">Informasi Destinasi Wisata</h2>
            </div>

            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="form-label">Nama Wisata</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" class="form-input" placeholder="cth: Curug Cipeuteuy" required>
                    @error('nama') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Kategori Wisata</label>
                    <select name="kategori" class="form-input" required>
                        <option value="" disabled selected>Pilih Kategori</option>
                        @foreach($categories as $key => $label)
                            <option value="{{ $key }}" {{ old('kategori') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('kategori') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="form-label">Ringkasan (Excerpt)</label>
                <input type="text" name="ringkasan" value="{{ old('ringkasan') }}" class="form-input" placeholder="cth: Keindahan curug alami dengan air yang sangat jernih di kaki pegunungan." required>
                <p class="text-[11px] text-slate-500 mt-1">Muncul di kartu luar halaman pariwisata. Maksimal 255 karakter.</p>
                @error('ringkasan') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Deskripsi Lengkap</label>
                <textarea name="deskripsi" rows="6" class="form-input resize-none" placeholder="Tuliskan cerita lengkap, daya tarik utama, rute, sarana/fasilitas, dan detail penting lainnya mengenai destinasi wisata ini..." required>{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="form-label">Harga Tiket Masuk</label>
                    <input type="text" name="harga_tiket" value="{{ old('harga_tiket', 'Gratis') }}" class="form-input" placeholder="cth: Rp 10.000 / Orang" required>
                    @error('harga_tiket') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Jam Operasional</label>
                    <input type="text" name="jam_operasional" value="{{ old('jam_operasional', '08:00 - 17:00 WIB') }}" class="form-input" placeholder="cth: 08:00 - 17:00 WIB" required>
                    @error('jam_operasional') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="form-label">Alamat / Lokasi Wisata</label>
                <input type="text" name="alamat" value="{{ old('alamat') }}" class="form-input" placeholder="cth: Dusun Cikondang, Desa Jambelaer" required>
                @error('alamat') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Embed Google Maps (Iframe/URL)</label>
                <textarea name="maps_iframe" rows="3" class="form-input resize-none" placeholder="Masukkan kode &lt;iframe&gt; embed map dari Google Maps atau link lokasinya...">{{ old('maps_iframe') }}</textarea>
                <p class="text-[11px] text-slate-500 mt-1">Caranya: Buka Google Maps &gt; Cari lokasi &gt; Klik "Bagikan" &gt; Klik "Sematkan peta" (Embed a map) &gt; Salin seluruh tag HTML <code class="bg-slate-100 px-1 py-0.5 rounded font-mono text-slate-700">&lt;iframe&gt;</code> lalu tempel di sini.</p>
                @error('maps_iframe') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="form-label">Foto / Gambar Wisata</label>
                    <input type="file" name="gambar" accept="image/*" class="form-input" onchange="previewImg(event)">
                    <p class="text-[11px] text-slate-500 mt-1.5">Format: JPG, PNG, WebP. Maks. 2 MB.</p>
                    @error('gambar') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Urutan Tampil</label>
                    <input type="number" name="urutan" value="{{ old('urutan', 0) }}" min="0" class="form-input">
                    <p class="text-[11px] text-slate-500 mt-1.5">Angka lebih kecil akan muncul terlebih dahulu.</p>
                    @error('urutan') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex items-center gap-3 pt-3">
                <input type="checkbox" name="is_active" id="is_active" class="w-4.5 h-4.5 border-slate-300 rounded text-forest-800 focus:ring-forest-800" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                <label for="is_active" class="text-sm font-semibold text-slate-700 cursor-pointer select-none">Aktifkan & Publikasikan wisata ini langsung ke website</label>
            </div>

            <div id="preview-container" class="mt-4 hidden">
                <p class="form-label">Pratinjau Gambar:</p>
                <img id="img-preview" src="" alt="Pratinjau Foto" class="w-full max-h-64 object-cover rounded-xl border border-slate-200 shadow-md">
            </div>

            <!-- Action Buttons Inside Card -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100 mt-6">
                <a href="{{ route('admin.wisata.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-500 hover:text-slate-800 border border-slate-200 hover:border-slate-600 transition-colors">
                    Batal
                </a>
                <button type="submit" class="btn-primary">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Simpan Destinasi Wisata
                </button>
            </div>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    function previewImg(event) {
        const preview = document.getElementById('img-preview');
        const container = document.getElementById('preview-container');
        
        if (event.target.files && event.target.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                container.classList.remove('hidden');
            }
            
            reader.readAsDataURL(event.target.files[0]);
        } else {
            container.classList.add('hidden');
        }
    }
</script>
@endpush
