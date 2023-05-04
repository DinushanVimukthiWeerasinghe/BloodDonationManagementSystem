<?php

namespace App\model\Campaigns;

class CampaignStatistics extends \App\model\database\dbModel
{

    protected string $Campaign_ID;
    protected int $No_of_Registers;
    protected int $No_Of_Campaign_Registers;
    protected int $No_Of_Health_Checks;
    protected int $No_Of_Blood_Checks;
    protected int $No_Of_Successful_Donations;
    protected int $No_Of_Aborted_Donations;

    /**
     * @return string
     */
    public function getCampaignID(): string
    {
        return $this->Campaign_ID;
    }

    /**
     * @return int
     */
    public function getNoOfRegisters(): int
    {
        return $this->No_of_Registers;
    }

    /**
     * @return int
     */
    public function getNoOfCampaignRegisters(): int
    {
        return $this->No_Of_Campaign_Registers;
    }

    /**
     * @return int
     */
    public function getNoOfHealthChecks(): int
    {
        return $this->No_Of_Health_Checks;
    }

    /**
     * @return int
     */
    public function getNoOfBloodChecks(): int
    {
        return $this->No_Of_Blood_Checks;
    }

    /**
     * @return int
     */
    public function getNoOfSuccessfulDonations(): int
    {
        return $this->No_Of_Successful_Donations;
    }

    /**
     * @return int
     */
    public function getNoOfAbortedDonations(): int
    {
        return $this->No_Of_Aborted_Donations;
    }



    public function labels(): array
    {
        return [
            'Campaign_ID' => 'Campaign ID',
            'No_of_Registers' => 'No of Registers',
            'No_Of_Campaign_Registers' => 'No Of Campaign Registers',
            'No_Of_Health_Checks' => 'No Of Health Checks',
            'No_Of_Blood_Checks' => 'No Of Blood Checks',
            'No_Of_Successful_Donations' => 'No Of Successful Donations',
            'No_Of_Aborted_Donations' => 'No Of Aborted Donations',
        ];
    }

    public function rules(): array
    {
        return [
            'Campaign_ID' => [self::RULE_REQUIRED],
            'No_of_Registers' => [self::RULE_REQUIRED],
            'No_Of_Campaign_Registers' => [self::RULE_REQUIRED],
            'No_Of_Health_Checks' => [self::RULE_REQUIRED],
            'No_Of_Blood_Checks' => [self::RULE_REQUIRED],
            'No_Of_Successful_Donations' => [self::RULE_REQUIRED],
            'No_Of_Aborted_Donations' => [self::RULE_REQUIRED],
        ];
    }

    public static function getTableShort(): string
    {
        return 'cs';
    }

    public static function tableName(): string
    {
        return 'campaign_statistics';
    }

    public static function PrimaryKey(): string
    {
        return 'Campaign_ID';
    }

    public function attributes(): array
    {
        return [
            'Campaign_ID',
            'No_of_Registers',
            'No_Of_Campaign_Registers',
            'No_Of_Health_Checks',
            'No_Of_Blood_Checks',
            'No_Of_Successful_Donations',
            'No_Of_Aborted_Donations',
        ];
    }
}