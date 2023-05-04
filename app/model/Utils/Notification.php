<?php

namespace App\model\Utils;

use App\model\database\dbModel;

class Notification extends dbModel
{
    protected string $ID='';
    protected string $Target_User='';

    /**
     * @return string
     */
    public function getTargetUser(): string
    {
        return $this->Target_User;
    }

    /**
     * @param string $Target_User
     */
    public function setTargetUser(string $Target_User): void
    {
        $this->Target_User = $Target_User;
    }

    /**
     * @return string
     */
    public function getID(): string
    {
        return $this->ID;
    }

    /**
     * @param string $ID
     */
    public function setID(string $ID): void
    {
        $this->ID = $ID;
    }

    /**
     * @return string
     */
    public function getTargetID(): string
    {
        return $this->Target_ID;
    }

    /**
     * @param string $Target_ID
     */
    public function setTargetID(string $Target_ID): void
    {
        $this->Target_ID = $Target_ID;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->Title;
    }

    /**
     * @param string $Title
     */
    public function setTitle(string $Title): void
    {
        $this->Title = $Title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->Description;
    }

    /**
     * @param string $Description
     */
    public function setDescription(string $Description): void
    {
        $this->Description = $Description;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->Date;
    }

    /**
     * @param string $Date
     */
    public function setDate(string $Date): void
    {
        $this->Date = $Date;
    }

    /**
     * @return string
     */
    public function getTime(): string
    {
        return $this->Time;
    }

    /**
     * @param string $Time
     */
    public function setTime(string $Time): void
    {
        $this->Time = $Time;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->Status;
    }

    /**
     * @param string $Status
     */
    public function setStatus(string $Status): void
    {
        $this->Status = $Status;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->Type;
    }

    /**
     * @param string $Type
     */
    public function setType(string $Type): void
    {
        $this->Type = $Type;
    }
    protected string $Target_ID='';
    protected string $Title='';
    protected string $Description='';
    protected string $Date='';
    protected string $Time='';
    protected string $Status='';
    protected string $Type='';

    public function labels(): array
    {
        return [
            'ID'=>'ID',
            'Target_ID'=>'Target ID',
            'Title'=>'Title',
            'Description'=>'Description',
            'Date'=>'Date',
            'Time'=>'Time',
            'Status'=>'Status',
            'Type'=>'Type'
        ];
    }

    public function rules(): array
    {
        return [
            'ID'=>[self::RULE_REQUIRED],
            'Target_ID'=>[self::RULE_REQUIRED],
            'Title'=>[self::RULE_REQUIRED],
            'Description'=>[self::RULE_REQUIRED],
            'Date'=>[self::RULE_REQUIRED],
            'Time'=>[self::RULE_REQUIRED],
            'Status'=>[self::RULE_REQUIRED],
            'Type'=>[self::RULE_REQUIRED]
        ];
    }

    public static function getTableShort(): string
    {
        return 'notification';
    }

    public static function tableName(): string
    {
        return 'Notification';
    }

    public static function PrimaryKey(): string
    {
        return 'ID';
    }

    public function attributes(): array
    {
        return [
            'ID',
            'Target_ID',
            'Title',
            'Description',
            'Date',
            'Time',
            'Status',
            'Type'
        ];
    }
}