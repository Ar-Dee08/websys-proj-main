-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 12, 2024 at 04:27 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crumbsnbrew`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `category_description`, `created_at`, `updated_at`) VALUES
(1, 'Coffee', 'A selection of expertly crafted coffee drinks made from high-quality beans.', '2024-12-12 01:31:43', '2024-12-12 14:32:13'),
(2, 'Tea', 'A selection of expertly brewed teas, carefully curated for a perfect cup.', '2024-12-12 15:16:59', '2024-12-12 15:18:19'),
(3, 'Pastry', 'A delightful assortment of freshly baked pastries, carefully crafted for a sweet treat.', '2024-12-12 15:20:43', '2024-12-12 15:20:43');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_description` text NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `removed` tinyint(1) DEFAULT 0,
  `status` enum('Active','Removed') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `product_description`, `product_price`, `category_id`, `removed`, `status`) VALUES
(1, 'Cafe Espanya', 'A rich and creamy latte, expertly blended with espresso and steamed milk to create a velvety-smooth coffee experience.', 125.00, 1, 0, 'Active'),
(2, 'Matcha Krim Frappe', 'A rich and creamy blend of matcha green tea and velvety ice, perfect for a pick-me-up on a warm day.', 149.00, 2, 0, 'Active'),
(3, 'Klasiko Crossaint', 'Flaky, buttery, and freshly baked, indulge in the rich flavor and tender texture.', 125.00, 3, 0, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE `user_login` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_login`
--

INSERT INTO `user_login` (`id`, `username`, `email`, `password`) VALUES
(1, 'Admin', 'admin@email.com', '$2y$10$0GntiNCE7lPnwhV.FoQ8c.rsXrjRZIM4AbLISko4LUmvm1hWLsJhi'),
(2, 'Admin2', 'admin2@email.com', '$2y$10$GMbl8dGDpeFeT2zs8H9DT.CliznG11aUVZJhchpZ/4bmB7NAb11RS'),
(3, 'Admin3', 'admin3@email.com', '$2y$10$UDbBEg.TYhE22geyqbcRsOu1g5jCnwDwy0jK5vIJDPnQ2E1gcRSAS'),
(4, 'Admin4', 'admin4@email.com', '$2y$10$Jk4vtj0jMJYFyv8N3ySwEuKKtoGJZ3.n42sSUJbMIvPdmQcJ80D9K'),
(5, 'Admin5', 'admin5@email.com', '$2y$10$DLt2m4zCSDOpIhROoiHTs.1Lk8jI6NrSzXqiwp.idZOYXNEsUqqIm'),
(31, 'Arjon', 'aj123@gmail.com', '$2y$10$syNHN0PUGkvmQzpikWukxujEmB7sBeTdaMzTE04dTX4sdp/WfseNK'),
(33, 'Kurukuru', 'fd@gmail.com', '$2y$10$nX/exYihfYVWtxQ/0zJZ9uIJ6gUk3L.yhB3Nxg7RfcCKvyIoDjGHC'),
(36, 'Grace', 'gra@email.com', '$2y$10$BFOBpgpXqsF1UPRCLZjV8uRwQ.ByU02UK18OBJdMDa09Rgeq/xb7q'),
(37, 'Ewan', 'asfdahjd@email.com', '$2y$10$Mp86JxSocVK30hiGD9H84.j1oS8z.D98Fwy55m5eFEXHpkAWmevSy');

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `user_id` int(11) NOT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `birthdate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`user_id`, `sex`, `birthdate`) VALUES
(36, 'Female', '2004-02-29'),
(37, 'Male', '2020-01-01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_login`
--
ALTER TABLE `user_login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_login`
--
ALTER TABLE `user_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
