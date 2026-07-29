
@extends('admin.layouts.admin')

@section('title', 'Produk UMKM')
@section('page_title', 'Produk UMKM')
@section('page_subtitle', 'Kelola produk yang tampil di halaman UMKM')

@section('content')

{{-- ── Stats Row ──────────────────────────────────────────────────────── --}}
@php
    $totalAktif    = $allProduk->where('is_active', true)->count();
    $totalJenis    = $allProduk->whereNotNull('jenis')->groupBy('jenis')->count();
    $totalIndividu = $allProduk->whereNull('jenis')->count();
@endphp
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
    <div class="bg-white border border-slate-200 rounded-2xl p-5">
        <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Total Produk</p>
        <p class="text-2xl font-extrabold text-slate-900 mt-1">{{ $produk->count() }}</p>
    </div>
    <div class="bg-white border border-slate-200 rounded-2xl p-5">
        <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Aktif</p>
        <p class="text-2xl font-extrabold text-forest-700 mt-1">{{ $totalAktif }}</p>
    </div>
    <div class="bg-white border border-slate-200 rounded-2xl p-5">
        <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Kelompok Jenis</p>
        <p class="text-2xl font-extrabold text-violet-600 mt-1">{{ $totalJenis }}</p>
        <p class="text-xs text-slate-400 mt-0.5">Cth: Opak</p>
    </div>
    <div class="bg-white border border-slate-200 rounded-2xl p-5">
        <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Individu</p>
        <p class="text-2xl font-extrabold text-amber-600 mt-1">{{ $totalIndividu }}</p>
    </div>
</div>

{{-- ── Header Actions ──────────────────────────────────────────────────── --}}
<div class="flex items-center justify-between mb-4">
    <p class="text-slate-500 text-sm">{{ $allProduk->count() }} produk terdaftar</p>
    <a href="{{ route('admin.produk.create') }}" class="btn-primary">
        <i data-lucide="plus" class="w-4 h-4"></i>
        Tambah Produk
    </a>
</div>

