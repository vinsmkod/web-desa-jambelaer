@extends('admin.layouts.admin')

@section('title', 'Tentang Kami')
@section('page_title', 'Kelola Tentang Kami')
@section('page_subtitle', 'Atur profil, sambutan kepala desa, visi & misi, dan struktur organisasi')

@section('content')

{{-- ── Tab Navigation ─────────────────────────────────────────────────────── --}}
<div class="flex items-center gap-1 bg-slate-900 border border-slate-800 rounded-2xl p-1.5 mb-6 max-w-4xl">
    <button onclick="switchTab('kades')" id="tab-kades"
        class="tab-btn flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 bg-emerald-600 text-white shadow">
        <i data-lucide="user" class="w-4 h-4"></i>
        <span class="hidden sm:inline">Kepala Desa</span>
    </button>
    <button onclick="switchTab('visimisi')" id="tab-visimisi"
        class="tab-btn flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 text-slate-400 hover:text-white hover:bg-slate-800">
        <i data-lucide="target" class="w-4 h-4"></i>
        <span class="hidden sm:inline">Visi & Misi</span>
    </button>
    <button onclick="switchTab('profil')" id="tab-profil"
        class="tab-btn flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 text-slate-400 hover:text-white hover:bg-slate-800">
        <i data-lucide="info" class="w-4 h-4"></i>
        <span class="hidden sm:inline">Profil Desa</span>
    </button>
    <button onclick="switchTab('struktur')" id="tab-struktur"
        class="tab-btn flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 text-slate-400 hover:text-white hover:bg-slate-800">
        <i data-lucide="sitemap" class="w-4 h-4"></i>
        <span class="hidden sm:inline">Struktur</span>
        @if(!$strukturList->isEmpty())
        <span class="ml-auto text-[10px] bg-amber-500/80 text-white font-bold px-1.5 py-0.5 rounded-md hidden sm:block">{{ $strukturList->count() }}</span>
        @endif
    </button>
</div>

