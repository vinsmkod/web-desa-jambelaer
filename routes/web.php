<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\PengajuanSuratController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\PertanyaanUmumController;
use App\Http\Controllers\PendaftaranUmkmController;
use App\Http\Controllers\Auth\MasyarakatAuthController;
use App\Http\Controllers\PengajuanSayaController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\PengajuanSuratController as AdminPengajuanSuratController;
use App\Http\Controllers\Admin\PengaduanController as AdminPengaduanController;
use App\Http\Controllers\Admin\PertanyaanUmumController as AdminPertanyaanUmumController;
use App\Http\Controllers\Admin\PendaftaranUmkmController as AdminPendaftaranUmkmController;
use App\Http\Controllers\Admin\JenisSuratController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Admin\TentangController;
use App\Http\Controllers\Admin\BudayaController;
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
use App\Models\AgendaAcara;
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
    $mapsUrl   = Pengaturan::get('maps_embed_url', '');
    return view('pages.tentang', compact('settings', 'mapsUrl'));
})->name('tentang');

// Struktur Desa — halaman terpisah (SRS-F-003.1 Lihat Struktur Desa)
Route::get('/struktur-desa', function () {
    $struktur = StrukturDesa::orderBy('urutan')->orderBy('struktur_desa_id')->get();
    return view('pages.struktur-desa', compact('struktur'));
})->name('struktur.desa');

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
    if (is_numeric($slug)) {
        $budaya = Budaya::find((int)$slug);
        if ($budaya && $budaya->slug) {
            return redirect()->route('budaya.detail', $budaya->slug, 301);
        }
        abort(404);
    }

    $budaya = Budaya::where('slug', $slug)->first();

    if (!$budaya && Budaya::count() === 0) {
        $fallbacks = [
            'ruwatan-bumi-hajat-bumi' => [
                'id' => 1,
                'slug' => 'ruwatan-bumi-hajat-bumi',
                'title' => 'Ruwatan Bumi (Hajat Bumi)',
                'kategori' => 'Upacara Adat',
                'excerpt' => 'Upacara adat tanda syukur hasil bumi pertanian desa yang melimpah.',
                'desc' => 'Tradisi Ruwatan Bumi diadakan setahun sekali setelah panen raya sebagai wujud syukur masyarakat Desa Jambelaer.',
                'img_url' => asset('uploads/img/budaya.webp'),
            ],
            'kesenian-sisingaan' => [
                'id' => 2,
                'slug' => 'kesenian-sisingaan',
                'title' => 'Kesenian Sisingaan',
                'kategori' => 'Seni Pertunjukan',
                'excerpt' => 'Atraksi budaya khas Subang pemacu semangat kebersamaan rakyat.',
                'desc' => 'Kesenian Sisingaan adalah pertunjukan boneka singa raksasa khas Kabupaten Subang.',
                'img_url' => asset('uploads/img/budaya.webp'),
            ],
            'pencak-silat-tradisional' => [
                'id' => 3,
                'slug' => 'pencak-silat-tradisional',
                'title' => 'Pencak Silat Tradisional',
                'kategori' => 'Seni Bela Diri',
                'excerpt' => 'Pelatihan fisik dan spiritual bela diri Sunda yang menjunjung persaudaraan.',
                'desc' => 'Bela diri warisan Sunda untuk melatih ketahanan fisik dan kehalusan budi pekerti.',
                'img_url' => asset('uploads/img/budaya.webp'),
            ],
            'milangkala-karnaval-desa' => [
                'id' => 4,
                'slug' => 'milangkala-karnaval-desa',
                'title' => 'Milangkala & Karnaval Desa',
                'kategori' => 'Festival Tahunan',
                'excerpt' => 'Peringatan hari lahir desa yang diramaikan pawai budaya kreasi warga.',
                'desc' => 'Milangkala dirayakan meriah setiap tahun dengan karnaval budaya.',
                'img_url' => asset('uploads/img/budaya.webp'),
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
        $allFallbacks = [
            'ruwatan-bumi-hajat-bumi' => (object)['id' => 1, 'slug' => 'ruwatan-bumi-hajat-bumi', 'title' => 'Ruwatan Bumi', 'kategori' => 'Upacara Adat', 'img_url' => asset('uploads/img/budaya.webp'), 'excerpt' => 'Upacara adat tanda syukur hasil bumi.'],
            'kesenian-sisingaan'      => (object)['id' => 2, 'slug' => 'kesenian-sisingaan', 'title' => 'Seni Sisingaan', 'kategori' => 'Seni Pertunjukan', 'img_url' => asset('uploads/img/budaya.webp'), 'excerpt' => 'Atraksi budaya khas Subang.'],
            'pencak-silat-tradisional' => (object)['id' => 3, 'slug' => 'pencak-silat-tradisional', 'title' => 'Pencak Silat', 'kategori' => 'Seni Bela Diri', 'img_url' => asset('uploads/img/budaya.webp'), 'excerpt' => 'Bela diri Sunda warisan budaya.'],
            'milangkala-karnaval-desa' => (object)['id' => 4, 'slug' => 'milangkala-karnaval-desa', 'title' => 'Milangkala Desa', 'kategori' => 'Festival Tahunan', 'img_url' => asset('uploads/img/budaya.webp'), 'excerpt' => 'Peringatan hari lahir desa.'],
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

// Kontak & Pusat Informasi Layanan Masyarakat
Route::get('/kontak', function () {
    $sosmed = [
        'instagram' => Pengaturan::get('sosmed_instagram', ''),
        'youtube'   => Pengaturan::get('sosmed_youtube', ''),
        'tiktok'    => Pengaturan::get('sosmed_tiktok', ''),
    ];
    $mapsUrl = Pengaturan::get('maps_embed_url', '');
    return view('pages.kontak', compact('sosmed', 'mapsUrl'));
})->name('kontak');

Route::post('/kontak', [KontakController::class, 'store'])->middleware('throttle:6,1')->name('kontak.store');

Route::get('/layanan', function () {
    return redirect()->route('kontak');
})->name('layanan');

// ── 4 Modul Layanan Masyarakat Terpisah ───────────────────────────────────────

// 1. Modul Pengajuan Pembuatan Surat (SRS-F-010.1)
Route::get('/pengajuan-surat', [PengajuanSuratController::class, 'create'])->name('pengajuan.surat');
Route::post('/pengajuan-surat', [PengajuanSuratController::class, 'store'])->name('pengajuan.surat.store');

// 2. Modul Pengaduan Masyarakat (SRS-F-011.1)
Route::get('/pengaduan', [PengaduanController::class, 'create'])->name('pengaduan.create');
Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');

// 3. Modul Pertanyaan Umum (SRS-F-012.1)
Route::get('/pertanyaan-umum', [PertanyaanUmumController::class, 'create'])->name('pertanyaan-umum.create');
Route::post('/pertanyaan-umum', [PertanyaanUmumController::class, 'store'])->name('pertanyaan-umum.store');

// 4. Modul Pendaftaran UMKM (SRS-F-013.1)
Route::get('/pendaftaran-umkm', [PendaftaranUmkmController::class, 'create'])->name('pendaftaran-umkm.create');
Route::post('/pendaftaran-umkm', [PendaftaranUmkmController::class, 'store'])->name('pendaftaran-umkm.store');

// ── Autentikasi Masyarakat ───────────────────────────────────────────────────
Route::get('/login', [MasyarakatAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [MasyarakatAuthController::class, 'login'])->middleware('throttle:5,1')->name('login.post');
Route::get('/register', [MasyarakatAuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [MasyarakatAuthController::class, 'register'])->name('register.post');
Route::post('/logout', [MasyarakatAuthController::class, 'logout'])->name('logout');

// ── Riwayat & Tracking Layanan Masyarakat (Wajib Login) ──────────────────────
Route::middleware([\App\Http\Middleware\MasyarakatAuth::class])->group(function () {
    Route::get('/pengajuan-saya', [PengajuanSayaController::class, 'index'])->name('pengajuan.saya');
    Route::get('/pengajuan-saya/{jenis}/{id}', [PengajuanSayaController::class, 'showDetail'])->name('pengajuan.show.detail');
    Route::get('/pengajuan-saya/{id}', [PengajuanSayaController::class, 'show'])->whereNumber('id')->name('pengajuan.show');

    // ── Edit Layanan Masyarakat (hanya pengajuan milik sendiri yang masih dapat diubah) ──

    // 1. Pengajuan Pembuatan Surat (SRS-F-010.1)
    Route::get('/pengajuan-surat/{id}/edit', [PengajuanSuratController::class, 'edit'])->whereNumber('id')->name('pengajuan.surat.edit');
    Route::put('/pengajuan-surat/{id}', [PengajuanSuratController::class, 'update'])->whereNumber('id')->name('pengajuan.surat.update');

    // 2. Pengaduan Masyarakat (SRS-F-011.1)
    Route::get('/pengaduan/{id}/edit', [PengaduanController::class, 'edit'])->whereNumber('id')->name('pengaduan.edit');
    Route::put('/pengaduan/{id}', [PengaduanController::class, 'update'])->whereNumber('id')->name('pengaduan.update');

    // 3. Pertanyaan Umum (SRS-F-012.1)
    Route::get('/pertanyaan-umum/{id}/edit', [PertanyaanUmumController::class, 'edit'])->whereNumber('id')->name('pertanyaan-umum.edit');
    Route::put('/pertanyaan-umum/{id}', [PertanyaanUmumController::class, 'update'])->whereNumber('id')->name('pertanyaan-umum.update');

    // 4. Pendaftaran UMKM (SRS-F-013.1)
    Route::get('/pendaftaran-umkm/{id}/edit', [PendaftaranUmkmController::class, 'edit'])->whereNumber('id')->name('pendaftaran-umkm.edit');
    Route::put('/pendaftaran-umkm/{id}', [PendaftaranUmkmController::class, 'update'])->whereNumber('id')->name('pendaftaran-umkm.update');

    // ── Batalkan Pengajuan Layanan Masyarakat (hanya pemilik sendiri yang masih dapat dibatalkan) ──
    // Mekanisme: perubahan status menjadi "dibatalkan" (bukan hapus data), sesuai workflow
    // berbasis status yang digunakan sistem. Endpoint hanya menerima POST + CSRF token.

    // 1. Pengajuan Pembuatan Surat (SRS-F-010.1)
    Route::post('/pengajuan-surat/{id}/batal', [PengajuanSuratController::class, 'batal'])->whereNumber('id')->name('pengajuan.surat.batal');

    // 2. Pengaduan Masyarakat (SRS-F-011.1)
    Route::post('/pengaduan/{id}/batal', [PengaduanController::class, 'batal'])->whereNumber('id')->name('pengaduan.batal');

    // 3. Pertanyaan Umum (SRS-F-012.1)
    Route::post('/pertanyaan-umum/{id}/batal', [PertanyaanUmumController::class, 'batal'])->whereNumber('id')->name('pertanyaan-umum.batal');

    // 4. Pendaftaran UMKM (SRS-F-013.1)
    Route::post('/pendaftaran-umkm/{id}/batal', [PendaftaranUmkmController::class, 'batal'])->whereNumber('id')->name('pendaftaran-umkm.batal');
});

// Acara – Daftar agenda acara desa yang dipublikasikan (Informasi Publik)
Route::get('/acara', function () {
    AgendaAcara::cleanupExpiredAcara();

    $today = now()->toDateString();

    $acaras = AgendaAcara::where('dipublikasikan', true)
        ->whereDate('tanggal_acara', '>=', $today)
        ->orderBy('tanggal_acara', 'asc')
        ->orderBy('waktu_acara', 'asc')
        ->get();

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

    $sessionKey = 'viewed_berita_' . $berita->berita_id;
    if (!auth()->check() && !session()->has($sessionKey)) {
        $berita->increment('views');
        $berita->views++;
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

Route::prefix('admin')->name('admin.')->group(function () {
    // Login (public)
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('login.post');

    // Protected routes
    Route::middleware(\App\Http\Middleware\AdminAuth::class)->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // 1. Kelola Pengajuan Pembuatan Surat (SRS-F-010)
        Route::get('/pengajuan-surat', [AdminPengajuanSuratController::class, 'index'])->name('pengajuan-surat.index');
        Route::get('/pengajuan-surat/{pengajuanSurat}', [AdminPengajuanSuratController::class, 'show'])->name('pengajuan-surat.show');
        Route::patch('/pengajuan-surat/{pengajuanSurat}/status', [AdminPengajuanSuratController::class, 'updateStatus'])->name('pengajuan-surat.status');
        Route::delete('/pengajuan-surat/{pengajuanSurat}', [AdminPengajuanSuratController::class, 'destroy'])->name('pengajuan-surat.destroy');

        // 2. Kelola Pengaduan Masyarakat (SRS-F-011)
        Route::get('/pengaduan', [AdminPengaduanController::class, 'index'])->name('pengaduan.index');
        Route::get('/pengaduan/{pengaduan}', [AdminPengaduanController::class, 'show'])->name('pengaduan.show');
        Route::patch('/pengaduan/{pengaduan}/status', [AdminPengaduanController::class, 'updateStatus'])->name('pengaduan.status');
        Route::delete('/pengaduan/{pengaduan}', [AdminPengaduanController::class, 'destroy'])->name('pengaduan.destroy');

        // 3. Kelola Pertanyaan Umum (SRS-F-012)
        Route::get('/pertanyaan-umum', [AdminPertanyaanUmumController::class, 'index'])->name('pertanyaan-umum.index');
        Route::get('/pertanyaan-umum/{pertanyaanUmum}', [AdminPertanyaanUmumController::class, 'show'])->name('pertanyaan-umum.show');
        Route::patch('/pertanyaan-umum/{pertanyaanUmum}/status', [AdminPertanyaanUmumController::class, 'updateStatus'])->name('pertanyaan-umum.status');
        Route::delete('/pertanyaan-umum/{pertanyaanUmum}', [AdminPertanyaanUmumController::class, 'destroy'])->name('pertanyaan-umum.destroy');

        // 4. Kelola Pendaftaran UMKM (SRS-F-013)
        Route::get('/pendaftaran-umkm', [AdminPendaftaranUmkmController::class, 'index'])->name('pendaftaran-umkm.index');
        Route::get('/pendaftaran-umkm/{pendaftaranUmkm}', [AdminPendaftaranUmkmController::class, 'show'])->name('pendaftaran-umkm.show');
        Route::patch('/pendaftaran-umkm/{pendaftaranUmkm}/status', [AdminPendaftaranUmkmController::class, 'updateStatus'])->name('pendaftaran-umkm.status');
        Route::post('/pendaftaran-umkm/{pendaftaranUmkm}/publikasikan', [AdminPendaftaranUmkmController::class, 'publikasikan'])->name('pendaftaran-umkm.publikasikan');
        Route::delete('/pendaftaran-umkm/{pendaftaranUmkm}', [AdminPendaftaranUmkmController::class, 'destroy'])->name('pendaftaran-umkm.destroy');

        // Kelola Jenis Surat CRUD
        Route::resource('jenis-surat', JenisSuratController::class)->names('jenis-surat');
        Route::patch('/jenis-surat/{jenisSurat}/toggle', [JenisSuratController::class, 'toggleActive'])->name('jenis-surat.toggle');

        // Produk UMKM (SRS-F-005)
        Route::resource('produk', ProdukController::class);

        // Galeri Desa (SRS-F-008)
        Route::resource('galeri', GaleriController::class);

        // Acara & Agenda Desa CRUD (SRS-F-009)
        Route::resource('acara', AcaraController::class)->parameters(['acara' => 'acara']);
        Route::patch('/acara/{acara}/status', [AcaraController::class, 'updateStatus'])->name('acara.status');
        Route::post('/acara/{acara}/publikasi', [AcaraController::class, 'publikasiAcara'])->name('acara.publikasi');

        // Pengaturan (SRS-F-002)
        Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
        Route::put('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');

        // Tentang Kami & Struktur Desa (SRS-F-002 & SRS-F-003)
        Route::get('/tentang', [TentangController::class, 'index'])->name('tentang.index');
        Route::put('/tentang', [TentangController::class, 'update'])->name('tentang.update');
        Route::post('/struktur', [TentangController::class, 'strukturStore'])->name('struktur.store');
        Route::put('/struktur/{struktur}', [TentangController::class, 'strukturUpdate'])->name('struktur.update');
        Route::delete('/struktur/{struktur}', [TentangController::class, 'strukturDestroy'])->name('struktur.destroy');

        // Budaya (SRS-F-007)
        Route::resource('budaya', BudayaController::class);

        // Wisata (SRS-F-006)
        Route::resource('wisata', WisataController::class)->parameters(['wisata' => 'wisata']);

        // Berita (SRS-F-004)
        Route::resource('berita', BeritaController::class)->parameters(['berita' => 'berita']);

        // Kelola Pengguna Admin (SRS-F-014)
        Route::get('/kelola-admin', [AdminManagementController::class, 'index'])->name('kelola-admin.index');
        Route::get('/kelola-admin/create', [AdminManagementController::class, 'create'])->name('kelola-admin.create');
        Route::post('/kelola-admin', [AdminManagementController::class, 'store'])->name('kelola-admin.store');
        Route::get('/kelola-admin/{admin}/edit', [AdminManagementController::class, 'edit'])->name('kelola-admin.edit');
        Route::put('/kelola-admin/{admin}', [AdminManagementController::class, 'update'])->name('kelola-admin.update');
        Route::delete('/kelola-admin/{admin}', [AdminManagementController::class, 'destroy'])->name('kelola-admin.destroy');


    });
});
