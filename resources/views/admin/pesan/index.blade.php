@extends('admin.layouts.admin')

@section('title', 'Pesan Masuk')
@section('page_title', 'Pesan Masuk')
@section('page_subtitle', 'Aspirasi, pertanyaan, pengaduan, dan kerja sama dari pengunjung website')

@section('content')

<div class="mb-6">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-3">
            <span class="text-sm text-slate-400">{{ $stats['total'] }} total pesan</span>
            @php $unread = \App\Models\Pesan::where('is_read', false)->where('jenis_pesan', '!=', 'pengajuan_acara')->count(); @endphp
            @if($unread > 0)
            <span class="badge-unread">{{ $unread }} belum dibaca</span>
            @endif
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="flex gap-2 overflow-x-auto border-b border-slate-800 pb-0" role="tablist">
        <button onclick="switchTab('semua')" role="tab" data-tab="semua"
            class="tab-button active px-4 py-3 text-sm font-semibold text-slate-400 hover:text-white transition-colors border-b-2 border-transparent hover:border-emerald-500 -mb-px">
            <i data-lucide="inbox" class="w-4 h-4 inline-block mr-2"></i>
            Semua <span class="ml-2 text-xs bg-slate-800 px-2 py-0.5 rounded-full">{{ $stats['total'] }}</span>
        </button>
        <button onclick="switchTab('pertanyaan_umum')" role="tab" data-tab="pertanyaan_umum"
            class="tab-button px-4 py-3 text-sm font-semibold text-slate-400 hover:text-white transition-colors border-b-2 border-transparent hover:border-emerald-500 -mb-px">
            <i data-lucide="help-circle" class="w-4 h-4 inline-block mr-2"></i>
            Pertanyaan Umum <span class="ml-2 text-xs bg-slate-800 px-2 py-0.5 rounded-full">{{ $stats['pertanyaan_umum'] }}</span>
        </button>
        <button onclick="switchTab('pengaduan')" role="tab" data-tab="pengaduan"
            class="tab-button px-4 py-3 text-sm font-semibold text-slate-400 hover:text-white transition-colors border-b-2 border-transparent hover:border-red-500 -mb-px">
            <i data-lucide="alert-triangle" class="w-4 h-4 inline-block mr-2"></i>
            Pengaduan <span class="ml-2 text-xs bg-slate-800 px-2 py-0.5 rounded-full">{{ $stats['pengaduan'] }}</span>
        </button>
        <button onclick="switchTab('kerja_sama')" role="tab" data-tab="kerja_sama"
            class="tab-button px-4 py-3 text-sm font-semibold text-slate-400 hover:text-white transition-colors border-b-2 border-transparent hover:border-sky-500 -mb-px">
            <i data-lucide="handshake" class="w-4 h-4 inline-block mr-2"></i>
            Kerja Sama <span class="ml-2 text-xs bg-slate-800 px-2 py-0.5 rounded-full">{{ $stats['kerja_sama'] }}</span>
        </button>
        <a href="{{ route('admin.pengajuan-acara.index') }}"
            class="px-4 py-3 text-sm font-semibold text-slate-400 hover:text-white transition-colors border-b-2 border-transparent hover:border-amber-500 -mb-px inline-flex items-center gap-2">
            <i data-lucide="calendar" class="w-4 h-4"></i>
            Pengajuan Acara
        </a>
    </div>
</div>

<!-- Tab Content -->
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
                    <th class="text-left px-4 py-3.5">Jenis</th>
                    <th class="text-left px-4 py-3.5">Subjek</th>
                    <th class="text-left px-4 py-3.5 hidden md:table-cell">Waktu</th>
                    <th class="text-left px-4 py-3.5">Status</th>
                    <th class="text-right px-5 py-3.5">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                @foreach($pesan as $p)
                <tr class="hover:bg-slate-800/40 transition-colors {{ !$p->is_read ? 'bg-amber-600/5' : '' }} pesan-row" data-jenis="{{ $p->jenis_pesan }}">
                    <td class="px-5 py-4">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-violet-600 to-violet-400 flex items-center justify-center text-white font-bold text-xs">
                            {{ strtoupper(substr($p->name, 0, 1)) }}
                        </div>
                    </td>
                    <td class="px-4 py-4">
                        <p class="font-semibold text-slate-200 {{ !$p->is_read ? 'text-white' : '' }}">{{ $p->name }}</p>
                        <p class="text-xs text-slate-500">{{ $p->email ?? $p->no_whatsapp ?? '-' }}</p>
                    </td>
                    <td class="px-4 py-4">
                        <span class="badge-{{ $p->jenis_pesan == 'pertanyaan_umum' ? 'blue' : ($p->jenis_pesan == 'pengaduan' ? 'red' : ($p->jenis_pesan == 'kerja_sama' ? 'sky' : 'amber')) }} text-xs">
                            @switch($p->jenis_pesan)
                                @case('pertanyaan_umum')
                                    Pertanyaan
                                    @break
                                @case('pengaduan')
                                    Pengaduan
                                    @break
                                @case('kerja_sama')
                                    Kerja Sama
                                    @break
                                @default
                                    {{ $p->jenis_pesan }}
                            @endswitch
                        </span>
                    </td>
                    <td class="px-4 py-4">
                        <p class="text-slate-300 {{ !$p->is_read ? 'font-semibold text-white' : '' }}">{{ $p->subject }}</p>
                        <p class="text-xs text-slate-500 truncate max-w-xs">{{ Str::limit($p->message, 40) }}</p>
                    </td>
                    <td class="px-4 py-4 text-slate-500 text-xs hidden md:table-cell">
                        <p>{{ $p->created_at->format('d M Y') }}</p>
                        <p>{{ $p->created_at->format('H:i') }} WIB</p>
                    </td>
                    <td class="px-4 py-4">
                        @if($p->is_read)
                        <span class="badge-read">Dibaca</span>
                        @else
                        <span class="badge-unread">Baru</span>
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

<style>
.badge-blue { @apply inline-flex items-center px-2.5 py-1 rounded-lg bg-sky-600/20 text-sky-400 font-semibold; }
.badge-red { @apply inline-flex items-center px-2.5 py-1 rounded-lg bg-red-600/20 text-red-400 font-semibold; }
.badge-sky { @apply inline-flex items-center px-2.5 py-1 rounded-lg bg-cyan-600/20 text-cyan-400 font-semibold; }
.badge-amber { @apply inline-flex items-center px-2.5 py-1 rounded-lg bg-amber-600/20 text-amber-400 font-semibold; }
</style>

@push('scripts')
<script>
function switchTab(tab) {
    const rows = document.querySelectorAll('.pesan-row');
    
    rows.forEach(row => {
        if (tab === 'semua' || row.dataset.jenis === tab) {
            row.style.display = 'table-row';
        } else {
            row.style.display = 'none';
        }
    });

    // Update active tab button
    document.querySelectorAll('.tab-button').forEach(btn => {
        if (btn.dataset.tab === tab) {
            btn.classList.add('active');
            btn.classList.add('border-emerald-500', 'text-white');
            btn.classList.remove('border-transparent', 'text-slate-400');
        } else {
            btn.classList.remove('active');
            btn.classList.remove('border-emerald-500', 'text-white');
            btn.classList.add('border-transparent', 'text-slate-400');
        }
    });
}
</script>
@endpush

@endsection
