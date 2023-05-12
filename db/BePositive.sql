DROP database IF EXISTS bepositive;
CREATE DATABASE IF NOT EXISTS `bepositive` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
use bepositive;

DROP TABLE IF EXISTS Users;
CREATE TABLE IF NOT EXISTS Users
(
    UID            VARCHAR(20) PRIMARY KEY,
    Email          VARCHAR(100) UNIQUE,
    Password       VARCHAR(100) NOT NULL,
    Account_Status INT          NOT NULL DEFAULT 0,
    Role           VARCHAR(100) NOT NULL DEFAULT 'Donor',
    Created_At     TIMESTAMP             DEFAULT CURRENT_TIMESTAMP,
    Updated_At     TIMESTAMP             DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    Security_Level INT          NOT NULL DEFAULT 0
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS BloodBanks;
CREATE TABLE IF NOT EXISTS BloodBanks
(
    BloodBank_ID   VARCHAR(20)  NOT NULL PRIMARY KEY,
    BankName       VARCHAR(100) NOT NULL,
    Address1       VARCHAR(100) NOT NULL,
    Address2       VARCHAR(100) NOT NULL,
    City           VARCHAR(100) NOT NULL,
    Telephone_No   VARCHAR(100) UNIQUE,
    No_Of_Doctors  INT          NOT NULL DEFAULT 0,
    No_Of_Nurses   INT          NOT NULL DEFAULT 0,
    No_Of_Beds     INT          NOT NULL DEFAULT 0,
    No_Of_Storages INT          NOT NULL DEFAULT 0,
    Type           INT          NOT NULL DEFAULT 2
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS MedicalOfficers;
CREATE TABLE IF NOT EXISTS MedicalOfficers
(
    Officer_ID          VARCHAR(20) PRIMARY KEY,
    First_Name          VARCHAR(100) NOT NULL,
    Last_Name           VARCHAR(100) NOT NULL,
    Address1            VARCHAR(100) NOT NULL,
    Address2            VARCHAR(100) NOT NULL,
    Contact_No          VARCHAR(12)  NOT NULL,
    City                VARCHAR(100) NOT NULL,
    Email               VARCHAR(100) UNIQUE,
    Gender              VARCHAR(10)  NOT NULL,
    Nationality         VARCHAR(100) NOT NULL,
    NIC                 VARCHAR(12) UNIQUE,
    Position            VARCHAR(20)           DEFAULT 'Nurse',
    Registration_Number VARCHAR(20) UNIQUE NOT NULL ,
    Registration_Date   TIMESTAMP  NOT NULL DEFAULT CURRENT_TIMESTAMP,
    Status              INT          NOT NULL DEFAULT 1,
    Joined_At           TIMESTAMP             DEFAULT CURRENT_TIMESTAMP,
    Branch_ID           VARCHAR(20)  NOT NULL,
    Profile_Image       VARCHAR(100) NOT NULL DEFAULT '/public/upload/profile/medicalOfficerDefault.png',
    FOREIGN KEY (Branch_ID) REFERENCES BloodBanks (BloodBank_ID)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS Managers;
CREATE TABLE IF NOT EXISTS Managers
(
    Manager_ID    VARCHAR(20) PRIMARY KEY,
    First_Name    VARCHAR(100) NOT NULL,
    Last_Name     VARCHAR(100) NOT NULL,
    Address1      VARCHAR(100) NOT NULL,
    Address2      VARCHAR(100) NOT NULL,
    City          VARCHAR(100) NOT NULL,
    Contact_No    VARCHAR(12)  NOT NULL,
    Email         VARCHAR(100) UNIQUE,
    Status        INT          NOT NULL DEFAULT 0,
    Joined_At     TIMESTAMP             DEFAULT CURRENT_TIMESTAMP,
    BloodBank_ID  VARCHAR(20)  NOT NULL,
    Profile_Image VARCHAR(100) NOT NULL DEFAULT '/public/upload/profile/managerDefault.png',
    FOREIGN KEY (BloodBank_ID) REFERENCES BloodBanks (BloodBank_ID),
    FOREIGN KEY (Manager_ID) REFERENCES Users (UID)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS Admins;
CREATE TABLE IF NOT EXISTS Admins
(
    Admin_ID      VARCHAR(20) PRIMARY KEY,
    UserName      VARCHAR(100) NOT NULL,
    Email         VARCHAR(100) NOT NULL,
    Profile_Image VARCHAR(100) NOT NULL DEFAULT '/public/upload/profile/adminDefault.png',
    FOREIGN KEY (Admin_ID) REFERENCES Users (UID)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS Donors;
CREATE TABLE IF NOT EXISTS Donors
(
    Donor_ID              VARCHAR(20) PRIMARY KEY,
    First_Name            VARCHAR(100) NOT NULL,
    Last_Name             VARCHAR(100) NOT NULL,
    Address1              VARCHAR(100) NOT NULL,
    Address2              VARCHAR(100) NOT NULL,
    City                  VARCHAR(100) NOT NULL,
    Nearest_Bank          VARCHAR(20)  NOT NULL,
    Contact_No            VARCHAR(12)  NOT NULL,
    Email                 VARCHAR(100) UNIQUE,
    Nationality           VARCHAR(100) NOT NULL DEFAULT 'SINHALA',
    NIC                   VARCHAR(12) UNIQUE,
    Gender                VARCHAR(1)   NOT NULL CHECK ( Gender IN ('F', 'M')),
    NIC_Front             VARCHAR(100) NULL,
    NIC_Back              VARCHAR(100) NULL,
    BloodGroup            VARCHAR(7)   NOT NULL CHECK ( BloodGroup IN ('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-','Unknown')),
    BloodDonation_Book_1  VARCHAR(100) NULL,
    BloodDonation_Book_2  VARCHAR(100) NULL,
    Status                VARCHAR(50)  NOT NULL,
    Donation_Availability INT          NOT NULL DEFAULT 1,
    Donation_Availability_Date DATE NULL ,
    Verified              INT          NOT NULL DEFAULT 1,
    Verified_At           TIMESTAMP    NULL,
    Verified_By           VARCHAR(20)  NULL,
    Verification_Remarks  VARCHAR(100) NULL,
    Created_At            TIMESTAMP             DEFAULT CURRENT_TIMESTAMP,
    Updated_At            TIMESTAMP             DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    Profile_Image         VARCHAR(100) NOT NULL DEFAULT '/public/upload/profile/donorDefault.png',
    FOREIGN KEY (Nearest_Bank) REFERENCES BloodBanks (BloodBank_ID),
    FOREIGN KEY (Verified_By) REFERENCES MedicalOfficers (Officer_ID)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS Hospitals;
CREATE TABLE IF NOT EXISTS Hospitals
(
    Hospital_ID   VARCHAR(20)  NOT NULL PRIMARY KEY,
    Hospital_Name VARCHAR(100) NOT NULL,
    Address1      VARCHAR(100) NOT NULL,
    Address2      VARCHAR(100) NOT NULL,
    Email         VARCHAR(100) UNIQUE,
    City          VARCHAR(100) NOT NULL,
    Contact_No    VARCHAR(100) UNIQUE,
    Nearest_Blood_Bank VARCHAR(20) NOT NULL,
    Type          INT          NOT NULL DEFAULT 1,
    Profile_Image VARCHAR(100) NOT NULL DEFAULT '/public/upload/profile/hospitalDefault.png',
    FOREIGN KEY (Hospital_ID) REFERENCES Users (UID),
    FOREIGN KEY (Nearest_Blood_Bank) REFERENCES BloodBanks (BloodBank_ID)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS Organizations;
CREATE TABLE IF NOT EXISTS Organizations
(
    Organization_ID    VARCHAR(20)  NOT NULL PRIMARY KEY,
    Organization_Name  VARCHAR(100) NOT NULL,
    Address1           VARCHAR(100) NOT NULL,
    Address2           VARCHAR(100) NOT NULL,
    Organization_Email VARCHAR(100) UNIQUE,
    Contact_No         VARCHAR(100) NOT NULL,
    City               VARCHAR(100) NOT NULL,
    Status             VARCHAR(50)  NOT NULL,
    Verified_By        VARCHAR(20)  NULL,
    Verified_At        TIMESTAMP    NULL,
    Profile_Image      VARCHAR(100) NOT NULL DEFAULT '/public/upload/organization.png',
    Created_At         TIMESTAMP             DEFAULT CURRENT_TIMESTAMP,
    Updated_At         TIMESTAMP             DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (Organization_ID) REFERENCES Users (UID),
    FOREIGN KEY (Verified_By) REFERENCES MedicalOfficers (Officer_ID)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


DROP TABLE IF EXISTS Sponsors;
CREATE TABLE IF NOT EXISTS Sponsors
(
    Sponsor_ID    VARCHAR(20)  NOT NULL PRIMARY KEY,
    Sponsor_Name  VARCHAR(100) NOT NULL,
    Email         VARCHAR(100) UNIQUE,
    Address1      VARCHAR(100) NOT NULL,
    Address2      VARCHAR(100) NOT NULL,
    City          VARCHAR(100) NOT NULL,
    Status        VARCHAR(50)  NOT NULL,
    Contact_No    VARCHAR(100) UNIQUE,
    Created_At    TIMESTAMP             DEFAULT CURRENT_TIMESTAMP,
    Updated_At    TIMESTAMP             DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    Profile_Image VARCHAR(100) NOT NULL DEFAULT '/public/upload/sponsorDefault.png',
    FOREIGN KEY (Sponsor_ID) REFERENCES Users (UID)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;



DROP TABLE IF EXISTS Medical_Team;
CREATE TABLE IF NOT EXISTS  Medical_Team
(
    Team_ID      VARCHAR(20)  NOT NULL PRIMARY KEY,
    Campaign_ID  VARCHAR(20)  NOT NULL,
    Team_Leader  VARCHAR(20)  NULL,
    No_Of_Member INT NOT NULL DEFAULT 0,
    Assigned_By VARCHAR(20) NOT NULL ,
    Assigned_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (Assigned_By) REFERENCES Managers(Manager_ID),
    FOREIGN KEY (Team_Leader) REFERENCES MedicalOfficers (Officer_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


# Status 1 - Pending 2- Approved 3- Rejected
# Verified 1 - Yes 2 - No
DROP TABLE IF EXISTS Campaign;
CREATE TABLE IF NOT EXISTS Campaign
(
    Campaign_ID          VARCHAR(20)  NOT NULL PRIMARY KEY,
    Campaign_Name        VARCHAR(100) NOT NULL,
    Organization_ID      VARCHAR(20)  NOT NULL,
    Campaign_Description VARCHAR(300) NOT NULL,
    Campaign_Date        DATE         NOT NULL,
    Venue                VARCHAR(100) NOT NULL,
    Nearest_City         VARCHAR(100) NOT NULL,
    Status               INT          NOT NULL CHECK ( Status Between 1 AND 5),
    Latitude             VARCHAR(100) NOT NULL,
    Longitude            VARCHAR(100) NOT NULL,
    Nearest_BloodBank    VARCHAR(20)  NOT NULL,
    Verified             INT          NOT NULL DEFAULT 1 CHECK ( Verified BETWEEN 1 AND 3),
    Expected_Amount      VARCHAR(20)  NULL,
    Created_At           TIMESTAMP             DEFAULT CURRENT_TIMESTAMP,
    Updated_At           TIMESTAMP             DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (Nearest_BloodBank) REFERENCES BloodBanks (BloodBank_ID),
    FOREIGN KEY (Organization_ID) REFERENCES Organizations (Organization_ID)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;


# Create Table for Approved Campaigns
DROP TABLE IF EXISTS Approved_Campaigns;
CREATE TABLE IF NOT EXISTS Approved_Campaigns (
                                                  Campaign_ID VARCHAR(20) NOT NULL  PRIMARY KEY,
                                                  Approved_By VARCHAR(20) NOT NULL,
                                                  Approved_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                                  Remarks VARCHAR(100) NOT NULL,
                                                  FOREIGN KEY (Campaign_ID) REFERENCES Campaign(Campaign_ID),
                                                  FOREIGN KEY (Approved_By) REFERENCES Managers(Manager_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Create Table for Rejected Campaigns
DROP TABLE IF EXISTS Rejected_Campaigns;
CREATE TABLE IF NOT EXISTS Rejected_Campaigns (
                                                  Campaign_ID VARCHAR(20) NOT NULL  PRIMARY KEY,
                                                  Rejected_By VARCHAR(20) NOT NULL,
                                                  Rejected_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                                  Remarks VARCHAR(100) NOT NULL,
                                                  FOREIGN KEY (Campaign_ID) REFERENCES Campaign(Campaign_ID),
                                                  FOREIGN KEY (Rejected_By) REFERENCES Managers(Manager_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS Campaign_Donation_Queue;
CREATE TABLE IF NOT EXISTS Campaign_Donation_Queue(
                                                      Donor_ID VARCHAR(20) NOT NULL,
                                                      Campaign_ID VARCHAR(20) NOT NULL,
                                                      Donor_Status INT NOT NULL CHECK ( Donor_Status BETWEEN 1 AND 5),
                                                      Last_Update TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                                      PRIMARY KEY (Donor_ID, Campaign_ID),
                                                      FOREIGN KEY (Donor_ID) REFERENCES Donors(Donor_ID),
                                                      FOREIGN KEY (Campaign_ID) REFERENCES Campaign(Campaign_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS Donor_Health_Checkup;
CREATE TABLE IF NOT EXISTS Donor_Health_Checkup
(
    Donor_ID                 VARCHAR(20)  NOT NULL,
    Campaign_ID              VARCHAR(20)  NOT NULL,
    GoodHealth               INT          NOT NULL CHECK ( GoodHealth BETWEEN 1 AND 2),
    Diseases                 VARCHAR(100) NULL,
    Vaccinated               INT          NOT NULL CHECK ( Vaccinated BETWEEN 1 AND 2),
    Tattooed                 INT          NOT NULL CHECK ( Tattooed BETWEEN 1 AND 2),
    Pierced                  INT          NOT NULL CHECK ( Pierced BETWEEN 1 AND 2),
    Pregnant                 INT          NOT NULL CHECK ( Pregnant BETWEEN 1 AND 2),
    Prisoned                 INT          NOT NULL CHECK ( Prisoned BETWEEN 1 AND 2),
    Donated_To_Partner       INT          NOT NULL CHECK ( Donated_To_Partner BETWEEN 1 AND 2),
    Went_Abroad              INT          NOT NULL CHECK ( Went_Abroad BETWEEN 1 AND 2),
    Malaria_Infected         INT          NOT NULL CHECK ( Malaria_Infected BETWEEN 1 AND 2),
    Dengue_Infected          INT          NOT NULL CHECK ( Dengue_Infected BETWEEN 1 AND 2),
    CFever_Infected          INT          NOT NULL CHECK ( CFever_Infected BETWEEN 1 AND 2),
    Teeth_Removed            INT          NOT NULL CHECK ( Teeth_Removed BETWEEN 1 AND 2),
    Antibiotics_And_Aspirins INT          NOT NULL CHECK ( Antibiotics_And_Aspirins BETWEEN 1 AND 2),
    Eligible                 INT          NOT NULL CHECK ( Eligible BETWEEN 1 AND 2),
    Recommendation          INT         NOT NULL CHECK ( Recommendation BETWEEN 1 AND 2),
    Recommend_By             VARCHAR(20)  NULL,
    Remarks                  VARCHAR(100) NULL,
    FOREIGN KEY (Donor_ID) REFERENCES Donors (Donor_ID),
    FOREIGN KEY (Recommend_By) REFERENCES MedicalOfficers (Officer_ID),
    FOREIGN KEY (Campaign_ID) REFERENCES Campaign (Campaign_ID),
    PRIMARY KEY (Donor_ID, Campaign_ID)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS Donor_Report;
CREATE TABLE IF NOT EXISTS `Donor_Report` (
                                `Donor_ID` varchar(20) NOT NULL,
                                `Blood_Group` varchar(10) NOT NULL,
                                `Weight` decimal(10,0) NOT NULL,
                                `Remarks` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS Email;
CREATE TABLE IF NOT EXISTS Email
(
    Email_ID     VARCHAR(20) PRIMARY KEY,
    Receiver     VARCHAR(100) NOT NULL,
    Sender       VARCHAR(20)  NOT NULL,
    Email_Type   INT          NOT NULL,
    Attachment   VARCHAR(100) NULL,
    Subject      VARCHAR(100) NOT NULL,
    Body         TEXT         NOT NULL,
    Email_Status INT          NOT NULL DEFAULT 0,
    Created_At   TIMESTAMP             DEFAULT CURRENT_TIMESTAMP,
    Updated_At   TIMESTAMP             DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS Password_Reset;
CREATE TABLE IF NOT EXISTS Password_Reset(
    UID            VARCHAR(20) PRIMARY KEY,
    Token          VARCHAR(100) NOT NULL,
    Email          VARCHAR(100) NOT NULL,
    Created_At     TIMESTAMP             DEFAULT CURRENT_TIMESTAMP,
    Status         INT          NOT NULL DEFAULT 0,
    Device_IP      VARCHAR(100) NOT NULL,
    Lifetime       INT          NOT NULL DEFAULT 60,
    Reset_At       TIMESTAMP        NULL DEFAULT NULL,
    FOREIGN KEY (UID) REFERENCES Users (UID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS Password_Reset_Audit;
CREATE TABLE Password_Reset_Audit(
                                     UID            VARCHAR(20) ,
                                     Token          VARCHAR(100) NOT NULL,
                                     Email          VARCHAR(100) NOT NULL,
                                     Created_At     TIMESTAMP             DEFAULT CURRENT_TIMESTAMP,
                                     Reset_At       TIMESTAMP        NULL DEFAULT NULL,
                                     Device_IP      VARCHAR(100) NOT NULL,
                                     Status         INT          NOT NULL DEFAULT 0,
                                     FOREIGN KEY (UID) REFERENCES Users (UID),
                                     PRIMARY KEY (UID, Token)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


DROP TABLE IF EXISTS Blood_Packets;
CREATE TABLE IF NOT EXISTS Blood_Packets
(
    Packet_ID   VARCHAR(20)  NOT NULL PRIMARY KEY,
    Donation_ID VARCHAR(20)  NOT NULL,
    Packed_By   VARCHAR(20)  NOT NULL,
    BloodGroup  VARCHAR(3)   NOT NULL,
    Status      VARCHAR(50)  NOT NULL,
    Remarks     VARCHAR(100) NULL,
    Stored_At   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (Packed_By) REFERENCES MedicalOfficers (Officer_ID)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS OTP_Code;
CREATE TABLE IF NOT EXISTS OTP_Code
(
    UserID         VARCHAR(20),
    Code           VARCHAR(6)   NOT NULL,
    Type           INT          NOT NULL DEFAULT 0,
    Target         VARCHAR(100) NOT NULL,
    Attempts       INT          NOT NULL DEFAULT 0,
    Total_Attempts INT          NOT NULL DEFAULT 0,
    Status         INT          NOT NULL DEFAULT 0,
    Expired_At     TIMESTAMP    NULL,
    Verified_At    TIMESTAMP    NULL,
    Created_At     TIMESTAMP             DEFAULT CURRENT_TIMESTAMP,
    Updated_At     TIMESTAMP    NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (UserID, Code),
    FOREIGN KEY (UserID) REFERENCES Users (UID)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS OTP_CODE_Audit;
CREATE TABLE IF NOT EXISTS OTP_CODE_Audit
(
    UserID             VARCHAR(20),
    Code               VARCHAR(6)   NOT NULL,
    Target             VARCHAR(100) NOT NULL,
    Total_Attempts     INT          NOT NULL DEFAULT 0,
    Verified_At        DATE         NULL,
    ReGenerated_At     TIMESTAMP    NULL,
    No_Of_Regeneration INT          NOT NULL DEFAULT 0 CHECK ( No_Of_Regeneration BETWEEN 0 AND 10),
    Activity           INT                   DEFAULT 0,
    Suspicious         INT                   DEFAULT 0,
    PRIMARY KEY (UserID, Code),
    FOREIGN KEY (UserID) REFERENCES Users (UID)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TRIGGER IF EXISTS OTP_CODE_Audit_ReGenerate_Amount;



DROP TABLE IF EXISTS Blocked_Users;
CREATE TABLE IF NOT EXISTS Blocked_Users
(
    UID        VARCHAR(20) PRIMARY KEY,
    Blocked_At TIMESTAMP NOT NULL,
    Type       INT       NOT NULL,
    FOREIGN KEY (UID) REFERENCES Users (UID)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


# Create Table for Blood Group
DROP TABLE IF EXISTS BloodGroups;
CREATE TABLE IF NOT EXISTS BloodGroups
(
    BloodGroup_ID   VARCHAR(20) PRIMARY KEY,
    BloodGroup_Name VARCHAR(100) NOT NULL UNIQUE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


# Create Table for Accepted Requests
DROP TABLE IF EXISTS Attendance_Accepted_Requests;
CREATE TABLE IF NOT EXISTS Attendance_Accepted_Requests
(
    Request_ID  VARCHAR(20) NOT NULL PRIMARY KEY,
    Donor_ID    VARCHAR(20) NOT NULL,
    Campaign_ID VARCHAR(20) NOT NULL,
    Accepted_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (Donor_ID) REFERENCES Donors (Donor_ID),
    FOREIGN KEY (Campaign_ID) REFERENCES Campaign (Campaign_ID)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS Blood_Requests;
CREATE TABLE IF NOT EXISTS Blood_Requests (
    Request_ID VARCHAR(20) NOT NULL  PRIMARY KEY,
    Requested_By VARCHAR(20) NOT NULL,
    BloodGroup VARCHAR(3) NOT NULL,
    Requested_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Request_From VARCHAR(20) NOT NULL,
    Type INT NOT NULL DEFAULT 1,
    Volume DECIMAL(10,2) NOT NULL CHECK ( Volume BETWEEN 0 AND 1000),
    Status INT NOT NULL DEFAULT 1,
    Action INT NOT NULL DEFAULT 1,
    Remarks VARCHAR(100) NULL,
    FullFilled_By VARCHAR(20) NULL,
    FOREIGN KEY (Requested_By) REFERENCES Hospitals(Hospital_ID),
    FOREIGN KEY (BloodGroup) REFERENCES BloodGroups(BloodGroup_ID),
    FOREIGN KEY (Request_From) REFERENCES BloodBanks(BloodBank_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS Hospital_Blood_Donations;
CREATE TABLE IF NOT EXISTS Hospital_Blood_Donations
(
    Donation_ID VARCHAR(20) NOT NULL PRIMARY KEY,
    Donor_ID    VARCHAR(20) NOT NULL,
    Request_ID  VARCHAR(20) NOT NULL,
    Donation_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Volume      DECIMAL(10,2) NOT NULL CHECK ( Volume BETWEEN 0 AND 1000),
    FOREIGN KEY (Request_ID) REFERENCES Blood_Requests (Request_ID),
    FOREIGN KEY (Donor_ID) REFERENCES Donors (Donor_ID)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

# Create Table for Organization Members
DROP TABLE IF EXISTS Organization_Members;
CREATE TABLE IF NOT EXISTS Organization_Members
(
    Organization_ID VARCHAR(20)  NOT NULL,
    Name            VARCHAR(100) NOT NULL,
    Contact_No      VARCHAR(100) UNIQUE ,
    NIC             VARCHAR(100) UNIQUE,
    Position        VARCHAR(100) NOT NULL,
    Email           VARCHAR(100) UNIQUE ,
    PRIMARY KEY (Organization_ID, NIC),
    FOREIGN KEY (Organization_ID) REFERENCES Organizations (Organization_ID)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


# Create Table for Team Members
DROP TABLE IF EXISTS Team_Members;
CREATE TABLE IF NOT EXISTS Team_Members
(
    Team_ID VARCHAR(20) NOT NULL,
    Member_ID VARCHAR(20) NOT NULL,
    Position VARCHAR(100) NOT NULL DEFAULT 'Member',
    Task INT NOT NULL DEFAULT 1,
    PRIMARY KEY (Team_ID, Member_ID),
    FOREIGN KEY (Team_ID) REFERENCES Medical_Team (Team_ID),
    FOREIGN KEY (Member_ID) REFERENCES MedicalOfficers (Officer_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Create Table for Campaigns


DROP TABLE IF EXISTS Inform_Donors;
CREATE TABLE IF NOT EXISTS `Inform_Donors`
(
    `Message_ID`  varchar(255) NOT NULL,
    `Message`     varchar(255) NOT NULL,
    `Type`        int(11)      NOT NULL,
    `Status`      int(11)      NOT NULL,
    `Date`        timestamp    NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    `Campaign_ID` varchar(255) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS Donor_Blood_Check;
CREATE TABLE IF NOT EXISTS Donor_Blood_Check
(
    Donor_ID           VARCHAR(20)   NOT NULL,
    Campaign_ID        VARCHAR(20)   NOT NULL,
    BloodGroup         VARCHAR(10)   NOT NULL,
    Hemoglobin_Level   DECIMAL(4, 2) NOT NULL,
    Blood_Pressure     DECIMAL(4, 2) NOT NULL,
    Weight             DECIMAL(4, 2) NOT NULL,
    Pulse_Rate         DECIMAL(5, 2) NOT NULL,
    Temperature        DECIMAL(5, 2) NOT NULL,
    Infection_Diseases VARCHAR(100)  NOT NULL DEFAULT 'None',
    Antibodies         INT           NOT NULL CHECK ( Antibodies BETWEEN 1 AND 2),
    Iron_Level         DECIMAL(4, 2) NOT NULL,
    Eligible           INT           NOT NULL CHECK ( Eligible BETWEEN 1 AND 2),
    Remarks            VARCHAR(100)  NULL,
    Checked_At         TIMESTAMP              DEFAULT CURRENT_TIMESTAMP,
    Checked_By         VARCHAR(20)   NOT NULL,
    PRIMARY KEY (Donor_ID, Campaign_ID),
    FOREIGN KEY (Donor_ID) REFERENCES Donors (Donor_ID),
    FOREIGN KEY (Campaign_ID) REFERENCES Campaign(Campaign_ID),
    FOREIGN KEY (Checked_By) REFERENCES MedicalOfficers(Officer_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Create Table for Donations
DROP TABLE IF EXISTS Donations;
CREATE TABLE IF NOT EXISTS Donations(
    Donation_ID VARCHAR(20) NOT NULL,
    Campaign_ID VARCHAR(20) NOT NULL,
    Donor_ID VARCHAR(20) NOT NULL,
    Start_At TIMESTAMP NOT NULL,
    End_At TIMESTAMP NULL,
    Officer_ID VARCHAR(20) NOT NULL,
    Status INT NOT NULL CHECK ( Status BETWEEN 1 AND 5),
    PRIMARY KEY (Donation_ID, Donor_ID, Campaign_ID),
    FOREIGN KEY (Donor_ID) REFERENCES Donors(Donor_ID),
    FOREIGN KEY (Campaign_ID) REFERENCES Campaign(Campaign_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS Aborted_Donations;
CREATE TABLE IF NOT EXISTS Aborted_Donations(
    Donation_ID VARCHAR(20) NOT NULL,
    Donor_ID VARCHAR(20) NOT NULL,
    Campaign_ID VARCHAR(20) NOT NULL,
    Reason VARCHAR(100) NOT NULL,
    Remarks VARCHAR(100) NULL,
    Started_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Aborted_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Aborted_By VARCHAR(20) NOT NULL,
    PRIMARY KEY (Donation_ID, Donor_ID, Campaign_ID),
    FOREIGN KEY (Donor_ID) REFERENCES Donors(Donor_ID),
    FOREIGN KEY (Campaign_ID) REFERENCES Campaign(Campaign_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS Campaign_Request;
CREATE TABLE IF NOT EXISTS Campaign_Request (
    Campaign_ID VARCHAR(20) NOT NULL,
    Organization_ID VARCHAR(20) NOT NULL,
    BloodBank_ID VARCHAR(20),
    FOREIGN KEY (Campaign_ID) REFERENCES Campaign(Campaign_ID),
    FOREIGN KEY (Organization_ID) REFERENCES Organizations(Organization_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS Campaign_Statistics;
CREATE TABLE IF NOT EXISTS Campaign_Statistics (
    Campaign_ID VARCHAR(20) NOT NULL,
    No_of_Registers INT NOT NULL DEFAULT 0,
    No_Of_Campaign_Registers INT NOT NULL DEFAULT 0,
    No_Of_Health_Checks INT NOT NULL DEFAULT 0,
    No_Of_Blood_Checks INT NOT NULL DEFAULT 0,
    No_Of_Successful_Donations INT NOT NULL DEFAULT 0,
    No_Of_Aborted_Donations INT NOT NULL DEFAULT 0,
    FOREIGN KEY (Campaign_ID) REFERENCES Campaign(Campaign_ID),
    PRIMARY KEY (Campaign_ID)
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
    Volume DECIMAL(4, 2) NOT NULL,
    Verified_By VARCHAR(20) NULL,
    FOREIGN KEY (Donation_ID) REFERENCES Donations(Donation_ID),
    FOREIGN KEY (Donor_ID) REFERENCES Donors(Donor_ID),
    FOREIGN KEY (Packet_ID) REFERENCES Blood_Packets(Packet_ID),
    FOREIGN KEY (Retrieved_By) REFERENCES MedicalOfficers(Officer_ID),
    FOREIGN KEY (Verified_By) REFERENCES MedicalOfficers(Officer_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS Rejected_Donations;
CREATE TABLE IF NOT EXISTS Rejected_Donations (
    Donation_ID VARCHAR(20) NOT NULL  PRIMARY KEY,
    Donor_ID VARCHAR(20) NOT NULL,
    Donated_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Campaign_ID VARCHAR(20) NOT NULL,
    Rejected_By VARCHAR(20) NOT NULL,
    Rejected_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Reason INT NOT NULL,
    OtherReason VARCHAR(255) NULL ,
    Type INT NOT NULL CHECK ( Type BETWEEN 1 AND 6), # TODO Change This to 5
    FOREIGN KEY (Donation_ID) REFERENCES Donations(Donation_ID),
    FOREIGN KEY (Donor_ID) REFERENCES Donors(Donor_ID),
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
    Notification_Status   INT  NOT NULL,
    Target_ID             VARCHAR(20)  NULL,
    Notification_Title    VARCHAR(100) NOT NULL,
    Notification_Message  VARCHAR(100) NOT NULL,
    Notification_Date     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Valid_Until           TIMESTAMP NULL,
    FOREIGN KEY (Target_ID) REFERENCES Managers(Manager_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
# Create Title Table



# Create Donor Notification Table
DROP TABLE IF EXISTS Donor_Notifications;
CREATE TABLE IF NOT EXISTS  Donor_Notifications
(
    Notification_ID       VARCHAR(20)  NOT NULL PRIMARY KEY,
    Notification_Type     INT  NOT NULL,
    Notification_State   INT  NOT NULL,
    Target_ID             VARCHAR(20)  NULL,
    Target_Group            VARCHAR(20) NULL    ,
    Notification_Title    VARCHAR(100) NOT NULL,
    Notification_Message  VARCHAR(100) NOT NULL,
    Notification_Date     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Valid_Until           TIMESTAMP NULL,
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
    Valid_Until           TIMESTAMP NULL,
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
    Valid_Until           TIMESTAMP NULL,
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
    Valid_Until           TIMESTAMP NULL,
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
    Valid_Until           TIMESTAMP NULL,
    FOREIGN KEY (Target_ID) REFERENCES Admins(Admin_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Create Table for Logging Sessions
DROP TABLE IF EXISTS Logging_History;
CREATE TABLE IF NOT EXISTS Logging_History
(
    Session_ID       VARCHAR(20) PRIMARY KEY,
    User_ID          VARCHAR(20)                           NOT NULL,
    Session_Start    TIMESTAMP DEFAULT CURRENT_TIMESTAMP   NOT NULL,
    Session_End      TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NULL,
    Session_End_Type INT       DEFAULT 0,
    FOREIGN KEY (User_ID) REFERENCES Users (UID)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS Donation_Campaigns;
CREATE TABLE IF NOT EXISTS Donation_Campaigns
(
    Campaign_ID      VARCHAR(20) PRIMARY KEY,
    Organization_ID  VARCHAR(20) NOT NULL,
    Campaign_Name    VARCHAR(100) NOT NULL,
    Campaign_Date    DATE NOT NULL,
    Nearest_Blood_Bank VARCHAR(20) NOT NULL,
    Venue            VARCHAR(100) NOT NULL,
    Status           INT NOT NULL,
    FOREIGN KEY (Organization_ID) REFERENCES Organizations (Organization_ID),
    FOREIGN KEY (Nearest_Blood_Bank) REFERENCES BloodBanks (BloodBank_ID)
);
DROP TABLE IF EXISTS Blogs;
CREATE TABLE Blogs (
                       Blog_ID VARCHAR(20) PRIMARY KEY ,
                       Blog_Title VARCHAR(100) NOT NULL ,
                       Blog_Content TEXT NOT NULL ,
                       Blog_Date DATE NOT NULL ,
                       Blog_Status INT NOT NULL ,
                       Blog_Image VARCHAR(100) NOT NULL
) engine=innodb default charset=utf8;

DROP TABLE IF EXISTS Register_OTP;
CREATE TABLE IF NOT EXISTS Register_OTP
(
    Email      VARCHAR(100) PRIMARY KEY,
    OTP        VARCHAR(20) NOT NULL,
    Created_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    Updated_At TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NULL,
    No_Of_Attempts INT DEFAULT 0 NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS Organization_Bank_Accounts;
CREATE TABLE IF NOT EXISTS Organization_Bank_Accounts
(
    Organization_ID VARCHAR(20) NOT NULL,
    Account_Name    VARCHAR(100) NOT NULL,
    Account_Number  VARCHAR(100) NOT NULL UNIQUE ,
    Bank_Name       VARCHAR(100) NOT NULL,
    Branch_Name     VARCHAR(100) NOT NULL,
    PRIMARY KEY (Organization_ID),
    FOREIGN KEY (Organization_ID) REFERENCES Organizations (Organization_ID)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


DROP TABLE IF EXISTS Sponsorship_Requests;
CREATE TABLE IF NOT EXISTS Sponsorship_Requests
(
    Sponsorship_ID VARCHAR(20) PRIMARY KEY,
    Campaign_ID VARCHAR(20) NOT NULL UNIQUE ,
    Sponsorship_Amount INT NOT NULL,
    Sponsorship_Status INT NOT NULL DEFAULT 1,
    Report VARCHAR(100) NOT NULL,
    Sponsorship_Date DATE NOT NULL DEFAULT CURRENT_DATE,
    Description VARCHAR(100) NOT NULL,
    Transferred INT NULL,
    Transferred_At TIMESTAMP NULL,
    Managed_By VARCHAR(20) NULL,
    Managed_At TIMESTAMP NULL,
    FOREIGN KEY (Managed_By) REFERENCES Managers (Manager_ID),
    FOREIGN KEY (Campaign_ID) REFERENCES Campaign (Campaign_ID)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS campaigns_sponsors;
CREATE TABLE IF NOT EXISTS campaigns_sponsors
(
    Sponsorship_ID VARCHAR(20) NOT NULL,
    Sponsor_ID VARCHAR(20) NOT NULL,
    Description VARCHAR(100) NOT NULL,
    Sponsored_Amount INT NOT NULL,
    Session_ID VARCHAR(255) NOT NULL,
    Status INT NOT NULL DEFAULT 1,
    Sponsored_At TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (Sponsorship_ID, Sponsor_ID,Sponsored_At),
    FOREIGN KEY (Sponsorship_ID) REFERENCES Sponsorship_Requests (Sponsorship_ID)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `Manager_Notices`;
CREATE TABLE IF NOT EXISTS `Manager_Notices` (
  Notice_ID VARCHAR(20) NOT NULL PRIMARY KEY,
    Manager_ID VARCHAR(20) NOT NULL,
    Notice_Title VARCHAR(100) NOT NULL,
    Notice_Content TEXT NOT NULL,
    Notice_Date DATE NOT NULL,
    Notice_Status INT NOT NULL,
    Notice_Action INT NOT NULL,
    FOREIGN KEY (Manager_ID) REFERENCES Managers (Manager_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `Reported_Campaigns`;
CREATE TABLE IF NOT EXISTS `Reported_Campaigns` (
    Campaign_ID VARCHAR(20) NOT NULL,
    Report_Reason INT NOT NULL,
    Report_Description VARCHAR(100) NULL,
    Reported_By VARCHAR(20) NOT NULL,
    Reported_At TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (Campaign_ID, Reported_By),
    FOREIGN KEY (Campaign_ID) REFERENCES Campaign (Campaign_ID),
    FOREIGN KEY (Reported_By) REFERENCES MedicalOfficers(Officer_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `Reported_Organization`;
CREATE TABLE IF NOT EXISTS `Reported_Organization` (
    Organization_ID VARCHAR(20) NOT NULL,
    Report_Reason VARCHAR(100) NOT NULL,
    Report_Description VARCHAR(100) NULL,
    Reported_By VARCHAR(20) NOT NULL,
    Reported_At TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    Action INT NULL,
    Reply VARCHAR(100) NULL,
    Reply_Action INT NULL,
    PRIMARY KEY (Organization_ID, Reported_By),
    FOREIGN KEY (Organization_ID) REFERENCES Organizations (Organization_ID),
    FOREIGN KEY (Reported_By) REFERENCES MedicalOfficers(Officer_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `Anonymous_Sponsors`;
CREATE TABLE IF NOT EXISTS `Anonymous_Sponsors` (
    Sponsor_ID VARCHAR(20) NOT NULL,
    Request_ID VARCHAR(20) NOT NULL,
    Email VARCHAR(100) NOT NULL,
    Amount INT NOT NULL,
    Status INT NOT NULL,
    Session_ID VARCHAR(255) NOT NULL,
    Sponsored_At TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (Sponsor_ID),
    FOREIGN KEY (Request_ID) REFERENCES Sponsorship_Requests (Sponsorship_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Insert Blood Type
INSERT INTO BloodGroups (BloodGroup_ID, BloodGroup_Name)
VALUES ('A+', 'A+');
INSERT INTO BloodGroups (BloodGroup_ID, BloodGroup_Name)
VALUES ('A-', 'A-');
INSERT INTO BloodGroups (BloodGroup_ID, BloodGroup_Name)
VALUES ('B+', 'B+');
INSERT INTO BloodGroups (BloodGroup_ID, BloodGroup_Name)
VALUES ('B-', 'B-');
INSERT INTO BloodGroups (BloodGroup_ID, BloodGroup_Name)
VALUES ('AB+', 'AB+');
INSERT INTO BloodGroups (BloodGroup_ID, BloodGroup_Name)
VALUES ('AB-', 'AB-');
INSERT INTO BloodGroups (BloodGroup_ID, BloodGroup_Name)
VALUES ('O+', 'O+');
INSERT INTO BloodGroups (BloodGroup_ID, BloodGroup_Name)
VALUES ('O-', 'O-');



# Insert Default Users for Testing
INSERT INTO Users (UID, Email, Password, Account_Status, Role)
VALUES ('Mng_01', 'manager@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Manager');
INSERT INTO Users (UID, Email, Password, Account_Status, Role)
VALUES ('Adm_01', 'admin@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Admin');
INSERT INTO Users (UID, Email, Password, Account_Status, Role)
VALUES ('Mof_01', 'mofficer@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer');
INSERT INTO Users (UID, Email, Password, Account_Status, Role)
VALUES ('Dnr_01', 'donor@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Donor');
INSERT INTO Users (UID, Email, Password, Account_Status, Role)
VALUES ('Dnr_02', 'donor2@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Donor');
INSERT INTO Users (UID, Email, Password, Account_Status, Role)
VALUES ('Dnr_03', 'donor3@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Donor');
INSERT INTO Users (UID, Email, Password, Account_Status, Role)
VALUES ('Dnr_04', 'donor4@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Donor');
INSERT INTO Users (UID, Email, Password, Account_Status, Role)
VALUES ('Dnr_05', 'donor5@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Donor');

INSERT INTO Users (UID, Email, Password, Account_Status, Role)
VALUES ('Org_01', 'org@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Organization');
INSERT INTO Users (UID, Email, Password, Account_Status, Role)
VALUES ('Spn_01', 'sponsor@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor');
INSERT INTO Users (UID, Email, Password, Account_Status, Role)
VALUES ('Hos_01', 'hospital@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital');

# Make Default Blood Bank for Testing
INSERT INTO BloodBanks (BloodBank_ID, BankName, Address1, Address2, City, Telephone_No, No_Of_Doctors, No_Of_Nurses,
                        No_Of_Beds, No_Of_Storages, Type)
VALUES ('BB_01', 'Main Blood Bank', 'No 01, Main Street', 'Colombo 01', 'Colombo', '0111234567', 0, 0, 0, 0, 1);;
INSERT INTO BloodBanks (BloodBank_ID, BankName, Address1, Address2, City, Telephone_No, No_Of_Doctors, No_Of_Nurses,
                        No_Of_Beds, No_Of_Storages, Type)
VALUES ('BB_02', 'Negombo Blood Bank', 'No 02, Main Street', 'Colombo 02', 'Negombo', '0111234577', 0, 0, 0, 0, 1);
# Make Default Admin for Testing
INSERT INTO Admins (Admin_ID, UserName, Email) VALUES ('Adm_01', 'Admin', 'admin@test.com');
# Make Default Manager for Testing
INSERT INTO Managers (Manager_ID, First_Name, Last_Name, Address1, Address2, City, Contact_No, Email, BloodBank_ID)
VALUES ('Mng_01', 'Manager', 'Manager', 'Address1', 'Address2', 'Colombo', '0771234567', 'manager@test.com', 'BB_01');
# Make Default Medical Officer for Testing
INSERT INTO MedicalOfficers (Officer_ID, First_Name, Last_Name, Address1, Address2, City, Contact_No, Email,Branch_ID,Registration_Number, NIC, Position, Gender, Nationality)
VALUES ('Mof_01', 'Medical', 'Officer', 'Address1', 'Address2', 'Colombo', '0771234567', 'mofficer@test.com', 'BB_01','12344',
        '123456789104', 'Doctor', 'M', 'Sri Lankan');
# Make Default Donor for Testing
INSERT INTO Donors (DONOR_ID, FIRST_NAME, LAST_NAME, ADDRESS1, ADDRESS2, CITY, NEAREST_BANK, CONTACT_NO, EMAIL, NIC,
                    GENDER, STATUS,BloodGroup)
VALUES ('Dnr_01', 'Donor', 'Donor', 'Address1', 'Address2', 'Colombo', 'BB_01', '0771234567', 'donor@test.com',
        '200017800595', 'F', 0,"A+");

# Make Default Organization for Testing
INSERT INTO Organizations (Organization_ID, Organization_Name, Organization_Email, Contact_No, Address1, Address2, City,
                           Status)
VALUES ('Org_01', 'Organization', 'organization@test.com', '0777123123', 'Address1', 'Address2', 'Colombo', 0);
# Make Default Sponsor for Testing
INSERT INTO Sponsors (SPONSOR_ID, Sponsor_Name, Email, ADDRESS1, ADDRESS2, CITY, STATUS)
VALUES ('Spn_01', 'Sponsor', 'sponsor@test.com', 'Address1', 'Address2', 'Colombo', 0);
# Make Default Hospital for Testing
INSERT INTO Hospitals (Hospital_ID, Hospital_Name, Email, Address1, Address2, City, Contact_No,Nearest_Blood_Bank)
VALUES ('Hos_01', 'Hospital', 'hospital@test.com', 'Address1', 'Address2', 'Colombo', '0111234567','BB_01');


# Make Default Organization Member for Testing
INSERT INTO Organization_Members(Organization_ID, Name, Contact_No, NIC, Position)
VALUES ('Org_01', 'Member', '0771234567', '123456789V', 'Secretary');
INSERT INTO Organization_Members(Organization_ID, Name, Contact_No, NIC, Position)
VALUES ('Org_01', 'Member2', '0772345671', '234567891V', 'President');
INSERT INTO Organization_Members(Organization_ID, Name, Contact_No, NIC, Position)
VALUES ('Org_01', 'Member3', '0773456712', '345678912V', 'Treasurer');


DELIMITER $$
DROP TRIGGER IF EXISTS `Campaign_Audit_Create`$$
CREATE TRIGGER IF NOT EXISTS `Campaign_Audit_Create` AFTER INSERT ON `campaign_donation_queue` FOR EACH ROW
    BEGIN
    IF EXISTS(SELECT * FROM campaign_statistics WHERE Campaign_ID=NEW.Campaign_ID) THEN
        UPDATE campaign_statistics SET No_Of_Campaign_Registers = No_Of_Campaign_Registers + 1 WHERE Campaign_ID = NEW.Campaign_ID;
    ELSE
        INSERT INTO campaign_statistics (Campaign_ID, No_Of_Campaign_Registers)
        VALUES (NEW.Campaign_ID,1);
    END IF;
    END $$
DELIMITER ;

DELIMITER $$
DROP TRIGGER IF EXISTS `Campaign_Audit_Donor_Health_Check`$$
    CREATE TRIGGER IF NOT EXISTS `Campaign_Audit_Donor_Health_Check` AFTER INSERT ON `donor_health_checkup` FOR EACH ROW
    BEGIN
        UPDATE campaign_statistics SET No_Of_Health_Checks = No_Of_Health_Checks + 1 WHERE Campaign_ID = NEW.Campaign_ID;
    END $$
DELIMITER ;

DELIMITER $$
DROP TRIGGER IF EXISTS `Campaign_Audit_Donor_Blood_Check`$$
    CREATE TRIGGER IF NOT EXISTS `Campaign_Audit_Donor_Blood_Check` AFTER INSERT ON `donor_blood_check` FOR EACH ROW
    BEGIN
        UPDATE campaign_statistics SET No_Of_Blood_Checks = No_Of_Blood_Checks + 1 WHERE Campaign_ID = NEW.Campaign_ID;
    END $$
DELIMITER ;

DELIMITER $$
DROP TRIGGER IF EXISTS `Campaign_Audit_Donor_Successful_Blood_Donation`$$
    CREATE TRIGGER IF NOT EXISTS `Campaign_Audit_Donor_Blood_Donation` AFTER UPDATE ON `campaign_donation_queue` FOR EACH ROW
    BEGIN
        IF (NEW.Donor_Status = 4) THEN
            UPDATE campaign_statistics SET No_Of_Successful_Donations = No_Of_Successful_Donations + 1 WHERE Campaign_ID = NEW.Campaign_ID;
        ELSEIF (NEW.Donor_Status = 5) THEN
            UPDATE campaign_statistics SET No_Of_Aborted_Donations = Campaign_Statistics.No_Of_Aborted_Donations + 1 WHERE Campaign_ID = NEW.Campaign_ID;
        END IF;
    END $$
DELIMITER ;




# Create Event Scheduler
# CREATE EVENT IF NOT EXISTS `BloodBank_Donation_Queue` ON SCHEDULE EVERY 1 DAY STARTS CURRENT_TIMESTAMP
#     DO
#         UPDATE donor_blood_check SET Donor_Status = 3 WHERE Donor_Status = 2 AND DATEDIFF(CURRENT_DATE, Blood_Check_Date) > 3;



