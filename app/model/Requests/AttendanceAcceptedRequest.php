<?php

namespace App\model\Requests;
//TODO : Create Attendance Accepted Request Model
class AttendanceAcceptedRequest extends \App\model\database\dbModel
{
    protected string $Donor_ID='';
    protected string $Request_ID='';
    protected string $Campaign_ID='';

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
        return 'attendance_accepted_requests';
    }

    public static function PrimaryKey(): string
    {
        // TODO: Implement PrimaryKey() method.
        return 'Request_ID';
    }

    public function attributes(): array
    {
        // TODO: Implement attributes() method.
        return [
            'Request_ID',
            'Donor_ID',
            'Campaign_ID',
        ];
    }
}