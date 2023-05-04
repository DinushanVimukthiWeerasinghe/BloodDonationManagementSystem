<?php

namespace App\model\Requests;

use App\model\database\dbModel;

class additional_sponsorship_request extends dbModel
{
    public const PENDING = 1;
    public const APPROVED = 2;
    protected string $Request_ID='';
    protected string $Campaign_ID='';
    protected string $Account_Number='';
    protected string $Bank_Name='';
    protected string $Branch_Name='';
    protected string $Account_Name='';
    protected string $Status='';
    protected string $Amount='';


    public function labels(): array
    {
        // TODO: Implement labels() method.
        return[
            'Amount' => 'Amount',
            'Account_Number' => 'Account_Number',
        ];
    }

    public function rules(): array
    {
        // TODO: Implement rules() method.
        return [
            'Account_Number'=>[self::RULE_REQUIRED,[self::RULE_MAX,'max' => 200],[self::RULE_MIN,'min' => 7],[self::RULE_NUMERIC]],
            'Amount'=>[self::RULE_REQUIRED,[self::RULE_MAX,'max' => 10],[self::RULE_MIN,'min' => 4],[self::RULE_NUMERIC]],
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
        return 'additional_sponsorship_requests';
    }

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
    public function getAccountNumber(): string
    {
        return $this->Account_Number;
    }

    /**
     * @param string $Account_Number
     */
    public function setAccountNumber(string $Account_Number): void
    {
        $this->Account_Number = $Account_Number;
    }

    /**
     * @return string
     */
    public function getBankName(): string
    {
        return $this->Bank_Name;
    }

    /**
     * @param string $Bank_Name
     */
    public function setBankName(string $Bank_Name): void
    {
        $this->Bank_Name = $Bank_Name;
    }

    /**
     * @return string
     */
    public function getBranchName(): string
    {
        return $this->Branch_Name;
    }

    /**
     * @param string $Branch_Name
     */
    public function setBranchName(string $Branch_Name): void
    {
        $this->Branch_Name = $Branch_Name;
    }

    /**
     * @return string
     */
    public function getAccountName(): string
    {
        return $this->Account_Name;
    }

    /**
     * @param string $Account_Name
     */
    public function setAccountName(string $Account_Name): void
    {
        $this->Account_Name = $Account_Name;
    }

    /**
     * @return string
     */
    public function getAmount(): string
    {
        return $this->Amount;
    }

    /**
     * @param string $Amount
     */
    public function setAmount(string $Amount): void
    {
        $this->Amount = $Amount;
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
            'Amount',
            'Status',
            'Campaign_ID',
            'Bank_Name',
            'Branch_Name',
            'Account_Name',
            'Account_Number',
        ];
    }
}