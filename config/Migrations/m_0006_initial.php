<?php

namespace Config\Migrations;

use Core\Application;

class m_0006_initial
{
    public function up(): void
    {
        $db = Application::$app->db;
        $SQL = "CREATE TABLE Organization(
        Organization_ID varchar(20) PRIMARY KEY, 
        Organization_Name varchar(255) NOT NULL , 
        Registration_Number varchar(20) UNIQUE ,
        Established_Year DATE NOT NULL ,
        Organization_Type varchar(50) NOT NULL ,
        Email varchar(100) UNIQUE,
        WebSite varchar(100) NULL ,
        Contact_No varchar(12) UNIQUE ,
        Official_Address varchar(255) NOT NULL,
        Registration_Certificate varchar(100) NOT NULL,
        Verification_Status varchar(20) DEFAULT 'Pending',
        Verification_Date DATE NULL,
        Verified_By varchar(20) NULL,
        UnVerified_Reason varchar(255) NULL,
        Profile_Image varchar(100) DEFAULT '/public/upload/Default/Organization.jpg',
        FOREIGN KEY(Organization_ID) REFERENCES Users(ID),
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