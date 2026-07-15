<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Produk;
use App\Models\Pengaturan;
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
            ['key' => 'desa_whatsapp',     'value' => '+62 812-3456-7890',         'label' => 'WhatsApp',               'group' => 'kontak'],
            ['key' => 'desa_email',        'value' => 'info@jambelaer-subang.desa.id', 'label' => 'Email Resmi',       'group' => 'kontak'],
            ['key' => 'desa_jam_buka',     'value' => 'Senin – Jumat: 08:00 – 15:30 WIB', 'label' => 'Jam Operasional','group' => 'kontak'],
            ['key' => 'stat_luas',         'value' => '1240',                      'label' => 'Luas Wilayah (Ha)',      'group' => 'statistik'],
            ['key' => 'stat_penduduk',     'value' => '4850',                      'label' => 'Jumlah Penduduk (Jiwa)', 'group' => 'statistik'],
            ['key' => 'stat_umkm',         'value' => '35',                        'label' => 'Pelaku UMKM',            'group' => 'statistik'],
            ['key' => 'facebook_url',      'value' => '#',                         'label' => 'URL Facebook',           'group' => 'sosmed'],
            ['key' => 'instagram_url',     'value' => '#',                         'label' => 'URL Instagram',          'group' => 'sosmed'],
            ['key' => 'youtube_url',       'value' => '#',                         'label' => 'URL YouTube',            'group' => 'sosmed'],
            
            // Tentang Kami
            ['key' => 'kades_nama',        'value' => 'Bapak Dedi Suherman, S.E.', 'label' => 'Nama Kepala Desa',       'group' => 'tentang'],
            ['key' => 'kades_jabatan',     'value' => 'Kepala Desa Jambelaer',     'label' => 'Jabatan Kepala Desa',    'group' => 'tentang'],
            ['key' => 'kades_foto',        'value' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=600&h=600&q=80', 'label' => 'URL Foto Kepala Desa', 'group' => 'tentang'],
            ['key' => 'kades_sambutan_1',  'value' => 'Sampurasun, salam sejahtera bagi kita semua. Sebagai Kepala Desa Jambelaer, saya menyambut baik kehadiran portal resmi ini. Website ini merupakan wujud keterbukaan informasi publik dan media komunikasi terpadu untuk memperkenalkan kekayaan alam, kearifan lokal, dan kreasi produk UMKM warga kami.', 'label' => 'Sambutan Paragraf 1', 'group' => 'tentang'],
            ['key' => 'kades_sambutan_2',  'value' => 'Desa Jambelaer dikaruniai tanah Dawuan yang subur, budaya yang terus dijaga kelestariannya, serta masyarakat wirausaha yang gigih. Melalui platform digital ini, kami membuka pintu kolaborasi dan kemitraan seluas-luasnya dengan pihak luar untuk memajukan perekonomian desa.', 'label' => 'Sambutan Paragraf 2', 'group' => 'tentang'],
            ['key' => 'kades_motto',       'value' => 'Melayani dengan Amanah, Terbuka, dan Transparan.', 'label' => 'Slogan / Motto Melayani', 'group' => 'tentang'],
            ['key' => 'visi_text',         'value' => 'Mewujudkan Desa Jambelaer yang Mandiri, Sejahtera, Berbasis Pertanian Berkelanjutan, dan Teguh Memegang Nilai Budaya Siliwangi pada Tahun 2030.', 'label' => 'Teks Visi', 'group' => 'tentang'],
            ['key' => 'visi_desc',         'value' => 'Visi ini menjadi arah pembangunan desa kami dalam mengoptimalkan potensi bumi, memberdayakan sumber daya manusia, dan menciptakan tata kelola pemerintahan desa yang bersih dan akuntabel.', 'label' => 'Deskripsi Visi', 'group' => 'tentang'],
            ['key' => 'misi_list',         'value' => "Meningkatkan produktivitas pertanian melalui modernisasi alat ramah lingkungan dan pendampingan intensif bagi kelompok tani.\nMendorong pertumbuhan UMKM desa melalui program digitalisasi pemasaran dan penyediaan akses permodalan bergulir.\nMelestarikan kesenian daerah Sunda dan tradisi Ruwatan Bumi sebagai benteng identitas dan daya tarik pariwisata budaya desa.\nMenyelenggarakan pelayanan administrasi desa yang cepat, ramah, digital, tanpa diskriminasi melalui inovasi e-Office Desa.", 'label' => 'Daftar Misi (Satu Per Baris)', 'group' => 'tentang'],
            ['key' => 'tentang_geo',       'value' => 'Desa Jambelaer terletak di Kecamatan Dawuan, Kabupaten Subang, Provinsi Jawa Barat.', 'label' => 'Deskripsi Letak Geografis', 'group' => 'tentang'],
            ['key' => 'tentang_potensi',   'value' => 'Lahan persawahan yang produktif menjadi tulang punggung perekonomian desa bersama industri UMKM rumahan dan kerajinan bambu.', 'label' => 'Deskripsi Potensi Utama', 'group' => 'tentang'],
            ['key' => 'tentang_admin',     'value' => 'Salah satu dari 10 desa di bawah Kecamatan Dawuan dengan pemerintahan yang aktif dan transparan.', 'label' => 'Deskripsi Administrasi', 'group' => 'tentang'],
        ];

        foreach ($settings as $s) {
            Pengaturan::updateOrCreate(['key' => $s['key']], $s);
        }
    }
}
