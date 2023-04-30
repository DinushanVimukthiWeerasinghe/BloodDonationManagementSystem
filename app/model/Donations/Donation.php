<?php

namespace App\model\Donations;

use App\model\database\dbModel;

class Donation extends dbModel
{
    const STATUS_BLOOD_DONATION_PENDING = 1;
    const STATUS_BLOOD_RETRIEVING = 2;
    const STATUS_BLOOD_RETRIEVED = 3;
    const STATUS_BLOOD_STORED = 4;
    const STATUS_BLOOD_DONATION_ABORTED = 5;
    protected string $Donor_ID='';
    protected string $Donation_ID='';
    protected string $Campaign_ID='';
    protected string $Officer_ID='';
    protected string $Start_At='';
    protected ?string $End_At=null;
    protected int $Status=0;

    /**
     * @return string
     */
    public function getOfficerID(): string
    {
        return $this->Officer_ID;
    }

    /**
     * @param string $Officer_ID
     */
    public function setOfficerID(string $Officer_ID): void
    {
        $this->Officer_ID = $Officer_ID;
    }



    /**
     * @return string
     */
    public function getDonorID(): string
    {
        return $this->Donor_ID;
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
     * @return float
     */
    public function getVolume(): float
    {
        return $this->Volume;
    }

    /**
     * @param float $Volume
     */
    public function setVolume(float $Volume): void
    {
        $this->Volume = $Volume;
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
    public function getStartAt(): string
    {
        return $this->Start_At;
    }

    /**
     * @param string $Start_At
     */
    public function setStartAt(string $Start_At): void
    {
        $this->Start_At = $Start_At;
    }

    /**
     * @return string
     */
    public function getEndAt(): string
    {
        return $this->End_At;
    }

    /**
     * @param string $End_At
     */
    public function setEndAt(string $End_At): void
    {
        $this->End_At = $End_At;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->Status;
    }

    /**
     * @param int $Status
     */
    public function setStatus(int $Status): void
    {
        $this->Status = $Status;
    }



    public function labels(): array
    {
        return [
            'Donor_ID' => 'Donor ID',
            'Donation_ID' => 'Donation ID',
            'Campaign_ID' => 'Campaign ID',
            'Start_At' => 'Start At',
            'End_At' => 'End At',
            'Status' => 'Status',
            'Officer_ID' => 'Officer ID',
        ];
    }

    public function rules(): array
    {
        return [
            'Donor_ID' => [self::RULE_REQUIRED],
            'Donation_ID' => [self::RULE_REQUIRED],
            'Campaign_ID' => [self::RULE_REQUIRED],
            'Start_At' => [self::RULE_REQUIRED],
            'Status' => [self::RULE_REQUIRED],
            'Officer_ID' => [self::RULE_REQUIRED],
        ];
    }

    public static function getTableShort(): string
    {
        return 'donation';
    }

    public static function tableName(): string
    {
        return 'Donations';
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
            'Campaign_ID',
            'Start_At',
            'End_At',
            'Status',
            'Officer_ID',
        ];
    }
}