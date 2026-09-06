@extends('layouts.app')

@section('title', 'Budaya Desa Jambelaer | Kesenian dan Tradisi Lokal')
@section('meta_desc', 'Kenali kekayaan seni dan tradisi budaya Desa Jambelaer – Ruwatan Bumi, Sisingaan, Pencak Silat, dan Karnaval Milangkala khas Kecamatan Dawuan, Kabupaten Subang.')

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Beranda",
      "item": "{{ config('app.url') }}"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "Budaya Desa Jambelaer",
      "item": "{{ config('app.url') }}/budaya"
    }
  ]
}
</script>
@endpush

@section('content')

{{-- ══════════════════════════════════════════════════════════════════
     PAGE HEADER BANNER & BREADCRUMB
══════════════════════════════════════════════════════════════════ --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 sm:pt-6">
    <nav class="flex items-center gap-1.5 text-xs text-stone-500 mb-4 reveal-fade-up">
        <a href="{{ route('home') }}" class="hover:text-forest-800 transition-colors">Beranda</a>
        <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-stone-300"></i>
        <span class="text-forest-800 font-semibold">Budaya & Seni</span>
    </nav>
</div>

<div class="relative h-60 sm:h-72 lg:h-80 overflow-hidden bg-forest-900 rounded-[28px] sm:rounded-[32px] mx-3 sm:mx-5 lg:mx-6 shadow-sm">
    <img src="{{ asset('uploads/img/budaya.webp') }}"
        alt="Budaya Sunda Desa Jambelaer" class="w-full h-full object-cover opacity-60">
    <div class="absolute inset-0 bg-gradient-to-t from-forest-950/90 via-forest-900/50 to-forest-900/20"></div>
    <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
        <span class="section-label !bg-white/10 !text-sand-300 !border-white/20">Kearifan Sunda</span>
        <h1 class="font-display font-extrabold text-3xl sm:text-4xl lg:text-5xl text-white mt-3">Pelestarian Seni & Tradisi</h1>
        <p class="text-xs sm:text-sm text-white/70 mt-2 font-light max-w-md">Merawat tradisi leluhur sebagai pilar identitas dan falsafah hidup bermasyarakat</p>
    </div>
</div>

<div class="bg-white pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center py-10 reveal-on-scroll">
            <span class="section-label">Warisan Budaya</span>
            <h2 class="font-display font-extrabold text-2xl sm:text-3xl text-forest-900 mt-3">Kearifan Lokal Desa</h2>
            <div class="section-divider"></div>
        </div>

        <!-- Culture Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($budayas as $index => $b)
            <a href="{{ route('budaya.detail', $b->slug ?: $b->budaya_id) }}" class="group relative overflow-hidden rounded-xl h-[420px] shadow-sm border border-stone-200 block transition-all duration-300 hover:border-forest-300 hover:shadow-md reveal-fade-up" style="transition-delay: {{ ($index % 4) * 80 }}ms">
                <img src="{{ $b->img_url }}"
                    alt="{{ $b->title }}" class="w-full h-full object-cover group-hover:scale-103 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-forest-950 via-forest-900/40 to-transparent flex flex-col justify-end p-6">
                    <span class="text-[10px] font-bold text-sand-300 tracking-widest uppercase block mb-1.5">{{ $b->kategori }}</span>
                    <h3 class="font-display font-bold text-lg text-white leading-tight">{{ $b->title }}</h3>
                    <p class="text-xs text-white/70 line-clamp-2 mt-2 font-light leading-relaxed">{{ $b->excerpt }}</p>
                    <span class="inline-flex items-center text-xs font-semibold text-sand-300 mt-4 group-hover:text-white transition-colors">
                        Lihat Selengkapnya <i data-lucide="arrow-right" class="w-3.5 h-3.5 ml-1 group-hover:translate-x-1 transition-transform"></i>
                    </span>
                </div>
            </a>
            @empty
            <div class="col-span-full text-center py-16 text-stone-400">
                <i data-lucide="image-off" class="w-10 h-10 mx-auto mb-3 opacity-40"></i>
                <p class="text-sm font-light">Belum ada data budaya yang ditambahkan.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection