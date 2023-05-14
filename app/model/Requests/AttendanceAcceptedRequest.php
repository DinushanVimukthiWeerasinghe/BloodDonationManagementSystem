<?php

namespace App\model\Requests;
//TODO : Create Attendance Accepted Request Model
class AttendanceAcceptedRequest extends \App\model\database\dbModel
{
    protected string $Donor_ID='';
    protected string $Request_ID='';
    protected string $Campaign_ID='';
    protected string $Accepted_At='';


    /**
     * @return string
     */
    public function getRequestID(): string
    {
        return $this->Request_ID;
    }

    /**
     * @param string $Request_ID
     */
    public function setRequestID(string $Request_ID): void
    {
        $this->Request_ID = $Request_ID;
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
    public function getAcceptedAt(): string
    {
        return $this->Accepted_At;
    }

    /**
     * @param string $Accepted_At
     */
    public function setAcceptedAt(string $Accepted_At): void
    {
        $this->Accepted_At = $Accepted_At;
    }

    public function labels(): array
    {
        return [
            'Donor_ID'=>'Donor ID',
            'Request_ID'=>'Request ID',
            'Campaign_ID'=>'Campaign ID',
            'Accepted_At'=>'Accepted At'
        ];
    }

    public function rules(): array
    {
        return [
            'Donor_ID'=>[self::RULE_REQUIRED],
            'Request_ID'=>[self::RULE_REQUIRED],
            'Campaign_ID'=>[self::RULE_REQUIRED],
            'Accepted_At'=>[self::RULE_REQUIRED]
        ];
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

    public static function getTableShort(): string
    {
        return 'Attendance_Accepted_Requests';
    }

    public function GetAttributesValue($attributes)
    {
        return $this->{$attributes};
    }

    public static function tableName(): string
    {
        return 'Attendance_Accepted_Requests';
    }

    public static function PrimaryKey(): string
    {
        return 'Request_ID';
    }

    public function attributes(): array
    {
        return [
            'Request_ID',
            'Donor_ID',
            'Campaign_ID',
            'Accepted_At'
        ];
    }
}