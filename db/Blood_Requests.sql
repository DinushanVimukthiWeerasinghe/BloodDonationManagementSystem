-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Feb 28, 2023 at 05:04 AM
-- Server version: 5.7.39
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bepositive`
--

-- --------------------------------------------------------

--
-- Table structure for table `Blood_Requests`
--

CREATE TABLE `Blood_Requests` (
  `Request_ID` varchar(20) NOT NULL,
  `Requested_By` varchar(20) NOT NULL,
  `BloodGroup` varchar(3) NOT NULL,
  `Requested_At` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Type` int(11) NOT NULL DEFAULT '1',
  `Status` int(11) NOT NULL DEFAULT '1',
  `Quantity` int(11) NOT NULL,
  `Remark` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Blood_Requests`
--

INSERT INTO `Blood_Requests` (`Request_ID`, `Requested_By`, `BloodGroup`, `Requested_At`, `Type`, `Status`, `Quantity`, `Remark`) VALUES
('Req_490', 'Hos_01', 'A+', '2023-02-27 03:41:00', 2, 1, 1, 'Hadissi ikmanata ewapan'),
('Req_5500', 'Hos_02', 'A+', '2023-02-27 08:00:34', 1, 1, 2, 'Le madi tikak ewapan'),
('Req_558', 'Hos_02', 'A+', '2023-02-27 08:00:18', 2, 1, 1, 'mathak wenne hutta'),
('Req_722', 'Hos_02', 'A+', '2023-02-27 08:01:01', 2, 1, 5, 'anam manam wana le thamai onaa'),
('Req_7613', 'Hos_01', 'A+', '2023-02-27 03:41:24', 1, 1, 6, 'Marenna tharam amaru un ne the ekak bila ehema ewapan');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Blood_Requests`
--
ALTER TABLE `Blood_Requests`
  ADD PRIMARY KEY (`Request_ID`),
  ADD KEY `Requested_By` (`Requested_By`),
  ADD KEY `BloodGroup` (`BloodGroup`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Blood_Requests`
--
ALTER TABLE `Blood_Requests`
  ADD CONSTRAINT `blood_requests_ibfk_1` FOREIGN KEY (`Requested_By`) REFERENCES `Hospitals` (`Hospital_ID`),
  ADD CONSTRAINT `blood_requests_ibfk_2` FOREIGN KEY (`BloodGroup`) REFERENCES `BloodGroups` (`BloodGroup_ID`);
COMMIT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
