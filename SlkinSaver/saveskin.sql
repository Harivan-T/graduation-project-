-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 08, 2022 at 10:49 AM
-- Server version: 8.0.22
-- PHP Version: 7.3.29-to-be-removed-in-future-macOS

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `saveskin`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int NOT NULL,
  `admin_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_name`, `password`, `email`) VALUES
(2, 'Admin', 'c8837b23ff8aaa8a2dde915473ce0991', 'admin@gmail.com'),
(3, 'Admin2', 'c8837b23ff8aaa8a2dde915473ce0991', 'admin2@gmail.com'),
(4, 'admin3', 'c8837b23ff8aaa8a2dde915473ce0991', 'admin3@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `cartID` int NOT NULL,
  `custID` int NOT NULL,
  `proID` int NOT NULL,
  `proQty` int NOT NULL,
  `cartAdded` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`cartID`, `custID`, `proID`, `proQty`, `cartAdded`) VALUES
(45, 5, 12, 1, '2022-02-19 16:42:41'),
(46, 5, 11, 3, '2022-02-19 16:42:43'),
(47, 5, 4, 1, '2022-02-20 13:37:15'),
(48, 5, 1, 3, '2022-02-21 17:42:29'),
(51, 1, 11, 1, '2022-03-07 23:04:58'),
(52, 1, 10, 1, '2022-03-07 23:05:02');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int NOT NULL,
  `cat_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `cat_image` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cat_parent` int NOT NULL,
  `cat_description` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_name`, `cat_image`, `cat_parent`, `cat_description`) VALUES
(1, 'Cleanser', '1643498577.jpg', 0, 'Best Cleanser Face Wash By Skin Type'),
(3, 'Wipes', '1643498570.jpg', 0, 'Disposable wipes are made for baby care, hand washing, feminine and other personal cleansing, removing makeup, and applying products such as deodorants and sunless tanners, among other uses'),
(5, 'Oils', '1643559470.jpg', 0, 'Face oils can have many potential benefits, but their overall purpose is to serve as an extra level of protection for your skin.');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `cust_id` int NOT NULL,
  `first_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `registered_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`cust_id`, `first_name`, `last_name`, `email`, `phone`, `password`, `registered_at`) VALUES
(1, 'dlovan', 'ali', 'dlovan.bashir.ali@gmail.com', '07504030754', 'c8837b23ff8aaa8a2dde915473ce0991', '2022-01-05 02:19:51'),
(2, 'Ali', 'Bashir', 'ali.dlovan.bashir@gmail.com', '07516009591', 'c8837b23ff8aaa8a2dde915473ce0991', '2022-01-06 02:19:51'),
(3, 'danar', 'Dlovan', 'danar.dlovan.bashir@gmail.com', '07516009591', 'c8837b23ff8aaa8a2dde915473ce0991', '2022-02-16 02:19:51'),
(4, 'member1', 'member', 'customer@gmail.com', '07504448888', 'c8837b23ff8aaa8a2dde915473ce0991', '2022-02-16 02:19:51'),
(5, 'Customer 2', 'Customer 2 2', 'customer2@gmail.com', '07504007788', 'c8837b23ff8aaa8a2dde915473ce0991', '2022-02-19 16:30:35'),
(6, 'Customer 3', 'C3', 'customer3@gmail.com', '07504990088', 'c8837b23ff8aaa8a2dde915473ce0991', '2022-03-08 12:57:30'),
(7, 'customer4', 'c4', 'customer4@gmail.com', '07504990088', 'c8837b23ff8aaa8a2dde915473ce0991', '2022-03-08 13:16:45');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `img_id` int NOT NULL,
  `img_product_id` int NOT NULL,
  `img_src` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `img_default` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`img_id`, `img_product_id`, `img_src`, `img_default`) VALUES
(1, 1, '1643103026.jpg', 1),
(3, 2, '1643103202.jpg', 1),
(4, 2, '1643103204.jpg', 0),
(5, 2, '1643103233.jpg', 0),
(7, 3, '1643495304.jpg', 1),
(8, 7, '1643495307.jpg', 1),
(9, 4, '1643495559.jpg', 0),
(10, 1, '1643495561.jpg', 0),
(11, 5, '1643495799.jpg', 1),
(12, 6, '1643559663.jpg', 1),
(13, 1, '1643559665.jpg', 0),
(18, 7, '1644101286.jpg', 0),
(19, 7, '1644614918.jpg', 0),
(24, 8, '1644687353.jpg', 0),
(25, 8, '1644687356.jpg', 0),
(26, 8, '1644687358.jpg', 1),
(27, 9, '1644689565.jpg', 1),
(28, 9, '1644689568.jpg', 0),
(29, 9, '1644689571.jpg', 0),
(30, 9, '1644689574.jpg', 0),
(31, 10, '1644689979.jpg', 1),
(32, 10, '1644689982.jpg', 0),
(33, 10, '1644689985.jpg', 0),
(34, 10, '1644689988.jpg', 0),
(36, 11, '1644690908.jpg', 1),
(37, 11, '1644690911.jpg', 0),
(38, 11, '1644690914.jpg', 0),
(39, 11, '1644690917.jpg', 0),
(40, 11, '1644690920.jpg', 0),
(41, 11, '1644690923.jpg', 0),
(42, 12, '1644691989.jpg', 0),
(43, 12, '1644691992.jpg', 0),
(44, 12, '1644691995.jpg', 0),
(45, 12, '1644691998.jpg', 0),
(46, 12, '1644692001.jpg', 0),
(47, 12, '1644692004.jpg', 1),
(50, 4, '1645363159.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `ord_id` int NOT NULL,
  `ord_customer` int NOT NULL,
  `ord_shipping` text COLLATE utf8_unicode_ci NOT NULL,
  `ord_payment` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ord_status` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ord_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`ord_id`, `ord_customer`, `ord_shipping`, `ord_payment`, `ord_status`, `ord_date`) VALUES
