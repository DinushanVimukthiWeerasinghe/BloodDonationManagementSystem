<?php

namespace App\model\sponsor;

class CampaignsSponsor extends \App\model\database\dbModel
{
    protected string $Sponsor_ID='';
    protected string $Sponsorship_ID='';
    protected string $Description='';
    protected int $Sponsored_Amount=0;
    protected string $Sponsored_At='';


    public function labels(): array
    {
        return [
            'Sponsor_ID'=>'Sponsor ID',
            'Sponsorship_ID'=>'Sponsorship ID',
            'Description'=>'Description',
            'Sponsored_Amount'=>'Sponsored Amount',
            'Sponsored_At'=>'Sponsored At',
        ];
    }

    public function rules(): array
    {
        return [
            'Sponsor_ID'=>[self::RULE_REQUIRED],
            'Sponsorship_ID'=>[self::RULE_REQUIRED],
            'Description'=>[self::RULE_REQUIRED],
            'Sponsored_Amount'=>[self::RULE_REQUIRED],
            'Sponsored_At'=>[self::RULE_REQUIRED],
        ];
    }

    public static function getTableShort(): string
    {
        return 'CS';
    }

    public function GetAttributesValue($attributes)
    {
        return $this->{$attributes};
    }

    public static function tableName(): string
    {
        // TODO: Implement tableName() method.
        return 'campaigns_sponsors';
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
            'Sponsor_ID',
            'Sponsorship_ID',
            'Description',
            'Sponsored_Amount',
            'Sponsored_At',
        ];
    }

    /**
     * @return int
     */
    public function getSponsoredAmount(): int
    {
        return $this->Sponsored_Amount;
    }

    /**
     * @param int $Sponsored_Amount
     */
    public function setSponsoredAmount(int $Sponsored_Amount): void
    {
        $this->Sponsored_Amount = $Sponsored_Amount;
    }

    /**
     * @return string
     */
    public function getSponsoredAt(): string
    {
        return $this->Sponsored_At;
    }

    /**
     * @param string $Sponsored_At
     */
    public function setSponsoredAt(string $Sponsored_At): void
    {
        $this->Sponsored_At = $Sponsored_At;
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

    /**
     * @return string
     */
    public function getSponsorshipID(): string
    {
        return $this->Sponsorship_ID;
    }

    /**
     * @param string $Sponsorship_ID
     */
    public function setSponsorshipID(string $Sponsorship_ID): void
    {
        $this->Sponsorship_ID = $Sponsorship_ID;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->Description;
    }

    /**
     * @param string $Description
     */
    public function setDescription(string $Description): void
    {
        $this->Description = $Description;
    }


}