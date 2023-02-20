DROP database IF EXISTS bepositive;
CREATE DATABASE IF NOT EXISTS `bepositive` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
use bepositive;


DROP TABLE IF EXISTS Email;
CREATE TABLE IF NOT EXISTS Email(
    Email_ID      VARCHAR(20) PRIMARY KEY,
    Receiver     VARCHAR(100) NOT NULL,
    Sender        VARCHAR(20) NOT NULL,
    Email_Type    INT NOT NULL,
    Attachment    VARCHAR(100) NULL,
    Subject       VARCHAR(100) NOT NULL,
    Body          TEXT         NOT NULL,
    Email_Status  INT          NOT NULL DEFAULT 0,
    Created_At    TIMESTAMP             DEFAULT CURRENT_TIMESTAMP,
    Updated_At    TIMESTAMP             DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
# DROP TABLE IF EXISTS Users;
CREATE TABLE IF NOT EXISTS Users(
                                    UID            VARCHAR(20) PRIMARY KEY,
                                    Email          VARCHAR(100) UNIQUE,
                                    Password       VARCHAR(100) NOT NULL,
                                    Account_Status         INT          NOT NULL DEFAULT 0,
                                    Role           VARCHAR(100) NOT NULL DEFAULT 'donor',
                                    Created_At     TIMESTAMP             DEFAULT CURRENT_TIMESTAMP,
                                    Updated_At     TIMESTAMP             DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                                    Security_Level INT          NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS Password_Reset;
CREATE TABLE IF NOT EXISTS Password_Reset(
    UID            VARCHAR(20) PRIMARY KEY,
    Token          VARCHAR(100) NOT NULL,
    Email          VARCHAR(100) NOT NULL,
    Created_At     TIMESTAMP             DEFAULT CURRENT_TIMESTAMP,
    Status         INT          NOT NULL DEFAULT 0,
    Device_IP      VARCHAR(100) NOT NULL,
    FOREIGN KEY (UID) REFERENCES Users (UID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TRIGGER IF EXISTS PasswordReset_OnSuccessUpdateUser;
DELIMITER $$
CREATE TRIGGER PasswordReset_OnSuccessUpdateUser
    AFTER UPDATE
    ON Password_Reset
    FOR EACH ROW
BEGIN
    IF NEW.Status = 1 THEN
        UPDATE Users
        SET Password = (SELECT Password FROM Password_Reset WHERE UID = NEW.UID)
        WHERE UID = NEW.UID;
    END IF;
END $$
DELIMITER ;

DROP TRIGGER IF EXISTS PasswordReset_OnSuccessDelete;
DELIMITER $$
CREATE TRIGGER PasswordReset_OnSuccessDelete
    AFTER DELETE
    ON Password_Reset
    FOR EACH ROW
BEGIN
    IF OLD.Status = 1 THEN
        INSERT INTO Password_Reset_Audit(UID, Token, Email, Device_IP, Status,Created_At, Reset_At) VALUES(OLD.UID, OLD.Token, OLD.Email, OLD.Device_IP, OLD.Status, OLD.Created_At, CURRENT_TIMESTAMP);
    END IF;
END $$

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


# Create Admin Table
# DROP TABLE IF EXISTS Admins;
CREATE TABLE IF NOT EXISTS Admins(
    Admin_ID      VARCHAR(20) PRIMARY KEY,
    UserName      VARCHAR(100) NOT NULL,
    Email         VARCHAR(100) NOT NULL,
    Profile_Image VARCHAR(100) NOT NULL DEFAULT '/public/upload/profile/adminDefault.png',
    FOREIGN KEY (Admin_ID) REFERENCES Users (UID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Create Blood Bank Table
# Main Blood Bank - 1 Branch - 2
# DROP TABLE IF EXISTS BloodBanks;
CREATE TABLE IF NOT EXISTS BloodBanks (
                                          BloodBank_ID   VARCHAR(20)  NOT NULL  PRIMARY KEY,
                                          BankName       VARCHAR(100) NOT NULL,
                                          Address1       VARCHAR(100) NOT NULL,
                                          Address2       VARCHAR(100) NOT NULL ,
                                          City           VARCHAR(100) NOT NULL,
                                          Telephone_No   VARCHAR(100) UNIQUE ,
                                          No_Of_Doctors  INT          NOT NULL DEFAULT 0,
                                          No_Of_Nurses   INT          NOT NULL DEFAULT 0,
                                          No_Of_Beds     INT          NOT NULL DEFAULT 0,
                                          No_Of_Storages INT          NOT NULL DEFAULT 0,
                                          Type           INT          NOT NULL DEFAULT 2
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

# Insert Main Blood Bank


# Create Medical Officer Table
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
    Registration_Number VARCHAR(20) UNIQUE,
    Registration_Date   TIMESTAMP             DEFAULT CURRENT_TIMESTAMP,
    Status              INT          NOT NULL DEFAULT 0,
    Joined_At           TIMESTAMP             DEFAULT CURRENT_TIMESTAMP,
    Branch_ID           VARCHAR(20)  NOT NULL,
    Profile_Image       VARCHAR(100) NOT NULL DEFAULT '/public/upload/profile/medicalOfficerDefault.png',
    FOREIGN KEY (Branch_ID) REFERENCES BloodBanks (BloodBank_ID)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TRIGGER IF EXISTS Add_MedicalOfficer_Login;
DELIMITER $$
CREATE TRIGGER Add_MedicalOfficer_Login
    AFTER INSERT
    ON MedicalOfficers
    FOR EACH ROW
BEGIN
    INSERT INTO Users(UID, Email, Password, Account_Status, Role, Created_At, Updated_At, Security_Level)
    VALUES (NEW.Officer_ID, NEW.Email, SHA(NEW.NIC), NEW.Status, 'MedicalOfficer', NEW.Joined_At, NEW.Joined_At, 0);
END $$


# DROP TABLE IF EXISTS Blood_Packets;
CREATE TABLE IF NOT EXISTS Blood_Packets
(
    Packet_ID    VARCHAR(20) NOT NULL PRIMARY KEY,
    Packed_By    VARCHAR(20) NOT NULL,
    BloodGroup   VARCHAR(3)  NOT NULL,
    Status       VARCHAR(50) NOT NULL,
    Certified_By VARCHAR(20) NOT NULL,
    Stored_At    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (Packed_By) REFERENCES MedicalOfficers (Officer_ID),
    FOREIGN KEY (Certified_By) REFERENCES MedicalOfficers (Officer_ID)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

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

# OTP Code Trigger
DROP TRIGGER IF EXISTS OTP_Code_AutoExpire;
DELIMITER $$
CREATE TRIGGER OTP_Code_AutoExpire
    BEFORE UPDATE
    ON OTP_Code
    FOR EACH ROW
BEGIN
    #     Compare the current time with the expired time
    IF (NEW.Status = 0 AND NEW.Expired_At < CURRENT_TIMESTAMP) THEN
        SET NEW.Status = 3;
    END IF;
END $$

# Create Trigger for No of Attempts in OTP Code
DROP TRIGGER IF EXISTS OTP_Code_NoOfAttempts;
DELIMITER $$
CREATE TRIGGER OTP_Code_NoOfAttempts
    BEFORE UPDATE
    ON OTP_Code
    FOR EACH ROW
BEGIN
    #     Compare the current time with the expired time
    IF (NEW.Status = 0 AND NEW.Attempts >= 5) THEN
        SET NEW.Status = 4;
    END IF;
END $$



DROP TRIGGER IF EXISTS OTP_Code_TotalAttempts;
DELIMITER $$
CREATE TRIGGER OTP_Code_TotalAttempts
    BEFORE UPDATE
    ON OTP_Code
    FOR EACH ROW
BEGIN
    #     Compare the current time with the expired time
    SET NEW.Total_Attempts = NEW.Total_Attempts + 1;
END $$

DROP TRIGGER IF EXISTS OTP_CODE_Verify;
DELIMITER $$
CREATE TRIGGER OTP_Code_Verify
    BEFORE DELETE
    ON OTP_Code
    FOR EACH ROW
BEGIN
    IF (OLD.Status = 1) THEN
        INSERT INTO OTP_CODE_Audit (UserID, Code, Target, Total_Attempts, Verified_At, Activity, Suspicious)
        VALUES (OLD.UserID, OLD.Code, OLD.Target, OLD.Total_Attempts, OLD.Verified_At, 1, 0);
    ELSE
        INSERT INTO OTP_CODE_Audit (UserID, Code, Target, Total_Attempts, Verified_At, Activity, Suspicious)
        VALUES (OLD.UserID, OLD.Code, OLD.Target, OLD.Total_Attempts, OLD.Verified_At, 1, 0);
    END IF;
END $$

# DROP TRIGGER IF EXISTS OTP_CODE_ReGenerate;
# DELIMITER
$$
# CREATE TRIGGER OTP_Code_ReGenerate
#     BEFORE UPDATE ON OTP_Code
#     FOR EACH ROW
# BEGIN
#     IF (NEW.Status = 0 AND OLD.Status = 0) THEN
#         INSERT INTO OTP_CODE_Audit (UserID,Code,Target,Total_Attempts,ReGenerated_At,Activity,Suspicious) VALUES (OLD.UserID,OLD.Code,OLD.Target,OLD.Total_Attempts,OLD.Updated_At,4,0);
#     ELSE
#         INSERT INTO OTP_CODE_Audit (UserID,Code,Target,Total_Attempts,ReGenerated_At,Activity,Suspicious) VALUES (OLD.UserID,OLD.Code,OLD.Target,OLD.Total_Attempts,OLD.Updated_At,9,1);
#     END IF;
# END
$$

DROP TRIGGER IF EXISTS OTP_Code_Generate;
DELIMITER $$
CREATE TRIGGER OTP_Code_Generate
    AFTER INSERT
    ON OTP_Code
    FOR EACH ROW
BEGIN
    INSERT INTO OTP_CODE_Audit (UserID, Code, Target, Total_Attempts, ReGenerated_At, Activity, Suspicious)
    VALUES (NEW.UserID, NEW.Code, NEW.Target, NEW.Total_Attempts, NEW.Created_At, 0, 0);
END $$

DROP TRIGGER IF EXISTS OTP_CODE_ReGenerate;
DELIMITER $$
CREATE TRIGGER OTP_Code_ReGenerate
    BEFORE UPDATE
    ON OTP_Code
    FOR EACH ROW
BEGIN
    #     SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = msg;
    IF (NEW.Status = 0 AND OLD.Status = 0) THEN
        UPDATE OTP_CODE_Audit
        SET No_Of_Regeneration = No_Of_Regeneration + 1,
            Code               = NEW.Code
        WHERE UserID = OLD.UserID
          AND Code = OLD.Code
          AND Activity IN (0, 4);
    ELSE
        UPDATE OTP_CODE_Audit
        SET No_Of_Regeneration = No_Of_Regeneration + 1
        WHERE UserID = OLD.UserID
          AND Code = OLD.Code
          AND Activity = 9;
    END IF;
END $$

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
DELIMITER $$
CREATE TRIGGER OTP_Code_Audit_ReGenerate_Amount
    BEFORE UPDATE
    ON OTP_CODE_Audit
    FOR EACH ROW
BEGIN
    IF (NEW.No_Of_Regeneration > 8) THEN
        SET NEW.Suspicious = 2;
        UPDATE Users SET Security_Level = 2 WHERE UID = NEW.UserID;
    ELSEIF (NEW.No_Of_Regeneration > 5) THEN
        SET NEW.Suspicious = 1;
        UPDATE Users SET Security_Level = 1 WHERE UID = NEW.UserID;
    END IF;
END $$


DROP TABLE IF EXISTS Blocked_Users;
CREATE TABLE IF NOT EXISTS Blocked_Users
(
    UID        VARCHAR(20) PRIMARY KEY,
    Blocked_At TIMESTAMP NOT NULL,
    Type       INT       NOT NULL,
    FOREIGN KEY (UID) REFERENCES Users (UID)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


# Create Table for Donor
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
    Status                VARCHAR(50)  NOT NULL,
    Donation_Availability INT          NOT NULL DEFAULT 0,
    Verified              INT          NOT NULL DEFAULT 0,
    Verified_At           TIMESTAMP    NULL,
    Verified_By           VARCHAR(20)  NULL,
    Verification_Remarks  VARCHAR(100) NULL,
    BloodPacket_ID        VARCHAR(20)  NULL,
    Created_At            TIMESTAMP             DEFAULT CURRENT_TIMESTAMP,
    Updated_At            TIMESTAMP             DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    Profile_Image         VARCHAR(100) NOT NULL DEFAULT '/public/upload/profile/donorDefault.png',
    FOREIGN KEY (Donor_ID) REFERENCES Users (UID),
    FOREIGN KEY (Nearest_Bank) REFERENCES BloodBanks (BloodBank_ID),
    FOREIGN KEY (Verified_By) REFERENCES MedicalOfficers (Officer_ID),
    FOREIGN KEY (BloodPacket_ID) REFERENCES Blood_Packets (Packet_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Create Hospital Table
# DROP TABLE IF EXISTS Hospitals;
CREATE TABLE IF NOT EXISTS Hospitals
(
    Hospital_ID   VARCHAR(20)  NOT NULL PRIMARY KEY,
    Hospital_Name VARCHAR(100) NOT NULL,
    Address1      VARCHAR(100) NOT NULL,
    Address2      VARCHAR(100) NOT NULL,
    Email         VARCHAR(100) UNIQUE,
    City          VARCHAR(100) NOT NULL,
    Contact_No  VARCHAR(100) UNIQUE,
    Type          INT          NOT NULL DEFAULT 1,
    Profile_Image VARCHAR(100) NOT NULL DEFAULT '/public/upload/profile/hospitalDefault.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Create Manager Table
# DROP TABLE IF EXISTS Managers;
CREATE TABLE IF NOT EXISTS Managers (
        Manager_ID    VARCHAR(20) PRIMARY KEY,
        First_Name    VARCHAR(100) NOT NULL,
        Last_Name     VARCHAR(100) NOT NULL,
        Address1      VARCHAR(100) NOT NULL,
        Address2      VARCHAR(100) NOT NULL,
        City          VARCHAR(100) NOT NULL,
        Contact_No     VARCHAR(12)  NOT NULL,
        Email         VARCHAR(100) UNIQUE,
        Status        INT          NOT NULL DEFAULT 0,
        Joined_At     TIMESTAMP             DEFAULT CURRENT_TIMESTAMP,
        BloodBank_ID  VARCHAR(20)  NOT NULL,
        Profile_Image VARCHAR(100) NOT NULL DEFAULT '/public/upload/profile/managerDefault.png',
        FOREIGN KEY (BloodBank_ID) REFERENCES BloodBanks (BloodBank_ID),
        FOREIGN KEY (Manager_ID) REFERENCES Users (UID)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

# Create Table for Blood Group
# DROP TABLE IF EXISTS BloodGroups;
CREATE TABLE IF NOT EXISTS BloodGroups
(
    BloodGroup_ID   VARCHAR(20) PRIMARY KEY,
    BloodGroup_Name VARCHAR(100) NOT NULL UNIQUE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


# Create Table for Accepted Requests
# DROP TABLE IF EXISTS Attendance_Accepted_Requests;
CREATE TABLE IF NOT EXISTS Attendance_Accepted_Requests
(
    Request_ID  VARCHAR(20) NOT NULL PRIMARY KEY,
    Donor_ID    VARCHAR(20) NOT NULL,
    Accepted_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (Donor_ID) REFERENCES Donors (Donor_ID)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


DROP TABLE IF EXISTS Blood_Requests;
CREATE TABLE IF NOT EXISTS Blood_Requests (
    Request_ID VARCHAR(20) NOT NULL  PRIMARY KEY,
    Requested_By VARCHAR(20) NOT NULL,
    BloodGroup VARCHAR(3) NOT NULL,
    Requested_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Type INT NOT NULL DEFAULT 1,
    Status INT NOT NULL DEFAULT 1,
    FOREIGN KEY (Requested_By) REFERENCES Hospitals(Hospital_ID),
    FOREIGN KEY (BloodGroup) REFERENCES BloodGroups(BloodGroup_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Create Table for Organizations
# DROP TABLE IF EXISTS Organizations;
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
    Profile_Image      VARCHAR(100) NOT NULL DEFAULT '/public/upload/organizationDefault.png',
    Created_At         TIMESTAMP             DEFAULT CURRENT_TIMESTAMP,
    Updated_At         TIMESTAMP             DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (Organization_ID) REFERENCES Users (UID)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

# Create Table for Organization Members
# DROP TABLE IF EXISTS Organization_Members;
CREATE TABLE IF NOT EXISTS Organization_Members
(
    Organization_ID VARCHAR(20)  NOT NULL,
    Name            VARCHAR(100) NOT NULL,
    Contact_No      VARCHAR(100) UNIQUE ,
    NIC             VARCHAR(100) UNIQUE,
    Position        VARCHAR(100) NOT NULL,
    PRIMARY KEY (Organization_ID, NIC),
    FOREIGN KEY (Organization_ID) REFERENCES Organizations (Organization_ID)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

# Create Table for Sponsors
# DROP TABLE IF EXISTS Sponsors;
CREATE TABLE IF NOT EXISTS Sponsors
(
    Sponsor_ID    VARCHAR(20)  NOT NULL PRIMARY KEY,
    Sponsor_Name          VARCHAR(100) NOT NULL,
    Email         VARCHAR(100) UNIQUE,
    Address1      VARCHAR(100) NOT NULL,
    Address2      VARCHAR(100) NOT NULL,
    City          VARCHAR(100) NOT NULL,
    Status        VARCHAR(50)  NOT NULL,
    Contact_No    VARCHAR(100) UNIQUE ,
    Created_At    TIMESTAMP             DEFAULT CURRENT_TIMESTAMP,
    Updated_At    TIMESTAMP             DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    Profile_Image VARCHAR(100) NOT NULL DEFAULT '/public/upload/sponsorDefault.png',
    FOREIGN KEY (Sponsor_ID) REFERENCES Users (UID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Create Table for Sponsorship Packages
# DROP TABLE IF EXISTS Sponsorship_Packages;
CREATE TABLE IF NOT EXISTS Sponsorship_Packages (
    Package_ID VARCHAR(20) NOT NULL  PRIMARY KEY,
    Package_Name VARCHAR(100) NOT NULL,
    Package_Description VARCHAR(100) NOT NULL,
    Package_Price VARCHAR(100) NOT NULL,
    Created_By VARCHAR(20) NOT NULL,
    Updated_By VARCHAR(20) NULL,
    Created_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Updated_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (Created_By) REFERENCES Managers(Manager_ID),
    FOREIGN KEY (Updated_By) REFERENCES Managers(Manager_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Create Table For Medical Team
# DROP TABLE IF EXISTS Medical_Team;
CREATE TABLE IF NOT EXISTS  Medical_Team
(
    Team_ID      VARCHAR(20)  NOT NULL PRIMARY KEY,
    Campaign_ID  VARCHAR(20)  NOT NULL,
    Team_Leader_ID  VARCHAR(20)  NOT NULL,
    Assigned_By VARCHAR(20) NOT NULL ,
    Assigned_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (Assigned_By) REFERENCES Managers(Manager_ID),
    FOREIGN KEY (Team_Leader_ID) REFERENCES MedicalOfficers (Officer_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Create Table for Team Members
DROP TABLE IF EXISTS Team_Members;
CREATE TABLE IF NOT EXISTS Team_Members
(
    Team_ID VARCHAR(20) NOT NULL,
    Member_ID VARCHAR(20) NOT NULL,
    Position VARCHAR(100) NOT NULL DEFAULT 'Support Staff',
    PRIMARY KEY (Team_ID, Member_ID),
    FOREIGN KEY (Team_ID) REFERENCES Medical_Team (Team_ID),
    FOREIGN KEY (Member_ID) REFERENCES MedicalOfficers (Officer_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Create Table for Campaigns
DROP TABLE IF EXISTS Campaign;
CREATE TABLE IF NOT EXISTS Campaign (
    Campaign_ID VARCHAR(20) NOT NULL  PRIMARY KEY,
    Campaign_Name VARCHAR(100) NOT NULL,
    Campaign_Description VARCHAR(100) NOT NULL,
    Campaign_Date DATE NOT NULL,
    Venue VARCHAR(100) NOT NULL,
    Nearest_City VARCHAR(100) NOT NULL,
    Status INT NOT NULL CHECK ( Status Between 1 AND 3),
    Nearest_BloodBank VARCHAR(20) NOT NULL,
    Verified INT NOT NULL DEFAULT 0 CHECK ( Verified BETWEEN 0 AND 2),
    Verified_By VARCHAR(20) NULL,
    Verified_At TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    Assigned_Team VARCHAR(20) NULL,
    Remarks VARCHAR(100) NULL,
    Created_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Updated_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (Verified_By) REFERENCES Managers(Manager_ID),
    FOREIGN KEY (Assigned_Team) REFERENCES Medical_Team(Team_ID),
    FOREIGN KEY (Nearest_BloodBank) REFERENCES BloodBanks(BloodBank_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# DROP TABLE IF EXISTS Campaigns_Sponsors;
CREATE TABLE IF NOT EXISTS Campaigns_Sponsors (
    Campaign_ID VARCHAR(20) NOT NULL,
    Sponsor_ID VARCHAR(20) NOT NULL,
    Package_ID VARCHAR(20) NOT NULL,
    FOREIGN KEY (Campaign_ID) REFERENCES Campaign(Campaign_ID),
    FOREIGN KEY (Sponsor_ID) REFERENCES Sponsors(Sponsor_ID),
    FOREIGN KEY (Package_ID) REFERENCES Sponsorship_Packages(Package_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# DROP TABLE IF EXISTS Campaign_Request;
CREATE TABLE IF NOT EXISTS Campaign_Request (
    Campaign_ID VARCHAR(20) NOT NULL,
    Organization_ID VARCHAR(20) NOT NULL,
    BloodBank_ID VARCHAR(20),
    FOREIGN KEY (Campaign_ID) REFERENCES Campaign(Campaign_ID),
    FOREIGN KEY (Organization_ID) REFERENCES Organizations(Organization_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS Approved_Campaigns (
    Campaign_ID VARCHAR(20) NOT NULL,
    Bank_ID VARCHAR(20) NOT NULL,
    PRIMARY KEY (Campaign_ID,Bank_ID),
    FOREIGN KEY (Campaign_ID) REFERENCES Campaign(Campaign_ID),
    FOREIGN KEY (Bank_ID) REFERENCES BloodBanks(BloodBank_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Create Table for Approved Campaigns
#     DROP TABLE IF EXISTS Approved_Campaigns;
CREATE TABLE IF NOT EXISTS Approved_Campaigns (
    Campaign_ID VARCHAR(20) NOT NULL  PRIMARY KEY,
    Approved_By VARCHAR(20) NOT NULL,
    Approved_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Remarks VARCHAR(100) NOT NULL,
    FOREIGN KEY (Campaign_ID) REFERENCES Campaign(Campaign_ID),
    FOREIGN KEY (Approved_By) REFERENCES MedicalOfficers(Officer_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Create Table for Rejected Campaigns
# DROP TABLE IF EXISTS Rejected_Campaigns;
CREATE TABLE IF NOT EXISTS Rejected_Campaigns (
    Campaign_ID VARCHAR(20) NOT NULL  PRIMARY KEY,
    Rejected_By VARCHAR(20) NOT NULL,
    Rejected_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Remarks VARCHAR(100) NOT NULL,
    FOREIGN KEY (Campaign_ID) REFERENCES Campaign(Campaign_ID),
    FOREIGN KEY (Rejected_By) REFERENCES MedicalOfficers(Officer_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# DROP TABLE IF EXISTS Accepted_Donations;
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

# DROP TABLE IF EXISTS Rejected_Donations;
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

# DROP TABLE IF EXISTS Donor_Reviews;
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
# DROP TABLE IF EXISTS Authentication_Code;
CREATE TABLE IF NOT EXISTS Authentication_Code (
    Code_ID VARCHAR(20) NOT NULL  PRIMARY KEY,
    Code VARCHAR(20) NOT NULL,
    Authentication_Method INT NOT NULL,
    Attempts INT NOT NULL DEFAULT 0 CHECK ( Attempts BETWEEN 0 AND 4),
    Created_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Updated_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Create Monthly Report Table
# DROP TABLE IF EXISTS Monthly_Reports;
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
# DROP TABLE IF EXISTS Yearly_Reports;
CREATE TABLE IF NOT EXISTS  Yearly_Reports(
    Report_ID VARCHAR(20) NOT NULL  PRIMARY KEY,
    Report_Year VARCHAR(20) NOT NULL,
    Report_File VARCHAR(100) NOT NULL,
    Generated_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Generated_By VARCHAR(20) NOT NULL,
    FOREIGN KEY (Generated_By) REFERENCES Managers(Manager_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Create Manager Notification Table
# DROP TABLE IF EXISTS Manager_Notifications;
CREATE TABLE IF NOT EXISTS  Manager_Notifications
(
    Notification_ID       VARCHAR(20)  NOT NULL PRIMARY KEY,
    Notification_Type     INT  NOT NULL,
    Notification_State   INT  NOT NULL,
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
# DROP TABLE IF EXISTS Medical_Officer_Notifications;
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
# DROP TABLE IF EXISTS Organization_Notifications;
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
# DROP TABLE IF EXISTS Sponsor_Notifications;
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
# DROP TABLE IF EXISTS Admin_Notifications;
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
# DROP TABLE IF EXISTS Logging_History;
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

# DROP TABLE IF EXISTS Donation_Campaigns;
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
INSERT INTO Admins (Admin_ID, UserName, Email)
VALUES ('Adm_01', 'Admin', 'admin@test.com');
# Make Default Manager for Testing
INSERT INTO Managers (Manager_ID, First_Name, Last_Name, Address1, Address2, City, Contact_No, Email, BloodBank_ID)
VALUES ('Mng_01', 'Manager', 'Manager', 'Address1', 'Address2', 'Colombo', '0771234567', 'manager@test.com', 'BB_01');
# Make Default Medical Officer for Testing
INSERT INTO MedicalOfficers (Officer_ID, First_Name, Last_Name, Address1, Address2, City, Contact_No, Email,
                             Branch_ID, NIC, Position, Gender, Nationality)
VALUES ('Mof_01', 'Medical', 'Officer', 'Address1', 'Address2', 'Colombo', '0771234567', 'mofficer@test.com', 'BB_01',
        '123456789104', 'Doctor', 'M', 'Sri Lankan');
# Make Default Donor for Testing
INSERT INTO Donors (DONOR_ID, FIRST_NAME, LAST_NAME, ADDRESS1, ADDRESS2, CITY, NEAREST_BANK, CONTACT_NO, EMAIL, NIC,
                    GENDER, STATUS,
                    DONATION_AVAILABILITY, VERIFIED)
VALUES ('Dnr_01', 'Donor', 'Donor', 'Address1', 'Address2', 'Colombo', 'BB_01', '0771234567', 'donor@test.com',
        '200017800595', 'F', 0, 0, 0);
# Make Default Organization for Testing
INSERT INTO Organizations (Organization_ID, Organization_Name, Organization_Email, Contact_No, Address1, Address2, City,
                           Status)
VALUES ('Org_01', 'Organization', 'organization@test.com', '0777123123', 'Address1', 'Address2', 'Colombo', 0);
# Make Default Sponsor for Testing
INSERT INTO Sponsors (SPONSOR_ID, Sponsor_Name, Email, ADDRESS1, ADDRESS2, CITY, STATUS)
VALUES ('Spn_01', 'Sponsor', 'sponsor@test.com', 'Address1', 'Address2', 'Colombo', 0);
# Make Default Hospital for Testing
INSERT INTO Hospitals (Hospital_ID, Hospital_Name, Email, Address1, Address2, City, Contact_No)
VALUES ('Hos_01', 'Hospital', 'hospital@test.com', 'Address1', 'Address2', 'Colombo', '0111234567');


# Make Default Organization Member for Testing
INSERT INTO Organization_Members(Organization_ID, Name, Contact_No, NIC, Position)
VALUES ('Org_01', 'Member', '0771234567', '123456789V', 'Secretary');
INSERT INTO Organization_Members(Organization_ID, Name, Contact_No, NIC, Position)
VALUES ('Org_01', 'Member2', '0772345671', '234567891V', 'President');
INSERT INTO Organization_Members(Organization_ID, Name, Contact_No, NIC, Position)
VALUES ('Org_01', 'Member3', '0773456712', '345678912V', 'Treasurer');

# Make Default Blood Group for Testing
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

DROP TABLE IF EXISTS Blogs;
CREATE TABLE Blogs (
                       Blog_ID VARCHAR(20) PRIMARY KEY ,
                       Blog_Title VARCHAR(100) NOT NULL ,
                       Blog_Content TEXT NOT NULL ,
                       Blog_Date DATE NOT NULL ,
                       Blog_Status INT NOT NULL ,
                       Blog_Image VARCHAR(100) NOT NULL
) engine=innodb default charset=utf8;
