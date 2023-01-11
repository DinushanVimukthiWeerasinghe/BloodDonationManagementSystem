<?php

namespace App\model\users;
use App\model\BloodBankBranch\BloodBank;
use App\model\database\dbModel;

class organization extends Person
{
    protected string $Organisation_ID='';
    protected string $Organization_Name='';
    protected string $Created_At='';
    protected string $Password='';
    protected string $Updated_At = '';


    public function getID()
    {
        return $this->Organisation_ID;
    }

    public function setID(string $Id)
    {
        $this->Organisation_ID=$Id;
    }

    public function getRole(): string
    {
        return 'Organization';
    }

    /**
     * @return string
     */
//    public function getPosition(): string
//    {
//        return $this->Position;
//    }

    /**
     * @param string $Position
     */
//    public function setPosition(string $Position): void
//    {
//        $this->Position = $Position;
//    }

    /**
     * @param string $Branch_ID
     */
//    public function setBranchID(string $Branch_ID): void
//    {
//        $this->Branch_ID = $Branch_ID;
//    }

    /**
     * @param string $Joined_Date
     */
    public function setJoinedDate(string $Joined_Date): void
    {
        $this->Created_At = $Joined_Date;
    }



    public function rules(): array
    {
        return [
            'Officer_ID'=>[self::RULE_REQUIRED,self::RULE_UNIQUE],
            'First_Name'=>[self::RULE_REQUIRED],
            'Last_Name'=>[self::RULE_REQUIRED],
            'NIC'=>[self::RULE_REQUIRED,self::RULE_UNIQUE,self::RULE_MIN=>10,self::RULE_MAX=>12],
            'Created_At'=>[self::RULE_REQUIRED,self::RULE_OLDER_DATE],
            'Status'=>[self::RULE_REQUIRED],
            'Position'=>[self::RULE_REQUIRED],
            'Email'=>[self::RULE_REQUIRED,self::RULE_UNIQUE,self::RULE_EMAIL],
            'Address1'=>[self::RULE_REQUIRED],
            'Address2'=>[self::RULE_REQUIRED],
            'City'=>[self::RULE_REQUIRED],
            'Profile_Image'=>[self::RULE_REQUIRED],
            'Contact_No'=>[self::RULE_REQUIRED,self::RULE_MOBILE_NO],
        ];
    }

    public static function getTableShort(): string
    {
        return 'mo';
    }

    public static function tableName(): string
    {
        return 'organizations';
    }

    public static function PrimaryKey(): string
    {
        return 'Organization_ID';
    }

    public function attributes(): array
    {
        return [
            'Organization_ID',
            'Organization_Name',
            'Created_At',
            'Status',
            'Email',
            'Address1',
            'Address2',
            'City',
            'Profile_Image',
            'Contact_No',
        ];
    }

    public function GetAttributesValue($attributes)
    {
        return $this->{$attributes};
    }

    public function labels(): array
    {
        return [
            'ID'=>'Organization ID',
            'Organization_Name'=>'Organization Name',
            'Joined_Date'=>'Joined Date',
            'Status'=>'Status',
            'Email'=>'Email',
            'Address1'=>'Address1',
            'Address2'=>'Address2',
            'City'=>'City',
            'ImageURL'=>'Image URL',
            'Contact_No'=>'Contact No',

        ];
    }
    public function getPassword(){
        $this -> Password;
    }
}