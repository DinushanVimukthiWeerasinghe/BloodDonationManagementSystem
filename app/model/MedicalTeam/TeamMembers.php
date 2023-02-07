<?php

namespace App\model\MedicalTeam;

use App\model\Campaigns\Campaign;
use App\model\database\dbModel;

class TeamMembers extends dbModel
{
    protected string $Team_ID='';
    protected string $Member_ID='';
    protected string $Position='';

    public const MEDICAL_DIRECTOR = 'Medical Director';
    public const PHLEBOTOMISTS = 'Phlebotomists';
    public const NURSE = 'Nurses';
    public const SUPPORT_STAFF = 'Support Staff';

    /**
     * @return string
     */
    public function getTeamID(): string
    {
        return $this->Team_ID;
    }

    public function getCampaignID(): string
    {
        $CampaignID = MedicalTeam::findOne(['Team_ID' => $this->Team_ID]);
        return $CampaignID->getCampaignID();
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
    public function getMemberID(): string
    {
        return $this->Member_ID;
    }

    /**
     * @param string $Member_ID
     */
    public function setMemberID(string $Member_ID): void
    {
        $this->Member_ID = $Member_ID;
    }

    /**
     * @return string
     */
    public function getPosition(): string
    {
        return $this->Position;
    }

    /**
     * @param string $Position
     */
    public function setPosition(string $Position): void
    {
        $this->Position = $Position;
    }


    public function labels(): array
    {
        return [
            'Team_ID' => 'Team ID',
            'Member_ID' => 'Member ID',
            'Position' => 'Position'
        ];
    }

    public function rules(): array
    {
        return [
            'Team_ID' => [self::RULE_REQUIRED],
            'Member_ID' => [self::RULE_REQUIRED],
            'Position' => [self::RULE_REQUIRED]
        ];
    }

    public static function getTableShort(): string
    {
        return 'team_members';
    }

    public static function tableName(): string
    {
        return 'Team_Members';
    }

    public static function PrimaryKey(): string
    {
        return 'Team_ID';
    }

    public function attributes(): array
    {
        return ['Team_ID', 'Member_ID', 'Position'];
    }
}