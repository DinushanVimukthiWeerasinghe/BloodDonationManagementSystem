<?php

namespace Config\Migrations;

use Core\Application;

class m_0002_initial
{
    public function up(): void
    {
        $db = Application::$app->db;
        $SQL = "CREATE TABLE Donor(
        Donor_ID varchar(20) PRIMARY KEY, 
        First_Name varchar(100) NOT NULL ,
        Last_Name varchar(100) NOT NULL , 
        Full_Name varchar(200) NOT NULL , 
        NIC varchar(12) UNIQUE ,
        Email varchar(100) UNIQUE,
        Contact_No varchar(12) UNIQUE ,
        Address1 varchar(50) NOT NULL , 
        Address2 varchar(50) NOT NULL ,
        City varchar(50) NOT NULL ,
        Postal_Code varchar(50) NOT NULL ,
        Availability INT(1) DEFAULT 0,
        Profile_Image varchar(100) DEFAULT '/public/images/user.jpg',
        FOREIGN KEY(Donor_ID) REFERENCES Users(ID)
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