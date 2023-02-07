<?php

namespace App\model\users;

use App\model\BloodBankBranch\BloodBank;
use App\model\database\dbModel;

class Manager extends Person
{

    protected string $Manager_ID='';

    public function getID():string
    {
        return $this->Manager_ID;
    }
    public function getRole(): string
    {
        return 'Manager';
    }
    protected string $Branch_ID='';
    protected string $Joined_Date='';

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

    public function GetBranch():BloodBank
    {
        $branchID=$this->getBranchID();
        return BloodBank::findOne(['Branch_ID'=>$branchID]);
    }


    public function rules(): array
    {
        return [
            'ID'=>[self::RULE_REQUIRED],
            'First_Name'=>[self::RULE_REQUIRED],
            'Last_Name'=>[self::RULE_REQUIRED],
            'NIC'=>[self::RULE_REQUIRED,self::RULE_UNIQUE],
            'Joined_Date'=>[self::RULE_REQUIRED],
            'Status'=>[self::RULE_REQUIRED],
            'Position'=>[self::RULE_REQUIRED],
            'Email'=>[self::RULE_REQUIRED,self::RULE_UNIQUE],
            'Address1'=>[self::RULE_REQUIRED],
            'Address2'=>[self::RULE_REQUIRED],
            'City'=>[self::RULE_REQUIRED],
            'Profile_Image'=>[self::RULE_REQUIRED],
            'Contact_No'=>[self::RULE_REQUIRED],
        ];
    }

    public static function getTableShort(): string
    {
        return 'bbm';
    }

    public static function tableName(): string
    {
        return 'Managers';
    }

    public static function PrimaryKey(): string
    {
        return 'Manager_ID';
    }

    public function attributes(): array
    {
        return [
            'ID',
            'First_Name',
            'Last_Name',
            'NIC',
            'Joined_Date',
            'Status',
            'Position',
            'Email',
            'Address1',
            'Address2',
            'City',
            'ImageURL',
            'Contact_No',
            'Position'
        ];
    }

    public function labels(): array
    {
        return [
            'ID'=>'Officer ID',
            'First_Name'=>'First Name',
            'Last_Name'=>'Last Name',
            'NIC'=>'NIC',
            'Joined_Date'=>'Joined Date',
            'Status'=>'Status',
            'Position'=>'Position',
            'Email'=>'Email',
            'Address1'=>'Address1',
            'Address2'=>'Address2',
            'City'=>'City',
            'ImageURL'=>'Image URL',
            'Contact_No'=>'Contact No',
        ];
    }

    public function setID(string $ID): void
    {
        $this->Manager_ID = $ID;
    }
}