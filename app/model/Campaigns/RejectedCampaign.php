<?php

namespace App\model\Campaigns;

class RejectedCampaign extends \App\model\database\dbModel
{

    protected string $Campaign_ID='';
    protected string $Rejected_By='';
    protected string $Rejected_At='';
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
    public function getRejectedBy(): string
    {
        return $this->Rejected_By;
    }

    /**
     * @param string $Rejected_By
     */
    public function setRejectedBy(string $Rejected_By): void
    {
        $this->Rejected_By = $Rejected_By;
    }

    /**
     * @return string
     */
    public function getRejectedAt(): string
    {
        return $this->Rejected_At;
    }

    /**
     * @param string $Rejected_At
     */
    public function setRejectedAt(string $Rejected_At): void
    {
        $this->Rejected_At = $Rejected_At;
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
            'Rejected_By'=>'Rejected By',
            'Rejected_At'=>'Rejected At',
            'Remarks'=>'Remarks'
        ];
    }

    public function rules(): array
    {
        return [
            'Campaign_ID'=>[self::RULE_REQUIRED],
            'Rejected_By'=>[self::RULE_REQUIRED],
            'Rejected_At'=>[self::RULE_REQUIRED],
        ];
    }

    public static function getTableShort(): string
    {
        return 'Rejected_Campaigns';
    }

    public static function tableName(): string
    {
        return 'rejected_campaigns';
    }

    public static function PrimaryKey(): string
    {
        return 'Campaign_ID';
    }

    public function attributes(): array
    {
        return [
            'Campaign_ID',
            'Rejected_By',
            'Rejected_At',
            'Remarks'
        ];
    }
}