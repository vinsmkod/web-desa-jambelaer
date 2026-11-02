@extends('admin.layouts.admin')

@section('title', 'Kelola Pertanyaan Umum')
@section('page_title', 'Kelola Pertanyaan Umum')
@section('page_subtitle', 'Kelola dan berikan jawaban resmi atas pertanyaan informasi dari warga desa')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-900 font-display">Pertanyaan Umum Masyarakat</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kelola dan berikan jawaban resmi atas pertanyaan informasi dari warga desa (SRS-F-012).</p>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        <a href="{{ route('admin.pertanyaan-umum.index', ['status' => 'semua']) }}"
           class="p-4 rounded-2xl border transition-all {{ $status === 'semua' ? 'bg-forest-800 text-white border-forest-800 shadow-sm' : 'bg-white border-slate-200 hover:border-slate-300' }}">
            <span class="text-[10px] font-bold uppercase tracking-wider block opacity-80">Total Pertanyaan</span>
            <span class="text-xl font-extrabold mt-1 block font-display">{{ $stats['total'] }}</span>
        </a>
        <a href="{{ route('admin.pertanyaan-umum.index', ['status' => 'diajukan']) }}"
           class="p-4 rounded-2xl border transition-all {{ $status === 'diajukan' ? 'bg-amber-500 text-white border-amber-500 shadow-sm' : 'bg-white border-slate-200 hover:border-amber-300' }}">
            <span class="text-[10px] font-bold uppercase tracking-wider block {{ $status === 'diajukan' ? 'text-white' : 'text-amber-600' }}">Belum Dijawab</span>
            <span class="text-xl font-extrabold mt-1 block font-display {{ $status === 'diajukan' ? 'text-white' : 'text-amber-600' }}">{{ $stats['diajukan'] }}</span>
        </a>
        <a href="{{ route('admin.pertanyaan-umum.index', ['status' => 'dijawab']) }}"
           class="p-4 rounded-2xl border transition-all {{ $status === 'dijawab' ? 'bg-sky-600 text-white border-sky-600 shadow-sm' : 'bg-white border-slate-200 hover:border-sky-300' }}">
            <span class="text-[10px] font-bold uppercase tracking-wider block {{ $status === 'dijawab' ? 'text-white' : 'text-sky-600' }}">Dijawab</span>
            <span class="text-xl font-extrabold mt-1 block font-display {{ $status === 'dijawab' ? 'text-white' : 'text-sky-600' }}">{{ $stats['dijawab'] }}</span>
        </a>
        <a href="{{ route('admin.pertanyaan-umum.index', ['status' => 'selesai']) }}"
           class="p-4 rounded-2xl border transition-all {{ $status === 'selesai' ? 'bg-emerald-600 text-white border-emerald-600 shadow-sm' : 'bg-white border-slate-200 hover:border-emerald-300' }}">
            <span class="text-[10px] font-bold uppercase tracking-wider block {{ $status === 'selesai' ? 'text-white' : 'text-emerald-600' }}">Selesai</span>
            <span class="text-xl font-extrabold mt-1 block font-display {{ $status === 'selesai' ? 'text-white' : 'text-emerald-600' }}">{{ $stats['selesai'] }}</span>
        </a>
    </div>

    {{-- Filter Bar & Table --}}
    <div class="page-card">
        <div class="p-4 border-b border-slate-100 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3 bg-slate-50/50">
            <form action="{{ route('admin.pertanyaan-umum.index') }}" method="GET" class="flex flex-wrap items-center gap-2 flex-1">
                <input type="hidden" name="status" value="{{ $status }}">
                
                {{-- Search --}}
                <div class="relative flex-1 max-w-sm">
                    <input type="text" name="q" value="{{ $search }}" placeholder="Cari subjek, penanya, nomor..."
                        class="w-full pl-8 pr-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-700 placeholder:text-slate-400 focus:outline-none focus:border-forest-500">
                    <i data-lucide="search" class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2.5"></i>
                </div>

                <button type="submit" class="btn-secondary text-xs py-2 px-3">Cari</button>
                @if($search || $status !== 'semua')
                    <a href="{{ route('admin.pertanyaan-umum.index') }}" class="text-xs text-slate-500 hover:text-slate-700 px-2">Reset</a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th class="table-th">Nomor & Tanggal</th>
                        <th class="table-th">Penanya</th>
                        <th class="table-th">Subjek & Pertanyaan</th>
                        <th class="table-th">Jawaban Staf</th>
                        <th class="table-th">Status</th>
                        <th class="table-th text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pertanyaan as $item)
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="table-td whitespace-nowrap">
                            <span class="font-mono text-xs font-bold text-slate-800 block">{{ $item->nomor_pertanyaan }}</span>
                            <span class="text-[11px] text-slate-400">{{ $item->created_at ? $item->created_at->translatedFormat('d M Y, H:i') : '-' }}</span>
                        </td>
                        <td class="table-td whitespace-nowrap">
                            <span class="font-bold text-xs text-slate-800 block">{{ $item->nama }}</span>
                            <span class="text-[11px] text-slate-500">{{ $item->no_whatsapp ?? '-' }}</span>
                        </td>
                        <td class="table-td">
                            <span class="font-bold text-xs text-slate-800 block line-clamp-1">{{ $item->subjek }}</span>
                            <p class="text-[11px] text-slate-500 line-clamp-1 max-w-xs">{{ $item->pertanyaan }}</p>
                        </td>
                        <td class="table-td">
                            @if($item->jawaban_admin)
                            <p class="text-xs text-emerald-800 font-medium line-clamp-1 max-w-xs bg-emerald-50 px-2 py-0.5 rounded">{{ $item->jawaban_admin }}</p>
                            @else
                            <span class="text-[11px] text-amber-600 italic">Belum ada jawaban</span>
                            @endif
                        </td>
                        <td class="table-td whitespace-nowrap">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold border {{ $item->status_badge_class }}">
                                {{ $item->status_label }}
                            </span>
                        </td>
                        <td class="table-td text-right whitespace-nowrap">
                            <div class="inline-flex items-center gap-1.5">
                                <a href="{{ route('admin.pertanyaan-umum.show', $item) }}"
                                    class="p-1.5 rounded-lg text-slate-600 hover:text-forest-700 hover:bg-forest-50 transition-colors" title="Jawab Pertanyaan">
                                    <i data-lucide="message-square" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('admin.pertanyaan-umum.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus pertanyaan ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors" title="Hapus">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-xs text-slate-400">
                            Tidak ada pertanyaan umum yang sesuai kriteria.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $pertanyaan->links() }}
        </div>
    </div>

</div>
@endsection
