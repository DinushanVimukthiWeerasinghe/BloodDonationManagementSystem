<?php

namespace App\model\sponsor;

use App\model\Utils\Security;

class AnonymousSponsor extends \App\model\database\dbModel
{
    
    public const PAYMENT_STATUS_PENDING = 1;
    public const PAYMENT_STATUS_PAID = 2;
    public const PAYMENT_STATUS_FAILED = 3;
    
    protected string $Sponsor_ID='';
    protected string $Request_ID='';
    protected string $Email='';
    protected int $Amount=0;
    protected string $Sponsored_At='';
    protected int $Status = 1;
    protected string $Session_ID = '';

    /**
     * @return string
     */
    public function getSponsorID(): string
    {
        return $this->Sponsor_ID;
    }

    /**
     * @param string $Sponsor_ID
     */
    public function setSponsorID(string $Sponsor_ID): void
    {
        $this->Sponsor_ID = $Sponsor_ID;
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
    public function getEmail(): string
    {
        return $this->Email;
    }

    /**
     * @param string $Email
     */
    public function setEmail(string $Email): void
    {
        $this->Email = $Email;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->Amount;
    }

    /**
     * @param int $Amount
     */
    public function setAmount(int $Amount): void
    {
        $this->Amount = $Amount;
    }

    /**
     * @return string
     */
    public function getSponsoredAt(): string
    {
        return $this->Sponsored_At;
    }

    /**
     * @param string $Sponsored_At
     */
    public function setSponsoredAt(string $Sponsored_At): void
    {
        $this->Sponsored_At = $Sponsored_At;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->Status;
    }

    /**
     * @param int $Status
     */
    public function setStatus(int $Status): void
    {
        $this->Status = $Status;
    }

    /**
     * @return string
     */
    public function getSessionID(): string
    {
        return Security::Decrypt($this->Session_ID);
    }

    /**
     * @param string $Session_ID
     */
    public function setSessionID(string $Session_ID): void
    {
        $this->Session_ID = Security::Encrypt($Session_ID);
    }

    public static function CreateAnonymousSponsor(string $RequestID,string $AnonymousSponsorID,string $Email,int $Amount,string $Session_ID): AnonymousSponsor
    {
        $AnonymousSponsor = new AnonymousSponsor();
        $AnonymousSponsor->setSponsorID($AnonymousSponsorID);
        $AnonymousSponsor->setRequestID($RequestID);
        $AnonymousSponsor->setEmail($Email);
        $AnonymousSponsor->setAmount($Amount);
        $AnonymousSponsor->setSponsoredAt(date('Y-m-d H:i:s'));
        $AnonymousSponsor->setStatus(self::PAYMENT_STATUS_PENDING);
        $AnonymousSponsor->setSessionID($Session_ID);
        return $AnonymousSponsor;
    }
    
    



    public function labels(): array
    {
        return [
            'Sponsor_ID'=>'Sponsor ID',
            'Request_ID'=>'Request ID',
            'Email'=>'Email',
            'Amount'=>'Amount',
            'Sponsored_At'=>'Sponsored At',
            'Status'=>'Status',
            'Session_ID'=>'Session ID',
        ];
    }

    public function rules(): array
    {
        return [
            'Sponsor_ID'=>[self::RULE_REQUIRED],
            'Request_ID'=>[self::RULE_REQUIRED],
            'Email'=>[self::RULE_REQUIRED],
            'Amount'=>[self::RULE_REQUIRED],
            'Sponsored_At'=>[self::RULE_REQUIRED],
            'Status'=>[self::RULE_REQUIRED],
            'Session_ID'=>[self::RULE_REQUIRED],
        ];
    }

    public static function getTableShort(): string
    {
        return 'Anonymous_Sponsors';
    }

    public static function tableName(): string
    {
        return 'Anonymous_Sponsors';
    }

    public static function PrimaryKey(): string
    {
        return 'Sponsor_ID';
    }

    public function attributes(): array
    {
        return [
            'Sponsor_ID',
            'Request_ID',
            'Email',
            'Amount',
            'Sponsored_At',
            'Status',
            'Session_ID',
        ];
    }
}