<form method="POST" action="{{ route('admin.tentang.update') }}" class="max-w-4xl" enctype="multipart/form-data" id="tentang-form">
    @csrf @method('PUT')

    {{-- ══════════════════════════════════════════════════════════ --}}
    {{-- TAB: Kepala Desa                                          --}}
    {{-- ══════════════════════════════════════════════════════════ --}}
    <div id="panel-kades" class="space-y-5">

        {{-- Preview Card + Upload --}}
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6">
            <div class="flex items-center gap-3 border-b border-slate-800 pb-4 mb-6">
                <div class="w-8 h-8 rounded-lg bg-emerald-600/20 flex items-center justify-center text-emerald-400">
                    <i data-lucide="camera" class="w-4 h-4"></i>
                </div>
                <div>
                    <h2 class="font-display font-bold text-white text-sm">Foto Kepala Desa</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Tampil di halaman Tentang Kami</p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-6 items-start">
                {{-- Live Preview --}}
                <div class="flex-shrink-0 flex flex-col items-center gap-3">
                    <div class="relative">
                        <img id="kades-foto-preview-el"
                             src="{{ $settings['kades_foto']->value ?? 'https://ui-avatars.com/api/?name=Kepala+Desa&background=065f46&color=fff&size=200' }}"
                             alt="Foto Kepala Desa"
                             class="w-32 h-32 rounded-2xl object-cover border-2 border-slate-700 shadow-lg">
                        <label for="kades-foto-upload"
                               class="absolute -bottom-2 -right-2 w-8 h-8 rounded-full bg-emerald-600 hover:bg-emerald-500 text-white flex items-center justify-center cursor-pointer shadow-md transition-colors">
                            <i data-lucide="upload" class="w-3.5 h-3.5"></i>
                        </label>
                    </div>
                    <span class="text-xs text-slate-500">Klik ikon upload</span>
                </div>

                {{-- Upload field (hidden, triggered by label) --}}
                <div class="flex-1 space-y-4 w-full">
                    <div>
                        <label class="form-label">Ganti Foto</label>
                        <input type="file" name="kades_foto" id="kades-foto-upload" accept="image/*"
                               class="form-input" onchange="previewKadesImg(event)">
                        <p class="text-xs text-slate-500 mt-1.5">Format: JPG, PNG, WebP. Maks. 2 MB. Kosongkan jika tidak ingin diubah.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Data Diri --}}
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-5">
            <div class="flex items-center gap-3 border-b border-slate-800 pb-4">
                <div class="w-8 h-8 rounded-lg bg-emerald-600/20 flex items-center justify-center text-emerald-400">
                    <i data-lucide="user" class="w-4 h-4"></i>
                </div>
                <div>
                    <h2 class="font-display font-bold text-white text-sm">Data Kepala Desa</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Nama, jabatan, dan motto pelayanan</p>
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="kades_nama"
                           value="{{ old('kades_nama', $settings['kades_nama']->value ?? '') }}"
                           class="form-input" placeholder="cth: Bapak Dedi Suherman, S.E.">
                </div>
                <div>
                    <label class="form-label">Jabatan</label>
                    <input type="text" name="kades_jabatan"
                           value="{{ old('kades_jabatan', $settings['kades_jabatan']->value ?? '') }}"
                           class="form-input" placeholder="cth: Kepala Desa Jambelaer">
                </div>
            </div>

            <div>
                <label class="form-label">Slogan / Motto Pelayanan</label>
                <input type="text" name="kades_motto"
                       value="{{ old('kades_motto', $settings['kades_motto']->value ?? '') }}"
                       class="form-input" placeholder="cth: Melayani dengan Amanah, Terbuka, dan Transparan.">
                <p class="text-xs text-slate-500 mt-1.5">Ditampilkan dengan ikon centang di bawah sambutan.</p>
            </div>
        </div>

        {{-- Sambutan --}}
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-5">
            <div class="flex items-center gap-3 border-b border-slate-800 pb-4">
                <div class="w-8 h-8 rounded-lg bg-sky-600/20 flex items-center justify-center text-sky-400">
                    <i data-lucide="quote" class="w-4 h-4"></i>
                </div>
                <div>
                    <h2 class="font-display font-bold text-white text-sm">Teks Sambutan</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Dua paragraf sambutan kepala desa</p>
                </div>
            </div>

            <div>
                <label class="form-label">Paragraf Pertama</label>
                <textarea name="kades_sambutan_1" rows="4" class="form-input resize-none"
                          placeholder="Tulis paragraf pembuka sambutan kepala desa...">{{ old('kades_sambutan_1', $settings['kades_sambutan_1']->value ?? '') }}</textarea>
            </div>
            <div>
                <label class="form-label">Paragraf Kedua</label>
                <textarea name="kades_sambutan_2" rows="4" class="form-input resize-none"
                          placeholder="Tulis paragraf penutup sambutan kepala desa...">{{ old('kades_sambutan_2', $settings['kades_sambutan_2']->value ?? '') }}</textarea>
            </div>
        </div>

        {{-- Save --}}
        <div class="flex justify-end pb-2">
            <button type="submit" class="btn-primary">
                <i data-lucide="save" class="w-4 h-4"></i>
                Simpan Perubahan
            </button>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════ --}}
    {{-- TAB: Visi & Misi                                          --}}
    {{-- ══════════════════════════════════════════════════════════ --}}
    <div id="panel-visimisi" class="space-y-5 hidden">

        {{-- Visi --}}
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-5">
            <div class="flex items-center gap-3 border-b border-slate-800 pb-4">
                <div class="w-8 h-8 rounded-lg bg-amber-600/20 flex items-center justify-center text-amber-400">
                    <i data-lucide="eye" class="w-4 h-4"></i>
                </div>
                <div>
                    <h2 class="font-display font-bold text-white text-sm">Visi Desa</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Cita-cita besar desa dalam jangka panjang</p>
                </div>
            </div>

            <div>
                <label class="form-label">Teks Visi Utama</label>
                <textarea name="visi_text" rows="3" class="form-input resize-none"
                          placeholder="cth: Mewujudkan Desa Jambelaer yang Mandiri, Sejahtera...">{{ old('visi_text', $settings['visi_text']->value ?? '') }}</textarea>
                <p class="text-xs text-slate-500 mt-1.5">Ditampilkan dalam kotak kutipan di halaman Tentang Kami.</p>
            </div>

            <div>
                <label class="form-label">Penjelasan Visi</label>
                <textarea name="visi_desc" rows="3" class="form-input resize-none"
                          placeholder="Jelaskan makna dan arah pembangunan berdasarkan visi di atas...">{{ old('visi_desc', $settings['visi_desc']->value ?? '') }}</textarea>
            </div>
        </div>

        {{-- Misi --}}
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-5">
            <div class="flex items-center gap-3 border-b border-slate-800 pb-4">
                <div class="w-8 h-8 rounded-lg bg-violet-600/20 flex items-center justify-center text-violet-400">
                    <i data-lucide="list-checks" class="w-4 h-4"></i>
                </div>
                <div>
                    <h2 class="font-display font-bold text-white text-sm">Misi Desa</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Langkah nyata untuk mewujudkan visi</p>
                </div>
            </div>

            <div>
                <label class="form-label">Daftar Misi</label>
                <textarea name="misi_list" rows="7" class="form-input resize-none font-mono text-sm"
                          placeholder="Tulis satu misi per baris&#10;Baris 1: Misi pertama&#10;Baris 2: Misi kedua&#10;...">{{ old('misi_list', $settings['misi_list']->value ?? '') }}</textarea>
                <div class="flex items-center gap-2 mt-2">
                    <i data-lucide="info" class="w-3.5 h-3.5 text-slate-500 flex-shrink-0"></i>
                    <p class="text-xs text-slate-500">Setiap baris baru (Enter) = satu butir misi. Akan ditampilkan dengan nomor urut secara otomatis.</p>
                </div>
            </div>
        </div>

        {{-- Save --}}
        <div class="flex justify-end pb-2">
            <button type="submit" class="btn-primary">
                <i data-lucide="save" class="w-4 h-4"></i>
                Simpan Perubahan
            </button>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════ --}}
    {{-- TAB: Profil Singkat                                       --}}
    {{-- ══════════════════════════════════════════════════════════ --}}
    <div id="panel-profil" class="space-y-5 hidden">

        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-5">
            <div class="flex items-center gap-3 border-b border-slate-800 pb-4">
                <div class="w-8 h-8 rounded-lg bg-emerald-600/20 flex items-center justify-center text-emerald-400">
                    <i data-lucide="layout-grid" class="w-4 h-4"></i>
                </div>
                <div>
                    <h2 class="font-display font-bold text-white text-sm">3 Kartu Profil Singkat</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Tampil sebagai kartu grid di bawah sambutan kepala desa</p>
                </div>
            </div>

            <div class="grid gap-5">
                {{-- Kartu 1 --}}
                <div class="p-4 rounded-xl border border-slate-700/60 bg-slate-800/40">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-6 h-6 rounded-lg bg-emerald-600/20 flex items-center justify-center text-emerald-400 flex-shrink-0">
                            <i data-lucide="map-pin" class="w-3.5 h-3.5"></i>
                        </div>
                        <span class="text-xs font-bold text-slate-300 uppercase tracking-wider">Kartu 1 – Letak Geografis</span>
                    </div>
                    <textarea name="tentang_geo" rows="2" class="form-input resize-none text-sm"
                              placeholder="Desa Jambelaer terletak di Kecamatan Dawuan, Kabupaten Subang, Provinsi Jawa Barat.">{{ old('tentang_geo', $settings['tentang_geo']->value ?? '') }}</textarea>
                </div>

                {{-- Kartu 2 --}}
                <div class="p-4 rounded-xl border border-slate-700/60 bg-slate-800/40">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-6 h-6 rounded-lg bg-amber-600/20 flex items-center justify-center text-amber-400 flex-shrink-0">
                            <i data-lucide="tractor" class="w-3.5 h-3.5"></i>
                        </div>
                        <span class="text-xs font-bold text-slate-300 uppercase tracking-wider">Kartu 2 – Potensi Utama</span>
                    </div>
                    <textarea name="tentang_potensi" rows="2" class="form-input resize-none text-sm"
                              placeholder="Lahan persawahan yang produktif menjadi tulang punggung perekonomian desa...">{{ old('tentang_potensi', $settings['tentang_potensi']->value ?? '') }}</textarea>
                </div>

                {{-- Kartu 3 --}}
                <div class="p-4 rounded-xl border border-slate-700/60 bg-slate-800/40">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-6 h-6 rounded-lg bg-sky-600/20 flex items-center justify-center text-sky-400 flex-shrink-0">
                            <i data-lucide="users" class="w-3.5 h-3.5"></i>
                        </div>
                        <span class="text-xs font-bold text-slate-300 uppercase tracking-wider">Kartu 3 – Administrasi</span>
                    </div>
                    <textarea name="tentang_admin" rows="2" class="form-input resize-none text-sm"
                              placeholder="Salah satu dari 10 desa di bawah Kecamatan Dawuan dengan pemerintahan yang aktif dan transparan.">{{ old('tentang_admin', $settings['tentang_admin']->value ?? '') }}</textarea>
                </div>

                {{-- Batas Wilayah --}}
                <div class="p-4 rounded-xl border border-slate-700/60 bg-slate-800/40 font-display">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-6 h-6 rounded-lg bg-emerald-600/20 flex items-center justify-center text-emerald-400 flex-shrink-0">
                            <i data-lucide="compass" class="w-3.5 h-3.5"></i>
                        </div>
                        <span class="text-xs font-bold text-slate-300 uppercase tracking-wider">Batas-Batas Wilayah</span>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs text-slate-400 mb-1.5 block">Sebelah Utara</label>
                            <input type="text" name="batas_utara"
                                   value="{{ old('batas_utara', $settings['batas_utara']->value ?? '') }}"
                                   class="form-input text-sm" placeholder="cth: Desa Cisampih">
                        </div>
                        <div>
                            <label class="text-xs text-slate-400 mb-1.5 block">Sebelah Timur</label>
                            <input type="text" name="batas_timur"
                                   value="{{ old('batas_timur', $settings['batas_timur']->value ?? '') }}"
                                   class="form-input text-sm" placeholder="cth: Kelurahan Parung">
                        </div>
                        <div>
                            <label class="text-xs text-slate-400 mb-1.5 block">Sebelah Selatan</label>
                            <input type="text" name="batas_selatan"
                                   value="{{ old('batas_selatan', $settings['batas_selatan']->value ?? '') }}"
                                   class="form-input text-sm" placeholder="cth: Desa Curug Agung">
                        </div>
                        <div>
                            <label class="text-xs text-slate-400 mb-1.5 block">Sebelah Barat</label>
                            <input type="text" name="batas_barat"
                                   value="{{ old('batas_barat', $settings['batas_barat']->value ?? '') }}"
                                   class="form-input text-sm" placeholder="cth: Desa Tanggulun Timur">
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-700/60">
                        <label class="text-xs text-slate-400 mb-1.5 block">Luas Wilayah (Ha)</label>
                        <input type="text" name="stat_luas"
                               value="{{ old('stat_luas', $settings['stat_luas']->value ?? '') }}"
                               class="form-input text-sm" placeholder="cth: 2.500,366">
                        <p class="text-xs text-slate-500 mt-1">Nilai ini ditampilkan pada bagian <em>"Luas Wilayah"</em> di halaman Tentang Kami.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Save --}}
        <div class="flex justify-end pb-2">
            <button type="submit" class="btn-primary">
                <i data-lucide="save" class="w-4 h-4"></i>
                Simpan Perubahan
            </button>
        </div>
    </div>

