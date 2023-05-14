<?php

namespace App\model\Requests;

use App\model\BloodBankBranch\BloodBank;
use App\model\Campaigns\Campaign;
//use App\model\sponsor\SponsorshipPackages;
use App\model\sponsor\CampaignsSponsor;
use App\model\users\Manager;
use App\model\users\Organization;
use App\model\users\Sponsor;
use Exception;

class SponsorshipRequest extends \App\model\database\dbModel
{

    const STATUS_PENDING = 1;
    const STATUS_APPROVED = 2;
    const STATUS_REJECTED = 3;
    const STATUS_COMPLETED = 4;
    const STATUS_EXPIRED = 5;
    const TRANSFERRING_PENDING = 1;
    const TRANSFERRING_COMPLETED = 2;
    protected string $Sponsorship_ID='';
    protected string $Campaign_ID='';
    protected int $Sponsorship_Amount=0;
    protected string $Sponsorship_Date='';
    protected int $Sponsorship_Status=1;
    protected string $Description='';
    protected string $Report='';
    protected ?string $Transferred=null;
    protected ?string $Transferred_At=null;
    protected ?string $Managed_By=null;
    protected ?string $Managed_At=null;

    /**
     * @return string
     */
    public function getReport(): string
    {
        return $this->Report;
    }

    /**
     * @return string|null
     */
    public function getManagedBy(): ?string
    {
        return $this->Managed_By;
    }

    /**
     * @param string|null $Managed_By
     */
    public function setManagedBy(?string $Managed_By): void
    {
        $this->Managed_By = $Managed_By;
    }

    /**
     * @return string|null
     */
    public function getManagedAt(): ?string
    {
        return $this->Managed_At;
    }

    /**
     * @param string|null $Managed_At
     */
    public function setManagedAt(?string $Managed_At): void
    {
        $this->Managed_At = $Managed_At;
    }


    /**
     * @param string $Report
     */
    public function setReport(string $Report): void
    {
        $this->Report = $Report;
    }

    /**
     * @return string|null
     */
    public function getSponsorshipID(): ?string
    {
        return $this->Sponsorship_ID;
    }

    public function getSponsorName() : string
    {
        /** @var $sponsor Sponsor */
        return $this->getSponsorName();
    }

    public function getToBeSponsoredAmount(bool $Readable=false): float|int|string
    {
        $CampaignSponsors = CampaignsSponsor::RetrieveAll(false,[],true,['Sponsorship_ID'=>$this->Sponsorship_ID,'Status'=>self::TRANSFERRING_COMPLETED]);
        if (count($CampaignSponsors) == 0)
            return $Readable ? number_format(intval($this->Sponsorship_Amount),0,'.',",") : $this->Sponsorship_Amount;
        $SponsoredAmount = array_sum(array_map(function ($CampaignSponsor){
            /** @var $CampaignSponsor CampaignsSponsor */
            return $CampaignSponsor->getSponsoredAmount();
        },$CampaignSponsors));
        return $Readable ? number_format(($this->Sponsorship_Amount - $SponsoredAmount),0,'.',",") : $this->Sponsorship_Amount - $SponsoredAmount;
    }

//    public function setToBeSponsoredAmount(int $SponsorAmount): float| int{
//        $this->Sponsorship_Amount = $SponsorAmount;
//    }

    /**
     * @return string|null
     */
    public function getTransferred(): ?string
    {
        return $this->Transferred;
    }

    /**
     * @param string|null $Transferred
     */
    public function setTransferred(?string $Transferred): void
    {
        $this->Transferred = $Transferred;
    }

    /**
     * @return string|null
     */
    public function getTransferredAt(): ?string
    {
        return $this->Transferred_At;
    }

    /**
     * @param string|null $Transferred_At
     */
    public function setTransferredAt(?string $Transferred_At): void
    {
        $this->Transferred_At = $Transferred_At;
    }



    /**
     * @return string
     */
//    public function getSponsorshipID(): string
//    {
//        return $this->Sponsorship_ID;
//    }

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

    public function getSponsorStatus(): string
    {
        return match ($this->Transferred) {
            self::TRANSFERRING_PENDING => 'NOT TRANSFERRED',
            self::TRANSFERRING_COMPLETED => 'TRANSFERRED',
            default => 'UNKNOWN'
        };
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

    /**
     * @throws Exception
     */
    public function Sponsor(string $SponsorID, $Amount, $SessionID, $Description): void
    {
        $this->Transferred = self::TRANSFERRING_PENDING;
        if ($this->Sponsorship_Amount <= $this->getToBeSponsoredAmount()){
            $this->Sponsorship_Status = self::STATUS_COMPLETED;
        }else{
            $this->Sponsorship_Status = self::STATUS_APPROVED;
        }
        $CampaignSponsor = new CampaignsSponsor();
        $CampaignSponsor->setSponsorshipID($this->Sponsorship_ID);
        $CampaignSponsor->setSponsorID($SponsorID);
        $CampaignSponsor->setSponsoredAmount($Amount);
        $CampaignSponsor->setSponsoredAt(date('Y-m-d H:i:s'));
        $CampaignSponsor->setDescription($Description);
        $CampaignSponsor->setStatus(CampaignsSponsor::PAYMENT_STATUS_PENDING);
        $CampaignSponsor->setSessionID($SessionID);


        if ($CampaignSponsor->validate()){
            $CampaignSponsor->save();
        }
    }

    public function getOrganizationName()
    {
        $Organization_ID = Campaign::findOne(['Campaign_ID'=>$this->Campaign_ID])->getOrganizationID();
        return Organization::findOne(['Organization_ID'=>$Organization_ID])->getOrganizationName();
    }
    public function getOrganizationID()
    {
        return Campaign::findOne(['Campaign_ID'=>$this->Campaign_ID])?->getOrganizationID();
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
            'Report',
            'Transferred',
            'Transferred_At',
            'Managed_By',
            'Managed_At',
        ];
    }

    public function getManagerName(): string
    {
        /** @var Manager $Manager*/
        $Manager = Manager::findOne(['Manager_ID'=>$this->Managed_By]);
        if ($Manager)
            return $Manager->getNameWithInitial();
        else
            return 'Unknown';
    }

    public function getManagerBloodBankName()
    {
        /** @var Manager $Manager*/
        /** @var BloodBank $Bank*/
        $Manager = Manager::findOne(['Manager_ID'=>$this->Managed_By]);
        if ($Manager) {
            $Bank = BloodBank::findOne(['BloodBank_ID' => $Manager->getBloodBankID()]);
            if ($Bank)
                return $Bank->getBankName();
            else
                return 'Unknown';
        }else {
            return 'Unknown';
        }
    }

    public function getNeededAmount()
    {
        /** @var $Sponsorship CampaignsSponsor*/
        $ReceivedSponsorship= CampaignsSponsor::RetrieveAll(false,[],true,['Sponsorship_ID'=>$this->Sponsorship_ID, 'Status' => CampaignsSponsor::PAYMENT_STATUS_PAID]);
        if ($ReceivedSponsorship)
            return $this->Sponsorship_Amount - array_sum(array_map(fn($Sponsorship)=>$Sponsorship->getSponsoredAmount() ,$ReceivedSponsorship));
        else
            return $this->Sponsorship_Amount;

    }
}