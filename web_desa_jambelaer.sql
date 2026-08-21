-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 21, 2026 at 10:58 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_desa_jambelaer`
--

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `berita_id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `kategori` varchar(255) NOT NULL DEFAULT 'pengumuman',
  `ringkasan` text DEFAULT NULL,
  `konten` longtext NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `penulis` varchar(255) NOT NULL DEFAULT 'Admin Desa',
  `views` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `berita`
--

INSERT INTO `berita` (`berita_id`, `judul`, `slug`, `kategori`, `ringkasan`, `konten`, `gambar`, `penulis`, `views`, `is_published`, `published_at`, `created_at`, `updated_at`) VALUES
(4, 'Mahasiswa KKN Universitas Subang Dorong Pengembangan UMKM Opak Desa Jambelaer melalui Inovasi Pemasaran dan Branding Produk', 'mahasiswa-kkn-universitas-subang-dorong-pengembangan-umkm-opak-desa-jambelaer-melalui-inovasi-pemasaran-dan-branding-produk', 'umum', 'Mahasiswa Kuliah Kerja Nyata (KKN) Universitas Subang melaksanakan program pendampingan UMKM Opak di Desa Jambelaer, Kecamatan Dawuan, Kabupaten Subang. Program ini bertujuan membantu pelaku usaha meningkatkan daya saing produk melalui pengembangan branding, pemasaran digital, serta peningkatan kualitas kemasan agar mampu menjangkau pasar yang lebih luas.', 'Mahasiswa Kuliah Kerja Nyata (KKN) Universitas Subang melaksanakan program pemberdayaan masyarakat dengan membantu pengembangan Usaha Mikro, Kecil, dan Menengah (UMKM) Opak yang berada di Desa Jambelaer, Kecamatan Dawuan, Kabupaten Subang. Kegiatan ini merupakan salah satu bentuk pengabdian kepada masyarakat yang bertujuan mendukung pertumbuhan ekonomi desa melalui penguatan sektor usaha lokal.\r\n\r\nOpak merupakan salah satu makanan tradisional yang telah lama diproduksi oleh masyarakat Desa Jambelaer. Produk ini memiliki cita rasa khas dan menjadi salah satu potensi unggulan desa yang berpeluang untuk berkembang lebih luas. Namun, masih terdapat beberapa kendala yang dihadapi pelaku UMKM, seperti keterbatasan promosi, desain kemasan yang sederhana, serta minimnya pemanfaatan teknologi digital dalam pemasaran produk.\r\n\r\nMelihat potensi dan tantangan tersebut, mahasiswa KKN Universitas Subang berinisiatif memberikan pendampingan kepada pelaku UMKM Opak melalui berbagai program kerja. Kegiatan yang dilakukan meliputi identifikasi kebutuhan usaha, pemberian edukasi mengenai pemasaran digital, pembuatan konten promosi, serta pengembangan identitas produk melalui desain logo dan kemasan yang lebih menarik.\r\n\r\nSelain itu, mahasiswa juga membantu memperkenalkan produk Opak Desa Jambelaer melalui media sosial sebagai sarana promosi yang efektif dan berbiaya rendah. Dengan memanfaatkan platform digital, diharapkan produk lokal desa dapat dikenal oleh masyarakat yang lebih luas, tidak hanya di wilayah Subang tetapi juga di luar daerah.\r\n\r\nKetua Kelompok KKN Universitas Subang menyampaikan bahwa program ini bertujuan untuk meningkatkan nilai jual produk sekaligus mendorong kemandirian ekonomi masyarakat desa. Menurutnya, UMKM memiliki peran penting sebagai penggerak ekonomi lokal sehingga perlu mendapatkan dukungan dan pendampingan yang berkelanjutan.\r\n\r\nPelaku UMKM Opak Desa Jambelaer menyambut baik kegiatan tersebut dan berharap ilmu serta inovasi yang diberikan dapat membantu meningkatkan penjualan produk mereka. Mereka juga mengapresiasi keterlibatan mahasiswa yang telah memberikan berbagai ide kreatif dalam pengembangan usaha.\r\n\r\nMelalui kolaborasi antara mahasiswa, pemerintah desa, dan pelaku UMKM, diharapkan produk Opak Desa Jambelaer dapat terus berkembang dan menjadi salah satu produk unggulan yang mampu meningkatkan kesejahteraan masyarakat. Kegiatan ini sekaligus menjadi bukti nyata kontribusi mahasiswa Universitas Subang dalam mendukung pembangunan desa dan pemberdayaan ekonomi masyarakat melalui program Kuliah Kerja Nyata.', 'berita/5DSOQ1GjXdCmZ8712JAnV9ax79yHdRGRDK8mTBEs.jpg', 'Admin Desa Jambelaer', 17, 1, '2026-07-28 19:24:30', '2026-07-28 19:24:30', '2026-08-21 04:50:23');