(1, 4, 'Dlovan Bashir-07516009591-dlovan.bashir.ali@gmail.com/128 Kevla Semel Duhok', 'ZainCash', 'ordered', '2022-02-14 22:16:28'),
(2, 4, 'Dlovan Bashir Ali-07516009591-dlovan.bashir.ali@gmail.com/128 Kevla Duhok', 'FastPay', 'canceled', '2022-02-14 22:25:21'),
(3, 4, 'Sardar Omar-07508572923-sardar@uod.ac/120 Gali Duhok', 'OnDelivery', 'delivered', '2022-02-14 22:52:01'),
(4, 3, 'Haval Ali-07504009988-haval.ali@gmail.com/129 Hala Duhok', 'ZainCash', 'delivered', '2022-01-04 22:57:13'),
(5, 3, 'Eman Ahmad-07504987654-eman.ahmad@gmail.com/120 Zahko  Duhok', 'FastPay', 'delivered', '2022-01-04 00:17:34'),
(6, 2, 'Ali Hameed-07508897766-ali.dlovan.bashir@gmail.com/33 Sardan Malta Duhok', 'ZainCash', 'ordered', '2022-02-15 01:17:49'),
(7, 2, 'Haval Ahmad-07503409090-haval.ahmad@gmail.com/332 Sarbast st Duhok', 'ZainCash', 'ordered', '2022-02-15 01:21:05'),
(21, 2, 'Ali Dlovan-07516009591-ali.dlovan.bashir@gmail.com/129 Kevla', 'FastPay', 'ordered', '2022-02-16 18:31:39'),
(22, 2, 'Ali Dlovan Bashir-07516009591-ali.dlovan.bashir@gmail.com/129 Kevla Duhok', 'FastPay', 'ordered', '2022-02-16 18:35:37'),
(23, 3, 'Danar Dlovan Bashir-07516009591-danar.dlovan.bashir@gmail.com/128 Astang Kevla Duhok', 'FastPay', 'ordered', '2022-03-01 21:09:35'),
(24, 3, 'Danar-07516009591-danar.dlovan.bashir@gmail.com/129 Sardar Kevla Duhok', 'FastPay', 'delivered', '2022-04-04 21:14:24'),
(25, 3, 'Danar-07516009591-danar.dlovan.bashir@gmail.com/128 Sarbast st Kevla Duhok', 'FastPay', 'ordered', '2022-02-16 21:36:39'),
(26, 1, 'Dlovan Bashir ALi-07504030754-dlovan.bashir.ali@gmail.com/120 Xani st Kevla Duhok', 'ZainCash', 'ordered', '2022-02-16 21:41:48'),
(27, 1, 'Dlovan-07516009591-dlovan.bashir.ali@gmail.com/22 Grebase st Duhok', 'ZainCash', 'ordered', '2022-02-16 21:44:40'),
(28, 1, 'Sardar Omar-07508572900-sardar.omar@gmail.com/120 Golbin st Keval Duhok', 'ZainCash', 'ordered', '2022-01-02 21:47:29'),
(29, 4, 'Aman Ali-07504998765-aman.ali@gmail.com/102 Sarhldan Duhok', 'ZainCash', 'ordered', '2022-02-04 20:22:07'),
(30, 4, 'Osama Arshad-07503987766-osama.arshad/34 Gulan st Muhabad Duhok', 'ZainCash', 'ordered', '2022-02-17 20:27:48'),
(31, 4, 'Osama Arshad-07502908877-os.arshad@gmail.com/32 Gulan st Muhabad Duhok', 'ZainCash', 'ordered', '2022-02-17 20:29:08'),
(32, 1, 'dlovan B Ali-07516009591-dlovan.bashir.ali@gmail.com/129 Sardan st Kevla Duhok', 'FastPay', 'ordered', '2022-02-17 20:30:46'),
(33, 1, 'Dlovan B Ali-07516009591-dlovan.bashir.ali@gmail.com/128 Sardan st Kevla Duhok', 'FastPay', 'ordered', '2022-02-17 20:31:46'),
(34, 1, 'D B Ali-07516009591-dlovan.bashir.ali@gmail.com/22 Distar Duhok', 'ZainCash', 'canceled', '2022-03-04 20:34:20'),
(35, 2, 'Ali Dlovan-07504030754-ali.dlovan.bashir@gmail.com/33 Golbin st Gali Duhok', 'FastPay', 'ordered', '2022-02-18 15:05:47'),
(36, 3, 'Dlovan B Ali-07516009591-dlovan.bashir.ali@gmail.com/23 Lss st Duhok', 'ZainCash', 'ordered', '2022-02-19 01:00:39'),
(37, 4, 'Haval Ahmad-0750498877-haval.a@gmail.com/33 Lalav st Duhok', 'ZainCash', 'delivered', '2022-02-19 11:14:56'),
(38, 4, 'Shilan Anwar-07504908877-shilan.anwar@gmail.com/44 Badinan st Sarbasti Duhok', 'OnDelivery', 'ordered', '2022-02-08 11:59:57'),
(39, 4, 'Dlman Ali-07503098854-dlman.ali@gmail.com/22 st 120 C3 Warvin City Duhok', 'OnDelivery', 'ordered', '2022-02-19 12:30:36'),
(40, 4, 'Dlovan B Ali-07516009591-dlovan.bashir.ali@gmail.com/23 DAD st Duhok', 'ZainCash', 'ordered', '2022-02-19 15:47:33'),
(41, 4, 'Dlovan-07516009591-danar.dlovan.bashir@gmail.com/Duhok', 'ZainCash', 'ordered', '2022-02-19 15:53:45'),
(42, 4, 'dlovan b ali-07516009591-dlovan.bashir.ali@gmail.com/Duhok', 'ZainCash', 'ordered', '2022-02-19 15:55:38'),
(43, 4, 'Dlovan Ali-07504448888-danar.dlovan.bashir@gmail.com/123 Darin st Duhok Center', 'ZainCash', 'ordered', '2022-02-19 15:58:31'),
(44, 4, 'Danar Dlovan-07516009591-danar.dlovan.bashir@gmail.com/45 Halala st Duhok', 'ZainCash', 'delivered', '2022-02-19 16:03:30'),
(45, 4, 'dlovan b ali-07516009591-dlovan.bashir.ali@gmail.com/34 Duhok', 'ZainCash', 'delivered', '2022-02-19 16:18:21'),
(46, 4, 'Dlovan B Ali-07516009591-dlovan.bashir.ali@gmail.com/33 Duhok', 'ZainCash', 'delivered', '2022-02-19 16:21:38'),
(47, 5, 'customer2-07504007788-customer2@gmail.com/23 Fan st Duhok', 'FastPay', 'canceled', '2022-02-19 16:31:58'),
(48, 4, 'customer 1-07504448888-customer@gmail.com/88 Karin st Sarhldan Duhok', 'OnDelivery', 'canceled', '2022-02-19 22:28:04'),
(49, 4, 'customer 1-07504007788-customer@gmail.com/234 Van st Gali Duhok', 'OnDelivery', 'delivered', '2022-02-20 00:49:34'),
(50, 5, 'customer 1-07504448888-customer@gmail.com/120 C3 Waarcity Semel Duhok', 'OnDelivery', 'delivered', '2022-02-20 11:22:21'),
(51, 5, 'customer 2-07516009591-customer2@gmail.com/120 B2 Zariland Semel Duhok', 'OnDelivery', 'delivered', '2022-02-20 13:22:43'),
(52, 5, 'Ali-07516009591-ali.dlovan.bashir@gmail.com/128 Buhar Duhok', 'ZainCash', 'delivered', '2022-02-20 17:44:51'),
(53, 4, 'customer-07516009591-customer@gmail.com/23 Earth planet Duhok Iraq', 'OnDelivery', 'ordered', '2022-02-21 16:57:44'),
(54, 4, 'customer-07516009591-customer@gmail.com/33 address city  province country', 'OnDelivery', 'ordered', '2022-02-21 17:02:17'),
(55, 5, 'customer 2-07504007788-customer2@gmail.com/Address of shipping', 'OnDelivery', 'ordered', '2022-02-21 17:43:01'),
(56, 1, 'dlovan b ali-07516009591-dlovan.bashir.ali@gmail.com/33 Lava st Kevla Duhok', 'ZainCash', 'ordered', '2022-02-23 10:51:55'),
(57, 1, 'Dlovan B Ali-07516009591-dlovan.bashir.ali@gmail.com/34 Solav Duhok', 'FastPay', 'ordered', '2022-02-23 10:52:35'),
(58, 4, 'customerian-07504908877-customer@gmail.com/33 Cust st Kustarica USA', 'OnDelivery', 'ordered', '2022-02-24 20:02:20'),
(59, 4, 'DLovan-07504030754-dlovan.bashir.ali@gmail.com/Duhok', 'ZainCash', 'ordered', '2022-02-27 12:32:24'),
(60, 4, 'Dlovan Ali-07504030754-dlovan.bashir.ali@gmail.com/Duhok Kevla', 'FastPay', 'ordered', '2022-02-27 12:39:41');

