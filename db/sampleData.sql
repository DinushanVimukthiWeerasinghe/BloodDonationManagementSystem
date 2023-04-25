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
INSERT INTO `Blood_Requests` (Request_ID, Requested_By, BloodGroup, Requested_At, Type, Volume, Status, Action, Remarks)
VALUES ('RQ0001', 'Hos_01', 'A+', '2019-01-01 00:00:00', 1,14.25, 1, 1, 'Sample Request'),
('RQ0002', 'Hos_01', 'B+', '2019-01-01 00:00:00', 1,14.25, 1, 1, 'Sample Request'),
('RQ0003', 'Hos_01', 'AB+', '2019-01-01 00:00:00', 1,14.25, 1, 1, 'Sample Request'),
('RQ0004', 'Hos_01', 'O+', '2019-01-01 00:00:00', 1,14.25, 1, 1, 'Sample Request'),
('RQ0005', 'Hos_01', 'A-', '2019-01-01 00:00:00', 1,14.25, 1, 1, 'Sample Request'),
('RQ0006', 'Hos_01', 'B-', '2019-01-01 00:00:00', 1,14.25, 1, 1, 'Sample Request'),
('RQ0007', 'Hos_01', 'AB-', '2019-01-01 00:00:00', 1,14.25, 1, 1, 'Sample Request'),
('RQ0008', 'Hos_01', 'O-', '2019-01-01 00:00:00', 1,14.25, 1, 1, 'Sample Request'),
('RQ0009', 'Hos_01', 'A+', '2019-01-01 00:00:00', 1,14.25, 1, 1, 'Sample Request'),
('RQ0010', 'Hos_01', 'B+', '2019-01-01 00:00:00', 1,14.25, 1, 1, 'Sample Request'),
('RQ0011', 'Hos_01', 'AB+', '2019-01-01 00:00:00', 1,14.25, 1, 1, 'Sample Request'),
('RQ0012', 'Hos_01', 'O+', '2019-01-01 00:00:00', 1,14.25, 1, 1, 'Sample Request'),
('RQ0013', 'Hos_01', 'A-', '2019-01-01 00:00:00', 1,14.25, 1, 1, 'Sample Request'),
('RQ0014', 'Hos_01', 'B-', '2019-01-01 00:00:00', 1,14.25, 1, 1, 'Sample Request'),
('RQ0015', 'Hos_01', 'AB-', '2019-01-01 00:00:00', 1,14.25, 1, 1, 'Sample Request'),
('RQ0016', 'Hos_01', 'O-', '2019-01-01 00:00:00', 1,14.25, 1, 1, 'Sample Request'),
('RQ0017', 'Hos_01', 'A+', '2019-01-01 00:00:00', 1,14.25, 1, 1, 'Sample Request'),
('RQ0018', 'Hos_01', 'B+', '2019-01-01 00:00:00', 1,14.25, 1, 1, 'Sample Request'),
('RQ0019', 'Hos_01', 'AB+', '2019-01-01 00:00:00', 1,14.25, 1, 1, 'Sample Request'),
('RQ0020', 'Hos_01', 'O+', '2019-01-01 00:00:00', 1,14.25, 1, 1, 'Sample Request'),
('RQ0021', 'Hos_01', 'A-', '2019-01-01 00:00:00', 1,14.25, 1, 1, 'Sample Request'),
('RQ0022', 'Hos_01', 'B-', '2019-01-01 00:00:00', 1,14.25, 1, 1, 'Sample Request'),
('RQ0023', 'Hos_01', 'AB-', '2019-01-01 00:00:00', 1,14.25, 1, 1, 'Sample Request');

