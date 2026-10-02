@extends('admin.layouts.admin')

@section('title', 'Kelola Jenis Surat')
@section('page_title', 'Kelola Jenis Surat')
@section('page_subtitle', 'Atur jenis-jenis surat keterangan yang dapat diajukan oleh masyarakat')

@section('content')

{{-- Tombol Tambah + Info --}}
<div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-forest-100 flex items-center justify-center">
            <i data-lucide="file-text" class="w-5 h-5 text-forest-700"></i>
        </div>
        <div>
            <p class="text-sm font-semibold text-slate-800">{{ $jenisSurats->count() }} Jenis Surat Terdaftar</p>
            <p class="text-xs text-slate-400">{{ $jenisSurats->where('is_active', true)->count() }} aktif tersedia untuk pengajuan</p>
        </div>
    </div>
    <a href="{{ route('admin.jenis-surat.create') }}"
       class="inline-flex items-center gap-2 px-4 py-2.5 bg-forest-800 hover:bg-forest-900 text-white rounded-xl text-sm font-bold transition-all shadow-sm">
        <i data-lucide="plus" class="w-4 h-4"></i>
        Tambah Jenis Surat
    </a>
</div>

@if(session('success'))
<div class="mb-4 flex items-center gap-3 px-4 py-3 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 text-sm font-medium">
    <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600 flex-shrink-0"></i>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="mb-4 flex items-center gap-3 px-4 py-3 bg-red-50 border border-red-200 rounded-xl text-red-800 text-sm font-medium">
    <i data-lucide="alert-circle" class="w-4 h-4 text-red-600 flex-shrink-0"></i>
    {{ session('error') }}
</div>
@endif

{{-- Daftar Jenis Surat --}}
<div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
    @if($jenisSurats->isEmpty())
    <div class="flex flex-col items-center justify-center py-20 text-slate-400">
        <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center mb-3">
            <i data-lucide="file-x" class="w-7 h-7"></i>
        </div>
        <p class="font-semibold text-slate-600">Belum ada jenis surat</p>
        <p class="text-sm mt-1">Tambahkan jenis surat pertama untuk masyarakat</p>
        <a href="{{ route('admin.jenis-surat.create') }}"
           class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-forest-800 text-white rounded-xl text-sm font-bold hover:bg-forest-900 transition-all">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Tambah Jenis Surat
        </a>
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50 text-xs font-bold text-slate-500 uppercase tracking-wider">
                    <th class="text-left px-5 py-3.5 w-10">#</th>
                    <th class="text-left px-4 py-3.5">Nama Surat</th>
                    <th class="text-left px-4 py-3.5 hidden md:table-cell">Kode</th>
                    <th class="text-left px-4 py-3.5 hidden lg:table-cell">Persyaratan Khusus</th>
                    <th class="text-left px-4 py-3.5">Status</th>
                    <th class="text-right px-5 py-3.5">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($jenisSurats as $item)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-4 text-slate-400 text-xs font-mono">{{ $loop->iteration }}</td>
                    <td class="px-4 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-forest-50 flex items-center justify-center flex-shrink-0">
                                <i data-lucide="file-text" class="w-4 h-4 text-forest-700"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-slate-800">{{ $item->nama_surat }}</p>
                                @if($item->deskripsi)
                                <p class="text-xs text-slate-400 mt-0.5 max-w-xs truncate">{{ $item->deskripsi }}</p>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-4 hidden md:table-cell">
                        @if($item->kode_surat)
                        <code class="text-xs bg-slate-100 text-slate-700 px-2 py-1 rounded-lg font-mono">{{ $item->kode_surat }}</code>
                        @else
                        <span class="text-slate-300">—</span>
                        @endif
                    </td>
                    <td class="px-4 py-4 hidden lg:table-cell">
                        @if($item->persyaratan_khusus)
                        <p class="text-xs text-slate-500 max-w-xs truncate">{{ $item->persyaratan_khusus }}</p>
                        @else
                        <span class="text-xs text-slate-300">KTP + KK (standar)</span>
                        @endif
                    </td>
                    <td class="px-4 py-4">
                        <form method="POST" action="{{ route('admin.jenis-surat.toggle', $item) }}" class="inline">
                            @csrf @method('PATCH')
                            <button type="submit"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold border transition-all
                                    {{ $item->is_active
                                        ? 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100'
                                        : 'bg-slate-50 text-slate-500 border-slate-200 hover:bg-slate-100' }}"
                                title="{{ $item->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                <i data-lucide="{{ $item->is_active ? 'toggle-right' : 'toggle-left' }}" class="w-3.5 h-3.5"></i>
                                {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                            </button>
                        </form>
                    </td>
                    <td class="px-5 py-4 text-right">
                        <div class="flex items-center justify-end gap-1.5">
                            <a href="{{ route('admin.jenis-surat.edit', $item) }}"
                               class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:bg-forest-50 hover:text-forest-700 transition-all" title="Edit">
                                <i data-lucide="pencil" class="w-4 h-4"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.jenis-surat.destroy', $item) }}"
                                  onsubmit="return confirm('Hapus jenis surat \'{{ $item->nama_surat }}\'? Data pengajuan yang menggunakan jenis ini tidak akan terhapus.')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:bg-red-50 hover:text-red-500 transition-all" title="Hapus">
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

{{-- Info Persyaratan Standar --}}
<div class="mt-6 p-4 bg-sky-50 border border-sky-200 rounded-xl flex items-start gap-3">
    <i data-lucide="info" class="w-4 h-4 text-sky-600 flex-shrink-0 mt-0.5"></i>
    <div class="text-sm text-sky-800">
        <p class="font-semibold">Persyaratan Standar Pengajuan Surat</p>
        <p class="text-sky-700 mt-1 font-normal">Semua pengajuan surat wajib melampirkan <strong>KTP</strong> dan <strong>Kartu Keluarga (KK)</strong>. Kolom "Persyaratan Khusus" digunakan untuk menambahkan dokumen pendukung tambahan per jenis surat (misal: akta kelahiran, surat nikah, dll.).</p>
    </div>
</div>

@endsection