-- --------------------------------------------------------

--
-- Table structure for table `order_list`
--

CREATE TABLE `order_list` (
  `ord_list_id` int NOT NULL,
  `ord_list_number` int NOT NULL,
  `ord_list_product` int NOT NULL,
  `ord_list_qty` int NOT NULL,
  `ord_list_product_price` int NOT NULL,
  `ord_list_date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `order_list`
--

INSERT INTO `order_list` (`ord_list_id`, `ord_list_number`, `ord_list_product`, `ord_list_qty`, `ord_list_product_price`, `ord_list_date_added`) VALUES
(1, 1, 12, 4, 44, '2022-02-15 18:49:47'),
(2, 1, 11, 3, 58, '2022-02-15 18:49:47'),
(3, 2, 10, 1, 48, '2022-02-15 18:49:47'),
(4, 2, 9, 1, 26, '2022-02-15 18:49:47'),
(5, 3, 8, 2, 26, '2022-02-15 18:49:47'),
(6, 3, 7, 2, 20, '2022-02-15 18:49:47'),
(7, 3, 1, 2, 18, '2022-02-15 18:49:47'),
(8, 4, 12, 1, 44, '2022-02-15 18:49:47'),
(9, 4, 11, 1, 58, '2022-02-15 18:49:47'),
(10, 5, 8, 3, 26, '2022-02-15 18:49:47'),
(11, 6, 1, 2, 18, '2022-02-14 00:16:00'),
(12, 6, 7, 3, 20, '2022-02-14 00:16:04'),
(13, 6, 2, 2, 28, '2022-02-15 18:49:47'),
(14, 6, 5, 2, 3, '2022-02-15 18:49:47'),
(15, 7, 12, 1, 44, '2022-02-15 18:49:47'),
(16, 7, 10, 1, 48, '2022-02-15 18:49:47'),
(17, 7, 9, 1, 26, '2022-02-15 18:49:47'),
(18, 21, 5, 1, 3, '2022-02-16 18:31:39'),
(19, 21, 2, 1, 28, '2022-02-16 18:31:39'),
(20, 21, 7, 1, 20, '2022-02-16 18:31:39'),
(21, 21, 3, 1, 13, '2022-02-16 18:31:39'),
(22, 21, 1, 1, 18, '2022-02-16 18:31:39'),
(23, 22, 8, 3, 26, '2022-02-16 18:35:37'),
(24, 23, 12, 4, 44, '2022-03-01 21:09:35'),
(25, 23, 7, 5, 20, '2022-01-01 21:09:35'),
(26, 24, 2, 3, 28, '2022-02-16 21:14:24'),
(27, 25, 7, 6, 20, '2022-02-16 21:36:39'),
(28, 25, 9, 3, 26, '2022-02-16 21:36:39'),
(29, 26, 12, 3, 44, '2022-02-16 21:41:48'),
(30, 26, 2, 3, 28, '2022-02-16 21:41:48'),
(31, 27, 11, 7, 58, '2022-01-03 21:44:40'),
(32, 28, 1, 3, 18, '2022-01-02 21:47:29'),
(33, 29, 10, 2, 48, '2022-02-04 20:22:07'),
(34, 29, 11, 2, 58, '2022-02-04 20:22:07'),
(35, 29, 12, 2, 44, '2022-02-04 20:22:07'),
(36, 30, 7, 3, 20, '2022-02-17 20:27:48'),
(37, 31, 8, 3, 26, '2022-02-17 20:29:08'),
(38, 32, 10, 2, 48, '2022-02-17 20:30:46'),
(39, 33, 8, 3, 26, '2022-02-17 20:31:46'),
(40, 34, 1, 2, 18, '2022-03-03 20:34:20'),
(41, 35, 1, 5, 18, '2022-02-18 15:05:47'),
(42, 36, 1, 1, 18, '2022-02-19 01:00:39'),
(43, 36, 2, 1, 28, '2022-02-19 01:00:39'),
(44, 36, 5, 1, 3, '2022-02-19 01:00:39'),
(45, 36, 10, 2, 48, '2022-02-19 01:00:39'),
(46, 37, 7, 3, 20, '2022-02-19 11:14:56'),
(47, 38, 11, 4, 58, '2022-02-19 11:59:57'),
(48, 39, 11, 4, 58, '2022-02-08 12:30:36'),
(49, 40, 11, 1, 58, '2022-02-19 15:47:33'),
(50, 41, 11, 1, 58, '2022-02-19 15:53:45'),
(51, 42, 11, 1, 58, '2022-02-19 15:55:38'),
(52, 43, 11, 2, 58, '2022-02-19 15:58:31'),
(53, 44, 11, 2, 58, '2022-02-19 16:03:30'),
(54, 45, 11, 2, 58, '2022-02-19 16:18:21'),
(55, 46, 11, 2, 58, '2022-02-19 16:21:38'),
(56, 47, 1, 1, 18, '2022-02-19 16:31:58'),
(57, 48, 10, 4, 48, '2022-02-19 22:28:04'),
(58, 49, 8, 2, 26, '2022-02-20 00:49:34'),
(59, 50, 7, 3, 20, '2022-02-20 11:22:21'),
(60, 51, 9, 3, 26, '2022-02-20 13:22:43'),
(61, 52, 12, 3, 44, '2022-02-20 17:44:51'),
(62, 53, 12, 4, 44, '2022-02-21 16:57:44'),
(63, 54, 4, 7, 5, '2022-02-21 17:02:17'),
(64, 55, 1, 4, 18, '2022-02-21 17:43:01'),
(65, 56, 11, 5, 58, '2022-02-23 10:51:55'),
(66, 57, 9, 2, 26, '2022-02-23 10:52:35'),
(67, 57, 7, 2, 20, '2022-02-23 10:52:35'),
(68, 58, 11, 2, 58, '2022-02-24 20:02:20'),
(69, 58, 12, 3, 44, '2022-02-24 20:02:20'),
(70, 59, 11, 3, 58, '2022-02-27 12:32:24'),
(71, 60, 9, 4, 26, '2022-02-27 12:39:41');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `pro_id` int NOT NULL,
  `pro_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pro_t_id` int NOT NULL,
  `br_id` int NOT NULL,
  `pro_amount` int NOT NULL,
  `price_buy` float NOT NULL,
  `price_sell` float NOT NULL,
  `pro_description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pro_expire_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`pro_id`, `pro_name`, `pro_t_id`, `br_id`, `pro_amount`, `price_buy`, `price_sell`, `pro_description`, `pro_expire_date`) VALUES
