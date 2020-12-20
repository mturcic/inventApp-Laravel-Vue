-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 26, 2020 at 01:46 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `inventar`
--

CREATE TABLE `inventar` (
  `id` int(10) UNSIGNED NOT NULL,
  `generirani_kod` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `naziv_inventara` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slika_inventara` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `datum_nabave` date DEFAULT NULL,
  `godina_nabave` bigint(20) DEFAULT NULL,
  `nabavna_vrijednost` double DEFAULT NULL,
  `stopa_amortizacije` double DEFAULT NULL,
  `kolicina` bigint(20) DEFAULT NULL,
  `jedinica_mjere` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `napomena` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ulazna_faktura` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otpis_inventara` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vrsta_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `tvrtka_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventar`
--

INSERT INTO `inventar` (`id`, `generirani_kod`, `naziv_inventara`, `slika_inventara`, `datum_nabave`, `godina_nabave`, `nabavna_vrijednost`, `stopa_amortizacije`, `kolicina`, `jedinica_mjere`, `napomena`, `ulazna_faktura`, `otpis_inventara`, `vrsta_id`, `user_id`, `tvrtka_id`, `created_at`, `updated_at`) VALUES
(1, '6R20EA888', 'Dell BR23', '1592292362.jpeg', '2020-05-01', 2016, 699.99, 0.2, 4, 'komada', NULL, '19-207.pdf', 'KORISTI SE', 1, NULL, 1, '2020-05-22 10:34:19', '2020-06-16 05:26:02'),
(13, '1K43R2', 'Lenovo Legion Y530', 'Legion_Y530.jpg', '2020-04-17', 2018, 5600, 0.2, 2, 'kom', 'sve', 'faktura_default.pdf', 'OTPISANO', 3, NULL, 1, NULL, '2020-05-26 10:35:57'),
(14, '1KW3CSR2', 'Logitech Y330', 'logitech.png', '2020-05-02', 2019, 89.99, 0.3, 7, 'komada', 's', 'faktura_default.pdf', 'KORISTI SE', 2, NULL, 2, NULL, '2020-05-29 06:13:16'),
(16, 'BK43R2', 'MaxLine', 'max_line.jpg', '2020-05-04', 2020, 69.99, 0.3, 6, 'komada', 'sve', 'faktura_default.pdf', 'KORISTI SE', 3, NULL, 1, NULL, '2020-05-29 06:13:47'),
(26, '1K43R2', 'Dell UH24', 'dell_UH24.png', '2020-05-08', 2020, 166.22, 0.3, 6, 'komada', 'sve', 'faktura_default.pdf', 'KORISTI SE', 2, NULL, 2, NULL, '2020-05-27 10:56:23'),
(36, 'BK43R2', 'Fujitsu', '1591087096.jpg', '2020-06-04', 2020, 89.99, 0.3, 6, 'komada', 'sve', '19-207.pdf', 'KORISTI SE', 2, NULL, 1, NULL, '2020-06-02 06:38:16'),
(41, '1K43R2', 'Hp 4420', '1593170591.png', '2020-06-03', 2020, 422.25, 0.2, 5, 'komada', 'printer', '22.pdf', 'KORISTI SE', 2, NULL, 1, NULL, '2020-06-26 09:23:11'),
(42, '1KW3CSR2', 'd', '1593171208.png', '2020-06-18', 2020, 166, 0.5, 6, 'komada', 'printer', '19-207.pdf', 'OTPISANO', 1, NULL, 1, NULL, '2020-06-26 09:33:28');

-- --------------------------------------------------------

--
-- Table structure for table `kategorija`
--

CREATE TABLE `kategorija` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `naziv_kategorije` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategorija`
--

INSERT INTO `kategorija` (`id`, `naziv_kategorije`, `created_at`, `updated_at`) VALUES
(1, 'Računalna oprema', '2020-05-21 11:24:14', '2020-05-21 11:24:14'),
(2, 'Pisaći strojevi', '2020-05-21 11:24:33', '2020-05-21 11:24:33'),
(3, 'Periferija računala', '2020-05-25 05:18:57', '2020-05-25 05:18:57');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2020_02_09_141615_create_kategorija_table', 1),
(3, '2020_02_09_142838_create_prostor_table', 1),
(4, '2020_02_11_094131_create_prostorija_table', 1),
(5, '2020_03_20_122630_create_vrstas_table', 1),
(6, '2020_03_20_123554_create_tvrtkas_table', 1),
(7, '2020_04_07_101039_create_inventar_table', 1),
(8, '2020_05_20_125020_create_prostorija__inventars_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `prostor`
--

CREATE TABLE `prostor` (
  `id` int(10) UNSIGNED NOT NULL,
  `opis_prostora` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresa_prostora` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prostor`
--

INSERT INTO `prostor` (`id`, `opis_prostora`, `adresa_prostora`, `created_at`, `updated_at`) VALUES
(1, 'Školjić 6', 'Školjić 6', '2020-05-25 05:05:03', '2020-05-25 05:05:03'),
(2, 'Prvi kat', 'Školjić 6', '2020-05-25 05:05:24', '2020-05-25 05:05:24'),
(3, 'Prizemlje - Laboratorij', 'Školjić 6', '2020-05-25 05:05:40', '2020-05-25 05:05:49');

-- --------------------------------------------------------

--
-- Table structure for table `prostorija`
--

CREATE TABLE `prostorija` (
  `id` int(10) UNSIGNED NOT NULL,
  `naziv_prostorije` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prostor_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prostorija`
--

INSERT INTO `prostorija` (`id`, `naziv_prostorije`, `prostor_id`, `created_at`, `updated_at`) VALUES
(4, 'Mars', 1, '2020-05-25 05:53:14', '2020-05-25 05:53:14'),
(5, 'Jupiter', 1, '2020-05-25 05:53:41', '2020-05-25 05:53:41'),
(6, 'Saturn', 3, '2020-05-25 05:54:04', '2020-05-25 05:54:04'),
(7, 'Uran', 3, '2020-05-25 05:54:19', '2020-05-25 06:18:50'),
(8, 'Venera', 2, '2020-05-25 06:18:15', '2020-05-25 06:18:15'),
(9, 'Neptun', 2, '2020-05-25 06:19:06', '2020-05-25 06:19:06');

-- --------------------------------------------------------

--
-- Table structure for table `prostorija__inventar`
--

CREATE TABLE `prostorija__inventar` (
  `prostorija_id` int(10) UNSIGNED NOT NULL,
  `inventar_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prostorija__inventar`
--

INSERT INTO `prostorija__inventar` (`prostorija_id`, `inventar_id`, `created_at`, `updated_at`) VALUES
(4, 13, '2020-05-26 10:24:31', '2020-05-26 10:24:31'),
(4, 42, '2020-06-26 09:33:28', '2020-06-26 09:33:28'),
(5, 16, '2020-05-26 10:49:33', '2020-05-26 10:49:33'),
(6, 13, '2020-05-26 10:24:31', '2020-05-26 10:24:31'),
(6, 26, '2020-05-27 10:14:04', '2020-05-27 10:14:04'),
(6, 41, '2020-06-26 09:23:11', '2020-06-26 09:23:11'),
(6, 42, '2020-06-26 09:33:28', '2020-06-26 09:33:28'),
(7, 14, '2020-05-26 10:38:15', '2020-05-26 10:38:15'),
(7, 26, '2020-05-27 10:14:04', '2020-05-27 10:14:04'),
(7, 36, '2020-06-02 06:38:16', '2020-06-02 06:38:16'),
(7, 41, '2020-06-26 09:23:11', '2020-06-26 09:23:11'),
(8, 14, '2020-05-26 10:38:15', '2020-05-26 10:38:15'),
(8, 26, '2020-05-27 10:14:04', '2020-05-27 10:14:04'),
(8, 36, '2020-06-02 06:38:16', '2020-06-02 06:38:16'),
(9, 1, NULL, NULL),
(9, 13, '2020-05-26 10:24:31', '2020-05-26 10:24:31'),
(9, 42, '2020-06-26 09:33:28', '2020-06-26 09:33:28');

-- --------------------------------------------------------

--
-- Table structure for table `tvrtka`
--

CREATE TABLE `tvrtka` (
  `id` int(10) UNSIGNED NOT NULL,
  `naziv_tvrtke` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tvrtka`
--

INSERT INTO `tvrtka` (`id`, `naziv_tvrtke`, `created_at`, `updated_at`) VALUES
(1, 'Centar Tehničke Kulture', '2020-05-25 06:19:31', '2020-05-25 06:19:31'),
(2, 'Hrvatski Savez Brodomaketara', '2020-05-25 06:20:07', '2020-05-25 06:20:07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `lastname`, `username`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(35, 'Marin', 'Turčić', 'mturcic', 'mturcic@veleri.hr', '$2y$10$KrxhTJ4WVNu8faOCL9EGeOxNytwxfIqTyjsRZnv7m9zisZFoCajVi', '51dNDpw1Xm797E5eVhGIiSQew1cgmPTK8hqVJwODFdU9xvoZZyc2NYCHBDxW', '2020-06-16 10:07:59', '2020-06-16 10:07:59'),
(39, 'Student', '2', 's2', 'student@veleri.hr', '$2y$10$GFhjuLLmIve9oQRdwVNl0e8hX8lGp8Ti2BBR3RSbnUN8fYmG8TTIm', 'MbHDojjEW8VKF2y0dF5mbqrMsiITKFZo5xjTgiayDEL4aiKlx4DWSnMRg3ld', '2020-06-25 20:20:56', '2020-06-25 20:20:56');

-- --------------------------------------------------------

--
-- Table structure for table `vrsta`
--

CREATE TABLE `vrsta` (
  `id` int(10) UNSIGNED NOT NULL,
  `naziv_vrste` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategorija_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vrsta`
--

INSERT INTO `vrsta` (`id`, `naziv_vrste`, `kategorija_id`, `created_at`, `updated_at`) VALUES
(1, 'Monitor', 1, '2020-05-21 11:29:15', '2020-05-25 06:21:32'),
(2, 'Miš', 3, '2020-05-25 06:21:51', '2020-05-25 06:22:11'),
(3, 'Tipkovnica', 3, '2020-05-25 06:22:01', '2020-05-25 06:36:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventar`
--
ALTER TABLE `inventar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventar_vrsta_id_index` (`vrsta_id`),
  ADD KEY `inventar_user_id_index` (`user_id`),
  ADD KEY `inventar_tvrtka_id_index` (`tvrtka_id`);

--
-- Indexes for table `kategorija`
--
ALTER TABLE `kategorija`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prostor`
--
ALTER TABLE `prostor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prostorija`
--
ALTER TABLE `prostorija`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prostorija_prostor_id_index` (`prostor_id`);

--
-- Indexes for table `prostorija__inventar`
--
ALTER TABLE `prostorija__inventar`
  ADD PRIMARY KEY (`prostorija_id`,`inventar_id`),
  ADD KEY `prostorija__inventar_prostorija_id_index` (`prostorija_id`),
  ADD KEY `prostorija__inventar_inventar_id_index` (`inventar_id`);

--
-- Indexes for table `tvrtka`
--
ALTER TABLE `tvrtka`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- Indexes for table `vrsta`
--
ALTER TABLE `vrsta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vrsta_kategorija_id_index` (`kategorija_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inventar`
--
ALTER TABLE `inventar`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `kategorija`
--
ALTER TABLE `kategorija`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `prostor`
--
ALTER TABLE `prostor`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `prostorija`
--
ALTER TABLE `prostorija`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tvrtka`
--
ALTER TABLE `tvrtka`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `vrsta`
--
ALTER TABLE `vrsta`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inventar`
--
ALTER TABLE `inventar`
  ADD CONSTRAINT `inventar_tvrtka_id_foreign` FOREIGN KEY (`tvrtka_id`) REFERENCES `tvrtka` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventar_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventar_vrsta_id_foreign` FOREIGN KEY (`vrsta_id`) REFERENCES `vrsta` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `prostorija`
--
ALTER TABLE `prostorija`
  ADD CONSTRAINT `prostorija_prostor_id_foreign` FOREIGN KEY (`prostor_id`) REFERENCES `prostor` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `prostorija__inventar`
--
ALTER TABLE `prostorija__inventar`
  ADD CONSTRAINT `prostorija__inventar_inventar_id_foreign` FOREIGN KEY (`inventar_id`) REFERENCES `inventar` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `prostorija__inventar_prostorija_id_foreign` FOREIGN KEY (`prostorija_id`) REFERENCES `prostorija` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vrsta`
--
ALTER TABLE `vrsta`
  ADD CONSTRAINT `vrsta_kategorija_id_foreign` FOREIGN KEY (`kategorija_id`) REFERENCES `kategorija` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
