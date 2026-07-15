<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Resmi Desa Jambelaer - Kecamatan Dawuan, Subang</title>
    <meta name="description" content="Portal Resmi Desa Jambelaer, Kecamatan Dawuan, Kabupaten Subang. Temukan informasi tentang profil desa, kebudayaan lokal, produk UMKM unggulan, dan kontak kami.">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS v4 Play CDN -->
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    
    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Inter', ui-sans-serif, system-ui, sans-serif;
            --font-display: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;
            --color-emerald-950: #022c22;
            --color-emerald-900: #064e3b;
            --color-emerald-800: #065f46;
            --color-emerald-700: #047857;
            --color-emerald-650: #059669;
            --color-emerald-50: #ecfdf5;
            --color-emerald-200: #a7f3d0;
            --color-amber-50: #fffbeb;
            --color-amber-600: #d97706;
            --color-amber-700: #b45309;
            --color-amber-705: #b45309;
            --color-amber-755: #b45309;
            --color-ivory: #fdfbf7;
        }
        
        html {
            scroll-behavior: smooth;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #fdfbf7;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Scroll reveal utility classes */
        .reveal-on-scroll {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .reveal-on-scroll.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* Delay classes for scroll reveal */
        .delay-100 { transition-delay: 100ms; }
        .delay-200 { transition-delay: 200ms; }
        .delay-300 { transition-delay: 300ms; }
        .delay-400 { transition-delay: 400ms; }

        /* Custom background patterns */
        .bg-grid-pattern {
            background-size: 40px 40px;
            background-image: 
                linear-gradient(to right, rgba(148, 163, 184, 0.05) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(148, 163, 184, 0.05) 1px, transparent 1px);
        }
    </style>
    
    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="font-sans text-slate-800 bg-ivory bg-grid-pattern selection:bg-emerald-600 selection:text-white antialiased overflow-x-hidden">

    <!-- HEADER & NAVBAR -->
    <header id="main-header" class="fixed top-0 left-0 w-full z-50 transition-all duration-300 border-b border-transparent">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo & Brand -->
                <a href="#home" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-850 to-emerald-650 flex items-center justify-center shadow-md shadow-emerald-900/10 group-hover:scale-105 transition-transform duration-300">
                        <i data-lucide="map" class="w-5 h-5 text-white"></i>
                    </div>
                    <div>
                        <span class="font-display font-extrabold text-lg sm:text-xl tracking-tight text-emerald-950 group-hover:text-emerald-800 transition-colors duration-300 block">DESA JAMBELAER</span>
                        <span class="text-xs text-emerald-700/80 font-medium block -mt-1 tracking-wider uppercase">Dawuan, Subang</span>
                    </div>
                </a>

                <!-- Desktop Nav Menu -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="font-medium text-sm text-slate-600 hover:text-emerald-850 transition-colors duration-200">Home</a>
                    <a href="#tentang-kami" class="font-medium text-sm text-slate-600 hover:text-emerald-850 transition-colors duration-200">Tentang Kami</a>
                    <a href="#umkm" class="font-medium text-sm text-slate-600 hover:text-emerald-850 transition-colors duration-200">UMKM</a>
                    <a href="#budaya" class="font-medium text-sm text-slate-600 hover:text-emerald-850 transition-colors duration-200">Budaya</a>
                    <a href="#kontak" class="font-medium text-sm text-slate-600 hover:text-emerald-850 transition-colors duration-200">Kontak</a>
                </nav>

                <!-- CTA Button -->
                <div class="hidden md:flex items-center">
                    <a href="#kontak" class="inline-flex items-center justify-center px-5 h-11 text-xs font-semibold tracking-wider uppercase text-white bg-emerald-900 hover:bg-emerald-800 rounded-lg shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-y-0.5">
                        Hubungi Kami
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex items-center md:hidden">
                    <button id="mobile-menu-btn" type="button" class="inline-flex items-center justify-center p-2 rounded-lg text-slate-600 hover:text-emerald-850 hover:bg-emerald-50 focus:outline-none transition-colors duration-200" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Buka menu</span>
                        <i id="hamburger-icon" data-lucide="menu" class="w-6 h-6"></i>
                        <i id="close-icon" data-lucide="x" class="w-6 h-6 hidden"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobile-menu" class="hidden md:hidden absolute top-20 left-0 w-full bg-white/95 backdrop-blur-md border-b border-slate-100 shadow-lg py-4 transition-all duration-300">
            <div class="px-4 space-y-3">
                <a href="#home" class="mobile-nav-link block px-4 py-2.5 rounded-lg text-base font-semibold text-slate-700 hover:bg-emerald-50 hover:text-emerald-800 transition-all duration-200">Home</a>
                <a href="#tentang-kami" class="mobile-nav-link block px-4 py-2.5 rounded-lg text-base font-semibold text-slate-700 hover:bg-emerald-50 hover:text-emerald-800 transition-all duration-200">Tentang Kami</a>
                <a href="#umkm" class="mobile-nav-link block px-4 py-2.5 rounded-lg text-base font-semibold text-slate-700 hover:bg-emerald-50 hover:text-emerald-800 transition-all duration-200">UMKM</a>
                <a href="#budaya" class="mobile-nav-link block px-4 py-2.5 rounded-lg text-base font-semibold text-slate-700 hover:bg-emerald-50 hover:text-emerald-800 transition-all duration-200">Budaya</a>
                <a href="#kontak" class="mobile-nav-link block px-4 py-2.5 rounded-lg text-base font-semibold text-slate-700 hover:bg-emerald-50 hover:text-emerald-800 transition-all duration-200">Kontak</a>
                <div class="pt-2">
                    <a href="#kontak" class="mobile-nav-link flex items-center justify-center w-full py-3 text-center text-sm font-semibold tracking-wider uppercase text-white bg-emerald-900 rounded-lg shadow-sm">
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- HERO SECTION (HOME) -->
    <section id="home" class="relative min-h-screen flex items-center justify-center pt-24 pb-16 overflow-hidden">
        <!-- Background Overlay Image -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1500937386664-56d1dfef3854?auto=format&fit=crop&w=1920&q=80" alt="Sawah Desa Jambelaer" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-b from-white/90 via-white/80 to-ivory"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <!-- Badges -->
            <div class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-800 mb-6 animate-pulse">
                <i data-lucide="heart" class="w-4 h-4 fill-emerald-600"></i>
                <span class="text-xs font-semibold tracking-wider uppercase">Portal Resmi Desa Jambelaer</span>
            </div>

            <!-- Title -->
            <h1 class="font-display font-extrabold text-4xl sm:text-5xl lg:text-6xl tracking-tight text-emerald-950 max-w-4xl mx-auto leading-tight">
                Harmoni Alam, Budaya, & Kemandirian <span class="bg-gradient-to-r from-emerald-800 to-amber-700 bg-clip-text text-transparent">Ekonomi Desa</span>
            </h1>
            
            <p class="mt-6 text-base sm:text-lg lg:text-xl text-slate-650 max-w-2xl mx-auto font-light leading-relaxed">
                Selamat datang di portal informasi resmi Desa Jambelaer, Kecamatan Dawuan, Kabupaten Subang. Tempat di mana tradisi luhur berpadu dengan kemajuan potensi lokal yang asri.
            </p>

            <!-- CTA Buttons -->
            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="#tentang-kami" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 text-sm font-bold tracking-wide text-white bg-emerald-900 hover:bg-emerald-800 rounded-xl shadow-lg hover:shadow-emerald-900/20 transition-all duration-200 hover:-translate-y-0.5 group">
                    Jelajahi Profil
                    <i data-lucide="arrow-right" class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform"></i>
                </a>
                <a href="#umkm" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 text-sm font-bold tracking-wide text-emerald-950 bg-white hover:bg-slate-50 border border-slate-200 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-y-0.5">
                    Lihat UMKM Desa
                </a>
            </div>

            <!-- Statistics Grid -->
            <div class="mt-20 grid grid-cols-2 lg:grid-cols-4 gap-6 max-w-5xl mx-auto text-left reveal-on-scroll">
                <!-- Stat Item 1 -->
                <div class="bg-white/80 backdrop-blur-sm p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-800 mb-4">
                        <i data-lucide="layers" class="w-6 h-6"></i>
                    </div>
                    <span class="text-3xl sm:text-4xl font-extrabold font-display text-emerald-950 block" data-target="1240">0</span>
                    <span class="text-xs font-semibold tracking-wider text-slate-500 uppercase block mt-1">Luas Wilayah (Ha)</span>
                </div>
                <!-- Stat Item 2 -->
                <div class="bg-white/80 backdrop-blur-sm p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-800 mb-4">
                        <i data-lucide="users" class="w-6 h-6"></i>
                    </div>
                    <span class="text-3xl sm:text-4xl font-extrabold font-display text-emerald-950 block" data-target="4850">0</span>
                    <span class="text-xs font-semibold tracking-wider text-slate-500 uppercase block mt-1">Jumlah Penduduk (Jiwa)</span>
                </div>
                <!-- Stat Item 3 -->
                <div class="bg-white/80 backdrop-blur-sm p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-800 mb-4">
                        <i data-lucide="sprout" class="w-6 h-6"></i>
                    </div>
                    <span class="text-3xl sm:text-4xl font-extrabold font-display text-emerald-950 block" data-target="12">0</span>
                    <span class="text-xs font-semibold tracking-wider text-slate-500 uppercase block mt-1">Kelompok Tani</span>
                </div>
                <!-- Stat Item 4 -->
                <div class="bg-white/80 backdrop-blur-sm p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-800 mb-4">
                        <i data-lucide="store" class="w-6 h-6"></i>
                    </div>
                    <span class="text-3xl sm:text-4xl font-extrabold font-display text-emerald-950 block" data-target="35">0</span>
                    <span class="text-xs font-semibold tracking-wider text-slate-500 uppercase block mt-1">Pelaku UMKM</span>
                </div>
            </div>
        </div>
    </section>

    <!-- TENTANG KAMI SECTION -->
    <section id="tentang-kami" class="py-24 relative overflow-hidden bg-white/40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 reveal-on-scroll">
                <span class="text-xs font-bold tracking-widest uppercase text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full">Tentang Kami</span>
                <h2 class="font-display font-extrabold text-3xl sm:text-4xl text-emerald-950 mt-3">Mengenal Lebih Dekat Desa Jambelaer</h2>
                <div class="w-16 h-1 bg-gradient-to-r from-emerald-800 to-amber-600 mx-auto mt-4 rounded-full"></div>
            </div>

            <!-- Content Grid 1: Welcome & Message -->
            <div class="grid lg:grid-cols-12 gap-12 items-center mb-20 reveal-on-scroll">
                <!-- Left: Avatar of Village Head -->
                <div class="lg:col-span-5 flex justify-center">
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-tr from-emerald-800 to-amber-600 rounded-3xl transform rotate-3 scale-95 group-hover:rotate-1 group-hover:scale-100 transition-all duration-500 -z-10"></div>
                        <div class="absolute -inset-1 rounded-3xl bg-white border border-slate-100 shadow-sm -z-10"></div>
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=600&h=600&q=80" alt="Kepala Desa Jambelaer" class="w-72 h-72 sm:w-80 sm:h-80 object-cover rounded-2xl shadow-md border-4 border-white transition-all duration-500 group-hover:scale-98">
                        <div class="absolute bottom-4 left-4 right-4 bg-emerald-950/90 backdrop-blur-sm rounded-xl p-4 text-white text-center">
                            <span class="font-display font-bold text-sm block">Bapak Dedi Suherman, S.E.</span>
                            <span class="text-xs font-light tracking-wider uppercase text-emerald-300 block">Kepala Desa Jambelaer</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Welcome Text -->
                <div class="lg:col-span-7 space-y-6">
                    <h3 class="font-display font-bold text-2xl text-emerald-950">Sambutan Hangat Kepala Desa</h3>
                    <p class="text-slate-650 leading-relaxed font-light">
                        "Sampurasun, salam sejahtera bagi kita semua. Sebagai Kepala Desa Jambelaer, saya menyambut baik kehadiran portal resmi ini. Website ini merupakan wujud keterbukaan informasi publik dan media komunikasi terpadu untuk memperkenalkan kekayaan alam, kearifan lokal, dan kreasi produk UMKM warga kami."
                    </p>
                    <p class="text-slate-655 leading-relaxed font-light">
                        "Desa Jambelaer dikaruniai tanah Dawuan yang subur, budaya yang terus dijaga kelestariannya, serta masyarakat wirausaha yang gigih. Melalui platform digital ini, kami membuka pintu kolaborasi dan kemitraan seluas-luasnya dengan pihak luar untuk memajukan perekonomian desa."
                    </p>
                    <div class="flex items-center space-x-3 text-emerald-800 font-semibold">
                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                        <span>Melayani dengan Amanah, Terbuka, dan Transparan.</span>
                    </div>
                </div>
            </div>

            <!-- Content Grid 2: Visi & Misi Tab System -->
            <div class="max-w-4xl mx-auto bg-white border border-slate-100 rounded-3xl p-6 sm:p-10 shadow-sm reveal-on-scroll delay-100">
                <!-- Tab Handles -->
                <div class="flex border-b border-slate-100 pb-4">
                    <button id="btn-visi" class="flex-1 text-center pb-4 font-display font-bold text-lg text-emerald-900 border-b-2 border-emerald-900 focus:outline-none transition-all duration-300">
                        Visi Desa
                    </button>
                    <button id="btn-misi" class="flex-1 text-center pb-4 font-display font-bold text-lg text-slate-400 border-b-2 border-transparent focus:outline-none hover:text-slate-600 transition-all duration-300">
                        Misi Desa
                    </button>
                </div>

                <!-- Tab Panels -->
                <div class="mt-8">
                    <!-- Visi Content -->
                    <div id="content-visi" class="transition-opacity duration-300 block">
                        <blockquote class="border-l-4 border-amber-600 pl-4 py-2 text-slate-700 italic font-medium text-lg leading-relaxed">
                            "Mewujudkan Desa Jambelaer yang Mandiri, Sejahtera, Berbasis Pertanian Berkelanjutan, dan Teguh Memegang Nilai Budaya Siliwangi pada Tahun 2030."
                        </blockquote>
                        <p class="text-slate-500 font-light mt-4 leading-relaxed text-sm">
                            Visi ini menjadi arah pembangunan desa kami dalam mengoptimalkan potensi bumi, memberdayakan sumber daya manusia yang berakhlak mulia, dan menciptakan tata kelola pemerintahan desa yang bersih dan akuntabel.
                        </p>
                    </div>

                    <!-- Misi Content -->
                    <div id="content-misi" class="transition-opacity duration-300 hidden">
                        <ul class="space-y-4">
                            <li class="flex items-start">
                                <span class="flex-shrink-0 w-6 h-6 rounded-full bg-emerald-50 text-emerald-800 flex items-center justify-center font-bold text-xs mr-3 mt-1">1</span>
                                <span class="text-slate-600 font-light text-sm sm:text-base">Meningkatkan produktivitas pertanian melalui modernisasi alat pertanian ramah lingkungan dan pendampingan intensif bagi kelompok tani.</span>
                            </li>
                            <li class="flex items-start">
                                <span class="flex-shrink-0 w-6 h-6 rounded-full bg-emerald-50 text-emerald-800 flex items-center justify-center font-bold text-xs mr-3 mt-1">2</span>
                                <span class="text-slate-600 font-light text-sm sm:text-base">Mendorong pertumbuhan UMKM desa melalui program digitalisasi pemasaran dan penyediaan akses permodalan bergulir.</span>
                            </li>
                            <li class="flex items-start">
                                <span class="flex-shrink-0 w-6 h-6 rounded-full bg-emerald-50 text-emerald-800 flex items-center justify-center font-bold text-xs mr-3 mt-1">3</span>
                                <span class="text-slate-600 font-light text-sm sm:text-base">Melestarikan kesenian daerah Sunda dan tradisi Ruwatan Bumi sebagai benteng identitas dan daya tarik pariwisata budaya desa.</span>
                            </li>
                            <li class="flex items-start">
                                <span class="flex-shrink-0 w-6 h-6 rounded-full bg-emerald-50 text-emerald-800 flex items-center justify-center font-bold text-xs mr-3 mt-1">4</span>
                                <span class="text-slate-600 font-light text-sm sm:text-base">Menyelenggarakan pelayanan administrasi desa yang cepat, ramah, digital, tanpa diskriminasi melalui inovasi e-Office Desa.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- UMKM SECTION -->
    <section id="umkm" class="py-24 bg-gradient-to-b from-white to-ivory relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 reveal-on-scroll">
                <span class="text-xs font-bold tracking-widest uppercase text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full">Kreativitas Lokal</span>
                <h2 class="font-display font-extrabold text-3xl sm:text-4xl text-emerald-950 mt-3">Karya & Produk Unggulan UMKM</h2>
                <p class="mt-4 text-slate-500 font-light text-sm sm:text-base">
                    Dukung perekonomian lokal dengan membeli produk khas Desa Jambelaer. Diproduksi secara lokal, higienis, dan ramah lingkungan oleh warga desa.
                </p>
                <div class="w-16 h-1 bg-gradient-to-r from-emerald-800 to-amber-600 mx-auto mt-4 rounded-full"></div>
            </div>

            <!-- Filter Buttons -->
            <div class="flex flex-wrap justify-center gap-3 mb-12 reveal-on-scroll delay-100">
                <button class="filter-btn active px-6 py-2.5 rounded-full text-xs font-bold tracking-wide uppercase transition-all duration-300" data-filter="all">Semua</button>
                <button class="filter-btn px-6 py-2.5 rounded-full text-xs font-bold tracking-wide uppercase transition-all duration-300" data-filter="makanan">Makanan</button>
                <button class="filter-btn px-6 py-2.5 rounded-full text-xs font-bold tracking-wide uppercase transition-all duration-300" data-filter="kerajinan">Kerajinan</button>
                <button class="filter-btn px-6 py-2.5 rounded-full text-xs font-bold tracking-wide uppercase transition-all duration-300" data-filter="pertanian">Pertanian</button>
            </div>

            <!-- Products Grid -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8 reveal-on-scroll delay-200">
                <!-- Product Card 1 -->
                <div class="product-card bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col h-full" data-category="pertanian,makanan">
                    <div class="relative overflow-hidden h-48">
                        <span class="absolute top-4 left-4 z-10 px-3 py-1 rounded-full text-xxs font-extrabold tracking-wider uppercase bg-emerald-50 text-emerald-850 shadow-sm">Pertanian</span>
                        <img src="https://images.unsplash.com/photo-1608039829572-78524f79c4c7?auto=format&fit=crop&w=600&q=80" alt="Gula Aren Asli" class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-6 flex-grow flex flex-col justify-between">
                        <div>
                            <span class="text-xxs font-bold text-slate-400 tracking-wider block uppercase">KWT Melati Lestari</span>
                            <h3 class="font-display font-bold text-lg text-emerald-950 mt-1">Gula Aren Cetak Murni</h3>
                            <p class="text-xs text-slate-500 font-light mt-2 leading-relaxed">
                                Diproses tradisional dari nira pohon aren murni tanpa pemanis buatan. Wangi khas dan legit natural.
                            </p>
                        </div>
                        <div class="pt-6 border-t border-slate-100 mt-4 flex items-center justify-between">
                            <div>
                                <span class="text-xxs font-semibold text-slate-400 block">Mulai Dari</span>
                                <span class="font-display font-extrabold text-sm text-amber-705">Rp 15.000 <span class="text-xxs text-slate-400 font-light">/ kg</span></span>
                            </div>
                            <a href="https://wa.me/6281234567890?text=Halo%20Admin%20Desa%20Jambelaer,%20saya%20ingin%20memesan%20Gula%20Aren%20Cetak%20Murni." target="_blank" class="w-10 h-10 rounded-full bg-emerald-50 hover:bg-emerald-900 hover:text-white text-emerald-800 flex items-center justify-center transition-all duration-200 shadow-sm">
                                <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Product Card 2 -->
                <div class="product-card bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col h-full" data-category="makanan">
                    <div class="relative overflow-hidden h-48">
                        <span class="absolute top-4 left-4 z-10 px-3 py-1 rounded-full text-xxs font-extrabold tracking-wider uppercase bg-amber-50 text-amber-850 shadow-sm">Makanan</span>
                        <img src="https://images.unsplash.com/photo-1566847438217-76e82d383f84?auto=format&fit=crop&w=600&q=80" alt="Keripik Singkong" class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-6 flex-grow flex flex-col justify-between">
                        <div>
                            <span class="text-xxs font-bold text-slate-400 tracking-wider block uppercase">UMKM Sumber Barokah</span>
                            <h3 class="font-display font-bold text-lg text-emerald-950 mt-1">Keripik Singkong Renyah</h3>
                            <p class="text-xs text-slate-500 font-light mt-2 leading-relaxed">
                                Singkong pilihan dipotong tipis dibumbui bawang putih gurih alami. Sangat renyah dan empuk digigit.
                            </p>
                        </div>
                        <div class="pt-6 border-t border-slate-100 mt-4 flex items-center justify-between">
                            <div>
                                <span class="text-xxs font-semibold text-slate-400 block">Mulai Dari</span>
                                <span class="font-display font-extrabold text-sm text-amber-755">Rp 8.000 <span class="text-xxs text-slate-400 font-light">/ bks</span></span>
                            </div>
                            <a href="https://wa.me/6281234567890?text=Halo%20Admin%20Desa%20Jambelaer,%20saya%20ingin%20memesan%20Keripik%20Singkong%20Renyah." target="_blank" class="w-10 h-10 rounded-full bg-emerald-50 hover:bg-emerald-900 hover:text-white text-emerald-800 flex items-center justify-center transition-all duration-200 shadow-sm">
                                <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Product Card 3 -->
                <div class="product-card bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col h-full" data-category="kerajinan">
                    <div class="relative overflow-hidden h-48">
                        <span class="absolute top-4 left-4 z-10 px-3 py-1 rounded-full text-xxs font-extrabold tracking-wider uppercase bg-emerald-50 text-emerald-850 shadow-sm">Kerajinan</span>
                        <img src="https://images.unsplash.com/photo-1531971589569-0d9370cbe1e5?auto=format&fit=crop&w=600&q=80" alt="Kerajinan Bambu" class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-6 flex-grow flex flex-col justify-between">
                        <div>
                            <span class="text-xxs font-bold text-slate-400 tracking-wider block uppercase">Galeri Bambu Jambelaer</span>
                            <h3 class="font-display font-bold text-lg text-emerald-950 mt-1">Gantungan & Keranjang Bambu</h3>
                            <p class="text-xs text-slate-500 font-light mt-2 leading-relaxed">
                                Anyaman bambu lokal halus buatan tangan pengrajin sepuh desa. Kuat, aestetik, dan serbaguna.
                            </p>
                        </div>
                        <div class="pt-6 border-t border-slate-100 mt-4 flex items-center justify-between">
                            <div>
                                <span class="text-xxs font-semibold text-slate-400 block">Mulai Dari</span>
                                <span class="font-display font-extrabold text-sm text-amber-755">Rp 25.000 <span class="text-xxs text-slate-400 font-light">/ pcs</span></span>
                            </div>
                            <a href="https://wa.me/6281234567890?text=Halo%20Admin%20Desa%20Jambelaer,%20saya%20ingin%20memesan%20Keranjang%20Bambu." target="_blank" class="w-10 h-10 rounded-full bg-emerald-50 hover:bg-emerald-900 hover:text-white text-emerald-800 flex items-center justify-center transition-all duration-200 shadow-sm">
                                <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Product Card 4 -->
                <div class="product-card bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col h-full" data-category="pertanian">
                    <div class="relative overflow-hidden h-48">
                        <span class="absolute top-4 left-4 z-10 px-3 py-1 rounded-full text-xxs font-extrabold tracking-wider uppercase bg-amber-50 text-amber-855 shadow-sm">Pertanian</span>
                        <img src="https://images.unsplash.com/photo-1586201375761-83865001e31c?auto=format&fit=crop&w=600&q=80" alt="Beras Organik" class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-6 flex-grow flex flex-col justify-between">
                        <div>
                            <span class="text-xxs font-bold text-slate-400 tracking-wider block uppercase">Gapoktan Sawah Asri</span>
                            <h3 class="font-display font-bold text-lg text-emerald-950 mt-1">Beras Organik Unggul</h3>
                            <p class="text-xs text-slate-500 font-light mt-2 leading-relaxed">
                                Ditanam menggunakan metode organik murni dari air pegunungan Subang. Pulen, sehat, tinggi nutrisi.
                            </p>
                        </div>
                        <div class="pt-6 border-t border-slate-100 mt-4 flex items-center justify-between">
                            <div>
                                <span class="text-xxs font-semibold text-slate-400 block">Mulai Dari</span>
                                <span class="font-display font-extrabold text-sm text-amber-755">Rp 18.000 <span class="text-xxs text-slate-400 font-light">/ kg</span></span>
                            </div>
                            <a href="https://wa.me/6281234567890?text=Halo%20Admin%20Desa%20Jambelaer,%20saya%20ingin%20memesan%20Beras%20Organik%20Unggul." target="_blank" class="w-10 h-10 rounded-full bg-emerald-50 hover:bg-emerald-900 hover:text-white text-emerald-800 flex items-center justify-center transition-all duration-200 shadow-sm">
                                <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- BUDAYA SECTION -->
    <section id="budaya" class="py-24 bg-white/60 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 reveal-on-scroll">
                <span class="text-xs font-bold tracking-widest uppercase text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full">Kearifan Sunda</span>
                <h2 class="font-display font-extrabold text-3xl sm:text-4xl text-emerald-950 mt-3">Pelestarian Seni & Tradisi Budaya</h2>
                <p class="mt-4 text-slate-500 font-light text-sm sm:text-base">
                    Masyarakat Desa Jambelaer memegang teguh falsafah kebersamaan dan merawat tradisi Sunda peninggalan leluhur sebagai identitas kehidupan.
                </p>
                <div class="w-16 h-1 bg-gradient-to-r from-emerald-800 to-amber-600 mx-auto mt-4 rounded-full"></div>
            </div>

            <!-- Culture Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 reveal-on-scroll delay-100">
                <!-- Culture Item 1 -->
                <div class="culture-card cursor-pointer group relative overflow-hidden rounded-3xl h-96 shadow-md border border-slate-100" 
                     data-title="Ruwatan Bumi (Hajat Bumi)"
                     data-desc="Tradisi Ruwatan Bumi (atau Hajat Bumi) diadakan setahun sekali setelah panen raya sebagai wujud syukur masyarakat Desa Jambelaer kepada Tuhan Yang Maha Esa atas kelimpahan hasil bumi pertanian. Upacara adat diisi dengan mengarak tumpeng besar, doa bersama para sepuh desa, pagelaran wayang golek, serta saling bertukar hidangan makanan antar tetangga untuk mempererat silaturahmi gotong royong."
                     data-img="https://images.unsplash.com/photo-1530595467537-0b5996c41f2d?auto=format&fit=crop&w=800&q=80">
                    <img src="https://images.unsplash.com/photo-1530595467537-0b5996c41f2d?auto=format&fit=crop&w=600&h=800&q=80" alt="Ruwatan Bumi" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-emerald-950 via-emerald-900/40 to-transparent flex flex-col justify-end p-6">
                        <span class="text-xxs font-bold text-emerald-300 tracking-widest uppercase block mb-1">Upacara Adat</span>
                        <h3 class="font-display font-bold text-xl text-white">Ruwatan Bumi</h3>
                        <p class="text-xs text-white/70 line-clamp-2 mt-2 font-light">Upacara adat tanda syukur hasil bumi pertanian desa yang melimpah.</p>
                        <span class="inline-flex items-center text-xs font-semibold text-amber-400 mt-4 group-hover:underline">
                            Lihat Detail
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5 ml-1 group-hover:translate-x-1 transition-transform"></i>
                        </span>
                    </div>
                </div>

                <!-- Culture Item 2 -->
                <div class="culture-card cursor-pointer group relative overflow-hidden rounded-3xl h-96 shadow-md border border-slate-100"
                     data-title="Kesenian Sisingaan"
                     data-desc="Kesenian Sisingaan adalah pertunjukan boneka singa raksasa khas Kabupaten Subang yang ditunggangi anak-anak lalu diusung oleh para pemuda gagah sambil menari mengikuti irama tabuhan kendang pencak silat. Pertunjukan ini sering dijumpai dalam upacara khitanan anak atau perayaan hari besar desa (Milangkala), melambangkan semangat persatuan, patriotisme, dan sukacita kebersamaan warga."
                     data-img="https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?auto=format&fit=crop&w=800&q=80">
                    <img src="https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?auto=format&fit=crop&w=600&h=800&q=80" alt="Seni Sisingaan" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-emerald-950 via-emerald-900/40 to-transparent flex flex-col justify-end p-6">
                        <span class="text-xxs font-bold text-emerald-300 tracking-widest uppercase block mb-1">Seni Pertunjukan</span>
                        <h3 class="font-display font-bold text-xl text-white">Seni Sisingaan</h3>
                        <p class="text-xs text-white/70 line-clamp-2 mt-2 font-light">Atraksi budaya khas Subang pemacu semangat kebersamaan rakyat.</p>
                        <span class="inline-flex items-center text-xs font-semibold text-amber-400 mt-4 group-hover:underline">
                            Lihat Detail
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5 ml-1 group-hover:translate-x-1 transition-transform"></i>
                        </span>
                    </div>
                </div>

                <!-- Culture Item 3 -->
                <div class="culture-card cursor-pointer group relative overflow-hidden rounded-3xl h-96 shadow-md border border-slate-100"
                     data-title="Pencak Silat Tradisional"
                     data-desc="Sebagai bentuk pelestarian bela diri warisan Sunda, Desa Jambelaer memiliki padepokan pencak silat lokal tempat berkumpulnya pemuda untuk melatih ketahanan fisik, konsentrasi mental, dan kehalusan budi pekerti. Dengan iringan musik terompet Sunda dan kendang, gerakan jurus silat diperagakan dalam pergelaran milangkala desa."
                     data-img="https://images.unsplash.com/photo-1555597673-b21d5c935865?auto=format&fit=crop&w=800&q=80">
                    <img src="https://images.unsplash.com/photo-1555597673-b21d5c935865?auto=format&fit=crop&w=600&h=800&q=80" alt="Pencak Silat" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-emerald-950 via-emerald-900/40 to-transparent flex flex-col justify-end p-6">
                        <span class="text-xxs font-bold text-emerald-300 tracking-widest uppercase block mb-1">Seni Bela Diri</span>
                        <h3 class="font-display font-bold text-xl text-white">Pencak Silat</h3>
                        <p class="text-xs text-white/70 line-clamp-2 mt-2 font-light">Pelatihan fisik dan spiritual bela diri Sunda yang menjunjung persaudaraan.</p>
                        <span class="inline-flex items-center text-xs font-semibold text-amber-400 mt-4 group-hover:underline">
                            Lihat Detail
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5 ml-1 group-hover:translate-x-1 transition-transform"></i>
                        </span>
                    </div>
                </div>

                <!-- Culture Item 4 -->
                <div class="culture-card cursor-pointer group relative overflow-hidden rounded-3xl h-96 shadow-md border border-slate-100"
                     data-title="Milangkala & Karnaval Desa"
                     data-desc="Milangkala atau hari jadi Desa Jambelaer dirayakan meriah setiap tahun dengan karnaval budaya. Setiap dusun bergotong royong membuat hiasan replika hasil bumi, memakai pakaian adat sunda pengantin atau kebaya, serta memamerkan kesenian kreasi masing-masing dusun dalam parade keliling sepanjang jalan desa."
                     data-img="https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=800&q=80">
                    <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=600&h=800&q=80" alt="Karnaval Budaya" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-emerald-950 via-emerald-900/40 to-transparent flex flex-col justify-end p-6">
                        <span class="text-xxs font-bold text-emerald-300 tracking-widest uppercase block mb-1">Festival Tahunan</span>
                        <h3 class="font-display font-bold text-xl text-white">Milangkala Desa</h3>
                        <p class="text-xs text-white/70 line-clamp-2 mt-2 font-light">Peringatan hari lahir desa yang diramaikan pawai budaya kreasi warga.</p>
                        <span class="inline-flex items-center text-xs font-semibold text-amber-400 mt-4 group-hover:underline">
                            Lihat Detail
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5 ml-1 group-hover:translate-x-1 transition-transform"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- KONTAK SECTION -->
    <section id="kontak" class="py-24 bg-gradient-to-b from-ivory to-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 reveal-on-scroll">
                <span class="text-xs font-bold tracking-widest uppercase text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full">Layanan Informasi</span>
                <h2 class="font-display font-extrabold text-3xl sm:text-4xl text-emerald-950 mt-3">Hubungi Kantor Desa Kami</h2>
                <p class="mt-4 text-slate-500 font-light text-sm sm:text-base">
                    Apakah Anda memiliki pertanyaan mengenai pelayanan administrasi, potensi kemitraan UMKM, atau kunjungan budaya? Tim kami siap melayani Anda.
                </p>
                <div class="w-16 h-1 bg-gradient-to-r from-emerald-800 to-amber-600 mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="grid lg:grid-cols-12 gap-12 items-stretch reveal-on-scroll delay-100">
                <!-- Left Details Box -->
                <div class="lg:col-span-5 bg-gradient-to-br from-emerald-950 to-emerald-900 rounded-3xl p-8 sm:p-10 text-white flex flex-col justify-between shadow-lg">
                    <div class="space-y-8">
                        <div>
                            <h3 class="font-display font-bold text-2xl text-white">Kantor Desa Jambelaer</h3>
                            <p class="text-emerald-200/70 text-xs font-light mt-1">Kecamatan Dawuan, Kabupaten Subang, Jawa Barat, 41270</p>
                        </div>

                        <!-- Contact List -->
                        <div class="space-y-6">
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0 text-amber-400">
                                    <i data-lucide="map-pin" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <span class="text-xxs text-emerald-300 font-semibold tracking-wider block uppercase">Alamat Lengkap</span>
                                    <span class="text-sm font-light text-emerald-50 mt-1 block leading-relaxed">
                                        Jl. Raya Jambelaer No. 12, Dawuan, Subang, Jawa Barat, 41270
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0 text-amber-400">
                                    <i data-lucide="phone" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <span class="text-xxs text-emerald-300 font-semibold tracking-wider block uppercase">Hubungi Kami</span>
                                    <span class="text-sm font-light text-emerald-50 mt-1 block">(0260) 123456 / +62 812-3456-7890</span>
                                </div>
                            </div>

                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0 text-amber-400">
                                    <i data-lucide="mail" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <span class="text-xxs text-emerald-300 font-semibold tracking-wider block uppercase">Email Resmi</span>
                                    <span class="text-sm font-light text-emerald-50 mt-1 block">info@jambelaer-subang.desa.id</span>
                                </div>
                            </div>

                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0 text-amber-400">
                                    <i data-lucide="clock" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <span class="text-xxs text-emerald-300 font-semibold tracking-wider block uppercase">Jam Operasional</span>
                                    <span class="text-sm font-light text-emerald-50 mt-1 block">Senin - Jumat: 08:00 - 15:30 WIB</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-8 border-t border-white/10 mt-8">
                        <span class="text-xxs text-emerald-300 font-semibold tracking-wider block uppercase mb-3">Ikuti Media Sosial Desa</span>
                        <div class="flex items-center space-x-3">
                            <a href="#" class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center hover:bg-amber-600 hover:text-white transition-all duration-200 text-emerald-100">
                                <i data-lucide="facebook" class="w-4 h-4"></i>
                            </a>
                            <a href="#" class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center hover:bg-amber-600 hover:text-white transition-all duration-200 text-emerald-100">
                                <i data-lucide="instagram" class="w-4 h-4"></i>
                            </a>
                            <a href="#" class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center hover:bg-amber-600 hover:text-white transition-all duration-200 text-emerald-100">
                                <i data-lucide="youtube" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Form / Map Container -->
                <div class="lg:col-span-7 flex flex-col justify-between space-y-6">
                    <!-- Form Card -->
                    <div class="bg-white border border-slate-100 rounded-3xl p-8 sm:p-10 shadow-sm flex-grow">
                        <h3 class="font-display font-bold text-xl text-emerald-950 mb-6">Kirim Pertanyaan / Aspirasi</h3>
                        
                        <!-- Success Alert Message -->
                        <div id="contact-success-alert" class="hidden mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 flex items-start space-x-3 transition-all duration-300">
                            <div class="w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0 text-emerald-800">
                                <i data-lucide="check" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <span class="font-bold text-emerald-950 text-sm block">Pesan Berhasil Terkirim!</span>
                                <span class="text-xs text-emerald-700/80 font-light mt-0.5 block">Terima kasih atas aspirasi Anda. Kami akan segera meninjau pesan Anda.</span>
                            </div>
                        </div>

                        <form id="contact-form" class="space-y-6">
                            @csrf
                            <div class="grid sm:grid-cols-2 gap-6">
                                <!-- Floating Input 1 -->
                                <div class="relative">
                                    <input type="text" id="name" name="name" required placeholder=" " 
                                           class="peer w-full px-4 pt-6 pb-2 border border-slate-200 rounded-xl focus:border-emerald-700 focus:ring-1 focus:ring-emerald-750 outline-none transition-all duration-200 text-sm font-medium animate-none">
                                    <label for="name" 
                                           class="absolute left-4 top-4 text-xs font-semibold text-slate-400 tracking-wider uppercase pointer-events-none transform origin-left transition-all duration-200 peer-placeholder-shown:text-sm peer-placeholder-shown:font-medium peer-placeholder-shown:top-4 peer-focus:-translate-y-2.5 peer-focus:scale-75 peer-focus:text-emerald-700 peer-focus:top-4 -translate-y-2.5 scale-75">
                                        Nama Lengkap
                                    </label>
                                </div>
                                <!-- Floating Input 2 -->
                                <div class="relative">
                                    <input type="email" id="email" name="email" required placeholder=" " 
                                           class="peer w-full px-4 pt-6 pb-2 border border-slate-200 rounded-xl focus:border-emerald-700 focus:ring-1 focus:ring-emerald-750 outline-none transition-all duration-200 text-sm font-medium animate-none">
                                    <label for="email" 
                                           class="absolute left-4 top-4 text-xs font-semibold text-slate-400 tracking-wider uppercase pointer-events-none transform origin-left transition-all duration-200 peer-placeholder-shown:text-sm peer-placeholder-shown:font-medium peer-placeholder-shown:top-4 peer-focus:-translate-y-2.5 peer-focus:scale-75 peer-focus:text-emerald-700 peer-focus:top-4 -translate-y-2.5 scale-75">
                                        Alamat Email
                                    </label>
                                </div>
                            </div>

                            <div class="relative">
                                <input type="text" id="subject" name="subject" required placeholder=" " 
                                       class="peer w-full px-4 pt-6 pb-2 border border-slate-200 rounded-xl focus:border-emerald-700 focus:ring-1 focus:ring-emerald-750 outline-none transition-all duration-200 text-sm font-medium animate-none">
                                <label for="subject" 
                                       class="absolute left-4 top-4 text-xs font-semibold text-slate-400 tracking-wider uppercase pointer-events-none transform origin-left transition-all duration-200 peer-placeholder-shown:text-sm peer-placeholder-shown:font-medium peer-placeholder-shown:top-4 peer-focus:-translate-y-2.5 peer-focus:scale-75 peer-focus:text-emerald-700 peer-focus:top-4 -translate-y-2.5 scale-75">
                                    Subjek Pesan
                                </label>
                            </div>

                            <div class="relative">
                                <textarea id="message" name="message" rows="4" required placeholder=" " 
                                          class="peer w-full px-4 pt-6 pb-2 border border-slate-200 rounded-xl focus:border-emerald-700 focus:ring-1 focus:ring-emerald-750 outline-none transition-all duration-200 text-sm font-medium resize-none animate-none"></textarea>
                                <label for="message" 
                                       class="absolute left-4 top-4 text-xs font-semibold text-slate-400 tracking-wider uppercase pointer-events-none transform origin-left transition-all duration-200 peer-placeholder-shown:text-sm peer-placeholder-shown:font-medium peer-placeholder-shown:top-4 peer-focus:-translate-y-2.5 peer-focus:scale-75 peer-focus:text-emerald-700 peer-focus:top-4 -translate-y-2.5 scale-75">
                                    Isi Pesan / Aspirasi
                                </label>
                            </div>

                            <button type="submit" class="w-full inline-flex items-center justify-center h-14 text-sm font-bold tracking-wide uppercase text-white bg-emerald-900 hover:bg-emerald-800 rounded-xl shadow-md transition-all duration-200 cursor-pointer">
                                Kirim Aspirasi
                                <i data-lucide="send" class="w-4 h-4 ml-2"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Map Card -->
                    <div class="h-64 rounded-3xl border border-slate-100 overflow-hidden shadow-sm">
                        <!-- Embed Google Maps with focus on Dawuan, Subang area -->
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3962.338781423455!2d107.6974104!3d-6.7285741!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6922442cf89a5b%3A0xe5a33c1f60ca8b99!2sJambelaer%2C%20Kec.%20Dawuan%2C%20Kabupaten%20Subang%2C%20Jawa%20Barat!5e0!3m2!1sid!2sid!4v1720894000000!5m2!1sid!2sid" 
                            width="100%" 
                            height="100%" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-emerald-950 border-t border-emerald-900 pt-16 pb-8 text-white relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12 pb-12 border-b border-white/10">
                <!-- Col 1: Brand -->
                <div class="lg:col-span-5 space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-lg bg-emerald-600 flex items-center justify-center shadow-md">
                            <i data-lucide="map" class="w-4.5 h-4.5 text-white"></i>
                        </div>
                        <span class="font-display font-extrabold text-lg tracking-tight text-white block">Pemerintah Desa Jambelaer</span>
                    </div>
                    <p class="text-xs font-light text-emerald-250/80 leading-relaxed max-w-sm">
                        Portal Layanan dan Profil Desa Jambelaer, Kecamatan Dawuan, Kabupaten Subang. Memajukan desa melalui digitalisasi potensi pariwisata, budaya lokal, dan produk unggulan UMKM daerah.
                    </p>
                </div>

                <!-- Col 2: Navigation Links -->
                <div class="lg:col-span-4 space-y-4">
                    <h4 class="font-display font-bold text-sm tracking-wider uppercase text-emerald-300">Navigasi Halaman</h4>
                    <div class="grid grid-cols-2 gap-x-4 gap-y-2">
                        <a href="#home" class="text-xs text-emerald-250/70 hover:text-white font-medium transition-colors duration-200">Home</a>
                        <a href="#tentang-kami" class="text-xs text-emerald-250/70 hover:text-white font-medium transition-colors duration-200">Tentang Kami</a>
                        <a href="#umkm" class="text-xs text-emerald-250/70 hover:text-white font-medium transition-colors duration-200">UMKM</a>
                        <a href="#budaya" class="text-xs text-emerald-250/70 hover:text-white font-medium transition-colors duration-200">Budaya</a>
                        <a href="#kontak" class="text-xs text-emerald-250/70 hover:text-white font-medium transition-colors duration-200">Kontak</a>
                    </div>
                </div>

                <!-- Col 3: Subang Details -->
                <div class="lg:col-span-3 space-y-4">
                    <h4 class="font-display font-bold text-sm tracking-wider uppercase text-emerald-300">Hubungi Kami</h4>
                    <ul class="space-y-2 text-xs font-light text-emerald-250/75">
                        <li class="flex items-center space-x-2">
                            <i data-lucide="phone" class="w-3.5 h-3.5 flex-shrink-0 text-amber-500"></i>
                            <span>(0260) 123456 / +62 812-3456-7890</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i data-lucide="mail" class="w-3.5 h-3.5 flex-shrink-0 text-amber-500"></i>
                            <span>info@jambelaer-subang.desa.id</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i data-lucide="map-pin" class="w-3.5 h-3.5 flex-shrink-0 text-amber-500"></i>
                            <span>Dawuan, Subang, Jawa Barat 41270</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Note -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xxs font-light text-emerald-250/50">
                <p>Copyright &copy; 2026 Pemerintah Desa Jambelaer. Hak Cipta Dilindungi Undang-Undang.</p>
                <div class="flex items-center space-x-4">
                    <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                    <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- BUDAYA DETAIL MODAL -->
    <div id="culture-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-emerald-955/80 backdrop-blur-md hidden transition-opacity duration-300 opacity-0" aria-modal="true" role="dialog">
        <div class="bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-2xl max-w-2xl w-full transform scale-95 transition-transform duration-300 flex flex-col max-h-[90vh]">
            <!-- Modal Banner -->
            <div class="h-64 sm:h-80 relative flex-shrink-0">
                <img id="modal-img" src="" alt="Budaya Detail" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-emerald-950 via-emerald-950/20 to-transparent"></div>
                <!-- Close Button inside Image Banner -->
                <button id="modal-close-btn" class="absolute top-4 right-4 w-9 h-9 rounded-full bg-white/20 hover:bg-white/40 text-white flex items-center justify-center transition-all focus:outline-none cursor-pointer">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
                <div class="absolute bottom-6 left-6 right-6 text-white">
                    <span class="text-xxs font-bold text-emerald-300 tracking-wider uppercase block">Detail Tradisi & Seni</span>
                    <h3 id="modal-title" class="font-display font-extrabold text-2xl mt-1">N/A</h3>
                </div>
            </div>

            <!-- Modal Content (Scrollable) -->
            <div class="p-6 sm:p-8 overflow-y-auto flex-grow">
                <p id="modal-desc" class="text-slate-650 font-light text-sm sm:text-base leading-relaxed">
                    N/A
                </p>
                <div class="mt-8 flex justify-end">
                    <button id="modal-close-btn-bottom" class="px-5 py-2.5 text-xs font-bold tracking-wide uppercase text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors focus:outline-none cursor-pointer">
                        Tutup Detail
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- BACK TO TOP BUTTON -->
    <button id="back-to-top" class="fixed bottom-6 right-6 w-12 h-12 rounded-xl bg-white hover:bg-emerald-900 border border-slate-150 shadow-md hover:text-white text-emerald-900 flex items-center justify-center transition-all duration-300 transform translate-y-16 opacity-0 z-40 focus:outline-none cursor-pointer">
        <i data-lucide="arrow-up" class="w-5 h-5"></i>
    </button>

    <!-- INLINE JAVASCRIPT FOR INTERACTIVE LOGIC -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Mobile Menu Toggle
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            const hamburgerIcon = document.getElementById('hamburger-icon');
            const closeIcon = document.getElementById('close-icon');

            mobileMenuBtn.addEventListener('click', function() {
                const isExpanded = mobileMenuBtn.getAttribute('aria-expanded') === 'true';
                mobileMenuBtn.setAttribute('aria-expanded', !isExpanded);
                mobileMenu.classList.toggle('hidden');
                hamburgerIcon.classList.toggle('hidden');
                closeIcon.classList.toggle('hidden');
            });

            // Close mobile menu when clicking nav links
            const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');
            mobileNavLinks.forEach(link => {
                link.addEventListener('click', function() {
                    mobileMenu.classList.add('hidden');
                    hamburgerIcon.classList.remove('hidden');
                    closeIcon.classList.add('hidden');
                    mobileMenuBtn.setAttribute('aria-expanded', 'false');
                });
            });

            // 2. Sticky Navbar and Back to Top scroll effects
            const header = document.getElementById('main-header');
            const backToTopBtn = document.getElementById('back-to-top');

            window.addEventListener('scroll', function() {
                if (window.scrollY > 50) {
                    header.classList.add('bg-white/90', 'backdrop-blur-md', 'shadow-sm', 'border-slate-100');
                    header.classList.remove('border-transparent');
                } else {
                    header.classList.remove('bg-white/90', 'backdrop-blur-md', 'shadow-sm', 'border-slate-100');
                    header.classList.add('border-transparent');
                }

                if (window.scrollY > 400) {
                    backToTopBtn.classList.remove('translate-y-16', 'opacity-0');
                    backToTopBtn.classList.add('translate-y-0', 'opacity-100');
                } else {
                    backToTopBtn.classList.remove('translate-y-0', 'opacity-100');
                    backToTopBtn.classList.add('translate-y-16', 'opacity-0');
                }
            });

            backToTopBtn.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });

            // 3. Visi & Misi Tab Switcher
            const btnVisi = document.getElementById('btn-visi');
            const btnMisi = document.getElementById('btn-misi');
            const contentVisi = document.getElementById('content-visi');
            const contentMisi = document.getElementById('content-misi');

            btnVisi.addEventListener('click', function() {
                // Style tabs
                btnVisi.classList.add('text-emerald-900', 'border-emerald-900');
                btnVisi.classList.remove('text-slate-400', 'border-transparent');
                btnMisi.classList.remove('text-emerald-900', 'border-emerald-900');
                btnMisi.classList.add('text-slate-400', 'border-transparent');

                // Toggle visibility
                contentVisi.classList.remove('hidden');
                contentVisi.classList.add('block');
                contentMisi.classList.add('hidden');
                contentMisi.classList.remove('block');
            });

            btnMisi.addEventListener('click', function() {
                // Style tabs
                btnMisi.classList.add('text-emerald-900', 'border-emerald-900');
                btnMisi.classList.remove('text-slate-400', 'border-transparent');
                btnVisi.classList.remove('text-emerald-900', 'border-emerald-900');
                btnVisi.classList.add('text-slate-400', 'border-transparent');

                // Toggle visibility
                contentMisi.classList.remove('hidden');
                contentMisi.classList.add('block');
                contentVisi.classList.add('hidden');
                contentVisi.classList.remove('block');
            });

            // 4. UMKM Product Filters
            const filterBtns = document.querySelectorAll('.filter-btn');
            const productCards = document.querySelectorAll('.product-card');

            // Apply base styling to filters
            filterBtns.forEach(btn => {
                if (btn.classList.contains('active')) {
                    btn.classList.add('bg-emerald-900', 'text-white', 'shadow-sm');
                    btn.classList.remove('bg-white', 'text-slate-650', 'border', 'border-slate-200');
                } else {
                    btn.classList.add('bg-white', 'text-slate-650', 'border', 'border-slate-200');
                    btn.classList.remove('bg-emerald-900', 'text-white', 'shadow-sm');
                }

                btn.addEventListener('click', function() {
                    const category = btn.getAttribute('data-filter');

                    // Set active state on button
                    filterBtns.forEach(b => {
                        b.classList.remove('active', 'bg-emerald-900', 'text-white', 'shadow-sm');
                        b.classList.add('bg-white', 'text-slate-650', 'border', 'border-slate-200');
                    });
                    btn.classList.add('active', 'bg-emerald-900', 'text-white', 'shadow-sm');
                    btn.classList.remove('bg-white', 'text-slate-650', 'border', 'border-slate-200');

                    // Filter cards
                    productCards.forEach(card => {
                        const cardCategories = card.getAttribute('data-category').split(',');
                        if (category === 'all' || cardCategories.includes(category)) {
                            card.style.display = 'flex';
                            setTimeout(() => {
                                card.style.opacity = '1';
                                card.style.transform = 'scale(1)';
                            }, 50);
                        } else {
                            card.style.opacity = '0';
                            card.style.transform = 'scale(0.95)';
                            setTimeout(() => {
                                card.style.display = 'none';
                            }, 300);
                        }
                    });
                });
            });

            // 5. Budaya Detail Modals
            const cultureCards = document.querySelectorAll('.culture-card');
            const cultureModal = document.getElementById('culture-modal');
            const modalImg = document.getElementById('modal-img');
            const modalTitle = document.getElementById('modal-title');
            const modalDesc = document.getElementById('modal-desc');
            const modalCloseBtn = document.getElementById('modal-close-btn');
            const modalCloseBtnBottom = document.getElementById('modal-close-btn-bottom');

            function openModal(title, desc, img) {
                modalImg.src = img;
                modalTitle.textContent = title;
                modalDesc.textContent = desc;

                cultureModal.classList.remove('hidden');
                // Force a repaint to trigger CSS transitions
                cultureModal.offsetWidth;
                cultureModal.classList.add('opacity-100');
                cultureModal.querySelector('.transform').classList.remove('scale-95');
                cultureModal.querySelector('.transform').classList.add('scale-100');
                document.body.classList.add('overflow-hidden'); // Disable body scroll
            }

            function closeModal() {
                cultureModal.classList.remove('opacity-100');
                cultureModal.querySelector('.transform').classList.remove('scale-100');
                cultureModal.querySelector('.transform').classList.add('scale-95');
                setTimeout(() => {
                    cultureModal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }, 300);
            }

            cultureCards.forEach(card => {
                card.addEventListener('click', function() {
                    const title = card.getAttribute('data-title');
                    const desc = card.getAttribute('data-desc');
                    const img = card.getAttribute('data-img');
                    openModal(title, desc, img);
                });
            });

            modalCloseBtn.addEventListener('click', closeModal);
            modalCloseBtnBottom.addEventListener('click', closeModal);
            cultureModal.addEventListener('click', function(e) {
                if (e.target === cultureModal) {
                    closeModal();
                }
            });

            // ESC key to close modal
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !cultureModal.classList.contains('hidden')) {
                    closeModal();
                }
            });

            // 6. Contact Form AJAX-like simulated response
            const contactForm = document.getElementById('contact-form');
            const successAlert = document.getElementById('contact-success-alert');

            contactForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Simulate AJAX delay
                const submitBtn = contactForm.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <span>Mengirim...</span>
                    <svg class="animate-spin ml-2 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                `;

                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;

                    // Show success state
                    successAlert.classList.remove('hidden');
                    successAlert.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    contactForm.reset();

                    // Hide success alert after 8 seconds
                    setTimeout(() => {
                        successAlert.classList.add('hidden');
                    }, 8000);
                }, 1500);
            });

            // 7. Scroll Reveal and Statistics Counter Animation using Intersection Observer
            const revealElements = document.querySelectorAll('.reveal-on-scroll');
            
            const elementObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                        
                        // If it contains stats numbers, trigger counter
                        const stats = entry.target.querySelectorAll('[data-target]');
                        if (stats.length > 0) {
                            stats.forEach(stat => {
                                animateCounter(stat);
                            });
                        }
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.15,
                rootMargin: '0px 0px -50px 0px'
            });

            revealElements.forEach(el => {
                elementObserver.observe(el);
            });

            function animateCounter(element) {
                const target = parseInt(element.getAttribute('data-target'));
                const duration = 2000; // 2 seconds duration
                const startTime = performance.now();

                function update(currentTime) {
                    const elapsedTime = currentTime - startTime;
                    if (elapsedTime >= duration) {
                        element.textContent = target.toLocaleString('id-ID');
                        return;
                    }
                    const progress = elapsedTime / duration;
                    // Ease out cubic
                    const easeProgress = 1 - Math.pow(1 - progress, 3);
                    const currentVal = Math.floor(easeProgress * target);
                    element.textContent = currentVal.toLocaleString('id-ID');
                    requestAnimationFrame(update);
                }

                requestAnimationFrame(update);
            }
        });
    </script>
</body>
</html>
