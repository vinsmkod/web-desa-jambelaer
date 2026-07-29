@extends('admin.layouts.admin')

@section('title', 'Budaya Desa')
@section('page_title', 'Pelestarian Seni & Tradisi Budaya')
@section('page_subtitle', 'Kelola atraksi budaya, kesenian, dan tradisi Desa Jambelaer')

@section('content')

<div class="flex items-center justify-between mb-6">
    <p class="text-slate-500 text-sm">{{ $budayaList->total() }} item budaya terdaftar</p>
    <a href="{{ route('admin.budaya.create') }}" class="btn-primary">
        <i data-lucide="plus" class="w-4 h-4"></i>
        Tambah Budaya
    </a>
</div>

<div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
    @if($budayaList->isEmpty())
    <div class="flex flex-col items-center justify-center py-20 text-slate-400">
        <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center mb-3">
            <i data-lucide="music" class="w-7 h-7"></i>
        </div>
        <p class="font-semibold text-slate-600">Belum ada data budaya</p>
        <p class="text-sm text-slate-400 mt-1">Mulai dengan menambahkan budaya/tradisi pertama</p>
        <a href="{{ route('admin.budaya.create') }}" class="btn-primary mt-4">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Tambah Budaya
        </a>
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50 text-xs font-bold text-slate-500 uppercase tracking-wider">
                    <th class="px-5 py-3.5 w-16 text-center">Urutan</th>
                    <th class="px-5 py-3.5">Budaya</th>
                    <th class="px-4 py-3.5 hidden sm:table-cell">Deskripsi Singkat</th>
                    <th class="px-5 py-3.5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($budayaList as $b)
                <tr class="hover:bg-slate-50 transition-colors group">
                    <td class="px-5 py-3.5 text-center text-slate-400 font-mono font-medium">
                        {{ $b->urutan }}
                    </td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <img src="{{ $b->img_url }}" alt="{{ $b->title }}"
                                 class="w-12 h-12 rounded-xl object-cover bg-slate-100 flex-shrink-0 border border-slate-200">
                            <div class="min-w-0">
                                <p class="font-semibold text-slate-800 truncate">{{ $b->title }}</p>
                                <span class="inline-block text-[10px] font-bold text-forest-700 bg-forest-50 border border-forest-200 px-2 py-0.5 rounded-full mt-1 uppercase tracking-wide">
                                    {{ $b->kategori }}
                                </span>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3.5 text-slate-500 hidden sm:table-cell max-w-xs truncate">
                        {{ $b->excerpt }}
                    </td>
                    <td class="px-5 py-3.5 text-right">
                        <div class="flex items-center justify-end gap-1.5">
                            <a href="{{ route('admin.budaya.edit', $b) }}"
                               class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:bg-forest-50 hover:text-forest-700 transition-all"
                               title="Edit Budaya">
                                <i data-lucide="pencil" class="w-4 h-4"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.budaya.destroy', $b) }}"
                                  onsubmit="return confirm('Hapus budaya {{ $b->title }}?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:bg-red-50 hover:text-red-500 transition-all"
                                    title="Hapus Budaya">
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
    @if($budayaList->hasPages())
    <div class="px-5 py-4 border-t border-slate-100">
        {{ $budayaList->links() }}
    </div>
    @endif
    @endif
</div>

@endsection
