-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 13, 2023 at 08:08 AM
-- Server version: 5.7.39
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
-- Table structure for table `Hospital_Notifications`
--

CREATE TABLE `Hospital_Notifications` (
  `Notification_ID` varchar(20) NOT NULL,
  `Notification_Type` int(11) NOT NULL,
  `Notification_State` int(11) NOT NULL,
  `Target_ID` varchar(20) DEFAULT NULL,
  `Notification_Title` varchar(100) NOT NULL,
  `Notification_Message` varchar(100) NOT NULL,
  `Notification_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Valid_Until` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Hospital_Notifications`
--

INSERT INTO `Hospital_Notifications` (`Notification_ID`, `Notification_Type`, `Notification_State`, `Target_ID`, `Notification_Title`, `Notification_Message`, `Notification_Date`, `Valid_Until`) VALUES
('1', 1, 1, 'Hos_01', 'Notification', 'Ube ammt hknn', '2023-05-12 07:48:30', '2023-05-19 07:47:07'),
('2', 1, 1, 'Hos_01', 'Notification 2', 'Ube ammt hknn deparak', '2023-05-12 08:06:18', '2023-05-26 08:05:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Hospital_Notifications`
--
ALTER TABLE `Hospital_Notifications`
  ADD PRIMARY KEY (`Notification_ID`),
  ADD KEY `Target_ID` (`Target_ID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Hospital_Notifications`
--
ALTER TABLE `Hospital_Notifications`
  ADD CONSTRAINT `hospital_notifications_ibfk_1` FOREIGN KEY (`Target_ID`) REFERENCES `Hospitals` (`Hospital_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
