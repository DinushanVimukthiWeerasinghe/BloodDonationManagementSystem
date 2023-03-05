<?php

namespace App\model\users;

class Sponsor extends Person
{
    protected string $Sponsor_ID='';
    protected string $Sponsor_Name='';
    protected string $Package_ID='';

    /**
     * @return string
     */
    public function getPackageID(): string
    {
        return $this->Package_ID;
    }

    /**
     * @param string $Package_ID
     */
    public function setPackageID(string $Package_ID): void
    {
        $this->Package_ID = $Package_ID;
    }
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

    /**
     * @return string
     */
    public function getSponsorID(): string
    {
        return $this->Sponsor_ID;
    }

    /**
     * @param string $Sponsor_ID
     */
    public function setSponsorID(string $Sponsor_ID): void
    {
        $this->Sponsor_ID = $Sponsor_ID;
    }

    /**
     * @return string
     */
    public function getSponsorName(): string
    {
        return $this->Sponsor_Name;
    }

    /**
     * @param string $Sponsor_Name
     */
    public function setSponsorName(string $Sponsor_Name): void
    {
        $this->Sponsor_Name = $Sponsor_Name;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->Type;
    }

    /**
     * @param string $Type
     */
    public function setType(string $Type): void
    {
        $this->Type = $Type;
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
        return User::SPONSOR;
    }

    public function setID(string $ID): void
    {
        $this->Sponsor_ID=$ID;
    }
}