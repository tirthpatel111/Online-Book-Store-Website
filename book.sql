-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2024 at 12:50 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `book`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_table`
--

CREATE TABLE `audit_table` (
  `audit_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `login_time` datetime NOT NULL,
  `logout_time` datetime DEFAULT NULL,
  `role` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `audit_table`
--

INSERT INTO `audit_table` (`audit_id`, `user_id`, `login_time`, `logout_time`, `role`) VALUES
(1, 1, '2024-11-25 16:34:55', '2024-11-25 16:34:59', 'admin'),
(2, 2, '2024-11-25 16:35:51', '2024-11-25 16:35:56', 'user'),
(3, 2, '2024-11-25 16:36:26', '2024-11-25 16:36:32', 'user'),
(4, 1, '2024-11-25 16:37:32', '2024-11-25 16:37:38', 'admin'),
(5, 2, '2024-11-25 16:39:06', '2024-11-25 16:41:35', 'user'),
(6, 1, '2024-11-25 16:41:40', '2024-11-25 16:42:01', 'admin'),
(7, 2, '2024-11-25 16:42:07', '2024-11-25 16:43:33', 'user'),
(8, 1, '2024-11-25 16:48:24', '2024-11-25 16:49:54', 'admin'),
(9, 3, '2024-11-25 16:50:11', '2024-11-25 16:50:53', 'user'),
(10, 1, '2024-11-25 16:51:03', '2024-11-25 16:51:11', 'admin'),
(11, 3, '2024-11-25 16:51:18', '2024-11-25 16:51:37', 'user'),
(12, 1, '2024-11-25 16:51:44', '2024-11-25 16:52:05', 'admin'),
(13, 1, '2024-11-25 16:52:53', '2024-11-25 16:53:42', 'admin'),
(14, 3, '2024-11-25 23:58:32', '2024-11-26 00:20:35', 'user'),
(15, 4, '2024-11-26 00:26:26', '2024-11-26 00:27:50', 'user'),
(16, 1, '2024-11-26 00:28:12', '2024-11-26 00:29:30', 'admin'),
(17, 1, '2024-11-26 00:31:58', '2024-11-26 00:49:43', 'admin'),
(18, 4, '2024-11-26 00:50:00', '2024-11-26 00:53:08', 'user'),
(19, 1, '2024-11-26 00:54:48', '2024-11-26 00:55:19', 'admin'),
(20, 5, '2024-11-26 01:01:43', '2024-11-26 01:11:41', 'user'),
(21, 4, '2024-11-26 01:12:03', '2024-11-26 01:17:04', 'user'),
(22, 4, '2024-11-26 10:41:44', '2024-11-26 10:42:43', 'user'),
(23, 1, '2024-11-26 10:42:58', '2024-11-26 10:48:46', 'admin'),
(24, 4, '2024-11-26 10:54:04', '2024-11-26 10:56:04', 'user'),
(25, 1, '2024-11-26 10:56:09', '2024-11-26 10:57:40', 'admin'),
(26, 1, '2024-11-26 11:00:37', '2024-11-26 11:10:26', 'admin'),
(27, 4, '2024-11-26 11:10:33', '2024-11-26 11:17:34', 'user'),
(28, 1, '2024-11-26 11:28:07', '2024-11-26 11:35:39', 'admin'),
(29, 4, '2024-11-26 11:33:45', '2024-11-26 11:46:34', 'user'),
(30, 1, '2024-11-26 11:36:06', '2024-11-26 11:43:47', 'admin'),
(31, 4, '2024-11-26 11:36:18', '2024-11-26 12:11:07', 'user'),
(32, 4, '2024-11-26 11:38:12', NULL, 'user'),
(33, 4, '2024-11-26 11:52:14', NULL, 'user'),
(34, 4, '2024-11-26 12:11:30', NULL, 'user'),
(35, 6, '2024-11-26 12:15:40', '2024-11-26 12:16:45', 'user'),
(36, 5, '2024-11-26 12:17:12', '2024-11-26 12:18:05', 'user'),
(37, 5, '2024-11-26 12:21:46', '2024-11-26 12:22:55', 'user'),
(38, 1, '2024-11-26 12:23:05', '2024-11-26 12:24:43', 'admin'),
(39, 8, '2024-11-26 14:50:13', '2024-11-26 15:30:48', 'user'),
(40, 6, '2024-11-26 15:31:26', '2024-11-26 15:37:24', 'user'),
(41, 8, '2024-11-26 15:37:31', '2024-11-26 15:46:27', 'user'),
(42, 1, '2024-11-26 15:46:32', '2024-11-26 15:46:38', 'admin'),
(43, 8, '2024-11-26 15:47:00', '2024-11-26 15:50:53', 'user'),
(44, 8, '2024-11-26 15:50:59', NULL, 'user'),
(45, 1, '2024-11-27 16:45:19', '2024-12-10 16:58:20', 'admin'),
(46, 5, '2024-11-27 16:51:57', '2024-11-27 16:53:47', 'user'),
(47, 10, '2024-12-10 16:36:11', '2024-12-10 16:54:26', 'user'),
(48, 10, '2024-12-10 16:54:40', '2024-12-10 16:54:46', 'user'),
(49, 1, '2024-12-10 16:56:55', '2024-12-10 17:19:06', 'admin'),
(50, 10, '2024-12-10 16:58:38', '2024-12-10 17:16:50', 'user'),
(51, 1, '2024-12-10 17:17:24', NULL, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `name`, `price`, `quantity`, `image`) VALUES
(3, 2, 'Indian Polity', 340, 1, 'book2.jpg'),
(10, 4, 'Indian Polity', 340, 1, 'book2.jpg'),
(12, 4, 'Hidden Potential', 380, 2, 'book3.jpg'),
(21, 10, 'Indian Polity', 340, 9, 'book2.jpg'),
(22, 10, 'Hidden Potential', 380, 1, 'book3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `user_id` int(50) NOT NULL,
  `order_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`user_id`, `order_id`) VALUES
(8, 10),
(5, 11),
(10, 12);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(11) NOT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `method`, `address`, `total_products`, `total_price`, `payment_status`) VALUES
(11, 5, 'cash on delivery', 'abc', ' Indian Polity (1) ', 340, 'completed'),
(12, 10, 'cash on delivery', '123,mn', ' Indian Polity (1) ', 340, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`) VALUES
(4, 'Let Us C', 399, 'book1.jpg'),
(5, 'Indian Polity', 340, 'book2.jpg'),
(6, 'Hidden Potential', 380, 'book3.jpg'),
(9, 'Harry Porter', 500, 'book7.jpg'),
(10, 'AI', 510, 'Ai.jpg'),
(11, 'JAVA', 440, 'java.jfif'),
(12, 'Mahabharat', 480, 'Mahabharat.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`id`, `name`, `email`, `number`, `password`, `user_type`) VALUES
(1, 'Admin', 'admin@gmail.com', '', '1234', 'admin'),
(10, 'User', 'u@gmail.com', '123456789', '1', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_table`
--
ALTER TABLE `audit_table`
  ADD PRIMARY KEY (`audit_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_table`
--
ALTER TABLE `audit_table`
  MODIFY `audit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