-- --------------------------------------------------------

--
-- Table structure for table `budaya`
--

CREATE TABLE `budaya` (
  `budaya_id` bigint(20) UNSIGNED NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `excerpt` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `urutan` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `budaya`
--

INSERT INTO `budaya` (`budaya_id`, `kategori`, `title`, `slug`, `excerpt`, `desc`, `img`, `urutan`, `created_at`, `updated_at`) VALUES
(1, 'Upacara Adat', 'Ruwatan Bumi (Hajat Bumi)', 'ruwatan-bumi-hajat-bumi', 'Upacara adat tanda syukur hasil bumi pertanian desa yang melimpah.', 'Tradisi Ruwatan Bumi (atau Hajat Bumi) diadakan setahun sekali setelah panen raya sebagai wujud syukur masyarakat Desa Jambelaer kepada Tuhan Yang Maha Esa atas kelimpahan hasil bumi pertanian. Upacara adat diisi dengan mengarak tumpeng besar, doa bersama para sepuh desa, pagelaran wayang golek, serta saling bertukar hidangan makanan antar tetangga untuk mempererat silaturahmi gotong royong.', '/uploads/budaya/budaya_1785592627_6a6dfb33c94c1.jpg', 1, '2026-07-20 17:41:24', '2026-08-21 04:35:30'),
(5, 'Upacara Adat', 'Musik Tradisional Tutunggulan', 'musik-tradisional-tutunggulan', 'Seni menabuh lesung padi tradisional menghasilkan harmoni ritmis yang indah.', 'Tutunggulan adalah salah satu kesenian musik tradisional khas Sunda yang menggunakan alat musik berbahan dasar bambu. Alat musik ini dimainkan dengan cara dipukul sehingga menghasilkan irama yang harmonis dan penuh semangat. Dahulu, bunyi tutunggulan digunakan sebagai sarana komunikasi masyarakat, seperti mengumpulkan warga atau memberikan tanda pada saat-saat tertentu. Seiring perkembangan zaman, Tutunggulan berkembang menjadi pertunjukan seni yang ditampilkan dalam berbagai acara adat, peringatan hari besar, festival budaya, hingga penyambutan tamu kehormatan.\r\n\r\nDi Desa Jambelaer, kesenian Tutunggulan menjadi salah satu warisan budaya yang terus dijaga dan dilestarikan oleh masyarakat. Berbagai generasi, mulai dari para pelaku seni hingga generasi muda, aktif mengikuti latihan dan pementasan sebagai bentuk upaya mempertahankan identitas budaya lokal. Melalui pelestarian Tutunggulan, masyarakat Desa Jambelaer tidak hanya menjaga tradisi leluhur, tetapi juga memperkenalkan kekayaan budaya daerah kepada masyarakat luas sebagai aset budaya yang bernilai sejarah, edukasi, dan pariwisata.', '/uploads/budaya/budaya_1785592504_6a6dfab8a22e4.jpeg', 3, '2026-07-20 17:41:24', '2026-08-21 04:35:30'),
(11, 'Festival Tahunan', 'Milangkala & Karnaval Desa', 'milangkala-karnaval-desa', 'Peringatan hari lahir desa yang diramaikan pawai budaya kreasi warga.', 'Milangkala atau hari jadi Desa Jambelaer dirayakan meriah setiap tahun dengan karnaval budaya. Setiap dusun bergotong royong membuat hiasan replika hasil bumi, memakai pakaian adat sunda pengantin atau kebaya, serta memamerkan kesenian kreasi masing-masing dusun dalam parade keliling sepanjang jalan desa.', '/uploads/budaya/budaya_1785592665_6a6dfb59670e5.jpeg', 2, '2026-07-28 18:11:57', '2026-08-21 04:35:30');

-- --------------------------------------------------------

--
-- Table structure for table `galeri`
--

CREATE TABLE `galeri` (
  `galeri_id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `kategori` enum('kegiatan_desa','acara_desa','umkm','budaya_desa','dokumentasi') NOT NULL DEFAULT 'kegiatan_desa',
  `foto` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `tanggal_publikasi` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `galeri`
--

INSERT INTO `galeri` (`galeri_id`, `judul`, `slug`, `kategori`, `foto`, `deskripsi`, `tanggal_publikasi`, `is_active`, `urutan`, `created_at`, `updated_at`) VALUES
(1, 'Kegiatan Musik Tutunggulan', 'kegiatan-musik-tutunggulan', 'budaya_desa', '/uploads/galeri/1785592299_kegiatan-musik-tutunggulan.png', 'Mahasiswa KKN Universitas Subang bersama masyarakat Desa Jambelaer mengikuti latihan Musik Tutunggulan sebagai upaya melestarikan kesenian tradisional yang menjadi bagian dari identitas budaya desa. Melalui kegiatan latihan bersama ini, mahasiswa memperoleh pengalaman langsung dalam mengenal teknik memainkan alat musik tradisional sekaligus mempererat hubungan dengan masyarakat. Kegiatan ini diharapkan dapat menumbuhkan kepedulian generasi muda terhadap pelestarian budaya lokal agar tetap lestari dan dikenal oleh masyarakat luas.', '2026-07-24', 1, 1, '2026-07-23 23:34:10', '2026-08-01 13:53:40');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '2024_01_01_000010_create_produk_table', 1),
(3, '2024_01_01_000011_create_pesan_table', 1),
(4, '2024_01_01_000012_create_pengaturan_table', 1),
(5, '2024_01_01_000013_create_struktur_desa_table', 1),
(6, '2024_01_01_000014_create_budaya_table', 1),
(7, '2024_01_01_000015_add_jenis_to_produk_table', 1),
(8, '2024_12_20_add_jenis_pesan_columns', 1),
(9, '2024_12_20_add_status_to_pesan_table', 1),
(10, '2026_07_21_000001_add_new_settings_to_pengaturan', 2),
(11, '2026_07_21_000002_create_galeri_table', 2),
(12, '2026_07_21_000003_add_detail_fields_to_produk_table', 2),
(13, '2026_07_25_000001_remove_tentang_group_from_pengaturan', 3),
(14, '2026_07_25_000002_remove_facebook_from_pengaturan', 4),
(15, '2026_07_25_000003_remove_whatsapp_desa_from_pengaturan', 5),
(16, '2026_07_27_000001_create_berita_table', 6),
(17, '2026_07_29_000001_add_sambutan_settings_to_pengaturan', 7),
(18, '2026_07_29_000002_fix_sosmed_settings_keys', 8),
(19, '2026_07_31_000001_create_wisata_table', 9),
(20, '2026_08_05_113605_add_foto_bukti_to_pesan_table', 10),
(21, '2026_08_06_113936_add_is_archived_to_pesan_table', 10),
(22, '2026_08_09_add_daftar_umkm_to_pesan_table', 11),
(23, '2026_08_09_add_dokumen_lampiran_to_pesan_table', 12),
(24, '2026_08_10_add_umkm_extra_fields_to_pesan_table', 13),
(25, '2026_08_10_add_isi_produk_umkm_to_pesan_table', 14),
(26, '2026_08_18_000001_add_slug_to_budaya_table', 15),
(27, '2026_08_21_000001_add_slug_to_galeri_table', 15),
(28, '2026_08_21_120000_add_user_id_to_pesan_table', 16),
(29, '2026_08_21_120001_add_pesan_id_to_produk_table', 16),
(30, '2026_08_21_130000_rename_primary_keys_to_custom_id_format', 17);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan`
--

CREATE TABLE `pengaturan` (
  `pengaturan_id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `group` varchar(255) NOT NULL DEFAULT 'umum',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengaturan`
--

INSERT INTO `pengaturan` (`pengaturan_id`, `key`, `value`, `label`, `group`, `created_at`, `updated_at`) VALUES
(1, 'desa_nama', 'Desa Jambelaer', 'Nama Desa', 'identitas', '2026-07-20 17:01:23', '2026-07-20 17:01:23'),
(2, 'desa_kecamatan', 'Dawuan', 'Kecamatan', 'identitas', '2026-07-20 17:01:23', '2026-07-20 17:01:23'),
(3, 'desa_kabupaten', 'Subang', 'Kabupaten', 'identitas', '2026-07-20 17:01:23', '2026-07-20 17:01:23'),
(4, 'desa_provinsi', 'Jawa Barat', 'Provinsi', 'identitas', '2026-07-20 17:01:23', '2026-07-20 17:01:23'),
(5, 'desa_kodepos', '41270', 'Kode Pos', 'identitas', '2026-07-20 17:01:23', '2026-07-20 17:01:23'),
(6, 'desa_alamat', 'Jl. Raya Jambelaer No. 12, Dawuan, Subang', 'Alamat', 'identitas', '2026-07-20 17:01:23', '2026-07-20 17:01:23'),
(7, 'desa_telepon', '081324768193', 'Nomor Telepon', 'kontak', '2026-07-20 17:01:23', '2026-08-11 14:15:32'),
(9, 'desa_email', 'info@jambelaer-subang.desa.id', 'Email Resmi', 'kontak', '2026-07-20 17:01:23', '2026-07-20 17:01:23'),
(10, 'desa_jam_buka', 'Senin – Jumat: 08:00 – 15:30 WIB', 'Jam Operasional', 'kontak', '2026-07-20 17:01:23', '2026-07-20 17:01:23'),
(11, 'stat_luas', '2.500,366', 'Luas Wilayah (Ha)', 'statistik', '2026-07-20 17:01:23', '2026-07-28 18:11:57'),
(12, 'stat_penduduk', '4850', 'Jumlah Penduduk (Jiwa)', 'statistik', '2026-07-20 17:01:23', '2026-07-20 17:01:23'),
(13, 'stat_umkm', '35', 'Pelaku UMKM', 'statistik', '2026-07-20 17:01:23', '2026-07-20 17:01:23'),
(15, 'sosmed_instagram', 'https://www.instagram.com/desa_jambelaer/', 'Instagram Desa', 'sosmed', '2026-07-20 17:01:23', '2026-08-10 05:43:44'),
(16, 'sosmed_youtube', '', 'YouTube Desa', 'sosmed', '2026-07-20 17:01:23', '2026-08-10 05:43:44'),
(34, 'stat_kk', '1250', 'Jumlah Kepala Keluarga', 'statistik', '2026-07-20 19:23:31', '2026-07-20 19:23:31'),
(35, 'stat_rtrw', '24', 'Jumlah RT/RW', 'statistik', '2026-07-20 19:23:31', '2026-07-20 19:23:31'),
(36, 'stat_dusun', '4', 'Jumlah Dusun', 'statistik', '2026-07-20 19:23:31', '2026-07-20 19:23:31'),
(37, 'maps_embed_url', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.2770633860905!2d107.67617547499373!3d-6.612456993381583!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6923c6db1dfea3%3A0xc0f3970f1ff4dff9!2sKantor%20Desa%20Jambelaer!5e0!3m2!1sen!2sid!4v1785331994623!5m2!1sen!2sid', 'Google Maps Embed URL', 'peta', '2026-07-20 19:23:31', '2026-07-29 06:34:38'),
(38, 'sosmed_tiktok', '', 'TikTok Desa', 'sosmed', '2026-07-20 19:23:31', '2026-08-10 05:43:44'),
(40, 'kades_nama', 'Sahar Dwi Anugrah, S.Kom', 'Nama Kepala Desa & Gelar', 'sambutan', '2026-07-28 18:19:38', '2026-08-11 14:20:20'),
(41, 'kades_jabatan', 'Kepala Desa Jambelaer', 'Jabatan Kepala Desa', 'sambutan', '2026-07-28 18:19:38', '2026-07-28 18:19:38'),
(42, 'kades_foto', '/uploads/kades/kades_1786284621_KIoREj.jpeg', 'URL Foto Kepala Desa', 'sambutan', '2026-07-28 18:19:38', '2026-08-09 14:10:21'),
(43, 'sambutan_judul', 'Sambutan Kepala Desa', 'Judul Sambutan', 'sambutan', '2026-07-28 18:19:38', '2026-07-28 18:19:38'),
(44, 'sambutan_quote', 'Assalamu\'alaikum Wr. Wb. Atas nama Pemerintah Desa Jambelaer, kami menyambut kehadiran Anda di portal resmi kami dengan penuh rasa syukur dan kebanggaan.', 'Kutipan Pembuka (Quote)', 'sambutan', '2026-07-28 18:19:38', '2026-07-28 18:19:38'),
(45, 'sambutan_teks', 'Kami berkomitmen untuk terus membangun desa yang mandiri, sejahtera, dan berdaya saing dengan menjunjung tinggi nilai-nilai budaya lokal yang telah diwariskan leluhur. Dengan semangat gotong royong dan kebersamaan, kami yakin Desa Jambelaer akan terus maju dan berkembang.\r\n\r\nKami mengundang seluruh masyarakat, perantau, dan mitra usaha untuk berkolaborasi membangun desa yang kita cintai bersama. Portal ini hadir sebagai jembatan informasi yang terbuka bagi semua.', 'Isi Lengkap Teks Sambutan', 'sambutan', '2026-07-28 18:19:38', '2026-07-28 18:25:56'),
(46, 'sambutan_tagline', 'Melayani dengan Amanah, Terbuka, dan Transparan.', 'Tagline / Slogan Sambutan', 'sambutan', '2026-07-28 18:19:38', '2026-07-28 18:19:38');

-- --------------------------------------------------------

--
-- Table structure for table `pesan`
--

CREATE TABLE `pesan` (
  `pesan_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `jenis_pesan` enum('pertanyaan_umum','pengaduan','kerja_sama','pengajuan_acara','daftar_umkm') NOT NULL DEFAULT 'pertanyaan_umum',
  `status` enum('menunggu','disetujui','ditolak') NOT NULL DEFAULT 'menunggu' COMMENT 'Status pengajuan (khususnya untuk pengajuan acara)',
  `dipublikasikan` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Apakah acara sudah dipublikasikan ke halaman budaya',
  `is_archived` tinyint(1) NOT NULL DEFAULT 0,
  `nama_umkm` varchar(255) DEFAULT NULL,
  `jenis_produk_umkm` varchar(255) DEFAULT NULL,
  `alamat_umkm_daftar` text DEFAULT NULL,
  `deskripsi_umkm` text DEFAULT NULL,
  `foto_produk` varchar(255) DEFAULT NULL,
  `jam_operasional_umkm` varchar(255) DEFAULT NULL,
  `instagram_umkm` varchar(255) DEFAULT NULL,
  `isi_produk_umkm` varchar(255) DEFAULT NULL,
  `berat_bersih_umkm` varchar(255) DEFAULT NULL,
  `harga_produk_umkm` varchar(255) DEFAULT NULL,
  `ketersediaan_umkm` varchar(255) DEFAULT NULL,
  `sertifikasi_umkm` varchar(255) DEFAULT NULL,
  `dokumen_lampiran` varchar(255) DEFAULT NULL,
  `no_whatsapp` varchar(255) DEFAULT NULL,
  `nama_instansi` varchar(255) DEFAULT NULL,
  `nama_acara` varchar(255) DEFAULT NULL,
  `tanggal_acara` date DEFAULT NULL,
  `waktu_acara` time DEFAULT NULL,
  `lokasi_acara` varchar(255) DEFAULT NULL,
  `jumlah_peserta` int(11) DEFAULT NULL,
  `deskripsi_acara` text DEFAULT NULL,
  `foto_bukti` varchar(255) DEFAULT NULL COMMENT 'Path foto bukti pengaduan (opsional)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pesan`
--

INSERT INTO `pesan` (`pesan_id`, `user_id`, `name`, `email`, `subject`, `message`, `is_read`, `jenis_pesan`, `status`, `dipublikasikan`, `is_archived`, `nama_umkm`, `jenis_produk_umkm`, `alamat_umkm_daftar`, `deskripsi_umkm`, `foto_produk`, `jam_operasional_umkm`, `instagram_umkm`, `isi_produk_umkm`, `berat_bersih_umkm`, `harga_produk_umkm`, `ketersediaan_umkm`, `sertifikasi_umkm`, `dokumen_lampiran`, `no_whatsapp`, `nama_instansi`, `nama_acara`, `tanggal_acara`, `waktu_acara`, `lokasi_acara`, `jumlah_peserta`, `deskripsi_acara`, `foto_bukti`, `created_at`, `updated_at`) VALUES
(3, NULL, 'Sahar Dwi Anugrah', '-', 'Pengaduan Jalan', 'Selamat Siang Bapak/Ibu, Saya ingin melaporkan terkait jalanan di desa A, yang minim penerangan', 1, 'pengaduan', 'menunggu', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6281324768193', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-24 00:59:44', '2026-07-24 00:59:53'),
(4, NULL, 'Asep', 'sahargntg@gmail.com', 'Kerja Sama', 'sHD VBv sh', 1, 'kerja_sama', 'menunggu', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'dokumen-lampiran/LNhsds76SCcfFiwHnOUNppHnZfGNvNPGIXkViu3Z.pdf', '081324768193', 'Subang Creative Hub', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-09 14:02:09', '2026-08-09 14:02:32'),
(5, NULL, 'Asep', '-', 'Pendaftaran UMKM: Opak Pak Asep', 'daefae', 1, 'daftar_umkm', 'menunggu', 0, 0, 'Opak Pak Asep', 'makanan', 'Kp. Melong', 'daefae', 'foto-produk/0DkRLpv5mYqikjMoht2qVJUu7kssCfozx3Eo7Vh8.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '081324768193', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-10 02:05:34', '2026-08-10 02:05:48');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `produk_id` bigint(20) UNSIGNED NOT NULL,
  `pesan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `producer` varchar(255) NOT NULL,
  `nama_pemilik` varchar(255) DEFAULT NULL,
  `alamat_umkm` text DEFAULT NULL,
  `jam_operasional` varchar(255) DEFAULT NULL,
  `no_whatsapp_umkm` varchar(255) DEFAULT NULL,
  `instagram_umkm` varchar(255) DEFAULT NULL,
  `link_marketplace` varchar(255) DEFAULT NULL,
  `price` varchar(255) NOT NULL,
  `badge` varchar(255) NOT NULL,
  `category` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`category`)),
  `img` varchar(255) NOT NULL,
  `desc_short` text NOT NULL,
  `desc_long` longtext NOT NULL,
  `details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`details`)),
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `jenis` varchar(255) DEFAULT NULL,
  `jenis_label` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`produk_id`, `pesan_id`, `slug`, `title`, `producer`, `nama_pemilik`, `alamat_umkm`, `jam_operasional`, `no_whatsapp_umkm`, `instagram_umkm`, `link_marketplace`, `price`, `badge`, `category`, `img`, `desc_short`, `desc_long`, `details`, `is_active`, `urutan`, `jenis`, `jenis_label`, `created_at`, `updated_at`) VALUES
(12, NULL, 'opak-ma-wiwin', 'Opak Ma Wiwin', 'Opak Ma Wiwin', 'Ma Wiwin', 'Kp. Melong, Desa Jambelaer, Kec. Dawuan, Kab. Subang', 'Senin-Minggu (06:00-17:00)', '085220724877', '@opak_ibu.wiwin', NULL, 'Rp 12.000 / bks', 'Makanan', '[\"makanan\"]', '/uploads/produk/1786282039_opak-ma-wiwin.jpeg', 'dsfs', 'fsdfsfdsf', '{\"Berat Bersih\":\"200 gram \\/ bungkus\",\"Harga\":\"12.000 \\/ Bungkus\",\"Ketersediaan\":\"Tersedia\",\"Sertifikasi\":\"\"}', 1, 1, 'opak', 'Opak', '2026-07-20 17:53:28', '2026-08-09 13:27:19'),
(20, NULL, 'opak-ibu-ninin', 'Opak Ibu Ninin', 'Ibu Ninin', 'Ibu Ninin', NULL, 'Senin-Minggu (06:00-17:00)', '085793644896', '@opak_ibu.ninin', NULL, 'Rp 12.000 / bks', 'Makanan', '[\"makanan\"]', '/uploads/produk/1786282054_opak-ibu-ninin.jpeg', 'svdfbd', 'dfgfbgdfgb', '{\"Berat Bersih\":\"200 gram \\/ bungkus\",\"Harga\":\"12.000 \\/ Bungkus\",\"Ketersediaan\":\"Tersedia\",\"Sertifikasi\":\"\"}', 1, 2, 'opak', 'Opak', '2026-07-28 18:55:26', '2026-08-09 13:27:34'),
(21, NULL, 'opak-ibu-aan', 'Opak Ibu Aan', 'Ibu Aan', 'Ibu Aan', 'Kp. Melong, Desa Jambelaer, Kec. Dawuan, Kab. Subang', 'Senin-Minggu (06:00-17:00)', '085320081452', '@opak_ibu.aan', NULL, 'Rp 12.000 / bks', 'Makanan', '[\"makanan\"]', '/uploads/produk/1786282072_opak-ibu-aan.png', 'afcasrhvfsdjnf', 'fsfvdsfhvbsjdgharb', '{\"Berat Bersih\":\"200 gram \\/ bungkus\",\"Harga\":\"12.000 \\/ bungkus\",\"Ketersediaan\":\"Tersedia\",\"Sertifikasi\":\"\"}', 1, 3, 'opak', 'Opak', '2026-07-28 18:57:51', '2026-08-09 13:27:52'),
(22, NULL, 'opak-hj-karli', 'Opak Hj. Karli', 'Hj. Karli', 'Hj. Karli', 'Kp. Melong, Desa Jambelaer, Kec. Dawuan, Kab. Subang', 'Senin-Minggu (06:00-17:00)', '085559072303', '@opak_haji.karli', NULL, 'Rp 13.000 / bks', 'Makanan', '[\"makanan\"]', '/uploads/produk/1786282086_opak-hj-karli.jpeg', 'sdvsv', 'sdvsdvsdf', '{\"Berat Bersih\":\"200 gram \\/ bungkus\",\"Harga\":\"13.000 \\/ bungkus\",\"Sertifikasi\":\"\",\"Ketersediaan\":\"Tersedia\"}', 1, 4, 'opak', 'Opak', '2026-07-28 18:59:44', '2026-08-09 13:28:06'),
(23, NULL, 'opak-ibu-hj-atang', 'Opak Ibu Hj. Atang', 'Ibu Hj. Atang', 'Ibu Hj. Atang', 'Kp. Melong, Desa Jambelaer, Kec. Dawuan, Kab. Subang', 'Senin-Minggu (06:00-17:00)', '085220051904', '@opak_ibu.h.atang', NULL, 'Rp 15.000 / kg', 'Makanan', '[\"makanan\"]', '/uploads/produk/1786282101_opak-ibu-hj-atang.jpeg', 'aFsd', 'sfvsd', '{\"Berat Bersih\":\"200 gram \\/ bungkus\",\"Harga\":\"15.000 \\/ bungkus\",\"Sertifikasi\":\"\",\"Ketersediaan\":\"Tersedia\"}', 1, 5, 'opak', 'Opak', '2026-07-28 19:02:11', '2026-08-09 13:28:21'),
(24, NULL, 'opak-ceu-juju', 'Opak Ceu Juju', 'Ceu Juju', 'Ceu Juju', 'Kp. Melong, Desa Jambelaer, Kec. Dawuan, Kab. Subang', 'Senin-Minggu (06:00-17:00)', '081214915721', '@opak_ceu.juju', NULL, 'Rp 25.000 / pcs', 'Makanan', '[\"makanan\"]', '/uploads/produk/1786282118_opak-ceu-juju.jpeg', 'fsafvdv', 'avfzsd', '{\"Berat Bersih\":\"200 gram \\/ bungkus\",\"Harga\":\"12.000 \\/ bungkus\",\"Sertifikasi\":\"\",\"Ketersediaan\":\"Tersedia\"}', 1, 6, 'opak', 'Opak', '2026-07-28 19:03:58', '2026-08-09 13:28:38'),
(25, NULL, 'opak-abah-utim', 'Opak Abah Utim', 'Abah Utim', 'Abah Utim', 'Kp. Melong, Desa Jambelaer, Kec. Dawuan, Kab. Subang', 'Senin-Minggu (06:00-17:00)', '082315250140', '@opak_abah.utim', NULL, 'Rp 15.000 / kg', 'Makanan', '[\"makanan\"]', '/uploads/produk/1786282136_opak-abah-utim.png', 'cdsvdsv', 'sdvVsv', '{\"Berat Bersih\":\"200 gram \\/ bungkus\",\"Harga\":\"12.000 \\/ Bungkus\",\"Sertifikasi\":\"\",\"Ketersediaan\":\"Tersedia\"}', 1, 7, 'opak', 'Opak', '2026-07-28 19:05:55', '2026-08-09 13:28:56');

-- --------------------------------------------------------

--
-- Table structure for table `struktur_desa`
--

CREATE TABLE `struktur_desa` (
  `struktur_desa_id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `urutan` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `struktur_desa`
--

INSERT INTO `struktur_desa` (`struktur_desa_id`, `nama`, `jabatan`, `foto`, `urutan`, `created_at`, `updated_at`) VALUES
(1, 'Sahar Dwi Anugrah, S.Kom', 'Kepala Desa', '/uploads/struktur/struktur_1786284584_CMvuZef2.jpeg', 1, '2026-07-20 17:05:13', '2026-08-11 14:20:50'),
(2, 'Dadang Koswara', 'Sekretaris Desa', '/uploads/struktur/struktur_1784592472_WhatsApp Image 2026-07-18 at 07.28.10.jpeg', 2, '2026-07-20 17:07:52', '2026-07-25 00:29:16'),
(3, 'Andy Irawan, S.E', 'Kaur. Keuangan', '/uploads/struktur/struktur_1784592609_WhatsApp Image 2026-07-18 at 07.28.08.jpeg', 5, '2026-07-20 17:10:09', '2026-07-25 00:29:16'),
(4, 'Rohamin', 'Kaur. Umum & Perencanaan', '/uploads/struktur/struktur_1784592743_WhatsApp Image 2026-07-18 at 07.28.10 (1).jpeg', 6, '2026-07-20 17:12:23', '2026-07-25 00:29:16'),
(5, 'Ade Supardi', 'Kasi. Pemerintahan', '/uploads/struktur/struktur_1784592808_WhatsApp Image 2026-07-18 at 07.28.07.jpeg', 3, '2026-07-20 17:13:28', '2026-07-25 00:29:16'),
(6, 'Wahyu Suyaman', 'Kasi. Kesejahteraan', '/uploads/struktur/struktur_1784592887_WhatsApp Image 2026-07-18 at 07.28.09.jpeg', 4, '2026-07-20 17:14:47', '2026-07-25 00:29:16'),
(7, 'Aneng Antikasari', 'Staf Desa', '/uploads/struktur/struktur_1784593084_WhatsApp Image 2026-07-18 at 07.28.08 (1).jpeg', 7, '2026-07-20 17:18:04', '2026-07-25 00:29:16'),
(8, 'Endah Triwantini', 'Staf Desa', '/uploads/struktur/struktur_1784593131_WhatsApp Image 2026-07-18 at 07.28.07 (1).jpeg', 8, '2026-07-20 17:18:51', '2026-07-25 00:29:16'),
(9, 'Dadan Kurniawan', 'Kepala Dusun I', '/uploads/struktur/struktur_1784593189_WhatsApp Image 2026-07-18 at 07.28.07 (2).jpeg', 9, '2026-07-20 17:19:49', '2026-07-25 00:29:16'),
(10, 'Cece Hermawan', 'Kepala Dusun II', '/uploads/struktur/struktur_1784593259_WhatsApp Image 2026-07-18 at 07.28.08 (2).jpeg', 10, '2026-07-20 17:20:59', '2026-07-25 00:29:16'),
(11, 'Wawan Gunawan', 'Kepala Dusun III', '/uploads/struktur/struktur_1784593318_WhatsApp Image 2026-07-18 at 07.28.08 (3).jpeg', 11, '2026-07-20 17:21:58', '2026-07-25 00:29:16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Desa Jambelaer', 'admin@jambelaer.id', NULL, '$2y$12$WVZGmZEwM9zsL6XrZztNpe6dGpowA3C5Qo.dBbdyCDe8Rt1u9flnq', 'gqZgCh7vPmqASSdNqTRoDlbzCAoxEu371FJZsNe6MqsCoG9qSkOMqnEsZOiT', '2026-07-20 17:01:23', '2026-07-31 20:14:35'),
(2, 'Sahar Dwi Anugrah', 'saharanugrah123@gmail.com', NULL, '$2y$12$4m58JWy2UHyyAWn1PtjbkOj0G4GgLKd2YOKCR6w.i7h4LrGCIO7Ou', 'SmNM6EL0IgpZ3LxAdNNs3l871yGJVXPYZBh9UdYfCvMiH2ix4DOn7vYdQBMs', '2026-07-28 18:49:41', '2026-07-31 20:51:37');

-- --------------------------------------------------------

--
-- Table structure for table `wisata`
--

CREATE TABLE `wisata` (
  `wisata_id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `ringkasan` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `maps_iframe` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `harga_tiket` varchar(255) NOT NULL,
  `jam_operasional` varchar(255) NOT NULL,
  `urutan` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wisata`
--

INSERT INTO `wisata` (`wisata_id`, `nama`, `slug`, `kategori`, `ringkasan`, `deskripsi`, `alamat`, `maps_iframe`, `gambar`, `harga_tiket`, `jam_operasional`, `urutan`, `is_active`, `created_at`, `updated_at`) VALUES
(6, 'Wisata Eco Brick', 'wisata-eco-brick', 'alam', 'Wisata Eco Brick merupakan destinasi alam yang mengajak pengunjung mengenal pengelolaan sampah plastik melalui pembuatan ecobrick. Tempat ini menjadi sarana belajar sekaligus meningkatkan kepedulian terhadap lingkungan.', 'Wisata Eco Brick merupakan destinasi alam yang mengajak pengunjung mengenal pengelolaan sampah plastik melalui pembuatan ecobrick. Tempat ini menjadi sarana belajar sekaligus meningkatkan kepedulian terhadap lingkungan.', 'Jl. Genteng, Desa Jambelaer', NULL, '/uploads/wisata/wisata_1786296157_6a78b75d2daf9.jpeg', 'Gratis', '08:00 - 17:00 WIB', 1, 1, '2026-08-09 17:22:37', '2026-08-09 17:23:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`berita_id`),
  ADD UNIQUE KEY `berita_slug_unique` (`slug`);

--
-- Indexes for table `budaya`
--
ALTER TABLE `budaya`
  ADD PRIMARY KEY (`budaya_id`),
  ADD UNIQUE KEY `budaya_slug_unique` (`slug`);

--
-- Indexes for table `galeri`
--
ALTER TABLE `galeri`
  ADD PRIMARY KEY (`galeri_id`),
  ADD UNIQUE KEY `galeri_slug_unique` (`slug`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`pengaturan_id`),
  ADD UNIQUE KEY `pengaturan_key_unique` (`key`);

--
-- Indexes for table `pesan`
--
ALTER TABLE `pesan`
  ADD PRIMARY KEY (`pesan_id`),
  ADD KEY `pesan_user_id_index` (`user_id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`produk_id`),
  ADD UNIQUE KEY `produk_slug_unique` (`slug`),
  ADD KEY `produk_pesan_id_index` (`pesan_id`);

--
-- Indexes for table `struktur_desa`
--
ALTER TABLE `struktur_desa`
  ADD PRIMARY KEY (`struktur_desa_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wisata`
--
ALTER TABLE `wisata`
  ADD PRIMARY KEY (`wisata_id`),
  ADD UNIQUE KEY `wisata_slug_unique` (`slug`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `berita_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `budaya`
--
ALTER TABLE `budaya`
  MODIFY `budaya_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `galeri`
--
ALTER TABLE `galeri`
  MODIFY `galeri_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `pengaturan`
--
ALTER TABLE `pengaturan`
  MODIFY `pengaturan_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `pesan`
--
ALTER TABLE `pesan`
  MODIFY `pesan_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `produk_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `struktur_desa`
--
ALTER TABLE `struktur_desa`
  MODIFY `struktur_desa_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wisata`
--
ALTER TABLE `wisata`
  MODIFY `wisata_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pesan`
--
ALTER TABLE `pesan`
  ADD CONSTRAINT `pesan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_pesan_id_foreign` FOREIGN KEY (`pesan_id`) REFERENCES `pesan` (`pesan_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
