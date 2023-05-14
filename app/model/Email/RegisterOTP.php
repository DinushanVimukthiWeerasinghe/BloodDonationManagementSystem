<?php

namespace App\model\Email;

use Core\Application;
use PHPMailer\PHPMailer\Exception;

class RegisterOTP extends \App\model\database\dbModel
{
    protected string $Email;
    protected string $OTP;
    protected string $Created_At;
    protected string $Updated_At;
    protected int $No_Of_Attempts=0;

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
     * @return string
     */
    public function getOTP(): string
    {
        return $this->OTP;
    }

    /**
     * @param string $OTP
     */
    public function setOTP(string $OTP): void
    {
        $this->OTP = $OTP;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->Created_At;
    }

    /**
     * @param string $Created_At
     */
    public function setCreatedAt(string $Created_At): void
    {
        $this->Created_At = $Created_At;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->Updated_At;
    }

    /**
     * @param string $Updated_At
     */
    public function setUpdatedAt(string $Updated_At): void
    {
        $this->Updated_At = $Updated_At;
    }

    /**
     * @return int
     */
    public function getNoOfAttempts(): int
    {
        return $this->No_Of_Attempts;
    }

    /**
     * @param int $No_Of_Attempts
     */
    public function setNoOfAttempts(int $No_Of_Attempts): void
    {
        $this->No_Of_Attempts = $No_Of_Attempts;
    }

    public function GenerateOTP()
    {
        $this->OTP=mt_rand(10000,99999);
    }
    private function getBody(): string
    {
        return "<h1>OTP</h1><p>Your OTP is {$this->OTP}</p>";
    }

    /**
     * @throws Exception
     */
    public function SendOTP(string $Email): bool
    {
        $this->Email=$Email;
        $this->GenerateOTP();
        $this->Created_At=date('Y-m-d H:i:s');
        $this->Updated_At=date('Y-m-d H:i:s');
        $this->No_Of_Attempts=0;
        $EmailClient = Application::$app->email;
        $EmailClient->setFrom('bdmsgroupcs46@gmail.com');
        if (MODE===DEVELOPMENT)
            $EmailClient->setTo(DEV_EMAIL);
        else
            $EmailClient->setTo($this->Email);
        $EmailClient->setBody($this->getBody());
        $EmailClient->setSubject('OTP');
//        exit();
        try {
            $EmailClient->send();
            /** @var RegisterOTP $PreviousOTP */
            $PreviousOTP = self::findOne(['Email' => $this->Email]);
            if ($PreviousOTP){
                if ($PreviousOTP->getNoOfAttempts()>=8) {
                    throw new Exception('You have reached the maximum number of attempts. Please try again later.');
                }
                $PreviousOTP->setOTP($this->OTP);
                $PreviousOTP->setNoOfAttempts($PreviousOTP->getNoOfAttempts()+1);
                return $PreviousOTP->update($this->Email,[],['No_Of_Attempts','OTP']);
            }else{
                return $this->save();
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

    }


    public function labels(): array
    {
        return [
            'Email'=>'Email',
            'OTP'=>'OTP',
            'Created_At'=>'Created At',
            'Updated_At'=>'Updated At',
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
        return ['Email','OTP','Created_At','Updated_At','No_Of_Attempts'];
    }
}