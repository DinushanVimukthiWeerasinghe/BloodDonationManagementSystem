<?php

namespace App\model\Campaigns;

use App\model\database\dbModel;

class Campaign extends dbModel
{
    public const PENDING = 1;
    public const APPROVED = 2;
    protected string $Campaign_ID='';
    protected string $Organization_ID='';
    protected string $Campaign_Name='';
    protected string $Campaign_Description='';
    protected string $Campaign_Date='';
    protected string $Venue='';
    protected string $Nearest_City='';
    protected int $Status=1;
    protected string $Nearest_BloodBank='';
    protected int $Verified=0;
    protected ?string $Verified_By=null;
    protected ?string $Verified_At=null;
    protected ?string $Assigned_Team=null;
    protected ?string $Remarks=null;
    protected string $Created_At='';
    protected ?string $Updated_At=null;

    /**
     * @return string
     */
    public function getCampaignID(): string
    {
        return $this->Campaign_ID;
    }

    /**
     * @return string
     */
    public function getOrganizationID(): string
    {
        return $this->Organization_ID;
    }

    /**
     * @param string $Organization_ID
     */
    public function setOrganizationID(string $Organization_ID): void
    {
        $this->Organization_ID = $Organization_ID;
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
    public function getCampaignName(): string
    {
        return $this->Campaign_Name;
    }

    /**
     * @param string $Campaign_Name
     */
    public function setCampaignName(string $Campaign_Name): void
    {
        $this->Campaign_Name = $Campaign_Name;
    }

    /**
     * @return string
     */
    public function getCampaignDescription(): string
    {
        return $this->Campaign_Description;
    }

    /**
     * @param string $Campaign_Description
     */
    public function setCampaignDescription(string $Campaign_Description): void
    {
        $this->Campaign_Description = $Campaign_Description;
    }

    /**
     * @return string
     */
    public function getCampaignDate(): string
    {
        return $this->Campaign_Date;
    }

    /**
     * @param string $Campaign_Date
     */
    public function setCampaignDate(string $Campaign_Date): void
    {
        $this->Campaign_Date = $Campaign_Date;
    }

    /**
     * @return string
     */
    public function getVenue(): string
    {
        return $this->Venue;
    }

    /**
     * @param string $Venue
     */
    public function setVenue(string $Venue): void
    {
        $this->Venue = $Venue;
    }

    /**
     * @return string
     */
    public function getNearestCity(): string
    {
        return $this->Nearest_City;
    }

    /**
     * @param string $Nearest_City
     */
    public function setNearestCity(string $Nearest_City): void
    {
        $this->Nearest_City = $Nearest_City;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->Status;
    }

    public function getCampaignStatus():string
    {
        return match ($this->Status){
            self::PENDING =>' Pending Approval',
            self::APPROVED => 'Campaign Approved',
            default => 'Unknown'
        };
    }

    /**
     * @param int $Status
     */
    public function setStatus(int $Status): void
    {
        $this->Status = $Status;
    }

    /**
     * @return string
     */
    public function getNearestBloodBank(): string
    {
        return $this->Nearest_BloodBank;
    }

    /**
     * @param string $Nearest_BloodBank
     */
    public function setNearestBloodBank(string $Nearest_BloodBank): void
    {
        $this->Nearest_BloodBank = $Nearest_BloodBank;
    }

    /**
     * @return int
     */
    public function getVerified(): int
    {
        return $this->Verified;
    }

    /**
     * @param int $Verified
     */
    public function setVerified(int $Verified): void
    {
        $this->Verified = $Verified;
    }

    /**
     * @return string
     */
    public function getVerifiedBy(): string
    {
        return $this->Verified_By;
    }

    /**
     * @param string $Verified_By
     */
    public function setVerifiedBy(string $Verified_By): void
    {
        $this->Verified_By = $Verified_By;
    }

    /**
     * @return string
     */
    public function getVerifiedAt(): string
    {
        return $this->Verified_At;
    }

    /**
     * @param string $Verified_At
     */
    public function setVerifiedAt(string $Verified_At): void
    {
        $this->Verified_At = $Verified_At;
    }

    /**
     * @return string
     */
    public function getAssignedTeam(): string
    {
        return $this->Assigned_Team;
    }

    /**
     * @param string $Assigned_Team
     */
    public function setAssignedTeam(string $Assigned_Team): void
    {
        $this->Assigned_Team = $Assigned_Team;
    }

    /**
     * @return string
     */
    public function getRemarks(): string
    {
        return $this->Remarks;
    }

    /**
     * @param string $Remarks
     */
    public function setRemarks(string $Remarks): void
    {
        $this->Remarks = $Remarks;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->Created_At;
    }

    /**
     * @param string $Created_At
     */
    public function setCreatedAt(string $Created_At): void
    {
        $this->Created_At = $Created_At;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->Updated_At;
    }

    /**
     * @param string $Updated_At
     */
    public function setUpdatedAt(string $Updated_At): void
    {
        $this->Updated_At = $Updated_At;
    }


    public function labels(): array
    {
        return [
            'Campaign_ID' => 'Campaign ID',
            'Campaign_Name' => 'Campaign Name',
            'Campaign_Description' => 'Campaign Description',
            'Campaign_Date' => 'Campaign Date',
            'Venue' => 'Venue',
            'Nearest_City' => 'Nearest City',
            'Status' => 'Status',
            'Nearest_BloodBank' => 'Nearest Blood Bank',
            'Verified' => 'Verified',
            'Verified_By' => 'Verified By',
            'Verified_At' => 'Verified At',
            'Assigned_Team' => 'Assigned Team',
            'Remarks' => 'Remarks',
            'Created_At' => 'Created At',
            'Updated_At' => 'Updated At',
        ];
    }

    public function rules(): array
    {
        return [
            'Campaign_ID' => [self::RULE_REQUIRED],
            'Campaign_Name' => [self::RULE_REQUIRED],
            'Campaign_Description' => [self::RULE_REQUIRED],
            'Campaign_Date' => [self::RULE_REQUIRED],
            'Venue' => [self::RULE_REQUIRED],
            'Nearest_City' => [self::RULE_REQUIRED],
            'Status' => [self::RULE_REQUIRED],
            'Nearest_BloodBank' => [self::RULE_REQUIRED],
        ];
    }

    public static function getTableShort(): string
    {
        return 'campaigns';
    }

    public static function tableName(): string
    {
        return 'Campaign';
    }

    public static function PrimaryKey(): string
    {
        return 'Campaign_ID';
    }

    public function attributes(): array
    {
        return [
            'Campaign_ID',
            'Organization_ID',
            'Campaign_Name',
            'Campaign_Description',
            'Campaign_Date',
            'Venue',
            'Nearest_City',
            'Status',
            'Nearest_BloodBank',
            'Verified',
            'Verified_By',
            'Verified_At',
            'Assigned_Team',
            'Remarks',
            'Created_At',
            'Updated_At',
        ];
    }
}