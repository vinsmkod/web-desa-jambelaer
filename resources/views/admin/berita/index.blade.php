@extends('admin.layouts.admin')

@section('title', 'Berita Desa')
@section('page_title', 'Berita Desa')
@section('page_subtitle', 'Kelola publikasi berita, pengumuman, dan informasi Desa Jambelaer')

@section('content')
<div class="space-y-6">

    <!-- Header & Action Button Banner -->
    <div class="p-5 rounded-2xl bg-forest-50/80 border border-forest-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 shadow-xs">
        <div class="flex items-center gap-4">
            <div class="w-11 h-11 rounded-2xl bg-forest-800 text-white flex items-center justify-center shadow-xs flex-shrink-0">
                <i data-lucide="newspaper" class="w-5 h-5 text-amber-300"></i>
            </div>
            <div>
                <h2 class="text-base font-bold text-slate-900">Kelola Berita & Informasi Desa</h2>
                <p class="text-xs text-slate-500 mt-0.5">Tulis, publikasikan, dan perbarui berita resmi Pemerintah Desa Jambelaer.</p>
            </div>
        </div>
        <a href="{{ route('admin.berita.create') }}" class="btn-primary flex-shrink-0 text-xs py-2.5 px-4">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Tambah Berita Baru
        </a>
    </div>


    <!-- Table List -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-4">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-forest-50 border border-forest-100 flex items-center justify-center text-forest-700">
                    <i data-lucide="file-text" class="w-4 h-4"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Daftar Berita</h3>
                    <p class="text-xs text-slate-400">Menampilkan {{ $beritas->total() }} berita desa</p>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/60 text-slate-500 font-bold uppercase tracking-wider">
                        <th class="py-3.5 px-4 rounded-l-xl">Artikel Berita</th>
                        <th class="py-3.5 px-4">Penulis & Views</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4">Tanggal Publikasi</th>
                        <th class="py-3.5 px-4 text-right rounded-r-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($beritas as $item)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <!-- Judul & Thumbnail -->
                        <td class="py-4 px-4 max-w-xs">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl overflow-hidden bg-slate-100 border border-slate-200 flex-shrink-0">
                                    <img src="{{ $item->gambar_url }}" alt="{{ $item->judul }}" class="w-full h-full object-cover">
                                </div>
                                <div class="min-w-0">
                                    <a href="{{ route('berita.detail', $item->slug) }}" target="_blank" class="font-bold text-slate-800 hover:text-forest-700 transition-colors text-sm line-clamp-1 flex items-center gap-1">
                                        <span>{{ $item->judul }}</span>
                                        <i data-lucide="external-link" class="w-3 h-3 text-slate-400"></i>
                                    </a>
                                    <p class="text-slate-500 text-xs line-clamp-1 mt-0.5 font-light">{{ $item->ringkasan }}</p>
                                </div>
                            </div>
                        </td>

                        <!-- Penulis & Views -->
                        <td class="py-4 px-4 whitespace-nowrap">
                            <div class="text-slate-800 font-semibold text-xs">{{ $item->penulis }}</div>
                            <div class="text-slate-400 text-[11px] flex items-center gap-1 mt-0.5">
                                <i data-lucide="eye" class="w-3 h-3"></i>
                                <span>{{ number_format($item->views) }}x dibaca</span>
                            </div>
                        </td>

                        <!-- Status -->
                        <td class="py-4 px-4 whitespace-nowrap">
                            @if($item->is_published)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Terbit
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                Draft
                            </span>
                            @endif
                        </td>

                        <!-- Tanggal -->
                        <td class="py-4 px-4 whitespace-nowrap text-slate-500 text-xs">
                            {{ $item->published_at ? $item->published_at->translatedFormat('d M Y, H:i') : '-' }}
                        </td>

                        <!-- Aksi -->
                        <td class="py-4 px-4 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end gap-1.5">
                                <a href="{{ route('admin.berita.edit', $item->id) }}"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-100 text-slate-600 hover:bg-forest-50 hover:text-forest-700 transition-all"
                                    title="Edit Berita">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>

                                <form action="{{ route('admin.berita.destroy', $item->id) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        onclick="submitDeleteForm(this)"
                                        data-judul="{{ addslashes($item->judul) }}"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all"
                                        title="Hapus Berita">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-slate-400">
                            <div class="flex flex-col items-center justify-center gap-2">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 mb-1">
                                    <i data-lucide="newspaper" class="w-6 h-6"></i>
                                </div>
                                <p class="text-sm font-semibold text-slate-600">Belum Ada Data Berita</p>
                                <p class="text-xs text-slate-400">Klik tombol "Tambah Berita Baru" untuk menulis berita pertama.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($beritas->hasPages())
        <div class="pt-4 border-t border-slate-100">
            {{ $beritas->links() }}
        </div>
        @endif
    </div>

</div>
@endsection

@push('scripts')
<script>
function submitDeleteForm(btn) {
    const judul = btn.getAttribute('data-judul');
    if (window.confirm('Hapus berita "' + judul + '"?\nTindakan ini tidak dapat dibatalkan.')) {
        btn.closest('form').submit();
    }
}
</script>
@endpush