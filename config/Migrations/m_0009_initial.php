<?php

namespace Config\Migrations;

use Core\Application;

class m_0009_initial
{
    public function up(): void
    {
        $db = Application::$app->db;
        $SQL = "CREATE TABLE Blood_Bank_Manager(
        Manager_ID varchar(20) PRIMARY KEY,
        First_Name varchar(20) NOT NULL,
        Last_Name varchar(20) NOT NULL,
        FullName varchar(50) NOT NULL,
        Email varchar(255) UNIQUE,
        NIC varchar(12) UNIQUE,
        Contact_Number varchar(20) NOT NULL,
        Address1 varchar(255) NOT NULL,
        Address2 varchar(255) NOT NULL,
        City varchar(20) NOT NULL,
        Branch_ID varchar(20) NOT NULL,
        Profile_Image varchar(255) NULL,
        Join_Date DATE NOT NULL DEFAULT CURRENT_DATE,
        FOREIGN KEY(Branch_ID) REFERENCES Blood_Bank_Branch(Branch_ID),
        FOREIGN KEY(Manager_ID) REFERENCES User(User_ID)            
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