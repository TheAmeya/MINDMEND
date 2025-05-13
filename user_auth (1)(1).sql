-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2024 at 09:06 PM
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
-- Database: `user_auth`
--

-- --------------------------------------------------------

--
-- Table structure for table `test_results`
--

CREATE TABLE `test_results` (
  `id` int(6) UNSIGNED NOT NULL,
  `user_id` int(6) NOT NULL,
  `test_name` varchar(255) NOT NULL,
  `score` int(3) NOT NULL,
  `test_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(15) NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `gender`, `profile_image`) VALUES
(1, 'Ameya Parab', 'RAj@gmail.com', '$2y$10$Mbn9ADsCGwkLRFbIF8PZwOtVTkRevt3MnFLRcM.ulMa6TGgSz1FCG', '', 'male', NULL),
(2, 'qa', 'sujjet@gmail.com', '$2y$10$1X3rbTPabkoOkOfn76rAY.pxivob.BYtRQz1UZC94W0fOwvcEy6vW', '', 'male', NULL),
(4, 'Sqwe', 'qwert@gmail.com', '$2y$10$tBVUGAD9fmo8HF8jKHCGJ.uQH9k6oKWHPUKAJ99PaTmx3hrZRk//S', '', 'male', NULL),
(5, 'Ajay', 'asapharmaplusconsultant@gmail.com', '$2y$10$aZ9Bm4t/Yud5gHa7/AFJTOmLO1ryMH6iM50gH8OeYYf.DY4bUOB42', '', 'male', NULL),
(6, 'Ajay', 'asa1pharmaplusconsultant@gmail.com', '$2y$10$BVa3/trtMfV6ANOOP2oR8uZCUFXs5TjfWLlh6ukS2BtB/EUu5AVC6', '', 'male', NULL),
(7, 'bn', 'bn@gmail.com', '$2y$10$mxPBS7amjwQSiyuDVRzumOoGAYB8yMvnKvZQpTQMH/7Y7HjS7vLk6', '', 'male', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `test_results`
--
ALTER TABLE `test_results`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `test_results`
--
ALTER TABLE `test_results`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
