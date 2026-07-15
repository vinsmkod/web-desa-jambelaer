@extends('admin.layouts.admin')

@section('title', 'Pesan Masuk')
@section('page_title', 'Pesan Masuk')
@section('page_subtitle', 'Aspirasi & pertanyaan dari pengunjung website')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
        <span class="text-sm text-slate-400">{{ $pesan->count() }} total pesan</span>
        @php $unread = $pesan->where('is_read', false)->count(); @endphp
        @if($unread > 0)
        <span class="badge-unread">{{ $unread }} belum dibaca</span>
        @endif
    </div>
</div>

<div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
    @if($pesan->isEmpty())
    <div class="flex flex-col items-center justify-center py-20 text-slate-600">
        <i data-lucide="inbox" class="w-12 h-12 mb-3"></i>
        <p class="font-semibold">Belum ada pesan masuk</p>
        <p class="text-sm mt-1">Pesan dari form kontak akan muncul di sini</p>
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-800 text-xs font-bold text-slate-500 uppercase tracking-wider">
                    <th class="text-left px-5 py-3.5 w-10"></th>
                    <th class="text-left px-4 py-3.5">Pengirim</th>
                    <th class="text-left px-4 py-3.5">Subjek</th>
                    <th class="text-left px-4 py-3.5 hidden md:table-cell">Waktu</th>
                    <th class="text-left px-4 py-3.5">Status</th>
                    <th class="text-right px-5 py-3.5">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                @foreach($pesan as $p)
                <tr class="hover:bg-slate-800/40 transition-colors {{ !$p->is_read ? 'bg-amber-600/5' : '' }}">
                    <td class="px-5 py-4">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-violet-600 to-violet-400 flex items-center justify-center text-white font-bold text-xs">
                            {{ strtoupper(substr($p->name, 0, 1)) }}
                        </div>
                    </td>
                    <td class="px-4 py-4">
                        <p class="font-semibold text-slate-200 {{ !$p->is_read ? 'text-white' : '' }}">{{ $p->name }}</p>
                        <p class="text-xs text-slate-500">{{ $p->email }}</p>
                    </td>
                    <td class="px-4 py-4">
                        <p class="text-slate-300 {{ !$p->is_read ? 'font-semibold text-white' : '' }}">{{ $p->subject }}</p>
                        <p class="text-xs text-slate-500 truncate max-w-xs">{{ Str::limit($p->message, 60) }}</p>
                    </td>
                    <td class="px-4 py-4 text-slate-500 text-xs hidden md:table-cell">
                        <p>{{ $p->created_at->format('d M Y') }}</p>
                        <p>{{ $p->created_at->format('H:i') }} WIB</p>
                    </td>
                    <td class="px-4 py-4">
                        @if($p->is_read)
                        <span class="badge-read">Sudah Dibaca</span>
                        @else
                        <span class="badge-unread">Belum Dibaca</span>
                        @endif
                    </td>
                    <td class="px-5 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.pesan.show', $p) }}"
                               class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-500 hover:bg-sky-600/20 hover:text-sky-400 transition-all" title="Lihat">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </a>
                            @if(!$p->is_read)
                            <form method="POST" action="{{ route('admin.pesan.read', $p) }}">
                                @csrf @method('PATCH')
                                <button type="submit" title="Tandai Sudah Dibaca"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-500 hover:bg-emerald-600/20 hover:text-emerald-400 transition-all">
                                    <i data-lucide="check" class="w-4 h-4"></i>
                                </button>
                            </form>
                            @endif
                            <form method="POST" action="{{ route('admin.pesan.destroy', $p) }}"
                                  onsubmit="return confirm('Hapus pesan dari {{ $p->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit"
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

@endsection
