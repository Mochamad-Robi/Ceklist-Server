-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 26, 2025 at 09:51 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `server_checklist_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_11_28_070928_create_server_checklists_table', 2),
(6, '2025_11_28_081150_add_role_to_users_table', 3),
(7, '2025_11_30_024323_add_profile_photo_to_users_table', 4),
(8, '2025_12_01_031657_modify_role_enum_in_users_table', 5),
(9, '2025_12_01_033343_add_user_id_to_server_checklists_table', 6),
(10, '2025_12_01_054911_create_picas_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `picas`
--

CREATE TABLE `picas` (
  `id` bigint UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `masalah` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `screen` text COLLATE utf8mb4_unicode_ci,
  `akar_penyebab` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tindakan_perbaikan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `screen_2` text COLLATE utf8mb4_unicode_ci,
  `waktu_penyelesaian` date NOT NULL,
  `pencegahan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Open',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `picas`
--

INSERT INTO `picas` (`id`, `tanggal`, `masalah`, `screen`, `akar_penyebab`, `tindakan_perbaikan`, `screen_2`, `waktu_penyelesaian`, `pencegahan`, `pic`, `status`, `created_at`, `updated_at`) VALUES
(1, '2025-12-01', 'CCTV ga aktif', 'pica-screens/peKLu5DSuiu1wFRaf6AoNYvpF7yLLO1wx97i8sGD.jpg', 'kabel dimakan tikus', 'penyambungan kabel', 'pica-screens/9CfYUJpCMsbT7bgRFIpeXwQnwuBlepomS6i7a931.jpg', '2025-12-01', 'di lilit kabel baru', 'Robi', 'Close', '2025-11-30 23:11:46', '2025-11-30 23:11:46');

-- --------------------------------------------------------

--
-- Table structure for table `server_checklists`
--

