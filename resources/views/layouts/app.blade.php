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
            --color-emerald-50:  #ecfdf5;
            --color-amber-50:    #fffbeb;
            --color-amber-600:   #d97706;
            --color-amber-700:   #b45309;
            --color-ivory:       #fdfbf7;
        }

        html { scroll-behavior: smooth; }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track  { background: #fdfbf7; }
        ::-webkit-scrollbar-thumb  { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        .reveal-on-scroll {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.8s cubic-bezier(0.16,1,0.3,1), transform 0.8s cubic-bezier(0.16,1,0.3,1);
        }
        .reveal-on-scroll.active { opacity: 1; transform: translateY(0); }
        .delay-100 { transition-delay: 100ms; }
        .delay-200 { transition-delay: 200ms; }
        .delay-300 { transition-delay: 300ms; }

        .bg-grid-pattern {
            background-size: 40px 40px;
            background-image:
                linear-gradient(to right,  rgba(148,163,184,.05) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(148,163,184,.05) 1px, transparent 1px);
        }
    </style>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    @stack('head')
</head>
<body class="font-sans text-slate-800 bg-ivory bg-grid-pattern selection:bg-emerald-600 selection:text-white antialiased overflow-x-hidden">

    <!-- ══════════════════════════ NAVBAR ══════════════════════════ -->
    <header id="main-header" class="fixed top-0 left-0 w-full z-50 transition-all duration-300 border-b border-transparent">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">

                <!-- Brand -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-900 to-emerald-650 flex items-center justify-center shadow-md group-hover:scale-105 transition-transform duration-300">
                        <i data-lucide="map" class="w-5 h-5 text-white"></i>
                    </div>
                    <div>
                        <span class="font-display font-extrabold text-lg sm:text-xl tracking-tight text-emerald-950 group-hover:text-emerald-800 transition-colors duration-300 block">DESA JAMBELAER</span>
                        <span class="text-xs text-emerald-700/80 font-medium block -mt-1 tracking-wider uppercase">Dawuan, Subang</span>
                    </div>
                </a>

                <!-- Desktop Menu -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}"        class="nav-link font-medium text-sm transition-colors duration-200 {{ request()->routeIs('home')       ? 'text-emerald-800 font-semibold' : 'text-slate-600 hover:text-emerald-800' }}">Home</a>
                    <a href="{{ route('tentang') }}"     class="nav-link font-medium text-sm transition-colors duration-200 {{ request()->routeIs('tentang')     ? 'text-emerald-800 font-semibold' : 'text-slate-600 hover:text-emerald-800' }}">Tentang Kami</a>
                    <a href="{{ route('umkm') }}"        class="nav-link font-medium text-sm transition-colors duration-200 {{ request()->routeIs('umkm')        ? 'text-emerald-800 font-semibold' : 'text-slate-600 hover:text-emerald-800' }}">UMKM</a>
                    <a href="{{ route('budaya') }}"      class="nav-link font-medium text-sm transition-colors duration-200 {{ request()->routeIs('budaya')      ? 'text-emerald-800 font-semibold' : 'text-slate-600 hover:text-emerald-800' }}">Budaya</a>
                    <a href="{{ route('galeri') }}"      class="nav-link font-medium text-sm transition-colors duration-200 {{ request()->routeIs('galeri')      ? 'text-emerald-800 font-semibold' : 'text-slate-600 hover:text-emerald-800' }}">Galeri</a>
                    <a href="{{ route('acara') }}"       class="nav-link font-medium text-sm transition-colors duration-200 {{ request()->routeIs('acara')       ? 'text-emerald-800 font-semibold' : 'text-slate-600 hover:text-emerald-800' }}">Acara</a>
                </nav>

                <!-- CTA -->
                <div class="hidden md:flex items-center">
                    <a href="{{ route('kontak') }}" class="inline-flex items-center justify-center px-5 h-11 text-xs font-semibold tracking-wider uppercase text-white bg-emerald-900 hover:bg-emerald-800 rounded-lg shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-y-0.5">
                        Hubungi Kami
                    </a>
                </div>

                <!-- Mobile Toggle -->
                <button id="mobile-menu-btn" type="button"
                    class="md:hidden inline-flex items-center justify-center p-2 rounded-lg text-slate-600 hover:bg-emerald-50 focus:outline-none transition-colors duration-200"
                    aria-controls="mobile-menu" aria-expanded="false">
                    <i id="hamburger-icon" data-lucide="menu" class="w-6 h-6"></i>
                    <i id="close-icon"     data-lucide="x"    class="w-6 h-6 hidden"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden absolute top-20 left-0 w-full bg-white/95 backdrop-blur-md border-b border-slate-100 shadow-lg py-4">
            <div class="px-4 space-y-2">
                <a href="{{ route('home') }}"    class="block px-4 py-2.5 rounded-lg text-base font-semibold text-slate-700 hover:bg-emerald-50 hover:text-emerald-800 transition-all">Home</a>
                <a href="{{ route('tentang') }}" class="block px-4 py-2.5 rounded-lg text-base font-semibold text-slate-700 hover:bg-emerald-50 hover:text-emerald-800 transition-all">Tentang Kami</a>
                <a href="{{ route('umkm') }}"    class="block px-4 py-2.5 rounded-lg text-base font-semibold text-slate-700 hover:bg-emerald-50 hover:text-emerald-800 transition-all">UMKM</a>
                <a href="{{ route('budaya') }}"  class="block px-4 py-2.5 rounded-lg text-base font-semibold text-slate-700 hover:bg-emerald-50 hover:text-emerald-800 transition-all">Budaya</a>
                <a href="{{ route('galeri') }}"  class="block px-4 py-2.5 rounded-lg text-base font-semibold text-slate-700 hover:bg-emerald-50 hover:text-emerald-800 transition-all">Galeri</a>
                <a href="{{ route('acara') }}"   class="block px-4 py-2.5 rounded-lg text-base font-semibold text-slate-700 hover:bg-emerald-50 hover:text-emerald-800 transition-all">Acara</a>
                <a href="{{ route('kontak') }}"  class="flex items-center justify-center w-full py-3 text-sm font-semibold tracking-wider uppercase text-white bg-emerald-900 rounded-lg shadow-sm mt-2">Hubungi Kami</a>
            </div>
        </div>
    </header>

    <!-- ══════════════════════════ PAGE CONTENT ══════════════════════════ -->
    <main>
        @yield('content')
    </main>

    <!-- ══════════════════════════ FOOTER ══════════════════════════ -->
    <footer class="bg-emerald-950 border-t border-emerald-900 pt-16 pb-8 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12 pb-12 border-b border-white/10">

                <!-- Brand -->
                <div class="lg:col-span-5 space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-lg bg-emerald-600 flex items-center justify-center shadow-md">
                            <i data-lucide="map" class="w-4 h-4 text-white"></i>
                        </div>
                        <span class="font-display font-extrabold text-lg tracking-tight text-white">Pemerintah Desa Jambelaer</span>
                    </div>
                    <p class="text-xs font-light text-emerald-200/70 leading-relaxed max-w-sm">
                        Portal Layanan dan Profil Desa Jambelaer, Kecamatan Dawuan, Kabupaten Subang. Memajukan desa melalui digitalisasi potensi pariwisata, budaya lokal, dan produk unggulan UMKM daerah.
                    </p>
                </div>

                <!-- Nav Links -->
                <div class="lg:col-span-4 space-y-4">
                    <h4 class="font-display font-bold text-sm tracking-wider uppercase text-emerald-300">Navigasi Halaman</h4>
                    <div class="grid grid-cols-2 gap-x-4 gap-y-2">
                        <a href="{{ route('home') }}"    class="text-xs text-emerald-200/70 hover:text-white font-medium transition-colors">Home</a>
                        <a href="{{ route('tentang') }}" class="text-xs text-emerald-200/70 hover:text-white font-medium transition-colors">Tentang Kami</a>
                        <a href="{{ route('umkm') }}"    class="text-xs text-emerald-200/70 hover:text-white font-medium transition-colors">UMKM</a>
                        <a href="{{ route('budaya') }}"  class="text-xs text-emerald-200/70 hover:text-white font-medium transition-colors">Budaya</a>
                        <a href="{{ route('galeri') }}"  class="text-xs text-emerald-200/70 hover:text-white font-medium transition-colors">Galeri</a>
                        <a href="{{ route('acara') }}"   class="text-xs text-emerald-200/70 hover:text-white font-medium transition-colors">Acara</a>
                        <a href="{{ route('kontak') }}"  class="text-xs text-emerald-200/70 hover:text-white font-medium transition-colors">Hubungi Kami</a>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="lg:col-span-3 space-y-4">
                    <h4 class="font-display font-bold text-sm tracking-wider uppercase text-emerald-300">Hubungi Kami</h4>
                    <ul class="space-y-2 text-xs font-light text-emerald-200/75">
                        <li class="flex items-center space-x-2">
                            <i data-lucide="phone"   class="w-3.5 h-3.5 flex-shrink-0 text-amber-500"></i>
                            <span>{{ \App\Models\Pengaturan::get('kontak_telp', '(0260) 123456') }}</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i data-lucide="mail"    class="w-3.5 h-3.5 flex-shrink-0 text-amber-500"></i>
                            <span>{{ \App\Models\Pengaturan::get('kontak_email', 'info@jambelaer-subang.desa.id') }}</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i data-lucide="map-pin" class="w-3.5 h-3.5 flex-shrink-0 text-amber-500"></i>
                            <span>Dawuan, Subang, Jawa Barat 41270</span>
                        </li>
                    </ul>
                    <!-- Social Icons from DB -->
                    @php
                        $footerFb  = \App\Models\Pengaturan::get('sosmed_facebook', '');
                        $footerIg  = \App\Models\Pengaturan::get('sosmed_instagram', '');
                        $footerYt  = \App\Models\Pengaturan::get('sosmed_youtube', '');
                        $footerTt  = \App\Models\Pengaturan::get('sosmed_tiktok', '');
                        $footerWa  = \App\Models\Pengaturan::get('sosmed_whatsapp', '');
                    @endphp
                    <div class="flex items-center flex-wrap gap-2 pt-1">
                        @if($footerFb)
                        <a href="{{ str_starts_with($footerFb, 'http') ? $footerFb : 'https://'.$footerFb }}" target="_blank" rel="noopener" title="Facebook Desa" class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center hover:bg-blue-600 transition-all text-emerald-100">
                            <i data-lucide="facebook"  class="w-4 h-4"></i>
                        </a>
                        @else
                        <span class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-slate-600" title="Facebook belum diatur">
                            <i data-lucide="facebook"  class="w-4 h-4"></i>
                        </span>
                        @endif
                        @if($footerIg)
                        <a href="{{ str_starts_with($footerIg, 'http') ? $footerIg : 'https://'.$footerIg }}" target="_blank" rel="noopener" title="Instagram Desa" class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center hover:bg-pink-600 transition-all text-emerald-100">
                            <i data-lucide="instagram" class="w-4 h-4"></i>
                        </a>
                        @else
                        <span class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-slate-600" title="Instagram belum diatur">
                            <i data-lucide="instagram" class="w-4 h-4"></i>
                        </span>
                        @endif
                        @if($footerYt)
                        <a href="{{ str_starts_with($footerYt, 'http') ? $footerYt : 'https://'.$footerYt }}" target="_blank" rel="noopener" title="YouTube Desa" class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center hover:bg-red-600 transition-all text-emerald-100">
                            <i data-lucide="youtube"   class="w-4 h-4"></i>
                        </a>
                        @else
                        <span class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-slate-600" title="YouTube belum diatur">
                            <i data-lucide="youtube"   class="w-4 h-4"></i>
                        </span>
                        @endif
                        @if($footerTt)
                        <a href="{{ str_starts_with($footerTt, 'http') ? $footerTt : 'https://'.$footerTt }}" target="_blank" rel="noopener" title="TikTok Desa" class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center hover:bg-slate-700 transition-all text-emerald-100">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.32 6.32 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.33-6.34V8.69a8.18 8.18 0 0 0 4.78 1.52V6.76a4.85 4.85 0 0 1-1.01-.07z"/></svg>
                        </a>
                        @else
                        <span class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-slate-600" title="TikTok belum diatur">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.32 6.32 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.33-6.34V8.69a8.18 8.18 0 0 0 4.78 1.52V6.76a4.85 4.85 0 0 1-1.01-.07z"/></svg>
                        </span>
                        @endif
                        @if($footerWa)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $footerWa) }}" target="_blank" rel="noopener" title="WhatsApp Desa" class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center hover:bg-green-600 transition-all text-emerald-100">
                            <i data-lucide="message-circle" class="w-4 h-4"></i>
                        </a>
                        @else
                        <span class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-slate-600" title="WhatsApp belum diatur">
                            <i data-lucide="message-circle" class="w-4 h-4"></i>
                        </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Bottom Row -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs font-light text-emerald-200/50">
                <p>Copyright &copy; {{ date('Y') }} Pemerintah Desa Jambelaer. Hak Cipta Dilindungi.</p>
                <div class="flex items-center space-x-4">
                    <a href="#" class="hover:text-white transition-colors">Syarat &amp; Ketentuan</a>
                    <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
                    <a href="{{ route('admin.login') }}" class="hover:text-emerald-300 transition-colors opacity-40 hover:opacity-100">Admin</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top -->
    <button id="back-to-top"
        class="fixed bottom-6 right-6 w-12 h-12 rounded-xl bg-white hover:bg-emerald-900 border border-slate-200 shadow-md hover:text-white text-emerald-900 flex items-center justify-center transition-all duration-300 transform translate-y-16 opacity-0 z-40 focus:outline-none cursor-pointer">
        <i data-lucide="arrow-up" class="w-5 h-5"></i>
    </button>

    <!-- ══════════════════════════ SHARED SCRIPTS ══════════════════════════ -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Init Lucide icons
            lucide.createIcons();

            // Sticky Navbar
            const header   = document.getElementById('main-header');
            const backToTop = document.getElementById('back-to-top');

            window.addEventListener('scroll', function () {
                if (window.scrollY > 50) {
                    header.classList.add('bg-white/90', 'backdrop-blur-md', 'shadow-sm', 'border-slate-100');
                    header.classList.remove('border-transparent');
                } else {
                    header.classList.remove('bg-white/90', 'backdrop-blur-md', 'shadow-sm', 'border-slate-100');
                    header.classList.add('border-transparent');
                }
                if (window.scrollY > 400) {
                    backToTop.classList.remove('translate-y-16', 'opacity-0');
                    backToTop.classList.add('translate-y-0', 'opacity-100');
                } else {
                    backToTop.classList.remove('translate-y-0', 'opacity-100');
                    backToTop.classList.add('translate-y-16', 'opacity-0');
                }
            });

            backToTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

            // Mobile Menu Toggle
            const mobileBtn   = document.getElementById('mobile-menu-btn');
            const mobileMenu  = document.getElementById('mobile-menu');
            const hamburger   = document.getElementById('hamburger-icon');
            const closeIcon   = document.getElementById('close-icon');

            mobileBtn.addEventListener('click', function () {
                const expanded = mobileBtn.getAttribute('aria-expanded') === 'true';
                mobileBtn.setAttribute('aria-expanded', !expanded);
                mobileMenu.classList.toggle('hidden');
                hamburger.classList.toggle('hidden');
                closeIcon.classList.toggle('hidden');
            });

            // Scroll Reveal
            const revealEls = document.querySelectorAll('.reveal-on-scroll');
            const observer  = new IntersectionObserver((entries, obs) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                        // Counter animation if applicable
                        entry.target.querySelectorAll('[data-target]').forEach(animateCounter);
                        obs.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.15, rootMargin: '0px 0px -50px 0px' });

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
                const duration = 2000;
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
