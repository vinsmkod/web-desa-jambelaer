@extends('admin.layouts.admin')

@section('title', 'Pengaturan')
@section('page_title', 'Pengaturan Desa')
@section('page_subtitle', 'Kelola informasi, kontak, statistik, dan media sosial website')

@section('content')

@php
    $groupMeta = [
        'identitas' => [
            'label' => 'Identitas Desa',
            'desc'  => 'Nama, alamat, dan informasi resmi desa',
            'icon'  => 'map-pin',
            'color' => 'emerald',
        ],
        'kontak' => [
            'label' => 'Kontak & Operasional',
            'desc'  => 'Nomor telepon, email, dan jam layanan',
            'icon'  => 'phone',
            'color' => 'sky',
        ],
        'statistik' => [
            'label' => 'Statistik Desa',
            'desc'  => 'Angka-angka yang tampil di halaman utama',
            'icon'  => 'bar-chart-2',
            'color' => 'violet',
        ],
        'sosmed' => [
            'label' => 'Media Sosial',
            'desc'  => 'URL akun media sosial resmi desa',
            'icon'  => 'share-2',
            'color' => 'amber',
        ],
    ];

    $colorMap = [
        'emerald' => ['icon_bg' => 'bg-emerald-600/20', 'icon_text' => 'text-emerald-400'],
        'sky'     => ['icon_bg' => 'bg-sky-600/20',     'icon_text' => 'text-sky-400'],
        'violet'  => ['icon_bg' => 'bg-violet-600/20',  'icon_text' => 'text-violet-400'],
        'amber'   => ['icon_bg' => 'bg-amber-600/20',   'icon_text' => 'text-amber-400'],
    ];

    // Field icons per key
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
        'sosmed_facebook' => 'facebook',
        'sosmed_instagram'=> 'instagram',
        'sosmed_youtube'  => 'youtube',
        'sosmed_twitter'  => 'twitter',
    ];
@endphp