(1, 'The Superfood 3-Step Clear Skin Routine updateded 2', 1, 1, 64, 10, 18, 'Looking to bring skin into balance? Look no further. This simple three-step supers routine contains all the daily antioxidant-rich greens, gentle AHA, BHA, and PHA acids, and clinically backed active hydrating ingredients your skin needs to stay clear, healthy, and balanced. Use them together to target congestion, clear pores, tackle oiliness, and boost skin health.updated v3', '2022-03-03'),
(2, 'La Roche-Posay Toleriane Double Repair Face Moisturizer, SPF 30, 2.5 oz', 1, 1, 89, 25, 28, 'SkinSAFE has reviewed the ingredients of La Roche-Posay Toleriane Double Repair Face Moisturizer, SPF 30, 2.5 oz and found it to be hypoallergenic and free of Fragrance, Gluten, Coconut, Nickel, Top Common Allergy Causing Preservatives, Lanolin, Topical Antibiotic, Paraben, MCI/MI, Soy, Propylene Glycol, Oil, and Dye. Product is Teen Safe and Lip Safe.', '2024-04-24'),
(3, 'CVS Health AM Moisturizing Facial Lotion For Normal to Dry Skin SPF 30', 9, 5, 100, 10, 13, 'SkinSAFE has reviewed the ingredients of CVS Health AM Moisturizing Facial Lotion For Normal to Dry Skin SPF 30 and found it to be hypoallergenic and free of Fragrance, Coconut, Nickel, Top Common Allergy Causing Preservatives, Lanolin, Paraben, Topical Antibiotic, MCI/MI, Soy, Propylene Glycol, Oil, and Dye. Product is Teen Safe and Lip Safe.', '2029-07-12'),
(4, 'CVS Ultra-Soft Cleansing Wipes, Unscented, 12 count<br><br>', 2, 0, 93, 2, 5, 'SkinSAFE has reviewed the ingredients of CVS Ultra-Soft Cleansing Wipes, Unscented, 12 count and found it to be 91% Top Allergen Free and free of Fragrance, Gluten, Nickel, MCI/MI, Topical Antibiotic, Paraben, Soy, Balsam of Peru, Oil, and Dye. Product is Teen Safe.', '2024-07-17'),
(5, 'Pipette Baby Wipes, 50-count', 2, 6, 310, 2, 3, 'SkinSAFE has reviewed the ingredients of Pipette Baby Wipes, 50-count and found it to be 91% Top Allergen Free and free of Gluten, Nickel, Top Common Allergy Causing Preservatives, Lanolin, MCI/MI, Topical Antibiotic, Paraben, Soy, Propylene Glycol, and Dye. Product is Teen Safe.', '2023-02-08'),
(6, 'Heritage Store Castor Oil Nourishing Treatment, 8 fl oz/237 ml', 9, 5, 97, 3, 5, 'SkinSAFE has reviewed the ingredients of Heritage Store Castor Oil Nourishing Treatment, 8 fl oz/237 mL and found it to be hypoallergenic and free of Fragrance, Gluten, Coconut, Nickel, Top Common Allergy Causing Preservatives, Lanolin, Topical Antibiotic, Paraben, MCI/MI, Soy, Propylene Glycol, Balsam of Peru, Irritant/Acid, and Dye. Product is Teen Safe and Lip Safe.', '2025-03-06'),
(7, 'La Roche-Posay Toleriane Double Repair Face Moisturizer, SPF 30, 2.5', 1, 1, 57, 15, 20, 'La Roche-Posay Toleriane Double Repair Face Moisturizer, SPF 30, 2.5 oz La Roche-Posay Toleriane Double Repair Face Moisturizer, SPF 30, 2.5 oz La Roche-Posay Toleriane Double Repair Face Moisturizer, SPF 30, 2.5', '2022-02-18'),
(8, 'Day Cream: Vital 24/7 for Dry Sensitive Skin', 2, 1, 70, 20, 26, 'Features & Benefits\r\n\r\nThis antioxidant-rich moisturizer instantly combats dry skin without a heavy, greasy feeling and creates softer, healthier, younger-looking skin that lasts.\r\n\r\n    Made with 100% Pure Shea Butter to help revitalize, replenish, and hydrate your skin\r\n    Rich in antioxidants and vitamins for youthful, radiant skin\r\n    Helps prevent premature aging and discoloration\r\n    Use as the last step in your AM skincare routine before applying SPF\r\n\r\n\r\nWhat it is:\r\n\r\nCleure Day Cream for all skin types including sensitive skin will wake up your skin and start your morning off right. Our rich, nourishing face cream provides intense hydration, builds a defense against environmental stressors, and prevents and reduces the appearance of fine lines and wrinkles.\r\n\r\nWhat we leave out:\r\n\r\nOther skincare products often contain harsh ingredients such as parabens, phthalates, salicylates, gluten, dyes, and fragrance that can further strip the skin of its vital oils and lead to irritation. According to the American Academy of Dermatology (AAD), these ingredients can flare up into contact dermatitis and other sensitive skin conditions. We leave those out for more results with less risk.\r\n\r\nWhat we put in:\r\n\r\nWe strive for ingredients with intention so we curate naturally derived, locally sourced, replenishing ingredients like shea butter and Vitamin E to naturally restore and protect your delicate skin, leaving a dewy and radiant look.\r\n\r\nHow it will benefit you:\r\n\r\nEnriched with powerful antioxidants that strengthen the skin’s barrier, and prevent production of free radicals which damage skin cells and cause premature aging, and 100% pure Shea butter which is known to naturally hydrate skin and help protect against sun and other environmental damage. Even with all that good packed in, the formula remains lightweight and non-comedogenic, so it won\'t clog pores, and can be used under makeup and sunscreen. Suitable for all skin types especially dry, sensitive skin.\r\n', '2025-07-17'),
(9, 'Eye Repair Gel - Advanced Rebuilding Complex', 10, 1, 15, 20, 26, 'Remove fine lines and puffiness under the eyes with Cleure Eye Repair Gel. A light, refreshing gel that targets multiple signs of aging, moisturizes, minimizes fine lines and visibly brightens the skin.\r\n\r\n    Boosts elasticity and hydration of the skin\r\n    Refreshes & renews delicate skin around the eye\r\n    Improves the skin tone and help improve the appearance of aging including fine lines, wrinkles, and age spots\r\n\r\n.5 fl. oz. (15 ml) \r\n\r\n\r\nWhat it is:\r\n\r\nPut up a good, clean fight against aging with Cleure Eye Repair Gel. Use this nourishing serum nightly after cleansing and moisturizing to reduce and slow the appearance of aging.\r\n\r\nWhat we leave out:\r\n\r\nOther eye gels and serums often contain harsh ingredients such as parabens, phthalates, gluten, and fragrance that can further strip the skin of its vital oils, leave skin more lifeless than before, and cause flare ups of contact dermatitis and other skin conditions. We keep those out for more results with less risk.\r\n\r\nWhat we put in:\r\n\r\nWe strive for ingredients with intention, so we\'ve enriched our sensitive skin eye gel with naturally sourced ingredients such as Sodium Hyaluronate, Niacinamide, and peptides to help improve skin elasticity, tackle the appearance of fine lines and wrinkles, and minimize puffiness around the eyes. Combined with the hydrating effects of glycerin, this carefully curated formula has what you need to refresh, rejuvenate, and nourish the delicate skin around your eyes.\r\n\r\nHow it will benefit you:\r\n\r\nHelps fill the space between collagen and elastin to diminish the appearance of fine lines, wrinkles, and age spots, and boost skin\'s elasticity. Simultaneously aids in combating the formation of new lines while nourishing and replenishing moisture in the delicate skin around the eye\r\n', '2024-06-11'),
(10, 'Superfood Air-Whip Moisture Cream', 9, 2, 62, 45, 48, 'Get ready for some leafy green moisture with this lightweight, air-whipped moisture cream. All the antioxidant-packed superfoods you love combine forces with Hyaluronic Acid, creating a moisturizer that instantly restores, balances and conditions. Friendly for all skin types, best for combo/oily.\r\n\r\nHow to use:\r\n\r\nSmooth a dime-sized amount of cream into the skin until it is fully absorbed. Use morning and night.\r\n\r\nIngredients:\r\n\r\nProprietary Superfoods Blend: Kale, spinach, green tea, alfalfa, vitamins C and E.\r\n', '2024-06-11'),
(11, 'Adaptogen Deep Moisture Cream', 9, 2, 38, 30, 58, 'A deeply hydrating moisturizer with superior plant extracts and a pro-grade peptide complex formulated for dry, reactive, and sensitive skin. This fragrance-free formula is made with an intelligent hydration trio of Squalane, Jojoba + Shea butter for long-lasting deep hydration that won\'t clog pores.\r\n\r\nHow to use:\r\n\r\nApply to cleansed skin morning and evening after Superberry Hydrate Oil and Superfood Serum.\r\n\r\nIngredients:\r\n\r\n\r\nProprietary Adaptogen Blend: Ashwagandha, Rhodiola, and Reishi. The use of adaptogens as medicine, taken internally and applied topically, has been championed by Eastern medicine and Ayurveda for 5,000 years.', '2024-05-21'),
(12, 'Superberry Hydrate + Glow Dream Oil', 9, 2, 70, 40, 44, 'This ultra-enriched, flash-absorbing face oil packed with rare super berry antioxidants that leaves skin velvety soft, hydrated, and glowing. Intensely hydrating prickly pear and squalane oil lock in moisture with the help of omega fatty acids and high levels of vitamin C. \r\n\r\nMaqui, the most antioxidant dense fruit in the world, is combined with açaí and goji, creating a potent antioxidant elixir. Our perfected balance of jojoba and sunflower oil illuminate and revive dehydrated skin without weighing it down.\r\n\r\nHow to use:\r\n\r\nAfter cleansing, apply 2-5 drops of oil into hands. Rub together and press into skin. Use day and night.\r\n\r\nIngredients:\r\n\r\nCustom Superberry Blend: Maqui, acai, prickly pear, goji berry, sunflower, jojoba, moringa, squalane.\r\n', '2028-10-24');

