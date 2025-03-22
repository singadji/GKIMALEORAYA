-- MySQL dump 10.13  Distrib 9.0.1, for macos15.1 (arm64)
--
-- Host: localhost    Database: gkimaleo_db
-- ------------------------------------------------------
-- Server version	9.0.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `albums`
--

DROP TABLE IF EXISTS `albums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `albums` (
  `id_album` int unsigned NOT NULL AUTO_INCREMENT,
  `nama_album` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `publish` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `slug` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_album`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `albums`
--

LOCK TABLES `albums` WRITE;
/*!40000 ALTER TABLE `albums` DISABLE KEYS */;
/*!40000 ALTER TABLE `albums` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `beritas`
--

DROP TABLE IF EXISTS `beritas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `beritas` (
  `id_berita` int unsigned NOT NULL AUTO_INCREMENT,
  `id_kategori` int NOT NULL,
  `judul` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_user` int NOT NULL,
  `isi` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `waktu` time NOT NULL,
  `gambar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `publish` tinyint(1) NOT NULL,
  `baca` int DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `isslider` tinyint(1) DEFAULT NULL,
  `slug` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_berita`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `beritas`
--

LOCK TABLES `beritas` WRITE;
/*!40000 ALTER TABLE `beritas` DISABLE KEYS */;
/*!40000 ALTER TABLE `beritas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fotos`
--

DROP TABLE IF EXISTS `fotos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fotos` (
  `id_foto` int unsigned NOT NULL AUTO_INCREMENT,
  `id_album` int NOT NULL,
  `judul_foto` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_foto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fotos`
--

LOCK TABLES `fotos` WRITE;
/*!40000 ALTER TABLE `fotos` DISABLE KEYS */;
/*!40000 ALTER TABLE `fotos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gambars`
--

DROP TABLE IF EXISTS `gambars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gambars` (
  `id_gambar` int NOT NULL AUTO_INCREMENT,
  `id_menu` int NOT NULL,
  `judul_gambar` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `foto` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`id_gambar`),
  KEY `galery_id_album_IDX` (`id_menu`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gambars`
--

LOCK TABLES `gambars` WRITE;
/*!40000 ALTER TABLE `gambars` DISABLE KEYS */;
/*!40000 ALTER TABLE `gambars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `group_wilayah`
--

DROP TABLE IF EXISTS `group_wilayah`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_wilayah` (
  `id_group_wilayah` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_group_wilayah` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kelurahan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kecamatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `koor_group_wilayah` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_group_wilayah`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `group_wilayah`
--

LOCK TABLES `group_wilayah` WRITE;
/*!40000 ALTER TABLE `group_wilayah` DISABLE KEYS */;
INSERT INTO `group_wilayah` VALUES ('0','NULL','NULL','NULL','NULL',NULL,NULL),('G01','Group Wilayah 1','Pondok Pucung','Pondok Aren','Ibu Yeni',NULL,'2025-02-13 05:02:54'),('G02','Group Wilayah 2','Sawah Baru','Ciputat','Ibu Ratna','2025-02-13 05:20:00','2025-02-14 10:35:33'),('G03','Group Wilayah 3','Perigi','Pondok Aren','Pak Budi','2025-02-14 19:38:51','2025-02-14 19:38:51'),('G04','Group Wilayah 4','Pondok Pucung','Ciputat','Pak Hendi','2025-02-14 19:40:00','2025-02-14 19:40:00');
/*!40000 ALTER TABLE `group_wilayah` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hubungan_keluarga`
--

DROP TABLE IF EXISTS `hubungan_keluarga`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hubungan_keluarga` (
  `id_hub_kel` int NOT NULL AUTO_INCREMENT,
  `id_kk_jemaat` int NOT NULL,
  `id_jemaat` int NOT NULL,
  `hubungan_keluarga` enum('Kepala Keluarga','Pasangan','Anak','Kerabat','Belum Menikah') NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_hub_kel`),
  KEY `id_kk_jemaat` (`id_kk_jemaat`),
  KEY `id_jemaat` (`id_jemaat`),
  CONSTRAINT `hubungan_keluarga_ibfk_1` FOREIGN KEY (`id_kk_jemaat`) REFERENCES `kk_jemaat` (`id_kk_jemaat`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `hubungan_keluarga_ibfk_2` FOREIGN KEY (`id_jemaat`) REFERENCES `jemaat` (`id_jemaat`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hubungan_keluarga`
--

LOCK TABLES `hubungan_keluarga` WRITE;
/*!40000 ALTER TABLE `hubungan_keluarga` DISABLE KEYS */;
INSERT INTO `hubungan_keluarga` VALUES (1,1,2,'Pasangan',NULL,NULL,NULL,NULL),(2,1,3,'Anak',NULL,NULL,NULL,NULL),(3,2,5,'Pasangan',NULL,NULL,NULL,NULL),(4,3,7,'Pasangan',NULL,NULL,NULL,NULL),(5,3,8,'Anak',NULL,NULL,NULL,NULL),(6,4,10,'Pasangan',NULL,NULL,NULL,NULL),(7,6,13,'Pasangan',NULL,NULL,NULL,NULL),(8,6,14,'Anak',NULL,NULL,NULL,NULL),(9,7,16,'Pasangan',NULL,NULL,NULL,NULL),(10,9,19,'Pasangan',NULL,NULL,NULL,NULL),(11,9,20,'Anak',NULL,NULL,NULL,NULL),(12,10,22,'Pasangan',NULL,NULL,NULL,NULL),(13,11,24,'Pasangan',NULL,NULL,NULL,NULL),(14,12,26,'Pasangan',NULL,NULL,NULL,NULL),(15,14,29,'Pasangan',NULL,NULL,NULL,NULL),(16,16,32,'Pasangan',NULL,NULL,NULL,NULL),(17,16,33,'Anak',NULL,NULL,NULL,NULL),(18,16,34,'Anak',NULL,NULL,NULL,NULL),(19,17,36,'Pasangan',NULL,NULL,NULL,NULL),(20,18,38,'Pasangan',NULL,NULL,NULL,NULL),(21,18,39,'Anak',NULL,NULL,NULL,NULL),(22,19,41,'Pasangan',NULL,NULL,NULL,NULL),(23,19,42,'Anak',NULL,NULL,NULL,NULL),(24,19,43,'Anak',NULL,NULL,NULL,NULL),(25,19,44,'Anak',NULL,NULL,NULL,NULL),(26,20,46,'Pasangan',NULL,NULL,NULL,NULL),(27,20,47,'Anak',NULL,NULL,NULL,NULL),(28,20,48,'Anak',NULL,NULL,NULL,NULL),(29,20,49,'Anak',NULL,NULL,NULL,NULL),(30,22,52,'Pasangan',NULL,NULL,NULL,NULL),(31,22,53,'Anak',NULL,NULL,NULL,NULL),(32,24,56,'Pasangan',NULL,NULL,NULL,NULL),(33,24,57,'Anak',NULL,NULL,NULL,NULL),(34,49,58,'Pasangan',NULL,NULL,NULL,NULL),(35,24,59,'Anak',NULL,NULL,NULL,NULL),(36,50,60,'Pasangan',NULL,NULL,NULL,NULL),(37,24,61,'Anak',NULL,NULL,NULL,NULL),(38,25,63,'Pasangan',NULL,NULL,NULL,NULL),(39,26,65,'Pasangan',NULL,NULL,NULL,NULL),(40,27,67,'Pasangan',NULL,NULL,NULL,NULL),(41,29,70,'Pasangan',NULL,NULL,NULL,NULL),(42,30,73,'Anak',NULL,NULL,NULL,NULL),(43,30,76,'Anak',NULL,NULL,NULL,NULL),(44,30,77,'Anak',NULL,NULL,NULL,NULL),(45,52,73,'Pasangan',NULL,NULL,NULL,NULL),(46,52,75,'Anak',NULL,NULL,NULL,NULL),(47,31,79,'Pasangan',NULL,NULL,NULL,NULL),(48,53,81,'Pasangan',NULL,NULL,NULL,NULL),(49,53,82,'Anak',NULL,NULL,NULL,NULL),(50,53,83,'Anak',NULL,NULL,NULL,NULL),(51,53,84,'Anak',NULL,NULL,NULL,NULL),(52,32,86,'Pasangan',NULL,NULL,NULL,NULL),(53,33,88,'Pasangan',NULL,NULL,NULL,NULL),(54,33,89,'Anak',NULL,NULL,NULL,NULL),(55,33,90,'Anak',NULL,NULL,NULL,NULL),(56,34,92,'Pasangan',NULL,NULL,NULL,NULL),(57,34,93,'Anak',NULL,NULL,NULL,NULL),(58,35,95,'Pasangan',NULL,NULL,NULL,NULL),(59,35,96,'Anak',NULL,NULL,NULL,NULL),(60,36,98,'Pasangan',NULL,NULL,NULL,NULL),(61,36,99,'Anak',NULL,NULL,NULL,NULL),(62,37,101,'Pasangan',NULL,NULL,NULL,NULL),(63,37,102,'Anak',NULL,NULL,NULL,NULL),(64,37,103,'Anak',NULL,NULL,NULL,NULL),(65,37,104,'Anak',NULL,NULL,NULL,NULL),(66,39,107,'Pasangan',NULL,NULL,NULL,NULL),(67,39,108,'Anak',NULL,NULL,NULL,NULL),(68,39,109,'Anak',NULL,NULL,NULL,NULL),(69,39,110,'Anak',NULL,NULL,NULL,NULL),(70,41,113,'Pasangan',NULL,NULL,NULL,NULL),(71,42,115,'Pasangan',NULL,NULL,NULL,NULL),(72,43,117,'Pasangan',NULL,NULL,NULL,NULL),(73,43,118,'Anak',NULL,NULL,NULL,NULL),(74,43,121,'Anak',NULL,NULL,NULL,NULL),(75,43,123,'Anak',NULL,NULL,NULL,NULL),(76,54,118,'Pasangan',NULL,NULL,NULL,NULL),(77,54,120,'Kerabat',NULL,NULL,NULL,NULL),(78,55,122,'Pasangan',NULL,NULL,NULL,NULL),(79,44,125,'Pasangan',NULL,NULL,NULL,NULL),(80,44,126,'Anak',NULL,NULL,NULL,NULL),(81,44,127,'Anak',NULL,NULL,NULL,NULL),(82,44,128,'Anak',NULL,NULL,NULL,NULL),(83,45,130,'Pasangan',NULL,NULL,NULL,NULL),(84,45,131,'Anak',NULL,NULL,NULL,NULL),(85,45,132,'Anak',NULL,NULL,NULL,NULL),(86,45,133,'Anak',NULL,NULL,NULL,NULL),(87,47,136,'Pasangan',NULL,NULL,NULL,NULL),(88,48,138,'Pasangan',NULL,NULL,NULL,NULL),(89,48,139,'Anak',NULL,NULL,NULL,NULL),(90,48,140,'Anak',NULL,NULL,NULL,NULL),(91,48,141,'Anak',NULL,NULL,NULL,NULL),(92,48,142,'Anak',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `hubungan_keluarga` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `identitaswebs`
--

DROP TABLE IF EXISTS `identitaswebs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `identitaswebs` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nama_website` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `facebook` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_telp` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `meta_keyword` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `favicon` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `maps` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `moto` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `youtube` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `identitaswebs`
--

LOCK TABLES `identitaswebs` WRITE;
/*!40000 ALTER TABLE `identitaswebs` DISABLE KEYS */;
INSERT INTO `identitaswebs` VALUES (1,'Sistem Informasi Administrasi GKI Maleo Raya','gki_maleoraya@yahoo.com','https://gkimaleo.or.id/','-','Jl. Maleo Raya, Bintaro Jaya Sektor IX, Tangerang-Selatan, Banten.','+62 21 7455780','-','-','-',NULL,'-','1740893738.png','-',NULL,NULL);
/*!40000 ALTER TABLE `identitaswebs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jemaat`
--

DROP TABLE IF EXISTS `jemaat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jemaat` (
  `id_jemaat` int NOT NULL AUTO_INCREMENT,
  `nia` char(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_jemaat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `gender` enum('L','P') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nomor_hp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `asal_gereja` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_terdaftar` date DEFAULT NULL,
  `tempat_lahir` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `tanggal_baptis` date DEFAULT NULL,
  `tanggal_sidi` date DEFAULT NULL,
  `tanggal_nikah` date DEFAULT NULL,
  `status_aktif` enum('Aktif','Pindah','Menikah','Meninggal Dunia','Atestasi') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_menikah` enum('Menikah','Belum Menikah','Duda','Janda') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Belum Menikah',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_jemaat`),
  UNIQUE KEY `unique_no_anggota` (`nia`)
) ENGINE=InnoDB AUTO_INCREMENT=143 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jemaat`
--

LOCK TABLES `jemaat` WRITE;
/*!40000 ALTER TABLE `jemaat` DISABLE KEYS */;
INSERT INTO `jemaat` VALUES (1,'0001','M.Ishak L. Tobing  ','L','745 6233','GKI Bintaro','2001-05-12','Kotabaru','1945-12-01','1948-10-03','1961-12-25','1978-01-23','Atestasi','Menikah',NULL,NULL,NULL,NULL),(2,'0002','Nurlela Hutagalung','P','745 6233','GKI Bintaro','2001-05-12','Tarutung','1954-05-03','1945-08-22','1969-11-02','1978-01-23','Atestasi','Menikah',NULL,NULL,NULL,NULL),(3,'0055','Elia Sumurung Hasoloan L. Tobing','P','','','2001-05-12','Jakarta','1981-07-14','1982-07-11','1982-07-11','1900-01-01','Atestasi','Belum Menikah',NULL,NULL,NULL,NULL),(4,'0003','Sudaryanto','L','731 8052','GKI Bintaro','2001-05-12','Semin','1958-03-23','1968-12-25','1976-12-26','1988-05-20','Meninggal Dunia','Menikah',NULL,NULL,NULL,NULL),(5,'0014','Ester Dian Nugraheni','P','731 8052','GKI Bintaro','2001-05-12','Gunung Kidul','1961-02-16','1988-04-24','1988-04-24','1988-05-20','Aktif','Menikah',NULL,NULL,NULL,NULL),(6,'0004','Jonathan H.Lemuel','L','737 1511','GKI Bintaro','2001-05-12','Wonogiri','1951-09-18','1951-10-28','1968-10-27','1983-02-03','Aktif','Menikah',NULL,NULL,NULL,NULL),(7,'0470','Vera Kosim Sindudibroto','P','737 1511','GKI Bintaro','2001-05-12','Purwokerto','1954-02-18','1900-01-01','2009-11-08','1983-02-03','Aktif','Menikah',NULL,NULL,NULL,NULL),(8,'0687','Jessica Kurniathy','P','','GKI Bintaro','2001-05-12','Jakarta','1996-04-25','1996-08-18','2013-11-10','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(9,'0007','Toman Gultom','L','','GKI Bintaro','2001-05-12','Labuhatongga','1934-10-01','1934-02-15','1934-02-15','1966-08-12','Meninggal Dunia','Menikah',NULL,NULL,NULL,NULL),(10,'0008','Syarmak Siregar','P','','GKI Bintaro','2001-05-12','Jakarta','1947-03-01','1947-10-15','1905-05-16','1966-08-12','Aktif','Menikah',NULL,NULL,NULL,NULL),(11,'0009','R. Soekartono Moegiri','L','','','1900-01-01','Semarang','1932-08-30','1971-03-26','1971-03-22','1971-03-22','Meninggal Dunia','Menikah',NULL,NULL,NULL,NULL),(12,'0010','G.D.Goenawan, RIP','L','','GKI Bintaro','2001-05-12','','1900-01-01','1900-01-01','1900-01-01','1962-05-18','Meninggal Dunia','Menikah',NULL,NULL,NULL,NULL),(13,'0011','Lydia Sri Oentari','P','','GKI Bintaro','2001-05-12','Cirebon','1939-09-10','1958-07-06','1958-07-06','1962-05-18','Aktif','Menikah',NULL,NULL,NULL,NULL),(14,'0012','Yahya Koernyanto Goenawan','L','','GKI Bintaro','2001-05-12','Jakarta','1966-01-01','1966-02-27','1983-02-06','1996-05-04','Aktif','Menikah',NULL,NULL,NULL,NULL),(15,'0015','Danny Wangsahardja','L','','GKI Bintaro','2001-05-12','Bandung','1961-01-03','1978-12-25','1978-12-25','1990-02-03','Aktif','Menikah',NULL,NULL,NULL,NULL),(16,'0016','Yanti P.Kusumaputri','P','','GKI Bintaro','2001-05-12','Jakarta','1963-10-22','1983-05-01','1983-05-01','1990-02-03','Aktif','Menikah',NULL,NULL,NULL,NULL),(17,'0017','Rosana Evita Juliana Gultom','P','','GKI Bintaro','2001-05-12','','1900-01-01','1900-01-01','1991-08-11','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(18,'0018','Ricardo Johnse Tulaar','L','','GKI Bintaro','2001-05-12','','1900-01-01','1900-01-01','1900-01-01','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(19,'0019','Hanneke Tulaar','P','','GKI Bintaro','2001-05-12','','1900-01-01','1900-01-01','1900-01-01','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(20,'0232','Sonya Louise Tulaar','P','','GKI Bintaro','2003-12-21','Jakarta','1986-12-13','1990-12-16','2003-12-21','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(21,'0020','Ferry James Watti','L','','GKI Bintaro','2001-05-12','Menado','1961-02-13','1900-01-01','1982-12-19','1989-12-06','Aktif','Menikah',NULL,NULL,NULL,NULL),(22,'0021','Pingkanita M Lumongdong','P','','GKI Bintaro','2001-05-12','Jakarta','1964-07-06','1900-01-01','1900-01-01','1989-12-06','Aktif','Menikah',NULL,NULL,NULL,NULL),(23,'0022','Jansen P.L. Tobing, RIP','L','','GKI Bintaro','2001-05-12','','1900-01-01','1900-01-01','1900-01-01','1900-01-01','Meninggal Dunia','Belum Menikah',NULL,NULL,NULL,NULL),(24,'0023','Annie Hutagalung, RIP','P','','GKI Bintaro','2001-05-12','','1900-01-01','1900-01-01','1900-01-01','1900-01-01','Meninggal Dunia','Belum Menikah',NULL,NULL,NULL,NULL),(25,'0024','Yusak Suryodinoto','L','','','1900-01-01','Magelang','1965-05-09','1982-12-25','1982-12-25','1995-01-23','Aktif','Menikah',NULL,NULL,NULL,NULL),(26,'0025','Elisabeth Dewin Bibiana','P','','','1900-01-01','Semarang','1966-01-23','1966-08-16','1988-03-20','1995-01-23','Aktif','Menikah',NULL,NULL,NULL,NULL),(27,'0026','Donny Oktavianus Tuturoong\' (Pindah)','L','','GKI Bintaro','2001-05-12','Jakarta','1977-10-14','1980-12-26','1996-07-21','1900-01-01','Atestasi','Belum Menikah',NULL,NULL,NULL,NULL),(28,'0027','Sigit Rahardjo','L','','','1900-01-01','Magelang','1951-12-06','1952-01-27','1973-04-29','1986-03-24','Aktif','Menikah',NULL,NULL,NULL,NULL),(29,'0028','Dwi Atmi Wijandari','P','','','1900-01-01','Surabaya','1963-05-14','1968-12-11','1982-12-12','1986-03-24','Aktif','Menikah',NULL,NULL,NULL,NULL),(30,'0029','Brillianto Sartono, RIP','L','','GKI Bintaro','2001-05-12','Jakarta','1972-10-20','1997-10-12','1998-10-10','1998-10-10','Meninggal Dunia','Menikah',NULL,NULL,NULL,NULL),(31,'0065','Johannis Josef Pattinasarany','L','','GKI Bintaro','2001-05-12','Ambon','1957-06-24','1960-07-08','1984-04-15','1986-11-22','Aktif','Menikah',NULL,NULL,NULL,NULL),(32,'0030','Charlina Margaretha','P','','GKI Bintaro','2001-05-12','Bandung','1958-11-05','1978-12-10','1978-12-10','1986-11-22','Aktif','Menikah',NULL,NULL,NULL,NULL),(33,'0378','Calvin Alfredo ','L','','GKI Maleo Raya','2006-11-19','Bandung','1988-07-04','1900-01-01','2006-07-09','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(34,'0474','Cheryl Avia Pattinasarany','P','021-74868329','GKI Maleo Raya','2009-11-08','Bandung','1992-12-28','1997-12-28','2009-11-08','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(35,'0031','Astronady Laksana, RIP','L','','GKI Bintaro','2001-05-12','Jakarta','1933-07-03','1977-09-11','1900-01-01','1966-11-24','Meninggal Dunia','Menikah',NULL,NULL,NULL,NULL),(36,'0032','Liem Ley Lie Mey','P','','GKI Bintaro','2001-05-12','Jember','1940-02-11','1970-07-26','1900-01-01','1966-11-24','Aktif','Menikah',NULL,NULL,NULL,NULL),(37,'0033','Lawrence TP Siburian','L','','GKI Bintaro','2001-05-12','','1957-07-22','1957-10-13','1900-01-01','1986-11-07','Aktif','Menikah',NULL,NULL,NULL,NULL),(38,'0034','Rosalina Somuntul Prianingsih Napitupulu','P','','GKI Bintaro','2001-05-12','','1959-01-09','1959-12-06','1900-01-01','1986-11-07','Aktif','Menikah',NULL,NULL,NULL,NULL),(39,'0230','Pangeran Daryl Yohannes Siburian','L','','GKI Bintaro','2003-12-21','Jakarta','1987-09-19','1988-12-04','2003-12-21','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(40,'0035','Mangapul Hutadjulu','L','','GKI Bintaro','2001-05-12','Tapanuli','1957-05-04','1957-08-25','1973-04-22','1988-01-28','Aktif','Menikah',NULL,NULL,NULL,NULL),(41,'0036','Justina Mariana Rumonang Sinaga','P','','GKI Bintaro','2001-05-12','Yogyakarta','1964-08-02','1966-09-11','1984-07-08','1988-01-28','Aktif','Menikah',NULL,NULL,NULL,NULL),(42,'0376','Madeline Saurina Natalia Hutadjulu ','P','','GKI Bintaro','2006-11-19','Jakarta','1988-12-06','1990-07-01','2006-11-19','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(43,'0483','Marella Matta Hutadjulu','P','0813 16903051','GKI Maleo Raya','2009-11-08','Jakarta','1993-06-07','1994-06-05','2009-11-08','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(44,'0634','Yohanes Manuel Hutadjulu','L','0813 1690 3091','GKI Maleo Raya','2012-11-18','Jakarta','1996-09-21','1900-01-01','2012-11-18','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(45,'0037','James Warner Toga Hutagalung, RIP','L','','GKI Bintaro','2001-05-12','','2025-05-07','1900-01-01','1900-01-01','1900-01-01','Meninggal Dunia','Belum Menikah',NULL,NULL,NULL,NULL),(46,'0038','Hotma Barita P. Sihite','P','','GKI Bintaro','2001-05-12','','1960-12-14','1900-01-01','1900-01-01','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(47,'0053','Sihar Jeremia Ariamusky Hutagalung','L','','GKI Bintaro','2001-05-12','Jakarta','1982-02-24','1983-11-20','1966-07-11','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(48,'0078','Jogiara Ekaristi Hutagalung','L','','GKI Bintaro','2001-05-12','Jakarta','1984-02-15','1984-12-09','2000-08-13','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(49,'0325','Abraham Hutagalung, RIP','L','','','2005-12-18','Jakarta','1985-11-18','1986-08-03','2005-12-18','1900-01-01','Meninggal Dunia','Belum Menikah',NULL,NULL,NULL,NULL),(50,'0039','Sapta Asih Handayani ( Atestasi)','P','','GKI Bintaro','2001-05-12','Magelang','1972-02-19','1900-01-01','1991-09-22','1900-01-01','Atestasi','Belum Menikah',NULL,NULL,NULL,NULL),(51,'0040','David Bren Pohanto Siahaan ( Atestasi)','L','','GKI Bintaro','2001-05-12','Tinjoan','1958-06-02','1900-01-01','1989-07-30','1900-01-01','Atestasi','Belum Menikah',NULL,NULL,NULL,NULL),(52,'0041','Christanta Sautmaida Mauli Rilaneke Pardede, RIP','P','','GKI Bintaro','2001-05-12','','1900-01-01','1900-01-01','1900-01-01','1900-01-01','Meninggal Dunia','Belum Menikah',NULL,NULL,NULL,NULL),(53,'0427','Juan Davin Partogi Siahaan (Pindah)','L','','','1900-01-01','Jakarta','1990-08-16','1900-01-01','1900-01-01','1900-01-01','Atestasi','Belum Menikah',NULL,NULL,NULL,NULL),(54,'0042','Yolanda Sri Mawar Dameria Tampubolon','P','','GKI Bintaro','2001-05-12','','1900-01-01','1900-01-01','1900-01-01','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(55,'0043','Djaisorba Sihotang','L','','GKI Bintaro','2001-05-12','Tampahan Samosir','1951-10-05','1900-01-01','1900-01-01','1981-08-04','Aktif','Menikah',NULL,NULL,NULL,NULL),(56,'0044','Dahlia Anceli Siregar','P','','GKI Bintaro','2001-05-12','Bangka','1958-07-10','1900-01-01','1979-02-22','1981-08-04','Aktif','Menikah',NULL,NULL,NULL,NULL),(57,'0283','Johan Parulian Sihotang','L','','Gereja Pantekosta ','1900-01-01','Pangkal Pinang Bangka','1982-07-11','1982-08-08','2000-02-27','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(58,'1053','Rury Tisyana','P','','GKI Kebayoran Baru ','2023-02-26','Surabaya','1981-03-02','2009-03-15','2009-03-15','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(59,'0079','Paul Januardo Sihotang','L','','GKI Bintaro','2001-05-12','Bangka','1984-01-27','1984-01-21','2000-08-13','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(60,'0231','Yollanda Oktaviane','P','','GKI Bintaro','2003-12-21','Jakarta','1986-10-25','1987-04-05','2003-12-21','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(61,'0333','Jason Timothy Sihotang','L','','GKI Bintaro','2005-12-18','Jakarta','1989-12-13','1900-01-01','2005-12-25','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(62,'0045','Frans Christianto Sitohang, RIP','L','0811 827788','GKI Bintaro','2001-05-12','','1971-02-25','1997-06-22','1900-01-01','1900-01-01','Meninggal Dunia','Belum Menikah',NULL,NULL,NULL,NULL),(63,'0460','Doni Novida Siregar','P','','','2009-06-05','','1981-11-15','1994-12-04','2009-01-31','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(64,'0046','Paul Patty','L','','GKI Bintaro','2001-05-12','Jakarta','1954-02-07','1954-07-11','1972-08-06','1992-12-05','Aktif','Menikah',NULL,NULL,NULL,NULL),(65,'0047','Wigya Sawitri','P','','GKI Bintaro','2001-05-12','Jakarta','1963-01-24','1963-03-24','1980-05-11','1992-12-05','Aktif','Menikah',NULL,NULL,NULL,NULL),(66,'0048','Parsaoran Hutagalung','L','','','1900-01-01','Tarutung','1951-12-15','1900-01-01','1967-07-30','1977-12-06','Aktif','Menikah',NULL,NULL,NULL,NULL),(67,'0049','Ernawaty','P','','','1900-01-01','Surabaya','1960-10-10','1900-01-01','1980-08-10','1977-12-06','Aktif','Menikah',NULL,NULL,NULL,NULL),(68,'0050','Maria Magdalena Supijah, RIP','P','','','1900-01-01','Semarang','1931-12-27','1983-12-11','1986-10-19','1900-01-01','Meninggal Dunia','Belum Menikah',NULL,NULL,NULL,NULL),(69,'0051','Darmo Tjahjadi (Atestasi)','L','','GKI Bintaro','2001-05-12','Malang','1966-02-03','1999-03-04','1993-12-12','1992-10-11','Atestasi','Menikah',NULL,NULL,NULL,NULL),(70,'0052','Swaty Tandaputra','P','','GKI Bintaro','2001-05-12','Subang','1964-06-18','1981-03-08','1981-03-08','1992-10-11','Aktif','Menikah',NULL,NULL,NULL,NULL),(71,'0054','Yahya Jujur Hutagaling','L','','','1900-01-01','Medan','1981-02-25','1982-08-22','1999-07-11','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(72,'0056','Sugeng','L','','GKI Bintaro','2001-05-12','','1959-03-01','1999-07-11','1999-07-11','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(73,'0097','Ike Puspita Sari','P','','GKI Bintaro','2001-09-02','Jakarta','1984-08-29','1900-01-01','2001-09-02','2003-11-03','Aktif','Menikah',NULL,NULL,NULL,NULL),(74,'1123','Benjamin Sondakh','L','08161851035','','2024-05-12','Jember','1969-07-08','1969-12-07','1988-03-27','2003-11-03','Aktif','Menikah',NULL,NULL,NULL,NULL),(75,'1090','Valerie Raffela Nataniela Sondakh ','P','','GKI Maleo Raya','2023-11-19','Jakarta','2007-10-19','2008-07-20','2023-11-19','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(76,'0229','Nila Pudji Pramesti','P','','GKI Bintaro','2003-12-21','Jakarta','1986-09-28','1986-12-25','2003-12-21','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(77,'0625','Bernando Rico Irawan','L','0856 9535 3794','GKI Bintaro','2012-11-18','Jakarta','1996-01-01','1999-12-25','2012-11-18','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(78,'0057','Sutarjo Osman (Pindah)','L','','GKI Bintaro','2001-05-12','Selat Panjang','1964-12-25','1900-01-01','1999-07-11','1995-09-02','Atestasi','Menikah',NULL,NULL,NULL,NULL),(79,'0201','Candrayu Mutiarani (pindah)','P','','GKI Bintaro','2001-05-12','Tanjung Balai','1960-03-06','1979-12-16','1979-12-16','1995-09-02','Atestasi','Menikah',NULL,NULL,NULL,NULL),(80,'0058','Nandia Bimantoro Elifas','L','','GKI Bintaro','2001-05-12','Bandung','1967-04-15','1967-07-09','1984-11-18','1991-01-05','Aktif','Menikah',NULL,NULL,NULL,NULL),(81,'0059','Triani Irawati','P','','GKI Bintaro','2001-05-12','Bandung','1965-06-09','1900-01-01','1900-01-01','1991-01-05','Aktif','Menikah',NULL,NULL,NULL,NULL),(82,'0602','Raynandi Irawan Elifas','L','','GKI Bintaro','1900-01-01','Tangerang','1991-10-26','1991-12-08','2011-11-27','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(83,'0631','Reinaldo Nathaniel Elifas','L','0857 8027 3313','GKI Bintaro','1900-01-01','Tangerang','1995-01-21','1997-06-01','2012-11-18','2022-09-09','Aktif','Menikah',NULL,NULL,NULL,NULL),(84,'1140','Rafael Benjamin Elifas ','L','','GKI Bintaro','2024-07-28','Tangerang','2006-09-26','2010-12-25','2022-11-06','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(85,'0060','Vence J Tuturoong, RIP','L','','GKI Bintaro','2001-05-12','Manado','1939-11-11','1940-05-23','1973-11-04','1987-11-04','Meninggal Dunia','Menikah',NULL,NULL,NULL,NULL),(86,'0061','Itje Lumingkewas, RIP','P','','GKI Bintaro','2001-05-12','Manado','1952-07-12','1900-01-01','1987-12-06','1987-11-04','Meninggal Dunia','Menikah',NULL,NULL,NULL,NULL),(87,'0062','Pahla Santoso','L','','GKI Bintaro','2001-05-12','Pati','1958-11-12','1976-11-28','1900-01-01','1985-07-14','Aktif','Menikah',NULL,NULL,NULL,NULL),(88,'0082','Ruti Dani Latifa','P','','GKI Bintaro','2001-05-12','Semarang','1962-05-31','2000-08-13','2000-08-13','1985-07-14','Aktif','Menikah',NULL,NULL,NULL,NULL),(89,'0233','Ruti Puspita Sari','P','','GKI Bintaro','2003-12-21','Semarang','1987-08-02','1999-12-25','2003-12-21','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(90,'0413','Ruti Devi Permatasari','P','','GKI Bintaro','2007-12-02','Jakarta','1991-03-04','1991-03-04','2007-12-02','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(91,'0063','Edwin Harold Huka','L','','GKI Bintaro','2001-05-12','Ambon','1970-03-14','1900-01-01','1988-03-27','1996-09-29','Aktif','Menikah',NULL,NULL,NULL,NULL),(92,'0064','Ika Indayanti','P','','GKI Bintaro','2001-05-12','Jombang','1972-01-03','1900-01-01','1993-04-04','1996-09-29','Aktif','Menikah',NULL,NULL,NULL,NULL),(93,'0712','Alexandra Endmar Huka','P','','GKI Bintaro','2014-11-02','Jakarta','1997-04-30','1999-12-25','2014-11-02','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(94,'0066','Aliaro Lavau, RIP','L','','GKI Bintaro','2001-05-12','Nias','1947-08-15','1959-12-14','1900-01-01','1982-04-17','Aktif','Menikah',NULL,NULL,NULL,NULL),(95,'0067','Edna Debbie Rambu Moha Haga','P','','GKI Bintaro','2001-05-12','Waikabubak','1945-10-06','1965-10-28','1965-09-26','1982-04-17','Aktif','Menikah',NULL,NULL,NULL,NULL),(96,'0223','Nano Waty M. Haga','P','','Gereja Kristen Sumba','1900-01-01','Sumba Barat','1980-04-22','1900-01-01','1999-07-11','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(97,'0068','Daud Suryanto','L','','GKI Bintaro','2001-05-12','Jakarta','1953-09-12','1983-07-30','1986-08-17','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(98,'0069','Jeannette Yvonne Wuaten','P','','GKI Bintaro','2001-05-12','Manado','1952-06-08','1900-01-01','1973-12-02','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(99,'0077','Rollando Marchell Suryanto','L','','GKI Bintaro','2001-05-12','Jakarta','1984-03-12','1985-12-15','2000-08-13','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(100,'0070','Jeremy Alwi Effendi','L','','GKI Bintaro','2001-05-12','Tangerang','1956-08-26','1979-10-07','1984-08-05','1985-05-04','Aktif','Menikah',NULL,NULL,NULL,NULL),(101,'0071','Nurijati Sukandi','P','','GKI Bintaro','2001-05-12','Jakarta','1960-09-29','1984-08-05','1984-08-05','1985-05-04','Aktif','Menikah',NULL,NULL,NULL,NULL),(102,'0431','Astrid Martina Efendi','P','','GKI Bintaro','2008-11-16','Jakarta','1986-02-14','1989-06-11','2008-11-16','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(103,'0414','Stefan Efendi','L','','GKI Bintaro','2007-12-02','Jakarta','1991-06-16','1995-02-12','2007-12-02','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(104,'0475','Davin Efendi','L','','GKI Bintaro','2009-11-08','Jakarta','1993-07-09','1995-02-12','2009-11-08','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(105,'0072','Nugraha Yudhi Rumpaka','L','','','1900-01-01','Solo','1975-02-22','1975-09-07','1992-06-07','2001-08-11','Aktif','Menikah',NULL,NULL,NULL,NULL),(106,'0073','Hisar Parhusip Nainggolan, RIP','L','','GKI Bintaro','2001-05-12','','1952-09-15','1900-01-01','1900-01-01','1900-01-01','Meninggal Dunia','Belum Menikah',NULL,NULL,NULL,NULL),(107,'0074','Caroline Wilhelmin Carel','P','','GKI Bintaro','2001-05-12','Ambon','1950-02-23','1900-01-01','1900-01-01','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(108,'0340','Jaya Henry Natal Nainggolan, RIP','L','','GKI Bintaro','1900-01-01','','1900-01-01','1900-01-01','1900-01-01','1900-01-01','Meninggal Dunia','Belum Menikah',NULL,NULL,NULL,NULL),(109,'0341','Berliana Indah Muliawati Nainggolan','P','','GKI Bintaro','1900-01-01','Jakarta','1982-05-18','1982-12-25','1999-07-11','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(110,'0080','Jefferson Nainggolan','L','','GKI Bintaro','2001-05-12','Jakarta','1983-09-07','1984-12-26','2000-08-13','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(111,'0081','Ari Widianto','L','','GKI Bintaro','2001-05-12','Jakarta','1984-05-29','1986-05-11','2000-08-13','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(112,'0083','Saidjadi P.H. Simamora (Atestasi)','L','0816 181 9740','GKI Bintaro','2001-05-12','Semarang','1971-12-18','1990-03-27','1995-04-11','1995-04-11','Atestasi','Menikah',NULL,NULL,NULL,NULL),(113,'0084','Sri Hartatik (Atestasi)','P','','GKI Bintaro','2001-05-12','','1900-01-01','1995-04-16','1995-04-11','1995-04-11','Atestasi','Menikah',NULL,NULL,NULL,NULL),(114,'0085','Denny Christiyanto','L','','','1900-01-01','Jakarta','1967-09-09','1968-12-22','1992-04-05','1997-07-26','Aktif','Menikah',NULL,NULL,NULL,NULL),(115,'0086','Riris Monica Natalia P. Christyanto','P','','','1900-01-01','Jakarta','1972-12-07','1900-01-01','1900-01-01','1997-07-26','Aktif','Menikah',NULL,NULL,NULL,NULL),(116,'0087','Hartono Sutjiadji, RIP','L','','GKI Ayudia Bandung','2001-06-28','Kebumen','1925-09-12','1960-06-19','1960-06-19','1960-02-23','Meninggal Dunia','Menikah',NULL,NULL,NULL,NULL),(117,'0088','Karolina Tedja, RIP','P','','GKI Ayudia Bandung','2001-06-28','Purwakarta','1934-07-13','1953-06-21','1953-06-21','1960-02-23','Meninggal Dunia','Menikah',NULL,NULL,NULL,NULL),(118,'0089','Deesyani Sutjiadji, RIP','P','','GKI Ayudia Bandung','2001-06-28','Bandung','1962-12-02','1963-03-17','1981-03-08','1990-12-08','Meninggal Dunia','Menikah',NULL,NULL,NULL,NULL),(119,'0106','Djono Salim','L','','GKI Jabar Bogor','2001-06-28','Jakarta','1961-11-29','1970-06-19','1983-05-12','1990-12-08','Aktif','Menikah',NULL,NULL,NULL,NULL),(120,'0783','Michael Jonathan Salim','L','','GKI Maleo Raya','2016-11-11','Jakarta','2000-07-16','1900-01-01','2016-11-06','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(121,'0144','Bennyanto Sutjiadji','L','','GKI Bintaro','2202-08-04','Bandung','1961-06-19','1961-09-17','1900-01-01','1998-09-19','Aktif','Menikah',NULL,NULL,NULL,NULL),(122,'0145','Raina Abednego','P','081314594828','GKI Bintaro','2202-08-04','Bogor','1967-07-23','1967-09-10','1985-03-03','1998-09-19','Aktif','Menikah',NULL,NULL,NULL,NULL),(123,'0090','Meilani Sutjiadji','P','','GKI Ayudia Bandung','2001-06-28','Bandung','1965-05-12','1965-09-26','1981-12-13','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(124,'0091','Dyan Sinembadan, RIP','L','','GPIB Imanuel Ujungpandang','2001-10-07','Surabaya','1957-11-18','1958-05-18','1900-01-01','1985-03-16','Meninggal Dunia','Menikah',NULL,NULL,NULL,NULL),(125,'0092','Janeke Selfia Kawulusan','P','','GPIB Imanuel Ujungpandang','2001-10-07','Ujungpandang','1958-09-18','1960-07-10','1980-03-30','1985-03-16','Aktif','Menikah',NULL,NULL,NULL,NULL),(126,'0278','Yananta Ruland Sinembadan','L','','GKI Maleo Raya','1900-01-01','Makasar','1985-09-18','1900-01-01','2004-11-21','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(127,'0279','Harjuna Sabathino Sinembadan','L','','GKI Maleo Raya','1900-01-01','Makasar','1987-01-31','1900-01-01','2004-11-21','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(128,'0633','Stanny Agengingsih Sinembadan','P','0812 8668 7224','GKI Maleo Raya','2012-11-18','Ujung Pandang','1994-04-04','2001-08-19','2012-11-18','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(129,'0093','Victor Reinhard Bengu','L','','GPIB Gibeon','2001-07-01','Flores','1957-07-14','1977-03-12','1996-12-01','1997-01-04','Aktif','Menikah',NULL,NULL,NULL,NULL),(130,'0094','Indah Ratih Sari','P','','GPIB Gibeon','2001-07-01','Kota Baru','1972-03-23','1996-12-01','1996-12-01','1997-01-04','Aktif','Menikah',NULL,NULL,NULL,NULL),(131,'0685','Irvan Yunus Bengu','L','','GKI Maleo Raya','2013-11-10','Jakarta','1997-06-19','1998-01-04','2013-11-10','2024-06-08','Aktif','Menikah',NULL,NULL,NULL,NULL),(132,'0723','Rivaldi Ezra Bengu','L','','GKI Maleo Raya','2014-11-02','Jakarta','1998-08-15','1998-12-06','2014-11-02','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(133,'0786','Alvin Yehezkiel Bengu','L','082112203863','GKI Maleo Raya','2016-11-11','Tangerang','2000-11-25','2001-08-19','2016-11-06','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(134,'0096','Ismoko Anjar Sunarso','L','','','2001-09-02','Surakarta','1983-07-21','1900-01-01','2001-09-02','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(135,'0098','Aprinius','L','','GKE Bontang','2001-11-01','Buntok','1966-04-07','1900-01-01','1900-01-01','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(136,'0099','Dewi Cahaya Ningrum','P','','GKE Bontang','2001-11-01','Kuala Kapuas','1970-05-23','1900-01-01','1900-01-01','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(137,'0100','Nimbangsa Sinulingga, RIP','L','','GKO Jemaat Bintaro','2001-07-22','Lau Pakam','1953-06-05','1972-07-09','1972-07-09','1986-09-19','Meninggal Dunia','Menikah',NULL,NULL,NULL,NULL),(138,'0101','Maimunah, RIP','P','','GKO Jemaat Bintaro','2001-07-22','Babat','1952-05-27','1984-11-25','1984-11-25','1986-09-19','Aktif','Menikah',NULL,NULL,NULL,NULL),(139,'0127','Agung Basmantyo Sinulingga ','L','','GKI Maleo Raya','2002-03-24','Surabaya','1979-08-05','1984-11-25','1996-10-13','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(140,'0182','Teguh Suranta Sinulingga','L','','GKI Maleo Raya','2002-11-17','Lhok Seumawe','1984-03-04','1900-01-01','2002-11-17','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(141,'0183','Wahyu Cristianta Sinulingga','L','','GKI Maleo Raya','2002-11-17','Lhok Seumawe','1986-03-23','1900-01-01','1900-01-01','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL),(142,'0326','Corah Sinulingga','L','','GKI Maleo Raya','2005-12-18','Kaban Jahe','1988-05-20','1900-01-01','2005-12-18','1900-01-01','Aktif','Belum Menikah',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `jemaat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kategoriberitas`
--

DROP TABLE IF EXISTS `kategoriberitas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kategoriberitas` (
  `id_kategori` int unsigned NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategoriberitas`