{{-- ── Table ───────────────────────────────────────────────────────────── --}}
<div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
    @if($produk->isEmpty())
    <div class="flex flex-col items-center justify-center py-20 text-slate-400">
        <i data-lucide="package" class="w-12 h-12 mb-3"></i>
        <p class="font-semibold text-slate-600">Belum ada produk</p>
        <p class="text-sm mt-1">Mulai dengan menambahkan produk pertama</p>
        <a href="{{ route('admin.produk.create') }}" class="btn-primary mt-4">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Tambah Produk
        </a>
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50 text-xs font-bold text-slate-500 uppercase tracking-wider">
                    <th class="text-left px-5 py-3.5">Produk</th>
                    <th class="text-left px-4 py-3.5 hidden sm:table-cell">Produsen</th>
                    <th class="text-left px-4 py-3.5 hidden md:table-cell">Harga</th>
                    <th class="text-left px-4 py-3.5 hidden lg:table-cell">Jenis / Kelompok</th>
                    <th class="text-left px-4 py-3.5 hidden lg:table-cell">Badge</th>
                    <th class="text-left px-4 py-3.5">Status</th>
                    <th class="text-right px-5 py-3.5">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($produk as $p)
                <tr class="hover:bg-slate-50 transition-colors">

                    {{-- Kolom: Gambar + Nama --}}
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <img src="{{ $p->img }}" alt="{{ $p->title }}"
                                 class="w-12 h-12 rounded-xl object-cover bg-slate-100 border border-slate-200 flex-shrink-0">
                            <div>
                                <p class="font-semibold text-slate-800">{{ $p->title }}</p>
                                <p class="text-xs text-slate-400 mt-0.5 font-mono">{{ $p->slug }}</p>
                            </div>
                        </div>
                    </td>

                    {{-- Kolom: Produsen --}}
                    <td class="px-4 py-3.5 text-slate-600 hidden sm:table-cell">{{ $p->producer }}</td>

                    {{-- Kolom: Harga --}}
                    <td class="px-4 py-3.5 font-semibold text-amber-600 hidden md:table-cell">{{ $p->price }}</td>

                    {{-- Kolom: Jenis / Kelompok --}}
                    <td class="px-4 py-3.5 hidden lg:table-cell">
                        @if($p->jenis)
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-violet-50 text-violet-700 border border-violet-200">
                                <i data-lucide="layers" class="w-3 h-3"></i>
                                {{ $p->jenis_label ?? ucfirst($p->jenis) }}
                            </span>
                        @else
                            <span class="text-xs text-slate-400 italic">Individu</span>
                        @endif
                    </td>

                    {{-- Kolom: Badge --}}
                    <td class="px-4 py-3.5 hidden lg:table-cell">
                        @php
                            $badgeColor = match($p->badge) {
                                'Makanan'   => 'bg-amber-50 text-amber-700 border-amber-200',
                                'Kerajinan' => 'bg-violet-50 text-violet-700 border-violet-200',
                                default     => 'bg-forest-50 text-forest-700 border-forest-200',
                            };
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border {{ $badgeColor }}">
                            {{ $p->badge }}
                        </span>
                    </td>

                    {{-- Kolom: Status --}}
                    <td class="px-4 py-3.5">
                        <span class="{{ $p->is_active ? 'badge-read' : 'badge-unread' }}">
                            {{ $p->is_active ? 'Aktif' : 'Non-aktif' }}
                        </span>
                    </td>

                    {{-- Kolom: Aksi --}}
                    <td class="px-5 py-3.5 text-right">
                        <div class="flex items-center justify-end gap-1.5">
                            @if($p->jenis)
                            <a href="{{ route('umkm.jenis', $p->jenis) }}" target="_blank"
                               title="Lihat halaman produsen {{ $p->jenis_label ?? $p->jenis }} di website"
                               class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-700 transition-all">
                                <i data-lucide="external-link" class="w-4 h-4"></i>
                            </a>
                            @else
                            <a href="{{ route('umkm.detail', $p->slug) }}" target="_blank"
                               title="Lihat di website"
                               class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-700 transition-all">
                                <i data-lucide="external-link" class="w-4 h-4"></i>
                            </a>
                            @endif

                            <a href="{{ route('admin.produk.edit', $p) }}"
                               title="Edit produk"
                               class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:bg-forest-50 hover:text-forest-700 transition-all">
                                <i data-lucide="pencil" class="w-4 h-4"></i>
                            </a>

                            <form method="POST" action="{{ route('admin.produk.destroy', $p) }}"
                                  onsubmit="return confirm('Hapus produk {{ addslashes($p->title) }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" title="Hapus produk"
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
    {{-- Pagination --}}
    @if($produk->hasPages())
    <div class="px-5 py-4 border-t border-slate-100">
        {{ $produk->links() }}
    </div>
    @endif
    @endif
</div>

{{-- ── Info Kelompok Jenis ─────────────────────────────────────────────── --}}
@php $jenisGroups = $allProduk->whereNotNull('jenis')->groupBy('jenis'); @endphp
@if($jenisGroups->isNotEmpty())
<div class="mt-6 bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
    <div class="flex items-center gap-2 mb-4">
        <i data-lucide="layers" class="w-4 h-4 text-violet-600"></i>
        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Kelompok Jenis Produk</h3>
    </div>
    <div class="flex flex-wrap gap-3">
        @foreach($jenisGroups as $jenisSlug => $jenisProds)
        <a href="{{ route('umkm.jenis', $jenisSlug) }}" target="_blank"
           class="flex items-center gap-2 px-4 py-2 bg-slate-50 hover:bg-violet-50 border border-slate-200 hover:border-violet-200 rounded-xl transition-all group">
            <span class="text-xs font-bold text-violet-700">{{ $jenisProds->first()->jenis_label ?? ucfirst($jenisSlug) }}</span>
            <span class="text-xs text-slate-500 bg-slate-200 group-hover:bg-violet-100 px-1.5 py-0.5 rounded-full transition-colors">{{ $jenisProds->count() }} produsen</span>
            <i data-lucide="external-link" class="w-3 h-3 text-slate-400 group-hover:text-violet-500 transition-colors"></i>
        </a>
        @endforeach
    </div>
    <p class="text-xs text-slate-400 mt-3 flex items-center gap-1">
        <i data-lucide="info" class="w-3 h-3"></i>
        Produk dalam kelompok yang sama akan tampil di satu halaman "Daftar Produsen" di website.
    </p>
</div>
@endif

@endsection
