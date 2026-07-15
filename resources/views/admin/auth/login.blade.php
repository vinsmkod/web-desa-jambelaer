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
        }
        .form-input {
            @apply w-full px-4 py-3 bg-slate-800 border border-slate-700 rounded-xl text-sm text-slate-100 placeholder-slate-500 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all;
        }
    </style>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="h-full bg-slate-950 font-sans antialiased flex items-center justify-center p-4">

    <div class="w-full max-w-md">

        <!-- Logo & Title -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-gradient-to-tr from-emerald-700 to-emerald-500 shadow-lg shadow-emerald-900/50 mb-4">
                <i data-lucide="map" class="w-7 h-7 text-white"></i>
            </div>
            <h1 class="font-display font-extrabold text-2xl text-white">Desa Jambelaer</h1>
            <p class="text-slate-400 text-sm mt-1">Masuk ke Panel Admin</p>
        </div>

        <!-- Card -->
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-8 shadow-2xl">

            <!-- Errors -->
            @if($errors->any())
            <div class="flex items-start gap-3 p-4 rounded-xl bg-red-600/10 border border-red-600/30 text-red-400 text-sm mb-6">
                <i data-lucide="alert-circle" class="w-5 h-5 flex-shrink-0 mt-0.5"></i>
                <div>
                    @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                    @endforeach
                </div>
            </div>
            @endif

            @if(session('success'))
            <div class="flex items-center gap-3 p-4 rounded-xl bg-emerald-600/10 border border-emerald-600/30 text-emerald-400 text-sm mb-6">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">
                        Alamat Email
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="form-input" placeholder="Masukan Username">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">
                        Password
                    </label>
                    <div class="relative">
                        <input id="password-input" type="password" name="password" required
                            class="form-input pr-12" placeholder="Masukan Password">
                        <button type="button" onclick="togglePassword()"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-300 transition-colors">
                            <i id="eye-icon" data-lucide="eye" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <input id="remember" type="checkbox" name="remember"
                        class="w-4 h-4 rounded border-slate-700 bg-slate-800 text-emerald-500 focus:ring-emerald-500 focus:ring-offset-slate-900">
                    <label for="remember" class="text-sm text-slate-400 select-none cursor-pointer">Ingat saya</label>
                </div>

                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 h-12 bg-emerald-600 hover:bg-emerald-500 text-white font-bold rounded-xl transition-all duration-200 text-sm tracking-wide">
                    Masuk ke Dashboard
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </button>
            </form>
        </div>

        <p class="text-center text-xs text-slate-600 mt-6">
            <a href="{{ route('home') }}" class="hover:text-slate-400 transition-colors flex items-center justify-center gap-1">
                <i data-lucide="arrow-left" class="w-3 h-3"></i>
                Kembali ke Website
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