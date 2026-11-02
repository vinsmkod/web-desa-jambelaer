@extends('admin.layouts.admin')

@section('title', 'Edit Acara: ' . $pesan->nama_acara)
@section('page_title', 'Edit Agenda Acara')
@section('page_subtitle', 'Perbarui rincian informasi, jadwal, dan status publikasi acara')

@section('content')

<div class="max-w-4xl">
    <div class="mb-4 flex items-center justify-between">
        <a href="{{ route('admin.acara.show', $pesan) }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-forest-800 transition-colors">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            Kembali ke Detail Acara
        </a>

        <form method="POST" action="{{ route('admin.acara.destroy', $pesan) }}"
              onsubmit="return confirm('Hapus acara ini secara permanen?')">
            @csrf @method('DELETE')
            <button type="submit" class="inline-flex items-center gap-1.5 text-xs font-semibold text-rose-600 hover:text-rose-700 transition-colors">
                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                Hapus Acara
            </button>
        </form>
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

    <form method="POST" action="{{ route('admin.acara.update', $pesan) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- ── 1. Informasi Utama Acara ── --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs">
            <h3 class="font-display font-bold text-slate-900 text-sm mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                <i data-lucide="calendar" class="w-4 h-4 text-forest-700"></i>
                Informasi Utama Acara
            </h3>

            <div class="space-y-4">
                {{-- Nama Acara --}}
                <div>
                    <label class="form-label">
                        Nama / Judul Acara <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="nama_acara" value="{{ old('nama_acara', $pesan->nama_acara) }}" required
                           class="form-input font-medium">
                </div>

                {{-- Tanggal & Waktu --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">
                            Tanggal Acara <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" name="tanggal_acara"
                               value="{{ old('tanggal_acara', $pesan->tanggal_acara ? $pesan->tanggal_acara->format('Y-m-d') : '') }}" required
                               class="form-input">
                    </div>

                    <div>
                        <label class="form-label">
                            Waktu Pelaksanaan (WIB)
                        </label>
                        <input type="time" name="waktu_acara"
                               value="{{ old('waktu_acara', $pesan->waktu_acara ? date('H:i', strtotime($pesan->waktu_acara)) : '') }}"
                               class="form-input">
                    </div>
                </div>

                {{-- Lokasi Acara --}}
                <div>
                    <label class="form-label">
                        Lokasi / Tempat Pelaksanaan <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="lokasi_acara" value="{{ old('lokasi_acara', $pesan->lokasi_acara) }}" required
                           class="form-input">
                </div>

                {{-- Deskripsi Acara --}}
                <div>
                    <label class="form-label">
                        Deskripsi & Rangkaian Kegiatan <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="deskripsi_acara" rows="5" required
                              class="form-input leading-relaxed">{{ old('deskripsi_acara', $pesan->deskripsi_acara) }}</textarea>
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
                    <label class="form-label">
                        Nama Penyelenggara / Penanggung Jawab <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', $pesan->name) }}" required
                           class="form-input">
                </div>

                <div>
                    <label class="form-label">
                        Instansi / Lembaga / Panitia
                    </label>
                    <input type="text" name="nama_instansi" value="{{ old('nama_instansi', $pesan->nama_instansi) }}"
                           placeholder="Contoh: Pemerintah Desa / Karang Taruna / BPD"
                           class="form-input">
                </div>

                <div>
                    <label class="form-label">
                        Nomor WhatsApp Narahubung
                    </label>
                    <input type="text" name="no_whatsapp" value="{{ old('no_whatsapp', $pesan->no_whatsapp) }}"
                           placeholder="081234567890"
                           class="form-input font-mono">
                </div>

                <div>
                    <label class="form-label">
                        Estimasi Jumlah Peserta (Orang)
                    </label>
                    <input type="number" name="jumlah_peserta" value="{{ old('jumlah_peserta', $pesan->jumlah_peserta) }}" min="0"
                           placeholder="Contoh: 150"
                           class="form-input">
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
                    <label class="form-label">
                        Foto Poster / Banner Acara
                    </label>
                    @php
                        $currentPhoto = null;
                        if ($pesan->foto_bukti) {
                            $currentPhoto = (str_starts_with($pesan->foto_bukti, 'http') || str_starts_with($pesan->foto_bukti, '/'))
                                ? asset($pesan->foto_bukti)
                                : \Illuminate\Support\Facades\Storage::url($pesan->foto_bukti);
                        }
                    @endphp

                    <div class="border-2 border-dashed border-slate-200 hover:border-forest-400 rounded-2xl p-4 text-center transition-all bg-slate-50/50">
                        <input type="file" name="foto_bukti" id="foto_bukti_input" accept="image/jpeg,image/png,image/jpg,image/webp"
                               class="hidden" onchange="previewAcaraImage(this)">
                        <label for="foto_bukti_input" class="cursor-pointer block">
                            <div id="image_preview_box" class="{{ $currentPhoto ? '' : 'hidden' }} mb-3">
                                <img id="image_preview" src="{{ $currentPhoto ?? '' }}" alt="Preview Poster" class="w-full h-40 object-cover rounded-xl mx-auto shadow-xs border border-slate-200">
                                <span class="text-[11px] text-forest-700 font-bold block mt-2">Klik untuk mengganti gambar</span>
                            </div>
                            <div id="image_placeholder" class="{{ $currentPhoto ? 'hidden' : '' }} py-4">
                                <div class="w-10 h-10 rounded-xl bg-forest-50 text-forest-700 flex items-center justify-center mx-auto mb-2 border border-forest-100">
                                    <i data-lucide="upload" class="w-5 h-5"></i>
                                </div>
                                <span class="text-xs font-bold text-slate-700 block">Unggah Banner Baru</span>
                                <span class="text-[11px] text-slate-400 block mt-0.5">JPG, PNG, atau WEBP (Maks 4MB)</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Dokumen PDF Proposal -->
                <div>
                    <label class="form-label">
                        Dokumen Surat / Proposal Acara (PDF)
                    </label>
                    <div class="border-2 border-dashed border-slate-200 hover:border-forest-400 rounded-2xl p-4 text-center transition-all bg-slate-50/50">
                        <input type="file" name="dokumen_lampiran" id="pdf_input" accept="application/pdf"
                               class="hidden" onchange="previewPdfFilename(this)">
                        <label for="pdf_input" class="cursor-pointer block py-4">
                            <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center mx-auto mb-2 border border-rose-100">
                                <i data-lucide="file-text" class="w-5 h-5"></i>
                            </div>
                            <span id="pdf_label" class="text-xs font-bold text-slate-700 block">
                                {{ $pesan->dokumen_lampiran ? 'Proposal Terlampir (Klik ganti PDF)' : 'Pilih Dokumen PDF' }}
                            </span>
                            <span class="text-[11px] text-slate-400 block mt-0.5">Format .PDF (Maks 10MB)</span>
                        </label>
                    </div>

                    @if($pesan->dokumen_lampiran)
                        <div class="mt-2 text-center">
                            <a href="{{ \Illuminate\Support\Facades\Storage::url($pesan->dokumen_lampiran) }}" target="_blank"
                               class="inline-flex items-center gap-1 text-xs text-rose-600 hover:underline font-semibold">
                                <i data-lucide="external-link" class="w-3.5 h-3.5"></i> Buka file PDF saat ini
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ── 4. Status & Publikasi ── --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs">
            <h3 class="font-display font-bold text-slate-900 text-sm mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                <i data-lucide="globe" class="w-4 h-4 text-forest-700"></i>
                Status & Publikasi ke Website
            </h3>

            <div class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">
                            Status Verifikasi Acara <span class="text-rose-500">*</span>
                        </label>
                        <select name="status" class="form-input font-semibold">
                            <option value="disetujui" {{ old('status', $pesan->status) === 'disetujui' ? 'selected' : '' }}>Disetujui (Dapat Dipublikasikan)</option>
                            <option value="menunggu" {{ old('status', $pesan->status) === 'menunggu' ? 'selected' : '' }}>Menunggu Review</option>
                            <option value="ditolak" {{ old('status', $pesan->status) === 'ditolak' ? 'selected' : '' }}>Ditolak / Batal</option>
                        </select>
                    </div>

                    <div>
                        <label class="form-label">
                            Catatan Internal Admin (Opsional)
                        </label>
                        <input type="text" name="catatan_admin" value="{{ old('catatan_admin', $pesan->catatan_admin) }}"
                               placeholder="Catatan khusus panitia / kesiapan lokasi..."
                               class="form-input">
                    </div>
                </div>

                {{-- Checkbox Publikasi --}}
                <div class="p-4 rounded-xl bg-forest-50/60 border border-forest-100 flex items-start gap-3">
                    <input type="checkbox" name="dipublikasikan" id="dipublikasikan" value="1"
                           {{ old('dipublikasikan', $pesan->dipublikasikan) ? 'checked' : '' }}
                           class="w-4 h-4 text-forest-700 rounded border-slate-300 focus:ring-forest-500 mt-0.5">
                    <label for="dipublikasikan" class="text-xs text-slate-700 cursor-pointer">
                        <span class="font-bold text-forest-900 block">Publikasikan ke halaman Agenda Acara Desa (/acara)</span>
                        <span class="text-slate-500 block mt-0.5">Pastikan status berstatus "Disetujui" agar acara dapat tampil dan diakses oleh masyarakat umum.</span>
                    </label>
                </div>
            </div>
        </div>

        {{-- ── Submit Actions ── --}}
        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('admin.acara.show', $pesan) }}" class="btn-secondary text-xs">
                Batal
            </a>
            <button type="submit" class="btn-primary !px-6 text-xs">
                <i data-lucide="check" class="w-4 h-4"></i>
                Simpan Perubahan
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
