<?php

namespace App\model\Authentication;

class BlockedUsers extends \App\model\database\dbModel
{

    protected string $UID = '';
    protected string $Blocked_At = '';
    protected int $Type = 0;

    public function labels(): array
    {
        return [
            'UID' => 'User ID',
            'Blocked_At' => 'Blocked At',
            'Type' => 'Type'
        ];
    }

    public function rules(): array
    {
        return [
            'UID' => [self::RULE_REQUIRED],
            'Blocked_At' => [self::RULE_REQUIRED],
            'Type' => [self::RULE_REQUIRED]
        ];
    }

    public static function getTableShort(): string
    {
        return 'BU';
    }

    public static function tableName(): string
    {
        return 'Blocked_Users';
    }

    public static function PrimaryKey(): string
    {
        return 'UID';
    }

    public function attributes(): array
    {
        return [
            'UID',
            'Blocked_At',
            'Type'
        ];
    }
}