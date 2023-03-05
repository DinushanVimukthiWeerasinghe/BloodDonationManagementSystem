-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2023 at 02:10 PM
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
-- Table structure for table `accepted_donations`
--

CREATE TABLE `accepted_donations` (
  `Donation_ID` varchar(20) NOT NULL,
  `Donor_ID` varchar(20) NOT NULL,
  `Packet_ID` varchar(20) NOT NULL,
  `Donated_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `Retrieved_By` varchar(20) NOT NULL,
  `In_Time` timestamp NOT NULL DEFAULT current_timestamp(),
  `Out_Time` timestamp NOT NULL DEFAULT current_timestamp(),
  `Verified_By` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `additional_sponsorship_requests`
--

CREATE TABLE `additional_sponsorship_requests` (
  `Request_ID` varchar(255) NOT NULL,
  `Account_Number` varchar(255) NOT NULL,
  `Bank_Name` varchar(255) NOT NULL,
  `Branch_Name` varchar(255) NOT NULL,
  `Account_Name` varchar(255) NOT NULL,
  `Status` int(11) NOT NULL,
  `Amount` varchar(255) NOT NULL,
  `Campaign_ID` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `additional_sponsorship_requests`
--

INSERT INTO `additional_sponsorship_requests` (`Request_ID`, `Account_Number`, `Bank_Name`, `Branch_Name`, `Account_Name`, `Status`, `Amount`, `Campaign_ID`) VALUES
('Request_640402b8b2736', '8006550284', 'Peoples Bank', 'Beliatta', 'YES', 1, '25000', 'Camp_0066');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `Admin_ID` varchar(20) NOT NULL,
  `UserName` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Profile_Image` varchar(100) NOT NULL DEFAULT '/public/upload/profile/adminDefault.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`Admin_ID`, `UserName`, `Email`, `Profile_Image`) VALUES
('Adm_01', 'Admin', 'admin@test.com', '/public/upload/profile/adminDefault.png');

-- --------------------------------------------------------

--
-- Table structure for table `admin_notifications`
--

CREATE TABLE `admin_notifications` (
  `Notification_ID` varchar(20) NOT NULL,
  `Notification_Type` int(11) NOT NULL,
  `Notification_State` int(11) NOT NULL,
  `Target_ID` varchar(20) DEFAULT NULL,
  `Notification_Title` varchar(100) NOT NULL,
  `Notification_Message` varchar(100) NOT NULL,
  `Notification_Date` timestamp NOT NULL DEFAULT current_timestamp(),
  `Valid_Until` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `approved_campaigns`
--

CREATE TABLE `approved_campaigns` (
  `Campaign_ID` varchar(20) NOT NULL,
  `Bank_ID` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance_accepted_requests`
--

CREATE TABLE `attendance_accepted_requests` (
  `Request_ID` varchar(20) NOT NULL,
  `Donor_ID` varchar(20) NOT NULL,
  `Accepted_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `Campaign_ID` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `attendance_accepted_requests`
--

INSERT INTO `attendance_accepted_requests` (`Request_ID`, `Donor_ID`, `Accepted_At`, `Campaign_ID`) VALUES
('Req_001', 'Dnr_01', '2023-02-25 18:36:31', 'Camp_0066');

-- --------------------------------------------------------

--
-- Table structure for table `authentication_code`
--

CREATE TABLE `authentication_code` (
  `Code_ID` varchar(20) NOT NULL,
  `Code` varchar(20) NOT NULL,
  `Authentication_Method` int(11) NOT NULL,
  `Attempts` int(11) NOT NULL DEFAULT 0 CHECK (`Attempts` between 0 and 4),
  `Created_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `Updated_At` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blocked_users`
--

CREATE TABLE `blocked_users` (
  `UID` varchar(20) NOT NULL,
  `Blocked_At` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `Blog_ID` varchar(20) NOT NULL,
  `Blog_Title` varchar(100) NOT NULL,
  `Blog_Content` text NOT NULL,
  `Blog_Date` date NOT NULL,
  `Blog_Status` int(11) NOT NULL,
  `Blog_Image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bloodbanks`
--

CREATE TABLE `bloodbanks` (
  `BloodBank_ID` varchar(20) NOT NULL,
  `BankName` varchar(100) NOT NULL,
  `Address1` varchar(100) NOT NULL,
  `Address2` varchar(100) NOT NULL,
  `City` varchar(100) NOT NULL,
  `Telephone_No` varchar(100) DEFAULT NULL,
  `No_Of_Doctors` int(11) NOT NULL DEFAULT 0,
  `No_Of_Nurses` int(11) NOT NULL DEFAULT 0,
  `No_Of_Beds` int(11) NOT NULL DEFAULT 0,
  `No_Of_Storages` int(11) NOT NULL DEFAULT 0,
  `Type` int(11) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `bloodbanks`
--

INSERT INTO `bloodbanks` (`BloodBank_ID`, `BankName`, `Address1`, `Address2`, `City`, `Telephone_No`, `No_Of_Doctors`, `No_Of_Nurses`, `No_Of_Beds`, `No_Of_Storages`, `Type`) VALUES
('BB_01', 'Main Blood Bank', 'No 01, Main Street', 'Colombo 01', 'Colombo', '0111234567', 0, 0, 0, 0, 1),
('BB_02', 'Negombo Blood Bank', 'No 02, Main Street', 'Colombo 02', 'Negombo', '0111234577', 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bloodgroups`
--

CREATE TABLE `bloodgroups` (
  `BloodGroup_ID` varchar(20) NOT NULL,
  `BloodGroup_Name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `bloodgroups`
--

INSERT INTO `bloodgroups` (`BloodGroup_ID`, `BloodGroup_Name`) VALUES
('A+', 'A+'),
('A-', 'A-'),
('AB+', 'AB+'),
('AB-', 'AB-'),
('B+', 'B+'),
('B-', 'B-'),
('O+', 'O+'),
('O-', 'O-');

-- --------------------------------------------------------

--
-- Table structure for table `blood_packets`
--

CREATE TABLE `blood_packets` (
  `Packet_ID` varchar(20) NOT NULL,
  `Packed_By` varchar(20) NOT NULL,
  `BloodGroup` varchar(3) NOT NULL,
  `Status` varchar(50) NOT NULL,
  `Certified_By` varchar(20) NOT NULL,
  `Stored_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blood_requests`
--

CREATE TABLE `blood_requests` (
  `Request_ID` varchar(20) NOT NULL,
  `Requested_By` varchar(20) NOT NULL,
  `BloodGroup` varchar(3) NOT NULL,
  `Requested_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `Type` int(11) NOT NULL DEFAULT 1,
  `Status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `campaigns_sponsors`
--

CREATE TABLE `campaigns_sponsors` (
  `Campaign_ID` varchar(20) NOT NULL,
  `Sponsor_ID` varchar(20) NOT NULL,
  `Package_ID` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `campaigns_sponsors`
--

INSERT INTO `campaigns_sponsors` (`Campaign_ID`, `Sponsor_ID`, `Package_ID`) VALUES
('Camp_0066', 'Spn_01', 'pkg_1');

-- --------------------------------------------------------

--
-- Table structure for table `campaign_request`
--

CREATE TABLE `campaign_request` (
  `Campaign_ID` varchar(20) NOT NULL,
  `Organization_ID` varchar(20) NOT NULL,
  `BloodBank_ID` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `donation_campaigns`
--

CREATE TABLE `donation_campaigns` (
  `Campaign_ID` varchar(20) NOT NULL,
  `Organization_ID` varchar(20) NOT NULL,
  `Campaign_Name` varchar(100) NOT NULL,
  `Campaign_Date` date NOT NULL,
  `Nearest_Blood_Bank` varchar(20) NOT NULL,
  `Venue` varchar(100) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `donors`
--

CREATE TABLE `donors` (
  `Donor_ID` varchar(20) NOT NULL,
  `First_Name` varchar(100) NOT NULL,
  `Last_Name` varchar(100) NOT NULL,
  `Address1` varchar(100) NOT NULL,
  `Address2` varchar(100) NOT NULL,
  `City` varchar(100) NOT NULL,
  `Nearest_Bank` varchar(20) NOT NULL,
  `Contact_No` varchar(12) NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Nationality` varchar(100) NOT NULL DEFAULT 'SINHALA',
  `NIC` varchar(12) DEFAULT NULL,
  `Gender` varchar(1) NOT NULL CHECK (`Gender` in ('F','M')),
  `Status` varchar(50) NOT NULL,
  `Donation_Availability` int(11) NOT NULL DEFAULT 0,
  `Verified` int(11) NOT NULL DEFAULT 0,
  `Verified_At` timestamp NULL DEFAULT NULL,
  `Verified_By` varchar(20) DEFAULT NULL,
  `Verification_Remarks` varchar(100) DEFAULT NULL,
  `BloodPacket_ID` varchar(20) DEFAULT NULL,
  `Created_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `Updated_At` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Profile_Image` varchar(100) NOT NULL DEFAULT '/public/upload/profile/donorDefault.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `donors`
--

INSERT INTO `donors` (`Donor_ID`, `First_Name`, `Last_Name`, `Address1`, `Address2`, `City`, `Nearest_Bank`, `Contact_No`, `Email`, `Nationality`, `NIC`, `Gender`, `Status`, `Donation_Availability`, `Verified`, `Verified_At`, `Verified_By`, `Verification_Remarks`, `BloodPacket_ID`, `Created_At`, `Updated_At`, `Profile_Image`) VALUES
('Dnr_01', 'Donor', 'Donor', 'Address1', 'Address2', 'Colombo', 'BB_01', '0771234567', 'donor@test.com', 'SINHALA', '200017800595', 'F', '0', 0, 0, NULL, NULL, NULL, NULL, '2023-02-25 17:32:53', '2023-02-25 17:32:53', '/public/upload/profile/donorDefault.png');

-- --------------------------------------------------------

--
-- Table structure for table `donor_notifications`
--

CREATE TABLE `donor_notifications` (
  `Notification_ID` varchar(20) NOT NULL,
  `Notification_Type` int(11) NOT NULL,
  `Notification_State` int(11) NOT NULL,
  `Target_ID` varchar(20) DEFAULT NULL,
  `Target_Group` varchar(20) DEFAULT NULL,
  `Notification_Title` varchar(100) NOT NULL,
  `Notification_Message` varchar(100) NOT NULL,
  `Notification_Date` timestamp NOT NULL DEFAULT current_timestamp(),
  `Valid_Until` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `donor_reviews`
--

CREATE TABLE `donor_reviews` (
  `Review_ID` varchar(20) NOT NULL,
  `Donor_ID` varchar(20) NOT NULL,
  `Campaign_ID` varchar(20) NOT NULL,
  `Reviewed_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `Remarks` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hospitals`
--

CREATE TABLE `hospitals` (
  `Hospital_ID` varchar(20) NOT NULL,
  `Hospital_Name` varchar(100) NOT NULL,
  `Address1` varchar(100) NOT NULL,
  `Address2` varchar(100) NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `City` varchar(100) NOT NULL,
  `Contact_No` varchar(100) DEFAULT NULL,
  `Type` int(11) NOT NULL DEFAULT 1,
  `Profile_Image` varchar(100) NOT NULL DEFAULT '/public/upload/profile/hospitalDefault.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `hospitals`
--

INSERT INTO `hospitals` (`Hospital_ID`, `Hospital_Name`, `Address1`, `Address2`, `Email`, `City`, `Contact_No`, `Type`, `Profile_Image`) VALUES
('Hos_01', 'Hospital', 'Address1', 'Address2', 'hospital@test.com', 'Colombo', '0111234567', 1, '/public/upload/profile/hospitalDefault.png');

-- --------------------------------------------------------

--
-- Table structure for table `inform_donors`
--

CREATE TABLE `inform_donors` (
  `Message_ID` varchar(255) NOT NULL,
  `Message` varchar(255) NOT NULL,
  `Type` int(11) NOT NULL,
  `Status` int(11) NOT NULL,
  `Date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Campaign_ID` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `inform_donors`
--

INSERT INTO `inform_donors` (`Message_ID`, `Message`, `Type`, `Status`, `Date`, `Campaign_ID`) VALUES
('Message_63fa586b6580c', 'Dear sir,&#13;&#10;welcome.', 1, 1, '2023-03-04 07:58:33', 'Camp_0066');

-- --------------------------------------------------------

--
-- Table structure for table `logging_history`
--

CREATE TABLE `logging_history` (
  `Session_ID` varchar(20) NOT NULL,
  `User_ID` varchar(20) NOT NULL,
  `Session_Start` timestamp NOT NULL DEFAULT current_timestamp(),
  `Session_End` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `Session_End_Type` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `logging_history`
--

INSERT INTO `logging_history` (`Session_ID`, `User_ID`, `Session_Start`, `Session_End`, `Session_End_Type`) VALUES
('SSI_63fa4680be05a', 'Org_01', '2023-02-25 13:03:52', '2023-02-25 14:55:34', 1),
('SSI_6402d2cf0fe2a', 'Org_01', '2023-03-04 00:40:39', NULL, 0),
('SSI_6402f2751679c', 'Org_01', '2023-03-04 02:55:41', '2023-03-04 03:23:25', 1),
('SSI_6402f8f801e9f', 'Org_01', '2023-03-04 03:23:28', NULL, 0),
('SSI_6402f8f82b733', 'Org_01', '2023-03-04 03:23:28', '2023-03-04 04:30:45', 1),
('SSI_6403fc9f014f6', 'Org_01', '2023-03-04 21:51:19', '2023-03-04 22:28:14', 1),
('SSI_6404055eaf85c', 'Spn_01', '2023-03-04 22:28:38', '2023-03-05 00:26:32', 1),
('SSI_6404211a4ed5e', 'Org_01', '2023-03-05 00:26:58', NULL, 0),
('SSI_6404739bbbbbb', 'Org_01', '2023-03-05 06:18:59', '2023-03-05 07:51:53', 1),
('SSI_640489890122c', 'Spn_01', '2023-03-05 07:52:33', '2023-03-05 08:17:01', 1),
('SSI_64048f490f6bd', 'Org_01', '2023-03-05 08:17:05', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `managers`
--

CREATE TABLE `managers` (
  `Manager_ID` varchar(20) NOT NULL,
  `First_Name` varchar(100) NOT NULL,
  `Last_Name` varchar(100) NOT NULL,
  `Address1` varchar(100) NOT NULL,
  `Address2` varchar(100) NOT NULL,
  `City` varchar(100) NOT NULL,
  `Contact_No` varchar(12) NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Status` int(11) NOT NULL DEFAULT 0,
  `Joined_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `BloodBank_ID` varchar(20) NOT NULL,
  `Profile_Image` varchar(100) NOT NULL DEFAULT '/public/upload/profile/managerDefault.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `managers`
--

INSERT INTO `managers` (`Manager_ID`, `First_Name`, `Last_Name`, `Address1`, `Address2`, `City`, `Contact_No`, `Email`, `Status`, `Joined_At`, `BloodBank_ID`, `Profile_Image`) VALUES
('Mng_01', 'Manager', 'Manager', 'Address1', 'Address2', 'Colombo', '0771234567', 'manager@test.com', 0, '2023-02-25 17:32:53', 'BB_01', '/public/upload/profile/managerDefault.png');

-- --------------------------------------------------------

--
-- Table structure for table `manager_notifications`
--

CREATE TABLE `manager_notifications` (
  `Notification_ID` varchar(20) NOT NULL,
  `Notification_Type` int(11) NOT NULL,
  `Notification_State` int(11) NOT NULL,
  `Target_ID` varchar(20) DEFAULT NULL,
  `Notification_Title` varchar(100) NOT NULL,
  `Notification_Message` varchar(100) NOT NULL,
  `Notification_Date` timestamp NOT NULL DEFAULT current_timestamp(),
  `Valid_Until` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medicalofficers`
--

CREATE TABLE `medicalofficers` (
  `Officer_ID` varchar(20) NOT NULL,
  `First_Name` varchar(100) NOT NULL,
  `Last_Name` varchar(100) NOT NULL,
  `Address1` varchar(100) NOT NULL,
  `Address2` varchar(100) NOT NULL,
  `Contact_No` varchar(12) NOT NULL,
  `City` varchar(100) NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Gender` varchar(10) NOT NULL,
  `Nationality` varchar(100) NOT NULL,
  `NIC` varchar(12) DEFAULT NULL,
  `Position` varchar(20) DEFAULT 'Nurse',
  `Registration_Number` varchar(20) DEFAULT NULL,
  `Registration_Date` timestamp NOT NULL DEFAULT current_timestamp(),
  `Status` int(11) NOT NULL DEFAULT 0,
  `Joined_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `Branch_ID` varchar(20) NOT NULL,
  `Profile_Image` varchar(100) NOT NULL DEFAULT '/public/upload/profile/medicalOfficerDefault.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `medicalofficers`
--

INSERT INTO `medicalofficers` (`Officer_ID`, `First_Name`, `Last_Name`, `Address1`, `Address2`, `Contact_No`, `City`, `Email`, `Gender`, `Nationality`, `NIC`, `Position`, `Registration_Number`, `Registration_Date`, `Status`, `Joined_At`, `Branch_ID`, `Profile_Image`) VALUES
('Mof_01', 'Medical', 'Officer', 'Address1', 'Address2', '0771234567', 'Colombo', 'mofficer@test.com', 'M', 'Sri Lankan', '123456789104', 'Doctor', NULL, '2023-02-25 17:32:53', 0, '2023-02-25 17:32:53', 'BB_01', '/public/upload/profile/medicalOfficerDefault.png');

-- --------------------------------------------------------

--
-- Table structure for table `medical_officer_notifications`
--

CREATE TABLE `medical_officer_notifications` (
  `Notification_ID` varchar(20) NOT NULL,
  `Notification_Type` int(11) NOT NULL,
  `Notification_State` int(11) NOT NULL,
  `Target_ID` varchar(20) DEFAULT NULL,
  `Notification_Title` varchar(100) NOT NULL,
  `Notification_Message` varchar(100) NOT NULL,
  `Notification_Date` timestamp NOT NULL DEFAULT current_timestamp(),
  `Valid_Until` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medical_team`
--

CREATE TABLE `medical_team` (
  `Team_ID` varchar(20) NOT NULL,
  `Campaign_ID` varchar(20) NOT NULL,
  `Team_Leader_ID` varchar(20) NOT NULL,
  `Assigned_By` varchar(20) NOT NULL,
  `Assigned_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `monthly_reports`
--

CREATE TABLE `monthly_reports` (
  `Report_ID` varchar(20) NOT NULL,
  `Report_Month` varchar(20) NOT NULL,
  `Report_Year` varchar(20) NOT NULL,
  `Report_File` varchar(100) NOT NULL,
  `Generated_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `Generated_By` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `Organization_ID` varchar(20) NOT NULL,
  `Organization_Name` varchar(100) NOT NULL,
  `Address1` varchar(100) NOT NULL,
  `Address2` varchar(100) NOT NULL,
  `Organization_Email` varchar(100) DEFAULT NULL,
  `Contact_No` varchar(100) NOT NULL,
  `City` varchar(100) NOT NULL,
  `Status` varchar(50) NOT NULL,
  `Profile_Image` varchar(100) NOT NULL DEFAULT '/public/upload/organizationDefault.png',
  `Created_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `Updated_At` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`Organization_ID`, `Organization_Name`, `Address1`, `Address2`, `Organization_Email`, `Contact_No`, `City`, `Status`, `Profile_Image`, `Created_At`, `Updated_At`) VALUES
('Org_01', 'Organization', 'Address1', 'Address2', 'organization@test.com', '0777123123', 'Colombo', '0', '/public/upload/organizationDefault.png', '2023-02-25 17:32:53', '2023-02-25 17:32:53');

-- --------------------------------------------------------

--
-- Table structure for table `organization_members`
--

CREATE TABLE `organization_members` (
  `Organization_ID` varchar(20) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Contact_No` varchar(100) DEFAULT NULL,
  `NIC` varchar(100) NOT NULL,
  `Position` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `organization_members`
--

INSERT INTO `organization_members` (`Organization_ID`, `Name`, `Contact_No`, `NIC`, `Position`) VALUES
('Org_01', 'Member', '0771234567', '123456789V', 'Secretary'),
('Org_01', 'Member2', '0772345671', '234567891V', 'President'),
('Org_01', 'Member3', '0773456712', '345678912V', 'Treasurer');

-- --------------------------------------------------------

--
-- Table structure for table `organization_notifications`
--

CREATE TABLE `organization_notifications` (
  `Notification_ID` varchar(20) NOT NULL,
  `Notification_Type` int(11) NOT NULL,
  `Notification_State` int(11) NOT NULL,
  `Target_ID` varchar(20) DEFAULT NULL,
  `Notification_Title` varchar(100) NOT NULL,
  `Notification_Message` varchar(100) NOT NULL,
  `Notification_Date` timestamp NOT NULL DEFAULT current_timestamp(),
  `Valid_Until` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `otp_code`
--

CREATE TABLE `otp_code` (
  `UserID` varchar(20) NOT NULL,
  `Code` varchar(6) NOT NULL,
  `Type` int(11) NOT NULL DEFAULT 0,
  `Target` varchar(100) NOT NULL,
  `Attempts` int(11) NOT NULL DEFAULT 0,
  `Total_Attempts` int(11) NOT NULL DEFAULT 0,
  `Status` int(11) NOT NULL DEFAULT 0,
  `Expired_At` timestamp NULL DEFAULT NULL,
  `Verified_At` timestamp NULL DEFAULT NULL,
  `Created_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `Updated_At` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `otp_code_audit`
--

CREATE TABLE `otp_code_audit` (
  `UserID` varchar(20) NOT NULL,
  `Code` varchar(6) NOT NULL,
  `Target` varchar(100) NOT NULL,
  `Total_Attempts` int(11) NOT NULL DEFAULT 0,
  `Verified_At` date DEFAULT NULL,
  `ReGenerated_At` timestamp NULL DEFAULT NULL,
  `No_Of_Regeneration` int(11) NOT NULL DEFAULT 0 CHECK (`No_Of_Regeneration` between 0 and 10),
  `Activity` int(11) DEFAULT 0,
  `Suspicious` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset`
--

CREATE TABLE `password_reset` (
  `UID` varchar(20) NOT NULL,
  `Token` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Created_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `Status` int(11) NOT NULL DEFAULT 0,
  `Device_IP` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_audit`
--

CREATE TABLE `password_reset_audit` (
  `UID` varchar(20) NOT NULL,
  `Token` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Created_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `Reset_At` timestamp NULL DEFAULT NULL,
  `Device_IP` varchar(100) NOT NULL,
  `Status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rejected_campaigns`
--

CREATE TABLE `rejected_campaigns` (
  `Campaign_ID` varchar(20) NOT NULL,
  `Rejected_By` varchar(20) NOT NULL,
  `Rejected_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `Remarks` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rejected_donations`
--

CREATE TABLE `rejected_donations` (
  `Donation_ID` varchar(20) NOT NULL,
  `Donor_ID` varchar(20) NOT NULL,
  `Packet_ID` varchar(20) NOT NULL,
  `Donated_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `Rejected_By` varchar(20) NOT NULL,
  `Rejected_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `Remarks` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sponsors`
--

CREATE TABLE `sponsors` (
  `Sponsor_ID` varchar(20) NOT NULL,
  `Sponsor_Name` varchar(100) NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Address1` varchar(100) NOT NULL,
  `Address2` varchar(100) NOT NULL,
  `City` varchar(100) NOT NULL,
  `Status` varchar(50) NOT NULL,
  `Contact_No` varchar(100) DEFAULT NULL,
  `Created_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `Updated_At` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Profile_Image` varchar(100) NOT NULL DEFAULT '/public/upload/sponsorDefault.png',
  `Package_ID` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `sponsors`
--

INSERT INTO `sponsors` (`Sponsor_ID`, `Sponsor_Name`, `Email`, `Address1`, `Address2`, `City`, `Status`, `Contact_No`, `Created_At`, `Updated_At`, `Profile_Image`, `Package_ID`) VALUES
('Spn_01', 'Sponsor', 'sponsor@test.com', 'Address1', 'Address2', 'Colombo', '0', NULL, '2023-02-25 17:32:53', '2023-03-05 12:26:13', '/public/upload/sponsorDefault.png', 'pkg_3'),
('Spn_02', 'Sponsor 2', 'sponsor2@test.com', '', '', 'Matara', '', NULL, '2023-02-25 18:42:21', '2023-03-05 03:23:43', '/public/upload/sponsorDefault.png', 'pkg_1');

-- --------------------------------------------------------

--
-- Table structure for table `sponsorship_packages`
--

CREATE TABLE `sponsorship_packages` (
  `Package_ID` varchar(20) NOT NULL,
  `Package_Name` varchar(100) NOT NULL,
  `Package_Description` varchar(100) NOT NULL,
  `Package_Price` varchar(100) NOT NULL,
  `Created_By` varchar(20) NOT NULL,
  `Updated_By` varchar(20) DEFAULT NULL,
  `Created_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `Updated_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `sponsorship_packages`
--

INSERT INTO `sponsorship_packages` (`Package_ID`, `Package_Name`, `Package_Description`, `Package_Price`, `Created_By`, `Updated_By`, `Created_At`, `Updated_At`) VALUES
('pkg_1', 'Silver', '', '1500', 'Mng_01', 'Mng_01', '2023-02-25 18:25:24', '2023-02-25 18:25:24'),
('pkg_2', 'Platinum', '', '2000', 'Mng_01', 'Mng_01', '2023-02-25 18:26:14', '2023-02-25 18:26:14'),
('pkg_3', 'Gold', '', '2500', 'Mng_01', 'Mng_01', '2023-02-25 18:26:49', '2023-02-25 18:26:49');

-- --------------------------------------------------------

--
-- Table structure for table `sponsor_notifications`
--

CREATE TABLE `sponsor_notifications` (
  `Notification_ID` varchar(20) NOT NULL,
  `Notification_Type` int(11) NOT NULL,
  `Notification_State` int(11) NOT NULL,
  `Target_ID` varchar(20) DEFAULT NULL,
  `Notification_Title` varchar(100) NOT NULL,
  `Notification_Message` varchar(100) NOT NULL,
  `Notification_Date` timestamp NOT NULL DEFAULT current_timestamp(),
  `Valid_Until` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE `team_members` (
  `Team_ID` varchar(20) NOT NULL,
  `Member_ID` varchar(20) NOT NULL,
  `Position` varchar(100) NOT NULL DEFAULT 'Support Staff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UID` varchar(20) NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Password` varchar(100) NOT NULL,
  `Account_Status` int(11) NOT NULL DEFAULT 0,
  `Role` varchar(100) NOT NULL DEFAULT 'donor',
  `Created_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `Updated_At` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Security_Level` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UID`, `Email`, `Password`, `Account_Status`, `Role`, `Created_At`, `Updated_At`, `Security_Level`) VALUES
('Adm_01', 'admin@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Admin', '2023-02-25 17:32:52', '2023-02-25 17:32:52', 0),
('Dnr_01', 'donor@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Donor', '2023-02-25 17:32:52', '2023-02-25 17:32:52', 0),
('Hos_01', 'hospital@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital', '2023-02-25 17:32:53', '2023-02-25 17:32:53', 0),
('Mng_01', 'manager@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Manager', '2023-02-25 17:32:52', '2023-02-25 17:32:52', 0),
('Mof_01', 'mofficer@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'MedicalOfficer', '2023-02-25 17:32:52', '2023-02-25 17:32:52', 0),
('Org_01', 'org@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Organization', '2023-02-25 17:32:52', '2023-02-25 17:32:52', 0),
('Spn_01', 'sponsor@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor', '2023-02-25 17:32:53', '2023-02-25 17:32:53', 0),
('Spn_02', 'sponsor2@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'sponsor', '2023-02-25 18:40:52', '2023-02-25 18:40:52', 0);

-- --------------------------------------------------------

--
-- Table structure for table `yearly_reports`
--

CREATE TABLE `yearly_reports` (
  `Report_ID` varchar(20) NOT NULL,
  `Report_Year` varchar(20) NOT NULL,
  `Report_File` varchar(100) NOT NULL,
  `Generated_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `Generated_By` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accepted_donations`
--
ALTER TABLE `accepted_donations`
  ADD PRIMARY KEY (`Donation_ID`),
  ADD KEY `Donor_ID` (`Donor_ID`),
  ADD KEY `Packet_ID` (`Packet_ID`),
  ADD KEY `Retrieved_By` (`Retrieved_By`),
  ADD KEY `Verified_By` (`Verified_By`);

--
-- Indexes for table `additional_sponsorship_requests`
--
ALTER TABLE `additional_sponsorship_requests`
  ADD PRIMARY KEY (`Request_ID`),
  ADD KEY `additional_sponsorship_request_ibfk_1` (`Campaign_ID`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`Admin_ID`);

--
-- Indexes for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD PRIMARY KEY (`Notification_ID`),
  ADD KEY `Target_ID` (`Target_ID`);

--
-- Indexes for table `approved_campaigns`
--
ALTER TABLE `approved_campaigns`
  ADD PRIMARY KEY (`Campaign_ID`,`Bank_ID`),
  ADD KEY `Bank_ID` (`Bank_ID`);

--
-- Indexes for table `attendance_accepted_requests`
--
ALTER TABLE `attendance_accepted_requests`
  ADD PRIMARY KEY (`Request_ID`),
  ADD KEY `Donor_ID` (`Donor_ID`),
  ADD KEY `attendance_accepted_requests_ibfk_2` (`Campaign_ID`);

--
-- Indexes for table `authentication_code`
--
ALTER TABLE `authentication_code`
  ADD PRIMARY KEY (`Code_ID`);

--
-- Indexes for table `blocked_users`
--
ALTER TABLE `blocked_users`
  ADD PRIMARY KEY (`UID`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`Blog_ID`);

--
-- Indexes for table `bloodbanks`
--
ALTER TABLE `bloodbanks`
  ADD PRIMARY KEY (`BloodBank_ID`),
  ADD UNIQUE KEY `Telephone_No` (`Telephone_No`);

--
-- Indexes for table `bloodgroups`
--
ALTER TABLE `bloodgroups`
  ADD PRIMARY KEY (`BloodGroup_ID`),
  ADD UNIQUE KEY `BloodGroup_Name` (`BloodGroup_Name`);

--
-- Indexes for table `blood_packets`
--
ALTER TABLE `blood_packets`
  ADD PRIMARY KEY (`Packet_ID`),
  ADD KEY `Packed_By` (`Packed_By`),
  ADD KEY `Certified_By` (`Certified_By`);

--
-- Indexes for table `blood_requests`
--
ALTER TABLE `blood_requests`
  ADD PRIMARY KEY (`Request_ID`),
  ADD KEY `Requested_By` (`Requested_By`),
  ADD KEY `BloodGroup` (`BloodGroup`);

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
-- Indexes for table `campaigns_sponsors`
--
ALTER TABLE `campaigns_sponsors`
  ADD KEY `Campaign_ID` (`Campaign_ID`),
  ADD KEY `Sponsor_ID` (`Sponsor_ID`),
  ADD KEY `Package_ID` (`Package_ID`);

--
-- Indexes for table `campaign_request`
--
ALTER TABLE `campaign_request`
  ADD KEY `Campaign_ID` (`Campaign_ID`),
  ADD KEY `Organization_ID` (`Organization_ID`);

--
-- Indexes for table `donation_campaigns`
--
ALTER TABLE `donation_campaigns`
  ADD PRIMARY KEY (`Campaign_ID`),
  ADD KEY `Organization_ID` (`Organization_ID`),
  ADD KEY `Nearest_Blood_Bank` (`Nearest_Blood_Bank`);

--
-- Indexes for table `donors`
--
ALTER TABLE `donors`
  ADD PRIMARY KEY (`Donor_ID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `NIC` (`NIC`),
  ADD KEY `Nearest_Bank` (`Nearest_Bank`),
  ADD KEY `Verified_By` (`Verified_By`),
  ADD KEY `BloodPacket_ID` (`BloodPacket_ID`);

--
-- Indexes for table `donor_notifications`
--
ALTER TABLE `donor_notifications`
  ADD PRIMARY KEY (`Notification_ID`),
  ADD KEY `Target_ID` (`Target_ID`);

--
-- Indexes for table `donor_reviews`
--
ALTER TABLE `donor_reviews`
  ADD PRIMARY KEY (`Review_ID`),
  ADD KEY `Donor_ID` (`Donor_ID`),
  ADD KEY `Campaign_ID` (`Campaign_ID`);

--
-- Indexes for table `hospitals`
--
ALTER TABLE `hospitals`
  ADD PRIMARY KEY (`Hospital_ID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `Contact_No` (`Contact_No`);

--
-- Indexes for table `inform_donors`
--
ALTER TABLE `inform_donors`
  ADD PRIMARY KEY (`Message_ID`),
  ADD KEY `inform_donors_ibfk_1` (`Campaign_ID`);

--
-- Indexes for table `logging_history`
--
ALTER TABLE `logging_history`
  ADD PRIMARY KEY (`Session_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `managers`
--
ALTER TABLE `managers`
  ADD PRIMARY KEY (`Manager_ID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `BloodBank_ID` (`BloodBank_ID`);

--
-- Indexes for table `manager_notifications`
--
ALTER TABLE `manager_notifications`
  ADD PRIMARY KEY (`Notification_ID`),
  ADD KEY `Target_ID` (`Target_ID`);

--
-- Indexes for table `medicalofficers`
--
ALTER TABLE `medicalofficers`
  ADD PRIMARY KEY (`Officer_ID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `NIC` (`NIC`),
  ADD UNIQUE KEY `Registration_Number` (`Registration_Number`),
  ADD KEY `Branch_ID` (`Branch_ID`);

--
-- Indexes for table `medical_officer_notifications`
--
ALTER TABLE `medical_officer_notifications`
  ADD PRIMARY KEY (`Notification_ID`),
  ADD KEY `Target_ID` (`Target_ID`);

--
-- Indexes for table `medical_team`
--
ALTER TABLE `medical_team`
  ADD PRIMARY KEY (`Team_ID`),
  ADD KEY `Assigned_By` (`Assigned_By`),
  ADD KEY `Team_Leader_ID` (`Team_Leader_ID`);

--
-- Indexes for table `monthly_reports`
--
ALTER TABLE `monthly_reports`
  ADD PRIMARY KEY (`Report_ID`),
  ADD KEY `Generated_By` (`Generated_By`);

--
-- Indexes for table `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`Organization_ID`),
  ADD UNIQUE KEY `Organization_Email` (`Organization_Email`);

--
-- Indexes for table `organization_members`
--
ALTER TABLE `organization_members`
  ADD PRIMARY KEY (`Organization_ID`,`NIC`),
  ADD UNIQUE KEY `Contact_No` (`Contact_No`),
  ADD UNIQUE KEY `NIC` (`NIC`);

--
-- Indexes for table `organization_notifications`
--
ALTER TABLE `organization_notifications`
  ADD PRIMARY KEY (`Notification_ID`),
  ADD KEY `Target_ID` (`Target_ID`);

--
-- Indexes for table `otp_code`
--
ALTER TABLE `otp_code`
  ADD PRIMARY KEY (`UserID`,`Code`);

--
-- Indexes for table `otp_code_audit`
--
ALTER TABLE `otp_code_audit`
  ADD PRIMARY KEY (`UserID`,`Code`);

--
-- Indexes for table `password_reset`
--
ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`UID`);

--
-- Indexes for table `password_reset_audit`
--
ALTER TABLE `password_reset_audit`
  ADD PRIMARY KEY (`UID`,`Token`);

--
-- Indexes for table `rejected_campaigns`
--
ALTER TABLE `rejected_campaigns`
  ADD PRIMARY KEY (`Campaign_ID`),
  ADD KEY `Rejected_By` (`Rejected_By`);

--
-- Indexes for table `rejected_donations`
--
ALTER TABLE `rejected_donations`
  ADD PRIMARY KEY (`Donation_ID`),
  ADD KEY `Donor_ID` (`Donor_ID`),
  ADD KEY `Packet_ID` (`Packet_ID`),
  ADD KEY `Rejected_By` (`Rejected_By`);

--
-- Indexes for table `sponsors`
--
ALTER TABLE `sponsors`
  ADD PRIMARY KEY (`Sponsor_ID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `Contact_No` (`Contact_No`),
  ADD KEY `sponsors_ibfk_2` (`Package_ID`);

--
-- Indexes for table `sponsorship_packages`
--
ALTER TABLE `sponsorship_packages`
  ADD PRIMARY KEY (`Package_ID`),
  ADD KEY `Created_By` (`Created_By`),
  ADD KEY `Updated_By` (`Updated_By`);

--
-- Indexes for table `sponsor_notifications`
--
ALTER TABLE `sponsor_notifications`
  ADD PRIMARY KEY (`Notification_ID`),
  ADD KEY `Target_ID` (`Target_ID`);

--
-- Indexes for table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`Team_ID`,`Member_ID`),
  ADD KEY `Member_ID` (`Member_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `yearly_reports`
--
ALTER TABLE `yearly_reports`
  ADD PRIMARY KEY (`Report_ID`),
  ADD KEY `Generated_By` (`Generated_By`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accepted_donations`
--
ALTER TABLE `accepted_donations`
  ADD CONSTRAINT `accepted_donations_ibfk_1` FOREIGN KEY (`Donor_ID`) REFERENCES `donors` (`Donor_ID`),
  ADD CONSTRAINT `accepted_donations_ibfk_2` FOREIGN KEY (`Packet_ID`) REFERENCES `blood_packets` (`Packet_ID`),
  ADD CONSTRAINT `accepted_donations_ibfk_3` FOREIGN KEY (`Retrieved_By`) REFERENCES `medicalofficers` (`Officer_ID`),
  ADD CONSTRAINT `accepted_donations_ibfk_4` FOREIGN KEY (`Verified_By`) REFERENCES `medicalofficers` (`Officer_ID`);

--
-- Constraints for table `additional_sponsorship_requests`
--
ALTER TABLE `additional_sponsorship_requests`
  ADD CONSTRAINT `additional_sponsorship_requests_ibfk_1` FOREIGN KEY (`Campaign_ID`) REFERENCES `campaign` (`Campaign_ID`);

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_ibfk_1` FOREIGN KEY (`Admin_ID`) REFERENCES `users` (`UID`);

--
-- Constraints for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD CONSTRAINT `admin_notifications_ibfk_1` FOREIGN KEY (`Target_ID`) REFERENCES `admins` (`Admin_ID`);

--
-- Constraints for table `approved_campaigns`
--
ALTER TABLE `approved_campaigns`
  ADD CONSTRAINT `approved_campaigns_ibfk_1` FOREIGN KEY (`Campaign_ID`) REFERENCES `campaign` (`Campaign_ID`),
  ADD CONSTRAINT `approved_campaigns_ibfk_2` FOREIGN KEY (`Bank_ID`) REFERENCES `bloodbanks` (`BloodBank_ID`);

--
-- Constraints for table `attendance_accepted_requests`
--
ALTER TABLE `attendance_accepted_requests`
  ADD CONSTRAINT `attendance_accepted_requests_ibfk_1` FOREIGN KEY (`Donor_ID`) REFERENCES `donors` (`Donor_ID`),
  ADD CONSTRAINT `attendance_accepted_requests_ibfk_2` FOREIGN KEY (`Campaign_ID`) REFERENCES `campaign` (`Campaign_ID`);

--
-- Constraints for table `blocked_users`
--
ALTER TABLE `blocked_users`
  ADD CONSTRAINT `blocked_users_ibfk_1` FOREIGN KEY (`UID`) REFERENCES `users` (`UID`);

--
-- Constraints for table `blood_packets`
--
ALTER TABLE `blood_packets`
  ADD CONSTRAINT `blood_packets_ibfk_1` FOREIGN KEY (`Packed_By`) REFERENCES `medicalofficers` (`Officer_ID`),
  ADD CONSTRAINT `blood_packets_ibfk_2` FOREIGN KEY (`Certified_By`) REFERENCES `medicalofficers` (`Officer_ID`);

--
-- Constraints for table `blood_requests`
--
ALTER TABLE `blood_requests`
  ADD CONSTRAINT `blood_requests_ibfk_1` FOREIGN KEY (`Requested_By`) REFERENCES `hospitals` (`Hospital_ID`),
  ADD CONSTRAINT `blood_requests_ibfk_2` FOREIGN KEY (`BloodGroup`) REFERENCES `bloodgroups` (`BloodGroup_ID`);

--
-- Constraints for table `campaign`
--
ALTER TABLE `campaign`
  ADD CONSTRAINT `campaign_ibfk_1` FOREIGN KEY (`Verified_By`) REFERENCES `managers` (`Manager_ID`),
  ADD CONSTRAINT `campaign_ibfk_2` FOREIGN KEY (`Assigned_Team`) REFERENCES `medical_team` (`Team_ID`),
  ADD CONSTRAINT `campaign_ibfk_3` FOREIGN KEY (`Nearest_BloodBank`) REFERENCES `bloodbanks` (`BloodBank_ID`),
  ADD CONSTRAINT `campaign_ibfk_4` FOREIGN KEY (`Organization_ID`) REFERENCES `organizations` (`Organization_ID`),
  ADD CONSTRAINT `campaign_ibfk_5` FOREIGN KEY (`Package_ID`) REFERENCES `sponsorship_packages` (`Package_ID`);

--
-- Constraints for table `campaigns_sponsors`
--
ALTER TABLE `campaigns_sponsors`
  ADD CONSTRAINT `campaigns_sponsors_ibfk_1` FOREIGN KEY (`Campaign_ID`) REFERENCES `campaign` (`Campaign_ID`),
  ADD CONSTRAINT `campaigns_sponsors_ibfk_2` FOREIGN KEY (`Sponsor_ID`) REFERENCES `sponsors` (`Sponsor_ID`),
  ADD CONSTRAINT `campaigns_sponsors_ibfk_3` FOREIGN KEY (`Package_ID`) REFERENCES `sponsorship_packages` (`Package_ID`);

--
-- Constraints for table `campaign_request`
--
ALTER TABLE `campaign_request`
  ADD CONSTRAINT `campaign_request_ibfk_1` FOREIGN KEY (`Campaign_ID`) REFERENCES `campaign` (`Campaign_ID`),
  ADD CONSTRAINT `campaign_request_ibfk_2` FOREIGN KEY (`Organization_ID`) REFERENCES `organizations` (`Organization_ID`);

--
-- Constraints for table `donation_campaigns`
--
ALTER TABLE `donation_campaigns`
  ADD CONSTRAINT `donation_campaigns_ibfk_1` FOREIGN KEY (`Organization_ID`) REFERENCES `organizations` (`Organization_ID`),
  ADD CONSTRAINT `donation_campaigns_ibfk_2` FOREIGN KEY (`Nearest_Blood_Bank`) REFERENCES `bloodbanks` (`BloodBank_ID`);

--
-- Constraints for table `donors`
--
ALTER TABLE `donors`
  ADD CONSTRAINT `donors_ibfk_1` FOREIGN KEY (`Donor_ID`) REFERENCES `users` (`UID`),
  ADD CONSTRAINT `donors_ibfk_2` FOREIGN KEY (`Nearest_Bank`) REFERENCES `bloodbanks` (`BloodBank_ID`),
  ADD CONSTRAINT `donors_ibfk_3` FOREIGN KEY (`Verified_By`) REFERENCES `medicalofficers` (`Officer_ID`),
  ADD CONSTRAINT `donors_ibfk_4` FOREIGN KEY (`BloodPacket_ID`) REFERENCES `blood_packets` (`Packet_ID`);

--
-- Constraints for table `donor_notifications`
--
ALTER TABLE `donor_notifications`
  ADD CONSTRAINT `donor_notifications_ibfk_1` FOREIGN KEY (`Target_ID`) REFERENCES `donors` (`Donor_ID`);

--
-- Constraints for table `donor_reviews`
--
ALTER TABLE `donor_reviews`
  ADD CONSTRAINT `donor_reviews_ibfk_1` FOREIGN KEY (`Donor_ID`) REFERENCES `donors` (`Donor_ID`),
  ADD CONSTRAINT `donor_reviews_ibfk_2` FOREIGN KEY (`Campaign_ID`) REFERENCES `campaign` (`Campaign_ID`);

--
-- Constraints for table `inform_donors`
--
ALTER TABLE `inform_donors`
  ADD CONSTRAINT `inform_donors_ibfk_1` FOREIGN KEY (`Campaign_ID`) REFERENCES `campaign` (`Campaign_ID`);

--
-- Constraints for table `logging_history`
--
ALTER TABLE `logging_history`
  ADD CONSTRAINT `logging_history_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`UID`);

--
-- Constraints for table `managers`
--
ALTER TABLE `managers`
  ADD CONSTRAINT `managers_ibfk_1` FOREIGN KEY (`BloodBank_ID`) REFERENCES `bloodbanks` (`BloodBank_ID`),
  ADD CONSTRAINT `managers_ibfk_2` FOREIGN KEY (`Manager_ID`) REFERENCES `users` (`UID`);

--
-- Constraints for table `manager_notifications`
--
ALTER TABLE `manager_notifications`
  ADD CONSTRAINT `manager_notifications_ibfk_1` FOREIGN KEY (`Target_ID`) REFERENCES `managers` (`Manager_ID`);

--
-- Constraints for table `medicalofficers`
--
ALTER TABLE `medicalofficers`
  ADD CONSTRAINT `medicalofficers_ibfk_1` FOREIGN KEY (`Branch_ID`) REFERENCES `bloodbanks` (`BloodBank_ID`);

--
-- Constraints for table `medical_officer_notifications`
--
ALTER TABLE `medical_officer_notifications`
  ADD CONSTRAINT `medical_officer_notifications_ibfk_1` FOREIGN KEY (`Target_ID`) REFERENCES `medicalofficers` (`Officer_ID`);

--
-- Constraints for table `medical_team`
--
ALTER TABLE `medical_team`
  ADD CONSTRAINT `medical_team_ibfk_1` FOREIGN KEY (`Assigned_By`) REFERENCES `managers` (`Manager_ID`),
  ADD CONSTRAINT `medical_team_ibfk_2` FOREIGN KEY (`Team_Leader_ID`) REFERENCES `medicalofficers` (`Officer_ID`);

--
-- Constraints for table `monthly_reports`
--
ALTER TABLE `monthly_reports`
  ADD CONSTRAINT `monthly_reports_ibfk_1` FOREIGN KEY (`Generated_By`) REFERENCES `managers` (`Manager_ID`);

--
-- Constraints for table `organizations`
--
ALTER TABLE `organizations`
  ADD CONSTRAINT `organizations_ibfk_1` FOREIGN KEY (`Organization_ID`) REFERENCES `users` (`UID`);

--
-- Constraints for table `organization_members`
--
ALTER TABLE `organization_members`
  ADD CONSTRAINT `organization_members_ibfk_1` FOREIGN KEY (`Organization_ID`) REFERENCES `organizations` (`Organization_ID`);

--
-- Constraints for table `organization_notifications`
--
ALTER TABLE `organization_notifications`
  ADD CONSTRAINT `organization_notifications_ibfk_1` FOREIGN KEY (`Target_ID`) REFERENCES `organizations` (`Organization_ID`);

--
-- Constraints for table `otp_code`
--
ALTER TABLE `otp_code`
  ADD CONSTRAINT `otp_code_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UID`);

--
-- Constraints for table `otp_code_audit`
--
ALTER TABLE `otp_code_audit`
  ADD CONSTRAINT `otp_code_audit_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UID`);

--
-- Constraints for table `password_reset`
--
ALTER TABLE `password_reset`
  ADD CONSTRAINT `password_reset_ibfk_1` FOREIGN KEY (`UID`) REFERENCES `users` (`UID`);

--
-- Constraints for table `password_reset_audit`
--
ALTER TABLE `password_reset_audit`
  ADD CONSTRAINT `password_reset_audit_ibfk_1` FOREIGN KEY (`UID`) REFERENCES `users` (`UID`);

--
-- Constraints for table `rejected_campaigns`
--
ALTER TABLE `rejected_campaigns`
  ADD CONSTRAINT `rejected_campaigns_ibfk_1` FOREIGN KEY (`Campaign_ID`) REFERENCES `campaign` (`Campaign_ID`),
  ADD CONSTRAINT `rejected_campaigns_ibfk_2` FOREIGN KEY (`Rejected_By`) REFERENCES `medicalofficers` (`Officer_ID`);

--
-- Constraints for table `rejected_donations`
--
ALTER TABLE `rejected_donations`
  ADD CONSTRAINT `rejected_donations_ibfk_1` FOREIGN KEY (`Donor_ID`) REFERENCES `donors` (`Donor_ID`),
  ADD CONSTRAINT `rejected_donations_ibfk_2` FOREIGN KEY (`Packet_ID`) REFERENCES `blood_packets` (`Packet_ID`),
  ADD CONSTRAINT `rejected_donations_ibfk_3` FOREIGN KEY (`Rejected_By`) REFERENCES `medicalofficers` (`Officer_ID`);

--
-- Constraints for table `sponsors`
--
ALTER TABLE `sponsors`
  ADD CONSTRAINT `sponsors_ibfk_1` FOREIGN KEY (`Sponsor_ID`) REFERENCES `users` (`UID`),
  ADD CONSTRAINT `sponsors_ibfk_2` FOREIGN KEY (`Package_ID`) REFERENCES `sponsorship_packages` (`Package_ID`);

--
-- Constraints for table `sponsorship_packages`
--
ALTER TABLE `sponsorship_packages`
  ADD CONSTRAINT `sponsorship_packages_ibfk_1` FOREIGN KEY (`Created_By`) REFERENCES `managers` (`Manager_ID`),
  ADD CONSTRAINT `sponsorship_packages_ibfk_2` FOREIGN KEY (`Updated_By`) REFERENCES `managers` (`Manager_ID`);

--
-- Constraints for table `sponsor_notifications`
--
ALTER TABLE `sponsor_notifications`
  ADD CONSTRAINT `sponsor_notifications_ibfk_1` FOREIGN KEY (`Target_ID`) REFERENCES `sponsors` (`Sponsor_ID`);

--
-- Constraints for table `team_members`
--
ALTER TABLE `team_members`
  ADD CONSTRAINT `team_members_ibfk_1` FOREIGN KEY (`Team_ID`) REFERENCES `medical_team` (`Team_ID`),
  ADD CONSTRAINT `team_members_ibfk_2` FOREIGN KEY (`Member_ID`) REFERENCES `medicalofficers` (`Officer_ID`);

--
-- Constraints for table `yearly_reports`
--
ALTER TABLE `yearly_reports`
  ADD CONSTRAINT `yearly_reports_ibfk_1` FOREIGN KEY (`Generated_By`) REFERENCES `managers` (`Manager_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
