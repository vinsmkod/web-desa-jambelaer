@extends('admin.layouts.admin')

@section('title', 'Detail Pengajuan Acara')
@section('page_title', 'Pengajuan Acara')
@section('page_subtitle', $pesan->nama_acara)

@section('content')

<div class="max-w-4xl">
    {{-- Status Card --}}
    <div class="bg-gradient-to-r from-slate-800 to-slate-700 border border-slate-200 rounded-2xl overflow-hidden mb-6">
        <div class="px-6 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-400 uppercase tracking-wider font-bold mb-2">Status Pengajuan</p>
                    <p class="text-xl font-bold text-white">{{ $pesan->nama_acara }}</p>
                </div>
                <span class="badge-{{ $pesan->status === 'menunggu' ? 'yellow' : ($pesan->status === 'disetujui' ? 'green' : 'red') }} text-sm">
                    @switch($pesan->status)
                        @case('menunggu')
                            Menunggu Review
                            @break
                        @case('disetujui')
                            Disetujui
                            @break
                        @case('ditolak')
                            Ditolak
                            @break
                    @endswitch
                </span>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        {{-- Main Content --}}
        <div class="lg:col-span-2">
            {{-- Informasi Penyelenggara --}}
            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-100/30">
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider">Informasi Penyelenggara</h3>
                </div>
                <div class="px-6 py-5 space-y-4">
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wider font-bold mb-1">Nama Penyelenggara</p>
                            <p class="text-slate-800">{{ $pesan->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wider font-bold mb-1">Nomor WhatsApp</p>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pesan->no_whatsapp) }}" target="_blank" class="text-sky-400 hover:text-sky-300">{{ $pesan->no_whatsapp }}</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Informasi Acara --}}
            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-100/30">
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider">Informasi Acara</h3>
                </div>
                <div class="px-6 py-5 space-y-4">
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wider font-bold mb-1">Nama Acara</p>
                        <p class="text-slate-800 font-semibold">{{ $pesan->nama_acara }}</p>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wider font-bold mb-1">Tanggal Acara</p>
                            <p class="text-slate-800">{{ $pesan->tanggal_acara->translatedFormat('l, d F Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wider font-bold mb-1">Waktu Acara</p>
                            <p class="text-slate-800">{{ $pesan->waktu_acara ? date('H:i', strtotime($pesan->waktu_acara)) : '-' }} WIB</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wider font-bold mb-1">Lokasi Acara</p>
                        <p class="text-slate-800">{{ $pesan->lokasi_acara }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wider font-bold mb-1">Perkiraan Jumlah Peserta</p>
                        <p class="text-slate-800">{{ number_format($pesan->jumlah_peserta, 0, ',', '.') }} orang</p>
                    </div>
                </div>
            </div>

            {{-- Deskripsi Acara --}}
            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-100/30">
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider">Deskripsi Acara</h3>
                </div>
                <div class="px-6 py-5">
                    <div class="text-slate-300 text-sm leading-relaxed whitespace-pre-wrap bg-slate-100/50 rounded-xl p-4 border border-slate-200">{{ $pesan->deskripsi_acara }}</div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div>
            {{-- Status Update --}}
            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden sticky top-6 mb-6">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-100/30">
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider">Tindakan</h3>
                </div>
                <div class="px-6 py-5 space-y-3">
                    <form method="POST" action="{{ route('admin.pengajuan-acara.status', $pesan) }}" class="space-y-2">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" id="status-input" value="{{ $pesan->status }}">
                        
                        <button type="button" onclick="setStatusAndSubmit('menunggu', 'Tunda pengajuan ini?')"
                            class="w-full px-4 py-2.5 rounded-lg border {{ $pesan->status === 'menunggu' ? 'border-amber-500 bg-amber-600/20 text-amber-400' : 'border-slate-200 text-slate-400 hover:bg-slate-50' }} transition-all text-sm font-semibold text-center">
                            <i data-lucide="clock" class="w-4 h-4 inline-block mr-2"></i>
                            Menunggu Review
                        </button>
                        <button type="button" onclick="setStatusAndSubmit('disetujui', 'Setujui pengajuan ini?')"
                            class="w-full px-4 py-2.5 rounded-lg border {{ $pesan->status === 'disetujui' ? 'border-emerald-500 bg-emerald-600/20 text-emerald-400' : 'border-slate-200 text-slate-400 hover:bg-slate-50' }} transition-all text-sm font-semibold text-center">
                            <i data-lucide="check-circle" class="w-4 h-4 inline-block mr-2"></i>
                            Setujui
                        </button>
                        <button type="button" onclick="setStatusAndSubmit('ditolak', 'Tolak pengajuan ini?')"
                            class="w-full px-4 py-2.5 rounded-lg border {{ $pesan->status === 'ditolak' ? 'border-red-500 bg-red-600/20 text-red-400' : 'border-slate-200 text-slate-400 hover:bg-slate-50' }} transition-all text-sm font-semibold text-center">
                            <i data-lucide="x-circle" class="w-4 h-4 inline-block mr-2"></i>
                            Tolak
                        </button>
                    </form>
                </div>
            </div>

            {{-- Publikasi Acara --}}
            @if($pesan->status === 'disetujui')
            <div class="bg-emerald-900/30 border border-emerald-700/40 rounded-2xl overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-emerald-700/40 bg-emerald-900/50">
                    <h3 class="text-sm font-bold text-emerald-300 uppercase tracking-wider">Publikasi</h3>
                </div>
                <div class="px-6 py-5">
                    @if($pesan->dipublikasikan)
                    <div class="bg-emerald-600/20 border border-emerald-500/40 rounded-lg px-4 py-3 mb-3">
                        <p class="text-sm text-emerald-300 font-semibold flex items-center gap-2">
                            <i data-lucide="check-circle" class="w-4 h-4"></i>
                            Acara sudah dipublikasikan
                        </p>
                    </div>
                    @else
                    <form method="POST" action="{{ route('admin.pengajuan-acara.publikasi', $pesan) }}" onsubmit="return confirm('Publikasikan acara ini ke halaman agenda acara desa?')">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold transition-all flex items-center justify-center gap-2">
                            <i data-lucide="upload" class="w-4 h-4"></i>
                            Publikasikan Acara
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @endif

            {{-- Informasi Tambahan --}}
            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-100/30">
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider">Informasi</h3>
                </div>
                <div class="px-6 py-5 space-y-3 text-sm">
                    <div>
                        <p class="text-xs text-slate-500 font-bold mb-1">Dikirim Pada</p>
                        <p class="text-slate-700">{{ $pesan->created_at->translatedFormat('l, d F Y H:i') }} WIB</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-bold mb-1">Status Dibaca</p>
                        <p class="text-slate-700">
                            @if($pesan->is_read)
                                <span class="badge-read">Sudah Dibaca</span>
                            @else
                                <span class="badge-unread">Belum Dibaca</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Actions Bar --}}
    @php
        $hasEmail = !empty($pesan->email) && $pesan->email !== '-' && filter_var($pesan->email, FILTER_VALIDATE_EMAIL);
        $hasWa = !empty($pesan->no_whatsapp) && $pesan->no_whatsapp !== '-';
    @endphp
    <div class="flex items-center gap-3 mt-6 pt-6 border-t border-slate-200">
        <a href="{{ route('admin.pengajuan-acara.index') }}"
           class="flex items-center gap-2 px-4 py-2 rounded-xl border border-slate-200 text-slate-600 hover:text-slate-900 text-sm font-semibold transition-all">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali
        </a>

        @if($hasEmail)
        <a href="mailto:{{ $pesan->email }}?subject=Re: {{ urlencode($pesan->nama_acara ?? $pesan->subject) }}"
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

        <form method="POST" action="{{ route('admin.pengajuan-acara.destroy', $pesan) }}"
              onsubmit="return confirm('Hapus pengajuan acara ini?')" class="ml-auto">
            @csrf @method('DELETE')
            <button type="submit" class="btn-danger">
                <i data-lucide="trash-2" class="w-4 h-4"></i>
                Hapus
            </button>
        </form>
    </div>
</div>


<style>
.badge-yellow { @apply inline-flex items-center px-2.5 py-1 rounded-lg bg-amber-600/20 text-amber-400 font-semibold text-xs; }
.badge-green { @apply inline-flex items-center px-2.5 py-1 rounded-lg bg-emerald-600/20 text-emerald-400 font-semibold text-xs; }
.badge-red { @apply inline-flex items-center px-2.5 py-1 rounded-lg bg-red-600/20 text-red-400 font-semibold text-xs; }
</style>

@push('scripts')
<script>
function setStatusAndSubmit(status, message) {
    if (confirm(message)) {
        document.getElementById('status-input').value = status;
        document.querySelector('form[action="{{ route("admin.pengajuan-acara.status", $pesan) }}"]').submit();
    }
}
</script>
@endpush

@endsection


