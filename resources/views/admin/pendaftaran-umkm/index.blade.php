@extends('admin.layouts.admin')

@section('title', 'Kelola Pendaftaran UMKM - Admin Desa Jambelaer')
@section('page-title', 'Pendaftaran UMKM')

@section('content')
<div class="space-y-6">
    <!-- Header & Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center">
            <div class="p-3 rounded-lg bg-emerald-50 text-emerald-600 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div>
                <span class="text-xs text-gray-500 font-medium">Total Pendaftaran</span>
                <p class="text-2xl font-bold text-gray-800">{{ $pendaftaranUmkms->total() }}</p>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center">
            <div class="p-3 rounded-lg bg-amber-50 text-amber-600 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <span class="text-xs text-gray-500 font-medium">Menunggu Verifikasi</span>
                <p class="text-2xl font-bold text-amber-600">{{ \App\Models\PendaftaranUmkm::whereIn('status', ['menunggu_verifikasi', 'diproses'])->count() }}</p>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center">
            <div class="p-3 rounded-lg bg-blue-50 text-blue-600 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <span class="text-xs text-gray-500 font-medium">Disetujui</span>
                <p class="text-2xl font-bold text-blue-600">{{ \App\Models\PendaftaranUmkm::where('status', 'disetujui')->count() }}</p>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center">
            <div class="p-3 rounded-lg bg-purple-50 text-purple-600 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
            </div>
            <div>
                <span class="text-xs text-gray-500 font-medium">Telah Dipublikasikan</span>
                <p class="text-2xl font-bold text-purple-600">{{ \App\Models\PendaftaranUmkm::has('produkDipublikasikan')->count() }}</p>
            </div>
        </div>
    </div>

    <!-- Filter & Search Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <form method="GET" action="{{ route('admin.pendaftaran-umkm.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Pencarian</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama usaha, pemilik, NIK, NIB..." class="w-full text-sm border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Status Verifikasi</label>
                <select name="status" class="w-full text-sm border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">Semua Status</option>
                    <option value="menunggu_verifikasi" {{ request('status') == 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                    <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Status Publikasi Katalog</label>
                <select name="published" class="w-full text-sm border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">Semua</option>
                    <option value="1" {{ request('published') === '1' ? 'selected' : '' }}>Sudah Publikasi</option>
                    <option value="0" {{ request('published') === '0' ? 'selected' : '' }}>Belum Publikasi</option>
                </select>
            </div>
            <div class="flex items-end space-x-2">
                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 px-4 rounded-lg text-sm transition">
                    Filter
                </button>
                <a href="{{ route('admin.pendaftaran-umkm.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 font-medium py-2 px-3 rounded-lg text-sm transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
                <thead class="bg-gray-50 text-gray-600 font-medium">
                    <tr>
                        <th class="px-6 py-3">Kode & Tanggal</th>
                        <th class="px-6 py-3">Nama Usaha & Pemilik</th>
                        <th class="px-6 py-3">Legalitas (NIB / Halal)</th>
                        <th class="px-6 py-3">Status Verifikasi</th>
                        <th class="px-6 py-3">Publikasi Katalog</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pendaftaranUmkms as $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <span class="font-mono text-xs font-semibold text-emerald-700 block">{{ $item->kode_pendaftaran }}</span>
                            <span class="text-xs text-gray-500">{{ $item->created_at->format('d/m/Y H:i') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-900">{{ $item->nama_usaha }}</div>
                            <div class="text-xs text-gray-500">{{ $item->nama_pemilik }} &bull; {{ $item->whatsapp ?? $item->telepon }}</div>
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-600 space-y-1">
                            <div><span class="font-medium text-gray-400">NIB:</span> {{ $item->nib ?? '-' }}</div>
                            <div><span class="font-medium text-gray-400">Halal:</span> {{ $item->nomor_halal ?? ($item->status_halal ? 'Ada' : 'Belum') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full 
                                @if($item->status === 'disetujui') bg-emerald-100 text-emerald-800
                                @elseif($item->status === 'diproses') bg-blue-100 text-blue-800
                                @elseif($item->status === 'menunggu_verifikasi') bg-amber-100 text-amber-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucwords(str_replace('_', ' ', $item->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($item->is_published)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    Aktif di Katalog
                                </span>
                            @else
                                <span class="text-xs text-gray-400">Belum dipublikasikan</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.pendaftaran-umkm.show', $item->id) }}" class="inline-flex items-center px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-medium rounded-lg text-xs transition">
                                Detail / Verifikasi
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            Belum ada permohonan pendaftaran UMKM.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $pendaftaranUmkms->links() }}
        </div>
    </div>
</div>
@endsection
