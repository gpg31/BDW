-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2024 at 06:37 PM
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
-- Database: `blood_donation`
--
CREATE DATABASE IF NOT EXISTS `blood_donation` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `blood_donation`;

-- --------------------------------------------------------

--
-- Table structure for table `bloodinventory`
--

DROP TABLE IF EXISTS `bloodinventory`;
CREATE TABLE `bloodinventory` (
  `blood_id` int(11) NOT NULL,
  `blood_type` varchar(10) NOT NULL,
  `quantity` int(11) NOT NULL,
  `hospital_id` int(11) NOT NULL,
  `recieveddate` datetime DEFAULT current_timestamp(),
  `expirydate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

DROP TABLE IF EXISTS `donations`;
CREATE TABLE `donations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `blood_type` varchar(10) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `donation_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Table structure for table `hospitals`
--

DROP TABLE IF EXISTS `hospitals`;
CREATE TABLE `hospitals` (
  `hosp_id` int(11) NOT NULL,
  `hospital_name` varchar(30) NOT NULL,
  `location` varchar(30) NOT NULL,
  `email` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hospitalstaffs`
--

DROP TABLE IF EXISTS `hospitalstaffs`;
CREATE TABLE `hospitalstaffs` (
  `hsid` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `hosp_id` int(11) NOT NULL,
  `contacts` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

DROP TABLE IF EXISTS `requests`;
CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `recipient_id` int(11) DEFAULT NULL,
  `blood_type` varchar(10) NOT NULL,
  `quantity` int(11) NOT NULL,
  `request_date` datetime DEFAULT current_timestamp(),
  `status` enum('pending','fulfilled') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `blood_type` enum('A+','A-','B+','B-','O+','O-','AB+','AB-') NOT NULL,
  `role` enum('admin','donor','recipient','hospital_staff') DEFAULT NULL,
  `location` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `blood_type`, `role`, `location`) VALUES
(1, 'Gopu Girish', 'sdasdasad@gmail.com', '$2y$10$a.KLxT0nNiHzM5rbAaQEFuPczmW2qgbDWt5JS95l4Hrm6THnQv8f2', 'A+', 'donor', 'tdpa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bloodinventory`
--
ALTER TABLE `bloodinventory`
  ADD PRIMARY KEY (`blood_id`),
  ADD KEY `hospital_id` (`hospital_id`);

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `hospitals`
--
ALTER TABLE `hospitals`
  ADD PRIMARY KEY (`hosp_id`);

--
-- Indexes for table `hospitalstaffs`
--
ALTER TABLE `hospitalstaffs`
  ADD PRIMARY KEY (`hsid`),
  ADD KEY `hosp_id` (`hosp_id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recipient_id` (`recipient_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bloodinventory`
--
ALTER TABLE `bloodinventory`
  MODIFY `blood_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hospitals`
--
ALTER TABLE `hospitals`
  MODIFY `hosp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hospitalstaffs`
--
ALTER TABLE `hospitalstaffs`
  MODIFY `hsid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bloodinventory`
--
ALTER TABLE `bloodinventory`
  ADD CONSTRAINT `bloodinventory_ibfk_1` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`hosp_id`);

--
-- Constraints for table `donations`
--
ALTER TABLE `donations`
  ADD CONSTRAINT `donations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `hospitalstaffs`
--
ALTER TABLE `hospitalstaffs`
  ADD CONSTRAINT `hospitalstaffs_ibfk_1` FOREIGN KEY (`hosp_id`) REFERENCES `hospitals` (`hosp_id`);

--
-- Constraints for table `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`recipient_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
