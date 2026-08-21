@extends('admin.layouts.admin')

@section('title', 'Kelola Admin')
@section('page_title', 'Kelola Admin')
@section('page_subtitle', 'Mendaftarkan, mengedit, dan mereset password administrator sistem')

@section('content')
<div class="space-y-6">

    <!-- Header & Action Button Banner -->
    <div class="p-5 rounded-2xl bg-forest-50/80 border border-forest-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 shadow-xs">
        <div class="flex items-center gap-4">
            <div class="w-11 h-11 rounded-2xl bg-forest-800 text-white flex items-center justify-center shadow-xs flex-shrink-0">
                <i data-lucide="users" class="w-5 h-5 text-amber-300"></i>
            </div>
            <div>
                <h2 class="text-base font-bold text-slate-900">Daftar Administrator Sistem</h2>
                <p class="text-xs text-slate-500 mt-0.5">Admin dapat mendaftarkan admin baru, mengedit data, atau mereset password admin lain jika lupa password.</p>
            </div>
        </div>
        <a href="{{ route('admin.kelola-admin.create') }}" class="btn-primary flex-shrink-0 text-xs py-2.5 px-4">
            <i data-lucide="user-plus" class="w-4 h-4"></i>
            Tambah Admin Baru
        </a>
    </div>

    <!-- Table Container -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-forest-50 border border-forest-100 flex items-center justify-center text-forest-700">
                    <i data-lucide="shield-check" class="w-4 h-4"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Admin Terdaftar</h3>
                    <p class="text-xs text-slate-400">Total {{ $admins->count() }} akun administrator aktif</p>
                </div>
            </div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200 w-fit">
                <i data-lucide="shield-check" class="w-3.5 h-3.5"></i>
                Akses Kelola Admin Aktif
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/60 text-slate-500 font-bold uppercase tracking-wider">
                        <th class="py-3.5 px-4 rounded-l-xl">Admin</th>
                        <th class="py-3.5 px-4">Status Hak Akses</th>
                        <th class="py-3.5 px-4">Tanggal Terdaftar</th>
                        <th class="py-3.5 px-4 text-right rounded-r-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($admins as $admin)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-forest-800 text-white font-bold text-xs flex items-center justify-center flex-shrink-0 shadow-xs">
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
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                Administrator Aktif
                            </span>
                        </td>
                        <td class="py-4 px-4 text-slate-500 text-xs">
                            {{ $admin->created_at ? $admin->created_at->translatedFormat('d M Y, H:i') : '-' }}
                        </td>
                        <td class="py-4 px-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.kelola-admin.edit', $admin->user_id) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-forest-50 text-forest-700 border border-forest-200 text-xs font-semibold hover:bg-forest-100 transition-all"
                                   title="Edit Data & Reset Password">
                                    <i data-lucide="key-round" class="w-3.5 h-3.5"></i>
                                    <span>Edit / Reset Pass</span>
                                </a>

                                @if($admin->user_id !== auth()->id() && $admins->count() > 1)
                                <form action="{{ route('admin.kelola-admin.destroy', $admin->user_id) }}" method="POST"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun admin {{ $admin->name }}?')" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-xl bg-red-50 text-red-600 border border-red-200 hover:bg-red-100 transition-all" title="Hapus Admin">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-12 text-center text-slate-400">
                            Belum ada admin terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
