-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2026 at 05:34 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

SET FOREIGN_KEY_CHECKS = 0;

--
-- Database: `laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

DROP TABLE IF EXISTS `banner`;
CREATE TABLE `banner` (
  `id_banner` bigint(20) UNSIGNED NOT NULL,
  `gambar_banner` varchar(255) NOT NULL,
  `type` enum('slider','promo_large','promo_small') NOT NULL DEFAULT 'slider',
  `position` int(11) NOT NULL DEFAULT 0,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id_banner`, `gambar_banner`, `type`, `position`, `title`, `subtitle`, `link`, `active`, `created_at`, `updated_at`) VALUES
(1, 'banner/banneraro.png', 'slider', 1, NULL, NULL, NULL, 1, '2026-02-18 02:27:32', '2026-02-18 02:27:32'),
(2, 'banner/banneraro2.png', 'slider', 2, NULL, NULL, NULL, 1, '2026-02-18 02:27:32', '2026-02-18 02:27:32');

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

DROP TABLE IF EXISTS `brand`;
CREATE TABLE `brand` (
  `id_brand` bigint(20) UNSIGNED NOT NULL,
  `nama_brand` varchar(255) NOT NULL,
  `deskripsi_brand` text DEFAULT NULL,
  `logo_brand` varchar(255) DEFAULT NULL,
  `gambar_background` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id_brand`, `nama_brand`, `deskripsi_brand`, `logo_brand`, `gambar_background`, `created_at`, `updated_at`) VALUES
(1, 'aro  baskara esa living', NULL, '1771989841_logo.png', 'brand_bg/aro_bg.jpg', '2026-02-11 00:20:39', '2026-02-24 20:24:01'),
(2, 'Acer', NULL, 'brand/logo_acer.png', 'brand_bg/acer_bg.jpg', '2026-02-11 00:20:39', '2026-02-11 00:20:39'),
(3, 'APC', NULL, 'brand/logo_apc.png', 'brand_bg/apc_bg.jpg', '2026-02-11 00:20:39', '2026-02-11 00:20:39'),
(4, 'Umalo', NULL, 'brand/logo_umalo.png', 'brand_bg/umalo_bg.jpg', '2026-02-11 00:20:39', '2026-02-11 00:20:39'),
(5, 'Ferro', NULL, 'brand/logo_ferro.png', 'brand_bg/ferro_bg.jpg', '2026-02-11 00:20:39', '2026-02-11 00:20:39'),
(6, 'Hartech', NULL, 'brand/logo_hartech.png', 'brand_bg/hartech_bg.jpg', '2026-02-11 00:20:39', '2026-02-11 00:20:39'),
(7, 'HP', NULL, 'brand/logo_hp.svg', 'brand_bg/hp_bg.jpg', '2026-02-11 00:20:39', '2026-02-11 00:20:39'),
(8, 'Mubarix', NULL, 'brand/logo_mubarix.webp', 'brand_bg/mubarix_bg.jpg', '2026-02-11 00:20:39', '2026-02-11 00:20:39'),
(9, 'Panasonic', NULL, 'brand/logo_panasonic.jpg', 'brand_bg/panasonic_bg.jpg', '2026-02-11 00:20:39', '2026-02-11 00:20:39'),
(14, 'aro baskara esa education', NULL, '1771989830_logo.png', NULL, '2026-02-24 20:23:50', '2026-02-24 20:23:50');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart` (
  `id_cart` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id_cart`, `id_user`, `status`, `created_at`, `updated_at`) VALUES
(4, 4, 'ordered', '2026-02-18 22:03:25', '2026-02-18 22:05:23'),
(5, 4, 'ordered', '2026-02-18 22:06:19', '2026-02-18 22:06:55'),
(6, 4, 'ordered', '2026-02-18 22:26:40', '2026-02-18 22:27:04'),
(7, 4, 'ordered', '2026-02-19 00:22:30', '2026-02-19 00:29:19'),
(8, 4, 'ordered', '2026-02-19 00:35:43', '2026-02-19 00:36:07'),
(9, 3, 'active', '2026-02-19 02:12:00', '2026-02-19 02:12:00');

-- --------------------------------------------------------

--
-- Table structure for table `cart_detail`
--

DROP TABLE IF EXISTS `cart_detail`;
CREATE TABLE `cart_detail` (
  `id_cart_detail` bigint(20) UNSIGNED NOT NULL,
  `id_cart` bigint(20) UNSIGNED NOT NULL,
  `id_produk` bigint(20) UNSIGNED NOT NULL,
  `qty_cart` int(11) NOT NULL,
  `harga` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_detail`
--

INSERT INTO `cart_detail` (`id_cart_detail`, `id_cart`, `id_produk`, `qty_cart`, `harga`, `created_at`, `updated_at`) VALUES
(5, 4, 28, 1, 5500000.00, '2026-02-18 22:03:25', '2026-02-18 22:03:25'),
(6, 5, 22, 1, 22500000.00, '2026-02-18 22:06:19', '2026-02-18 22:06:19'),
(7, 6, 19, 1, 17000000.00, '2026-02-18 22:26:40', '2026-02-18 22:26:40'),
(8, 7, 21, 1, 28000000.00, '2026-02-19 00:22:30', '2026-02-19 00:22:30'),
(9, 8, 22, 1, 22500000.00, '2026-02-19 00:35:43', '2026-02-19 00:35:43'),
(10, 9, 26, 1, 899000.00, '2026-02-19 02:12:00', '2026-02-19 02:12:00');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
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
-- Table structure for table `footer_links`
--

DROP TABLE IF EXISTS `footer_links`;
CREATE TABLE `footer_links` (
  `id_footer_link` bigint(20) UNSIGNED NOT NULL,
  `column_title` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'text',
  `label` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `footer_links`
--

INSERT INTO `footer_links` (`id_footer_link`, `column_title`, `type`, `label`, `url`, `image_path`, `order`, `created_at`, `updated_at`) VALUES
(1, 'LAYANAN PELANGGAN', 'text', 'Bantuan', '#', NULL, 1, '2026-02-15 22:10:49', '2026-02-15 22:10:49'),
(2, 'LAYANAN PELANGGAN', 'text', 'Metode Pembayaran', '#', NULL, 2, '2026-02-15 22:10:49', '2026-02-15 22:10:49'),
(3, 'LAYANAN PELANGGAN', 'text', 'Lacak Pesanan', '#', NULL, 3, '2026-02-15 22:10:49', '2026-02-15 22:10:49'),
(4, 'LAYANAN PELANGGAN', 'text', 'Kebijakan Privasi', '#', NULL, 4, '2026-02-15 22:10:49', '2026-02-15 22:10:49'),
(5, 'JELAJAHI', 'text', 'Tentang Kami', '#', NULL, 1, '2026-02-15 22:10:49', '2026-02-15 22:10:49'),
(6, 'JELAJAHI', 'text', 'Karir', '#', NULL, 2, '2026-02-15 22:10:49', '2026-02-15 22:10:49'),
(7, 'JELAJAHI', 'text', 'Blog', '#', NULL, 3, '2026-02-15 22:10:49', '2026-02-15 22:10:49'),
(8, 'JELAJAHI', 'text', 'Mitra', '#', NULL, 4, '2026-02-15 22:10:49', '2026-02-15 22:10:49'),
(9, 'PENGIRIMAN', 'image', 'TIKI', '#', '1771220104_TIKI_tiki.png', 1, '2026-02-15 22:16:47', '2026-02-15 22:35:04'),
(10, 'PENGIRIMAN', 'image', 'JNE', '#', '1771220081_JNE_download.png', 2, '2026-02-15 22:16:47', '2026-02-15 22:34:41');

-- --------------------------------------------------------

--
-- Table structure for table `integrated_solutions`
--

DROP TABLE IF EXISTS `integrated_solutions`;
CREATE TABLE `integrated_solutions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT 'Integrated Solutions for Modern Businesses',
  `background_image` varchar(255) DEFAULT NULL,
  `button_text` varchar(255) NOT NULL DEFAULT 'See Now',
  `button_color` varchar(255) NOT NULL DEFAULT '#FF5F57',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `integrated_solutions`
--

INSERT INTO `integrated_solutions` (`id`, `title`, `background_image`, `button_text`, `button_color`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Integrated Solutions for Modern Businesses', '1771921680_integrated_bg.png', 'See Now', '#FF5F57', 1, '2026-02-23 23:18:30', '2026-02-24 01:28:00');

-- --------------------------------------------------------

--
-- Table structure for table `integrated_solution_categories`
--

DROP TABLE IF EXISTS `integrated_solution_categories`;
CREATE TABLE `integrated_solution_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `integrated_solution_id` bigint(20) UNSIGNED NOT NULL,
  `kategori_id` bigint(20) UNSIGNED NOT NULL,
  `category_image` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `integrated_solution_categories`
--

INSERT INTO `integrated_solution_categories` (`id`, `integrated_solution_id`, `kategori_id`, `category_image`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(4, 1, 1, '1771922096_cat_0.jpg', 0, 1, '2026-02-24 01:34:56', '2026-02-24 01:34:56'),
(5, 1, 2, '1771922096_cat_1.jpg', 1, 1, '2026-02-24 01:34:56', '2026-02-24 01:34:56'),
(6, 1, 3, '1771922096_cat_2.jpg', 2, 1, '2026-02-24 01:34:56', '2026-02-24 01:34:56');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
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

DROP TABLE IF EXISTS `job_batches`;
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

DROP TABLE IF EXISTS `kategori`;
CREATE TABLE `kategori` (
  `id_kategori` bigint(20) UNSIGNED NOT NULL,
  `nama_kategori` varchar(255) NOT NULL,
  `icon_kategori` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `icon_kategori`, `created_at`, `updated_at`) VALUES
(1, 'Furniture Kantor', 'kategori/furniturekantor.svg', '2026-02-12 06:16:15', '2026-02-12 06:16:15'),
(2, 'Furniture Kesiswaan', 'kategori/furniturekesiswaan.svg', '2026-02-12 06:16:15', '2026-02-12 06:16:15'),
(3, 'Peralatan Pendidikan ', 'kategori/peralatanpendidikan.svg', '2026-02-12 06:16:15', '2026-02-12 06:16:15'),
(4, 'Mesin dan Perkakas', 'kategori/mesindanperkakas.svg', '2026-02-12 06:16:15', '2026-02-12 06:16:15'),
(5, 'Peralatan Dapur', 'kategori/perlatandapur.svg', '2026-02-12 06:16:15', '2026-02-12 06:16:15'),
(6, 'Peralatan Elektronik', 'kategori/peralatanelektronik.svg', '2026-02-12 06:16:15', '2026-02-12 06:16:15'),
(7, 'Peralatan AID Kit', 'kategori/peralatanaidkit.svg', '2026-02-12 06:16:15', '2026-02-12 06:16:15'),
(8, 'Elektronik', 'elektronik.png', '2026-02-12 08:15:17', '2026-02-12 08:15:17'),
(9, 'Fashion', 'fashion.png', '2026-02-12 08:15:17', '2026-02-12 08:15:17'),
(10, 'Furniture Kantorr', 'kategori/furniture-kantorr.png', '2026-02-24 00:07:59', '2026-02-24 00:16:59'),
(11, 'Fashion', 'kategori/fashion.png', '2026-02-24 00:24:25', '2026-02-24 00:24:25');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
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
(4, '2024_01_01_000001_create_kategori_table', 1),
(5, '2024_01_01_000002_create_brand_table', 1),
(6, '2024_01_01_000003_create_banner_table', 1),
(7, '2024_01_01_000004_create_perusahaan_table', 1),
(8, '2024_01_01_000005_create_subkategori_table', 1),
(9, '2024_01_01_000006_create_produk_table', 1),
(10, '2024_01_01_000007_create_cart_table', 1),
(11, '2024_01_01_000008_create_order_table', 1),
(12, '2024_01_01_000009_create_wishlist_table', 1),
(13, '2024_01_01_000010_create_ulasan_table', 1),
(14, '2024_01_01_000011_create_cart_detail_table', 1),
(15, '2024_01_01_000012_create_order_item_table', 1),
(16, '2024_01_01_000013_create_payment_table', 1),
(17, '2024_01_01_000014_create_quotation_table', 1),
(18, '2026_02_11_094638_add_gambar_to_produk_table', 1),
(19, '2026_02_12_000001_create_sub_subkategori_table', 1),
(20, '2026_02_12_000002_fix_subkategori_nama_column', 1),
(21, '2026_02_12_000003_migrate_produk_to_sub_subkategori', 1),
(22, '2026_02_12_072241_add_gambar_background_to_brand_table', 2),
(23, '2026_02_12_160700_add_icon_kategori_to_kategori_table', 2),
(24, '2026_02_12_190000_add_shipping_fields_to_order_table', 3),
(25, '2026_02_13_034722_add_specification_fields_to_produk_table', 4),
(26, '2026_02_13_051958_make_harga_produk_nullable_in_produk_table', 5),
(27, '2026_02_16_042149_add_details_to_perusahaan_table', 6),
(28, '2026_02_16_042150_add_details_to_banner_table', 6),
(29, '2026_02_16_042151_create_footer_links_table', 6),
(30, '2026_02_16_051139_add_youtube_to_perusahaan_table', 7),
(31, '2026_02_16_121130_add_youtube_to_perusahaan_table', 7),
(32, '2026_02_16_121400_add_image_to_footer_links_table', 8),
(33, '2026_02_16_055051_add_slug_to_produk_table', 9),
(34, '2026_02_18_083126_update_banner_types_for_separation', 10),
(35, '2026_02_18_083833_create_slider_banners_table', 10),
(36, '2026_02_18_083838_create_promo_banners_table', 10),
(41, '2026_02_18_092607_create_temp_banner_table', 11),
(42, '2026_02_18_083854_migrate_banners_to_separate_tables', 12),
(45, '2026_02_18_090600_remove_type_from_promo_banners_table', 13),
(46, '2026_02_18_100052_create_promo_details_table', 14),
(47, '2026_02_18_103348_make_link_nullable_in_promo_banners_table', 15),
(49, '2026_02_18_103813_simplify_promo_banners_table_structure', 16),
(50, '2026_02_18_110837_add_missing_columns_to_promo_details_table', 17),
(51, '2026_02_18_111158_remove_unwanted_columns_from_promo_details_table', 18),
(52, '2026_02_19_103000_add_promo_detail_id_to_promo_banners_table', 19),
(53, '2026_02_19_000001_add_last_login_fields_to_users_table', 20),
(54, '2026_02_19_000002_add_member_fields_to_users_table', 20),
(55, '2026_02_19_000001_create_payment_accounts_table', 21),
(56, '2026_02_19_000002_add_payment_account_id_to_payment_table', 21),
(57, '2026_02_19_000003_add_admin_note_to_payment_table', 22),
(58, '2026_02_19_000004_create_quotation_items_table', 23),
(60, '2026_02_24_054508_create_integrated_solutions_table', 24),
(61, '2026_02_24_094452_create_special_deals_table', 25),
(62, '2026_02_24_094502_create_special_deal_products_table', 26);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `id_order` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `shipping_name` varchar(255) DEFAULT NULL,
  `shipping_phone` varchar(30) DEFAULT NULL,
  `shipping_address` text DEFAULT NULL,
  `shipping_city` varchar(255) DEFAULT NULL,
  `shipping_province` varchar(255) DEFAULT NULL,
  `shipping_postcode` varchar(20) DEFAULT NULL,
  `tanggal_order` datetime NOT NULL,
  `total_harga` decimal(15,2) NOT NULL,
  `status_order` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id_order`, `id_user`, `shipping_name`, `shipping_phone`, `shipping_address`, `shipping_city`, `shipping_province`, `shipping_postcode`, `tanggal_order`, `total_harga`, `status_order`, `created_at`, `updated_at`) VALUES
(4, 4, 'Aisyah Ayu Sibarani', '0812345678', 'asdfghjk', 'qwertyui', 'dfgukil', '1234567', '2026-02-19 05:05:23', 5500000.00, 'pending_quotation', '2026-02-18 22:05:23', '2026-02-18 22:05:23'),
(5, 4, 'Aisyah Ayu Sibarani', '0812345678', 'asdfghj', 'qwertyui', 'dfgukil', '1234567', '2026-02-19 05:06:55', 22500000.00, 'pending', '2026-02-18 22:06:55', '2026-02-18 22:06:55'),
(6, 4, 'Aisyah Ayu Sibarani', '0812345678', 'asadfghjkl', 'qwertyui', 'dfgukil', '1234567', '2026-02-19 05:27:04', 17000000.00, 'pending', '2026-02-18 22:27:04', '2026-02-18 22:27:04'),
(7, 4, 'Aisyah Ayu Sibarani', '08567890', 'waesrdtf', 'ewret', 'revvv', '121344', '2026-02-19 07:29:19', 28000000.00, 'paid', '2026-02-19 00:29:19', '2026-02-19 00:52:44'),
(8, 4, 'Aisyah Ayu Sibarani', '08567890', 'asd', 'ewret', 'revvv', '121344', '2026-02-19 07:36:07', 22500000.00, 'pending_quotation', '2026-02-19 00:36:07', '2026-02-19 00:36:07');

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

DROP TABLE IF EXISTS `order_item`;
CREATE TABLE `order_item` (
  `id_order_item` bigint(20) UNSIGNED NOT NULL,
  `id_order` bigint(20) UNSIGNED NOT NULL,
  `id_produk` bigint(20) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_item`
--

INSERT INTO `order_item` (`id_order_item`, `id_order`, `id_produk`, `qty`, `price`, `created_at`, `updated_at`) VALUES
(4, 4, 28, 1, 5500000.00, '2026-02-18 22:05:23', '2026-02-18 22:05:23'),
(5, 5, 22, 1, 22500000.00, '2026-02-18 22:06:55', '2026-02-18 22:06:55'),
(6, 6, 19, 1, 17000000.00, '2026-02-18 22:27:04', '2026-02-18 22:27:04'),
(7, 7, 21, 1, 28000000.00, '2026-02-19 00:29:19', '2026-02-19 00:29:19'),
(8, 8, 22, 1, 22500000.00, '2026-02-19 00:36:07', '2026-02-19 00:36:07');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
CREATE TABLE `payment` (
  `id_payment` bigint(20) UNSIGNED NOT NULL,
  `id_order` bigint(20) UNSIGNED NOT NULL,
  `payment_account_id` bigint(20) UNSIGNED DEFAULT NULL,
  `metode` varchar(255) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `bukti_transfer` varchar(255) DEFAULT NULL,
  `admin_note` text DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `rejected_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id_payment`, `id_order`, `payment_account_id`, `metode`, `amount`, `status`, `bukti_transfer`, `admin_note`, `paid_at`, `rejected_at`, `created_at`, `updated_at`) VALUES
(4, 4, NULL, 'quotation', 5500000.00, 'pending', NULL, NULL, NULL, NULL, '2026-02-18 22:05:23', '2026-02-18 22:05:23'),
(5, 5, NULL, 'qris', 22500000.00, 'pending', NULL, NULL, NULL, NULL, '2026-02-18 22:06:55', '2026-02-18 22:06:55'),
(6, 6, NULL, 'qris', 17000000.00, 'pending', NULL, NULL, NULL, NULL, '2026-02-18 22:27:04', '2026-02-18 22:27:04'),
(7, 7, 1, 'transfer', 28000000.00, 'paid', 'bukti_transfer/bIwfnuIXjLNZ8N5dxZ6wY5vzmL5GaavIbzzy0Ocy.png', NULL, '2026-02-19 02:06:20', NULL, '2026-02-19 00:29:19', '2026-02-19 02:06:20'),
(8, 8, NULL, 'quotation', 22500000.00, 'pending', NULL, NULL, NULL, NULL, '2026-02-19 00:36:07', '2026-02-19 00:36:07');

-- --------------------------------------------------------

--
-- Table structure for table `payment_accounts`
--

DROP TABLE IF EXISTS `payment_accounts`;
CREATE TABLE `payment_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `account_holder` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_accounts`
--

INSERT INTO `payment_accounts` (`id`, `bank_name`, `account_number`, `account_holder`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'bank bni', '1234567890', 'aisyah', 1, '2026-02-19 00:15:35', '2026-02-19 00:15:35');

-- --------------------------------------------------------

--
-- Table structure for table `perusahaan`
--

DROP TABLE IF EXISTS `perusahaan`;
CREATE TABLE `perusahaan` (
  `id_perusahaan` bigint(20) UNSIGNED NOT NULL,
  `nama_perusahaan` varchar(255) NOT NULL,
  `visi` text DEFAULT NULL,
  `misi` text DEFAULT NULL,
  `footer_description` text DEFAULT NULL,
  `alamat_perusahaan` text DEFAULT NULL,
  `notelp_perusahaan` varchar(255) DEFAULT NULL,
  `phone_alt` varchar(255) DEFAULT NULL,
  `email_perusahaan` varchar(255) DEFAULT NULL,
  `email_sales` varchar(255) DEFAULT NULL,
  `website_perusahaan` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `tiktok` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `logo_perusahaan` varchar(255) DEFAULT NULL,
  `member_of_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `perusahaan`
--

INSERT INTO `perusahaan` (`id_perusahaan`, `nama_perusahaan`, `visi`, `misi`, `footer_description`, `alamat_perusahaan`, `notelp_perusahaan`, `phone_alt`, `email_perusahaan`, `email_sales`, `website_perusahaan`, `facebook`, `instagram`, `twitter`, `linkedin`, `tiktok`, `youtube`, `logo_perusahaan`, `member_of_image`, `created_at`, `updated_at`) VALUES
(1, 'PT. ARO BASKARA ESA', 'Menjadi perusahaan ecommerce terpercaya di Indonesia', 'Menyediakan produk berkualitas dan layanan terbaik', NULL, 'Jl. TM. Slamet Riyadi Raya No. 9 RT.1 RW.4 Kb. Manggis. Kec. Matraman, Daerah Khusus Ibukota Jakarta 13150', '(021) 38835187 / +62 822-8888-6009', NULL, 'sales@ayobelanja.co.id', NULL, 'ayobelanja.co.id', 'https://www.facebook.com/', NULL, NULL, NULL, NULL, NULL, '1771218097_logo.png', NULL, '2026-02-12 06:08:08', '2026-02-15 22:20:54'),
(2, 'Arow Ecommerce', 'Menjadi platform ecommerce terdepan.', 'Memberikan pengalaman belanja terbaik.', NULL, 'Jl. Teknologi No. 123, Jakarta', '081234567890', NULL, 'info@arow.com', NULL, 'www.arow.com', NULL, NULL, NULL, NULL, NULL, NULL, 'logo.png', NULL, '2026-02-12 08:15:16', '2026-02-12 08:15:16');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

DROP TABLE IF EXISTS `produk`;
CREATE TABLE `produk` (
  `id_produk` bigint(20) UNSIGNED NOT NULL,
  `id_brand` bigint(20) UNSIGNED NOT NULL,
  `id_sub_subkategori` bigint(20) UNSIGNED NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `deskripsi_produk` text NOT NULL,
  `spesifikasi_produk` longtext DEFAULT NULL,
  `sku_produk` varchar(100) DEFAULT NULL,
  `tipe_produk` varchar(100) DEFAULT NULL,
  `asal_produk` varchar(100) DEFAULT NULL,
  `dimensi_produk` varchar(150) DEFAULT NULL,
  `gambar_produk` varchar(255) DEFAULT NULL,
  `harga_produk` decimal(15,2) DEFAULT NULL,
  `stok_produk` int(11) NOT NULL,
  `status_produk` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `berat_produk` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `id_brand`, `id_sub_subkategori`, `nama_produk`, `slug`, `deskripsi_produk`, `spesifikasi_produk`, `sku_produk`, `tipe_produk`, `asal_produk`, `dimensi_produk`, `gambar_produk`, `harga_produk`, `stok_produk`, `status_produk`, `berat_produk`, `created_at`, `updated_at`) VALUES
(19, 1, 1, 'Google Pixel 8 Pro', 'google-pixel-8-pro', 'The pro-level phone from Google.', NULL, NULL, NULL, NULL, NULL, 'google-pixel-8-pro.jpg', 17000000.00, 45, 'aktif', 0.21, '2026-02-12 08:16:42', '2026-02-15 22:51:11'),
(21, 1, 1, 'ROG Zephyrus G14', 'rog-zephyrus-g14', 'Ultra-slim gaming laptop with AI power.', NULL, NULL, NULL, NULL, NULL, 'rog-zephyrus-g14.jpg', 28000000.00, 30, 'aktif', 1.70, '2026-02-12 08:16:42', '2026-02-15 22:51:11'),
(22, 1, 1, 'Dell XPS 13', 'dell-xps-13', 'Iconic design. Sustainable materials.', NULL, NULL, NULL, NULL, NULL, 'dell-xps-13.jpg', 22500000.00, 25, 'aktif', 1.20, '2026-02-12 08:16:42', '2026-02-15 22:51:11'),
(24, 1, 1, 'Adidas Ultraboost', 'adidas-ultraboost', 'Energy return for every stride.', NULL, NULL, NULL, NULL, NULL, 'adidas-ultraboost.jpg', 2800000.00, 150, 'aktif', 0.80, '2026-02-12 08:16:42', '2026-02-15 22:51:11'),
(25, 1, 1, 'Levi\'s 501 Original Jeans', 'levis-501-original-jeans', 'The blue jean that started it all.', NULL, NULL, NULL, NULL, NULL, 'levis-501.jpg', 1200000.00, 100, 'aktif', 0.60, '2026-02-12 08:16:42', '2026-02-15 22:51:11'),
(26, 1, 1, 'Zara Blazer', 'zara-blazer', 'Tailored blazer with a structured fit.', NULL, NULL, NULL, NULL, NULL, 'zara-blazer.jpg', 899000.00, 75, 'aktif', 0.50, '2026-02-12 08:16:42', '2026-02-15 22:51:11'),
(27, 1, 1, 'H&M Summer Dress', 'hm-summer-dress', 'Floral print dress for summer vibes.', NULL, NULL, NULL, NULL, NULL, 'hm-summer-dress.jpg', 450000.00, 120, 'aktif', 0.30, '2026-02-12 08:16:42', '2026-02-15 22:51:11'),
(28, 1, 1, 'Coach Tabby Bag', 'coach-tabby-bag', 'A modern take on an archival 1970s Coach design.', NULL, NULL, NULL, NULL, NULL, 'coach-tabby.jpg', 5500000.00, 20, 'aktif', 0.70, '2026-02-12 08:16:42', '2026-02-15 22:51:11'),
(29, 1, 1, 'Sony WH-1000XM5', 'sony-wh-1000xm5', 'Industry-leading noise canceling headphones.', NULL, NULL, NULL, NULL, NULL, 'sony-xm5.jpg', 5999000.00, 40, 'aktif', 0.25, '2026-02-12 08:16:42', '2026-02-15 22:51:11'),
(31, 1, 1, 'Logitech MX Master 3S', 'logitech-mx-master-3s', 'Performance wireless mouse.', NULL, NULL, NULL, NULL, NULL, 'logitech-mx-master.jpg', 1600000.00, 90, 'aktif', 0.14, '2026-02-12 08:16:42', '2026-02-15 22:51:11'),
(34, 7, 32, 'Komputer HP ProDesk 400 G9 – Intel Core i5 – 8GB RAM – 512GB SSD', 'komputer-hp-prodesk-400-g9-intel-core-i5-8gb-ram-512gb-ssd', 'rrrrrrrrr', NULL, '0', 'IR-01A', 'Indonesia', 'P x L x T : 1400 x 1400 x 750/1200 mm', '1771993572.jpg', 1000000.00, 4, 'aktif', 100.00, '2026-02-24 03:32:51', '2026-02-24 21:26:12');

-- --------------------------------------------------------

--
-- Table structure for table `promo_banners`
--

DROP TABLE IF EXISTS `promo_banners`;
CREATE TABLE `promo_banners` (
  `id_promo_banner` bigint(20) UNSIGNED NOT NULL,
  `gambar_promo_banner` varchar(255) NOT NULL,
  `id_promo_detail` bigint(20) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promo_banners`
--

INSERT INTO `promo_banners` (`id_promo_banner`, `gambar_promo_banner`, `id_promo_detail`, `active`, `created_at`, `updated_at`) VALUES
(1, '1771412444_promo_banner.png', 1, 1, '2026-02-18 04:00:44', '2026-02-18 20:38:19'),
(2, '1771492117_promo_banner.png', 2, 1, '2026-02-19 02:08:37', '2026-02-19 02:08:37');

-- --------------------------------------------------------

--
-- Table structure for table `promo_details`
--

DROP TABLE IF EXISTS `promo_details`;
CREATE TABLE `promo_details` (
  `id_promo_detail` bigint(20) UNSIGNED NOT NULL,
  `id_promo_banner` bigint(20) UNSIGNED NOT NULL,
  `judul_detail` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar_tambahan` varchar(255) DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promo_details`
--

INSERT INTO `promo_details` (`id_promo_detail`, `id_promo_banner`, `judul_detail`, `deskripsi`, `gambar_tambahan`, `tanggal_mulai`, `tanggal_selesai`, `created_at`, `updated_at`) VALUES
(1, 1, 'test', 'test', '1771412964_promo_detail_WhatsApp Image 2026-01-07 at 11.56.03 (1).jpeg', NULL, NULL, '2026-02-18 04:09:24', '2026-02-19 02:05:14'),
(2, 1, 'tutorial penggunaan ecommerce', 'tutorial penggunaan ecommerce adalah checkout dan melakukkan pembayaran', '1771492090_promo_detail_pexels-thirdman-7181188.jpg', '2026-02-18', '2026-02-20', '2026-02-19 02:08:10', '2026-02-19 02:08:10');

-- --------------------------------------------------------

--
-- Table structure for table `quotation`
--

DROP TABLE IF EXISTS `quotation`;
CREATE TABLE `quotation` (
  `id_quotation` bigint(20) UNSIGNED NOT NULL,
  `id_order` bigint(20) UNSIGNED NOT NULL,
  `sent_at` timestamp NULL DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `status_quotation` varchar(255) NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quotation`
--

INSERT INTO `quotation` (`id_quotation`, `id_order`, `sent_at`, `expiry_date`, `status_quotation`, `created_at`, `updated_at`) VALUES
(2, 4, NULL, NULL, 'draft', '2026-02-18 22:05:23', '2026-02-18 22:05:23'),
(3, 8, NULL, NULL, 'draft', '2026-02-19 00:36:07', '2026-02-19 00:36:07');

-- --------------------------------------------------------

--
-- Table structure for table `quotation_items`
--

DROP TABLE IF EXISTS `quotation_items`;
CREATE TABLE `quotation_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_quotation` bigint(20) UNSIGNED NOT NULL,
  `id_produk` bigint(20) UNSIGNED DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `qty` int(11) NOT NULL DEFAULT 1,
  `price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `description` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quotation_items`
--

INSERT INTO `quotation_items` (`id`, `id_quotation`, `id_produk`, `product_name`, `qty`, `price`, `description`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 3, 22, 'Dell XPS 13', 1, 22500000.00, NULL, 0, '2026-02-19 01:00:31', '2026-02-19 01:00:42');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('HEDckkLHAf4mtTdNVOiuSpTAI8Gtxg7wCtgh1seV', 5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSWMxZzNKUVJtVDYzNUJUenUzQVprNElVNHp0OGVRT1dVN09uNXNRbSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ob21lL3RvcC1icmFuZC1wcm9kdWN0cy83IjtzOjU6InJvdXRlIjtzOjIzOiJob21lLnRvcC1icmFuZC1wcm9kdWN0cyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7fQ==', 1771993744);

-- --------------------------------------------------------

--
-- Table structure for table `slider_banners`
--

DROP TABLE IF EXISTS `slider_banners`;
CREATE TABLE `slider_banners` (
  `id_slider_banner` bigint(20) UNSIGNED NOT NULL,
  `gambar_slider_banner` varchar(255) NOT NULL,
  `position` int(11) NOT NULL DEFAULT 0,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `slider_banners`
--

INSERT INTO `slider_banners` (`id_slider_banner`, `gambar_slider_banner`, `position`, `title`, `subtitle`, `active`, `created_at`, `updated_at`) VALUES
(1, 'banner/banneraro.png', 1, NULL, NULL, 1, '2026-02-18 02:27:32', '2026-02-18 02:27:32'),
(2, 'banner/banneraro2.png', 2, NULL, NULL, 1, '2026-02-18 02:27:32', '2026-02-18 02:27:32');

-- --------------------------------------------------------

--
-- Table structure for table `special_deals`
--

DROP TABLE IF EXISTS `special_deals`;
CREATE TABLE `special_deals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT 'Special Deals',
  `subtitle` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `special_deals`
--

INSERT INTO `special_deals` (`id`, `title`, `subtitle`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Special Deals', 'for this year', 1, '2026-02-24 03:34:05', '2026-02-24 03:34:05');

-- --------------------------------------------------------

--
-- Table structure for table `special_deal_products`
--

DROP TABLE IF EXISTS `special_deal_products`;
CREATE TABLE `special_deal_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `special_deal_id` bigint(20) UNSIGNED NOT NULL,
  `id_produk` bigint(20) UNSIGNED NOT NULL,
  `discount_percentage` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `special_deal_products`
--

INSERT INTO `special_deal_products` (`id`, `special_deal_id`, `id_produk`, `discount_percentage`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 1, 21, 50, 1, NULL, NULL),
(3, 1, 19, 50, 1, NULL, NULL),
(4, 1, 22, 50, 1, NULL, NULL),
(5, 1, 24, 50, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subkategori`
--

DROP TABLE IF EXISTS `subkategori`;
CREATE TABLE `subkategori` (
  `id_subkategori` bigint(20) UNSIGNED NOT NULL,
  `id_kategori` bigint(20) UNSIGNED NOT NULL,
  `nama_subkategori` varchar(255) NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subkategori`
--

INSERT INTO `subkategori` (`id_subkategori`, `id_kategori`, `nama_subkategori`, `created_at`, `updated_at`) VALUES
(1, 1, 'Meja Kerja', '2026-02-12 06:16:24', '2026-02-12 06:16:24'),
(2, 1, 'Meja Receptionist', '2026-02-12 06:16:24', '2026-02-12 06:16:24'),
(3, 1, 'Meja Rapat', '2026-02-12 06:16:24', '2026-02-12 06:16:24'),
(4, 1, 'Meja Serbaguna', '2026-02-12 06:16:24', '2026-02-12 06:16:24'),
(5, 1, 'Meja Komputer', '2026-02-12 06:16:24', '2026-02-12 06:16:24'),
(6, 1, 'Papan Tulis', '2026-02-12 06:16:24', '2026-02-12 06:16:24'),
(7, 1, 'Sofa', '2026-02-12 06:16:24', '2026-02-12 06:16:24'),
(8, 1, 'Tempat Tidur', '2026-02-12 06:16:24', '2026-02-12 06:16:24'),
(9, 1, 'Lemari', '2026-02-12 06:16:24', '2026-02-12 06:16:24'),
(10, 1, 'PC Tray Komputer', '2026-02-12 06:16:24', '2026-02-12 06:16:24'),
(11, 1, 'Locker', '2026-02-12 06:16:24', '2026-02-12 06:16:24'),
(12, 1, 'Papan Pengumuman', '2026-02-12 06:16:24', '2026-02-12 06:16:24'),
(13, 1, 'Meja Podium', '2026-02-12 06:16:24', '2026-02-12 06:16:24'),
(14, 1, 'Tiang Bendera', '2026-02-12 06:16:24', '2026-02-12 06:16:24'),
(15, 1, 'Meja Mimbar', '2026-02-12 06:16:24', '2026-02-12 06:16:24'),
(16, 1, 'Pot Bunga', '2026-02-12 06:16:24', '2026-02-12 06:16:24'),
(17, 1, 'Tempat Sampah', '2026-02-12 06:16:24', '2026-02-12 06:16:24'),
(18, 1, 'Rehal', '2026-02-12 06:16:24', '2026-02-12 06:16:24'),
(19, 1, 'Sutrah', '2026-02-12 06:16:24', '2026-02-12 06:16:24'),
(20, 1, 'Cermin', '2026-02-12 06:16:24', '2026-02-12 06:16:24'),
(21, 1, 'Patung Garuda Pancasila', '2026-02-12 06:16:24', '2026-02-12 06:16:24'),
(22, 1, 'Foto Presiden', '2026-02-12 06:16:24', '2026-02-12 06:16:24'),
(23, 1, 'Kursi', '2026-02-12 06:16:24', '2026-02-12 06:16:24'),
(24, 2, 'Kursi', '2026-02-12 06:16:24', '2026-02-12 06:16:24'),
(25, 2, 'Lemari', '2026-02-12 06:16:24', '2026-02-12 06:16:24'),
(26, 2, 'Rak', '2026-02-12 06:16:24', '2026-02-12 06:16:24'),
(27, 2, 'Meja', '2026-02-12 06:16:24', '2026-02-12 06:16:24'),
(28, 3, 'Alat Peraga', '2026-02-12 06:16:24', '2026-02-12 06:16:24'),
(29, 4, 'Genset', '2026-02-12 06:16:24', '2026-02-12 06:16:24'),
(30, 4, 'Chainsaw', '2026-02-12 06:16:24', '2026-02-12 06:16:24'),
(31, 4, 'Mesin Trafo Las', '2026-02-12 06:16:24', '2026-02-12 06:16:24'),
(32, 4, 'Toolkit Set', '2026-02-12 06:16:24', '2026-02-12 06:16:24'),
(33, 6, 'Laptop', '2026-02-12 06:16:24', '2026-02-12 06:16:24'),
(34, 6, 'Komputer PC', '2026-02-12 06:16:24', '2026-02-12 06:16:24'),
(35, 6, 'UPS', '2026-02-12 06:16:24', '2026-02-12 06:16:24'),
(36, 6, 'Printer', '2026-02-12 06:16:24', '2026-02-12 06:16:24'),
(37, 6, 'Air Conditioner (AC)', '2026-02-12 06:16:24', '2026-02-12 06:16:24'),
(38, 6, 'Video Wall', '2026-02-12 06:16:24', '2026-02-12 06:16:24'),
(39, 7, 'Paket Sembako', '2026-02-12 06:16:24', '2026-02-12 06:16:24'),
(40, 8, 'Handphone', '2026-02-12 08:15:17', '2026-02-12 08:15:17'),
(41, 8, 'Laptop', '2026-02-12 08:15:17', '2026-02-12 08:15:17'),
(42, 8, 'Aksesoris Utk Gadget', '2026-02-12 08:15:17', '2026-02-12 08:15:17'),
(43, 9, 'Pria', '2026-02-12 08:15:17', '2026-02-12 08:15:17'),
(44, 9, 'Wanita', '2026-02-12 08:15:17', '2026-02-12 08:15:17'),
(45, 9, 'Anak-anak', '2026-02-12 08:15:17', '2026-02-12 08:15:17');

-- --------------------------------------------------------

--
-- Table structure for table `sub_subkategori`
--

DROP TABLE IF EXISTS `sub_subkategori`;
CREATE TABLE `sub_subkategori` (
  `id_sub_subkategori` bigint(20) UNSIGNED NOT NULL,
  `id_subkategori` bigint(20) UNSIGNED NOT NULL,
  `nama_sub_subkategori` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_subkategori`
--

INSERT INTO `sub_subkategori` (`id_sub_subkategori`, `id_subkategori`, `nama_sub_subkategori`, `created_at`, `updated_at`) VALUES
(1, 1, 'Meja Staff', '2026-02-12 06:16:37', '2026-02-12 06:16:37'),
(2, 1, 'Meja Kerja Kubikal', '2026-02-12 06:16:37', '2026-02-12 06:16:37'),
(3, 1, 'Meja Kerja Konfirgurasi', '2026-02-12 06:16:37', '2026-02-12 06:16:37'),
(4, 7, 'Sofa Set', '2026-02-12 06:16:37', '2026-02-12 06:16:37'),
(5, 7, 'Sofa Bed', '2026-02-12 06:16:37', '2026-02-12 06:16:37'),
(6, 7, 'Corner Sofa', '2026-02-12 06:16:37', '2026-02-12 06:16:37'),
(7, 7, 'Single Sofa', '2026-02-12 06:16:37', '2026-02-12 06:16:37'),
(8, 7, 'Stool', '2026-02-12 06:16:37', '2026-02-12 06:16:37'),
(9, 9, 'Lemari Arsip', '2026-02-12 06:16:37', '2026-02-12 06:16:37'),
(10, 9, 'Lemari Pakaian', '2026-02-12 06:16:37', '2026-02-12 06:16:37'),
(11, 9, 'Rak Buku', '2026-02-12 06:16:37', '2026-02-12 06:16:37'),
(12, 9, 'Divider', '2026-02-12 06:16:37', '2026-02-12 06:16:37'),
(13, 9, 'Lemari Laboratorium', '2026-02-12 06:16:37', '2026-02-12 06:16:37'),
(14, 23, 'Kursi Direktur', '2026-02-12 06:16:37', '2026-02-12 06:16:37'),
(15, 23, 'Kursi Manager', '2026-02-12 06:16:37', '2026-02-12 06:16:37'),
(16, 23, 'Kursi Staff', '2026-02-12 06:16:37', '2026-02-12 06:16:37'),
(17, 23, 'Kursi Hadap', '2026-02-12 06:16:37', '2026-02-12 06:16:37'),
(18, 23, 'Kursi Lipat', '2026-02-12 06:16:37', '2026-02-12 06:16:37'),
(19, 24, 'Kursi Siswa', '2026-02-12 06:16:37', '2026-02-12 06:16:37'),
(20, 25, 'Lemari Siswa', '2026-02-12 06:16:37', '2026-02-12 06:16:37'),
(21, 26, 'Rak Sepatu', '2026-02-12 06:16:37', '2026-02-12 06:16:37'),
(22, 27, 'Meja Siswa', '2026-02-12 06:16:37', '2026-02-12 06:16:37'),
(23, 28, 'Globe', '2026-02-12 06:16:37', '2026-02-12 06:16:37'),
(24, 28, 'Kerangka Manusia', '2026-02-12 06:16:37', '2026-02-12 06:16:37'),
(25, 29, 'Genset 5000 Watt', '2026-02-12 06:16:37', '2026-02-12 06:16:37'),
(26, 30, 'Chainsaw Mini', '2026-02-12 06:16:37', '2026-02-12 06:16:37'),
(27, 31, 'Trafo Las 900 Watt', '2026-02-12 06:16:37', '2026-02-12 06:16:37'),
(28, 32, 'Toolkit 100 Pcs', '2026-02-12 06:16:37', '2026-02-12 06:16:37'),
(29, 33, 'Laptop Core i5', '2026-02-12 06:16:37', '2026-02-12 06:16:37'),
(30, 34, 'PC Core i7', '2026-02-12 06:16:37', '2026-02-12 06:16:37'),
(31, 35, 'UPS 1200VA', '2026-02-12 06:16:37', '2026-02-12 06:16:37'),
(32, 36, 'Printer LaserJet', '2026-02-12 06:16:37', '2026-02-12 06:16:37'),
(33, 39, 'Paket Sembako Lengkap', '2026-02-12 06:16:37', '2026-02-12 06:16:37');

-- --------------------------------------------------------

--
-- Table structure for table `ulasan`
--

DROP TABLE IF EXISTS `ulasan`;
CREATE TABLE `ulasan` (
  `id_ulasan` bigint(20) UNSIGNED NOT NULL,
  `id_produk` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `rating_ulasan` int(11) NOT NULL,
  `komentar_ulasan` text DEFAULT NULL,
  `tanggal_ulasan` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ulasan`
--

INSERT INTO `ulasan` (`id_ulasan`, `id_produk`, `id_user`, `rating_ulasan`, `komentar_ulasan`, `tanggal_ulasan`, `created_at`, `updated_at`) VALUES
(2, 31, 2, 5, 'bagus banget', '2026-02-13 07:53:07', '2026-02-13 00:53:07', '2026-02-13 00:53:07'),
(3, 19, 2, 5, 'baguas', '2026-02-13 07:56:54', '2026-02-13 00:56:54', '2026-02-13 00:56:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `nama_user` varchar(255) NOT NULL,
  `email_user` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password_user` varchar(255) NOT NULL,
  `role_user` varchar(255) NOT NULL DEFAULT 'user',
  `nama_perusahaan` varchar(255) DEFAULT NULL,
  `nomor_telepon` varchar(30) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `last_login_ip` varchar(45) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama_user`, `email_user`, `email_verified_at`, `password_user`, `role_user`, `nama_perusahaan`, `nomor_telepon`, `alamat`, `last_login_at`, `last_login_ip`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'aliester', 'aliester@alsrcrp.id', NULL, '$2y$12$Rb/EGen9YEmQeJAzvB/MherNwjf7Nvf5/LA5uW5Out46itk9bY8/m', 'user', NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-12 21:58:17', '2026-02-12 21:58:17'),
(3, 'Administrator', 'admin@admin.com', NULL, '$2y$12$8MUL5SoR8flgAEch6ngcnu4qUfzQIyoqTXlTMHFbkCdyn9uyKN8QG', 'admin', NULL, NULL, NULL, '2026-02-19 02:03:19', '127.0.0.1', NULL, '2026-02-15 21:33:47', '2026-02-19 02:03:19'),
(4, 'Aisyah Ayu Sibarani', 'aisyahayuus@gmail.com', NULL, '$2y$12$JcjeifIF5.sYGZbB.TNH5O01Z5xlWNuooX9oCNeeNE/TeMBqyI//i', 'user', NULL, NULL, NULL, '2026-02-19 00:22:26', '127.0.0.1', NULL, '2026-02-18 22:03:07', '2026-02-19 00:22:26'),
(5, 'admin2', 'admin@gmail.com', NULL, '$2y$12$G9oyQH1c9eTEIIuJKGE.N.8Q28VOm72q78QrcJIu4XRq0Jsr8XCia', 'admin', NULL, NULL, NULL, '2026-02-24 20:16:27', '127.0.0.1', NULL, '2026-02-18 22:49:37', '2026-02-24 20:16:27');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

DROP TABLE IF EXISTS `wishlist`;
CREATE TABLE `wishlist` (
  `id_wishlist` bigint(20) UNSIGNED NOT NULL,
  `id_produk` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id_banner`);

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id_brand`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id_cart`),
  ADD KEY `cart_id_user_foreign` (`id_user`);

--
-- Indexes for table `cart_detail`
--
ALTER TABLE `cart_detail`
  ADD PRIMARY KEY (`id_cart_detail`),
  ADD KEY `cart_detail_id_cart_foreign` (`id_cart`),
  ADD KEY `cart_detail_id_produk_foreign` (`id_produk`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `footer_links`
--
ALTER TABLE `footer_links`
  ADD PRIMARY KEY (`id_footer_link`);

--
-- Indexes for table `integrated_solutions`
--
ALTER TABLE `integrated_solutions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `integrated_solution_categories`
--
ALTER TABLE `integrated_solution_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `integrated_solution_categories_integrated_solution_id_foreign` (`integrated_solution_id`),
  ADD KEY `integrated_solution_categories_kategori_id_foreign` (`kategori_id`);

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
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `order_id_user_foreign` (`id_user`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`id_order_item`),
  ADD KEY `order_item_id_order_foreign` (`id_order`),
  ADD KEY `order_item_id_produk_foreign` (`id_produk`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id_payment`),
  ADD KEY `payment_id_order_foreign` (`id_order`),
  ADD KEY `payment_payment_account_id_index` (`payment_account_id`);

--
-- Indexes for table `payment_accounts`
--
ALTER TABLE `payment_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `perusahaan`
--
ALTER TABLE `perusahaan`
  ADD PRIMARY KEY (`id_perusahaan`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD UNIQUE KEY `produk_slug_unique` (`slug`),
  ADD KEY `produk_id_brand_foreign` (`id_brand`),
  ADD KEY `produk_id_sub_subkategori_foreign` (`id_sub_subkategori`);

--
-- Indexes for table `promo_banners`
--
ALTER TABLE `promo_banners`
  ADD PRIMARY KEY (`id_promo_banner`),
  ADD KEY `promo_banners_id_promo_detail_foreign` (`id_promo_detail`);

--
-- Indexes for table `promo_details`
--
ALTER TABLE `promo_details`
  ADD PRIMARY KEY (`id_promo_detail`),
  ADD KEY `promo_details_id_promo_banner_foreign` (`id_promo_banner`);

--
-- Indexes for table `quotation`
--
ALTER TABLE `quotation`
  ADD PRIMARY KEY (`id_quotation`),
  ADD KEY `quotation_id_order_foreign` (`id_order`);

--
-- Indexes for table `quotation_items`
--
ALTER TABLE `quotation_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quotation_items_id_produk_foreign` (`id_produk`),
  ADD KEY `quotation_items_id_quotation_sort_order_index` (`id_quotation`,`sort_order`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `slider_banners`
--
ALTER TABLE `slider_banners`
  ADD PRIMARY KEY (`id_slider_banner`);

--
-- Indexes for table `special_deals`
--
ALTER TABLE `special_deals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `special_deal_products`
--
ALTER TABLE `special_deal_products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `special_deal_products_special_deal_id_id_produk_unique` (`special_deal_id`,`id_produk`),
  ADD KEY `special_deal_products_id_produk_foreign` (`id_produk`);

--
-- Indexes for table `subkategori`
--
ALTER TABLE `subkategori`
  ADD PRIMARY KEY (`id_subkategori`),
  ADD KEY `subkategori_id_kategori_foreign` (`id_kategori`);

--
-- Indexes for table `sub_subkategori`
--
ALTER TABLE `sub_subkategori`
  ADD PRIMARY KEY (`id_sub_subkategori`),
  ADD KEY `sub_subkategori_id_subkategori_foreign` (`id_subkategori`);

--
-- Indexes for table `ulasan`
--
ALTER TABLE `ulasan`
  ADD PRIMARY KEY (`id_ulasan`),
  ADD KEY `ulasan_id_produk_foreign` (`id_produk`),
  ADD KEY `ulasan_id_user_foreign` (`id_user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `users_email_user_unique` (`email_user`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id_wishlist`),
  ADD KEY `wishlist_id_produk_foreign` (`id_produk`),
  ADD KEY `wishlist_id_user_foreign` (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id_banner` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id_brand` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id_cart` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cart_detail`
--
ALTER TABLE `cart_detail`
  MODIFY `id_cart_detail` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `footer_links`
--
ALTER TABLE `footer_links`
  MODIFY `id_footer_link` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `integrated_solutions`
--
ALTER TABLE `integrated_solutions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `integrated_solution_categories`
--
ALTER TABLE `integrated_solution_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id_order` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `id_order_item` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id_payment` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payment_accounts`
--
ALTER TABLE `payment_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `perusahaan`
--
ALTER TABLE `perusahaan`
  MODIFY `id_perusahaan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `promo_banners`
--
ALTER TABLE `promo_banners`
  MODIFY `id_promo_banner` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `promo_details`
--
ALTER TABLE `promo_details`
  MODIFY `id_promo_detail` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `quotation`
--
ALTER TABLE `quotation`
  MODIFY `id_quotation` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `quotation_items`
--
ALTER TABLE `quotation_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `slider_banners`
--
ALTER TABLE `slider_banners`
  MODIFY `id_slider_banner` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `special_deals`
--
ALTER TABLE `special_deals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `special_deal_products`
--
ALTER TABLE `special_deal_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `subkategori`
--
ALTER TABLE `subkategori`
  MODIFY `id_subkategori` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `sub_subkategori`
--
ALTER TABLE `sub_subkategori`
  MODIFY `id_sub_subkategori` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `ulasan`
--
ALTER TABLE `ulasan`
  MODIFY `id_ulasan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id_wishlist` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `cart_detail`
--
ALTER TABLE `cart_detail`
  ADD CONSTRAINT `cart_detail_id_cart_foreign` FOREIGN KEY (`id_cart`) REFERENCES `cart` (`id_cart`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_detail_id_produk_foreign` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE;

--
-- Constraints for table `integrated_solution_categories`
--
ALTER TABLE `integrated_solution_categories`
  ADD CONSTRAINT `integrated_solution_categories_integrated_solution_id_foreign` FOREIGN KEY (`integrated_solution_id`) REFERENCES `integrated_solutions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `integrated_solution_categories_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE;

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `order_item_id_order_foreign` FOREIGN KEY (`id_order`) REFERENCES `order` (`id_order`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_item_id_produk_foreign` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_id_order_foreign` FOREIGN KEY (`id_order`) REFERENCES `order` (`id_order`) ON DELETE CASCADE,
  ADD CONSTRAINT `payment_payment_account_id_foreign` FOREIGN KEY (`payment_account_id`) REFERENCES `payment_accounts` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_id_brand_foreign` FOREIGN KEY (`id_brand`) REFERENCES `brand` (`id_brand`) ON DELETE CASCADE,
  ADD CONSTRAINT `produk_id_sub_subkategori_foreign` FOREIGN KEY (`id_sub_subkategori`) REFERENCES `sub_subkategori` (`id_sub_subkategori`) ON UPDATE CASCADE;

--
-- Constraints for table `promo_banners`
--
ALTER TABLE `promo_banners`
  ADD CONSTRAINT `promo_banners_id_promo_detail_foreign` FOREIGN KEY (`id_promo_detail`) REFERENCES `promo_details` (`id_promo_detail`) ON DELETE SET NULL;

--
-- Constraints for table `promo_details`
--
ALTER TABLE `promo_details`
  ADD CONSTRAINT `promo_details_id_promo_banner_foreign` FOREIGN KEY (`id_promo_banner`) REFERENCES `promo_banners` (`id_promo_banner`) ON DELETE CASCADE;

--
-- Constraints for table `quotation`
--
ALTER TABLE `quotation`
  ADD CONSTRAINT `quotation_id_order_foreign` FOREIGN KEY (`id_order`) REFERENCES `order` (`id_order`) ON DELETE CASCADE;

--
-- Constraints for table `quotation_items`
--
ALTER TABLE `quotation_items`
  ADD CONSTRAINT `quotation_items_id_produk_foreign` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE SET NULL,
  ADD CONSTRAINT `quotation_items_id_quotation_foreign` FOREIGN KEY (`id_quotation`) REFERENCES `quotation` (`id_quotation`) ON DELETE CASCADE;

--
-- Constraints for table `special_deal_products`
--
ALTER TABLE `special_deal_products`
  ADD CONSTRAINT `special_deal_products_id_produk_foreign` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE,
  ADD CONSTRAINT `special_deal_products_special_deal_id_foreign` FOREIGN KEY (`special_deal_id`) REFERENCES `special_deals` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subkategori`
--
ALTER TABLE `subkategori`
  ADD CONSTRAINT `subkategori_id_kategori_foreign` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE;

--
-- Constraints for table `sub_subkategori`
--
ALTER TABLE `sub_subkategori`
  ADD CONSTRAINT `sub_subkategori_id_subkategori_foreign` FOREIGN KEY (`id_subkategori`) REFERENCES `subkategori` (`id_subkategori`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ulasan`
--
ALTER TABLE `ulasan`
  ADD CONSTRAINT `ulasan_id_produk_foreign` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE,
  ADD CONSTRAINT `ulasan_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_id_produk_foreign` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlist_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;
SET FOREIGN_KEY_CHECKS = 1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;