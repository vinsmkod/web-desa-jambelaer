@extends('admin.layouts.admin')

@section('title', 'Pengajuan Acara')
@section('page_title', 'Pengajuan Acara')
@section('page_subtitle', 'Kelola dan proses pengajuan acara desa')

@section('content')

<div class="mb-6">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white border border-slate-200 rounded-2xl p-5 flex items-start gap-4">
            <div class="w-11 h-11 rounded-xl bg-amber-50 border border-amber-200 flex items-center justify-center text-amber-600 flex-shrink-0">
                <i data-lucide="calendar" class="w-5 h-5"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-2xl font-extrabold font-display text-slate-900 leading-none">{{ $stats['total'] }}</p>
                <p class="text-xs text-slate-400 mt-1">Total Pengajuan</p>
            </div>
        </div>
        <div class="bg-white border border-slate-200 rounded-2xl p-5 flex items-start gap-4">
            <div class="w-11 h-11 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-500 flex-shrink-0">
                <i data-lucide="clock" class="w-5 h-5"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-2xl font-extrabold font-display text-slate-900 leading-none">{{ $stats['menunggu'] }}</p>
                <p class="text-xs text-slate-400 mt-1">Menunggu Review</p>
            </div>
        </div>
        <div class="bg-white border border-slate-200 rounded-2xl p-5 flex items-start gap-4">
            <div class="w-11 h-11 rounded-xl bg-forest-50 border border-forest-200 flex items-center justify-center text-forest-700 flex-shrink-0">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-2xl font-extrabold font-display text-forest-700 leading-none">{{ $stats['disetujui'] }}</p>
                <p class="text-xs text-slate-400 mt-1">Disetujui</p>
            </div>
        </div>
        <div class="bg-white border border-slate-200 rounded-2xl p-5 flex items-start gap-4">
            <div class="w-11 h-11 rounded-xl bg-red-50 border border-red-200 flex items-center justify-center text-red-500 flex-shrink-0">
                <i data-lucide="x-circle" class="w-5 h-5"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-2xl font-extrabold font-display text-red-500 leading-none">{{ $stats['ditolak'] }}</p>
                <p class="text-xs text-slate-400 mt-1">Ditolak</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
    @if($pengajuan->isEmpty())
    <div class="flex flex-col items-center justify-center py-20 text-slate-400">
        <i data-lucide="inbox" class="w-12 h-12 mb-3"></i>
        <p class="font-semibold text-slate-600">Belum ada pengajuan acara</p>
        <p class="text-sm mt-1">Pengajuan acara dari form kontak akan muncul di sini</p>
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50 text-xs font-bold text-slate-500 uppercase tracking-wider">
                    <th class="text-left px-5 py-3.5 w-10"></th>
                    <th class="text-left px-4 py-3.5">Nama Acara</th>
                    <th class="text-left px-4 py-3.5">Penyelenggara</th>
                    <th class="text-left px-4 py-3.5">Tanggal</th>
                    <th class="text-left px-4 py-3.5">Status</th>
                    <th class="text-right px-5 py-3.5">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($pengajuan as $p)
                <tr class="hover:bg-slate-50 transition-colors {{ !$p->is_read ? 'bg-amber-50/50' : '' }}">
                    <td class="px-5 py-4">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-amber-600 to-amber-400 flex items-center justify-center text-white font-bold text-xs">
                            {{ strtoupper(substr($p->name, 0, 1)) }}
                        </div>
                    </td>
                    <td class="px-4 py-4">
                        <p class="font-semibold text-slate-800 {{ !$p->is_read ? 'font-bold' : '' }}">{{ $p->nama_acara }}</p>
                        <p class="text-xs text-slate-400 truncate max-w-xs">{{ $p->lokasi_acara }}</p>
                    </td>
                    <td class="px-4 py-4">
                        <p class="text-slate-700 text-sm">{{ $p->name }}</p>
                        <p class="text-xs text-slate-400">{{ $p->no_whatsapp }}</p>
                    </td>
                    <td class="px-4 py-4">
                        <div class="text-slate-600 text-sm">
                            <p>{{ $p->tanggal_acara->format('d M Y') }}</p>
                            <p class="text-xs text-slate-400">{{ $p->waktu_acara ? date('H:i', strtotime($p->waktu_acara)) : '-' }} WIB</p>
                        </div>
                    </td>
                    <td class="px-4 py-4">
                        @php
                        $statusClass = match($p->status) {
                        'menunggu' => 'bg-amber-50 text-amber-700 border-amber-200',
                        'disetujui' => 'bg-forest-50 text-forest-700 border-forest-200',
                        'ditolak' => 'bg-red-50 text-red-600 border-red-200',
                        default => 'bg-slate-50 text-slate-500 border-slate-200',
                        };
                        $statusLabel = match($p->status) {
                        'menunggu' => 'Menunggu',
                        'disetujui' => 'Disetujui',
                        'ditolak' => 'Ditolak',
                        default => $p->status,
                        };
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold border {{ $statusClass }}">
                            {{ $statusLabel }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-right">
                        <div class="flex items-center justify-end gap-1.5">
                            <a href="{{ route('admin.pengajuan-acara.show', $p) }}"
                                class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:bg-forest-50 hover:text-forest-700 transition-all" title="Lihat Detail">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.pengajuan-acara.destroy', $p) }}"
                                onsubmit="return confirm('Hapus pengajuan acara ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" title="Hapus"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:bg-red-50 hover:text-red-500 transition-all">
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

@endsection