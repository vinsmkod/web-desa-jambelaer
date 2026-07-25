<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Website Resmi Desa Jambelaer') - Kecamatan Dawuan, Subang</title>
    <meta name="description" content="@yield('meta_desc', 'Portal Resmi Desa Jambelaer, Kecamatan Dawuan, Kabupaten Subang. Temukan informasi tentang profil desa, kebudayaan lokal, produk UMKM unggulan, dan kontak kami.')">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&family=Lora:ital,wght@0,400;0,600;1,400;1,600&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Tailwind CSS v4 Play CDN -->
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

    <style type="text/tailwindcss">
        @theme {
            /* Typography */
            --font-sans:    'Inter', ui-sans-serif, system-ui, sans-serif;
            --font-display: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;
            --font-serif:   'Lora', ui-serif, Georgia, serif;

            /* ── Forest Green Scale ── */
            --color-forest-950: #071a10;
            --color-forest-900: #0d2b1d;
            --color-forest-800: #1a4731;
            --color-forest-700: #245e3f;
            --color-forest-600: #2d7a52;
            --color-forest-500: #3d9b69;
            --color-forest-400: #5db886;
            --color-forest-200: #aeddc4;
            --color-forest-100: #d6efdf;
            --color-forest-50:  #f0f9f3;

            /* ── Warm Sand / Stone Scale ── */
            --color-sand-900:  #4a3520;
            --color-sand-700:  #7a5c30;
            --color-sand-500:  #b88a48;
            --color-sand-400:  #c9a06a;
            --color-sand-300:  #d9ba92;
            --color-sand-200:  #e8d5b0;
            --color-sand-100:  #f2e8d0;
            --color-sand-50:   #faf4e8;

            /* ── Page Background ── */
            --color-page:      #fdfaf5;
            --color-surface:   #ffffff;
        }

        /* ── Base ── */
        html { scroll-behavior: smooth; }
        body { background-color: var(--color-page); }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track  { background: #fdfaf5; }
        ::-webkit-scrollbar-thumb  { background: #c9a06a; border-radius: 99px; }
        ::-webkit-scrollbar-thumb:hover { background: #b88a48; }

        /* ── Reveal Animation ── */
        .reveal-on-scroll {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity 0.7s cubic-bezier(0.16,1,0.3,1),
                        transform 0.7s cubic-bezier(0.16,1,0.3,1);
        }
        .reveal-on-scroll.active { opacity: 1; transform: translateY(0); }
        .delay-100 { transition-delay: 100ms; }
        .delay-200 { transition-delay: 200ms; }
        .delay-300 { transition-delay: 300ms; }

        /* ── Navbar Active Underline ── */
        .nav-link-active {
            color: #1a4731;
            font-weight: 600;
            position: relative;
        }
        .nav-link-active::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            right: 0;
            height: 2px;
            background: #b88a48;
            border-radius: 99px;
        }
        .nav-link-hover {
            color: #57534e;
            font-weight: 500;
            position: relative;
            transition: color 0.2s;
        }
        .nav-link-hover::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            right: 0;
            height: 2px;
            background: transparent;
            border-radius: 99px;
            transition: background 0.2s;
        }
        .nav-link-hover:hover { color: #1a4731; }
        .nav-link-hover:hover::after { background: #b88a48; }

        /* ── Section Label Pill ── */
        .section-label {
            display: inline-block;
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #1a4731;
            background-color: #d6efdf;
            padding: 4px 12px;
            border-radius: 99px;
            border: 1px solid #aeddc4;
        }

        /* ── Divider Bar ── */
        .section-divider {
            width: 48px;
            height: 3px;
            background: linear-gradient(90deg, #1a4731, #b88a48);
            border-radius: 99px;
            margin: 14px auto 0;
        }

        /* ── Buttons ── */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 28px;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: #ffffff;
            background-color: #1a4731;
            border: 2px solid #1a4731;
            border-radius: 9999px;
            transition: all 0.2s;
            text-decoration: none;
        }
        .btn-primary:hover {
            background-color: #245e3f;
            border-color: #245e3f;
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(26,71,49,0.25);
        }
        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 28px;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: #1a4731;
            background-color: transparent;
            border: 2px solid #1a4731;
            border-radius: 9999px;
            transition: all 0.2s;
            text-decoration: none;
        }
        .btn-secondary:hover {
            background-color: #1a4731;
            color: #ffffff;
            transform: translateY(-1px);
        }

        /* ── Paper Texture Overlay ── */
        .paper-bg {
            background-color: #fdfaf5;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='4' height='4'%3E%3Crect width='4' height='4' fill='%23fdfaf5'/%3E%3Crect x='0' y='0' width='1' height='1' fill='%23f5ead6' opacity='0.3'/%3E%3C/svg%3E");
        }

        /* ── Card Style ── */
        .card-village {
            background: #ffffff;
            border: 1px solid #e7e5e4;
            border-radius: 24px;
            transition: all 0.25s ease;
        }
        .card-village:hover {
            border-color: #aeddc4;
            box-shadow: 0 6px 24px rgba(26,71,49,0.09);
            transform: translateY(-2px);
        }
    </style>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    @stack('head')
</head>

<body class="font-sans text-stone-800 paper-bg antialiased overflow-x-hidden">

    <!-- ══════════════════════════ NAVBAR ══════════════════════════ -->
    <header id="main-header" class="fixed top-0 left-0 w-full z-50 bg-white border-b border-stone-200 transition-shadow duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-18 py-3">

                <!-- Brand -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 rounded-lg bg-forest-800 flex items-center justify-center shadow-sm group-hover:bg-forest-700 transition-colors duration-200 flex-shrink-0">
                        <i data-lucide="wheat" class="w-5 h-5 text-sand-300"></i>
                    </div>
                    <div class="leading-tight">
                        <span class="font-display font-extrabold text-base sm:text-lg tracking-tight text-forest-900 block leading-none">DESA JAMBELAER</span>
                        <span class="text-[10px] text-sand-700 font-semibold tracking-widest uppercase block mt-0.5">Kec. Dawuan · Kab. Subang</span>
                    </div>
                </a>

                <!-- Desktop Menu -->
                <nav class="hidden md:flex items-center space-x-7">
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home')    ? 'nav-link-active' : 'nav-link-hover' }} font-display text-sm pb-1">Beranda</a>
                    <a href="{{ route('tentang') }}" class="{{ request()->routeIs('tentang') ? 'nav-link-active' : 'nav-link-hover' }} font-display text-sm pb-1">Tentang</a>
                    <a href="{{ route('umkm') }}" class="{{ request()->routeIs('umkm*')   ? 'nav-link-active' : 'nav-link-hover' }} font-display text-sm pb-1">UMKM</a>
                    <a href="{{ route('budaya') }}" class="{{ request()->routeIs('budaya*') ? 'nav-link-active' : 'nav-link-hover' }} font-display text-sm pb-1">Budaya</a>
                    <a href="{{ route('galeri') }}" class="{{ request()->routeIs('galeri*') ? 'nav-link-active' : 'nav-link-hover' }} font-display text-sm pb-1">Galeri</a>
                    <a href="{{ route('acara') }}" class="{{ request()->routeIs('acara')   ? 'nav-link-active' : 'nav-link-hover' }} font-display text-sm pb-1">Acara</a>
                </nav>

                <!-- CTA -->
                <div class="hidden md:flex items-center">
                    <a href="{{ route('kontak') }}" class="btn-primary text-[11px] py-2.5 px-5">
                        <i data-lucide="phone" class="w-3.5 h-3.5 mr-2"></i>
                        Hubungi Kami
                    </a>
                </div>

                <!-- Mobile Toggle -->
                <button id="mobile-menu-btn" type="button"
                    class="md:hidden inline-flex items-center justify-center p-2 rounded-lg text-stone-600 hover:bg-forest-50 focus:outline-none transition-colors duration-200"
                    aria-controls="mobile-menu" aria-expanded="false">
                    <i id="hamburger-icon" data-lucide="menu" class="w-6 h-6"></i>
                    <i id="close-icon" data-lucide="x" class="w-6 h-6 hidden"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-stone-100 bg-white py-3">
            <div class="px-4 space-y-0.5">
                <a href="{{ route('home') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-semibold text-stone-700 hover:bg-forest-50 hover:text-forest-800 transition-all">Beranda</a>
                <a href="{{ route('tentang') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-semibold text-stone-700 hover:bg-forest-50 hover:text-forest-800 transition-all">Tentang</a>
                <a href="{{ route('umkm') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-semibold text-stone-700 hover:bg-forest-50 hover:text-forest-800 transition-all">UMKM</a>
                <a href="{{ route('budaya') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-semibold text-stone-700 hover:bg-forest-50 hover:text-forest-800 transition-all">Budaya</a>
                <a href="{{ route('galeri') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-semibold text-stone-700 hover:bg-forest-50 hover:text-forest-800 transition-all">Galeri</a>
                <a href="{{ route('acara') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-semibold text-stone-700 hover:bg-forest-50 hover:text-forest-800 transition-all">Acara</a>
                <div class="pt-3 pb-1 px-1">
                    <a href="{{ route('kontak') }}" class="btn-primary w-full justify-center text-[11px] py-3">
                        <i data-lucide="phone" class="w-3.5 h-3.5 mr-2"></i>
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- ══════════════════════════ PAGE CONTENT ══════════════════════════ -->
    <main class="pt-[72px]">
        @yield('content')
    </main>

    <!-- ══════════════════════════ FOOTER ══════════════════════════ -->
    <footer class="bg-forest-900 text-white mt-16 rounded-none overflow-hidden">
        <!-- Zone 1: Main Footer Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 pb-10 border-b border-white/10">

                <!-- Brand + Tagline -->
                <div class="lg:col-span-5 space-y-5">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-lg bg-forest-700 border border-forest-600 flex items-center justify-center">
                            <i data-lucide="wheat" class="w-5 h-5 text-sand-300"></i>
                        </div>
                        <div>
                            <span class="font-display font-extrabold text-base text-white block leading-tight">Pemerintah Desa Jambelaer</span>
                            <span class="text-[10px] text-sand-400 tracking-widest uppercase">Kecamatan Dawuan · Kabupaten Subang</span>
                        </div>
                    </div>
                    <p class="text-sm text-white/50 leading-relaxed max-w-sm font-light">
                        Portal layanan dan profil resmi Desa Jambelaer. Memajukan desa melalui digitalisasi potensi pariwisata, budaya lokal, dan produk UMKM unggulan daerah.
                    </p>
                    <!-- Social Icons -->
                    @php
                    $footerIg = \App\Models\Pengaturan::get('sosmed_instagram', '');
                    $footerYt = \App\Models\Pengaturan::get('sosmed_youtube', '');
                    $footerTt = \App\Models\Pengaturan::get('sosmed_tiktok', '');
                    @endphp
                    <div class="flex items-center flex-wrap gap-2 pt-1">

                        @if($footerIg)
                        <a href="{{ str_starts_with($footerIg, 'http') ? $footerIg : 'https://'.$footerIg }}" target="_blank" rel="noopener" title="Instagram Desa"
                            class="w-8 h-8 rounded border border-white/10 bg-white/5 flex items-center justify-center hover:bg-pink-600 hover:border-pink-600 transition-all text-white/60 hover:text-white">
                            <i data-lucide="instagram" class="w-3.5 h-3.5"></i>
                        </a>
                        @else
                        <span class="w-8 h-8 rounded border border-white/5 bg-white/5 flex items-center justify-center text-white/20" title="Instagram belum diatur">
                            <i data-lucide="instagram" class="w-3.5 h-3.5"></i>
                        </span>
                        @endif

                        @if($footerYt)
                        <a href="{{ str_starts_with($footerYt, 'http') ? $footerYt : 'https://'.$footerYt }}" target="_blank" rel="noopener" title="YouTube Desa"
                            class="w-8 h-8 rounded border border-white/10 bg-white/5 flex items-center justify-center hover:bg-red-600 hover:border-red-600 transition-all text-white/60 hover:text-white">
                            <i data-lucide="youtube" class="w-3.5 h-3.5"></i>
                        </a>
                        @else
                        <span class="w-8 h-8 rounded border border-white/5 bg-white/5 flex items-center justify-center text-white/20" title="YouTube belum diatur">
                            <i data-lucide="youtube" class="w-3.5 h-3.5"></i>
                        </span>
                        @endif

                        @if($footerTt)
                        <a href="{{ str_starts_with($footerTt, 'http') ? $footerTt : 'https://'.$footerTt }}" target="_blank" rel="noopener" title="TikTok Desa"
                            class="w-8 h-8 rounded border border-white/10 bg-white/5 flex items-center justify-center hover:bg-stone-700 hover:border-stone-700 transition-all text-white/60 hover:text-white">
                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.32 6.32 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.33-6.34V8.69a8.18 8.18 0 0 0 4.78 1.52V6.76a4.85 4.85 0 0 1-1.01-.07z" />
                            </svg>
                        </a>
                        @else
                        <span class="w-8 h-8 rounded border border-white/5 bg-white/5 flex items-center justify-center text-white/20" title="TikTok belum diatur">
                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.32 6.32 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.33-6.34V8.69a8.18 8.18 0 0 0 4.78 1.52V6.76a4.85 4.85 0 0 1-1.01-.07z" />
                            </svg>
                        </span>
                        @endif
                    </div>
                </div>

                <!-- Nav Links -->
                <div class="lg:col-span-3 space-y-4">
                    <h4 class="font-display font-bold text-xs tracking-widest uppercase text-sand-400">Navigasi</h4>
                    <ul class="space-y-2.5">
                        <li><a href="{{ route('home') }}" class="text-sm text-white/50 hover:text-sand-300 font-light transition-colors flex items-center gap-2"><i data-lucide="chevron-right" class="w-3 h-3"></i>Beranda</a></li>
                        <li><a href="{{ route('tentang') }}" class="text-sm text-white/50 hover:text-sand-300 font-light transition-colors flex items-center gap-2"><i data-lucide="chevron-right" class="w-3 h-3"></i>Tentang Kami</a></li>
                        <li><a href="{{ route('umkm') }}" class="text-sm text-white/50 hover:text-sand-300 font-light transition-colors flex items-center gap-2"><i data-lucide="chevron-right" class="w-3 h-3"></i>UMKM Desa</a></li>
                        <li><a href="{{ route('budaya') }}" class="text-sm text-white/50 hover:text-sand-300 font-light transition-colors flex items-center gap-2"><i data-lucide="chevron-right" class="w-3 h-3"></i>Budaya & Seni</a></li>
                        <li><a href="{{ route('galeri') }}" class="text-sm text-white/50 hover:text-sand-300 font-light transition-colors flex items-center gap-2"><i data-lucide="chevron-right" class="w-3 h-3"></i>Galeri Foto</a></li>
                        <li><a href="{{ route('acara') }}" class="text-sm text-white/50 hover:text-sand-300 font-light transition-colors flex items-center gap-2"><i data-lucide="chevron-right" class="w-3 h-3"></i>Acara & Kegiatan</a></li>
                        <li><a href="{{ route('kontak') }}" class="text-sm text-white/50 hover:text-sand-300 font-light transition-colors flex items-center gap-2"><i data-lucide="chevron-right" class="w-3 h-3"></i>Hubungi Kami</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="lg:col-span-4 space-y-4">
                    <h4 class="font-display font-bold text-xs tracking-widest uppercase text-sand-400">Kontak & Lokasi</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start space-x-3">
                            <div class="w-8 h-8 rounded bg-white/5 border border-white/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i data-lucide="map-pin" class="w-3.5 h-3.5 text-sand-400"></i>
                            </div>
                            <div>
                                <span class="text-[10px] text-sand-500 font-semibold tracking-wider uppercase block">Alamat</span>
                                <span class="text-sm text-white/60 font-light leading-relaxed">Jl. Raya Jambelaer, Dawuan, Subang, Jawa Barat 41270</span>
                            </div>
                        </li>
                        <li class="flex items-start space-x-3">
                            <div class="w-8 h-8 rounded bg-white/5 border border-white/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i data-lucide="phone" class="w-3.5 h-3.5 text-sand-400"></i>
                            </div>
                            <div>
                                <span class="text-[10px] text-sand-500 font-semibold tracking-wider uppercase block">Telepon</span>
                                <span class="text-sm text-white/60 font-light">{{ \App\Models\Pengaturan::get('kontak_telp', '(0260) 123456') }}</span>
                            </div>
                        </li>
                        <li class="flex items-start space-x-3">
                            <div class="w-8 h-8 rounded bg-white/5 border border-white/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i data-lucide="mail" class="w-3.5 h-3.5 text-sand-400"></i>
                            </div>
                            <div>
                                <span class="text-[10px] text-sand-500 font-semibold tracking-wider uppercase block">Email</span>
                                <span class="text-sm text-white/60 font-light">{{ \App\Models\Pengaturan::get('kontak_email', 'info@jambelaer-subang.desa.id') }}</span>
                            </div>
                        </li>
                        <li class="flex items-start space-x-3">
                            <div class="w-8 h-8 rounded bg-white/5 border border-white/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i data-lucide="clock" class="w-3.5 h-3.5 text-sand-400"></i>
                            </div>
                            <div>
                                <span class="text-[10px] text-sand-500 font-semibold tracking-wider uppercase block">Jam Layanan</span>
                                <span class="text-sm text-white/60 font-light">Sen – Jum: 08.00 – 15.30 WIB</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Row -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-white/30 font-light">
                <p>© {{ date('Y') }} Pemerintah Desa Jambelaer · Kecamatan Dawuan · Kabupaten Subang</p>
                <div class="flex items-center divide-x divide-white/10 text-white/25">
                    <a href="#" class="hover:text-sand-400 transition-colors pr-4">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-sand-400 transition-colors px-4">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top -->
    <button id="back-to-top"
        class="fixed bottom-6 right-6 w-10 h-10 rounded-full bg-forest-800 text-white shadow-lg flex items-center justify-center transition-all duration-300 transform translate-y-16 opacity-0 z-40 focus:outline-none cursor-pointer hover:bg-forest-700 hover:shadow-xl">
        <i data-lucide="arrow-up" class="w-4 h-4"></i>
    </button>

    <!-- ══════════════════════════ SHARED SCRIPTS ══════════════════════════ -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Init Lucide icons
            lucide.createIcons();

            // Sticky Navbar shadow on scroll
            const header = document.getElementById('main-header');
            const backToTop = document.getElementById('back-to-top');

            window.addEventListener('scroll', function() {
                if (window.scrollY > 30) {
                    header.classList.add('shadow-md');
                } else {
                    header.classList.remove('shadow-md');
                }
                if (window.scrollY > 400) {
                    backToTop.classList.remove('translate-y-16', 'opacity-0');
                    backToTop.classList.add('translate-y-0', 'opacity-100');
                } else {
                    backToTop.classList.remove('translate-y-0', 'opacity-100');
                    backToTop.classList.add('translate-y-16', 'opacity-0');
                }
            });

            backToTop.addEventListener('click', () => window.scrollTo({
                top: 0,
                behavior: 'smooth'
            }));

            // Mobile Menu Toggle
            const mobileBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            const hamburger = document.getElementById('hamburger-icon');
            const closeIcon = document.getElementById('close-icon');

            mobileBtn.addEventListener('click', function() {
                const expanded = mobileBtn.getAttribute('aria-expanded') === 'true';
                mobileBtn.setAttribute('aria-expanded', !expanded);
                mobileMenu.classList.toggle('hidden');
                hamburger.classList.toggle('hidden');
                closeIcon.classList.toggle('hidden');
            });

            // Scroll Reveal
            const revealEls = document.querySelectorAll('.reveal-on-scroll');
            const observer = new IntersectionObserver((entries, obs) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                        entry.target.querySelectorAll('[data-target]').forEach(animateCounter);
                        obs.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.12,
                rootMargin: '0px 0px -40px 0px'
            });

            revealEls.forEach(el => observer.observe(el));

            function animateCounter(el) {
                const targetAttr = el.getAttribute('data-target');
                if (!targetAttr) return;

                const hasComma = targetAttr.includes(',');
                let rawValue = targetAttr;
                if (hasComma) {
                    rawValue = rawValue.replace(/\./g, '').replace(',', '.');
                } else {
                    rawValue = rawValue.replace(/,/g, '');
                }

                const target = parseFloat(rawValue);
                if (isNaN(target)) {
                    el.textContent = targetAttr;
                    return;
                }

                const start = performance.now();
                const duration = 1800;
                (function update(now) {
                    const t = Math.min((now - start) / duration, 1);
                    const ease = 1 - Math.pow(1 - t, 3);
                    const current = ease * target;

                    if (hasComma) {
                        const decimalPart = targetAttr.split(',')[1] || '';
                        const decimalPlaces = decimalPart.length;
                        el.textContent = current.toLocaleString('id-ID', {
                            minimumFractionDigits: decimalPlaces,
                            maximumFractionDigits: decimalPlaces
                        });
                    } else if (Number.isInteger(target)) {
                        el.textContent = Math.floor(current).toLocaleString('id-ID');
                    } else {
                        el.textContent = current.toLocaleString('id-ID', {
                            minimumFractionDigits: 1,
                            maximumFractionDigits: 3
                        });
                    }

                    if (t < 1) requestAnimationFrame(update);
                    else el.textContent = targetAttr;
                })(start);
            }
        });
    </script>

    @stack('scripts')
</body>

</html>