--

LOCK TABLES `kategoriberitas` WRITE;
/*!40000 ALTER TABLE `kategoriberitas` DISABLE KEYS */;
/*!40000 ALTER TABLE `kategoriberitas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kk_jemaat`
--

DROP TABLE IF EXISTS `kk_jemaat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kk_jemaat` (
  `id_kk_jemaat` int NOT NULL AUTO_INCREMENT,
  `id_group_wilayah` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_jemaat` int NOT NULL,
  `alamat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_kk_jemaat`),
  KEY `fk_id_group_wilayah_kk` (`id_group_wilayah`),
  KEY `fk_id_jemaat_kk` (`id_jemaat`),
  CONSTRAINT `fk_id_group_wilayah_kk` FOREIGN KEY (`id_group_wilayah`) REFERENCES `group_wilayah` (`id_group_wilayah`) ON DELETE CASCADE,
  CONSTRAINT `fk_id_jemaat_kk` FOREIGN KEY (`id_jemaat`) REFERENCES `jemaat` (`id_jemaat`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kk_jemaat`
--

LOCK TABLES `kk_jemaat` WRITE;
/*!40000 ALTER TABLE `kk_jemaat` DISABLE KEYS */;
INSERT INTO `kk_jemaat` VALUES (1,'0',1,'Jl. Cikini Raya Blok FG-5 No.7,Sektor VII, Bintaro Jaya  ',NULL,NULL,NULL,NULL),(2,'0',4,'Jl. Dahlia Blok D2 No.11, Komp. Kimia Farma Hankam, Parung Serab',NULL,NULL,NULL,NULL),(3,'0',6,'Jl. Puter  Blok EF 7/1, Sektor V Bintaro Jaya ',NULL,NULL,NULL,NULL),(4,'0',9,'Jl.Anggrek Lili  Blok AA No.47 Sektor 2.2, Anggrek Loka BSD',NULL,NULL,NULL,NULL),(5,'0',11,'',NULL,NULL,NULL,NULL),(6,'0',12,'Wisma Pondok Aren',NULL,NULL,NULL,NULL),(7,'0',15,'Jl. Pinguin VI Blok CH No.5 Sektor III, Bintaro Jaya ',NULL,NULL,NULL,NULL),(8,'0',17,'Jl.Anggrek Lili  Blok AA No.47 Sektor 2.2 Anggrek Loka BSD',NULL,NULL,NULL,NULL),(9,'0',18,'Jl. M Saidi Raya No.74Sektor 3 Komp.Nuansa Pesanggarahan Kav E3. Petukangan Selatan Jkt 12270',NULL,NULL,NULL,NULL),(10,'0',21,'Jl. Kuricang XIX Blok GD V No. 13, Bintaro Jaya',NULL,NULL,NULL,NULL),(11,'0',23,'Jl. Kuricang III Blok GD I No. 10, Pondok Bintaro ',NULL,NULL,NULL,NULL),(12,'0',25,'',NULL,NULL,NULL,NULL),(13,'0',27,'Komp. Mabad 25 C2 Rt.009/05, Rempoa - ',NULL,NULL,NULL,NULL),(14,'0',28,'',NULL,NULL,NULL,NULL),(15,'0',30,'Pondok Maharta Blok B 27/15, Pondok Kacang Timur',NULL,NULL,NULL,NULL),(16,'0',31,'Jl. Maleo XXI JE 6/11, Sektor IX - Bintaro Jaya',NULL,NULL,NULL,NULL),(17,'0',35,'Jl. Maleo XVI Blok JE V/45, Sektor IX - Bintaro Jaya',NULL,NULL,NULL,NULL),(18,'0',37,'Jl. Perkici I Blok EB I/6-8, Sektor V - Bintaro Jaya ',NULL,NULL,NULL,NULL),(19,'0',40,'Jl. Taman Bintaro Blok E/11, Sektor II - Bintaro Jaya',NULL,NULL,NULL,NULL),(20,'0',45,'Jl. Pisok Blok EA I/4, Sektor V - Bintaro Jaya',NULL,NULL,NULL,NULL),(21,'0',50,'Jl. Mertilang VII KA.6/11, Sektor IX, Bintaro Jaya',NULL,NULL,NULL,NULL),(22,'0',51,'Villa Bintaro Indah Blok EX/11, Jombang, Tangerang',NULL,NULL,NULL,NULL),(23,'0',54,'Jl. Maleo XVIII JE 4/5, Sektor IX - Bintaro Jaya ',NULL,NULL,NULL,NULL),(24,'0',55,'Puri Bintaro, Blok PB-2 No.14',NULL,NULL,NULL,NULL),(25,'0',62,'Villa Dago Tol D 12/15, Sarua, Ciputat',NULL,NULL,NULL,NULL),(26,'0',64,'Villa Bintaro Indah, Blok B-8 /8, Jombang, Ciputat',NULL,NULL,NULL,NULL),(27,'0',66,'',NULL,NULL,NULL,NULL),(28,'0',68,'',NULL,NULL,NULL,NULL),(29,'0',69,'The Castilla Blok B6. No.8 Sektor 14-IV, BSD City',NULL,NULL,NULL,NULL),(30,'0',72,'Jl. Amal Bakti Rt.007/02 No.42, Rengas Ciputat',NULL,NULL,NULL,NULL),(31,'0',78,'Villa Bintaro Regency, Blok C-IV/4, Pdk. Kacang Timur Pondok Aren',NULL,NULL,NULL,NULL),(32,'0',85,'Komp. Mabad 25 C2 Rt. 009/05, Rempoa - Ciputat',NULL,NULL,NULL,NULL),(33,'0',87,'Komplek Menteng Bintaro, Jl.Menteng Utama III Blok FB 12 No.19 Sektor VII',NULL,NULL,NULL,NULL),(34,'0',91,'Graha Bintaro GR 11/39, Pondok Kacang Barat',NULL,NULL,NULL,NULL),(35,'0',94,'Jl. Camar V Blok AG-37, Sektor III - Bintaro Jaya',NULL,NULL,NULL,NULL),(36,'0',97,'Jl. Puter II Blok ED II/4, Sektor V - Bintaro Jaya',NULL,NULL,NULL,NULL),(37,'0',100,'Jl. Puter V Blok EF 1/11, Sektor V - Bintaro Jaya',NULL,NULL,NULL,NULL),(38,'0',105,'',NULL,NULL,NULL,NULL),(39,'0',106,'Jl. Puskesmas No.21 Rt.006/04, Pondok Aren',NULL,NULL,NULL,NULL),(40,'0',111,'Jl.Kayu Putih No.23 Pondok Cabe, Tangerang Selatan',NULL,NULL,NULL,NULL),(41,'0',112,'Pindah Alamat dari Villa Bintaro Regency    Blok A4/9, Jombang - Pondok Aren',NULL,NULL,NULL,NULL),(42,'0',114,'',NULL,NULL,NULL,NULL),(43,'0',116,'Jl. Kasuari 4 HB 4/2, Sektor IX - Bintaro Jaya',NULL,NULL,NULL,NULL),(44,'0',124,'Villa Bintaro Indah Blok B. VIII/2A,  Jombang, Ciputat',NULL,NULL,NULL,NULL),(45,'0',129,'Jl. Kasuari III Blok HB 3/22, Sektor IX, Bintaro Jaya',NULL,NULL,NULL,NULL),(46,'0',134,'Jl. Anggrek II No. 18 Pondok Ranji, Pondok Aren',NULL,NULL,NULL,NULL),(47,'0',135,'Jl. Maleo Raya Blok JE.5 No.26 Sektor IX  Bintaro Jaya, Tangerang  Selatan',NULL,NULL,NULL,NULL),(48,'0',137,'Jl. Maleo Blok JC 1 No.20, Sektor IX - Bintaro Jaya',NULL,NULL,NULL,NULL),(49,'0',57,'Jl. Elang II Blok HF 2 No.10 Bintaro Jaya, Tangerang',NULL,NULL,NULL,NULL),(50,'0',59,'Puri Bintaro, Blok PB-5 No.2',NULL,NULL,NULL,NULL),(51,'0',71,'-',NULL,NULL,NULL,NULL),(52,'0',74,'Villa Bintaro Regency, Jl. Flores Blok E-3/8, Pondok Kacang Timur. Pondok Aren',NULL,NULL,NULL,NULL),(53,'0',80,'Villa Bintaro Indah Blok B.III No.8,Jombang, Ciputat',NULL,NULL,NULL,NULL),(54,'0',119,'Jl. Kasuari 12 HB 14 No.12, Sektor IX - Bintaro Jaya',NULL,NULL,NULL,NULL),(55,'0',12,'Jl. Kasuari 12 HB 14 No.12, Sektor IX - Bintaro Jaya',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `kk_jemaat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `master_bulans`
--

DROP TABLE IF EXISTS `master_bulans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `master_bulans` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_bulan` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_bulan` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `master_bulans`
--

LOCK TABLES `master_bulans` WRITE;
/*!40000 ALTER TABLE `master_bulans` DISABLE KEYS */;
/*!40000 ALTER TABLE `master_bulans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `master_kecamatans`
--

DROP TABLE IF EXISTS `master_kecamatans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `master_kecamatans` (
  `id_kecamatan` char(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_kota_kabupaten` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kecamatan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_kecamatan`),
  KEY `districts_id_index` (`id_kota_kabupaten`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `master_kecamatans`
--

LOCK TABLES `master_kecamatans` WRITE;
/*!40000 ALTER TABLE `master_kecamatans` DISABLE KEYS */;
/*!40000 ALTER TABLE `master_kecamatans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `master_kelurahans`
--

DROP TABLE IF EXISTS `master_kelurahans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `master_kelurahans` (
  `id_kelurahan` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_kecamatan` char(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelurahan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id_kelurahan`),
  KEY `urbans_district_id_index` (`id_kecamatan`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `master_kelurahans`
--

LOCK TABLES `master_kelurahans` WRITE;
/*!40000 ALTER TABLE `master_kelurahans` DISABLE KEYS */;
/*!40000 ALTER TABLE `master_kelurahans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `master_kota_kabupatens`
--

DROP TABLE IF EXISTS `master_kota_kabupatens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `master_kota_kabupatens` (
  `id_kota_kabupaten` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_provinsi` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kota_kabupaten` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id_kota_kabupaten`),
  KEY `cities_province_id_index` (`id_provinsi`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `master_kota_kabupatens`
--

LOCK TABLES `master_kota_kabupatens` WRITE;
/*!40000 ALTER TABLE `master_kota_kabupatens` DISABLE KEYS */;
/*!40000 ALTER TABLE `master_kota_kabupatens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `master_provinsis`
--

DROP TABLE IF EXISTS `master_provinsis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `master_provinsis` (
  `id_provinsi` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `provinsi` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id_provinsi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `master_provinsis`
--

LOCK TABLES `master_provinsis` WRITE;
/*!40000 ALTER TABLE `master_provinsis` DISABLE KEYS */;
/*!40000 ALTER TABLE `master_provinsis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `master_roles`
--

DROP TABLE IF EXISTS `master_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `master_roles` (
  `id_role` int unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `aktif` tinyint(1) DEFAULT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `master_roles`
--

LOCK TABLES `master_roles` WRITE;
/*!40000 ALTER TABLE `master_roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `master_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menus` (
  `id_menu` int unsigned NOT NULL AUTO_INCREMENT,
  `id_parent` int NOT NULL DEFAULT '0',
  `nama_menu` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_menu` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `publish` enum('Y','T') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `isi_menu` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `gambar` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dokumen` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `posisi` int DEFAULT NULL,
  `highlight` enum('Y','T') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'T',
  `deleted_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_menu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (7,'0001_01_01_000000_create_users_table',1),(8,'0001_01_01_000001_create_cache_table',1),(9,'0001_01_01_000002_create_jobs_table',1),(10,'2025_01_15_173152_add_is_admin_column_to_user_table',1),(13,'2025_01_15_201430_add_timestamps_to_group_wilayah',2),(14,'2025_01_15_215922_add_id_group_wilayah_to_kk_jemaat_table',3),(15,'2025_01_15_225400_add_timestamps_to_kk_jemaat_table',3),(16,'2025_01_15_230535_add_foreign_key_to_kk_jemaat_table',4),(17,'2025_01_16_002421_add_timestamps_to_jemaat_table',5),(18,'2025_01_16_003109_add_defaults_to_jemaat_table',6),(19,'2025_01_16_003737_remove_foto_jemaat_from_jemaat_table',7),(23,'2025_01_16_005557_update_columns_in_jemaat_table',8),(24,'2025_01_16_013518_update_primary_key_kkjemaat_table',8);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `moduls`
--

DROP TABLE IF EXISTS `moduls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `moduls` (
  `id_modul` int unsigned NOT NULL AUTO_INCREMENT,
  `nama_modul` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_modul` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `publish` enum('Y','T') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `aktif` enum('Y','T') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('Administrator','Pangan','Pertanian','Peternakan','User') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `par` int DEFAULT '0',
  `role_id` int unsigned DEFAULT NULL,
  `slug` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `folder` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_modul`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `moduls`
--

LOCK TABLES `moduls` WRITE;
/*!40000 ALTER TABLE `moduls` DISABLE KEYS */;
INSERT INTO `moduls` VALUES (1,'Manajemen Web','#','T','Y','Administrator','settings text-primary',0,0,'manajemen-web','web'),(2,'Menu','menu','T','Y','Administrator','MN',1,0,'menu','web'),(3,'Kategori Berita','kategoriberita','T','T','User','FD',1,0,'kategori-berita','web'),(4,'Berita dan Kagiatan','berita','T','Y','User','NW',1,0,'berita-kegiatan','web'),(5,'Kegiatan','kegiatan','T','T','Administrator','KG',1,0,'kegiatan','web'),(6,'IdentitasWeb','identitasweb','T','Y','Administrator','WEB',1,0,'identitas-web','web'),(7,'Slider','slider','T','T','Administrator','SLD',1,0,'slider','web'),(8,'Foto','foto','T','Y','Administrator','FT',1,0,'album-foto','web'),(9,'Video','video','T','Y','Administrator','VD',1,0,'video','web'),(10,'Manajemen User','user','T','Y','User','USR',1,0,'manajemen-user','web'),(11,'Administrasi Jemaat','#','T','Y','Administrator','books text-success',0,0,'administrasi-jemaat','administrasi'),(12,'Data Jemaat','data-jemaat','T','Y','Administrator','JMT',11,0,'data-jemaat','administrasi');
/*!40000 ALTER TABLE `moduls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('dE3PSJ56zmK4ZMpUSzNzsUyOJsrE7APGqi8000sb',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36','YTo1OntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im5ldyI7YTowOnt9czozOiJvbGQiO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoieGViTkdKMmh5MmxHT2RWZDRRZlh1TXNjbnpsYnZaaXA3ZkIwdFE2RyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ob21lIjt9czo3OiJpZF91c2VyIjtpOjI7czo4OiJpc19hZG1pbiI7aTowO30=',1737172365),('EtnY5e9pzCZLA5BEDf5lNsMttenpM5xZ2RmJpbXw',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiQ1NZODhidlVEd2dWY1pjbWIxVHNuZklFbEdVZXZlUkNzMWd5Ykl3bCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9rZWxvbGEtaHVidW5nYW4ta2VsdWFyZ2EiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjc6ImlkX3VzZXIiO2k6MjtzOjg6ImlzX2FkbWluIjtpOjA7fQ==',1737465266);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sliders`
--

DROP TABLE IF EXISTS `sliders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sliders` (
  `id_slides` int NOT NULL AUTO_INCREMENT,
  `judul` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `url` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `gambar` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `publish` enum('Y','N') CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT 'Y',
  PRIMARY KEY (`id_slides`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sliders`
--

LOCK TABLES `sliders` WRITE;
/*!40000 ALTER TABLE `sliders` DISABLE KEYS */;
/*!40000 ALTER TABLE `sliders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `u_mods`
--

DROP TABLE IF EXISTS `u_mods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `u_mods` (
  `id_umod` int unsigned NOT NULL AUTO_INCREMENT,
  `id_modul` int NOT NULL,
  `id` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_umod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `u_mods`
--

LOCK TABLES `u_mods` WRITE;
/*!40000 ALTER TABLE `u_mods` DISABLE KEYS */;
/*!40000 ALTER TABLE `u_mods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `role` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aktif` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `google2fa_secret` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google2fa_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `role_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'UserDev','singadji@gmail.com',NULL,'Administrator','$2y$10$eWUx2x3mrDproat2NzheQuvZrdUaJcP3/WTh9PNeDJSfRaXYom9Sm',NULL,NULL,'2025-03-02 09:42:20','08_03_05_2021_05_25_Administrator.jpg','Y','',0,0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `videos`
--

DROP TABLE IF EXISTS `videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `videos` (
  `id_video` int unsigned NOT NULL AUTO_INCREMENT,
  `judul_video` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_youtube` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `publish` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_video`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `videos`
--

LOCK TABLES `videos` WRITE;
/*!40000 ALTER TABLE `videos` DISABLE KEYS */;
/*!40000 ALTER TABLE `videos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visits`
--

DROP TABLE IF EXISTS `visits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `visits` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `primary_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `secondary_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `score` bigint unsigned NOT NULL,
  `list` json DEFAULT NULL,
  `expired_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `visits_primary_key_secondary_key_unique` (`primary_key`,`secondary_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visits`
--

LOCK TABLES `visits` WRITE;
/*!40000 ALTER TABLE `visits` DISABLE KEYS */;
/*!40000 ALTER TABLE `visits` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-03-07 17:11:30
