<?php

namespace App\model\users;

use App\model\database\dbModel;
use Core\Application;

class User extends dbModel
{
    public const ADMIN='Admin';
    public const DONOR='Donor';
    public const ORGANIZATION='Organization';
    public const SPONSOR='Sponsor';
    public const MEDICAL_OFFICER='MedicalOfficer';
    public const MANAGER='Manager';
    public const HOSPITAL='Hospital';

    public const ACTIVE = 0;
    public const TEMPORARY_DEACTIVATED = 1;
    public const PERMANENTLY_DEACTIVATED = 2;
    public const SEC_LEVEL_SUSPICIOUS = 1;
    public const SEC_LEVEL_NORMAL = 0;
    public const SEC_LEVEL_HIGH = 2;

    protected string $UID='';
    protected string $First_Name='';
    protected string $Last_Name='';
    protected string $NIC='';
    protected string $ContactNo='';
    protected string $Address1='';
    protected string $Address2='';
    protected string $City='';
    protected int $Status=0;
    protected string $Profile_Image='';
    protected string $Email='';
    protected string $Password='';
    protected int $Account_Status=0;
    protected string $Role='';


    /**
     * @param string $Uid
     */
    public function setUid(string $Uid): void
    {
        $this->UID = $Uid;
    }

    /**
     * @param string $Password
     */
    public function setPassword(string $Password): void
    {
        $this->Password = $Password;
    }

    public function IsValidRole($role): bool
    {
        return in_array($role, [self::ADMIN, self::DONOR, self::ORGANIZATION, self::SPONSOR, self::MEDICAL_OFFICER, self::MANAGER, self::HOSPITAL]);
    }




    public function getFullName()
    {
        return match ($this->Role) {
            self::DONOR => Donor::findOne(['Donor_ID' => $this->UID])->getFullName(),
            self::ORGANIZATION => Organization::findOne(['Organization_ID' => $this->UID])->getFullName(),
            self::SPONSOR => Sponsor::findOne(['Sponsor_ID' => $this->UID])->getFullName(),
            self::MEDICAL_OFFICER => MedicalOfficer::findOne(['Officer_ID' => $this->UID])->getFullName(),
            self::MANAGER => Manager::findOne(['Manager_ID' => $this->UID])->getFullName(),
            self::HOSPITAL => Hospital::findOne(['Hospital_ID' => $this->UID])->getFullName(),
            self::ADMIN => Admin::findOne(['Admin_ID' => $this->UID])->getFullName(),
            default => '',
        };

    }

    /**
     * @return int
     */
    public function getAccountStatus(): int
    {
        return $this->Account_Status;
    }

    /**
     * @param int $Account_Status
     */
    public function setAccountStatus(int $Account_Status): void
    {
        $this->Account_Status = $Account_Status;
    }



    public function getID(): string
    {
        return $this->UID;
    }

    /**
     * @param string $Role
     */
    public function setRole(string $Role): void
    {
        $this->Role = $Role;
    }




    /**
     * @return string
     */
    public function getProfileImage(): string
    {
        return $this->Profile_Image;
    }

    /**
     * @param string $Profile_Image
     */
    public function setProfileImage(string $Profile_Image): void
    {
        $this->Profile_Image = $Profile_Image;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->First_Name;
    }


    /**
     * @param string $First_Name
     */
    public function setFirstName(string $First_Name): void
    {
        $this->First_Name = $First_Name;
    }

    public function IsTemporaryDeactivated(): bool
    {
        return $this->Status == self::TEMPORARY_DEACTIVATED;
    }

    public function IsPermanentlyDeactivated(): bool
    {
        return $this->Status == self::PERMANENTLY_DEACTIVATED;
    }

    public function IsDeactivated(): bool
    {
        return $this->IsTemporaryDeactivated() || $this->IsPermanentlyDeactivated();
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->Last_Name;
    }

    /**
     * @param string $Last_Name
     */
    public function setLastName(string $Last_Name): void
    {
        $this->Last_Name = $Last_Name;
    }

    /**
     * @return string
     */
    public function getNIC(): string
    {
        return $this->NIC;
    }

