-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 28, 2023 at 03:33 AM
-- Server version: 5.7.24
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_tasek`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tabungan_pelajar`
--

CREATE TABLE `tbl_tabungan_pelajar` (
  `id_tabungan` int(11) NOT NULL,
  `email` varchar(80) NOT NULL,
  `nama_lengkap` varchar(80) NOT NULL,
  `jenis_kelamin` varchar(20) NOT NULL,
  `kelas` varchar(30) NOT NULL,
  `angkatan` year(4) NOT NULL,
  `saldo` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_tabungan_pelajar`
--

INSERT INTO `tbl_tabungan_pelajar` (`id_tabungan`, `email`, `nama_lengkap`, `jenis_kelamin`, `kelas`, `angkatan`, `saldo`, `status`, `created_at`, `updated_at`) VALUES
(42, 'galihprasetya181@smk.belajar.id', 'galih anggoro prasetya', 'laki laki', 'XII TKJ (3)', '2019', '100.000', 'tidak aktif', '2023-07-26', '2023-07-26'),
(43, 'testing@gmail.com', 'testing', 'perempuan', 'XII TKJ (4)', '2017', '550.000', 'aktif', '2023-07-26', '2023-07-26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_tabungan_pelajar`
--
ALTER TABLE `tbl_tabungan_pelajar`
  ADD PRIMARY KEY (`id_tabungan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_tabungan_pelajar`
--
ALTER TABLE `tbl_tabungan_pelajar`
  MODIFY `id_tabungan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
