<?php

namespace App\model\Donor;

use App\model\database\dbModel;

class ReportedDonor extends dbModel
{
    protected string $Report_ID='';
    protected string $Donor_ID='';
    protected string $Reported_By='';
    protected string $Reported_At='';
    protected string $Reason='';
    protected int $Status=0;

    /**
     * @return string
     */
    public function getReportID(): string
    {
        return $this->Report_ID;
    }

    /**
     * @param string $Report_ID
     */
    public function setReportID(string $Report_ID): void
    {
        $this->Report_ID = $Report_ID;
    }

    /**
     * @return string
     */
    public function getDonorID(): string
    {
        return $this->Donor_ID;
    }

    /**
     * @param string $Donor_ID
     */
    public function setDonorID(string $Donor_ID): void
    {
        $this->Donor_ID = $Donor_ID;
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
     * @return string
     */
    public function getReason(): string
    {
        return $this->Reason;
    }

    /**
     * @param string $Reason
     */
    public function setReason(string $Reason): void
    {
        $this->Reason = $Reason;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->Status;
    }

    /**
     * @param int $Status
     */
    public function setStatus(int $Status): void
    {
        $this->Status = $Status;
    }




    public function labels(): array
    {
        return [
            'Report_ID'=>'Report ID',
            'Donor_ID'=>'Donor ID',
            'Reported_By'=>'Reported By',
            'Reported_At'=>'Reported At',
            'Reason'=>'Reason',
            'Status'=>'Status'
        ];
    }

    public function rules(): array
    {
        return [
            'Report_ID'=>[self::RULE_REQUIRED],
            'Donor_ID'=>[self::RULE_REQUIRED],
            'Reported_By'=>[self::RULE_REQUIRED],
            'Reported_At'=>[self::RULE_REQUIRED],
            'Reason'=>[self::RULE_REQUIRED],
        ];
    }

    public static function getTableShort(): string
    {
        return 'rpt_dnr';

    }

    public static function tableName(): string
    {
        return 'Reported_Donors';
    }

    public static function PrimaryKey(): string
    {
        return 'Report_ID';
    }

    public function attributes(): array
    {
        return [
            'Report_ID',
            'Donor_ID',
            'Reported_By',
            'Reported_At',
            'Reason',
            'Status'
        ];
    }


}