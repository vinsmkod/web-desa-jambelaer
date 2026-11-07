@extends('layouts.app')

@section('title', 'Pengajuan Layanan Saya – Desa Jambelaer')
@section('meta_desc', 'Pantau status, progres, dan tanggapan resmi dari Pemerintah Desa Jambelaer atas permohonan surat, pengaduan, pertanyaan, atau pendaftaran UMKM.')

@section('content')
{{-- Breadcrumb --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 sm:pt-6">
    <nav class="flex items-center gap-1.5 text-xs text-stone-500 mb-4">
        <a href="{{ route('home') }}" class="hover:text-forest-800 transition-colors">Beranda</a>
        <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-stone-300"></i>
        <a href="{{ route('layanan') }}" class="hover:text-forest-800 transition-colors">Layanan Masyarakat</a>
        <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-stone-300"></i>
        <span class="text-forest-800 font-semibold">Pengajuan Saya</span>
    </nav>
</div>

{{-- Banner Header --}}
<div class="relative overflow-hidden bg-forest-900 rounded-[28px] sm:rounded-[32px] mx-3 sm:mx-5 lg:mx-6 shadow-sm mb-10">
    <div class="absolute inset-0 bg-gradient-to-r from-forest-950 via-forest-900 to-forest-800 opacity-95"></div>
    <div class="relative px-6 py-10 sm:py-12 lg:px-12 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-sand-300 border border-white/15 text-xs font-semibold uppercase tracking-wider mb-2">
                <i data-lucide="folder-check" class="w-3.5 h-3.5"></i>
                Layanan Mandiri Warga
            </div>
            <h1 class="font-display font-extrabold text-2xl sm:text-3xl lg:text-4xl text-white">
                Daftar Pengajuan Saya
            </h1>
            <p class="text-xs sm:text-sm text-white/75 mt-1.5 max-w-xl font-light">
                Pantau proses verifikasi, tindak lanjut, dan tanggapan resmi dari Pemerintah Desa Jambelaer untuk seluruh permohonan layanan yang Anda ajukan.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('profil.edit') }}"
                class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 text-xs font-bold text-white transition-all shadow-sm">
                <i data-lucide="user" class="w-3.5 h-3.5"></i>
                Profil Saya
            </a>
            <a href="{{ route('layanan') }}#layanan-hub"
                class="btn-primary bg-sand-500 hover:bg-sand-600 !text-forest-950 border-sand-400 text-xs py-2.5 px-5 gap-2 shadow-lg">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                Buat Pengajuan Baru
            </a>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">

    {{-- Flash Message --}}
    @if(session('success'))
    <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 flex items-start gap-3 text-sm text-emerald-800 shadow-sm">
        <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-600 flex-shrink-0 mt-0.5"></i>
        <div>
            <p class="font-semibold">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    {{-- Filter & Search Bar --}}
    <div class="bg-white rounded-2xl border border-stone-200/80 p-4 shadow-sm mb-6 space-y-3">
        {{-- Kategori Layanan Filter Pills --}}
        <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none text-xs">
            <span class="text-stone-400 font-bold uppercase tracking-wider text-[10px] mr-1">Modul:</span>
            <a href="{{ route('pengajuan.saya', array_merge(request()->query(), ['jenis' => 'semua'])) }}"
                class="px-3 py-1.5 rounded-lg font-semibold transition-all {{ ($jenisFilter ?? 'semua') === 'semua' ? 'bg-forest-800 text-white' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">
                Semua Modul
            </a>
            <a href="{{ route('pengajuan.saya', array_merge(request()->query(), ['jenis' => 'pengajuan_surat'])) }}"
                class="px-3 py-1.5 rounded-lg font-semibold transition-all {{ ($jenisFilter ?? '') === 'pengajuan_surat' ? 'bg-violet-700 text-white' : 'bg-violet-50 text-violet-700 hover:bg-violet-100' }}">
                Pengajuan Surat
            </a>
            <a href="{{ route('pengajuan.saya', array_merge(request()->query(), ['jenis' => 'pengaduan'])) }}"
                class="px-3 py-1.5 rounded-lg font-semibold transition-all {{ ($jenisFilter ?? '') === 'pengaduan' ? 'bg-rose-700 text-white' : 'bg-rose-50 text-rose-700 hover:bg-rose-100' }}">
                Pengaduan
            </a>
            <a href="{{ route('pengajuan.saya', array_merge(request()->query(), ['jenis' => 'pertanyaan_umum'])) }}"
                class="px-3 py-1.5 rounded-lg font-semibold transition-all {{ ($jenisFilter ?? '') === 'pertanyaan_umum' ? 'bg-sky-700 text-white' : 'bg-sky-50 text-sky-700 hover:bg-sky-100' }}">
                Pertanyaan Umum
            </a>
            <a href="{{ route('pengajuan.saya', array_merge(request()->query(), ['jenis' => 'pendaftaran_umkm'])) }}"
                class="px-3 py-1.5 rounded-lg font-semibold transition-all {{ ($jenisFilter ?? '') === 'pendaftaran_umkm' ? 'bg-emerald-700 text-white' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }}">
                Pendaftaran UMKM
            </a>
        </div>

        <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4 pt-2 border-t border-stone-100">
            
            {{-- Tabs Status --}}
            <div class="flex items-center gap-1.5 overflow-x-auto pb-2 lg:pb-0 scrollbar-none text-xs font-semibold">
                @php
                    $tabs = [
                        'semua'        => ['label' => 'Semua', 'count' => $stats['semua']],
                        'diajukan'     => ['label' => 'Diajukan', 'count' => $stats['diajukan']],
                        'diverifikasi' => ['label' => 'Diverifikasi/Dijawab', 'count' => $stats['diverifikasi']],
                        'diproses'     => ['label' => 'Diproses', 'count' => $stats['diproses']],
                        'selesai'      => ['label' => 'Selesai/Disetujui', 'count' => $stats['selesai']],
                        'ditolak'      => ['label' => 'Ditolak', 'count' => $stats['ditolak']],
                    ];
                @endphp

                @foreach($tabs as $key => $t)
                <a href="{{ route('pengajuan.saya', array_merge(request()->query(), ['status' => $key])) }}"
                    class="px-3 py-1.5 rounded-xl transition-all whitespace-nowrap flex items-center gap-1.5 {{ $tab === $key ? 'bg-forest-800 text-white shadow-sm' : 'bg-stone-50 text-stone-600 hover:bg-stone-100' }}">
                    <span>{{ $t['label'] }}</span>
                    <span class="text-[10px] px-1.5 py-0.5 rounded-full {{ $tab === $key ? 'bg-white/20 text-white' : 'bg-stone-200 text-stone-600' }}">
                        {{ $t['count'] }}
                    </span>
                </a>
                @endforeach
            </div>

            {{-- Search Form --}}
            <form action="{{ route('pengajuan.saya') }}" method="GET" class="flex-shrink-0">
                <input type="hidden" name="status" value="{{ $tab }}">
                <input type="hidden" name="jenis" value="{{ $jenisFilter }}">
                <div class="relative w-full sm:w-64">
                    <input type="text" name="q" value="{{ $search }}"
                        placeholder="Cari nomor / subjek..."
                        class="w-full pl-9 pr-8 py-2 bg-stone-50 border border-stone-200 rounded-xl text-xs text-stone-800 placeholder:text-stone-400 focus:outline-none focus:bg-white focus:border-forest-600 transition-all">
                    <i data-lucide="search" class="w-4 h-4 text-stone-400 absolute left-3 top-2.5"></i>
                    @if($search)
                    <a href="{{ route('pengajuan.saya', ['status' => $tab, 'jenis' => $jenisFilter]) }}" class="absolute right-2.5 top-2.5 text-stone-400 hover:text-stone-600">
                        <i data-lucide="x" class="w-3.5 h-3.5"></i>
                    </a>
                    @endif
                </div>
            </form>

        </div>
    </div>

    {{-- List Pengajuan --}}
    @if($pengajuanList->isEmpty())
    <div class="bg-white rounded-3xl border border-stone-200/80 p-12 text-center max-w-lg mx-auto shadow-sm">
        <div class="w-16 h-16 rounded-2xl bg-stone-50 border border-stone-200 flex items-center justify-center text-stone-400 mx-auto mb-4">
            <i data-lucide="inbox" class="w-8 h-8"></i>
        </div>
        <h3 class="font-display font-bold text-base text-stone-800">Belum Ada Pengajuan</h3>
        <p class="text-xs text-stone-500 mt-1 mb-6 font-light">
            @if($search || $tab !== 'semua' || $jenisFilter !== 'semua')
                Tidak ditemukan pengajuan dengan kriteria pencarian ini.
            @else
                Anda belum pernah membuat pengajuan layanan. Silakan pilih layanan desa untuk memulai.
            @endif
        </p>
        <a href="{{ route('layanan') }}#layanan-hub"
            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-forest-800 hover:bg-forest-900 text-white font-semibold text-xs shadow-md transition-all">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Ajukan Permohonan Sekarang
        </a>
    </div>
    @else
    <div class="space-y-4">
        @foreach($pengajuanList as $item)
        <div class="bg-white rounded-2xl border border-stone-200/80 hover:border-forest-300 p-5 sm:p-6 shadow-sm hover:shadow-md transition-all flex flex-col md:flex-row md:items-center justify-between gap-5 group">
            
            {{-- Info Kiri --}}
            <div class="flex-1 min-w-0">
                <div class="flex flex-wrap items-center gap-2 mb-2">
                    {{-- Nomor Pengajuan Pill --}}
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-stone-100 text-stone-700 text-xs font-mono font-bold">
                        <i data-lucide="hash" class="w-3.5 h-3.5 text-stone-400"></i>
                        {{ $item->nomor_tiket }}
                    </span>

                    {{-- Jenis Layanan Badge --}}
                    @if($item->jenis_layanan === 'pengajuan_surat')
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-violet-50 text-violet-800 text-xs font-semibold border border-violet-100">
                            <i data-lucide="file-text" class="w-3.5 h-3.5 text-violet-600"></i>
                            {{ $item->jenis_layanan_label }}
                        </span>
                    @elseif($item->jenis_layanan === 'pertanyaan_umum')
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-sky-50 text-sky-800 text-xs font-semibold border border-sky-100">
                            <i data-lucide="help-circle" class="w-3.5 h-3.5 text-sky-600"></i>
                            Pertanyaan Umum
                        </span>
                    @elseif($item->jenis_layanan === 'pengaduan')
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-rose-50 text-rose-800 text-xs font-semibold border border-rose-100">
                            <i data-lucide="alert-triangle" class="w-3.5 h-3.5 text-rose-600"></i>
                            Pengaduan Warga
                        </span>
                    @elseif($item->jenis_layanan === 'pendaftaran_umkm')
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-800 text-xs font-semibold border border-emerald-100">
                            <i data-lucide="store" class="w-3.5 h-3.5 text-emerald-600"></i>
                            Pendaftaran UMKM
                        </span>
                    @endif

                    {{-- Tanggal --}}
                    <span class="text-xs text-stone-400 flex items-center gap-1">
                        <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                        {{ $item->created_at ? $item->created_at->translatedFormat('d M Y, H:i') : '-' }} WIB
                    </span>
                </div>

                {{-- Judul / Subjek --}}
                <h3 class="font-display font-bold text-base text-stone-900 group-hover:text-forest-800 transition-colors line-clamp-1">
                    {{ $item->judul_layanan }}
                </h3>

                {{-- Cuplikan Pesan / Keterangan --}}
                <p class="text-xs text-stone-500 mt-1 line-clamp-2 font-light">
                    {{ $item->ringkasan }}
                </p>

                {{-- Indikator Tanggapan Admin --}}
                <div class="flex flex-wrap items-center gap-3 mt-3 pt-3 border-t border-stone-100 text-[11px]">
                    @if($item->catatan_admin)
                    <span class="text-emerald-700 font-semibold flex items-center gap-1 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100">
                        <i data-lucide="message-square" class="w-3 h-3 text-emerald-600"></i>
                        Ada Tanggapan / Jawaban Administrator
                    </span>
                    @endif
                </div>
            </div>

            {{-- Kolom Kanan: Status & Action --}}
            <div class="flex flex-row md:flex-col items-center md:items-end justify-between md:justify-center gap-3 border-t md:border-t-0 pt-3 md:pt-0 border-stone-100 flex-shrink-0">
                {{-- Status Badge --}}
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold border {{ $item->status_badge_class }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ strtolower($item->status ?? '') === 'ditolak' ? 'bg-rose-500' : (in_array(strtolower($item->status ?? ''), ['selesai', 'disetujui']) ? 'bg-emerald-500' : 'bg-amber-500') }}"></span>
                    {{ $item->status_label }}
                </span>

                {{-- Action Button --}}
                <a href="{{ route('pengajuan.show.detail', ['jenis' => $item->jenis_layanan, 'id' => $item->primary_id]) }}"
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-forest-50 hover:bg-forest-800 text-forest-800 hover:text-white font-semibold text-xs transition-all">
                    Lihat Detail
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </a>

                @if(!empty($item->editable) && !empty($item->edit_url))
                <a href="{{ $item->edit_url }}"
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-amber-50 hover:bg-amber-500 text-amber-800 hover:text-white font-semibold text-xs transition-all border border-amber-200 hover:border-amber-500"
                    title="Perbaiki pengajuan selagi masih berstatus Diajukan">
                    <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                    Edit
                </a>
                @endif

                @if(!empty($item->cancelable) && !empty($item->cancel_url))
                <form action="{{ $item->cancel_url }}" method="POST" class="inline-block"
                    onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pengajuan ini? Pengajuan yang dibatalkan tidak akan diproses lebih lanjut.');">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-rose-50 hover:bg-rose-500 text-rose-700 hover:text-white font-semibold text-xs transition-all border border-rose-200 hover:border-rose-500"
                        title="Batalkan pengajuan selagi masih berstatus Diajukan">
                        <i data-lucide="ban" class="w-3.5 h-3.5"></i>
                        Batalkan
                    </button>
                </form>
                @endif
            </div>

        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $pengajuanList->links() }}
    </div>
    @endif

</div>
@endsection
