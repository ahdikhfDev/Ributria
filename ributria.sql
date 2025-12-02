-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table ributria.artists
CREATE TABLE IF NOT EXISTS `artists` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `genre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ributria.artists: ~5 rows (approximately)
INSERT IGNORE INTO `artists` (`id`, `name`, `genre`, `image`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
	(1, 'RIRIS MULYANTI', 'INDUSTRIAL NOISE', NULL, 1, 1, '2025-11-30 07:41:55', '2025-11-30 07:41:55'),
	(2, 'AHDI KHALIDA FATHIR', 'SYNTHWAVE', NULL, 1, 2, '2025-11-30 07:41:55', '2025-11-30 07:41:55'),
	(3, 'LUTFI', 'GLITCH HOP', NULL, 1, 3, '2025-11-30 07:41:55', '2025-11-30 07:41:55'),
	(4, 'KEYSA', 'DARK AMBIENT', NULL, 1, 4, '2025-11-30 07:41:55', '2025-11-30 07:41:55'),
	(5, 'FAIZ', 'DARK AMBIENT', NULL, 1, 5, '2025-11-30 07:41:55', '2025-11-30 07:41:55');

-- Dumping structure for table ributria.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ributria.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table ributria.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ributria.migrations: ~9 rows (approximately)
INSERT IGNORE INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2025_11_29_120116_create_site_settings_table', 1),
	(6, '2025_11_29_120122_create_artists_table', 1),
	(7, '2025_11_29_120128_create_tickets_table', 1),
	(8, '2025_11_30_142328_create_website_features_table', 1),
	(9, '2025_11_30_142333_create_transactions_table', 1);

-- Dumping structure for table ributria.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ributria.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table ributria.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ributria.personal_access_tokens: ~0 rows (approximately)

-- Dumping structure for table ributria.site_settings
CREATE TABLE IF NOT EXISTS `site_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `hero_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'BISING NGERILIS JIWA LO',
  `hero_description` text COLLATE utf8mb4_unicode_ci,
  `primary_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#ff1f1f',
  `secondary_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#ccff00',
  `background_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#050505',
  `oracle_prompt` text COLLATE utf8mb4_unicode_ci COMMENT 'Instruksi kepribadian AI',
  `location_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'JAKARTA (GBK)',
  `event_date` datetime DEFAULT NULL,
  `footer_coordinates` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '-6.2088° S, 106.8456° E',
  `ticket_label_top` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'PUSAT SENI',
  `ticket_label_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'BISING NGERILIS...',
  `ticket_label_bottom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'TAMPIL LIVE',
  `ticket_label_left` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'BISING NGE',
  `ticket_price_label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'HARGA',
  `ticket_price_display` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Rp 750K++',
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qris_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ributria.site_settings: ~1 rows (approximately)
INSERT IGNORE INTO `site_settings` (`id`, `hero_title`, `hero_description`, `primary_color`, `secondary_color`, `background_color`, `oracle_prompt`, `location_name`, `event_date`, `footer_coordinates`, `ticket_label_top`, `ticket_label_title`, `ticket_label_bottom`, `ticket_label_left`, `ticket_price_label`, `ticket_price_display`, `bank_name`, `bank_account_number`, `bank_account_name`, `qris_image`, `created_at`, `updated_at`) VALUES
	(1, 'BISING\nNGERILIS\nJIWA LO', 'Sistem tiket konser masa depan. Bukan cuma tiket doang, tapi akses ke dunia audio-visual tanpa batas.\nJangan cuma nonton. Bikin ribut.', '#880df0', '#f436f7', '#050505', 'You are \'The Oracle\', the ultimate hype-man and guide for the RiButRiA music festival.', 'JAKARTA (GBK)', '2025-12-30 19:00:00', '-6.2088° S, 106.8476° E', 'PUSAT apa aja', 'BISING NGERILIS...', 'TAMPIL LIVE', 'BISING NGE', 'HARGA', 'Rp 750K++', 'BCA', '1146626371323', 'Ahdi Khalida Fathir', 'payments/01KBAM0TKMQASX9673SBNYW9GX.jpg', '2025-11-30 07:41:55', '2025-11-30 07:59:22');

-- Dumping structure for table ributria.subscribers
CREATE TABLE IF NOT EXISTS `subscribers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subscribers_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ributria.subscribers: ~0 rows (approximately)

-- Dumping structure for table ributria.tracks
CREATE TABLE IF NOT EXISTS `tracks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `artist` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `audio_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ributria.tracks: ~2 rows (approximately)
INSERT IGNORE INTO `tracks` (`id`, `title`, `artist`, `audio_url`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
	(1, 'Everything U Are', 'Hindia', 'https://res.cloudinary.com/dym46ephk/video/upload/v1764423997/Hindia_-_everything_u_are_1_furpk2.mp3', 1, 1, '2025-11-30 07:41:56', '2025-11-30 07:41:56'),
	(2, 'Synthwave Demo', 'SoundHelix', 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3', 1, 2, '2025-11-30 07:41:56', '2025-11-30 07:41:56');

-- Dumping structure for table ributria.transactions
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ticket_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guest_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guest_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guest_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ticket_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL,
  `total_price` int NOT NULL,
  `unique_code` int NOT NULL,
  `payment_proof` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','waiting_approval','paid','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `transactions_code_unique` (`code`),
  UNIQUE KEY `transactions_ticket_code_unique` (`ticket_code`),
  KEY `transactions_ticket_id_foreign` (`ticket_id`),
  CONSTRAINT `transactions_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ributria.transactions: ~0 rows (approximately)

-- Dumping structure for table ributria.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ributria.users: ~1 rows (approximately)
INSERT IGNORE INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'admin', 'admin@gmail.com', NULL, '$2y$10$zVlZ0wAZWfd3ecMMwtuqZuGEYOd1Jheme16BDROBzcRdOnmKTH0R2', NULL, '2025-11-30 07:44:07', '2025-11-30 07:44:07');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
