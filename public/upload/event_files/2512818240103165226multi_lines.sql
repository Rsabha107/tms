-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 28, 2023 at 04:36 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `marktone_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `multi_lines`
--

CREATE TABLE `multi_lines` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `source` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `multi_lines`
--

INSERT INTO `multi_lines` (`id`, `parent_id`, `source`, `name`, `created_at`, `updated_at`) VALUES
(20, 13, 'ASGTO', '10', '2023-12-28 08:37:33', '2023-12-28 08:37:33'),
(21, 14, 'ASGTO', '12', '2023-12-28 08:42:11', '2023-12-28 08:42:11'),
(22, 17, 'ASGTO', '10', '2023-12-28 08:45:32', '2023-12-28 08:45:32'),
(23, 17, 'ASGTO', '11', '2023-12-28 08:45:32', '2023-12-28 08:45:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `multi_lines`
--
ALTER TABLE `multi_lines`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `multi_lines`
--
ALTER TABLE `multi_lines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
