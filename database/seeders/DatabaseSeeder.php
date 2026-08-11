<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Produk;
use App\Models\Pengaturan;
use App\Models\Budaya;
use App\Models\Berita;
use App\Models\Wisata;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin User ──────────────────────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'admin@jambelaer.id'],
            [
                'name'     => 'Admin Desa Jambelaer',
                'email'    => 'admin@jambelaer.id',
                'password' => Hash::make('admin123'),
            ]
        );

        // ── Produk UMKM ─────────────────────────────────────────────────────
        $produk = [
            [
                'slug'       => 'gula-aren',
                'title'      => 'Gula Aren Cetak Murni',
                'producer'   => 'KWT Melati Lestari',
                'price'      => 'Rp 15.000 / kg',
                'badge'      => 'Makanan',
                'category'   => ['makanan'],
                'img'        => 'https://images.unsplash.com/photo-1608039829572-78524f79c4c7?auto=format&fit=crop&w=1200&q=80',
                'desc_short' => 'Diproses tradisional dari nira pohon aren murni tanpa pemanis buatan. Wangi khas dan legit natural.',
                'desc_long'  => 'Gula aren cetak murni diproses secara tradisional dari nira pohon aren pilihan tanpa campuran pemanis buatan. Memiliki aroma khas yang harum dan rasa legit natural. Cocok digunakan sebagai bahan masakan, minuman tradisional, dan olahan kue khas Sunda. Diproduksi langsung oleh ibu-ibu KWT Melati Lestari menggunakan tungku kayu bakar dengan metode turun-temurun yang telah diwariskan selama tiga generasi.',
                'details'    => [
                    'Berat Bersih' => '250 gram / cetakan',
                    'Kemasan'      => 'Daun pisang kering & kardus',
                    'Masa Simpan'  => '6 bulan (suhu ruang)',
                    'Sertifikasi'  => 'P-IRT No. 215321',
                    'Ketersediaan' => 'Stok tersedia, pengiriman 1–3 hari',
                ],
                'is_active' => true,
                'urutan'    => 1,
            ],
            [
                'slug'       => 'keripik-singkong',
                'title'      => 'Keripik Singkong Renyah',
                'producer'   => 'UMKM Sumber Barokah',
                'price'      => 'Rp 8.000 / bks',
                'badge'      => 'Makanan',
                'category'   => ['makanan'],
                'img'        => 'https://images.unsplash.com/photo-1566847438217-76e82d383f84?auto=format&fit=crop&w=1200&q=80',
                'desc_short' => 'Singkong pilihan dipotong tipis dibumbui bawang putih gurih alami. Sangat renyah dan empuk digigit.',
                'desc_long'  => 'Keripik singkong pilihan dipotong tipis-tipis lalu digoreng dengan minyak bersih berbumbu bawang putih gurih alami. Teksturnya sangat renyah dan tetap empuk ketika digigit. Tersedia dalam varian rasa original, pedas, dan balado. Dikemas higienis dengan standing pouch kedap udara agar tetap segar hingga 3 bulan.',
                'details'    => [
                    'Berat Bersih' => '150 gram / bungkus',
                    'Varian Rasa'  => 'Original, Pedas, Balado',
                    'Masa Simpan'  => '3 bulan (kemasan tertutup)',
                    'Sertifikasi'  => 'P-IRT No. 216321',
                    'Ketersediaan' => 'Stok tersedia, pengiriman 1–2 hari',
                ],
                'is_active' => true,
                'urutan'    => 2,
            ],
            [
                'slug'       => 'kerajinan-bambu',
                'title'      => 'Gantungan & Keranjang Bambu',
                'producer'   => 'Galeri Bambu Jambelaer',
                'price'      => 'Rp 25.000 / pcs',
                'badge'      => 'Kerajinan',
                'category'   => ['kerajinan'],
                'img'        => 'https://images.unsplash.com/photo-1531971589569-0d9370cbe1e5?auto=format&fit=crop&w=1200&q=80',
                'desc_short' => 'Anyaman bambu lokal halus buatan tangan pengrajin sepuh desa. Kuat, aestetik, dan serbaguna.',
                'desc_long'  => 'Anyaman bambu lokal buatan tangan pengrajin sepuh Desa Jambelaer yang telah berpengalaman puluhan tahun. Menggunakan bilah bambu pilihan yang diproses ramah lingkungan tanpa bahan kimia berbahaya. Tersedia dalam berbagai ukuran dan motif.',
                'details'    => [
                    'Material'     => 'Bambu apus pilihan',
                    'Ukuran'       => 'S (20×15 cm), M (30×25 cm), L (40×35 cm)',
                    'Finishing'    => 'Natural / pernis transparan',
                    'Pengerjaan'   => 'Handmade, 2–3 hari per produk',
                    'Ketersediaan' => 'Pesan terlebih dahulu (made by order)',
                ],
                'is_active' => true,
                'urutan'    => 3,
            ],
            [
                'slug'        => 'beras-organik',
                'title'       => 'Beras Organik Unggul',
                'producer'    => 'Gapoktan Sawah Asri',
                'price'       => 'Rp 18.000 / kg',
                'badge'       => 'Makanan',
                'category'    => ['makanan'],
                'img'         => 'https://images.unsplash.com/photo-1586201375761-83865001e31c?auto=format&fit=crop&w=1200&q=80',
                'desc_short'  => 'Ditanam menggunakan metode organik murni dari air pegunungan Subang. Pulen, sehat, tinggi nutrisi.',
                'desc_long'   => 'Beras organik premium yang ditanam menggunakan metode pertanian organik murni tanpa pestisida kimia. Irigasi menggunakan air bersih dari saluran pegunungan Subang yang alami. Varietasnya adalah padi lokal unggul yang menghasilkan nasi pulen, harum, dan bernutrisi tinggi.',
                'details'     => [
                    'Kemasan'      => '1 kg, 5 kg, 10 kg',
                    'Varietas'     => 'Padi IR-64 Organik',
                    'Masa Simpan'  => '12 bulan (tempat sejuk & kering)',
                    'Sertifikasi'  => 'Organik – Dinas Pertanian Kab. Subang',
                    'Ketersediaan' => 'Tersedia sepanjang tahun',
                ],
                'is_active'   => true,
                'urutan'      => 4,
            ],
            // ── Opak – 3 Produsen Lokal ─────────────────────────────────────
            [
                'slug'        => 'opak-singkong-bu-siti',
                'title'       => 'Opak Singkong Bu Siti',
                'producer'    => 'Bu Siti Rahayu',
                'price'       => 'Rp 12.000 / bks',
                'badge'       => 'Makanan',
                'jenis'       => 'opak',
                'jenis_label' => 'Opak',
                'category'    => ['makanan'],
                'img'         => 'https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?auto=format&fit=crop&w=1200&q=80',
                'desc_short'  => 'Opak singkong renyah buatan Bu Siti, dibumbui rempah khas Sunda. Digoreng kering tanpa pengawet.',
                'desc_long'   => 'Opak singkong Bu Siti Rahayu adalah kerupuk tradisional khas Sunda yang terbuat dari singkong pilihan, diproses secara higienis tanpa bahan pengawet. Dibumbui dengan rempah khas Sunda seperti bawang putih, ketumbar, dan sedikit kencur sehingga menghasilkan cita rasa gurih yang otentik. Proses pengeringan dilakukan secara alami di bawah sinar matahari sebelum digoreng kering hingga sempurna renyah. Dikemas dalam plastik kedap udara 200 gram per bungkus.',
                'details'     => [
                    'Berat Bersih'  => '200 gram / bungkus',
                    'Bahan Utama'   => 'Singkong pilihan',
                    'Rasa'          => 'Original, Asin Gurih',
                    'Masa Simpan'   => '2 bulan (kemasan tertutup)',
                    'Ketersediaan'  => 'Tersedia, min. order 5 bungkus',
                ],
                'is_active'   => true,
                'urutan'      => 5,
            ],
            [
                'slug'        => 'opak-gurih-pak-deden',
                'title'       => 'Opak Gurih Pak Deden',
                'producer'    => 'Pak Deden Suryana',
                'price'       => 'Rp 10.000 / bks',
                'badge'       => 'Makanan',
                'jenis'       => 'opak',
                'jenis_label' => 'Opak',
                'category'    => ['makanan'],
                'img'         => 'https://images.unsplash.com/photo-1547592180-85f173990554?auto=format&fit=crop&w=1200&q=80',
                'desc_short'  => 'Opak tipis renyah produksi Pak Deden, resep turun-temurun 3 generasi di Desa Jambelaer.',
                'desc_long'   => 'Pak Deden Suryana adalah pengrajin opak generasi ketiga di Desa Jambelaer. Resep warisan leluhur ini menggunakan singkong lokal yang dipanen sendiri dari kebun sekitar desa. Proses pembuatan sepenuhnya manual menggunakan alat tradisional sehingga setiap keping opak memiliki ketebalan khas dan tekstur renyah yang berbeda dari opak pabrikan. Tersedia dalam ukuran besar (diameter 20 cm) dan mini untuk camilan sehari-hari.',
                'details'     => [
                    'Berat Bersih'  => '150 gram / bungkus',
                    'Bahan Utama'   => 'Singkong lokal organik',
                    'Ukuran'        => 'Besar (Ø 20 cm) / Mini',
                    'Masa Simpan'   => '3 bulan (kemasan tertutup)',
                    'Ketersediaan'  => 'Tersedia, pengiriman 1–2 hari',
                ],
                'is_active'   => true,
                'urutan'      => 6,
            ],
            [
                'slug'        => 'opak-pedas-ibu-tini',
                'title'       => 'Opak Pedas Ibu Tini',
                'producer'    => 'Kelompok Usaha Ibu Tini',
                'price'       => 'Rp 13.000 / bks',
                'badge'       => 'Makanan',
                'jenis'       => 'opak',
                'jenis_label' => 'Opak',
                'category'    => ['makanan'],
                'img'         => 'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?auto=format&fit=crop&w=1200&q=80',
                'desc_short'  => 'Opak pedas varian baru khas Ibu Tini, berbumbu cabai rawit segar. Favorit para muda-mudi desa!',
                'desc_long'   => 'Ibu Tini bersama kelompok usaha ibu-ibu RT 04 berinovasi membuat opak tradisional dengan sentuhan modern: varian rasa pedas menggunakan cabai rawit merah segar yang digiling halus. Rasanya menggigit di lidah namun tetap terasa rempah tradisionalnya. Produk ini menjadi favorit generasi muda dan sering dipesan sebagai oleh-oleh khas Desa Jambelaer. Setiap bungkus dikemas rapi dengan label produk yang menarik.',
                'details'     => [
                    'Berat Bersih'  => '180 gram / bungkus',
                    'Varian Rasa'   => 'Pedas Original, Super Pedas',
                    'Bahan Utama'   => 'Singkong + Cabai Rawit Merah Segar',
                    'Masa Simpan'   => '2 bulan',
                    'Ketersediaan'  => 'Tersedia, siap kirim',
                ],
                'is_active'   => true,
                'urutan'      => 7,
            ],
        ];

        foreach ($produk as $p) {
            Produk::updateOrCreate(['slug' => $p['slug']], $p);
        }

        // ── Pengaturan Desa ──────────────────────────────────────────────────
        $settings = [
            ['key' => 'desa_nama',         'value' => 'Desa Jambelaer',            'label' => 'Nama Desa',              'group' => 'identitas'],
            ['key' => 'desa_kecamatan',    'value' => 'Dawuan',                    'label' => 'Kecamatan',              'group' => 'identitas'],
            ['key' => 'desa_kabupaten',    'value' => 'Subang',                    'label' => 'Kabupaten',              'group' => 'identitas'],
            ['key' => 'desa_provinsi',     'value' => 'Jawa Barat',               'label' => 'Provinsi',               'group' => 'identitas'],
            ['key' => 'desa_kodepos',      'value' => '41270',                     'label' => 'Kode Pos',               'group' => 'identitas'],
            ['key' => 'desa_alamat',       'value' => 'Jl. Raya Jambelaer No. 12, Dawuan, Subang', 'label' => 'Alamat', 'group' => 'identitas'],
            ['key' => 'desa_telepon',      'value' => '(0260) 123456',             'label' => 'Nomor Telepon',          'group' => 'kontak'],
            ['key' => 'desa_email',        'value' => 'info@jambelaer-subang.desa.id', 'label' => 'Email Resmi',       'group' => 'kontak'],
            ['key' => 'desa_jam_buka',     'value' => 'Senin – Jumat: 08:00 – 15:30 WIB', 'label' => 'Jam Operasional','group' => 'kontak'],
            ['key' => 'stat_luas',         'value' => '2.500,366',                 'label' => 'Luas Wilayah (Ha)',      'group' => 'statistik'],
            ['key' => 'stat_penduduk',     'value' => '4850',                      'label' => 'Jumlah Penduduk (Jiwa)', 'group' => 'statistik'],
            ['key' => 'stat_umkm',         'value' => '35',                        'label' => 'Pelaku UMKM',            'group' => 'statistik'],
            ['key' => 'sosmed_instagram',  'value' => '#',                         'label' => 'Instagram Desa',         'group' => 'sosmed'],
            ['key' => 'sosmed_youtube',    'value' => '#',                         'label' => 'YouTube Desa',           'group' => 'sosmed'],
        ];

        foreach ($settings as $s) {
            Pengaturan::updateOrCreate(['key' => $s['key']], $s);
        }

        // ── Budaya ──────────────────────────────────────────────────────────
        $budayas = [
            [
                'title'    => 'Ruwatan Bumi (Hajat Bumi)',
                'kategori' => 'Upacara Adat',
                'excerpt'  => 'Upacara adat tanda syukur hasil bumi pertanian desa yang melimpah.',
                'desc'     => 'Tradisi Ruwatan Bumi (atau Hajat Bumi) diadakan setahun sekali setelah panen raya sebagai wujud syukur masyarakat Desa Jambelaer kepada Tuhan Yang Maha Esa atas kelimpahan hasil bumi pertanian. Upacara adat diisi dengan mengarak tumpeng besar, doa bersama para sepuh desa, pagelaran wayang golek, serta saling bertukar hidangan makanan antar tetangga untuk mempererat silaturahmi gotong royong.',
                'img'      => 'https://images.unsplash.com/photo-1530595467537-0b5996c41f2d?auto=format&fit=crop&w=800&q=80',
                'urutan'   => 1,
            ],
            [
                'title'    => 'Kesenian Sisingaan',
                'kategori' => 'Seni Pertunjukan',
                'excerpt'  => 'Atraksi budaya khas Subang pemacu semangat kebersamaan rakyat.',
                'desc'     => 'Kesenian Sisingaan adalah pertunjukan boneka singa raksasa khas Kabupaten Subang yang ditunggangi anak-anak lalu diusung oleh para pemuda gagah sambil menari mengikuti irama tabuhan kendang pencak silat. Pertunjukan ini sering dijumpai dalam upacara khitanan anak atau perayaan hari besar desa (Milangkala), melambangkan semangat persatuan, patriotisme, dan sukacita kebersamaan warga.',
                'img'      => 'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?auto=format&fit=crop&w=800&q=80',
                'urutan'   => 2,
            ],
            [
                'title'    => 'Pencak Silat Tradisional',
                'kategori' => 'Seni Bela Diri',
                'excerpt'  => 'Pelatihan fisik dan spiritual bela diri Sunda yang menjunjung persaudaraan.',
                'desc'     => 'Sebagai bentuk pelestarian bela diri warisan Sunda, Desa Jambelaer memiliki padepokan pencak silat lokal tempat berkumpulnya pemuda untuk melatih ketahanan fisik, konsentrasi mental, dan kehalusan budi pekerti. Dengan iringan musik terompet Sunda dan kendang, gerakan jurus silat diperagakan dalam pergelaran milangkala desa.',
                'img'      => 'https://images.unsplash.com/photo-1555597673-b21d5c935865?auto=format&fit=crop&w=800&q=80',
                'urutan'   => 3,
            ],
            [
                'title'    => 'Milangkala & Karnaval Desa',
                'kategori' => 'Festival Tahunan',
                'excerpt'  => 'Peringatan hari lahir desa yang diramaikan pawai budaya kreasi warga.',
                'desc'     => 'Milangkala atau hari jadi Desa Jambelaer dirayakan meriah setiap tahun dengan karnaval budaya. Setiap dusun bergotong royong membuat hiasan replika hasil bumi, memakai pakaian adat sunda pengantin atau kebaya, serta memamerkan kesenian kreasi masing-masing dusun dalam parade keliling sepanjang jalan desa.',
                'img'      => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=800&q=80',
                'urutan'   => 4,
            ],
            [
                'title'    => 'Musik Tradisional Tutunggulan',
                'kategori' => 'Musik Tradisional',
                'excerpt'  => 'Seni menabuh lesung padi tradisional menghasilkan harmoni ritmis yang indah.',
                'desc'     => 'Musik Tradisional Tutunggulan adalah kesenian musik tradisional khas Jawa Barat berupa ketukan ritmis dari benturan alu dan lesung kayu pembumbung padi. Dulu digunakan sebagai penanda waktu panen atau pesta rakyat, kini dilestarikan sebagai wujud kebersamaan, gotong royong, serta ungkapan rasa syukur masyarakat agraris atas melimpahnya hasil pertanian desa.',
                'img'      => 'https://images.unsplash.com/photo-1465847899084-d164df4dedc6?auto=format&fit=crop&w=800&q=80',
                'urutan'   => 5,
            ],
            [
                'title'    => 'Kridatani',
                'kategori' => 'Tari Tradisional',
                'excerpt'  => 'Tarian kolosal petani Sunda yang melambangkan kemandirian pangan desa.',
                'desc'     => 'Kridatani merupakan seni tari tradisional yang secara filosofis menggambarkan gerak gerik petani Sunda mulai dari mengolah sawah, menanam padi, merawat tanaman, hingga memanen bersama-sama. Tarian ini dimainkan secara berkelompok dengan iringan kendang dan suling Sunda, melambangkan etos kerja tinggi, kemandirian pangan, serta rasa syukur agraris.',
                'img'      => 'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?auto=format&fit=crop&w=800&q=80',
                'urutan'   => 6,
            ],
            [
                'title'    => 'Musik Marawis',
                'kategori' => 'Seni Religi',
                'excerpt'  => 'Seni rebana dengan perpaduan selawat dan tabuhan perkusi rohani islami.',
                'desc'     => 'Musik Marawis adalah salah satu kesenian islami bernuansa rohani agung yang memadukan lagu pujian selawat kepada Nabi Muhammad SAW dengan ketukan ritmis dari seperangkat instrumen perkusi tradisional (hajir, marawis, dumbuk). Kesenian rohani ini tumbuh subur di tengah pemuda-pemudi Desa Jambelaer dan selalu tampil memeriahkan hari-hari besar keagamaan islam di desa.',
                'img'      => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=800&q=80',
                'urutan'   => 7,
            ]
        ];

        foreach ($budayas as $b) {
            Budaya::updateOrCreate(['title' => $b['title']], $b);
        }

        // ── Berita Desa ──────────────────────────────────────────────────────
        $beritaList = [
            [
                'judul'        => 'Pemerintah Desa Jambelaer Luncurkan Portal Informasi Resmi Berbasis Digital',
                'slug'         => 'pemerintah-desa-jambelaer-luncurkan-portal-informasi-resmi-berbasis-digital',
                'kategori'     => 'pemerintahan',
                'ringkasan'    => 'Peluncuran website desa untuk mempermudah akses informasi publik, promosi UMKM lokal, dan jadwal kegiatan warga.',
                'konten'       => 'Pemerintah Desa Jambelaer, Kecamatan Dawuan, Kabupaten Subang secara resmi meluncurkan portal informasi desa berbasis digital. Website ini dirancang untuk memudahkan warga masyarakat dan publik luas dalam mengakses profil desa, informasi layanan publik, promosi produk unggulan UMKM, hingga agenda kebudayaan lokal. Kepala Desa berharap inovasi digital ini dapat mendorong keterbukaan informasi publik dan memajukan perekonomian warga desa.',
                'gambar'       => 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&w=1200&q=80',
                'penulis'      => 'Admin Desa',
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'judul'        => 'Pelatihan Pembinaan UMKM Dan Inovasi Kemasan Produk Olahan Pangan Desa',
                'slug'         => 'pelatihan-pembinaan-umkm-dan-inovasi-kemasan-produk-olahan-pangan-desa',
                'kategori'     => 'kegiatan_warga',
                'ringkasan'    => 'Para pelaku UMKM Desa Jambelaer mengikuti pelatihan pembinaan desain kemasan dan strategi pemasaran digital.',
                'konten'       => 'Guna meningkatkan daya saing produk lokal seperti opak singkong, keripik, dan gula aren, Pemerintah Desa Jambelaer menggelar pelatihan pembinaan UMKM. Acara ini dihadiri puluhan pengrajin makanan tradisional dan produsen lokal. Dalam kesempatan ini, peserta mendapatkan bimbingan mengenai pembuatan kemasan higienis berstandar P-IRT serta pemanfaatan e-commerce.',
                'gambar'       => 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?auto=format&fit=crop&w=1200&q=80',
                'penulis'      => 'Tim Redaksi Desa',
                'is_published' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'judul'        => 'Pembangunan Saluran Irigasi Pertanian Dusun III Selesai Dikerjakan',
                'slug'         => 'pembangunan-saluran-irigasi-pertanian-dusun-iii-selesai-dikerjakan',
                'kategori'     => 'pembangunan',
                'ringkasan'    => 'Fasilitas irigasi sawah sepanjang 450 meter kini siap mengairi puluhan hektar lahan pertanian warga.',
                'konten'       => 'Pembangunan saluran irigasi beton di Dusun III Desa Jambelaer telah rampung 100%. Saluran irigasi sepanjang 450 meter ini didanai melalui program alokasi dana desa tahun berjalan. Dengan selesainya irigasi ini, pasokan air menuju lahan persawahan warga dipastikan lancar sehingga diharapkan mampu meningkatkan produktivitas hasil panen padi organik lokal.',
                'gambar'       => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=1200&q=80',
                'penulis'      => 'Kasi Pembangunan',
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ],
        ];

        foreach ($beritaList as $br) {
            Berita::updateOrCreate(['slug' => $br['slug']], $br);
        }

        // ── Wisata ──────────────────────────────────────────────────────────
        $wisataList = [
            [
                'nama'             => 'Curug Cipeuteuy',
                'slug'             => 'curug-cipeuteuy',
                'kategori'         => 'alam',
                'ringkasan'        => 'Air terjun alami dengan air pegunungan yang sangat jernih dan dikelilingi hutan pinus yang asri.',
                'deskripsi'        => "Curug Cipeuteuy adalah salah satu permata tersembunyi Desa Jambelaer yang menawarkan keindahan air terjun alami setinggi kurang lebih 15 meter. Air yang mengalir berasal langsung dari sumber mata air pegunungan Subang yang bersih dan jernih sepanjang tahun.\n\nLokasinya yang masih asri dikelilingi pepohonan pinus dan rerumputan hijau menjadikan suasana di sekitar curug sangat sejuk dan menyegarkan. Pengunjung dapat menikmati pemandangan alam, berendam di kolam alami, atau sekadar berfoto dengan latar belakang air terjun yang indah.\n\nUntuk mencapai curug, pengunjung perlu berjalan kaki sekitar 20–30 menit menyusuri jalan setapak di antara kebun dan hutan kecil. Pemandu lokal tersedia bagi yang membutuhkan panduan perjalanan.",
                'alamat'           => 'Dusun Cikondang, Desa Jambelaer',
                'maps_iframe'      => null,
                'gambar'           => 'https://images.unsplash.com/photo-1546182990-dffeafbe841d?auto=format&fit=crop&w=1200&q=80',
                'harga_tiket'      => 'Rp 10.000',
                'jam_operasional'  => '08:00 - 17:00 WIB',
                'urutan'           => 1,
                'is_active'        => true,
            ],
            [
                'nama'             => 'Perkebunan Teh Hijau',
                'slug'             => 'perkebunan-teh-hijau',
                'kategori'         => 'alam',
                'ringkasan'        => 'Hamparan bukit kebun teh hijau yang menyejukkan mata dengan udara pagi yang sangat segar dan pemandangan indah.',
                'deskripsi'        => "Perkebunan Teh Hijau Jambelaer membentang luas di lereng bukit desa dengan panorama berbukit-bukit yang memesona. Hamparan tanaman teh yang tertata rapi menjadi latar belakang foto yang sangat populer di kalangan wisatawan alam.\n\nPada pagi hari, kabut tipis menyelimuti perkebunan menciptakan suasana yang magis dan romantis. Pengunjung dapat menyaksikan langsung proses petik teh oleh para petani lokal, belajar cara penyortiran daun teh, hingga mencicipi teh hijau segar yang baru dipetik.\n\nKawasan perkebunan juga menyediakan jalur trekking ringan yang cocok untuk keluarga. Warung kecil di pinggir kebun menjual minuman teh hangat dan camilan tradisional.",
                'alamat'           => 'Dusun Babakan, Desa Jambelaer',
                'maps_iframe'      => null,
                'gambar'           => 'https://images.unsplash.com/photo-1555899434-94d1368aa7af?auto=format&fit=crop&w=1200&q=80',
                'harga_tiket'      => 'Gratis',
                'jam_operasional'  => '24 Jam',
                'urutan'           => 2,
                'is_active'        => true,
            ],
            [
                'nama'             => 'Kampung Restorasi Budaya',
                'slug'             => 'kampung-restorasi-budaya',
                'kategori'         => 'budaya',
                'ringkasan'        => 'Pusat pelestarian adat istiadat, kerajinan anyaman bambu, dan pertunjukan seni musik tradisional Sunda.',
                'deskripsi'        => "Kampung Restorasi Budaya adalah inisiatif warga Desa Jambelaer untuk melestarikan kekayaan budaya dan tradisi leluhur Sunda yang mulai tergerus zaman. Di sini, pengunjung dapat menyaksikan dan belajar langsung berbagai kesenian tradisional.\n\nKegiatannya meliputi workshop anyaman bambu oleh pengrajin sepuh, pertunjukan tari jaipongan, musik degung dan kecapi suling, serta pengenalan upacara adat Sunda seperti Mapag Sri dan Ruwatan Bumi.\n\nPengunjung juga dapat mencicipi kuliner tradisional Sunda yang dimasak menggunakan tungku kayu bakar, seperti nasi liwet, lalapan segar, dan sambal terasi khas desa. Tersedia paket kunjungan rombongan untuk sekolah dan instansi.",
                'alamat'           => 'Kampung Gede, Desa Jambelaer',
                'maps_iframe'      => null,
                'gambar'           => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=1200&q=80',
                'harga_tiket'      => 'Sukarela',
                'jam_operasional'  => '09:00 - 16:00 WIB',
                'urutan'           => 3,
                'is_active'        => true,
            ],
            [
                'nama'             => 'Sawah Terasering Indah',
                'slug'             => 'sawah-terasering-indah',
                'kategori'         => 'alam',
                'ringkasan'        => 'Pemandangan sawah terasering berlapis yang memesona, sangat indah saat pagi hari dengan latar pegunungan.',
                'deskripsi'        => "Sawah Terasering Indah Jambelaer adalah salah satu spot fotografi terbaik yang dimiliki desa. Petak-petak sawah yang tertata berlapis mengikuti kontur bukit menciptakan pola geometris alami yang sangat memukau, terutama saat padi sedang menghijau atau menguning.\n\nMoment terbaik mengunjungi lokasi ini adalah saat pagi hari ketika matahari terbit menyinari hamparan sawah dan pegunungan di kejauhan. Kabut pagi yang menggantung rendah menambah nuansa dramatis dan puitis.\n\nPetani setempat dengan senang hati berbagi cerita tentang sistem pertanian organik tradisional yang telah diwariskan turun-temurun. Pengunjung juga dapat mencoba pengalaman membajak sawah dengan cara tradisional.",
                'alamat'           => 'Dusun Ciawi, Desa Jambelaer',
                'maps_iframe'      => null,
                'gambar'           => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?auto=format&fit=crop&w=1200&q=80',
                'harga_tiket'      => 'Gratis',
                'jam_operasional'  => '06:00 - 18:00 WIB',
                'urutan'           => 4,
                'is_active'        => true,
            ],
            [
                'nama'             => 'Warung Kuliner Tradisional',
                'slug'             => 'warung-kuliner-tradisional',
                'kategori'         => 'kuliner',
                'ringkasan'        => 'Menikmati cita rasa masakan khas Sunda otentik dengan bahan-bahan segar langsung dari ladang dan kebun warga desa.',
                'deskripsi'        => "Wisata kuliner di Desa Jambelaer mengajak pengunjung merasakan kenikmatan masakan Sunda otentik yang dimasak langsung menggunakan bahan-bahan segar dari kebun dan ladang warga desa.\n\nMenu unggulan yang wajib dicoba antara lain: nasi liwet kukus dalam dandang bambu, pepes ikan mas bumbu rempah lokal, sayur asem segar dengan belimbing wuluh, lalapan aneka daun segar disertai sambal terasi bakar, hingga minuman tradisional seperti bandrek jahe dan bajigur aren.\n\nSuasana makan di pondok bambu di tepi sawah dengan pemandangan alam terbuka menjadi pengalaman tersendiri yang tak terlupakan. Tersedia paket makan keluarga dan rombongan dengan harga terjangkau.",
                'alamat'           => 'Pusat Desa Jambelaer',
                'maps_iframe'      => null,
                'gambar'           => 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?auto=format&fit=crop&w=1200&q=80',
                'harga_tiket'      => 'Mulai Rp 25.000',
                'jam_operasional'  => '07:00 - 20:00 WIB',
                'urutan'           => 5,
                'is_active'        => true,
            ],
        ];

        foreach ($wisataList as $w) {
            Wisata::updateOrCreate(['slug' => $w['slug']], $w);
        }
    }
}

