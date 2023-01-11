<?php

namespace App\model\OrganizationMembers;

class Organization_Members extends \App\model\database\dbModel
{
    protected string $Organization_ID='';
    protected string $NIC='';
    protected string $Position='';
    protected string $Contact_No='';

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
        return ['Organization_ID','NIC','Position','Contact_No'];
    }
}