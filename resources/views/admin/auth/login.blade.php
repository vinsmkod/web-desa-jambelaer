<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin – Desa Jambelaer</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

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
        }
        .form-input {
            @apply w-full px-4 py-3 bg-white border border-slate-300 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-forest-600 focus:ring-2 focus:ring-forest-600/20 transition-all;
        }
    </style>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="h-full bg-slate-100 font-sans antialiased flex items-center justify-center p-4 min-h-screen">

    {{-- Background decoration --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-forest-100/60 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-forest-100/40 rounded-full blur-3xl"></div>
    </div>

    <div class="relative w-full max-w-md">

        {{-- Logo & Title --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl shadow-lg mb-4" style="background: linear-gradient(135deg, #1a4731, #245e3f);">
                <i data-lucide="wheat" class="w-8 h-8 text-amber-300"></i>
            </div>
            <h1 class="font-display font-extrabold text-2xl text-slate-900">Desa Jambelaer</h1>
            <p class="text-slate-500 text-sm mt-1">Masuk ke Panel Admin</p>
        </div>

        {{-- Card --}}
        <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-xl shadow-slate-200/60">

            {{-- Errors --}}
            @if($errors->any())
            <div class="flex items-start gap-3 p-4 rounded-xl bg-red-50 border border-red-200 text-red-600 text-sm mb-6">
                <i data-lucide="alert-circle" class="w-5 h-5 flex-shrink-0 mt-0.5"></i>
                <div>
                    @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                    @endforeach
                </div>
            </div>
            @endif

            @if(session('success'))
            <div class="flex items-center gap-3 p-4 rounded-xl bg-forest-50 border border-forest-200 text-forest-700 text-sm mb-6">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                        Alamat Email
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="form-input pl-10" placeholder="admin@jambelaer.id">
                    </div>
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                        Password
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400">
                            <i data-lucide="lock" class="w-4 h-4"></i>
                        </span>
                        <input id="password-input" type="password" name="password" required
                            class="form-input pl-10 pr-12" placeholder="••••••••">
                        <button type="button" onclick="togglePassword()"
                            class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
                            <i id="eye-icon" data-lucide="eye" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                {{-- Remember --}}
                <div class="flex items-center gap-2.5">
                    <input id="remember" type="checkbox" name="remember"
                        class="w-4 h-4 rounded border-slate-300 text-forest-600 focus:ring-forest-500">
                    <label for="remember" class="text-sm text-slate-500 select-none cursor-pointer">Ingat saya</label>
                </div>

                {{-- Submit --}}
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 h-12 rounded-xl font-bold text-sm text-white tracking-wide transition-all duration-200 hover:opacity-90 active:scale-[0.98] shadow-sm"
                    style="background: linear-gradient(135deg, #1a4731, #245e3f);">
                    <i data-lucide="log-in" class="w-4 h-4"></i>
                    Masuk ke Dashboard
                </button>
            </form>

            {{-- Divider --}}
            <div class="flex items-center gap-3 my-6">
                <div class="flex-1 h-px bg-slate-200"></div>
                <span class="text-xs text-slate-400 font-medium">Panel Admin</span>
                <div class="flex-1 h-px bg-slate-200"></div>
            </div>

            <p class="text-center text-xs text-slate-400">
                Sistem Informasi Desa Jambelaer · Kec. Dawuan, Kab. Subang
            </p>
        </div>

        {{-- Back link --}}
        <p class="text-center text-xs text-slate-400 mt-6">
            <a href="{{ route('home') }}" class="hover:text-forest-700 transition-colors inline-flex items-center gap-1.5 font-medium">
                <i data-lucide="arrow-left" class="w-3 h-3"></i>
                Kembali ke Website Desa
            </a>
        </p>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => lucide.createIcons());

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
            lucide.createIcons();
        }
    </script>
</body>

</html>