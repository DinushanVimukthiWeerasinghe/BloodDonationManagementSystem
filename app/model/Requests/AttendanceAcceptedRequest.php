<?php

namespace App\model\Requests;
//TODO : Create Attendance Accepted Request Model
class AttendanceAcceptedRequest extends \App\model\database\dbModel
{
    protected string $Donor_ID='';
    protected string $Request_ID='';
    protected string $Campaign_ID='';
    protected string $Accepted_At='';

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