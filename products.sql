-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2023 at 03:52 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scandiwebtest`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sku` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(8,2) UNSIGNED NOT NULL,
  `productType` varchar(32) NOT NULL COMMENT '[''dvd'',''furniture'',''book'']',
  `size` decimal(8,0) UNSIGNED DEFAULT NULL,
  `height` decimal(8,0) UNSIGNED DEFAULT NULL,
  `width` decimal(8,0) UNSIGNED DEFAULT NULL,
  `length` decimal(8,0) UNSIGNED DEFAULT NULL,
  `weight` decimal(8,1) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `sku`, `name`, `price`, `productType`, `status`, `size`, `height`, `width`, `length`, `weight`, `created_at`) VALUES
(1, '123-ABC-123', 'Book1', '123.00', 'book', 0, NULL, NULL, NULL, NULL, '2.0', '2023-04-19 13:49:33'),
(2, '124-ABC-124', 'Book2', '123.00', 'book', 0, NULL, NULL, NULL, NULL, '2.0', '2023-04-19 13:49:33'),
(3, '134-ABC-134', 'Furniture1', '125.00', 'furniture', 0, NULL, '12', '14', '15', NULL, '2023-04-19 13:50:26'),
(4, '135-ABC-135', 'Furniture2', '125.00', 'furniture', 0, NULL, '12', '14', '15', NULL, '2023-04-19 13:50:26'),
(5, '156-ABC-156', 'DVD-disc1', '1235.00', 'dvd', 0, '1024', NULL, NULL, NULL, NULL, '2023-04-19 13:51:10');
(6, '157-ABC-157', 'DVD-disc2', '1235.00', 'dvd', 0, '1024', NULL, NULL, NULL, NULL, '2023-04-19 13:51:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `SKU` (`sku`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
