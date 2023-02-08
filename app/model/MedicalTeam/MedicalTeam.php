<?php

namespace App\model\MedicalTeam;

class MedicalTeam extends \App\model\database\dbModel
{
    protected string $Team_ID='';
    protected string $Campaign_ID='';
    protected string $Team_Leader_ID='';
    protected string $Assigned_At='';
    protected string $Assigned_Date='';

    /**
     * @return string
     */
    public function getTeamID(): string
    {
        return $this->Team_ID;
    }

    /**
     * @param string $Team_ID
     */
    public function setTeamID(string $Team_ID): void
    {
        $this->Team_ID = $Team_ID;
    }

    /**
     * @return string
     */
    public function getCampaignID(): string
    {
        return $this->Campaign_ID;
    }

    /**
     * @param string $Campaign_ID
     */
    public function setCampaignID(string $Campaign_ID): void
    {
        $this->Campaign_ID = $Campaign_ID;
    }

    /**
     * @return string
     */
    public function getTeamLeaderID(): string
    {
        return $this->Team_Leader_ID;
    }

    /**
     * @param string $Team_Leader_ID
     */
    public function setTeamLeaderID(string $Team_Leader_ID): void
    {
        $this->Team_Leader_ID = $Team_Leader_ID;
    }

    /**
     * @return string
     */
    public function getAssignedAt(): string
    {
        return $this->Assigned_At;
    }

    /**
     * @param string $Assigned_At
     */
    public function setAssignedAt(string $Assigned_At): void
    {
        $this->Assigned_At = $Assigned_At;
    }

    /**
     * @return string
     */
    public function getAssignedDate(): string
    {
        return $this->Assigned_Date;
    }

    /**
     * @param string $Assigned_Date
     */
    public function setAssignedDate(string $Assigned_Date): void
    {
        $this->Assigned_Date = $Assigned_Date;
    }



    public function labels(): array
    {
        return [
            'Team_ID' => 'Team ID',
            'Campaign_ID' => 'Campaign ID',
            'Team_Leader_ID' => 'Team Leader ID',
            'Assigned_At' => 'Assigned At',
            'Assigned_Date' => 'Assigned Date'
        ];
    }

    public function rules(): array
    {
        return [
            'Team_ID' => [self::RULE_REQUIRED],
            'Campaign_ID' => [self::RULE_REQUIRED],
            'Team_Leader_ID' => [self::RULE_REQUIRED],
            'Assigned_At' => [self::RULE_REQUIRED],
            'Assigned_Date' => [self::RULE_REQUIRED]
        ];
    }

    public static function getTableShort(): string
    {
        return 'medical_team';
    }

    public static function tableName(): string
    {
        return 'Medical_Team';
    }

    public static function PrimaryKey(): string
    {
        return 'Team_ID';
    }

    public function attributes(): array
    {
        return ['Team_ID', 'Campaign_ID', 'Team_Leader_ID', 'Assigned_At', 'Assigned_Date'];
    }
}