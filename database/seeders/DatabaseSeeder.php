<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Produk;
use App\Models\Pengaturan;
use App\Models\Budaya;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
                'badge'      => 'Pertanian',
                'category'   => ['pertanian', 'makanan'],
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
                'badge'       => 'Pertanian',
                'category'    => ['pertanian'],
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
            ['key' => 'instagram_url',     'value' => '#',                         'label' => 'URL Instagram',          'group' => 'sosmed'],
            ['key' => 'youtube_url',       'value' => '#',                         'label' => 'URL YouTube',            'group' => 'sosmed'],
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
    }
}
