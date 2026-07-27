@extends('layouts.app')

@section('title', $berita->judul . ' - Berita Desa Jambelaer')
@section('meta_desc', Str::limit(strip_tags($berita->ringkasan ?: $berita->konten), 160))

@section('content')

<!-- Header Breadcrumb & Banner -->
<section class="pt-32 pb-12 bg-gradient-to-b from-emerald-950 via-emerald-900 to-emerald-950 text-white relative">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-xs text-emerald-300/80 mb-2">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
            <a href="{{ route('berita') }}" class="hover:text-white transition-colors">Berita</a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
            <span class="text-slate-300 truncate max-w-xs">{{ $berita->kategori_label }}</span>
        </nav>

        <!-- Category Badge -->
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-800/80 text-emerald-300 border border-emerald-700/50">
            {{ $berita->kategori_label }}
        </span>

        <!-- Article Title -->
        <h1 class="font-display font-extrabold text-2xl sm:text-4xl text-white leading-tight tracking-tight">
            {{ $berita->judul }}
        </h1>

        <!-- Metadata Bar -->
        <div class="flex flex-wrap items-center gap-4 text-xs text-slate-300 pt-2 border-t border-emerald-800/50">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-full bg-emerald-700 flex items-center justify-center text-white font-bold text-xs">
                    {{ strtoupper(substr($berita->penulis, 0, 2)) }}
                </div>
                <span>{{ $berita->penulis }}</span>
            </div>
            <span>•</span>
            <div class="flex items-center gap-1.5">
                <i data-lucide="calendar" class="w-4 h-4 text-emerald-400"></i>
                <span>{{ $berita->published_at ? $berita->published_at->translatedFormat('d F Y, H:i') : $berita->created_at->translatedFormat('d F Y') }} WIB</span>
            </div>
            <span>•</span>
            <div class="flex items-center gap-1.5">
                <i data-lucide="eye" class="w-4 h-4 text-emerald-400"></i>
                <span>{{ number_format($berita->views) }}x dibaca</span>
            </div>
        </div>
    </div>
</section>

<!-- Article Main Body -->
<section class="py-12 bg-ivory">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

            <!-- Main Content Area -->
            <div class="lg:col-span-8 space-y-8">
                <!-- Main Featured Image -->
                <div class="rounded-3xl overflow-hidden shadow-xl border border-slate-100 bg-slate-100 aspect-video">
                    <img src="{{ $berita->gambar_url }}" alt="{{ $berita->judul }}" class="w-full h-full object-cover">
                </div>

                @if($berita->ringkasan)
                <!-- Excerpt Highlight -->
                <div class="p-6 rounded-2xl bg-emerald-50/70 border-l-4 border-emerald-700 text-slate-700 text-sm font-medium leading-relaxed italic">
                    "{{ $berita->ringkasan }}"
                </div>
                @endif

                <!-- Article Body Paragraphs -->
                <div class="prose prose-emerald max-w-none text-slate-800 text-sm sm:text-base leading-relaxed space-y-5">
                    {!! nl2br(e($berita->konten)) !!}
                </div>

                <!-- Article Footer / Share -->
                <div class="pt-8 border-t border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <a href="{{ route('berita') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-emerald-50 transition-all shadow-sm w-fit">
                        <i data-lucide="arrow-left" class="w-4 h-4 text-emerald-700"></i>
                        Kembali ke Daftar Berita
                    </a>

                    <div class="flex items-center gap-2 text-xs font-medium text-slate-500">
                        <span>Bagikan Berita:</span>
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($berita->judul . ' - ' . url()->current()) }}" target="_blank"
                           class="w-8 h-8 rounded-lg bg-emerald-600 text-white flex items-center justify-center hover:bg-emerald-500 transition-all" title="Bagikan ke WhatsApp">
                            <i data-lucide="share-2" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sidebar (Recent News Recommendations) -->
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white rounded-3xl p-6 shadow-xl border border-slate-100 space-y-6">
                    <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-800">
                            <i data-lucide="newspaper" class="w-4 h-4"></i>
                        </div>
                        <h3 class="font-display font-bold text-slate-900 text-base">Berita Terkait</h3>
                    </div>

                    <div class="space-y-4">
                        @forelse($rekomendasi as $rek)
                        <a href="{{ route('berita.detail', $rek->slug) }}" class="flex gap-3 group">
                            <div class="w-20 h-16 rounded-xl overflow-hidden bg-slate-100 flex-shrink-0 border border-slate-100">
                                <img src="{{ $rek->gambar_url }}" alt="{{ $rek->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            </div>
                            <div class="flex-1 min-w-0 space-y-1">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-700 block">
                                    {{ $rek->kategori_label }}
                                </span>
                                <h4 class="font-semibold text-xs text-slate-900 group-hover:text-emerald-700 transition-colors line-clamp-2 leading-snug">
                                    {{ $rek->judul }}
                                </h4>
                                <span class="text-[10px] text-slate-400 block">
                                    {{ $rek->published_at ? $rek->published_at->translatedFormat('d M Y') : $rek->created_at->translatedFormat('d M Y') }}
                                </span>
                            </div>
                        </a>
                        @empty
                        <p class="text-xs text-slate-400 py-4 text-center">Belum ada berita terkait lainnya.</p>
                        @endforelse
                    </div>

                    <div class="pt-2">
                        <a href="{{ route('berita') }}" class="w-full py-2.5 px-4 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 text-xs font-bold flex items-center justify-center gap-2 transition-all">
                            Lihat Semua Berita
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
