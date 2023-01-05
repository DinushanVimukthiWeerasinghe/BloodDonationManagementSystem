<?php

namespace Config\Migrations;

use Core\Application;

class m_0001_initial
{
    public function up(): void
    {
        $db = Application::$app->db;
        $SQL = "CREATE TABLE Users( ID varchar(20) primary key , Email varchar(100) unique ,Password varchar(500), Role varchar(50) DEFAULT 'Donor', Status int(1) DEFAULT 0)";
        $db->pdo->exec($SQL);
    }

    public function down(): void
    {
        $db = Application::$app->db;
        $SQL = "DROP TABLE `Users`";
        $db->pdo->exec($SQL);

    }

}