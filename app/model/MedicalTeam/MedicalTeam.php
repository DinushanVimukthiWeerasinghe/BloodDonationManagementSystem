<?php

namespace App\model\MedicalTeam;

use App\model\Campaigns\Campaign;

class MedicalTeam extends \App\model\database\dbModel
{
    protected string $Team_ID='';
    protected string $Campaign_ID='';
    protected ?string $Team_Leader=null;
    protected string $Assigned_By='';
    protected int $No_Of_Member=0;


    /**
     * @return string
     */
    public function getTeamID(): string
    {
        return $this->Team_ID;
    }

    /**
     * @return int
     */
    public function getNoOfMembers(): int
    {
        return $this->No_Of_Member;
    }

    /**
     * @param int $No_Of_Members
     */
    public function setNoOfMembers(int $No_Of_Members): void
    {
        $this->No_Of_Member = $No_Of_Members;
    }



    /**
     * @param string $Team_ID
     */
    public function setTeamID(string $Team_ID): void
    {
        $this->Team_ID = $Team_ID;
    }

    public function generateTeamID()
    {
        $this->Team_ID=uniqid("MT_");
    }

    /**
     * @return string
     */
    public function getCampaignID(): string
    {
        return $this->Campaign_ID;
    }

    public function getCampaign(): ?Campaign
    {
        return Campaign::findOne(['Campaign_ID' => $this->Campaign_ID]);
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
        return $this->Team_Leader;
    }

    /**
     * @param string $Team_Leader
     */
    public function setTeamLeaderID(string $Team_Leader): void
    {
        $this->Team_Leader = $Team_Leader;
    }

    /**
     * @return string
     */
    public function getTeamLeader(): string
    {
        return $this->Team_Leader;
    }

    /**
     * @param string $Team_Leader
     */
    public function setTeamLeader(string $Team_Leader): void
    {
        $this->Team_Leader = $Team_Leader;
    }

    /**
     * @return string
     */
    public function getAssignedBy(): string
    {
        return $this->Assigned_By;
    }

    /**
     * @param string $Assigned_By
     */
    public function setAssignedBy(string $Assigned_By): void
    {
        $this->Assigned_By = $Assigned_By;
    }




    public function labels(): array
    {
        return [
            'Team_ID' => 'Team ID',
            'Campaign_ID' => 'Campaign ID',
            'Team_Leader' => 'Team Leader ID',
            'Assigned_By' => 'Assigned Date',
            'No_Of_Member' => 'No Of Members'
        ];
    }

    public function rules(): array
    {
        return [
            'Team_ID' => [self::RULE_REQUIRED],
            'Campaign_ID' => [self::RULE_REQUIRED],
            'Assigned_By' => [self::RULE_REQUIRED],
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
        return ['Team_ID', 'Campaign_ID', 'Team_Leader', 'Assigned_By', 'No_Of_Member'];
    }
}