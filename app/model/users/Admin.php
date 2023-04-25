<?php

namespace App\model\users;

use App\model\database\dbModel;

class Admin extends dbModel
{

//    TODO Always Declare the ID of the table and getters and setters for it as getID() and setID()
    protected string $Admin_ID='';
    protected string $UserName='';
    protected string $Email='';
    protected string $Profile_Image='';

    /**
     * @return string
     */
    public function getID(): string
    {
        return $this->Admin_ID;
    }

    public function getRole(): string
    {
        return 'Admin';
    }

    /**
     * @param string $Admin_ID
     */
    public function setID(string $Admin_ID): void
    {
        $this->Admin_ID = $Admin_ID;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->UserName;
    }

    /**
     * @param string $UserName
     */
    public function setUserName(string $UserName): void
    {
        $this->UserName = $UserName;
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


    public function labels(): array
    {
        return [
            'Admin_ID'=>'Admin ID',
            'UserName'=>'User Name',
            'Email'=>'Email',
            'Profile_Image'=>'Profile Image'
        ];
    }

    public function rules(): array
    {
        return [
            'Admin_ID'=>[self::RULE_REQUIRED,self::RULE_UNIQUE],
            'UserName'=>[self::RULE_REQUIRED],
            'Email'=>[self::RULE_REQUIRED,self::RULE_EMAIL],
            'Profile_Image'=>[self::RULE_REQUIRED]
        ];
    }

    public static function getTableShort(): string
    {
        return 'admin';
    }

    public static function tableName(): string
    {
        return 'Admins';
    }

    public static function PrimaryKey(): string
    {
        return 'Admin_ID';
    }

    public function attributes(): array
    {
        return [
            'Admin_ID',
            'UserName',
            'Email',
            'Profile_Image'
        ];
    }
}