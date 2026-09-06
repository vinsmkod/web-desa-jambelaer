<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\PesanController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Admin\TentangController;
use App\Http\Controllers\Admin\BudayaController;
use App\Http\Controllers\Admin\PengajuanAcaraController;
use App\Http\Controllers\Admin\AcaraController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\AdminManagementController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\WisataController;
use App\Models\Produk;
use App\Models\Pengaturan;
use App\Models\StrukturDesa;
use App\Models\Budaya;
use App\Models\Galeri;
use App\Models\Pesan;
use App\Models\Berita;
use App\Models\Wisata;

// ── Frontend Routes ─────────────────────────────────────────────────────────

// Sitemap XML — harus diakses sebelum route lain agar tidak tertutup wildcard
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Home
Route::get('/', function () {
    $settings = [
        'stat_luas'     => Pengaturan::get('stat_luas', '1240'),
        'stat_penduduk' => Pengaturan::get('stat_penduduk', '4850'),
        'stat_umkm'     => Pengaturan::get('stat_umkm', '35'),
        'stat_kk'       => Pengaturan::get('stat_kk', '1250'),
        'stat_rtrw'     => Pengaturan::get('stat_rtrw', '24'),
        'stat_dusun'    => Pengaturan::get('stat_dusun', '4'),
    ];
    $umkms   = Produk::where('is_active', true)->orderBy('urutan')->orderBy('produk_id')->take(6)->get();
    $budayas = Budaya::orderBy('urutan')->orderBy('budaya_id')->take(3)->get();
    $wisatas = Wisata::where('is_active', true)->orderBy('urutan')->orderBy('wisata_id')->take(3)->get();
    $beritas = Berita::where('is_published', true)->orderBy('published_at', 'desc')->take(3)->get();
    $galeris = Galeri::where('is_active', true)->orderBy('urutan')->orderBy('galeri_id')->take(6)->get();

    return view('pages.home', compact('settings', 'umkms', 'budayas', 'wisatas', 'beritas', 'galeris'));
})->name('home');

// Tentang Kami
Route::get('/tentang-kami', function () {
    $settings  = Pengaturan::all()->keyBy('key');
    $struktur  = StrukturDesa::orderBy('urutan')->orderBy('struktur_desa_id')->get();
    $mapsUrl   = Pengaturan::get('maps_embed_url', '');
    return view('pages.tentang', compact('settings', 'struktur', 'mapsUrl'));
})->name('tentang');

// UMKM – Daftar produk (grouped by jenis)
Route::get('/umkm', function () {
    $products           = Produk::where('is_active', true)->orderBy('urutan')->orderBy('produk_id')->get();
    $jenisGroups        = $products->whereNotNull('jenis')->groupBy('jenis');
    $individualProducts = $products->filter(fn($p) => is_null($p->jenis));
    return view('pages.umkm', compact('products', 'jenisGroups', 'individualProducts'));
})->name('umkm');

// UMKM – Daftar produsen per jenis produk (HARUS sebelum /{slug})
Route::get('/umkm/jenis/{jenis}', function ($jenis) {
    $producers = Produk::where('is_active', true)
        ->where('jenis', $jenis)
        ->orderBy('urutan')
        ->orderBy('produk_id')
        ->get();
    if ($producers->isEmpty()) abort(404);
    $jenisLabel = $producers->first()->jenis_label ?? ucfirst($jenis);
    return view('pages.umkm-producers', compact('producers', 'jenis', 'jenisLabel'));
})->name('umkm.jenis');

// UMKM – Detail produk
Route::get('/umkm/{slug}', function ($slug) {
    $product     = Produk::where('slug', $slug)->where('is_active', true)->firstOrFail();
    $allProducts = Produk::where('is_active', true)->where('slug', '!=', $slug)->take(4)->get();
    return view('pages.umkm-detail', compact('product', 'allProducts'));
})->name('umkm.detail');

// Budaya
Route::get('/budaya', function () {
    $budayas = Budaya::orderBy('urutan')->orderBy('budaya_id')->get();
    return view('pages.budaya', compact('budayas'));
})->name('budaya');

