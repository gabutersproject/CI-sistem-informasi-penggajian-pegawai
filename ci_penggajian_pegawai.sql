-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 22, 2022 at 04:55 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ci_penggajian_pegawai`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id_admin` int(11) NOT NULL,
  `kd_admin` varchar(10) NOT NULL,
  `nm_admin` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `kd_admin`, `nm_admin`, `username`, `password`, `photo`) VALUES
(5, 'AD001', 'Administrator', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', '1525892431473.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `detil_gaji`
--

CREATE TABLE IF NOT EXISTS `detil_gaji` (
  `id_detil_gaji` int(11) NOT NULL,
  `no_slip` varchar(30) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `id_potongan` int(11) NOT NULL,
  `jml_potongan` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detil_gaji`
--

INSERT INTO `detil_gaji` (`id_detil_gaji`, `no_slip`, `nip`, `id_potongan`, `jml_potongan`) VALUES
(1, '240318001', '121212', 2, 50000);

-- --------------------------------------------------------

--
-- Table structure for table `gaji`
--

CREATE TABLE IF NOT EXISTS `gaji` (
  `id_gaji` int(11) NOT NULL,
  `no_slip` varchar(30) NOT NULL,
  `tgl` date NOT NULL,
  `pendapatan` int(11) NOT NULL,
  `potongan` int(11) NOT NULL,
  `gaji_bersih` int(11) NOT NULL,
  `jml_jam_lembur` int(11) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `id_admin` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gaji`
--

INSERT INTO `gaji` (`id_gaji`, `no_slip`, `tgl`, `pendapatan`, `potongan`, `gaji_bersih`, `jml_jam_lembur`, `nip`, `id_admin`) VALUES
(1, '240318001', '2018-03-24', 8230000, 50000, 8180000, 12, '121212', 1);

-- --------------------------------------------------------

--
-- Table structure for table `golongan`
--

CREATE TABLE IF NOT EXISTS `golongan` (
  `id_golongan` int(11) NOT NULL,
  `golongan` varchar(10) NOT NULL,
  `tj_suami_istri` varchar(50) NOT NULL,
  `tj_anak` varchar(50) NOT NULL,
  `uang_makan` varchar(50) NOT NULL,
  `uang_lembur` varchar(50) NOT NULL,
  `askes` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `golongan`
--

INSERT INTO `golongan` (`id_golongan`, `golongan`, `tj_suami_istri`, `tj_anak`, `uang_makan`, `uang_lembur`, `askes`) VALUES
(1, '2A', '400000', '150000', '350000', '15000', '150000'),
(2, '1A', '450000', '150000', '350000', '10000', '150000');

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE IF NOT EXISTS `jabatan` (
  `kd_jabatan` varchar(10) NOT NULL,
  `nm_jabatan` varchar(50) NOT NULL,
  `gapok` varchar(20) NOT NULL,
  `tj_jabatan` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`kd_jabatan`, `nm_jabatan`, `gapok`, `tj_jabatan`) VALUES
('MN001', 'Manager', '5000000', '2000000'),
('KR001', 'Karyawan', '3500000', '1000000'),
('DR001', 'Direktur', '11000000', '1500000'),
('SP001', 'Satpam', '2500000', '800000'),
('OB001', 'Office Boy', '1800000', '500000');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE IF NOT EXISTS `pegawai` (
  `id_pegawai` int(11) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `nm_pegawai` varchar(50) NOT NULL,
  `kd_jabatan` varchar(10) NOT NULL,
  `id_golongan` int(11) NOT NULL,
  `status_nikah` varchar(15) NOT NULL,
  `jml_anak` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id_pegawai`, `nip`, `nm_pegawai`, `kd_jabatan`, `id_golongan`, `status_nikah`, `jml_anak`) VALUES
(1, '121212', 'juni', 'MN001', 1, '1', '2'),
(2, '1213', 'Ajis', 'KR001', 2, '2', '0'),
(3, '131321', 'Kiki', 'MN001', 1, '1', '3');

-- --------------------------------------------------------

--
-- Table structure for table `potongan`
--

CREATE TABLE IF NOT EXISTS `potongan` (
  `id_potongan` int(11) NOT NULL,
  `kd_potongan` varchar(10) NOT NULL,
  `nm_potongan` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `potongan`
--

INSERT INTO `potongan` (`id_potongan`, `kd_potongan`, `nm_potongan`) VALUES
(1, '100', 'BPSJ'),
(2, '101', 'Bon Karyawan'),
(3, '102', 'Asuransi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `detil_gaji`
--
ALTER TABLE `detil_gaji`
  ADD PRIMARY KEY (`id_detil_gaji`);

--
-- Indexes for table `gaji`
--
ALTER TABLE `gaji`
  ADD PRIMARY KEY (`id_gaji`);

--
-- Indexes for table `golongan`
--
ALTER TABLE `golongan`
  ADD PRIMARY KEY (`id_golongan`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id_pegawai`);

--
-- Indexes for table `potongan`
--
ALTER TABLE `potongan`
  ADD PRIMARY KEY (`id_potongan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `detil_gaji`
--
ALTER TABLE `detil_gaji`
  MODIFY `id_detil_gaji` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `gaji`
--
ALTER TABLE `gaji`
  MODIFY `id_gaji` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `golongan`
--
ALTER TABLE `golongan`
  MODIFY `id_golongan` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id_pegawai` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `potongan`
--
ALTER TABLE `potongan`
  MODIFY `id_potongan` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