    /**
     * @param string $NIC
     */
    public function setNIC(string $NIC): void
    {
        $this->NIC = $NIC;
    }

    /**
     * @return string
     */
    public function getContactNo(): string
    {
        return $this->ContactNo;
    }

    /**
     * @param string $ContactNo
     */
    public function setContactNo(string $ContactNo): void
    {
        $this->ContactNo = $ContactNo;
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

    public function getLastActive()
    {
        return 'Last Active';
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
    public function getStatus(): string
    {
        return $this->Status;
    }

    /**
     * @param string $Status
     */
    public function setStatus(string $Status): void
    {
        $this->Status = $Status;
    }



    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->Email;
    }

    /**
     * @param string $Email
     */
    public function setEmail(string $Email): void
    {
        $this->Email = $Email;
    }



    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->Role;
    }

    public function IsManager(): bool
    {
        return $this->Role === 'Manager';
    }

    public function IsAdmin(): bool
    {
        return $this->Role === 'Admin';
    }

    public function IsMedicalOfficer(): bool
    {
        return $this->Role === 'MedicalOfficer';
    }

    public function IsDonor(): bool
    {
        return $this->Role === 'Donor';
    }

    public function IsOrganization(): bool
    {
        return $this->Role === 'Organization';
    }

    public function IsSponsor(): bool
    {
        return $this->Role === 'Sponsor';
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->Password;
    }


    /**
     * @return string
     */
    public function getUid(): string
    {
        return $this->UID;
    }

    public function login(): bool
    {
        //    Hashing Algorithm PASSWORD_BCRYPT
        $user= User::findOne(['Email' => $this->Email]);

        if(!$user)
        {
            $this->addError('email','Invalid User Credential!');
            return false;
        }

        if(!password_verify($this->Password,$user->getPassword()))
        {
            $this->addError('password','Incorrect Password!');
            return false;
        }
        Application::$app->login($user);
        Application::$app->session->setFlash('success','Login Successful!');
        return true;
    }

    public static function getUserInfo(string $Role='Donor')
    {
        $Getters=User::RetrieveAll(false,[],true,['Role'=>$Role]);
        $users=[];
        foreach ($Getters as $key=>$user)
        {
            if ($user->getRole()=='Manager'){
                $data=Manager::findOne(['Manager_ID'=>$user->getUid()]);
                if ($data){
                    $users[$key]=$data;
                }
            }else if ($user->getRole()=='MedicalOfficer'){
                $data=MedicalOfficer::findOne(['Officer_ID'=>$user->getUid()]);
                if ($data){
                    $users[$key]=$data;
                }
            }else if ($user->getRole()=='Donor'){
                $data=Donor::findOne(['Donor_ID'=>$user->getUid()]);
                if ($data){
                    $users[$key]=$data;
                }
            }else if ($user->getRole()=='Organization'){
                $data=Organization::findOne(['Organization_ID'=>$user->getUid()]);
                if ($data){
                    $users[$key]=$data;
                }
            }else if ($user->getRole()=='Sponsor'){
                $data=Sponsor::findOne(['Sponsor_ID'=>$user->getUid()]);
                if ($data){
                    $users[$key]=$data;
                }
            }else if($user->getRole()=='Hospital') {
                $data = Hospital::findOne(['Hospital_ID' => $user->getUid()]);
                if ($data) {
                    $users[$key] = $data;
                }
            }

        }
        return $users;
    }


    public function rules(): array
    {
        return [
            'Email'=>[self::RULE_REQUIRED,self::RULE_EMAIL],
            'Password'=>[self::RULE_REQUIRED],
        ];
    }

    public static function getTableShort(): string
    {
        return 'usr';
    }

    public static function tableName(): string
    {
        return 'Users';
    }

    public static function PrimaryKey(): string
    {
        return 'UID';
    }

    public function attributes(): array
    {
        return [
            'UID',
            'Email',
            'Password',
            'Role',
            'Account_Status'
        ];
    }

    public function labels(): array
    {
        return [
            'Uid'=>'User ID',
            'Email'=>'Email',
            'Password'=>'Password',
            'UserName'=>'User Name',
            'Role'=>'Role'
        ];
    }

}