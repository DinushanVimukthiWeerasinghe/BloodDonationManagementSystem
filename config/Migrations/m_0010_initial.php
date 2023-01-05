<?php

namespace Config\Migrations;

use Core\Application;

class m_0010_initial
{
    public function up(): void
    {
        $db = Application::$app->db;
        $SQL = "CREATE TABLE Accepted_Donation(
        Donation_ID varchar(20) PRIMARY KEY,
        Donor_ID varchar(20) NOT NULL,
        Campaign_ID varchar(20) NOT NULL,
        Blood_Pack_ID varchar(20) NOT NULL,
        Donation_Date DATE NOT NULL,
        Donation_Amount float NOT NULL,
        In_Time TIME NOT NULL,
        Out_Time TIME NOT NULL,
        Remarks varchar(255) NULL,
        Blood_Taken_By varchar(20) NOT NULL,
        Examined_By varchar(20) NULL,
        Verified_By varchar(20) NULL,
        Donation_Status varchar(20) DEFAULT 'Pending',
        FOREIGN KEY(Donor_ID) REFERENCES Donor(Donor_ID),
        FOREIGN KEY(Campaign_ID) REFERENCES Campaign(Campaign_ID),
        FOREIGN KEY(Blood_Taken_By) REFERENCES Medical_Officer(Officer_ID),
        FOREIGN KEY(Examined_By) REFERENCES Medical_Officer(Officer_ID),
        FOREIGN KEY(Verified_By) REFERENCES Medical_Officer(Officer_ID)              
        )";
        $db->pdo->exec($SQL);
    }

    public function down(): void
    {
        $db = Application::$app->db;
        $SQL = "DROP TABLE `Donor`";
        $db->pdo->exec($SQL);

    }

}