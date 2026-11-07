@extends('admin.layouts.admin')

@section('title', 'Kelola Pengajuan Surat')
@section('page_title', 'Kelola Pengajuan Surat')
@section('page_subtitle', 'Kelola, verifikasi berkas, dan proses surat keterangan permohonan masyarakat')

@section('content')
<div class="space-y-6">

    {{-- Header & Stats --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-900 font-display">Pengajuan Pembuatan Surat</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kelola, verifikasi berkas, dan proses surat keterangan permohonan masyarakat (SRS-F-010).</p>
        </div>
        <div>
            <a href="{{ route('admin.jenis-surat.index') }}" class="btn-secondary text-xs">
                <i data-lucide="settings" class="w-3.5 h-3.5"></i>
                Kelola Jenis Surat ({{ \App\Models\JenisSuratModel::count() }})
            </a>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
        <a href="{{ route('admin.pengajuan-surat.index', ['status' => 'semua']) }}"
           class="p-4 rounded-2xl border transition-all {{ $status === 'semua' ? 'bg-forest-800 text-white border-forest-800 shadow-sm' : 'bg-white border-slate-200 hover:border-slate-300' }}">
            <span class="text-[10px] font-bold uppercase tracking-wider block opacity-80">Total Pengajuan</span>
            <span class="text-xl font-extrabold mt-1 block font-display">{{ $stats['total'] }}</span>
        </a>
        <a href="{{ route('admin.pengajuan-surat.index', ['status' => 'diajukan']) }}"
           class="p-4 rounded-2xl border transition-all {{ $status === 'diajukan' ? 'bg-amber-500 text-white border-amber-500 shadow-sm' : 'bg-white border-slate-200 hover:border-amber-300' }}">
            <span class="text-[10px] font-bold uppercase tracking-wider block {{ $status === 'diajukan' ? 'text-white' : 'text-amber-600' }}">Diajukan / Baru</span>
            <span class="text-xl font-extrabold mt-1 block font-display {{ $status === 'diajukan' ? 'text-white' : 'text-amber-600' }}">{{ $stats['diajukan'] }}</span>
        </a>
        <a href="{{ route('admin.pengajuan-surat.index', ['status' => 'diverifikasi']) }}"
           class="p-4 rounded-2xl border transition-all {{ $status === 'diverifikasi' ? 'bg-sky-600 text-white border-sky-600 shadow-sm' : 'bg-white border-slate-200 hover:border-sky-300' }}">
            <span class="text-[10px] font-bold uppercase tracking-wider block {{ $status === 'diverifikasi' ? 'text-white' : 'text-sky-600' }}">Diverifikasi</span>
            <span class="text-xl font-extrabold mt-1 block font-display {{ $status === 'diverifikasi' ? 'text-white' : 'text-sky-600' }}">{{ $stats['diverifikasi'] }}</span>
        </a>
        <a href="{{ route('admin.pengajuan-surat.index', ['status' => 'diproses']) }}"
           class="p-4 rounded-2xl border transition-all {{ $status === 'diproses' ? 'bg-indigo-600 text-white border-indigo-600 shadow-sm' : 'bg-white border-slate-200 hover:border-indigo-300' }}">
            <span class="text-[10px] font-bold uppercase tracking-wider block {{ $status === 'diproses' ? 'text-white' : 'text-indigo-600' }}">Diproses</span>
            <span class="text-xl font-extrabold mt-1 block font-display {{ $status === 'diproses' ? 'text-white' : 'text-indigo-600' }}">{{ $stats['diproses'] }}</span>
        </a>
        <a href="{{ route('admin.pengajuan-surat.index', ['status' => 'selesai']) }}"
           class="p-4 rounded-2xl border transition-all {{ $status === 'selesai' ? 'bg-emerald-600 text-white border-emerald-600 shadow-sm' : 'bg-white border-slate-200 hover:border-emerald-300' }}">
            <span class="text-[10px] font-bold uppercase tracking-wider block {{ $status === 'selesai' ? 'text-white' : 'text-emerald-600' }}">Selesai</span>
            <span class="text-xl font-extrabold mt-1 block font-display {{ $status === 'selesai' ? 'text-white' : 'text-emerald-600' }}">{{ $stats['selesai'] }}</span>
        </a>
        <a href="{{ route('admin.pengajuan-surat.index', ['status' => 'ditolak']) }}"
           class="p-4 rounded-2xl border transition-all {{ $status === 'ditolak' ? 'bg-rose-600 text-white border-rose-600 shadow-sm' : 'bg-white border-slate-200 hover:border-rose-300' }}">
            <span class="text-[10px] font-bold uppercase tracking-wider block {{ $status === 'ditolak' ? 'text-white' : 'text-rose-600' }}">Ditolak</span>
            <span class="text-xl font-extrabold mt-1 block font-display {{ $status === 'ditolak' ? 'text-white' : 'text-rose-600' }}">{{ $stats['ditolak'] }}</span>
        </a>
    </div>

    {{-- Filter Bar & Table --}}
    <div class="page-card">
        <div class="p-4 border-b border-slate-100 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3 bg-slate-50/50">
            <form action="{{ route('admin.pengajuan-surat.index') }}" method="GET" class="flex flex-wrap items-center gap-2 flex-1">
                <input type="hidden" name="status" value="{{ $status }}">
                
                {{-- Filter Jenis Surat --}}
                <select name="jenis_id" onchange="this.form.submit()"
                    class="px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:border-forest-500">
                    <option value="">Semua Jenis Surat</option>
                    @foreach($jenisSurats as $js)
                        <option value="{{ $js->id }}" {{ $jenisId == $js->id ? 'selected' : '' }}>{{ $js->nama_surat }}</option>
                    @endforeach
                </select>

                {{-- Search --}}
                <div class="relative flex-1 max-w-xs">
                    <input type="text" name="q" value="{{ $search }}" placeholder="Cari NIK, pemohon, nomor..."
                        class="w-full pl-8 pr-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-700 placeholder:text-slate-400 focus:outline-none focus:border-forest-500">
                    <i data-lucide="search" class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2.5"></i>
                </div>

                <button type="submit" class="btn-secondary text-xs py-2 px-3">Cari</button>
                @if($search || $jenisId || $status !== 'semua')
                    <a href="{{ route('admin.pengajuan-surat.index') }}" class="text-xs text-slate-500 hover:text-slate-700 px-2">Reset</a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th class="table-th">Nomor & Tanggal</th>
                        <th class="table-th">Pemohon & NIK</th>
                        <th class="table-th">Jenis Surat</th>
                        <th class="table-th">Keperluan</th>
                        <th class="table-th">Status</th>
                        <th class="table-th text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pengajuan as $item)
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="table-td whitespace-nowrap">
                            <span class="font-mono text-xs font-bold text-slate-800 block">{{ $item->nomor_pengajuan }}</span>
                            <span class="text-[11px] text-slate-400">{{ $item->created_at ? $item->created_at->translatedFormat('d M Y, H:i') : '-' }}</span>
                        </td>
                        <td class="table-td">
                            <span class="font-bold text-xs text-slate-800 block">{{ $item->nama_pemohon ?? ($item->user->name ?? '-') }}</span>
                            <span class="font-mono text-[11px] text-slate-500">NIK: {{ $item->nik }}</span>
                        </td>
                        <td class="table-td whitespace-nowrap">
                            <span class="inline-flex items-center gap-1 text-xs font-semibold text-violet-700 bg-violet-50 px-2 py-0.5 rounded-md border border-violet-100">
                                <i data-lucide="file-text" class="w-3 h-3"></i>
                                {{ $item->jenisSurat->nama_surat ?? 'Surat' }}
                            </span>
                        </td>
                        <td class="table-td">
                            <p class="text-xs text-slate-600 line-clamp-1 max-w-xs">{{ $item->keperluan }}</p>
                        </td>
                        <td class="table-td whitespace-nowrap">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold border {{ $item->status_badge_class }}">
                                {{ $item->status_label }}
                            </span>
                        </td>
                        <td class="table-td text-right whitespace-nowrap">
                            <div class="inline-flex items-center gap-1.5">
                                <a href="{{ route('admin.pengajuan-surat.show', $item) }}"
                                    class="p-1.5 rounded-lg text-slate-600 hover:text-forest-700 hover:bg-forest-50 transition-colors" title="Periksa Berkas & Verifikasi">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('admin.pengajuan-surat.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus pengajuan surat ini?');" class="inline">
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
                            Tidak ada pengajuan surat yang sesuai kriteria.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $pengajuan->links() }}
        </div>
    </div>

</div>
@endsection
