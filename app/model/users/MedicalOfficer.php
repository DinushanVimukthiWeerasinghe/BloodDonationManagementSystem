<?php

namespace App\model\users;

use App\model\BloodBankBranch\BloodBankBranch;
use App\model\database\dbModel;
use PhpParser\Node\Expr\Array_;

class MedicalOfficer extends Person
{
    protected string $Branch_ID='Bra_17';
    protected string $Joined_Date='';
    protected string $Position='';
    protected string $Registration_Number='';
    protected string $Registration_Date='';

    public function getBranchLocation()
    {
        return BloodBankBranch::findOne(['Branch_ID'=>$this->Branch_ID])->getLocation().' Branch';
    }

    public function getRole(): string
    {
        return 'MedicalOfficer';
    }



    public function getFullName(): string
    {
        return $this->First_Name.' '.$this->Last_Name;
    }

    /**
     * @return string
     */
    public function getPosition(): string
    {
        return $this->Position;
    }

    /**
     * @param string $Position
     */
    public function setPosition(string $Position): void
    {
        $this->Position = $Position;
    }

    /**
     * @param string $Branch_ID
     */
    public function setBranchID(string $Branch_ID): void
    {
        $this->Branch_ID = $Branch_ID;
    }

    /**
     * @param string $Joined_Date
     */
    public function setJoinedDate(string $Joined_Date): void
    {
        $this->Joined_Date = $Joined_Date;
    }



    public function rules(): array
    {
        return [
            'ID'=>[self::RULE_REQUIRED,self::RULE_UNIQUE],
            'First_Name'=>[self::RULE_REQUIRED],
            'Last_Name'=>[self::RULE_REQUIRED],
            'NIC'=>[self::RULE_REQUIRED,self::RULE_UNIQUE,self::RULE_MIN=>10,self::RULE_MAX=>12],
            'Joined_Date'=>[self::RULE_REQUIRED,self::RULE_OLDER_DATE],
            'Status'=>[self::RULE_REQUIRED],
            'Position'=>[self::RULE_REQUIRED],
            'Email'=>[self::RULE_REQUIRED,self::RULE_UNIQUE,self::RULE_EMAIL],
            'Address1'=>[self::RULE_REQUIRED],
            'Address2'=>[self::RULE_REQUIRED],
            'City'=>[self::RULE_REQUIRED],
            'Profile_Image'=>[self::RULE_REQUIRED],
            'Contact_No'=>[self::RULE_REQUIRED,self::RULE_MOBILE_NO],
            'Gender'=>[self::RULE_REQUIRED],
            'Nationality'=>[self::RULE_REQUIRED],
            'Registration_Number'=>[self::RULE_REQUIRED,self::RULE_UNIQUE],
            'Registration_Date'=>[self::RULE_REQUIRED,self::RULE_OLDER_DATE],
        ];
    }

    public static function getTableShort(): string
    {
        return 'mo';
    }

    public static function tableName(): string
    {
        return 'Medical_Officer';
    }

    public static function PrimaryKey(): string
    {
        return 'ID';
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
            'Profile_Image',
            'Contact_No',
            'Branch_ID',
            'Gender',
            'Nationality',
            'Registration_Number',
            'Registration_Date',
        ];
    }

    public function GetAttributesValue($attributes)
    {
        return $this->{$attributes};
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
            'Branch_ID'=>'Branch ID',
            'Gender'=>'Gender',

        ];
    }




}