CREATE TABLE `server_checklists` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `inspection_date` date NOT NULL,
  `inspector_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `checklist_data` json NOT NULL,
  `total_items` int NOT NULL DEFAULT '0',
  `checked_items` int NOT NULL DEFAULT '0',
  `ok_items` int NOT NULL DEFAULT '0',
  `not_ok_items` int NOT NULL DEFAULT '0',
  `attention_items` int NOT NULL DEFAULT '0',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `server_checklists`
--

INSERT INTO `server_checklists` (`id`, `user_id`, `inspection_date`, `inspector_name`, `checklist_data`, `total_items`, `checked_items`, `ok_items`, `not_ok_items`, `attention_items`, `status`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, '2025-11-28', 'Robi', '[{\"items\": [{\"item\": \"Kebersihan ruangan\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Tidak ada debu berlebih\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Tidak ada kebocoran air\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Pencahayaan memadai\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Pintu dan kunci berfungsi\", \"note\": \"\", \"status\": \"ok\"}], \"category\": \"Lingkungan Fisik\"}, {\"items\": [{\"item\": \"AC berfungsi normal\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Suhu ruangan 18-24°C\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Kelembaban 40-60%\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Tidak ada bunyi aneh pada AC\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Filter AC bersih\", \"note\": \"\", \"status\": \"ok\"}], \"category\": \"Sistem Pendingin\"}, {\"items\": [{\"item\": \"Voltase stabil\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"UPS berfungsi normal\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Baterai UPS > 80%\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Genset siap operasi\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Tidak ada kabel terkelupas\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Grounding berfungsi\", \"note\": \"\", \"status\": \"ok\"}], \"category\": \"Kelistrikan\"}, {\"items\": [{\"item\": \"CCTV berfungsi\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Access control aktif\", \"note\": \"\", \"status\": \"not-ok\"}, {\"item\": \"APAR dalam kondisi baik\", \"note\": \"\", \"status\": \"not-ok\"}, {\"item\": \"Sistem alarm berfungsi\", \"note\": \"\", \"status\": \"attention\"}, {\"item\": \"Sensor asap aktif\", \"note\": \"\", \"status\": \"ok\"}], \"category\": \"Keamanan\"}, {\"items\": [{\"item\": \"Semua server menyala\", \"note\": \"\", \"status\": \"not-ok\"}, {\"item\": \"LED indikator normal\", \"note\": \"\", \"status\": \"attention\"}, {\"item\": \"Tidak ada bunyi aneh\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Kabel teratur (cable management)\", \"note\": \"\", \"status\": \"not-ok\"}, {\"item\": \"Label perangkat jelas\", \"note\": \"\", \"status\": \"ok\"}], \"category\": \"Perangkat Server\"}, {\"items\": [{\"item\": \"Switch/router berfungsi\", \"note\": \"\", \"status\": \"not-ok\"}, {\"item\": \"Koneksi internet stabil\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Patch cable dalam kondisi baik\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Tidak ada port error\", \"note\": \"\", \"status\": \"ok\"}], \"category\": \"Jaringan\"}]', 30, 30, 23, 5, 2, 'completed', NULL, '2025-11-28 00:27:08', '2025-11-28 00:27:08', NULL),
(3, NULL, '2025-11-28', 'Irwan', '[{\"items\": [{\"item\": \"Kebersihan ruangan\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Tidak ada debu berlebih\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Tidak ada kebocoran air\", \"note\": \"\", \"status\": \"not-ok\"}, {\"item\": \"Pencahayaan memadai\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Pintu dan kunci berfungsi\", \"note\": \"\", \"status\": \"ok\"}], \"category\": \"Lingkungan Fisik\"}, {\"items\": [{\"item\": \"AC berfungsi normal\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Suhu ruangan 18-24°C\", \"note\": \"\", \"status\": \"not-ok\"}, {\"item\": \"Kelembaban 40-60%\", \"note\": \"\", \"status\": \"not-ok\"}, {\"item\": \"Tidak ada bunyi aneh pada AC\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Filter AC bersih\", \"note\": \"\", \"status\": \"ok\"}], \"category\": \"Sistem Pendingin\"}, {\"items\": [{\"item\": \"Voltase stabil\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"UPS berfungsi normal\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Baterai UPS > 80%\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Genset siap operasi\", \"note\": \"genset mati\", \"status\": \"not-ok\"}, {\"item\": \"Tidak ada kabel terkelupas\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Grounding berfungsi\", \"note\": \"\", \"status\": \"ok\"}], \"category\": \"Kelistrikan\"}, {\"items\": [{\"item\": \"CCTV berfungsi\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Access control aktif\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"APAR dalam kondisi baik\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Sistem alarm berfungsi\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Sensor asap aktif\", \"note\": \"\", \"status\": \"ok\"}], \"category\": \"Keamanan\"}, {\"items\": [{\"item\": \"Semua server menyala\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"LED indikator normal\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Tidak ada bunyi aneh\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Kabel teratur (cable management)\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Label perangkat jelas\", \"note\": \"\", \"status\": \"ok\"}], \"category\": \"Perangkat Server\"}, {\"items\": [{\"item\": \"Switch/router berfungsi\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Koneksi internet stabil\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Patch cable dalam kondisi baik\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Tidak ada port error\", \"note\": \"\", \"status\": \"ok\"}], \"category\": \"Jaringan\"}]', 30, 30, 26, 4, 0, 'draft', 'amann', '2025-11-28 02:38:05', '2025-11-28 02:38:05', NULL),
(4, NULL, '2025-11-29', 'Roni', '[{\"items\": [{\"item\": \"Kebersihan ruangan\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Tidak ada debu berlebih\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Tidak ada kebocoran air\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Pencahayaan memadai\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Pintu dan kunci berfungsi\", \"note\": \"\", \"status\": \"ok\"}], \"category\": \"Lingkungan Fisik\"}, {\"items\": [{\"item\": \"AC berfungsi normal\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Suhu ruangan 18-24°C\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Kelembaban 40-60%\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Tidak ada bunyi aneh pada AC\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Filter AC bersih\", \"note\": \"\", \"status\": \"ok\"}], \"category\": \"Sistem Pendingin\"}, {\"items\": [{\"item\": \"Voltase stabil\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"UPS berfungsi normal\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Baterai UPS > 80%\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Genset siap operasi\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Tidak ada kabel terkelupas\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Grounding berfungsi\", \"note\": \"\", \"status\": \"ok\"}], \"category\": \"Kelistrikan\"}, {\"items\": [{\"item\": \"CCTV berfungsi\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Access control aktif\", \"note\": \"\", \"status\": \"not-ok\"}, {\"item\": \"APAR dalam kondisi baik\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Sistem alarm berfungsi\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Sensor asap aktif\", \"note\": \"\", \"status\": \"ok\"}], \"category\": \"Keamanan\"}, {\"items\": [{\"item\": \"Semua server menyala\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"LED indikator normal\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Tidak ada bunyi aneh\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Kabel teratur (cable management)\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Label perangkat jelas\", \"note\": \"\", \"status\": \"ok\"}], \"category\": \"Perangkat Server\"}, {\"items\": [{\"item\": \"Switch/router berfungsi\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Koneksi internet stabil\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Patch cable dalam kondisi baik\", \"note\": \"\", \"status\": \"not-ok\"}, {\"item\": \"Tidak ada port error\", \"note\": \"\", \"status\": \"ok\"}], \"category\": \"Jaringan\"}]', 30, 30, 28, 2, 0, 'completed', 'baguss cuman ada beberapa yg ga not ok', '2025-11-28 21:45:23', '2025-11-28 21:45:23', NULL),
(5, NULL, '2025-12-02', 'Dwi', '[{\"items\": [{\"item\": \"Kebersihan ruangan\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Tidak ada debu berlebih\", \"note\": \"\", \"status\": \"not-ok\"}, {\"item\": \"Tidak ada kebocoran air\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Pencahayaan memadai\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Pintu dan kunci berfungsi\", \"note\": \"Lobok Lobang Pintu\", \"status\": \"attention\"}], \"category\": \"Lingkungan Fisik\"}, {\"items\": [{\"item\": \"AC berfungsi normal\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Suhu ruangan 20-24°C\", \"note\": \"20\", \"status\": \"ok\"}, {\"item\": \"Kelembaban 40-60%\", \"note\": \"40\", \"status\": \"ok\"}, {\"item\": \"Tidak ada bunyi aneh pada AC\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Filter AC bersih\", \"note\": \"\", \"status\": \"ok\"}], \"category\": \"Sistem Pendingin\"}, {\"items\": [{\"item\": \"Voltase stabil\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"UPS berfungsi normal\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Baterai UPS > 80%\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Genset siap operasi\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Tidak ada kabel terkelupas\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Grounding berfungsi\", \"note\": \"\", \"status\": \"ok\"}], \"category\": \"Kelistrikan\"}, {\"items\": [{\"item\": \"CCTV berfungsi\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Access control aktif\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"APAR dalam kondisi baik\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Sistem alarm berfungsi\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Sensor asap aktif\", \"note\": \"\", \"status\": \"ok\"}], \"category\": \"Keamanan\"}, {\"items\": [{\"item\": \"Semua server menyala\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"LED indikator normal\", \"note\": \"\", \"status\": \"not-ok\"}, {\"item\": \"Tidak ada bunyi aneh\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Kabel teratur (cable management)\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Label perangkat jelas\", \"note\": \"\", \"status\": \"ok\"}], \"category\": \"Perangkat Server\"}, {\"items\": [{\"item\": \"Switch/router berfungsi\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Koneksi internet stabil\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Patch cable dalam kondisi baik\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Tidak ada port error\", \"note\": \"\", \"status\": \"ok\"}], \"category\": \"Jaringan\"}]', 30, 30, 27, 2, 1, 'completed', 'Kaca Retak', '2025-12-02 00:08:38', '2025-12-02 00:08:38', NULL),
(6, NULL, '2025-12-09', 'Robi', '[{\"items\": [{\"item\": \"Memastikan perangkat di rak dalam kondisi baik\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Memastikan tidak ada benda asing di dalam rak server\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Memastikan pintu rak server terkunci\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Memastikan ruangan steril dari barang yang tidak ada hubungannya dengan perangkat\", \"note\": \"\", \"status\": \"ok\"}], \"category\": \"Perangkat dan Rak\"}, {\"items\": [{\"item\": \"Memastikan tidak ada kebocoran ke dalam ruangan\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"CCTV aktif & merekam\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Ruang server bersih & bebas debu\", \"note\": \"\", \"status\": \"ok\"}], \"category\": \"Keamanan Ruangan\"}, {\"items\": [{\"item\": \"Memastikan UPS nyala\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"UPS normal (no alarm)\", \"note\": \"\", \"status\": \"ok\"}], \"category\": \"Kelistrikan\"}, {\"items\": [{\"item\": \"Suhu ruangan 22°C\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Pastikan ruangan server terkunci\", \"note\": \"\", \"status\": \"ok\"}], \"category\": \"Sistem Pendingin\"}, {\"items\": [{\"item\": \"Indikator server normal\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Switch/router/firewall normal\", \"note\": \"\", \"status\": \"ok\"}], \"category\": \"Status Server dan Perangkat\"}, {\"items\": [{\"item\": \"Memastikan Synolog + Qnap Berjalan dengan baik\", \"note\": \"\", \"status\": \"ok\"}], \"category\": \"Sistem dan Aplikasi\"}, {\"items\": [{\"item\": \"Cek Kondisi Jaringan Indihome\", \"note\": \"\", \"status\": \"ok\"}, {\"item\": \"Cek Kondisi Jaringan Cyber-K\", \"note\": \"\", \"status\": \"ok\"}], \"category\": \"Koneksi Internet\"}]', 16, 16, 16, 0, 0, 'completed', NULL, '2025-12-08 19:48:07', '2025-12-08 19:48:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('super_admin','admin','inspector','viewer') COLLATE utf8mb4_unicode_ci DEFAULT 'inspector',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `profile_photo`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Mochamad Robi', 'admin@server.com', 'profile-photos/r3qv8HKbO7JXQL62mbOnprptbXtxE3E1wzwG8UG8.jpg', 'admin', NULL, '$2y$10$1Oe800Rsjp/9.G2Uzoi0ieYh5j1NVNqxJSCv4/3Zn2dXKW/69SbEO', NULL, '2025-11-28 00:36:12', '2025-11-29 20:51:22'),
(2, 'Inspector 1', 'inspector@server.com', NULL, 'inspector', NULL, '$2y$10$ziZaHlHcw49WkVFu7YG.WejQ8Qdy7o5DWnApn..f/cS/c9i.RTtd6', NULL, '2025-11-28 01:17:29', '2025-11-28 01:17:29'),
(3, 'Irwan', 'irwan@kemakmuran.com', NULL, 'inspector', NULL, '$2y$10$pds0Nk/OT7BMQG6qK8HCpelxD8KDrsL8PeI6ikBtW7XXTzcblW1Ni', NULL, '2025-11-30 20:04:10', '2025-11-30 20:04:10'),
(4, 'Super Admin', 'superadmin@checklist.com', NULL, 'super_admin', NULL, '$2y$10$7l68AoaNVxGVMD/gAHeWyet32vOvzwdzhwdpS9jkmLCXqcQ/NAucu', NULL, '2025-11-30 20:18:04', '2025-11-30 21:07:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `picas`
--
ALTER TABLE `picas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `server_checklists`
--
ALTER TABLE `server_checklists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `server_checklists_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `picas`
--
ALTER TABLE `picas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `server_checklists`
--
ALTER TABLE `server_checklists`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `server_checklists`
--
ALTER TABLE `server_checklists`
  ADD CONSTRAINT `server_checklists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
