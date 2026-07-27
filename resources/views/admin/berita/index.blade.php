@extends('admin.layouts.admin')

@section('title', 'Berita Desa')
@section('page_title', 'Berita Desa')
@section('page_subtitle', 'Kelola publikasi berita, pengumuman, dan informasi Desa Jambelaer')

@section('content')
<div class="space-y-6">

    <!-- Header & Action Button -->
    <div class="p-5 rounded-2xl bg-slate-900 border border-slate-800 shadow-xl flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-600 to-emerald-400 flex items-center justify-center text-white shadow-lg flex-shrink-0">
                <i data-lucide="newspaper" class="w-6 h-6"></i>
            </div>
            <div>
                <h2 class="text-base font-bold text-white">Kelola Berita & Informasi Desa</h2>
                <p class="text-xs text-slate-400 mt-0.5">Tulis, publikasikan, dan perbarui warta berita resmi Pemerintah Desa Jambelaer.</p>
            </div>
        </div>
        <a href="{{ route('admin.berita.create') }}" class="btn-primary flex-shrink-0 text-xs">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Tambah Berita Baru
        </a>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-4 shadow-xl">
        <form method="GET" action="{{ route('admin.berita.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-6 relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </div>
                <input type="text" name="q" value="{{ request('q') }}"
                    placeholder="Cari judul berita, ringkasan, atau penulis..."
                    class="form-input !pl-10 text-xs">
            </div>

            <div class="sm:col-span-4">
                <select name="kategori" class="form-input text-xs">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoriList as $key => $label)
                        <option value="{{ $key }}" {{ request('kategori') === $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="sm:col-span-2 flex items-center gap-2">
                <button type="submit" class="w-full btn-primary justify-center text-xs py-2.5">
                    Filter
                </button>
                @if(request()->hasAny(['q', 'kategori']))
                <a href="{{ route('admin.berita.index') }}" class="px-3 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white transition-all text-xs" title="Reset Filter">
                    <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table List -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl space-y-4">
        <div class="flex items-center justify-between pb-4 border-b border-slate-800">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-emerald-600/20 flex items-center justify-center text-emerald-400">
                    <i data-lucide="file-text" class="w-4 h-4"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-white">Daftar Berita</h3>
                    <p class="text-xs text-slate-500">Menampilkan {{ $beritas->total() }} berita desa</p>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-800 text-slate-400 uppercase tracking-wider">
                        <th class="py-3.5 px-4">Artikel Berita</th>
                        <th class="py-3.5 px-4">Kategori</th>
                        <th class="py-3.5 px-4">Penulis & Views</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4">Tanggal Publikasi</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse ($beritas as $item)
                    <tr class="hover:bg-slate-800/40 transition-colors">
                        <!-- Judul & Thumbnail -->
                        <td class="py-4 px-4 max-w-xs">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl overflow-hidden bg-slate-800 border border-slate-700 flex-shrink-0">
                                    <img src="{{ $item->gambar_url }}" alt="{{ $item->judul }}" class="w-full h-full object-cover">
                                </div>
                                <div class="min-w-0">
                                    <a href="{{ route('berita.detail', $item->slug) }}" target="_blank" class="font-semibold text-white hover:text-emerald-400 transition-colors text-sm line-clamp-1 flex items-center gap-1">
                                        <span>{{ $item->judul }}</span>
                                        <i data-lucide="external-link" class="w-3 h-3 text-slate-500"></i>
                                    </a>
                                    <p class="text-slate-400 text-xs line-clamp-1 mt-0.5">{{ $item->ringkasan }}</p>
                                </div>
                            </div>
                        </td>

                        <!-- Kategori -->
                        <td class="py-4 px-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-medium bg-slate-800 text-slate-300 border border-slate-700">
                                {{ $item->kategori_label }}
                            </span>
                        </td>

                        <!-- Penulis & Views -->
                        <td class="py-4 px-4 whitespace-nowrap">
                            <div class="text-slate-200 font-medium">{{ $item->penulis }}</div>
                            <div class="text-slate-500 text-[11px] flex items-center gap-1 mt-0.5">
                                <i data-lucide="eye" class="w-3 h-3"></i>
                                <span>{{ number_format($item->views) }}x dibaca</span>
                            </div>
                        </td>

                        <!-- Status -->
                        <td class="py-4 px-4 whitespace-nowrap">
                            @if($item->is_published)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                    Terbit
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-medium bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                    Draft
                                </span>
                            @endif
                        </td>

                        <!-- Tanggal -->
                        <td class="py-4 px-4 whitespace-nowrap text-slate-400">
                            {{ $item->published_at ? $item->published_at->translatedFormat('d M Y, H:i') : '-' }}
                        </td>

                        <!-- Aksi -->
                        <td class="py-4 px-4 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.berita.edit', $item->id) }}"
                                   class="p-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white transition-all"
                                   title="Edit Berita">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </a>

                                <form action="{{ route('admin.berita.destroy', $item->id) }}" method="POST"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="p-2 rounded-lg bg-red-600/10 hover:bg-red-600 text-red-400 hover:text-white transition-all"
                                            title="Hapus Berita">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-slate-500">
                            <div class="flex flex-col items-center justify-center gap-2">
                                <i data-lucide="newspaper" class="w-8 h-8 text-slate-600"></i>
                                <p class="text-sm font-medium">Belum ada data berita.</p>
                                <p class="text-xs text-slate-600">Klik tombol "Tambah Berita Baru" untuk menulis berita pertama.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($beritas->hasPages())
        <div class="pt-4 border-t border-slate-800">
            {{ $beritas->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
