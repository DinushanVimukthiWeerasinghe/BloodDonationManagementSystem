<?php

namespace App\model;

class AttendanceAcceptanceRequest extends database\dbModel
{
    protected string $Request_ID='';
    protected string $Donor_ID='';
    protected string $Campaign_ID='';
    protected string $Accepted_At='';
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