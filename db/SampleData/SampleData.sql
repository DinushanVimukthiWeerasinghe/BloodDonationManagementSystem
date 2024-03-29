use bepositive_test;
-- use bepositive;
# Create Organizations
INSERT INTO Users (UID, Email, Password, Account_Status, Role)
VALUES ('Org_01', 'org2@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Organization'),
         ('Org_03', 'org3#test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Organization'),
       ('Org_04', 'org4@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Organization'),
       ('Org_05', 'org5@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Organization'),
       ('Org_06', 'org6@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Organization'),
       ('Org_07', 'org7@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Organization'),
       ('Org_08', 'org8@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Organization'),
       ('Org_09', 'org9@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Organization'),
       ('Org_10', 'org10@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Organization'),
       ('Org_11', 'org11@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Organization'),
       ('Org_12', 'org12@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Organization'),
       ('Org_13', 'org13@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Organization'),
       ('Org_14', 'org14@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Organization'),
       ('Org_15', 'org15@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Organization'),
       ('Org_16', 'org16@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Organization'),
       ('Org_17', 'org17@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Organization'),
       ('Org_18', 'org18@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Organization'),
       ('Org_19', 'org19@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Organization'),
       ('Org_20', 'org20@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Organization'),
       ('Org_21', 'org21@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Organization'),
       ('Org_22', 'org22@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Organization'),
       ('Org_23', 'org23@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Organization'),
       ('Org_24', 'org24@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Organization'),
       ('Org_25', 'org25@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Organization');
INSERT INTO Organizations (Organization_ID, Organization_Name, Organization_Email, Contact_No, Address1, Address2, City,
                           Status)
VALUES
    ('Org_01', 'Organization', 'org2@test.com', '0770000001', 'Address1', 'Address2', 'Gampaha', 1),
    ('Org_03', 'Organization', 'org3@test.com', '0770000002', 'Address1', 'Address2', 'Gampaha', 1),
    ('Org_04', 'Organization', 'org4@test.com', '0770000003', 'Address1', 'Address2', 'Colombo', 0),
    ('Org_05', 'Organization', 'org5@test.com', '0770000004', 'Address1', 'Address2', 'Kandy', 1),
    ('Org_06', 'Organization', 'org6@test.com', '0770000005', 'Address1', 'Address2', 'Colombo', 0),
    ('Org_07', 'Organization', 'org7@test.com', '0770000006', 'Address1', 'Address2', 'Kurunegala', 1),
    ('Org_08', 'Organization', 'org8@test.com', '0770000007', 'Address1', 'Address2', 'Galle', 0),
    ('Org_09', 'Organization', 'org9@test.com', '0770000008', 'Address1', 'Address2', 'Colombo', 1),
    ('Org_10', 'Organization', 'org10@test.com', '0770000009', 'Address1', 'Address2', 'Kandy', 0),
    ('Org_11', 'Organization', 'org11@test.com', '0770000010', 'Address1', 'Address2', 'Gampaha', 1),
    ('Org_12', 'Organization', 'org12@test.com', '0770000011', 'Address1', 'Address2', 'Colombo', 0),
    ('Org_13', 'Organization', 'org13@test.com', '0770000012', 'Address1', 'Address2', 'Matara', 1),
    ('Org_14', 'Organization', 'org14@test.com', '0770000013', 'Address1', 'Address2', 'Gampaha', 0),
    ('Org_15', 'Organization', 'org15@test.com', '0770000014', 'Address1', 'Address2', 'Colombo', 1),
    ('Org_16', 'Organization', 'org16@test.com', '0770000015', 'Address1', 'Address2', 'Kurunegala', 0),
    ('Org_17', 'Organization', 'org17@test.com', '0770000016', 'Address1', 'Address2', 'Galle', 1),
    ('Org_18', 'Organization', 'org18@test.com', '0770000017', 'Address1', 'Address2', 'Colombo', 0),
    ('Org_19', 'Organization', 'org19@test.com', '0770000018', 'Address1', 'Address2', 'Kandy', 1),
    ('Org_20', 'Organization', 'org20@test.com', '0770000019', 'Address1', 'Address2', 'Gampaha', 0),
    ('Org_21', 'Organization', 'org21@test.com', '0770000020', 'Address1', 'Address2', 'Colombo', 1),
    ('Org_22', 'Organization', 'org22@test.com', '0770000021', 'Address1', 'Address2', 'Galle', 0),
    ('Org_23', 'Organization', 'org23@test.com', '0770000023', 'Address1', 'Address2', 'Gampaha', 0),
    ('Org_24', 'Organization', 'org24@test.com', '0770000024', 'Address1', 'Address2', 'Kandy', 0),
    ('Org_25', 'Organization', 'org25@test.com', '0770000025', 'Address1', 'Address2', 'Colombo', 0);