</form>

{{-- ══════════════════════════════════════════════════════════════════════════ --}}
{{-- TAB: Struktur Organisasi (outside main form)                              --}}
{{-- ══════════════════════════════════════════════════════════════════════════ --}}
<div id="panel-struktur" class="hidden max-w-4xl space-y-5">

    {{-- Daftar Anggota --}}
    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-800">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-amber-600/20 flex items-center justify-center text-amber-400">
                    <i data-lucide="sitemap" class="w-4 h-4"></i>
                </div>
                <div>
                    <h2 class="font-display font-bold text-white text-sm">Daftar Anggota Struktur</h2>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $strukturList->count() }} anggota · urutan terkecil tampil di atas</p>
                </div>
            </div>
            <button onclick="document.getElementById('form-tambah').classList.toggle('hidden')"
                    class="inline-flex items-center gap-2 px-3 py-2 rounded-xl bg-emerald-600/20 hover:bg-emerald-600/30 text-emerald-400 text-xs font-semibold transition-all border border-emerald-600/20">
                <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                Tambah
            </button>
        </div>

        @if($strukturList->isEmpty())
        <div class="flex flex-col items-center justify-center py-14 text-slate-600">
            <div class="w-14 h-14 rounded-2xl bg-slate-800 flex items-center justify-center mb-3">
                <i data-lucide="users" class="w-7 h-7"></i>
            </div>
            <p class="text-sm font-medium text-slate-500">Belum ada anggota</p>
            <p class="text-xs text-slate-600 mt-1">Klik tombol "Tambah" untuk menambahkan anggota pertama</p>
        </div>
        @else
        <div class="divide-y divide-slate-800/60">
            @foreach($strukturList as $idx => $anggota)
            <div class="flex items-center gap-4 px-6 py-4 hover:bg-slate-800/30 transition-colors group">
                {{-- Urutan badge --}}
                <div class="w-6 h-6 rounded-full bg-slate-800 flex items-center justify-center text-slate-500 text-xs font-bold flex-shrink-0">
                    {{ $anggota->urutan }}
                </div>
                {{-- Foto --}}
                <img src="{{ $anggota->foto ? asset($anggota->foto) : 'https://ui-avatars.com/api/?name='.urlencode($anggota->nama).'&background=065f46&color=fff&size=80' }}"
                     alt="{{ $anggota->nama }}"
                     class="w-11 h-11 rounded-full object-cover border-2 border-slate-700 flex-shrink-0">
                {{-- Info --}}
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-white truncate">{{ $anggota->nama }}</p>
                    <p class="text-xs text-slate-400 truncate mt-0.5">{{ $anggota->jabatan }}</p>
                </div>
                {{-- Actions --}}
                <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    <button type="button"
                        onclick="openEditModal({{ $anggota->id }}, '{{ addslashes($anggota->nama) }}', '{{ addslashes($anggota->jabatan) }}', {{ $anggota->urutan }}, '{{ $anggota->foto ? asset($anggota->foto) : '' }}')"
                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-700 hover:bg-slate-600 text-slate-300 hover:text-white text-xs font-medium transition-all">
                        <i data-lucide="pencil" class="w-3 h-3"></i> Edit
                    </button>
                    <form method="POST" action="{{ route('admin.struktur.destroy', $anggota) }}"
                          onsubmit="return confirm('Hapus {{ addslashes($anggota->nama) }}?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-red-900/20 hover:bg-red-900/50 text-red-400 hover:text-red-300 text-xs font-medium transition-all">
                            <i data-lucide="trash-2" class="w-3 h-3"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        {{-- Form Tambah (collapsible) --}}
        <div id="form-tambah" class="hidden border-t border-slate-800 bg-slate-800/30 p-6">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                <i data-lucide="user-plus" class="w-3.5 h-3.5 text-emerald-400"></i>
                Tambah Anggota Baru
            </p>
            <form method="POST" action="{{ route('admin.struktur.store') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-input" placeholder="cth: Ahmad Fauzi, S.Pd." required>
                    </div>
                    <div>
                        <label class="form-label">Jabatan</label>
                        <input type="text" name="jabatan" class="form-input" placeholder="cth: Sekretaris Desa" required>
                    </div>
                </div>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Foto <span class="text-slate-600 normal-case font-normal">(opsional)</span></label>
                        <input type="file" name="foto" accept="image/*" class="form-input"
                               onchange="previewStrukturImg(event, 'struktur-new-preview')">
                        <div class="mt-2.5 hidden" id="struktur-new-preview-wrap">
                            <img id="struktur-new-preview" class="w-14 h-14 rounded-full object-cover border-2 border-slate-600" src="" alt="Preview">
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Urutan Tampil</label>
                        <input type="number" name="urutan" value="0" min="0" class="form-input" placeholder="0">
                        <p class="text-xs text-slate-500 mt-1">Angka terkecil tampil paling atas/kiri.</p>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-3 pt-1">
                    <button type="button" onclick="document.getElementById('form-tambah').classList.add('hidden')"
                            class="px-4 py-2 rounded-xl text-sm text-slate-400 hover:text-white border border-slate-700 hover:border-slate-500 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="btn-primary">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        Tambah Anggota
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>{{-- /panel-struktur --}}


