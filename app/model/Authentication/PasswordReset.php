<?php

namespace App\model\Authentication;

use Core\Application;
use Core\Email;
use PHPMailer\PHPMailer\Exception;

class PasswordReset extends \App\model\database\dbModel
{
    protected string $UID='';
    protected string $Email='';
    protected ?string $Name ='';
    protected string $Token='';
    protected string $Created_at='';
    protected int $Status=0;
    protected string $Device_IP='';
    protected ?string $ResetPassword_At='';

    /**
     * @throws \Exception
     */
    public function GenerateToken()
    {
        $this->Created_at=date('Y-m-d H:i:s');
        $this->Token=bin2hex(random_bytes(50));
    }

    /**
     * @return string
     */
    public function getDeviceIP(): string
    {
        return $this->Device_IP;
    }

    /**
     * @param string $Device_IP
     */
    public function setDeviceIP(string $Device_IP): void
    {
        $this->Device_IP = $Device_IP;
    }



    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->Name;
    }

    /**
     * @param string|null $Name
     */
    public function setName(?string $Name): void
    {
        $this->Name = $Name;
    }


    /**
     * @throws Exception
     */
    public function SendPasswordResetEmail()
    {
        $email = Application::$app->email;
        $email->setTo('stdinushan@gmail.com');
        $email->setFrom('bdms@gmail.com');
        $email->setSubject('Password Reset');
        $email->AddImage(Application::$ROOT_DIR.'/public/images/logo.png','logo-img','Logo');
            ob_start();
            include_once Application::$ROOT_DIR."/app/view/Email/PasswordReset.php";
            $body=ob_get_clean();
        $body=str_replace('{{Link}}','http://localhost:5000/resetPassword?token=' . $this->Token,$body);
        $body=str_replace('{{UserName}}',$this->Name,$body);
        $email->setBody($body);
        $email->send();

    }

    public function labels(): array
    {
        return [
            'UID'=>'User ID',
            'email'=>'Email',
            'token'=>'Token',
            'created_at'=>'Created At',
            'Status'=>'Status',
        ];
    }

    public function rules(): array
    {
        return [
            'UID'=>[self::RULE_REQUIRED,self::RULE_UNIQUE],
            'email'=>[self::RULE_REQUIRED,self::RULE_EMAIL,self::RULE_UNIQUE],
            'token'=>[self::RULE_REQUIRED,self::RULE_UNIQUE],
            'created_at'=>[self::RULE_REQUIRED],
            'Status'=>[self::RULE_REQUIRED],
            'Device_IP'=>[self::RULE_REQUIRED],
        ];
    }

    public static function getTableShort(): string
    {
        return 'password_reset';
    }

    public static function tableName(): string
    {
        return 'Password_Reset';
    }

    public static function PrimaryKey(): string
    {
        return 'UID';
    }

    public function attributes(): array
    {
        return ['UID','Email','Token','Created_at','Status','Device_IP'];
    }

    /**
     * @return string
     */
    public function getUID(): string
    {
        return $this->UID;
    }

    /**
     * @param string $UID
     */
    public function setUID(string $UID): void
    {
        $this->UID = $UID;
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
     * @return string
     */
    public function getToken(): string
    {
        return $this->Token;
    }

    /**
     * @param string $Token
     */
    public function setToken(string $Token): void
    {
        $this->Token = $Token;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->Created_at;
    }

    /**
     * @param string $Created_at
     */
    public function setCreatedAt(string $Created_at): void
    {
        $this->Created_at = $Created_at;
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
     * @return string|null
     */
    public function getResetPasswordAt(): ?string
    {
        return $this->ResetPassword_At;
    }

    /**
     * @param string|null $ResetPassword_At
     */
    public function setResetPasswordAt(?string $ResetPassword_At): void
    {
        $this->ResetPassword_At = $ResetPassword_At;
    }


}