{{-- ── Tab Navigation ─────────────────────────────────────────────────────── --}}
<div class="flex items-center gap-1 bg-slate-900 border border-slate-800 rounded-2xl p-1.5 mb-6 max-w-3xl">
    @foreach($settings as $group => $items)
    @php $meta = $groupMeta[$group] ?? ['label' => ucfirst($group), 'icon' => 'settings', 'color' => 'emerald']; @endphp
    <button onclick="switchTab('{{ $group }}')" id="tab-{{ $group }}"
        class="peng-tab flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200
               {{ $loop->first ? 'bg-emerald-600 text-white shadow' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
        <i data-lucide="{{ $meta['icon'] }}" class="w-4 h-4 flex-shrink-0"></i>
        <span class="hidden sm:inline">{{ $meta['label'] }}</span>
    </button>
    @endforeach
</div>

<form method="POST" action="{{ route('admin.pengaturan.update') }}" class="max-w-3xl" id="pengaturan-form">
    @csrf @method('PUT')

    @foreach($settings as $group => $items)
    @php
        $meta  = $groupMeta[$group] ?? ['label' => ucfirst($group), 'icon' => 'settings', 'color' => 'emerald', 'desc' => ''];
        $color = $colorMap[$meta['color']] ?? $colorMap['emerald'];
    @endphp

    <div id="panel-{{ $group }}" class="space-y-5 {{ $loop->first ? '' : 'hidden' }}">

        {{-- Panel Header Card --}}
        <div class="flex items-center gap-4 p-4 bg-slate-900 border border-slate-800 rounded-2xl">
            <div class="w-10 h-10 rounded-xl {{ $color['icon_bg'] }} flex items-center justify-center {{ $color['icon_text'] }} flex-shrink-0">
                <i data-lucide="{{ $meta['icon'] }}" class="w-5 h-5"></i>
            </div>
            <div>
                <h2 class="font-display font-bold text-white text-sm">{{ $meta['label'] }}</h2>
                <p class="text-xs text-slate-500 mt-0.5">{{ $meta['desc'] }}</p>
            </div>
            <div class="ml-auto">
                <span class="text-xs text-slate-600">{{ $items->count() }} field</span>
            </div>
        </div>

        {{-- Fields --}}
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-5">
            @foreach($items as $item)
            @php $fieldIcon = $fieldIcons[$item->key] ?? 'pencil'; @endphp
            <div class="{{ $item->key === 'desa_alamat' ? '' : '' }}">
                <label class="flex items-center gap-2 mb-2">
                    <div class="w-5 h-5 rounded flex items-center justify-center {{ $color['icon_bg'] }} {{ $color['icon_text'] }} flex-shrink-0">
                        <i data-lucide="{{ $fieldIcon }}" class="w-3 h-3"></i>
                    </div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">{{ $item->label }}</span>
                </label>

                @if($item->key === 'desa_alamat')
                <textarea name="{{ $item->key }}" rows="2"
                          class="form-input resize-none"
                          placeholder="{{ $item->label }}...">{{ $item->value }}</textarea>

                @elseif(in_array($item->key, ['sosmed_facebook', 'sosmed_instagram', 'sosmed_youtube', 'sosmed_twitter']))
                <div class="flex items-center gap-0">
                    <div class="flex-shrink-0 px-3 h-10 flex items-center rounded-l-xl bg-slate-700 border border-slate-700 border-r-0 text-slate-400 text-xs font-mono">
                        https://
                    </div>
                    <input type="text" name="{{ $item->key }}" value="{{ $item->value }}"
                           class="flex-1 px-4 py-2.5 bg-slate-800 border border-slate-700 rounded-r-xl text-sm text-slate-100 placeholder-slate-500 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all"
                           placeholder="{{ str_replace('_', '.', str_replace('sosmed_', '', $item->key)) }}.com/namaakun">
                </div>

                @elseif(in_array($item->key, ['stat_luas', 'stat_penduduk', 'stat_umkm']))
                <div class="flex items-center gap-0">
                    <input type="number" name="{{ $item->key }}" value="{{ $item->value }}"
                           class="flex-1 px-4 py-2.5 bg-slate-800 border border-slate-700 rounded-l-xl text-sm text-slate-100 placeholder-slate-500 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all">
                    <div class="flex-shrink-0 px-3 h-10 flex items-center rounded-r-xl bg-slate-700 border border-slate-700 border-l-0 text-slate-400 text-xs">
                        @if($item->key === 'stat_luas') Ha
                        @elseif($item->key === 'stat_penduduk') Jiwa
                        @else UMKM
                        @endif
                    </div>
                </div>

                @elseif($item->key === 'kontak_telp')
                <input type="tel" name="{{ $item->key }}" value="{{ $item->value }}"
                       class="form-input" placeholder="cth: +62-260-123456">

                @elseif($item->key === 'kontak_email')
                <input type="email" name="{{ $item->key }}" value="{{ $item->value }}"
                       class="form-input" placeholder="cth: desa@jambelaer.id">

                @else
                <input type="text" name="{{ $item->key }}" value="{{ $item->value }}"
                       class="form-input" placeholder="{{ $item->label }}...">
                @endif
            </div>
            @endforeach
        </div>

        {{-- Tombol Simpan per tab --}}
        <div class="flex items-center justify-between pb-2">
            <p class="text-xs text-slate-600">
                <i data-lucide="info" class="w-3 h-3 inline"></i>
                Perubahan disimpan ke seluruh pengaturan sekaligus.
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
            btn.classList.add('bg-emerald-600', 'text-white', 'shadow');
            btn.classList.remove('text-slate-400', 'hover:bg-slate-800', 'hover:text-white');
        } else {
            panel.classList.add('hidden');
            btn.classList.remove('bg-emerald-600', 'text-white', 'shadow');
            btn.classList.add('text-slate-400', 'hover:bg-slate-800', 'hover:text-white');
        }
    });
    localStorage.setItem('pengaturan_active_tab', name);
}

// Restore last active tab on load
const savedPengaturanTab = localStorage.getItem('pengaturan_active_tab');
if (savedPengaturanTab && pengaturanTabs.includes(savedPengaturanTab)) {
    switchTab(savedPengaturanTab);
}
</script>
@endpush
