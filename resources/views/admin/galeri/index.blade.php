@extends('admin.layouts.admin')

@section('title', 'Galeri Desa')
@section('page_title', 'Kelola Galeri Desa')
@section('page_subtitle', 'Tambah, edit, dan hapus foto kegiatan, acara, serta budaya desa')

@section('content')
<div class="space-y-6">

    <div class="flex items-center justify-between">
        <p class="text-xs text-slate-500">Total {{ $galeri->total() }} foto galeri terdaftar</p>
        <a href="{{ route('admin.galeri.create') }}" class="btn-primary">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Tambah Foto Galeri
        </a>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs font-bold uppercase tracking-wider text-slate-500 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4">Foto</th>
                        <th class="px-6 py-4">Judul</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Tgl Publikasi</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Urutan</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($galeri as $item)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <img src="{{ asset($item->foto) }}" alt="{{ $item->judul }}" class="w-16 h-12 object-cover rounded-xl border border-slate-200">
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-semibold text-slate-800 block">{{ $item->judul }}</span>
                            @if($item->deskripsi)
                            <span class="text-xs text-slate-400 truncate max-w-xs block mt-0.5">{{ Str::limit($item->deskripsi, 60) }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-forest-50 text-forest-700 border border-forest-200">
                                {{ $item->kategori_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-500">
                            {{ $item->tanggal_publikasi ? $item->tanggal_publikasi->translatedFormat('d M Y') : '-' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($item->is_active)
                            <span class="badge-read">Tampil</span>
                            @else
                            <span class="badge-unread">Disembunyikan</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center font-mono text-xs text-slate-400">
                            {{ $item->urutan }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <a href="{{ route('admin.galeri.edit', $item->galeri_id) }}"
                                   class="w-8 h-8 rounded-lg text-slate-400 hover:bg-forest-50 hover:text-forest-700 flex items-center justify-center transition-all"
                                   title="Edit">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('admin.galeri.destroy', $item->galeri_id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus foto ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg text-slate-400 hover:bg-red-50 hover:text-red-500 flex items-center justify-center transition-all" title="Hapus">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center text-slate-400">
                            <i data-lucide="image" class="w-10 h-10 mx-auto mb-3 text-slate-700"></i>
                            <p class="font-medium text-slate-500">Belum ada foto galeri</p>
                            <p class="text-sm mt-1">Klik tombol "Tambah Foto Galeri" untuk menambahkan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Pagination --}}
        @if($galeri->hasPages())
        <div class="px-5 py-4 border-t border-slate-100">
            {{ $galeri->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

