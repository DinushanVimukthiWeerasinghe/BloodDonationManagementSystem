<?php

namespace App\model\Donations;

use App\model\database\dbModel;

class HospitalBloodDonations extends dbModel
{
    protected string $Donation_ID='';
    protected string $Donor_ID='';
    protected string $Request_ID='';
    protected string $Donation_At='';
    protected float $volume=0.0;


    public function labels(): array
    {
        // TODO: Implement labels() method.
        return [
            'Donation_ID'=>'Donation ID',
            'Donor_ID'=>'Donor ID',
            'Request_ID'=>'Request ID',
            'Donation_At'=>'Donation At',
            'volume'=>'Volume'
        ];
    }

    public function rules(): array
    {
        // TODO: Implement rules() method.
        return [
            'Donation_ID'=>[self::RULE_REQUIRED],
            'Donor_ID'=>[self::RULE_REQUIRED],
            'Request_ID'=>[self::RULE_REQUIRED],
            'Donation_At'=>[self::RULE_REQUIRED],
            'volume'=>[self::RULE_REQUIRED]
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
            'volume'
        ];
    }
}