<?php

namespace App\model\Campaigns;

use App\model\database\dbModel;

class campaigns extends dbModel
{
    protected string $Campaign_ID='';
    protected string $Organization_ID='';
    protected string $Campaign_Name='';
    protected string $Campaign_Date='';
    protected string $Nearest_BloodBank='';
    protected string $Venue='';
    protected int $status;
    public function labels(): array
    {
        // TODO: Implement labels() method.
    }
    public function getName(): string
    {
        return $this->Campaign_Name;
        // TODO: Implement labels() method.
    }

    public function getDate(): string{
        return $this->Campaign_Date;
    }
    public function getVenue(): string{
        return $this->Venue;
    }

    public function rules(): array
    {
        // TODO: Implement rules() method.
        return[
            'Campaign_ID'=>[self::RULE_REQUIRED,self::RULE_UNIQUE],
            'Venue'=>[self::RULE_REQUIRED],
            'Campaign_Date'=>[self::RULE_REQUIRED],

        ];

    }

    public static function getTableShort(): string
    {
        // TODO: Implement getTableShort() method.
    }

    public static function tableName(): string
    {
       return 'campaignhistory';
    }

    public static function PrimaryKey(): string
    {
        return 'Campaign_ID';
    }

    public  function getOrganizationID(): string
    {
        return 'Organization_ID';
    }
    public function setOrganizationID($organizationID)
    {
        $this->Organization_ID = $organizationID;
    }

    public function attributes(): array
    {
        // TODO: Implement attributes() method.
        return [
            'Campaign_ID',
            'Campaign_Name',
            'Campaign_Date',
            'Venue',
            'Organization_ID',
            'Nearest_BloodBank',
        ];
    }

    public function getStatus(): int
    {
        return $this->status;
    }
    public function setCampaignID($camaignID): string
    {
        return $this->Campaign_ID=$camaignID;
    }
    public function setStatus($status): int
    {
        return $this->status = $status;
    }

    public function getID():string
    {
        return $this->Campaign_ID;
    }
}