@extends('admin.layouts.admin')

@section('title', 'Pengaturan')
@section('page_title', 'Pengaturan Desa')
@section('page_subtitle', 'Kelola informasi resmi, kontak, data statistik, dan media sosial Desa Jambelaer')

@section('content')

@php
    $groupMeta = [
        'identitas' => [
            'label' => 'Identitas Desa',
            'desc'  => 'Nama, alamat, dan data administratif resmi desa',
            'icon'  => 'landmark',
            'color' => 'forest',
        ],
        'sambutan' => [
            'label' => 'Sambutan Kades',
            'desc'  => 'Foto, nama, dan isi teks sambutan Kepala Desa',
            'icon'  => 'user-check',
            'color' => 'forest',
        ],
        'kontak' => [
            'label' => 'Kontak & Operasional',
            'desc'  => 'Nomor telepon, email resmi, dan jam pelayanan warga',
            'icon'  => 'phone-call',
            'color' => 'sky',
        ],
        'statistik' => [
            'label' => 'Statistik Desa',
            'desc'  => 'Data demografi dan wilayah yang tampil di halaman utama',
            'icon'  => 'bar-chart-3',
            'color' => 'violet',
        ],
        'sosmed' => [
            'label' => 'Media Sosial',
            'desc'  => 'Tautan ke akun media sosial resmi Pemerintah Desa',
            'icon'  => 'share-2',
            'color' => 'amber',
        ],
        'peta' => [
            'label' => 'Peta Lokasi',
            'desc'  => 'Sematkan (Embed) Google Maps lokasi kantor desa',
            'icon'  => 'map-pin',
            'color' => 'forest',
        ],
    ];

    $colorMap = [
        'forest' => ['icon_bg' => 'bg-forest-50 border border-forest-200', 'icon_text' => 'text-forest-700'],
        'sky'    => ['icon_bg' => 'bg-sky-50 border border-sky-200',       'icon_text' => 'text-sky-600'],
        'violet' => ['icon_bg' => 'bg-violet-50 border border-violet-200', 'icon_text' => 'text-violet-600'],
        'amber'  => ['icon_bg' => 'bg-amber-50 border border-amber-200',   'icon_text' => 'text-amber-600'],
    ];

    $fieldIcons = [
        'desa_nama'       => 'landmark',
        'desa_kecamatan'  => 'map',
        'desa_kabupaten'  => 'map',
        'desa_provinsi'   => 'map',
        'desa_kodepos'    => 'hash',
        'desa_alamat'     => 'map-pin',
        'kontak_telp'     => 'phone',
        'kontak_email'    => 'mail',
        'kontak_jam'      => 'clock',
        'stat_luas'       => 'ruler',
        'stat_penduduk'   => 'users',
        'stat_umkm'       => 'shopping-bag',
        'stat_kk'         => 'home',
        'stat_rtrw'       => 'network',
        'stat_dusun'      => 'map',
        'sosmed_instagram'=> 'instagram',
        'sosmed_youtube'  => 'youtube',
        'sosmed_twitter'  => 'twitter',
        'sosmed_tiktok'   => 'video',
        'maps_embed_url'  => 'map-pin',
        'kades_nama'      => 'user',
        'kades_jabatan'   => 'award',
        'kades_foto'      => 'image',
        'sambutan_judul'  => 'heading',
        'sambutan_quote'  => 'quote',
        'sambutan_teks'   => 'file-text',
        'sambutan_tagline'=> 'sparkles',
    ];
@endphp

