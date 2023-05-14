<?php

namespace App\model\Organization;

use App\model\users\MedicalOfficer;

/**
 *
 */
class ReportOrganization extends \App\model\database\dbModel
{
    /**
     * @var string
     */
    protected string $Organization_ID='';
    /**
     * @var string
     */
    protected string $Report_Reason="";
    /**
     * @var string|null
     */
    protected ?string $Report_Description=null;
    /**
     * @var string
     */
    protected string $Reported_By="";
    /**
     * @var string
     */
    protected string $Reported_At="";
    /**
     * @var int|null
     */
    protected ?int $Action=null;
    /**
     * @var string
     */
    protected string $Reply="";
    /**
     * @var string
     */
    protected string $Reply_Action="";

    /**
     * @return string
     */
    public function getOrganizationID(): string
    {
        return $this->Organization_ID;
    }

    /**
     * @param string $Organization_ID
     */
    public function setOrganizationID(string $Organization_ID): void
    {
        $this->Organization_ID = $Organization_ID;
    }

    /**
     * @return string
     */
    public function getReportReason(): string
    {
        return $this->Report_Reason;
    }

    /**
     * @param string $Report_Reason
     */
    public function setReportReason(string $Report_Reason): void
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
     * @return int|null
     */
    public function getAction(): ?int
    {
        return $this->Action;
    }

    /**
     * @param int|null $Action
     */
    public function setAction(?int $Action): void
    {
        $this->Action = $Action;
    }

    /**
     * @return string
     */
    public function getReply(): string
    {
        return $this->Reply;
    }

    /**
     * @param string $Reply
     */
    public function setReply(string $Reply): void
    {
        $this->Reply = $Reply;
    }

    /**
     * @return string
     */
    public function getReplyAction(): string
    {
        return $this->Reply_Action;
    }

    /**
     * @param string $Reply_Action
     */
    public function setReplyAction(string $Reply_Action): void
    {
        $this->Reply_Action = $Reply_Action;
    }

    public function getReporter()
    {
        return MedicalOfficer::findOne(['Officer_ID'=>$this->getReportedBy()]);
    }

    public static function ReportOrganization(string $OrganizationID,string $ReporterID,string $ReportReason,string $ReportDescription=null): bool
    {
        $ReportOrganization = new self();
        $ReportOrganization->setOrganizationID($OrganizationID);
        $ReportOrganization->setReportedBy($ReporterID);
        $ReportOrganization->setReportedAt(date("Y-m-d H:i:s"));
        $ReportOrganization->setReportReason($ReportReason);
        $ReportOrganization->setReportDescription($ReportDescription);
        if ($ReportOrganization->validate()){
            $ReportOrganization->save();
            return true;
        }else{
            return false;
        }

    }


    /**
     * @return string[]
     */
    public function labels(): array
    {
        return [
                'Organization_ID',
                'Report_Reason',
                'Report_Description',
                'Reported_By',
                'Reported_At',
                'Action',
                'Reply',
                'Reply_Action'
        ];
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'Organization_ID'=>[self::RULE_REQUIRED],
            'Report_Reason'=>[self::RULE_REQUIRED],
            'Reported_By'=>[self::RULE_REQUIRED],
            'Reported_At'=>[self::RULE_REQUIRED],
            ];
    }

    /**
     * @return string
     */
    public static function getTableShort(): string
    {
        return 'Reported_Organization';
    }

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return "Reported_Organization";
    }

    /**
     * @return string
     */
    public static function PrimaryKey(): string
    {
        return "Organization_ID";
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'Organization_ID',
            'Report_Reason',
            'Report_Description',
            'Reported_By',
            'Reported_At',
            'Action',
            'Reply',
            'Reply_Action'
        ];
    }
}