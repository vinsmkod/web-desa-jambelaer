<nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between gap-4 flex-wrap">
    {{-- Info kiri --}}
    <div>
        @if ($paginator->firstItem())
        <p class="text-xs text-slate-500">
            Menampilkan
            <span class="font-bold text-slate-700">{{ $paginator->firstItem() }}</span>–<span class="font-bold text-slate-700">{{ $paginator->lastItem() }}</span>
            dari <span class="font-bold text-slate-700">{{ $paginator->total() }}</span> data
        </p>
        @endif
    </div>

    {{-- Tombol navigasi kanan --}}
    @if ($paginator->hasPages())
    <div class="flex items-center gap-1.5">

        {{-- Prev --}}
        @if ($paginator->onFirstPage())
            <span class="w-8 h-8 flex items-center justify-center rounded-xl bg-slate-100 text-slate-300 border border-slate-200 cursor-not-allowed text-sm font-bold select-none">&lsaquo;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-forest-50 hover:text-forest-700 hover:border-forest-200 transition-all text-sm font-bold shadow-xs">&lsaquo;</a>
        @endif

        {{-- Pages --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="w-8 h-8 flex items-center justify-center text-xs text-slate-400 select-none">&hellip;</span>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="w-8 h-8 flex items-center justify-center rounded-xl bg-forest-700 text-white font-bold text-xs border border-forest-800 shadow-xs select-none">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="w-8 h-8 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-forest-50 hover:text-forest-700 hover:border-forest-200 transition-all text-xs font-medium shadow-xs">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-forest-50 hover:text-forest-700 hover:border-forest-200 transition-all text-sm font-bold shadow-xs">&rsaquo;</a>
        @else
            <span class="w-8 h-8 flex items-center justify-center rounded-xl bg-slate-100 text-slate-300 border border-slate-200 cursor-not-allowed text-sm font-bold select-none">&rsaquo;</span>
        @endif

    </div>
    @endif
</nav>
