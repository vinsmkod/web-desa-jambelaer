@extends('admin.layouts.admin')

@section('title', 'Produk UMKM')
@section('page_title', 'Produk UMKM')
@section('page_subtitle', 'Kelola produk yang tampil di halaman UMKM')

@section('content')

{{-- ── Stats Row ──────────────────────────────────────────────────────── --}}
@php
    $totalAktif   = $produk->where('is_active', true)->count();
    $totalJenis   = $produk->whereNotNull('jenis')->groupBy('jenis')->count();
    $totalIndividu = $produk->whereNull('jenis')->count();
@endphp
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-4">
        <p class="text-xs text-slate-500 font-medium uppercase tracking-wider">Total Produk</p>
        <p class="text-2xl font-extrabold text-white mt-1">{{ $produk->count() }}</p>
    </div>
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-4">
        <p class="text-xs text-slate-500 font-medium uppercase tracking-wider">Aktif</p>
        <p class="text-2xl font-extrabold text-emerald-400 mt-1">{{ $totalAktif }}</p>
    </div>
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-4">
        <p class="text-xs text-slate-500 font-medium uppercase tracking-wider">Kelompok Jenis</p>
        <p class="text-2xl font-extrabold text-violet-400 mt-1">{{ $totalJenis }}</p>
        <p class="text-xs text-slate-600 mt-0.5">Cth: Opak</p>
    </div>
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-4">
        <p class="text-xs text-slate-500 font-medium uppercase tracking-wider">Individu</p>
        <p class="text-2xl font-extrabold text-amber-400 mt-1">{{ $totalIndividu }}</p>
    </div>
</div>

{{-- ── Header Actions ──────────────────────────────────────────────────── --}}
<div class="flex items-center justify-between mb-4">
    <p class="text-slate-400 text-sm">{{ $produk->count() }} produk terdaftar</p>
    <a href="{{ route('admin.produk.create') }}" class="btn-primary">
        <i data-lucide="plus" class="w-4 h-4"></i>
        Tambah Produk
    </a>
</div>

