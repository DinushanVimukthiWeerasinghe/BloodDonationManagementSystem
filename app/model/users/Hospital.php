<?php

namespace App\model\users;

use App\model\database\dbModel;

class Hospital extends Person
{
    protected string $Hospital_ID='';
    protected string $Hospital_Name='';


    /**
     * @return string
     */
    public function getHospitalName(): string
    {
        return $this->Hospital_Name;
    }

    /**
     * @param string $Hospital_Name
     */
    public function setHospitalName(string $Hospital_Name): void
    {
        $this->Hospital_Name = $Hospital_Name;
    }
    protected string $Type ='';

    public function getID(): string
    {
        return $this->Hospital_ID;
    }
    public function getFullName(): string
    {
        return $this->Hospital_Name.' Hospital';
    }

    public function getRole(): string
    {
        return 'Hospital';
    }


    public function labels(): array
    {
        return [
            'Hospital_ID'=>'Hospital ID',
            'Hospital_Name'=>'Hospital Name',
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
            'Hospital_ID'=>[self::RULE_UNIQUE,self::RULE_REQUIRED],
            'Hospital_Name'=>[self::RULE_REQUIRED],
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
        return 'hsp';
    }

    public static function tableName(): string
    {
        return 'Hospitals';
    }

    public static function PrimaryKey(): string
    {
        return 'Hospital_ID';
    }

    public function attributes(): array
    {
        return [
            'Hospital_ID',
            'Hospital_Name',
            'Address1',
            'Address2',
            'Email',
            'City',
            'Contact_No',
            'Type',
            'Profile_Image'
        ];
    }

    public function setID(string $ID): void
    {
        $this->Hospital_ID=$ID;
    }
}