@extends('admin.layouts.admin')

@section('title', 'Tambah Admin Baru')
@section('page_title', 'Tambah Admin Baru')
@section('page_subtitle', 'Mendaftarkan akun administrator baru ke dalam sistem')

@section('content')
<div class="max-w-3xl space-y-6">

    <!-- Header Actions / Back Link -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.kelola-admin.index') }}" class="btn-secondary text-xs">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali ke Daftar Admin
        </a>
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200">
            <i data-lucide="shield-alert" class="w-3.5 h-3.5"></i>
            Aksi Edit & Hapus Dinonaktifkan
        </span>
    </div>

    <!-- Main Form Card -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
        <div class="flex items-center gap-4 pb-6 mb-2 border-b border-slate-100">
            <div class="w-12 h-12 rounded-2xl bg-forest-800 text-white flex items-center justify-center shadow-xs flex-shrink-0">
                <i data-lucide="user-plus" class="w-6 h-6 text-amber-300"></i>
            </div>
            <div>
                <h2 class="text-base font-bold text-slate-900">Form Registrasi Admin</h2>
                <p class="text-xs text-slate-500 mt-0.5">Isi formulir di bawah ini untuk menambahkan hak akses administrator baru</p>
            </div>
        </div>

        {{-- Flash Error Summary --}}
        @if ($errors->any())
        <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-600 text-xs space-y-1.5">
            <div class="font-bold flex items-center gap-2">
                <i data-lucide="alert-circle" class="w-4 h-4"></i>
                <span>Gagal mendaftarkan admin. Mohon periksa input berikut:</span>
            </div>
            <ul class="list-disc list-inside space-y-1 pl-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.kelola-admin.store') }}" method="POST" autocomplete="off" class="space-y-5">
            @csrf

            <!-- Nama Lengkap -->
            <div>
                <label for="name" class="form-label">Nama Lengkap Admin <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="user" class="w-5 h-5"></i>
                    </div>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        placeholder="Contoh: Ahmad Subagja" autocomplete="off"
                        class="form-input !pl-12 @error('name') border-red-400 @enderror">
                </div>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="form-label">Alamat Email <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="mail" class="w-5 h-5"></i>
                    </div>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        placeholder="admin@jambelaer.desa.id" autocomplete="new-email"
                        class="form-input !pl-12 @error('email') border-red-400 @enderror">
                </div>
                <p class="text-[11px] text-slate-400 mt-1">Email ini akan digunakan oleh admin untuk login ke panel ini.</p>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Grid -->
            <div class="grid sm:grid-cols-2 gap-5 pt-1">
                <!-- Password -->
                <div>
                    <label for="password" class="form-label">Password <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="lock" class="w-5 h-5"></i>
                        </div>
                        <input type="password" name="password" id="password" required
                            placeholder="Minimal 8 karakter" autocomplete="new-password"
                            class="form-input !pl-12 !pr-12 @error('password') border-red-400 @enderror">
                        <button type="button" onclick="togglePasswordVisibility('password', 'icon-password')"
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition-colors"
                            title="Tampilkan / Sembunyikan Password">
                            <i id="icon-password" data-lucide="eye" class="w-5 h-5"></i>
                        </button>
                    </div>
                    <p class="text-[11px] text-slate-400 mt-1">Minimal 8 karakter.</p>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="shield-check" class="w-5 h-5"></i>
                        </div>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            placeholder="Ketik ulang password" autocomplete="new-password"
                            class="form-input !pl-12 !pr-12">
                        <button type="button" onclick="togglePasswordVisibility('password_confirmation', 'icon-password-confirm')"
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition-colors"
                            title="Tampilkan / Sembunyikan Password">
                            <i id="icon-password-confirm" data-lucide="eye" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Warning Callout -->
            <div class="p-4 rounded-xl bg-forest-50/60 border border-forest-100 flex items-start gap-3">
                <i data-lucide="info" class="w-5 h-5 text-forest-700 flex-shrink-0 mt-0.5"></i>
                <div class="text-xs text-slate-600 space-y-1">
                    <p class="font-bold text-slate-800">Catatan Keamanan:</p>
                    <p>Setelah akun terdaftar, admin yang bersangkutan dapat langsung login. Pastikan informasi password disimpan secara aman.</p>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.kelola-admin.index') }}" class="btn-secondary">
                    Batal
                </a>
                <button type="submit" class="btn-primary">
                    <i data-lucide="user-check" class="w-4 h-4"></i>
                    Simpan & Daftarkan Admin
                </button>
            </div>
        </form>
    </div>

</div>

@push('scripts')
<script>
    function togglePasswordVisibility(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (!input || !icon) return;

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

    @if(!$errors->any())
    document.addEventListener('DOMContentLoaded', function () {
        setTimeout(function () {
            const inputs = ['name', 'email', 'password', 'password_confirmation'];
            inputs.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.value = '';
            });
        }, 50);
    });
    @endif
</script>
@endpush
@endsection
