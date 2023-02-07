use bepositive;

DROP TABLE IF EXISTS `Reported_Donors`;
CREATE TABLE `Reported_Donors` (
  `Report_ID` varchar(20) NOT NULL,
  `Donor_ID` varchar(20) NOT NULL,
  `Reported_By` varchar(20) NOT NULL,
  `Reported_At` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Reason` varchar(100) NOT NULL,
  `Status` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Report_ID`),
  FOREIGN KEY (`Donor_ID`) REFERENCES `Donors`(`Donor_ID`),
  FOREIGN KEY (`Reported_By`) REFERENCES MedicalOfficers(Officer_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


# Blood Requests Sample Data
INSERT INTO `Blood_Requests` (`Request_ID`, `Requested_By`, `BloodGroup`, `Requested_At`, `Type`, `Status`) VALUES ('Req_01', 'Hos_01', 'A+', CURRENT_TIMESTAMP, '1', '1');
INSERT INTO `Blood_Requests` (`Request_ID`, `Requested_By`, `BloodGroup`, `Requested_At`, `Type`, `Status`) VALUES ('Req_02', 'Hos_01', 'AB+', CURRENT_TIMESTAMP, '1', '1');
INSERT INTO `Blood_Requests` (`Request_ID`, `Requested_By`, `BloodGroup`, `Requested_At`, `Type`, `Status`) VALUES ('Req_03', 'Hos_01', 'O+', CURRENT_TIMESTAMP, '1', '1');
INSERT INTO `Blood_Requests` (`Request_ID`, `Requested_By`, `BloodGroup`, `Requested_At`, `Type`, `Status`) VALUES ('Req_04', 'Hos_01', 'B-', CURRENT_TIMESTAMP, '1', '1');
INSERT INTO `Blood_Requests` (`Request_ID`, `Requested_By`, `BloodGroup`, `Requested_At`, `Type`, `Status`) VALUES ('Req_05', 'Hos_01', 'O+', CURRENT_TIMESTAMP, '1', '1');


