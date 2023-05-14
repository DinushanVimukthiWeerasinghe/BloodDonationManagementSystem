use bepositive_test;

# Insert Blood Groups
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


# Insert Default Users for Each Role
# Insert Default Users for Testing
INSERT INTO Users (UID, Email, Password, Account_Status, Role)
VALUES ('Mng_01', 'manager@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Manager');
INSERT INTO Users (UID, Email, Password, Account_Status, Role)
VALUES ('Adm_01', 'admin@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Admin');
INSERT INTO Users (UID, Email, Password, Account_Status, Role)
VALUES ('Mof_01', 'mofficer@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer');
INSERT INTO Users (UID, Email, Password, Account_Status, Role)
VALUES ('Dnr_01', 'donor@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Donor');
INSERT INTO Users (UID, Email, Password, Account_Status, Role)
VALUES ('Org_01', 'org@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Organization');
INSERT INTO Users (UID, Email, Password, Account_Status, Role)
VALUES ('Spn_01', 'sponsor@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor');
INSERT INTO Users (UID, Email, Password, Account_Status, Role)
VALUES ('Hos_01', 'hospital@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital');

# Insert Blood Banks
INSERT INTO BloodBanks (BloodBank_ID, BankName, Address1, Address2, City, Telephone_No,No_Of_Beds,No_Of_Doctors,No_Of_Nurses,No_Of_Storages) VALUES
    ('BB_01', 'Kuliyapitiya Hospital Blood Bank', 'No 17', 'Wariyapola Road', 'Kuliyapitiya', '0110000000',48,25,58,145);

# Admin Profile
INSERT INTO admins (Admin_ID, UserName, Email) VALUES ('Adm_01', 'Be Positive Admin', 'admin@bepositive.local');

# Manager Profile
INSERT INTO Managers (Manager_ID, First_Name, Last_Name, Address1, Address2, City, Contact_No, Email, BloodBank_ID)
VALUES ('Mng_01', 'Prasad ', 'Perera', 'No 07', 'Colombo Road', 'Dehiwala', '0771234567', 'manager@bepositive.local', 'BB_01');

# Medical Officer Profile
INSERT INTO MedicalOfficers (Officer_ID, First_Name, Last_Name, Address1, Address2, City, Contact_No, Email,Branch_ID,Registration_Number, NIC, Position, Gender, Nationality)
VALUES ('Mof_01', 'Krishanthi' , 'Perera', 'No 05', 'Dalupotha', 'Negombo', '0775896748', 'mofficer@bepositive.local', 'BB_01','25784',
        '198785024586', 'Doctor', 'F', 'Sinhala');

# Donor Profile
INSERT INTO Donors (DONOR_ID, FIRST_NAME, LAST_NAME, ADDRESS1, ADDRESS2, CITY, NEAREST_BANK, CONTACT_NO, EMAIL, NIC,
                    GENDER, STATUS,BloodGroup)
VALUES ('Dnr_01', 'Viharsha', 'Jayathilaka', 'No 17/A', 'Mathugama', 'Kaluthara', 'BB_01', '0711234567', 'donor@bepositive.local',
        '199947856983', 'F', 0,'A+');

# Make Default Organization for Testing
INSERT INTO Organizations (Organization_ID, Organization_Name, Organization_Email, Contact_No, Address1, Address2, City,
                           Status)
VALUES ('Org_01', 'Sinha Society', 'orgnization@bepositive.local', '0784578888', 'No 17', 'Sinha Road', 'Colombo 05', 1);
# Make Default Organization Member for Testing
INSERT INTO Organization_Members(Organization_ID, Name, Contact_No, NIC, Position, Email)
VALUES ('Org_01', 'Dinushan Vimukthi', '0771234567', '200017800595', 'Secretary','dinushan@sinhasociety.local');
INSERT INTO Organization_Members(Organization_ID, Name, Contact_No, NIC, Position,Email)
VALUES ('Org_01', 'Isuru Heshan', '0772345671', '200056777896', 'President','isuru@sinhasociety.local');
INSERT INTO Organization_Members(Organization_ID, Name, Contact_No, NIC, Position,Email)
VALUES ('Org_01', 'Janith Heshara', '0773456712', '199978436578', 'Treasurer','janith@sinhasociety.local');


# Make Default Sponsor for Testing
INSERT INTO Sponsors (SPONSOR_ID, Sponsor_Name, Email, ADDRESS1, ADDRESS2, CITY, STATUS)
VALUES ('Spn_01', 'E-Sport', 'sponsor@bepositive.local', 'No 78/B', 'Galle Road', 'Dehiwala', 0);

INSERT INTO Hospitals (Hospital_ID, Hospital_Name, Email, Address1, Address2, City, Contact_No,Nearest_Blood_Bank)
VALUES ('Hos_01', 'Negombo District Hospital', 'hospital@bepositive.local', 'Negombo District Hospital', 'Colombo Road', 'Negombo', '0111234567','BB_01');







# Add Blood Banks
INSERT INTO BloodBanks (BloodBank_ID, BankName, Address1, Address2, City, Telephone_No,No_Of_Beds,No_Of_Doctors,No_Of_Nurses,No_Of_Storages) VALUES
('BB_02', 'Matara Hospital Blood Bank', 'No 41', 'Dewundara Road', 'Matara', '061000000',48,25,58,145),
('BB_03', 'Badulla Central Hospital Blood Bank', 'No 178', 'Ravana Alla', 'Badulla', '021000000',48,25,58,145),
('BB_04', 'National Blood Centre', 'No 555/5', 'Elvitigala Mawatha', 'Colombo', '0112693226',48,25,58,145),
('BB_05', 'Sri Jayewardenepura General Hospital Blood Bank', 'No 1011', 'Gangodawila', 'Nugegoda', '0112844444',48,25,58,145),
('BB_06', 'Teaching Hospital Kandy Blood Bank', 'No 45', 'Saracchi Loop Road', 'Kandy', '0812234777',48,25,58,145),
('BB_07', 'Anuradhapura General Hospital Blood Bank', 'No 7', 'Jaffna Road', 'Anuradhapura', '0252222261',48,25,58,145),
('BB_08', 'Ratnapura General Hospital Blood Bank', 'No 143', 'Colombo - Ratnapura Road', 'Ratnapura', '0452222261',48,25,58,145),
('BB_09', 'Matara General Hospital Blood Bank', 'No 90', 'Pareyagoda', 'Matara', '0412222261',48,25,58,145),
('BB_10', 'Jaffna Teaching Hospital Blood Bank', 'No 1', 'Hospital Road', 'Jaffna', '0212222261',48,25,58,145),
('BB_11', 'Kilinochchi District General Hospital Blood Bank', 'No 56', 'Kandy Road', 'Kilinochchi', '0212222234',48,25,58,145),
('BB_12', 'Mannar District General Hospital Blood Bank', 'No 15', 'Hospital Road', 'Mannar', '0232222261',48,25,58,145),
('BB_13', 'Batticaloa Teaching Hospital Blood Bank', 'No 30', 'Kallady', 'Batticaloa', '0652222261',48,25,58,145),
('BB_14', 'Trincomalee District General Hospital Blood Bank', 'No 74', 'Madathady', 'Trincomalee', '0262222261',48,25,58,145),
('BB_15', 'Hemas Hospitals Blood Bank', 'No 389', 'Negombo Road', 'Wattala', '0112233445',48,25,58,145),
('BB_16', 'Karapitiya Blood Bank', 'Karapitiya', 'Galle', 'Galle', '0912234567',48,25,58,145),
('BB_17', 'Durdans Hospital Blood Bank', 'No 3', 'Alfred Place', 'Colombo 03', '0112364444',48,25,58,145),
('BB_18', 'Nawaloka Hospitals Blood Bank', 'No 23', 'De Fonseka Place', 'Colombo 05', '0115572222',48,25,58,145),
('BB_19', 'Asiri Blood Bank', 'No 181', 'Kirula Road', 'Colombo 05', '0112553333',48,25,58,145),
('BB_20', 'Panadura Base Hospital Blood Bank', 'Horana Road', 'Panadura', 'Panadura', '0382233322',48,25,58,145),
('BB_21', 'Castle Street Hospital Blood Bank', 'No 75', 'Castle Street', 'Colombo 08', '0112691111',48,25,58,145),
('BB_22', 'Rathnapura General Hospital Blood Bank', 'Ratnapura', 'Ratnapura', 'Ratnapura', '0452234567',48,25,58,145),
('BB_23', 'Kurunegala Teaching Hospital Blood Bank', 'Kurunegala', 'Kurunegala', 'Kurunegala', '0372233456',48,25,58,145),
('BB_24', 'National Blood Centre', 'Ellawala Mawatha', 'Narahenpita', 'Colombo', '0112695111',48,25,58,145);



