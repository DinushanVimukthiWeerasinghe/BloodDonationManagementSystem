<?php

namespace App\model\Authentication;

use App\model\database\dbModel;

class LoggingHistory extends dbModel
{
    public const Logout = 1;
    public const Timeout = 2;
    protected string $Session_ID='';
    protected string $User_ID='';
    protected string $Session_Start='';
    protected string $Session_End='';
    protected int $Session_End_Type=0;
    public function labels(): array
    {
        return [
            'Session_ID' => 'Session ID',
            'User_ID' => 'User ID',
            'Session_Start' => 'Session Start',
            'Session_End' => 'Session End',
            'Session_End_Type' => 'Session End Type',
        ];
    }

    public function rules(): array
    {
        return [
            'Session_ID' => [self::RULE_REQUIRED],
            'User_ID' => [self::RULE_REQUIRED],
            'Session_Start' => [self::RULE_REQUIRED],
            'Session_End_Type' => [self::RULE_REQUIRED],
        ];
    }

    public static function getTableShort(): string
    {
        return 'Logging_History';
    }

    public static function tableName(): string
    {
        return 'Logging_History';
    }

    public static function PrimaryKey(): string
    {
        return 'Session_ID';
    }

    /**
     * @return string
     */
    public function getSessionID(): string
    {
        return $this->Session_ID;
    }

    /**
     * @param string $Session_ID
     */
    public function setSessionID(string $Session_ID): void
    {
        $this->Session_ID = $Session_ID;
    }

    /**
     * @return string
     */
    public function getUserID(): string
    {
        return $this->User_ID;
    }

    /**
     * @param string $User_ID
     */
    public function setUserID(string $User_ID): void
    {
        $this->User_ID = $User_ID;
    }

    /**
     * @return string
     */
    public function getSessionStart(): string
    {
        return $this->Session_Start;
    }

    /**
     * @param string $Session_Start
     */
    public function setSessionStart(string $Session_Start): void
    {
        $this->Session_Start = $Session_Start;
    }

    /**
     * @return string
     */
    public function getSessionEnd(): string
    {
        return $this->Session_End;
    }

    /**
     * @param string $Session_End
     */
    public function setSessionEnd(string $Session_End): void
    {
        $this->Session_End = $Session_End;
    }

    /**
     * @return int
     */
    public function getSessionEndType(): int
    {
        return $this->Session_End_Type;
    }

    /**
     * @param int $Session_End_Type
     */
    public function setSessionEndType(int $Session_End_Type): void
    {
        $this->Session_End_Type = $Session_End_Type;
    }

    public function attributes(): array
    {
        return ['Session_ID', 'User_ID', 'Session_Start', 'Session_End', 'Session_End_Type'];
    }
}