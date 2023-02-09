<?php

namespace App\model\users;

class Organization extends Person
{
    protected string $Organization_ID='';
    protected string $Organization_Name='';
    protected string $Organization_Email='';
    protected string $Type ='';

    public function getID(): string
    {
        return $this->Organization_ID;
    }

    /**
     * @return string
     */
    public function getOrganizationName(): string
    {
        return $this->Organization_Name;
    }

    /**
     * @param string $Organization_Name
     */
    public function setOrganizationName(string $Organization_Name): void
    {
        $this->Organization_Name = $Organization_Name;
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

    public function getEmail():string
    {
        return $this->Organization_Email;
    }



    public function labels(): array
    {
        return [
            'Organization_ID'=>'Organization ID',
            'Organization_Name'=>'Organization Name',
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
            'Organization_ID'=>[self::RULE_UNIQUE,self::RULE_REQUIRED],
            'Organization_Name'=>[self::RULE_REQUIRED],
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
        return 'org';
    }

    public static function tableName(): string
    {
        return 'Organizations';
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
        return 'Organization';
    }

    public function setID(string $ID): void
    {
        $this->Organization_ID=$ID;
    }
}