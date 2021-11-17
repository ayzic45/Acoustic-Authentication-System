-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 17, 2021 at 05:19 PM
-- Server version: 10.5.12-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u570667022_ukznacousticDB`
--

-- --------------------------------------------------------

--
-- Table structure for table `ac_users`
--

CREATE TABLE `ac_users` (
  `user_id` bigint(20) NOT NULL,
  `username` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fullname` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_number` varchar(13) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_address` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PIN` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `control` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_created` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ac_users`
--

INSERT INTO `ac_users` (`user_id`, `username`, `fullname`, `mobile_number`, `email_address`, `password`, `PIN`, `control`, `status`, `date_created`) VALUES
(50, 'AYA4646', 'AYA', '0822581472', 'AYA4646@GMAIL.COM', '11111111', '1111', NULL, NULL, NULL),
(1000, 'Sabza18', 'Sabelo Mkhize', '0616835393', 'asmdluli85@yahoo.com', '00000000', '9068', NULL, 'Active', '2021-11-09'),
(1001, 'AYA796', 'Ayanda Mlambo', '0658007931', 'ayzic@gmail.com', '11111111', '1111', '0', 'Active', '2021-11-03'),
(1002, 'AYA4545', 'ayanda mdluli', '0658007937', 'ayzic45@gmail.com', '12345678', '3987', '0', 'Recovery Phase', '2021-11-10');

-- --------------------------------------------------------

--
-- Table structure for table `authentication`
--

CREATE TABLE `authentication` (
  `user_id` bigint(20) NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_address` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `locked` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `securecode` varchar(24) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fail_attempts` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lock_time` datetime DEFAULT NULL,
  `suspension_time` datetime DEFAULT NULL,
  `control` int(11) DEFAULT NULL,
  `review` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `authentication`
--

INSERT INTO `authentication` (`user_id`, `username`, `email_address`, `locked`, `status`, `securecode`, `fail_attempts`, `lock_time`, `suspension_time`, `control`, `review`) VALUES
(50, 'AYA4646', 'AYA4646@GMAIL.COM', NULL, NULL, 'UKZN-ACOUSTIC-AUTHENTICA', '0', NULL, NULL, NULL, NULL),
(1000, 'Sabza18', 'asmdluli85@yahoo.com', NULL, 'Active', 'kXNZBmjYTLqFMCcEgv-tedo3', '1', NULL, NULL, NULL, NULL),
(1001, 'AYA796', 'ayzic@gmail.com', '', 'Active', 'DeopvJBqVH4xzMmjAPE02gu', '7', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, ''),
(1002, 'AYA4545', 'ayzic45@gmail.com', '4', 'Recovery Phase', '7zAM5OhYmNdu9gJy1QVSZI2e', '8', '2021-11-10 23:43:00', '0000-00-00 00:00:00', 1, 'Action Required');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ac_users`
--
ALTER TABLE `ac_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `mobile_number` (`mobile_number`),
  ADD UNIQUE KEY `email_address` (`email_address`);

--
-- Indexes for table `authentication`
--
ALTER TABLE `authentication`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `securecode` (`securecode`),
  ADD UNIQUE KEY `username_2` (`username`),
  ADD UNIQUE KEY `email` (`email_address`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ac_users`
--
ALTER TABLE `ac_users`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1004;

--
-- AUTO_INCREMENT for table `authentication`
--
ALTER TABLE `authentication`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1004;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
