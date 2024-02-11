-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 11, 2024 at 11:30 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `paragraf_zadatak`
--

-- --------------------------------------------------------

--
-- Table structure for table `nosioci_osiguranja`
--

CREATE TABLE `nosioci_osiguranja` (
  `id` int(10) UNSIGNED NOT NULL,
  `ime` varchar(255) COLLATE utf16_slovenian_ci NOT NULL,
  `prezime` varchar(255) COLLATE utf16_slovenian_ci NOT NULL,
  `broj_pasosa` varchar(6) COLLATE utf16_slovenian_ci NOT NULL,
  `datum_rodjenja` date NOT NULL,
  `email` varchar(255) COLLATE utf16_slovenian_ci NOT NULL,
  `broj_telefona` varchar(255) COLLATE utf16_slovenian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_slovenian_ci;

--
-- Dumping data for table `nosioci_osiguranja`
--

INSERT INTO `nosioci_osiguranja` (`id`, `ime`, `prezime`, `broj_pasosa`, `datum_rodjenja`, `email`, `broj_telefona`) VALUES
(16, 'Milos', 'Babura', '877777', '2024-02-22', 'test8@gmail.com', '0355659898'),
(17, 'NIkola', 'Milicevic', '266666', '2023-05-05', 'vemicnikola18@gmail.com', '0355659898'),
(18, 'Milos', 'Mitrovic', '888888', '2024-02-01', 'admin3@gmail.com', '0355659898'),
(19, 'Milos', 'Mitrovic', '888888', '2024-02-01', 'admin3@gmail.com', '0355659898');

-- --------------------------------------------------------

--
-- Table structure for table `osiguranici`
--

CREATE TABLE `osiguranici` (
  `id` int(10) UNSIGNED NOT NULL,
  `ime` varchar(255) COLLATE utf16_slovenian_ci NOT NULL,
  `prezime` varchar(255) COLLATE utf16_slovenian_ci NOT NULL,
  `broj_pasosa` varchar(6) COLLATE utf16_slovenian_ci NOT NULL,
  `datum_rodjenja` date NOT NULL,
  `nosilac_osiguranja_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_slovenian_ci;

--
-- Dumping data for table `osiguranici`
--

INSERT INTO `osiguranici` (`id`, `ime`, `prezime`, `broj_pasosa`, `datum_rodjenja`, `nosilac_osiguranja_id`) VALUES
(10, 'Milica', 'Zavetnica', '444444', '2024-02-14', 17),
(11, 'nikola', 'Zavetnica', '444444', '2024-02-21', 17);

-- --------------------------------------------------------

--
-- Table structure for table `polise`
--

CREATE TABLE `polise` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `start_at` date NOT NULL,
  `end_at` date NOT NULL,
  `tip_osiguranja` varchar(255) COLLATE utf16_slovenian_ci DEFAULT NULL,
  `nosilac_osiguranja_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_slovenian_ci;

--
-- Dumping data for table `polise`
--

INSERT INTO `polise` (`id`, `created_at`, `updated_at`, `start_at`, `end_at`, `tip_osiguranja`, `nosilac_osiguranja_id`) VALUES
(4, '2024-02-11', NULL, '2024-02-14', '2024-02-25', 'individualno', 16),
(5, '2024-02-11', NULL, '2024-02-24', '2024-02-29', 'grupno', 17),
(6, '2024-02-11', NULL, '2024-02-23', '2024-03-09', 'individualno', 18),
(7, '2024-02-11', NULL, '2024-02-23', '2024-03-09', 'individualno', 18);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `nosioci_osiguranja`
--
ALTER TABLE `nosioci_osiguranja`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `osiguranici`
--
ALTER TABLE `osiguranici`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nosilac_osiguranja_id` (`nosilac_osiguranja_id`);

--
-- Indexes for table `polise`
--
ALTER TABLE `polise`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nosilac_osiguranja_id` (`nosilac_osiguranja_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `nosioci_osiguranja`
--
ALTER TABLE `nosioci_osiguranja`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `osiguranici`
--
ALTER TABLE `osiguranici`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `polise`
--
ALTER TABLE `polise`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `osiguranici`
--
ALTER TABLE `osiguranici`
  ADD CONSTRAINT `osiguranici_ibfk_1` FOREIGN KEY (`nosilac_osiguranja_id`) REFERENCES `nosioci_osiguranja` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `polise`
--
ALTER TABLE `polise`
  ADD CONSTRAINT `polise_ibfk_1` FOREIGN KEY (`nosilac_osiguranja_id`) REFERENCES `nosioci_osiguranja` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
