<?php

namespace App\model\Notification;
//TODO : Create Admin Notification Model
class MedicalOfficerNotification extends \App\model\database\dbModel
{
    const CAMPAIGN_ASSIGNMENT = 1;
    const TASK_ASSIGNMENT = 2;

    protected string $Notification_ID;
    protected string $Notification_Title;
    protected string $Notification_Message;
    protected string $Notification_Date;
    protected string $Notification_Status;
    protected string $Notification_Type;
    protected string $Target_ID;
    protected ?string $Valid_Until=null;

    /**
     * @return string
     */
    public function getNotificationID(): string
    {
        return $this->Notification_ID;
    }

    /**
     * @param string $Notification_ID
     */
    public function setNotificationID(string $Notification_ID): void
    {
        $this->Notification_ID = $Notification_ID;
    }

    /**
     * @return string
     */
    public function getNotificationTitle(): string
    {
        return $this->Notification_Title;
    }

    /**
     * @param string $Notification_Title
     */
    public function setNotificationTitle(string $Notification_Title): void
    {
        $this->Notification_Title = $Notification_Title;
    }

    /**
     * @return string
     */
    public function getNotificationMessage(): string
    {
        return $this->Notification_Message;
    }

    /**
     * @param string $Notification_Message
     */
    public function setNotificationMessage(string $Notification_Message): void
    {
        $this->Notification_Message = $Notification_Message;
    }

    /**
     * @return string
     */
    public function getNotificationDate(): string
    {
        return $this->Notification_Date;
    }

    /**
     * @param string $Notification_Date
     */
    public function setNotificationDate(string $Notification_Date): void
    {
        $this->Notification_Date = $Notification_Date;
    }

    /**
     * @return string
     */
    public function getNotificationStatus(): string
    {
        return $this->Notification_Status;
    }

    /**
     * @param string $Notification_Status
     */
    public function setNotificationStatus(string $Notification_Status): void
    {
        $this->Notification_Status = $Notification_Status;
    }

    /**
     * @return string
     */
    public function getNotificationType(): string
    {
        return $this->Notification_Type;
    }

    /**
     * @param string $Notification_Type
     */
    public function setNotificationType(string $Notification_Type): void
    {
        $this->Notification_Type = $Notification_Type;
    }

    /**
     * @return string
     */
    public function getTargetID(): string
    {
        return $this->Target_ID;
    }

    /**
     * @param string $Target_ID
     */
    public function setTargetID(string $Target_ID): void
    {
        $this->Target_ID = $Target_ID;
    }

    /**
     * @return string|null
     */
    public function getValidUntil(): ?string
    {
        return $this->Valid_Until;
    }

    /**
     * @param string|null $Valid_Until
     */
    public function setValidUntil(?string $Valid_Until): void
    {
        $this->Valid_Until = $Valid_Until;
    }


    public function labels(): array
    {
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
        return [
            'Notification_ID'=>[self::RULE_REQUIRED],
            'Notification_Title'=>[self::RULE_REQUIRED],
            'Notification_Message'=>[self::RULE_REQUIRED],
            'Notification_Date'=>[self::RULE_REQUIRED],
            'Notification_Status'=>[self::RULE_REQUIRED],
            'Notification_Type'=>[self::RULE_REQUIRED],
            'Target_ID'=>[self::RULE_REQUIRED],
        ];
    }

    public static function tableName(): string
    {
        return 'Medical_Officer_Notifications';
    }

    public static function PrimaryKey(): string
    {
        return 'Notification_ID';
    }

    public function attributes(): array
    {
        return [
            'Notification_ID',
            'Notification_Title',
            'Notification_Message',
            'Notification_Date',
            'Notification_Status',
            'Notification_Type',
            'Target_ID',
            'Valid_Until'
        ];
    }

    public static function getTableShort(): string
    {
        return 'MON';
    }
}