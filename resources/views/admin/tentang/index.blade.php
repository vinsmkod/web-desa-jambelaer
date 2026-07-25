@extends('admin.layouts.admin')

@section('title', 'Struktur Organisasi')
@section('page_title', 'Struktur Organisasi Desa')
@section('page_subtitle', 'Kelola daftar pengurus, perangkat, dan struktur organisasi Desa Jambelaer')

@section('content')

<div class="max-w-4xl space-y-6">
    {{-- Header Actions & Counter --}}
    <div class="flex items-center justify-between">
        <p class="text-xs text-slate-500 font-medium">Total {{ $strukturList->total() }} anggota terdaftar · diurutkan otomatis (1, 2, 3...)</p>
        <button onclick="document.getElementById('form-tambah').classList.toggle('hidden')"
            class="btn-primary">
            <i data-lucide="user-plus" class="w-4 h-4"></i>
            Tambah Anggota
        </button>
    </div>

    {{-- Form Tambah (Collapsible) --}}
    <div id="form-tambah" class="hidden bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-2">
            <p class="text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center gap-2">
                <i data-lucide="user-plus" class="w-4 h-4 text-forest-600"></i>
                Tambah Anggota Struktur Baru
            </p>
            <button onclick="document.getElementById('form-tambah').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.struktur.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Nama Lengkap & Gelar</label>
                    <input type="text" name="nama" class="form-input" placeholder="cth: Ahmad Fauzi, S.Pd." required>
                </div>
                <div>
                    <label class="form-label">Jabatan</label>
                    <input type="text" name="jabatan" class="form-input" placeholder="cth: Sekretaris Desa" required>
                </div>
            </div>
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Foto Anggota <span class="text-slate-400 normal-case font-normal">(opsional)</span></label>
                    <input type="file" name="foto" accept="image/*" class="form-input"
                        onchange="previewStrukturImg(event, 'struktur-new-preview')">
                    <div class="mt-2.5 hidden" id="struktur-new-preview-wrap">
                        <img id="struktur-new-preview" class="w-14 h-14 rounded-full object-cover border-2 border-slate-200" src="" alt="Preview">
                    </div>
                </div>
                <div>
                    <label class="form-label">Urutan Tampil</label>
                    <input type="number" name="urutan" value="{{ $nextUrutan }}" min="1" class="form-input" placeholder="{{ $nextUrutan }}">
                    <p class="text-[11px] text-slate-400 mt-1">Otomatis terisi urutan berikutnya. Angka 1 = Kepala Desa.</p>
                </div>
            </div>
            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('form-tambah').classList.add('hidden')"
                    class="btn-secondary">
                    Batal
                </button>
                <button type="submit" class="btn-primary">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Simpan Anggota
                </button>
            </div>
        </form>
    </div>

    {{-- Daftar Anggota Table/List --}}
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
        @if($strukturList->isEmpty())
        <div class="flex flex-col items-center justify-center py-16 text-slate-400">
            <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center mb-3 text-slate-400">
                <i data-lucide="users" class="w-7 h-7"></i>
            </div>
            <p class="text-sm font-semibold text-slate-600">Belum Ada Anggota Struktur</p>
            <p class="text-xs text-slate-400 mt-1">Klik tombol "Tambah Anggota" untuk memasukkan data perangkat desa.</p>
        </div>
        @else
        <div class="divide-y divide-slate-100">
            @foreach($strukturList as $anggota)
            <div class="flex items-center gap-4 px-6 py-4 hover:bg-slate-50 transition-colors group">
                {{-- Urutan badge --}}
                <div class="w-7 h-7 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-600 text-xs font-bold font-mono flex-shrink-0">
                    {{ $anggota->urutan }}
                </div>

                {{-- Foto --}}
                <img src="{{ $anggota->foto ? asset($anggota->foto) : 'https://ui-avatars.com/api/?name='.urlencode($anggota->nama).'&background=1a4731&color=fff&size=80' }}"
                    alt="{{ $anggota->nama }}"
                    class="w-11 h-11 rounded-full object-cover border-2 border-slate-200 flex-shrink-0">

                {{-- Info --}}
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-slate-800 truncate group-hover:text-slate-900 transition-colors">{{ $anggota->nama }}</p>
                    <p class="text-xs text-slate-400 truncate mt-0.5">{{ $anggota->jabatan }}</p>
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-1.5 opacity-90 group-hover:opacity-100 transition-opacity">
                    <button type="button"
                        onclick="openEditModal({{ $anggota->id }}, '{{ addslashes($anggota->nama) }}', '{{ addslashes($anggota->jabatan) }}', {{ $anggota->urutan }}, '{{ $anggota->foto ? asset($anggota->foto) : '' }}')"
                        class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:bg-forest-50 hover:text-forest-700 transition-all"
                        title="Edit Anggota">
                        <i data-lucide="pencil" class="w-4 h-4"></i>
                    </button>
                    <form method="POST" action="{{ route('admin.struktur.destroy', $anggota) }}"
                        onsubmit="return confirm('Hapus {{ addslashes($anggota->nama) }} dari struktur?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:bg-red-50 hover:text-red-500 transition-all"
                            title="Hapus Anggota">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @if($strukturList->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-xs text-slate-500 font-medium">
                Menampilkan <span class="font-bold text-slate-700">{{ $strukturList->firstItem() }}</span>
                – <span class="font-bold text-slate-700">{{ $strukturList->lastItem() }}</span>
                dari <span class="font-bold text-slate-700">{{ $strukturList->total() }}</span> anggota
            </p>

            <div class="flex items-center gap-1.5">
                {{-- Previous Page Link --}}
                @if ($strukturList->onFirstPage())
                    <span class="w-8 h-8 flex items-center justify-center rounded-xl bg-slate-100 text-slate-300 border border-slate-200 cursor-not-allowed font-bold text-sm">
                        &lt;
                    </span>
                @else
                    <a href="{{ $strukturList->previousPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-xl bg-white text-slate-600 border border-slate-200 hover:bg-forest-50 hover:text-forest-700 hover:border-forest-200 transition-all shadow-sm font-bold text-sm">
                        &lt;
                    </a>
                @endif

                {{-- Page Numbers --}}
                @foreach ($strukturList->getUrlRange(1, $strukturList->lastPage()) as $page => $url)
                    @if ($page == $strukturList->currentPage())
                        <span class="w-8 h-8 flex items-center justify-center rounded-xl bg-forest-700 text-white font-bold text-xs shadow-sm border border-forest-800">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="w-8 h-8 flex items-center justify-center rounded-xl bg-white text-slate-600 font-medium text-xs border border-slate-200 hover:bg-forest-50 hover:text-forest-700 hover:border-forest-200 transition-all shadow-sm">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($strukturList->hasMorePages())
                    <a href="{{ $strukturList->nextPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-xl bg-white text-slate-600 border border-slate-200 hover:bg-forest-50 hover:text-forest-700 hover:border-forest-200 transition-all shadow-sm font-bold text-sm">
                        &gt;
                    </a>
                @else
                    <span class="w-8 h-8 flex items-center justify-center rounded-xl bg-slate-100 text-slate-300 border border-slate-200 cursor-not-allowed font-bold text-sm">
                        &gt;
                    </span>
                @endif
            </div>
        </div>
        @endif
        @endif
    </div>

</div>

{{-- ══ Modal Edit Anggota ════════════════════════════════════════════════════ --}}
<div id="edit-struktur-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-sm p-4">
    <div class="bg-white border border-slate-200 rounded-3xl w-full max-w-md shadow-2xl overflow-hidden">
        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-forest-50 border border-forest-200 flex items-center justify-center text-forest-700">
                    <i data-lucide="pencil" class="w-4 h-4"></i>
                </div>
                <h3 class="font-display font-bold text-slate-900 text-sm">Edit Anggota Struktur</h3>
            </div>
            <button onclick="closeEditModal()" class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-700 transition-all">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        {{-- Form --}}
        <form id="edit-struktur-form" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf @method('PUT')

            {{-- Foto preview --}}
            <div class="flex items-center gap-4 p-3.5 bg-slate-50 rounded-2xl border border-slate-200">
                <img id="edit-foto-preview" class="w-14 h-14 rounded-full object-cover border-2 border-slate-300 flex-shrink-0" src="" alt="Preview">
                <div class="flex-1 min-w-0">
                    <label class="form-label">Ganti Foto <span class="text-slate-400 normal-case font-normal">(opsional)</span></label>
                    <input type="file" name="foto" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-forest-50 file:text-forest-700 hover:file:bg-forest-100 transition-all"
                        onchange="previewStrukturImg(event, 'edit-foto-preview')">
                </div>
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div class="col-span-2">
                    <label class="form-label">Nama & Gelar</label>
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

            <div class="flex justify-end gap-2 pt-2 border-t border-slate-100">
                <button type="button" onclick="closeEditModal()" class="btn-secondary">
                    Batal
                </button>
                <button type="submit" class="btn-primary">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function previewStrukturImg(event, targetId) {
        const img = document.getElementById(targetId);
        const wrap = document.getElementById(targetId + '-wrap');
        const file = event.target.files[0];
        if (file) {
            img.src = URL.createObjectURL(file);
            if (wrap) wrap.classList.remove('hidden');
        }
    }

    function openEditModal(id, nama, jabatan, urutan, fotoUrl) {
        const modal = document.getElementById('edit-struktur-modal');
        const form = document.getElementById('edit-struktur-form');
        form.action = `/admin/struktur/${id}`;
        document.getElementById('edit-nama').value = nama;
        document.getElementById('edit-jabatan').value = jabatan;
        document.getElementById('edit-urutan').value = urutan;
        const preview = document.getElementById('edit-foto-preview');
        preview.src = fotoUrl || `https://ui-avatars.com/api/?name=${encodeURIComponent(nama)}&background=1a4731&color=fff&size=160`;
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