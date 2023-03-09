<?php

namespace App\model\Email;

class RegisterOTP extends \App\model\database\dbModel
{
    protected string $Email;
    protected string $OTP;
    protected string $Created_At;
    protected string $Updated_At;
    protected string $Expired_At;
    protected int $No_Of_Attempts=0;
    public function labels(): array
    {
        return [
            'Email'=>'Email',
            'OTP'=>'OTP',
            'Created_At'=>'Created At',
            'Updated_At'=>'Updated At',
            'Expired_At'=>'Expired At',
            'No_Of_Attempts'=>'No Of Attempts'
        ];
    }

    public function rules(): array
    {
        return [
            'Email'=>[self::RULE_REQUIRED,self::RULE_EMAIL],
            'OTP'=>[self::RULE_REQUIRED],
            'Created_At'=>[self::RULE_REQUIRED],
            'Updated_At'=>[self::RULE_REQUIRED],
            'Expired_At'=>[self::RULE_REQUIRED],
            'No_Of_Attempts'=>[self::RULE_REQUIRED]
        ];
    }

    public static function getTableShort(): string
    {
        return 'regotp';
    }

    public static function tableName(): string
    {
        return 'Register_OTP';
    }

    public static function PrimaryKey(): string
    {
        return 'Email';
    }

    public function attributes(): array
    {
        // TODO: Implement attributes() method.
    }
}