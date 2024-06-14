-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table isms3.control_tbl
CREATE TABLE IF NOT EXISTS `control_tbl` (
  `control_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `hazard_id` bigint unsigned DEFAULT NULL,
  `opportunity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `new_control` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `responsibility` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int DEFAULT NULL,
  `finish_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`control_id`),
  KEY `control_tbl_hazard_id_foreign` (`hazard_id`),
  CONSTRAINT `control_tbl_hazard_id_foreign` FOREIGN KEY (`hazard_id`) REFERENCES `hazard_identify_tbl` (`hazard_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table isms3.control_tbl: ~0 rows (approximately)

-- Dumping structure for table isms3.failed_jobs
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

-- Dumping data for table isms3.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table isms3.hazard_identify_tbl
CREATE TABLE IF NOT EXISTS `hazard_identify_tbl` (
  `hazard_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `job_sequence` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hazard` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `can_cause` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hirarc_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`hazard_id`),
  KEY `hazard_identify_tbl_hirarc_id_foreign` (`hirarc_id`),
  CONSTRAINT `hazard_identify_tbl_hirarc_id_foreign` FOREIGN KEY (`hirarc_id`) REFERENCES `hirarc_tbl` (`hirarc_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table isms3.hazard_identify_tbl: ~0 rows (approximately)

-- Dumping structure for table isms3.hirarc_tbl
CREATE TABLE IF NOT EXISTS `hirarc_tbl` (
  `hirarc_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `desc_job` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prepared_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `approved_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`hirarc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table isms3.hirarc_tbl: ~0 rows (approximately)

-- Dumping structure for table isms3.incidents
CREATE TABLE IF NOT EXISTS `incidents` (
  `reportNo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dept_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_site` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `incident_location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `incident_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `incident_time` time NOT NULL,
  `incident_desc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `incident_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `incident_date` date DEFAULT NULL,
  PRIMARY KEY (`reportNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table isms3.incidents: ~5 rows (approximately)
INSERT INTO `incidents` (`reportNo`, `dept_name`, `project_site`, `incident_location`, `created_at`, `updated_at`, `incident_title`, `incident_time`, `incident_desc`, `incident_image`, `notes`, `incident_date`) VALUES
	('1isms3isms3isms3isms361057', 'Public Services', 'Sarawak', 'Sarawak', '2024-01-01 08:13:33', '2024-01-02 08:23:34', 'A student being struck by a fallen goalpost.', '13:12:00', 'A fifth-grade student died after being struck by a goalpost while hanging from it.', 'incident-image/incident_161057_', 'The fallen goalpost had suffered severe corrosion to the extent that the portion of the post embedded in the ground had broken away from its structure, causing it to collapse.', '2023-09-29'),
	('537020', 'Setiawangsaa', 'Ali Bistro', 'Belakang Ali Bistro', '2024-01-06 20:07:08', '2024-01-06 20:07:08', 'qweqwe', '13:04:00', 'asdasd', NULL, 'as', '2024-01-09'),
	('633729', 'Business', 'Sabah', 'Sabah', '2024-01-05 07:48:14', '2024-01-05 19:22:29', 'A worker died from an electric shock.', '15:46:00', 'A worker died after being subjected to an electric shock, while performing tasks to lift and move pipes using a truck-mounted crane that came into close proximity with overhead electrical lines.', 'incident-image/incident_633729_', '1. There is no safe work procedure for pipe lifting using a crane.\r\n2. There is no supervision during pipe lifting and transfer work.', '2023-07-01'),
	('826013', 'Utilities: Electricity', 'Kelantan', 'Electricity Building', '2024-01-02 10:05:40', '2024-01-02 10:05:40', 'A worker was injured after being stung by a swarm of bees.', '14:59:00', 'A worker was injured after being attacked and stung by a swarm of bees while performing electrical wire redirection tasks.', 'incident-image/incident_826013_', 'To improve safety procedures involving the risk of bee attacks (biological hazard).', '2023-09-11'),
	('902769', 'Manufacturing', 'PP', 'Pulau Pinang.', '2024-01-05 07:43:04', '2024-01-05 07:43:04', 'Worker dies after being hit by a forklift.', '12:34:00', 'A worker died after being hit by a forklift while the victim was on the way to work', 'incident-image/incident_902769_', '1. There is no separation between the workers pathway and the forklift lane.\r\n2. The narrow pathway in the accident area is used by everyone without proper traffic control.', '2023-08-15');

-- Dumping structure for table isms3.injured_people
CREATE TABLE IF NOT EXISTS `injured_people` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `incident_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `injured_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `injured_ic` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `injured_nationality` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `injured_company` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `injured_trades` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_lost_days` int DEFAULT NULL,
  `incident_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `injured_people_incident_id_foreign` (`incident_id`),
  KEY `injured_people_user_id_foreign` (`user_id`),
  CONSTRAINT `injured_people_incident_id_foreign` FOREIGN KEY (`incident_id`) REFERENCES `incidents` (`reportNo`),
  CONSTRAINT `injured_people_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=176 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table isms3.injured_people: ~6 rows (approximately)
INSERT INTO `injured_people` (`id`, `incident_id`, `injured_name`, `injured_ic`, `injured_nationality`, `injured_company`, `injured_trades`, `total_lost_days`, `incident_type`, `created_at`, `updated_at`, `user_id`) VALUES
	(144, '826013', 'Aiman Kecek Kelate', '001112-09-5329', 'Malaysia', 'TNB', 'Electrician', 30, 'Lost Time Incident', '2024-01-02 10:05:40', '2024-01-02 10:05:40', 2),
	(158, '902769', 'Azfar', '631211-08-6321', 'Pakistan', 'Disclosed', 'Worker', 6000, 'Fatality', '2024-01-05 07:43:04', '2024-01-05 07:43:04', 2),
	(170, '161057', 'Ahmad', '981129-90832', 'Indon', 'UTHM', 'Uni', 22, 'Death', '2024-01-05 12:09:34', '2024-01-05 12:09:34', 2),
	(171, '161057', 'Azfar', '1231231231', 'Malaysia', 'UTHM', 'Uni', 1, 'Near Miss', '2024-01-05 12:09:34', '2024-01-05 12:09:34', 2),
	(172, '633729', 'Matpet', '112233-00-1133', 'Bangladesh', 'Disclosed', 'Electrician', 6000, 'Fatality', '2024-01-05 19:22:29', '2024-01-05 19:22:29', 2),
	(175, '537020', 'asdad', 'asdasd', 'asda', 'asdasd', 'adas', 2, 'Lost Time', '2024-01-06 20:07:08', '2024-01-06 20:07:08', 2);

-- Dumping structure for table isms3.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table isms3.migrations: ~8 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(31, '2014_10_12_000000_create_users_table', 1),
	(32, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(33, '2019_08_19_000000_create_failed_jobs_table', 1),
	(34, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(35, '2023_11_25_082808_create_table_table', 1),
	(36, '2023_11_29_151706_add_first_time_status_column_to_users_table', 1),
	(37, '2023_12_29_164911_create_witness_details_table', 2),
	(38, '2023_12_29_164838_create_injured_people_table', 3),
	(39, '2023_12_30_043939_add_new_column_to_incidents_table', 4),
	(40, '2023_12_30_065128_modify_incident_image_column_on_incidents_table', 5),
	(41, '2023_12_30_090247_modify_incident_image_column_on_injured_people_table', 6),
	(43, '2024_03_30_133454_create_titlepage_tbl', 7),
	(44, '2024_03_30_143238_create_hirarc_tbl', 8),
	(45, '2024_03_30_150645_create_hazard_identify_tbl', 9),
	(46, '2024_03_30_151702_create_risk_assesment_tbl', 10),
	(47, '2024_03_30_153103_create_control_tbl', 11);

-- Dumping structure for table isms3.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table isms3.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table isms3.personal_access_tokens
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

-- Dumping data for table isms3.personal_access_tokens: ~0 rows (approximately)

-- Dumping structure for table isms3.table
CREATE TABLE IF NOT EXISTS `table` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table isms3.table: ~0 rows (approximately)

-- Dumping structure for table isms3.titlepage_tbl
CREATE TABLE IF NOT EXISTS `titlepage_tbl` (
  `tpage_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `insp_date` date NOT NULL,
  `verified_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ver_signature_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `approval_date` date NOT NULL,
  `approved_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `appr_signature_img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`tpage_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table isms3.titlepage_tbl: ~0 rows (approximately)

-- Dumping structure for table isms3.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `worker_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `first_time_status` int NOT NULL DEFAULT '1',
  `accessToken` int NOT NULL DEFAULT '1',
  `profile_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_worker_id_unique` (`worker_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table isms3.users: ~3 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `worker_id`, `email_verified_at`, `password`, `phone_no`, `role`, `remember_token`, `created_at`, `updated_at`, `first_time_status`, `accessToken`, `profile_photo`) VALUES
	(1, 'Anastazry', 'anastazry@gmail.com', 'ci200044', NULL, '$2y$12$yA50nrURTtS06TuXqQY2fOQ/0mtKBOnzKwS.CWtNoCZQktoOgnCVS', '0193890127', 'Admin', NULL, '2023-12-29 11:27:14', '2024-03-13 18:59:12', 0, 1, 'profile-1.jpg'),
	(2, 'AnasSV', 'anastazrypeace@gmail.com', 'ci200033', NULL, '$2y$12$b5MDj1Q2zSraSNf0LwdkAO7fBVnbqpg7gzG9Peuw2FQ1lfse2EV/a', '0193890123', 'Supervisor', NULL, '2023-12-29 11:28:22', '2024-01-06 18:26:13', 0, 1, 'profile-2.jpg'),
	(3, 'AnasPM', 'ci200044@student.uthm.edu.my', 'ci200011', NULL, '$2y$12$3pS3nfU9MW3eD4fcUnUI0OGrLCFHb2rVsrT1quSSjBgBgU4qIGtZy', '0193890120', 'Project Manager', NULL, '2023-12-31 00:16:17', '2024-01-05 11:59:18', 0, 1, 'profile-3.jpg'),
	(4, 'Anastazry Faidzli', 'anazizhere@gmail.com', 'ci200066', NULL, '$2y$12$Wa165i8cnmv3.HrRuJUM4uNERrYuxTNQCIYywH3bLWZmvR1tYIgs2', '0193890128', 'Supervisor', NULL, '2024-01-02 18:04:56', '2024-01-06 19:52:29', 1, 0, 'profile-4.jpg'),
	(5, 'AnasSHO', 'camammaster@gmail.com', 'ci200022', NULL, '$2y$12$cnfPZLGDe80IA18XabwCbefg1ThWweUkUAUjGMqzAi8AeZVURqCCm', '0193890131', 'SHO', NULL, '2024-01-05 08:49:21', '2024-01-05 08:49:55', 0, 1, NULL),
	(6, 'Anas', 'notoriousanazz@gmail.com', 'ci200088', NULL, '$2y$12$vL4tE94Wlz1RKrK93WlxluEzc8cdul8gPTGN2HnUfa2hdfMPJF8lC', '0193890124', 'Project Manager', NULL, '2024-01-06 19:54:08', '2024-01-06 19:54:08', 1, 1, NULL);

-- Dumping structure for table isms3.witness_details
CREATE TABLE IF NOT EXISTS `witness_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `incident_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `witness_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `witness_company` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `witness_details_user_id_foreign` (`user_id`),
  KEY `witness_details_incident_id_foreign` (`incident_id`),
  CONSTRAINT `witness_details_incident_id_foreign` FOREIGN KEY (`incident_id`) REFERENCES `incidents` (`reportNo`),
  CONSTRAINT `witness_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table isms3.witness_details: ~6 rows (approximately)
INSERT INTO `witness_details` (`id`, `user_id`, `incident_id`, `witness_name`, `witness_company`, `remarks`, `created_at`, `updated_at`) VALUES
	(111, 2, '826013', 'Ahmad', 'TNB', 'Victim was unlucky.', '2024-01-02 10:05:40', '2024-01-02 10:05:40'),
	(115, 2, '902769', 'Anas', 'Disclosed', 'He just walked and died.', '2024-01-05 07:43:04', '2024-01-05 07:43:04'),
	(126, 2, '161057', 'Aza', 'UTHM', 'Teruk dia kena hempap', '2024-01-05 12:09:34', '2024-01-05 12:09:34'),
	(127, 2, '161057', 'Anas', 'UTHM', 'Terkejut saya tengok bero', '2024-01-05 12:09:34', '2024-01-05 12:09:34'),
	(128, 2, '633729', 'Anas', 'UTHM', 'Victim died immediately', '2024-01-05 19:22:29', '2024-01-05 19:22:29'),
	(130, 2, '537020', 'asdas', 'asdasd', 'sss', '2024-01-06 20:07:08', '2024-01-06 20:07:08');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
migrations