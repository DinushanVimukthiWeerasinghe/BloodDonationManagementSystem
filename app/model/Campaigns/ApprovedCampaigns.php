<?php

namespace App\model\Campaigns;

use App\model\database\dbModel;

class ApprovedCampaigns extends dbModel
{
    protected string $Campaign_ID='';
    protected string $Approved_By='';
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