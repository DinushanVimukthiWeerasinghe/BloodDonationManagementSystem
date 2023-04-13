<?php

namespace Config\Migrations;

use Core\Application;

class m_0008_initial
{
    public function up(): void
    {
        $db = Application::$app->db;
        $SQL = "CREATE TABLE Donation_Campaign(
        Campaign_ID varchar(20) NOT NULL,
        Organization_ID varchar(20) NOT NULL,
        Campaign_Name varchar(255) NOT NULL,
        Venue varchar(255) NOT NULL,
        Date DATE NOT NULL,
        StartTime TIME NOT NULL,
        EndTime TIME NOT NULL,
        Description varchar(255) NOT NULL,
        Nearest_Blood_Bank_ID varchar(255) NOT NULL,
        Verification_Status varchar(20) DEFAULT 'Pending',
        Verification_Date DATE NULL,
        Verified_By varchar(20) NULL,
        UnVerified_Reason varchar(255) NULL,
        PRIMARY KEY (Campaign_ID),
        FOREIGN KEY(Organization_ID) REFERENCES Organization(Organization_ID),
        FOREIGN KEY(Nearest_Blood_Bank_ID) REFERENCES Blood_Bank(Blood_Bank_ID),
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