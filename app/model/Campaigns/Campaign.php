<?php

namespace App\model\Campaigns;

use App\model\database\dbModel;
use App\model\MedicalTeam\MedicalTeam;
use App\model\Requests\SponsorshipRequest;
use App\model\users\MedicalOfficer;
use App\model\users\Organization;
use Core\Application;

class Campaign extends dbModel
{
    public const CAMPAIGN_STATUS_PENDING = 1;
    public const CAMPAIGN_STATUS_APPROVED = 2;
    public const CAMPAIGN_STATUS_REJECTED = 3;
    public const CAMPAIGN_STATUS_FINISHED = 4;
    public const CAMPAIGN_STATUS_REPORTED = 5;
    public const NOT_VERIFIED = 1;
    public const VERIFIED = 2;
    const CAMPAIGN_STATUS_ALL = 0;

    protected string $Campaign_ID='';
    protected string $Organization_ID='';
    protected ?string $Expected_Amount=null;
    protected string $Campaign_Name='';
    protected string $Campaign_Description='';
    protected string $Campaign_Date='';
    protected string $Venue='';
    protected string $Nearest_City='';
    protected int $Status=1;
    protected string $Nearest_BloodBank='';
    protected int $Verified=1;
    protected ?string $Verified_By=null;
    protected ?string $Verified_At=null;
    protected ?string $Remarks=null;
    protected string $Created_At='';
    protected ?string $Updated_At=null;
    protected ?string $Longitude=null;
    protected ?string $Latitude=null;

    public static function getActiveCampaigns(): bool|array
    {
        $Campaigns = Campaign::RetrieveAll(false,[],true,['Status'=>self::CAMPAIGN_STATUS_APPROVED]);
        if ($Campaigns){
            return $Campaigns;
        }
        return [];
    }


    /**
     * @return string
     */
    public function getCampaignID(): string
    {
        return $this->Campaign_ID;
    }

    public function IsApproved(): bool
    {
        return $this->Status == self::CAMPAIGN_STATUS_APPROVED;
    }

    /**
     * @return string
     */
    public function getOrganizationID(): string
    {
        return $this->Organization_ID;
    }

    public function getOrganizationName()
    {
        $Organization = Organization::findOne(['Organization_ID'=>$this->Organization_ID]);
        if ($Organization){
            return $Organization->getOrganizationName();
        }
    }

    /**
     * @param string $Organization_ID
     */
    public function setOrganizationID(string $Organization_ID): void
    {
        $this->Organization_ID = $Organization_ID;
    }

    /**
     * @return string|null
     */
    public function getLongitude(): ?string
    {
        return $this->Longitude;
    }

    /**
     * @param string|null $Longitude
     */
    public function setLongitude(?string $Longitude): void
    {
        $this->Longitude = $Longitude;
    }

    /**
     * @return string|null
     */
    public function getLatitude(): ?string
    {
        return $this->Latitude;
    }

