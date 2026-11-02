@extends('admin.layouts.admin')

@section('title', 'Kelola Pengaduan Masyarakat')
@section('page_title', 'Kelola Pengaduan Masyarakat')
@section('page_subtitle', 'Kelola, tindaklanjuti, dan berikan tanggapan atas aspirasi atau pengaduan warga desa')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-900 font-display">Pengaduan Masyarakat</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kelola, tindaklanjuti, dan berikan tanggapan atas aspirasi atau pengaduan warga desa (SRS-F-011).</p>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
        <a href="{{ route('admin.pengaduan.index', ['status' => 'semua']) }}"
           class="p-4 rounded-2xl border transition-all {{ $status === 'semua' ? 'bg-forest-800 text-white border-forest-800 shadow-sm' : 'bg-white border-slate-200 hover:border-slate-300' }}">
            <span class="text-[10px] font-bold uppercase tracking-wider block opacity-80">Total Pengaduan</span>
            <span class="text-xl font-extrabold mt-1 block font-display">{{ $stats['total'] }}</span>
        </a>
        <a href="{{ route('admin.pengaduan.index', ['status' => 'diajukan']) }}"
           class="p-4 rounded-2xl border transition-all {{ $status === 'diajukan' ? 'bg-amber-500 text-white border-amber-500 shadow-sm' : 'bg-white border-slate-200 hover:border-amber-300' }}">
            <span class="text-[10px] font-bold uppercase tracking-wider block {{ $status === 'diajukan' ? 'text-white' : 'text-amber-600' }}">Diajukan / Baru</span>
            <span class="text-xl font-extrabold mt-1 block font-display {{ $status === 'diajukan' ? 'text-white' : 'text-amber-600' }}">{{ $stats['diajukan'] }}</span>
        </a>
        <a href="{{ route('admin.pengaduan.index', ['status' => 'diproses']) }}"
           class="p-4 rounded-2xl border transition-all {{ $status === 'diproses' ? 'bg-indigo-600 text-white border-indigo-600 shadow-sm' : 'bg-white border-slate-200 hover:border-indigo-300' }}">
            <span class="text-[10px] font-bold uppercase tracking-wider block {{ $status === 'diproses' ? 'text-white' : 'text-indigo-600' }}">Diproses</span>
            <span class="text-xl font-extrabold mt-1 block font-display {{ $status === 'diproses' ? 'text-white' : 'text-indigo-600' }}">{{ $stats['diproses'] }}</span>
        </a>
        <a href="{{ route('admin.pengaduan.index', ['status' => 'selesai']) }}"
           class="p-4 rounded-2xl border transition-all {{ $status === 'selesai' ? 'bg-emerald-600 text-white border-emerald-600 shadow-sm' : 'bg-white border-slate-200 hover:border-emerald-300' }}">
            <span class="text-[10px] font-bold uppercase tracking-wider block {{ $status === 'selesai' ? 'text-white' : 'text-emerald-600' }}">Selesai</span>
            <span class="text-xl font-extrabold mt-1 block font-display {{ $status === 'selesai' ? 'text-white' : 'text-emerald-600' }}">{{ $stats['selesai'] }}</span>
        </a>
        <a href="{{ route('admin.pengaduan.index', ['status' => 'ditolak']) }}"
           class="p-4 rounded-2xl border transition-all {{ $status === 'ditolak' ? 'bg-rose-600 text-white border-rose-600 shadow-sm' : 'bg-white border-slate-200 hover:border-rose-300' }}">
            <span class="text-[10px] font-bold uppercase tracking-wider block {{ $status === 'ditolak' ? 'text-white' : 'text-rose-600' }}">Ditolak</span>
            <span class="text-xl font-extrabold mt-1 block font-display {{ $status === 'ditolak' ? 'text-white' : 'text-rose-600' }}">{{ $stats['ditolak'] }}</span>
        </a>
    </div>

    {{-- Filter Bar & Table --}}
    <div class="page-card">
        <div class="p-4 border-b border-slate-100 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3 bg-slate-50/50">
            <form action="{{ route('admin.pengaduan.index') }}" method="GET" class="flex flex-wrap items-center gap-2 flex-1">
                <input type="hidden" name="status" value="{{ $status }}">
                
                {{-- Search --}}
                <div class="relative flex-1 max-w-sm">
                    <input type="text" name="q" value="{{ $search }}" placeholder="Cari judul, pelapor, nomor..."
                        class="w-full pl-8 pr-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-700 placeholder:text-slate-400 focus:outline-none focus:border-forest-500">
                    <i data-lucide="search" class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2.5"></i>
                </div>

                <button type="submit" class="btn-secondary text-xs py-2 px-3">Cari</button>
                @if($search || $status !== 'semua')
                    <a href="{{ route('admin.pengaduan.index') }}" class="text-xs text-slate-500 hover:text-slate-700 px-2">Reset</a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th class="table-th">Nomor & Tanggal</th>
                        <th class="table-th">Pelapor</th>
                        <th class="table-th">Judul & Uraian</th>
                        <th class="table-th">Bukti Foto</th>
                        <th class="table-th">Status</th>
                        <th class="table-th text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pengaduan as $item)
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="table-td whitespace-nowrap">
                            <span class="font-mono text-xs font-bold text-slate-800 block">{{ $item->nomor_pengaduan }}</span>
                            <span class="text-[11px] text-slate-400">{{ $item->created_at ? $item->created_at->translatedFormat('d M Y, H:i') : '-' }}</span>
                        </td>
                        <td class="table-td whitespace-nowrap">
                            <span class="font-bold text-xs text-slate-800 block">{{ $item->nama }}</span>
                            <span class="text-[11px] text-slate-500">{{ $item->no_whatsapp ?? '-' }}</span>
                        </td>
                        <td class="table-td">
                            <span class="font-bold text-xs text-slate-800 block line-clamp-1">{{ $item->judul }}</span>
                            <p class="text-[11px] text-slate-500 line-clamp-1 max-w-xs">{{ $item->isi_pengaduan }}</p>
                        </td>
                        <td class="table-td whitespace-nowrap">
                            @if($item->foto_bukti)
                            <a href="{{ asset('storage/' . $item->foto_bukti) }}" target="_blank"
                                class="inline-flex items-center gap-1 text-[11px] font-bold text-rose-700 bg-rose-50 px-2 py-0.5 rounded border border-rose-100 hover:bg-rose-100">
                                <i data-lucide="image" class="w-3 h-3"></i> Ada Bukti
                            </a>
                            @else
                            <span class="text-[11px] text-slate-400">Tanpa Bukti</span>
                            @endif
                        </td>
                        <td class="table-td whitespace-nowrap">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold border {{ $item->status_badge_class }}">
                                {{ $item->status_label }}
                            </span>
                        </td>
                        <td class="table-td text-right whitespace-nowrap">
                            <div class="inline-flex items-center gap-1.5">
                                <a href="{{ route('admin.pengaduan.show', $item) }}"
                                    class="p-1.5 rounded-lg text-slate-600 hover:text-forest-700 hover:bg-forest-50 transition-colors" title="Lihat & Tindaklanjuti">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('admin.pengaduan.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus data pengaduan ini?');" class="inline">
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
                            Tidak ada pengaduan masyarakat yang sesuai kriteria.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $pengaduan->links() }}
        </div>
    </div>

</div>
@endsection
