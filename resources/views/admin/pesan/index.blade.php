@extends('admin.layouts.admin')

@section('title', 'Pesan Masuk')
@section('page_title', 'Pesan Masuk')
@section('page_subtitle', 'Aspirasi, pertanyaan, pengaduan, dan kerja sama dari pengunjung website')

@section('content')

<div class="mb-6">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-3">
            <span class="text-sm text-slate-500">{{ $stats['total'] }} total pesan</span>
            @php $unread = \App\Models\Pesan::where('is_read', false)->where('jenis_pesan', '!=', 'pengajuan_acara')->count(); @endphp
            @if($unread > 0)
            <span class="badge-unread">{{ $unread }} belum dibaca</span>
            @endif
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="flex gap-1 overflow-x-auto border-b border-slate-200 pb-0" role="tablist">
        <button onclick="switchTab('semua')" role="tab" data-tab="semua"
            class="tab-button active px-4 py-3 text-sm font-semibold text-slate-500 hover:text-forest-700 transition-colors border-b-2 border-forest-600 -mb-px">
            <i data-lucide="inbox" class="w-4 h-4 inline-block mr-1.5"></i>
            Semua <span class="ml-1.5 text-xs bg-slate-100 text-slate-500 px-2 py-0.5 rounded-full">{{ $stats['total'] }}</span>
        </button>
        <button onclick="switchTab('pertanyaan_umum')" role="tab" data-tab="pertanyaan_umum"
            class="tab-button px-4 py-3 text-sm font-semibold text-slate-400 hover:text-forest-700 transition-colors border-b-2 border-transparent hover:border-forest-600 -mb-px">
            <i data-lucide="help-circle" class="w-4 h-4 inline-block mr-1.5"></i>
            Pertanyaan <span class="ml-1.5 text-xs bg-slate-100 text-slate-500 px-2 py-0.5 rounded-full">{{ $stats['pertanyaan_umum'] }}</span>
        </button>
        <button onclick="switchTab('pengaduan')" role="tab" data-tab="pengaduan"
            class="tab-button px-4 py-3 text-sm font-semibold text-slate-400 hover:text-red-600 transition-colors border-b-2 border-transparent hover:border-red-500 -mb-px">
            <i data-lucide="alert-triangle" class="w-4 h-4 inline-block mr-1.5"></i>
            Pengaduan <span class="ml-1.5 text-xs bg-slate-100 text-slate-500 px-2 py-0.5 rounded-full">{{ $stats['pengaduan'] }}</span>
        </button>
        <button onclick="switchTab('kerja_sama')" role="tab" data-tab="kerja_sama"
            class="tab-button px-4 py-3 text-sm font-semibold text-slate-400 hover:text-sky-600 transition-colors border-b-2 border-transparent hover:border-sky-500 -mb-px">
            <i data-lucide="handshake" class="w-4 h-4 inline-block mr-1.5"></i>
            Kerja Sama <span class="ml-1.5 text-xs bg-slate-100 text-slate-500 px-2 py-0.5 rounded-full">{{ $stats['kerja_sama'] }}</span>
        </button>
        <a href="{{ route('admin.pengajuan-acara.index') }}"
            class="px-4 py-3 text-sm font-semibold text-slate-400 hover:text-amber-600 transition-colors border-b-2 border-transparent hover:border-amber-500 -mb-px inline-flex items-center gap-1.5">
            <i data-lucide="calendar" class="w-4 h-4"></i>
            Pengajuan Acara
        </a>
    </div>
</div>

