-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 21, 2022 at 08:13 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_graduation`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fci_students`
--

CREATE TABLE `fci_students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '012' COMMENT 'phone',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `age` int(11) NOT NULL DEFAULT 15,
  `gender` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `found_objects`
--

CREATE TABLE `found_objects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `helper_id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `found_date` datetime NOT NULL,
  `found_place` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attach` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `second_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jop_applies`
--

CREATE TABLE `jop_applies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lost_objects`
--

CREATE TABLE `lost_objects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `needer_id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expected_lost_date` datetime NOT NULL,
  `expected_lost_place` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attach` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `second_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(7, '2021_10_21_124121_create_fci_students_table', 1),
(116, '2014_10_12_000000_create_users_table', 2),
(117, '2014_10_12_100000_create_password_resets_table', 2),
(118, '2019_08_19_000000_create_failed_jobs_table', 2),
(119, '2019_12_14_000001_create_personal_access_tokens_table', 2),
(120, '2021_10_11_195354_create_lost_objects_table', 2),
(121, '2021_10_11_195423_create_found_objects_table', 2),
(122, '2021_12_13_182201_create_request_jops_table', 2),
(123, '2021_12_13_182240_create_provide_jops_table', 2),
(124, '2021_12_13_195359_create_jop_applies_table', 2),
(125, '2022_02_19_185029_create_things_to_be_dones_table', 2),
(126, '2022_02_19_194959_create_support_things_to_be_dones_table', 2),
(127, '2022_02_19_202422_create_to_be_applies_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `provide_jops`
--

CREATE TABLE `provide_jops` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `required_qualification` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `required_skills` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `required_certificates` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attach` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `request_jops`
--

CREATE TABLE `request_jops` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `qualification` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `skills` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `certificates` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `summary_about_you` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attach` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_things_to_be_dones`
--

CREATE TABLE `support_things_to_be_dones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `from_place` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `to_place` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `support_things_to_be_dones`
--

INSERT INTO `support_things_to_be_dones` (`id`, `user_id`, `from_place`, `to_place`, `date`, `note`, `created_at`, `updated_at`) VALUES
(1, 1, 'طنطا', 'القاهرة', '2022-04-15', 'none', '2022-02-19 19:34:24', '2022-02-19 19:34:24'),
(2, 1, 'طنطا', 'القاهرة', '2022-04-15', 'none', '2022-02-19 19:34:32', '2022-02-19 19:34:32'),
(3, 1, 'طنطا', 'القاهرة', '2022-04-15', 'none', '2022-02-19 19:34:33', '2022-02-19 19:34:33');

-- --------------------------------------------------------

--
-- Table structure for table `things_to_be_dones`
--

CREATE TABLE `things_to_be_dones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `type_of_service` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_place` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `to_place` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attach` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `opposite` int(11) NOT NULL DEFAULT 0,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `things_to_be_dones`
--

INSERT INTO `things_to_be_dones` (`id`, `user_id`, `type_of_service`, `from_place`, `to_place`, `attach`, `opposite`, `from_date`, `to_date`, `note`, `created_at`, `updated_at`) VALUES
(1, 1, 'خدمات2', '2طنطا', 'القاهرة2', '', 110, '2022-12-15', '2023-12-15', 'nothing2', '2022-02-19 19:33:22', '2022-02-19 19:36:53'),
(3, 1, 'خدمات', 'طنطا', 'القاهرة', '', 115, '2022-12-12', '2023-12-12', 'nothing', '2022-02-19 19:42:04', '2022-02-19 19:42:04');

-- --------------------------------------------------------

--
-- Table structure for table `to_be_applies`
--

CREATE TABLE `to_be_applies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `type` enum('help','need') COLLATE utf8mb4_unicode_ci NOT NULL,
  `accept` enum('wait list','yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'wait list',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `to_be_applies`
--

INSERT INTO `to_be_applies` (`id`, `user_id`, `post_id`, `type`, `accept`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'need', 'wait list', '2022-02-19 19:34:58', '2022-02-19 19:34:58'),
(2, 1, 1, 'help', 'no', '2022-02-19 19:37:20', '2022-02-19 19:45:54'),
(3, 1, 1, 'help', 'wait list', '2022-02-19 19:37:28', '2022-02-19 19:37:28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `id_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `job` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0 female 1 male',
  `main_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `date_of_birth`, `id_number`, `job`, `gender`, `main_address`, `id_photo`, `photo`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'عبدالله', 'abdulla@gmail.com', NULL, '$2y$10$GHqg7UXvTdQ099XTq2LHPehfMj1cPtMK9rC1869p/OXWT.LZq9T3m', '0147852369', '2000-01-25', '3000', 'software engineer', 1, 'tanta', NULL, NULL, NULL, '2022-02-19 19:33:15', '2022-02-19 19:33:15');

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
-- Indexes for table `fci_students`
--
ALTER TABLE `fci_students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `found_objects`
--
ALTER TABLE `found_objects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jop_applies`
--
ALTER TABLE `jop_applies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lost_objects`
--
ALTER TABLE `lost_objects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `provide_jops`
--
ALTER TABLE `provide_jops`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request_jops`
--
ALTER TABLE `request_jops`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_things_to_be_dones`
--
ALTER TABLE `support_things_to_be_dones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `things_to_be_dones`
--
ALTER TABLE `things_to_be_dones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `to_be_applies`
--
ALTER TABLE `to_be_applies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`),
  ADD UNIQUE KEY `users_id_number_unique` (`id_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fci_students`
--
ALTER TABLE `fci_students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `found_objects`
--
ALTER TABLE `found_objects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jop_applies`
--
ALTER TABLE `jop_applies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lost_objects`
--
ALTER TABLE `lost_objects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `provide_jops`
--
ALTER TABLE `provide_jops`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `request_jops`
--
ALTER TABLE `request_jops`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_things_to_be_dones`
--
ALTER TABLE `support_things_to_be_dones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `things_to_be_dones`
--
ALTER TABLE `things_to_be_dones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `to_be_applies`
--
ALTER TABLE `to_be_applies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
