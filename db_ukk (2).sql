-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2025 at 05:50 PM
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
-- Database: `db_ukk`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `BarangID` int(11) NOT NULL,
  `nama_barang` varchar(20) DEFAULT NULL,
  `jumlah_barang` int(11) NOT NULL,
  `kategori` enum('P','L') DEFAULT NULL,
  `tanggal_masuk` date NOT NULL,
  `harga_barang` decimal(10,0) NOT NULL,
  `PegawaiID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`BarangID`, `nama_barang`, `jumlah_barang`, `kategori`, `tanggal_masuk`, `harga_barang`, `PegawaiID`) VALUES
(1, 'Evangeline Premium C', 6, 'P', '2025-04-06', 20000, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `distribusi`
--

CREATE TABLE `distribusi` (
  `DistributorID` int(11) NOT NULL,
  `nama_toko` varchar(20) DEFAULT NULL,
  `TokoID` int(11) DEFAULT NULL,
  `BarangID` int(11) DEFAULT NULL,
  `nama_barang` varchar(20) NOT NULL,
  `tgl_keluar` date NOT NULL,
  `jml_barang_keluar` int(11) NOT NULL,
  `harga_barang` decimal(10,0) NOT NULL,
  `sub_total` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `distribusi`
--

INSERT INTO `distribusi` (`DistributorID`, `nama_toko`, `TokoID`, `BarangID`, `nama_barang`, `tgl_keluar`, `jml_barang_keluar`, `harga_barang`, `sub_total`) VALUES
(6, 'alfamart', NULL, NULL, 'Evangeline Premium C', '2025-04-10', 2, 20000, 40000);

-- --------------------------------------------------------

--
-- Table structure for table `toko`
--

CREATE TABLE `toko` (
  `TokoID` int(11) NOT NULL,
  `nama_toko` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `toko`
--

INSERT INTO `toko` (`TokoID`, `nama_toko`) VALUES
(1, 'alfamart'),
(2, 'borma');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `PegawaiID` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(8) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`PegawaiID`, `username`, `password`, `email`) VALUES
(1, 'gudang', 'gdg', 'gudang12@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`BarangID`),
  ADD KEY `PegawaiID` (`PegawaiID`);

--
-- Indexes for table `distribusi`
--
ALTER TABLE `distribusi`
  ADD PRIMARY KEY (`DistributorID`),
  ADD KEY `BarangID` (`BarangID`),
  ADD KEY `TokoID` (`TokoID`);

--
-- Indexes for table `toko`
--
ALTER TABLE `toko`
  ADD PRIMARY KEY (`TokoID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`PegawaiID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `BarangID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `distribusi`
--
ALTER TABLE `distribusi`
  MODIFY `DistributorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`PegawaiID`) REFERENCES `users` (`PegawaiID`);

--
-- Constraints for table `distribusi`
--
ALTER TABLE `distribusi`
  ADD CONSTRAINT `distribusi_ibfk_1` FOREIGN KEY (`BarangID`) REFERENCES `barang` (`BarangID`),
  ADD CONSTRAINT `distribusi_ibfk_2` FOREIGN KEY (`TokoID`) REFERENCES `toko` (`TokoID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
