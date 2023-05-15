<?php

namespace App\model\Donations;

use App\model\database\dbModel;

class HospitalBloodDonations extends dbModel
{
    protected string $Donation_ID='';
    protected string $Donor_ID='';
    protected ?string $Request_ID=null;
    protected string $Donation_At='';
    protected float $Volume=0.0;

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
    public function getRequestID(): string
    {
        return $this->Request_ID;
    }

    /**
     * @param string $Request_ID
     */
    public function setRequestID(string $Request_ID): void
    {
        $this->Request_ID = $Request_ID;
    }

    /**
     * @return string
     */
    public function getDonationAt(): string
    {
        return $this->Donation_At;
    }

    /**
     * @param string $Donation_At
     */
    public function setDonationAt(string $Donation_At): void
    {
        $this->Donation_At = $Donation_At;
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


    public function labels(): array
    {
        // TODO: Implement labels() method.
        return [
            'Donation_ID'=>'Donation ID',
            'Donor_ID'=>'Donor ID',
            'Request_ID'=>'Request ID',
            'Donation_At'=>'Donation At',
            'Volume'=>'Volume'
        ];
    }

    public function rules(): array
    {
        // TODO: Implement rules() method.
        return [
            'Donation_ID'=>[self::RULE_REQUIRED],
            'Donor_ID'=>[self::RULE_REQUIRED],
            'Donation_At'=>[self::RULE_REQUIRED],
            'Volume'=>[self::RULE_REQUIRED]
        ];
    }

    public static function getTableShort(): string
    {
        // TODO: Implement getTableShort() method.
        return 'HBD';
    }

    public static function tableName(): string
    {
        // TODO: Implement tableName() method.
        return 'Hospital_Blood_Donations';
    }

    public static function PrimaryKey(): string
    {
        // TODO: Implement PrimaryKey() method.
        return 'Donation_ID';
    }

    public function attributes(): array
    {
        // TODO: Implement attributes() method.
        return [
            'Donation_ID',
            'Donor_ID',
            'Request_ID',
            'Donation_At',
            'Volume'
        ];
    }
}