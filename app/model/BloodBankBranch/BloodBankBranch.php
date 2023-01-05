<?php

namespace App\model\BloodBankBranch;

class BloodBankBranch extends \App\model\database\dbModel
{

    protected string $Branch_ID='';
    protected string $Location='';
    protected string $Telephone_No='';

    /**
     * @return string
     */
    public function getBranchID(): string
    {
        return $this->Branch_ID;
    }

    /**
     * @param string $Branch_ID
     */
    public function setBranchID(string $Branch_ID): void
    {
        $this->Branch_ID = $Branch_ID;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->Location;
    }

    /**
     * @param string $Location
     */
    public function setLocation(string $Location): void
    {
        $this->Location = $Location;
    }

    /**
     * @return string
     */
    public function getTelephoneNo(): string
    {
        return $this->Telephone_No;
    }

    /**
     * @param string $Telephone_No
     */
    public function setTelephoneNo(string $Telephone_No): void
    {
        $this->Telephone_No = $Telephone_No;
    }

    public function labels(): array
    {
        return [
            'Branch_ID'=>'Branch ID',
            'Location'=>'Location',
            'Telephone_No'=>'Telephone Number'
        ];
    }

    public function rules(): array
    {
        return [
            'Branch_ID'=>[self::RULE_REQUIRED],
            'Location'=>[self::RULE_REQUIRED],
            'Telephone_No'=>[self::RULE_REQUIRED]
        ];
    }

    public static function getTableShort(): string
    {
        return 'bbb';
    }

    public static function tableName(): string
    {
        return 'Blood_Bank_Branch';
    }

    public static function PrimaryKey(): string
    {
        return 'Branch_ID';
    }

    public function attributes(): array
    {
        return [
            'Branch_ID',
            'Location',
            'Telephone_No'
        ];
    }
}