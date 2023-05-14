<?php

namespace App\model\Utils;

use Core\Application;

class Backup extends \App\model\database\dbModel
{
    public const BACKUP_SUCCESS = 1;
    public const BACKUP_DOWNLOAD = 2;

    protected string $Backup_ID='';
    protected string $Backup_Name='';
    protected string $Backup_Date='';
    protected int $Backup_Status=1;
    protected string $Backup_Path='';
    protected string $Backup_Size='';

    private static function backupDatabaseFile(string $getBackupName): string
    {
        $backup_name = $getBackupName . '.sql';
        $backup_path = '../Backups/' . $backup_name;
        $command = 'mysqldump --user=' . DB_USER . ' --password=' . DB_PASSWORD . ' --host=' . DB_HOST . ' ' . DB_NAME . ' > ' . $backup_path;
        exec($command);
        return $backup_path;
    }

    /**
     * @return string
     */
    public function getBackupID(): string
    {
        return $this->Backup_ID;
    }

    /**
     * @param string $Backup_ID
     */
    public function setBackupID(string $Backup_ID): void
    {
        $this->Backup_ID = $Backup_ID;
    }

    /**
     * @return string
     */
    public function getBackupName(): string
    {
        return $this->Backup_Name;
    }

    /**
     * @param string $Backup_Name
     */
    public function setBackupName(string $Backup_Name): void
    {
        $this->Backup_Name = $Backup_Name;
    }

    /**
     * @return string
     */
    public function getBackupDate(): string
    {
        return $this->Backup_Date;
    }

    /**
     * @param string $Backup_Date
     */
    public function setBackupDate(string $Backup_Date): void
    {
        $this->Backup_Date = $Backup_Date;
    }

    /**
     * @return int
     */
    public function getBackupStatus(): int
    {
        return $this->Backup_Status;
    }

    /**
     * @param int $Backup_Status
     */
    public function setBackupStatus(int $Backup_Status): void
    {
        $this->Backup_Status = $Backup_Status;
    }

    /**
     * @return string
     */
    public function getBackupPath(): string
    {
        return $this->Backup_Path;
    }

    /**
     * @param string $Backup_Path
     */
    public function setBackupPath(string $Backup_Path): void
    {
        $this->Backup_Path = $Backup_Path;
    }

    /**
     * @return string
     */
    public function getBackupSize(): string
    {
        return $this->Backup_Size;
    }

    /**
     * @param string $Backup_Size
     */
    public function setBackupSize(string $Backup_Size): void
    {
        $this->Backup_Size = $Backup_Size;
    }



    public function labels(): array
    {
        return [
            'Backup_ID' => 'Backups ID',
            'Backup_Name' => 'Backups Name',
            'Backup_Date' => 'Backups Date',
            'Backup_Status' => 'Backups Status',
            'Backup_Path' => 'Backups Path',
            'Backup_Size' => 'Backups Size',
        ];
    }

    public function rules(): array
    {
        return [
            'Backup_ID' => [self::RULE_REQUIRED],
            'Backup_Name' => [self::RULE_REQUIRED],
            'Backup_Date' => [self::RULE_REQUIRED],
            'Backup_Status' => [self::RULE_REQUIRED],
            'Backup_Path' => [self::RULE_REQUIRED],
            'Backup_Size' => [self::RULE_REQUIRED],
        ];
    }

    public static function getTableShort(): string
    {
        return 'backup';
    }

    public static function tableName(): string
    {
        return 'Backups';
    }

    public static function PrimaryKey(): string
    {
        return 'Backup_ID';
    }

    public function attributes(): array
    {
        return [
            'Backup_ID',
            'Backup_Name',
            'Backup_Date',
            'Backup_Status',
            'Backup_Path',
            'Backup_Size',
        ];
    }

    public static function backupDatabase()
    {
        $backup = new self();
        $backup->setBackupID(uniqid("Backup_"));
        $backup->setBackupName('Backup_'.date('Y-m-d_H-i-s'));
        $backup->setBackupDate(date('Y-m-d H:i:s'));
        $backup->setBackupStatus(self::BACKUP_SUCCESS);
        $backup->setBackupPath('public/backup/');
        // Backups database
        $backupFile = self::backupDatabaseFile($backup->getBackupName());
        $backup->setBackupSize(filesize($backupFile));
        if ($backup->save()){
            return true;
        }else{
            return false;
        }


    }


}