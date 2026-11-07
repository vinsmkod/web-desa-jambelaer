@extends('admin.layouts.admin')

@section('title', 'Kelola Profil Desa')
@section('page_title', 'Kelola Profil Desa')
@section('page_subtitle', 'Atur seluruh konten halaman "Profil Desa": sejarah, timeline, sambutan kades, wilayah, potensi, visi-misi, dan peta lokasi')

@section('content')

@php
    // Helper nilai: cek input lama (old) -> $tentang (default bawaan) -> tabel pengaturan.
    $val = fn($key) => old($key, $tentang[$key] ?? ($settings->get($key)?->value ?? ''));

    $tabs = [
        'sejarah'       => ['label' => 'Sejarah & Timeline', 'icon' => 'history'],
        'kades'         => ['label' => 'Kepala Desa',         'icon' => 'user-check'],
        'sambutan'      => ['label' => 'Sambutan',            'icon' => 'quote'],
        'wilayah'       => ['label' => 'Wilayah',             'icon' => 'map'],
        'potensi'       => ['label' => 'Potensi',             'icon' => 'sprout'],
        'administrasi'  => ['label' => 'Administrasi',        'icon' => 'building-2'],
        'visi-misi'     => ['label' => 'Visi & Misi',         'icon' => 'target'],
        'peta'          => ['label' => 'Peta Lokasi',         'icon' => 'map-pin'],
    ];

    // Saat validasi gagal, otomatis pindah ke tab yang berisi field error.
    $fieldTab = [
        'tentang_sejarah' => 'sejarah', 'tahun' => 'sejarah', 'judul' => 'sejarah',
        'deskripsi' => 'sejarah', 'ikon' => 'sejarah', 'warna' => 'sejarah', 'urutan' => 'sejarah',
        'kades_nama' => 'kades', 'kades_jabatan' => 'kades', 'kades_foto_file' => 'kades',
        'sambutan_judul' => 'sambutan', 'sambutan_quote' => 'sambutan',
        'sambutan_teks' => 'sambutan', 'sambutan_tagline' => 'sambutan',
        'tentang_letak' => 'wilayah', 'tentang_batas_utara' => 'wilayah', 'tentang_batas_timur' => 'wilayah',
        'tentang_batas_selatan' => 'wilayah', 'tentang_batas_barat' => 'wilayah', 'tentang_luas' => 'wilayah',
        'tentang_potensi_judul' => 'potensi', 'tentang_potensi_subjudul' => 'potensi', 'tentang_potensi_deskripsi' => 'potensi',
        'tentang_administrasi_judul' => 'administrasi', 'tentang_administrasi_subjudul' => 'administrasi',
        'tentang_administrasi_deskripsi' => 'administrasi', 'tentang_visi' => 'visi-misi',
        'tentang_visi_deskripsi' => 'visi-misi', 'isi' => 'visi-misi',
        'maps_embed_url' => 'peta', 'tentang_alamat' => 'peta', 'tentang_maps_link' => 'peta',
    ];
    $errorTab = null;
    if ($errors->any()) {
        foreach ($errors->keys() as $errKey) {
            if (isset($fieldTab[$errKey])) { $errorTab = $fieldTab[$errKey]; break; }
        }
    }
@endphp

{{-- â”€â”€ Notifikasi â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ --}}
@if(session('success'))
<div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 flex items-start gap-3 text-sm text-emerald-800 shadow-sm">
    <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-600 flex-shrink-0 mt-0.5"></i>
    <p class="font-semibold">{{ session('success') }}</p>
</div>
@endif
@if($errors->any())
<div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 flex items-start gap-3 text-sm text-rose-800 shadow-sm">
    <i data-lucide="alert-circle" class="w-5 h-5 text-rose-600 flex-shrink-0 mt-0.5"></i>
    <div class="space-y-0.5">
        <p class="font-semibold">Terjadi kesalahan pada data yang dikirim:</p>
        <ul class="list-disc list-inside text-xs font-normal">
            @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
        </ul>
    </div>
</div>
@endif

{{-- â”€â”€ Toolbar â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ --}}
<div class="flex items-center justify-between gap-3">
    <p class="text-xs text-slate-500 font-medium">Total {{ $timelineList->count() }} timeline Â· {{ $misiList->count() }} misi terdaftar</p>
    <a href="{{ route('profil.desa') }}" target="_blank" class="btn-secondary text-xs">
        <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
        Lihat Halaman Publik
    </a>
</div>

