<?php

namespace Config\Migrations;

use Core\Application;

class m_0012_initial
{
    public function up(): void
    {
        $db = Application::$app->db;
        $SQL = "CREATE TABLE Blood_Pack_Remarks(
        Blood_Pack_ID varchar(20),
        Remarks varchar(255),
        PRIMARY KEY (Blood_Pack_ID,Remarks),
        FOREIGN KEY(Blood_Pack_ID) REFERENCES Accepted_Donation(Blood_Pack_ID)
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