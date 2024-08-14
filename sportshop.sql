-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versi server:                 8.0.30 - MySQL Community Server - GPL
-- OS Server:                    Win64
-- HeidiSQL Versi:               12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Membuang struktur basisdata untuk koperasi
CREATE DATABASE IF NOT EXISTS `koperasi` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `koperasi`;

-- membuang struktur untuk table koperasi.archives
CREATE TABLE IF NOT EXISTS `archives` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `loanId` bigint unsigned DEFAULT NULL,
  `paymentId` bigint unsigned DEFAULT NULL,
  `archivedAt` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `archives_loanid_foreign` (`loanId`),
  KEY `archives_paymentid_foreign` (`paymentId`),
  CONSTRAINT `archives_loanid_foreign` FOREIGN KEY (`loanId`) REFERENCES `loans` (`id`),
  CONSTRAINT `archives_paymentid_foreign` FOREIGN KEY (`paymentId`) REFERENCES `payments` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table koperasi.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table koperasi.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table koperasi.deposits
CREATE TABLE IF NOT EXISTS `deposits` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `memberId` bigint unsigned NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tipe` enum('wajib','pokok','sukarela') COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `deposits_memberid_foreign` (`memberId`),
  CONSTRAINT `deposits_memberid_foreign` FOREIGN KEY (`memberId`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table koperasi.failed_jobs
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

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table koperasi.installments
CREATE TABLE IF NOT EXISTS `installments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `MemberId` bigint unsigned NOT NULL,
  `loanId` bigint unsigned NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `receipt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `installments_loanid_foreign` (`loanId`),
  KEY `installments_memberid_foreign` (`MemberId`),
  CONSTRAINT `installments_loanid_foreign` FOREIGN KEY (`loanId`) REFERENCES `loans` (`id`),
  CONSTRAINT `installments_memberid_foreign` FOREIGN KEY (`MemberId`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table koperasi.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table koperasi.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table koperasi.loans
CREATE TABLE IF NOT EXISTS `loans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `amount` decimal(15,2) NOT NULL,
  `nik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pekerjaan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gaji_perbulan` decimal(15,2) NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_rekening` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `beban_keluarga` int NOT NULL,
  `hutang_lain` text COLLATE utf8mb4_unicode_ci,
  `penanggung_jawab` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gaji_penanggung_jawab` decimal(15,2) NOT NULL,
  `pekerjaan_penanggung_jawab` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alasan_meminjam` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pengajuan_bulan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `masa_pinjaman` int NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `memberId` bigint unsigned NOT NULL,
  `verifiedBy` bigint unsigned DEFAULT NULL,
  `approvedBy` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ktp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slip_gaji` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `due_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `loans_memberid_foreign` (`memberId`),
  KEY `loans_verifiedby_foreign` (`verifiedBy`),
  KEY `loans_approvedby_foreign` (`approvedBy`),
  CONSTRAINT `loans_approvedby_foreign` FOREIGN KEY (`approvedBy`) REFERENCES `users` (`id`),
  CONSTRAINT `loans_memberid_foreign` FOREIGN KEY (`memberId`) REFERENCES `users` (`id`),
  CONSTRAINT `loans_verifiedby_foreign` FOREIGN KEY (`verifiedBy`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table koperasi.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table koperasi.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table koperasi.payments
CREATE TABLE IF NOT EXISTS `payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `loanId` bigint unsigned NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `memberId` bigint unsigned NOT NULL,
  `notedBy` bigint unsigned NOT NULL,
  `paymentDate` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_loanid_foreign` (`loanId`),
  KEY `payments_memberid_foreign` (`memberId`),
  KEY `payments_notedby_foreign` (`notedBy`),
  CONSTRAINT `payments_loanid_foreign` FOREIGN KEY (`loanId`) REFERENCES `loans` (`id`),
  CONSTRAINT `payments_memberid_foreign` FOREIGN KEY (`memberId`) REFERENCES `users` (`id`),
  CONSTRAINT `payments_notedby_foreign` FOREIGN KEY (`notedBy`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table koperasi.reports
CREATE TABLE IF NOT EXISTS `reports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `loanId` bigint unsigned DEFAULT NULL,
  `paymentId` bigint unsigned DEFAULT NULL,
  `memberId` bigint unsigned NOT NULL,
  `reportDate` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reports_loanid_foreign` (`loanId`),
  KEY `reports_paymentid_foreign` (`paymentId`),
  KEY `reports_memberid_foreign` (`memberId`),
  CONSTRAINT `reports_loanid_foreign` FOREIGN KEY (`loanId`) REFERENCES `loans` (`id`),
  CONSTRAINT `reports_memberid_foreign` FOREIGN KEY (`memberId`) REFERENCES `users` (`id`),
  CONSTRAINT `reports_paymentid_foreign` FOREIGN KEY (`paymentId`) REFERENCES `payments` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table koperasi.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table koperasi.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nik` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_rekening` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pekerjaan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `golongan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gaji_perbulan` decimal(15,2) DEFAULT NULL,
  `ktp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slip_gaji` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Pengeluaran data tidak dipilih.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
