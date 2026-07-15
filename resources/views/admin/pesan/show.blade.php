@extends('admin.layouts.admin')

@section('title', 'Detail Pesan')
@section('page_title', 'Detail Pesan')
@section('page_subtitle', 'Dari: ' . $pesan->name)

@section('content')

<div class="max-w-2xl">
    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">

        {{-- Header --}}
        <div class="flex items-start gap-4 px-6 py-5 border-b border-slate-800">
            <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-violet-600 to-violet-400 flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                {{ strtoupper(substr($pesan->name, 0, 1)) }}
            </div>
            <div class="flex-1">
                <h2 class="font-display font-bold text-white text-base">{{ $pesan->name }}</h2>
                <a href="mailto:{{ $pesan->email }}" class="text-sm text-emerald-400 hover:text-emerald-300 transition-colors">{{ $pesan->email }}</a>
                <p class="text-xs text-slate-500 mt-1">{{ $pesan->created_at->format('d M Y, H:i') }} WIB · {{ $pesan->created_at->diffForHumans() }}</p>
            </div>
            <span class="{{ $pesan->is_read ? 'badge-read' : 'badge-unread' }}">
                {{ $pesan->is_read ? 'Sudah Dibaca' : 'Belum Dibaca' }}
            </span>
        </div>

        {{-- Subject --}}
        <div class="px-6 py-4 border-b border-slate-800 bg-slate-800/30">
            <p class="text-xs text-slate-500 uppercase tracking-wider font-bold mb-1">Subjek</p>
            <p class="font-semibold text-white">{{ $pesan->subject }}</p>
        </div>

        {{-- Message Body --}}
        <div class="px-6 py-5">
            <p class="text-xs text-slate-500 uppercase tracking-wider font-bold mb-3">Isi Pesan</p>
            <div class="text-slate-300 text-sm leading-relaxed whitespace-pre-wrap bg-slate-800/50 rounded-xl p-4 border border-slate-700">{{ $pesan->message }}</div>
        </div>

        {{-- Actions --}}
        <div class="px-6 py-4 border-t border-slate-800 flex items-center gap-3">
            <a href="{{ route('admin.pesan.index') }}"
               class="flex items-center gap-2 px-4 py-2 rounded-xl border border-slate-700 text-slate-400 hover:text-slate-200 text-sm font-semibold transition-all">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Kembali
            </a>
            <a href="mailto:{{ $pesan->email }}?subject=Re: {{ $pesan->subject }}"
               class="btn-primary">
                <i data-lucide="reply" class="w-4 h-4"></i>
                Balas via Email
            </a>
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

@endsection
