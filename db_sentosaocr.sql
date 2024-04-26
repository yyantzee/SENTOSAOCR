-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 26, 2024 at 09:06 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sentosaocr`
--

-- --------------------------------------------------------

--
-- Table structure for table `ocr_data`
--

CREATE TABLE `ocr_data` (
  `id` int NOT NULL,
  `invoice_number` varchar(50) DEFAULT NULL,
  `invoice_date` varchar(55) DEFAULT NULL,
  `total_amount` int DEFAULT NULL,
  `tax` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `gr_number` varchar(50) DEFAULT NULL,
  `do_number` varchar(50) DEFAULT NULL,
  `files_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ocr_data`
--

INSERT INTO `ocr_data` (`id`, `invoice_number`, `invoice_date`, `total_amount`, `tax`, `gr_number`, `do_number`, `files_name`, `created_at`) VALUES
(9, 'PRTM-001', '03/01/2022', 5550000, 'https://kraftinvoicehandling.azurewebsites.net/dummy.xml', '19156', '00001', 'pdfpertamina_merge.pdf', '2024-04-24 06:23:37'),
(10, 'PRTM-132', '01/07/2022', 160000, 'https://kraftinvoicehandling.azurewebsites.net/dummy.xml', '8630', '00002', 'pdfpertamina_merge_3.pdf', '2024-04-24 06:24:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ocr_data`
--
ALTER TABLE `ocr_data`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ocr_data`
--
ALTER TABLE `ocr_data`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
