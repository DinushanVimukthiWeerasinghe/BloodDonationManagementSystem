<?php

namespace App\model\users;

use App\model\database\dbModel;

class Sponsor extends Person
{
    protected string $Sponsor_ID='';
    protected string $Sponsor_Name='';
    protected string $Type ='';

    public function getID(): string
    {
        return $this->Sponsor_ID;
    }


    public function labels(): array
    {
        return [
            'Sponsor_ID'=>'Sponsor ID',
            'Sponsor_Name'=>'Sponsor Name',
            'Address1'=>'Address 1',
            'Address2'=>'Address 2',
            'Email'=>'Email',
            'City'=>'City',
            'Contact_No'=>'Contact No',
            'Type'=>'Type',
            'Profile_Image'=>'Profile Image'
        ];
    }

    public function rules(): array
    {
        return [
            'Sponsor_ID'=>[self::RULE_UNIQUE,self::RULE_REQUIRED],
            'Sponsor_Name'=>[self::RULE_REQUIRED],
            'Address1'=>[self::RULE_REQUIRED],
            'Address2'=>[self::RULE_REQUIRED],
            'Email'=>[self::RULE_REQUIRED],
            'City'=>[self::RULE_REQUIRED],
            'Contact_No'=>[self::RULE_REQUIRED],
            'Type'=>[self::RULE_REQUIRED],
            'Profile_Image'=>[self::RULE_REQUIRED]
        ];
    }

    public static function getTableShort(): string
    {
        return 'spn';
    }

    public static function tableName(): string
    {
        return 'Sponsors';
    }

    public static function PrimaryKey(): string
    {
        return 'Sponsor_ID';
    }

    public function attributes(): array
    {
        return [
            'Sponsor_ID',
            'Sponsor_Name',
            'Address1',
            'Address2',
            'Email',
            'City',
            'Contact_No',
            'Type',
            'Profile_Image'
        ];
    }

    public function getRole(): string
    {
        return 'Sponsors';
    }

    public function setID(string $ID): void
    {
        $this->Sponsor_ID=$ID;
    }
}