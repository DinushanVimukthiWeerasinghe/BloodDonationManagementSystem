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
    protected string $UID='';

    /**
     * @param string $Uid
     */
    public function setUid(string $Uid): void
    {
        $this->ID = $Uid;
    }
    protected string $Email='';
    protected string $Password='';
    protected string $Role='';

    /**
     * @param string $Role
     */
    public function setRole(string $Role): void
    {
        $this->Role = $Role;
    }
    protected string $First_Name='';
    protected string $Last_Name='';
    protected string $NIC='';
    protected string $ContactNo='';
    protected string $Address1='';
    protected string $Address2='';
    protected string $City='';
    protected string $Status='';
    protected string $Profile_Image='';

    public function getFullName(): string
    {
        return $this->First_Name.' '.$this->Last_Name;
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

    public static function getUserInfo()
    {
        $users=User::RetrieveAll();
        foreach ($users as $key=>$user)
        {
            if ($user->getRole()=='Manager'){
                $data=Manager::findOne(['ID'=>$user->getUid()]);
                if ($data){
                    $users[$key]=$data;
                }
            }else if ($user->getRole()=='MedicalOfficer'){
                $data=MedicalOfficer::findOne(['ID'=>$user->getUid()]);
                if ($data){
                    $users[$key]=$data;
                }
            }else if ($user->getRole()=='Donor'){
                $data=Donor::findOne(['ID'=>$user->getUid()]);
                if ($data){
                    $users[$key]=$data;
                }
            }else if ($user->getRole()=='Organization'){
                $data=Organization::findOne(['ID'=>$user->getUid()]);
                if ($data){
                    $users[$key]=$data;
                }
            }else if ($user->getRole()=='Sponsor'){
                $data=Sponsor::findOne(['ID'=>$user->getUid()]);
                if ($data){
                    $users[$key]=$data;
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
        return 'users';
    }

    public static function PrimaryKey(): string
    {
        return 'Uid';
    }

    public function attributes(): array
    {
        return [
            'Uid',
            'Email',
            'Password',
            'UserName',
            'Role'
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
    public function save()
    {
        return parent::save();
    }
    public function register(){
        $this -> save();
    }
}