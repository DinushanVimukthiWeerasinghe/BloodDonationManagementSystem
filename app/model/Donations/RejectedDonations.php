<?php

namespace App\model\Donations;

class RejectedDonations extends \App\model\database\dbModel
{

    public const TYPE_ABORT_BLOOD_RETRIEVING = 1;
    public const TYPE_UNHEALTHY_DONOR = 2;
    public const TYPE_NOT_ENOUGH_BLOOD = 3;
    public const TYPE_NOT_HEALTHY_BLOOD = 4;
    public const TYPE_OTHER = 6;

    public const REASON_FITS_SEIZURE = 1;
    public const REASON_LOW_BLOOD_PRESSURE = 2;
    public const REASON_HIGH_BLOOD_PRESSURE = 3;
    public const OTHER = 4;
    const TYPE_ABORT_DONATION = 5;


    protected string $Donor_ID='';
    protected string $Donation_ID='';
    protected string $Rejected_At='';
    protected string $Campaign_ID = '';
    protected string $Rejected_By='';
    protected string $Reason='';
    protected int $Type = 1;
    protected ?string $OtherReason = null;

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
    public function getDonorID(): string
    {
        return $this->Donor_ID;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->Type;
    }

    /**
     * @param int $Type
     */
    public function setType(int $Type): void
    {
        $this->Type = $Type;
    }

    /**
     * @param string $Donor_ID
     */
    public function setDonorID(string $Donor_ID): void
    {
        $this->Donor_ID = $Donor_ID;
    }

    /**
     * @return string
     */
    public function getDonationID(): string
    {
        return $this->Donation_ID;
    }

    /**
     * @param string $Donation_ID
     */
    public function setDonationID(string $Donation_ID): void
    {
        $this->Donation_ID = $Donation_ID;
    }

    /**
     * @return string
     */
    public function getRejectedAt(): string
    {
        return $this->Rejected_At;
    }

    /**
     * @param string $Rejected_At
     */
    public function setRejectedAt(string $Rejected_At): void
    {
        $this->Rejected_At = $Rejected_At;
    }

    /**
     * @return string
     */
    public function getRejectedBy(): string
    {
        return $this->Rejected_By;
    }

    /**
     * @param string $Rejected_By
     */
    public function setRejectedBy(string $Rejected_By): void
    {
        $this->Rejected_By = $Rejected_By;
    }

    /**
     * @return string
     */
    public function getReason(): string
    {
        return $this->Reason;
    }

    /**
     * @param string $Reason
     */
    public function setReason(string $Reason): void
    {
        $this->Reason = $Reason;
    }

    /**
     * @return string|null
     */
    public function getOtherReason(): ?string
    {
        return $this->OtherReason;
    }

    /**
     * @param string|null $OtherReason
     */
    public function setOtherReason(?string $OtherReason): void
    {
        $this->OtherReason = $OtherReason;
    }




    public function labels(): array
    {
        return [
            'Donor_ID' => 'Donor ID',
            'Donation_ID' => 'Donation ID',
            'Campaign_ID' => 'Campaign ID',
            'Officer_ID' => 'Officer ID',
            'Start_At' => 'Start At',
            'End_At' => 'End At',
            'Status' => 'Status',
            'Type' => 'Type',
        ];
    }

    public function rules(): array
    {
        return [
            'Donor_ID' => [self::RULE_REQUIRED],
            'Donation_ID' => [self::RULE_REQUIRED],
            'Campaign_ID' => [self::RULE_REQUIRED],
            'Reason' => [self::RULE_REQUIRED],
            'Rejected_By' => [self::RULE_REQUIRED],
            'Rejected_At' => [self::RULE_REQUIRED],
            'Type' => [self::RULE_REQUIRED],
        ];
    }

    public static function getTableShort(): string
    {
        return 'rd';
    }

    public static function tableName(): string
    {
        return 'rejected_donations';
    }

    public static function PrimaryKey(): string
    {
        return 'Donation_ID';
    }

    public function attributes(): array
    {
        return [
            'Donor_ID',
            'Donation_ID',
            'Rejected_At',
            'Rejected_By',
            'Reason',
            'Campaign_ID',
            'Type',
            'OtherReason'
        ];
    }

}