{{-- ══ Modal Edit Anggota ════════════════════════════════════════════════════ --}}
<div id="edit-struktur-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 backdrop-blur-sm p-4">
    <div class="bg-slate-900 border border-slate-700 rounded-2xl w-full max-w-md shadow-2xl">
        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-800">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-emerald-600/20 flex items-center justify-center text-emerald-400">
                    <i data-lucide="pencil" class="w-4 h-4"></i>
                </div>
                <h3 class="font-display font-bold text-white">Edit Anggota</h3>
            </div>
            <button onclick="closeEditModal()" class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition-all">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
        {{-- Form --}}
        <form id="edit-struktur-form" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf @method('PUT')

            {{-- Foto preview --}}
            <div class="flex items-center gap-4 p-4 bg-slate-800/60 rounded-xl border border-slate-700">
                <img id="edit-foto-preview" class="w-16 h-16 rounded-full object-cover border-2 border-slate-600 flex-shrink-0" src="" alt="Preview">
                <div class="flex-1 min-w-0">
                    <label class="form-label">Ganti Foto <span class="text-slate-600 normal-case font-normal">(opsional)</span></label>
                    <input type="file" name="foto" accept="image/*" class="form-input text-xs"
                           onchange="previewStrukturImg(event, 'edit-foto-preview')">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" id="edit-nama" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">Urutan</label>
                    <input type="number" name="urutan" id="edit-urutan" min="0" class="form-input">
                </div>
            </div>
            <div>
                <label class="form-label">Jabatan</label>
                <input type="text" name="jabatan" id="edit-jabatan" class="form-input" required>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="closeEditModal()"
                        class="px-4 py-2.5 rounded-xl text-sm text-slate-400 hover:text-white border border-slate-700 hover:border-slate-500 transition-colors">
                    Batal
                </button>
                <button type="submit" class="btn-primary">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
