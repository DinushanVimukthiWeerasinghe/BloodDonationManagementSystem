<?php

namespace App\model\users;

use App\model\Authentication\OrganizationBankAccount;

class Organization extends Person
{
    protected string $Organization_ID='';
    protected string $Organization_Name='';
    protected string $Organization_Email='';

    public function getID(): string
    {
        return $this->Organization_ID;
    }

    public static function getDefaultProfilePicture(): string
    {
        return '/public/images/default/profile/organization.png';
    }

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
    public function getOrganizationEmail(): string
    {
        return $this->Organization_Email;
    }

    /**
     * @param string $Organization_Email
     */
    public function setOrganizationEmail(string $Organization_Email): void
    {
        $this->Organization_Email = $Organization_Email;
    }


    public function CreateOrganization($UID,$Email)
    {
        $this->setID($UID);
        $this->setEmail($Email);
        $this->setStatus(self::USER_NOT_VERIFIED);
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
    public function setEmail(string $email):void
    {
        $this->Organization_Email = $email;
    }

    public function getEmail():string
    {
        return $this->Organization_Email;
    }

    public function getBankAccountNo(): bool|string
    {
        /** @var OrganizationBankAccount $BankAccount */
        $BankAccount=OrganizationBankAccount::findOne(['Organization_ID'=>$this->Organization_ID]);
        return $BankAccount->getAccountNumber();
    }

    public function getBankAccountName(): bool|string
    {
        /** @var OrganizationBankAccount $BankAccount */
        $BankAccount=OrganizationBankAccount::findOne(['Organization_ID'=>$this->Organization_ID]);
        return $BankAccount->getAccountName();
    }

    public function getBankName(): bool|string
    {
        /** @var OrganizationBankAccount $BankAccount */
        $BankAccount=OrganizationBankAccount::findOne(['Organization_ID'=>$this->Organization_ID]);
        return $BankAccount->getBankName();
    }

    public function getBranchName(): bool|string
    {
        /** @var OrganizationBankAccount $BankAccount */
        $BankAccount=OrganizationBankAccount::findOne(['Organization_ID'=>$this->Organization_ID]);
        return $BankAccount->getBranchName();
    }

    public function getBankAccount(): OrganizationBankAccount | bool
    {
        /** @var OrganizationBankAccount $BankAccount */
        $BankAccount=OrganizationBankAccount::findOne(['Organization_ID'=>$this->Organization_ID]);
        if (!$BankAccount){
            return false;
        }
        return $BankAccount;
    }




    public function labels(): array
    {
        return [
            'Organization_ID'=>'Organization ID',
            'Organization_Name'=>'Organization Name',
            'Address1'=>'Address 1',
            'Address2'=>'Address 2',
            'Organization_Email'=>'Email',
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
            'Organization_Email'=>[self::RULE_REQUIRED],
            'City'=>[self::RULE_REQUIRED],
            'Contact_No'=>[self::RULE_REQUIRED],
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
            'Organization_Email',
            'City',
            'Contact_No',
            'Profile_Image',
            'Status'

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

    private function generateID()
    {
        $ID=uniqid("ORG_");
        return $ID;
    }
}