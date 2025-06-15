-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2025 at 06:50 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fintory_db`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `FormatSaleID` (`sale_id` INT) RETURNS VARCHAR(15) CHARSET utf8mb4 COLLATE utf8mb4_general_ci DETERMINISTIC BEGIN
                RETURN CONCAT("TRX-", LPAD(sale_id, 5, "0"));
            END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `kode_barang` int(10) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`kode_barang`, `nama`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'Royal Canin Shampoo Anti Kutu', 'Deskripsi untuk Royal Canin Shampoo Anti Kutu', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(2, 'Pro Plan Shampoo Anti Kutu', 'Deskripsi untuk Pro Plan Shampoo Anti Kutu', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(3, 'Equilibrio Shampoo Anti Kutu', 'Deskripsi untuk Equilibrio Shampoo Anti Kutu', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(4, 'Me-O Bola Kerincing', 'Deskripsi untuk Me-O Bola Kerincing', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(5, 'Cat Choize Adult Tuna 1.2kg', 'Deskripsi untuk Cat Choize Adult Tuna 1.2kg', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(6, 'Pro Plan Indoor Cat Formula', 'Deskripsi untuk Pro Plan Indoor Cat Formula', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(7, 'Cat Choize Indoor Cat Formula', 'Deskripsi untuk Cat Choize Indoor Cat Formula', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(8, 'Cat Choize Mini Adult 2kg', 'Deskripsi untuk Cat Choize Mini Adult 2kg', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(9, 'Cat Choize Sisir Bulu Halus', 'Deskripsi untuk Cat Choize Sisir Bulu Halus', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(10, 'Equilibrio Persian Adult', 'Deskripsi untuk Equilibrio Persian Adult', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(11, 'Cat Choize Mini Adult 2kg', 'Deskripsi untuk Cat Choize Mini Adult 2kg', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(12, 'Pro Plan Persian Adult', 'Deskripsi untuk Pro Plan Persian Adult', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(13, 'Happy Dog Kitten Pouch 85g', 'Deskripsi untuk Happy Dog Kitten Pouch 85g', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(14, 'Royal Canin Adult Tuna 1.2kg', 'Deskripsi untuk Royal Canin Adult Tuna 1.2kg', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(15, 'Bolt Adult Tuna 1.2kg', 'Deskripsi untuk Bolt Adult Tuna 1.2kg', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(16, 'Equilibrio Bola Kerincing', 'Deskripsi untuk Equilibrio Bola Kerincing', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(17, 'Pro Plan Dental Care Stick', 'Deskripsi untuk Pro Plan Dental Care Stick', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(18, 'Cat Choize Shampoo Anti Kutu', 'Deskripsi untuk Cat Choize Shampoo Anti Kutu', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(19, 'Whiskas Dental Care Stick', 'Deskripsi untuk Whiskas Dental Care Stick', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(20, 'Bolt Dental Care Stick', 'Deskripsi untuk Bolt Dental Care Stick', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(21, 'Friskies Sisir Bulu Halus', 'Deskripsi untuk Friskies Sisir Bulu Halus', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(22, 'Equilibrio Indoor Cat Formula', 'Deskripsi untuk Equilibrio Indoor Cat Formula', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(23, 'Friskies Kalung Anti Kutu', 'Deskripsi untuk Friskies Kalung Anti Kutu', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(24, 'Equilibrio Kalung Anti Kutu', 'Deskripsi untuk Equilibrio Kalung Anti Kutu', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(25, 'Cat Choize Dental Care Stick', 'Deskripsi untuk Cat Choize Dental Care Stick', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(26, 'Happy Dog Mini Adult 2kg', 'Deskripsi untuk Happy Dog Mini Adult 2kg', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(27, 'Royal Canin Dental Care Stick', 'Deskripsi untuk Royal Canin Dental Care Stick', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(28, 'Pedigree Bola Kerincing', 'Deskripsi untuk Pedigree Bola Kerincing', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(29, 'Friskies Dental Care Stick', 'Deskripsi untuk Friskies Dental Care Stick', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(30, 'Bolt Indoor Cat Formula', 'Deskripsi untuk Bolt Indoor Cat Formula', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(31, 'Bolt Persian Adult', 'Deskripsi untuk Bolt Persian Adult', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(32, 'Bolt Mini Adult 2kg', 'Deskripsi untuk Bolt Mini Adult 2kg', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(33, 'Me-O Adult Tuna 1.2kg', 'Deskripsi untuk Me-O Adult Tuna 1.2kg', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(34, 'Cat Choize Bola Kerincing', 'Deskripsi untuk Cat Choize Bola Kerincing', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(35, 'Happy Dog Persian Adult', 'Deskripsi untuk Happy Dog Persian Adult', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(36, 'Happy Dog Mini Adult 2kg', 'Deskripsi untuk Happy Dog Mini Adult 2kg', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(37, 'Equilibrio Adult Tuna 1.2kg', 'Deskripsi untuk Equilibrio Adult Tuna 1.2kg', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(38, 'Cat Choize Mini Adult 2kg', 'Deskripsi untuk Cat Choize Mini Adult 2kg', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(39, 'Me-O Sisir Bulu Halus', 'Deskripsi untuk Me-O Sisir Bulu Halus', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(40, 'Happy Dog Dental Care Stick', 'Deskripsi untuk Happy Dog Dental Care Stick', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(41, 'Bolt Kalung Anti Kutu', 'Deskripsi untuk Bolt Kalung Anti Kutu', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(42, 'Happy Dog Bola Kerincing', 'Deskripsi untuk Happy Dog Bola Kerincing', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(43, 'Whiskas Shampoo Anti Kutu', 'Deskripsi untuk Whiskas Shampoo Anti Kutu', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(44, 'Friskies Dental Care Stick', 'Deskripsi untuk Friskies Dental Care Stick', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(45, 'Bolt Adult Tuna 1.2kg', 'Deskripsi untuk Bolt Adult Tuna 1.2kg', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(46, 'Friskies Mini Adult 2kg', 'Deskripsi untuk Friskies Mini Adult 2kg', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(47, 'Equilibrio Kalung Anti Kutu', 'Deskripsi untuk Equilibrio Kalung Anti Kutu', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(48, 'Pro Plan Indoor Cat Formula', 'Deskripsi untuk Pro Plan Indoor Cat Formula', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(49, 'Me-O Adult Tuna 1.2kg', 'Deskripsi untuk Me-O Adult Tuna 1.2kg', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(50, 'Friskies Indoor Cat Formula', 'Deskripsi untuk Friskies Indoor Cat Formula', '2025-06-15 09:49:32', '2025-06-15 09:49:32');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cashledger`
--

