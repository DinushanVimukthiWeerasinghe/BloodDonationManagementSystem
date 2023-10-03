-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 11, 2022 at 02:07 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bePositive`
--

-- --------------------------------------------------------

--
-- Table structure for table `Accepted_Requests`
--

CREATE TABLE `Accepted_Requests` (
  `Refrence_NO` varchar(10) NOT NULL,
  `Request_Id` varchar(10) NOT NULL,
  `Donor_ID` varchar(10) NOT NULL,
  `Remark` text NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Approved_Campaign`
--

CREATE TABLE `Approved_Campaign` (
  `Campaign_ID` varchar(10) NOT NULL,
  `Approved_By` varchar(10) NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Assigned_Staff`
--

CREATE TABLE `Assigned_Staff` (
  `Refrence_NO` varchar(10) NOT NULL,
  `Officer_ID` varchar(10) NOT NULL,
  `Campaign_ID` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Blood_Bank_Report`
--

CREATE TABLE `Blood_Bank_Report` (
  `Report_Id` varchar(10) NOT NULL,
  `Remark` text NOT NULL,
  `Type` text NOT NULL,
  `Created_BY` varchar(10) NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Blood_Bank_Staff`
--

CREATE TABLE `Blood_Bank_Staff` (
  `Officer_ID` varchar(10) NOT NULL,
  `Branch_ID` varchar(10) NOT NULL,
  `Branch_Name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Blood_Packet`
--

CREATE TABLE `Blood_Packet` (
  `Packet_ID` varchar(10) NOT NULL,
  `Type` text NOT NULL,
  `Effect` text NOT NULL,
  `Remark` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Campaign`
--

CREATE TABLE `Campaign` (
  `Campaign_ID` varchar(10) NOT NULL,
  `Venue` text NOT NULL,
  `Date` date NOT NULL,
  `Created_AT` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Manage_By` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Donations`
--

CREATE TABLE `Donations` (
  `Packet_ID` varchar(10) NOT NULL,
  `Donor_Id` varchar(10) NOT NULL,
  `Officer_ID` varchar(10) NOT NULL,
  `Blood_Volume` varchar(5) NOT NULL,
  `In_Time` time NOT NULL,
  `Out_Time` time NOT NULL,
  `Date` date NOT NULL,
  `Venue` varchar(10) NOT NULL,
  `Effects` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Donation_Request`
--

CREATE TABLE `Donation_Request` (
  `Request_Id` varchar(10) NOT NULL,
  `Special_Remark` text NOT NULL,
  `Message` text NOT NULL,
  `Created_BY` varchar(10) NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Donor`
--

CREATE TABLE `Donor` (
  `Donor_ID` varchar(10) NOT NULL,
  `f_Name` text NOT NULL,
  `l_Name` text NOT NULL,
  `NIC` varchar(12) NOT NULL,
  `e-mail` text NOT NULL,
  `address_L1` text NOT NULL,
  `address_L2` text NOT NULL,
  `address_L3` text NOT NULL,
  `postoal_Code` text NOT NULL,
  `availability` int(1) NOT NULL,
  `usr_Image` blob DEFAULT NULL,
  `Contact_No` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Donor`
--

INSERT INTO `Donor` (`Donor_ID`, `f_Name`, `l_Name`, `NIC`, `e-mail`, `address_L1`, `address_L2`, `address_L3`, `postoal_Code`, `availability`, `usr_Image`, `Contact_No`) VALUES
('123', 'ISURU', 'HESHAN', '200018402787', 'isuru.heshan1@gmail.com', '142/1', 'Embaraluwa North', 'Weliweriya', '11007', 1, '', 775891969);

-- --------------------------------------------------------

--
-- Table structure for table `Donor_Review`
--

CREATE TABLE `Donor_Review` (
  `Review_ID` varchar(10) NOT NULL,
  `Donor_Id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Donor_Review`
--

INSERT INTO `Donor_Review` (`Review_ID`, `Donor_Id`) VALUES
('001', '123'),
('002', '123');

-- --------------------------------------------------------

--
-- Table structure for table `Emergency_Request`
--

CREATE TABLE `Emergency_Request` (
  `Request_Id` varchar(10) NOT NULL,
  `Officer_ID` varchar(10) NOT NULL,
  `Remark` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Financial_Package`
--

CREATE TABLE `Financial_Package` (
  `Package_ID` varchar(10) NOT NULL,
  `Package_Name` text NOT NULL,
  `Amount` int(11) NOT NULL,
  `Remark` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Hospital_Staff`
--

CREATE TABLE `Hospital_Staff` (
  `Officer_ID` varchar(10) NOT NULL,
  `Hospital_ID` varchar(10) NOT NULL,
  `Hospital_Name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Login_History`
--

CREATE TABLE `Login_History` (
  `Login_ID` varchar(10) NOT NULL,
  `Officer_ID` varchar(10) NOT NULL,
  `logged_In` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Logged_Out` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Medical_Officer`
--

CREATE TABLE `Medical_Officer` (
  `Officer_ID` varchar(10) NOT NULL,
  `Name` text NOT NULL,
  `NIC` varchar(12) NOT NULL,
  `Joined_Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Organization`
--

CREATE TABLE `Organization` (
  `Organization_ID` varchar(10) NOT NULL,
  `Organization_Name` text NOT NULL,
  `E_Mail` text NOT NULL,
  `Joined_Date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Telephone_Number` int(10) NOT NULL,
  `Address_Line1` text NOT NULL,
  `Address_Line2` text NOT NULL,
  `City` text NOT NULL,
  `Postal_Code` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Package_Assignments`
--

CREATE TABLE `Package_Assignments` (
  `Campaign_ID` varchar(10) NOT NULL,
  `Package_ID` varchar(10) NOT NULL,
  `Sponsor_ID` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Report`
--

CREATE TABLE `Report` (
  `Report_Id` varchar(10) NOT NULL,
  `Donor_ID` varchar(10) NOT NULL,
  `Weight` float NOT NULL,
  `Blood_Group` text NOT NULL,
  `Created_On` timestamp NOT NULL DEFAULT current_timestamp(),
  `Remark` text NOT NULL,
  `Updated_By` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Review`
--

CREATE TABLE `Review` (
  `Review_ID` varchar(10) NOT NULL,
  `Type` text NOT NULL,
  `Messege` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Review`
--

INSERT INTO `Review` (`Review_ID`, `Type`, `Messege`) VALUES
('001', 'Critical', 'No heart'),
('002', 'Normal', 'Normal condition');

-- --------------------------------------------------------

--
-- Table structure for table `Sponsor`
--

CREATE TABLE `Sponsor` (
  `Sponsor_ID` varchar(10) NOT NULL,
  `Sponsor_Name` text NOT NULL,
  `E_Mail` text NOT NULL,
  `Address` text NOT NULL,
  `Telephone_Number` int(10) NOT NULL,
  `Joined_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Sponsor_Requests`
--

CREATE TABLE `Sponsor_Requests` (
  `Campaign_ID` varchar(10) NOT NULL,
  `Package_ID` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Verified_Donor`
--

CREATE TABLE `Verified_Donor` (
  `Donor_ID` varchar(10) NOT NULL,
  `Officer_ID` varchar(10) NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Accepted_Requests`
--
ALTER TABLE `Accepted_Requests`
  ADD PRIMARY KEY (`Refrence_NO`),
  ADD KEY `Request_NO` (`Request_Id`),
  ADD KEY `Donor_ID` (`Donor_ID`);

--
-- Indexes for table `Approved_Campaign`
--
ALTER TABLE `Approved_Campaign`
  ADD PRIMARY KEY (`Campaign_ID`),
  ADD KEY `Officer_ID` (`Approved_By`);

--
-- Indexes for table `Assigned_Staff`
--
ALTER TABLE `Assigned_Staff`
  ADD PRIMARY KEY (`Refrence_NO`),
  ADD KEY `Officer_ID` (`Officer_ID`),
  ADD KEY `Campaign_ID` (`Campaign_ID`);

--
-- Indexes for table `Blood_Bank_Report`
--
ALTER TABLE `Blood_Bank_Report`
  ADD PRIMARY KEY (`Report_Id`),
  ADD KEY `Officer_ID` (`Created_BY`) USING BTREE;

--
-- Indexes for table `Blood_Bank_Staff`
--
ALTER TABLE `Blood_Bank_Staff`
  ADD PRIMARY KEY (`Officer_ID`);

--
-- Indexes for table `Blood_Packet`
--
ALTER TABLE `Blood_Packet`
  ADD PRIMARY KEY (`Packet_ID`);

--
-- Indexes for table `Campaign`
--
ALTER TABLE `Campaign`
  ADD PRIMARY KEY (`Campaign_ID`),
  ADD KEY `Organization_ID` (`Manage_By`);

--
-- Indexes for table `Donations`
--
ALTER TABLE `Donations`
  ADD PRIMARY KEY (`Packet_ID`),
  ADD KEY `Donor_ID` (`Donor_Id`),
  ADD KEY `Officer_ID` (`Officer_ID`) USING BTREE,
  ADD KEY `Venue` (`Venue`);

--
-- Indexes for table `Donation_Request`
--
ALTER TABLE `Donation_Request`
  ADD PRIMARY KEY (`Request_Id`),
  ADD KEY `Organization_ID` (`Created_BY`);

--
-- Indexes for table `Donor`
--
ALTER TABLE `Donor`
  ADD PRIMARY KEY (`Donor_ID`),
  ADD UNIQUE KEY `NIC` (`NIC`);

--
-- Indexes for table `Donor_Review`
--
ALTER TABLE `Donor_Review`
  ADD PRIMARY KEY (`Review_ID`),
  ADD KEY `Donor_Id` (`Donor_Id`);

--
-- Indexes for table `Emergency_Request`
--
ALTER TABLE `Emergency_Request`
  ADD PRIMARY KEY (`Request_Id`),
  ADD KEY `Officer_ID` (`Officer_ID`);

--
-- Indexes for table `Financial_Package`
--
ALTER TABLE `Financial_Package`
  ADD PRIMARY KEY (`Package_ID`);

--
-- Indexes for table `Hospital_Staff`
--
ALTER TABLE `Hospital_Staff`
  ADD PRIMARY KEY (`Officer_ID`),
  ADD KEY `Hospital_ID` (`Hospital_ID`);

--
-- Indexes for table `Login_History`
--
ALTER TABLE `Login_History`
  ADD PRIMARY KEY (`Login_ID`),
  ADD KEY `Officer_ID` (`Officer_ID`);

--
-- Indexes for table `Medical_Officer`
--
ALTER TABLE `Medical_Officer`
  ADD PRIMARY KEY (`Officer_ID`),
  ADD UNIQUE KEY `NIC` (`NIC`);

--
-- Indexes for table `Organization`
--
ALTER TABLE `Organization`
  ADD PRIMARY KEY (`Organization_ID`);

--
-- Indexes for table `Package_Assignments`
--
ALTER TABLE `Package_Assignments`
  ADD PRIMARY KEY (`Campaign_ID`),
  ADD KEY `Package_ID` (`Package_ID`),
  ADD KEY `Sponsor_ID` (`Sponsor_ID`);

--
-- Indexes for table `Report`
--
ALTER TABLE `Report`
  ADD PRIMARY KEY (`Report_Id`(8)),
  ADD UNIQUE KEY `Donor_ID` (`Donor_ID`),
  ADD KEY `Officer_ID` (`Updated_By`);

--
-- Indexes for table `Review`
--
ALTER TABLE `Review`
  ADD PRIMARY KEY (`Review_ID`);

--
-- Indexes for table `Sponsor`
--
ALTER TABLE `Sponsor`
  ADD PRIMARY KEY (`Sponsor_ID`);

--
-- Indexes for table `Sponsor_Requests`
--
ALTER TABLE `Sponsor_Requests`
  ADD PRIMARY KEY (`Campaign_ID`),
  ADD KEY `Package_ID` (`Package_ID`);

--
-- Indexes for table `Verified_Donor`
--
ALTER TABLE `Verified_Donor`
  ADD PRIMARY KEY (`Donor_ID`),
  ADD KEY `Officer_ID` (`Officer_ID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Accepted_Requests`
--
ALTER TABLE `Accepted_Requests`
  ADD CONSTRAINT `Accepted_Requests_ibfk_1` FOREIGN KEY (`Request_Id`) REFERENCES `Donation_Request` (`Request_Id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `Accepted_Requests_ibfk_2` FOREIGN KEY (`Donor_ID`) REFERENCES `Donor` (`Donor_ID`) ON UPDATE CASCADE;

--
-- Constraints for table `Approved_Campaign`
--
ALTER TABLE `Approved_Campaign`
  ADD CONSTRAINT `Approved_Campaign_ibfk_1` FOREIGN KEY (`Campaign_ID`) REFERENCES `Campaign` (`Campaign_ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `Approved_Campaign_ibfk_2` FOREIGN KEY (`Approved_By`) REFERENCES `Blood_Bank_Staff` (`Officer_ID`) ON UPDATE CASCADE;

--
-- Constraints for table `Assigned_Staff`
--
ALTER TABLE `Assigned_Staff`
  ADD CONSTRAINT `Assigned_Staff_ibfk_1` FOREIGN KEY (`Officer_ID`) REFERENCES `Medical_Officer` (`Officer_ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `Assigned_Staff_ibfk_2` FOREIGN KEY (`Campaign_ID`) REFERENCES `Approved_Campaign` (`Campaign_ID`) ON UPDATE CASCADE;

--
-- Constraints for table `Blood_Bank_Report`
--
ALTER TABLE `Blood_Bank_Report`
  ADD CONSTRAINT `Blood_Bank_Report_ibfk_1` FOREIGN KEY (`Created_BY`) REFERENCES `Blood_Bank_Staff` (`Officer_ID`) ON UPDATE CASCADE;

--
-- Constraints for table `Blood_Bank_Staff`
--
ALTER TABLE `Blood_Bank_Staff`
  ADD CONSTRAINT `Blood_Bank_Staff_ibfk_1` FOREIGN KEY (`Officer_ID`) REFERENCES `Medical_Officer` (`Officer_ID`) ON UPDATE CASCADE;

--
-- Constraints for table `Campaign`
--
ALTER TABLE `Campaign`
  ADD CONSTRAINT `Campaign_ibfk_1` FOREIGN KEY (`Manage_By`) REFERENCES `Organization` (`Organization_ID`) ON UPDATE CASCADE;

--
-- Constraints for table `Donations`
--
ALTER TABLE `Donations`
  ADD CONSTRAINT `Donations_ibfk_1` FOREIGN KEY (`Packet_ID`) REFERENCES `Blood_Packet` (`Packet_ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `Donations_ibfk_2` FOREIGN KEY (`Donor_Id`) REFERENCES `Donor` (`Donor_ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `Donations_ibfk_3` FOREIGN KEY (`Officer_ID`) REFERENCES `Assigned_Staff` (`Officer_ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `Donations_ibfk_4` FOREIGN KEY (`Venue`) REFERENCES `Assigned_Staff` (`Campaign_ID`) ON UPDATE CASCADE;

--
-- Constraints for table `Donation_Request`
--
ALTER TABLE `Donation_Request`
  ADD CONSTRAINT `Donation_Request_ibfk_1` FOREIGN KEY (`Created_BY`) REFERENCES `Organization` (`Organization_ID`) ON UPDATE CASCADE;

--
-- Constraints for table `Donor_Review`
--
ALTER TABLE `Donor_Review`
  ADD CONSTRAINT `Donor_Review_ibfk_1` FOREIGN KEY (`Review_ID`) REFERENCES `Review` (`Review_ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `Donor_Review_ibfk_2` FOREIGN KEY (`Donor_Id`) REFERENCES `Donor` (`Donor_ID`) ON UPDATE CASCADE;

--
-- Constraints for table `Emergency_Request`
--
ALTER TABLE `Emergency_Request`
  ADD CONSTRAINT `Emergency_Request_ibfk_1` FOREIGN KEY (`Officer_ID`) REFERENCES `Hospital_Staff` (`Officer_ID`) ON UPDATE CASCADE;

--
-- Constraints for table `Hospital_Staff`
--
ALTER TABLE `Hospital_Staff`
  ADD CONSTRAINT `Hospital_Staff_ibfk_1` FOREIGN KEY (`Officer_ID`) REFERENCES `Medical_Officer` (`Officer_ID`) ON UPDATE CASCADE;

--
-- Constraints for table `Login_History`
--
ALTER TABLE `Login_History`
  ADD CONSTRAINT `Login_History_ibfk_1` FOREIGN KEY (`Officer_ID`) REFERENCES `Medical_Officer` (`Officer_ID`) ON UPDATE CASCADE;

--
-- Constraints for table `Package_Assignments`
--
ALTER TABLE `Package_Assignments`
  ADD CONSTRAINT `Package_Assignments_ibfk_1` FOREIGN KEY (`Campaign_ID`) REFERENCES `Sponsor_Requests` (`Campaign_ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `Package_Assignments_ibfk_2` FOREIGN KEY (`Package_ID`) REFERENCES `Sponsor_Requests` (`Package_ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `Package_Assignments_ibfk_3` FOREIGN KEY (`Sponsor_ID`) REFERENCES `Sponsor` (`Sponsor_ID`) ON UPDATE CASCADE;

--
-- Constraints for table `Report`
--
ALTER TABLE `Report`
  ADD CONSTRAINT `Report_ibfk_1` FOREIGN KEY (`Donor_ID`) REFERENCES `Donor` (`Donor_ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `Report_ibfk_2` FOREIGN KEY (`Updated_By`) REFERENCES `Medical_Officer` (`Officer_ID`) ON UPDATE CASCADE;

--
-- Constraints for table `Sponsor_Requests`
--
ALTER TABLE `Sponsor_Requests`
  ADD CONSTRAINT `Sponsor_Requests_ibfk_2` FOREIGN KEY (`Package_ID`) REFERENCES `Financial_Package` (`Package_ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `Sponsor_Requests_ibfk_3` FOREIGN KEY (`Campaign_ID`) REFERENCES `Approved_Campaign` (`Campaign_ID`) ON UPDATE CASCADE;

--
-- Constraints for table `Verified_Donor`
--
ALTER TABLE `Verified_Donor`
  ADD CONSTRAINT `Verified_Donor_ibfk_1` FOREIGN KEY (`Donor_ID`) REFERENCES `Donor` (`Donor_ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `Verified_Donor_ibfk_2` FOREIGN KEY (`Officer_ID`) REFERENCES `Medical_Officer` (`Officer_ID`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
