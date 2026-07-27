@extends('admin.layouts.admin')

@section('title', 'Kelola Admin')
@section('page_title', 'Kelola Admin')
@section('page_subtitle', 'Mendaftarkan dan melihat daftar administrator sistem')

@section('content')
<div class="space-y-6">

    <!-- Header & Action Button Card -->
    <div class="p-5 rounded-2xl bg-slate-900 border border-slate-800 shadow-xl flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-600 to-emerald-400 flex items-center justify-center text-white shadow-lg flex-shrink-0">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
            <div>
                <h2 class="text-base font-bold text-white">Daftar Administrator Sistem</h2>
                <p class="text-xs text-slate-400 mt-0.5">Admin yang aktif hanya dapat **mendaftarkan admin baru** dan melihat daftar admin terdaftar. Fitur edit dan hapus dinonaktifkan.</p>
            </div>
        </div>
        <a href="{{ route('admin.kelola-admin.create') }}" class="btn-primary flex-shrink-0 text-xs">
            <i data-lucide="user-plus" class="w-4 h-4"></i>
            Tambah Admin Baru
        </a>
    </div>

    <!-- Full Width Table Container -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-800">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-blue-600/20 flex items-center justify-center text-blue-400">
                    <i data-lucide="shield-check" class="w-4 h-4"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-white">Admin Terdaftar</h3>
                    <p class="text-xs text-slate-500">Total {{ $admins->count() }} akun administrator aktif</p>
                </div>
            </div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-slate-800 text-slate-400 border border-slate-700 w-fit">
                <i data-lucide="lock" class="w-3.5 h-3.5 text-slate-500"></i>
                Fitur Edit & Hapus Dinonaktifkan
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-800 text-slate-400 uppercase tracking-wider">
                        <th class="py-3.5 px-4">Admin</th>
                        <th class="py-3.5 px-4">Status Hak Akses</th>
                        <th class="py-3.5 px-4">Tanggal Terdaftar</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse ($admins as $admin)
                    <tr class="hover:bg-slate-800/40 transition-colors">
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-emerald-600 to-emerald-400 flex items-center justify-center text-white font-bold text-xs flex-shrink-0 shadow">
                                    {{ strtoupper(substr($admin->name, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="font-semibold text-slate-200 text-sm flex items-center gap-2">
                                        {{ $admin->name }}
                                        @if($admin->id === auth()->id())
                                            <span class="px-2 py-0.5 rounded text-[10px] font-extrabold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">Anda</span>
                                        @endif
                                    </div>
                                    <div class="text-slate-400 text-xs">{{ $admin->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                Administrator Aktif
                            </span>
                        </td>
                        <td class="py-4 px-4 text-slate-400">
                            {{ $admin->created_at ? $admin->created_at->translatedFormat('d M Y, H:i') : '-' }}
                        </td>
                        <td class="py-4 px-4 text-right">
                            <span class="inline-flex items-center gap-1.5 text-[11px] text-slate-500 bg-slate-800/50 px-2.5 py-1 rounded-lg border border-slate-800" title="Aksi ubah & hapus tidak diperbolehkan">
                                <i data-lucide="lock" class="w-3.5 h-3.5 text-slate-500"></i>
                                Terkunci
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-12 text-center text-slate-500">
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