# Add Blood Banks
INSERT INTO BloodBanks (BloodBank_ID, BankName, Address1, Address2, City, Telephone_No)
VALUES
    ('BB_03', 'Blood Bank 3', 'No 3', 'Colombo 03', 'Colombo', '0110000001'),
    ('BB_04', 'Blood Bank 4', 'No 4', 'Colombo 04', 'Colombo', '0110000002'),
    ('BB_05', 'Blood Bank 5', 'No 5', 'Colombo 05', 'Colombo', '0110000003'),
    ('BB_06', 'Blood Bank 6', 'No 6', 'Colombo 06', 'Colombo', '0110000004'),
    ('BB_07', 'Blood Bank 7', 'No 7', 'Colombo 07', 'Colombo', '0110000005'),
    ('BB_08', 'Blood Bank 8', 'No 8', 'Colombo 08', 'Colombo', '0110000006'),
    ('BB_09', 'Blood Bank 9', 'No 9', 'Colombo 09', 'Colombo', '0110000007'),
    ('BB_10', 'Blood Bank 10', 'No 10', 'Colombo 10', 'Colombo', '0110000008'),
    ('BB_11', 'Blood Bank 11', 'No 11', 'Colombo 11', 'Colombo', '0110000009'),
    ('BB_12', 'Blood Bank 12', 'No 12', 'Colombo 12', 'Colombo', '0110000010'),
    ('BB_13', 'Blood Bank 13', 'No 13', 'Colombo 13', 'Colombo', '0110000011'),
    ('BB_14', 'Blood Bank 14', 'No 14', 'Colombo 14', 'Colombo', '0110000012'),
    ('BB_15', 'Blood Bank 15', 'No 15', 'Colombo 15', 'Colombo', '0110000013'),
    ('BB_16', 'Blood Bank 16', 'No 16', 'Colombo 16', 'Colombo', '0110000014'),
    ('BB_17', 'Blood Bank 17', 'No 17', 'Colombo 17', 'Colombo', '0110000015'),
    ('BB_18', 'Blood Bank 18', 'No 18', 'Colombo 18', 'Colombo', '0110000016'),
    ('BB_19', 'Blood Bank 19', 'No 19', 'Colombo 19', 'Colombo', '0110000017'),
    ('BB_20', 'Blood Bank 20', 'No 20', 'Colombo 20', 'Colombo', '0110000018');
