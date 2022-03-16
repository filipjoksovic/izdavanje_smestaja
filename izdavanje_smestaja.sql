-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 19, 2021 at 11:23 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `izdavanje_smestaja`
--

-- --------------------------------------------------------

--
-- Table structure for table `appartments`
--

CREATE TABLE `appartments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `location` varchar(300) NOT NULL,
  `number_of_rooms` int(11) NOT NULL,
  `max_customers` int(11) NOT NULL,
  `has_parking` int(11) NOT NULL,
  `has_wifi` int(11) NOT NULL,
  `smoking_allowed` int(11) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `appartments`
--

INSERT INTO `appartments` (`id`, `user_id`, `name`, `price`, `location`, `number_of_rooms`, `max_customers`, `has_parking`, `has_wifi`, `smoking_allowed`, `description`) VALUES
(2, 5, 'Dvosoban stan', 4000, 'Širi centar - Autokomanda, Beograd', 2, 4, 1, 1, 1, 'Izdajem dvosoban stan u sirem centru Beograda. Cena je mesecna, i u njenu cenu nisu uracunati racuni.'),
(4, 5, 'Stan tri sobe', 5000, 'Beograd', 3, 6, 1, 1, 1, 'izdajem stan u beogradu ');

-- --------------------------------------------------------

--
-- Table structure for table `appartment_images`
--

CREATE TABLE `appartment_images` (
  `id` int(11) NOT NULL,
  `appartment_id` int(11) NOT NULL,
  `path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `appartment_images`
--

INSERT INTO `appartment_images` (`id`, `appartment_id`, `path`) VALUES
(5, 2, 'upload/siri-centar---autokomanda-id43612-5425637026864-71797278866.jpg'),
(6, 2, 'upload/siri-centar---autokomanda-id43612-5425637026864-71797278867.jpg'),
(7, 2, 'upload/siri-centar---autokomanda-id43612-5425637026864-71797278868.jpg'),
(8, 2, 'upload/siri-centar---autokomanda-id43612-5425637026864-71797278869.jpg'),
(12, 4, 'upload/novi-beograd---novi-merkator-id43424-5425636973475-71797087018.jpg'),
(13, 4, 'upload/novi-beograd---novi-merkator-id43424-5425636973475-71797087019.jpg'),
(14, 4, 'upload/novi-beograd---novi-merkator-id43424-5425636973475-71797087020.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `appartment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `payment` int(11) NOT NULL,
  `date_start` date NOT NULL DEFAULT current_timestamp(),
  `date_end` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `appartment_id`, `user_id`, `payment`, `date_start`, `date_end`) VALUES
(8, 2, 7, 0, '2020-09-19', '2020-09-26');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `appartment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `review` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `appartment_id`, `user_id`, `rate`, `review`) VALUES
(1, 2, 7, 3, 'Osrednji');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(500) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `first_name`, `last_name`, `role`) VALUES
(5, 'testprodavac', 'test@prodavac.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'Test', 'Prodavac', 'seller'),
(6, 'admin', 'admin@admin.rs', '5f4dcc3b5aa765d61d8327deb882cf99', 'Admin', 'Main', 'admin'),
(7, 'peramikic', 'peramikic@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'Filip', 'Joksovic', 'user'),
(8, 'testkorisnik', 'test@korisnik.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'Test', 'Korisnik', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appartments`
--
ALTER TABLE `appartments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `appartment_images`
--
ALTER TABLE `appartment_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appartment_id` (`appartment_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appartment_id` (`appartment_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appartment_id` (`appartment_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appartments`
--
ALTER TABLE `appartments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `appartment_images`
--
ALTER TABLE `appartment_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appartments`
--
ALTER TABLE `appartments`
  ADD CONSTRAINT `appartments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `appartment_images`
--
ALTER TABLE `appartment_images`
  ADD CONSTRAINT `appartment_images_ibfk_1` FOREIGN KEY (`appartment_id`) REFERENCES `appartments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`appartment_id`) REFERENCES `appartments` (`id`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`appartment_id`) REFERENCES `appartments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
