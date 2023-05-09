<?php

namespace App\model\Authentication;

class OrganizationBankAccount extends \App\model\database\dbModel
{
    protected string $Organization_ID='';
    protected string $Bank_Name='';
    protected string $Account_Number='';
    protected string $Account_Name='';
    protected string $Branch_Name='';

    /**
     * @return string
     */
    public function getOrganizationID(): string
    {
        return $this->Organization_ID;
    }

    /**
     * @param string $Organization_ID
     */
    public function setOrganizationID(string $Organization_ID): void
    {
        $this->Organization_ID = $Organization_ID;
    }

    /**
     * @return string
     */
    public function getBankName(): string
    {
        return $this->Bank_Name;
    }

    /**
     * @param string $Bank_Name
     */
    public function setBankName(string $Bank_Name): void
    {
        $this->Bank_Name = $Bank_Name;
    }

    /**
     * @return string
     */
    public function getAccountNumber(): string
    {
        return $this->Account_Number = openssl_decrypt($this->Account_Number,ENCRYPTION_METHOD,ENCRYPTION_KEY,ENCRYPTION_IV);
    }

    /**
     * @param string $Account_Number
     */
    public function setAccountNumber(string $Account_Number): void
    {
        $this->Account_Number = openssl_encrypt($Account_Number,ENCRYPTION_METHOD,ENCRYPTION_KEY,0,ENCRYPTION_IV);
    }

    /**
     * @return string
     */
    public function getAccountName(): string
    {
        return $this->Account_Name;
    }

    /**
     * @param string $Account_Name
     */
    public function setAccountName(string $Account_Name): void
    {
        $this->Account_Name = $Account_Name;
    }

    /**
     * @return string
     */
    public function getBranchName(): string
    {
        return $this->Branch_Name;
    }

    /**
     * @param string $Branch_Name
     */
    public function setBranchName(string $Branch_Name): void
    {
        $this->Branch_Name = $Branch_Name;
    }




    public function labels(): array
    {
        return [
            'Organization_ID'=>'Organization ID',
            'Bank_Name'=>'Bank Name',
            'Account_Number'=>'Account Number',
            'Account_Name'=>'Account Name',
            'Branch_Name'=>'Branch Name',
        ];
    }

    public function rules(): array
    {
        return [
            'Organization_ID'=>[self::RULE_REQUIRED,self::RULE_UNIQUE],
            'Bank_Name'=>[self::RULE_REQUIRED],
            'Account_Number'=>[self::RULE_REQUIRED,self::RULE_UNIQUE],
            'Account_Name'=>[self::RULE_REQUIRED],
            'Branch_Name'=>[self::RULE_REQUIRED],
        ];
    }

    public static function getTableShort(): string
    {
        return 'Organization_Bank_Account';
    }

    public static function tableName(): string
    {
        return 'Organization_Bank_Accounts';
    }

    public static function PrimaryKey(): string
    {
        return 'Organization_ID';
    }

    public function attributes(): array
    {
        return [
            'Organization_ID',
            'Bank_Name',
            'Account_Number',
            'Account_Name',
            'Branch_Name',
        ];
    }
}