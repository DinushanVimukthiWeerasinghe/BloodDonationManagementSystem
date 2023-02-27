-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Feb 27, 2023 at 08:55 AM
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
  `Remark` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Blood_Requests`
--

INSERT INTO `Blood_Requests` (`Request_ID`, `Requested_By`, `BloodGroup`, `Requested_At`, `Type`, `Status`, `Quantity`, `Remark`) VALUES
('Req_01', 'Hos_01', 'A+', '2023-02-23 05:09:35', 1, 1, 2, 'This is a remark'),
('Req_02', 'Hos_01', 'O-', '2023-02-23 05:13:32', 1, 1, 2, NULL),
('Req_03', 'Hos_01', 'O+', '2023-02-23 05:14:46', 2, 2, 1, 'This is a remark'),
('Req_04', 'Hos_01', 'AB+', '2023-02-23 05:15:14', 2, 3, 4, NULL),
('Req_4787', 'Hos_01', 'A+', '2023-02-27 03:18:51', 2, 1, 7, 'dfg'),
('Req_8218', 'Hos_01', 'AB-', '2023-02-27 03:24:06', 2, 1, 1, 'Uberta le denne moda Hutta');

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