# Create Medical Officers
INSERT INTO Users (UID, Email, Password, Account_Status, Role)
VALUES
    ('Mof_02', 'dr.sanjayaperera@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_03', 'dr.shanthifernando@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_04', 'dr.sajithaamarasinghe@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_05', 'dr.maheshgunaratne@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_06', 'dr.nishanthabandara@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_07', 'dr.dineshpeiris@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_08', 'dr.chathurajayawardena@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_09', 'dr.kumaradesilva@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_10', 'dr.ruwanwijewardena@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_11', 'dr.anushagunasekara@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_12', 'dr.janakaratnayake@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_13', 'dr.harshadesilva@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_14', 'dr.sureshrodrigo@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_15', 'dr.sampathfernando@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_16', 'dr.dilankaperera@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_17', 'dr.nuwandesilva@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_18', 'dr.thushararanasinghe@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_19', 'dr.madhawajayasena@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_20', 'dr.kavindasenanayake@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_21', 'dr.aselakarunathilake@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_22', 'dr.nimalrajapakse@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_23', 'dr.chaturawijesinghe@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_24', 'dr.harshanifernando@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_25', 'dr.tharangaperera@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_26', 'dr.roshanpeiris@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_27', 'dr.gayanjayasekara@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_28', 'dr.nirosharanasinghe@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_29', 'dr.sachinsilva@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_30', 'dr.sampathperera@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_31', 'dr.tharindubandara@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer');













































