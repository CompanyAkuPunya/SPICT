-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 28, 2014 at 06:44 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `spict`
--
CREATE DATABASE IF NOT EXISTS `spict` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `spict`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `username` varchar(10) NOT NULL,
  `password` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin'),
(2, 'test', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `bahagian`
--

CREATE TABLE IF NOT EXISTS `bahagian` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Kod` varchar(10) NOT NULL,
  `Keterangan` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `bahagian`
--

INSERT INTO `bahagian` (`Id`, `Kod`, `Keterangan`) VALUES
(1, 'BAH1', 'Bahagian 1'),
(2, 'BAH2', 'Bahagian 2');

-- --------------------------------------------------------

--
-- Table structure for table `cawangan`
--

CREATE TABLE IF NOT EXISTS `cawangan` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Negeri` int(11) NOT NULL,
  `Kod` varchar(10) NOT NULL,
  `Keterangan` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `cawangan`
--

INSERT INTO `cawangan` (`Id`, `Negeri`, `Kod`, `Keterangan`) VALUES
(1, 5, 'HQ', 'Ibu Pejabat'),
(2, 4, 'P011', 'IPOH'),
(3, 2, 'K012', 'ALOR SETAR');

-- --------------------------------------------------------

--
-- Table structure for table `jeniskerosakan`
--

CREATE TABLE IF NOT EXISTS `jeniskerosakan` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Keterangan` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `jeniskerosakan`
--

INSERT INTO `jeniskerosakan` (`Id`, `Keterangan`) VALUES
(1, 'Jenis Kerosakan 1'),
(2, 'Jenis Kerosakan 2');

-- --------------------------------------------------------

--
-- Table structure for table `laporanselenggara`
--

CREATE TABLE IF NOT EXISTS `laporanselenggara` (
  `Id` int(12) NOT NULL AUTO_INCREMENT,
  `IdPeralatan` int(12) DEFAULT NULL,
  `JenisKerosakan` varchar(50) DEFAULT NULL,
  `TarikhLaporan` date DEFAULT NULL,
  `KeteranganKerosakan` varchar(255) DEFAULT NULL,
  `TarikhSelenggara` date DEFAULT NULL,
  `NotaSelenggara` varchar(255) DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL,
  `SLA` int(11) DEFAULT NULL,
  `Penyelenggara` varchar(255) DEFAULT NULL,
  `TC` datetime DEFAULT NULL,
  `PC` int(11) DEFAULT NULL,
  `TU` datetime DEFAULT NULL,
  `PU` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `laporanselenggara`
--

INSERT INTO `laporanselenggara` (`Id`, `IdPeralatan`, `JenisKerosakan`, `TarikhLaporan`, `KeteranganKerosakan`, `TarikhSelenggara`, `NotaSelenggara`, `Status`, `SLA`, `Penyelenggara`, `TC`, `PC`, `TU`, `PU`) VALUES
(1, 1, '1', '2013-11-06', 'MASUK AIR', '2013-11-13', 'TIDAK BOLEH DIBAIKI', '1', NULL, NULL, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(2, 2, '2', '2013-11-20', 'popopo', '2013-11-12', 'qweqwr', '2', NULL, NULL, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(3, 1, '1', '2013-11-06', 'Kerosakan maksima', '2013-11-19', 'wrqwrq', '2', NULL, NULL, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(4, 1, '2', '2013-12-16', 'rosak rosak', NULL, NULL, '-1', NULL, NULL, NULL, NULL, NULL, NULL),
(5, 1, '1', '2013-12-11', 'rosak', NULL, NULL, '-1', NULL, NULL, NULL, NULL, NULL, NULL),
(6, 1, '2', '2013-12-10', 'keterangn kerosakan', NULL, NULL, '-1', NULL, NULL, NULL, NULL, NULL, NULL),
(7, 1, '1', '2013-12-18', 'Tidak Boleh Open', '2013-12-17', 'da siap di baiki', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(8, 7, '1', '2014-01-01', 'laporan', '2013-12-20', 'Telah Selesai', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(9, 7, '1', '2013-12-19', 'ink tidak keluar', '2014-01-08', 'nota', '2', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `negeri`
--

CREATE TABLE IF NOT EXISTS `negeri` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Kod` varchar(10) NOT NULL,
  `Keterangan` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `negeri`
--

INSERT INTO `negeri` (`Id`, `Kod`, `Keterangan`) VALUES
(1, 'PER', 'PERLIS'),
(2, 'KDH', 'KEDAH'),
(3, 'PNG', 'PULAU PINANG'),
(4, 'PRK', 'PERAK'),
(5, 'SEL', 'SELANGOR');

-- --------------------------------------------------------

--
-- Table structure for table `peralatan`
--

CREATE TABLE IF NOT EXISTS `peralatan` (
  `Id` int(12) NOT NULL AUTO_INCREMENT,
  `Peralatan` varchar(150) DEFAULT NULL,
  `Jenis` varchar(150) DEFAULT NULL,
  `NoSiri` varchar(150) DEFAULT NULL,
  `Pengeluar` varchar(150) DEFAULT NULL,
  `Model` varchar(150) DEFAULT NULL,
  `Spesifikasi` varchar(255) DEFAULT NULL,
  `Kaedah` int(11) DEFAULT NULL,
  `TahunBeli` year(4) DEFAULT NULL,
  `DeskripsiProjek` varchar(255) DEFAULT NULL,
  `MulaSewa` date DEFAULT NULL,
  `TamatSewa` date DEFAULT NULL,
  `IdStaf` int(12) DEFAULT NULL,
  `IdSyarikat` int(12) DEFAULT NULL,
  `TC` datetime DEFAULT NULL,
  `PC` int(11) DEFAULT NULL,
  `TU` datetime DEFAULT NULL,
  `PU` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `peralatan`
--

INSERT INTO `peralatan` (`Id`, `Peralatan`, `Jenis`, `NoSiri`, `Pengeluar`, `Model`, `Spesifikasi`, `Kaedah`, `TahunBeli`, `DeskripsiProjek`, `MulaSewa`, `TamatSewa`, `IdStaf`, `IdSyarikat`, `TC`, `PC`, `TU`, `PU`) VALUES
(1, 'PC', 'Hardware', 'ASF124455', 'samsung', 'c123', 'test', NULL, 2013, NULL, NULL, NULL, 1, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(2, 'PRINTER', 'Hardware', 'TR11122', 'Canon', 'Pixma', 'Laserjet', 3, NULL, 'projek', '2014-01-14', '2014-01-15', 2, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(3, 'LAPTOP', 'Hardware', 'YR241', 'SONY', 'VIAO', '2gb ram', NULL, NULL, NULL, NULL, NULL, 1, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(4, 'KOMPUTER', 'Software', 'OP0999', 'samsung', 'Pixma', 'inkjet', NULL, NULL, NULL, NULL, NULL, 2, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(5, 'SCANNER', 'Hardware', 'PX919221', 'CANON', 'INKJET', 'INKJET, 3 IN 1', NULL, 2013, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL),
(6, 'Laptop', 'Hardware', 'PC1000000', 'Sony', 'Tablet', '2gb Ram\r\n500 HDD', NULL, NULL, NULL, '2013-12-17', '2013-12-31', 1, 2, NULL, NULL, NULL, NULL),
(7, 'PRINTER', 'Hardware', 'CN12345', 'CANON', 'INKJET', 'INKEJET', NULL, NULL, NULL, '2013-12-15', '2013-12-31', 3, 2, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `server`
--

CREATE TABLE IF NOT EXISTS `server` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `SMTP` varchar(255) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Port` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `server`
--

INSERT INTO `server` (`Id`, `SMTP`, `Email`, `Username`, `Password`, `Port`) VALUES
(1, 'http://mail.inform.gov.my/office/', 'opsbtm@inform.gov.my', '', 'ops123btm', 25);

-- --------------------------------------------------------

--
-- Table structure for table `staf`
--

CREATE TABLE IF NOT EXISTS `staf` (
  `Id` int(12) NOT NULL AUTO_INCREMENT,
  `Nama` varchar(150) DEFAULT NULL,
  `NoMykad` varchar(12) DEFAULT NULL,
  `Jantina` int(1) DEFAULT NULL,
  `TarikhLahir` date DEFAULT NULL,
  `NoTel` int(15) DEFAULT NULL,
  `NoHp` int(15) DEFAULT NULL,
  `Email` varchar(150) DEFAULT NULL,
  `Alamat` varchar(255) DEFAULT NULL,
  `Poskod` int(12) DEFAULT NULL,
  `Gambar` varchar(255) DEFAULT NULL,
  `Facebook` varchar(255) DEFAULT NULL,
  `Twitter` varchar(255) DEFAULT NULL,
  `Pejabat` int(11) DEFAULT NULL,
  `Negeri` int(11) DEFAULT NULL,
  `Cawangan` int(11) DEFAULT NULL,
  `Bahagian` varchar(255) DEFAULT NULL,
  `Jawatan` varchar(200) DEFAULT NULL,
  `NoBilik` varchar(150) DEFAULT NULL,
  `Username` varchar(20) DEFAULT NULL,
  `Password` varchar(20) DEFAULT NULL,
  `TC` datetime DEFAULT NULL,
  `PC` int(11) DEFAULT NULL,
  `TU` datetime DEFAULT NULL,
  `PU` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`),
  UNIQUE KEY `NoMykad` (`NoMykad`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `staf`
--

INSERT INTO `staf` (`Id`, `Nama`, `NoMykad`, `Jantina`, `TarikhLahir`, `NoTel`, `NoHp`, `Email`, `Alamat`, `Poskod`, `Gambar`, `Facebook`, `Twitter`, `Pejabat`, `Negeri`, `Cawangan`, `Bahagian`, `Jawatan`, `NoBilik`, `Username`, `Password`, `TC`, `PC`, `TU`, `PU`) VALUES
(1, 'SHAH IZZAT BIN AZIZ', '900123085029', 1, '1988-12-09', 1234567890, 1234567890, 'zakwanfata@gmail.com', 'NO 5, JALAN INDAH 10,\r\nTAMAN INDAH PERMAI', 72100, NULL, 'FACEBOOK/SHAH.IZZAT', 'TWITTER/SHAH.IZZAT', 2, 4, 2, 'KEWANGAN', 'PENGURUS', 'A309', 'zakwanfata@gmail.com', '900123085029', NULL, NULL, NULL, NULL),
(2, 'KAMAL BIN JAMAL', '993921813818', 1, '1988-12-17', 92889911, 92288811, 'EMAIL@EMAIL.COM', 'ALAMAT', 99889, NULL, 'FACEBOOK', 'TWITTER', 1, NULL, NULL, 'UNIT', 'PENGURUS', '98', 'EMAIL@EMAIL.COM', '993921813818', NULL, NULL, NULL, NULL),
(3, 'RuslanNgah', '123456789012', 1, '2013-12-18', 31234567, 12312346, 'ruslanngah@inform.gov.my', 'JPM', 12345, NULL, 'FACEBOOK', 'TWITTER', 1, NULL, NULL, 'Kewangan', 'Pengurus', 'B18', '123456789012', '123456', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `statusselenggara`
--

CREATE TABLE IF NOT EXISTS `statusselenggara` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Keterangan` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `statusselenggara`
--

INSERT INTO `statusselenggara` (`Id`, `Keterangan`) VALUES
(1, 'Status Selenggara 1'),
(2, 'Status Selenggara 2'),
(3, 'Status Selenggara 3');

-- --------------------------------------------------------

--
-- Table structure for table `syarikat`
--

CREATE TABLE IF NOT EXISTS `syarikat` (
  `Id` int(12) NOT NULL AUTO_INCREMENT,
  `Nama` varchar(150) DEFAULT NULL,
  `Alamat` varchar(255) DEFAULT NULL,
  `NoTel` int(15) DEFAULT NULL,
  `Email` varchar(150) DEFAULT NULL,
  `Contact1_Nama` varchar(150) DEFAULT NULL,
  `Contact1_NoTel` int(15) DEFAULT NULL,
  `Contact1_NoHp` int(15) DEFAULT NULL,
  `Contact1_Email` varchar(150) DEFAULT NULL,
  `Contact2_Nama` varchar(150) DEFAULT NULL,
  `Contact2_NoTel` int(15) DEFAULT NULL,
  `Contact2_NoHp` int(15) DEFAULT NULL,
  `Contact2_Email` varchar(150) DEFAULT NULL,
  `Contact3_Nama` varchar(150) DEFAULT NULL,
  `Contact3_NoTel` int(15) DEFAULT NULL,
  `Contact3_NoHp` int(15) DEFAULT NULL,
  `Contact3_Email` varchar(150) DEFAULT NULL,
  `Username` varchar(20) NOT NULL,
  `Password` varchar(20) NOT NULL,
  `TC` int(11) DEFAULT NULL,
  `PC` int(11) DEFAULT NULL,
  `TU` int(11) DEFAULT NULL,
  `PU` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `syarikat`
--

INSERT INTO `syarikat` (`Id`, `Nama`, `Alamat`, `NoTel`, `Email`, `Contact1_Nama`, `Contact1_NoTel`, `Contact1_NoHp`, `Contact1_Email`, `Contact2_Nama`, `Contact2_NoTel`, `Contact2_NoHp`, `Contact2_Email`, `Contact3_Nama`, `Contact3_NoTel`, `Contact3_NoHp`, `Contact3_Email`, `Username`, `Password`, `TC`, `PC`, `TU`, `PU`) VALUES
(1, 'ALIRAN PERMATA SDN. BHD.', 'LOT 11, JALAN DAMAI,\r\n44102 AMPANG, \r\nSELANGOR', 19993, 'admin@aliranpermata.com', 'SUZILA BINTI SAMAD', 2147483647, 1759991012, 'suzila@aliranpermata.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'aliran', 'asdf1234', 0, 0, 0, 0),
(2, 'PC Soft Sdn Bhd', 'Selangor', 3100000, 'ruslanngah@inform.gov.my', 'Ruslan Ngah', 1200000, 123000000, 'ruslanngah@inform.gov.my', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pcsoft', '123456', NULL, NULL, NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
