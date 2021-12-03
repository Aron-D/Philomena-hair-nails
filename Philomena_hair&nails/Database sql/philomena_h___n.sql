-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2021 at 01:26 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `philomena_h_&_n`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `id` int(11) NOT NULL,
  `date` bigint(14) NOT NULL,
  `cid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `total_price` decimal(11,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`id`, `date`, `cid`, `sid`, `total_price`) VALUES
(2, 0, 5, 1, '50');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(14) NOT NULL,
  `password` varchar(100) NOT NULL,
  `street` varchar(50) NOT NULL,
  `postal_code` varchar(6) NOT NULL,
  `place` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `role_id`, `fname`, `lname`, `email`, `phone`, `password`, `street`, `postal_code`, `place`) VALUES
(5, 1, 'Mashal', 'Dosti', 'mashal-dom@hotmail.com', '619611650', '1605bd1a6a436895827103b59d9e96c2e87067ce', 'absrechtstraat 61', '2729AW', 'Zoetermeer');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `role_id`, `name`, `username`, `password`) VALUES
(1, 2, 'Kimberly', 'Emp1', 'KEmp1'),
(2, 2, 'Britt', 'Emp2', 'BEmp2'),
(3, 2, 'Priscilla', 'Emp3', 'PEmp3'),
(4, 3, 'Jamy', 'Emp4', 'JEmp4'),
(5, 3, 'Angelique', 'Emp5', 'AEmp5');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`, `type`) VALUES
(1, 'Customer', NULL),
(2, 'Employee', 'Hairdresser'),
(3, 'Employee', 'Nailstylist');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `categories` varchar(100) NOT NULL,
  `products` varchar(150) NOT NULL,
  `price` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `categories`, `products`, `price`) VALUES
(1, 'nieuwe set', 'Naturel : Gel / powergel / acryl', '50.00'),
(2, 'nieuwe set', 'French manicure : gel / powergel / acryl', '55.00'),
(3, 'nieuwe set', 'Gelpolish: gel / powergel / acryl', '57.50'),
(4, 'nabehandeling', 'Naturel: gel / powergel / acryl', '32.50'),
(5, 'nabehandeling', 'French manicure: gel / powergel / acryl', '35.00'),
(6, 'nabehandeling', 'Gelpolish: gel / powergel / acryl', '37.50'),
(7, 'nabehandeling', 'Kunstnagels verwijderen', '25.00'),
(8, 'nabehandeling', 'Gel op natuurlijke nagels', '30.00'),
(9, 'nabehandeling', 'Gelpolish op natuurlijke nagels', '25.00'),
(10, 'handen', 'Manicure 30 min', '17.50'),
(11, 'handen', 'Gelpolish op natuurlijke nagels', '25.00'),
(12, 'handen', 'Manicure incl. gelpolish', '35.00'),
(13, 'voeten', 'Spa pedicure: eelt verwijderen en verzorging 30 min.', '27.50'),
(14, 'voeten', 'Gelpolish op tenen nagels', '25.00'),
(15, 'voeten', 'Gel met French manicure op teen nagels', '35.00'),
(16, 'voeten', 'Spa pedicure incl. Gelpolish', '45.00'),
(17, 'dames', 'Knippen', '25.00'),
(18, 'dames', 'Knippen / drogen / zonder product', '28.00'),
(19, 'dames', 'Knippen / modelleren', '32.00'),
(20, 'dames', 'Wassen / knippen', '28.00'),
(21, 'dames', 'Wassen / knippen / drogen / zonder product', '31.00'),
(22, 'dames', 'Wassen / knippen / modelleren', '35.00'),
(23, 'heren', 'Knippen', '25.00'),
(24, 'heren', 'Wassen / knippen', '27.00'),
(25, 'kinderen t/m 11 jaar', 'Knippen', '18.50'),
(26, 'kinderen t/m 11 jaar', 'Wassen / knippen', '21.50'),
(27, 'kinderen t/m 11 jaar', 'Wassen / knippen / drogen', '24.50'),
(28, 'kinderen 12 t/m 15 jaar', 'Knippen', '21.50'),
(29, 'kinderen 12 t/m 15 jaar', 'Wassen / knippen', '23.50'),
(30, 'kinderen 12 t/m 15 jaar', 'Knippen / drogen', '23.50'),
(31, 'kinderen 12 t/m 15 jaar', 'Wassen / knippen / drogen', '26.50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
