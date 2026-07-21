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
        }

        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track  { background: #0f172a; }
        ::-webkit-scrollbar-thumb  { background: #334155; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #475569; }

        .sidebar-link {
            @apply flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-400 hover:bg-slate-800 hover:text-white transition-all duration-200;
        }
        .sidebar-link.active {
            @apply bg-emerald-600/20 text-emerald-400 font-semibold;
        }
        .sidebar-link .icon {
            @apply w-5 h-5 flex-shrink-0;
        }

        .stat-card {
            @apply bg-slate-800/50 border border-slate-700/50 rounded-2xl p-5 flex items-start gap-4;
        }
        .form-input {
            @apply w-full px-4 py-2.5 bg-slate-800 border border-slate-700 rounded-xl text-sm text-slate-100 placeholder-slate-500 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all;
        }
        .form-label {
            @apply block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5;
        }
        .btn-primary {
            @apply inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-semibold rounded-xl transition-all duration-200;
        }
        .btn-danger {
            @apply inline-flex items-center gap-2 px-4 py-2 bg-red-600/20 hover:bg-red-600 text-red-400 hover:text-white text-xs font-semibold rounded-lg transition-all duration-200;
        }
        .badge-read {
            @apply inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-600/20 text-emerald-400;
        }
        .badge-unread {
            @apply inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-amber-600/20 text-amber-400;
        }
    </style>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    @stack('head')
</head>
<body class="h-full bg-slate-950 text-slate-100 font-sans antialiased flex">

    <!-- ══════════════ SIDEBAR ══════════════ -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 border-r border-slate-800 flex flex-col transition-transform duration-300 -translate-x-full lg:translate-x-0">

        <!-- Brand -->
        <div class="flex items-center gap-3 px-5 h-16 border-b border-slate-800 flex-shrink-0">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-emerald-700 to-emerald-500 flex items-center justify-center shadow-md">
                <i data-lucide="map" class="w-4 h-4 text-white"></i>
            </div>
            <div>
                <span class="font-display font-bold text-sm text-white block leading-tight">Desa Jambelaer</span>
                <span class="text-xs text-slate-500 block">Panel Admin</span>
            </div>
        </div>

        <!-- Nav -->
        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            <p class="px-3 text-xs font-bold tracking-widest uppercase text-slate-600 mb-2">Menu Utama</p>

            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i data-lucide="layout-dashboard" class="icon"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.produk.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.produk.*') ? 'active' : '' }}">
                <i data-lucide="package" class="icon"></i>
                <span>Produk UMKM</span>
                <span class="ml-auto text-xs bg-emerald-600 text-white font-bold px-1.5 py-0.5 rounded-md">{{ \App\Models\Produk::count() }}</span>
            </a>
            <a href="{{ route('admin.pesan.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.pesan.*') ? 'active' : '' }}">
                <i data-lucide="mail" class="icon"></i>
                <span>Pesan Masuk</span>
                @php $unread = \App\Models\Pesan::where('is_read', false)->where('jenis_pesan', '!=', 'pengajuan_acara')->count(); @endphp
                @if($unread > 0)
                <span class="ml-auto text-xs bg-amber-500 text-white font-bold px-1.5 py-0.5 rounded-md">{{ $unread }}</span>
                @endif
            </a>
            <a href="{{ route('admin.pengajuan-acara.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.pengajuan-acara.*') ? 'active' : '' }}">
                <i data-lucide="calendar" class="icon"></i>
                <span>Pengajuan Acara</span>
                @php $unreadAcara = \App\Models\Pesan::where('jenis_pesan', 'pengajuan_acara')->where('status', 'menunggu')->count(); @endphp
                @if($unreadAcara > 0)
                <span class="ml-auto text-xs bg-amber-500 text-white font-bold px-1.5 py-0.5 rounded-md">{{ $unreadAcara }}</span>
                @endif
            </a>
            <a href="{{ route('admin.tentang.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.tentang.*') ? 'active' : '' }}">
                <i data-lucide="info" class="icon"></i>
                <span>Tentang Kami</span>
            </a>
            <a href="{{ route('admin.budaya.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.budaya.*') ? 'active' : '' }}">
                <i data-lucide="music" class="icon"></i>
                <span>Budaya Desa</span>
                <span class="ml-auto text-xs bg-emerald-600 text-white font-bold px-1.5 py-0.5 rounded-md">{{ \App\Models\Budaya::count() }}</span>
            </a>
            <a href="{{ route('admin.galeri.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.galeri.*') ? 'active' : '' }}">
                <i data-lucide="image" class="icon"></i>
                <span>Galeri Desa</span>
                <span class="ml-auto text-xs bg-emerald-600 text-white font-bold px-1.5 py-0.5 rounded-md">{{ \App\Models\Galeri::count() }}</span>
            </a>
            <a href="{{ route('admin.pengaturan.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.pengaturan.*') ? 'active' : '' }}">
                <i data-lucide="settings" class="icon"></i>
                <span>Pengaturan</span>
            </a>

            <div class="pt-4 mt-4 border-t border-slate-800">
                <p class="px-3 text-xs font-bold tracking-widest uppercase text-slate-600 mb-2">Website</p>
                <a href="{{ route('home') }}" target="_blank"
                   class="sidebar-link">
                    <i data-lucide="external-link" class="icon"></i>
                    <span>Lihat Website</span>
                </a>
            </div>
        </nav>

        <!-- User -->
        <div class="px-3 py-4 border-t border-slate-800 flex items-center gap-3 flex-shrink-0">
            <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-emerald-600 to-emerald-400 flex items-center justify-center text-white font-bold text-xs flex-shrink-0">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email }}</p>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" title="Logout"
                    class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-500 hover:bg-red-600/20 hover:text-red-400 transition-all">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                </button>
            </form>
        </div>
    </aside>

    <!-- Sidebar Overlay (mobile) -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/60 z-40 hidden lg:hidden" onclick="closeSidebar()"></div>

    <!-- ══════════════ MAIN CONTENT ══════════════ -->
    <div class="flex-1 flex flex-col min-h-screen lg:pl-64">

        <!-- Topbar -->
        <header class="h-16 bg-slate-900/80 backdrop-blur-md border-b border-slate-800 flex items-center px-4 sm:px-6 flex-shrink-0 sticky top-0 z-30">
            <button onclick="toggleSidebar()" class="lg:hidden mr-3 w-9 h-9 flex items-center justify-center rounded-lg text-slate-400 hover:bg-slate-800 transition-all">
                <i data-lucide="menu" class="w-5 h-5"></i>
            </button>

            <div class="flex-1">
                <h1 class="font-display font-bold text-base text-white">@yield('page_title', 'Dashboard')</h1>
                <p class="text-xs text-slate-500">@yield('page_subtitle', 'Panel Admin Desa Jambelaer')</p>
            </div>

            <div class="flex items-center gap-3">
                <!-- Notification Bell -->
                <button class="relative w-9 h-9 flex items-center justify-center rounded-lg text-slate-400 hover:bg-slate-800 transition-all">
                    <i data-lucide="bell" class="w-5 h-5"></i>
                    @if(\App\Models\Pesan::where('is_read', false)->count() > 0)
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-amber-500 rounded-full"></span>
                    @endif
                </button>
                <div class="h-6 w-px bg-slate-700"></div>
                <span class="text-xs text-slate-400 hidden sm:block">{{ now()->translatedFormat('d M Y') }}</span>
            </div>
        </header>

        <!-- Flash Messages -->
        <div class="px-4 sm:px-6 pt-4">
            @if(session('success'))
            <div class="flex items-center gap-3 p-4 rounded-xl bg-emerald-600/10 border border-emerald-600/30 text-emerald-400 text-sm mb-0">
                <i data-lucide="check-circle" class="w-5 h-5 flex-shrink-0"></i>
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="ml-auto text-emerald-600 hover:text-emerald-400">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
            @endif
            @if(session('error'))
            <div class="flex items-center gap-3 p-4 rounded-xl bg-red-600/10 border border-red-600/30 text-red-400 text-sm mb-0">
                <i data-lucide="alert-circle" class="w-5 h-5 flex-shrink-0"></i>
                <span>{{ session('error') }}</span>
                <button onclick="this.parentElement.remove()" class="ml-auto text-red-600 hover:text-red-400">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
            @endif
        </div>

        <!-- Page Content -->
        <main class="flex-1 p-4 sm:p-6">
            @yield('content')
        </main>

        <footer class="px-6 py-4 text-center text-xs text-slate-600 border-t border-slate-800">
            Panel Admin © {{ date('Y') }} Pemerintah Desa Jambelaer
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            lucide.createIcons();
        });

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }
    </script>

    @stack('scripts')
</body>
</html>
