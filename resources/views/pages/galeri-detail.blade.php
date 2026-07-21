@extends('layouts.app')

@section('title', $foto->judul)
@section('meta_desc', Str::limit($foto->deskripsi ?? $foto->judul, 160))

@section('content')
<div class="pt-28 pb-24 bg-gradient-to-b from-white to-ivory">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Breadcrumb --}}
        <nav class="flex items-center flex-wrap gap-1.5 text-xs text-slate-500 mb-8 reveal-on-scroll">
            <a href="{{ route('home') }}" class="hover:text-emerald-800 transition-colors">Home</a>
            <i data-lucide="chevron-right" class="w-3 h-3 flex-shrink-0"></i>
            <a href="{{ route('galeri') }}" class="hover:text-emerald-800 transition-colors">Galeri</a>
            <i data-lucide="chevron-right" class="w-3 h-3 flex-shrink-0"></i>
            <span class="text-emerald-800 font-semibold truncate max-w-xs">{{ $foto->judul }}</span>
        </nav>

        <div class="grid lg:grid-cols-12 gap-10 items-start">
            {{-- ── Left / Main: Photo ── --}}
            <div class="lg:col-span-8 space-y-6 reveal-on-scroll">
                <div class="relative rounded-3xl overflow-hidden shadow-lg border border-slate-100 bg-slate-900">
                    <img src="{{ $foto->foto }}" alt="{{ $foto->judul }}"
                         class="w-full h-auto max-h-[600px] object-contain mx-auto">
                    <span class="absolute top-5 left-5 px-3 py-1.5 rounded-full text-xs font-extrabold tracking-wider uppercase shadow-sm bg-emerald-900/90 text-white backdrop-blur-sm">
                        {{ $foto->kategori_label }}
                    </span>
                </div>

                <div class="bg-white border border-slate-100 rounded-3xl p-6 sm:p-8 shadow-sm space-y-4">
                    <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-100 pb-4">
                        <h1 class="font-display font-extrabold text-2xl sm:text-3xl text-emerald-950">
                            {{ $foto->judul }}
                        </h1>
                        <span class="text-xs font-semibold text-slate-400 flex items-center">
                            <i data-lucide="calendar" class="w-4 h-4 mr-1.5 text-amber-600"></i>
                            {{ $foto->tanggal_publikasi ? $foto->tanggal_publikasi->translatedFormat('d F Y') : $foto->created_at->translatedFormat('d F Y') }}
                        </span>
                    </div>

                    @if($foto->deskripsi)
                    <div>
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Deskripsi</h3>
                        <p class="text-slate-600 text-sm sm:text-base leading-relaxed whitespace-pre-line font-light">
                            {{ $foto->deskripsi }}
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- ── Right: Related Photos ── --}}
            <div class="lg:col-span-4 space-y-6 reveal-on-scroll delay-100">
                <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
                    <h3 class="font-display font-bold text-emerald-950 text-base mb-4 flex items-center">
                        <i data-lucide="image" class="w-4 h-4 mr-2 text-emerald-700"></i>
                        Foto Terkait
                    </h3>

                    @if($lainnya->isNotEmpty())
                    <div class="space-y-3">
                        @foreach($lainnya as $item)
                        <a href="{{ route('galeri.detail', $item->id) }}"
                           class="group flex items-center gap-3 p-2.5 rounded-2xl border border-slate-100 hover:border-emerald-200 hover:bg-emerald-50/50 transition-all">
                            <img src="{{ $item->foto }}" alt="{{ $item->judul }}"
                                 class="w-16 h-16 object-cover rounded-xl flex-shrink-0">
                            <div class="min-w-0 flex-grow">
                                <h4 class="text-xs font-bold text-emerald-950 group-hover:text-emerald-700 truncate">
                                    {{ $item->judul }}
                                </h4>
                                <span class="text-[10px] text-slate-400 block mt-1">
                                    {{ $item->tanggal_publikasi ? $item->tanggal_publikasi->translatedFormat('d M Y') : $item->created_at->translatedFormat('d M Y') }}
                                </span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    @else
                    <p class="text-xs text-slate-400 font-light">Tidak ada foto lain dalam kategori ini.</p>
                    @endif

                    <div class="mt-6 pt-4 border-t border-slate-100">
                        <a href="{{ route('galeri') }}"
                           class="inline-flex items-center text-xs font-bold text-emerald-800 hover:text-emerald-950 transition-colors">
                            <i data-lucide="arrow-left" class="w-4 h-4 mr-1.5"></i>
                            Kembali ke Galeri Desa
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
