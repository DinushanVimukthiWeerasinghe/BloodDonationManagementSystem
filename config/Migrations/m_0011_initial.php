<?php

namespace Config\Migrations;

use Core\Application;

class m_0011_initial
{
    public function up(): void
    {
        $db = Application::$app->db;
        $SQL = "CREATE TABLE Assign_Staff(
        Campaign_ID varchar(20) NOT NULL,
        Officer_ID varchar(20) NOT NULL,
        Assigned_By varchar(20) NOT NULL,
        Assigned_Date DATE NOT NULL,
        Assigned_As varchar(20) NOT NULL,
        PRIMARY KEY (Campaign_ID,Officer_ID),
        FOREIGN KEY(Campaign_ID) REFERENCES Donation_Campaign(Campaign_ID),
        FOREIGN KEY(Officer_ID) REFERENCES Medical_Officer(Officer_ID),
        FOREIGN KEY(Assigned_By) REFERENCES Blood_Bank_Manager(Manager_ID)
    
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