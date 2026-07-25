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
            <span class="badge-{{ $pesan->jenis_pesan == 'pertanyaan_umum' ? 'blue' : ($pesan->jenis_pesan == 'pengaduan' ? 'red' : 'sky') }}">
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
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wider font-bold mb-2">Isi Pengaduan</p>
                        <div class="text-slate-700 text-sm leading-relaxed whitespace-pre-wrap bg-slate-50 rounded-xl p-4 border border-slate-200">{{ $pesan->message }}</div>
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
                </div>
            @endif
        </div>

        {{-- Actions --}}
        @php
            $hasEmail = !empty($pesan->email) && $pesan->email !== '-' && filter_var($pesan->email, FILTER_VALIDATE_EMAIL);
            $hasWa = !empty($pesan->no_whatsapp) && $pesan->no_whatsapp !== '-';
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
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pesan->no_whatsapp) }}?text=Halo%20{{ urlencode($pesan->name) }}" target="_blank"
               class="btn-secondary">
                <i data-lucide="message-circle" class="w-4 h-4"></i>
                WhatsApp
            </a>
            @endif
            @elseif($hasWa)
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pesan->no_whatsapp) }}?text=Halo%20{{ urlencode($pesan->name) }}" target="_blank"
               class="btn-primary">
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
</style>

@endsection


