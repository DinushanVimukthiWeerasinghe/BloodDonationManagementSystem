<?php

namespace App\model\Requests;

use App\model\Campaigns\Campaign;
use App\model\sponsor\SponsorshipPackages;
use App\model\users\Organization;

class SponsorshipRequest extends \App\model\database\dbModel
{

    const STATUS_PENDING = 1;
    const STATUS_APPROVED = 2;
    const STATUS_REJECTED = 3;
    const STATUS_COMPLETED = 4;
    protected string $Sponsorship_ID='';
    protected string $Campaign_ID='';
    protected int $Sponsorship_Amount=0;
    protected string $Sponsorship_Date='';
    protected int $Sponsorship_Status=1;
    protected string $Description='';
    protected string $Report='';

    /**
     * @return string
     */
    public function getReport(): string
    {
        return $this->Report;
    }

    /**
     * @param string $Report
     */
    public function setReport(string $Report): void
    {
        $this->Report = $Report;
    }



    /**
     * @return string
     */
    public function getSponsorshipID(): string
    {
        return $this->Sponsorship_ID;
    }

    /**
     * @param string $Sponsorship_ID
     */
    public function setSponsorshipID(string $Sponsorship_ID): void
    {
        $this->Sponsorship_ID = $Sponsorship_ID;
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
    public function getSponsorshipAmount(): string
    {
        return $this->Sponsorship_Amount;
    }

    /**
     * @param string $Sponsorship_Amount
     */
    public function setSponsorshipAmount(string $Sponsorship_Amount): void
    {
        $this->Sponsorship_Amount = $Sponsorship_Amount;
    }

    /**
     * @return string
     */
    public function getSponsorshipDate(): string
    {
        return $this->Sponsorship_Date;
    }

    /**
     * @param string $Sponsorship_Date
     */
    public function setSponsorshipDate(string $Sponsorship_Date): void
    {
        $this->Sponsorship_Date = $Sponsorship_Date;
    }

    /**
     * @return string
     */
    public function getSponsorshipStatus(): string
    {
        return $this->Sponsorship_Status;
    }

    public function getReadableSponsorshipStatus(): string
    {
        return match ($this->Sponsorship_Status) {
            self::STATUS_PENDING => 'Pending',
            self::STATUS_APPROVED => 'Approved',
            self::STATUS_REJECTED => 'Rejected',
            default => 'Unknown'
        };
    }

    /**
     * @param string $Sponsorship_Status
     */
    public function setSponsorshipStatus(string $Sponsorship_Status): void
    {
        $this->Sponsorship_Status = $Sponsorship_Status;
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

    public function getCampaignName()
    {
        return Campaign::findOne(['Campaign_ID'=>$this->Campaign_ID])->getCampaignName();
    }

    public function getCampaignDate()
    {
        return Campaign::findOne(['Campaign_ID'=>$this->Campaign_ID])->getCampaignDate();
    }

    public static function getSuggestedPackage($Amount): bool|array
    {
        $Packages= SponsorshipPackages::RetrieveAll();
        return array_filter($Packages, function ($package) use ($Amount) {
            /** @var SponsorshipPackages $package */
            if ($package->getPackagePrice() == $Amount)
                return true;
            else if ($package->getPackagePrice() > $Amount)
                return false;
            else if ($package->getPackagePrice() < $Amount)
                if ($package->getPackagePrice() + 10000 > $Amount)
                    return true;
                else
                    return false;
            else
                return false;
        });

    }

    public function getOrganizationName()
    {
        $Organization_ID = Campaign::findOne(['Campaign_ID'=>$this->Campaign_ID])->getOrganizationID();
        return Organization::findOne(['Organization_ID'=>$Organization_ID])->getOrganizationName();
    }
    public function getOrganizationID()
    {
        return Campaign::findOne(['Campaign_ID'=>$this->Campaign_ID])->getOrganizationID();
    }

    public function getOrganizationEmail()
    {
        return Organization::findOne(['Organization_ID'=>$this->getOrganizationID()])->getOrganizationEmail();
    }

    public function labels(): array
    {
        return [
            'Sponsorship_ID'=>'Sponsorship ID',
            'Campaign_ID'=>'Campaign ID',
            'Sponsorship_Amount'=>'Sponsorship Amount',
            'Sponsorship_Date'=>'Sponsorship Date',
            'Sponsorship_Status'=>'Sponsorship Status',
            'Description'=>'Description'
        ];
    }

    public function rules(): array
    {
        return [
            'Sponsorship_ID'=>[self::RULE_REQUIRED,self::RULE_UNIQUE],
            'Campaign_ID'=>[self::RULE_REQUIRED],
            'Sponsorship_Amount'=>[self::RULE_REQUIRED],
            'Sponsorship_Date'=>[self::RULE_REQUIRED],
            'Sponsorship_Status'=>[self::RULE_REQUIRED],
            'Description'=>[self::RULE_REQUIRED]
        ];
    }

    public static function getTableShort(): string
    {
        return 'Sponsorship_Request';
    }

    public static function tableName(): string
    {
        return 'Sponsorship_Requests';
    }

    public static function PrimaryKey(): string
    {
        return 'Sponsorship_ID';
    }

    public function attributes(): array
    {
        return [
            'Sponsorship_ID',
            'Campaign_ID',
            'Sponsorship_Amount',
            'Sponsorship_Date',
            'Sponsorship_Status',
            'Description',
            'Report'
        ];
    }
}