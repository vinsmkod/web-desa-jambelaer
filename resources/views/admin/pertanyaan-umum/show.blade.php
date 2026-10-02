@extends('admin.layouts.admin')

@section('title', 'Detail Pertanyaan Umum - Admin Desa Jambelaer')
@section('page-title', 'Detail Pertanyaan')

@section('content')
<div class="space-y-6">
    <!-- Header Back -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.pertanyaan-umum.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar Pertanyaan
        </a>
        <div class="flex items-center space-x-2">
            <span class="text-xs font-mono bg-gray-100 text-gray-700 px-2.5 py-1 rounded">Kode: {{ $pertanyaan->kode_tiket }}</span>
            <span class="px-2.5 py-1 text-xs font-semibold rounded-full 
                @if($pertanyaan->status === 'dijawab') bg-emerald-100 text-emerald-800
                @elseif($pertanyaan->status === 'dibaca') bg-amber-100 text-amber-800
                @elseif($pertanyaan->status === 'ditutup') bg-gray-100 text-gray-800
                @else bg-blue-100 text-blue-800 @endif">
                {{ ucfirst($pertanyaan->status) }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Informasi Penanya & Pertanyaan -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-6">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded">Pertanyaan Umum Warga</span>
                    <h2 class="text-xl font-bold text-gray-900 mt-2">{{ $pertanyaan->subjek }}</h2>
                    <p class="text-xs text-gray-500 mt-1">Diajukan pada {{ $pertanyaan->created_at->isoFormat('dddd, D MMMM Y - HH:mm') }} WIB</p>
                </div>

                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                    <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Isi Pertanyaan</h4>
                    <p class="text-gray-800 text-sm whitespace-pre-line leading-relaxed">{{ $pertanyaan->pertanyaan }}</p>
                </div>

                <!-- Informasi Kontak Pengirim -->
                <div class="border-t border-gray-100 pt-4">
                    <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Identitas Penanya</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500 text-xs block">Nama Lengkap</span>
                            <span class="font-medium text-gray-900">{{ $pertanyaan->nama }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 text-xs block">Nomor WhatsApp / Telepon</span>
                            <span class="font-medium text-gray-900">{{ $pertanyaan->telepon ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 text-xs block">Alamat Email</span>
                            <span class="font-medium text-gray-900">{{ $pertanyaan->email ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 text-xs block">Akun Terdaftar</span>
                            <span class="font-medium text-gray-900">{{ $pertanyaan->user ? $pertanyaan->user->name . ' (' . $pertanyaan->user->email . ')' : 'Tamu / Umum' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Balasan / Tanggapan Admin -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Jawaban / Tanggapan Administrator</h3>
                <form action="{{ route('admin.pertanyaan-umum.status', $pertanyaan->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Status Pertanyaan</label>
                        <select name="status" class="w-full text-sm border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="terkirim" {{ $pertanyaan->status == 'terkirim' ? 'selected' : '' }}>Terkirim</option>
                            <option value="dibaca" {{ $pertanyaan->status == 'dibaca' ? 'selected' : '' }}>Dibaca</option>
                            <option value="dijawab" {{ $pertanyaan->status == 'dijawab' ? 'selected' : '' }}>Dijawab</option>
                            <option value="ditutup" {{ $pertanyaan->status == 'ditutup' ? 'selected' : '' }}>Ditutup</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Teks Jawaban untuk Warga</label>
                        <textarea name="jawaban" rows="5" class="w-full text-sm border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500" placeholder="Tuliskan penjelasan dan jawaban resmi dari Pemerintah Desa Jambelaer...">{{ old('jawaban', $pertanyaan->jawaban) }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 shadow-sm">
                            Simpan Tanggapan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 space-y-4">
                <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi Cepat Kontak</h4>
                <div class="space-y-2">
                    @if($pertanyaan->telepon)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pertanyaan->telepon) }}?text=Halo%20{{ urlencode($pertanyaan->nama) }},%20terkait%20pertanyaan%20Anda%20ke%20Pemerintah%20Desa%20Jambelaer%20(Kode%20{{ $pertanyaan->kode_tiket }}):" target="_blank" class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-medium rounded-lg text-sm border border-emerald-200 transition">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.669-.699c.969.54 1.772.8 2.791.8 3.182 0 5.768-2.587 5.768-5.766.001-3.182-2.585-5.786-5.768-5.786zm0 10.355c-.947 0-1.637-.253-2.396-.708l-.171-.102-1.782.467.476-1.737-.113-.18c-.487-.775-.783-1.558-.782-2.529 0-2.518 2.05-4.568 4.568-4.568 2.519 0 4.569 2.05 4.569 4.568 0 2.518-2.05 4.568-4.568 4.568z"/>
                        </svg>
                        Hubungi via WhatsApp
                    </a>
                    @endif
                    @if($pertanyaan->email)
                    <a href="mailto:{{ $pertanyaan->email }}?subject=Jawaban%20Pertanyaan%20Desa%20Jambelaer%20[{{ $pertanyaan->kode_tiket }}]" class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-gray-50 hover:bg-gray-100 text-gray-700 font-medium rounded-lg text-sm border border-gray-200 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Kirim Email
                    </a>
                    @endif
                </div>
            </div>

            <!-- Hapus Pertanyaan -->
            <div class="bg-white rounded-xl shadow-sm border border-red-100 p-5">
                <h4 class="text-xs font-semibold text-red-600 uppercase tracking-wider mb-2">Hapus Data</h4>
                <p class="text-xs text-gray-500 mb-4">Tindakan ini akan menghapus data pertanyaan ini secara permanen dari basis data.</p>
                <form action="{{ route('admin.pertanyaan-umum.destroy', $pertanyaan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pertanyaan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-50 hover:bg-red-100 text-red-700 font-medium rounded-lg text-sm border border-red-200 transition">
                        Hapus Pertanyaan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
