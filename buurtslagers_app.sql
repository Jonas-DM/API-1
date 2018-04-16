-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2018 at 11:39 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `buurtslagers_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `api`
--

CREATE TABLE `api` (
  `api_key` varchar(255) NOT NULL,
  `valid` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `api`
--

INSERT INTO `api` (`api_key`, `valid`) VALUES
('8e6c7b47e63f664c7c66d84fcf0588202d37c3939e9fd65bf7ad6d9df52d4c188bd9c745', 1);

-- --------------------------------------------------------

--
-- Table structure for table `broodje`
--

CREATE TABLE `broodje` (
  `id` int(11) NOT NULL,
  `Naam` tinytext NOT NULL,
  `Prijs` varchar(50) NOT NULL,
  `Omschrijving` varchar(100) NOT NULL,
  `Aanpassing` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `broodje`
--

INSERT INTO `broodje` (`id`, `Naam`, `Prijs`, `Omschrijving`, `Aanpassing`) VALUES
(5, 'ham', '', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gemeente`
--

CREATE TABLE `gemeente` (
  `GemeenteID` int(11) NOT NULL,
  `Gemeente` tinytext NOT NULL,
  `Postcode` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `klant`
--

CREATE TABLE `klant` (
  `KLantID` int(11) NOT NULL,
  `inlognaam` tinytext NOT NULL,
  `Naam` tinytext NOT NULL,
  `Voornaam` tinytext NOT NULL,
  `Adres` tinytext NOT NULL,
  `GSMnummer` tinytext NOT NULL,
  `Wachtwoord` tinytext NOT NULL,
  `GemeenteID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `openingsdagen`
--

CREATE TABLE `openingsdagen` (
  `OpenDagenID` int(11) NOT NULL,
  `OpeningsDagen` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `openingsuur`
--

CREATE TABLE `openingsuur` (
  `OpenUurID` int(11) NOT NULL,
  `OpeningsUur` datetime NOT NULL,
  `SluitUur` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `OrderID` int(11) NOT NULL,
  `Datum` datetime NOT NULL,
  `AfhaalTijdstip` datetime NOT NULL,
  `verwerkt` char(1) NOT NULL,
  `BroodjesID` int(11) NOT NULL,
  `KLantID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `api`
--
ALTER TABLE `api`
  ADD UNIQUE KEY `key` (`api_key`);

--
-- Indexes for table `broodje`
--
ALTER TABLE `broodje`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gemeente`
--
ALTER TABLE `gemeente`
  ADD PRIMARY KEY (`GemeenteID`);

--
-- Indexes for table `klant`
--
ALTER TABLE `klant`
  ADD PRIMARY KEY (`KLantID`),
  ADD KEY `GemeenteID` (`GemeenteID`);

--
-- Indexes for table `openingsdagen`
--
ALTER TABLE `openingsdagen`
  ADD PRIMARY KEY (`OpenDagenID`);

--
-- Indexes for table `openingsuur`
--
ALTER TABLE `openingsuur`
  ADD PRIMARY KEY (`OpenUurID`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `BroodjesID` (`BroodjesID`),
  ADD KEY `KLantID` (`KLantID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `broodje`
--
ALTER TABLE `broodje`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `gemeente`
--
ALTER TABLE `gemeente`
  MODIFY `GemeenteID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `klant`
--
ALTER TABLE `klant`
  MODIFY `KLantID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `openingsdagen`
--
ALTER TABLE `openingsdagen`
  MODIFY `OpenDagenID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `openingsuur`
--
ALTER TABLE `openingsuur`
  MODIFY `OpenUurID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `klant`
--
ALTER TABLE `klant`
  ADD CONSTRAINT `klant_ibfk_1` FOREIGN KEY (`GemeenteID`) REFERENCES `gemeente` (`GemeenteID`);

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`BroodjesID`) REFERENCES `broodje` (`id`),
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`KLantID`) REFERENCES `klant` (`KLantID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
