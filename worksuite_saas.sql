-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2021 at 02:39 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sportxsportx_saas`
--

-- --------------------------------------------------------

--
-- Table structure for table `accept_estimates`
--

CREATE TABLE `accept_estimates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `estimate_id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `signature` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `clock_in_time` datetime NOT NULL,
  `clock_out_time` datetime DEFAULT NULL,
  `clock_in_ip` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `clock_out_ip` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `working_from` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'office',
  `late` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `half_day` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance_settings`
--

CREATE TABLE `attendance_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `office_start_time` time NOT NULL,
  `office_end_time` time NOT NULL,
  `halfday_mark_time` time DEFAULT NULL,
  `late_mark_duration` tinyint(4) NOT NULL,
  `clockin_in_day` int(11) NOT NULL DEFAULT 1,
  `employee_clock_in_out` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `office_open_days` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT '[1,2,3,4,5]',
  `ip_address` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `radius` int(11) DEFAULT NULL,
  `radius_check` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `ip_check` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `alert_after` int(11) DEFAULT NULL,
  `alert_after_status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `attendance_settings`
--

INSERT INTO `attendance_settings` (`id`, `company_id`, `office_start_time`, `office_end_time`, `halfday_mark_time`, `late_mark_duration`, `clockin_in_day`, `employee_clock_in_out`, `office_open_days`, `ip_address`, `radius`, `radius_check`, `ip_check`, `alert_after`, `alert_after_status`, `created_at`, `updated_at`) VALUES
(1, NULL, '09:00:00', '18:00:00', NULL, 20, 2, 'yes', '[1,2,3,4,5]', NULL, NULL, 'no', 'no', NULL, 1, '2021-11-10 18:02:57', '2021-11-10 18:02:57'),
(2, 1, '09:00:00', '18:00:00', NULL, 20, 1, 'yes', '[1,2,3,4,5]', NULL, NULL, 'no', 'no', NULL, 1, '2021-11-10 18:30:30', '2021-11-10 18:30:30'),
(3, 2, '09:00:00', '18:00:00', NULL, 20, 1, 'yes', '[1,2,3,4,5]', NULL, NULL, 'no', 'no', NULL, 1, '2021-11-10 18:31:15', '2021-11-10 18:31:15'),
(4, 3, '09:00:00', '18:00:00', NULL, 20, 1, 'yes', '[1,2,3,4,5]', NULL, NULL, 'no', 'no', NULL, 1, '2021-11-10 18:32:04', '2021-11-10 18:32:04'),
(5, 4, '09:00:00', '18:00:00', NULL, 20, 1, 'yes', '[1,2,3,4,5]', NULL, NULL, 'no', 'no', NULL, 1, '2021-11-10 18:32:45', '2021-11-10 18:32:45'),
(6, 5, '09:00:00', '18:00:00', NULL, 20, 1, 'yes', '[1,2,3,4,5]', NULL, NULL, 'no', 'no', NULL, 1, '2021-11-10 18:33:22', '2021-11-10 18:33:22'),
(7, 6, '09:00:00', '18:00:00', NULL, 20, 1, 'yes', '[1,2,3,4,5]', NULL, NULL, 'no', 'no', NULL, 1, '2021-11-10 18:34:02', '2021-11-10 18:34:02');

-- --------------------------------------------------------

--
-- Table structure for table `authorize_invoices`
--

CREATE TABLE `authorize_invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `package_id` int(10) UNSIGNED NOT NULL,
  `transaction_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pay_date` date DEFAULT NULL,
  `next_pay_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `authorize_subscriptions`
--

CREATE TABLE `authorize_subscriptions` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `subscription_id` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `plan_id` int(10) UNSIGNED DEFAULT NULL,
  `plan_type` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `borrowings`
--

CREATE TABLE `borrowings` (
  `id` int(10) NOT NULL,
  `borrower` int(10) UNSIGNED NOT NULL,
  `resources` int(10) UNSIGNED NOT NULL,
  `borrowed` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `borrow_date` date NOT NULL,
  `due_date` date NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `approved` tinyint(4) NOT NULL,
  `approved_by` int(10) UNSIGNED NOT NULL,
  `turn_in` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `borrowings`
--

INSERT INTO `borrowings` (`id`, `borrower`, `resources`, `borrowed`, `borrow_date`, `due_date`, `created_by`, `approved`, `approved_by`, `turn_in`, `created_at`, `updated_at`) VALUES
(1, 25, 2, 1, '2021-11-17', '2021-11-18', 2, 1, 1, 0, '2021-11-18 04:51:51', '2021-11-18 04:51:51'),
(2, 4, 2, 1, '2021-11-11', '2021-11-14', 2, 1, 1, 0, '2021-11-18 06:30:14', '2021-11-18 06:30:14');

-- --------------------------------------------------------

--
-- Table structure for table `client_categories`
--

CREATE TABLE `client_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `category_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client_contacts`
--

CREATE TABLE `client_contacts` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `contact_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client_details`
--

CREATE TABLE `client_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `shipping_address` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `office_phone` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postal_code` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `linkedin` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `skype` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gst_number` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `email_notifications` tinyint(1) NOT NULL DEFAULT 1,
  `country_id` int(10) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sub_category_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `client_details`
--

INSERT INTO `client_details` (`id`, `company_id`, `user_id`, `name`, `email`, `image`, `mobile`, `company_name`, `address`, `shipping_address`, `office_phone`, `city`, `state`, `postal_code`, `website`, `note`, `linkedin`, `facebook`, `twitter`, `skype`, `gst_number`, `created_at`, `updated_at`, `email_notifications`, `country_id`, `category_id`, `sub_category_id`) VALUES
(1, 1, 4, 'Ms. Sharon Boyle DDS', 'jaskolski.mike@yahoo.com', NULL, NULL, 'Collier, Jast and Hansen', '36362 Monica Well Apt. 033\nSouth Harrisonstad, WI 24437-2418', NULL, NULL, NULL, NULL, NULL, 'murphy.com', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:30:56', '2021-11-10 18:30:56', 1, NULL, NULL, NULL),
(2, 1, 25, 'Prof. Freida Kunze DVM', 'paige15@feeney.com', NULL, NULL, 'Goyette-Wuckert', '696 Smitham Oval\nPort Lonie, NE 94723-5899', NULL, NULL, NULL, NULL, NULL, 'quigley.com', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:34:54', '2021-11-10 18:34:54', 1, NULL, NULL, NULL),
(3, 1, 26, 'Dwight Swift', 'ryan.clay@wehner.org', NULL, NULL, 'Nader Ltd', '9238 Alisa Shoal Suite 224\nEast Lizzieshire, IN 20074-5385', NULL, NULL, NULL, NULL, NULL, 'nikolaus.com', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:34:56', '2021-11-10 18:34:56', 1, NULL, NULL, NULL),
(4, 1, 27, 'Guido Greenholt', 'clay15@kessler.info', NULL, NULL, 'Romaguera-Gottlieb', '2416 Zachery Locks\nWest Daphne, ND 04217', NULL, NULL, NULL, NULL, NULL, 'luettgen.com', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:34:56', '2021-11-10 18:34:56', 1, NULL, NULL, NULL),
(5, 1, 28, 'Clementina Mosciski', 'claudia.zemlak@gmail.com', NULL, NULL, 'Pacocha, Will and Hackett', '651 Spinka Shore\nNew Gregoriaburgh, ND 57790-7948', NULL, NULL, NULL, NULL, NULL, 'crooks.info', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:34:56', '2021-11-10 18:34:56', 1, NULL, NULL, NULL),
(6, 1, 29, 'Lea Pacocha', 'adam.ebert@schoen.com', NULL, NULL, 'Lebsack-Smitham', '4476 Langworth Falls Suite 141\nLake Dolores, TX 34405', NULL, NULL, NULL, NULL, NULL, 'frami.biz', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:34:56', '2021-11-10 18:34:56', 1, NULL, NULL, NULL),
(7, 1, 30, 'Dr. Domenico Bosco DDS', 'maya88@yahoo.com', NULL, NULL, 'Boehm, Cummings and Terry', '52119 Haag Trafficway\nNorth Erling, AR 08731-4927', NULL, NULL, NULL, NULL, NULL, 'haag.biz', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:34:57', '2021-11-10 18:34:57', 1, NULL, NULL, NULL),
(8, 1, 31, 'Madisyn Lakin', 'block.lulu@gmail.com', NULL, NULL, 'Abbott-Doyle', '80870 Lebsack Green\nPort Albin, MO 62384-3619', NULL, NULL, NULL, NULL, NULL, 'ankunding.info', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:34:57', '2021-11-10 18:34:57', 1, NULL, NULL, NULL),
(9, 1, 32, 'Katlyn Bednar', 'hand.eduardo@schowalter.com', NULL, NULL, 'Morissette Inc', '297 Shany Ridge\nBotown, CT 02907', NULL, NULL, NULL, NULL, NULL, 'schmeler.com', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:34:57', '2021-11-10 18:34:57', 1, NULL, NULL, NULL),
(10, 1, 33, 'Morton Willms', 'eleazar.wiegand@hotmail.com', NULL, NULL, 'Kling and Sons', '4451 Afton Crossing\nEast Brookeport, ND 12772-0956', NULL, NULL, NULL, NULL, NULL, 'waelchi.org', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:34:57', '2021-11-10 18:34:57', 1, NULL, NULL, NULL),
(11, 1, 34, 'Santa Schmidt IV', 'wilson.zboncak@gmail.com', NULL, NULL, 'Bayer and Sons', '814 Collins Hollow Apt. 616\nNew Colinbury, WY 47097', NULL, NULL, NULL, NULL, NULL, 'ernser.com', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:34:58', '2021-11-10 18:34:58', 1, NULL, NULL, NULL),
(12, 2, 55, 'Adella Reichel', 'mante.jeramy@mayert.com', NULL, NULL, 'Murray, Walsh and Raynor', '2902 Kulas Mission Suite 936\nNew Eric, NV 40448', NULL, NULL, NULL, NULL, NULL, 'bednar.com', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:35:19', '2021-11-10 18:35:19', 1, NULL, NULL, NULL),
(13, 2, 56, 'Dr. Godfrey Kessler I', 'aliza35@yahoo.com', NULL, NULL, 'Bins, Johns and Williamson', '99527 Rodrigo Grove Apt. 968\nSouth Tristian, RI 71376-4386', NULL, NULL, NULL, NULL, NULL, 'predovic.com', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:35:19', '2021-11-10 18:35:19', 1, NULL, NULL, NULL),
(14, 2, 57, 'Hazle Schmeler', 'sebastian86@thompson.com', NULL, NULL, 'Roob-Romaguera', '405 Rodriguez Expressway Suite 780\nLuettgenberg, VT 00929', NULL, NULL, NULL, NULL, NULL, 'huels.net', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:35:19', '2021-11-10 18:35:19', 1, NULL, NULL, NULL),
(15, 2, 58, 'Makenzie Kub', 'vmertz@hotmail.com', NULL, NULL, 'O\'Conner PLC', '5075 Ebert Inlet Apt. 313\nDejuanburgh, HI 24685-3290', NULL, NULL, NULL, NULL, NULL, 'osinski.biz', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:35:20', '2021-11-10 18:35:20', 1, NULL, NULL, NULL),
(16, 2, 59, 'Nora Bartell DDS', 'carey50@gmail.com', NULL, NULL, 'Fay, Altenwerth and Wilkinson', '93924 Osinski Valleys Apt. 150\nSouth Chelsieview, AL 24827', NULL, NULL, NULL, NULL, NULL, 'brown.org', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:35:21', '2021-11-10 18:35:21', 1, NULL, NULL, NULL),
(17, 2, 60, 'Myrna Deckow', 'delphia.marvin@yahoo.com', NULL, NULL, 'Balistreri-Koelpin', '18971 Cole Grove\nEast Trudiechester, PA 29205-1221', NULL, NULL, NULL, NULL, NULL, 'yundt.biz', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:35:22', '2021-11-10 18:35:22', 1, NULL, NULL, NULL),
(18, 2, 61, 'Ladarius Kutch', 'schoen.ora@runolfsson.info', NULL, NULL, 'Fay-Bechtelar', '41986 Klocko Parkways Suite 529\nLulatown, NC 09395-1212', NULL, NULL, NULL, NULL, NULL, 'waters.com', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:35:22', '2021-11-10 18:35:22', 1, NULL, NULL, NULL),
(19, 2, 62, 'Vance Stehr', 'lee.goldner@huels.com', NULL, NULL, 'Larkin-Donnelly', '590 McKenzie Ports\nAbdielfurt, PA 02868', NULL, NULL, NULL, NULL, NULL, 'dach.org', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:35:23', '2021-11-10 18:35:23', 1, NULL, NULL, NULL),
(20, 2, 63, 'Prof. Lina Dach V', 'eichmann.dahlia@leannon.com', NULL, NULL, 'Satterfield-Bergnaum', '70974 Tanner Walk\nSouth Josiah, NH 59744-5139', NULL, NULL, NULL, NULL, NULL, 'rohan.biz', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:35:24', '2021-11-10 18:35:24', 1, NULL, NULL, NULL),
(21, 2, 64, 'Mrs. Pearlie Thompson III', 'justyn76@gmail.com', NULL, NULL, 'Daugherty and Sons', '8365 Luciano Forks Apt. 933\nMarcelinoburgh, PA 79346-4078', NULL, NULL, NULL, NULL, NULL, 'medhurst.info', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:35:24', '2021-11-10 18:35:24', 1, NULL, NULL, NULL),
(22, 3, 85, 'Kellen Littel', 'zulauf.ellsworth@gmail.com', NULL, NULL, 'Barton LLC', '1078 White Square\nNorth Oranmouth, OH 63007', NULL, NULL, NULL, NULL, NULL, 'koepp.com', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:35:43', '2021-11-10 18:35:43', 1, NULL, NULL, NULL),
(23, 3, 86, 'Dr. Alyce Pacocha', 'esimonis@gleichner.net', NULL, NULL, 'Conroy PLC', '1157 Phoebe Freeway\nBridieton, FL 80036', NULL, NULL, NULL, NULL, NULL, 'kihn.com', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:35:43', '2021-11-10 18:35:43', 1, NULL, NULL, NULL),
(24, 3, 87, 'Janelle Gaylord', 'qprohaska@strosin.biz', NULL, NULL, 'Ferry LLC', '8284 Schultz Ville\nPort Franciscotown, ME 92699-0525', NULL, NULL, NULL, NULL, NULL, 'oconnell.org', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:35:43', '2021-11-10 18:35:43', 1, NULL, NULL, NULL),
(25, 3, 88, 'Orlo Wintheiser', 'eleazar50@thompson.com', NULL, NULL, 'Friesen Ltd', '152 Hollie Lane\nNorth Jakayla, OH 13492', NULL, NULL, NULL, NULL, NULL, 'yundt.com', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:35:45', '2021-11-10 18:35:45', 1, NULL, NULL, NULL),
(26, 3, 89, 'Jaylin Boyer DDS', 'hdurgan@yahoo.com', NULL, NULL, 'Wuckert, Herzog and Jacobson', '650 Schoen Coves\nAdanchester, IL 61184', NULL, NULL, NULL, NULL, NULL, 'keebler.com', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:35:46', '2021-11-10 18:35:46', 1, NULL, NULL, NULL),
(27, 3, 90, 'Mr. Leonard Welch', 'ecollins@rau.org', NULL, NULL, 'Bergnaum, Satterfield and Mayert', '9622 Langosh Expressway\nReneebury, MN 54293', NULL, NULL, NULL, NULL, NULL, 'bruen.com', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:35:47', '2021-11-10 18:35:47', 1, NULL, NULL, NULL),
(28, 3, 91, 'Waylon Medhurst', 'kkris@schneider.com', NULL, NULL, 'Towne LLC', '34154 Price Fords\nNew Horace, WA 26000', NULL, NULL, NULL, NULL, NULL, 'heathcote.com', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:35:47', '2021-11-10 18:35:47', 1, NULL, NULL, NULL),
(29, 3, 92, 'Noemi Senger', 'hellen.ortiz@yahoo.com', NULL, NULL, 'Luettgen-Goyette', '205 Carole Lane\nDeckowbury, TX 14233-8233', NULL, NULL, NULL, NULL, NULL, 'tromp.net', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:35:47', '2021-11-10 18:35:47', 1, NULL, NULL, NULL),
(30, 3, 93, 'Florian Huels DVM', 'eleanore.skiles@kihn.com', NULL, NULL, 'Toy Ltd', '515 Rosemarie Cove Apt. 159\nPorterchester, VT 91385-3179', NULL, NULL, NULL, NULL, NULL, 'larson.com', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:35:48', '2021-11-10 18:35:48', 1, NULL, NULL, NULL),
(31, 3, 94, 'Lexie Grimes', 'rosie.howe@gmail.com', NULL, NULL, 'Pfeffer-VonRueden', '851 Adriel Forge\nMyaland, VA 81410', NULL, NULL, NULL, NULL, NULL, 'ratke.com', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:35:48', '2021-11-10 18:35:48', 1, NULL, NULL, NULL),
(32, 4, 115, 'Levi Jones', 'erdman.vicente@bode.com', NULL, NULL, 'Dach, Boyle and Kautzer', '298 Tillman Ville Suite 763\nRatkemouth, NC 28480', NULL, NULL, NULL, NULL, NULL, 'ebert.com', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:36:16', '2021-11-10 18:36:16', 1, NULL, NULL, NULL),
(33, 4, 116, 'Mr. Cesar Eichmann', 'hglover@grady.com', NULL, NULL, 'McKenzie-Streich', '993 Jones Turnpike\nConnellyview, SD 61259-4937', NULL, NULL, NULL, NULL, NULL, 'heathcote.com', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:36:16', '2021-11-10 18:36:16', 1, NULL, NULL, NULL),
(34, 4, 117, 'Macie Strosin Sr.', 'florian.reichert@stokes.info', NULL, NULL, 'Corwin, O\'Conner and Schuster', '7352 Anya Vista Suite 703\nSouth Taraport, NV 64029', NULL, NULL, NULL, NULL, NULL, 'rogahn.org', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:36:16', '2021-11-10 18:36:16', 1, NULL, NULL, NULL),
(35, 4, 118, 'Melba Fay', 'senger.davion@hotmail.com', NULL, NULL, 'Lemke and Sons', '3975 Rodriguez Villages Suite 117\nJaydeshire, NJ 25425', NULL, NULL, NULL, NULL, NULL, 'quitzon.com', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:36:16', '2021-11-10 18:36:16', 1, NULL, NULL, NULL),
(36, 4, 119, 'Jameson Harvey', 'rquigley@hotmail.com', NULL, NULL, 'Dibbert Inc', '44471 Edmond Trail Suite 350\nKianatown, OR 30149', NULL, NULL, NULL, NULL, NULL, 'sawayn.biz', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:36:16', '2021-11-10 18:36:16', 1, NULL, NULL, NULL),
(37, 4, 120, 'Prof. Shaylee Bechtelar', 'lueilwitz.joaquin@goyette.org', NULL, NULL, 'Eichmann, Towne and Ferry', '937 Julian Viaduct Apt. 906\nKreigerburgh, VT 73702', NULL, NULL, NULL, NULL, NULL, 'hyatt.biz', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:36:18', '2021-11-10 18:36:18', 1, NULL, NULL, NULL),
(38, 4, 121, 'Dr. Kaci Quitzon DDS', 'uledner@yahoo.com', NULL, NULL, 'Bechtelar-Hamill', '360 Lowe Rapids\nDanielland, KY 88146', NULL, NULL, NULL, NULL, NULL, 'rath.com', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:36:18', '2021-11-10 18:36:18', 1, NULL, NULL, NULL),
(39, 4, 122, 'Bert Bartell', 'delbert12@stark.com', NULL, NULL, 'Pollich-Morissette', '711 Elody Mission Apt. 619\nLueilwitzberg, NH 31972-2997', NULL, NULL, NULL, NULL, NULL, 'dach.net', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:36:18', '2021-11-10 18:36:18', 1, NULL, NULL, NULL),
(40, 4, 123, 'Skylar Oberbrunner', 'blanda.raheem@kling.com', NULL, NULL, 'Hoppe Ltd', '6109 Meredith Court\nBreanaton, NC 45923', NULL, NULL, NULL, NULL, NULL, 'jaskolski.com', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:36:19', '2021-11-10 18:36:19', 1, NULL, NULL, NULL),
(41, 4, 124, 'Ervin Gislason MD', 'robel.kasandra@gmail.com', NULL, NULL, 'Green, Nitzsche and Klocko', '100 Lora Locks\nEast Alysa, ID 04515-8746', NULL, NULL, NULL, NULL, NULL, 'steuber.net', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:36:19', '2021-11-10 18:36:19', 1, NULL, NULL, NULL),
(42, 5, 145, 'Kellie Powlowski', 'alan.greenfelder@hotmail.com', NULL, NULL, 'Schuster-O\'Conner', '3232 Runolfsson Unions Suite 331\nDeonside, ME 51740-1481', NULL, NULL, NULL, NULL, NULL, 'gulgowski.com', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:36:43', '2021-11-10 18:36:43', 1, NULL, NULL, NULL),
(43, 5, 146, 'Mr. Vern Murray MD', 'khalvorson@gmail.com', NULL, NULL, 'Koch-Connelly', '9218 O\'Conner Well Suite 566\nGerhardton, GA 13507-9069', NULL, NULL, NULL, NULL, NULL, 'ratke.com', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:36:43', '2021-11-10 18:36:43', 1, NULL, NULL, NULL),
(44, 5, 147, 'Kian DuBuque', 'abraham43@gmail.com', NULL, NULL, 'Kilback-Rosenbaum', '39910 Harris Freeway Suite 283\nRusselmouth, OR 82967', NULL, NULL, NULL, NULL, NULL, 'towne.net', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:36:43', '2021-11-10 18:36:43', 1, NULL, NULL, NULL),
(45, 5, 148, 'Vicenta Emard', 'dpaucek@gmail.com', NULL, NULL, 'Crona, Jacobson and Gislason', '1385 Bogisich Freeway Suite 328\nNorth Maximechester, MO 60448-7815', NULL, NULL, NULL, NULL, NULL, 'mann.com', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:36:44', '2021-11-10 18:36:44', 1, NULL, NULL, NULL),
(46, 5, 149, 'Demond Considine I', 'kolby.nicolas@hotmail.com', NULL, NULL, 'Kovacek, Pacocha and Schneider', '685 Kristina Plains Apt. 668\nRennerfurt, DC 09727', NULL, NULL, NULL, NULL, NULL, 'goyette.com', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:36:44', '2021-11-10 18:36:44', 1, NULL, NULL, NULL),
(47, 5, 150, 'Braulio Wintheiser', 'vmetz@dach.com', NULL, NULL, 'Schaden-Zieme', '500 Will Junctions Apt. 169\nEbertfurt, IA 45901', NULL, NULL, NULL, NULL, NULL, 'sporer.com', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:36:44', '2021-11-10 18:36:44', 1, NULL, NULL, NULL),
(48, 5, 151, 'Prof. Jonatan Kautzer', 'oratke@schoen.com', NULL, NULL, 'Gottlieb, Bayer and Stokes', '901 White Pines Suite 403\nEast Donnyhaven, MS 54721-9557', NULL, NULL, NULL, NULL, NULL, 'macejkovic.org', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:36:44', '2021-11-10 18:36:44', 1, NULL, NULL, NULL),
(49, 5, 152, 'Hattie Kutch', 'wolff.ruben@hodkiewicz.org', NULL, NULL, 'Dibbert-Senger', '67756 Wiza Estates\nGustfort, LA 56018', NULL, NULL, NULL, NULL, NULL, 'jacobson.info', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:36:45', '2021-11-10 18:36:45', 1, NULL, NULL, NULL),
(50, 5, 153, 'Miss Yvonne Haley', 'gilberto.koepp@yahoo.com', NULL, NULL, 'West-Ullrich', '367 Benton Circles Apt. 678\nNew Annette, MN 67230-5568', NULL, NULL, NULL, NULL, NULL, 'mclaughlin.com', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:36:46', '2021-11-10 18:36:46', 1, NULL, NULL, NULL),
(51, 5, 154, 'Erna Runolfsson III', 'dixie50@doyle.biz', NULL, NULL, 'Bradtke Group', '89242 Glover Knolls\nEast Morgan, MO 82956-4733', NULL, NULL, NULL, NULL, NULL, 'kshlerin.net', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:36:46', '2021-11-10 18:36:46', 1, NULL, NULL, NULL),
(52, 6, 175, 'Tristin Ritchie Jr.', 'terry.golda@hotmail.com', NULL, NULL, 'King-Koss', '30628 Abernathy Hills Apt. 572\nLake Blake, KS 40904-6199', NULL, NULL, NULL, NULL, NULL, 'altenwerth.biz', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:37:11', '2021-11-10 18:37:11', 1, NULL, NULL, NULL),
(53, 6, 176, 'Dr. Colten Hahn', 'fbraun@yahoo.com', NULL, NULL, 'Johnson-Koepp', '3068 Amya Point\nMadisenmouth, AL 96393', NULL, NULL, NULL, NULL, NULL, 'sauer.org', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:37:11', '2021-11-10 18:37:11', 1, NULL, NULL, NULL),
(54, 6, 177, 'Dr. Bettye Dare', 'leola.terry@hotmail.com', NULL, NULL, 'Predovic Ltd', '810 Hailee Mill\nReillyberg, IL 78043', NULL, NULL, NULL, NULL, NULL, 'wyman.org', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:37:11', '2021-11-10 18:37:11', 1, NULL, NULL, NULL),
(55, 6, 178, 'Noelia Jacobi', 'bradtke.braxton@hotmail.com', NULL, NULL, 'Beier-Dickens', '7353 Robel Hollow\nOthamouth, NM 81513-1753', NULL, NULL, NULL, NULL, NULL, 'corwin.com', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:37:12', '2021-11-10 18:37:12', 1, NULL, NULL, NULL),
(56, 6, 179, 'Edyth Schowalter I', 'beaulah.mcdermott@kautzer.com', NULL, NULL, 'Stracke, Crooks and Wuckert', '213 Zachery Plain Suite 744\nWest Danview, CT 18853', NULL, NULL, NULL, NULL, NULL, 'hilpert.org', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:37:12', '2021-11-10 18:37:12', 1, NULL, NULL, NULL),
(57, 6, 180, 'Miss Savanna Nikolaus', 'hbosco@hotmail.com', NULL, NULL, 'Raynor PLC', '229 Lolita Terrace Apt. 941\nTurnermouth, MS 91506-5550', NULL, NULL, NULL, NULL, NULL, 'corwin.com', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:37:12', '2021-11-10 18:37:12', 1, NULL, NULL, NULL),
(58, 6, 181, 'Candice Parker', 'zsmitham@mante.net', NULL, NULL, 'Armstrong Group', '1758 Rey Turnpike Suite 439\nWest Lucas, WV 05840-8758', NULL, NULL, NULL, NULL, NULL, 'larkin.com', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:37:13', '2021-11-10 18:37:13', 1, NULL, NULL, NULL),
(59, 6, 182, 'Zachery Braun', 'arturo69@veum.com', NULL, NULL, 'Lindgren-Crona', '11428 Alford Rapid Suite 266\nNorth Madyson, MI 38756', NULL, NULL, NULL, NULL, NULL, 'beahan.com', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:37:13', '2021-11-10 18:37:13', 1, NULL, NULL, NULL),
(60, 6, 183, 'Rosalyn Wehner', 'runte.ruby@gmail.com', NULL, NULL, 'Medhurst Ltd', '43984 O\'Keefe Courts Suite 321\nO\'Connellside, NJ 07934-1559', NULL, NULL, NULL, NULL, NULL, 'koelpin.org', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:37:13', '2021-11-10 18:37:13', 1, NULL, NULL, NULL),
(61, 6, 184, 'Kendrick Towne', 'shane91@hotmail.com', NULL, NULL, 'McGlynn Group', '9631 Reilly Ferry Suite 757\nAlanisport, AK 25415-6173', NULL, NULL, NULL, NULL, NULL, 'raynor.biz', NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-10 18:37:14', '2021-11-10 18:37:14', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `client_docs`
--

CREATE TABLE `client_docs` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `filename` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `hashname` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `size` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client_sub_categories`
--

CREATE TABLE `client_sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client_user_notes`
--

CREATE TABLE `client_user_notes` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `note_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `company_email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `company_phone` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `login_background` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `currency_id` int(10) UNSIGNED DEFAULT NULL,
  `package_id` int(10) UNSIGNED DEFAULT NULL,
  `package_type` enum('monthly','annual') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'monthly',
  `timezone` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Asia/Kolkata',
  `date_format` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'd-m-Y',
  `date_picker_format` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `moment_format` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time_format` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'h:i A',
  `week_start` int(11) NOT NULL DEFAULT 1,
  `locale` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'en',
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `leaves_start_from` enum('joining_date','year_start') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'joining_date',
  `active_theme` enum('default','custom') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default',
  `status` enum('active','inactive','license_expired') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `task_self` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `last_updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stripe_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `card_brand` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `card_last_four` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `licence_expire_on` date DEFAULT NULL,
  `rounded_theme` tinyint(1) NOT NULL DEFAULT 1,
  `last_login` datetime DEFAULT NULL,
  `default_task_status` int(10) UNSIGNED DEFAULT NULL,
  `show_update_popup` tinyint(1) NOT NULL DEFAULT 1,
  `dashboard_clock` tinyint(1) NOT NULL DEFAULT 1,
  `ticket_form_google_captcha` tinyint(1) NOT NULL DEFAULT 0,
  `lead_form_google_captcha` tinyint(1) NOT NULL DEFAULT 0,
  `rtl` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `company_name`, `company_email`, `company_phone`, `logo`, `login_background`, `address`, `website`, `currency_id`, `package_id`, `package_type`, `timezone`, `date_format`, `date_picker_format`, `moment_format`, `time_format`, `week_start`, `locale`, `latitude`, `longitude`, `leaves_start_from`, `active_theme`, `status`, `task_self`, `last_updated_by`, `created_at`, `updated_at`, `stripe_id`, `card_brand`, `card_last_four`, `trial_ends_at`, `licence_expire_on`, `rounded_theme`, `last_login`, `default_task_status`, `show_update_popup`, `dashboard_clock`, `ticket_form_google_captcha`, `lead_form_google_captcha`, `rtl`) VALUES
(1, 'CODAGETECH Company', 'admin@codagetech.com', '01016542830', NULL, NULL, '14 50st Zone 13, Maadi, Cairo, Egypt', 'https://codagetech.com', 1, 1, 'monthly', 'Asia/Kolkata', 'd-m-Y', 'dd-mm-yyyy', 'DD-MM-YYYY', 'h:i A', 1, 'en', NULL, NULL, 'joining_date', 'default', 'active', 'yes', NULL, '2021-11-10 18:30:12', '2021-11-18 01:42:48', NULL, NULL, NULL, NULL, NULL, 1, '2021-11-17 17:42:48', NULL, 1, 1, 0, 0, 0),
(2, 'Baumbach, Kuhlman and Jenkins', 'cora.ondricka@schmeler.com', '+1-487-379-5259', NULL, NULL, '83093 Alena Mountain\nKirlinberg, NY 24654', 'torp.com', 5, 1, 'monthly', 'Asia/Kolkata', 'd-m-Y', 'dd-mm-yyyy', 'DD-MM-YYYY', 'h:i A', 1, 'en', NULL, NULL, 'joining_date', 'default', 'active', 'yes', NULL, '2021-11-10 18:30:56', '2021-11-10 18:31:40', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, 1, 0, 0, 0),
(3, 'Hammes, Wolf and Boyle', 'tbashirian@nader.net', '+1 (238) 842-4302', NULL, NULL, '25073 Johann Isle\nNew Lincoln, AR 18503-5726', 'rolfson.com', 9, 1, 'monthly', 'Asia/Kolkata', 'd-m-Y', 'dd-mm-yyyy', 'DD-MM-YYYY', 'h:i A', 1, 'en', NULL, NULL, 'joining_date', 'default', 'active', 'yes', NULL, '2021-11-10 18:31:43', '2021-11-10 18:32:19', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, 1, 0, 0, 0),
(4, 'Erdman Ltd', 'zack61@rempel.com', '1-865-359-8667 x5745', NULL, NULL, '52364 Runte Underpass Apt. 591\nLake Percyberg, CT 18161', 'mcdermott.com', 13, 1, 'monthly', 'Asia/Kolkata', 'd-m-Y', 'dd-mm-yyyy', 'DD-MM-YYYY', 'h:i A', 1, 'en', NULL, NULL, 'joining_date', 'default', 'active', 'yes', NULL, '2021-11-10 18:32:20', '2021-11-10 18:33:00', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, 1, 0, 0, 0),
(5, 'Zulauf, Fahey and Reichel', 'ratke.lacey@beahan.com', '1-713-959-6998', NULL, NULL, '21930 Bo Spur\nSouth Ashtynbury, DC 35392', 'luettgen.com', 17, 1, 'monthly', 'Asia/Kolkata', 'd-m-Y', 'dd-mm-yyyy', 'DD-MM-YYYY', 'h:i A', 1, 'en', NULL, NULL, 'joining_date', 'default', 'active', 'yes', NULL, '2021-11-10 18:33:01', '2021-11-10 18:33:41', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, 1, 0, 0, 0),
(6, 'Moen PLC', 'deven.schaefer@hills.biz', '984.518.3945', NULL, NULL, '978 Chanelle Manor Suite 369\nSouth Kay, SC 67707-9836', 'yundt.com', 21, 1, 'monthly', 'Asia/Kolkata', 'd-m-Y', 'dd-mm-yyyy', 'DD-MM-YYYY', 'h:i A', 1, 'en', NULL, NULL, 'joining_date', 'default', 'active', 'yes', NULL, '2021-11-10 18:33:42', '2021-11-10 18:34:22', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `contracts`
--

CREATE TABLE `contracts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `subject` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `amount` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `original_amount` decimal(15,2) NOT NULL,
  `contract_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `start_date` date NOT NULL,
  `original_start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `original_end_date` date DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `contract_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_logo` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alternate_address` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `office_phone` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postal_code` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contract_detail` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `send_status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contract_discussions`
--

CREATE TABLE `contract_discussions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `contract_id` bigint(20) UNSIGNED NOT NULL,
  `from` int(10) UNSIGNED NOT NULL,
  `message` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contract_files`
--

CREATE TABLE `contract_files` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `contract_id` bigint(20) UNSIGNED NOT NULL,
  `filename` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `google_url` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hashname` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `size` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dropbox_link` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `external_link` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `external_link_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contract_renews`
--

CREATE TABLE `contract_renews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `renewed_by` int(10) UNSIGNED NOT NULL,
  `contract_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contract_signs`
--

CREATE TABLE `contract_signs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `contract_id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `signature` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contract_types`
--

CREATE TABLE `contract_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `conversation`
--

CREATE TABLE `conversation` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_one` int(10) UNSIGNED NOT NULL,
  `user_two` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `conversation_reply`
--

CREATE TABLE `conversation_reply` (
  `id` int(10) UNSIGNED NOT NULL,
  `conversation_id` int(10) UNSIGNED NOT NULL,
  `reply` text COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(10) UNSIGNED NOT NULL,
  `iso` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `nicename` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `iso3` char(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `numcode` smallint(6) DEFAULT NULL,
  `phonecode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `iso`, `name`, `nicename`, `iso3`, `numcode`, `phonecode`) VALUES
(1, 'AF', 'AFGHANISTAN', 'Afghanistan', 'AFG', 4, 93),
(2, 'AL', 'ALBANIA', 'Albania', 'ALB', 8, 355),
(3, 'DZ', 'ALGERIA', 'Algeria', 'DZA', 12, 213),
(4, 'AS', 'AMERICAN SAMOA', 'American Samoa', 'ASM', 16, 1684),
(5, 'AD', 'ANDORRA', 'Andorra', 'AND', 20, 376),
(6, 'AO', 'ANGOLA', 'Angola', 'AGO', 24, 244),
(7, 'AI', 'ANGUILLA', 'Anguilla', 'AIA', 660, 1264),
(8, 'AQ', 'ANTARCTICA', 'Antarctica', NULL, NULL, 0),
(9, 'AG', 'ANTIGUA AND BARBUDA', 'Antigua and Barbuda', 'ATG', 28, 1268),
(10, 'AR', 'ARGENTINA', 'Argentina', 'ARG', 32, 54),
(11, 'AM', 'ARMENIA', 'Armenia', 'ARM', 51, 374),
(12, 'AW', 'ARUBA', 'Aruba', 'ABW', 533, 297),
(13, 'AU', 'AUSTRALIA', 'Australia', 'AUS', 36, 61),
(14, 'AT', 'AUSTRIA', 'Austria', 'AUT', 40, 43),
(15, 'AZ', 'AZERBAIJAN', 'Azerbaijan', 'AZE', 31, 994),
(16, 'BS', 'BAHAMAS', 'Bahamas', 'BHS', 44, 1242),
(17, 'BH', 'BAHRAIN', 'Bahrain', 'BHR', 48, 973),
(18, 'BD', 'BANGLADESH', 'Bangladesh', 'BGD', 50, 880),
(19, 'BB', 'BARBADOS', 'Barbados', 'BRB', 52, 1246),
(20, 'BY', 'BELARUS', 'Belarus', 'BLR', 112, 375),
(21, 'BE', 'BELGIUM', 'Belgium', 'BEL', 56, 32),
(22, 'BZ', 'BELIZE', 'Belize', 'BLZ', 84, 501),
(23, 'BJ', 'BENIN', 'Benin', 'BEN', 204, 229),
(24, 'BM', 'BERMUDA', 'Bermuda', 'BMU', 60, 1441),
(25, 'BT', 'BHUTAN', 'Bhutan', 'BTN', 64, 975),
(26, 'BO', 'BOLIVIA', 'Bolivia', 'BOL', 68, 591),
(27, 'BA', 'BOSNIA AND HERZEGOVINA', 'Bosnia and Herzegovina', 'BIH', 70, 387),
(28, 'BW', 'BOTSWANA', 'Botswana', 'BWA', 72, 267),
(29, 'BV', 'BOUVET ISLAND', 'Bouvet Island', NULL, NULL, 0),
(30, 'BR', 'BRAZIL', 'Brazil', 'BRA', 76, 55),
(31, 'IO', 'BRITISH INDIAN OCEAN TERRITORY', 'British Indian Ocean Territory', NULL, NULL, 246),
(32, 'BN', 'BRUNEI DARUSSALAM', 'Brunei Darussalam', 'BRN', 96, 673),
(33, 'BG', 'BULGARIA', 'Bulgaria', 'BGR', 100, 359),
(34, 'BF', 'BURKINA FASO', 'Burkina Faso', 'BFA', 854, 226),
(35, 'BI', 'BURUNDI', 'Burundi', 'BDI', 108, 257),
(36, 'KH', 'CAMBODIA', 'Cambodia', 'KHM', 116, 855),
(37, 'CM', 'CAMEROON', 'Cameroon', 'CMR', 120, 237),
(38, 'CA', 'CANADA', 'Canada', 'CAN', 124, 1),
(39, 'CV', 'CAPE VERDE', 'Cape Verde', 'CPV', 132, 238),
(40, 'KY', 'CAYMAN ISLANDS', 'Cayman Islands', 'CYM', 136, 1345),
(41, 'CF', 'CENTRAL AFRICAN REPUBLIC', 'Central African Republic', 'CAF', 140, 236),
(42, 'TD', 'CHAD', 'Chad', 'TCD', 148, 235),
(43, 'CL', 'CHILE', 'Chile', 'CHL', 152, 56),
(44, 'CN', 'CHINA', 'China', 'CHN', 156, 86),
(45, 'CX', 'CHRISTMAS ISLAND', 'Christmas Island', NULL, NULL, 61),
(46, 'CC', 'COCOS (KEELING) ISLANDS', 'Cocos (Keeling) Islands', NULL, NULL, 672),
(47, 'CO', 'COLOMBIA', 'Colombia', 'COL', 170, 57),
(48, 'KM', 'COMOROS', 'Comoros', 'COM', 174, 269),
(49, 'CG', 'CONGO', 'Congo', 'COG', 178, 242),
(50, 'CD', 'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 'Congo, the Democratic Republic of the', 'COD', 180, 242),
(51, 'CK', 'COOK ISLANDS', 'Cook Islands', 'COK', 184, 682),
(52, 'CR', 'COSTA RICA', 'Costa Rica', 'CRI', 188, 506),
(53, 'CI', 'COTE D\'IVOIRE', 'Cote D\'Ivoire', 'CIV', 384, 225),
(54, 'HR', 'CROATIA', 'Croatia', 'HRV', 191, 385),
(55, 'CU', 'CUBA', 'Cuba', 'CUB', 192, 53),
(56, 'CY', 'CYPRUS', 'Cyprus', 'CYP', 196, 357),
(57, 'CZ', 'CZECH REPUBLIC', 'Czech Republic', 'CZE', 203, 420),
(58, 'DK', 'DENMARK', 'Denmark', 'DNK', 208, 45),
(59, 'DJ', 'DJIBOUTI', 'Djibouti', 'DJI', 262, 253),
(60, 'DM', 'DOMINICA', 'Dominica', 'DMA', 212, 1767),
(61, 'DO', 'DOMINICAN REPUBLIC', 'Dominican Republic', 'DOM', 214, 1809),
(62, 'EC', 'ECUADOR', 'Ecuador', 'ECU', 218, 593),
(63, 'EG', 'EGYPT', 'Egypt', 'EGY', 818, 20),
(64, 'SV', 'EL SALVADOR', 'El Salvador', 'SLV', 222, 503),
(65, 'GQ', 'EQUATORIAL GUINEA', 'Equatorial Guinea', 'GNQ', 226, 240),
(66, 'ER', 'ERITREA', 'Eritrea', 'ERI', 232, 291),
(67, 'EE', 'ESTONIA', 'Estonia', 'EST', 233, 372),
(68, 'ET', 'ETHIOPIA', 'Ethiopia', 'ETH', 231, 251),
(69, 'FK', 'FALKLAND ISLANDS (MALVINAS)', 'Falkland Islands (Malvinas)', 'FLK', 238, 500),
(70, 'FO', 'FAROE ISLANDS', 'Faroe Islands', 'FRO', 234, 298),
(71, 'FJ', 'FIJI', 'Fiji', 'FJI', 242, 679),
(72, 'FI', 'FINLAND', 'Finland', 'FIN', 246, 358),
(73, 'FR', 'FRANCE', 'France', 'FRA', 250, 33),
(74, 'GF', 'FRENCH GUIANA', 'French Guiana', 'GUF', 254, 594),
(75, 'PF', 'FRENCH POLYNESIA', 'French Polynesia', 'PYF', 258, 689),
(76, 'TF', 'FRENCH SOUTHERN TERRITORIES', 'French Southern Territories', NULL, NULL, 0),
(77, 'GA', 'GABON', 'Gabon', 'GAB', 266, 241),
(78, 'GM', 'GAMBIA', 'Gambia', 'GMB', 270, 220),
(79, 'GE', 'GEORGIA', 'Georgia', 'GEO', 268, 995),
(80, 'DE', 'GERMANY', 'Germany', 'DEU', 276, 49),
(81, 'GH', 'GHANA', 'Ghana', 'GHA', 288, 233),
(82, 'GI', 'GIBRALTAR', 'Gibraltar', 'GIB', 292, 350),
(83, 'GR', 'GREECE', 'Greece', 'GRC', 300, 30),
(84, 'GL', 'GREENLAND', 'Greenland', 'GRL', 304, 299),
(85, 'GD', 'GRENADA', 'Grenada', 'GRD', 308, 1473),
(86, 'GP', 'GUADELOUPE', 'Guadeloupe', 'GLP', 312, 590),
(87, 'GU', 'GUAM', 'Guam', 'GUM', 316, 1671),
(88, 'GT', 'GUATEMALA', 'Guatemala', 'GTM', 320, 502),
(89, 'GN', 'GUINEA', 'Guinea', 'GIN', 324, 224),
(90, 'GW', 'GUINEA-BISSAU', 'Guinea-Bissau', 'GNB', 624, 245),
(91, 'GY', 'GUYANA', 'Guyana', 'GUY', 328, 592),
(92, 'HT', 'HAITI', 'Haiti', 'HTI', 332, 509),
(93, 'HM', 'HEARD ISLAND AND MCDONALD ISLANDS', 'Heard Island and Mcdonald Islands', NULL, NULL, 0),
(94, 'VA', 'HOLY SEE (VATICAN CITY STATE)', 'Holy See (Vatican City State)', 'VAT', 336, 39),
(95, 'HN', 'HONDURAS', 'Honduras', 'HND', 340, 504),
(96, 'HK', 'HONG KONG', 'Hong Kong', 'HKG', 344, 852),
(97, 'HU', 'HUNGARY', 'Hungary', 'HUN', 348, 36),
(98, 'IS', 'ICELAND', 'Iceland', 'ISL', 352, 354),
(99, 'IN', 'INDIA', 'India', 'IND', 356, 91),
(100, 'ID', 'INDONESIA', 'Indonesia', 'IDN', 360, 62),
(101, 'IR', 'IRAN, ISLAMIC REPUBLIC OF', 'Iran, Islamic Republic of', 'IRN', 364, 98),
(102, 'IQ', 'IRAQ', 'Iraq', 'IRQ', 368, 964),
(103, 'IE', 'IRELAND', 'Ireland', 'IRL', 372, 353),
(104, 'IL', 'ISRAEL', 'Israel', 'ISR', 376, 972),
(105, 'IT', 'ITALY', 'Italy', 'ITA', 380, 39),
(106, 'JM', 'JAMAICA', 'Jamaica', 'JAM', 388, 1876),
(107, 'JP', 'JAPAN', 'Japan', 'JPN', 392, 81),
(108, 'JO', 'JORDAN', 'Jordan', 'JOR', 400, 962),
(109, 'KZ', 'KAZAKHSTAN', 'Kazakhstan', 'KAZ', 398, 7),
(110, 'KE', 'KENYA', 'Kenya', 'KEN', 404, 254),
(111, 'KI', 'KIRIBATI', 'Kiribati', 'KIR', 296, 686),
(112, 'KP', 'KOREA, DEMOCRATIC PEOPLE\'S REPUBLIC OF', 'Korea, Democratic People\'s Republic of', 'PRK', 408, 850),
(113, 'KR', 'KOREA, REPUBLIC OF', 'Korea, Republic of', 'KOR', 410, 82),
(114, 'KW', 'KUWAIT', 'Kuwait', 'KWT', 414, 965),
(115, 'KG', 'KYRGYZSTAN', 'Kyrgyzstan', 'KGZ', 417, 996),
(116, 'LA', 'LAO PEOPLE\'S DEMOCRATIC REPUBLIC', 'Lao People\'s Democratic Republic', 'LAO', 418, 856),
(117, 'LV', 'LATVIA', 'Latvia', 'LVA', 428, 371),
(118, 'LB', 'LEBANON', 'Lebanon', 'LBN', 422, 961),
(119, 'LS', 'LESOTHO', 'Lesotho', 'LSO', 426, 266),
(120, 'LR', 'LIBERIA', 'Liberia', 'LBR', 430, 231),
(121, 'LY', 'LIBYAN ARAB JAMAHIRIYA', 'Libyan Arab Jamahiriya', 'LBY', 434, 218),
(122, 'LI', 'LIECHTENSTEIN', 'Liechtenstein', 'LIE', 438, 423),
(123, 'LT', 'LITHUANIA', 'Lithuania', 'LTU', 440, 370),
(124, 'LU', 'LUXEMBOURG', 'Luxembourg', 'LUX', 442, 352),
(125, 'MO', 'MACAO', 'Macao', 'MAC', 446, 853),
(126, 'MK', 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF', 'Macedonia, the Former Yugoslav Republic of', 'MKD', 807, 389),
(127, 'MG', 'MADAGASCAR', 'Madagascar', 'MDG', 450, 261),
(128, 'MW', 'MALAWI', 'Malawi', 'MWI', 454, 265),
(129, 'MY', 'MALAYSIA', 'Malaysia', 'MYS', 458, 60),
(130, 'MV', 'MALDIVES', 'Maldives', 'MDV', 462, 960),
(131, 'ML', 'MALI', 'Mali', 'MLI', 466, 223),
(132, 'MT', 'MALTA', 'Malta', 'MLT', 470, 356),
(133, 'MH', 'MARSHALL ISLANDS', 'Marshall Islands', 'MHL', 584, 692),
(134, 'MQ', 'MARTINIQUE', 'Martinique', 'MTQ', 474, 596),
(135, 'MR', 'MAURITANIA', 'Mauritania', 'MRT', 478, 222),
(136, 'MU', 'MAURITIUS', 'Mauritius', 'MUS', 480, 230),
(137, 'YT', 'MAYOTTE', 'Mayotte', NULL, NULL, 269),
(138, 'MX', 'MEXICO', 'Mexico', 'MEX', 484, 52),
(139, 'FM', 'MICRONESIA, FEDERATED STATES OF', 'Micronesia, Federated States of', 'FSM', 583, 691),
(140, 'MD', 'MOLDOVA, REPUBLIC OF', 'Moldova, Republic of', 'MDA', 498, 373),
(141, 'MC', 'MONACO', 'Monaco', 'MCO', 492, 377),
(142, 'MN', 'MONGOLIA', 'Mongolia', 'MNG', 496, 976),
(143, 'MS', 'MONTSERRAT', 'Montserrat', 'MSR', 500, 1664),
(144, 'MA', 'MOROCCO', 'Morocco', 'MAR', 504, 212),
(145, 'MZ', 'MOZAMBIQUE', 'Mozambique', 'MOZ', 508, 258),
(146, 'MM', 'MYANMAR', 'Myanmar', 'MMR', 104, 95),
(147, 'NA', 'NAMIBIA', 'Namibia', 'NAM', 516, 264),
(148, 'NR', 'NAURU', 'Nauru', 'NRU', 520, 674),
(149, 'NP', 'NEPAL', 'Nepal', 'NPL', 524, 977),
(150, 'NL', 'NETHERLANDS', 'Netherlands', 'NLD', 528, 31),
(151, 'AN', 'NETHERLANDS ANTILLES', 'Netherlands Antilles', 'ANT', 530, 599),
(152, 'NC', 'NEW CALEDONIA', 'New Caledonia', 'NCL', 540, 687),
(153, 'NZ', 'NEW ZEALAND', 'New Zealand', 'NZL', 554, 64),
(154, 'NI', 'NICARAGUA', 'Nicaragua', 'NIC', 558, 505),
(155, 'NE', 'NIGER', 'Niger', 'NER', 562, 227),
(156, 'NG', 'NIGERIA', 'Nigeria', 'NGA', 566, 234),
(157, 'NU', 'NIUE', 'Niue', 'NIU', 570, 683),
(158, 'NF', 'NORFOLK ISLAND', 'Norfolk Island', 'NFK', 574, 672),
(159, 'MP', 'NORTHERN MARIANA ISLANDS', 'Northern Mariana Islands', 'MNP', 580, 1670),
(160, 'NO', 'NORWAY', 'Norway', 'NOR', 578, 47),
(161, 'OM', 'OMAN', 'Oman', 'OMN', 512, 968),
(162, 'PK', 'PAKISTAN', 'Pakistan', 'PAK', 586, 92),
(163, 'PW', 'PALAU', 'Palau', 'PLW', 585, 680),
(164, 'PS', 'PALESTINIAN TERRITORY, OCCUPIED', 'Palestinian Territory, Occupied', NULL, NULL, 970),
(165, 'PA', 'PANAMA', 'Panama', 'PAN', 591, 507),
(166, 'PG', 'PAPUA NEW GUINEA', 'Papua New Guinea', 'PNG', 598, 675),
(167, 'PY', 'PARAGUAY', 'Paraguay', 'PRY', 600, 595),
(168, 'PE', 'PERU', 'Peru', 'PER', 604, 51),
(169, 'PH', 'PHILIPPINES', 'Philippines', 'PHL', 608, 63),
(170, 'PN', 'PITCAIRN', 'Pitcairn', 'PCN', 612, 0),
(171, 'PL', 'POLAND', 'Poland', 'POL', 616, 48),
(172, 'PT', 'PORTUGAL', 'Portugal', 'PRT', 620, 351),
(173, 'PR', 'PUERTO RICO', 'Puerto Rico', 'PRI', 630, 1787),
(174, 'QA', 'QATAR', 'Qatar', 'QAT', 634, 974),
(175, 'RE', 'REUNION', 'Reunion', 'REU', 638, 262),
(176, 'RO', 'ROMANIA', 'Romania', 'ROM', 642, 40),
(177, 'RU', 'RUSSIAN FEDERATION', 'Russian Federation', 'RUS', 643, 70),
(178, 'RW', 'RWANDA', 'Rwanda', 'RWA', 646, 250),
(179, 'SH', 'SAINT HELENA', 'Saint Helena', 'SHN', 654, 290),
(180, 'KN', 'SAINT KITTS AND NEVIS', 'Saint Kitts and Nevis', 'KNA', 659, 1869),
(181, 'LC', 'SAINT LUCIA', 'Saint Lucia', 'LCA', 662, 1758),
(182, 'PM', 'SAINT PIERRE AND MIQUELON', 'Saint Pierre and Miquelon', 'SPM', 666, 508),
(183, 'VC', 'SAINT VINCENT AND THE GRENADINES', 'Saint Vincent and the Grenadines', 'VCT', 670, 1784),
(184, 'WS', 'SAMOA', 'Samoa', 'WSM', 882, 684),
(185, 'SM', 'SAN MARINO', 'San Marino', 'SMR', 674, 378),
(186, 'ST', 'SAO TOME AND PRINCIPE', 'Sao Tome and Principe', 'STP', 678, 239),
(187, 'SA', 'SAUDI ARABIA', 'Saudi Arabia', 'SAU', 682, 966),
(188, 'SN', 'SENEGAL', 'Senegal', 'SEN', 686, 221),
(189, 'CS', 'SERBIA AND MONTENEGRO', 'Serbia and Montenegro', NULL, NULL, 381),
(190, 'SC', 'SEYCHELLES', 'Seychelles', 'SYC', 690, 248),
(191, 'SL', 'SIERRA LEONE', 'Sierra Leone', 'SLE', 694, 232),
(192, 'SG', 'SINGAPORE', 'Singapore', 'SGP', 702, 65),
(193, 'SK', 'SLOVAKIA', 'Slovakia', 'SVK', 703, 421),
(194, 'SI', 'SLOVENIA', 'Slovenia', 'SVN', 705, 386),
(195, 'SB', 'SOLOMON ISLANDS', 'Solomon Islands', 'SLB', 90, 677),
(196, 'SO', 'SOMALIA', 'Somalia', 'SOM', 706, 252),
(197, 'ZA', 'SOUTH AFRICA', 'South Africa', 'ZAF', 710, 27),
(198, 'GS', 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'South Georgia and the South Sandwich Islands', NULL, NULL, 0),
(199, 'ES', 'SPAIN', 'Spain', 'ESP', 724, 34),
(200, 'LK', 'SRI LANKA', 'Sri Lanka', 'LKA', 144, 94),
(201, 'SD', 'SUDAN', 'Sudan', 'SDN', 736, 249),
(202, 'SR', 'SURINAME', 'Suriname', 'SUR', 740, 597),
(203, 'SJ', 'SVALBARD AND JAN MAYEN', 'Svalbard and Jan Mayen', 'SJM', 744, 47),
(204, 'SZ', 'SWAZILAND', 'Swaziland', 'SWZ', 748, 268),
(205, 'SE', 'SWEDEN', 'Sweden', 'SWE', 752, 46),
(206, 'CH', 'SWITZERLAND', 'Switzerland', 'CHE', 756, 41),
(207, 'SY', 'SYRIAN ARAB REPUBLIC', 'Syrian Arab Republic', 'SYR', 760, 963),
(208, 'TW', 'TAIWAN, PROVINCE OF CHINA', 'Taiwan, Province of China', 'TWN', 158, 886),
(209, 'TJ', 'TAJIKISTAN', 'Tajikistan', 'TJK', 762, 992),
(210, 'TZ', 'TANZANIA, UNITED REPUBLIC OF', 'Tanzania, United Republic of', 'TZA', 834, 255),
(211, 'TH', 'THAILAND', 'Thailand', 'THA', 764, 66),
(212, 'TL', 'TIMOR-LESTE', 'Timor-Leste', NULL, NULL, 670),
(213, 'TG', 'TOGO', 'Togo', 'TGO', 768, 228),
(214, 'TK', 'TOKELAU', 'Tokelau', 'TKL', 772, 690),
(215, 'TO', 'TONGA', 'Tonga', 'TON', 776, 676),
(216, 'TT', 'TRINIDAD AND TOBAGO', 'Trinidad and Tobago', 'TTO', 780, 1868),
(217, 'TN', 'TUNISIA', 'Tunisia', 'TUN', 788, 216),
(218, 'TR', 'TURKEY', 'Turkey', 'TUR', 792, 90),
(219, 'TM', 'TURKMENISTAN', 'Turkmenistan', 'TKM', 795, 7370),
(220, 'TC', 'TURKS AND CAICOS ISLANDS', 'Turks and Caicos Islands', 'TCA', 796, 1649),
(221, 'TV', 'TUVALU', 'Tuvalu', 'TUV', 798, 688),
(222, 'UG', 'UGANDA', 'Uganda', 'UGA', 800, 256),
(223, 'UA', 'UKRAINE', 'Ukraine', 'UKR', 804, 380),
(224, 'AE', 'UNITED ARAB EMIRATES', 'United Arab Emirates', 'ARE', 784, 971),
(225, 'GB', 'UNITED KINGDOM', 'United Kingdom', 'GBR', 826, 44),
(226, 'US', 'UNITED STATES', 'United States', 'USA', 840, 1),
(227, 'UM', 'UNITED STATES MINOR OUTLYING ISLANDS', 'United States Minor Outlying Islands', NULL, NULL, 1),
(228, 'UY', 'URUGUAY', 'Uruguay', 'URY', 858, 598),
(229, 'UZ', 'UZBEKISTAN', 'Uzbekistan', 'UZB', 860, 998),
(230, 'VU', 'VANUATU', 'Vanuatu', 'VUT', 548, 678),
(231, 'VE', 'VENEZUELA', 'Venezuela', 'VEN', 862, 58),
(232, 'VN', 'VIET NAM', 'Viet Nam', 'VNM', 704, 84),
(233, 'VG', 'VIRGIN ISLANDS, BRITISH', 'Virgin Islands, British', 'VGB', 92, 1284),
(234, 'VI', 'VIRGIN ISLANDS, U.S.', 'Virgin Islands, U.s.', 'VIR', 850, 1340),
(235, 'WF', 'WALLIS AND FUTUNA', 'Wallis and Futuna', 'WLF', 876, 681),
(236, 'EH', 'WESTERN SAHARA', 'Western Sahara', 'ESH', 732, 212),
(237, 'YE', 'YEMEN', 'Yemen', 'YEM', 887, 967),
(238, 'ZM', 'ZAMBIA', 'Zambia', 'ZMB', 894, 260),
(239, 'ZW', 'ZIMBABWE', 'Zimbabwe', 'ZWE', 716, 263),
(240, 'RS', 'SERBIA', 'Serbia', 'SRB', 688, 381),
(241, 'AP', 'ASIA PACIFIC REGION', 'Asia / Pacific Region', '0', 0, 0),
(242, 'ME', 'MONTENEGRO', 'Montenegro', 'MNE', 499, 382),
(243, 'AX', 'ALAND ISLANDS', 'Aland Islands', 'ALA', 248, 358),
(244, 'BQ', 'BONAIRE, SINT EUSTATIUS AND SABA', 'Bonaire, Sint Eustatius and Saba', 'BES', 535, 599),
(245, 'CW', 'CURACAO', 'Curacao', 'CUW', 531, 599),
(246, 'GG', 'GUERNSEY', 'Guernsey', 'GGY', 831, 44),
(247, 'IM', 'ISLE OF MAN', 'Isle of Man', 'IMN', 833, 44),
(248, 'JE', 'JERSEY', 'Jersey', 'JEY', 832, 44),
(249, 'XK', 'KOSOVO', 'Kosovo', '---', 0, 381),
(250, 'BL', 'SAINT BARTHELEMY', 'Saint Barthelemy', 'BLM', 652, 590),
(251, 'MF', 'SAINT MARTIN', 'Saint Martin', 'MAF', 663, 590),
(252, 'SX', 'SINT MAARTEN', 'Sint Maarten', 'SXM', 534, 1),
(253, 'SS', 'SOUTH SUDAN', 'South Sudan', 'SSD', 728, 211);

-- --------------------------------------------------------

--
-- Table structure for table `credit_notes`
--

CREATE TABLE `credit_notes` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `project_id` int(10) UNSIGNED DEFAULT NULL,
  `cn_number` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `invoice_id` int(10) UNSIGNED DEFAULT NULL,
  `issue_date` date NOT NULL,
  `due_date` date NOT NULL,
  `discount` double NOT NULL DEFAULT 0,
  `discount_type` enum('percent','fixed') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'percent',
  `sub_total` double(8,2) NOT NULL,
  `total` double(8,2) NOT NULL,
  `currency_id` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('closed','open') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'closed',
  `recurring` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `billing_frequency` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_interval` int(11) DEFAULT NULL,
  `billing_cycle` int(11) DEFAULT NULL,
  `file` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_original_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `client_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `credit_notes_invoice`
--

CREATE TABLE `credit_notes_invoice` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `credit_notes_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `date` datetime NOT NULL,
  `credit_amount` double(16,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `credit_note_items`
--

CREATE TABLE `credit_note_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `credit_note_id` int(10) UNSIGNED NOT NULL,
  `item_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('item','discount','tax') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'item',
  `quantity` int(11) NOT NULL,
  `unit_price` double(8,2) NOT NULL,
  `amount` double(8,2) NOT NULL,
  `taxes` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `hsn_sac_code` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `currency_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `currency_symbol` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `currency_code` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `exchange_rate` double DEFAULT NULL,
  `is_cryptocurrency` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `usd_price` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `currency_position` enum('front','behind') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'front',
  `status` enum('enable','disable') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'enable'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `company_id`, `currency_name`, `currency_symbol`, `currency_code`, `exchange_rate`, `is_cryptocurrency`, `usd_price`, `created_at`, `updated_at`, `currency_position`, `status`) VALUES
(1, 1, 'Egyptian Pound', 'LE', 'EGP', NULL, 'no', NULL, '2021-11-10 18:30:26', '2021-11-10 18:30:26', 'front', 'enable'),
(2, 1, 'Dollars', '$', 'USD', NULL, 'no', NULL, '2021-11-10 18:30:26', '2021-11-10 18:30:26', 'front', 'enable'),
(3, 1, 'Pounds', '£', 'GBP', NULL, 'no', NULL, '2021-11-10 18:30:26', '2021-11-10 18:30:26', 'front', 'enable'),
(4, 1, 'Euros', '€', 'EUR', NULL, 'no', NULL, '2021-11-10 18:30:27', '2021-11-10 18:30:27', 'behind', 'enable'),
(5, 2, 'Egyptian Pound', 'LE', 'EGP', NULL, 'no', NULL, '2021-11-10 18:31:12', '2021-11-10 18:31:12', 'front', 'enable'),
(6, 2, 'Dollars', '$', 'USD', NULL, 'no', NULL, '2021-11-10 18:31:12', '2021-11-10 18:31:12', 'front', 'enable'),
(7, 2, 'Pounds', '£', 'GBP', NULL, 'no', NULL, '2021-11-10 18:31:12', '2021-11-10 18:31:12', 'front', 'enable'),
(8, 2, 'Euros', '€', 'EUR', NULL, 'no', NULL, '2021-11-10 18:31:13', '2021-11-10 18:31:13', 'behind', 'enable'),
(9, 3, 'Egyptian Pound', 'LE', 'EGP', NULL, 'no', NULL, '2021-11-10 18:32:02', '2021-11-10 18:32:02', 'front', 'enable'),
(10, 3, 'Dollars', '$', 'USD', NULL, 'no', NULL, '2021-11-10 18:32:03', '2021-11-10 18:32:03', 'front', 'enable'),
(11, 3, 'Pounds', '£', 'GBP', NULL, 'no', NULL, '2021-11-10 18:32:03', '2021-11-10 18:32:03', 'front', 'enable'),
(12, 3, 'Euros', '€', 'EUR', NULL, 'no', NULL, '2021-11-10 18:32:03', '2021-11-10 18:32:03', 'behind', 'enable'),
(13, 4, 'Egyptian Pound', 'LE', 'EGP', NULL, 'no', NULL, '2021-11-10 18:32:38', '2021-11-10 18:32:38', 'front', 'enable'),
(14, 4, 'Dollars', '$', 'USD', NULL, 'no', NULL, '2021-11-10 18:32:39', '2021-11-10 18:32:39', 'front', 'enable'),
(15, 4, 'Pounds', '£', 'GBP', NULL, 'no', NULL, '2021-11-10 18:32:39', '2021-11-10 18:32:39', 'front', 'enable'),
(16, 4, 'Euros', '€', 'EUR', NULL, 'no', NULL, '2021-11-10 18:32:40', '2021-11-10 18:32:40', 'behind', 'enable'),
(17, 5, 'Egyptian Pound', 'LE', 'EGP', NULL, 'no', NULL, '2021-11-10 18:33:20', '2021-11-10 18:33:20', 'front', 'enable'),
(18, 5, 'Dollars', '$', 'USD', NULL, 'no', NULL, '2021-11-10 18:33:20', '2021-11-10 18:33:20', 'front', 'enable'),
(19, 5, 'Pounds', '£', 'GBP', NULL, 'no', NULL, '2021-11-10 18:33:20', '2021-11-10 18:33:20', 'front', 'enable'),
(20, 5, 'Euros', '€', 'EUR', NULL, 'no', NULL, '2021-11-10 18:33:20', '2021-11-10 18:33:20', 'behind', 'enable'),
(21, 6, 'Egyptian Pound', 'LE', 'EGP', NULL, 'no', NULL, '2021-11-10 18:33:59', '2021-11-10 18:33:59', 'front', 'enable'),
(22, 6, 'Dollars', '$', 'USD', NULL, 'no', NULL, '2021-11-10 18:34:00', '2021-11-10 18:34:00', 'front', 'enable'),
(23, 6, 'Pounds', '£', 'GBP', NULL, 'no', NULL, '2021-11-10 18:34:00', '2021-11-10 18:34:00', 'front', 'enable'),
(24, 6, 'Euros', '€', 'EUR', NULL, 'no', NULL, '2021-11-10 18:34:00', '2021-11-10 18:34:00', 'behind', 'enable');

-- --------------------------------------------------------

--
-- Table structure for table `currency_format_settings`
--

CREATE TABLE `currency_format_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `currency_position` enum('left','right','left_with_space','right_with_space') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'left',
  `no_of_decimal` int(10) UNSIGNED NOT NULL,
  `thousand_separator` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `decimal_separator` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sample_data` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `currency_format_settings`
--

INSERT INTO `currency_format_settings` (`id`, `company_id`, `currency_position`, `no_of_decimal`, `thousand_separator`, `decimal_separator`, `sample_data`) VALUES
(1, NULL, 'left', 2, ',', '.', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `custom_fields`
--

CREATE TABLE `custom_fields` (
  `id` int(10) UNSIGNED NOT NULL,
  `custom_field_group_id` int(10) UNSIGNED DEFAULT NULL,
  `label` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `required` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `values` varchar(5000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `show_employee` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custom_fields_data`
--

CREATE TABLE `custom_fields_data` (
  `id` int(10) UNSIGNED NOT NULL,
  `custom_field_id` int(10) UNSIGNED NOT NULL,
  `model_id` int(10) UNSIGNED NOT NULL,
  `model` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(10000) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custom_field_groups`
--

CREATE TABLE `custom_field_groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `model` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `custom_field_groups`
--

INSERT INTO `custom_field_groups` (`id`, `company_id`, `name`, `model`) VALUES
(1, NULL, 'Company', 'App\\Company'),
(2, 1, 'Client', 'App\\ClientDetails'),
(3, 1, 'Employee', 'App\\EmployeeDetails'),
(4, 1, 'Project', 'App\\Project'),
(5, 1, 'Invoice', 'App\\Invoice'),
(6, 1, 'Estimate', 'App\\Estimate'),
(7, 1, 'Task', 'App\\Task'),
(8, 1, 'Expense', 'App\\Expense'),
(9, 1, 'Lead', 'App\\Lead'),
(10, 2, 'Client', 'App\\ClientDetails'),
(11, 2, 'Employee', 'App\\EmployeeDetails'),
(12, 2, 'Project', 'App\\Project'),
(13, 2, 'Invoice', 'App\\Invoice'),
(14, 2, 'Estimate', 'App\\Estimate'),
(15, 2, 'Task', 'App\\Task'),
(16, 2, 'Expense', 'App\\Expense'),
(17, 2, 'Lead', 'App\\Lead'),
(18, 3, 'Client', 'App\\ClientDetails'),
(19, 3, 'Employee', 'App\\EmployeeDetails'),
(20, 3, 'Project', 'App\\Project'),
(21, 3, 'Invoice', 'App\\Invoice'),
(22, 3, 'Estimate', 'App\\Estimate'),
(23, 3, 'Task', 'App\\Task'),
(24, 3, 'Expense', 'App\\Expense'),
(25, 3, 'Lead', 'App\\Lead'),
(26, 4, 'Client', 'App\\ClientDetails'),
(27, 4, 'Employee', 'App\\EmployeeDetails'),
(28, 4, 'Project', 'App\\Project'),
(29, 4, 'Invoice', 'App\\Invoice'),
(30, 4, 'Estimate', 'App\\Estimate'),
(31, 4, 'Task', 'App\\Task'),
(32, 4, 'Expense', 'App\\Expense'),
(33, 4, 'Lead', 'App\\Lead'),
(34, 5, 'Client', 'App\\ClientDetails'),
(35, 5, 'Employee', 'App\\EmployeeDetails'),
(36, 5, 'Project', 'App\\Project'),
(37, 5, 'Invoice', 'App\\Invoice'),
(38, 5, 'Estimate', 'App\\Estimate'),
(39, 5, 'Task', 'App\\Task'),
(40, 5, 'Expense', 'App\\Expense'),
(41, 5, 'Lead', 'App\\Lead'),
(42, 6, 'Client', 'App\\ClientDetails'),
(43, 6, 'Employee', 'App\\EmployeeDetails'),
(44, 6, 'Project', 'App\\Project'),
(45, 6, 'Invoice', 'App\\Invoice'),
(46, 6, 'Estimate', 'App\\Estimate'),
(47, 6, 'Task', 'App\\Task'),
(48, 6, 'Expense', 'App\\Expense'),
(49, 6, 'Lead', 'App\\Lead');

-- --------------------------------------------------------

--
-- Table structure for table `dashboard_widgets`
--

CREATE TABLE `dashboard_widgets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `widget_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `dashboard_type` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dashboard_widgets`
--

INSERT INTO `dashboard_widgets` (`id`, `company_id`, `widget_name`, `status`, `created_at`, `updated_at`, `dashboard_type`) VALUES
(1, 1, 'total_clients', 1, '2021-11-10 18:30:34', '2021-11-10 18:30:34', 'admin-dashboard'),
(2, 1, 'total_employees', 1, '2021-11-10 18:30:34', '2021-11-10 18:30:34', 'admin-dashboard'),
(3, 1, 'total_projects', 1, '2021-11-10 18:30:34', '2021-11-10 18:30:34', 'admin-dashboard'),
(4, 1, 'total_unpaid_invoices', 1, '2021-11-10 18:30:35', '2021-11-10 18:30:35', 'admin-dashboard'),
(5, 1, 'total_hours_logged', 1, '2021-11-10 18:30:35', '2021-11-10 18:30:35', 'admin-dashboard'),
(6, 1, 'total_pending_tasks', 1, '2021-11-10 18:30:35', '2021-11-10 18:30:35', 'admin-dashboard'),
(7, 1, 'total_today_attendance', 1, '2021-11-10 18:30:35', '2021-11-10 18:30:35', 'admin-dashboard'),
(8, 1, 'total_unresolved_tickets', 1, '2021-11-10 18:30:36', '2021-11-10 18:30:36', 'admin-dashboard'),
(9, 1, 'total_resolved_tickets', 1, '2021-11-10 18:30:37', '2021-11-10 18:30:37', 'admin-dashboard'),
(10, 1, 'recent_earnings', 1, '2021-11-10 18:30:37', '2021-11-10 18:30:37', 'admin-dashboard'),
(11, 1, 'settings_leaves', 1, '2021-11-10 18:30:38', '2021-11-10 18:30:38', 'admin-dashboard'),
(12, 1, 'new_tickets', 1, '2021-11-10 18:30:38', '2021-11-10 18:30:38', 'admin-dashboard'),
(13, 1, 'overdue_tasks', 1, '2021-11-10 18:30:38', '2021-11-10 18:30:38', 'admin-dashboard'),
(14, 1, 'completed_tasks', 1, '2021-11-10 18:30:38', '2021-11-10 18:30:38', 'admin-dashboard'),
(15, 1, 'pending_follow_up', 1, '2021-11-10 18:30:38', '2021-11-10 18:30:38', 'admin-dashboard'),
(16, 1, 'project_activity_timeline', 1, '2021-11-10 18:30:38', '2021-11-10 18:30:38', 'admin-dashboard'),
(17, 1, 'user_activity_timeline', 1, '2021-11-10 18:30:39', '2021-11-10 18:30:39', 'admin-dashboard'),
(18, 1, 'total_clients', 1, '2021-11-10 18:30:39', '2021-11-10 18:30:39', 'admin-client-dashboard'),
(19, 1, 'total_leads', 1, '2021-11-10 18:30:39', '2021-11-10 18:30:39', 'admin-client-dashboard'),
(20, 1, 'total_lead_conversions', 1, '2021-11-10 18:30:39', '2021-11-10 18:30:39', 'admin-client-dashboard'),
(21, 1, 'total_contracts_generated', 1, '2021-11-10 18:30:40', '2021-11-10 18:30:40', 'admin-client-dashboard'),
(22, 1, 'total_contracts_signed', 1, '2021-11-10 18:30:40', '2021-11-10 18:30:40', 'admin-client-dashboard'),
(23, 1, 'client_wise_earnings', 1, '2021-11-10 18:30:40', '2021-11-10 18:30:40', 'admin-client-dashboard'),
(24, 1, 'client_wise_timelogs', 1, '2021-11-10 18:30:40', '2021-11-10 18:30:40', 'admin-client-dashboard'),
(25, 1, 'lead_vs_status', 1, '2021-11-10 18:30:41', '2021-11-10 18:30:41', 'admin-client-dashboard'),
(26, 1, 'lead_vs_source', 1, '2021-11-10 18:30:41', '2021-11-10 18:30:41', 'admin-client-dashboard'),
(27, 1, 'latest_client', 1, '2021-11-10 18:30:41', '2021-11-10 18:30:41', 'admin-client-dashboard'),
(28, 1, 'recent_login_activities', 1, '2021-11-10 18:30:41', '2021-11-10 18:30:41', 'admin-client-dashboard'),
(29, 1, 'total_paid_invoices', 1, '2021-11-10 18:30:41', '2021-11-10 18:30:41', 'admin-finance-dashboard'),
(30, 1, 'total_expenses', 1, '2021-11-10 18:30:41', '2021-11-10 18:30:41', 'admin-finance-dashboard'),
(31, 1, 'total_earnings', 1, '2021-11-10 18:30:41', '2021-11-10 18:30:41', 'admin-finance-dashboard'),
(32, 1, 'total_profit', 1, '2021-11-10 18:30:41', '2021-11-10 18:30:41', 'admin-finance-dashboard'),
(33, 1, 'total_pending_amount', 1, '2021-11-10 18:30:41', '2021-11-10 18:30:41', 'admin-finance-dashboard'),
(34, 1, 'invoice_overview', 1, '2021-11-10 18:30:42', '2021-11-10 18:30:42', 'admin-finance-dashboard'),
(35, 1, 'estimate_overview', 1, '2021-11-10 18:30:42', '2021-11-10 18:30:42', 'admin-finance-dashboard'),
(36, 1, 'proposal_overview', 1, '2021-11-10 18:30:42', '2021-11-10 18:30:42', 'admin-finance-dashboard'),
(37, 1, 'invoice_tab', 1, '2021-11-10 18:30:42', '2021-11-10 18:30:42', 'admin-finance-dashboard'),
(38, 1, 'estimate_tab', 1, '2021-11-10 18:30:42', '2021-11-10 18:30:42', 'admin-finance-dashboard'),
(39, 1, 'expense_tab', 1, '2021-11-10 18:30:42', '2021-11-10 18:30:42', 'admin-finance-dashboard'),
(40, 1, 'payment_tab', 1, '2021-11-10 18:30:42', '2021-11-10 18:30:42', 'admin-finance-dashboard'),
(41, 1, 'due_payments_tab', 1, '2021-11-10 18:30:42', '2021-11-10 18:30:42', 'admin-finance-dashboard'),
(42, 1, 'proposal_tab', 1, '2021-11-10 18:30:42', '2021-11-10 18:30:42', 'admin-finance-dashboard'),
(43, 1, 'earnings_by_client', 1, '2021-11-10 18:30:42', '2021-11-10 18:30:42', 'admin-finance-dashboard'),
(44, 1, 'earnings_by_projects', 1, '2021-11-10 18:30:43', '2021-11-10 18:30:43', 'admin-finance-dashboard'),
(45, 1, 'total_leaves_approved', 1, '2021-11-10 18:30:43', '2021-11-10 18:30:43', 'admin-hr-dashboard'),
(46, 1, 'total_new_employee', 1, '2021-11-10 18:30:43', '2021-11-10 18:30:43', 'admin-hr-dashboard'),
(47, 1, 'total_employee_exits', 1, '2021-11-10 18:30:43', '2021-11-10 18:30:43', 'admin-hr-dashboard'),
(48, 1, 'average_attendance', 1, '2021-11-10 18:30:43', '2021-11-10 18:30:43', 'admin-hr-dashboard'),
(49, 1, 'department_wise_employee', 1, '2021-11-10 18:30:43', '2021-11-10 18:30:43', 'admin-hr-dashboard'),
(50, 1, 'designation_wise_employee', 1, '2021-11-10 18:30:44', '2021-11-10 18:30:44', 'admin-hr-dashboard'),
(51, 1, 'gender_wise_employee', 1, '2021-11-10 18:30:44', '2021-11-10 18:30:44', 'admin-hr-dashboard'),
(52, 1, 'role_wise_employee', 1, '2021-11-10 18:30:44', '2021-11-10 18:30:44', 'admin-hr-dashboard'),
(53, 1, 'leaves_taken', 1, '2021-11-10 18:30:44', '2021-11-10 18:30:44', 'admin-hr-dashboard'),
(54, 1, 'late_attendance_mark', 1, '2021-11-10 18:30:44', '2021-11-10 18:30:44', 'admin-hr-dashboard'),
(55, 1, 'total_project', 1, '2021-11-10 18:30:44', '2021-11-10 18:30:44', 'admin-project-dashboard'),
(56, 1, 'total_hours_logged', 1, '2021-11-10 18:30:44', '2021-11-10 18:30:44', 'admin-project-dashboard'),
(57, 1, 'total_overdue_project', 1, '2021-11-10 18:30:44', '2021-11-10 18:30:44', 'admin-project-dashboard'),
(58, 1, 'status_wise_project', 1, '2021-11-10 18:30:45', '2021-11-10 18:30:45', 'admin-project-dashboard'),
(59, 1, 'pending_milestone', 1, '2021-11-10 18:30:45', '2021-11-10 18:30:45', 'admin-project-dashboard'),
(60, 1, 'total_unresolved_tickets', 1, '2021-11-10 18:30:45', '2021-11-10 18:30:45', 'admin-ticket-dashboard'),
(61, 1, 'total_unassigned_ticket', 1, '2021-11-10 18:30:45', '2021-11-10 18:30:45', 'admin-ticket-dashboard'),
(62, 1, 'type_wise_ticket', 1, '2021-11-10 18:30:45', '2021-11-10 18:30:45', 'admin-ticket-dashboard'),
(63, 1, 'status_wise_ticket', 1, '2021-11-10 18:30:45', '2021-11-10 18:30:45', 'admin-ticket-dashboard'),
(64, 1, 'channel_wise_ticket', 1, '2021-11-10 18:30:46', '2021-11-10 18:30:46', 'admin-ticket-dashboard'),
(65, 1, 'new_tickets', 1, '2021-11-10 18:30:46', '2021-11-10 18:30:46', 'admin-ticket-dashboard'),
(66, 2, 'total_clients', 1, '2021-11-10 18:31:23', '2021-11-10 18:31:23', 'admin-dashboard'),
(67, 2, 'total_employees', 1, '2021-11-10 18:31:24', '2021-11-10 18:31:24', 'admin-dashboard'),
(68, 2, 'total_projects', 1, '2021-11-10 18:31:24', '2021-11-10 18:31:24', 'admin-dashboard'),
(69, 2, 'total_unpaid_invoices', 1, '2021-11-10 18:31:24', '2021-11-10 18:31:24', 'admin-dashboard'),
(70, 2, 'total_hours_logged', 1, '2021-11-10 18:31:24', '2021-11-10 18:31:24', 'admin-dashboard'),
(71, 2, 'total_pending_tasks', 1, '2021-11-10 18:31:25', '2021-11-10 18:31:25', 'admin-dashboard'),
(72, 2, 'total_today_attendance', 1, '2021-11-10 18:31:25', '2021-11-10 18:31:25', 'admin-dashboard'),
(73, 2, 'total_unresolved_tickets', 1, '2021-11-10 18:31:25', '2021-11-10 18:31:25', 'admin-dashboard'),
(74, 2, 'total_resolved_tickets', 1, '2021-11-10 18:31:25', '2021-11-10 18:31:25', 'admin-dashboard'),
(75, 2, 'recent_earnings', 1, '2021-11-10 18:31:25', '2021-11-10 18:31:25', 'admin-dashboard'),
(76, 2, 'settings_leaves', 1, '2021-11-10 18:31:26', '2021-11-10 18:31:26', 'admin-dashboard'),
(77, 2, 'new_tickets', 1, '2021-11-10 18:31:26', '2021-11-10 18:31:26', 'admin-dashboard'),
(78, 2, 'overdue_tasks', 1, '2021-11-10 18:31:26', '2021-11-10 18:31:26', 'admin-dashboard'),
(79, 2, 'completed_tasks', 1, '2021-11-10 18:31:27', '2021-11-10 18:31:27', 'admin-dashboard'),
(80, 2, 'pending_follow_up', 1, '2021-11-10 18:31:28', '2021-11-10 18:31:28', 'admin-dashboard'),
(81, 2, 'project_activity_timeline', 1, '2021-11-10 18:31:29', '2021-11-10 18:31:29', 'admin-dashboard'),
(82, 2, 'user_activity_timeline', 1, '2021-11-10 18:31:29', '2021-11-10 18:31:29', 'admin-dashboard'),
(83, 2, 'total_clients', 1, '2021-11-10 18:31:29', '2021-11-10 18:31:29', 'admin-client-dashboard'),
(84, 2, 'total_leads', 1, '2021-11-10 18:31:30', '2021-11-10 18:31:30', 'admin-client-dashboard'),
(85, 2, 'total_lead_conversions', 1, '2021-11-10 18:31:30', '2021-11-10 18:31:30', 'admin-client-dashboard'),
(86, 2, 'total_contracts_generated', 1, '2021-11-10 18:31:30', '2021-11-10 18:31:30', 'admin-client-dashboard'),
(87, 2, 'total_contracts_signed', 1, '2021-11-10 18:31:31', '2021-11-10 18:31:31', 'admin-client-dashboard'),
(88, 2, 'client_wise_earnings', 1, '2021-11-10 18:31:31', '2021-11-10 18:31:31', 'admin-client-dashboard'),
(89, 2, 'client_wise_timelogs', 1, '2021-11-10 18:31:31', '2021-11-10 18:31:31', 'admin-client-dashboard'),
(90, 2, 'lead_vs_status', 1, '2021-11-10 18:31:31', '2021-11-10 18:31:31', 'admin-client-dashboard'),
(91, 2, 'lead_vs_source', 1, '2021-11-10 18:31:31', '2021-11-10 18:31:31', 'admin-client-dashboard'),
(92, 2, 'latest_client', 1, '2021-11-10 18:31:32', '2021-11-10 18:31:32', 'admin-client-dashboard'),
(93, 2, 'recent_login_activities', 1, '2021-11-10 18:31:32', '2021-11-10 18:31:32', 'admin-client-dashboard'),
(94, 2, 'total_paid_invoices', 1, '2021-11-10 18:31:32', '2021-11-10 18:31:32', 'admin-finance-dashboard'),
(95, 2, 'total_expenses', 1, '2021-11-10 18:31:32', '2021-11-10 18:31:32', 'admin-finance-dashboard'),
(96, 2, 'total_earnings', 1, '2021-11-10 18:31:33', '2021-11-10 18:31:33', 'admin-finance-dashboard'),
(97, 2, 'total_profit', 1, '2021-11-10 18:31:33', '2021-11-10 18:31:33', 'admin-finance-dashboard'),
(98, 2, 'total_pending_amount', 1, '2021-11-10 18:31:33', '2021-11-10 18:31:33', 'admin-finance-dashboard'),
(99, 2, 'invoice_overview', 1, '2021-11-10 18:31:33', '2021-11-10 18:31:33', 'admin-finance-dashboard'),
(100, 2, 'estimate_overview', 1, '2021-11-10 18:31:33', '2021-11-10 18:31:33', 'admin-finance-dashboard'),
(101, 2, 'proposal_overview', 1, '2021-11-10 18:31:33', '2021-11-10 18:31:33', 'admin-finance-dashboard'),
(102, 2, 'invoice_tab', 1, '2021-11-10 18:31:34', '2021-11-10 18:31:34', 'admin-finance-dashboard'),
(103, 2, 'estimate_tab', 1, '2021-11-10 18:31:34', '2021-11-10 18:31:34', 'admin-finance-dashboard'),
(104, 2, 'expense_tab', 1, '2021-11-10 18:31:35', '2021-11-10 18:31:35', 'admin-finance-dashboard'),
(105, 2, 'payment_tab', 1, '2021-11-10 18:31:35', '2021-11-10 18:31:35', 'admin-finance-dashboard'),
(106, 2, 'due_payments_tab', 1, '2021-11-10 18:31:35', '2021-11-10 18:31:35', 'admin-finance-dashboard'),
(107, 2, 'proposal_tab', 1, '2021-11-10 18:31:35', '2021-11-10 18:31:35', 'admin-finance-dashboard'),
(108, 2, 'earnings_by_client', 1, '2021-11-10 18:31:35', '2021-11-10 18:31:35', 'admin-finance-dashboard'),
(109, 2, 'earnings_by_projects', 1, '2021-11-10 18:31:36', '2021-11-10 18:31:36', 'admin-finance-dashboard'),
(110, 2, 'total_leaves_approved', 1, '2021-11-10 18:31:36', '2021-11-10 18:31:36', 'admin-hr-dashboard'),
(111, 2, 'total_new_employee', 1, '2021-11-10 18:31:36', '2021-11-10 18:31:36', 'admin-hr-dashboard'),
(112, 2, 'total_employee_exits', 1, '2021-11-10 18:31:36', '2021-11-10 18:31:36', 'admin-hr-dashboard'),
(113, 2, 'average_attendance', 1, '2021-11-10 18:31:37', '2021-11-10 18:31:37', 'admin-hr-dashboard'),
(114, 2, 'department_wise_employee', 1, '2021-11-10 18:31:37', '2021-11-10 18:31:37', 'admin-hr-dashboard'),
(115, 2, 'designation_wise_employee', 1, '2021-11-10 18:31:37', '2021-11-10 18:31:37', 'admin-hr-dashboard'),
(116, 2, 'gender_wise_employee', 1, '2021-11-10 18:31:37', '2021-11-10 18:31:37', 'admin-hr-dashboard'),
(117, 2, 'role_wise_employee', 1, '2021-11-10 18:31:37', '2021-11-10 18:31:37', 'admin-hr-dashboard'),
(118, 2, 'leaves_taken', 1, '2021-11-10 18:31:37', '2021-11-10 18:31:37', 'admin-hr-dashboard'),
(119, 2, 'late_attendance_mark', 1, '2021-11-10 18:31:37', '2021-11-10 18:31:37', 'admin-hr-dashboard'),
(120, 2, 'total_project', 1, '2021-11-10 18:31:38', '2021-11-10 18:31:38', 'admin-project-dashboard'),
(121, 2, 'total_hours_logged', 1, '2021-11-10 18:31:38', '2021-11-10 18:31:38', 'admin-project-dashboard'),
(122, 2, 'total_overdue_project', 1, '2021-11-10 18:31:38', '2021-11-10 18:31:38', 'admin-project-dashboard'),
(123, 2, 'status_wise_project', 1, '2021-11-10 18:31:38', '2021-11-10 18:31:38', 'admin-project-dashboard'),
(124, 2, 'pending_milestone', 1, '2021-11-10 18:31:38', '2021-11-10 18:31:38', 'admin-project-dashboard'),
(125, 2, 'total_unresolved_tickets', 1, '2021-11-10 18:31:38', '2021-11-10 18:31:38', 'admin-ticket-dashboard'),
(126, 2, 'total_unassigned_ticket', 1, '2021-11-10 18:31:38', '2021-11-10 18:31:38', 'admin-ticket-dashboard'),
(127, 2, 'type_wise_ticket', 1, '2021-11-10 18:31:39', '2021-11-10 18:31:39', 'admin-ticket-dashboard'),
(128, 2, 'status_wise_ticket', 1, '2021-11-10 18:31:39', '2021-11-10 18:31:39', 'admin-ticket-dashboard'),
(129, 2, 'channel_wise_ticket', 1, '2021-11-10 18:31:39', '2021-11-10 18:31:39', 'admin-ticket-dashboard'),
(130, 2, 'new_tickets', 1, '2021-11-10 18:31:39', '2021-11-10 18:31:39', 'admin-ticket-dashboard'),
(131, 3, 'total_clients', 1, '2021-11-10 18:32:07', '2021-11-10 18:32:07', 'admin-dashboard'),
(132, 3, 'total_employees', 1, '2021-11-10 18:32:07', '2021-11-10 18:32:07', 'admin-dashboard'),
(133, 3, 'total_projects', 1, '2021-11-10 18:32:07', '2021-11-10 18:32:07', 'admin-dashboard'),
(134, 3, 'total_unpaid_invoices', 1, '2021-11-10 18:32:07', '2021-11-10 18:32:07', 'admin-dashboard'),
(135, 3, 'total_hours_logged', 1, '2021-11-10 18:32:07', '2021-11-10 18:32:07', 'admin-dashboard'),
(136, 3, 'total_pending_tasks', 1, '2021-11-10 18:32:08', '2021-11-10 18:32:08', 'admin-dashboard'),
(137, 3, 'total_today_attendance', 1, '2021-11-10 18:32:08', '2021-11-10 18:32:08', 'admin-dashboard'),
(138, 3, 'total_unresolved_tickets', 1, '2021-11-10 18:32:08', '2021-11-10 18:32:08', 'admin-dashboard'),
(139, 3, 'total_resolved_tickets', 1, '2021-11-10 18:32:08', '2021-11-10 18:32:08', 'admin-dashboard'),
(140, 3, 'recent_earnings', 1, '2021-11-10 18:32:08', '2021-11-10 18:32:08', 'admin-dashboard'),
(141, 3, 'settings_leaves', 1, '2021-11-10 18:32:08', '2021-11-10 18:32:08', 'admin-dashboard'),
(142, 3, 'new_tickets', 1, '2021-11-10 18:32:08', '2021-11-10 18:32:08', 'admin-dashboard'),
(143, 3, 'overdue_tasks', 1, '2021-11-10 18:32:08', '2021-11-10 18:32:08', 'admin-dashboard'),
(144, 3, 'completed_tasks', 1, '2021-11-10 18:32:08', '2021-11-10 18:32:08', 'admin-dashboard'),
(145, 3, 'pending_follow_up', 1, '2021-11-10 18:32:08', '2021-11-10 18:32:08', 'admin-dashboard'),
(146, 3, 'project_activity_timeline', 1, '2021-11-10 18:32:09', '2021-11-10 18:32:09', 'admin-dashboard'),
(147, 3, 'user_activity_timeline', 1, '2021-11-10 18:32:09', '2021-11-10 18:32:09', 'admin-dashboard'),
(148, 3, 'total_clients', 1, '2021-11-10 18:32:09', '2021-11-10 18:32:09', 'admin-client-dashboard'),
(149, 3, 'total_leads', 1, '2021-11-10 18:32:09', '2021-11-10 18:32:09', 'admin-client-dashboard'),
(150, 3, 'total_lead_conversions', 1, '2021-11-10 18:32:09', '2021-11-10 18:32:09', 'admin-client-dashboard'),
(151, 3, 'total_contracts_generated', 1, '2021-11-10 18:32:09', '2021-11-10 18:32:09', 'admin-client-dashboard'),
(152, 3, 'total_contracts_signed', 1, '2021-11-10 18:32:09', '2021-11-10 18:32:09', 'admin-client-dashboard'),
(153, 3, 'client_wise_earnings', 1, '2021-11-10 18:32:10', '2021-11-10 18:32:10', 'admin-client-dashboard'),
(154, 3, 'client_wise_timelogs', 1, '2021-11-10 18:32:10', '2021-11-10 18:32:10', 'admin-client-dashboard'),
(155, 3, 'lead_vs_status', 1, '2021-11-10 18:32:10', '2021-11-10 18:32:10', 'admin-client-dashboard'),
(156, 3, 'lead_vs_source', 1, '2021-11-10 18:32:10', '2021-11-10 18:32:10', 'admin-client-dashboard'),
(157, 3, 'latest_client', 1, '2021-11-10 18:32:10', '2021-11-10 18:32:10', 'admin-client-dashboard'),
(158, 3, 'recent_login_activities', 1, '2021-11-10 18:32:11', '2021-11-10 18:32:11', 'admin-client-dashboard'),
(159, 3, 'total_paid_invoices', 1, '2021-11-10 18:32:11', '2021-11-10 18:32:11', 'admin-finance-dashboard'),
(160, 3, 'total_expenses', 1, '2021-11-10 18:32:11', '2021-11-10 18:32:11', 'admin-finance-dashboard'),
(161, 3, 'total_earnings', 1, '2021-11-10 18:32:11', '2021-11-10 18:32:11', 'admin-finance-dashboard'),
(162, 3, 'total_profit', 1, '2021-11-10 18:32:11', '2021-11-10 18:32:11', 'admin-finance-dashboard'),
(163, 3, 'total_pending_amount', 1, '2021-11-10 18:32:11', '2021-11-10 18:32:11', 'admin-finance-dashboard'),
(164, 3, 'invoice_overview', 1, '2021-11-10 18:32:11', '2021-11-10 18:32:11', 'admin-finance-dashboard'),
(165, 3, 'estimate_overview', 1, '2021-11-10 18:32:11', '2021-11-10 18:32:11', 'admin-finance-dashboard'),
(166, 3, 'proposal_overview', 1, '2021-11-10 18:32:11', '2021-11-10 18:32:11', 'admin-finance-dashboard'),
(167, 3, 'invoice_tab', 1, '2021-11-10 18:32:12', '2021-11-10 18:32:12', 'admin-finance-dashboard'),
(168, 3, 'estimate_tab', 1, '2021-11-10 18:32:12', '2021-11-10 18:32:12', 'admin-finance-dashboard'),
(169, 3, 'expense_tab', 1, '2021-11-10 18:32:12', '2021-11-10 18:32:12', 'admin-finance-dashboard'),
(170, 3, 'payment_tab', 1, '2021-11-10 18:32:12', '2021-11-10 18:32:12', 'admin-finance-dashboard'),
(171, 3, 'due_payments_tab', 1, '2021-11-10 18:32:12', '2021-11-10 18:32:12', 'admin-finance-dashboard'),
(172, 3, 'proposal_tab', 1, '2021-11-10 18:32:12', '2021-11-10 18:32:12', 'admin-finance-dashboard'),
(173, 3, 'earnings_by_client', 1, '2021-11-10 18:32:12', '2021-11-10 18:32:12', 'admin-finance-dashboard'),
(174, 3, 'earnings_by_projects', 1, '2021-11-10 18:32:13', '2021-11-10 18:32:13', 'admin-finance-dashboard'),
(175, 3, 'total_leaves_approved', 1, '2021-11-10 18:32:13', '2021-11-10 18:32:13', 'admin-hr-dashboard'),
(176, 3, 'total_new_employee', 1, '2021-11-10 18:32:13', '2021-11-10 18:32:13', 'admin-hr-dashboard'),
(177, 3, 'total_employee_exits', 1, '2021-11-10 18:32:13', '2021-11-10 18:32:13', 'admin-hr-dashboard'),
(178, 3, 'average_attendance', 1, '2021-11-10 18:32:13', '2021-11-10 18:32:13', 'admin-hr-dashboard'),
(179, 3, 'department_wise_employee', 1, '2021-11-10 18:32:14', '2021-11-10 18:32:14', 'admin-hr-dashboard'),
(180, 3, 'designation_wise_employee', 1, '2021-11-10 18:32:14', '2021-11-10 18:32:14', 'admin-hr-dashboard'),
(181, 3, 'gender_wise_employee', 1, '2021-11-10 18:32:14', '2021-11-10 18:32:14', 'admin-hr-dashboard'),
(182, 3, 'role_wise_employee', 1, '2021-11-10 18:32:14', '2021-11-10 18:32:14', 'admin-hr-dashboard'),
(183, 3, 'leaves_taken', 1, '2021-11-10 18:32:14', '2021-11-10 18:32:14', 'admin-hr-dashboard'),
(184, 3, 'late_attendance_mark', 1, '2021-11-10 18:32:14', '2021-11-10 18:32:14', 'admin-hr-dashboard'),
(185, 3, 'total_project', 1, '2021-11-10 18:32:15', '2021-11-10 18:32:15', 'admin-project-dashboard'),
(186, 3, 'total_hours_logged', 1, '2021-11-10 18:32:15', '2021-11-10 18:32:15', 'admin-project-dashboard'),
(187, 3, 'total_overdue_project', 1, '2021-11-10 18:32:15', '2021-11-10 18:32:15', 'admin-project-dashboard'),
(188, 3, 'status_wise_project', 1, '2021-11-10 18:32:16', '2021-11-10 18:32:16', 'admin-project-dashboard'),
(189, 3, 'pending_milestone', 1, '2021-11-10 18:32:16', '2021-11-10 18:32:16', 'admin-project-dashboard'),
(190, 3, 'total_unresolved_tickets', 1, '2021-11-10 18:32:16', '2021-11-10 18:32:16', 'admin-ticket-dashboard'),
(191, 3, 'total_unassigned_ticket', 1, '2021-11-10 18:32:16', '2021-11-10 18:32:16', 'admin-ticket-dashboard'),
(192, 3, 'type_wise_ticket', 1, '2021-11-10 18:32:16', '2021-11-10 18:32:16', 'admin-ticket-dashboard'),
(193, 3, 'status_wise_ticket', 1, '2021-11-10 18:32:16', '2021-11-10 18:32:16', 'admin-ticket-dashboard'),
(194, 3, 'channel_wise_ticket', 1, '2021-11-10 18:32:16', '2021-11-10 18:32:16', 'admin-ticket-dashboard'),
(195, 3, 'new_tickets', 1, '2021-11-10 18:32:17', '2021-11-10 18:32:17', 'admin-ticket-dashboard'),
(196, 4, 'total_clients', 1, '2021-11-10 18:32:50', '2021-11-10 18:32:50', 'admin-dashboard'),
(197, 4, 'total_employees', 1, '2021-11-10 18:32:50', '2021-11-10 18:32:50', 'admin-dashboard'),
(198, 4, 'total_projects', 1, '2021-11-10 18:32:50', '2021-11-10 18:32:50', 'admin-dashboard'),
(199, 4, 'total_unpaid_invoices', 1, '2021-11-10 18:32:50', '2021-11-10 18:32:50', 'admin-dashboard'),
(200, 4, 'total_hours_logged', 1, '2021-11-10 18:32:51', '2021-11-10 18:32:51', 'admin-dashboard'),
(201, 4, 'total_pending_tasks', 1, '2021-11-10 18:32:51', '2021-11-10 18:32:51', 'admin-dashboard'),
(202, 4, 'total_today_attendance', 1, '2021-11-10 18:32:51', '2021-11-10 18:32:51', 'admin-dashboard'),
(203, 4, 'total_unresolved_tickets', 1, '2021-11-10 18:32:51', '2021-11-10 18:32:51', 'admin-dashboard'),
(204, 4, 'total_resolved_tickets', 1, '2021-11-10 18:32:51', '2021-11-10 18:32:51', 'admin-dashboard'),
(205, 4, 'recent_earnings', 1, '2021-11-10 18:32:51', '2021-11-10 18:32:51', 'admin-dashboard'),
(206, 4, 'settings_leaves', 1, '2021-11-10 18:32:51', '2021-11-10 18:32:51', 'admin-dashboard'),
(207, 4, 'new_tickets', 1, '2021-11-10 18:32:51', '2021-11-10 18:32:51', 'admin-dashboard'),
(208, 4, 'overdue_tasks', 1, '2021-11-10 18:32:51', '2021-11-10 18:32:51', 'admin-dashboard'),
(209, 4, 'completed_tasks', 1, '2021-11-10 18:32:52', '2021-11-10 18:32:52', 'admin-dashboard'),
(210, 4, 'pending_follow_up', 1, '2021-11-10 18:32:52', '2021-11-10 18:32:52', 'admin-dashboard'),
(211, 4, 'project_activity_timeline', 1, '2021-11-10 18:32:52', '2021-11-10 18:32:52', 'admin-dashboard'),
(212, 4, 'user_activity_timeline', 1, '2021-11-10 18:32:52', '2021-11-10 18:32:52', 'admin-dashboard'),
(213, 4, 'total_clients', 1, '2021-11-10 18:32:52', '2021-11-10 18:32:52', 'admin-client-dashboard'),
(214, 4, 'total_leads', 1, '2021-11-10 18:32:52', '2021-11-10 18:32:52', 'admin-client-dashboard'),
(215, 4, 'total_lead_conversions', 1, '2021-11-10 18:32:52', '2021-11-10 18:32:52', 'admin-client-dashboard'),
(216, 4, 'total_contracts_generated', 1, '2021-11-10 18:32:52', '2021-11-10 18:32:52', 'admin-client-dashboard'),
(217, 4, 'total_contracts_signed', 1, '2021-11-10 18:32:52', '2021-11-10 18:32:52', 'admin-client-dashboard'),
(218, 4, 'client_wise_earnings', 1, '2021-11-10 18:32:52', '2021-11-10 18:32:52', 'admin-client-dashboard'),
(219, 4, 'client_wise_timelogs', 1, '2021-11-10 18:32:53', '2021-11-10 18:32:53', 'admin-client-dashboard'),
(220, 4, 'lead_vs_status', 1, '2021-11-10 18:32:53', '2021-11-10 18:32:53', 'admin-client-dashboard'),
(221, 4, 'lead_vs_source', 1, '2021-11-10 18:32:53', '2021-11-10 18:32:53', 'admin-client-dashboard'),
(222, 4, 'latest_client', 1, '2021-11-10 18:32:53', '2021-11-10 18:32:53', 'admin-client-dashboard'),
(223, 4, 'recent_login_activities', 1, '2021-11-10 18:32:53', '2021-11-10 18:32:53', 'admin-client-dashboard'),
(224, 4, 'total_paid_invoices', 1, '2021-11-10 18:32:53', '2021-11-10 18:32:53', 'admin-finance-dashboard'),
(225, 4, 'total_expenses', 1, '2021-11-10 18:32:54', '2021-11-10 18:32:54', 'admin-finance-dashboard'),
(226, 4, 'total_earnings', 1, '2021-11-10 18:32:54', '2021-11-10 18:32:54', 'admin-finance-dashboard'),
(227, 4, 'total_profit', 1, '2021-11-10 18:32:54', '2021-11-10 18:32:54', 'admin-finance-dashboard'),
(228, 4, 'total_pending_amount', 1, '2021-11-10 18:32:54', '2021-11-10 18:32:54', 'admin-finance-dashboard'),
(229, 4, 'invoice_overview', 1, '2021-11-10 18:32:54', '2021-11-10 18:32:54', 'admin-finance-dashboard'),
(230, 4, 'estimate_overview', 1, '2021-11-10 18:32:54', '2021-11-10 18:32:54', 'admin-finance-dashboard'),
(231, 4, 'proposal_overview', 1, '2021-11-10 18:32:54', '2021-11-10 18:32:54', 'admin-finance-dashboard'),
(232, 4, 'invoice_tab', 1, '2021-11-10 18:32:55', '2021-11-10 18:32:55', 'admin-finance-dashboard'),
(233, 4, 'estimate_tab', 1, '2021-11-10 18:32:55', '2021-11-10 18:32:55', 'admin-finance-dashboard'),
(234, 4, 'expense_tab', 1, '2021-11-10 18:32:55', '2021-11-10 18:32:55', 'admin-finance-dashboard'),
(235, 4, 'payment_tab', 1, '2021-11-10 18:32:55', '2021-11-10 18:32:55', 'admin-finance-dashboard'),
(236, 4, 'due_payments_tab', 1, '2021-11-10 18:32:55', '2021-11-10 18:32:55', 'admin-finance-dashboard'),
(237, 4, 'proposal_tab', 1, '2021-11-10 18:32:55', '2021-11-10 18:32:55', 'admin-finance-dashboard'),
(238, 4, 'earnings_by_client', 1, '2021-11-10 18:32:55', '2021-11-10 18:32:55', 'admin-finance-dashboard'),
(239, 4, 'earnings_by_projects', 1, '2021-11-10 18:32:56', '2021-11-10 18:32:56', 'admin-finance-dashboard'),
(240, 4, 'total_leaves_approved', 1, '2021-11-10 18:32:56', '2021-11-10 18:32:56', 'admin-hr-dashboard'),
(241, 4, 'total_new_employee', 1, '2021-11-10 18:32:57', '2021-11-10 18:32:57', 'admin-hr-dashboard'),
(242, 4, 'total_employee_exits', 1, '2021-11-10 18:32:57', '2021-11-10 18:32:57', 'admin-hr-dashboard'),
(243, 4, 'average_attendance', 1, '2021-11-10 18:32:57', '2021-11-10 18:32:57', 'admin-hr-dashboard'),
(244, 4, 'department_wise_employee', 1, '2021-11-10 18:32:57', '2021-11-10 18:32:57', 'admin-hr-dashboard'),
(245, 4, 'designation_wise_employee', 1, '2021-11-10 18:32:57', '2021-11-10 18:32:57', 'admin-hr-dashboard'),
(246, 4, 'gender_wise_employee', 1, '2021-11-10 18:32:58', '2021-11-10 18:32:58', 'admin-hr-dashboard'),
(247, 4, 'role_wise_employee', 1, '2021-11-10 18:32:58', '2021-11-10 18:32:58', 'admin-hr-dashboard'),
(248, 4, 'leaves_taken', 1, '2021-11-10 18:32:58', '2021-11-10 18:32:58', 'admin-hr-dashboard'),
(249, 4, 'late_attendance_mark', 1, '2021-11-10 18:32:58', '2021-11-10 18:32:58', 'admin-hr-dashboard'),
(250, 4, 'total_project', 1, '2021-11-10 18:32:58', '2021-11-10 18:32:58', 'admin-project-dashboard'),
(251, 4, 'total_hours_logged', 1, '2021-11-10 18:32:58', '2021-11-10 18:32:58', 'admin-project-dashboard'),
(252, 4, 'total_overdue_project', 1, '2021-11-10 18:32:58', '2021-11-10 18:32:58', 'admin-project-dashboard'),
(253, 4, 'status_wise_project', 1, '2021-11-10 18:32:58', '2021-11-10 18:32:58', 'admin-project-dashboard'),
(254, 4, 'pending_milestone', 1, '2021-11-10 18:32:58', '2021-11-10 18:32:58', 'admin-project-dashboard'),
(255, 4, 'total_unresolved_tickets', 1, '2021-11-10 18:32:58', '2021-11-10 18:32:58', 'admin-ticket-dashboard'),
(256, 4, 'total_unassigned_ticket', 1, '2021-11-10 18:32:58', '2021-11-10 18:32:58', 'admin-ticket-dashboard'),
(257, 4, 'type_wise_ticket', 1, '2021-11-10 18:32:59', '2021-11-10 18:32:59', 'admin-ticket-dashboard'),
(258, 4, 'status_wise_ticket', 1, '2021-11-10 18:32:59', '2021-11-10 18:32:59', 'admin-ticket-dashboard'),
(259, 4, 'channel_wise_ticket', 1, '2021-11-10 18:32:59', '2021-11-10 18:32:59', 'admin-ticket-dashboard'),
(260, 4, 'new_tickets', 1, '2021-11-10 18:32:59', '2021-11-10 18:32:59', 'admin-ticket-dashboard'),
(261, 5, 'total_clients', 1, '2021-11-10 18:33:27', '2021-11-10 18:33:27', 'admin-dashboard'),
(262, 5, 'total_employees', 1, '2021-11-10 18:33:27', '2021-11-10 18:33:27', 'admin-dashboard'),
(263, 5, 'total_projects', 1, '2021-11-10 18:33:27', '2021-11-10 18:33:27', 'admin-dashboard'),
(264, 5, 'total_unpaid_invoices', 1, '2021-11-10 18:33:27', '2021-11-10 18:33:27', 'admin-dashboard'),
(265, 5, 'total_hours_logged', 1, '2021-11-10 18:33:28', '2021-11-10 18:33:28', 'admin-dashboard'),
(266, 5, 'total_pending_tasks', 1, '2021-11-10 18:33:28', '2021-11-10 18:33:28', 'admin-dashboard'),
(267, 5, 'total_today_attendance', 1, '2021-11-10 18:33:28', '2021-11-10 18:33:28', 'admin-dashboard'),
(268, 5, 'total_unresolved_tickets', 1, '2021-11-10 18:33:28', '2021-11-10 18:33:28', 'admin-dashboard'),
(269, 5, 'total_resolved_tickets', 1, '2021-11-10 18:33:28', '2021-11-10 18:33:28', 'admin-dashboard'),
(270, 5, 'recent_earnings', 1, '2021-11-10 18:33:28', '2021-11-10 18:33:28', 'admin-dashboard'),
(271, 5, 'settings_leaves', 1, '2021-11-10 18:33:28', '2021-11-10 18:33:28', 'admin-dashboard'),
(272, 5, 'new_tickets', 1, '2021-11-10 18:33:28', '2021-11-10 18:33:28', 'admin-dashboard'),
(273, 5, 'overdue_tasks', 1, '2021-11-10 18:33:28', '2021-11-10 18:33:28', 'admin-dashboard'),
(274, 5, 'completed_tasks', 1, '2021-11-10 18:33:28', '2021-11-10 18:33:28', 'admin-dashboard'),
(275, 5, 'pending_follow_up', 1, '2021-11-10 18:33:28', '2021-11-10 18:33:28', 'admin-dashboard'),
(276, 5, 'project_activity_timeline', 1, '2021-11-10 18:33:28', '2021-11-10 18:33:28', 'admin-dashboard'),
(277, 5, 'user_activity_timeline', 1, '2021-11-10 18:33:29', '2021-11-10 18:33:29', 'admin-dashboard'),
(278, 5, 'total_clients', 1, '2021-11-10 18:33:29', '2021-11-10 18:33:29', 'admin-client-dashboard'),
(279, 5, 'total_leads', 1, '2021-11-10 18:33:29', '2021-11-10 18:33:29', 'admin-client-dashboard'),
(280, 5, 'total_lead_conversions', 1, '2021-11-10 18:33:29', '2021-11-10 18:33:29', 'admin-client-dashboard'),
(281, 5, 'total_contracts_generated', 1, '2021-11-10 18:33:29', '2021-11-10 18:33:29', 'admin-client-dashboard'),
(282, 5, 'total_contracts_signed', 1, '2021-11-10 18:33:29', '2021-11-10 18:33:29', 'admin-client-dashboard'),
(283, 5, 'client_wise_earnings', 1, '2021-11-10 18:33:29', '2021-11-10 18:33:29', 'admin-client-dashboard'),
(284, 5, 'client_wise_timelogs', 1, '2021-11-10 18:33:29', '2021-11-10 18:33:29', 'admin-client-dashboard'),
(285, 5, 'lead_vs_status', 1, '2021-11-10 18:33:29', '2021-11-10 18:33:29', 'admin-client-dashboard'),
(286, 5, 'lead_vs_source', 1, '2021-11-10 18:33:29', '2021-11-10 18:33:29', 'admin-client-dashboard'),
(287, 5, 'latest_client', 1, '2021-11-10 18:33:30', '2021-11-10 18:33:30', 'admin-client-dashboard'),
(288, 5, 'recent_login_activities', 1, '2021-11-10 18:33:30', '2021-11-10 18:33:30', 'admin-client-dashboard'),
(289, 5, 'total_paid_invoices', 1, '2021-11-10 18:33:30', '2021-11-10 18:33:30', 'admin-finance-dashboard'),
(290, 5, 'total_expenses', 1, '2021-11-10 18:33:31', '2021-11-10 18:33:31', 'admin-finance-dashboard'),
(291, 5, 'total_earnings', 1, '2021-11-10 18:33:31', '2021-11-10 18:33:31', 'admin-finance-dashboard'),
(292, 5, 'total_profit', 1, '2021-11-10 18:33:31', '2021-11-10 18:33:31', 'admin-finance-dashboard'),
(293, 5, 'total_pending_amount', 1, '2021-11-10 18:33:31', '2021-11-10 18:33:31', 'admin-finance-dashboard'),
(294, 5, 'invoice_overview', 1, '2021-11-10 18:33:32', '2021-11-10 18:33:32', 'admin-finance-dashboard'),
(295, 5, 'estimate_overview', 1, '2021-11-10 18:33:32', '2021-11-10 18:33:32', 'admin-finance-dashboard'),
(296, 5, 'proposal_overview', 1, '2021-11-10 18:33:32', '2021-11-10 18:33:32', 'admin-finance-dashboard'),
(297, 5, 'invoice_tab', 1, '2021-11-10 18:33:32', '2021-11-10 18:33:32', 'admin-finance-dashboard'),
(298, 5, 'estimate_tab', 1, '2021-11-10 18:33:32', '2021-11-10 18:33:32', 'admin-finance-dashboard'),
(299, 5, 'expense_tab', 1, '2021-11-10 18:33:32', '2021-11-10 18:33:32', 'admin-finance-dashboard'),
(300, 5, 'payment_tab', 1, '2021-11-10 18:33:32', '2021-11-10 18:33:32', 'admin-finance-dashboard'),
(301, 5, 'due_payments_tab', 1, '2021-11-10 18:33:33', '2021-11-10 18:33:33', 'admin-finance-dashboard'),
(302, 5, 'proposal_tab', 1, '2021-11-10 18:33:33', '2021-11-10 18:33:33', 'admin-finance-dashboard'),
(303, 5, 'earnings_by_client', 1, '2021-11-10 18:33:33', '2021-11-10 18:33:33', 'admin-finance-dashboard'),
(304, 5, 'earnings_by_projects', 1, '2021-11-10 18:33:33', '2021-11-10 18:33:33', 'admin-finance-dashboard'),
(305, 5, 'total_leaves_approved', 1, '2021-11-10 18:33:33', '2021-11-10 18:33:33', 'admin-hr-dashboard'),
(306, 5, 'total_new_employee', 1, '2021-11-10 18:33:33', '2021-11-10 18:33:33', 'admin-hr-dashboard'),
(307, 5, 'total_employee_exits', 1, '2021-11-10 18:33:34', '2021-11-10 18:33:34', 'admin-hr-dashboard'),
(308, 5, 'average_attendance', 1, '2021-11-10 18:33:34', '2021-11-10 18:33:34', 'admin-hr-dashboard'),
(309, 5, 'department_wise_employee', 1, '2021-11-10 18:33:34', '2021-11-10 18:33:34', 'admin-hr-dashboard'),
(310, 5, 'designation_wise_employee', 1, '2021-11-10 18:33:34', '2021-11-10 18:33:34', 'admin-hr-dashboard'),
(311, 5, 'gender_wise_employee', 1, '2021-11-10 18:33:35', '2021-11-10 18:33:35', 'admin-hr-dashboard'),
(312, 5, 'role_wise_employee', 1, '2021-11-10 18:33:35', '2021-11-10 18:33:35', 'admin-hr-dashboard'),
(313, 5, 'leaves_taken', 1, '2021-11-10 18:33:35', '2021-11-10 18:33:35', 'admin-hr-dashboard'),
(314, 5, 'late_attendance_mark', 1, '2021-11-10 18:33:35', '2021-11-10 18:33:35', 'admin-hr-dashboard'),
(315, 5, 'total_project', 1, '2021-11-10 18:33:35', '2021-11-10 18:33:35', 'admin-project-dashboard'),
(316, 5, 'total_hours_logged', 1, '2021-11-10 18:33:36', '2021-11-10 18:33:36', 'admin-project-dashboard'),
(317, 5, 'total_overdue_project', 1, '2021-11-10 18:33:36', '2021-11-10 18:33:36', 'admin-project-dashboard'),
(318, 5, 'status_wise_project', 1, '2021-11-10 18:33:36', '2021-11-10 18:33:36', 'admin-project-dashboard'),
(319, 5, 'pending_milestone', 1, '2021-11-10 18:33:37', '2021-11-10 18:33:37', 'admin-project-dashboard'),
(320, 5, 'total_unresolved_tickets', 1, '2021-11-10 18:33:37', '2021-11-10 18:33:37', 'admin-ticket-dashboard'),
(321, 5, 'total_unassigned_ticket', 1, '2021-11-10 18:33:37', '2021-11-10 18:33:37', 'admin-ticket-dashboard'),
(322, 5, 'type_wise_ticket', 1, '2021-11-10 18:33:38', '2021-11-10 18:33:38', 'admin-ticket-dashboard'),
(323, 5, 'status_wise_ticket', 1, '2021-11-10 18:33:38', '2021-11-10 18:33:38', 'admin-ticket-dashboard'),
(324, 5, 'channel_wise_ticket', 1, '2021-11-10 18:33:38', '2021-11-10 18:33:38', 'admin-ticket-dashboard'),
(325, 5, 'new_tickets', 1, '2021-11-10 18:33:39', '2021-11-10 18:33:39', 'admin-ticket-dashboard'),
(326, 6, 'total_clients', 1, '2021-11-10 18:34:07', '2021-11-10 18:34:07', 'admin-dashboard'),
(327, 6, 'total_employees', 1, '2021-11-10 18:34:07', '2021-11-10 18:34:07', 'admin-dashboard'),
(328, 6, 'total_projects', 1, '2021-11-10 18:34:07', '2021-11-10 18:34:07', 'admin-dashboard'),
(329, 6, 'total_unpaid_invoices', 1, '2021-11-10 18:34:07', '2021-11-10 18:34:07', 'admin-dashboard'),
(330, 6, 'total_hours_logged', 1, '2021-11-10 18:34:07', '2021-11-10 18:34:07', 'admin-dashboard'),
(331, 6, 'total_pending_tasks', 1, '2021-11-10 18:34:08', '2021-11-10 18:34:08', 'admin-dashboard'),
(332, 6, 'total_today_attendance', 1, '2021-11-10 18:34:08', '2021-11-10 18:34:08', 'admin-dashboard'),
(333, 6, 'total_unresolved_tickets', 1, '2021-11-10 18:34:08', '2021-11-10 18:34:08', 'admin-dashboard'),
(334, 6, 'total_resolved_tickets', 1, '2021-11-10 18:34:08', '2021-11-10 18:34:08', 'admin-dashboard'),
(335, 6, 'recent_earnings', 1, '2021-11-10 18:34:09', '2021-11-10 18:34:09', 'admin-dashboard'),
(336, 6, 'settings_leaves', 1, '2021-11-10 18:34:09', '2021-11-10 18:34:09', 'admin-dashboard'),
(337, 6, 'new_tickets', 1, '2021-11-10 18:34:09', '2021-11-10 18:34:09', 'admin-dashboard'),
(338, 6, 'overdue_tasks', 1, '2021-11-10 18:34:09', '2021-11-10 18:34:09', 'admin-dashboard'),
(339, 6, 'completed_tasks', 1, '2021-11-10 18:34:10', '2021-11-10 18:34:10', 'admin-dashboard'),
(340, 6, 'pending_follow_up', 1, '2021-11-10 18:34:10', '2021-11-10 18:34:10', 'admin-dashboard'),
(341, 6, 'project_activity_timeline', 1, '2021-11-10 18:34:10', '2021-11-10 18:34:10', 'admin-dashboard'),
(342, 6, 'user_activity_timeline', 1, '2021-11-10 18:34:10', '2021-11-10 18:34:10', 'admin-dashboard'),
(343, 6, 'total_clients', 1, '2021-11-10 18:34:11', '2021-11-10 18:34:11', 'admin-client-dashboard'),
(344, 6, 'total_leads', 1, '2021-11-10 18:34:11', '2021-11-10 18:34:11', 'admin-client-dashboard'),
(345, 6, 'total_lead_conversions', 1, '2021-11-10 18:34:11', '2021-11-10 18:34:11', 'admin-client-dashboard'),
(346, 6, 'total_contracts_generated', 1, '2021-11-10 18:34:11', '2021-11-10 18:34:11', 'admin-client-dashboard'),
(347, 6, 'total_contracts_signed', 1, '2021-11-10 18:34:11', '2021-11-10 18:34:11', 'admin-client-dashboard'),
(348, 6, 'client_wise_earnings', 1, '2021-11-10 18:34:11', '2021-11-10 18:34:11', 'admin-client-dashboard'),
(349, 6, 'client_wise_timelogs', 1, '2021-11-10 18:34:11', '2021-11-10 18:34:11', 'admin-client-dashboard'),
(350, 6, 'lead_vs_status', 1, '2021-11-10 18:34:11', '2021-11-10 18:34:11', 'admin-client-dashboard'),
(351, 6, 'lead_vs_source', 1, '2021-11-10 18:34:11', '2021-11-10 18:34:11', 'admin-client-dashboard'),
(352, 6, 'latest_client', 1, '2021-11-10 18:34:12', '2021-11-10 18:34:12', 'admin-client-dashboard'),
(353, 6, 'recent_login_activities', 1, '2021-11-10 18:34:12', '2021-11-10 18:34:12', 'admin-client-dashboard'),
(354, 6, 'total_paid_invoices', 1, '2021-11-10 18:34:12', '2021-11-10 18:34:12', 'admin-finance-dashboard'),
(355, 6, 'total_expenses', 1, '2021-11-10 18:34:12', '2021-11-10 18:34:12', 'admin-finance-dashboard'),
(356, 6, 'total_earnings', 1, '2021-11-10 18:34:12', '2021-11-10 18:34:12', 'admin-finance-dashboard'),
(357, 6, 'total_profit', 1, '2021-11-10 18:34:13', '2021-11-10 18:34:13', 'admin-finance-dashboard'),
(358, 6, 'total_pending_amount', 1, '2021-11-10 18:34:13', '2021-11-10 18:34:13', 'admin-finance-dashboard'),
(359, 6, 'invoice_overview', 1, '2021-11-10 18:34:14', '2021-11-10 18:34:14', 'admin-finance-dashboard'),
(360, 6, 'estimate_overview', 1, '2021-11-10 18:34:15', '2021-11-10 18:34:15', 'admin-finance-dashboard'),
(361, 6, 'proposal_overview', 1, '2021-11-10 18:34:15', '2021-11-10 18:34:15', 'admin-finance-dashboard'),
(362, 6, 'invoice_tab', 1, '2021-11-10 18:34:15', '2021-11-10 18:34:15', 'admin-finance-dashboard'),
(363, 6, 'estimate_tab', 1, '2021-11-10 18:34:15', '2021-11-10 18:34:15', 'admin-finance-dashboard'),
(364, 6, 'expense_tab', 1, '2021-11-10 18:34:16', '2021-11-10 18:34:16', 'admin-finance-dashboard'),
(365, 6, 'payment_tab', 1, '2021-11-10 18:34:16', '2021-11-10 18:34:16', 'admin-finance-dashboard'),
(366, 6, 'due_payments_tab', 1, '2021-11-10 18:34:16', '2021-11-10 18:34:16', 'admin-finance-dashboard'),
(367, 6, 'proposal_tab', 1, '2021-11-10 18:34:17', '2021-11-10 18:34:17', 'admin-finance-dashboard'),
(368, 6, 'earnings_by_client', 1, '2021-11-10 18:34:17', '2021-11-10 18:34:17', 'admin-finance-dashboard'),
(369, 6, 'earnings_by_projects', 1, '2021-11-10 18:34:17', '2021-11-10 18:34:17', 'admin-finance-dashboard'),
(370, 6, 'total_leaves_approved', 1, '2021-11-10 18:34:17', '2021-11-10 18:34:17', 'admin-hr-dashboard'),
(371, 6, 'total_new_employee', 1, '2021-11-10 18:34:17', '2021-11-10 18:34:17', 'admin-hr-dashboard'),
(372, 6, 'total_employee_exits', 1, '2021-11-10 18:34:17', '2021-11-10 18:34:17', 'admin-hr-dashboard'),
(373, 6, 'average_attendance', 1, '2021-11-10 18:34:18', '2021-11-10 18:34:18', 'admin-hr-dashboard'),
(374, 6, 'department_wise_employee', 1, '2021-11-10 18:34:18', '2021-11-10 18:34:18', 'admin-hr-dashboard'),
(375, 6, 'designation_wise_employee', 1, '2021-11-10 18:34:18', '2021-11-10 18:34:18', 'admin-hr-dashboard'),
(376, 6, 'gender_wise_employee', 1, '2021-11-10 18:34:18', '2021-11-10 18:34:18', 'admin-hr-dashboard'),
(377, 6, 'role_wise_employee', 1, '2021-11-10 18:34:18', '2021-11-10 18:34:18', 'admin-hr-dashboard'),
(378, 6, 'leaves_taken', 1, '2021-11-10 18:34:19', '2021-11-10 18:34:19', 'admin-hr-dashboard'),
(379, 6, 'late_attendance_mark', 1, '2021-11-10 18:34:19', '2021-11-10 18:34:19', 'admin-hr-dashboard'),
(380, 6, 'total_project', 1, '2021-11-10 18:34:19', '2021-11-10 18:34:19', 'admin-project-dashboard'),
(381, 6, 'total_hours_logged', 1, '2021-11-10 18:34:19', '2021-11-10 18:34:19', 'admin-project-dashboard'),
(382, 6, 'total_overdue_project', 1, '2021-11-10 18:34:19', '2021-11-10 18:34:19', 'admin-project-dashboard'),
(383, 6, 'status_wise_project', 1, '2021-11-10 18:34:19', '2021-11-10 18:34:19', 'admin-project-dashboard'),
(384, 6, 'pending_milestone', 1, '2021-11-10 18:34:19', '2021-11-10 18:34:19', 'admin-project-dashboard'),
(385, 6, 'total_unresolved_tickets', 1, '2021-11-10 18:34:20', '2021-11-10 18:34:20', 'admin-ticket-dashboard'),
(386, 6, 'total_unassigned_ticket', 1, '2021-11-10 18:34:20', '2021-11-10 18:34:20', 'admin-ticket-dashboard'),
(387, 6, 'type_wise_ticket', 1, '2021-11-10 18:34:20', '2021-11-10 18:34:20', 'admin-ticket-dashboard'),
(388, 6, 'status_wise_ticket', 1, '2021-11-10 18:34:20', '2021-11-10 18:34:20', 'admin-ticket-dashboard'),
(389, 6, 'channel_wise_ticket', 1, '2021-11-10 18:34:20', '2021-11-10 18:34:20', 'admin-ticket-dashboard'),
(390, 6, 'new_tickets', 1, '2021-11-10 18:34:20', '2021-11-10 18:34:20', 'admin-ticket-dashboard');

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `company_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Trainee', '2021-11-10 18:34:22', '2021-11-10 18:34:22'),
(2, 1, 'Senior', '2021-11-10 18:34:23', '2021-11-10 18:34:23'),
(3, 1, 'Junior', '2021-11-10 18:34:23', '2021-11-10 18:34:23'),
(4, 1, 'Team Lead', '2021-11-10 18:34:23', '2021-11-10 18:34:23'),
(5, 1, 'Project Manager', '2021-11-10 18:34:23', '2021-11-10 18:34:23'),
(6, 2, 'Trainee', '2021-11-10 18:34:59', '2021-11-10 18:34:59'),
(7, 2, 'Senior', '2021-11-10 18:34:59', '2021-11-10 18:34:59'),
(8, 2, 'Junior', '2021-11-10 18:34:59', '2021-11-10 18:34:59'),
(9, 2, 'Team Lead', '2021-11-10 18:34:59', '2021-11-10 18:34:59'),
(10, 2, 'Project Manager', '2021-11-10 18:34:59', '2021-11-10 18:34:59'),
(11, 3, 'Trainee', '2021-11-10 18:35:26', '2021-11-10 18:35:26'),
(12, 3, 'Senior', '2021-11-10 18:35:26', '2021-11-10 18:35:26'),
(13, 3, 'Junior', '2021-11-10 18:35:26', '2021-11-10 18:35:26'),
(14, 3, 'Team Lead', '2021-11-10 18:35:26', '2021-11-10 18:35:26'),
(15, 3, 'Project Manager', '2021-11-10 18:35:27', '2021-11-10 18:35:27'),
(16, 4, 'Trainee', '2021-11-10 18:35:51', '2021-11-10 18:35:51'),
(17, 4, 'Senior', '2021-11-10 18:35:51', '2021-11-10 18:35:51'),
(18, 4, 'Junior', '2021-11-10 18:35:51', '2021-11-10 18:35:51'),
(19, 4, 'Team Lead', '2021-11-10 18:35:51', '2021-11-10 18:35:51'),
(20, 4, 'Project Manager', '2021-11-10 18:35:52', '2021-11-10 18:35:52'),
(21, 5, 'Trainee', '2021-11-10 18:36:22', '2021-11-10 18:36:22'),
(22, 5, 'Senior', '2021-11-10 18:36:22', '2021-11-10 18:36:22'),
(23, 5, 'Junior', '2021-11-10 18:36:22', '2021-11-10 18:36:22'),
(24, 5, 'Team Lead', '2021-11-10 18:36:23', '2021-11-10 18:36:23'),
(25, 5, 'Project Manager', '2021-11-10 18:36:23', '2021-11-10 18:36:23'),
(26, 6, 'Trainee', '2021-11-10 18:36:48', '2021-11-10 18:36:48'),
(27, 6, 'Senior', '2021-11-10 18:36:48', '2021-11-10 18:36:48'),
(28, 6, 'Junior', '2021-11-10 18:36:48', '2021-11-10 18:36:48'),
(29, 6, 'Team Lead', '2021-11-10 18:36:48', '2021-11-10 18:36:48'),
(30, 6, 'Project Manager', '2021-11-10 18:36:48', '2021-11-10 18:36:48');

-- --------------------------------------------------------

--
-- Table structure for table `discussions`
--

CREATE TABLE `discussions` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `discussion_category_id` int(10) UNSIGNED DEFAULT NULL,
  `project_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(20) COLLATE utf8_unicode_ci DEFAULT '#232629',
  `user_id` int(10) UNSIGNED NOT NULL,
  `pinned` tinyint(1) NOT NULL DEFAULT 0,
  `closed` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_reply_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `best_answer_id` int(10) UNSIGNED DEFAULT NULL,
  `last_reply_by_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `discussion_categories`
--

CREATE TABLE `discussion_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 1,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `discussion_files`
--

CREATE TABLE `discussion_files` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `discussion_id` int(10) UNSIGNED DEFAULT NULL,
  `discussion_reply_id` int(10) UNSIGNED DEFAULT NULL,
  `filename` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `google_url` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hashname` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `size` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dropbox_link` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `external_link_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `discussion_replies`
--

CREATE TABLE `discussion_replies` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `discussion_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_notification_settings`
--

CREATE TABLE `email_notification_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `setting_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `send_email` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `send_slack` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `send_push` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `email_notification_settings`
--

INSERT INTO `email_notification_settings` (`id`, `company_id`, `setting_name`, `send_email`, `send_slack`, `send_push`, `created_at`, `updated_at`) VALUES
(7, NULL, 'User Registration/Added by Admin', 'yes', 'no', 'no', '2021-11-10 18:29:58', '2021-11-10 18:29:58'),
(8, NULL, 'Employee Assign to Project', 'yes', 'no', 'no', '2021-11-10 18:29:58', '2021-11-10 18:29:58'),
(9, NULL, 'New Notice Published', 'no', 'no', 'no', '2021-11-10 18:29:58', '2021-11-10 18:29:58'),
(10, NULL, 'User Assign to Task', 'yes', 'no', 'no', '2021-11-10 18:29:59', '2021-11-10 18:29:59'),
(11, 1, 'New Expense/Added by Admin', 'yes', 'no', 'yes', '2021-11-10 18:30:24', '2021-11-10 18:30:24'),
(12, 1, 'New Expense/Added by Member', 'yes', 'no', 'yes', '2021-11-10 18:30:24', '2021-11-10 18:30:24'),
(13, 1, 'Expense Status Changed', 'yes', 'no', 'yes', '2021-11-10 18:30:24', '2021-11-10 18:30:24'),
(14, 1, 'New Support Ticket Request', 'yes', 'no', 'yes', '2021-11-10 18:30:24', '2021-11-10 18:30:24'),
(15, 1, 'User Registration/Added by Admin', 'yes', 'no', 'yes', '2021-11-10 18:30:24', '2021-11-10 18:30:24'),
(16, 1, 'Employee Assign to Project', 'yes', 'no', 'yes', '2021-11-10 18:30:25', '2021-11-10 18:30:25'),
(17, 1, 'New Notice Published', 'yes', 'no', 'yes', '2021-11-10 18:30:25', '2021-11-10 18:30:25'),
(18, 1, 'User Assign to Task', 'yes', 'no', 'yes', '2021-11-10 18:30:25', '2021-11-10 18:30:25'),
(19, 1, 'New Leave Application', 'yes', 'no', 'yes', '2021-11-10 18:30:25', '2021-11-10 18:30:25'),
(20, 1, 'Task Completed', 'yes', 'no', 'yes', '2021-11-10 18:30:25', '2021-11-10 18:30:25'),
(21, 1, 'Invoice Create/Update Notification', 'yes', 'no', 'yes', '2021-11-10 18:30:25', '2021-11-10 18:30:25'),
(22, 1, 'Payment Create/Update Notification', 'yes', 'no', 'yes', '2021-11-10 18:30:25', '2021-11-10 18:30:25'),
(23, 1, 'Discussion Reply', 'yes', 'no', 'yes', '2021-11-10 18:30:25', '2021-11-10 18:30:25'),
(24, 1, 'New Project/Added by Admin', 'yes', 'no', 'yes', '2021-11-10 18:30:25', '2021-11-10 18:30:25'),
(25, 1, 'New Project/Added by Member', 'yes', 'no', 'yes', '2021-11-10 18:30:25', '2021-11-10 18:30:25'),
(26, 1, 'Project File Added', 'yes', 'no', 'yes', '2021-11-10 18:30:25', '2021-11-10 18:30:25'),
(27, 1, 'Lead notification', 'yes', 'no', 'no', '2021-11-10 18:30:26', '2021-11-10 18:30:26'),
(28, 2, 'New Expense/Added by Admin', 'yes', 'no', 'yes', '2021-11-10 18:31:09', '2021-11-10 18:31:09'),
(29, 2, 'New Expense/Added by Member', 'yes', 'no', 'yes', '2021-11-10 18:31:09', '2021-11-10 18:31:09'),
(30, 2, 'Expense Status Changed', 'yes', 'no', 'yes', '2021-11-10 18:31:10', '2021-11-10 18:31:10'),
(31, 2, 'New Support Ticket Request', 'yes', 'no', 'yes', '2021-11-10 18:31:10', '2021-11-10 18:31:10'),
(32, 2, 'User Registration/Added by Admin', 'yes', 'no', 'yes', '2021-11-10 18:31:10', '2021-11-10 18:31:10'),
(33, 2, 'Employee Assign to Project', 'yes', 'no', 'yes', '2021-11-10 18:31:10', '2021-11-10 18:31:10'),
(34, 2, 'New Notice Published', 'yes', 'no', 'yes', '2021-11-10 18:31:10', '2021-11-10 18:31:10'),
(35, 2, 'User Assign to Task', 'yes', 'no', 'yes', '2021-11-10 18:31:10', '2021-11-10 18:31:10'),
(36, 2, 'New Leave Application', 'yes', 'no', 'yes', '2021-11-10 18:31:11', '2021-11-10 18:31:11'),
(37, 2, 'Task Completed', 'yes', 'no', 'yes', '2021-11-10 18:31:11', '2021-11-10 18:31:11'),
(38, 2, 'Invoice Create/Update Notification', 'yes', 'no', 'yes', '2021-11-10 18:31:11', '2021-11-10 18:31:11'),
(39, 2, 'Payment Create/Update Notification', 'yes', 'no', 'yes', '2021-11-10 18:31:11', '2021-11-10 18:31:11'),
(40, 2, 'Discussion Reply', 'yes', 'no', 'yes', '2021-11-10 18:31:11', '2021-11-10 18:31:11'),
(41, 2, 'New Project/Added by Admin', 'yes', 'no', 'yes', '2021-11-10 18:31:11', '2021-11-10 18:31:11'),
(42, 2, 'New Project/Added by Member', 'yes', 'no', 'yes', '2021-11-10 18:31:11', '2021-11-10 18:31:11'),
(43, 2, 'Project File Added', 'yes', 'no', 'yes', '2021-11-10 18:31:11', '2021-11-10 18:31:11'),
(44, 2, 'Lead notification', 'yes', 'no', 'no', '2021-11-10 18:31:11', '2021-11-10 18:31:11'),
(45, 3, 'New Expense/Added by Admin', 'yes', 'no', 'yes', '2021-11-10 18:31:59', '2021-11-10 18:31:59'),
(46, 3, 'New Expense/Added by Member', 'yes', 'no', 'yes', '2021-11-10 18:31:59', '2021-11-10 18:31:59'),
(47, 3, 'Expense Status Changed', 'yes', 'no', 'yes', '2021-11-10 18:31:59', '2021-11-10 18:31:59'),
(48, 3, 'New Support Ticket Request', 'yes', 'no', 'yes', '2021-11-10 18:31:59', '2021-11-10 18:31:59'),
(49, 3, 'User Registration/Added by Admin', 'yes', 'no', 'yes', '2021-11-10 18:31:59', '2021-11-10 18:31:59'),
(50, 3, 'Employee Assign to Project', 'yes', 'no', 'yes', '2021-11-10 18:32:00', '2021-11-10 18:32:00'),
(51, 3, 'New Notice Published', 'yes', 'no', 'yes', '2021-11-10 18:32:00', '2021-11-10 18:32:00'),
(52, 3, 'User Assign to Task', 'yes', 'no', 'yes', '2021-11-10 18:32:01', '2021-11-10 18:32:01'),
(53, 3, 'New Leave Application', 'yes', 'no', 'yes', '2021-11-10 18:32:01', '2021-11-10 18:32:01'),
(54, 3, 'Task Completed', 'yes', 'no', 'yes', '2021-11-10 18:32:01', '2021-11-10 18:32:01'),
(55, 3, 'Invoice Create/Update Notification', 'yes', 'no', 'yes', '2021-11-10 18:32:01', '2021-11-10 18:32:01'),
(56, 3, 'Payment Create/Update Notification', 'yes', 'no', 'yes', '2021-11-10 18:32:01', '2021-11-10 18:32:01'),
(57, 3, 'Discussion Reply', 'yes', 'no', 'yes', '2021-11-10 18:32:01', '2021-11-10 18:32:01'),
(58, 3, 'New Project/Added by Admin', 'yes', 'no', 'yes', '2021-11-10 18:32:01', '2021-11-10 18:32:01'),
(59, 3, 'New Project/Added by Member', 'yes', 'no', 'yes', '2021-11-10 18:32:02', '2021-11-10 18:32:02'),
(60, 3, 'Project File Added', 'yes', 'no', 'yes', '2021-11-10 18:32:02', '2021-11-10 18:32:02'),
(61, 3, 'Lead notification', 'yes', 'no', 'no', '2021-11-10 18:32:02', '2021-11-10 18:32:02'),
(62, 4, 'New Expense/Added by Admin', 'yes', 'no', 'yes', '2021-11-10 18:32:33', '2021-11-10 18:32:33'),
(63, 4, 'New Expense/Added by Member', 'yes', 'no', 'yes', '2021-11-10 18:32:33', '2021-11-10 18:32:33'),
(64, 4, 'Expense Status Changed', 'yes', 'no', 'yes', '2021-11-10 18:32:34', '2021-11-10 18:32:34'),
(65, 4, 'New Support Ticket Request', 'yes', 'no', 'yes', '2021-11-10 18:32:34', '2021-11-10 18:32:34'),
(66, 4, 'User Registration/Added by Admin', 'yes', 'no', 'yes', '2021-11-10 18:32:35', '2021-11-10 18:32:35'),
(67, 4, 'Employee Assign to Project', 'yes', 'no', 'yes', '2021-11-10 18:32:35', '2021-11-10 18:32:35'),
(68, 4, 'New Notice Published', 'yes', 'no', 'yes', '2021-11-10 18:32:35', '2021-11-10 18:32:35'),
(69, 4, 'User Assign to Task', 'yes', 'no', 'yes', '2021-11-10 18:32:35', '2021-11-10 18:32:35'),
(70, 4, 'New Leave Application', 'yes', 'no', 'yes', '2021-11-10 18:32:35', '2021-11-10 18:32:35'),
(71, 4, 'Task Completed', 'yes', 'no', 'yes', '2021-11-10 18:32:36', '2021-11-10 18:32:36'),
(72, 4, 'Invoice Create/Update Notification', 'yes', 'no', 'yes', '2021-11-10 18:32:36', '2021-11-10 18:32:36'),
(73, 4, 'Payment Create/Update Notification', 'yes', 'no', 'yes', '2021-11-10 18:32:36', '2021-11-10 18:32:36'),
(74, 4, 'Discussion Reply', 'yes', 'no', 'yes', '2021-11-10 18:32:36', '2021-11-10 18:32:36'),
(75, 4, 'New Project/Added by Admin', 'yes', 'no', 'yes', '2021-11-10 18:32:36', '2021-11-10 18:32:36'),
(76, 4, 'New Project/Added by Member', 'yes', 'no', 'yes', '2021-11-10 18:32:36', '2021-11-10 18:32:36'),
(77, 4, 'Project File Added', 'yes', 'no', 'yes', '2021-11-10 18:32:37', '2021-11-10 18:32:37'),
(78, 4, 'Lead notification', 'yes', 'no', 'no', '2021-11-10 18:32:37', '2021-11-10 18:32:37'),
(79, 5, 'New Expense/Added by Admin', 'yes', 'no', 'yes', '2021-11-10 18:33:16', '2021-11-10 18:33:16'),
(80, 5, 'New Expense/Added by Member', 'yes', 'no', 'yes', '2021-11-10 18:33:16', '2021-11-10 18:33:16'),
(81, 5, 'Expense Status Changed', 'yes', 'no', 'yes', '2021-11-10 18:33:16', '2021-11-10 18:33:16'),
(82, 5, 'New Support Ticket Request', 'yes', 'no', 'yes', '2021-11-10 18:33:17', '2021-11-10 18:33:17'),
(83, 5, 'User Registration/Added by Admin', 'yes', 'no', 'yes', '2021-11-10 18:33:17', '2021-11-10 18:33:17'),
(84, 5, 'Employee Assign to Project', 'yes', 'no', 'yes', '2021-11-10 18:33:17', '2021-11-10 18:33:17'),
(85, 5, 'New Notice Published', 'yes', 'no', 'yes', '2021-11-10 18:33:17', '2021-11-10 18:33:17'),
(86, 5, 'User Assign to Task', 'yes', 'no', 'yes', '2021-11-10 18:33:17', '2021-11-10 18:33:17'),
(87, 5, 'New Leave Application', 'yes', 'no', 'yes', '2021-11-10 18:33:18', '2021-11-10 18:33:18'),
(88, 5, 'Task Completed', 'yes', 'no', 'yes', '2021-11-10 18:33:18', '2021-11-10 18:33:18'),
(89, 5, 'Invoice Create/Update Notification', 'yes', 'no', 'yes', '2021-11-10 18:33:18', '2021-11-10 18:33:18'),
(90, 5, 'Payment Create/Update Notification', 'yes', 'no', 'yes', '2021-11-10 18:33:19', '2021-11-10 18:33:19'),
(91, 5, 'Discussion Reply', 'yes', 'no', 'yes', '2021-11-10 18:33:19', '2021-11-10 18:33:19'),
(92, 5, 'New Project/Added by Admin', 'yes', 'no', 'yes', '2021-11-10 18:33:19', '2021-11-10 18:33:19'),
(93, 5, 'New Project/Added by Member', 'yes', 'no', 'yes', '2021-11-10 18:33:19', '2021-11-10 18:33:19'),
(94, 5, 'Project File Added', 'yes', 'no', 'yes', '2021-11-10 18:33:19', '2021-11-10 18:33:19'),
(95, 5, 'Lead notification', 'yes', 'no', 'no', '2021-11-10 18:33:20', '2021-11-10 18:33:20'),
(96, 6, 'New Expense/Added by Admin', 'yes', 'no', 'yes', '2021-11-10 18:33:57', '2021-11-10 18:33:57'),
(97, 6, 'New Expense/Added by Member', 'yes', 'no', 'yes', '2021-11-10 18:33:57', '2021-11-10 18:33:57'),
(98, 6, 'Expense Status Changed', 'yes', 'no', 'yes', '2021-11-10 18:33:57', '2021-11-10 18:33:57'),
(99, 6, 'New Support Ticket Request', 'yes', 'no', 'yes', '2021-11-10 18:33:57', '2021-11-10 18:33:57'),
(100, 6, 'User Registration/Added by Admin', 'yes', 'no', 'yes', '2021-11-10 18:33:58', '2021-11-10 18:33:58'),
(101, 6, 'Employee Assign to Project', 'yes', 'no', 'yes', '2021-11-10 18:33:58', '2021-11-10 18:33:58'),
(102, 6, 'New Notice Published', 'yes', 'no', 'yes', '2021-11-10 18:33:58', '2021-11-10 18:33:58'),
(103, 6, 'User Assign to Task', 'yes', 'no', 'yes', '2021-11-10 18:33:58', '2021-11-10 18:33:58'),
(104, 6, 'New Leave Application', 'yes', 'no', 'yes', '2021-11-10 18:33:58', '2021-11-10 18:33:58'),
(105, 6, 'Task Completed', 'yes', 'no', 'yes', '2021-11-10 18:33:58', '2021-11-10 18:33:58'),
(106, 6, 'Invoice Create/Update Notification', 'yes', 'no', 'yes', '2021-11-10 18:33:58', '2021-11-10 18:33:58'),
(107, 6, 'Payment Create/Update Notification', 'yes', 'no', 'yes', '2021-11-10 18:33:59', '2021-11-10 18:33:59'),
(108, 6, 'Discussion Reply', 'yes', 'no', 'yes', '2021-11-10 18:33:59', '2021-11-10 18:33:59'),
(109, 6, 'New Project/Added by Admin', 'yes', 'no', 'yes', '2021-11-10 18:33:59', '2021-11-10 18:33:59'),
(110, 6, 'New Project/Added by Member', 'yes', 'no', 'yes', '2021-11-10 18:33:59', '2021-11-10 18:33:59'),
(111, 6, 'Project File Added', 'yes', 'no', 'yes', '2021-11-10 18:33:59', '2021-11-10 18:33:59'),
(112, 6, 'Lead notification', 'yes', 'no', 'no', '2021-11-10 18:33:59', '2021-11-10 18:33:59');

-- --------------------------------------------------------

--
-- Table structure for table `employee_details`
--

CREATE TABLE `employee_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `employee_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `hourly_rate` double DEFAULT NULL,
  `slack_username` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `department_id` int(10) UNSIGNED DEFAULT NULL,
  `designation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `joining_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_date` date DEFAULT NULL,
  `attendance_reminder` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `employee_details`
--

INSERT INTO `employee_details` (`id`, `company_id`, `user_id`, `employee_id`, `address`, `hourly_rate`, `slack_username`, `department_id`, `designation_id`, `created_at`, `updated_at`, `joining_date`, `last_date`, `attendance_reminder`) VALUES
(1, 1, 2, 'EMP002', 'address', 44, NULL, NULL, NULL, '2021-11-10 18:30:53', '2021-11-10 18:30:53', '2021-11-09 22:00:00', NULL, NULL),
(2, 1, 3, 'EMP003', 'address', 46, NULL, NULL, NULL, '2021-11-10 18:30:55', '2021-11-10 18:30:55', '2021-11-09 22:00:00', NULL, NULL),
(3, 1, 5, 'EMP005', '71588 Kreiger Dale\nSmithamshire, AK 19240-6020', 46, 'lera.green', 5, 1, '2021-11-10 18:34:27', '2021-11-10 18:34:27', '2021-09-04 22:00:00', NULL, NULL),
(4, 1, 6, 'EMP006', '44063 Miller Walks Suite 903\nBriceview, ID 28198', 17, 'antonette69', 5, 2, '2021-11-10 18:34:29', '2021-11-10 18:34:29', '2021-03-20 22:00:00', NULL, NULL),
(5, 1, 7, 'EMP007', '67529 Kertzmann Ports\nPaxtonborough, OK 92023', 16, 'fbergstrom', 3, 1, '2021-11-10 18:34:30', '2021-11-10 18:34:30', '2021-08-01 22:00:00', NULL, NULL),
(6, 1, 8, 'EMP008', '75838 Goyette Fords\nAnaburgh, PA 10165-1780', 39, 'virgil95', 1, 4, '2021-11-10 18:34:33', '2021-11-10 18:34:33', '2021-05-03 22:00:00', NULL, NULL),
(7, 1, 9, 'EMP009', '992 Braun Shoals\nSheldonhaven, CA 25370-6056', 28, 'benton97', 2, 1, '2021-11-10 18:34:34', '2021-11-10 18:34:34', '2021-02-17 22:00:00', NULL, NULL),
(8, 1, 10, 'EMP0010', '451 Heidenreich Track\nWalterburgh, DC 07450', 29, 'jkoepp', 5, 2, '2021-11-10 18:34:36', '2021-11-10 18:34:36', '2021-02-26 22:00:00', NULL, NULL),
(9, 1, 11, 'EMP0011', '5244 Kelsie Freeway\nBernhardbury, CT 37976-0334', 35, 'sporer.filiberto', 2, 1, '2021-11-10 18:34:38', '2021-11-10 18:34:38', '2021-10-09 22:00:00', NULL, NULL),
(10, 1, 12, 'EMP0012', '3963 Miller Manor Apt. 404\nShannafort, CA 03393-0031', 29, 'stephany.dooley', 1, 2, '2021-11-10 18:34:38', '2021-11-10 18:34:38', '2021-05-17 22:00:00', NULL, NULL),
(11, 1, 13, 'EMP0013', '4374 Winnifred Green\nGeraldinehaven, NM 63404-4514', 21, 'iswaniawski', 6, 5, '2021-11-10 18:34:39', '2021-11-10 18:34:39', '2021-02-04 22:00:00', NULL, NULL),
(12, 1, 14, 'EMP0014', '8921 Greenfelder Shoals\nSouth Nyasiastad, IN 62692', 16, 'ward.zoey', 4, 2, '2021-11-10 18:34:39', '2021-11-10 18:34:39', '2021-05-18 22:00:00', NULL, NULL),
(13, 1, 15, 'EMP0015', '148 Beier Island\nCummingsberg, MA 52753', 21, 'schuppe.loyce', 1, 3, '2021-11-10 18:34:41', '2021-11-10 18:34:41', '2021-04-08 22:00:00', NULL, NULL),
(14, 1, 16, 'EMP0016', '37571 Moore Fork Apt. 202\nSouth Annahaven, VT 96237-0762', 33, 'dora.conn', 2, 5, '2021-11-10 18:34:42', '2021-11-10 18:34:42', '2021-09-28 22:00:00', NULL, NULL),
(15, 1, 17, 'EMP0017', '25505 Terry Green\nSouth Francescastad, KY 37671-0626', 16, 'shayna67', 3, 1, '2021-11-10 18:34:42', '2021-11-10 18:34:42', '2021-06-04 22:00:00', NULL, NULL),
(16, 1, 18, 'EMP0018', '37488 Greenholt Unions Suite 206\nKochburgh, TX 75530-1322', 37, 'vreinger', 1, 1, '2021-11-10 18:34:42', '2021-11-10 18:34:42', '2020-12-06 22:00:00', NULL, NULL),
(17, 1, 19, 'EMP0019', '563 Balistreri Plaza\nMonahanfurt, NH 77376', 38, 'murazik.dayne', 3, 4, '2021-11-10 18:34:43', '2021-11-10 18:34:43', '2021-08-29 22:00:00', NULL, NULL),
(18, 1, 20, 'EMP0020', '524 Jakubowski Course\nWillmsberg, NC 57545', 38, 'bledner', 2, 5, '2021-11-10 18:34:43', '2021-11-10 18:34:43', '2021-09-12 22:00:00', NULL, NULL),
(19, 1, 21, 'EMP0021', '298 Beatty Key\nJoannyland, ND 45642', 37, 'moen.horacio', 6, 2, '2021-11-10 18:34:44', '2021-11-10 18:34:44', '2021-06-16 22:00:00', NULL, NULL),
(20, 1, 22, 'EMP0022', '3267 Ankunding Lakes Suite 925\nNew Cathrynview, ND 05406', 38, 'elroy.connelly', 1, 1, '2021-11-10 18:34:46', '2021-11-10 18:34:46', '2021-11-02 22:00:00', NULL, NULL),
(21, 1, 23, 'EMP0023', '502 Michael Brook\nLake Moises, TX 21785-0431', 23, 'grady.andreanne', 4, 4, '2021-11-10 18:34:49', '2021-11-10 18:34:49', '2021-03-02 22:00:00', NULL, NULL),
(22, 1, 24, 'EMP0024', '672 Kuhn Square\nWest Dasia, SC 60199-4235', 25, 'odell.erdman', 6, 1, '2021-11-10 18:34:50', '2021-11-10 18:34:50', '2021-09-17 22:00:00', NULL, NULL),
(23, 2, 35, 'EMP0035', '440 Orlando Parkway\nBoehmville, VA 54615', 28, 'lbotsford', 8, 5, '2021-11-10 18:35:01', '2021-11-10 18:35:01', '2021-08-08 22:00:00', NULL, NULL),
(24, 2, 36, 'EMP0036', '653 Pat Trafficway\nLake Orpha, NE 18589', 21, 'karli.nolan', 1, 4, '2021-11-10 18:35:02', '2021-11-10 18:35:02', '2020-12-15 22:00:00', NULL, NULL),
(25, 2, 37, 'EMP0037', '2536 Kulas Spurs Suite 668\nImmanuelmouth, WA 46706', 40, 'retta73', 6, 10, '2021-11-10 18:35:02', '2021-11-10 18:35:02', '2021-02-01 22:00:00', NULL, NULL),
(26, 2, 38, 'EMP0038', '49751 Von Falls Suite 113\nNorth Stephanburgh, AZ 28339-5796', 50, 'littel.reggie', 2, 2, '2021-11-10 18:35:03', '2021-11-10 18:35:03', '2021-10-25 22:00:00', NULL, NULL),
(27, 2, 39, 'EMP0039', '496 Harmony Path\nPort Deon, CA 55042', 48, 'jordon.mante', 11, 6, '2021-11-10 18:35:03', '2021-11-10 18:35:03', '2021-10-09 22:00:00', NULL, NULL),
(28, 2, 40, 'EMP0040', '96050 Lowe Light\nNorth Dillonmouth, TX 06701', 22, 'mcglynn.gage', 8, 4, '2021-11-10 18:35:04', '2021-11-10 18:35:04', '2021-02-05 22:00:00', NULL, NULL),
(29, 2, 41, 'EMP0041', '4085 Hayes Lodge\nAbshiremouth, WA 64667-9832', 47, 'fay.faye', 1, 4, '2021-11-10 18:35:04', '2021-11-10 18:35:04', '2021-08-27 22:00:00', NULL, NULL),
(30, 2, 42, 'EMP0042', '319 Turcotte Mill Apt. 965\nNorth Calistamouth, KS 72938', 50, 'bmarks', 8, 8, '2021-11-10 18:35:05', '2021-11-10 18:35:05', '2021-01-28 22:00:00', NULL, NULL),
(31, 2, 43, 'EMP0043', '8079 Parisian Fords\nEast Citlalliborough, OK 03709', 13, 'johns.leora', 1, 4, '2021-11-10 18:35:05', '2021-11-10 18:35:05', '2021-03-02 22:00:00', NULL, NULL),
(32, 2, 44, 'EMP0044', '19544 Wolf Meadows Suite 955\nCollierstad, ME 80692-0920', 48, 'freida77', 3, 9, '2021-11-10 18:35:06', '2021-11-10 18:35:06', '2020-12-02 22:00:00', NULL, NULL),
(33, 2, 45, 'EMP0045', '3501 Bartell Brooks\nRoxanneland, OR 19279', 31, 'tracey.sauer', 8, 9, '2021-11-10 18:35:08', '2021-11-10 18:35:08', '2021-03-13 22:00:00', NULL, NULL),
(34, 2, 46, 'EMP0046', '350 Anderson Spring Suite 093\nGerholdland, NV 68426', 37, 'cjakubowski', 3, 8, '2021-11-10 18:35:09', '2021-11-10 18:35:09', '2020-12-12 22:00:00', NULL, NULL),
(35, 2, 47, 'EMP0047', '146 Hyatt Radial Apt. 183\nDeontaebury, NE 17176-9721', 41, 'wmiller', 11, 5, '2021-11-10 18:35:09', '2021-11-10 18:35:09', '2021-08-30 22:00:00', NULL, NULL),
(36, 2, 48, 'EMP0048', '4997 Trycia Crossing\nLake Emmalee, OK 64238', 48, 'hilpert.cleo', 11, 2, '2021-11-10 18:35:10', '2021-11-10 18:35:10', '2020-11-16 22:00:00', NULL, NULL),
(37, 2, 49, 'EMP0049', '37965 Jacobson Pike\nEast Stephany, CO 79959-4853', 32, 'hmedhurst', 10, 2, '2021-11-10 18:35:11', '2021-11-10 18:35:11', '2021-04-17 22:00:00', NULL, NULL),
(38, 2, 50, 'EMP0050', '53068 Rempel Valleys\nNorth Ricoport, ME 54798-7769', 12, 'henriette.watsica', 10, 7, '2021-11-10 18:35:11', '2021-11-10 18:35:11', '2021-04-11 22:00:00', NULL, NULL),
(39, 2, 51, 'EMP0051', '14182 Aniya Ridge\nSouth Angus, NJ 34122-9853', 12, 'tnienow', 3, 1, '2021-11-10 18:35:12', '2021-11-10 18:35:12', '2020-12-22 22:00:00', NULL, NULL),
(40, 2, 52, 'EMP0052', '5127 Matt Ports Suite 971\nJaceyberg, NC 40468-4080', 21, 'mlegros', 8, 7, '2021-11-10 18:35:14', '2021-11-10 18:35:14', '2021-08-23 22:00:00', NULL, NULL),
(41, 2, 53, 'EMP0053', '776 Benton Motorway\nSouth Erick, NE 47650-1177', 35, 'jameson32', 8, 7, '2021-11-10 18:35:16', '2021-11-10 18:35:16', '2021-10-22 22:00:00', NULL, NULL),
(42, 2, 54, 'EMP0054', '7011 Priscilla Gateway\nWest Hoseatown, MO 11728', 32, 'hammes.rosie', 2, 1, '2021-11-10 18:35:17', '2021-11-10 18:35:17', '2020-11-13 22:00:00', NULL, NULL),
(43, 3, 65, 'EMP0065', '66946 Zander Walk\nLake Modestamouth, IA 13487', 36, 'barton.powlowski', 8, 2, '2021-11-10 18:35:29', '2021-11-10 18:35:29', '2021-09-04 22:00:00', NULL, NULL),
(44, 3, 66, 'EMP0066', '40565 Eldora Plaza Apt. 054\nBaileyfort, MS 93633-2916', 29, 'rippin.megane', 2, 13, '2021-11-10 18:35:30', '2021-11-10 18:35:30', '2021-02-13 22:00:00', NULL, NULL),
(45, 3, 67, 'EMP0067', '760 Retha River\nBayerton, TN 36740-2160', 48, 'mpadberg', 17, 10, '2021-11-10 18:35:31', '2021-11-10 18:35:31', '2021-03-19 22:00:00', NULL, NULL),
(46, 3, 68, 'EMP0068', '142 Maryjane Dale\nBayerport, LA 14534', 15, 'viola.deckow', 8, 8, '2021-11-10 18:35:31', '2021-11-10 18:35:31', '2020-11-24 22:00:00', NULL, NULL),
(47, 3, 69, 'EMP0069', '23997 Noemie Port\nMuhammadberg, KY 52192', 14, 'dschmeler', 11, 10, '2021-11-10 18:35:31', '2021-11-10 18:35:31', '2021-05-15 22:00:00', NULL, NULL),
(48, 3, 70, 'EMP0070', '915 Hosea Common\nNorth Coralie, WY 69582-1933', 34, 'king.alison', 3, 11, '2021-11-10 18:35:32', '2021-11-10 18:35:32', '2021-03-19 22:00:00', NULL, NULL),
(49, 3, 71, 'EMP0071', '1332 Lonnie Trafficway\nEast Florence, ID 92110', 25, 'ihudson', 1, 13, '2021-11-10 18:35:34', '2021-11-10 18:35:34', '2021-05-04 22:00:00', NULL, NULL),
(50, 3, 72, 'EMP0072', '944 Maybelle Courts Suite 875\nMaritzashire, OH 49631', 42, 'gino.rice', 9, 8, '2021-11-10 18:35:35', '2021-11-10 18:35:35', '2021-08-25 22:00:00', NULL, NULL),
(51, 3, 73, 'EMP0073', '43252 Micaela Field\nKihnton, GA 42695', 42, 'cynthia65', 7, 2, '2021-11-10 18:35:35', '2021-11-10 18:35:35', '2021-05-07 22:00:00', NULL, NULL),
(52, 3, 74, 'EMP0074', '69402 Collier Divide Apt. 417\nSouth Lupe, NJ 51361-2372', 42, 'cjacobson', 7, 3, '2021-11-10 18:35:36', '2021-11-10 18:35:36', '2021-09-14 22:00:00', NULL, NULL),
(53, 3, 75, 'EMP0075', '212 Heaney Glens\nMertzside, GA 12198-8369', 26, 'smitham.ellie', 16, 10, '2021-11-10 18:35:37', '2021-11-10 18:35:37', '2021-08-01 22:00:00', NULL, NULL),
(54, 3, 76, 'EMP0076', '42389 Botsford Meadow\nEast Vellafort, MA 38813', 31, 'rupert.mante', 13, 7, '2021-11-10 18:35:37', '2021-11-10 18:35:37', '2021-08-22 22:00:00', NULL, NULL),
(55, 3, 77, 'EMP0077', '39323 Aric Bridge\nPort Dortha, AZ 52181', 33, 'grimes.clotilde', 2, 2, '2021-11-10 18:35:37', '2021-11-10 18:35:37', '2021-06-08 22:00:00', NULL, NULL),
(56, 3, 78, 'EMP0078', '9752 Lenore Lock\nBlickberg, CO 40932', 45, 'rey.ortiz', 3, 14, '2021-11-10 18:35:38', '2021-11-10 18:35:38', '2021-07-01 22:00:00', NULL, NULL),
(57, 3, 79, 'EMP0079', '33549 Gulgowski Pass\nHirthetown, AL 42046', 10, 'elouise18', 13, 5, '2021-11-10 18:35:38', '2021-11-10 18:35:38', '2021-06-23 22:00:00', NULL, NULL),
(58, 3, 80, 'EMP0080', '959 Rahsaan Shoal\nLake Adella, MO 80851-8170', 18, 'sylvester45', 7, 8, '2021-11-10 18:35:38', '2021-11-10 18:35:38', '2021-02-08 22:00:00', NULL, NULL),
(59, 3, 81, 'EMP0081', '8558 Abe Curve Apt. 857\nSouth Chad, GA 99657', 40, 'aokeefe', 8, 1, '2021-11-10 18:35:39', '2021-11-10 18:35:39', '2021-07-27 22:00:00', NULL, NULL),
(60, 3, 82, 'EMP0082', '8731 Otha Rapids Suite 820\nChayaberg, TN 29692-1367', 17, 'dasia78', 18, 4, '2021-11-10 18:35:40', '2021-11-10 18:35:40', '2021-02-18 22:00:00', NULL, NULL),
(61, 3, 83, 'EMP0083', '558 Saul Fork Suite 448\nSouth Alana, MS 29558', 31, 'schumm.hal', 17, 9, '2021-11-10 18:35:40', '2021-11-10 18:35:40', '2021-09-01 22:00:00', NULL, NULL),
(62, 3, 84, 'EMP0084', '319 Lakin Crescent\nEast Roseshire, NV 46207', 10, 'angelita.grant', 3, 15, '2021-11-10 18:35:41', '2021-11-10 18:35:41', '2021-05-25 22:00:00', NULL, NULL),
(63, 4, 95, 'EMP0095', '422 Bridgette Road\nSouth Moniquemouth, UT 58319', 43, 'mclaughlin.marcus', 3, 20, '2021-11-10 18:35:54', '2021-11-10 18:35:54', '2021-10-01 22:00:00', NULL, NULL),
(64, 4, 96, 'EMP0096', '5101 Nienow Walk\nRosannaborough, LA 56306', 16, 'metz.earlene', 13, 7, '2021-11-10 18:35:58', '2021-11-10 18:35:58', '2021-08-14 22:00:00', NULL, NULL),
(65, 4, 97, 'EMP0097', '626 Conn Groves Apt. 701\nWest Rocio, VA 30221', 14, 'huel.marcos', 9, 1, '2021-11-10 18:35:59', '2021-11-10 18:35:59', '2021-10-04 22:00:00', NULL, NULL),
(66, 4, 98, 'EMP0098', '23957 Leuschke Park\nSpinkastad, MO 33887-8301', 43, 'tstanton', 7, 12, '2021-11-10 18:35:59', '2021-11-10 18:35:59', '2021-03-27 22:00:00', NULL, NULL),
(67, 4, 99, 'EMP0099', '81177 Bartoletti Courts\nEvangelineview, MS 46117', 37, 'mercedes.littel', 13, 18, '2021-11-10 18:35:59', '2021-11-10 18:35:59', '2021-03-06 22:00:00', NULL, NULL),
(68, 4, 100, 'EMP00100', '9435 Shyanne Harbors Suite 140\nKristinatown, NH 04525', 45, 'bbecker', 21, 8, '2021-11-10 18:36:00', '2021-11-10 18:36:00', '2021-01-06 22:00:00', NULL, NULL),
(69, 4, 101, 'EMP00101', '75014 Katlyn Island Suite 259\nGlendaborough, AL 74172', 11, 'leannon.ewell', 7, 16, '2021-11-10 18:36:00', '2021-11-10 18:36:00', '2021-10-18 22:00:00', NULL, NULL),
(70, 4, 102, 'EMP00102', '1271 Micaela Court Apt. 409\nPort Angelina, IN 88450', 24, 'mkirlin', 21, 19, '2021-11-10 18:36:01', '2021-11-10 18:36:01', '2021-04-06 22:00:00', NULL, NULL),
(71, 4, 103, 'EMP00103', '4161 Price Extensions Suite 607\nDickinsonstad, NC 55368-4268', 29, 'jalen.huel', 23, 9, '2021-11-10 18:36:01', '2021-11-10 18:36:01', '2020-12-16 22:00:00', NULL, NULL),
(72, 4, 104, 'EMP00104', '76636 Berge Fort Suite 252\nLake Jameymouth, AL 40001', 27, 'mayra.mckenzie', 19, 8, '2021-11-10 18:36:03', '2021-11-10 18:36:03', '2020-12-03 22:00:00', NULL, NULL),
(73, 4, 105, 'EMP00105', '5692 Kennedy Mission Suite 540\nThompsonland, AR 02259', 40, 'bosco.beth', 22, 2, '2021-11-10 18:36:06', '2021-11-10 18:36:06', '2021-06-14 22:00:00', NULL, NULL),
(74, 4, 106, 'EMP00106', '60484 Florida Cove\nEast Gregoriatown, AL 04838', 26, 'diamond55', 15, 7, '2021-11-10 18:36:08', '2021-11-10 18:36:08', '2021-06-17 22:00:00', NULL, NULL),
(75, 4, 107, 'EMP00107', '10727 Herman Locks\nSouth Cristianmouth, TX 97755-9909', 50, 'oroob', 12, 15, '2021-11-10 18:36:09', '2021-11-10 18:36:09', '2021-06-04 22:00:00', NULL, NULL),
(76, 4, 108, 'EMP00108', '263 Batz Lakes\nKonopelskiland, NV 44444-4798', 14, 'erwin35', 13, 12, '2021-11-10 18:36:10', '2021-11-10 18:36:10', '2021-05-05 22:00:00', NULL, NULL),
(77, 4, 109, 'EMP00109', '9776 Eino Coves\nEast Aryannaville, ME 26005-3772', 45, 'jgottlieb', 16, 3, '2021-11-10 18:36:10', '2021-11-10 18:36:10', '2021-01-09 22:00:00', NULL, NULL),
(78, 4, 110, 'EMP00110', '80789 Amalia Terrace\nHellerborough, MO 92050', 15, 'dangelo26', 12, 9, '2021-11-10 18:36:11', '2021-11-10 18:36:11', '2021-08-08 22:00:00', NULL, NULL),
(79, 4, 111, 'EMP00111', '62544 Willms Bridge\nAmyport, TN 10667', 14, 'renner.arely', 10, 11, '2021-11-10 18:36:12', '2021-11-10 18:36:12', '2021-04-15 22:00:00', NULL, NULL),
(80, 4, 112, 'EMP00112', '965 Robel Squares Suite 336\nPort Taya, DE 77509-0270', 13, 'missouri.will', 7, 16, '2021-11-10 18:36:13', '2021-11-10 18:36:13', '2021-07-08 22:00:00', NULL, NULL),
(81, 4, 113, 'EMP00113', '8552 Maxie Flats Apt. 565\nLake Loyland, AK 10784-6231', 13, 'myah.bergstrom', 2, 16, '2021-11-10 18:36:13', '2021-11-10 18:36:13', '2021-05-26 22:00:00', NULL, NULL),
(82, 4, 114, 'EMP00114', '4832 Emanuel Roads Apt. 731\nVernmouth, NE 92195-0073', 31, 'ivory.luettgen', 9, 8, '2021-11-10 18:36:14', '2021-11-10 18:36:14', '2021-04-13 22:00:00', NULL, NULL),
(83, 5, 125, 'EMP00125', '706 Hettinger Mission Apt. 072\nMollyburgh, SC 79023', 42, 'elvera.sauer', 9, 24, '2021-11-10 18:36:27', '2021-11-10 18:36:27', '2020-11-14 22:00:00', NULL, NULL),
(84, 5, 126, 'EMP00126', '39311 Torp Viaduct Suite 429\nMoenshire, IA 95206-6280', 10, 'hagenes.xzavier', 8, 16, '2021-11-10 18:36:27', '2021-11-10 18:36:27', '2021-05-16 22:00:00', NULL, NULL),
(85, 5, 127, 'EMP00127', '69558 Ellie Shore Suite 805\nShanestad, WY 84989', 22, 'dorris17', 8, 23, '2021-11-10 18:36:28', '2021-11-10 18:36:28', '2021-08-06 22:00:00', NULL, NULL),
(86, 5, 128, 'EMP00128', '5119 Cassin Locks Suite 834\nMoenbury, VA 25861', 34, 'tjohnson', 6, 11, '2021-11-10 18:36:28', '2021-11-10 18:36:28', '2020-11-11 22:00:00', NULL, NULL),
(87, 5, 129, 'EMP00129', '35935 Tyler Estate\nBellview, SD 92247-8423', 29, 'wintheiser.russell', 13, 14, '2021-11-10 18:36:29', '2021-11-10 18:36:29', '2021-05-28 22:00:00', NULL, NULL),
(88, 5, 130, 'EMP00130', '1821 Allen Vista Apt. 540\nKristofertown, MI 16283-5365', 21, 'franecki.vernie', 28, 13, '2021-11-10 18:36:29', '2021-11-10 18:36:29', '2021-07-13 22:00:00', NULL, NULL),
(89, 5, 131, 'EMP00131', '250 Kiehn Village Apt. 217\nLake Selenachester, MN 55892-0568', 18, 'jaden.nitzsche', 24, 2, '2021-11-10 18:36:30', '2021-11-10 18:36:30', '2021-01-10 22:00:00', NULL, NULL),
(90, 5, 132, 'EMP00132', '389 Rhiannon Circle Apt. 830\nNew Estaside, PA 37235-9785', 36, 'barrett08', 9, 20, '2021-11-10 18:36:33', '2021-11-10 18:36:33', '2021-10-22 22:00:00', NULL, NULL),
(91, 5, 133, 'EMP00133', '507 Laurine Squares Suite 305\nToyport, MT 57012', 38, 'becker.elijah', 25, 24, '2021-11-10 18:36:33', '2021-11-10 18:36:33', '2021-05-09 22:00:00', NULL, NULL),
(92, 5, 134, 'EMP00134', '2073 Garnett Shoals Suite 522\nLebsackfurt, MN 62306-8987', 18, 'shea.fay', 11, 21, '2021-11-10 18:36:34', '2021-11-10 18:36:34', '2021-07-15 22:00:00', NULL, NULL),
(93, 5, 135, 'EMP00135', '5210 Loma Course Apt. 613\nAddiehaven, IL 79036-8409', 50, 'tbins', 14, 7, '2021-11-10 18:36:36', '2021-11-10 18:36:36', '2021-06-27 22:00:00', NULL, NULL),
(94, 5, 136, 'EMP00136', '44735 Madison Crossing\nLake Mireille, HI 76457', 42, 'ocie.kulas', 19, 12, '2021-11-10 18:36:37', '2021-11-10 18:36:37', '2021-05-27 22:00:00', NULL, NULL),
(95, 5, 137, 'EMP00137', '1920 McCullough Skyway\nAbbottville, SD 41885-1526', 11, 'mittie.schoen', 23, 2, '2021-11-10 18:36:37', '2021-11-10 18:36:37', '2021-06-17 22:00:00', NULL, NULL),
(96, 5, 138, 'EMP00138', '7024 Aurore Branch Apt. 340\nKrisstad, GA 75405', 21, 'bethel.satterfield', 2, 12, '2021-11-10 18:36:39', '2021-11-10 18:36:39', '2021-03-06 22:00:00', NULL, NULL),
(97, 5, 139, 'EMP00139', '87169 Volkman Camp\nLake Nash, AR 23941', 25, 'flatley.ariel', 27, 9, '2021-11-10 18:36:40', '2021-11-10 18:36:40', '2020-11-15 22:00:00', NULL, NULL),
(98, 5, 140, 'EMP00140', '2556 Kihn Mall Apt. 865\nNew Daynemouth, NY 33602-1157', 13, 'ymarks', 21, 8, '2021-11-10 18:36:40', '2021-11-10 18:36:40', '2021-09-10 22:00:00', NULL, NULL),
(99, 5, 141, 'EMP00141', '268 Nader Mill Suite 604\nKatarinaville, OK 31077', 28, 'efeil', 16, 23, '2021-11-10 18:36:41', '2021-11-10 18:36:41', '2021-03-21 22:00:00', NULL, NULL),
(100, 5, 142, 'EMP00142', '56575 Freeman Manors\nGislasonberg, CA 56260-1082', 10, 'hansen.irma', 2, 10, '2021-11-10 18:36:41', '2021-11-10 18:36:41', '2021-07-19 22:00:00', NULL, NULL),
(101, 5, 143, 'EMP00143', '6737 Mann Walks\nCrooksville, LA 36446-2831', 33, 'katheryn.renner', 4, 8, '2021-11-10 18:36:41', '2021-11-10 18:36:41', '2021-08-19 22:00:00', NULL, NULL),
(102, 5, 144, 'EMP00144', '39806 Niko Skyway\nNorth Luna, PA 80395', 21, 'tre80', 22, 22, '2021-11-10 18:36:42', '2021-11-10 18:36:42', '2021-02-21 22:00:00', NULL, NULL),
(103, 6, 155, 'EMP00155', '265 Monahan Lakes\nAltenwerthshire, NY 98696', 49, 'mohr.gilda', 36, 20, '2021-11-10 18:36:50', '2021-11-10 18:36:50', '2021-05-24 22:00:00', NULL, NULL),
(104, 6, 156, 'EMP00156', '74716 Sunny Passage\nNorth Olen, WY 07468', 45, 'fstehr', 7, 13, '2021-11-10 18:36:50', '2021-11-10 18:36:50', '2021-10-30 22:00:00', NULL, NULL),
(105, 6, 157, 'EMP00157', '3663 Hoyt Ford Apt. 659\nHellerberg, NV 64646', 19, 'tsawayn', 2, 4, '2021-11-10 18:36:52', '2021-11-10 18:36:52', '2021-07-07 22:00:00', NULL, NULL),
(106, 6, 158, 'EMP00158', '567 Adriel Motorway\nHellerfurt, KS 89615', 18, 'agreenholt', 27, 12, '2021-11-10 18:36:53', '2021-11-10 18:36:53', '2021-05-24 22:00:00', NULL, NULL),
(107, 6, 159, 'EMP00159', '47170 Wilbert Locks Apt. 991\nHayliestad, VT 73066', 42, 'rosalia37', 5, 28, '2021-11-10 18:36:54', '2021-11-10 18:36:54', '2021-05-26 22:00:00', NULL, NULL),
(108, 6, 160, 'EMP00160', '8027 Mustafa Crossing Suite 050\nNew Dustinville, OH 18602', 31, 'jaylen.rowe', 20, 29, '2021-11-10 18:36:55', '2021-11-10 18:36:55', '2021-09-23 22:00:00', NULL, NULL),
(109, 6, 161, 'EMP00161', '143 Scottie Village Suite 061\nWehnerhaven, WV 04305-3400', 25, 'konopelski.ashlynn', 30, 26, '2021-11-10 18:36:58', '2021-11-10 18:36:58', '2021-06-08 22:00:00', NULL, NULL),
(110, 6, 162, 'EMP00162', '9211 Sammy Squares Apt. 139\nAnastasiaborough, IL 38724', 50, 'rkeebler', 26, 24, '2021-11-10 18:36:59', '2021-11-10 18:36:59', '2021-04-26 22:00:00', NULL, NULL),
(111, 6, 163, 'EMP00163', '334 Sporer Camp\nJademouth, CT 24929-5870', 24, 'gislason.kaylee', 25, 20, '2021-11-10 18:37:00', '2021-11-10 18:37:00', '2021-08-06 22:00:00', NULL, NULL),
(112, 6, 164, 'EMP00164', '86243 Maximilian Groves\nKubton, AK 64235-4194', 28, 'mdare', 16, 28, '2021-11-10 18:37:01', '2021-11-10 18:37:01', '2020-11-11 22:00:00', NULL, NULL),
(113, 6, 165, 'EMP00165', '39629 Joyce Corners\nVandervortville, NH 28294-1018', 38, 'karianne11', 32, 5, '2021-11-10 18:37:04', '2021-11-10 18:37:04', '2021-03-20 22:00:00', NULL, NULL),
(114, 6, 166, 'EMP00166', '197 Hahn Terrace\nPort Leliatown, NV 86796-9145', 17, 'spinka.sabryna', 13, 10, '2021-11-10 18:37:04', '2021-11-10 18:37:04', '2021-11-04 22:00:00', NULL, NULL),
(115, 6, 167, 'EMP00167', '24057 Abernathy Mountains Suite 070\nDooleytown, AL 81833', 42, 'aufderhar.maxime', 1, 15, '2021-11-10 18:37:05', '2021-11-10 18:37:05', '2021-02-18 22:00:00', NULL, NULL),
(116, 6, 168, 'EMP00168', '967 Jovan Mill\nNorth Louisaview, NC 16533', 39, 'heloise99', 18, 6, '2021-11-10 18:37:05', '2021-11-10 18:37:05', '2021-07-29 22:00:00', NULL, NULL),
(117, 6, 169, 'EMP00169', '174 Brandon Forks Apt. 581\nWillieborough, MT 88489', 28, 'ksauer', 34, 18, '2021-11-10 18:37:06', '2021-11-10 18:37:06', '2021-11-03 22:00:00', NULL, NULL),
(118, 6, 170, 'EMP00170', '8985 Feest Station\nAufderharborough, NM 95166', 32, 'omedhurst', 8, 18, '2021-11-10 18:37:07', '2021-11-10 18:37:07', '2021-08-26 22:00:00', NULL, NULL),
(119, 6, 171, 'EMP00171', '1050 Nolan Manor\nBrownton, KS 83746', 24, 'uschiller', 27, 12, '2021-11-10 18:37:07', '2021-11-10 18:37:07', '2021-05-01 22:00:00', NULL, NULL),
(120, 6, 172, 'EMP00172', '4456 Pagac Plaza\nAbshirestad, SC 06316', 16, 'fruecker', 23, 18, '2021-11-10 18:37:08', '2021-11-10 18:37:08', '2021-05-17 22:00:00', NULL, NULL),
(121, 6, 173, 'EMP00173', '63011 Cecilia Fields Suite 572\nNorth Huldaville, IL 48771', 40, 'leanne.stroman', 9, 17, '2021-11-10 18:37:08', '2021-11-10 18:37:08', '2021-09-14 22:00:00', NULL, NULL),
(122, 6, 174, 'EMP00174', '160 Langosh Plaza Apt. 017\nGretchenberg, MD 04055', 37, 'ethelyn.abernathy', 8, 24, '2021-11-10 18:37:09', '2021-11-10 18:37:09', '2021-10-31 22:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee_docs`
--

CREATE TABLE `employee_docs` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `filename` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `hashname` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `size` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_faqs`
--

CREATE TABLE `employee_faqs` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `employee_faq_category_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_faq_categories`
--

CREATE TABLE `employee_faq_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_faq_files`
--

CREATE TABLE `employee_faq_files` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `employee_faq_id` int(10) UNSIGNED NOT NULL,
  `filename` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `google_url` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hashname` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `size` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dropbox_link` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `external_link` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `external_link_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_leave_quotas`
--

CREATE TABLE `employee_leave_quotas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `leave_type_id` int(10) UNSIGNED NOT NULL,
  `no_of_leaves` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `employee_leave_quotas`
--

INSERT INTO `employee_leave_quotas` (`id`, `company_id`, `user_id`, `leave_type_id`, `no_of_leaves`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 4, 5, '2021-11-10 18:30:54', '2021-11-10 18:30:54'),
(2, 1, 2, 5, 5, '2021-11-10 18:30:54', '2021-11-10 18:30:54'),
(3, 1, 2, 6, 5, '2021-11-10 18:30:54', '2021-11-10 18:30:54'),
(4, 1, 3, 4, 5, '2021-11-10 18:30:56', '2021-11-10 18:30:56'),
(5, 1, 3, 5, 5, '2021-11-10 18:30:56', '2021-11-10 18:30:56'),
(6, 1, 3, 6, 5, '2021-11-10 18:30:56', '2021-11-10 18:30:56'),
(7, 1, 5, 4, 5, '2021-11-10 18:34:28', '2021-11-10 18:34:28'),
(8, 1, 5, 5, 5, '2021-11-10 18:34:28', '2021-11-10 18:34:28'),
(9, 1, 5, 6, 5, '2021-11-10 18:34:28', '2021-11-10 18:34:28'),
(10, 1, 6, 4, 5, '2021-11-10 18:34:30', '2021-11-10 18:34:30'),
(11, 1, 6, 5, 5, '2021-11-10 18:34:30', '2021-11-10 18:34:30'),
(12, 1, 6, 6, 5, '2021-11-10 18:34:30', '2021-11-10 18:34:30'),
(13, 1, 7, 4, 5, '2021-11-10 18:34:30', '2021-11-10 18:34:30'),
(14, 1, 7, 5, 5, '2021-11-10 18:34:31', '2021-11-10 18:34:31'),
(15, 1, 7, 6, 5, '2021-11-10 18:34:32', '2021-11-10 18:34:32'),
(16, 1, 8, 4, 5, '2021-11-10 18:34:33', '2021-11-10 18:34:33'),
(17, 1, 8, 5, 5, '2021-11-10 18:34:33', '2021-11-10 18:34:33'),
(18, 1, 8, 6, 5, '2021-11-10 18:34:34', '2021-11-10 18:34:34'),
(19, 1, 9, 4, 5, '2021-11-10 18:34:35', '2021-11-10 18:34:35'),
(20, 1, 9, 5, 5, '2021-11-10 18:34:35', '2021-11-10 18:34:35'),
(21, 1, 9, 6, 5, '2021-11-10 18:34:35', '2021-11-10 18:34:35'),
(22, 1, 10, 4, 5, '2021-11-10 18:34:36', '2021-11-10 18:34:36'),
(23, 1, 10, 5, 5, '2021-11-10 18:34:36', '2021-11-10 18:34:36'),
(24, 1, 10, 6, 5, '2021-11-10 18:34:37', '2021-11-10 18:34:37'),
(25, 1, 11, 4, 5, '2021-11-10 18:34:38', '2021-11-10 18:34:38'),
(26, 1, 11, 5, 5, '2021-11-10 18:34:38', '2021-11-10 18:34:38'),
(27, 1, 11, 6, 5, '2021-11-10 18:34:38', '2021-11-10 18:34:38'),
(28, 1, 12, 4, 5, '2021-11-10 18:34:38', '2021-11-10 18:34:38'),
(29, 1, 12, 5, 5, '2021-11-10 18:34:38', '2021-11-10 18:34:38'),
(30, 1, 12, 6, 5, '2021-11-10 18:34:39', '2021-11-10 18:34:39'),
(31, 1, 13, 4, 5, '2021-11-10 18:34:39', '2021-11-10 18:34:39'),
(32, 1, 13, 5, 5, '2021-11-10 18:34:39', '2021-11-10 18:34:39'),
(33, 1, 13, 6, 5, '2021-11-10 18:34:39', '2021-11-10 18:34:39'),
(34, 1, 14, 4, 5, '2021-11-10 18:34:39', '2021-11-10 18:34:39'),
(35, 1, 14, 5, 5, '2021-11-10 18:34:40', '2021-11-10 18:34:40'),
(36, 1, 14, 6, 5, '2021-11-10 18:34:40', '2021-11-10 18:34:40'),
(37, 1, 15, 4, 5, '2021-11-10 18:34:41', '2021-11-10 18:34:41'),
(38, 1, 15, 5, 5, '2021-11-10 18:34:41', '2021-11-10 18:34:41'),
(39, 1, 15, 6, 5, '2021-11-10 18:34:42', '2021-11-10 18:34:42'),
(40, 1, 16, 4, 5, '2021-11-10 18:34:42', '2021-11-10 18:34:42'),
(41, 1, 16, 5, 5, '2021-11-10 18:34:42', '2021-11-10 18:34:42'),
(42, 1, 16, 6, 5, '2021-11-10 18:34:42', '2021-11-10 18:34:42'),
(43, 1, 17, 4, 5, '2021-11-10 18:34:42', '2021-11-10 18:34:42'),
(44, 1, 17, 5, 5, '2021-11-10 18:34:42', '2021-11-10 18:34:42'),
(45, 1, 17, 6, 5, '2021-11-10 18:34:42', '2021-11-10 18:34:42'),
(46, 1, 18, 4, 5, '2021-11-10 18:34:43', '2021-11-10 18:34:43'),
(47, 1, 18, 5, 5, '2021-11-10 18:34:43', '2021-11-10 18:34:43'),
(48, 1, 18, 6, 5, '2021-11-10 18:34:43', '2021-11-10 18:34:43'),
(49, 1, 19, 4, 5, '2021-11-10 18:34:43', '2021-11-10 18:34:43'),
(50, 1, 19, 5, 5, '2021-11-10 18:34:43', '2021-11-10 18:34:43'),
(51, 1, 19, 6, 5, '2021-11-10 18:34:43', '2021-11-10 18:34:43'),
(52, 1, 20, 4, 5, '2021-11-10 18:34:43', '2021-11-10 18:34:43'),
(53, 1, 20, 5, 5, '2021-11-10 18:34:44', '2021-11-10 18:34:44'),
(54, 1, 20, 6, 5, '2021-11-10 18:34:44', '2021-11-10 18:34:44'),
(55, 1, 21, 4, 5, '2021-11-10 18:34:44', '2021-11-10 18:34:44'),
(56, 1, 21, 5, 5, '2021-11-10 18:34:45', '2021-11-10 18:34:45'),
(57, 1, 21, 6, 5, '2021-11-10 18:34:45', '2021-11-10 18:34:45'),
(58, 1, 22, 4, 5, '2021-11-10 18:34:46', '2021-11-10 18:34:46'),
(59, 1, 22, 5, 5, '2021-11-10 18:34:47', '2021-11-10 18:34:47'),
(60, 1, 22, 6, 5, '2021-11-10 18:34:48', '2021-11-10 18:34:48'),
(61, 1, 23, 4, 5, '2021-11-10 18:34:49', '2021-11-10 18:34:49'),
(62, 1, 23, 5, 5, '2021-11-10 18:34:49', '2021-11-10 18:34:49'),
(63, 1, 23, 6, 5, '2021-11-10 18:34:50', '2021-11-10 18:34:50'),
(64, 1, 24, 4, 5, '2021-11-10 18:34:51', '2021-11-10 18:34:51'),
(65, 1, 24, 5, 5, '2021-11-10 18:34:53', '2021-11-10 18:34:53'),
(66, 1, 24, 6, 5, '2021-11-10 18:34:53', '2021-11-10 18:34:53'),
(67, 2, 35, 7, 5, '2021-11-10 18:35:01', '2021-11-10 18:35:01'),
(68, 2, 35, 8, 5, '2021-11-10 18:35:01', '2021-11-10 18:35:01'),
(69, 2, 35, 9, 5, '2021-11-10 18:35:02', '2021-11-10 18:35:02'),
(70, 2, 36, 7, 5, '2021-11-10 18:35:02', '2021-11-10 18:35:02'),
(71, 2, 36, 8, 5, '2021-11-10 18:35:02', '2021-11-10 18:35:02'),
(72, 2, 36, 9, 5, '2021-11-10 18:35:02', '2021-11-10 18:35:02'),
(73, 2, 37, 7, 5, '2021-11-10 18:35:02', '2021-11-10 18:35:02'),
(74, 2, 37, 8, 5, '2021-11-10 18:35:02', '2021-11-10 18:35:02'),
(75, 2, 37, 9, 5, '2021-11-10 18:35:03', '2021-11-10 18:35:03'),
(76, 2, 38, 7, 5, '2021-11-10 18:35:03', '2021-11-10 18:35:03'),
(77, 2, 38, 8, 5, '2021-11-10 18:35:03', '2021-11-10 18:35:03'),
(78, 2, 38, 9, 5, '2021-11-10 18:35:03', '2021-11-10 18:35:03'),
(79, 2, 39, 7, 5, '2021-11-10 18:35:04', '2021-11-10 18:35:04'),
(80, 2, 39, 8, 5, '2021-11-10 18:35:04', '2021-11-10 18:35:04'),
(81, 2, 39, 9, 5, '2021-11-10 18:35:04', '2021-11-10 18:35:04'),
(82, 2, 40, 7, 5, '2021-11-10 18:35:04', '2021-11-10 18:35:04'),
(83, 2, 40, 8, 5, '2021-11-10 18:35:04', '2021-11-10 18:35:04'),
(84, 2, 40, 9, 5, '2021-11-10 18:35:04', '2021-11-10 18:35:04'),
(85, 2, 41, 7, 5, '2021-11-10 18:35:04', '2021-11-10 18:35:04'),
(86, 2, 41, 8, 5, '2021-11-10 18:35:04', '2021-11-10 18:35:04'),
(87, 2, 41, 9, 5, '2021-11-10 18:35:04', '2021-11-10 18:35:04'),
(88, 2, 42, 7, 5, '2021-11-10 18:35:05', '2021-11-10 18:35:05'),
(89, 2, 42, 8, 5, '2021-11-10 18:35:05', '2021-11-10 18:35:05'),
(90, 2, 42, 9, 5, '2021-11-10 18:35:05', '2021-11-10 18:35:05'),
(91, 2, 43, 7, 5, '2021-11-10 18:35:05', '2021-11-10 18:35:05'),
(92, 2, 43, 8, 5, '2021-11-10 18:35:05', '2021-11-10 18:35:05'),
(93, 2, 43, 9, 5, '2021-11-10 18:35:05', '2021-11-10 18:35:05'),
(94, 2, 44, 7, 5, '2021-11-10 18:35:06', '2021-11-10 18:35:06'),
(95, 2, 44, 8, 5, '2021-11-10 18:35:06', '2021-11-10 18:35:06'),
(96, 2, 44, 9, 5, '2021-11-10 18:35:06', '2021-11-10 18:35:06'),
(97, 2, 45, 7, 5, '2021-11-10 18:35:08', '2021-11-10 18:35:08'),
(98, 2, 45, 8, 5, '2021-11-10 18:35:08', '2021-11-10 18:35:08'),
(99, 2, 45, 9, 5, '2021-11-10 18:35:09', '2021-11-10 18:35:09'),
(100, 2, 46, 7, 5, '2021-11-10 18:35:09', '2021-11-10 18:35:09'),
(101, 2, 46, 8, 5, '2021-11-10 18:35:09', '2021-11-10 18:35:09'),
(102, 2, 46, 9, 5, '2021-11-10 18:35:09', '2021-11-10 18:35:09'),
(103, 2, 47, 7, 5, '2021-11-10 18:35:10', '2021-11-10 18:35:10'),
(104, 2, 47, 8, 5, '2021-11-10 18:35:10', '2021-11-10 18:35:10'),
(105, 2, 47, 9, 5, '2021-11-10 18:35:10', '2021-11-10 18:35:10'),
(106, 2, 48, 7, 5, '2021-11-10 18:35:10', '2021-11-10 18:35:10'),
(107, 2, 48, 8, 5, '2021-11-10 18:35:10', '2021-11-10 18:35:10'),
(108, 2, 48, 9, 5, '2021-11-10 18:35:10', '2021-11-10 18:35:10'),
(109, 2, 49, 7, 5, '2021-11-10 18:35:11', '2021-11-10 18:35:11'),
(110, 2, 49, 8, 5, '2021-11-10 18:35:11', '2021-11-10 18:35:11'),
(111, 2, 49, 9, 5, '2021-11-10 18:35:11', '2021-11-10 18:35:11'),
(112, 2, 50, 7, 5, '2021-11-10 18:35:11', '2021-11-10 18:35:11'),
(113, 2, 50, 8, 5, '2021-11-10 18:35:11', '2021-11-10 18:35:11'),
(114, 2, 50, 9, 5, '2021-11-10 18:35:12', '2021-11-10 18:35:12'),
(115, 2, 51, 7, 5, '2021-11-10 18:35:13', '2021-11-10 18:35:13'),
(116, 2, 51, 8, 5, '2021-11-10 18:35:13', '2021-11-10 18:35:13'),
(117, 2, 51, 9, 5, '2021-11-10 18:35:13', '2021-11-10 18:35:13'),
(118, 2, 52, 7, 5, '2021-11-10 18:35:14', '2021-11-10 18:35:14'),
(119, 2, 52, 8, 5, '2021-11-10 18:35:15', '2021-11-10 18:35:15'),
(120, 2, 52, 9, 5, '2021-11-10 18:35:15', '2021-11-10 18:35:15'),
(121, 2, 53, 7, 5, '2021-11-10 18:35:16', '2021-11-10 18:35:16'),
(122, 2, 53, 8, 5, '2021-11-10 18:35:16', '2021-11-10 18:35:16'),
(123, 2, 53, 9, 5, '2021-11-10 18:35:16', '2021-11-10 18:35:16'),
(124, 2, 54, 7, 5, '2021-11-10 18:35:17', '2021-11-10 18:35:17'),
(125, 2, 54, 8, 5, '2021-11-10 18:35:17', '2021-11-10 18:35:17'),
(126, 2, 54, 9, 5, '2021-11-10 18:35:17', '2021-11-10 18:35:17'),
(127, 3, 65, 10, 5, '2021-11-10 18:35:29', '2021-11-10 18:35:29'),
(128, 3, 65, 11, 5, '2021-11-10 18:35:29', '2021-11-10 18:35:29'),
(129, 3, 65, 12, 5, '2021-11-10 18:35:29', '2021-11-10 18:35:29'),
(130, 3, 66, 10, 5, '2021-11-10 18:35:30', '2021-11-10 18:35:30'),
(131, 3, 66, 11, 5, '2021-11-10 18:35:30', '2021-11-10 18:35:30'),
(132, 3, 66, 12, 5, '2021-11-10 18:35:30', '2021-11-10 18:35:30'),
(133, 3, 67, 10, 5, '2021-11-10 18:35:31', '2021-11-10 18:35:31'),
(134, 3, 67, 11, 5, '2021-11-10 18:35:31', '2021-11-10 18:35:31'),
(135, 3, 67, 12, 5, '2021-11-10 18:35:31', '2021-11-10 18:35:31'),
(136, 3, 68, 10, 5, '2021-11-10 18:35:31', '2021-11-10 18:35:31'),
(137, 3, 68, 11, 5, '2021-11-10 18:35:31', '2021-11-10 18:35:31'),
(138, 3, 68, 12, 5, '2021-11-10 18:35:31', '2021-11-10 18:35:31'),
(139, 3, 69, 10, 5, '2021-11-10 18:35:32', '2021-11-10 18:35:32'),
(140, 3, 69, 11, 5, '2021-11-10 18:35:32', '2021-11-10 18:35:32'),
(141, 3, 69, 12, 5, '2021-11-10 18:35:32', '2021-11-10 18:35:32'),
(142, 3, 70, 10, 5, '2021-11-10 18:35:32', '2021-11-10 18:35:32'),
(143, 3, 70, 11, 5, '2021-11-10 18:35:32', '2021-11-10 18:35:32'),
(144, 3, 70, 12, 5, '2021-11-10 18:35:33', '2021-11-10 18:35:33'),
(145, 3, 71, 10, 5, '2021-11-10 18:35:34', '2021-11-10 18:35:34'),
(146, 3, 71, 11, 5, '2021-11-10 18:35:34', '2021-11-10 18:35:34'),
(147, 3, 71, 12, 5, '2021-11-10 18:35:34', '2021-11-10 18:35:34'),
(148, 3, 72, 10, 5, '2021-11-10 18:35:35', '2021-11-10 18:35:35'),
(149, 3, 72, 11, 5, '2021-11-10 18:35:35', '2021-11-10 18:35:35'),
(150, 3, 72, 12, 5, '2021-11-10 18:35:35', '2021-11-10 18:35:35'),
(151, 3, 73, 10, 5, '2021-11-10 18:35:35', '2021-11-10 18:35:35'),
(152, 3, 73, 11, 5, '2021-11-10 18:35:35', '2021-11-10 18:35:35'),
(153, 3, 73, 12, 5, '2021-11-10 18:35:36', '2021-11-10 18:35:36'),
(154, 3, 74, 10, 5, '2021-11-10 18:35:36', '2021-11-10 18:35:36'),
(155, 3, 74, 11, 5, '2021-11-10 18:35:36', '2021-11-10 18:35:36'),
(156, 3, 74, 12, 5, '2021-11-10 18:35:36', '2021-11-10 18:35:36'),
(157, 3, 75, 10, 5, '2021-11-10 18:35:37', '2021-11-10 18:35:37'),
(158, 3, 75, 11, 5, '2021-11-10 18:35:37', '2021-11-10 18:35:37'),
(159, 3, 75, 12, 5, '2021-11-10 18:35:37', '2021-11-10 18:35:37'),
(160, 3, 76, 10, 5, '2021-11-10 18:35:37', '2021-11-10 18:35:37'),
(161, 3, 76, 11, 5, '2021-11-10 18:35:37', '2021-11-10 18:35:37'),
(162, 3, 76, 12, 5, '2021-11-10 18:35:37', '2021-11-10 18:35:37'),
(163, 3, 77, 10, 5, '2021-11-10 18:35:37', '2021-11-10 18:35:37'),
(164, 3, 77, 11, 5, '2021-11-10 18:35:37', '2021-11-10 18:35:37'),
(165, 3, 77, 12, 5, '2021-11-10 18:35:37', '2021-11-10 18:35:37'),
(166, 3, 78, 10, 5, '2021-11-10 18:35:38', '2021-11-10 18:35:38'),
(167, 3, 78, 11, 5, '2021-11-10 18:35:38', '2021-11-10 18:35:38'),
(168, 3, 78, 12, 5, '2021-11-10 18:35:38', '2021-11-10 18:35:38'),
(169, 3, 79, 10, 5, '2021-11-10 18:35:38', '2021-11-10 18:35:38'),
(170, 3, 79, 11, 5, '2021-11-10 18:35:38', '2021-11-10 18:35:38'),
(171, 3, 79, 12, 5, '2021-11-10 18:35:38', '2021-11-10 18:35:38'),
(172, 3, 80, 10, 5, '2021-11-10 18:35:38', '2021-11-10 18:35:38'),
(173, 3, 80, 11, 5, '2021-11-10 18:35:38', '2021-11-10 18:35:38'),
(174, 3, 80, 12, 5, '2021-11-10 18:35:38', '2021-11-10 18:35:38'),
(175, 3, 81, 10, 5, '2021-11-10 18:35:39', '2021-11-10 18:35:39'),
(176, 3, 81, 11, 5, '2021-11-10 18:35:39', '2021-11-10 18:35:39'),
(177, 3, 81, 12, 5, '2021-11-10 18:35:39', '2021-11-10 18:35:39'),
(178, 3, 82, 10, 5, '2021-11-10 18:35:40', '2021-11-10 18:35:40'),
(179, 3, 82, 11, 5, '2021-11-10 18:35:40', '2021-11-10 18:35:40'),
(180, 3, 82, 12, 5, '2021-11-10 18:35:40', '2021-11-10 18:35:40'),
(181, 3, 83, 10, 5, '2021-11-10 18:35:40', '2021-11-10 18:35:40'),
(182, 3, 83, 11, 5, '2021-11-10 18:35:40', '2021-11-10 18:35:40'),
(183, 3, 83, 12, 5, '2021-11-10 18:35:40', '2021-11-10 18:35:40'),
(184, 3, 84, 10, 5, '2021-11-10 18:35:41', '2021-11-10 18:35:41'),
(185, 3, 84, 11, 5, '2021-11-10 18:35:41', '2021-11-10 18:35:41'),
(186, 3, 84, 12, 5, '2021-11-10 18:35:41', '2021-11-10 18:35:41'),
(187, 4, 95, 13, 5, '2021-11-10 18:35:55', '2021-11-10 18:35:55'),
(188, 4, 95, 14, 5, '2021-11-10 18:35:55', '2021-11-10 18:35:55'),
(189, 4, 95, 15, 5, '2021-11-10 18:35:55', '2021-11-10 18:35:55'),
(190, 4, 96, 13, 5, '2021-11-10 18:35:58', '2021-11-10 18:35:58'),
(191, 4, 96, 14, 5, '2021-11-10 18:35:58', '2021-11-10 18:35:58'),
(192, 4, 96, 15, 5, '2021-11-10 18:35:59', '2021-11-10 18:35:59'),
(193, 4, 97, 13, 5, '2021-11-10 18:35:59', '2021-11-10 18:35:59'),
(194, 4, 97, 14, 5, '2021-11-10 18:35:59', '2021-11-10 18:35:59'),
(195, 4, 97, 15, 5, '2021-11-10 18:35:59', '2021-11-10 18:35:59'),
(196, 4, 98, 13, 5, '2021-11-10 18:35:59', '2021-11-10 18:35:59'),
(197, 4, 98, 14, 5, '2021-11-10 18:35:59', '2021-11-10 18:35:59'),
(198, 4, 98, 15, 5, '2021-11-10 18:35:59', '2021-11-10 18:35:59'),
(199, 4, 99, 13, 5, '2021-11-10 18:36:00', '2021-11-10 18:36:00'),
(200, 4, 99, 14, 5, '2021-11-10 18:36:00', '2021-11-10 18:36:00'),
(201, 4, 99, 15, 5, '2021-11-10 18:36:00', '2021-11-10 18:36:00'),
(202, 4, 100, 13, 5, '2021-11-10 18:36:00', '2021-11-10 18:36:00'),
(203, 4, 100, 14, 5, '2021-11-10 18:36:00', '2021-11-10 18:36:00'),
(204, 4, 100, 15, 5, '2021-11-10 18:36:00', '2021-11-10 18:36:00'),
(205, 4, 101, 13, 5, '2021-11-10 18:36:00', '2021-11-10 18:36:00'),
(206, 4, 101, 14, 5, '2021-11-10 18:36:00', '2021-11-10 18:36:00'),
(207, 4, 101, 15, 5, '2021-11-10 18:36:01', '2021-11-10 18:36:01'),
(208, 4, 102, 13, 5, '2021-11-10 18:36:01', '2021-11-10 18:36:01'),
(209, 4, 102, 14, 5, '2021-11-10 18:36:01', '2021-11-10 18:36:01'),
(210, 4, 102, 15, 5, '2021-11-10 18:36:01', '2021-11-10 18:36:01'),
(211, 4, 103, 13, 5, '2021-11-10 18:36:02', '2021-11-10 18:36:02'),
(212, 4, 103, 14, 5, '2021-11-10 18:36:02', '2021-11-10 18:36:02'),
(213, 4, 103, 15, 5, '2021-11-10 18:36:03', '2021-11-10 18:36:03'),
(214, 4, 104, 13, 5, '2021-11-10 18:36:03', '2021-11-10 18:36:03'),
(215, 4, 104, 14, 5, '2021-11-10 18:36:03', '2021-11-10 18:36:03'),
(216, 4, 104, 15, 5, '2021-11-10 18:36:04', '2021-11-10 18:36:04'),
(217, 4, 105, 13, 5, '2021-11-10 18:36:06', '2021-11-10 18:36:06'),
(218, 4, 105, 14, 5, '2021-11-10 18:36:07', '2021-11-10 18:36:07'),
(219, 4, 105, 15, 5, '2021-11-10 18:36:07', '2021-11-10 18:36:07'),
(220, 4, 106, 13, 5, '2021-11-10 18:36:08', '2021-11-10 18:36:08'),
(221, 4, 106, 14, 5, '2021-11-10 18:36:08', '2021-11-10 18:36:08'),
(222, 4, 106, 15, 5, '2021-11-10 18:36:08', '2021-11-10 18:36:08'),
(223, 4, 107, 13, 5, '2021-11-10 18:36:09', '2021-11-10 18:36:09'),
(224, 4, 107, 14, 5, '2021-11-10 18:36:09', '2021-11-10 18:36:09'),
(225, 4, 107, 15, 5, '2021-11-10 18:36:10', '2021-11-10 18:36:10'),
(226, 4, 108, 13, 5, '2021-11-10 18:36:10', '2021-11-10 18:36:10'),
(227, 4, 108, 14, 5, '2021-11-10 18:36:10', '2021-11-10 18:36:10'),
(228, 4, 108, 15, 5, '2021-11-10 18:36:10', '2021-11-10 18:36:10'),
(229, 4, 109, 13, 5, '2021-11-10 18:36:11', '2021-11-10 18:36:11'),
(230, 4, 109, 14, 5, '2021-11-10 18:36:11', '2021-11-10 18:36:11'),
(231, 4, 109, 15, 5, '2021-11-10 18:36:11', '2021-11-10 18:36:11'),
(232, 4, 110, 13, 5, '2021-11-10 18:36:11', '2021-11-10 18:36:11'),
(233, 4, 110, 14, 5, '2021-11-10 18:36:12', '2021-11-10 18:36:12'),
(234, 4, 110, 15, 5, '2021-11-10 18:36:12', '2021-11-10 18:36:12'),
(235, 4, 111, 13, 5, '2021-11-10 18:36:12', '2021-11-10 18:36:12'),
(236, 4, 111, 14, 5, '2021-11-10 18:36:12', '2021-11-10 18:36:12'),
(237, 4, 111, 15, 5, '2021-11-10 18:36:13', '2021-11-10 18:36:13'),
(238, 4, 112, 13, 5, '2021-11-10 18:36:13', '2021-11-10 18:36:13'),
(239, 4, 112, 14, 5, '2021-11-10 18:36:13', '2021-11-10 18:36:13'),
(240, 4, 112, 15, 5, '2021-11-10 18:36:13', '2021-11-10 18:36:13'),
(241, 4, 113, 13, 5, '2021-11-10 18:36:13', '2021-11-10 18:36:13'),
(242, 4, 113, 14, 5, '2021-11-10 18:36:13', '2021-11-10 18:36:13'),
(243, 4, 113, 15, 5, '2021-11-10 18:36:13', '2021-11-10 18:36:13'),
(244, 4, 114, 13, 5, '2021-11-10 18:36:14', '2021-11-10 18:36:14'),
(245, 4, 114, 14, 5, '2021-11-10 18:36:14', '2021-11-10 18:36:14'),
(246, 4, 114, 15, 5, '2021-11-10 18:36:14', '2021-11-10 18:36:14'),
(247, 5, 125, 16, 5, '2021-11-10 18:36:27', '2021-11-10 18:36:27'),
(248, 5, 125, 17, 5, '2021-11-10 18:36:27', '2021-11-10 18:36:27'),
(249, 5, 125, 18, 5, '2021-11-10 18:36:27', '2021-11-10 18:36:27'),
(250, 5, 126, 16, 5, '2021-11-10 18:36:27', '2021-11-10 18:36:27'),
(251, 5, 126, 17, 5, '2021-11-10 18:36:27', '2021-11-10 18:36:27'),
(252, 5, 126, 18, 5, '2021-11-10 18:36:27', '2021-11-10 18:36:27'),
(253, 5, 127, 16, 5, '2021-11-10 18:36:28', '2021-11-10 18:36:28'),
(254, 5, 127, 17, 5, '2021-11-10 18:36:28', '2021-11-10 18:36:28'),
(255, 5, 127, 18, 5, '2021-11-10 18:36:28', '2021-11-10 18:36:28'),
(256, 5, 128, 16, 5, '2021-11-10 18:36:28', '2021-11-10 18:36:28'),
(257, 5, 128, 17, 5, '2021-11-10 18:36:28', '2021-11-10 18:36:28'),
(258, 5, 128, 18, 5, '2021-11-10 18:36:29', '2021-11-10 18:36:29'),
(259, 5, 129, 16, 5, '2021-11-10 18:36:29', '2021-11-10 18:36:29'),
(260, 5, 129, 17, 5, '2021-11-10 18:36:29', '2021-11-10 18:36:29'),
(261, 5, 129, 18, 5, '2021-11-10 18:36:29', '2021-11-10 18:36:29'),
(262, 5, 130, 16, 5, '2021-11-10 18:36:29', '2021-11-10 18:36:29'),
(263, 5, 130, 17, 5, '2021-11-10 18:36:30', '2021-11-10 18:36:30'),
(264, 5, 130, 18, 5, '2021-11-10 18:36:30', '2021-11-10 18:36:30'),
(265, 5, 131, 16, 5, '2021-11-10 18:36:30', '2021-11-10 18:36:30'),
(266, 5, 131, 17, 5, '2021-11-10 18:36:31', '2021-11-10 18:36:31'),
(267, 5, 131, 18, 5, '2021-11-10 18:36:31', '2021-11-10 18:36:31'),
(268, 5, 132, 16, 5, '2021-11-10 18:36:33', '2021-11-10 18:36:33'),
(269, 5, 132, 17, 5, '2021-11-10 18:36:33', '2021-11-10 18:36:33'),
(270, 5, 132, 18, 5, '2021-11-10 18:36:33', '2021-11-10 18:36:33'),
(271, 5, 133, 16, 5, '2021-11-10 18:36:33', '2021-11-10 18:36:33'),
(272, 5, 133, 17, 5, '2021-11-10 18:36:33', '2021-11-10 18:36:33'),
(273, 5, 133, 18, 5, '2021-11-10 18:36:33', '2021-11-10 18:36:33'),
(274, 5, 134, 16, 5, '2021-11-10 18:36:34', '2021-11-10 18:36:34'),
(275, 5, 134, 17, 5, '2021-11-10 18:36:34', '2021-11-10 18:36:34'),
(276, 5, 134, 18, 5, '2021-11-10 18:36:35', '2021-11-10 18:36:35'),
(277, 5, 135, 16, 5, '2021-11-10 18:36:36', '2021-11-10 18:36:36'),
(278, 5, 135, 17, 5, '2021-11-10 18:36:36', '2021-11-10 18:36:36'),
(279, 5, 135, 18, 5, '2021-11-10 18:36:36', '2021-11-10 18:36:36'),
(280, 5, 136, 16, 5, '2021-11-10 18:36:37', '2021-11-10 18:36:37'),
(281, 5, 136, 17, 5, '2021-11-10 18:36:37', '2021-11-10 18:36:37'),
(282, 5, 136, 18, 5, '2021-11-10 18:36:37', '2021-11-10 18:36:37'),
(283, 5, 137, 16, 5, '2021-11-10 18:36:37', '2021-11-10 18:36:37'),
(284, 5, 137, 17, 5, '2021-11-10 18:36:38', '2021-11-10 18:36:38'),
(285, 5, 137, 18, 5, '2021-11-10 18:36:38', '2021-11-10 18:36:38'),
(286, 5, 138, 16, 5, '2021-11-10 18:36:39', '2021-11-10 18:36:39'),
(287, 5, 138, 17, 5, '2021-11-10 18:36:39', '2021-11-10 18:36:39'),
(288, 5, 138, 18, 5, '2021-11-10 18:36:39', '2021-11-10 18:36:39'),
(289, 5, 139, 16, 5, '2021-11-10 18:36:40', '2021-11-10 18:36:40'),
(290, 5, 139, 17, 5, '2021-11-10 18:36:40', '2021-11-10 18:36:40'),
(291, 5, 139, 18, 5, '2021-11-10 18:36:40', '2021-11-10 18:36:40'),
(292, 5, 140, 16, 5, '2021-11-10 18:36:40', '2021-11-10 18:36:40'),
(293, 5, 140, 17, 5, '2021-11-10 18:36:40', '2021-11-10 18:36:40'),
(294, 5, 140, 18, 5, '2021-11-10 18:36:40', '2021-11-10 18:36:40'),
(295, 5, 141, 16, 5, '2021-11-10 18:36:41', '2021-11-10 18:36:41'),
(296, 5, 141, 17, 5, '2021-11-10 18:36:41', '2021-11-10 18:36:41'),
(297, 5, 141, 18, 5, '2021-11-10 18:36:41', '2021-11-10 18:36:41'),
(298, 5, 142, 16, 5, '2021-11-10 18:36:41', '2021-11-10 18:36:41'),
(299, 5, 142, 17, 5, '2021-11-10 18:36:41', '2021-11-10 18:36:41'),
(300, 5, 142, 18, 5, '2021-11-10 18:36:41', '2021-11-10 18:36:41'),
(301, 5, 143, 16, 5, '2021-11-10 18:36:41', '2021-11-10 18:36:41'),
(302, 5, 143, 17, 5, '2021-11-10 18:36:41', '2021-11-10 18:36:41'),
(303, 5, 143, 18, 5, '2021-11-10 18:36:42', '2021-11-10 18:36:42'),
(304, 5, 144, 16, 5, '2021-11-10 18:36:42', '2021-11-10 18:36:42'),
(305, 5, 144, 17, 5, '2021-11-10 18:36:42', '2021-11-10 18:36:42'),
(306, 5, 144, 18, 5, '2021-11-10 18:36:42', '2021-11-10 18:36:42'),
(307, 6, 155, 19, 5, '2021-11-10 18:36:50', '2021-11-10 18:36:50'),
(308, 6, 155, 20, 5, '2021-11-10 18:36:50', '2021-11-10 18:36:50'),
(309, 6, 155, 21, 5, '2021-11-10 18:36:50', '2021-11-10 18:36:50'),
(310, 6, 156, 19, 5, '2021-11-10 18:36:51', '2021-11-10 18:36:51'),
(311, 6, 156, 20, 5, '2021-11-10 18:36:51', '2021-11-10 18:36:51'),
(312, 6, 156, 21, 5, '2021-11-10 18:36:51', '2021-11-10 18:36:51'),
(313, 6, 157, 19, 5, '2021-11-10 18:36:52', '2021-11-10 18:36:52'),
(314, 6, 157, 20, 5, '2021-11-10 18:36:52', '2021-11-10 18:36:52'),
(315, 6, 157, 21, 5, '2021-11-10 18:36:52', '2021-11-10 18:36:52'),
(316, 6, 158, 19, 5, '2021-11-10 18:36:53', '2021-11-10 18:36:53'),
(317, 6, 158, 20, 5, '2021-11-10 18:36:53', '2021-11-10 18:36:53'),
(318, 6, 158, 21, 5, '2021-11-10 18:36:53', '2021-11-10 18:36:53'),
(319, 6, 159, 19, 5, '2021-11-10 18:36:54', '2021-11-10 18:36:54'),
(320, 6, 159, 20, 5, '2021-11-10 18:36:55', '2021-11-10 18:36:55'),
(321, 6, 159, 21, 5, '2021-11-10 18:36:55', '2021-11-10 18:36:55'),
(322, 6, 160, 19, 5, '2021-11-10 18:36:56', '2021-11-10 18:36:56'),
(323, 6, 160, 20, 5, '2021-11-10 18:36:56', '2021-11-10 18:36:56'),
(324, 6, 160, 21, 5, '2021-11-10 18:36:56', '2021-11-10 18:36:56'),
(325, 6, 161, 19, 5, '2021-11-10 18:36:58', '2021-11-10 18:36:58'),
(326, 6, 161, 20, 5, '2021-11-10 18:36:59', '2021-11-10 18:36:59'),
(327, 6, 161, 21, 5, '2021-11-10 18:36:59', '2021-11-10 18:36:59'),
(328, 6, 162, 19, 5, '2021-11-10 18:36:59', '2021-11-10 18:36:59'),
(329, 6, 162, 20, 5, '2021-11-10 18:37:00', '2021-11-10 18:37:00'),
(330, 6, 162, 21, 5, '2021-11-10 18:37:00', '2021-11-10 18:37:00'),
(331, 6, 163, 19, 5, '2021-11-10 18:37:01', '2021-11-10 18:37:01'),
(332, 6, 163, 20, 5, '2021-11-10 18:37:01', '2021-11-10 18:37:01'),
(333, 6, 163, 21, 5, '2021-11-10 18:37:01', '2021-11-10 18:37:01'),
(334, 6, 164, 19, 5, '2021-11-10 18:37:01', '2021-11-10 18:37:01'),
(335, 6, 164, 20, 5, '2021-11-10 18:37:01', '2021-11-10 18:37:01'),
(336, 6, 164, 21, 5, '2021-11-10 18:37:02', '2021-11-10 18:37:02'),
(337, 6, 165, 19, 5, '2021-11-10 18:37:04', '2021-11-10 18:37:04'),
(338, 6, 165, 20, 5, '2021-11-10 18:37:04', '2021-11-10 18:37:04'),
(339, 6, 165, 21, 5, '2021-11-10 18:37:04', '2021-11-10 18:37:04'),
(340, 6, 166, 19, 5, '2021-11-10 18:37:04', '2021-11-10 18:37:04'),
(341, 6, 166, 20, 5, '2021-11-10 18:37:04', '2021-11-10 18:37:04'),
(342, 6, 166, 21, 5, '2021-11-10 18:37:04', '2021-11-10 18:37:04'),
(343, 6, 167, 19, 5, '2021-11-10 18:37:05', '2021-11-10 18:37:05'),
(344, 6, 167, 20, 5, '2021-11-10 18:37:05', '2021-11-10 18:37:05'),
(345, 6, 167, 21, 5, '2021-11-10 18:37:05', '2021-11-10 18:37:05'),
(346, 6, 168, 19, 5, '2021-11-10 18:37:06', '2021-11-10 18:37:06'),
(347, 6, 168, 20, 5, '2021-11-10 18:37:06', '2021-11-10 18:37:06'),
(348, 6, 168, 21, 5, '2021-11-10 18:37:06', '2021-11-10 18:37:06'),
(349, 6, 169, 19, 5, '2021-11-10 18:37:06', '2021-11-10 18:37:06'),
(350, 6, 169, 20, 5, '2021-11-10 18:37:06', '2021-11-10 18:37:06'),
(351, 6, 169, 21, 5, '2021-11-10 18:37:06', '2021-11-10 18:37:06'),
(352, 6, 170, 19, 5, '2021-11-10 18:37:07', '2021-11-10 18:37:07'),
(353, 6, 170, 20, 5, '2021-11-10 18:37:07', '2021-11-10 18:37:07'),
(354, 6, 170, 21, 5, '2021-11-10 18:37:07', '2021-11-10 18:37:07'),
(355, 6, 171, 19, 5, '2021-11-10 18:37:07', '2021-11-10 18:37:07'),
(356, 6, 171, 20, 5, '2021-11-10 18:37:07', '2021-11-10 18:37:07'),
(357, 6, 171, 21, 5, '2021-11-10 18:37:08', '2021-11-10 18:37:08'),
(358, 6, 172, 19, 5, '2021-11-10 18:37:08', '2021-11-10 18:37:08'),
(359, 6, 172, 20, 5, '2021-11-10 18:37:08', '2021-11-10 18:37:08'),
(360, 6, 172, 21, 5, '2021-11-10 18:37:08', '2021-11-10 18:37:08'),
(361, 6, 173, 19, 5, '2021-11-10 18:37:08', '2021-11-10 18:37:08'),
(362, 6, 173, 20, 5, '2021-11-10 18:37:09', '2021-11-10 18:37:09'),
(363, 6, 173, 21, 5, '2021-11-10 18:37:09', '2021-11-10 18:37:09'),
(364, 6, 174, 19, 5, '2021-11-10 18:37:09', '2021-11-10 18:37:09'),
(365, 6, 174, 20, 5, '2021-11-10 18:37:09', '2021-11-10 18:37:09'),
(366, 6, 174, 21, 5, '2021-11-10 18:37:10', '2021-11-10 18:37:10');

-- --------------------------------------------------------

--
-- Table structure for table `employee_skills`
--

CREATE TABLE `employee_skills` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `skill_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_teams`
--

CREATE TABLE `employee_teams` (
  `id` int(10) UNSIGNED NOT NULL,
  `team_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `estimates`
--

CREATE TABLE `estimates` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `estimate_number` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `valid_till` date NOT NULL,
  `sub_total` double(16,2) NOT NULL,
  `total` double(16,2) NOT NULL,
  `currency_id` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('declined','accepted','waiting','sent','draft','canceled') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'waiting',
  `note` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `discount` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `discount_type` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `send_status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `estimate_items`
--

CREATE TABLE `estimate_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `estimate_id` int(10) UNSIGNED NOT NULL,
  `item_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `item_summary` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` enum('item','discount','tax') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'item',
  `quantity` double(16,2) NOT NULL,
  `unit_price` double(16,2) NOT NULL,
  `amount` double(16,2) NOT NULL,
  `taxes` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `hsn_sac_code` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `event_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `label_color` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `where` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `start_date_time` datetime NOT NULL,
  `end_date_time` datetime NOT NULL,
  `repeat` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `repeat_every` int(11) DEFAULT NULL,
  `repeat_cycles` int(11) DEFAULT NULL,
  `repeat_type` enum('day','week','month','year') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'day',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `event_type_id` int(10) UNSIGNED DEFAULT NULL,
  `event_unique_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_attendees`
--

CREATE TABLE `event_attendees` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `event_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_categories`
--

CREATE TABLE `event_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `category_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_types`
--

CREATE TABLE `event_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `item_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `purchase_date` date NOT NULL,
  `purchase_from` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` double(8,2) NOT NULL,
  `currency_id` int(10) UNSIGNED NOT NULL,
  `project_id` int(10) UNSIGNED DEFAULT NULL,
  `bill` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `can_claim` tinyint(1) NOT NULL DEFAULT 1,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `expenses_recurring_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses_category`
--

CREATE TABLE `expenses_category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `category_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses_category_roles`
--

CREATE TABLE `expenses_category_roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `expenses_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses_recurring`
--

CREATE TABLE `expenses_recurring` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `currency_id` int(10) UNSIGNED DEFAULT NULL,
  `project_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `item_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `day_of_month` int(11) DEFAULT 1,
  `day_of_week` int(11) DEFAULT 1,
  `payment_method` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rotation` enum('monthly','weekly','bi-weekly','quarterly','half-yearly','annually','daily') COLLATE utf8_unicode_ci NOT NULL,
  `billing_cycle` int(11) DEFAULT NULL,
  `unlimited_recurring` tinyint(1) NOT NULL DEFAULT 0,
  `price` double NOT NULL,
  `bill` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8_unicode_ci NOT NULL,
  `queue` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `faq_category_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faq_categories`
--

CREATE TABLE `faq_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faq_files`
--

CREATE TABLE `faq_files` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `faq_id` int(10) UNSIGNED NOT NULL,
  `filename` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `google_url` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hashname` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `size` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dropbox_link` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `external_link` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `external_link_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `id` int(10) UNSIGNED NOT NULL,
  `language_setting_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` enum('image','icon','task','bills','team','apps') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'image',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `front_feature_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `features`
--

INSERT INTO `features` (`id`, `language_setting_id`, `title`, `description`, `image`, `icon`, `type`, `created_at`, `updated_at`, `front_feature_id`) VALUES
(1, NULL, 'Meet Your Business Needs', '<p>Manage your projects and your talent in a single system, resulting in empowered teams, satisfied clients, and increased profitability.</p><ul class=\"list1 border-top pt-5 mt-5\">\r\n                            <li class=\"mb-3\">\r\n                                Keep a track of all your projects in most simple way.\r\n                            </li>\r\n                            <li class=\"mb-3\">\r\n                                Assign tasks to project members and track the status.\r\n                            </li>\r\n                            <li class=\"mb-3\">\r\n                                Add members to your projects and keep them in sync  with the progress.\r\n                            </li>\r\n                        </ul>', NULL, NULL, 'image', '2021-11-10 18:29:59', '2021-11-10 18:29:59', NULL),
(2, NULL, 'Analyse Your Workflow', '<p>Reports section to analyse what\'s working and what\'s not for your business</p><ul class=\"list1 border-top pt-5 mt-5\">\r\n                            <li class=\"mb-3\">\r\n                                It Shows how much you earned and how much you spent.\r\n                            </li>\r\n                            <li class=\"mb-3\">\r\n                                Tiket report shows you Open vs Closed tickets.\r\n                            </li>\r\n                            <li class=\"mb-3\">\r\n                                It creates task report to track completed vs pending tasks.\r\n                            </li>\r\n                        </ul>', NULL, NULL, 'image', '2021-11-10 18:29:59', '2021-11-10 18:29:59', NULL),
(3, NULL, 'Manage your support tickets efficiently', '<p>Whether someone\'s internet is not working, someone is facing issue with housekeeping or need something regarding their work they can raise a ticket for all their problems.</p><ul class=\"list1 border-top pt-5 mt-5\"><li class=\"mb-3\">Admin can assign the tickets to respective department agents.</li></ul>', NULL, NULL, 'image', '2021-11-10 18:30:00', '2021-11-10 18:30:00', NULL),
(4, NULL, 'Responsive', 'Your website works on any device: desktop, tablet or mobile.', NULL, 'fas fa-desktop', 'icon', '2021-11-10 18:30:00', '2021-11-10 18:30:00', NULL),
(5, NULL, 'Customizable', 'You can easily read, edit, and write your own code, or change everything.', NULL, 'fas fa-wrench', 'icon', '2021-11-10 18:30:00', '2021-11-10 18:30:00', NULL),
(6, NULL, 'UI Elements', 'There is a bunch of useful and necessary elements for developing your website.', NULL, 'fas fa-cubes', 'icon', '2021-11-10 18:30:00', '2021-11-10 18:30:00', NULL),
(7, NULL, 'Clean Code', 'You can find our code well organized, commented and readable.', NULL, 'fas fa-code', 'icon', '2021-11-10 18:30:00', '2021-11-10 18:30:00', NULL),
(8, NULL, 'Documented', 'As you can see in the source code, we provided a comprehensive documentation.', NULL, 'far fa-file-alt', 'icon', '2021-11-10 18:30:00', '2021-11-10 18:30:00', NULL),
(9, NULL, 'Free Updates', 'When you purchase this template, you\'ll freely receive future updates.', NULL, 'fas fa-download', 'icon', '2021-11-10 18:30:01', '2021-11-10 18:30:01', NULL),
(10, NULL, 'Track Projects', '<span style=\"color: rgb(68, 68, 68); font-family: Lato, sans-serif; font-size: 16px; text-align: center;\">Keep a track of all your projects in the most simple way.</span>', NULL, 'fas fa-desktop', 'task', '2021-11-10 18:30:02', '2021-11-10 18:30:07', 1),
(11, NULL, 'Add Members', '<span style=\"color: rgb(68, 68, 68); font-family: Lato, sans-serif; font-size: 16px; text-align: center;\">Add members to your projects and keep them in sync with the progress.</span>', NULL, 'fas fa-users', 'task', '2021-11-10 18:30:02', '2021-11-10 18:30:07', 1),
(12, NULL, 'Assign Tasks', '<span style=\"color: rgb(68, 68, 68); font-family: Lato, sans-serif; font-size: 16px; text-align: center;\">Your website is fully responsive, it will work on any device, desktop, tablet and mobile.</span>', NULL, 'fas fa-list', 'task', '2021-11-10 18:30:03', '2021-11-10 18:30:07', 1),
(13, NULL, 'Estimates', '<span style=\"color: rgb(68, 68, 68); font-family: Lato, sans-serif; font-size: 16px; text-align: center;\">Create estimates how much project can cost and send to your clients.</span>', NULL, 'fas fa-calculator', 'bills', '2021-11-10 18:30:03', '2021-11-10 18:30:07', 2),
(14, NULL, 'Invoices', '<span style=\"color: rgb(68, 68, 68); font-family: Lato, sans-serif; font-size: 16px; text-align: center;\">Simple and professional invoices can be download in form of PDF.</span>', NULL, 'far fa-file-alt', 'bills', '2021-11-10 18:30:03', '2021-11-10 18:30:08', 2),
(15, NULL, 'Payments', '<span style=\"color: rgb(68, 68, 68); font-family: Lato, sans-serif; font-size: 16px; text-align: center;\">Track payments done by clients in the payment section.</span>', NULL, 'fas fa-money-bill-alt', 'bills', '2021-11-10 18:30:04', '2021-11-10 18:30:08', 2),
(16, NULL, 'Tickets', '<span style=\"color: rgb(68, 68, 68); font-family: Lato, sans-serif; font-size: 16px; text-align: center;\">When someone is facing a problem, they can raise a ticket for their problems. Admin can assign the tickets to respective department agents.</span>', NULL, 'fas fa-ticket-alt', 'team', '2021-11-10 18:30:04', '2021-11-10 18:30:08', 3),
(17, NULL, 'Leaves', '<span style=\"color: rgb(68, 68, 68); font-family: Lato, sans-serif; font-size: 16px; text-align: center;\">Employees can apply for the multiple leaves from their panel. Admin can approve or reject the leave applications.</span>', NULL, 'fas fa-ban', 'team', '2021-11-10 18:30:04', '2021-11-10 18:30:09', 3),
(18, NULL, 'Attendance', '<span style=\"color: rgb(68, 68, 68); font-family: Lato, sans-serif; font-size: 16px; text-align: center;\">Attendance module allows employees to clock-in and clock-out, right from their dashboard. Admin can track the attendance of the team.</span>', NULL, 'far fa-check-circle', 'team', '2021-11-10 18:30:04', '2021-11-10 18:30:09', 3),
(19, NULL, 'OneSignal', NULL, NULL, NULL, 'apps', '2021-11-10 18:30:04', '2021-11-10 18:30:04', NULL),
(20, NULL, 'Slack', NULL, NULL, NULL, 'apps', '2021-11-10 18:30:05', '2021-11-10 18:30:05', NULL),
(21, NULL, 'Paypal', NULL, NULL, NULL, 'apps', '2021-11-10 18:30:05', '2021-11-10 18:30:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `file_storage`
--

CREATE TABLE `file_storage` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `path` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `size` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `file_storage_settings`
--

CREATE TABLE `file_storage_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `filesystem` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `auth_keys` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('enabled','disabled') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'disabled',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `footer_menu`
--

CREATE TABLE `footer_menu` (
  `id` int(10) UNSIGNED NOT NULL,
  `language_setting_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `video_link` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `video_embed` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hash_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `external_link` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` enum('header','footer','both') COLLATE utf8_unicode_ci DEFAULT 'footer',
  `status` enum('active','inactive') COLLATE utf8_unicode_ci DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `footer_menu`
--

INSERT INTO `footer_menu` (`id`, `language_setting_id`, `name`, `slug`, `description`, `created_at`, `updated_at`, `video_link`, `video_embed`, `file_name`, `hash_name`, `external_link`, `type`, `status`) VALUES
(1, NULL, 'Terms of use', 'terms-of-use', '<div><b><span style=\"font-size: 14px;\"><span style=\"font-size: 14px;\">T</span><span style=\"font-size: 14px;\">ERMS OF USE FOR CODAGETECH</span></span></b></div><div><br></div><div>The use of any product, service or feature (the \"Materials\") available through the internet web sites accessible at codagetech.com (the \"Web Site\") by any user of the Web Site (\"You\" or \"Your\" hereafter) shall be governed by the following terms of use:</div><div>This Web Site is provided by CODAGETECH, a partnership awaiting registration with Government of India, and shall be used for informational purposes only. By using the Web Site or downloading Materials from the Web Site, You hereby agree to abide by the terms and conditions set forth in this Terms of Use. In the event of You not agreeing to these terms and conditions, You are requested by CODAGETECH not to use the Web Site or download Materials from the Web Site. This Web Site, including all Materials present (excluding any applicable third party materials), is the property of CODAGETECH and is copyrighted and protected by worldwide copyright laws and treaty provisions. You hereby agree to comply with all copyright laws worldwide in Your use of this Web Site and to prevent any unauthorized copying of the Materials. CODAGETECH does not grant any express or implied rights under any patents, trademarks, copyrights or trade secret information.</div><div>CODAGETECH has business relationships with many customers, suppliers, governments, and others. For convenience and simplicity, words like joint venture, partnership, and partner are used to indicate business relationships involving common activities and interests, and those words may not indicate precise legal relationships.</div><div><br></div><div><b><span style=\"font-size: 14px;\">LIMITED LICENSE:</span></b></div><div><br></div><div>Subject to the terms and conditions set forth in these Terms of Use, CODAGETECH grants You a non-exclusive, non-transferable, limited right to access, use and display this Web Site and the Materials thereon. You agree not to interrupt or attempt to interrupt the operation of the Web Site in any manner. Unless otherwise specified, the Web Site is for Your personal and non-commercial use. You shall not modify, copy, distribute, transmit, display, perform, reproduce, publish, license, create derivative works from, transfer, or sell any information, software, products or services obtained from this Web Site.</div><div><br></div><div><b><span style=\"font-size: 14px;\">THIRD PARTY CONTENT</span></b></div><div>The Web Site makes information of third parties available, including articles, analyst reports, news reports, and company information, including any regulatory authority, content licensed under Content Licensed under Creative Commons Attribution License, and other data from external sources (the \"Third Party Content\"). You acknowledge and agree that the Third Party Content is not created or endorsed by CODAGETECH. The provision of Third Party Content is for general informational purposes only and does not constitute a recommendation or solicitation to purchase or sell any securities or shares or to make any other type of investment or investment decision. In addition, the Third Party Content is not intended to provide tax, legal or investment advice. You acknowledge that the Third Party Content provided to You is obtained from sources believed to be reliable, but that no guarantees are made by CODAGETECH or the providers of the Third Party Content as to its accuracy, completeness, timeliness. You agree not to hold CODAGETECH, any business offering products or services through the Web Site or any provider of Third Party Content liable for any investment decision or other transaction You may make based on Your reliance on or use of such data, or any liability that may arise due to delays or interruptions in the delivery of the Third Party Content for any reason</div><div>By using any Third Party Content, You may leave this Web Site and be directed to an external website, or to a website maintained by an entity other than CODAGETECH. If You decide to visit any such site, You do so at Your own risk and it is Your responsibility to take all protective measures to guard against viruses or any other destructive elements. CODAGETECH makes no warranty or representation regarding and does not endorse, any linked web sites or the information appearing thereon or any of the products or services described thereon. Links do not imply that CODAGETECH or this Web Site sponsors, endorses, is affiliated or associated with, or is legally authorized to use any trademark, trade name, logo or copyright symbol displayed in or accessible through the links, or that any linked site is authorized to use any trademark, trade name, logo or copyright symbol of CODAGETECH or any of its affiliates or subsidiaries. You hereby expressly acknowledge and agree that the linked sites are not under the control of CODAGETECH and CODAGETECH is not responsible for the contents of any linked site or any link contained in a linked site, or any changes or updates to such sites. CODAGETECH is not responsible for webcasting or any other form of transmission received from any linked site. CODAGETECH is providing these links to You only as a convenience, and the inclusion of any link shall not be construed to imply endorsement by CODAGETECH in any manner of the website.</div><div><br></div><div><br></div><div><b><span style=\"font-size: 14px;\">NO WARRANTIES</span></b></div><div>THIS WEB SITE, THE INFORMATION AND MATERIALS ON THE SITE, AND ANY SOFTWARE MADE AVAILABLE ON THE WEB SITE, ARE PROVIDED \"AS IS\" WITHOUT ANY REPRESENTATION OR WARRANTY, EXPRESS OR IMPLIED, OF ANY KIND, INCLUDING, BUT NOT LIMITED TO, WARRANTIES OF MERCHANTABILITY, NON INFRINGEMENT, OR FITNESS FOR ANY PARTICULAR PURPOSE. THERE IS NO WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, REGARDING THIRD PARTY CONTENT. INSPITE OF FROIDEN BEST ENDEAVOURS, THERE IS NO WARRANTY ON BEHALF OF FROIDEN THAT THIS WEB SITE WILL BE FREE OF ANY COMPUTER VIRUSES. SOME JURISDICTIONS DO NOT ALLOW FOR THE EXCLUSION OF IMPLIED WARRANTIES, SO THE ABOVE EXCLUSIONS MAY NOT APPLY TO YOU.</div><div>LIMITATION OF DAMAGES:</div><div>IN NO EVENT SHALL FROIDEN OR ANY OF ITS SUBSIDIARIES OR AFFILIATES BE LIABLE TO ANY ENTITY FOR ANY DIRECT, INDIRECT, SPECIAL, CONSEQUENTIAL OR OTHER DAMAGES (INCLUDING, WITHOUT LIMITATION, ANY LOST PROFITS, BUSINESS INTERRUPTION, LOSS OF INFORMATION OR PROGRAMS OR OTHER DATA ON YOUR INFORMATION HANDLING SYSTEM) THAT ARE RELATED TO THE USE OF, OR THE INABILITY TO USE, THE CONTENT, MATERIALS, AND FUNCTIONS OF THIS WEB SITE OR ANY LINKED WEB SITE, EVEN IF FROIDEN IS EXPRESSLY ADVISED OF THE POSSIBILITY OF SUCH DAMAGES.</div><div><br></div><div><b><span style=\"font-size: 14px;\">DISCLAIMER:</span></b></div><div>THE WEB SITE MAY CONTAIN INACCURACIES AND TYPOGRAPHICAL AND CLERICAL ERRORS. FROIDEN EXPRESSLY DISCLAIMS ANY OBLIGATION(S) TO UPDATE THIS WEBSITE OR ANY OF THE MATERIALS ON THIS WEBSITE. FROIDEN DOES NOT WARRANT THE ACCURACY OR COMPLETENESS OF THE MATERIALS OR THE RELIABILITY OF ANY ADVICE, OPINION, STATEMENT OR OTHER INFORMATION DISPLAYED OR DISTRIBUTED THROUGH THE WEB SITE. YOU ACKNOWLEDGE THAT ANY RELIANCE ON ANY SUCH OPINION, ADVICE, STATEMENT, MEMORANDUM, OR INFORMATION SHALL BE AT YOUR SOLE RISK. FROIDEN RESERVES THE RIGHT, IN ITS SOLE DISCRETION, TO CORRECT ANY ERRORS OR OMISSIONS IN ANY PORTION OF THE WEB SITE. FROIDEN MAY MAKE ANY OTHER CHANGES TO THE WEB SITE, THE MATERIALS AND THE PRODUCTS, PROGRAMS, SERVICES OR PRICES (IF ANY) DESCRIBED IN THE WEB SITE AT ANY TIME WITHOUT NOTICE. THIS WEB SITE IS FOR INFORMATIONAL PURPOSES ONLY AND SHOULD NOT BE CONSTRUED AS TECHNICAL ADVICE OF ANY MANNER.</div><div>UNLAWFUL AND/OR PROHIBITED USE OF THE WEB SITE</div><div>As a condition of Your use of the Web Site, You shall not use the Web Site for any purpose(s) that is unlawful or prohibited by the Terms of Use. You shall not use the Web Site in any manner that could damage, disable, overburden, or impair any CODAGETECH server, or the network(s) connected to any CODAGETECH server, or interfere with any other party\'s use and enjoyment of any services associated with the Web Site. You shall not attempt to gain unauthorized access to any section of the Web Site, other accounts, computer systems or networks connected to any CODAGETECH server or to any of the services associated with the Web Site, through hacking, password mining or any other means. You shall not obtain or attempt to obtain any Materials or information through any means not intentionally made available through the Web Site.</div><div><br></div><div><b><span style=\"font-size: 14px;\">INDEMNITY:</span></b></div><div>You agree to indemnify and hold harmless CODAGETECH, its subsidiaries and affiliates from any claim, cost, expense, judgment or other loss relating to Your use of this Web Site in any manner, including without limitation of the foregoing, any action You take which is in violation of the terms and conditions of these Terms of Use and against any applicable law.</div><div><br></div><div><b><span style=\"font-size: 14px;\">CHANGES:</span></b></div><div>CODAGETECH reserves the rights, at its sole discretion, to change, modify, add or remove any portion of these Terms of Use in whole or in part, at any time. Changes in these Terms of Use will be effective when notice of such change is posted. Your continued use of the Web Site after any changes to these Terms of Use are posted will be considered acceptance of those changes. CODAGETECH may terminate, change, suspend or discontinue any aspect of the Web Site, including the availability of any feature(s) of the Web Site, at any time. CODAGETECH may also impose limits on certain features and services or restrict Your access to certain sections or all of the Web Site without notice or liability. You hereby acknowledge and agree that CODAGETECH may terminate the authorization, rights, and license given above at any point of time at its own sole discretion, and upon such termination; You shall immediately destroy all Materials.</div><div><br></div><div><br></div><div><b><span style=\"font-size: 14px;\">INTERNATIONAL USERS AND CHOICE OF LAW:</span></b></div><div>This Site is controlled, operated, and administered by CODAGETECH from within India. CODAGETECH makes no representation that Materials on this Web Site are appropriate or available for use at any other location(s) outside India. Any access to this Web Site from territories where their contents are illegal is prohibited. You may not use the Web Site or export the Materials in violation of any applicable export laws and regulations. If You access this Web Site from a location outside India, You are responsible for compliance with all local laws.</div><div>These Terms of Use shall be governed by the laws of India,Terms of Use for CODAGETECH</div><div>The use of any product, service or feature (the \"Materials\") available through the internet web sites accessible at codagetech.com (the \"Web Site\") by any user of the Web Site (\"You\" or \"Your\" hereafter) shall be governed by the following terms of use:</div><div>This Web Site is provided by CODAGETECH, a partnership awaiting registration with Government of India, and shall be used for informational purposes only. By using the Web Site or downloading Materials from the Web Site, You hereby agree to abide by the terms and conditions set forth in this Terms of Use. In the event of You not agreeing to these terms and conditions, You are requested by CODAGETECH not to use the Web Site or download Materials from the Web Site. This Web Site, including all Materials present (excluding any applicable third party materials), is the property of CODAGETECH and is copyrighted and protected by worldwide copyright laws and treaty provisions. You hereby agree to comply with all copyright laws worldwide in Your use of this Web Site and to prevent any unauthorized copying of the Materials. CODAGETECH does not grant any express or implied rights under any patents, trademarks, copyrights or trade secret information.</div><div>CODAGETECH has business relationships with many customers, suppliers, governments, and others. For convenience and simplicity, words like joint venture, partnership, and partner are used to indicate business relationships involving common activities and interests, and those words may not indicate precise legal relationships.</div><div><br></div><div><b><span style=\"font-size: 14px;\">LIMITED LICENSE:</span></b></div><div>Subject to the terms and conditions set forth in these Terms of Use, CODAGETECH grants You a non-exclusive, non-transferable, limited right to access, use and display this Web Site and the Materials thereon. You agree not to interrupt or attempt to interrupt the operation of the Web Site in any manner. Unless otherwise specified, the Web Site is for Your personal and non-commercial use. You shall not modify, copy, distribute, transmit, display, perform, reproduce, publish, license, create derivative works from, transfer, or sell any information, software, products or services obtained from this Web Site.</div><div><br></div><div><b><span style=\"font-size: 14px;\">THIRD-PARTY CONTENT</span></b></div><div>The Web Site makes information of third parties available, including articles, analyst reports, news reports, and company information, including any regulatory authority, content licensed under Content Licensed under Creative Commons Attribution License, and other data from external sources (the \"Third Party Content\"). You acknowledge and agree that the Third Party Content is not created or endorsed by CODAGETECH. The provision of Third Party Content is for general informational purposes only and does not constitute a recommendation or solicitation to purchase or sell any securities or shares or to make any other type of investment or investment decision. In addition, the Third Party Content is not intended to provide tax, legal or investment advice. You acknowledge that the Third Party Content provided to You is obtained from sources believed to be reliable, but that no guarantees are made by CODAGETECH or the providers of the Third Party Content as to its accuracy, completeness, timeliness. You agree not to hold CODAGETECH, any business offering products or services through the Web Site or any provider of Third Party Content liable for any investment decision or other transaction You may make based on Your reliance on or use of such data, or any liability that may arise due to delays or interruptions in the delivery of the Third Party Content for any reason</div><div>By using any Third Party Content, You may leave this Web Site and be directed to an external website, or to a website maintained by an entity other than CODAGETECH. If You decide to visit any such site, You do so at Your own risk and it is Your responsibility to take all protective measures to guard against viruses or any other destructive elements. CODAGETECH makes no warranty or representation regarding, and does not endorse, any linked web sites or the information appearing thereon or any of the products or services described thereon. Links do not imply that CODAGETECH or this Web Site sponsors, endorses, is affiliated or associated with, or is legally authorized to use any trademark, trade name, logo or copyright symbol displayed in or accessible through the links, or that any linked site is authorized to use any trademark, trade name, logo or copyright symbol of CODAGETECH or any of its affiliates or subsidiaries. You hereby expressly acknowledge and agree that the linked sites are not under the control of CODAGETECH and CODAGETECH is not responsible for the contents of any linked site or any link contained in a linked site, or any changes or updates to such sites. CODAGETECH is not responsible for webcasting or any other form of transmission received from any linked site. CODAGETECH is providing these links to You only as a convenience, and the inclusion of any link shall not be construed to imply endorsement by CODAGETECH in any manner of the website.</div><div><br></div><div><b><span style=\"font-size: 14px;\">NO WARRANTIES</span></b></div><div>THIS WEB SITE, THE INFORMATION AND MATERIALS ON THE SITE, AND ANY SOFTWARE MADE AVAILABLE ON THE WEB SITE, ARE PROVIDED \"AS IS\" WITHOUT ANY REPRESENTATION OR WARRANTY, EXPRESS OR IMPLIED, OF ANY KIND, INCLUDING, BUT NOT LIMITED TO, WARRANTIES OF MERCHANTABILITY, NON INFRINGEMENT, OR FITNESS FOR ANY PARTICULAR PURPOSE. THERE IS NO WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, REGARDING THIRD PARTY CONTENT. INSPITE OF FROIDEN BEST ENDEAVOURS, THERE IS NO WARRANTY ON BEHALF OF FROIDEN THAT THIS WEB SITE WILL BE FREE OF ANY COMPUTER VIRUSES. SOME JURISDICTIONS DO NOT ALLOW FOR THE EXCLUSION OF IMPLIED WARRANTIES, SO THE ABOVE EXCLUSIONS MAY NOT APPLY TO YOU.</div><div>LIMITATION OF DAMAGES:</div><div>IN NO EVENT SHALL FROIDEN OR ANY OF ITS SUBSIDIARIES OR AFFILIATES BE LIABLE TO ANY ENTITY FOR ANY DIRECT, INDIRECT, SPECIAL, CONSEQUENTIAL OR OTHER DAMAGES (INCLUDING, WITHOUT LIMITATION, ANY LOST PROFITS, BUSINESS INTERRUPTION, LOSS OF INFORMATION OR PROGRAMS OR OTHER DATA ON YOUR INFORMATION HANDLING SYSTEM) THAT ARE RELATED TO THE USE OF, OR THE INABILITY TO USE, THE CONTENT, MATERIALS, AND FUNCTIONS OF THIS WEB SITE OR ANY LINKED WEB SITE, EVEN IF FROIDEN IS EXPRESSLY ADVISED OF THE POSSIBILITY OF SUCH DAMAGES.</div><div><br></div><div><b><span style=\"font-size: 14px;\">DISCLAIMER:</span></b></div><div><span style=\"font-size: 12px;\">THE WEB SITE MAY CONTAIN INACCURACIES AND TYPOGRAPHICAL AND CLERICAL ERRORS. FROIDEN EXPRESSLY DISCLAIMS ANY OBLIGATION(S) TO UPDATE THIS WEBSITE OR ANY OF THE MATERIALS ON THIS WEBSITE. FROIDEN DOES NOT WARRANT THE ACCURACY OR COMPLETENESS OF THE MATERIALS OR THE RELIABILITY OF ANY ADVICE, OPINION, STATEMENT OR OTHER INFORMATION DISPLAYED OR DISTRIBUTED THROUGH THE WEB SITE. YOU ACKNOWLEDGE THAT ANY RELIANCE ON ANY SUCH OPINION, ADVICE, STATEMENT, MEMORANDUM, OR INFORMATION SHALL BE AT YOUR SOLE RISK. FROIDEN RESERVES THE RIGHT, IN ITS SOLE DISCRETION, TO CORRECT ANY ERRORS OR OMISSIONS IN ANY PORTION OF THE WEB SITE. FROIDEN MAY MAKE ANY OTHER CHANGES TO THE WEB SITE, THE MATERIALS AND THE PRODUCTS, PROGRAMS, SERVICES OR PRICES (IF ANY) DESCRIBED IN THE WEB SITE AT ANY TIME WITHOUT NOTICE. THIS WEB SITE IS FOR INFORMATIONAL PURPOSES ONLY AND SHOULD NOT BE CONSTRUED AS TECHNICAL ADVICE OF ANY MANNER.</span></div><div><span style=\"font-size: 12px;\">UNLAWFUL AND/OR PROHIBITED USE OF THE WEB SITE</span></div><div>As a condition of Your use of the Web Site, You shall not use the Web Site for any purpose(s) that is unlawful or prohibited by the Terms of Use. You shall not use the Web Site in any manner that could damage, disable, overburden, or impair any CODAGETECH server, or the network(s) connected to any CODAGETECH server, or interfere with any other party\'s use and enjoyment of any services associated with the Web Site. You shall not attempt to gain unauthorized access to any section of the Web Site, other accounts, computer systems or networks connected to any CODAGETECH server or to any of the services associated with the Web Site, through hacking, password mining or any other means. You shall not obtain or attempt to obtain any materials or information through any means not intentionally made available through the Web Site.</div><div><br></div><div><b><span style=\"font-size: 14px;\">INDEMNITY:</span></b></div><div>You agree to indemnify and hold harmless CODAGETECH, its subsidiaries and affiliates from any claim, cost, expense, judgment or other loss relating to Your use of this Web Site in any manner, including without limitation of the foregoing, any action You take which is in violation of the terms and conditions of these Terms of Use and against any applicable law.</div><div><br></div><div><b><span style=\"font-size: 14px;\">CHANGES:</span></b></div><div>CODAGETECH reserves the rights, at its sole discretion, to change, modify, add or remove any portion of these Terms of Use in whole or in part, at any time. Changes in these Terms of Use will be effective when notice of such change is posted. Your continued use of the Web Site after any changes to these Terms of Use are posted will be considered acceptance of those changes. CODAGETECH may terminate, change, suspend or discontinue any aspect of the Web Site, including the availability of any feature(s) of the Web Site, at any time. CODAGETECH may also impose limits on certain features and services or restrict Your access to certain sections or all of the Web Site without notice or liability. You hereby acknowledge and agree that CODAGETECH may terminate the authorization, rights, and license given above at any point of time at its own sole discretion, and upon such termination; You shall immediately destroy all Materials.</div><div><br></div><div><b><span style=\"font-size: 14px;\">INTERNATIONAL USERS AND CHOICE OF LAW:</span></b></div><div>This Site is controlled, operated, and administered by CODAGETECH from within India. CODAGETECH makes no representation that Materials on this Web Site are appropriate or available for use at any other location(s) outside India. Any access to this Web Site from territories where their contents are illegal is prohibited. You may not use the Web Site or export the Materials in violation of any applicable export laws and regulations. If You access this Web Site from a location outside India, You are responsible for compliance with all local laws.</div><div>These Terms of Use shall be governed by the laws of India, without giving effect to its conflict of laws provisions. You agree that the appropriate court(s) in Bangalore, India, will have the exclusive jurisdiction to resolve all disputes arising under these Terms of Use and You hereby consent to personal jurisdiction in such forum.</div><div>These Terms of Use constitute the entire agreement between CODAGETECH and You with respect to Your use of the Web Site. Any claim You may have with respect to Your use of the Web Site must be commenced within one (1) year of the cause of action. If any provision(s) of this Terms of Use is held by a court of competent jurisdiction to be contrary to law then such provision(s) shall be severed from this Terms of Use and the other remaining provisions of this Terms of Use shall remain in full force and effect. without giving effect to its conflict of laws provisions. You agree that the appropriate court(s) in Bangalore, India, will have the exclusive jurisdiction to resolve all disputes arising under these Terms of Use and You hereby consent to personal jurisdiction in such forum.</div><div>These Terms of Use constitute the entire agreement between CODAGETECH and You with respect to Your use of the Web Site. Any claim You may have with respect to Your use of the Web Site must be commenced within one (1) year of the cause of action. If any provision(s) of this Terms of Use is held by a court of competent jurisdiction to be contrary to law then such provision(s) shall be severed from this Terms of Use and the other remaining provisions of this Terms of Use shall remain in full force and effect.</div>', '2021-11-10 18:30:01', '2021-11-10 18:30:01', NULL, NULL, NULL, NULL, NULL, 'footer', 'active'),
(2, NULL, 'Privacy Policy', 'privacy-policy', '<div><b><span style=\"font-size: 14px;\">WHAT DO WE DO WITH YOUR INFORMATION?</span></b></div><div>When you purchase something from our store, as part of the buying and selling process, we collect the personal information you give us such as your name, address, and email address.</div><div><br></div><div>When you browse our store, we also automatically receive your computer’s internet protocol (IP) address in order to provide us with information that helps us learn about your browser and operating system.</div><div><b><br></b></div><div><b>How do you get my consent?</b></div><div>When you provide us with personal information to complete a transaction, verify your credit card, place an order, arrange for a delivery or return a purchase, we imply that you consent to our collecting it and using it for that specific reason only.</div><div><br></div><div>If we ask for your personal information for a secondary reason, like marketing, we will either ask you directly for your expressed consent, or provide you with an opportunity to say no.</div><div><br></div><div><b>How do I withdraw my consent?</b></div><div>If after you opt-in, you change your mind, you may withdraw your consent for us to contact you, for the continued collection, use or disclosure of your information, at any time, by contacting us at <b>support@codagetech.com</b> or mailing us at my address</div><div><br></div><div><b><span style=\"font-size: 14px;\">DISCLOSURE</span></b></div><div>We may disclose your personal information if we are required by law to do so or if you violate our Terms of Service.</div><div><br></div><div><b><span style=\"font-size: 14px;\">PAYMENT</span></b></div><div>We use Razorpay for processing payments. We/Razorpay do not store your card data on their servers. The data is encrypted through the Payment Card Industry Data Security Standard (PCI-DSS) when processing payment. Your purchase transaction data is only used as long as is necessary to complete your purchase transaction. After that is complete, your purchase transaction information is not saved.</div><div><br></div><div>Our payment gateway adheres to the standards set by PCI-DSS as managed by the PCI Security Standards Council, which is a joint effort of brands like Visa, MasterCard, American Express, and Discover.</div><div><br></div><div>PCI-DSS requirements help ensure the secure handling of credit card information by our store and its service providers.</div><div><br></div><div>For more insight, you may also want to read terms and conditions of Razorpay on https://razorpay.com</div><div><b><br></b></div><div><b><span style=\"font-size: 14px;\">THIRD-PARTY SERVICES</span></b></div><div>In general, the third-party providers used by us will only collect, use, and disclose your information to the extent necessary to allow them to perform the services they provide to us.</div><div><br></div><div>However, certain third-party service providers, such as payment gateways and other payment transaction processors, have their own privacy policies with respect to the information we are required to provide to them for your purchase-related transactions.</div><div><br></div><div>For these providers, we recommend that you read their privacy policies so you can understand the manner in which your personal information will be handled by these providers.</div><div><br></div><div>In particular, remember that certain providers may be located in or have facilities that are located in a different jurisdiction than either you or us. So if you elect to proceed with a transaction that involves the services of a third-party service provider, then your information may become subject to the laws of the jurisdiction(s) in which that service provider or its facilities are located.</div><div><br></div><div>Once you leave our store’s website or are redirected to a third-party website or application, you are no longer governed by this Privacy Policy or our website’s Terms of Service.</div><div><br></div><div><b><span style=\"font-size: 14px;\">Links</span></b></div><div>When you click on links on our store, they may direct you away from our site. We are not responsible for the privacy practices of other sites and encourage you to read their privacy statements.</div><div><br></div><div><b><span style=\"font-size: 14px;\">SECURITY</span></b></div><div>To protect your personal information, we take reasonable precautions and follow industry best practices to make sure it is not inappropriately lost, misused, accessed, disclosed, altered or destroyed.</div><div><br></div><div><b><span style=\"font-size: 14px;\">COOKIES</span></b></div><div>We use cookies to maintain session of your user. It is not used to personally identify you on other websites.</div><div><br></div><div><b><span style=\"font-size: 14px;\">AGE OF CONSENT</span></b></div><div>By using this site, you represent that you are at least the age of majority in your state or province of residence, or that you are the age of majority in your state or province of residence and you have given us your consent to allow any of your minor dependents to use this site.</div><div><br></div><div><b><span style=\"font-size: 14px;\">CHANGES TO THIS PRIVACY POLICY</span></b></div><div>We reserve the right to modify this privacy policy at any time, so please review it frequently. Changes and clarifications will take effect immediately upon their posting on the website. If we make material changes to this policy, we will notify you here that it has been updated, so that you are aware of what information we collect, how we use it, and under what circumstances, if any, we use and/or disclose it.</div><div><br></div><div>If our store is acquired or merged with another company, your information may be transferred to the new owners so that we may continue to sell products to you.</div><div><br></div><div><b><span style=\"font-size: 14px;\">QUESTIONS AND CONTACT INFORMATION</span></b></div><div>If you would like to: access, correct, amend or delete any personal information we have about you, register a complaint, or simply want more information contact our Privacy Compliance Officer at <b>contactus@codagetech.com</b> or by mail at <i><b>your address here</b></i></div>', '2021-11-10 18:30:01', '2021-11-10 18:30:01', NULL, NULL, NULL, NULL, NULL, 'footer', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `front_clients`
--

CREATE TABLE `front_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `language_setting_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `front_clients`
--

INSERT INTO `front_clients` (`id`, `language_setting_id`, `title`, `image`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Client 1', NULL, '2021-11-10 18:30:05', '2021-11-10 18:30:05'),
(2, NULL, 'Client 2', NULL, '2021-11-10 18:30:05', '2021-11-10 18:30:05'),
(3, NULL, 'Client 3', NULL, '2021-11-10 18:30:05', '2021-11-10 18:30:05'),
(4, NULL, 'Client 4', NULL, '2021-11-10 18:30:05', '2021-11-10 18:30:05');

-- --------------------------------------------------------

--
-- Table structure for table `front_details`
--

CREATE TABLE `front_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `get_started_show` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `sign_in_show` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `address` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `social_links` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `primary_color` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `custom_css` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `custom_css_theme_two` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `locale` varchar(191) COLLATE utf8_unicode_ci DEFAULT 'en',
  `contact_html` longtext COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `front_details`
--

INSERT INTO `front_details` (`id`, `get_started_show`, `sign_in_show`, `address`, `phone`, `email`, `social_links`, `created_at`, `updated_at`, `primary_color`, `custom_css`, `custom_css_theme_two`, `locale`, `contact_html`) VALUES
(1, 'yes', 'yes', '14 50 st zone 13, Maadi, Cairo, Egypt.', '01016542830', 'info@codagetech.com', '[{\"name\":\"facebook\",\"link\":\"https:\\/\\/facebook.com\"},{\"name\":\"twitter\",\"link\":\"https:\\/\\/twitter.com\"},{\"name\":\"instagram\",\"link\":\"https:\\/\\/instagram.com\"},{\"name\":\"dribbble\",\"link\":\"https:\\/\\/dribbble.com\"},{\"name\":\"youtube\",\"link\":\"https:\\/\\/www.youtube.com\"}]', '2021-11-10 18:29:59', '2021-11-10 18:29:59', '#e94033', NULL, NULL, 'en', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `front_faqs`
--

CREATE TABLE `front_faqs` (
  `id` int(10) UNSIGNED NOT NULL,
  `language_setting_id` int(10) UNSIGNED DEFAULT NULL,
  `question` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `answer` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `front_faqs`
--

INSERT INTO `front_faqs` (`id`, `language_setting_id`, `question`, `answer`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Can i see demo?', '<span style=\"color: rgb(68, 68, 68); font-family: Lato, sans-serif; font-size: 16px;\">Yes, definitely. We would be happy to demonstrate you CODAGETECH through a web conference at your convenience. Please submit a query on our contact us page or drop a mail to our mail id info@codagetech.com.</span>', '2021-11-10 18:30:06', '2021-11-10 18:30:06'),
(2, NULL, 'How can i update app?', '<span style=\"color: rgb(68, 68, 68); font-family: Lato, sans-serif; font-size: 16px;\">Yes, definitely. We would be happy to demonstrate you CODAGETECH through a web conference at your convenience. Please submit a query on our contact us page or drop a mail to our mail id info@codagetech.com.</span>', '2021-11-10 18:30:07', '2021-11-10 18:30:07');

-- --------------------------------------------------------

--
-- Table structure for table `front_features`
--

CREATE TABLE `front_features` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `language_setting_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('enable','disable') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'enable',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `front_features`
--

INSERT INTO `front_features` (`id`, `language_setting_id`, `title`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Task Management', 'Manage your projects and your talent in a single system, resulting in empowered teams, satisfied clients, and increased profitability.', 'enable', '2021-11-10 18:30:07', '2021-11-10 18:30:07'),
(2, NULL, 'Manages All Your Bills', 'Manage your Automate billing and revenue recognition to streamline the contract-to-cash cycle.', 'enable', '2021-11-10 18:30:07', '2021-11-10 18:30:07'),
(3, NULL, 'Manages All Your Bills', 'Manage your Automate billing and revenue recognition to streamline the contract-to-cash cycle.', 'enable', '2021-11-10 18:30:08', '2021-11-10 18:30:08');

-- --------------------------------------------------------

--
-- Table structure for table `front_menu_buttons`
--

CREATE TABLE `front_menu_buttons` (
  `id` int(10) UNSIGNED NOT NULL,
  `language_setting_id` int(10) UNSIGNED DEFAULT NULL,
  `home` varchar(20) COLLATE utf8_unicode_ci DEFAULT 'home',
  `feature` varchar(20) COLLATE utf8_unicode_ci DEFAULT 'feature',
  `price` varchar(20) COLLATE utf8_unicode_ci DEFAULT 'price',
  `contact` varchar(20) COLLATE utf8_unicode_ci DEFAULT 'contact',
  `get_start` varchar(20) COLLATE utf8_unicode_ci DEFAULT 'get_start',
  `login` varchar(20) COLLATE utf8_unicode_ci DEFAULT 'login',
  `contact_submit` varchar(20) COLLATE utf8_unicode_ci DEFAULT 'contact_submit',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `front_menu_buttons`
--

INSERT INTO `front_menu_buttons` (`id`, `language_setting_id`, `home`, `feature`, `price`, `contact`, `get_start`, `login`, `contact_submit`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Home', 'Features', 'Pricing', 'Contact', 'Get Started', 'Login', 'Submit Enquiry', '2021-11-10 18:16:08', '2021-11-10 18:16:08');

-- --------------------------------------------------------

--
-- Table structure for table `front_widgets`
--

CREATE TABLE `front_widgets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `widget_code` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gdpr_settings`
--

CREATE TABLE `gdpr_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `enable_gdpr` tinyint(1) NOT NULL DEFAULT 0,
  `show_customer_area` tinyint(1) NOT NULL DEFAULT 0,
  `show_customer_footer` tinyint(1) NOT NULL DEFAULT 0,
  `top_information_block` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `enable_export` tinyint(1) NOT NULL DEFAULT 0,
  `data_removal` tinyint(1) NOT NULL DEFAULT 0,
  `lead_removal_public_form` tinyint(1) NOT NULL DEFAULT 0,
  `terms_customer_footer` tinyint(1) NOT NULL DEFAULT 0,
  `terms` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `policy` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `public_lead_edit` tinyint(1) NOT NULL DEFAULT 0,
  `consent_customer` tinyint(1) NOT NULL DEFAULT 0,
  `consent_leads` tinyint(1) NOT NULL DEFAULT 0,
  `consent_block` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `gdpr_settings`
--

INSERT INTO `gdpr_settings` (`id`, `company_id`, `enable_gdpr`, `show_customer_area`, `show_customer_footer`, `top_information_block`, `enable_export`, `data_removal`, `lead_removal_public_form`, `terms_customer_footer`, `terms`, `policy`, `public_lead_edit`, `consent_customer`, `consent_leads`, `consent_block`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, 0, 0, 0, NULL, '2021-11-10 18:30:46', '2021-11-10 18:30:46'),
(2, 2, 0, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, 0, 0, 0, NULL, '2021-11-10 18:31:39', '2021-11-10 18:31:39'),
(3, 3, 0, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, 0, 0, 0, NULL, '2021-11-10 18:32:17', '2021-11-10 18:32:17'),
(4, 4, 0, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, 0, 0, 0, NULL, '2021-11-10 18:32:59', '2021-11-10 18:32:59'),
(5, 5, 0, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, 0, 0, 0, NULL, '2021-11-10 18:33:39', '2021-11-10 18:33:39'),
(6, 6, 0, 0, 0, NULL, 0, 0, 0, 0, NULL, NULL, 0, 0, 0, NULL, '2021-11-10 18:34:20', '2021-11-10 18:34:20');

-- --------------------------------------------------------

--
-- Table structure for table `global_currencies`
--

CREATE TABLE `global_currencies` (
  `id` int(10) UNSIGNED NOT NULL,
  `currency_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `currency_symbol` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `currency_code` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `exchange_rate` double DEFAULT NULL,
  `usd_price` double DEFAULT NULL,
  `is_cryptocurrency` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `currency_position` enum('front','behind') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'front',
  `status` enum('enable','disable') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'enable'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `global_currencies`
--

INSERT INTO `global_currencies` (`id`, `currency_name`, `currency_symbol`, `currency_code`, `exchange_rate`, `usd_price`, `is_cryptocurrency`, `created_at`, `updated_at`, `deleted_at`, `currency_position`, `status`) VALUES
(1, 'Egyptian Pound', 'LE', 'EGP', NULL, NULL, 'no', '2021-11-10 18:29:53', '2021-11-10 18:29:53', NULL, 'front', 'enable'),
(2, 'Dollars', '$', 'USD', NULL, NULL, 'no', '2021-11-10 18:29:54', '2021-11-10 18:29:54', NULL, 'front', 'enable'),
(3, 'Pounds', '£', 'GBP', NULL, NULL, 'no', '2021-11-10 18:29:54', '2021-11-10 18:29:54', NULL, 'front', 'enable'),
(4, 'Euros', '€', 'EUR', NULL, NULL, 'no', '2021-11-10 18:29:55', '2021-11-10 18:29:55', NULL, 'behind', 'enable');

-- --------------------------------------------------------

--
-- Table structure for table `global_settings`
--

CREATE TABLE `global_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `currency_id` int(10) UNSIGNED DEFAULT NULL,
  `timezone` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Asia/Kolkata',
  `locale` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'en',
  `company_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `company_email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `company_phone` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logo` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `login_background` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_updated_by` int(10) UNSIGNED DEFAULT NULL,
  `front_design` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `google_map_key` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `currency_converter_key` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `google_captcha_version` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'v2',
  `google_recaptcha_key` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `google_recaptcha_secret` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `purchase_code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `supported_until` timestamp NULL DEFAULT NULL,
  `hide_cron_message` tinyint(1) NOT NULL DEFAULT 0,
  `week_start` int(11) NOT NULL DEFAULT 1,
  `system_update` tinyint(1) NOT NULL DEFAULT 1,
  `email_verification` tinyint(1) NOT NULL DEFAULT 1,
  `logo_background_color` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT '#171e28',
  `currency_key_version` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'free',
  `show_review_modal` tinyint(1) NOT NULL DEFAULT 1,
  `logo_front` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `login_ui` tinyint(1) NOT NULL,
  `active_theme` enum('default','custom') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default',
  `auth_css` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_css_theme_two` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `new_company_locale` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `frontend_disable` tinyint(1) NOT NULL DEFAULT 0,
  `google_recaptcha_status` tinyint(1) NOT NULL DEFAULT 0,
  `setup_homepage` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default',
  `custom_homepage_url` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `app_debug` tinyint(1) NOT NULL DEFAULT 0,
  `expired_message` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `show_update_popup` tinyint(1) NOT NULL DEFAULT 1,
  `favicon` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `enable_register` tinyint(1) NOT NULL DEFAULT 1,
  `last_cron_run` timestamp NULL DEFAULT NULL,
  `rtl` tinyint(1) NOT NULL DEFAULT 0,
  `registration_open` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `global_settings`
--

INSERT INTO `global_settings` (`id`, `currency_id`, `timezone`, `locale`, `company_name`, `company_email`, `company_phone`, `logo`, `login_background`, `address`, `website`, `last_updated_by`, `front_design`, `created_at`, `updated_at`, `google_map_key`, `currency_converter_key`, `google_captcha_version`, `google_recaptcha_key`, `google_recaptcha_secret`, `purchase_code`, `supported_until`, `hide_cron_message`, `week_start`, `system_update`, `email_verification`, `logo_background_color`, `currency_key_version`, `show_review_modal`, `logo_front`, `login_ui`, `active_theme`, `auth_css`, `auth_css_theme_two`, `new_company_locale`, `frontend_disable`, `google_recaptcha_status`, `setup_homepage`, `custom_homepage_url`, `app_debug`, `expired_message`, `show_update_popup`, `favicon`, `enable_register`, `last_cron_run`, `rtl`, `registration_open`) VALUES
(1, 1, 'Asia/Kolkata', 'en', 'CODAGETECH', 'info@codagetech.com', '01016542830', NULL, NULL, '14 50st Zone 13, Maadi, Cairo, Egypt', 'https://codagetech.com', NULL, 1, '2021-11-10 18:29:55', '2021-11-10 18:29:55', '', '6c12788708871d0c499d', 'v2', NULL, NULL, NULL, NULL, 0, 1, 1, 1, '#171e28', 'free', 1, NULL, 0, 'default', NULL, NULL, NULL, 0, 0, 'default', NULL, 0, NULL, 1, NULL, 1, NULL, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `date` date NOT NULL,
  `occassion` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventories`
--

CREATE TABLE `inventories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `location` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `inventories`
--

INSERT INTO `inventories` (`id`, `name`, `description`, `location`, `created_at`, `updated_at`) VALUES
(1, 'Main Branch', 'Cairo branch', 'Cairo Government', '2021-11-10 18:39:14', '2021-11-12 15:30:06'),
(2, 'Menofia Hub', 'Menofia', 'Menofia Government', '2021-11-11 17:12:38', '2021-11-11 17:12:38');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `project_id` int(10) UNSIGNED DEFAULT NULL,
  `client_id` int(10) UNSIGNED DEFAULT NULL,
  `invoice_number` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `issue_date` date NOT NULL,
  `due_date` date NOT NULL,
  `sub_total` double(16,2) NOT NULL,
  `discount` double NOT NULL DEFAULT 0,
  `discount_type` enum('percent','fixed') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'percent',
  `total` double(16,2) NOT NULL,
  `currency_id` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('paid','unpaid','partial','canceled','draft','review') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'unpaid',
  `recurring` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `billing_cycle` int(11) DEFAULT NULL,
  `billing_interval` int(11) DEFAULT NULL,
  `billing_frequency` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_original_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `credit_note` tinyint(1) NOT NULL DEFAULT 0,
  `show_shipping_address` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `estimate_id` int(10) UNSIGNED DEFAULT NULL,
  `send_status` tinyint(1) NOT NULL DEFAULT 1,
  `invoice_recurring_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `approved` int(11) NOT NULL,
  `approved_by` int(10) UNSIGNED DEFAULT NULL,
  `products` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`products`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `company_id`, `project_id`, `client_id`, `invoice_number`, `issue_date`, `due_date`, `sub_total`, `discount`, `discount_type`, `total`, `currency_id`, `status`, `recurring`, `billing_cycle`, `billing_interval`, `billing_frequency`, `file`, `file_original_name`, `note`, `credit_note`, `show_shipping_address`, `created_at`, `updated_at`, `deleted_at`, `estimate_id`, `send_status`, `invoice_recurring_id`, `created_by`, `approved`, `approved_by`, `products`) VALUES
(1, 1, NULL, 4, '1', '2021-11-10', '2021-11-25', 200.00, 0, 'percent', 200.00, 1, 'unpaid', '', NULL, NULL, NULL, NULL, NULL, 'nnnnn', 0, 'no', '2021-11-10 20:43:18', '2021-11-11 20:41:42', NULL, NULL, 0, NULL, NULL, 1, NULL, NULL),
(2, 1, NULL, 4, '2', '2021-11-12', '2021-11-27', 2021.00, 0, 'percent', 2021.00, 1, 'unpaid', 'no', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'no', '2021-11-12 00:31:33', '2021-11-12 00:31:33', NULL, NULL, 0, NULL, 2, 1, 2, NULL),
(6, 1, NULL, 4, '3', '2021-11-12', '2021-11-27', 4042.00, 0, 'percent', 4042.00, 1, 'unpaid', 'no', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'no', '2021-11-12 13:06:37', '2021-11-12 13:06:37', NULL, NULL, 0, NULL, 2, 6, 2, '[{\"id\":\"1\",\"quantity\":\"2\"}]'),
(7, 1, NULL, 4, '4', '2021-11-12', '2021-11-27', 1615.00, 0, 'percent', 1615.00, 1, 'unpaid', 'no', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'no', '2021-11-12 15:34:48', '2021-11-12 15:34:48', NULL, NULL, 0, NULL, 2, 1, 2, '[{\"id\":\"6\",\"quantity\":\"5\"}]');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `invoice_id` int(10) UNSIGNED NOT NULL,
  `item_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `item_summary` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` enum('item','discount','tax') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'item',
  `quantity` double(16,2) NOT NULL,
  `unit_price` double(16,2) NOT NULL,
  `amount` double(16,2) NOT NULL,
  `taxes` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `hsn_sac_code` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `invoice_items`
--

INSERT INTO `invoice_items` (`id`, `invoice_id`, `item_name`, `item_summary`, `type`, `quantity`, `unit_price`, `amount`, `taxes`, `created_at`, `updated_at`, `hsn_sac_code`) VALUES
(2, 1, 'shirt 1', 'juhh', 'item', 1.00, 200.00, 200.00, NULL, '2021-11-11 20:41:43', '2021-11-11 20:41:43', '58'),
(3, 2, 'shirt 1', '', 'item', 1.00, 2021.00, 2021.00, NULL, '2021-11-12 00:31:34', '2021-11-12 00:31:34', '58'),
(7, 6, 'shirt 1', '', 'item', 2.00, 2021.00, 4042.00, NULL, '2021-11-12 13:06:38', '2021-11-12 13:06:38', NULL),
(8, 7, 'Bag-1', '', 'item', 5.00, 323.00, 1615.00, NULL, '2021-11-12 15:34:48', '2021-11-12 15:34:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_recurring`
--

CREATE TABLE `invoice_recurring` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `currency_id` int(10) UNSIGNED DEFAULT NULL,
  `project_id` int(10) UNSIGNED DEFAULT NULL,
  `client_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `issue_date` date NOT NULL,
  `due_date` date NOT NULL,
  `sub_total` double NOT NULL DEFAULT 0,
  `total` double NOT NULL DEFAULT 0,
  `discount` double NOT NULL DEFAULT 0,
  `discount_type` enum('percent','fixed') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'percent',
  `status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `file` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_original_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `show_shipping_address` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `day_of_month` int(11) DEFAULT 1,
  `day_of_week` int(11) DEFAULT 1,
  `payment_method` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rotation` enum('monthly','weekly','bi-weekly','quarterly','half-yearly','annually','daily') COLLATE utf8_unicode_ci NOT NULL,
  `billing_cycle` int(11) DEFAULT NULL,
  `unlimited_recurring` tinyint(1) NOT NULL DEFAULT 0,
  `client_can_stop` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` datetime DEFAULT NULL,
  `shipping_address` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_recurring_items`
--

CREATE TABLE `invoice_recurring_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `invoice_recurring_id` bigint(20) UNSIGNED NOT NULL,
  `item_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` double NOT NULL,
  `unit_price` double NOT NULL,
  `amount` double NOT NULL,
  `taxes` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` enum('item','discount','tax') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'item',
  `item_summary` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `hsn_sac_code` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_settings`
--

CREATE TABLE `invoice_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `invoice_prefix` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `invoice_digit` int(10) UNSIGNED NOT NULL DEFAULT 3,
  `estimate_prefix` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'EST',
  `estimate_digit` int(10) UNSIGNED NOT NULL DEFAULT 3,
  `credit_note_prefix` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'CN',
  `credit_note_digit` int(10) UNSIGNED NOT NULL DEFAULT 3,
  `template` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `due_after` int(11) NOT NULL,
  `invoice_terms` text COLLATE utf8_unicode_ci NOT NULL,
  `estimate_terms` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `gst_number` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `show_gst` enum('yes','no') COLLATE utf8_unicode_ci DEFAULT 'no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `logo` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hsn_sac_code_show` tinyint(1) NOT NULL DEFAULT 1,
  `locale` varchar(191) COLLATE utf8_unicode_ci DEFAULT 'en',
  `send_reminder` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `invoice_settings`
--

INSERT INTO `invoice_settings` (`id`, `company_id`, `invoice_prefix`, `invoice_digit`, `estimate_prefix`, `estimate_digit`, `credit_note_prefix`, `credit_note_digit`, `template`, `due_after`, `invoice_terms`, `estimate_terms`, `gst_number`, `show_gst`, `created_at`, `updated_at`, `logo`, `hsn_sac_code_show`, `locale`, `send_reminder`) VALUES
(1, NULL, 'INV', 3, 'EST', 3, 'CN', 3, 'invoice-1', 15, 'Thank you for your business. Please process this invoice within the due date.', NULL, NULL, 'no', '2021-11-10 18:02:10', '2021-11-10 18:02:10', NULL, 1, 'en', 0),
(2, 1, 'INV', 3, 'EST', 3, 'CN', 3, 'invoice-1', 15, 'Thank you for your business. Please process this invoice within the due date.', NULL, NULL, 'no', '2021-11-10 18:30:29', '2021-11-10 18:30:29', NULL, 1, 'en', 0),
(3, 2, 'INV', 3, 'EST', 3, 'CN', 3, 'invoice-1', 15, 'Thank you for your business. Please process this invoice within the due date.', NULL, NULL, 'no', '2021-11-10 18:31:14', '2021-11-10 18:31:14', NULL, 1, 'en', 0),
(4, 3, 'INV', 3, 'EST', 3, 'CN', 3, 'invoice-1', 15, 'Thank you for your business. Please process this invoice within the due date.', NULL, NULL, 'no', '2021-11-10 18:32:04', '2021-11-10 18:32:04', NULL, 1, 'en', 0),
(5, 4, 'INV', 3, 'EST', 3, 'CN', 3, 'invoice-1', 15, 'Thank you for your business. Please process this invoice within the due date.', NULL, NULL, 'no', '2021-11-10 18:32:42', '2021-11-10 18:32:42', NULL, 1, 'en', 0),
(6, 5, 'INV', 3, 'EST', 3, 'CN', 3, 'invoice-1', 15, 'Thank you for your business. Please process this invoice within the due date.', NULL, NULL, 'no', '2021-11-10 18:33:22', '2021-11-10 18:33:22', NULL, 1, 'en', 0),
(7, 6, 'INV', 3, 'EST', 3, 'CN', 3, 'invoice-1', 15, 'Thank you for your business. Please process this invoice within the due date.', NULL, NULL, 'no', '2021-11-10 18:34:01', '2021-11-10 18:34:01', NULL, 1, 'en', 0);

-- --------------------------------------------------------

--
-- Table structure for table `issues`
--

CREATE TABLE `issues` (
  `id` int(10) UNSIGNED NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `project_id` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('pending','resolved') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `language_settings`
--

CREATE TABLE `language_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `language_code` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `language_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('enabled','disabled') COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `language_settings`
--

INSERT INTO `language_settings` (`id`, `language_code`, `language_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'ar', 'Arabic', 'disabled', NULL, NULL),
(2, 'de', 'German', 'disabled', NULL, NULL),
(3, 'es', 'Spanish', 'enabled', NULL, NULL),
(4, 'et', 'Estonian', 'disabled', NULL, NULL),
(5, 'fa', 'Farsi', 'disabled', NULL, NULL),
(6, 'fr', 'French', 'enabled', NULL, NULL),
(7, 'gr', 'Greek', 'disabled', NULL, NULL),
(8, 'it', 'Italian', 'enabled', NULL, NULL),
(9, 'nl', 'Dutch', 'disabled', NULL, NULL),
(10, 'pl', 'Polish', 'disabled', NULL, NULL),
(11, 'pt', 'Portuguese', 'disabled', NULL, NULL),
(12, 'br', 'Portuguese (Brazil)', 'disabled', NULL, NULL),
(13, 'ro', 'Romanian', 'disabled', NULL, NULL),
(14, 'ru', 'Russian', 'enabled', NULL, NULL),
(15, 'tr', 'Turkish', 'disabled', NULL, NULL),
(16, 'zh-CN', 'Chinese (S)', 'disabled', NULL, NULL),
(17, 'zh-TW', 'Chinese (T)', 'disabled', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

CREATE TABLE `leads` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `source_id` int(11) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `column_priority` int(11) NOT NULL,
  `agent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `office_phone` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postal_code` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `client_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `client_email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `next_follow_up` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `value` double DEFAULT 0,
  `currency_id` int(10) UNSIGNED DEFAULT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `leads`
--

INSERT INTO `leads` (`id`, `company_id`, `client_id`, `source_id`, `status_id`, `column_priority`, `agent_id`, `company_name`, `website`, `address`, `office_phone`, `city`, `state`, `country`, `postal_code`, `client_name`, `client_email`, `mobile`, `note`, `next_follow_up`, `created_at`, `updated_at`, `value`, `currency_id`, `category_id`) VALUES
(1, 1, NULL, NULL, NULL, 0, NULL, 'Daugherty and Sons', 'Bell Kshlerin', NULL, NULL, NULL, NULL, NULL, NULL, 'Janick Boehm', 'rhianna.rempel@example.org', '91 123456789', 'Alice. \'Come on, then,\' said the Cat: \'we\'re all mad here. I\'m mad. You\'re mad.\' \'How do you like.', 'yes', '2021-11-10 18:34:58', '2021-11-10 18:34:58', 0, NULL, NULL),
(2, 1, NULL, NULL, NULL, 0, NULL, 'Rodriguez, Effertz and McClure', 'Dr. Alden Funk', NULL, NULL, NULL, NULL, NULL, NULL, 'Alek Watsica PhD', 'albert37@example.net', '91 123456789', 'Oh dear! I\'d nearly forgotten to ask.\' \'It turned into a pig, and she thought it had some kind of.', 'yes', '2021-11-10 18:34:58', '2021-11-10 18:34:58', 0, NULL, NULL),
(3, 1, NULL, NULL, NULL, 0, NULL, 'Jacobs, Rau and Torp', 'Prof. Everett Armstrong II', NULL, NULL, NULL, NULL, NULL, NULL, 'Manuel Maggio', 'mhegmann@example.net', '91 123456789', 'What made you so awfully clever?\' \'I have answered three questions, and that in some alarm. This.', 'yes', '2021-11-10 18:34:58', '2021-11-10 18:34:58', 0, NULL, NULL),
(4, 1, NULL, NULL, NULL, 0, NULL, 'Schumm PLC', 'Olin Nader', NULL, NULL, NULL, NULL, NULL, NULL, 'Prof. Ewell Denesik III', 'baumbach.alda@example.org', '91 123456789', 'And yet I don\'t remember where.\' \'Well, it must make me grow larger, I can creep under the sea,\'.', 'yes', '2021-11-10 18:34:58', '2021-11-10 18:34:58', 0, NULL, NULL),
(5, 1, NULL, NULL, NULL, 0, NULL, 'Rice, Bins and Torphy', 'Garret Larson', NULL, NULL, NULL, NULL, NULL, NULL, 'Porter Smitham', 'ltreutel@example.com', '91 123456789', 'Down, down, down. There was a bright idea came into Alice\'s head. \'Is that all?\' said the Duchess.', 'yes', '2021-11-10 18:34:58', '2021-11-10 18:34:58', 0, NULL, NULL),
(6, 1, NULL, NULL, NULL, 0, NULL, 'Wilkinson PLC', 'Dr. Lester Larson', NULL, NULL, NULL, NULL, NULL, NULL, 'Miss Frida Kuhlman', 'bartoletti.johnson@example.net', '91 123456789', 'But her sister on the top of her ever getting out of sight, they were playing the Queen left off.', 'yes', '2021-11-10 18:34:58', '2021-11-10 18:34:58', 0, NULL, NULL),
(7, 1, NULL, NULL, NULL, 0, NULL, 'Dicki Group', 'Barry Wiegand', NULL, NULL, NULL, NULL, NULL, NULL, 'Pete Glover', 'jayda.quitzon@example.com', '91 123456789', 'MUST be more to come, so she tried her best to climb up one of the evening, beautiful Soup!.', 'yes', '2021-11-10 18:34:59', '2021-11-10 18:34:59', 0, NULL, NULL),
(8, 1, NULL, NULL, NULL, 0, NULL, 'Hermiston, Towne and Collins', 'Shakira Lubowitz', NULL, NULL, NULL, NULL, NULL, NULL, 'Easter Wolff', 'marietta98@example.net', '91 123456789', 'How puzzling all these strange Adventures of hers would, in the direction it pointed to, without.', 'yes', '2021-11-10 18:34:59', '2021-11-10 18:34:59', 0, NULL, NULL),
(9, 1, NULL, NULL, NULL, 0, NULL, 'Zulauf, Skiles and Toy', 'Torrey Keeling', NULL, NULL, NULL, NULL, NULL, NULL, 'Elroy McDermott', 'hamill.dahlia@example.net', '91 123456789', 'I ever was at the window, and some were birds,) \'I suppose so,\' said Alice. \'And where HAVE my.', 'yes', '2021-11-10 18:34:59', '2021-11-10 18:34:59', 0, NULL, NULL),
(10, 1, NULL, NULL, NULL, 0, NULL, 'Gerhold-Fay', 'Kian Senger', NULL, NULL, NULL, NULL, NULL, NULL, 'Nakia Kohler', 'coby09@example.com', '91 123456789', 'CAN I have done just as she could, and waited to see what I see\"!\' \'You might just as if a dish or.', 'yes', '2021-11-10 18:34:59', '2021-11-10 18:34:59', 0, NULL, NULL),
(11, 2, NULL, NULL, NULL, 0, NULL, 'Hoeger, Hoeger and McGlynn', 'Ms. Rosemary Wyman', NULL, NULL, NULL, NULL, NULL, NULL, 'Nicola Johnston', 'abernathy.alysha@example.org', '91 123456789', 'I don\'t know what they\'re like.\' \'I believe so,\' Alice replied very politely, \'for I never heard.', 'yes', '2021-11-10 18:35:24', '2021-11-10 18:35:24', 0, NULL, NULL),
(12, 2, NULL, NULL, NULL, 0, NULL, 'Smith-Schuppe', 'Dr. Nigel Deckow', NULL, NULL, NULL, NULL, NULL, NULL, 'Clinton Greenholt', 'dariana76@example.com', '91 123456789', 'Who in the pool, \'and she sits purring so nicely by the little passage: and THEN--she found.', 'yes', '2021-11-10 18:35:24', '2021-11-10 18:35:24', 0, NULL, NULL),
(13, 2, NULL, NULL, NULL, 0, NULL, 'Crona-Stehr', 'Bulah Runolfsdottir', NULL, NULL, NULL, NULL, NULL, NULL, 'Freida Kassulke', 'lane.gislason@example.org', '91 123456789', 'It was, no doubt: only Alice did not dare to laugh; and, as a cushion, resting their elbows on it.', 'yes', '2021-11-10 18:35:24', '2021-11-10 18:35:24', 0, NULL, NULL),
(14, 2, NULL, NULL, NULL, 0, NULL, 'Shields, Auer and Smith', 'Cullen Daniel', NULL, NULL, NULL, NULL, NULL, NULL, 'Carson Rogahn', 'greta.prohaska@example.org', '91 123456789', 'They all made of solid glass; there was a dispute going on within--a constant howling and.', 'yes', '2021-11-10 18:35:24', '2021-11-10 18:35:24', 0, NULL, NULL),
(15, 2, NULL, NULL, NULL, 0, NULL, 'Mills-Jones', 'Morgan Mosciski', NULL, NULL, NULL, NULL, NULL, NULL, 'Carson Schulist', 'mante.walker@example.com', '91 123456789', 'Alice, and, after folding his arms and frowning at the cook till his eyes very wide on hearing.', 'yes', '2021-11-10 18:35:26', '2021-11-10 18:35:26', 0, NULL, NULL),
(16, 2, NULL, NULL, NULL, 0, NULL, 'Brekke-Quitzon', 'Jaylan Rohan', NULL, NULL, NULL, NULL, NULL, NULL, 'Lilyan Pollich', 'sherman@example.net', '91 123456789', 'I know who I WAS when I grow at a reasonable pace,\' said the Mock Turtle, suddenly dropping his.', 'yes', '2021-11-10 18:35:26', '2021-11-10 18:35:26', 0, NULL, NULL),
(17, 2, NULL, NULL, NULL, 0, NULL, 'Nikolaus Ltd', 'Lavonne Stracke', NULL, NULL, NULL, NULL, NULL, NULL, 'Mr. Kayden Metz DDS', 'jewel.sanford@example.com', '91 123456789', 'But here, to Alice\'s side as she went hunting about, and called out \'The Queen! The Queen!\' and.', 'yes', '2021-11-10 18:35:26', '2021-11-10 18:35:26', 0, NULL, NULL),
(18, 2, NULL, NULL, NULL, 0, NULL, 'Jaskolski Ltd', 'Blaze Schneider', NULL, NULL, NULL, NULL, NULL, NULL, 'Roselyn Vandervort', 'okon.leopoldo@example.com', '91 123456789', 'Alice remarked. \'Oh, you foolish Alice!\' she answered herself. \'How can you learn lessons in the.', 'yes', '2021-11-10 18:35:26', '2021-11-10 18:35:26', 0, NULL, NULL),
(19, 2, NULL, NULL, NULL, 0, NULL, 'Mraz-Bednar', 'Dr. Jeffry Grady MD', NULL, NULL, NULL, NULL, NULL, NULL, 'Madeline Ziemann', 'daugherty.cayla@example.com', '91 123456789', 'Hatter, \'I cut some more tea,\' the Hatter were having tea at it: a Dormouse was sitting on a.', 'yes', '2021-11-10 18:35:26', '2021-11-10 18:35:26', 0, NULL, NULL),
(20, 2, NULL, NULL, NULL, 0, NULL, 'Feeney, Koch and Runte', 'Sadye Hackett', NULL, NULL, NULL, NULL, NULL, NULL, 'Zachariah Ratke', 'kshlerin.ceasar@example.org', '91 123456789', 'Alice, rather doubtfully, as she could. \'No,\' said the Queen, turning purple. \'I won\'t!\' said.', 'yes', '2021-11-10 18:35:26', '2021-11-10 18:35:26', 0, NULL, NULL),
(21, 3, NULL, NULL, NULL, 0, NULL, 'Rodriguez PLC', 'Agustin Roberts', NULL, NULL, NULL, NULL, NULL, NULL, 'Velva Parisian', 'ahuel@example.net', '91 123456789', 'As she said these words her foot as far as they lay on the ground near the King in a great hurry.', 'yes', '2021-11-10 18:35:48', '2021-11-10 18:35:48', 0, NULL, NULL),
(22, 3, NULL, NULL, NULL, 0, NULL, 'Maggio and Sons', 'Judy Prosacco DVM', NULL, NULL, NULL, NULL, NULL, NULL, 'Prof. Jenifer D\'Amore DVM', 'edna.gaylord@example.com', '91 123456789', 'I know who I am! But I\'d better take him his fan and gloves, and, as she had hoped) a fan and the.', 'yes', '2021-11-10 18:35:48', '2021-11-10 18:35:48', 0, NULL, NULL),
(23, 3, NULL, NULL, NULL, 0, NULL, 'Stanton Ltd', 'Kaelyn Gerlach', NULL, NULL, NULL, NULL, NULL, NULL, 'Kaia Auer', 'vgibson@example.net', '91 123456789', 'Hatter. \'You might just as well as I tell you!\' said Alice. \'Anything you like,\' said the Duchess.', 'yes', '2021-11-10 18:35:48', '2021-11-10 18:35:48', 0, NULL, NULL),
(24, 3, NULL, NULL, NULL, 0, NULL, 'Murray-Jacobi', 'Dr. Elnora Emard II', NULL, NULL, NULL, NULL, NULL, NULL, 'Dr. Keenan Renner', 'cruz.sporer@example.net', '91 123456789', 'Gryphon, lying fast asleep in the distance, and she crossed her hands on her spectacles, and began.', 'yes', '2021-11-10 18:35:48', '2021-11-10 18:35:48', 0, NULL, NULL),
(25, 3, NULL, NULL, NULL, 0, NULL, 'Schimmel-Sawayn', 'Alberto Ernser Sr.', NULL, NULL, NULL, NULL, NULL, NULL, 'Prof. Alda Mohr MD', 'nolan.grimes@example.org', '91 123456789', 'They had a vague sort of circle, (\'the exact shape doesn\'t matter,\' it said,) and then the.', 'yes', '2021-11-10 18:35:49', '2021-11-10 18:35:49', 0, NULL, NULL),
(26, 3, NULL, NULL, NULL, 0, NULL, 'Champlin-Tromp', 'Prof. Braeden Bruen MD', NULL, NULL, NULL, NULL, NULL, NULL, 'Xzavier Tillman', 'iullrich@example.net', '91 123456789', 'I think that very few little girls eat eggs quite as much right,\' said the Gryphon: and Alice.', 'yes', '2021-11-10 18:35:49', '2021-11-10 18:35:49', 0, NULL, NULL),
(27, 3, NULL, NULL, NULL, 0, NULL, 'Toy, Gutkowski and Zulauf', 'Mckenzie Mitchell V', NULL, NULL, NULL, NULL, NULL, NULL, 'Mellie Wilderman', 'mroob@example.net', '91 123456789', 'Hatter. This piece of evidence we\'ve heard yet,\' said the White Rabbit with pink eyes ran close by.', 'yes', '2021-11-10 18:35:49', '2021-11-10 18:35:49', 0, NULL, NULL),
(28, 3, NULL, NULL, NULL, 0, NULL, 'Heaney-Reichel', 'Prof. Kelsie Reinger PhD', NULL, NULL, NULL, NULL, NULL, NULL, 'Ryleigh Corkery', 'johnston.mabelle@example.org', '91 123456789', 'Hatter went on, \'I must be the best of educations--in fact, we went to school every day--\' \'I\'VE.', 'yes', '2021-11-10 18:35:50', '2021-11-10 18:35:50', 0, NULL, NULL),
(29, 3, NULL, NULL, NULL, 0, NULL, 'Pfeffer Inc', 'Anahi Stoltenberg MD', NULL, NULL, NULL, NULL, NULL, NULL, 'Janae Roberts', 'aylin07@example.net', '91 123456789', 'I\'M a Duchess,\' she said to herself, \'to be going messages for a minute or two she stood looking.', 'yes', '2021-11-10 18:35:50', '2021-11-10 18:35:50', 0, NULL, NULL),
(30, 3, NULL, NULL, NULL, 0, NULL, 'Swaniawski Group', 'Dr. Elisha Bartell Sr.', NULL, NULL, NULL, NULL, NULL, NULL, 'Assunta Gottlieb', 'vskiles@example.org', '91 123456789', 'Her first idea was that you think I can do no more, whatever happens. What WILL become of it; then.', 'yes', '2021-11-10 18:35:50', '2021-11-10 18:35:50', 0, NULL, NULL),
(31, 4, NULL, NULL, NULL, 0, NULL, 'Bernhard-Muller', 'Flossie Becker', NULL, NULL, NULL, NULL, NULL, NULL, 'Harry Quigley', 'enos.oconner@example.net', '91 123456789', 'Then the Queen was silent. The King laid his hand upon her knee, and the three gardeners who were.', 'yes', '2021-11-10 18:36:19', '2021-11-10 18:36:19', 0, NULL, NULL),
(32, 4, NULL, NULL, NULL, 0, NULL, 'Donnelly-Emmerich', 'Lambert Wolff MD', NULL, NULL, NULL, NULL, NULL, NULL, 'Danyka Mraz', 'patsy84@example.org', '91 123456789', 'Pray, what is the reason of that?\' \'In my youth,\' said his father, \'I took to the end: then stop.\'.', 'yes', '2021-11-10 18:36:20', '2021-11-10 18:36:20', 0, NULL, NULL),
(33, 4, NULL, NULL, NULL, 0, NULL, 'Padberg, Weber and Dicki', 'Breanne Gleichner', NULL, NULL, NULL, NULL, NULL, NULL, 'Alene Roberts', 'odessa.lebsack@example.org', '91 123456789', 'Suddenly she came in sight of the court. (As that is enough,\' Said his father; \'don\'t give.', 'yes', '2021-11-10 18:36:20', '2021-11-10 18:36:20', 0, NULL, NULL),
(34, 4, NULL, NULL, NULL, 0, NULL, 'Tremblay Group', 'Felton Rodriguez', NULL, NULL, NULL, NULL, NULL, NULL, 'Norbert Rutherford', 'ivah38@example.com', '91 123456789', 'Though they were playing the Queen ordering off her head!\' Alice glanced rather anxiously at the.', 'yes', '2021-11-10 18:36:20', '2021-11-10 18:36:20', 0, NULL, NULL),
(35, 4, NULL, NULL, NULL, 0, NULL, 'Runolfsdottir-Murray', 'Ms. Rosalyn Hickle', NULL, NULL, NULL, NULL, NULL, NULL, 'Raquel Romaguera', 'kennedi36@example.net', '91 123456789', 'Hatter with a soldier on each side to guard him; and near the door, and tried to speak, but for a.', 'yes', '2021-11-10 18:36:20', '2021-11-10 18:36:20', 0, NULL, NULL),
(36, 4, NULL, NULL, NULL, 0, NULL, 'Hauck, Crona and Jerde', 'Waylon Renner', NULL, NULL, NULL, NULL, NULL, NULL, 'Sister Kozey', 'nwaelchi@example.org', '91 123456789', 'Alice in a great many teeth, so she sat down again very sadly and quietly, and looked at Alice.', 'yes', '2021-11-10 18:36:20', '2021-11-10 18:36:20', 0, NULL, NULL),
(37, 4, NULL, NULL, NULL, 0, NULL, 'Osinski-Kuhlman', 'Shakira Adams', NULL, NULL, NULL, NULL, NULL, NULL, 'Alexandro Klein', 'yasmeen43@example.org', '91 123456789', 'Who would not open any of them. \'I\'m sure I\'m not Ada,\' she said, \'and see whether it\'s marked.', 'yes', '2021-11-10 18:36:20', '2021-11-10 18:36:20', 0, NULL, NULL),
(38, 4, NULL, NULL, NULL, 0, NULL, 'Halvorson Group', 'Clovis Shields', NULL, NULL, NULL, NULL, NULL, NULL, 'Amie Farrell', 'durgan.cristopher@example.com', '91 123456789', 'Was kindly permitted to pocket the spoon: While the Panther were sharing a pie--\' [later editions.', 'yes', '2021-11-10 18:36:21', '2021-11-10 18:36:21', 0, NULL, NULL),
(39, 4, NULL, NULL, NULL, 0, NULL, 'Dare, McClure and Dibbert', 'Uriel Breitenberg', NULL, NULL, NULL, NULL, NULL, NULL, 'Allan Willms', 'ystroman@example.net', '91 123456789', 'First, because I\'m on the door between us. For instance, suppose it doesn\'t understand English,\'.', 'yes', '2021-11-10 18:36:21', '2021-11-10 18:36:21', 0, NULL, NULL),
(40, 4, NULL, NULL, NULL, 0, NULL, 'Treutel and Sons', 'Noe Zemlak', NULL, NULL, NULL, NULL, NULL, NULL, 'Grover Weissnat IV', 'addison78@example.org', '91 123456789', 'Alice was not a moment to be no chance of this, so she began thinking over other children she.', 'yes', '2021-11-10 18:36:21', '2021-11-10 18:36:21', 0, NULL, NULL),
(41, 5, NULL, NULL, NULL, 0, NULL, 'Torphy-Jenkins', 'Alysa Schoen', NULL, NULL, NULL, NULL, NULL, NULL, 'Jaquelin O\'Reilly', 'rashawn.ryan@example.net', '91 123456789', 'It did so indeed, and much sooner than she had never forgotten that, if you were me?\' \'Well.', 'yes', '2021-11-10 18:36:46', '2021-11-10 18:36:46', 0, NULL, NULL),
(42, 5, NULL, NULL, NULL, 0, NULL, 'Hills, Hackett and Klocko', 'Scotty Marks', NULL, NULL, NULL, NULL, NULL, NULL, 'Dr. Oliver Homenick MD', 'joanne.mayer@example.net', '91 123456789', 'Alice again, in a melancholy tone. \'Nobody seems to be in before the end of the officers of the.', 'yes', '2021-11-10 18:36:46', '2021-11-10 18:36:46', 0, NULL, NULL),
(43, 5, NULL, NULL, NULL, 0, NULL, 'Swift-Schuppe', 'Kellen Bernier', NULL, NULL, NULL, NULL, NULL, NULL, 'Aric Deckow V', 'xledner@example.org', '91 123456789', 'There were doors all round the court was in the night? Let me see: four times seven is--oh dear! I.', 'yes', '2021-11-10 18:36:47', '2021-11-10 18:36:47', 0, NULL, NULL),
(44, 5, NULL, NULL, NULL, 0, NULL, 'Gerhold PLC', 'Myra Fadel', NULL, NULL, NULL, NULL, NULL, NULL, 'Jakob Fisher', 'graham.dion@example.net', '91 123456789', 'March Hare interrupted in a very small cake, on which the March Hare went on. \'We had the best cat.', 'yes', '2021-11-10 18:36:47', '2021-11-10 18:36:47', 0, NULL, NULL),
(45, 5, NULL, NULL, NULL, 0, NULL, 'Windler Group', 'Stuart Denesik', NULL, NULL, NULL, NULL, NULL, NULL, 'Derek King', 'dejon.littel@example.net', '91 123456789', 'I can\'t tell you my history, and you\'ll understand why it is all the children she knew that it.', 'yes', '2021-11-10 18:36:47', '2021-11-10 18:36:47', 0, NULL, NULL),
(46, 5, NULL, NULL, NULL, 0, NULL, 'Dach, Trantow and Grant', 'Hayden Lemke', NULL, NULL, NULL, NULL, NULL, NULL, 'Jodie Eichmann', 'okris@example.com', '91 123456789', 'Then came a rumbling of little Alice and all must have imitated somebody else\'s hand,\' said the.', 'yes', '2021-11-10 18:36:47', '2021-11-10 18:36:47', 0, NULL, NULL),
(47, 5, NULL, NULL, NULL, 0, NULL, 'Moen-Moen', 'Mr. Tanner Bailey I', NULL, NULL, NULL, NULL, NULL, NULL, 'Dr. Declan DuBuque', 'parker.jennie@example.org', '91 123456789', 'Cheshire cat,\' said the Hatter; \'so I can\'t show it you myself,\' the Mock Turtle at last, and.', 'yes', '2021-11-10 18:36:47', '2021-11-10 18:36:47', 0, NULL, NULL),
(48, 5, NULL, NULL, NULL, 0, NULL, 'Sawayn Inc', 'Katherine Blick', NULL, NULL, NULL, NULL, NULL, NULL, 'Katlynn Quigley', 'graham74@example.org', '91 123456789', 'For instance, suppose it were nine o\'clock in the sand with wooden spades, then a great deal too.', 'yes', '2021-11-10 18:36:47', '2021-11-10 18:36:47', 0, NULL, NULL),
(49, 5, NULL, NULL, NULL, 0, NULL, 'Hoeger Ltd', 'Dr. Felipa Rohan DDS', NULL, NULL, NULL, NULL, NULL, NULL, 'Wyman Franecki', 'maverick.brakus@example.org', '91 123456789', 'They\'re dreadfully fond of pretending to be ashamed of yourself,\' said Alice, looking down at her.', 'yes', '2021-11-10 18:36:47', '2021-11-10 18:36:47', 0, NULL, NULL),
(50, 5, NULL, NULL, NULL, 0, NULL, 'Frami, Haag and Gutkowski', 'Dr. Jayce Stiedemann PhD', NULL, NULL, NULL, NULL, NULL, NULL, 'Joshuah Klocko', 'brenda07@example.net', '91 123456789', 'CHAPTER VIII. The Queen\'s Croquet-Ground A large rose-tree stood near the door between us. For.', 'yes', '2021-11-10 18:36:47', '2021-11-10 18:36:47', 0, NULL, NULL),
(51, 6, NULL, NULL, NULL, 0, NULL, 'Graham and Sons', 'Ardith Hagenes', NULL, NULL, NULL, NULL, NULL, NULL, 'Emmy Weimann', 'maggio.ines@example.com', '91 123456789', 'Caterpillar. Alice said nothing; she had made the whole thing, and longed to change the subject.', 'yes', '2021-11-10 18:37:14', '2021-11-10 18:37:14', 0, NULL, NULL),
(52, 6, NULL, NULL, NULL, 0, NULL, 'Baumbach-Hayes', 'Augusta Lockman', NULL, NULL, NULL, NULL, NULL, NULL, 'Aylin Kshlerin PhD', 'minnie76@example.com', '91 123456789', 'Alice had got its head to hide a smile: some of the ground--and I should think you\'ll feel it a.', 'yes', '2021-11-10 18:37:14', '2021-11-10 18:37:14', 0, NULL, NULL),
(53, 6, NULL, NULL, NULL, 0, NULL, 'Carroll, Runte and Fritsch', 'Laury Block', NULL, NULL, NULL, NULL, NULL, NULL, 'Jayde Runte', 'beatty.rory@example.org', '91 123456789', 'Caterpillar; and it was all about, and crept a little faster?\" said a whiting to a shriek, \'and.', 'yes', '2021-11-10 18:37:14', '2021-11-10 18:37:14', 0, NULL, NULL),
(54, 6, NULL, NULL, NULL, 0, NULL, 'Weissnat, Roob and Greenfelder', 'Dejon Stroman', NULL, NULL, NULL, NULL, NULL, NULL, 'Arden Waelchi I', 'qschuster@example.net', '91 123456789', 'She had just begun to repeat it, but her head made her draw back in a voice outside, and stopped.', 'yes', '2021-11-10 18:37:14', '2021-11-10 18:37:14', 0, NULL, NULL),
(55, 6, NULL, NULL, NULL, 0, NULL, 'Schuster, Parker and Bartoletti', 'Morton Beahan', NULL, NULL, NULL, NULL, NULL, NULL, 'Palma Swaniawski', 'cristopher.rice@example.net', '91 123456789', 'This time there could be NO mistake about it: it was too dark to see if there are, nobody attends.', 'yes', '2021-11-10 18:37:14', '2021-11-10 18:37:14', 0, NULL, NULL),
(56, 6, NULL, NULL, NULL, 0, NULL, 'Bartell and Sons', 'Kareem Wiza', NULL, NULL, NULL, NULL, NULL, NULL, 'Prof. Miles Kuhn V', 'merritt25@example.com', '91 123456789', 'Duchess, \'as pigs have to ask the question?\' said the Pigeon in a VERY turn-up nose, much more.', 'yes', '2021-11-10 18:37:14', '2021-11-10 18:37:14', 0, NULL, NULL),
(57, 6, NULL, NULL, NULL, 0, NULL, 'Hagenes-Glover', 'Shanelle Wisozk III', NULL, NULL, NULL, NULL, NULL, NULL, 'Hester Daugherty', 'kohler.jan@example.com', '91 123456789', 'Queen jumped up and repeat \"\'TIS THE VOICE OF THE SLUGGARD,\"\' said the Caterpillar. Here was.', 'yes', '2021-11-10 18:37:14', '2021-11-10 18:37:14', 0, NULL, NULL),
(58, 6, NULL, NULL, NULL, 0, NULL, 'Blanda Inc', 'Dr. Clifton Durgan', NULL, NULL, NULL, NULL, NULL, NULL, 'Prof. Lauren Pacocha', 'landen.huel@example.net', '91 123456789', 'However, I\'ve got back to yesterday, because I was going a journey, I should have liked teaching.', 'yes', '2021-11-10 18:37:14', '2021-11-10 18:37:14', 0, NULL, NULL),
(59, 6, NULL, NULL, NULL, 0, NULL, 'O\'Hara-Jenkins', 'Alexandra Durgan', NULL, NULL, NULL, NULL, NULL, NULL, 'Prof. Izaiah Strosin DVM', 'torey.considine@example.org', '91 123456789', 'I\'m talking!\' Just then her head impatiently; and, turning to Alice as it was not otherwise than.', 'yes', '2021-11-10 18:37:14', '2021-11-10 18:37:14', 0, NULL, NULL),
(60, 6, NULL, NULL, NULL, 0, NULL, 'Harris-Klocko', 'King Wehner', NULL, NULL, NULL, NULL, NULL, NULL, 'Roberta Bode MD', 'matilde67@example.net', '91 123456789', 'CHORUS. (In which the cook and the roof bear?--Mind that loose slate--Oh, it\'s coming down! Heads.', 'yes', '2021-11-10 18:37:15', '2021-11-10 18:37:15', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lead_agents`
--

CREATE TABLE `lead_agents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `status` enum('enabled','disabled') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'enabled',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lead_category`
--

CREATE TABLE `lead_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lead_custom_forms`
--

CREATE TABLE `lead_custom_forms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `field_display_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `field_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `field_order` int(11) NOT NULL,
  `status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `required` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lead_custom_forms`
--

INSERT INTO `lead_custom_forms` (`id`, `company_id`, `field_display_name`, `field_name`, `field_order`, `status`, `created_at`, `updated_at`, `required`) VALUES
(1, 1, 'Name', 'name', 1, 'active', '2021-11-10 18:30:48', '2021-11-10 18:30:48', 1),
(2, 1, 'Email', 'email', 2, 'active', '2021-11-10 18:30:48', '2021-11-10 18:30:48', 1),
(3, 1, 'Company Name', 'company_name', 3, 'active', '2021-11-10 18:30:48', '2021-11-10 18:30:48', 0),
(4, 1, 'Website', 'website', 4, 'active', '2021-11-10 18:30:48', '2021-11-10 18:30:48', 0),
(5, 1, 'Address', 'address', 5, 'active', '2021-11-10 18:30:49', '2021-11-10 18:30:49', 0),
(6, 1, 'Mobile', 'mobile', 6, 'active', '2021-11-10 18:30:49', '2021-11-10 18:30:49', 0),
(7, 1, 'Message', 'message', 7, 'active', '2021-11-10 18:30:49', '2021-11-10 18:30:49', 0),
(8, 2, 'Name', 'name', 1, 'active', '2021-11-10 18:31:41', '2021-11-10 18:31:41', 1),
(9, 2, 'Email', 'email', 2, 'active', '2021-11-10 18:31:41', '2021-11-10 18:31:41', 1),
(10, 2, 'Company Name', 'company_name', 3, 'active', '2021-11-10 18:31:41', '2021-11-10 18:31:41', 0),
(11, 2, 'Website', 'website', 4, 'active', '2021-11-10 18:31:42', '2021-11-10 18:31:42', 0),
(12, 2, 'Address', 'address', 5, 'active', '2021-11-10 18:31:42', '2021-11-10 18:31:42', 0),
(13, 2, 'Mobile', 'mobile', 6, 'active', '2021-11-10 18:31:42', '2021-11-10 18:31:42', 0),
(14, 2, 'Message', 'message', 7, 'active', '2021-11-10 18:31:43', '2021-11-10 18:31:43', 0),
(15, 3, 'Name', 'name', 1, 'active', '2021-11-10 18:32:19', '2021-11-10 18:32:19', 1),
(16, 3, 'Email', 'email', 2, 'active', '2021-11-10 18:32:19', '2021-11-10 18:32:19', 1),
(17, 3, 'Company Name', 'company_name', 3, 'active', '2021-11-10 18:32:19', '2021-11-10 18:32:19', 0),
(18, 3, 'Website', 'website', 4, 'active', '2021-11-10 18:32:19', '2021-11-10 18:32:19', 0),
(19, 3, 'Address', 'address', 5, 'active', '2021-11-10 18:32:19', '2021-11-10 18:32:19', 0),
(20, 3, 'Mobile', 'mobile', 6, 'active', '2021-11-10 18:32:20', '2021-11-10 18:32:20', 0),
(21, 3, 'Message', 'message', 7, 'active', '2021-11-10 18:32:20', '2021-11-10 18:32:20', 0),
(22, 4, 'Name', 'name', 1, 'active', '2021-11-10 18:33:00', '2021-11-10 18:33:00', 1),
(23, 4, 'Email', 'email', 2, 'active', '2021-11-10 18:33:00', '2021-11-10 18:33:00', 1),
(24, 4, 'Company Name', 'company_name', 3, 'active', '2021-11-10 18:33:01', '2021-11-10 18:33:01', 0),
(25, 4, 'Website', 'website', 4, 'active', '2021-11-10 18:33:01', '2021-11-10 18:33:01', 0),
(26, 4, 'Address', 'address', 5, 'active', '2021-11-10 18:33:01', '2021-11-10 18:33:01', 0),
(27, 4, 'Mobile', 'mobile', 6, 'active', '2021-11-10 18:33:01', '2021-11-10 18:33:01', 0),
(28, 4, 'Message', 'message', 7, 'active', '2021-11-10 18:33:01', '2021-11-10 18:33:01', 0),
(29, 5, 'Name', 'name', 1, 'active', '2021-11-10 18:33:41', '2021-11-10 18:33:41', 1),
(30, 5, 'Email', 'email', 2, 'active', '2021-11-10 18:33:41', '2021-11-10 18:33:41', 1),
(31, 5, 'Company Name', 'company_name', 3, 'active', '2021-11-10 18:33:41', '2021-11-10 18:33:41', 0),
(32, 5, 'Website', 'website', 4, 'active', '2021-11-10 18:33:41', '2021-11-10 18:33:41', 0),
(33, 5, 'Address', 'address', 5, 'active', '2021-11-10 18:33:42', '2021-11-10 18:33:42', 0),
(34, 5, 'Mobile', 'mobile', 6, 'active', '2021-11-10 18:33:42', '2021-11-10 18:33:42', 0),
(35, 5, 'Message', 'message', 7, 'active', '2021-11-10 18:33:42', '2021-11-10 18:33:42', 0),
(36, 6, 'Name', 'name', 1, 'active', '2021-11-10 18:34:22', '2021-11-10 18:34:22', 1),
(37, 6, 'Email', 'email', 2, 'active', '2021-11-10 18:34:22', '2021-11-10 18:34:22', 1),
(38, 6, 'Company Name', 'company_name', 3, 'active', '2021-11-10 18:34:22', '2021-11-10 18:34:22', 0),
(39, 6, 'Website', 'website', 4, 'active', '2021-11-10 18:34:22', '2021-11-10 18:34:22', 0),
(40, 6, 'Address', 'address', 5, 'active', '2021-11-10 18:34:22', '2021-11-10 18:34:22', 0),
(41, 6, 'Mobile', 'mobile', 6, 'active', '2021-11-10 18:34:22', '2021-11-10 18:34:22', 0),
(42, 6, 'Message', 'message', 7, 'active', '2021-11-10 18:34:22', '2021-11-10 18:34:22', 0);

-- --------------------------------------------------------

--
-- Table structure for table `lead_files`
--

CREATE TABLE `lead_files` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `lead_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `filename` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `hashname` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `size` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `google_url` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dropbox_link` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lead_follow_up`
--

CREATE TABLE `lead_follow_up` (
  `id` int(10) UNSIGNED NOT NULL,
  `lead_id` int(10) UNSIGNED NOT NULL,
  `remark` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `next_follow_up_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lead_sources`
--

CREATE TABLE `lead_sources` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `type` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lead_sources`
--

INSERT INTO `lead_sources` (`id`, `company_id`, `type`, `created_at`, `updated_at`) VALUES
(1, NULL, 'email', NULL, NULL),
(2, NULL, 'google', NULL, NULL),
(3, NULL, 'facebook', NULL, NULL),
(4, NULL, 'friend', NULL, NULL),
(5, NULL, 'direct visit', NULL, NULL),
(6, NULL, 'tv ad', NULL, NULL),
(7, 1, 'email', NULL, NULL),
(8, 1, 'google', NULL, NULL),
(9, 1, 'facebook', NULL, NULL),
(10, 1, 'friend', NULL, NULL),
(11, 1, 'direct visit', NULL, NULL),
(12, 1, 'tv ad', NULL, NULL),
(13, 2, 'email', NULL, NULL),
(14, 2, 'google', NULL, NULL),
(15, 2, 'facebook', NULL, NULL),
(16, 2, 'friend', NULL, NULL),
(17, 2, 'direct visit', NULL, NULL),
(18, 2, 'tv ad', NULL, NULL),
(19, 3, 'email', NULL, NULL),
(20, 3, 'google', NULL, NULL),
(21, 3, 'facebook', NULL, NULL),
(22, 3, 'friend', NULL, NULL),
(23, 3, 'direct visit', NULL, NULL),
(24, 3, 'tv ad', NULL, NULL),
(25, 4, 'email', NULL, NULL),
(26, 4, 'google', NULL, NULL),
(27, 4, 'facebook', NULL, NULL),
(28, 4, 'friend', NULL, NULL),
(29, 4, 'direct visit', NULL, NULL),
(30, 4, 'tv ad', NULL, NULL),
(31, 5, 'email', NULL, NULL),
(32, 5, 'google', NULL, NULL),
(33, 5, 'facebook', NULL, NULL),
(34, 5, 'friend', NULL, NULL),
(35, 5, 'direct visit', NULL, NULL),
(36, 5, 'tv ad', NULL, NULL),
(37, 6, 'email', NULL, NULL),
(38, 6, 'google', NULL, NULL),
(39, 6, 'facebook', NULL, NULL),
(40, 6, 'friend', NULL, NULL),
(41, 6, 'direct visit', NULL, NULL),
(42, 6, 'tv ad', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lead_status`
--

CREATE TABLE `lead_status` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `type` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `priority` int(11) NOT NULL,
  `default` tinyint(1) NOT NULL,
  `label_color` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT '#ff0000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lead_status`
--

INSERT INTO `lead_status` (`id`, `company_id`, `type`, `created_at`, `updated_at`, `priority`, `default`, `label_color`) VALUES
(1, NULL, 'pending', NULL, '2021-11-10 18:21:44', 0, 1, '#ff0000'),
(2, NULL, 'inprocess', NULL, NULL, 0, 0, '#ff0000'),
(3, NULL, 'converted', NULL, NULL, 0, 0, '#ff0000'),
(4, 1, 'pending', NULL, NULL, 1, 1, '#ff0000'),
(5, 1, 'inprocess', NULL, NULL, 2, 0, '#ff0000'),
(6, 1, 'converted', NULL, NULL, 3, 0, '#ff0000'),
(7, 2, 'pending', NULL, NULL, 1, 1, '#ff0000'),
(8, 2, 'inprocess', NULL, NULL, 2, 0, '#ff0000'),
(9, 2, 'converted', NULL, NULL, 3, 0, '#ff0000'),
(10, 3, 'pending', NULL, NULL, 1, 1, '#ff0000'),
(11, 3, 'inprocess', NULL, NULL, 2, 0, '#ff0000'),
(12, 3, 'converted', NULL, NULL, 3, 0, '#ff0000'),
(13, 4, 'pending', NULL, NULL, 1, 1, '#ff0000'),
(14, 4, 'inprocess', NULL, NULL, 2, 0, '#ff0000'),
(15, 4, 'converted', NULL, NULL, 3, 0, '#ff0000'),
(16, 5, 'pending', NULL, NULL, 1, 1, '#ff0000'),
(17, 5, 'inprocess', NULL, NULL, 2, 0, '#ff0000'),
(18, 5, 'converted', NULL, NULL, 3, 0, '#ff0000'),
(19, 6, 'pending', NULL, NULL, 1, 1, '#ff0000'),
(20, 6, 'inprocess', NULL, NULL, 2, 0, '#ff0000'),
(21, 6, 'converted', NULL, NULL, 3, 0, '#ff0000');

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `leave_type_id` int(10) UNSIGNED NOT NULL,
  `duration` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `leave_date` date NOT NULL,
  `reason` text COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('approved','pending','rejected') COLLATE utf8_unicode_ci NOT NULL,
  `reject_reason` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `paid` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_types`
--

CREATE TABLE `leave_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `type_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `no_of_leaves` int(11) NOT NULL DEFAULT 5,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `paid` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `leave_types`
--

INSERT INTO `leave_types` (`id`, `company_id`, `type_name`, `color`, `no_of_leaves`, `created_at`, `updated_at`, `paid`) VALUES
(1, NULL, 'Casual', 'success', 5, '2021-11-10 18:03:36', '2021-11-10 18:03:36', 1),
(2, NULL, 'Sick', 'danger', 5, '2021-11-10 18:03:37', '2021-11-10 18:03:37', 1),
(3, NULL, 'Earned', 'info', 5, '2021-11-10 18:03:37', '2021-11-10 18:03:37', 1),
(4, 1, 'Casual', 'success', 5, '2021-11-10 18:30:23', '2021-11-10 18:30:23', 1),
(5, 1, 'Sick', 'danger', 5, '2021-11-10 18:30:23', '2021-11-10 18:30:23', 1),
(6, 1, 'Earned', 'info', 5, '2021-11-10 18:30:23', '2021-11-10 18:30:23', 1),
(7, 2, 'Casual', 'success', 5, '2021-11-10 18:31:08', '2021-11-10 18:31:08', 1),
(8, 2, 'Sick', 'danger', 5, '2021-11-10 18:31:08', '2021-11-10 18:31:08', 1),
(9, 2, 'Earned', 'info', 5, '2021-11-10 18:31:08', '2021-11-10 18:31:08', 1),
(10, 3, 'Casual', 'success', 5, '2021-11-10 18:31:58', '2021-11-10 18:31:58', 1),
(11, 3, 'Sick', 'danger', 5, '2021-11-10 18:31:58', '2021-11-10 18:31:58', 1),
(12, 3, 'Earned', 'info', 5, '2021-11-10 18:31:58', '2021-11-10 18:31:58', 1),
(13, 4, 'Casual', 'success', 5, '2021-11-10 18:32:32', '2021-11-10 18:32:32', 1),
(14, 4, 'Sick', 'danger', 5, '2021-11-10 18:32:32', '2021-11-10 18:32:32', 1),
(15, 4, 'Earned', 'info', 5, '2021-11-10 18:32:33', '2021-11-10 18:32:33', 1),
(16, 5, 'Casual', 'success', 5, '2021-11-10 18:33:15', '2021-11-10 18:33:15', 1),
(17, 5, 'Sick', 'danger', 5, '2021-11-10 18:33:15', '2021-11-10 18:33:15', 1),
(18, 5, 'Earned', 'info', 5, '2021-11-10 18:33:16', '2021-11-10 18:33:16', 1),
(19, 6, 'Casual', 'success', 5, '2021-11-10 18:33:56', '2021-11-10 18:33:56', 1),
(20, 6, 'Sick', 'danger', 5, '2021-11-10 18:33:57', '2021-11-10 18:33:57', 1),
(21, 6, 'Earned', 'info', 5, '2021-11-10 18:33:57', '2021-11-10 18:33:57', 1);

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE `levels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'high', 'most skilled', '2021-11-10 18:37:16', '2021-11-10 18:37:16'),
(2, 'medium', 'ordinary', '2021-11-10 18:37:16', '2021-11-10 18:37:16'),
(3, 'low', 'beginners', '2021-11-10 18:37:16', '2021-11-10 18:37:16');

-- --------------------------------------------------------

--
-- Table structure for table `level_group`
--

CREATE TABLE `level_group` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `level_id` bigint(20) NOT NULL,
  `group_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `level_sport`
--

CREATE TABLE `level_sport` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `level_id` bigint(20) NOT NULL,
  `sport_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `licences`
--

CREATE TABLE `licences` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `license_number` char(29) COLLATE utf8_unicode_ci NOT NULL,
  `package_id` int(10) UNSIGNED DEFAULT NULL,
  `company_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact_person` varchar(70) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tax_number` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `last_payment_date` date DEFAULT NULL,
  `next_payment_date` date DEFAULT NULL,
  `status` enum('valid','invalid') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'valid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `capacity` int(11) NOT NULL,
  `description` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`, `capacity`, `description`, `created_at`, `updated_at`) VALUES
(1, 'football east', 20, 'football playground', '2021-11-10 18:37:16', '2021-11-10 18:37:16'),
(2, 'football west', 30, 'football playground', '2021-11-10 18:37:16', '2021-11-10 18:37:16'),
(3, 'basketball east', 50, 'basketball playground', '2021-11-10 18:37:16', '2021-11-10 18:37:16'),
(4, 'basketball west', 40, 'basketball playground', '2021-11-10 18:37:16', '2021-11-10 18:37:16');

-- --------------------------------------------------------

--
-- Table structure for table `log_time_for`
--

CREATE TABLE `log_time_for` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `log_time_for` enum('project','task') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'project',
  `auto_timer_stop` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `approval_required` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `log_time_for`
--

INSERT INTO `log_time_for` (`id`, `company_id`, `log_time_for`, `auto_timer_stop`, `created_at`, `updated_at`, `approval_required`) VALUES
(1, 1, 'project', 'no', '2021-11-10 18:30:32', '2021-11-10 18:30:32', 0),
(2, 2, 'project', 'no', '2021-11-10 18:31:21', '2021-11-10 18:31:21', 0),
(3, 3, 'project', 'no', '2021-11-10 18:32:06', '2021-11-10 18:32:06', 0),
(4, 4, 'project', 'no', '2021-11-10 18:32:49', '2021-11-10 18:32:49', 0),
(5, 5, 'project', 'no', '2021-11-10 18:33:26', '2021-11-10 18:33:26', 0),
(6, 6, 'project', 'no', '2021-11-10 18:34:05', '2021-11-10 18:34:05', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ltm_translations`
--

CREATE TABLE `ltm_translations` (
  `id` int(10) UNSIGNED NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `locale` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `group` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `member_category`
--

CREATE TABLE `member_category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `member_category`
--

INSERT INTO `member_category` (`id`, `category_name`, `created_at`, `updated_at`) VALUES
(1, 'Main', '2021-11-10 18:37:15', '2021-11-10 18:37:15'),
(2, 'Related', '2021-11-10 18:37:15', '2021-11-10 18:37:15'),
(3, 'Gained', '2021-11-10 18:37:15', '2021-11-10 18:37:15');

-- --------------------------------------------------------

--
-- Table structure for table `member_details`
--

CREATE TABLE `member_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `member_id` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `family_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `national_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `gender` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `relation_id` int(10) UNSIGNED NOT NULL,
  `status_id` int(10) UNSIGNED NOT NULL,
  `phone` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `date_of_birth` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `age` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `profession` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `religion` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `country_id` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `postal_code` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `face_book` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_notifications` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `member_relations`
--

CREATE TABLE `member_relations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `relation_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `member_relations`
--

INSERT INTO `member_relations` (`id`, `relation_name`, `created_at`, `updated_at`) VALUES
(1, 'Owner', '2021-11-10 18:37:15', '2021-11-10 18:37:15'),
(2, 'Husband', '2021-11-10 18:37:15', '2021-11-10 18:37:15'),
(3, 'Wife', '2021-11-10 18:37:15', '2021-11-10 18:37:15'),
(4, 'Son', '2021-11-10 18:37:15', '2021-11-10 18:37:15'),
(5, 'daughter', '2021-11-10 18:37:15', '2021-11-10 18:37:15');

-- --------------------------------------------------------

--
-- Table structure for table `member_status`
--

CREATE TABLE `member_status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `member_status`
--

INSERT INTO `member_status` (`id`, `status_name`, `created_at`, `updated_at`) VALUES
(1, 'Active', '2021-11-10 18:37:15', '2021-11-10 18:37:15'),
(2, 'Dropped', '2021-11-10 18:37:15', '2021-11-10 18:37:15'),
(3, 'Expired', '2021-11-10 18:37:15', '2021-11-10 18:37:15');

-- --------------------------------------------------------

--
-- Table structure for table `message_settings`
--

CREATE TABLE `message_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `allow_client_admin` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `allow_client_employee` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `message_settings`
--

INSERT INTO `message_settings` (`id`, `company_id`, `allow_client_admin`, `allow_client_employee`, `created_at`, `updated_at`) VALUES
(1, NULL, 'no', 'no', '2021-11-10 18:03:44', '2021-11-10 18:03:44'),
(2, 1, 'yes', 'yes', '2021-11-10 18:30:32', '2021-11-10 18:30:32'),
(3, 2, 'yes', 'yes', '2021-11-10 18:31:21', '2021-11-10 18:31:21'),
(4, 3, 'yes', 'yes', '2021-11-10 18:32:06', '2021-11-10 18:32:06'),
(5, 4, 'yes', 'yes', '2021-11-10 18:32:48', '2021-11-10 18:32:48'),
(6, 5, 'yes', 'yes', '2021-11-10 18:33:26', '2021-11-10 18:33:26'),
(7, 6, 'yes', 'yes', '2021-11-10 18:34:04', '2021-11-10 18:34:04');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_04_02_193003_create_countries_table', 1),
(2, '2014_04_02_193005_create_translations_table', 1),
(3, '2014_10_12_000000_create_users_table', 1),
(4, '2014_10_12_100000_create_password_resets_table', 1),
(5, '2016_06_20_112951_create_user_chat_table', 1),
(6, '2017_03_23_110416_add_column_users_table', 1),
(7, '2017_03_23_111036_create_client_details_table', 1),
(8, '2017_03_23_112028_create_client_contacts_table', 1),
(9, '2017_03_23_112353_create_employee_details_table', 1),
(10, '2017_03_23_114438_create_organisation_settings_table', 1),
(11, '2017_03_23_122646_create_project_category_table', 1),
(12, '2017_03_23_123601_create_projects_table', 1),
(13, '2017_03_23_125424_create_project_members_table', 1),
(14, '2017_03_23_125625_create_project_time_logs_table', 1),
(15, '2017_03_23_130413_create_project_files_table', 1),
(16, '2017_03_24_051800_create_tasks_table', 1),
(17, '2017_03_24_054355_create_notices_table', 1),
(18, '2017_03_24_055005_create_conversation_table', 1),
(19, '2017_03_24_055539_create_conversation_reply_table', 1),
(20, '2017_03_24_055859_create_invoices_table', 1),
(21, '2017_03_24_060421_create_invoice_items_table', 1),
(22, '2017_03_24_060751_create_quotations_table', 1),
(23, '2017_03_24_061241_create_quotation_items_table', 1),
(24, '2017_03_24_061505_create_sticky_notes_table', 1),
(25, '2017_03_24_064541_create_issues_table', 1),
(26, '2017_03_29_123858_entrust_setup_tables', 1),
(27, '2017_04_04_193158_AddColumnsProjectFilesTable', 1),
(28, '2017_04_05_063103_change_clientid_projectid_invoice_table', 1),
(29, '2017_04_06_051401_add_discount_column_invoice_table', 1),
(30, '2017_04_06_054728_add_status_column_issues_table', 1),
(31, '2017_04_08_152902_add_total_hours_column_time_log_table', 1),
(32, '2017_04_18_095809_create_project_activity_table', 1),
(33, '2017_04_18_103815_create_user_activities_table', 1),
(34, '2017_04_19_101519_create_email_notification_settings_table', 1),
(35, '2017_04_20_185211_add_colour_column_sticky_notes_table', 1),
(36, '2017_04_28_114154_create_notifications_table', 1),
(37, '2017_05_03_131016_add_project_completion_field_projects', 1),
(38, '2017_05_03_174333_create_currencies_table', 1),
(39, '2017_05_05_124330_create_module_settings_table', 1),
(40, '2017_05_05_233111_add_status_column_invoices', 1),
(41, '2017_05_11_140502_add_currency_symbol_column_invoices', 1),
(42, '2017_05_11_170244_add_currency_id_column_organisation_settings_table', 1),
(43, '2017_05_22_172748_add_timezone_column_settings_table', 1),
(44, '2017_05_24_120216_create_smtp_settings_table', 1),
(45, '2017_05_31_112158_create_universal_search_table', 1),
(46, '2017_06_22_131112_add_locale_organisation_settings_table', 1),
(47, '2017_07_13_091922_add_calculate_task_progress_column_project_table', 1),
(48, '2017_07_20_093528_on_delete_setnull_timelog', 1),
(49, '2017_07_21_120958_create_theme_settings_table', 1),
(50, '2017_07_24_113657_add_link_color_column_theme_settings_table', 1),
(51, '2017_07_24_123050_add_login_background_organisation_settings_table', 1),
(52, '2017_07_27_101351_add_column_type_invoice_items_table', 1),
(53, '2017_07_28_102010_create_estimates_table', 1),
(54, '2017_07_28_103230_create_estimate_items_table', 1),
(55, '2017_08_04_064431_create_payments_table', 1),
(56, '2017_08_05_103940_create_payment_gateway_credential_table', 1),
(57, '2017_08_08_055908_add_enable_paypal_column_payment_gateway_table', 1),
(58, '2017_08_09_054230_create_expenses_table', 1),
(59, '2017_08_21_065430_add_exchange_rate_column_currency_table', 1),
(60, '2017_08_21_131318_create_invoice_setting_table', 1),
(61, '2017_08_22_055908_add_expense_email_setting_to_email_notification_setting_table', 1),
(62, '2017_08_28_110759_add_recurring_columns_in_invoice_table', 1),
(63, '2017_08_30_061016_add_plan_id_to_payments_table', 1),
(64, '2017_08_30_093400_create_settings_table', 1),
(65, '2017_08_30_123956_add_slack_username_column_employee_details_table', 1),
(66, '2017_08_30_133725_add_send_slack_column_email_notification_settings_table', 1),
(67, '2017_09_01_060715_add_stipe_column_to_payment_credentials_table', 1),
(68, '2017_09_01_090124_add_customer_id_column_to_payments_table', 1),
(69, '2017_09_02_084049_add_locale_column_users_table', 1),
(70, '2017_09_14_095429_create_ticket_reply_templates_table', 1),
(71, '2017_09_14_095815_create_ticket_types_table', 1),
(72, '2017_09_14_100400_create_ticket_groups_table', 1),
(73, '2017_09_14_100530_create_ticket_tag_list_table', 1),
(74, '2017_09_14_114900_create_ticket_channels_table', 1),
(75, '2017_09_14_115003_create_ticket_agent_groups_table', 1),
(76, '2017_09_14_115004_create_tickets_table', 1),
(77, '2017_09_14_115005_create_ticket_tags_table', 1),
(78, '2017_09_18_064917_add_status_column_ticket_agent_group_table', 1),
(79, '2017_09_24_101700_create_ticket_replies_table', 1),
(80, '2017_09_25_060229_drop_description_column_ticket_table', 1),
(81, '2017_09_25_072611_add_deleted_at_column_tickets', 1),
(82, '2017_09_25_072627_add_deleted_at_column_ticket_reply', 1),
(83, '2017_10_03_094922_ticket_notification_migration', 1),
(84, '2017_10_03_134003_add_latitude_longitude_column', 1),
(85, '2017_10_12_111741_create_attendance_setting_table', 1),
(86, '2017_10_13_051909_create_attendance_table', 1),
(87, '2017_10_26_051335_add_mail_from_email_column_smtp_settings_table', 1),
(88, '2017_10_26_112253_add_office_open_days_column_attendance_settings_table', 1),
(89, '2017_11_01_054603_add_columns_to_client_details', 1),
(90, '2017_11_02_045542_change_on_cascade_project_members', 1),
(91, '2017_11_07_054438_add_project_admin_column_project_table', 1),
(92, '2017_11_07_125619_remove_project_admin_role', 1),
(93, '2017_11_08_045549_make_project_id_nullable_tasks_table', 1),
(94, '2017_11_09_071318_create_taskboard_columns_table', 1),
(95, '2017_11_09_092817_add_column_tasks_table', 1),
(96, '2017_11_20_070830_create_custom_fields_table', 1),
(97, '2017_11_20_071758_create_custom_fields__data_table', 1),
(98, '2017_11_22_071535_create_events_table', 1),
(99, '2017_11_23_065323_add_cryptocurrency_columns', 1),
(100, '2017_11_24_103957_create_event_attendees_table', 1),
(101, '2017_12_07_034433_change cascade users in time log table', 1),
(102, '2017_12_12_071823_create_modules_table', 1),
(103, '2017_12_12_073501_add_module_id_column_permissions_table', 1),
(104, '2017_12_21_114839_change_upload_folder', 1),
(105, '2017_12_28_112910_create_leave_types_table', 1),
(106, '2017_12_30_184422_create_leaves_table', 1),
(107, '2018_01_02_122442_add_leaves_notification_setting', 1),
(108, '2018_01_05_062543_add_user_css_column_theme_settings', 1),
(109, '2018_01_09_180937_add_task_completed_notification_setting', 1),
(110, '2018_01_29_073527_create_message_setting_table', 1),
(111, '2018_04_12_100452_add_dropbox_link_column_project_files_table', 1),
(112, '2018_04_12_123243_create_file_storage_table', 1),
(113, '2018_04_13_072732_create_groups_table', 1),
(114, '2018_04_13_092757_create_employee_groups_table', 1),
(115, '2018_04_17_113657_set_attendance_late_column_default', 1),
(116, '2018_05_07_065407_alter_invoice_id_null_payments', 1),
(117, '2018_05_07_065557_add_currency_id_column_payments_table', 1),
(118, '2018_05_08_064539_add_note_column_invoices', 1),
(119, '2018_05_15_072536_add_project_id_column_payments', 1),
(120, '2018_05_28_094515_set_gateway_column_null_payments_table', 1),
(121, '2018_05_29_070343_change_completed_on_column_to_datetime', 1),
(122, '2018_05_29_114402_populate_file_storage_settings_table', 1),
(123, '2018_05_30_051128_add_google_url_to_project_files_table', 1),
(124, '2018_06_05_092136_create_sub_tasks_table', 1),
(125, '2018_06_06_091511_create_task_comments_table', 1),
(126, '2018_06_11_054204_create_push_subscriptions_table', 1),
(127, '2018_06_14_094059_create_taxes_table', 1),
(128, '2018_06_18_065034_add_tax_id_column_invoice_items_table', 1),
(129, '2018_06_18_071442_add_discount_column_invoice_items_table', 1),
(130, '2018_06_21_052408_change_default_taskboard_columns', 1),
(131, '2018_06_26_160023_add_leave_count_column_leave_types_table', 1),
(132, '2018_06_27_072813_add_leaves_start_from_column', 1),
(133, '2018_06_27_075233_add_joining_date_column', 1),
(134, '2018_06_27_113713_add_gender_column_users_table', 1),
(135, '2018_06_28_054604_add_client_view_task_column_project_table', 1),
(136, '2018_06_28_191256_create_language_settings_table', 1),
(137, '2018_06_29_060331_add_active_theme_column_settings', 1),
(138, '2018_06_29_081128_add_manual_timelog_column_project_timelog', 1),
(139, '2018_06_29_104709_seed_languages', 1),
(140, '2018_08_02_121259_add_minutes_column_time_log_table', 1),
(141, '2018_08_22_103829_add_leaves_module', 1),
(142, '2018_08_22_104302_add_leaves_permissions', 1),
(143, '2018_08_27_114329_add_module_list_in_module_settings', 1),
(144, '2018_08_30_065158_add_status_column_users_table', 1),
(145, '2018_08_31_095814_create_lead_table', 1),
(146, '2018_08_31_095815_create_lead_source_table', 1),
(147, '2018_08_31_095815_create_lead_status_table', 1),
(148, '2018_08_31_095816_create_lead_follow_up_table', 1),
(149, '2018_09_04_095158_alter_lead_table', 1),
(150, '2018_09_04_095816_add_lead_module', 1),
(151, '2018_09_05_102010_create_proposal_table', 1),
(152, '2018_09_05_113230_create_proposal_items_table', 1),
(153, '2018_09_07_051239_alter_lead_website_table', 1),
(154, '2018_09_15_174026_add_default_lead_settings', 1),
(155, '2018_09_17_045718_add_leads_permission', 1),
(156, '2018_09_19_091643_add_remarks_to_payments_table', 1),
(157, '2018_09_21_095816_create_offline_payment_method_table', 1),
(158, '2018_09_25_065158_alter_payment_table', 1),
(159, '2018_09_28_110029_create_log_time_for_table', 1),
(160, '2018_09_28_965158_alter_project_time_log_table', 1),
(161, '2018_10_03_121901_create_packages_table', 1),
(162, '2018_10_03_121902_alter_organisation_settings_table', 1),
(163, '2018_10_04_042418_create_licences_table', 1),
(164, '2018_10_04_082754_add_super_admin_column_in_users_table', 1),
(165, '2018_10_08_091643_alter_project_table', 1),
(166, '2018_10_08_095950_create_subscriptions_table', 1),
(167, '2018_10_08_110029_create_lead_files_table', 1),
(168, '2018_10_08_120639_add_company_id_in_users_table', 1),
(169, '2018_10_10_110029_create_holidays_table', 1),
(170, '2018_10_10_114514_add_company_id_in_teams_table', 1),
(171, '2018_10_10_120621_add_company_id_in_leads_table', 1),
(172, '2018_10_10_123601_create_project_templates_table', 1),
(173, '2018_10_10_125424_create_project_template_members_table', 1),
(174, '2018_10_10_135816_add_holiday_module', 1),
(175, '2018_10_10_251800_create_project_template_tasks_table', 1),
(176, '2018_10_11_044355_add_company_id_in_attendances_table', 1),
(177, '2018_10_11_055814_add_company_id_in_holidays_table', 1),
(178, '2018_10_11_061029_add_company_id_in_projects_table', 1),
(179, '2018_10_11_061955_add_company_id_in_project_category_table', 1),
(180, '2018_10_11_063520_add_company_id_in_project_members_table', 1),
(181, '2018_10_11_065229_add_company_id_in_invoices_table', 1),
(182, '2018_10_11_070557_add_company_id_in_project_activity_table', 1),
(183, '2018_10_11_072547_add_company_id_in_taxes_table', 1),
(184, '2018_10_11_081816_add_company_id_in_tasks_table', 1),
(185, '2018_10_11_083600_add_company_id_in_taskboard_columns_table', 1),
(186, '2018_10_11_100425_add_company_id_in_estimates_table', 1),
(187, '2018_10_11_101701_add_company_id_in_payments_table', 1),
(188, '2018_10_11_102047_add_company_id_in_expenses_table', 1),
(189, '2018_10_11_110008_add_company_id_in_employee_details_table', 1),
(190, '2018_10_11_115208_add_company_id_in_project_time_logs_table', 1),
(191, '2018_10_11_115805_add_company_id_in_user_activities_table', 1),
(192, '2018_10_12_045341_add_company_id_in_tickets_table', 1),
(193, '2018_10_12_051409_add_company_id_in_ticket_channels_table', 1),
(194, '2018_10_12_052646_add_company_id_in_ticket_types_table', 1),
(195, '2018_10_12_060038_add_company_id_in_ticket_groups_table', 1),
(196, '2018_10_12_061136_add_company_id_in_ticket_agent_groups_table', 1),
(197, '2018_10_12_061807_add_company_id_in_ticket_reply_templates_table', 1),
(198, '2018_10_12_072321_add_company_id_in_events_table', 1),
(199, '2018_10_12_090132_add_company_id_in_leave_types_table', 1),
(200, '2018_10_12_090146_add_company_id_in_leaves_table', 1),
(201, '2018_10_12_093431_add_company_id_in_notices_table', 1),
(202, '2018_10_12_110433_add_company_id_in_email_notification_settings_table', 1),
(203, '2018_10_12_110842_add_company_id_in_smtp_settings_table', 1),
(204, '2018_10_15_051607_add_company_id_in_currencies_table', 1),
(205, '2018_10_15_052819_create_global_settings_table', 1),
(206, '2018_10_15_065737_add_company_id_in_theme_settings_table', 1),
(207, '2018_10_15_070856_alter_currency_id_in_companies_table', 1),
(208, '2018_10_15_083914_add_company_id_in_payment_gateway_credentials_table', 1),
(209, '2018_10_15_093625_add_company_id_in_invoice_settings_table', 1),
(210, '2018_10_15_094709_add_company_id_in_slack_settings_table', 1),
(211, '2018_10_15_105445_add_company_id_in_attendance_settings_table', 1),
(212, '2018_10_15_115927_add_company_id_in_custom_field_groups_table', 1),
(213, '2018_10_16_045235_add_company_id_in_module_settings_table', 1),
(214, '2018_10_16_071301_add_company_id_in_roles_table', 1),
(215, '2018_10_16_095816_add_holiday_module_detail', 1),
(216, '2018_10_17_043749_add_company_id_in_message_settings_table', 1),
(217, '2018_10_17_052214_add_company_id_in_file_storage_settings_table', 1),
(218, '2018_10_17_063334_add_company_id_in_lead_sources_table', 1),
(219, '2018_10_17_063359_add_company_id_in_lead_status_table', 1),
(220, '2018_10_17_081757_remove_config_datatable_file', 1),
(221, '2018_10_17_965158_alter_leads_address_table', 1),
(222, '2018_10_17_965168_alter_leads_phone_table', 1),
(223, '2018_10_18_034518_create_stripe_invoices_table', 1),
(224, '2018_10_18_075228_add_column_in_global_settings_table', 1),
(225, '2018_10_18_091643_alter_attendance_setting_table', 1),
(226, '2018_10_19_045718_add_holidays_permission', 1),
(227, '2018_10_20_094413_add_products_module', 1),
(228, '2018_10_20_094504_add_products_permissions', 1),
(229, '2018_10_21_051239_alter_holiday_website_table', 1),
(230, '2018_10_22_050933_alter_state_column_companies_table', 1),
(231, '2018_10_23_071525_remove_company_id_column_smtp_settings_table', 1),
(232, '2018_10_24_041117_add_column_email_verification_code_in_users_table', 1),
(233, '2018_10_24_071300_add_file_column_to_invoices_table', 1),
(234, '2018_10_24_965158_alter_employee_detail_table', 1),
(235, '2018_10_29_965158_alter_attendance_setting_default_table', 1),
(236, '2018_11_02_061629_add_column_in_proposals_table', 1),
(237, '2018_11_10_071300_alter_user_table', 1),
(238, '2018_11_10_122646_create_task_category_table', 1),
(239, '2018_11_15_105021_alter_stripe_invoices_table', 1),
(240, '2018_11_16_072246_add_company_id_in_client_details_table', 1),
(241, '2018_11_16_104747_add_column_in_estimate_items_table', 1),
(242, '2018_11_16_112847_add_column_in_proposals_items_table', 1),
(243, '2018_11_22_044348_add_estimate_number_column_in_estimates_table', 1),
(244, '2018_11_30_965158_alter_invoice_item_table', 1),
(245, '2018_12_12_965158_alter_invoice_estimate_response_table', 1),
(246, '2018_12_14_094504_add_expenses_permissions', 1),
(247, '2018_12_14_194504_add_expenses_permissions_detail', 1),
(248, '2018_12_20_1065158_alter_company_setting_table', 1),
(249, '2018_12_20_965158_alter_estimate_quantity_table', 1),
(250, '2018_12_27_074504_check_verify_purchase_file', 1),
(251, '2018_12_28_075730_create_push_notification_settings_table', 1),
(252, '2018_12_28_082056_add_send_push_column_email_notification_table', 1),
(253, '2018_12_28_123245_add_onesignal_player_id_column_users_table', 1),
(254, '2019_01_02_1065158_alter_module_setting_table', 1),
(255, '2019_01_02_2065158_insert_module_setting_client_table', 1),
(256, '2019_01_04_110029_create_employee_docs_table', 1),
(257, '2019_01_10_063520_add_company_id_in_lead_files_table', 1),
(258, '2019_01_17_045235_add_company_id_in_project_template_table', 1),
(259, '2019_01_17_055235_add_company_id_in_task_category_table', 1),
(260, '2019_01_17_065235_add_company_id_in_employee_docs_table', 1),
(261, '2019_01_17_075235_add_company_id_in_log_time_for_table', 1),
(262, '2019_01_21_1065158_alter_task_creator_table', 1),
(263, '2019_02_06_1065158_alter_attendance_check_table', 1),
(264, '2019_02_08_174333_create_global_currencies_table', 1),
(265, '2019_02_08_275235_add_currency_id_in_global_setting_table', 1),
(266, '2019_02_11_1065158_alter_log_time_for_table', 1),
(267, '2019_02_12_2065158_insert_module_setting_client_task_table', 1),
(268, '2019_02_13_110029_create_skills_table', 1),
(269, '2019_02_13_130029_create_employee_skills_table', 1),
(270, '2019_02_15_1065158_alter_employee_end_date_table', 1),
(271, '2019_02_15_1165158_alter_custom_status_table', 1),
(272, '2019_02_20_074848_create_jobs_table', 1),
(273, '2019_02_22_1165158_add_company_currency_api_google_api', 1),
(274, '2019_02_22_1165158_add_currency_api_google_api', 1),
(275, '2019_02_25_965158_alter_package_max_size_table', 1),
(276, '2019_02_28_965158_alter_package_sort_billing_cycle_table', 1),
(277, '2019_03_04_073501_change_module_id_notice_permissions_table', 1),
(278, '2019_03_05_110029_create_front_detail_table', 1),
(279, '2019_03_05_110039_create_feature_table', 1),
(280, '2019_03_08_1165158_create_stripe_table', 1),
(281, '2019_03_08_965158_alter_invoice_project_id_null_table', 1),
(282, '2019_03_11_132024_seed_front_end_data', 1),
(283, '2019_03_18_1165158_alter_stripe_setting_table', 1),
(284, '2019_03_19_061905_add_google_recaptcha_key_column_global_settings', 1),
(285, '2019_03_19_1265158_paypal_invoice_table', 1),
(286, '2019_04_03_965158_alter_project_deadline_table', 1),
(287, '2019_04_04_074848_alter_invoice_setting_table', 1),
(288, '2019_04_04_075848_alter_client_Details_table', 1),
(289, '2019_04_04_1165158_alter_package_default_table', 1),
(290, '2019_04_10_075848_alter_company_task_table', 1),
(291, '2019_04_17_1165158_create_package_setting_table', 1),
(292, '2019_04_22_075848_alter_package_setting_table', 1),
(293, '2019_06_05_163256_add_timezone_column_global_settings_table', 1),
(294, '2019_06_05_180258_add_locale_column_global_settings_table', 1),
(295, '2019_06_21_100408_add_name_and_email_columns_to_client_details_table', 1),
(296, '2019_07_05_083850_add_company_id_in_client_contacts_table', 1),
(297, '2019_07_09_133247_remove_invoice_unique_index', 1),
(298, '2019_07_16_145850_add_deleted_at_in_estimates_table', 1),
(299, '2019_07_16_145851_add_deleted_at_in_invoices_table', 1),
(300, '2019_07_17_145848_remove_estimate_unique_index', 1),
(301, '2019_07_19_112506_add_project_id_column_in_expenses_table', 1),
(302, '2019_08_05_112511_create_credit_notes_table', 1),
(303, '2019_08_05_112513_create_credit_note_items_table', 1),
(304, '2019_08_06_112518_add_credit_note_column_in_invoices_table', 1),
(305, '2019_08_07_112521_add_columns_in_invoice_settings_table', 1),
(306, '2019_08_13_073129_update_settings_add_envato_key', 1),
(307, '2019_08_13_073129_update_settings_add_support_key', 1),
(308, '2019_08_14_091832_add_item_summary_invoice_items_table', 1),
(309, '2019_08_14_105412_add_item_summary_estimate_items_table', 1),
(310, '2019_08_16_075733_change_price_size_proposal', 1),
(311, '2019_08_22_055908_add_invoice_email_setting_to_email_notification_setting_table', 1),
(312, '2019_08_22_075432_remove_unique_column_name_taskboard', 1),
(313, '2019_08_22_121805_add_external_link_column_project_files_table', 1),
(314, '2019_08_26_120718_add_offline_method_id_column_payments_table', 1),
(315, '2019_08_28_070105_create_project_milestones_table', 1),
(316, '2019_08_28_081847_update_smtp_setting_verified', 1),
(317, '2019_08_28_100242_add_columns_projects_table', 1),
(318, '2019_08_28_101747_add_milestone_id_column_tasks_table', 1),
(319, '2019_08_28_115700_add_budget_columns_projects_table', 1),
(320, '2019_08_28_2083812_add_invoice_created_column_project_milestones_table', 1),
(321, '2019_08_29_140115_make_smtp_type_nullable', 1),
(322, '2019_09_03_021925_add_currency_in_free_trail', 1),
(323, '2019_09_04_115714_add_recurring_task_id_column_in_tasks_table', 1),
(324, '2019_09_09_041914_create_project_settings_table', 1),
(325, '2019_09_09_045042_create_faq_categories_table', 1),
(326, '2019_09_09_045056_create_faqs_table', 1),
(327, '2019_09_09_081030_add_rounded_theme_column', 1),
(328, '2019_09_09_115714_add_cron_job_message_hide_table', 1),
(329, '2019_09_12_061447_add_google_recaptcha_secret_in_global_settings_table', 1),
(330, '2019_09_12_1074848_create_designation_table', 1),
(331, '2019_09_12_115714_add_team_field_employee_table', 1),
(332, '2019_09_27_212735_add_timelog_module_clients', 1),
(333, '2019_10_01_110039_create_footer_menu_table', 1),
(334, '2019_10_03_110030_add_social_links_column_in_front_details_table', 1),
(335, '2019_10_03_112806_add_week_start_column_in_companies_table', 1),
(336, '2019_10_04_101818_add_paypal_mode_in_payment_gateway_credentials_table', 1),
(337, '2019_10_04_124931_add_week_start_column_gloabl_settings', 1),
(338, '2019_10_07_063300_add_last_login_column_in_companies_table', 1),
(339, '2019_10_07_063301_add_payments_module_clients', 1),
(340, '2019_10_07_183130_create_dashboard_widgets_table', 1),
(341, '2019_10_07_191818_add_razorpay_detail_in_payment_gateway_credentials_table', 1),
(342, '2019_10_07_201818_add_razorpay_detail_in_stripe_setting_table', 1),
(343, '2019_10_09_191818_add_razorpay_plan_id_in_packages_table', 1),
(344, '2019_10_10_095950_create_razorpay_subscriptions_table', 1),
(345, '2019_10_10_1534518_create_razorpay_invoices_table', 1),
(346, '2019_10_14_060314_create_accept_estimates_table', 1),
(347, '2019_10_14_110606_add_estimate_id_column_in_invoices_table', 1),
(348, '2019_10_15_052931_create_contract_types_table', 1),
(349, '2019_10_15_052932_create_contracts_table', 1),
(350, '2019_10_15_084310_add_contract_module_in_module_settings', 1),
(351, '2019_10_15_115655_create_contract_signs_table', 1),
(352, '2019_10_17_051544_create_contract_discussions_table', 1),
(353, '2019_10_19_191818_add_order_id_in_razorpay_invoice_table', 1),
(354, '2019_10_19_5074854_add_status_column_projects_table', 1),
(355, '2019_10_22_5074864_add_company_id_in_skills_table', 1),
(356, '2019_10_22_5074874_add_company_id_in_universal_search_table', 1),
(357, '2019_10_23_122412_create_contract_renews_table', 1),
(358, '2019_10_23_130413_create_task_files_table', 1),
(359, '2019_10_23_230413_create_ticket_files_table', 1),
(360, '2019_10_23_5074884_alter_company_id_in_project_category_table', 1),
(361, '2019_10_24_120220_add_origin_amount_column_in_contracts_table', 1),
(362, '2019_10_31_043520_add_dependent_task_id_in_tasks_table', 1),
(363, '2019_10_31_122412_create_lead_agent_table', 1),
(364, '2019_11_01_142619_add_column_to_in_notices_table', 1),
(365, '2019_11_02_051209_create_invoice_credit_note_pivot_table', 1),
(366, '2019_11_02_051855_alter_credit_note_status_in_credit_notes_table', 1),
(367, '2019_11_04_0455045_add_column_invoice_item_table', 1),
(368, '2019_11_04_0455055_add_column_credit_note_item_table', 1),
(369, '2019_11_04_0455065_add_column_estimate_item_table', 1),
(370, '2019_11_04_063551_create_gdpr_settings_table', 1),
(371, '2019_11_04_091725_create_removal_requests_table', 1),
(372, '2019_11_04_091810_create_removal_requests_lead_table', 1),
(373, '2019_11_06_092918_add_client_id_in_invoices_table', 1),
(374, '2019_11_06_120145_create_offline_invoices_table', 1),
(375, '2019_11_06_120146_create_offline_plan_changes_table', 1),
(376, '2019_11_12_054145_add_system_update_column_in_global_settings_table', 1),
(377, '2019_11_14_082655_add_employee_id_column_in_employee_details_table', 1),
(378, '2019_11_18_054145_add_discount_column_in_proposal_table', 1),
(379, '2019_11_18_064145_add_tax_column_in_proposal_item_table', 1),
(380, '2019_11_18_123900_create_offline_invoice_payments_table', 1),
(381, '2019_11_19_064145_change_universal_search_client_id', 1),
(382, '2019_11_20_111631_add_payent_method_id_in_offline_invoices_table', 1),
(383, '2019_11_29_122129_add_paypal_mode_column_in_stripe_setting_table', 1),
(384, '2019_12_01_115133_alter_invoice_status_table', 1),
(385, '2019_12_09_171149_make_taxes_nullable_propsal_items_table', 1),
(386, '2019_12_11_082834_add_email_verification_column_in_global_settings_table', 1),
(387, '2019_12_18_121031_add_date_picker_format_column_in_companies_table', 1),
(388, '2019_12_20_143625_add_logo_background_color_column_settings_table', 1),
(389, '2020_01_13_055908_add_payment_email_setting_to_email_notification_setting_table', 1),
(390, '2020_01_13_1100390_create_testimonials_table', 1),
(391, '2020_01_13_1100391_create_front_clients_table', 1),
(392, '2020_01_13_115133_alter_feature_setting_table', 1),
(393, '2020_01_13_122129_add_extra_column_in_front_setting_table', 1),
(394, '2020_01_15_045056_create_front_faqs_table', 1),
(395, '2020_01_15_045057_create_front_menu_table', 1),
(396, '2020_01_15_056908_add_date_picker_format_to_company_setting_table', 1),
(397, '2020_01_16_132024_seed_front_data', 1),
(398, '2020_01_22_093727_add_version_column_global_settings', 1),
(399, '2020_01_22_122009_add_is_private_column_tasks_table', 1),
(400, '2020_01_23_062328_create_task_history_table', 1),
(401, '2020_01_24_093737_add_employee_details_of_default_admin', 1),
(402, '2020_01_24_134008_add_default_task_status_column_organisation_settings', 1),
(403, '2020_02_01_101914_update_settings_review', 1),
(404, '2020_02_13_101914_update_global_phone', 1),
(405, '2020_02_14_101914_update_front_old_settings_global', 1),
(406, '2020_02_18_132351_add_front_setting_logo', 1),
(407, '2020_02_19_121221_create_storage_settings', 1),
(408, '2020_02_19_132351_add_soft_delete_global_currency', 1),
(409, '2020_02_24_060416_update_invoice_setting_logo', 1),
(410, '2020_02_26_121650_add_report_module', 1),
(411, '2020_03_03_121750_add_stripe_active_subscription', 1),
(412, '2020_03_11_101914_remove_employee_id_unique', 1),
(413, '2020_03_11_101924_product_modules_setting_client', 1),
(414, '2020_03_27_102832_create_task_users_table', 1),
(415, '2020_03_30_111911_create_front_widgets_table', 1),
(416, '2020_04_01_062153_add_shipping_address_field_in_client_details_table', 1),
(417, '2020_04_01_062305_add_show_shipping_field_in_invoices_table', 1),
(418, '2020_04_06_130331_create_discussion_categories_table', 1),
(419, '2020_04_06_132027_create_discussions_table', 1),
(420, '2020_04_06_133759_create_discussion_replies_table', 1),
(421, '2020_04_07_093553_create_paystack_subscriptions_table', 1),
(422, '2020_04_08_094325_add_best_answer_id_discussions_table', 1),
(423, '2020_04_08_125803_add_discussion_reply_email_notification_settings_table', 1),
(424, '2020_04_09_051247_add_column_in_payment_gateway_credentials_table', 1),
(425, '2020_04_09_102411_add_last_reply_by_discussions_table', 1),
(426, '2020_04_10_080841_create_failed_jobs_table', 1),
(427, '2020_04_13_114832_create_project_template_task_users_table', 1),
(428, '2020_04_13_119832_migration_for_client_name_table', 1),
(429, '2020_04_15_210107_add_login_ui_column_global_settings', 1),
(430, '2020_04_17_074412_add_private_column_packages_table', 1),
(431, '2020_04_19_143824_remove_emailverification_notifications', 1),
(432, '2020_04_20_083724_add_hourly_rate_project_timelogs', 1),
(433, '2020_04_20_114349_add_hourly_rate_project_members', 1),
(434, '2020_04_20_173833_add_project_id_value_for_tasks_timelogs', 1),
(435, '2020_04_23_124301_add_billable_column_tasks_table', 1),
(436, '2020_04_24_115049_add_approved_invoice_id_column_project_time_logs', 1),
(437, '2020_04_24_122510_add_approval_required_column_log_time_for', 1),
(438, '2020_04_28_154832_create_seo_details_table', 1),
(439, '2020_05_01_132214_update_package_trial_message', 1),
(440, '2020_05_05_064735_stripe_annual_nullable', 1),
(441, '2020_05_08_073554_add_superadmin_theme_settings_theme_settings_table', 1),
(442, '2020_05_08_132214_alter_global_setting_auth_css_table', 1),
(443, '2020_05_08_132214_alter_global_setting_auth_css_theme_table', 1),
(444, '2020_05_13_070505_change_earning_by_minutes_timelogs', 1),
(445, '2020_05_13_113533_add_receipt_column_payments_table', 1),
(446, '2020_05_14_113533_alter_currency_id_in_packages_table', 1),
(447, '2020_05_19_025644_alter_status_column_in_invoices_table', 1),
(448, '2020_05_19_065735_stripe_annual_plan_nullable', 1),
(449, '2020_05_21_040421_currency_position_settings', 1),
(450, '2020_05_21_041143_create_social_auth_settings_table', 1),
(451, '2020_05_26_084027_add_column_expenses_table', 1),
(452, '2020_05_28_081651_alter_payment_gateway_credentials_table', 1),
(453, '2020_05_29_083029_add_company_id_ticket_replies_table', 1),
(454, '2020_05_30_093624_add_send_status_column_invoices_table', 1),
(455, '2020_06_01_021753_add_storage_columns_in_packages_table', 1),
(456, '2020_06_01_080620_add_send_status_column_estimates_table', 1),
(457, '2020_06_02_160923_add_email_notifications_column_users_table', 1),
(458, '2020_06_03_094515_set_task_category_null_table', 1),
(459, '2020_06_03_132214_alter_front_setting_custom_css_theme_table', 1),
(460, '2020_06_05_030225_alter_status_column_invoices_table', 1),
(461, '2020_06_05_132214_alter_footer_setting_video_table', 1),
(462, '2020_06_10_070614_add_company_id_notifications_table', 1),
(463, '2020_06_10_070614_add_default_language_front_detail_table', 1),
(464, '2020_06_10_132214_alter_footer_menu_setting_table', 1),
(465, '2020_06_12_070614_add_default_language_new_company_table', 1),
(466, '2020_06_15_100530_create_task_tag_list_table', 1),
(467, '2020_06_15_116005_create_task_tags_table', 1),
(468, '2020_06_19_070614_add_company_id_notifications_again_table', 1),
(469, '2020_06_20_030225_alter_task_tags_to_label_table', 1),
(470, '2020_06_25_145817_create_tr_front_details_table', 1),
(471, '2020_06_26_023445_add_contracts_module_permissions_in_permissions_table', 1),
(472, '2020_06_26_131840_add_column_priority_column_leads_table', 1),
(473, '2020_07_03_042627_create_mollie_subscriptions_table', 1),
(474, '2020_07_06_132724_add_language_setting_id_column_in_features_table', 1),
(475, '2020_07_06_171614_add_phone_country_code_column_users_table', 1),
(476, '2020_07_07_2065158_insert_module_setting_client_expense_table', 1),
(477, '2020_07_08_091513_add_language_setting_id_column_in_testimonials_table', 1),
(478, '2020_07_08_131840_add_column_recommended_column_packages_table', 1),
(479, '2020_07_08_2065258_enter_lead_status_id_table', 1),
(480, '2020_07_08_2931840_add_column_category_id_in_template_task_table', 1),
(481, '2020_07_09_053724_add_language_setting_id_column_in_front_clients_table', 1),
(482, '2020_07_09_112754_add_language_setting_id_column_in_front_faqs_table', 1),
(483, '2020_07_10_042018_authorize_payment_integration_migrations_table', 1),
(484, '2020_07_10_083207_add_language_setting_id_column_in_front_menu_buttons_table', 1),
(485, '2020_07_13_045503_add_language_id_column_in_footer_menu_table', 1),
(486, '2020_07_29_112558_alter_package_amount_field', 1),
(487, '2020_08_06_2931840_add_column_status_currency_table', 1),
(488, '2020_08_10_2931840_add_column_attachment_notice_table', 1),
(489, '2020_08_10_2931845_add_column_free_plan_table', 1),
(490, '2020_08_13_114705_set_task_category_id_column_null', 1),
(491, '2020_08_13_2931840_add_column_image_faq_table', 1),
(492, '2020_08_17_2931845_add_free_offline_method_table', 1),
(493, '2020_08_19_051839_create_employee_leave_quotas_table', 1),
(494, '2020_08_20_091702_add_moment_format_column_companies_table', 1),
(495, '2020_08_24_2065258_fix_lead_status_id_table', 1),
(496, '2020_08_25_583130_alter_dashboard_widgets_table', 1),
(497, '2020_08_31_2065258_fix_lead_status_issue_table', 1),
(498, '2020_09_01_134008_default_task_status_column', 1),
(499, '2020_09_03_081839_alter_leads_value_table', 1),
(500, '2020_09_15_114705_change_sort_column_value', 1),
(501, '2020_09_17_196005_create_task_notes_table', 1),
(502, '2020_09_18_104145_add_estimate_fields_tasks_table', 1),
(503, '2020_09_22_111607_add_frontend_disable_column_global_settings', 1),
(504, '2020_09_24_522646_create_expenses_category_table', 1),
(505, '2020_09_28_054230_create_expenses_recurring_table', 1),
(506, '2020_09_30_111248_add_google_recpatcha_status_column_global_settings', 1),
(507, '2020_10_06_081839_add_columns_in_notices_table', 1),
(508, '2020_10_07_522646_create_pinned_table', 1),
(509, '2020_10_13_054230_create_invoice_recurring_table', 1),
(510, '2020_10_19_091702_add_moment_format_default_table', 1),
(511, '2020_10_21_183130_remove_client_feedback_widgets', 1),
(512, '2020_10_23_114705_project_template_user_id_foreign', 1),
(513, '2020_10_29_081839_add_client_id_credit_note_table', 1),
(514, '2020_11_07_090709_add_set_homepage_column_global_settings_table', 1),
(515, '2020_11_10_081303_add_companylogo_address_column_in_contracts_table', 1),
(516, '2020_11_10_114539_add_custom_field_groups', 1),
(517, '2020_11_10_522646_create_front_feature_table', 1),
(518, '2020_11_12_130413_create_faq_files_table', 1),
(519, '2020_11_18_065533_create_lead_custom_forms_table', 1),
(520, '2020_11_18_130413_create_contract_files_table', 1),
(521, '2020_11_19_122122_add_city_state_column_in_client_details_table', 1),
(522, '2020_11_20_063640_add_city_state_in_leads_table', 1),
(523, '2020_11_20_070745_add_city_state_coloumn_in_contracts_table', 1),
(524, '2020_11_23_081331_create_lead_category_table', 1),
(525, '2020_11_23_081804_add_category_id_column_in_leads_table', 1),
(526, '2020_11_25_095815_create_support_ticket_types_table', 1),
(527, '2020_11_25_101600_create_support_tickets_table', 1),
(528, '2020_11_25_101700_create_support_ticket_replies_table', 1),
(529, '2020_11_25_114705_cancel_status_estimate', 1),
(530, '2020_11_25_230413_create_support_ticket_files_table', 1),
(531, '2020_11_26_103829_add_ticket_support_module', 1),
(532, '2020_11_27_092136_create_project_template_sub_tasks_table', 1),
(533, '2020_12_01_092136_create_notice_view_table', 1),
(534, '2020_12_01_103829_add_global_default_locale', 1),
(535, '2020_12_02_055908_add_project_email_setting_to_email_notification_setting_table', 1),
(536, '2020_12_02_103829_add_app_debug_column_superadmin', 1),
(537, '2020_12_03_065533_create_ticket_custom_forms_table', 1),
(538, '2020_12_04_075308_create_client_category_table', 1),
(539, '2020_12_08_075308_create_project_rating_table', 1),
(540, '2020_12_24_065533_migrate_ticket_custom_forms_table', 1),
(541, '2020_12_29_050407_create_event_type_table', 1),
(542, '2020_12_29_055731_create_event_category_table', 1),
(543, '2020_12_29_062559_add_category_id_in_events_table', 1),
(544, '2020_12_31_110336_fix_default_task_status', 1),
(545, '2021_01_04_000003_create_subscription_items_table', 1),
(546, '2021_01_07_134008_default_task_status_column', 1),
(547, '2021_01_08_134008_add_expired_message_in_global_settings_table', 1),
(548, '2021_01_18_062719_add_estimate_terms_column_in_invoice_setting', 1),
(549, '2021_01_21_122157_add_captcha_version_column_in_global_setting', 1),
(550, '2021_01_22_134008_add_new_update_popup_in_global_settings_table', 1),
(551, '2021_01_29_152503_lead_custom_field_name_change', 1),
(552, '2021_02_02_113619_add_deleted_at_column_taxes', 1),
(553, '2021_02_05_055908_add_lead_proposal_email_setting', 1),
(554, '2021_02_08_115655_create_proposal_signs_table', 1),
(555, '2021_02_08_120510_create_notes_table', 1),
(556, '2021_02_08_135533_alter_lead_custom_forms_table', 1),
(557, '2021_02_10_090111_add_send_status_column_contracts_table', 1),
(558, '2021_02_10_090146_add_company_id_in_client_category_table', 1),
(559, '2021_02_10_120841_create_project_notes_table', 1),
(560, '2021_02_12_113619_add_fevicon_column_in_global_settings_table', 1),
(561, '2021_02_12_124422_add_register_enable_column_in_global_settings_table', 1),
(562, '2021_02_15_082045_modify_status_column_in_projects_table', 1),
(563, '2021_02_15_135533_alter_lead_custom_forms_table', 1),
(564, '2021_02_17_114412_change_version_in_global_setting_table', 1),
(565, '2021_02_17_115412_change_client_details_foreign_table', 1),
(566, '2021_02_18_115412_project_status_enum_table', 1),
(567, '2021_02_22_965158_alter_notes_table', 1),
(568, '2021_02_23_092336_create_user_notes_table', 1),
(569, '2021_02_23_094043_add_dashboard_clock_column_company_table', 1),
(570, '2021_02_23_094558_add_is_client_show_column_notes_table', 1),
(571, '2021_02_23_135533_alter_lead_custom_field_table', 1),
(572, '2021_02_24_083209_create_project_user_notes_table', 1),
(573, '2021_02_24_092148_alter_project_notes_table', 1),
(574, '2021_02_24_092817_add_sac_code_invoice_table', 1),
(575, '2021_03_09_045042_create_employee_faq_and_faq_categories_table', 1),
(576, '2021_03_09_130413_create_employee_faq_files_table', 1),
(577, '2021_03_10_110029_create_client_docs_table', 1),
(578, '2021_03_10_135533_add_company_id_event_category_table', 1),
(579, '2021_03_11_035914_default_global_task_remove_foreign_key', 1),
(580, '2021_03_11_113423_fix_default_task_board_colomn_company', 1),
(581, '2021_03_15_145533_add_last_cron_run_in_global_settings_table', 1),
(582, '2021_03_16_163423_seo_image_column_in_seo_details', 1),
(583, '2021_03_25_135533_alter_lead_custom_field_message_lead_table', 1),
(584, '2021_04_05_110352_add_mobile_field_in_ticket_custom_forms_table', 1),
(585, '2021_04_06_135533_alter_ticket_custom_field_message_table', 1),
(586, '2021_04_07_044843_change_comment_column_type_in_task_comments', 1),
(587, '2021_04_14_080502_add_decription_column_in_proposals_table', 1),
(588, '2021_04_16_043432_add_rtl_column_in_companies_table', 1),
(589, '2021_04_16_070540_add_rtl_column_in_global_settings_table', 1),
(590, '2021_04_19_064140_change_date_null_in_task_table', 1),
(591, '2021_04_23_075556_create_task_comment_files_table', 1),
(592, '2021_04_27_052134_add_comment_id_in_task_comment_files_table', 1),
(593, '2021_05_06_115651_add_link_in_front_details', 1),
(594, '2021_05_14_074538_add_event_unique_id_in_events_table', 1),
(595, '2021_05_17_065904_modify_status_column_in_proposals_table', 1),
(596, '2021_05_18_083231_add_send_status_column_in_proposals_table', 1),
(597, '2021_05_20_095231_modify_currency_id_in_packages_table', 1),
(598, '2021_05_21_050747_add_send_reminder_in_invoice_setting_table', 1),
(599, '2021_05_23_130410_lead_category_company_specific', 1),
(600, '2021_05_31_102117_task_share_unique_hash', 1),
(601, '2021_06_07_054429_add_paid_column_in_leaves_table', 1),
(602, '2021_06_07_060250_add_paid_coloumn_in_leave_types', 1),
(603, '2021_06_08_072201_add_close_date_in_ticket_table', 1),
(604, '2021_06_09_061010_alter_category_id_expense_table', 1),
(605, '2021_06_09_081707_add_column_in_packages_table', 1),
(606, '2021_06_09_082208_add_value_in_packages_table', 1),
(607, '2021_06_09_085733_add_column_null_in_packages_table', 1),
(608, '2021_06_09_114015_custom_field_employee_show', 1),
(609, '2021_06_10_073137_create_sign_up_settings_table', 1),
(610, '2021_06_10_114015_add_new_custom_field_group', 1),
(611, '2021_06_14_044650_remove_and_add_column_in_sign_up_setting_table', 1),
(612, '2021_06_14_053146_update_global_settings_registration_closed_table', 1),
(613, '2021_06_14_061858_add_value_in_sign_up_setting_table', 1),
(614, '2021_06_15_095905_create_currency_format_settings_table', 1),
(615, '2021_06_17_052728_alter_leads_agent_id_leads_table', 1),
(616, '2021_06_17_071622_add_last_login_column_in_users_table', 1),
(617, '2021_06_17_103249_add_sample_data_column_in_currency_format_settings_table', 1),
(618, '2021_06_17_130413_create_sub_task_files_table', 1),
(619, '2021_06_18_071622_product_tax_check_array', 1),
(620, '2021_06_21_063108_add_set_null_in_contract_table', 1),
(621, '2021_06_22_130413_attendance_setting_alert', 1),
(622, '2021_06_23_081926_add_payfast_column_in_stripe_setting_table', 1),
(623, '2021_06_23_085038_add_readonly_mode_in_projects_table', 1),
(624, '2021_06_23_095909_add_payfast_column_in_payment_gateway_credentials_table', 1),
(625, '2021_06_23_130413_alter_theme_setting_login_table', 1),
(626, '2021_06_23_130413_create_discussion_files_table', 1),
(627, '2021_06_28_084623_change_paid_coloumn_nullable_in_leave_types_table', 1),
(628, '2021_06_28_121538_add_column_in_payment_and_stripe_setting_table', 1),
(629, '2021_06_29_063243_create_payfast_subscriptions_table', 1),
(630, '2021_06_29_063258_create_payfast_invoices_table', 1),
(631, '2021_06_29_130413_create_expenses_category_roles_table', 1),
(632, '2021_06_30_112056_add_mode_column_in_payment_and_stripe_setting_table', 1),
(633, '2021_10_12_131238_member_details', 1),
(634, '2021_10_12_131356_member_category', 1),
(635, '2021_10_20_110347_member_relations', 1),
(636, '2021_10_20_110405_member_status', 1),
(637, '2021_10_24_160144_create_locations_table', 1),
(638, '2021_10_24_162451_create_levels_table', 1),
(639, '2021_10_24_164500_create_player_groups_table', 1),
(640, '2021_10_24_170931_create_sport_academies_table', 1),
(641, '2021_10_24_180402_level_group_table', 1),
(642, '2021_10_24_185010_level_sport_table', 1),
(643, '2021_10_26_224819_sport_location_table', 1),
(644, '2021_11_06_100127_create_product_category_table', 1),
(645, '2021_11_06_100815_product_sub_category_table', 1),
(646, '2021_11_06_101047_inventories_table', 1),
(647, '2021_11_06_101242_product_statuses_table', 1),
(648, '2021_11_06_101514_product_table', 1),
(649, '2021_11_06_101729_product_inventories_table', 1),
(650, '2021_11_9_0455075_add_column_products_table', 1),
(651, '2021_11_9_071656_add_company_id_in_products_table', 1),
(652, '2021_11_9_082637_add_purchase_allow_in_product_table', 1),
(653, '2021_3_09_135533_add_lead_custom_column_message_table', 1),
(654, '2021_11_13_105101_create_stock_requests_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` int(10) UNSIGNED NOT NULL,
  `module_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `module_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'members', '', NULL, NULL),
(2, 'clients', '', NULL, NULL),
(3, 'employees', '', NULL, NULL),
(4, 'projects', 'User can view the basic details of projects assigned to him even without any permission.', NULL, NULL),
(5, 'attendance', 'User can view his own attendance even without any permission.', NULL, NULL),
(6, 'tasks', 'User can view the tasks assigned to him even without any permission.', NULL, NULL),
(7, 'estimates', '', NULL, NULL),
(8, 'invoices', '', NULL, NULL),
(9, 'payments', '', NULL, NULL),
(10, 'timelogs', '', NULL, NULL),
(11, 'tickets', 'User can view the tickets generated by him as default even without any permission.', NULL, NULL),
(12, 'events', 'User can view the events to be attended by him as default even without any permission.', NULL, NULL),
(13, 'messages', '', NULL, NULL),
(14, 'notices', '', NULL, NULL),
(15, 'leaves', 'User can view the leaves applied by him as default even without any permission.', NULL, NULL),
(16, 'leads', NULL, NULL, NULL),
(17, 'holidays', NULL, '2021-11-10 18:10:07', '2021-11-10 18:10:07'),
(18, 'products', NULL, '2021-11-10 18:10:08', '2021-11-10 18:10:08'),
(19, 'expenses', 'User can view and add(self expenses) the expenses as default even without any permission.', '2021-11-10 18:10:41', '2021-11-10 18:10:41'),
(20, 'contracts', 'User can view all contracts', '2021-11-10 18:13:39', '2021-11-10 18:13:39'),
(21, 'reports', 'Report module', '2021-11-10 18:16:37', '2021-11-10 18:16:37'),
(22, 'ticket support', 'Ticket support', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `module_settings`
--

CREATE TABLE `module_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `module_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('active','deactive') COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('admin','employee','client','member') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'admin',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `module_settings`
--

INSERT INTO `module_settings` (`id`, `company_id`, `module_name`, `status`, `type`, `created_at`, `updated_at`) VALUES
(2, 1, 'clients', 'active', 'employee', '2021-11-10 18:30:13', '2021-11-10 18:30:13'),
(3, 1, 'clients', 'active', 'admin', '2021-11-10 18:30:14', '2021-11-10 18:30:14'),
(4, 1, 'employees', 'active', 'employee', '2021-11-10 18:30:14', '2021-11-10 18:30:14'),
(5, 1, 'employees', 'active', 'admin', '2021-11-10 18:30:14', '2021-11-10 18:30:14'),
(6, 1, 'attendance', 'active', 'employee', '2021-11-10 18:30:14', '2021-11-10 18:30:14'),
(7, 1, 'attendance', 'active', 'admin', '2021-11-10 18:30:14', '2021-11-10 18:30:14'),
(8, 1, 'projects', 'active', 'client', '2021-11-10 18:30:14', '2021-11-10 18:30:14'),
(9, 1, 'projects', 'active', 'employee', '2021-11-10 18:30:14', '2021-11-10 18:30:14'),
(10, 1, 'projects', 'active', 'admin', '2021-11-10 18:30:14', '2021-11-10 18:30:14'),
(11, 1, 'tasks', 'active', 'client', '2021-11-10 18:30:14', '2021-11-10 18:30:14'),
(12, 1, 'tasks', 'active', 'employee', '2021-11-10 18:30:15', '2021-11-10 18:30:15'),
(13, 1, 'tasks', 'active', 'admin', '2021-11-10 18:30:15', '2021-11-10 18:30:15'),
(14, 1, 'estimates', 'active', 'client', '2021-11-10 18:30:15', '2021-11-10 18:30:15'),
(15, 1, 'estimates', 'active', 'employee', '2021-11-10 18:30:15', '2021-11-10 18:30:15'),
(16, 1, 'estimates', 'active', 'admin', '2021-11-10 18:30:15', '2021-11-10 18:30:15'),
(17, 1, 'invoices', 'active', 'client', '2021-11-10 18:30:15', '2021-11-10 18:30:15'),
(18, 1, 'invoices', 'active', 'employee', '2021-11-10 18:30:16', '2021-11-10 18:30:16'),
(19, 1, 'invoices', 'active', 'admin', '2021-11-10 18:30:16', '2021-11-10 18:30:16'),
(20, 1, 'payments', 'active', 'client', '2021-11-10 18:30:16', '2021-11-10 18:30:16'),
(21, 1, 'payments', 'active', 'employee', '2021-11-10 18:30:16', '2021-11-10 18:30:16'),
(22, 1, 'payments', 'active', 'admin', '2021-11-10 18:30:16', '2021-11-10 18:30:16'),
(23, 1, 'expenses', 'active', 'employee', '2021-11-10 18:30:16', '2021-11-10 18:30:16'),
(24, 1, 'expenses', 'active', 'admin', '2021-11-10 18:30:16', '2021-11-10 18:30:16'),
(25, 1, 'timelogs', 'active', 'client', '2021-11-10 18:30:17', '2021-11-10 18:30:17'),
(26, 1, 'timelogs', 'active', 'employee', '2021-11-10 18:30:17', '2021-11-10 18:30:17'),
(27, 1, 'timelogs', 'active', 'admin', '2021-11-10 18:30:17', '2021-11-10 18:30:17'),
(28, 1, 'tickets', 'active', 'client', '2021-11-10 18:30:17', '2021-11-10 18:30:17'),
(29, 1, 'tickets', 'active', 'employee', '2021-11-10 18:30:17', '2021-11-10 18:30:17'),
(30, 1, 'tickets', 'active', 'admin', '2021-11-10 18:30:17', '2021-11-10 18:30:17'),
(31, 1, 'messages', 'active', 'client', '2021-11-10 18:30:17', '2021-11-10 18:30:17'),
(32, 1, 'messages', 'active', 'employee', '2021-11-10 18:30:17', '2021-11-10 18:30:17'),
(33, 1, 'messages', 'active', 'admin', '2021-11-10 18:30:17', '2021-11-10 18:30:17'),
(34, 1, 'events', 'active', 'client', '2021-11-10 18:30:17', '2021-11-10 18:30:17'),
(35, 1, 'events', 'active', 'employee', '2021-11-10 18:30:17', '2021-11-10 18:30:17'),
(36, 1, 'events', 'active', 'admin', '2021-11-10 18:30:17', '2021-11-10 18:30:17'),
(37, 1, 'leaves', 'active', 'employee', '2021-11-10 18:30:18', '2021-11-10 18:30:18'),
(38, 1, 'leaves', 'active', 'admin', '2021-11-10 18:30:18', '2021-11-10 18:30:18'),
(39, 1, 'notices', 'active', 'client', '2021-11-10 18:30:18', '2021-11-10 18:30:18'),
(40, 1, 'notices', 'active', 'employee', '2021-11-10 18:30:18', '2021-11-10 18:30:18'),
(41, 1, 'notices', 'active', 'admin', '2021-11-10 18:30:18', '2021-11-10 18:30:18'),
(42, 1, 'leads', 'active', 'employee', '2021-11-10 18:30:18', '2021-11-10 18:30:18'),
(43, 1, 'leads', 'active', 'admin', '2021-11-10 18:30:18', '2021-11-10 18:30:18'),
(44, 1, 'holidays', 'active', 'employee', '2021-11-10 18:30:18', '2021-11-10 18:30:18'),
(45, 1, 'holidays', 'active', 'admin', '2021-11-10 18:30:18', '2021-11-10 18:30:18'),
(46, 1, 'products', 'active', 'client', '2021-11-10 18:30:18', '2021-11-10 18:30:18'),
(47, 1, 'products', 'active', 'employee', '2021-11-10 18:30:18', '2021-11-10 18:30:18'),
(48, 1, 'products', 'active', 'admin', '2021-11-10 18:30:18', '2021-11-10 18:30:18'),
(49, 1, 'contracts', 'active', 'client', '2021-11-10 18:30:19', '2021-11-10 18:30:19'),
(50, 1, 'contracts', 'active', 'employee', '2021-11-10 18:30:19', '2021-11-10 18:30:19'),
(51, 1, 'contracts', 'active', 'admin', '2021-11-10 18:30:19', '2021-11-10 18:30:19'),
(52, 1, 'reports', 'active', 'employee', '2021-11-10 18:30:19', '2021-11-10 18:30:19'),
(53, 1, 'reports', 'active', 'admin', '2021-11-10 18:30:19', '2021-11-10 18:30:19'),
(54, 2, 'clients', 'active', 'employee', '2021-11-10 18:30:59', '2021-11-10 18:30:59'),
(55, 2, 'clients', 'active', 'admin', '2021-11-10 18:30:59', '2021-11-10 18:30:59'),
(56, 2, 'employees', 'active', 'employee', '2021-11-10 18:30:59', '2021-11-10 18:30:59'),
(57, 2, 'employees', 'active', 'admin', '2021-11-10 18:30:59', '2021-11-10 18:30:59'),
(58, 2, 'attendance', 'active', 'employee', '2021-11-10 18:30:59', '2021-11-10 18:30:59'),
(59, 2, 'attendance', 'active', 'admin', '2021-11-10 18:30:59', '2021-11-10 18:30:59'),
(60, 2, 'projects', 'active', 'client', '2021-11-10 18:30:59', '2021-11-10 18:30:59'),
(61, 2, 'projects', 'active', 'employee', '2021-11-10 18:30:59', '2021-11-10 18:30:59'),
(62, 2, 'projects', 'active', 'admin', '2021-11-10 18:30:59', '2021-11-10 18:30:59'),
(63, 2, 'tasks', 'active', 'client', '2021-11-10 18:30:59', '2021-11-10 18:30:59'),
(64, 2, 'tasks', 'active', 'employee', '2021-11-10 18:31:00', '2021-11-10 18:31:00'),
(65, 2, 'tasks', 'active', 'admin', '2021-11-10 18:31:00', '2021-11-10 18:31:00'),
(66, 2, 'estimates', 'active', 'client', '2021-11-10 18:31:00', '2021-11-10 18:31:00'),
(67, 2, 'estimates', 'active', 'employee', '2021-11-10 18:31:00', '2021-11-10 18:31:00'),
(68, 2, 'estimates', 'active', 'admin', '2021-11-10 18:31:00', '2021-11-10 18:31:00'),
(69, 2, 'invoices', 'active', 'client', '2021-11-10 18:31:00', '2021-11-10 18:31:00'),
(70, 2, 'invoices', 'active', 'employee', '2021-11-10 18:31:00', '2021-11-10 18:31:00'),
(71, 2, 'invoices', 'active', 'admin', '2021-11-10 18:31:01', '2021-11-10 18:31:01'),
(72, 2, 'payments', 'active', 'client', '2021-11-10 18:31:01', '2021-11-10 18:31:01'),
(73, 2, 'payments', 'active', 'employee', '2021-11-10 18:31:01', '2021-11-10 18:31:01'),
(74, 2, 'payments', 'active', 'admin', '2021-11-10 18:31:01', '2021-11-10 18:31:01'),
(75, 2, 'expenses', 'active', 'employee', '2021-11-10 18:31:01', '2021-11-10 18:31:01'),
(76, 2, 'expenses', 'active', 'admin', '2021-11-10 18:31:01', '2021-11-10 18:31:01'),
(77, 2, 'timelogs', 'active', 'client', '2021-11-10 18:31:01', '2021-11-10 18:31:01'),
(78, 2, 'timelogs', 'active', 'employee', '2021-11-10 18:31:01', '2021-11-10 18:31:01'),
(79, 2, 'timelogs', 'active', 'admin', '2021-11-10 18:31:01', '2021-11-10 18:31:01'),
(80, 2, 'tickets', 'active', 'client', '2021-11-10 18:31:02', '2021-11-10 18:31:02'),
(81, 2, 'tickets', 'active', 'employee', '2021-11-10 18:31:02', '2021-11-10 18:31:02'),
(82, 2, 'tickets', 'active', 'admin', '2021-11-10 18:31:02', '2021-11-10 18:31:02'),
(83, 2, 'messages', 'active', 'client', '2021-11-10 18:31:02', '2021-11-10 18:31:02'),
(84, 2, 'messages', 'active', 'employee', '2021-11-10 18:31:02', '2021-11-10 18:31:02'),
(85, 2, 'messages', 'active', 'admin', '2021-11-10 18:31:02', '2021-11-10 18:31:02'),
(86, 2, 'events', 'active', 'client', '2021-11-10 18:31:02', '2021-11-10 18:31:02'),
(87, 2, 'events', 'active', 'employee', '2021-11-10 18:31:02', '2021-11-10 18:31:02'),
(88, 2, 'events', 'active', 'admin', '2021-11-10 18:31:02', '2021-11-10 18:31:02'),
(89, 2, 'leaves', 'active', 'employee', '2021-11-10 18:31:02', '2021-11-10 18:31:02'),
(90, 2, 'leaves', 'active', 'admin', '2021-11-10 18:31:02', '2021-11-10 18:31:02'),
(91, 2, 'notices', 'active', 'client', '2021-11-10 18:31:02', '2021-11-10 18:31:02'),
(92, 2, 'notices', 'active', 'employee', '2021-11-10 18:31:03', '2021-11-10 18:31:03'),
(93, 2, 'notices', 'active', 'admin', '2021-11-10 18:31:03', '2021-11-10 18:31:03'),
(94, 2, 'leads', 'active', 'employee', '2021-11-10 18:31:03', '2021-11-10 18:31:03'),
(95, 2, 'leads', 'active', 'admin', '2021-11-10 18:31:03', '2021-11-10 18:31:03'),
(96, 2, 'holidays', 'active', 'employee', '2021-11-10 18:31:03', '2021-11-10 18:31:03'),
(97, 2, 'holidays', 'active', 'admin', '2021-11-10 18:31:03', '2021-11-10 18:31:03'),
(98, 2, 'products', 'active', 'client', '2021-11-10 18:31:03', '2021-11-10 18:31:03'),
(99, 2, 'products', 'active', 'employee', '2021-11-10 18:31:03', '2021-11-10 18:31:03'),
(100, 2, 'products', 'active', 'admin', '2021-11-10 18:31:04', '2021-11-10 18:31:04'),
(101, 2, 'contracts', 'active', 'client', '2021-11-10 18:31:04', '2021-11-10 18:31:04'),
(102, 2, 'contracts', 'active', 'employee', '2021-11-10 18:31:04', '2021-11-10 18:31:04'),
(103, 2, 'contracts', 'active', 'admin', '2021-11-10 18:31:04', '2021-11-10 18:31:04'),
(104, 2, 'reports', 'active', 'employee', '2021-11-10 18:31:04', '2021-11-10 18:31:04'),
(105, 2, 'reports', 'active', 'admin', '2021-11-10 18:31:05', '2021-11-10 18:31:05'),
(106, 3, 'clients', 'active', 'employee', '2021-11-10 18:31:44', '2021-11-10 18:31:44'),
(107, 3, 'clients', 'active', 'admin', '2021-11-10 18:31:44', '2021-11-10 18:31:44'),
(108, 3, 'employees', 'active', 'employee', '2021-11-10 18:31:45', '2021-11-10 18:31:45'),
(109, 3, 'employees', 'active', 'admin', '2021-11-10 18:31:45', '2021-11-10 18:31:45'),
(110, 3, 'attendance', 'active', 'employee', '2021-11-10 18:31:45', '2021-11-10 18:31:45'),
(111, 3, 'attendance', 'active', 'admin', '2021-11-10 18:31:45', '2021-11-10 18:31:45'),
(112, 3, 'projects', 'active', 'client', '2021-11-10 18:31:45', '2021-11-10 18:31:45'),
(113, 3, 'projects', 'active', 'employee', '2021-11-10 18:31:46', '2021-11-10 18:31:46'),
(114, 3, 'projects', 'active', 'admin', '2021-11-10 18:31:46', '2021-11-10 18:31:46'),
(115, 3, 'tasks', 'active', 'client', '2021-11-10 18:31:46', '2021-11-10 18:31:46'),
(116, 3, 'tasks', 'active', 'employee', '2021-11-10 18:31:47', '2021-11-10 18:31:47'),
(117, 3, 'tasks', 'active', 'admin', '2021-11-10 18:31:47', '2021-11-10 18:31:47'),
(118, 3, 'estimates', 'active', 'client', '2021-11-10 18:31:47', '2021-11-10 18:31:47'),
(119, 3, 'estimates', 'active', 'employee', '2021-11-10 18:31:47', '2021-11-10 18:31:47'),
(120, 3, 'estimates', 'active', 'admin', '2021-11-10 18:31:48', '2021-11-10 18:31:48'),
(121, 3, 'invoices', 'active', 'client', '2021-11-10 18:31:48', '2021-11-10 18:31:48'),
(122, 3, 'invoices', 'active', 'employee', '2021-11-10 18:31:48', '2021-11-10 18:31:48'),
(123, 3, 'invoices', 'active', 'admin', '2021-11-10 18:31:48', '2021-11-10 18:31:48'),
(124, 3, 'payments', 'active', 'client', '2021-11-10 18:31:49', '2021-11-10 18:31:49'),
(125, 3, 'payments', 'active', 'employee', '2021-11-10 18:31:49', '2021-11-10 18:31:49'),
(126, 3, 'payments', 'active', 'admin', '2021-11-10 18:31:49', '2021-11-10 18:31:49'),
(127, 3, 'expenses', 'active', 'employee', '2021-11-10 18:31:49', '2021-11-10 18:31:49'),
(128, 3, 'expenses', 'active', 'admin', '2021-11-10 18:31:50', '2021-11-10 18:31:50'),
(129, 3, 'timelogs', 'active', 'client', '2021-11-10 18:31:50', '2021-11-10 18:31:50'),
(130, 3, 'timelogs', 'active', 'employee', '2021-11-10 18:31:50', '2021-11-10 18:31:50'),
(131, 3, 'timelogs', 'active', 'admin', '2021-11-10 18:31:50', '2021-11-10 18:31:50'),
(132, 3, 'tickets', 'active', 'client', '2021-11-10 18:31:50', '2021-11-10 18:31:50'),
(133, 3, 'tickets', 'active', 'employee', '2021-11-10 18:31:50', '2021-11-10 18:31:50'),
(134, 3, 'tickets', 'active', 'admin', '2021-11-10 18:31:51', '2021-11-10 18:31:51'),
(135, 3, 'messages', 'active', 'client', '2021-11-10 18:31:51', '2021-11-10 18:31:51'),
(136, 3, 'messages', 'active', 'employee', '2021-11-10 18:31:51', '2021-11-10 18:31:51'),
(137, 3, 'messages', 'active', 'admin', '2021-11-10 18:31:51', '2021-11-10 18:31:51'),
(138, 3, 'events', 'active', 'client', '2021-11-10 18:31:51', '2021-11-10 18:31:51'),
(139, 3, 'events', 'active', 'employee', '2021-11-10 18:31:51', '2021-11-10 18:31:51'),
(140, 3, 'events', 'active', 'admin', '2021-11-10 18:31:51', '2021-11-10 18:31:51'),
(141, 3, 'leaves', 'active', 'employee', '2021-11-10 18:31:51', '2021-11-10 18:31:51'),
(142, 3, 'leaves', 'active', 'admin', '2021-11-10 18:31:52', '2021-11-10 18:31:52'),
(143, 3, 'notices', 'active', 'client', '2021-11-10 18:31:53', '2021-11-10 18:31:53'),
(144, 3, 'notices', 'active', 'employee', '2021-11-10 18:31:53', '2021-11-10 18:31:53'),
(145, 3, 'notices', 'active', 'admin', '2021-11-10 18:31:53', '2021-11-10 18:31:53'),
(146, 3, 'leads', 'active', 'employee', '2021-11-10 18:31:54', '2021-11-10 18:31:54'),
(147, 3, 'leads', 'active', 'admin', '2021-11-10 18:31:54', '2021-11-10 18:31:54'),
(148, 3, 'holidays', 'active', 'employee', '2021-11-10 18:31:54', '2021-11-10 18:31:54'),
(149, 3, 'holidays', 'active', 'admin', '2021-11-10 18:31:54', '2021-11-10 18:31:54'),
(150, 3, 'products', 'active', 'client', '2021-11-10 18:31:54', '2021-11-10 18:31:54'),
(151, 3, 'products', 'active', 'employee', '2021-11-10 18:31:54', '2021-11-10 18:31:54'),
(152, 3, 'products', 'active', 'admin', '2021-11-10 18:31:54', '2021-11-10 18:31:54'),
(153, 3, 'contracts', 'active', 'client', '2021-11-10 18:31:55', '2021-11-10 18:31:55'),
(154, 3, 'contracts', 'active', 'employee', '2021-11-10 18:31:55', '2021-11-10 18:31:55'),
(155, 3, 'contracts', 'active', 'admin', '2021-11-10 18:31:55', '2021-11-10 18:31:55'),
(156, 3, 'reports', 'active', 'employee', '2021-11-10 18:31:55', '2021-11-10 18:31:55'),
(157, 3, 'reports', 'active', 'admin', '2021-11-10 18:31:55', '2021-11-10 18:31:55'),
(158, 4, 'clients', 'active', 'employee', '2021-11-10 18:32:20', '2021-11-10 18:32:20'),
(159, 4, 'clients', 'active', 'admin', '2021-11-10 18:32:21', '2021-11-10 18:32:21'),
(160, 4, 'employees', 'active', 'employee', '2021-11-10 18:32:21', '2021-11-10 18:32:21'),
(161, 4, 'employees', 'active', 'admin', '2021-11-10 18:32:21', '2021-11-10 18:32:21'),
(162, 4, 'attendance', 'active', 'employee', '2021-11-10 18:32:21', '2021-11-10 18:32:21'),
(163, 4, 'attendance', 'active', 'admin', '2021-11-10 18:32:21', '2021-11-10 18:32:21'),
(164, 4, 'projects', 'active', 'client', '2021-11-10 18:32:22', '2021-11-10 18:32:22'),
(165, 4, 'projects', 'active', 'employee', '2021-11-10 18:32:22', '2021-11-10 18:32:22'),
(166, 4, 'projects', 'active', 'admin', '2021-11-10 18:32:22', '2021-11-10 18:32:22'),
(167, 4, 'tasks', 'active', 'client', '2021-11-10 18:32:22', '2021-11-10 18:32:22'),
(168, 4, 'tasks', 'active', 'employee', '2021-11-10 18:32:22', '2021-11-10 18:32:22'),
(169, 4, 'tasks', 'active', 'admin', '2021-11-10 18:32:22', '2021-11-10 18:32:22'),
(170, 4, 'estimates', 'active', 'client', '2021-11-10 18:32:22', '2021-11-10 18:32:22'),
(171, 4, 'estimates', 'active', 'employee', '2021-11-10 18:32:23', '2021-11-10 18:32:23'),
(172, 4, 'estimates', 'active', 'admin', '2021-11-10 18:32:23', '2021-11-10 18:32:23'),
(173, 4, 'invoices', 'active', 'client', '2021-11-10 18:32:23', '2021-11-10 18:32:23'),
(174, 4, 'invoices', 'active', 'employee', '2021-11-10 18:32:23', '2021-11-10 18:32:23'),
(175, 4, 'invoices', 'active', 'admin', '2021-11-10 18:32:23', '2021-11-10 18:32:23'),
(176, 4, 'payments', 'active', 'client', '2021-11-10 18:32:23', '2021-11-10 18:32:23'),
(177, 4, 'payments', 'active', 'employee', '2021-11-10 18:32:23', '2021-11-10 18:32:23'),
(178, 4, 'payments', 'active', 'admin', '2021-11-10 18:32:23', '2021-11-10 18:32:23'),
(179, 4, 'expenses', 'active', 'employee', '2021-11-10 18:32:24', '2021-11-10 18:32:24'),
(180, 4, 'expenses', 'active', 'admin', '2021-11-10 18:32:24', '2021-11-10 18:32:24'),
(181, 4, 'timelogs', 'active', 'client', '2021-11-10 18:32:24', '2021-11-10 18:32:24'),
(182, 4, 'timelogs', 'active', 'employee', '2021-11-10 18:32:24', '2021-11-10 18:32:24'),
(183, 4, 'timelogs', 'active', 'admin', '2021-11-10 18:32:24', '2021-11-10 18:32:24'),
(184, 4, 'tickets', 'active', 'client', '2021-11-10 18:32:24', '2021-11-10 18:32:24'),
(185, 4, 'tickets', 'active', 'employee', '2021-11-10 18:32:24', '2021-11-10 18:32:24'),
(186, 4, 'tickets', 'active', 'admin', '2021-11-10 18:32:25', '2021-11-10 18:32:25'),
(187, 4, 'messages', 'active', 'client', '2021-11-10 18:32:25', '2021-11-10 18:32:25'),
(188, 4, 'messages', 'active', 'employee', '2021-11-10 18:32:25', '2021-11-10 18:32:25'),
(189, 4, 'messages', 'active', 'admin', '2021-11-10 18:32:25', '2021-11-10 18:32:25'),
(190, 4, 'events', 'active', 'client', '2021-11-10 18:32:25', '2021-11-10 18:32:25'),
(191, 4, 'events', 'active', 'employee', '2021-11-10 18:32:25', '2021-11-10 18:32:25'),
(192, 4, 'events', 'active', 'admin', '2021-11-10 18:32:25', '2021-11-10 18:32:25'),
(193, 4, 'leaves', 'active', 'employee', '2021-11-10 18:32:25', '2021-11-10 18:32:25'),
(194, 4, 'leaves', 'active', 'admin', '2021-11-10 18:32:25', '2021-11-10 18:32:25'),
(195, 4, 'notices', 'active', 'client', '2021-11-10 18:32:26', '2021-11-10 18:32:26'),
(196, 4, 'notices', 'active', 'employee', '2021-11-10 18:32:26', '2021-11-10 18:32:26'),
(197, 4, 'notices', 'active', 'admin', '2021-11-10 18:32:26', '2021-11-10 18:32:26'),
(198, 4, 'leads', 'active', 'employee', '2021-11-10 18:32:26', '2021-11-10 18:32:26'),
(199, 4, 'leads', 'active', 'admin', '2021-11-10 18:32:26', '2021-11-10 18:32:26'),
(200, 4, 'holidays', 'active', 'employee', '2021-11-10 18:32:26', '2021-11-10 18:32:26'),
(201, 4, 'holidays', 'active', 'admin', '2021-11-10 18:32:26', '2021-11-10 18:32:26'),
(202, 4, 'products', 'active', 'client', '2021-11-10 18:32:26', '2021-11-10 18:32:26'),
(203, 4, 'products', 'active', 'employee', '2021-11-10 18:32:27', '2021-11-10 18:32:27'),
(204, 4, 'products', 'active', 'admin', '2021-11-10 18:32:27', '2021-11-10 18:32:27'),
(205, 4, 'contracts', 'active', 'client', '2021-11-10 18:32:27', '2021-11-10 18:32:27'),
(206, 4, 'contracts', 'active', 'employee', '2021-11-10 18:32:27', '2021-11-10 18:32:27'),
(207, 4, 'contracts', 'active', 'admin', '2021-11-10 18:32:27', '2021-11-10 18:32:27'),
(208, 4, 'reports', 'active', 'employee', '2021-11-10 18:32:28', '2021-11-10 18:32:28'),
(209, 4, 'reports', 'active', 'admin', '2021-11-10 18:32:28', '2021-11-10 18:32:28'),
(210, 5, 'clients', 'active', 'employee', '2021-11-10 18:33:02', '2021-11-10 18:33:02'),
(211, 5, 'clients', 'active', 'admin', '2021-11-10 18:33:02', '2021-11-10 18:33:02'),
(212, 5, 'employees', 'active', 'employee', '2021-11-10 18:33:02', '2021-11-10 18:33:02'),
(213, 5, 'employees', 'active', 'admin', '2021-11-10 18:33:02', '2021-11-10 18:33:02'),
(214, 5, 'attendance', 'active', 'employee', '2021-11-10 18:33:03', '2021-11-10 18:33:03'),
(215, 5, 'attendance', 'active', 'admin', '2021-11-10 18:33:03', '2021-11-10 18:33:03'),
(216, 5, 'projects', 'active', 'client', '2021-11-10 18:33:03', '2021-11-10 18:33:03'),
(217, 5, 'projects', 'active', 'employee', '2021-11-10 18:33:03', '2021-11-10 18:33:03'),
(218, 5, 'projects', 'active', 'admin', '2021-11-10 18:33:03', '2021-11-10 18:33:03'),
(219, 5, 'tasks', 'active', 'client', '2021-11-10 18:33:03', '2021-11-10 18:33:03'),
(220, 5, 'tasks', 'active', 'employee', '2021-11-10 18:33:03', '2021-11-10 18:33:03'),
(221, 5, 'tasks', 'active', 'admin', '2021-11-10 18:33:04', '2021-11-10 18:33:04'),
(222, 5, 'estimates', 'active', 'client', '2021-11-10 18:33:04', '2021-11-10 18:33:04'),
(223, 5, 'estimates', 'active', 'employee', '2021-11-10 18:33:04', '2021-11-10 18:33:04'),
(224, 5, 'estimates', 'active', 'admin', '2021-11-10 18:33:04', '2021-11-10 18:33:04'),
(225, 5, 'invoices', 'active', 'client', '2021-11-10 18:33:05', '2021-11-10 18:33:05'),
(226, 5, 'invoices', 'active', 'employee', '2021-11-10 18:33:05', '2021-11-10 18:33:05'),
(227, 5, 'invoices', 'active', 'admin', '2021-11-10 18:33:05', '2021-11-10 18:33:05'),
(228, 5, 'payments', 'active', 'client', '2021-11-10 18:33:05', '2021-11-10 18:33:05'),
(229, 5, 'payments', 'active', 'employee', '2021-11-10 18:33:06', '2021-11-10 18:33:06'),
(230, 5, 'payments', 'active', 'admin', '2021-11-10 18:33:06', '2021-11-10 18:33:06'),
(231, 5, 'expenses', 'active', 'employee', '2021-11-10 18:33:06', '2021-11-10 18:33:06'),
(232, 5, 'expenses', 'active', 'admin', '2021-11-10 18:33:06', '2021-11-10 18:33:06'),
(233, 5, 'timelogs', 'active', 'client', '2021-11-10 18:33:06', '2021-11-10 18:33:06'),
(234, 5, 'timelogs', 'active', 'employee', '2021-11-10 18:33:07', '2021-11-10 18:33:07'),
(235, 5, 'timelogs', 'active', 'admin', '2021-11-10 18:33:07', '2021-11-10 18:33:07'),
(236, 5, 'tickets', 'active', 'client', '2021-11-10 18:33:07', '2021-11-10 18:33:07'),
(237, 5, 'tickets', 'active', 'employee', '2021-11-10 18:33:08', '2021-11-10 18:33:08'),
(238, 5, 'tickets', 'active', 'admin', '2021-11-10 18:33:08', '2021-11-10 18:33:08'),
(239, 5, 'messages', 'active', 'client', '2021-11-10 18:33:08', '2021-11-10 18:33:08'),
(240, 5, 'messages', 'active', 'employee', '2021-11-10 18:33:08', '2021-11-10 18:33:08'),
(241, 5, 'messages', 'active', 'admin', '2021-11-10 18:33:08', '2021-11-10 18:33:08'),
(242, 5, 'events', 'active', 'client', '2021-11-10 18:33:09', '2021-11-10 18:33:09'),
(243, 5, 'events', 'active', 'employee', '2021-11-10 18:33:09', '2021-11-10 18:33:09'),
(244, 5, 'events', 'active', 'admin', '2021-11-10 18:33:09', '2021-11-10 18:33:09'),
(245, 5, 'leaves', 'active', 'employee', '2021-11-10 18:33:09', '2021-11-10 18:33:09'),
(246, 5, 'leaves', 'active', 'admin', '2021-11-10 18:33:09', '2021-11-10 18:33:09'),
(247, 5, 'notices', 'active', 'client', '2021-11-10 18:33:09', '2021-11-10 18:33:09'),
(248, 5, 'notices', 'active', 'employee', '2021-11-10 18:33:09', '2021-11-10 18:33:09'),
(249, 5, 'notices', 'active', 'admin', '2021-11-10 18:33:10', '2021-11-10 18:33:10'),
(250, 5, 'leads', 'active', 'employee', '2021-11-10 18:33:10', '2021-11-10 18:33:10'),
(251, 5, 'leads', 'active', 'admin', '2021-11-10 18:33:10', '2021-11-10 18:33:10'),
(252, 5, 'holidays', 'active', 'employee', '2021-11-10 18:33:10', '2021-11-10 18:33:10'),
(253, 5, 'holidays', 'active', 'admin', '2021-11-10 18:33:10', '2021-11-10 18:33:10'),
(254, 5, 'products', 'active', 'client', '2021-11-10 18:33:10', '2021-11-10 18:33:10'),
(255, 5, 'products', 'active', 'employee', '2021-11-10 18:33:11', '2021-11-10 18:33:11'),
(256, 5, 'products', 'active', 'admin', '2021-11-10 18:33:11', '2021-11-10 18:33:11'),
(257, 5, 'contracts', 'active', 'client', '2021-11-10 18:33:11', '2021-11-10 18:33:11'),
(258, 5, 'contracts', 'active', 'employee', '2021-11-10 18:33:11', '2021-11-10 18:33:11'),
(259, 5, 'contracts', 'active', 'admin', '2021-11-10 18:33:11', '2021-11-10 18:33:11'),
(260, 5, 'reports', 'active', 'employee', '2021-11-10 18:33:11', '2021-11-10 18:33:11'),
(261, 5, 'reports', 'active', 'admin', '2021-11-10 18:33:11', '2021-11-10 18:33:11'),
(262, 6, 'clients', 'active', 'employee', '2021-11-10 18:33:44', '2021-11-10 18:33:44'),
(263, 6, 'clients', 'active', 'admin', '2021-11-10 18:33:44', '2021-11-10 18:33:44'),
(264, 6, 'employees', 'active', 'employee', '2021-11-10 18:33:44', '2021-11-10 18:33:44'),
(265, 6, 'employees', 'active', 'admin', '2021-11-10 18:33:44', '2021-11-10 18:33:44'),
(266, 6, 'attendance', 'active', 'employee', '2021-11-10 18:33:44', '2021-11-10 18:33:44'),
(267, 6, 'attendance', 'active', 'admin', '2021-11-10 18:33:44', '2021-11-10 18:33:44'),
(268, 6, 'projects', 'active', 'client', '2021-11-10 18:33:44', '2021-11-10 18:33:44'),
(269, 6, 'projects', 'active', 'employee', '2021-11-10 18:33:45', '2021-11-10 18:33:45'),
(270, 6, 'projects', 'active', 'admin', '2021-11-10 18:33:45', '2021-11-10 18:33:45'),
(271, 6, 'tasks', 'active', 'client', '2021-11-10 18:33:45', '2021-11-10 18:33:45'),
(272, 6, 'tasks', 'active', 'employee', '2021-11-10 18:33:45', '2021-11-10 18:33:45'),
(273, 6, 'tasks', 'active', 'admin', '2021-11-10 18:33:45', '2021-11-10 18:33:45'),
(274, 6, 'estimates', 'active', 'client', '2021-11-10 18:33:45', '2021-11-10 18:33:45'),
(275, 6, 'estimates', 'active', 'employee', '2021-11-10 18:33:45', '2021-11-10 18:33:45'),
(276, 6, 'estimates', 'active', 'admin', '2021-11-10 18:33:46', '2021-11-10 18:33:46'),
(277, 6, 'invoices', 'active', 'client', '2021-11-10 18:33:46', '2021-11-10 18:33:46'),
(278, 6, 'invoices', 'active', 'employee', '2021-11-10 18:33:46', '2021-11-10 18:33:46'),
(279, 6, 'invoices', 'active', 'admin', '2021-11-10 18:33:46', '2021-11-10 18:33:46'),
(280, 6, 'payments', 'active', 'client', '2021-11-10 18:33:47', '2021-11-10 18:33:47'),
(281, 6, 'payments', 'active', 'employee', '2021-11-10 18:33:47', '2021-11-10 18:33:47'),
(282, 6, 'payments', 'active', 'admin', '2021-11-10 18:33:47', '2021-11-10 18:33:47'),
(283, 6, 'expenses', 'active', 'employee', '2021-11-10 18:33:47', '2021-11-10 18:33:47'),
(284, 6, 'expenses', 'active', 'admin', '2021-11-10 18:33:47', '2021-11-10 18:33:47'),
(285, 6, 'timelogs', 'active', 'client', '2021-11-10 18:33:48', '2021-11-10 18:33:48'),
(286, 6, 'timelogs', 'active', 'employee', '2021-11-10 18:33:48', '2021-11-10 18:33:48'),
(287, 6, 'timelogs', 'active', 'admin', '2021-11-10 18:33:48', '2021-11-10 18:33:48'),
(288, 6, 'tickets', 'active', 'client', '2021-11-10 18:33:48', '2021-11-10 18:33:48'),
(289, 6, 'tickets', 'active', 'employee', '2021-11-10 18:33:49', '2021-11-10 18:33:49'),
(290, 6, 'tickets', 'active', 'admin', '2021-11-10 18:33:49', '2021-11-10 18:33:49'),
(291, 6, 'messages', 'active', 'client', '2021-11-10 18:33:49', '2021-11-10 18:33:49'),
(292, 6, 'messages', 'active', 'employee', '2021-11-10 18:33:49', '2021-11-10 18:33:49'),
(293, 6, 'messages', 'active', 'admin', '2021-11-10 18:33:49', '2021-11-10 18:33:49'),
(294, 6, 'events', 'active', 'client', '2021-11-10 18:33:50', '2021-11-10 18:33:50'),
(295, 6, 'events', 'active', 'employee', '2021-11-10 18:33:50', '2021-11-10 18:33:50'),
(296, 6, 'events', 'active', 'admin', '2021-11-10 18:33:50', '2021-11-10 18:33:50'),
(297, 6, 'leaves', 'active', 'employee', '2021-11-10 18:33:50', '2021-11-10 18:33:50'),
(298, 6, 'leaves', 'active', 'admin', '2021-11-10 18:33:50', '2021-11-10 18:33:50'),
(299, 6, 'notices', 'active', 'client', '2021-11-10 18:33:51', '2021-11-10 18:33:51'),
(300, 6, 'notices', 'active', 'employee', '2021-11-10 18:33:51', '2021-11-10 18:33:51'),
(301, 6, 'notices', 'active', 'admin', '2021-11-10 18:33:51', '2021-11-10 18:33:51'),
(302, 6, 'leads', 'active', 'employee', '2021-11-10 18:33:51', '2021-11-10 18:33:51'),
(303, 6, 'leads', 'active', 'admin', '2021-11-10 18:33:51', '2021-11-10 18:33:51'),
(304, 6, 'holidays', 'active', 'employee', '2021-11-10 18:33:52', '2021-11-10 18:33:52'),
(305, 6, 'holidays', 'active', 'admin', '2021-11-10 18:33:52', '2021-11-10 18:33:52'),
(306, 6, 'products', 'active', 'client', '2021-11-10 18:33:53', '2021-11-10 18:33:53'),
(307, 6, 'products', 'active', 'employee', '2021-11-10 18:33:53', '2021-11-10 18:33:53'),
(308, 6, 'products', 'active', 'admin', '2021-11-10 18:33:53', '2021-11-10 18:33:53'),
(309, 6, 'contracts', 'active', 'client', '2021-11-10 18:33:53', '2021-11-10 18:33:53'),
(310, 6, 'contracts', 'active', 'employee', '2021-11-10 18:33:54', '2021-11-10 18:33:54'),
(311, 6, 'contracts', 'active', 'admin', '2021-11-10 18:33:54', '2021-11-10 18:33:54'),
(312, 6, 'reports', 'active', 'employee', '2021-11-10 18:33:54', '2021-11-10 18:33:54'),
(313, 6, 'reports', 'active', 'admin', '2021-11-10 18:33:54', '2021-11-10 18:33:54');

-- rola
(314, 6, 'PublicRelationsDepartment', 'active', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `mollie_invoices`
--

CREATE TABLE `mollie_invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `package_id` int(10) UNSIGNED NOT NULL,
  `transaction_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `package_type` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pay_date` date DEFAULT NULL,
  `next_pay_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mollie_subscriptions`
--

CREATE TABLE `mollie_subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `customer_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subscription_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `notes_title` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `notes_type` tinyint(1) NOT NULL DEFAULT 0,
  `client_id` int(10) UNSIGNED DEFAULT NULL,
  `ask_password` tinyint(1) NOT NULL DEFAULT 0,
  `note_details` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_client_show` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE `notices` (
  `id` int(10) UNSIGNED NOT NULL,
  `to` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'employee',
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `heading` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `attachment` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `department_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notice_views`
--

CREATE TABLE `notice_views` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `notice_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `type` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `notifiable_type` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text COLLATE utf8_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offline_invoices`
--

CREATE TABLE `offline_invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `package_id` int(10) UNSIGNED NOT NULL,
  `package_type` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `offline_method_id` int(10) UNSIGNED DEFAULT NULL,
  `transaction_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `amount` decimal(12,2) UNSIGNED NOT NULL,
  `pay_date` date NOT NULL,
  `next_pay_date` date DEFAULT NULL,
  `status` enum('paid','unpaid','pending') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offline_invoice_payments`
--

CREATE TABLE `offline_invoice_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `payment_method_id` int(10) UNSIGNED NOT NULL,
  `slip` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('pending','approve','reject') COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offline_payment_methods`
--

CREATE TABLE `offline_payment_methods` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('yes','no') COLLATE utf8_unicode_ci DEFAULT 'yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offline_plan_changes`
--

CREATE TABLE `offline_plan_changes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `package_id` int(10) UNSIGNED NOT NULL,
  `package_type` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `offline_method_id` int(10) UNSIGNED NOT NULL,
  `file_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('verified','pending','rejected') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int(10) UNSIGNED NOT NULL,
  `currency_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `max_storage_size` varchar(255) COLLATE utf8_unicode_ci DEFAULT '-1',
  `max_file_size` int(10) UNSIGNED DEFAULT NULL,
  `annual_price` decimal(10,0) UNSIGNED DEFAULT NULL,
  `monthly_price` decimal(10,0) UNSIGNED DEFAULT NULL,
  `billing_cycle` tinyint(3) UNSIGNED DEFAULT NULL,
  `max_employees` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `sort` int(11) DEFAULT NULL,
  `module_in_package` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `stripe_annual_plan_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `razorpay_annual_plan_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `razorpay_monthly_plan_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stripe_monthly_plan_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paystack_monthly_plan_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paystack_annual_plan_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `default` enum('yes','no','trial') COLLATE utf8_unicode_ci DEFAULT 'no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_private` tinyint(1) NOT NULL,
  `storage_unit` enum('gb','mb') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'mb',
  `is_recommended` tinyint(1) NOT NULL DEFAULT 0,
  `is_free` tinyint(1) NOT NULL DEFAULT 0,
  `is_auto_renew` tinyint(1) NOT NULL DEFAULT 0,
  `monthly_status` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `annual_status` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `currency_id`, `name`, `description`, `max_storage_size`, `max_file_size`, `annual_price`, `monthly_price`, `billing_cycle`, `max_employees`, `sort`, `module_in_package`, `stripe_annual_plan_id`, `razorpay_annual_plan_id`, `razorpay_monthly_plan_id`, `stripe_monthly_plan_id`, `paystack_monthly_plan_id`, `paystack_annual_plan_id`, `default`, `created_at`, `updated_at`, `is_private`, `storage_unit`, `is_recommended`, `is_free`, `is_auto_renew`, `monthly_status`, `annual_status`) VALUES
(1, 1, 'Default', 'Its a default package and cannot be deleted', '-1', NULL, '0', '0', NULL, 20, 0, '{\"1\":\"clients\",\"2\":\"employees\",\"3\":\"attendance\",\"4\":\"projects\",\"5\":\"tasks\",\"6\":\"estimates\",\"7\":\"invoices\",\"8\":\"payments\",\"9\":\"expenses\",\"10\":\"timelogs\",\"11\":\"tickets\",\"12\":\"messages\",\"13\":\"events\",\"14\":\"leaves\",\"15\":\"notices\",\"16\":\"leads\",\"17\":\"holidays\",\"18\":\"products\",\"19\":\"contracts\",\"20\":\"reports\"}', 'default_plan', NULL, NULL, 'default_plan', NULL, NULL, 'yes', '2021-11-10 18:11:51', '2021-11-10 18:29:56', 0, 'mb', 0, 0, 0, '1', '1'),
(2, 1, 'Trial', 'Its a trial package', '-1', NULL, '0', '0', NULL, 20, 0, '{\"1\":\"clients\",\"2\":\"employees\",\"3\":\"projects\",\"4\":\"attendance\",\"5\":\"tasks\",\"6\":\"estimates\",\"7\":\"invoices\",\"8\":\"payments\",\"9\":\"timelogs\",\"10\":\"tickets\",\"11\":\"events\",\"12\":\"messages\",\"13\":\"notices\",\"14\":\"leaves\",\"15\":\"leads\",\"16\":\"holidays\",\"17\":\"products\",\"18\":\"expenses\",\"19\":\"contracts\",\"20\":\"reports\",\"21\":\"contracts\",\"22\":\"reports\"}', 'trial_plan', NULL, NULL, 'trial_plan', NULL, NULL, 'trial', '2021-11-10 18:11:52', '2021-11-10 18:29:56', 0, 'mb', 0, 0, 0, '1', '1'),
(3, 1, 'Free', 'It\'s a free package.', '-1', 10, NULL, NULL, NULL, 20, 0, '{\"1\":\"clients\",\"2\":\"employees\",\"3\":\"attendance\",\"4\":\"projects\",\"5\":\"tasks\",\"6\":\"estimates\",\"7\":\"invoices\",\"8\":\"payments\",\"9\":\"expenses\",\"10\":\"timelogs\",\"11\":\"tickets\",\"12\":\"messages\",\"13\":\"events\",\"14\":\"leaves\",\"15\":\"notices\",\"16\":\"leads\",\"17\":\"holidays\",\"18\":\"products\",\"19\":\"member\"}', NULL, NULL, NULL, NULL, NULL, NULL, 'no', '2021-11-10 18:29:57', '2021-11-10 18:29:57', 0, 'mb', 0, 0, 0, NULL, NULL),
(4, 1, 'Starter', 'Quidem deserunt nobis asperiores fuga Ullamco corporis culpa', '-1', 30, '500', '50', 10, 50, 1, '{\"1\":\"clients\",\"2\":\"employees\",\"3\":\"attendance\",\"4\":\"projects\",\"5\":\"tasks\",\"6\":\"estimates\",\"7\":\"invoices\",\"8\":\"payments\",\"9\":\"expenses\",\"10\":\"timelogs\",\"11\":\"tickets\",\"17\":\"holidays\",\"18\":\"member\"}', 'starter_annual', NULL, NULL, 'starter_monthly', NULL, NULL, 'no', '2021-11-10 18:29:57', '2021-11-10 18:29:57', 0, 'mb', 0, 0, 0, NULL, NULL),
(5, 1, 'Medium', 'Quidem deserunt nobis asperiores fuga Ullamco corporis culpa', '-1', 50, '1000', '100', 10, 100, 2, '{\"1\":\"clients\",\"2\":\"employees\",\"3\":\"attendance\",\"4\":\"projects\",\"5\":\"tasks\",\"6\":\"estimates\",\"7\":\"invoices\",\"8\":\"payments\",\"9\":\"expenses\",\"10\":\"timelogs\",\"11\":\"tickets\",\"12\":\"messages\",\"13\":\"events\",\"14\":\"leaves\",\"15\":\"notices\",\"16\":\"leads\",\"17\":\"holidays\",\"18\":\"member\"}', 'medium_annual', NULL, NULL, 'medium_monthly', NULL, NULL, 'no', '2021-11-10 18:29:57', '2021-11-10 18:29:57', 0, 'mb', 0, 0, 0, NULL, NULL),
(6, 1, 'Larger', 'Quidem deserunt nobis asperiores fuga Ullamco corporis culpa', '-1', 100, '5000', '500', 10, 500, 3, '{\"1\":\"clients\",\"2\":\"employees\",\"3\":\"attendance\",\"4\":\"projects\",\"5\":\"tasks\",\"6\":\"estimates\",\"7\":\"invoices\",\"8\":\"payments\",\"9\":\"expenses\",\"10\":\"timelogs\",\"11\":\"tickets\",\"12\":\"messages\",\"13\":\"events\",\"14\":\"leaves\",\"15\":\"notices\",\"16\":\"leads\",\"17\":\"holidays\",\"18\":\"products\",\"19\":\"member\"}', 'larger_annual', NULL, NULL, 'larger_monthly', NULL, NULL, 'no', '2021-11-10 18:29:58', '2021-11-10 18:29:58', 0, 'mb', 0, 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `package_settings`
--

CREATE TABLE `package_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'inactive',
  `no_of_days` int(11) DEFAULT 30,
  `modules` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trial_message` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `notification_before` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `package_settings`
--

INSERT INTO `package_settings` (`id`, `status`, `no_of_days`, `modules`, `trial_message`, `notification_before`, `created_at`, `updated_at`) VALUES
(1, 'inactive', 30, '{\"1\":\"clients\",\"2\":\"employees\",\"3\":\"projects\",\"4\":\"attendance\",\"5\":\"tasks\",\"6\":\"estimates\",\"7\":\"invoices\",\"8\":\"payments\",\"9\":\"timelogs\",\"10\":\"tickets\",\"11\":\"events\",\"12\":\"messages\",\"13\":\"notices\",\"14\":\"leaves\",\"15\":\"leads\",\"16\":\"holidays\",\"17\":\"products\",\"18\":\"expenses\",\"19\":\"contracts\",\"20\":\"reports\"}', 'Start 30 days free trial', NULL, '2021-11-10 18:11:52', '2021-11-10 18:18:55');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payfast_invoices`
--

CREATE TABLE `payfast_invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `package_id` int(10) UNSIGNED DEFAULT NULL,
  `m_payment_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pf_payment_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payfast_plan` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pay_date` date DEFAULT NULL,
  `next_pay_date` date DEFAULT NULL,
  `signature` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `token` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payfast_subscriptions`
--

CREATE TABLE `payfast_subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `payfast_plan` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `payfast_status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'inactive',
  `ends_at` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `project_id` int(10) UNSIGNED DEFAULT NULL,
  `invoice_id` int(10) UNSIGNED DEFAULT NULL,
  `amount` double NOT NULL,
  `gateway` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `currency_id` int(10) UNSIGNED DEFAULT NULL,
  `plan_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('complete','pending') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'complete',
  `paid_on` datetime DEFAULT NULL,
  `remarks` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `offline_method_id` int(10) UNSIGNED DEFAULT NULL,
  `bill` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_gateway_credentials`
--

CREATE TABLE `payment_gateway_credentials` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `paypal_client_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paypal_secret` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paypal_status` enum('active','deactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'deactive',
  `stripe_client_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stripe_secret` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stripe_webhook_secret` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stripe_status` enum('active','deactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'deactive',
  `razorpay_key` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `razorpay_secret` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `razorpay_webhook_secret` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `razorpay_status` enum('active','deactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'deactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `paypal_mode` enum('sandbox','live') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'sandbox',
  `paystack_client_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paystack_secret` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paystack_status` enum('active','inactive') COLLATE utf8_unicode_ci DEFAULT 'inactive',
  `paystack_merchant_email` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paystack_payment_url` varchar(191) COLLATE utf8_unicode_ci DEFAULT 'https://api.paystack.co',
  `mollie_api_key` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `mollie_status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'inactive',
  `authorize_api_login_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `authorize_transaction_key` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `authorize_environment` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `authorize_status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'inactive',
  `payfast_key` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payfast_secret` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payfast_status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'inactive',
  `payfast_salt_passphrase` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payfast_mode` enum('sandbox','live') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'sandbox'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payment_gateway_credentials`
--

INSERT INTO `payment_gateway_credentials` (`id`, `company_id`, `paypal_client_id`, `paypal_secret`, `paypal_status`, `stripe_client_id`, `stripe_secret`, `stripe_webhook_secret`, `stripe_status`, `razorpay_key`, `razorpay_secret`, `razorpay_webhook_secret`, `razorpay_status`, `created_at`, `updated_at`, `paypal_mode`, `paystack_client_id`, `paystack_secret`, `paystack_status`, `paystack_merchant_email`, `paystack_payment_url`, `mollie_api_key`, `mollie_status`, `authorize_api_login_id`, `authorize_transaction_key`, `authorize_environment`, `authorize_status`, `payfast_key`, `payfast_secret`, `payfast_status`, `payfast_salt_passphrase`, `payfast_mode`) VALUES
(1, NULL, NULL, NULL, 'active', NULL, NULL, NULL, 'active', NULL, NULL, NULL, 'deactive', '2021-11-10 18:02:02', '2021-11-10 18:02:02', 'sandbox', NULL, NULL, 'inactive', NULL, 'https://api.paystack.co', '', 'inactive', NULL, NULL, NULL, 'inactive', NULL, NULL, 'inactive', NULL, 'sandbox'),
(2, 1, NULL, NULL, 'deactive', NULL, NULL, NULL, 'deactive', NULL, NULL, NULL, 'deactive', '2021-11-10 18:30:29', '2021-11-10 18:30:29', 'sandbox', NULL, NULL, 'inactive', NULL, 'https://api.paystack.co', '', 'inactive', NULL, NULL, NULL, 'inactive', NULL, NULL, 'inactive', NULL, 'sandbox'),
(3, 2, NULL, NULL, 'deactive', NULL, NULL, NULL, 'deactive', NULL, NULL, NULL, 'deactive', '2021-11-10 18:31:14', '2021-11-10 18:31:14', 'sandbox', NULL, NULL, 'inactive', NULL, 'https://api.paystack.co', '', 'inactive', NULL, NULL, NULL, 'inactive', NULL, NULL, 'inactive', NULL, 'sandbox'),
(4, 3, NULL, NULL, 'deactive', NULL, NULL, NULL, 'deactive', NULL, NULL, NULL, 'deactive', '2021-11-10 18:32:04', '2021-11-10 18:32:04', 'sandbox', NULL, NULL, 'inactive', NULL, 'https://api.paystack.co', '', 'inactive', NULL, NULL, NULL, 'inactive', NULL, NULL, 'inactive', NULL, 'sandbox'),
(5, 4, NULL, NULL, 'deactive', NULL, NULL, NULL, 'deactive', NULL, NULL, NULL, 'deactive', '2021-11-10 18:32:41', '2021-11-10 18:32:41', 'sandbox', NULL, NULL, 'inactive', NULL, 'https://api.paystack.co', '', 'inactive', NULL, NULL, NULL, 'inactive', NULL, NULL, 'inactive', NULL, 'sandbox'),
(6, 5, NULL, NULL, 'deactive', NULL, NULL, NULL, 'deactive', NULL, NULL, NULL, 'deactive', '2021-11-10 18:33:21', '2021-11-10 18:33:21', 'sandbox', NULL, NULL, 'inactive', NULL, 'https://api.paystack.co', '', 'inactive', NULL, NULL, NULL, 'inactive', NULL, NULL, 'inactive', NULL, 'sandbox'),
(7, 6, NULL, NULL, 'deactive', NULL, NULL, NULL, 'deactive', NULL, NULL, NULL, 'deactive', '2021-11-10 18:34:01', '2021-11-10 18:34:01', 'sandbox', NULL, NULL, 'inactive', NULL, 'https://api.paystack.co', '', 'inactive', NULL, NULL, NULL, 'inactive', NULL, NULL, 'inactive', NULL, 'sandbox');

-- --------------------------------------------------------

--
-- Table structure for table `paypal_invoices`
--

CREATE TABLE `paypal_invoices` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `currency_id` int(10) UNSIGNED DEFAULT NULL,
  `package_id` int(10) UNSIGNED DEFAULT NULL,
  `sub_total` double DEFAULT NULL,
  `total` double DEFAULT NULL,
  `transaction_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remarks` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_frequency` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_interval` int(11) DEFAULT NULL,
  `paid_on` datetime DEFAULT NULL,
  `next_pay_date` datetime DEFAULT NULL,
  `recurring` enum('yes','no') COLLATE utf8_unicode_ci DEFAULT 'no',
  `status` enum('paid','unpaid','pending') COLLATE utf8_unicode_ci DEFAULT 'pending',
  `plan_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `end_on` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paystack_invoices`
--

CREATE TABLE `paystack_invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `package_id` int(10) UNSIGNED NOT NULL,
  `transaction_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pay_date` date DEFAULT NULL,
  `next_pay_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paystack_subscriptions`
--

CREATE TABLE `paystack_subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `subscription_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `token` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `plan_id` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `module_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `module_id`, `created_at`, `updated_at`) VALUES
(1, 'add_members', 'Add Members', NULL, 13, NULL, NULL),
(2, 'view_members', 'View Members', NULL, 13, NULL, NULL),
(3, 'edit_members', 'Edit Members', NULL, 13, NULL, NULL),
(4, 'delete_members', 'Delete Members', NULL, 13, NULL, NULL),
(5, 'add_clients', 'Add Clients', NULL, 1, NULL, NULL),
(6, 'view_clients', 'View Clients', NULL, 1, NULL, NULL),
(7, 'edit_clients', 'Edit Clients', NULL, 1, NULL, NULL),
(8, 'delete_clients', 'Delete Clients', NULL, 1, NULL, NULL),
(9, 'add_employees', 'Add Employees', NULL, 2, NULL, NULL),
(10, 'view_employees', 'View Employees', NULL, 2, NULL, NULL),
(11, 'edit_employees', 'Edit Employees', NULL, 2, NULL, NULL),
(12, 'delete_employees', 'Delete Employees', NULL, 2, NULL, NULL),
(13, 'add_projects', 'Add Project', NULL, 3, NULL, NULL),
(14, 'view_projects', 'View Project', NULL, 3, NULL, NULL),
(15, 'edit_projects', 'Edit Project', NULL, 3, NULL, NULL),
(16, 'delete_projects', 'Delete Project', NULL, 3, NULL, NULL),
(17, 'add_attendance', 'Add Attendance', NULL, 4, NULL, NULL),
(18, 'view_attendance', 'View Attendance', NULL, 4, NULL, NULL),
(19, 'add_tasks', 'Add Tasks', NULL, 5, NULL, NULL),
(20, 'view_tasks', 'View Tasks', NULL, 5, NULL, NULL),
(21, 'edit_tasks', 'Edit Tasks', NULL, 5, NULL, NULL),
(22, 'delete_tasks', 'Delete Tasks', NULL, 5, NULL, NULL),
(23, 'add_estimates', 'Add Estimates', NULL, 6, NULL, NULL),
(24, 'view_estimates', 'View Estimates', NULL, 6, NULL, NULL),
(25, 'edit_estimates', 'Edit Estimates', NULL, 6, NULL, NULL),
(26, 'delete_estimates', 'Delete Estimates', NULL, 6, NULL, NULL),
(27, 'add_invoices', 'Add Invoices', NULL, 7, NULL, NULL),
(28, 'view_invoices', 'View Invoices', NULL, 7, NULL, NULL),
(29, 'edit_invoices', 'Edit Invoices', NULL, 7, NULL, NULL),
(30, 'delete_invoices', 'Delete Invoices', NULL, 7, NULL, NULL),
(31, 'add_payments', 'Add Payments', NULL, 8, NULL, NULL),
(32, 'view_payments', 'View Payments', NULL, 8, NULL, NULL),
(33, 'edit_payments', 'Edit Payments', NULL, 8, NULL, NULL),
(34, 'delete_payments', 'Delete Payments', NULL, 8, NULL, NULL),
(35, 'add_timelogs', 'Add Timelogs', NULL, 9, NULL, NULL),
(36, 'view_timelogs', 'View Timelogs', NULL, 9, NULL, NULL),
(37, 'edit_timelogs', 'Edit Timelogs', NULL, 9, NULL, NULL),
(38, 'delete_timelogs', 'Delete Timelogs', NULL, 9, NULL, NULL),
(39, 'add_tickets', 'Add Tickets', NULL, 10, NULL, NULL),
(40, 'view_tickets', 'View Tickets', NULL, 10, NULL, NULL),
(41, 'edit_tickets', 'Edit Tickets', NULL, 10, NULL, NULL),
(42, 'delete_tickets', 'Delete Tickets', NULL, 10, NULL, NULL),
(43, 'add_events', 'Add Events', NULL, 11, NULL, NULL),
(44, 'view_events', 'View Events', NULL, 11, NULL, NULL),
(45, 'edit_events', 'Edit Events', NULL, 11, NULL, NULL),
(46, 'delete_events', 'Delete Events', NULL, 11, NULL, NULL),
(47, 'add_notice', 'Add Notice', NULL, 14, NULL, '2021-11-10 18:11:37'),
(48, 'view_notice', 'View Notice', NULL, 14, NULL, '2021-11-10 18:11:37'),
(49, 'edit_notice', 'Edit Notice', NULL, 14, NULL, '2021-11-10 18:11:38'),
(50, 'delete_notice', 'Delete Notice', NULL, 14, NULL, '2021-11-10 18:11:38'),
(51, 'add_leave', 'Add Leave', NULL, 15, NULL, NULL),
(52, 'view_leave', 'View Leave', NULL, 15, NULL, NULL),
(53, 'edit_leave', 'Edit Leave', NULL, 15, NULL, NULL),
(54, 'delete_leave', 'Delete Leave', NULL, 15, NULL, NULL),
(55, 'add_lead', 'Add Lead', NULL, 16, NULL, NULL),
(56, 'view_lead', 'View Lead', NULL, 16, NULL, NULL),
(57, 'edit_lead', 'Edit Lead', NULL, 16, NULL, NULL),
(58, 'delete_lead', 'Delete Lead', NULL, 16, NULL, NULL),
(59, 'add_holiday', 'Add Holiday', NULL, 17, NULL, NULL),
(60, 'view_holiday', 'View Holiday', NULL, 17, NULL, NULL),
(61, 'edit_holiday', 'Edit Holiday', NULL, 17, NULL, NULL),
(62, 'delete_holiday', 'Delete Holiday', NULL, 17, NULL, NULL),
(63, 'add_product', 'Add Product', NULL, 18, NULL, NULL),
(64, 'view_product', 'View Product', NULL, 18, NULL, NULL),
(65, 'edit_product', 'Edit Product', NULL, 18, NULL, NULL),
(66, 'delete_product', 'Delete Product', NULL, 18, NULL, NULL),
(67, 'add_expenses', 'Add Expenses', NULL, 19, NULL, NULL),
(68, 'view_expenses', 'View Expenses', NULL, 19, NULL, NULL),
(69, 'edit_expenses', 'Edit Expenses', NULL, 19, NULL, NULL),
(70, 'delete_expenses', 'Delete Expenses', NULL, 19, NULL, NULL),
(71, 'add_contract', 'Add Contract', NULL, 20, '2021-11-10 18:20:16', '2021-11-10 18:20:16'),
(72, 'edit_contract', 'Edit Contract', NULL, 20, '2021-11-10 18:20:16', '2021-11-10 18:20:16'),
(73, 'view_contract', 'View Contract', NULL, 20, '2021-11-10 18:20:16', '2021-11-10 18:20:16'),
(74, 'delete_contract', 'Delete Contract', NULL, 20, '2021-11-10 18:20:17', '2021-11-10 18:20:17');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pinned`
--

CREATE TABLE `pinned` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `project_id` int(10) UNSIGNED DEFAULT NULL,
  `task_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `player_groups`
--

CREATE TABLE `player_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `player_groups`
--

INSERT INTO `player_groups` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'A1', '2021-11-10 18:37:16', '2021-11-10 18:37:16'),
(2, 'B1', '2021-11-10 18:37:16', '2021-11-10 18:37:16'),
(3, 'C1', '2021-11-10 18:37:16', '2021-11-10 18:37:16');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `price` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `taxes` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `allow_purchase` tinyint(1) NOT NULL DEFAULT 0,
  `item_in_stock` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `status` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `company_id`, `name`, `price`, `taxes`, `allow_purchase`, `item_in_stock`, `status`, `category_id`, `created_at`, `updated_at`, `description`) VALUES
(1, 1, 'shirt 2', '20', NULL, 0, 21, 2, 8, '2021-11-10 19:39:17', '2021-11-14 16:38:31', NULL),
(2, 1, 'Reda', '', NULL, 0, 2, 1, 8, '2021-11-11 17:13:35', '2021-11-11 17:13:35', NULL),
(3, 1, 'short', '', NULL, 0, 1, 2, 9, '2021-11-12 15:24:02', '2021-11-12 15:24:02', NULL),
(4, 1, 'Bag-1', '', NULL, 0, 1, 2, 10, '2021-11-12 15:32:39', '2021-11-12 15:32:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(7, 'shirts', 'sport wear', NULL, NULL),
(8, 'white shirt', 'men shirts', NULL, NULL),
(9, 'blue shirts', 'men shirts', NULL, NULL),
(10, 'Bags', 'bags', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_inventories`
--

CREATE TABLE `product_inventories` (
  `id` int(10) UNSIGNED NOT NULL,
  `product` int(10) UNSIGNED NOT NULL,
  `inventory` int(10) UNSIGNED NOT NULL,
  `price` int(11) NOT NULL,
  `item_in_stock` int(10) UNSIGNED NOT NULL,
  `consumed` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `old` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `damaged` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product_inventories`
--

INSERT INTO `product_inventories` (`id`, `product`, `inventory`, `price`, `item_in_stock`, `consumed`, `old`, `damaged`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 200, 23, 6, 17, 12, '2021-11-10 19:39:17', '2021-11-14 16:38:31'),
(2, 2, 1, 2021, 1, 0, 0, 0, '2021-11-11 17:13:35', '2021-11-11 17:13:35'),
(3, 2, 2, 2021, 0, 1, 1, 0, '2021-11-11 17:13:35', '2021-11-11 17:13:35'),
(4, 3, 1, 400, 4, 0, 0, 0, '2021-11-12 15:24:02', '2021-11-12 15:24:02'),
(5, 3, 2, 140, 23, 4, 0, 3, '2021-11-12 15:24:02', '2021-11-12 15:24:02'),
(6, 4, 1, 323, 16, 3, 6, 6, '2021-11-12 15:32:39', '2021-11-12 15:32:39'),
(7, 4, 2, 220, 20, 0, 0, 0, '2021-11-12 15:32:39', '2021-11-12 15:32:39');

-- --------------------------------------------------------

--
-- Table structure for table `product_statuses`
--

CREATE TABLE `product_statuses` (
  `id` int(10) UNSIGNED NOT NULL,
  `status` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product_statuses`
--

INSERT INTO `product_statuses` (`id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'old', NULL, NULL),
(2, 'new', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_sub_category`
--

CREATE TABLE `product_sub_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `sub_category` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product_sub_category`
--

INSERT INTO `product_sub_category` (`id`, `category_id`, `sub_category`, `created_at`, `updated_at`) VALUES
(4, 7, 8, NULL, NULL),
(5, 8, NULL, NULL, NULL),
(6, 9, NULL, NULL, NULL),
(7, 7, 9, NULL, NULL),
(8, 10, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `project_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `project_summary` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `project_admin` int(10) UNSIGNED DEFAULT NULL,
  `start_date` date NOT NULL,
  `deadline` date DEFAULT NULL,
  `notes` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `client_id` int(10) UNSIGNED DEFAULT NULL,
  `feedback` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `read_only` enum('enable','disable') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'disable',
  `manual_timelog` enum('enable','disable') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'disable',
  `client_view_task` enum('enable','disable') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'disable',
  `allow_client_notification` enum('enable','disable') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'disable',
  `completion_percent` tinyint(4) NOT NULL,
  `calculate_task_progress` enum('true','false') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'true',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `project_budget` double(20,2) DEFAULT NULL,
  `currency_id` int(10) UNSIGNED DEFAULT NULL,
  `hours_allocated` double(8,2) DEFAULT NULL,
  `status` enum('not started','in progress','on hold','canceled','finished','under review') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'in progress',
  `visible_rating_employee` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_activity`
--

CREATE TABLE `project_activity` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `project_id` int(10) UNSIGNED NOT NULL,
  `activity` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_category`
--

CREATE TABLE `project_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `category_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_files`
--

CREATE TABLE `project_files` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `project_id` int(10) UNSIGNED NOT NULL,
  `filename` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `hashname` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `size` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `google_url` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dropbox_link` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `external_link_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `external_link` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_members`
--

CREATE TABLE `project_members` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `project_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `hourly_rate` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_milestones`
--

CREATE TABLE `project_milestones` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `project_id` int(10) UNSIGNED DEFAULT NULL,
  `currency_id` int(10) UNSIGNED DEFAULT NULL,
  `milestone_title` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `summary` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `cost` double(15,2) NOT NULL,
  `status` enum('complete','incomplete') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'incomplete',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `invoice_created` tinyint(1) NOT NULL,
  `invoice_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_notes`
--

CREATE TABLE `project_notes` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `project_id` int(10) UNSIGNED DEFAULT NULL,
  `notes_title` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `notes_type` tinyint(1) NOT NULL DEFAULT 0,
  `client_id` int(10) UNSIGNED DEFAULT NULL,
  `ask_password` tinyint(1) NOT NULL DEFAULT 0,
  `note_details` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_client_show` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_ratings`
--

CREATE TABLE `project_ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `project_id` int(10) UNSIGNED NOT NULL,
  `rating` double NOT NULL DEFAULT 0,
  `comment` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_settings`
--

CREATE TABLE `project_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `send_reminder` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL,
  `remind_time` int(11) NOT NULL,
  `remind_type` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `remind_to` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT '["admins","members"]',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `project_settings`
--

INSERT INTO `project_settings` (`id`, `company_id`, `send_reminder`, `remind_time`, `remind_type`, `remind_to`, `created_at`, `updated_at`) VALUES
(1, 1, 'no', 5, 'days', '[\"admins\",\"members\"]', '2021-11-10 18:30:30', '2021-11-10 18:30:30'),
(2, 2, 'no', 5, 'days', '[\"admins\",\"members\"]', '2021-11-10 18:31:15', '2021-11-10 18:31:15'),
(3, 3, 'no', 5, 'days', '[\"admins\",\"members\"]', '2021-11-10 18:32:04', '2021-11-10 18:32:04'),
(4, 4, 'no', 5, 'days', '[\"admins\",\"members\"]', '2021-11-10 18:32:44', '2021-11-10 18:32:44'),
(5, 5, 'no', 5, 'days', '[\"admins\",\"members\"]', '2021-11-10 18:33:22', '2021-11-10 18:33:22'),
(6, 6, 'no', 5, 'days', '[\"admins\",\"members\"]', '2021-11-10 18:34:02', '2021-11-10 18:34:02');

-- --------------------------------------------------------

--
-- Table structure for table `project_templates`
--

CREATE TABLE `project_templates` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `project_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `client_id` int(10) UNSIGNED DEFAULT NULL,
  `project_summary` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `notes` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `feedback` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `client_view_task` enum('enable','disable') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'disable',
  `allow_client_notification` enum('enable','disable') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'disable',
  `manual_timelog` enum('enable','disable') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'disable',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_template_members`
--

CREATE TABLE `project_template_members` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `project_template_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_template_sub_tasks`
--

CREATE TABLE `project_template_sub_tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_template_task_id` int(10) UNSIGNED NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `start_date` datetime DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `status` enum('incomplete','complete') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'incomplete',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_template_tasks`
--

CREATE TABLE `project_template_tasks` (
  `id` int(10) UNSIGNED NOT NULL,
  `heading` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `project_template_id` int(10) UNSIGNED NOT NULL,
  `priority` enum('low','medium','high') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'medium',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `project_template_task_category_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_template_task_users`
--

CREATE TABLE `project_template_task_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_template_task_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_time_logs`
--

CREATE TABLE `project_time_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `project_id` int(10) UNSIGNED DEFAULT NULL,
  `task_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime DEFAULT NULL,
  `memo` text COLLATE utf8_unicode_ci NOT NULL,
  `total_hours` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total_minutes` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `edited_by_user` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `hourly_rate` int(11) NOT NULL,
  `earnings` int(11) NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT 1,
  `approved_by` int(10) UNSIGNED DEFAULT NULL,
  `invoice_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_user_notes`
--

CREATE TABLE `project_user_notes` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `project_notes_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `proposals`
--

CREATE TABLE `proposals` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `lead_id` int(10) UNSIGNED NOT NULL,
  `valid_till` date NOT NULL,
  `sub_total` double(16,2) NOT NULL,
  `total` double(16,2) NOT NULL,
  `currency_id` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('declined','accepted','waiting','draft') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'waiting',
  `note` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `discount` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `invoice_convert` tinyint(1) NOT NULL DEFAULT 0,
  `discount_type` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `client_comment` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `signature_approval` tinyint(1) NOT NULL DEFAULT 1,
  `send_status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `proposal_items`
--

CREATE TABLE `proposal_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `tax_id` int(10) UNSIGNED DEFAULT NULL,
  `proposal_id` int(10) UNSIGNED NOT NULL,
  `item_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('item','discount','tax') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'item',
  `quantity` double(16,2) NOT NULL,
  `unit_price` double(16,2) NOT NULL,
  `amount` double(16,2) NOT NULL,
  `item_summary` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `taxes` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `hsn_sac_code` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `proposal_signs`
--

CREATE TABLE `proposal_signs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `proposal_id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `signature` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purpose_consent`
--

CREATE TABLE `purpose_consent` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purpose_consent_leads`
--

CREATE TABLE `purpose_consent_leads` (
  `id` int(10) UNSIGNED NOT NULL,
  `lead_id` int(10) UNSIGNED NOT NULL,
  `purpose_consent_id` int(10) UNSIGNED NOT NULL,
  `status` enum('agree','disagree') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'agree',
  `ip` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by_id` int(10) UNSIGNED DEFAULT NULL,
  `additional_description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purpose_consent_users`
--

CREATE TABLE `purpose_consent_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `purpose_consent_id` int(10) UNSIGNED NOT NULL,
  `status` enum('agree','disagree') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'agree',
  `ip` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by_id` int(10) UNSIGNED NOT NULL,
  `additional_description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `push_notification_settings`
--

CREATE TABLE `push_notification_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `onesignal_app_id` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `onesignal_rest_api_key` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `notification_logo` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `push_notification_settings`
--

INSERT INTO `push_notification_settings` (`id`, `onesignal_app_id`, `onesignal_rest_api_key`, `notification_logo`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, 'inactive', '2021-11-10 18:10:48', '2021-11-10 18:10:48');

-- --------------------------------------------------------

--
-- Table structure for table `push_subscriptions`
--

CREATE TABLE `push_subscriptions` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `endpoint` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `public_key` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_token` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quotations`
--

CREATE TABLE `quotations` (
  `id` int(10) UNSIGNED NOT NULL,
  `business_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `client_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `client_email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `sub_total` double(8,2) NOT NULL,
  `total` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quotation_items`
--

CREATE TABLE `quotation_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `quotation_id` int(10) UNSIGNED NOT NULL,
  `item_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` int(11) NOT NULL,
  `amount` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `hsn_sac_code` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `razorpay_invoices`
--

CREATE TABLE `razorpay_invoices` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `invoice_id` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `subscription_id` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `order_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `package_id` int(10) UNSIGNED NOT NULL,
  `transaction_id` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(12,2) UNSIGNED NOT NULL,
  `pay_date` date NOT NULL,
  `next_pay_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `razorpay_subscriptions`
--

CREATE TABLE `razorpay_subscriptions` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `subscription_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `razorpay_id` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `razorpay_plan` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `removal_requests`
--

CREATE TABLE `removal_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `removal_requests_lead`
--

CREATE TABLE `removal_requests_lead` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `lead_id` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `request_types`
--

CREATE TABLE `request_types` (
  `id` int(10) NOT NULL,
  `name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `request_types`
--

INSERT INTO `request_types` (`id`, `name`) VALUES
(1, 'withdraw'),
(2, 'consumed'),
(3, 'retrieved'),
(4, 'old'),
(5, 'damaged'),
(6, 'scraped');

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE `resources` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(150) NOT NULL,
  `item_in_stock` int(10) NOT NULL DEFAULT 1,
  `borrowed` int(10) DEFAULT 0,
  `borrowable` tinyint(4) NOT NULL DEFAULT 1,
  `file` varchar(150) DEFAULT NULL,
  `type` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `resources`
--

INSERT INTO `resources` (`id`, `name`, `description`, `item_in_stock`, `borrowed`, `borrowable`, `file`, `type`, `created_at`, `updated_at`) VALUES
(1, 'book-2', 'book', 9, 4, 0, NULL, 3, '2021-11-17 22:46:15', '2021-11-17 07:42:37'),
(2, 'book  3', 'mc', 10, 2, 1, NULL, 2, '2021-11-17 22:47:45', '2021-11-17 07:50:02');

-- --------------------------------------------------------

--
-- Table structure for table `resource_types`
--

CREATE TABLE `resource_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `resource_types`
--

INSERT INTO `resource_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'video ', '2021-11-16 20:55:35', NULL),
(2, 'audio ', '2021-11-16 20:55:35', NULL),
(3, 'book', '2021-11-16 20:55:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `company_id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'admin', 'App Administrator', 'Admin is allowed to manage everything of the app.', '2021-11-10 18:30:31', '2021-11-10 18:30:31'),
(2, 1, 'employee', 'Employee', 'Employee can see tasks and projects assigned to him.', '2021-11-10 18:30:31', '2021-11-10 18:30:31'),
(3, 1, 'client', 'Client', 'Client can see own tasks and projects.', '2021-11-10 18:30:31', '2021-11-10 18:30:31'),
(4, 2, 'admin', 'App Administrator', 'Admin is allowed to manage everything of the app.', '2021-11-10 18:31:18', '2021-11-10 18:31:18'),
(5, 2, 'employee', 'Employee', 'Employee can see tasks and projects assigned to him.', '2021-11-10 18:31:18', '2021-11-10 18:31:18'),
(6, 2, 'client', 'Client', 'Client can see own tasks and projects.', '2021-11-10 18:31:20', '2021-11-10 18:31:20'),
(7, 3, 'admin', 'App Administrator', 'Admin is allowed to manage everything of the app.', '2021-11-10 18:32:06', '2021-11-10 18:32:06'),
(8, 3, 'employee', 'Employee', 'Employee can see tasks and projects assigned to him.', '2021-11-10 18:32:06', '2021-11-10 18:32:06'),
(9, 3, 'client', 'Client', 'Client can see own tasks and projects.', '2021-11-10 18:32:06', '2021-11-10 18:32:06'),
(10, 4, 'admin', 'App Administrator', 'Admin is allowed to manage everything of the app.', '2021-11-10 18:32:48', '2021-11-10 18:32:48'),
(11, 4, 'employee', 'Employee', 'Employee can see tasks and projects assigned to him.', '2021-11-10 18:32:48', '2021-11-10 18:32:48'),
(12, 4, 'client', 'Client', 'Client can see own tasks and projects.', '2021-11-10 18:32:48', '2021-11-10 18:32:48'),
(13, 5, 'admin', 'App Administrator', 'Admin is allowed to manage everything of the app.', '2021-11-10 18:33:25', '2021-11-10 18:33:25'),
(14, 5, 'employee', 'Employee', 'Employee can see tasks and projects assigned to him.', '2021-11-10 18:33:26', '2021-11-10 18:33:26'),
(15, 5, 'client', 'Client', 'Client can see own tasks and projects.', '2021-11-10 18:33:26', '2021-11-10 18:33:26'),
(16, 6, 'admin', 'App Administrator', 'Admin is allowed to manage everything of the app.', '2021-11-10 18:34:04', '2021-11-10 18:34:04'),
(17, 6, 'employee', 'Employee', 'Employee can see tasks and projects assigned to him.', '2021-11-10 18:34:04', '2021-11-10 18:34:04'),
(18, 6, 'client', 'Client', 'Client can see own tasks and projects.', '2021-11-10 18:34:04', '2021-11-10 18:34:04');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
(2, 1),
(3, 2),
(4, 3),
(5, 1),
(5, 2),
(6, 1),
(6, 2),
(7, 1),
(7, 2),
(8, 1),
(8, 2),
(9, 1),
(9, 2),
(10, 1),
(10, 2),
(11, 1),
(11, 2),
(12, 1),
(12, 2),
(13, 1),
(13, 2),
(14, 1),
(14, 2),
(15, 2),
(16, 2),
(17, 2),
(18, 2),
(19, 2),
(20, 2),
(21, 2),
(22, 2),
(23, 2),
(24, 2),
(25, 3),
(26, 3),
(27, 3),
(28, 3),
(29, 3),
(30, 3),
(31, 3),
(32, 3),
(33, 3),
(34, 3),
(35, 4),
(35, 5),
(36, 4),
(36, 5),
(37, 4),
(37, 5),
(38, 4),
(38, 5),
(39, 4),
(39, 5),
(40, 4),
(40, 5),
(41, 4),
(41, 5),
(42, 4),
(42, 5),
(43, 4),
(43, 5),
(44, 4),
(44, 5),
(45, 5),
(46, 5),
(47, 5),
(48, 5),
(49, 5),
(50, 5),
(51, 5),
(52, 5),
(53, 5),
(54, 5),
(55, 6),
(56, 6),
(57, 6),
(58, 6),
(59, 6),
(60, 6),
(61, 6),
(62, 6),
(63, 6),
(64, 6),
(65, 7),
(65, 8),
(66, 7),
(66, 8),
(67, 7),
(67, 8),
(68, 7),
(68, 8),
(69, 7),
(69, 8),
(70, 7),
(70, 8),
(71, 7),
(71, 8),
(72, 7),
(72, 8),
(73, 7),
(73, 8),
(74, 7),
(74, 8),
(75, 8),
(76, 8),
(77, 8),
(78, 8),
(79, 8),
(80, 8),
(81, 8),
(82, 8),
(83, 8),
(84, 8),
(85, 9),
(86, 9),
(87, 9),
(88, 9),
(89, 9),
(90, 9),
(91, 9),
(92, 9),
(93, 9),
(94, 9),
(95, 10),
(95, 11),
(96, 10),
(96, 11),
(97, 10),
(97, 11),
(98, 10),
(98, 11),
(99, 10),
(99, 11),
(100, 10),
(100, 11),
(101, 10),
(101, 11),
(102, 10),
(102, 11),
(103, 10),
(103, 11),
(104, 10),
(104, 11),
(105, 11),
(106, 11),
(107, 11),
(108, 11),
(109, 11),
(110, 11),
(111, 11),
(112, 11),
(113, 11),
(114, 11),
(115, 12),
(116, 12),
(117, 12),
(118, 12),
(119, 12),
(120, 12),
(121, 12),
(122, 12),
(123, 12),
(124, 12),
(125, 13),
(125, 14),
(126, 13),
(126, 14),
(127, 13),
(127, 14),
(128, 13),
(128, 14),
(129, 13),
(129, 14),
(130, 13),
(130, 14),
(131, 13),
(131, 14),
(132, 13),
(132, 14),
(133, 13),
(133, 14),
(134, 13),
(134, 14),
(135, 14),
(136, 14),
(137, 14),
(138, 14),
(139, 14),
(140, 14),
(141, 14),
(142, 14),
(143, 14),
(144, 14),
(145, 15),
(146, 15),
(147, 15),
(148, 15),
(149, 15),
(150, 15),
(151, 15),
(152, 15),
(153, 15),
(154, 15),
(155, 16),
(155, 17),
(156, 16),
(156, 17),
(157, 16),
(157, 17),
(158, 16),
(158, 17),
(159, 16),
(159, 17),
(160, 16),
(160, 17),
(161, 16),
(161, 17),
(162, 16),
(162, 17),
(163, 16),
(163, 17),
(164, 16),
(164, 17),
(165, 17),
(166, 17),
(167, 17),
(168, 17),
(169, 17),
(170, 17),
(171, 17),
(172, 17),
(173, 17),
(174, 17),
(175, 18),
(176, 18),
(177, 18),
(178, 18),
(179, 18),
(180, 18),
(181, 18),
(182, 18),
(183, 18),
(184, 18);

-- --------------------------------------------------------

--
-- Table structure for table `seo_details`
--

CREATE TABLE `seo_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `language_setting_id` int(10) UNSIGNED DEFAULT NULL,
  `page_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `seo_title` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seo_keywords` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `seo_description` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seo_author` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `og_image` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `seo_details`
--

INSERT INTO `seo_details` (`id`, `language_setting_id`, `page_name`, `seo_title`, `seo_keywords`, `seo_description`, `seo_author`, `og_image`, `created_at`, `updated_at`) VALUES
(1, NULL, 'home', 'Home', 'best crm,hr management software, web hr software, hr software online, free hr software, hr software for sme, hr management software for small business, cloud hr software, online hr management software', 'CODAGETECH saas is easy to use CRM software that is designed for B2B. It include  everything you need to run your businesses. like manage customers, projects, invoices, estimates, timelogs, co', 'CODAGETECH', NULL, '2021-11-10 18:18:54', '2021-11-10 18:18:54'),
(2, NULL, 'feature', 'Feature', 'best crm,hr management software, web hr software, hr software online, free hr software, hr software for sme, hr management software for small business, cloud hr software, online hr management software', 'CODAGETECH saas is easy to use CRM software that is designed for B2B. It include  everything you need to run your businesses. like manage customers, projects, invoices, estimates, timelogs, co', 'CODAGETECH', NULL, '2021-11-10 18:18:54', '2021-11-10 18:18:54'),
(3, NULL, 'pricing', 'Pricing', 'best crm,hr management software, web hr software, hr software online, free hr software, hr software for sme, hr management software for small business, cloud hr software, online hr management software', 'CODAGETECH saas is easy to use CRM software that is designed for B2B. It include  everything you need to run your businesses. like manage customers, projects, invoices, estimates, timelogs, co', 'CODAGETECH', NULL, '2021-11-10 18:18:54', '2021-11-10 18:18:54'),
(4, NULL, 'contact', 'Contact', 'best crm,hr management software, web hr software, hr software online, free hr software, hr software for sme, hr management software for small business, cloud hr software, online hr management software', 'CODAGETECH saas is easy to use CRM software that is designed for B2B. It include  everything you need to run your businesses. like manage customers, projects, invoices, estimates, timelogs, co', 'CODAGETECH', NULL, '2021-11-10 18:18:54', '2021-11-10 18:18:54'),
(5, NULL, 'terms-of-use', 'Terms of use', 'best crm,hr management software, web hr software, hr software online, free hr software, hr software for sme, hr management software for small business, cloud hr software, online hr management software', 'CODAGETECH saas is easy to use CRM software that is designed for B2B. It include everything you need to run your businesses. like manage customers, projects, invoices, estimates, timelogs, con', 'CODAGETECH', NULL, '2021-11-10 18:30:02', '2021-11-10 18:30:02'),
(6, NULL, 'privacy-policy', 'Privacy Policy', 'best crm,hr management software, web hr software, hr software online, free hr software, hr software for sme, hr management software for small business, cloud hr software, online hr management software', 'CODAGETECH saas is easy to use CRM software that is designed for B2B. It include everything you need to run your businesses. like manage customers, projects, invoices, estimates, timelogs, con', 'CODAGETECH', NULL, '2021-11-10 18:30:02', '2021-11-10 18:30:02');

-- --------------------------------------------------------

--
-- Table structure for table `sign_up_settings`
--

CREATE TABLE `sign_up_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `language_setting_id` int(10) UNSIGNED DEFAULT NULL,
  `message` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sign_up_settings`
--

INSERT INTO `sign_up_settings` (`id`, `language_setting_id`, `message`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Registration is currently closed. Please try again later. If you have any inquiries feel free to contact us', '2021-11-10 18:27:45', '2021-11-10 18:27:45');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `slack_settings`
--

CREATE TABLE `slack_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `slack_webhook` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `slack_logo` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `slack_settings`
--

INSERT INTO `slack_settings` (`id`, `company_id`, `slack_webhook`, `slack_logo`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, '2021-11-10 18:02:12', '2021-11-10 18:02:12'),
(2, 1, NULL, NULL, '2021-11-10 18:30:30', '2021-11-10 18:30:30'),
(3, 2, NULL, NULL, '2021-11-10 18:31:14', '2021-11-10 18:31:14'),
(4, 3, NULL, NULL, '2021-11-10 18:32:04', '2021-11-10 18:32:04'),
(5, 4, NULL, NULL, '2021-11-10 18:32:43', '2021-11-10 18:32:43'),
(6, 5, NULL, NULL, '2021-11-10 18:33:22', '2021-11-10 18:33:22'),
(7, 6, NULL, NULL, '2021-11-10 18:34:02', '2021-11-10 18:34:02');

-- --------------------------------------------------------

--
-- Table structure for table `smtp_settings`
--

CREATE TABLE `smtp_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `mail_driver` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'smtp',
  `mail_host` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'smtp.gmail.com',
  `mail_port` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT '587',
  `mail_username` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'youremail@gmail.com',
  `mail_password` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'your password',
  `mail_from_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'your name',
  `mail_from_email` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'from@email.com',
  `mail_encryption` enum('tls','ssl') COLLATE utf8_unicode_ci DEFAULT 'tls',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `smtp_settings`
--

INSERT INTO `smtp_settings` (`id`, `mail_driver`, `mail_host`, `mail_port`, `mail_username`, `mail_password`, `mail_from_name`, `mail_from_email`, `mail_encryption`, `created_at`, `updated_at`, `verified`) VALUES
(1, 'mail', 'smtp.gmail.com', '587', 'myemail@gmail.com', 'mypassword', 'froiden', 'from@email.com', 'tls', '2021-11-10 18:10:12', '2021-11-10 18:10:12', 0);

-- --------------------------------------------------------

--
-- Table structure for table `socials`
--

CREATE TABLE `socials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `social_id` text COLLATE utf8_unicode_ci NOT NULL,
  `social_service` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `social_auth_settings`
--

CREATE TABLE `social_auth_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `facebook_client_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook_secret_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook_status` enum('enable','disable') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'disable',
  `google_client_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `google_secret_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `google_status` enum('enable','disable') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'disable',
  `twitter_client_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter_secret_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter_status` enum('enable','disable') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'disable',
  `linkedin_client_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `linkedin_secret_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `linkedin_status` enum('enable','disable') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'disable',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `social_auth_settings`
--

INSERT INTO `social_auth_settings` (`id`, `facebook_client_id`, `facebook_secret_id`, `facebook_status`, `google_client_id`, `google_secret_id`, `google_status`, `twitter_client_id`, `twitter_secret_id`, `twitter_status`, `linkedin_client_id`, `linkedin_secret_id`, `linkedin_status`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'disable', NULL, NULL, 'disable', NULL, NULL, 'disable', NULL, NULL, 'disable', '2021-11-10 18:19:12', '2021-11-10 18:19:12');

-- --------------------------------------------------------

--
-- Table structure for table `sport_academies`
--

CREATE TABLE `sport_academies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sport_academies`
--

INSERT INTO `sport_academies` (`id`, `name`, `code`, `created_at`, `updated_at`) VALUES
(1, 'football', 'F-1', '2021-11-10 18:37:17', '2021-11-10 18:37:17'),
(2, 'basketball', 'B-1', '2021-11-10 18:37:17', '2021-11-10 18:37:17'),
(3, 'swimming', 'S-1', '2021-11-10 18:37:17', '2021-11-10 18:37:17');

-- --------------------------------------------------------

--
-- Table structure for table `sport_location`
--

CREATE TABLE `sport_location` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `location_id` bigint(20) NOT NULL,
  `sport_id` bigint(20) NOT NULL,
  `level_id` bigint(20) NOT NULL,
  `group_id` bigint(20) NOT NULL,
  `coach_id` bigint(20) NOT NULL,
  `capacity` int(11) NOT NULL,
  `fees` double NOT NULL,
  `currency` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `training_days` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`training_days`)),
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sticky_notes`
--

CREATE TABLE `sticky_notes` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `note_text` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `colour` enum('blue','yellow','red','gray','purple','green') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'blue',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_requests`
--

CREATE TABLE `stock_requests` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `project_id` int(10) UNSIGNED DEFAULT NULL,
  `client_id` int(10) UNSIGNED DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `currency_id` int(10) UNSIGNED DEFAULT NULL,
  `type` int(10) NOT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `approved` int(11) NOT NULL,
  `approved_by` int(10) UNSIGNED DEFAULT NULL,
  `products` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `total` double NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stock_requests`
--

INSERT INTO `stock_requests` (`id`, `company_id`, `project_id`, `client_id`, `issue_date`, `currency_id`, `type`, `created_by`, `approved`, `approved_by`, `products`, `total`, `updated_at`, `created_at`) VALUES
(10, NULL, NULL, NULL, NULL, NULL, 3, 2, 1, 2, '[{\"id\":\"1\",\"quantity\":\"3\"}]', 6063, '2021-11-14 09:26:55', '2021-11-14 09:26:55'),
(11, NULL, NULL, NULL, NULL, NULL, 1, 2, 1, 2, '[{\"id\":\"1\",\"quantity\":\"2\"}]', 4042, '2021-11-14 10:31:57', '2021-11-14 10:31:57'),
(12, NULL, NULL, NULL, NULL, NULL, 2, 2, 1, 2, '[{\"id\":\"1\",\"quantity\":\"3\"}]', 6063, '2021-11-14 10:34:52', '2021-11-14 10:34:52'),
(13, NULL, NULL, NULL, NULL, NULL, 3, 2, 1, 2, '[{\"id\":\"1\",\"quantity\":\"3\"}]', 6063, '2021-11-14 10:37:25', '2021-11-14 10:37:25'),
(14, NULL, NULL, NULL, NULL, NULL, 5, 2, 1, 2, '[{\"id\":\"1\",\"quantity\":\"3\"}]', 6063, '2021-11-14 10:40:27', '2021-11-14 10:40:27'),
(15, NULL, NULL, NULL, NULL, NULL, 5, 2, 1, 2, '[{\"id\":\"1\",\"quantity\":\"3\"}]', 6063, '2021-11-14 10:42:48', '2021-11-14 10:42:48'),
(16, NULL, NULL, NULL, NULL, NULL, 5, 2, 1, 2, '[{\"id\":\"1\",\"quantity\":\"3\"}]', 6063, '2021-11-14 10:43:53', '2021-11-14 10:43:53'),
(17, NULL, NULL, NULL, NULL, NULL, 4, 2, 1, 2, '[{\"id\":\"1\",\"quantity\":\"1\"}]', 2021, '2021-11-14 10:44:14', '2021-11-14 10:44:14'),
(18, NULL, NULL, NULL, NULL, NULL, 4, 2, 1, 2, '[{\"id\":\"1\",\"quantity\":\"4\"}]', 8084, '2021-11-14 10:46:10', '2021-11-14 10:46:10'),
(19, NULL, NULL, NULL, NULL, NULL, 4, 2, 1, 2, '[{\"id\":\"1\",\"quantity\":\"3\"}]', 6063, '2021-11-14 10:52:30', '2021-11-14 10:52:30'),
(20, NULL, NULL, NULL, NULL, NULL, 4, 2, 1, 2, '[{\"id\":\"1\",\"quantity\":\"3\"}]', 6063, '2021-11-14 10:55:26', '2021-11-14 10:55:26'),
(21, NULL, NULL, NULL, NULL, NULL, 5, 2, 1, 2, '[{\"id\":\"1\",\"quantity\":\"3\"}]', 6063, '2021-11-14 10:56:47', '2021-11-14 10:56:47'),
(22, NULL, NULL, NULL, NULL, NULL, 6, 2, 0, 2, '[{\"id\":\"1\",\"quantity\":\"3\"}]', 6063, '2021-11-14 11:02:30', '2021-11-14 11:02:30'),
(23, NULL, NULL, NULL, NULL, NULL, 3, 2, 1, 2, '[{\"id\":\"1\",\"quantity\":\"1\"}]', 200, '2021-11-14 23:57:52', '2021-11-14 23:57:52'),
(24, NULL, NULL, NULL, NULL, NULL, 3, 2, 1, 2, '[{\"id\":\"1\",\"quantity\":\"1\"}]', 200, '2021-11-15 00:01:38', '2021-11-15 00:01:38'),
(25, NULL, NULL, NULL, NULL, NULL, 3, 2, 1, 2, '[{\"id\":\"1\",\"quantity\":\"1\"}]', 200, '2021-11-15 00:04:13', '2021-11-15 00:04:13'),
(26, NULL, NULL, NULL, NULL, NULL, 1, 2, 1, 2, '[{\"id\":\"1\",\"quantity\":\"2\"}]', 400, '2021-11-16 04:54:43', '2021-11-16 04:54:43'),
(27, NULL, NULL, NULL, NULL, NULL, 2, 2, 1, 2, '[{\"id\":\"1\",\"quantity\":\"2\"}]', 400, '2021-11-16 04:55:36', '2021-11-16 04:55:36'),
(28, NULL, NULL, NULL, NULL, NULL, 2, 2, 1, 2, '[{\"id\":\"1\",\"quantity\":\"1\"}]', 200, '2021-11-16 04:56:47', '2021-11-16 04:56:47'),
(29, NULL, NULL, NULL, NULL, NULL, 3, 2, 1, 2, '[{\"id\":\"1\",\"quantity\":\"5\"}]', 1000, '2021-11-16 04:57:50', '2021-11-16 04:57:50'),
(30, NULL, NULL, NULL, NULL, NULL, 3, 2, 1, 2, '[{\"id\":\"1\",\"quantity\":\"1\"}]', 200, '2021-11-16 04:59:46', '2021-11-16 04:59:46'),
(31, NULL, NULL, NULL, NULL, NULL, 1, 2, 1, 2, '[{\"id\":\"1\",\"quantity\":\"2\"}]', 400, '2021-11-16 05:00:30', '2021-11-16 05:00:30'),
(32, NULL, NULL, NULL, NULL, NULL, 1, 2, 1, 2, '[{\"id\":\"1\",\"quantity\":\"2\"}]', 400, '2021-11-16 05:07:19', '2021-11-16 05:07:19'),
(33, NULL, NULL, NULL, NULL, NULL, 3, 2, 1, 2, '[{\"id\":\"1\",\"quantity\":\"7\"}]', 1400, '2021-11-16 05:08:12', '2021-11-16 05:08:12'),
(34, NULL, NULL, NULL, NULL, NULL, 1, 2, 1, 2, '[{\"id\":\"1\",\"quantity\":\"5\"}]', 1000, '2021-11-16 05:46:34', '2021-11-16 05:46:34'),
(35, NULL, NULL, NULL, NULL, NULL, 3, 2, 1, 2, '[{\"id\":\"1\",\"quantity\":\"1\"}]', 200, '2021-11-16 05:47:44', '2021-11-16 05:47:44'),
(36, NULL, NULL, NULL, NULL, NULL, 3, 2, 1, 2, '[{\"id\":\"1\",\"quantity\":\"3\"}]', 600, '2021-11-16 05:50:46', '2021-11-16 05:50:46'),
(37, NULL, NULL, NULL, NULL, NULL, 1, 2, 1, 2, '[{\"id\":\"6\",\"quantity\":\"4\"}]', 1292, '2021-11-16 07:00:10', '2021-11-16 07:00:10'),
(38, NULL, NULL, NULL, NULL, NULL, 4, 2, 1, 2, '[{\"id\":\"1\",\"quantity\":\"3\"},{\"id\":\"3\",\"quantity\":\"1\"}]', 2621, '2021-11-16 08:43:20', '2021-11-16 08:43:20');

-- --------------------------------------------------------

--
-- Table structure for table `stock_transactions`
--

CREATE TABLE `stock_transactions` (
  `id` int(10) NOT NULL,
  `product` int(10) UNSIGNED NOT NULL,
  `prev` int(10) NOT NULL DEFAULT 1,
  `current` int(10) NOT NULL DEFAULT 1,
  `state` int(11) NOT NULL DEFAULT 0,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stock_transactions`
--

INSERT INTO `stock_transactions` (`id`, `product`, `prev`, `current`, `state`, `date`, `created_at`, `updated_at`) VALUES
(13, 1, 0, 20, 1, '2021-11-15', '2021-11-16 04:54:43', '2021-11-16 04:57:50'),
(14, 1, 20, 23, 1, '2021-11-16', '2021-11-16 04:59:46', '2021-11-16 05:50:46'),
(15, 6, 20, 16, -1, '2021-11-16', '2021-11-16 07:00:10', '2021-11-16 07:00:10');

-- --------------------------------------------------------

--
-- Table structure for table `storage_settings`
--

CREATE TABLE `storage_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `filesystem` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'local',
  `auth_keys` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('enabled','disabled') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'disabled',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `storage_settings`
--

INSERT INTO `storage_settings` (`id`, `filesystem`, `auth_keys`, `status`, `created_at`, `updated_at`) VALUES
(1, 'local', NULL, 'enabled', '2021-11-10 18:16:36', '2021-11-10 18:16:36');

-- --------------------------------------------------------

--
-- Table structure for table `stripe_invoices`
--

CREATE TABLE `stripe_invoices` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `invoice_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `package_id` int(10) UNSIGNED NOT NULL,
  `transaction_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `amount` decimal(12,2) UNSIGNED NOT NULL,
  `pay_date` date NOT NULL,
  `next_pay_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stripe_setting`
--

CREATE TABLE `stripe_setting` (
  `id` int(10) UNSIGNED NOT NULL,
  `api_key` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `api_secret` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `webhook_key` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paypal_client_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paypal_secret` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paypal_status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'inactive',
  `stripe_status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'inactive',
  `razorpay_key` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `razorpay_secret` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `razorpay_webhook_secret` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `razorpay_status` enum('active','deactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'deactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `paypal_mode` enum('sandbox','live') COLLATE utf8_unicode_ci NOT NULL,
  `paystack_client_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paystack_secret` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paystack_status` enum('active','inactive') COLLATE utf8_unicode_ci DEFAULT 'inactive',
  `paystack_merchant_email` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paystack_payment_url` varchar(191) COLLATE utf8_unicode_ci DEFAULT 'https://api.paystack.co',
  `mollie_api_key` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `mollie_status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'inactive',
  `authorize_api_login_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `authorize_transaction_key` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `authorize_signature_key` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `authorize_environment` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `authorize_status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'inactive',
  `payfast_key` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payfast_secret` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payfast_status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'inactive',
  `payfast_salt_passphrase` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payfast_mode` enum('sandbox','live') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'sandbox'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `stripe_setting`
--

INSERT INTO `stripe_setting` (`id`, `api_key`, `api_secret`, `webhook_key`, `paypal_client_id`, `paypal_secret`, `paypal_status`, `stripe_status`, `razorpay_key`, `razorpay_secret`, `razorpay_webhook_secret`, `razorpay_status`, `created_at`, `updated_at`, `paypal_mode`, `paystack_client_id`, `paystack_secret`, `paystack_status`, `paystack_merchant_email`, `paystack_payment_url`, `mollie_api_key`, `mollie_status`, `authorize_api_login_id`, `authorize_transaction_key`, `authorize_signature_key`, `authorize_environment`, `authorize_status`, `payfast_key`, `payfast_secret`, `payfast_status`, `payfast_salt_passphrase`, `payfast_mode`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, 'inactive', 'inactive', NULL, NULL, NULL, 'deactive', '2021-11-10 18:11:40', '2021-11-10 18:11:40', 'sandbox', NULL, NULL, 'inactive', NULL, 'https://api.paystack.co', '', 'inactive', NULL, NULL, NULL, NULL, 'inactive', NULL, NULL, 'inactive', NULL, 'sandbox');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `stripe_id` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `stripe_plan` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stripe_status` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscription_items`
--

CREATE TABLE `subscription_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subscription_id` bigint(20) UNSIGNED NOT NULL,
  `stripe_id` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `stripe_plan` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_tasks`
--

CREATE TABLE `sub_tasks` (
  `id` int(10) UNSIGNED NOT NULL,
  `task_id` int(10) UNSIGNED NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `due_date` datetime DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `status` enum('incomplete','complete') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'incomplete',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_task_files`
--

CREATE TABLE `sub_task_files` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `sub_task_id` int(10) UNSIGNED NOT NULL,
  `filename` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `google_url` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hashname` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `size` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dropbox_link` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `external_link` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `external_link_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `subject` text COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('open','pending','resolved','closed') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'open',
  `priority` enum('low','medium','high','urgent') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'medium',
  `agent_id` int(10) UNSIGNED DEFAULT NULL,
  `support_ticket_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_ticket_files`
--

CREATE TABLE `support_ticket_files` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `support_ticket_reply_id` bigint(20) UNSIGNED NOT NULL,
  `filename` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `google_url` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hashname` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `size` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dropbox_link` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `external_link` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `external_link_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_ticket_replies`
--

CREATE TABLE `support_ticket_replies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `support_ticket_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `message` longtext COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_ticket_types`
--

CREATE TABLE `support_ticket_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `support_ticket_types`
--

INSERT INTO `support_ticket_types` (`id`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Question', '2021-11-10 18:23:53', '2021-11-10 18:23:53'),
(2, 'Problem', '2021-11-10 18:23:53', '2021-11-10 18:23:53'),
(3, 'Incident', '2021-11-10 18:23:53', '2021-11-10 18:23:53'),
(4, 'Feature Request', '2021-11-10 18:23:53', '2021-11-10 18:23:53');

-- --------------------------------------------------------

--
-- Table structure for table `taskboard_columns`
--

CREATE TABLE `taskboard_columns` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `column_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label_color` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `priority` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `taskboard_columns`
--

INSERT INTO `taskboard_columns` (`id`, `company_id`, `column_name`, `slug`, `label_color`, `priority`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Incomplete', 'incomplete', '#d21010', 1, '2021-11-10 18:03:13', '2021-11-10 18:11:29'),
(2, NULL, 'Completed', 'completed', '#679c0d', 2, '2021-11-10 18:04:33', '2021-11-10 18:11:29'),
(3, 1, 'Incomplete', 'incomplete', '#d21010', 1, '2021-11-10 18:30:19', '2021-11-10 18:30:19'),
(4, 1, 'Completed', 'completed', '#679c0d', 2, '2021-11-10 18:30:19', '2021-11-10 18:30:19'),
(5, 2, 'Incomplete', 'incomplete', '#d21010', 1, '2021-11-10 18:31:05', '2021-11-10 18:31:05'),
(6, 2, 'Completed', 'completed', '#679c0d', 2, '2021-11-10 18:31:05', '2021-11-10 18:31:05'),
(7, 3, 'Incomplete', 'incomplete', '#d21010', 1, '2021-11-10 18:31:55', '2021-11-10 18:31:55'),
(8, 3, 'Completed', 'completed', '#679c0d', 2, '2021-11-10 18:31:55', '2021-11-10 18:31:55'),
(9, 4, 'Incomplete', 'incomplete', '#d21010', 1, '2021-11-10 18:32:28', '2021-11-10 18:32:28'),
(10, 4, 'Completed', 'completed', '#679c0d', 2, '2021-11-10 18:32:29', '2021-11-10 18:32:29'),
(11, 5, 'Incomplete', 'incomplete', '#d21010', 1, '2021-11-10 18:33:12', '2021-11-10 18:33:12'),
(12, 5, 'Completed', 'completed', '#679c0d', 2, '2021-11-10 18:33:12', '2021-11-10 18:33:12'),
(13, 6, 'Incomplete', 'incomplete', '#d21010', 1, '2021-11-10 18:33:54', '2021-11-10 18:33:54'),
(14, 6, 'Completed', 'completed', '#679c0d', 2, '2021-11-10 18:33:54', '2021-11-10 18:33:54');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `heading` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `project_id` int(10) UNSIGNED DEFAULT NULL,
  `task_category_id` int(10) UNSIGNED DEFAULT NULL,
  `priority` enum('low','medium','high') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'medium',
  `status` enum('incomplete','completed') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'incomplete',
  `board_column_id` int(10) UNSIGNED DEFAULT NULL,
  `column_priority` int(11) NOT NULL,
  `completed_on` datetime DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `recurring_task_id` int(10) UNSIGNED DEFAULT NULL,
  `dependent_task_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `milestone_id` int(10) UNSIGNED DEFAULT NULL,
  `is_private` tinyint(1) NOT NULL DEFAULT 1,
  `billable` tinyint(1) NOT NULL DEFAULT 1,
  `estimate_hours` int(11) NOT NULL,
  `estimate_minutes` int(11) NOT NULL,
  `hash` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_category`
--

CREATE TABLE `task_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `category_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_comments`
--

CREATE TABLE `task_comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `comment` longtext COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `task_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_comment_files`
--

CREATE TABLE `task_comment_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `task_id` int(10) UNSIGNED NOT NULL,
  `comment_id` int(10) UNSIGNED DEFAULT NULL,
  `filename` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `google_url` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hashname` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `size` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dropbox_link` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `external_link` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `external_link_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_files`
--

CREATE TABLE `task_files` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `task_id` int(10) UNSIGNED NOT NULL,
  `filename` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `google_url` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hashname` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `size` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dropbox_link` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `external_link` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `external_link_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_history`
--

CREATE TABLE `task_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task_id` int(10) UNSIGNED NOT NULL,
  `sub_task_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `details` text COLLATE utf8_unicode_ci NOT NULL,
  `board_column_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_labels`
--

CREATE TABLE `task_labels` (
  `id` int(10) UNSIGNED NOT NULL,
  `label_id` int(10) UNSIGNED NOT NULL,
  `task_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_label_list`
--

CREATE TABLE `task_label_list` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `label_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_notes`
--

CREATE TABLE `task_notes` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `task_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_users`
--

CREATE TABLE `task_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `tax_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `rate_percent` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `team_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `company_id`, `team_name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Marketing', '2021-11-10 18:34:23', '2021-11-10 18:34:23'),
(2, 1, 'Sales', '2021-11-10 18:34:24', '2021-11-10 18:34:24'),
(3, 1, 'Human Resources', '2021-11-10 18:34:25', '2021-11-10 18:34:25'),
(4, 1, 'Public Relations', '2021-11-10 18:34:25', '2021-11-10 18:34:25'),
(5, 1, 'Research', '2021-11-10 18:34:26', '2021-11-10 18:34:26'),
(6, 1, 'Finance', '2021-11-10 18:34:26', '2021-11-10 18:34:26'),
(7, 2, 'Marketing', '2021-11-10 18:34:59', '2021-11-10 18:34:59'),
(8, 2, 'Sales', '2021-11-10 18:34:59', '2021-11-10 18:34:59'),
(9, 2, 'Human Resources', '2021-11-10 18:34:59', '2021-11-10 18:34:59'),
(10, 2, 'Public Relations', '2021-11-10 18:34:59', '2021-11-10 18:34:59'),
(11, 2, 'Research', '2021-11-10 18:35:00', '2021-11-10 18:35:00'),
(12, 2, 'Finance', '2021-11-10 18:35:00', '2021-11-10 18:35:00'),
(13, 3, 'Marketing', '2021-11-10 18:35:27', '2021-11-10 18:35:27'),
(14, 3, 'Sales', '2021-11-10 18:35:27', '2021-11-10 18:35:27'),
(15, 3, 'Human Resources', '2021-11-10 18:35:27', '2021-11-10 18:35:27'),
(16, 3, 'Public Relations', '2021-11-10 18:35:27', '2021-11-10 18:35:27'),
(17, 3, 'Research', '2021-11-10 18:35:27', '2021-11-10 18:35:27'),
(18, 3, 'Finance', '2021-11-10 18:35:28', '2021-11-10 18:35:28'),
(19, 4, 'Marketing', '2021-11-10 18:35:52', '2021-11-10 18:35:52'),
(20, 4, 'Sales', '2021-11-10 18:35:52', '2021-11-10 18:35:52'),
(21, 4, 'Human Resources', '2021-11-10 18:35:52', '2021-11-10 18:35:52'),
(22, 4, 'Public Relations', '2021-11-10 18:35:52', '2021-11-10 18:35:52'),
(23, 4, 'Research', '2021-11-10 18:35:52', '2021-11-10 18:35:52'),
(24, 4, 'Finance', '2021-11-10 18:35:53', '2021-11-10 18:35:53'),
(25, 5, 'Marketing', '2021-11-10 18:36:23', '2021-11-10 18:36:23'),
(26, 5, 'Sales', '2021-11-10 18:36:23', '2021-11-10 18:36:23'),
(27, 5, 'Human Resources', '2021-11-10 18:36:23', '2021-11-10 18:36:23'),
(28, 5, 'Public Relations', '2021-11-10 18:36:24', '2021-11-10 18:36:24'),
(29, 5, 'Research', '2021-11-10 18:36:24', '2021-11-10 18:36:24'),
(30, 5, 'Finance', '2021-11-10 18:36:25', '2021-11-10 18:36:25'),
(31, 6, 'Marketing', '2021-11-10 18:36:48', '2021-11-10 18:36:48'),
(32, 6, 'Sales', '2021-11-10 18:36:48', '2021-11-10 18:36:48'),
(33, 6, 'Human Resources', '2021-11-10 18:36:48', '2021-11-10 18:36:48'),
(34, 6, 'Public Relations', '2021-11-10 18:36:48', '2021-11-10 18:36:48'),
(35, 6, 'Research', '2021-11-10 18:36:48', '2021-11-10 18:36:48'),
(36, 6, 'Finance', '2021-11-10 18:36:48', '2021-11-10 18:36:48');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(10) UNSIGNED NOT NULL,
  `language_setting_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `comment` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `rating` double(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `language_setting_id`, `name`, `comment`, `rating`, `created_at`, `updated_at`) VALUES
(1, NULL, 'theon salvatore', 'Lorem ipsum dolor sit detudzdae amet, rcquisc adipiscing elit.\r\n                            Aenean amet socada commodo sit.', 5.00, '2021-11-10 18:30:06', '2021-11-10 18:30:06'),
(2, NULL, 'jenna gilbert', 'Lorem ipsum dolor sit detudzdae amet, rcquisc adipiscing elit.\r\n                            Aenean amet socada commodo sit.', 4.00, '2021-11-10 18:30:06', '2021-11-10 18:30:06'),
(3, NULL, 'Redh gilbert', 'Lorem ipsum dolor sit detudzdae amet, rcquisc adipiscing elit.\r\n                            Aenean amet socada commodo sit.', 3.00, '2021-11-10 18:30:06', '2021-11-10 18:30:06'),
(4, NULL, 'angela whatson', 'Lorem ipsum dolor sit detudzdae amet, rcquisc adipiscing elit.\r\n                            Aenean amet socada commodo sit.', 4.00, '2021-11-10 18:30:06', '2021-11-10 18:30:06'),
(5, NULL, 'angela whatson', 'Lorem ipsum dolor sit detudzdae amet, rcquisc adipiscing elit.\r\n                            Aenean amet socada commodo sit.', 2.00, '2021-11-10 18:30:06', '2021-11-10 18:30:06');

-- --------------------------------------------------------

--
-- Table structure for table `theme_settings`
--

CREATE TABLE `theme_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `panel` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `header_color` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `sidebar_color` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `sidebar_text_color` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `link_color` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT '#ffffff',
  `user_css` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `enable_rounded_theme` tinyint(1) NOT NULL DEFAULT 0,
  `login_background` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `theme_settings`
--

INSERT INTO `theme_settings` (`id`, `company_id`, `panel`, `header_color`, `sidebar_color`, `sidebar_text_color`, `link_color`, `user_css`, `created_at`, `updated_at`, `enable_rounded_theme`, `login_background`) VALUES
(1, NULL, 'superadmin', '#ed4040', '#292929', '#cbcbcb', '#ffffff', NULL, '2021-11-10 18:18:55', '2021-11-10 18:18:55', 0, NULL),
(2, 1, 'admin', '#ed4040', '#292929', '#cbcbcb', '#ffffff', NULL, '2021-11-10 18:30:27', '2021-11-10 18:30:27', 0, NULL),
(3, 1, 'project_admin', '#5475ed', '#292929', '#cbcbcb', '#ffffff', NULL, '2021-11-10 18:30:27', '2021-11-10 18:30:27', 0, NULL),
(4, 1, 'employee', '#f7c80c', '#292929', '#cbcbcb', '#ffffff', NULL, '2021-11-10 18:30:27', '2021-11-10 18:30:27', 0, NULL),
(5, 1, 'client', '#00c292', '#292929', '#cbcbcb', '#ffffff', NULL, '2021-11-10 18:30:29', '2021-11-10 18:30:29', 0, NULL),
(6, 2, 'admin', '#ed4040', '#292929', '#cbcbcb', '#ffffff', NULL, '2021-11-10 18:31:13', '2021-11-10 18:31:13', 0, NULL),
(7, 2, 'project_admin', '#5475ed', '#292929', '#cbcbcb', '#ffffff', NULL, '2021-11-10 18:31:13', '2021-11-10 18:31:13', 0, NULL),
(8, 2, 'employee', '#f7c80c', '#292929', '#cbcbcb', '#ffffff', NULL, '2021-11-10 18:31:13', '2021-11-10 18:31:13', 0, NULL),
(9, 2, 'client', '#00c292', '#292929', '#cbcbcb', '#ffffff', NULL, '2021-11-10 18:31:14', '2021-11-10 18:31:14', 0, NULL),
(10, 3, 'admin', '#ed4040', '#292929', '#cbcbcb', '#ffffff', NULL, '2021-11-10 18:32:03', '2021-11-10 18:32:03', 0, NULL),
(11, 3, 'project_admin', '#5475ed', '#292929', '#cbcbcb', '#ffffff', NULL, '2021-11-10 18:32:03', '2021-11-10 18:32:03', 0, NULL),
(12, 3, 'employee', '#f7c80c', '#292929', '#cbcbcb', '#ffffff', NULL, '2021-11-10 18:32:03', '2021-11-10 18:32:03', 0, NULL),
(13, 3, 'client', '#00c292', '#292929', '#cbcbcb', '#ffffff', NULL, '2021-11-10 18:32:04', '2021-11-10 18:32:04', 0, NULL),
(14, 4, 'admin', '#ed4040', '#292929', '#cbcbcb', '#ffffff', NULL, '2021-11-10 18:32:40', '2021-11-10 18:32:40', 0, NULL),
(15, 4, 'project_admin', '#5475ed', '#292929', '#cbcbcb', '#ffffff', NULL, '2021-11-10 18:32:41', '2021-11-10 18:32:41', 0, NULL),
(16, 4, 'employee', '#f7c80c', '#292929', '#cbcbcb', '#ffffff', NULL, '2021-11-10 18:32:41', '2021-11-10 18:32:41', 0, NULL),
(17, 4, 'client', '#00c292', '#292929', '#cbcbcb', '#ffffff', NULL, '2021-11-10 18:32:41', '2021-11-10 18:32:41', 0, NULL),
(18, 5, 'admin', '#ed4040', '#292929', '#cbcbcb', '#ffffff', NULL, '2021-11-10 18:33:21', '2021-11-10 18:33:21', 0, NULL),
(19, 5, 'project_admin', '#5475ed', '#292929', '#cbcbcb', '#ffffff', NULL, '2021-11-10 18:33:21', '2021-11-10 18:33:21', 0, NULL),
(20, 5, 'employee', '#f7c80c', '#292929', '#cbcbcb', '#ffffff', NULL, '2021-11-10 18:33:21', '2021-11-10 18:33:21', 0, NULL),
(21, 5, 'client', '#00c292', '#292929', '#cbcbcb', '#ffffff', NULL, '2021-11-10 18:33:21', '2021-11-10 18:33:21', 0, NULL),
(22, 6, 'admin', '#ed4040', '#292929', '#cbcbcb', '#ffffff', NULL, '2021-11-10 18:34:00', '2021-11-10 18:34:00', 0, NULL),
(23, 6, 'project_admin', '#5475ed', '#292929', '#cbcbcb', '#ffffff', NULL, '2021-11-10 18:34:00', '2021-11-10 18:34:00', 0, NULL),
(24, 6, 'employee', '#f7c80c', '#292929', '#cbcbcb', '#ffffff', NULL, '2021-11-10 18:34:00', '2021-11-10 18:34:00', 0, NULL),
(25, 6, 'client', '#00c292', '#292929', '#cbcbcb', '#ffffff', NULL, '2021-11-10 18:34:01', '2021-11-10 18:34:01', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `subject` text COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('open','pending','resolved','closed') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'open',
  `priority` enum('low','medium','high','urgent') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'medium',
  `agent_id` int(10) UNSIGNED DEFAULT NULL,
  `channel_id` int(10) UNSIGNED DEFAULT NULL,
  `type_id` int(10) UNSIGNED DEFAULT NULL,
  `close_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_agent_groups`
--

CREATE TABLE `ticket_agent_groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `agent_id` int(10) UNSIGNED NOT NULL,
  `group_id` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('enabled','disabled') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'enabled',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_channels`
--

CREATE TABLE `ticket_channels` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `channel_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ticket_channels`
--

INSERT INTO `ticket_channels` (`id`, `company_id`, `channel_name`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Email', '2021-11-10 18:02:27', '2021-11-10 18:02:27'),
(2, NULL, 'Phone', '2021-11-10 18:02:27', '2021-11-10 18:02:27'),
(3, NULL, 'Twitter', '2021-11-10 18:02:27', '2021-11-10 18:02:27'),
(4, NULL, 'Facebook', '2021-11-10 18:02:27', '2021-11-10 18:02:27'),
(5, 1, 'Email', '2021-11-10 18:30:20', '2021-11-10 18:30:20'),
(6, 1, 'Phone', '2021-11-10 18:30:20', '2021-11-10 18:30:20'),
(7, 1, 'Twitter', '2021-11-10 18:30:20', '2021-11-10 18:30:20'),
(8, 1, 'Facebook', '2021-11-10 18:30:20', '2021-11-10 18:30:20'),
(9, 2, 'Email', '2021-11-10 18:31:05', '2021-11-10 18:31:05'),
(10, 2, 'Phone', '2021-11-10 18:31:06', '2021-11-10 18:31:06'),
(11, 2, 'Twitter', '2021-11-10 18:31:06', '2021-11-10 18:31:06'),
(12, 2, 'Facebook', '2021-11-10 18:31:06', '2021-11-10 18:31:06'),
(13, 3, 'Email', '2021-11-10 18:31:55', '2021-11-10 18:31:55'),
(14, 3, 'Phone', '2021-11-10 18:31:56', '2021-11-10 18:31:56'),
(15, 3, 'Twitter', '2021-11-10 18:31:56', '2021-11-10 18:31:56'),
(16, 3, 'Facebook', '2021-11-10 18:31:56', '2021-11-10 18:31:56'),
(17, 4, 'Email', '2021-11-10 18:32:29', '2021-11-10 18:32:29'),
(18, 4, 'Phone', '2021-11-10 18:32:29', '2021-11-10 18:32:29'),
(19, 4, 'Twitter', '2021-11-10 18:32:29', '2021-11-10 18:32:29'),
(20, 4, 'Facebook', '2021-11-10 18:32:29', '2021-11-10 18:32:29'),
(21, 5, 'Email', '2021-11-10 18:33:12', '2021-11-10 18:33:12'),
(22, 5, 'Phone', '2021-11-10 18:33:12', '2021-11-10 18:33:12'),
(23, 5, 'Twitter', '2021-11-10 18:33:13', '2021-11-10 18:33:13'),
(24, 5, 'Facebook', '2021-11-10 18:33:13', '2021-11-10 18:33:13'),
(25, 6, 'Email', '2021-11-10 18:33:54', '2021-11-10 18:33:54'),
(26, 6, 'Phone', '2021-11-10 18:33:55', '2021-11-10 18:33:55'),
(27, 6, 'Twitter', '2021-11-10 18:33:55', '2021-11-10 18:33:55'),
(28, 6, 'Facebook', '2021-11-10 18:33:55', '2021-11-10 18:33:55');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_custom_forms`
--

CREATE TABLE `ticket_custom_forms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `field_display_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `field_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `field_type` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'text',
  `field_order` int(11) NOT NULL,
  `status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `required` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ticket_custom_forms`
--

INSERT INTO `ticket_custom_forms` (`id`, `company_id`, `field_display_name`, `field_name`, `field_type`, `field_order`, `status`, `created_at`, `updated_at`, `required`) VALUES
(1, 1, 'Name', 'name', 'text', 1, 'active', '2021-11-10 18:30:46', '2021-11-10 18:30:46', 1),
(2, 1, 'Email', 'email', 'text', 2, 'active', '2021-11-10 18:30:46', '2021-11-10 18:30:46', 1),
(3, 1, 'Ticket Subject', 'ticket_subject', 'text', 3, 'active', '2021-11-10 18:30:47', '2021-11-10 18:30:47', 1),
(4, 1, 'Ticket Description', 'ticket_description', 'textarea', 4, 'active', '2021-11-10 18:30:47', '2021-11-10 18:30:47', 1),
(5, 1, 'Type', 'type', 'select', 5, 'active', '2021-11-10 18:30:47', '2021-11-10 18:30:47', 0),
(6, 1, 'Priority', 'priority', 'select', 6, 'active', '2021-11-10 18:30:47', '2021-11-10 18:30:47', 0),
(7, 2, 'Name', 'name', 'text', 1, 'active', '2021-11-10 18:31:39', '2021-11-10 18:31:39', 1),
(8, 2, 'Email', 'email', 'text', 2, 'active', '2021-11-10 18:31:40', '2021-11-10 18:31:40', 1),
(9, 2, 'Ticket Subject', 'ticket_subject', 'text', 3, 'active', '2021-11-10 18:31:40', '2021-11-10 18:31:40', 1),
(10, 2, 'Ticket Description', 'ticket_description', 'textarea', 4, 'active', '2021-11-10 18:31:40', '2021-11-10 18:31:40', 1),
(11, 2, 'Type', 'type', 'select', 5, 'active', '2021-11-10 18:31:40', '2021-11-10 18:31:40', 0),
(12, 2, 'Priority', 'priority', 'select', 6, 'active', '2021-11-10 18:31:40', '2021-11-10 18:31:40', 0),
(13, 3, 'Name', 'name', 'text', 1, 'active', '2021-11-10 18:32:17', '2021-11-10 18:32:17', 1),
(14, 3, 'Email', 'email', 'text', 2, 'active', '2021-11-10 18:32:17', '2021-11-10 18:32:17', 1),
(15, 3, 'Ticket Subject', 'ticket_subject', 'text', 3, 'active', '2021-11-10 18:32:18', '2021-11-10 18:32:18', 1),
(16, 3, 'Ticket Description', 'ticket_description', 'textarea', 4, 'active', '2021-11-10 18:32:18', '2021-11-10 18:32:18', 1),
(17, 3, 'Type', 'type', 'select', 5, 'active', '2021-11-10 18:32:18', '2021-11-10 18:32:18', 0),
(18, 3, 'Priority', 'priority', 'select', 6, 'active', '2021-11-10 18:32:18', '2021-11-10 18:32:18', 0),
(19, 4, 'Name', 'name', 'text', 1, 'active', '2021-11-10 18:32:59', '2021-11-10 18:32:59', 1),
(20, 4, 'Email', 'email', 'text', 2, 'active', '2021-11-10 18:32:59', '2021-11-10 18:32:59', 1),
(21, 4, 'Ticket Subject', 'ticket_subject', 'text', 3, 'active', '2021-11-10 18:32:59', '2021-11-10 18:32:59', 1),
(22, 4, 'Ticket Description', 'ticket_description', 'textarea', 4, 'active', '2021-11-10 18:33:00', '2021-11-10 18:33:00', 1),
(23, 4, 'Type', 'type', 'select', 5, 'active', '2021-11-10 18:33:00', '2021-11-10 18:33:00', 0),
(24, 4, 'Priority', 'priority', 'select', 6, 'active', '2021-11-10 18:33:00', '2021-11-10 18:33:00', 0),
(25, 5, 'Name', 'name', 'text', 1, 'active', '2021-11-10 18:33:39', '2021-11-10 18:33:39', 1),
(26, 5, 'Email', 'email', 'text', 2, 'active', '2021-11-10 18:33:39', '2021-11-10 18:33:39', 1),
(27, 5, 'Ticket Subject', 'ticket_subject', 'text', 3, 'active', '2021-11-10 18:33:39', '2021-11-10 18:33:39', 1),
(28, 5, 'Ticket Description', 'ticket_description', 'textarea', 4, 'active', '2021-11-10 18:33:40', '2021-11-10 18:33:40', 1),
(29, 5, 'Type', 'type', 'select', 5, 'active', '2021-11-10 18:33:40', '2021-11-10 18:33:40', 0),
(30, 5, 'Priority', 'priority', 'select', 6, 'active', '2021-11-10 18:33:40', '2021-11-10 18:33:40', 0),
(31, 6, 'Name', 'name', 'text', 1, 'active', '2021-11-10 18:34:21', '2021-11-10 18:34:21', 1),
(32, 6, 'Email', 'email', 'text', 2, 'active', '2021-11-10 18:34:21', '2021-11-10 18:34:21', 1),
(33, 6, 'Ticket Subject', 'ticket_subject', 'text', 3, 'active', '2021-11-10 18:34:21', '2021-11-10 18:34:21', 1),
(34, 6, 'Ticket Description', 'ticket_description', 'textarea', 4, 'active', '2021-11-10 18:34:21', '2021-11-10 18:34:21', 1),
(35, 6, 'Type', 'type', 'select', 5, 'active', '2021-11-10 18:34:21', '2021-11-10 18:34:21', 0),
(36, 6, 'Priority', 'priority', 'select', 6, 'active', '2021-11-10 18:34:21', '2021-11-10 18:34:21', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_files`
--

CREATE TABLE `ticket_files` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `ticket_reply_id` int(10) UNSIGNED NOT NULL,
  `filename` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `google_url` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hashname` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `size` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dropbox_link` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `external_link` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `external_link_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_groups`
--

CREATE TABLE `ticket_groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `group_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ticket_groups`
--

INSERT INTO `ticket_groups` (`id`, `company_id`, `group_name`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Sales', '2021-11-10 18:02:23', '2021-11-10 18:02:23'),
(2, NULL, 'Code', '2021-11-10 18:02:24', '2021-11-10 18:02:24'),
(3, NULL, 'Management', '2021-11-10 18:02:24', '2021-11-10 18:02:24'),
(4, 1, 'Sales', '2021-11-10 18:30:22', '2021-11-10 18:30:22'),
(5, 1, 'Code', '2021-11-10 18:30:22', '2021-11-10 18:30:22'),
(6, 1, 'Management', '2021-11-10 18:30:22', '2021-11-10 18:30:22'),
(7, 2, 'Sales', '2021-11-10 18:31:07', '2021-11-10 18:31:07'),
(8, 2, 'Code', '2021-11-10 18:31:07', '2021-11-10 18:31:07'),
(9, 2, 'Management', '2021-11-10 18:31:07', '2021-11-10 18:31:07'),
(10, 3, 'Sales', '2021-11-10 18:31:57', '2021-11-10 18:31:57'),
(11, 3, 'Code', '2021-11-10 18:31:58', '2021-11-10 18:31:58'),
(12, 3, 'Management', '2021-11-10 18:31:58', '2021-11-10 18:31:58'),
(13, 4, 'Sales', '2021-11-10 18:32:31', '2021-11-10 18:32:31'),
(14, 4, 'Code', '2021-11-10 18:32:32', '2021-11-10 18:32:32'),
(15, 4, 'Management', '2021-11-10 18:32:32', '2021-11-10 18:32:32'),
(16, 5, 'Sales', '2021-11-10 18:33:14', '2021-11-10 18:33:14'),
(17, 5, 'Code', '2021-11-10 18:33:14', '2021-11-10 18:33:14'),
(18, 5, 'Management', '2021-11-10 18:33:14', '2021-11-10 18:33:14'),
(19, 6, 'Sales', '2021-11-10 18:33:56', '2021-11-10 18:33:56'),
(20, 6, 'Code', '2021-11-10 18:33:56', '2021-11-10 18:33:56'),
(21, 6, 'Management', '2021-11-10 18:33:56', '2021-11-10 18:33:56');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_replies`
--

CREATE TABLE `ticket_replies` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `ticket_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `message` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_reply_templates`
--

CREATE TABLE `ticket_reply_templates` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `reply_heading` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `reply_text` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_tags`
--

CREATE TABLE `ticket_tags` (
  `id` int(10) UNSIGNED NOT NULL,
  `tag_id` int(10) UNSIGNED NOT NULL,
  `ticket_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_tag_list`
--

CREATE TABLE `ticket_tag_list` (
  `id` int(10) UNSIGNED NOT NULL,
  `tag_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_types`
--

CREATE TABLE `ticket_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `type` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ticket_types`
--

INSERT INTO `ticket_types` (`id`, `company_id`, `type`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Question', '2021-11-10 18:02:22', '2021-11-10 18:02:22'),
(2, NULL, 'Problem', '2021-11-10 18:02:22', '2021-11-10 18:02:22'),
(3, NULL, 'Incident', '2021-11-10 18:02:22', '2021-11-10 18:02:22'),
(4, NULL, 'Feature Request', '2021-11-10 18:02:23', '2021-11-10 18:02:23'),
(5, 1, 'Question', '2021-11-10 18:30:20', '2021-11-10 18:30:20'),
(6, 1, 'Problem', '2021-11-10 18:30:21', '2021-11-10 18:30:21'),
(7, 1, 'Incident', '2021-11-10 18:30:21', '2021-11-10 18:30:21'),
(8, 1, 'Feature Request', '2021-11-10 18:30:21', '2021-11-10 18:30:21'),
(9, 2, 'Question', '2021-11-10 18:31:06', '2021-11-10 18:31:06'),
(10, 2, 'Problem', '2021-11-10 18:31:06', '2021-11-10 18:31:06'),
(11, 2, 'Incident', '2021-11-10 18:31:07', '2021-11-10 18:31:07'),
(12, 2, 'Feature Request', '2021-11-10 18:31:07', '2021-11-10 18:31:07'),
(13, 3, 'Question', '2021-11-10 18:31:56', '2021-11-10 18:31:56'),
(14, 3, 'Problem', '2021-11-10 18:31:57', '2021-11-10 18:31:57'),
(15, 3, 'Incident', '2021-11-10 18:31:57', '2021-11-10 18:31:57'),
(16, 3, 'Feature Request', '2021-11-10 18:31:57', '2021-11-10 18:31:57'),
(17, 4, 'Question', '2021-11-10 18:32:30', '2021-11-10 18:32:30'),
(18, 4, 'Problem', '2021-11-10 18:32:30', '2021-11-10 18:32:30'),
(19, 4, 'Incident', '2021-11-10 18:32:30', '2021-11-10 18:32:30'),
(20, 4, 'Feature Request', '2021-11-10 18:32:30', '2021-11-10 18:32:30'),
(21, 5, 'Question', '2021-11-10 18:33:13', '2021-11-10 18:33:13'),
(22, 5, 'Problem', '2021-11-10 18:33:13', '2021-11-10 18:33:13'),
(23, 5, 'Incident', '2021-11-10 18:33:14', '2021-11-10 18:33:14'),
(24, 5, 'Feature Request', '2021-11-10 18:33:14', '2021-11-10 18:33:14'),
(25, 6, 'Question', '2021-11-10 18:33:55', '2021-11-10 18:33:55'),
(26, 6, 'Problem', '2021-11-10 18:33:55', '2021-11-10 18:33:55'),
(27, 6, 'Incident', '2021-11-10 18:33:55', '2021-11-10 18:33:55'),
(28, 6, 'Feature Request', '2021-11-10 18:33:56', '2021-11-10 18:33:56');

-- --------------------------------------------------------

--
-- Table structure for table `tr_front_details`
--

CREATE TABLE `tr_front_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `language_setting_id` int(10) UNSIGNED DEFAULT NULL,
  `header_title` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `header_description` text COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `feature_title` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `feature_description` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price_title` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price_description` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `task_management_title` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `task_management_detail` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `manage_bills_title` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `manage_bills_detail` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `teamates_title` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `teamates_detail` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `favourite_apps_title` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `favourite_apps_detail` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `cta_title` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cta_detail` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `client_title` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `client_detail` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `testimonial_title` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `testimonial_detail` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `faq_title` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `faq_detail` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `footer_copyright_text` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tr_front_details`
--

INSERT INTO `tr_front_details` (`id`, `language_setting_id`, `header_title`, `header_description`, `image`, `feature_title`, `feature_description`, `price_title`, `price_description`, `task_management_title`, `task_management_detail`, `manage_bills_title`, `manage_bills_detail`, `teamates_title`, `teamates_detail`, `favourite_apps_title`, `favourite_apps_detail`, `cta_title`, `cta_detail`, `client_title`, `client_detail`, `testimonial_title`, `testimonial_detail`, `faq_title`, `faq_detail`, `footer_copyright_text`, `created_at`, `updated_at`) VALUES
(1, NULL, 'HR, CRM & Project Management System', 'The most powerful and simple way to collaborate with your team.<ul class=\"list1 border-top pt-5 mt-5\">\r\n                            <li class=\"mb-3\">\r\n                                Create invoices & Estimates\r\n                            </li>\r\n                            <li class=\"mb-3\">\r\n                                Tracks time and expenses\r\n                            </li>\r\n                            <li class=\"mb-3\">\r\n                                Add company’s employees, track their attendance and manage leaves\r\n                            </li>\r\n                        </ul>', '', 'Team communications for the 21st century.', NULL, 'Affordable Pricing', 'CODAGETECH for Teams is a single workspace for your small- to medium-sized company or team.', 'Task Management', 'Manage your projects and your talent in a single system, resulting in empowered teams, satisfied clients, and increased profitability.', 'Manages All Your Bills', 'Manage your Automate billing and revenue recognition to streamline the contract-to-cash cycle.', 'Manages All Your Bills', 'Manage your Automate billing and revenue recognition to streamline the contract-to-cash cycle.', 'Integrate With Your Favourite Apps.', 'Our app gives you the added advantage of several other third party apps through seamless integrations.', 'Managing Business Has Never Been So Easy.', 'Don\'t hesitate, Our experts will show you how our application can streamline the way your team works.', 'Trusted by the world\'s best team', 'More Than 700 People Use Our Product.', 'Loved By Businesses, And Individuals Across The Globe', NULL, 'Frequently Asked Questions', NULL, 'Copyright © 2020. All Rights Reserved', '2021-11-10 18:29:59', '2021-11-10 18:29:59');

-- --------------------------------------------------------

--
-- Table structure for table `universal_search`
--

CREATE TABLE `universal_search` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `searchable_id` int(11) NOT NULL,
  `module_type` enum('ticket','invoice','notice','proposal','task','creditNote','client','employee','project','estimate','lead') COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `route_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `universal_search`
--

INSERT INTO `universal_search` (`id`, `company_id`, `searchable_id`, `module_type`, `title`, `route_name`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'invoice', 'Invoice INV#001', 'admin.all-invoices.show', '2021-11-10 20:43:19', '2021-11-10 20:43:19'),
(2, 1, 2, 'invoice', 'Invoice INV#002', 'admin.all-invoices.show', '2021-11-12 00:31:34', '2021-11-12 00:31:34'),
(3, 1, 3, 'invoice', 'Invoice INV#003', 'admin.all-invoices.show', '2021-11-12 10:19:44', '2021-11-12 10:19:44'),
(4, 1, 4, 'invoice', 'Invoice INV#004', 'admin.all-invoices.show', '2021-11-12 10:25:20', '2021-11-12 10:25:20'),
(5, 1, 5, 'invoice', 'Invoice INV#005', 'admin.all-invoices.show', '2021-11-12 10:27:43', '2021-11-12 10:27:43'),
(6, 1, 6, 'invoice', 'Invoice INV#003', 'admin.all-invoices.show', '2021-11-12 13:06:38', '2021-11-12 13:06:38'),
(7, 1, 7, 'invoice', 'Invoice INV#004', 'admin.all-invoices.show', '2021-11-12 15:34:49', '2021-11-12 15:34:49'),
(8, 1, 0, 'invoice', 'Invoice ', 'admin.all-invoices.show', '2021-11-13 09:16:50', '2021-11-13 09:16:50'),
(9, 1, 2, 'invoice', 'Invoice ', 'admin.all-invoices.show', '2021-11-13 14:46:30', '2021-11-13 14:46:30'),
(10, 1, 3, 'invoice', 'Invoice ', 'admin.all-invoices.show', '2021-11-13 14:53:23', '2021-11-13 14:53:23'),
(11, 1, 4, 'invoice', 'Invoice ', 'admin.all-invoices.show', '2021-11-14 06:18:51', '2021-11-14 06:18:51'),
(12, 1, 5, 'invoice', 'Invoice ', 'admin.all-invoices.show', '2021-11-14 07:14:57', '2021-11-14 07:14:57'),
(13, 1, 6, 'invoice', 'Invoice ', 'admin.all-invoices.show', '2021-11-14 07:16:36', '2021-11-14 07:16:36'),
(14, 1, 7, 'invoice', 'Invoice ', 'admin.all-invoices.show', '2021-11-14 07:21:33', '2021-11-14 07:21:33'),
(15, 1, 8, 'invoice', 'Invoice ', 'admin.all-invoices.show', '2021-11-14 07:24:00', '2021-11-14 07:24:00'),
(16, 1, 9, 'invoice', 'Invoice ', 'admin.all-invoices.show', '2021-11-14 08:54:23', '2021-11-14 08:54:23'),
(17, 1, 10, 'invoice', 'Invoice ', 'admin.all-invoices.show', '2021-11-14 09:26:55', '2021-11-14 09:26:55'),
(18, 1, 11, 'invoice', 'Invoice ', 'admin.all-invoices.show', '2021-11-14 10:31:57', '2021-11-14 10:31:57'),
(19, 1, 12, 'invoice', 'Invoice ', 'admin.all-invoices.show', '2021-11-14 10:34:52', '2021-11-14 10:34:52'),
(20, 1, 13, 'invoice', 'Invoice ', 'admin.all-invoices.show', '2021-11-14 10:37:25', '2021-11-14 10:37:25'),
(21, 1, 14, 'invoice', 'Invoice ', 'admin.all-invoices.show', '2021-11-14 10:40:27', '2021-11-14 10:40:27'),
(22, 1, 15, 'invoice', 'Invoice ', 'admin.all-invoices.show', '2021-11-14 10:42:48', '2021-11-14 10:42:48'),
(23, 1, 16, 'invoice', 'Invoice ', 'admin.all-invoices.show', '2021-11-14 10:43:54', '2021-11-14 10:43:54'),
(24, 1, 17, 'invoice', 'Invoice ', 'admin.all-invoices.show', '2021-11-14 10:44:14', '2021-11-14 10:44:14'),
(25, 1, 18, 'invoice', 'Invoice ', 'admin.all-invoices.show', '2021-11-14 10:46:10', '2021-11-14 10:46:10'),
(26, 1, 19, 'invoice', 'Invoice ', 'admin.all-invoices.show', '2021-11-14 10:52:30', '2021-11-14 10:52:30'),
(27, 1, 20, 'invoice', 'Invoice ', 'admin.all-invoices.show', '2021-11-14 10:55:27', '2021-11-14 10:55:27'),
(28, 1, 21, 'invoice', 'Invoice ', 'admin.all-invoices.show', '2021-11-14 10:56:47', '2021-11-14 10:56:47'),
(29, 1, 22, 'invoice', 'Invoice ', 'admin.all-invoices.show', '2021-11-14 11:02:30', '2021-11-14 11:02:30'),
(30, 1, 23, 'invoice', 'Invoice ', 'admin.all-invoices.show', '2021-11-14 23:57:52', '2021-11-14 23:57:52'),
(31, 1, 24, 'invoice', 'Invoice ', 'admin.all-invoices.show', '2021-11-15 00:01:38', '2021-11-15 00:01:38'),
(32, 1, 25, 'invoice', 'Invoice ', 'admin.all-invoices.show', '2021-11-15 00:04:13', '2021-11-15 00:04:13'),
(33, 1, 26, 'invoice', 'Invoice ', 'admin.all-invoices.show', '2021-11-16 04:54:43', '2021-11-16 04:54:43'),
(34, 1, 27, 'invoice', 'Invoice ', 'admin.all-invoices.show', '2021-11-16 04:55:36', '2021-11-16 04:55:36'),
(35, 1, 28, 'invoice', 'Invoice ', 'admin.all-invoices.show', '2021-11-16 04:56:47', '2021-11-16 04:56:47'),
(36, 1, 29, 'invoice', 'Invoice ', 'admin.all-invoices.show', '2021-11-16 04:57:50', '2021-11-16 04:57:50'),
(37, 1, 30, 'invoice', 'Invoice ', 'admin.all-invoices.show', '2021-11-16 04:59:46', '2021-11-16 04:59:46'),
(38, 1, 31, 'invoice', 'Invoice ', 'admin.all-invoices.show', '2021-11-16 05:00:30', '2021-11-16 05:00:30'),
(39, 1, 32, 'invoice', 'Invoice ', 'admin.all-invoices.show', '2021-11-16 05:07:19', '2021-11-16 05:07:19'),
(40, 1, 33, 'invoice', 'Invoice ', 'admin.all-invoices.show', '2021-11-16 05:08:12', '2021-11-16 05:08:12'),
(41, 1, 34, 'invoice', 'Invoice ', 'admin.all-invoices.show', '2021-11-16 05:46:34', '2021-11-16 05:46:34'),
(42, 1, 35, 'invoice', 'Invoice ', 'admin.all-invoices.show', '2021-11-16 05:47:44', '2021-11-16 05:47:44'),
(43, 1, 36, 'invoice', 'Invoice ', 'admin.all-invoices.show', '2021-11-16 05:50:46', '2021-11-16 05:50:46'),
(44, 1, 37, 'invoice', 'Invoice ', 'admin.all-invoices.show', '2021-11-16 07:00:10', '2021-11-16 07:00:10'),
(45, 1, 38, 'invoice', 'Invoice ', 'admin.all-invoices.show', '2021-11-16 08:43:20', '2021-11-16 08:43:20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` enum('male','female','others') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'male',
  `locale` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'en',
  `status` enum('active','deactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `login` enum('enable','disable') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'enable',
  `onesignal_player_id` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `super_admin` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `email_verification_code` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `social_token` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_notifications` tinyint(1) NOT NULL DEFAULT 1,
  `country_id` int(10) UNSIGNED DEFAULT NULL,
  `authorize_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `authorize_payment_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `card_brand` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `card_last_four` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `company_id`, `name`, `email`, `password`, `remember_token`, `image`, `mobile`, `gender`, `locale`, `status`, `login`, `onesignal_player_id`, `created_at`, `updated_at`, `super_admin`, `email_verification_code`, `social_token`, `email_notifications`, `country_id`, `authorize_id`, `authorize_payment_id`, `card_brand`, `card_last_four`, `last_login`) VALUES
(1, NULL, 'Super Admin', 'superadmin@codagetech.com', '$2y$10$4nQqpOq2lNkCK1nCo0jsKOoL9yqIrQDJa.OrIe4oMJTc4al0.hwNa', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:30:12', '2021-11-10 18:30:12', '1', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 1, 'Admin', 'admin@codagetech.com', '$2y$10$UVGp20hBvVxgyct7uk2x6OSwYcJ89LWwJPELGO6cFY19fQ4jNWRny', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:30:53', '2021-11-12 13:50:57', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2021-11-12 15:50:57'),
(3, 1, 'Employee', 'employee@codagetech.com', '$2y$10$UVGp20hBvVxgyct7uk2x6OSwYcJ89LWwJPELGO6cFY19fQ4jNWRny', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:30:55', '2021-11-12 13:54:15', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2021-11-12 15:54:15'),
(4, 1, 'Client', 'client@codagetech.com', '$2y$10$LDjw3z3FLZK5mj9CXcyIau.cvyF4Htw6eidEcBVOAS6.eOymU.W7q', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:30:56', '2021-11-10 18:30:56', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 1, 'Prof. Leonel Reilly PhD', 'ecorwin@example.com', '$2y$10$BZJn2oNw.8lViAUz7HU5N.9TIIYUCEm6JkRmtM0MHO9Xtd7x//92O', NULL, NULL, NULL, 'female', 'en', 'deactive', 'enable', NULL, '2021-11-10 18:34:27', '2021-11-10 18:34:27', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 1, 'Benjamin Zemlak', 'vmcdermott@example.org', '$2y$10$dDMw3YYWmBUCl8ymn3F4luEZShpmHOBoJO50HtLKtEJk9zzVlJlOq', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:34:29', '2021-11-10 18:34:29', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 1, 'Lukas Kunde', 'brendon05@example.org', '$2y$10$NgH0S9uTqDXb4h0Bx.GVGOzD3cprS5VWgbrQ7BcWJoruTYJ.7Eaui', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:34:30', '2021-11-10 18:34:30', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 1, 'Prof. Prudence Legros Sr.', 'leatha.hickle@example.org', '$2y$10$5ZSQQGg.qH78KFGfta6B4.ZFk3vhSwXDJFlJMfs/SElwRKot0ZL72', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:34:32', '2021-11-10 18:34:32', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 1, 'Cathryn McCullough', 'ywiza@example.org', '$2y$10$8yx/gbSheqF4N9.iJp6yp.PU/RT2JYr2CPZpv2VB4oImkMoMHfS/S', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:34:34', '2021-11-10 18:34:34', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 1, 'Mr. Cecil Purdy DVM', 'willms.cleve@example.org', '$2y$10$d2tdEkm5q9oZb1eF8Ccub.yQajEmWhgVV4GW4rEl.e47HKHfzZtca', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:34:35', '2021-11-10 18:34:35', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 1, 'Mitchell Gerlach', 'ifeeney@example.com', '$2y$10$Yjk38NllqksFXM9jZXCQKeyaP89I9pvNXR5HqqNcNOWenGrLj1F1y', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:34:37', '2021-11-10 18:34:37', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 1, 'Lewis Wolff', 'okon.leanne@example.com', '$2y$10$mwZ4wLOJiyP4eL.2s.0F3OucmpdwlzKlIdkAl.mbceX9czZPeHiEW', NULL, NULL, NULL, 'male', 'en', 'deactive', 'enable', NULL, '2021-11-10 18:34:38', '2021-11-10 18:34:38', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 1, 'Karelle Tremblay I', 'alittle@example.com', '$2y$10$xU.fel3MX03yKRswU1kOtunQCpSH2mX3h7bOC.op6OdjnZ6lnoR3u', NULL, NULL, NULL, 'female', 'en', 'deactive', 'enable', NULL, '2021-11-10 18:34:39', '2021-11-10 18:34:39', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 1, 'Brennon Lowe', 'gust88@example.com', '$2y$10$PQ4iibt7z3JWqjWybin8o.XCHE3M/vAzBJA3CqMj540ZtiM7X2RHq', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:34:39', '2021-11-10 18:34:39', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 1, 'Liana Robel', 'vgorczany@example.net', '$2y$10$bjQW2UhfKvbd7WAtM9FoOOxN/zB1RlgYwAyaMDyAmy52ayYiLzbd6', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:34:40', '2021-11-10 18:34:40', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 1, 'Tyrique McGlynn', 'hrice@example.com', '$2y$10$Y7oT0jxyJ4XcH2RGdpoSquAOyHlZYdaWIzp0lwMSZnTaWUUl1CSIm', NULL, NULL, NULL, 'female', 'en', 'deactive', 'enable', NULL, '2021-11-10 18:34:42', '2021-11-10 18:34:42', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 1, 'Adrienne Kuhlman', 'arnulfo.durgan@example.com', '$2y$10$1JrheZ1dO6gd7c38dahD4OqooJuzSY5KJN45V42xWwvZw2UoKFsQO', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:34:42', '2021-11-10 18:34:42', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 1, 'Prof. Abbie Beahan V', 'adams.gage@example.net', '$2y$10$rB5w.IvJtY4Fyi2Yn5TL..v75jyJi6F7vEFyECJRIt4fXpUM8coZ2', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:34:42', '2021-11-10 18:34:42', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 1, 'Carlos Oberbrunner', 'susie.toy@example.net', '$2y$10$RlHi15PA.xfNISlHFRDh9.ubw9guViRxWJDgMk6CShpdZRolXLCoG', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:34:43', '2021-11-10 18:34:43', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 1, 'Lolita Donnelly', 'ferry.hipolito@example.com', '$2y$10$f4D2TrN7XxIBfmpvp3/.O.kQC5VF/H9vaJS2OxbknbJKtJzfr5jDe', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:34:43', '2021-11-10 18:34:43', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 1, 'Amya O\'Kon MD', 'annabelle15@example.org', '$2y$10$UO/xpZyDEVMtE0Y6lIvmKugda8jz0WRPOjwsbnk1FAg6gWoOJIJL6', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:34:44', '2021-11-10 18:34:44', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 1, 'Dr. Gia Raynor', 'brown.mariane@example.org', '$2y$10$7HjcwWJsYKgUaQcUgjanc.HgP1cuHTvscVjCgiFAkgtfP4USN4B1e', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:34:45', '2021-11-10 18:34:45', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 1, 'Gilda Strosin', 'raynor.amira@example.net', '$2y$10$69bvFfLF4VemOXPER8Iho..a2UhJC1tUJU7oclCaFcU8.iMopYl6S', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:34:48', '2021-11-10 18:34:48', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 1, 'Hubert Murazik', 'tanner.emard@example.net', '$2y$10$.wH67DB4raf5anFD0b1QouLAzjsFTrwzLGdfV9EEd/7Sqdz73Nudm', NULL, NULL, NULL, 'male', 'en', 'deactive', 'enable', NULL, '2021-11-10 18:34:50', '2021-11-10 18:34:50', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 1, 'Jabari Skiles', 'okon.ethel@example.org', '$2y$10$cK8GIUZ5yC7Iyo74h3vIv.Ykddw.ph5dZcztJtargx.afB6BVqsVC', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:34:54', '2021-11-10 18:34:54', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 1, 'Javonte Sipes', 'nmraz@example.org', '$2y$10$wLIEjkrBDlLs1G/fL6vCvefY/AfwxhAd9HY8WoRVULSw58xHjjk3e', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:34:55', '2021-11-10 18:34:55', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 1, 'Melissa Larson MD', 'josianne45@example.net', '$2y$10$GmzgCMChVftuSrg1olAIU.fA5kyd1TFUUU4PzS.2B8MUId5GnK1I2', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:34:56', '2021-11-10 18:34:56', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 1, 'Gene Lakin', 'vkunde@example.org', '$2y$10$R8fgRGjcVkdGAbTyfAKjquVHX0g68GFvtXU5yhNWz5gRypEyjonIK', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:34:56', '2021-11-10 18:34:56', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 1, 'Maye Dickens', 'weimann.haven@example.com', '$2y$10$sA6n/EnQtBiRcOyYkclc.eSybWquyXMObJvh3xNxX4hi23hrctxF2', NULL, NULL, NULL, 'male', 'en', 'deactive', 'enable', NULL, '2021-11-10 18:34:56', '2021-11-10 18:34:56', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 1, 'Mr. Toni Kuvalis I', 'parisian.aric@example.org', '$2y$10$00MsrRNIo3qMTYf4/xFu6OVb4emsBn7tU3CfISM.JvZYzMIw0h4NC', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:34:57', '2021-11-10 18:34:57', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 1, 'Coty Wyman', 'kameron.marvin@example.net', '$2y$10$uBIUt61x3dCTCJ0QeCH7YucgJCbw59opLjHQXAEf4nBMfxqJ1CVQy', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:34:57', '2021-11-10 18:34:57', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 1, 'Dr. Bryana Glover II', 'lkulas@example.net', '$2y$10$NkZvRxiJd/5n8Vu1RsJJIeLjU6Duw7NGxDdGLuTDJGiwopznUAASq', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:34:57', '2021-11-10 18:34:57', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(33, 1, 'Alessandra Reilly', 'drolfson@example.net', '$2y$10$3NAhr4tHV0tMP9IZhz1tuec366kcdM3xb4fYspu1dAKcEhyQKVjm6', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:34:57', '2021-11-10 18:34:57', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(34, 1, 'Darrick Powlowski', 'xkutch@example.org', '$2y$10$V0S5XhmH.hftq0TTPVZ47.AvRBU/.B4O7MVQuTiNjxPoLE1WhThz6', NULL, NULL, NULL, 'female', 'en', 'deactive', 'enable', NULL, '2021-11-10 18:34:58', '2021-11-10 18:34:58', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(35, 2, 'Scarlett Kulas', 'hilton17@example.org', '$2y$10$bqtRlvrHhQlwHkjPGgp5JOxvsW.8pTkgh3yBV8U4kclPoCVc2ZqAO', NULL, NULL, NULL, 'female', 'en', 'deactive', 'enable', NULL, '2021-11-10 18:35:01', '2021-11-10 18:35:01', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(36, 2, 'Hoyt Walter', 'francesca.runolfsdottir@example.com', '$2y$10$cnTfb4TgTvO6TkE7GhngWec2uj.zMTFXI4e/Ka6l2RFTkCDRkG.0C', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:02', '2021-11-10 18:35:02', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(37, 2, 'Kassandra Leuschke', 'gislason.marjorie@example.net', '$2y$10$E/DahG2rh/jkVg2F7HtzQui/9RINYDAZ19sf8vOEE9nCpmq3TYpRK', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:02', '2021-11-10 18:35:02', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(38, 2, 'Lavina Mraz', 'upton.adonis@example.org', '$2y$10$fcH2AY05xWTCWjPVFD.kOOdaV43xolwnFnj4roBsru1o9yb/sY.b.', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:03', '2021-11-10 18:35:03', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(39, 2, 'Eli Ullrich', 'gvonrueden@example.com', '$2y$10$4DVNZDGR/iO2D6WXq8VdqeARFBRZ9Fd8qMnQrUsgB2J5LZ5Bw6Hyi', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:03', '2021-11-10 18:35:03', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(40, 2, 'Lillian Funk Sr.', 'river.mosciski@example.org', '$2y$10$3qTDX34H9lJgW8FyxWjGMumuTwuv00oLwK6w4/yjwCMKnMxO3wcUC', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:04', '2021-11-10 18:35:04', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(41, 2, 'Jasper Leuschke', 'elijah45@example.org', '$2y$10$a/oRnJiJ2DsTSgIvm8jInO.ZJ1.fVssC8vqIT14lRBx88qeiUd0QK', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:04', '2021-11-10 18:35:04', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(42, 2, 'Leone Muller', 'pfeffer.evelyn@example.org', '$2y$10$kFMPB/0EULh2LGkjN8T.Z..eGT8dN8qCFyoee2EAFMvdvwZs5feBW', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:05', '2021-11-10 18:35:05', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(43, 2, 'Mariana Spencer Jr.', 'priscilla.cremin@example.net', '$2y$10$.b6H2CzC9.3iLdaILgDWweYBHAv2AE07h88nn4xxp9kRRknckQItG', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:05', '2021-11-10 18:35:05', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(44, 2, 'Brycen Quigley', 'damon.schultz@example.com', '$2y$10$izyl6SB4d7dq8WwHx1tbzuhBgpD4XAmLswk1FatPk1o6.P5cZ4EsS', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:05', '2021-11-10 18:35:05', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(45, 2, 'Monte Streich', 'ressie65@example.org', '$2y$10$hS/FYc4IDrDVnpVVbMaBmOQVJGtf2o8LlGCEtbLZlTtjvxG97Ckr6', NULL, NULL, NULL, 'male', 'en', 'deactive', 'enable', NULL, '2021-11-10 18:35:07', '2021-11-10 18:35:07', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(46, 2, 'Stone Kautzer', 'samara.morissette@example.org', '$2y$10$.M7Gfwyq9Yc5BmExBCebqeMXodRIRkZYqny9GL7ZlXL0bb0b0WdOS', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:09', '2021-11-10 18:35:09', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(47, 2, 'Orlando Monahan', 'jfeeney@example.com', '$2y$10$MNe/Kr.WK/MwUhOPLKdDq.wcJ2U2OUqjIK1z7ssgObgOBEo6y9Vfe', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:09', '2021-11-10 18:35:09', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(48, 2, 'Javonte Macejkovic', 'baumbach.willa@example.com', '$2y$10$gljyXp.Ew3gja0hZSRSVfOhPQHjICDh5jBlobYKHU7HtZkuQYrwea', NULL, NULL, NULL, 'male', 'en', 'deactive', 'enable', NULL, '2021-11-10 18:35:10', '2021-11-10 18:35:10', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(49, 2, 'Zola Hessel', 'cjerde@example.com', '$2y$10$JJo7nuqKrrDFrQm2pbtJeul8i4bp/JdZoxFN5KSFwko.JflCbIKfi', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:10', '2021-11-10 18:35:10', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(50, 2, 'Emelia Abshire PhD', 'hackett.eve@example.org', '$2y$10$x/4/D4ggaERJ.WCEZnYCce3La716DwGQU5wY33u.yDL0g4hYhzOlK', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:11', '2021-11-10 18:35:11', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(51, 2, 'Prof. Jarrod Satterfield', 'jessika.beahan@example.com', '$2y$10$SnEDXcQgzC8vXk9Ejpwz/u1c5U/ERQ4sCbTB0P..LxWWJzc7Qxqyu', NULL, NULL, NULL, 'female', 'en', 'deactive', 'enable', NULL, '2021-11-10 18:35:12', '2021-11-10 18:35:12', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(52, 2, 'Hilbert Heidenreich', 'greenholt.alphonso@example.com', '$2y$10$8R4//Nt8iXw0sa0CjpuGuup9MoFeWVjkXgAlj6X.KvnSfrVBKWlaG', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:14', '2021-11-10 18:35:14', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(53, 2, 'Prof. Rhiannon Goyette', 'hoyt03@example.com', '$2y$10$wD7C7ZZ0ft3qQ8ldAlhaUezFB8UdQynB.pU0S1uvmqCUjA4cryDmy', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:15', '2021-11-10 18:35:15', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(54, 2, 'Terrell Feeney', 'zjakubowski@example.org', '$2y$10$HcGJ1tMfDZ/ubIn203WUNegXE7A/7VPLIycA4f3z2zYX888vsOTLG', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:17', '2021-11-10 18:35:17', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(55, 2, 'Darrel Dibbert', 'istokes@example.org', '$2y$10$MwYAY6SZx4QmIWzRSgMdyOu9zA/zMXjLFavfMn3rOD4LY18MrXLK.', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:18', '2021-11-10 18:35:18', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(56, 2, 'Alfredo Zulauf', 'xwisoky@example.org', '$2y$10$v3oGbu1J6zo90tODZ0nZEOMmQ5PPxA3wxDr0e/y74yb7FX3gXmbjm', NULL, NULL, NULL, 'female', 'en', 'deactive', 'enable', NULL, '2021-11-10 18:35:19', '2021-11-10 18:35:19', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(57, 2, 'Kianna Doyle', 'deja30@example.net', '$2y$10$xh2ZBhRkyih0SwdUsT/G0ulyYIzwlCfb9RnzBbmulb7dQiPE/n9ua', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:19', '2021-11-10 18:35:19', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(58, 2, 'Prof. Rosendo Krajcik', 'bettie78@example.org', '$2y$10$TIFTSzybD6EFlGL4MAowy.lIupKQts7RYLTExTg.1FRCIGv8yrkdu', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:19', '2021-11-10 18:35:19', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(59, 2, 'Mr. Kennith Russel', 'nora91@example.org', '$2y$10$rHHRzTB89oXSzren4Ml1rOX9IkbWlNZ.nhanLG9deWcomS2cOKUIe', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:20', '2021-11-10 18:35:20', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(60, 2, 'Wade Dare', 'nhagenes@example.com', '$2y$10$KvN7oG.T2SgaYO.7bHyWW.b.mP/R/FqV9iSPKJRH6gR7bKOA7k9Ee', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:22', '2021-11-10 18:35:22', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(61, 2, 'Elyssa Cummerata DDS', 'xhaag@example.com', '$2y$10$yOjK0HE77AqMFvWcpHW56uCDeRnCoxaH8a90MYq/CTtEOi9TjtVdO', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:22', '2021-11-10 18:35:22', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(62, 2, 'Daryl Lebsack', 'camila.wilderman@example.net', '$2y$10$WJerMm2ccpRoMP4SdoGxCunrgmVA8F0rBlNG2lf80COuEQRrTnmKi', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:22', '2021-11-10 18:35:22', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(63, 2, 'Prof. Kira Dicki', 'liam75@example.com', '$2y$10$5ru.LfUtKzCXNIWjxbfZcek1zG0K6SSf45TmtzPpAv/.etFDVk9Vu', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:23', '2021-11-10 18:35:23', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(64, 2, 'Prof. Donna Hickle', 'thea.rogahn@example.org', '$2y$10$OiBIj1TcD.3o6mHHcYTrtOip8sF4f6J3tzdxxuAzxaYQfr02mCX3i', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:24', '2021-11-10 18:35:24', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(65, 3, 'Dexter Larkin', 'alison37@example.com', '$2y$10$8tHbcoxt81sOrghRrR/ubuhYQa8pRqYJnNJ7.7y7bZQlUMMDgiMpG', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:29', '2021-11-10 18:35:29', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(66, 3, 'Prof. Gage Kerluke DDS', 'jakubowski.rhianna@example.net', '$2y$10$vtsdoZbrqIGRgu2ms7k2AuVfrtevTUGgPEmOn6trS1ZTAD6o0kJzi', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:29', '2021-11-10 18:35:29', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(67, 3, 'Wilford Hane', 'zstoltenberg@example.com', '$2y$10$mZvFJzQdqA/X7b8av8zaguQgi/c9Fj8rpJAar8fDQypcTl.g/akcy', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:30', '2021-11-10 18:35:30', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(68, 3, 'Prof. Lucinda Pagac', 'wroob@example.com', '$2y$10$OMOo.lujleXbR9UriL6/T.RQ.z2gAgwbB/WNgPQwPmcO5ZxHujV8K', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:31', '2021-11-10 18:35:31', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(69, 3, 'Prof. Easton Hill', 'drau@example.net', '$2y$10$yU5ERT3scKCDdjQlQpnuoeOC4hhWlQu0TlRHh9tc6BS8ZRVfB5SyS', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:31', '2021-11-10 18:35:31', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(70, 3, 'Ansley Kuvalis', 'klangworth@example.com', '$2y$10$eypvR3GVEG5nHBB.4XHbgO5VxJg4r4VsEA.qcKNPGwx5VdvvF/YdO', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:32', '2021-11-10 18:35:32', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(71, 3, 'Giles Nienow', 'agnes.dickens@example.com', '$2y$10$veJDQSZChrR8pgPdsbpqRexnu5NWAszmoLrSOb9ebF2nr39ivZ.8q', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:33', '2021-11-10 18:35:33', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(72, 3, 'Prof. Frank Hansen', 'christiansen.rae@example.net', '$2y$10$g7Zxfc5Qo/kkR7ypwNjfz.678qzTF5E.ugJ.7voTvk12MK2F7jale', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:34', '2021-11-10 18:35:34', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(73, 3, 'Norma Boyer DDS', 'cole.alize@example.net', '$2y$10$tZtWpvrNawPuittCrjIT6.jdaOHErgrclySyJFc6ZYgmz.u4XyQRG', NULL, NULL, NULL, 'male', 'en', 'deactive', 'enable', NULL, '2021-11-10 18:35:35', '2021-11-10 18:35:35', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(74, 3, 'Tatum Graham DDS', 'wehner.cynthia@example.org', '$2y$10$t7Ef0llMPfNUeIaRUfzaxesKGWoArTHFRGhIafbvUdJazGcSaC2wS', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:36', '2021-11-10 18:35:36', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(75, 3, 'King McGlynn', 'alberta96@example.com', '$2y$10$/buHtr7Bv1UMxAb4Vuh0cuYffHYTWfizteLsHs4ePjZ3y6bFCbNk.', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:37', '2021-11-10 18:35:37', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(76, 3, 'Wava Bosco', 'felix.bednar@example.net', '$2y$10$Tmr7Bkirf7zl5rAQ0xgeeuY3L6l/MkFuduYn6//oL3lnW080DIjyq', NULL, NULL, NULL, 'male', 'en', 'deactive', 'enable', NULL, '2021-11-10 18:35:37', '2021-11-10 18:35:37', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(77, 3, 'Myriam Bartoletti', 'rachael.lang@example.org', '$2y$10$.fP2ZGHt00YmeVSh2rt5muZC3NIr/SmGkA86rDwhwsNkdicy6CCoK', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:37', '2021-11-10 18:35:37', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(78, 3, 'Melissa Jerde', 'guillermo.collier@example.com', '$2y$10$m96fosYqj7eNlKLKaBDbs.3uV5rdP3fuhzaYaU6DGWztVfcjNprlK', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:37', '2021-11-10 18:35:37', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(79, 3, 'Katelynn Osinski', 'deron.muller@example.net', '$2y$10$q5bz7cz.LTttKfo4FxTreur35Kli3xtJHg90TmVIJiqy7Xodk9Uba', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:38', '2021-11-10 18:35:38', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(80, 3, 'Geraldine Gutkowski II', 'nickolas17@example.org', '$2y$10$hbQlUUcL9x2zn/JXDWWb9ekYWjQ8ehwhShcj57izPIv4m3Q2eM0xy', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:38', '2021-11-10 18:35:38', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(81, 3, 'Raleigh Keeling PhD', 'jboehm@example.com', '$2y$10$Lq3s04KY8rcW9jlKjyN8jOj/t7F7mRj4RITrazx4G4rZCbrp/w5sW', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:38', '2021-11-10 18:35:38', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(82, 3, 'Kay Miller II', 'christiansen.jazlyn@example.com', '$2y$10$QgQbkuH9iHkpJBRtZyYNm.6OccIad/u/VzUeIgxcRWy3aNYp47946', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:39', '2021-11-10 18:35:39', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(83, 3, 'Lenny Littel', 'smitham.celestino@example.com', '$2y$10$Ldmg8t6acD86rwfTOCaZdeCQtWPJ/yyu213N2sgxJZlIZ97NQ3v36', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:40', '2021-11-10 18:35:40', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(84, 3, 'Prof. Avis O\'Keefe', 'christiana.kautzer@example.com', '$2y$10$gdiAHJ34yOlTIg8g3iogJOAN09UNtw4B9eD0TKMravdM9X7EcYqcu', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:40', '2021-11-10 18:35:40', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(85, 3, 'Edgardo Dickens', 'price.janice@example.com', '$2y$10$n2AeoJrL7LoTy1K.qHHVreQtMn9bL432nKbGprJQWc.1MtJbQjoI6', NULL, NULL, NULL, 'male', 'en', 'deactive', 'enable', NULL, '2021-11-10 18:35:41', '2021-11-10 18:35:41', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(86, 3, 'Felicita Graham', 'kim84@example.com', '$2y$10$wliKt1XXOMzmHme3d81bj.2rGA9zo6vQROlb5m06txZ4TAvQ9nMNi', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:43', '2021-11-10 18:35:43', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(87, 3, 'Araceli Runte I', 'kshlerin.kory@example.net', '$2y$10$lzzzZlTk.cmNkNAE97vVo./qoHNHxJlaZqGfY4KBGB5UwIJccdxu2', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:43', '2021-11-10 18:35:43', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(88, 3, 'Mariela Koepp', 'turcotte.woodrow@example.com', '$2y$10$.yfr9Ug9l/Ux.Nnej4SpPu6gu37GxJAoAVEkE5NcHEyy9Xw2h5sgO', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:44', '2021-11-10 18:35:44', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(89, 3, 'Horacio Kuvalis II', 'lessie27@example.org', '$2y$10$cNqnTtxqor3/wzYMePiFDeQCWgEXaj4uNJ38BLe0EQ2kqFTzk4Oie', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:45', '2021-11-10 18:35:45', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(90, 3, 'Miss Cassie Lebsack', 'bergnaum.antwan@example.net', '$2y$10$hHd9U1Qd4NWm0WxedqMlkOKJm57c2MiJqcwVzR30.HFYy.1K7oSvy', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:46', '2021-11-10 18:35:46', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(91, 3, 'Prof. Liliane Becker', 'zboncak.maxwell@example.com', '$2y$10$1/dbmPUweevzilVzFmAZZe37Zc7qh6gdiNULOn0IojQroEU.qfEje', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:47', '2021-11-10 18:35:47', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(92, 3, 'Darion Stracke', 'twitting@example.com', '$2y$10$pEcn/wjn.YLVfyBRwKmk4Of3nnO5syhDchUIf7WyzY2lA1bcgwlTW', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:47', '2021-11-10 18:35:47', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(93, 3, 'Gerald Reinger', 'keeling.reese@example.org', '$2y$10$D9HEfRLXTxlNjbjTc7Q.FeR7JzjUEsxmKa2WHjfSrkZnqgePGwopS', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:47', '2021-11-10 18:35:47', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(94, 3, 'Malika Herman', 'scotty.kunze@example.com', '$2y$10$4xc5mejQ3/Gxevy29Z48juszUUG0.8RG8fkT1YLc7vZrwJ1D7qIcy', NULL, NULL, NULL, 'male', 'en', 'deactive', 'enable', NULL, '2021-11-10 18:35:48', '2021-11-10 18:35:48', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(95, 4, 'Randi Murray', 'kbarton@example.org', '$2y$10$ZS/I8YRQxor4VbOnL3bng.ljuabEue8iAMgyl/LG1YM/HJRoCBxFm', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:54', '2021-11-10 18:35:54', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(96, 4, 'Jaquan Kunze', 'roger19@example.net', '$2y$10$G9Q1CYic5BnGGwvKk6W.0uvj1V5dPKAiKmVRDYFf36fskFe6eRGYC', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:56', '2021-11-10 18:35:56', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(97, 4, 'Gillian Zieme', 'emory68@example.org', '$2y$10$h23z1aa701Ibb.SIyTyrm.d/yTVSGM/eBYh7oFG7gKUF93Km8gRZy', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:59', '2021-11-10 18:35:59', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(98, 4, 'Prof. Armand Kling', 'lindgren.amir@example.com', '$2y$10$VXO9K9S8Q5Be0HkbCA5xd.9za6yLpz1lCwSnaA90zeVi2DqRourBa', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:35:59', '2021-11-10 18:35:59', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(99, 4, 'Madyson Leannon', 'stella64@example.com', '$2y$10$zN0z4WVUGsowm3QxANKoVOAqFbqt68CoVulWAd5U7HhfGuG/X4XzK', NULL, NULL, NULL, 'male', 'en', 'deactive', 'enable', NULL, '2021-11-10 18:35:59', '2021-11-10 18:35:59', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(100, 4, 'Glenna Schinner', 'oparisian@example.net', '$2y$10$EIOYJd7LhWUzlpyPoOLIzeqCJy76V.9uhT4Kbwc2CtC0FAyzK74pC', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:00', '2021-11-10 18:36:00', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(101, 4, 'Tomasa Vandervort III', 'mertz.roy@example.net', '$2y$10$0JjpsenguBmk8GMP/iqSl.OSouQOMy4ydNnPDMKPDMw5ALs0PwaY2', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:00', '2021-11-10 18:36:00', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(102, 4, 'Edmund Schmeler', 'sward@example.org', '$2y$10$9AziYdHlK5i6lPxiNuCuX.qslRu5G4KQhhlI3yDXy1csMnAgXg5Um', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:01', '2021-11-10 18:36:01', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(103, 4, 'Eva Goldner', 'precious.mcdermott@example.net', '$2y$10$H6.n20P1phtuKtUQE//PGeP3nGTZRS7iBBRfc/fjxT9.jowIGA/Ma', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:01', '2021-11-10 18:36:01', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(104, 4, 'Boris Bashirian', 'kulas.keith@example.net', '$2y$10$HmZQSr9U8eWxefHMPWzOD.9g6Ugj8fs.oKIBXvSJJJNKCti8zadva', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:03', '2021-11-10 18:36:03', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(105, 4, 'Yesenia Windler', 'greenholt.dillon@example.com', '$2y$10$OLvteknZ3RiB3rAMqJovdeocHFKayZgUnNaPAt69x4yalsqvMUsGK', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:04', '2021-11-10 18:36:04', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(106, 4, 'Prof. Felicita Schulist', 'adicki@example.com', '$2y$10$EomdpkAG3RpGEMEFYNc6jumZ53hH.vEw69Mm3goynv5lzgCKqw4nW', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:07', '2021-11-10 18:36:07', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(107, 4, 'Libbie Crona', 'bmoen@example.com', '$2y$10$VgtjG0w.9RH8MI6jYbxpLOYqzsOTJy5tK/hfs9E9XrGmS4LyxJ0My', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:09', '2021-11-10 18:36:09', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(108, 4, 'Eulah Hilpert', 'leonel.quitzon@example.net', '$2y$10$RjKC4rB3howcG5EWtbrn7.b7/K0GmyUxvIiGT2oz4Cmmnkl///FsW', NULL, NULL, NULL, 'female', 'en', 'deactive', 'enable', NULL, '2021-11-10 18:36:10', '2021-11-10 18:36:10', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(109, 4, 'Carolanne Wilderman', 'drolfson@example.com', '$2y$10$qXNuqEh36Aw3ZbjdTeL8qeZRyc/uhzPHARn31wtmtYfTsyT7Xnio.', NULL, NULL, NULL, 'female', 'en', 'deactive', 'enable', NULL, '2021-11-10 18:36:10', '2021-11-10 18:36:10', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(110, 4, 'Mr. Lloyd Mante', 'ybernhard@example.org', '$2y$10$37opHkEFSQ.OLBb5Km0LuuaeK1I7e0D0fPIck1Ru7QfrEnU1nUxV6', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:11', '2021-11-10 18:36:11', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(111, 4, 'Mrs. Nikki Legros PhD', 'ipfannerstill@example.org', '$2y$10$aFtmhIwyBqsMzl82D01L7.xPllUDSJdUrQzGMGXDaPC0AQ6YHy9xK', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:12', '2021-11-10 18:36:12', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(112, 4, 'Alphonso Emmerich', 'camron44@example.net', '$2y$10$ZYsEe.3m7kk2qiyn8JU4QeX/cF4wOp8Q6qzQrWTqdS7ro1gx8IXnW', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:13', '2021-11-10 18:36:13', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(113, 4, 'Leola King', 'dskiles@example.net', '$2y$10$fE/LzeAzvwWtW2c1GQm6yuDtcWSepZc2QmcLpW0ln9hJl6O6NK1B.', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:13', '2021-11-10 18:36:13', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(114, 4, 'Prof. Blair Considine Sr.', 'herminio.bartell@example.org', '$2y$10$xSvciabBtSUJxko8V8YP3em3ZZcrla7wBl/iol6g1XaNeIY4C61se', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:13', '2021-11-10 18:36:13', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(115, 4, 'Josephine Ritchie', 'damore.miles@example.net', '$2y$10$oREzY/wYam4gaQxcAFS3zOwTwrjrOyJA6EAJ6hFRrxyi221MtJ9D2', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:15', '2021-11-10 18:36:15', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(116, 4, 'Urban Rice', 'hhackett@example.org', '$2y$10$ow9mc.q3HmGWyVxytI6ylOy9MElqq5rnpTGs.ZF.soHeBg7i4T1Da', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:16', '2021-11-10 18:36:16', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(117, 4, 'Ms. Emily Bernier', 'homenick.georgianna@example.com', '$2y$10$8FuOO228zGJ8eblaLCn0R.XiC93GEXf0lE0UG8txbfQlbUEowuTHS', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:16', '2021-11-10 18:36:16', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(118, 4, 'Lucy Parker', 'nella08@example.com', '$2y$10$Sv/wn61HQZ5PzaavR4PJDObRAB2jhIZq7kqvnG1blZervYiPI3Smy', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:16', '2021-11-10 18:36:16', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(119, 4, 'Garrick Macejkovic', 'reanna.stark@example.net', '$2y$10$WWT1hqj/8uGhgyVNE.55SOUgJljCfkwdulWA2DAchXUbyf7HBD1hS', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:16', '2021-11-10 18:36:16', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(120, 4, 'Rosetta Schmeler', 'oconnell.lucienne@example.com', '$2y$10$7T6MoGGtlgoOzNuVihw7TO/VOniIb.yofSOeZE.KbUFbpUvbqQ4NC', NULL, NULL, NULL, 'female', 'en', 'deactive', 'enable', NULL, '2021-11-10 18:36:17', '2021-11-10 18:36:17', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(121, 4, 'Nathanael Heaney', 'dcartwright@example.net', '$2y$10$T78WVT9q.8He8knyeSEf5ONu.D50/ALh0HKrIrLHyId/Nl/3buQkS', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:18', '2021-11-10 18:36:18', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(122, 4, 'Dr. Demarcus Hagenes DVM', 'kasey.labadie@example.org', '$2y$10$iWGkAMN5Pgg.YQzasS9LNen3l9/hJf5ub.v2c1TkKr0Gw.aCx7kHO', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:18', '2021-11-10 18:36:18', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(123, 4, 'Mr. Mathew Rippin', 'huels.carol@example.net', '$2y$10$G.5k6Ql0ZblfnEL.6MrOYuIjWmw.cC9DlFVzOeDWnnHRyl3kUviSG', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:19', '2021-11-10 18:36:19', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(124, 4, 'Lavon Fadel I', 'kris.lilly@example.net', '$2y$10$ed.ELeSMV1v9dTggRzmk3O.l2gteu7ZDDzFxlFRcly/n5YACIkcku', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:19', '2021-11-10 18:36:19', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(125, 5, 'Mrs. April Witting', 'miller.sarai@example.org', '$2y$10$ensE0Ylwp.OfJOgHX/T8kOVmd2RfsEhHsLMHX6b/UYu7GTa70Yhdi', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:26', '2021-11-10 18:36:26', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(126, 5, 'Miss Julianne Ledner IV', 'turcotte.matt@example.com', '$2y$10$BxyApv.uVziT.LOO.RwfYu.0Gnm3XOCBDKmaBjosSSYwHBOsk7uk6', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:27', '2021-11-10 18:36:27', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(127, 5, 'Freddie Labadie', 'jchamplin@example.org', '$2y$10$adIxktZvgNbSXJDScZgu7uJmzSZtGuYbDMACIz7iekqGY6cqyd4kK', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:27', '2021-11-10 18:36:27', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(128, 5, 'Aurelio Balistreri', 'melba71@example.org', '$2y$10$go9ijF.ra5sLW0s3adZf3uCWRxCo2/UfnWTg8l4pYyuhQOVE/iwA2', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:28', '2021-11-10 18:36:28', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(129, 5, 'Eriberto Halvorson MD', 'borer.cristobal@example.net', '$2y$10$uUhwCNBSanlEDoDXdU8dxeNB6Hm7rTSPKIW653XRW99lw7OszLZCe', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:29', '2021-11-10 18:36:29', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(130, 5, 'Mr. Diego Ward I', 'shane80@example.net', '$2y$10$QyhCf76IIiguKsdpQMAaqOyNhswgSB6SiTXQIT4ZYSF4Go/a5QfvK', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:29', '2021-11-10 18:36:29', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(131, 5, 'Mr. Leo Davis V', 'taryn62@example.org', '$2y$10$C5vM94jpdq9zDStUy5Oj4eUbigPEV0lOg8Vu43A7U4Ed3IutDSrt2', NULL, NULL, NULL, 'male', 'en', 'deactive', 'enable', NULL, '2021-11-10 18:36:30', '2021-11-10 18:36:30', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(132, 5, 'Oren Ruecker', 'switting@example.com', '$2y$10$VmGy1Qhr/h8b6QTb/E92Tued2yhI3ZnRmwUZRs1zYUOO/AHOlhxvC', NULL, NULL, NULL, 'male', 'en', 'deactive', 'enable', NULL, '2021-11-10 18:36:31', '2021-11-10 18:36:31', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(133, 5, 'Laurel Kreiger III', 'pkertzmann@example.com', '$2y$10$6LIEEDctgTooSZt9ayS90Op/PC/TX2fFC9Zy3JabWQZgCBnCDRlFq', NULL, NULL, NULL, 'male', 'en', 'deactive', 'enable', NULL, '2021-11-10 18:36:33', '2021-11-10 18:36:33', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(134, 5, 'Renee Beahan', 'brannon.dooley@example.net', '$2y$10$NY043SaEgaZCnt955Q50K.onH3VsMjzZRkG60h/trj//MXEx2uDNe', NULL, NULL, NULL, 'male', 'en', 'deactive', 'enable', NULL, '2021-11-10 18:36:33', '2021-11-10 18:36:33', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(135, 5, 'Taya Nikolaus', 'turcotte.emil@example.net', '$2y$10$ocLo5iUyYqkUFekSN.yAze0SP1eMGCEP9IigPvdm4TzQsvyjYRi26', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:36', '2021-11-10 18:36:36', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(136, 5, 'Peter Wuckert', 'joshua.purdy@example.net', '$2y$10$SIISrZRXpKtIVCoeeBPzxujQBwa7ttGTE0KnKxYUfe3q/GC0qs.s6', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:37', '2021-11-10 18:36:37', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(137, 5, 'Prof. Trevor Connelly', 'oterry@example.org', '$2y$10$0fzpDD657gPLYQYx9lrZnuvE7gY4K2QgYgqOarPJpAlsWuyz0hIku', NULL, NULL, NULL, 'female', 'en', 'deactive', 'enable', NULL, '2021-11-10 18:36:37', '2021-11-10 18:36:37', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(138, 5, 'Rosetta Dibbert', 'maximillia.goodwin@example.com', '$2y$10$y8PFA5elmFlYTOKvc1LGz.8s.JYrPj/lTUy5lh.THjoCIlc0qydeu', NULL, NULL, NULL, 'male', 'en', 'deactive', 'enable', NULL, '2021-11-10 18:36:38', '2021-11-10 18:36:38', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(139, 5, 'Jason Feeney', 'schinner.eula@example.net', '$2y$10$IeL3U2VpqD5Nrl3iEtCkCuNTtm0Zmb2BlWWi3AG/BtCzB9rMMng5G', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:39', '2021-11-10 18:36:39', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(140, 5, 'Kurtis Hoeger II', 'adeline.jenkins@example.net', '$2y$10$iHgLvTeRqN2szHhHX5Ci3uE8N5VXNpGCjvYB6PHCAs8ljtTi9gxJy', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:40', '2021-11-10 18:36:40', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(141, 5, 'Gerda Wiza', 'franz.smith@example.net', '$2y$10$dti3RUbONHQLrdwcX3c31uNwtId8ubk5VO10YqC7ySrD4weLpexSe', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:40', '2021-11-10 18:36:40', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(142, 5, 'Dr. Hope Waelchi MD', 'jakayla20@example.com', '$2y$10$9.As7Ff0BCVL2SoJzOHS0uujcWuf7rMvwNf57rF3/RSZuVLRlhVay', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:41', '2021-11-10 18:36:41', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(143, 5, 'Antonette Fay', 'karianne.ryan@example.org', '$2y$10$Nv6p/QwV8ZKS1glq8A9.Ye0ZEDQxtNgW7TgrqnL6lm/mJGhDWDO2a', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:41', '2021-11-10 18:36:41', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(144, 5, 'Ms. Rosanna Reichel', 'alejandra06@example.net', '$2y$10$t80Kpj9KDg2V35rzg47CN.yXZxru72BBSqSGDlpK9jzXyBziPLIHq', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:42', '2021-11-10 18:36:42', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(145, 5, 'Macy Prosacco III', 'augustine.runolfsson@example.net', '$2y$10$z2ANNJb2VegDcb2OaWdI1.Tn0/GXiLqkz42NHLYIlahAXSG78GUhq', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:43', '2021-11-10 18:36:43', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(146, 5, 'Glennie Schimmel IV', 'cassin.george@example.org', '$2y$10$g6UXaMeJGOrlDe.2ZPjAlu1eA7oPRvGugJ78pMaA/3YNdl6pFiLMK', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:43', '2021-11-10 18:36:43', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(147, 5, 'Izaiah Kuhlman', 'sauer.lawson@example.net', '$2y$10$JlLVYSYEFQaUXOhPvxzOTu8DKpZYz2K1sDv5oGk9cMQuqqV.KrmrS', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:43', '2021-11-10 18:36:43', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(148, 5, 'Lamar Hessel', 'cecelia52@example.org', '$2y$10$qdOVuZK2pYZSO3DMUBqZZOCapQecOBRfMR1LrNndLcyKw438zwWwW', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:44', '2021-11-10 18:36:44', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(149, 5, 'Duane Morissette', 'lionel.torp@example.com', '$2y$10$4VKLkansI.2lozUwJzAoAOZInaz0dwC2bjZOvaFx2mQi98RY2fCam', NULL, NULL, NULL, 'female', 'en', 'deactive', 'enable', NULL, '2021-11-10 18:36:44', '2021-11-10 18:36:44', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(150, 5, 'Dewayne Goldner', 'annabell.macejkovic@example.com', '$2y$10$01s8Ryp/WD/mUUT8hDKv2u4MbZ9LZpCDauk5vHSAWHpUXGtp/7JaW', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:44', '2021-11-10 18:36:44', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(151, 5, 'Haleigh Casper I', 'kullrich@example.org', '$2y$10$SEHj4kxuPtruzpqh9P9x6u7Dv0GQrBwN1FkbwPg6TJ2Iyf6s8TZVq', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:44', '2021-11-10 18:36:44', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(152, 5, 'Chester Kessler V', 'haleigh57@example.org', '$2y$10$YHgSKIv1welqoF0iUYeSYOt4sOP92q9EpsRnCcvYFxa.hM50t1L/2', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:44', '2021-11-10 18:36:44', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(153, 5, 'Theo Connelly PhD', 'ltromp@example.com', '$2y$10$tWem8ivkRUUAe3f887E7WeXbxKoXbTKS2jz/9Ofahv6tWaMXooqbi', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:46', '2021-11-10 18:36:46', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(154, 5, 'Dr. Christy Weimann', 'margie80@example.org', '$2y$10$4fgrAQaPLY1id2.qb7Xgbe9jPyvgpu2Dc1y7vs.yURRgbXJKGDYwW', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:46', '2021-11-10 18:36:46', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(155, 6, 'Nya Brekke', 'little.kendall@example.net', '$2y$10$sBoWNlp7MgMJK7Gry4YHJuMG.YlxQ6HklM9Cygjw2EnYLN2PUZl52', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:49', '2021-11-10 18:36:49', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(156, 6, 'Roosevelt Thompson', 'luigi.marks@example.org', '$2y$10$jDJNU0EJ2tuB6BLA.EiINe2yPF157ravweDXSMmk/Lwbvxvt5cbqO', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:50', '2021-11-10 18:36:50', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(157, 6, 'Jacques Fisher', 'jake.franecki@example.com', '$2y$10$h66JEkUop4zKwk1NjF8VG.sxmdH5nukyyIN/rYsjc774/0E8bB.Ee', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:51', '2021-11-10 18:36:51', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(158, 6, 'Dr. Martine Thiel', 'muller.erling@example.net', '$2y$10$heLoaOzOmDS0kSPl6.P7b.LLINlFJOR/617AIhA5EgKrsJk8KJj/u', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:53', '2021-11-10 18:36:53', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(159, 6, 'Nico Upton', 'fritsch.juwan@example.com', '$2y$10$15mb6M5QAFeAYoz2OPJwN.Wag/NmGjvpynKNtzOa588SS.XFPTh3y', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:53', '2021-11-10 18:36:53', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(160, 6, 'Bernardo Fahey', 'reilly.cynthia@example.net', '$2y$10$CSZDnurZvgoIO..AiF6Mq.kUqRO2akgyvTHx4quT8AnVeobS/i4Em', NULL, NULL, NULL, 'male', 'en', 'deactive', 'enable', NULL, '2021-11-10 18:36:55', '2021-11-10 18:36:55', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(161, 6, 'Andre Brown', 'trantow.hanna@example.org', '$2y$10$z3FOBN5DEOHQa9Q1UfMGIOlfJrNtWQulVXyZCWmr5NTOjcWzGrcdK', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:36:56', '2021-11-10 18:36:56', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(162, 6, 'Alex Rosenbaum', 'gillian50@example.com', '$2y$10$sz61eF5w5KjNiP7UK2/8rO0YpJnvJYNR9m4TVfhnPdgh.W.n6mxDO', NULL, NULL, NULL, 'female', 'en', 'deactive', 'enable', NULL, '2021-11-10 18:36:59', '2021-11-10 18:36:59', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(163, 6, 'Harmon Dach', 'armando70@example.org', '$2y$10$fsf4kBb6pGQD8aPgpYVmtONagXx4rR38eaJInx1GeCN7NrH0w.tNy', NULL, NULL, NULL, 'female', 'en', 'deactive', 'enable', NULL, '2021-11-10 18:37:00', '2021-11-10 18:37:00', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(164, 6, 'Isabella Douglas V', 'newton.dooley@example.org', '$2y$10$FuRPZVDRGC1MiDMgoUJYDeXhsdlVt8.LwMlriIluiSGhAOejFbcFu', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:37:01', '2021-11-10 18:37:01', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(165, 6, 'Deanna Ullrich', 'juliana53@example.net', '$2y$10$.u/FzTPern4JoajXZcMTLuaIHs92GKfmCFHDekq3UWaDzhraQdW.m', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:37:03', '2021-11-10 18:37:03', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(166, 6, 'Colby Schmeler Sr.', 'bwillms@example.com', '$2y$10$5nb/To5HHFj/HQTsipYDXu2ATjQVwI3OSZVy8TAKaVCX7mA5b4ltS', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:37:04', '2021-11-10 18:37:04', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(167, 6, 'Joe Prohaska', 'wava14@example.net', '$2y$10$8Up3VhPkXIvFkTSaTZfNvO.Y2oqciqC9yXBJcrnl1fPpIMjn63UHS', NULL, NULL, NULL, 'male', 'en', 'deactive', 'enable', NULL, '2021-11-10 18:37:04', '2021-11-10 18:37:04', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(168, 6, 'Carole Bechtelar', 'uvon@example.org', '$2y$10$wd0XRZmCJX67NM9WYeh.OOciewBBLV7PVdoCCPMQVG.oPkYFAjRjS', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:37:05', '2021-11-10 18:37:05', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(169, 6, 'Jailyn Gleason', 'kuhn.bobby@example.com', '$2y$10$h40BXWr5AjVbnIRc/36Sle2XAWOUaWSrbsO3b4Sh6ZG/wrP6x0KzW', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:37:06', '2021-11-10 18:37:06', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(170, 6, 'Magnolia Kuvalis', 'ucollins@example.org', '$2y$10$CzKSlAE7OqZaYdbBfYFceOMbkAPw7UhN2S9Lgj8AOWIr/If3i3P4a', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:37:07', '2021-11-10 18:37:07', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(171, 6, 'Mr. Flavio VonRueden IV', 'angie51@example.net', '$2y$10$w6vJCW.QLAY.28R1x.at1OHAgMQO9pqHjasVWqC0vYEtbXwNIsExq', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:37:07', '2021-11-10 18:37:07', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(172, 6, 'Prof. Jayce Swift I', 'spencer.emmet@example.org', '$2y$10$YEWo.D1QRRCEOH0EUFhuYeC1hLTdzfvqqbNOSkIyPM/Vwvieo2XJm', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:37:08', '2021-11-10 18:37:08', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(173, 6, 'Monica Grady DDS', 'wwiegand@example.com', '$2y$10$Fp5MDHoupBie80VAKcpfiOaaN7VrhPKk3/Owp7sqMPWj42KpqUQl.', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:37:08', '2021-11-10 18:37:08', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(174, 6, 'Skyla Reichert DVM', 'uwyman@example.org', '$2y$10$241QM7TEvLBuo/jpwskFS.ddzhtvdoR8fR/mo8esJg.AzA2jACAy2', NULL, NULL, NULL, 'female', 'en', 'deactive', 'enable', NULL, '2021-11-10 18:37:09', '2021-11-10 18:37:09', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(175, 6, 'Dr. Deven Kertzmann', 'predovic.mckenna@example.net', '$2y$10$wpDoG8sOXKG3XuzSWK.JquA2tt6R0ytYgrK7ig9s/uqWoAE5L7jrS', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:37:10', '2021-11-10 18:37:10', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(176, 6, 'Prof. Nasir Feest MD', 'lenora.kling@example.com', '$2y$10$v9aphqnODy9Yb.Y7DPjRA.MONvvWzVMGcugyb2COYeFIVq02L8IMC', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:37:11', '2021-11-10 18:37:11', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(177, 6, 'Osvaldo Zulauf', 'gryan@example.com', '$2y$10$hLf1sJK1l1idk/5T9oUCqehCjiTwf2Lu2CCJ7TzR9mbwlYPs.1UTi', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:37:11', '2021-11-10 18:37:11', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `users` (`id`, `company_id`, `name`, `email`, `password`, `remember_token`, `image`, `mobile`, `gender`, `locale`, `status`, `login`, `onesignal_player_id`, `created_at`, `updated_at`, `super_admin`, `email_verification_code`, `social_token`, `email_notifications`, `country_id`, `authorize_id`, `authorize_payment_id`, `card_brand`, `card_last_four`, `last_login`) VALUES
(178, 6, 'Isac Funk', 'mueller.aliya@example.net', '$2y$10$DJ0DeUkoy6nPeHjVZda0TOf8.l9atApG2HGYgisk6j7Rn82IattlS', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:37:11', '2021-11-10 18:37:11', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(179, 6, 'Remington Hayes', 'greenfelder.lorenzo@example.org', '$2y$10$zU3MRNlVGDoJPNHyYc5Z4OUPSzovCHMeF6COfVeNO9ymLiP7kaDuK', NULL, NULL, NULL, 'male', 'en', 'deactive', 'enable', NULL, '2021-11-10 18:37:12', '2021-11-10 18:37:12', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(180, 6, 'Dr. Eldora Doyle Jr.', 'deanna61@example.com', '$2y$10$YrsfzojBZUG2aUDuR8qm/uc7OElQmxMoIRrsG/wh0/xGQXQsvMCfm', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:37:12', '2021-11-10 18:37:12', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(181, 6, 'Ms. Justine Thompson Sr.', 'gibson.tod@example.com', '$2y$10$Qg.eTU2qgfwH10xvNGaoIu3o7u1BkmvyrPQteNNwCXQJSKEynAT6m', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:37:12', '2021-11-10 18:37:12', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(182, 6, 'Estell Parker', 'alf07@example.org', '$2y$10$o8Ol2Ogq7NRd6IpycENoO.b4iX3pu5HFudEnfskZ4gtGUCKqJAX2C', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2021-11-10 18:37:13', '2021-11-10 18:37:13', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(183, 6, 'Celine Mayer', 'rrath@example.net', '$2y$10$CHpuCCqQSqEoqw3psJUVR.7T5fueus8vwYQbUipLEskJ4jNP5j0sq', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:37:13', '2021-11-10 18:37:13', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(184, 6, 'Freeda Beatty', 'austin32@example.net', '$2y$10$FlYsPTSOYxdmXSmvfNgR1O/othqiccZ363d0MSuvFYW63nFWMyEl.', NULL, NULL, NULL, 'female', 'en', 'active', 'enable', NULL, '2021-11-10 18:37:14', '2021-11-10 18:37:14', '0', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_chat`
--

CREATE TABLE `users_chat` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_one` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `message` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `from` int(10) UNSIGNED DEFAULT NULL,
  `to` int(10) UNSIGNED DEFAULT NULL,
  `message_seen` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_chat_files`
--

CREATE TABLE `users_chat_files` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `users_chat_id` int(10) UNSIGNED NOT NULL,
  `filename` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `google_url` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hashname` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `size` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `external_link` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `external_link_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_activities`
--

CREATE TABLE `user_activities` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `activity` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accept_estimates`
--
ALTER TABLE `accept_estimates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accept_estimates_company_id_foreign` (`company_id`),
  ADD KEY `accept_estimates_estimate_id_foreign` (`estimate_id`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendances_user_id_foreign` (`user_id`),
  ADD KEY `attendances_company_id_foreign` (`company_id`);

--
-- Indexes for table `attendance_settings`
--
ALTER TABLE `attendance_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendance_settings_company_id_foreign` (`company_id`);

--
-- Indexes for table `authorize_invoices`
--
ALTER TABLE `authorize_invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `authorize_invoices_company_id_foreign` (`company_id`),
  ADD KEY `authorize_invoices_package_id_foreign` (`package_id`);

--
-- Indexes for table `authorize_subscriptions`
--
ALTER TABLE `authorize_subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `authorize_subscriptions_company_id_foreign` (`company_id`),
  ADD KEY `authorize_subscriptions_plan_id_foreign` (`plan_id`);

--
-- Indexes for table `borrowings`
--
ALTER TABLE `borrowings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `borrower` (`borrower`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `approved_by` (`approved_by`),
  ADD KEY `resources` (`resources`);

--
-- Indexes for table `client_categories`
--
ALTER TABLE `client_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_categories_company_id_foreign` (`company_id`);

--
-- Indexes for table `client_contacts`
--
ALTER TABLE `client_contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_contacts_user_id_foreign` (`user_id`),
  ADD KEY `client_contacts_company_id_foreign` (`company_id`);

--
-- Indexes for table `client_details`
--
ALTER TABLE `client_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_details_user_id_foreign` (`user_id`),
  ADD KEY `client_details_company_id_foreign` (`company_id`),
  ADD KEY `client_details_country_id_foreign` (`country_id`),
  ADD KEY `client_details_category_id_foreign` (`category_id`),
  ADD KEY `client_details_sub_category_id_foreign` (`sub_category_id`);

--
-- Indexes for table `client_docs`
--
ALTER TABLE `client_docs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_docs_company_id_foreign` (`company_id`),
  ADD KEY `client_docs_user_id_foreign` (`user_id`);

--
-- Indexes for table `client_sub_categories`
--
ALTER TABLE `client_sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_sub_categories_category_id_foreign` (`category_id`),
  ADD KEY `client_sub_categories_company_id_foreign` (`company_id`);

--
-- Indexes for table `client_user_notes`
--
ALTER TABLE `client_user_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_user_notes_company_id_foreign` (`company_id`),
  ADD KEY `client_user_notes_user_id_foreign` (`user_id`),
  ADD KEY `client_user_notes_note_id_foreign` (`note_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `organisation_settings_last_updated_by_foreign` (`last_updated_by`),
  ADD KEY `companies_package_id_foreign` (`package_id`),
  ADD KEY `companies_default_task_status_foreign` (`default_task_status`),
  ADD KEY `companies_currency_id_foreign` (`currency_id`);

--
-- Indexes for table `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contracts_company_id_foreign` (`company_id`),
  ADD KEY `contracts_client_id_foreign` (`client_id`),
  ADD KEY `contracts_contract_type_id_foreign` (`contract_type_id`);

--
-- Indexes for table `contract_discussions`
--
ALTER TABLE `contract_discussions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contract_discussions_company_id_foreign` (`company_id`),
  ADD KEY `contract_discussions_contract_id_foreign` (`contract_id`),
  ADD KEY `contract_discussions_from_foreign` (`from`);

--
-- Indexes for table `contract_files`
--
ALTER TABLE `contract_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contract_files_company_id_foreign` (`company_id`),
  ADD KEY `contract_files_user_id_foreign` (`user_id`),
  ADD KEY `contract_files_contract_id_foreign` (`contract_id`);

--
-- Indexes for table `contract_renews`
--
ALTER TABLE `contract_renews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contract_renews_company_id_foreign` (`company_id`),
  ADD KEY `contract_renews_renewed_by_foreign` (`renewed_by`),
  ADD KEY `contract_renews_contract_id_foreign` (`contract_id`);

--
-- Indexes for table `contract_signs`
--
ALTER TABLE `contract_signs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contract_signs_company_id_foreign` (`company_id`),
  ADD KEY `contract_signs_contract_id_foreign` (`contract_id`);

--
-- Indexes for table `contract_types`
--
ALTER TABLE `contract_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contract_types_company_id_foreign` (`company_id`);

--
-- Indexes for table `conversation`
--
ALTER TABLE `conversation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conversation_user_one_foreign` (`user_one`),
  ADD KEY `conversation_user_two_foreign` (`user_two`);

--
-- Indexes for table `conversation_reply`
--
ALTER TABLE `conversation_reply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conversation_reply_conversation_id_foreign` (`conversation_id`),
  ADD KEY `conversation_reply_user_id_foreign` (`user_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `credit_notes`
--
ALTER TABLE `credit_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `credit_notes_company_id_foreign` (`company_id`),
  ADD KEY `credit_notes_project_id_foreign` (`project_id`),
  ADD KEY `credit_notes_currency_id_foreign` (`currency_id`),
  ADD KEY `credit_notes_client_id_foreign` (`client_id`);

--
-- Indexes for table `credit_notes_invoice`
--
ALTER TABLE `credit_notes_invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `credit_note_items`
--
ALTER TABLE `credit_note_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `credit_note_items_credit_note_id_foreign` (`credit_note_id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `currencies_company_id_foreign` (`company_id`);

--
-- Indexes for table `currency_format_settings`
--
ALTER TABLE `currency_format_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `currency_format_settings_company_id_foreign` (`company_id`);

--
-- Indexes for table `custom_fields`
--
ALTER TABLE `custom_fields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `custom_fields_custom_field_group_id_foreign` (`custom_field_group_id`);

--
-- Indexes for table `custom_fields_data`
--
ALTER TABLE `custom_fields_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `custom_fields_data_custom_field_id_foreign` (`custom_field_id`),
  ADD KEY `custom_fields_data_model_index` (`model`);

--
-- Indexes for table `custom_field_groups`
--
ALTER TABLE `custom_field_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `custom_field_groups_model_index` (`model`),
  ADD KEY `custom_field_groups_company_id_foreign` (`company_id`);

--
-- Indexes for table `dashboard_widgets`
--
ALTER TABLE `dashboard_widgets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dashboard_widgets_company_id_foreign` (`company_id`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `designations_company_id_foreign` (`company_id`);

--
-- Indexes for table `discussions`
--
ALTER TABLE `discussions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `discussions_company_id_foreign` (`company_id`),
  ADD KEY `discussions_discussion_category_id_foreign` (`discussion_category_id`),
  ADD KEY `discussions_project_id_foreign` (`project_id`),
  ADD KEY `discussions_user_id_foreign` (`user_id`),
  ADD KEY `discussions_best_answer_id_foreign` (`best_answer_id`),
  ADD KEY `discussions_last_reply_by_id_foreign` (`last_reply_by_id`);

--
-- Indexes for table `discussion_categories`
--
ALTER TABLE `discussion_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `discussion_categories_company_id_foreign` (`company_id`);

--
-- Indexes for table `discussion_files`
--
ALTER TABLE `discussion_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `discussion_files_company_id_foreign` (`company_id`),
  ADD KEY `discussion_files_user_id_foreign` (`user_id`),
  ADD KEY `discussion_files_discussion_id_foreign` (`discussion_id`),
  ADD KEY `discussion_files_discussion_reply_id_foreign` (`discussion_reply_id`);

--
-- Indexes for table `discussion_replies`
--
ALTER TABLE `discussion_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `discussion_replies_company_id_foreign` (`company_id`),
  ADD KEY `discussion_replies_discussion_id_foreign` (`discussion_id`),
  ADD KEY `discussion_replies_user_id_foreign` (`user_id`);

--
-- Indexes for table `email_notification_settings`
--
ALTER TABLE `email_notification_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email_notification_settings_company_id_foreign` (`company_id`);

--
-- Indexes for table `employee_details`
--
ALTER TABLE `employee_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_details_slack_username_unique` (`slack_username`),
  ADD KEY `employee_details_user_id_foreign` (`user_id`),
  ADD KEY `employee_details_company_id_foreign` (`company_id`),
  ADD KEY `employee_details_designation_id_foreign` (`designation_id`),
  ADD KEY `employee_details_department_id_foreign` (`department_id`);

--
-- Indexes for table `employee_docs`
--
ALTER TABLE `employee_docs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_docs_user_id_foreign` (`user_id`),
  ADD KEY `employee_docs_company_id_foreign` (`company_id`);

--
-- Indexes for table `employee_faqs`
--
ALTER TABLE `employee_faqs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_faqs_company_id_foreign` (`company_id`),
  ADD KEY `employee_faqs_employee_faq_category_id_foreign` (`employee_faq_category_id`);

--
-- Indexes for table `employee_faq_categories`
--
ALTER TABLE `employee_faq_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_faq_categories_company_id_foreign` (`company_id`);

--
-- Indexes for table `employee_faq_files`
--
ALTER TABLE `employee_faq_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_faq_files_company_id_foreign` (`company_id`),
  ADD KEY `employee_faq_files_user_id_foreign` (`user_id`),
  ADD KEY `employee_faq_files_employee_faq_id_foreign` (`employee_faq_id`);

--
-- Indexes for table `employee_leave_quotas`
--
ALTER TABLE `employee_leave_quotas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_leave_quotas_company_id_foreign` (`company_id`),
  ADD KEY `employee_leave_quotas_user_id_foreign` (`user_id`),
  ADD KEY `employee_leave_quotas_leave_type_id_foreign` (`leave_type_id`);

--
-- Indexes for table `employee_skills`
--
ALTER TABLE `employee_skills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_skills_user_id_foreign` (`user_id`),
  ADD KEY `employee_skills_skill_id_foreign` (`skill_id`);

--
-- Indexes for table `employee_teams`
--
ALTER TABLE `employee_teams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_teams_team_id_foreign` (`team_id`),
  ADD KEY `employee_teams_user_id_foreign` (`user_id`);

--
-- Indexes for table `estimates`
--
ALTER TABLE `estimates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estimates_client_id_foreign` (`client_id`),
  ADD KEY `estimates_currency_id_foreign` (`currency_id`),
  ADD KEY `estimates_company_id_foreign` (`company_id`);

--
-- Indexes for table `estimate_items`
--
ALTER TABLE `estimate_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estimate_items_estimate_id_foreign` (`estimate_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `events_company_id_foreign` (`company_id`),
  ADD KEY `events_category_id_foreign` (`category_id`),
  ADD KEY `events_event_type_id_foreign` (`event_type_id`);

--
-- Indexes for table `event_attendees`
--
ALTER TABLE `event_attendees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_attendees_user_id_foreign` (`user_id`),
  ADD KEY `event_attendees_event_id_foreign` (`event_id`);

--
-- Indexes for table `event_categories`
--
ALTER TABLE `event_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_categories_company_id_foreign` (`company_id`);

--
-- Indexes for table `event_types`
--
ALTER TABLE `event_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_types_company_id_foreign` (`company_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_currency_id_foreign` (`currency_id`),
  ADD KEY `expenses_user_id_foreign` (`user_id`),
  ADD KEY `expenses_company_id_foreign` (`company_id`),
  ADD KEY `expenses_expenses_recurring_id_foreign` (`expenses_recurring_id`),
  ADD KEY `expenses_created_by_foreign` (`created_by`),
  ADD KEY `expenses_category_id_foreign` (`category_id`);

--
-- Indexes for table `expenses_category`
--
ALTER TABLE `expenses_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_category_company_id_foreign` (`company_id`);

--
-- Indexes for table `expenses_category_roles`
--
ALTER TABLE `expenses_category_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_category_roles_company_id_foreign` (`company_id`),
  ADD KEY `expenses_category_roles_expenses_category_id_foreign` (`expenses_category_id`),
  ADD KEY `expenses_category_roles_role_id_foreign` (`role_id`);

--
-- Indexes for table `expenses_recurring`
--
ALTER TABLE `expenses_recurring`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_recurring_company_id_foreign` (`company_id`),
  ADD KEY `expenses_recurring_currency_id_foreign` (`currency_id`),
  ADD KEY `expenses_recurring_project_id_foreign` (`project_id`),
  ADD KEY `expenses_recurring_user_id_foreign` (`user_id`),
  ADD KEY `expenses_recurring_created_by_foreign` (`created_by`),
  ADD KEY `expenses_recurring_category_id_foreign` (`category_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faqs_faq_category_id_foreign` (`faq_category_id`);

--
-- Indexes for table `faq_categories`
--
ALTER TABLE `faq_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faq_files`
--
ALTER TABLE `faq_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faq_files_user_id_foreign` (`user_id`),
  ADD KEY `faq_files_faq_id_foreign` (`faq_id`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`id`),
  ADD KEY `features_language_setting_id_foreign` (`language_setting_id`),
  ADD KEY `features_front_feature_id_foreign` (`front_feature_id`);

--
-- Indexes for table `file_storage`
--
ALTER TABLE `file_storage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `file_storage_company_id_foreign` (`company_id`);

--
-- Indexes for table `file_storage_settings`
--
ALTER TABLE `file_storage_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `file_storage_settings_company_id_foreign` (`company_id`);

--
-- Indexes for table `footer_menu`
--
ALTER TABLE `footer_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `footer_menu_language_setting_id_foreign` (`language_setting_id`);

--
-- Indexes for table `front_clients`
--
ALTER TABLE `front_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `front_clients_language_setting_id_foreign` (`language_setting_id`);

--
-- Indexes for table `front_details`
--
ALTER TABLE `front_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `front_faqs`
--
ALTER TABLE `front_faqs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `front_faqs_language_setting_id_foreign` (`language_setting_id`);

--
-- Indexes for table `front_features`
--
ALTER TABLE `front_features`
  ADD PRIMARY KEY (`id`),
  ADD KEY `front_features_language_setting_id_foreign` (`language_setting_id`);

--
-- Indexes for table `front_menu_buttons`
--
ALTER TABLE `front_menu_buttons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `front_menu_buttons_language_setting_id_foreign` (`language_setting_id`);

--
-- Indexes for table `front_widgets`
--
ALTER TABLE `front_widgets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gdpr_settings`
--
ALTER TABLE `gdpr_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gdpr_settings_company_id_foreign` (`company_id`);

--
-- Indexes for table `global_currencies`
--
ALTER TABLE `global_currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `global_settings`
--
ALTER TABLE `global_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `global_settings_last_updated_by_foreign` (`last_updated_by`),
  ADD KEY `global_settings_currency_id_foreign` (`currency_id`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`),
  ADD KEY `holidays_company_id_foreign` (`company_id`);

--
-- Indexes for table `inventories`
--
ALTER TABLE `inventories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoices_project_id_foreign` (`project_id`),
  ADD KEY `invoices_currency_id_foreign` (`currency_id`),
  ADD KEY `invoices_company_id_foreign` (`company_id`),
  ADD KEY `invoices_estimate_id_foreign` (`estimate_id`),
  ADD KEY `invoices_client_id_foreign` (`client_id`),
  ADD KEY `invoices_invoice_recurring_id_foreign` (`invoice_recurring_id`),
  ADD KEY `invoices_created_by_foreign` (`created_by`),
  ADD KEY `approved_by` (`approved_by`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_items_invoice_id_foreign` (`invoice_id`);

--
-- Indexes for table `invoice_recurring`
--
ALTER TABLE `invoice_recurring`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_recurring_company_id_foreign` (`company_id`),
  ADD KEY `invoice_recurring_currency_id_foreign` (`currency_id`),
  ADD KEY `invoice_recurring_project_id_foreign` (`project_id`),
  ADD KEY `invoice_recurring_client_id_foreign` (`client_id`),
  ADD KEY `invoice_recurring_user_id_foreign` (`user_id`),
  ADD KEY `invoice_recurring_created_by_foreign` (`created_by`);

--
-- Indexes for table `invoice_recurring_items`
--
ALTER TABLE `invoice_recurring_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_recurring_items_invoice_recurring_id_foreign` (`invoice_recurring_id`);

--
-- Indexes for table `invoice_settings`
--
ALTER TABLE `invoice_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_settings_company_id_foreign` (`company_id`);

--
-- Indexes for table `issues`
--
ALTER TABLE `issues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `issues_user_id_foreign` (`user_id`),
  ADD KEY `issues_project_id_foreign` (`project_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `language_settings`
--
ALTER TABLE `language_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leads_company_id_foreign` (`company_id`),
  ADD KEY `leads_currency_id_foreign` (`currency_id`),
  ADD KEY `leads_category_id_foreign` (`category_id`),
  ADD KEY `leads_agent_id_foreign` (`agent_id`);

--
-- Indexes for table `lead_agents`
--
ALTER TABLE `lead_agents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lead_agents_company_id_foreign` (`company_id`),
  ADD KEY `lead_agents_user_id_foreign` (`user_id`);

--
-- Indexes for table `lead_category`
--
ALTER TABLE `lead_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lead_category_company_id_foreign` (`company_id`);

--
-- Indexes for table `lead_custom_forms`
--
ALTER TABLE `lead_custom_forms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lead_custom_forms_company_id_foreign` (`company_id`);

--
-- Indexes for table `lead_files`
--
ALTER TABLE `lead_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lead_files_lead_id_foreign` (`lead_id`),
  ADD KEY `lead_files_user_id_foreign` (`user_id`),
  ADD KEY `lead_files_company_id_foreign` (`company_id`);

--
-- Indexes for table `lead_follow_up`
--
ALTER TABLE `lead_follow_up`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lead_follow_up_lead_id_foreign` (`lead_id`);

--
-- Indexes for table `lead_sources`
--
ALTER TABLE `lead_sources`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lead_sources_company_id_foreign` (`company_id`);

--
-- Indexes for table `lead_status`
--
ALTER TABLE `lead_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lead_status_company_id_foreign` (`company_id`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leaves_user_id_foreign` (`user_id`),
  ADD KEY `leaves_leave_type_id_foreign` (`leave_type_id`),
  ADD KEY `leaves_company_id_foreign` (`company_id`);

--
-- Indexes for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leave_types_company_id_foreign` (`company_id`);

--
-- Indexes for table `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level_group`
--
ALTER TABLE `level_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level_sport`
--
ALTER TABLE `level_sport`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `licences`
--
ALTER TABLE `licences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `licences_company_id_foreign` (`company_id`),
  ADD KEY `licences_package_id_foreign` (`package_id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_time_for`
--
ALTER TABLE `log_time_for`
  ADD PRIMARY KEY (`id`),
  ADD KEY `log_time_for_company_id_foreign` (`company_id`);

--
-- Indexes for table `ltm_translations`
--
ALTER TABLE `ltm_translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member_category`
--
ALTER TABLE `member_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member_details`
--
ALTER TABLE `member_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `member_details_id_national_id_unique` (`id`,`national_id`);

--
-- Indexes for table `member_relations`
--
ALTER TABLE `member_relations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member_status`
--
ALTER TABLE `member_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message_settings`
--
ALTER TABLE `message_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_settings_company_id_foreign` (`company_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `module_settings`
--
ALTER TABLE `module_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `module_settings_company_id_foreign` (`company_id`);

--
-- Indexes for table `mollie_invoices`
--
ALTER TABLE `mollie_invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mollie_invoices_company_id_foreign` (`company_id`),
  ADD KEY `mollie_invoices_package_id_foreign` (`package_id`);

--
-- Indexes for table `mollie_subscriptions`
--
ALTER TABLE `mollie_subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mollie_subscriptions_company_id_foreign` (`company_id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notes_client_id_foreign` (`client_id`),
  ADD KEY `notes_company_id_foreign` (`company_id`);

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notices_company_id_foreign` (`company_id`),
  ADD KEY `notices_department_id_foreign` (`department_id`);

--
-- Indexes for table `notice_views`
--
ALTER TABLE `notice_views`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notice_views_company_id_foreign` (`company_id`),
  ADD KEY `notice_views_notice_id_foreign` (`notice_id`),
  ADD KEY `notice_views_user_id_foreign` (`user_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`),
  ADD KEY `notifications_company_id_foreign` (`company_id`);

--
-- Indexes for table `offline_invoices`
--
ALTER TABLE `offline_invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `offline_invoices_company_id_foreign` (`company_id`),
  ADD KEY `offline_invoices_package_id_foreign` (`package_id`),
  ADD KEY `offline_invoices_offline_method_id_foreign` (`offline_method_id`);

--
-- Indexes for table `offline_invoice_payments`
--
ALTER TABLE `offline_invoice_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `offline_invoice_payments_invoice_id_foreign` (`invoice_id`),
  ADD KEY `offline_invoice_payments_client_id_foreign` (`client_id`),
  ADD KEY `offline_invoice_payments_payment_method_id_foreign` (`payment_method_id`);

--
-- Indexes for table `offline_payment_methods`
--
ALTER TABLE `offline_payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `offline_payment_methods_company_id_foreign` (`company_id`);

--
-- Indexes for table `offline_plan_changes`
--
ALTER TABLE `offline_plan_changes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `offline_plan_changes_company_id_foreign` (`company_id`),
  ADD KEY `offline_plan_changes_package_id_foreign` (`package_id`),
  ADD KEY `offline_plan_changes_invoice_id_foreign` (`invoice_id`),
  ADD KEY `offline_plan_changes_offline_method_id_foreign` (`offline_method_id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `packages_currency_id_foreign` (`currency_id`);

--
-- Indexes for table `package_settings`
--
ALTER TABLE `package_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `payfast_invoices`
--
ALTER TABLE `payfast_invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payfast_invoices_company_id_foreign` (`company_id`),
  ADD KEY `payfast_invoices_package_id_foreign` (`package_id`);

--
-- Indexes for table `payfast_subscriptions`
--
ALTER TABLE `payfast_subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payfast_subscriptions_company_id_foreign` (`company_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payments_transaction_id_unique` (`transaction_id`),
  ADD UNIQUE KEY `payments_plan_id_unique` (`plan_id`),
  ADD UNIQUE KEY `payments_event_id_unique` (`event_id`),
  ADD KEY `payments_currency_id_foreign` (`currency_id`),
  ADD KEY `payments_project_id_foreign` (`project_id`),
  ADD KEY `payments_invoice_id_foreign` (`invoice_id`),
  ADD KEY `payments_company_id_foreign` (`company_id`),
  ADD KEY `payments_offline_method_id_foreign` (`offline_method_id`);

--
-- Indexes for table `payment_gateway_credentials`
--
ALTER TABLE `payment_gateway_credentials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_gateway_credentials_company_id_foreign` (`company_id`);

--
-- Indexes for table `paypal_invoices`
--
ALTER TABLE `paypal_invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `paypal_invoices_company_id_foreign` (`company_id`),
  ADD KEY `paypal_invoices_currency_id_foreign` (`currency_id`),
  ADD KEY `paypal_invoices_package_id_foreign` (`package_id`);

--
-- Indexes for table `paystack_invoices`
--
ALTER TABLE `paystack_invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `paystack_invoices_company_id_foreign` (`company_id`),
  ADD KEY `paystack_invoices_package_id_foreign` (`package_id`);

--
-- Indexes for table `paystack_subscriptions`
--
ALTER TABLE `paystack_subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `paystack_subscriptions_company_id_foreign` (`company_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`),
  ADD KEY `permissions_module_id_foreign` (`module_id`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `pinned`
--
ALTER TABLE `pinned`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pinned_company_id_foreign` (`company_id`),
  ADD KEY `pinned_project_id_foreign` (`project_id`),
  ADD KEY `pinned_task_id_foreign` (`task_id`),
  ADD KEY `pinned_user_id_foreign` (`user_id`);

--
-- Indexes for table `player_groups`
--
ALTER TABLE `player_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_status_foreign` (`status`),
  ADD KEY `products_company_id_foreign` (`company_id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_inventories`
--
ALTER TABLE `product_inventories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_inventories_product_foreign` (`product`),
  ADD KEY `product_inventories_inventory_foreign` (`inventory`);

--
-- Indexes for table `product_statuses`
--
ALTER TABLE `product_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_sub_category`
--
ALTER TABLE `product_sub_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_sub_category_category_id_foreign` (`category_id`),
  ADD KEY `product_sub_category_sub_category_foreign` (`sub_category`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projects_category_id_foreign` (`category_id`),
  ADD KEY `projects_client_id_foreign` (`client_id`),
  ADD KEY `projects_project_admin_foreign` (`project_admin`),
  ADD KEY `projects_company_id_foreign` (`company_id`),
  ADD KEY `projects_currency_id_foreign` (`currency_id`);

--
-- Indexes for table `project_activity`
--
ALTER TABLE `project_activity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_activity_project_id_foreign` (`project_id`),
  ADD KEY `project_activity_company_id_foreign` (`company_id`);

--
-- Indexes for table `project_category`
--
ALTER TABLE `project_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_category_company_id_foreign` (`company_id`);

--
-- Indexes for table `project_files`
--
ALTER TABLE `project_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_files_user_id_foreign` (`user_id`),
  ADD KEY `project_files_project_id_foreign` (`project_id`),
  ADD KEY `project_files_company_id_foreign` (`company_id`);

--
-- Indexes for table `project_members`
--
ALTER TABLE `project_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_members_project_id_foreign` (`project_id`),
  ADD KEY `project_members_user_id_foreign` (`user_id`),
  ADD KEY `project_members_company_id_foreign` (`company_id`);

--
-- Indexes for table `project_milestones`
--
ALTER TABLE `project_milestones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_milestones_company_id_foreign` (`company_id`),
  ADD KEY `project_milestones_project_id_foreign` (`project_id`),
  ADD KEY `project_milestones_currency_id_foreign` (`currency_id`);

--
-- Indexes for table `project_notes`
--
ALTER TABLE `project_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_notes_company_id_foreign` (`company_id`),
  ADD KEY `project_notes_project_id_foreign` (`project_id`),
  ADD KEY `project_notes_client_id_foreign` (`client_id`);

--
-- Indexes for table `project_ratings`
--
ALTER TABLE `project_ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_ratings_company_id_foreign` (`company_id`),
  ADD KEY `project_ratings_project_id_foreign` (`project_id`),
  ADD KEY `project_ratings_user_id_foreign` (`user_id`);

--
-- Indexes for table `project_settings`
--
ALTER TABLE `project_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_settings_company_id_foreign` (`company_id`);

--
-- Indexes for table `project_templates`
--
ALTER TABLE `project_templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_templates_category_id_foreign` (`category_id`),
  ADD KEY `project_templates_client_id_foreign` (`client_id`),
  ADD KEY `project_templates_company_id_foreign` (`company_id`);

--
-- Indexes for table `project_template_members`
--
ALTER TABLE `project_template_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_template_members_project_template_id_foreign` (`project_template_id`),
  ADD KEY `project_template_members_user_id_foreign` (`user_id`);

--
-- Indexes for table `project_template_sub_tasks`
--
ALTER TABLE `project_template_sub_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_template_sub_tasks_project_template_task_id_foreign` (`project_template_task_id`);

--
-- Indexes for table `project_template_tasks`
--
ALTER TABLE `project_template_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_template_tasks_project_template_id_foreign` (`project_template_id`),
  ADD KEY `project_template_tasks_project_template_task_category_id_foreign` (`project_template_task_category_id`);

--
-- Indexes for table `project_template_task_users`
--
ALTER TABLE `project_template_task_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_template_task_users_project_template_task_id_foreign` (`project_template_task_id`),
  ADD KEY `project_template_task_users_user_id_foreign` (`user_id`);

--
-- Indexes for table `project_time_logs`
--
ALTER TABLE `project_time_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_time_logs_edited_by_user_foreign` (`edited_by_user`),
  ADD KEY `project_time_logs_project_id_foreign` (`project_id`),
  ADD KEY `project_time_logs_user_id_foreign` (`user_id`),
  ADD KEY `project_time_logs_task_id_foreign` (`task_id`),
  ADD KEY `project_time_logs_company_id_foreign` (`company_id`),
  ADD KEY `project_time_logs_approved_by_foreign` (`approved_by`),
  ADD KEY `project_time_logs_invoice_id_foreign` (`invoice_id`);

--
-- Indexes for table `project_user_notes`
--
ALTER TABLE `project_user_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_user_notes_company_id_foreign` (`company_id`),
  ADD KEY `project_user_notes_user_id_foreign` (`user_id`),
  ADD KEY `project_user_notes_project_notes_id_foreign` (`project_notes_id`);

--
-- Indexes for table `proposals`
--
ALTER TABLE `proposals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proposals_lead_id_foreign` (`lead_id`),
  ADD KEY `proposals_currency_id_foreign` (`currency_id`),
  ADD KEY `proposals_company_id_foreign` (`company_id`);

--
-- Indexes for table `proposal_items`
--
ALTER TABLE `proposal_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proposal_items_proposal_id_foreign` (`proposal_id`),
  ADD KEY `proposal_items_tax_id_foreign` (`tax_id`);

--
-- Indexes for table `proposal_signs`
--
ALTER TABLE `proposal_signs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proposal_signs_company_id_foreign` (`company_id`),
  ADD KEY `proposal_signs_proposal_id_foreign` (`proposal_id`);

--
-- Indexes for table `purpose_consent`
--
ALTER TABLE `purpose_consent`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purpose_consent_company_id_foreign` (`company_id`);

--
-- Indexes for table `purpose_consent_leads`
--
ALTER TABLE `purpose_consent_leads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purpose_consent_leads_lead_id_foreign` (`lead_id`),
  ADD KEY `purpose_consent_leads_purpose_consent_id_foreign` (`purpose_consent_id`),
  ADD KEY `purpose_consent_leads_updated_by_id_foreign` (`updated_by_id`);

--
-- Indexes for table `purpose_consent_users`
--
ALTER TABLE `purpose_consent_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purpose_consent_users_client_id_foreign` (`client_id`),
  ADD KEY `purpose_consent_users_purpose_consent_id_foreign` (`purpose_consent_id`),
  ADD KEY `purpose_consent_users_updated_by_id_foreign` (`updated_by_id`);

--
-- Indexes for table `push_notification_settings`
--
ALTER TABLE `push_notification_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `push_subscriptions`
--
ALTER TABLE `push_subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `push_subscriptions_endpoint_unique` (`endpoint`),
  ADD KEY `push_subscriptions_user_id_index` (`user_id`);

--
-- Indexes for table `quotations`
--
ALTER TABLE `quotations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotation_items`
--
ALTER TABLE `quotation_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quotation_items_quotation_id_foreign` (`quotation_id`);

--
-- Indexes for table `razorpay_invoices`
--
ALTER TABLE `razorpay_invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `razorpay_invoices_company_id_foreign` (`company_id`),
  ADD KEY `razorpay_invoices_package_id_foreign` (`package_id`);

--
-- Indexes for table `razorpay_subscriptions`
--
ALTER TABLE `razorpay_subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `removal_requests`
--
ALTER TABLE `removal_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `removal_requests_company_id_foreign` (`company_id`),
  ADD KEY `removal_requests_user_id_foreign` (`user_id`);

--
-- Indexes for table `removal_requests_lead`
--
ALTER TABLE `removal_requests_lead`
  ADD PRIMARY KEY (`id`),
  ADD KEY `removal_requests_lead_company_id_foreign` (`company_id`),
  ADD KEY `removal_requests_lead_lead_id_foreign` (`lead_id`);

--
-- Indexes for table `request_types`
--
ALTER TABLE `request_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `resource_types`
--
ALTER TABLE `resource_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `roles_company_id_foreign` (`company_id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indexes for table `seo_details`
--
ALTER TABLE `seo_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seo_details_language_setting_id_foreign` (`language_setting_id`);

--
-- Indexes for table `sign_up_settings`
--
ALTER TABLE `sign_up_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sign_up_settings_language_setting_id_foreign` (`language_setting_id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `skills_company_id_foreign` (`company_id`);

--
-- Indexes for table `slack_settings`
--
ALTER TABLE `slack_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `slack_settings_company_id_foreign` (`company_id`);

--
-- Indexes for table `smtp_settings`
--
ALTER TABLE `smtp_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `socials`
--
ALTER TABLE `socials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_auth_settings`
--
ALTER TABLE `social_auth_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sport_academies`
--
ALTER TABLE `sport_academies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sport_location`
--
ALTER TABLE `sport_location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sticky_notes`
--
ALTER TABLE `sticky_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sticky_notes_user_id_foreign` (`user_id`);

--
-- Indexes for table `stock_requests`
--
ALTER TABLE `stock_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `approved_by` (`approved_by`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `currency_id` (`currency_id`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `stock_transactions`
--
ALTER TABLE `stock_transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product` (`product`,`date`);

--
-- Indexes for table `storage_settings`
--
ALTER TABLE `storage_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stripe_invoices`
--
ALTER TABLE `stripe_invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stripe_invoices_company_id_foreign` (`company_id`),
  ADD KEY `stripe_invoices_package_id_foreign` (`package_id`);

--
-- Indexes for table `stripe_setting`
--
ALTER TABLE `stripe_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscription_items`
--
ALTER TABLE `subscription_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscription_items_subscription_id_stripe_plan_unique` (`subscription_id`,`stripe_plan`),
  ADD KEY `subscription_items_stripe_id_index` (`stripe_id`);

--
-- Indexes for table `sub_tasks`
--
ALTER TABLE `sub_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_tasks_task_id_foreign` (`task_id`);

--
-- Indexes for table `sub_task_files`
--
ALTER TABLE `sub_task_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_task_files_company_id_foreign` (`company_id`),
  ADD KEY `sub_task_files_user_id_foreign` (`user_id`),
  ADD KEY `sub_task_files_sub_task_id_foreign` (`sub_task_id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `support_tickets_user_id_foreign` (`user_id`),
  ADD KEY `support_tickets_created_by_foreign` (`created_by`),
  ADD KEY `support_tickets_agent_id_foreign` (`agent_id`),
  ADD KEY `support_tickets_support_ticket_type_id_foreign` (`support_ticket_type_id`);

--
-- Indexes for table `support_ticket_files`
--
ALTER TABLE `support_ticket_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `support_ticket_files_user_id_foreign` (`user_id`),
  ADD KEY `support_ticket_files_support_ticket_reply_id_foreign` (`support_ticket_reply_id`);

--
-- Indexes for table `support_ticket_replies`
--
ALTER TABLE `support_ticket_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `support_ticket_replies_support_ticket_id_foreign` (`support_ticket_id`),
  ADD KEY `support_ticket_replies_user_id_foreign` (`user_id`);

--
-- Indexes for table `support_ticket_types`
--
ALTER TABLE `support_ticket_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `support_ticket_types_type_unique` (`type`);

--
-- Indexes for table `taskboard_columns`
--
ALTER TABLE `taskboard_columns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `taskboard_columns_company_id_foreign` (`company_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tasks_project_id_foreign` (`project_id`),
  ADD KEY `tasks_board_column_id_foreign` (`board_column_id`),
  ADD KEY `tasks_company_id_foreign` (`company_id`),
  ADD KEY `tasks_created_by_foreign` (`created_by`),
  ADD KEY `tasks_recurring_task_id_foreign` (`recurring_task_id`),
  ADD KEY `tasks_dependent_task_id_foreign` (`dependent_task_id`),
  ADD KEY `tasks_task_category_id_foreign` (`task_category_id`),
  ADD KEY `tasks_milestone_id_foreign` (`milestone_id`);

--
-- Indexes for table `task_category`
--
ALTER TABLE `task_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_category_company_id_foreign` (`company_id`);

--
-- Indexes for table `task_comments`
--
ALTER TABLE `task_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_comments_user_id_foreign` (`user_id`),
  ADD KEY `task_comments_task_id_foreign` (`task_id`);

--
-- Indexes for table `task_comment_files`
--
ALTER TABLE `task_comment_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_comment_files_company_id_foreign` (`company_id`),
  ADD KEY `task_comment_files_user_id_foreign` (`user_id`),
  ADD KEY `task_comment_files_task_id_foreign` (`task_id`),
  ADD KEY `task_comment_files_comment_id_foreign` (`comment_id`);

--
-- Indexes for table `task_files`
--
ALTER TABLE `task_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_files_company_id_foreign` (`company_id`),
  ADD KEY `task_files_user_id_foreign` (`user_id`),
  ADD KEY `task_files_task_id_foreign` (`task_id`);

--
-- Indexes for table `task_history`
--
ALTER TABLE `task_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_history_task_id_foreign` (`task_id`),
  ADD KEY `task_history_sub_task_id_foreign` (`sub_task_id`),
  ADD KEY `task_history_user_id_foreign` (`user_id`),
  ADD KEY `task_history_board_column_id_foreign` (`board_column_id`);

--
-- Indexes for table `task_labels`
--
ALTER TABLE `task_labels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_tags_task_id_foreign` (`task_id`),
  ADD KEY `task_labels_label_id_foreign` (`label_id`);

--
-- Indexes for table `task_label_list`
--
ALTER TABLE `task_label_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_label_list_company_id_foreign` (`company_id`);

--
-- Indexes for table `task_notes`
--
ALTER TABLE `task_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_notes_company_id_foreign` (`company_id`),
  ADD KEY `task_notes_task_id_foreign` (`task_id`);

--
-- Indexes for table `task_users`
--
ALTER TABLE `task_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_users_task_id_foreign` (`task_id`),
  ADD KEY `task_users_user_id_foreign` (`user_id`);

--
-- Indexes for table `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `taxes_company_id_foreign` (`company_id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teams_company_id_foreign` (`company_id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `testimonials_language_setting_id_foreign` (`language_setting_id`);

--
-- Indexes for table `theme_settings`
--
ALTER TABLE `theme_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `theme_settings_company_id_foreign` (`company_id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tickets_user_id_foreign` (`user_id`),
  ADD KEY `tickets_agent_id_foreign` (`agent_id`),
  ADD KEY `tickets_channel_id_foreign` (`channel_id`),
  ADD KEY `tickets_type_id_foreign` (`type_id`),
  ADD KEY `tickets_company_id_foreign` (`company_id`);

--
-- Indexes for table `ticket_agent_groups`
--
ALTER TABLE `ticket_agent_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_agent_groups_agent_id_foreign` (`agent_id`),
  ADD KEY `ticket_agent_groups_group_id_foreign` (`group_id`),
  ADD KEY `ticket_agent_groups_company_id_foreign` (`company_id`);

--
-- Indexes for table `ticket_channels`
--
ALTER TABLE `ticket_channels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_channels_company_id_foreign` (`company_id`);

--
-- Indexes for table `ticket_custom_forms`
--
ALTER TABLE `ticket_custom_forms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_custom_forms_company_id_foreign` (`company_id`);

--
-- Indexes for table `ticket_files`
--
ALTER TABLE `ticket_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_files_company_id_foreign` (`company_id`),
  ADD KEY `ticket_files_user_id_foreign` (`user_id`),
  ADD KEY `ticket_files_ticket_reply_id_foreign` (`ticket_reply_id`);

--
-- Indexes for table `ticket_groups`
--
ALTER TABLE `ticket_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_groups_company_id_foreign` (`company_id`);

--
-- Indexes for table `ticket_replies`
--
ALTER TABLE `ticket_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_replies_ticket_id_foreign` (`ticket_id`),
  ADD KEY `ticket_replies_user_id_foreign` (`user_id`),
  ADD KEY `ticket_replies_company_id_foreign` (`company_id`);

--
-- Indexes for table `ticket_reply_templates`
--
ALTER TABLE `ticket_reply_templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_reply_templates_company_id_foreign` (`company_id`);

--
-- Indexes for table `ticket_tags`
--
ALTER TABLE `ticket_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_tags_tag_id_foreign` (`tag_id`),
  ADD KEY `ticket_tags_ticket_id_foreign` (`ticket_id`);

--
-- Indexes for table `ticket_tag_list`
--
ALTER TABLE `ticket_tag_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_types`
--
ALTER TABLE `ticket_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_types_company_id_foreign` (`company_id`);

--
-- Indexes for table `tr_front_details`
--
ALTER TABLE `tr_front_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tr_front_details_language_setting_id_foreign` (`language_setting_id`);

--
-- Indexes for table `universal_search`
--
ALTER TABLE `universal_search`
  ADD PRIMARY KEY (`id`),
  ADD KEY `universal_search_company_id_foreign` (`company_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_company_id_foreign` (`company_id`),
  ADD KEY `users_country_id_foreign` (`country_id`);

--
-- Indexes for table `users_chat`
--
ALTER TABLE `users_chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_chat_user_one_foreign` (`user_one`),
  ADD KEY `users_chat_user_id_foreign` (`user_id`),
  ADD KEY `users_chat_from_foreign` (`from`),
  ADD KEY `users_chat_to_foreign` (`to`);

--
-- Indexes for table `users_chat_files`
--
ALTER TABLE `users_chat_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_chat_files_company_id_foreign` (`company_id`),
  ADD KEY `users_chat_files_user_id_foreign` (`user_id`),
  ADD KEY `users_chat_files_users_chat_id_foreign` (`users_chat_id`);

--
-- Indexes for table `user_activities`
--
ALTER TABLE `user_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_activities_user_id_foreign` (`user_id`),
  ADD KEY `user_activities_company_id_foreign` (`company_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accept_estimates`
--
ALTER TABLE `accept_estimates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendance_settings`
--
ALTER TABLE `attendance_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `authorize_invoices`
--
ALTER TABLE `authorize_invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `authorize_subscriptions`
--
ALTER TABLE `authorize_subscriptions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `borrowings`
--
ALTER TABLE `borrowings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `client_categories`
--
ALTER TABLE `client_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client_contacts`
--
ALTER TABLE `client_contacts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client_details`
--
ALTER TABLE `client_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `client_docs`
--
ALTER TABLE `client_docs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client_sub_categories`
--
ALTER TABLE `client_sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client_user_notes`
--
ALTER TABLE `client_user_notes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `contracts`
--
ALTER TABLE `contracts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contract_discussions`
--
ALTER TABLE `contract_discussions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contract_files`
--
ALTER TABLE `contract_files`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contract_renews`
--
ALTER TABLE `contract_renews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contract_signs`
--
ALTER TABLE `contract_signs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contract_types`
--
ALTER TABLE `contract_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conversation`
--
ALTER TABLE `conversation`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conversation_reply`
--
ALTER TABLE `conversation_reply`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=254;

--
-- AUTO_INCREMENT for table `credit_notes`
--
ALTER TABLE `credit_notes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `credit_notes_invoice`
--
ALTER TABLE `credit_notes_invoice`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `credit_note_items`
--
ALTER TABLE `credit_note_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `currency_format_settings`
--
ALTER TABLE `currency_format_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `custom_fields`
--
ALTER TABLE `custom_fields`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `custom_fields_data`
--
ALTER TABLE `custom_fields_data`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `custom_field_groups`
--
ALTER TABLE `custom_field_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `dashboard_widgets`
--
ALTER TABLE `dashboard_widgets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=391;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `discussions`
--
ALTER TABLE `discussions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discussion_categories`
--
ALTER TABLE `discussion_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discussion_files`
--
ALTER TABLE `discussion_files`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discussion_replies`
--
ALTER TABLE `discussion_replies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_notification_settings`
--
ALTER TABLE `email_notification_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `employee_details`
--
ALTER TABLE `employee_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `employee_docs`
--
ALTER TABLE `employee_docs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_faqs`
--
ALTER TABLE `employee_faqs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_faq_categories`
--
ALTER TABLE `employee_faq_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_faq_files`
--
ALTER TABLE `employee_faq_files`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_leave_quotas`
--
ALTER TABLE `employee_leave_quotas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=367;

--
-- AUTO_INCREMENT for table `employee_skills`
--
ALTER TABLE `employee_skills`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_teams`
--
ALTER TABLE `employee_teams`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `estimates`
--
ALTER TABLE `estimates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `estimate_items`
--
ALTER TABLE `estimate_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_attendees`
--
ALTER TABLE `event_attendees`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_categories`
--
ALTER TABLE `event_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_types`
--
ALTER TABLE `event_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses_category`
--
ALTER TABLE `expenses_category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses_category_roles`
--
ALTER TABLE `expenses_category_roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses_recurring`
--
ALTER TABLE `expenses_recurring`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faq_categories`
--
ALTER TABLE `faq_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faq_files`
--
ALTER TABLE `faq_files`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `file_storage`
--
ALTER TABLE `file_storage`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `file_storage_settings`
--
ALTER TABLE `file_storage_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `footer_menu`
--
ALTER TABLE `footer_menu`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `front_clients`
--
ALTER TABLE `front_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `front_details`
--
ALTER TABLE `front_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `front_faqs`
--
ALTER TABLE `front_faqs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `front_features`
--
ALTER TABLE `front_features`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `front_menu_buttons`
--
ALTER TABLE `front_menu_buttons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `front_widgets`
--
ALTER TABLE `front_widgets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gdpr_settings`
--
ALTER TABLE `gdpr_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `global_currencies`
--
ALTER TABLE `global_currencies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `global_settings`
--
ALTER TABLE `global_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventories`
--
ALTER TABLE `inventories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `invoice_recurring`
--
ALTER TABLE `invoice_recurring`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_recurring_items`
--
ALTER TABLE `invoice_recurring_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_settings`
--
ALTER TABLE `invoice_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `issues`
--
ALTER TABLE `issues`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `language_settings`
--
ALTER TABLE `language_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `lead_agents`
--
ALTER TABLE `lead_agents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lead_category`
--
ALTER TABLE `lead_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lead_custom_forms`
--
ALTER TABLE `lead_custom_forms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `lead_files`
--
ALTER TABLE `lead_files`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lead_follow_up`
--
ALTER TABLE `lead_follow_up`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lead_sources`
--
ALTER TABLE `lead_sources`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `lead_status`
--
ALTER TABLE `lead_status`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_types`
--
ALTER TABLE `leave_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `levels`
--
ALTER TABLE `levels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `level_group`
--
ALTER TABLE `level_group`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `level_sport`
--
ALTER TABLE `level_sport`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `licences`
--
ALTER TABLE `licences`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `log_time_for`
--
ALTER TABLE `log_time_for`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ltm_translations`
--
ALTER TABLE `ltm_translations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `member_category`
--
ALTER TABLE `member_category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `member_details`
--
ALTER TABLE `member_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `member_relations`
--
ALTER TABLE `member_relations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `member_status`
--
ALTER TABLE `member_status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `message_settings`
--
ALTER TABLE `message_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=655;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `module_settings`
--
ALTER TABLE `module_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=314;

--
-- AUTO_INCREMENT for table `mollie_invoices`
--
ALTER TABLE `mollie_invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mollie_subscriptions`
--
ALTER TABLE `mollie_subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE `notices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notice_views`
--
ALTER TABLE `notice_views`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offline_invoices`
--
ALTER TABLE `offline_invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offline_invoice_payments`
--
ALTER TABLE `offline_invoice_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offline_payment_methods`
--
ALTER TABLE `offline_payment_methods`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offline_plan_changes`
--
ALTER TABLE `offline_plan_changes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `package_settings`
--
ALTER TABLE `package_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payfast_invoices`
--
ALTER TABLE `payfast_invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payfast_subscriptions`
--
ALTER TABLE `payfast_subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_gateway_credentials`
--
ALTER TABLE `payment_gateway_credentials`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `paypal_invoices`
--
ALTER TABLE `paypal_invoices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paystack_invoices`
--
ALTER TABLE `paystack_invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paystack_subscriptions`
--
ALTER TABLE `paystack_subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `pinned`
--
ALTER TABLE `pinned`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `player_groups`
--
ALTER TABLE `player_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `product_inventories`
--
ALTER TABLE `product_inventories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product_statuses`
--
ALTER TABLE `product_statuses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_sub_category`
--
ALTER TABLE `product_sub_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_activity`
--
ALTER TABLE `project_activity`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_category`
--
ALTER TABLE `project_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_files`
--
ALTER TABLE `project_files`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_members`
--
ALTER TABLE `project_members`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_milestones`
--
ALTER TABLE `project_milestones`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_notes`
--
ALTER TABLE `project_notes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_ratings`
--
ALTER TABLE `project_ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_settings`
--
ALTER TABLE `project_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `project_templates`
--
ALTER TABLE `project_templates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_template_members`
--
ALTER TABLE `project_template_members`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_template_sub_tasks`
--
ALTER TABLE `project_template_sub_tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_template_tasks`
--
ALTER TABLE `project_template_tasks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_template_task_users`
--
ALTER TABLE `project_template_task_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_time_logs`
--
ALTER TABLE `project_time_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_user_notes`
--
ALTER TABLE `project_user_notes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `proposals`
--
ALTER TABLE `proposals`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `proposal_items`
--
ALTER TABLE `proposal_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `proposal_signs`
--
ALTER TABLE `proposal_signs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purpose_consent`
--
ALTER TABLE `purpose_consent`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purpose_consent_leads`
--
ALTER TABLE `purpose_consent_leads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purpose_consent_users`
--
ALTER TABLE `purpose_consent_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `push_notification_settings`
--
ALTER TABLE `push_notification_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `push_subscriptions`
--
ALTER TABLE `push_subscriptions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quotations`
--
ALTER TABLE `quotations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quotation_items`
--
ALTER TABLE `quotation_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `razorpay_invoices`
--
ALTER TABLE `razorpay_invoices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `razorpay_subscriptions`
--
ALTER TABLE `razorpay_subscriptions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `removal_requests`
--
ALTER TABLE `removal_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `removal_requests_lead`
--
ALTER TABLE `removal_requests_lead`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `request_types`
--
ALTER TABLE `request_types`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `resources`
--
ALTER TABLE `resources`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `resource_types`
--
ALTER TABLE `resource_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `seo_details`
--
ALTER TABLE `seo_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sign_up_settings`
--
ALTER TABLE `sign_up_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slack_settings`
--
ALTER TABLE `slack_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `smtp_settings`
--
ALTER TABLE `smtp_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `socials`
--
ALTER TABLE `socials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `social_auth_settings`
--
ALTER TABLE `social_auth_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sport_academies`
--
ALTER TABLE `sport_academies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sport_location`
--
ALTER TABLE `sport_location`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sticky_notes`
--
ALTER TABLE `sticky_notes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_requests`
--
ALTER TABLE `stock_requests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `stock_transactions`
--
ALTER TABLE `stock_transactions`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `storage_settings`
--
ALTER TABLE `storage_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stripe_invoices`
--
ALTER TABLE `stripe_invoices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stripe_setting`
--
ALTER TABLE `stripe_setting`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscription_items`
--
ALTER TABLE `subscription_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_tasks`
--
ALTER TABLE `sub_tasks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_task_files`
--
ALTER TABLE `sub_task_files`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_ticket_files`
--
ALTER TABLE `support_ticket_files`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_ticket_replies`
--
ALTER TABLE `support_ticket_replies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_ticket_types`
--
ALTER TABLE `support_ticket_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `taskboard_columns`
--
ALTER TABLE `taskboard_columns`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_category`
--
ALTER TABLE `task_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_comments`
--
ALTER TABLE `task_comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_comment_files`
--
ALTER TABLE `task_comment_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_files`
--
ALTER TABLE `task_files`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_history`
--
ALTER TABLE `task_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_labels`
--
ALTER TABLE `task_labels`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_label_list`
--
ALTER TABLE `task_label_list`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_notes`
--
ALTER TABLE `task_notes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_users`
--
ALTER TABLE `task_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `theme_settings`
--
ALTER TABLE `theme_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_agent_groups`
--
ALTER TABLE `ticket_agent_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_channels`
--
ALTER TABLE `ticket_channels`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `ticket_custom_forms`
--
ALTER TABLE `ticket_custom_forms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `ticket_files`
--
ALTER TABLE `ticket_files`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_groups`
--
ALTER TABLE `ticket_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `ticket_replies`
--
ALTER TABLE `ticket_replies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_reply_templates`
--
ALTER TABLE `ticket_reply_templates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_tags`
--
ALTER TABLE `ticket_tags`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_tag_list`
--
ALTER TABLE `ticket_tag_list`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_types`
--
ALTER TABLE `ticket_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tr_front_details`
--
ALTER TABLE `tr_front_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `universal_search`
--
ALTER TABLE `universal_search`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- AUTO_INCREMENT for table `users_chat`
--
ALTER TABLE `users_chat`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_chat_files`
--
ALTER TABLE `users_chat_files`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_activities`
--
ALTER TABLE `user_activities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accept_estimates`
--
ALTER TABLE `accept_estimates`
  ADD CONSTRAINT `accept_estimates_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `accept_estimates_estimate_id_foreign` FOREIGN KEY (`estimate_id`) REFERENCES `estimates` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attendances_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `attendance_settings`
--
ALTER TABLE `attendance_settings`
  ADD CONSTRAINT `attendance_settings_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `authorize_invoices`
--
ALTER TABLE `authorize_invoices`
  ADD CONSTRAINT `authorize_invoices_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `authorize_invoices_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `authorize_subscriptions`
--
ALTER TABLE `authorize_subscriptions`
  ADD CONSTRAINT `authorize_subscriptions_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `authorize_subscriptions_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `borrowings`
--
ALTER TABLE `borrowings`
  ADD CONSTRAINT `borrowings_ibfk_1` FOREIGN KEY (`borrower`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `borrowings_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `borrowings_ibfk_3` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `borrowings_ibfk_4` FOREIGN KEY (`resources`) REFERENCES `resources` (`id`);

--
-- Constraints for table `client_categories`
--
ALTER TABLE `client_categories`
  ADD CONSTRAINT `client_categories_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `client_contacts`
--
ALTER TABLE `client_contacts`
  ADD CONSTRAINT `client_contacts_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_contacts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `client_details`
--
ALTER TABLE `client_details`
  ADD CONSTRAINT `client_details_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `client_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `client_details_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_details_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `client_details_sub_category_id_foreign` FOREIGN KEY (`sub_category_id`) REFERENCES `client_sub_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `client_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `client_docs`
--
ALTER TABLE `client_docs`
  ADD CONSTRAINT `client_docs_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_docs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `client_sub_categories`
--
ALTER TABLE `client_sub_categories`
  ADD CONSTRAINT `client_sub_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `client_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_sub_categories_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `client_user_notes`
--
ALTER TABLE `client_user_notes`
  ADD CONSTRAINT `client_user_notes_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_user_notes_note_id_foreign` FOREIGN KEY (`note_id`) REFERENCES `notes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_user_notes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `companies_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `companies_default_task_status_foreign` FOREIGN KEY (`default_task_status`) REFERENCES `taskboard_columns` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `companies_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `organisation_settings_last_updated_by_foreign` FOREIGN KEY (`last_updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `contracts`
--
ALTER TABLE `contracts`
  ADD CONSTRAINT `contracts_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contracts_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contracts_contract_type_id_foreign` FOREIGN KEY (`contract_type_id`) REFERENCES `contract_types` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `contract_discussions`
--
ALTER TABLE `contract_discussions`
  ADD CONSTRAINT `contract_discussions_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contract_discussions_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contract_discussions_from_foreign` FOREIGN KEY (`from`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `contract_files`
--
ALTER TABLE `contract_files`
  ADD CONSTRAINT `contract_files_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contract_files_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contract_files_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `contract_renews`
--
ALTER TABLE `contract_renews`
  ADD CONSTRAINT `contract_renews_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contract_renews_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contract_renews_renewed_by_foreign` FOREIGN KEY (`renewed_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `contract_signs`
--
ALTER TABLE `contract_signs`
  ADD CONSTRAINT `contract_signs_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contract_signs_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `contract_types`
--
ALTER TABLE `contract_types`
  ADD CONSTRAINT `contract_types_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `conversation`
--
ALTER TABLE `conversation`
  ADD CONSTRAINT `conversation_user_one_foreign` FOREIGN KEY (`user_one`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `conversation_user_two_foreign` FOREIGN KEY (`user_two`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `conversation_reply`
--
ALTER TABLE `conversation_reply`
  ADD CONSTRAINT `conversation_reply_conversation_id_foreign` FOREIGN KEY (`conversation_id`) REFERENCES `conversation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `conversation_reply_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `credit_notes`
--
ALTER TABLE `credit_notes`
  ADD CONSTRAINT `credit_notes_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `credit_notes_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `credit_notes_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `credit_notes_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `credit_note_items`
--
ALTER TABLE `credit_note_items`
  ADD CONSTRAINT `credit_note_items_credit_note_id_foreign` FOREIGN KEY (`credit_note_id`) REFERENCES `credit_notes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `currencies`
--
ALTER TABLE `currencies`
  ADD CONSTRAINT `currencies_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `currency_format_settings`
--
ALTER TABLE `currency_format_settings`
  ADD CONSTRAINT `currency_format_settings_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `custom_fields`
--
ALTER TABLE `custom_fields`
  ADD CONSTRAINT `custom_fields_custom_field_group_id_foreign` FOREIGN KEY (`custom_field_group_id`) REFERENCES `custom_field_groups` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `custom_fields_data`
--
ALTER TABLE `custom_fields_data`
  ADD CONSTRAINT `custom_fields_data_custom_field_id_foreign` FOREIGN KEY (`custom_field_id`) REFERENCES `custom_fields` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `custom_field_groups`
--
ALTER TABLE `custom_field_groups`
  ADD CONSTRAINT `custom_field_groups_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dashboard_widgets`
--
ALTER TABLE `dashboard_widgets`
  ADD CONSTRAINT `dashboard_widgets_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `designations`
--
ALTER TABLE `designations`
  ADD CONSTRAINT `designations_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `discussions`
--
ALTER TABLE `discussions`
  ADD CONSTRAINT `discussions_best_answer_id_foreign` FOREIGN KEY (`best_answer_id`) REFERENCES `discussion_replies` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `discussions_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `discussions_discussion_category_id_foreign` FOREIGN KEY (`discussion_category_id`) REFERENCES `discussion_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `discussions_last_reply_by_id_foreign` FOREIGN KEY (`last_reply_by_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `discussions_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `discussions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `discussion_categories`
--
ALTER TABLE `discussion_categories`
  ADD CONSTRAINT `discussion_categories_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `discussion_files`
--
ALTER TABLE `discussion_files`
  ADD CONSTRAINT `discussion_files_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `discussion_files_discussion_id_foreign` FOREIGN KEY (`discussion_id`) REFERENCES `discussions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `discussion_files_discussion_reply_id_foreign` FOREIGN KEY (`discussion_reply_id`) REFERENCES `discussion_replies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `discussion_files_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `discussion_replies`
--
ALTER TABLE `discussion_replies`
  ADD CONSTRAINT `discussion_replies_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `discussion_replies_discussion_id_foreign` FOREIGN KEY (`discussion_id`) REFERENCES `discussions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `discussion_replies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `email_notification_settings`
--
ALTER TABLE `email_notification_settings`
  ADD CONSTRAINT `email_notification_settings_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employee_details`
--
ALTER TABLE `employee_details`
  ADD CONSTRAINT `employee_details_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_details_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `teams` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_details_designation_id_foreign` FOREIGN KEY (`designation_id`) REFERENCES `designations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employee_docs`
--
ALTER TABLE `employee_docs`
  ADD CONSTRAINT `employee_docs_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_docs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employee_faqs`
--
ALTER TABLE `employee_faqs`
  ADD CONSTRAINT `employee_faqs_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_faqs_employee_faq_category_id_foreign` FOREIGN KEY (`employee_faq_category_id`) REFERENCES `employee_faq_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employee_faq_categories`
--
ALTER TABLE `employee_faq_categories`
  ADD CONSTRAINT `employee_faq_categories_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employee_faq_files`
--
ALTER TABLE `employee_faq_files`
  ADD CONSTRAINT `employee_faq_files_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_faq_files_employee_faq_id_foreign` FOREIGN KEY (`employee_faq_id`) REFERENCES `employee_faqs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_faq_files_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employee_leave_quotas`
--
ALTER TABLE `employee_leave_quotas`
  ADD CONSTRAINT `employee_leave_quotas_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_leave_quotas_leave_type_id_foreign` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_leave_quotas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employee_skills`
--
ALTER TABLE `employee_skills`
  ADD CONSTRAINT `employee_skills_skill_id_foreign` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_skills_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employee_teams`
--
ALTER TABLE `employee_teams`
  ADD CONSTRAINT `employee_teams_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_teams_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `estimates`
--
ALTER TABLE `estimates`
  ADD CONSTRAINT `estimates_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `estimates_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `estimates_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `estimate_items`
--
ALTER TABLE `estimate_items`
  ADD CONSTRAINT `estimate_items_estimate_id_foreign` FOREIGN KEY (`estimate_id`) REFERENCES `estimates` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `event_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `events_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `events_event_type_id_foreign` FOREIGN KEY (`event_type_id`) REFERENCES `event_types` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `event_attendees`
--
ALTER TABLE `event_attendees`
  ADD CONSTRAINT `event_attendees_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_attendees_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event_categories`
--
ALTER TABLE `event_categories`
  ADD CONSTRAINT `event_categories_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event_types`
--
ALTER TABLE `event_types`
  ADD CONSTRAINT `event_types_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `expenses_category` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `expenses_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `expenses_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `expenses_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `expenses_expenses_recurring_id_foreign` FOREIGN KEY (`expenses_recurring_id`) REFERENCES `expenses_recurring` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `expenses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `expenses_category`
--
ALTER TABLE `expenses_category`
  ADD CONSTRAINT `expenses_category_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `expenses_category_roles`
--
ALTER TABLE `expenses_category_roles`
  ADD CONSTRAINT `expenses_category_roles_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `expenses_category_roles_expenses_category_id_foreign` FOREIGN KEY (`expenses_category_id`) REFERENCES `expenses_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `expenses_category_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `expenses_recurring`
--
ALTER TABLE `expenses_recurring`
  ADD CONSTRAINT `expenses_recurring_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `expenses_category` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `expenses_recurring_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `expenses_recurring_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `expenses_recurring_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `expenses_recurring_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `expenses_recurring_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `faqs`
--
ALTER TABLE `faqs`
  ADD CONSTRAINT `faqs_faq_category_id_foreign` FOREIGN KEY (`faq_category_id`) REFERENCES `faq_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `faq_files`
--
ALTER TABLE `faq_files`
  ADD CONSTRAINT `faq_files_faq_id_foreign` FOREIGN KEY (`faq_id`) REFERENCES `faqs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `faq_files_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `features`
--
ALTER TABLE `features`
  ADD CONSTRAINT `features_front_feature_id_foreign` FOREIGN KEY (`front_feature_id`) REFERENCES `front_features` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `features_language_setting_id_foreign` FOREIGN KEY (`language_setting_id`) REFERENCES `language_settings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `file_storage`
--
ALTER TABLE `file_storage`
  ADD CONSTRAINT `file_storage_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `file_storage_settings`
--
ALTER TABLE `file_storage_settings`
  ADD CONSTRAINT `file_storage_settings_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `footer_menu`
--
ALTER TABLE `footer_menu`
  ADD CONSTRAINT `footer_menu_language_setting_id_foreign` FOREIGN KEY (`language_setting_id`) REFERENCES `language_settings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `front_clients`
--
ALTER TABLE `front_clients`
  ADD CONSTRAINT `front_clients_language_setting_id_foreign` FOREIGN KEY (`language_setting_id`) REFERENCES `language_settings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `front_faqs`
--
ALTER TABLE `front_faqs`
  ADD CONSTRAINT `front_faqs_language_setting_id_foreign` FOREIGN KEY (`language_setting_id`) REFERENCES `language_settings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `front_features`
--
ALTER TABLE `front_features`
  ADD CONSTRAINT `front_features_language_setting_id_foreign` FOREIGN KEY (`language_setting_id`) REFERENCES `language_settings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `front_menu_buttons`
--
ALTER TABLE `front_menu_buttons`
  ADD CONSTRAINT `front_menu_buttons_language_setting_id_foreign` FOREIGN KEY (`language_setting_id`) REFERENCES `language_settings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `gdpr_settings`
--
ALTER TABLE `gdpr_settings`
  ADD CONSTRAINT `gdpr_settings_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `global_settings`
--
ALTER TABLE `global_settings`
  ADD CONSTRAINT `global_settings_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `global_currencies` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `global_settings_last_updated_by_foreign` FOREIGN KEY (`last_updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `holidays`
--
ALTER TABLE `holidays`
  ADD CONSTRAINT `holidays_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `invoices_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `invoices_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `invoices_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `invoices_estimate_id_foreign` FOREIGN KEY (`estimate_id`) REFERENCES `estimates` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `invoices_invoice_recurring_id_foreign` FOREIGN KEY (`invoice_recurring_id`) REFERENCES `invoice_recurring` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `invoices_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD CONSTRAINT `invoice_items_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `invoice_recurring`
--
ALTER TABLE `invoice_recurring`
  ADD CONSTRAINT `invoice_recurring_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `invoice_recurring_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `invoice_recurring_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `invoice_recurring_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `invoice_recurring_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `invoice_recurring_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `invoice_recurring_items`
--
ALTER TABLE `invoice_recurring_items`
  ADD CONSTRAINT `invoice_recurring_items_invoice_recurring_id_foreign` FOREIGN KEY (`invoice_recurring_id`) REFERENCES `invoice_recurring` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `invoice_settings`
--
ALTER TABLE `invoice_settings`
  ADD CONSTRAINT `invoice_settings_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `issues`
--
ALTER TABLE `issues`
  ADD CONSTRAINT `issues_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `issues_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `leads`
--
ALTER TABLE `leads`
  ADD CONSTRAINT `leads_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `lead_agents` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `leads_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `lead_category` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `leads_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `leads_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `lead_agents`
--
ALTER TABLE `lead_agents`
  ADD CONSTRAINT `lead_agents_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lead_agents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lead_category`
--
ALTER TABLE `lead_category`
  ADD CONSTRAINT `lead_category_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lead_custom_forms`
--
ALTER TABLE `lead_custom_forms`
  ADD CONSTRAINT `lead_custom_forms_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lead_files`
--
ALTER TABLE `lead_files`
  ADD CONSTRAINT `lead_files_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lead_files_lead_id_foreign` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lead_files_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lead_follow_up`
--
ALTER TABLE `lead_follow_up`
  ADD CONSTRAINT `lead_follow_up_lead_id_foreign` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lead_sources`
--
ALTER TABLE `lead_sources`
  ADD CONSTRAINT `lead_sources_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lead_status`
--
ALTER TABLE `lead_status`
  ADD CONSTRAINT `lead_status_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `leaves`
--
ALTER TABLE `leaves`
  ADD CONSTRAINT `leaves_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `leaves_leave_type_id_foreign` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `leaves_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD CONSTRAINT `leave_types_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `licences`
--
ALTER TABLE `licences`
  ADD CONSTRAINT `licences_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `licences_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `log_time_for`
--
ALTER TABLE `log_time_for`
  ADD CONSTRAINT `log_time_for_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `message_settings`
--
ALTER TABLE `message_settings`
  ADD CONSTRAINT `message_settings_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `module_settings`
--
ALTER TABLE `module_settings`
  ADD CONSTRAINT `module_settings_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mollie_invoices`
--
ALTER TABLE `mollie_invoices`
  ADD CONSTRAINT `mollie_invoices_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mollie_invoices_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mollie_subscriptions`
--
ALTER TABLE `mollie_subscriptions`
  ADD CONSTRAINT `mollie_subscriptions_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notes_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notices`
--
ALTER TABLE `notices`
  ADD CONSTRAINT `notices_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notices_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notice_views`
--
ALTER TABLE `notice_views`
  ADD CONSTRAINT `notice_views_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notice_views_notice_id_foreign` FOREIGN KEY (`notice_id`) REFERENCES `notices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notice_views_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `offline_invoices`
--
ALTER TABLE `offline_invoices`
  ADD CONSTRAINT `offline_invoices_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `offline_invoices_offline_method_id_foreign` FOREIGN KEY (`offline_method_id`) REFERENCES `offline_payment_methods` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `offline_invoices_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `offline_invoice_payments`
--
ALTER TABLE `offline_invoice_payments`
  ADD CONSTRAINT `offline_invoice_payments_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `offline_invoice_payments_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `offline_invoice_payments_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `offline_payment_methods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `offline_payment_methods`
--
ALTER TABLE `offline_payment_methods`
  ADD CONSTRAINT `offline_payment_methods_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `offline_plan_changes`
--
ALTER TABLE `offline_plan_changes`
  ADD CONSTRAINT `offline_plan_changes_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `offline_plan_changes_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `offline_invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `offline_plan_changes_offline_method_id_foreign` FOREIGN KEY (`offline_method_id`) REFERENCES `offline_payment_methods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `offline_plan_changes_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `packages`
--
ALTER TABLE `packages`
  ADD CONSTRAINT `packages_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `global_currencies` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `payfast_invoices`
--
ALTER TABLE `payfast_invoices`
  ADD CONSTRAINT `payfast_invoices_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payfast_invoices_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payfast_subscriptions`
--
ALTER TABLE `payfast_subscriptions`
  ADD CONSTRAINT `payfast_subscriptions_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payments_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payments_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payments_offline_method_id_foreign` FOREIGN KEY (`offline_method_id`) REFERENCES `offline_payment_methods` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `payments_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payment_gateway_credentials`
--
ALTER TABLE `payment_gateway_credentials`
  ADD CONSTRAINT `payment_gateway_credentials_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `paypal_invoices`
--
ALTER TABLE `paypal_invoices`
  ADD CONSTRAINT `paypal_invoices_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `paypal_invoices_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `paystack_invoices`
--
ALTER TABLE `paystack_invoices`
  ADD CONSTRAINT `paystack_invoices_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `paystack_invoices_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `paystack_subscriptions`
--
ALTER TABLE `paystack_subscriptions`
  ADD CONSTRAINT `paystack_subscriptions_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pinned`
--
ALTER TABLE `pinned`
  ADD CONSTRAINT `pinned_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pinned_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pinned_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pinned_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `product_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_status_foreign` FOREIGN KEY (`status`) REFERENCES `product_statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_inventories`
--
ALTER TABLE `product_inventories`
  ADD CONSTRAINT `product_inventories_inventory_foreign` FOREIGN KEY (`inventory`) REFERENCES `inventories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_inventories_product_foreign` FOREIGN KEY (`product`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_sub_category`
--
ALTER TABLE `product_sub_category`
  ADD CONSTRAINT `product_sub_category_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `product_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_sub_category_sub_category_foreign` FOREIGN KEY (`sub_category`) REFERENCES `product_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `project_category` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `projects_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `projects_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `projects_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `projects_project_admin_foreign` FOREIGN KEY (`project_admin`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `project_activity`
--
ALTER TABLE `project_activity`
  ADD CONSTRAINT `project_activity_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `project_activity_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `project_category`
--
ALTER TABLE `project_category`
  ADD CONSTRAINT `project_category_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `project_files`
--
ALTER TABLE `project_files`
  ADD CONSTRAINT `project_files_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `project_files_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `project_files_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `project_members`
--
ALTER TABLE `project_members`
  ADD CONSTRAINT `project_members_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `project_members_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `project_members_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `project_milestones`
--
ALTER TABLE `project_milestones`
  ADD CONSTRAINT `project_milestones_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `project_milestones_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `project_milestones_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `project_notes`
--
ALTER TABLE `project_notes`
  ADD CONSTRAINT `project_notes_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `project_notes_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `project_notes_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `project_ratings`
--
ALTER TABLE `project_ratings`
  ADD CONSTRAINT `project_ratings_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `project_ratings_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `project_ratings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `project_settings`
--
ALTER TABLE `project_settings`
  ADD CONSTRAINT `project_settings_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `project_templates`
--
ALTER TABLE `project_templates`
  ADD CONSTRAINT `project_templates_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `project_category` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `project_templates_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `project_templates_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `project_template_members`
--
ALTER TABLE `project_template_members`
  ADD CONSTRAINT `project_template_members_project_template_id_foreign` FOREIGN KEY (`project_template_id`) REFERENCES `project_templates` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `project_template_members_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `project_template_sub_tasks`
--
ALTER TABLE `project_template_sub_tasks`
  ADD CONSTRAINT `project_template_sub_tasks_project_template_task_id_foreign` FOREIGN KEY (`project_template_task_id`) REFERENCES `project_template_tasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `project_template_tasks`
--
ALTER TABLE `project_template_tasks`
  ADD CONSTRAINT `project_template_tasks_project_template_id_foreign` FOREIGN KEY (`project_template_id`) REFERENCES `project_templates` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `project_template_tasks_project_template_task_category_id_foreign` FOREIGN KEY (`project_template_task_category_id`) REFERENCES `task_category` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `project_template_task_users`
--
ALTER TABLE `project_template_task_users`
  ADD CONSTRAINT `project_template_task_users_project_template_task_id_foreign` FOREIGN KEY (`project_template_task_id`) REFERENCES `project_template_tasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `project_template_task_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `project_time_logs`
--
ALTER TABLE `project_time_logs`
  ADD CONSTRAINT `project_time_logs_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `project_time_logs_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `project_time_logs_edited_by_user_foreign` FOREIGN KEY (`edited_by_user`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `project_time_logs_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `project_time_logs_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `project_time_logs_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `project_time_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `project_user_notes`
--
ALTER TABLE `project_user_notes`
  ADD CONSTRAINT `project_user_notes_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `project_user_notes_project_notes_id_foreign` FOREIGN KEY (`project_notes_id`) REFERENCES `project_notes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `project_user_notes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `proposals`
--
ALTER TABLE `proposals`
  ADD CONSTRAINT `proposals_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `proposals_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `proposals_lead_id_foreign` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `proposal_items`
--
ALTER TABLE `proposal_items`
  ADD CONSTRAINT `proposal_items_proposal_id_foreign` FOREIGN KEY (`proposal_id`) REFERENCES `proposals` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `proposal_items_tax_id_foreign` FOREIGN KEY (`tax_id`) REFERENCES `taxes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `proposal_signs`
--
ALTER TABLE `proposal_signs`
  ADD CONSTRAINT `proposal_signs_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `proposal_signs_proposal_id_foreign` FOREIGN KEY (`proposal_id`) REFERENCES `proposals` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purpose_consent`
--
ALTER TABLE `purpose_consent`
  ADD CONSTRAINT `purpose_consent_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purpose_consent_leads`
--
ALTER TABLE `purpose_consent_leads`
  ADD CONSTRAINT `purpose_consent_leads_lead_id_foreign` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purpose_consent_leads_purpose_consent_id_foreign` FOREIGN KEY (`purpose_consent_id`) REFERENCES `purpose_consent` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purpose_consent_leads_updated_by_id_foreign` FOREIGN KEY (`updated_by_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purpose_consent_users`
--
ALTER TABLE `purpose_consent_users`
  ADD CONSTRAINT `purpose_consent_users_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purpose_consent_users_purpose_consent_id_foreign` FOREIGN KEY (`purpose_consent_id`) REFERENCES `purpose_consent` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purpose_consent_users_updated_by_id_foreign` FOREIGN KEY (`updated_by_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `push_subscriptions`
--
ALTER TABLE `push_subscriptions`
  ADD CONSTRAINT `push_subscriptions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quotation_items`
--
ALTER TABLE `quotation_items`
  ADD CONSTRAINT `quotation_items_quotation_id_foreign` FOREIGN KEY (`quotation_id`) REFERENCES `quotations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `razorpay_invoices`
--
ALTER TABLE `razorpay_invoices`
  ADD CONSTRAINT `razorpay_invoices_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `razorpay_invoices_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `removal_requests`
--
ALTER TABLE `removal_requests`
  ADD CONSTRAINT `removal_requests_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `removal_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `removal_requests_lead`
--
ALTER TABLE `removal_requests_lead`
  ADD CONSTRAINT `removal_requests_lead_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `removal_requests_lead_lead_id_foreign` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `resources`
--
ALTER TABLE `resources`
  ADD CONSTRAINT `resources_ibfk_1` FOREIGN KEY (`type`) REFERENCES `resource_types` (`id`);

--
-- Constraints for table `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `roles_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `seo_details`
--
ALTER TABLE `seo_details`
  ADD CONSTRAINT `seo_details_language_setting_id_foreign` FOREIGN KEY (`language_setting_id`) REFERENCES `language_settings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sign_up_settings`
--
ALTER TABLE `sign_up_settings`
  ADD CONSTRAINT `sign_up_settings_language_setting_id_foreign` FOREIGN KEY (`language_setting_id`) REFERENCES `language_settings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `skills`
--
ALTER TABLE `skills`
  ADD CONSTRAINT `skills_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `slack_settings`
--
ALTER TABLE `slack_settings`
  ADD CONSTRAINT `slack_settings_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sticky_notes`
--
ALTER TABLE `sticky_notes`
  ADD CONSTRAINT `sticky_notes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stock_requests`
--
ALTER TABLE `stock_requests`
  ADD CONSTRAINT `stock_requests_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  ADD CONSTRAINT `stock_requests_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  ADD CONSTRAINT `stock_requests_ibfk_3` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `stock_requests_ibfk_4` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `stock_requests_ibfk_5` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  ADD CONSTRAINT `stock_requests_ibfk_6` FOREIGN KEY (`type`) REFERENCES `request_types` (`id`);

--
-- Constraints for table `stock_transactions`
--
ALTER TABLE `stock_transactions`
  ADD CONSTRAINT `stock_transactions_ibfk_1` FOREIGN KEY (`product`) REFERENCES `product_inventories` (`id`);

--
-- Constraints for table `stripe_invoices`
--
ALTER TABLE `stripe_invoices`
  ADD CONSTRAINT `stripe_invoices_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stripe_invoices_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sub_tasks`
--
ALTER TABLE `sub_tasks`
  ADD CONSTRAINT `sub_tasks_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sub_task_files`
--
ALTER TABLE `sub_task_files`
  ADD CONSTRAINT `sub_task_files_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sub_task_files_sub_task_id_foreign` FOREIGN KEY (`sub_task_id`) REFERENCES `sub_tasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sub_task_files_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD CONSTRAINT `support_tickets_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `support_tickets_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `support_tickets_support_ticket_type_id_foreign` FOREIGN KEY (`support_ticket_type_id`) REFERENCES `support_ticket_types` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `support_tickets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `support_ticket_files`
--
ALTER TABLE `support_ticket_files`
  ADD CONSTRAINT `support_ticket_files_support_ticket_reply_id_foreign` FOREIGN KEY (`support_ticket_reply_id`) REFERENCES `support_ticket_replies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `support_ticket_files_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `support_ticket_replies`
--
ALTER TABLE `support_ticket_replies`
  ADD CONSTRAINT `support_ticket_replies_support_ticket_id_foreign` FOREIGN KEY (`support_ticket_id`) REFERENCES `support_tickets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `support_ticket_replies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `taskboard_columns`
--
ALTER TABLE `taskboard_columns`
  ADD CONSTRAINT `taskboard_columns_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_board_column_id_foreign` FOREIGN KEY (`board_column_id`) REFERENCES `taskboard_columns` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tasks_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tasks_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tasks_dependent_task_id_foreign` FOREIGN KEY (`dependent_task_id`) REFERENCES `tasks` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tasks_milestone_id_foreign` FOREIGN KEY (`milestone_id`) REFERENCES `project_milestones` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tasks_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tasks_recurring_task_id_foreign` FOREIGN KEY (`recurring_task_id`) REFERENCES `tasks` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tasks_task_category_id_foreign` FOREIGN KEY (`task_category_id`) REFERENCES `task_category` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `task_category`
--
ALTER TABLE `task_category`
  ADD CONSTRAINT `task_category_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `task_comments`
--
ALTER TABLE `task_comments`
  ADD CONSTRAINT `task_comments_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `task_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `task_comment_files`
--
ALTER TABLE `task_comment_files`
  ADD CONSTRAINT `task_comment_files_comment_id_foreign` FOREIGN KEY (`comment_id`) REFERENCES `task_comments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `task_comment_files_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `task_comment_files_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `task_comment_files_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `task_files`
--
ALTER TABLE `task_files`
  ADD CONSTRAINT `task_files_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `task_files_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `task_files_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `task_history`
--
ALTER TABLE `task_history`
  ADD CONSTRAINT `task_history_board_column_id_foreign` FOREIGN KEY (`board_column_id`) REFERENCES `taskboard_columns` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `task_history_sub_task_id_foreign` FOREIGN KEY (`sub_task_id`) REFERENCES `sub_tasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `task_history_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `task_history_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `task_labels`
--
ALTER TABLE `task_labels`
  ADD CONSTRAINT `task_labels_label_id_foreign` FOREIGN KEY (`label_id`) REFERENCES `task_label_list` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `task_tags_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `task_label_list`
--
ALTER TABLE `task_label_list`
  ADD CONSTRAINT `task_label_list_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `task_notes`
--
ALTER TABLE `task_notes`
  ADD CONSTRAINT `task_notes_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `task_notes_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `task_users`
--
ALTER TABLE `task_users`
  ADD CONSTRAINT `task_users_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `task_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `taxes`
--
ALTER TABLE `taxes`
  ADD CONSTRAINT `taxes_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `teams`
--
ALTER TABLE `teams`
  ADD CONSTRAINT `teams_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD CONSTRAINT `testimonials_language_setting_id_foreign` FOREIGN KEY (`language_setting_id`) REFERENCES `language_settings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `theme_settings`
--
ALTER TABLE `theme_settings`
  ADD CONSTRAINT `theme_settings_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tickets_channel_id_foreign` FOREIGN KEY (`channel_id`) REFERENCES `ticket_channels` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tickets_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tickets_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `ticket_types` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tickets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ticket_agent_groups`
--
ALTER TABLE `ticket_agent_groups`
  ADD CONSTRAINT `ticket_agent_groups_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ticket_agent_groups_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ticket_agent_groups_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `ticket_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ticket_channels`
--
ALTER TABLE `ticket_channels`
  ADD CONSTRAINT `ticket_channels_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ticket_custom_forms`
--
ALTER TABLE `ticket_custom_forms`
  ADD CONSTRAINT `ticket_custom_forms_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ticket_files`
--
ALTER TABLE `ticket_files`
  ADD CONSTRAINT `ticket_files_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ticket_files_ticket_reply_id_foreign` FOREIGN KEY (`ticket_reply_id`) REFERENCES `ticket_replies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ticket_files_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ticket_groups`
--
ALTER TABLE `ticket_groups`
  ADD CONSTRAINT `ticket_groups_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ticket_replies`
--
ALTER TABLE `ticket_replies`
  ADD CONSTRAINT `ticket_replies_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ticket_replies_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ticket_replies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ticket_reply_templates`
--
ALTER TABLE `ticket_reply_templates`
  ADD CONSTRAINT `ticket_reply_templates_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ticket_tags`
--
ALTER TABLE `ticket_tags`
  ADD CONSTRAINT `ticket_tags_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `ticket_tag_list` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ticket_tags_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ticket_types`
--
ALTER TABLE `ticket_types`
  ADD CONSTRAINT `ticket_types_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tr_front_details`
--
ALTER TABLE `tr_front_details`
  ADD CONSTRAINT `tr_front_details_language_setting_id_foreign` FOREIGN KEY (`language_setting_id`) REFERENCES `language_settings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `universal_search`
--
ALTER TABLE `universal_search`
  ADD CONSTRAINT `universal_search_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `users_chat`
--
ALTER TABLE `users_chat`
  ADD CONSTRAINT `users_chat_from_foreign` FOREIGN KEY (`from`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_chat_to_foreign` FOREIGN KEY (`to`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_chat_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_chat_user_one_foreign` FOREIGN KEY (`user_one`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users_chat_files`
--
ALTER TABLE `users_chat_files`
  ADD CONSTRAINT `users_chat_files_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_chat_files_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_chat_files_users_chat_id_foreign` FOREIGN KEY (`users_chat_id`) REFERENCES `users_chat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_activities`
--
ALTER TABLE `user_activities`
  ADD CONSTRAINT `user_activities_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_activities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
