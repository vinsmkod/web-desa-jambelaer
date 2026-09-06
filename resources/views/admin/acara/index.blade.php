@extends('admin.layouts.admin')

@section('title', 'Agenda & Acara Desa')
@section('page_title', 'Agenda & Acara Desa')
@section('page_subtitle', 'Kelola acara resmi pemerintah desa serta kurasi pengajuan acara dari masyarakat')

@section('content')

{{-- ── Top Stat Cards ── --}}
<div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 flex items-start gap-3.5 shadow-xs">
        <div class="w-11 h-11 rounded-xl bg-forest-50 border border-forest-100 flex items-center justify-center text-forest-700 flex-shrink-0">
            <i data-lucide="calendar" class="w-5 h-5"></i>
        </div>
        <div class="min-w-0">
            <p class="text-2xl font-black font-display text-slate-900 leading-none">{{ $stats['total'] }}</p>
            <p class="text-xs text-slate-400 mt-1 font-medium">Total Acara Aktif</p>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 flex items-start gap-3.5 shadow-xs">
        <div class="w-11 h-11 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 flex-shrink-0">
            <i data-lucide="building-2" class="w-5 h-5"></i>
        </div>
        <div class="min-w-0">
            <p class="text-2xl font-black font-display text-slate-900 leading-none">{{ $stats['desa'] }}</p>
            <p class="text-xs text-slate-400 mt-1 font-medium">Dari Pemdes</p>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 flex items-start gap-3.5 shadow-xs">
        <div class="w-11 h-11 rounded-xl bg-sky-50 border border-sky-100 flex items-center justify-center text-sky-600 flex-shrink-0">
            <i data-lucide="users" class="w-5 h-5"></i>
        </div>
        <div class="min-w-0">
            <p class="text-2xl font-black font-display text-slate-900 leading-none">{{ $stats['pengajuan'] }}</p>
            <p class="text-xs text-slate-400 mt-1 font-medium">Pengajuan Warga</p>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 flex items-start gap-3.5 shadow-xs">
        <div class="w-11 h-11 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600 flex-shrink-0">
            <i data-lucide="clock" class="w-5 h-5"></i>
        </div>
        <div class="min-w-0">
            <div class="flex items-center gap-1.5">
                <p class="text-2xl font-black font-display text-slate-900 leading-none">{{ $stats['menunggu'] }}</p>
                @if($stats['menunggu'] > 0)
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-ping"></span>
                @endif
            </div>
            <p class="text-xs text-slate-400 mt-1 font-medium">Perlu Review</p>
        </div>
    </div>
</div>

