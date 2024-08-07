-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 07, 2024 at 02:09 AM
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
-- Database: `car_rental_agency`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `model` varchar(255) NOT NULL,
  `number` varchar(50) NOT NULL,
  `seating_capacity` int(11) NOT NULL,
  `rent_per_day` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_booked` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `model`, `number`, `seating_capacity`, `rent_per_day`, `created_at`, `updated_at`, `is_booked`) VALUES
(1, 'Toyota Camry', 'ABC123', 5, 50.00, '2024-08-06 20:44:11', '2024-08-06 23:12:49', 1),
(2, 'Honda Civic', 'XYZ456', 5, 45.00, '2024-08-06 20:44:11', '2024-08-06 23:12:56', 1),
(3, 'Ford Mustang', 'MNO789', 4, 80.00, '2024-08-06 20:44:11', '2024-08-06 23:15:35', 1),
(4, 'Chevrolet Malibu', 'DEF101', 5, 2000.00, '2024-08-06 20:44:11', '2024-08-06 23:20:37', 1),
(7, 'Mercedes-Benz C-Class', 'PQR567', 5, 110.00, '2024-08-06 20:44:11', '2024-08-06 23:11:35', 0),
(8, 'Nissan Altima', 'STU890', 5, 60.00, '2024-08-06 20:44:11', '2024-08-06 23:28:11', 1),
(9, 'Hyundai Elantra', 'VWX213', 5, 40.00, '2024-08-06 20:44:11', '2024-08-06 23:11:35', 0),
(11, 'Toyota Camry', 'ABC123', 5, 200.00, '2024-08-06 20:55:46', '2024-08-06 22:52:31', 0),
(12, 'Toyota Camry', 'ABC123', 4, 600.00, '2024-08-06 23:26:05', '2024-08-06 23:26:05', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `id_number` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('agency','customer') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `phone`, `email`, `id_number`, `address`, `password`, `user_type`, `created_at`) VALUES
(1, 'test', '12345', 'test@something.com', '2345678', 'fdgde3wrfsvdfxvc', '$2y$10$DhYdNOuA.nHpDdd9c8B3/uv9O2gbCsmrBHbVqbCB/9NDJE.iOClG6', 'agency', '2024-08-05 21:13:04'),
(2, 'test', '45642675', 'test1@something.com', '457625765867', 'fdsgsew4rwrafve', '$2y$10$lhFiiaIUi5cBQDhT5A1Lo.UlwaRthwo.9fgSXXIdKr2XEIUGiyPPu', 'agency', '2024-08-05 21:15:53'),
(3, 'test', '454764565', 'hbkgg@yfuyf', '13q2422', 'dafdfer', '$2y$10$S1fDodYAa7EnQYe0NzPLAuoRon3u/dyWBDIPHMpExguDnfvBIsdb.', 'customer', '2024-08-05 21:21:37'),
(4, 'abcd', '324567890', 'abcd@test.com', '32456789', 'zsexchtjghbjnm', '$2y$10$XW/W5x86ggyUll0DegUGluYJbxRaq9zUevghsXpkh1ikOqBZxStC6', 'customer', '2024-08-06 22:43:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
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
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