    /**
     * @param string|null $Latitude
     */
    public function setLatitude(?string $Latitude): void
    {
        $this->Latitude = $Latitude;
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

    public function getSponsorshipRequest() : SponsorshipRequest|bool
    {
        return SponsorshipRequest::findOne(['Campaign_ID'=>$this->Campaign_ID]);
    }

    public function getOrganizationType(): string
    {
//        Randomly return the organization type "NGO" or "Social Club"
        return match (rand(0,1)){
            0 => 'NGO',
            1 => 'Social Club'
        };
    }

    /**
     * @param string $Campaign_Date
     */
    public function setCampaignDate(string $Campaign_Date): void
    {
        $this->Campaign_Date = $Campaign_Date;
    }

    public function IsVerified(): bool
    {
        return $this->Verified == self::VERIFIED;
    }

    public function IsRejected(): bool
    {
        return $this->Status == self::CAMPAIGN_STATUS_REJECTED;
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

    public function IsRequestedSponsorship(): bool
    {
        $SponsorshipRequest = SponsorshipRequest::findOne(['Campaign_ID'=>$this->Campaign_ID]);
        return $SponsorshipRequest != null;
    }


    public function getCampaignStatus():string
    {
        return match ($this->Status){
            self::CAMPAIGN_STATUS_PENDING =>'Pending',
            self::CAMPAIGN_STATUS_APPROVED => 'Approved',
            self::CAMPAIGN_STATUS_REJECTED => 'Rejected',
            self::CAMPAIGN_STATUS_FINISHED => 'Finished',
            self::CAMPAIGN_STATUS_REPORTED => 'Reported',
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
    public function getAssignedTeam(): MedicalTeam | string
    {
        /** @var MedicalTeam $MedicalTeam */
        $MedicalTeam=MedicalTeam::findOne(['Campaign_ID'=>$this->Campaign_ID]);
        if ($MedicalTeam)
            return $MedicalTeam;
        else
            return 'Not Assigned';
    }

    /**
     * @param string $Assigned_Team
     */

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
    public function getPackageID(): string
    {
        return $this->Package_ID;
    }

    /**
     * @param string $Package_ID
     */
    public function setPackageID(string $Package_ID): void
    {
        $this->Package_ID = $Package_ID;
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
            'Package_ID' => 'Package ID',
            'Venue' => 'Venue',
            'Nearest_City' => 'Nearest City',
            'Status' => 'Status',
            'Nearest_BloodBank' => 'Nearest Blood Bank',
            'Verified' => 'Verified',
            'Created_At' => 'Created At',
            'Updated_At' => 'Updated At',
        ];
    }

    public function rules(): array
    {
        return [
            'Campaign_ID' => [self::RULE_REQUIRED,self::RULE_UNIQUE],
            'Campaign_Name' => [self::RULE_REQUIRED],
            'Campaign_Description' => [self::RULE_REQUIRED],
            'Campaign_Date' => [self::RULE_REQUIRED],
            'Venue' => [self::RULE_REQUIRED],
            'Nearest_City' => [self::RULE_REQUIRED],
            'Status' => [self::RULE_REQUIRED],
            'Nearest_BloodBank' => [self::RULE_REQUIRED],
            'Latitude' => [self::RULE_REQUIRED],
            'Longitude' => [self::RULE_REQUIRED],
        ];
    }

    public static function getTableShort(): string
    {
        return 'Campaign';
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
            'Created_At',
            'Updated_At',
            'Expected_Amount',
            'Latitude',
            'Longitude'
        ];
    }

    /**
     * @return string
     */
    public function getExpectedAmount(): string
    {
        return $this->Expected_Amount ?? '0';
    }

    /**
     * @param string $Expected_Amount
     */
    public function setExpectedAmount(string $Expected_Amount): void
    {
        $this->Expected_Amount = $Expected_Amount;
    }

    public function getNoOfDonors()
    {
        return '100';
    }

    public function getOrganization() : Organization
    {
        return Organization::findOne(['Organization_ID'=>$this->Organization_ID]);
    }

    public function IsReported(): bool
    {
        return $this->getStatus() === self::CAMPAIGN_STATUS_REPORTED;
    }

    public function getReportedBy() : MedicalOfficer | string
    {
        if ($this->IsReported()) {
            /** @var ReportedCampaign $ReportedCampaign */
            $ReportedCampaign = ReportedCampaign::findOne(['Campaign_ID' => $this->Campaign_ID]);
            if ($ReportedCampaign)
                return MedicalOfficer::findOne(['Officer_ID' => $ReportedCampaign->getReportedBy()]);
            else
                return 'Not Reported';
        }
        else{
            return 'Not Reported';
        }

    }

    public function getReportedDate(): string
    {
        if ($this->IsReported()) {
            /** @var ReportedCampaign $ReportedCampaign */
            $ReportedCampaign = ReportedCampaign::findOne(['Campaign_ID' => $this->Campaign_ID]);
            if ($ReportedCampaign)
                return date('d-F-Y',strtotime($ReportedCampaign->getReportedAt()));
            else
                return 'Not Reported';
        }
        else{
            return 'Not Reported';
        }
    }

    public function getReportedReason()
    {
        if ($this->IsReported()) {
            /** @var ReportedCampaign $ReportedCampaign */
            $ReportedCampaign = ReportedCampaign::findOne(['Campaign_ID' => $this->Campaign_ID]);
            if ($ReportedCampaign)
                return $ReportedCampaign->getReportReason(true);
            else
                return 'Not Reported';
        }
        else{
            return 'Not Reported';
        }
    }

    public function IsReportedByMe(): bool
    {
        if ($this->IsReported()) {
            /** @var ReportedCampaign $ReportedCampaign */
            $ReportedBy = $this->getReportedBy();
            $UserID = Application::$app->getUser()->getID();
            if ($ReportedBy instanceof MedicalOfficer)
                return $ReportedBy->getID() === $UserID;
            else
                return false;
        }
        else{
            return false;
        }
    }
}