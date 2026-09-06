<!DOCTYPE html>
<html lang="id" class="min-h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin – Desa Jambelaer</title>
    <!-- Blokir indexing halaman login oleh mesin pencari -->
    <meta name="robots" content="noindex, nofollow, noarchive">
    <meta name="googlebot" content="noindex, nofollow">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Plus Jakarta Sans', 'Inter', ui-sans-serif, system-ui, sans-serif;
            --color-forest-50:  #f0fdf4;
            --color-forest-100: #dcfce7;
            --color-forest-200: #bbf7d0;
            --color-forest-500: #22c55e;
            --color-forest-600: #16a34a;
            --color-forest-700: #15803d;
            --color-forest-800: #1a4731;
            --color-forest-900: #0f2d1f;
        }

        .bg-glass {
            background: rgba(255, 255, 255, 0.94);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .form-input-custom {
            @apply w-full pl-10 pr-4 py-2.5 bg-slate-50/80 border border-slate-200/90 rounded-xl text-xs font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-forest-600 focus:ring-4 focus:ring-forest-600/15 transition-all duration-200;
        }

        .btn-gradient {
            background: linear-gradient(135deg, #1a4731 0%, #22c55e 100%);
        }

        .btn-gradient:hover {
            background: linear-gradient(135deg, #15803d 0%, #16a34a 100%);
        }
    </style>

    <!-- Lucide Icons -->
    <script src="{{ asset('js/lucide.min.js') }}"></script>
    <script>
        if (typeof lucide === 'undefined') {
            document.write('<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"><\/script>');
        }
    </script>
</head>

<body class="min-h-screen bg-slate-900 font-sans antialiased flex flex-col items-center justify-center py-6 px-4 relative overflow-y-auto selection:bg-forest-500 selection:text-white">

    <!-- Ambient Background Lighting & Effects -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden">
        <!-- Background Hero Image Blur -->
        <div class="absolute inset-0 bg-cover bg-center opacity-15 filter blur-sm scale-105"
            style="background-image: url('{{ asset('uploads/img/sawah.jpeg') }}');"></div>

        <!-- Radial Gradients & Glow Blobs -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[500px] bg-gradient-to-b from-forest-800/40 via-forest-600/10 to-transparent blur-3xl rounded-full"></div>
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-emerald-500/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-amber-500/15 rounded-full blur-3xl"></div>
    </div>

    <!-- Main Container -->
    <div class="relative w-full max-w-[400px] z-10 my-auto">

        <!-- Logo & Header Badge -->
        <div class="text-center mb-4 space-y-2">
            <div class="inline-flex p-2 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 shadow-xl">
                <div class="w-11 h-11 rounded-xl bg-forest-800 flex items-center justify-center overflow-hidden p-1 shadow-inner">
                    <img src="{{ asset('uploads/img/DESA_JAMBELAER.png') }}"
                        alt="Logo Desa Jambelaer"
                        class="w-full h-full object-contain">
                </div>
            </div>
            <div>
                <h1 class="font-extrabold text-xl text-white tracking-tight">Desa Jambelaer</h1>
                <p class="text-slate-300 text-[11px] font-medium mt-0.5 tracking-wide uppercase">Portal Administrator Sistem</p>
            </div>
        </div>

        <!-- Login Card -->
        <div class="bg-glass border border-white/60 rounded-3xl p-6 sm:p-7 shadow-2xl shadow-black/30">

            <!-- Title Inside Card -->
            <div class="mb-4 pb-3 border-b border-slate-100">
                <h2 class="text-base font-bold text-slate-900 leading-tight">Selamat Datang Kembali</h2>
                <p class="text-[11px] text-slate-500 mt-0.5">Masukkan kredensial Anda untuk mengakses dashboard</p>
            </div>

            <!-- Error Alerts -->
            @if($errors->any())
            <div class="flex items-start gap-2.5 p-3 rounded-xl bg-red-50/90 border border-red-200 text-red-700 text-xs mb-4">
                <i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0 mt-0.5 text-red-500"></i>
                <div class="space-y-0.5">
                    @foreach($errors->all() as $error)
                    <p class="font-medium">{{ $error }}</p>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Success Session Alert -->
            @if(session('success'))
            <div class="flex items-center gap-2.5 p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs mb-4">
                <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600 flex-shrink-0"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-3.5">
                @csrf

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 mb-1">
                        Alamat Email
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                            <i data-lucide="mail" class="w-3.5 h-3.5"></i>
                        </span>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                            class="form-input-custom" placeholder="Masukan Username" autocomplete="email">
                    </div>
                </div>

                <!-- Password Input -->
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label for="password-input" class="block text-xs font-bold text-slate-700">
                            Password
                        </label>
                    </div>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                            <i data-lucide="lock" class="w-3.5 h-3.5"></i>
                        </span>
                        <input id="password-input" type="password" name="password" required
                            class="form-input-custom !pr-10" placeholder="Masukan Password" autocomplete="current-password">
                        <button type="button" onclick="togglePassword()"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 focus:outline-none transition-colors"
                            title="Tampilkan / Sembunyikan Password">
                            <i id="eye-icon" data-lucide="eye" class="w-3.5 h-3.5"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between pt-0.5">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input id="remember" type="checkbox" name="remember"
                            class="w-3.5 h-3.5 rounded border-slate-300 text-forest-700 focus:ring-forest-600/30 transition-all cursor-pointer">
                        <span class="text-xs text-slate-600 group-hover:text-slate-900 transition-colors select-none font-medium">Ingat Sesi Saya</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="pt-1.5">
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 h-10 rounded-xl font-bold text-xs text-white tracking-wider uppercase btn-gradient shadow-md shadow-forest-800/20 transition-all duration-200 hover:shadow-lg hover:shadow-forest-700/30 active:scale-[0.99]">
                        <i data-lucide="log-in" class="w-4 h-4"></i>
                        Masuk ke Dashboard
                    </button>
                </div>
            </form>

            <!-- Card Footer Info -->
            <div class="mt-4 pt-3 border-t border-slate-100/80 text-center">
                <p class="text-[10px] text-slate-400 font-medium">
                    Sistem Informasi Desa Jambelaer · Subang
                </p>
            </div>
        </div>

        <!-- Back to Main Site -->
        <div class="text-center mt-4">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-300 hover:text-white transition-colors bg-white/5 hover:bg-white/10 border border-white/10 px-3.5 py-1.5 rounded-full backdrop-blur-sm">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5 text-forest-400"></i>
                <span>Kembali ke Website Utama Desa</span>
            </a>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });

        function togglePassword() {
            const input = document.getElementById('password-input');
            const icon = document.getElementById('eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.setAttribute('data-lucide', 'eye-off');
            } else {
                input.type = 'password';
                icon.setAttribute('data-lucide', 'eye');
            }
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        }
    </script>
</body>

</html>