<?php

namespace App\model\OrganizationMembers;

class Organization_Members extends \App\model\database\dbModel
{
    protected string $Organization_ID='';
    protected string $NIC='';
    protected string $Position='';
    protected string $Contact_No='';
    protected string $Email='';
    protected string $Name='';


    public static function CreateMember($Organization_ID,$NIC,$Position,$Contact_No,$Email,$Name)
    {
       $member = new self();
         $member->setOrganizationID($Organization_ID);
         $member->setNIC($NIC);
         $member->setPosition($Position);
         $member->setContactNo($Contact_No);
         $member->setEmail($Email);
         $member->setName($Name);
         if ($member->validate()) {
            return $member;
         }
         return false;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->Name;
    }

    /**
     * @param string $Name
     */
    public function setName(string $Name): void
    {
        $this->Name = $Name;
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
     * @return string
     */
    public function getContactNo(): string
    {
        return $this->Contact_No;
    }

    /**
     * @param string $Contact_No
     */
    public function setContactNo(string $Contact_No): void
    {
        $this->Contact_No = $Contact_No;
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

    public function labels(): array
    {
        return [
            'Organization_ID' => 'Organization ID',
            'NIC' => 'NIC',
            'Position' => 'Position',
            'Contact_No' => 'Contact No',
        ];

    }

    public function rules(): array
    {
        return [
            'Organization_ID' => [self::RULE_REQUIRED],
            'NIC' => [self::RULE_REQUIRED,self::RULE_UNIQUE],
            'Position' => [self::RULE_REQUIRED],
            'Contact_No' => [self::RULE_REQUIRED],
            'Email' => [self::RULE_REQUIRED],
            'Name' => [self::RULE_REQUIRED],
        ];
    }

    public static function getTableShort(): string
    {
        return 'organization_members';
    }

    public static function tableName(): string
    {
        return 'Organization_Members';
    }

    public static function PrimaryKey(): string
    {
        return 'NIC';
    }

    public function attributes(): array
    {
        return ['Organization_ID','NIC','Position','Contact_No','Email','Name'];
    }
}