<!-- Tab Content -->
<div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
    @if($pesan->isEmpty())
    <div class="flex flex-col items-center justify-center py-20 text-slate-400">
        <i data-lucide="inbox" class="w-12 h-12 mb-3"></i>
        <p class="font-semibold text-slate-600">Belum ada pesan masuk</p>
        <p class="text-sm mt-1">Pesan dari form kontak akan muncul di sini</p>
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50 text-xs font-bold text-slate-500 uppercase tracking-wider">
                    <th class="text-left px-5 py-3.5 w-10"></th>
                    <th class="text-left px-4 py-3.5">Pengirim</th>
                    <th class="text-left px-4 py-3.5">Jenis</th>
                    <th class="text-left px-4 py-3.5">Subjek</th>
                    <th class="text-left px-4 py-3.5 hidden md:table-cell">Waktu</th>
                    <th class="text-left px-4 py-3.5">Status</th>
                    <th class="text-right px-5 py-3.5">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($pesan as $p)
                <tr class="hover:bg-slate-50 transition-colors {{ !$p->is_read ? 'bg-amber-50/50' : '' }} pesan-row" data-jenis="{{ $p->jenis_pesan }}">
                    <td class="px-5 py-4">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-violet-600 to-violet-400 flex items-center justify-center text-white font-bold text-xs">
                            {{ strtoupper(substr($p->name, 0, 1)) }}
                        </div>
                    </td>
                    <td class="px-4 py-4">
                        <p class="font-semibold text-slate-700 {{ !$p->is_read ? 'text-slate-900' : '' }}">{{ $p->name }}</p>
                        <p class="text-xs text-slate-400">{{ $p->email ?? $p->no_whatsapp ?? '-' }}</p>
                    </td>
                    <td class="px-4 py-4">
                        @php
                            $jenisClass = match($p->jenis_pesan) {
                                'pertanyaan_umum' => 'bg-sky-50 text-sky-700 border-sky-200',
                                'pengaduan'       => 'bg-red-50 text-red-600 border-red-200',
                                'kerja_sama'      => 'bg-cyan-50 text-cyan-700 border-cyan-200',
                                default           => 'bg-slate-50 text-slate-600 border-slate-200',
                            };
                            $jenisLabel = match($p->jenis_pesan) {
                                'pertanyaan_umum' => 'Pertanyaan',
                                'pengaduan'       => 'Pengaduan',
                                'kerja_sama'      => 'Kerja Sama',
                                default           => $p->jenis_pesan,
                            };
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold border {{ $jenisClass }}">
                            {{ $jenisLabel }}
                        </span>
                    </td>
                    <td class="px-4 py-4">
                        <p class="text-slate-700 {{ !$p->is_read ? 'font-semibold' : '' }}">{{ $p->subject }}</p>
                        <p class="text-xs text-slate-400 truncate max-w-xs">{{ Str::limit($p->message, 40) }}</p>
                    </td>
                    <td class="px-4 py-4 text-slate-400 text-xs hidden md:table-cell">
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
                        <div class="flex items-center justify-end gap-1.5">
                            <a href="{{ route('admin.pesan.show', $p) }}"
                               class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:bg-forest-50 hover:text-forest-700 transition-all" title="Lihat">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </a>
                            @if(!$p->is_read)
                            <form method="POST" action="{{ route('admin.pesan.read', $p) }}">
                                @csrf @method('PATCH')
                                <button type="submit" title="Tandai Sudah Dibaca"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:bg-forest-50 hover:text-forest-700 transition-all">
                                    <i data-lucide="check" class="w-4 h-4"></i>
                                </button>
                            </form>
                            @endif
                            <form method="POST" action="{{ route('admin.pesan.destroy', $p) }}"
                                  onsubmit="return confirm('Hapus pesan dari {{ $p->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit"
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

@push('scripts')
<script>
function switchTab(tab) {
    const rows = document.querySelectorAll('.pesan-row');
    rows.forEach(row => {
        row.style.display = (tab === 'semua' || row.dataset.jenis === tab) ? 'table-row' : 'none';
    });

    document.querySelectorAll('.tab-button').forEach(btn => {
        if (btn.dataset.tab === tab) {
            btn.classList.add('border-forest-600', 'text-forest-700');
            btn.classList.remove('border-transparent', 'text-slate-400');
        } else {
            btn.classList.remove('border-forest-600', 'text-forest-700');
            btn.classList.add('border-transparent', 'text-slate-400');
        }
    });
}
</script>
@endpush

@endsection
