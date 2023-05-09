<?php

namespace App\model\users;

use App\model\Authentication\OrganizationBankAccount;
use App\model\Organization\ReportOrganization;
use App\model\Utils\Security;

class Organization extends Person
{
    const ORGANIZATION_NOT_VERIFIED = 1;
    const ORGANIZATION_VERIFIED = 2;
    const ORGANIZATION_REJECTED = 3;
    protected string $Organization_ID='';
    protected string $Organization_Name='';
    protected string $Organization_Email='';
    protected ?string $Verified_By=null;
    protected ?string $Verified_At=null;

    public static function CreateEmptyOrganization($Email)
    {
        $Organization=new Organization();
        $Organization->setOrganizationName('No Name');
        $Organization->setOrganizationEmail($Email);
        $Organization->setAddress1('Address Line 1');
        $Organization->setAddress2('Address Line 2');
        $Organization->setCity('City');
        $Organization->setContactNo('Contact No');
        $Organization->setStatus(Organization::ORGANIZATION_NOT_VERIFIED);
        $Organization->setProfileImage(Organization::getDefaultProfilePicture());
        return $Organization;
    }

    public function getVerificationStatus(bool $Readable=false): int | string
    {
        if ($Readable){
            return match (intval($this->Status)) {
                self::ORGANIZATION_NOT_VERIFIED => 'Not Verified',
                self::ORGANIZATION_VERIFIED => 'Verified',
                self::ORGANIZATION_REJECTED => 'Rejected',
                default => 'Unknown',
            };
        }
        return intval($this->Status);
    }

    /**
     * @return string|null
     */
    public function getRemarks(): ?string
    {
        return $this->Remarks;
    }

    /**
     * @param string|null $Remarks
     */
    public function setRemarks(?string $Remarks): void
    {
        $this->Remarks = $Remarks;
    }


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
        return $this->Type ?? 'Social_Welfare';
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
        return Security::Decrypt($BankAccount->getAccountNumber());
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

    /**
     * @return string
     */
    public function getVerifiedBy(): string
    {
        return $this->Verified_By;
    }

    /**
     * @param string $Verified_By
     */
    public function setVerifiedBy(string $Verified_By): void
    {
        $this->Verified_By = $Verified_By;
    }



    /**
     * @param string $Verified_At
     */
    public function setVerifiedAt(string $Verified_At): void
    {
        $this->Verified_At = $Verified_At;
    }

    public function getVerifierName()
    {
        if ($this->Verified_By){
            $User=MedicalOfficer::findOne(['Officer_ID'=>$this->Verified_By]);
            if ($User){
                return $User->getFullName();
            }
            return 'Unknown';
        }
    }

    public function getVerifiedAt(): string
    {
        if ($this->Verified_At){
            return date('Y-F-d',strtotime($this->Verified_At));
        }
        return 'Unknown';
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
            'Profile_Image'=>'Profile Image',
            'Status'=>'Status',
            'Verified_By'=>'Verified By',
            'Verified_At'=>'Verified At',
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
            'Status',
            'Verified_By',
            'Verified_At',

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

    public static function generateID($param = ""): string
    {
        return uniqid("ORG_");
    }

    public function IsReported() : bool
    {
        if (intval($this->getStatus())===self::ORGANIZATION_REJECTED){
            return true;
        }else{
            return false;
        }
    }

    public function IsVerified(): bool
    {
        if (intval($this->getStatus())===self::ORGANIZATION_VERIFIED){
            return true;
        }else{
            return false;
        }
    }

    public function getReporterName()
    {
        /** @var ReportOrganization $Reporter */
        $Reporter = ReportOrganization::findOne(['Organization_ID'=>$this->getOrganizationID()]);
        return $Reporter->getReporter()->getFullName();

    }

    public function getReporterAt()
    {
        /** @var ReportOrganization $Reporter */
        $Reporter = ReportOrganization::findOne(['Organization_ID'=>$this->getOrganizationID()]);
        return date("Y F d ",strtotime($Reporter->getReportedAt()));
    }
}