-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 25, 2025 at 10:51 AM
-- Server version: 5.7.36
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel_hris_magang`
--

-- --------------------------------------------------------

--
-- Table structure for table `assessments`
--

DROP TABLE IF EXISTS `assessments`;
CREATE TABLE IF NOT EXISTS `assessments` (
  `assessment_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `intern_id` bigint(20) UNSIGNED NOT NULL,
  `mentor_id` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(4) NOT NULL,
  `feedback` text COLLATE utf8mb4_unicode_ci,
  `assessment_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`assessment_id`),
  KEY `intern_id` (`intern_id`),
  KEY `mentor_id` (`mentor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assessments`
--

INSERT INTO `assessments` (`assessment_id`, `intern_id`, `mentor_id`, `rating`, `feedback`, `assessment_date`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 5, 'Sangat baik', '2025-07-23', '2025-07-23 11:21:22', '2025-07-23 11:21:22');

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

DROP TABLE IF EXISTS `attendances`;
CREATE TABLE IF NOT EXISTS `attendances` (
  `attendance_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `intern_id` bigint(20) UNSIGNED NOT NULL,
  `check_in_time` datetime NOT NULL,
  `check_out_time` datetime DEFAULT NULL,
  `attendance_date` date NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`attendance_id`),
  KEY `intern_id` (`intern_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`attendance_id`, `intern_id`, `check_in_time`, `check_out_time`, `attendance_date`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-06-19 14:44:05', '2025-06-19 14:46:23', '2025-06-19', 'Check-out otomatis', '2025-06-19 07:44:05', '2025-06-19 07:46:23'),
(2, 1, '2025-06-20 00:13:57', '2025-06-20 03:54:00', '2025-06-20', 'Check-out otomatis', '2025-06-19 17:13:57', '2025-06-19 20:54:00'),
(3, 2, '2025-06-20 00:14:31', '2025-06-20 03:54:09', '2025-06-20', 'Check-out otomatis', '2025-06-19 17:14:31', '2025-06-19 20:54:09'),
(4, 1, '2025-07-25 10:15:40', '2025-07-25 10:15:42', '2025-07-25', 'Check-out otomatis', '2025-07-25 03:15:40', '2025-07-25 03:15:42');

-- --------------------------------------------------------

--
-- Table structure for table `calendar`
--

DROP TABLE IF EXISTS `calendar`;
CREATE TABLE IF NOT EXISTS `calendar` (
  `event_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `calendar`
--

INSERT INTO `calendar` (`event_id`, `title`, `description`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
(2, 'gajiann', NULL, '2025-07-31', '2025-07-31', '2025-07-23 10:53:08', '2025-07-23 10:53:08');

-- --------------------------------------------------------

--
-- Table structure for table `interns`
--

DROP TABLE IF EXISTS `interns`;
CREATE TABLE IF NOT EXISTS `interns` (
  `intern_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `batch` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mentor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `joining_date` date NOT NULL,
  `termination_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `profile_picture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`intern_id`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `mentor_id` (`mentor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `interns`
--

INSERT INTO `interns` (`intern_id`, `user_id`, `full_name`, `email`, `phone_number`, `batch`, `mentor_id`, `joining_date`, `termination_date`, `created_at`, `updated_at`, `profile_picture`) VALUES
(1, 2, 'Aigal Kurniawan', 'aigalkurniawan@mail.com', '081234567890', '2024/2025', 1, '2024-02-01', '2029-12-31', '2025-06-19 14:42:02', '2025-07-25 03:16:19', '1750399263.jpg'),
(2, 4, 'Kurniawan', 'kurniawankurniawan@mail.com', '089521489283', '2024/2025', 1, '2024-02-29', '2029-12-31', '2025-06-19 14:51:38', '2025-06-19 22:59:53', '1750399193.jpg'),
(3, 5, 'akmal', '5giana@edny.net', '083648192834', '2029/2030', 1, '2025-06-01', '2029-12-31', '2025-06-19 21:55:07', '2025-07-23 12:35:30', '');

-- --------------------------------------------------------

--
-- Table structure for table `mentors`
--

DROP TABLE IF EXISTS `mentors`;
CREATE TABLE IF NOT EXISTS `mentors` (
  `mentor_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`mentor_id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mentors`
--

INSERT INTO `mentors` (`mentor_id`, `user_id`, `full_name`, `email`, `phone_number`, `department`, `created_at`, `updated_at`) VALUES
(1, 3, 'Pak mentor', 'iniemailpakmentor@mail.com', '081234543253', 'SDM', '2025-06-20 03:52:35', '2025-06-20 03:52:35');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payroll`
--

DROP TABLE IF EXISTS `payroll`;
CREATE TABLE IF NOT EXISTS `payroll` (
  `payroll_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `intern_id` bigint(20) UNSIGNED NOT NULL,
  `payment_date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`payroll_id`),
  KEY `intern_id` (`intern_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payroll`
--

INSERT INTO `payroll` (`payroll_id`, `intern_id`, `payment_date`, `amount`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-07-01', '720000.00', 'Gajian juli', '2025-06-19 21:12:26', '2025-06-19 21:13:32'),
(3, 3, '2025-07-01', '350000.00', NULL, '2025-06-19 21:56:53', '2025-06-19 21:56:53'),
(4, 3, '2025-07-02', '700000.00', NULL, '2025-06-19 21:58:03', '2025-06-19 21:58:03');

-- --------------------------------------------------------

--
-- Table structure for table `program_info`
--

DROP TABLE IF EXISTS `program_info`;
CREATE TABLE IF NOT EXISTS `program_info` (
  `info_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`info_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `program_info`
--

INSERT INTO `program_info` (`info_id`, `title`, `content`, `created_at`, `updated_at`) VALUES
(1, 'Libur Lebaran', 'tgl 21 - 29 libur departemen IT', '2025-07-23 10:31:38', '2025-07-24 07:12:21'),
(2, 'Meeting diluar', 'tgl 28 meeting di solaria', '2025-07-23 10:33:12', '2025-07-23 10:33:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','intern','mentor') COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$12$ipwsGEm14TEwOpblxKSUnOLI5efiprdQTvoHuknrCd3O7cHJyqSje', 'admin', NULL, '2025-06-19 12:06:38', '2025-06-19 12:27:02'),
(2, 'intern1', '$2y$12$i2rmHGKFjtaVxzpfx3JS9uj7j2KblpnraWBhcG23LmJnDrd3i/iUu', 'intern', NULL, '2025-06-19 12:06:38', '2025-07-24 07:10:17'),
(3, 'mentor1', '$2y$12$ipwsGEm14TEwOpblxKSUnOLI5efiprdQTvoHuknrCd3O7cHJyqSje', 'mentor', NULL, '2025-06-19 12:06:38', '2025-06-19 12:27:10'),
(4, 'intern2', '$2y$12$L24qjFMk8koafJDSnO7WnehoXWS3M9LncJEasSAMsOWq.ePxjvfGG', 'intern', NULL, '2025-06-19 14:50:14', '2025-07-24 07:11:48'),
(5, 'akmalintern', '$2y$12$s4C2.y1VtRHZAXmt8SRBn.p91wM5No8iopgKgV0DSOxYLWf3RtEEO', 'intern', NULL, '2025-06-19 21:55:07', '2025-06-19 21:55:07'),
(6, 'riedoeintern', '$2y$12$WPnpZ1kz9EfvmwWtLMlVbudxU8rCwIFiLY/kn5eCeFXiX/w9LhJ8O', 'intern', NULL, '2025-06-19 22:14:37', '2025-06-19 22:14:37'),
(7, 'riedoeintern11', '$2y$12$f1IoM40NoM9FJYbnE72S4u8t80jgT9ar52AeJlS5sVpGbiGSDRCU.', 'intern', NULL, '2025-06-19 22:15:50', '2025-06-19 22:15:50'),
(8, 'riedoeintern1', '$2y$12$i5HU4RfrcViI.pKF9Oa8/OMNZT/6X0Whb/SVNZeOhHGDUH8/2FLUi', 'intern', NULL, '2025-06-19 22:16:23', '2025-06-19 22:16:23'),
(9, 'ririintern', '$2y$12$0FDzGv06TAk5R637.XEyTuK.Ojnda6g1BPlwe/ywTesTSZG6aL8Cy', 'intern', NULL, '2025-06-19 22:30:18', '2025-06-19 22:30:18'),
(10, 'swagintern', '$2y$12$8kgcdkwu2ZlVjAIcWGCGOOU7B1NzrcmCfnTGZewFpjQ5/GyqtA3ya', 'intern', NULL, '2025-06-19 22:40:55', '2025-06-19 22:40:55'),
(11, 'intern3', '$2y$12$xFUJN.2qEPlX4VDScPejP.4oRSv7QjOuDdmu5tWKQwAsD.v95NmaC', 'intern', NULL, '2025-07-23 12:43:27', '2025-07-23 12:43:27'),
(12, 'lutungmagang', '$2y$12$AXPfV.wfZmp5DPMQAQr.D.bd1zJQevt9vQOc1AvL.TwQ1qGakzj3m', 'intern', NULL, '2025-07-23 12:52:15', '2025-07-23 12:52:15'),
(13, 'intern123', '$2y$12$jOdFDjRoHdGvTr5igsARNukvo2vYr9efZu6/jk5bARVPvLIvwWpOq', 'intern', NULL, '2025-07-24 07:11:17', '2025-07-24 07:11:17');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assessments`
--
ALTER TABLE `assessments`
  ADD CONSTRAINT `assessments_ibfk_1` FOREIGN KEY (`intern_id`) REFERENCES `interns` (`intern_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assessments_ibfk_2` FOREIGN KEY (`mentor_id`) REFERENCES `mentors` (`mentor_id`) ON DELETE CASCADE;

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_ibfk_1` FOREIGN KEY (`intern_id`) REFERENCES `interns` (`intern_id`) ON DELETE CASCADE;

--
-- Constraints for table `interns`
--
ALTER TABLE `interns`
  ADD CONSTRAINT `interns_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `interns_ibfk_2` FOREIGN KEY (`mentor_id`) REFERENCES `mentors` (`mentor_id`) ON DELETE SET NULL;

--
-- Constraints for table `mentors`
--
ALTER TABLE `mentors`
  ADD CONSTRAINT `mentors_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `payroll`
--
ALTER TABLE `payroll`
  ADD CONSTRAINT `payroll_ibfk_1` FOREIGN KEY (`intern_id`) REFERENCES `interns` (`intern_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
