-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2023 at 01:55 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

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
-- Table structure for table `campaign`
--

CREATE TABLE `campaign` (
  `Campaign_ID` varchar(20) NOT NULL,
  `Campaign_Name` varchar(100) NOT NULL,
  `Campaign_Description` varchar(100) NOT NULL,
  `Campaign_Date` date NOT NULL,
  `Venue` varchar(100) NOT NULL,
  `Nearest_City` varchar(100) NOT NULL,
  `Status` int(11) NOT NULL CHECK (`Status` between 1 and 3),
  `Nearest_BloodBank` varchar(20) NOT NULL,
  `Verified` int(11) NOT NULL DEFAULT 0 CHECK (`Verified` between 0 and 2),
  `Verified_By` varchar(20) DEFAULT NULL,
  `Verified_At` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `Assigned_Team` varchar(20) DEFAULT NULL,
  `Remarks` varchar(100) DEFAULT NULL,
  `Created_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `Updated_At` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Organization_ID` varchar(255) NOT NULL,
  `Package_ID` varchar(255) NOT NULL,
  `Expected_Amount` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `campaign`
--

INSERT INTO `campaign` (`Campaign_ID`, `Campaign_Name`, `Campaign_Description`, `Campaign_Date`, `Venue`, `Nearest_City`, `Status`, `Nearest_BloodBank`, `Verified`, `Verified_By`, `Verified_At`, `Assigned_Team`, `Remarks`, `Created_At`, `Updated_At`, `Organization_ID`, `Package_ID`, `Expected_Amount`) VALUES
('Camp_0066', 'Donation', '', '2023-02-28', 'Matara', 'Matara', 2, 'BB_02', 0, 'Mng_01', '2023-03-05 11:03:14', NULL, NULL, '2023-02-25 18:34:11', '2023-03-05 11:03:14', 'Org_01', 'pkg_2', '25000'),
('Camp_640478423b075', 'Sahana', '', '2023-03-05', 'Matara', 'Colombo', 2, 'BB_02', 0, NULL, '2023-03-05 12:41:01', NULL, NULL, '2023-03-06 06:38:50', '2023-03-05 12:41:01', 'Org_01', 'pkg_1', '30000'),
('Camp_640478cb4c96e', 'Namala', '', '2023-03-05', 'Colombo', 'Colombo', 2, 'BB_01', 0, NULL, '2023-03-05 12:47:48', NULL, NULL, '2023-03-05 06:41:07', '2023-03-05 12:47:48', 'Org_01', 'pkg_1', '50000');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `campaign`
--
ALTER TABLE `campaign`
  ADD PRIMARY KEY (`Campaign_ID`),
  ADD KEY `Verified_By` (`Verified_By`),
  ADD KEY `Assigned_Team` (`Assigned_Team`),
  ADD KEY `Nearest_BloodBank` (`Nearest_BloodBank`),
  ADD KEY `campaign_ibfk_4` (`Organization_ID`),
  ADD KEY `campaign_ibfk_5` (`Package_ID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `campaign`
--
ALTER TABLE `campaign`
  ADD CONSTRAINT `campaign_ibfk_1` FOREIGN KEY (`Verified_By`) REFERENCES `managers` (`Manager_ID`),
  ADD CONSTRAINT `campaign_ibfk_2` FOREIGN KEY (`Assigned_Team`) REFERENCES `medical_team` (`Team_ID`),
  ADD CONSTRAINT `campaign_ibfk_3` FOREIGN KEY (`Nearest_BloodBank`) REFERENCES `bloodbanks` (`BloodBank_ID`),
  ADD CONSTRAINT `campaign_ibfk_4` FOREIGN KEY (`Organization_ID`) REFERENCES `organizations` (`Organization_ID`),
  ADD CONSTRAINT `campaign_ibfk_5` FOREIGN KEY (`Package_ID`) REFERENCES `sponsorship_packages` (`Package_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
