<?php

namespace App\model\Notification;
//TODO : Create Admin Notification Model
class DonorNotification extends \App\model\database\dbModel
{
    public const INFORM_ALL_DONOR = 0;
    public const INFORM_GROUP_OF_DONOR = 2;
    public const NOTIFICATION_STATE_UNREAD = 1;

    protected string $Notification_ID='';
    protected int $Notification_Type=0;
    protected int $Notification_State=0;
    protected ?string $Target_ID=null;
    protected ?string $Target_Group=null;
    protected string $Notification_Title='';
    protected string $Notification_Message='';
    protected string $Notification_Date='';
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
     * @return int
     */
    public function getNotificationType(): int
    {
        return $this->Notification_Type;
    }

    /**
     * @param int $Notification_Type
     */
    public function setNotificationType(int $Notification_Type): void
    {
        $this->Notification_Type = $Notification_Type;
    }

    /**
     * @return int
     */
    public function getNotificationState(): int
    {
        return $this->Notification_State;
    }

    /**
     * @param int $Notification_State
     */
    public function setNotificationState(int $Notification_State): void
    {
        $this->Notification_State = $Notification_State;
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
    public function getValidUntil(): string
    {
        return $this->Valid_Until;
    }

    /**
     * @param string $Valid_Until
     */
    public function setValidUntil(string $Valid_Until): void
    {
        $this->Valid_Until = $Valid_Until;
    }

    /**
     * @return string|null
     */
    public function getTargetGroup(): ?string
    {
        return $this->Target_Group;
    }

    /**
     * @param string|null $Target_Group
     */
    public function setTargetGroup(?string $Target_Group): void
    {
        $this->Target_Group = $Target_Group;
    }

    public function __construct()
    {
        $this->Notification_ID=uniqid('DN_');
        $this->Notification_Date=date('Y-m-d H:i:s');
    }

    public function labels(): array
    {
        return [
            'Notification_ID'=>'Notification ID',
            'Notification_Type'=>'Notification Type',
            'Notification_State'=>'Notification State',
            'Target_ID'=>'Target ID',
            'Notification_Title'=>'Notification Title',
            'Notification_Message'=>'Notification Message',
            'Notification_Date'=>'Notification Date',
            'Valid_Until'=>'Valid Until',
            'Target_Group'=>'Target Group'
        ];
    }

    public function rules(): array
    {
        return [
            'Notification_ID'=>[self::RULE_REQUIRED,self::RULE_UNIQUE],
            'Notification_Type'=>[self::RULE_REQUIRED],
            'Notification_State'=>[self::RULE_REQUIRED],
            'Notification_Title'=>[self::RULE_REQUIRED],
            'Notification_Message'=>[self::RULE_REQUIRED],
            'Notification_Date'=>[self::RULE_REQUIRED],
            'Valid_Until'=>[self::RULE_REQUIRED]
        ];
    }

    public static function getTableShort(): string
    {
        return 'dn';
    }

    public static function tableName(): string
    {
        return 'Donor_Notifications';
    }

    public static function PrimaryKey(): string
    {
        return 'Notification_ID';
    }

    public function attributes(): array
    {
        return [
            'Notification_ID',
            'Notification_Type',
            'Notification_State',
            'Target_ID',
            'Notification_Title',
            'Notification_Message',
            'Notification_Date',
            'Valid_Until',
            'Target_Group'
        ];
    }
}