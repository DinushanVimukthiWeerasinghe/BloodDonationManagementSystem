<?php

namespace Config\Migrations;

use Core\Application;

class m_0003_initial
{
    public function up(): void
    {
        $db = Application::$app->db;
        $SQL = "CREATE TABLE Blood_Bank_Branch(
        Branch_ID varchar(20) PRIMARY KEY ,
        Branch_Name varchar(20) NOT NULL,
        Branch_Address varchar(20) NOT NULL,
        Branch_Contact varchar(12) NOT NULL,
        Branch_Email varchar(100) NOT NULL,
        Branch_Type varchar(20) NOT NULL,
        Branch_Geo_Location varchar(20) NULL
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