-- --------------------------------------------------------

--
-- Table structure for table `product_brand`
--

CREATE TABLE `product_brand` (
  `br_id` int NOT NULL,
  `brand_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product_brand`
--

INSERT INTO `product_brand` (`br_id`, `brand_name`) VALUES
(1, 'Cleure'),
(2, 'Youth To The People'),
(5, 'CVS Health'),
(6, 'Pipette');

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `pro_cat_id` int NOT NULL,
  `product_cat_id` int NOT NULL,
  `product_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`pro_cat_id`, `product_cat_id`, `product_id`) VALUES
(1, 3, 4),
(2, 3, 5),
(3, 1, 7),
(4, 1, 3),
(6, 1, 1),
(7, 1, 2),
(19, 5, 7),
(20, 0, 8),
(21, 1, 8),
(22, 5, 8),
(23, 0, 9),
(24, 1, 9),
(25, 5, 9),
(26, 0, 10),
(27, 5, 10),
(28, 1, 10),
(29, 0, 11),
(30, 1, 11),
(31, 5, 11),
(32, 0, 12),
(33, 5, 12),
(34, 1, 12),
(35, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_type`
--

CREATE TABLE `product_type` (
  `pro_t_id` int NOT NULL,
  `type` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product_type`
--

INSERT INTO `product_type` (`pro_t_id`, `type`) VALUES
(1, 'Lip Safe'),
(2, 'Cleanser'),
(9, 'Moisturizers'),
(10, 'Eye repare');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `setting_id` int NOT NULL,
  `setting_key` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `setting_value` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting_id`, `setting_key`, `setting_value`) VALUES
(1, 'operating', '1'),
(2, 'fav_product', '12'),
(3, 'target_price', '8000'),
(4, 'target_profit', '1000'),
(5, 'target_customers', '100'),
(6, 'target_orders', '120'),
(7, 'target_sales', '300');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `cartID` int NOT NULL,
  `custID` int NOT NULL,
  `proID` int NOT NULL,
  `proQty` int NOT NULL,
  `cartAdded` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`cartID`, `custID`, `proID`, `proQty`, `cartAdded`) VALUES