# Create Organizations
INSERT INTO Users (UID, Email, Password, Account_Status, Role)
VALUES
    ('ORG_02', 'savetheanimals@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_03', 'greenpeace@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_04', 'womeninneed@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_05', 'thehungerproject@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_06', 'amnestyinternational@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_07', 'doctorswithoutborders@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_08', 'unitedway@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_09', 'makeawishfoundation@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_10', 'oxfam@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_11', 'americanredcross@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_12', 'habitatforhumanity@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_13', 'savethechildren@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_14', 'worldvision@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_15', 'worldwildlifefund@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_16', 'stjudechildrensresearchhospital@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_17', 'actionagainsthunger@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_18', 'waterorg@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_19', 'heiferinternational@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_20', 'feedingamerica@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_21', 'thenatureconservancy@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_22', 'care@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_23', 'thesalvationarmy@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_24', 'mercycorps@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_25', 'savethechildreninternational@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_26', 'internationalrescuecommittee@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_27', 'thetrevorproject@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_28', 'boysandgirlsclubsofamerica@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_29', 'aspca@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_30', 'unicef@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_31', 'americancancersociety@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_32', 'americanheartassociation@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_33', 'internationalplannedparenthoodfederation@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_34', 'doctorsoftheworld@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_35', 'humanrightswatch@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_36', 'theleukemiaandlymphomasociety@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_37', 'thecartercenter@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_38', 'ronaldmcdonaldhousecharities@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_39', 'specialolympics@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_40', 'americandiabetesassociation@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_41', 'thebreastcancerresearchfoundation@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_42', 'standupcancer@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_43', 'bigbrothersbigsistersofamerica@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_44', 'theamericanfoundationforsuicideprevention@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_45', 'thealzheimersassociation@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_46', 'thenationalmultiplesclerosissociety@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_47', 'thearthritisfoundation@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_48', 'thelupusfoundationofamerica@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization'),
    ('ORG_49', 'hopeforchildren@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'Organization');


# Create Organizations Table
INSERT INTO organizations(ORGANIZATION_ID, ORGANIZATION_NAME, ADDRESS1, ADDRESS2, ORGANIZATION_EMAIL, CONTACT_NO, CITY, STATUS, VERIFIED_BY, VERIFIED_AT)
VALUES
    ('ORG_02', 'Save the Animals', '19, Visaka Road', 'Colombo 04,', 'savetheanimals@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_03', 'Greenpeace', '186/1',' Dr. Colvin R. De Silva Mawatha, Colombo 02,', 'greenpeace@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_04', 'Women in Need', '106',' Dharmapala Mawatha, Colombo 07,', 'womeninneed@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_05', 'The Hunger Project', '183/2', 'Vauxhall Street, Colombo 02,', 'thehungerproject@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_06', 'Amnesty International', '114',' Norris Canal Road, Colombo 10,', 'amnestyinternational@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_07', 'Doctors Without Borders', 'Children - 4th Floor',' Fonseka Road, Colombo 05,', 'doctorswithoutborders@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_08', 'United Way', 'No. 32/11',' 1st Lane, Pagoda Road, Nugegoda,', 'unitedway@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_09', 'Make-A-Wish Foundation', '207/3',' Wijerama Mawatha, Colombo 07,', 'makeawishfoundation@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_10', 'Oxfam', '98/1',' Sri Saranankara Road, Kalubowila, Dehiwela,', 'oxfam@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_11', 'American Red Cross', 'No. 234',' 1st Floor, Galle Road, Colombo 04,', 'americanredcross@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_12', 'Habitat for Humanity', '65',' High Level Road, Maharagama,', 'habitatforhumanity@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_13', 'Save the Children', '108',' Barnes Place, Colombo 07,', 'savethechildren@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_14', 'World Vision', 'No. 05',' Rosmead Place, Colombo 07,', 'worldvision@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_15', 'World Wildlife Fund', 'No. 40',' Rodney Street, Colombo 08,', 'worldwildlifefund@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_16', 'St. Jude Children\'s Research Hospital', '53/9',' Tickell Road, Colombo 08,', 'stjudechildrensresearchhospital@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_17', 'Action Against Hunger', '18',' Dudley Senanayake Mawatha, Colombo 08,', 'actionagainsthunger@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_18', 'Water.org', '100/20',' Independence Avenue, Colombo 07, Sri Lanka49, Bullers Lane, Colombo 07,', 'waterorg@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_19', 'Heifer International', 'No. 3',' 5th Lane, Colombo 03,', 'heiferinternational@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_20', 'Feeding America', '3',' Kynsey Road, Colombo 08,', 'feedingamerica@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_21', 'The Nature Conservancy', '6/5',' Wijerama Mawatha, Colombo 07,', 'thenatureconservancy@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_22', 'CARE', 'No. 19',' Green Path, Colombo 03,', 'care@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_23', 'The Salvation Army', '245',' Havelock Road, Colombo 06, Sri Lanka365, Cotta Road, Rajagiriya,', 'thesalvationarmy@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_24', 'Mercy Corps', '26/1',' Ananda Coomaraswamy Mawatha, Colombo 03,', 'mercycorps@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_25', 'Save the Children International', 'No. 5',' 1st Lane, Off Kirula Road, Colombo 05,', 'savethechildreninternational@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_26', 'International Rescue Committee', '140',' Horton Place, Colombo 07,', 'internationalrescuecommittee@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_27', 'The Trevor Project', '698/1',' Kotte Road, Ethul Kotte,', 'thetrevorproject@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_28', 'Boys & Girls Clubs of America', '19',' Visaka Road, Colombo 04,', 'boysandgirlsclubsofamerica@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_29', 'ASPCA', '186/1',' Dr. Colvin R. De Silva Mawatha, Colombo 02,', 'aspca@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_30', 'UNICEF', '106',' Dharmapala Mawatha, Colombo 07,', 'unicef@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_31', 'American Cancer Society', '183/2',' Vauxhall Street, Colombo 02,', 'americancancersociety@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_32', 'American Heart Association', '114',' Norris Canal Road, Colombo 10,', 'americanheartassociation@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_33', 'International Planned Parenthood Federation', 'Children - 4th Floor',' Fonseka Road, Colombo 05,', 'internationalplannedparenthoodfederation@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_34', 'Doctors of the World', 'No. 32/11',' 1st Lane, Pagoda Road, Nugegoda,', 'doctorsoftheworld@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_35', 'Human Rights Watch', '207/3',' Wijerama Mawatha, Colombo 07,', 'humanrightswatch@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_36', 'The Leukemia & Lymphoma Society', '98/1',' Sri Saranankara Road, Kalubowila, Dehiwela,', 'theleukemiaandlymphomasociety@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_37', 'The Carter Center', 'No. 234',' 1st Floor, Galle Road, Colombo 04,', 'thecartercenter@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_38', 'Ronald McDonald House Charities', '65',' High Level Road, Maharagama,', 'ronaldmcdonaldhousecharities@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_39', 'Special Olympics', '108',' Barnes Place, Colombo 07,', 'specialolympics@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_40', 'American Diabetes Association', 'No. 05',' Rosmead Place, Colombo 07,', 'americandiabetesassociation@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_41', 'The Breast Cancer Research Foundation', 'No. 40',' Rodney Street, Colombo 08,', 'thebreastcancerresearchfoundation@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_42', 'Stand Up To Cancer - standuptocanc', '53/9',' Tickell Road, Colombo 08,', 'standupcancer@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_43', 'Big Brothers Big Sisters of America', '18',' Dudley Senanayake Mawatha, Colombo 08,', 'bigbrothersbigsistersofamerica@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_44', 'The American Foundation for Suicide Prevention', '100/20',' Independence Avenue, Colombo 07, Sri Lanka49, Bullers Lane, Colombo 07,', 'theamericanfoundationforsuicideprevention@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_45', 'The Alzheimer\'s Association', 'No. 3',' 5th Lane, Colombo 03,', 'thealzheimersassociation@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_46', 'The National Multiple Sclerosis Society', '3',' Kynsey Road, Colombo 08,', 'thenationalmultiplesclerosissociety@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_47', 'The Arthritis Foundation', '6/5',' Wijerama Mawatha, Colombo 07,', 'thearthritisfoundation@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_48', 'The Lupus Foundation of America', 'No. 19',' Green Path, Colombo 03,', 'thelupusfoundationofamerica@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10'),
    ('ORG_49', 'Hope for Children', '698/1, Kotte Road', 'Ethul Kotte,', 'hopeforchildren@bepositive.local', '0112690911', 'Colombo 05', 1, 'Mof_01', '2020-10-10 10:10:10');



    INSERT INTO MedicalOfficers (Officer_ID, First_Name, Last_Name, Address1, Address2, City, Contact_No, Email,
                             Branch_ID,Registration_Number, NIC, Position, Gender, Nationality)
VALUES ('Mof_02', 'Sanjaya', 'Perera', 'No 54', 'Piliyandala Road', 'Nugegoda', '0773000000', 'dr.sanjayaperera@bepositive.local', 'BB_03','12146',
        '200004400004', 'Doctor', 'M', 'Sri Lankan'),
       ('Mof_03', 'Shanthi', 'Fernando', 'No 12', 'Rajagiriya Road', 'Rajagiriya', '0774000000', 'dr.shanthifernando@bepositive.local', 'BB_04','12347',
        '200006500001', 'Doctor', 'M', 'Sri Lankan'),
       ('Mof_04', 'Sajitha', 'Amarasinghe', 'No 37', 'Dehiwala Road', 'Mt Lavinia', '0775000000', 'dr.sajithaamarasinghe@bepositive.local', 'BB_05','12348',
        '200008700003', 'Doctor', 'M', 'Sri Lankan'),
       ('Mof_05', 'Mahesh', 'Gunaratne', 'No 64', 'High Level Road', 'Nugegoda', '0776000000', 'dr.maheshgunaratne@bepositive.local', 'BB_06','12349',
        '200004200005', 'Doctor', 'M', 'Sri Lankan'),
       ('Mof_06', 'Nishantha', 'Bandara', 'No 10', 'Galle Road', 'Dehiwala', '0777000000', 'dr.nishanthabandara@bepositive.local', 'BB_07','12350',
        '200009100002', 'Doctor', 'F', 'Sri Lankan'),
       ('Mof_07', 'Dinesh', 'Peiris', 'No 53', 'Havelock Road', 'Colombo', '0778000000', 'dr.dineshpeiris@bepositive.local', 'BB_08','12351',
        '200007500002', 'Doctor', 'M', 'Sri Lankan'),
       ('Mof_08', 'Chathura', 'Jayawardena', 'No 28', 'Kotte Road', 'Rajagiriya', '0779000000', 'dr.chathurajayawardena@bepositive.local', 'BB_09','12352',
        '200004300006', 'Doctor', 'F', 'Sri Lankan'),
       ('Mof_09', 'Kumara', 'De', 'No 15', 'Nawala Road', 'Nugegoda', '0771000000', 'dr.kumaradesilva@bepositive.local', 'BB_10','12353',
        '200007200001', 'Doctor', 'M', 'Sri Lankan'),
       ('Mof_10', 'Ruwan', 'Wijewardena', 'No 04', 'Galle Road', 'Colombo 06', '0712000000', 'dr.ruwanwijewardena@bepositive.local', 'BB_02','12354',
        '199607220012', 'Doctor', 'M', 'Sri Lankan'),
       ('Mof_11', 'Anusha', 'Gunasekara', 'No 1/1', 'Malabe Road', 'Athurugiriya', '0773000000', 'dr.anushagunasekara@bepositive.local', 'BB_03','12355',
        '198912050023', 'Nurse', 'M', 'Sri Lankan'),
       ('Mof_12', 'Janaka', 'Ratnayake', 'No 14', 'High Level Road', 'Maharagama', '0774000000', 'dr.janakaratnayake@bepositive.local', 'BB_01','12356',
        '199712010040', 'Doctor', 'F', 'Sri Lankan'),
       ('Mof_13', 'Harsha', 'de', 'No 10', 'Peradeniya Road', 'Kandy', '0715000000', 'dr.harshadesilva@bepositive.local', 'BB_04','12357',
        '199011070015', 'Nurse', 'M', 'Sri Lankan'),
       ('Mof_14', 'Suresh', 'Rodrigo', 'No 22', 'Galle Road', 'Hikkaduwa', '0766000000', 'dr.sureshrodrigo@bepositive.local', 'BB_05','12358',
        '199412160011', 'Doctor', 'M', 'Sri Lankan'),
       ('Mof_15', 'Sampath', 'Fernando', 'No 17', 'Rajagiriya Road', 'Rajagiriya', '0777000000', 'dr.sampathfernando@bepositive.local', 'BB_02','12359',
        '198811230004', 'Doctor', 'M', 'Sri Lankan'),
       ('Mof_16', 'Dilanka', 'Perera', 'No 05', 'Nawala Road', 'Nugegoda', '0718000000', 'dr.dilankaperera@bepositive.local', 'BB_03','12360',
        '199611290035', 'Nurse', 'F', 'Sri Lankan'),
       ('Mof_17', 'Nuwan', 'De', 'No 6/1', 'Dehiwala Road', 'Boralasgamuwa', '0769000000', 'dr.nuwandesilva@bepositive.local', 'BB_04','12361',
        '199306100014', 'Doctor', 'M', 'Sri Lankan'),
       ('Mof_18', 'Thushara', 'Ranasinghe', 'No 08', 'Kurunegala Road', 'Kegalle', '0770000000', 'dr.thushararanasinghe@bepositive.local', 'BB_05','12362',
        '199803220032', 'Nurse', 'M', 'Sri Lankan'),
       ('Mof_19', 'Madhawa', 'Jayasena', 'No 10', 'Galle Road', 'Dehiwala', '0777000000', 'dr.madhawajayasena@bepositive.local', 'BB_07','12363',
        '200009100003', 'Doctor', 'F', 'Sri Lankan'),
       ('Mof_20', 'Kavinda', 'Senanayake', 'No 53', 'Havelock Road', 'Colombo', '0778000000', 'dr.kavindasenanayake@bepositive.local', 'BB_08','12364',
        '200007500008', 'Doctor', 'M', 'Sri Lankan'),
       ('Mof_21', 'Asela', 'Karunathilake', 'No 28', 'Kotte Road', 'Rajagiriya', '0779000000', 'dr.aselakarunathilake@bepositive.local', 'BB_09','12365',
        '200004300001', 'Doctor', 'F', 'Sri Lankan'),
       ('Mof_22', 'Nimal', 'Rajapakse', 'No 15', 'Nawala Road', 'Nugegoda', '0771000000', 'dr.nimalrajapakse@bepositive.local', 'BB_10','12366',
        '200007200008', 'Doctor', 'M', 'Sri Lankan'),
       ('Mof_23', 'Chatura', 'Wijesinghe', 'No 04', 'Galle Road', 'Colombo 06', '0712000000', 'dr.chaturawijesinghe@bepositive.local', 'BB_02','12367',
        '199607220011', 'Doctor', 'M', 'Sri Lankan'),
       ('Mof_24', 'Harshani', 'Fernando', 'No 1/1', 'Malabe Road', 'Athurugiriya', '0773000000', 'dr.harshanifernando@bepositive.local', 'BB_03','12368',
        '198912050021', 'Nurse', 'M', 'Sri Lankan'),
       ('Mof_25', 'Tharanga', 'Perera', 'No 14', 'High Level Road', 'Maharagama', '0774000000', 'dr.tharangaperera@bepositive.local', 'BB_01','12369',
        '199712010041', 'Doctor', 'F', 'Sri Lankan'),
       ('Mof_26', 'Roshan', 'Peiris', 'No 10', 'Peradeniya Road', 'Kandy', '0715000000', 'dr.roshanpeiris@bepositive.local', 'BB_04','12370',
        '199011070017', 'Nurse', 'M', 'Sri Lankan'),
       ('Mof_27', 'Gayan', 'Jayasekara', 'No 22', 'Galle Road', 'Hikkaduwa', '0766000000', 'dr.gayanjayasekara@bepositive.local', 'BB_05','12371',
        '199412160012', 'Doctor', 'M', 'Sri Lankan'),
       ('Mof_28', 'Nirosha', 'Ranasinghe', 'No 17', 'Rajagiriya Road', 'Rajagiriya', '0777000000', 'dr.nirosharanasinghe@bepositive.local', 'BB_02','12372',
        '198811230017', 'Doctor', 'M', 'Sri Lankan'),
       ('Mof_29', 'Sachin', 'Silva', 'No 05', 'Nawala Road', 'Nugegoda', '0718000000', 'dr.sachinsilva@bepositive.local', 'BB_03','12373',
        '199611290030', 'Nurse', 'F', 'Sri Lankan'),
       ('Mof_30', 'Sampath', 'Perera', 'No 6/1', 'Dehiwala Road', 'Boralasgamuwa', '0769000000', 'dr.sampathperera@bepositive.local', 'BB_04','12374',
        '199306100017', 'Doctor', 'M', 'Sri Lankan'),
       ('Mof_31', 'Tharindu', 'Bandara', 'No 08', 'Kurunegala Road', 'Kegalle', '0770000000', 'dr.tharindubandara@bepositive.local', 'BB_05','12375',
        '199803220030', 'Nurse', 'M', 'Sri Lankan');
# Create Sponsors

INSERT INTO Users (UID, Email, Password, Account_Status, Role)
VALUES ('Spn_02', 'hemashospitals@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_03', 'masholdings@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_04', 'cargillsceylon@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_05', 'dialogaxiata@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_06', 'johnkeellsholdings@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_07', 'brandixlanka@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_08', 'srilankanairlines@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_09', 'commercialbankceylon@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_10', 'peoplesbank@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_11', 'hnbassurance@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_12', 'abansgroup@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_13', 'virtusacorp@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_14', 'hayleysgroup@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_15', 'softlogicholdings@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_16', 'nawalokahospitals@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_17', 'dimocorporation@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_18', 'unionbankcolombo@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_19', 'sampathbank@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_20', 'singersrilanka@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_21', 'hemaspharmaceuticals@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_22', 'efllogistics@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_23', 'nationstrustbank@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_24', 'dfccbank@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_25', 'accessengineering@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_26', 'lolcholdings@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_27', 'aitkenspence@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_28', 'amayaleisure@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_29', 'ceylonbiscuits@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_30', 'laugfsholdings@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_31', 'srilankatelecom@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor');
INSERT INTO Sponsors (SPONSOR_ID, Sponsor_Name, Email, ADDRESS1, ADDRESS2, CITY, STATUS)
VALUES
    ('Spn_02','Hemas Hospitals' , 'hemashospitals@bepositive.local', 'Maharagama', 'Colombo 01', 'Colombo', 0),
    ('Spn_03','MAS Holdings' , 'masholdings@bepositive.local', 'No. 10, Galle Road', 'Colombo 03', 'Colombo', 0),
    ('Spn_04','Cargills (Ceylon) PLC' , 'cargillsceylon@bepositive.local', 'No. 56, High Level Road', 'Maharagama', 'Colombo', 0),
    ('Spn_05','Dialog Axiata PLC' , 'dialogaxiata@bepositive.local', 'No. 235, Galle Road', 'Mount Lavinia', 'Colombo', 0),
    ('Spn_06','John Keells Holdings PLC' , 'johnkeellsholdings@bepositive.local', 'No. 1, Indigolla', 'Miriswatta', 'Gampaha', 0),
    ('Spn_07','Brandix Lanka Limited' , 'brandixlanka@bepositive.local', 'No. 36, Sir Ernest de Silva Mawatha', 'Colombo 07', 'Colombo', 0),
    ('Spn_08','SriLankan Airlines' , 'srilankanairlines@bepositive.local', 'No. 148, A.S. Jayawardena Mawatha', 'Colombo 10', 'Colombo', 0),
    ('Spn_09','Commercial Bank of Ceylon PLC' , 'commercialbankceylon@bepositive.local', 'Level 2, Hemas House', 'Colombo 02', 'Colombo', 0),
    ('Spn_10','People\'s Bank' ,'peoplesbank@bepositive.local', 'No. 25, Foster Lane', 'Colombo 10', 'Colombo', 0),
    ('Spn_11','HNB Assurance PLC ', 'hnbassurance@bepositive.local', 'No. 40, York Street', 'Colombo 01', 'Colombo', 0),
    ('Spn_12','Abans Group ', 'abansgroup@bepositive.local', 'No. 80, Nawam Mawatha', 'Colombo 02', 'Colombo', 0),
    ('Spn_13','Virtusa Corporation' , 'virtusacorp@bepositive.local', 'No. 10, Velona Street', 'Colombo 02', 'Colombo', 0),
    ('Spn_14','Hayleys Group' , 'hayleysgroup@bepositive.local', 'No. 315, Vauxhall Street', 'Colombo 02', 'Colombo', 0),
    ('Spn_15','Softlogic Holdings PLC' , 'softlogicholdings@bepositive.local', 'No. 253, Nawala Road', 'Nawala', 'Colombo', 0),
    ('Spn_16','Nawaloka Hospitals PLC' , 'nawalokahospitals@bepositive.local', 'No. 130, Glennie Street', 'Colombo 02', 'Colombo', 0),
    ('Spn_17','DIMO Corporation' , 'dimocorporation@bepositive.local', 'No. 110, Sir James Peiris Mawatha', 'Colombo 02', 'Colombo', 0),
    ('Spn_18','Union Bank of Colombo PLC' , 'unionbankcolombo@bepositive.local', 'No. 40, Nawam Mawatha', 'Colombo 02', 'Colombo', 0),
    ('Spn_19','Sampath Bank PLC' , 'sampathbank@bepositive.local', 'No. 10, Ward Place', 'Colombo 07', 'Colombo', 0),
    ('Spn_20','Singer PLC' , 'singersrilanka@bepositive.local', 'No. 110, Sir James Pieris Mawatha', 'Colombo 02', 'Colombo', 0),
    ('Spn_21','Hemas Pharmaceuticals' , 'hemaspharmaceuticals@bepositive.local', 'No. 475, Union Place', 'Colombo 02', 'Colombo', 0),
    ('Spn_22','EFL Logistics' , 'efllogistics@bepositive.local', 'No. 21, Sir Razik Fareed Mawatha', 'Colombo 01', 'Colombo', 0),
    ('Spn_23','Nations Trust Bank PLC' , 'nationstrustbank@bepositive.local', 'No. 315, Vauxhall Street', 'Colombo 02', 'Colombo', 0),
    ('Spn_24','DFCC Bank PLC' , 'dfccbank@bepositive.local', 'No. 75, Braybrooke Place', 'Colombo 02', 'Colombo', 0),
    ('Spn_25','Access Engineering PLC' , 'accessengineering@bepositive.local', 'No. 80, Nawala Road', 'Nugegoda', 'Colombo', 0),
    ('Spn_26','LOLC Holdings PLC' , 'lolcholdings@bepositive.local', 'No. 19, Sir Chittampalam A. Gardiner Mawatha', 'Colombo 02', 'Colombo', 0),
    ('Spn_27','Aitken Spence PLC' ,'aitkenspence@bepositive.local', 'No. 25, Foster Lane', 'Colombo 10', 'Colombo', 0),
    ('Spn_28','Amaya Leisure PLC' , 'amayaleisure@bepositive.local', 'No. 94, Horana Road', 'Piliyandala', 'Colombo', 1),
    ('Spn_29','Ceylon Biscuits Limited' , 'ceylonbiscuits@bepositive.local', 'No. 10, York Street', 'Colombo 01', 'Colombo', 0),
    ('Spn_30','Laugfs Holdings Limited' , 'laugfsholdings@bepositive.local', 'No. 574, Galle Road', 'Colombo 03', 'Colombo', 1),
    ('Spn_31','Sri Lanka Telecom PLC' , 'srilankatelecom@bepositive.local', 'No. 75, Braybrooke Street', 'Colombo 02', 'Colombo', 0);


# Create Campaigns
INSERT INTO Campaign (Campaign_ID, Campaign_Name, Organization_ID, Campaign_Description, Campaign_Date, Venue, Nearest_City, Status, Latitude, Longitude, Nearest_BloodBank, Expected_Amount)
VALUES
    ('Cmp_02', 'Hope Blood Drive', 'Org_02', 'Help us save lives by donating blood!', '2023-06-10', 'Kandy Road', 'Kegalle', 1, 7.2518, 80.3467, 'BB_01', 800),
    ('Cmp_03', 'Blood for All', 'Org_03', 'Join us in our mission to provide blood to those in need.', '2023-06-12', 'Galle Road', 'Hikkaduwa', 1, 6.1381, 80.1032, 'BB_01', 500),
    ('Cmp_04', 'Life Saver Campaign', 'Org_04', 'Be a hero and donate blood!', '2023-06-15', 'Dharmapala Mawatha', 'Kandy', 1, 7.2906, 80.6337, 'BB_01', 120),
    ('Cmp_05', 'Blood Drive Colombo', 'Org_05', 'Help us meet the urgent demand for blood in Colombo.', '2023-06-18', 'Bauddhaloka Mawatha', 'Colombo 07', 1, 6.9018, 79.8578, 'BB_01', 900),
    ('Cmp_06', 'Together for Life', 'Org_06', 'Let us come together to save lives through blood donation.', '2023-05-20', 'Temple Road', 'Anuradhapura', 1, 8.3526, 80.4018, 'BB_01', 200),
    ('Cmp_07', 'Give the Gift of Life', 'Org_07', 'Donate blood today and help save a life tomorrow.', '2023-05-22', 'Mahiyangana Road', 'Badulla', 1, 6.9923, 81.0552, 'BB_01', 400),
    ('Cmp_08', 'Blood Donation Drive', 'Org_08', 'Join us in this noble cause and donate blood to save lives.', '2023-05-25', 'Matale Road', 'Gampola', 1, 7.1777, 80.5722, 'BB_01', 150),
    ('Cmp_09', 'Blood for Life', 'Org_09', 'Help us reach our goal of collecting 5000 pints of blood.', '2023-05-28', 'Kalmunai Road', 'Ampara', 1, 7.2962, 81.6743, 'BB_01', 500),
    ('Cmp_10', 'Be a Life Saver', 'Org_10', 'Your blood donation can make a big difference in someone\'s life.', '2023-05-30', 'Nawala Road', 'Nugegoda', 1, 6.8731, 79.8906, 'BB_01', 700),
    ('Cmp_11', 'Save a Life Today', 'Org_11', 'Join us in our mission to save lives through blood donation.', '2023-06-01', 'Kandy Road', 'Kandy', 1, 7.2906, 80.6337, 'BB_01', 800),
    ('Cmp_12', 'Blood Donation Camp', 'Org_12', 'Donate blood and become a life saver.', '2023-07-02', 'Negombo Road', 'Kurunegala', 1, 7.4915, 80.3631, 'BB_01', 800),
    ('Cmp_13', 'Blood Bank Drive', 'Org_13', 'Help us collect blood for our blood bank.', '2023-06-05', 'Kandy-Jaffna Highway', 'Vavuniya', 1, 8.7519, 80.4989, 'BB_01', 400),
    ('Cmp_14', 'Donate Blood, Save Lives', 'Org_14', 'Your blood can be the difference between life and death.', '2023-05-08', 'Habarana Road', 'Polonnaruwa', 1, 7.9406, 81.0187, 'BB_01', 1000),
    ('Cmp_15', 'Be a Blood Donor', 'Org_15', 'Join us in this life saving cause by donating blood.', '2023-06-12', 'Kotte Road', 'Rajagiriya', 1, 6.9025, 79.8936, 'BB_01', 500),
    ('Cmp_17', 'Blood Donation Camp', 'Org_17', 'Join us to save lives through blood donation', '2023-06-21', 'High Level Road', 'Maharagama', 1, 6.8540, 79.9299, 'BB_01', 500),
    ('Cmp_18', 'Donate Blood, Save Lives', 'Org_18', 'Be a superhero! Donate blood today and save someone\'s life', '2023-06-24', 'Kotte', 'Sri Jayawardenepura Kotte', 1, 6.8934, 79.9188, 'BB_01', 800),
    ('Cmp_19', 'Blood Drive 2023', 'Org_19', 'Join us in our mission to save lives by donating blood', '2023-06-20', 'Bauddhaloka Mawatha', 'Colombo 07', 1, 6.9032, 79.8699, 'BB_01', 600),
    ('Cmp_20', 'Let\'s Save Lives Together', 'Org_20', 'Your blood can save lives. Come donate and make a difference', '2023-07-02', 'Galle Road', 'Dehiwala-Mount Lavinia', 1, 6.8516, 79.8672, 'BB_01', 900),
    ('Cmp_21', 'Blood for Life', 'Org_21', 'Donate blood today and be the reason someone smiles tomorrow', '2023-07-16', 'High Level Road', 'Nugegoda', 1, 6.8624, 79.8923, 'BB_01', 400),
    ('Cmp_22', 'Blood Donation Drive', 'Org_22', 'Help us save lives by donating blood', '2023-08-06', 'Kandy Road', 'Kadawatha', 1, 7.0098, 79.9323, 'BB_01', 700),
('Cmp_23', 'Blood Donation Day', 'Org_01', 'Join us in giving the gift of life!', '2023-06-15', 'Main Street', 'Colombo', 1, 6.9271, 79.8612, 'BB_01', 1000),
('Cmp_24', 'LifeSavers Blood Drive', 'Org_03', 'Donate blood and become a lifesaver today!', '2023-06-18', 'Galle Road', 'Matara', 1, 5.9487, 80.5423, 'BB_01', 500),
('Cmp_25', 'Blood for All', 'Org_02', 'Help us provide blood for those in need!', '2023-06-22', 'Peradeniya Road', 'Kandy', 1, 7.2906, 80.6337, 'BB_01', 700),
('Cmp_26', 'Save Lives Blood Drive', 'Org_04', 'One donation can save up to three lives!', '2023-06-27', 'High Level Road', 'Nugegoda', 1, 6.8615, 79.8946, 'BB_01', 600),
('Cmp_27', 'Blood Donation Camp', 'Org_05', 'Donate blood and make a difference in someone\'s life!', '2023-06-30', 'Negombo Road', 'Wattala', 1, 7.0121, 79.8939, 'BB_01', 900),
('Cmp_28', 'Give Blood Save Lives', 'Org_06', 'Help us save lives by donating blood today!', '2023-07-05', 'Galle Road', 'Galle', 1, 6.0320, 80.2170, 'BB_01', 400),
('Cmp_29', 'Blood Drive for Children', 'Org_07', 'Donate blood to help children in need!', '2023-07-10', 'Batticaloa Road', 'Ampara', 1, 7.3106, 81.6710, 'BB_01', 1200),
('Cmp_30', 'Life Blood Drive', 'Org_08', 'Join us in giving the gift of life!', '2023-07-15', 'Anuradhapura Road', 'Polonnaruwa', 1, 7.9390, 81.0006, 'BB_01', 800),
('Cmp_31', 'Blood Donation Campaign', 'Org_09', 'Help us save lives by donating blood today!', '2023-07-20', 'Kandy Road', 'Kurunegala', 1, 7.4840, 80.3600, 'BB_01', 500),
('Cmp_32', 'Blood for Life', 'Org_10', 'Donate blood and make a difference in someone\'s life!', '2023-07-25', 'Dambulla Road', 'Matale', 1, 7.4683, 80.6234, 'BB_01', 700),
('Cmp_33', 'Blood Donation Drive for Animal Shelters', 'Org_40', 'Help animals in need by donating blood!', '2023-12-15', 'Galle Road', 'Hikkaduwa', 1, 6.1399, 80.1006, 'BB_01', 500),
('Cmp_34', 'Save a Life Blood Drive', 'Org_12', 'Your donation can help save a life!', '2023-07-30', 'Negombo Road', 'Seeduwa', 1, 7.1540, 79.8950, 'BB_01', 600),
('Cmp_35', 'Blood Donation Marathon', 'Org_13', 'Join us in our blood donation marathon!', '2023-08-03', 'Main Street', 'Kolonnawa', 1, 6.9420, 79.9167, 'BB_01', 1000),
('Cmp_36', 'Blood Drive for Cancer Patients', 'Org_14', 'Donate blood and help cancer patients!', '2023-08-07', 'Galle Road', 'Hikkaduwa', 1, 6.1389, 80.1007, 'BB_01', 800),
('Cmp_37', 'Blood for the Needy', 'Org_15', 'Help us provide blood for those in need!', '2023-08-10', 'Kandy Road', 'Gampaha', 1, 7.0873, 79.9944, 'BB_01', 500),
('Cmp_38', 'LifeSavers Blood Donation Drive', 'Org_16', 'Join us in saving lives by donating blood!', '2023-08-15', 'High Level Road', 'Maharagama', 1, 6.8489, 79.9299, 'BB_01', 700),
('Cmp_39', 'Blood Donation Camp for Dengue Patients', 'Org_17', 'Donate blood to help dengue patients in need!', '2023-08-20', 'Anuradhapura Road', 'Anuradhapura', 1, 8.3144, 80.4126, 'BB_01', 900),
('Cmp_40', 'Give Blood, Give Life', 'Org_18', 'Your donation can help save a life!', '2023-08-25', 'Batticaloa Road', 'Batticaloa', 1, 7.7191, 81.6914, 'BB_01', 400),
('Cmp_41', 'Blood Donation Drive for the Elderly', 'Org_19', 'Donate blood and help the elderly!', '2023-08-30', 'Galle Road', 'Ambalangoda', 1, 6.2294, 80.0586, 'BB_01', 1200),
('Cmp_42', 'Blood for the Future', 'Org_20', 'Join us in donating blood for a better future!', '2023-09-05', 'Kandy Road', 'Nawalapitiya', 1, 7.0519, 80.5164, 'BB_01', 800),
('Cmp_43', 'Blood Drive for Road Accident Victims', 'Org_21', 'Help us save lives by donating blood today!', '2023-09-10', 'Negombo Road', 'Ja-Ela', 1, 7.0635, 79.8994, 'BB_01', 500),
('Cmp_44', 'Blood Donation Drive for Thalassemia Patients', 'Org_22', 'Donate blood to help thalassemia patients in need!', '2023-09-15', 'Colombo Road', 'Kurunegala', 1, 7.4850, 80.3606, 'BB_01', 700),
('Cmp_45', 'Donate Blood, Save a Life', 'Org_23', 'Join us in our blood donation drive!', '2023-09-20', 'Dambulla Road', 'Matale', 1, 7.4716, 80.6230, 'BB_01', 1000),
('Cmp_46', 'Blood Drive for Emergency Preparedness', 'Org_24', 'Help us prepare for emergencies by donating blood!', '2023-09-25', 'Negombo Road', 'Minuwangoda', 1, 7.1693, 79.9523, 'BB_01', 800),
('Cmp_47', 'Blood for Life', 'Org_25', 'Donate blood and give the gift of life!', '2023-10-01', 'Kandy Road', 'Gampola', 1, 7.1613, 80.5724, 'BB_01', 600),
('Cmp_48', 'Blood Donation Drive for Dengue Prevention', 'Org_26', 'Help prevent dengue by donating blood!', '2023-10-05', 'Galle Road', 'Matara', 1, 5.9473, 80.5354, 'BB_01', 900),
('Cmp_49', 'Blood Donation Drive for Cancer Research', 'Org_27', 'Donate blood to help with cancer research!', '2023-10-10', 'Colombo Road', 'Kandy', 1, 7.2906, 80.6337, 'BB_01', 1200),
('Cmp_50', 'Blood Donation Drive for Covid-19 Patients', 'Org_28', 'Donate blood to help Covid-19 patients in need!', '2023-10-15', 'Negombo Road', 'Wattala', 1, 6.9974, 79.8939, 'BB_01', 500),
('Cmp_51', 'Blood Donation Drive for Women and Children', 'Org_29', 'Help women and children in need by donating blood!', '2023-10-20', 'Galle Road', 'Galle', 1, 6.0367, 80.2149, 'BB_01', 700),
('Cmp_52', 'Blood Donation Drive for Heart Patients', 'Org_30', 'Donate blood to help heart patients!', '2023-10-25', 'Kandy Road', 'Peradeniya', 1, 7.2703, 80.5962, 'BB_01', 800),
('Cmp_53', 'Donate Blood, Save a Future', 'Org_31', 'Join us in donating blood for a better future!', '2023-10-30', 'Negombo Road', 'Warakapola', 1, 7.1982, 80.2232, 'BB_01',100),
('Cmp_54', 'Blood Donation Drive for Orphanages', 'Org_32', 'Donate blood to help children in orphanages!', '2023-11-05', 'Colombo Road', 'Ratnapura', 1, 6.7056, 80.3848, 'BB_01', 600),
('Cmp_55', 'Blood Donation Drive for the Elderly', 'Org_33', 'Help the elderly by donating blood!', '2023-11-10', 'Kandy Road', 'Kadugannawa', 1, 7.3116, 80.5322, 'BB_01', 500),
('Cmp_56', 'Blood Donation Drive for Disaster Relief', 'Org_34', 'Donate blood to help with disaster relief efforts!', '2023-11-15', 'Galle Road', 'Ambalangoda', 1, 6.2350, 80.0514, 'BB_01', 800),
('Cmp_57', 'Donate Blood, Save a Life', 'Org_35', 'Join us in our blood donation drive!', '2023-11-20', 'Negombo Road', 'Kochchikade', 1, 7.2609, 79.8391, 'BB_01', 700),
('Cmp_58', 'Blood Donation Drive for Diabetes Patients', 'Org_36', 'Donate blood to help diabetes patients!', '2023-11-25', 'Colombo Road', 'Panadura', 1, 6.7110, 79.9075, 'BB_01', 900),
('Cmp_59', 'Blood Donation Drive for the Holidays', 'Org_37', 'Give the gift of life this holiday season by donating blood!', '2023-12-01', 'Kandy Road', 'Kurunegala', 1, 7.4830, 80.3659, 'BB_01', 600),
('Cmp_60', 'Blood Donation Drive for HIV Patients', 'Org_38', 'Donate blood to help HIV patients in need!', '2023-12-05', 'Negombo Road', 'Gampaha', 1, 7.0873, 79.9937, 'BB_01', 800),
('Cmp_61', 'Blood Donation Drive for Mental Health Awareness', 'Org_39', 'Donate blood to raise awareness for mental health!', '2023-12-10', 'Colombo Road', 'Colombo', 1, 6.9167, 79.8473, 'BB_01', 1000);
# Add 5ample Data to the Donor TABLE
INSERT INTO users(UID, Email, Password) VALUES
('Dnr_02', 'john@bepositive.local','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_03', 'peter@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_04', 'mary@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_05', 'sarah@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_06', 'david@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_07', 'samantha@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_08', 'robert@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_09', 'linda@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_10', 'samuel@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_11', 'sophias@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_12', 'michael@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_13', 'julia@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_14', 'christopher@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_15', 'emily@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_16', 'adam@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_17', 'olivia@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_20', 'emma@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_21', 'benjamin@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_22', 'chloe@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_23', 'mason@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_24', 'isabella@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_25', 'ethan@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_26', 'sophia@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_27', 'alexander@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_28', 'madison@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS');

INSERT INTO Donors (DONOR_ID, FIRST_NAME, LAST_NAME, ADDRESS1, ADDRESS2, CITY, NEAREST_BANK, CONTACT_NO, EMAIL, NIC,
                    GENDER, STATUS,BloodGroup)
VALUES ('Dnr_02', 'John','Fernando','No 15','Colombo 05','Colombo','BB_01','0771234567','john@bepositive.local','200017800001','M',0,'A+'),
       ('Dnr_03', 'Peter','Fernando','No 5','Colombo 06','Colombo','BB_01','0771234567','peter@bepositive.local','200017800002','M',0,'A+'),
       ('Dnr_04', 'Mary','Fernando','No 8','Kandy','Colombo','BB_01','0771234567','mary@bepositive.local','200017800003','F',0,'A-'),
       ('Dnr_05', 'Sarah','Silva','No 20','Colombo 07','Colombo','BB_01','0771234567','sarah@bepositive.local','200017800004','F',0,'B+'),
       ('Dnr_06', 'David','Silva','No 10','Colombo 08','Colombo','BB_01','0771234567','david@bepositive.local','200017800005','M',0,'B-'),
       ('Dnr_07', 'Samantha','Silva','No 7','Colombo 09','Colombo','BB_01','0771234567','samantha@bepositive.local','200017800006','F',0,'O-'),
       ('Dnr_08', 'Robert','Silva','No 3','Colombo 10','Colombo','BB_01','0771234567','robert@bepositive.local','200017800007','M',0,'A+'),
       ('Dnr_09', 'Linda','Perera','No 9','Colombo 11','Colombo','BB_01','0771234567','linda@bepositive.local','200017800008','F',0,'B+'),
       ('Dnr_10', 'Samuel','Perera','No 1','Colombo 12','Colombo','BB_01','0771234567','samuel@bepositive.local','200017800009','M',0,'B-'),
       ('Dnr_11', 'Sophia','Perera','No 12','Colombo 13','Colombo','BB_01','0771234567','sophias@bepositive.local','200017800010','F',0,'B+'),
       ('Dnr_12', 'Michael','Fernando','No 6','Colombo 14','Colombo','BB_01','0771234567','michael@bepositive.local','200017800011','M',0,'O+'),
       ('Dnr_13', 'Julia','Fernando','No 15','Colombo 15','Colombo','BB_01','0771234567','julia@bepositive.local','200017800012','F',0,'AB+'),
       ('Dnr_14', 'Christopher','Fernando','No 7','Colombo 16','Colombo','BB_01','0771234567','christopher@bepositive.local','200017800013','M',0,'AB-'),
       ('Dnr_15', 'Emily','Jayawardena','No 5','Colombo 17','Colombo','BB_01','0771234567','emily@bepositive.local','200017800014','F',0,'A+'),
       ('Dnr_16', 'Adam','Jayawardena','No 11','Colombo 18','Colombo','BB_01','0771234567','adam@bepositive.local','200017800015','M',0,'A+'),
       ('Dnr_17', 'Olivia','Jayawardena','No 2','Colombo 19','Colombo','BB_01','0771234567','olivia@bepositive.local','200017800016','F',0,'B+'),
       ('Dnr_20', 'Emma', 'Rodriguez', 'No 14', 'Colombo 13', 'Colombo', 'BB_01', '0771234567', 'emma@bepositive.local', '200017800112', 'F',0,'O+'),
       ('Dnr_21', 'Benjamin', 'Wilson', 'No 18', 'Colombo 14', 'Colombo', 'BB_03', '0771234567', 'benjamin@bepositive.local', '200017800113', 'M', 0,'O+'),
       ('Dnr_22', 'Chloe', 'Martinez', 'No 21', 'Colombo 15', 'Colombo', 'BB_01', '0771234567', 'chloe@bepositive.local', '200017800114', 'F', 0,'O+'),
       ('Dnr_23', 'Mason', 'Anderson', 'No 15', 'Galle', 'Colombo', 'BB_02', '0771234567', 'mason@bepositive.local', '200017800115', 'M', 0,'O-'),
       ('Dnr_24', 'Isabella', 'Thomas', 'No 11', 'Colombo 16', 'Colombo', 'BB_01', '0771234567', 'isabella@bepositive.local', '200017800116', 'F', 0,'AB+'),
       ('Dnr_25', 'Ethan', 'Jackson', 'No 24', 'Colombo 17', 'Colombo', 'BB_04', '0771234567', 'ethan@bepositive.local', '200017800117', 'M', 0,'O+'),
       ('Dnr_26', 'Sophia', 'White', 'No 17', 'Negombo', 'Colombo', 'BB_01', '0771234567', 'sophia@bepositive.local', '200017800118', 'F', 0,'O+'),
       ('Dnr_27', 'Alexander', 'Harris', 'No 6', 'Colombo 18', 'Colombo', 'BB_03', '0771234567', 'alexander@bepositive.local', '200017800119', 'M', 0,'O+'),
       ('Dnr_28', 'Madison', 'Clark', 'No 13', 'Colombo 19', 'Colombo', 'BB_01', '0771234567', 'madison@bepositive.local', '200017800120', 'F', 0,'O+');

# Create Hospitals
INSERT INTO Users (UID, Email, Password, Account_Status, Role)
VALUES
    ('Hos_02', 'royalhospital@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_03', 'citygeneralhospital@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_04', 'mercyhospital@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_05', 'oceanviewhospital@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_06', 'sunrisehospital@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_07', 'greenwaymedicalcenter@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_08', 'pinevalleyhospital@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_09', 'westwoodmedicalcenter@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_10', 'lakefronthospital@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_11', 'maplewoodhospital@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_12', 'goldenstatehospital@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_13', 'valleymedicalcenter@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_14', 'mountainviewhospital@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_15', 'northshoremedicalcenter@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_16', 'bayshorehospital@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_17', 'lakesidemedicalcenter@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_18', 'hillcresthospital@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_19', 'oakparkhospital@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_20', 'parkviewmedicalcenter@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_21', 'greenfieldhospital@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_22', 'seaviewhospital@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_23', 'pinehillshospital@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_24', 'sunsetmedicalcenter@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_25', 'elmwoodhospital@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_26', 'woodlandhospital@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_27', 'willowcreekhospital@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_28', 'cedargrovehospital@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_29', 'rollinghillsmedicalcenter@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_30', 'highpointhospital@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_31', 'riverviewhospital@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_32', 'lakeshoremedicalcenter@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_33', 'northparkhospital@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_34', 'stonecreekhospital@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_35', 'forestparkmedicalcenter@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_36', 'heritagehospital@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_37', 'southshorehospital@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_38', 'harborviewmedicalcenter@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_39', 'meadowviewhospital@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_40', 'magnoliahospital@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_41', 'riverbendmedicalcenter@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_42', 'redwoodhospital@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_43', 'crescentmedicalcenter@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_44', 'sunrisemedicalcenter@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_45', 'fairviewhospital@bepositive.local', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital');

INSERT INTO Hospitals (Hospital_ID, Hospital_Name, Email, Address1, Address2, City, Contact_No,Nearest_Blood_Bank)
VALUES
    ('Hos_02','Royal Hospital' , 'royalhospital@bepositive.local', 'No. 181, Kirula Road', 'Narahenpita', 'Colombo', '0114524401','BB_01'),
    ('Hos_03','City General Hospital' , 'citygeneralhospital@bepositive.local', '578, Elvitigala Mawatha', 'Narahenpita', 'Colombo', '0115530002','BB_01'),
    ('Hos_04','Mercy Medical Center' , 'mercyhospital@bepositive.local', '3, Alfred Place', 'Colombo 03', 'Colombo', '0112140034','BB_01'),
    ('Hos_05','Ocean View Hospital' , 'oceanviewhospital@bepositive.local', '23, Deshamanya H.K. Dharmadasa Mawatha', 'Colombo 02', 'Colombo', '0315430056','BB_01'),
    ('Hos_06','Sunrise Hospital' , 'sunrisehospital@bepositive.local', '389, Negombo Road', 'Wattala', 'Colombo', '0117507777','BB_01'),
    ('Hos_07','Greenway Medical Center , Hospital', 'greenwaymedicalcenter@bepositive.local', 'Hospital Road', 'Thalapathpitiya', 'Nugegoda', '0112841607','BB_01'),
    ('Hos_08','Pine Valley Hospital' , 'pinevalleyhospital@bepositive.local', 'Maharagama', 'Colombo', 'Maharagama', '0112841601','BB_01'),
    ('Hos_09','Westwood Medical Center' , 'westwoodmedicalcenter@bepositive.local', 'Regent Street', 'Colombo 08', 'Colombo', '0112691111','BB_01'),
    ('Hos_10','Lakefront Hospital' , 'lakefronthospital@bepositive.local', 'Horton Place', 'Dehiwala-Mount Lavinia', 'Dehiwala', '0112769711','BB_01'),
    ('Hos_11','Maplewood Hospital' , 'maplewoodhospital@bepositive.local', 'Galle', 'Galle', 'Galle', '0212232255','BB_01'),
    ('Hos_12','Golden State Hospital' , 'goldenstatehospital@bepositive.local', '670, Maithreepala Senanayake Mawatha', 'Anuradhapura', 'Anuradhapura', '0452222261','BB_01'),
    ('Hos_13','Valley Medical Center' , 'valleymedicalcenter@bepositive.local', 'Kallady', 'Batticaloa', 'Batticaloa', '0652222261','BB_01'),
    ('Hos_14','Mountain View Hospital' , 'mountainviewhospital@bepositive.local', 'Hospital Road', 'Jaffna', 'Jaffna', '0332222261','BB_01'),
    ('Hos_15','North Shore Medical Center' , 'northshoremedicalcenter@bepositive.local', 'Srimath Kudarathwatta Mawatha', 'Kandy', 'Kandy', '0812222261','BB_01'),
    ('Hos_16','Bayshore Hospital' , 'bayshorehospital@bepositive.local', 'Nittambuwa Road', 'Karawanella', 'Karawanella', '0365675511','BB_01'),
    ('Hos_17','Lakeside Medical Center' , 'lakesidemedicalcenter@bepositive.local', 'No. 181, Kirula Road', 'Narahenpita', 'Colombo', '0214524401','BB_01'),
    ('Hos_18','Hillcrest Hospital' , 'hillcresthospital@bepositive.local', '578, Elvitigala Mawatha', 'Narahenpita', 'Colombo', '0315530002','BB_01'),
    ('Hos_19','Oak Park Hospital' , 'oakparkhospital@bepositive.local', '3, Alfred Place', 'Colombo 03', 'Colombo', '0312140034','BB_01'),
    ('Hos_20','Parkview Medical Center' , 'parkviewmedicalcenter@bepositive.local', '23, Deshamanya H.K. Dharmadasa Mawatha', 'Colombo 02', 'Colombo', '0115430056','BB_01'),
    ('Hos_21','Greenfield Hospital' , 'greenfieldhospital@bepositive.local', '389, Negombo Road', 'Wattala', 'Colombo', '0317507777','BB_01'),
    ('Hos_22','Sea View Hospital , Hospital', 'seaviewhospital@bepositive.local', 'Hospital Road', 'Thalapathpitiya', 'Nugegoda', '0312841607','BB_01'),
    ('Hos_23','Pine Hills Hospital' , 'pinehillshospital@bepositive.local', 'Maharagama', 'Colombo', 'Maharagama', '0312841601','BB_01'),
    ('Hos_24','Sunset Medical Center' , 'sunsetmedicalcenter@bepositive.local', 'Regent Street', 'Colombo 08', 'Colombo', '0312691111','BB_01'),
    ('Hos_25','Elmwood Hospital' , 'elmwoodhospital@bepositive.local', 'Horton Place', 'Dehiwala-Mount Lavinia', 'Dehiwala', '0312769711','BB_01'),
    ('Hos_26','Woodland Hospital' , 'woodlandhospital@bepositive.local', 'Galle', 'Galle', 'Galle', '0712232255','BB_01'),
    ('Hos_27','Willow Creek Hospital' , 'willowcreekhospital@bepositive.local', '670, Maithreepala Senanayake Mawatha', 'Anuradhapura', 'Anuradhapura', '0952222261','BB_01'),
    ('Hos_28','Cedar Grove Hospital' , 'cedargrovehospital@bepositive.local', 'Kallady', 'Batticaloa', 'Batticaloa', '0222222261','BB_01'),
    ('Hos_29','Rolling Hills Medical Center' , 'rollinghillsmedicalcenter@bepositive.local', 'Hospital Road', 'Jaffna', 'Jaffna', '0212222261','BB_01'),
    ('Hos_30','High Point Hospital' , 'highpointhospital@bepositive.local', 'Srimath Kudarathwatta Mawatha', 'Kandy', 'Kandy', '0712222261','BB_01'),
    ('Hos_31','River View Hospital' , 'riverviewhospital@bepositive.local', 'Nittambuwa Road', 'Karawanella', 'Karawanella', '0225675511','BB_01'),
    ('Hos_32','Lake Shore Medical Center' , 'lakeshoremedicalcenter@bepositive.local', 'No. 181, Kirula Road', 'Narahenpita', 'Colombo', '0314524401','BB_01'),
    ('Hos_33','North Park Hospital' , 'northparkhospital@bepositive.local', '578, Elvitigala Mawatha', 'Narahenpita', 'Colombo', '0125530002','BB_01'),
    ('Hos_34','Stone Creek Hospital' , 'stonecreekhospital@bepositive.local', '3, Alfred Place', 'Colombo 03', 'Colombo', '0212140034','BB_01'),
    ('Hos_35','Forest Park Medical Center' , 'forestparkmedicalcenter@bepositive.local', '23, Deshamanya H.K. Dharmadasa Mawatha', 'Colombo 02', 'Colombo', '01215430056','BB_01'),
    ('Hos_36','Heritage Hospital' , 'heritagehospital@bepositive.local', '389, Negombo Road', 'Wattala', 'Colombo', '0217507777','BB_01'),
    ('Hos_37','South Shore Hospital , Hospital', 'southshorehospital@bepositive.local', 'Hospital Road', 'Thalapathpitiya', 'Nugegoda', '0212841607','BB_01'),
    ('Hos_38','Harbor View Medical Center' , 'harborviewmedicalcenter@bepositive.local', 'Maharagama', 'Colombo', 'Maharagama', '0212841601','BB_01'),
    ('Hos_39','Meadow View Hospital' , 'meadowviewhospital@bepositive.local', 'Regent Street', 'Colombo 08', 'Colombo', '0212691111','BB_01'),
    ('Hos_40','Magnolia Hospital' , 'magnoliahospital@bepositive.local', 'Horton Place', 'Dehiwala-Mount Lavinia', 'Dehiwala', '0212769711','BB_01'),
    ('Hos_41','River Bend Medical Center' , 'riverbendmedicalcenter@bepositive.local', 'Galle', 'Galle', 'Galle', '0232232255','BB_01'),
    ('Hos_42','Redwood Hospital' , 'redwoodhospital@bepositive.local', '670, Maithreepala Senanayake Mawatha', 'Anuradhapura', 'Anuradhapura', '0722222261','BB_01'),
    ('Hos_43','Crescent Medical Center' , 'crescentmedicalcenter@bepositive.local', 'Kallady', 'Batticaloa', 'Batticaloa', '0352222261','BB_01'),
    ('Hos_44','Sunrise Medical Center' , 'sunrisemedicalcenter@bepositive.local', 'Hospital Road', 'Jaffna', 'Jaffna', '0512222261','BB_01'),
    ('Hos_45','Fairview Hospital' , 'fairviewhospital@bepositive.local', 'Srimath Kudarathwatta Mawatha', 'Kandy', 'Kandy', '0312222261','BB_01');

# Create Sample Data for Blood Requests

INSERT INTO Blood_Requests(Request_ID, Requested_By, BloodGroup, Requested_At, Type, Status, Volume, Request_From) VALUES
    ('Req_01', 'Hos_01', 'A+', '2023-03-06 00:00:00', 1, 1, 100, 'BB_01'),
    ('Req_02', 'Hos_02', 'B+', '2023-03-07 00:00:00', 1, 1, 100, 'BB_01'),
    ('Req_03', 'Hos_03', 'AB-', '2023-03-08 00:00:00', 1, 1, 100, 'BB_01'),
    ('Req_04', 'Hos_04', 'O+', '2023-03-09 00:00:00', 1, 1, 100, 'BB_01'),
    ('Req_05', 'Hos_05', 'A-', '2023-03-10 00:00:00', 1, 1, 100, 'BB_01'),
    ('Req_06', 'Hos_06', 'B-', '2023-03-11 00:00:00', 1, 1, 100, 'BB_01'),
    ('Req_07', 'Hos_07', 'O-', '2023-03-12 00:00:00', 1, 1, 100, 'BB_01'),
    ('Req_08', 'Hos_08', 'A+', '2023-03-13 00:00:00', 1, 1, 100, 'BB_01'),
    ('Req_09', 'Hos_09', 'B+', '2023-03-14 00:00:00', 1, 1, 100, 'BB_01'),
    ('Req_10', 'Hos_10', 'AB-', '2023-03-15 00:00:00', 1, 1, 100, 'BB_01'),
    ('Req_11', 'Hos_11', 'O+', '2023-03-16 00:00:00', 1, 1, 100, 'BB_01'),
    ('Req_12', 'Hos_12', 'A-', '2023-03-17 00:00:00', 1, 1, 100, 'BB_01'),
    ('Req_13', 'Hos_13', 'B-', '2023-03-18 00:00:00', 1, 1, 100, 'BB_01'),
    ('Req_14', 'Hos_14', 'O-', '2023-03-19 00:00:00', 1, 1, 100, 'BB_01'),
    ('Req_15', 'Hos_15', 'A+', '2023-03-20 00:00:00', 1, 1, 100, 'BB_01'),
    ('Req_16', 'Hos_16', 'B+', '2023-03-21 00:00:00', 1, 1, 100, 'BB_01'),
    ('Req_17', 'Hos_17', 'AB-', '2023-03-22 00:00:00', 1, 1, 100, 'BB_01'),
    ('Req_18', 'Hos_18', 'O+', '2023-03-23 00:00:00', 1, 1, 100, 'BB_01'),
    ('Req_19', 'Hos_19', 'A-', '2023-03-24 00:00:00', 1, 1, 100, 'BB_01'),
    ('Req_20', 'Hos_20', 'B-', '2023-03-25 00:00:00', 1, 1, 100, 'BB_01'),
    ('Req_21', 'Hos_21', 'O-', '2023-03-26 00:00:00', 1, 1, 100, 'BB_01'),
    ('Req_22', 'Hos_22', 'A+', '2023-03-27 00:00:00', 1, 1, 100, 'BB_01'),
    ('Req_23', 'Hos_23', 'B+', '2023-03-28 00:00:00', 1, 1, 100, 'BB_01'),
    ('Req_24', 'Hos_24', 'AB-', '2023-03-29 00:00:00', 1, 1, 100, 'BB_01'),
    ('Req_25', 'Hos_25', 'O+', '2023-03-30 00:00:00', 1, 1, 100, 'BB_01'),
    ('Req_26', 'Hos_26', 'A-', '2023-03-31 00:00:00', 1, 1, 100, 'BB_01'),
    ('Req_27', 'Hos_27', 'B-', '2023-04-01 00:00:00', 1, 1, 100, 'BB_01'),
    ('Req_28', 'Hos_28', 'O-', '2023-04-02 00:00:00', 1, 1, 100, 'BB_01'),
    ('Req_29', 'Hos_29', 'A+', '2023-04-03 00:00:00',1,1,150,'BB_01'),
    ('Req_30', 'Hos_30', 'B+', '2023-04-04 00:00:00',1,1,150,'BB_01'),
    ('Req_31', 'Hos_31', 'AB-', '2023-04-05 00:00:00',1,1,150,'BB_01'),
    ('Req_32', 'Hos_32', 'O+', '2023-04-06 00:00:00',1,1,150,'BB_01'),
    ('Req_33', 'Hos_33', 'A-', '2023-04-07 00:00:00',1,1,150,'BB_01'),
    ('Req_34', 'Hos_34', 'B-', '2023-04-08 00:00:00',1,1,150,'BB_01'),
    ('Req_35', 'Hos_35', 'O-', '2023-04-09 00:00:00',1,1,150,'BB_01'),
    ('Req_36', 'Hos_36', 'A+', '2023-04-10 00:00:00',1,1,150,'BB_01'),
    ('Req_37', 'Hos_37', 'B+', '2023-04-11 00:00:00',1,1,150,'BB_01'),
    ('Req_38', 'Hos_38', 'AB-', '2023-04-12 00:00:00',1,1,150,'BB_01'),
    ('Req_39', 'Hos_39', 'O+', '2023-04-13 00:00:00',1,1,150,'BB_01'),
    ('Req_40', 'Hos_40', 'A-', '2023-04-14 00:00:00',1,1,150,'BB_01'),
    ('Req_41', 'Hos_41', 'B-', '2023-04-15 00:00:00',1,1,150,'BB_01'),
    ('Req_42', 'Hos_42', 'O-', '2023-04-16 00:00:00',1 ,1 ,200, 'BB_01');
