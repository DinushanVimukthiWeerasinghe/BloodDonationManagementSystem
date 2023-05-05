<?php

namespace App\model\users;

use App\model\BloodBankBranch\BloodBank;
use App\model\database\dbModel;

class Manager extends Person
{

    protected string $Manager_ID='';
    protected string $Joined_At='';
    protected string $BloodBank_ID='';
    protected string $Branch_ID='';
    protected string $Joined_Date='';

    /**
     * @return string
     */
    public function getManagerID(): string
    {
        return $this->Manager_ID;
    }

    /**
     * @param string $Manager_ID
     */
    public function setManagerID(string $Manager_ID): void
    {
        $this->Manager_ID = $Manager_ID;
    }

    /**
     * @return string
     */
    public function getJoinedAt(): string
    {
        return $this->Joined_At;
    }

    /**
     * @param string $Joined_At
     */
    public function setJoinedAt(string $Joined_At): void
    {
        $this->Joined_At = $Joined_At;
    }

    /**
     * @return string
     */
    public function getJoinedDate(): string
    {
        return $this->Joined_Date;
    }

    /**
     * @param string $Joined_Date
     */
    public function setJoinedDate(string $Joined_Date): void
    {
        $this->Joined_Date = $Joined_Date;
    }






    public function getID():string
    {
        return $this->Manager_ID;
    }

    public function getRole(): string
    {
        return 'Manager';
    }

    /**
     * @return string
     */
    public function getBranchID(): string
    {
        return $this->Branch_ID;
    }

    /**
     * @return string
     */
    public function getBloodBankID(): string
    {
        return $this->BloodBank_ID;
    }

    /**
     * @param string $BloodBank_ID
     */
    public function setBloodBankID(string $BloodBank_ID): void
    {
        $this->BloodBank_ID = $BloodBank_ID;
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
            'Manager_ID'=>[self::RULE_REQUIRED],
            'First_Name'=>[self::RULE_REQUIRED],
            'Last_Name'=>[self::RULE_REQUIRED],
//            'NIC'=>[self::RULE_REQUIRED,self::RULE_UNIQUE],
//            'Joined_Date'=>[self::RULE_REQUIRED],
//            'Status'=>[self::RULE_REQUIRED],
//            'Position'=>[self::RULE_REQUIRED],
            'Email'=>[self::RULE_REQUIRED,self::RULE_UNIQUE],
            'Address1'=>[self::RULE_REQUIRED],
            'Address2'=>[self::RULE_REQUIRED],
            'City'=>[self::RULE_REQUIRED],
//            'Profile_Image'=>[self::RULE_REQUIRED],
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
            'Manager_ID',
            'First_Name',
            'Last_Name',
//            'NIC',
//            'Joined_Date',
//            'Status',
//            'Position',
            'Email',
            'Address1',
            'Address2',
            'City',
//            'ImageURL',
            'Contact_No',
            'BloodBank_ID',
            'Profile_Image',
//            'Position'
        ];
    }

    public function labels(): array
    {
        return [
            'Manager_ID'=>'Officer ID',
            'First_Name'=>'First Name',
            'Last_Name'=>'Last Name',
//            'NIC'=>'NIC',
//            'Joined_Date'=>'Joined Date',
            'Status'=>'Status',
//            'Position'=>'Position',
            'Email'=>'Email',
            'Address1'=>'Address1',
            'Address2'=>'Address2',
            'City'=>'City',
//            'ImageURL'=>'Image URL',
            'Contact_No'=>'Contact No',
        ];
    }

    public function setID(string $ID): void
    {
        $this->Manager_ID = $ID;
    }

    public function getBloodBank()
    {
        $bloodBankID=$this->getBloodBankID();
        return BloodBank::findOne(['BloodBank_ID'=>$bloodBankID]);
    }
}