(1, 2, 4, 0, '2022-02-10 12:51:30'),
(3, 2, 1, 0, '2022-02-10 12:53:40'),
(4, 2, 3, 0, '2022-02-10 12:54:39'),
(6, 2, 7, 0, '2022-02-10 13:17:19'),
(8, 2, 2, 1, '2022-02-10 16:56:46'),
(9, 2, 5, 1, '2022-02-10 16:57:42'),
(14, 1, 7, 1, '2022-02-11 00:41:51'),
(15, 1, 5, 1, '2022-02-11 00:41:55'),
(16, 1, 2, 1, '2022-02-11 00:41:59'),
(17, 1, 1, 1, '2022-02-11 00:42:03'),
(18, 3, 5, 1, '2022-02-11 15:40:04'),
(19, 3, 2, 1, '2022-02-11 15:40:07'),
(20, 3, 1, 1, '2022-02-11 15:40:16'),
(26, 4, 3, 1, '2022-02-12 17:52:15'),
(29, 4, 11, 1, '2022-02-12 22:21:10'),
(30, 4, 9, 1, '2022-02-12 22:21:14'),
(31, 4, 10, 1, '2022-02-13 11:32:00'),
(32, 5, 12, 1, '2022-02-20 17:54:34'),
(33, 5, 11, 1, '2022-02-20 17:54:36'),
(34, 5, 10, 1, '2022-02-20 17:54:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`cartID`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`cust_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`img_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`ord_id`);

--
-- Indexes for table `order_list`
--
ALTER TABLE `order_list`
  ADD PRIMARY KEY (`ord_list_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`pro_id`);

--
-- Indexes for table `product_brand`
--
ALTER TABLE `product_brand`
  ADD PRIMARY KEY (`br_id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`pro_cat_id`);

--
-- Indexes for table `product_type`
--
ALTER TABLE `product_type`
  ADD PRIMARY KEY (`pro_t_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`cartID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `cartID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `cust_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `img_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `ord_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `order_list`
--
ALTER TABLE `order_list`
  MODIFY `ord_list_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `pro_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `product_brand`
--
ALTER TABLE `product_brand`
  MODIFY `br_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `pro_cat_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `product_type`
--
ALTER TABLE `product_type`
  MODIFY `pro_t_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `setting_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `cartID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