CREATE TABLE `cashledger` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `outlet_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL DEFAULT curdate(),
  `tipe` enum('INCOME','EXPENSE','TRANSFER_IN','TRANSFER_OUT') NOT NULL,
  `sumber` varchar(100) DEFAULT NULL,
  `referensi_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `amount` decimal(14,2) NOT NULL,
  `saldo_setelah` decimal(14,2) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cashledger`
--

INSERT INTO `cashledger` (`id`, `outlet_id`, `tanggal`, `tipe`, `sumber`, `referensi_id`, `deskripsi`, `amount`, `saldo_setelah`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, '2000-10-20', 'TRANSFER_OUT', 'sint', NULL, 'Nihil unde tenetur non quis.', 16616.91, 774147.99, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(2, 1, '1999-07-14', 'EXPENSE', 'ut', NULL, 'Et dolor et alias commodi.', 99139.92, 825325.51, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(3, 1, '1984-02-15', 'TRANSFER_IN', 'nobis', NULL, 'Saepe consequatur in est autem illo.', 55489.72, 83032.70, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(4, 2, '1973-02-11', 'INCOME', 'enim', NULL, 'Et sapiente mollitia et illo.', 93276.09, 810058.40, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(5, 2, '2022-11-15', 'TRANSFER_IN', 'enim', NULL, 'Ut dolores expedita ut consequatur et rerum est ut.', 49740.07, 100016.54, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(6, 2, '1990-05-21', 'INCOME', 'distinctio', NULL, 'Consequatur sunt quia fugit quo unde et saepe.', 24227.44, 390816.05, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(7, 3, '2022-10-03', 'INCOME', 'ipsam', NULL, 'Voluptas a quo laboriosam quos mollitia.', 98683.55, 900735.17, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(8, 3, '2012-10-11', 'TRANSFER_IN', 'quo', NULL, 'Exercitationem non delectus laboriosam maiores qui.', 6858.30, 293738.16, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(9, 3, '2003-11-28', 'EXPENSE', 'voluptatem', NULL, 'Mollitia nesciunt qui explicabo et enim itaque.', 38980.68, 741574.84, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(10, 4, '2007-12-26', 'TRANSFER_IN', 'impedit', NULL, 'Odio quaerat quo sequi maiores et sunt.', 95888.06, 372934.49, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(11, 4, '1984-11-10', 'INCOME', 'officiis', NULL, 'Enim repudiandae sit iure veritatis iusto distinctio tempora.', 64615.66, 545375.37, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(12, 4, '2024-03-03', 'EXPENSE', 'rem', NULL, 'Cum iste similique harum veniam nesciunt.', 15035.47, 631197.07, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(13, 5, '1973-01-12', 'TRANSFER_IN', 'dolor', NULL, 'Sed voluptas voluptates nisi corporis.', 74893.80, 83275.21, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(14, 5, '2023-03-09', 'TRANSFER_IN', 'voluptates', NULL, 'Et doloremque et omnis quia.', 30288.98, 278591.57, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(15, 5, '2024-12-18', 'EXPENSE', 'error', NULL, 'Corporis sit aspernatur aut natus quasi quis.', 19429.06, 484094.00, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(16, 6, '1983-11-18', 'INCOME', 'illum', NULL, 'Minima quas tempore quod sed ex delectus similique.', 5744.39, 346211.78, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(17, 6, '2005-02-07', 'TRANSFER_IN', 'rem', NULL, 'Adipisci nihil quia cum enim ab.', 36930.77, 828745.04, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(18, 6, '2016-10-21', 'TRANSFER_IN', 'ad', NULL, 'Molestias consequatur illo cumque adipisci voluptate error dolor.', 45847.66, 301748.21, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(19, 7, '1982-10-01', 'TRANSFER_OUT', 'est', NULL, 'Et saepe consequatur quaerat nostrum distinctio qui.', 65381.77, 545237.34, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(20, 7, '2014-12-01', 'TRANSFER_IN', 'eius', NULL, 'Sint at non voluptatem nemo non.', 50700.96, 786781.84, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(21, 7, '2013-09-29', 'EXPENSE', 'voluptas', NULL, 'Ut assumenda cum saepe tempora quia.', 36414.36, 564499.58, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(22, 8, '1984-07-31', 'TRANSFER_OUT', 'illum', NULL, 'Tempore dolorem fuga unde dolorem quos qui.', 91781.36, 237279.10, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(23, 8, '1981-09-14', 'TRANSFER_IN', 'et', NULL, 'Error quam perferendis ad facere eos.', 94113.22, 324076.73, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(24, 8, '2018-01-28', 'INCOME', 'aut', NULL, 'Aliquam necessitatibus eveniet quis repellendus.', 13274.31, 118201.08, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(25, 9, '2014-11-24', 'INCOME', 'itaque', NULL, 'Quidem sit error et explicabo ipsum.', 77093.99, 40572.83, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(26, 9, '1985-10-30', 'TRANSFER_IN', 'nihil', NULL, 'Eum unde nostrum rerum deleniti.', 26873.41, 509992.52, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(27, 9, '2018-07-30', 'TRANSFER_OUT', 'est', NULL, 'Sunt voluptatem accusantium consectetur ratione molestiae inventore quia.', 22346.79, 858155.06, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(28, 10, '1973-02-06', 'EXPENSE', 'debitis', NULL, 'Eligendi iusto dolores quia non.', 63421.53, 551787.99, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(29, 10, '2013-10-28', 'TRANSFER_IN', 'et', NULL, 'Est harum sunt maxime aut sunt.', 68386.84, 380993.68, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(30, 10, '2022-09-28', 'TRANSFER_OUT', 'ab', NULL, 'Magni adipisci eos est esse laborum sed facere.', 94653.73, 554885.85, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(31, 11, '2009-06-17', 'TRANSFER_OUT', 'esse', NULL, 'Quasi quis sint est iusto et.', 60292.86, 606881.25, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(32, 11, '1978-04-17', 'EXPENSE', 'distinctio', NULL, 'Quo voluptatibus soluta illo iusto consequatur explicabo eum error.', 42021.58, 938605.35, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(33, 11, '2010-04-26', 'TRANSFER_IN', 'qui', NULL, 'Possimus facere aut qui non culpa.', 80045.85, 487703.38, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(34, 12, '1995-05-05', 'TRANSFER_OUT', 'non', NULL, 'Nostrum aut voluptas sed magnam facilis.', 35899.69, 189681.31, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(35, 12, '2008-04-16', 'TRANSFER_IN', 'et', NULL, 'Aspernatur dolorem unde provident quod sint.', 21760.48, 292867.12, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(36, 12, '1974-12-28', 'TRANSFER_IN', 'natus', NULL, 'Aliquam quae a fugit ullam possimus et rerum.', 41408.76, 222807.80, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(37, 13, '2014-01-12', 'INCOME', 'tenetur', NULL, 'Aut veniam rerum praesentium animi illo sint libero architecto.', 85167.79, 875940.15, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(38, 13, '1986-02-02', 'TRANSFER_OUT', 'maxime', NULL, 'Aliquid laborum eveniet nihil qui voluptas.', 33200.40, 868523.86, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(39, 13, '2001-07-04', 'INCOME', 'quas', NULL, 'Suscipit esse ut officiis assumenda.', 24897.92, 391391.35, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(40, 14, '1973-10-12', 'INCOME', 'doloribus', NULL, 'Tempore repellat aspernatur quisquam commodi autem.', 86985.68, 228171.94, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(41, 14, '1975-07-14', 'TRANSFER_OUT', 'sunt', NULL, 'Nihil ut dolores eum rerum.', 63127.30, 31493.97, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(42, 14, '2022-08-03', 'INCOME', 'voluptas', NULL, 'Quidem quis aut sit architecto quod et iure ducimus.', 32231.46, 640064.62, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(43, 15, '1995-09-14', 'TRANSFER_OUT', 'rerum', NULL, 'Eius quia perspiciatis ut minus possimus eos.', 35415.25, 34264.85, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(44, 15, '2000-11-25', 'EXPENSE', 'voluptatem', NULL, 'Quas eaque commodi quia voluptatem quae.', 74503.60, 669867.52, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(45, 15, '1994-11-27', 'TRANSFER_OUT', 'aut', NULL, 'Incidunt expedita exercitationem labore et commodi ipsum amet.', 40108.43, 893753.84, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(46, 16, '2003-06-29', 'INCOME', 'aut', NULL, 'Officiis nihil facere et.', 32977.20, 950449.96, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(47, 16, '2022-03-13', 'TRANSFER_OUT', 'non', NULL, 'At facere velit doloribus id aut nobis sequi.', 46072.24, 443378.41, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(48, 16, '1970-11-13', 'TRANSFER_IN', 'ut', NULL, 'Enim ullam quaerat quia cupiditate magnam quasi dolore.', 20638.77, 828955.61, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(49, 17, '2019-08-11', 'TRANSFER_OUT', 'delectus', NULL, 'Explicabo porro sequi in.', 50582.60, 423488.50, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(50, 17, '2021-11-10', 'INCOME', 'laudantium', NULL, 'Delectus quo veniam architecto voluptatibus corporis est quae.', 16520.54, 909447.18, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(51, 17, '2008-07-09', 'TRANSFER_OUT', 'incidunt', NULL, 'Quod rem optio id sunt culpa eum vitae.', 64669.06, 196177.43, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(52, 18, '1972-04-15', 'EXPENSE', 'voluptatem', NULL, 'Ut nam a voluptas.', 56861.58, 112275.91, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(53, 18, '1989-06-17', 'TRANSFER_OUT', 'recusandae', NULL, 'Et quis ad voluptatibus.', 1417.79, 344723.59, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(54, 18, '2014-12-29', 'EXPENSE', 'nulla', NULL, 'Ut molestias ut suscipit asperiores commodi enim.', 87322.65, 180169.59, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(55, 19, '1984-07-20', 'TRANSFER_OUT', 'distinctio', NULL, 'Sed eos et ea eveniet amet itaque.', 1001.71, 747268.00, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(56, 19, '2014-04-02', 'TRANSFER_IN', 'possimus', NULL, 'Qui officia reprehenderit et aperiam.', 22358.84, 477582.41, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(57, 19, '2002-06-17', 'INCOME', 'nihil', NULL, 'Commodi aperiam consequuntur ab aut.', 44133.48, 355634.80, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(58, 20, '1985-07-23', 'INCOME', 'aliquam', NULL, 'Corrupti a doloribus deserunt.', 45112.46, 439092.18, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(59, 20, '1994-09-09', 'TRANSFER_OUT', 'vel', NULL, 'Eum quaerat minima et aut consectetur.', 12054.99, 761823.48, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(60, 20, '2018-11-04', 'EXPENSE', 'consequuntur', NULL, 'Aut corporis aut quo voluptas deserunt culpa architecto.', 75611.28, 781310.70, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39');

-- --------------------------------------------------------

--
-- Table structure for table `cicilan`
--

CREATE TABLE `cicilan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hutang_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `jumlah_bayar` decimal(14,2) NOT NULL,
  `metode_pembayaran` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cicilan`
--

INSERT INTO `cicilan` (`id`, `hutang_id`, `tanggal_bayar`, `jumlah_bayar`, `metode_pembayaran`, `deskripsi`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, '1972-03-27', 106311.03, 'Cash', 'Autem dolorem veritatis voluptate harum occaecati libero deserunt.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(2, 1, '1991-10-22', 414065.14, 'Transfer', 'Id est ipsam quia cupiditate molestiae accusantium consequatur.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(3, 2, '2009-01-13', 223204.60, 'QRIS', 'Non facilis nisi consequatur.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(4, 2, '1977-07-18', 157777.72, 'QRIS', 'Ea ipsa dolorem et qui.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(5, 3, '2016-10-29', 183255.05, 'QRIS', 'Quaerat quo dicta ut aut.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(6, 3, '2021-06-30', 301237.33, 'Transfer', 'Error sed rerum magnam cum.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(7, 4, '1970-09-09', 433503.80, 'QRIS', 'Voluptas harum quisquam nihil nemo dicta minima hic.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(8, 4, '1971-02-23', 301506.13, 'Transfer', 'Et officiis rem tenetur natus consequatur est aspernatur.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(9, 5, '2003-11-21', 231051.12, 'Cash', 'Possimus et quam veniam nihil.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(10, 5, '1992-08-07', 151878.19, 'Cash', 'Quae blanditiis aspernatur mollitia sit.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(11, 6, '1979-02-26', 448636.18, 'Cash', 'Et accusantium aliquam sed rerum sequi eum.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(12, 6, '1994-10-28', 157429.95, 'Cash', 'Ipsum magnam fugiat illo quam facere dolores ut.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(13, 7, '2007-12-08', 124672.80, 'QRIS', 'Qui excepturi sint error magni quam at velit sit.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(14, 7, '1996-10-14', 112492.26, 'Transfer', 'Exercitationem laudantium sunt odio.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(15, 8, '1982-07-22', 89786.59, 'Cash', 'Deserunt quasi perferendis quia.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(16, 8, '1984-04-29', 203239.61, 'QRIS', 'Consequuntur consequuntur molestiae fuga ut qui.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(17, 9, '2022-07-05', 323246.17, 'QRIS', 'Placeat omnis quidem culpa impedit laboriosam voluptates omnis.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(18, 9, '1974-03-17', 205845.67, 'Transfer', 'Facere est dolor aperiam minima nihil.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(19, 10, '2019-07-12', 256398.57, 'Cash', 'Iusto at eos qui ducimus a laboriosam.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(20, 10, '1987-07-13', 105748.12, 'QRIS', 'Voluptas cupiditate excepturi in rem autem quis nam.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(21, 11, '2011-12-20', 384552.41, 'Cash', 'Velit ab et animi.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(22, 11, '1991-12-22', 92779.10, 'Transfer', 'Cumque nostrum et omnis quis voluptatum aperiam asperiores dignissimos.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(23, 12, '1984-04-06', 257741.81, 'QRIS', 'Consequuntur omnis et et quo inventore.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(24, 12, '2019-08-25', 369797.90, 'Transfer', 'Ea nostrum aspernatur consequuntur rerum.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(25, 13, '2015-01-15', 328463.87, 'Transfer', 'Quam officia est ab voluptate.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(26, 13, '2004-05-12', 442991.78, 'QRIS', 'Dolorum qui et culpa.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(27, 14, '1975-07-29', 232550.71, 'Cash', 'Sapiente et a qui non voluptas voluptatem modi.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(28, 14, '1970-03-25', 21317.48, 'Transfer', 'Facere doloremque blanditiis accusamus tempore qui doloremque.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(29, 15, '1985-10-13', 440010.36, 'Transfer', 'A modi hic ratione dolore est.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(30, 15, '2012-03-01', 348771.89, 'Transfer', 'Aut illum veniam dolor.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(31, 16, '1976-08-17', 361989.74, 'QRIS', 'Esse deserunt dolore dolor minima repellendus placeat.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(32, 16, '2003-08-30', 282750.20, 'Cash', 'Ut atque in doloremque quaerat.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(33, 17, '2003-07-30', 352803.76, 'Cash', 'Enim dolores asperiores occaecati aut.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(34, 17, '1972-10-14', 369368.46, 'Transfer', 'Est impedit totam a libero omnis est omnis.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(35, 18, '2022-12-05', 276830.40, 'Transfer', 'Fugit excepturi inventore et.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(36, 18, '2000-04-01', 423148.32, 'Transfer', 'Molestiae aut laudantium quia quam excepturi sit.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(37, 19, '2010-12-28', 467731.10, 'QRIS', 'Totam voluptas facere eum consectetur aut dolores.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(38, 19, '1984-02-07', 133176.77, 'QRIS', 'Culpa deserunt aut sit dolores libero dignissimos fugit.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(39, 20, '2010-06-26', 89552.72, 'Transfer', 'Recusandae et aut quia quaerat.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(40, 20, '2006-06-18', 487588.76, 'Transfer', 'Distinctio est totam ab repudiandae tempora cum laborum recusandae.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `outlet_id` bigint(20) UNSIGNED NOT NULL,
  `lembaga_id` bigint(20) UNSIGNED NOT NULL,
  `position` varchar(100) DEFAULT NULL,
  `joined_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hutang`
--

CREATE TABLE `hutang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `outlet_id` bigint(20) UNSIGNED NOT NULL,
  `nama_pemberi_hutang` varchar(255) NOT NULL,
  `tanggal_hutang` date NOT NULL,
  `jumlah` decimal(14,2) NOT NULL,
  `sisa_hutang` decimal(14,2) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hutang`
--

INSERT INTO `hutang` (`id`, `outlet_id`, `nama_pemberi_hutang`, `tanggal_hutang`, `jumlah`, `sisa_hutang`, `deskripsi`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'Susan Crona', '1981-07-19', 846303.02, 430784.04, 'Minima atque incidunt similique delectus delectus.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(2, 2, 'Alvis Rowe IV', '1979-02-22', 669820.18, 498971.58, 'Explicabo ipsa consectetur nihil quaerat nemo.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(3, 3, 'Jerome Stanton', '2025-05-28', 507629.55, 91653.76, 'Voluptatum ratione quis ratione tempora inventore blanditiis perferendis.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(4, 4, 'Erling Rempel', '1981-08-09', 428199.32, 258004.07, 'Laudantium aspernatur perferendis dolorem perferendis aut molestiae animi.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(5, 5, 'Shayna Predovic', '1987-02-16', 289085.80, 70591.28, 'Saepe quaerat sit esse voluptate qui voluptatibus perferendis est.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(6, 6, 'Dr. Doug Torp Jr.', '1993-09-06', 942846.97, 840354.10, 'Iusto vero magnam earum ut explicabo corrupti ea.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(7, 7, 'Dr. Destany Senger V', '1982-09-30', 272500.97, 265235.18, 'Odit corporis optio ut maxime et qui quia accusantium.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(8, 8, 'Isidro Dach', '1985-05-16', 979207.96, 231330.91, 'Quis ut quisquam voluptatem est sint quam.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(9, 9, 'Miss Eliza Farrell V', '1991-05-19', 407684.54, 144087.23, 'Quibusdam labore quas magnam beatae.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(10, 10, 'Walter Hermiston', '2017-12-19', 387507.95, 138730.52, 'Quae qui eaque voluptatem.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(11, 11, 'Bobbie Gorczany DVM', '1978-03-03', 729682.29, 704321.77, 'Et nulla quia illum odit.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(12, 12, 'Jeremy Davis', '1978-10-07', 648735.05, 165373.61, 'Est sunt qui amet ratione et facere in nesciunt.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(13, 13, 'Reggie Donnelly', '2012-04-01', 509115.86, 186258.22, 'Maxime ea deleniti voluptatum ipsum earum architecto quasi.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(14, 14, 'Mr. Darian Reichel', '2014-06-04', 591200.90, 589217.72, 'Qui qui dolores quis.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(15, 15, 'Shawna Wiegand', '1995-03-11', 215116.21, 192773.53, 'Facilis tenetur iusto non occaecati maiores illum expedita ex.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(16, 16, 'Edmund Nolan PhD', '2022-07-28', 849859.35, 821975.49, 'Non saepe quos qui voluptas.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(17, 17, 'Odessa Bayer', '1986-06-26', 132751.12, 51039.43, 'Ex ex non molestiae esse.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(18, 18, 'Karolann Weimann', '2000-11-25', 775456.82, 304516.33, 'Quo voluptatem quis ad qui consequatur deleniti ab cum.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(19, 19, 'Dr. Domenick Bailey Sr.', '1986-03-21', 501465.58, 422124.84, 'Mollitia rerum esse laboriosam aut voluptatem nihil neque.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(20, 20, 'Mr. Cade Hackett III', '2022-05-13', 574188.53, 102994.85, 'Quos occaecati eum sapiente eligendi.', 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'Makanan Kering Anjing', 'Quas nisi voluptatum ullam et architecto in quisquam.', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(2, 'Snack Kucing', 'Sit consequatur nemo fugiat est rerum facere ipsum aut.', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(3, 'Mainan Hewan', 'Blanditiis ab qui ab dolor ea aut.', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(4, 'Obat & Vitamin', 'Aut laborum ullam voluptatem vel est ipsum.', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(5, 'Makanan Basah Kucing', 'Delectus ullam maxime et officiis porro distinctio placeat.', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(6, 'Makanan Kering Kucing', 'Ipsam sequi laudantium provident ipsum nulla.', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(7, 'Makanan Basah Anjing', 'Sint ipsum vero dicta praesentium maiores.', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(8, 'Snack Anjing', 'Qui ipsam cumque eaque repellendus deleniti at.', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(9, 'Kandang & Tas Hewan', 'Et qui dicta ea molestiae occaecati voluptas ducimus.', '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(10, 'Perawatan & Grooming', 'Et et deserunt magnam dolor similique.', '2025-06-15 09:49:32', '2025-06-15 09:49:32');

-- --------------------------------------------------------

--
-- Table structure for table `lembaga`
--

CREATE TABLE `lembaga` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `industry` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `logo_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lembaga`
--

INSERT INTO `lembaga` (`id`, `name`, `industry`, `phone`, `email`, `address`, `logo_path`, `created_at`, `updated_at`) VALUES
(1, 'Moezza Petshop', 'Pet Care & Retail', '+62 21 1234 5678', 'info@moezzapetshop.com', 'Jl. Pet Care No. 123, Jakarta', NULL, '2025-06-15 09:49:30', '2025-06-15 09:49:30');

-- --------------------------------------------------------

--
-- Table structure for table `lembaga_user_role`
--

CREATE TABLE `lembaga_user_role` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `lembaga_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lembaga_user_role`
--

INSERT INTO `lembaga_user_role` (`user_id`, `role_id`, `lembaga_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(1, 2, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(1, 3, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(1, 4, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(1, 5, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(1, 6, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_name` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `is_parent` tinyint(1) NOT NULL DEFAULT 0,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `menu_name`, `icon`, `route`, `is_parent`, `parent_id`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Dashboard', 'fas fa-tachometer-alt', '#', 0, NULL, 1, 1, '2025-06-15 09:49:30', '2025-06-15 09:49:30'),
(2, 'Penjualan', 'fa-solid fa-magnifying-glass-chart', '/dashboard/penjualan', 0, NULL, 2, 1, '2025-06-15 09:49:30', '2025-06-15 09:49:30'),
(3, 'Produk & Stok', 'fa-solid fa-boxes-stacked', NULL, 1, NULL, 3, 1, '2025-06-15 09:49:30', '2025-06-15 09:49:30'),
(4, 'Daftar Produk', 'fa-solid fa-clipboard-list', '/dashboard/produk-stok/produk', 0, 3, 1, 1, '2025-06-15 09:49:30', '2025-06-15 09:49:30'),
(5, 'Manajemen Barang', 'fa-solid fa-list-check', '/dashboard/produk-stok/barang', 0, 3, 2, 1, '2025-06-15 09:49:30', '2025-06-15 09:49:30'),
(6, 'Mutasi Stok', 'fa-solid fa-truck-moving', '/dashboard/produk-stok/mutasi', 0, 3, 3, 1, '2025-06-15 09:49:30', '2025-06-15 09:49:30'),
(7, 'Keuangan', 'fa-solid fa-coins', NULL, 1, NULL, 4, 1, '2025-06-15 09:49:30', '2025-06-15 09:49:30'),
(8, 'Kas & Ledger', 'fa-solid fa-money-bills', '/dashboard/keuangan/kas-ledger', 0, 7, 1, 1, '2025-06-15 09:49:30', '2025-06-15 09:49:30'),
(9, 'Hutang', 'fa-solid fa-sack-xmark', '/dashboard/keuangan/hutang', 0, 7, 2, 1, '2025-06-15 09:49:30', '2025-06-15 09:49:30'),
(10, 'Cicilan', 'fa-solid fa-sack-dollar', '/dashboard/keuangan/cicilan', 0, 7, 3, 1, '2025-06-15 09:49:30', '2025-06-15 09:49:30'),
(11, 'Outlet & Karyawan', 'fa-solid fa-shop', NULL, 1, NULL, 5, 1, '2025-06-15 09:49:30', '2025-06-15 09:49:30'),
(12, 'Daftar Outlet', 'fa-solid fa-store', '#', 0, 11, 1, 1, '2025-06-15 09:49:30', '2025-06-15 09:49:30'),
(13, 'Saldo Outlet', 'fa-solid fa-scale-balanced', '#', 0, 11, 2, 1, '2025-06-15 09:49:30', '2025-06-15 09:49:30'),
(14, 'Karyawan', 'fa-solid fa-users-line', '#', 0, 11, 3, 1, '2025-06-15 09:49:30', '2025-06-15 09:49:30'),
(15, 'Laporan', 'fa-solid fa-book', NULL, 1, NULL, 6, 1, '2025-06-15 09:49:30', '2025-06-15 09:49:30'),
(16, 'Laporan Penjualan', 'fa-solid fa-square-poll-vertical', '/dashboard/laporan/penjualan', 0, 15, 1, 1, '2025-06-15 09:49:30', '2025-06-15 09:49:30'),
(17, 'Laporan Stok', 'fa-solid fa-cubes-stacked', '/dashboard/laporan/stok/mutasi-stok', 0, 15, 2, 1, '2025-06-15 09:49:30', '2025-06-15 09:49:30'),
(18, 'Laporan Keuangan', 'fa-solid fa-magnifying-glass-dollar', '/dashboard/laporan/keuangan', 0, 15, 3, 1, '2025-06-15 09:49:30', '2025-06-15 09:49:30'),
(19, 'Pengaturan', 'fa-solid fa-gear', NULL, 1, NULL, 7, 1, '2025-06-15 09:49:30', '2025-06-15 09:49:30'),
(20, 'Manajemen User & Role', 'fa-solid fa-users-gear', '/dashboard/admin/user-management', 0, 19, 1, 1, '2025-06-15 09:49:30', '2025-06-15 09:49:30'),
(21, 'Manajemen Role & Menu', 'fa-solid fa-list-ul', '/dashboard/admin/menu', 0, 19, 2, 1, '2025-06-15 09:49:30', '2025-06-15 09:49:30'),
(22, 'Kategori Produk', 'fa-solid fa-tags', '/dashboard/produk-stok/kategori', 0, 19, 3, 1, '2025-06-15 09:49:30', '2025-06-15 09:49:30'),
(23, 'Log Aktivitas', 'fa-solid fa-timeline', '#', 0, NULL, 8, 1, '2025-06-15 09:49:30', '2025-06-15 09:49:30');

-- --------------------------------------------------------

--
-- Table structure for table `menu_roles`
--

CREATE TABLE `menu_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_item_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_roles`
--

INSERT INTO `menu_roles` (`id`, `menu_item_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(2, 1, 2, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(3, 1, 3, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(4, 1, 5, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(5, 1, 4, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(6, 1, 6, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(7, 2, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(8, 2, 2, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(9, 2, 5, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(10, 2, 4, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(11, 3, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(12, 3, 2, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(13, 3, 5, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(14, 3, 4, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(15, 4, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(16, 4, 2, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(17, 4, 5, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(18, 4, 4, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(19, 5, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(20, 5, 2, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(21, 5, 5, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(22, 6, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(23, 6, 2, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(24, 6, 5, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(25, 6, 4, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(26, 7, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(27, 7, 2, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(28, 7, 3, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(29, 7, 5, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(30, 8, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(31, 8, 2, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(32, 8, 3, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(33, 8, 5, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(34, 9, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(35, 9, 2, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(36, 9, 3, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(37, 9, 5, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(38, 10, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(39, 10, 2, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(40, 10, 3, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(41, 10, 5, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(42, 11, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(43, 11, 2, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(44, 12, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(45, 12, 2, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(46, 13, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(47, 13, 2, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(48, 14, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(49, 14, 2, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(50, 15, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(51, 15, 2, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(52, 15, 3, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(53, 15, 5, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(54, 15, 6, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(55, 16, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(56, 16, 2, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(57, 16, 3, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(58, 16, 5, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(59, 16, 6, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(60, 17, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(61, 17, 2, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(62, 17, 5, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(63, 17, 6, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(64, 18, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(65, 18, 2, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(66, 18, 3, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(67, 18, 5, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(68, 18, 6, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(69, 19, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(70, 19, 2, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(71, 20, 2, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(72, 22, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(73, 22, 2, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(74, 22, 5, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(75, 23, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(76, 23, 2, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(77, 23, 5, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(78, 21, 1, '2025-06-15 09:49:39', '2025-06-15 09:49:39');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_05_21_123154_create_barang_table', 1),
(5, '2025_05_21_123356_create_outlet_table', 1),
(6, '2025_05_21_123360_create_kategori_table', 1),
(7, '2025_05_21_123370_create_product_table', 1),
(8, '2025_05_21_123401_create_sale_table', 1),
(9, '2025_05_21_123453_create_employee_table', 1),
(10, '2025_05_21_123527_create_saleitem_table', 1),
(11, '2025_05_21_123540_create_stockmutation_table', 1),
(12, '2025_05_21_123550_create_cashledger_table', 1),
(13, '2025_05_21_123559_create_outletbalance_table', 1),
(14, '2025_05_21_123607_create_hutang_table', 1),
(15, '2025_05_21_123615_create_cicilan_table', 1),
(16, '2025_05_27_033916_create_lembaga_table', 1),
(17, '2025_05_27_034106_drop_field_name_from_users', 1),
(18, '2025_05_27_034358_add_name_to_employee_table', 1),
(19, '2025_05_27_034653_add_lembaga_id_to_employee_table', 1),
(20, '2025_05_27_034909_create_subscription_status', 1),
(21, '2025_05_27_035004_create_subscription_transaction', 1),
(22, '2025_05_27_084824_create_roles_table', 1),
(23, '2025_05_27_084832_create_user_role_table', 1),
(24, '2025_05_27_092914_create_menu_items_table', 1),
(25, '2025_06_04_085631_create_lembaga_user_role_table', 1),
(26, '2025_06_04_135044_add_display_name_and_description_to_roles_table', 1),
(27, '2025_06_15_122429_create_menu_roles_table', 1),
(28, '2025_06_15_135254_create_after_saleitem_insert_trigger', 1),
(29, '2025_06_15_140153_create_format_sale_id_function', 1);

-- --------------------------------------------------------

--
-- Table structure for table `outlet`
--

CREATE TABLE `outlet` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `lembaga_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `outlet`
--

INSERT INTO `outlet` (`id`, `name`, `address`, `phone`, `lembaga_id`, `created_at`, `updated_at`) VALUES
(1, 'Connelly Ltd', '974 Filiberto Ridges\nHeidenreichhaven, NE 55922', '1-501-534-1832', 1, '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(2, 'Homenick Inc', '76213 Liam Place\nRippinstad, IL 81922', '+1-646-653-5683', 1, '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(3, 'Kemmer and Sons', '11675 Dangelo View\nVidaborough, MD 94746-6455', '+18084927744', 1, '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(4, 'Morissette, Turcotte and Jaskolski', '4321 Dibbert Rue Apt. 854\nOlsontown, NY 85538', '+1-425-439-0120', 1, '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(5, 'Rogahn-Vandervort', '8079 Sanford Stream Apt. 795\nCreminland, NC 82589-2856', '(860) 438-8528', 1, '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(6, 'Klocko and Sons', '6648 Russel Rest Suite 064\nDanielaville, RI 40801', '+1-773-269-0292', 1, '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(7, 'Kuphal, Conn and Moore', '2230 Pamela Tunnel\nNorth Heath, ND 33343', '+12629302965', 1, '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(8, 'Willms, Powlowski and Mueller', '44092 Miguel Spurs Suite 498\nNorth Randy, SD 02025-9815', '(650) 683-1034', 1, '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(9, 'Goodwin Ltd', '54206 Kris Road Suite 154\nSouth Guiseppe, CO 23894', '+1.631.286.8114', 1, '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(10, 'Quigley, Jakubowski and Hyatt', '61367 Roderick Tunnel\nSouth Brody, WY 60411', '1-848-892-5569', 1, '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(11, 'Romaguera, Gutmann and Glover', '8895 Connelly Shores Suite 366\nAraport, MD 79985-1032', '+1-319-769-4378', 1, '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(12, 'Schmidt PLC', '686 Maurice Ramp Apt. 291\nEast Eloy, AZ 18326-6794', '845-205-2015', 1, '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(13, 'Homenick, Zulauf and Zemlak', '51241 Hill Gardens Suite 053\nEast Alysatown, WA 42529', '410-412-2411', 1, '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(14, 'Lang-Dickinson', '547 Kulas Plains\nNew Adrain, MT 81288-8913', '520.928.9434', 1, '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(15, 'Abshire-Moore', '660 Therese Mill\nDeshawnmouth, KS 93298', '(361) 895-4312', 1, '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(16, 'Ryan-Bode', '9785 Alford Highway\nWest Shanonton, DC 18449', '551.698.3651', 1, '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(17, 'Kemmer Ltd', '389 Geovanni Falls\nNew Adrianchester, VT 52819-4860', '+1-682-959-5353', 1, '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(18, 'Effertz Group', '8924 Freeda Village Apt. 423\nWiegandburgh, AR 95746-3115', '+1-831-981-7921', 1, '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(19, 'Pfeffer, Yundt and Farrell', '5790 Brycen Knoll\nKunzestad, WA 88324', '+1 (539) 407-1110', 1, '2025-06-15 09:49:32', '2025-06-15 09:49:32'),
(20, 'Streich-Sanford', '55214 Urban Cliff Suite 916\nRobertoview, AL 31643', '1-212-233-6225', 1, '2025-06-15 09:49:32', '2025-06-15 09:49:32');

-- --------------------------------------------------------

--
-- Table structure for table `outletbalance`
--

CREATE TABLE `outletbalance` (
  `outlet_id` bigint(20) UNSIGNED NOT NULL,
  `saldo` decimal(14,2) NOT NULL DEFAULT 0.00,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `outletbalance`
--

INSERT INTO `outletbalance` (`outlet_id`, `saldo`, `last_updated`, `created_at`, `updated_at`) VALUES
(1, 182003.66, '2025-06-15 09:49:39', '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(2, 235435.06, '2025-06-15 09:49:39', '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(3, 964338.46, '2025-06-15 09:49:39', '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(4, 235299.61, '2025-06-15 09:49:39', '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(5, 865576.29, '2025-06-15 09:49:39', '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(6, 208787.97, '2025-06-15 09:49:39', '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(7, 535421.76, '2025-06-15 09:49:39', '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(8, 669561.16, '2025-06-15 09:49:39', '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(9, 949166.15, '2025-06-15 09:49:39', '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(10, 205163.61, '2025-06-15 09:49:39', '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(11, 791864.99, '2025-06-15 09:49:39', '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(12, 281719.98, '2025-06-15 09:49:39', '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(13, 71489.79, '2025-06-15 09:49:39', '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(14, 446456.96, '2025-06-15 09:49:39', '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(15, 454918.18, '2025-06-15 09:49:39', '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(16, 795338.72, '2025-06-15 09:49:39', '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(17, 967314.04, '2025-06-15 09:49:39', '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(18, 700527.30, '2025-06-15 09:49:39', '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(19, 762240.93, '2025-06-15 09:49:39', '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(20, 295263.48, '2025-06-15 09:49:39', '2025-06-15 09:49:39', '2025-06-15 09:49:39');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `outlet_id` bigint(20) UNSIGNED NOT NULL,
  `barang_id` int(10) UNSIGNED NOT NULL,
  `kategori_id` bigint(20) UNSIGNED NOT NULL,
  `harga_jual` decimal(12,2) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `outlet_id`, `barang_id`, `kategori_id`, `harga_jual`, `stok`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 12, 31, 8, 290000.00, 2, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:37'),
(2, 18, 16, 2, 264000.00, 9, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:36'),
(3, 19, 3, 5, 78000.00, 3, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:35'),
(4, 12, 50, 7, 273000.00, 71, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:37'),
(5, 19, 46, 6, 16000.00, 5, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:36'),
(6, 1, 6, 4, 206000.00, 12, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(7, 17, 22, 7, 85000.00, 5, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(8, 13, 12, 9, 248000.00, 7, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(9, 14, 25, 5, 84000.00, 9, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(10, 19, 24, 5, 145000.00, 3, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:36'),
(11, 3, 22, 4, 191000.00, 25, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(12, 9, 42, 2, 158000.00, 21, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:39'),
(13, 14, 14, 9, 36000.00, 6, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(14, 8, 36, 2, 261000.00, 7, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(15, 11, 49, 1, 294000.00, 9, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(16, 8, 36, 2, 161000.00, 39, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(17, 8, 47, 6, 45000.00, 59, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(18, 16, 3, 5, 87000.00, 44, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(19, 20, 10, 9, 198000.00, 41, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(20, 18, 3, 7, 99000.00, 8, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(21, 3, 35, 5, 280000.00, 39, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(22, 18, 11, 6, 267000.00, 29, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(23, 5, 29, 4, 75000.00, 61, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(24, 15, 8, 2, 19000.00, 5, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:37'),
(25, 1, 12, 5, 241000.00, 7, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:36'),
(26, 7, 5, 10, 47000.00, 2, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(27, 7, 28, 2, 207000.00, 54, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(28, 4, 38, 5, 49000.00, 10, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:39'),
(29, 8, 34, 9, 195000.00, 58, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(30, 5, 1, 4, 232000.00, 9, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:36'),
(31, 4, 18, 6, 28000.00, 10, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:37'),
(32, 7, 19, 9, 279000.00, 54, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(33, 1, 30, 1, 74000.00, 34, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(34, 20, 9, 3, 55000.00, 47, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(35, 8, 50, 5, 38000.00, 35, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(36, 15, 46, 3, 116000.00, 11, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(37, 7, 29, 3, 271000.00, 20, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(38, 14, 21, 8, 73000.00, 8, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:35'),
(39, 19, 14, 2, 179000.00, 5, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(40, 5, 26, 2, 176000.00, 45, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:39'),
(41, 14, 29, 8, 241000.00, 4, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(42, 3, 3, 8, 53000.00, 28, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(43, 1, 26, 9, 278000.00, 66, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(44, 3, 44, 10, 123000.00, 5, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(45, 11, 31, 7, 138000.00, 28, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:39'),
(46, 20, 49, 8, 137000.00, 8, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:36'),
(47, 10, 50, 8, 188000.00, 10, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(48, 8, 45, 6, 182000.00, 69, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(49, 9, 15, 1, 47000.00, 5, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:35'),
(50, 20, 24, 9, 233000.00, 26, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:39'),
(51, 10, 6, 6, 299000.00, 8, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(52, 20, 18, 3, 30000.00, 30, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:39'),
(53, 20, 36, 3, 233000.00, 57, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:39'),
(54, 7, 2, 8, 265000.00, 5, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:36'),
(55, 13, 41, 2, 104000.00, 5, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:37'),
(56, 8, 33, 10, 178000.00, 1, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(57, 12, 27, 2, 279000.00, 63, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:33'),
(58, 6, 16, 10, 225000.00, 9, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:37'),
(59, 5, 48, 7, 257000.00, 52, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(60, 2, 28, 9, 44000.00, 34, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(61, 2, 25, 4, 103000.00, 4, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:37'),
(62, 12, 19, 10, 81000.00, 4, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:36'),
(63, 12, 21, 3, 64000.00, 26, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:36'),
(64, 12, 43, 3, 243000.00, 21, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(65, 7, 20, 8, 145000.00, 28, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(66, 1, 36, 8, 293000.00, 9, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:37'),
(67, 8, 48, 8, 40000.00, 82, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:37'),
(68, 17, 4, 8, 211000.00, 9, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(69, 6, 32, 4, 101000.00, 9, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:37'),
(70, 11, 27, 6, 18000.00, 4, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:36'),
(71, 11, 36, 7, 106000.00, 13, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(72, 18, 20, 4, 222000.00, 29, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(73, 3, 49, 5, 196000.00, 6, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(74, 4, 13, 10, 208000.00, 25, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:39'),
(75, 3, 36, 7, 97000.00, 2, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:37'),
(76, 6, 41, 3, 80000.00, 30, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(77, 12, 26, 7, 155000.00, 21, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:36'),
(78, 9, 44, 7, 234000.00, 37, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:39'),
(79, 5, 33, 2, 234000.00, 48, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(80, 15, 42, 1, 243000.00, 5, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(81, 16, 34, 5, 85000.00, 9, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(82, 6, 49, 4, 66000.00, 7, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:37'),
(83, 10, 6, 10, 104000.00, 52, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(84, 12, 35, 5, 286000.00, 74, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:37'),
(85, 13, 26, 3, 140000.00, 1, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:35'),
(86, 10, 32, 6, 264000.00, 10, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(87, 12, 50, 1, 212000.00, 78, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:36'),
(88, 15, 43, 6, 173000.00, 2, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(89, 3, 5, 9, 195000.00, 13, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(90, 10, 47, 9, 246000.00, 23, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(91, 12, 47, 4, 215000.00, 30, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(92, 7, 41, 10, 28000.00, 2, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(93, 5, 9, 1, 169000.00, 1, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:37'),
(94, 4, 33, 1, 161000.00, 6, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:36'),
(95, 8, 32, 10, 121000.00, 42, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(96, 3, 35, 5, 150000.00, 18, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(97, 11, 22, 10, 17000.00, 9, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(98, 11, 34, 7, 125000.00, 5, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(99, 16, 24, 9, 84000.00, 17, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38'),
(100, 19, 19, 9, 287000.00, 4, 1, '2025-06-15 09:49:33', '2025-06-15 09:49:38');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'super', 'Super Administrator', 'Highest level access with all permissions across all lembaga', '2025-06-15 09:49:30', '2025-06-15 09:49:30'),
(2, 'admin', 'Administrator', 'Full access administrator with all permissions within lembaga', '2025-06-15 09:49:30', '2025-06-15 09:49:30'),
(3, 'keuangan', 'Staff Keuangan', 'Financial staff with access to financial modules and reports', '2025-06-15 09:49:30', '2025-06-15 09:49:30'),
(4, 'employee', 'Karyawan', 'Regular employee with basic operational permissions', '2025-06-15 09:49:30', '2025-06-15 09:49:30'),
(5, 'manager', 'Manager', 'Manager with limited administrative permissions', '2025-06-15 09:49:30', '2025-06-15 09:49:30'),
(6, 'viewer', 'Viewer', 'Read-only access to view data without modification rights', '2025-06-15 09:49:30', '2025-06-15 09:49:30');

-- --------------------------------------------------------

--
-- Table structure for table `sale`
--

CREATE TABLE `sale` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `outlet_id` bigint(20) UNSIGNED NOT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `sale_date` date NOT NULL,
  `total` decimal(14,2) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale`
--

INSERT INTO `sale` (`id`, `outlet_id`, `customer_name`, `sale_date`, `total`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 19, 'Tamara Parisian', '2025-02-05', 985000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(2, 15, 'Levi Collins', '2024-11-10', 1416000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(3, 5, 'Monroe Dickens Sr.', '2025-04-29', 845000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(4, 19, 'Patience Sauer', '2024-09-14', 1243000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(5, 3, 'Noemy Kunde', '2025-01-05', 291000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(6, 17, 'Miss Kelli Schowalter IV', '2024-07-29', 255000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(7, 7, 'Max Crist II', '2025-03-16', 1116000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(8, 14, 'Miss Tiara Bosco I', '2025-01-21', 1493000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(9, 1, 'Kristina Beier', '2025-04-05', 2454000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(10, 15, 'Raoul Pouros', '2024-10-25', 154000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(11, 7, 'Jodie McClure', '2025-04-03', 1850000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(12, 6, 'Ms. Tabitha O\'Kon', '2024-10-12', 247000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(13, 17, 'Lesley Stamm', '2024-07-31', 1310000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(14, 9, 'Kenya Huel', '2024-07-08', 1867000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(15, 13, 'Hattie Eichmann', '2024-11-21', 732000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(16, 7, 'Mr. Brennan Wiza III', '2025-05-29', 664000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(17, 13, 'Kiel Barton III', '2024-08-27', 2460000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(18, 4, 'Mr. Gunner Medhurst III', '2024-09-09', 84000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(19, 2, 'Mrs. Brenna Sipes', '2024-11-04', 338000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(20, 19, 'Delbert Turcotte', '2024-11-25', 994000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(21, 4, 'Marco Paucek III', '2024-10-12', 1039000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(22, 4, 'Prof. Kenneth Roberts', '2024-10-05', 1212000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(23, 15, 'Tessie Wunsch', '2024-10-06', 1151000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(24, 5, 'Dr. Alek Doyle', '2025-05-12', 1492000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(25, 20, 'Ms. Lois Volkman PhD', '2024-07-25', 548000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(26, 8, 'Dr. Myron Cummings I', '2025-04-17', 90000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(27, 1, 'Mr. Ryley Gutkowski', '2024-10-19', 3343000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(28, 15, 'Marlin Becker', '2024-11-20', 726000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(29, 19, 'Hillary Bauch', '2024-07-22', 2237000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(30, 19, 'Ludwig Krajcik', '2025-02-24', 716000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(31, 7, 'Maxime Nolan', '2024-11-06', 2636000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(32, 13, 'Lexus Beer', '2025-06-02', 1016000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(33, 4, 'Rolando Beatty II', '2024-07-10', 1294000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(34, 8, 'Tessie Schaefer', '2025-05-30', 1154000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(35, 1, 'Conrad Kulas', '2025-03-10', 1450000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(36, 3, 'Haleigh Kuhic', '2024-08-27', 876000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(37, 13, 'Mr. Efren Goodwin', '2025-05-10', 1096000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(38, 12, 'Prof. Magnus Labadie DDS', '2025-06-10', 452000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(39, 1, 'Niko Powlowski I', '2024-09-13', 1324000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(40, 11, 'Brandi Gleason', '2025-04-01', 747000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(41, 14, 'Houston Ryan', '2024-07-27', 445000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(42, 5, 'Prof. Jules Schmitt IV', '2024-12-06', 1165000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(43, 16, 'Modesto Russel', '2025-02-08', 688000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(44, 1, 'Prof. Leda Wiegand Jr.', '2024-08-09', 412000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(45, 12, 'Catherine Collins', '2024-07-20', 2162000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(46, 15, 'Miss Mandy Luettgen III', '2025-04-17', 729000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(47, 11, 'Dovie Rogahn V', '2024-06-21', 212000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(48, 16, 'Dr. Orin Schneider Sr.', '2024-11-21', 170000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(49, 19, 'Evert Rath', '2025-03-18', 179000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(50, 5, 'Mrs. Claudie Windler DVM', '2025-06-14', 1346000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(51, 8, 'Prof. Raegan Howell I', '2025-03-20', 38000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(52, 18, 'Miss Jakayla Wolff', '2024-10-24', 792000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(53, 8, 'Lila Kuhn Sr.', '2025-01-09', 638000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(54, 18, 'Dr. Russel Marvin DVM', '2025-06-13', 99000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(55, 7, 'Loma Bradtke DVM', '2025-06-05', 140000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(56, 6, 'Jess Rice', '2025-03-31', 101000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(57, 2, 'Esther Schoen', '2025-05-15', 485000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(58, 19, 'Prof. Stanley Keeling PhD', '2024-12-08', 1972000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(59, 1, 'Elise Parisian III', '2024-12-09', 586000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(60, 17, 'Dominic Moen', '2024-09-27', 507000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(61, 5, 'Andre Bayer', '2025-05-31', 1843000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(62, 9, 'Milo Feest', '2025-06-08', 1492000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(63, 6, 'Dane Hartmann', '2025-02-20', 1429000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(64, 9, 'Jazmyne Herzog II', '2025-04-02', 632000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(65, 16, 'Jadyn Walker', '2025-02-10', 595000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(66, 3, 'Ervin Shields', '2025-04-18', 1793000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(67, 5, 'Eleonore Little II', '2025-03-06', 257000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(68, 17, 'Mrs. Asa Fritsch', '2024-11-05', 1269000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(69, 14, 'Mrs. Maiya Pfannerstill', '2024-10-27', 830000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(70, 12, 'Dixie Hirthe', '2025-05-01', 2084000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(71, 4, 'Devan Stokes', '2025-04-16', 245000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(72, 1, 'Ms. Cathy Torphy IV', '2025-01-10', 618000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(73, 10, 'Albert Hodkiewicz', '2024-08-24', 751000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(74, 12, 'Hulda Corkery MD', '2024-07-19', 1891000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(75, 7, 'Gabrielle Ernser III', '2024-12-31', 1754000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(76, 18, 'Dr. Darrel Streich DDS', '2024-08-31', 1116000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(77, 20, 'Iliana Kovacek', '2024-06-24', 1285000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(78, 17, 'Betty Crist', '2025-05-30', 973000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(79, 9, 'Deron McClure', '2025-02-06', 1170000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:36'),
(80, 6, 'Ottis Crooks', '2024-08-28', 1946000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(81, 5, 'Prof. Clifford Klein Jr.', '2024-11-03', 1327000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(82, 16, 'Greta Konopelski', '2024-06-21', 685000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(83, 1, 'Tomasa Nolan', '2025-02-08', 1920000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(84, 2, 'Ismael Medhurst', '2025-05-25', 412000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(85, 6, 'Dr. George Pouros DVM', '2025-02-04', 968000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(86, 17, 'Mr. Nigel Ruecker', '2024-10-25', 847000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(87, 13, 'Amber Glover MD', '2025-02-04', 1160000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(88, 18, 'Prof. Cindy Bruen MD', '2025-03-12', 666000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(89, 15, 'Imelda Smitham', '2024-12-25', 1786000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(90, 16, 'Prof. Megane Conroy', '2024-12-21', 346000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(91, 6, 'Miss Matilda Wisozk I', '2024-11-02', 1016000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(92, 12, 'Ruben Cummings', '2024-12-09', 1417000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(93, 3, 'Sallie Hilpert', '2024-08-17', 1728000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(94, 9, 'Dr. Treva Gorczany', '2025-04-22', 1410000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(95, 8, 'Mr. Ralph Johnson', '2025-06-14', 910000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(96, 13, 'Carlos Hane', '2024-10-16', 456000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(97, 8, 'Sofia Kutch', '2024-11-02', 900000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(98, 19, 'Athena Macejkovic', '2025-05-01', 645000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(99, 17, 'Mekhi Carter', '2024-12-08', 888000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(100, 17, 'Suzanne Altenwerth', '2025-02-01', 633000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(101, 17, 'Lizzie Marvin IV', '2025-03-08', 255000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(102, 6, 'Prof. Ervin Kilback', '2025-06-05', 414000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(103, 13, 'Nickolas Homenick DVM', '2024-11-17', 992000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(104, 10, 'Ransom Morissette', '2024-12-21', 2214000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(105, 18, 'Houston Blanda', '2024-10-02', 2841000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(106, 19, 'Hobart Blick', '2024-07-24', 861000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(107, 18, 'Lavina Goyette', '2025-01-11', 1497000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(108, 13, 'Virginia Douglas Sr.', '2025-02-11', 1552000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(109, 1, 'Prof. Raphael Littel', '2025-06-01', 278000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(110, 4, 'Kennedy Kub', '2025-04-29', 876000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(111, 2, 'Mr. Christop Schoen IV', '2025-01-20', 220000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(112, 3, 'Aaliyah Collier', '2024-11-05', 978000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(113, 5, 'Cloyd White', '2024-08-12', 1177000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(114, 18, 'Lynn King', '2025-03-04', 519000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(115, 17, 'Ms. Erna Mueller', '2024-08-03', 762000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(116, 20, 'Phoebe Klocko', '2024-12-05', 932000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(117, 14, 'Prof. Janae Smith', '2024-07-25', 723000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(118, 2, 'Easton Treutel', '2024-12-16', 44000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(119, 14, 'Morton Hettinger', '2025-05-09', 108000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(120, 13, 'Janis Bauch IV', '2024-07-15', 992000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(121, 17, 'Clara Hoppe', '2025-04-22', 1395000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(122, 17, 'Ruthe Tremblay V', '2025-04-06', 1055000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(123, 4, 'Virgil Brekke', '2025-04-05', 869000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(124, 15, 'Stevie Medhurst', '2025-02-02', 116000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(125, 2, 'Calista Kunde II', '2024-07-09', 132000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(126, 18, 'Keanu Erdman III', '2024-12-27', 1557000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(127, 20, 'Leonie Bergstrom', '2024-12-02', 2483000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(128, 9, 'Jonas Funk', '2025-05-24', 1568000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(129, 6, 'Harvey Cummerata', '2024-07-12', 685000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(130, 19, 'Charity Labadie', '2025-01-11', 2330000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(131, 8, 'Lowell Kiehn', '2025-03-23', 1026000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(132, 15, 'Chester West', '2024-09-25', 1213000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(133, 5, 'Richie Rowe DVM', '2024-06-22', 150000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(134, 18, 'Elwyn Anderson', '2025-04-06', 222000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(135, 16, 'Alf Lakin Jr.', '2024-07-06', 423000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(136, 2, 'Mariam Roberts', '2024-12-31', 220000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(137, 10, 'Jayce Little', '2024-09-21', 4123000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(138, 13, 'Prof. Pattie Smith', '2025-03-24', 496000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(139, 11, 'Ms. Laney Kuhn V', '2025-02-12', 85000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(140, 19, 'Sofia Stroman', '2025-03-12', 1972000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(141, 17, 'Mr. Celestino Maggio', '2025-02-07', 1225000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(142, 4, 'Ms. Agnes Bradtke', '2025-03-27', 98000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(143, 3, 'Mrs. Heather Barrows', '2024-08-17', 300000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(144, 13, 'Romaine Stanton', '2024-10-06', 992000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(145, 3, 'Marcia Schowalter', '2025-05-05', 388000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(146, 16, 'Prof. Horace Barton', '2024-07-29', 852000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(147, 18, 'Reina Romaguera III', '2024-10-29', 2742000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(148, 16, 'Columbus Davis', '2024-09-13', 424000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(149, 10, 'Allie Mayer', '2025-03-10', 940000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(150, 12, 'Mrs. Karianne Daugherty', '2024-10-28', 286000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(151, 19, 'Mr. Darren Leannon', '2024-06-20', 1685000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(152, 10, 'Mr. Diego Konopelski', '2024-12-18', 2470000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(153, 7, 'Scotty Abernathy', '2024-12-16', 725000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(154, 15, 'Simeon Feeney', '2025-02-16', 2023000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(155, 12, 'Prof. Francesco Schoen I', '2025-04-25', 1450000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:37'),
(156, 5, 'Mr. Terence Bernier Jr.', '2024-07-31', 1819000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(157, 2, 'Zachary Kunze', '2025-03-26', 132000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(158, 7, 'Beth Casper', '2024-10-21', 2552000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(159, 18, 'Crystel Moen', '2024-12-26', 2130000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(160, 15, 'Miss Elena Daugherty', '2024-08-08', 1410000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(161, 13, 'Irma Padberg', '2025-05-12', 496000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(162, 11, 'Dr. Darlene Balistreri', '2025-05-20', 212000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(163, 17, 'Mrs. Joanie Dare', '2024-12-02', 381000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(164, 6, 'Laura Kassulke', '2024-08-20', 160000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(165, 17, 'Fidel Larson', '2024-09-07', 381000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(166, 14, 'Alycia Walker', '2025-04-03', 1046000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(167, 19, 'Mr. Grover Kessler', '2025-03-15', 753000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(168, 20, 'Lonny Langworth', '2024-10-11', 198000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(169, 7, 'Prof. Petra Hahn', '2025-01-28', 575000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(170, 20, 'Randy Leffler', '2025-05-31', 1095000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(171, 15, 'Katelin Goldner', '2024-11-03', 648000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(172, 15, 'Sam Borer', '2025-04-21', 464000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(173, 14, 'Ericka Schinner', '2025-02-03', 1215000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(174, 3, 'Thaddeus Jacobs II', '2024-06-24', 1372000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(175, 5, 'Junior McClure', '2025-04-14', 2598000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(176, 6, 'Genoveva Wisozk', '2024-06-23', 320000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(177, 11, 'Dr. Jordi Nitzsche', '2025-05-13', 639000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(178, 19, 'Dr. Alisa Bauch I', '2025-05-01', 1972000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(179, 7, 'Mrs. Esther Keebler V', '2025-02-25', 235000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(180, 8, 'Chester Kuhlman', '2025-04-12', 3143000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(181, 16, 'Miss Mozell Gusikowski IV', '2024-12-02', 431000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(182, 11, 'Judson Bailey DDS', '2024-12-22', 863000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(183, 3, 'Jordy Turcotte Sr.', '2024-10-15', 922000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(184, 3, 'Jaren O\'Reilly', '2025-03-26', 392000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(185, 19, 'Bryon Bergstrom', '2024-10-15', 574000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(186, 12, 'Prof. Jason Gottlieb', '2024-10-22', 972000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(187, 13, 'Melyssa Kassulke PhD', '2024-12-19', 496000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(188, 9, 'Tristin Berge', '2024-10-30', 1258000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(189, 6, 'Dr. Porter Mraz', '2024-12-22', 160000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(190, 9, 'Brent Kuhic', '2024-12-28', 158000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(191, 7, 'Eveline Wiza', '2024-09-15', 2426000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(192, 7, 'Camron Schaden I', '2025-03-12', 794000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(193, 3, 'Sarah Treutel', '2025-03-25', 2229000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(194, 1, 'Misael Volkman', '2024-12-25', 1894000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(195, 1, 'Mohamed Rempel', '2024-11-24', 370000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(196, 14, 'Miss Tressa Lehner DDS', '2024-07-05', 1251000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(197, 15, 'Jessika Monahan DDS', '2025-06-06', 2196000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(198, 13, 'Oral Johns', '2025-06-03', 248000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(199, 13, 'Shanie Prosacco', '2024-08-30', 496000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(200, 10, 'Annamarie Klein', '2024-12-05', 695000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(201, 3, 'Emily Witting', '2024-12-24', 687000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(202, 2, 'Rhea Hoppe', '2024-09-07', 132000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(203, 5, 'Brandon Little', '2025-04-11', 234000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(204, 15, 'Cory Cremin', '2024-07-26', 116000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(205, 11, 'Brigitte Rempel', '2024-12-04', 731000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(206, 7, 'Mazie Simonis I', '2024-12-07', 1355000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(207, 16, 'Prof. Manuela Johnston V', '2025-01-02', 425000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(208, 20, 'Christine Kessler', '2024-06-21', 220000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(209, 1, 'Aaliyah Carroll', '2025-02-28', 1390000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(210, 10, 'Prof. Beau Davis', '2025-01-12', 598000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(211, 6, 'Chadrick Hickle', '2024-08-27', 400000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(212, 5, 'Mrs. Clotilde Gaylord Sr.', '2025-02-06', 2050000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(213, 14, 'Maximus Schroeder Jr.', '2025-01-20', 1288000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(214, 8, 'Nona Brakus II', '2025-02-18', 2439000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(215, 5, 'Amanda Bartoletti', '2024-11-11', 866000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(216, 10, 'Luz Johns', '2024-08-31', 3802000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(217, 3, 'Dr. Ewell Russel DDS', '2025-03-10', 732000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(218, 9, 'Ebony Mueller', '2025-06-11', 550000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(219, 18, 'Vivien Goyette', '2025-04-09', 2445000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(220, 10, 'Prof. Edwina Dicki', '2024-07-22', 2072000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(221, 9, 'Audrey O\'Kon', '2024-09-07', 392000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(222, 19, 'Frank Wiza IV', '2024-12-26', 2043000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(223, 16, 'Ms. Sibyl Block', '2024-07-16', 423000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(224, 20, 'Gabrielle Stroman V', '2024-07-05', 1220000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(225, 11, 'Julius Hessel', '2025-05-03', 1181000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(227, 11, 'Dr. Mariela Barrows', '2024-10-31', 1220000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(228, 14, 'Jodie Schuster', '2024-11-01', 84000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(229, 12, 'Vicky Murray', '2024-12-23', 1075000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(230, 9, 'Amber Reynolds', '2025-03-19', 626000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(231, 9, 'Roger Deckow DDS', '2024-07-15', 860000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(232, 8, 'Dr. Vivianne Herzog DDS', '2024-11-14', 595000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(233, 7, 'Alexandra Reynolds', '2025-04-05', 1551000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(234, 16, 'Robert Mante', '2025-01-26', 435000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(236, 15, 'Serena Wisozk', '2024-07-24', 116000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(237, 17, 'Brody Kuvalis V', '2025-05-18', 677000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(239, 15, 'Romaine Schaden', '2025-02-09', 348000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(240, 11, 'Dorothea Kuphal', '2024-12-24', 530000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(241, 18, 'Maiya Olson', '2025-04-07', 1467000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:38'),
(242, 11, 'Ova Murazik', '2025-03-28', 1707000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:39'),
(244, 20, 'Dr. Mireya Carroll', '2025-05-22', 263000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:39'),
(246, 9, 'Camron Shanahan', '2025-01-08', 1024000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:39'),
(247, 4, 'Margarita Crona', '2024-11-16', 1089000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:39'),
(248, 5, 'Gunner Purdy', '2024-12-01', 704000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:39'),
(250, 20, 'Doris Towne', '2025-05-19', 466000.00, 1, '2025-06-15 09:49:35', '2025-06-15 09:49:39');

-- --------------------------------------------------------

--
-- Table structure for table `saleitem`
--

CREATE TABLE `saleitem` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `harga_satuan` decimal(12,2) NOT NULL,
  `subtotal` decimal(14,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `saleitem`
--

INSERT INTO `saleitem` (`id`, `sale_id`, `product_id`, `quantity`, `harga_satuan`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 100, 1, 287000.00, 287000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(2, 1, 39, 3, 179000.00, 537000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(3, 1, 5, 1, 16000.00, 16000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(4, 1, 10, 1, 145000.00, 145000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(5, 2, 80, 1, 243000.00, 243000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(6, 2, 24, 4, 19000.00, 76000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(7, 2, 36, 2, 116000.00, 232000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(8, 2, 88, 5, 173000.00, 865000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(9, 3, 93, 5, 169000.00, 845000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(10, 4, 10, 4, 145000.00, 580000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(11, 4, 5, 3, 16000.00, 48000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(12, 4, 3, 1, 78000.00, 78000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(13, 4, 39, 3, 179000.00, 537000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(14, 5, 75, 3, 97000.00, 291000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(15, 6, 7, 3, 85000.00, 255000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(16, 7, 32, 4, 279000.00, 1116000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(17, 8, 13, 1, 36000.00, 36000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(18, 8, 9, 5, 84000.00, 420000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(19, 8, 38, 1, 73000.00, 73000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(20, 8, 41, 4, 241000.00, 964000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(21, 9, 33, 5, 74000.00, 370000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(22, 9, 66, 3, 293000.00, 879000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(23, 9, 25, 5, 241000.00, 1205000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(24, 10, 24, 2, 19000.00, 38000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(25, 10, 36, 1, 116000.00, 116000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(26, 11, 27, 3, 207000.00, 621000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(27, 11, 65, 1, 145000.00, 145000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(28, 11, 37, 4, 271000.00, 1084000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(29, 12, 69, 1, 101000.00, 101000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(30, 12, 76, 1, 80000.00, 80000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(31, 12, 82, 1, 66000.00, 66000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(32, 13, 68, 5, 211000.00, 1055000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(33, 13, 7, 3, 85000.00, 255000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(34, 14, 12, 5, 158000.00, 790000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(35, 14, 78, 4, 234000.00, 936000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(36, 14, 49, 3, 47000.00, 141000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(37, 15, 55, 3, 104000.00, 312000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(38, 15, 85, 3, 140000.00, 420000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(39, 16, 92, 3, 28000.00, 84000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(40, 16, 65, 4, 145000.00, 580000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(41, 17, 85, 5, 140000.00, 700000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(42, 17, 55, 5, 104000.00, 520000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(43, 17, 8, 5, 248000.00, 1240000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(44, 18, 31, 3, 28000.00, 84000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(45, 19, 60, 3, 44000.00, 132000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(46, 19, 61, 2, 103000.00, 206000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(47, 20, 39, 3, 179000.00, 537000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(48, 20, 10, 1, 145000.00, 145000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(49, 20, 3, 4, 78000.00, 312000.00, '2025-06-15 09:49:35', '2025-06-15 09:49:35'),
(50, 21, 74, 2, 208000.00, 416000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(51, 21, 94, 3, 161000.00, 483000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(52, 21, 31, 5, 28000.00, 140000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(53, 22, 94, 3, 161000.00, 483000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(54, 22, 28, 1, 49000.00, 49000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(55, 22, 31, 2, 28000.00, 56000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(56, 22, 74, 3, 208000.00, 624000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(57, 23, 80, 3, 243000.00, 729000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(58, 23, 24, 4, 19000.00, 76000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(59, 23, 88, 2, 173000.00, 346000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(60, 24, 30, 2, 232000.00, 464000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(61, 24, 59, 4, 257000.00, 1028000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(62, 25, 46, 4, 137000.00, 548000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(63, 26, 17, 2, 45000.00, 90000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(64, 27, 6, 3, 206000.00, 618000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(65, 27, 33, 4, 74000.00, 296000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(66, 27, 66, 5, 293000.00, 1465000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(67, 27, 25, 4, 241000.00, 964000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(68, 28, 36, 4, 116000.00, 464000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(69, 28, 24, 1, 19000.00, 19000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(70, 28, 80, 1, 243000.00, 243000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(71, 29, 100, 3, 287000.00, 861000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(72, 29, 5, 5, 16000.00, 80000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(73, 29, 10, 4, 145000.00, 580000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(74, 29, 39, 4, 179000.00, 716000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(75, 30, 39, 4, 179000.00, 716000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(76, 31, 54, 3, 265000.00, 795000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(77, 31, 65, 5, 145000.00, 725000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(78, 31, 32, 4, 279000.00, 1116000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(79, 32, 8, 2, 248000.00, 496000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(80, 32, 55, 5, 104000.00, 520000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(81, 33, 74, 4, 208000.00, 832000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(82, 33, 31, 5, 28000.00, 140000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(83, 33, 94, 2, 161000.00, 322000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(84, 34, 16, 2, 161000.00, 322000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(85, 34, 56, 4, 178000.00, 712000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(86, 34, 67, 3, 40000.00, 120000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(87, 35, 66, 4, 293000.00, 1172000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(88, 35, 43, 1, 278000.00, 278000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(89, 36, 75, 1, 97000.00, 97000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(90, 36, 73, 3, 196000.00, 588000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(91, 36, 11, 1, 191000.00, 191000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(92, 37, 55, 1, 104000.00, 104000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(93, 37, 8, 4, 248000.00, 992000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(94, 38, 62, 4, 81000.00, 324000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(95, 38, 63, 2, 64000.00, 128000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(96, 39, 43, 1, 278000.00, 278000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(97, 39, 6, 4, 206000.00, 824000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(98, 39, 33, 3, 74000.00, 222000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(99, 40, 98, 5, 125000.00, 625000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(100, 40, 70, 3, 18000.00, 54000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(101, 40, 97, 4, 17000.00, 68000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(102, 41, 41, 1, 241000.00, 241000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(103, 41, 13, 1, 36000.00, 36000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(104, 41, 9, 2, 84000.00, 168000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(105, 42, 93, 1, 169000.00, 169000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(106, 42, 30, 3, 232000.00, 696000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(107, 42, 23, 4, 75000.00, 300000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(108, 43, 81, 4, 85000.00, 340000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(109, 43, 18, 4, 87000.00, 348000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(110, 44, 6, 2, 206000.00, 412000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(111, 45, 1, 4, 290000.00, 1160000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(112, 45, 84, 2, 286000.00, 572000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(113, 45, 91, 2, 215000.00, 430000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(114, 46, 80, 3, 243000.00, 729000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(115, 47, 71, 2, 106000.00, 212000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(116, 48, 81, 2, 85000.00, 170000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(117, 49, 39, 1, 179000.00, 179000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(118, 50, 79, 5, 234000.00, 1170000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(119, 50, 40, 1, 176000.00, 176000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(120, 51, 35, 1, 38000.00, 38000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(121, 52, 2, 3, 264000.00, 792000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(122, 53, 35, 4, 38000.00, 152000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(123, 53, 17, 5, 45000.00, 225000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(124, 53, 14, 1, 261000.00, 261000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(125, 54, 20, 1, 99000.00, 99000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(126, 55, 92, 5, 28000.00, 140000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(127, 56, 69, 1, 101000.00, 101000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(128, 57, 60, 4, 44000.00, 176000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(129, 57, 61, 3, 103000.00, 309000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(130, 58, 100, 5, 287000.00, 1435000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(131, 58, 39, 3, 179000.00, 537000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(132, 59, 66, 2, 293000.00, 586000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(133, 60, 68, 2, 211000.00, 422000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(134, 60, 7, 1, 85000.00, 85000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(135, 61, 40, 4, 176000.00, 704000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(136, 61, 59, 1, 257000.00, 257000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(137, 61, 23, 5, 75000.00, 375000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(138, 61, 93, 3, 169000.00, 507000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(139, 62, 78, 3, 234000.00, 702000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(140, 62, 12, 5, 158000.00, 790000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(141, 63, 58, 4, 225000.00, 900000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(142, 63, 69, 3, 101000.00, 303000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(143, 63, 76, 2, 80000.00, 160000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(144, 63, 82, 1, 66000.00, 66000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(145, 64, 12, 4, 158000.00, 632000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(146, 65, 99, 2, 84000.00, 168000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(147, 65, 18, 1, 87000.00, 87000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(148, 65, 81, 4, 85000.00, 340000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(149, 66, 96, 3, 150000.00, 450000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(150, 66, 75, 4, 97000.00, 388000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(151, 66, 11, 5, 191000.00, 955000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(152, 67, 59, 1, 257000.00, 257000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(153, 68, 68, 4, 211000.00, 844000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(154, 68, 7, 5, 85000.00, 425000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(155, 69, 13, 5, 36000.00, 180000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(156, 69, 9, 2, 84000.00, 168000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(157, 69, 41, 2, 241000.00, 482000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(158, 70, 64, 3, 243000.00, 729000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(159, 70, 1, 3, 290000.00, 870000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(160, 70, 4, 1, 273000.00, 273000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(161, 70, 87, 1, 212000.00, 212000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(162, 71, 28, 5, 49000.00, 245000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(163, 72, 6, 3, 206000.00, 618000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(164, 73, 86, 1, 264000.00, 264000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(165, 73, 47, 1, 188000.00, 188000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(166, 73, 51, 1, 299000.00, 299000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(167, 74, 63, 1, 64000.00, 64000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(168, 74, 4, 4, 273000.00, 1092000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(169, 74, 1, 2, 290000.00, 580000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(170, 74, 77, 1, 155000.00, 155000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(171, 75, 32, 2, 279000.00, 558000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(172, 75, 92, 4, 28000.00, 112000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(173, 75, 37, 4, 271000.00, 1084000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(174, 76, 20, 1, 99000.00, 99000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(175, 76, 2, 2, 264000.00, 528000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(176, 76, 22, 1, 267000.00, 267000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(177, 76, 72, 1, 222000.00, 222000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(178, 77, 53, 1, 233000.00, 233000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(179, 77, 52, 4, 30000.00, 120000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(180, 77, 50, 4, 233000.00, 932000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(181, 78, 68, 3, 211000.00, 633000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(182, 78, 7, 4, 85000.00, 340000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(183, 79, 78, 5, 234000.00, 1170000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(184, 80, 76, 4, 80000.00, 320000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(185, 80, 58, 5, 225000.00, 1125000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(186, 80, 82, 3, 66000.00, 198000.00, '2025-06-15 09:49:36', '2025-06-15 09:49:36'),
(187, 80, 69, 3, 101000.00, 303000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(188, 81, 79, 2, 234000.00, 468000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(189, 81, 93, 3, 169000.00, 507000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(190, 81, 40, 2, 176000.00, 352000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(191, 82, 18, 3, 87000.00, 261000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(192, 82, 81, 4, 85000.00, 340000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(193, 82, 99, 1, 84000.00, 84000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(194, 83, 43, 4, 278000.00, 1112000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(195, 83, 66, 2, 293000.00, 586000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(196, 83, 33, 3, 74000.00, 222000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(197, 84, 61, 4, 103000.00, 412000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(198, 85, 76, 4, 80000.00, 320000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(199, 85, 82, 3, 66000.00, 198000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(200, 85, 58, 2, 225000.00, 450000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(201, 86, 68, 2, 211000.00, 422000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(202, 86, 7, 5, 85000.00, 425000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(203, 87, 8, 3, 248000.00, 744000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(204, 87, 55, 4, 104000.00, 416000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(205, 88, 72, 3, 222000.00, 666000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(206, 89, 88, 5, 173000.00, 865000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(207, 89, 36, 1, 116000.00, 116000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(208, 89, 24, 4, 19000.00, 76000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(209, 89, 80, 3, 243000.00, 729000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(210, 90, 81, 1, 85000.00, 85000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(211, 90, 18, 3, 87000.00, 261000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(212, 91, 69, 1, 101000.00, 101000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(213, 91, 58, 3, 225000.00, 675000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(214, 91, 76, 3, 80000.00, 240000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(215, 92, 84, 4, 286000.00, 1144000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(216, 92, 4, 1, 273000.00, 273000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(217, 93, 89, 4, 195000.00, 780000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(218, 93, 75, 4, 97000.00, 388000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(219, 93, 21, 2, 280000.00, 560000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(220, 94, 78, 4, 234000.00, 936000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(221, 94, 12, 3, 158000.00, 474000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(222, 95, 48, 5, 182000.00, 910000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(223, 96, 8, 1, 248000.00, 248000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(224, 96, 55, 2, 104000.00, 208000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(225, 97, 95, 5, 121000.00, 605000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(226, 97, 67, 4, 40000.00, 160000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(227, 97, 17, 3, 45000.00, 135000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(228, 98, 39, 2, 179000.00, 358000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(229, 98, 100, 1, 287000.00, 287000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(230, 99, 7, 3, 85000.00, 255000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(231, 99, 68, 3, 211000.00, 633000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(232, 100, 68, 3, 211000.00, 633000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(233, 101, 7, 3, 85000.00, 255000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(234, 102, 82, 2, 66000.00, 132000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(235, 102, 76, 1, 80000.00, 80000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(236, 102, 69, 2, 101000.00, 202000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(237, 103, 8, 4, 248000.00, 992000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(238, 104, 51, 4, 299000.00, 1196000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(239, 104, 47, 3, 188000.00, 564000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(240, 104, 90, 1, 246000.00, 246000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(241, 104, 83, 2, 104000.00, 208000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(242, 105, 20, 4, 99000.00, 396000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(243, 105, 22, 5, 267000.00, 1335000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(244, 105, 72, 5, 222000.00, 1110000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(245, 106, 100, 3, 287000.00, 861000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(246, 107, 20, 3, 99000.00, 297000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(247, 107, 72, 3, 222000.00, 666000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(248, 107, 22, 2, 267000.00, 534000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(249, 108, 55, 3, 104000.00, 312000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(250, 108, 8, 5, 248000.00, 1240000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(251, 109, 43, 1, 278000.00, 278000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(252, 110, 74, 3, 208000.00, 624000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(253, 110, 31, 2, 28000.00, 56000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(254, 110, 28, 4, 49000.00, 196000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(255, 111, 60, 5, 44000.00, 220000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(256, 112, 89, 2, 195000.00, 390000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(257, 112, 73, 3, 196000.00, 588000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(258, 113, 59, 1, 257000.00, 257000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(259, 113, 23, 1, 75000.00, 75000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(260, 113, 93, 5, 169000.00, 845000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(261, 114, 72, 1, 222000.00, 222000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(262, 114, 20, 3, 99000.00, 297000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(263, 115, 68, 2, 211000.00, 422000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(264, 115, 7, 4, 85000.00, 340000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(265, 116, 50, 4, 233000.00, 932000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(266, 117, 41, 3, 241000.00, 723000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(267, 118, 60, 1, 44000.00, 44000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(268, 119, 13, 3, 36000.00, 108000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(269, 120, 8, 4, 248000.00, 992000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(270, 121, 68, 5, 211000.00, 1055000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(271, 121, 7, 4, 85000.00, 340000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(272, 122, 68, 5, 211000.00, 1055000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(273, 123, 28, 5, 49000.00, 245000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(274, 123, 74, 3, 208000.00, 624000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(275, 124, 36, 1, 116000.00, 116000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(276, 125, 60, 3, 44000.00, 132000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(277, 126, 72, 1, 222000.00, 222000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(278, 126, 22, 5, 267000.00, 1335000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(279, 127, 19, 4, 198000.00, 792000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(280, 127, 53, 2, 233000.00, 466000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(281, 127, 50, 5, 233000.00, 1165000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(282, 127, 52, 2, 30000.00, 60000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(283, 128, 12, 4, 158000.00, 632000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(284, 128, 78, 4, 234000.00, 936000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(285, 129, 82, 4, 66000.00, 264000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(286, 129, 69, 1, 101000.00, 101000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(287, 129, 76, 4, 80000.00, 320000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(288, 130, 100, 5, 287000.00, 1435000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(289, 130, 39, 5, 179000.00, 895000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(290, 131, 17, 2, 45000.00, 90000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(291, 131, 56, 2, 178000.00, 356000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(292, 131, 35, 5, 38000.00, 190000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(293, 131, 29, 2, 195000.00, 390000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(294, 132, 36, 3, 116000.00, 348000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(295, 132, 88, 5, 173000.00, 865000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(296, 133, 23, 2, 75000.00, 150000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(297, 134, 72, 1, 222000.00, 222000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(298, 135, 99, 2, 84000.00, 168000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(299, 135, 81, 3, 85000.00, 255000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(300, 136, 60, 5, 44000.00, 220000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(301, 137, 90, 5, 246000.00, 1230000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(302, 137, 51, 3, 299000.00, 897000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(303, 137, 47, 5, 188000.00, 940000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(304, 137, 86, 4, 264000.00, 1056000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(305, 138, 8, 2, 248000.00, 496000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(306, 139, 97, 5, 17000.00, 85000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(307, 140, 100, 5, 287000.00, 1435000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(308, 140, 39, 3, 179000.00, 537000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(309, 141, 68, 5, 211000.00, 1055000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(310, 141, 7, 2, 85000.00, 170000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(311, 142, 28, 2, 49000.00, 98000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(312, 143, 96, 2, 150000.00, 300000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(313, 144, 8, 4, 248000.00, 992000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(314, 145, 44, 1, 123000.00, 123000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(315, 145, 42, 5, 53000.00, 265000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(316, 146, 18, 3, 87000.00, 261000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(317, 146, 81, 3, 85000.00, 255000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(318, 146, 99, 4, 84000.00, 336000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(319, 147, 20, 3, 99000.00, 297000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(320, 147, 72, 5, 222000.00, 1110000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(321, 147, 22, 5, 267000.00, 1335000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(322, 148, 81, 1, 85000.00, 85000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(323, 148, 99, 3, 84000.00, 252000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(324, 148, 18, 1, 87000.00, 87000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(325, 149, 47, 5, 188000.00, 940000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(326, 150, 84, 1, 286000.00, 286000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(327, 151, 100, 4, 287000.00, 1148000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(328, 151, 39, 3, 179000.00, 537000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(329, 152, 90, 1, 246000.00, 246000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(330, 152, 86, 4, 264000.00, 1056000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(331, 152, 47, 4, 188000.00, 752000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(332, 152, 83, 4, 104000.00, 416000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(333, 153, 65, 5, 145000.00, 725000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(334, 154, 36, 1, 116000.00, 116000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(335, 154, 80, 5, 243000.00, 1215000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(336, 154, 88, 4, 173000.00, 692000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(337, 155, 1, 5, 290000.00, 1450000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(338, 156, 23, 1, 75000.00, 75000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(339, 156, 40, 3, 176000.00, 528000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(340, 156, 79, 3, 234000.00, 702000.00, '2025-06-15 09:49:37', '2025-06-15 09:49:37'),
(341, 156, 59, 2, 257000.00, 514000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(342, 157, 60, 3, 44000.00, 132000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(343, 158, 32, 4, 279000.00, 1116000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(344, 158, 65, 4, 145000.00, 580000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(345, 158, 92, 1, 28000.00, 28000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(346, 158, 27, 4, 207000.00, 828000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(347, 159, 22, 4, 267000.00, 1068000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(348, 159, 20, 4, 99000.00, 396000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(349, 159, 72, 3, 222000.00, 666000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(350, 160, 80, 2, 243000.00, 486000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(351, 160, 88, 4, 173000.00, 692000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(352, 160, 36, 2, 116000.00, 232000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(353, 161, 8, 2, 248000.00, 496000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(354, 162, 71, 2, 106000.00, 212000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(355, 163, 7, 2, 85000.00, 170000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(356, 163, 68, 1, 211000.00, 211000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(357, 164, 76, 2, 80000.00, 160000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(358, 165, 7, 2, 85000.00, 170000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(359, 165, 68, 1, 211000.00, 211000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(360, 166, 41, 2, 241000.00, 482000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(361, 166, 13, 4, 36000.00, 144000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(362, 166, 9, 5, 84000.00, 420000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(363, 167, 100, 2, 287000.00, 574000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(364, 167, 39, 1, 179000.00, 179000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(365, 168, 19, 1, 198000.00, 198000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(366, 169, 92, 5, 28000.00, 140000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(367, 169, 65, 3, 145000.00, 435000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(368, 170, 19, 2, 198000.00, 396000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(369, 170, 50, 3, 233000.00, 699000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(370, 171, 80, 1, 243000.00, 243000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(371, 171, 88, 1, 173000.00, 173000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(372, 171, 36, 2, 116000.00, 232000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(373, 172, 36, 4, 116000.00, 464000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(374, 173, 13, 2, 36000.00, 72000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(375, 173, 41, 3, 241000.00, 723000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(376, 173, 9, 5, 84000.00, 420000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(377, 174, 42, 4, 53000.00, 212000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(378, 174, 96, 4, 150000.00, 600000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(379, 174, 21, 2, 280000.00, 560000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(380, 175, 59, 5, 257000.00, 1285000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(381, 175, 23, 5, 75000.00, 375000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(382, 175, 79, 1, 234000.00, 234000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(383, 175, 40, 4, 176000.00, 704000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(384, 176, 76, 4, 80000.00, 320000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(385, 177, 97, 3, 17000.00, 51000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(386, 177, 15, 2, 294000.00, 588000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(387, 178, 39, 3, 179000.00, 537000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(388, 178, 100, 5, 287000.00, 1435000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(389, 179, 26, 5, 47000.00, 235000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(390, 180, 14, 5, 261000.00, 1305000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(391, 180, 48, 4, 182000.00, 728000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(392, 180, 17, 3, 45000.00, 135000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(393, 180, 29, 5, 195000.00, 975000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(394, 181, 81, 2, 85000.00, 170000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(395, 181, 18, 3, 87000.00, 261000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(396, 182, 71, 2, 106000.00, 212000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(397, 182, 45, 2, 138000.00, 276000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(398, 182, 98, 3, 125000.00, 375000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(399, 183, 96, 1, 150000.00, 150000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(400, 183, 21, 1, 280000.00, 280000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(401, 183, 44, 4, 123000.00, 492000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(402, 184, 73, 2, 196000.00, 392000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(403, 185, 100, 2, 287000.00, 574000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(404, 186, 64, 4, 243000.00, 972000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(405, 187, 8, 2, 248000.00, 496000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(406, 188, 78, 2, 234000.00, 468000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(407, 188, 12, 5, 158000.00, 790000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(408, 189, 76, 2, 80000.00, 160000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(409, 190, 12, 1, 158000.00, 158000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(410, 191, 27, 3, 207000.00, 621000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(411, 191, 26, 3, 47000.00, 141000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(412, 191, 65, 4, 145000.00, 580000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(413, 191, 37, 4, 271000.00, 1084000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(414, 192, 27, 2, 207000.00, 414000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(415, 192, 65, 1, 145000.00, 145000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(416, 192, 26, 5, 47000.00, 235000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(417, 193, 96, 1, 150000.00, 150000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(418, 193, 89, 1, 195000.00, 195000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(419, 193, 11, 4, 191000.00, 764000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(420, 193, 21, 4, 280000.00, 1120000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(421, 194, 33, 5, 74000.00, 370000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(422, 194, 6, 2, 206000.00, 412000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(423, 194, 43, 4, 278000.00, 1112000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(424, 195, 33, 5, 74000.00, 370000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(425, 196, 13, 3, 36000.00, 108000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(426, 196, 9, 5, 84000.00, 420000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(427, 196, 41, 3, 241000.00, 723000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(428, 197, 80, 5, 243000.00, 1215000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(429, 197, 88, 5, 173000.00, 865000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(430, 197, 36, 1, 116000.00, 116000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(431, 198, 8, 1, 248000.00, 248000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(432, 199, 8, 2, 248000.00, 496000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(433, 200, 83, 2, 104000.00, 208000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(434, 200, 47, 1, 188000.00, 188000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(435, 200, 51, 1, 299000.00, 299000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(436, 201, 89, 2, 195000.00, 390000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(437, 201, 42, 2, 53000.00, 106000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(438, 201, 11, 1, 191000.00, 191000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(439, 202, 60, 3, 44000.00, 132000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(440, 203, 79, 1, 234000.00, 234000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(441, 204, 36, 1, 116000.00, 116000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(442, 205, 98, 5, 125000.00, 625000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(443, 205, 71, 1, 106000.00, 106000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(444, 206, 37, 5, 271000.00, 1355000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(445, 207, 81, 5, 85000.00, 425000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(446, 208, 34, 4, 55000.00, 220000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(447, 209, 43, 5, 278000.00, 1390000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(448, 210, 51, 2, 299000.00, 598000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(449, 211, 76, 5, 80000.00, 400000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(450, 212, 40, 5, 176000.00, 880000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(451, 212, 79, 5, 234000.00, 1170000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(452, 213, 9, 3, 84000.00, 252000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(453, 213, 41, 4, 241000.00, 964000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(454, 213, 13, 2, 36000.00, 72000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(455, 214, 29, 5, 195000.00, 975000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(456, 214, 17, 2, 45000.00, 90000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(457, 214, 56, 5, 178000.00, 890000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(458, 214, 95, 4, 121000.00, 484000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(459, 215, 40, 2, 176000.00, 352000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(460, 215, 59, 2, 257000.00, 514000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(461, 216, 47, 5, 188000.00, 940000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(462, 216, 83, 3, 104000.00, 312000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(463, 216, 86, 5, 264000.00, 1320000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(464, 216, 90, 5, 246000.00, 1230000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(465, 217, 11, 3, 191000.00, 573000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(466, 217, 42, 3, 53000.00, 159000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(467, 218, 78, 1, 234000.00, 234000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(468, 218, 12, 2, 158000.00, 316000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(469, 219, 22, 5, 267000.00, 1335000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(470, 219, 72, 5, 222000.00, 1110000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(471, 220, 47, 4, 188000.00, 752000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(472, 220, 86, 5, 264000.00, 1320000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(473, 221, 12, 1, 158000.00, 158000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(474, 221, 78, 1, 234000.00, 234000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(475, 222, 100, 4, 287000.00, 1148000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(476, 222, 39, 5, 179000.00, 895000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(477, 223, 18, 1, 87000.00, 87000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(478, 223, 99, 4, 84000.00, 336000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(479, 224, 34, 1, 55000.00, 55000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(480, 224, 53, 5, 233000.00, 1165000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(481, 225, 45, 2, 138000.00, 276000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(482, 225, 98, 3, 125000.00, 375000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(483, 225, 71, 5, 106000.00, 530000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(484, 227, 45, 5, 138000.00, 690000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(485, 227, 71, 5, 106000.00, 530000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(486, 228, 9, 1, 84000.00, 84000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(487, 229, 91, 5, 215000.00, 1075000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(488, 230, 78, 2, 234000.00, 468000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(489, 230, 12, 1, 158000.00, 158000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(490, 231, 78, 3, 234000.00, 702000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(491, 231, 12, 1, 158000.00, 158000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(492, 232, 95, 1, 121000.00, 121000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(493, 232, 35, 4, 38000.00, 152000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(494, 232, 16, 2, 161000.00, 322000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(495, 233, 32, 4, 279000.00, 1116000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(496, 233, 65, 3, 145000.00, 435000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(497, 234, 18, 5, 87000.00, 435000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(498, 236, 36, 1, 116000.00, 116000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(499, 237, 68, 2, 211000.00, 422000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(500, 237, 7, 3, 85000.00, 255000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(501, 239, 36, 3, 116000.00, 348000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(502, 240, 71, 5, 106000.00, 530000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(503, 241, 22, 3, 267000.00, 801000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(504, 241, 72, 3, 222000.00, 666000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(505, 242, 71, 5, 106000.00, 530000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(506, 242, 98, 5, 125000.00, 625000.00, '2025-06-15 09:49:38', '2025-06-15 09:49:38'),
(507, 242, 45, 4, 138000.00, 552000.00, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(508, 244, 52, 1, 30000.00, 30000.00, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(509, 244, 50, 1, 233000.00, 233000.00, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(510, 246, 12, 5, 158000.00, 790000.00, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(511, 246, 78, 1, 234000.00, 234000.00, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(512, 247, 28, 1, 49000.00, 49000.00, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(513, 247, 74, 5, 208000.00, 1040000.00, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(514, 248, 40, 4, 176000.00, 704000.00, '2025-06-15 09:49:39', '2025-06-15 09:49:39'),
(515, 250, 53, 2, 233000.00, 466000.00, '2025-06-15 09:49:39', '2025-06-15 09:49:39');

--
-- Triggers `saleitem`
--
DELIMITER $$
CREATE TRIGGER `after_saleitem_insert` AFTER INSERT ON `saleitem` FOR EACH ROW BEGIN
                DECLARE sale_outlet_id INT;

                -- 1. Ambil ID outlet dari tabel `sale` yang berelasi
                SELECT `outlet_id` INTO sale_outlet_id 
                FROM `sale` 
                WHERE `id` = NEW.sale_id;

                -- 2. Kurangi stok di tabel `product`
                UPDATE `product`
                SET `stok` = `stok` - NEW.quantity
                WHERE `id` = NEW.product_id;

                -- 3. Buat catatan baru di tabel `stockmutation`
                INSERT INTO `stockmutation` (
                    `product_id`, `outlet_id`, `quantity`, `type`, 
                    `reference_type`, `reference_id`, `created_at`, `updated_at`
                )
                VALUES (
                    NEW.product_id, sale_outlet_id, NEW.quantity, "out", 
                    "sale", NEW.sale_id, NOW(), NOW()
                );
            END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stockmutation`
--

CREATE TABLE `stockmutation` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `outlet_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `type` enum('in','out') NOT NULL,
  `reference_type` enum('purchase','sale','adjustment') NOT NULL,
  `reference_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stockmutation`
--

INSERT INTO `stockmutation` (`id`, `product_id`, `outlet_id`, `quantity`, `type`, `reference_type`, `reference_id`, `created_at`, `updated_at`) VALUES
(1, 100, 19, 1, 'out', 'sale', 1, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(2, 100, 19, 1, 'out', 'sale', 1, '2025-02-05 13:07:12', '2025-02-05 13:07:12'),
(3, 39, 19, 3, 'out', 'sale', 1, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(4, 39, 19, 3, 'out', 'sale', 1, '2025-02-05 13:07:12', '2025-02-05 13:07:12'),
(5, 5, 19, 1, 'out', 'sale', 1, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(6, 5, 19, 1, 'out', 'sale', 1, '2025-02-05 13:07:12', '2025-02-05 13:07:12'),
(7, 10, 19, 1, 'out', 'sale', 1, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(8, 10, 19, 1, 'out', 'sale', 1, '2025-02-05 13:07:12', '2025-02-05 13:07:12'),
(9, 80, 15, 1, 'out', 'sale', 2, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(10, 80, 15, 1, 'out', 'sale', 2, '2024-11-09 18:01:42', '2024-11-09 18:01:42'),
(11, 24, 15, 4, 'out', 'sale', 2, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(12, 24, 15, 4, 'out', 'sale', 2, '2024-11-09 18:01:42', '2024-11-09 18:01:42'),
(13, 36, 15, 2, 'out', 'sale', 2, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(14, 36, 15, 2, 'out', 'sale', 2, '2024-11-09 18:01:42', '2024-11-09 18:01:42'),
(15, 88, 15, 5, 'out', 'sale', 2, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(16, 88, 15, 5, 'out', 'sale', 2, '2024-11-09 18:01:42', '2024-11-09 18:01:42'),
(17, 93, 5, 5, 'out', 'sale', 3, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(18, 93, 5, 5, 'out', 'sale', 3, '2025-04-29 02:27:44', '2025-04-29 02:27:44'),
(19, 10, 19, 4, 'out', 'sale', 4, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(20, 10, 19, 4, 'out', 'sale', 4, '2024-09-14 10:08:09', '2024-09-14 10:08:09'),
(21, 5, 19, 3, 'out', 'sale', 4, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(22, 5, 19, 3, 'out', 'sale', 4, '2024-09-14 10:08:09', '2024-09-14 10:08:09'),
(23, 3, 19, 1, 'out', 'sale', 4, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(24, 3, 19, 1, 'out', 'sale', 4, '2024-09-14 10:08:09', '2024-09-14 10:08:09'),
(25, 39, 19, 3, 'out', 'sale', 4, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(26, 39, 19, 3, 'out', 'sale', 4, '2024-09-14 10:08:09', '2024-09-14 10:08:09'),
(27, 75, 3, 3, 'out', 'sale', 5, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(28, 75, 3, 3, 'out', 'sale', 5, '2025-01-05 12:11:41', '2025-01-05 12:11:41'),
(29, 7, 17, 3, 'out', 'sale', 6, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(30, 7, 17, 3, 'out', 'sale', 6, '2024-07-28 21:54:21', '2024-07-28 21:54:21'),
(31, 32, 7, 4, 'out', 'sale', 7, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(32, 32, 7, 4, 'out', 'sale', 7, '2025-03-16 04:23:45', '2025-03-16 04:23:45'),
(33, 13, 14, 1, 'out', 'sale', 8, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(34, 13, 14, 1, 'out', 'sale', 8, '2025-01-21 14:31:46', '2025-01-21 14:31:46'),
(35, 9, 14, 5, 'out', 'sale', 8, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(36, 9, 14, 5, 'out', 'sale', 8, '2025-01-21 14:31:46', '2025-01-21 14:31:46'),
(37, 38, 14, 1, 'out', 'sale', 8, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(38, 38, 14, 1, 'out', 'sale', 8, '2025-01-21 14:31:46', '2025-01-21 14:31:46'),
(39, 41, 14, 4, 'out', 'sale', 8, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(40, 41, 14, 4, 'out', 'sale', 8, '2025-01-21 14:31:46', '2025-01-21 14:31:46'),
(41, 33, 1, 5, 'out', 'sale', 9, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(42, 33, 1, 5, 'out', 'sale', 9, '2025-04-05 06:59:25', '2025-04-05 06:59:25'),
(43, 66, 1, 3, 'out', 'sale', 9, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(44, 66, 1, 3, 'out', 'sale', 9, '2025-04-05 06:59:25', '2025-04-05 06:59:25'),
(45, 25, 1, 5, 'out', 'sale', 9, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(46, 25, 1, 5, 'out', 'sale', 9, '2025-04-05 06:59:25', '2025-04-05 06:59:25'),
(47, 24, 15, 2, 'out', 'sale', 10, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(48, 24, 15, 2, 'out', 'sale', 10, '2024-10-25 04:27:46', '2024-10-25 04:27:46'),
(49, 36, 15, 1, 'out', 'sale', 10, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(50, 36, 15, 1, 'out', 'sale', 10, '2024-10-25 04:27:46', '2024-10-25 04:27:46'),
(51, 27, 7, 3, 'out', 'sale', 11, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(52, 27, 7, 3, 'out', 'sale', 11, '2025-04-02 18:28:20', '2025-04-02 18:28:20'),
(53, 65, 7, 1, 'out', 'sale', 11, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(54, 65, 7, 1, 'out', 'sale', 11, '2025-04-02 18:28:20', '2025-04-02 18:28:20'),
(55, 37, 7, 4, 'out', 'sale', 11, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(56, 37, 7, 4, 'out', 'sale', 11, '2025-04-02 18:28:20', '2025-04-02 18:28:20'),
(57, 69, 6, 1, 'out', 'sale', 12, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(58, 69, 6, 1, 'out', 'sale', 12, '2024-10-12 12:03:39', '2024-10-12 12:03:39'),
(59, 76, 6, 1, 'out', 'sale', 12, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(60, 76, 6, 1, 'out', 'sale', 12, '2024-10-12 12:03:39', '2024-10-12 12:03:39'),
(61, 82, 6, 1, 'out', 'sale', 12, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(62, 82, 6, 1, 'out', 'sale', 12, '2024-10-12 12:03:39', '2024-10-12 12:03:39'),
(63, 68, 17, 5, 'out', 'sale', 13, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(64, 68, 17, 5, 'out', 'sale', 13, '2024-07-31 02:56:58', '2024-07-31 02:56:58'),
(65, 7, 17, 3, 'out', 'sale', 13, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(66, 7, 17, 3, 'out', 'sale', 13, '2024-07-31 02:56:58', '2024-07-31 02:56:58'),
(67, 12, 9, 5, 'out', 'sale', 14, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(68, 12, 9, 5, 'out', 'sale', 14, '2024-07-08 16:37:19', '2024-07-08 16:37:19'),
(69, 78, 9, 4, 'out', 'sale', 14, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(70, 78, 9, 4, 'out', 'sale', 14, '2024-07-08 16:37:19', '2024-07-08 16:37:19'),
(71, 49, 9, 3, 'out', 'sale', 14, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(72, 49, 9, 3, 'out', 'sale', 14, '2024-07-08 16:37:19', '2024-07-08 16:37:19'),
(73, 55, 13, 3, 'out', 'sale', 15, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(74, 55, 13, 3, 'out', 'sale', 15, '2024-11-20 20:26:01', '2024-11-20 20:26:01'),
(75, 85, 13, 3, 'out', 'sale', 15, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(76, 85, 13, 3, 'out', 'sale', 15, '2024-11-20 20:26:01', '2024-11-20 20:26:01'),
(77, 92, 7, 3, 'out', 'sale', 16, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(78, 92, 7, 3, 'out', 'sale', 16, '2025-05-28 19:35:28', '2025-05-28 19:35:28'),
(79, 65, 7, 4, 'out', 'sale', 16, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(80, 65, 7, 4, 'out', 'sale', 16, '2025-05-28 19:35:28', '2025-05-28 19:35:28'),
(81, 85, 13, 5, 'out', 'sale', 17, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(82, 85, 13, 5, 'out', 'sale', 17, '2024-08-27 06:58:01', '2024-08-27 06:58:01'),
(83, 55, 13, 5, 'out', 'sale', 17, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(84, 55, 13, 5, 'out', 'sale', 17, '2024-08-27 06:58:01', '2024-08-27 06:58:01'),
(85, 8, 13, 5, 'out', 'sale', 17, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(86, 8, 13, 5, 'out', 'sale', 17, '2024-08-27 06:58:01', '2024-08-27 06:58:01'),
(87, 31, 4, 3, 'out', 'sale', 18, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(88, 31, 4, 3, 'out', 'sale', 18, '2024-09-09 14:25:30', '2024-09-09 14:25:30'),
(89, 60, 2, 3, 'out', 'sale', 19, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(90, 60, 2, 3, 'out', 'sale', 19, '2024-11-03 20:35:34', '2024-11-03 20:35:34'),
(91, 61, 2, 2, 'out', 'sale', 19, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(92, 61, 2, 2, 'out', 'sale', 19, '2024-11-03 20:35:34', '2024-11-03 20:35:34'),
(93, 39, 19, 3, 'out', 'sale', 20, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(94, 39, 19, 3, 'out', 'sale', 20, '2024-11-25 11:47:44', '2024-11-25 11:47:44'),
(95, 10, 19, 1, 'out', 'sale', 20, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(96, 10, 19, 1, 'out', 'sale', 20, '2024-11-25 11:47:44', '2024-11-25 11:47:44'),
(97, 3, 19, 4, 'out', 'sale', 20, '2025-06-15 16:49:35', '2025-06-15 16:49:35'),
(98, 3, 19, 4, 'out', 'sale', 20, '2024-11-25 11:47:44', '2024-11-25 11:47:44'),
(99, 74, 4, 2, 'out', 'sale', 21, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(100, 74, 4, 2, 'out', 'sale', 21, '2024-10-11 18:47:59', '2024-10-11 18:47:59'),
(101, 94, 4, 3, 'out', 'sale', 21, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(102, 94, 4, 3, 'out', 'sale', 21, '2024-10-11 18:47:59', '2024-10-11 18:47:59'),
(103, 31, 4, 5, 'out', 'sale', 21, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(104, 31, 4, 5, 'out', 'sale', 21, '2024-10-11 18:47:59', '2024-10-11 18:47:59'),
(105, 94, 4, 3, 'out', 'sale', 22, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(106, 94, 4, 3, 'out', 'sale', 22, '2024-10-05 02:48:57', '2024-10-05 02:48:57'),
(107, 28, 4, 1, 'out', 'sale', 22, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(108, 28, 4, 1, 'out', 'sale', 22, '2024-10-05 02:48:57', '2024-10-05 02:48:57'),
(109, 31, 4, 2, 'out', 'sale', 22, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(110, 31, 4, 2, 'out', 'sale', 22, '2024-10-05 02:48:57', '2024-10-05 02:48:57'),
(111, 74, 4, 3, 'out', 'sale', 22, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(112, 74, 4, 3, 'out', 'sale', 22, '2024-10-05 02:48:57', '2024-10-05 02:48:57'),
(113, 80, 15, 3, 'out', 'sale', 23, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(114, 80, 15, 3, 'out', 'sale', 23, '2024-10-05 21:03:26', '2024-10-05 21:03:26'),
(115, 24, 15, 4, 'out', 'sale', 23, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(116, 24, 15, 4, 'out', 'sale', 23, '2024-10-05 21:03:26', '2024-10-05 21:03:26'),
(117, 88, 15, 2, 'out', 'sale', 23, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(118, 88, 15, 2, 'out', 'sale', 23, '2024-10-05 21:03:26', '2024-10-05 21:03:26'),
(119, 30, 5, 2, 'out', 'sale', 24, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(120, 30, 5, 2, 'out', 'sale', 24, '2025-05-12 10:55:40', '2025-05-12 10:55:40'),
(121, 59, 5, 4, 'out', 'sale', 24, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(122, 59, 5, 4, 'out', 'sale', 24, '2025-05-12 10:55:40', '2025-05-12 10:55:40'),
(123, 46, 20, 4, 'out', 'sale', 25, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(124, 46, 20, 4, 'out', 'sale', 25, '2024-07-25 07:53:05', '2024-07-25 07:53:05'),
(125, 17, 8, 2, 'out', 'sale', 26, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(126, 17, 8, 2, 'out', 'sale', 26, '2025-04-17 11:31:01', '2025-04-17 11:31:01'),
(127, 6, 1, 3, 'out', 'sale', 27, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(128, 6, 1, 3, 'out', 'sale', 27, '2024-10-19 03:58:51', '2024-10-19 03:58:51'),
(129, 33, 1, 4, 'out', 'sale', 27, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(130, 33, 1, 4, 'out', 'sale', 27, '2024-10-19 03:58:51', '2024-10-19 03:58:51'),
(131, 66, 1, 5, 'out', 'sale', 27, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(132, 66, 1, 5, 'out', 'sale', 27, '2024-10-19 03:58:51', '2024-10-19 03:58:51'),
(133, 25, 1, 4, 'out', 'sale', 27, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(134, 25, 1, 4, 'out', 'sale', 27, '2024-10-19 03:58:51', '2024-10-19 03:58:51'),
(135, 36, 15, 4, 'out', 'sale', 28, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(136, 36, 15, 4, 'out', 'sale', 28, '2024-11-20 05:26:39', '2024-11-20 05:26:39'),
(137, 24, 15, 1, 'out', 'sale', 28, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(138, 24, 15, 1, 'out', 'sale', 28, '2024-11-20 05:26:39', '2024-11-20 05:26:39'),
(139, 80, 15, 1, 'out', 'sale', 28, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(140, 80, 15, 1, 'out', 'sale', 28, '2024-11-20 05:26:39', '2024-11-20 05:26:39'),
(141, 100, 19, 3, 'out', 'sale', 29, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(142, 100, 19, 3, 'out', 'sale', 29, '2024-07-22 01:26:58', '2024-07-22 01:26:58'),
(143, 5, 19, 5, 'out', 'sale', 29, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(144, 5, 19, 5, 'out', 'sale', 29, '2024-07-22 01:26:58', '2024-07-22 01:26:58'),
(145, 10, 19, 4, 'out', 'sale', 29, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(146, 10, 19, 4, 'out', 'sale', 29, '2024-07-22 01:26:58', '2024-07-22 01:26:58'),
(147, 39, 19, 4, 'out', 'sale', 29, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(148, 39, 19, 4, 'out', 'sale', 29, '2024-07-22 01:26:58', '2024-07-22 01:26:58'),
(149, 39, 19, 4, 'out', 'sale', 30, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(150, 39, 19, 4, 'out', 'sale', 30, '2025-02-24 13:00:09', '2025-02-24 13:00:09'),
(151, 54, 7, 3, 'out', 'sale', 31, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(152, 54, 7, 3, 'out', 'sale', 31, '2024-11-06 00:20:00', '2024-11-06 00:20:00'),
(153, 65, 7, 5, 'out', 'sale', 31, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(154, 65, 7, 5, 'out', 'sale', 31, '2024-11-06 00:20:00', '2024-11-06 00:20:00'),
(155, 32, 7, 4, 'out', 'sale', 31, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(156, 32, 7, 4, 'out', 'sale', 31, '2024-11-06 00:20:00', '2024-11-06 00:20:00'),
(157, 8, 13, 2, 'out', 'sale', 32, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(158, 8, 13, 2, 'out', 'sale', 32, '2025-06-02 10:25:27', '2025-06-02 10:25:27'),
(159, 55, 13, 5, 'out', 'sale', 32, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(160, 55, 13, 5, 'out', 'sale', 32, '2025-06-02 10:25:27', '2025-06-02 10:25:27'),
(161, 74, 4, 4, 'out', 'sale', 33, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(162, 74, 4, 4, 'out', 'sale', 33, '2024-07-10 00:53:49', '2024-07-10 00:53:49'),
(163, 31, 4, 5, 'out', 'sale', 33, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(164, 31, 4, 5, 'out', 'sale', 33, '2024-07-10 00:53:49', '2024-07-10 00:53:49'),
(165, 94, 4, 2, 'out', 'sale', 33, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(166, 94, 4, 2, 'out', 'sale', 33, '2024-07-10 00:53:49', '2024-07-10 00:53:49'),
(167, 16, 8, 2, 'out', 'sale', 34, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(168, 16, 8, 2, 'out', 'sale', 34, '2025-05-30 06:46:48', '2025-05-30 06:46:48'),
(169, 56, 8, 4, 'out', 'sale', 34, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(170, 56, 8, 4, 'out', 'sale', 34, '2025-05-30 06:46:48', '2025-05-30 06:46:48'),
(171, 67, 8, 3, 'out', 'sale', 34, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(172, 67, 8, 3, 'out', 'sale', 34, '2025-05-30 06:46:48', '2025-05-30 06:46:48'),
(173, 66, 1, 4, 'out', 'sale', 35, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(174, 66, 1, 4, 'out', 'sale', 35, '2025-03-10 02:48:35', '2025-03-10 02:48:35'),
(175, 43, 1, 1, 'out', 'sale', 35, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(176, 43, 1, 1, 'out', 'sale', 35, '2025-03-10 02:48:35', '2025-03-10 02:48:35'),
(177, 75, 3, 1, 'out', 'sale', 36, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(178, 75, 3, 1, 'out', 'sale', 36, '2024-08-27 09:14:17', '2024-08-27 09:14:17'),
(179, 73, 3, 3, 'out', 'sale', 36, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(180, 73, 3, 3, 'out', 'sale', 36, '2024-08-27 09:14:17', '2024-08-27 09:14:17'),
(181, 11, 3, 1, 'out', 'sale', 36, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(182, 11, 3, 1, 'out', 'sale', 36, '2024-08-27 09:14:17', '2024-08-27 09:14:17'),
(183, 55, 13, 1, 'out', 'sale', 37, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(184, 55, 13, 1, 'out', 'sale', 37, '2025-05-09 20:00:11', '2025-05-09 20:00:11'),
(185, 8, 13, 4, 'out', 'sale', 37, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(186, 8, 13, 4, 'out', 'sale', 37, '2025-05-09 20:00:11', '2025-05-09 20:00:11'),
(187, 62, 12, 4, 'out', 'sale', 38, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(188, 62, 12, 4, 'out', 'sale', 38, '2025-06-10 09:33:50', '2025-06-10 09:33:50'),
(189, 63, 12, 2, 'out', 'sale', 38, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(190, 63, 12, 2, 'out', 'sale', 38, '2025-06-10 09:33:50', '2025-06-10 09:33:50'),
(191, 43, 1, 1, 'out', 'sale', 39, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(192, 43, 1, 1, 'out', 'sale', 39, '2024-09-13 14:48:01', '2024-09-13 14:48:01'),
(193, 6, 1, 4, 'out', 'sale', 39, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(194, 6, 1, 4, 'out', 'sale', 39, '2024-09-13 14:48:01', '2024-09-13 14:48:01'),
(195, 33, 1, 3, 'out', 'sale', 39, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(196, 33, 1, 3, 'out', 'sale', 39, '2024-09-13 14:48:01', '2024-09-13 14:48:01'),
(197, 98, 11, 5, 'out', 'sale', 40, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(198, 98, 11, 5, 'out', 'sale', 40, '2025-04-01 00:12:22', '2025-04-01 00:12:22'),
(199, 70, 11, 3, 'out', 'sale', 40, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(200, 70, 11, 3, 'out', 'sale', 40, '2025-04-01 00:12:22', '2025-04-01 00:12:22'),
(201, 97, 11, 4, 'out', 'sale', 40, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(202, 97, 11, 4, 'out', 'sale', 40, '2025-04-01 00:12:22', '2025-04-01 00:12:22'),
(203, 41, 14, 1, 'out', 'sale', 41, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(204, 41, 14, 1, 'out', 'sale', 41, '2024-07-27 16:31:33', '2024-07-27 16:31:33'),
(205, 13, 14, 1, 'out', 'sale', 41, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(206, 13, 14, 1, 'out', 'sale', 41, '2024-07-27 16:31:33', '2024-07-27 16:31:33'),
(207, 9, 14, 2, 'out', 'sale', 41, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(208, 9, 14, 2, 'out', 'sale', 41, '2024-07-27 16:31:33', '2024-07-27 16:31:33'),
(209, 93, 5, 1, 'out', 'sale', 42, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(210, 93, 5, 1, 'out', 'sale', 42, '2024-12-06 12:17:09', '2024-12-06 12:17:09'),
(211, 30, 5, 3, 'out', 'sale', 42, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(212, 30, 5, 3, 'out', 'sale', 42, '2024-12-06 12:17:09', '2024-12-06 12:17:09'),
(213, 23, 5, 4, 'out', 'sale', 42, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(214, 23, 5, 4, 'out', 'sale', 42, '2024-12-06 12:17:09', '2024-12-06 12:17:09'),
(215, 81, 16, 4, 'out', 'sale', 43, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(216, 81, 16, 4, 'out', 'sale', 43, '2025-02-08 02:36:03', '2025-02-08 02:36:03'),
(217, 18, 16, 4, 'out', 'sale', 43, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(218, 18, 16, 4, 'out', 'sale', 43, '2025-02-08 02:36:03', '2025-02-08 02:36:03'),
(219, 6, 1, 2, 'out', 'sale', 44, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(220, 6, 1, 2, 'out', 'sale', 44, '2024-08-09 00:13:39', '2024-08-09 00:13:39'),
(221, 1, 12, 4, 'out', 'sale', 45, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(222, 1, 12, 4, 'out', 'sale', 45, '2024-07-19 23:17:42', '2024-07-19 23:17:42'),
(223, 84, 12, 2, 'out', 'sale', 45, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(224, 84, 12, 2, 'out', 'sale', 45, '2024-07-19 23:17:42', '2024-07-19 23:17:42'),
(225, 91, 12, 2, 'out', 'sale', 45, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(226, 91, 12, 2, 'out', 'sale', 45, '2024-07-19 23:17:42', '2024-07-19 23:17:42'),
(227, 80, 15, 3, 'out', 'sale', 46, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(228, 80, 15, 3, 'out', 'sale', 46, '2025-04-17 16:12:06', '2025-04-17 16:12:06'),
(229, 71, 11, 2, 'out', 'sale', 47, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(230, 71, 11, 2, 'out', 'sale', 47, '2024-06-21 14:29:17', '2024-06-21 14:29:17'),
(231, 81, 16, 2, 'out', 'sale', 48, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(232, 81, 16, 2, 'out', 'sale', 48, '2024-11-21 03:23:53', '2024-11-21 03:23:53'),
(233, 39, 19, 1, 'out', 'sale', 49, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(234, 39, 19, 1, 'out', 'sale', 49, '2025-03-18 06:00:42', '2025-03-18 06:00:42'),
(235, 79, 5, 5, 'out', 'sale', 50, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(236, 79, 5, 5, 'out', 'sale', 50, '2025-06-14 06:20:28', '2025-06-14 06:20:28'),
(237, 40, 5, 1, 'out', 'sale', 50, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(238, 40, 5, 1, 'out', 'sale', 50, '2025-06-14 06:20:28', '2025-06-14 06:20:28'),
(239, 35, 8, 1, 'out', 'sale', 51, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(240, 35, 8, 1, 'out', 'sale', 51, '2025-03-19 23:35:08', '2025-03-19 23:35:08'),
(241, 2, 18, 3, 'out', 'sale', 52, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(242, 2, 18, 3, 'out', 'sale', 52, '2024-10-24 06:48:36', '2024-10-24 06:48:36'),
(243, 35, 8, 4, 'out', 'sale', 53, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(244, 35, 8, 4, 'out', 'sale', 53, '2025-01-09 13:40:59', '2025-01-09 13:40:59'),
(245, 17, 8, 5, 'out', 'sale', 53, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(246, 17, 8, 5, 'out', 'sale', 53, '2025-01-09 13:40:59', '2025-01-09 13:40:59'),
(247, 14, 8, 1, 'out', 'sale', 53, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(248, 14, 8, 1, 'out', 'sale', 53, '2025-01-09 13:40:59', '2025-01-09 13:40:59'),
(249, 20, 18, 1, 'out', 'sale', 54, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(250, 20, 18, 1, 'out', 'sale', 54, '2025-06-12 17:32:04', '2025-06-12 17:32:04'),
(251, 92, 7, 5, 'out', 'sale', 55, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(252, 92, 7, 5, 'out', 'sale', 55, '2025-06-05 13:43:21', '2025-06-05 13:43:21'),
(253, 69, 6, 1, 'out', 'sale', 56, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(254, 69, 6, 1, 'out', 'sale', 56, '2025-03-31 10:23:15', '2025-03-31 10:23:15'),
(255, 60, 2, 4, 'out', 'sale', 57, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(256, 60, 2, 4, 'out', 'sale', 57, '2025-05-15 16:43:32', '2025-05-15 16:43:32'),
(257, 61, 2, 3, 'out', 'sale', 57, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(258, 61, 2, 3, 'out', 'sale', 57, '2025-05-15 16:43:32', '2025-05-15 16:43:32'),
(259, 100, 19, 5, 'out', 'sale', 58, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(260, 100, 19, 5, 'out', 'sale', 58, '2024-12-08 03:09:48', '2024-12-08 03:09:48'),
(261, 39, 19, 3, 'out', 'sale', 58, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(262, 39, 19, 3, 'out', 'sale', 58, '2024-12-08 03:09:48', '2024-12-08 03:09:48'),
(263, 66, 1, 2, 'out', 'sale', 59, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(264, 66, 1, 2, 'out', 'sale', 59, '2024-12-08 23:03:06', '2024-12-08 23:03:06'),
(265, 68, 17, 2, 'out', 'sale', 60, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(266, 68, 17, 2, 'out', 'sale', 60, '2024-09-27 15:42:30', '2024-09-27 15:42:30'),
(267, 7, 17, 1, 'out', 'sale', 60, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(268, 7, 17, 1, 'out', 'sale', 60, '2024-09-27 15:42:30', '2024-09-27 15:42:30'),
(269, 40, 5, 4, 'out', 'sale', 61, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(270, 40, 5, 4, 'out', 'sale', 61, '2025-05-31 12:43:40', '2025-05-31 12:43:40'),
(271, 59, 5, 1, 'out', 'sale', 61, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(272, 59, 5, 1, 'out', 'sale', 61, '2025-05-31 12:43:40', '2025-05-31 12:43:40'),
(273, 23, 5, 5, 'out', 'sale', 61, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(274, 23, 5, 5, 'out', 'sale', 61, '2025-05-31 12:43:40', '2025-05-31 12:43:40'),
(275, 93, 5, 3, 'out', 'sale', 61, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(276, 93, 5, 3, 'out', 'sale', 61, '2025-05-31 12:43:40', '2025-05-31 12:43:40'),
(277, 78, 9, 3, 'out', 'sale', 62, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(278, 78, 9, 3, 'out', 'sale', 62, '2025-06-07 17:12:27', '2025-06-07 17:12:27'),
(279, 12, 9, 5, 'out', 'sale', 62, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(280, 12, 9, 5, 'out', 'sale', 62, '2025-06-07 17:12:27', '2025-06-07 17:12:27'),
(281, 58, 6, 4, 'out', 'sale', 63, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(282, 58, 6, 4, 'out', 'sale', 63, '2025-02-19 23:16:31', '2025-02-19 23:16:31'),
(283, 69, 6, 3, 'out', 'sale', 63, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(284, 69, 6, 3, 'out', 'sale', 63, '2025-02-19 23:16:31', '2025-02-19 23:16:31'),
(285, 76, 6, 2, 'out', 'sale', 63, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(286, 76, 6, 2, 'out', 'sale', 63, '2025-02-19 23:16:31', '2025-02-19 23:16:31'),
(287, 82, 6, 1, 'out', 'sale', 63, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(288, 82, 6, 1, 'out', 'sale', 63, '2025-02-19 23:16:31', '2025-02-19 23:16:31'),
(289, 12, 9, 4, 'out', 'sale', 64, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(290, 12, 9, 4, 'out', 'sale', 64, '2025-04-01 23:04:00', '2025-04-01 23:04:00'),
(291, 99, 16, 2, 'out', 'sale', 65, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(292, 99, 16, 2, 'out', 'sale', 65, '2025-02-10 10:03:03', '2025-02-10 10:03:03'),
(293, 18, 16, 1, 'out', 'sale', 65, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(294, 18, 16, 1, 'out', 'sale', 65, '2025-02-10 10:03:03', '2025-02-10 10:03:03'),
(295, 81, 16, 4, 'out', 'sale', 65, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(296, 81, 16, 4, 'out', 'sale', 65, '2025-02-10 10:03:03', '2025-02-10 10:03:03'),
(297, 96, 3, 3, 'out', 'sale', 66, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(298, 96, 3, 3, 'out', 'sale', 66, '2025-04-18 14:13:24', '2025-04-18 14:13:24'),
(299, 75, 3, 4, 'out', 'sale', 66, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(300, 75, 3, 4, 'out', 'sale', 66, '2025-04-18 14:13:24', '2025-04-18 14:13:24'),
(301, 11, 3, 5, 'out', 'sale', 66, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(302, 11, 3, 5, 'out', 'sale', 66, '2025-04-18 14:13:24', '2025-04-18 14:13:24'),
(303, 59, 5, 1, 'out', 'sale', 67, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(304, 59, 5, 1, 'out', 'sale', 67, '2025-03-06 01:57:57', '2025-03-06 01:57:57'),
(305, 68, 17, 4, 'out', 'sale', 68, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(306, 68, 17, 4, 'out', 'sale', 68, '2024-11-05 01:33:43', '2024-11-05 01:33:43'),
(307, 7, 17, 5, 'out', 'sale', 68, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(308, 7, 17, 5, 'out', 'sale', 68, '2024-11-05 01:33:43', '2024-11-05 01:33:43'),
(309, 13, 14, 5, 'out', 'sale', 69, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(310, 13, 14, 5, 'out', 'sale', 69, '2024-10-27 15:13:36', '2024-10-27 15:13:36'),
(311, 9, 14, 2, 'out', 'sale', 69, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(312, 9, 14, 2, 'out', 'sale', 69, '2024-10-27 15:13:36', '2024-10-27 15:13:36'),
(313, 41, 14, 2, 'out', 'sale', 69, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(314, 41, 14, 2, 'out', 'sale', 69, '2024-10-27 15:13:36', '2024-10-27 15:13:36'),
(315, 64, 12, 3, 'out', 'sale', 70, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(316, 64, 12, 3, 'out', 'sale', 70, '2025-05-01 14:36:23', '2025-05-01 14:36:23'),
(317, 1, 12, 3, 'out', 'sale', 70, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(318, 1, 12, 3, 'out', 'sale', 70, '2025-05-01 14:36:23', '2025-05-01 14:36:23'),
(319, 4, 12, 1, 'out', 'sale', 70, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(320, 4, 12, 1, 'out', 'sale', 70, '2025-05-01 14:36:23', '2025-05-01 14:36:23'),
(321, 87, 12, 1, 'out', 'sale', 70, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(322, 87, 12, 1, 'out', 'sale', 70, '2025-05-01 14:36:23', '2025-05-01 14:36:23'),
(323, 28, 4, 5, 'out', 'sale', 71, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(324, 28, 4, 5, 'out', 'sale', 71, '2025-04-16 12:11:35', '2025-04-16 12:11:35'),
(325, 6, 1, 3, 'out', 'sale', 72, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(326, 6, 1, 3, 'out', 'sale', 72, '2025-01-10 11:35:25', '2025-01-10 11:35:25'),
(327, 86, 10, 1, 'out', 'sale', 73, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(328, 86, 10, 1, 'out', 'sale', 73, '2024-08-24 15:29:43', '2024-08-24 15:29:43'),
(329, 47, 10, 1, 'out', 'sale', 73, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(330, 47, 10, 1, 'out', 'sale', 73, '2024-08-24 15:29:43', '2024-08-24 15:29:43'),
(331, 51, 10, 1, 'out', 'sale', 73, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(332, 51, 10, 1, 'out', 'sale', 73, '2024-08-24 15:29:43', '2024-08-24 15:29:43'),
(333, 63, 12, 1, 'out', 'sale', 74, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(334, 63, 12, 1, 'out', 'sale', 74, '2024-07-19 01:14:15', '2024-07-19 01:14:15'),
(335, 4, 12, 4, 'out', 'sale', 74, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(336, 4, 12, 4, 'out', 'sale', 74, '2024-07-19 01:14:15', '2024-07-19 01:14:15'),
(337, 1, 12, 2, 'out', 'sale', 74, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(338, 1, 12, 2, 'out', 'sale', 74, '2024-07-19 01:14:15', '2024-07-19 01:14:15'),
(339, 77, 12, 1, 'out', 'sale', 74, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(340, 77, 12, 1, 'out', 'sale', 74, '2024-07-19 01:14:15', '2024-07-19 01:14:15'),
(341, 32, 7, 2, 'out', 'sale', 75, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(342, 32, 7, 2, 'out', 'sale', 75, '2024-12-31 05:13:34', '2024-12-31 05:13:34'),
(343, 92, 7, 4, 'out', 'sale', 75, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(344, 92, 7, 4, 'out', 'sale', 75, '2024-12-31 05:13:34', '2024-12-31 05:13:34'),
(345, 37, 7, 4, 'out', 'sale', 75, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(346, 37, 7, 4, 'out', 'sale', 75, '2024-12-31 05:13:34', '2024-12-31 05:13:34'),
(347, 20, 18, 1, 'out', 'sale', 76, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(348, 20, 18, 1, 'out', 'sale', 76, '2024-08-31 04:52:16', '2024-08-31 04:52:16'),
(349, 2, 18, 2, 'out', 'sale', 76, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(350, 2, 18, 2, 'out', 'sale', 76, '2024-08-31 04:52:16', '2024-08-31 04:52:16'),
(351, 22, 18, 1, 'out', 'sale', 76, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(352, 22, 18, 1, 'out', 'sale', 76, '2024-08-31 04:52:16', '2024-08-31 04:52:16'),
(353, 72, 18, 1, 'out', 'sale', 76, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(354, 72, 18, 1, 'out', 'sale', 76, '2024-08-31 04:52:16', '2024-08-31 04:52:16'),
(355, 53, 20, 1, 'out', 'sale', 77, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(356, 53, 20, 1, 'out', 'sale', 77, '2024-06-23 22:51:17', '2024-06-23 22:51:17'),
(357, 52, 20, 4, 'out', 'sale', 77, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(358, 52, 20, 4, 'out', 'sale', 77, '2024-06-23 22:51:17', '2024-06-23 22:51:17'),
(359, 50, 20, 4, 'out', 'sale', 77, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(360, 50, 20, 4, 'out', 'sale', 77, '2024-06-23 22:51:17', '2024-06-23 22:51:17'),
(361, 68, 17, 3, 'out', 'sale', 78, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(362, 68, 17, 3, 'out', 'sale', 78, '2025-05-29 22:32:04', '2025-05-29 22:32:04'),
(363, 7, 17, 4, 'out', 'sale', 78, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(364, 7, 17, 4, 'out', 'sale', 78, '2025-05-29 22:32:04', '2025-05-29 22:32:04'),
(365, 78, 9, 5, 'out', 'sale', 79, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(366, 78, 9, 5, 'out', 'sale', 79, '2025-02-06 11:41:35', '2025-02-06 11:41:35'),
(367, 76, 6, 4, 'out', 'sale', 80, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(368, 76, 6, 4, 'out', 'sale', 80, '2024-08-28 08:15:21', '2024-08-28 08:15:21'),
(369, 58, 6, 5, 'out', 'sale', 80, '2025-06-15 16:49:36', '2025-06-15 16:49:36'),
(370, 58, 6, 5, 'out', 'sale', 80, '2024-08-28 08:15:21', '2024-08-28 08:15:21'),
(371, 82, 6, 3, 'out', 'sale', 80, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(372, 82, 6, 3, 'out', 'sale', 80, '2024-08-28 08:15:21', '2024-08-28 08:15:21'),
(373, 69, 6, 3, 'out', 'sale', 80, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(374, 69, 6, 3, 'out', 'sale', 80, '2024-08-28 08:15:21', '2024-08-28 08:15:21'),
(375, 79, 5, 2, 'out', 'sale', 81, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(376, 79, 5, 2, 'out', 'sale', 81, '2024-11-03 13:40:11', '2024-11-03 13:40:11'),
(377, 93, 5, 3, 'out', 'sale', 81, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(378, 93, 5, 3, 'out', 'sale', 81, '2024-11-03 13:40:11', '2024-11-03 13:40:11'),
(379, 40, 5, 2, 'out', 'sale', 81, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(380, 40, 5, 2, 'out', 'sale', 81, '2024-11-03 13:40:11', '2024-11-03 13:40:11'),
(381, 18, 16, 3, 'out', 'sale', 82, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(382, 18, 16, 3, 'out', 'sale', 82, '2024-06-21 15:50:47', '2024-06-21 15:50:47'),
(383, 81, 16, 4, 'out', 'sale', 82, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(384, 81, 16, 4, 'out', 'sale', 82, '2024-06-21 15:50:47', '2024-06-21 15:50:47'),
(385, 99, 16, 1, 'out', 'sale', 82, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(386, 99, 16, 1, 'out', 'sale', 82, '2024-06-21 15:50:47', '2024-06-21 15:50:47'),
(387, 43, 1, 4, 'out', 'sale', 83, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(388, 43, 1, 4, 'out', 'sale', 83, '2025-02-08 08:09:19', '2025-02-08 08:09:19'),
(389, 66, 1, 2, 'out', 'sale', 83, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(390, 66, 1, 2, 'out', 'sale', 83, '2025-02-08 08:09:19', '2025-02-08 08:09:19'),
(391, 33, 1, 3, 'out', 'sale', 83, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(392, 33, 1, 3, 'out', 'sale', 83, '2025-02-08 08:09:19', '2025-02-08 08:09:19'),
(393, 61, 2, 4, 'out', 'sale', 84, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(394, 61, 2, 4, 'out', 'sale', 84, '2025-05-25 16:12:24', '2025-05-25 16:12:24'),
(395, 76, 6, 4, 'out', 'sale', 85, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(396, 76, 6, 4, 'out', 'sale', 85, '2025-02-04 10:44:27', '2025-02-04 10:44:27'),
(397, 82, 6, 3, 'out', 'sale', 85, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(398, 82, 6, 3, 'out', 'sale', 85, '2025-02-04 10:44:27', '2025-02-04 10:44:27'),
(399, 58, 6, 2, 'out', 'sale', 85, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(400, 58, 6, 2, 'out', 'sale', 85, '2025-02-04 10:44:27', '2025-02-04 10:44:27'),
(401, 68, 17, 2, 'out', 'sale', 86, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(402, 68, 17, 2, 'out', 'sale', 86, '2024-10-25 09:04:26', '2024-10-25 09:04:26'),
(403, 7, 17, 5, 'out', 'sale', 86, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(404, 7, 17, 5, 'out', 'sale', 86, '2024-10-25 09:04:26', '2024-10-25 09:04:26'),
(405, 8, 13, 3, 'out', 'sale', 87, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(406, 8, 13, 3, 'out', 'sale', 87, '2025-02-03 18:05:56', '2025-02-03 18:05:56'),
(407, 55, 13, 4, 'out', 'sale', 87, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(408, 55, 13, 4, 'out', 'sale', 87, '2025-02-03 18:05:56', '2025-02-03 18:05:56'),
(409, 72, 18, 3, 'out', 'sale', 88, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(410, 72, 18, 3, 'out', 'sale', 88, '2025-03-12 01:11:23', '2025-03-12 01:11:23'),
(411, 88, 15, 5, 'out', 'sale', 89, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(412, 88, 15, 5, 'out', 'sale', 89, '2024-12-25 12:16:08', '2024-12-25 12:16:08'),
(413, 36, 15, 1, 'out', 'sale', 89, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(414, 36, 15, 1, 'out', 'sale', 89, '2024-12-25 12:16:08', '2024-12-25 12:16:08'),
(415, 24, 15, 4, 'out', 'sale', 89, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(416, 24, 15, 4, 'out', 'sale', 89, '2024-12-25 12:16:08', '2024-12-25 12:16:08'),
(417, 80, 15, 3, 'out', 'sale', 89, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(418, 80, 15, 3, 'out', 'sale', 89, '2024-12-25 12:16:08', '2024-12-25 12:16:08'),
(419, 81, 16, 1, 'out', 'sale', 90, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(420, 81, 16, 1, 'out', 'sale', 90, '2024-12-21 00:51:03', '2024-12-21 00:51:03'),
(421, 18, 16, 3, 'out', 'sale', 90, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(422, 18, 16, 3, 'out', 'sale', 90, '2024-12-21 00:51:03', '2024-12-21 00:51:03'),
(423, 69, 6, 1, 'out', 'sale', 91, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(424, 69, 6, 1, 'out', 'sale', 91, '2024-11-01 23:11:52', '2024-11-01 23:11:52'),
(425, 58, 6, 3, 'out', 'sale', 91, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(426, 58, 6, 3, 'out', 'sale', 91, '2024-11-01 23:11:52', '2024-11-01 23:11:52'),
(427, 76, 6, 3, 'out', 'sale', 91, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(428, 76, 6, 3, 'out', 'sale', 91, '2024-11-01 23:11:52', '2024-11-01 23:11:52'),
(429, 84, 12, 4, 'out', 'sale', 92, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(430, 84, 12, 4, 'out', 'sale', 92, '2024-12-09 02:35:05', '2024-12-09 02:35:05'),
(431, 4, 12, 1, 'out', 'sale', 92, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(432, 4, 12, 1, 'out', 'sale', 92, '2024-12-09 02:35:05', '2024-12-09 02:35:05'),
(433, 89, 3, 4, 'out', 'sale', 93, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(434, 89, 3, 4, 'out', 'sale', 93, '2024-08-16 22:39:32', '2024-08-16 22:39:32'),
(435, 75, 3, 4, 'out', 'sale', 93, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(436, 75, 3, 4, 'out', 'sale', 93, '2024-08-16 22:39:32', '2024-08-16 22:39:32'),
(437, 21, 3, 2, 'out', 'sale', 93, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(438, 21, 3, 2, 'out', 'sale', 93, '2024-08-16 22:39:32', '2024-08-16 22:39:32'),
(439, 78, 9, 4, 'out', 'sale', 94, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(440, 78, 9, 4, 'out', 'sale', 94, '2025-04-21 17:34:30', '2025-04-21 17:34:30'),
(441, 12, 9, 3, 'out', 'sale', 94, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(442, 12, 9, 3, 'out', 'sale', 94, '2025-04-21 17:34:30', '2025-04-21 17:34:30'),
(443, 48, 8, 5, 'out', 'sale', 95, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(444, 48, 8, 5, 'out', 'sale', 95, '2025-06-14 15:05:24', '2025-06-14 15:05:24'),
(445, 8, 13, 1, 'out', 'sale', 96, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(446, 8, 13, 1, 'out', 'sale', 96, '2024-10-16 16:18:55', '2024-10-16 16:18:55'),
(447, 55, 13, 2, 'out', 'sale', 96, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(448, 55, 13, 2, 'out', 'sale', 96, '2024-10-16 16:18:55', '2024-10-16 16:18:55'),
(449, 95, 8, 5, 'out', 'sale', 97, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(450, 95, 8, 5, 'out', 'sale', 97, '2024-11-01 18:33:41', '2024-11-01 18:33:41'),
(451, 67, 8, 4, 'out', 'sale', 97, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(452, 67, 8, 4, 'out', 'sale', 97, '2024-11-01 18:33:41', '2024-11-01 18:33:41'),
(453, 17, 8, 3, 'out', 'sale', 97, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(454, 17, 8, 3, 'out', 'sale', 97, '2024-11-01 18:33:41', '2024-11-01 18:33:41'),
(455, 39, 19, 2, 'out', 'sale', 98, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(456, 39, 19, 2, 'out', 'sale', 98, '2025-04-30 20:28:00', '2025-04-30 20:28:00'),
(457, 100, 19, 1, 'out', 'sale', 98, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(458, 100, 19, 1, 'out', 'sale', 98, '2025-04-30 20:28:00', '2025-04-30 20:28:00'),
(459, 7, 17, 3, 'out', 'sale', 99, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(460, 7, 17, 3, 'out', 'sale', 99, '2024-12-08 13:34:38', '2024-12-08 13:34:38'),
(461, 68, 17, 3, 'out', 'sale', 99, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(462, 68, 17, 3, 'out', 'sale', 99, '2024-12-08 13:34:38', '2024-12-08 13:34:38'),
(463, 68, 17, 3, 'out', 'sale', 100, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(464, 68, 17, 3, 'out', 'sale', 100, '2025-01-31 17:51:11', '2025-01-31 17:51:11'),
(465, 7, 17, 3, 'out', 'sale', 101, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(466, 7, 17, 3, 'out', 'sale', 101, '2025-03-07 22:22:45', '2025-03-07 22:22:45'),
(467, 82, 6, 2, 'out', 'sale', 102, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(468, 82, 6, 2, 'out', 'sale', 102, '2025-06-05 03:49:09', '2025-06-05 03:49:09'),
(469, 76, 6, 1, 'out', 'sale', 102, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(470, 76, 6, 1, 'out', 'sale', 102, '2025-06-05 03:49:09', '2025-06-05 03:49:09'),
(471, 69, 6, 2, 'out', 'sale', 102, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(472, 69, 6, 2, 'out', 'sale', 102, '2025-06-05 03:49:09', '2025-06-05 03:49:09'),
(473, 8, 13, 4, 'out', 'sale', 103, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(474, 8, 13, 4, 'out', 'sale', 103, '2024-11-16 20:27:14', '2024-11-16 20:27:14'),
(475, 51, 10, 4, 'out', 'sale', 104, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(476, 51, 10, 4, 'out', 'sale', 104, '2024-12-21 04:05:30', '2024-12-21 04:05:30'),
(477, 47, 10, 3, 'out', 'sale', 104, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(478, 47, 10, 3, 'out', 'sale', 104, '2024-12-21 04:05:30', '2024-12-21 04:05:30'),
(479, 90, 10, 1, 'out', 'sale', 104, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(480, 90, 10, 1, 'out', 'sale', 104, '2024-12-21 04:05:30', '2024-12-21 04:05:30'),
(481, 83, 10, 2, 'out', 'sale', 104, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(482, 83, 10, 2, 'out', 'sale', 104, '2024-12-21 04:05:30', '2024-12-21 04:05:30'),
(483, 20, 18, 4, 'out', 'sale', 105, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(484, 20, 18, 4, 'out', 'sale', 105, '2024-10-02 15:34:31', '2024-10-02 15:34:31'),
(485, 22, 18, 5, 'out', 'sale', 105, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(486, 22, 18, 5, 'out', 'sale', 105, '2024-10-02 15:34:31', '2024-10-02 15:34:31'),
(487, 72, 18, 5, 'out', 'sale', 105, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(488, 72, 18, 5, 'out', 'sale', 105, '2024-10-02 15:34:31', '2024-10-02 15:34:31'),
(489, 100, 19, 3, 'out', 'sale', 106, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(490, 100, 19, 3, 'out', 'sale', 106, '2024-07-24 13:42:48', '2024-07-24 13:42:48'),
(491, 20, 18, 3, 'out', 'sale', 107, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(492, 20, 18, 3, 'out', 'sale', 107, '2025-01-10 22:24:30', '2025-01-10 22:24:30'),
(493, 72, 18, 3, 'out', 'sale', 107, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(494, 72, 18, 3, 'out', 'sale', 107, '2025-01-10 22:24:30', '2025-01-10 22:24:30'),
(495, 22, 18, 2, 'out', 'sale', 107, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(496, 22, 18, 2, 'out', 'sale', 107, '2025-01-10 22:24:30', '2025-01-10 22:24:30'),
(497, 55, 13, 3, 'out', 'sale', 108, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(498, 55, 13, 3, 'out', 'sale', 108, '2025-02-11 15:06:23', '2025-02-11 15:06:23'),
(499, 8, 13, 5, 'out', 'sale', 108, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(500, 8, 13, 5, 'out', 'sale', 108, '2025-02-11 15:06:23', '2025-02-11 15:06:23'),
(501, 43, 1, 1, 'out', 'sale', 109, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(502, 43, 1, 1, 'out', 'sale', 109, '2025-05-31 21:39:04', '2025-05-31 21:39:04'),
(503, 74, 4, 3, 'out', 'sale', 110, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(504, 74, 4, 3, 'out', 'sale', 110, '2025-04-28 19:40:15', '2025-04-28 19:40:15'),
(505, 31, 4, 2, 'out', 'sale', 110, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(506, 31, 4, 2, 'out', 'sale', 110, '2025-04-28 19:40:15', '2025-04-28 19:40:15'),
(507, 28, 4, 4, 'out', 'sale', 110, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(508, 28, 4, 4, 'out', 'sale', 110, '2025-04-28 19:40:15', '2025-04-28 19:40:15'),
(509, 60, 2, 5, 'out', 'sale', 111, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(510, 60, 2, 5, 'out', 'sale', 111, '2025-01-19 21:42:39', '2025-01-19 21:42:39'),
(511, 89, 3, 2, 'out', 'sale', 112, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(512, 89, 3, 2, 'out', 'sale', 112, '2024-11-05 16:10:57', '2024-11-05 16:10:57'),
(513, 73, 3, 3, 'out', 'sale', 112, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(514, 73, 3, 3, 'out', 'sale', 112, '2024-11-05 16:10:57', '2024-11-05 16:10:57'),
(515, 59, 5, 1, 'out', 'sale', 113, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(516, 59, 5, 1, 'out', 'sale', 113, '2024-08-12 09:05:29', '2024-08-12 09:05:29'),
(517, 23, 5, 1, 'out', 'sale', 113, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(518, 23, 5, 1, 'out', 'sale', 113, '2024-08-12 09:05:29', '2024-08-12 09:05:29'),
(519, 93, 5, 5, 'out', 'sale', 113, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(520, 93, 5, 5, 'out', 'sale', 113, '2024-08-12 09:05:29', '2024-08-12 09:05:29'),
(521, 72, 18, 1, 'out', 'sale', 114, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(522, 72, 18, 1, 'out', 'sale', 114, '2025-03-04 12:24:55', '2025-03-04 12:24:55'),
(523, 20, 18, 3, 'out', 'sale', 114, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(524, 20, 18, 3, 'out', 'sale', 114, '2025-03-04 12:24:55', '2025-03-04 12:24:55'),
(525, 68, 17, 2, 'out', 'sale', 115, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(526, 68, 17, 2, 'out', 'sale', 115, '2024-08-03 03:16:50', '2024-08-03 03:16:50'),
(527, 7, 17, 4, 'out', 'sale', 115, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(528, 7, 17, 4, 'out', 'sale', 115, '2024-08-03 03:16:50', '2024-08-03 03:16:50'),
(529, 50, 20, 4, 'out', 'sale', 116, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(530, 50, 20, 4, 'out', 'sale', 116, '2024-12-05 13:19:39', '2024-12-05 13:19:39'),
(531, 41, 14, 3, 'out', 'sale', 117, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(532, 41, 14, 3, 'out', 'sale', 117, '2024-07-25 15:37:11', '2024-07-25 15:37:11'),
(533, 60, 2, 1, 'out', 'sale', 118, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(534, 60, 2, 1, 'out', 'sale', 118, '2024-12-16 15:13:03', '2024-12-16 15:13:03'),
(535, 13, 14, 3, 'out', 'sale', 119, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(536, 13, 14, 3, 'out', 'sale', 119, '2025-05-08 21:07:49', '2025-05-08 21:07:49'),
(537, 8, 13, 4, 'out', 'sale', 120, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(538, 8, 13, 4, 'out', 'sale', 120, '2024-07-15 09:16:42', '2024-07-15 09:16:42'),
(539, 68, 17, 5, 'out', 'sale', 121, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(540, 68, 17, 5, 'out', 'sale', 121, '2025-04-22 15:35:30', '2025-04-22 15:35:30'),
(541, 7, 17, 4, 'out', 'sale', 121, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(542, 7, 17, 4, 'out', 'sale', 121, '2025-04-22 15:35:30', '2025-04-22 15:35:30'),
(543, 68, 17, 5, 'out', 'sale', 122, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(544, 68, 17, 5, 'out', 'sale', 122, '2025-04-06 09:11:10', '2025-04-06 09:11:10'),
(545, 28, 4, 5, 'out', 'sale', 123, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(546, 28, 4, 5, 'out', 'sale', 123, '2025-04-05 06:38:49', '2025-04-05 06:38:49'),
(547, 74, 4, 3, 'out', 'sale', 123, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(548, 74, 4, 3, 'out', 'sale', 123, '2025-04-05 06:38:49', '2025-04-05 06:38:49'),
(549, 36, 15, 1, 'out', 'sale', 124, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(550, 36, 15, 1, 'out', 'sale', 124, '2025-02-02 10:28:52', '2025-02-02 10:28:52'),
(551, 60, 2, 3, 'out', 'sale', 125, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(552, 60, 2, 3, 'out', 'sale', 125, '2024-07-09 15:11:52', '2024-07-09 15:11:52'),
(553, 72, 18, 1, 'out', 'sale', 126, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(554, 72, 18, 1, 'out', 'sale', 126, '2024-12-27 11:13:17', '2024-12-27 11:13:17'),
(555, 22, 18, 5, 'out', 'sale', 126, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(556, 22, 18, 5, 'out', 'sale', 126, '2024-12-27 11:13:17', '2024-12-27 11:13:17'),
(557, 19, 20, 4, 'out', 'sale', 127, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(558, 19, 20, 4, 'out', 'sale', 127, '2024-12-02 16:37:10', '2024-12-02 16:37:10'),
(559, 53, 20, 2, 'out', 'sale', 127, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(560, 53, 20, 2, 'out', 'sale', 127, '2024-12-02 16:37:10', '2024-12-02 16:37:10'),
(561, 50, 20, 5, 'out', 'sale', 127, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(562, 50, 20, 5, 'out', 'sale', 127, '2024-12-02 16:37:10', '2024-12-02 16:37:10'),
(563, 52, 20, 2, 'out', 'sale', 127, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(564, 52, 20, 2, 'out', 'sale', 127, '2024-12-02 16:37:10', '2024-12-02 16:37:10'),
(565, 12, 9, 4, 'out', 'sale', 128, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(566, 12, 9, 4, 'out', 'sale', 128, '2025-05-24 14:12:36', '2025-05-24 14:12:36'),
(567, 78, 9, 4, 'out', 'sale', 128, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(568, 78, 9, 4, 'out', 'sale', 128, '2025-05-24 14:12:36', '2025-05-24 14:12:36'),
(569, 82, 6, 4, 'out', 'sale', 129, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(570, 82, 6, 4, 'out', 'sale', 129, '2024-07-12 04:04:16', '2024-07-12 04:04:16'),
(571, 69, 6, 1, 'out', 'sale', 129, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(572, 69, 6, 1, 'out', 'sale', 129, '2024-07-12 04:04:16', '2024-07-12 04:04:16'),
(573, 76, 6, 4, 'out', 'sale', 129, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(574, 76, 6, 4, 'out', 'sale', 129, '2024-07-12 04:04:16', '2024-07-12 04:04:16'),
(575, 100, 19, 5, 'out', 'sale', 130, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(576, 100, 19, 5, 'out', 'sale', 130, '2025-01-11 14:09:41', '2025-01-11 14:09:41'),
(577, 39, 19, 5, 'out', 'sale', 130, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(578, 39, 19, 5, 'out', 'sale', 130, '2025-01-11 14:09:41', '2025-01-11 14:09:41'),
(579, 17, 8, 2, 'out', 'sale', 131, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(580, 17, 8, 2, 'out', 'sale', 131, '2025-03-23 14:33:38', '2025-03-23 14:33:38'),
(581, 56, 8, 2, 'out', 'sale', 131, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(582, 56, 8, 2, 'out', 'sale', 131, '2025-03-23 14:33:38', '2025-03-23 14:33:38'),
(583, 35, 8, 5, 'out', 'sale', 131, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(584, 35, 8, 5, 'out', 'sale', 131, '2025-03-23 14:33:38', '2025-03-23 14:33:38'),
(585, 29, 8, 2, 'out', 'sale', 131, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(586, 29, 8, 2, 'out', 'sale', 131, '2025-03-23 14:33:38', '2025-03-23 14:33:38'),
(587, 36, 15, 3, 'out', 'sale', 132, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(588, 36, 15, 3, 'out', 'sale', 132, '2024-09-25 07:09:44', '2024-09-25 07:09:44'),
(589, 88, 15, 5, 'out', 'sale', 132, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(590, 88, 15, 5, 'out', 'sale', 132, '2024-09-25 07:09:44', '2024-09-25 07:09:44'),
(591, 23, 5, 2, 'out', 'sale', 133, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(592, 23, 5, 2, 'out', 'sale', 133, '2024-06-21 19:46:01', '2024-06-21 19:46:01'),
(593, 72, 18, 1, 'out', 'sale', 134, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(594, 72, 18, 1, 'out', 'sale', 134, '2025-04-06 10:10:23', '2025-04-06 10:10:23'),
(595, 99, 16, 2, 'out', 'sale', 135, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(596, 99, 16, 2, 'out', 'sale', 135, '2024-07-05 21:47:30', '2024-07-05 21:47:30'),
(597, 81, 16, 3, 'out', 'sale', 135, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(598, 81, 16, 3, 'out', 'sale', 135, '2024-07-05 21:47:30', '2024-07-05 21:47:30'),
(599, 60, 2, 5, 'out', 'sale', 136, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(600, 60, 2, 5, 'out', 'sale', 136, '2024-12-31 04:36:30', '2024-12-31 04:36:30'),
(601, 90, 10, 5, 'out', 'sale', 137, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(602, 90, 10, 5, 'out', 'sale', 137, '2024-09-21 08:22:16', '2024-09-21 08:22:16'),
(603, 51, 10, 3, 'out', 'sale', 137, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(604, 51, 10, 3, 'out', 'sale', 137, '2024-09-21 08:22:16', '2024-09-21 08:22:16'),
(605, 47, 10, 5, 'out', 'sale', 137, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(606, 47, 10, 5, 'out', 'sale', 137, '2024-09-21 08:22:16', '2024-09-21 08:22:16'),
(607, 86, 10, 4, 'out', 'sale', 137, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(608, 86, 10, 4, 'out', 'sale', 137, '2024-09-21 08:22:16', '2024-09-21 08:22:16'),
(609, 8, 13, 2, 'out', 'sale', 138, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(610, 8, 13, 2, 'out', 'sale', 138, '2025-03-24 05:26:15', '2025-03-24 05:26:15'),
(611, 97, 11, 5, 'out', 'sale', 139, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(612, 97, 11, 5, 'out', 'sale', 139, '2025-02-12 14:28:09', '2025-02-12 14:28:09'),
(613, 100, 19, 5, 'out', 'sale', 140, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(614, 100, 19, 5, 'out', 'sale', 140, '2025-03-11 22:24:15', '2025-03-11 22:24:15'),
(615, 39, 19, 3, 'out', 'sale', 140, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(616, 39, 19, 3, 'out', 'sale', 140, '2025-03-11 22:24:15', '2025-03-11 22:24:15'),
(617, 68, 17, 5, 'out', 'sale', 141, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(618, 68, 17, 5, 'out', 'sale', 141, '2025-02-07 12:43:58', '2025-02-07 12:43:58'),
(619, 7, 17, 2, 'out', 'sale', 141, '2025-06-15 16:49:37', '2025-06-15 16:49:37');
INSERT INTO `stockmutation` (`id`, `product_id`, `outlet_id`, `quantity`, `type`, `reference_type`, `reference_id`, `created_at`, `updated_at`) VALUES
(620, 7, 17, 2, 'out', 'sale', 141, '2025-02-07 12:43:58', '2025-02-07 12:43:58'),
(621, 28, 4, 2, 'out', 'sale', 142, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(622, 28, 4, 2, 'out', 'sale', 142, '2025-03-27 06:18:11', '2025-03-27 06:18:11'),
(623, 96, 3, 2, 'out', 'sale', 143, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(624, 96, 3, 2, 'out', 'sale', 143, '2024-08-17 07:22:35', '2024-08-17 07:22:35'),
(625, 8, 13, 4, 'out', 'sale', 144, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(626, 8, 13, 4, 'out', 'sale', 144, '2024-10-06 12:36:38', '2024-10-06 12:36:38'),
(627, 44, 3, 1, 'out', 'sale', 145, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(628, 44, 3, 1, 'out', 'sale', 145, '2025-05-05 12:59:21', '2025-05-05 12:59:21'),
(629, 42, 3, 5, 'out', 'sale', 145, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(630, 42, 3, 5, 'out', 'sale', 145, '2025-05-05 12:59:21', '2025-05-05 12:59:21'),
(631, 18, 16, 3, 'out', 'sale', 146, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(632, 18, 16, 3, 'out', 'sale', 146, '2024-07-28 21:49:46', '2024-07-28 21:49:46'),
(633, 81, 16, 3, 'out', 'sale', 146, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(634, 81, 16, 3, 'out', 'sale', 146, '2024-07-28 21:49:46', '2024-07-28 21:49:46'),
(635, 99, 16, 4, 'out', 'sale', 146, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(636, 99, 16, 4, 'out', 'sale', 146, '2024-07-28 21:49:46', '2024-07-28 21:49:46'),
(637, 20, 18, 3, 'out', 'sale', 147, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(638, 20, 18, 3, 'out', 'sale', 147, '2024-10-29 13:50:15', '2024-10-29 13:50:15'),
(639, 72, 18, 5, 'out', 'sale', 147, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(640, 72, 18, 5, 'out', 'sale', 147, '2024-10-29 13:50:15', '2024-10-29 13:50:15'),
(641, 22, 18, 5, 'out', 'sale', 147, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(642, 22, 18, 5, 'out', 'sale', 147, '2024-10-29 13:50:15', '2024-10-29 13:50:15'),
(643, 81, 16, 1, 'out', 'sale', 148, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(644, 81, 16, 1, 'out', 'sale', 148, '2024-09-13 06:54:12', '2024-09-13 06:54:12'),
(645, 99, 16, 3, 'out', 'sale', 148, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(646, 99, 16, 3, 'out', 'sale', 148, '2024-09-13 06:54:12', '2024-09-13 06:54:12'),
(647, 18, 16, 1, 'out', 'sale', 148, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(648, 18, 16, 1, 'out', 'sale', 148, '2024-09-13 06:54:12', '2024-09-13 06:54:12'),
(649, 47, 10, 5, 'out', 'sale', 149, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(650, 47, 10, 5, 'out', 'sale', 149, '2025-03-10 10:47:39', '2025-03-10 10:47:39'),
(651, 84, 12, 1, 'out', 'sale', 150, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(652, 84, 12, 1, 'out', 'sale', 150, '2024-10-28 04:49:46', '2024-10-28 04:49:46'),
(653, 100, 19, 4, 'out', 'sale', 151, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(654, 100, 19, 4, 'out', 'sale', 151, '2024-06-19 17:27:52', '2024-06-19 17:27:52'),
(655, 39, 19, 3, 'out', 'sale', 151, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(656, 39, 19, 3, 'out', 'sale', 151, '2024-06-19 17:27:52', '2024-06-19 17:27:52'),
(657, 90, 10, 1, 'out', 'sale', 152, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(658, 90, 10, 1, 'out', 'sale', 152, '2024-12-17 20:12:14', '2024-12-17 20:12:14'),
(659, 86, 10, 4, 'out', 'sale', 152, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(660, 86, 10, 4, 'out', 'sale', 152, '2024-12-17 20:12:14', '2024-12-17 20:12:14'),
(661, 47, 10, 4, 'out', 'sale', 152, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(662, 47, 10, 4, 'out', 'sale', 152, '2024-12-17 20:12:14', '2024-12-17 20:12:14'),
(663, 83, 10, 4, 'out', 'sale', 152, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(664, 83, 10, 4, 'out', 'sale', 152, '2024-12-17 20:12:14', '2024-12-17 20:12:14'),
(665, 65, 7, 5, 'out', 'sale', 153, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(666, 65, 7, 5, 'out', 'sale', 153, '2024-12-16 01:45:52', '2024-12-16 01:45:52'),
(667, 36, 15, 1, 'out', 'sale', 154, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(668, 36, 15, 1, 'out', 'sale', 154, '2025-02-16 10:47:16', '2025-02-16 10:47:16'),
(669, 80, 15, 5, 'out', 'sale', 154, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(670, 80, 15, 5, 'out', 'sale', 154, '2025-02-16 10:47:16', '2025-02-16 10:47:16'),
(671, 88, 15, 4, 'out', 'sale', 154, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(672, 88, 15, 4, 'out', 'sale', 154, '2025-02-16 10:47:16', '2025-02-16 10:47:16'),
(673, 1, 12, 5, 'out', 'sale', 155, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(674, 1, 12, 5, 'out', 'sale', 155, '2025-04-25 00:53:04', '2025-04-25 00:53:04'),
(675, 23, 5, 1, 'out', 'sale', 156, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(676, 23, 5, 1, 'out', 'sale', 156, '2024-07-30 17:59:16', '2024-07-30 17:59:16'),
(677, 40, 5, 3, 'out', 'sale', 156, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(678, 40, 5, 3, 'out', 'sale', 156, '2024-07-30 17:59:16', '2024-07-30 17:59:16'),
(679, 79, 5, 3, 'out', 'sale', 156, '2025-06-15 16:49:37', '2025-06-15 16:49:37'),
(680, 79, 5, 3, 'out', 'sale', 156, '2024-07-30 17:59:16', '2024-07-30 17:59:16'),
(681, 59, 5, 2, 'out', 'sale', 156, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(682, 59, 5, 2, 'out', 'sale', 156, '2024-07-30 17:59:16', '2024-07-30 17:59:16'),
(683, 60, 2, 3, 'out', 'sale', 157, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(684, 60, 2, 3, 'out', 'sale', 157, '2025-03-26 10:17:53', '2025-03-26 10:17:53'),
(685, 32, 7, 4, 'out', 'sale', 158, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(686, 32, 7, 4, 'out', 'sale', 158, '2024-10-21 10:05:20', '2024-10-21 10:05:20'),
(687, 65, 7, 4, 'out', 'sale', 158, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(688, 65, 7, 4, 'out', 'sale', 158, '2024-10-21 10:05:20', '2024-10-21 10:05:20'),
(689, 92, 7, 1, 'out', 'sale', 158, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(690, 92, 7, 1, 'out', 'sale', 158, '2024-10-21 10:05:20', '2024-10-21 10:05:20'),
(691, 27, 7, 4, 'out', 'sale', 158, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(692, 27, 7, 4, 'out', 'sale', 158, '2024-10-21 10:05:20', '2024-10-21 10:05:20'),
(693, 22, 18, 4, 'out', 'sale', 159, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(694, 22, 18, 4, 'out', 'sale', 159, '2024-12-26 10:38:52', '2024-12-26 10:38:52'),
(695, 20, 18, 4, 'out', 'sale', 159, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(696, 20, 18, 4, 'out', 'sale', 159, '2024-12-26 10:38:52', '2024-12-26 10:38:52'),
(697, 72, 18, 3, 'out', 'sale', 159, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(698, 72, 18, 3, 'out', 'sale', 159, '2024-12-26 10:38:52', '2024-12-26 10:38:52'),
(699, 80, 15, 2, 'out', 'sale', 160, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(700, 80, 15, 2, 'out', 'sale', 160, '2024-08-08 04:34:29', '2024-08-08 04:34:29'),
(701, 88, 15, 4, 'out', 'sale', 160, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(702, 88, 15, 4, 'out', 'sale', 160, '2024-08-08 04:34:29', '2024-08-08 04:34:29'),
(703, 36, 15, 2, 'out', 'sale', 160, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(704, 36, 15, 2, 'out', 'sale', 160, '2024-08-08 04:34:29', '2024-08-08 04:34:29'),
(705, 8, 13, 2, 'out', 'sale', 161, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(706, 8, 13, 2, 'out', 'sale', 161, '2025-05-12 13:19:15', '2025-05-12 13:19:15'),
(707, 71, 11, 2, 'out', 'sale', 162, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(708, 71, 11, 2, 'out', 'sale', 162, '2025-05-20 09:23:09', '2025-05-20 09:23:09'),
(709, 7, 17, 2, 'out', 'sale', 163, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(710, 7, 17, 2, 'out', 'sale', 163, '2024-12-01 19:12:10', '2024-12-01 19:12:10'),
(711, 68, 17, 1, 'out', 'sale', 163, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(712, 68, 17, 1, 'out', 'sale', 163, '2024-12-01 19:12:10', '2024-12-01 19:12:10'),
(713, 76, 6, 2, 'out', 'sale', 164, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(714, 76, 6, 2, 'out', 'sale', 164, '2024-08-20 03:56:06', '2024-08-20 03:56:06'),
(715, 7, 17, 2, 'out', 'sale', 165, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(716, 7, 17, 2, 'out', 'sale', 165, '2024-09-07 10:35:11', '2024-09-07 10:35:11'),
(717, 68, 17, 1, 'out', 'sale', 165, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(718, 68, 17, 1, 'out', 'sale', 165, '2024-09-07 10:35:11', '2024-09-07 10:35:11'),
(719, 41, 14, 2, 'out', 'sale', 166, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(720, 41, 14, 2, 'out', 'sale', 166, '2025-04-03 13:06:27', '2025-04-03 13:06:27'),
(721, 13, 14, 4, 'out', 'sale', 166, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(722, 13, 14, 4, 'out', 'sale', 166, '2025-04-03 13:06:27', '2025-04-03 13:06:27'),
(723, 9, 14, 5, 'out', 'sale', 166, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(724, 9, 14, 5, 'out', 'sale', 166, '2025-04-03 13:06:27', '2025-04-03 13:06:27'),
(725, 100, 19, 2, 'out', 'sale', 167, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(726, 100, 19, 2, 'out', 'sale', 167, '2025-03-15 13:53:08', '2025-03-15 13:53:08'),
(727, 39, 19, 1, 'out', 'sale', 167, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(728, 39, 19, 1, 'out', 'sale', 167, '2025-03-15 13:53:08', '2025-03-15 13:53:08'),
(729, 19, 20, 1, 'out', 'sale', 168, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(730, 19, 20, 1, 'out', 'sale', 168, '2024-10-10 23:57:26', '2024-10-10 23:57:26'),
(731, 92, 7, 5, 'out', 'sale', 169, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(732, 92, 7, 5, 'out', 'sale', 169, '2025-01-27 23:17:46', '2025-01-27 23:17:46'),
(733, 65, 7, 3, 'out', 'sale', 169, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(734, 65, 7, 3, 'out', 'sale', 169, '2025-01-27 23:17:46', '2025-01-27 23:17:46'),
(735, 19, 20, 2, 'out', 'sale', 170, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(736, 19, 20, 2, 'out', 'sale', 170, '2025-05-31 02:51:55', '2025-05-31 02:51:55'),
(737, 50, 20, 3, 'out', 'sale', 170, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(738, 50, 20, 3, 'out', 'sale', 170, '2025-05-31 02:51:55', '2025-05-31 02:51:55'),
(739, 80, 15, 1, 'out', 'sale', 171, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(740, 80, 15, 1, 'out', 'sale', 171, '2024-11-02 23:58:49', '2024-11-02 23:58:49'),
(741, 88, 15, 1, 'out', 'sale', 171, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(742, 88, 15, 1, 'out', 'sale', 171, '2024-11-02 23:58:49', '2024-11-02 23:58:49'),
(743, 36, 15, 2, 'out', 'sale', 171, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(744, 36, 15, 2, 'out', 'sale', 171, '2024-11-02 23:58:49', '2024-11-02 23:58:49'),
(745, 36, 15, 4, 'out', 'sale', 172, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(746, 36, 15, 4, 'out', 'sale', 172, '2025-04-21 14:38:28', '2025-04-21 14:38:28'),
(747, 13, 14, 2, 'out', 'sale', 173, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(748, 13, 14, 2, 'out', 'sale', 173, '2025-02-02 17:34:40', '2025-02-02 17:34:40'),
(749, 41, 14, 3, 'out', 'sale', 173, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(750, 41, 14, 3, 'out', 'sale', 173, '2025-02-02 17:34:40', '2025-02-02 17:34:40'),
(751, 9, 14, 5, 'out', 'sale', 173, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(752, 9, 14, 5, 'out', 'sale', 173, '2025-02-02 17:34:40', '2025-02-02 17:34:40'),
(753, 42, 3, 4, 'out', 'sale', 174, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(754, 42, 3, 4, 'out', 'sale', 174, '2024-06-23 17:19:48', '2024-06-23 17:19:48'),
(755, 96, 3, 4, 'out', 'sale', 174, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(756, 96, 3, 4, 'out', 'sale', 174, '2024-06-23 17:19:48', '2024-06-23 17:19:48'),
(757, 21, 3, 2, 'out', 'sale', 174, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(758, 21, 3, 2, 'out', 'sale', 174, '2024-06-23 17:19:48', '2024-06-23 17:19:48'),
(759, 59, 5, 5, 'out', 'sale', 175, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(760, 59, 5, 5, 'out', 'sale', 175, '2025-04-14 03:09:24', '2025-04-14 03:09:24'),
(761, 23, 5, 5, 'out', 'sale', 175, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(762, 23, 5, 5, 'out', 'sale', 175, '2025-04-14 03:09:24', '2025-04-14 03:09:24'),
(763, 79, 5, 1, 'out', 'sale', 175, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(764, 79, 5, 1, 'out', 'sale', 175, '2025-04-14 03:09:24', '2025-04-14 03:09:24'),
(765, 40, 5, 4, 'out', 'sale', 175, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(766, 40, 5, 4, 'out', 'sale', 175, '2025-04-14 03:09:24', '2025-04-14 03:09:24'),
(767, 76, 6, 4, 'out', 'sale', 176, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(768, 76, 6, 4, 'out', 'sale', 176, '2024-06-22 19:12:05', '2024-06-22 19:12:05'),
(769, 97, 11, 3, 'out', 'sale', 177, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(770, 97, 11, 3, 'out', 'sale', 177, '2025-05-13 08:30:23', '2025-05-13 08:30:23'),
(771, 15, 11, 2, 'out', 'sale', 177, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(772, 15, 11, 2, 'out', 'sale', 177, '2025-05-13 08:30:23', '2025-05-13 08:30:23'),
(773, 39, 19, 3, 'out', 'sale', 178, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(774, 39, 19, 3, 'out', 'sale', 178, '2025-05-01 10:03:13', '2025-05-01 10:03:13'),
(775, 100, 19, 5, 'out', 'sale', 178, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(776, 100, 19, 5, 'out', 'sale', 178, '2025-05-01 10:03:13', '2025-05-01 10:03:13'),
(777, 26, 7, 5, 'out', 'sale', 179, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(778, 26, 7, 5, 'out', 'sale', 179, '2025-02-25 10:46:13', '2025-02-25 10:46:13'),
(779, 14, 8, 5, 'out', 'sale', 180, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(780, 14, 8, 5, 'out', 'sale', 180, '2025-04-12 10:01:22', '2025-04-12 10:01:22'),
(781, 48, 8, 4, 'out', 'sale', 180, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(782, 48, 8, 4, 'out', 'sale', 180, '2025-04-12 10:01:22', '2025-04-12 10:01:22'),
(783, 17, 8, 3, 'out', 'sale', 180, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(784, 17, 8, 3, 'out', 'sale', 180, '2025-04-12 10:01:22', '2025-04-12 10:01:22'),
(785, 29, 8, 5, 'out', 'sale', 180, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(786, 29, 8, 5, 'out', 'sale', 180, '2025-04-12 10:01:22', '2025-04-12 10:01:22'),
(787, 81, 16, 2, 'out', 'sale', 181, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(788, 81, 16, 2, 'out', 'sale', 181, '2024-12-02 05:21:56', '2024-12-02 05:21:56'),
(789, 18, 16, 3, 'out', 'sale', 181, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(790, 18, 16, 3, 'out', 'sale', 181, '2024-12-02 05:21:56', '2024-12-02 05:21:56'),
(791, 71, 11, 2, 'out', 'sale', 182, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(792, 71, 11, 2, 'out', 'sale', 182, '2024-12-22 11:08:21', '2024-12-22 11:08:21'),
(793, 45, 11, 2, 'out', 'sale', 182, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(794, 45, 11, 2, 'out', 'sale', 182, '2024-12-22 11:08:21', '2024-12-22 11:08:21'),
(795, 98, 11, 3, 'out', 'sale', 182, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(796, 98, 11, 3, 'out', 'sale', 182, '2024-12-22 11:08:21', '2024-12-22 11:08:21'),
(797, 96, 3, 1, 'out', 'sale', 183, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(798, 96, 3, 1, 'out', 'sale', 183, '2024-10-15 03:55:38', '2024-10-15 03:55:38'),
(799, 21, 3, 1, 'out', 'sale', 183, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(800, 21, 3, 1, 'out', 'sale', 183, '2024-10-15 03:55:38', '2024-10-15 03:55:38'),
(801, 44, 3, 4, 'out', 'sale', 183, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(802, 44, 3, 4, 'out', 'sale', 183, '2024-10-15 03:55:38', '2024-10-15 03:55:38'),
(803, 73, 3, 2, 'out', 'sale', 184, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(804, 73, 3, 2, 'out', 'sale', 184, '2025-03-26 12:08:47', '2025-03-26 12:08:47'),
(805, 100, 19, 2, 'out', 'sale', 185, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(806, 100, 19, 2, 'out', 'sale', 185, '2024-10-15 13:41:07', '2024-10-15 13:41:07'),
(807, 64, 12, 4, 'out', 'sale', 186, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(808, 64, 12, 4, 'out', 'sale', 186, '2024-10-22 02:50:24', '2024-10-22 02:50:24'),
(809, 8, 13, 2, 'out', 'sale', 187, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(810, 8, 13, 2, 'out', 'sale', 187, '2024-12-19 05:51:46', '2024-12-19 05:51:46'),
(811, 78, 9, 2, 'out', 'sale', 188, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(812, 78, 9, 2, 'out', 'sale', 188, '2024-10-30 12:32:37', '2024-10-30 12:32:37'),
(813, 12, 9, 5, 'out', 'sale', 188, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(814, 12, 9, 5, 'out', 'sale', 188, '2024-10-30 12:32:37', '2024-10-30 12:32:37'),
(815, 76, 6, 2, 'out', 'sale', 189, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(816, 76, 6, 2, 'out', 'sale', 189, '2024-12-22 10:37:10', '2024-12-22 10:37:10'),
(817, 12, 9, 1, 'out', 'sale', 190, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(818, 12, 9, 1, 'out', 'sale', 190, '2024-12-28 09:35:04', '2024-12-28 09:35:04'),
(819, 27, 7, 3, 'out', 'sale', 191, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(820, 27, 7, 3, 'out', 'sale', 191, '2024-09-15 10:39:37', '2024-09-15 10:39:37'),
(821, 26, 7, 3, 'out', 'sale', 191, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(822, 26, 7, 3, 'out', 'sale', 191, '2024-09-15 10:39:37', '2024-09-15 10:39:37'),
(823, 65, 7, 4, 'out', 'sale', 191, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(824, 65, 7, 4, 'out', 'sale', 191, '2024-09-15 10:39:37', '2024-09-15 10:39:37'),
(825, 37, 7, 4, 'out', 'sale', 191, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(826, 37, 7, 4, 'out', 'sale', 191, '2024-09-15 10:39:37', '2024-09-15 10:39:37'),
(827, 27, 7, 2, 'out', 'sale', 192, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(828, 27, 7, 2, 'out', 'sale', 192, '2025-03-12 13:04:53', '2025-03-12 13:04:53'),
(829, 65, 7, 1, 'out', 'sale', 192, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(830, 65, 7, 1, 'out', 'sale', 192, '2025-03-12 13:04:53', '2025-03-12 13:04:53'),
(831, 26, 7, 5, 'out', 'sale', 192, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(832, 26, 7, 5, 'out', 'sale', 192, '2025-03-12 13:04:53', '2025-03-12 13:04:53'),
(833, 96, 3, 1, 'out', 'sale', 193, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(834, 96, 3, 1, 'out', 'sale', 193, '2025-03-25 05:30:10', '2025-03-25 05:30:10'),
(835, 89, 3, 1, 'out', 'sale', 193, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(836, 89, 3, 1, 'out', 'sale', 193, '2025-03-25 05:30:10', '2025-03-25 05:30:10'),
(837, 11, 3, 4, 'out', 'sale', 193, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(838, 11, 3, 4, 'out', 'sale', 193, '2025-03-25 05:30:10', '2025-03-25 05:30:10'),
(839, 21, 3, 4, 'out', 'sale', 193, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(840, 21, 3, 4, 'out', 'sale', 193, '2025-03-25 05:30:10', '2025-03-25 05:30:10'),
(841, 33, 1, 5, 'out', 'sale', 194, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(842, 33, 1, 5, 'out', 'sale', 194, '2024-12-25 07:04:49', '2024-12-25 07:04:49'),
(843, 6, 1, 2, 'out', 'sale', 194, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(844, 6, 1, 2, 'out', 'sale', 194, '2024-12-25 07:04:49', '2024-12-25 07:04:49'),
(845, 43, 1, 4, 'out', 'sale', 194, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(846, 43, 1, 4, 'out', 'sale', 194, '2024-12-25 07:04:49', '2024-12-25 07:04:49'),
(847, 33, 1, 5, 'out', 'sale', 195, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(848, 33, 1, 5, 'out', 'sale', 195, '2024-11-24 01:19:47', '2024-11-24 01:19:47'),
(849, 13, 14, 3, 'out', 'sale', 196, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(850, 13, 14, 3, 'out', 'sale', 196, '2024-07-04 21:24:34', '2024-07-04 21:24:34'),
(851, 9, 14, 5, 'out', 'sale', 196, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(852, 9, 14, 5, 'out', 'sale', 196, '2024-07-04 21:24:34', '2024-07-04 21:24:34'),
(853, 41, 14, 3, 'out', 'sale', 196, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(854, 41, 14, 3, 'out', 'sale', 196, '2024-07-04 21:24:34', '2024-07-04 21:24:34'),
(855, 80, 15, 5, 'out', 'sale', 197, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(856, 80, 15, 5, 'out', 'sale', 197, '2025-06-06 07:35:37', '2025-06-06 07:35:37'),
(857, 88, 15, 5, 'out', 'sale', 197, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(858, 88, 15, 5, 'out', 'sale', 197, '2025-06-06 07:35:37', '2025-06-06 07:35:37'),
(859, 36, 15, 1, 'out', 'sale', 197, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(860, 36, 15, 1, 'out', 'sale', 197, '2025-06-06 07:35:37', '2025-06-06 07:35:37'),
(861, 8, 13, 1, 'out', 'sale', 198, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(862, 8, 13, 1, 'out', 'sale', 198, '2025-06-03 00:03:55', '2025-06-03 00:03:55'),
(863, 8, 13, 2, 'out', 'sale', 199, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(864, 8, 13, 2, 'out', 'sale', 199, '2024-08-30 09:31:43', '2024-08-30 09:31:43'),
(865, 83, 10, 2, 'out', 'sale', 200, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(866, 83, 10, 2, 'out', 'sale', 200, '2024-12-05 00:39:19', '2024-12-05 00:39:19'),
(867, 47, 10, 1, 'out', 'sale', 200, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(868, 47, 10, 1, 'out', 'sale', 200, '2024-12-05 00:39:19', '2024-12-05 00:39:19'),
(869, 51, 10, 1, 'out', 'sale', 200, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(870, 51, 10, 1, 'out', 'sale', 200, '2024-12-05 00:39:19', '2024-12-05 00:39:19'),
(871, 89, 3, 2, 'out', 'sale', 201, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(872, 89, 3, 2, 'out', 'sale', 201, '2024-12-24 04:18:54', '2024-12-24 04:18:54'),
(873, 42, 3, 2, 'out', 'sale', 201, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(874, 42, 3, 2, 'out', 'sale', 201, '2024-12-24 04:18:54', '2024-12-24 04:18:54'),
(875, 11, 3, 1, 'out', 'sale', 201, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(876, 11, 3, 1, 'out', 'sale', 201, '2024-12-24 04:18:54', '2024-12-24 04:18:54'),
(877, 60, 2, 3, 'out', 'sale', 202, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(878, 60, 2, 3, 'out', 'sale', 202, '2024-09-06 19:57:50', '2024-09-06 19:57:50'),
(879, 79, 5, 1, 'out', 'sale', 203, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(880, 79, 5, 1, 'out', 'sale', 203, '2025-04-11 08:06:24', '2025-04-11 08:06:24'),
(881, 36, 15, 1, 'out', 'sale', 204, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(882, 36, 15, 1, 'out', 'sale', 204, '2024-07-26 08:24:58', '2024-07-26 08:24:58'),
(883, 98, 11, 5, 'out', 'sale', 205, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(884, 98, 11, 5, 'out', 'sale', 205, '2024-12-04 06:37:46', '2024-12-04 06:37:46'),
(885, 71, 11, 1, 'out', 'sale', 205, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(886, 71, 11, 1, 'out', 'sale', 205, '2024-12-04 06:37:46', '2024-12-04 06:37:46'),
(887, 37, 7, 5, 'out', 'sale', 206, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(888, 37, 7, 5, 'out', 'sale', 206, '2024-12-07 13:16:51', '2024-12-07 13:16:51'),
(889, 81, 16, 5, 'out', 'sale', 207, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(890, 81, 16, 5, 'out', 'sale', 207, '2025-01-02 10:37:44', '2025-01-02 10:37:44'),
(891, 34, 20, 4, 'out', 'sale', 208, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(892, 34, 20, 4, 'out', 'sale', 208, '2024-06-21 05:19:58', '2024-06-21 05:19:58'),
(893, 43, 1, 5, 'out', 'sale', 209, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(894, 43, 1, 5, 'out', 'sale', 209, '2025-02-28 10:37:23', '2025-02-28 10:37:23'),
(895, 51, 10, 2, 'out', 'sale', 210, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(896, 51, 10, 2, 'out', 'sale', 210, '2025-01-11 20:32:19', '2025-01-11 20:32:19'),
(897, 76, 6, 5, 'out', 'sale', 211, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(898, 76, 6, 5, 'out', 'sale', 211, '2024-08-27 04:00:02', '2024-08-27 04:00:02'),
(899, 40, 5, 5, 'out', 'sale', 212, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(900, 40, 5, 5, 'out', 'sale', 212, '2025-02-06 10:58:29', '2025-02-06 10:58:29'),
(901, 79, 5, 5, 'out', 'sale', 212, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(902, 79, 5, 5, 'out', 'sale', 212, '2025-02-06 10:58:29', '2025-02-06 10:58:29'),
(903, 9, 14, 3, 'out', 'sale', 213, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(904, 9, 14, 3, 'out', 'sale', 213, '2025-01-19 19:06:15', '2025-01-19 19:06:15'),
(905, 41, 14, 4, 'out', 'sale', 213, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(906, 41, 14, 4, 'out', 'sale', 213, '2025-01-19 19:06:15', '2025-01-19 19:06:15'),
(907, 13, 14, 2, 'out', 'sale', 213, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(908, 13, 14, 2, 'out', 'sale', 213, '2025-01-19 19:06:15', '2025-01-19 19:06:15'),
(909, 29, 8, 5, 'out', 'sale', 214, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(910, 29, 8, 5, 'out', 'sale', 214, '2025-02-17 19:52:18', '2025-02-17 19:52:18'),
(911, 17, 8, 2, 'out', 'sale', 214, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(912, 17, 8, 2, 'out', 'sale', 214, '2025-02-17 19:52:18', '2025-02-17 19:52:18'),
(913, 56, 8, 5, 'out', 'sale', 214, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(914, 56, 8, 5, 'out', 'sale', 214, '2025-02-17 19:52:18', '2025-02-17 19:52:18'),
(915, 95, 8, 4, 'out', 'sale', 214, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(916, 95, 8, 4, 'out', 'sale', 214, '2025-02-17 19:52:18', '2025-02-17 19:52:18'),
(917, 40, 5, 2, 'out', 'sale', 215, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(918, 40, 5, 2, 'out', 'sale', 215, '2024-11-11 07:16:56', '2024-11-11 07:16:56'),
(919, 59, 5, 2, 'out', 'sale', 215, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(920, 59, 5, 2, 'out', 'sale', 215, '2024-11-11 07:16:56', '2024-11-11 07:16:56'),
(921, 47, 10, 5, 'out', 'sale', 216, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(922, 47, 10, 5, 'out', 'sale', 216, '2024-08-31 13:29:29', '2024-08-31 13:29:29'),
(923, 83, 10, 3, 'out', 'sale', 216, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(924, 83, 10, 3, 'out', 'sale', 216, '2024-08-31 13:29:29', '2024-08-31 13:29:29'),
(925, 86, 10, 5, 'out', 'sale', 216, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(926, 86, 10, 5, 'out', 'sale', 216, '2024-08-31 13:29:29', '2024-08-31 13:29:29'),
(927, 90, 10, 5, 'out', 'sale', 216, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(928, 90, 10, 5, 'out', 'sale', 216, '2024-08-31 13:29:29', '2024-08-31 13:29:29'),
(929, 11, 3, 3, 'out', 'sale', 217, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(930, 11, 3, 3, 'out', 'sale', 217, '2025-03-09 20:50:15', '2025-03-09 20:50:15'),
(931, 42, 3, 3, 'out', 'sale', 217, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(932, 42, 3, 3, 'out', 'sale', 217, '2025-03-09 20:50:15', '2025-03-09 20:50:15'),
(933, 78, 9, 1, 'out', 'sale', 218, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(934, 78, 9, 1, 'out', 'sale', 218, '2025-06-10 23:23:55', '2025-06-10 23:23:55'),
(935, 12, 9, 2, 'out', 'sale', 218, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(936, 12, 9, 2, 'out', 'sale', 218, '2025-06-10 23:23:55', '2025-06-10 23:23:55'),
(937, 22, 18, 5, 'out', 'sale', 219, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(938, 22, 18, 5, 'out', 'sale', 219, '2025-04-09 13:14:19', '2025-04-09 13:14:19'),
(939, 72, 18, 5, 'out', 'sale', 219, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(940, 72, 18, 5, 'out', 'sale', 219, '2025-04-09 13:14:19', '2025-04-09 13:14:19'),
(941, 47, 10, 4, 'out', 'sale', 220, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(942, 47, 10, 4, 'out', 'sale', 220, '2024-07-21 17:39:41', '2024-07-21 17:39:41'),
(943, 86, 10, 5, 'out', 'sale', 220, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(944, 86, 10, 5, 'out', 'sale', 220, '2024-07-21 17:39:41', '2024-07-21 17:39:41'),
(945, 12, 9, 1, 'out', 'sale', 221, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(946, 12, 9, 1, 'out', 'sale', 221, '2024-09-07 02:45:48', '2024-09-07 02:45:48'),
(947, 78, 9, 1, 'out', 'sale', 221, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(948, 78, 9, 1, 'out', 'sale', 221, '2024-09-07 02:45:48', '2024-09-07 02:45:48'),
(949, 100, 19, 4, 'out', 'sale', 222, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(950, 100, 19, 4, 'out', 'sale', 222, '2024-12-26 09:53:00', '2024-12-26 09:53:00'),
(951, 39, 19, 5, 'out', 'sale', 222, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(952, 39, 19, 5, 'out', 'sale', 222, '2024-12-26 09:53:00', '2024-12-26 09:53:00'),
(953, 18, 16, 1, 'out', 'sale', 223, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(954, 18, 16, 1, 'out', 'sale', 223, '2024-07-15 22:31:47', '2024-07-15 22:31:47'),
(955, 99, 16, 4, 'out', 'sale', 223, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(956, 99, 16, 4, 'out', 'sale', 223, '2024-07-15 22:31:47', '2024-07-15 22:31:47'),
(957, 34, 20, 1, 'out', 'sale', 224, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(958, 34, 20, 1, 'out', 'sale', 224, '2024-07-05 09:26:12', '2024-07-05 09:26:12'),
(959, 53, 20, 5, 'out', 'sale', 224, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(960, 53, 20, 5, 'out', 'sale', 224, '2024-07-05 09:26:12', '2024-07-05 09:26:12'),
(961, 45, 11, 2, 'out', 'sale', 225, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(962, 45, 11, 2, 'out', 'sale', 225, '2025-05-02 21:11:17', '2025-05-02 21:11:17'),
(963, 98, 11, 3, 'out', 'sale', 225, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(964, 98, 11, 3, 'out', 'sale', 225, '2025-05-02 21:11:17', '2025-05-02 21:11:17'),
(965, 71, 11, 5, 'out', 'sale', 225, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(966, 71, 11, 5, 'out', 'sale', 225, '2025-05-02 21:11:17', '2025-05-02 21:11:17'),
(967, 45, 11, 5, 'out', 'sale', 227, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(968, 45, 11, 5, 'out', 'sale', 227, '2024-10-30 19:11:21', '2024-10-30 19:11:21'),
(969, 71, 11, 5, 'out', 'sale', 227, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(970, 71, 11, 5, 'out', 'sale', 227, '2024-10-30 19:11:21', '2024-10-30 19:11:21'),
(971, 9, 14, 1, 'out', 'sale', 228, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(972, 9, 14, 1, 'out', 'sale', 228, '2024-11-01 03:59:53', '2024-11-01 03:59:53'),
(973, 91, 12, 5, 'out', 'sale', 229, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(974, 91, 12, 5, 'out', 'sale', 229, '2024-12-23 05:46:49', '2024-12-23 05:46:49'),
(975, 78, 9, 2, 'out', 'sale', 230, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(976, 78, 9, 2, 'out', 'sale', 230, '2025-03-19 05:59:13', '2025-03-19 05:59:13'),
(977, 12, 9, 1, 'out', 'sale', 230, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(978, 12, 9, 1, 'out', 'sale', 230, '2025-03-19 05:59:13', '2025-03-19 05:59:13'),
(979, 78, 9, 3, 'out', 'sale', 231, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(980, 78, 9, 3, 'out', 'sale', 231, '2024-07-15 16:33:40', '2024-07-15 16:33:40'),
(981, 12, 9, 1, 'out', 'sale', 231, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(982, 12, 9, 1, 'out', 'sale', 231, '2024-07-15 16:33:40', '2024-07-15 16:33:40'),
(983, 95, 8, 1, 'out', 'sale', 232, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(984, 95, 8, 1, 'out', 'sale', 232, '2024-11-14 14:49:00', '2024-11-14 14:49:00'),
(985, 35, 8, 4, 'out', 'sale', 232, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(986, 35, 8, 4, 'out', 'sale', 232, '2024-11-14 14:49:00', '2024-11-14 14:49:00'),
(987, 16, 8, 2, 'out', 'sale', 232, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(988, 16, 8, 2, 'out', 'sale', 232, '2024-11-14 14:49:00', '2024-11-14 14:49:00'),
(989, 32, 7, 4, 'out', 'sale', 233, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(990, 32, 7, 4, 'out', 'sale', 233, '2025-04-05 09:28:46', '2025-04-05 09:28:46'),
(991, 65, 7, 3, 'out', 'sale', 233, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(992, 65, 7, 3, 'out', 'sale', 233, '2025-04-05 09:28:46', '2025-04-05 09:28:46'),
(993, 18, 16, 5, 'out', 'sale', 234, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(994, 18, 16, 5, 'out', 'sale', 234, '2025-01-26 01:34:07', '2025-01-26 01:34:07'),
(995, 36, 15, 1, 'out', 'sale', 236, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(996, 36, 15, 1, 'out', 'sale', 236, '2024-07-24 15:58:05', '2024-07-24 15:58:05'),
(997, 68, 17, 2, 'out', 'sale', 237, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(998, 68, 17, 2, 'out', 'sale', 237, '2025-05-18 10:10:10', '2025-05-18 10:10:10'),
(999, 7, 17, 3, 'out', 'sale', 237, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(1000, 7, 17, 3, 'out', 'sale', 237, '2025-05-18 10:10:10', '2025-05-18 10:10:10'),
(1001, 36, 15, 3, 'out', 'sale', 239, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(1002, 36, 15, 3, 'out', 'sale', 239, '2025-02-09 04:09:33', '2025-02-09 04:09:33'),
(1003, 71, 11, 5, 'out', 'sale', 240, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(1004, 71, 11, 5, 'out', 'sale', 240, '2024-12-24 05:54:04', '2024-12-24 05:54:04'),
(1005, 22, 18, 3, 'out', 'sale', 241, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(1006, 22, 18, 3, 'out', 'sale', 241, '2025-04-07 14:41:12', '2025-04-07 14:41:12'),
(1007, 72, 18, 3, 'out', 'sale', 241, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(1008, 72, 18, 3, 'out', 'sale', 241, '2025-04-07 14:41:12', '2025-04-07 14:41:12'),
(1009, 71, 11, 5, 'out', 'sale', 242, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(1010, 71, 11, 5, 'out', 'sale', 242, '2025-03-28 00:49:02', '2025-03-28 00:49:02'),
(1011, 98, 11, 5, 'out', 'sale', 242, '2025-06-15 16:49:38', '2025-06-15 16:49:38'),
(1012, 98, 11, 5, 'out', 'sale', 242, '2025-03-28 00:49:02', '2025-03-28 00:49:02'),
(1013, 45, 11, 4, 'out', 'sale', 242, '2025-06-15 16:49:39', '2025-06-15 16:49:39'),
(1014, 45, 11, 4, 'out', 'sale', 242, '2025-03-28 00:49:02', '2025-03-28 00:49:02'),
(1015, 52, 20, 1, 'out', 'sale', 244, '2025-06-15 16:49:39', '2025-06-15 16:49:39'),
(1016, 52, 20, 1, 'out', 'sale', 244, '2025-05-21 18:45:22', '2025-05-21 18:45:22'),
(1017, 50, 20, 1, 'out', 'sale', 244, '2025-06-15 16:49:39', '2025-06-15 16:49:39'),
(1018, 50, 20, 1, 'out', 'sale', 244, '2025-05-21 18:45:22', '2025-05-21 18:45:22'),
(1019, 12, 9, 5, 'out', 'sale', 246, '2025-06-15 16:49:39', '2025-06-15 16:49:39'),
(1020, 12, 9, 5, 'out', 'sale', 246, '2025-01-07 18:26:03', '2025-01-07 18:26:03'),
(1021, 78, 9, 1, 'out', 'sale', 246, '2025-06-15 16:49:39', '2025-06-15 16:49:39'),
(1022, 78, 9, 1, 'out', 'sale', 246, '2025-01-07 18:26:03', '2025-01-07 18:26:03'),
(1023, 28, 4, 1, 'out', 'sale', 247, '2025-06-15 16:49:39', '2025-06-15 16:49:39'),
(1024, 28, 4, 1, 'out', 'sale', 247, '2024-11-16 12:32:12', '2024-11-16 12:32:12'),
(1025, 74, 4, 5, 'out', 'sale', 247, '2025-06-15 16:49:39', '2025-06-15 16:49:39'),
(1026, 74, 4, 5, 'out', 'sale', 247, '2024-11-16 12:32:12', '2024-11-16 12:32:12'),
(1027, 40, 5, 4, 'out', 'sale', 248, '2025-06-15 16:49:39', '2025-06-15 16:49:39'),
(1028, 40, 5, 4, 'out', 'sale', 248, '2024-12-01 15:11:21', '2024-12-01 15:11:21'),
(1029, 53, 20, 2, 'out', 'sale', 250, '2025-06-15 16:49:39', '2025-06-15 16:49:39'),
(1030, 53, 20, 2, 'out', 'sale', 250, '2025-05-19 10:01:08', '2025-05-19 10:01:08');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_status`
--

CREATE TABLE `subscription_status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lembaga_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('active','inactive','trial','cancelled') NOT NULL,
  `tier` enum('free','basic','pro','enterprise') NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscription_status`
--

INSERT INTO `subscription_status` (`id`, `lembaga_id`, `status`, `tier`, `start_date`, `end_date`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'active', 'pro', '2025-05-16', '2026-06-15', 1, '2025-06-15 09:49:30', '2025-06-15 09:49:30');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_transaction`
--

CREATE TABLE `subscription_transaction` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lembaga_id` bigint(20) UNSIGNED NOT NULL,
  `payment_date` date NOT NULL,
  `amount` decimal(14,2) NOT NULL,
  `payment_method` enum('credit_card','bank_transfer','ewallet','paypal') DEFAULT NULL,
  `status` enum('paid','pending','failed','refunded') NOT NULL,
  `reference_code` varchar(255) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `email_verified_at`, `password`, `profile_picture`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin@gmail.com', '2025-06-15 09:49:30', '$2y$12$lNNRX.U.A771RBlB4BFi8uMec3mLBzwvNWA91L.PHxef4eq.jxFd6', NULL, 'J2z5iiuRP1', '2025-06-15 09:49:30', '2025-06-15 09:49:30');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`kode_barang`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cashledger`
--
ALTER TABLE `cashledger`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cashledger_outlet_id_foreign` (`outlet_id`),
  ADD KEY `cashledger_created_by_foreign` (`created_by`);

--
-- Indexes for table `cicilan`
--
ALTER TABLE `cicilan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cicilan_hutang_id_foreign` (`hutang_id`),
  ADD KEY `cicilan_created_by_foreign` (`created_by`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_user_id_outlet_id_unique` (`user_id`,`outlet_id`),
  ADD KEY `employee_outlet_id_foreign` (`outlet_id`),
  ADD KEY `employee_lembaga_id_foreign` (`lembaga_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `hutang`
--
ALTER TABLE `hutang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hutang_outlet_id_foreign` (`outlet_id`),
  ADD KEY `hutang_created_by_foreign` (`created_by`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lembaga`
--
ALTER TABLE `lembaga`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lembaga_user_role`
--
ALTER TABLE `lembaga_user_role`
  ADD PRIMARY KEY (`user_id`,`role_id`,`lembaga_id`),
  ADD KEY `lembaga_user_role_role_id_foreign` (`role_id`),
  ADD KEY `lembaga_user_role_lembaga_id_foreign` (`lembaga_id`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_items_parent_id_order_index` (`parent_id`,`order`);

--
-- Indexes for table `menu_roles`
--
ALTER TABLE `menu_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menu_roles_menu_item_id_role_id_unique` (`menu_item_id`,`role_id`),
  ADD KEY `menu_roles_menu_item_id_index` (`menu_item_id`),
  ADD KEY `menu_roles_role_id_index` (`role_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `outlet`
--
ALTER TABLE `outlet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `outlet_lembaga_id_foreign` (`lembaga_id`);

--
-- Indexes for table `outletbalance`
--
ALTER TABLE `outletbalance`
  ADD PRIMARY KEY (`outlet_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_outlet_id_foreign` (`outlet_id`),
  ADD KEY `product_barang_id_foreign` (`barang_id`),
  ADD KEY `product_kategori_id_foreign` (`kategori_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_role_name_unique` (`role_name`);

--
-- Indexes for table `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_outlet_id_foreign` (`outlet_id`),
  ADD KEY `sale_created_by_foreign` (`created_by`);

--
-- Indexes for table `saleitem`
--
ALTER TABLE `saleitem`
  ADD PRIMARY KEY (`id`),
  ADD KEY `saleitem_sale_id_foreign` (`sale_id`),
  ADD KEY `saleitem_product_id_foreign` (`product_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `stockmutation`
--
ALTER TABLE `stockmutation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stockmutation_product_id_foreign` (`product_id`),
  ADD KEY `stockmutation_outlet_id_foreign` (`outlet_id`);

--
-- Indexes for table `subscription_status`
--
ALTER TABLE `subscription_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscription_status_lembaga_id_foreign` (`lembaga_id`);

--
-- Indexes for table `subscription_transaction`
--
ALTER TABLE `subscription_transaction`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscription_transaction_reference_code_unique` (`reference_code`),
  ADD KEY `subscription_transaction_lembaga_id_foreign` (`lembaga_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `user_role_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `kode_barang` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `cashledger`
--
ALTER TABLE `cashledger`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `cicilan`
--
ALTER TABLE `cicilan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hutang`
--
ALTER TABLE `hutang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `lembaga`
--
ALTER TABLE `lembaga`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `menu_roles`
--
ALTER TABLE `menu_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `outlet`
--
ALTER TABLE `outlet`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sale`
--
ALTER TABLE `sale`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

--
-- AUTO_INCREMENT for table `saleitem`
--
ALTER TABLE `saleitem`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=516;

--
-- AUTO_INCREMENT for table `stockmutation`
--
ALTER TABLE `stockmutation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1031;

--
-- AUTO_INCREMENT for table `subscription_status`
--
ALTER TABLE `subscription_status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subscription_transaction`
--
ALTER TABLE `subscription_transaction`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cashledger`
--
ALTER TABLE `cashledger`
  ADD CONSTRAINT `cashledger_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cashledger_outlet_id_foreign` FOREIGN KEY (`outlet_id`) REFERENCES `outlet` (`id`);

--
-- Constraints for table `cicilan`
--
ALTER TABLE `cicilan`
  ADD CONSTRAINT `cicilan_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cicilan_hutang_id_foreign` FOREIGN KEY (`hutang_id`) REFERENCES `hutang` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_lembaga_id_foreign` FOREIGN KEY (`lembaga_id`) REFERENCES `lembaga` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employee_outlet_id_foreign` FOREIGN KEY (`outlet_id`) REFERENCES `outlet` (`id`),
  ADD CONSTRAINT `employee_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `hutang`
--
ALTER TABLE `hutang`
  ADD CONSTRAINT `hutang_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `hutang_outlet_id_foreign` FOREIGN KEY (`outlet_id`) REFERENCES `outlet` (`id`);

--
-- Constraints for table `lembaga_user_role`
--
ALTER TABLE `lembaga_user_role`
  ADD CONSTRAINT `lembaga_user_role_lembaga_id_foreign` FOREIGN KEY (`lembaga_id`) REFERENCES `lembaga` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lembaga_user_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lembaga_user_role_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD CONSTRAINT `menu_items_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `menu_roles`
--
ALTER TABLE `menu_roles`
  ADD CONSTRAINT `menu_roles_menu_item_id_foreign` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `menu_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `outlet`
--
ALTER TABLE `outlet`
  ADD CONSTRAINT `outlet_lembaga_id_foreign` FOREIGN KEY (`lembaga_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `outletbalance`
--
ALTER TABLE `outletbalance`
  ADD CONSTRAINT `outletbalance_outlet_id_foreign` FOREIGN KEY (`outlet_id`) REFERENCES `outlet` (`id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`kode_barang`),
  ADD CONSTRAINT `product_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`),
  ADD CONSTRAINT `product_outlet_id_foreign` FOREIGN KEY (`outlet_id`) REFERENCES `outlet` (`id`);

--
-- Constraints for table `sale`
--
ALTER TABLE `sale`
  ADD CONSTRAINT `sale_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `sale_outlet_id_foreign` FOREIGN KEY (`outlet_id`) REFERENCES `outlet` (`id`);

--
-- Constraints for table `saleitem`
--
ALTER TABLE `saleitem`
  ADD CONSTRAINT `saleitem_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `saleitem_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sale` (`id`);

--
-- Constraints for table `stockmutation`
--
ALTER TABLE `stockmutation`
  ADD CONSTRAINT `stockmutation_outlet_id_foreign` FOREIGN KEY (`outlet_id`) REFERENCES `outlet` (`id`),
  ADD CONSTRAINT `stockmutation_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `subscription_status`
--
ALTER TABLE `subscription_status`
  ADD CONSTRAINT `subscription_status_lembaga_id_foreign` FOREIGN KEY (`lembaga_id`) REFERENCES `lembaga` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subscription_transaction`
--
ALTER TABLE `subscription_transaction`
  ADD CONSTRAINT `subscription_transaction_lembaga_id_foreign` FOREIGN KEY (`lembaga_id`) REFERENCES `lembaga` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `user_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_role_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
