<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') – Panel Admin Desa Jambelaer</title>
    <meta name="description" content="Panel Admin Desa Jambelaer">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS v4 -->
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Inter', ui-sans-serif, system-ui, sans-serif;
            --font-display: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;
            --color-forest-50:  #f0fdf4;
            --color-forest-100: #dcfce7;
            --color-forest-200: #bbf7d0;
            --color-forest-500: #22c55e;
            --color-forest-600: #16a34a;
            --color-forest-700: #15803d;
            --color-forest-800: #1a4731;
            --color-forest-900: #14532d;
        }

        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track  { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb  { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        .sidebar-link {
            @apply flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-500 hover:bg-slate-100 hover:text-slate-800 transition-all duration-150 relative;
        }
        .sidebar-link.active {
            @apply bg-forest-50 text-forest-700 font-semibold;
        }
        .sidebar-link.active::before {
            content: '';
            @apply absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-forest-600 rounded-r-full;
        }
        .sidebar-link .icon {
            @apply w-4 h-4 flex-shrink-0;
        }

        .stat-card {
            @apply bg-white border border-slate-200 rounded-2xl p-5 flex items-start gap-4 hover:border-slate-300 hover:shadow-sm transition-all duration-200;
        }
        .form-input {
            @apply w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-forest-500 focus:ring-1 focus:ring-forest-500 transition-all;
        }
        .form-label {
            @apply block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5;
        }
        .btn-primary {
            @apply inline-flex items-center gap-2 px-5 py-2.5 bg-forest-700 hover:bg-forest-800 text-white text-sm font-semibold rounded-xl transition-all duration-200 shadow-sm;
        }
        .btn-secondary {
            @apply inline-flex items-center gap-2 px-4 py-2.5 bg-white hover:bg-slate-50 text-slate-600 hover:text-slate-800 text-sm font-medium rounded-xl border border-slate-300 hover:border-slate-400 transition-all duration-200;
        }
        .btn-danger {
            @apply inline-flex items-center gap-2 px-4 py-2 bg-red-50 hover:bg-red-500 text-red-500 hover:text-white text-xs font-semibold rounded-xl border border-red-200 hover:border-red-500 transition-all duration-200;
        }
        .badge-read {
            @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-forest-50 text-forest-700 border border-forest-200;
        }
        .badge-unread {
            @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-600 border border-amber-200;
        }
        .badge-pending {
            @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-violet-50 text-violet-600 border border-violet-200;
        }
        .page-card {
            @apply bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm;
        }
        .table-th {
            @apply px-4 py-3 text-left text-[10px] font-bold uppercase tracking-wider text-slate-400 bg-slate-50;
        }
        .table-td {
            @apply px-4 py-3.5 text-sm text-slate-700 border-t border-slate-100;
        }
    </style>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    @stack('head')
</head>
<body class="h-full bg-slate-50 text-slate-800 font-sans antialiased flex">

    <!-- ══════════════ SIDEBAR ══════════════ -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-[220px] bg-white border-r border-slate-200 flex flex-col transition-transform duration-300 -translate-x-full lg:translate-x-0 shadow-sm">

        <!-- Brand -->
        <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-100 flex-shrink-0">
            <div class="w-9 h-9 rounded-xl bg-forest-800 flex items-center justify-center shadow-sm flex-shrink-0">
                <i data-lucide="wheat" class="w-4 h-4 text-amber-300"></i>
            </div>
            <div class="min-w-0">
                <span class="font-display font-bold text-sm text-slate-900 block leading-tight truncate">Desa Jambelaer</span>
                <span class="text-[10px] text-slate-400 font-medium tracking-wide block">Panel Admin</span>
            </div>
        </div>

        <!-- Nav -->
        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-0.5">
            <p class="px-3 text-[10px] font-bold tracking-widest uppercase text-slate-400 mb-2">Menu Utama</p>

            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i data-lucide="layout-dashboard" class="icon"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.produk.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.produk.*') ? 'active' : '' }}">
                <i data-lucide="package" class="icon"></i>
                <span>Produk UMKM</span>
                <span class="ml-auto text-[10px] bg-slate-100 text-slate-500 font-bold px-1.5 py-0.5 rounded-md">{{ \App\Models\Produk::count() }}</span>
            </a>
            <a href="{{ route('admin.pesan.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.pesan.*') || request()->routeIs('admin.pengajuan-acara.*') ? 'active' : '' }}">
                <i data-lucide="mail" class="icon"></i>
                <span>Pesan Masuk</span>
                @php $unread = \App\Models\Pesan::where('is_read', false)->count(); @endphp
                @if($unread > 0)
                <span class="ml-auto text-[10px] bg-amber-500 text-white font-bold px-1.5 py-0.5 rounded-md">{{ $unread }}</span>
                @endif
            </a>


            <p class="px-3 text-[10px] font-bold tracking-widest uppercase text-slate-400 mb-2 mt-4 pt-3 border-t border-slate-100">Konten</p>

            <a href="{{ route('admin.tentang.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.tentang.*') ? 'active' : '' }}">
                <i data-lucide="users-2" class="icon"></i>
                <span>Struktur Desa</span>
            </a>
            <a href="{{ route('admin.budaya.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.budaya.*') ? 'active' : '' }}">
                <i data-lucide="music-2" class="icon"></i>
                <span>Budaya Desa</span>
                <span class="ml-auto text-[10px] bg-slate-100 text-slate-500 font-bold px-1.5 py-0.5 rounded-md">{{ \App\Models\Budaya::count() }}</span>
            </a>
            <a href="{{ route('admin.wisata.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.wisata.*') ? 'active' : '' }}">
                <i data-lucide="compass" class="icon"></i>
                <span>Wisata Desa</span>
                <span class="ml-auto text-[10px] bg-slate-100 text-slate-500 font-bold px-1.5 py-0.5 rounded-md">{{ \App\Models\Wisata::count() }}</span>
            </a>
            <a href="{{ route('admin.galeri.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.galeri.*') ? 'active' : '' }}">
                <i data-lucide="image" class="icon"></i>
                <span>Galeri Desa</span>
                <span class="ml-auto text-[10px] bg-slate-100 text-slate-500 font-bold px-1.5 py-0.5 rounded-md">{{ \App\Models\Galeri::count() }}</span>
            </a>
            <a href="{{ route('admin.berita.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}">
                <i data-lucide="newspaper" class="icon"></i>
                <span>Berita Desa</span>
                <span class="ml-auto text-xs bg-emerald-600 text-white font-bold px-1.5 py-0.5 rounded-md">{{ \App\Models\Berita::count() }}</span>
            </a>
            <a href="{{ route('admin.pengaturan.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.pengaturan.*') ? 'active' : '' }}">
                <i data-lucide="settings-2" class="icon"></i>
                <span>Pengaturan</span>
            </a>
            <a href="{{ route('admin.kelola-admin.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.kelola-admin.*') ? 'active' : '' }}">
                <i data-lucide="user-plus" class="icon"></i>
                <span>Kelola Admin</span>
            </a>

            <div class="pt-3 mt-3 border-t border-slate-100">
                <a href="{{ route('home') }}" target="_blank" class="sidebar-link text-slate-400">
                    <i data-lucide="external-link" class="icon"></i>
                    <span>Lihat Website</span>
                </a>
            </div>
        </nav>

        <!-- User footer -->
        <div class="px-3 py-4 border-t border-slate-100 flex-shrink-0">
            <div class="flex items-center gap-3 px-2 py-2.5 rounded-xl hover:bg-slate-50 transition-all">
                <div class="w-8 h-8 rounded-full bg-forest-800 flex items-center justify-center text-white font-bold text-xs flex-shrink-0 shadow-sm">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-slate-800 truncate leading-tight">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-slate-400 truncate">{{ auth()->user()->email }}</p>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" title="Logout"
                        class="w-7 h-7 flex items-center justify-center rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 transition-colors">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Sidebar Overlay (mobile) -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40 hidden lg:hidden" onclick="closeSidebar()"></div>

    <!-- ══════════════ MAIN CONTENT ══════════════ -->
    <div class="flex-1 flex flex-col min-h-screen lg:pl-[220px]">

        <!-- Topbar -->
        <header class="h-[60px] bg-white border-b border-slate-200 flex items-center px-4 sm:px-6 flex-shrink-0 sticky top-0 z-30 shadow-sm">
            <button onclick="toggleSidebar()" class="lg:hidden mr-3 w-8 h-8 flex items-center justify-center rounded-lg text-slate-500 hover:bg-slate-100 transition-all">
                <i data-lucide="menu" class="w-5 h-5"></i>
            </button>

            <div class="flex-1 min-w-0">
                <h1 class="font-display font-bold text-sm text-slate-900 truncate">@yield('page_title', 'Dashboard')</h1>
                <p class="text-[11px] text-slate-400 truncate hidden sm:block">@yield('page_subtitle', 'Panel Admin Desa Jambelaer')</p>
            </div>

            <div class="flex items-center gap-3 sm:gap-4 flex-shrink-0 ml-auto">
                <!-- Notif bell / Mail -->
                <a href="{{ route('admin.pesan.index') }}" class="relative w-9 h-9 flex items-center justify-center rounded-xl text-slate-400 hover:bg-slate-100 hover:text-slate-700 transition-all" title="Pesan Masuk">
                    <i data-lucide="mail" class="w-4 h-4"></i>
                    @if(\App\Models\Pesan::where('is_read', false)->count() > 0)
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-amber-500 rounded-full ring-2 ring-white"></span>
                    @endif
                </a>

                <div class="h-5 w-px bg-slate-200 hidden sm:block"></div>

                <!-- Admin Aktif -->
                @if(auth()->check())
                <div class="flex items-center gap-2.5 bg-slate-100 border border-slate-200 rounded-xl px-3 py-1.5 shadow-xs">
                    <div class="relative">
                        <div class="w-7 h-7 rounded-lg bg-forest-800 flex items-center justify-center text-white font-bold text-xs shadow">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                        <span class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-emerald-500 border-2 border-white rounded-full" title="Status: Online"></span>
                    </div>
                    <div class="hidden sm:block text-left">
                        <div class="text-xs font-semibold text-slate-800 leading-tight">
                            {{ auth()->user()->name }}
                        </div>
                        <span class="text-[10px] text-emerald-600 font-medium flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            Admin Aktif
                        </span>
                    </div>
                </div>
                @endif
            </div>
        </header>

        <!-- Flash Messages -->
        <div class="px-4 sm:px-6 pt-4 space-y-2">
            @if(session('success'))
            <div class="flex items-center gap-3 p-3.5 rounded-xl bg-forest-50 border border-forest-200 text-forest-700 text-sm">
                <i data-lucide="check-circle-2" class="w-4 h-4 flex-shrink-0 text-forest-600"></i>
                <span class="flex-1 text-sm">{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-forest-400 hover:text-forest-600">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
            @endif
            @if(session('error'))
            <div class="flex items-center gap-3 p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-600 text-sm">
                <i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0"></i>
                <span class="flex-1 text-sm">{{ session('error') }}</span>
                <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
            @endif
        </div>

        <!-- Page Content -->
        <main class="flex-1 p-4 sm:p-6">
            @yield('content')
        </main>

        <footer class="px-6 py-3 text-center text-[11px] text-slate-400 border-t border-slate-200">
            Panel Admin © {{ date('Y') }} · Pemerintah Desa Jambelaer
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        function closeSidebar() {
            document.getElementById('sidebar').classList.add('-translate-x-full');
            document.getElementById('sidebar-overlay').classList.add('hidden');
        }
    </script>

    @stack('scripts')
</body>
</html>
