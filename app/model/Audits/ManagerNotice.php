<?php

namespace App\model\Audits;

class ManagerNotice extends \App\model\database\dbModel
{

    public const STATUS_PENDING = 1;
    public const STATUS_CRITICAL = 2;
    public const STATUS_NORMAL = 3;
    public const STATUS_COMPLETED = 4;

    public const ACTION_PENDING = 1;
    public const ACTION_RESOLVED = 2;
    public const ACTION_IGNORED = 3;
    protected string $Notice_ID='';
    protected string $Notice_Title='';
    protected string $Notice_Content='';
    protected string $Notice_Date='';
    protected int $Notice_Status=1;
    protected int $Notice_Action=1;

    /**
     * @return string
     */
    public function getNoticeID(): string
    {
        return $this->Notice_ID;
    }

    /**
     * @param string $Notice_ID
     */
    public function setNoticeID(string $Notice_ID): void
    {
        $this->Notice_ID = $Notice_ID;
    }

    /**
     * @return string
     */
    public function getNoticeTitle(): string
    {
        return $this->Notice_Title;
    }

    /**
     * @param string $Notice_Title
     */
    public function setNoticeTitle(string $Notice_Title): void
    {
        $this->Notice_Title = $Notice_Title;
    }

    /**
     * @return string
     */
    public function getNoticeContent(): string
    {
        return $this->Notice_Content;
    }

    /**
     * @param string $Notice_Content
     */
    public function setNoticeContent(string $Notice_Content): void
    {
        $this->Notice_Content = $Notice_Content;
    }

    /**
     * @return string
     */
    public function getNoticeDate(): string
    {
        return $this->Notice_Date;
    }

    /**
     * @param string $Notice_Date
     */
    public function setNoticeDate(string $Notice_Date): void
    {
        $this->Notice_Date = $Notice_Date;
    }

    /**
     * @return int
     */
    public function getNoticeStatus(): int
    {
        return $this->Notice_Status;
    }

    /**
     * @param int $Notice_Status
     */
    public function setNoticeStatus(int $Notice_Status): void
    {
        $this->Notice_Status = $Notice_Status;
    }

    /**
     * @return int
     */
    public function getNoticeAction(): int
    {
        return $this->Notice_Action;
    }

    /**
     * @param int $Notice_Action
     */
    public function setNoticeAction(int $Notice_Action): void
    {
        $this->Notice_Action = $Notice_Action;
    }

    public function labels(): array
    {
        return [
            'Notice_ID'=>'Notice ID',
            'Notice_Title'=>'Notice Title',
            'Notice_Content'=>'Notice Content',
            'Notice_Date'=>'Notice Date',
            'Notice_Status'=>'Notice Status',
            'Notice_Action'=>'Notice Action',
        ];
    }

    public function rules(): array
    {
        return [
            'Notice_ID'=>[self::RULE_REQUIRED],
            'Notice_Title'=>[self::RULE_REQUIRED],
            'Notice_Content'=>[self::RULE_REQUIRED],
            'Notice_Date'=>[self::RULE_REQUIRED],
            'Notice_Status'=>[self::RULE_REQUIRED],
            'Notice_Action'=>[self::RULE_REQUIRED],
        ];
    }

    public static function getTableShort(): string
    {
        return 'manager_notice';
    }

    public static function tableName(): string
    {
        return 'Manager_Notices';
    }

    public static function PrimaryKey(): string
    {
        return 'Notice_ID';
    }

    public function attributes(): array
    {
        return [
            'Notice_ID',
            'Notice_Title',
            'Notice_Content',
            'Notice_Date',
            'Notice_Status',
            'Notice_Action',
        ];
    }
}