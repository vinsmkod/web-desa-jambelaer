@extends('admin.layouts.admin')

@section('title', 'Tambah Acara Desa Baru')
@section('page_title', 'Tambah Acara Baru')
@section('page_subtitle', 'Publikasikan agenda, kegiatan, atau upacara desa langsung ke portal website desa')

@section('content')

<div class="max-w-4xl">
    <div class="mb-4">
        <a href="{{ route('admin.acara.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-forest-800 transition-colors">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            Kembali ke Daftar Acara
        </a>
    </div>

    @if ($errors->any())
    <div class="mb-5 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs">
        <div class="flex items-center gap-2 font-bold mb-1">
            <i data-lucide="alert-circle" class="w-4 h-4"></i>
            Terdapat beberapa kesalahan pengisian:
        </div>
        <ul class="list-disc list-inside space-y-0.5 pl-2 text-rose-600">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.acara.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- ── 1. Informasi Utama Acara ── --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs">
            <h3 class="font-display font-bold text-slate-900 text-sm mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                <i data-lucide="calendar" class="w-4 h-4 text-forest-700"></i>
                Informasi Utama Acara
            </h3>

            <div class="space-y-4">
                {{-- Nama Acara --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Nama / Judul Acara <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="nama_acara" value="{{ old('nama_acara') }}" required
                           placeholder="Contoh: Upacara Adat Ruwatan Bumi Desa Jambelaer"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-forest-500/20 focus:border-forest-600 transition-all font-medium">
                    <p class="text-[11px] text-slate-400 mt-1">Nama lengkap agenda kegiatan yang akan ditampilkan ke masyarakat.</p>
                </div>

                {{-- Tanggal & Waktu --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Tanggal Acara <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" name="tanggal_acara" value="{{ old('tanggal_acara', date('Y-m-d')) }}" required
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-forest-500/20 focus:border-forest-600 transition-all">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Waktu Pelaksanaan (WIB)
                        </label>
                        <input type="time" name="waktu_acara" value="{{ old('waktu_acara', '08:00') }}"
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-forest-500/20 focus:border-forest-600 transition-all">
                    </div>
                </div>

                {{-- Lokasi Acara --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Lokasi / Tempat Pelaksanaan <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="lokasi_acara" value="{{ old('lokasi_acara', 'Kantor Pemerintah Desa Jambelaer') }}" required
                           placeholder="Contoh: Lapangan Kantor Desa Jambelaer / Balai Musyawarah"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-forest-500/20 focus:border-forest-600 transition-all">
                </div>

                {{-- Deskripsi Acara --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Deskripsi & Rangkaian Kegiatan <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="deskripsi_acara" rows="5" required
                              placeholder="Tuliskan gambaran acara, tujuan kegiatan, susunan acara penting, serta himbauan untuk para peserta atau masyarakat..."
                              class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-forest-500/20 focus:border-forest-600 transition-all leading-relaxed">{{ old('deskripsi_acara') }}</textarea>
                </div>
            </div>
        </div>

        {{-- ── 2. Penyelenggara & Kontak ── --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs">
            <h3 class="font-display font-bold text-slate-900 text-sm mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                <i data-lucide="users" class="w-4 h-4 text-forest-700"></i>
                Penyelenggara & Narahubung (Kontak)
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Nama Penyelenggara / Penanggung Jawab <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', 'Pemerintah Desa Jambelaer') }}" required
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-forest-500/20 focus:border-forest-600 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Instansi / Lembaga / Panitia
                    </label>
                    <input type="text" name="nama_instansi" value="{{ old('nama_instansi', 'Pemerintah Desa Jambelaer') }}"
                           placeholder="Contoh: Pemerintah Desa / Karang Taruna / BPD"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-forest-500/20 focus:border-forest-600 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Nomor WhatsApp Narahubung
                    </label>
                    <input type="text" name="no_whatsapp" value="{{ old('no_whatsapp', \App\Models\Pengaturan::get('desa_telepon', '081324768193')) }}"
                           placeholder="081234567890"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-forest-500/20 focus:border-forest-600 transition-all font-mono">
                    <p class="text-[11px] text-slate-400 mt-1">Digunakan untuk tombol "Hubungi Panitia via WhatsApp" di website.</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Estimasi Jumlah Peserta (Orang)
                    </label>
                    <input type="number" name="jumlah_peserta" value="{{ old('jumlah_peserta') }}" min="0"
                           placeholder="Contoh: 150"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-forest-500/20 focus:border-forest-600 transition-all">
                </div>
            </div>
        </div>

        {{-- ── 3. Media & Berkas Acara ── --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs">
            <h3 class="font-display font-bold text-slate-900 text-sm mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                <i data-lucide="image" class="w-4 h-4 text-forest-700"></i>
                Foto / Banner Poster & Berkas PDF
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Foto Banner Acara -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Foto Poster / Banner Acara
                    </label>
                    <div class="border-2 border-dashed border-slate-200 hover:border-forest-400 rounded-2xl p-4 text-center transition-all bg-slate-50/50">
                        <input type="file" name="foto_bukti" id="foto_bukti_input" accept="image/jpeg,image/png,image/jpg,image/webp"
                               class="hidden" onchange="previewAcaraImage(this)">
                        <label for="foto_bukti_input" class="cursor-pointer block">
                            <div id="image_preview_box" class="hidden mb-3">
                                <img id="image_preview" src="" alt="Preview Poster" class="w-full h-40 object-cover rounded-xl mx-auto shadow-xs border border-slate-200">
                            </div>
                            <div id="image_placeholder" class="py-4">
                                <div class="w-10 h-10 rounded-xl bg-forest-50 text-forest-700 flex items-center justify-center mx-auto mb-2 border border-forest-100">
                                    <i data-lucide="upload" class="w-5 h-5"></i>
                                </div>
                                <span class="text-xs font-bold text-slate-700 block">Unggah Banner Acara</span>
                                <span class="text-[11px] text-slate-400 block mt-0.5">JPG, PNG, atau WEBP (Maks 4MB)</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Dokumen PDF Proposal -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Dokumen Surat / Proposal Acara (PDF)
                    </label>
                    <div class="border-2 border-dashed border-slate-200 hover:border-forest-400 rounded-2xl p-4 text-center transition-all bg-slate-50/50">
                        <input type="file" name="dokumen_lampiran" id="pdf_input" accept="application/pdf"
                               class="hidden" onchange="previewPdfFilename(this)">
                        <label for="pdf_input" class="cursor-pointer block py-4">
                            <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center mx-auto mb-2 border border-rose-100">
                                <i data-lucide="file-text" class="w-5 h-5"></i>
                            </div>
                            <span id="pdf_label" class="text-xs font-bold text-slate-700 block">Pilih Dokumen PDF</span>
                            <span class="text-[11px] text-slate-400 block mt-0.5">Format .PDF (Maks 10MB)</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── 4. Pengaturan Status & Publikasi ── --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs">
            <h3 class="font-display font-bold text-slate-900 text-sm mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                <i data-lucide="globe" class="w-4 h-4 text-forest-700"></i>
                Status & Publikasi ke Website
            </h3>

            <div class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Status Verifikasi Acara
                        </label>
                        <select name="status" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-forest-500/20 focus:border-forest-600 transition-all font-semibold">
                            <option value="disetujui" selected>Disetujui (Siap Tayang)</option>
                            <option value="menunggu">Menunggu Review (Draf)</option>
                            <option value="ditolak">Ditolak / Batal</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Catatan Internal Admin (Opsional)
                        </label>
                        <input type="text" name="catatan_admin" value="{{ old('catatan_admin') }}"
                               placeholder="Catatan khusus panitia / kesiapan lokasi..."
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-forest-500/20 focus:border-forest-600 transition-all">
                    </div>
                </div>

                {{-- Checkbox Langsung Publikasi --}}
                <div class="p-4 rounded-xl bg-forest-50/60 border border-forest-100 flex items-start gap-3">
                    <input type="checkbox" name="dipublikasikan" id="dipublikasikan" value="1" checked
                           class="w-4 h-4 text-forest-700 rounded border-slate-300 focus:ring-forest-500 mt-0.5">
                    <label for="dipublikasikan" class="text-xs text-slate-700 cursor-pointer">
                        <span class="font-bold text-forest-900 block">Publikasikan langsung ke halaman Agenda Acara Desa</span>
                        <span class="text-slate-500 block mt-0.5">Jika dicentang, acara ini akan langsung tampil di halaman publik <a href="{{ route('acara') }}" target="_blank" class="text-forest-700 underline font-semibold">/acara</a> agar dapat dilihat oleh seluruh warga.</span>
                    </label>
                </div>
            </div>
        </div>

        {{-- ── Submit Actions ── --}}
        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('admin.acara.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-xs font-semibold hover:bg-slate-50 transition-all">
                Batal
            </a>
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-forest-800 hover:bg-forest-700 text-white text-xs font-semibold shadow-xs transition-all">
                <i data-lucide="check" class="w-4 h-4"></i>
                Simpan & Terbitkan Acara
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function previewAcaraImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image_preview').src = e.target.result;
                document.getElementById('image_preview_box').classList.remove('hidden');
                document.getElementById('image_placeholder').classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewPdfFilename(input) {
        if (input.files && input.files[0]) {
            document.getElementById('pdf_label').textContent = input.files[0].name;
        }
    }
</script>
@endpush

@endsection
