<?php

namespace App\model\Blood;

class BloodGroup extends \App\model\database\dbModel
{
    protected string $BloodGroup_ID='';
    protected string $BloodGroup_Name='';

    /**
     * @return string
     */
    public function getBloodGroupID(): string
    {
        return $this->BloodGroup_ID;
    }

    /**
     * @param string $BloodGroup_ID
     */
    public function setBloodGroupID(string $BloodGroup_ID): void
    {
        $this->BloodGroup_ID = $BloodGroup_ID;
    }

    /**
     * @return string
     */
    public function getBloodGroupName(): string
    {
        return $this->BloodGroup_Name;
    }

    /**
     * @param string $BloodGroup_Name
     */
    public function setBloodGroupName(string $BloodGroup_Name): void
    {
        $this->BloodGroup_Name = $BloodGroup_Name;
    }




    public function labels(): array
    {
        return [
            'BloodGroup_ID' => 'Blood Group ID',
            'BloodGroup_Name' => 'Blood Group Name',
        ];
    }

    public function rules(): array
    {
        return [
            'BloodGroup_ID' =>[self::RULE_REQUIRED,self::RULE_UNIQUE],
            'BloodGroup_Name' => [self::RULE_REQUIRED,self::RULE_UNIQUE],
            ];
    }

    public static function getTableShort(): string
    {
        return 'BloodGroup';
    }

    public static function tableName(): string
    {
        return 'BloodGroups';
    }

    public static function PrimaryKey(): string
    {
        return 'BloodGroup_ID';
    }

    public function attributes(): array
    {
       return [
           'BloodGroup_ID',
           'BloodGroup_Name',
       ];
    }
}