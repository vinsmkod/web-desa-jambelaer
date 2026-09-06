@extends('admin.layouts.admin')

@section('title', 'Detail Acara: ' . $pesan->nama_acara)
@section('page_title', 'Detail Agenda Acara')
@section('page_subtitle', $pesan->nama_acara)

@section('content')

<div class="max-w-5xl">
    {{-- Top Navigation & Action Buttons --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
        <a href="{{ route('admin.acara.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-forest-800 transition-colors">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            Kembali ke Daftar Acara
        </a>

        <div class="flex items-center gap-2">
            @if($pesan->status === 'disetujui')
                <form method="POST" action="{{ route('admin.acara.publikasi', $pesan) }}">
                    @csrf
                    <button type="submit"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold shadow-xs transition-all {{ $pesan->dipublikasikan ? 'bg-amber-50 text-amber-700 border border-amber-200 hover:bg-amber-100' : 'bg-emerald-600 text-white hover:bg-emerald-700' }}">
                        <i data-lucide="{{ $pesan->dipublikasikan ? 'eye-off' : 'globe' }}" class="w-3.5 h-3.5"></i>
                        {{ $pesan->dipublikasikan ? 'Tarik dari Website' : 'Tayangkan di Website' }}
                    </button>
                </form>
            @endif

            <a href="{{ route('admin.acara.edit', $pesan) }}"
               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 text-xs font-semibold shadow-xs transition-all">
                <i data-lucide="pencil" class="w-3.5 h-3.5 text-amber-500"></i>
                Edit Acara
            </a>

            <form method="POST" action="{{ route('admin.acara.destroy', $pesan) }}"
                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus acara ini secara permanen?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl border border-rose-200 bg-rose-50 text-rose-600 hover:bg-rose-100 text-xs font-semibold shadow-xs transition-all">
                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    {{-- Status Hero Card --}}
    @php
        $isDesa = ($pesan->user_id !== null || str_contains(strtolower($pesan->name), 'desa') || str_contains(strtolower($pesan->nama_instansi ?? ''), 'desa'));
        $photoUrl = null;
        if ($pesan->foto_bukti) {
            $photoUrl = (str_starts_with($pesan->foto_bukti, 'http') || str_starts_with($pesan->foto_bukti, '/'))
                ? asset($pesan->foto_bukti)
                : \Illuminate\Support\Facades\Storage::url($pesan->foto_bukti);
        }
    @endphp

    <div class="bg-white border border-slate-200 rounded-2xl p-5 mb-6 shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    @if($isDesa)
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            <i data-lucide="shield-check" class="w-3.5 h-3.5"></i> Acara Resmi Pemerintah Desa
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-sky-50 text-sky-700 border border-sky-200">
                            <i data-lucide="users" class="w-3.5 h-3.5"></i> Pengajuan Acara Warga / Komunitas
                        </span>
                    @endif

                    @if($pesan->is_archived)
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-500">
                            <i data-lucide="archive" class="w-3.5 h-3.5"></i> Diarsipkan (Selesai)
                        </span>
                    @endif
                </div>

                <h1 class="font-display font-extrabold text-xl text-slate-900 mt-1">
                    {{ $pesan->nama_acara }}
                </h1>
            </div>

            <div class="flex items-center gap-2 flex-shrink-0">
                @if($pesan->status === 'disetujui')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <i data-lucide="check-circle-2" class="w-4 h-4"></i> Disetujui
                    </span>
                @elseif($pesan->status === 'menunggu')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                        <i data-lucide="clock" class="w-4 h-4"></i> Menunggu Review
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">
                        <i data-lucide="x-circle" class="w-4 h-4"></i> Ditolak
                    </span>
                @endif

                @if($pesan->dipublikasikan)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-bold bg-forest-800 text-white shadow-xs">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        Tayang Publik
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-bold bg-slate-100 text-slate-500 border border-slate-200">
                        Draf / Privat
                    </span>
                @endif
            </div>
        </div>
    </div>

    {{-- Main Grid Content --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left Column (2 Cols) --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Poster Banner if available --}}
            @if($photoUrl)
            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
                <img src="{{ $photoUrl }}" alt="{{ $pesan->nama_acara }}"
                     class="w-full h-64 sm:h-80 object-cover">
            </div>
            @endif

            {{-- Rincian Jadwal & Lokasi --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs">
                <h3 class="font-display font-bold text-slate-900 text-sm mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                    <i data-lucide="clock" class="w-4 h-4 text-forest-700"></i>
                    Jadwal & Tempat Kegiatan
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Tanggal Acara</p>
                        <p class="font-bold text-slate-800 flex items-center gap-1.5">
                            <i data-lucide="calendar" class="w-4 h-4 text-forest-700"></i>
                            {{ $pesan->tanggal_acara ? $pesan->tanggal_acara->translatedFormat('l, d F Y') : '-' }}
                        </p>
                    </div>

                    <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Waktu Pelaksanaan</p>
                        <p class="font-bold text-slate-800 flex items-center gap-1.5">
                            <i data-lucide="clock" class="w-4 h-4 text-forest-700"></i>
                            {{ $pesan->waktu_acara ? date('H:i', strtotime($pesan->waktu_acara)) . ' WIB' : 'Waktu Fleksibel' }}
                        </p>
                    </div>

                    <div class="sm:col-span-2 p-3.5 bg-slate-50 rounded-xl border border-slate-100">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Lokasi Kegiatan</p>
                        <p class="font-bold text-slate-800 flex items-center gap-1.5">
                            <i data-lucide="map-pin" class="w-4 h-4 text-forest-700"></i>
                            {{ $pesan->lokasi_acara }}
                        </p>
                    </div>

                    @if($pesan->jumlah_peserta)
                    <div class="sm:col-span-2 p-3.5 bg-slate-50 rounded-xl border border-slate-100">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Estimasi Partisipan</p>
                        <p class="font-bold text-slate-800 flex items-center gap-1.5">
                            <i data-lucide="users" class="w-4 h-4 text-forest-700"></i>
                            Sekitar {{ number_format($pesan->jumlah_peserta) }} Orang
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Deskripsi Acara --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs">
                <h3 class="font-display font-bold text-slate-900 text-sm mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                    <i data-lucide="file-text" class="w-4 h-4 text-forest-700"></i>
                    Deskripsi & Susunan Kegiatan
                </h3>

                <div class="text-slate-700 text-sm leading-relaxed whitespace-pre-wrap font-sans">
                    {{ $pesan->deskripsi_acara }}
                </div>
            </div>

            {{-- Dokumen Lampiran Resmi (PDF) --}}
            @if($pesan->dokumen_lampiran)
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs">
                <h3 class="font-display font-bold text-slate-900 text-sm mb-4 pb-3 border-b border-slate-100 flex items-center justify-between">
                    <span class="flex items-center gap-2">
                        <i data-lucide="file-text" class="w-4 h-4 text-rose-500"></i>
                        Dokumen Surat / Proposal Acara
                    </span>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 border border-emerald-200 uppercase">
                        PDF Terlampir
                    </span>
                </h3>

                <div class="flex items-center justify-between gap-4 p-4 bg-slate-50 border border-slate-200 rounded-xl">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-10 h-10 rounded-lg bg-rose-100 flex items-center justify-center text-rose-600 flex-shrink-0 font-bold text-xs">
                            PDF
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-slate-800 truncate">Proposal_Acara_{{ Str::slug($pesan->nama_acara) }}.pdf</p>
                            <p class="text-xs text-slate-400">Proposal Resmi / Rundown Acara</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 flex-shrink-0">
                        <a href="{{ \Illuminate\Support\Facades\Storage::url($pesan->dokumen_lampiran) }}" target="_blank"
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold transition-all">
                            <i data-lucide="file-text" class="w-3.5 h-3.5"></i> Buka PDF
                        </a>
                        <a href="{{ \Illuminate\Support\Facades\Storage::url($pesan->dokumen_lampiran) }}" download
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-100 text-slate-700 text-xs font-semibold transition-all">
                            <i data-lucide="download" class="w-3.5 h-3.5"></i> Unduh
                        </a>
                    </div>
                </div>
            </div>
            @endif

            {{-- Catatan Internal Admin --}}
            @if($pesan->catatan_admin)
            <div class="bg-amber-50/70 border border-amber-200 rounded-2xl p-5 shadow-xs">
                <h4 class="text-xs font-bold text-amber-800 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                    <i data-lucide="sticky-note" class="w-3.5 h-3.5"></i> Catatan Internal Admin
                </h4>
                <p class="text-xs text-amber-900 leading-relaxed">{{ $pesan->catatan_admin }}</p>
            </div>
            @endif

        </div>

        {{-- Right Column (1 Col Sidebar) --}}
        <div class="space-y-6">

            {{-- Penyelenggara Card --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
                <h3 class="font-display font-bold text-slate-900 text-sm mb-3 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i data-lucide="user" class="w-4 h-4 text-forest-700"></i>
                    Informasi Penyelenggara
                </h3>

                <div class="space-y-3 text-xs">
                    <div>
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Nama Penyelenggara</span>
                        <span class="text-slate-800 font-bold text-sm block mt-0.5">{{ $pesan->name }}</span>
                    </div>

                    @if($pesan->nama_instansi)
                    <div>
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Lembaga / Instansi</span>
                        <span class="text-slate-700 font-medium block mt-0.5">{{ $pesan->nama_instansi }}</span>
                    </div>
                    @endif

                    @if($pesan->no_whatsapp)
                    <div class="pt-2">
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block mb-1.5">Kontak WhatsApp</span>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pesan->no_whatsapp) }}?text=Halo%20{{ urlencode($pesan->name) }},%20terkait%20acara%20'{{ urlencode($pesan->nama_acara) }}'%20di%20Website%20Desa%20Jambelaer..."
                           target="_blank"
                           class="inline-flex items-center gap-2 w-full px-3 py-2 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 font-semibold hover:bg-emerald-100 transition-all font-mono text-xs">
                            <i data-lucide="message-square" class="w-4 h-4"></i>
                            {{ $pesan->no_whatsapp }}
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Kelola Status Verifikasi --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
                <h3 class="font-display font-bold text-slate-900 text-sm mb-3 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i data-lucide="shield" class="w-4 h-4 text-forest-700"></i>
                    Ubah Status Verifikasi
                </h3>

                <form method="POST" action="{{ route('admin.acara.status', $pesan) }}" class="space-y-2">
                    @csrf
                    @method('PATCH')

                    <button type="submit" name="status" value="disetujui"
                            class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl border text-xs font-semibold transition-all {{ $pesan->status === 'disetujui' ? 'bg-emerald-50 border-emerald-500 text-emerald-800 shadow-xs' : 'border-slate-200 text-slate-700 hover:bg-slate-50' }}">
                        <span class="flex items-center gap-2">
                            <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600"></i> Setujui Acara
                        </span>
                        @if($pesan->status === 'disetujui')
                            <span class="text-[10px] font-bold bg-emerald-200/60 px-1.5 py-0.5 rounded">Aktif</span>
                        @endif
                    </button>

                    <button type="submit" name="status" value="menunggu"
                            class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl border text-xs font-semibold transition-all {{ $pesan->status === 'menunggu' ? 'bg-amber-50 border-amber-500 text-amber-800 shadow-xs' : 'border-slate-200 text-slate-700 hover:bg-slate-50' }}">
                        <span class="flex items-center gap-2">
                            <i data-lucide="clock" class="w-4 h-4 text-amber-600"></i> Tunda / Review
                        </span>
                        @if($pesan->status === 'menunggu')
                            <span class="text-[10px] font-bold bg-amber-200/60 px-1.5 py-0.5 rounded">Aktif</span>
                        @endif
                    </button>

                    <button type="submit" name="status" value="ditolak"
                            class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl border text-xs font-semibold transition-all {{ $pesan->status === 'ditolak' ? 'bg-rose-50 border-rose-500 text-rose-800 shadow-xs' : 'border-slate-200 text-slate-700 hover:bg-slate-50' }}">
                        <span class="flex items-center gap-2">
                            <i data-lucide="x-circle" class="w-4 h-4 text-rose-600"></i> Tolak Acara
                        </span>
                        @if($pesan->status === 'ditolak')
                            <span class="text-[10px] font-bold bg-rose-200/60 px-1.5 py-0.5 rounded">Aktif</span>
                        @endif
                    </button>
                </form>
            </div>

            {{-- Metadata Info --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs text-xs space-y-2.5">
                <h3 class="font-display font-bold text-slate-900 text-xs mb-2 pb-2 border-b border-slate-100 flex items-center gap-1.5">
                    <i data-lucide="info" class="w-3.5 h-3.5 text-slate-400"></i>
                    Informasi Sistem
                </h3>

                <div class="flex justify-between text-slate-600">
                    <span class="text-slate-400">Dibuat pada:</span>
                    <span class="font-medium">{{ $pesan->created_at->format('d/m/Y H:i') }}</span>
                </div>

                <div class="flex justify-between text-slate-600">
                    <span class="text-slate-400">Pembaruan:</span>
                    <span class="font-medium">{{ $pesan->updated_at->format('d/m/Y H:i') }}</span>
                </div>

                <div class="flex justify-between text-slate-600">
                    <span class="text-slate-400">Halaman Publik:</span>
                    <a href="{{ route('acara') }}" target="_blank" class="text-forest-700 hover:underline font-semibold flex items-center gap-0.5">
                        Lihat <i data-lucide="external-link" class="w-3 h-3"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
