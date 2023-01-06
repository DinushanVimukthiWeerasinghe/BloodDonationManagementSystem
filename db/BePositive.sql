DROP database IF EXISTS bepositive;
CREATE DATABASE IF NOT EXISTS `bepositive` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
use bepositive;
DROP TABLE IF EXISTS Users;
CREATE TABLE IF NOT EXISTS Users (
    UID VARCHAR(20) PRIMARY KEY,
    Email VARCHAR(100) UNIQUE ,
    Password VARCHAR(100) NOT NULL,
    Status INT NOT NULL DEFAULT 0,
    Role VARCHAR(100) NOT NULL DEFAULT 'donor',
    Created_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Updated_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
# Add a new user
INSERT INTO Users (UID, Email, Password, Status, Role) VALUES ('Manager_01', 'stdinushan@gmail.com','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS',0,'Manager');

# Create Admin User
INSERT INTO Users (UID, Email, Password, Status, Role) VALUES ('Admin_01', 'admin@admin.com','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS',0,'Admin');

# Create Admin Table
DROP TABLE IF EXISTS Admins;
CREATE TABLE IF NOT EXISTS Admins (
    Admin_ID VARCHAR(20) PRIMARY KEY,
    UserName VARCHAR(100) NOT NULL,
    Email VARCHAR(100) NOT NULL,
    Phone VARCHAR(100) NOT NULL,
    Profile_Image VARCHAR(100) NOT NULL DEFAULT '/upload/adminDefault.png',
    FOREIGN KEY (Admin_ID) REFERENCES Users(UID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Insert Admin Users Here
INSERT INTO Admins (Admin_ID, UserName, Email, Phone) VALUES ('Admin_01', 'Admin','admin@admin.com','0771234567');


# Create Blood Bank Table
# Main Blood Bank - 1 Branch - 2
DROP TABLE IF EXISTS BloodBanks;
CREATE TABLE IF NOT EXISTS BloodBanks (
    BloodBank_ID VARCHAR(20) NOT NULL  PRIMARY KEY,
    BankName VARCHAR(100) NOT NULL,
    Address1 VARCHAR(100) NOT NULL,
    Address2 VARCHAR(100) NOT NULL ,
    City VARCHAR(100) NOT NULL,
    Telephone_No VARCHAR(100) UNIQUE ,
    No_Of_Doctors INT NOT NULL DEFAULT 0,
    No_Of_Nurses INT NOT NULL DEFAULT 0,
    No_Of_Beds INT NOT NULL DEFAULT 0,
    No_Of_Storages INT NOT NULL DEFAULT 0,
    Type INT NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Insert Main Blood Bank
INSERT INTO BloodBanks (BloodBank_ID, BankName, Address1, Address2, City, Telephone_No, No_Of_Doctors, No_Of_Nurses, No_Of_Beds, No_Of_Storages, Type) VALUES ('BloodBank_01', 'Main Blood Bank','No 01, Main Street','Colombo 01','Colombo','0111234567',0,0,0,0,1);

# Create Medical Officer Table
DROP TABLE IF EXISTS MedicalOfficers;
CREATE TABLE IF NOT EXISTS MedicalOfficers (
    Officer_ID VARCHAR(20) PRIMARY KEY,
    First_Name VARCHAR(100) NOT NULL,
    Last_Name VARCHAR(100) NOT NULL,
    Address1 VARCHAR(100) NOT NULL,
    Address2 VARCHAR(100) NOT NULL,
    Mobile_No VARCHAR(12) NOT NULL,
    City VARCHAR(100) NOT NULL,
    Email VARCHAR(100) UNIQUE ,
    Status INT NOT NULL DEFAULT 0,
    Joined_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    BloodBank_ID VARCHAR(20) NOT NULL,
    Profile_Image VARCHAR(100) NOT NULL DEFAULT '/upload/medicalOfficerDefault.png',
    FOREIGN KEY (BloodBank_ID) REFERENCES BloodBanks(BloodBank_ID),
    FOREIGN KEY (Officer_ID) REFERENCES Users(UID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Create Table for Donor
DROP TABLE IF EXISTS Donors;
CREATE TABLE IF NOT EXISTS Donors (
    Donor_ID VARCHAR(20) PRIMARY KEY,
    First_Name VARCHAR(100) NOT NULL,
    Last_Name VARCHAR(100) NOT NULL,
    Address1 VARCHAR(100) NOT NULL,
    Address2 VARCHAR(100) NOT NULL ,
    City VARCHAR(100) NOT NULL,
    Nearest_Bank VARCHAR(20) NOT NULL,
    Account_No VARCHAR(100) NULL,
    Contact_No VARCHAR(100) NOT NULL,
    Status VARCHAR(50) NOT NULL,
    Donation_Availability INT NOT NULL DEFAULT 0,
    Verified INT NOT NULL DEFAULT 0,
    Verified_At TIMESTAMP NULL,
    Verified_By VARCHAR(20) NULL,
    Verification_Remarks VARCHAR(100) NULL,
    Created_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Updated_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    Profile_Image VARCHAR(100) NOT NULL DEFAULT '/upload/donorDefault.png',
    FOREIGN KEY (Donor_ID) REFERENCES Users(UID),
    FOREIGN KEY (Nearest_Bank) REFERENCES BloodBanks(BloodBank_ID),
    FOREIGN KEY (Verified_By) REFERENCES MedicalOfficers(Officer_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Create Hospital Table
DROP TABLE IF EXISTS Hospitals;
CREATE TABLE IF NOT EXISTS Hospitals (
    Hospital_ID VARCHAR(20) NOT NULL  PRIMARY KEY,
    Hospital_Name VARCHAR(100) NOT NULL,
    Address1 VARCHAR(100) NOT NULL,
    Address2 VARCHAR(100) NOT NULL,
    City VARCHAR(100) NOT NULL,
    Telephone_No VARCHAR(100) UNIQUE ,
    Type INT NOT NULL DEFAULT 1,
    Profile_Image VARCHAR(100) NOT NULL DEFAULT '/upload/hospitalDefault.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Create Manager Table
DROP TABLE IF EXISTS Managers;
CREATE TABLE IF NOT EXISTS Managers (
    Manager_ID VARCHAR(20) PRIMARY KEY,
    First_Name VARCHAR(100) NOT NULL,
    Last_Name VARCHAR(100) NOT NULL,
    Address1 VARCHAR(100) NOT NULL,
    Address2 VARCHAR(100) NOT NULL,
    City VARCHAR(100) NOT NULL,
    Mobile_No VARCHAR(12) NOT NULL,
    Email VARCHAR(100) UNIQUE ,
    Status INT NOT NULL DEFAULT 0,
    Joined_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    BloodBank_ID VARCHAR(20) NOT NULL,
    Profile_Image VARCHAR(100) NOT NULL DEFAULT '/upload/managerDefault.png',
    FOREIGN KEY (BloodBank_ID) REFERENCES BloodBanks(BloodBank_ID),
    FOREIGN KEY (Manager_ID) REFERENCES Users(UID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Create Manager User
# INSERT INTO Users (UID, Password, Role) VALUES ('Manager_01', '$2y$10$hoKw.CNW2iwq0SI8yULXGenv2SkajhdIXtzyoVz9MVMyTsRpJKKzi', 'Manager');
INSERT INTO Managers (Manager_ID, First_Name, Last_Name, Address1, Address2, City, Mobile_No, Email, BloodBank_ID) VALUES ('Manager_01', 'Manager','Manager','Address1','Address2','Colombo','0771234567','stdinushan@gmail.com','BloodBank_01');

# Create Table for Accepted Requests
DROP TABLE IF EXISTS Accepted_Requests;
CREATE TABLE IF NOT EXISTS Accepted_Requests (
    Request_ID VARCHAR(20) NOT NULL  PRIMARY KEY,
    Donor_ID VARCHAR(20) NOT NULL ,
    Accepted_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (Donor_ID) REFERENCES Donors(Donor_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS Blood_Requests;
CREATE TABLE IF NOT EXISTS Blood_Requests (
    Request_ID VARCHAR(20) NOT NULL  PRIMARY KEY,
    Requested_By VARCHAR(20) NOT NULL,
    BloodGroup VARCHAR(3) NOT NULL,
    Requested_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Status VARCHAR(50) NOT NULL,
    FOREIGN KEY (Requested_By) REFERENCES Hospitals(Hospital_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Create Table for Organizations
DROP TABLE IF EXISTS Organizations;
CREATE TABLE IF NOT EXISTS Organizations (
    Organization_ID VARCHAR(20) NOT NULL  PRIMARY KEY,
    Organization_Name VARCHAR(100) NOT NULL,
    Address1 VARCHAR(100) NOT NULL,
    Address2 VARCHAR(100) NOT NULL ,
    City VARCHAR(100) NOT NULL,
    Status VARCHAR(50) NOT NULL,
    Profile_Image VARCHAR(100) NOT NULL DEFAULT '/upload/organizationDefault.png',
    Created_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Updated_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (Organization_ID) REFERENCES Users(UID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Create Table for Sponsors
DROP TABLE IF EXISTS Sponsors;
CREATE TABLE IF NOT EXISTS Sponsors (
    Sponsor_ID VARCHAR(20) NOT NULL  PRIMARY KEY,
    Name VARCHAR(100) NOT NULL,
    Address1 VARCHAR(100) NOT NULL,
    Address2 VARCHAR(100) NOT NULL ,
    City VARCHAR(100) NOT NULL,
    Status VARCHAR(50) NOT NULL,
    Created_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Updated_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    Profile_Image VARCHAR(100) NOT NULL DEFAULT '/upload/sponsorDefault.png',
    FOREIGN KEY (Sponsor_ID) REFERENCES Users(UID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Create Table for Sponsorship Packages
DROP TABLE IF EXISTS Sponsorship_Packages;
CREATE TABLE IF NOT EXISTS Sponsorship_Packages (
    Package_ID VARCHAR(20) NOT NULL  PRIMARY KEY,
    Package_Name VARCHAR(100) NOT NULL,
    Package_Description VARCHAR(100) NOT NULL,
    Package_Price VARCHAR(100) NOT NULL,
    Created_By VARCHAR(20) NOT NULL,
    Updated_By VARCHAR(20) NULL,
    Created_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Updated_At TIMESTAMP DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (Created_By) REFERENCES Managers(Manager_ID),
    FOREIGN KEY (Updated_By) REFERENCES Managers(Manager_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Create Table For Medical Team
DROP TABLE IF EXISTS Medical_Team;
CREATE TABLE IF NOT EXISTS  Medical_Team
(
    Team_ID      VARCHAR(20)  NOT NULL PRIMARY KEY,
    Campaign_ID  VARCHAR(20)  NOT NULL,
    Team_Leader  VARCHAR(20)  NOT NULL,
    Team_Members VARCHAR(100) NOT NULL,
    Assigned_By VARCHAR(20) NOT NULL ,
    FOREIGN KEY (Assigned_By) REFERENCES Managers(Manager_ID),
    FOREIGN KEY (Team_Leader) REFERENCES MedicalOfficers (Officer_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Create Table for Campaigns
DROP TABLE IF EXISTS Campaigns;
CREATE TABLE IF NOT EXISTS Campaign (
    Campaign_ID VARCHAR(20) NOT NULL  PRIMARY KEY,
    Campaign_Name VARCHAR(100) NOT NULL,
    Campaign_Description VARCHAR(100) NOT NULL,
    Campaign_Date DATE NOT NULL,
    Venue VARCHAR(100) NOT NULL,
    Nearest_City VARCHAR(100) NOT NULL,
    Status VARCHAR(50) NOT NULL,
    Nearest_BloodBank VARCHAR(20) NOT NULL,
    Verified INT NOT NULL DEFAULT 0,
    Verified_By VARCHAR(20) NULL,
    Verified_At TIMESTAMP DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    Assigned_Team VARCHAR(20) DEFAULT NULL,
    Remarks VARCHAR(100) NULL,
    Created_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Updated_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (Verified_By) REFERENCES Managers(Manager_ID),
    FOREIGN KEY (Assigned_Team) REFERENCES Medical_Team(Team_ID),
    FOREIGN KEY (Nearest_BloodBank) REFERENCES BloodBanks(BloodBank_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS Campaigns_Sponsors;
CREATE TABLE IF NOT EXISTS Campaigns_Sponsors (
    Campaign_ID VARCHAR(20) NOT NULL,
    Sponsor_ID VARCHAR(20) NOT NULL,
    Package_ID VARCHAR(20) NOT NULL,
    FOREIGN KEY (Campaign_ID) REFERENCES Campaign(Campaign_ID),
    FOREIGN KEY (Sponsor_ID) REFERENCES Sponsors(Sponsor_ID),
    FOREIGN KEY (Package_ID) REFERENCES Sponsorship_Packages(Package_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS Campaign_Request;
CREATE TABLE IF NOT EXISTS Approved_Campaigns (
    Campaign_ID VARCHAR(20) NOT NULL,
    Bank_ID VARCHAR(20) NOT NULL,
    PRIMARY KEY (Campaign_ID,Bank_ID),
    FOREIGN KEY (Campaign_ID) REFERENCES Campaign(Campaign_ID),
    FOREIGN KEY (Bank_ID) REFERENCES BloodBanks(BloodBank_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Create Table for Approved Campaigns
    DROP TABLE IF EXISTS Approved_Campaigns;
CREATE TABLE IF NOT EXISTS Approved_Campaigns (
    Campaign_ID VARCHAR(20) NOT NULL  PRIMARY KEY,
    Approved_By VARCHAR(20) NOT NULL,
    Approved_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Remarks VARCHAR(100) NOT NULL,
    FOREIGN KEY (Campaign_ID) REFERENCES Campaign(Campaign_ID),
    FOREIGN KEY (Approved_By) REFERENCES MedicalOfficers(Officer_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Create Table for Rejected Campaigns
DROP TABLE IF EXISTS Rejected_Campaigns;
CREATE TABLE IF NOT EXISTS Rejected_Campaigns (
    Campaign_ID VARCHAR(20) NOT NULL  PRIMARY KEY,
    Rejected_By VARCHAR(20) NOT NULL,
    Rejected_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Remarks VARCHAR(100) NOT NULL,
    FOREIGN KEY (Campaign_ID) REFERENCES Campaign(Campaign_ID),
    FOREIGN KEY (Rejected_By) REFERENCES MedicalOfficers(Officer_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS Blood_Packets;
CREATE TABLE IF NOT EXISTS Blood_Packets (
    Packet_ID VARCHAR(20) NOT NULL  PRIMARY KEY,
    Packed_By VARCHAR(20) NOT NULL,
    BloodGroup VARCHAR(3) NOT NULL,
    Status VARCHAR(50) NOT NULL,
    Stored_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (Packed_By) REFERENCES MedicalOfficers(Officer_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS Accepted_Donations;
CREATE TABLE IF NOT EXISTS Accepted_Donations (
    Donation_ID VARCHAR(20) NOT NULL  PRIMARY KEY,
    Donor_ID VARCHAR(20) NOT NULL,
    Packet_ID VARCHAR(20) NOT NULL,
    Donated_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Retrieved_By VARCHAR(20) NOT NULL,
    In_Time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Out_Time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Verified_By VARCHAR(20) NULL,
    FOREIGN KEY (Donor_ID) REFERENCES Donors(Donor_ID),
    FOREIGN KEY (Packet_ID) REFERENCES Blood_Packets(Packet_ID),
    FOREIGN KEY (Retrieved_By) REFERENCES MedicalOfficers(Officer_ID),
    FOREIGN KEY (Verified_By) REFERENCES MedicalOfficers(Officer_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS Rejected_Donations;
CREATE TABLE IF NOT EXISTS Rejected_Donations (
    Donation_ID VARCHAR(20) NOT NULL  PRIMARY KEY,
    Donor_ID VARCHAR(20) NOT NULL,
    Packet_ID VARCHAR(20) NOT NULL,
    Donated_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Rejected_By VARCHAR(20) NOT NULL,
    Rejected_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Remarks VARCHAR(100) NOT NULL,
    FOREIGN KEY (Donor_ID) REFERENCES Donors(Donor_ID),
    FOREIGN KEY (Packet_ID) REFERENCES Blood_Packets(Packet_ID),
    FOREIGN KEY (Rejected_By) REFERENCES MedicalOfficers(Officer_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS Donor_Reviews;
CREATE TABLE IF NOT EXISTS Donor_Reviews (
    Review_ID VARCHAR(20) NOT NULL  PRIMARY KEY,
    Donor_ID VARCHAR(20) NOT NULL,
    Campaign_ID VARCHAR(20) NOT NULL,
    Reviewed_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Remarks VARCHAR(100) NOT NULL,
    FOREIGN KEY (Donor_ID) REFERENCES Donors(Donor_ID),
    FOREIGN KEY (Campaign_ID) REFERENCES Campaign(Campaign_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Authentication Code
DROP TABLE IF EXISTS Authentication_Code;
CREATE TABLE IF NOT EXISTS Authentication_Code (
    Code_ID VARCHAR(20) NOT NULL  PRIMARY KEY,
    Code VARCHAR(20) NOT NULL,
    Authentication_Method INT NOT NULL,
    Attempts INT NOT NULL DEFAULT 0 CHECK ( Attempts BETWEEN 0 AND 4),
    Created_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Updated_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Create Monthly Report Table
DROP TABLE IF EXISTS Monthly_Reports;
CREATE TABLE IF NOT EXISTS  Monthly_Reports(
    Report_ID VARCHAR(20) NOT NULL  PRIMARY KEY,
    Report_Month VARCHAR(20) NOT NULL,
    Report_Year VARCHAR(20) NOT NULL,
    Report_File VARCHAR(100) NOT NULL,
    Generated_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Generated_By VARCHAR(20) NOT NULL,
    FOREIGN KEY (Generated_By) REFERENCES Managers(Manager_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#Create Table for Yearly Report
DROP TABLE IF EXISTS Yearly_Reports;
CREATE TABLE IF NOT EXISTS  Yearly_Reports(
    Report_ID VARCHAR(20) NOT NULL  PRIMARY KEY,
    Report_Year VARCHAR(20) NOT NULL,
    Report_File VARCHAR(100) NOT NULL,
    Generated_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Generated_By VARCHAR(20) NOT NULL,
    FOREIGN KEY (Generated_By) REFERENCES Managers(Manager_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Create Manager Notification Table
DROP TABLE IF EXISTS Manager_Notifications;
CREATE TABLE IF NOT EXISTS  Manager_Notifications
(
    Notification_ID       VARCHAR(20)  NOT NULL PRIMARY KEY,
    Notification_Type     INT  NOT NULL,
    Notification_State   INT  NOT NULL,
    Target_ID             VARCHAR(20)  NULL,
    Notification_Title    VARCHAR(100) NOT NULL,
    Notification_Message  VARCHAR(100) NOT NULL,
    Notification_Date     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Valid_Until           TIMESTAMP DEFAULT NULL,
    FOREIGN KEY (Target_ID) REFERENCES Managers(Manager_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Create Donor Notification Table
DROP TABLE IF EXISTS Donor_Notifications;
CREATE TABLE IF NOT EXISTS  Donor_Notifications
(
    Notification_ID       VARCHAR(20)  NOT NULL PRIMARY KEY,
    Notification_Type     INT  NOT NULL,
    Notification_State   INT  NOT NULL,
    Target_ID             VARCHAR(20)  NULL,
    Notification_Title    VARCHAR(100) NOT NULL,
    Notification_Message  VARCHAR(100) NOT NULL,
    Notification_Date     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Valid_Until           TIMESTAMP DEFAULT NULL,
    FOREIGN KEY (Target_ID) REFERENCES Donors(Donor_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Create Medical Officer Notification Table
DROP TABLE IF EXISTS Medical_Officer_Notifications;
CREATE TABLE IF NOT EXISTS  Medical_Officer_Notifications
(
    Notification_ID       VARCHAR(20)  NOT NULL PRIMARY KEY,
    Notification_Type     INT  NOT NULL,
    Notification_State   INT  NOT NULL,
    Target_ID             VARCHAR(20)  NULL,
    Notification_Title    VARCHAR(100) NOT NULL,
    Notification_Message  VARCHAR(100) NOT NULL,
    Notification_Date     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Valid_Until           TIMESTAMP DEFAULT NULL,
    FOREIGN KEY (Target_ID) REFERENCES MedicalOfficers(Officer_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Create Organization Notification Table
DROP TABLE IF EXISTS Organization_Notifications;
CREATE TABLE IF NOT EXISTS  Organization_Notifications
(
    Notification_ID       VARCHAR(20)  NOT NULL PRIMARY KEY,
    Notification_Type     INT  NOT NULL,
    Notification_State   INT  NOT NULL,
    Target_ID             VARCHAR(20)  NULL,
    Notification_Title    VARCHAR(100) NOT NULL,
    Notification_Message  VARCHAR(100) NOT NULL,
    Notification_Date     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Valid_Until           TIMESTAMP DEFAULT NULL,
    FOREIGN KEY (Target_ID) REFERENCES Organizations(Organization_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Create Sponsor Notification Table
DROP TABLE IF EXISTS Sponsor_Notifications;
CREATE TABLE IF NOT EXISTS  Sponsor_Notifications
(
    Notification_ID       VARCHAR(20)  NOT NULL PRIMARY KEY,
    Notification_Type     INT  NOT NULL,
    Notification_State   INT  NOT NULL,
    Target_ID             VARCHAR(20)  NULL,
    Notification_Title    VARCHAR(100) NOT NULL,
    Notification_Message  VARCHAR(100) NOT NULL,
    Notification_Date     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Valid_Until           TIMESTAMP DEFAULT NULL,
    FOREIGN KEY (Target_ID) REFERENCES Sponsors(Sponsor_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Create Admin Notification Table
DROP TABLE IF EXISTS Admin_Notifications;
CREATE TABLE IF NOT EXISTS  Admin_Notifications
(
    Notification_ID       VARCHAR(20)  NOT NULL PRIMARY KEY,
    Notification_Type     INT  NOT NULL,
    Notification_State   INT  NOT NULL,
    Target_ID             VARCHAR(20)  NULL,
    Notification_Title    VARCHAR(100) NOT NULL,
    Notification_Message  VARCHAR(100) NOT NULL,
    Notification_Date     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Valid_Until           TIMESTAMP DEFAULT NULL,
    FOREIGN KEY (Target_ID) REFERENCES Admins(Admin_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Create Table for Logging Sessions
DROP TABLE IF EXISTS Logging_History;
CREATE TABLE IF NOT EXISTS Logging_History(
    Session_ID VARCHAR(20) PRIMARY KEY ,
    User_ID VARCHAR(20) NOT NULL ,
    Session_Start TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    Session_End TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NULL,
    Session_End_Type INT DEFAULT 0,
    FOREIGN KEY (User_ID) REFERENCES Users(UID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


