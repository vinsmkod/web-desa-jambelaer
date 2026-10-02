@extends('admin.layouts.admin')

@section('title', 'Detail Pendaftaran UMKM - Admin Desa Jambelaer')
@section('page-title', 'Detail & Verifikasi UMKM')

@section('content')
<div class="space-y-6">

    <!-- Header Back -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <a href="{{ route('admin.pendaftaran-umkm.index') }}"
           class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar UMKM
        </a>

        <div class="flex items-center space-x-2">
            <span class="text-xs font-mono bg-gray-100 text-gray-700 px-2.5 py-1 rounded">
                No. Reg: {{ $pendaftaranUmkm->kode_pendaftaran }}
            </span>

            <span class="px-2.5 py-1 text-xs font-semibold rounded-full
                @if($pendaftaranUmkm->status === 'disetujui')          bg-emerald-100 text-emerald-800
                @elseif($pendaftaranUmkm->status === 'diproses')        bg-blue-100 text-blue-800
                @elseif($pendaftaranUmkm->status === 'menunggu_verifikasi') bg-amber-100 text-amber-800
                @else                                                   bg-red-100 text-red-800
                @endif">
                {{ ucwords(str_replace('_', ' ', $pendaftaranUmkm->status)) }}
            </span>

            @if($pendaftaranUmkm->is_published)
                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                    Katalog Aktif
                </span>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Profil Usaha -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-6">
                <div class="flex items-start justify-between">
                    <div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded">
                            {{ $pendaftaranUmkm->kategori_usaha ?? 'UMKM Desa' }}
                        </span>
                        <h2 class="text-2xl font-bold text-gray-900 mt-2">
                            {{ $pendaftaranUmkm->nama_usaha }}
                        </h2>
                        <p class="text-xs text-gray-500 mt-1">
                            Diajukan pada {{ $pendaftaranUmkm->created_at->isoFormat('dddd, D MMMM Y - HH:mm') }} WIB
                        </p>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                    <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                        Deskripsi Usaha & Produk
                    </h4>
                    <p class="text-gray-800 text-sm whitespace-pre-line leading-relaxed">
                        {{ $pendaftaranUmkm->deskripsi }}
                    </p>
                </div>

                <!-- Informasi Pemilik & Legalitas -->
                <div class="border-t border-gray-100 pt-5">
                    <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">
                        Informasi Pemilik & Legalitas
                    </h4>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500 text-xs block">Nama Pemilik</span>
                            <span class="font-medium text-gray-900">{{ $pendaftaranUmkm->nama_pemilik }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 text-xs block">NIK Pemilik</span>
                            <span class="font-medium text-gray-900 font-mono">{{ $pendaftaranUmkm->nik }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 text-xs block">Nomor WhatsApp</span>
                            <span class="font-medium text-gray-900">
                                {{ $pendaftaranUmkm->whatsapp ?? $pendaftaranUmkm->telepon ?? '-' }}
                            </span>
                        </div>
                        <div>
                            <span class="text-gray-500 text-xs block">Email</span>
                            <span class="font-medium text-gray-900">{{ $pendaftaranUmkm->email ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 text-xs block">Nomor Induk Berusaha (NIB)</span>
                            <span class="font-medium text-gray-900 font-mono">
                                {{ $pendaftaranUmkm->nib ?? 'Belum ada' }}
                            </span>
                        </div>
                        <div>
                            <span class="text-gray-500 text-xs block">Sertifikasi Halal</span>
                            <span class="font-medium text-gray-900">
                                {{ $pendaftaranUmkm->nomor_halal ?? ($pendaftaranUmkm->status_halal ? 'Memiliki Sertifikat' : 'Belum Memiliki') }}
                            </span>
                        </div>
                        <div>
                            <span class="text-gray-500 text-xs block">Instagram Usaha</span>
                            <span class="font-medium text-gray-900">
                                {{ $pendaftaranUmkm->instagram ? '@' . ltrim($pendaftaranUmkm->instagram, '@') : '-' }}
                            </span>
                        </div>
                        <div>
                            <span class="text-gray-500 text-xs block">Kisaran Harga Produk</span>
                            <span class="font-medium text-gray-900">
                                @if($pendaftaranUmkm->harga_min || $pendaftaranUmkm->harga_max)
                                    Rp {{ number_format($pendaftaranUmkm->harga_min, 0, ',', '.') }} -
                                    Rp {{ number_format($pendaftaranUmkm->harga_max, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </span>
                        </div>
                        <div class="sm:col-span-2">
                            <span class="text-gray-500 text-xs block">Alamat Tempat Usaha</span>
                            <span class="font-medium text-gray-900">
                                {{ $pendaftaranUmkm->alamat_usaha ?? '-' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Foto & Lampiran Dokumen -->
                <div class="border-t border-gray-100 pt-5">
                    <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">
                        Lampiran Foto & Dokumen Pendukung
                    </h4>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        @if($pendaftaranUmkm->foto_produk)
                        <div class="p-3 bg-gray-50 rounded-xl border border-gray-200">
                            <span class="text-xs font-semibold text-gray-700 block mb-2">Foto Produk Utama</span>
                            <a href="{{ asset('storage/' . $pendaftaranUmkm->foto_produk) }}"
                               target="_blank"
                               class="block aspect-video rounded-lg overflow-hidden bg-gray-200 hover:opacity-90 transition">
                                <img src="{{ asset('storage/' . $pendaftaranUmkm->foto_produk) }}"
                                     alt="Foto Produk"
                                     class="w-full h-full object-cover">
                            </a>
                        </div>
                        @endif

                        @if($pendaftaranUmkm->foto_usaha)
                        <div class="p-3 bg-gray-50 rounded-xl border border-gray-200">
                            <span class="text-xs font-semibold text-gray-700 block mb-2">Foto Tempat Usaha</span>
                            <a href="{{ asset('storage/' . $pendaftaranUmkm->foto_usaha) }}"
                               target="_blank"
                               class="block aspect-video rounded-lg overflow-hidden bg-gray-200 hover:opacity-90 transition">
                                <img src="{{ asset('storage/' . $pendaftaranUmkm->foto_usaha) }}"
                                     alt="Foto Usaha"
                                     class="w-full h-full object-cover">
                            </a>
                        </div>
                        @endif

                        @if($pendaftaranUmkm->dokumen_nib)
                        <div class="p-3 bg-gray-50 rounded-xl border border-gray-200 flex flex-col justify-between">
                            <div>
                                <span class="text-xs font-semibold text-gray-700 block mb-1">Dokumen NIB / Izin</span>
                                <p class="text-xs text-gray-500 mb-2">File dokumen legalitas usaha</p>
                            </div>
                            <a href="{{ asset('storage/' . $pendaftaranUmkm->dokumen_nib) }}"
                               target="_blank"
                               class="inline-flex items-center justify-center px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-medium transition">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Unduh NIB
                            </a>
                        </div>
                        @endif

                        @if($pendaftaranUmkm->sertifikat_halal)
                        <div class="p-3 bg-gray-50 rounded-xl border border-gray-200 flex flex-col justify-between">
                            <div>
                                <span class="text-xs font-semibold text-gray-700 block mb-1">Sertifikat Halal</span>
                                <p class="text-xs text-gray-500 mb-2">Dokumen sertifikasi kehalalan</p>
                            </div>
                            <a href="{{ asset('storage/' . $pendaftaranUmkm->sertifikat_halal) }}"
                               target="_blank"
                               class="inline-flex items-center justify-center px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-medium transition">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Unduh Sertifikat
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Form Verifikasi Admin -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Verifikasi & Catatan Petugas</h3>

                <form action="{{ route('admin.pendaftaran-umkm.status', $pendaftaranUmkm->id) }}"
                      method="POST"
                      class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">
                                Status Verifikasi
                            </label>
                            <select name="status"
                                    class="w-full text-sm border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500">
                                <option value="menunggu_verifikasi"
                                    {{ $pendaftaranUmkm->status == 'menunggu_verifikasi' ? 'selected' : '' }}>
                                    Menunggu Verifikasi
                                </option>
                                <option value="diproses"
                                    {{ $pendaftaranUmkm->status == 'diproses' ? 'selected' : '' }}>
                                    Sedang Diproses
                                </option>
                                <option value="disetujui"
                                    {{ $pendaftaranUmkm->status == 'disetujui' ? 'selected' : '' }}>
                                    Disetujui
                                </option>
                                <option value="ditolak"
                                    {{ $pendaftaranUmkm->status == 'ditolak' ? 'selected' : '' }}>
                                    Ditolak
                                </option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">
                            Catatan Verifikasi untuk Pemilik UMKM
                        </label>
                        <textarea name="catatan_admin"
                                  rows="3"
                                  class="w-full text-sm border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500"
                                  placeholder="Tuliskan catatan verifikasi atau alasan jika permohonan ditolak...">{{ old('catatan_admin', $pendaftaranUmkm->catatan_admin) }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 shadow-sm">
                            Simpan Perubahan Verifikasi
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar Actions & Info -->
        <div class="space-y-6">

            <!-- Publikasi ke Katalog Produk Desa -->
            <div class="bg-white rounded-xl shadow-sm border border-purple-100 p-5 space-y-4">
                <div class="flex items-center justify-between">
                    <h4 class="text-xs font-semibold text-purple-700 uppercase tracking-wider">
                        Publikasi Katalog UMKM
                    </h4>
                    <span class="w-2.5 h-2.5 rounded-full {{ $pendaftaranUmkm->is_published ? 'bg-purple-500' : 'bg-gray-300' }}"></span>
                </div>

                <p class="text-xs text-gray-600">
                    Jika disetujui, UMKM ini dapat dipublikasikan ke halaman katalog UMKM publik desa agar dapat dilihat oleh masyarakat luas.
                </p>

                <form action="{{ route('admin.pendaftaran-umkm.publikasikan', $pendaftaranUmkm->id) }}" method="POST">
                    @csrf
                    @if($pendaftaranUmkm->is_published)
                        <button type="submit"
                                class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-amber-50 hover:bg-amber-100 text-amber-800 font-medium rounded-lg text-sm border border-amber-200 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                            </svg>
                            Tarik dari Katalog Publik
                        </button>
                    @else
                        <button type="submit"
                                class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg text-sm shadow transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                            </svg>
                            Publikasikan ke Katalog Desa
                        </button>
                    @endif
                </form>

                @if($pendaftaranUmkm->produk)
                <div class="pt-3 border-t border-purple-50">
                    <span class="text-xs text-gray-500 block">Terkait Data Katalog:</span>
                    <a href="{{ route('admin.produk.edit', $pendaftaranUmkm->produk->id) }}"
                       class="text-xs font-semibold text-purple-700 hover:underline inline-flex items-center mt-1">
                        Edit Data Katalog Produk &rarr;
                    </a>
                </div>
                @endif
            </div>

            <!-- Kontak Pemilik -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 space-y-3">
                <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Kontak Langsung</h4>

                @if($pendaftaranUmkm->whatsapp || $pendaftaranUmkm->telepon)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pendaftaranUmkm->whatsapp ?? $pendaftaranUmkm->telepon) }}?text=Halo%20{{ urlencode($pendaftaranUmkm->nama_pemilik) }},%20kami%20dari%20Pemerintah%20Desa%20Jambelaer%20mengenai%20pendaftaran%20UMKM%20{{ urlencode($pendaftaranUmkm->nama_usaha) }}%20(No%20Reg%20{{ $pendaftaranUmkm->kode_pendaftaran }}):"
                   target="_blank"
                   class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-medium rounded-lg text-sm border border-emerald-200 transition">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.669-.699c.969.54 1.772.8 2.791.8 3.182 0 5.768-2.587 5.768-5.766.001-3.182-2.585-5.786-5.768-5.786zm0 10.355c-.947 0-1.637-.253-2.396-.708l-.171-.102-1.782.467.476-1.737-.113-.18c-.487-.775-.783-1.558-.782-2.529 0-2.518 2.05-4.568 4.568-4.568 2.519 0 4.569 2.05 4.569 4.568 0 2.518-2.05 4.568-4.568 4.568z"/>
                    </svg>
                    Chat via WhatsApp
                </a>
                @endif

                @if($pendaftaranUmkm->instagram)
                <a href="https://instagram.com/{{ ltrim($pendaftaranUmkm->instagram, '@') }}"
                   target="_blank"
                   class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-pink-50 hover:bg-pink-100 text-pink-700 font-medium rounded-lg text-sm border border-pink-200 transition">
                    Instagram Usaha
                </a>
                @endif
            </div>

            <!-- Hapus Data -->
            <div class="bg-white rounded-xl shadow-sm border border-red-100 p-5">
                <h4 class="text-xs font-semibold text-red-600 uppercase tracking-wider mb-2">Hapus Pendaftaran</h4>
                <p class="text-xs text-gray-500 mb-4">Menghapus data permohonan pendaftaran UMKM ini.</p>

                <form action="{{ route('admin.pendaftaran-umkm.destroy', $pendaftaranUmkm->id) }}"
                      method="POST"
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pendaftaran UMKM ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-50 hover:bg-red-100 text-red-700 font-medium rounded-lg text-sm border border-red-200 transition">
                        Hapus Pendaftaran
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
