<?php

namespace App\model\Campaigns;

use App\model\database\dbModel;

class ApprovedCampaigns extends dbModel
{
    protected string $Campaign_ID='';
    protected string $Approved_By='';
    protected string $Approved_At='';
    protected ?string $Remarks=null;

    /**
     * @return string
     */
    public function getCampaignID(): string
    {
        return $this->Campaign_ID;
    }

    /**
     * @param string $Campaign_ID
     */
    public function setCampaignID(string $Campaign_ID): void
    {
        $this->Campaign_ID = $Campaign_ID;
    }

    /**
     * @return string
     */
    public function getApprovedBy(): string
    {
        return $this->Approved_By;
    }

    /**
     * @param string $Approved_By
     */
    public function setApprovedBy(string $Approved_By): void
    {
        $this->Approved_By = $Approved_By;
    }

    /**
     * @return string
     */
    public function getApprovedAt(): string
    {
        return $this->Approved_At;
    }

    /**
     * @param string $Approved_At
     */
    public function setApprovedAt(string $Approved_At): void
    {
        $this->Approved_At = $Approved_At;
    }

    /**
     * @return string|null
     */
    public function getRemarks(): ?string
    {
        return $this->Remarks;
    }

    /**
     * @param string|null $Remarks
     */
    public function setRemarks(?string $Remarks): void
    {
        $this->Remarks = $Remarks;
    }


    public function labels(): array
    {
        return [
            'Campaign_ID'=>'Campaign ID',
            'Approved_By'=>'Approved By',
            'Approved_At'=>'Approved At',
            'Remarks'=>'Remarks'
        ];
    }

    public function rules(): array
    {
        return [
            'Campaign_ID'=>[self::RULE_REQUIRED],
            'Approved_By'=>[self::RULE_REQUIRED],
            'Approved_At'=>[self::RULE_REQUIRED]
            ];
    }

    public static function getTableShort(): string
    {
        return 'Approved_Campaigns';
    }

    public static function tableName(): string
    {
        return 'Approved_Campaigns';
    }

    public static function PrimaryKey(): string
    {
        return 'Campaign_ID';
    }

    public function attributes(): array
    {
        return [
            'Campaign_ID',
            'Approved_By',
            'Approved_At',
            'Remarks'
        ];
    }

    public function getCampaign() : Campaign | null
    {
        return Campaign::findOne(['Campaign_ID'=>$this->Campaign_ID]);
    }
}