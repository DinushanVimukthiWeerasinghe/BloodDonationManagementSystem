<?php

namespace App\model\Campaigns;

use Core\Application;

class ReportedCampaign extends \App\model\database\dbModel
{
    public const REPORTED_CAMPAIGN_NOT_THERE = 1;
    public const REPORTED_CAMPAIGN_NOT_ACTIVE = 2;
    public const REPORTED_CAMPAIGN_NO_DONORS = 3;
    public const REPORTED_CAMPAIGN_FAKE_CAMPAIGN = 4;
    public const REPORTED_CAMPAIGN_OTHER = 5;

    protected string $Campaign_ID='';
    protected string $Reported_By='';
    protected string $Reported_At='';
    protected int $Report_Reason=0;
    protected ?string $Report_Description=null;

    public static function UndoReportCampaign(string $CampaignID): bool
    {
        $ReportedCampaign=ReportedCampaign::findOne(['Campaign_ID'=>$CampaignID]);
        if ($ReportedCampaign){
            return ReportedCampaign::DeleteOne(['Campaign_ID'=>$CampaignID]);
        }else{
            return false;
        }
    }

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
    public function getReportedBy(): string
    {
        return $this->Reported_By;
    }

    /**
     * @param string $Reported_By
     */
    public function setReportedBy(string $Reported_By): void
    {
        $this->Reported_By = $Reported_By;
    }

    /**
     * @return string
     */
    public function getReportedAt(): string
    {
        return $this->Reported_At;
    }

    /**
     * @param string $Reported_At
     */
    public function setReportedAt(string $Reported_At): void
    {
        $this->Reported_At = $Reported_At;
    }

    /**
     * @param bool $Readable
     * @return int
     */
    public function getReportReason(bool $Readable=false): int | string
    {
        if ($Readable){
            return match ($this->Report_Reason) {
                self::REPORTED_CAMPAIGN_NOT_THERE => 'Campaign Not There',
                self::REPORTED_CAMPAIGN_NOT_ACTIVE => 'Campaign Not Active',
                self::REPORTED_CAMPAIGN_NO_DONORS => 'No Donors',
                self::REPORTED_CAMPAIGN_FAKE_CAMPAIGN => 'Fake Campaign',
                self::REPORTED_CAMPAIGN_OTHER => 'Other',
                default => 'Unknown',
            };
        }
        return $this->Report_Reason;
    }

    /**
     * @param int $Report_Reason
     */
    public function setReportReason(int $Report_Reason): void
    {
        $this->Report_Reason = $Report_Reason;
    }

    /**
     * @return string|null
     */
    public function getReportDescription(): ?string
    {
        return $this->Report_Description;
    }

    /**
     * @param string|null $Report_Description
     */
    public function setReportDescription(?string $Report_Description): void
    {
        $this->Report_Description = $Report_Description;
    }


    public static function ReportCampaign(string $CampaignID,int $Reason, string $Description=null): bool
    {
        $UserID = Application::$app->getUser()->getID();
        $ReportedCampaign=new ReportedCampaign();
        $ReportedCampaign->setCampaignID($CampaignID);
        $ReportedCampaign->setReportedBy($UserID);
        $ReportedCampaign->setReportedAt(date('Y-m-d H:i:s'));
        $ReportedCampaign->setReportReason($Reason);
        $ReportedCampaign->setReportDescription($Description);
        if ($ReportedCampaign->save())
            return true;
        else
            return false;
    }

    public function labels(): array
    {
        return [
            'Campaign_ID'=>'Campaign ID',
            'Reported_By'=>'Reported By',
            'Reported_At'=>'Reported At',
            'Report_Reason'=>'Report Reason',
            'Report_Description'=>'Report Description',
        ];
    }

    public function rules(): array
    {
        return [
            'Campaign_ID'=>[self::RULE_REQUIRED,self::RULE_UNIQUE],
            'Reported_By'=>[self::RULE_REQUIRED],
            'Reported_At'=>[self::RULE_REQUIRED],
            'Report_Reason'=>[self::RULE_REQUIRED],
        ];
    }

    public static function getTableShort(): string
    {
        return 'Reported_Campaign';
    }

    public static function tableName(): string
    {
        return 'Reported_Campaigns';
    }

    public static function PrimaryKey(): string
    {
        return 'Campaign_ID';
    }

    public function attributes(): array
    {
        return [
            'Campaign_ID',
            'Reported_By',
            'Reported_At',
            'Report_Reason',
            'Report_Description',
        ];
    }
}