<?php

namespace Config\Migrations;

use Core\Application;

class m_0007_initial
{
    public function up(): void
    {
        $db = Application::$app->db;
        $SQL = "CREATE TABLE Hospital(
        Hospital_ID varchar(20) PRIMARY KEY,
        Hospital_Name varchar(255) NOT NULL,
        Registration_Number varchar(20) UNIQUE,
        Established_Year DATE NOT NULL,
        Email varchar(100) UNIQUE,
        WebSite varchar(100) NULL,
        Contact_No varchar(12) UNIQUE,
        Official_Address varchar(255) NOT NULL,
        Hospital_Type varchar(50) NOT NULL,
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