<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        // â”€â”€ SEO Globals â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        $siteName    = 'Sistem Informasi Desa Jambelaer';
        $siteUrl     = config('app.url', 'https://desajambelaer.sainzlab.my.id');
        $defaultImg  = $siteUrl . '/' . ltrim(asset('uploads/img/DESA_JAMBELAER.png'), '/');
        // Normalize default image URL (avoid double domain)
        $defaultImg  = $siteUrl . '/uploads/img/DESA_JAMBELAER.png';

        $pageTitle   = trim(View::yieldContent('title'));
        $metaDesc    = trim(View::yieldContent('meta_desc'));
        $ogImage     = trim(View::yieldContent('og_image'));
        $ogType      = trim(View::yieldContent('og_type'))   ?: 'website';
        $metaRobots  = trim(View::yieldContent('meta_robots')) ?: 'index, follow';

        // Build final title
        if ($pageTitle) {
            $fullTitle = $pageTitle . ' | ' . $siteName;
        } else {
            $fullTitle = $siteName . ' â€” Portal Resmi Desa Jambelaer, Kecamatan Dawuan, Kabupaten Subang';
        }

        // Build canonical URL (use section if provided, else current URL without query)
        $canonical   = trim(View::yieldContent('canonical'));
        if (!$canonical) {
            $canonical = url(parse_url(request()->getRequestUri(), PHP_URL_PATH));
        }

        // Build description
        if (!$metaDesc) {
            $metaDesc = 'Portal resmi Desa Jambelaer, Kecamatan Dawuan, Kabupaten Subang, Jawa Barat. Informasi profil desa, berita, UMKM, wisata, budaya, galeri, dan layanan publik desa.';
        }

        // OG Image fallback
        if (!$ogImage) {
            $ogImage = $defaultImg;
        }
    @endphp

    <!-- Primary Meta Tags -->
    <title>{{ $fullTitle }}</title>
    <meta name="description" content="{{ Str::limit($metaDesc, 160) }}">
    <meta name="robots" content="{{ $metaRobots }}">
    <meta name="language" content="Indonesian">
    <meta name="author" content="Pemerintah Desa Jambelaer">
    <meta name="geo.region" content="ID-JB">
    <meta name="geo.placename" content="Desa Jambelaer, Kecamatan Dawuan, Kabupaten Subang, Jawa Barat">

    <!-- hreflang -->
    <link rel="alternate" hreflang="id" href="{{ $canonical }}">
    <link rel="alternate" hreflang="x-default" href="{{ $canonical }}">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ $canonical }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type"         content="{{ $ogType }}">
    <meta property="og:site_name"    content="{{ $siteName }}">
    <meta property="og:url"          content="{{ $canonical }}">
    <meta property="og:title"        content="{{ $fullTitle }}">
    <meta property="og:description" content="{{ Str::limit($metaDesc, 200) }}">
    <meta property="og:image"        content="{{ $ogImage }}">
    <meta property="og:image:width"  content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:locale"       content="id_ID">

    <!-- Twitter Card -->
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="{{ $fullTitle }}">
    <meta name="twitter:description" content="{{ Str::limit($metaDesc, 200) }}">
    <meta name="twitter:image"       content="{{ $ogImage }}">
    <meta name="twitter:site"        content="@DesaJambelaer">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&family=Lora:ital,wght@0,400;0,600;1,400;1,600&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Animate On Scroll (AOS) CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <!-- Tailwind CSS v4 Play CDN -->
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

    <style type="text/tailwindcss">
        @theme {
            /* Typography */
            --font-sans:    'Inter', ui-sans-serif, system-ui, sans-serif;
            --font-display: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;
            --font-serif:   'Lora', ui-serif, Georgia, serif;

            /* â”€â”€ Forest Green Scale â”€â”€ */
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

            /* â”€â”€ Warm Sand / Stone Scale â”€â”€ */
            --color-sand-900:  #4a3520;
            --color-sand-700:  #7a5c30;
            --color-sand-500:  #b88a48;
            --color-sand-400:  #c9a06a;
            --color-sand-300:  #d9ba92;
            --color-sand-200:  #e8d5b0;
            --color-sand-100:  #f2e8d0;
            --color-sand-50:   #faf4e8;

            /* â”€â”€ Page Background â”€â”€ */
            --color-page:      #fdfaf5;
            --color-surface:   #ffffff;
        }

        /* â”€â”€ Base â”€â”€ */
        html { scroll-behavior: smooth; }
        body { background-color: var(--color-page); }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track  { background: #fdfaf5; }
        ::-webkit-scrollbar-thumb  { background: #c9a06a; border-radius: 99px; }
        ::-webkit-scrollbar-thumb:hover { background: #b88a48; }

        /* â”€â”€ Reveal & Animate on Scroll â”€â”€ */
        .reveal-on-scroll,
        .reveal-fade-up {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity 0.75s cubic-bezier(0.16, 1, 0.3, 1),
                        transform 0.75s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }
        .reveal-fade-left {
            opacity: 0;
            transform: translateX(-32px);
            transition: opacity 0.75s cubic-bezier(0.16, 1, 0.3, 1),
                        transform 0.75s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }
        .reveal-fade-right {
            opacity: 0;
            transform: translateX(32px);
            transition: opacity 0.75s cubic-bezier(0.16, 1, 0.3, 1),
                        transform 0.75s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }
        .reveal-zoom-in {
            opacity: 0;
            transform: scale(0.93);
            transition: opacity 0.75s cubic-bezier(0.16, 1, 0.3, 1),
                        transform 0.75s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }
        .reveal-fade-in {
            opacity: 0;
            transition: opacity 0.75s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity;
        }
        .reveal-on-scroll.active,
        .reveal-fade-up.active,
        .reveal-fade-left.active,
        .reveal-fade-right.active,
        .reveal-zoom-in.active,
        .reveal-fade-in.active {
            opacity: 1;
            transform: translate(0) scale(1);
        }
        .delay-50  { transition-delay: 50ms; }
        .delay-100 { transition-delay: 100ms; }
        .delay-150 { transition-delay: 150ms; }
        .delay-200 { transition-delay: 200ms; }
        .delay-250 { transition-delay: 250ms; }
        .delay-300 { transition-delay: 300ms; }
        .delay-400 { transition-delay: 400ms; }
        .delay-500 { transition-delay: 500ms; }

        /* â”€â”€ Navbar Link Styles â”€â”€ */
        .nav-link-active {
            color: #1a4731;
            font-weight: 600;
            position: relative;
        }
        .nav-link-active::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0; right: 0;
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
            left: 0; right: 0;
            height: 2px;
            background: transparent;
            border-radius: 99px;
            transition: background 0.2s;
        }
        .nav-link-hover:hover { color: #1a4731; }
        .nav-link-hover:hover::after { background: #b88a48; }

        /* â”€â”€ Navbar Dropdown â”€â”€ */
        .nav-dropdown { position: relative; }
        .nav-dropdown-btn {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            color: #57534e;
            font-weight: 500;
            font-size: 0.875rem;
            font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;
            transition: color 0.2s;
            cursor: pointer;
            background: none;
            border: none;
            padding: 0 0 4px 0;
            position: relative;
        }
        .nav-dropdown-btn::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0; right: 0;
            height: 2px;
            background: transparent;
            border-radius: 99px;
            transition: background 0.2s;
        }
        .nav-dropdown-btn:hover { color: #1a4731; }
        .nav-dropdown-btn:hover::after { background: #b88a48; }
        .nav-dropdown-btn.dd-active { color: #1a4731; font-weight: 600; }
        .nav-dropdown-btn.dd-active::after { background: #b88a48; }
        .nav-dropdown-btn .dd-chev {
            width: 13px; height: 13px;
            transition: transform 0.2s;
            flex-shrink: 0;
        }
        .nav-dropdown.open .nav-dropdown-btn .dd-chev { transform: rotate(180deg); }

        .nav-dropdown-panel {
            position: absolute;
            top: calc(100% + 14px);
            left: 50%;
            transform: translateX(-50%) translateY(-6px);
            min-width: 210px;
            background: #ffffff;
            border: 1px solid #e7e5e4;
            border-radius: 14px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.10), 0 2px 8px rgba(0,0,0,0.06);
            padding: 6px;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.18s ease, transform 0.18s ease, visibility 0s linear 0.18s;
            z-index: 200;
        }
        .nav-dropdown.open .nav-dropdown-panel {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(0);
            transition: opacity 0.18s ease, transform 0.18s ease, visibility 0s;
        }
        .nav-dropdown-panel a {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 8px 12px;
            border-radius: 9px;
            font-size: 0.8rem;
            font-weight: 500;
            color: #44403c;
            transition: background 0.15s, color 0.15s;
            text-decoration: none;
            white-space: nowrap;
        }
        .nav-dropdown-panel a:hover { background: #f0f9f3; color: #1a4731; }
        .nav-dropdown-panel .dp-icon {
            width: 26px; height: 26px;
            border-radius: 7px;
            background: #f0f9f3;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; color: #1a4731;
        }
        .nav-dropdown-panel a:hover .dp-icon { background: #d6efdf; }
        .dp-divider { height: 1px; background: #f5f5f4; margin: 4px 6px; }

        /* â”€â”€ Mobile Accordion â”€â”€ */
        .mob-acc-body {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.28s cubic-bezier(0.4,0,0.2,1);
        }
        .mob-acc-body.open { max-height: 300px; }
        .mob-acc-chev { transition: transform 0.22s; }
        .mob-acc-chev.open { transform: rotate(180deg); }

        /* â”€â”€ Section Label Pill â”€â”€ */
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

        /* â”€â”€ Divider Bar â”€â”€ */
        .section-divider {
            width: 48px;
            height: 3px;
            background: linear-gradient(90deg, #1a4731, #b88a48);
            border-radius: 99px;
            margin: 14px auto 0;
        }

        /* â”€â”€ Buttons â”€â”€ */
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

        /* ── Tombol Utama Layanan Masyarakat (Kirim/Submit) ── */
        .btn-submit-layanan {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            min-height: 50px;
            height: 50px;
            padding: 0 1.75rem;
            font-size: 0.875rem;
            font-weight: 600;
            letter-spacing: 0.01em;
            color: #ffffff !important;
            background-color: #174b35 !important;
            border: 1.5px solid #174b35 !important;
            border-radius: 9999px !important;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(23, 75, 53, 0.2);
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            outline: none;
            user-select: none;
        }

        .btn-submit-layanan:hover:not(:disabled) {
            background-color: #103b29 !important;
            border-color: #103b29 !important;
            color: #ffffff !important;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(16, 59, 41, 0.32);
        }

        .btn-submit-layanan:active:not(:disabled) {
            transform: translateY(0);
            box-shadow: 0 2px 6px rgba(16, 59, 41, 0.2);
        }

        .btn-submit-layanan:focus-visible {
            outline: 2px solid #103b29;
            outline-offset: 3px;
            box-shadow: 0 0 0 4px rgba(23, 75, 53, 0.25);
        }

        .btn-submit-layanan:disabled,
        .btn-submit-layanan[disabled] {
            opacity: 0.55 !important;
            cursor: not-allowed !important;
            background-color: #4a6356 !important;
            border-color: #4a6356 !important;
            box-shadow: none !important;
            transform: none !important;
        }

        .btn-submit-layanan .btn-spinner {
            display: none;
            width: 1rem;
            height: 1rem;
            border: 2px solid rgba(255, 255, 255, 0.35);
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: btn-spin 0.75s linear infinite;
        }

        .btn-submit-layanan.is-loading .btn-spinner {
            display: inline-block;
        }

        .btn-submit-layanan.is-loading .btn-icon {
            display: none !important;
        }

        .btn-submit-layanan.is-loading {
            pointer-events: none;
            opacity: 0.85;
            cursor: wait;
        }

        @keyframes btn-spin {
            to { transform: rotate(360deg); }
        }

        /* â”€â”€ Paper Texture Overlay â”€â”€ */
        .paper-bg {
            background-color: #fdfaf5;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='4' height='4'%3E%3Crect width='4' height='4' fill='%23fdfaf5'/%3E%3Crect x='0' y='0' width='1' height='1' fill='%23f5ead6' opacity='0.3'/%3E%3C/svg%3E");
        }

        /* â”€â”€ Card Style â”€â”€ */
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

    <!-- Structured Data / JSON-LD (per-page schema) -->
    @stack('schema')
</head>

<body class="font-sans text-stone-800 paper-bg antialiased overflow-x-hidden">

    <!-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• NAVBAR â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• -->
    <header id="main-header" role="banner" class="fixed top-0 left-0 w-full z-50 bg-white border-b border-stone-200 transition-shadow duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 lg:h-[68px]">

                <!-- Brand -->
                <a href="{{ route('home') }}" class="flex items-center space-x-2.5 group flex-shrink-0">
                    <div class="w-9 h-9 rounded-lg overflow-hidden flex-shrink-0 shadow-sm">
                        <img src="{{ asset('uploads/img/DESA_JAMBELAER.png') }}" alt="Logo Desa Jambelaer" class="w-full h-full object-cover">
                    </div>
                    <div class="leading-tight">
                        <span class="font-display font-extrabold text-sm sm:text-base tracking-tight text-forest-900 block leading-none">DESA JAMBELAER</span>
                        <span class="text-[9px] text-sand-700 font-semibold tracking-widest uppercase block mt-0.5 hidden sm:block">Kec. Dawuan Â· Kab. Subang</span>
                    </div>
                </a>

                <!-- Desktop Navigation -->
                <nav role="navigation" aria-label="Menu Utama" class="hidden lg:flex items-center gap-0.5 xl:gap-1">

                    {{-- Beranda --}}
                    <a href="{{ route('home') }}"
                       class="{{ request()->routeIs('home') ? 'nav-link-active' : 'nav-link-hover' }} font-display text-sm pb-1 px-2.5">
                        Beranda
                    </a>

                    {{-- Tentang Desa --}}
                    <a href="{{ route('profil.desa') }}"
                       class="{{ request()->routeIs('profil.desa*') ? 'nav-link-active' : 'nav-link-hover' }} font-display text-sm pb-1 px-2.5">
                        Tentang Desa
                    </a>

                    {{-- Struktur Desa --}}
                    <a href="{{ route('struktur.desa') }}"
                       class="{{ request()->routeIs('struktur.desa') ? 'nav-link-active' : 'nav-link-hover' }} font-display text-sm pb-1 px-2.5">
                        Struktur Desa
                    </a>

                    {{-- Informasi Dropdown --}}
                    <div class="nav-dropdown" id="dd-informasi">
                        <button type="button" id="dd-informasi-btn"
                            class="nav-dropdown-btn {{ request()->routeIs('berita*', 'acara') ? 'dd-active' : '' }}"
                            aria-haspopup="true" aria-expanded="false" aria-controls="panel-informasi">
                            Informasi
                            <svg class="dd-chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                        </button>
                        <div id="panel-informasi" class="nav-dropdown-panel" role="menu">
                            <a href="{{ route('berita') }}" role="menuitem">
                                <span class="dp-icon"><i data-lucide="newspaper" class="w-3.5 h-3.5"></i></span>Berita Desa
                            </a>
                            <a href="{{ route('acara') }}" role="menuitem">
                                <span class="dp-icon"><i data-lucide="calendar" class="w-3.5 h-3.5"></i></span>Kegiatan &amp; Acara
                            </a>
                        </div>
                    </div>

                    {{-- Potensi Desa Dropdown --}}
                    <div class="nav-dropdown" id="dd-potensi">
                        <button type="button" id="dd-potensi-btn"
                            class="nav-dropdown-btn {{ request()->routeIs('umkm*', 'budaya*', 'wisata*') ? 'dd-active' : '' }}"
                            aria-haspopup="true" aria-expanded="false" aria-controls="panel-potensi">
                            Potensi Desa
                            <svg class="dd-chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                        </button>
                        <div id="panel-potensi" class="nav-dropdown-panel" role="menu">
                            <a href="{{ route('umkm') }}" role="menuitem">
                                <span class="dp-icon"><i data-lucide="shopping-bag" class="w-3.5 h-3.5"></i></span>UMKM Desa
                            </a>
                            <div class="dp-divider"></div>
                            <a href="{{ route('budaya') }}" role="menuitem">
                                <span class="dp-icon"><i data-lucide="music" class="w-3.5 h-3.5"></i></span>Budaya &amp; Tradisi
                            </a>
                            <a href="{{ route('wisata') }}" role="menuitem">
                                <span class="dp-icon"><i data-lucide="map-pin" class="w-3.5 h-3.5"></i></span>Wisata Desa
                            </a>
                        </div>
                    </div>

                    {{-- Galeri --}}
                    <a href="{{ route('galeri') }}"
                       class="{{ request()->routeIs('galeri*') ? 'nav-link-active' : 'nav-link-hover' }} font-display text-sm pb-1 px-2.5">
                        Galeri
                    </a>
                </nav>

                <!-- Desktop Primary CTA & User Auth -->
                <div class="hidden lg:flex items-center gap-2">
                    <a href="{{ route('layanan') }}" class="btn-primary text-[11px] py-2 px-4 gap-1.5 {{ request()->routeIs('layanan') ? '!bg-forest-700 !border-forest-700 ring-2 ring-forest-300' : '' }}">
                        <i data-lucide="headphones" class="w-3.5 h-3.5"></i>
                        Layanan Masyarakat
                    </a>

                    @guest
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-1 px-3 py-2 rounded-xl text-xs font-bold text-forest-800 hover:bg-forest-50 border border-stone-200 transition-all">
                            <i data-lucide="log-in" class="w-3.5 h-3.5"></i>
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-1 px-3 py-2 rounded-xl text-xs font-bold bg-sand-500 hover:bg-sand-600 text-forest-950 border border-sand-400 transition-all shadow-xs">
                            <i data-lucide="user-plus" class="w-3.5 h-3.5"></i>
                            Daftar
                        </a>
                    @else
                        {{-- Logged in user dropdown --}}
                        <div class="nav-dropdown" id="dd-user">
                            <button type="button" id="dd-user-btn"
                                class="nav-dropdown-btn !py-1.5 !px-2.5 rounded-xl bg-forest-50 border border-forest-200/80 text-forest-900 font-bold text-xs flex items-center gap-2 hover:bg-forest-100 transition-all"
                                aria-haspopup="true" aria-expanded="false" aria-controls="panel-user">
                                <span class="w-5 h-5 rounded-full bg-forest-800 text-white flex items-center justify-center text-[10px] font-bold">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                                <span class="max-w-[90px] truncate">{{ Auth::user()->name }}</span>
                                <svg class="dd-chev w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                            </button>
                            <div id="panel-user" class="nav-dropdown-panel !min-w-[200px]" role="menu">
                                <div class="px-3 py-2 border-b border-stone-100">
                                    <p class="text-[10px] text-stone-400 uppercase tracking-wider font-semibold">Akun Terhubung</p>
                                    <p class="text-xs font-bold text-stone-800 truncate mt-0.5">{{ Auth::user()->name }}</p>
                                    <span class="inline-block mt-1 px-1.5 py-0.5 rounded text-[9px] uppercase font-bold {{ Auth::user()->isAdmin() ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800' }}">
                                        {{ Auth::user()->isAdmin() ? 'Administrator' : 'Masyarakat' }}
                                    </span>
                                </div>

                                @if(Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" role="menuitem">
                                    <span class="dp-icon"><i data-lucide="layout-dashboard" class="w-3.5 h-3.5"></i></span>Dashboard Admin
                                </a>
                                @else
                                <a href="{{ route('profil.edit') }}" role="menuitem">
                                    <span class="dp-icon"><i data-lucide="user" class="w-3.5 h-3.5"></i></span>Profil Saya
                                </a>
                                @endif

                                <a href="{{ route('pengajuan.saya') }}" role="menuitem">
                                    <span class="dp-icon"><i data-lucide="folder-check" class="w-3.5 h-3.5"></i></span>Pengajuan Saya
                                </a>

                                <div class="dp-divider"></div>

                                <form action="{{ route('logout') }}" method="POST" class="m-0 p-0">
                                    @csrf
                                    <button type="submit" role="menuitem" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold text-rose-600 hover:bg-rose-50 hover:text-rose-700 transition-all text-left">
                                        <i data-lucide="log-out" class="w-4 h-4"></i>Keluar (Logout)
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>

                <!-- Mobile Toggle -->
                <button id="mobile-menu-btn" type="button"
                    class="lg:hidden inline-flex items-center justify-center p-2 rounded-lg text-stone-600 hover:bg-forest-50 focus:outline-none transition-colors duration-200"
                    aria-controls="mobile-menu" aria-expanded="false">
                    <i id="hamburger-icon" data-lucide="menu" class="w-6 h-6"></i>
                    <i id="close-icon" data-lucide="x" class="w-6 h-6 hidden"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <nav id="mobile-menu" role="navigation" aria-label="Menu Mobile"
             class="hidden lg:hidden border-t border-stone-100 bg-white max-h-[calc(100vh-64px)] overflow-y-auto">
            <div class="px-3 py-2 space-y-0.5">

                {{-- Beranda --}}
                <a href="{{ route('home') }}"
                   class="flex items-center px-3 py-2.5 rounded-lg text-sm font-semibold {{ request()->routeIs('home') ? 'text-forest-800 bg-forest-50' : 'text-stone-700 hover:bg-forest-50 hover:text-forest-800' }} transition-all">
                    <i data-lucide="home" class="w-4 h-4 mr-2.5 flex-shrink-0"></i>Beranda
                </a>

                {{-- Tentang Desa --}}
                <a href="{{ route('profil.desa') }}"
                   class="flex items-center px-3 py-2.5 rounded-lg text-sm font-semibold {{ request()->routeIs('profil.desa*') ? 'text-forest-800 bg-forest-50' : 'text-stone-700 hover:bg-forest-50 hover:text-forest-800' }} transition-all">
                    <i data-lucide="landmark" class="w-4 h-4 mr-2.5 flex-shrink-0"></i>Tentang Desa
                </a>

                {{-- Struktur Desa --}}
                <a href="{{ route('struktur.desa') }}"
                   class="flex items-center px-3 py-2.5 rounded-lg text-sm font-semibold {{ request()->routeIs('struktur.desa') ? 'text-forest-800 bg-forest-50' : 'text-stone-700 hover:bg-forest-50 hover:text-forest-800' }} transition-all">
                    <i data-lucide="users" class="w-4 h-4 mr-2.5 flex-shrink-0"></i>Struktur Desa
                </a>

                {{-- Informasi Accordion --}}
                <div>
                    <button type="button" id="mob-informasi-btn" aria-expanded="false"
                        class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-semibold {{ request()->routeIs('berita*', 'acara') ? 'text-forest-800 bg-forest-50' : 'text-stone-700 hover:bg-forest-50 hover:text-forest-800' }} transition-all">
                        <span class="flex items-center"><i data-lucide="newspaper" class="w-4 h-4 mr-2.5 flex-shrink-0"></i>Informasi</span>
                        <i data-lucide="chevron-down" class="w-4 h-4 mob-acc-chev" id="mob-informasi-chev"></i>
                    </button>
                    <div class="mob-acc-body" id="mob-informasi-body">
                        <div class="pl-9 pr-2 pb-1 space-y-0.5">
                            <a href="{{ route('berita') }}" class="block px-3 py-2 rounded-lg text-sm text-stone-600 hover:bg-forest-50 hover:text-forest-800 transition-all">Berita Desa</a>
                            <a href="{{ route('acara') }}" class="block px-3 py-2 rounded-lg text-sm text-stone-600 hover:bg-forest-50 hover:text-forest-800 transition-all">Kegiatan &amp; Acara</a>
                        </div>
                    </div>
                </div>

                {{-- Potensi Desa Accordion --}}
                <div>
                    <button type="button" id="mob-potensi-btn" aria-expanded="false"
                        class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-semibold {{ request()->routeIs('umkm*', 'budaya*', 'wisata*') ? 'text-forest-800 bg-forest-50' : 'text-stone-700 hover:bg-forest-50 hover:text-forest-800' }} transition-all">
                        <span class="flex items-center"><i data-lucide="sprout" class="w-4 h-4 mr-2.5 flex-shrink-0"></i>Potensi Desa</span>
                        <i data-lucide="chevron-down" class="w-4 h-4 mob-acc-chev" id="mob-potensi-chev"></i>
                    </button>
                    <div class="mob-acc-body" id="mob-potensi-body">
                        <div class="pl-9 pr-2 pb-1 space-y-0.5">
                            <a href="{{ route('umkm') }}" class="block px-3 py-2 rounded-lg text-sm text-stone-600 hover:bg-forest-50 hover:text-forest-800 transition-all">UMKM Desa</a>
                            <a href="{{ route('budaya') }}" class="block px-3 py-2 rounded-lg text-sm text-stone-600 hover:bg-forest-50 hover:text-forest-800 transition-all">Budaya &amp; Tradisi</a>
                            <a href="{{ route('wisata') }}" class="block px-3 py-2 rounded-lg text-sm text-stone-600 hover:bg-forest-50 hover:text-forest-800 transition-all">Wisata Desa</a>
                        </div>
                    </div>
                </div>

                {{-- Galeri --}}
                <a href="{{ route('galeri') }}"
                   class="flex items-center px-3 py-2.5 rounded-lg text-sm font-semibold {{ request()->routeIs('galeri*') ? 'text-forest-800 bg-forest-50' : 'text-stone-700 hover:bg-forest-50 hover:text-forest-800' }} transition-all">
                    <i data-lucide="image" class="w-4 h-4 mr-2.5 flex-shrink-0"></i>Galeri
                </a>

                {{-- User Section for Mobile --}}
                <div class="pt-2 pb-2 px-1 border-t border-stone-100 space-y-1">
                    @guest
                        <a href="{{ route('login') }}" class="flex items-center px-3 py-2 rounded-lg text-sm font-semibold text-stone-700 hover:bg-forest-50 hover:text-forest-800 transition-all">
                            <i data-lucide="log-in" class="w-4 h-4 mr-2.5 text-forest-700"></i>Masuk Akun
                        </a>
                        <a href="{{ route('register') }}" class="flex items-center px-3 py-2 rounded-lg text-sm font-semibold text-forest-800 hover:bg-forest-50 transition-all">
                            <i data-lucide="user-plus" class="w-4 h-4 mr-2.5 text-sand-600"></i>Daftar Akun Warga
                        </a>
                    @else
                        <div class="px-3 py-2 bg-stone-50 rounded-xl mb-1 text-xs">
                            <p class="text-stone-400 text-[10px]">Halo,</p>
                            <p class="font-bold text-stone-800">{{ Auth::user()->name }}</p>
                            <span class="inline-block mt-0.5 px-1.5 py-0.5 rounded text-[9px] uppercase font-bold {{ Auth::user()->isAdmin() ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800' }}">
                                {{ Auth::user()->isAdmin() ? 'Administrator' : 'Masyarakat' }}
                            </span>
                        </div>

                        @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2 rounded-lg text-sm font-semibold text-stone-700 hover:bg-forest-50 hover:text-forest-800 transition-all">
                            <i data-lucide="layout-dashboard" class="w-4 h-4 mr-2.5 text-forest-700"></i>Dashboard Admin
                        </a>
                        @else
                        <a href="{{ route('profil.edit') }}" class="flex items-center px-3 py-2 rounded-lg text-sm font-semibold text-stone-700 hover:bg-forest-50 hover:text-forest-800 transition-all">
                            <i data-lucide="user" class="w-4 h-4 mr-2.5 text-forest-700"></i>Profil Saya
                        </a>
                        @endif

                        <a href="{{ route('pengajuan.saya') }}" class="flex items-center px-3 py-2 rounded-lg text-sm font-semibold text-stone-700 hover:bg-forest-50 hover:text-forest-800 transition-all">
                            <i data-lucide="folder-check" class="w-4 h-4 mr-2.5 text-forest-700"></i>Pengajuan Saya
                        </a>

                        <form action="{{ route('logout') }}" method="POST" class="pt-1">
                            @csrf
                            <button type="submit" class="w-full flex items-center px-3 py-2 rounded-lg text-sm font-semibold text-rose-600 hover:bg-rose-50 transition-all text-left">
                                <i data-lucide="log-out" class="w-4 h-4 mr-2.5"></i>Keluar (Logout)
                            </button>
                        </form>
                    @endguest
                </div>

                {{-- CTA --}}
                <div class="pt-2 pb-2 px-1">
                    <a href="{{ route('layanan') }}" class="btn-primary w-full justify-center text-[11px] py-2.5 gap-2">
                        <i data-lucide="headphones" class="w-4 h-4"></i>Layanan Masyarakat
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <!-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• PAGE CONTENT â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• -->
    <main role="main" class="pt-16 lg:pt-[68px]">
        @yield('content')
    </main>

    <footer role="contentinfo" class="bg-forest-900 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">

            <!-- Main Footer Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-6 pb-10 border-b border-white/10">

                <!-- Col 1: Brand -->
                <div class="sm:col-span-2 lg:col-span-4 space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-lg bg-forest-700 border border-forest-600 flex items-center justify-center">
                            <i data-lucide="wheat" class="w-5 h-5 text-sand-300"></i>
                        </div>
                        <div>
                            <span class="font-display font-extrabold text-sm text-white block leading-tight">Pemerintah Desa Jambelaer</span>
                            <span class="text-[10px] text-sand-400 tracking-widest uppercase">Kec. Dawuan Â· Kab. Subang Â· Jawa Barat</span>
                        </div>
                    </div>
                    <p class="text-sm text-white/50 leading-relaxed font-light max-w-xs">
                        Portal layanan dan profil resmi Desa Jambelaer. Memajukan desa melalui digitalisasi potensi budaya lokal, pariwisata, dan UMKM unggulan.
                    </p>
                    <!-- Social Icons -->
                    @php
                        $footerIg = \App\Models\PengaturanModel::get('sosmed_instagram', '');
                        $footerYt = \App\Models\PengaturanModel::get('sosmed_youtube', '');
                        $footerTt = \App\Models\PengaturanModel::get('sosmed_tiktok', '');
                    @endphp
                    <div class="flex items-center gap-2 pt-1">
                        @if($footerIg)
                        <a href="{{ str_starts_with($footerIg, 'http') ? $footerIg : 'https://'.$footerIg }}" target="_blank" rel="noopener" title="Instagram Desa"
                            class="w-8 h-8 rounded border border-white/10 bg-white/5 flex items-center justify-center hover:bg-pink-600 hover:border-pink-600 transition-all text-white/60 hover:text-white">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                        </a>
                        @else
                        <span class="w-8 h-8 rounded border border-white/5 bg-white/5 flex items-center justify-center text-white/20" title="Instagram belum diatur">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                        </span>
                        @endif

                        @if($footerYt)
                        <a href="{{ str_starts_with($footerYt, 'http') ? $footerYt : 'https://'.$footerYt }}" target="_blank" rel="noopener" title="YouTube Desa"
                            class="w-8 h-8 rounded border border-white/10 bg-white/5 flex items-center justify-center hover:bg-red-600 hover:border-red-600 transition-all text-white/60 hover:text-white">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 0 0-1.95 1.96A29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58A2.78 2.78 0 0 0 3.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 0 0 1.95-1.95A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02"/></svg>
                        </a>
                        @else
                        <span class="w-8 h-8 rounded border border-white/5 bg-white/5 flex items-center justify-center text-white/20" title="YouTube belum diatur">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 0 0-1.95 1.96A29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58A2.78 2.78 0 0 0 3.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 0 0 1.95-1.95A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02"/></svg>
                        </span>
                        @endif

                        @if($footerTt)
                        <a href="{{ str_starts_with($footerTt, 'http') ? $footerTt : 'https://'.$footerTt }}" target="_blank" rel="noopener" title="TikTok Desa"
                            class="w-8 h-8 rounded border border-white/10 bg-white/5 flex items-center justify-center hover:bg-stone-700 hover:border-stone-700 transition-all text-white/60 hover:text-white">
                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.32 6.32 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.33-6.34V8.69a8.18 8.18 0 0 0 4.78 1.52V6.76a4.85 4.85 0 0 1-1.01-.07z"/></svg>
                        </a>
                        @else
                        <span class="w-8 h-8 rounded border border-white/5 bg-white/5 flex items-center justify-center text-white/20" title="TikTok belum diatur">
                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.32 6.32 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.33-6.34V8.69a8.18 8.18 0 0 0 4.78 1.52V6.76a4.85 4.85 0 0 1-1.01-.07z"/></svg>
                        </span>
                        @endif
                    </div>
                </div>

                <!-- Col 2: Navigasi -->
                <div class="lg:col-span-2 space-y-4">
                    <h4 class="font-display font-bold text-[11px] tracking-widest uppercase text-sand-400">Navigasi</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-sm text-white/50 hover:text-sand-300 font-light transition-colors flex items-center gap-1.5"><i data-lucide="chevron-right" class="w-3 h-3"></i>Beranda</a></li>
                        <li><a href="{{ route('profil.desa') }}" class="text-sm text-white/50 hover:text-sand-300 font-light transition-colors flex items-center gap-1.5"><i data-lucide="chevron-right" class="w-3 h-3"></i>Tentang Desa</a></li>
                        <li><a href="{{ route('berita') }}" class="text-sm text-white/50 hover:text-sand-300 font-light transition-colors flex items-center gap-1.5"><i data-lucide="chevron-right" class="w-3 h-3"></i>Berita</a></li>
                        <li><a href="{{ route('acara') }}" class="text-sm text-white/50 hover:text-sand-300 font-light transition-colors flex items-center gap-1.5"><i data-lucide="chevron-right" class="w-3 h-3"></i>Kegiatan</a></li>
                        <li><a href="{{ route('galeri') }}" class="text-sm text-white/50 hover:text-sand-300 font-light transition-colors flex items-center gap-1.5"><i data-lucide="chevron-right" class="w-3 h-3"></i>Galeri</a></li>
                    </ul>
                </div>

                <!-- Col 3: Potensi -->
                <div class="lg:col-span-2 space-y-4">
                    <h4 class="font-display font-bold text-[11px] tracking-widest uppercase text-sand-400">Potensi Desa</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('umkm') }}" class="text-sm text-white/50 hover:text-sand-300 font-light transition-colors flex items-center gap-1.5"><i data-lucide="chevron-right" class="w-3 h-3"></i>UMKM</a></li>
                        <li><a href="{{ route('budaya') }}" class="text-sm text-white/50 hover:text-sand-300 font-light transition-colors flex items-center gap-1.5"><i data-lucide="chevron-right" class="w-3 h-3"></i>Budaya &amp; Seni</a></li>
                        <li><a href="{{ route('wisata') }}" class="text-sm text-white/50 hover:text-sand-300 font-light transition-colors flex items-center gap-1.5"><i data-lucide="chevron-right" class="w-3 h-3"></i>Wisata</a></li>
                    </ul>
                </div>

                <!-- Col 4: Pelayanan -->
                <div class="lg:col-span-2 space-y-4">
                    <h4 class="font-display font-bold text-[11px] tracking-widest uppercase text-sand-400">Layanan Publik</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('pengajuan.surat') }}" class="text-sm text-white/50 hover:text-sand-300 font-light transition-colors flex items-center gap-1.5"><i data-lucide="chevron-right" class="w-3 h-3"></i>Pengajuan Surat</a></li>
                        <li><a href="{{ route('pertanyaan-umum.create') }}" class="text-sm text-white/50 hover:text-sand-300 font-light transition-colors flex items-center gap-1.5"><i data-lucide="chevron-right" class="w-3 h-3"></i>Pertanyaan Umum</a></li>
                        <li><a href="{{ route('pengaduan.create') }}" class="text-sm text-white/50 hover:text-sand-300 font-light transition-colors flex items-center gap-1.5"><i data-lucide="chevron-right" class="w-3 h-3"></i>Pengaduan Warga</a></li>
                        <li><a href="{{ route('pengajuan.saya') }}" class="text-sm text-white/50 hover:text-sand-300 font-light transition-colors flex items-center gap-1.5"><i data-lucide="chevron-right" class="w-3 h-3"></i>Pantau Pengajuan</a></li>
                    </ul>
                </div>

                <!-- Col 5: Kontak -->
                <div class="sm:col-span-2 lg:col-span-2 space-y-4">
                    <h4 class="font-display font-bold text-[11px] tracking-widest uppercase text-sand-400">Kontak &amp; Lokasi</h4>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-2.5">
                            <i data-lucide="map-pin" class="w-3.5 h-3.5 text-sand-400 flex-shrink-0 mt-0.5"></i>
                            <span class="text-xs text-white/50 font-light leading-relaxed">{{ \App\Models\PengaturanModel::get('desa_alamat', 'Jl. Raya Jambelaer, Dawuan, Subang, Jawa Barat 41270') }}</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i data-lucide="phone" class="w-3.5 h-3.5 text-sand-400 flex-shrink-0"></i>
                            <span class="text-xs text-white/50 font-light">{{ \App\Models\PengaturanModel::get('desa_telepon', '081324768193') }}</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i data-lucide="mail" class="w-3.5 h-3.5 text-sand-400 flex-shrink-0"></i>
                            <span class="text-xs text-white/50 font-light break-all">{{ \App\Models\PengaturanModel::get('desa_email', 'info@jambelaer-subang.desa.id') }}</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i data-lucide="clock" class="w-3.5 h-3.5 text-sand-400 flex-shrink-0"></i>
                            <span class="text-xs text-white/50 font-light">{{ \App\Models\PengaturanModel::get('desa_jam_buka', 'Senin â€“ Jumat: 08:00 â€“ 15:30 WIB') }}</span>
                        </li>
                    </ul>
                </div>

            </div>

            <!-- Bottom Bar -->
            <div class="pt-7 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-white/30 font-light">
                <p>Â© {{ date('Y') }} Pemerintah Desa Jambelaer Â· Kecamatan Dawuan Â· Kabupaten Subang</p>
                <div class="flex items-center divide-x divide-white/10 text-white/25">
                    <a href="#" class="hover:text-sand-400 transition-colors pr-4">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-sand-400 transition-colors px-4">Syarat &amp; Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top -->
    <button id="back-to-top"
        class="fixed bottom-6 right-6 w-10 h-10 rounded-full bg-forest-800 text-white shadow-lg flex items-center justify-center transition-all duration-300 transform translate-y-16 opacity-0 z-40 focus:outline-none cursor-pointer hover:bg-forest-700 hover:shadow-xl">
        <i data-lucide="arrow-up" class="w-4 h-4"></i>
    </button>

    <!-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• SHARED SCRIPTS â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• -->
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

            // â”€â”€ Desktop Dropdown â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
            const dropdowns = document.querySelectorAll('.nav-dropdown');
            dropdowns.forEach(function(dd) {
                const btn = dd.querySelector('.nav-dropdown-btn');
                if (!btn) return;
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const isOpen = dd.classList.contains('open');
                    dropdowns.forEach(d => { d.classList.remove('open'); const b = d.querySelector('.nav-dropdown-btn'); if(b) b.setAttribute('aria-expanded','false'); });
                    if (!isOpen) { dd.classList.add('open'); btn.setAttribute('aria-expanded', 'true'); }
                });
            });
            document.addEventListener('click', function() {
                dropdowns.forEach(d => { d.classList.remove('open'); const b = d.querySelector('.nav-dropdown-btn'); if(b) b.setAttribute('aria-expanded','false'); });
            });
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') { dropdowns.forEach(d => { d.classList.remove('open'); const b = d.querySelector('.nav-dropdown-btn'); if(b) b.setAttribute('aria-expanded','false'); }); }
            });

            // â”€â”€ Mobile Menu Toggle â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
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

            // â”€â”€ Mobile Accordion â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
            function setupAcc(btnId, bodyId, chevId) {
                const btn  = document.getElementById(btnId);
                const body = document.getElementById(bodyId);
                const chev = document.getElementById(chevId);
                if (!btn || !body) return;
                btn.addEventListener('click', function() {
                    const open = body.classList.contains('open');
                    body.classList.toggle('open', !open);
                    if (chev) chev.classList.toggle('open', !open);
                    btn.setAttribute('aria-expanded', !open);
                });
            }
            setupAcc('mob-informasi-btn', 'mob-informasi-body','mob-informasi-chev');
            setupAcc('mob-potensi-btn',   'mob-potensi-body',  'mob-potensi-chev');

            // â”€â”€ Scroll Reveal Observer â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
            const revealEls = document.querySelectorAll('.reveal-on-scroll, .reveal-fade-up, .reveal-fade-left, .reveal-fade-right, .reveal-zoom-in, .reveal-fade-in, [data-aos]');
            const observer = new IntersectionObserver((entries, obs) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                        entry.target.querySelectorAll('[data-target]').forEach(animateCounter);
                        obs.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.08,
                rootMargin: '0px 0px -30px 0px'
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

    <!-- AOS Library JS -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof AOS !== 'undefined') {
                AOS.init({
                    duration: 750,
                    easing: 'ease-out-cubic',
                    once: true,
                    offset: 40,
                    delay: 50,
                });
            }
        });

        // ── Auto Loading & Double-Submit Protection for Layanan Masyarakat Buttons ──
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('form').forEach(function(form) {
                if (form.id === 'contact-form') return; // Handled by its own AJAX script

                const submitBtn = form.querySelector('.btn-submit-layanan');
                if (!submitBtn) return;

                form.addEventListener('submit', function(e) {
                    if (form.checkValidity && !form.checkValidity()) {
                        return;
                    }

                    if (submitBtn.dataset.submitting === 'true') {
                        e.preventDefault();
                        return false;
                    }

                    submitBtn.dataset.submitting = 'true';
                    submitBtn.classList.add('is-loading');

                    const textSpan = submitBtn.querySelector('.btn-text');
                    if (textSpan) {
                        submitBtn.dataset.origText = textSpan.textContent;
                        textSpan.textContent = 'Memproses...';
                    }
                });
            });
        });

        window.addEventListener('pageshow', function(e) {
            if (e.persisted) {
                document.querySelectorAll('.btn-submit-layanan').forEach(function(btn) {
                    btn.classList.remove('is-loading');
                    delete btn.dataset.submitting;
                    const textSpan = btn.querySelector('.btn-text');
                    if (textSpan && btn.dataset.origText) {
                        textSpan.textContent = btn.dataset.origText;
                    }
                });
            }
        });
    </script>

    @stack('scripts')
</body>

</html>