// ── Tab Switching ──────────────────────────────────────────────────────────
const tabs    = ['kades', 'visimisi', 'profil', 'struktur'];
const tabBtns = document.querySelectorAll('.tab-btn');

function switchTab(name) {
    tabs.forEach(t => {
        const panel = document.getElementById('panel-' + t);
        const btn   = document.getElementById('tab-' + t);
        if (t === name) {
            panel.classList.remove('hidden');
            btn.classList.add('bg-emerald-600', 'text-white', 'shadow');
            btn.classList.remove('text-slate-400', 'hover:bg-slate-800', 'hover:text-white');
        } else {
            panel.classList.add('hidden');
            btn.classList.remove('bg-emerald-600', 'text-white', 'shadow');
            btn.classList.add('text-slate-400', 'hover:bg-slate-800', 'hover:text-white');
        }
    });
    // Persist active tab
    localStorage.setItem('tentang_active_tab', name);
    lucide.createIcons();
}

// Restore last active tab
const savedTab = localStorage.getItem('tentang_active_tab');
if (savedTab && tabs.includes(savedTab)) switchTab(savedTab);

// ── Foto Preview ──────────────────────────────────────────────────────────
function previewKadesImg(event) {
    const img  = document.getElementById('kades-foto-preview-el');
    const file = event.target.files[0];
    if (file) img.src = URL.createObjectURL(file);
}

function previewStrukturImg(event, targetId) {
    const img  = document.getElementById(targetId);
    const wrap = document.getElementById(targetId + '-wrap');
    const file = event.target.files[0];
    if (file) {
        img.src = URL.createObjectURL(file);
        if (wrap) wrap.classList.remove('hidden');
    }
}

// ── Edit Modal ────────────────────────────────────────────────────────────
function openEditModal(id, nama, jabatan, urutan, fotoUrl) {
    const modal   = document.getElementById('edit-struktur-modal');
    const form    = document.getElementById('edit-struktur-form');
    form.action   = `/admin/struktur/${id}`;
    document.getElementById('edit-nama').value    = nama;
    document.getElementById('edit-jabatan').value = jabatan;
    document.getElementById('edit-urutan').value  = urutan;
    const preview = document.getElementById('edit-foto-preview');
    preview.src   = fotoUrl || `https://ui-avatars.com/api/?name=${encodeURIComponent(nama)}&background=065f46&color=fff&size=160`;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    lucide.createIcons();
}

function closeEditModal() {
    const modal = document.getElementById('edit-struktur-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

document.getElementById('edit-struktur-modal').addEventListener('click', function(e) {
    if (e.target === this) closeEditModal();
});
</script>
@endpush
