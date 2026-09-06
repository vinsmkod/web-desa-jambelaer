@extends('admin.layouts.admin')

@section('title', 'Detail Pesan')
@section('page_title', 'Detail Pesan - ' . ucfirst(str_replace('_', ' ', $pesan->jenis_pesan)))
@section('page_subtitle', 'Dari: ' . $pesan->name)

@section('content')

<div class="max-w-2xl">
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">

        {{-- Header --}}
        <div class="flex items-start gap-4 px-6 py-5 border-b border-slate-100">
            <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-violet-600 to-violet-400 flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                {{ strtoupper(substr($pesan->name, 0, 1)) }}
            </div>
            <div class="flex-1">
                <h2 class="font-display font-bold text-slate-900 text-base">{{ $pesan->name }}</h2>
                @if($pesan->email && $pesan->email !== '-')
                <a href="mailto:{{ $pesan->email }}" class="text-sm text-forest-700 hover:text-forest-800 transition-colors font-medium block">{{ $pesan->email }}</a>
                @endif
                @if($pesan->no_whatsapp && $pesan->no_whatsapp !== '-')
                <p class="text-sm text-sky-600 font-medium block">{{ $pesan->no_whatsapp }}</p>
                @endif
                <p class="text-xs text-slate-500 mt-1">{{ $pesan->created_at->format('d M Y, H:i') }} WIB · {{ $pesan->created_at->diffForHumans() }}</p>
            </div>
            <span class="badge-{{ $pesan->jenis_pesan == 'pertanyaan_umum' ? 'blue' : ($pesan->jenis_pesan == 'pengaduan' ? 'red' : ($pesan->jenis_pesan == 'daftar_umkm' ? 'green' : 'sky')) }}">
                @switch($pesan->jenis_pesan)
                    @case('pertanyaan_umum')
                        Pertanyaan Umum
                        @break
                    @case('pengaduan')
                        Pengaduan
                        @break
                    @case('kerja_sama')
                        Kerja Sama
                        @break
                    @case('daftar_umkm')
                        Pendaftaran UMKM
                        @break
                @endswitch
            </span>
        </div>

        {{-- Jenis Pesan Info --}}
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 grid grid-cols-2 gap-4">
            <div>
                <p class="text-xs text-slate-500 uppercase tracking-wider font-bold mb-1">Jenis Pesan</p>
                <p class="text-sm font-semibold text-slate-700">
                    @switch($pesan->jenis_pesan)
                        @case('pertanyaan_umum')
                            Pertanyaan Umum
                            @break
                        @case('pengaduan')
                            Pengaduan
                            @break
                        @case('kerja_sama')
                            Kerja Sama
                            @break
                        @case('daftar_umkm')
                            Pendaftaran UMKM
                            @break
                    @endswitch
                </p>
            </div>
            <div>
                <p class="text-xs text-slate-500 uppercase tracking-wider font-bold mb-1">Status Dibaca</p>
                <p class="text-sm">
                    @if($pesan->is_read)
                        <span class="badge-read">Sudah Dibaca</span>
                    @else
                        <span class="badge-unread">Belum Dibaca</span>
                    @endif
                </p>
            </div>
        </div>

        {{-- Konten Dinamis berdasarkan Jenis Pesan --}}
        <div class="px-6 py-5">
            
            {{-- PERTANYAAN UMUM --}}
            @if($pesan->jenis_pesan === 'pertanyaan_umum')
                <div class="space-y-4">
                    <div class="pb-4 border-b border-slate-100">
                        <p class="text-xs text-slate-500 uppercase tracking-wider font-bold mb-2">Subjek Pertanyaan</p>
                        <p class="text-slate-800 font-semibold">{{ $pesan->subject }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wider font-bold mb-2">Isi Pertanyaan</p>
                        <div class="text-slate-700 text-sm leading-relaxed whitespace-pre-wrap bg-slate-50 rounded-xl p-4 border border-slate-200">{{ $pesan->message }}</div>
                    </div>
                </div>
            @endif

            {{-- PENGADUAN --}}
            @if($pesan->jenis_pesan === 'pengaduan')
                <div class="space-y-4">
                    <div class="pb-4 border-b border-slate-100">
                        <p class="text-xs text-slate-500 uppercase tracking-wider font-bold mb-2">Subjek Pengaduan</p>
                        <p class="text-slate-800 font-semibold">{{ $pesan->subject }}</p>
                    </div>
                    <div class="pb-4 border-b border-slate-100">
                        <p class="text-xs text-slate-500 uppercase tracking-wider font-bold mb-2">Isi Pengaduan</p>
                        <div class="text-slate-700 text-sm leading-relaxed whitespace-pre-wrap bg-slate-50 rounded-xl p-4 border border-slate-200">{{ $pesan->message }}</div>
                    </div>

                    {{-- Foto Bukti --}}
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wider font-bold mb-3 flex items-center gap-2">
                            <i data-lucide="image" class="w-3.5 h-3.5"></i>
                            Foto Bukti
                        </p>
                        @if($pesan->foto_bukti)
                            <div class="relative group inline-block cursor-pointer" onclick="openLightbox('{{ \Illuminate\Support\Facades\Storage::url($pesan->foto_bukti) }}')">
                                <img
                                    src="{{ \Illuminate\Support\Facades\Storage::url($pesan->foto_bukti) }}"
                                    alt="Foto bukti pengaduan dari {{ $pesan->name }}"
                                    class="w-full max-w-sm rounded-xl border border-slate-200 object-cover shadow-sm hover:shadow-md transition-shadow"
                                    style="max-height: 280px;"
                                >
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 rounded-xl transition-colors flex items-center justify-center pointer-events-none">
                                    <div class="opacity-0 group-hover:opacity-100 transition-opacity w-10 h-10 rounded-full bg-white/90 flex items-center justify-center shadow">
                                        <i data-lucide="zoom-in" class="w-5 h-5 text-slate-700"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 mt-3">
                                <a href="{{ \Illuminate\Support\Facades\Storage::url($pesan->foto_bukti) }}"
                                   download
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 text-xs text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-semibold transition-all">
                                    <i data-lucide="download" class="w-3.5 h-3.5"></i>
                                    Unduh Foto
                                </a>
                                <a href="{{ \Illuminate\Support\Facades\Storage::url($pesan->foto_bukti) }}"
                                   target="_blank"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 text-xs text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-semibold transition-all">
                                    <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                                    Buka di Tab Baru
                                </a>
                            </div>
                        @else
                            <div class="flex items-center gap-2 text-sm text-slate-400 bg-slate-50 rounded-xl px-4 py-3 border border-slate-100">
                                <i data-lucide="image-off" class="w-4 h-4"></i>
                                <span>Tidak ada foto bukti dilampirkan</span>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- KERJA SAMA --}}
            @if($pesan->jenis_pesan === 'kerja_sama')
                <div class="space-y-4">
                    <div class="pb-4 border-b border-slate-100">
                        <p class="text-xs text-slate-500 uppercase tracking-wider font-bold mb-2">Nama Instansi / Organisasi</p>
                        <p class="text-slate-800 font-semibold">{{ $pesan->nama_instansi }}</p>
                    </div>
                    <div class="pb-4 border-b border-slate-100">
                        <p class="text-xs text-slate-500 uppercase tracking-wider font-bold mb-2">Pesan Kemitraan</p>
                        <div class="text-slate-700 text-sm leading-relaxed whitespace-pre-wrap bg-slate-50 rounded-xl p-4 border border-slate-200">{{ $pesan->message }}</div>
                    </div>

                    {{-- Dokumen Lampiran Resmi (PDF) --}}
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wider font-bold mb-3 flex items-center gap-2">
                            <i data-lucide="file-text" class="w-3.5 h-3.5 text-rose-500"></i>
                            Dokumen Surat / Proposal Kemitraan (PDF)
                        </p>
                        @if($pesan->dokumen_lampiran)
                            <div class="flex items-center gap-3 p-4 bg-slate-50 border border-slate-200 rounded-xl">
                                <div class="w-10 h-10 rounded-lg bg-rose-100 flex items-center justify-center text-rose-600 flex-shrink-0 font-bold text-xs">
                                    PDF
                                </div>
                                <div class="flex-grow overflow-hidden">
                                    <p class="text-sm font-semibold text-slate-800 truncate">Proposal_Kemitraan_{{ Str::slug($pesan->nama_instansi ?? 'KerjaSama') }}.pdf</p>
                                    <p class="text-xs text-slate-400">Terlampir &bull; Siap untuk verifikasi administrasi digital</p>
                                </div>
                                <div class="flex items-center gap-2 flex-shrink-0">
                                    <a href="{{ \Illuminate\Support\Facades\Storage::url($pesan->dokumen_lampiran) }}"
                                       target="_blank"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-rose-600 text-white text-xs font-semibold hover:bg-rose-700 transition-all">
                                        <i data-lucide="file-text" class="w-3.5 h-3.5"></i>
                                        Buka PDF
                                    </a>
                                    <a href="{{ \Illuminate\Support\Facades\Storage::url($pesan->dokumen_lampiran) }}"
                                       download
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 text-xs text-slate-600 hover:bg-slate-100 font-semibold transition-all">
                                        <i data-lucide="download" class="w-3.5 h-3.5"></i>
                                        Unduh
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center gap-2 text-sm text-slate-400 bg-slate-50 rounded-xl px-4 py-3 border border-slate-100">
                                <i data-lucide="file-x" class="w-4 h-4"></i>
                                <span>Tidak ada proposal PDF dilampirkan</span>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- PENDAFTARAN UMKM --}}
            @if($pesan->jenis_pesan === 'daftar_umkm')
                <div class="space-y-6">
                    <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center gap-3 text-emerald-900">
                        <div class="w-10 h-10 rounded-lg bg-emerald-600 text-white flex items-center justify-center flex-shrink-0 font-bold">
                            <i data-lucide="store" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold">Permohonan Pendaftaran UMKM Baru</p>
                            <p class="text-xs text-emerald-700/80 font-light mt-0.5">Pemilik usaha mengajukan untuk tampil di katalog UMKM Desa Jambelaer.</p>
                        </div>
                    </div>

                    {{-- 1. Informasi Pengelola UMKM Card --}}
                    <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm space-y-4">
                        <h4 class="font-display font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                            <i data-lucide="store" class="w-4 h-4 text-emerald-600"></i>
                            Informasi Pengelola UMKM
                        </h4>
                        <div class="grid sm:grid-cols-2 gap-4 text-xs">
                            <div>
                                <span class="text-slate-400 font-medium block uppercase tracking-wider text-[10px]">Nama Pemilik</span>
                                <span class="text-slate-800 font-bold block mt-0.5 text-sm">{{ $pesan->name ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 font-medium block uppercase tracking-wider text-[10px]">Nama Usaha</span>
                                <span class="text-slate-800 font-bold block mt-0.5 text-sm">{{ $pesan->nama_umkm ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 font-medium block uppercase tracking-wider text-[10px]">Kategori</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200 mt-1">
                                    {{ ucfirst($pesan->jenis_produk_umkm ?? 'Umum') }}
                                </span>
                            </div>
                            <div>
                                <span class="text-slate-400 font-medium block uppercase tracking-wider text-[10px]">Jam Operasional</span>
                                <span class="text-slate-800 font-bold block mt-0.5">{{ $pesan->jam_operasional_umkm ?? '-' }}</span>
                            </div>
                            @if($pesan->instagram_umkm)
                            <div>
                                <span class="text-slate-400 font-medium block uppercase tracking-wider text-[10px]">Instagram</span>
                                <a href="https://instagram.com/{{ ltrim($pesan->instagram_umkm, '@') }}" target="_blank" class="text-pink-600 font-bold hover:underline block mt-0.5">
                                    {{ $pesan->instagram_umkm }}
                                </a>
                            </div>
                            @endif
                            <div>
                                <span class="text-slate-400 font-medium block uppercase tracking-wider text-[10px]">Nomor WhatsApp</span>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pesan->no_whatsapp) }}" target="_blank" class="text-emerald-700 font-bold hover:underline block mt-0.5">
                                    {{ $pesan->no_whatsapp ?? '-' }}
                                </a>
                            </div>
                            <div class="sm:col-span-2 pt-2 border-t border-slate-100">
                                <span class="text-slate-400 font-medium block uppercase tracking-wider text-[10px]">Alamat Usaha</span>
                                <span class="text-slate-800 font-medium block mt-0.5 leading-relaxed">{{ $pesan->alamat_umkm_daftar ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- 2. Tentang Produk Card --}}
                    <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm space-y-3">
                        <h4 class="font-display font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                            <i data-lucide="info" class="w-4 h-4 text-emerald-600"></i>
                            Tentang Produk
                        </h4>
                        <div class="text-slate-700 text-sm leading-relaxed whitespace-pre-wrap bg-slate-50 rounded-xl p-4 border border-slate-200">
                            {{ $pesan->deskripsi_umkm ?? $pesan->message }}
                        </div>
                    </div>

                    {{-- 3. Spesifikasi Produk Card --}}
                    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
                        <div class="px-5 py-3.5 border-b border-slate-100 bg-slate-50/70">
                            <h4 class="font-display font-bold text-slate-800 text-sm flex items-center gap-2">
                                <i data-lucide="list-checks" class="w-4 h-4 text-emerald-600"></i>
                                Spesifikasi Produk
                            </h4>
                        </div>
                        <table class="w-full text-xs sm:text-sm">
                            <tbody class="divide-y divide-slate-100">
                                <tr>
                                    <td class="px-5 py-3 text-slate-500 font-medium w-1/3">Harga</td>
                                    <td class="px-5 py-3 text-slate-800 font-bold">{{ $pesan->harga_produk_umkm ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="px-5 py-3 text-slate-500 font-medium">Isi</td>
                                    <td class="px-5 py-3 text-slate-800 font-bold">{{ $pesan->isi_produk_umkm ?? $pesan->berat_bersih_umkm ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="px-5 py-3 text-slate-500 font-medium">Ketersediaan</td>
                                    <td class="px-5 py-3 font-bold text-emerald-700">{{ $pesan->ketersediaan_umkm ?? 'Tersedia' }}</td>
                                </tr>
                                <tr>
                                    <td class="px-5 py-3 text-slate-500 font-medium">Sertifikasi</td>
                                    <td class="px-5 py-3 text-slate-800 font-bold">{{ $pesan->sertifikasi_umkm ?? '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Foto Produk --}}
                    <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm space-y-3">
                        <h4 class="font-display font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                            <i data-lucide="image" class="w-4 h-4 text-emerald-600"></i>
                            Foto Produk Usaha
                        </h4>
                        @if($pesan->foto_produk)
                            <div class="relative group inline-block cursor-pointer" onclick="openLightbox('{{ \Illuminate\Support\Facades\Storage::url($pesan->foto_produk) }}')">
                                <img
                                    src="{{ \Illuminate\Support\Facades\Storage::url($pesan->foto_produk) }}"
                                    alt="Foto produk {{ $pesan->nama_umkm }}"
                                    class="w-full max-w-sm rounded-xl border border-slate-200 object-cover shadow-sm hover:shadow-md transition-shadow"
                                    style="max-height: 280px;"
                                >
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 rounded-xl transition-colors flex items-center justify-center pointer-events-none">
                                    <div class="opacity-0 group-hover:opacity-100 transition-opacity w-10 h-10 rounded-full bg-white/90 flex items-center justify-center shadow">
                                        <i data-lucide="zoom-in" class="w-5 h-5 text-slate-700"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 mt-3">
                                <a href="{{ \Illuminate\Support\Facades\Storage::url($pesan->foto_produk) }}"
                                   download
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 text-xs text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-semibold transition-all">
                                    <i data-lucide="download" class="w-3.5 h-3.5"></i>
                                    Unduh Foto Produk
                                </a>
                                <a href="{{ \Illuminate\Support\Facades\Storage::url($pesan->foto_produk) }}"
                                   target="_blank"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 text-xs text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-semibold transition-all">
                                    <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                                    Buka di Tab Baru
                                </a>
                            </div>
                        @else
                            <div class="flex items-center gap-2 text-sm text-slate-400 bg-slate-50 rounded-xl px-4 py-3 border border-slate-100">
                                <i data-lucide="image-off" class="w-4 h-4"></i>
                                <span>Tidak ada foto produk dilampirkan</span>
                            </div>
                        @endif
                    </div>

                    {{-- Tombol Tambah ke Katalog UMKM Desa --}}
                    @php
                        $createUrl = route('admin.produk.create') . '?' . http_build_query([
                            'pesan_id' => $pesan->pesan_id,
                            'title' => $pesan->nama_umkm,
                            'producer' => $pesan->nama_umkm,
                            'nama_pemilik' => $pesan->name,
                            'no_whatsapp_umkm' => $pesan->no_whatsapp,
                            'badge' => $pesan->jenis_produk_umkm,
                            'jam_operasional' => $pesan->jam_operasional_umkm,
                            'instagram_umkm' => $pesan->instagram_umkm,
                            'alamat_umkm' => $pesan->alamat_umkm_daftar,
                            'desc_short' => Str::limit($pesan->deskripsi_umkm ?? $pesan->message, 120),
                            'desc_long' => $pesan->deskripsi_umkm ?? $pesan->message,
                            'price' => $pesan->harga_produk_umkm,
                            'isi' => $pesan->isi_produk_umkm ?? $pesan->berat_bersih_umkm,
                            'ketersediaan' => $pesan->ketersediaan_umkm ?? 'Tersedia',
                            'sertifikasi' => $pesan->sertifikasi_umkm,
                        ]);
                    @endphp
                    <div class="pt-2 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 p-4 bg-slate-50 rounded-xl border border-slate-200">
                        <div>
                            <p class="text-xs font-bold text-slate-700">Publikasikan ke Katalog UMKM?</p>
                            <p class="text-xs text-slate-500 font-light">Tambahkan produk ini ke daftar UMKM resmi desa di menu Kelola Produk.</p>
                        </div>
                        <a href="{{ $createUrl }}"
                           class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition-all shadow-sm flex-shrink-0">
                            <i data-lucide="plus-circle" class="w-4 h-4"></i>
                            Tambah ke Produk UMKM
                        </a>
                    </div>
                </div>
            @endif
        </div>

        {{-- Actions --}}
        @php
            $hasEmail = !empty($pesan->email) && $pesan->email !== '-' && filter_var($pesan->email, FILTER_VALIDATE_EMAIL);
            $hasWa    = !empty($pesan->no_whatsapp) && $pesan->no_whatsapp !== '-';
            $waMsg = match($pesan->jenis_pesan) {
                'pengaduan'  => \App\Helpers\WhatsAppHelper::msgPengaduanKePemohon($pesan),
                'kerja_sama' => \App\Helpers\WhatsAppHelper::msgKerjaSamaKePemohon($pesan),
                default      => "Halo Bapak/Ibu {$pesan->name},\n\nKami dari Pemerintah Desa Jambelaer menindaklanjuti pesan Anda mengenai: {$pesan->subject}.\n\nTerima kasih.",
            };
            $waUrl = \App\Helpers\WhatsAppHelper::url($pesan->no_whatsapp ?? '', $waMsg);
        @endphp
        <div class="px-6 py-4 border-t border-slate-200 flex items-center gap-3">
            <a href="{{ route('admin.pesan.index') }}"
               class="flex items-center gap-2 px-4 py-2 rounded-xl border border-slate-200 text-slate-600 hover:text-slate-900 text-sm font-semibold transition-all">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Kembali
            </a>

            @if($hasEmail)
            <a href="mailto:{{ $pesan->email }}?subject=Re: {{ urlencode($pesan->subject) }}"
               class="btn-primary">
                <i data-lucide="reply" class="w-4 h-4"></i>
                Balas via Email
            </a>
            @if($hasWa)
            <a href="{{ $waUrl }}" target="_blank" class="btn-secondary">
                <i data-lucide="message-circle" class="w-4 h-4"></i>
                WhatsApp
            </a>
            @endif
            @elseif($hasWa)
            <a href="{{ $waUrl }}" target="_blank" class="btn-primary">
                <i data-lucide="message-circle" class="w-4 h-4"></i>
                Balas via WhatsApp
            </a>
            @endif

            <form method="POST" action="{{ route('admin.pesan.destroy', $pesan) }}"
                  onsubmit="return confirm('Hapus pesan ini?')" class="ml-auto">
                @csrf @method('DELETE')
                <button type="submit" class="btn-danger">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                    Hapus
                </button>
            </form>
        </div>

    </div>
</div>

<style>
.badge-blue { @apply inline-flex items-center px-2.5 py-1 rounded-lg bg-sky-600/20 text-sky-600 font-semibold text-xs; }
.badge-red { @apply inline-flex items-center px-2.5 py-1 rounded-lg bg-red-600/20 text-red-400 font-semibold text-xs; }
.badge-sky { @apply inline-flex items-center px-2.5 py-1 rounded-lg bg-cyan-600/20 text-cyan-400 font-semibold text-xs; }
.badge-green { @apply inline-flex items-center px-2.5 py-1 rounded-lg bg-emerald-600/20 text-emerald-600 font-semibold text-xs; }
</style>

{{-- Lightbox Overlay --}}
@if(($pesan->jenis_pesan === 'pengaduan' && $pesan->foto_bukti) || ($pesan->jenis_pesan === 'daftar_umkm' && $pesan->foto_produk))
<div id="lightbox" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/85 backdrop-blur-sm p-4" onclick="closeLightbox()">
    <div class="relative max-w-4xl max-h-full" onclick="event.stopPropagation()">
        <img id="lightbox-img" src="" alt="Foto bukti pengaduan" class="max-w-full max-h-[88vh] rounded-2xl shadow-2xl object-contain">
        <button onclick="closeLightbox()" class="absolute -top-4 -right-4 w-9 h-9 rounded-full bg-white flex items-center justify-center shadow-lg hover:bg-slate-100 transition-colors">
            <i data-lucide="x" class="w-4 h-4 text-slate-700"></i>
        </button>
    </div>
</div>
@endif

@endsection

@push('scripts')
<script>
function openLightbox(src) {
    const lb = document.getElementById('lightbox');
    if (!lb) return;
    document.getElementById('lightbox-img').src = src;
    lb.classList.remove('hidden');
    lb.classList.add('flex');
    document.body.style.overflow = 'hidden';
    lucide.createIcons();
}
function closeLightbox() {
    const lb = document.getElementById('lightbox');
    if (!lb) return;
    lb.classList.add('hidden');
    lb.classList.remove('flex');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeLightbox();
});
</script>
@endpush


