<?php

namespace App\model\BloodBankBranch;

use App\model\database\dbModel;

class BloodBank extends dbModel
{
    public const BRANCH=1;
    public const MAIN=2;

    /**
     * @return string
     */

    protected string $BloodBank_ID='';
    protected string $BankName='';
    protected string $Address1='';
    protected string $Address2='';
    protected string $City='';
    protected string $Telephone_No='';
//    protected string $Email='';
    protected int $No_Of_Doctors=0;
    protected int $No_Of_Nurses=0;
    protected int $No_Of_Beds=0;
    protected int $No_Of_Storages=0;
    protected int $Type=0;


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

    public function getLocation(): string
    {
        return $this->City;
    }

    /**
     * @return string
     */
    public function getBankName(): string
    {
        return $this->BankName;
    }

    /**
     * @param string $BankName
     */
    public function setBankName(string $BankName): void
    {
        $this->BankName = $BankName;
    }

    /**
     * @return string
     */
    public function getAddress1(): string
    {
        return $this->Address1;
    }

    /**
     * @param string $Address1
     */
    public function setAddress1(string $Address1): void
    {
        $this->Address1 = $Address1;
    }

    /**
     * @return string
     */
    public function getAddress2(): string
    {
        return $this->Address2;
    }

    /**
     * @param string $Address2
     */
    public function setAddress2(string $Address2): void
    {
        $this->Address2 = $Address2;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->City;
    }

    /**
     * @param string $City
     */
    public function setCity(string $City): void
    {
        $this->City = $City;
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

    /**
     * @return int
     */
    public function getNoOfDoctors(): int
    {
        return $this->No_Of_Doctors;
    }

    /**
     * @param int $No_Of_Doctors
     */
    public function setNoOfDoctors(int $No_Of_Doctors): void
    {
        $this->No_Of_Doctors = $No_Of_Doctors;
    }

    /**
     * @return int
     */
    public function getNoOfNurses(): int
    {
        return $this->No_Of_Nurses;
    }

    /**
     * @param int $No_Of_Nurses
     */
    public function setNoOfNurses(int $No_Of_Nurses): void
    {
        $this->No_Of_Nurses = $No_Of_Nurses;
    }

    /**
     * @return int
     */
    public function getNoOfBeds(): int
    {
        return $this->No_Of_Beds;
    }

    /**
     * @param int $No_Of_Beds
     */
    public function setNoOfBeds(int $No_Of_Beds): void
    {
        $this->No_Of_Beds = $No_Of_Beds;
    }

    /**
     * @return int
     */
    public function getNoOfStorages(): int
    {
        return $this->No_Of_Storages;
    }

    /**
     * @param int $No_Of_Storages
     */
    public function setNoOfStorages(int $No_Of_Storages): void
    {
        $this->No_Of_Storages = $No_Of_Storages;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->Type;
    }

    /**
     * @param int $Type
     */
    public function setType(int $Type): void
    {
        $this->Type = $Type;
    }

    public function labels(): array
    {
        return [
            'BloodBank_ID'=>'Blood Bank ID',
            'BankName'=>'Blood Bank Name',
            'Address1'=>'Address Line 1',
            'Address2'=>'Address Line 2',
            'City'=>'City',
            'Telephone_No'=>'Telephone Number',
            'No_Of_Doctors'=>'Number of Doctors',
            'No_Of_Nurses'=>'Number of Nurses',
            'No_Of_Beds'=>'Number of Beds',
            'No_Of_Storages'=>'Number of Storages',
            'Type'=>'Type'
        ];
    }

    public function rules(): array
    {
        return [
            'BloodBank_ID'=>[self::RULE_REQUIRED,self::RULE_UNIQUE],
            'BankName'=>[self::RULE_REQUIRED],
            'Address1'=>[self::RULE_REQUIRED],
            'Address2'=>[self::RULE_REQUIRED],
            'City'=>[self::RULE_REQUIRED],
            'Telephone_No'=>[self::RULE_REQUIRED],
            'No_Of_Doctors'=>[self::RULE_REQUIRED],
            'No_Of_Nurses'=>[self::RULE_REQUIRED],
            'No_Of_Beds'=>[self::RULE_REQUIRED],
            'No_Of_Storages'=>[self::RULE_REQUIRED],
            'Type'=>[self::RULE_REQUIRED]

        ];
    }

    public static function getTableShort(): string
    {
        return 'bb';
    }

    public static function tableName(): string
    {
        return 'BloodBanks';
    }

    public static function PrimaryKey(): string
    {
        return 'BloodBank_ID';
    }

    public function attributes(): array
    {
       return [
           'BloodBank_ID',
           'BankName',
           'Address1',
           'Address2',
           'City',
           'Telephone_No',
           'No_Of_Doctors',
           'No_Of_Nurses',
           'No_Of_Beds',
           'No_Of_Storages',
           'Type'
       ];
    }
}