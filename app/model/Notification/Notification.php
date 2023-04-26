<?php

namespace App\model\Notification;

use App\model\database\dbModel;

class Notification extends dbModel
{

    public const Read='read';
    public const ToRead='toRead';
    public const General_Request=0;
    public const Authentication_Request=1;
    public const Emergency_Request=2;
    protected string $ID='';
    protected string $Caused_ID='';
    protected string $Title='';
    protected string $Description='';
    protected string $Type='';
    protected string $SDate='';
    protected string $Status='';


    public function labels(): array
    {
        return [
            'ID'=>'ID',
            'Caused_ID'=>'Caused_ID',
            'Title'=>'Title',
            'Description'=>'Description',
            'Type'=>'Type',
            'SDate'=>'SDate',
            'Status'=>'Status',
        ];
    }

    public function rules(): array
    {
        return [
            'ID'=>[self::RULE_REQUIRED],
            'Caused_ID'=>[self::RULE_REQUIRED],
            'Title'=>[self::RULE_REQUIRED],
            'Description'=>[self::RULE_REQUIRED],
            'Type'=>[self::RULE_REQUIRED],
            'SDate'=>[self::RULE_REQUIRED],
            'Status'=>[self::RULE_REQUIRED],
        ];
    }

    public static function getTableShort(): string
    {
        // TODO: Implement getTableShort() method.
    }

    public static function tableName(): string
    {
        // TODO: Implement tableName() method.
    }

    public static function PrimaryKey(): string
    {
        // TODO: Implement PrimaryKey() method.
    }

    public function attributes(): array
    {
        // TODO: Implement attributes() method.
    }
}