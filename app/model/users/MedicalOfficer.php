<?php

namespace App\model\users;

use App\model\BloodBankBranch\BloodBank;

class MedicalOfficer extends Person
{

    protected string $BloodBank_ID = '';
    protected string $Joined_At = '';
    protected string $Position = '';
    protected ?string $Registration_Number = '';
    protected string $Registration_Date = '';

    protected string $Officer_ID = '';
    protected string $Branch_ID = '';

    public function getID():string
    {
        return $this->Officer_ID;
    }

    public function setID(string $ID):void
    {
        $this->Officer_ID=$ID;
    }

    public function getBranchLocation()
    {
//        return BloodBank::findOne(['BloodBank_ID'=>$this->Branch_ID]);
        return BloodBank::findOne(['BloodBank_ID' => $this->Branch_ID])->getLocation() . ' Branch';
    }

    public function getRole(): string
    {
        return Person::MEDICAL_OFFICER;
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
        $this->Joined_At = $Joined_Date;
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
     * @return string
     */
    public function getJoinedAt($DateOnly = false): string
    {
        if ($DateOnly) {
            return date('Y-m-d', strtotime($this->Joined_At));
        }
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
    public function getRegistrationNumber(): string
    {
        return $this->Registration_Number;
    }

    /**
     * @param string $Registration_Number
     */
    public function setRegistrationNumber(string $Registration_Number): void
    {
        $this->Registration_Number = $Registration_Number;
    }

    /**
     * @return string
     */
    public function getRegistrationDate(): string
    {
        return $this->Registration_Date;
    }

    /**
     * @param string $Registration_Date
     */
    public function setRegistrationDate(string $Registration_Date): void
    {
        $this->Registration_Date = $Registration_Date;
    }

    /**
     * @return string
     */
    public function getOfficerID(): string
    {
        return $this->Officer_ID;
    }

    /**
     * @param string $Officer_ID
     */
    public function setOfficerID(string $Officer_ID): void
    {
        $this->Officer_ID = $Officer_ID;
    }


    public function rules(): array
    {
        return [
            'Officer_ID' => [self::RULE_REQUIRED, self::RULE_UNIQUE],
            'First_Name' => [self::RULE_REQUIRED],
            'Last_Name' => [self::RULE_REQUIRED],
            'NIC' => [self::RULE_REQUIRED, self::RULE_UNIQUE, self::RULE_MIN => 10, self::RULE_MAX => 12],
            'Joined_At' => [self::RULE_REQUIRED, self::RULE_OLDER_DATE],
            'Status' => [self::RULE_REQUIRED],
            'Position' => [self::RULE_REQUIRED],
            'Email' => [self::RULE_REQUIRED, self::RULE_UNIQUE, self::RULE_EMAIL],
            'Address1' => [self::RULE_REQUIRED],
            'Address2' => [self::RULE_REQUIRED],
            'City' => [self::RULE_REQUIRED],
            'Profile_Image' => [self::RULE_REQUIRED],
            'Contact_No' => [self::RULE_REQUIRED, self::RULE_MOBILE_NO],
            'Gender' => [self::RULE_REQUIRED],
            'Nationality' => [self::RULE_REQUIRED],
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
        return 'MedicalOfficers';
    }

    public static function PrimaryKey(): string
    {
        return 'Officer_ID';
    }

    public function attributes(): array
    {
        return [
            'Officer_ID',
            'First_Name',
            'Last_Name',
            'NIC',
            'Joined_At',
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
            'User_ID' => 'Officer ID',
            'First_Name' => 'First Name',
            'Last_Name' => 'Last Name',
            'NIC' => 'NIC',
            'Joined_At' => 'Joined At',
            'Status' => 'Status',
            'Position' => 'Position',
            'Email' => 'Email',
            'Address1' => 'Address1',
            'Address2' => 'Address2',
            'City' => 'City',
            'ImageURL' => 'Image URL',
            'Contact_No' => 'Contact No',
            'Branch_ID' => 'Branch ID',
            'Gender' => 'Gender',
            'Registration_Number' => 'Registration Number',
        ];
    }




}