<?php

namespace Config\Migrations;

use Core\Application;

class m_0005_initial
{
    public function up(): void
    {
        $db = Application::$app->db;
        $SQL = "CREATE TABLE Sponsors(
        Sponsor_ID varchar(20) PRIMARY KEY, 
        First_Name varchar(255) NOT NULL , 
        Last_Name varchar(255) NOT NULL , 
        NIC varchar(12) UNIQUE ,
        Email varchar(100) UNIQUE,
        Contact_No varchar(12) UNIQUE ,
        Address1 varchar(50) NULL ,
        Address2 varchar(50) NULL ,
        City varchar(50) NULL ,
        Join_Date DATE DEFAULT CURRENT_TIMESTAMP NOT NULL,
        Profile_Image varchar(100) DEFAULT '/public/upload/Default/Sponsor.jpg',
        FOREIGN KEY(Sponsor_ID) REFERENCES Users(ID)
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