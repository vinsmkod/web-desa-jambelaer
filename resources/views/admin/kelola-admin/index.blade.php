@extends('admin.layouts.admin')

@section('title', 'Kelola Pengguna')
@section('page_title', 'Kelola Pengguna')
@section('page_subtitle', 'Daftar akun pengguna sistem: Perangkat Desa dan Masyarakat yang telah terdaftar')

@section('content')
<div class="space-y-6">

    <!-- Header & Action Button Banner -->
    <div class="p-5 rounded-2xl bg-forest-50/80 border border-forest-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 shadow-xs">
        <div class="flex items-center gap-4">
            <div class="w-11 h-11 rounded-2xl bg-forest-800 text-white flex items-center justify-center shadow-xs flex-shrink-0">
                <i data-lucide="users" class="w-5 h-5 text-amber-300"></i>
            </div>
            <div>
                <h2 class="text-base font-bold text-slate-900">Kelola Pengguna Sistem</h2>
                <p class="text-xs text-slate-500 mt-0.5">Daftar akun Perangkat Desa dan Masyarakat yang terdaftar dalam sistem.</p>
            </div>
        </div>
        <a href="{{ route('admin.kelola-admin.create') }}" class="btn-primary flex-shrink-0 text-xs py-2.5 px-4">
            <i data-lucide="user-plus" class="w-4 h-4"></i>
            Tambah Akun Perangkat Desa
        </a>
    </div>

    <!-- Search Bar -->
    <form method="GET" action="{{ route('admin.kelola-admin.index') }}" class="flex gap-3 items-center">
        <input type="hidden" name="tab" value="{{ $activeTab }}">
        <div class="relative flex-1 max-w-sm">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <i data-lucide="search" class="w-4 h-4"></i>
            </div>
            <input type="text" name="search" value="{{ $search }}"
                placeholder="Cari nama, email, atau jabatan..."
                class="form-input !pl-10 text-sm py-2.5">
        </div>
        <button type="submit" class="btn-secondary text-xs py-2.5 px-4">Cari</button>
        @if($search)
            <a href="{{ route('admin.kelola-admin.index', ['tab' => $activeTab]) }}" class="btn-secondary text-xs py-2.5 px-4">
                <i data-lucide="x" class="w-3.5 h-3.5"></i>
                Reset
            </a>
        @endif
    </form>

    <!-- Tabs -->
    <div class="border-b border-slate-200">
        <nav class="flex gap-1" aria-label="Tabs">
            <a href="{{ route('admin.kelola-admin.index', array_filter(['tab' => 'perangkat', 'search' => $search])) }}"
               class="inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold border-b-2 transition-colors
                      {{ $activeTab === 'perangkat'
                          ? 'border-forest-700 text-forest-700'
                          : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }}">
                <i data-lucide="shield-check" class="w-4 h-4"></i>
                Perangkat Desa
                <span class="inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full text-[11px] font-bold
                             {{ $activeTab === 'perangkat' ? 'bg-forest-100 text-forest-800' : 'bg-slate-100 text-slate-600' }}">
                    {{ $admins->count() }}
                </span>
            </a>
            <a href="{{ route('admin.kelola-admin.index', array_filter(['tab' => 'masyarakat', 'search' => $search])) }}"
               class="inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold border-b-2 transition-colors
                      {{ $activeTab === 'masyarakat'
                          ? 'border-forest-700 text-forest-700'
                          : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }}">
                <i data-lucide="users" class="w-4 h-4"></i>
                Masyarakat
                <span class="inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full text-[11px] font-bold
                             {{ $activeTab === 'masyarakat' ? 'bg-forest-100 text-forest-800' : 'bg-slate-100 text-slate-600' }}">
                    {{ $masyarakat->count() }}
                </span>
            </a>
        </nav>
    </div>

    {{-- ══════════════════════════════════════════════════════════
         TAB: PERANGKAT DESA
    ══════════════════════════════════════════════════════════ --}}
    @if($activeTab === 'perangkat')
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-forest-50 border border-forest-100 flex items-center justify-center text-forest-700">
                    <i data-lucide="shield-check" class="w-4 h-4"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Perangkat Desa Terdaftar</h3>
                    <p class="text-xs text-slate-400">
                        {{ $search ? 'Ditemukan ' . $admins->count() . ' akun' : 'Total ' . $admins->count() . ' akun aktif' }}
                    </p>
                </div>
            </div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200 w-fit">
                <i data-lucide="shield-check" class="w-3.5 h-3.5"></i>
                Role-Based Access Control (SRS)
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/60 text-slate-500 font-bold uppercase tracking-wider">
                        <th class="py-3.5 px-4 rounded-l-xl w-8">#</th>
                        <th class="py-3.5 px-4">Nama & Email</th>
                        <th class="py-3.5 px-4">Kewenangan / Role</th>
                        <th class="py-3.5 px-4">Jabatan Struktural</th>
                        <th class="py-3.5 px-4">Terdaftar</th>
                        <th class="py-3.5 px-4 text-right rounded-r-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($admins as $i => $admin)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="py-4 px-4 text-slate-400 font-medium">{{ $i + 1 }}</td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-forest-800 text-white font-bold text-xs flex items-center justify-center flex-shrink-0 shadow-xs">
                                    {{ strtoupper(substr($admin->name, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="font-bold text-slate-800 text-sm flex items-center gap-2">
                                        {{ $admin->name }}
                                        @if($admin->user_id === auth()->id())
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-forest-50 text-forest-700 border border-forest-200">Anda</span>
                                        @endif
                                    </div>
                                    <div class="text-slate-400 text-xs mt-0.5">{{ $admin->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold border {{ $admin->role_badge_class }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                {{ $admin->role_label }}
                            </span>
                        </td>
                        <td class="py-4 px-4 text-slate-700 font-medium text-xs">
                            {{ $admin->jabatan ?? '-' }}
                        </td>
                        <td class="py-4 px-4 text-slate-500 text-xs">
                            {{ $admin->created_at ? $admin->created_at->translatedFormat('d M Y') : '-' }}
                        </td>
                        <td class="py-4 px-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.kelola-admin.edit', $admin->user_id) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-forest-50 text-forest-700 border border-forest-200 text-xs font-semibold hover:bg-forest-100 transition-all"
                                   title="Edit Data & Reset Password">
                                    <i data-lucide="edit" class="w-3.5 h-3.5"></i>
                                    <span>Edit</span>
                                </a>
                                @if($admin->user_id !== auth()->id() && $admins->count() > 1)
                                <form action="{{ route('admin.kelola-admin.destroy', $admin->user_id) }}" method="POST"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ $admin->name }}?')" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-xl bg-red-50 text-red-600 border border-red-200 hover:bg-red-100 transition-all" title="Hapus Akun">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-10 text-center">
                            <div class="flex flex-col items-center gap-2 text-slate-400">
                                <i data-lucide="user-x" class="w-8 h-8 opacity-40"></i>
                                <p class="text-sm font-medium">{{ $search ? 'Tidak ada hasil pencarian.' : 'Belum ada akun perangkat desa terdaftar.' }}</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- ══════════════════════════════════════════════════════════
         TAB: MASYARAKAT
    ══════════════════════════════════════════════════════════ --}}
    @if($activeTab === 'masyarakat')
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600">
                    <i data-lucide="users" class="w-4 h-4"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Masyarakat Terdaftar</h3>
                    <p class="text-xs text-slate-400">
                        {{ $search ? 'Ditemukan ' . $masyarakat->count() . ' akun' : 'Total ' . $masyarakat->count() . ' akun masyarakat' }}
                    </p>
                </div>
            </div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200 w-fit">
                <i data-lucide="user-check" class="w-3.5 h-3.5"></i>
                Registrasi Mandiri
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/60 text-slate-500 font-bold uppercase tracking-wider">
                        <th class="py-3.5 px-4 rounded-l-xl w-8">#</th>
                        <th class="py-3.5 px-4">Nama & Email</th>
                        <th class="py-3.5 px-4">No. Telepon</th>
                        <th class="py-3.5 px-4">Alamat</th>
                        <th class="py-3.5 px-4">Terdaftar</th>
                        <th class="py-3.5 px-4 text-right rounded-r-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($masyarakat as $i => $warga)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="py-4 px-4 text-slate-400 font-medium">{{ $i + 1 }}</td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-blue-600 text-white font-bold text-xs flex items-center justify-center flex-shrink-0 shadow-xs">
                                    {{ strtoupper(substr($warga->name, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="font-bold text-slate-800 text-sm">{{ $warga->name }}</div>
                                    <div class="text-slate-400 text-xs mt-0.5">{{ $warga->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-slate-600 text-xs">
                            {{ $warga->no_hp ?? '-' }}
                        </td>
                        <td class="py-4 px-4 text-slate-600 text-xs max-w-xs">
                            <span class="line-clamp-2">{{ $warga->alamat ?? '-' }}</span>
                        </td>
                        <td class="py-4 px-4 text-slate-500 text-xs">
                            {{ $warga->created_at ? $warga->created_at->translatedFormat('d M Y') : '-' }}
                        </td>
                        <td class="py-4 px-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <form action="{{ route('admin.kelola-admin.destroy', $warga->user_id) }}" method="POST"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun masyarakat {{ $warga->name }}?\nTindakan ini tidak dapat dibatalkan.')" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-red-50 text-red-600 border border-red-200 text-xs font-semibold hover:bg-red-100 transition-all" title="Hapus Akun Masyarakat">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-10 text-center">
                            <div class="flex flex-col items-center gap-2 text-slate-400">
                                <i data-lucide="users" class="w-8 h-8 opacity-40"></i>
                                <p class="text-sm font-medium">{{ $search ? 'Tidak ada hasil pencarian.' : 'Belum ada akun masyarakat yang terdaftar.' }}</p>
                                @if(!$search)
                                    <p class="text-xs">Akun masyarakat akan muncul otomatis setelah warga melakukan registrasi.</p>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif

</div>
@endsection
