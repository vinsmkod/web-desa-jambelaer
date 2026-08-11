-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: web_desa_jambelaer
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `berita`
--

DROP TABLE IF EXISTS `berita`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `berita` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `kategori` varchar(255) NOT NULL DEFAULT 'pengumuman',
  `ringkasan` text DEFAULT NULL,
  `konten` longtext NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `penulis` varchar(255) NOT NULL DEFAULT 'Admin Desa',
  `views` bigint(20) unsigned NOT NULL DEFAULT 0,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `berita_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `budaya`
--

DROP TABLE IF EXISTS `budaya`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `budaya` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kategori` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `excerpt` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `urutan` smallint(5) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `galeri`
--

DROP TABLE IF EXISTS `galeri`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `galeri` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `kategori` enum('kegiatan_desa','acara_desa','umkm','budaya_desa','dokumentasi') NOT NULL DEFAULT 'kegiatan_desa',
  `foto` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `tanggal_publikasi` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pengaturan`
--

DROP TABLE IF EXISTS `pengaturan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pengaturan` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `group` varchar(255) NOT NULL DEFAULT 'umum',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pengaturan_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pesan`
--

DROP TABLE IF EXISTS `pesan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pesan` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `produk`
--

DROP TABLE IF EXISTS `produk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produk` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `produk_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `struktur_desa`
--

DROP TABLE IF EXISTS `struktur_desa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `struktur_desa` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `urutan` smallint(5) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wisata`
--

DROP TABLE IF EXISTS `wisata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wisata` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
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
  `urutan` smallint(5) unsigned NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `wisata_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-08-11 16:44:17
