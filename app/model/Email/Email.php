<?php

namespace App\model\Email;

use App\model\database\dbModel;

class Email extends dbModel
{
    public const NORMAL_EMAIL = 1;
    public const CONFIDENTIAL_EMAIL=2;
    public const EMAIL_PENDING=1;
    public const EMAIL_SENT=2;
    protected string $Email_ID='';
    protected string $Receiver='';
    protected string $Sender='';
    protected int $Email_Type=0;
    protected string $Subject='';
    protected string $Body='';
    protected string $Attachment='';
    protected int $Email_Status=0;
    protected string $Created_At='';
    protected string $Updated_At='';

    /**
     * @return string
     */
    public function getEmailID(): string
    {
        return $this->Email_ID;
    }

    /**
     * @return string
     */
    public function getAttachment(): string
    {
        return $this->Attachment;
    }

    /**
     * @param string $Attachment
     */
    public function setAttachment(string $Attachment): void
    {
        $this->Attachment = $Attachment;
    }


    /**
     * @param string $Email_ID
     */
    public function setEmailID(string $Email_ID): void
    {
        $this->Email_ID = $Email_ID;
    }

    /**
     * @return string
     */
    public function getSender(): string
    {
        return $this->Sender;
    }

    /**
     * @param string $Sender
     */
    public function setSender(string $Sender): void
    {
        $this->Sender = $Sender;
    }



    /**
     * @return string
     */
    public function getReceiver(): string
    {
        return $this->Receiver;
    }

    /**
     * @param string $Receiver
     */
    public function setReceiver(string $Receiver): void
    {
        $this->Receiver = $Receiver;
    }

    /**
     * @return int
     */
    public function getEmailType(): int
    {
        return $this->Email_Type;
    }

    /**
     * @param int $Email_Type
     */
    public function setEmailType(int $Email_Type): void
    {
        $this->Email_Type = $Email_Type;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->Subject;
    }

    /**
     * @param string $Subject
     */
    public function setSubject(string $Subject): void
    {
        $this->Subject = $Subject;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->Body;
    }

    /**
     * @param string $Body
     */
    public function setBody(string $Body): void
    {
        $this->Body = $Body;
    }

    /**
     * @return int
     */
    public function getEmailStatus(): int
    {
        return $this->Email_Status;
    }

    /**
     * @param int $Email_Status
     */
    public function setEmailStatus(int $Email_Status): void
    {
        $this->Email_Status = $Email_Status;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->Created_At;
    }

    /**
     * @param string|null $Created_At
     */
    public function setCreatedAt(?string $Created_At): void
    {
        $this->Created_At = $Created_At;
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->Updated_At;
    }

    /**
     * @param string|null $Updated_At
     */
    public function setUpdatedAt(?string $Updated_At): void
    {
        $this->Updated_At = $Updated_At;
    }



    public function __construct()
    {
        $this->Created_At=date('Y-m-d H:i:s');
        $this->Updated_At=date('Y-m-d H:i:s');
    }

    public function labels(): array
    {
        return [
            'Email_ID'=>'Email ID',
            'Receiver'=>'Receiver',
            'Email_Type'=>'Email Type',
            'Subject'=>'Subject',
            'Body'=>'Body',
            'Email_Status'=>'Email Status',
            'Created_At'=>'Email Created At',
            'Updated_At'=>'Email Updated At',
            'Sender'=>'Sender'
        ];
    }

    public function rules(): array
    {
        return [
            'Email_ID'=>[self::RULE_REQUIRED,self::RULE_UNIQUE],
            'Receiver'=>[self::RULE_REQUIRED],
            'Email_Type'=>[self::RULE_REQUIRED],
            'Subject'=>[self::RULE_REQUIRED],
            'Body'=>[self::RULE_REQUIRED],
            'Email_Status'=>[self::RULE_REQUIRED],
            'Created_At'=>[self::RULE_REQUIRED],
        ];
    }

    public static function getTableShort(): string
    {
        return 'Email';
    }

    public static function tableName(): string
    {
        return 'Email';
    }

    public static function PrimaryKey(): string
    {
        return 'Email_ID';
    }

    public function attributes(): array
    {
        return [
            'Email_ID',
            'Receiver',
            'Email_Type',
            'Subject',
            'Body',
            'Email_Status',
            'Created_At',
            'Updated_At',
            'Sender',
            'Attachment'
        ];
    }
}