-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 02, 2019 at 10:15 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `used_car_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `makes`
--

CREATE TABLE `makes` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `makes`
--

INSERT INTO `makes` (`id`, `name`) VALUES
(18, 'Acura'),
(8, 'Ford'),
(17, 'Honda'),
(16, 'Huyndai'),
(10, 'Kia'),
(20, 'Land Rover'),
(19, 'Lexus'),
(23, 'Mitsubishi'),
(21, 'Ram'),
(22, 'Subaru'),
(15, 'Toyota');

-- --------------------------------------------------------

--
-- Table structure for table `models`
--

CREATE TABLE `models` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `makeid` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `models`
--

INSERT INTO `models` (`id`, `name`, `makeid`) VALUES
(18, 'Sportage', 8),
(19, 'Sorrento', 10),
(20, 'Fusion', 8),
(21, 'Prius II', 15),
(23, 'Optima', 10),
(25, 'Elantra', 16),
(27, 'Corolla', 15),
(28, 'Accord', 17),
(32, 'Dessert', 8),
(33, 'ILX', 18),
(34, 'RLX ', 18),
(35, 'MDX', 18);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT 0,
  `password` varchar(60) NOT NULL,
  `registrationDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `lastname`, `firstname`, `email`, `isAdmin`, `password`, `registrationDate`) VALUES
(22, 'test1', 'test', 'user', 'test2@gmail.com', 1, '7c222fb2927d828af22f592134e8932480637c0d', '2019-10-20'),
(24, 'phan.dang', 'Phan', 'Dang', 'phan.dang@gmail.com', 0, 'ce052d1434374bf659bdcd22e2e692038b2e1020', '2019-10-25');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `vehicle_id` int(10) UNSIGNED NOT NULL,
  `model_id` int(10) UNSIGNED NOT NULL,
  `year` int(10) UNSIGNED NOT NULL,
  `vehicle_type_id` int(10) UNSIGNED NOT NULL,
  `vehicle_power_type_id` int(10) UNSIGNED NOT NULL,
  `vin` varchar(20) NOT NULL,
  `dealer_purchase_date` datetime NOT NULL,
  `dealer_purchase_price` double NOT NULL,
  `sold_date` datetime DEFAULT NULL,
  `sold_price` double DEFAULT NULL,
  `additional_cost` double DEFAULT NULL,
  `color` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`vehicle_id`, `model_id`, `year`, `vehicle_type_id`, `vehicle_power_type_id`, `vin`, `dealer_purchase_date`, `dealer_purchase_price`, `sold_date`, `sold_price`, `additional_cost`, `color`) VALUES
(57, 20, 2019, 1, 2, '1B7GG2AN9YS629756', '2019-10-15 00:00:00', 34000, '2019-11-27 00:00:00', 40000, 200, 'Gray'),
(58, 25, 2020, 1, 1, 'JH4DA3469HS019532', '2019-10-28 00:00:00', 43499, '2019-10-31 00:00:00', 45000, NULL, 'gray'),
(59, 20, 2020, 1, 3, 'JH4DC4340SS001223', '2019-10-01 00:00:00', 23999, NULL, NULL, NULL, 'Blue'),
(60, 20, 2029, 1, 1, 'JH4DC4340SS001220', '2019-10-16 00:00:00', 43021, NULL, NULL, NULL, 'Red'),
(61, 18, 2020, 4, 2, '1234567890987890X', '2019-11-06 00:00:00', 5000, '2019-11-02 00:00:00', 6000, 3000, 'Yellow'),
(62, 18, 2019, 4, 2, 'JA3AP57J5SY000719', '2019-11-02 00:00:00', 25999, '2019-11-27 00:00:00', 30000, 200, 'Black');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_power_types`
--

CREATE TABLE `vehicle_power_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vehicle_power_types`
--

INSERT INTO `vehicle_power_types` (`id`, `name`) VALUES
(2, 'Diesel'),
(6, 'Electric Vehicle'),
(1, 'Gasoline'),
(3, 'Hybrid');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_types`
--

CREATE TABLE `vehicle_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vehicle_types`
--

INSERT INTO `vehicle_types` (`id`, `name`) VALUES
(4, 'ATV'),
(6, 'Crossover'),
(1, 'Sedan'),
(5, 'SUV'),
(2, 'Truck '),
(3, 'Van '),
(7, 'Wagon');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `makes`
--
ALTER TABLE `makes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `IDX_UNIQUE_MAKE_NAME` (`name`) USING BTREE;

--
-- Indexes for table `models`
--
ALTER TABLE `models`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `model_name_unique_index` (`name`) USING BTREE,
  ADD KEY `makes_id_fk` (`makeid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `IDX_UNIQUE_USERNAME` (`username`) USING BTREE,
  ADD KEY `IDX_LASTNAME` (`lastname`) USING BTREE,
  ADD KEY `IDX_FIRSTNAME` (`firstname`) USING BTREE,
  ADD KEY `IDX_EMAIL` (`email`) USING BTREE;

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`vehicle_id`),
  ADD KEY `model_vehicle_id_fk` (`model_id`),
  ADD KEY `vehicle_type_id_fk` (`vehicle_type_id`),
  ADD KEY `vehicle_power_type_id_fk` (`vehicle_power_type_id`);

--
-- Indexes for table `vehicle_power_types`
--
ALTER TABLE `vehicle_power_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `power_type_unique_index` (`name`) USING BTREE;

--
-- Indexes for table `vehicle_types`
--
ALTER TABLE `vehicle_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vehicle_type_unique_index` (`name`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `makes`
--
ALTER TABLE `makes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `models`
--
ALTER TABLE `models`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `vehicle_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `vehicle_power_types`
--
ALTER TABLE `vehicle_power_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `vehicle_types`
--
ALTER TABLE `vehicle_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `models`
--
ALTER TABLE `models`
  ADD CONSTRAINT `makes_id_fk` FOREIGN KEY (`makeid`) REFERENCES `makes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `model_vehicle_id_fk` FOREIGN KEY (`model_id`) REFERENCES `models` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vehicle_power_type_id_fk` FOREIGN KEY (`vehicle_power_type_id`) REFERENCES `vehicle_power_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vehicle_type_id_fk` FOREIGN KEY (`vehicle_type_id`) REFERENCES `vehicle_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