{{-- ── Tab Navigation ─────────────────────────────────────────────────────── --}}
<div class="flex items-center gap-1.5 bg-white border border-slate-200 rounded-2xl p-1.5 mb-6 overflow-x-auto shadow-sm">
    @foreach($settings as $group => $items)
    @php $meta = $groupMeta[$group] ?? ['label' => ucfirst($group), 'icon' => 'settings', 'color' => 'forest']; @endphp
    <button type="button" onclick="switchTab('{{ $group }}')" id="tab-{{ $group }}"
        class="peng-tab flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold transition-all duration-200 whitespace-nowrap cursor-pointer
               {{ $loop->first ? 'bg-forest-700 text-white shadow-sm' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-100' }}">
        <i data-lucide="{{ $meta['icon'] }}" class="w-4 h-4 flex-shrink-0"></i>
        <span>{{ $meta['label'] }}</span>
    </button>
    @endforeach
</div>

<form method="POST" action="{{ route('admin.pengaturan.update') }}" enctype="multipart/form-data" id="pengaturan-form">
    @csrf @method('PUT')

    @foreach($settings as $group => $items)
    @php
        $meta  = $groupMeta[$group] ?? ['label' => ucfirst($group), 'icon' => 'settings', 'color' => 'forest', 'desc' => ''];
        $color = $colorMap[$meta['color']] ?? $colorMap['forest'];
    @endphp

    <div id="panel-{{ $group }}" class="space-y-5 {{ $loop->first ? '' : 'hidden' }}">

        {{-- Panel Header Card --}}
        <div class="flex items-center gap-4 p-4 bg-white border border-slate-200 rounded-2xl shadow-sm">
            <div class="w-10 h-10 rounded-xl {{ $color['icon_bg'] }} flex items-center justify-center {{ $color['icon_text'] }} flex-shrink-0">
                <i data-lucide="{{ $meta['icon'] }}" class="w-5 h-5"></i>
            </div>
            <div>
                <h2 class="font-display font-bold text-slate-900 text-sm">{{ $meta['label'] }}</h2>
                <p class="text-xs text-slate-400 mt-0.5">{{ $meta['desc'] }}</p>
            </div>
            <div class="ml-auto">
                <span class="text-xs text-slate-500 bg-slate-100 border border-slate-200 px-2.5 py-1 rounded-lg font-mono font-semibold">{{ $items->count() }} field</span>
            </div>
        </div>

        {{-- Fields Card --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-6 space-y-5 shadow-sm">
            @foreach($items as $item)
            @php $fieldIcon = $fieldIcons[$item->key] ?? 'pencil'; @endphp
            <div>
                <label class="flex items-center gap-2 mb-2">
                    <div class="w-5 h-5 rounded flex items-center justify-center {{ $color['icon_bg'] }} {{ $color['icon_text'] }} flex-shrink-0">
                        <i data-lucide="{{ $fieldIcon }}" class="w-3 h-3"></i>
                    </div>
                    <span class="text-xs font-semibold text-slate-600 uppercase tracking-wider">{{ $item->label }}</span>
                </label>

                @if($item->key === 'kades_foto')
                <div class="space-y-3">
                    <div class="flex items-center gap-4 p-3 bg-slate-50 rounded-xl border border-slate-200">
                        @php
                            $imgSrc = $item->value;
                            if ($imgSrc && !str_starts_with($imgSrc, 'http') && file_exists(public_path($imgSrc))) {
                                $imgSrc = asset($imgSrc);
                            }
                        @endphp
                        <img id="kades-foto-preview" src="{{ $imgSrc ?: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=600&h=600&q=80' }}"
                             alt="Foto Kades" class="w-16 h-20 object-cover rounded-lg border border-slate-300 shadow-sm flex-shrink-0">
                        <div class="flex-1 min-w-0 space-y-1.5">
                            <label class="block text-xs font-semibold text-slate-700">Upload Foto Baru (Komputer/HP)</label>
                            <input type="file" name="kades_foto_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-forest-50 file:text-forest-700 hover:file:bg-forest-100 transition-all"
                                   onchange="if(this.files[0]){ document.getElementById('kades-foto-preview').src = URL.createObjectURL(this.files[0]); }">
                            <p class="text-[11px] text-slate-400">Format: JPG, PNG, WEBP. Maks 2MB.</p>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Atau Gunakan URL Foto Eksternal</label>
                        <input type="text" name="kades_foto" value="{{ $item->value }}" class="form-input text-xs" placeholder="https://...">
                    </div>
                </div>

                @elseif($item->key === 'sambutan_quote')
                <textarea name="{{ $item->key }}" rows="2" class="form-input resize-y" placeholder="Kutipan ringkas pembuka sambutan...">{{ $item->value }}</textarea>

                @elseif($item->key === 'sambutan_teks')
                <textarea name="{{ $item->key }}" rows="6" class="form-input resize-y leading-relaxed" placeholder="Isi paragraf lengkap sambutan kepala desa...">{{ $item->value }}</textarea>
                <p class="text-[11px] text-slate-400 mt-1">Gunakan baris baru (Enter) untuk memisahkan antar paragraf.</p>

                @elseif($item->key === 'desa_alamat')
                <textarea name="{{ $item->key }}" rows="3"
                          class="form-input resize-none"
                          placeholder="{{ $item->label }}...">{{ $item->value }}</textarea>

                @elseif($item->key === 'maps_embed_url')
                <textarea name="{{ $item->key }}" rows="3"
                          class="form-input resize-none font-mono text-xs"
                          placeholder="Sematkan src URL Google Maps...">{{ $item->value }}</textarea>
                <p class="text-[11px] text-slate-400 mt-1.5 flex items-center gap-1">
                    <i data-lucide="info" class="w-3 h-3"></i>
                    Isi dengan atribut <code>src="..."</code> dari kode Embed iFrame Google Maps.
                </p>

                @elseif(in_array($item->key, ['sosmed_instagram', 'sosmed_youtube', 'sosmed_twitter', 'sosmed_tiktok']))
                <div class="relative">
                    <input type="text" name="{{ $item->key }}" value="{{ $item->value }}"
                           class="form-input"
                           placeholder="cth: instagram.com/desa_jambelaer atau 08123456789">
                </div>

                @elseif(in_array($item->key, ['stat_luas', 'stat_penduduk', 'stat_umkm', 'stat_kk', 'stat_rtrw', 'stat_dusun']))
                <div class="flex items-center">
                    <input type="text" name="{{ $item->key }}" value="{{ $item->value }}"
                           class="flex-1 form-input rounded-r-none" placeholder="0">
                    <div class="flex-shrink-0 px-3.5 h-[42px] flex items-center rounded-r-xl bg-slate-100 border border-slate-300 border-l-0 text-slate-600 text-xs font-bold font-mono">
                        @if($item->key === 'stat_luas') Ha
                        @elseif($item->key === 'stat_penduduk') Jiwa
                        @elseif($item->key === 'stat_kk') KK
                        @elseif($item->key === 'stat_rtrw') RT/RW
                        @elseif($item->key === 'stat_dusun') Dusun
                        @else UMKM
                        @endif
                    </div>
                </div>

                @elseif($item->key === 'kontak_telp')
                <input type="tel" name="{{ $item->key }}" value="{{ $item->value }}"
                       class="form-input" placeholder="cth: (0260) 123456">

                @elseif($item->key === 'kontak_email')
                <input type="email" name="{{ $item->key }}" value="{{ $item->value }}"
                       class="form-input" placeholder="cth: desa@jambelaer-subang.desa.id">

                @else
                <input type="text" name="{{ $item->key }}" value="{{ $item->value }}"
                       class="form-input" placeholder="{{ $item->label }}...">
                @endif
            </div>
            @endforeach
        </div>

        {{-- Action Bar --}}
        <div class="flex items-center justify-between pt-1 pb-2">
            <p class="text-xs text-slate-400 flex items-center gap-1.5">
                <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-forest-600"></i>
                Perubahan disimpan secara langsung untuk seluruh tab.
            </p>
            <button type="submit" class="btn-primary">
                <i data-lucide="save" class="w-4 h-4"></i>
                Simpan Pengaturan
            </button>
        </div>

    </div>{{-- /panel --}}
    @endforeach

</form>

@endsection

@push('scripts')
<script>
const pengaturanTabs = @json($settings->keys()->values());

function switchTab(name) {
    pengaturanTabs.forEach(t => {
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
    localStorage.setItem('pengaturan_active_tab', name);
    lucide.createIcons();
}

const savedPengaturanTab = localStorage.getItem('pengaturan_active_tab');
if (savedPengaturanTab && pengaturanTabs.includes(savedPengaturanTab)) {
    switchTab(savedPengaturanTab);
}
</script>
@endpush
