@extends('admin.layouts.admin')

@section('title', 'Pengajuan Acara')
@section('page_title', 'Pengajuan Acara')
@section('page_subtitle', 'Kelola dan proses pengajuan acara desa')

@section('content')

<div class="mb-6">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
        <div class="stat-card">
            <div class="w-11 h-11 rounded-xl bg-amber-600/20 flex items-center justify-center text-amber-400 flex-shrink-0">
                <i data-lucide="calendar" class="w-5 h-5"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-2xl font-extrabold font-display text-white leading-none">{{ $stats['total'] }}</p>
                <p class="text-xs text-slate-400 mt-1">Total Pengajuan</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="w-11 h-11 rounded-xl bg-slate-600/20 flex items-center justify-center text-slate-400 flex-shrink-0">
                <i data-lucide="clock" class="w-5 h-5"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-2xl font-extrabold font-display text-white leading-none">{{ $stats['menunggu'] }}</p>
                <p class="text-xs text-slate-400 mt-1">Menunggu Review</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="w-11 h-11 rounded-xl bg-emerald-600/20 flex items-center justify-center text-emerald-400 flex-shrink-0">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-2xl font-extrabold font-display text-white leading-none">{{ $stats['disetujui'] }}</p>
                <p class="text-xs text-slate-400 mt-1">Disetujui</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="w-11 h-11 rounded-xl bg-red-600/20 flex items-center justify-center text-red-400 flex-shrink-0">
                <i data-lucide="x-circle" class="w-5 h-5"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-2xl font-extrabold font-display text-white leading-none">{{ $stats['ditolak'] }}</p>
                <p class="text-xs text-slate-400 mt-1">Ditolak</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
    @if($pengajuan->isEmpty())
    <div class="flex flex-col items-center justify-center py-20 text-slate-600">
        <i data-lucide="inbox" class="w-12 h-12 mb-3"></i>
        <p class="font-semibold">Belum ada pengajuan acara</p>
        <p class="text-sm mt-1">Pengajuan acara dari form kontak akan muncul di sini</p>
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-800 text-xs font-bold text-slate-500 uppercase tracking-wider">
                    <th class="text-left px-5 py-3.5 w-10"></th>
                    <th class="text-left px-4 py-3.5">Nama Acara</th>
                    <th class="text-left px-4 py-3.5">Penyelenggara</th>
                    <th class="text-left px-4 py-3.5">Tanggal</th>
                    <th class="text-left px-4 py-3.5">Status</th>
                    <th class="text-right px-5 py-3.5">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                @foreach($pengajuan as $p)
                <tr class="hover:bg-slate-800/40 transition-colors {{ !$p->is_read ? 'bg-amber-600/5' : '' }}">
                    <td class="px-5 py-4">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-amber-600 to-amber-400 flex items-center justify-center text-white font-bold text-xs">
                            {{ strtoupper(substr($p->name, 0, 1)) }}
                        </div>
                    </td>
                    <td class="px-4 py-4">
                        <p class="font-semibold text-slate-200 {{ !$p->is_read ? 'text-white' : '' }}">{{ $p->nama_acara }}</p>
                        <p class="text-xs text-slate-500 truncate max-w-xs">{{ $p->lokasi_acara }}</p>
                    </td>
                    <td class="px-4 py-4">
                        <p class="text-slate-300 text-sm">{{ $p->name }}</p>
                        <p class="text-xs text-slate-500">{{ $p->no_whatsapp }}</p>
                    </td>
                    <td class="px-4 py-4">
                        <div class="text-slate-400 text-sm">
                            <p>{{ $p->tanggal_acara->format('d M Y') }}</p>
                            <p class="text-xs">{{ $p->waktu_acara ? date('H:i', strtotime($p->waktu_acara)) : '-' }} WIB</p>
                        </div>
                    </td>
                    <td class="px-4 py-4">
                        <span class="badge-{{ $p->status === 'menunggu' ? 'yellow' : ($p->status === 'disetujui' ? 'green' : 'red') }}">
                            @switch($p->status)
                                @case('menunggu')
                                    Menunggu
                                    @break
                                @case('disetujui')
                                    Disetujui
                                    @break
                                @case('ditolak')
                                    Ditolak
                                    @break
                            @endswitch
                        </span>
                    </td>
                    <td class="px-5 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.pengajuan-acara.show', $p) }}"
                               class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-500 hover:bg-sky-600/20 hover:text-sky-400 transition-all" title="Lihat Detail">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.pengajuan-acara.destroy', $p) }}"
                                  onsubmit="return confirm('Hapus pengajuan acara ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" title="Hapus"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-500 hover:bg-red-600/20 hover:text-red-400 transition-all">
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
    @endif
</div>

<style>
.badge-yellow { @apply inline-flex items-center px-2.5 py-1 rounded-lg bg-amber-600/20 text-amber-400 font-semibold text-xs; }
.badge-green { @apply inline-flex items-center px-2.5 py-1 rounded-lg bg-emerald-600/20 text-emerald-400 font-semibold text-xs; }
.badge-red { @apply inline-flex items-center px-2.5 py-1 rounded-lg bg-red-600/20 text-red-400 font-semibold text-xs; }
</style>

@endsection
