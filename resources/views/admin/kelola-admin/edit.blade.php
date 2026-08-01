@extends('admin.layouts.admin')

@section('title', 'Edit & Reset Password Admin')
@section('page_title', 'Edit Administrator')
@section('page_subtitle', 'Ubah informasi atau reset password akun administrator ' . $admin->name)

@section('content')
<div class="max-w-3xl space-y-6">

    <!-- Header Actions / Back Link -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.kelola-admin.index') }}" class="btn-secondary text-xs">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali ke Daftar Admin
        </a>
    </div>

    <!-- Main Form Card -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
        <div class="flex items-center gap-4 pb-6 mb-2 border-b border-slate-100">
            <div class="w-12 h-12 rounded-2xl bg-forest-800 text-white flex items-center justify-center shadow-xs flex-shrink-0">
                <i data-lucide="user-cog" class="w-6 h-6 text-amber-300"></i>
            </div>
            <div>
                <h2 class="text-base font-bold text-slate-900">Form Edit & Reset Password</h2>
                <p class="text-xs text-slate-500 mt-0.5">Perbarui profil admin atau isi password baru jika admin lupa password</p>
            </div>
        </div>

        {{-- Flash Error Summary --}}
        @if ($errors->any())
        <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-600 text-xs space-y-1.5">
            <div class="font-bold flex items-center gap-2">
                <i data-lucide="alert-circle" class="w-4 h-4"></i>
                <span>Gagal memperbarui admin. Mohon periksa input berikut:</span>
            </div>
            <ul class="list-disc list-inside space-y-1 pl-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.kelola-admin.update', $admin->id) }}" method="POST" autocomplete="off" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Nama Lengkap -->
            <div>
                <label for="name" class="form-label">Nama Lengkap Admin <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="user" class="w-5 h-5"></i>
                    </div>
                    <input type="text" name="name" id="name" value="{{ old('name', $admin->name) }}" required
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
                    <input type="email" name="email" id="email" value="{{ old('email', $admin->email) }}" required
                        placeholder="admin@jambelaer.desa.id" autocomplete="new-email"
                        class="form-input !pl-12 @error('email') border-red-400 @enderror">
                </div>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 border-t border-slate-100">
                <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2 mb-1">
                    <i data-lucide="key-round" class="w-4 h-4 text-forest-700"></i>
                    Reset Password (Opsional)
                </h3>
                <p class="text-xs text-slate-500 mb-4">Kosongkan kolom password di bawah ini jika tidak ingin mengubah password lama admin ini.</p>

                <!-- Password Grid -->
                <div class="grid sm:grid-cols-2 gap-5">
                    <!-- Password Baru -->
                    <div>
                        <label for="password" class="form-label">Password Baru</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i data-lucide="lock" class="w-5 h-5"></i>
                            </div>
                            <input type="password" name="password" id="password"
                                placeholder="Minimal 8 karakter" autocomplete="new-password"
                                class="form-input !pl-12 !pr-12 @error('password') border-red-400 @enderror">
                            <button type="button" onclick="togglePasswordVisibility('password', 'icon-password')"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition-colors"
                                title="Tampilkan / Sembunyikan Password">
                                <i id="icon-password" data-lucide="eye" class="w-5 h-5"></i>
                            </button>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">Isi hanya jika ingin ganti password.</p>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div>
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i data-lucide="shield-check" class="w-5 h-5"></i>
                            </div>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                placeholder="Ketik ulang password baru" autocomplete="new-password"
                                class="form-input !pl-12 !pr-12">
                            <button type="button" onclick="togglePasswordVisibility('password_confirmation', 'icon-password-confirm')"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition-colors"
                                title="Tampilkan / Sembunyikan Password">
                                <i id="icon-password-confirm" data-lucide="eye" class="w-5 h-5"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Warning Callout -->
            <div class="p-4 rounded-xl bg-forest-50/60 border border-forest-100 flex items-start gap-3">
                <i data-lucide="info" class="w-5 h-5 text-forest-700 flex-shrink-0 mt-0.5"></i>
                <div class="text-xs text-slate-600 space-y-1">
                    <p class="font-bold text-slate-800">Catatan:</p>
                    <p>Jika Anda mereset password admin lain (misal karena lupa password), pastikan memberitahukan password baru tersebut kepada yang bersangkutan secara aman.</p>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.kelola-admin.index') }}" class="btn-secondary">
                    Batal
                </a>
                <button type="submit" class="btn-primary">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Simpan Perubahan
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
</script>
@endpush
@endsection
