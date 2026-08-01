@extends('admin.layouts.admin')

@section('title', 'Wisata Desa')
@section('page_title', 'Destinasi Pariwisata Desa')
@section('page_subtitle', 'Kelola tempat pariwisata, fasilitas, lokasi, dan daya tarik Desa Jambelaer')

@section('content')

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <p class="text-slate-500 text-sm">{{ $wisataList->total() }} destinasi wisata terdaftar</p>
    <a href="{{ route('admin.wisata.create') }}" class="btn-primary">
        <i data-lucide="plus" class="w-4 h-4"></i>
        Tambah Destinasi Wisata
    </a>
</div>

<div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
    @if($wisataList->isEmpty())
    <div class="flex flex-col items-center justify-center py-20 text-slate-400">
        <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center mb-3">
            <i data-lucide="compass" class="w-7 h-7"></i>
        </div>
        <p class="font-semibold text-slate-600">Belum ada data wisata</p>
        <p class="text-sm text-slate-400 mt-1">Mulai dengan menambahkan destinasi wisata pertama Anda</p>
        <a href="{{ route('admin.wisata.create') }}" class="btn-primary mt-4">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Tambah Destinasi Wisata
        </a>
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50 text-xs font-bold text-slate-500 uppercase tracking-wider">
                    <th class="px-5 py-3.5 w-16 text-center">Urutan</th>
                    <th class="px-5 py-3.5">Destinasi</th>
                    <th class="px-4 py-3.5 hidden md:table-cell">Info Tiket & Operasional</th>
                    <th class="px-4 py-3.5 hidden sm:table-cell">Ringkasan & Lokasi</th>
                    <th class="px-5 py-3.5 text-center">Status</th>
                    <th class="px-5 py-3.5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($wisataList as $w)
                <tr class="hover:bg-slate-50 transition-colors group">
                    <td class="px-5 py-3.5 text-center text-slate-400 font-mono font-medium">
                        {{ $w->urutan }}
                    </td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <img src="{{ $w->gambar_url }}" alt="{{ $w->nama }}"
                                 class="w-12 h-12 rounded-xl object-cover bg-slate-100 flex-shrink-0 border border-slate-200">
                            <div class="min-w-0">
                                <p class="font-semibold text-slate-800 truncate">{{ $w->nama }}</p>
                                <span class="inline-block text-[10px] font-bold text-forest-700 bg-forest-50 border border-forest-200 px-2 py-0.5 rounded-full mt-1 uppercase tracking-wide">
                                    {{ $w->kategori_label }}
                                </span>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3.5 text-slate-500 hidden md:table-cell">
                        <div class="space-y-1">
                            <div class="flex items-center gap-1.5 text-xs">
                                <i data-lucide="ticket" class="w-3.5 h-3.5 text-slate-400"></i>
                                <span>{{ $w->harga_tiket }}</span>
                            </div>
                            <div class="flex items-center gap-1.5 text-xs">
                                <i data-lucide="clock" class="w-3.5 h-3.5 text-slate-400"></i>
                                <span>{{ $w->jam_operasional }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3.5 text-slate-500 hidden sm:table-cell max-w-xs">
                        <p class="truncate text-slate-700 font-medium text-xs">{{ $w->ringkasan }}</p>
                        <div class="flex items-center gap-1 text-[11px] text-slate-400 mt-1 truncate">
                            <i data-lucide="map-pin" class="w-3 h-3 flex-shrink-0"></i>
                            <span>{{ $w->alamat }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-3.5 text-center">
                        @if($w->is_active)
                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-full uppercase tracking-wide">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            Aktif
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-slate-500 bg-slate-50 border border-slate-200 px-2 py-0.5 rounded-full uppercase tracking-wide">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                            Nonaktif
                        </span>
                        @endif
                    </td>
                    <td class="px-5 py-3.5 text-right">
                        <div class="flex items-center justify-end gap-1.5">
                            <a href="{{ route('admin.wisata.edit', $w) }}"
                               class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:bg-forest-50 hover:text-forest-700 transition-all"
                               title="Edit Wisata">
                                <i data-lucide="pencil" class="w-4 h-4"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.wisata.destroy', $w) }}"
                                  onsubmit="return confirm('Hapus destinasi wisata {{ $w->nama }}?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:bg-red-50 hover:text-red-500 transition-all"
                                    title="Hapus Wisata">
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
    {{-- Pagination --}}
    @if($wisataList->hasPages())
    <div class="px-5 py-4 border-t border-slate-100">
        {{ $wisataList->links() }}
    </div>
    @endif
    @endif
</div>

@endsection