{{-- â”€â”€ Tab Navigation â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ --}}
<div class="flex items-center gap-1.5 bg-white border border-slate-200 rounded-2xl p-1.5 overflow-x-auto shadow-sm">
    @foreach($tabs as $key => $tab)
    <button type="button" onclick="switchTab('{{ $key }}')" id="tab-{{ $key }}"
        class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold transition-all duration-200 whitespace-nowrap cursor-pointer
               {{ $loop->first ? 'bg-forest-700 text-white shadow-sm' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-100' }}">
        <i data-lucide="{{ $tab['icon'] }}" class="w-4 h-4 flex-shrink-0"></i>
        <span>{{ $tab['label'] }}</span>
    </button>
    @endforeach
</div>
{{-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• PANEL: SEJARAH & TIMELINE â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• --}}
<div id="panel-sejarah" class="space-y-5 {{ $errorTab && $errorTab !== 'sejarah' ? 'hidden' : '' }}">
    <div class="flex items-center gap-4 p-4 bg-white border border-slate-200 rounded-2xl shadow-sm">
        <div class="w-10 h-10 rounded-xl bg-forest-50 border border-forest-200 flex items-center justify-center text-forest-700 flex-shrink-0">
            <i data-lucide="history" class="w-5 h-5"></i>
        </div>
        <div>
            <h2 class="font-display font-bold text-slate-900 text-sm">Sejarah &amp; Timeline Desa</h2>
            <p class="text-xs text-slate-400 mt-0.5">Paragraf pembuka sejarah beserta daftar tonggak sejarah (timeline) desa</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.tentang-desa.sejarah.update') }}"
        class="bg-white border border-slate-200 rounded-2xl p-6 space-y-4 shadow-sm">
        @csrf @method('PUT')
        <div>
            <label for="tentang_sejarah" class="form-label">Deskripsi Sejarah Desa <span class="text-red-500">*</span></label>
            <textarea name="tentang_sejarah" id="tentang_sejarah" rows="5" required
                class="form-input resize-y @error('tentang_sejarah') border-red-400 @enderror">{{ $val('tentang_sejarah') }}</textarea>
            @error('tentang_sejarah')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror
            <p class="text-[11px] text-slate-400 mt-1.5">Teks ini tampil di bagian pembuka section "Sejarah Desa".</p>
        </div>
        <div class="flex justify-end pt-3 border-t border-slate-100">
            <button type="submit" class="btn-primary">
                <i data-lucide="save" class="w-4 h-4"></i> Simpan Sejarah
            </button>
        </div>
    </form>
    {{-- Daftar Timeline --}}
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <p class="text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center gap-2">
                <i data-lucide="git-commit-vertical" class="w-4 h-4 text-forest-600"></i>
                Daftar Timeline Sejarah
            </p>
            <button type="button" onclick="document.getElementById('form-timeline').classList.toggle('hidden')" class="btn-primary !py-2 !px-3.5 text-xs">
                <i data-lucide="plus" class="w-3.5 h-3.5"></i> Tambah Timeline
            </button>
        </div>

        {{-- Form Tambah Timeline (Collapsible) --}}
        <div id="form-timeline" class="hidden p-6 bg-slate-50/60 border-b border-slate-100">
            <form method="POST" action="{{ route('admin.tentang-desa.timeline.store') }}" class="space-y-4">
                @csrf
                <div class="flex items-center justify-between">
                    <p class="text-xs font-bold text-slate-700 uppercase tracking-wider">Tambah Timeline Baru</p>
                    <button type="button" onclick="document.getElementById('form-timeline').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
                <div class="grid sm:grid-cols-3 gap-4">
                    <div>
                        <label class="form-label">Tahun / Periode <span class="text-red-500">*</span></label>
                        <input type="text" name="tahun" class="form-input" placeholder="cth: 2007" required>
                        @error('tahun')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="form-label">Judul Tonggak <span class="text-red-500">*</span></label>
                        <input type="text" name="judul" class="form-input" placeholder="cth: Pemekaran Wilayah Kecamatan" required>
                        @error('judul')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div>
                    <label class="form-label">Deskripsi <span class="text-red-500">*</span></label>
                    <textarea name="deskripsi" rows="3" class="form-input resize-y"
                        placeholder="Penjelasan singkat peristiwa pada tahun tersebut..." required></textarea>
                    @error('deskripsi')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
                    <p class="text-[11px] text-slate-400 mt-1">Boleh menggunakan tag inline aman: &lt;strong&gt;, &lt;b&gt;, &lt;em&gt;, &lt;i&gt;, &lt;br&gt;.</p>
                </div>
                <div class="grid sm:grid-cols-3 gap-4">
                    <div>
                        <label class="form-label">Ikon <span class="text-slate-400 normal-case font-normal">(opsional)</span></label>
                        <input type="text" name="ikon" class="form-input" placeholder="sprout">
                        @error('ikon')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label">Warna <span class="text-slate-400 normal-case font-normal">(opsional)</span></label>
                        <select name="warna" class="form-input">
                            @foreach(\App\Models\TentangTimelineModel::$palettes as $name => $palette)
                            <option value="{{ $name }}">{{ ucfirst($name) }}</option>
                            @endforeach
                        </select>
                        @error('warna')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label">Urutan Tampil</label>
                        <input type="number" name="urutan" value="{{ $nextTimelineUrutan }}" min="1" class="form-input">
                        @error('urutan')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button" onclick="document.getElementById('form-timeline').classList.add('hidden')" class="btn-secondary">Batal</button>
                    <button type="submit" class="btn-primary"><i data-lucide="plus" class="w-4 h-4"></i> Simpan Timeline</button>
                </div>
            </form>
        </div>
        @if($timelineList->isEmpty())
        <div class="flex flex-col items-center justify-center py-14 text-slate-400">
            <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center mb-3">
                <i data-lucide="git-commit-vertical" class="w-7 h-7"></i>
            </div>
            <p class="text-sm font-semibold text-slate-600">Belum Ada Timeline</p>
            <p class="text-xs text-slate-400 mt-1">Klik "Tambah Timeline" untuk memasukkan tonggak sejarah desa.</p>
        </div>
        @else
        <div class="divide-y divide-slate-100">
            @foreach($timelineList as $item)
            <div class="flex items-start gap-4 px-6 py-4 hover:bg-slate-50 transition-colors group"
                 data-timeline-row="{{ $item->tentang_timeline_id }}"
                 data-action="{{ route('admin.tentang-desa.timeline.update', $item->tentang_timeline_id) }}"
                 data-tahun="{{ $item->tahun }}" data-judul="{{ $item->judul }}"
                 data-deskripsi="{{ $item->deskripsi }}" data-ikon="{{ $item->ikon }}"
                 data-warna="{{ $item->warna }}" data-urutan="{{ $item->urutan }}">
                <div class="w-9 h-9 rounded-lg {{ $item->palette_classes['dot'] }} flex items-center justify-center {{ $item->palette_classes['icon'] }} flex-shrink-0">
                    <i data-lucide="{{ $item->ikon ?: 'circle' }}" class="w-4 h-4"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="text-[11px] font-bold font-mono {{ $item->palette_classes['badge'] }} bg-slate-100 px-2 py-0.5 rounded-md">{{ $item->tahun }}</span>
                        <span class="text-[11px] text-slate-400 font-mono">#{{ $item->urutan }}</span>
                    </div>
                    <p class="text-sm font-semibold text-slate-800 mt-1 truncate group-hover:text-slate-900 transition-colors">{{ $item->judul }}</p>
                    <p class="text-xs text-slate-500 mt-0.5 line-clamp-2">{!! $item->deskripsi !!}</p>
                </div>
                <div class="flex items-center gap-1.5 opacity-90 group-hover:opacity-100 transition-opacity flex-shrink-0">
                    <button type="button" onclick="openTimelineModal({{ $item->tentang_timeline_id }})"
                        class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:bg-forest-50 hover:text-forest-700 transition-all" title="Edit Timeline">
                        <i data-lucide="pencil" class="w-4 h-4"></i>
                    </button>
                    <form method="POST" action="{{ route('admin.tentang-desa.timeline.destroy', $item->tentang_timeline_id) }}"
                        onsubmit="return confirm('Hapus timeline {{ addslashes($item->tahun) }} â€” {{ addslashes($item->judul) }}?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:bg-red-50 hover:text-red-500 transition-all" title="Hapus Timeline">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>{{-- /panel-sejarah --}}
{{-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• PANEL: KEPALA DESA â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• --}}
@php
    $kadesFoto = $settings->get('kades_foto')?->value;
    $kadesImg  = $kadesFoto
        ? (str_starts_with($kadesFoto, 'http') ? $kadesFoto : (file_exists(public_path($kadesFoto)) ? asset($kadesFoto) : asset('uploads/img/DESA_JAMBELAER.png')))
        : asset('uploads/img/DESA_JAMBELAER.png');
@endphp
<div id="panel-kades" class="space-y-5 hidden">
    <div class="flex items-center gap-4 p-4 bg-white border border-slate-200 rounded-2xl shadow-sm">
        <div class="w-10 h-10 rounded-xl bg-forest-50 border border-forest-200 flex items-center justify-center text-forest-700 flex-shrink-0">
            <i data-lucide="user-check" class="w-5 h-5"></i>
        </div>
        <div>
            <h2 class="font-display font-bold text-slate-900 text-sm">Data Kepala Desa</h2>
            <p class="text-xs text-slate-400 mt-0.5">Nama, jabatan, dan foto Kepala Desa yang tampil pada section sambutan</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.tentang-desa.kades.update') }}" enctype="multipart/form-data"
        class="bg-white border border-slate-200 rounded-2xl p-6 space-y-5 shadow-sm">
        @csrf @method('PUT')

        <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-200">
            <img id="kades-foto-preview" src="{{ $kadesImg }}" alt="Foto Kepala Desa"
                class="w-20 h-24 object-cover rounded-xl border border-slate-300 shadow-sm flex-shrink-0">
            <div class="flex-1 min-w-0 space-y-1.5">
                <label class="block text-xs font-semibold text-slate-700">Upload Foto Baru</label>
                <input type="file" name="kades_foto_file" accept="image/*"
                    class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-forest-50 file:text-forest-700 hover:file:bg-forest-100 transition-all"
                    onchange="if(this.files[0]){ document.getElementById('kades-foto-preview').src = URL.createObjectURL(this.files[0]); }">
                <p class="text-[11px] text-slate-400">Format: JPG, PNG, WEBP. Maks 2MB. Kosongkan jika tidak ingin mengganti foto.</p>
                @error('kades_foto_file')<p class="text-xs text-rose-500">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label for="kades_nama" class="form-label">Nama Lengkap &amp; Gelar <span class="text-red-500">*</span></label>
                <input type="text" name="kades_nama" id="kades_nama" value="{{ $val('kades_nama') }}" required
                    class="form-input @error('kades_nama') border-red-400 @enderror" placeholder="cth: Ahmad Fauzi, S.Pd.">
                @error('kades_nama')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="kades_jabatan" class="form-label">Jabatan <span class="text-red-500">*</span></label>
                <input type="text" name="kades_jabatan" id="kades_jabatan" value="{{ $val('kades_jabatan') }}" required
                    class="form-input @error('kades_jabatan') border-red-400 @enderror" placeholder="cth: Kepala Desa Jambelaer">
                @error('kades_jabatan')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="flex justify-end pt-3 border-t border-slate-100">
            <button type="submit" class="btn-primary">
                <i data-lucide="save" class="w-4 h-4"></i> Simpan Data Kepala Desa
            </button>
        </div>
    </form>
</div>{{-- /panel-kades --}}
{{-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• PANEL: SAMBUTAN â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• --}}
<div id="panel-sambutan" class="space-y-5 hidden">
    <div class="flex items-center gap-4 p-4 bg-white border border-slate-200 rounded-2xl shadow-sm">
        <div class="w-10 h-10 rounded-xl bg-forest-50 border border-forest-200 flex items-center justify-center text-forest-700 flex-shrink-0">
            <i data-lucide="quote" class="w-5 h-5"></i>
        </div>
        <div>
            <h2 class="font-display font-bold text-slate-900 text-sm">Sambutan Kepala Desa</h2>
            <p class="text-xs text-slate-400 mt-0.5">Judul, kutipan pembuka, isi paragraf, dan tagline penutup sambutan</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.tentang-desa.sambutan.update') }}"
        class="bg-white border border-slate-200 rounded-2xl p-6 space-y-5 shadow-sm">
        @csrf @method('PUT')

        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label for="sambutan_judul" class="form-label">Judul Sambutan <span class="text-red-500">*</span></label>
                <input type="text" name="sambutan_judul" id="sambutan_judul" value="{{ $val('sambutan_judul') }}" required
                    class="form-input @error('sambutan_judul') border-red-400 @enderror" placeholder="cth: Sambutan Kepala Desa">
                @error('sambutan_judul')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="sambutan_tagline" class="form-label">Tagline Penutup <span class="text-slate-400 normal-case font-normal">(opsional)</span></label>
                <input type="text" name="sambutan_tagline" id="sambutan_tagline" value="{{ $val('sambutan_tagline') }}"
                    class="form-input @error('sambutan_tagline') border-red-400 @enderror" placeholder="cth: Hormat Kami, Kepala Desa Jambelaer">
                @error('sambutan_tagline')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror
            </div>
        </div>

        <div>
            <label for="sambutan_quote" class="form-label">Kutipan Pembuka <span class="text-slate-400 normal-case font-normal">(opsional)</span></label>
            <textarea name="sambutan_quote" id="sambutan_quote" rows="2"
                class="form-input resize-y @error('sambutan_quote') border-red-400 @enderror" placeholder="Kutipan ringkas pembuka sambutan...">{{ $val('sambutan_quote') }}</textarea>
            @error('sambutan_quote')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="sambutan_teks" class="form-label">Isi Sambutan <span class="text-red-500">*</span></label>
            <textarea name="sambutan_teks" id="sambutan_teks" rows="7" required
                class="form-input resize-y leading-relaxed @error('sambutan_teks') border-red-400 @enderror" placeholder="Isi paragraf lengkap sambutan kepala desa...">{{ $val('sambutan_teks') }}</textarea>
            @error('sambutan_teks')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror
            <p class="text-[11px] text-slate-400 mt-1.5">Gunakan baris baru (Enter) untuk memisahkan antar paragraf.</p>
        </div>

        <div class="flex justify-end pt-3 border-t border-slate-100">
            <button type="submit" class="btn-primary">
                <i data-lucide="save" class="w-4 h-4"></i> Simpan Sambutan
            </button>
        </div>
    </form>
</div>{{-- /panel-sambutan --}}
{{-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• PANEL: WILAYAH â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• --}}
<div id="panel-wilayah" class="space-y-5 hidden">
    <div class="flex items-center gap-4 p-4 bg-white border border-slate-200 rounded-2xl shadow-sm">
        <div class="w-10 h-10 rounded-xl bg-forest-50 border border-forest-200 flex items-center justify-center text-forest-700 flex-shrink-0">
            <i data-lucide="map" class="w-5 h-5"></i>
        </div>
        <div>
            <h2 class="font-display font-bold text-slate-900 text-sm">Profil Wilayah Desa</h2>
            <p class="text-xs text-slate-400 mt-0.5">Letak geografis, batas wilayah, dan total luas wilayah desa</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.tentang-desa.wilayah.update') }}"
        class="bg-white border border-slate-200 rounded-2xl p-6 space-y-5 shadow-sm">
        @csrf @method('PUT')

        <div>
            <label for="tentang_letak" class="form-label">Deskripsi Letak Geografis <span class="text-red-500">*</span></label>
            <textarea name="tentang_letak" id="tentang_letak" rows="4" required
                class="form-input resize-y @error('tentang_letak') border-red-400 @enderror">{{ $val('tentang_letak') }}</textarea>
            @error('tentang_letak')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror
        </div>

        <div>
            <p class="form-label mb-3">Batas Wilayah <span class="text-red-500">*</span></p>
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label for="tentang_batas_utara" class="form-label">Batas Utara</label>
                    <input type="text" name="tentang_batas_utara" id="tentang_batas_utara" value="{{ $val('tentang_batas_utara') }}" required
                        class="form-input @error('tentang_batas_utara') border-red-400 @enderror" placeholder="cth: Desa Cisampih">
                    @error('tentang_batas_utara')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="tentang_batas_timur" class="form-label">Batas Timur</label>
                    <input type="text" name="tentang_batas_timur" id="tentang_batas_timur" value="{{ $val('tentang_batas_timur') }}" required
                        class="form-input @error('tentang_batas_timur') border-red-400 @enderror" placeholder="cth: Kelurahan Parung">
                    @error('tentang_batas_timur')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="tentang_batas_selatan" class="form-label">Batas Selatan</label>
                    <input type="text" name="tentang_batas_selatan" id="tentang_batas_selatan" value="{{ $val('tentang_batas_selatan') }}" required
                        class="form-input @error('tentang_batas_selatan') border-red-400 @enderror" placeholder="cth: Desa Curug Agung">
                    @error('tentang_batas_selatan')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="tentang_batas_barat" class="form-label">Batas Barat</label>
                    <input type="text" name="tentang_batas_barat" id="tentang_batas_barat" value="{{ $val('tentang_batas_barat') }}" required
                        class="form-input @error('tentang_batas_barat') border-red-400 @enderror" placeholder="cth: Desa Tanggulun Timur">
                    @error('tentang_batas_barat')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        <div class="sm:w-1/2">
            <label for="tentang_luas" class="form-label">Total Luas Wilayah <span class="text-red-500">*</span></label>
            <input type="text" name="tentang_luas" id="tentang_luas" value="{{ $val('tentang_luas') }}" required
                class="form-input @error('tentang_luas') border-red-400 @enderror" placeholder="cth: 2.500,366 Ha">
            @error('tentang_luas')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror
        </div>

        <div class="flex justify-end pt-3 border-t border-slate-100">
            <button type="submit" class="btn-primary">
                <i data-lucide="save" class="w-4 h-4"></i> Simpan Profil Wilayah
            </button>
        </div>
    </form>
</div>{{-- /panel-wilayah --}}
{{-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• PANEL: POTENSI â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• --}}
<div id="panel-potensi" class="space-y-5 hidden">
    <div class="flex items-center gap-4 p-4 bg-white border border-slate-200 rounded-2xl shadow-sm">
        <div class="w-10 h-10 rounded-xl bg-forest-50 border border-forest-200 flex items-center justify-center text-forest-700 flex-shrink-0">
            <i data-lucide="sprout" class="w-5 h-5"></i>
        </div>
        <div>
            <h2 class="font-display font-bold text-slate-900 text-sm">Potensi Utama Desa</h2>
            <p class="text-xs text-slate-400 mt-0.5">Kartu "Potensi Utama" pada halaman Tentang Desa</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.tentang-desa.potensi.update') }}"
        class="bg-white border border-slate-200 rounded-2xl p-6 space-y-5 shadow-sm">
        @csrf @method('PUT')
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label for="tentang_potensi_judul" class="form-label">Judul Kartu <span class="text-red-500">*</span></label>
                <input type="text" name="tentang_potensi_judul" id="tentang_potensi_judul" value="{{ $val('tentang_potensi_judul') }}" required
                    class="form-input @error('tentang_potensi_judul') border-red-400 @enderror" placeholder="cth: Potensi Utama">
                @error('tentang_potensi_judul')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="tentang_potensi_subjudul" class="form-label">Subjudul Kartu <span class="text-slate-400 normal-case font-normal">(opsional)</span></label>
                <input type="text" name="tentang_potensi_subjudul" id="tentang_potensi_subjudul" value="{{ $val('tentang_potensi_subjudul') }}"
                    class="form-input @error('tentang_potensi_subjudul') border-red-400 @enderror" placeholder="cth: Sumber Daya & Ekonomi">
                @error('tentang_potensi_subjudul')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror
            </div>
        </div>
        <div>
            <label for="tentang_potensi_deskripsi" class="form-label">Deskripsi Kartu <span class="text-red-500">*</span></label>
            <textarea name="tentang_potensi_deskripsi" id="tentang_potensi_deskripsi" rows="6" required
                class="form-input resize-y @error('tentang_potensi_deskripsi') border-red-400 @enderror">{{ $val('tentang_potensi_deskripsi') }}</textarea>
            @error('tentang_potensi_deskripsi')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror
        </div>
        <div class="flex justify-end pt-3 border-t border-slate-100">
            <button type="submit" class="btn-primary"><i data-lucide="save" class="w-4 h-4"></i> Simpan Potensi</button>
        </div>
    </form>
</div>{{-- /panel-potensi --}}

{{-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• PANEL: ADMINISTRASI â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• --}}
<div id="panel-administrasi" class="space-y-5 hidden">
    <div class="flex items-center gap-4 p-4 bg-white border border-slate-200 rounded-2xl shadow-sm">
        <div class="w-10 h-10 rounded-xl bg-forest-50 border border-forest-200 flex items-center justify-center text-forest-700 flex-shrink-0">
            <i data-lucide="building-2" class="w-5 h-5"></i>
        </div>
        <div>
            <h2 class="font-display font-bold text-slate-900 text-sm">Administrasi Desa</h2>
            <p class="text-xs text-slate-400 mt-0.5">Kartu "Administrasi Desa" pada halaman Tentang Desa</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.tentang-desa.administrasi.update') }}"
        class="bg-white border border-slate-200 rounded-2xl p-6 space-y-5 shadow-sm">
        @csrf @method('PUT')
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label for="tentang_administrasi_judul" class="form-label">Judul Kartu <span class="text-red-500">*</span></label>
                <input type="text" name="tentang_administrasi_judul" id="tentang_administrasi_judul" value="{{ $val('tentang_administrasi_judul') }}" required
                    class="form-input @error('tentang_administrasi_judul') border-red-400 @enderror" placeholder="cth: Administrasi Desa">
                @error('tentang_administrasi_judul')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="tentang_administrasi_subjudul" class="form-label">Subjudul Kartu <span class="text-slate-400 normal-case font-normal">(opsional)</span></label>
                <input type="text" name="tentang_administrasi_subjudul" id="tentang_administrasi_subjudul" value="{{ $val('tentang_administrasi_subjudul') }}"
                    class="form-input @error('tentang_administrasi_subjudul') border-red-400 @enderror" placeholder="cth: Struktur & Wilayah">
                @error('tentang_administrasi_subjudul')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror
            </div>
        </div>
        <div>
            <label for="tentang_administrasi_deskripsi" class="form-label">Deskripsi Kartu <span class="text-red-500">*</span></label>
            <textarea name="tentang_administrasi_deskripsi" id="tentang_administrasi_deskripsi" rows="6" required
                class="form-input resize-y @error('tentang_administrasi_deskripsi') border-red-400 @enderror">{{ $val('tentang_administrasi_deskripsi') }}</textarea>
            @error('tentang_administrasi_deskripsi')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror
        </div>
        <div class="flex justify-end pt-3 border-t border-slate-100">
            <button type="submit" class="btn-primary"><i data-lucide="save" class="w-4 h-4"></i> Simpan Administrasi</button>
        </div>
    </form>
</div>{{-- /panel-administrasi --}}
{{-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• PANEL: VISI & MISI â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• --}}
<div id="panel-visi-misi" class="space-y-5 hidden">
    <div class="flex items-center gap-4 p-4 bg-white border border-slate-200 rounded-2xl shadow-sm">
        <div class="w-10 h-10 rounded-xl bg-forest-50 border border-forest-200 flex items-center justify-center text-forest-700 flex-shrink-0">
            <i data-lucide="target" class="w-5 h-5"></i>
        </div>
        <div>
            <h2 class="font-display font-bold text-slate-900 text-sm">Visi &amp; Misi Desa</h2>
            <p class="text-xs text-slate-400 mt-0.5">Pernyataan visi dan daftar poin misi pembangunan desa</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.tentang-desa.visi.update') }}"
        class="bg-white border border-slate-200 rounded-2xl p-6 space-y-5 shadow-sm">
        @csrf @method('PUT')
        <div>
            <label for="tentang_visi" class="form-label">Visi Desa <span class="text-red-500">*</span></label>
            <textarea name="tentang_visi" id="tentang_visi" rows="4" required
                class="form-input resize-y @error('tentang_visi') border-red-400 @enderror">{{ $val('tentang_visi') }}</textarea>
            @error('tentang_visi')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="tentang_visi_deskripsi" class="form-label">Deskripsi Visi <span class="text-slate-400 normal-case font-normal">(opsional)</span></label>
            <textarea name="tentang_visi_deskripsi" id="tentang_visi_deskripsi" rows="3"
                class="form-input resize-y @error('tentang_visi_deskripsi') border-red-400 @enderror">{{ $val('tentang_visi_deskripsi') }}</textarea>
            @error('tentang_visi_deskripsi')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror
        </div>
        <div class="flex justify-end pt-3 border-t border-slate-100">
            <button type="submit" class="btn-primary"><i data-lucide="save" class="w-4 h-4"></i> Simpan Visi</button>
        </div>
    </form>

    {{-- Daftar Misi --}}
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <p class="text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center gap-2">
                <i data-lucide="list-checks" class="w-4 h-4 text-forest-600"></i>
                Daftar Misi Desa
            </p>
            <button type="button" onclick="document.getElementById('form-misi').classList.toggle('hidden')" class="btn-primary !py-2 !px-3.5 text-xs">
                <i data-lucide="plus" class="w-3.5 h-3.5"></i> Tambah Misi
            </button>
        </div>

        {{-- Form Tambah Misi (Collapsible) --}}
        <div id="form-misi" class="hidden p-6 bg-slate-50/60 border-b border-slate-100">
            <form method="POST" action="{{ route('admin.tentang-desa.misi.store') }}" class="space-y-4">
                @csrf
                <div class="flex items-center justify-between">
                    <p class="text-xs font-bold text-slate-700 uppercase tracking-wider">Tambah Misi Baru</p>
                    <button type="button" onclick="document.getElementById('form-misi').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
                <div>
                    <label class="form-label">Isi Misi <span class="text-red-500">*</span></label>
                    <textarea name="isi" rows="3" class="form-input resize-y @error('isi') border-red-400 @enderror"
                        placeholder="cth: Meningkatkan kualitas pelayanan publik yang prima dan transparan" required></textarea>
                    @error('isi')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="sm:w-1/3">
                    <label class="form-label">Urutan Tampil</label>
                    <input type="number" name="urutan" value="{{ $nextMisiUrutan }}" min="1" class="form-input @error('urutan') border-red-400 @enderror">
                    @error('urutan')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button" onclick="document.getElementById('form-misi').classList.add('hidden')" class="btn-secondary">Batal</button>
                    <button type="submit" class="btn-primary"><i data-lucide="plus" class="w-4 h-4"></i> Simpan Misi</button>
                </div>
            </form>
        </div>
        @if($misiList->isEmpty())
        <div class="flex flex-col items-center justify-center py-14 text-slate-400">
            <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center mb-3">
                <i data-lucide="list-checks" class="w-7 h-7"></i>
            </div>
            <p class="text-sm font-semibold text-slate-600">Belum Ada Misi</p>
            <p class="text-xs text-slate-400 mt-1">Klik "Tambah Misi" untuk memasukkan poin misi pembangunan desa.</p>
        </div>
        @else
        <div class="divide-y divide-slate-100">
            @foreach($misiList as $misi)
            <div class="flex items-start gap-4 px-6 py-4 hover:bg-slate-50 transition-colors group"
                 data-misi-row="{{ $misi->tentang_misi_id }}"
                 data-action="{{ route('admin.tentang-desa.misi.update', $misi->tentang_misi_id) }}"
                 data-isi="{{ $misi->isi }}" data-urutan="{{ $misi->urutan }}">
                <div class="w-7 h-7 rounded-lg bg-forest-100 border border-forest-200 flex items-center justify-center text-forest-700 text-xs font-bold font-mono flex-shrink-0">
                    {{ $misi->urutan }}
                </div>
                <p class="flex-1 min-w-0 text-sm text-slate-700 leading-relaxed">{{ $misi->isi }}</p>
                <div class="flex items-center gap-1.5 opacity-90 group-hover:opacity-100 transition-opacity flex-shrink-0">
                    <button type="button" onclick="openMisiModal({{ $misi->tentang_misi_id }})"
                        class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:bg-forest-50 hover:text-forest-700 transition-all" title="Edit Misi">
                        <i data-lucide="pencil" class="w-4 h-4"></i>
                    </button>
                    <form method="POST" action="{{ route('admin.tentang-desa.misi.destroy', $misi->tentang_misi_id) }}"
                        onsubmit="return confirm('Hapus misi nomor {{ $misi->urutan }} ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:bg-red-50 hover:text-red-500 transition-all" title="Hapus Misi">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>{{-- /panel-visi-misi --}}
{{-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• PANEL: PETA LOKASI â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• --}}
<div id="panel-peta" class="space-y-5 hidden">
    <div class="flex items-center gap-4 p-4 bg-white border border-slate-200 rounded-2xl shadow-sm">
        <div class="w-10 h-10 rounded-xl bg-forest-50 border border-forest-200 flex items-center justify-center text-forest-700 flex-shrink-0">
            <i data-lucide="map-pin" class="w-5 h-5"></i>
        </div>
        <div>
            <h2 class="font-display font-bold text-slate-900 text-sm">Peta Lokasi &amp; Alamat</h2>
            <p class="text-xs text-slate-400 mt-0.5">Embed Google Maps, alamat kantor desa, dan link peta eksternal</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.tentang-desa.peta.update') }}"
        class="bg-white border border-slate-200 rounded-2xl p-6 space-y-5 shadow-sm">
        @csrf @method('PUT')

        <div>
            <label for="maps_embed_url" class="form-label">Embed Google Maps (iframe) <span class="text-slate-400 normal-case font-normal">(opsional)</span></label>
            <textarea name="maps_embed_url" id="maps_embed_url" rows="4"
                class="form-input resize-y font-mono text-xs @error('maps_embed_url') border-red-400 @enderror"
                placeholder="Tempelkan kode iframe dari Google Maps (Share â†’ Embed a map â†’ Copy HTML)...">{{ $val('maps_embed_url') }}</textarea>
            @error('maps_embed_url')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror
            <p class="text-[11px] text-slate-400 mt-1.5">Hanya tag &lt;iframe&gt; dari Google Maps yang diizinkan; atribut selain src/srcwidth/height otomatis dihapus.</p>
        </div>

        @if($val('maps_embed_url'))
        <div>
            <p class="form-label mb-2">Pratinjau Embed Saat Ini</p>
            <div class="rounded-2xl overflow-hidden border border-slate-200">
                {!! \App\Helpers\SecurityHelper::sanitizeMapsIframe($val('maps_embed_url')) !!}
            </div>
        </div>
        @endif

        <div>
            <label for="tentang_alamat" class="form-label">Alamat Kantor Desa <span class="text-red-500">*</span></label>
            <textarea name="tentang_alamat" id="tentang_alamat" rows="3" required
                class="form-input resize-y @error('tentang_alamat') border-red-400 @enderror">{{ $val('tentang_alamat') }}</textarea>
            @error('tentang_alamat')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="tentang_maps_link" class="form-label">Link Google Maps (Tombol Buka Peta) <span class="text-slate-400 normal-case font-normal">(opsional)</span></label>
            <input type="url" name="tentang_maps_link" id="tentang_maps_link" value="{{ $val('tentang_maps_link') }}"
                class="form-input @error('tentang_maps_link') border-red-400 @enderror" placeholder="https://maps.google.com/?q=Kantor+Desa+Jambelaer">
            @error('tentang_maps_link')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror
        </div>

        <div class="flex justify-end pt-3 border-t border-slate-100">
            <button type="submit" class="btn-primary"><i data-lucide="save" class="w-4 h-4"></i> Simpan Peta &amp; Alamat</button>
        </div>
    </form>
</div>{{-- /panel-peta --}}

{{-- â”€â”€ Modal Edit Timeline â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ --}}
<div id="edit-timeline-modal" class="hidden fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl p-6 my-8">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
            <p class="text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center gap-2">
                <i data-lucide="pencil" class="w-4 h-4 text-forest-600"></i> Edit Timeline
            </p>
            <button type="button" onclick="closeTimelineModal()" class="text-slate-400 hover:text-slate-600">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
        <form id="edit-timeline-form" method="POST" action="" class="space-y-4">
            @csrf @method('PUT')
            <div class="grid sm:grid-cols-3 gap-4">
                <div>
                    <label class="form-label">Tahun / Periode <span class="text-red-500">*</span></label>
                    <input type="text" name="tahun" id="tl-tahun" class="form-input" required>
                </div>
                <div class="sm:col-span-2">
                    <label class="form-label">Judul Tonggak <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" id="tl-judul" class="form-input" required>
                </div>
            </div>
            <div>
                <label class="form-label">Deskripsi <span class="text-red-500">*</span></label>
                <textarea name="deskripsi" id="tl-deskripsi" rows="3" class="form-input resize-y" required></textarea>
            </div>
            <div class="grid sm:grid-cols-3 gap-4">
                <div>
                    <label class="form-label">Ikon <span class="text-slate-400 normal-case font-normal">(opsional)</span></label>
                    <input type="text" name="ikon" id="tl-ikon" class="form-input" placeholder="sprout">
                </div>
                <div>
                    <label class="form-label">Warna</label>
                    <select name="warna" id="tl-warna" class="form-input">
                        @foreach(\App\Models\TentangTimelineModel::$palettes as $name => $palette)
                        <option value="{{ $name }}">{{ ucfirst($name) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Urutan Tampil</label>
                    <input type="number" name="urutan" id="tl-urutan" min="1" class="form-input">
                </div>
            </div>
            <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeTimelineModal()" class="btn-secondary">Batal</button>
                <button type="submit" class="btn-primary"><i data-lucide="save" class="w-4 h-4"></i> Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

{{-- â”€â”€ Modal Edit Misi â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ --}}
<div id="edit-misi-modal" class="hidden fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl p-6 my-8">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
            <p class="text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center gap-2">
                <i data-lucide="pencil" class="w-4 h-4 text-forest-600"></i> Edit Misi
            </p>
            <button type="button" onclick="closeMisiModal()" class="text-slate-400 hover:text-slate-600">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
        <form id="edit-misi-form" method="POST" action="" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="form-label">Isi Misi <span class="text-red-500">*</span></label>
                <textarea name="isi" id="misi-isi" rows="4" class="form-input resize-y" required></textarea>
            </div>
            <div class="sm:w-1/3">
                <label class="form-label">Urutan Tampil</label>
                <input type="number" name="urutan" id="misi-urutan" min="1" class="form-input">
            </div>
            <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeMisiModal()" class="btn-secondary">Batal</button>
                <button type="submit" class="btn-primary"><i data-lucide="save" class="w-4 h-4"></i> Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@endsection
@push('scripts')
<script>
const tentangTabs = @json(array_keys($tabs));

function switchTab(name) {
    tentangTabs.forEach(t => {
        const panel = document.getElementById('panel-' + t);
        const btn   = document.getElementById('tab-' + t);
        if (!panel || !btn) return;
        if (t === name) {
            panel.classList.remove('hidden');
            btn.classList.add('bg-forest-700', 'text-white', 'shadow-sm');
            btn.classList.remove('text-slate-500', 'hover:bg-slate-100', 'hover:text-slate-800');
        } else {
            panel.classList.add('hidden');
            btn.classList.remove('bg-forest-700', 'text-white', 'shadow-sm');
            btn.classList.add('text-slate-500', 'hover:bg-slate-100', 'hover:text-slate-800');
        }
    });
    localStorage.setItem('tentang_desa_active_tab', name);
    lucide.createIcons();
}

document.addEventListener('DOMContentLoaded', function () {
    @if($errorTab)
    switchTab('{{ $errorTab }}');
    @else
    const saved = localStorage.getItem('tentang_desa_active_tab');
    if (saved && document.getElementById('panel-' + saved)) switchTab(saved);
    @endif
});

{{-- Modal Timeline --}}
function openTimelineModal(id) {
    const row = document.querySelector(`[data-timeline-row="${id}"]`);
    if (!row) return;
    document.getElementById('edit-timeline-form').action = row.dataset.action;
    document.getElementById('tl-tahun').value     = row.dataset.tahun;
    document.getElementById('tl-judul').value     = row.dataset.judul;
    document.getElementById('tl-deskripsi').value = row.dataset.deskripsi;
    document.getElementById('tl-ikon').value      = row.dataset.ikon;
    document.getElementById('tl-urutan').value    = row.dataset.urutan;
    const warna = row.dataset.warna;
    document.querySelectorAll('#tl-warna option').forEach(opt => {
        opt.selected = opt.value === warna;
    });
    const modal = document.getElementById('edit-timeline-modal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    lucide.createIcons();
}

function closeTimelineModal() {
    const modal = document.getElementById('edit-timeline-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

document.getElementById('edit-timeline-modal').addEventListener('click', function (e) {
    if (e.target === this) closeTimelineModal();
});

{{-- Modal Misi --}}
function openMisiModal(id) {
    const row = document.querySelector(`[data-misi-row="${id}"]`);
    if (!row) return;
    document.getElementById('edit-misi-form').action = row.dataset.action;
    document.getElementById('misi-isi').value      = row.dataset.isi;
    document.getElementById('misi-urutan').value   = row.dataset.urutan;
    const modal = document.getElementById('edit-misi-modal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    lucide.createIcons();
}

function closeMisiModal() {
    const modal = document.getElementById('edit-misi-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

document.getElementById('edit-misi-modal').addEventListener('click', function (e) {
    if (e.target === this) closeMisiModal();
});

{{-- Tutup modal dengan tombol Escape --}}
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        closeTimelineModal();
        closeMisiModal();
    }
});
</script>
@endpush













