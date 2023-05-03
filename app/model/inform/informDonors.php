<?php

namespace App\model\inform;

use App\model\database\dbModel;

class informDonors extends dbModel
{
    public const PENDING = 1;
    public const APPROVED = 2;
    protected string $Campaign_ID='';
    protected string $Message_ID='';
    protected string $Message='';
    protected string $Status='';
    protected string $Type='';

    public function labels(): array
    {
        // TODO: Implement labels() method.
        return[
            'Message' => 'Message',


        ];
    }

    public function rules(): array
    {
        // TODO: Implement rules() method.
        return [
            'Message'=>[self::RULE_REQUIRED,[self::RULE_MAX,'max' => 200],[self::RULE_MIN,'min' => 10]],
//            'Password'=>[self::RULE_REQUIRED],
        ];
    }

    public static function getTableShort(): string
    {
        // TODO: Implement getTableShort() method.
        return 'spn';
    }

    public function GetAttributesValue($attributes)
    {
        return $this->{$attributes};
    }

    public static function tableName(): string
    {
        // TODO: Implement tableName() method.
        return 'Inform_Donors';
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
    public function getMessageID(): string
    {
        return $this->Message_ID;
    }

    /**
     * @param string $Message_ID
     */
    public function setMessageID(string $Message_ID): void
    {
        $this->Message_ID = $Message_ID;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->Status;
    }

    /**
     * @param string $Status
     */
    public function setStatus(string $Status): void
    {
        $this->Status = $Status;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->Type;
    }

    /**
     * @param string $Type
     */
    public function setType(string $Type): void
    {
        $this->Type = $Type;
    }

    public static function PrimaryKey(): string
    {
        // TODO: Implement PrimaryKey() method.
        return 'Message_ID';
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->Message;
    }

    /**
     * @param string $Message
     */
    public function setMessage(string $Message): void
    {
        $this->Message = $Message;
    }

    public function attributes(): array
    {
        // TODO: Implement attributes() method.
        return [
            'Message_ID',
            'Message',
            'Status',
            'Campaign_ID',
            'Type',
        ];
    }

}