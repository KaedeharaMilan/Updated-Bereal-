-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2024 at 08:28 AM
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
-- Database: `bereal`
--

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pw` varchar(255) NOT NULL,
  `role` enum('buyer','seller') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id`, `username`, `email`, `pw`, `role`) VALUES
(1, 'Gemuani', 'gemuanijomok@gmail.com', '$2y$10$5MWlDOSgg/rCFBJAd879KOXG7QKlVTPRKNgKnQcBvPe9dVb52bHGm', 'buyer'),
(2, 'Ibnu', 'ibnualdbest@gmail.com', '$2y$10$pidIODAhKiJNwVrBaNYXS.Fu8DoMWDTa1/vcVwoI0QoXP/HyX9Tze', 'seller'),
(4, 'Saipul', 'saipulganteng@gmail.com', '$2y$10$l.BK0qMoIw73RaNBEThZI.RbYtINWGqa6cBI7q1dCBZ1yMW/S0VH2', 'seller'),
(5, 'kontol', 'milankontol@gmail.com', '$2y$10$STi6qSyAy3ctrP4QWYyHNuS3HuCHuMIIykZ3iOKfAU4s9r4FX4zSm', 'buyer'),
(6, 'pepek', 'milanpepek@gmail.com', '$2y$10$8s8U.BS9lU5MvlYKOhutKuVpVGu.AhKnY2Bluq4u0ienUaVlNvENm', 'seller'),
(7, 'tes', 'tes@gmail.com', '$2y$10$C./ZirMG9F21vQ9kQXQ43.Bvn5oH7BtSE6OKE3VSEGeiIA.C5iquK', 'seller');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `buyer_id` int(11) DEFAULT NULL,
  `status` enum('purchased','pending') NOT NULL,
  `purchase_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `product_id`, `buyer_id`, `status`, `purchase_date`) VALUES
(4, 11, 7, 'purchased', '2024-12-11 14:20:38'),
(5, 11, 7, 'purchased', '2024-12-11 14:21:05'),
(6, 11, 7, 'purchased', '2024-12-11 14:22:01'),
(7, 11, 7, 'purchased', '2024-12-11 14:22:21'),
(8, 11, 7, 'purchased', '2024-12-11 14:22:51'),
(9, 11, 7, 'purchased', '2024-12-11 14:23:16');

-- --------------------------------------------------------

--
-- Table structure for table `seller_post`
--

CREATE TABLE `seller_post` (
  `id` int(11) NOT NULL,
  `preview` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `mini_desc` varchar(255) NOT NULL,
  `detail_desc` text NOT NULL,
  `seller_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seller_post`
--

INSERT INTO `seller_post` (`id`, `preview`, `nama`, `price`, `mini_desc`, `detail_desc`, `seller_id`) VALUES
(11, '67593eb5a4729.jpeg', 'Bapak dia', 55.00, 'e', 'e', 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `buyer_id` (`buyer_id`);

--
-- Indexes for table `seller_post`
--
ALTER TABLE `seller_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seller_id` (`seller_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `seller_post`
--
ALTER TABLE `seller_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `seller_post` (`id`),
  ADD CONSTRAINT `purchases_ibfk_2` FOREIGN KEY (`buyer_id`) REFERENCES `client` (`id`);

--
-- Constraints for table `seller_post`
--
ALTER TABLE `seller_post`
  ADD CONSTRAINT `seller_post_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `client` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
