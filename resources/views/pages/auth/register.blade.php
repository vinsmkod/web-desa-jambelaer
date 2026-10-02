@extends('layouts.app')

@section('title', 'Daftar Akun Warga – Layanan Mandiri Desa Jambelaer')
@section('meta_desc', 'Registrasi akun warga Desa Jambelaer untuk memudahkan pengajuan permohonan layanan, pengaduan, acara, UMKM, dan pemantauan status secara transparan.')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md">

        {{-- Card Container --}}
        <div class="bg-white rounded-3xl border border-stone-200/80 shadow-xl shadow-stone-200/50 p-6 sm:p-8 backdrop-blur-md">
            
            {{-- Header --}}
            <div class="text-center mb-6">
                <div class="w-14 h-14 mx-auto mb-3 rounded-2xl bg-forest-50 border border-forest-100 flex items-center justify-center text-forest-800 shadow-sm">
                    <i data-lucide="user-plus" class="w-7 h-7"></i>
                </div>
                <h1 class="font-display font-extrabold text-2xl text-forest-950">Daftar Akun Warga</h1>
                <p class="text-xs text-stone-500 mt-1.5 font-light leading-relaxed">
                    Buat akun untuk mengajukan permohonan layanan masyarakat dan memantau status secara langsung.
                </p>
            </div>

            {{-- Error Validation Box --}}
            @if($errors->any())
            <div class="mb-5 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-700 space-y-1">
                @foreach($errors->all() as $error)
                <div class="flex items-center gap-2">
                    <i data-lucide="x-circle" class="w-3.5 h-3.5 text-rose-500 flex-shrink-0"></i>
                    <span>{{ $error }}</span>
                </div>
                @endforeach
            </div>
            @endif

            {{-- Form Register --}}
            <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
                @csrf

                {{-- Nama Lengkap --}}
                <div>
                    <label for="name" class="block text-xs font-semibold text-stone-700 mb-1.5">
                        Nama Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-stone-400">
                            <i data-lucide="user" class="w-4 h-4"></i>
                        </div>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                            placeholder="Contoh: Budi Santoso"
                            class="w-full pl-10 pr-4 py-2.5 bg-stone-50/60 border border-stone-200 rounded-xl text-xs font-medium text-stone-900 placeholder:text-stone-400 focus:outline-none focus:bg-white focus:border-forest-600 focus:ring-4 focus:ring-forest-600/10 transition-all">
                    </div>
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-xs font-semibold text-stone-700 mb-1.5">
                        Alamat Email <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-stone-400">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                        </div>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            placeholder="nama@email.com"
                            class="w-full pl-10 pr-4 py-2.5 bg-stone-50/60 border border-stone-200 rounded-xl text-xs font-medium text-stone-900 placeholder:text-stone-400 focus:outline-none focus:bg-white focus:border-forest-600 focus:ring-4 focus:ring-forest-600/10 transition-all">
                    </div>
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-xs font-semibold text-stone-700 mb-1.5">
                        Kata Sandi (Minimal 6 karakter) <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-stone-400">
                            <i data-lucide="lock" class="w-4 h-4"></i>
                        </div>
                        <input type="password" name="password" id="password" required
                            placeholder="Minimal 6 karakter"
                            class="w-full pl-10 pr-10 py-2.5 bg-stone-50/60 border border-stone-200 rounded-xl text-xs font-medium text-stone-900 placeholder:text-stone-400 focus:outline-none focus:bg-white focus:border-forest-600 focus:ring-4 focus:ring-forest-600/10 transition-all">
                        <button type="button" onclick="togglePasswordVisibility('password', 'toggle-pass-1')"
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-stone-400 hover:text-stone-600">
                            <i id="toggle-pass-1" data-lucide="eye" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold text-stone-700 mb-1.5">
                        Konfirmasi Kata Sandi <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-stone-400">
                            <i data-lucide="shield-check" class="w-4 h-4"></i>
                        </div>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            placeholder="Ulangi kata sandi"
                            class="w-full pl-10 pr-10 py-2.5 bg-stone-50/60 border border-stone-200 rounded-xl text-xs font-medium text-stone-900 placeholder:text-stone-400 focus:outline-none focus:bg-white focus:border-forest-600 focus:ring-4 focus:ring-forest-600/10 transition-all">
                        <button type="button" onclick="togglePasswordVisibility('password_confirmation', 'toggle-pass-2')"
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-stone-400 hover:text-stone-600">
                            <i id="toggle-pass-2" data-lucide="eye" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="pt-3">
                    <button type="submit"
                        class="w-full py-3 px-4 bg-forest-800 hover:bg-forest-900 text-white font-display font-bold text-xs uppercase tracking-wider rounded-xl shadow-md shadow-forest-800/20 hover:shadow-lg transition-all flex items-center justify-center gap-2">
                        <i data-lucide="user-check" class="w-4 h-4"></i>
                        Daftar Akun Sekarang
                    </button>
                </div>
            </form>

            {{-- Divider --}}
            <div class="relative my-6 text-center">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-stone-200"></div>
                </div>
                <span class="relative px-3 bg-white text-[11px] text-stone-400 uppercase tracking-wider font-semibold">
                    Sudah memiliki akun?
                </span>
            </div>

            {{-- Login Link --}}
            <div>
                <a href="{{ route('login') }}"
                    class="w-full py-2.5 px-4 bg-stone-50 hover:bg-stone-100 text-stone-700 hover:text-stone-900 border border-stone-200 rounded-xl font-display font-semibold text-xs transition-all flex items-center justify-center gap-2">
                    <i data-lucide="log-in" class="w-4 h-4 text-forest-700"></i>
                    Masuk ke Akun Anda
                </a>
            </div>

        </div>

        {{-- Back to Home --}}
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-stone-500 hover:text-forest-800 transition-colors">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                Kembali ke Beranda Desa
            </a>
        </div>

    </div>
</div>

@push('scripts')
<script>
function togglePasswordVisibility(fieldId, iconId) {
    const input = document.getElementById(fieldId);
    const icon = document.getElementById(iconId);
    if (!input || !icon) return;

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
@endpush
@endsection