# Create Medical Officers
INSERT INTO Users (UID, Email, Password, Account_Status, Role)
VALUES
    ('Mof_02', 'mofficer2@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_03', 'mofficer3@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_04', 'mofficer4@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_05', 'mofficer5@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_06', 'mofficer6@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_07', 'mofficer7@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_08', 'mofficer8@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_09', 'mofficer9@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_10', 'mofficer10@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_11', 'mofficer11@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_12', 'mofficer12@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_13', 'mofficer13@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_14', 'mofficer14@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_15', 'mofficer15@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_16', 'mofficer16@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_17', 'mofficer17@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_18', 'mofficer18@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer'),
    ('Mof_19', 'mofficer19@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0,'MedicalOfficer');
INSERT INTO MedicalOfficers (Officer_ID, First_Name, Last_Name, Address1, Address2, City, Contact_No, Email,
                             Branch_ID,Registration_Number, NIC, Position, Gender, Nationality)
VALUES ('Mof_02', 'Saman', 'Silva', 'No 20', 'Galle Road', 'Colombo', '0772000000', 'mofficer3@test.com', 'BB_02','12345',
        '200009000002', 'Doctor', 'M', 'Sri Lankan'),
       ('Mof_03', 'Kamal', 'Fernando', 'No 54', 'Piliyandala Road', 'Nugegoda', '0773000000', 'mofficer4@test.com', 'BB_03','12346',
        '200004400004', 'Doctor', 'M', 'Sri Lankan'),
       ('Mof_04', 'Nuwan', 'Rathnayake', 'No 12', 'Rajagiriya Road', 'Rajagiriya', '0774000000', 'mofficer5@test.com', 'BB_04','12347',
        '200006500001', 'Doctor', 'M', 'Sri Lankan'),
       ('Mof_05', 'Kasun', 'Nanayakkara', 'No 37', 'Dehiwala Road', 'Mt Lavinia', '0775000000', 'mofficer6@test.com', 'BB_05','12348',
        '200008700003', 'Doctor', 'M', 'Sri Lankan'),
       ('Mof_06', 'Chathura', 'Wijesinghe', 'No 64', 'High Level Road', 'Nugegoda', '0776000000', 'mofficer7@test.com', 'BB_06','12349',
        '200004200005', 'Doctor', 'M', 'Sri Lankan'),
       ('Mof_07', 'Dilani', 'Amarasinghe', 'No 10', 'Galle Road', 'Dehiwala', '0777000000', 'mofficer8@test.com', 'BB_07','12350',
        '200009100002', 'Doctor', 'F', 'Sri Lankan'),
       ('Mof_08', 'Gihan', 'Jayasinghe', 'No 53', 'Havelock Road', 'Colombo', '0778000000', 'mofficer9@test.com', 'BB_08','12351',
        '200007500002', 'Doctor', 'M', 'Sri Lankan'),
       ('Mof_09', 'Lakshika', 'Fernando', 'No 28', 'Kotte Road', 'Rajagiriya', '0779000000', 'mofficer10@test.com', 'BB_09','12352',
        '200004300006', 'Doctor', 'F', 'Sri Lankan'),
       ('Mof_10', 'Thilina', 'Silva', 'No 15', 'Nawala Road', 'Nugegoda', '0771000000', 'mofficer11@test.com', 'BB_10','12353',
        '200007200001', 'Doctor', 'M', 'Sri Lankan'),
       ('Mof_11', 'Kamal', 'Silva', 'No 04', 'Galle Road', 'Colombo 06', '0712000000', 'kamal.silva@test.com', 'BB_02','12354',
        '199607220012', 'Doctor', 'M', 'Sri Lankan'),
       ('Mof_12', 'Saman', 'Fernando', 'No 1/1', 'Malabe Road', 'Athurugiriya', '0773000000', 'samanf@test.com', 'BB_03','12355',
        '198912050023', 'Nurse', 'M', 'Sri Lankan'),
       ('Mof_13', 'Ishara', 'Ratnayake', 'No 14', 'High Level Road', 'Maharagama', '0774000000', 'ishara.r@test.com', 'BB_01','12356',
        '199712010040', 'Doctor', 'F', 'Sri Lankan'),
       ('Mof_14', 'Chamara', 'Fernando', 'No 10', 'Peradeniya Road', 'Kandy', '0715000000', 'cfernando@test.com', 'BB_04','12357',
        '199011070015', 'Nurse', 'M', 'Sri Lankan'),
       ('Mof_15', 'Chathura', 'Bandara', 'No 22', 'Galle Road', 'Hikkaduwa', '0766000000', 'chathura.b@test.com', 'BB_05','12358',
        '199412160011', 'Doctor', 'M', 'Sri Lankan'),
       ('Mof_16', 'Sanjaya', 'Jayasuriya', 'No 17', 'Rajagiriya Road', 'Rajagiriya', '0777000000', 'sanjay.j@test.com', 'BB_02','12359',
        '198811230004', 'Doctor', 'M', 'Sri Lankan'),
       ('Mof_17', 'Nisansala', 'Fernando', 'No 05', 'Nawala Road', 'Nugegoda', '0718000000', 'nisansala.f@test.com', 'BB_03','12360',
        '199611290035', 'Nurse', 'F', 'Sri Lankan'),
       ('Mof_18', 'Tharindu', 'Kumarasinghe', 'No 6/1', 'Dehiwala Road', 'Boralasgamuwa', '0769000000', 'tharindu.k@test.com', 'BB_04','12361',
        '199306100014', 'Doctor', 'M', 'Sri Lankan'),
       ('Mof_19', 'Sajith', 'Perera', 'No 08', 'Kurunegala Road', 'Kegalle', '0770000000', 'sajith.p@test.com', 'BB_05','12362',
        '199803220032', 'Nurse', 'M', 'Sri Lankan');

# Create Sponsors
INSERT INTO Users (UID, Email, Password, Account_Status, Role)
VALUES ('Spn_02', 'sponsor2@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_03', 'sponsor3@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_04', 'sponsor4@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_05', 'sponsor5@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_06', 'sponsor6@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_07', 'sponsor7@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_08', 'sponsor8@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_09', 'sponsor9@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_10', 'sponsor10@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_11', 'sponsor11@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_12', 'sponsor12@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_13', 'sponsor13@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_14', 'sponsor14@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_15', 'sponsor15@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_16', 'sponsor16@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_17', 'sponsor17@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_18', 'sponsor18@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_19', 'sponsor19@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_20', 'sponsor20@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_21', 'sponsor21@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_22', 'sponsor22@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_23', 'sponsor23@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_24', 'sponsor24@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_25', 'sponsor25@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_26', 'sponsor26@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_27', 'sponsor27@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_28', 'sponsor28@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_29', 'sponsor29@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_30', 'sponsor30@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_31', 'sponsor31@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_32', 'sponsor32@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_33', 'sponsor33@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor'),
       ('Spn_34', 'sponsor34@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Sponsor');
INSERT INTO Sponsors (SPONSOR_ID, Sponsor_Name, Email, ADDRESS1, ADDRESS2, CITY, STATUS)
VALUES
    ('Spn_02', 'Prasanna and Sons (Pvt) Ltd', 'sponsor2@test.com', 'Maharagama', 'Colombo 01', 'Colombo', 0),
    ('Spn_03', 'ABC (Pvt) Ltd', 'sponsor3@test.com', 'No. 10, Galle Road', 'Colombo 03', 'Colombo', 0),
    ('Spn_04', 'Green Lanka (Pvt) Ltd', 'sponsor4@test.com', 'No. 56, High Level Road', 'Maharagama', 'Colombo', 0),
    ('Spn_05', 'Lanka Coir Products', 'sponsor5@test.com', 'No. 235, Galle Road', 'Mount Lavinia', 'Colombo', 0),
    ('Spn_06', 'Siddhalepa Group of Companies', 'sponsor6@test.com', 'No. 1, Indigolla', 'Miriswatta', 'Gampaha', 0),
    ('Spn_07', 'Hemas Holdings PLC', 'sponsor7@test.com', 'No. 36, Sir Ernest de Silva Mawatha', 'Colombo 07', 'Colombo', 0),
    ('Spn_08', 'Ceylon Biscuits Limited', 'sponsor8@test.com', 'No. 148, A.S. Jayawardena Mawatha', 'Colombo 10', 'Colombo', 0),
    ('Spn_09', 'Brandix Lanka Limited', 'sponsor9@test.com', 'Level 2, Hemas House', 'Colombo 02', 'Colombo', 0),
    ('Spn_10', 'Hayleys PLC', 'sponsor10@test.com', 'No. 25, Foster Lane', 'Colombo 10', 'Colombo', 0),
    ('Spn_11', 'Cargills (Ceylon) PLC', 'sponsor11@test.com', 'No. 40, York Street', 'Colombo 01', 'Colombo', 0),
    ('Spn_12', 'Singer (Sri Lanka) PLC', 'sponsor12@test.com', 'No. 80, Nawam Mawatha', 'Colombo 02', 'Colombo', 0),
    ('Spn_13', 'John Keells Holdings PLC', 'sponsor13@test.com', 'No. 10, Velona Street', 'Colombo 02', 'Colombo', 0),
    ('Spn_14', 'Aitken Spence PLC', 'sponsor14@test.com', 'No. 315, Vauxhall Street', 'Colombo 02', 'Colombo', 0),
    ('Spn_15', 'JAT Holdings (Pvt) Ltd', 'sponsor15@test.com', 'No. 253, Nawala Road', 'Nawala', 'Colombo', 0),
    ('Spn_16', 'George Steuart Group', 'sponsor16@test.com', 'No. 130, Glennie Street', 'Colombo 02', 'Colombo', 0),
    ('Spn_17', 'Sampath Bank PLC', 'sponsor17@test.com', 'No. 110, Sir James Peiris Mawatha', 'Colombo 02', 'Colombo', 0),
    ('Spn_18', 'National Development Bank PLC', 'sponsor18@test.com', 'No. 40, Nawam Mawatha', 'Colombo 02', 'Colombo', 0),
    ('Spn_19', 'John Keels Holdings PLC', 'sponsor19@test.com', 'No. 10, Ward Place', 'Colombo 07', 'Colombo', 0),
    ('Spn_20', 'Sampath Bank PLC', 'sponsor20@test.com', 'No. 110, Sir James Pieris Mawatha', 'Colombo 02', 'Colombo', 0),
    ('Spn_21', 'Dialog Axiata PLC', 'sponsor21@test.com', 'No. 475, Union Place', 'Colombo 02', 'Colombo', 0),
    ('Spn_22', 'Commercial Bank of Ceylon PLC', 'sponsor22@test.com', 'No. 21, Sir Razik Fareed Mawatha', 'Colombo 01', 'Colombo', 0),
    ('Spn_23', 'Aitken Spence PLC', 'sponsor23@test.com', 'No. 315, Vauxhall Street', 'Colombo 02', 'Colombo', 0),
    ('Spn_24', 'Hemas Holdings PLC', 'sponsor24@test.com', 'No. 75, Braybrooke Place', 'Colombo 02', 'Colombo', 0),
    ('Spn_25', 'Singer (Sri Lanka) PLC', 'sponsor25@test.com', 'No. 80, Nawala Road', 'Nugegoda', 'Colombo', 0),
    ('Spn_26', 'Sri Lanka Telecom PLC', 'sponsor26@test.com', 'No. 19, Sir Chittampalam A. Gardiner Mawatha', 'Colombo 02', 'Colombo', 0),
    ('Spn_27', 'Hayleys PLC', 'sponsor27@test.com', 'No. 25, Foster Lane', 'Colombo 10', 'Colombo', 0),
    ('Spn_28', 'Brandix Apparel Solutions', 'sponsor28@test.com', 'No. 94, Horana Road', 'Piliyandala', 'Colombo', 1),
    ('Spn_29', 'John Keells Holdings PLC', 'sponsor29@test.com', 'No. 10, York Street', 'Colombo 01', 'Colombo', 0),
    ('Spn_30', 'Ceylon Tea Board', 'sponsor30@test.com', 'No. 574, Galle Road', 'Colombo 03', 'Colombo', 1),
    ('Spn_31', 'Hemas Holdings PLC', 'sponsor31@test.com', 'No. 75, Braybrooke Street', 'Colombo 02', 'Colombo', 0),
    ('Spn_32', 'Dialog Axiata PLC', 'sponsor32@test.com', 'No. 475, Union Place', 'Colombo 02', 'Colombo', 1),
    ('Spn_33', 'Singer Sri Lanka PLC', 'sponsor33@test.com', 'No. 80, Nawam Mawatha', 'Colombo 02', 'Colombo', 0),
    ('Spn_34', 'Sampath Bank PLC', 'sponsor34@test.com', 'No. 110, Sir James Pieris Mawatha', 'Colombo 02', 'Colombo', 1);



# Create Campaigns
INSERT INTO Campaign (Campaign_ID, Campaign_Name, Organization_ID, Campaign_Description, Campaign_Date, Venue, Nearest_City, Status, Latitude, Longitude, Nearest_BloodBank, Expected_Amount)
VALUES
    ('Cmp_02', 'Hope Blood Drive', 'Org_02', 'Help us save lives by donating blood!', '2023-03-10', 'Kandy Road', 'Kegalle', 1, 7.2518, 80.3467, 'BB_02', 8000),
    ('Cmp_03', 'Blood for All', 'Org_03', 'Join us in our mission to provide blood to those in need.', '2023-03-12', 'Galle Road', 'Hikkaduwa', 1, 6.1381, 80.1032, 'BB_03', 5000),
    ('Cmp_04', 'Life Saver Campaign', 'Org_04', 'Be a hero and donate blood!', '2023-03-15', 'Dharmapala Mawatha', 'Kandy', 1, 7.2906, 80.6337, 'BB_04', 12000),
    ('Cmp_05', 'Blood Drive Colombo', 'Org_05', 'Help us meet the urgent demand for blood in Colombo.', '2023-03-18', 'Bauddhaloka Mawatha', 'Colombo 07', 1, 6.9018, 79.8578, 'BB_05', 9000),
    ('Cmp_06', 'Together for Life', 'Org_06', 'Let us come together to save lives through blood donation.', '2023-03-20', 'Temple Road', 'Anuradhapura', 1, 8.3526, 80.4018, 'BB_06', 6000),
    ('Cmp_07', 'Give the Gift of Life', 'Org_07', 'Donate blood today and help save a life tomorrow.', '2023-03-22', 'Mahiyangana Road', 'Badulla', 1, 6.9923, 81.0552, 'BB_07', 4000),
    ('Cmp_08', 'Blood Donation Drive', 'Org_08', 'Join us in this noble cause and donate blood to save lives.', '2023-03-25', 'Matale Road', 'Gampola', 1, 7.1777, 80.5722, 'BB_08', 10000),
    ('Cmp_09', 'Blood for Life', 'Org_09', 'Help us reach our goal of collecting 5000 pints of blood.', '2023-03-28', 'Kalmunai Road', 'Ampara', 1, 7.2962, 81.6743, 'BB_09', 5000),
    ('Cmp_10', 'Be a Life Saver', 'Org_10', 'Your blood donation can make a big difference in someone\'s life.', '2023-03-30', 'Nawala Road', 'Nugegoda', 1, 6.8731, 79.8906, 'BB_10', 7000),
    ('Cmp_11', 'Save a Life Today', 'Org_11', 'Join us in our mission to save lives through blood donation.', '2023-04-01', 'Kandy Road', 'Kandy', 1, 7.2906, 80.6337, 'BB_11', 8000),
    ('Cmp_12', 'Blood Donation Camp', 'Org_12', 'Donate blood and become a life saver.', '2023-04-02', 'Negombo Road', 'Kurunegala', 1, 7.4915, 80.3631, 'BB_11', 8000),
    ('Cmp_13', 'Blood Bank Drive', 'Org_13', 'Help us collect blood for our blood bank.', '2023-04-05', 'Kandy-Jaffna Highway', 'Vavuniya', 1, 8.7519, 80.4989, 'BB_12', 4000),
    ('Cmp_14', 'Donate Blood, Save Lives', 'Org_14', 'Your blood can be the difference between life and death.', '2023-04-08', 'Habarana Road', 'Polonnaruwa', 1, 7.9406, 81.0187, 'BB_13', 10000),
    ('Cmp_15', 'Be a Blood Donor', 'Org_15', 'Join us in this life saving cause by donating blood.', '2023-04-10', 'Kotte Road', 'Rajagiriya', 1, 6.9025, 79.8936, 'BB_14', 5000),
    ('Cmp_16', 'Save Lives with Blood Donation', 'Org_16', 'Make a difference in someone\'s life by donating blood today.', '2023-04-12', 'Havelock Road', 'Colombo 05', 1, 6.8949, 79.8665, 'BB_15', 7000);

# Add 2 Month to Campaign Date
UPDATE Campaign SET Campaign_Date = DATE_ADD(Campaign_Date, INTERVAL 2 MONTH);

# Add Sample Data to the Donor TABLE
use bepositive;
INSERT INTO users(UID, Email, Password) VALUES
('Dnr_02', 'john@test.com','$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_03', 'peter@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_04', 'mary@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_05', 'sarah@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_06', 'david@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_07', 'samantha@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_08', 'robert@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_09', 'linda@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_10', 'samuel@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_11', 'sophias@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_12', 'michael@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_13', 'julia@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_14', 'christopher@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_15', 'emily@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_16', 'adam@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_17', 'olivia@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_20', 'emma@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_21', 'benjamin@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_22', 'chloe@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_23', 'mason@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_24', 'isabella@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_25', 'ethan@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_26', 'sophia@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_27', 'alexander@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS'),
('Dnr_28', 'madison@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS');

INSERT INTO Donors (DONOR_ID, FIRST_NAME, LAST_NAME, ADDRESS1, ADDRESS2, CITY, NEAREST_BANK, CONTACT_NO, EMAIL, NIC,
                    GENDER, STATUS,BloodGroup)
VALUES ('Dnr_02', 'John','Fernando','No 15','Colombo 05','Colombo','BB_01','0771234567','john@test.com','200017800001','M',0,'A+'),
       ('Dnr_03', 'Peter','Fernando','No 5','Colombo 06','Colombo','BB_01','0771234567','peter@test.com','200017800002','M',0,'A+'),
       ('Dnr_04', 'Mary','Fernando','No 8','Kandy','Colombo','BB_01','0771234567','mary@test.com','200017800003','F',0,'A+'),
       ('Dnr_05', 'Sarah','Silva','No 20','Colombo 07','Colombo','BB_01','0771234567','sarah@test.com','200017800004','F',0,'A+'),
       ('Dnr_06', 'David','Silva','No 10','Colombo 08','Colombo','BB_01','0771234567','david@test.com','200017800005','M',0,'A+'),
       ('Dnr_07', 'Samantha','Silva','No 7','Colombo 09','Colombo','BB_01','0771234567','samantha@test.com','200017800006','F',0,'A+'),
       ('Dnr_08', 'Robert','Silva','No 3','Colombo 10','Colombo','BB_01','0771234567','robert@test.com','200017800007','M',0,'A+'),
       ('Dnr_09', 'Linda','Perera','No 9','Colombo 11','Colombo','BB_01','0771234567','linda@test.com','200017800008','F',0,'A+'),
       ('Dnr_10', 'Samuel','Perera','No 1','Colombo 12','Colombo','BB_01','0771234567','samuel@test.com','200017800009','M',0,'A+'),
       ('Dnr_11', 'Sophia','Perera','No 12','Colombo 13','Colombo','BB_01','0771234567','sophias@test.com','200017800010','F',0,'A+'),
       ('Dnr_12', 'Michael','Fernando','No 6','Colombo 14','Colombo','BB_01','0771234567','michael@test.com','200017800011','M',0,'A+'),
       ('Dnr_13', 'Julia','Fernando','No 15','Colombo 15','Colombo','BB_01','0771234567','julia@test.com','200017800012','F',0,'A+'),
       ('Dnr_14', 'Christopher','Fernando','No 7','Colombo 16','Colombo','BB_01','0771234567','christopher@test.com','200017800013','M',0,'A+'),
       ('Dnr_15', 'Emily','Jayawardena','No 5','Colombo 17','Colombo','BB_01','0771234567','emily@test.com','200017800014','F',0,'A+'),
       ('Dnr_16', 'Adam','Jayawardena','No 11','Colombo 18','Colombo','BB_01','0771234567','adam@test.com','200017800015','M',0,'A+'),
       ('Dnr_17', 'Olivia','Jayawardena','No 2','Colombo 19','Colombo','BB_01','0771234567','olivia@test.com','200017800016','F',0,'A+'),
       ('Dnr_20', 'Emma', 'Rodriguez', 'No 14', 'Colombo 13', 'Colombo', 'BB_01', '0771234567', 'emma@test.com', '200017800112', 'F', 0,"O+"),
       ('Dnr_21', 'Benjamin', 'Wilson', 'No 18', 'Colombo 14', 'Colombo', 'BB_03', '0771234567', 'benjamin@test.com', '200017800113', 'M', 0,"O+"),
       ('Dnr_22', 'Chloe', 'Martinez', 'No 21', 'Colombo 15', 'Colombo', 'BB_01', '0771234567', 'chloe@test.com', '200017800114', 'F', 0,"O+"),
       ('Dnr_23', 'Mason', 'Anderson', 'No 15', 'Galle', 'Colombo', 'BB_02', '0771234567', 'mason@test.com', '200017800115', 'M', 0,"O+"),
       ('Dnr_24', 'Isabella', 'Thomas', 'No 11', 'Colombo 16', 'Colombo', 'BB_01', '0771234567', 'isabella@test.com', '200017800116', 'F', 0,"O+"),
       ('Dnr_25', 'Ethan', 'Jackson', 'No 24', 'Colombo 17', 'Colombo', 'BB_04', '0771234567', 'ethan@test.com', '200017800117', 'M', 0,"O+"),
       ('Dnr_26', 'Sophia', 'White', 'No 17', 'Negombo', 'Colombo', 'BB_01', '0771234567', 'sophia@test.com', '200017800118', 'F', 0,"O+"),
       ('Dnr_27', 'Alexander', 'Harris', 'No 6', 'Colombo 18', 'Colombo', 'BB_03', '0771234567', 'alexander@test.com', '200017800119', 'M', 0,"O+"),
       ('Dnr_28', 'Madison', 'Clark', 'No 13', 'Colombo 19', 'Colombo', 'BB_01', '0771234567', 'madison@test.com', '200017800120', 'F', 0,"O+");

# Create Hospitals
INSERT INTO Users (UID, Email, Password, Account_Status, Role)
VALUES
    ('Hos_02', 'hos2@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_03', 'hos3@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_04', 'hos4@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_05', 'hos5@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_06', 'hos6@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_07', 'hos7@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_08', 'hos8@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_09', 'hos9@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_10', 'hos10@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_11', 'hos11@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_12', 'hos12@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_13', 'hos13@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_14', 'hos14@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_15', 'hos15@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital'),
    ('Hos_16', 'hos16@test.com', '$2y$10$yjcyB1lr8V/nVciydOYedu0Rnedd9JHZ3d6PqPMqM4yNJoPmltlZS', 0, 'Hospital');
INSERT INTO Hospitals (Hospital_ID, Hospital_Name, Email, Address1, Address2, City, Contact_No,Nearest_Blood_Bank)
VALUES
    ('Hos_02', 'Asiri Hospital', 'hos2@test.com', 'No. 181, Kirula Road', 'Narahenpita', 'Colombo', '0114524401','BB_01'),
    ('Hos_03', 'Lanka Hospitals', 'hos3@test.com', '578, Elvitigala Mawatha', 'Narahenpita', 'Colombo', '0115530002','BB_01'),
    ('Hos_04', 'Durdans Hospital', 'hos4@test.com', '3, Alfred Place', 'Colombo 03', 'Colombo', '0112140034','BB_01'),
    ('Hos_05', 'Nawaloka Hospitals', 'hos5@test.com', '23, Deshamanya H.K. Dharmadasa Mawatha', 'Colombo 02', 'Colombo', '0115430056','BB_01'),
    ('Hos_06', 'Hemas Hospitals', 'hos6@test.com', '389, Negombo Road', 'Wattala', 'Colombo', '0117507777','BB_01'),
    ('Hos_07', 'Sri Jayawardenapura General Hospital', 'hos7@test.com', 'Hospital Road', 'Thalapathpitiya', 'Nugegoda', '0112841607','BB_01'),
    ('Hos_08', 'Apeksha Hospital', 'hos8@test.com', 'Maharagama', 'Colombo', 'Maharagama', '0112841601','BB_01'),
    ('Hos_09', 'National Hospital of Sri Lanka', 'hos9@test.com', 'Regent Street', 'Colombo 08', 'Colombo', '0112691111','BB_01'),
    ('Hos_10', 'Kalubowila Teaching Hospital', 'hos10@test.com', 'Horton Place', 'Dehiwala-Mount Lavinia', 'Dehiwala', '0112769711','BB_01'),
    ('Hos_11', 'Karapitiya Teaching Hospital', 'hos11@test.com', 'Galle', 'Galle', 'Galle', '0912232255','BB_01'),
    ('Hos_12', 'Teaching Hospital Anuradhapura', 'hos12@test.com', '670, Maithreepala Senanayake Mawatha', 'Anuradhapura', 'Anuradhapura', '0252222261','BB_01'),
    ('Hos_13', 'Teaching Hospital Batticaloa', 'hos13@test.com', 'Kallady', 'Batticaloa', 'Batticaloa', '0652222261','BB_01'),
    ('Hos_14', 'Teaching Hospital Jaffna', 'hos14@test.com', 'Hospital Road', 'Jaffna', 'Jaffna', '0212222261','BB_01'),
    ('Hos_15', 'Teaching Hospital Kandy', 'hos15@test.com', 'Srimath Kudarathwatta Mawatha', 'Kandy', 'Kandy', '0812222261','BB_01'),
    ('Hos_16', 'Teaching Hospital Karawanella', 'hos16@test.com', 'Nittambuwa Road', 'Karawanella', 'Karawanella', '0365675511','BB_01');

# Create Sample Data for Blood Requests
INSERT INTO Blood_Requests(Request_ID, Requested_By, BloodGroup, Requested_At, Type, Status,Volume,Request_From)
VALUES
('Req_01', 'Hos_01', 'A+', '2023-03-06 00:00:00', 1, 1,100,'BB_01'),
('Req_02', 'Hos_01', 'A+', '2023-03-06 00:00:00', 1, 1,100,'BB_01'),
('Req_03', 'Hos_01', 'A+', '2023-03-06 00:00:00', 1, 1,100,'BB_01'),
('Req_04', 'Hos_01', 'A+', '2023-03-06 00:00:00', 1, 1,100,'BB_01'),
('Req_05', 'Hos_01', 'A+', '2023-03-06 00:00:00', 1, 1,100,'BB_01'),
('Req_06', 'Hos_01', 'A+', '2023-03-06 00:00:00', 1, 1,100,'BB_01'),
('Req_07', 'Hos_01', 'A+', '2023-03-06 00:00:00', 1, 1,100,'BB_01'),
('Req_08', 'Hos_01', 'A+', '2023-03-06 00:00:00', 1, 1,100,'BB_01'),
('Req_09', 'Hos_01', 'A+', '2023-03-06 00:00:00', 1, 1,100,'BB_01'),
('Req_10', 'Hos_01', 'A+', '2023-03-06 00:00:00', 1, 1,100,'BB_01'),
('Req_11', 'Hos_01', 'A+', '2023-03-06 00:00:00', 1, 1,100,'BB_01'),
('Req_12', 'Hos_01', 'A+', '2023-03-06 00:00:00', 1, 1,100,'BB_01'),
('Req_13', 'Hos_01', 'A+', '2023-03-06 00:00:00', 1, 1,100,'BB_01'),
('Req_14', 'Hos_01', 'A+', '2023-03-06 00:00:00', 1, 1,100,'BB_01'),
('Req_15', 'Hos_01', 'A+', '2023-03-06 00:00:00', 1,1,100,'BB_01');

