<?php

namespace App\model\Authentication;

class OTPCodeAudit extends \App\model\database\dbModel
{
    protected string $UserID = '';
    protected string $Code = '';
    protected string $Target = '';
    protected int $Total_Attempts = 0;
    protected int $Verified_At = 0;
    protected string $ReGenerated_At = '';
    protected int $No_Of_ReGeneration = 0;
    protected string $Activity = '';
    protected int $Suspicious = 0;

    public function labels(): array
    {
        // TODO: Implement labels() method.
    }

    public function rules(): array
    {
        // TODO: Implement rules() method.
    }

    public static function getTableShort(): string
    {
        // TODO: Implement getTableShort() method.
    }

    public static function tableName(): string
    {
        // TODO: Implement tableName() method.
    }

    public static function PrimaryKey(): string
    {
        // TODO: Implement PrimaryKey() method.
    }

    public function attributes(): array
    {
        // TODO: Implement attributes() method.
    }
}