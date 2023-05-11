<?php

namespace App\model\Notification;
//TODO : Create Admin Notification Model
use App\model\database\dbModel;

class HospitalNotification extends dbModel
{
    protected string $Notification_ID;
    protected string $Notification_Title;
    protected string $Notification_Message;
    protected string $Notification_Date;
    protected string $Notification_Status;
    protected string $Notification_Type;
    protected string $Target_ID;

    protected ?string $Valid_Until=null;

    public function getNotificationID(): string
    {
        return $this->Notification_ID;
    }

    public function setNotificationID(string $Notification_ID): void
    {
        $this->Notification_ID = $Notification_ID;
    }

    public function getNotificationTitle(): string
    {
        return $this->Notification_Title;
    }

    public function setNotificationTitle(string $Notification_Title): void
    {
        $this->Notification_Title = $Notification_Title;
    }

    public function getNotificationMessage(): string
    {
        return $this->Notification_Message;
    }

    public function setNotificationMessage(string $Notification_Message): void
    {
        $this->Notification_Message = $Notification_Message;
    }

    public function getNotificationDate(): string
    {
        return $this->Notification_Date;
    }

    public function setNotificationDate(string $Notification_Date): void
    {
        $this->Notification_Date = $Notification_Date;
    }

    public function getNotificationStatus(): string
    {
        return $this->Notification_Status;
    }

    public function setNotificationStatus(string $Notification_Status): void
    {
        $this->Notification_Status = $Notification_Status;
    }

    public function getNotificationType(): string
    {
        return $this->Notification_Type;
    }

    public function setNotificationType(string $Notification_Type): void
    {
        $this->Notification_Type = $Notification_Type;
    }

    public function getTargetID(): string
    {
        return $this->Target_ID;
    }

    public function setTargetID(string $Target_ID): void
    {
        $this->Target_ID = $Target_ID;
    }

    public function getValidUntil(): string
    {
        return $this->Valid_Until;
    }

    public function setValidUntil(string $Valid_Until): void
    {
        $this->Valid_Until = $Valid_Until;
    }

    public function labels(): array
    {
        // TODO: Implement labels() method.
        return [
            'Notification_ID'=>'Notification ID',
            'Notification_Title'=>'Notification Title',
            'Notification_Message'=>'Notification Message',
            'Notification_Date'=>'Notification Date',
            'Notification_Status'=>'Notification Status',
            'Notification_Type'=>'Notification Type',
            'Target_ID'=>'Target ID',
            'Valid_Until'=>'Valid Until'
        ];
    }

    public function rules(): array
    {
        // TODO: Implement rules() method.
        return [
            'Notification_Title'=>[self::RULE_REQUIRED],
            'Notification_Message'=>[self::RULE_REQUIRED],
            'Notification_Date'=>[self::RULE_REQUIRED],
            'Notification_Status'=>[self::RULE_REQUIRED],
            'Notification_Type'=>[self::RULE_REQUIRED],
            'Valid_Until'=>[self::RULE_REQUIRED]
        ];
    }

    public static function getTableShort(): string
    {
        // TODO: Implement getTableShort() method.
        return 'hn';
    }

    public static function tableName(): string
    {
        // TODO: Implement tableName() method.
        return 'Hospital_Notifications';
    }

    public static function PrimaryKey(): string
    {
        // TODO: Implement PrimaryKey() method.
        return 'Notification_ID';
    }

    public function attributes(): array
    {
        // TODO: Implement attributes() method.
        return [
            'Notification_Title',
            'Notification_Message',
            'Notification_Date',
            'Notification_Status',
            'Notification_Type',
            'Target_ID',
            'Valid_Until'
        ];
    }
}