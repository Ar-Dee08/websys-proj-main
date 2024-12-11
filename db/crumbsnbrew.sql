-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 11, 2024 at 02:47 PM
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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_description` text NOT NULL,
  `product_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `product_description`, `product_price`) VALUES
(1, 'Test 1', 'Asdfghjkl', 120.00);

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE `user_login` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `dob` date DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_login`
--

INSERT INTO `user_login` (`id`, `username`, `dob`, `email`, `password`) VALUES
(1, 'Admin', NULL, 'admin@email.com', '$2y$10$0GntiNCE7lPnwhV.FoQ8c.rsXrjRZIM4AbLISko4LUmvm1hWLsJhi'),
(2, 'Admin2', NULL, 'admin2@email.com', '$2y$10$GMbl8dGDpeFeT2zs8H9DT.CliznG11aUVZJhchpZ/4bmB7NAb11RS'),
(3, 'Admin3', NULL, 'admin3@email.com', '$2y$10$UDbBEg.TYhE22geyqbcRsOu1g5jCnwDwy0jK5vIJDPnQ2E1gcRSAS'),
(4, 'Admin4', NULL, 'admin4@email.com', '$2y$10$Jk4vtj0jMJYFyv8N3ySwEuKKtoGJZ3.n42sSUJbMIvPdmQcJ80D9K'),
(5, 'Admin5', NULL, 'admin5@email.com', '$2y$10$DLt2m4zCSDOpIhROoiHTs.1Lk8jI6NrSzXqiwp.idZOYXNEsUqqIm'),
(31, 'Arjon', '2003-07-02', 'aj123@gmail.com', '$2y$10$syNHN0PUGkvmQzpikWukxujEmB7sBeTdaMzTE04dTX4sdp/WfseNK'),
(33, 'Kurukuru', NULL, 'fd@gmail.com', '$2y$10$nX/exYihfYVWtxQ/0zJZ9uIJ6gUk3L.yhB3Nxg7RfcCKvyIoDjGHC'),
(35, 'Grace', NULL, 'gra@email.com', '$2y$10$cOBcyFJdfzcdEmInf2pOwuR0wP3SNy1xamNR17NpUneXKZ83x7SjO');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_login`
--
ALTER TABLE `user_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
