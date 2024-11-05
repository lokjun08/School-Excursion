-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 04, 2024 at 04:34 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school_excursion`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `reset_token`, `token_expiry`) VALUES
(1, 'Jun', 'aujenlee6544@gmail.com', '$2y$10$CgLbOOJnAYu.rQJBn.JL2.GM6TlmM26gl7k/PHPHBVhX1IrQxv5kK', NULL, NULL),
(2, 'John', 'leemumu2004@gmail.com', '$2y$10$0jDxhclMydvl92B0FVyXKeLtKPgKEKibSsUFhK2eRf.WJtfJxS6ai', NULL, NULL),
(3, 'Hao', 'cheeling64@gmail.com', '$2y$10$A1kO6oHFZBrcxsZ6599dSOcZnRZJy6p8Y/cYu0RdXtmF6azgGznzu', NULL, NULL),
(4, 'jjj', 'jj@gmail.com', '$2y$10$Aejiud7YDFSZHfhqN3.0nOZ.hE2QsT/7QjM.uYiS105lrmfTMThym', NULL, NULL),
(6, 'jjj1', 'jj1@gmail.com', '$2y$10$Rj4vvNpUKkr.XEtUOFTBGO.QBlMJd3W6lvuayO1IXwxIkblE0e7ke', NULL, NULL);

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
