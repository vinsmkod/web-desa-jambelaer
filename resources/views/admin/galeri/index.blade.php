@extends('admin.layouts.admin')

@section('title', 'Galeri Desa')
@section('page_title', 'Kelola Galeri Desa')
@section('page_subtitle', 'Tambah, edit, dan hapus foto kegiatan, budaya, UMKM, serta pembangunan desa')

@section('content')
<div class="space-y-6">

    <div class="flex items-center justify-between">
        <p class="text-xs text-slate-400">Total {{ $galeri->count() }} foto galeri terdaftar</p>
        <a href="{{ route('admin.galeri.create') }}" class="btn-primary">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Tambah Foto Galeri
        </a>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="bg-slate-800/80 text-xs font-semibold uppercase tracking-wider text-slate-400 border-b border-slate-800">
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
                <tbody class="divide-y divide-slate-800">
                    @forelse($galeri as $item)
                    <tr class="hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <img src="{{ asset($item->foto) }}" alt="{{ $item->judul }}" class="w-16 h-12 object-cover rounded-lg border border-slate-700">
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-semibold text-white block">{{ $item->judul }}</span>
                            @if($item->deskripsi)
                            <span class="text-xs text-slate-400 font-light truncate max-w-xs block mt-0.5">{{ Str::limit($item->deskripsi, 60) }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-600/20 text-emerald-400 border border-emerald-600/30">
                                {{ $item->kategori_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-400">
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
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.galeri.edit', $item->id) }}"
                                   class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-slate-700 text-amber-400 flex items-center justify-center transition-all"
                                   title="Edit">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('admin.galeri.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus foto ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-red-600/20 hover:bg-red-600 text-red-400 hover:text-white flex items-center justify-center transition-all" title="Hapus">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-500 font-light">
                            Belum ada foto galeri. Klik tombol "Tambah Foto Galeri" untuk menambahkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