{{-- ── Table ───────────────────────────────────────────────────────────── --}}
<div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
    @if($produk->isEmpty())
    <div class="flex flex-col items-center justify-center py-20 text-slate-600">
        <i data-lucide="package" class="w-12 h-12 mb-3"></i>
        <p class="font-semibold">Belum ada produk</p>
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
                <tr class="border-b border-slate-800 text-xs font-bold text-slate-500 uppercase tracking-wider">
                    <th class="text-left px-5 py-3.5">Produk</th>
                    <th class="text-left px-4 py-3.5 hidden sm:table-cell">Produsen</th>
                    <th class="text-left px-4 py-3.5 hidden md:table-cell">Harga</th>
                    <th class="text-left px-4 py-3.5 hidden lg:table-cell">Jenis / Kelompok</th>
                    <th class="text-left px-4 py-3.5 hidden lg:table-cell">Badge</th>
                    <th class="text-left px-4 py-3.5">Status</th>
                    <th class="text-right px-5 py-3.5">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                @foreach($produk as $p)
                <tr class="hover:bg-slate-800/40 transition-colors">

                    {{-- Kolom: Gambar + Nama --}}
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <img src="{{ $p->img }}" alt="{{ $p->title }}"
                                 class="w-12 h-12 rounded-xl object-cover bg-slate-800 flex-shrink-0">
                            <div>
                                <p class="font-semibold text-slate-200">{{ $p->title }}</p>
                                <p class="text-xs text-slate-500 mt-0.5 font-mono">{{ $p->slug }}</p>
                            </div>
                        </div>
                    </td>

                    {{-- Kolom: Produsen --}}
                    <td class="px-4 py-3.5 text-slate-400 hidden sm:table-cell">{{ $p->producer }}</td>

                    {{-- Kolom: Harga --}}
                    <td class="px-4 py-3.5 font-semibold text-amber-400 hidden md:table-cell">{{ $p->price }}</td>

                    {{-- Kolom: Jenis / Kelompok --}}
                    <td class="px-4 py-3.5 hidden lg:table-cell">
                        @if($p->jenis)
                            <div class="flex items-center gap-1.5">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-violet-600/20 text-violet-300 border border-violet-700/30">
                                    <i data-lucide="layers" class="w-3 h-3"></i>
                                    {{ $p->jenis_label ?? ucfirst($p->jenis) }}
                                </span>
                            </div>
                        @else
                            <span class="text-xs text-slate-600 italic">Individu</span>
                        @endif
                    </td>

                    {{-- Kolom: Badge --}}
                    <td class="px-4 py-3.5 hidden lg:table-cell">
                        @php
                            $badgeColor = match($p->badge) {
                                'Makanan'   => 'bg-amber-600/20 text-amber-400',
                                'Kerajinan' => 'bg-violet-600/20 text-violet-400',
                                default     => 'bg-emerald-600/20 text-emerald-400',
                            };
                        @endphp
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $badgeColor }}">
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
                        <div class="flex items-center justify-end gap-2">
                            {{-- Preview di website: jenis → halaman produsen, individu → detail langsung --}}
                            @if($p->jenis)
                            <a href="{{ route('umkm.jenis', $p->jenis) }}" target="_blank"
                               title="Lihat halaman produsen {{ $p->jenis_label ?? $p->jenis }} di website"
                               class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-500 hover:bg-slate-800 hover:text-slate-300 transition-all">
                                <i data-lucide="external-link" class="w-4 h-4"></i>
                            </a>
                            @else
                            <a href="{{ route('umkm.detail', $p->slug) }}" target="_blank"
                               title="Lihat di website"
                               class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-500 hover:bg-slate-800 hover:text-slate-300 transition-all">
                                <i data-lucide="external-link" class="w-4 h-4"></i>
                            </a>
                            @endif

                            {{-- Edit --}}
                            <a href="{{ route('admin.produk.edit', $p) }}"
                               title="Edit produk"
                               class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-500 hover:bg-sky-600/20 hover:text-sky-400 transition-all">
                                <i data-lucide="pencil" class="w-4 h-4"></i>
                            </a>

                            {{-- Hapus --}}
                            <form method="POST" action="{{ route('admin.produk.destroy', $p) }}"
                                  onsubmit="return confirm('Hapus produk {{ addslashes($p->title) }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" title="Hapus produk"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-500 hover:bg-red-600/20 hover:text-red-400 transition-all">
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
    @endif
</div>

{{-- ── Info Kelompok Jenis ─────────────────────────────────────────────── --}}
@php $jenisGroups = $produk->whereNotNull('jenis')->groupBy('jenis'); @endphp
@if($jenisGroups->isNotEmpty())
<div class="mt-6 bg-slate-900 border border-slate-800 rounded-2xl p-5">
    <div class="flex items-center gap-2 mb-4">
        <i data-lucide="layers" class="w-4 h-4 text-violet-400"></i>
        <h3 class="text-sm font-bold text-slate-300 uppercase tracking-wider">Kelompok Jenis Produk</h3>
    </div>
    <div class="flex flex-wrap gap-3">
        @foreach($jenisGroups as $jenisSlug => $jenisProds)
        <a href="{{ route('umkm.jenis', $jenisSlug) }}" target="_blank"
           class="flex items-center gap-2 px-4 py-2 bg-slate-800 hover:bg-slate-700 border border-slate-700 rounded-xl transition-all group">
            <span class="text-xs font-bold text-violet-300">{{ $jenisProds->first()->jenis_label ?? ucfirst($jenisSlug) }}</span>
            <span class="text-xs text-slate-500 bg-slate-700 px-1.5 py-0.5 rounded-full">{{ $jenisProds->count() }} produsen</span>
            <i data-lucide="external-link" class="w-3 h-3 text-slate-600 group-hover:text-slate-400 transition-colors"></i>
        </a>
        @endforeach
    </div>
    <p class="text-xs text-slate-600 mt-3">
        <i data-lucide="info" class="w-3 h-3 inline-block mr-1"></i>
        Produk dalam kelompok yang sama akan tampil di satu halaman "Daftar Produsen" di website.
    </p>
</div>
@endif

@endsection
