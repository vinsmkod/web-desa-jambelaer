@extends('layouts.app')

@section('title', 'Profil Akun Saya – Desa Jambelaer')
@section('meta_desc', 'Lihat dan perbarui informasi profil akun Anda di Sistem Informasi Profil Desa Jambelaer.')

@section('content')
{{-- Breadcrumb --}}
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 sm:pt-6">
    <nav class="flex items-center gap-1.5 text-xs text-stone-500 mb-4" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-forest-800 transition-colors">Beranda</a>
        <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-stone-300"></i>
        <a href="{{ route('pengajuan.saya') }}" class="hover:text-forest-800 transition-colors">Pengajuan Saya</a>
        <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-stone-300"></i>
        <span class="text-forest-800 font-semibold">Profil Akun</span>
    </nav>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">

    {{-- Banner Header --}}
    <div class="bg-gradient-to-r from-forest-900 to-forest-800 text-white rounded-3xl p-6 sm:p-8 shadow-sm mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-sand-300 border border-white/15 text-xs font-semibold uppercase tracking-wider mb-2">
                <i data-lucide="user-check" class="w-3.5 h-3.5"></i>
                Data Warga Desa
            </div>
            <h1 class="font-display font-extrabold text-2xl sm:text-3xl text-white">
                Profil Akun Saya
            </h1>
            <p class="text-xs sm:text-sm text-white/75 mt-1 max-w-xl font-light">
                Perbarui informasi identitas dan kontak Anda agar mempermudah koordinasi serta proses verifikasi layanan administrasi desa.
            </p>
        </div>
        <a href="{{ route('pengajuan.saya') }}"
            class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 text-xs font-bold text-white transition-all whitespace-nowrap self-start sm:self-auto">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            Kembali ke Pengajuan
        </a>
    </div>

    {{-- Flash Success Message --}}
    @if(session('success'))
    <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 flex items-start gap-3 text-sm text-emerald-800 shadow-sm" role="alert">
        <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-600 flex-shrink-0 mt-0.5"></i>
        <div>
            <p class="font-semibold">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    {{-- Error Summary --}}
    @if($errors->any())
    <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-sm text-rose-800" role="alert">
        <div class="flex items-center gap-2 font-bold mb-2">
            <i data-lucide="alert-triangle" class="w-4 h-4 text-rose-600"></i>
            Terdapat {{ $errors->count() }} kesalahan dalam pengisian formulir:
        </div>
        <ul class="list-disc list-inside space-y-1 text-xs font-light">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Ringkasan Akun (Read-only Card) --}}
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-3xl border border-stone-200/80 p-6 shadow-sm">
                <div class="flex flex-col items-center text-center pb-6 border-b border-stone-100">
                    <div class="w-20 h-20 rounded-full bg-forest-50 border-2 border-forest-200 text-forest-800 flex items-center justify-center font-bold text-2xl shadow-inner mb-3">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <h2 class="font-bold text-stone-800 text-base leading-tight">{{ $user->name }}</h2>
                    <p class="text-xs text-stone-500 mt-0.5 break-all">{{ $user->email }}</p>
                    <span class="inline-block mt-2 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        {{ $user->role_label }}
                    </span>
                </div>

                <div class="pt-5 space-y-3.5 text-xs">
                    <div>
                        <span class="block text-[11px] text-stone-400 font-semibold uppercase tracking-wider">Peran Pengguna</span>
                        <span class="font-semibold text-stone-700 capitalize">{{ $user->role }}</span>
                    </div>
                    <div>
                        <span class="block text-[11px] text-stone-400 font-semibold uppercase tracking-wider">Alamat Email</span>
                        <span class="font-medium text-stone-700 break-all">{{ $user->email }}</span>
                    </div>
                    <div>
                        <span class="block text-[11px] text-stone-400 font-semibold uppercase tracking-wider">Tanggal Pendaftaran</span>
                        <span class="font-medium text-stone-700">{{ $user->created_at ? $user->created_at->translatedFormat('d F Y') : '-' }}</span>
                    </div>
                </div>

                <div class="mt-5 p-3 rounded-2xl bg-stone-50 border border-stone-200/70 text-[11px] text-stone-500 flex items-start gap-2">
                    <i data-lucide="shield-check" class="w-4 h-4 text-forest-700 flex-shrink-0 mt-0.5"></i>
                    <span>Email dan peran akun dilindungi dan tidak dapat diubah secara mandiri demi keamanan akun.</span>
                </div>
            </div>
        </div>

        {{-- Form Edit Profil Card --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-3xl border border-stone-200/80 p-6 sm:p-8 shadow-sm">
                <div class="flex items-center gap-2 pb-4 mb-6 border-b border-stone-100">
                    <i data-lucide="edit-3" class="w-5 h-5 text-forest-800"></i>
                    <h3 class="font-bold text-stone-800 text-lg">Perbarui Data Diri</h3>
                </div>

                <form action="{{ route('profil.update') }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    {{-- 1. Nama Lengkap --}}
                    <div>
                        <label for="name" class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">
                            Nama Lengkap <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text"
                                id="name"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                required
                                minlength="3"
                                maxlength="255"
                                placeholder="Masukkan nama lengkap sesuai identitas"
                                class="w-full pl-10 pr-4 py-3 rounded-xl border {{ $errors->has('name') ? 'border-rose-400 ring-2 ring-rose-100' : 'border-stone-200' }} bg-stone-50/50 text-stone-800 text-sm font-medium focus:bg-white focus:border-forest-700 focus:ring-2 focus:ring-forest-100 outline-none transition-all">
                            <i data-lucide="user" class="w-4 h-4 absolute left-3.5 top-3.5 text-stone-400"></i>
                        </div>
                        <p class="text-[11px] text-stone-400 mt-1">Minimal 3 karakter, maksimal 255 karakter.</p>
                        @error('name')
                        <p class="text-xs text-rose-600 mt-1 flex items-center gap-1 font-medium">
                            <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    {{-- 2. Nomor Telepon --}}
                    <div>
                        <label for="no_hp" class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">
                            Nomor Telepon / WhatsApp <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text"
                                id="no_hp"
                                name="no_hp"
                                value="{{ old('no_hp', $user->no_hp) }}"
                                required
                                maxlength="20"
                                placeholder="Contoh: 081234567890"
                                class="w-full pl-10 pr-4 py-3 rounded-xl border {{ $errors->has('no_hp') ? 'border-rose-400 ring-2 ring-rose-100' : 'border-stone-200' }} bg-stone-50/50 text-stone-800 text-sm font-medium focus:bg-white focus:border-forest-700 focus:ring-2 focus:ring-forest-100 outline-none transition-all">
                            <i data-lucide="phone" class="w-4 h-4 absolute left-3.5 top-3.5 text-stone-400"></i>
                        </div>
                        <p class="text-[11px] text-stone-400 mt-1">Nomor aktif yang dapat dihubungi melalui telepon atau WhatsApp (maks. 20 karakter).</p>
                        @error('no_hp')
                        <p class="text-xs text-rose-600 mt-1 flex items-center gap-1 font-medium">
                            <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    {{-- 3. Alamat Lengkap --}}
                    <div>
                        <label for="alamat" class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">
                            Alamat Lengkap <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <textarea
                                id="alamat"
                                name="alamat"
                                rows="4"
                                required
                                maxlength="500"
                                placeholder="Tuliskan alamat domisili lengkap Anda (Dusun, RT/RW, Desa Jambelaer)..."
                                class="w-full pl-10 pr-4 py-3 rounded-xl border {{ $errors->has('alamat') ? 'border-rose-400 ring-2 ring-rose-100' : 'border-stone-200' }} bg-stone-50/50 text-stone-800 text-sm font-medium focus:bg-white focus:border-forest-700 focus:ring-2 focus:ring-forest-100 outline-none transition-all resize-y">{{ old('alamat', $user->alamat) }}</textarea>
                            <i data-lucide="map-pin" class="w-4 h-4 absolute left-3.5 top-3.5 text-stone-400"></i>
                        </div>
                        <p class="text-[11px] text-stone-400 mt-1">Maksimal 500 karakter.</p>
                        @error('alamat')
                        <p class="text-xs text-rose-600 mt-1 flex items-center gap-1 font-medium">
                            <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="pt-4 border-t border-stone-100 flex flex-col-reverse sm:flex-row items-center justify-end gap-3">
                        <a href="{{ route('pengajuan.saya') }}"
                            class="w-full sm:w-auto px-5 py-2.5 rounded-xl border border-stone-300 text-stone-700 hover:bg-stone-50 text-xs font-bold transition-all text-center flex items-center justify-center gap-2">
                            <i data-lucide="x" class="w-4 h-4"></i>
                            Batal
                        </a>
                        <button type="submit"
                            class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-forest-800 hover:bg-forest-900 text-white text-xs font-bold transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                            <i data-lucide="save" class="w-4 h-4"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