// Budaya Detail — SEO-friendly slug URL
Route::get('/budaya/{slug}', function ($slug) {
    // Jika parameter adalah angka (ID lama), redirect 301 ke slug baru
    if (is_numeric($slug)) {
        $budaya = Budaya::find((int)$slug);
        if ($budaya && $budaya->slug) {
            return redirect()->route('budaya.detail', $budaya->slug, 301);
        }
        abort(404);
    }

    // Cari berdasarkan slug
    $budaya = Budaya::where('slug', $slug)->first();

    // Fallback: jika database budaya kosong, gunakan data statis
    if (!$budaya && Budaya::count() === 0) {
        $fallbacks = [
            'ruwatan-bumi-hajat-bumi' => [
                'id' => 1,
                'slug' => 'ruwatan-bumi-hajat-bumi',
                'title' => 'Ruwatan Bumi (Hajat Bumi)',
                'kategori' => 'Upacara Adat',
                'excerpt' => 'Upacara adat tanda syukur hasil bumi pertanian desa yang melimpah.',
                'desc' => 'Tradisi Ruwatan Bumi (atau Hajat Bumi) diadakan setahun sekali setelah panen raya sebagai wujud syukur masyarakat Desa Jambelaer kepada Tuhan Yang Maha Esa atas kelimpahan hasil bumi pertanian. Upacara adat diisi dengan mengarak tumpeng besar, doa bersama para sepuh desa, pagelaran wayang golek, serta saling bertukar hidangan makanan antar tetangga untuk mempererat silaturahmi gotong royong.',
                'img_url' => 'https://images.unsplash.com/photo-1530595467537-0b5996c41f2d?auto=format&fit=crop&w=800&q=80',
            ],
            'kesenian-sisingaan' => [
                'id' => 2,
                'slug' => 'kesenian-sisingaan',
                'title' => 'Kesenian Sisingaan',
                'kategori' => 'Seni Pertunjukan',
                'excerpt' => 'Atraksi budaya khas Subang pemacu semangat kebersamaan rakyat.',
                'desc' => 'Kesenian Sisingaan adalah pertunjukan boneka singa raksasa khas Kabupaten Subang yang ditunggangi anak-anak lalu diusung oleh para pemuda gagah sambil menari mengikuti irama tabuhan kendang pencak silat.',
                'img_url' => 'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?auto=format&fit=crop&w=800&q=80',
            ],
            'pencak-silat-tradisional' => [
                'id' => 3,
                'slug' => 'pencak-silat-tradisional',
                'title' => 'Pencak Silat Tradisional',
                'kategori' => 'Seni Bela Diri',
                'excerpt' => 'Pelatihan fisik dan spiritual bela diri Sunda yang menjunjung persaudaraan.',
                'desc' => 'Sebagai bentuk pelestarian bela diri warisan Sunda, Desa Jambelaer memiliki padepokan pencak silat lokal tempat berkumpulnya pemuda untuk melatih ketahanan fisik, konsentrasi mental, dan kehalusan budi pekerti.',
                'img_url' => 'https://images.unsplash.com/photo-1555597673-b21d5c935865?auto=format&fit=crop&w=800&q=80',
            ],
            'milangkala-karnaval-desa' => [
                'id' => 4,
                'slug' => 'milangkala-karnaval-desa',
                'title' => 'Milangkala & Karnaval Desa',
                'kategori' => 'Festival Tahunan',
                'excerpt' => 'Peringatan hari lahir desa yang diramaikan pawai budaya kreasi warga.',
                'desc' => 'Milangkala atau hari jadi Desa Jambelaer dirayakan meriah setiap tahun dengan karnaval budaya. Setiap dusun bergotong royong membuat hiasan replika hasil bumi, memakai pakaian adat sunda pengantin atau kebaya, serta memamerkan kesenian kreasi masing-masing dusun dalam parade keliling sepanjang jalan desa.',
            ],
        ];

        if (isset($fallbacks[$slug])) {
            $budaya = (object) $fallbacks[$slug];
        }
    }

    if (!$budaya) {
        abort(404);
    }

    $rekomendasi = [];
    if (Budaya::count() > 0) {
        $rekomendasi = Budaya::where('slug', '!=', $slug)->orderBy('urutan')->take(3)->get();
    } else {
        // Fallback rekomendasi statis
        $allFallbacks = [
            'ruwatan-bumi-hajat-bumi' => (object)['id' => 1, 'slug' => 'ruwatan-bumi-hajat-bumi', 'title' => 'Ruwatan Bumi', 'kategori' => 'Upacara Adat', 'img_url' => 'https://images.unsplash.com/photo-1530595467537-0b5996c41f2d?auto=format&fit=crop&w=400&q=80', 'excerpt' => 'Upacara adat tanda syukur hasil bumi.'],
            'kesenian-sisingaan'      => (object)['id' => 2, 'slug' => 'kesenian-sisingaan', 'title' => 'Seni Sisingaan', 'kategori' => 'Seni Pertunjukan', 'img_url' => 'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?auto=format&fit=crop&w=400&q=80', 'excerpt' => 'Atraksi budaya khas Subang.'],
            'pencak-silat-tradisional' => (object)['id' => 3, 'slug' => 'pencak-silat-tradisional', 'title' => 'Pencak Silat', 'kategori' => 'Seni Bela Diri', 'img_url' => 'https://images.unsplash.com/photo-1555597673-b21d5c935865?auto=format&fit=crop&w=400&q=80', 'excerpt' => 'Bela diri Sunda warisan budaya.'],
            'milangkala-karnaval-desa' => (object)['id' => 4, 'slug' => 'milangkala-karnaval-desa', 'title' => 'Milangkala Desa', 'kategori' => 'Festival Tahunan', 'img_url' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=400&q=80', 'excerpt' => 'Peringatan hari lahir desa.'],
        ];
        unset($allFallbacks[$slug]);
        $rekomendasi = array_values($allFallbacks);
    }

    return view('pages.budaya-detail', compact('budaya', 'rekomendasi'));
})->name('budaya.detail');

// Wisata
Route::get('/wisata', function () {
    $wisatas = Wisata::where('is_active', true)->orderBy('urutan')->orderBy('wisata_id')->get();
    $kategoriList = Wisata::kategoriList();
    return view('pages.wisata', compact('wisatas', 'kategoriList'));
})->name('wisata');

Route::get('/wisata/{slug}', function ($slug) {
    $wisata = Wisata::where('slug', $slug)->where('is_active', true)->firstOrFail();
    $rekomendasi = Wisata::where('is_active', true)
        ->where('wisata_id', '!=', $wisata->wisata_id)
        ->orderBy('urutan')
        ->take(3)
        ->get();
    return view('pages.wisata-detail', compact('wisata', 'rekomendasi'));
})->name('wisata.detail');

// Galeri – Daftar foto galeri desa
Route::get('/galeri', function () {
    $galeris      = Galeri::where('is_active', true)->orderBy('urutan')->orderBy('galeri_id')->get();
    $kategoriList = Galeri::kategoriList();
    return view('pages.galeri', compact('galeris', 'kategoriList'));
})->name('galeri');

// Galeri – Detail foto SEO-friendly slug
Route::get('/galeri/{slug}', function ($slug) {
    // Jika parameter berupa angka (ID lama), redirect 301 ke URL slug baru
    if (is_numeric($slug)) {
        $foto = Galeri::where('is_active', true)->find((int)$slug);
        if ($foto && $foto->slug) {
            return redirect()->route('galeri.detail', $foto->slug, 301);
        }
        if (!$foto) abort(404);
    } else {
        $foto = Galeri::where('slug', $slug)->where('is_active', true)->firstOrFail();
    }

    $lainnya = Galeri::where('is_active', true)
        ->where('galeri_id', '!=', $foto->galeri_id)
        ->where('kategori', $foto->kategori)
        ->orderBy('urutan')
        ->take(6)
        ->get();

    return view('pages.galeri-detail', compact('foto', 'lainnya'));
})->name('galeri.detail');

// Kontak – Form
Route::get('/kontak', function () {
    $sosmed = [
        'instagram' => Pengaturan::get('sosmed_instagram', ''),
        'youtube'   => Pengaturan::get('sosmed_youtube', ''),
        'tiktok'    => Pengaturan::get('sosmed_tiktok', ''),
    ];
    $mapsUrl = Pengaturan::get('maps_embed_url', '');
    return view('pages.kontak', compact('sosmed', 'mapsUrl'));
})->name('kontak');

// Kontak – Submit pesan (simpan ke DB)
Route::post('/kontak', [KontakController::class, 'store'])->middleware('throttle:6,1')->name('kontak.store');

// Layanan Publik (Aliasing ke pusat layanan /kontak)
Route::get('/layanan', function () {
    return redirect()->route('kontak');
})->name('layanan');

// Acara – Daftar acara yang disetujui & dipublikasikan (Sesi Aktif & Auto-Delete Expired)
Route::get('/acara', function () {
    // Hapus otomatis pengajuan acara yang sudah melewati tanggal hari ini
    Pesan::cleanupExpiredAcara();

    $today = now()->toDateString();

    $acaras = Pesan::where('jenis_pesan', 'pengajuan_acara')
        ->where('status', 'disetujui')
        ->where('dipublikasikan', true)
        ->whereDate('tanggal_acara', '>=', $today)
        ->orderBy('tanggal_acara', 'asc')
        ->orderBy('waktu_acara', 'asc')
        ->get();

    // Kelompokkan per bulan untuk kalender timeline
    $acaraPerBulan = $acaras->groupBy(function ($a) {
        return $a->tanggal_acara ? $a->tanggal_acara->format('Y-m') : 'unknown';
    });

    return view('pages.acara', compact('acaras', 'acaraPerBulan', 'today'));
})->name('acara');

// Berita – Portal Berita Publik
Route::get('/berita', function () {
    $featuredBerita = Berita::where('is_published', true)->orderBy('published_at', 'desc')->first();
    $beritas = Berita::where('is_published', true)->orderBy('published_at', 'desc')->orderBy('berita_id', 'desc')->paginate(9);

    return view('pages.berita', compact('beritas', 'featuredBerita'));
})->name('berita');

// Berita – Detail Artikel
Route::get('/berita/{slug}', function ($slug) {
    $berita = Berita::where('slug', $slug)->where('is_published', true)->firstOrFail();

    // Hitung views hanya dari pengunjung publik & cegah manipulasi spam refresh dalam 1 sesi
    $sessionKey = 'viewed_berita_' . $berita->berita_id;
    if (!auth()->check() && !session()->has($sessionKey)) {
        $berita->increment('views');
        $berita->views++; // Update angka views di memori agar langsung sesuai pada halaman
        session()->put($sessionKey, true);
    }

    $rekomendasi = Berita::where('is_published', true)
        ->where('berita_id', '!=', $berita->berita_id)
        ->orderBy('published_at', 'desc')
        ->take(4)
        ->get();

    return view('pages.berita-detail', compact('berita', 'rekomendasi'));
})->name('berita.detail');



// ── Admin Routes ─────────────────────────────────────────────────────────────

// Login (public)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('login.post');

    // Protected routes
    Route::middleware(\App\Http\Middleware\AdminAuth::class)->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Produk UMKM
        Route::resource('produk', ProdukController::class);

        // Galeri Desa
        Route::resource('galeri', GaleriController::class);

        // Pesan
        Route::get('/pesan', [PesanController::class, 'index'])->name('pesan.index');
        Route::get('/pesan/{pesan}', [PesanController::class, 'show'])->name('pesan.show');
        Route::patch('/pesan/{pesan}/read', [PesanController::class, 'markRead'])->name('pesan.read');
        Route::delete('/pesan/{pesan}', [PesanController::class, 'destroy'])->name('pesan.destroy');

        // Acara & Agenda Desa CRUD
        Route::resource('acara', AcaraController::class)->parameters(['acara' => 'pesan']);
        Route::patch('/acara/{pesan}/status', [AcaraController::class, 'updateStatus'])->name('acara.status');
        Route::post('/acara/{pesan}/publikasi', [AcaraController::class, 'publikasiAcara'])->name('acara.publikasi');

        // Pengajuan Acara Aliases (Mendukung backward compatibility)
        Route::get('/pengajuan-acara', [AcaraController::class, 'index'])->name('pengajuan-acara.index');
        Route::get('/pengajuan-acara/{pesan}', [AcaraController::class, 'show'])->name('pengajuan-acara.show');
        Route::patch('/pengajuan-acara/{pesan}/status', [AcaraController::class, 'updateStatus'])->name('pengajuan-acara.status');
        Route::post('/pengajuan-acara/{pesan}/publikasi', [AcaraController::class, 'publikasiAcara'])->name('pengajuan-acara.publikasi');
        Route::delete('/pengajuan-acara/{pesan}', [AcaraController::class, 'destroy'])->name('pengajuan-acara.destroy');

        // Pengaturan
        Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
        Route::put('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');

        // Tentang Kami CRUD
        Route::get('/tentang', [TentangController::class, 'index'])->name('tentang.index');
        Route::put('/tentang', [TentangController::class, 'update'])->name('tentang.update');

        // Struktur Desa CRUD
        Route::post('/struktur', [TentangController::class, 'strukturStore'])->name('struktur.store');
        Route::put('/struktur/{struktur}', [TentangController::class, 'strukturUpdate'])->name('struktur.update');
        Route::delete('/struktur/{struktur}', [TentangController::class, 'strukturDestroy'])->name('struktur.destroy');

        // Budaya CRUD
        Route::resource('budaya', BudayaController::class);

        // Wisata CRUD
        Route::resource('wisata', WisataController::class)->parameters(['wisata' => 'wisata']);

        // Berita CRUD
        Route::resource('berita', BeritaController::class)->parameters(['berita' => 'berita']);

        // Kelola Admin CRUD
        Route::get('/kelola-admin', [AdminManagementController::class, 'index'])->name('kelola-admin.index');
        Route::get('/kelola-admin/create', [AdminManagementController::class, 'create'])->name('kelola-admin.create');
        Route::post('/kelola-admin', [AdminManagementController::class, 'store'])->name('kelola-admin.store');
        Route::get('/kelola-admin/{admin}/edit', [AdminManagementController::class, 'edit'])->name('kelola-admin.edit');
        Route::put('/kelola-admin/{admin}', [AdminManagementController::class, 'update'])->name('kelola-admin.update');
        Route::delete('/kelola-admin/{admin}', [AdminManagementController::class, 'destroy'])->name('kelola-admin.destroy');
    });
});
