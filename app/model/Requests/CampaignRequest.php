<?php

namespace App\model\Requests;

class CampaignRequest extends \App\model\database\dbModel
{
    protected string $Campaign_ID='';
    protected string $Organization_ID='';
    protected string $BloodBank_ID='';
    public function labels(): array
    {
        return [
            'Campaign_ID' => 'Campaign ID',
            'Organization_ID' => 'Organization ID',
            'BloodBank_ID' => 'Blood Bank ID',
        ];
    }

    public function rules(): array
    {
        return [
            'Campaign_ID' => [self::RULE_REQUIRED],
            'Organization_ID' => [self::RULE_REQUIRED],
            'BloodBank_ID' => [self::RULE_REQUIRED],
        ];
    }

    public static function getTableShort(): string
    {
        return 'CR';
    }

    public static function tableName(): string
    {
        return 'Campaign_Request';
    }

    public static function PrimaryKey(): string
    {
        return 'Campaign_ID';
    }

    public function attributes(): array
    {
        return ['Campaign_ID', 'Organization_ID', 'BloodBank_ID'];
    }
}