{{-- ── Action Header & Filter Tabs ── --}}
<div class="bg-white border border-slate-200 rounded-2xl p-4 mb-5 shadow-xs">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
        <!-- Search Form -->
        <form method="GET" action="{{ route('admin.acara.index') }}" class="relative flex-1 max-w-md">
            @if($tab !== 'semua')
                <input type="hidden" name="tab" value="{{ $tab }}">
            @endif
            <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
            <input type="text" name="q" value="{{ $search }}"
                   placeholder="Cari acara, lokasi, atau panitia..."
                   class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-forest-500/20 focus:border-forest-600 transition-all">
        </form>

        <!-- Create Button -->
        <a href="{{ route('admin.acara.create') }}"
           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-forest-800 hover:bg-forest-700 text-white text-xs font-semibold shadow-xs transition-all flex-shrink-0">
            <i data-lucide="plus-circle" class="w-4 h-4 text-sand-300"></i>
            Tambah Acara Desa
        </a>
    </div>

    <!-- Filter Tabs -->
    <div class="flex items-center gap-1 overflow-x-auto pt-3 text-xs">
        @php
            $tabList = [
                'semua'     => ['label' => 'Semua Acara',     'count' => $stats['total']],
                'desa'      => ['label' => 'Acara Pemdes',    'count' => $stats['desa']],
                'pengajuan' => ['label' => 'Pengajuan Warga', 'count' => $stats['pengajuan']],
                'menunggu'  => ['label' => 'Perlu Review',    'count' => $stats['menunggu']],
                'publik'    => ['label' => 'Tayang di Web',   'count' => $stats['dipublikasikan']],
                'arsip'     => ['label' => 'Arsip Lewat',     'count' => $stats['arsip']],
            ];
        @endphp

        @foreach($tabList as $key => $item)
            @php $isActive = ($tab === $key); @endphp
            <a href="{{ route('admin.acara.index', array_merge(request()->query(), ['tab' => $key])) }}"
               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg font-medium transition-all whitespace-nowrap {{ $isActive ? 'bg-forest-800 text-white font-semibold shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}">
                <span>{{ $item['label'] }}</span>
                <span class="text-[10px] px-1.5 py-0.2 rounded-md {{ $isActive ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-500' }}">
                    {{ $item['count'] }}
                </span>
            </a>
        @endforeach
    </div>
</div>

{{-- ── Table Acara ── --}}
<div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
    @if($acaras->isEmpty())
        <div class="flex flex-col items-center justify-center py-16 text-center px-4">
            <div class="w-14 h-14 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 mb-3">
                <i data-lucide="calendar-x" class="w-7 h-7"></i>
            </div>
            <p class="font-bold text-slate-700 text-sm">Tidak ada agenda acara ditemukan</p>
            <p class="text-xs text-slate-400 mt-1 max-w-sm">
                @if($search)
                    Pencarian "{{ $search }}" tidak menemukan hasil. Coba kata kunci lain.
                @else
                    Belum ada agenda acara untuk filter ini. Buat acara baru untuk desa Anda sekarang.
                @endif
            </p>
            <div class="mt-4 flex gap-2">
                @if($search)
                    <a href="{{ route('admin.acara.index', ['tab' => $tab]) }}" class="px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50">Reset Cari</a>
                @endif
                <a href="{{ route('admin.acara.create') }}" class="px-4 py-1.5 rounded-lg bg-forest-800 text-white text-xs font-semibold hover:bg-forest-700">Buat Acara Baru</a>
            </div>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/70 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        <th class="py-3.5 px-4">Acara</th>
                        <th class="py-3.5 px-4">Penyelenggara</th>
                        <th class="py-3.5 px-4">Waktu & Jadwal</th>
                        <th class="py-3.5 px-4">Status & Publikasi</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($acaras as $a)
                    @php
                        $isDesa = ($a->user_id !== null || str_contains(strtolower($a->name), 'desa') || str_contains(strtolower($a->nama_instansi ?? ''), 'desa'));
                        $thumb = null;
                        if ($a->foto_bukti) {
                            $thumb = (str_starts_with($a->foto_bukti, 'http') || str_starts_with($a->foto_bukti, '/'))
                                ? asset($a->foto_bukti)
                                : \Illuminate\Support\Facades\Storage::url($a->foto_bukti);
                        }
                    @endphp
                    <tr class="hover:bg-slate-50/80 transition-colors {{ !$a->is_read ? 'bg-amber-50/40' : '' }}">
                        <!-- Acara Info -->
                        <td class="py-3.5 px-4">
                            <div class="flex items-center gap-3">
                                @if($thumb)
                                    <img src="{{ $thumb }}" alt="{{ $a->nama_acara }}"
                                         class="w-11 h-11 rounded-xl object-cover border border-slate-200 flex-shrink-0 bg-slate-100 shadow-xs">
                                @else
                                    <div class="w-11 h-11 rounded-xl {{ $isDesa ? 'bg-forest-50 text-forest-700 border-forest-200' : 'bg-amber-50 text-amber-700 border-amber-200' }} border flex items-center justify-center flex-shrink-0 font-bold">
                                        <i data-lucide="calendar" class="w-5 h-5"></i>
                                    </div>
                                @endif
                                <div class="min-w-0 max-w-xs sm:max-w-md">
                                    <div class="flex items-center gap-1.5">
                                        <a href="{{ route('admin.acara.show', $a) }}" class="font-bold text-slate-900 hover:text-forest-700 text-sm truncate block">
                                            {{ $a->nama_acara }}
                                        </a>
                                        @if(!$a->is_read)
                                            <span class="w-2 h-2 rounded-full bg-amber-500 flex-shrink-0" title="Baru / Belum Dibaca"></span>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-1 text-xs text-slate-400 mt-0.5 truncate">
                                        <i data-lucide="map-pin" class="w-3 h-3 flex-shrink-0"></i>
                                        <span class="truncate">{{ $a->lokasi_acara }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Penyelenggara -->
                        <td class="py-3.5 px-4">
                            <div>
                                <div class="flex items-center gap-1.5">
                                    @if($isDesa)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <i data-lucide="shield-check" class="w-3 h-3"></i> Pemdes
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-sky-50 text-sky-700 border border-sky-200">
                                            <i data-lucide="user" class="w-3 h-3"></i> Warga
                                        </span>
                                    @endif
                                    <span class="text-xs font-semibold text-slate-700 truncate max-w-[120px]">{{ $a->name }}</span>
                                </div>
                                @if($a->no_whatsapp)
                                    <p class="text-[11px] text-slate-400 mt-0.5 font-mono">{{ $a->no_whatsapp }}</p>
                                @endif
                            </div>
                        </td>

                        <!-- Waktu & Tanggal -->
                        <td class="py-3.5 px-4 whitespace-nowrap">
                            <div class="text-xs">
                                <p class="font-semibold text-slate-800">
                                    {{ $a->tanggal_acara ? $a->tanggal_acara->translatedFormat('d M Y') : '-' }}
                                </p>
                                <p class="text-[11px] text-slate-400 mt-0.5 flex items-center gap-1">
                                    <i data-lucide="clock" class="w-3 h-3"></i>
                                    {{ $a->waktu_acara ? date('H:i', strtotime($a->waktu_acara)) . ' WIB' : 'Waktu Fleksibel' }}
                                </p>
                            </div>
                        </td>

                        <!-- Status & Publikasi -->
                        <td class="py-3.5 px-4 whitespace-nowrap">
                            <div class="space-y-1">
                                <!-- Status Verifikasi -->
                                <div>
                                    @if($a->status === 'disetujui')
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <i data-lucide="check" class="w-3 h-3"></i> Disetujui
                                        </span>
                                    @elseif($a->status === 'menunggu')
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                            <i data-lucide="clock" class="w-3 h-3"></i> Menunggu Review
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                            <i data-lucide="x" class="w-3 h-3"></i> Ditolak
                                        </span>
                                    @endif
                                </div>

                                <!-- Status Publikasi -->
                                <div>
                                    @if($a->is_archived)
                                        <span class="text-[10px] text-slate-400 italic">Selesai / Diarsipkan</span>
                                    @elseif($a->dipublikasikan)
                                        <span class="inline-flex items-center gap-1 text-[11px] text-emerald-600 font-semibold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                            Tayang di Website
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-[11px] text-slate-400">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                                            Draf / Tidak Tayang
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <!-- Aksi Buttons -->
                        <td class="py-3.5 px-4 text-right whitespace-nowrap">
                            <div class="inline-flex items-center gap-1.5">
                                <a href="{{ route('admin.acara.show', $a) }}"
                                   class="p-1.5 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-all"
                                   title="Lihat Detail Acara">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>

                                <a href="{{ route('admin.acara.edit', $a) }}"
                                   class="p-1.5 rounded-lg border border-amber-200 text-amber-600 hover:bg-amber-50 transition-all"
                                   title="Edit Data Acara">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>

                                <form method="POST" action="{{ route('admin.acara.destroy', $a) }}"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus acara \'{{ addslashes($a->nama_acara) }}\'? Data yang dihapus tidak dapat dipulihkan.')"
                                      class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="p-1.5 rounded-lg border border-rose-200 text-rose-500 hover:bg-rose-50 transition-all"
                                            title="Hapus Acara">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($acaras->hasPages())
        <div class="px-4 py-3 border-t border-slate-100">
            {{ $acaras->links() }}
        </div>
        @endif
    @endif
</div>

@endsection
