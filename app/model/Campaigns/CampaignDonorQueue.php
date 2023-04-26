<?php

namespace App\model\Campaigns;

use App\model\users\Donor;

class CampaignDonorQueue extends \App\model\database\dbModel
{
    const STAGE_1 = 1;
    const STAGE_2 = 2;
    const STAGE_3 = 3;
    const STAGE_4 = 4;
    protected string $Donor_ID='';
    protected string $Campaign_ID='';
    protected int $Donor_Status=1;
    protected string $Last_Update='';

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
     * @return int
     */
    public function getDonor_Status(): int
    {
        return $this->Donor_Status;
    }

    /**
     * @param int $Donor_Status
     */
    public function setDonor_Status(int $Donor_Status): void
    {
        $this->Donor_Status = $Donor_Status;
    }

    /**
     * @return string
     */
    public function getLastUpdated(): string
    {
        return $this->Last_Update;
    }

    /**
     * @param string $Last_Update
     */
    public function setLastUpdated(string $Last_Update): void
    {
        $this->Last_Update = $Last_Update;
    }

    public function getDonor()
    {
        return Donor::findOne(['Donor_ID' => $this->Donor_ID]);
    }



    public function labels(): array
    {
        return [
            'Donor_ID' => 'Donor ID',
            'Campaign_ID' => 'Campaign ID',
            'Donor_Status' => 'Donor_Status',
            'Last_Update' => 'Last Updated',
        ];
    }

    public function rules(): array
    {
        return [
            'Donor_ID' => [self::RULE_REQUIRED],
            'Campaign_ID' => [self::RULE_REQUIRED],
            'Donor_Status' => [self::RULE_REQUIRED],
            'Last_Update' => [self::RULE_REQUIRED],
        ];
    }

    public static function getTableShort(): string
    {
        return 'CDQ';
    }

    public static function tableName(): string
    {
        return 'Campaign_Donation_Queue';
    }

    public static function PrimaryKey(): string
    {
        return 'Donor_ID';
    }

    public function attributes(): array
    {
        return [
            'Donor_ID',
            'Campaign_ID',
            'Donor_Status',
            'Last_Update',
        ];
    }
}