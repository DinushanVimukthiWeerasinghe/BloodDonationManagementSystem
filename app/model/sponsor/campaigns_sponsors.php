<?php

namespace App\model\sponsor;

class campaigns_sponsors extends \App\model\database\dbModel
{
    protected string $Sponsor_ID='';
    protected string $Campaign_ID='';
    protected string $Campaign_Name='';
    protected string $Package_ID='';

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

    public function GetAttributesValue($attributes)
    {
        return $this->{$attributes};
    }

    public static function tableName(): string
    {
        // TODO: Implement tableName() method.
        return 'Campaigns_Sponsors';
    }

    public static function PrimaryKey(): string
    {
        // TODO: Implement PrimaryKey() method.
        return 'Campaign_ID';

    }

    public function attributes(): array
    {
        // TODO: Implement attributes() method.
        return [
            'Campaign_Name',
            'Campaign_ID',
            'Sponsor_ID',
            'Package_ID',
        ];
    }

    public function getName():string
    {
        return $this->Campaign_Name;
    }

    /**
     * @return string
     */
    public function getPackageID(): string
    {
        return $this->Package_ID;
    }

    /**
     * @param string $Package_ID
     */
    public function setPackageID(string $Package_ID): void
    {
        $this->Package_ID = $Package_ID;
    }

    public function getID():string
    {
        return $this->Campaign_ID;
    }

    /**
     * @return string
     */
    public function getSponsorID(): string
    {
        return $this->Sponsor_ID;
    }

    /**
     * @param string $Sponsor_ID
     */
    public function setSponsorID(string $Sponsor_ID): void
    {
        $this->Sponsor_ID = $Sponsor_ID;
    }


}